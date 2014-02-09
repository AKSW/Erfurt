<?php

/**
 * Tests the SPARQL wrapper.
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

    }

    /**
     * Checks if wrap() adds the name of the model to the SQL.
     */
    public function testWrapAddsModelName()
    {

    }

    /**
     * Checks if wrap() adds the SPARQL query to the SQL.
     */
    public function testWrapAddSparqlQuery()
    {

    }

    /**
     * Ensures that wrap() adds the parallelization query hint if the SPARQL query
     * contains many filters.
     */
    public function testWrapAddsParallelizationHintIfSparqlQueryContainsManyFilters()
    {

    }

    /**
     * Ensures that wrap() does not add the parallelization query hint if the SPARQL query
     * does not use many FILTER expressions.
     */
    public function testWrapDoesNotAddParallelizationHintIfQueryDoesNotContainManyFilters()
    {

    }

    /**
     * Ensures that wrap() adds ORDER BY if the SPARQL query requires an ordered result.
     */
    public function testWrapAddsOrderByIfSparqlQueryRequiresSorting()
    {

    }

    /**
     * Ensures that wrap() does not add ORDER BY if the SPARQL query does not
     * request an ordered result set.
     */
    public function testWrapDoesNotAddOrderByIfSparqlQueryDoesNotRequireSorting()
    {

    }

    /**
     * Checks if the wrapper activates the strict default graph option, which means
     * that the default graph contains only triples without graph part.
     */
    public function testWrapActivatesStrictDefaultGraphOption()
    {

    }

}
