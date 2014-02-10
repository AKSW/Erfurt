<?php

use Doctrine\DBAL\Schema\Schema;

/**
 * Helper class that is used to set up test environments that use an Oracle database.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 * @group Oracle
 */
class Erfurt_OracleTestHelper
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
     * Setup helper that is used to install the triple store.
     *
     * @var \Erfurt_Store_Adapter_Oracle_Setup
     */
    protected $setup = null;

    /**
     * Contains task callbacks that must be executed on tear down.
     *
     * @var array(mixed)
     */
    protected $cleanUpTasks = array();

    /**
     * Cleans up the environment.
     */
    public function cleanUp()
    {
        foreach (array_reverse($this->cleanUpTasks) as $task) {
            call_user_func($task);
        }
    }

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
            $this->sparqlConnector = new Erfurt_Store_Adapter_Oracle_OracleSparqlConnector($this->getConnection());
            $this->addCleanUpTask(array($this, 'unsetSparqlConnector'));
        }
        return $this->sparqlConnector;
    }

    /**
     * Creates a clean installation of the Triple Store.
     */
    public function installTripleStore()
    {
        if ($this->setup === null) {
            $this->setup = new Erfurt_Store_Adapter_Oracle_Setup($this->getConnection());
            $this->uninstallTripleStore();
            $this->setup->install();
            $this->addCleanUpTask(array($this, 'uninstallTripleStore'));
        }
    }

    /**
     * Removes the Triple Store that was used for testing.
     */
    protected function uninstallTripleStore()
    {
        if ($this->setup->isInstalled()) {
            $this->setup->uninstall();
        }
    }

    /**
     * Registers a task that must be executed on cleanup.
     *
     * @param mixed $callback
     */
    protected function addCleanUpTask($callback)
    {
        $this->cleanUpTasks[] = $callback;
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
     * Loads the configuration for the adapter.
     *
     * @return array(mixed)
     * @throws \PHPUnit_Framework_SkippedTestError If the config does not exist.
     */
    protected function getConfig()
    {
        $path = __DIR__ . '/../../oracle.ini';
        if (!is_file($path)) {
            $message = 'This test requires an Oracle connection configuration in the file '
                     . 'oracle.ini in the test root. Use oracle.ini.dist as a template.';
            throw new PHPUnit_Framework_SkippedTestError($message);
        }
        $config = new Zend_Config_Ini($path);
        return $config->toArray();
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
