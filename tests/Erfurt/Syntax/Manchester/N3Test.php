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
    public function testParser($method, $inputQuery, $expectedValue) {
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


    /**
     * @dataProvider providerDataRange
     */
    public function testDataRange($method, $inputQuery, $expectedValue) {
        $q = $this->initParser($inputQuery)->$method();
        $rrr = $q->toTriples();
        $this->assertEquals($expectedValue, $rrr);
    }

    public function providerParser() {
        return array(
            array("conjunction", "class1 and class2",
                "_:b3 rdf:type owl:Class .
_:b3 owl:intersectionOf _:b1 .
_:b1 rdf:first :class1 .
_:b1 rdf:rest _:b2 .
_:b2 rdf:first :class2 .
_:b2 rdf:rest rdf:nil .
"),
            array("description", "class1 or class2",
                "_:b6 rdf:type owl:Class .
_:b6 owl:unionOf _:b4 .
_:b4 rdf:first :class1 .
_:b4 rdf:rest _:b5 .
_:b5 rdf:first :class2 .
_:b5 rdf:rest rdf:nil .
"),
            array("description", "class1 or class2",
                "_:b9 rdf:type owl:Class .
_:b9 owl:unionOf _:b7 .
_:b7 rdf:first :class1 .
_:b7 rdf:rest _:b8 .
_:b8 rdf:first :class2 .
_:b8 rdf:rest rdf:nil .
"),
            array("description", "class1 or class2 or class3",
                "_:b13 rdf:type owl:Class .
_:b13 owl:unionOf _:b10 .
_:b10 rdf:first :class1 .
_:b10 rdf:rest _:b11 .
_:b11 rdf:first :class2 .
_:b11 rdf:rest _:b12 .
_:b12 rdf:first :class3 .
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
_:b14 rdf:first :a .
_:b14 rdf:rest _:b15 .
_:b15 rdf:first :b .
_:b15 rdf:rest rdf:nil .
"),
            array("conjunction", 'a1 and b1 and c1 and d1',
                "_:b21 rdf:type owl:Class .
_:b21 owl:intersectionOf _:b17 .
_:b17 rdf:first :a1 .
_:b17 rdf:rest _:b18 .
_:b18 rdf:first :b1 .
_:b18 rdf:rest _:b19 .
_:b19 rdf:first :c1 .
_:b19 rdf:rest _:b20 .
_:b20 rdf:first :d1 .
_:b20 rdf:rest rdf:nil .
"),
            array("restriction", 'hasParent some John',
                "_:b22 rdf:type owl:Restriction .
_:b22 owl:onProperty :hasParent .
_:b22 owl:someValuesFrom :John .
"),
            array("restriction", 'hasParent only John',
                "_:b23 rdf:type owl:Restriction .
_:b23 owl:onProperty :hasParent .
_:b23 owl:allValuesFrom :John .
"),
            array("restriction", 'hasParent value John',
                "_:b24 rdf:type owl:Restriction .
_:b24 owl:onProperty :hasParent .
_:b24 owl:hasValue :John .
"),
            array("restriction", 'hasParent Self',
                "_:b25 rdf:type owl:Restriction .
_:b25 owl:onProperty :hasParent .
_:b25 owl:hasSelf true^^xsd:boolean .
"),
            array("restriction", 'hasParent min 5 John',
                '_:b26 rdf:type owl:Restriction .
_:b26 owl:onProperty :hasParent .
_:b26 owl:minQualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b26 owl:onClass :John .
'),
            array("restriction", 'hasParent exactly 5 John',
                '_:b27 rdf:type owl:Restriction .
_:b27 owl:onProperty :hasParent .
_:b27 owl:qualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b27 owl:onClass :John .
'),

            array("description", "(class1 or class2 or class3)",
                "_:b31 rdf:type owl:Class .
_:b31 owl:unionOf _:b28 .
_:b28 rdf:first :class1 .
_:b28 rdf:rest _:b29 .
_:b29 rdf:first :class2 .
_:b29 rdf:rest _:b30 .
_:b30 rdf:first :class3 .
_:b30 rdf:rest rdf:nil .
"),
            array("description", "(class1 and class2 and class3)",
                "_:b35 rdf:type owl:Class .
_:b35 owl:intersectionOf _:b32 .
_:b32 rdf:first :class1 .
_:b32 rdf:rest _:b33 .
_:b33 rdf:first :class2 .
_:b33 rdf:rest _:b34 .
_:b34 rdf:first :class3 .
_:b34 rdf:rest rdf:nil .
"),

            array("description", "class1 and (class2 or class3)",
                "_:b41 rdf:type owl:Class .
_:b41 owl:intersectionOf _:b36 .
_:b36 rdf:first :class1 .
_:b36 rdf:rest _:b37 .
_:b37 rdf:first _:b40 .
_:b40 rdf:type owl:Class .
_:b40 owl:unionOf _:b38 .
_:b38 rdf:first :class2 .
_:b38 rdf:rest _:b39 .
_:b39 rdf:first :class3 .
_:b39 rdf:rest rdf:nil .
_:b37 rdf:rest rdf:nil .
"),
            array("description", "class1 and (class2 or class3) and class4",
                "_:b48 rdf:type owl:Class .
_:b48 owl:intersectionOf _:b42 .
_:b42 rdf:first :class1 .
_:b42 rdf:rest _:b43 .
_:b43 rdf:first _:b46 .
_:b46 rdf:type owl:Class .
_:b46 owl:unionOf _:b44 .
_:b44 rdf:first :class2 .
_:b44 rdf:rest _:b45 .
_:b45 rdf:first :class3 .
_:b45 rdf:rest rdf:nil .
_:b43 rdf:rest _:b47 .
_:b47 rdf:first :class4 .
_:b47 rdf:rest rdf:nil .
"),

        );
    }

    public function providerComplex() {
        return array(
            array("primary", "not class1",
"_:b49 rdf:type owl:Class .
_:b49 owl:complementOf :class1 .
"),
            array("description", "not (class1)",
                "_:b50 rdf:type owl:Class .
_:b50 owl:complementOf :class1 .
"),

            array("description", "(not class1)",
                "_:b51 rdf:type owl:Class .
_:b51 owl:complementOf :class1 .
"),
            array("description", "not (class1 and class2)",
                "_:b52 rdf:type owl:Class .
_:b52 owl:complementOf _:b55 .
_:b55 rdf:type owl:Class .
_:b55 owl:intersectionOf _:b53 .
_:b53 rdf:first :class1 .
_:b53 rdf:rest _:b54 .
_:b54 rdf:first :class2 .
_:b54 rdf:rest rdf:nil .
"),
            array("restriction", 'hasParent max 5 (not John)',
                '_:b56 rdf:type owl:Restriction .
_:b56 owl:onProperty :hasParent .
_:b56 owl:maxQualifiedCardinality "5"^^xsd:nonNegativeInteger .
_:b56 owl:onClass _:b57 .
_:b57 rdf:type owl:Class .
_:b57 owl:complementOf :John .
'),
            array("restriction", 'hasChild min 2 Parent',
                '_:b58 rdf:type owl:Restriction .
_:b58 owl:onProperty :hasChild .
_:b58 owl:minQualifiedCardinality "2"^^xsd:nonNegativeInteger .
_:b58 owl:onClass :Parent .
'),
            array('restriction', 'hasAge some integer [< 12 , >= 19]',
                '_:b64 rdf:type owl:Restriction .
_:b64 owl:onProperty :hasAge .
_:b64 owl:someValuesFrom _:b63 .
_:b63 rdf:type rdfs:Datatype .
_:b63 owl:onDatatype xsd:integer .
_:b63 owl:withRestrictions _:b59 .
_:b59 rdf:first _:b60 .
_:b60 xsd:minExclusive "12"^^xsd:integer .
_:b59 rdf:rest _:b61 .
_:b61 rdf:first _:b62 .
_:b62 xsd:maxInclusive "19"^^xsd:integer .
_:b61 rdf:rest rdf:nil .
'),
            array('restriction', 'hasAge some integer [< 12]',
                '_:b66 rdf:type owl:Restriction .
_:b66 owl:onProperty :hasAge .
_:b66 owl:someValuesFrom _:b65 .
_:b65 rdf:type rdfs:Datatype .
_:b65 owl:onDatatype xsd:integer .
_:b65 owl:withRestrictions _:b64 .
_:b64 xsd:minExclusive "12"^^xsd:integer .
'),
            array("restriction", 'hasParent exactly 5',
                '_:b67 rdf:type owl:Restriction .
_:b67 owl:onProperty :hasParent .
_:b67 owl:cardinality "5"^^xsd:nonNegativeInteger .
'),
            array("dataRange", 'integer [> 5]',
                '_:b68 rdf:type rdfs:Datatype .
_:b68 owl:onDatatype xsd:integer .
_:b68 owl:withRestrictions _:b67 .
_:b67 xsd:maxExclusive "5"^^xsd:integer .
'),
            array("dataRange", '{"aaa", "bbb"}',
                '_:b71 rdf:type rdfs:Datatype .
_:b71 owl:oneOf _:b69 .
_:b69 rdf:first "aaa" .
_:b69 rdf:rest _:b70 .
_:b70 rdf:first "bbb" .
_:b70 rdf:rest rdf:nil .
'),
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
            array("restriction", 'hasParent value "John"@dd',
                '_:b72 rdf:type owl:Restriction .
_:b72 owl:onProperty :hasParent .
_:b72 owl:hasValue "John"@dd .
'),
//            array("restriction", 'hasParent min 5 (integer [<= 222])', ''),
//            array("restriction", 'hasParent max 5 (integer [> 22])', ''),
//            array("restriction", 'hasParent max 5 ({"s", "w", 12})', ''),
////            array("restriction", 'hasParent exactly 5',''),
////
////            array("restriction", 'hasAge some integer [< 12, >= 19]',''),
////
////            array("dataConjunction", 'not float [< 4]',''),
////            array("dataConjunction", 'not float [< 4] and integer [>= 5]',''),
//            array("dataConjunction", 'not float [< 4]',''),
//
        );
    }


    public function providerDataRange() {
        return array(
            array("dataRange", "not personAge","_:b73 rdf:type rdfs:Datatype .
_:b73 owl:datatypeComplementOf :personAge .
"),
            array("dataRange", "personAge and personXXX", "_:b76 rdf:type rdfs:Datatype .
_:b76 owl:intersectionOf _:b74 .
_:b74 rdf:first :personAge .
_:b74 rdf:rest _:b75 .
_:b75 rdf:first :personXXX .
_:b75 rdf:rest rdf:nil .
"),
            array("dataRange", "not (personAge and personXXX)", "_:b80 rdf:type rdfs:Datatype .
_:b80 owl:datatypeComplementOf _:b79 .
_:b79 rdf:type rdfs:Datatype .
_:b79 owl:intersectionOf _:b77 .
_:b77 rdf:first :personAge .
_:b77 rdf:rest _:b78 .
_:b78 rdf:first :personXXX .
_:b78 rdf:rest rdf:nil .
"),
            array("dataRange", "personAge and not minorAge", "_:b84 rdf:type rdfs:Datatype .
_:b84 owl:intersectionOf _:b81 .
_:b81 rdf:first :personAge .
_:b81 rdf:rest _:b82 .
_:b82 rdf:first _:b83 .
_:b83 rdf:type rdfs:Datatype .
_:b83 owl:datatypeComplementOf :minorAge .
_:b82 rdf:rest rdf:nil .
" ),
            array("dataRange","{ 1, 2 }",'_:b87 rdf:type rdfs:Datatype .
_:b87 owl:oneOf _:b85 .
_:b85 rdf:first "1"^^xsd:integer .
_:b85 rdf:rest _:b86 .
_:b86 rdf:first "2"^^xsd:integer .
_:b86 rdf:rest rdf:nil .
'),
            array("dataRange","{ 1, 2, 2.3 }",'_:b91 rdf:type rdfs:Datatype .
_:b91 owl:oneOf _:b88 .
_:b88 rdf:first "1"^^xsd:integer .
_:b88 rdf:rest _:b89 .
_:b89 rdf:first "2"^^xsd:integer .
_:b89 rdf:rest _:b90 .
_:b90 rdf:first "2.3"^^xsd:decimal .
_:b90 rdf:rest rdf:nil .
'),
            array("dataRange",'{ 1, 2, "sss" }','_:b95 rdf:type rdfs:Datatype .
_:b95 owl:oneOf _:b92 .
_:b92 rdf:first "1"^^xsd:integer .
_:b92 rdf:rest _:b93 .
_:b93 rdf:first "2"^^xsd:integer .
_:b93 rdf:rest _:b94 .
_:b94 rdf:first "sss" .
_:b94 rdf:rest rdf:nil .
'),
            array("dataRange",'{ 1, 2, "sss"@de }','_:b99 rdf:type rdfs:Datatype .
_:b99 owl:oneOf _:b96 .
_:b96 rdf:first "1"^^xsd:integer .
_:b96 rdf:rest _:b97 .
_:b97 rdf:first "2"^^xsd:integer .
_:b97 rdf:rest _:b98 .
_:b98 rdf:first "sss"@de .
_:b98 rdf:rest rdf:nil .
'),
            array("restriction", 'ns0:allokiertFuer exactly 1 ns0:Ausspeisepunkt or ns0:Einspeisepunkt',
            ''
          ),
            );
    }
}
