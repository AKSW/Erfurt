<?php
define(EF_TEST_CONFIG_SKIP_DB_TESTS, false);

define('_TESTROOT', rtrim(dirname(__FILE__), '\\/') . '/');
define('_BASE', rtrim(realpath(_TESTROOT . '../src'), '\\/') . '/');

// add Erfurt lib to include path
$includePath  = get_include_path()          . PATH_SEPARATOR;
$includePath .= _BASE                       . PATH_SEPARATOR;
$includePath .= _BASE . 'Erfurt/libraries/' . PATH_SEPARATOR;
set_include_path($includePath);

// We need a session for authentication
require_once 'Zend/Session/Namespace.php';
$session = new Zend_Session_Namespace('Erfurt_Test');