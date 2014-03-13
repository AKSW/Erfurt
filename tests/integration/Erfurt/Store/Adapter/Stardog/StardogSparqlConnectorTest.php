<?php

/**
 * Tests the Stardog SPARQL connector.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 02.03.14
 * @group Stardog
 */
class Erfurt_Store_Adapter_Stardog_StardogSparqlConnectorTest
    extends \Erfurt_Store_Adapter_Sparql_AbstractSparqlConnectorTestCase
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
        $this->helper = new Erfurt_StardogTestHelper();
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
     * Checks if deleteMatchingTriples() is able to delete a triple whose literal looks like the subject URI.
     *
     * Tests have shown that deletion failed if a (literal) object value equals the subject or predicate URI
     * of the triple.
     */
    public function testDeleteMatchingTriplesRemovesTripleWithObjectLiteralThatLooksLikeSubjectUri()
    {
        $triple = new Erfurt_Store_Adapter_Sparql_Triple(
            'http://example.org/renameTest/old',
            'http://example.org/renameTest/p2',
            array(
                'type'  => 'literal',
                'value' => 'http://example.org/renameTest/old'
            )
        );
        $this->insertTriple(
            $triple->getSubject(),
            $triple->getPredicate(),
            $triple->getObject(),
            'http://example.org/renameTest/'
        );

        $this->connector->deleteMatchingTriples('http://example.org/renameTest/', $triple);

        $this->assertEquals(0, $this->countTriples());
    }

    /**
     * Creates the SPARQL connector that will be tested.
     *
     * @return \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
     */
    protected function createConnector()
    {
        return $this->helper->getSparqlConnector();
    }

    /**
     * Counts the number of triples in the store.
     *
     * @return integer
     */
    protected function countTriples()
    {
        return $this->helper->getApiClient()->size();
    }


}
