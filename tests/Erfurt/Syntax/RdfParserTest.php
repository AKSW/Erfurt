<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Syntax/RdfParser.php';

class Erfurt_Syntax_RdfParserTest extends Erfurt_TestCase
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
        $this->_object = new Erfurt_Syntax_RdfParser();    
    }
    
    public function testParseWithUrlAndRdfXml()
    {        
        $this->_object->initializeWithFormat('rdfxml');
        $url = 'http://ontowiki.googlecode.com/hg/erfurt/tests/resources/syntax/valid/conferences.rdf';
           
        $result1 = $this->_object->parse($url, Erfurt_Syntax_RdfParser::LOCATOR_URL);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXml.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();
        $result2 = $adapter->parseFromUrl($url);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithUrlAndN3()
    {   
        $this->_object->initializeWithFormat('ttl');
        $url = 'http://erfurt.ontowiki.googlecode.com/hg/tests/resources/syntax/valid/conferences.ttl';
        
        
        $result1 = $this->_object->parse($url, Erfurt_Syntax_RdfParser::LOCATOR_URL);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Turtle.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Turtle();
        $result2 = $adapter->parseFromUrl($url);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithUrlAndRdfJson()
    {
        $this->_object->initializeWithFormat('rdfjson');
        $url = 'http://erfurt.ontowiki.googlecode.com/hg/tests/resources/syntax/valid/conferences.json';
        
        
        $result1 = $this->_object->parse($url, Erfurt_Syntax_RdfParser::LOCATOR_URL);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJson.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();
        $result2 = $adapter->parseFromUrl($url);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithFilenameAndRdfXml()
    {
        $this->_object->initializeWithFormat('rdfxml');
        $filename = 'resources/syntax/valid/conferences.rdf';
        
        $result1 = $this->_object->parse($filename, Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXml.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();
        $result2 = $adapter->parseFromFilename($filename);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithFilenameAndN3()
    {   
        $this->_object->initializeWithFormat('ttl');
        $filename = 'resources/syntax/valid/conferences.ttl';
        
        $result1 = $this->_object->parse($filename, Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Turtle.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Turtle();
        $result2 = $adapter->parseFromFilename($filename);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithFilenameAndRdfJson()
    {
        $this->_object->initializeWithFormat('rdfjson');
        $filename = 'resources/syntax/valid/conferences.json';
        
        $result1 = $this->_object->parse($filename, Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJson.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();
        $result2 = $adapter->parseFromFilename($filename);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithDataStringAndRdfXml()
    {
        $this->_object->initializeWithFormat('rdfxml');
        
        $dataString = '<?xml version="1.0" encoding="UTF-8" ?>
        <!DOCTYPE rdf:RDF [
            <!ENTITY rdf "http://www.w3.org/1999/02/22-rdf-syntax-ns#">
            <!ENTITY owl "http://www.w3.org/2002/07/owl#">
            <!ENTITY rdfs "http://www.w3.org/2000/01/rdf-schema#">
            <!ENTITY conferences "http://3ba.se/conferences/">
        ]>
        <rdf:RDF xml:base="&conferences;" xmlns:rdf="&rdf;" xmlns:owl="&owl;" xmlns:rdfs="&rdfs;">
        <owl:Ontology rdf:about="&conferences;" rdfs:label="Conference Model">
            <rdfs:comment>Demo Model about Conferences and Semantic Web People</rdfs:comment>
        </owl:Ontology>
        </rdf:RDF>';
        
        $result1 = $this->_object->parse($dataString, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXml.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();
        $result2 = $adapter->parseFromDataString($dataString);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithDataStringAndN3()
    {
        $this->_object->initializeWithFormat('ttl');
        
        $dataString = '<http://3ba.se/conferences/> a <Ontology> ;
                                     <label> "Conference Model" ;
                                     <comment> "Demo Model about Conferences and Semantic Web People" .';
        
        $result1 = $this->_object->parse($dataString, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Turtle.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Turtle();
        $result2 = $adapter->parseFromDataString($dataString);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithDataStringAndRdfJson()
       {
           $this->_object->initializeWithFormat('rdfjson');

           $dataString = '{"http:\/\/3ba.se\/conferences\/":{"http:\/\/www.w3.org\/1999\/02\/22-rdf-syntax-ns#type":[{"type":"uri","value":"http:\/\/www.w3.org\/2002\/07\/owl#Ontology"}],"http:\/\/www.w3.org\/2000\/01\/rdf-schema#label":[{"type":"literal","value":"Conference Model"}],"http:\/\/www.w3.org\/2000\/01\/rdf-schema#comment":[{"type":"literal","value":"Demo Model about Conferences and Semantic Web People"}]}}';

           $result1 = $this->_object->parse($dataString, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);

           require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJson.php';
           $adapter = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();
           $result2 = $adapter->parseFromDataString($dataString);

           $this->assertEquals($result1, $result2);
       }
}
