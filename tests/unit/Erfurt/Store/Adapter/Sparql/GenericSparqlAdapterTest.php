<?php

/**
 * Tests the generic SPARQL adapter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.02.14
 */
class Erfurt_Store_Adapter_Sparql_GenericSparqlAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Sparql_GenericSparqlAdapter
     */
    protected $adapter = null;

    /**
     * The (mocked) connector that is used by the adapter.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $connector = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->connector = $this->getMock('\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface');
        $this->adapter   = new Erfurt_Store_Adapter_Sparql_GenericSparqlAdapter($this->connector);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->adapter   = null;
        $this->connector = null;
        parent::tearDown();
    }

    /**
     * Ensures that sparqlQuery() returns an array if a select query is passed.
     */
    public function testSparqlQueryReturnsArrayIfSelectQueryIsPassed()
    {
        $this->simulateEmptyConnectorResult();

        $query  = 'SELECT ?subject FROM <http://example.org/graph> WHERE { ?subject ?predicate ?object. }';
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
    }

    /**
     * Checks if sparqlQuery() returns the result in extended format if
     * that is requested.
     */
    public function testSparqlQueryKeepsExtendedFormatIfExpected()
    {
        $connectorResult = $this->getSimpleResult();
        $this->simulateSparqlResult($connectorResult);

        $query   = 'SELECT ?subject ?predicate ?object WHERE { ?subject ?predicate ?object . }';
        $options = array(Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_EXTENDED);
        $result  = $this->adapter->sparqlQuery($query, $options);

        $this->assertEquals($connectorResult, $result);
    }

    /**
     * Ensures that sparqlQuery() converts the result set into the plain format
     * if no specific format is requested.
     */
    public function testSparqlQueryConvertsToPlainResultSetIfNoFormatIsPassed()
    {
        $connectorResult = $this->getSimpleResult();
        $this->simulateSparqlResult($connectorResult);

        $query   = 'SELECT ?subject ?predicate ?object WHERE { ?subject ?predicate ?object . }';
        $options = array();
        $result  = $this->adapter->sparqlQuery($query, $options);

        $this->assertEquals($this->toPlainResult($connectorResult), $result);
    }

    /**
     * Ensures that sparqlQuery() converts the result set into the plain format
     * if that format is requested.
     */
    public function testSparqlQueryConvertsToPlainResultSetIfPlainFormatIsRequested()
    {
        $connectorResult = $this->getSimpleResult();
        $this->simulateSparqlResult($connectorResult);

        $query   = 'SELECT ?subject ?predicate ?object WHERE { ?subject ?predicate ?object . }';
        $options = array(Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_PLAIN);
        $result  = $this->adapter->sparqlQuery($query, $options);

        $this->assertEquals($this->toPlainResult($connectorResult), $result);
    }

    /**
     * Ensures that an exception is thrown by sparqlQuery() if the requested result
     * format is not supported or does not exist.
     */
    public function testSparqlQueryThrowsExceptionIfResultFormatIsNotSupported()
    {
        $this->simulateEmptyConnectorResult();

        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';
        $options = array(
            Erfurt_Store::RESULTFORMAT => 'unknown'
        );

        $this->setExpectedException('Erfurt_Exception');
        $this->adapter->sparqlQuery($query, $options);
    }

    /**
     * Checks if sparqlQuery() supports result sets in XML format.
     */
    public function testSparqlQuerySupportsXmlFormat()
    {
        $this->simulateSparqlResult($this->getSimpleResult());
        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';
        $options = array(
            Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_XML
        );

        $result = $this->adapter->sparqlQuery($query, $options);

        $this->assertInternalType('string', $result);
    }

    /**
     * Checks if sparqlQuery() supports result sets in JSON format.
     */
    public function testSparqlQuerySupportsJsonFormat()
    {
        $this->simulateSparqlResult($this->getSimpleResult());
        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';
        $options = array(
            Erfurt_Store::RESULTFORMAT => 'json'
        );

        $result = $this->adapter->sparqlQuery($query, $options);

        $this->assertInternalType('string', $result);

        $this->setExpectedException(null);
        Zend_Json::decode($result);
    }

    /**
     * Checks if sparqlQuery() returns a boolean (result of an ASK query)
     * from the inner connector.
     */
    public function testSparqlQueryReturnsAskResultFromConnector()
    {
        $this->simulateSparqlResult(true);
        $query  = 'ASK FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';

        $result = $this->adapter->sparqlQuery($query);

        $this->assertTrue($result);
    }

    /**
     * Checks if createModel() returns always true, as the connector should
     * handle the creation of a new named graph when a triple is inserted.
     */
    public function testCreateModelReturnsTrue()
    {
        $this->assertTrue($this->adapter->createModel('http://example.org'));
    }

    /**
     * Checks if createModel() adds a marker triple to an OWL ontology.
     */
    public function testCreateModelMarksOwlOntology()
    {
        $this->assertTripleAddedTo('http://example.org');

        $this->adapter->createModel('http://example.org', Erfurt_Store::MODEL_TYPE_OWL);
    }

    /**
     * Ensures that non-OWL models are not marked by createModel().
     */
    public function testCreateModelDoesNotMarkNonOwlModels()
    {
        $this->assertNoTripleAddedTo('http://example.org');

        $this->adapter->createModel('http://example.org', Erfurt_Store::MODEL_TYPE_RDFS);
    }

    /**
     * Ensures that deleteModel() delegates the deletion request to
     * the deleteMatchingStatements() method of the connector.
     */
    public function testDeleteModelDelegatesToConnector()
    {
        $this->assertDeletion(
            'http://example.org',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(null, null, null)
        );

        $this->adapter->deleteModel('http://example.org');
    }

    /**
     * Ensures that getAvailableModels() returns an empty array if
     * no graphs exist yet.
     */
    public function testGetAvailableModelsReturnsEmptyArrayIfNoGraphsExist()
    {
        $this->simulateEmptyConnectorResult();

        $models = $this->adapter->getAvailableModels();

        $this->assertInternalType('array', $models);
        $this->assertEmpty($models);
    }

    /**
     * Checks if getAvailableModels() returns the existing graphs as key.
     */
    public function testGetAvailableModelsReturnsExistingGraphsAsKey()
    {
        $availableGraphs = array('http://example.org/graph', 'http://example.org/another-graph');
        $connectorResult = $this->getGraphResult($availableGraphs);
        $this->simulateSparqlResult($connectorResult);

        $models = $this->adapter->getAvailableModels();

        $this->assertInternalType('array', $models);
        $graphIris = array_keys($models);
        $this->assertContains('http://example.org/graph', $graphIris);
        $this->assertContains('http://example.org/another-graph', $graphIris);
    }

    /**
     * Ensures that getAvailableModels() returns graphs that have been added via createModel() in this request,
     * even if no statement has been assigned to that graph yet.
     */
    public function testGetAvailableModelsReturnsModelsThatHaveBeenCreatedInCurrentRequestButNotYetFilled()
    {
        $availableGraphs = array('http://example.org/graph', 'http://example.org/another-graph');
        $connectorResult = $this->getGraphResult($availableGraphs);
        $this->simulateSparqlResult($connectorResult);

        $this->adapter->createModel('http://example.org/new-graph' , Erfurt_Store::MODEL_TYPE_RDFS);

        $models = $this->adapter->getAvailableModels();

        $this->assertInternalType('array', $models);
        $this->assertArrayHasKey('http://example.org/new-graph', $models);
    }

    /**
     * Ensures that getAvailableModels() does not returns graphs that have been created and deleted in
     * the current request.
     */
    public function testGetAvailableModelsDoesNotReturnModelsThatHaveBeenCreatedAndDeletedInCurrentRequest()
    {
        $availableGraphs = array('http://example.org/graph');
        $connectorResult = $this->getGraphResult($availableGraphs);
        $this->simulateSparqlResult($connectorResult);

        $this->adapter->createModel('http://example.org/new-graph');
        $this->adapter->deleteModel('http://example.org/new-graph');

        $models = $this->adapter->getAvailableModels();

        $this->assertInternalType('array', $models);
        $this->assertArrayNotHasKey('http://example.org/new-graph', $models);
    }

    /**
     * Ensures that the array, which is returned by getAvailableModels(),
     * contains only the boolean value true as array values.
     */
    public function testGetAvailableModelsContainsOnlyTrueAsValue()
    {
        $availableGraphs = array('http://example.org/graph', 'http://example.org/another-graph');
        $connectorResult = $this->getGraphResult($availableGraphs);
        $this->simulateSparqlResult($connectorResult);

        $models = $this->adapter->getAvailableModels();

        $this->assertInternalType('array', $models);
        foreach ($models as $graphIri => $value) {
            $message = 'Value not true for entry "' .  $graphIri . '".';
            $this->assertTrue($value, $message);
        }
    }

    /**
     * Ensures that isModelAvailable() returns false if the provided
     * graph does not exist.
     */
    public function testIsModelAvailableReturnsFalseIfGraphDoesNotExist()
    {
        $availableGraphs = array('http://example.org/graph');
        $connectorResult = $this->getGraphResult($availableGraphs);
        $this->simulateSparqlResult($connectorResult);

        $available = $this->adapter->isModelAvailable('http://example.org/missing-graph');
        $this->assertFalse($available);
    }

    /**
     * Ensures that isModelAvailable() returns true if the provided
     * graph exists.
     */
    public function testIsModelAvailableReturnsTrueIfGraphExists()
    {
        $availableGraphs = array('http://example.org/graph');
        $connectorResult = $this->getGraphResult($availableGraphs);
        $this->simulateSparqlResult($connectorResult);

        $available = $this->adapter->isModelAvailable('http://example.org/graph');
        $this->assertTrue($available);
    }

    /**
     * Checks if deleteMatchingStatements() creates a delete request and
     * delegates it to the connector.
     */
    public function testDeleteMatchingStatementsCreatesDeleteRequest()
    {
        $object = array(
            'type'  => 'literal',
            'value' => 'hello'
        );
        $this->assertDeletion(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                'http://example.org/subject',
                'http://example.org/predicate',
                $object
            )
        );

        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            'http://example.org/subject',
            'http://example.org/predicate',
            $object
        );
    }

    /**
     * Ensures that deleteMatchingStatements() returns the number of affected
     * triples from the connector.
     */
    public function testDeleteMatchingStatementsReturnsNumberOfAffectedTriplesFromConnector()
    {
        $this->assertDeletion(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                null,
                null,
                null
            )
        );

        $affected = $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            null,
            null,
            null
        );

        $this->assertInternalType('integer', $affected);
        $this->assertEquals(42, $affected);
    }

    /**
     * Checks if deleteMultipleStatements() creates a delete request for each triple and
     * delegates them to the connector.
     */
    public function testDeleteMultipleStatementsRemovesCreatesDeleteRequestForEachTriple()
    {
        $tripleDefinition = array(
            'http://example.org/subject1' => array(
                'http://example.org/predicate1-1' => array(
                    array(
                        'type'  => 'literal',
                        'value' => 'Hello world!'
                    ),
                    array(
                        'type'  => 'uri',
                        'value' => 'http://example.org/object1-1-1'
                    )
                ),
                'http://example.org/predicate1-2' => array(
                    array(
                        'type'  => 'literal',
                        'value' => 'Test'
                    ),
                )
            ),
            'http://example.org/subject2' => array(
                'http://example.org/predicate2-1' => array(
                    array(
                        'type'  => 'uri',
                        'value' => 'http://example.org/object2-1-1'
                    )
                )
            )
        );

        $triples = new Erfurt_Store_Adapter_Sparql_TripleIterator($tripleDefinition);
        $this->connector->expects($this->exactly(iterator_count($triples)))
                        ->method('deleteMatchingStatements')
                        ->with('http://example.org/graph/will-be-deleted');

        $this->adapter->deleteMultipleStatements('http://example.org/graph/will-be-deleted', $tripleDefinition);
    }

    /**
     * Checks if getSupportedImportFormats() returns an array.
     */
    public function testGetSupportedImportFormatsReturnsArray()
    {
        $supported = $this->adapter->getSupportedImportFormats();

        $this->assertInternalType('array', $supported);
    }

    /**
     * Checks if getSupportedExportFormats() returns an array.
     */
    public function testGetSupportedExportFormatsReturnsArray()
    {
        $supported = $this->adapter->getSupportedExportFormats();

        $this->assertInternalType('array', $supported);
    }

    /**
     * Checks if addMultipleStatements() delegates the creation of each triple
     * to the connector.
     */
    public function testAddMultipleStatementsInsertsTriples()
    {
        $tripleDefinition = array(
            'http://example.org/subject1' => array(
                'http://example.org/predicate1-1' => array(
                    array(
                        'type'  => 'literal',
                        'value' => 'Hello world!'
                    ),
                    array(
                        'type'  => 'uri',
                        'value' => 'http://example.org/object1-1-1'
                    )
                ),
                'http://example.org/predicate1-2' => array(
                    array(
                        'type'  => 'literal',
                        'value' => 'Test'
                    ),
                )
            ),
            'http://example.org/subject2' => array(
                'http://example.org/predicate2-1' => array(
                    array(
                        'type'  => 'uri',
                        'value' => 'http://example.org/object2-1-1'
                    )
                )
            )
        );

        $triples = new Erfurt_Store_Adapter_Sparql_TripleIterator($tripleDefinition);
        $this->connector->expects($this->exactly(iterator_count($triples)))
                        ->method('addTriple')
                        ->with('http://example.org');

        $this->adapter->addMultipleStatements('http://example.org', $tripleDefinition);
    }

    /**
     * Ensures that init() does not raise any error when called.
     */
    public function testInitDoesNotRaiseError()
    {
        $this->setExpectedException(null);
        $this->adapter->init();
    }

    /**
     * Asserts that a deletion request will be delegated to the constructor.
     *
     * @param string $graphIri
     * @param Erfurt_Store_Adapter_Sparql_TriplePattern $pattern
     */
    protected function assertDeletion($graphIri, Erfurt_Store_Adapter_Sparql_TriplePattern $pattern)
    {
        $this->connector->expects($this->atLeastOnce())
                        ->method('deleteMatchingStatements')
                        ->with($graphIri, $pattern)
                        ->will($this->returnValue(42));
    }

    /**
     * Asserts that no triple is added to the provided graph.
     *
     * @param string $graphIri
     */
    protected function assertNoTripleAddedTo($graphIri)
    {
        $this->connector->expects($this->never())
                        ->method('addTriple')
                        ->with($graphIri);
    }

    /**
     * Asserts that at least one triple is added to the provided graph.
     *
     * @param string $graphIri
     */
    protected function assertTripleAddedTo($graphIri)
    {
        $this->connector->expects($this->atLeastOnce())
                        ->method('addTriple')
                        ->with($graphIri);
    }

    /**
     * Simulates an empty result that is provided by the SPARQL connector.
     */
    protected function simulateEmptyConnectorResult()
    {
        $this->simulateSparqlResult($this->getEmptyResultSet());
    }

    /**
     * Ensures that the SPARQL connector returns the provided query result.
     *
     * @param mixed $result
     */
    protected function simulateSparqlResult($result)
    {
        $this->connector->expects($this->any())
                        ->method('query')
                        ->will($this->returnValue($result));
    }

    /**
     * Converts the provided result set in extended format into the
     * plain format.
     *
     * @param array(mixed) $extendedResult
     * @return array(array(string=>mixed))
     */
    protected function toPlainResult($extendedResult)
    {
        $plain = array();
        foreach ($extendedResult['results']['bindings'] as $binding) {
            /* @var $binding array(string=>array(string=>string)) */
            $row = count($plain);
            foreach ($binding as $name => $definition) {
                /* @var $name string */
                /* @var $definition array(string=>mixed) */
                $plain[$row][$name] = $definition['value'];
            }
        }
        return $plain;
    }

    /**
     * Simulates a connector result for the query that is used to
     * determine the existing graphs.
     *
     * @param array(string) $graphs
     */
    protected function getGraphResult(array $graphs)
    {
        $result = array(
            'head' => array(
                'vars' => array(
                    'graph'
                )
            ),
            'results' => array(
                'bindings' => array()
            )
        );
        foreach ($graphs as $graph) {
            /* @var $graph string */
            $result['results']['bindings'][] = array(
                'type'  => 'uri',
                'value' => $graph
            );
        }
        return $result;
    }

    /**
     * Creates a simple SPARQL result in extended format.
     *
     * @return array(mixed)
     */
    protected function getSimpleResult()
    {
        return array(
            'head' => array(
                'vars' => array(
                    'subject',
                    'predicate',
                    'object'
                )
            ),
            'results' => array(
                'bindings' => array(
                    array(
                        'subject' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/subject1'
                        ),
                        'predicate' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/predicate1'
                        ),
                        'object' => array(
                            'type'  => 'literal',
                            'value' => 'Hello world!'
                        )
                    ),
                    array(
                        'subject' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/subject2'
                        ),
                        'predicate' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/predicate2'
                        ),
                        'object' => array(
                            'type'  => 'uri',
                            'value' => 'http://example.org/object'
                        )
                    )
                )
            )
        );
    }

    /**
     * Returns an empty SPARQL result set in extended format.
     */
    protected function getEmptyResultSet()
    {
        return array(
            'head' => array(
                'vars' => array()
            ),
            'results' => array(
                'bindings' => array()
            )
        );
    }

}
