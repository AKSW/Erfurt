<?php

require_once 'test_base.php';

class Erfurt_Syntax_Manchester_SparqlHelperTest extends Erfurt_TestCase {

    public function TestConnection() {
        $x = Erfurt_Owl_Structured_Util_SparqlHelper::fetch();
        // var_dump($x);
    }

    public function testGreedy(){
        $expected = "Class: ns0:Bilanzkreisvertrag SubClassOf: (ns0:Vertrag and ns0:hatVertragspartner some ns0:Bilanzkreisnetzbetreiber and ns0:hatVertragspartner some ns0:Lieferant and ns0:hatVertragspartner only (ns0:Bilanzkreisnetzbetreiber or ns0:Lieferant) and ns0:hatVertragspartner max 1 ns0:Bilanzkreisnetzbetreiber and ns0:hatVertragspartner max 1 ns0:Lieferant)";
        $x = Erfurt_Owl_Structured_Util_Owl2Structured::mapOWL2Structured(array("http://gasmarkt"), "http://www.bi-web.de/ontologies/le4sw/ns/0.3/Bilanzkreisvertrag");
        $this->assertEquals($expected, (string)$x);
    }
}
