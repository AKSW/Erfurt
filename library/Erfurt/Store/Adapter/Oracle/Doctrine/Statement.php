<?php

use Doctrine\DBAL\Driver\OCI8\OCI8Connection;
use \Doctrine\DBAL\Driver\OCI8\OCI8Statement;

/**
 * Custom statement that performs an advanced substitution of positional parameters
 * to avoid problems with question marks in SPARQL queries and literals.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 04.01.14
 */
class Erfurt_Store_Adapter_Oracle_Doctrine_Statement extends OCI8Statement
{

    /**
     * Creates a statement with advanced positional parameter substitution.
     *
     * @param resource                                  $dbh       The connection handle.
     * @param string                                    $statement The SQL statement.
     * @param \Doctrine\DBAL\Driver\OCI8\OCI8Connection $conn
     */
    public function __construct($dbh, $statement, OCI8Connection $conn)
    {
        list($statement, $paramMap) = static::convertPositionalToNamedPlaceholders($statement);
        $this->_sth = oci_parse($dbh, $statement);
        $this->_dbh = $dbh;
        $this->_paramMap = $paramMap;
        $this->_conn = $conn;
    }

    /**
     * Converts positional (?) into named placeholders (:param<num>).
     *
     * @param string $statement The SQL statement to convert.
     * @return string
     */
    static public function convertPositionalToNamedPlaceholders($statement)
    {
        $count = 1;
        $literalStart = null;
        $stmtLen = strlen($statement);
        $paramMap = array();
        for ($i = 0; $i < $stmtLen; $i++) {
            if ($statement[$i] == '?' && $literalStart === null) {
                // real positional parameter detected
                $paramMap[$count] = ":param$count";
                $len = strlen($paramMap[$count]);
                $statement = substr_replace($statement, ":param$count", $i, 1);
                $i += $len-1; // jump ahead
                $stmtLen = strlen($statement); // adjust statement length
                ++$count;
            } else if ($statement[$i] == "'" || $statement[$i] == '"') {
                if ($literalStart === null) {
                    $literalStart = $statement[$i];
                } else if ($literalStart === $statement[$i]) {
                    // Literal ends.
                    $literalStart = null;
                }
            }
        }
        return array($statement, $paramMap);
    }

}
