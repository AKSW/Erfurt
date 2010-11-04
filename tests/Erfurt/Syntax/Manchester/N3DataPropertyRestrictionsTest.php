<?php


require_once 'test_base.php';
class Erfurt_Syntax_Manchester_N3DataPropertyRestrictionsTest extends PHPUnit_Framework_TestCase {

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


    public function providerParser(){
      return array(
          array("restriction", "hasAge only integer[< 12 , >= 19]",'_:b6 rdf:type owl:Restriction .
_:b6 owl:onProperty :hasAge .
_:b6 owl:allValuesFrom _:b5 .
_:b5 rdf:type rdfs:Datatype .
_:b5 owl:onDatatype xsd:integer .
_:b5 owl:withRestrictions _:b1 .
_:b1 rdf:first _:b2 .
_:b2 xsd:minExclusive "12"^^xsd:integer .
_:b1 rdf:rest _:b3 .
_:b3 rdf:first _:b4 .
_:b4 xsd:maxInclusive "19"^^xsd:integer .
_:b3 rdf:rest rdf:nil .
'),
          array("restriction", "hasAge some integer[< 12 , >= 19]",'_:b12 rdf:type owl:Restriction .
_:b12 owl:onProperty :hasAge .
_:b12 owl:someValuesFrom _:b11 .
_:b11 rdf:type rdfs:Datatype .
_:b11 owl:onDatatype xsd:integer .
_:b11 owl:withRestrictions _:b7 .
_:b7 rdf:first _:b8 .
_:b8 xsd:minExclusive "12"^^xsd:integer .
_:b7 rdf:rest _:b9 .
_:b9 rdf:first _:b10 .
_:b10 xsd:maxInclusive "19"^^xsd:integer .
_:b9 rdf:rest rdf:nil .
'),
        array("restriction", 'hasAge value "aaa"@de', '_:b13 rdf:type owl:Restriction .
_:b13 owl:onProperty :hasAge .
_:b13 owl:hasValue "aaa"@de .
'),
        array("restriction", 'hasParent exactly 2','_:b14 rdf:type owl:Restriction .
_:b14 owl:onProperty :hasParent .
_:b14 owl:cardinality "2"^^xsd:nonNegativeInteger .
'),
//        array("dataRange", "not integer",''),
        array("restriction", 'hasParent exactly 2 integer[< 12]','_:b16 rdf:type owl:Restriction .
_:b16 owl:onProperty :hasParent .
_:b16 owl:qualifiedCardinality "2"^^xsd:nonNegativeInteger .
_:b16 owl:onDataRange _:b15 .
_:b15 rdf:type rdfs:Datatype .
_:b15 owl:onDatatype xsd:integer .
_:b15 owl:withRestrictions _:b14 .
_:b14 xsd:minExclusive "12"^^xsd:integer .
'),
//        array("restriction", 'hasParent exactly 2 integer','_:b14 rdf:type owl:Restriction .
//            '),
        array("restriction", "hasParent max 1",''),
        array("restriction", 'hasParent max 1 integer [< 12]',''),
          );
    }
}
