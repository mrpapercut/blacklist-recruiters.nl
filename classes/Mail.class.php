<?php

class Mail {

	private $util;

	public function mailAdmin($name, $report, $company, $insertid) {
		if (!$this->util) $this->util = new Util();

		$mailtoken = $this->util->getMailToken($insertid);

		$to = ADMIN_EMAIL;
        $subject = sprintf(EMAIL_SUBJECT, $company);
		$headers = implode("\r\n", array(
            'From: '.SITE_EMAIL,
            'Reply-To: '.SITE_EMAIL,
            'X-Mailer: PHP/'.phpversion()
        ));

		// mail($to, $subject, $this->getReportTemplate($name, $report, $mailtoken), $headers);

		return $mailtoken;
	}

	private function getReportTemplate($name, $report, $mailtoken) {
		$from = sprintf(EMAIL_BODY, $name);
		$approveUrl = BASE_URL.URL_ALLOWREPORT.'/'.$mailtoken;

		return implode("\n\n", array($from, $report, $approveUrl));
	}
}
