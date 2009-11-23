<?php
error_reporting(E_ALL);

require_once './runtime/Php/antlr.php';
require_once 'Iri.php';
require_once 'TestParser.php';

// require_once 'Simple_CommonLexer.php';
// require_once 'SimpleLexer.php';
// require_once 'SimpleParser.php';
// 
// #
// # usage: php Main.php input
// #
// 
//$input = new ANTLRFileStream(dirname(__FILE__).DIRECTORY_SEPARATOR.$argv[1]);
$input = new ANTLRFileStream(dirname(__FILE__).DIRECTORY_SEPARATOR."input");
$lexer = new Iri($input);
// $lexer = new CommonLexer($input);
$tokens = new CommonTokenStream($lexer);

foreach ($tokens->getTokens() as $t) {
		echo $t."\n";
}

$parser = new TestParser($tokens);
$parser->query();

?>
