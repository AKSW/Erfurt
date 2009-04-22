<?php
require_once 'test_base.php';
require_once 'Erfurt/Syntax/RdfSerializer.php';

class Erfurt_Syntax_RdfSerializerTest extends PHPUnit_Framework_TestCase
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
        $this->_object = new Erfurt_Syntax_RdfSerializer();    
    }
    
    public function testRdfSerializerWithFormat()
    {
        $positiveFormats = array('rdfxml', 'xml', 'rdf', 'turtle', 'ttl', 'nt', 'ntriple',
            'json', 'rdfjson', 'RDFXML', 'rdfXML', 'RdF', 'TuRTle');
            
        $negativeFormats = array('noVALIDformat', '123456789', 'rdf-xml', 'n 3', 'andsoon');
        
        foreach ($positiveFormats as $format) {
            try {
                $object = Erfurt_Syntax_RdfSerializer::rdfSerializerWithFormat($format);
                
                if (!($object instanceof Erfurt_Syntax_RdfSerializer)) {
                    $this->fail('Object initialization failed where it should not fail.');
                }
            } catch (Exception $e) {
                $this->fail('Object initialization failed where it should not fail.');
            }
        }
        
        foreach ($negativeFormats as $format) {
            try {
                $object = Erfurt_Syntax_RdfSerializer::rdfSerializerWithFormat($format);
                
                // We should not reach this point.
                $this->fail('Object initialization should fail.');
            } catch (Exception $e) {
                
            }
        }
    }
    
    public function testinitializeWithFormat()
    {
        $positiveFormats = array('rdfxml', 'xml', 'rdf', 'turtle', 'ttl', 'nt', 'ntriple',
            'json', 'rdfjson', 'RDFXML', 'rdfXML', 'RdF', 'TuRTle');
            
        $negativeFormats = array('noVALIDformat', '123456789', 'rdf-xml', 'n 3', 'andsoon');
        
        foreach ($positiveFormats as $format) {
            try {
                $object = new Erfurt_Syntax_RdfSerializer();
                $object->initializeWithFormat($format);
                
                if (!($object instanceof Erfurt_Syntax_RdfSerializer)) {
                    $this->fail('Object initialization failed where it should not fail.');
                }
            } catch (Exception $e) {
                $this->fail('Object initialization with format failed where it should not fail.');
            }
        }
        
        foreach ($negativeFormats as $format) {
            try {
                $object = new Erfurt_Syntax_RdfSerializer();
                $object->initializeWithFormat($format);
                
                // We should not reach this point.
                $this->fail('Initialization with format should fail.');
            } catch (Exception $e) {
                
            }
        }
    }
    
    /*public function testSerializeGraphToStringWithRdfXml()
    {
        $this->_object->initializeWithFormat('rdfxml');
        $result1 = $this->_object->serializeGraphToString('http://3ba.se/conferences/');
        
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfXml.php';
        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml();
        $result2 = $adapter->serializeGraphToString('http://3ba.se/conferences/');
        
        $this->assertEquals($result1, $result2);
    }*/
    
    /*public function testSerializeResourceToStringWithRdfXml()
    {
        $this->_object->initializeWithFormat('rdfxml');
        $result1 = $this->_object->serializeResourceToString('http://3ba.se/conferences/PhilippFrischmuth', 
                        'http://3ba.se/conferences/');
        
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfXml.php';
        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml();
        $result2 = $adapter->serializeResourceToString('http://3ba.se/conferences/PhilippFrischmuth', 
                        'http://3ba.se/conferences/');
        
        $this->assertEquals($result1, $result2);
    }*/
    
    /*public function testSerializeGraphToStringWithRdfJson()
    {
        $this->_object->initializeWithFormat('rdfjson');
        $result1 = $this->_object->serializeGraphToString('http://3ba.se/conferences/');
        
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfJson.php';
        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfJson();
        $result2 = $adapter->serializeGraphToString('http://3ba.se/conferences/');
        
        $this->assertEquals($result1, $result2);
    }*/
    
    /*public function testSerializeResourceToStringWithRdfJson()
    {
        $this->_object->initializeWithFormat('rdfjson');
        $result1 = $this->_object->serializeResourceToString('http://3ba.se/conferences/PhilippFrischmuth', 
                        'http://3ba.se/conferences/');
        
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfJson.php';
        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfJson();
        $result2 = $adapter->serializeResourceToString('http://3ba.se/conferences/PhilippFrischmuth', 
                        'http://3ba.se/conferences/');
        
        $this->assertEquals($result1, $result2);
    }*/
    
    /*public function testSerializeGraphToStringWithN3()
    {
        $this->_object->initializeWithFormat('ttl');
        $result1 = $this->_object->serializeGraphToString('http://3ba.se/conferences/');
        
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Turtle.php';
        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_Turtle();
        $result2 = $adapter->serializeGraphToString('http://3ba.se/conferences/');
        
        $this->assertEquals($result1, $result2);
    }*/
    
    /*public function testSerializeResourceToStringWithN3()
    {
        $this->_object->initializeWithFormat('ttl');
        $result1 = $this->_object->serializeResourceToString('http://3ba.se/conferences/PhilippFrischmuth', 
                        'http://3ba.se/conferences/');
        
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Turtle.php';
        $adapter = new Erfurt_Syntax_RdfSerializer_Adapter_Turtle();
        $result2 = $adapter->serializeResourceToString('http://3ba.se/conferences/PhilippFrischmuth', 
                        'http://3ba.se/conferences/');
        
        $this->assertEquals($result1, $result2);
    }*/
}
