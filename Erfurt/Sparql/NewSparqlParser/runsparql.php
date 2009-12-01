<?php
error_reporting(E_ALL);
// ini_set("memory_limit","1G");

require_once './runtime/Php/antlr.php';
require_once 'Iri.php';
require_once 'TestParser.php';

// #
// # usage: php runsparql.php input
// #
// 
//$input = new ANTLRFileStream(dirname(__FILE__).DIRECTORY_SEPARATOR.$argv[1]);

$input = new ANTLRFileStream(dirname(__FILE__).DIRECTORY_SEPARATOR."input");
$lexer = new Iri($input);
// $lexer = new CommonLexer($input);
$tokens = new CommonTokenStream($lexer);

foreach ($tokens->getTokens() as $t) {
//		echo $t."\n";
}

$parser = new TestParser($tokens);
$parser->query();

?>
