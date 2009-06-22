<?php
require_once 'Erfurt/TestCase.php';

require_once 'Erfurt/Rdf/Literal.php';

class Erfurt_Rdf_LiteralTest extends Erfurt_TestCase
{

    public function testInitWithLabel() {
        $literal1 = Erfurt_Rdf_Literal::initWithLabel("Testliteral1");
        $literal2 = Erfurt_Rdf_Literal::initWithLabel("Testliteral2");

        $this->assertSame("Testliteral1", $literal1->getLabel());
        $this->assertSame("Testliteral2", $literal2->getLabel());
    }

    public function testInitWithLabelAndLanguage() {
        $literal1 = Erfurt_Rdf_Literal::initWithLabelAndLanguage("Testliteral1","de");
        $literal2 = Erfurt_Rdf_Literal::initWithLabelAndLanguage("Testliteral2","en");

        $this->assertSame("Testliteral1", $literal1->getLabel());
        $this->assertSame("Testliteral2", $literal2->getLabel());

        $this->assertSame("de", $literal1->getLanguage());
        $this->assertSame("en", $literal2->getLanguage());

    }

    public function testInitWithLabelAndDatatype() {
        $literal1 = Erfurt_Rdf_Literal::initWithLabelAndDatatype("true","http://www.w3.org/2001/XMLSchema#boolean");
        $literal2 = Erfurt_Rdf_Literal::initWithLabelAndDatatype("Testliteral2","http://www.w3.org/2001/XMLSchema#string");

        $this->assertSame("true", $literal1->getLabel());
        $this->assertSame("Testliteral2", $literal2->getLabel());

        $this->assertSame("http://www.w3.org/2001/XMLSchema#boolean", $literal1->getDatatype());
        $this->assertSame("http://www.w3.org/2001/XMLSchema#string", $literal2->getDatatype());

    }

}
