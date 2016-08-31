<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_Store_Adapter_SparqlIntegrationTest extends Erfurt_TestCase
{
    private $_dataDir = null;

    public function testInstantiation()
    {
        $options = array(
            'serviceUrl' => 'http://dbpedia.org/sparql',
            'graphs'     => array('http://dbpedia.org')
        );

        $adapter = new Erfurt_Store_Adapter_Sparql($options);

        $this->assertTrue($adapter instanceof Erfurt_Store_Adapter_Sparql);
    }

    /**
     * Test if the Erfurt_Store_Adapter_Sparql resolves the graph URI to the correct service.
     */
    public function testSparqlWithDbPediaEndpoint()
    {
        $this->markTestNeedsTestConfig();
        $this->_dataDir = realpath(dirname(__FILE__)) . '/_files/data/';

        $options = array(
            'serviceUrl' => 'http://dbpedia.org/sparql',
            'graphs'     => array('http://dbpedia.org')
        );

        $adapter = new Erfurt_Store_Adapter_Sparql($options);

        // Use HTTP Client test adapter
        $httpAdapter = new Erfurt_TestHelper_Http_ClientAdapter();
        $httpAdapter->setResponse(
            new Zend_Http_Response(
                200,
                array('Content-type' => 'application/sparql-results+xml'),
                file_get_contents($this->_dataDir . 'sparqlDBpediaLeipzig.srx')
            )
        );
        $adapter->setHttpAdapter($httpAdapter);

        $sparql = 'SELECT ?p ?o FROM <http://dbpedia.org> WHERE {<http://dbpedia.org/resource/Leipzig> ?p ?o} LIMIT 10';
        $result = $adapter->sparqlQuery($sparql);

        $serviceUrl = Zend_Uri_Http::fromString('http://dbpedia.org/sparql');
        $requestUrl = $httpAdapter->getLastRequestUri();

        $this->assertTrue(is_array($result));
        $this->assertEquals($serviceUrl->getHost(), $requestUrl->getHost());
        $this->assertEquals($serviceUrl->getPath(), $requestUrl->getPath());
        $this->assertEquals(10, count($result));
    }
}
