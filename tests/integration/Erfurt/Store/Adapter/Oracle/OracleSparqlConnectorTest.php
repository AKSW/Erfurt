<?php

/**
 * Tests the Oracle SPARQL connector.
 *
 * @since 02.02.14
 * @group Oracle
 */
class Erfurt_Store_Adapter_Oracle_OracleSparqlConnectorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Oracle_OracleSparqlConnector
     */
    protected $connector = null;

    /**
     * Test helper that is used to set up the environment.
     *
     * @var \Erfurt_OracleTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper = new \Erfurt_OracleTestHelper();
        $this->helper->installTripleStore();
        $this->connector = new Erfurt_Store_Adapter_Oracle_OracleSparqlConnector($this->helper->getConnection());
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->connector = null;
        $this->helper->cleanUp();
        parent::tearDown();
    }

    /**
     * Asserts that the connector implements the required interface.
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf('\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface', $this->connector);
    }

    /**
     * Ensures that an exception is thrown if a syntactically invalid
     * SPARQL query is passed to query().
     */
    public function testQueryThrowsExceptionIfInvalidQueryIsPassed()
    {
        $this->setExpectedException('Exception');
        $this->connector->query('Hello world!');
    }

    /**
     * Ensures that query() returns an array if a select query is passed.
     */
    public function testQueryReturnsArrayIfSelectQueryIsPassed()
    {
        $this->insertTriple();

        $query  = 'SELECT ?subject FROM <http://example.org/graph> WHERE { ?subject ?predicate ?object. }';
        $result = $this->connector->query($query);

        $this->assertInternalType('array', $result);
    }

    /**
     * Checks if the result set that is returned by query() contains
     * the requested variables.
     */
    public function testQueryResultContainsRequestedVariables()
    {
        $this->insertTriple();

        $query  = 'SELECT ?subject ?predicate ?object FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object. }';
        $result = $this->connector->query($query);

        $this->assertExtendedResultStructure($result);
        $this->assertContains('subject', $result['head']['vars']);
        $this->assertContains('predicate', $result['head']['vars']);
        $this->assertContains('object', $result['head']['vars']);
        foreach ($result['results']['bindings'] as $row) {
            $this->assertInternalType('array', $row);
            $this->assertArrayHasKey('subject', $row);
            $this->assertArrayHasKey('predicate', $row);
            $this->assertArrayHasKey('object', $row);
        }
    }

    /**
     * Checks if the result set that is returned by query() contains
     * the defined aliased variables.
     */
    public function testQueryResultContainsAliasedVariables()
    {
        $this->insertTriple();

        $query  = 'SELECT (?subject AS ?aliased) FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object. }';
        $result = $this->connector->query($query);

        $this->assertExtendedResultStructure($result);
        $this->assertContains('aliased', $result['head']['vars']);
    }

    /**
     * Ensures that query() returns an empty set if no data
     * matches the query.
     */
    public function testQueryResultIsEmptyIfNoDataMatches()
    {
        $this->insertTriple();

        $query  = 'SELECT ?object FROM <http://example.org/graph> '
                . 'WHERE { <http://testing.org/subject> ?predicate ?object. }';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(0, $result);
    }

    /**
     * Checks if query() returns the correct number of rows
     * for a query that selects a subset of the data.
     */
    public function testQueryResultReturnsCorrectNumberOfRows()
    {
        $this->insertTriple('http://example.org/subject');
        $this->insertTriple('http://example.org/subject', 'http://example.org/predicate2');
        $this->insertTriple('http://example.org/another-subject');

        $query  = 'SELECT ?object FROM <http://example.org/graph> '
                . 'WHERE { <http://example.org/subject> ?predicate ?object. }';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(2, $result);
    }

    /**
     * Ensures that the result set that is returned by query()
     * is ordered correctly.
     */
    public function testQueryResultIsOrderedCorrectly()
    {
        // Insert triples unordered to ensure that they are not randomly returned
        // in order.
        $this->insertTriple('http://example.org/003');
        $this->insertTriple('http://example.org/001');
        $this->insertTriple('http://example.org/002');

        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object. } ORDER BY ASC(?subject)';
        $result = $this->connector->query($query);

        $this->assertExtendedResultStructure($result);
        $subjects = array_map(function (array $row) {
            \PHPUnit_Framework_Assert::assertArrayHasKey('subject', $row);
            return $row['subject']['value'];
        }, $result['results']['bindings']);
        $expected = array(
            'http://example.org/001',
            'http://example.org/002',
            'http://example.org/003'
        );
        $this->assertEquals($expected, $subjects);
    }

    /**
     * Checks if query() accepts a query that uses numbers as variable identifiers.
     *
     * @see http://www.w3.org/TR/2013/REC-sparql11-query-20130321/#rVARNAME
     */
    public function testQueryAcceptsQueryThatUsesNumbersAsVariables()
    {
        $query = 'SELECT ?1 '
               . 'FROM <http://example.org> '
               . 'WHERE {'
               . '    {?1 a <http://example.org/animal>} UNION {?1 a <http://example.org/human>}'
               . '}';

        $result = $this->connector->query($query);

        $this->assertExtendedResultStructure($result);
    }

    /**
     * Ensures that query() returns only the variables that were
     * requested in the SPARQL query.
     */
    public function testQueryReturnsOnlyRequestedVariables()
    {
        $this->insertTriple();

        $query  = 'SELECT ?subject ?object FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object. }';
        $result = $this->connector->query($query);

        $expectedKeys = array(
            'subject',
            'object'
        );
        $this->assertExtendedResultStructure($result);
        foreach ($result['results']['bindings'] as $row) {
            /* @var $row array(string=>string) */
            $this->assertInternalType('array', $row);
            $keys           = array_keys($row);
            $additionalKeys = array_diff($keys, $expectedKeys);
            $this->assertEquals(array(), $additionalKeys, 'Additional keys in result rows detected.');
        }
    }

    /**
     * Checks if query() works with Unix new line values ("\n")
     * in the query.
     */
    public function testQueryHandlesUnixNewLines()
    {
        $query  = "SELECT ?subject ?object\n"
                . "FROM <http://example.org/graph>\n"
                . "WHERE { ?subject ?predicate ?object. }";

        $this->setExpectedException(null);
        $this->connector->query($query);
    }

    /**
     * Checks if query() works with Windows new line values ("\r\n")
     * in the query.
     */
    public function testQueryHandlesWindowsNewLines()
    {
        $query  = "SELECT ?subject ?object\r\n"
                . "FROM <http://example.org/graph>\r\n"
                . "WHERE { ?subject ?predicate ?object. }";

        $this->setExpectedException(null);
        $this->connector->query($query);
    }

    /**
     * Ensures that the connector does not fail if a query contains the internal escape
     * sequence in a literal or comment.
     */
    public function testQueryDoesNotFailIfQueryContainsEscapeSequenceInLiteralOrComment()
    {
        $query  = 'SELECT ?subject FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate "This is the escape sequence: ~\'"@en . } # In a comment: ~\'!';

        $this->setExpectedException(null);
        $this->connector->query($query);
    }

    /**
     * Ensures that the connector rejects queries that contain the internal escape
     * sequence at a position where it cannot be handled properly.
     *
     * This is not optimal, but at least it should prevent SQL injection attacks.
     */
    public function testQueryThrowsExceptionIfQueryContainsInternalEscapeSequence()
    {
        $query  = 'SELECT ?subject FROM <http://example.org/~\'test> '
                . 'WHERE { ?subject ?predicate "test"@en . }';

        $this->setExpectedException('InvalidArgumentException');
        $this->connector->query($query);
    }

    /**
     * Ensures that query() returns a boolean value if an ASK
     * query is passed.
     */
    public function testQueryReturnsBooleanIfAskQueryIsPassed()
    {
        $query  = 'ASK FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';

        $result = $this->connector->query($query);

        $this->assertInternalType('boolean', $result);
    }

    /**
     * Ensures that an ASK query returns false if no triple matches
     * the provided query.
     */
    public function testAskQueryReturnsFalseIfNoTripleMatches()
    {
        $query  = 'ASK FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';

        $result = $this->connector->query($query);

        $this->assertFalse($result);
    }

    /**
     * Ensures that an ASK query returns true if at least one triple matches
     * the provided SPARQL query.
     */
    public function testAskQueryReturnsTrueIfAtLeastOneTripleMatchesPattern()
    {
        $this->insertTriple();
        $query  = 'ASK FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?object . }';

        $result = $this->connector->query($query);

        $this->assertTrue($result);
    }

    /**
     * Ensures that query() can handle queries, which contain variable
     * identifiers that are reserved words in Oracle SQL.
     */
    public function testQueryWorksEvenIfReservedWordIsUsedAsVariable()
    {
        $query  = 'SELECT ?group FROM <http://example.org/graph> '
                . 'WHERE { ?group <http://example.org/relation#contains> <http:/example.org/user/matthias> . }';

        $this->setExpectedException(null);
        $this->connector->query($query);
    }

    /**
     * Checks if query() supports queries that contain IRIs with special characters.
     */
    public function testQuerySupportsIriWithSpecialCharacters()
    {
        $query = 'SELECT ?p ?o '
               . 'FROM <http://example.org/graph> '
               . 'WHERE { <http://example.org/iri/with/quote/x\'y> ?p ?o . }';

        $this->setExpectedException(null);
        $this->connector->query($query);
    }

    /**
     * Checks if the connector stores (and returns) a literal that contains
     * a single quote ("'") correctly.
     */
    public function testConnectorStoresLiteralWithQuoteCorrectly()
    {
        $object = array(
            'type'  => 'literal',
            'value' => 'Literal with quote (\').'
        );
        $this->insertTriple('http://example.org/subject', 'http://example.org/predicate', $object);

        $query  = 'SELECT ?object '
                . 'FROM <http://example.org/graph> '
                . 'WHERE { <http://example.org/subject> <http://example.org/predicate> ?object . }';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
        $row   = array_shift($result['results']['bindings']);
        $value = array_shift($row);
        $this->assertEquals($object['value'], $value['value']);
    }

    /**
     * Checks if the connector can work with SPARQL queries that contain
     * a full SPARQL query as literal.
     */
    public function testConnectorCanWorkWithSparqlQueryInStringLiteral()
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
        $result = $this->connector->query($query);

        // The inserted triple should have been selected.
        $this->assertNumberOfRows(1, $result);
    }

    /**
     * Checks if the connector can work with a SPARQL query that is passed as string literal
     * and that contains another literal itself.
     */
    public function testConnectorCanWorkWithSparqlQueryThatContainsLiteralInStringLiteral()
    {
        $object = array(
            'type'  => 'literal',
            'value' => 'SELECT ?subject WHERE { ?subject ?predicate "This is a ?test variable." . }'
        );
        $this->insertTriple('http://example.org/subject', 'http://example.org/predicate', $object);

        $query  = 'SELECT ?subject '
                . 'FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate %s . }';
        $query  = sprintf($query, Erfurt_Utils::buildLiteralString($object['value']));
        $result = $this->connector->query($query);

        // The inserted triple should have been selected.
        $this->assertNumberOfRows(1, $result);
    }

    /**
     * Checks if it is possible to use literals with quotes in SPARQL graph patterns.
     */
    public function testQueryAllowsSearchingForLiteralsWithQuote()
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
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
    }

    /**
     * Checks if query() handles camel cased variables (for example ?resourceUri)
     * correctly.
     */
    public function testQuerySupportsCamelCasedVariables()
    {
        $this->insertTriple();

        $query  = 'SELECT ?camelCasedObject '
                . 'FROM <http://example.org/graph> '
                . 'WHERE { ?subject ?predicate ?camelCasedObject . }';

        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
        $this->assertContains('camelCasedObject', $result['head']['vars']);
        $row = array_shift($result['results']['bindings']);
        $this->assertContains('camelCasedObject', array_keys($row));
    }

    /**
     * Ensures that deleteMatchingTriples() does nothing if no triples belong to
     * the given graph.
     */
    public function testDeleteMatchingTriplesDoesNothingIfNoCorrespondingTriplesExist()
    {
        $this->insertTriple();

        $this->connector->deleteMatchingTriples(
            'http://example.org',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(null, null, null)
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Checks if deleteMatchingTriples() removes all triples that belong to the
     * provided graph if a triple pattern without restrictions is passed.
     */
    public function testDeleteMatchingTriplesRemovesAllTriplesThatBelongToTheGivenGraph()
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

        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern()
        );

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Ensures that deleteMatchingTriples() does not remove triples from other graphs.
     */
    public function testDeleteMatchingTriplesDoesNotRemoveTriplesFromOtherGraphs()
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

        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern()
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Ensures that deleteMatchingTriples() removes all triples that match the
     * provided graph/subject combination.
     */
    public function testDeleteMatchingTriplesRemovesAllTriplesWithProvidedSubject()
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

        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                'http://example.org/some-subject'
            )
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Checks if deleteMatchingTriples() removes a specific triple if all details (subject,
     * predicate, object) are passed.
     */
    public function testDeleteMatchingTriplesDeletesSpecificTripleIfAllInformationIsPassed()
    {
        $this->insertTriple();
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/another-predicate',
            'http://example.org/another-object',
            'http://example.org/graph'
        );

        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                'http://example.org/subject',
                'http://example.org/another-predicate',
                array(
                    'value' => 'http://example.org/another-object',
                    'type'  => 'uri'
                )
            )
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Checks if deleteMatchingTriples() is able to remove a triple with literal as
     * object.
     */
    public function testDeleteMatchingTriplesDeletesTripleWithObjectLiteral()
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

        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                'http://example.org/subject',
                'http://example.org/another-predicate',
                array(
                    'value' => 'Hello world!',
                    'type'  => 'literal'
                )
            )
        );

        $this->assertEquals(1, $this->countTriples());
    }

    /**
     * Ensures that deleteMatchingTriples() returns 0 if no statement was deleted.
     */
    public function testDeleteMatchingTriplesReturnsZeroIfNoTripleWasDeleted()
    {
        $this->insertTriple();

        $deleted = $this->connector->deleteMatchingTriples(
            'http://example.org/not-existing-graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern()
        );

        $this->assertInternalType('integer', $deleted);
        $this->assertEquals(0, $deleted);
    }

    /**
     * Checks if deleteMatchingTriples() returns the number of removed triples.
     */
    public function testDeleteMatchingTriplesReturnsNumberOfDeletedTriples()
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

        $deleted = $this->connector->deleteMatchingTriples(
            'http://example.org/graph-that-will-be-deleted',
            new Erfurt_Store_Adapter_Sparql_TriplePattern()
        );

        $after = $this->countTriples();
        $this->assertInternalType('integer', $deleted);
        $this->assertEquals($before - $after, $deleted);
    }

    /**
     * Checks if triples with objects that are typed as string are removed correctly.
     */
    public function testDeleteMatchingTriplesRemovesObjectLiteralsThatAreTypedAsStringCorrectly()
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

        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                'http://example.org/subject',
                'http://example.org/predicate',
                $object
            )
        );

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Checks if triples that contain a literal object of type integer are removed correctly.
     */
    public function testDeleteMatchingTriplesRemovesObjectLiteralsThatAreTypedAsIntegerCorrectly()
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

        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                'http://example.org/subject',
                'http://example.org/predicate',
                $object
            )
        );

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Checks if triples with object literal that has a language are removed correctly.
     */
    public function testDeleteMatchingTriplesRemovesObjectLiteralsWithLanguageCorrectly()
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

        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                'http://example.org/subject',
                'http://example.org/predicate',
                $object
            )
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
        $result = $this->connector->query($query);

        $this->assertExtendedResultStructure($result);
        $triple = array_shift($result['results']['bindings']);
        // ... and pass its definition to the delete method.
        $this->connector->deleteMatchingTriples(
            'http://example.org/graph',
            new Erfurt_Store_Adapter_Sparql_TriplePattern(
                $triple['subject']['value'],
                $triple['predicate']['value'],
                $triple['object']
            )
        );

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Checks if the adapter can handle blank nodes.
     *
     * Blank nodes should not be treated as URIs and it should be possible
     * to use the SPARQL function isBLANK() to detect blank nodes.
     */
    public function testConnectorSupportsBlankNodes()
    {
        $this->insertTriple();
        $this->insertTriple('_:b1', 'http://example.org/predicate', array('value' => '_:b2', 'type' => 'bnode'));

        // Select the blank nodes.
        $query  = 'SELECT ?subject ?predicate ?object '
                . 'FROM <http://example.org/graph> '
                . 'WHERE {'
                . '    ?subject ?predicate ?object . '
                . '    FILTER(isBLANK(?subject) && isBLANK(?object))'
                . '}';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
    }

    /**
     * Ensures that the connector is able to insert values that contain double quotes
     * and which use a custom data type.
     */
    public function testConnectorCanInsertValuesWithCustomTypeAndDoubleQuoteAsContent()
    {
        $this->setExpectedException(null);
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'     => 'literal',
                'value'    => 'Hello "world"!',
                'datatype' => 'http://example.org/sentence'
            )
        );
    }

    /**
     * Checks if the connector is able to insert a triple that contains a literal that is longer
     * than 4000 bytes.
     */
    public function testConnectorCanInsertTripleWithVeryLongLiteral()
    {
        $this->setExpectedException(null);
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'  => 'literal',
                'value' => str_repeat('x', 4200)
            )
        );
    }

    /**
     * Checks if the connector can insert a large text literal that contains a
     * type definition (as text).
     */
    public function testConnectorCanInsertLargeLiteralThatContainsTypeDefinitionAsText()
    {
        $literal = '{{query where="?resourceUri aksw:promoted \'true\'^^xsd:boolean." template="liplain"}}';
        $literal = str_pad($literal, 4001, 'x', STR_PAD_RIGHT);

        $this->setExpectedException(null);
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'     => 'literal',
                'value'    => $literal,
                'datatype' => 'http://ns.ontowiki.net/SysOnt/Markdown'
            )
        );
    }

    /**
     * Checks if query() returns the content of a large literal correctly.
     */
    public function testQueryReturnsContentOfLargeLiteral()
    {
        $literal = str_repeat('x', 4200);
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'     => 'literal',
                'value'    => $literal
            )
        );

        $query = 'SELECT ?object '
               . 'FROM <http://example.org/graph> '
               . 'WHERE {'
               . '    <http://example.org/subject> <http://example.org/predicate> ?object .'
               . '}';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
        $row   = array_shift($result['results']['bindings']);
        $value = array_shift($row);
        $this->assertEquals($literal, $value['value']);
    }

    /**
     * Checks if query() returns a large literal, which contains special characters,
     * correctly.
     */
    public function testQueryReturnsContentOfLargeLiteralWithSpecialCharactersCorrectly()
    {
        $literal = '{{query where="?resourceUri aksw:promoted \'true\'^^xsd:boolean." template="liplain"}}';
        $literal = str_pad($literal, 4001, 'x', STR_PAD_RIGHT);
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'     => 'literal',
                'value'    => $literal,
                'datatype' => 'http://ns.ontowiki.net/SysOnt/Markdown'
            )
        );

        $query = 'SELECT ?object '
               . 'FROM <http://example.org/graph> '
               . 'WHERE {'
               . '    <http://example.org/subject> <http://example.org/predicate> ?object .'
               . '}';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
        $row   = array_shift($result['results']['bindings']);
        $value = array_shift($row);
        $this->assertEquals($literal, $value['value']);
    }

    /**
     * Checks if a literal that will be converted into a long literal ("""test""")
     * is returned correctly by the adapter.
     */
    public function testConnectorReturnsValueOfLongLiteralCorrectly()
    {
        // Single quotes in the literal ensure that double quotes are used for escaping.
        // The line break leads to the usage of a long literal.
        $literal = "Hello\n 'world'!";
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'     => 'literal',
                'value'    => $literal
            )
        );

        $query = 'SELECT ?object '
               . 'FROM <http://example.org/graph> '
               . 'WHERE {'
               . '    <http://example.org/subject> <http://example.org/predicate> ?object .'
               . '}';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
        $row   = array_shift($result['results']['bindings']);
        $value = array_shift($row);
        $this->assertEquals($literal, $value['value']);
    }

    /**
     * Ensures that the connector stores literal type and value correctly if the literal
     * value contains a type definition (which must be considered as text).
     */
    public function testConnectorRecognizesTypeOfLiteralThatContainsTypeDefinitionAsTextCorrectly()
    {
        $literal  = '"?resourceUri aksw:promoted \'true\'^^xsd:boolean."';
        $dataType = 'http://example.org/type/query';
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'     => 'literal',
                'value'    => $literal,
                'datatype' => $dataType
            )
        );

        $query = 'SELECT ?object (DATATYPE(?object) AS ?dataType)'
               . 'FROM <http://example.org/graph> '
               . 'WHERE {'
               . '    <http://example.org/subject> <http://example.org/predicate> ?object .'
               . '}';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
        $row = array_shift($result['results']['bindings']);
        $this->assertArrayHasKey('object', $row);
        $this->assertArrayHasKey('dataType', $row);
        $this->assertEquals($literal, $row['object']['value']);
        $this->assertEquals($dataType, $row['dataType']['value']);
    }

    /**
     * Checks if the connector handles literals with umlauts correctly.
     */
    public function testConnectorHandlesUmlautsCorrectly()
    {
        $literalValue = 'hühü';
        $this->insertTriple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'     => 'literal',
                'value'    => $literalValue
            )
        );

        $query  = 'SELECT ?object FROM <http://example.org/graph> WHERE { ?subject ?predicate ?object . }';
        $result = $this->connector->query($query);

        $this->assertNumberOfRows(1, $result);
        $row   = array_shift($result['results']['bindings']);
        $value = array_shift($row);
        $this->assertEquals($literalValue, $value['value']);
    }

    /**
     * Checks if the callback that is passed to batch() is executed.
     */
    public function testBatchExecutesProvidedCallback()
    {
        $callback = $this->getMock('\stdClass', array('__invoke'));
        $callback->expects($this->once())
                 ->method('__invoke');

        $this->connector->batch($callback);
    }

    /**
     * Ensures that a connector is passed as parameter to the batch
     * callback.
     */
    public function testBatchPassesConnectorAsParameter()
    {
        $callback = $this->getMock('\stdClass', array('__invoke'));
        $callback->expects($this->once())
                 ->method('__invoke')
                 ->with($this->isInstanceOf('\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface'));

        $this->connector->batch($callback);
    }

    /**
     * Checks if batch() returns the result from the callback.
     */
    public function testBatchReturnsReturnsFromCallback()
    {
        $callback = function () {
            return 42;
        };

        $result = $this->connector->batch($callback);

        $this->assertEquals(42, $result);
    }

    /**
     * Checks if triples are successfully added in batch mode.
     */
    public function testBatchCanBeUsedToInsertTriples()
    {
        $addTriples = function ($connector) {
            PHPUnit_Framework_Assert::assertInstanceOf(
                '\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface',
                $connector
            );
            /* @var $connector \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface */
            $connector->addTriple(
                'http://example.org/graph',
                new Erfurt_Store_Adapter_Sparql_Triple(
                    'http://example.org/subject1',
                    'http://example.org/predicate1',
                    array(
                        'type'  => 'uri',
                        'value' => 'http://example.org/object1'
                    )
                )
            );
            $connector->addTriple(
                'http://example.org/graph',
                new Erfurt_Store_Adapter_Sparql_Triple(
                    'http://example.org/subject2',
                    'http://example.org/predicate2',
                    array(
                        'type'  => 'uri',
                        'value' => 'http://example.org/object2'
                    )
                )
            );
        };

        $this->connector->batch($addTriples);

        $this->assertEquals(2, $this->countTriples());
    }

    /**
     * Asserts that the provided (extended) result set contains
     * the expected number of result rows.
     *
     * @param integer $expected The expected number of rows.
     * @param mixed $resultSet
     */
    protected function assertNumberOfRows($expected, $resultSet)
    {
        $this->assertExtendedResultStructure($resultSet);
        $this->assertCount($expected, $resultSet['results']['bindings']);
    }

    /**
     * Asserts that the provided result set has the structure of an extended
     * result.
     *
     * An extended result set contains a head with variable names and a set
     * of bindings:
     *
     *     array(
     *         'head' => array(
     *             'vars' => array(
     *                 // Contains the names of all variables that occur in the result set.
     *             )
     *         )
     *         'results' => array(
     *             'bindings' => array(
     *                 // Contains one entry for each result set row.
     *                 // Each entry contains the variable name as key and a set
     *                 // of additional information as value:
     *             )
     *         )
     *     )
     *
     * @param array(mixed)|mixed $resultSet
     */
    protected function assertExtendedResultStructure($resultSet)
    {
        $this->assertInternalType('array', $resultSet);

        // Check the variable declaration in the head.
        $this->assertArrayHasKey('head', $resultSet);
        $this->assertInternalType('array', $resultSet['head']);
        $this->assertArrayHasKey('vars', $resultSet['head']);
        $this->assertInternalType('array', $resultSet['head']['vars']);
        $this->assertContainsOnly('string', $resultSet['head']['vars']);

        // Check the result bindings.
        $this->assertArrayHasKey('results', $resultSet);
        $this->assertInternalType('array', $resultSet['results']);
        $this->assertArrayHasKey('bindings', $resultSet['results']);
        $this->assertInternalType('array', $resultSet['results']['bindings']);
        foreach ($resultSet['results']['bindings'] as $binding) {
            /* @var $binding array(array(string=>array(string=>mixed)) */
            $this->assertInternalType('array', $binding);
            foreach ($binding as $name => $valueDefinition) {
                /* @var $name string */
                /* @var $valueDefinition array(string=>mixed) */
                $this->assertInternalType('string', $name);
                $this->assertInternalType('array', $valueDefinition);
                $this->assertArrayHasKey('type', $valueDefinition);
                $this->assertArrayHasKey('value', $valueDefinition);
            }
        }
    }

    /**
     * Counts all triples in the database.
     *
     * @return integer The number of triples.
     */
    protected function countTriples()
    {
        return $this->helper->countTriples();
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
        $triple = new Erfurt_Store_Adapter_Sparql_Triple($subjectIri, $predicateIri, $object);
        $this->connector->addTriple($graphIri, $triple);
    }

}
