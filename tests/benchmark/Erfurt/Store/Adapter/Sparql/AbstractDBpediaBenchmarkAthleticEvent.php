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
     * Clears the DBpedia graph before the benchmark is started.
     */
    protected function classSetUp()
    {
        parent::classSetUp();
        $this->connector->deleteMatchingTriples('http://dbpedia.org', new Erfurt_Store_Adapter_Sparql_TriplePattern());
    }


    /**
     * Loads the data set that is used in the benchmark.
     *
     * @Iterations 1
     */
    public function loadDataSet()
    {
        $benchmark = $this;
        $this->connector->batch(function () use ($benchmark) {
            $benchmark->loadData(100);
        });
    }

    /**
     * Loads the benchmark data (or a subset of it).
     *
     * If $sizeInPercent is lower that 100, then only that percentage of the data is
     * loaded. Which triples are loaded is decided by random (this is still deterministic,
     * as the random generator is seeded).
     *
     * @param integer $sizeInPercent Value between 1 and 100.
     */
    public function loadData($sizeInPercent)
    {

        $dataFile   = fopen($this->getBenchmarkDataFile(), 'r');
        $linesToAdd = array();
        while (($line = fgets($dataFile)) !== false) {
            if ($this->faker->boolean($sizeInPercent)) {
                // This triple will be included in the data set that is used in the benchmark.
                $linesToAdd[] = $line;
                if (count($linesToAdd) >= 100) {
                    $this->saveTriples($linesToAdd);
                    $linesToAdd = array();
                }
            }
        }
        $this->saveTriples($linesToAdd);
    }

    /**
     * Saves the triples that are encoded in the provided lines (in n-triples syntax).
     *
     * @param array(string) $lines
     */
    protected function saveTriples(array $lines)
    {
        $parser     = new Erfurt_Syntax_RdfParser_Adapter_Turtle();
        $data       = implode(PHP_EOL, $lines);
        $statements = $parser->parseFromDataString($data);
        foreach (new Erfurt_Store_Adapter_Sparql_TripleIterator($statements) as $triple) {
            /* @var $triple Erfurt_Store_Adapter_Sparql_Triple */
            $this->connector->addTriple('http://dbpedia.org', $triple);
        }
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
