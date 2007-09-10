<?php

include '../../lib/PEAR/PHP/ParserGenerator.php';
$a=new PHP_ParserGenerator;
//$_SERVER['argv'] = array('lemon', '-s', 'Parser.y');
$_SERVER['argv'] = array('lemon', '-s', './manchester.y');
$a->main();
?>
