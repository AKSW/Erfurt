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
     * Callback that is used to quote identifiers.
     *
     * @var callable
     */
    protected $identifierQuoter = null;

    /**
     * The name of the model that is queried.
     *
     * @var string
     */
    protected $modelName = null;

    /**
     * Creates a wrapper that selects data from the provided model.
     *
     * Uses $valueQuoter to escape values and $identifierQuoter to quote
     * variable names in the generated SQL queries.
     *
     * @param string $modelName
     * @param callable $valueQuoter
     * @param callable $identifierQuoter
     * @throws \InvalidArgumentException If no valid callback is passed.
     */
    public function __construct($modelName, $valueQuoter, $identifierQuoter)
    {
        if (!is_callable($valueQuoter)) {
            $message = '$valueQuoter must be a valid callback.';
            throw new \InvalidArgumentException($message);
        }
        if (!is_callable($identifierQuoter)) {
            $message = '$identifierQuoter must be a valid callback.';
            throw new \InvalidArgumentException($message);
        }
        $this->parser           = new Erfurt_Sparql_Parser();
        $this->modelName        = $modelName;
        $this->valueQuoter      = $valueQuoter;
        $this->identifierQuoter = $identifierQuoter;
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
        $queryInfo = $this->parser->parse($query);
        $parameters = array(
            '{{PROJECTION}}' => $this->getProjection($queryInfo),
            '{{HINTS}}'      => $this->getHints($queryInfo),
            '{{SPARQL}}'     => $query,
            '{{ORDER}}'      => $this->getOrder($queryInfo)
        );
        return $this->buildSql($parameters);
    }

    /**
     * Returns the variables that will be selected by the SQL query.
     *
     * @param Erfurt_Sparql_Query $query
     * @return string
     */
    protected function getProjection(Erfurt_Sparql_Query $query)
    {
        $selected = array();
        $vars     = $this->getRequestedVariables($query);
        foreach ($vars as $var) {
            /* @var $var string */
            $selected = array_merge($selected, $this->getSelection($var));
        }
        return implode(', ', $selected);
    }

    /**
     * Returns the ORDER expression that will be used by the SQL query.
     *
     * @param Erfurt_Sparql_Query $query
     * @return string
     */
    protected function getOrder(Erfurt_Sparql_Query $query)
    {
        $modifiers = $query->getSolutionModifier();
        if (isset($modifiers['order by'])) {
            return 'ORDER BY SEM$ROWNUM';
        }
        return '';
    }

    /**
     * Returns the hints that will be used in the SQL query.
     *
     * @param Erfurt_Sparql_Query $query
     * @return string
     */
    protected function getHints(Erfurt_Sparql_Query $query)
    {
        $numberOfConstraints = $this->countConstraints($query->getResultPart());
        if ($numberOfConstraints > static::MIN_NUMBER_OF_CONSTRAINTS_FOR_PARALLELIZATION) {
            // If the query contains many constraints (filter expressions etc.), then provide
            // the hint to parallelize the execution. This greatly improves the performance
            // of queries that have to check many rows, but other queries will
            // slightly suffer, which is the reason why this hint is not used in general.
            return '/*+ PARALLEL */';
        }
        return '';
    }

    /**
     * Returns the names of the variables that are requested by the
     * provided SPARQL query.
     *
     * @param Erfurt_Sparql_Query $query
     * @return string
     */
    protected function getRequestedVariables(Erfurt_Sparql_Query $query)
    {
        if ($query->getResultForm() === 'ask') {
            return array ('?ASK');
        }
        $vars = $query->getResultVars();
        if (count($vars) > 1) {
            return array_map('strval', $vars);
        }
        /* @var $variable \Erfurt_Sparql_QueryResultVariable */
        $variable = $vars[0];
        if ($variable->getName() !== '*') {
            return array((string)$variable);
        }
        // The STAR selector is used, all variables are requested.
        return $query->getAllVars();
    }

    /**
     * Returns a list of variable selection expressions, that are necessary to
     * get all necessary information about the provided SPARQL variable.
     *
     * @param string $var The name of the SPARQL variable.
     * @return array(string)
     */
    protected function getSelection($var)
    {
        $var        = ltrim($var, '?$');
        $normalized = $this->removePrefix($var);
        $normalized = \Erfurt_Store_Adapter_Oracle_ResultConverter_Util::decodeVariableName($normalized);
        $suffixes  = array(
            '',
            '$RDFLANG',
            '$RDFVTYP',
            '$RDFLTYP',
            '$RDFCLOB'
        );
        $selected  = array();
        $oracleVar = strtoupper($var);
        foreach ($suffixes as $suffix) {
            /* @var $suffix string */
            $selected[] = $oracleVar . $suffix . ' AS ' . $this->quoteIdentifier($normalized . $suffix);
        }
        return $selected;
    }

    /**
     * Removes the prefix that is added by the SPARQL rewriter from the provided
     * variable.
     *
     * If the variable does not start with the prefix, then it will not be changed.
     *
     * @param string $var
     * @return string
     */
    protected function removePrefix($var)
    {
        if (!$this->startsWithPrefix($var)) {
            return $var;
        }
        return substr($var, strlen(Erfurt_Store_Adapter_Oracle_SparqlRewriter::VARIABLE_PREFIX));
    }

    /**
     * Checks if the provided value starts with the prefix that is added to
     * SPARQL variables by the rewriter.
     *
     * @param string $value
     * @return boolean
     */
    protected function startsWithPrefix($value)
    {
        return strpos($value, Erfurt_Store_Adapter_Oracle_SparqlRewriter::VARIABLE_PREFIX) === 0;
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
     * Quotes the provided identifier to ensure that even reserved keywords can be used.
     *
     * @param string $identifier
     */
    protected function quoteIdentifier($identifier)
    {
        return call_user_func($this->identifierQuoter, $identifier);
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
