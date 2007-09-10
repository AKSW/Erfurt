<?php
error_reporting(E_STRICT);
$debug=1;

date_default_timezone_set('Europe/Berlin');
$start = explode(' ',microtime());
require_once 'manchester.php';	
$x='';
for ($i=1; $i < $argc; $i++) { 
	$x.=$argv[$i].' ';
}
//echo $x."\n";
$o= new OWLParser();
$o->parseString($x);
$end =  explode(' ',microtime() );
if($debug)echo "\nparsed in " . ($end[0]+$end[1]-($start[0]+$start[1])). "\n";
?>