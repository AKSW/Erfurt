<?php

/**
 * Tests the performance of adding triples to a store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.02.14
 */
abstract class Erfurt_Store_Adapter_Sparql_AbstractAddTriplesAthleticEvent
    extends Erfurt_Store_Adapter_Sparql_AbstractConnectorAthleticEvent
{

    /**
     * Removes the triples from the store to ensure that each iteration
     * starts with an empty graph.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->connector->deleteMatchingTriples(
            'http://example.org/performance',
            new Erfurt_Store_Adapter_Sparql_TriplePattern()
        );
    }

    /**
     * Inserts 1000 triples via independent addTriple() calls.
     *
     * @Iterations 20
     */
    public function testInsert1000TriplesViaSingleInsert()
    {
        for ($i = 0; $i < 1000; $i++) {
            $triple = new Erfurt_Store_Adapter_Sparql_Triple(
                $this->faker->url . '/subject',
                $this->faker->url . '/predicate',
                array(
                    'type'  => 'uri',
                    'value' => $this->faker->url . '/object'
                )
            );
            $this->connector->addTriple('http://example.org/performance', $triple);
        }
    }

    /**
     * Inserts 1000 triples in 10 batches, 100 triples each.
     *
     * @Iterations 20
     */
    public function testInsert1000TriplesInChunksOf100()
    {
        $faker = $this->faker;
        $insert100Triples = function (\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector) use ($faker) {
            for ($i = 0; $i < 100; $i++) {
                $triple = new Erfurt_Store_Adapter_Sparql_Triple(
                    $faker->url . '/subject',
                    $faker->url . '/predicate',
                    array(
                        'type'  => 'uri',
                        'value' => $faker->url . '/object'
                    )
                );
                $connector->addTriple('http://example.org/performance', $triple);
            }
        };
        for ($i = 0; $i < 10; $i++) {
            $this->connector->batch($insert100Triples);
        }
    }

    /**
     * Inserts 1000 triples in a batch.
     *
     * @Iterations 20
     */
    public function testInsert1000TriplesAsBatch()
    {
        $faker = $this->faker;
        $this->connector->batch(function (\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector) use ($faker) {
            for ($i = 0; $i < 1000; $i++) {
                $triple = new Erfurt_Store_Adapter_Sparql_Triple(
                    $faker->url . '/subject',
                    $faker->url . '/predicate',
                    array(
                        'type'  => 'uri',
                        'value' => $faker->url . '/object'
                    )
                );
                $connector->addTriple('http://example.org/performance', $triple);
            }
        });
    }

}
