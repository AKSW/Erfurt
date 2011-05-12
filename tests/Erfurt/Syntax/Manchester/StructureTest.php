<?php


require_once 'test_base.php';
class Erfurt_Syntax_Manchester_StructureTest extends PHPUnit_Framework_TestCase {

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
        // var_dump($q);
        $rrr = $q->toTriples();
        var_dump($rrr);


        $val1 = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(
        array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Speicher");
        // $this->assertEquals($q->toTriples(), $val1->toTriples());
        var_dump($val1->toTriples());
        // $this->assertEquals($expectedValue, $rrr);
    }


    public function providerParser(){
      return array(
        array("classFrame",
        "Class: ns0:Speicher SubClassOf: ns0:Ausspeisepunkt SubClassOf: ns0:Einspeisepunkt SubClassOf: ns0:istGegenstand only ns0:Speichervertrag SubClassOf: ns0:VolumenkWh exactly 1 float SubClassOf: ns0:Volumenm3 exactly 1 float",
        "Class: ns0:Speicher SubClassOf: ns0:Ausspeisepunkt SubClassOf: ns0:Einspeisepunkt SubClassOf: ns0:istGegenstand only ns0:Speichervertrag SubClassOf: ns0:VolumenkWh exactly 1 xsd:float SubClassOf: ns0:Volumenm3 exactly 1 xsd:float"),
          );
    }
}
