<?php

/**
 * See {@link \Erfurt_Store_Adapter_Sparql_AbstractDBpediaBenchmarkAthleticEvent} for details.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 19.05.14
 */
class Erfurt_Store_Adapter_Neo4J_DBpedia25PercentBenchmarkEvent
    extends Erfurt_Store_Adapter_Sparql_AbstractDBpediaBenchmarkAthleticEvent
{

    /**
     * Size of the used data set in percent [1..100].
     *
     * @var integer
     */
    protected $sizeInPercent = 25;

}
