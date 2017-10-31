<?php

class Reports {

	private $db;
	private $template;
	private $util;
	private $mail;
	private $companies;

	public function handleRequest($id) {
		if (!$this->template) $this->template = new Template();

		if (is_null($id) || $id === '' || !preg_match('/^[0-9]+$/', $id)) {
			// No valid id found, return all reports
			$reportlist = $this->getAllReports();

			if (is_array($reportlist)) {
				$this->util = new Util();

				for ($i = 0; $i < count($reportlist); $i++) {
					$reportlist[$i]['report'] = $this->util->truncateText(strip_tags($reportlist[$i]['report']));
				}
			}

			return $this->template->getTemplate('content-reports', $reportlist);

		} elseif (preg_match('/^[0-9]+$/', $id)) {
			// ID found, return report by ID
			return $this->getReport($id);
		} else {
			// Invalid ID found
			$this->template = new Template();
			return $this->template->get404();
		}
	}

	public function getAllReports() {
		if (!$this->db) $this->db = new Db();

		return $this->db->getAllReports();
	}

	public function getReport($id) {
		if (!$this->template) $this->template = new Template();

		$report = $this->getReportById($id);

		if (!is_array($report) || (is_array($report) && count($report) < 1)) {
			return $this->template->get404();
		} else {
			$content = array();

			$content['report'] = $report[0];
			$content['otherreports'] = $this->getReportsByCompany($content['report']['companyname'], $id);

			return $this->template->getTemplate('content-report', $content);
		}
	}

	public function getReportById($id) {
		if (!$this->db) $this->db = new Db();

		// To force admin to see all reports
		// TODO: Make this better
		$forceAllowed = ($_SERVER['REMOTE_ADDR'] === ADMIN_IP || $_SERVER['REMOTE_ADDR'] === '::1');

        $hash = isset($_SESSION) && isset($_SESSION['hash']) ? $_SESSION['hash'] : 'dfssfd';

		return $this->db->getReportById($id, $hash, $forceAllowed);
	}

	public function getReportsByCompany($companyname, $excludeId = null) {
		if (!$this->db) $this->db = new Db();

		return $this->db->getReportsByCompany($companyname, $excludeId);
	}

	public function countReportsByCompany($companyId) {
		if (!$this->db) $this->db = new Db();

		return $this->db->countReportsByCompanyId($companyId);
	}

	public function postReport($data) {
		if (!$this->db) $this->db = new Db();
        if (!$this->util) $this->util = new Util();

		$companyid = null;
		$conn = $this->db->conn;
		$data = json_decode($data);

        $hash = $this->util->encrypt($_SERVER['REMOTE_ADDR']);
        // Store hash in Session
        if (!isset($_SESSION)) session_start();
        $_SESSION['hash'] = $hash;

        // If company doesn't exist, $data->company contains a company-name to add to the DB
		if ($data->addcompany) {
            $companyname = $conn->real_escape_string(strtolower($data->company));
            $companyid = $this->db->addCompany($companyname);
		}

		$name = $conn->real_escape_string($data->name);
		$company_id = $companyid ? $companyid : $conn->real_escape_string($data->company);
		$report = $conn->real_escape_string(strip_tags($data->report, '<br>'));

		if ($insertid = $this->db->addReport($name, $company_id, $report, $hash)) {
			$this->mail = new Mail();
			$this->companies = new Companies();

			$id = $companyid ? $companyid : $data->company;
			$company = $this->companies->getCompanyById($id);

			$mailtoken = $this->mail->mailAdmin($name, $report, ucwords($company[0]['companyname']), $insertid);

			if ($this->db->setMailToken($insertid, $mailtoken)) {
				return $insertid.'';
			}
		} else {
			return false;
		}
	}

	public function allowReport($token) {
		if (!$this->db) $this->db = new Db();

		$id = $this->db->getReportByMailtoken($this->db->conn->real_escape_string($token));

        if (!is_null($id) && $this->db->allowReport($id)) {
            return $id;
        }

		return false;
	}
}
