<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXml.php';

class Erfurt_Syntax_RdfParser_Adapter_RdfXmlTest extends Erfurt_TestCase
{
    const SYNTAX_TEST_DIR = 'resources/syntax/valid/';
    const SYNTAX_INVALID_TEST_DIR = 'resources/syntax/invalid/';
    
    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_RdfXml
     * @access protected
     */
    protected $_object;
    
    protected $_xmlString = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->_object    = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();
        
        $this->_xmlString = '<?xml version="1.0" encoding="UTF-8"?>
        <!DOCTYPE rdf:RDF [
          <!ENTITY owl "http://www.w3.org/2002/07/owl#">
          <!ENTITY rdf "http://www.w3.org/1999/02/22-rdf-syntax-ns#">
          <!ENTITY rdfs "http://www.w3.org/2000/01/rdf-schema#">
        ]>
        <rdf:RDF xml:base="http://ns.ontowiki.net/unittest/xmlparser/"
                 xmlns:owl="&owl;"
                 xmlns:rdf="&rdf;"
                 xmlns:rdfs="&rdfs;">';
    }
    
    public function testParseEmpty()
    {
        $xml = $this->_getRdfXmlString('');

        $result = $this->_object->parseFromDataString($xml);

        $this->assertEquals(0, count($result));
    }

    public function testParseBaseWithEmptyAbout()
    {
        $xml = $this->_getRdfXmlString('<owl:Ontology rdf:about=""></owl:Ontology>');

        $result = $this->_object->parseFromDataString($xml);

        $this->assertEquals(1, count($result));
        $this->assertTrue(isset($result['http://ns.ontowiki.net/unittest/xmlparser/']));
    }

    public function testParseEmptyOwlOntologyWithAboutAndLabel()
    {
        $xml = $this->_getRdfXmlString('<owl:Ontology rdf:about="http://example.org/" rdfs:label="Test Label" />');

        $result = $this->_object->parseFromDataString($xml);

        $this->assertEquals(1, count($result));

        $this->assertTrue(
            $result['http://example.org/']['http://www.w3.org/1999/02/22-rdf-syntax-ns#type'][0]['value'] 
            === 'http://www.w3.org/2002/07/owl#Ontology');

        $this->assertTrue(
            $result['http://example.org/']['http://www.w3.org/1999/02/22-rdf-syntax-ns#type'][0]['type'] 
            === 'uri');

        $this->assertTrue(
            $result['http://example.org/']['http://www.w3.org/2000/01/rdf-schema#label'][0]['value'] 
            === 'Test Label');

        $this->assertTrue(
            $result['http://example.org/']['http://www.w3.org/2000/01/rdf-schema#label'][0]['type'] 
            === 'literal');
    }

    public function testParseTagWithoutAboutAndNodeId()
    {
        $xml = $this->_getRdfXmlString('<owl:Ontology rdf:about=""><rdfs:comment>Test comment.</rdfs:comment></owl:Ontology>');

        $result = $this->_object->parseFromDataString($xml);

        // Only one subject
        $this->assertEquals(1, count($result));

        $this->assertTrue(
            $result['http://ns.ontowiki.net/unittest/xmlparser/']
            ['http://www.w3.org/1999/02/22-rdf-syntax-ns#type'][0]['value'] 
            === 'http://www.w3.org/2002/07/owl#Ontology');

        $this->assertTrue(
            $result['http://ns.ontowiki.net/unittest/xmlparser/']
            ['http://www.w3.org/1999/02/22-rdf-syntax-ns#type'][0]['type'] 
            === 'uri');

        $this->assertTrue(
            $result['http://ns.ontowiki.net/unittest/xmlparser/']
            ['http://www.w3.org/2000/01/rdf-schema#comment'][0]['value'] 
            === 'Test comment.');

        $this->assertTrue(
            $result['http://ns.ontowiki.net/unittest/xmlparser/']
            ['http://www.w3.org/2000/01/rdf-schema#comment'][0]['type'] 
            === 'literal');
    }

    public function testEmptyRdfDescriptionWithAbout()
    {
        $xml = $this->_getRdfXmlString('<rdf:Description rdf:about="http://example.org/" />');

        $result = $this->_object->parseFromDataString($xml);

        $this->assertEquals(0, count($result));
    }

    public function testRdfDescriptionWithAbout()
    {
        $xml = $this->_getRdfXmlString('<rdf:Description rdf:about="http://example.org/"><rdfs:label>TTT</rdfs:label></rdf:Description>');

        $result = $this->_object->parseFromDataString($xml);

        $this->assertEquals(1, count($result));

        $this->assertTrue(
            $result['http://example.org/']
            ['http://www.w3.org/2000/01/rdf-schema#label'][0]['value'] 
            === 'TTT');

        $this->assertTrue(
            $result['http://example.org/']
            ['http://www.w3.org/2000/01/rdf-schema#label'][0]['type'] 
            === 'literal');
    }

    public function testRdfDescriptionNodeGeneration()
    {
        $xml = $this->_getRdfXmlString('<rdf:Description><rdfs:label>TTT Test 2.</rdfs:label></rdf:Description>');

        $result = $this->_object->parseFromDataString($xml);

        $this->assertEquals(1, count($result));

        $keys = array_keys($result);

        $this->assertTrue(substr($keys[0], 0, 2) === '_:');
    }

    public function testElementNodeGeneration()
    {
        $xml = $this->_getRdfXmlString('<owl:Class rdfs:label="example" />');
    #var_dump($xml);
        $result = $this->_object->parseFromDataString($xml);
    }

    public function testUriLiteral()
    {
        $xml = $this->_getRdfXmlString('<owl:Class rdfs:label="example"><rdfs:comment>http://aksw.org/images/jpegPhoto.php?name=sn&amp;value=Dietzold</rdfs:comment></owl:Class>');
    #var_dump($xml);
        $result = $this->_object->parseFromDataString($xml);
    }

    public function testParsingRdfXmlWithEntities()
    {
        $xml = $this->_getRdfXmlString('<owl:Class rdfs:label="example &lt;1234&gt;" />');
        $result = $this->_object->parseFromDataString($xml);

        $this->assertEquals('example <1234>', $result['_:node1'][EF_RDFS_LABEL][0]['value']);
    }

    public function testParsingRdfXmlWithCData()
    {
        $xml = $this->_getRdfXmlString('<owl:Class><rdfs:label>example 12345 <![CDATA[<12345>]]></rdfs:label></owl:Class>');
        $result = $this->_object->parseFromDataString($xml);

        $this->assertEquals('example 12345 <12345>', $result['_:node1'][EF_RDFS_LABEL][0]['value']);
    }

    /**
     * @expectedException Erfurt_Syntax_RdfParserException
     */
    public function testParsingRdfXmlWithoutEntitiesUsed()
    {
        $xml = $this->_getRdfXmlString('<owl:Class rdfs:label="example <1234>" />');
        $result = $this->_object->parseFromDataString($xml);
    }

    /**
     * @dataProvider providerTestParseFromDataString
     */
    public function testParseFromDataString($fileName)
    {
        $fileHandle = fopen($fileName, 'r');
        $data = fread($fileHandle, filesize($fileName));
        fclose($fileHandle);

        try {
            $result = $this->_object->parseFromDataString($data);
            $this->assertTrue(is_array($result));
        } catch (Erfurt_Syntax_RdfParserException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @dataProvider providerTestParseFromInvalidDataString
     */
    public function testParseFromInvalidDataString($fileName)
    {
        $fileHandle = fopen($fileName, 'r');
        $data = fread($fileHandle, filesize($fileName));
        fclose($fileHandle);

        try {
            $result = $this->_object->parseFromDataString($data);

            $this->fail('Parser test should fail.');
        } catch (Erfurt_Syntax_RdfParserException $e) {

        }
    }

    public function providerTestParseFromDataString()
    {
        $dataArray = array();

        if (is_readable(self::SYNTAX_TEST_DIR)) {
            $dirIterator = new DirectoryIterator(self::SYNTAX_TEST_DIR);

            foreach ($dirIterator as $file) {
                if (!$file->isDot() && !$file->isDir()) {
                    $fileName = $file->getFileName();

                    if ((substr($fileName, -4) === '.rdf') && is_readable(self::SYNTAX_TEST_DIR . $fileName)) {
                        $dataArray[] = array((self::SYNTAX_TEST_DIR . $fileName));
                    }
                }
            }
        }

        return $dataArray;
    }

    public function providerTestParseFromInvalidDataString()
    {
        $dataArray = array();

        if (is_readable(self::SYNTAX_INVALID_TEST_DIR)) {
            $dirIterator = new DirectoryIterator(self::SYNTAX_INVALID_TEST_DIR);

            foreach ($dirIterator as $file) {
                if (!$file->isDot() && !$file->isDir()) {
                    $fileName = $file->getFileName();

                    if ((substr($fileName, -4) === '.rdf') && is_readable(self::SYNTAX_INVALID_TEST_DIR . $fileName)) {
                        $dataArray[] = array((self::SYNTAX_INVALID_TEST_DIR . $fileName));
                    }
                }
            }
        }

        return $dataArray;
    }

    public function testParseFromUrlWithConferenceModelFromTrunk()
    {
        $url = 'http://ontowiki.googlecode.com/svn/trunk/models/Conferences/conferences.rdf';

        try {
            $result = $this->_object->parseFromUrl($url);
        } catch (Erfurt_Syntax_RdfParserException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    public function testParseRecursiveEntity()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <!DOCTYPE rdf:RDF [
          <!ENTITY location "http://www.w3.org/2002/07/owl">
          <!ENTITY rdf "http://www.w3.org/1999/02/22-rdf-syntax-ns#">
          <!ENTITY rdfs "http://www.w3.org/2000/01/rdf-schema#">
          <!ENTITY xsd "http://www.w3.org/2001/XMLSchema#">
          <!ENTITY dc "http://purl.org/dc/elements/1.1/">
          <!ENTITY grddl "http://www.w3.org/2003/g/data-view#">
          <!ENTITY owl "&location;#" >
        ]>
        
        <rdf:RDF xml:base="&location;"
                 xmlns:conferences="&location;"
                 xmlns:owl="&owl;"
                 xmlns:rdf="&rdf;">
            
            <owl:Class rdf:about="#test" />
        </rdf:RDF>';
        
        try {
            $result = $this->_object->parseFromDataString($xml);
            $this->assertEquals('http://www.w3.org/2002/07/owl#Class', $result['http://www.w3.org/2002/07/owl#test'][EF_RDF_TYPE][0]['value']);
        } catch (Erfurt_Syntax_RdfParserException $e) {
            $this->fail($e->getMessage());
        }
    }
    
    protected function _getRdfXmlString($innerXml)
    {
        return $this->_xmlString . $innerXml . '</rdf:RDF>';
    }    
}
