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
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $connection = $this->getConnection();
        $this->setup = new Erfurt_Store_Adapter_Oracle_Setup($connection);
        $this->installTripleStore($this->setup);
        $this->adapter = new Erfurt_Store_Adapter_Oracle_OracleAdapter($connection);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->adapter = null;
        $this->uninstallTripleStore($this->setup);
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

        $query  = 'SELECT ?subject WHERE { ?subject ?predicate ?object. }';
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

        $query  = 'SELECT ?subject ?predicate ?object WHERE { ?subject ?predicate ?object. }';
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

        $query  = 'SELECT (?subject AS ?aliased) WHERE { ?subject ?predicate ?object. }';
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

        $query  = 'SELECT ?object WHERE { <http://testing.org/subject> ?predicate ?object. }';
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

        $query  = 'SELECT ?object WHERE { <http://example.org/subject> ?predicate ?object. }';
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

        $query  = 'SELECT ?subject WHERE { ?subject ?predicate ?object. } ORDER BY ASC(?subject)';
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

        $query  = 'SELECT ?subject ?object WHERE { ?subject ?predicate ?object. }';
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

    }

    public function testDeleteModelDoesNothingIfNoCorrespondingTriplesExist()
    {

    }

    public function testDeleteModelRemovesAllTriplesThatBelongToTheGivenGraph()
    {

    }

    public function testGetAvailableModelsReturnsEmptyArrayIfNoGraphsExist()
    {

    }

    public function testGetAvailableModelsReturnsExistingGraphsAsKey()
    {

    }

    public function testGetAvailableModelsContainsOnlyTrueAsValue()
    {

    }

    /**
     * Inserts the provided triple into the database.
     *
     * @param string $subjectIri
     * @param string $predicateIri
     * @param string $objectIri
     */
    protected function insertTriple(
        $subjectIri   = 'http://example.org/subject',
        $predicateIri = 'http://example.org/predicate',
        $objectIri    = 'http://example.org/object'
    )
    {
        $object = array(
            'value' => $objectIri,
            'type' => 'uri'
        );
        $graphIri = 'http://example.org/graph';
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
    protected function getConnection()
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
