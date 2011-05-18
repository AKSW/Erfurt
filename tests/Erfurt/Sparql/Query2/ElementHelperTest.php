<?php
require_once 'Erfurt/TestCase.php';

if(!class_exists("Element")){
    class Element extends Erfurt_Sparql_Query2_ElementHelper{
        public function getSparql() {
            return spl_object_hash($this);
        }
    }
}
class Erfurt_Sparql_Query2_ElementHelperTest  extends Erfurt_TestCase{
    protected $element;

    public function setUp(){
        $this->element = new Element();
    }
    public function testIdentity(){
        $element2 = unserialize(serialize($this->element));
        $this->assertTrue($this->element->equals($element2));
        $element3 = new Element();
        $this->assertTrue($element2->getID() == ($element3->getID() - 1));
    }
}
?>
