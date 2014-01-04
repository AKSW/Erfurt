<?php

use Doctrine\DBAL\Driver\OCI8\OCI8Connection;
use \Doctrine\DBAL\Driver\OCI8\OCI8Statement;

/**
 * Custom statement that does not perform any substitution of positional parameters
 * to avoid problems with question marks in SPARQL queries and literals.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 04.01.14
 */
class Erfurt_Store_Adapter_Oracle_Doctrine_Statement extends OCI8Statement
{

    /**
     * Creates a statement without positional parameter substitution.
     *
     * @param resource                                  $dbh       The connection handle.
     * @param string                                    $statement The SQL statement.
     * @param \Doctrine\DBAL\Driver\OCI8\OCI8Connection $conn
     */
    public function __construct($dbh, $statement, OCI8Connection $conn)
    {
        $this->_sth = oci_parse($dbh, $statement);
        $this->_dbh = $dbh;
        $this->_paramMap = array();
        $this->_conn = $conn;
    }

}
