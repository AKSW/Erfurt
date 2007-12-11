<?php

/**
 * @version $Id$
 */


$time_start = microtime(true);

//$davsystem = "file";
$davsystem = "rdf";

if ($davsystem == "file") {
	require_once ("HTTP/WebDAV/Server/Filesystem.php");
	$WebDAV = new HTTP_WebDAV_Server_Filesystem();
}
else {
	require_once ("RDF.php");
	require_once ("config.inc.php");
	$WebDAV = new HTTP_WebDAV_Server_RDF($_WEBDAV);
}

$time_end = microtime(true);
$time = $time_end - $time_start;
syslog (LOG_INFO, "webdav debug: start Method $_SERVER[REQUEST_METHOD] after $time" );
$WebDAV->Serverequest();
?>
