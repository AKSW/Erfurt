<?php

use Doctrine\DBAL\Connection;

/**
 * Loads large literals by value ID.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.02.14
 */
class Erfurt_Store_Adapter_Oracle_ClobLiteralLoader
{

    /**
     * Creates a loader that uses the provided connection.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {

    }

    /**
     * Loads the CLOB that is identified by the provided ID.
     *
     * @param integer $valueId
     * @return string|null
     */
    public function load($valueId)
    {

    }

}
