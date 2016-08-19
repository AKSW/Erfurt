<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_TestCase extends PHPUnit_Framework_TestCase
{
    protected $_dbWasUsed       = false;

    private $_testConfig        = null;
    private $_customTestConfig  = null;

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
            // TODO add a way to specify that a test modified the sysonts
            $store->deleteModel($config->sysont->modelUri);
            $store->deleteModel($config->sysont->schemaUri);

            $this->_dbWasUsed = false;
        }

        $this->_testConfig = null; // force reload on each test e.g. because of db params
        Erfurt_App::reset();
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
        $this->markTestNeedsTestConfig();

        $dbName = null;
        if ($this->_testConfig->store->backend === 'virtuoso') {
            if (isset($this->_testConfig->store->virtuoso->dsn)) {
                $dbName = $this->_testConfig->store->virtuoso->dsn;
            }
        } else if ($this->_testConfig->store->backend === 'zenddb') {
            if (isset($this->_testConfig->store->zenddb->dbname)) {
                $dbName = $this->_testConfig->store->zenddb->dbname;
            }
        } else if ($this->_testConfig->store->backend === 'stardog') {
            if (isset($this->_testConfig->store->stardog->database)) {
                $dbName = $this->_testConfig->store->stardog->database;
            }
        }

        // make sure a test db was selected!
        if ((null === $dbName) || (substr($dbName, -5) !== '_TEST')) {
            $this->markTestSkipped('The $dbName is not a valide test-database name: "' . $dbName . '"');
        }

        try {
            $store = Erfurt_App::getInstance()->getStore();
            $store->checkSetup();
            $this->_dbWasUsed = true;
        } catch (Erfurt_Store_Exception $e) {
            if ($e->getCode() === 20) {
                // Setup successful
                $this->_dbWasUsed = true;
            } else {
                $this->markTestSkipped(
                    'An Erfurt_Store_Exception occurred when establishing a connection: ' . $e->getMessage()
                );
            }
        } catch (Erfurt_Exception $ee) {
            $this->markTestSkipped('An Erfurt_Exception occurred when establishing a connection: ' . $ee->getMessage());
        }

        $config = Erfurt_App::getInstance()->getConfig();

        $this->assertTrue(Erfurt_App::getInstance()->getStore()->isModelAvailable($config->sysont->modelUri, false));
        $this->assertTrue(Erfurt_App::getInstance()->getStore()->isModelAvailable($config->sysont->schemaUri, false));

        $this->authenticateAnonymous();
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

    public function markTestNeedsTestConfig(Zend_Config $config = null)
    {
        $this->_loadTestConfig($config);

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
        if ($this->_testConfig->store->backend !== 'virtuoso') {
            $this->markTestSkipped('Skipped since other backend is under test.');
        }

        $this->markTestNeedsDatabase();
    }

    public function markTestNeedsZendDb()
    {
        $this->markTestNeedsTestConfig();
        if ($this->_testConfig->store->backend !== 'zenddb') {
            $this->markTestSkipped('Skipped since other backend is under test.');
        }

        $this->markTestNeedsDatabase();
    }

    public function markTestNeedsStardog()
    {
        $this->markTestNeedsTestConfig();
        if ($this->_testConfig->store->backend !== 'stardog') {
            $this->markTestSkipped('Skipped since other backend is under test.');
        }

        $this->markTestNeedsDatabase();
    }

    private function _loadTestConfig(Zend_Config $config = null)
    {
        if (null === $this->_customTestConfig) {
            if (is_readable(_TESTROOT . 'config.ini')) {
                $this->_customTestConfig = new Zend_Config_Ini(
                    (_TESTROOT . 'config.ini'),
                    'private',
                    array('allowModifications' => true)
                );
            } else if (is_readable(_TESTROOT . 'config.ini.dist')) {
                $this->_customTestConfig = new Zend_Config_Ini(
                    (_TESTROOT . 'config.ini.dist'),
                    'private',
                    array('allowModifications' => true)
                );
            } else {
                $this->_customTestConfig = false;
            }

            if ($this->_customTestConfig !== false) {
                // merge with injected config if given
                if (null !== $config) {
                    try {
                        $this->_customTestConfig->merge($config);
                    } catch (Zend_Config_Exception $e) {
                        $this->markTestSkipped('Error while merging with injected config.');
                    }
                }

                // overwrite store adapter to use with environment variable if set
                // this is useful, when we want to test with different stores without manually
                // editing the config
                $storeAdapter = getenv('EF_STORE_ADAPTER');
                if (($storeAdapter === 'virtuoso') || ($storeAdapter === 'zenddb') || ($storeAdapter === 'stardog')) {
                    $this->_customTestConfig->store->backend = $storeAdapter;
                } else if ($storeAdapter !== false) {
                    throw new Exception('Invalid value of $EF_STORE_ADAPTER: ' . $storeAdapter);
                }
            }
        }

        $app = Erfurt_App::getInstance(false);

        // We always reload the config in Erfurt, for a test may have changed values
        // and we need a clean environment.
        if ($this->_customTestConfig !== false && $this->_customTestConfig !== null) {
            $app->loadConfig($this->_customTestConfig);
        } else {
            $app->loadConfig();
        }
        $this->_testConfig = $app->getConfig();

        // Disable versioning
        $versioning = $app->getVersioning();
        if ($versioning != false) {
            $versioning->enableVersioning(false);
        }

        // For tests we have no session!
        $auth = Erfurt_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_NonPersistent());
        $app->setAuth($auth);
    }

    /**
     * Asserts that statement sets are the same.
     *
     * @param  array  $expected
     * @param  array  $got
     * @param  string $message
     */
    public static function assertStatementsEqual($expected, $got, $message = '')
    {
        $expectedS = array_keys($expected);
        sort($expectedS);
        $gotS = array_keys($got);
        sort($gotS);
        self::assertEquals($expectedS, $gotS, $message);

        $sortFn = function(array $a, array $b) {
            // The attributes that are used for sorting, in descending order.
            $sortAttributes = array('value', 'type', 'xml:lang');
            foreach ($sortAttributes as $key) {
                $valueA = isset($a[$key]) ? $a[$key] : '';
                $valueB = isset($b[$key]) ? $b[$key] : '';
                $result = strcmp($valueA, $valueB);
                if ($result !== 0) {
                    return $result;
                }
            }
            return 0;
        };

        foreach ($expectedS as $s) {
            $expectedP = array_keys($expected[$s]);
            sort($expectedP);
            $gotP = array_keys($got[$s]);
            sort($gotP);
            self::assertEquals($expectedP, $gotP, $message);

            foreach ($expectedP as $p) {
                usort($expected[$s][$p], $sortFn);
                usort($got[$s][$p], $sortFn);
                self::assertEquals($expected[$s][$p], $got[$s][$p], $message);
            }
        }
    }
}
