<html>
<body>
<form action="starter.php" method="post">String to parse: <input
	type="text" name="manchesterstring" /> <input name="click" type="submit" />
<?php

/**
 * Test file for the Manchester OWL Syntax. Refer to readme file for more information.
 * 
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package syntax
 * @version $Id$
 */

error_reporting(E_STRICT);
$debug=1;

date_default_timezone_set('Europe/Berlin');
if($debug){
	$start = explode(' ',microtime());
	$start = $start[1] + $start[0];
}
require_once 'Parser.php';
$x='';
for ($i=1; $i < $argc; $i++) {
	$x.=$argv[$i].' ';
}
if(!$_POST["manchesterstring"]=="" || !$x=="" ){
	echo"you entered: ".($_POST["manchesterstring"]!=""?$_POST["manchesterstring"]:$x)."<br />";
	$o= new OWLParser();
	echo "output:" . "<br />";
	$o->parseString($_POST["manchesterstring"]!=""?$_POST["manchesterstring"]:$x);
}
if($debug){
	$end = explode( ' ', microtime());
	$end = $end[1] + $end[0];
	
	echo "<br />\nparsed in ";
	print_r("<input
		type=\"text\" name=\"timer\" value=\"");
	print_r ($end-$start);
	print_r("\"</>");
	echo " s";
}

?>
</form>
</body>
</html>
