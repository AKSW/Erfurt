<?php

require_once 'Erfurt/TestCase.php';

class Erfurt_Store_Adapter_CompareTest extends Erfurt_TestCase {

    public function setUp() {
        
    }

    private function getAdapter() {
        $optionsRef = array(
            'dsn' => 'VOS',
            'username' => 'dba',
            'password' => 'dba');
        $optionsCand = array();
        $optionsComp = array(
            'reference' => new Erfurt_Store_Adapter_Virtuoso($optionsRef),
            'candidate' => new Erfurt_Store_Adapter_EfZendDb($optionsCand)
        );

        $adapter = new Erfurt_Store_Adapter_Sparql($options);
        return $adapter;
    }

    public function testInstantiation() {
        $adapter = $this->getAdapter();
        $this->assertTrue($adapter instanceof Erfurt_Store_Adapter_Sparql);
    }

    public function testIsModelAvailable() {
        $graphUri1 = "http://idontexist.com/";
        $graphUri2 = "http://localhost/OntoWiki/Config/";
        $adapter = $this->getAdapter();
        //return values dont need to be checked 
        //because not the result itself is relevant, but the equality of the 2
        //this is checked inside the method and a exception will be thrown in case
        $adapter->isModelAvailable($graphUri1);
        $adapter->isModelAvailable($graphUri2);
    }

}