<?php

use Doctrine\DBAL\Schema\Schema;

/**
 * Base class for tests that use an Oracle database.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 11.01.14
 * @Group Oracle
 */
abstract class Erfurt_OracleTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * The connection that is used for testing.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * The database schema before the test was executed.
     *
     * @var \Doctrine\DBAL\Schema\Schema
     */
    protected $originalSchema = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->connection = $this->createConnection();
        $this->backupSchema();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->restoreSchema();
        $this->connection = null;
        parent::tearDown();
    }

    /**
     * Returns the database connection that is used for testing.
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function createConnection()
    {
        return Erfurt_Store_Adapter_Oracle::createConnection($this->getConfig());
    }

    /**
     * Loads the configuration for the adapter.
     *
     * @return array(mixed)
     */
    protected function getConfig()
    {
        $path = __DIR__ . '/../../oracle.ini';
        if (!is_file($path)) {
            $message = 'This test requires an Oracle connection configuration in the file '
                     . 'oracle.ini in the test root. Use oracle.ini.dist as a template.';
            $this->markTestSkipped($message);
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
    }

    /**
     * Restores the original database schema.
     */
    protected function restoreSchema()
    {
        $modifiedSchema = $this->connection->getSchemaManager()->createSchema();
        $sql = $modifiedSchema->getMigrateToSql($this->originalSchema, $this->connection->getDatabasePlatform());
        foreach ($sql as $query) {
            /* @var $query string */
            $this->connection->exec($sql);
        }
    }

}
