<?php
/**
 * Test class for Erfurt_Versioning.
 * Generated by PHPUnit on 2008-12-18 at 21:54:10.
 */
class Erfurt_AppTest extends Erfurt_TestCase
{   
    public function testGetInstanceWithWrongPhpVersion()
    {
        // We need to make sure that the constructor gets called.
        Erfurt_App::reset();
        
        $appMock = $this->getMock('Erfurt_App',
            array('_getPhpVersion'),
            array(),
            '',
            false
        );
        
        $appMock->expects($this->once())
                ->method('_getPhpVersion')
                ->will($this->returnValue('5.1.9'));
 
        try {
            $appMock->start();

            // If we reach this point, expected exception was not thrown.
            $this->fail('Wrong PHP version should lead to an error.');
        } catch (Erfurt_Exception $e) {
            // Nothing to do here.
        }     
    }
    
    public function testGetInstanceWithWrongZendVersion()
    {
        // We need to make sure that the constructor gets called.
        Erfurt_App::reset();
        
        $appMock = $this->getMock('Erfurt_App',
            array('_getZendVersion'),
            array(),
            '',
            false
        );
        
        $appMock->expects($this->once())
                ->method('_getZendVersion')
                ->will($this->returnValue('1.4.9'));
        
        try {
            $appMock->start();
            
            // If we reach this point, expected exception was not thrown.
            $this->fail('Wrong Zend version should lead to an error.');
        } catch (Erfurt_Exception $e) {
            // Nothing to do here.
        }
    }
    
    public function testGetInstanceWithoutAutostart()
    {
        // We need to make sure that the constructor gets called.
        Erfurt_App::reset();
        
        $app = Erfurt_App::getInstance(false);
        
        if (!($app instanceof Erfurt_App)) {
            $this->fail();
        }
        
        $this->assertFalse($app->isStarted());
    }
    
    public function testGetInstanceWithAutostart()
    {
        // We need to make sure that the constructor gets called.
        Erfurt_App::reset();
        
        $app = Erfurt_App::getInstance();
        
        if (!($app instanceof Erfurt_App)) {
            $this->fail();
        }
        
        $this->assertTrue($app->isStarted());
    }
    
    public function testReset()
    {
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance();
        
        $this->assertTrue($app->isStarted());
        
        // Now we reset and test whether app is started (should be not).
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false);
        
        $this->assertFalse($app->isStarted());
    }
    
    public function testStart()
    {
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false)->start();
        
        if (!($app instanceof Erfurt_App)) {
            $this->fail();
        }
        
        $this->assertTrue($app->isStarted()); 
    }
    
    public function testStartWithDebugMode()
    {
        $this->markTestNeedsTestConfig();
        $testConfig = $this->getTestConfig();
        $testConfig->debug = true;

        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false)->start($testConfig);
        
        $this->assertTrue(defined('_EFDEBUG'));
        $this->assertEquals(7, $app->getConfig()->log->level);
        $this->assertEquals((E_ALL | E_STRICT), error_reporting());
    }
    
    public function testStartAlreadyStarted()
    {
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false);
        
        $app->start();
        $this->assertTrue($app->isStarted()); 
        
        // Start a second time should do no harm.
        $app->start();
        $this->assertTrue($app->isStarted());
    }
    
    public function testStartWithVersioningException()
    {
        // We need to make sure that the constructor gets called.
        Erfurt_App::reset();
        
        $appMock = $this->getMock('Erfurt_App',
            array('getVersioning'),
            array(),
            '',
            false
        );
        
        $appMock->expects($this->once())
                ->method('getVersioning')
                ->will($this->throwException(new Erfurt_Exception()));
        
        try {
            $appMock->start();
            
            // If we reach this point, expected exception was not thrown.
            $this->fail('An exception is expected here.');
        } catch (Erfurt_Exception $e) {
            // Nothing to do here.
        }
    }
    
    public function testStartVersioningDisabled()
    {
        $this->markTestNeedsTestConfig();
        $testConfig = $this->getTestConfig();
        $testConfig->versioning = false;

        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false)->start($testConfig);
        
        $this->assertFalse($app->getVersioning()->isVersioningEnabled());
    }
    
    public function testStartWithTimezoneNotSet()
    {
        $this->markTestNeedsTestConfig();
        $testConfig = $this->getTestConfig();
        $testConfig->timezone = false;
        
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false)->start($testConfig);
        
        $this->assertEquals('Europe/Berlin', date_default_timezone_get());
    }
    
    public function testAddOpenIdUser()
    {   
        $user  = 'http://openid.example.org/exampleuser';
        $email = 'me@example.org';
        $label = 'Example User';
        $group = 'http://example.org/DefaultGroup';
        
        $config = Erfurt_App::getInstance()->getConfig();
        $acModelUri = $config->ac->modelUri;
              
        $acModelStub = new Erfurt_Rdf_ModelStub($acModelUri);
        
        $appMock = $this->getMock('Erfurt_App', array('getAcModel'), array(), '', false);
        $appMock->start();
        $appMock->expects($this->once())
                ->method('getAcModel')
                ->will($this->returnValue($acModelStub));
        
        $retVal = $appMock->addOpenIdUser($user, $email, $label, $group);
        
        $this->assertTrue(isset($acModelStub->getStore()->statements[$acModelUri][$user]));
        $this->assertTrue(isset($acModelStub->getStore()->statements[$acModelUri][$group]));
        $this->assertEquals(3, count($acModelStub->getStore()->statements[$acModelUri][$user]));
        $this->assertEquals(1, count($acModelStub->getStore()->statements[$acModelUri][$group]));
        $this->assertTrue($retVal);
    }
    
    public function testAddUser()
    {
        $user    = 'TestUser';
        $userUri = 'http://localhost/OntoWiki/Config/TestUser';
        $pw      = 'testpass';
        $email   = 'me@example.org';
        $group   = 'http://example.org/DefaultGroup';
        
        $config = Erfurt_App::getInstance()->getConfig();
        $acModelUri = $config->ac->modelUri;
              
        $acModelStub = new Erfurt_Rdf_ModelStub($acModelUri);
        
        $appMock = $this->getMock('Erfurt_App', array('getAcModel'), array(), '', false);
        $appMock->start();
        $appMock->expects($this->once())
                ->method('getAcModel')
                ->will($this->returnValue($acModelStub));
      
        $retVal = $appMock->addUser($user, $pw, $email, $group);

        $this->assertTrue(isset($acModelStub->getStore()->statements[$acModelUri][$userUri]));
        $this->assertTrue(isset($acModelStub->getStore()->statements[$acModelUri][$group]));
        $this->assertEquals(4, count($acModelStub->getStore()->statements[$acModelUri][$userUri]));
        $this->assertEquals(1, count($acModelStub->getStore()->statements[$acModelUri][$group]));
        $this->assertTrue($retVal);
    }
    
/*
    public function testAuthenticateWithDefaultAnonymous()
    {
        // Authenticate as Anonymous
        $result = Erfurt_App::getInstance()->authenticate();
        $this->assertTrue($result->isValid());
        $identity = $result->getIdentity();
        $this->assertEquals('Anonymous', $identity->getUsername());
    }
*/
    
/*
    public function testAuthenticateWithExplicitAnonymous()
    {
        // Authenticate as Anonymous
        $result = Erfurt_App::getInstance()->authenticate('Anonymous');
        $this->assertTrue($result->isValid());
        $identity = $result->getIdentity();
        $this->assertEquals('Anonymous', $identity->getUsername());
    }
*/
        
    public function testAuthenticateWithAdmin()
    {
        Erfurt_App::reset();
        $this->markTestNeedsDatabase();
        
        // Authenticate as Anonymous
        $result = Erfurt_App::getInstance()->authenticate('Admin');
        $this->assertTrue($result->isValid());
        $identity = $result->getIdentity();
        $this->assertEquals('Admin', $identity->getUsername());
    }
    
    public function testAuthenticateWithAdminWrongPassword()
    {
        $this->markTestNeedsDatabase();
        
        // Authenticate as Anonymous
        $result = Erfurt_App::getInstance()->authenticate('Admin', 'theWrongPassword');
        $this->assertFalse($result->isValid());
    }
    
    public function testAuthenticateWithDefaultSuperAdmin()
    {
        $this->markTestNeedsDatabase();
        
        // Authenticate as Anonymous
        $result = Erfurt_App::getInstance()->authenticate($this->getDbUser(), $this->getDbPassword());
        $this->assertTrue($result->isValid());
        $identity = $result->getIdentity();
        $this->assertEquals('SuperAdmin', $identity->getUsername());
    }

    public function testAuthenticateWithOpenIdWillFail()
    {
        $this->markTestNeedsDatabase();
        
        // OpenId for a user that does not exist!
        $openId      = 'http://thisisnotanopenidprovider.com/fakeOpenId';
        $verifyUrl   = 'http://doesnotmatterhere.com';
        $redirectUrl = 'http://doesnotmatterhere.com';
        
        $result = Erfurt_App::getInstance()->authenticateWithOpenId($openId, $verifyUrl, $redirectUrl);
        
        $this->assertTrue($result instanceof Zend_Auth_Result);
        $this->assertFalse($result->isValid());
        
        // Erfurt (versioning) needs a user...
        $this->authenticateAnonymous();
        
        // Now we add the user, so we can test whether a non existing provider url also fails.
        Erfurt_App::getInstance()->addOpenIdUser($openId);
        
        $result = Erfurt_App::getInstance()->authenticateWithOpenId($openId, $verifyUrl, $redirectUrl);
        $this->assertTrue($result instanceof Zend_Auth_Result);
        $this->assertFalse($result->isValid());

        // We only test cases here that will fail, for otherwise we would be redirected!
    }
    
    public function testGetAc()
    { 
        $ac = Erfurt_App::getInstance()->getAc(); 
        
        if (!($ac instanceof Erfurt_Ac_Default)) {
            $this->fail();
        }
    }
    
    public function testGetAcModel()
    {
        $config = Erfurt_App::getInstance()->getConfig();
        $acModelUri = $config->ac->modelUri;
        
        $storeMock = $this->getMock('Erfurt_Store',
            array('getModel'),
            array(),
            '',
            false
        );
        
        $storeMock->expects($this->once())
                  ->method('getModel')
                  ->will($this->returnValue(new Erfurt_Rdf_Model($acModelUri)));
        
        $appMock = $this->getMock('Erfurt_App',
            array('getStore'),
            array(),
            '',
            false
        );
        $appMock->loadConfig();
        
        $appMock->expects($this->once())
              ->method('getStore')
              ->will($this->returnValue($storeMock));
              
         $acModel = $appMock->getAcModel();
        
         if (!($acModel instanceof Erfurt_Rdf_Model)) {
             $this->fail();
         }
         
         $this->assertEquals($acModelUri, $acModel->getModelUri());
    }
    
    public function testGetActionConfig()
    {
        $acMock = $this->getMock('Erfurt_Ac_Default', array('getActionConfig'));
        $appMock = $this->getMock('Erfurt_App', array('getAc'), array(), '', false);
        
        $appMock->expects($this->once())
                ->method('getAc')
                ->will($this->returnValue($acMock));
        
        $acMock->expects($this->once())
               ->method('getActionConfig');
        
        $appMock->getActionConfig(array());
    }
    
    public function testGetAuth()
    {
        $auth = Erfurt_App::getInstance()->getAuth();
        $this->assertTrue($auth instanceof Zend_Auth);
    }
    
    public function testGetCache()
    {
        $cache = Erfurt_App::getInstance()->getCache();
        $this->assertTrue($cache instanceof Erfurt_Cache_Frontend_ObjectCache);
    }
    
    public function testGetCacheWithLifetime()
    {
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->cache->lifetime = 3600;
        
        $cache = $app->getCache();
        $this->assertTrue($cache instanceof Erfurt_Cache_Frontend_ObjectCache);
    }
    
    public function testGetCacheWithDatabaseCacheBackend()
    {   
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->cache->enable = true;
        $config->cache->type   = 'database';
        
        $cache = $app->getCache();
        $this->assertTrue($cache instanceof Erfurt_Cache_Frontend_ObjectCache);
    }
    
    public function testGetCacheWithSqliteCacheBackendSuccess()
    {   
        if (!extension_loaded('sqlite')) {
            $this->markTestSkipped();
        }

        Erfurt_App::reset();
        
        $configOptions = array(
            'cache' => array(
                'sqlite' => array(
                    'dbname' => 'cache.sqlite'
                )
            )
        );
        
        require_once 'Zend/Config.php';
        $tmpConfig = new Zend_Config($configOptions);
        
        $app = Erfurt_App::getInstance(false)->start($tmpConfig);
        $config = $app->getConfig();
        $config->cache->enable = true;
        $config->cache->type   = 'sqlite';
        $config->cache->sqlite->dbname = 'cache.sqlite';
        
        $cache = $app->getCache();
        $this->assertTrue($cache instanceof Erfurt_Cache_Frontend_ObjectCache);
    }
    
    public function testGetCacheDir()
    {
        $app    = Erfurt_App::getInstance();
        $config = $app->getConfig(); 
        
        $cachePath = $app->getCacheDir();
        $this->assertFalse($cachePath);
        
        $config->cache->path = 'cache/';
        
        // Check if cache dir is writeable. If not, skip the test because of
        // getCacheDir returned false.
        if ( false === is_writable($config->cache->path) )
        {
            $this->markTestSkipped( 'Cache dir '. $config->cache->path . ' isnt writeable.' );
        }
        else
        {
            $cachePath = $app->getCacheDir();
            $this->assertEquals(EF_BASE.'cache/', $cachePath);
        }
    }
    
    public function testGetConfig()
    {
        $config = Erfurt_App::getInstance()->getConfig();
        $this->assertTrue($config instanceof Zend_Config_Ini);
    }
    
    public function testGetConfigWithoutLoadedConfig()
    {
        Erfurt_App::reset();
        
        try {
            $config = Erfurt_App::getInstance(false)->getConfig();
            
            $this->fail();
        } catch (Erfurt_Exception $e) {
            // Nothing to do here.
        }
        
        Erfurt_App::reset();
    }
    
    public function testGetEventDispatcher()
    {
        $ed = Erfurt_App::getInstance()->getEventDispatcher();
        $this->assertTrue($ed instanceof Erfurt_Event_Dispatcher);
    }
    
    public function testGetLog()
    {
        Erfurt_App::reset();
        
        $log = Erfurt_App::getInstance()->getLog();
        $this->assertTrue($log instanceof Zend_Log);
        
        $log = Erfurt_App::getInstance()->getLog('someOtherLog');
        $this->assertTrue($log instanceof Zend_Log);
    }
    
    public function testGetLogWithTmpDir()
    {
        Erfurt_App::reset();
        
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->log->level = 7;
        $config->log->path  = $app->getTmpDir();
        
        $log = Erfurt_App::getInstance()->getLog('someOtherLog2');
        $this->assertTrue($log instanceof Zend_Log);
    }
    
    public function testGetLogDir()
    {
         $app    = Erfurt_App::getInstance();
         $config = $app->getConfig(); 

         $config->log->path = 'logs';
         $expectedPath = false;
         $resolvedPath = $app->getLogDir();
         $this->assertEquals($expectedPath, $resolvedPath);

         $config->log->path = '/tmp';
         $expectedPath = '/tmp/';
         $resolvedPath = $app->getLogDir();
         $this->assertEquals($expectedPath, $resolvedPath);
         
         $config->log->path = '/tmp/';
         $expectedPath = '/tmp/';
         $resolvedPath = $app->getLogDir();
         $this->assertEquals($expectedPath, $resolvedPath);

         unset($config->log->path);
         $expectedPath = false;
         $resolvedPath = $app->getLogDir();
         $this->assertEquals($expectedPath, $resolvedPath);
    }
    
    public function testGetPluginManager()
    {
        $pm = Erfurt_App::getInstance()->getPluginManager();
        $this->assertTrue($pm instanceof Erfurt_Plugin_Manager);
    }
    
    public function testGetQueryCache()
    {
        $qc = Erfurt_App::getInstance()->getQueryCache();
        $this->assertTrue($qc instanceof Erfurt_Cache_Frontend_QueryCache);
    }
    
    public function testGetQueryCacheWithNoCacheType()
    {   
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->cache->query->enable = true;
        
        try {
            $app->getQueryCache();
            
            $this->fail('Failure expected');
        } catch (Erfurt_Exception $e) {
            
        }
    }
    
    public function testGetQueryCacheWithDatabaseCacheBackend()
    {   
        Erfurt_App::reset();
        $this->markTestNeedsDatabase();
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->cache->query->enable = true;
        $config->cache->query->type = 'database';
        
        $cache = $app->getQueryCache();
        $this->assertTrue($cache instanceof Erfurt_Cache_Frontend_QueryCache);
    }
    
    public function testGetQueryCacheWithNonExistingCacheBackend()
    {
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->cache->query->enable = true;
        $config->cache->query->type   = 'doesnotexist';
        
        try {
            $app->getQueryCache();
            
            $this->fail('Failure expected');
        } catch (Erfurt_Exception $e) {
            
        }
    }
    
    public function testGetStore()
    {
        Erfurt_App::reset();
        $this->markTestNeedsDatabase();
        
        $store = Erfurt_App::getInstance()->getStore();
        $this->assertTrue($store instanceof Erfurt_Store);
    }
    
    public function testGetStoreWithBackendNotSet()
    {
        Erfurt_App::reset();
        
        $app = Erfurt_App::getInstance();
        
        try {
            $store = Erfurt_App::getInstance()->getStore();
            
            $this->fail();
        } catch (Erfurt_Exception $e) {
            
        }
    }
    
    public function testGetStoreWithWrongBackendAndSchema()
    {
        Erfurt_App::reset();
        
        $configOptions = array(
            'store' => array(
                'backend' => 'somethingwrong', 
                'schema'  => 'doesnotexist'
            )
        );
        
        require_once 'Zend/Config.php';
        $tmpConfig = new Zend_Config($configOptions);
                
        $app = Erfurt_App::getInstance(false)->start($tmpConfig);
        $config = $app->getConfig();
        
        try {
            $store = $app->getStore();
            
            $this->fail();
        } catch (Erfurt_Exception $e) {
            
        }
    }
    
    public function testGetStoreWithCleanDatabase()
    {
        Erfurt_App::reset();
        $this->markTestNeedsCleanZendDbDatabase();
        
        try {
            $store = Erfurt_App::getInstance()->getStore();
        } catch (Erfurt_Exception $e) {
            // Should not fail! Instead should initialize the db tables.
            $this->fail('Something went wrong while initialization of new db environment: ' . $e->getMessage());
        }
    }   
    
    public function testGetSysOntModel()
    {
        $this->markTestNeedsDatabase();
        
        $config      = Erfurt_App::getInstance()->getConfig();
        $sysModelUri = $config->sysont->modelUri;
        
        $sysModel = Erfurt_App::getInstance()->getSysOntModel();
        $this->assertTrue($sysModel instanceof Erfurt_Rdf_Model);
        $this->assertEquals($sysModelUri, $sysModel->getModelUri());
    }
    
    public function testGetTmpDir()
    {
        $tmpDir = Erfurt_App::getInstance()->getTmpDir();
        $this->assertTrue($tmpDir !== false);
    }
    
    public function testGetUsers()
    {
        $this->markTestNeedsDatabase();
        
        $users = Erfurt_App::getInstance()->getUsers();

        $this->assertTrue(array_key_exists('http://localhost/OntoWiki/Config/Admin', $users));
        $this->assertTrue(array_key_exists('http://ns.ontowiki.net/SysOnt/Anonymous', $users));
    }
    
    public function testGetVersioning()
    {
        $v = Erfurt_App::getInstance()->getVersioning();
        $this->assertTrue($v instanceof Erfurt_Versioning);
    }
    
    public function testGetWrapperManager()
    {
        $wm = Erfurt_App::getInstance()->getWrapperManager();
        $this->assertTrue($wm instanceof Erfurt_Wrapper_Manager); 
    }
    
    public function testGetWrapperRegistry()
    {
        $wr = Erfurt_App::getInstance()->getWrapperRegistry();
        $this->assertTrue($wr instanceof Erfurt_Wrapper_Registry);
    }
    
    public function testIsActionAllowed()
    {        
        $this->markTestNeedsDatabase();
        
        $app = Erfurt_App::getInstance();
        $ac = $app->getAc();
        
        $this->authenticateAnonymous();
        
        $this->assertEquals(
            $ac->isActionAllowed('SomeNonExistingAction'), 
            $app->isActionAllowed('SomeNonExistingAction')
        );
        
        // Now test with an existing action (Login)
        $this->assertEquals(
            $ac->isActionAllowed('Login'), 
            $app->isActionAllowed('Login')
        );
    }
    
    public function testIsStarted()
    {
        $app = Erfurt_App::getInstance();
        $this->assertTrue($app->isStarted());
    }
    
    public function testLoadConfig()
    {
        $app = Erfurt_App::getInstance();
        $app->loadConfig();
    }
    
    public function testVerifyOpenIdResult()
    {
        $this->markTestNeedsDatabase();
        
        $get = array();
        $result = Erfurt_App::getInstance()->verifyOpenIdResult($get);
        $this->assertFalse($result->isValid());
    }
}
