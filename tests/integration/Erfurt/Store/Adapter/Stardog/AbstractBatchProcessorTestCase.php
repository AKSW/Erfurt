<?php

/**
 * Base test case for Stardog batch processors.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.03.14
 */
abstract class Erfurt_Store_Adapter_Stardog_AbstractBatchProcessorTestCase
    extends Erfurt_Store_Adapter_Sparql_AbstractBatchProcessorTestCase
{

    /**
     * Test helper that is used to initialize the environment.
     *
     * @var \Erfurt_StardogTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        $this->helper    = new Erfurt_StardogTestHelper();
        parent::setUp();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->helper->cleanUp();
        $this->helper = null;
    }

    /**
     * Checks if the processor stores a quad whose object literal is equal to the
     * subject URI correctly (with object as literal).
     */
    public function testPersistStoresQuadWithLiteralsThatEqualsSubjectUriCorrectly()
    {
        $quad = new Erfurt_Store_Adapter_Sparql_Quad(
            'http://example.org/subject',
            'http://example.org/predicate',
            array(
                'type'  => 'literal',
                'value' => 'http://example.org/subject'
            ),
            'http://example.org/graph'
        );

        $this->processor->persist(array($quad));

        $query = 'SELECT * FROM <http://example.org/graph> WHERE { ?s ?p "http://example.org/subject" }';
        $this->assertNumberOfRowsSelected(1, $query);
    }

    /**
     * Asserts that the whole database contains the expected number of triples.
     *
     * @param integer $expected
     */
    protected function assertNumberOfTriples($expected)
    {
        $this->assertEquals($expected, $this->helper->getApiClient()->size());
    }

    /**
     * Executes the provided SPARQL query and returns the result in extended format.
     *
     * @param string $query
     * @return mixed
     */
    protected function executeSparqlQuery($query)
    {
        return $this->helper->getApiClient()->query(array('query' => $query));
    }

}
