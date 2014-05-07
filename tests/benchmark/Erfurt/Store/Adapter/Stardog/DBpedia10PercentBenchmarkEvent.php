<?php

/**
 * See {@link \Erfurt_Store_Adapter_Sparql_AbstractDBpediaBenchmarkAthleticEvent} for details.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 30.04.14
 */
class Erfurt_Store_Adapter_Stardog_DBpedia10PercentBenchmarkEvent
    extends Erfurt_Store_Adapter_Sparql_AbstractDBpediaBenchmarkAthleticEvent
{

    /**
     * Creates the benchmark event.
     */
    public function __construct()
    {
        parent::__construct(10);
    }

}
