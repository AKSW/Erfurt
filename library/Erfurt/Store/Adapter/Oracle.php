<?php

use Doctrine\DBAL\DriverManager;

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
        if (!isset($adapterOptions['connection'])) {
            throw new InvalidArgumentException('Connection options are missing for Oracle adapter.');
        }
        $connectionParams = $adapterOptions['connection'] + array('driver' => 'oci8', 'port' => 1521);
        $requiredParams   = array('dbname', 'user', 'password', 'host', 'port');
        $missing          = array_diff($requiredParams, array_keys($connectionParams));
        if (count($missing) > 0) {
            $message = 'The following Oracle adapter connection options are missing: ' . implode(', ', $missing);
            throw new InvalidArgumentException($message);
        }
        $connection = DriverManager::getConnection($connectionParams);
        return new Erfurt_Store_Adapter_Oracle_OracleAdapter($connection);
    }

}
