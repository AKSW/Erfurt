<?php

/**
 * @group Integration
 */
class Erfurt_Store_Adapter_CompareIntegrationTest extends Erfurt_TestCase {

    private $_virtuosoOptions = null;
    private $_zendDbOptions   = null;

    public function setUp() 
    {
/*
        $this->markTestNeedsVirtuoso();
        $this->markTestNeedsZendDb();
        
        $config = Erfurt_App::getInstance()->getConfig();
        
        $this->_virtuosoOptions = $config->store->virtuoso;
        $this->_zendDbOptions = $config->store->zenddb;
*/
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
// TODO fix this... currently returns SPARQL adapter?!
        $adapter = new Erfurt_Store_Adapter_Sparql($options);
        return $adapter;
    }

    public function testInstantiation() 
    {
        $this->markTestIncomplete();

        $adapter = $this->getAdapter();        
        $this->assertTrue($adapter instanceof Erfurt_Store_Adapter_Sparql);
    }

    public function testIsModelAvailable() 
    {
        $this->markTestIncomplete();
    
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
