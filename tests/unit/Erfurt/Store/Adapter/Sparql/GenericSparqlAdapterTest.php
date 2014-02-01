<?php

/**
 * Tests the generic SPARQL adapter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.02.14
 */
class Erfurt_Store_Adapter_Sparql_GenericSparqlAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Sparql_GenericSparqlAdapter
     */
    protected $adapter = null;

    /**
     * The (mocked) connector that is used by the adapter.
     *
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $connector = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->connector = $this->getMock('\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface');
        $this->adapter   = new Erfurt_Store_Adapter_Sparql_GenericSparqlAdapter($this->connector);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->adapter   = null;
        $this->connector = null;
        parent::tearDown();
    }

}
