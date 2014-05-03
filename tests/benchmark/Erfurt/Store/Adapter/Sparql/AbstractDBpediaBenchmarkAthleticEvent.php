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
     * Contains variable assignments for the test queries.
     *
     * @var array(string=>array)
     */
    protected $variableAssignmentsByLabel = array();

    /**
     * Clears the DBpedia graph before the benchmark is started.
     */
    protected function classSetUp()
    {
        parent::classSetUp();
//        $this->connector->deleteMatchingTriples('http://dbpedia.org', new Erfurt_Store_Adapter_Sparql_TriplePattern());
    }

    /**
     * Loads the data set that is used in the benchmark.
     *
     * @Iterations 1
     */
//    public function loadDataSet()
//    {
//        $benchmark = $this;
//        $this->connector->batch(function () use ($benchmark) {
//            $benchmark->loadData(100);
//        });
//    }

    /**
     * Uses the auxiliary queries to find variable assignments for the test queries.
     *
     * @Iterations 1
     */
    public function prepareQueryVars()
    {
        foreach ($this->getQueries() as $label => $queryData) {
            /* @var $label string */
            /* @var $queryData array(string=>string) */
            $query = $queryData['auxiliary_query'];
            $result = $this->connector->query($query);
            $this->variableAssignmentsByLabel[$label] = $this->extractAssignments($result);
        }
    }

    public function distinctQuery()
    {
        // distinct
    }

    public function filterQuery()
    {
        // filter
    }

    public function optionalQuery()
    {
        // optional
    }

    public function unionQuery()
    {
        // union
    }

    public function unionDistinctQuery()
    {
        // union,distinct
    }

    public function filterDistinctQuery()
    {
        // filter,distinct
    }

    public function optionalDistinctQuery()
    {
        // optional,distinct
    }

    public function unionFilterQuery()
    {
        // union,filter
    }

    public function unionOptionalQuery()
    {
        // union,optional
    }

    public function optionalFilterDistinctQuery()
    {
        // optional,filter,distinct
    }

    public function unionOptionalDistinctQuery()
    {
        // optional,filter,distinc
    }

    public function filterLangDistinctQuery()
    {
        // optional,filter,distinc
    }

    public function unionFilterLangQuery()
    {
        // optional,filter,distinc
    }

    public function optionalFilterLangQuery()
    {
        // optional,filter,distinc
    }

    public function filterRegexDistinctStrQuery()
    {
        // optional,filter,distinc
    }

    public function optionalFilterLangDistinctQuery()
    {
        // optional,filter,distinc
    }

    public function unionFilterLangDistinctQuery()
    {
        // optional,filter,distinc
    }

    public function unionFilterLangStrQuery()
    {
        // optional,filter,distinc
    }

    public function unionFilterRegexStrQuery()
    {
        // optional,filter,distinc
    }

    public function unionOptionalFilterLangQuery()
    {
        // optional,filter,distinc
    }

    public function triplePatterns1Query()
    {
        // 1-TriplePatterns
    }

    public function triplePatterns2Query()
    {
        // 2-TriplePatterns
    }

    public function triplePatterns3Query()
    {
        // 3-TriplePatterns
    }

    public function triplePatterns4Query()
    {
        // 4-TriplePatterns
    }

    public function triplePatterns5Query()
    {
        // 5-TriplePatterns
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
     * Accepts the result of an auxiliary query in extended format and
     * generates a list variable assignments.
     *
     * @param array(mixed) $result
     * @return array(array(string=>string))
     */
    protected function extractAssignments($result)
    {
        $assignments = array();
        foreach ($result['results']['bindings'] as $binding) {
            /* @var array(string=>array(string=>mixed)) */
            $assignment = array();
            foreach ($binding as $varName => $spec) {
                /* @var $varName string */
                /* @var $spec array(string=>mixed) */
                $assignment[$varName] = $this->toRdfTerm($spec);
            }
            $assignments[] = $assignment;
        }
        return $assignments;
    }

    /**
     * Creates the RDF term for the provided value specification.
     *
     * @param array(string=>mixed) $valueSpec
     * @return string
     */
    protected function toRdfTerm(array $valueSpec)
    {
        if ($valueSpec['type'] === 'uri') {
            return '<' . $valueSpec['value'] . '>';
        }
        $type = (isset($valueSpec['datatype'])) ? $valueSpec['datatype'] : null;
        $lang = (isset($valueSpec['lang'])) ? $valueSpec['lang'] : null;
        return Erfurt_Utils::buildLiteralString($valueSpec['value'], $type, $lang);
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
            try {
                $this->connector->addTriple('http://dbpedia.org', $triple);
            } catch(Exception $e) {
                echo $e . PHP_EOL;
            }
        }
    }

    /**
     * Returns the test queries.
     *
     * @return array(array(string=>string))
     */
    protected function getQueries()
    {
        return require(__DIR__ . '/DBpedia/queries.php');
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
