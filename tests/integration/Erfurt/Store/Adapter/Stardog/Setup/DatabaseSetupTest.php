<?php

/**
 * Tests the Stardog database setup.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 10.03.14
 */
class Erfurt_Store_Adapter_Stardog_Setup_DatabaseSetupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Helper that is used to create the test environment.
     *
     * @var Erfurt_StardogTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper = new Erfurt_StardogTestHelper();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->helper->cleanUp();
        $this->helper = null;
        parent::tearDown();
    }

    /**
     * Checks if the setup implements the required interface.
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf('Erfurt_Store_Adapter_Container_SetupInterface', $this->createSetup('test'));
    }

    /**
     * Ensures that isInstalled() returns true if the database exists.
     */
    public function testIsInstalledReturnsTrueIfDatabaseExists()
    {
        $setup = $this->createSetup('test');
        $this->assertTrue($setup->isInstalled());
    }

    /**
     * Ensures that isInstalled() returns false if the database does not exist.
     */
    public function testIsInstalledReturnsFalseIfDatabaseDoesNotExist()
    {
        $setup = $this->createSetup('missing');
        $this->assertFalse($setup->isInstalled());
    }

    /**
     * Checks if install() creates the database.
     *
     * @return string Name of the database that was created.
     */
    public function testInstallCreatesDatabase()
    {
        $database = uniqid('db', true);
        $setup = $this->createSetup($database);
        $this->assertTrue($setup->isInstalled());
        return $database;
    }

    /**
     * Checks if uninstall() drops the database.
     *
     * @param string $database
     * @depends testInstallCreatesDatabase
     */
    public function testUninstallDropsDatabase($database)
    {
        $setup = $this->createSetup($database);
        $setup->uninstall();
        $this->assertFalse($setup->isInstalled());
    }

    /**
     * Creates a setup instance for the provided database.
     *
     * @param string $database
     * @return Erfurt_Store_Adapter_Stardog_Setup_DatabaseSetup
     */
    protected function createSetup($database)
    {
        return new Erfurt_Store_Adapter_Stardog_Setup_DatabaseSetup($this->helper->getApiClient(), $database);
    }

}
