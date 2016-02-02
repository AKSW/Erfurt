<?php

/**
 * Erfurt_Store_Adapter_SparqlSqlCombinationTest
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 07.01.14
 */
class Erfurt_Store_Adapter_SparqlSqlCombinationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_SparqlSqlCombination
     */
    protected $adapter = null;

    /**
     * The mocked SPARQL adapter.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $sparqlAdapter = null;

    /**
     * The mocked SQL adapter.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $sqlAdapter = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sparqlAdapter = $this->getMock('\Erfurt_Store_Adapter_Interface');
        $this->sqlAdapter    = $this->getMock('\Erfurt_Store_Sql_Interface');
        $this->adapter       = new Erfurt_Store_Adapter_SparqlSqlCombination($this->sparqlAdapter, $this->sqlAdapter);
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->adapter       = null;
        $this->sqlAdapter    = null;
        $this->sparqlAdapter = null;
        parent::tearDown();
    }

    /**
     * Checks if the methods in the SPARQL adapter interface are delegated correctly.
     *
     * @param string $method
     * @param array(mixed) $expectedArguments
     * @param mixed $expectedReturn
     * @dataProvider getSparqlAdapterCalls
     */
    public function testSparqlAdapterCallsAreDelegatedCorrectly($method, $expectedArguments, $expectedReturn)
    {
        $this->assertInterfaceContains('Erfurt_Store_Adapter_Interface', $method);
        $this->simulateMethod($this->sparqlAdapter, $method, $expectedArguments, $expectedReturn);

        $return = call_user_func_array(array($this->adapter, $method), $expectedArguments);

        $this->assertEquals($expectedReturn, $return);
    }

    /**
     * Checks if the methods in the SQL adapter interface are delegated correctly.
     *
     * @param string $method
     * @param array(mixed) $expectedArguments
     * @param mixed $expectedReturn
     * @dataProvider getSqlAdapterCalls
     */
    public function testSqlAdapterCallsAreDelegatedCorrectly($method, $expectedArguments, $expectedReturn)
    {
        $this->assertInterfaceContains('Erfurt_Store_Sql_Interface', $method);
        $this->simulateMethod($this->sqlAdapter, $method, $expectedArguments, $expectedReturn);

        $return = call_user_func_array(array($this->adapter, $method), $expectedArguments);

        $this->assertEquals($expectedReturn, $return);
    }

    /**
     * Prepares a mock object to simulate (and expect) a method call.
     *
     * @param PHPUnit_Framework_MockObject_MockObject $mock
     * @param string $method
     * @param array(mixed) $expectedArguments
     * @param mixed $returnValue
     */
    protected function simulateMethod(
        PHPUnit_Framework_MockObject_MockObject $mock,
        $method,
        $expectedArguments,
        $returnValue
    )
    {
        $call = $mock->expects($this->once())->method($method);
        $call = call_user_func_array(array($call, 'with'), $expectedArguments);
        $call->will($this->returnValue($returnValue));
    }

    /**
     * Asserts that the provided interface defines the given method.
     *
     * @param string $interface
     * @param string $method
     */
    protected function assertInterfaceContains($interface, $method)
    {
        $methods = get_class_methods($interface);
        $message = 'Interface %s  does not contain method %s(). If this is intended, '
                 . 'then this test data should be removed.';
        $message = sprintf($message, $interface, $method);
        $this->assertContains($method, $methods, $message);
    }

    /**
     * Returns SPARQL adapter method names as well as corresponding
     * arguments and return values.
     *
     * @return array(mixed)
     */
    public function getSparqlAdapterCalls()
    {
        return array(
            array(
                'addMultipleStatements',
                array(
                    'http://example.org/graph',
                    array(),
                    array()
                ),
                null
            ),
            array(
                'addStatement',
                array(
                    'http://example.org/graph',
                    'http://example.org/subject',
                    'http://example.org/predicate',
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array()
                ),
                null
            ),
            array(
                'createModel',
                array(
                    'http://example.org/graph',
                    Erfurt_Store::MODEL_TYPE_OWL
                ),
                true
            ),
            array(
                'deleteMatchingStatements',
                array(
                    'http://example.org/graph',
                    'http://example.org/subject',
                    'http://example.org/predicate',
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array()
                ),
                42
            ),
            array(
                'deleteMultipleStatements',
                array(
                    'http://example.org/graph',
                    array()
                ),
                null
            ),
            array(
                'deleteModel',
                array(
                    'http://example.org/graph'
                ),
                null
            ),
            array(
                'exportRdf',
                array(
                    'http://example.org/graph',
                    'xml',
                    null
                ),
                '<rdf>data</rdf>'
            ),
            array(
                'getAvailableModels',
                array(),
                array('http://example.org/graph' => true)
            ),
            array(
                'getBlankNodePrefix',
                array(),
                '_'
            ),
            array(
                'getSupportedExportFormats',
                array(),
                array('rdf')
            ),
            array(
                'getSupportedImportFormats',
                array(),
                array('json')
            ),
            array(
                'importRdf',
                array(
                    'http://example.org/graph',
                    'data',
                    'auto',
                    'http://example.org/data/semantic.txt'
                ),
                true
            ),
            array(
                'init',
                array(),
                null
            ),
            array(
                'isModelAvailable',
                array(
                    'http://example.org/graph'
                ),
                false
            ),
            array(
                'sparqlAsk',
                array(
                    'ASK WHERE { ?s ?p ?o . }'
                ),
                true
            ),
            array(
                'sparqlQuery',
                array(
                    'SELECT ?o WHERE { ?s ?p ?o . }',
                    array()
                ),
                array()
            ),
        );
    }

    /**
     * Returns SQL adapter method names as well as corresponding
     * arguments and return values.
     *
     * @return array(mixed)
     */
    public function getSqlAdapterCalls()
    {
        return array(
            array(
                'createTable',
                array(
                    'test_table',
                    array('id' => 'INT NOT NULL', 'name' => 'VARCHAR(255) NOT NULL')
                ),
                null
            ),
            array(
                'lastInsertId',
                array(),
                42
            ),

            array(
                'listTables',
                array(
                    'prefix_'
                ),
                array('prefix_a_table')
            ),

            array(
                'sqlQuery',
                array(
                    'SELECT * FROM DUAL',
                    42,
                    7
                ),
                array()
            )
        );
    }

}
