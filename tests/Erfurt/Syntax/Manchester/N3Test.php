<?php

require_once 'test_base.php';

class Erfurt_Syntax_Manchester_N3Test extends PHPUnit_Framework_TestCase {

    private function initParser($inputQuery) {
        require_once 'antlr/Php/antlr.php';
        $input = new ANTLRStringStream($inputQuery);
        $lexer = new Erfurt_Syntax_ManchesterLexer($input);
        $tokens = new CommonTokenStream($lexer);
        return new Erfurt_Syntax_ManchesterParser($tokens);
    }

    /**
     * @dataProvider providerParser
     */
    public function tEstParser($method, $inputQuery, $expectedValue) {
        $q = $this->initParser($inputQuery)->$method();
        $rrr = $q->toTriples();
        $this->assertEquals($expectedValue, $rrr);
    }

    /**
     * @dataProvider providerComplex
     */
    public function testComplexParser($method, $inputQuery, $expectedValue) {
        $q = $this->initParser($inputQuery)->$method();
        $rrr = $q->toTriples();
        $this->assertEquals($expectedValue, $rrr);
    }


    public function providerParser() {
        return array(
            array("conjunction", "class1 and class2",
                "_:b3 rdf:type owl:Class .
_:b3 owl:intersectionOf _:b1 .
_:b1 rdf:first class1 .
_:b1 rdf:rest _:b2 .
_:b2 rdf:first class2 .
_:b2 rdf:rest rdf:nil .
"),
            array("description", "class1 or class2",
                "_:b6 rdf:type owl:Class .
_:b6 owl:unionOf _:b4 .
_:b4 rdf:first class1 .
_:b4 rdf:rest _:b5 .
_:b5 rdf:first class2 .
_:b5 rdf:rest rdf:nil .
"),
            array("description", "class1 or class2",
                "_:b9 rdf:type owl:Class .
_:b9 owl:unionOf _:b7 .
_:b7 rdf:first class1 .
_:b7 rdf:rest _:b8 .
_:b8 rdf:first class2 .
_:b8 rdf:rest rdf:nil .
"),
            array("description", "class1 or class2 or class3",
                "_:b13 rdf:type owl:Class .
_:b13 owl:unionOf _:b10 .
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

//            array("conjunction", 'ab',
//                "_:b14 owl:Class ab .
//"),
            // dummy
//            array("description", 'ab',
//                "_:b15 owl:Class ab .
//"),
            array("conjunction", 'a and b',
                "_:b16 rdf:type owl:Class .
_:b16 owl:intersectionOf _:b14 .
_:b14 rdf:first a .
_:b14 rdf:rest _:b15 .
_:b15 rdf:first b .
_:b15 rdf:rest rdf:nil .
"),
            array("conjunction", 'a1 and b1 and c1 and d1',
                "_:b21 rdf:type owl:Class .
_:b21 owl:intersectionOf _:b17 .
_:b17 rdf:first a1 .
_:b17 rdf:rest _:b18 .
_:b18 rdf:first b1 .
_:b18 rdf:rest _:b19 .
_:b19 rdf:first c1 .
_:b19 rdf:rest _:b20 .
_:b20 rdf:first d1 .
_:b20 rdf:rest rdf:nil .
"),
            array("restriction", 'hasParent some John',
                "_:b22 rdf:type owl:Restriction .
_:b22 owl:onProperty hasParent .
_:b22 owl:someValuesFrom John .
"),
            array("restriction", 'hasParent only John',
                "_:b23 rdf:type owl:Restriction .
_:b23 owl:onProperty hasParent .
_:b23 owl:allValuesFrom John .
"),
            array("restriction", 'hasParent value John',
                "_:b24 rdf:type owl:Restriction .
_:b24 owl:onProperty hasParent .
_:b24 owl:hasValue John .
"),
            array("restriction", 'hasParent Self',
                "_:b25 rdf:type owl:Restriction .
_:b25 owl:onProperty hasParent .
_:b25 owl:hasSelf true^^xsd:boolean .
"),
            array("restriction", 'hasParent min 5 John',
                '_:b26 rdf:type owl:Restriction .
_:b26 owl:onProperty hasParent .
_:b26 owl:minQualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b26 owl:onClass John .
'),
            array("restriction", 'hasParent exactly 5 John',
                '_:b27 rdf:type owl:Restriction .
_:b27 owl:onProperty hasParent .
_:b27 owl:qualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b27 owl:onClass John .
'),

        );
    }

    public function providerComplex() {
        return array(
            array("conjunction", "not class1",
                "_:b30 owl:complementOf _:b31 .
_:b31 owl:Class class1 .
"),
//            array("restriction", 'hasParent max 5 (not John)',
//                '_:b32 rdf:type owl:Restriction .
//_:b32 owl:maxQualifiedCardinality "5"^^xsd:nonNegativeInteger .
//_:b32 owl:onProperty hasParent .
//_:b32 owl:onClass _:b33 .
//_:b33 owl:complementOf _:b34 .
//_:b34 owl:Class John .
//'),
//            array("restriction", 'hasChild min 2 Parent',
//                '_:b35 rdf:type owl:Restriction .
//_:b35 owl:minQualifiedCardinality "2"^^xsd:nonNegativeInteger .
//_:b35 owl:onProperty hasChild .
//_:b35 owl:onClass Parent .
//'),
//            array('restriction', 'hasAge some integer [< 12 , >= 19]',
//                '_:b41 rdf:type owl:Restriction .
//_:b41 owl:onProperty hasAge .
//_:b41 owl:someValuesFrom _:b40 .
//_:b40 rdf:type rdfs:Datatype .
//_:b40 owl:onDatatype xsd:integer .
//_:b40 owl:withRestrictions _:b36 .
//_:b36 rdf:first _:b37 .
//_:b37 xsd:minExclusive "12"^^xsd:integer .
//_:b36 rdf:rest _:b38 .
//_:b38 rdf:first _:b39 .
//_:b39 xsd:maxInclusive "19"^^xsd:integer .
//_:b38 rdf:rest rdf:nil .
//'),
//            array('restriction', 'hasAge some integer [< 12]',
//                '_:b43 rdf:type owl:Restriction .
//_:b43 owl:onProperty hasAge .
//_:b43 owl:someValuesFrom _:b42 .
//_:b42 rdf:type rdfs:Datatype .
//_:b42 owl:onDatatype xsd:integer .
//_:b42 owl:withRestrictions _:b41 .
//_:b41 xsd:minExclusive "12"^^xsd:integer .
//'),
//            array("restriction", 'hasParent exactly 5',
//                '_:b44 rdf:type owl:Restriction .
//_:b44 owl:qualifiedCardinality "5"^^xsd:nonNegativeInteger .
//_:b44 owl:onProperty hasParent .
//'),
//            array("dataRange", 'integer [> 5]',
//                '_:b45 rdf:type rdfs:Datatype .
//_:b45 owl:onDatatype xsd:integer .
//_:b45 owl:withRestrictions _:b44 .
//_:b44 xsd:maxExclusive "5"^^xsd:integer .
//'),
//            array("dataRange", '{"aaa", "bbb"}',
//                '_:b48 rdf:type rdfs:Datatype .
//_:b48 owl:oneOf _:b46 .
//_:b46 rdf:first "aaa" .
//_:b46 rdf:rest _:b47 .
//_:b47 rdf:first "bbb" .
//_:b47 rdf:rest rdf:nil .
//'),
//            array("restriction", 'hasParent some float [< 4]',
//                '_:b50 rdf:type owl:Restriction .
//_:b50 owl:onProperty hasParent .
//_:b50 owl:someValuesFrom _:b49 .
//_:b49 rdf:type rdfs:Datatype .
//_:b49 owl:onDatatype xsd:float .
//_:b49 owl:withRestrictions _:b48 .
//_:b48 xsd:minExclusive "4"^^xsd:integer .
//'),
//            array("restriction", 'hasParent only integer [> 333]',
//                '_:b52 rdf:type owl:Restriction .
//_:b52 owl:onProperty hasParent .
//_:b52 owl:allValuesFrom _:b51 .
//_:b51 rdf:type rdfs:Datatype .
//_:b51 owl:onDatatype xsd:integer .
//_:b51 owl:withRestrictions _:b50 .
//_:b50 xsd:maxExclusive "333"^^xsd:integer .
//'),
//            array("restriction", 'hasParent value "John"@dd',
//                '_:b53 rdf:type owl:Restriction .
//_:b53 owl:onProperty hasParent .
//_:b53 owl:hasValue "John"@dd .
//'),
//            array("restriction", 'hasParent min 5 (integer [<= 222])', ''),
//            array("restriction", 'hasParent max 5 (integer [> 22])', ''),
//            array("restriction", 'hasParent max 5 ({"s", "w", 12})', ''),
////            array("restriction", 'hasParent exactly 5',''),
////
////            array("restriction", 'hasAge some integer [< 12, >= 19]',''),
////
////            array("dataConjunction", 'not float [< 4]',''),
////            array("dataConjunction", 'not float [< 4] and integer [>= 5]',''),
////            array("dataConjunction", 'not float [< 4]',''),
//
        );
    }

}
