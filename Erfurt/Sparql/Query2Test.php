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

$foafPrefix =new Erfurt_Sparql_Query2_Prefix("foaf", new Erfurt_Sparql_Query2_IriRef("http://xmlns.com/foaf/0.1/"));

$iri = new Erfurt_Sparql_Query2_IriRef("http://example.com");

$query
	->setBase($iri)
	->addPrefix($foafPrefix);

$prefixedUri1 = new Erfurt_Sparql_Query2_IriRef("name", $foafPrefix);
$prefixedUri2 = new Erfurt_Sparql_Query2_IriRef("website", $foafPrefix);
$name = new Erfurt_Sparql_Query2_RDFLiteral("bob", "en");
$bnode = new Erfurt_Sparql_Query2_BlankNode("bn");
$triple2 = new Erfurt_Sparql_Query2_Triple($s, $prefixedUri1, $name);
$triple3 = new Erfurt_Sparql_Query2_Triple($s, $prefixedUri2, $iri);
$triple4 = new Erfurt_Sparql_Query2_Triple($s, $prefixedUri2, $bnode);
$optional_pattern = new Erfurt_Sparql_Query2_OptionalGraphPattern();

$query->setPattern(
	$pattern
	->addElement($triple1)
	->addElement(
		$optional_pattern
		->addElement($triple2)
		->addElement($triple3)
		->addElement($triple4)
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

echo "<h3>Basic Query Building</h3><pre>".htmlentities($query->getSparql())."</pre>";
//echo $prefixedUri1->getSparql()." == ".htmlentities($prefixedUri1->getExpanded());

$abs = new Erfurt_Sparql_Query2_Abstraction();
$startclass = new Erfurt_Sparql_Query2_Abstraction_RDFSClass(new Erfurt_Sparql_Query2_IriRef("http://example.com/someclass"));
$abs->addNode(null, null, $startclass);
$abs->getStartNode()->addShownProperty(new Erfurt_Sparql_Query2_IriRef("http://example.com/someclass#someprop"));
$abs->addNode($abs->getStartNode(), new Erfurt_Sparql_Query2_IriRef("http://example.com/someclass#somelink"), new Erfurt_Sparql_Query2_Abstraction_RDFSClass(new Erfurt_Sparql_Query2_IriRef("http://example.com/someOtherClass")))
		->addShownProperty(new Erfurt_Sparql_Query2_IriRef("http://example.com/someOtherClass#otherProp"));

echo "<h3>Abstracted Query Building</h3><pre>".htmlentities($abs->getSparql())."</pre>";
?>
