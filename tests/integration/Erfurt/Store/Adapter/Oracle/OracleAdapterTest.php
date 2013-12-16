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
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $connection = $this->getConnection();
        $this->installTripleStore($connection);
        $this->adapter = new Erfurt_Store_Adapter_Oracle_OracleAdapter($connection);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->adapter = null;
        parent::tearDown();
    }

    /**
     * Ensures that an exception is thrown if a syntactically invalid
     * SPARQL query is passed to sparqlQuery().
     */
    public function testSparqlQueryThrowsExceptionIfInvalidQueryIsPassed()
    {
        $this->setExpectedException('InvalidArgumentException');
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

        $query  = 'SELECT ?subject AS aliased WHERE { ?subject ?predicate ?object. }';
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
     * @param Connection $connection
     */
    protected function installTripleStore(Connection $connection)
    {
        $setup = new Erfurt_Store_Adapter_Oracle_Setup($connection);
        if ($setup->isInstalled()) {
            $setup->uninstall();
        }
        $setup->install();
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
