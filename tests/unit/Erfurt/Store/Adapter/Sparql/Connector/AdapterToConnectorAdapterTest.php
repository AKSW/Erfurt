<?php

/**
 * Tests the Adapter to Connector implementation.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 27.04.14
 */
class Erfurt_Store_Adapter_Sparql_Connector_AdapterToConnectorAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Sparql_Connector_AdapterToConnectorAdapter
     */
    protected $adapter = null;

    /**
     * The simulated Store adapter.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeAdapter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->storeAdapter = $this->getMock('Erfurt_Store_Adapter_Interface');
        $this->adapter      = new Erfurt_Store_Adapter_Sparql_Connector_AdapterToConnectorAdapter($this->storeAdapter);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->adapter      = null;
        $this->storeAdapter = null;
        parent::tearDown();
    }

}
