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

    public function testWrapThrowsExceptionIfSparqlQueryContainsInternalEscapeSequence()
    {

    }

    public function testWrapAddsModelName()
    {

    }

    public function testWrapAddSparqlQuery()
    {

    }

    public function testWrapAddsParallelizationHintIfSparqlQueryContainsManyFilters()
    {

    }

    public function testWrapDoesNotAddParallelizationHintIfQueryDoesNotContainManyFilters()
    {

    }

    public function testWrapAddsOrderByIfSparqlQueryRequiresSorting()
    {

    }

    public function testWrapDoesNotAddOrderByIfSparqlQueryDoesNotRequireSorting()
    {

    }

}
