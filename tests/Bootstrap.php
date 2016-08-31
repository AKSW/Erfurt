<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


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

// force vocabulary loading
Erfurt_App::getInstance(false);