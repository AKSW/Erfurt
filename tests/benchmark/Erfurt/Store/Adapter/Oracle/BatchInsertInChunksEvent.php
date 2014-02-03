<?php

/**
 * Tests the performance when using several batch jobs to insert triples.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.02.14
 */
class Erfurt_Store_Adapter_Oracle_BatchInsertInChunksEvent extends Erfurt_Store_Adapter_Oracle_AbstractConnectorAthleticEvent
{

    /**
     * Inserts 1000 triples in 10 batches, 100 triples each.
     *
     * @Iterations 1
     */
    public function testInsert1000Triples()
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

}
