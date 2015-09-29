<?php

require_once '../vendor/autoload.php';

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

// TODO: can we remove this?
if (!defined('_TESTROOT')) {
    define('_TESTROOT', rtrim(dirname(__FILE__), '\\/') . '/');
}

// Access Erfurt app for constant loading etc.
Erfurt_App::getInstance(false);
