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

    /**
     * Checks if the adapter implements the Connector interface.
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf('Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface', $this->adapter);
    }

    /**
     * Checks if addTriple() delegates to the addStatement() method of the Store adapter.
     */
    public function testAddTripleDelegatesToAddStatement()
    {
        $triple = new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/subject',
            'http://example.org/predicate',
            array('type' => 'uri', 'value' => 'http://example.org/object')
        );
        $this->storeAdapter->expects($this->once())
                           ->method('addStatement')
                           ->with(
                               'http://example.org/graph',
                               $triple->getSubject(),
                               $triple->getPredicate(),
                               $triple->getObject(),
                               array()
                           );

        $this->adapter->addTriple('http://example.org/graph', $triple);
    }

    /**
     * Ensures that the addTriple() calls are delegated to addMultipleStatements() in batch mode.
     */
    public function testAdditionsAreDelegatedToAddMultipleStatementsInBatchMode()
    {
        $first = new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/subject1',
            'http://example.org/predicate1',
            array('type' => 'uri', 'value' => 'http://example.org/object1')
        );
        $second = new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/subject2',
            'http://example.org/predicate2',
            array('type' => 'uri', 'value' => 'http://example.org/object2')
        );
        $statements = array(
            $first->getSubject() => array(
                $first->getPredicate() => array(
                    $first->getObject()
                )
            ),
            $second->getSubject() => array(
                $second->getPredicate() => array(
                    $second->getObject()
                )
            )
        );
        $this->storeAdapter->expects($this->once())
                           ->method('addMultipleStatements')
                           ->with('http://example.org/graph', $statements, array());

        $this->adapter->batch(function ($connector) use ($first, $second) {
            PHPUnit_Framework_Assert::assertInstanceOf(
                'Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface',
                $connector
            );
            /* @var $connector Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface */
            $connector->addTriple('http://example.org/graph', $first);
            $connector->addTriple('http://example.org/graph', $second);
        });
    }

    /**
     * Checks if query() delegates to sparqlQuery().
     */
    public function testQueryDelegatesToSparqlQuery()
    {
        $query = 'SELECT * WHERE { ?s ?p ?o . }';
        $this->storeAdapter->expects($this->once())
                           ->method('sparqlQuery')
                           ->with($query);

        $this->adapter->query($query);
    }

    /**
     * Ensures that query() delegates ASK queries to sparqlAsk().
     */
    public function testQueryDelegatesAskQueryToSparqlAsk()
    {
        $query = 'ASK WHERE { ?s ?p ?o . }';
        $this->storeAdapter->expects($this->once())
                           ->method('sparqlAsk')
                           ->with($query);

        $this->adapter->query($query);
    }

    /**
     * Checks if deleteMatchingTriples() delegates to the correct adapter method.
     */
    public function testDeleteMatchingTriplesDelegatesToCorrectAdapterMethod()
    {
        $pattern = new Erfurt_Store_Adapter_Sparql_TriplePattern(
            'http://example.org/subject',
            'http://example.org/predicate',
            array('type' => 'uri', 'value' => 'http://example.org/object')
        );
        $this->storeAdapter->expects($this->once())
                           ->method('isModelAvailable')
                           ->with('http://example.org/graph')
                           ->will($this->returnValue(true));
        $this->storeAdapter->expects($this->once())
                           ->method('deleteMatchingStatements')
                           ->with(
                               'http://example.org/graph',
                               $pattern->getSubject(),
                               $pattern->getPredicate(),
                               $pattern->getObject(),
                               array()
                           );

        $this->adapter->deleteMatchingTriples('http://example.org/graph', $pattern);
    }

    /**
     * Ensures that deleteMatchingTriples() does not call deleteMatchingStatements()
     * on the adapter if the model does not exist.
     */
    public function testDeleteMatchingTriplesDoesNotDelegateCallIfModelDoesNotExist()
    {
        $pattern = new Erfurt_Store_Adapter_Sparql_TriplePattern(
            'http://example.org/subject',
            'http://example.org/predicate',
            array('type' => 'uri', 'value' => 'http://example.org/object')
        );
        $this->storeAdapter->expects($this->once())
                           ->method('isModelAvailable')
                           ->with('http://example.org/graph')
                           ->will($this->returnValue(false));
        $this->storeAdapter->expects($this->never())
            ->method('deleteMatchingStatements');

        $this->adapter->deleteMatchingTriples('http://example.org/graph', $pattern);
    }

    /**
     * Ensures that batch() executes the provided callback.
     */
    public function testBatchExecutesCallback()
    {
        $callback = $this->getMock('stdClass', array('__invoke'));
        $callback->expects($this->once())
                 ->method('__invoke');

        $this->adapter->batch($callback);
    }

}
