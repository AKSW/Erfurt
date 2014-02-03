<?php

use Faker\Generator;

/**
 * Tests the performance of the SPARQL connector when loading large literals.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.02.14
 */
class Erfurt_Store_Adapter_Oracle_LoadLargeRowsEvent extends Erfurt_Store_Adapter_Oracle_AbstractConnectorAthleticEvent
{
    /**
     * The number of triples that are used in the benchmark.
     */
    const NUMBER_OF_TRIPLES = 100;

    /**
     * Adds test data to the store.
     *
     * @param \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector
     * @param Generator $faker
     */
    public function populateStore(\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector, Generator $faker)
    {
        for ($i = 0; $i < static::NUMBER_OF_TRIPLES; $i++) {
            $triple = new Erfurt_Store_Adapter_Sparql_Triple(
                'http://example.org/person/' . $faker->uuid,
                'http://example.org/action/has-written',
                // Add a text with more than 4000 byte.
                array(
                    'type'  => 'literal',
                    'value' => $faker->text(4200)
                )
            );
            $connector->addTriple('http://example.org/text', $triple);
        }
    }

    /**
     * Executes a query that loads 10 rows from the store.
     *
     * @Iterations 200
     */
    public function load10Rows()
    {
        $this->load(10);
    }

    /**
     * Executes a query that loads 50 rows from the store.
     *
     * @Iterations 200
     */
    public function load50Rows()
    {
        $this->load(50);
    }

    /**
     * Executes a query that loads 100 rows from the store.
     *
     * @Iterations 200
     */
    public function load100Rows()
    {
        $this->load(100);
    }

    /**
     * Queries $limit rows from the store.
     *
     * @param integer $limit
     */
    protected function load($limit)
    {
        $query = 'SELECT ?person ?text '
               . 'FROM <http://example.org/text> '
               . 'WHERE { '
               . '    ?person <http://example.org/action/has-written> ?text . '
               . '} '
               . 'LIMIT ' . $limit;
        $this->connector->query($query);
    }

}
