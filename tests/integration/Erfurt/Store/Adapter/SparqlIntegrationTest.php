<?php

/**
 * @group Integration
 */
class Erfurt_Store_Adapter_SparqlIntegrationTest extends Erfurt_TestCase
{
    public function setUp()
    {   
        $this->markTestNeedsDatabase();
    }
    
    public function testInstantiation()
    {
        $options = array(
            'serviceUrl' => 'http://dbpedia.org/sparql',
            'graphs'     => array('http://dbpedia.org')
        );
        
        $adapter = new Erfurt_Store_Adapter_Sparql($options);
        
        $this->assertTrue($adapter instanceof Erfurt_Store_Adapter_Sparql);
    }
    
    public function testSparqlWithDbPediaEndpointIssue589()
    {
        $message = 'This test makes the build unstable as it relies on the availability and data of DBpedia. '
                 . 'Therefore, it is deactivated until a better solution is implemented.';
        $this->markTestSkipped($message);

// TODO Use HTTP Client test adapter?
        $options = array(
            'serviceUrl' => 'http://dbpedia.org/sparql',
            'graphs'     => array('http://dbpedia.org')
        );
        $adapter = new Erfurt_Store_Adapter_Sparql($options);
        
        $sparql = 'SELECT ?p ?o FROM <http://dbpedia.org> WHERE {<http://dbpedia.org/resource/Leipzig> ?p ?o} LIMIT 10';
        $result = $adapter->sparqlQuery($sparql);
        
        $this->assertTrue(is_array($result));
        $this->assertEquals(10, count($result));
    }
}