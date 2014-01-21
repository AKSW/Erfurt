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

    /**
     * {@inheritdoc}
     */
    public function bindParam($column, &$variable, $type = null, $length = null)
    {
        if ($type === \PDO::PARAM_LOB) {
            // Intercept assignment of large objects and ensure that CLOB is used instead of BLOB.
            $column = isset($this->_paramMap[$column]) ? $this->_paramMap[$column] : $column;
            $lob = oci_new_descriptor($this->_dbh, OCI_D_LOB);
            $lob->writeTemporary($variable, OCI_TEMP_CLOB);
            return oci_bind_by_name($this->_sth, $column, $lob, -1, OCI_B_CLOB);
        }
        return parent::bindParam($column, $variable, $type, $length);
    }

}
