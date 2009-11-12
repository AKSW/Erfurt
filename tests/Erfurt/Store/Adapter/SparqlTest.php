<?php
require_once 'Erfurt/TestCase.php';

class Erfurt_Store_Adapter_SparqlTest extends Erfurt_TestCase
{
    public function setUp()
    {   
        
    }
    
    public function testInstantiation()
    {
        $options = array(
            'serviceurl' => 'http://dbpedia.org/sparql',
            'graphs'     => array('http://dbpedia.org')
        );
        
        $adapter = new Erfurt_Store_Adapter_Sparql($options);
        
        $this->assertTrue($adapter instanceof Erfurt_Store_Adapter_Sparql);
    }
    
    public function testSparqlWithDbPediaEndpointIssue589()
    {
        $options = array(
            'serviceurl' => 'http://dbpedia.org/sparql',
            'graphs'     => array('http://dbpedia.org')
        );
        $adapter = new Erfurt_Store_Adapter_Sparql($options);
        
        $sparql = 'SELECT ?s ?p ?o WHERE {?s ?p ?o} LIMIT 10';
        $result = $adapter->sparqlQuery($sparql);
        
        $this->assertTrue(is_array($result));
        $this->assertEquals(10, count($result));
    }
}