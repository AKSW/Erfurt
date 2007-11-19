<?php
// TODO remove hardcoded path
define('ERFURT_BASE', '/Users/philipp/Sites/erfurt_doc_it/');
define('RDFAPI_INCLUDE_DIR', ERFURT_BASE . 'api/Erfurt/lib/rdfapi-php/');

$include_path  = get_include_path() . PATH_SEPARATOR;
$include_path .= ERFURT_BASE . 'api/' . PATH_SEPARATOR;
$include_path .= ERFURT_BASE . 'api/Erfurt/lib/' . PATH_SEPARATOR;
$include_path .= ERFURT_BASE . 'test/' . PATH_SEPARATOR;
set_include_path($include_path);

// overwrite if it does not exists; needed for autodiscovering missing classes
if (!function_exists('__autoload')) {
	function __autoload($class) {
		$file = str_replace('_', DIRECTORY_SEPARATOR, substr($class, 0)) . '.php';
		require_once($file);
	}
}

// include rap lib
require_once(RDFAPI_INCLUDE_DIR.'RdfAPI.php');
require_once(RDFAPI_INCLUDE_DIR.'model/DbModel.php');

require_once 'Erfurt/Rdfs/rap/model.php';
require_once 'Erfurt/Rdfs/rap/resource.php';
require_once 'Erfurt/functions.php';

// test classes
require_once 'PHPUnit/Framework/TestCase.php';

Zend_Registry::set('config', new Erfurt_Config(array('/Users/philipp/Sites/erfurt_doc_it/api/Erfurt/erfurt.ini'), 'erfurt'));


require_once('Erfurt/constants.php');

//echo $include_path;
?>
