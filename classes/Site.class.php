<?php

class Site {

    public $template;
    public $ajax;

    static function autoloader($class) {
        require_once('classes/'.$class.'.class.php');
    }

    public function __construct() {
        require_once('inc/definitions.inc.php');

        spl_autoload_register('Site::autoloader');

        if (isset($_POST['ajax']) && $_POST['ajax'] == true && isset($_POST['request'])) {
            $this->ajax = new Ajax();
            die($this->ajax->getRequest($_POST['request'], $_POST['data']));
        }
    }

    public function getPage() {
        $this->template = new Template();

        $allowed = array(URL_REPORTS, URL_COMPANIES, URL_SUBMIT, URL_FAQ, URL_ALLOWREPORT);

        $this->template->getTemplate('header');

        if (isset($_GET['cat']) && in_array($_GET['cat'], $allowed)) {
            $id = (isset($_GET['id'])) ? $_GET['id'] : null;

            $this->getContentByCategory($_GET['cat'], $id);
        } else {
            $this->getContentByCategory(URL_REPORTS, '');
        }

        $this->template->getTemplate('footer');
    }

    private function getContentByCategory($category, $id) {
        if (!$this->ajax) $this->ajax = new Ajax();

        $mapping = array(
            URL_REPORTS     => 'getReports',
            URL_COMPANIES   => 'getCompanies',
            URL_SUBMIT      => 'getSubmitForm',
            URL_FAQ         => 'getFaq',
            URL_ALLOWREPORT => 'allowReport'
        );

        if (isset($mapping[$category]) && is_callable(array($this->ajax, $mapping[$category]))) {
            if (!is_null($id)) {
                return call_user_func(array($this->ajax, $mapping[$category]), $id);
            } else {
                return call_user_func(array($this->ajax, $mapping[$category]));
            }
        }
    }
}
