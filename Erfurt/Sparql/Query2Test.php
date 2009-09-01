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

//test graph pattern
$query = new Erfurt_Sparql_Query2();
$pattern = new Erfurt_Sparql_Query2_GroupGraphPattern();
$s = new Erfurt_Sparql_Query2_BlankNode("s");
$foafPrefix =new Erfurt_Sparql_Query2_Prefix("foaf", new Erfurt_Sparql_Query2_IriRef("http://xmlns.com/foaf/0.1/"));
$triple1 = new Erfurt_Sparql_Query2_Triple($s, new Erfurt_Sparql_Query2_A(), new Erfurt_Sparql_Query2_IriRef("Person", $foafPrefix));
$iri1 = new Erfurt_Sparql_Query2_IriRef("http://bob-home.example.com");
$iri2 = new Erfurt_Sparql_Query2_IriRef("http://bob-work.example.com");
$iri3 = new Erfurt_Sparql_Query2_IriRef("http://bob-work.example.com/mailaddr_checker_func");
$query->addPrefix($foafPrefix);
$query->addFrom("http://3ba.se/conferences/", true); //we can add strings - will be converted internally
$query->addFrom("http://3ba.se/conferences/"); //doubled
$query->deleteFrom(1); //so remove
$prefixedUri1 = new Erfurt_Sparql_Query2_IriRef("name", $foafPrefix);
$prefixedUri2 = new Erfurt_Sparql_Query2_IriRef("website", $foafPrefix);
$name = new Erfurt_Sparql_Query2_RDFLiteral("bob", "en");
$bnode = new Erfurt_Sparql_Query2_BlankNode("bn");
$triplesamesubj = new Erfurt_Sparql_Query2_TriplesSameSubject($s, array(array("pred"=>$prefixedUri1, "obj"=>$name),array("pred"=>$prefixedUri2, "obj"=>new Erfurt_Sparql_Query2_ObjectList(array($iri1, $iri2)))));
$optional_pattern = new Erfurt_Sparql_Query2_OptionalGraphPattern();
$optional_pattern2 = new Erfurt_Sparql_Query2_OptionalGraphPattern();
$mbox =  new Erfurt_Sparql_Query2_Var("mbox");
$mbox2 =  new Erfurt_Sparql_Query2_Var("mbox");
$triple2 = new Erfurt_Sparql_Query2_Triple($s, new Erfurt_Sparql_Query2_IriRef("mbox", $foafPrefix),$mbox);

//test filter
$or = new Erfurt_Sparql_Query2_ConditionalOrExpression();
$one1= new Erfurt_Sparql_Query2_NumericLiteral(1);
$one2 = new Erfurt_Sparql_Query2_RDFLiteral("1", "int");

$st = new Erfurt_Sparql_Query2_sameTerm($one1, $one2);

$nst = new Erfurt_Sparql_Query2_UnaryExpressionNot($st);
$and= new Erfurt_Sparql_Query2_ConditionalAndExpression();
$regex = new Erfurt_Sparql_Query2_Regex(new Erfurt_Sparql_Query2_Str($mbox), new Erfurt_Sparql_Query2_RDFLiteral("/home/"),new Erfurt_Sparql_Query2_RDFLiteral("i"));
$filter = new Erfurt_Sparql_Query2_Filter($or);

//build structure
$query->setWhere(
	$pattern
	->addElement($triple1)
	->addElement($triplesamesubj)
	->addElement($triplesamesubj) //duplicate
	->addElement(
		$optional_pattern
			->addElement($triple2)
	)
	->addElement($filter
		->setConstraint($or
			->addElement($and
				->addElement($nst)
				->addElement(new Erfurt_Sparql_Query2_isLiteral($mbox))
				->addElement(new Erfurt_Sparql_Query2_Function($iri3,array($mbox)))
			)
			->addElement($regex)
		)
	)
);
$query->optimize();

$nst->remove();
// or 
// $and->removeElement($nst->getID());
// but the 2nd command removes only occurences of $nst in add, while $nst->remove() removes all ocurrences

//modify query
$query->addProjectionVar($mbox);
$query->setCountStar(true);

//$query->setReduced(true);
$query->setDistinct(true);

$query->setLimit(50);
$query->setOffset(30);
$idx = $query->getOrder()->add($mbox);
//$query->getOrder()->toggleDirection($idx);

//test different types
//$query->setQueryType(Erfurt_Sparql_Query2::typeConstruct);
//$query->getWhere()->removeAllElements();
//$query->getConstructTemplate()->addElement(new Erfurt_Sparql_Query2_Triple($s, $prefixedUri1, $name));

echo "<h3>Basic Query Building</h3><pre>".htmlentities($query->getSparql())."</pre>";

$abs = new Erfurt_Sparql_Query2_Abstraction();
$startclass = new Erfurt_Sparql_Query2_Abstraction_RDFSClass(new Erfurt_Sparql_Query2_IriRef("http://example.com/someclass"));
$abs->addNode(null, null, $startclass);
$abs->getStartNode()->addShownProperty(new Erfurt_Sparql_Query2_IriRef("http://example.com/someclass#someprop"));
$abs->addNode($abs->getStartNode(), new Erfurt_Sparql_Query2_IriRef("http://example.com/someclass#somelink"), new Erfurt_Sparql_Query2_Abstraction_RDFSClass(new Erfurt_Sparql_Query2_IriRef("http://example.com/someOtherClass")))
		->addShownProperty(new Erfurt_Sparql_Query2_IriRef("http://example.com/someOtherClass#otherProp"));

echo "<h3>Abstracted Query Building</h3><pre>".htmlentities($abs->getSparql())."</pre>";

?>
