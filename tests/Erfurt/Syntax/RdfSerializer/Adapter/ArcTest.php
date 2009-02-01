<?php
require_once 'test_base.php';
require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Arc.php';

class Erfurt_Syntax_RdfSerializer_Adapter_ArcTest extends PHPUnit_Framework_TestCase
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
        $this->_object = new Erfurt_Syntax_RdfSerializer_Adapter_Arc('rdfxml');    
    }
    
    public function testSerializeGraphToString()
    {
        //$this->_object->serializeGraphToString('http://3ba.se/conferences/');
        
        $this->markTestIncomplete('Not implemented yet.');
    }
    
    public function testSerializeResourceToString()
    {
        //$this->_object->serializeResourceToString('http://3ba.se/conferences/PhilippFrischmuth', 'http://3ba.se/conferences/');
        
        $this->markTestIncomplete('Not implemented yet.');
    }
    
    
}
