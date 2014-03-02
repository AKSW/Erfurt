<?php

/**
 * Tests the Oracle SPARQL connector.
 *
 * @since 02.02.14
 * @group Oracle
 */
class Erfurt_Store_Adapter_Oracle_OracleSparqlConnectorTest
    extends Erfurt_Store_Adapter_Sparql_AbstractSparqlConnectorTestCase
{

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
        $this->helper = new \Erfurt_OracleTestHelper();
        $this->helper->installTripleStore();
        parent::setUp();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->helper->cleanUp();
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
     * Creates the SPARQL connector that will be tested.
     *
     * @return \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
     */
    protected function createConnector()
    {
        return $this->helper->getSparqlConnector();
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

}
