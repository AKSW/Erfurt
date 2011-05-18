<?php
require_once realpath(dirname(__FILE__) . '/..') . '/test_base.php';
require_once 'Erfurt/App.php';

class Erfurt_TestCase extends PHPUnit_Framework_TestCase
{
    private $_dbWasUsed      = false;
    private $_testConfig     = null;
    
    public function __construct($name = null, $data = array(), $dataName = '')
    {
        // error_reporting(E_ALL | E_STRICT);
        
        parent::__construct($name, $data, $dataName);
        
        Erfurt_App::getInstance();
    }
    
    protected function tearDown()
    {
        // If test case used the database, we delete all models in order to clean up th environment
        if ($this->_dbWasUsed) {
            $this->authenticateDbUser();
            $store = Erfurt_App::getInstance()->getStore();
            $config = Erfurt_App::getInstance()->getConfig();

            foreach ($store->getAvailableModels(true) as $graphUri => $true) {
                if ($graphUri !== $config->sysont->schemaUri && $graphUri !== $config->sysont->modelUri) {
                    $store->deleteModel($graphUri);
                }              
            }
            
            // Delete system models after all other models are deleted.
            $store->deleteModel($config->sysont->modelUri);
            $store->deleteModel($config->sysont->schemaUri);
            
            $this->_dbWasUsed = false;
        }
    }
    
    public function authenticateAnonymous()
    {
        Erfurt_App::getInstance()->authenticate();
    }
    
    public function authenticateDbUser()
    {
        $store = Erfurt_App::getInstance()->getStore();
        $dbUser = $store->getDbUser();
        $dbPass = $store->getDbPassword();
        Erfurt_App::getInstance()->authenticate($dbUser, $dbPass);
    }
    
    public function getDbUser()
    {
        $store = Erfurt_App::getInstance()->getStore();
        return $store->getDbUser();
    }
    
    public function getDbPassword()
    {
        $store = Erfurt_App::getInstance()->getStore();
        return $store->getDbPassword();
    }
    
    public function markTestNeedsDatabase()
    {
        if (EF_TEST_CONFIG_SKIP_DB_TESTS) {
            $this->markTestSkipped();
        }
        
        $this->_loadTestConfig();
        
        if ($this->_testConfig === false) {
            $this->markTestSkipped();
        }
        
        $this->authenticateAnonymous();
        
        try {
            $store = Erfurt_App::getInstance()->getStore();
            $store->checkSetup();
            $this->_dbWasUsed = true;
        } catch (Erfurt_Store_Exception $e) {
            if ($e->getCode() === 20) {
                // Setup successfull
                $this->_dbWasUsed = true;
            } else {
                $this->markTestSkipped();
            }
        } catch (Erfurt_Exception $e2) {
            $this->markTestSkipped();
        }
    }
    
    public function markTestNeedsCleanZendDbDatabase()
    {
        $this->markTestNeedsZendDb();
        
        $store = Erfurt_App::getInstance()->getStore();
        $sql = 'DROP TABLE IF EXISTS ' . implode(',', $store->listTables()) . ';';
        $store->sqlQuery($sql);
        
        // We do not clean up the db on tear down, for it is empty now.
        $this->_dbWasUsed = false;
        Erfurt_App::reset();
        
        $this->_loadTestConfig();
    }
    
    public function markTestUsesDb()
    {
        $this->_dbWasUsed = true;
    }
    
    public function markTestNeedsTestConfig()
    {
        $this->_loadTestConfig();

        if ($this->_testConfig === false) {
            $this->markTestSkipped();
        }
    }
    
    public function getTestConfig()
    {
        return $this->_testConfig;
    }
    
    public function markTestNeedsVirtuoso()
    {
        $this->markTestNeedsTestConfig();
        $this->_testConfig->store->backend = 'virtuoso';
        $this->markTestNeedsDatabase();
    }
    
    public function markTestNeedsZendDb()
    {
        $this->markTestNeedsDatabase();
        
        if ($this->_testConfig->store->backend !== 'zenddb') {
            $this->markTestSkipped();
        }
    }
    
    private function _loadTestConfig()
    {
        if (null === $this->_testConfig) {
            if (is_readable(_TESTROOT . 'config.ini')) {
                require_once 'Zend/Config/Ini.php';
                $this->_testConfig = new Zend_Config_Ini((_TESTROOT . 'config.ini'), 'private', true);
            } else {
                $this->_testConfig = false;
            }
        }

        // We always reload the config in Erfurt, for a test may have changed values 
        // and we need a clean environment.
        if ($this->_testConfig !== false) {
            Erfurt_App::getInstance()->loadConfig($this->_testConfig);
        } else {
            Erfurt_App::getInstance()->loadConfig();
        }
    }
}
