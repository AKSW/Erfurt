<html>
<body>
<form action="starter.php" method="post">String to parse: <input
	type="text" name="manchesterstring" /> <input type="submit" /></form>
<?php


error_reporting(E_STRICT);
$debug=1;

date_default_timezone_set('Europe/Berlin');
$start = explode(' ',microtime());
require_once 'Parser.php';
$x='';
for ($i=1; $i < $argc; $i++) {
	$x.=$argv[$i].' ';
}
if(!$_POST["manchesterstring"]=="" || !$x=="" ){
	echo"you entered: ".($_POST["manchesterstring"]!=""?$_POST["manchesterstring"]:$x)."<br />";
	$o= new ManchesterParser();
	echo "output string = " . "<br />";
	$o->parseString($_POST["manchesterstring"]!=""?$_POST["manchesterstring"]:$x);

	$end =  explode(' ',microtime() );
	if($debug){
		echo "<br />\nparsed in ";
		print_r ($end[0]-$start[0]);
		echo "s ";
	}
}

?>

</body>
</html>
