<?php

use Athletic\AthleticEvent;

/**
 * Checks the performance when loading many (small) rows via SPARQL connector.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 02.02.14
 */
class Erfurt_Store_Adapter_Oracle_LoadLargeResultSetEvent extends AthleticEvent
{

    /**
     * The number of triples that will be loaded.
     */
    const NUMBER_OF_TRIPLES = 1000;

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Oracle_OracleSparqlConnector
     */
    protected $connector = null;

    /**
     * Test helper that is used to set up the environment.
     *
     * @var \Erfurt_OracleTestHelper
     */
    protected $helper = null;

    /**
     * Sets up the environment.
     */
    protected function classSetUp()
    {
        $this->helper = new \Erfurt_OracleTestHelper();
        $this->helper->installTripleStore();
        $this->connector = new Erfurt_Store_Adapter_Oracle_OracleSparqlConnector($this->helper->getConnection());
        $this->populateStore();
    }

    /**
     * Cleans up the environment.
     */
    protected function classTearDown()
    {
        $this->connector = null;
        $this->helper->cleanUp();
    }

    /**
     * Populates the store with triples.
     */
    protected function populateStore()
    {
        $faker = \Faker\Factory::create('en');
        $faker->seed(static::NUMBER_OF_TRIPLES);
        $this->connector->batch(function (\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector) use ($faker) {
            for ($i = 0; $i < Erfurt_Store_Adapter_Oracle_LoadLargeResultSetEvent::NUMBER_OF_TRIPLES; $i++) {
                $triple = new Erfurt_Store_Adapter_Sparql_Triple(
                    'http://example.org/person/' . $faker->uuid,
                    'http://xmlns.com/foaf/0.1/name',
                    array(
                        'type'  => 'literal',
                        'value' => $faker->name
                    )
                );
                $connector->addTriple('http://example.org/performance', $triple);
            }
        });
    }

    /**
     * Executes a query that loads the whole store data.
     *
     * @Iterations 200
     */
    public function queryManySmallRows()
    {
        $query = 'SELECT ?person ?name '
               . 'FROM <http://example.org/performance> '
               . 'WHERE { '
               . '    ?person <http://xmlns.com/foaf/0.1/name> ?name'
               . '}'
               . 'LIMIT ' . static::NUMBER_OF_TRIPLES;
        $this->connector->query($query);
    }

}
