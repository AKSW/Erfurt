<?php

require_once 'test_base.php';

class Erfurt_Syntax_Manchester_N3Test extends PHPUnit_Framework_TestCase
{
	
	private function initParser($inputQuery)
	{
    require_once 'antlr/Php/antlr.php'; 
		$input = new ANTLRStringStream($inputQuery);
		$lexer = new Erfurt_Syntax_ManchesterLexer($input);
		$tokens = new CommonTokenStream($lexer);
		return new Erfurt_Syntax_ManchesterParser($tokens);
	}

  /**
    * @dataProvider providerParser
    */
	public function testParser($method, $inputQuery, $expectedValue)
	{
		$q = $this->initParser($inputQuery)->$method();
    $rrr = $q->toTriples();
    $this->assertEquals($expectedValue, $rrr);
 }
  /**
    * @dataProvider providerComplex
    */
	public function testComplexParser($method, $inputQuery, $expectedValue)
	{
		$q = $this->initParser($inputQuery)->$method();
    $rrr = $q->toTriples();
    $this->assertEquals($expectedValue, $rrr);
 }


  public function providerParser(){
    return array(
         array("conjunction","class1 and class2", 
"_:b3 owl:intersectionOf _:b1 .
_:b1 rdf:first class1 .
_:b1 rdf:rest _:b2 .
_:b2 rdf:first class2 .
_:b2 rdf:rest rdf:nil .
"),
         array("description","class1 or class2",
"_:b6 owl:unionOf _:b4 .
_:b4 rdf:first class1 .
_:b4 rdf:rest _:b5 .
_:b5 rdf:first class2 .
_:b5 rdf:rest rdf:nil .
"),
        array("description","class1 or class2",
"_:b9 owl:unionOf _:b7 .
_:b7 rdf:first class1 .
_:b7 rdf:rest _:b8 .
_:b8 rdf:first class2 .
_:b8 rdf:rest rdf:nil .
"),
        array("description","class1 or class2 or class3",
"_:b13 owl:unionOf _:b10 .
_:b10 rdf:first class1 .
_:b10 rdf:rest _:b11 .
_:b11 rdf:first class2 .
_:b11 rdf:rest _:b12 .
_:b12 rdf:first class3 .
_:b12 rdf:rest rdf:nil .
"),
//        array("description","class1 or class2 and class3", "_:b owl:unionOf (class1 class2 class3) .\n"),
//        array("description","class1 or class2 and class3 or class4", "_:b owl:unionOf (class1 class2 class3) .\n"),

//        array("dataTypeRestriction","integer [>= 150]", "_:b owl:onDatatype xsd:integer; owl:withRestrictions ([>= 150]) .\n"),
//        array("dataTypeRestriction","integer [<= 0, >= 150]", "xxx"),

        array("conjunction",'ab',
"_:b15 owl:intersectionOf _:b14 .
_:b14 rdf:first ab .
_:b14 rdf:rest rdf:nil .
"),
        array("conjunction",'a and b',
"_:b18 owl:intersectionOf _:b16 .
_:b16 rdf:first a .
_:b16 rdf:rest _:b17 .
_:b17 rdf:first b .
_:b17 rdf:rest rdf:nil .
"),
        array("conjunction",'a1 and b1 and c1 and d1',
"_:b23 owl:intersectionOf _:b19 .
_:b19 rdf:first a1 .
_:b19 rdf:rest _:b20 .
_:b20 rdf:first b1 .
_:b20 rdf:rest _:b21 .
_:b21 rdf:first c1 .
_:b21 rdf:rest _:b22 .
_:b22 rdf:first d1 .
_:b22 rdf:rest rdf:nil .
"),
        array("restriction",'hasParent some John',
"_:b24 rdf:type owl:Restriction .
_:b24 owl:onProperty hasParent .
_:b24 owl:someValuesFrom John .
"),
        array("restriction",'hasParent only John',
"_:b25 rdf:type owl:Restriction .
_:b25 owl:onProperty hasParent .
_:b25 owl:allValuesFrom John .
"),
        array("restriction",'hasParent value John',
"_:b26 rdf:type owl:Restriction .
_:b26 owl:onProperty hasParent .
_:b26 owl:hasValue John .
"),
        array("restriction",'hasParent Self',
"_:b27 rdf:type owl:Restriction .
_:b27 owl:onProperty hasParent .
_:b27 owl:hasSelf true^^xsd:boolean .
"),
        array("restriction",'hasParent min 5 John',
'_:b28 rdf:type owl:Restriction .
_:b28 owl:minQualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b28 owl:onProperty hasParent .
_:b28 owl:onClass John .
'),
        array("restriction",'hasParent exactly 5 John',
'_:b29 rdf:type owl:Restriction .
_:b29 owl:qualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b29 owl:onProperty hasParent .
_:b29 owl:onClass John .
'),

        );
  }

  public function providerComplex(){
    return array(
       array("restriction",'hasParent max 5 (not John)',""),
        );
  }

}
