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
     * Number of triples that are parsed and inserted at once.
     *
     * @var integer
     */
    const PARSING_SIZE = 100000;

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
     * Error messages that are gathered during the benchmark run,
     * grouped by benchmark.
     *
     * @var array(string=>array(string))
     */
    protected $errors = array();

    /**
     * Size of the used data set in percent [1..100].
     *
     * @var integer
     */
    protected $sizeInPercent = 100;

    /**
     * Determines if errors during the benchmark are displayed.
     *
     * @var boolean
     */
    protected $displayErrors = true;

    /**
     * The name of the current benchmark.
     *
     * @var string
     */
    protected $currentBenchmark = 'undefined';

    /**
     * Clears the DBpedia graph before the benchmark is started.
     */
    protected function classSetUp()
    {
        parent::classSetUp();
        $this->connector->deleteMatchingTriples('http://dbpedia.org', new Erfurt_Store_Adapter_Sparql_TriplePattern());
    }

    /**
     * Shows error information that has been gathered.
     */
    protected function classTearDown()
    {
        if ($this->displayErrors) {
            echo $this->createErrorReport();
        }
        parent::classTearDown();
    }

    /**
     * Loads the data set that is used in the benchmark.
     *
     * @Iterations 1
     */
    public function loadDataSet()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->loadData($this->sizeInPercent);
    }

    /**
     * Uses the auxiliary queries to find variable assignments for the test queries.
     *
     * @Iterations 1
     */
    public function prepareQueryVars()
    {
        $this->enterBenchmark(__FUNCTION__);
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
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function distinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - FILTER
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function filterQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('filter');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function optionalQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('optional');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('union');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - DISTINCT
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionDistinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('union,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - FILTER
     * - DISTINCT
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function filterDistinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('filter,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     * - DISTINCT
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function optionalDistinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('optional,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - FILTER
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionFilterQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('union,filter');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - OPTIONAL
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionOptionalQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('union,optional');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     * - FILTER
     * - DISTINCT
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function optionalFilterDistinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('optional,filter,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - OPTIONAL
     * - DISTINCT
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionOptionalDistinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('union,optional,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - FILTER
     * - LANG
     * - DISTINCT
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function filterLangDistinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('filter,lang,distinct');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - UNION
     * - FILTER
     * - LANG
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionFilterLangQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('union,filter,lang');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - OPTIONAL
     * - FILTER
     * - LANG
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function optionalFilterLangQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
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
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function filterRegexDistinctStrQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
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
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function optionalFilterLangDistinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
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
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionFilterLangDistinctQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
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
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionFilterLangStrQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
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
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionFilterRegexStrQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
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
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function unionOptionalFilterLangQuery()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('union,optional,filter,lang');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 1 Triple Pattern
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function triplePatterns1Query()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('1-TriplePatterns');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 2 Triple Patterns
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function triplePatterns2Query()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('2-TriplePatterns');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 3 Triple Patterns
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function triplePatterns3Query()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('3-TriplePatterns');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 4 Triple Patterns
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function triplePatterns4Query()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('4-TriplePatterns');
    }

    /**
     * Benchmarks queries that use the following features:
     *
     * - 5 Triple Patterns
     *
     * @Iterations 2000
     * @MaxRuntime 300
     */
    public function triplePatterns5Query()
    {
        $this->enterBenchmark(__FUNCTION__);
        $this->executeOneQuery('5-TriplePatterns');
    }

    /**
     * Executes a query mix, which means that one query of each type is executed.
     *
     * @Iterations 1000
     * @MaxRuntime 600
     */
    public function queryMix()
    {
        foreach ($this->getQueryTypes() as $type) {
            /* @var $type string */
            $this->executeOneQuery($type);
        }
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
    protected function loadData($sizeInPercent)
    {
        $dataFile   = fopen($this->getBenchmarkDataFile(), 'r');
        $linesToAdd = array();
        while (($line = fgets($dataFile)) !== false) {
            if ($this->faker->boolean($sizeInPercent)) {
                // This triple will be included in the data set that is used in the benchmark.
                $linesToAdd[] = $line;
                if (count($linesToAdd) >= static::PARSING_SIZE) {
                    $this->saveTriples($linesToAdd);
                    $linesToAdd = array();
                }
            }
        }
        $this->saveTriples($linesToAdd);
    }

    /**
     * Adds a message that is shown when the benchmark finishes.
     *
     * @param string $message
     */
    protected function addError($message)
    {
        if (!isset($this->errors[$this->currentBenchmark])) {
            $this->errors[$this->currentBenchmark] = array();
        }
        $this->errors[$this->currentBenchmark][] = $message;
    }

    /**
     * Creates a formatted representation of the errors.
     *
     * @return string
     */
    protected function createErrorReport()
    {
        $report = $this->createLine()
                . 'Errors (sum): ' . array_sum(array_map('count', $this->errors)) . PHP_EOL
                . $this->createLine()
                . $this->createLine()
                . 'Overview' . PHP_EOL;
        foreach ($this->errors as $benchmark => $errors) {
            /* @var $benchmark string */
            /* @var $errors array(string) */
            $report .= $benchmark . ': ' . count($errors) . PHP_EOL;
        }
        $report .= $this->createLine();
        $report .= $this->createLine();
        $report .= 'Details' . PHP_EOL;
        $report .= $this->createLine();
        foreach ($this->errors as $benchmark => $errors) {
            /* @var $benchmark string */
            /* @var $errors array(string) */
            $report .= $benchmark . ': ' . PHP_EOL;
            $report .= implode(PHP_EOL, $this->errors[$benchmark]) . PHP_EOL;
            $report .= $this->createLine();
        }
        return $report;
    }

    /**
     * Creates a dashed line that can be used as console output.
     *
     * @return string
     */
    protected function createLine()
    {
        return str_repeat('-', 80) . PHP_EOL;
    }

    /**
     * Returns a list of query types.
     *
     * @return array(string)
     */
    protected function getQueryTypes()
    {
        return array_keys($this->getQueries());
    }

    /**
     * Executes one SPARQL query of the specified type.
     *
     * @param string $label
     */
    protected function executeOneQuery($label)
    {
        $query = $this->createQuery($label);
        try {
            $this->connector->query($query);
        } catch (\Exception $e) {
            $this->addError('Error while executing query of type "' . $label . '": ' . PHP_EOL . $e);
        }
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
        if (count($this->variableAssignmentsByLabel[$label]) === 0) {
            $assignment = $this->createDefaultAssignmentFor($label);
        } else {
            /* @var $assignment array */
            $assignment = $this->faker->randomElement($this->variableAssignmentsByLabel[$label]);
        }
        foreach ($assignment as $varName => $value) {
            $query = str_replace('%%' . $varName . '%%', $value, $query);
        }
        return $query;
    }

    /**
     * Creates a default variable assignment for the a query of the provided type.
     *
     * This is useful if it was not possible to extract assignments
     * from the available data.
     *
     * @param string $label
     * @return array(string=>string)
     */
    protected function createDefaultAssignmentFor($label)
    {
        $queries = $this->getQueries();
        return $queries[$label]['default_assignment'];
    }

    /**
     * Marks the given benchmark as running.
     *
     * @param string $name
     */
    protected function enterBenchmark($name)
    {
        $this->currentBenchmark = $name;
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
        $messages = $this->connector->batch(function ($connector) use($statements) {
            /* @var $connector \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface */
            $messages = array();
            foreach (new Erfurt_Store_Adapter_Sparql_TripleIterator($statements) as $triple) {
                /* @var $triple Erfurt_Store_Adapter_Sparql_Triple */
                try {
                    $connector->addTriple('http://dbpedia.org', $triple);
                } catch(Exception $e) {
                    $messages[] = (string)$e;
                }
            }
            return $messages;
        });
        foreach ($messages as $message) {
            $this->addError($message);
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
            $this->queryData = require(__DIR__ . '/_files/DBpedia/queries.php');
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
        $path = __DIR__ . '/_files/DBpedia/data/benchmark_data.nt';
        if (!is_file($path)) {
            $message = 'File "' . $path . '" does not exist. It must contain benchmark data in n-triples format.';
            throw new \RuntimeException($message);
        }
        return $path;
    }

}
