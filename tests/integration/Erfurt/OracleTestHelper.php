<?php

use Doctrine\DBAL\Schema\Schema;

/**
 * Helper class that is used to set up test environments that use an Oracle database.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 */
class Erfurt_OracleTestHelper extends Erfurt_AbstractTestHelper
    implements \Erfurt_Store_Adapter_Sparql_ConnectorBenchmarkHelperInterface
{

    /**
     * The connection that is used for testing.
     *
     * @var \Doctrine\DBAL\Connection|null
     */
    protected $connection = null;

    /**
     * The Oracle SPARQL connector that is used for testing.
     *
     * @var \Erfurt_Store_Adapter_Oracle_OracleSparqlConnector|null
     */
    protected $sparqlConnector = null;

    /**
     * The database schema before the test was executed.
     *
     * @var \Doctrine\DBAL\Schema\Schema|null
     */
    protected $originalSchema = null;

    /**
     * Setup instances that are used to install the triple store.
     *
     * @var \Erfurt_Store_Adapter_Container_SetupInterface[]
     */
    protected $setups = null;

    /**
     * Returns the database connection that is used for testing.
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        if ($this->connection === null) {
            $this->connection = Erfurt_Store_Adapter_Oracle::createConnection($this->getConfig());
            $this->addCleanUpTask(array($this, 'closeConnection'));
            $this->backupSchema();
        }
        return $this->connection;
    }

    /**
     * Returns the SPARQL connector.
     *
     * @return Erfurt_Store_Adapter_Oracle_OracleSparqlConnector
     */
    public function getSparqlConnector()
    {
        if ($this->sparqlConnector === null) {
            $this->installTripleStore();
            $this->sparqlConnector = new Erfurt_Store_Adapter_Oracle_OracleSparqlConnector($this->getConnection());
            $this->addCleanUpTask(array($this, 'unsetSparqlConnector'));
        }
        return $this->sparqlConnector;
    }

    /**
     * Counts the number of triples in the store.
     *
     * @return integer
     */
    public function countTriples()
    {
        $this->installTripleStore();
        $query = 'SELECT COUNT(*) AS NUMBER_OF_TRIPLES FROM erfurt_semantic_data';
        $result = $this->getConnection()->query($query);
        $rows = $result->fetchAll();
        return (int)$rows[0]['NUMBER_OF_TRIPLES'];
    }

    /**
     * Creates a clean installation of the Triple Store.
     */
    public function installTripleStore()
    {
        if ($this->setups === null) {
            $connection = $this->getConnection();
            $this->setups = array(
                new Erfurt_Store_Adapter_Oracle_Setup_TableSetup($connection),
                new Erfurt_Store_Adapter_Oracle_Setup_ModelSetup($connection),
                new Erfurt_Store_Adapter_Oracle_Setup_PackageSetup($connection)
            );
            // Remove components if there are leftovers from a previous run.
            foreach (array_reverse($this->setups) as $setup) {
                /* @var $setup \Erfurt_Store_Adapter_Container_SetupInterface */
                if ($setup->isInstalled()) {
                    $setup->uninstall();
                }
            }
            // Afterwards, create a clean install of each component.
            foreach ($this->setups as $setup) {
                // Create a fresh install for each component.
                $setup->install();
                $this->addCleanUpTask(array($setup, 'uninstall'));
            }
        }
    }

    /**
     * Closes the connection that has been created.
     */
    protected function closeConnection()
    {
        $this->connection->close();
        $this->connection = null;
    }

    /**
     * Destroys the used SPARQL connector.
     */
    protected function unsetSparqlConnector()
    {
        $this->sparqlConnector = null;
    }

    /**
     * Creates a backup of the current database schema.
     */
    protected function backupSchema()
    {
        $this->originalSchema = clone $this->connection->getSchemaManager()->createSchema();
        $this->addCleanUpTask(array($this, 'restoreSchema'));
    }

    /**
     * Restores the original database schema.
     */
    protected function restoreSchema()
    {
        if ($this->connection === null) {
            // Seems as if the test was skipped during setUp().
            return;
        }
        $modifiedSchema = $this->connection->getSchemaManager()->createSchema();
        $sql = $modifiedSchema->getMigrateToSql($this->originalSchema, $this->connection->getDatabasePlatform());
        foreach ($sql as $query) {
            /* @var $query string */
            $this->connection->exec($query);
        }
    }

}
