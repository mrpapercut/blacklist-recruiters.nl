<?php

$host = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$prot = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on' ? 'https' : 'http';
$base = $prot.'://'.$host.$path.'/';

define('BASE_URL',          $base);

// Database
define('DB_HOST',           'localhost');
define('DB_USER',           'root');
define('DB_PASS',           '');
define('DB_DATABASE',       'blacklist_recruiters');

// Email addresses
define('ADMIN_EMAIL',       '');
define('SITE_EMAIL',        '');

// Strings
define('EMAIL_SUBJECT',     'Nieuwe melding voor "%s" op blacklist-recruiters.nl');
define('EMAIL_BODY',        'Door %s:');

// URLs
define('URL_REPORTS',       'meldingen');
define('URL_COMPANIES',     'bedrijven');
define('URL_SUBMIT',        'maakmelding');
define('URL_FAQ',           'faq');
define('URL_ALLOWREPORT',   'allowreport');

// Misc details
define('ADMIN_IP',          '');
define('DISQUS_SHORTNAME',  '');
