<?php
require_once 'Erfurt/TestCase.php';

class Erfurt_Sparql_Query2_GroupGraphPatternTest  extends Erfurt_TestCase{
    protected $pattern;

    public function setUp(){
        $this->pattern = new Erfurt_Sparql_Query2_GroupGraphPattern();
    }

    public function testTripleSeprator(){
        $x = new Erfurt_Sparql_Query2_Var("x");
        $triple = new Erfurt_Sparql_Query2_Triple($x, $x, $x);
        $this->pattern->addElement($triple);
        $this->pattern->addElement($triple);
        $this->assertTrue($this->pattern->getSparql() == "{ \n".$triple->getSparql()." . \n".$triple->getSparql()." \n} \n");
    }

    public function testRemoveOptionals(){
        $x = new Erfurt_Sparql_Query2_Var("x");
        $triple = new Erfurt_Sparql_Query2_Triple($x, $x, $x);
        $optional = new Erfurt_Sparql_Query2_OptionalGraphPattern();
        $optional->addElement($triple);
        $this->pattern->addElement($optional);
        $this->pattern->removeAllOptionals();
        $elements = $this->pattern->getElements();
        $this->assertTrue(empty($elements));
    }
}
?>
