<?php

require_once 'test_base.php';

class Erfurt_Syntax_Manchester_AxiomTest extends Erfurt_TestCase {

    public function testSublass(){
        $x = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Speicher");
        $expexted = "Class: ns0:Speicher SubClassOf: ns0:Ausspeisepunkt SubClassOf: ns0:Einspeisepunkt SubClassOf: ns0:istGegenstand only ns0:Speichervertrag SubClassOf: ns0:VolumenkWh exactly 1 (xsd:float) SubClassOf: ns0:Volumenm3 exactly 1 (xsd:float)";
        $this->assertEquals($expexted, (string)$x);
    }


    public function testSimple()
    {
        $x = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Einspeisemenge");
        $expexted = "Class: ns0:Einspeisemenge SubClassOf: ns0:Gasmenge SubClassOf: ns0:eingespeistAm exactly 1 ns31:Instant SubClassOf: ns0:ermitteltAn exactly 1 ns0:Einspeisepunkt";
        $this->assertEquals($expexted, (string)$x);
    }
}
