<?php
/**
 * Generated by PHPUnit on 2008-12-18 at 21:54:10.
 */
class Erfurt_AppTest extends Erfurt_TestCase
{
    public function tearDown()
    {
        Erfurt_App::reset();
    }

    public function testGetInstanceWithoutAutostart()
    {
        $app = Erfurt_App::getInstance(false);

        if (!($app instanceof Erfurt_App)) {
            $this->fail();
        }

        $this->assertFalse($app->isStarted());
    }

    public function testGetInstanceWithAutostart()
    {
        $app = Erfurt_App::getInstance();

        if (!($app instanceof Erfurt_App)) {
            $this->fail();
        }

        $this->assertTrue($app->isStarted());
    }

    public function testReset()
    {
        $app = Erfurt_App::getInstance();

        $this->assertTrue($app->isStarted());

        // Now we reset and test whether app is started (should be not).
        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false);

        $this->assertFalse($app->isStarted());
    }

    public function testStart()
    {
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
        $app = Erfurt_App::getInstance(false);

        $app->start();
        $this->assertTrue($app->isStarted());

        // Start a second time should do no harm.
        $app->start();
        $this->assertTrue($app->isStarted());
    }

    public function testStartWithVersioningException()
    {
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

    public function testStartVersioningEnabled()
    {
        $this->markTestNeedsTestConfig();
        $testConfig = $this->getTestConfig();
        $testConfig->versioning = true;

        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false)->start($testConfig);

        $this->assertInstanceOf('Erfurt_Versioning', $app->getVersioning());
        $this->assertTrue($app->getVersioning()->isVersioningEnabled(), 'Erfurt_Versioning should be enabled after start.');
    }

    public function testStartVersioningDisabled()
    {
        $this->markTestNeedsTestConfig();
        $testConfig = $this->getTestConfig();
        $testConfig->versioning = false;

        Erfurt_App::reset();
        $app = Erfurt_App::getInstance(false)->start($testConfig);

        $this->assertFalse($app->getVersioning());
    }

    public function testStartWithTimezoneNotSet()
    {
        $this->markTestNeedsTestConfig();
        $testConfig = $this->getTestConfig();
        $testConfig->timezone = false;

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

    public function testGetAc()
    {
        $ac = Erfurt_App::getInstance()->getAc();
        $this->assertInstanceOf('Erfurt_Ac_Default', $ac);
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
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->cache->lifetime = 3600;

        $cache = $app->getCache();
        $this->assertTrue($cache instanceof Erfurt_Cache_Frontend_ObjectCache);
    }

    /*public function testGetCacheWithSqliteCacheBackendSuccess()
    {
        if (!extension_loaded('sqlite')) {
            $this->markTestSkipped();
        }

        $configOptions = array(
            'cache' => array(
                'enable' => true,
                'type'   => 'sqlite',
                'sqlite' => array(
                    'dbname' => 'cache.sqlite'
                )
            )
        );
        $tmpConfig = new Zend_Config($configOptions);

        $app = Erfurt_App::getInstance(false)->start($tmpConfig);
        $cache = $app->getCache();
        $this->assertTrue($cache instanceof Erfurt_Cache_Frontend_ObjectCache);
    }*/

    public function testGetConfig()
    {
        $config = Erfurt_App::getInstance()->getConfig();
        $this->assertTrue($config instanceof Zend_Config_Ini);
    }

    /**
     * @expectedException Erfurt_Exception
     */
    public function testGetConfigWithoutLoadedConfig()
    {
        $config = Erfurt_App::getInstance(false)->getConfig();
    }

    public function testGetEventDispatcher()
    {
        $ed = Erfurt_App::getInstance()->getEventDispatcher();
        $this->assertTrue($ed instanceof Erfurt_Event_Dispatcher);
    }

    public function testGetLog()
    {
        $log = Erfurt_App::getInstance()->getLog();
        $this->assertTrue($log instanceof Zend_Log);

        $log = Erfurt_App::getInstance()->getLog('someOtherLog');
        $this->assertTrue($log instanceof Zend_Log);
    }

    public function testGetLogWithTmpDir()
    {
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->log->level = 7;
        $config->log->path  = $app->getTmpDir();

        $log = Erfurt_App::getInstance()->getLog('someOtherLog2');
        $this->assertTrue($log instanceof Zend_Log);
    }

    /**
     * Ensures that relative log directory paths are interpreted relative to the Erfurt root directory.
     */
    public function testGetLogDirUsesPathRelativeToErfurtRootDirectoryIfRelativePathIsProvided()
    {
        $app    = Erfurt_App::getInstance();
        $config = $app->getConfig();

        $config->log->path = 'tests/unit/Erfurt/_files/logs';
        $resolvedPath = $app->getLogDir();

        // Ensure that the expected directory exists.
        $expectedPath = EF_BASE . '../../tests/unit/Erfurt/_files/logs';
        $this->assertFileExists($expectedPath);
        // Normalize the path.
        $expectedPath = realpath($expectedPath) . '/';
        $this->assertEquals($expectedPath, $resolvedPath);
    }

    /**
     * Ensures that getLogDir() does not change a log directory that is
     * configured as absolute path.
     */
    public function testGetLogDirDoesNotChangeAbsolutePath()
    {
        $app    = Erfurt_App::getInstance();
        $config = $app->getConfig();

        $path = dirname(__FILE__) . '/_files/logs';
        $config->log->path = $path;
        $resolvedPath = $app->getLogDir();
        $this->assertEquals(realpath($path), realpath($resolvedPath));
    }

    /**
     * Ensures that getLogDir() adds a trailing slash to the configured
     * log directory if necessary.
     */
    public function testGetLogDirAppendsSlashToPathIfNotAvailable()
    {
        $app    = Erfurt_App::getInstance();
        $config = $app->getConfig();

        $path = dirname(__FILE__) . '/_files/logs';
        $config->log->path = $path;
        $expectedPath = $path . '/';
        $resolvedPath = $app->getLogDir();
        $this->assertEquals($expectedPath, $resolvedPath);
    }

    /**
     * Ensures that getLogDir() does not add another trailing slash if the configured
     * log path already contains one.
     */
    public function testGetLogDirDoesNotAddAnotherSlashIfItIsAlreadyConfigured()
    {
        $app    = Erfurt_App::getInstance();
        $config = $app->getConfig();

        $path = dirname(__FILE__) . '/_files/logs/';
        $config->log->path = $path;
        $resolvedPath = $app->getLogDir();
        $this->assertEquals($path, $resolvedPath);
    }

    /**
     * Ensures that getLogDir() returns false if no log directory is configured.
     */
    public function testGetLogDirReturnsFalseIfNoLogDirectoryIsConfigured()
    {
        $app    = Erfurt_App::getInstance();
        $config = $app->getConfig();

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

    /**
     * @expectedException Erfurt_Exception
     */
    public function testGetQueryCacheWithNoCacheType()
    {
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->cache->query->enable = true;
        $config->cache->query->type = NULL;

        $app->getQueryCache();
    }

    /**
     * @expectedException Erfurt_Exception
     */
    public function testGetQueryCacheWithNonExistingCacheBackend()
    {
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->cache->query->enable = true;
        $config->cache->query->type   = 'doesnotexist';

        $app->getQueryCache();
    }

    /**
     * @expectedException Erfurt_Exception
     */
    public function testGetStoreWithBackendNotSet()
    {
        $app = Erfurt_App::getInstance();
        $config = $app->getConfig();
        $config->store->backend = NULL;
        $store = Erfurt_App::getInstance()->getStore();
    }

    /**
     * @expectedException Erfurt_Exception
     */
    public function testGetStoreWithWrongBackendAndSchema()
    {
        $configOptions = array(
            'store' => array(
                'backend' => 'somethingwrong',
                'schema'  => 'doesnotexist'
            )
        );

        
        $tmpConfig = new Zend_Config($configOptions);

        $app = Erfurt_App::getInstance(false)->start($tmpConfig);
        $config = $app->getConfig();

        $store = $app->getStore();
    }

    public function testGetTmpDir()
    {
        $tmpDir = Erfurt_App::getInstance()->getTmpDir();
        $this->assertTrue($tmpDir !== false);
    }

    public function testGetVersioning()
    {
        $v = Erfurt_App::getInstance()->getVersioning();
        $this->assertTrue($v instanceof Erfurt_Versioning);
    }

    public function testGetWrapperRegistry()
    {
        $wr = Erfurt_App::getInstance()->getWrapperRegistry();
        $this->assertTrue($wr instanceof Erfurt_Wrapper_Registry);
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

        $this->assertInstanceOf('Zend_Config', $app->getConfig());
    }
}
