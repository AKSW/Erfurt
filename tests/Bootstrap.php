<?php
define('EF_TEST_CONFIG_SKIP_DB_TESTS', false);

/*
 * Set error reporting to the level to which Erfurt code must comply.
 */
error_reporting(E_ALL | E_STRICT);

/*
 * Check for minimum supported PHPUnit version
 */
$phpUnitVersion = PHPUnit_Runner_Version::id();
if ('@package_version@' !== $phpUnitVersion && version_compare($phpUnitVersion, '3.5.0', '<')) {
    echo 'This version of PHPUnit (' . PHPUnit_Runner_Version::id() . ') is not supported in Erfurt unit tests.' . PHP_EOL;
    exit(1);
}
unset($phpUnitVersion);

/*
 * Determine the root, library, and tests directories of Erfurt.
 */
$efRoot                = realpath(dirname(__DIR__));
$efLibraryDir          = "$efRoot/library";
$efUnitTestsDir        = "$efRoot/tests/unit";
$efIntegrationTestsDir = "$efRoot/tests/integration";

// Check for Zend... if we can find it in some standard directories, we add it. Otherwise
// we assume, that it is already in the include_path
$zfDir = null;
if (is_dir("$efLibraryDir/Zend")) {
    $zfDir = null; // Already in include path!
} else if (is_dir(realpath(dirname(dirname(__DIR__)).'/Zend'))) {
    $zfDir = realpath(dirname(dirname(__DIR__)));
}

/*
 * Prepend the Erfurt class base directory, libraries/ and tests/ directories to the
 * include_path. This allows the tests to run out of the box and helps prevent
 * loading other copies of the Erfurt code and tests that would supersede
 * this copy.
 */
$path = array(
    $efLibraryDir,
    $efUnitTestsDir,
    $efIntegrationTestsDir,
    get_include_path(),
);
if (null !== $zfDir) {
    $path = array(
        $zfDir,
        $efLibraryDir,
        $efUnitTestsDir,
        $efIntegrationTestsDir,
        get_include_path(),
    );
}
set_include_path(implode(PATH_SEPARATOR, $path));
unset($efRoot, $efLibraryDir, $efUnitTestsDir, $efIntegrationTestsDir, $path);

/**
 * Setup autoloading
 */
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Erfurt_');

// TODO: can we remove this?
if (!defined('_TESTROOT')) {
    define('_TESTROOT', rtrim(dirname(__FILE__), '\\/') . '/');
}



// define('_BASE', rtrim(realpath(_TESTROOT . '../'), '\\/') . '/');
// 
// // add Erfurt lib to include path
// $includePath  = get_include_path()          . PATH_SEPARATOR;
// $includePath .= _BASE                       . PATH_SEPARATOR;
// $includePath .= _BASE . 'Erfurt/libraries/' . PATH_SEPARATOR;
// $includePath .= _BASE . 'Erfurt/libraries/antlr/Php' . PATH_SEPARATOR;
// $includePath .= _BASE . '../' . PATH_SEPARATOR;
// set_include_path($includePath);
// 
// // We need a session for authentication
// require_once 'Zend/Session/Namespace.php';
// $session = new Zend_Session_Namespace('Erfurt_Test');
// 
// 

