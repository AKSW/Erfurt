<?php

use Faker\Generator;

/**
 * Tests the performance of SELECT queries with REGEX filters.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 05.02.14
 */
class Erfurt_Store_Adapter_Oracle_RegexFilterEvent extends Erfurt_Store_Adapter_Oracle_AbstractConnectorAthleticEvent
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
     * Executes a SPARQL query with 1 REGEX filter.
     *
     * @Iterations 20
     */
    public function queryWith1RegexFilter()
    {
        $this->query(1);
    }

    /**
     * Executes a SPARQL query with 2 REGEX filters.
     *
     * @Iterations 20
     */
    public function queryWith2RegexFilters()
    {
        $this->query(2);
    }

    /**
     * Executes a SPARQL query with 4 REGEX filters.
     *
     * @Iterations 20
     */
    public function queryWith4RegexFilters()
    {
        $this->query(4);
    }

    /**
     * Executes a SPARQL query with 6 REGEX filters.
     *
     * @Iterations 20
     */
    public function queryWith6RegexFilters()
    {
        $this->query(6);
    }

    /**
     * Executes a SPARQL query that uses the provided number of REGEX filters.
     *
     * @param integer $numberOfFilters
     */
    protected function query($numberOfFilters)
    {
        $query = $this->createQuery($numberOfFilters);
        $this->connector->query($query);
    }

    /**
     * Creates a SPARQL query that has the provided number of REGEX filters.
     *
     * @param integer $numberOfFilters
     * @return string
     */
    protected function createQuery($numberOfFilters)
    {
        $query = 'SELECT DISTINCT ?resourceUri '
               . 'FROM <http://example.org/performance> '
               . 'WHERE { '
               . '    ?subject <http://xmlns.com/foaf/0.1/name> ?resourceUri . '
               . '    %s'
               . '} ';
        $filters = array();
        for ($i = 0; $i < $numberOfFilters; $i++) {
            $filters[] = sprintf('FILTER (!REGEX(STR(?resourceUri), "^%s"))', $this->faker->url);
        }
        return sprintf($query, implode(PHP_EOL, $filters));
    }

}
