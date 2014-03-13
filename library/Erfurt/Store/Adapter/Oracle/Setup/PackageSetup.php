<?php

use Doctrine\DBAL\Connection;

/**
 * Installs the package that contains types and stored procedures, which
 * can be used by the Oracle adapter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 24.02.14
 */
class Erfurt_Store_Adapter_Oracle_Setup_PackageSetup implements \Erfurt_Store_Adapter_Container_SetupInterface
{

    /**
     * The database connection that is used.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * Creates a setup object that uses the provided connection to
     * install the package.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Checks if the feature is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {
        return $this->packageExists();
    }

    /**
     * Installs the feature.
     */
    public function install()
    {
        $this->createPackage();
    }

    /**
     * Removes a previously installed feature.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {
        $this->dropPackage();
    }

    /**
     * Creates a stored procedure that is used to insert triples.
     */
    protected function createPackage()
    {
        $packageHeaderLines = array(
            'CREATE OR REPLACE PACKAGE ERFURT AS',
            '    TYPE uri_list IS TABLE OF VARCHAR(1000) INDEX BY BINARY_INTEGER;',
            '    TYPE object_list IS TABLE OF VARCHAR(4000) INDEX BY BINARY_INTEGER;',
            '    PROCEDURE ADD_TRIPLES(graphs IN uri_list, subjects IN uri_list, predicates IN uri_list, objects IN object_list);',
            'END ERFURT;'
        );
        $packageBodyLines = array(
            'CREATE OR REPLACE PACKAGE BODY ERFURT AS',
            '    PROCEDURE ADD_TRIPLES(graphs IN uri_list, subjects IN uri_list, predicates IN uri_list, objects IN object_list) AS',
            '    BEGIN',
            '        FORALL i IN 1 .. graphs.count',
            '            INSERT INTO erfurt_semantic_data (triple)',
            '            VALUES (SDO_RDF_TRIPLE_S(',
            '                graphs(i),',
            '                subjects(i),',
            '                predicates(i),',
            '                objects(i)',
            '            ));',
            '    END;',
            'END ERFURT;'
        );
        $this->connection->executeQuery(implode(PHP_EOL, $packageHeaderLines));
        $this->connection->executeQuery(implode(PHP_EOL, $packageBodyLines));
    }

    /**
     * Drops the adapter package and its stored procedures.
     */
    protected function dropPackage()
    {
        if ($this->packageExists()) {
            $query = 'DROP PACKAGE ERFURT';
            $this->connection->executeQuery($query);
        }
    }

    /**
     * Checks if the Erfurt procedure package exists.
     *
     * @return boolean
     */
    protected function packageExists()
    {
        $query     = "SELECT * FROM USER_OBJECTS WHERE OBJECT_TYPE='PACKAGE' AND OBJECT_NAME='ERFURT'";
        $statement = $this->connection->query($query);
        $rows      = $statement->fetchAll();
        return count($rows) > 0;
    }

}
