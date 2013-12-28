<?php

use Doctrine\DBAL\DriverManager;
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
        $connectionParams = $adapterOptions['connection'] + array('driver' => 'oci8');
        $connection       = DriverManager::getConnection($connectionParams);
        return new Erfurt_Store_Adapter_Oracle_OracleAdapter($connection);
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
