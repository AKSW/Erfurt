<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type;

/**
 * Used to setup the Oracle Triple Store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 14.12.13
 */
class Erfurt_Store_Adapter_Oracle_Setup
{

    /**
     * The database connection that is used.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * Creates a setup object that uses the provided connection to
     * install a Triple Store.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Checks if the Triple Store is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {
        return $this->tableExists('erfurt_semantic_data') && $this->modelExists($this->getModelName());
    }

    /**
     * Installs the Triple Store.
     */
    public function install()
    {
        // Drop model and table if these already exist...
        $this->dropModel();
        $this->dropTable();
        // ... and create new ones.
        $this->createTable();
        $this->createModel();
        $this->createInsertProcedure();
    }

    /**
     * Removes a previously installed Triple Store.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {
        $this->dropModel();
        $this->dropTable();
    }

    /**
     * Creates the tables that holds the semantic data.
     */
    protected function createTable()
    {
        $query = 'CREATE TABLE erfurt_semantic_data ('
               . '  triple SDO_RDF_TRIPLE_S'
               . ')';
        $this->connection->executeQuery($query);
        // Create a function based index on the object ID, which is used to retrieve CLOB literals.
        $query = 'CREATE INDEX object_id ON erfurt_semantic_data (triple.RDF_O_ID)';
        $this->connection->executeQuery($query);
    }

    /**
     * Creates the semantic model.
     */
    protected function createModel()
    {
        $query = 'BEGIN SEM_APIS.CREATE_SEM_MODEL(:model, :dataTable, :tripleColumn); END;';
        $params = array(
            'model'        => $this->getModelName(),
            'dataTable'    => 'erfurt_semantic_data',
            'tripleColumn' => 'triple'
        );
        $this->connection->prepare($query)->execute($params);
    }

    /**
     * Removes the semantic model.
     *
     * @throws Doctrine\DBAL\DBALException|Exception
     */
    protected function dropModel()
    {
        $model = $this->getModelName();
        if ($this->modelExists($model)) {
            $query = 'BEGIN SEM_APIS.DROP_SEM_MODEL(:model); END;';
            $params = array('model' => $model);
            $this->connection->prepare($query)->execute($params);
        }
    }

    /**
     * Creates a stored procedure that is used to insert triples.
     */
    protected function createInsertProcedure()
    {
        $packageHeaderLines = array(
            'CREATE OR REPLACE PACKAGE ERFURT AS',
            '    TYPE STRING_LIST IS TABLE OF VARCHAR(4000) INDEX BY BINARY_INTEGER;',
            '    PROCEDURE ADD_TRIPLES(graphs IN STRING_LIST, subjects IN STRING_LIST, predicates IN STRING_LIST, objects IN STRING_LIST);',
            'END ERFURT;'
        );
        $packageBodyLines = array(
            'CREATE OR REPLACE PACKAGE BODY ERFURT AS',
            '    PROCEDURE ADD_TRIPLES(graphs IN STRING_LIST, subjects IN STRING_LIST, predicates IN STRING_LIST, objects IN STRING_LIST) IS',
            '    BEGIN',
            '        FOR i IN 1 .. graphs.count LOOP',
            '            INSERT INTO erfurt_semantic_data (triple)',
            '            VALUES (SDO_RDF_TRIPLE_S(',
            '                graphs(i),',
            '                subjects(i),',
            '                predicates(i),',
            '                objects(i)',
            '            ));',
            '        END LOOP;',
            '    END;',
            'END ERFURT;'
        );
        $this->connection->executeQuery(implode(PHP_EOL, $packageHeaderLines));
        $this->connection->executeQuery(implode(PHP_EOL, $packageBodyLines));
    }

    /**
     * Removes the table that contains the semantic data.
     */
    protected function dropTable()
    {
        if ($this->getSchemaManager()->tablesExist(array('erfurt_semantic_data'))) {
            $query = 'DROP TABLE erfurt_semantic_data';
            $this->connection->executeQuery($query);
        }
    }

    /**
     * Checks if the provided semantic model exists.
     *
     * @param string $model
     * @return boolean
     */
    protected function modelExists($model)
    {
        $query = 'SELECT m.MODEL_NAME FROM MDSYS.SEM_MODEL$ m '
               . 'WHERE OWNER=SYS_CONTEXT(:namespace, :parameter) AND '
               . 'MODEL_NAME=:modelName';
        $params = array(
            'namespace' => 'USERENV',
            'parameter' => 'CURRENT_USER',
            'modelName' => strtoupper($model)
        );
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return count($rows) > 0;
    }

    /**
     * Checks if the given table exists.
     *
     * @param string $table
     * @return boolean
     */
    protected function tableExists($table)
    {
        return $this->getSchemaManager()->tablesExist(array($table));
    }

    /**
     * Returns the name of the semantic model that is used.
     *
     * @return string
     */
    protected function getModelName()
    {
        return $this->connection->getUsername() . '_erfurt';
    }

    /**
     * Returns the schema manager for the connection.
     *
     * @return \Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    protected function getSchemaManager()
    {
        return $this->connection->getSchemaManager();
    }

}
