<?php

class Companies {

    private $db;
    private $template;
    private $reports;

    public function handleRequest($id) {
        if (!$this->template) $this->template = new Template();
        if (!$this->reports) $this->reports = new Reports();

        if (is_null($id) || $id === '' || !preg_match('/^[0-9]+$/', $id)) {
            $companylist = $this->getAllCompanies();

            for ($i = 0; $i < count($companylist); $i++) {
                $companylist[$i]['reportcount'] = $this->reports->countReportsByCompany($companylist[$i]['id'])[0]['count'];
            }

            return $this->template->getTemplate('content-companies', $companylist);

        } elseif (preg_match('/^[0-9]+$/', $id)) {
            $company = $this->getCompanyById((int) $id);
            if ($company[0]['allowed'] !== 1) return $this->template->get404();

            $content['companyname'] = $company[0]['companyname'];

            $reports = $this->reports->getReportsByCompany($company[0]['companyname']);
            $content['reports'] = is_array($reports) ? $reports : array();

            return $this->template->getTemplate('content-company', $content);

        } else {
            return $this->template->get404();
        }
    }

    public function getAllCompanies($forceReportless = false, $forceAll = false) {
        if (!$this->db) $this->db = new Db();

        return $this->db->getCompanies();
    }

    public function getCompanyById($id) {
        if (!$this->db) $this->db = new Db();

        return $this->db->getCompanyById($id);
    }
}
