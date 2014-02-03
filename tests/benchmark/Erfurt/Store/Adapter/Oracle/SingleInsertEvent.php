<?php

/**
 * Tests the performance when using independent addTriple() calls to populate the store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.02.14
 */
class Erfurt_Store_Adapter_Oracle_SingleInsertEvent extends Erfurt_Store_Adapter_Oracle_AbstractConnectorAthleticEvent
{

    /**
     * Inserts 1000 triples via independent addTriple() calls.
     *
     * @Iterations 1
     */
    public function testInsert1000Triples()
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

}
