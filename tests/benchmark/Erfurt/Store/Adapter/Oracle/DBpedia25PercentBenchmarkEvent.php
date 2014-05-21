<?php

/**
 * See {@link \Erfurt_Store_Adapter_Sparql_AbstractDBpediaBenchmarkAthleticEvent} for details.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 21.05.14
 */
class Erfurt_Store_Adapter_Oracle_DBpedia25PercentBenchmarkEvent
    extends Erfurt_Store_Adapter_Sparql_AbstractDBpediaBenchmarkAthleticEvent
{

    /**
     * Size of the used data set in percent [1..100].
     *
     * @var integer
     */
    protected $sizeInPercent = 25;

    /**
     * Defines the level of error reporting.
     *
     * Valid values are the ERROR_REPORTING_* constants.
     *
     * @var integer
     */
    protected $errorReporting = self::ERROR_REPORTING_OVERVIEW;

}
