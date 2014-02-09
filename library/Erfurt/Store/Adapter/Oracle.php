<?php

use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Event\Listeners\OracleSessionInit;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Config\Definition\Processor;

/**
 * Acts as a factory that creates the Oracle Triple Store adapter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 12.12.13
 */
class Erfurt_Store_Adapter_Oracle implements \Erfurt_Store_Adapter_FactoryInterface
{

    /**
     * Uses the options to create an adapter instance.
     *
     * @param array(string=>mixed) $adapterOptions
     * @return \Erfurt_Store_Adapter_Interface
     * @throws \InvalidArgumentException If options are missing or wrong options are provided.
     */
    public static function createFromOptions(array $adapterOptions)
    {
        $adapterOptions   = static::normalizeOptions($adapterOptions);
        $connectionParams = $adapterOptions['connection'];
        $connection       = static::createConnection($connectionParams);
        if ($adapterOptions['auto_setup']) {
            static::installTripleStoreIfNecessary($connection);
        }
        $sparqlAdapter = new Erfurt_Store_Adapter_Sparql_GenericSparqlAdapter(
            new Erfurt_Store_Adapter_Oracle_OracleSparqlConnector($connection)
        );
        $sqlAdapter = new Erfurt_Store_Adapter_Oracle_OracleSqlAdapter($connection);
        return new Erfurt_Store_Adapter_SparqlSqlCombination($sparqlAdapter, $sqlAdapter);
    }

    /**
     * Creates a database connection that can be used by the adapter.
     *
     * @param array(string=>string) $params
     * @return \Doctrine\DBAL\Connection
     */
    public static function createConnection(array $params)
    {
        // TODO: use configuration to normalize
        if (!Type::hasType(\Erfurt_Store_Adapter_Oracle_Doctrine_TripleType::TRIPLE)) {
            Type::addType(
                \Erfurt_Store_Adapter_Oracle_Doctrine_TripleType::TRIPLE,
                'Erfurt_Store_Adapter_Oracle_Doctrine_TripleType'
            );
        }
        if (isset($params['pool'])) {
            // Set the name of the connection pool.
            ini_set('oci8.connection_class', $params['pool']);
        }
        $additionalParams = array('driverClass' => 'Erfurt_Store_Adapter_Oracle_Doctrine_Driver');
        $connectionParams = $params + $additionalParams;

        $eventManager = new EventManager();
        $additionalSessionParams = isset($params['session']) ? $params['session'] : array();
        unset($params['session']);
        $initializer = new Erfurt_Store_Adapter_Oracle_Doctrine_OracleSessionInit($additionalSessionParams);
        $eventManager->addEventSubscriber($initializer);

        return DriverManager::getConnection($connectionParams, null, $eventManager);

    }

    /**
     * Uses the provided connection to install the Triple Store components
     * if that is necessary.
     *
     * @param \Doctrine\DBAL\Connection $connection
     */
    protected static function installTripleStoreIfNecessary($connection)
    {
        $setup = new Erfurt_Store_Adapter_Oracle_Setup($connection);
        if ($setup->isInstalled()) {
            // The Triple Store components are already installed.
            return;
        }
        $setup->install();
    }

    /**
     * Validates and normalizes the provided adapter options.
     *
     * @param array(string=>mixed) $options
     * @return array(string=>mixed)
     */
    protected static function normalizeOptions(array $options)
    {
        $processor = new Processor();
        $configuration = new Erfurt_Store_Adapter_Oracle_AdapterConfiguration();
        return $processor->processConfiguration(
            $configuration,
            array($options)
        );
    }

}
