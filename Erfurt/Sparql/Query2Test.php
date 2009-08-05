<?php
/**
 * Erfurt Sparql Query - little test script
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
 
require_once "Query2.php";

$query = new Erfurt_Sparql_Query2();
$pattern = new Erfurt_Sparql_Query2_GroupGraphPattern();
$block = new Erfurt_Sparql_Query2_TriplesBlock();
$s = new Erfurt_Sparql_Query2_Var("s");
$p = new Erfurt_Sparql_Query2_Var("p");
$triple1 = new Erfurt_Sparql_Query2_Triple($s, $p, new Erfurt_Sparql_Query2_Var("o"));
$triple2 = new Erfurt_Sparql_Query2_Triple($s, $p , new Erfurt_Sparql_Query2_Var("q"));
$block->addTriple($triple1);
$pattern->addMember($block);
$optional_pattern = new Erfurt_Sparql_Query2_OptionalGraphPattern();
$block2 = new Erfurt_Sparql_Query2_TriplesBlock();
$block2->addTriple($triple2);
$optional_pattern->addMember($block2);
$pattern->addMember($optional_pattern);
$query->setPattern($pattern);


$query->addProjectionVar($p);
//$query->setStar(true);


//$query->setReduced(true);
$query->setDistinct(true);

$query->setLimit(50);
$query->setOffset(30);
$query->getOrder()->addVar($s);
//$query->getOrder()->toggleDirection();

echo "<pre>".$query->getSparql()."</pre>";

?>
