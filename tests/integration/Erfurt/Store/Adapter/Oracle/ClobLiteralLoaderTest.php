<?php

/**
 * Tests the loader for large literals.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.02.14
 * @group Oracle
 */
class Erfurt_Store_Adapter_Oracle_ClobLiteralLoaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Oracle_ClobLiteralLoader
     */
    protected $loader = null;

    /**
     * Test helper that is used to set up the environment.
     *
     * @var \Erfurt_OracleTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper = new \Erfurt_OracleTestHelper();
        $this->helper->installTripleStore();
        $this->loader = new Erfurt_Store_Adapter_Oracle_ClobLiteralLoader($this->helper->getConnection());
        $this->insertLargeTriple();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->loader = null;
        $this->helper->cleanUp();
        parent::tearDown();
    }

    /**
     * Ensures that load() returns null if the requested literal data does not exist.
     */
    public function testLoadReturnsNullIfDataDoesNotExist()
    {
        $id = $this->getTripleLiteralId();

        $this->assertNull($this->loader->load($id + 42));
    }

    /**
     * Checks if load() returns the correct data.
     */
    public function testLoadReturnsCorrectValue()
    {
        $id = $this->getTripleLiteralId();

        $value = $this->loader->load($id);

        $this->assertInternalType('string', $value);
        $this->assertEquals(str_repeat('x', 4200), $value);
    }

    /**
     * Returns the value ID of the literal.
     *
     * @return integer
     */
    protected function getTripleLiteralId()
    {
        // The triple type can be used to determine the value ID of the object.
        $query = 'SELECT d.triple.RDF_O_ID AS "id" FROM erfurt_semantic_data d';
        $statement = $this->helper->getConnection()->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->assertCount(1, $results);
        return $results[0]['id'];
    }

    /**
     * Inserts a triple with large literal value.
     */
    protected function insertLargeTriple()
    {
        $triple = new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/test',
            'http://example.org/is-large',
            array(
                'type'  => 'literal',
                'value' => str_repeat('x', 4200)
            )
        );
        $this->helper->getSparqlConnector()->addTriple('http://example.org', $triple);
    }

}
