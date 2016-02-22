<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type;

/**
 * Used to setup the Oracle Triple Store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 14.12.13
 * @deprecated Use more specific setups (TableSetup, ModelSetup, PackageSetup).
 */
class Erfurt_Store_Adapter_Oracle_Setup
{

    /**
     * Inner setups.
     *
     * @var \Erfurt_Store_Adapter_Container_SetupInterface[]
     */
    protected $setups = array();

    /**
     * Creates a setup object that uses the provided connection to
     * install a Triple Store.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->setups = array(
            new Erfurt_Store_Adapter_Oracle_Setup_TableSetup($connection),
            new Erfurt_Store_Adapter_Oracle_Setup_ModelSetup($connection),
            new Erfurt_Store_Adapter_Oracle_Setup_PackageSetup($connection)
        );
    }

    /**
     * Checks if the Triple Store is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {
        foreach ($this->setups as $setup) {
            if (!$setup->isInstalled()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Installs the Triple Store.
     */
    public function install()
    {
        foreach ($this->setups as $setup) {
            if (!$setup->isInstalled()) {
                $setup->install();
            }
        }
    }

    /**
     * Removes a previously installed Triple Store.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {
        foreach (array_reverse($this->setups) as $setup) {
            if ($setup->isInstalled()) {
                $setup->uninstall();
            }
        }
    }

}
