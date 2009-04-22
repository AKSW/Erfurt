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
    
    public function testParseEncodingUtf8()
    {
        // TODO
        $this->markTestIncomplete();
    }
    
    public function testParseEncodingIso88591()
    {
        // TODO
        $this->markTestIncomplete();
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
    
    public function testComplex()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <!DOCTYPE rdf:RDF [
          <!ENTITY conferences "http://3ba.se/conferences/">
          <!ENTITY owl "http://www.w3.org/2002/07/owl#">
          <!ENTITY rdf "http://www.w3.org/1999/02/22-rdf-syntax-ns#">
          <!ENTITY rdfs "http://www.w3.org/2000/01/rdf-schema#">
          <!ENTITY wgs84_pos "http://www.w3.org/2003/01/geo/wgs84_pos#">
          <!ENTITY xsd "http://www.w3.org/2001/XMLSchema#">
          <!ENTITY foaf "http://xmlns.com/foaf/0.1/">
          <!ENTITY doap "http://usefulinc.com/ns/doap#">
          <!ENTITY swrc "http://swrc.ontoware.org/ontology#">
          <!ENTITY dc "http://purl.org/dc/elements/1.1/">
        ]>
        <rdf:RDF xml:base="&conferences;"
                 xmlns:conferences="&conferences;"
                 xmlns:owl="&owl;"
                 xmlns:swrc="&swrc;"
                 xmlns:dc="&dc;"
                 xmlns:doap="&doap;"
                 xmlns:rdf="&rdf;"
                 xmlns:rdfs="&rdfs;"
                 xmlns:foaf="&foaf;"
                 xmlns:wgs84_pos="&wgs84_pos;">

        <!-- Ontology Information -->
          <owl:Ontology rdf:about="http://3ba.se/conferences/"
                        rdfs:label="Conference Model">
            <rdfs:comment>Demo Model about Conferences and Semantic Web People</rdfs:comment>
          </owl:Ontology>

        <!-- Classes -->
          <owl:Class rdf:about="&swrc;Event"
                     rdfs:label="Event"/>

          <owl:Class rdf:about="&swrc;Conference" rdfs:label="Conference">
            <rdfs:subClassOf>
              <owl:Class rdf:about="&swrc;Event"/>
            </rdfs:subClassOf>
          </owl:Class>
          <owl:Class rdf:about="&swrc;Workshop" rdfs:label="Workshop">
            <rdfs:subClassOf>
              <owl:Class rdf:about="&swrc;Event"/>
            </rdfs:subClassOf>
          </owl:Class>

          <owl:Class rdf:about="&swrc;Journal"
                     rdfs:label="Journal"/>
          <owl:Class rdf:about="&swrc;Person"
                     rdfs:label="Person"/>
          <owl:Class rdf:about="&swrc;Topic"
                     rdfs:label="Topic"/>

        <!-- Datatypes -->
          <rdfs:Datatype rdf:about="&xsd;anyURI"/>
          <rdfs:Datatype rdf:about="&xsd;date"/>
          <rdfs:Datatype rdf:about="&xsd;string"/>

        <!-- Annotation Properties -->
          <owl:AnnotationProperty rdf:about="&rdfs;comment" rdfs:label="comment"/>
          <owl:AnnotationProperty rdf:about="&rdfs;label" rdfs:label="label"/>

        <!-- Datatype Properties -->
          <owl:DatatypeProperty rdf:about="URL" rdfs:label="URL"/>
          <owl:DatatypeProperty rdf:about="abstractsDue"
                                rdfs:label="abstracts due">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;date"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="acceptanceNotification"
                                rdfs:label="acceptance Notification">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;date"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="affiliation"
                                rdfs:label="affiliation">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Person"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="audience"
                                rdfs:label="audience">
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="camera-readySubmission"
                                rdfs:label="camera-ready Submission">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;date"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="conferenceChair"
                                rdfs:label="Chair">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="conferenceFee"
                                rdfs:label="Fee">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="conferenceFeeLate"
                                rdfs:label="Fee (late)">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="conferenceFeeStudent"
                                rdfs:label="Fee (student)">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="conferenceFeeStudentLate"
                                rdfs:label="Fee (student, late)">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="country" rdfs:label="Country" />
          <owl:DatatypeProperty rdf:about="end"
                                rdfs:label="end">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:comment rdf:resource="end"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;date"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="interval"
                                rdfs:label="Interval">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="issn"
                                rdfs:label="ISSN">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="localChair"
                                rdfs:label="Chair (local)">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdf:type rdf:resource="&owl;ObjectProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="logo"
                                rdfs:label="Logo">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:range rdf:resource="&xsd;anyURI"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="pcMember"
                                rdfs:label="PC Member">
            <rdf:type rdf:resource="&owl;ObjectProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="place"
                                rdfs:label="Place">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="preRegistration"
                                rdfs:label="preRegistration">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;anyURI"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="price" />
          <owl:DatatypeProperty rdf:about="programChair"
                                rdfs:label="Chair (Program)">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="programmeCommittee"
                                rdfs:label="Programme Committee">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;string"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="publicityChair"
                                rdfs:label="Chair (Publicity)">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdf:type rdf:resource="&owl;ObjectProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="start"
                                rdfs:label="start">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;date"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="submissionsDue"
                                rdfs:label="Submissions due">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:range rdf:resource="&xsd;date"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="&swrc;title"
                                rdfs:label="Title">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Conference"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="&wgs84_pos;lat"
                                rdfs:label="latitude">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Event"/>
          </owl:DatatypeProperty>

          <owl:DatatypeProperty rdf:about="&wgs84_pos;long"
                                rdfs:label="longitude">
            <rdf:type rdf:resource="&owl;FunctionalProperty"/>
            <rdfs:domain rdf:resource="&swrc;Event"/>
          </owl:DatatypeProperty>

        <!-- Object Properties -->
          <owl:ObjectProperty rdf:about="inConjunctionWith"
                              rdfs:comment="inConjunctionWith">
            <rdfs:domain rdf:resource="&swrc;Conference"/>
            <rdfs:label rdf:datatype="&xsd;string">inConjunctionWith</rdfs:label>
            <rdfs:range rdf:resource="&swrc;Event"/>
          </owl:ObjectProperty>

          <owl:ObjectProperty rdf:about="&swrc;isAbout"
                              rdfs:label="topics">
            <rdfs:domain rdf:resource="&swrc;Event"/>
            <rdfs:range rdf:resource="&swrc;Topic"/>
          </owl:ObjectProperty>

          <owl:FunctionalProperty rdf:about="http://xmlns.com/foaf/0.1/currentProject">
            <rdf:type rdf:resource="&owl;ObjectProperty"/>
            <rdfs:comment>http://xmlns.com/foaf/0.1/currentProject</rdfs:comment>
            <rdfs:label rdf:datatype="&xsd;string">current Project</rdfs:label>
          </owl:FunctionalProperty>

        <!-- Instances -->
          <swrc:Conference rdf:about="AIMSA2006" swrc:year="2006"
                                  rdfs:label="AIMSA2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://aimsa2006.inrialpes.fr/</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-06-10</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-06-30</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-09-15</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Varna, Bulgaria</conferences:place>
            <conferences:price rdf:datatype="&xsd;integer">300</conferences:price>
            <conferences:start rdf:datatype="&xsd;date">2006-09-13</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-04-15</conferences:submissionsDue>
            <swrc:title rdf:datatype="&xsd;string">12th International Conference on Artificial Intelligence: Methodology, Systems, Applications</swrc:title>
            <wgs84_pos:lat xml:lang="de">43.206667</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">27.918889</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="AMCIS2006" swrc:year="2006"
                                  rdfs:label="AMCIS2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://amcis2006.aisnet.org</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-08-06</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://amcis2006.aisnet.org/MEMO%20LOGO%20C%20red.jpg</conferences:logo>
            <conferences:place xml:lang="en">Acapulco, México</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-08-04</conferences:start>
            <swrc:title rdf:datatype="&xsd;string">12th Americas Conference on Information Systems</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">16.85</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-99.92</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="AbrahamBernstein"
                              conferences:affiliation="University of Zurich"
                              conferences:country="Switzerland"
                              rdfs:label="Abraham Bernstein"/>
          <swrc:Person rdf:about="AchilleVarzi"
                              conferences:country="United States"
                              rdfs:label="Achille Varzi">
            <conferences:affiliation>Department of Philosophy, Columbia University</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="AlainLeger"
                              conferences:country="France"
                              rdfs:label="Alain Leger">
            <conferences:affiliation rdf:datatype="&xsd;string">France  Telecom</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="AldoGangemi"
                              conferences:country="Italy"
                              rdfs:label="Aldo Gangemi">
            <conferences:affiliation rdf:datatype="&xsd;string">CNR</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="AleksanderPivk"
                              conferences:affiliation="J. Stefan Institute"
                              conferences:country="Slovenia"
                              rdfs:label="Aleksander Pivk"/>
          <swrc:Person rdf:about="AlessandroLenci"
                              conferences:affiliation="University of Pisa"
                              conferences:country="Italy"
                              rdfs:label="Alessandro Lenci"/>
          <swrc:Person rdf:about="AlexBorgida"
                              conferences:affiliation="Rutgers University"
                              conferences:country="United States"
                              rdfs:label="Alex Borgida"/>
          <swrc:Person rdf:about="AlexanderLoeser"
                              conferences:affiliation="TU Berlin"
                              conferences:country="Germany"
                              rdfs:label="Alexander Loeser"/>
          <swrc:Person rdf:about="AmitSheth"
                              conferences:affiliation="University of Georgia and Semagix"
                              conferences:country="United States"
                              rdfs:label="Amit Sheth"/>
          <swrc:Person rdf:about="AndreasAbecker"
                              conferences:affiliation="FZI Karlsruhe"
                              conferences:country="Germany"
                              rdfs:label="Andreas Abecker"/>
          <swrc:Person rdf:about="AndreasEberhart"
                              conferences:affiliation="Hewlett Packard"
                              conferences:country="Germany"
                              rdfs:label="Andreas Eberhart"/>
          <swrc:Person rdf:about="AndreasHotho"
                              conferences:affiliation="University of Kassel"
                              conferences:country="Germany"
                              rdfs:label="Andreas Hotho"/>
          <swrc:Person rdf:about="AntonyGalton"
                              conferences:country="United Kingdom"
                              rdfs:label="Antony Galton">
            <conferences:affiliation>School of Engineering and Computer Science, University of Exeter</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="AnupriyaAnkolekar"
                              conferences:affiliation="University of Karlsruhe"
                              conferences:country="Germany"
                              rdfs:label="Anupriya Ankolekar"/>
          <swrc:Person rdf:about="ArantzaIllarramendi"
                              conferences:affiliation="Basque Country University"
                              conferences:country="Spain"
                              rdfs:label="Arantza Illarramendi"/>
          <swrc:Topic rdf:about="ArtificialIntelligence">
            <rdfs:label rdf:datatype="&xsd;string">ArtificialIntelligence</rdfs:label>
          </swrc:Topic>

          <swrc:Person rdf:about="AsunGomezPerez"
                              conferences:affiliation="Universidad Politecnica de Madrid"
                              conferences:country="Spain"
                              rdfs:label="Asun Gomez-Perez"/>
          <swrc:Person rdf:about="AtanasKiryakov"
                              conferences:affiliation="Sirma AI"
                              conferences:country="Bulgaria"
                              rdfs:label="Atanas Kiryakov"/>
          <swrc:Person rdf:about="AxelHahn"
                              conferences:affiliation="University of Oldenburg"
                              conferences:country="Germany"
                              rdfs:label="Axel Hahn"/>
          <swrc:Conference rdf:about="BPM2006" swrc:year="2006"
                                  rdfs:label="BPM2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://bpm2006.tuwien.ac.at/</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-05-12</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-05-27</conferences:camera-readySubmission>
            <conferences:place rdf:datatype="&xsd;string">Vienna, Austria</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-09-05</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-03-17</conferences:submissionsDue>
            <swrc:title rdf:datatype="&xsd;string">4th International Conference on Business Process Management</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">48.208333</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">16.373056</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="BarbaraPartee"
                              conferences:affiliation="University of Massachusetts"
                              conferences:country="United States"
                              rdfs:label="Barbara Partee"/>
          <swrc:Person rdf:about="BarrySmith"
                              conferences:country="Germany"
                              rdfs:label="Barry Smith">
            <conferences:affiliation>National Center for Ontological Research and Department of Philosophy, University at Buffalo, USA; Institute for Formal Ontology and Medical Information Science, Saarbrücken</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="BillAndersen"
                              conferences:affiliation="OntoWorks"
                              conferences:country="United States"
                              rdfs:label="Bill Andersen"/>
          <swrc:Person rdf:about="BoiFaltings"
                              conferences:affiliation="EPFL Lausanne"
                              conferences:country="Switzerland"
                              rdfs:label="Boi Faltings"/>
          <swrc:Person rdf:about="BorisMotik"
                              conferences:affiliation="FZI Karlsruhe"
                              conferences:country="Germany"
                              rdfs:label="Boris Motik"/>
          <swrc:Person rdf:about="BrandonBennett"
                              conferences:country="United Kingdom"
                              rdfs:label="Brandon Bennett">
            <conferences:affiliation>School of Computing, University of Leeds</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="BrianMcBride"
                              conferences:affiliation="Hewlett Packard"
                              conferences:country="United Kingdom"
                              rdfs:label="Brian McBride"/>
          <swrc:Conference rdf:about="COLINGACL2006" swrc:year="2006"
                                  rdfs:label="COLING-ACL2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.acl2006.mq.edu.au/</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-07-21</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Sydney, Australia</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-07-17</conferences:start>
            <swrc:title rdf:datatype="&xsd;string">Conference of the International Committee on Computational Linguistics and the Association for Computational Linguistics</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">-33.866667</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">151.2</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="COMPSAC2006" swrc:year="2006"
                                  rdfs:label="COMPSAC2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://conferences.computer.org/compsac/2006/</conferences:URL>
            <conferences:inConjunctionWith rdf:resource="CoSTEP2006"/>
            <swrc:title rdf:datatype="&xsd;string">IEEE Computer Society Signature Conference on Software Technology and Applications</swrc:title>
          </swrc:Conference>

          <swrc:Person rdf:about="CarolaEschenbach"
                              conferences:country="Germany"
                              rdfs:label="Carola Eschenbach">
            <conferences:affiliation>Department for Informatics, University of Hamburg</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="CaroleGoble"
                              conferences:affiliation="University of Manchester"
                              conferences:country="United Kingdom"
                              rdfs:label="Carole Goble"/>
          <swrc:Person rdf:about="ChrisMenzel"
                              conferences:country="United States"
                              rdfs:label="Chris Menzel">
            <conferences:affiliation>Department of Philosophy, Texas A&amp;M University</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="ChrisPreist"
                              conferences:affiliation="HP Labs"
                              conferences:country="United Kingdom"
                              rdfs:label="Chris Preist"/>
          <swrc:Person rdf:about="ChrisWelty"
                              conferences:affiliation="IBM"
                              conferences:country="United States"
                              rdfs:label="Chris Welty"/>
          <swrc:Person rdf:about="ChristianeFellbaum"
                              conferences:country="Germany"
                              rdfs:label="Christiane Fellbaum">
            <conferences:affiliation>Cognitive Science Laboratory, Princeton University, USA and Berlin Brandenburg Academy of Sciences and Humanities, Berlin</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="ChristineGolbreich"
                              conferences:affiliation="University of Rennes"
                              conferences:country="France"
                              rdfs:label="Christine Golbreich"/>
          <swrc:Person rdf:about="ChristophBussler"
                              conferences:affiliation="Cisco Systems, Inc."
                              conferences:country="United States"
                              rdfs:label="Christoph Bussler"/>
          <swrc:Person rdf:about="ClaudioMasolo"
                              conferences:country="Italy"
                              rdfs:label="Claudio Masolo">
            <conferences:affiliation>Laboratory for Applied Ontology, ISTC-CNR, Trento</conferences:affiliation>
          </swrc:Person>

          <swrc:Conference rdf:about="CoSTEP2006" swrc:year="2006"
                                  rdfs:label="CoSTEP2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://conferences.computer.org/CoSTEP/</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-09-23</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Chicago, USA</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-09-17</conferences:start>
            <swrc:title rdf:datatype="&xsd;string">The Congress on Software Technology  and Engineering Practice</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">41.9</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-87.65</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="DEXA2006" swrc:year="2006"
                                  rdfs:label="DEXA 2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.dexa.org/</conferences:URL>
            <conferences:abstractsDue rdf:datatype="&xsd;date">2006-02-28</conferences:abstractsDue>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-05-10</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-06-10</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-09-08</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www.dexa.org/themes/dexa/images/logo_2006.gif</conferences:logo>
            <conferences:place rdf:datatype="&xsd;string">Krakow, Poland</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-09-04</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-03-07</conferences:submissionsDue>
            <swrc:title rdf:datatype="&xsd;string">17th International Conference on Database and Expert Systems Applications</swrc:title>
            <swrc:isAbout rdf:resource="DataMining"/>
            <swrc:isAbout rdf:resource="Databases"/>
            <swrc:isAbout rdf:resource="XML"/>
            <rdfs:comment>The aim of DEXA 2006 is to present both research contributions in the area of data base and intelligent systems and a large spectrum of already implemented or just being developed applications. DEXA will offer the opportunity to extensively discuss requirements, problems, and solutions in the field. The workshop and conference should inspire a fruitful dialogue between developers in practice, users of database and expert systems, and scientists working in the field.</rdfs:comment>
            <wgs84_pos:lat rdf:datatype="&xsd;float">50.061667</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">19.937222</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="DMIN2006" swrc:year="2006"
                                  rdfs:label="DMIN2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.dmin-2006.com/</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-04-09</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-04-20</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-05-29</conferences:end>
            <conferences:inConjunctionWith rdf:resource="WORLDCOMP06"/>
            <conferences:place rdf:datatype="&xsd;string">Monte Carlo Resort, Las Vegas, Nevada, USA</conferences:place>
            <conferences:preRegistration rdf:datatype="&xsd;date">2006-04-20</conferences:preRegistration>
            <conferences:start rdf:datatype="&xsd;date">2006-05-26</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-03-06</conferences:submissionsDue>
            <swrc:title rdf:datatype="&xsd;string">2006 International Conference on Data Mining</swrc:title>
            <swrc:isAbout rdf:resource="DataMining"/>
            <swrc:isAbout rdf:resource="DataVisualization"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">36.183333</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-115.216667</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="DanielOlmedilla"
                              conferences:affiliation="L3S Hannover"
                              conferences:country="Germany"
                              rdfs:label="Daniel Olmedilla"/>
          <swrc:Person rdf:about="DanielSchwabe"
                              conferences:affiliation="PUC-Rio"
                              conferences:country="Brazil"
                              rdfs:label="Daniel Schwabe"/>
          <swrc:Topic rdf:about="DataMining">
            <rdfs:label rdf:datatype="&xsd;string">DataMining</rdfs:label>
          </swrc:Topic>

          <swrc:Topic rdf:about="DataModeling">
            <rdfs:label rdf:datatype="&xsd;string">DataModeling</rdfs:label>
          </swrc:Topic>

          <swrc:Topic rdf:about="DataVisualization">
            <rdfs:label rdf:datatype="&xsd;string">DataVisualization</rdfs:label>
          </swrc:Topic>

          <swrc:Topic rdf:about="Databases"/>
          <swrc:Person rdf:about="DavidMark"
                              conferences:country="United States"
                              rdfs:label="David Mark">
            <conferences:affiliation>Department of Geography, State University of New York, Buffalo</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="DavidRandell"
                              conferences:affiliation="Imperial College London"
                              conferences:country="United Kingdom"
                              rdfs:label="David Randell"/>
          <swrc:Person rdf:about="DavidToman"
                              conferences:affiliation="University of Waterloo"
                              conferences:country="Canada"
                              rdfs:label="David Toman"/>
          <swrc:Person rdf:about="DeanAllemang"
                              conferences:affiliation="TopQuadrant Inc."
                              conferences:country="United States"
                              rdfs:label="Dean Allemang"/>
          <swrc:Person rdf:about="DerekSleeman"
                              conferences:affiliation="University of Aberdeen"
                              conferences:country="United Kingdom"
                              rdfs:label="Derek Sleeman"/>
          <swrc:Person rdf:about="DianaMaynard"
                              conferences:affiliation="University Sheffield"
                              conferences:country="United Kingdom"
                              rdfs:label="Diana Maynard"/>
          <swrc:Person rdf:about="DieterFensel"
                              conferences:affiliation="University of Innsbruck and DERI"
                              conferences:country="Austria"
                              rdfs:label="Dieter Fensel"/>
          <swrc:Person rdf:about="DimitrisPlexousakis"
                              conferences:affiliation="University of Crete"
                              conferences:country="Greece"
                              rdfs:label="Dimitris Plexousakis"/>
          <swrc:Person rdf:about="DunjaMladenic"
                              conferences:affiliation="J. Stefan Institute"
                              conferences:country="Slovenia"
                              rdfs:label="Dunja Mladenic"/>
          <swrc:Topic rdf:about="E-Collaboration">
            <rdfs:label rdf:datatype="&xsd;string">E-Collaboration</rdfs:label>
          </swrc:Topic>

          <swrc:Topic rdf:about="E-Commerce">
            <rdfs:label rdf:datatype="&xsd;string">E-Commerce</rdfs:label>
          </swrc:Topic>

          <swrc:Topic rdf:about="E-Government">
            <rdfs:label rdf:datatype="&xsd;string">E-Government</rdfs:label>
          </swrc:Topic>

          <swrc:Topic rdf:about="E-Learning"/>
          <swrc:Conference rdf:about="EC-TEL2006" swrc:year="2006"
                                  rdfs:label="EC-TEL2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.ectel06.org</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-06-01</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-06-30</conferences:camera-readySubmission>
            <conferences:place rdf:datatype="&xsd;string">Crete, Greece</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-10-01</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-03-30</conferences:submissionsDue>
            <swrc:title>First European Conference on Technology Enhanced Learning</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">35</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">24</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="EDBT2006" swrc:year="2006"
                                  rdfs:label="EDBT2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.edbt2006.de</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-03-31</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www.edbt2006.de/Images/Logo1.jpg</conferences:logo>
            <conferences:place rdf:datatype="&xsd;string">Munich, Germany</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-03-26</conferences:start>
            <swrc:title rdf:datatype="&xsd;string">10. International Conference on Extending Database Technology</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">48.133333</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">11.566667</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="EISTA06" swrc:year="2006"
                                  rdfs:label="EISTA06">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.conf-info.org/eista06/</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-04-03</conferences:acceptanceNotification>
            <conferences:end rdf:datatype="&xsd;date">2006-07-23</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Orlando, Florida, USA</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-07-20</conferences:start>
            <rdfs:comment>4th International Conference on Education and Information Systems, Technologies and Applications</rdfs:comment>
            <wgs84_pos:lat rdf:datatype="&xsd;float">28.533611</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-81.368533</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="ER2006" swrc:year="2006"
                                  rdfs:label="ER2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://adrg.eller.arizona.edu/ER2006/</conferences:URL>
            <conferences:abstractsDue rdf:datatype="&xsd;date">2006-04-03</conferences:abstractsDue>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-06-14</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-07-12</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-11-09</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Tucson, Arizona, USA</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-11-06</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-04-10</conferences:submissionsDue>
            <swrc:title rdf:datatype="&xsd;string">25th International Conference on Conceptual Modeling</swrc:title>
            <swrc:isAbout rdf:resource="DataModeling"/>
            <swrc:isAbout rdf:resource="Databases"/>
            <swrc:isAbout rdf:resource="ProcessModeling"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">32.214444</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-110.918056</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="ESWC06" swrc:year="2006"
                                  rdfs:label="ESWC06">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.eswc2006.org/</conferences:URL>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-03-31</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-06-14</conferences:end>
            <conferences:pcMember rdf:resource="AbrahamBernstein"/>
            <conferences:pcMember rdf:resource="AlainLeger"/>
            <conferences:pcMember rdf:resource="AldoGangemi"/>
            <conferences:pcMember rdf:resource="AleksanderPivk"/>
            <conferences:pcMember rdf:resource="AlexanderLoeser"/>
            <conferences:pcMember rdf:resource="AmitSheth"/>
            <conferences:pcMember rdf:resource="AndreasAbecker"/>
            <conferences:pcMember rdf:resource="AndreasEberhart"/>
            <conferences:pcMember rdf:resource="AndreasHotho"/>
            <conferences:pcMember rdf:resource="AnupriyaAnkolekar"/>
            <conferences:pcMember rdf:resource="AsunGomezPerez"/>
            <conferences:pcMember rdf:resource="AtanasKiryakov"/>
            <conferences:pcMember rdf:resource="AxelHahn"/>
            <conferences:pcMember rdf:resource="BoiFaltings"/>
            <conferences:pcMember rdf:resource="BorisMotik"/>
            <conferences:pcMember rdf:resource="BrianMcBride"/>
            <conferences:pcMember rdf:resource="CaroleGoble"/>
            <conferences:pcMember rdf:resource="ChrisPreist"/>
            <conferences:pcMember rdf:resource="ChristineGolbreich"/>
            <conferences:pcMember rdf:resource="ChristophBussler"/>
            <conferences:pcMember rdf:resource="DanielOlmedilla"/>
            <conferences:pcMember rdf:resource="DanielSchwabe"/>
            <conferences:pcMember rdf:resource="DeanAllemang"/>
            <conferences:pcMember rdf:resource="DerekSleeman"/>
            <conferences:pcMember rdf:resource="DianaMaynard"/>
            <conferences:pcMember rdf:resource="DieterFensel"/>
            <conferences:pcMember rdf:resource="DimitrisPlexousakis"/>
            <conferences:pcMember rdf:resource="DunjaMladenic"/>
            <conferences:pcMember rdf:resource="EeroHyvnen"/>
            <conferences:pcMember rdf:resource="ElenaPaslaruBontas"/>
            <conferences:pcMember rdf:resource="EnricoFranconi"/>
            <conferences:pcMember rdf:resource="EnricoMotta"/>
            <conferences:pcMember rdf:resource="FabienGandon"/>
            <conferences:pcMember rdf:resource="FaustoGiunchiglia"/>
            <conferences:pcMember rdf:resource="FrancoisBry"/>
            <conferences:pcMember rdf:resource="FrankvanHarmelen"/>
            <conferences:pcMember rdf:resource="GerdStumme"/>
            <conferences:pcMember rdf:resource="GritDenker"/>
            <conferences:pcMember rdf:resource="GuusSchreiber"/>
            <conferences:pcMember rdf:resource="HamishCunningham"/>
            <conferences:pcMember rdf:resource="HeinerStuckenschmidt"/>
            <conferences:pcMember rdf:resource="HermanterHorst"/>
            <conferences:pcMember rdf:resource="HideakiTakeda"/>
            <conferences:pcMember rdf:resource="HolgerWache"/>
            <conferences:pcMember rdf:resource="IanHorrocks"/>
            <conferences:pcMember rdf:resource="IsabelCruz"/>
            <conferences:pcMember rdf:resource="JaneHunter"/>
            <conferences:pcMember rdf:resource="JeenBroekstra"/>
            <conferences:pcMember rdf:resource="JeffHeflin"/>
            <conferences:pcMember rdf:resource="JeffZPan"/>
            <conferences:pcMember rdf:resource="JeremyJCarroll"/>
            <conferences:pcMember rdf:resource="JeromeEuzenat"/>
            <conferences:pcMember rdf:resource="JinghaiRao"/>
            <conferences:pcMember rdf:resource="JoergDiedrich"/>
            <conferences:pcMember rdf:resource="JohnDavies"/>
            <conferences:pcMember rdf:resource="JohnMylopoulos"/>
            <conferences:pcMember rdf:resource="JosdeBruijn"/>
            <conferences:pcMember rdf:resource="JrgenAngele"/>
            <conferences:pcMember rdf:resource="KalinaBontcheva"/>
            <conferences:pcMember rdf:resource="KatiaSycara"/>
            <conferences:pcMember rdf:resource="KavithaSrinivas"/>
            <conferences:pcMember rdf:resource="KrzysztofWecel"/>
            <conferences:pcMember rdf:resource="LeoObrst"/>
            <conferences:pcMember rdf:resource="LilianaCabral"/>
            <conferences:pcMember rdf:resource="LjiljanaStojanovic"/>
            <conferences:pcMember rdf:resource="ManolisKoubarakis"/>
            <conferences:pcMember rdf:resource="MarcoPistore"/>
            <conferences:pcMember rdf:resource="MariGeorges"/>
            <conferences:pcMember rdf:resource="MarieChristineRousset"/>
            <conferences:pcMember rdf:resource="MarkoGrobelnik"/>
            <conferences:pcMember rdf:resource="MarkoTadic"/>
            <conferences:pcMember rdf:resource="MartinDzbor"/>
            <conferences:pcMember rdf:resource="MartinHepp"/>
            <conferences:pcMember rdf:resource="MasahiroHori"/>
            <conferences:pcMember rdf:resource="MatthiasKlusch"/>
            <conferences:pcMember rdf:resource="MaurizioLenzerini"/>
            <conferences:pcMember rdf:resource="MichaelSintek"/>
            <conferences:pcMember rdf:resource="MichaelStollberg"/>
            <conferences:pcMember rdf:resource="MichaelWooldridge"/>
            <conferences:pcMember rdf:resource="MihhailMatskin"/>
            <conferences:pcMember rdf:resource="NicolaGuarino"/>
            <conferences:pcMember rdf:resource="NicolaHenze"/>
            <conferences:pcMember rdf:resource="NigelCollier"/>
            <conferences:pcMember rdf:resource="OscarCorcho"/>
            <conferences:pcMember rdf:resource="PaoloBouquet"/>
            <conferences:pcMember rdf:resource="PaoloTraverso"/>
            <conferences:pcMember rdf:resource="PascalHitzler"/>
            <conferences:pcMember rdf:resource="PaulBuitelaar"/>
            <conferences:pcMember rdf:resource="PaulodaPinheiro"/>
            <conferences:pcMember rdf:resource="RalfMoeller"/>
            <conferences:pcMember rdf:resource="RaphaelTroncy"/>
            <conferences:pcMember rdf:resource="RichardBenjamins"/>
            <conferences:pcMember rdf:resource="RiichiroMizoguchi"/>
            <conferences:pcMember rdf:resource="RobertTolksdorf"/>
            <conferences:pcMember rdf:resource="RubenLara"/>
            <conferences:pcMember rdf:resource="RudiStuder"/>
            <conferences:pcMember rdf:resource="SeanBechhofer"/>
            <conferences:pcMember rdf:resource="SergioTessaris"/>
            <conferences:pcMember rdf:resource="SiegfriedHandschuh"/>
            <conferences:pcMember rdf:resource="SofiaPinto"/>
            <conferences:pcMember rdf:resource="StefanSchlobach"/>
            <conferences:pcMember rdf:resource="SteffenStaab"/>
            <conferences:pcMember rdf:resource="SteveWillmott"/>
            <conferences:pcMember rdf:resource="TerryPayne"/>
            <conferences:pcMember rdf:resource="UbboVisser"/>
            <conferences:pcMember rdf:resource="UlrichReimer"/>
            <conferences:pcMember rdf:resource="ValentinaTamma"/>
            <conferences:pcMember rdf:resource="VangelisKarkaletsis"/>
            <conferences:pcMember rdf:resource="VibhuMittal"/>
            <conferences:pcMember rdf:resource="VipulKashyap"/>
            <conferences:pcMember rdf:resource="VojtechSvatek"/>
            <conferences:pcMember rdf:resource="VolkerHaarslev"/>
            <conferences:pcMember rdf:resource="WalterBinder"/>
            <conferences:pcMember rdf:resource="WolfgangNejdl"/>
            <conferences:pcMember rdf:resource="YingDing"/>
            <conferences:place rdf:datatype="&xsd;string">Budva, Montenegro</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-06-11</conferences:start>
            <swrc:title rdf:datatype="&xsd;string">3rd Annual European Semantic Web Conference</swrc:title>
            <swrc:isAbout rdf:resource="SemanticWeb"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">42.285278</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">18.843611</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="EduardHovy"
                              conferences:affiliation="University of Southern California"
                              conferences:country="United States"
                              rdfs:label="Eduard Hovy"/>
          <swrc:Person rdf:about="EeroHyvnen"
                              conferences:affiliation="University of Helsinki"
                              conferences:country="Finland"
                              rdfs:label="Eero Hyvönen"/>
          <swrc:Person rdf:about="ElenaPaslaruBontas"
                              conferences:affiliation="FU Berlin"
                              conferences:country="Germany"
                              rdfs:label="Elena Paslaru Bontas"/>
          <swrc:Person rdf:about="EnricoFranconi"
                              conferences:affiliation="Free University of Bozen-Bolzano"
                              conferences:country="Italy"
                              rdfs:label="Enrico Franconi"/>
          <swrc:Person rdf:about="EnricoMotta"
                              conferences:affiliation="The Open University"
                              conferences:country="United Kingdom"
                              rdfs:label="Enrico Motta"/>
          <swrc:Person rdf:about="ErnestDavis"
                              conferences:country="United States"
                              rdfs:label="Ernest Davis">
            <conferences:affiliation>Department of Computer Science, New York University</conferences:affiliation>
          </swrc:Person>

          <swrc:Conference rdf:about="FOIS2006" swrc:year="2006"
                                  conferences:publicityChair="Leo Obrst (MITRE, USA) lobrst@mitre.org"
                                  rdfs:label="FOIS-2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.formalontology.org/</conferences:URL>
            <conferences:abstractsDue rdf:datatype="&xsd;date">2006-05-01</conferences:abstractsDue>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-05-05</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-06-28</conferences:camera-readySubmission>
            <conferences:conferenceChair rdf:resource="NicolaGuarino"/>
            <conferences:end rdf:datatype="&xsd;date">2006-11-11</conferences:end>
            <conferences:localChair rdf:resource="BillAndersen"/>
            <conferences:pcMember rdf:resource="AchilleVarzi"/>
            <conferences:pcMember rdf:resource="AldoGangemi"/>
            <conferences:pcMember rdf:resource="AlessandroLenci"/>
            <conferences:pcMember rdf:resource="AntonyGalton"/>
            <conferences:pcMember rdf:resource="BarbaraPartee"/>
            <conferences:pcMember rdf:resource="BarrySmith"/>
            <conferences:pcMember rdf:resource="BillAndersen"/>
            <conferences:pcMember rdf:resource="BrandonBennett"/>
            <conferences:pcMember rdf:resource="CarolaEschenbach"/>
            <conferences:pcMember rdf:resource="ChrisMenzel"/>
            <conferences:pcMember rdf:resource="ChrisWelty"/>
            <conferences:pcMember rdf:resource="ChristianeFellbaum"/>
            <conferences:pcMember rdf:resource="ClaudioMasolo"/>
            <conferences:pcMember rdf:resource="DavidMark"/>
            <conferences:pcMember rdf:resource="DavidRandell"/>
            <conferences:pcMember rdf:resource="EduardHovy"/>
            <conferences:pcMember rdf:resource="ErnestDavis"/>
            <conferences:pcMember rdf:resource="IanPrattHartmann"/>
            <conferences:pcMember rdf:resource="IngvarJohansson"/>
            <conferences:pcMember rdf:resource="JamesPustejovsky"/>
            <conferences:pcMember rdf:resource="JerryHobbs"/>
            <conferences:pcMember rdf:resource="JohnBateman"/>
            <conferences:pcMember rdf:resource="JohnMylopoulos"/>
            <conferences:pcMember rdf:resource="JohnSowa"/>
            <conferences:pcMember rdf:resource="JoostBreuker"/>
            <conferences:pcMember rdf:resource="LaureVieu"/>
            <conferences:pcMember rdf:resource="LeoObrst"/>
            <conferences:pcMember rdf:resource="LeonardoLesmo"/>
            <conferences:pcMember rdf:resource="MartinDrr"/>
            <conferences:pcMember rdf:resource="MassimoPoesio"/>
            <conferences:pcMember rdf:resource="MatteoCristani"/>
            <conferences:pcMember rdf:resource="MichaelGruninger"/>
            <conferences:pcMember rdf:resource="MikeUschold"/>
            <conferences:pcMember rdf:resource="NathalieAussenacGilles"/>
            <conferences:pcMember rdf:resource="NicholasAsher"/>
            <conferences:pcMember rdf:resource="NicolaGuarino"/>
            <conferences:pcMember rdf:resource="PhilippeMuller"/>
            <conferences:pcMember rdf:resource="PierdanieleGiaretta"/>
            <conferences:pcMember rdf:resource="RichmondThomason"/>
            <conferences:pcMember rdf:resource="RobertRynasiewicz"/>
            <conferences:pcMember rdf:resource="RobertoCasati"/>
            <conferences:pcMember rdf:resource="SimonMilton"/>
            <conferences:pcMember rdf:resource="StefanoBorgo"/>
            <conferences:pcMember rdf:resource="TonyCohn"/>
            <conferences:pcMember rdf:resource="UdoHahn"/>
            <conferences:pcMember rdf:resource="VedaStorey"/>
            <conferences:pcMember rdf:resource="WernerCeusters"/>
            <conferences:pcMember rdf:resource="WernerKuhn"/>
            <conferences:place rdf:datatype="&xsd;string">Baltimore, Maryland (USA)</conferences:place>
            <conferences:programChair>Brandon Bennett (University of Leeds, UK) brandon@comp.leeds.ac.uk
        Christiane Fellbaum (Princeton University, USA and Berlin Brandenburg Academy of Sciences and Humanities, Germany) fellbaum@clarity.princeton.edu</conferences:programChair>
            <conferences:programmeCommittee>*  Bill Andersen (OntologyWorks, USA)
            * Nicholas Asher (Department of Philosophy, University of Texas at Austin, USA)
            * Nathalie Aussenac-Gilles (Research Institute for Computer Science, CNRS, Toulouse, France)
            * John Bateman (Department of Applied English Linguistics, University of Bremen, Germany)
            * Brandon Bennett (School of Computing, University of Leeds, UK)
            * Stefano Borgo (Laboratory for Applied Ontology, ISTC-CNR, Italy)
            * Joost Breuker (Leibniz Center for Law, University of Amsterdam, The Netherlands)
            * Roberto Casati (Jean Nicod Institute, CNRS, Paris, France)
            * Werner Ceusters (European Centre for Ontological Research, Saarbrücken)
            * Tony Cohn (School of Computing, University of Leeds, UK)
            * Matteo Cristani (University of Verona, Italy)
            * Ernest Davis (Department of Computer Science, New York University, USA)
            * Martin Dörr (Institute of Computer Science, FORTH, Heraklion, Greece)
            * Carola Eschenbach (Department for Informatics, University of Hamburg, Germany)
            * Christiane Fellbaum (Cognitive Science Laboratory, Princeton University, USA and Berlin Brandenburg Academy of Sciences and Humanities, Berlin, Germany)
            * Antony Galton (School of Engineering and Computer Science, University of Exeter, UK)
            * Aldo Gangemi (Laboratory for Applied Ontology, ISTC-CNR, Roma, Italy)
            * Pierdaniele Giaretta (Department of Philosophy, University of Verona, Italy)
            * Michael Gruninger (University of Toronto, Canada)
            * Nicola Guarino (Laboratory for Applied Ontology, ISTC-CNR, Trento, Italy)
            * Udo Hahn (Jena University, Germany)
            * Jerry Hobbs (University of Southern California, USA)
            * Eduard Hovy (University of Southern California, USA)
            * Ingvar Johansson (Institute for Formal Ontology and Medical Information Science, University of Saarbrücken, Germany)
            * Werner Kuhn (IFGI, Muenster)
            * Fritz Lehmann (USA)
            * Alessandro Lenci (University of Pisa, Italy)
            * Leonardo Lesmo (Department of Computer Science, University of Torino, Italy)
            * David Mark (Department of Geography, State University of New York, Buffalo, USA)
            * Claudio Masolo (Laboratory for Applied Ontology, ISTC-CNR, Trento, Italy)
            * Chris Menzel (Department of Philosophy, Texas A&amp;M University, USA)
            * Simon Milton (Department of Information Systems, University of Melbourne, Australia)
            * Philippe Muller (Research Institute for Computer Science, University of Toulouse III, France)
            * John Mylopoulos (Department of Computer Science, University of Toronto, Canada)
            * Leo Obrst (The MITRE Corporation, USA)
            * Barbara Partee (University of Massachusetts, USA)
            * Massimo Poesio (Department of Computer Science, University of Essex, UK)
            * Ian Pratt-Hartmann (Department of Computer Science, University of Manchester, UK)
            * James Pustejovsky (Department of Computer Science, Brandeis University, USA)
            * David Randell (Imperial College London, UK)
            * Robert Rynasiewicz (Johns Hopkins University, USA)
            * Barry Smith (National Center for Ontological Research and Department of Philosophy, University at Buffalo, USA; Institute for Formal Ontology and Medical Information Science, Saarbrücken, Germany)
            * John Sowa (Vivomind Intelligence Inc., USA)
            * Veda Storey (Department of Computer Information Systems, Georgia State University, USA)
            * Richmond Thomason (University of Michigan, USA)
            * Mike Uschold (The Boeing Company, USA)
            * Achille Varzi (Department of Philosophy, Columbia University, USA)
            * Laure Vieu (Research Institute for Computer Science, CNRS, Toulouse, France)
            * Chris Welty (IBM Watson Research Center, USA)</conferences:programmeCommittee>
            <conferences:start rdf:datatype="&xsd;date">2006-11-09</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-05-05</conferences:submissionsDue>
            <swrc:title>International Conference on Formal Ontology in Information Systems</swrc:title>
            <swrc:isAbout rdf:resource="KnowledgeEngineering"/>
            <swrc:isAbout rdf:resource="Ontologies"/>
            <swrc:isAbout rdf:resource="SemanticWeb"/>
            <rdfs:comment>Since ancient times, ontology, the analysis and categorisation of what exists, has been fundamental to philosophical enquiry. But, until recently, ontology has been seen as an abstract, purely theoretical discipline, far removed from the practical applications of science. However, with the increasing use of sophisticated computerised information systems, solving problems of an ontological nature is now key to the effective use of technologies supporting a wide range of human activities. The ship of Theseus and the tail of Tibbles the cat are no longer merely amusing puzzles. We employ databases and software applications to deal with everything from ships and ship building to anatomy and amputations. When we design a computer to take stock of a ship yard or check that all goes well at the veterinary hospital, we need to ensure that our system operates in a consistent and reliable way even when manipulating information that involves subtle issues of semantics and identity. So, whereas ontologists may once have shied away from practical problems, now the practicalities of achieving cohesion in an information-based society demand that attention must be paid to ontology.

        Researchers in such areas as artificial intelligence, formal and computational linguistics, biomedical informatics, conceptual modeling, knowledge engineering and information retrieval have come to realise that a solid foundation for their research calls for serious work in ontology, understood as a general theory of the types of entities and relations that make up their respective domains of inquiry. In all these areas, attention is now being focused on the content of information rather than on just the formats and languages used to represent information. The clearest example of this development is provided by the many initiatives growing up around the project of the Semantic Web. And, as the need for integrating research in these different fields arises, so does the realisation that strong principles for building well-founded ontologies might provide significant advantages over ad hoc, case-based solutions. The tools of formal ontology address precisely these needs, but a real effort is required in order to apply such philosophical tools to the domain of information systems. Reciprocally, research in the information sciences raises specific ontological questions which call for further philosophical investigations.

        The purpose of FOIS is to provide a forum for genuine interdisciplinary exchange in the spirit of a unified effort towards solving the problems of ontology, with an eye to both theoretical issues and concrete applications.</rdfs:comment>
            <wgs84_pos:lat rdf:datatype="&xsd;float">39.2865</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-76.6149</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="FabienGandon"
                              conferences:affiliation="INRIA Sophia-Antipolis"
                              conferences:country="France"
                              rdfs:label="Fabien Gandon"/>
          <swrc:Person rdf:about="FaustoGiunchiglia"
                              conferences:affiliation="University of Trento"
                              conferences:country="Italy"
                              rdfs:label="Fausto Giunchiglia"/>
          <swrc:Person rdf:about="FrancoisBry"
                              conferences:affiliation="University of Munich"
                              conferences:country="Germany"
                              rdfs:label="Francois Bry"/>
          <swrc:Person rdf:about="FrankvanHarmelen"
                              conferences:affiliation="Vrije Universiteit Amsterdam"
                              conferences:country="Netherlands"
                              rdfs:label="Frank van Harmelen"/>
          <swrc:Person rdf:about="FranzBaader"
                              conferences:affiliation="University of Dresden"
                              conferences:country="Germany"
                              rdfs:label="Franz Baader"/>
          <swrc:Person rdf:about="GeorgLausen"
                              conferences:affiliation="University of Freiburg"
                              conferences:country="Germany"
                              rdfs:label="Georg Lausen"/>
          <swrc:Person rdf:about="GerdStumme"
                              conferences:affiliation="University of Kassel"
                              conferences:country="Germany"
                              rdfs:label="Gerd Stumme"/>
          <swrc:Person rdf:about="GiuseppeDeGiacomo"
                              conferences:affiliation="University of Roma Sapienza"
                              conferences:country="Italy"
                              rdfs:label="Giuseppe De Giacomo"/>
          <swrc:Person rdf:about="GritDenker"
                              conferences:affiliation="SRI"
                              conferences:country="United States"
                              rdfs:label="Grit Denker"/>
          <swrc:Person rdf:about="GuidoVetere"
                              conferences:affiliation="IBM"
                              conferences:country="Italy"
                              rdfs:label="Guido Vetere"/>
          <swrc:Person rdf:about="GuusSchreiber"
                              conferences:affiliation="Vrije Universiteit Amsterdam"
                              conferences:country="Netherlands"
                              rdfs:label="Guus Schreiber"/>
          <swrc:Person rdf:about="HamishCunningham"
                              conferences:affiliation="University Sheffield"
                              conferences:country="United Kingdom"
                              rdfs:label="Hamish Cunningham"/>
          <swrc:Person rdf:about="HeikoSchuldt"
                              conferences:affiliation="University Basel"
                              conferences:country="Switzerland"
                              rdfs:label="Heiko Schuldt"/>
          <swrc:Person rdf:about="HeinerStuckenschmidt"
                              conferences:affiliation="University of Mannheim"
                              conferences:country="Germany"
                              rdfs:label="Heiner Stuckenschmidt"/>
          <swrc:Person rdf:about="HermanterHorst"
                              conferences:affiliation="Philips Research"
                              conferences:country="Netherlands"
                              rdfs:label="Herman ter Horst"/>
          <swrc:Person rdf:about="HideakiTakeda"
                              conferences:affiliation="National Institute of Informatics"
                              conferences:country="Japan"
                              rdfs:label="Hideaki Takeda"/>
          <swrc:Person rdf:about="HolgerWache"
                              conferences:affiliation="Vrije Universiteit Amsterdam"
                              conferences:country="Netherlands"
                              rdfs:label="Holger Wache"/>
          <swrc:Conference rdf:about="ICDM06" swrc:year="2006"
                                  rdfs:label="ICDM06">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.comp.hkbu.edu.hk/iwi06/icdm</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-09-04</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-10-04</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-12-22</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Hong Kong Convention and Exhibition Centre, Hong Kong, China</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-12-18</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-07-05</conferences:submissionsDue>
            <swrc:title>IEEE International Conference on Data Mining</swrc:title>
            <swrc:isAbout rdf:resource="DataMining"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">22.285278</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">114.147778</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="ICEC06" swrc:year="2006"
                                  rdfs:label="ICEC06">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.icec06.net/</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-04-15</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-05-31</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-08-16</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Fredericton, New Brunswick, Canada</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-08-14</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-03-06</conferences:submissionsDue>
            <swrc:title>The Eighth International Conference on Electronic Commerce</swrc:title>
            <swrc:isAbout rdf:resource="E-Commerce"/>
            <swrc:isAbout rdf:resource="E-Government"/>
            <swrc:isAbout rdf:resource="MultiagentSystems"/>
            <swrc:isAbout rdf:resource="SemanticWeb"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">45.95</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-66.666667</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="ICL2006" swrc:year="2006"
                                  rdfs:label="ICL2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.icl-conference.org/</conferences:URL>
            <conferences:abstractsDue rdf:datatype="&xsd;date">2006-05-19</conferences:abstractsDue>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-06-19</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-09-11</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-09-29</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www.icl-conference.org/images/logo_big.gif</conferences:logo>
            <conferences:place rdf:datatype="&xsd;string">Carinthia Tech Institute, Villach, Austria</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-09-27</conferences:start>
            <swrc:title>Interactive Computer Aided Learning Conference</swrc:title>
            <swrc:isAbout rdf:resource="E-Learning"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">46.625</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">13.834167</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="ICWE2006" swrc:year="2006"
                                  rdfs:label="ICWE2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www-conf.slac.stanford.edu/icwe06/</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-04-01</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-04-19</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-04-14</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www-conf.slac.stanford.edu/icwe06/images/ICWE_logo1.gif</conferences:logo>
            <conferences:start rdf:datatype="&xsd;date">2006-07-11</conferences:start>
            <swrc:title>Sixth International Conference on Web Engineering</swrc:title>
            <swrc:isAbout rdf:resource="E-Learning"/>
            <swrc:isAbout rdf:resource="P2P"/>
            <swrc:isAbout rdf:resource="WebApplications"/>
            <swrc:isAbout rdf:resource="WebServices"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">37.429167</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-122.138056</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="ICWS2006"
                                  rdfs:label="ICWS2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.icws.org/</conferences:URL>
            <conferences:inConjunctionWith rdf:resource="CoSTEP2006"/>
            <swrc:title rdf:datatype="&xsd;string">IEEE International Conference on Web Services</swrc:title>
          </swrc:Conference>

          <swrc:Conference rdf:about="IMCL06" swrc:year="2006"
                                  rdfs:label="IMCL06">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.imcl-conference.org</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-04-21</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www.imcl-conference.org/images/imcl_logo_gross.gif</conferences:logo>
            <conferences:place rdf:datatype="&xsd;string">Princess Sumaya University for Technology, Amman, Jordan</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-04-19</conferences:start>
            <swrc:title>First International Conference on Interactive Mobile and Computer Aided Learning</swrc:title>
            <swrc:isAbout rdf:resource="E-Learning"/>
            <swrc:isAbout rdf:resource="MobileComputing"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">31.95</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">35.933333</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="ISWC2006" swrc:year="2006"
                                  rdfs:label="ISWC 2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://iswc2006.semanticweb.org/</conferences:URL>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-07-26</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-08-25</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-11-09</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www.informatik.uni-leipzig.de/~auer/iswc.png</conferences:logo>
            <conferences:place rdf:datatype="&xsd;string">Athens, Georgia, USA</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-11-05</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-05-15</conferences:submissionsDue>
            <swrc:title rdf:datatype="&xsd;string">Fifth International Semantic Web Conference</swrc:title>
            <swrc:isAbout rdf:resource="SemanticWeb"/>
            <rdfs:comment>The dream of the Web was to create a human communication and collaboration
        platform for sharing knowledge and enabling a universal space for
        information and services. We all are now much more connected, and in turn
        face new resulting problems: service and information overload caused by
        insufficient support for information selection, organization and
        collaboration. The Semantic Web, by providing standards for formulating and
        distributing metadata and ontologies, enables means for information
        organization and selective access. However, the Semantic Web requires new
        infrastructure on all levels - e.g., human-computer interaction, expressive
        representation and query languages, reasoning engines, data representation
        and integration, interoperability middleware, and distributed computing.

        To foster the exchange of ideas and collaboration, the International
        Semantic Web Conference brings together researchers in relevant disciplines
        such as artificial intelligence, databases, distributed computing, web
        engineering, information systems, and human-computer interaction.

        The Fifth International Semantic Web Conference (ISWC2006) follows on the
        success of previous conferences and workshops in Galway, Ireland (2005),
        Hiroshima, Japan (2004), Sanibel Island, USA (2003), Sardinia, Italy (2002),
        and Stanford, USA (2001).

        The organizing committee is soliciting paper submissions for the Research
        papers track and the Semantic Web In-Use papers track.</rdfs:comment>
          </swrc:Conference>

          <swrc:Person rdf:about="IanHorrocks"
                              conferences:affiliation="University of Manchester"
                              conferences:country="United Kingdom"
                              rdfs:label="Ian Horrocks"/>
          <swrc:Person rdf:about="IanPrattHartmann"
                              conferences:country="United Kingdom"
                              rdfs:label="Ian Pratt-Hartmann">
            <conferences:affiliation>Department of Computer Science, University of Manchester</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="IngvarJohansson"
                              conferences:country="Germany"
                              rdfs:label="Ingvar Johansson">
            <conferences:affiliation>Institute for Formal Ontology and Medical Information Science, University of Saarbrücken</conferences:affiliation>
          </swrc:Person>

          <swrc:Topic rdf:about="IntelligentSystems">
            <rdfs:label rdf:datatype="&xsd;string">IntelligentSystems</rdfs:label>
          </swrc:Topic>

          <swrc:Person rdf:about="IsabelCruz"
                              conferences:affiliation="University Illinois at Chicago"
                              conferences:country="United States"
                              rdfs:label="Isabel Cruz"/>
          <swrc:Person rdf:about="JamesPustejovsky"
                              conferences:country="United States"
                              rdfs:label="James Pustejovsky">
            <conferences:affiliation>Department of Computer Science, Brandeis University</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="JaneHunter"
                              conferences:affiliation="University of Queensland"
                              conferences:country="Austria"
                              rdfs:label="Jane Hunter"/>
          <swrc:Person rdf:about="JeenBroekstra"
                              conferences:country="Netherlands"
                              rdfs:label="Jeen Broekstra">
            <conferences:affiliation>Technical University Eindhoven and Aduna</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="JeffHeflin"
                              conferences:affiliation="Lehigh University"
                              conferences:country="United States"
                              rdfs:label="Jeff Heflin"/>
          <swrc:Person rdf:about="JeffZPan"
                              conferences:affiliation="University of Aberdeen"
                              conferences:country="United Kingdom"
                              rdfs:label="Jeff Z. Pan"/>
          <swrc:Person rdf:about="JeremyJCarroll"
                              conferences:affiliation="HP Labs"
                              conferences:country="United Kingdom"
                              rdfs:label="Jeremy J. Carroll"/>
          <swrc:Person rdf:about="JeromeEuzenat"
                              conferences:affiliation="INRIA Rhone-Alpes"
                              conferences:country="France"
                              rdfs:label="Jerome Euzenat"/>
          <swrc:Person rdf:about="JerryHobbs"
                              conferences:affiliation="University of Southern California"
                              conferences:country="United States"
                              rdfs:label="Jerry Hobbs"/>
          <swrc:Person rdf:about="JimHendler"
                              conferences:affiliation="University of Maryland"
                              conferences:country="United States"
                              rdfs:label="Jim Hendler"/>
          <swrc:Person rdf:about="JinghaiRao"
                              conferences:affiliation="Carnegie Mellon University"
                              conferences:country="United States"
                              rdfs:label="Jinghai Rao"/>
          <swrc:Person rdf:about="JoergDiedrich"
                              conferences:affiliation="L3S Hannover"
                              conferences:country="Germany"
                              rdfs:label="Joerg Diedrich"/>
          <swrc:Person rdf:about="JohannEder"
                              conferences:affiliation="University of Vienna"
                              conferences:country="Austria"
                              rdfs:label="Johann Eder"/>
          <swrc:Person rdf:about="JohnBateman"
                              conferences:country="Germany"
                              rdfs:label="John Bateman">
            <conferences:affiliation>Department of Applied English Linguistics, University of Bremen</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="JohnDavies"
                              conferences:affiliation="BT"
                              conferences:country="United Kingdom"
                              rdfs:label="John Davies"/>
          <swrc:Person rdf:about="JohnMylopoulos"
                              conferences:affiliation="University of Toronto"
                              conferences:country="Canada"
                              rdfs:label="John Mylopoulos"/>
          <swrc:Person rdf:about="JohnSowa"
                              conferences:affiliation="Vivomind Intelligence Inc."
                              conferences:country="United States"
                              rdfs:label="John Sowa"/>
          <swrc:Person rdf:about="JoostBreuker"
                              conferences:country="Netherlands"
                              rdfs:label="Joost Breuker">
            <conferences:affiliation>Leibniz Center for Law, University of Amsterdam</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="JosdeBruijn"
                              conferences:affiliation="DERI Innsbruck"
                              conferences:country="Austria"
                              rdfs:label="Jos de Bruijn"/>
          <swrc:Journal rdf:about="JournalofWebSemantics"
                               conferences:interval="quarterly"
                               conferences:issn="1570-8268"
                               rdfs:label="Journal of Web Semantics">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://authors.elsevier.com/JournalDetail.html?PubID=671322</conferences:URL>
          </swrc:Journal>

          <swrc:Person rdf:about="JrgenAngele"
                              conferences:affiliation="Ontoprise"
                              conferences:country="Germany"
                              rdfs:label="Jürgen Angele"/>
          <swrc:Person rdf:about="JuergenAngele"
                              conferences:affiliation="Ontoprise GmbH"
                              conferences:country="Germany"
                              rdfs:label="Juergen Angele"/>
          <swrc:Conference rdf:about="KES2006" swrc:year="2006"
                                  rdfs:label="KES2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://kes2006.kesinternational.org</conferences:URL>
            <conferences:place rdf:datatype="&xsd;string">Bournemouth International Conference Centre</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-10-09</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-10-11</conferences:submissionsDue>
            <swrc:title>10th International Conference on Knowledge-Based &amp; Intelligent Information &amp; Engineering Systems</swrc:title>
            <swrc:isAbout rdf:resource="IntelligentSystems"/>
            <swrc:isAbout rdf:resource="KnowledgeEngineering"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">50.72</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-1.88</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="KalinaBontcheva"
                              conferences:affiliation="University Sheffield"
                              conferences:country="United Kingdom"
                              rdfs:label="Kalina Bontcheva"/>
          <swrc:Person rdf:about="KatiaSycara"
                              conferences:affiliation="Carnegie Mellon University"
                              conferences:country="United States"
                              rdfs:label="Katia Sycara"/>
          <swrc:Person rdf:about="KavithaSrinivas"
                              conferences:affiliation="IBM T. J. Watson Research Center"
                              conferences:country="United States"
                              rdfs:label="Kavitha Srinivas"/>
          <swrc:Topic rdf:about="KnowledgeEngineering">
            <rdfs:label rdf:datatype="&xsd;string">KnowledgeEngineering</rdfs:label>
          </swrc:Topic>

          <swrc:Person rdf:about="KrzysztofWecel"
                              conferences:affiliation="Poznan University of Economics"
                              conferences:country="Poland"
                              rdfs:label="Krzysztof Wecel"/>
          <swrc:Person rdf:about="LarryKerschberg"
                              conferences:affiliation="George Mason University"
                              conferences:country="United States"
                              rdfs:label="Larry Kerschberg"/>
          <swrc:Person rdf:about="LaureVieu"
                              conferences:country="France"
                              rdfs:label="Laure Vieu">
            <conferences:affiliation>Research Institute for Computer Science, CNRS, Toulouse</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="LeoObrst"
                              conferences:affiliation="MITRE"
                              conferences:country="United States"
                              rdfs:label="Leo Obrst"/>
          <swrc:Person rdf:about="LeonardoLesmo"
                              conferences:country="Italy"
                              rdfs:label="Leonardo Lesmo">
            <conferences:affiliation>Department of Computer Science, University of Torino</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="LilianaCabral"
                              conferences:affiliation="Open University"
                              conferences:country="United Kingdom"
                              rdfs:label="Liliana Cabral"/>
          <swrc:Person rdf:about="LjiljanaStojanovic"
                              conferences:affiliation="FZI Karlsruhe"
                              conferences:country="Germany"
                              rdfs:label="Ljiljana Stojanovic"/>
          <swrc:Person rdf:about="ManolisKoubarakis"
                              conferences:affiliation="Technical University of Crete"
                              conferences:country="Greece"
                              rdfs:label="Manolis Koubarakis"/>
          <swrc:Person rdf:about="MarcoAntonioCasanova"
                              conferences:affiliation="PUC-Rio"
                              conferences:country="Brazil"
                              rdfs:label="Marco Antonio Casanova"/>
          <swrc:Person rdf:about="MarcoPistore"
                              conferences:affiliation="University of Trento"
                              conferences:country="Italy"
                              rdfs:label="Marco Pistore"/>
          <swrc:Person rdf:about="MariGeorges"
                              conferences:affiliation="ILOG"
                              conferences:country="France"
                              rdfs:label="Mari Georges"/>
          <swrc:Person rdf:about="MarieChristineRousset"
                              conferences:affiliation="University Orsay"
                              conferences:country="France"
                              rdfs:label="Marie-Christine Rousset"/>
          <swrc:Person rdf:about="MaristellaAgosti"
                              conferences:affiliation="University of Padova"
                              conferences:country="Italy"
                              rdfs:label="Maristella Agosti"/>
          <swrc:Person rdf:about="MarkoGrobelnik"
                              conferences:affiliation="J. Stefan Institute"
                              conferences:country="Slovenia"
                              rdfs:label="Marko Grobelnik"/>
          <swrc:Person rdf:about="MarkoTadic"
                              conferences:affiliation="University of Zagreb"
                              conferences:country="Croatia"
                              rdfs:label="Marko Tadic"/>
          <swrc:Person rdf:about="MartinDrr"
                              conferences:country="Greece"
                              rdfs:label="Martin Dörr">
            <conferences:affiliation>Institute of Computer Science, FORTH, Heraklion</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="MartinDzbor"
                              conferences:affiliation="Open University"
                              conferences:country="United Kingdom"
                              rdfs:label="Martin Dzbor"/>
          <swrc:Person rdf:about="MartinHepp"
                              conferences:affiliation="University of Innsbruck and DERI"
                              conferences:country="Austria"
                              rdfs:label="Martin Hepp"/>
          <swrc:Person rdf:about="MasahiroHori"
                              conferences:affiliation="Kansai University"
                              conferences:country="Japan"
                              rdfs:label="Masahiro Hori"/>
          <swrc:Person rdf:about="MassimoPoesio"
                              conferences:country="United Kingdom"
                              rdfs:label="Massimo Poesio">
            <conferences:affiliation>Department of Computer Science, University of Essex</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="MatteoCristani"
                              conferences:affiliation="University of Verona"
                              conferences:country="Italy"
                              rdfs:label="Matteo Cristani"/>
          <swrc:Person rdf:about="MatthiasKlusch"
                              conferences:affiliation="DFKI Saarbruecken"
                              conferences:country="Germany"
                              rdfs:label="Matthias Klusch"/>
          <swrc:Person rdf:about="MaurizioLenzerini"
                              conferences:affiliation="Universita di Roma Sapienza"
                              conferences:country="Italy"
                              rdfs:label="Maurizio Lenzerini"/>
          <swrc:Person rdf:about="MichaelGruninger"
                              conferences:affiliation="University of Toronto"
                              conferences:country="Canada"
                              rdfs:label="Michael Gruninger"/>
          <swrc:Person rdf:about="MichaelSintek"
                              conferences:affiliation="DFKI Kaiserslautern"
                              conferences:country="Germany"
                              rdfs:label="Michael Sintek"/>
          <swrc:Person rdf:about="MichaelStollberg"
                              conferences:affiliation="DERI Innsbruck"
                              conferences:country="Austria"
                              rdfs:label="Michael Stollberg"/>
          <swrc:Person rdf:about="MichaelWooldridge"
                              conferences:affiliation="University of Liverpool"
                              conferences:country="United Kingdom"
                              rdfs:label="Michael Wooldridge"/>
          <swrc:Person rdf:about="MicheleMissikoff"
                              conferences:affiliation="CNR"
                              conferences:country="Italy"
                              rdfs:label="Michele Missikoff"/>
          <swrc:Person rdf:about="MihhailMatskin"
                              conferences:affiliation="KTH Stockholm"
                              conferences:country="Sweden"
                              rdfs:label="Mihhail Matskin"/>
          <swrc:Person rdf:about="MikeUschold"
                              conferences:affiliation="The Boeing Company"
                              conferences:country="United States"
                              rdfs:label="Mike Uschold"/>
          <swrc:Topic rdf:about="MobileComputing">
            <rdfs:label rdf:datatype="&xsd;string">MobileComputing</rdfs:label>
          </swrc:Topic>

          <swrc:Person rdf:about="MohandSaidHacid"
                              conferences:affiliation="Universite Claude Bernard Lyon"
                              conferences:country="France"
                              rdfs:label="Mohand Said Hacid"/>
          <swrc:Topic rdf:about="Multiagent-Systems">
            <rdfs:label rdf:datatype="&xsd;string">Multiagent-Systems</rdfs:label>
          </swrc:Topic>

          <swrc:Topic rdf:about="MultiagentSystems">
            <rdfs:label rdf:datatype="&xsd;string">MultiagentSystems</rdfs:label>
          </swrc:Topic>

          <swrc:Conference rdf:about="NETObjectDays2006" swrc:year="2006"
                                  rdfs:label="NET.ObjectDays2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.netobjectdays.org</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-09-21</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Erfurt, Germany</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-09-18</conferences:start>
            <swrc:title rdf:datatype="&xsd;string">Net.ObjectDays 2006</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">50.983333</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">11.033333</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="NathalieAussenacGilles"
                              conferences:country="France"
                              rdfs:label="Nathalie Aussenac-Gilles">
            <conferences:affiliation>Research Institute for Computer Science, CNRS, Toulouse</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="NicholasAsher"
                              conferences:country="United States"
                              rdfs:label="Nicholas Asher">
            <conferences:affiliation>Department of Philosophy, University of Texas at Austin</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="NicolaGuarino"
                              conferences:affiliation="CNR"
                              conferences:country="Italy"
                              rdfs:label="Nicola Guarino"/>
          <swrc:Person rdf:about="NicolaHenze"
                              conferences:affiliation="University of Hannover"
                              conferences:country="Germany"
                              rdfs:label="Nicola Henze"/>
          <swrc:Person rdf:about="NigelCollier"
                              conferences:affiliation="National Institute of Informatics"
                              conferences:country="Japan"
                              rdfs:label="Nigel Collier"/>
          <swrc:Conference rdf:about="ODBASE2006" swrc:year="2006"
                                  rdfs:label="ODBASE 2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.cs.rmit.edu.au/fedconf/</conferences:URL>
            <conferences:abstractsDue rdf:datatype="&xsd;date">2006-05-30</conferences:abstractsDue>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-08-05</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-08-20</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-11-03</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www.cs.rmit.edu.au/fedconf/img/odbase2006cfp.gif</conferences:logo>
            <conferences:pcMember rdf:resource="AlexBorgida"/>
            <conferences:pcMember rdf:resource="ArantzaIllarramendi"/>
            <conferences:pcMember rdf:resource="BillAndersen"/>
            <conferences:pcMember rdf:resource="ChrisWelty"/>
            <conferences:pcMember rdf:resource="ChristophBussler"/>
            <conferences:pcMember rdf:resource="DavidToman"/>
            <conferences:pcMember rdf:resource="FranzBaader"/>
            <conferences:pcMember rdf:resource="GeorgLausen"/>
            <conferences:pcMember rdf:resource="GiuseppeDeGiacomo"/>
            <conferences:pcMember rdf:resource="GuidoVetere"/>
            <conferences:pcMember rdf:resource="HeikoSchuldt"/>
            <conferences:pcMember rdf:resource="JeffHeflin"/>
            <conferences:pcMember rdf:resource="JimHendler"/>
            <conferences:pcMember rdf:resource="JohannEder"/>
            <conferences:pcMember rdf:resource="JohnMylopoulos"/>
            <conferences:pcMember rdf:resource="JuergenAngele"/>
            <conferences:pcMember rdf:resource="LarryKerschberg"/>
            <conferences:pcMember rdf:resource="MarcoAntonioCasanova"/>
            <conferences:pcMember rdf:resource="MaristellaAgosti"/>
            <conferences:pcMember rdf:resource="MicheleMissikoff"/>
            <conferences:pcMember rdf:resource="MohandSaidHacid"/>
            <conferences:pcMember rdf:resource="NicolaGuarino"/>
            <conferences:pcMember rdf:resource="PeterSchwarz"/>
            <conferences:pcMember rdf:resource="PeterSpyns"/>
            <conferences:pcMember rdf:resource="RainerEckstein"/>
            <conferences:pcMember rdf:resource="RogerBuzzKing"/>
            <conferences:pcMember rdf:resource="RossKing"/>
            <conferences:pcMember rdf:resource="SergioTessaris"/>
            <conferences:pcMember rdf:resource="SibelAdali"/>
            <conferences:pcMember rdf:resource="SilvanaCastano"/>
            <conferences:pcMember rdf:resource="SoniaBergamaschi"/>
            <conferences:pcMember rdf:resource="StefanDecker"/>
            <conferences:pcMember rdf:resource="ThomasRisse"/>
            <conferences:pcMember rdf:resource="TizianaCatarci"/>
            <conferences:pcMember rdf:resource="VipulKashyap"/>
            <conferences:pcMember rdf:resource="WolfgangNeijdl"/>
            <conferences:pcMember rdf:resource="YorkSure"/>
            <conferences:place rdf:datatype="&xsd;string">Montpellier, France</conferences:place>
            <conferences:programmeCommittee rdf:datatype="&xsd;string">* Sibel Adali (Rensselaer Polytechnic Univ., USA)
            * Maristella Agosti (University of Padova, Italy)
            * Bill Andersen (OntoWorks, USA)
            * Juergen Angele (Ontoprise GmbH, Germany)
            * Franz Baader (University of Dresden, Germany)
            * Sonia Bergamaschi (Università di Modena e Reggio Emilia, Italy)
            * Alex Borgida (Rutgers University, USA)
            * Christoph Bussler (Cisco Systems, USA)
            * Marco Antonio Casanova (PUC-Rio, Brazil)
            * Silvana Castano (University of Milan, Italy)
            * Tiziana Catarci (Universita\' degli Studi di Roma "La Sapienza", Italy)
            * Giuseppe De Giacomo (University of Roma "La Sapienza", Italy)
            * Stefan Decker (DERI Galway, Ireland)
            * Rainer Eckstein (Humboldt-Universitaet zu Berlin, Germany)
            * Johann Eder (University of Vienna, Austria)
            * Nicola Guarino (CNR, Trento, Italy)
            * Mohand Said Hacid (Universite Claude Bernard Lyon, France)
            * Jeff Heflin (Lehigh University, USA)
            * Jim Hendler (University of Maryland, College Park)
            * Edward Hung (Hong Kong Polytechnic University)
            * Arantza Illarramendi (Basque Country University, Spain)
            * Vipul Kashyap (Partners HealthCare Systems, USA)
            * Larry Kerschberg (George Mason University, USA)
            * Ross King (Research Studios Austria - DME, Austria)
            * Roger (Buzz) King (University of Colorado, USA)
            * Harumi Kuno (HP Labs)
            * Georg Lausen (University of Freiburg, Germany)
            * Michele Missikoff (CNR, Italy)
            * John Mylopoulos (University of Toronto, Canada)
            * Wolfgang Neijdl (L3C, Germany)
            * Christine Parent (Universite de Lausanne Switzerland)
            * Thomas Risse (Fraunhofer IPSI, Germany)
            * Heiko Schuldt (University Basel, Switzerland)
            * Peter Schwarz (IBM, USA)
            * Peter Spyns (Vrije Universiteit Brussels, Belgium)
            * York Sure (University Karlsruhe, Germany)
            * Sergio Tessaris (Free University of Bozen-Bolzano, Italy)
            * David Toman (University of Waterloo, Canada)
            * Guido Vetere (IBM, Italy)
            * Chris Welty (IBM, USA)</conferences:programmeCommittee>
            <conferences:start rdf:datatype="&xsd;date">2006-10-29</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-06-10</conferences:submissionsDue>
            <swrc:title>5th International Conference on Ontologies, DataBases, and Applications of Semantics</swrc:title>
            <swrc:isAbout rdf:resource="Databases"/>
            <swrc:isAbout rdf:resource="Ontologies"/>
            <rdfs:comment>As in previous years, the 2006 conference on Ontologies, DataBases, and Applications of
        Semantics (ODBASE\'06) provides a forum for exchanging the latest research results on ontologies,
        data semantics, and other areas of computing involved in developing the Semantic Web.

        ODBASE06 intends to draw a highly diverse body of researchers and practitioners by being part
        of the Federated Symposium Event "On the Move to Meaningful Internet Systems 2006" that co-locates
        four conferences: ODBASE06, DOA06 (International Symposium on Distributed Objects and Applications),
        CoopIS06 (International Conference on Cooperative Information Systems), and GADA06 (International
        Symposium on Grid computing, high-performAnce and Distributed Applications).

        Of particular relevance to ODBASE06 are papers that bridge traditional boundaries
        between disciplines such as databases, artificial intelligence, networking, computational
        linguistics, and mobile computing. ODBASE06 also encourages the submission of research and
        practical experience papers concerning scalability issues in ontology management, information
        integration, and data mining, as well as papers that examine the information needs of various
        applications, including electronic commerce, electronic government, mobile systems,
        and bioinformatics.

        ODBASE06 will consider two categories of papers: research and experience. Research papers must
        contain novel, unpublished results. Experience papers must describe existing, realistically
        large systems. Preference will be given to papers that describe software products or systems
        that are in wide experimental use.</rdfs:comment>
            <wgs84_pos:lat rdf:datatype="&xsd;float">43.611944</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">3.877222</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Topic rdf:about="Ontologies"/>
          <swrc:Person rdf:about="OscarCorcho"
                              conferences:affiliation="University of Manchester"
                              conferences:country="United Kingdom"
                              rdfs:label="Oscar Corcho"/>
          <swrc:Topic rdf:about="P2P"/>
          <swrc:Conference rdf:about="PSI2006" swrc:year="2006"
                                  rdfs:label="PSI2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.iis.nsk.su/PSI06/</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-06-30</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Novosibirsk, Akademgorodok, Russia</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-06-27</conferences:start>
            <swrc:title>Sixth International Andrei Ershov Memorial Conference</swrc:title>
            <swrc:isAbout rdf:resource="ArtificialIntelligence"/>
            <swrc:isAbout rdf:resource="Databases"/>
            <swrc:isAbout rdf:resource="SoftwareEngineering"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">54.988889</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">82.904167</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="PaoloBouquet"
                              conferences:affiliation="University of Trento"
                              conferences:country="Italy"
                              rdfs:label="Paolo Bouquet"/>
          <swrc:Person rdf:about="PaoloTraverso"
                              conferences:country="Italy"
                              rdfs:label="Paolo Traverso">
            <conferences:affiliation>Automated Reasoning Systems Division at ITC/IRST</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="PascalHitzler"
                              conferences:affiliation="University of Karlsruhe"
                              conferences:country="Germany"
                              rdfs:label="Pascal Hitzler"/>
          <swrc:Person rdf:about="PaulBuitelaar"
                              conferences:affiliation="DFKI Saarbruecken"
                              conferences:country="Germany"
                              rdfs:label="Paul Buitelaar"/>
          <swrc:Person rdf:about="PaulodaPinheiro"
                              conferences:affiliation="Stanford University"
                              conferences:country="United States"
                              rdfs:label="Paulo da Pinheiro"/>
          <swrc:Person rdf:about="PeterSchwarz"
                              conferences:affiliation="IBM"
                              conferences:country="United States"
                              rdfs:label="Peter Schwarz"/>
          <swrc:Person rdf:about="PeterSpyns"
                              rdfs:label="Peter Spyns">
            <conferences:affiliation rdf:datatype="&xsd;string">Vrije Universiteit Brussels</conferences:affiliation>
            <conferences:country xml:lang="en">Belgium</conferences:country>
          </swrc:Person>

          <swrc:Person rdf:about="PhilippeMuller"
                              conferences:country="France"
                              rdfs:label="Philippe Muller">
            <conferences:affiliation>Research Institute for Computer Science, University of Toulouse III</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="PierdanieleGiaretta"
                              conferences:country="Italy"
                              rdfs:label="Pierdaniele Giaretta">
            <conferences:affiliation>Department of Philosophy, University of Verona</conferences:affiliation>
          </swrc:Person>

          <swrc:Topic rdf:about="ProcessModeling">
            <rdfs:label rdf:datatype="&xsd;string">ProcessModeling</rdfs:label>
          </swrc:Topic>

          <swrc:Person rdf:about="RainerEckstein"
                              conferences:affiliation="Humboldt-Universitaet zu Berlin"
                              conferences:country="Germany"
                              rdfs:label="Rainer Eckstein"/>
          <swrc:Person rdf:about="RalfMoeller"
                              conferences:affiliation="Hamburg University of Technology"
                              conferences:country="Germany"
                              rdfs:label="Ralf Moeller"/>
          <swrc:Person rdf:about="RaphaelTroncy"
                              conferences:affiliation="CWI Amsterdam"
                              conferences:country="Netherlands"
                              rdfs:label="Raphael Troncy"/>
          <swrc:Person rdf:about="RichardBenjamins"
                              conferences:affiliation="iSOCO"
                              conferences:country="Spain"
                              rdfs:label="Richard Benjamins"/>
          <swrc:Person rdf:about="RichmondThomason"
                              conferences:affiliation="University of Michigan"
                              conferences:country="United States"
                              rdfs:label="Richmond Thomason"/>
          <swrc:Person rdf:about="RiichiroMizoguchi"
                              conferences:affiliation="Osaka University"
                              conferences:country="Japan"
                              rdfs:label="Riichiro Mizoguchi"/>
          <swrc:Person rdf:about="RobertRynasiewicz"
                              conferences:affiliation="Johns Hopkins University"
                              conferences:country="United States"
                              rdfs:label="Robert Rynasiewicz"/>
          <swrc:Person rdf:about="RobertTolksdorf"
                              conferences:affiliation="Free University Berlin"
                              conferences:country="Germany"
                              rdfs:label="Robert Tolksdorf"/>
          <swrc:Person rdf:about="RobertoCasati"
                              conferences:affiliation="Jean Nicod Institute, CNRS, Paris"
                              conferences:country="France"
                              rdfs:label="Roberto Casati"/>
          <swrc:Person rdf:about="RogerBuzzKing"
                              conferences:affiliation="University of Colorado"
                              conferences:country="United States"
                              rdfs:label="Roger (Buzz) King"/>
          <swrc:Person rdf:about="RossKing"
                              conferences:affiliation="Research Studios Austria - DME"
                              conferences:country="Austria"
                              rdfs:label="Ross King"/>
          <swrc:Person rdf:about="RubenLara"
                              conferences:affiliation="Tecnologia, Informacion y Finanzas"
                              conferences:country="Spain"
                              rdfs:label="Ruben Lara"/>
          <swrc:Person rdf:about="RudiStuder"
                              conferences:affiliation="University of Karlsruhe"
                              conferences:country="Germany"
                              rdfs:label="Rudi Studer"/>
          <swrc:Conference rdf:about="SCC2006" swrc:year="2006"
                                  rdfs:label="SCC2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://conferences.computer.org/scc</conferences:URL>
            <conferences:inConjunctionWith rdf:resource="CoSTEP2006"/>
            <swrc:title rdf:datatype="&xsd;string">IEEE International Conference on Services Computing</swrc:title>
          </swrc:Conference>

          <swrc:Conference rdf:about="SIGMOD2006" swrc:year="2006"
                                  rdfs:label="SIGMOD2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://tangra.si.umich.edu/clair/sigmod-pods06</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-06-29</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Chicago, USA</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-06-26</conferences:start>
            <swrc:title rdf:datatype="&xsd;string">ACM SIGMOD International Conference on Management of Data</swrc:title>
            <swrc:isAbout rdf:resource="Databases"/>
            <swrc:isAbout rdf:resource="P2P"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">41.9</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-87.65</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="SeanBechhofer"
                              conferences:affiliation="University of Manchester"
                              conferences:country="United Kingdom"
                              rdfs:label="Sean Bechhofer"/>
          <swrc:Conference rdf:about="SemTech2006" swrc:year="2006"
                                  swrc:title="2006 Semantic Technology Conference"
                                  rdfs:label="SemTech 2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.semantic-conference.com/</conferences:URL>
            <conferences:audience rdf:datatype="&xsd;string">Academia</conferences:audience>
            <conferences:audience>Business</conferences:audience>
            <conferences:audience>Investors</conferences:audience>
            <conferences:end rdf:datatype="&xsd;date">2006-03-09</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">San Jose, California, USA</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-03-06</conferences:start>
            <wgs84_pos:lat rdf:datatype="&xsd;float">37.304167</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-121.872778</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Topic rdf:about="SemanticWeb"/>
          <swrc:Person rdf:about="SergioTessaris"
                              conferences:affiliation="Free University Bozen"
                              conferences:country="Italy"
                              rdfs:label="Sergio Tessaris"/>
          <swrc:Person rdf:about="SibelAdali"
                              conferences:affiliation="Rensselaer Polytechnic Univ."
                              conferences:country="United States"
                              rdfs:label="Sibel Adali"/>
          <swrc:Person rdf:about="SiegfriedHandschuh"
                              conferences:affiliation="FZI Karlsruhe"
                              conferences:country="Germany"
                              rdfs:label="Siegfried Handschuh"/>
          <swrc:Person rdf:about="SilvanaCastano"
                              conferences:affiliation="University of Milan"
                              conferences:country="Italy"
                              rdfs:label="Silvana Castano"/>
          <swrc:Person rdf:about="SimonMilton"
                              conferences:country="Australia"
                              rdfs:label="Simon Milton">
            <conferences:affiliation>Department of Information Systems, University of Melbourne</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="SofiaPinto"
                              conferences:affiliation="Technical University of Lisbon"
                              conferences:country="Portugal"
                              rdfs:label="Sofia Pinto"/>
          <swrc:Topic rdf:about="SoftwareEngineering">
            <rdfs:label rdf:datatype="&xsd;string">SoftwareEngineering</rdfs:label>
          </swrc:Topic>

          <swrc:Person rdf:about="SoniaBergamaschi"
                              conferences:affiliation="Università di Modena e Reggio Emilia"
                              conferences:country="Italy"
                              rdfs:label="Sonia Bergamaschi"/>

          <swrc:Person rdf:about="StefanDecker"
                              conferences:affiliation="DERI Galway"
                              conferences:country="Ireland"
                              rdfs:label="Stefan Decker"/>
          <swrc:Person rdf:about="StefanSchlobach"
                              conferences:affiliation="Vrije Universiteit Amsterdam"
                              conferences:country="Netherlands"
                              rdfs:label="Stefan Schlobach"/>
          <swrc:Person rdf:about="StefanoBorgo"
                              conferences:country="Italy"
                              rdfs:label="Stefano Borgo">
            <conferences:affiliation>Laboratory for Applied Ontology, ISTC-CNR</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="SteffenStaab"
                              conferences:affiliation="University of Koblenz"
                              conferences:country="Germany"
                              rdfs:label="Steffen Staab"/>
          <swrc:Person rdf:about="SteveWillmott"
                              conferences:affiliation="Universidad Politecnica de Cataluna"
                              conferences:country="Spain"
                              rdfs:label="Steve Willmott"/>
          <swrc:Conference rdf:about="TMRA2006" swrc:year="2006"
                                  swrc:title="Topic Maps Research and Applications"
                                  rdfs:label="TMRA 2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.informatik.uni-leipzig.de/~tmra/</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-02-12</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Leipzig, Germany</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-10-11</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-06-02</conferences:submissionsDue>
            <swrc:isAbout rdf:resource="TopicMaps"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">51.333333</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">12.383333</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="TerryPayne"
                              conferences:affiliation="University of Southampton"
                              conferences:country="United Kingdom"
                              rdfs:label="Terry Payne"/>
          <swrc:Person rdf:about="ThomasRisse"
                              conferences:affiliation="Fraunhofer IPSI"
                              conferences:country="Germany"
                              rdfs:label="Thomas Risse"/>
          <swrc:Person rdf:about="TizianaCatarci"
                              conferences:country="Italy"
                              rdfs:label="Tiziana Catarci">
            <conferences:affiliation>Universita\' degli Studi di Roma "La Sapienza"</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="TonyCohn"
                              conferences:country="United Kingdom"
                              rdfs:label="Tony Cohn">
            <conferences:affiliation>School of Computing, University of Leeds</conferences:affiliation>
          </swrc:Person>

          <swrc:Topic rdf:about="TopicMaps"/>
          <swrc:Person rdf:about="UbboVisser"
                              conferences:affiliation="University of Bremen"
                              conferences:country="Germany"
                              rdfs:label="Ubbo Visser"/>
          <swrc:Person rdf:about="UdoHahn"
                              conferences:affiliation="Jena University"
                              conferences:country="Germany"
                              rdfs:label="Udo Hahn"/>
          <swrc:Person rdf:about="UlrichReimer"
                              conferences:country="Switzerland"
                              rdfs:label="Ulrich Reimer">
            <conferences:affiliation>University of Konstanz and University of Applied Sciences St. Gallen</conferences:affiliation>
          </swrc:Person>

          <swrc:Conference rdf:about="VLDB2006" swrc:year="2006"
                                  rdfs:label="VLDB2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://aitrc.kaist.ac.kr/~vldb06/</conferences:URL>
            <conferences:abstractsDue rdf:datatype="&xsd;date">2006-03-09</conferences:abstractsDue>
            <conferences:acceptanceNotification rdf:datatype="&xsd;date">2006-05-30</conferences:acceptanceNotification>
            <conferences:camera-readySubmission rdf:datatype="&xsd;date">2006-06-23</conferences:camera-readySubmission>
            <conferences:end rdf:datatype="&xsd;date">2006-09-15</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Convention and Exhibition Center (COEX), Seoul, Korea</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-09-12</conferences:start>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-03-16</conferences:submissionsDue>
            <swrc:title>32nd International Conference on Very Large Data Bases</swrc:title>
            <swrc:isAbout rdf:resource="Databases"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">37.583333</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">127</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="ValentinaTamma"
                              conferences:affiliation="University of Liverpool"
                              conferences:country="United Kingdom"
                              rdfs:label="Valentina Tamma"/>
          <swrc:Person rdf:about="VangelisKarkaletsis"
                              conferences:affiliation="NCSR Demokritos"
                              conferences:country="Greece"
                              rdfs:label="Vangelis Karkaletsis"/>
          <swrc:Person rdf:about="VedaStorey"
                              conferences:country="United States"
                              rdfs:label="Veda Storey">
            <conferences:affiliation>Department of Computer Information Systems, Georgia State University</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="VibhuMittal"
                              conferences:affiliation="Google Research"
                              conferences:country="United States"
                              rdfs:label="Vibhu Mittal"/>
          <swrc:Person rdf:about="VipulKashyap"
                              conferences:affiliation="Clinical informatics R&amp;D"
                              conferences:country="United States"
                              rdfs:label="Vipul Kashyap"/>
          <swrc:Person rdf:about="VojtechSvatek"
                              conferences:affiliation="University of Economics"
                              conferences:country="Czech Republic"
                              rdfs:label="Vojtech Svatek"/>
          <swrc:Person rdf:about="VolkerHaarslev"
                              conferences:affiliation="Concordia University"
                              conferences:country="Canada"
                              rdfs:label="Volker Haarslev"/>
          <swrc:Conference rdf:about="WETICE2006" swrc:year="2006"
                                  rdfs:label="WETICE 2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://wetice.co.umist.ac.uk/</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-06-28</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://wetice.co.umist.ac.uk/assets/images/wetice2006.jpg</conferences:logo>
            <conferences:place rdf:datatype="&xsd;string">The University of Manchester, Manchester, U.K.</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-06-26</conferences:start>
            <swrc:title>15th International Workshops on Enabling Technologies: Infrastructures for Collaborative Enterprises</swrc:title>
            <swrc:isAbout rdf:resource="E-Collaboration"/>
            <swrc:isAbout rdf:resource="Multiagent-Systems"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">53.483333</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-2.25</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="WORLDCOMP06" swrc:year="2006"
                                  rdfs:label="WORLDCOMP06">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www.world-academy-of-science.org/worldcomp06/ws</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-06-29</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Las Vegas, USA</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-06-26</conferences:start>
            <swrc:title>The 2006 World Congress in Computer Science, Computer Engineering, and Applied Computing</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">36.183333</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-115.216667</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Conference rdf:about="WWW2006" swrc:year="2006"
                                  rdfs:label="WWW2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www2006.org</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-05-26</conferences:end>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www2006.org/images/template/titlelogo.gif</conferences:logo>
            <conferences:place rdf:datatype="&xsd;string">Edinburgh International Conference Centre</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-05-23</conferences:start>
            <swrc:title>15th International World Wide Web Conference</swrc:title>
            <swrc:isAbout rdf:resource="WorldWideWeb"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">55.949556</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-3.160288</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="WalterBinder"
                              conferences:affiliation="EPFL"
                              conferences:country="Switzerland"
                              rdfs:label="Walter Binder"/>
          <swrc:Topic rdf:about="WebApplications">
            <rdfs:label rdf:datatype="&xsd;string">WebApplications</rdfs:label>
          </swrc:Topic>

          <swrc:Topic rdf:about="WebServices">
            <rdfs:label rdf:datatype="&xsd;string">WebServices</rdfs:label>
          </swrc:Topic>

          <swrc:Person rdf:about="WernerCeusters"
                              conferences:country="Germany"
                              rdfs:label="Werner Ceusters">
            <conferences:affiliation>European Centre for Ontological Research</conferences:affiliation>
          </swrc:Person>

          <swrc:Person rdf:about="WernerKuhn"
                              conferences:affiliation="IFGI"
                              conferences:country="Germany"
                              rdfs:label="Werner Kuhn"/>
          <swrc:Person rdf:about="WolfgangNeijdl"
                              conferences:affiliation="L3C"
                              conferences:country="Germany"
                              rdfs:label="Wolfgang Neijdl"/>
          <swrc:Person rdf:about="WolfgangNejdl"
                              conferences:affiliation="University of Hannover and L3S"
                              conferences:country="Germany"
                              rdfs:label="Wolfgang Nejdl"/>
          <swrc:Topic rdf:about="WorldWideWeb"/>
          <swrc:Topic rdf:about="XML">
            <rdfs:label rdf:datatype="&xsd;string">XML</rdfs:label>
          </swrc:Topic>

          <swrc:Conference rdf:about="XTECH2006" swrc:year="2006"
                                  rdfs:label="XTECH2006">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://xtech06.usefulinc.com/</conferences:URL>
            <conferences:end rdf:datatype="&xsd;date">2006-05-19</conferences:end>
            <conferences:place rdf:datatype="&xsd;string">Amsterdam, Netherlands</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2006-05-16</conferences:start>
            <swrc:title rdf:datatype="&xsd;string">XTECH 2006 "Building Web 2.0"</swrc:title>
            <swrc:isAbout rdf:resource="XML"/>
            <wgs84_pos:lat rdf:datatype="&xsd;float">52.370197</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">4.890444</wgs84_pos:long>
          </swrc:Conference>

          <swrc:Person rdf:about="YingDing"
                              conferences:affiliation="University of Innsbruck"
                              conferences:country="Austria"
                              rdfs:label="Ying Ding"/>
          <swrc:Person rdf:about="YorkSure"
                              conferences:affiliation="University Karlsruhe"
                              conferences:country="Germany"
                              rdfs:label="York Sure"/>




          <swrc:Workshop rdf:about="CKC2007" rdfs:label="CKC2007" swrc:year="2007">
            <conferences:URL rdf:datatype="&xsd;anyURI">https://km.aifb.uni-karlsruhe.de/ws/ckc2007</conferences:URL>
            <swrc:title>Workshop on Social and Collaborative Construction of Structured Knowledge</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">50.729502</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-110.67627</wgs84_pos:long>
            <conferences:conferenceChair rdf:resource="NatashaNoy" rdfs:label="Natasha Noy"/>
            <conferences:conferenceChair rdf:resource="HarithAlani"  rdfs:label="Harith Alani"/>
            <conferences:inConjunctionWith rdf:resource="WWW2007"/>
            <conferences:place rdf:datatype="&xsd;string">Banff, Canada</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2007-05-08</conferences:start>
          </swrc:Workshop>

          <swrc:Conference rdf:about="WWW2007" rdfs:label="WWW2007" swrc:year="2007">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://www2007.org/</conferences:URL>
            <conferences:place rdf:datatype="&xsd;string">Banff, Canada</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2007-05-08</conferences:start>
            <conferences:end rdf:datatype="&xsd;date">2007-05-12</conferences:end>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-11-20</conferences:submissionsDue>
            <swrc:title rdf:datatype="&xsd;string">16th International World Wide Web Conference</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">50.729502</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">-110.67627</wgs84_pos:long>
            <conferences:logo rdf:datatype="&xsd;anyURI">http://www2007.org/images/menuWWW2007logo.jpg</conferences:logo>
          </swrc:Conference>

          <swrc:Conference rdf:about="CSSW2007" rdfs:label="CSSW2007" swrc:year="2007">
            <conferences:URL rdf:datatype="&xsd;anyURI">http://aksw.org/SocialSemanticWebConference</conferences:URL>
            <conferences:place rdf:datatype="&xsd;string">Leipzig, Germany</conferences:place>
            <conferences:start rdf:datatype="&xsd;date">2007-09-26</conferences:start>
            <conferences:end rdf:datatype="&xsd;date">2007-09-28</conferences:end>
            <conferences:submissionsDue rdf:datatype="&xsd;date">2006-06-01</conferences:submissionsDue>
            <swrc:title rdf:datatype="&xsd;string">SABRE Conference on Social Semantic Web</swrc:title>
            <wgs84_pos:lat rdf:datatype="&xsd;float">51.340264</wgs84_pos:lat>
            <wgs84_pos:long rdf:datatype="&xsd;float">12.371292</wgs84_pos:long>
            <conferences:conferenceChair rdf:resource="SrenAuer"/>
            <conferences:conferenceChair rdf:resource="ChrisBizer" rdfs:label="Chris Bizer"/>
            <conferences:conferenceChair rdf:resource="ClaudiaMueller" rdfs:label="Claudia Müller"/>
            <conferences:conferenceChair rdf:resource="AnnaVZhdanova" rdfs:label="AnnaVZhdanova"/>
          </swrc:Conference>


          <swrc:University rdf:about="UniversityOfLeipzig" rdfs:label="University of Leipzig">
            <foaf:homepage rdf:resource="http://www.uni-leipzig.de/" />
            <swrc:hasParts rdf:resource="FMILeipzig" />
          </swrc:University>
          <swrc:Department rdf:about="FMILeipzig" rdfs:label="Faculty of Mathematics and Computer Science">
            <foaf:homepage rdf:resource="http://www.fmi.uni-leipzig.de/" />
            <swrc:hasParts rdf:resource="IfILeipzig" />
          </swrc:Department>
          <swrc:Institute rdf:about="IfILeipzig" rdfs:label="Department of Computer Science">
            <foaf:homepage rdf:resource="http://www.informatik.uni-leipzig.de/" />
            <swrc:hasParts rdf:resource="AKSW" />
          </swrc:Institute>



          <swrc:ResearchGroup rdf:about="AKSW" rdfs:label="Agile Knowledge Engineering and Semantic Web">
              <swrc:head rdf:resource="SrenAuer"/>
              <swrc:member rdf:resource="SrenAuer" rdfs:label="Sören Auer"/>
              <swrc:member rdf:resource="SebastianDietzold" rdfs:label="Sebastian Dietzold"/>
              <swrc:member rdf:resource="NormanHeino" rdfs:label="Norman Heino"/>
              <swrc:member rdf:resource="PhilippFrischmuth" rdfs:label="Philipp Frischmuth"/>
              <swrc:member rdf:resource="SebastianDietzold" rdfs:label="Sebastian Dietzold"/>
              <swrc:member rdf:resource="JensLehmann" rdfs:label="Jens Lehmann"/>
              <swrc:member rdf:resource="ThomasRiechert" rdfs:label="Thomas Riechert"/>
              <swrc:member rdf:resource="MuhammadAhtishamAslam" rdfs:label="Muhammad Ahtisham Aslam"/>
              <swrc:carriesOut rdf:resource="OntoWiki" />
              <swrc:carriesOut rdf:resource="SoftWiki" />
              <swrc:carriesOut rdf:resource="Powl" />
          </swrc:ResearchGroup>

          <swrc:SoftwareProject rdf:about="OntoWiki" rdfs:label="OntoWiki">
            <swrc:carriedOutBy rdf:resource="AKSW" />
         <doap:name>OntoWiki</doap:name>
         <doap:shortdesc>A Tool for Social, Semantic Collaboration</doap:shortdesc> 
         <doap:description>OntoWiki is a tool providing support for agile, distributed knowledge engineering scenarios. OntoWiki facilitates the visual presentation of a knowledge base as an information map, with different views on instance data. It enables intuitive authoring of semantic content, with an inline editing mode for editing RDF content, smiliar to WYSIWIG for text documents. It fosters social collaboration aspects by keeping track of changes, allowing to comment and discuss every single part of a knowledge base, enabling to rate and measure the popularity of content and honoring the activity of users.</doap:description>
         <doap:homepage rdf:resource="http://aksw.org/Projects/OntoWiki" />
         <doap:download-page rdf:resource="http://sourceforge.net/project/showfiles.php?group_id=99425" />
         <doap:bug-database rdf:resource="http://sourceforge.net/tracker/?group_id=99425&amp;atid=624170" />
         <doap:programming-language>PHP</doap:programming-language>
         <doap:programming-language>JavaScript</doap:programming-language>
         <doap:license rdf:resource="http://usefulinc.com/doap/licenses/gpl" />
         <doap:maintainer rdf:resource="SebastianDietzold" />
         <doap:developer rdf:resource="NormanHeino"/>
         <foaf:depiction rdf:resource="http://aksw.org/images/ontowiki-map-view.jpg" />
          </swrc:SoftwareProject>

          <swrc:SoftwareProject rdf:about="DBpedia" rdfs:label="DBpedia.org">
            <swrc:carriedOutBy rdf:resource="AKSW" />
         <doap:name>DBpedia.org</doap:name>
         <doap:description>DBpedia.org is a community effort to extract structured information from Wikipedia and to make this information available on the Web. dbpedia allows you to ask sophisticated queries against Wikipedia and to link other datasets on the Web to Wikipedia data.</doap:description>
         <doap:homepage rdf:resource="http://dbpedia.org" />
         <doap:programming-language>PHP</doap:programming-language>
         <doap:programming-language>JavaScript</doap:programming-language>
         <doap:maintainer rdf:resource="SrenAuer" />
         <doap:developer rdf:resource="JensLehmann"/>
         <doap:developer rdf:resource="SrenAuer"/>
         <foaf:depiction rdf:resource="http://aksw.org/images/wikipedia-query.png" />
          </swrc:SoftwareProject>

          <swrc:SoftwareProject rdf:about="Powl" rdfs:label="Powl">
            <swrc:carriedOutBy rdf:resource="AKSW" />
         <doap:name>Powl</doap:name>
         <doap:shortdesc>Semantic Web Development Plattform</doap:shortdesc> 
         <doap:description>Powl is a Semantic Web application development framework featuring a comprehensive API for handling RDF, RDFS and OWL, a library of semantic widgets and a web based user interface. Powl is implemented for the most widely deployed web application environment: PHP and MySQL. Powl was downloaded over 3.000 times and has an active developer and user community.</doap:description>
         <doap:homepage rdf:resource="http://aksw.org/Projects/Powl" />
         <doap:download-page rdf:resource="http://sourceforge.net/project/showfiles.php?group_id=99425" />
         <doap:bug-database rdf:resource="http://sourceforge.net/tracker/?group_id=99425&amp;atid=624170" />
         <doap:programming-language>PHP</doap:programming-language>
         <doap:programming-language>JavaScript</doap:programming-language>
         <doap:license rdf:resource="http://usefulinc.com/doap/licenses/gpl" />
         <doap:maintainer rdf:resource="SrenAuer" />
         <doap:developer rdf:resource="PhilippFrischmuth"/>
         <foaf:depiction rdf:resource="http://powl.sourceforge.net/images/powl-screenshot.png" />
          </swrc:SoftwareProject>

          <swrc:ResearchProject rdf:about="SoftWiki" rdfs:label="SoftWiki">
            <swrc:carriedOutBy rdf:resource="AKSW" />
         <doap:name>OntoWiki</doap:name>
         <doap:shortdesc>Distributed, End-user Centered Requirements Engineering for Evolutionary Software Development</doap:shortdesc> 
         <doap:description>The aim of the cooperative research project SoftWiki is to support the collaboration of all stakeholders in software development processes in particular with respect to software requirements. Potentially very large and spatially distributed user groups shall be enabled to collect, semantically enrich, classify and aggregate software requirements. The solution will be founded on the Semantic Web standards for terminological knowledge representation. The implementation will base on generic means of semantic collaboration using next generation Web user interfaces (in the spirit of Social Software and the Web 2.0) thus fostering completely new means of Requirements Engineering with very large user groups.</doap:description>
         <doap:homepage rdf:resource="http://softwiki.de" />
          </swrc:ResearchProject>

          <swrc:InProceedings rdf:about="auer-s-2006-736-a" rdfs:label="OntoWiki – A Tool for Social, Semantic Collaboration">
            <dc:identifier rdf:resource="http://www.informatik.uni-leipzig.de/~auer/publication/ontowiki.pdf" />
            <dc:publisher rdf:resource="ISWC2006" />
            <swrc:creator rdf:resource="SrenAuer" />
            <swrc:creator rdf:resource="SebastianDietzold" />
            <swrc:creator rdf:resource="ThomasRiechert" />
            <swrc:describesProject rdf:resource="OntoWiki" />
          </swrc:InProceedings>


          <swrc:AcademicStaff rdf:about="SebastianDietzold" conferences:country="Germany">
            <swrc:affiliation rdf:resource="UniversityOfLeipzig" />
            <rdf:type rdf:resource="&swrc;PhDStudent" />
            <rdf:type rdf:resource="&swrc;Person" />
            <swrc:lastName>Dietzold</swrc:lastName>
            <swrc:firstName>Sebastian</swrc:firstName>
            <swrc:fax>+49 341 9732329</swrc:fax>
            <foaf:workInfoHomepage>http://bis.informatik.uni-leipzig.de/SebastianDietzold</foaf:workInfoHomepage>
            <swrc:email>dietzold@informatik.uni-leipzig.de</swrc:email>
            <swrc:phone>+49 341 9732366</swrc:phone>
            <swrc:address>Johannisgasse 26, 04103 Leipzig, Germany</swrc:address>
            <foaf:depiction>http://aksw.org/images/jpegPhoto.php?name=sn&amp;value=Dietzold</foaf:depiction>
             <foaf:homepage rdf:resource="http://sebastian.dietzold.de"/>
             <rdfs:seeAlso rdf:resource="http://sebastian.dietzold.de/rdf/foaf.rdf"/>
             <foaf:mbox_sha1sum>16ef723e22f2b7c6fc04f151cc7bd400918330b3</foaf:mbox_sha1sum>
          </swrc:AcademicStaff>

          <swrc:AcademicStaff rdf:about="SrenAuer" conferences:country="Germany">
            <rdf:type rdf:resource="&swrc;Person" />
            <swrc:affiliation rdf:resource="UniversityOfLeipzig" />
            <swrc:lastName>Auer</swrc:lastName>
            <swrc:firstName>Sören</swrc:firstName>
            <swrc:fax>+49 341 9732329</swrc:fax>
            <foaf:workInfoHomepage>http://www.informatik.uni-leipzig.de/~auer</foaf:workInfoHomepage>
            <swrc:email>auer@informatik.uni-leipzig.de</swrc:email>
            <swrc:phone>+49 341 9732367</swrc:phone>
            <swrc:address>Johannisgasse 26, 04103 Leipzig, Germany</swrc:address>
            <foaf:depiction>http://aksw.org/images/jpegPhoto.php?name=sn&amp;value=Auer</foaf:depiction>
          </swrc:AcademicStaff>

          <swrc:AcademicStaff rdf:about="JensLehmann" conferences:country="Germany">
            <rdf:type rdf:resource="&swrc;Person" />
            <swrc:affiliation rdf:resource="UniversityOfLeipzig" />
            <rdf:type rdf:resource="&swrc;PhDStudent" />
            <swrc:lastName>Lehmann</swrc:lastName>
            <swrc:firstName>Jens</swrc:firstName>
            <swrc:fax>+49 341 9732329</swrc:fax>
            <foaf:workInfoHomepage>http://jens-lehmann.org/</foaf:workInfoHomepage>
            <swrc:email>lehmann@informatik.uni-leipzig.de</swrc:email>
            <swrc:phone>+49 341 9732260</swrc:phone>
            <swrc:address>Johannisgasse 26, 04103 Leipzig, Germany</swrc:address>
            <foaf:depiction>http://aksw.org/images/jpegPhoto.php?name=cn&amp;value=Jens+Lehmann</foaf:depiction>
          </swrc:AcademicStaff>

          <swrc:AcademicStaff rdf:about="ThomasRiechert" conferences:country="Germany">
            <rdf:type rdf:resource="&swrc;Person" />
            <swrc:affiliation rdf:resource="UniversityOfLeipzig" />
            <rdf:type rdf:resource="&swrc;PhDStudent" />
            <swrc:lastName>Riechert</swrc:lastName>
            <swrc:firstName>Thomas</swrc:firstName>
            <swrc:fax>+49 341 9732329</swrc:fax>
            <foaf:workInfoHomepage>http://bis.informatik.uni-leipzig.de/ThomasRiechert</foaf:workInfoHomepage>
            <swrc:email>riechert@informatik.uni-leipzig.de</swrc:email>
            <swrc:phone>+49 341 9732323</swrc:phone>
            <swrc:address>Johannisgasse 26, 04103 Leipzig, Germany</swrc:address>
            <foaf:depiction>http://aksw.org/images/jpegPhoto.php?name=sn&amp;value=Riechert</foaf:depiction>
          </swrc:AcademicStaff>

          <swrc:AcademicStaff rdf:about="MuhammadAhtishamAslam" conferences:country="Germany">
            <rdf:type rdf:resource="&swrc;Person" />
            <swrc:affiliation rdf:resource="UniversityOfLeipzig" />
            <rdf:type rdf:resource="&swrc;PhDStudent" />
            <swrc:lastName>Aslam</swrc:lastName>
            <swrc:firstName>Muhammad Ahtisham</swrc:firstName>
            <swrc:fax>+49 341 9732329</swrc:fax>
            <swrc:email>ahtisham_a@hotmail.com</swrc:email>
            <swrc:address>Johannisgasse 26, 04103 Leipzig, Germany</swrc:address>
            <foaf:depiction>http://aksw.org/images/jpegPhoto.php?name=sn&amp;value=Aslam</foaf:depiction>
          </swrc:AcademicStaff>

          <swrc:Student rdf:about="NormanHeino" conferences:country="Germany">
            <rdf:type rdf:resource="&swrc;Person" />
            <swrc:studiesAt rdf:resource="UniversityOfLeipzig" />
          </swrc:Student>
          <swrc:Student rdf:about="PhilippFrischmuth" conferences:country="Germany">
            <rdf:type rdf:resource="&swrc;Person" />
            <swrc:studiesAt rdf:resource="UniversityOfLeipzig" />
          </swrc:Student>


        </rdf:RDF>';
        
        $result = $this->_object->parseFromDataString($xml);
        
        $counter = 0;
        foreach ($result as $s => $pArray) {
            foreach ($pArray as $p => $oArray) {
                foreach ($oArray as $o) {
                    $counter++;
                }
            }
        }

        $this->assertEquals(1810, $counter);
    }
    
    protected function _getRdfXmlString($innerXml)
    {
        return $this->_xmlString . $innerXml . '</rdf:RDF>';
    }
    
    
    
}
