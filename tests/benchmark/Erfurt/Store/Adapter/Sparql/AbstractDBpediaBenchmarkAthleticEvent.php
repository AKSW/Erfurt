<?php

/**
 * Executes the DBpedia benchmark.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 30.04.14
 * @see http://aksw.org/Projects/DBPSB.html
 */
abstract class Erfurt_Store_Adapter_Sparql_AbstractDBpediaBenchmarkAthleticEvent
    extends Erfurt_Store_Adapter_Sparql_AbstractConnectorAthleticEvent
{

    /**
     * Loads the data set that is used in the benchmark.
     *
     * @Iterations 1
     */
    public function loadDataSet()
    {

    }

    /**
     * Returns the path to the file that contains the benchmark data.
     *
     * @return string
     * @throws \RuntimeException If the file does not exist.
     */
    protected function getBenchmarkDataFile()
    {
        $path = __DIR__ . '/DBpedia/data/benchmark_data.nt';
        if (!is_file($path)) {
            $message = 'File "' . $path . '" does not exist. It must contain benchmark data in n-triples format.';
            throw new \RuntimeException($message);
        }
        return $path;
    }

}
