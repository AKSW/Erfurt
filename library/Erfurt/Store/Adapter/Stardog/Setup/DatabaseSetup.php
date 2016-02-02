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
     * The client that is used to interact with the store.
     *
     * @var Erfurt_Store_Adapter_Stardog_ApiClient
     */
    protected $client = null;

    /**
     * The name of the database that is managed by this setup.
     *
     * @var string
     */
    protected $database = null;

    /**
     * Creates a setup instance for the provided database.
     *
     * @param Erfurt_Store_Adapter_Stardog_ApiClient $client
     * @param string $database The name of the database.
     */
    public function __construct(Erfurt_Store_Adapter_Stardog_ApiClient $client, $database)
    {
        $this->client   = $client;
        $this->database = $database;
    }

    /**
     * Checks if the feature is already installed.
     *
     * @return boolean
     */
    public function isInstalled()
    {
        $databases = $this->client->listDatabases();
        return in_array($this->database, $databases);
    }

    /**
     * Installs the feature.
     */
    public function install()
    {
        $this->client->createDatabase($this->database);
    }

    /**
     * Removes a previously installed feature.
     *
     * All stored data will be lost.
     */
    public function uninstall()
    {
        $this->client->dropDatabase(array('database' => $this->database));
    }

}
