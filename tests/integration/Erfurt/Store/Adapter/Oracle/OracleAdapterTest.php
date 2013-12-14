<?php

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
        $this->adapter = Erfurt_Store_Adapter_Oracle::createFromOptions($this->getConfig());
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

    }

    /**
     * Ensures that sparqlQuery() returns an array if a select query is passed.
     */
    public function testSparqlQueryReturnsArrayIfSelectQueryIsPassed()
    {

    }

    /**
     * Checks if the result set that is returned by sparqlQuery() contains
     * the requested variables.
     */
    public function testSparqlQueryResultContainsRequestedVariables()
    {

    }

    /**
     * Checks if the result set that is returned by sparqlQuery() contains
     * the defined aliased variables.
     */
    public function testSparqlQueryResultContainsAliasedVariables()
    {

    }

    /**
     * Ensures that sparqlQuery() returns an empty set if no data
     * matches the query.
     */
    public function testSparqlQueryResultIsEmptyIfNoDataMatches()
    {

    }

    /**
     * Checks if sparqlQuery() returns the correct number of rows
     * for a query that selects a subset of the data.
     */
    public function testSparqlQueryResultReturnsCorrectNumberOfRows()
    {

    }

    /**
     * Ensures that the result set that is returned by sparqlQuery()
     * is ordered correctly.
     */
    public function testSparqlQueryResultIsOrderedCorrectly()
    {

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
            $message = 'This test requires an Oracle adapter configuration in the file '
                     . 'oracle.ini in the test root. Use oracle.ini.dist as a template.';
            $this->markTestSkipped($message);
        }
        $config = new Zend_Config_Ini($path);
        return $config->toArray();
    }

}
