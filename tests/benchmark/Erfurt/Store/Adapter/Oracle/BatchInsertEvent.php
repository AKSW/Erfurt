<?php

/**
 * Tests the performance when grouping addTriple() calls as a batch job to populate the store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.02.14
 */
class Erfurt_Store_Adapter_Oracle_BatchInsertEvent extends Erfurt_Store_Adapter_Oracle_AbstractConnectorAthleticEvent
{

    /**
     * Inserts 1000 triples in a batch.
     *
     * @Iterations 1
     */
    public function testInsert1000Triples()
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
