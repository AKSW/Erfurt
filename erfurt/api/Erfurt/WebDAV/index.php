<?php

/**
 * @version $Id$
 */

define('REAL_BASE', str_replace('lib/Erfurt/WebDAV/', '', str_replace('\\', '/', dirname(__FILE__)) . '/'));

$include_path  = get_include_path() . PATH_SEPARATOR;
$include_path .= REAL_BASE . 'lib/Erfurt/lib/PEAR/' . PATH_SEPARATOR;
set_include_path($include_path);

//$davsystem = "file";
$davsystem = "rdf";

if ($davsystem == "file") {
	require_once ("HTTP/WebDAV/Server/Filesystem.php");
	$WebDAV = new HTTP_WebDAV_Server_Filesystem();
}
else {
	require_once '../erfurt.php';
	require_once ("RDF.php");
	//require_once ("config.inc.php");
	$WebDAV = new HTTP_WebDAV_Server_RDF($_WEBDAV,new Erfurt_App_Default($config));
}

$WebDAV->Serverequest();

?>
