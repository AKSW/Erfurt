<?php
require_once 'Erfurt/TestCase.php';

class Container extends Erfurt_Sparql_Query2_ContainerHelper{
    public function getSparql() {
        return "[".implode(" , ", $this->elements)."]";
    }
    public function setElements($elements) {
        $this->elements = $elements;
    }
    public function addElement($element) {
        $this->elements[] = $element;
    }
}
class Element extends Erfurt_Sparql_Query2_ElementHelper{
    public function getSparql() {
        return spl_object_hash($this);
    }
}

class Erfurt_Sparql_Query2_ContainerHelperTest  extends Erfurt_TestCase{
    protected $container;

    public function setUp(){
        $this->container = new Container();
    }
    public function testElements(){
        $element = new Element();
        $this->container->addElement($element);
        $elements = $this->container->getElements();
        $this->assertEquals($element, $elements[0]);
        $this->assertEquals($this->container->getElement(0), $elements[0]);
        $this->assertTrue($this->container->size() == 1);
        $this->container->removeAllElements();
        $elements = $this->container->getElements();
        $this->assertTrue(empty($elements));
        $this->assertTrue($this->container->size() == 0);
    }

    public function testSetProperties(){
        $element1 = new Element();
        $element2 = new Element();
        $this->container->addElement($element1);
        $this->container->addElement($element2);

        $container2 = new Container();
        $container2->addElement($element2);
        $container2->addElement($element1);

        $this->assertTrue($this->container->equals($container2));

        //test contains-function in recursive and non-recursive mode
        $this->container->removeAllElements();
        $this->container->addElement($element1);
        $this->container->addElement($container2);
        $this->assertFalse($this->container->contains($element2, false));
        $this->assertTrue($this->container->contains($element2, true));
        
        //clean
        $this->container->removeAllElements();
    }

    public function testVars(){
        $var = new Erfurt_Sparql_Query2_Var("x");
        $var2 = new Erfurt_Sparql_Query2_Var("y");
        $this->container->addElement($var);
        $container2 = new Container();
        $container2->addElement($var2);
        $this->container->addElement($container2);

        $this->assertEquals(array($var, $var2), $this->container->getVars());
    }
}
?>
