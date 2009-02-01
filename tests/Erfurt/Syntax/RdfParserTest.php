<?php
require_once 'test_base.php';
require_once 'Erfurt/Syntax/RdfParser.php';

class Erfurt_Syntax_RdfParserTest extends PHPUnit_Framework_TestCase
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
// TODO use a url, that is available on every machine
        $this->markTestIncomplete();return;
        
        $this->_object->initializeWithFormat('rdfxml');
        $url = 'http://localhost/ontowiki_1_0/ontowiki/src/model/export/f/rdfxml?m=http%3A%2F%2F3ba.se%2Fconferences%2F';
        
        
        $result1 = $this->_object->parse($url, Erfurt_Syntax_RdfParser::LOCATOR_URL);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Arc('rdfxml');
        $result2 = $adapter->parseFromUrl($url);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithUrlAndN3()
    {
// TODO use a url, that is available on every machine
        $this->markTestIncomplete();return;
        
        $this->_object->initializeWithFormat('n3');
        $url = 'http://localhost/ontowiki_1_0/ontowiki/src/model/export/f/n3?m=http%3A%2F%2F3ba.se%2Fconferences%2F';
        
        
        $result1 = $this->_object->parse($url, Erfurt_Syntax_RdfParser::LOCATOR_URL);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Arc('turtle');
        $result2 = $adapter->parseFromUrl($url);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithUrlAndRdfJson()
    {
// TODO use a url, that is available on every machine
        $this->markTestIncomplete();return;
        
        $this->_object->initializeWithFormat('rdfjson');
        $url = 'http://localhost/ontowiki_1_0/ontowiki/src/model/export/f/rdfjson?m=http%3A%2F%2F3ba.se%2Fconferences%2F';
        
        
        $result1 = $this->_object->parse($url, Erfurt_Syntax_RdfParser::LOCATOR_URL);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJson.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();
        $result2 = $adapter->parseFromUrl($url);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithFilenameAndRdfXml()
    {
        $this->_object->initializeWithFormat('rdfxml');
        $filename = 'resources/syntax/conferences.rdf';
        
        $result1 = $this->_object->parse($filename, Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Arc('rdfxml');
        $result2 = $adapter->parseFromFilename($filename);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithFilenameAndN3()
    {
        $this->_object->initializeWithFormat('n3');
        $filename = 'resources/syntax/conferences.n3';
        
        $result1 = $this->_object->parse($filename, Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Arc('turtle');
        $result2 = $adapter->parseFromFilename($filename);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithFilenameAndRdfJson()
    {
        $this->_object->initializeWithFormat('rdfjson');
        $filename = 'resources/syntax/conferences.json';
        
        $result1 = $this->_object->parse($filename, Erfurt_Syntax_RdfParser::LOCATOR_FILE);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJson.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();
        $result2 = $adapter->parseFromFilename($filename);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithDataStringAndRdfXml()
    {
        $this->_object->initializeWithFormat('rdfxml');
        
        $dataString = '?xml version="1.0" encoding="UTF-8" ?>
        <!DOCTYPE rdf:RDF [
            <!ENTITY rdf "http://www.w3.org/1999/02/22-rdf-syntax-ns#">
            <!ENTITY owl "http://www.w3.org/2002/07/owl#">
            <!ENTITY rdfs "http://www.w3.org/2000/01/rdf-schema#">
        ]>
        <rdf:RDF xml:base="&conferences;" xmlns:rdf="&rdf;" xmlns:owl="&owl;" xmlns:rdfs="&rdfs;">
        <owl:Ontology rdf:about="&conferences;" rdfs:label="Conference Model">
            <rdfs:comment>Demo Model about Conferences and Semantic Web People</rdfs:comment>
        </owl:Ontology>
        </rdf:RDF>';
        
        $result1 = $this->_object->parse($dataString, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Arc('rdfxml');
        $result2 = $adapter->parseFromDataString($dataString);
        
        $this->assertEquals($result1, $result2);
    }
    
    public function testParseWithDataStringAndN3()
    {
        $this->_object->initializeWithFormat('n3');
        
        $dataString = '<http://3ba.se/conferences/> rdf:type ns0:Ontology ;
                                     ns1:label "Conference Model" ;
                                     ns1:comment "Demo Model about Conferences and Semantic Web People" .';
        
        $result1 = $this->_object->parse($dataString, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
        
        require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';
        $adapter = new Erfurt_Syntax_RdfParser_Adapter_Arc('turtle');
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
