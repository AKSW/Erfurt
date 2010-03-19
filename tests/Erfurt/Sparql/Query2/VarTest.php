<?php
require_once 'Erfurt/TestCase.php';

class Erfurt_Sparql_Query2_VarTest  extends Erfurt_TestCase{
    protected $var;

    public function setUp(){
        $this->var = new Erfurt_Sparql_Query2_Var("s");
    }

    public function testBasic(){
        $this->assertTrue($this->var->getSparql() == "?s");
        $this->assertTrue($this->var->getVarLabelType() == "?");

        $this->var->toggleVarLabelType();
        $this->assertTrue($this->var->getSparql() == '$s');
        $this->assertTrue($this->var->getVarLabelType() == '$');

        $this->var->setName("p");
        $this->assertTrue($this->var->getName() == "p");
    }

    public function testExtraction(){
        $this->assertTrue(Erfurt_Sparql_Query2_Var::extractName('http://example.com/foaf/bob') == "bob");
        $this->assertTrue(Erfurt_Sparql_Query2_Var::extractName('http://example.com/foaf#bob') == "bob");
        $this->assertTrue(Erfurt_Sparql_Query2_Var::extractName('http://example.com/foaf/bob/') == "bob");
    }
}
?>
