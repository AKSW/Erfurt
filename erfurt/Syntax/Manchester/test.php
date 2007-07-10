<?php

include '/Applications/MAMP/bin/php5/lib/php/PHP/ParserGenerator.php';
$a=new PHP_ParserGenerator;
//$_SERVER['argv'] = array('lemon', '-s', 'Parser.y');
$_SERVER['argv'] = array('lemon', '-s', './manchester.y');
$a->main();

//$lexer_file='/Users/roll/Desktop/lex/lex.plex';
//$lex=file_get_contents($lexer_file);
//$parser = new parser($lex);
//while ($lex->yylex()) {
//    $parser->doParse($lex->token, $lex->value);
//}
//$this->parser->doParse(0, 0);
//require_once '/Applications/MAMP/bin/php5/lib/php/PHP/LexerGenerator.php';
//require_once './manchester.php';
//$rrr=new OWL_To_Erfurth_yyParser;
//$rrr->printTrace();

//$lexer1=new PHP_LexerGenerator($lexer_file);
//$lexer = new OWL_To_Erfurth_yyParser;
//while ($a->advance($parser)) {
//	$parser->doParse($lexer->token,$lexer->value);
//}
//$lexer->doParse(INTEGER,15);
//$lexer->doParse(0,0);
//$a->doParse(INTEGER,15);
//$a->doParse(PLUS,0);
//$a->doParse(INTEGER,1);
//$a->doParse(0,0);
//$a = new PHP_ParserGenerator;
//$_SERVER['argv'] = array('lemon', '-s', './manchester.y');
//$a->main();
?>
