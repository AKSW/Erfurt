<?php

/**
 * Erfurt_Store_Adapter_Sparql_Connector_SlowQueryLogConnectorDecoratorTest
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.03.14
 */
class Erfurt_Store_Adapter_Sparql_Connector_SlowQueryLogConnectorDecoratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Decorator with a high threshold that should not log any query.
     *
     * @var Erfurt_Store_Adapter_Sparql_Connector_SlowQueryLogConnectorDecorator
     */
    protected $highThresholdDecorator = null;

    /**
     * Decorator with a low threshold that should log all queries.
     *
     * @var Erfurt_Store_Adapter_Sparql_Connector_SlowQueryLogConnectorDecorator
     */
    protected $logAllDecorator = null;

    /**
     * The (mocked) decorated connector.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $innerConnector = null;

    /**
     * The log writer instance that is used for testing.
     *
     * @var Zend_Log_Writer_Mock
     */
    protected $logWriter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->innerConnector = $this->getMock('Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface');
        $this->logWriter      = new Zend_Log_Writer_Mock();
        $this->highThresholdDecorator = new Erfurt_Store_Adapter_Sparql_Connector_SlowQueryLogConnectorDecorator(
            $this->innerConnector,
            new Zend_Log($this->logWriter),
            2000
        );
        $this->logAllDecorator = new Erfurt_Store_Adapter_Sparql_Connector_SlowQueryLogConnectorDecorator(
            $this->innerConnector,
            new Zend_Log($this->logWriter),
            0
        );
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {

        $this->logAllDecorator        = null;
        $this->highThresholdDecorator = null;
        $this->logWriter              = null;
        $this->innerConnector         = null;
        parent::tearDown();
    }

    /**
     * Ensures that the decorator does not log queries that do not exceed the threshold.
     */
    public function testDecoratorDoesNotLogQueriesWithinThreshold()
    {
        $this->highThresholdDecorator->query('SELECT * WHERE { ?s ?p ?o . }');

        $this->assertEmpty($this->logWriter->events);
    }

    /**
     * Checks if the decorator logs queries that reach the defined threshold.
     */
    public function testDecoratorLogsQueriesThatReachThreshold()
    {
        $this->logAllDecorator->query('SELECT * WHERE { ?s ?p ?o . }');

        $this->assertCount(1, $this->logWriter->events);
    }

    /**
     * Checks if query() returns the result from the inner connector.
     */
    public function testQueryReturnsResultFromInnerConnector()
    {
        $this->innerConnector->expects($this->once())
                             ->method('query')
                             ->with('ASK WHERE { ?s ?p ?o . }')
                             ->will($this->returnValue(true));

        $result = $this->highThresholdDecorator->query('ASK WHERE { ?s ?p ?o . }');

        $this->assertTrue($result);
    }

}
