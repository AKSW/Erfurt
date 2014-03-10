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

    }

    /**
     * Ensures that isInstalled() returns true if the database exists.
     */
    public function testIsInstalledReturnsTrueIfDatabaseExists()
    {

    }

    /**
     * Ensures that isInstalled() returns false if the database does not exist.
     */
    public function testIsInstalledReturnsFalseIfDatabaseDoesNotExist()
    {

    }

    /**
     * Checks if install() creates the database.
     */
    public function testInstallCreatesDatabase()
    {

    }

    /**
     * Checks if uninstall() drops the database.
     */
    public function testUninstallDropsDatabase()
    {

    }

}
