<?php
class Erfurt_Auth_Adapter_RdfIntegrationTest extends Erfurt_TestCase
{
    public function testAuthenticateSuperAdmin()
    {
        $this->markTestNeedsTestConfig();
        $this->markTestNeedsDatabase();
        $dbUser = $this->getDbUser();
        $dbPassword = $this->getDbPassword();
        
        $instance = new Erfurt_Auth_Adapter_Rdf($dbUser, $dbPassword);
        $result = $instance->authenticate();
        $id = $result->getIdentity();

        $this->assertTrue($result->isValid());
        $this->assertEquals('SuperAdmin', $id->getUsername());
        $this->assertTrue($id->isDbUser());
    }
    
    public function testAuthenticateSuperAdminWithWrongPassword()
    {
        $this->markTestNeedsTestConfig();
        $this->markTestNeedsDatabase();
        $dbUser = $this->getDbUser();
        
        $instance = new Erfurt_Auth_Adapter_Rdf($dbUser, 'wrongPass');
        $result = $instance->authenticate();

        $this->assertFalse($result->isValid());
    }
    
    public function testAuthenticateAdmin()
    {
        $this->markTestNeedsDatabase();
        
        $instance = new Erfurt_Auth_Adapter_Rdf('Admin');
        $result = $instance->authenticate();
        $id = $result->getIdentity();

        $this->assertTrue($result->isValid());
        $this->assertEquals('Admin', $id->getUsername());
    }
    
    public function testAuthenticateUserWithWrongPassword()
    {
        $this->markTestNeedsDatabase();
        
        $instance = new Erfurt_Auth_Adapter_Rdf('Admin', 'wrongPass');
        $result = $instance->authenticate();

        $this->assertFalse($result->isValid());
    }
    
    public function testAuthenticateWithNotExistingUser()
    {
        $this->markTestNeedsDatabase();
        
        $instance = new Erfurt_Auth_Adapter_Rdf('UserDoesNotExist', 'wrongPass');
        $result = $instance->authenticate();

        $this->assertFalse($result->isValid());
    }
    
    public function testFetchDataForAllUsers()
    {
        $this->markTestNeedsDatabase();
        
        $instance = new Erfurt_Auth_Adapter_Rdf();
        $instance->fetchDataForAllUsers();
    }
    
    public function testGetUsers()
    {
        $this->markTestNeedsDatabase();
        
        $instance = new Erfurt_Auth_Adapter_Rdf();
        $users = $instance->getUsers();
        
        $this->assertTrue(is_array($users));
    }
}
