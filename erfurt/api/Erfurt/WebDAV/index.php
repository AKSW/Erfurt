<?php

require_once '../erfurt.php';

$davsystem = "rdf";

if ($davsystem == "file") {
	require_once ("HTTP/WebDAV/Server/Filesystem.php");
	$WebDAV = new HTTP_WebDAV_Server_Filesystem(); 
}
else
{
	require_once ("RDF.php");
	require_once ("config.inc.php");
	$_WEBDAV['erfurt_config'] = $config;
	$WebDAV = new HTTP_WebDAV_Server_RDF($_WEBDAV);
}

$WebDAV->Serverequest();

?>