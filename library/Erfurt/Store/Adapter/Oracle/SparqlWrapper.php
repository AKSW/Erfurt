<?php

/**
 * Creates SQL that is used to retrieve the results of a SPARQL query
 * from the Oracle database.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.02.14
 */
class Erfurt_Store_Adapter_Oracle_SparqlWrapper
{

    /**
     * The minimal number of filter expressions that a SPARQL query must
     * contain to trigger the activation of the SQL query parallelization.
     */
    const MIN_NUMBER_OF_CONSTRAINTS_FOR_PARALLELIZATION = 5;

    /**
     * The parser that is used for SPARQL query analysis.
     *
     * @var \Erfurt_Sparql_Parser;
     */
    protected $parser = null;

    /**
     * The callback that is used to quote values.
     *
     * @var callable
     */
    protected $valueQuoter = null;

    /**
     * The name of the model that is queried.
     *
     * @var string
     */
    protected $modelName = null;

    /**
     * Creates a wrapper that selects data from the provided model.
     *
     * Uses $valueQuoter to escape values in the generated SQL queries.
     *
     * @param string $modelName
     * @param callable $valueQuoter
     * @throws \InvalidArgumentException If no valid callback is passed.
     */
    public function __construct($modelName, $valueQuoter)
    {
        if (!is_callable($valueQuoter)) {
            $message = '$valueQuoter must be a valid callback.';
            throw new \InvalidArgumentException($message);
        }
        $this->parser      = new Erfurt_Sparql_Parser();
        $this->modelName   = $modelName;
        $this->valueQuoter = $valueQuoter;
    }

    /**
     * Returns the SQL query that is used to actually execute
     * the provided SPARQL query.
     *
     * @param string $query The SPARQL query.
     * @return string The SQL query.
     */
    public function wrap($query)
    {
        $parameters = array(
            '{{SPARQL}}' => $query
        );

        $queryInfo = $this->parser->parse($query);

        $modifiers = $queryInfo->getSolutionModifier();
        if (isset($modifiers['order by'])) {
            $parameters['{{ORDER}}'] = 'ORDER BY SEM$ROWNUM';
        }
        $numberOfConstraints = $this->countConstraints($queryInfo->getResultPart());
        if ($numberOfConstraints > static::MIN_NUMBER_OF_CONSTRAINTS_FOR_PARALLELIZATION) {
            // If the query contains many constraints (filter expressions etc.), then provide
            // the hint to parallelize the execution. This greatly improves the performance
            // of queries that have to check many rows, but other queries will
            // slightly suffer, which is the reason why this hint is not used in general.
            $parameters['{{HINTS}}'] = '/*+ PARALLEL */';
        }
        return $this->buildSql($parameters);
    }

    /**
     * Counts the number of constraints (recursively) in the provided
     * query pattern.
     *
     * @param array(\Erfurt_Sparql_GraphPattern) $patterns
     * @return integer
     */
    protected function countConstraints(array $patterns)
    {
        $numberOfConstraints = 0;
        foreach ($patterns as $pattern) {
            /* @var $pattern \Erfurt_Sparql_GraphPattern */
           $numberOfConstraints += count($pattern->getConstraints());
        }
        return $numberOfConstraints;
    }

    /**
     * Uses the provided parameters to build the SQL query from template.
     *
     * @param array(string=>string) $parameters
     * @return string
     */
    protected function buildSql(array $parameters)
    {
        $template = 'SELECT {{HINTS}} {{PROJECTION}} '
                  . 'FROM TABLE('
                  . '  SEM_MATCH('
                  . '    {{SPARQL}},'
                  . '    SEM_MODELS({{MODELS}}),'
                  . '    NULL,'
                  . '    NULL,'
                  . '    NULL,'
                  . '    NULL,'
                  . '    {{OPTIONS}},'
                  . '    NULL,'
                  . '    NULL'
                  . '  )'
                  . ') '
                  . '{{ORDER}}';
        $parameters = $parameters + $this->getDefaultParameters();
        $parameters['{{SPARQL}}']  = $this->escapeSparql($parameters['{{SPARQL}}']);
        $parameters['{{MODELS}}']  = $this->quote($parameters['{{MODELS}}']);
        $parameters['{{OPTIONS}}'] = $this->quote($parameters['{{OPTIONS}}']);
        return strtr($template, $parameters);
    }

    /**
     * Returns the default query parameters.
     *
     * @return array(string=>string)
     */
    protected function getDefaultParameters()
    {
        return array(
            '{{HINTS}}'      => '',
            '{{PROJECTION}}' => '*',
            '{{MODELS}}'     => $this->modelName,
            '{{OPTIONS}}'    => 'STRICT_DEFAULT=T',
            '{{ORDER}}'      => ''
        );
    }

    /**
     * Uses the Oracle q operator to escape a SPARQL query string.
     *
     * Usually it is much better to use prepared statements, but
     * parameters like the SPARQL query must be available at
     * compile time for optimization reasons.
     *
     * @param string $query
     * @return string
     * @throws \InvalidArgumentException If the string contains the escape sequence.
     */
    protected function escapeSparql($query)
    {
        if (strpos($query, "~'") !== false) {
            $message = 'SPARQL query must not contain the sequence "~\'", which is used internally for escaping."';
            throw new \InvalidArgumentException($message);
        }
        return "q'~$query~'";
    }

    /**
     * Escapes the provided value.
     *
     * @param mixed $value
     * @return string
     */
    protected function quote($value)
    {
        return call_user_func($this->valueQuoter, $value);
    }

}
