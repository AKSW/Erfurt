<?php

use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Event\Listeners\OracleSessionInit;

/**
 * Session initializer that treats non-string values correctly.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.02.14
 */
class Erfurt_Store_Adapter_Oracle_Doctrine_OracleSessionInit extends OracleSessionInit
{

    /**
     * @param \Doctrine\DBAL\Event\ConnectionEventArgs $args
     */
    public function postConnect(ConnectionEventArgs $args)
    {
        if (count($this->_defaultSessionVars) === 0) {
            return;
        }
        $connection = $args->getConnection();
        $vars       = array();
        foreach ($this->_defaultSessionVars as $option => $value) {
            $vars[] = $option . ' = ' . $connection->quote($value);
        }
        $sql = "ALTER SESSION SET " . implode(" ", $vars);
        $connection->executeUpdate($sql);
    }

}
