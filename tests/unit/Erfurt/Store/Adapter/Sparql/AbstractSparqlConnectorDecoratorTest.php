<?php

/**
 * Tests the abstract connector decorator.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.03.14
 */
class Erfurt_Store_Adapter_Sparql_AbstractSparqlConnectorDecoratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Sparql_AbstractSparqlConnectorDecorator
     */
    protected $decorator = null;

    /**
     * The (mocked) decorated connector.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $innerConnector = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->innerConnector = $this->getMock('Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface');
        $this->decorator      = $this->getMockForAbstractClass(
            'Erfurt_Store_Adapter_Sparql_AbstractSparqlConnectorDecorator',
            array($this->innerConnector)
        );
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->decorator      = null;
        $this->innerConnector = null;
        parent::tearDown();
    }

    /**
     * Checks if the decorator implements the connector interface.
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf('Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface', $this->decorator);
    }

    /**
     * Checks if the decorator delegates the method calls to the inner decorator.
     *
     * @param string $method
     * @param array(mixed) $arguments
     * @param mixed $returnValue
     * @dataProvider methodCallProvider
     */
    public function testDelegatesMethodCall($method, array $arguments, $returnValue)
    {
        $message = 'Decorator does not provide method "' . $method . '".';
        $this->assertTrue(method_exists($this->decorator, $method), $message);

        $methodExpectation = $this->innerConnector->expects($this->once())->method($method);
        $methodExpectation = call_user_func_array(array($methodExpectation, 'with'), $arguments);
        $methodExpectation->will($this->returnValue($returnValue));

        $result = call_user_func_array(array($this->decorator, $method), $arguments);
        $this->assertEquals($returnValue, $result);
    }

    /**
     * Checks if batch() passes the decorated connector to the provided callback.
     */
    public function testBatchPassesDecoratorToCallback()
    {
        $innerConnector = $this->innerConnector;
        $innerBatch = function ($callback) use ($innerConnector) {
            $message = 'Callback expected.';
            PHPUnit_Framework_Assert::assertTrue(is_callable($callback), $message);
            call_user_func($callback, $innerConnector);
        };
        $this->innerConnector->expects($this->once())
                             ->method('batch')
                             ->will($this->returnCallback($innerBatch));

        $callback = $this->getMock('stdClass', '__invoke');
        $callback->expects($this->once())
                 ->method('__invoke')
                 ->with($this->isInstanceOf('Erfurt_Store_Adapter_Sparql_AbstractSparqlConnectorDecorator'));
        $this->decorator->batch($callback);
    }

    /**
     * Ensures that batch() throws an exception if no valid callback is provided.
     */
    public function testBatchThrowsExceptionIfNoValidCallbackIsPassed()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->decorator->batch(new \stdClass());
    }

    /**
     * Provides test data for each method call that must be delegated.
     *
     * Each record contains:
     *
     * - The name of the method.
     * - A list of arguments.
     * - The return value.
     *
     * @return array(array(string|array(mixed)|mixed))
     */
    public function methodCallProvider()
    {
        return array(
            array(
                'addTriple',
                array(
                    'http://example.org/graph',
                    new Erfurt_Store_Adapter_Sparql_Triple(
                        'http://example.org/subject',
                        'http://example.org/predicate',
                        array('type' => 'uri', 'value' => 'http://example.org/object')
                    )
                ),
                null
            ),
            array(
                'query',
                array(
                    'ASK WHERE { ?s ?p ?o . }'
                ),
                true
            ),
            array(
                'deleteMatchingTriples',
                array(
                    'http://example.org/graph',
                    new Erfurt_Store_Adapter_Sparql_TriplePattern(null, null, null)
                ),
                42
            ),
            array(
                'batch',
                array(
                    function () {}
                ),
                null
            )
        );
    }

}
