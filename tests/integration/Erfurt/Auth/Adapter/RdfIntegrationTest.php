<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_Auth_Adapter_RdfIntegrationTest extends Erfurt_TestCase
{
    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testAuthenticateSuperAdmin($storeAdapterName)
    {
        $this->markTestNeedsTestConfig();
        $this->markTestNeedsStore($storeAdapterName);
        $dbUser = $this->getDbUser();
        $dbPassword = $this->getDbPassword();

        $instance = new Erfurt_Auth_Adapter_Rdf($dbUser, $dbPassword);
        $result = $instance->authenticate();
        $id = $result->getIdentity();

        $this->assertTrue($result->isValid());
        $this->assertEquals('SuperAdmin', $id->getUsername());
        $this->assertTrue($id->isDbUser());
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testAuthenticateSuperAdminWithWrongPassword($storeAdapterName)
    {
        $this->markTestNeedsTestConfig();
        $this->markTestNeedsStore($storeAdapterName);
        $dbUser = $this->getDbUser();

        $instance = new Erfurt_Auth_Adapter_Rdf($dbUser, 'wrongPass');
        $result = $instance->authenticate();

        $this->assertFalse($result->isValid());
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testAuthenticateAdmin($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);

        $instance = new Erfurt_Auth_Adapter_Rdf('Admin');
        $result = $instance->authenticate();
        $id = $result->getIdentity();

        $this->assertTrue($result->isValid());
        $this->assertEquals('Admin', $id->getUsername());
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testAuthenticateUserWithWrongPassword($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);

        $instance = new Erfurt_Auth_Adapter_Rdf('Admin', 'wrongPass');
        $result = $instance->authenticate();

        $this->assertFalse($result->isValid());
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testAuthenticateWithNotExistingUser($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);

        $instance = new Erfurt_Auth_Adapter_Rdf('UserDoesNotExist', 'wrongPass');
        $result = $instance->authenticate();

        $this->assertFalse($result->isValid());
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testFetchDataForAllUsers($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);

        $instance = new Erfurt_Auth_Adapter_Rdf();
        $instance->fetchDataForAllUsers();
    }

    /**
     * @dataProvider allSupportedStoresProvider
     */
    public function testGetUsers($storeAdapterName)
    {
        $this->markTestNeedsStore($storeAdapterName);

        $instance = new Erfurt_Auth_Adapter_Rdf();
        $users = $instance->getUsers();

        $this->assertTrue(is_array($users));
    }
}
