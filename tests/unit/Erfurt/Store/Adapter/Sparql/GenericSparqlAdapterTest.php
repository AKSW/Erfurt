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

    public function testSparqlQueryKeepsExtendedFormatIfExpected()
    {

    }

    public function testSparqlQueryConvertsToSimpleResultSetIfNoFormatIsPassed()
    {

    }

    public function testSparqlQueryConvertsToSimpleResultSetIfPlainFormatIsRequested()
    {

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
        // TODO simulate result set
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
        // TODO simulate result set
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
        // TODO simulate ASK result
        $query  = 'ASK FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';

        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('boolean', $result);
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
        // TODO simulate result with graphs <http://example.org/graph>
        // and <http://example.org/another-graph>
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
        // TODO simulate result
        $this->adapter->createModel('http://example.org/new-graph');

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
        // TODO simulate result
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
        // TODO simulate result with graphs <http://example.org/graph>
        // and <http://example.org/another-graph>

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
        // TODO simulate result with graph <http://example.org/graph>

        $available = $this->adapter->isModelAvailable('http://example.org/missing-graph');
        $this->assertFalse($available);
    }

    /**
     * Ensures that isModelAvailable() returns true if the provided
     * graph exists.
     */
    public function testIsModelAvailableReturnsTrueIfGraphExists()
    {
        // TODO simulate result with graph <http://example.org/graph>

        $available = $this->adapter->isModelAvailable('http://example.org/graph');
        $this->assertTrue($available);
    }

    /**
     * Checks if deleteMatchingStatements() creates a delete request and
     * delegates it to the connector.
     */
    public function testDeleteMatchingStatementsCreatesDeleteRequest()
    {

    }

    /**
     * Ensures that deleteMatchingStatements() returns the number of affected
     * triples from the connector.
     */
    public function testDeleteMatchingStatementsReturnsNumberOfAffectedTriplesFromConnector()
    {

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
        $this->connector->expects($this->any())
                        ->method('query')
                        ->will($this->returnValue($this->getEmptyResultSet()));
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
