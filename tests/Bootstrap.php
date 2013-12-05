<?php
/*
 * Set error reporting to the level to which Erfurt code must comply.
 */
error_reporting(E_ALL | E_STRICT);

/*
 * Default timezone in order to prevent warnings
 */ 
date_default_timezone_set('Europe/Berlin');

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
set_include_path(implode(PATH_SEPARATOR, $path));
unset($efRoot, $efLibraryDir, $efUnitTestsDir, $efIntegrationTestsDir, $path);

/**
 * Setup autoloading
 */
require_once(__DIR__ . '/../vendor/autoload.php');
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Erfurt_');

// TODO: can we remove this?
if (!defined('_TESTROOT')) {
    define('_TESTROOT', rtrim(dirname(__FILE__), '\\/') . '/');
}

// Access Erfurt app for constant loading etc.
Erfurt_App::getInstance(false);
