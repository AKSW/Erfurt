<?php
define('ERFURT_TEST_CONFIG', '1');
define('ERFURT_TEST_CONFIG_BACKEND', 'rap');
define('ERFURT_TEST_CONFIG_DBTYPE', 'mysqli');
define('ERFURT_TEST_CONFIG_HOST', 'localhost');
define('ERFURT_TEST_CONFIG_DBNAME', 'erfurt_testbed');
define('ERFURT_TEST_CONFIG_USER', 'powl');
define('ERFURT_TEST_CONFIG_PW', 'powl');


define('ERFURT_BASE', str_replace('\\', '/', dirname(__FILE__)).'/../api/Erfurt/');
define('ERFURT_TEST_BASE', str_replace('\\', '/', dirname(__FILE__)).'/');
define('RDFAPI_INCLUDE_DIR', ERFURT_BASE . 'lib/rdfapi-php/');



$include_path  = get_include_path() . PATH_SEPARATOR;
$include_path .= ERFURT_BASE . '../' . PATH_SEPARATOR;
$include_path .= ERFURT_BASE . 'lib/' . PATH_SEPARATOR;
$include_path .= ERFURT_BASE . '../../test/' . PATH_SEPARATOR;
set_include_path($include_path);

// overwrite if it does not exists; needed for autodiscovering missing classes
if (!function_exists('__autoload')) {
	function __autoload($class) {
		$file = str_replace('_', DIRECTORY_SEPARATOR, substr($class, 0)) . '.php';
		require_once($file);
	}
}

require_once('Erfurt/constants.php');
$GLOBALS['RAP']['conf']['database']['tblStatements'] = 'statements';

// include rap lib
require_once(RDFAPI_INCLUDE_DIR . 'RdfAPI.php');
require_once(RDFAPI_INCLUDE_DIR . 'model/DbModel.php');
require_once(RDFAPI_INCLUDE_DIR . 'model/DbStore.php');
require_once(RDFAPI_INCLUDE_DIR . 'dataset/DatasetP.php');
require_once(RDFAPI_INCLUDE_DIR . 'sparql/SPARQL.php');

require_once 'Erfurt/Rdfs/rap/model.php';
require_once 'Erfurt/Rdfs/rap/resource.php';
require_once 'Erfurt/functions.php';
require_once 'Erfurt/Rdfs/rap/class.php';

$config = new Erfurt_Config(array('/Users/philipp/Sites/erfurt_doc_it/api/Erfurt/erfurt.ini'), 'erfurt');
Zend_Registry::set('config', $config);

$writer = new Zend_Log_Writer_Null();
$erfurtLog = new Zend_Log($writer);
Zend_Registry::set('erfurtLog', $erfurtLog);

Zend_Registry::set('erfurt', new Erfurt_App_Default($config));


switch (ERFURT_TEST_CONFIG_BACKEND) {
	case 'rap':
		$store = new Erfurt_Store_Adapter_Rap(ERFURT_TEST_CONFIG_DBTYPE, ERFURT_TEST_CONFIG_HOST, 				
					ERFURT_TEST_CONFIG_DBNAME, ERFURT_TEST_CONFIG_USER, ERFURT_TEST_CONFIG_PW);
		break;
	case 'virtuoso':
		$store = new Erfurt_Store_Adapter_Virtuoso(ERFURT_TEST_CONFIG_DBTYPE, ERFURT_TEST_CONFIG_HOST, 				
					ERFURT_TEST_CONFIG_DBNAME, ERFURT_TEST_CONFIG_USER, ERFURT_TEST_CONFIG_PW);
		break;
	case 'oracle':
		$store = new Erfurt_Store_Adapter_Oracle(ERFURT_TEST_CONFIG_DBTYPE, ERFURT_TEST_CONFIG_HOST, 				
					ERFURT_TEST_CONFIG_DBNAME, ERFURT_TEST_CONFIG_USER, ERFURT_TEST_CONFIG_PW);
		break;
	default:
		$store = new Erfurt_Store_Adapter_Rap(ERFURT_TEST_CONFIG_DBTYPE, ERFURT_TEST_CONFIG_HOST, 				
					ERFURT_TEST_CONFIG_DBNAME, ERFURT_TEST_CONFIG_USER, ERFURT_TEST_CONFIG_PW);
}
Zend_Registry::set('store', $store);
?>
