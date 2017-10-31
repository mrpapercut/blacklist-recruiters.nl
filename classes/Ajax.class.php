<?php

class Ajax {

    public $db;
    public $template;
    private $reports;
    private $companies;
    private $util;

    public function getRequest($request, $data = null) {

        if(is_callable(array($this, $request))){
            if(!is_null($data)){
                $response = call_user_func(array($this, $request), $data);
            } else {
                $response = call_user_func(array($this, $request));
            }
        } else {
            $response = $this->getDefault($data);
        }

        die($response);
    }

    public function getReports($id) {
        if (!$this->reports) $this->reports = new Reports();
        return $this->reports->handleRequest($id);
    }

    public function getSubmitForm() {
        if (!$this->template) $this->template = new Template();
        if (!$this->companies) $this->companies = new Companies();

        $companylist = $this->companies->getAllCompanies();
        return $this->template->getTemplate('content-submit', $companylist);
    }

    public function getCompanies($id = null) {
        if (!$this->companies) $this->companies = new Companies();
        return $this->companies->handleRequest($id);
    }

    public function getFAQ() {
        if (!$this->template) $this->template = new Template();
        return $this->template->getTemplate('content-faq');
    }

    public function postReport($data) {
        if (!$this->reports) $this->reports = new Reports();
        return $this->reports->postReport($data);
    }

    public function getDefault() {
        return $this->getReports();
    }

    public function allowReport($token) {
        if (!$this->reports) $this->reports = new Reports();

        if ($reportid = $this->reports->allowReport($token)) {
            return $this->getReports($reportid);
        }
    }
}
