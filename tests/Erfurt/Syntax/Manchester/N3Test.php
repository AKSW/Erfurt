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
		$this->assertEquals($expectedValue, $q->toTriples());
 }

  public function providerParser(){
    return array(
        array("conjunction","class1 and class2", 
"_:b2 owl:intersectionOf _:b0 .
_:b0 rdf:first class1 .
_:b0 rdf:rest _:b1 .
_:b1 rdf:first class2 .
_:b1 rdf:rest rdf:nil .
"),
        array("description","class1 or class2",
"_:b4 owl:unionOf _:b2 .
_:b2 rdf:first class1 .
_:b2 rdf:rest _:b3 .
_:b3 rdf:first class2 .
_:b3 rdf:rest rdf:nil .
"),
        array("description","class1 or class2",
"_:b6 owl:unionOf _:b4 .
_:b4 rdf:first class1 .
_:b4 rdf:rest _:b5 .
_:b5 rdf:first class2 .
_:b5 rdf:rest rdf:nil .
"),
        array("description","class1 or class2 or class3",
"_:b9 owl:unionOf _:b6 .
_:b6 rdf:first class1 .
_:b6 rdf:rest _:b7 .
_:b7 rdf:first class2 .
_:b7 rdf:rest _:b8 .
_:b8 rdf:first class3 .
_:b8 rdf:rest rdf:nil .
"),
//        array("description","class1 or class2 and class3", "_:b owl:unionOf (class1 class2 class3) .\n"),
//        array("description","class1 or class2 and class3 or class4", "_:b owl:unionOf (class1 class2 class3) .\n"),

//        array("dataTypeRestriction","integer [>= 150]", "_:b owl:onDatatype xsd:integer; owl:withRestrictions ([>= 150]) .\n"),
//        array("dataTypeRestriction","integer [<= 0, >= 150]", "xxx"),

        array("conjunction",'ab',
"_:b10 owl:intersectionOf _:b9 .
_:b9 rdf:first ab .
_:b9 rdf:rest rdf:nil .
"),
        array("conjunction",'a and b',
"_:b12 owl:intersectionOf _:b10 .
_:b10 rdf:first a .
_:b10 rdf:rest _:b11 .
_:b11 rdf:first b .
_:b11 rdf:rest rdf:nil .
"),
        array("conjunction",'a1 and b1 and c1 and d1',
"_:b16 owl:intersectionOf _:b12 .
_:b12 rdf:first a1 .
_:b12 rdf:rest _:b13 .
_:b13 rdf:first b1 .
_:b13 rdf:rest _:b14 .
_:b14 rdf:first c1 .
_:b14 rdf:rest _:b15 .
_:b15 rdf:first d1 .
_:b15 rdf:rest rdf:nil .
"),
        array("restriction",'hasParent some John',
"_:b17 rdf:type owl:Restriction .
_:b17 owl:onProperty hasParent .
_:b17 owl:someValuesFrom John .
"),
        array("restriction",'hasParent only John',
"_:b18 rdf:type owl:Restriction .
_:b18 owl:onProperty hasParent .
_:b18 owl:allValuesFrom John .
"),
        array("restriction",'hasParent value John',
"_:b19 rdf:type owl:Restriction .
_:b19 owl:onProperty hasParent .
_:b19 owl:hasValue John .
"),
        array("restriction",'hasParent Self',
"_:b20 rdf:type owl:Restriction .
_:b20 owl:onProperty hasParent .
_:b20 owl:hasSelf true^^xsd:boolean .
"),
        array("restriction",'hasParent min 5 John',
'_:b21 rdf:type owl:Restriction .
_:b21 owl:minQualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b21 owl:onProperty hasParent .
_:b21 owl:onClass John .
'),
        array("restriction",'hasParent exactly 5 John',
'_:b22 rdf:type owl:Restriction .
_:b22 owl:qualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b22 owl:onProperty hasParent .
_:b22 owl:onClass John .
'),
        array("restriction",'hasParent max 5 not John',""),

        );
  }

}
