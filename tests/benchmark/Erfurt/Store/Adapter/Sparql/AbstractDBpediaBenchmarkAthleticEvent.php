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
     * The cached query definitions.
     *
     * @var array(string=>array(string=>string))|null
     */
    protected $queryData = null;

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

    /**
     * Benchmarks queries that use the following features:
     *
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function distinctQuery()
    {
        $this->executeOneQuery('distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - FILTER
     *
     * @Iterations 20
     */
    public function filterQuery()
    {
        $this->executeOneQuery('filter');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     *
     * @Iterations 20
     */
    public function optionalQuery()
    {
        $this->executeOneQuery('optional');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     *
     * @Iterations 20
     */
    public function unionQuery()
    {
        $this->executeOneQuery('union');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function unionDistinctQuery()
    {
        $this->executeOneQuery('union,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - FILTER
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function filterDistinctQuery()
    {
        $this->executeOneQuery('filter,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function optionalDistinctQuery()
    {
        $this->executeOneQuery('optional,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - FILTER
     *
     * @Iterations 20
     */
    public function unionFilterQuery()
    {
        $this->executeOneQuery('union,filter');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - OPTIONAL
     *
     * @Iterations 20
     */
    public function unionOptionalQuery()
    {
        $this->executeOneQuery('union,optional');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     * - FILTER
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function optionalFilterDistinctQuery()
    {
        $this->executeOneQuery('optional,filter,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - OPTIONAL
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function unionOptionalDistinctQuery()
    {
        $this->executeOneQuery('union,optional,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - FILTER
     * - LANG
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function filterLangDistinctQuery()
    {
        $this->executeOneQuery('filter,lang,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - FILTER
     * - LANG
     *
     * @Iterations 20
     */
    public function unionFilterLangQuery()
    {
        $this->executeOneQuery('union,filter,lang');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     * - FILTER
     * - LANG
     *
     * @Iterations 20
     */
    public function optionalFilterLangQuery()
    {
        $this->executeOneQuery('optional,filter,lang');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - FILTER
     * - REGEX
     * - DISTINCT
     * - STR
     *
     * @Iterations 20
     */
    public function filterRegexDistinctStrQuery()
    {
        $this->executeOneQuery('filter,regex,distinct,str');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     * - FILTER
     * - LANG
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function optionalFilterLangDistinctQuery()
    {
        $this->executeOneQuery('optional,filter,lang,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - FILTER
     * - LANG
     * - DISTINCT
     *
     * @Iterations 20
     */
    public function unionFilterLangDistinctQuery()
    {
        $this->executeOneQuery('union,filter,lang,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - FILTER
     * - LANG
     * - STR
     *
     * @Iterations 20
     */
    public function unionFilterLangStrQuery()
    {
        $this->executeOneQuery('union,filter,lang,str');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - FILTER
     * - REGEX
     * - STR
     *
     * @Iterations 20
     */
    public function unionFilterRegexStrQuery()
    {
        $this->executeOneQuery('union,filter,regex,str');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - OPTIONAL
     * - FILTER
     * - LANG
     *
     * @Iterations 20
     */
    public function unionOptionalFilterLangQuery()
    {
        $this->executeOneQuery('union,optional,filter,lang');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 1 Triple Pattern
     *
     * @Iterations 20
     */
    public function triplePatterns1Query()
    {
        $this->executeOneQuery('1-TriplePatterns');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 2 Triple Patterns
     *
     * @Iterations 20
     */
    public function triplePatterns2Query()
    {
        $this->executeOneQuery('2-TriplePatterns');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 3 Triple Patterns
     *
     * @Iterations 20
     */
    public function triplePatterns3Query()
    {
        $this->executeOneQuery('3-TriplePatterns');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 4 Triple Patterns
     *
     * @Iterations 20
     */
    public function triplePatterns4Query()
    {
        $this->executeOneQuery('4-TriplePatterns');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 5 Triple Patterns
     *
     * @Iterations 20
     */
    public function triplePatterns5Query()
    {
        $this->executeOneQuery('5-TriplePatterns');
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
     * Executes one SPARQL query of the specified type.
     *
     * @param string $label
     */
    protected function executeOneQuery($label)
    {
        $query = $this->createQuery($label);
        $this->connector->query($query);
    }

    /**
     * Creates a SPARQL query of the provided type.
     *
     * Automatically substitutes variable parts.
     *
     * @param string $label
     * @return string
     * @throws \RuntimeException If no such query exists.
     */
    protected function createQuery($label)
    {
        $queries = $this->getQueries();
        if (!isset($queries[$label])) {
            $message = 'Query of type "' . $label . '" is not configured.';
            throw new \RuntimeException($message);
        }
        $query = $queries[$label]['query'];
        /* @var $assignment array */
        $assignment = $this->faker->randomElement($this->variableAssignmentsByLabel[$label]);
        foreach ($assignment as $varName => $value) {
            $query = str_replace('%%' . $varName . '%%', $value, $query);
        }
        return $query;
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
        if ($this->queryData === null) {
            $this->queryData = require(__DIR__ . '/DBpedia/queries.php');
        }
        return $this->queryData;
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
