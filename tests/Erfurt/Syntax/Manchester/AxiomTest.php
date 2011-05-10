<?php

require_once 'test_base.php';

class Erfurt_Syntax_Manchester_AxiomTest extends Erfurt_TestCase {

    public function testSublass(){
        $x = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Speicher");
        $expexted = "ns0:Speicher SubClassOf: ns0:Ausspeisepunkt, ns0:Einspeisepunkt, ns0:istGegenstand only ns0:Speichervertrag, ns0:VolumenkWh exactly :1 (xsd:float), ns0:Volumenm3 exactly :1 (xsd:float)";
        $this->assertEquals((string)$x, $expexted);
    }


    public function testSimple()
    {
        $x = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Einspeisemenge");
        $expexted = "ns0:Speicher SubClassOf: ns0:Ausspeisepunkt, ns0:Einspeisepunkt, ns0:istGegenstand only ns0:Speichervertrag, ns0:VolumenkWh exactly :1 (xsd:float), ns0:Volumenm3 exactly :1 (xsd:float)";
        $this->assertEquals((string)$x, $expexted);
    }
}
