<?php
class Erfurt_Syntax_RdfSerializerTest extends Erfurt_TestCase
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
    
    public function testRdfSerializerWithValidFormats()
    {
        $positiveFormats = array('rdfxml', 'xml', 'rdf', 'turtle', 'ttl', 'nt', 'ntriple',
            'json', 'rdfjson', 'RDFXML', 'rdfXML', 'RdF', 'TuRTle', 'ntriples');

        foreach ($positiveFormats as $format) {
            try {
                $object = Erfurt_Syntax_RdfSerializer::rdfSerializerWithFormat($format);
                
                $this->assertInstanceOf('Erfurt_Syntax_RdfSerializer', $object);
            } catch (Exception $e) {
                $this->fail($e->getMessage());
            }
        }
    }
    
    public function testRdfSerializerWithInvalidFormats()
    {
        $negativeFormats = array('noVALIDformat', '123456789', 'rdf-xml', 'n 3', 'andsoon');
        
        $failCount = 0;
        foreach ($negativeFormats as $format) {
            try {
                $object = Erfurt_Syntax_RdfSerializer::rdfSerializerWithFormat($format);
                
                // We should not reach this point.
                $this->fail('Object initialization should fail.');
            } catch (Exception $e) {
                $failCount++;
            }
        }
        
        $this->assertEquals(count($negativeFormats), $failCount);
    }
    
    public function testInitializeWithValidFormats()
    {
        $positiveFormats = array('rdfxml', 'xml', 'rdf', 'turtle', 'ttl', 'nt', 'ntriple',
            'json', 'rdfjson', 'RDFXML', 'rdfXML', 'RdF', 'TuRTle', 'ntriples');

        foreach ($positiveFormats as $format) {
            try {
                $object = new Erfurt_Syntax_RdfSerializer();
                $object->initializeWithFormat($format);
                
                $this->assertInstanceOf('Erfurt_Syntax_RdfSerializer', $object);
            } catch (Exception $e) {
                $this->fail($e->getMessage());
            }
        }
    }
    
    public function testInitializeWithInvalidFormats()
    {
        $negativeFormats = array('noVALIDformat', '123456789', 'rdf-xml', 'n 3', 'andsoon');

        $failCount = 0;
        foreach ($negativeFormats as $format) {
            try {
                $object = new Erfurt_Syntax_RdfSerializer();
                $object->initializeWithFormat($format);
                
                // We should not reach this point.
                $this->fail('Initialization with format should fail.');
            } catch (Exception $e) {
                $failCount++;
            }
        }
        
        $this->assertEquals(count($negativeFormats), $failCount);
    }

}

