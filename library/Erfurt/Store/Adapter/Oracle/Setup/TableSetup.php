<?php

use Doctrine\DBAL\Connection;

/**
 * Installs the application table that is used to push triples
 * into the semantic model.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 24.02.14
 */
class Erfurt_Store_Adapter_Oracle_Setup_TableSetup implements \Erfurt_Store_Adapter_Container_SetupInterface
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
     * Checks if the feature is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {
        return $this->tableExists('erfurt_semantic_data');
    }

    /**
     * Installs the feature.
     */
    public function install()
    {
        $this->createTable();
    }

    /**
     * Removes a previously installed feature.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {
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
     * Returns the schema manager for the connection.
     *
     * @return \Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    protected function getSchemaManager()
    {
        return $this->connection->getSchemaManager();
    }

}
