<?php
use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

/**
 * Factory that creates an Oracle database connection.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 06.07.14
 */
class Erfurt_Store_Adapter_Oracle_Doctrine_ConnectionFactory
{

    /**
     * Creates a database connection.
     *
     * @param array(string=>string) $params
     * @return \Doctrine\DBAL\Connection
     */
    public static function createConnection(array $params)
    {
        $params = static::normalizeParameters(
            $params,
            new Erfurt_Store_Adapter_Oracle_ConnectionConfiguration()
        );
        return static::createOracleConnectionFrom($params);
    }

    /**
     * Validates and normalizes the provided options.
     *
     * @param array(string=>mixed) $options
     * @param \Symfony\Component\Config\Definition\ConfigurationInterface $configuration
     * @return array(string=>mixed)
     */
    protected static function normalizeParameters(array $options, ConfigurationInterface $configuration)
    {
        $processor = new Processor();
        return $processor->processConfiguration(
            $configuration,
            array($options)
        );
    }

    /**
     * Creates the connection without validating the provided parameters.
     *
     * @param array(string=>mixed) $params
     * @return \Doctrine\DBAL\Connection
     */
    protected static function createOracleConnectionFrom(array $params)
    {
        $additionalParams = array('driverClass' => 'Erfurt_Store_Adapter_Oracle_Doctrine_Driver');
        $connectionParams = $params + $additionalParams;

        $eventManager = new EventManager();
        $additionalSessionParams = isset($params['session']) ? $params['session'] : array();
        unset($params['session']);
        $initializer = new Erfurt_Store_Adapter_Oracle_Doctrine_OracleSessionInit($additionalSessionParams);
        $eventManager->addEventSubscriber($initializer);

        return DriverManager::getConnection($connectionParams, null, $eventManager);
    }

}
