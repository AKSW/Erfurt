<?php
/**
 * In order to use the Erfurt Semantic Web Framework just include this file and define the EF_LOCATION_RAP constant.
 * This should look something like this: define('EF_LOCATION_RAP', '/path/to/rap/')
 *
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright
 * @license 
 * @version $Id: $
 */

//apd_set_pprof_trace();
/*************************************************************************************************************/



/******************************************************************************
* includes                                                                   *
******************************************************************************/
# basepath
define('ERFURT_BASE', str_replace('\\', '/', dirname(__FILE__)) . '/');

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


/******************************************************************************
* CONSTANTS                                                                   *
******************************************************************************/
// TODO use a vocabulary adapter in order to have a cleaner file and not so much constants

// some namespace definitions
define('EF_XML_NS', 'http://www.w3.org/XML/1998/namespace');
define('EF_XSD_NS', 'http://www.w3.org/2001/XMLSchema#');
define('EF_RDF_NS', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
define('EF_RDFS_NS', 'http://www.w3.org/2000/01/rdf-schema#');
define('EF_OWL_NS', 'http://www.w3.org/2002/07/owl#');
	
define('EF_OWL_IMPORTS', EF_OWL_NS.'imports');
define('EF_OWL_ONTOLOGY', EF_OWL_NS.'Ontology');
define('EF_OWL_SAMEAS', EF_OWL_NS.'sameAs');
define('EF_OWL_DIFFERENTFROM', EF_OWL_NS.'differentFrom');
define('EF_OWL_CARDINALITY', EF_OWL_NS.'cardinality');
define('EF_OWL_MINCARDINALITY', EF_OWL_NS.'minCardinality');
define('EF_OWL_MAXCARDINALITY', EF_OWL_NS.'maxCardinality');
define('EF_OWL_HASVALUE', EF_OWL_NS.'hasValue');
define('EF_OWL_SOMEVALUESFROM', EF_OWL_NS.'someValuesFrom');
define('EF_OWL_ALLVALUESFROM', EF_OWL_NS.'allValuesFrom');
define('EF_OWL_INTERSECTIONOF', EF_OWL_NS.'intersectionOf');
define('EF_OWL_EQUIVALENTCLASS', EF_OWL_NS.'equivalentClass');
define('EF_OWL_DISJOINTWITH', EF_OWL_NS.'disjointWith');
define('EF_OWL_CLASS', EF_OWL_NS.'Class');
define('EF_OWL_DEPRECATED_CLASS', EF_OWL_NS.'DeprecatedClass');
define('EF_OWL_ANNOTATION_PROPERTY', EF_OWL_NS.'AnnotationProperty');
define('EF_OWL_DATATYPE_PROPERTY', EF_OWL_NS.'DatatypeProperty');
define('EF_OWL_OBJECT_PROPERTY', EF_OWL_NS.'ObjectProperty');
define('EF_OWL_FUNCTIONAL_PROPERTY', EF_OWL_NS.'FunctionalProperty');
define('EF_OWL_INVERSEFUNCTIONAL_PROPERTY', EF_OWL_NS.'InverseFunctionalProperty');
define('EF_OWL_SYMMETRIC_PROPERTY', EF_OWL_NS.'SymmetricProperty');
define('EF_OWL_TRANSITIVE_PROPERTY', EF_OWL_NS.'TransitiveProperty');
define('EF_OWL_DEPRECATED_PROPERTY', EF_OWL_NS.'DeprecatedProperty');
define('EF_OWL_RESTRICTION', EF_OWL_NS.'Restriction');
define('EF_OWL_ONEOF', EF_OWL_NS.'oneOf');
	
define('EF_RDF_TYPE', EF_RDF_NS.'type');
define('EF_RDF_DESCRIPTION', EF_RDF_NS.'Description');
define('EF_RDF_ABOUT', EF_RDF_NS.'about');
define('EF_RDF_NIL', EF_RDF_NS.'nil');
define('EF_RDF_FIRST', EF_RDF_NS.'first');
define('EF_RDF_REST', EF_RDF_NS.'rest');
define('EF_RDF_PROPERTY', EF_RDF_NS.'Property');
	
define('EF_RDFS_COMMENT', EF_RDFS_NS.'comment');
define('EF_RDFS_LABEL', EF_RDFS_NS.'label');
define('EF_RDFS_SUBCLASSOF', EF_RDFS_NS.'subClassOf');
define('EF_RDFS_DATATYPE', EF_RDFS_NS.'Datatype');
define('EF_RDFS_CLASS', EF_RDFS_NS.'Class');
	
define('EF_XSD_STRING', EF_XSD_NS.'string');
	
define('EF_BNODE_PREFIX', 'bNode');

define('EF_SERIALIZER_AD', 'Generated by Erfurt Semantic Web Framework - http://sourceforge.net/projects/powl');
?>
