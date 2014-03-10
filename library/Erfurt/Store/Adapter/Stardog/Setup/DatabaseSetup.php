<?php

/**
 * Creates a Stardog database if not already available.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.03.14
 */
class Erfurt_Store_Adapter_Stardog_Setup_DatabaseSetup implements Erfurt_Store_Adapter_Container_SetupInterface
{

    /**
     * Creates a setup instance for the provided database.
     *
     * @param Erfurt_Store_Adapter_Stardog_ApiClient $client
     * @param string $database The name of the database.
     */
    public function __construct(Erfurt_Store_Adapter_Stardog_ApiClient $client, $database)
    {

    }

    /**
     * Checks if the feature is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {
        // TODO: Implement isInstalled() method.
    }

    /**
     * Installs the feature.
     */
    public function install()
    {
        // TODO: Implement install() method.
    }

    /**
     * Removes a previously installed feature.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {
        // TODO: Implement uninstall() method.
    }

}
