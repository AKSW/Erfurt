<?php

require_once '../erfurt.php';

$WebDAV = new Erfurt_WebDAV_Server_Default($config);

$WebDAV->Serverequest();

?>