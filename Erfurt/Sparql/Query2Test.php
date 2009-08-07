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
$s = new Erfurt_Sparql_Query2_Var("s");
$p = new Erfurt_Sparql_Query2_Var("p");
$triple1 = new Erfurt_Sparql_Query2_Triple($s, $p, new Erfurt_Sparql_Query2_Var("o"));

$profPrefix =new Erfurt_Sparql_Query2_Prefix("profs", new Erfurt_Sparql_Query2_IriRef("http://professoren.de"));

$iri = new Erfurt_Sparql_Query2_IriRef("http://example.com");

$query->setBase($iri)
->addPrefix($profPrefix)
->addPrefix(new Erfurt_Sparql_Query2_Prefix("confs", new Erfurt_Sparql_Query2_IriRef("http://konferenzen.de")));

$prefixedUri1 = new Erfurt_Sparql_Query2_IriRef("name", $profPrefix);
$prefixedUri2 = new Erfurt_Sparql_Query2_IriRef("website", $profPrefix);
$name = new Erfurt_Sparql_Query2_RDFLiteral("bob", "de");
$triple2 = new Erfurt_Sparql_Query2_Triple($s, $prefixedUri1, $prefixedUri1);
$triple3 = new Erfurt_Sparql_Query2_Triple($s, $prefixedUri2, $prefixedUri2);
$optional_pattern = new Erfurt_Sparql_Query2_OptionalGraphPattern();

$query->setPattern(
	$pattern
	->addElement($triple1)
	->addElement(
		$optional_pattern
		->addElement($triple2)
		->addElement($triple3)
	)
);


$query->addProjectionVar($p);
//$query->setStar(true);


//$query->setReduced(true);
$query->setDistinct(true);

$query->setLimit(50);
$query->setOffset(30);
$query->getOrder()->addVar($s);
//$query->getOrder()->toggleDirection();

echo "<pre>".htmlentities($query->getSparql())."</pre>";

?>
