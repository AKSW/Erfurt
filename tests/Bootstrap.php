<?php

require_once 'vendor/autoload.php';

/*
 * Set error reporting to the level to which Erfurt code must comply.
 */
error_reporting(E_ALL | E_STRICT);

/*
 * Default timezone in order to prevent warnings
 */
date_default_timezone_set('Europe/Berlin');

if (!defined('_TESTROOT')) {
    define('_TESTROOT', rtrim(dirname(__FILE__), '\\/') . '/');
}
