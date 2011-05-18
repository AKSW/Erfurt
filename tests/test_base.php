<?php
define('EF_TEST_CONFIG_SKIP_DB_TESTS', false);

define('_TESTROOT', rtrim(dirname(__FILE__), '\\/') . '/');
define('_BASE', rtrim(realpath(_TESTROOT . '../'), '\\/') . '/');

// add Erfurt lib to include path
$includePath  = get_include_path()          . PATH_SEPARATOR;
$includePath .= _BASE                       . PATH_SEPARATOR;
$includePath .= _BASE . 'Erfurt/libraries/' . PATH_SEPARATOR;
$includePath .= _BASE . 'Erfurt/libraries/antlr/Php' . PATH_SEPARATOR;
$includePath .= _BASE . '../' . PATH_SEPARATOR;
set_include_path($includePath);

// We need a session for authentication
require_once 'Zend/Session/Namespace.php';
$session = new Zend_Session_Namespace('Erfurt_Test');


// Zend_Loader for class autoloading
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Erfurt_');
// $loader->suppressNotFoundWarnings(false);
