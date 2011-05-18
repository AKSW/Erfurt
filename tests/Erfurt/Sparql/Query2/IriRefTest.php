<?php
require_once 'Erfurt/TestCase.php';

class Erfurt_Sparql_Query2_IriRefTest  extends Erfurt_TestCase{
    protected $iri;

    public function setUp(){
        $this->iri = new Erfurt_Sparql_Query2_IriRef("http://example.com/");
    }

    public function testSimple(){
        $this->assertTrue($this->iri->getSparql() == "<http://example.com/>");
    }

    public function testPrefixedUri(){
        $prefix = new Erfurt_Sparql_Query2_Prefix("ns", new Erfurt_Sparql_Query2_IriRef("http://example.com/"));
        $this->iri = new Erfurt_Sparql_Query2_IriRef("local", $prefix);
        $this->assertTrue($this->iri->getSparql() == "ns:local");
        $this->assertTrue($this->iri->getExpanded() == "<http://example.com/local>");
        $this->assertTrue($this->iri->isPrefixed());
    }

    public function testUnexpandablePrefixedUri(){
        $this->iri = new Erfurt_Sparql_Query2_IriRef("local", null, "ns");
        $this->assertTrue($this->iri->getSparql() == "ns:local");
        $this->assertTrue($this->iri->getExpanded() == "ns:local");
        $this->assertTrue($this->iri->isPrefixed());
    }
}
?>
