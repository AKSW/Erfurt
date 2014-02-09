<?php

/**
 * Tests the SPARQL wrapper.
 *
 * These tests do not check if the generated SQL query is valid as
 * this would be a very complex task.
 * Instead, the tests verify that some statement parts are present or absent.
 *
 * The correctness of the SQL query itself is ensured by the integration tests.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.02.14
 */
class Erfurt_Store_Adapter_Oracle_SparqlWrapperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Oracle_SparqlWrapper
     */
    protected $wrapper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $quoter = function ($value) {
            return "'$value'";
        };
        $this->wrapper = new \Erfurt_Store_Adapter_Oracle_SparqlWrapper('model_erfurt', $quoter);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->wrapper = null;
        parent::tearDown();
    }

    /**
     * Ensures that the constructor of the wrapper throws an exception if the provided
     * quoter is not callable.
     */
    public function testWrapperThrowsExceptionIfProvidedQuoterIsNotCallable()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Erfurt_Store_Adapter_Oracle_SparqlWrapper('test_model', array($this, 'missing'));
    }

    /**
     * Ensures that wrap() throws an exception if the SPARQL query contains the internal
     * escape sequence.
     *
     * That's not a perfect solution, but at least it is unlikely.
     */
    public function testWrapThrowsExceptionIfSparqlQueryContainsInternalEscapeSequence()
    {
        $query = 'SELECT * WHERE { ?subject ?predicate "This is the escape sequence: ~\'"@en .}';

        $this->setExpectedException('InvalidArgumentException');
        $this->wrapper->wrap($query);
    }

    /**
     * Checks if wrap() adds the name of the model to the SQL.
     */
    public function testWrapAddsModelName()
    {
        $query = 'SELECT * WHERE { ?subject ?predicate ?object . }';

        $sql = $this->wrapper->wrap($query);

        $this->assertContains('model_erfurt', $sql);
    }

    /**
     * Checks if wrap() adds the SPARQL query to the SQL.
     */
    public function testWrapAddSparqlQuery()
    {
        $query = 'SELECT * WHERE { ?subject ?predicate ?object . }';

        $sql = $this->wrapper->wrap($query);

        $this->assertContains($query, $sql);
    }

    /**
     * Ensures that wrap() adds the parallelization query hint if the SPARQL query
     * contains many filters.
     */
    public function testWrapAddsParallelizationHintIfSparqlQueryContainsManyFilters()
    {
        $query = 'SELECT * WHERE { '
               . '    ?subject ?predicate ?object . '
               . '    FILTER (!REGEXP(?subject, "^a")) '
               . '    FILTER (!REGEXP(?subject, "^b")) '
               . '    FILTER (!REGEXP(?subject, "^c")) '
               . '    FILTER (!REGEXP(?subject, "^d")) '
               . '    FILTER (!REGEXP(?subject, "^e")) '
               . '    FILTER (!REGEXP(?subject, "^f")) '
               . '}';

        $sql = $this->wrapper->wrap($query);

        $this->assertContainsHint('PARALLEL', $sql);
    }

    /**
     * Ensures that wrap() can handle SPARQL queries with nested patterns.
     */
    public function testWrapCanHandleQueriesWithNestedPatterns()
    {
        $query = 'SELECT * WHERE { '
               . '    { '
               . '        ?subject ?predicate ?object . '
               . '        FILTER (!REGEXP(?subject, "^a")) '
               . '        FILTER (!REGEXP(?subject, "^b")) '
               . '        FILTER (!REGEXP(?subject, "^c")) '
               . '    } UNION { '
               . '       ?subject ?predicate ?object . '
               . '        FILTER (!REGEXP(?subject, "^d")) '
               . '        FILTER (!REGEXP(?subject, "^e")) '
               . '        FILTER (!REGEXP(?subject, "^f")) '
               . '    } '
               . '}';

        $sql = $this->wrapper->wrap($query);

        $this->assertContainsHint('PARALLEL', $sql);
    }

    /**
     * Ensures that wrap() does not add the parallelization query hint if the SPARQL query
     * does not use many FILTER expressions.
     */
    public function testWrapDoesNotAddParallelizationHintIfQueryDoesNotContainManyFilters()
    {
        $query = 'SELECT * WHERE { ?subject ?predicate ?object . }';

        $sql = $this->wrapper->wrap($query);

        $this->assertNotContains('PARALLEL', $sql);
    }

    /**
     * Ensures that wrap() adds ORDER BY if the SPARQL query requires an ordered result.
     */
    public function testWrapAddsOrderByIfSparqlQueryRequiresSorting()
    {
        $query = 'SELECT * WHERE { ?subject ?predicate ?object . } ORDER BY ASC(?subject)';

        $sql = $this->wrapper->wrap($query);

        $this->assertContains('ORDER BY SEM$ROWNUM', $sql);
    }

    /**
     * Ensures that wrap() does not add ORDER BY if the SPARQL query does not
     * request an ordered result set.
     */
    public function testWrapDoesNotAddOrderByIfSparqlQueryDoesNotRequireSorting()
    {
        $query = 'SELECT * WHERE { ?subject ?predicate ?object . }';

        $sql = $this->wrapper->wrap($query);

        $this->assertNotContains('ORDER BY SEM$ROWNUM', $sql);
    }

    /**
     * Checks if the wrapper activates the strict default graph option, which means
     * that the default graph contains only triples without graph part.
     */
    public function testWrapActivatesStrictDefaultGraphOption()
    {
        $query = 'SELECT * WHERE { ?subject ?predicate ?object . }';

        $sql = $this->wrapper->wrap($query);

        $this->assertContains('STRICT_DEFAULT=T', $sql);
    }

    public function testWrapRequestsCorrectColumnsIfStarIsUsedAsSelector()
    {

    }

    public function testWrapRequestsCorrectColumnsIfProjectionVarsAreProvided()
    {

    }

    public function testWrapDoesNotRequestColumnsThatAreNotPartOfProjectionVars()
    {
        
    }

    /**
     * Asserts that the provided SQL query contains the hint $name.
     *
     * @param string $name
     * @param string $sql
     */
    protected function assertContainsHint($name, $sql)
    {
        $this->assertContains('/*+', $sql, 'Query does not contain sequence "/*+", which starts a query hint.');
        $this->assertContains($name, $sql);
    }

}
