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
        // We assume that the Triple Store was installed if the data table already exists.
        return $this->tableExists('erfurt_semantic_data');
    }

    /**
     * Installs the Triple Store.
     */
    public function install()
    {
        $this->createTable();
        $this->createModel();
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
            . '  id NUMBER GENERATED BY DEFAULT ON NULL AS IDENTITY,'
            . '  triple SDO_RDF_TRIPLE_S'
            . ')';
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
        $this->connection->executeQuery($query, $params);
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
            $this->connection->executeQuery($query, $params);
        }
    }

    /**
     * Removes the table that contains the semantic data.
     */
    protected function dropTable()
    {
        if ($this->getSchemaManager()->tablesExist(array('erfurt_semantic_data'))) {
            $query = 'DROP TABLE erfurt_semantic_data';
            $this->connection->executeQuery($query);
            // This might avoid a bug that occurs when using the new IDENTITY column feature.
            // If the bug is encountered, the database complains about a NOT NULL CONSTRAINT
            // that cannot be dropped.
            $this->connection->executeQuery('PURGE RECYCLEBIN');
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
        $rows = $statement->fetchAll();
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