<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Sparql/Query2/structural-Interfaces.php';
require_once 'Erfurt/Sparql/Query2/Constraint.php';
class Erfurt_Sparql_Query2_RDFLiteralTest  extends Erfurt_TestCase{
    protected $literal;

    public function setUp(){
        $this->literal = new Erfurt_Sparql_Query2_RDFLiteral("abc");
    }

    public function testBasic(){
        $this->assertTrue($this->literal->isPlain());
        $this->literal->setValue("xyz");
        $this->assertTrue($this->literal->getValue() == "xyz");
        $this->literal = new Erfurt_Sparql_Query2_RDFLiteral("42", "int");
        $this->assertTrue($this->literal->getSparql() == '"42"^^<http://www.w3.org/2001/XMLSchema#int>');
        $this->assertTrue($this->literal->isTyped());
        $this->literal = new Erfurt_Sparql_Query2_RDFLiteral("42", "de");
        $this->assertTrue($this->literal->isLangTagged());
        $this->literal->setLanguageTag("fr");
        $this->assertTrue($this->literal->getSparql() == '"42"@fr');
    }
}
?>
