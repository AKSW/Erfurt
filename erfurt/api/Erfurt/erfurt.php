<?php
/**
 * In order to use the Erfurt Semantic Web Framework just include this file and define the EF_LOCATION_RAP constant.
 * This should look something like this: define('EF_LOCATION_RAP', '/path/to/rap/')
 *
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright
 * @license 
 * @version $Id$
 */

//apd_set_pprof_trace();
/*************************************************************************************************************/



/******************************************************************************
* includes                                                                   *
******************************************************************************/
# basepath
define('ERFURT_BASE', str_replace('\\', '/', dirname(__FILE__)) . '/');
define('ERFURT_MIN_PHP_VERSION', '5.2.0');

if (!version_compare(phpversion(), ERFURT_MIN_PHP_VERSION, '>=')) {
	throw new Erfurt_Exception('Erfurt requires at least PHP Version ' . ERFURT_MIN_PHP_VERSION, 2001);
	exit();
}

// set include path to lib/
$include_path  = get_include_path() . PATH_SEPARATOR;
$include_path .= ERFURT_BASE . PATH_SEPARATOR;
$include_path .= ERFURT_BASE . 'lib/' . PATH_SEPARATOR;
set_include_path($include_path);

// overwrite if it does not exists; needed for autodiscovering missing classes
if (!function_exists('__autoload')) {
	function __autoload($class) {
		// try Erfurt dir
		if (file_exists($file = ERFURT_BASE . str_replace('_', DIRECTORY_SEPARATOR, substr($class, 7)) . '.php')) {
			require_once($file);
		// try lib
		} elseif (file_exists($file = ERFURT_BASE . 'lib/' . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php')) {
			require_once($file);
		} else {
			// throw new Erfurt_Exception('Class ' . $class . ' not found.');
		}
	}
}

# LOGGER
$logDir = ERFURT_BASE . 'log/';
if (is_writable($logDir)) {
	$writer = new Zend_Log_Writer_Stream($logDir . 'erfurt.log');
	$erfurtLog = new Zend_Log($writer);
} else {
	$writer = new Zend_Log_Writer_Null();
	$erfurtLog = new Zend_Log($writer);
}
Zend_Registry::set('erfurtLog', $erfurtLog);
$erfurtLog->info('Erfurt-Start: ' . @date('d.m.Y H:i:s'));


# config
$section = 'erfurt';
$iniFiles = array(ERFURT_BASE . 'erfurt.ini');
if (Zend_Registry::isRegistered('config')) {
	if (isset(Zend_Registry::get('config')->iniFiles)) {
		$iniFiles = array_merge($iniFiles, Zend_Registry::get('config')->iniFiles->toArray());
		$section = Zend_Registry::get('config')->iniSection;
	}
}
$config = new Erfurt_Config($iniFiles, $section, true);
Zend_Registry::set('config', $config);


### TAKEN FROM include.php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('max_execution_time','6000');
ini_set('allow_call_time_pass_reference','1');


# define constances 
define('POWLAPI_INCLUDE_DIR', 	ERFURT_BASE.'lib/powlapi/');
#define('OWLAPI_INCLUDE_DIR', 		ERFURT_BASE.'lib/owlapi/');
define('RDFSAPI_INCLUDE_DIR', 	ERFURT_BASE.'Rdfs/');
define('RDFAPI_INCLUDE_DIR', 		ERFURT_BASE.'lib/rdfapi-php/');

define('RDF_BACKEND_INCLUDE_DIR', RDFSAPI_INCLUDE_DIR . ($config->database->backend ? $config->database->backend : 'rap') . '/');

define('WIDGETS_INCLUDE_DIR', ERFURT_BASE.'lib/plugins/widgets/');

## HACK FOR OLD GLOBAL FUNCTIONS
require_once(ERFURT_BASE.'functions.php');

// load classes and functions common to all POWL modules
### TAKEN FROM powlapi/include.php ####
	
// load OWLAPI
### TAGEN FROM owlapi/owlapi.php ####

// load RDFSAPI
### TAGEN FROM rdfsapi/rdfsapi.php ####
define('RDFSAPI_ERROR', 'RDFSAPI error ');

// configure RAP constants
define("HIDE_ADVERTISE",true);
#define("USE_CDATA", true);
define('SER_SORT_MODEL', true);
//define('UNIC_RDF', true);
define("VALIDATE_IDS", false);
#define("SER_RDF_QNAMES",false);
define('BNODE_PREFIX','node');
#define('INDENTATION'," ");


// include rap lib
require_once(RDFAPI_INCLUDE_DIR.'RdfAPI.php');
require_once(RDFAPI_INCLUDE_DIR.PACKAGE_DBASE);
require_once(RDFAPI_INCLUDE_DIR.PACKAGE_VOCABULARY);
require_once(RDFAPI_INCLUDE_DIR.PACKAGE_SPARQL);
require_once(RDFAPI_INCLUDE_DIR.PACKAGE_DATASET);

// backend-specific classes from rdfs package (not yet auto-loadable)
require_once(RDF_BACKEND_INCLUDE_DIR.'model.php');
require_once(RDF_BACKEND_INCLUDE_DIR.'literal.php');
require_once(RDF_BACKEND_INCLUDE_DIR.'resource.php');
require_once(RDF_BACKEND_INCLUDE_DIR.'class.php');
require_once(RDF_BACKEND_INCLUDE_DIR.'property.php');
require_once(RDF_BACKEND_INCLUDE_DIR.'instance.php');
require_once(RDF_BACKEND_INCLUDE_DIR.'search.php');

$default_prefixes['owl']='http://www.w3.org/2002/07/owl#';
### END rdfsapi/rdfsapi.php ###


// Add vocabulary missing in rdfapi-php/api/vocabulary/owl.php
$OWL_equivalentClass=new Resource(OWL_NS."equivalentClass");
$OWL_equivalentProperty=new Resource(OWL_NS."equivalentProperty");
$OWL_Thing=new Resource(OWL_NS."Thing");
$OWL_Nothing=new Resource(OWL_NS."Nothing");
$OWL_AllDifferent=new Resource(OWL_NS."AllDifferent");
$OWL_distinctMembers=new Resource(OWL_NS."distinctMembers");

// HTML rendering related functions (header, footer)
require_once(POWLAPI_INCLUDE_DIR.'html.php');
require_once(POWLAPI_INCLUDE_DIR.'widget.php');


if (empty($config->erfurtUriBase)) {
	if (!empty($_SERVER['DOCUMENT_ROOT']) && ereg($_SERVER['DOCUMENT_ROOT'], ERFURT_BASE)) {
		$config->erfurtUriBase = str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/'), '', ERFURT_BASE);
	} else  {
		$config->erfurtUriBase = '/powl/';
	}
	$config->erfurtPublicUri =  $config->erfurtUriBase . 'public/';
}

$config->erfurtLibUri = $config->erfurtUriBase .'lib/';

// set paths and rewrite base
// TODO: test!!!
$urlBase = strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/'))) . 
		   '://' . $_SERVER['HTTP_HOST'] . ($_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '');
$scriptNameUnix = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$rewriteBase = substr($scriptNameUnix, 0, strrpos($scriptNameUnix, '/'));
$scriptFilenameUnix = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);

if (false !== stripos($scriptFilenameUnix, ERFURT_BASE)) {
	// we are inside Erfurt
	$postFix = str_ireplace(ERFURT_BASE, '', $scriptFilenameUnix);
	$config->erfurtUrlBase = $urlBase . str_replace($postFix, '', $scriptNameUnix);
} else {
	// we are outside Erfurt
	$fileSystemBase = substr($scriptFilenameUnix, 0, strrpos($scriptFilenameUnix, '/'));
	$prefixDir = str_ireplace($fileSystemBase, '', ERFURT_BASE);
	// we can assume PHP5, so str_ireplace should be available
	// if (function_exists('str_ireplace')) {
	// 	$prefixDir = str_ireplace($fileSystemBase, '', ERFURT_BASE);
	// } else {
	// 	$prefixDir = str_replace($fileSystemBase, '', ERFURT_BASE);
	// }
	$config->erfurtUrlBase = $urlBase . $rewriteBase . $prefixDir;
}

$config->erfurtPublicUrl = $config->erfurtUrlBase . $config->publicDir;

$datatypes = array(
	'http://www.w3.org/2001/XMLSchema#string'=>'String',
	'http://www.w3.org/2001/XMLSchema#boolean'=>'Boolean',
	'http://www.w3.org/2001/XMLSchema#decimal'=>'Decimal',
	'http://www.w3.org/2001/XMLSchema#integer'=>'&nbsp;&nbsp;Integer',
	'http://www.w3.org/2001/XMLSchema#nonNegativeInteger'=>'&nbsp;&nbsp;&nbsp;&nbsp;nonNegative',
	'http://www.w3.org/2001/XMLSchema#positiveInteger'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;positive',
	'http://www.w3.org/2001/XMLSchema#nonPositiveInteger'=>'&nbsp;&nbsp;&nbsp;&nbsp;nonPositive',
	'http://www.w3.org/2001/XMLSchema#negativeInteger'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;negative',
	'http://www.w3.org/2001/XMLSchema#long'=>'&nbsp;&nbsp;&nbsp;&nbsp;long',
	'http://www.w3.org/2001/XMLSchema#int'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;int',
	'http://www.w3.org/2001/XMLSchema#short'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;short',
	'http://www.w3.org/2001/XMLSchema#float'=>'Float',
	'http://www.w3.org/2001/XMLSchema#double'=>'Double',
	'http://www.w3.org/2001/XMLSchema#duration'=>'Duration',
	'http://www.w3.org/2001/XMLSchema#dateTime'=>'DateTime',
	'http://www.w3.org/2001/XMLSchema#time'=>'&nbsp;&nbsp;Time',
	'http://www.w3.org/2001/XMLSchema#date'=>'&nbsp;&nbsp;Date',
	'http://www.w3.org/2001/XMLSchema#gYearMonth'=>'&nbsp;&nbsp;gYearMonth',
	'http://www.w3.org/2001/XMLSchema#gYear'=>'&nbsp;&nbsp;gYear',
	'http://www.w3.org/2001/XMLSchema#gMonthDay'=>'&nbsp;&nbsp;gMonthDay',
	'http://www.w3.org/2001/XMLSchema#gDay'=>'&nbsp;&nbsp;gDay',
	'http://www.w3.org/2001/XMLSchema#gMonth'=>'&nbsp;&nbsp;gMonth',
	'http://www.w3.org/2001/XMLSchema#hexBinary'=>'HexBinary',
	'http://www.w3.org/2001/XMLSchema#base64Binary'=>'Base64Binary',
	'http://www.w3.org/2001/XMLSchema#anyURI'=>'AnyURI',
);
Zend_Registry::set('datatypes', $datatypes);
### END powlapi/include.php ###

// for debugging purposes
if($config ->debug === true)
	require_once(RDFAPI_INCLUDE_DIR.'util/adodb/adodb-errorhandler.inc.php');
	
// instantiate plug-in manager
$pluginManager = new Erfurt_Plugin_Manager();
// $pluginManager->addPluginDir(ERFURT_BASE . $config->pluginDir);
$pluginManager->addPluginDir(ERFURT_BASE . $config->widgetDir);
Zend_Registry::set('pluginManager', $pluginManager);

// load crucial widget classes to render user interface	 	 
include_once(WIDGETS_INCLUDE_DIR.'select.php');
include_once(WIDGETS_INCLUDE_DIR.'checkbox.php');
include_once(WIDGETS_INCLUDE_DIR.'text.php');
include_once(WIDGETS_INCLUDE_DIR.'textselect.php');
include_once(WIDGETS_INCLUDE_DIR.'node.php');
include_once(WIDGETS_INCLUDE_DIR.'file.php');

require_once('constants.php');
?>
