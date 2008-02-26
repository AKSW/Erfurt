<?php
/**
 * Class for generating the Manchester OWL Syntax Parser
 * 
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package syntax
 * @version $Id$
 *
 */

include '../../lib/PEAR/PHP/ParserGenerator.php';
$a=new PHP_ParserGenerator();
//$_SERVER['argv'] = array('lemon', '-s', 'Parser.y');
$_SERVER['argv'] = array('lemon', '-s', './Parser.y');
$a->main();
?>
