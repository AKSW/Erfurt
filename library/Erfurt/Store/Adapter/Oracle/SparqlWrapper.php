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

    }

}
