<?php
class Erfurt_Syntax_RdfSerializer_Adapter_RdfJsonIntegrationTest extends Erfurt_TestCase
{
    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_RdfXml
     * @access protected
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->_object = new Erfurt_Syntax_RdfSerializer_Adapter_RdfJson();    
    }
    
    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testSerializeGraphToString($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        
        $result = $this->_object->serializeGraphToString('http://localhost/OntoWiki/Config/');
        $this->assertTrue(is_string($result));
    }
    
    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testSerializeResourceToString($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);
        $this->authenticateDbUser();
        
        $r = 'http://localhost/OntoWiki/Config/';
        $result = $this->_object->serializeResourceToString($r, $r);
        $this->assertTrue(is_string($result));
    }
}
