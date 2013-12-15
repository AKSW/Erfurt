<?php

use Doctrine\DBAL\Driver\Connection;

/**
 * Used to setup the Oracle Triple Store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 14.12.13
 */
class Erfurt_Store_Adapter_Oracle_Setup
{

    /**
     * Creates a setup object that uses the provided connection to
     * install a Triple Store.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {

    }

    /**
     * Checks if the Triple Store is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {

    }

    /**
     * Installs the Triple Store.
     */
    public function install()
    {

    }

    /**
     * Removes a previously installed Triple Store.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {

    }

}
