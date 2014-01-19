<?php

use Doctrine\DBAL\DriverManager;

/**
 * Tests the Oracle adapter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 14.12.13
 * @group Oracle
 */
class Erfurt_Store_Adapter_Oracle_OracleAdapterTest extends \Erfurt_OracleTestCase
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
     * Checks if sparqlQuery() accepts a query that uses numbers as variable identifiers.
     *
     * @see http://www.w3.org/TR/2013/REC-sparql11-query-20130321/#rVARNAME
     */
    public function testSparqlQueryAcceptsQueryThatUsesNumbersAsVariables()
    {
        $query = 'SELECT ?1 '
               . 'FROM <http://example.org> '
               . 'WHERE {'
               . '    {?1 a <http://example.org/animal>} UNION {?1 a <http://example.org/human>}'
               . '}';

        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
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
     * Checks if sparqlQuery() works with Unix new line values ("\n")
     * in the query.
     */
    public function testSparqlQueryHandlesUnixNewLines()
    {
        $query  = "SELECT ?subject ?object\n"
                . "FROM <http://example.org/graph>\n"
                . "WHERE { ?subject ?predicate ?object. }";

        $this->setExpectedException(null);
        $this->adapter->sparqlQuery($query);
    }

    /**
     * Checks if sparqlQuery() works with Windows new line values ("\r\n")
     * in the query.
     */
    public function testSparqlQueryHandlesWindowsNewLines()
    {
        $query  = "SELECT ?subject ?object\r\n"
                . "FROM <http://example.org/graph>\r\n"
                . "WHERE { ?subject ?predicate ?object. }";

        $this->setExpectedException(null);
        $this->adapter->sparqlQuery($query);
    }

    /**
     * Ensures that the adapter rejects queries that contain the internal escape
     * sequence.
     *
     * This is not optimal, but at least it should prevent SQL injection attacks.
     */
    public function testSparqlQueryRejectsQueriesThatContainsEscapeSequence()
    {
        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate "This is the escape sequence: ~\'"@en . }';

        $this->setExpectedException('Erfurt_Exception');
        $this->adapter->sparqlQuery($query);
    }

    /**
     * Ensures that an exception is thrown by sparqlQuery() if the requested result
     * format is not supported or does not exist.
     */
    public function testSparqlQueryThrowsExceptionIfResultFormatIsNotSupported()
    {
        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';
        $options = array(
            Erfurt_Store::RESULTFORMAT => 'unknown'
        );

        $this->setExpectedException('Erfurt_Exception');
        $this->adapter->sparqlQuery($query, $options);
    }

    /**
     * Ensures that sparqlQuery() returns the result in extended format if that is requested.
     */
    public function testSparqlQueryReturnsExtendedResultFormatIfRequested()
    {
        $this->insertTriple();
        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';
        $options = array(
            Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_EXTENDED
        );

        $result = $this->adapter->sparqlQuery($query, $options);

        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('head', $result);
        $this->assertArrayHasKey('results', $result);
    }

    /**
     * Checks if sparqlQuery() supports the raw Oracle result format.
     */
    public function testSparqlQuerySupportsRawFormat()
    {
        $this->insertTriple();
        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';
        $options = array(
            Erfurt_Store::RESULTFORMAT => 'raw'
        );

        $result = $this->adapter->sparqlQuery($query, $options);

        $this->assertInternalType('array', $result);
    }

    /**
     * Ensures that sparqlQuery() returns a boolean value if an ASK
     * query is passed.
     */
    public function testSparqlQueryReturnsBooleanIfAskQueryIsPassed()
    {
        $query  = 'ASK FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';

        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('boolean', $result);
    }

    /**
     * Ensures that sparqlQuery() can handle queries, which contain variable
     * identifiers that are reserved words in Oracle SQL.
     */
    public function testSparqlQueryWorksEvenIfReservedWordIsUsedAsVariable()
    {
        $query  = 'SELECT ?group FROM <http://example.org/graph> '
                . 'WHERE { ?group <http://example.org/relation#contains> <http:/example.org/user/matthias> . }';

        $this->setExpectedException(null);
        $this->adapter->sparqlQuery($query);
    }

    /**
     * Checks if sparqlQuery() supports queries that contain IRIs with special characters.
     */
    public function testSparqlQuerySupportsIriWithSpecialCharacters()
    {
        $query = 'SELECT ?p ?o '
               . 'FROM <http://example.org/graph> '
               . 'WHERE { <http://example.org/iri/with/quote/x\'y> ?p ?o . }';

        $this->setExpectedException(null);
        $this->adapter->sparqlQuery($query);
    }

    /**
     * Ensures that sparqlAsk() returns false if no triple matches
     * the provided query.
     */
    public function testSparqlAskReturnsFalseIfNoTripleMatches()
    {
        $query  = 'ASK FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';

        $result = $this->adapter->sparqlAsk($query);

        $this->assertFalse($result);
    }

    /**
     * Ensures that sparqlAsk() returns true if at least one triple matches
     * the provided SPARQL query.
     */
    public function testSparqlAskReturnsTrueIfAtLeastOneTripleMatchesPattern()
    {
        $this->insertTriple();
        $query  = 'ASK FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';

        $result = $this->adapter->sparqlAsk($query);

        $this->assertTrue($result);
    }

    /**
     * Checks if the adapter stores (and returns) a literal that contains
     * a single quote ("'") correctly.
     */
    public function testAdapterStoresLiteralWithQuoteCorrectly()
    {
        $object = array(
            'type'  => 'literal',
            'value' => 'Literal with quote (\').'
        );
        $this->insertTriple('http://example.org/subject', 'http://example.org/predicate', $object);

        $query  = 'SELECT ?object '
                . 'FROM <http://example.org/graph> '
                . 'WHERE { <http://example.org/subject> <http://example.org/predicate> ?object . }';
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        $value = current(current($result));
        $this->assertEquals($object['value'], $value);
    }

    /**
     * Checks if the adapter can work with SPARQL queries that contain
     * a full SPARQL query as literal.
     */
    public function testAdapterCanWorkWithSparqlQueryInStringLiteral()
    {
        $object = array(
            'type'  => 'literal',
            'value' => 'SELECT ?subject WHERE { ?subject ?predicate ?object . }'
        );
        $this->insertTriple('http://example.org/subject', 'http://example.org/predicate', $object);

        $query  = 'SELECT ?subject '
                . 'FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate %s . }';
        $query  = sprintf($query, Erfurt_Utils::buildLiteralString($object['value']));
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        // The inserted triple should have been selected.
        $this->assertCount(1, $result);
    }

    /**
     * Checks if the adapter can work with SPARQL query that is passed as string literal
     * and that contains another literal itself.
     */
    public function testAdapterCanWorkWithSparqlQueryThatContainsLiteralInStringLiteral()
    {
        $this->markTestSkipped('Rewriting of literals in SPARQL queries is required for this one to work.');
        $object = array(
            'type'  => 'literal',
            'value' => 'SELECT ?subject WHERE { ?subject ?predicate "This is a ?test variable." . }'
        );
        $this->insertTriple('http://example.org/subject', 'http://example.org/predicate', $object);

        $query  = 'SELECT ?subject '
                . 'FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate %s . }';
        $query  = sprintf($query, Erfurt_Utils::buildLiteralString($object['value']));
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        // The inserted triple should have been selected.
        $this->assertCount(1, $result);
    }

    /**
     * Checks if it is possible to use literals with quotes in SPARQL graph patterns.
     */
    public function testSparqlQueryAllowsSearchingForLiteralsWithQuote()
    {
        $object = array(
            'type'  => 'literal',
            'value' => 'Literal with quote (\').'
        );
        $this->insertTriple('http://example.org/subject','http://example.org/predicate', $object);

        $query  = 'SELECT ?subject '
                . 'FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate %s . }';
        $query  = sprintf($query, Erfurt_Utils::buildLiteralString($object['value']));
        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
    }

    /**
     * Checks if sparqlQuery() handles camel cased variables (for example ?resourceUri)
     * correctly.
     */
    public function testSparqlQuerySupportsCamelCasedVariables()
    {
        $this->insertTriple();

        $query  = 'SELECT ?camelCasedObject '
                . 'FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?camelCasedObject . }';

        $result = $this->adapter->sparqlQuery($query);

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
        $row = current($result);
        $this->assertInternalType('array', $row);
        $this->assertArrayHasKey('camelCasedObject', $row);
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
     * Checks if createModel() adds a marker triple to an OWL ontology.
     */
    public function testCreateModelMarksOwlOntology()
    {
        $this->adapter->createModel('http://example.org', Erfurt_Store::MODEL_TYPE_OWL);
        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Ensures that non-OWL models are not marked by createModel().
     */
    public function testCreateModelDoesNotMarkNonOwlModels()
    {
        $this->adapter->createModel('http://example.org', Erfurt_Store::MODEL_TYPE_RDFS);
        $this->assertEquals(0, $this->countTriples());
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
     * Ensures that getAvailableModels() returns graphs that have been added via createModel() in this request,
     * even if no statement has been assigned to that graph yet.
     */
    public function testGetAvailableModelsReturnsModelsThatHaveBeenCreatedInCurrentRequestButNotYetFilled()
    {
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
     * Checks if triples with objects that are typed as string are removed correctly.
     */
    public function testDeleteMatchingStatementsCanRemovesObjectLiteralsThatAreTypedAsStringCorrectly()
    {
        $object = array(
            'value'    => 'Hello',
            'type'     => 'literal',
            'datatype' => EF_XSD_NS . 'string'
        );
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            $object
        );

        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            'http://example.org/subject',
            'http://example.org/predicate',
            $object
        );

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Checks if triples that contain a literal object of type integer are removed correctly.
     */
    public function testDeleteMatchingStatementsCanRemovesObjectLiteralsThatAreTypedAsIntegerCorrectly()
    {
        $object = array(
            'value'    => 42,
            'type'     => 'literal',
            'datatype' => EF_XSD_NS . 'integer'
        );
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            $object
        );

        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            'http://example.org/subject',
            'http://example.org/predicate',
            $object
        );

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Checks if triples with object literal that has a language are removed correctly.
     */
    public function testDeleteMatchingStatementsCanRemovesObjectLiteralsWithLanguageCorrectly()
    {
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'value' => 'hallo',
                'type'  => 'literal',
                'lang'  => 'de'
            )
        );
        $object = array(
            'value' => 'hello',
            'type'  => 'literal',
            'lang'  => 'en'
        );
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            $object
        );

        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            'http://example.org/subject',
            'http://example.org/predicate',
            $object
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Checks if the triple definition from the extended SPARQL select result set can be used
     * to delete the specified triples via deleteMatchingStatements().
     *
     * This test checks if the desired behavior works for triple with a typed object.
     */
    public function testTripleDefinitionFromExtendedSelectResultCanBePassedToDeleteMatchingStatements()
    {
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'value'    => 'Hello',
                'type'     => 'literal',
                'datatype' => EF_XSD_NS . 'string'
            )
        );

        // Select the triple...
        $query = 'SELECT ?subject ?predicate ?object '
               . 'FROM <http://example.org/graph> '
               . '{ ?subject ?predicate ?object . }';
        $options = array(Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_EXTENDED);
        $result = $this->adapter->sparqlQuery($query, $options);
        $this->assertInternalType('array', $result);
        $this->assertTrue(isset($result['results']['bindings']), 'Missing bindings in result set.');
        $triple = current($result['results']['bindings']);
        // ... and pass its definition to the delete method.
        $this->adapter->deleteMatchingStatements(
            'http://example.org/graph',
            $triple['subject']['value'],
            $triple['predicate']['value'],
            $triple['object']
        );

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Checks if deleteMultipleStatements() removes the provided statements.
     */
    public function testDeleteMultipleStatementsRemovesProvidedStatements()
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
        // Insert all the test triples.
        foreach ($tripleDefinition as $subject => $objectDefinitionsByPredicate) {
            /* @var $objectDefinitionsByPredicate array(string=>array(array(string=>string))) */
            foreach ($objectDefinitionsByPredicate as $predicate => $objectDefinitions) {
                /* @var $objectDefinitions array(array(string=>string)) */
                foreach ($objectDefinitions as $object) {
                    /* @var $definition array(string=>string) */
                    $this->insertTriple($subject, $predicate, $object, 'http://example.org/graph/will-be-deleted');
                }
            }
        }
        // Insert a triple that will not be deleted.
        $this->insertTriple();

        $this->adapter->deleteMultipleStatements('http://example.org/graph/will-be-deleted', $tripleDefinition);

        $this->assertEquals(1, $this->countTriples());
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
     * Checks if addMultipleStatements() injects the defined triples.
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

        $this->adapter->addMultipleStatements('http://example.org', $tripleDefinition);

        $expectedNumber = 0;
        foreach ($tripleDefinition as $objectDefinitionsByPredicate) {
            /* @var $objectDefinitionsByPredicate array(string=>array(array(string=>string))) */
            foreach ($objectDefinitionsByPredicate as $objectDefinitions) {
                /* @var $objectDefinitions array(array(string=>string)) */
                $expectedNumber += count($objectDefinitions);
            }
        }
        $this->assertEquals($expectedNumber, $this->countTriples());
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

}
