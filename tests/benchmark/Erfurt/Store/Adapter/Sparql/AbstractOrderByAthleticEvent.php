<?php

use Faker\Generator;

/**
 * Tests the performance of SPARQL queries that require ordered results.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.02.14
 */
abstract class Erfurt_Store_Adapter_Sparql_AbstractOrderByAthleticEvent
    extends Erfurt_Store_Adapter_Sparql_AbstractConnectorAthleticEvent
{

    /**
     * The number of triples that will be loaded.
     */
    const NUMBER_OF_TRIPLES = 1000;

    /**
     * Populates the store with triples.
     *
     * @param \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector
     * @param \Faker\Generator $faker
     */
    public function populateStore(\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector, Generator $faker)
    {
        for ($i = 0; $i < static::NUMBER_OF_TRIPLES; $i++) {
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
    }

    /**
     * Retrieves the result set in any order.
     *
     * @Iterations 100
     */
    public function notSorted()
    {
        $this->query();
    }

    /**
     * Retrieves the result set that is sorted in ascending order by object.
     *
     * @Iterations 100
     */
    public function orderedAscendingByObject()
    {
        $this->query('ORDER BY ASC(?object)');
    }

    /**
     * Retrieves the result set that is sorted in descending order by object.
     *
     * @Iterations 100
     */
    public function orderedDescendingByObject()
    {
        $this->query('ORDER BY DESC(?object)');
    }

    /**
     * Retrieves the result set that is sorted in ascending order by subject.
     *
     * @Iterations 100
     */
    public function orderedAscendingBySubject()
    {
        $this->query('ORDER BY ASC(?subject)');
    }

    /**
     * Retrieves the result set that is sorted in descending order by subject.
     *
     * @Iterations 100
     */
    public function orderedDescendingBySubject()
    {
        $this->query('ORDER BY DESC(?subject)');
    }

    /**
     * Executes a query that uses the provided ORDER clause.
     *
     * @param string|null $orderClause
     */
    protected function query($orderClause = null)
    {
        $query = 'SELECT * '
               . 'FROM <http://example.org/performance> '
               . 'WHERE { '
               . '    ?subject ?predicate ?object . '
               . '} '
               . $orderClause;
        $this->connector->query($query);
    }

}
