<?php

/**
 * Erfurt test base file
 *
 * Sets the same include paths as OntoWik uses and must be included
 * by all tests.
 *
 * @author     Norman Heino <norman.heino@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */

// path to tests
define('_TESTROOT', rtrim(dirname(__FILE__), '\\/') . '/');

// path to OntoWiki
define('_BASE', rtrim(realpath(_TESTROOT . '../src'), '\\/') . '/');

// add libraries to include path
$includePath  = get_include_path() . PATH_SEPARATOR;
$includePath .= _TESTROOT          . PATH_SEPARATOR;
$includePath .= _BASE              . PATH_SEPARATOR;
set_include_path($includePath);

// start dummy session before any PHPUnit output
// require_once 'Zend/Session/Namespace.php';
// $session = new Zend_Session_Namespace('OntoWiki_Test');

require_once 'Erfurt/App.php';
$erfurt = Erfurt_App::start();
$erfurt->authenticate();

// PHPUnit
require_once 'PHPUnit/Framework.php';
