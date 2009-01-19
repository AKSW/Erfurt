<?php
require_once 'test_base.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXml.php';

class Erfurt_Syntax_RdfParser_Adapter_RdfXmlTest extends PHPUnit_Framework_TestCase
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
        $this->_object    = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();    
    }
    
    public function testParseFromDataString()
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>
        <!DOCTYPE rdf:RDF [
          <!ENTITY dc "http://purl.org/dc/elements/1.1/">
          <!ENTITY ns "http://www.w3.org/2003/06/sw-vocab-status/ns#">
          <!ENTITY owl "http://www.w3.org/2002/07/owl#">
          <!ENTITY rdf "http://www.w3.org/1999/02/22-rdf-syntax-ns#">
          <!ENTITY rdfs "http://www.w3.org/2000/01/rdf-schema#">
          <!ENTITY wot "http://xmlns.com/wot/0.1/">
          <!ENTITY xsd "http://www.w3.org/2001/XMLSchema#">
          <!ENTITY ow "http://ns.ontowiki.net/SysOnt/">
        ]>
        <rdf:RDF xml:base="http://ns.ontowiki.net/classtest/"
                 xmlns:ct="http://ns.ontowiki.net/classtest/"
                 xmlns:dc="&dc;"
                 xmlns:ns="&ns;"
                 xmlns:owl="&owl;"
                 xmlns:rdf="&rdf;"
                 xmlns:rdfs="&rdfs;"
                 xmlns:ow="&ow;"
                 xmlns:wot="&wot;">


        	<owl:Ontology rdf:about=""
        		rdfs:label="Class Test Schema">
        	</owl:Ontology>

        	<owl:Class rdf:about="OwlClassA"
        		rdfs:label="OWL Class A" />
        	<ct:OwlClassA rdf:about="ItemOA1" rdfs:label="Item OA1" />	

          <owl:Class rdf:about="OwlClassB"
                     rdfs:label="OWL Class B" />

          <owl:Class rdf:about="OwlClassC"
                     rdfs:label="OWL Class C">
        		<rdfs:subClassOf rdf:resource="OwlClassB" />         
          </owl:Class>
        	<ct:OwlClassC rdf:about="ItemOC1" rdfs:label="Item OC1" />	

          <owl:DeprecatedClass rdf:about="OwlClassD"
                     rdfs:label="OWL Class D" />

          <owl:Class rdf:about="OwlClassE"
                     rdfs:label="OWL Class E">
        		<rdfs:subClassOf rdf:resource="OwlClassD" />         
        		<rdf:type rdf:resource="&owl;DeprecatedClass" />
          </owl:Class>
        	<ct:OwlClassE rdf:about="ItemOE1" rdfs:label="Item OE1" />	


        	<rdfs:Class rdf:about="RdfsClassA"
        		rdfs:label="RDFS Class A" />
        	<ct:RdfsClassA rdf:about="ItemRA1" rdfs:label="Item RA1" />	

          <rdfs:Class rdf:about="RdfsClassB"
                     rdfs:label="RDFS Class B" />

          <rdfs:Class rdf:about="RdfsClassC"
                     rdfs:label="RDFS Class C" >
        		<rdfs:subClassOf rdf:resource="RdfsClassB" />         
          </rdfs:Class>
        	<ct:RdfsClassC rdf:about="ItemRC1" rdfs:label="Item RC1" />	

          <ct:ImplicitClass rdf:about="ItemIC1" rdfs:label="Item IC1" />


          <rdfs:Class rdf:about="RdfsClassD"
                     rdfs:label="RDFS Class D (Hidden)">
        		<rdfs:subClassOf rdf:resource="RdfsClassB" />
        		<ow:hidden rdf:datatype="&xsd;boolean">true</ow:hidden>
          </rdfs:Class>

          <rdfs:Class rdf:about="RdfsClassE"
                     rdfs:label="RDFS Class E (Hidden)">
        		<ow:hidden rdf:datatype="&xsd;boolean">true</ow:hidden>
          </rdfs:Class>
        	<ct:RdfsClassE rdf:about="ItemRE1" rdfs:label="Item RE1" />	


          <rdfs:Class rdf:about="RdfsClassF"
                     rdfs:label="RDFS Class F" >
        		<rdfs:subClassOf rdf:resource="RdfsClassE" />
          </rdfs:Class>



        </rdf:RDF>';
        
        //$this->_object->parseFromDataString($data);
    }
}
