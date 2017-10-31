<?php

class Db {
    public $db;

    private $db_user;
    private $db_pass;
    private $db_database;

    public $conn;

    public function __construct(){

        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;
        $this->db_database = DB_DATABASE;
        $this->db_host = DB_HOST;

        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_database);
    }

    /* Reports */
    public function getAllReports() {
        $stmt = $this->conn->prepare("SELECT r.id, r.timestamp, r.company_id, r.name, r.report, c.companyname
            FROM reports AS r
            INNER JOIN companies AS c
            ON r.company_id = c.id
            WHERE r.allowed = 1
            ORDER BY timestamp DESC");

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($id, $timestamp, $company_id, $name, $report, $companyname);

        $out = array();

        while ($stmt->fetch()) {
            $out[] = array(
                'id' => $id,
                'timestamp' => $timestamp,
                'company_id' => $company_id,
                'name' => $name,
                'report' => $report,
                'companyname' => $companyname
            );
        }

        $stmt->close();

        return $out;
    }

    public function getReportById($id, $hash, $forceAllowed) {
        if ($forceAllowed !== true) {
            $stmt = $this->conn->prepare("SELECT r.id, r.allowed, r.company_id, r.name, r.timestamp, r.report, c.companyname
                FROM reports AS r
                INNER JOIN companies AS c
                ON r.company_id = c.id
                WHERE r.id = ? AND (r.allowed = 1 OR r.hash = ?)");

            $stmt->bind_param('is', $id, $hash);
        } else {
            $stmt = $this->conn->prepare("SELECT r.id, r.allowed, r.company_id, r.name, r.timestamp, r.report, c.companyname
                FROM reports AS r
                INNER JOIN companies AS c
                ON r.company_id = c.id
                WHERE r.id = ?");
            $stmt->bind_param('i', $id);
        }

       try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($id, $allowed, $company_id, $name, $timestamp, $report, $companyname);

        $out = array();

        while ($stmt->fetch()) {
            $out[] = array(
                'id' => $id,
                'allowed' => $allowed,
                'company_id' => $company_id,
                'name' => $name,
                'timestamp' => $timestamp,
                'report' => $report,
                'companyname' => $companyname
            );
        }

        $stmt->close();

        return $out;
    }

    public function getReportsByCompany($companyname, $excludeId) {
        if (is_null($excludeId)) $excludeId = 0;

        $stmt = $this->conn->prepare("SELECT r.id, r.timestamp
            FROM reports AS r
            INNER JOIN companies AS c
            ON r.company_id = c.id
            WHERE c.companyname = ?
            AND r.allowed = 1
            AND r.id != ?
            ORDER BY r.timestamp DESC");

        $stmt->bind_param('si', $companyname, $excludeId);

       try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($id, $timestamp);

        $out = array();

        while ($stmt->fetch()) {
            $out[] = array(
                'id' => $id,
                'timestamp' => $timestamp
            );
        }

        $stmt->close();

        return $out;
    }

    public function countReportsByCompanyId($companyId) {
        $stmt = $this->conn->prepare("SELECT COUNT(r.id) AS count
            FROM companies as c
            INNER JOIN reports AS r
            ON c.id = r.company_id
            WHERE r.allowed = 1
            AND c.allowed = 1
            AND c.id = ?");

        $stmt->bind_param('i', $companyId);

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($count);

        $out = array();

        while ($stmt->fetch()) {
            $out[] = array(
                'count' => $count
            );
        }

        $stmt->close();

        return $out;
    }

    public function addReport($name, $company_id, $report, $hash) {
        $stmt = $this->conn->prepare("INSERT INTO reports SET name = ?, company_id = ?, report = ?, allowed = 0, hash = ?, mailtoken = ''");
        $stmt->bind_param('siss', $name, $company_id, $report, $hash);

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }

            $id = $stmt->insert_id;

            if (!$id) {
                throw new Exception('Error: failed to retrieve reportid');
            }

            $stmt->close();

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $id;
    }

    public function setMailToken($insertid, $mailtoken) {
        $stmt = $this->conn->prepare("UPDATE reports SET mailtoken = ? WHERE id = ?");
        $stmt->bind_param('si', $mailtoken, $insertid);

       try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }

            $stmt->close();

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    public function getReportByMailToken($mailtoken) {
        $stmt = $this->conn->prepare("SELECT id FROM reports WHERE mailtoken = ?");
        $stmt->bind_param('s', $mailtoken);

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $stmt->store_result();
        $stmt->bind_result($id);

        $out = null;

        while ($stmt->fetch()) {
            $out = $id;
        }

        $stmt->close();

        return $out;
    }

    public function allowReport($id) {
        $stmt = $this->conn->prepare("UPDATE reports SET mailtoken = '', allowed = 1 WHERE id = ?");
        $stmt->bind_param('i', $id);

       try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }

            $stmt->close();

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    /* Companies */
    public function addCompany($companyname) {
        $stmt = $this->conn->prepare("INSERT INTO companies SET companyname = ?, allowed = 0");
        $stmt->bind_param('s', $companyname);

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }

            $id = $stmt->insert_id;

            if (!$id) {
                throw new Exception('Error: failed to retrieve companyid');
            }

            $stmt->close();

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $id;
    }

    public function getCompanies() {
        $stmt = $this->conn->prepare("SELECT DISTINCT c.id, c.companyname, c.allowed FROM companies AS c
            INNER JOIN reports AS r
            ON c.id = r.company_id
            WHERE c.allowed = 1
            AND r.allowed = 1
            ORDER BY companyname ASC");

        $stmt->bind_result($id, $companyname, $allowed);

        $out = array();

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        while ($stmt->fetch()) {
            $out[] = array(
                'id' => $id,
                'allowed' => $allowed,
                'companyname' => $companyname
            );
        }

        $stmt->close();

        return $out;
    }

    public function getCompanyById($id) {
        $stmt = $this->conn->prepare("SELECT companyname, allowed FROM companies WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->bind_result($companyname, $allowed);

        $out = array();

        try {
            if (!$stmt->execute()) {
                throw new Exception('Error: failed to execute query');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        while ($stmt->fetch()) {
            $out[] = array(
                'allowed' => $allowed,
                'companyname' => $companyname
            );
        }

        $stmt->close();

        return $out;
    }
}