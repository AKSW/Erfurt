<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;

/**
 * Tests the Oracle adapter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 14.12.13
 */
class Erfurt_Store_Adapter_Oracle_OracleAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Oracle_OracleAdapter
     */
    protected $adapter = null;

    /**
     * Helper object that is used to set up and clean the database.
     *
     * @var \Erfurt_Store_Adapter_Oracle_Setup::__construct
     */
    protected $setup = null;

    /**
     * The connection that is used for testing.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->connection = $this->createConnection();
        $this->setup = new Erfurt_Store_Adapter_Oracle_Setup($this->connection);
        $this->installTripleStore($this->setup);
        $this->adapter = new Erfurt_Store_Adapter_Oracle_OracleAdapter($this->connection);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->adapter = null;
        $this->uninstallTripleStore($this->setup);
        $this->connection = null;
        parent::tearDown();
    }

    /**
     * Ensures that an exception is thrown if a syntactically invalid
     * SPARQL query is passed to sparqlQuery().
     */
    public function testSparqlQueryThrowsExceptionIfInvalidQueryIsPassed()
    {
        $this->setExpectedException('Erfurt_Exception');
        $this->adapter->sparqlQuery('Hello world!');
    }

    /**
     * Ensures that sparqlQuery() returns an array if a select query is passed.
     */
    public function testSparqlQueryReturnsArrayIfSelectQueryIsPassed()
    {
        $this->insertTriple();

        $query  = 'SELECT ?subject FROM <http://example.org/graph> WHERE { ?subject ?predicate ?object. }';
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
    }

    /**
     * Checks if the result set that is returned by sparqlQuery() contains
     * the requested variables.
     */
    public function testSparqlQueryResultContainsRequestedVariables()
    {
        $this->insertTriple();

        $query  = 'SELECT ?subject ?predicate ?object FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object. }';
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        foreach ($result as $row) {
            $this->assertInternalType('array', $row);
            $this->assertArrayHasKey('subject', $row);
            $this->assertArrayHasKey('predicate', $row);
            $this->assertArrayHasKey('object', $row);
        }
    }

    /**
     * Checks if the result set that is returned by sparqlQuery() contains
     * the defined aliased variables.
     */
    public function testSparqlQueryResultContainsAliasedVariables()
    {
        $this->insertTriple();

        $query  = 'SELECT (?subject AS ?aliased) FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object. }';
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        foreach ($result as $row) {
            $this->assertInternalType('array', $row);
            $this->assertArrayHasKey('aliased', $row);
        }
    }

    /**
     * Ensures that sparqlQuery() returns an empty set if no data
     * matches the query.
     */
    public function testSparqlQueryResultIsEmptyIfNoDataMatches()
    {
        $this->insertTriple();

        $query  = 'SELECT ?object FROM <http://example.org/graph> '
                . 'WHERE { <http://testing.org/subject> ?predicate ?object. }';
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        $this->assertCount(0, $result);
    }

    /**
     * Checks if sparqlQuery() returns the correct number of rows
     * for a query that selects a subset of the data.
     */
    public function testSparqlQueryResultReturnsCorrectNumberOfRows()
    {
        $this->insertTriple('http://example.org/subject');
        $this->insertTriple('http://example.org/subject', 'http://example.org/predicate2');
        $this->insertTriple('http://example.org/another-subject');

        $query  = 'SELECT ?object FROM <http://example.org/graph> '
                . 'WHERE { <http://example.org/subject> ?predicate ?object. }';
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        $this->assertCount(2, $result);
    }

    /**
     * Ensures that the result set that is returned by sparqlQuery()
     * is ordered correctly.
     */
    public function testSparqlQueryResultIsOrderedCorrectly()
    {
        // Insert triples unordered to ensure that they are not randomly returned
        // in order.
        $this->insertTriple('http://example.org/003');
        $this->insertTriple('http://example.org/001');
        $this->insertTriple('http://example.org/002');

        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object. } ORDER BY ASC(?subject)';
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        $subjects = array_map(function (array $row) {
            \PHPUnit_Framework_Assert::assertArrayHasKey('subject', $row);
            return $row['subject'];
        }, $result);
        $expected = array(
            'http://example.org/001',
            'http://example.org/002',
            'http://example.org/003'
        );
        $this->assertEquals($expected, $subjects);
    }

    /**
     * Ensures that sparqlQuery() returns only the variables that were
     * requested in the SPARQL query.
     */
    public function testSparqlQueryReturnsOnlyRequestedVariables()
    {
        $this->insertTriple();

        $query  = 'SELECT ?subject ?object FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object. }';
        $result = $this->adapter->sparqlQuery($query);

        $expectedKeys = array(
            'subject',
            'object'
        );
        $this->assertInternalType('array', $result);
        foreach ($result as $row) {
            /* @var $row array(string=>string) */
            $this->assertInternalType('array', $row);
            $keys           = array_keys($row);
            $additionalKeys = array_diff($keys, $expectedKeys);
            $this->assertEquals(array(), $additionalKeys, 'Additional keys in result rows detected.');
        }
    }

    /**
     * Checks if createModel() returns always true, as there are
     * no preparation steps necessary to create a new named graph.
     */
    public function testCreateModelReturnsTrue()
    {
        $this->assertTrue($this->adapter->createModel('http://example.org'));
    }

    /**
     * Ensures that deleteModel() does nothing if no triples belong to
     * the given graph.
     */
    public function testDeleteModelDoesNothingIfNoCorrespondingTriplesExist()
    {
        $this->setExpectedException(null);
        $this->adapter->deleteModel('http://example.org');
    }

    /**
     * Checks if deleteModel() removes all triples that belong to the
     * provided graph.
     */
    public function testDeleteModelRemovesAllTriplesThatBelongToTheGivenGraph()
    {
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );

        $this->adapter->deleteModel('http://example.org/graph');

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Ensures that deleteModel() does not remove triples from other graphs.
     */
    public function testDeleteModelDoesNotRemoveTriplesFromOtherGraphs()
    {
        $this->insertTriple(
            'http://example.org/subject1',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );
        $this->insertTriple(
            'http://example.org/subject2',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/another-graph'
        );

        $this->adapter->deleteModel('http://example.org/graph');

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Ensures that getAvailableModels() returns an empty array if
     * no graphs exist yet.
     */
    public function testGetAvailableModelsReturnsEmptyArrayIfNoGraphsExist()
    {
        $models = $this->adapter->getAvailableModels();

        $this->assertInternalType('array', $models);
        $this->assertEmpty($models);
    }

    /**
     * Checks if getAvailableModels() returns the existing graphs as key.
     */
    public function testGetAvailableModelsReturnsExistingGraphsAsKey()
    {
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/another-graph'
        );

        $models = $this->adapter->getAvailableModels();

        $this->assertInternalType('array', $models);
        $graphIris = array_keys($models);
        $this->assertContains('http://example.org/graph', $graphIris);
        $this->assertContains('http://example.org/another-graph', $graphIris);
    }

    /**
     * Ensures that getAvailableModels() returns the correct number of graphs even
     * if multiple triples are assigned to a single graph.
     */
    public function testGetAvailableModelsReturnsCorrectNumberOfGraphsIfGraphContainsMultipleTriples()
    {
        $this->insertTriple(
            'http://example.org/subject1',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );
        $this->insertTriple(
            'http://example.org/subject2',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );

        $models = $this->adapter->getAvailableModels();

        $this->assertInternalType('array', $models);
        $this->assertCount(1, $models);
    }

    /**
     * Ensures that the array, which is returned by getAvailableModels(),
     * contains only the boolean value true as array values.
     */
    public function testGetAvailableModelsContainsOnlyTrueAsValue()
    {
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/another-graph'
        );

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
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );

        $available = $this->adapter->isModelAvailable('http://example.org/missing-graph');
        $this->assertFalse($available);
    }

    /**
     * Ensures that isModelAvailable() returns true if the provided
     * graph exists.
     */
    public function testIsModelAvailableReturnsTrueIfGraphExists()
    {
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph'
        );

        $available = $this->adapter->isModelAvailable('http://example.org/graph');
        $this->assertTrue($available);
    }

    /**
     * Checks if deleteMatchingStatements() removes a complete graph if only the
     * model IRI is passed.
     */
    public function testDeleteMatchingStatementsDeleteGraphIfOnlyModelIriIsPassed()
    {
        $this->insertTriple();
        $this->insertTriple(
            'http://example.org/subject1',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph-that-will-be-deleted'
        );
        $this->insertTriple(
            'http://example.org/subject2',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph-that-will-be-deleted'
        );

        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph-that-will-be-deleted',
            null,
            null,
            null
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Ensures that deleteMatchingStatements() removes all triples that match the
     * provided model/subject combination.
     */
    public function testDeleteMatchingStatementsRemovesAllTriplesWithProvidedSubject()
    {
        $this->insertTriple();
        $this->insertTriple(
            'http://example.org/some-subject',
            'http://example.org/predicate1'
        );
        $this->insertTriple(
            'http://example.org/some-subject',
            'http://example.org/predicate2'
        );

        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            'http://example.org/some-subject',
            null,
            null
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Checks if deleteMatchingStatements() removes a specific triple if all details (subject,
     * predicate, object) are passed.
     */
    public function testDeleteMatchingStatementsDeletesSpecificTripleIfAllInformationIsPassed()
    {
        $this->insertTriple();
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/another-predicate',
            'http://example.org/another-object',
            'http://example.org/graph'
        );

        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            'http://example.org/subject',
            'http://example.org/another-predicate',
            array(
                'value' => 'http://example.org/another-object',
                'type'  => 'uri'
            )
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Checks if deleteMatchingStatements() is able to remove a triple with literal as
     * object.
     */
    public function testDeleteMatchingStatementsDeletesTripleWithObjectLiteral()
    {
        $this->insertTriple();
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/another-predicate',
            array(
                'value' => 'Hello world!',
                'type'  => 'literal'
            ),
            'http://example.org/graph'
        );

        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            'http://example.org/subject',
            'http://example.org/another-predicate',
            array(
                'value' => 'Hello world!',
                'type'  => 'literal'
            )
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Ensures that deleteMatchingStatements() returns 0 if no statement was deleted.
     */
    public function testDeleteMatchingStatementReturnsZeroIfNoTripleWasDeleted()
    {
        $this->insertTriple();

        $deleted = $this->adapter->deleteMatchingStatements(
            'http://example.org/not-existing-graph',
            null,
            null,
            null
        );

        $this->assertInternalType('integer', $deleted);
        $this->assertEquals(0, $deleted);
    }

    /**
     * Checks if deleteMatchingStatements() returns the number of removed triples.
     */
    public function testDeleteMatchingStatementsReturnsNumberOfDeletedTriples()
    {
        $this->insertTriple();
        $this->insertTriple(
            'http://example.org/subject1',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph-that-will-be-deleted'
        );
        $this->insertTriple(
            'http://example.org/subject2',
            'http://example.org/predicate',
            'http://example.org/object',
            'http://example.org/graph-that-will-be-deleted'
        );
        $before = $this->countTriples();

        $deleted = $this->adapter->deleteMatchingStatements(
            'http://example.org/graph-that-will-be-deleted',
            null,
            null,
            null
        );

        $after = $this->countTriples();
        $this->assertInternalType('integer', $deleted);
        $this->assertEquals($before - $after, $deleted);

    }

    /**
     * Counts all triples in the database.
     *
     * @return integer The number of triples.
     */
    protected function countTriples()
    {
        $query = 'SELECT COUNT(*) AS NUMBER_OF_TRIPLES FROM erfurt_semantic_data';
        $result = $this->connection->query($query);
        $rows = $result->fetchAll();
        return (int)$rows[0]['NUMBER_OF_TRIPLES'];
    }

    /**
     * Inserts the provided triple into the database.
     *
     * @param string $subjectIri
     * @param string $predicateIri
     * @param string|array(string=>string) $objectIriOrSpecification
     * @param string $graphIri
     */
    protected function insertTriple(
        $subjectIri               = 'http://example.org/subject',
        $predicateIri             = 'http://example.org/predicate',
        $objectIriOrSpecification = 'http://example.org/object',
        $graphIri                 = 'http://example.org/graph'
    )
    {
        if (is_array($objectIriOrSpecification)) {
            // Specification provided.
            $object = $objectIriOrSpecification;
        } else {
            // Object URI passed.
            $object = array(
                'value' => $objectIriOrSpecification,
                'type'  => 'uri'
            );
        }
        $this->adapter->addStatement($graphIri, $subjectIri, $predicateIri, $object);
    }

    /**
     * Creates a clean installation of the Triple Store.
     *
     * @param \Erfurt_Store_Adapter_Oracle_Setup $setup
     */
    protected function installTripleStore(Erfurt_Store_Adapter_Oracle_Setup $setup)
    {
        $this->uninstallTripleStore($setup);
        $setup->install();
    }

    /**
     * Removes the Triple Store that was used for testing.
     *
     * @param Erfurt_Store_Adapter_Oracle_Setup $setup
     */
    protected function uninstallTripleStore(Erfurt_Store_Adapter_Oracle_Setup $setup)
    {
        if ($setup->isInstalled()) {
            $setup->uninstall();
        }
    }

    /**
     * Returns the database connection that is used for testing.
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function createConnection()
    {
        return DriverManager::getConnection($this->getConfig() + array('driver' => 'oci8'));
    }

    /**
     * Loads the configuration for the adapter.
     *
     * @return array(mixed)
     */
    protected function getConfig()
    {
        $path = __DIR__ . '/../../../../../oracle.ini';
        if (!is_file($path)) {
            $message = 'This test requires an Oracle connection configuration in the file '
                     . 'oracle.ini in the test root. Use oracle.ini.dist as a template.';
            $this->markTestSkipped($message);
        }
        $config = new Zend_Config_Ini($path);
        return $config->toArray();
    }

}
