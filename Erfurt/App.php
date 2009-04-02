<?php
/**
 * Erfurt application class
 *
 * @package app
 * @version $Id$
 */
class Erfurt_App 
{   
    /** constant that contains the minimum supported php version */ 
    const EF_MIN_PHP_VERSION  = '5.2.0';
	const EF_MIN_ZEND_VERSION = '1.5.0';
    
    /**
     * The singleton instance of this class which is returned on request.
     *
     * @var Erfurt_App
     */ 
    private static $_instance = false;
    
    /** @var */
    private $_config = false;
    
    /** @var Erfurt_EventDispatcher event dispatcher */
    private $_ed = false;
    
    /** @var object for plugin manager */
    private $_pluginManager = false;
    
    /** @var */
    private $_store = false;
    
    /** @var object auth instance */
    private $_auth = false;
    
    /** @var */
    private $_authAdapter = false;
    
    /** @var */
    private $_sysOntModel = false;
    
    /** @var object instance of model-object */
    private $_acModel = false;
    
    /** @var object instance of ac-object */
    private $_ac = false;
    
    /** @var */
    private $_cache = false;
    
    /** @var */
    private $_cacheBackend = false;
    
    /** @var Zend_Log */
    private $_log = false;

    /** @var */
    private $_versioning = false;
    
    /**
     * constructor
     *
     * @param object configuration parameters
     */
    private function __construct() {
                
        if (!version_compare(phpversion(), self::EF_MIN_PHP_VERSION, '>=')) {
            require_once 'Erfurt/Exception.php';
			throw new Erfurt_Exception('Erfurt requires at least PHP version ' . self::EF_MIN_PHP_VERSION);
        }
        
        define('EF_BASE', rtrim(dirname(__FILE__), '\\/') . '/');
        
        // update the include path, such that libraries like e.g. Zend are available        
        $include_path  = get_include_path() . PATH_SEPARATOR;
        $include_path .= EF_BASE . 'libraries/' . PATH_SEPARATOR;
        set_include_path($include_path);
        
		// Check whethe Zend is loaded with the right version.
		require_once 'Zend/Version.php';
		if (!version_compare(Zend_Version::VERSION, self::EF_MIN_ZEND_VERSION, '>=')) {
			require_once 'Erfurt/Exception.php';
			throw new Erfurt_Exception('Erfurt requires at least Zend Framework in version ' . self::EF_MIN_ZEND_VERSION);
		}


// TODO better way for vocabs?!
        // include the vocabulary file
        require_once EF_BASE . 'include/vocabulary.php';

// TODO do that in a better way!
        //$GLOBALS['RAP']['conf']['database']['tblStatements'] = 'statements';
        
// TODO source out from here            
        // check for new installation
        //$this->_checkNewInstallation($config);
    }
    
    /** singleton pattern makes clone unavailable */
    private function __clone()
    {}
    
    /**
     * @throws Erfurt_Exception
     */ 
    public function getSysOntModel() {
        
        $config = $this->getConfig();
        $this->_sysOntModel = $this->getStore()->getModel($config->sysOnt->modelUri, false);
        
        return $this->_sysOntModel;
    }
    
    /**
     * returns ac instance
     * 
     * @throws Erfurt_Exception
     */
    public function getAcModel() {
        
        $config = $this->getConfig();
        $this->_acModel = $this->getStore()->getModel($config->ac->modelUri, false);
        
        return $this->_acModel;
    }
    
    /**
     * returns ac instance
     * 
     * @throws Erfurt_Exception
     */
    public function getAc() {
        
        if (!$this->_ac) {
// TODO remove default action conf
            #$defaultActionConf = include(EF_INCLUDE_DIR . '/include/actions.ini.php');
            require_once 'Erfurt/Ac/Default.php';
            $this->_ac = new Erfurt_Ac_Default();
        }
        
        return $this->_ac;
    }
    
    /**
     * singleton
     */
    public static function getInstance() {
        
        if (self::$_instance === false) {
            self::$_instance = new Erfurt_App();
// TODO auto start the app?
        }
        
        return self::$_instance;
    }
    
    public function getTempDir()
    {
        $tmpDir = EF_BASE . 'tmp/';
        
        if (is_readable($tmpDir) && is_writable($tmpDir)) {
            return $tmpDir;
        } else {
            return false;
        }
    }
    
    /**
     * @throws Erfurt_Exception Throws an exception if the connection to the backend server fails.
     */
    public static function start(Zend_Config $config = null) 
    {   
        $start = microtime(true);
        
        $inst = self::getInstance();
        $inst->loadConfig($config);
        
        // check for debugging mode
        $config = $inst->getConfig();   
        if ((boolean)$config->debug === true) {
            error_reporting(E_ALL | E_STRICT);
            if (!defined('_EFDEBUG')) {
                define('_EFDEBUG', 1);
            }
// TODO handle timezone settings
            date_default_timezone_set('Europe/Berlin');
            $config->efloglevel = 7;
        }
                
        try {
            // Access the store in order to test the database connection.
            $inst->getStore();
        } catch (Erfurt_Store_Adapter_Exception $e) {
            if ($e->getCode() === 10) {
                // In this case the db environment was not initialized... It should be initialized now.
                // Do nothing.
            } else {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception($e->getMessage(), -1);
            }
        }

        // Starting Versioning
        try {
            $versioning = $inst->getVersioning();
            if ((boolean)$config->versioning === true) {
                $versioning->enableVersioning(true);
            } else {
                $versioning->enableVersioning(false);
            }
        } catch (Erfurt_Exception $e) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception($e->getMessage(), -1);
        }
        
        $inst->getLog()->debug(PHP_EOL . PHP_EOL . PHP_EOL);
        $time = (microtime(true) - $start)*1000;
        $inst->getLog()->debug('Erfurt_App: Started. (' . $time . ' ms)'); 
                
        return $inst;
    }
    
    public function loadConfig(Zend_Config $config = null) {
       
        // load the default erfurt config
        require_once 'Zend/Config/Ini.php';
        $this->_config = new Zend_Config_Ini((EF_BASE . 'config/default.ini'), 'default', true);

		// load user config iff available
		if (is_readable((EF_BASE . 'config.ini'))) {
			$this->_config->merge(new Zend_Config_Ini((EF_BASE . 'config.ini'), 'private', true));
		}
	
        // merge with injected config iff given
        if (null !== $config) {
            $this->_config->merge($config);
        }
    }
    
    /**
     * @throws Erfurt_Exception
     */
    public function getConfig() {
        
        if (!$this->_config) {
// TODO error code
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('config not loaded');
        } else {
            return $this->_config;
        }
    }
    
    /**
     * @throws Erfurt_Exception
     * @throws Erfurt_Exception
     */
    public function getLog() {
 
        if (!$this->_log) {
            $config = $this->getConfig();
        
            if ((boolean)$config->efloglevel != false) {
                $logDir = EF_BASE . 'logs/'; 
                
                if (!is_writable($logDir)) {
                    require_once 'Zend/Log/Writer/Null.php';
                    $logWriter = new Zend_Log_Writer_Null();
                } else {
                    require_once 'Zend/Log/Writer/Stream.php';
                    $logWriter = new Zend_Log_Writer_Stream($logDir . 'erfurt.log');    
                }
            } else {
                require_once 'Zend/Log/Writer/Null.php';
                $logWriter = new Zend_Log_Writer_Null();
            }
                
            require_once 'Zend/Log.php';
            $this->_log = new Zend_Log($logWriter);       
        }
        
        return $this->_log;
    }
    
    /**
     * returns the event dispatcher
     */
    public function getEventDispatcher() {
        
        if (!$this->_ed) {
            $this->_ed = new Erfurt_EventDispatcher($this);
        }
        
        return $this->_ed;
    }
    
    /**
     * returns the plugin manager
     * 
     * @throws Erfurt_Exception
     */
    public function getPluginManager() {
        
        if (!$this->_pluginManager) {
            $config = $this->getConfig();
            $this->_pluginManager = new Erfurt_PluginManager($this);
            if ($config->plugins->erfurt && (strlen($config->plugins->erfurt) > 0)) {
// TODO remove constant?!
                $this->_pluginManager->init(REAL_BASE . $this->config->plugins->erfurt);
            }
        }
    
        return $this->pluginManager;
    }
    
    /**
     * returns the store instance as configured in config
     * 
     * @throws Erfurt_Exception
     */
    public function getStore() 
    {
        if ($this->_store === false) {
            $config = $this->getConfig();
            
            // schema must be set, else throw an exception
            if (isset($config->store->backend)) {
                $backend = strtolower($config->store->backend);
            } else {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Backend must be set in configuration.');
            }
            
            // check configured backend and if not set set it as empty (e.g. virtuoso needs no special backend)
// TODO Maybe later, if we have different schemas... for now we only need virtuoso and zenddb with ef schema. 
            if (isset($config->store->schema)) {
                $schema = $config->store->schema;
            } else {
                $schema = null;
            }
            
            // fetch backend specific options from config
            $backendOptions = array();
            if ($backendConfig = $config->store->get($backend)) {
                $backendOptions = $backendConfig->toArray();
            }
        
            try {
                require_once 'Erfurt/Store.php';
                $this->_store = new Erfurt_Store($backend, $backendOptions, $schema);
            } catch (Erfurt_Store_Adapter_Exception $e) {
                if ($e->getCode() === 10) {
                    // In this case the db environment was not initialized... It should be initialized now.
                    $this->_store = new Erfurt_Store($backend, $backendOptions, $schema);
                    $this->_store->checkSetup();
                } else {
                    require_once 'Erfurt/Exception.php';
                    throw new Erfurt_Exception($e->getMessage(), -1);
                }
            }
        }
        
        return $this->_store;
    }
    
    /**
         * check for new erfurt installation and sets the system ontologies
         */
    /*private function _checkNewInstallation(Zend_Config $config) {

        // check for ontowiki system ontologies
        if (!$this->store[$this->defaultStore]->modelExists($config->sysont->schema, false)) {
            $msg = 'Database Setup: Checking for Ontowiki SysOnt Schema ... no schema found.<br />';
            
            $m = $this->store[$this->defaultStore]->getNewModel($config->sysont->schema, '', 'RDFS', false);
            $m->dontCheckForDuplicatesOnAdd = true;
            $this->store[$this->defaultStore]->dbConn->StartTrans();
            $m->load(ERFURT_BASE . 'SysOnt.rdf', NULL, true);
            $this->store[$this->defaultStore]->dbConn->CompleteTrans();
            
            $msg .= 'Database Setup: Ontowiki SysOnt schema created.<br />';
            
            if ($this->throwExceptions) {
                header('Refresh: 3; url=' . $_SERVER['REQUEST_URI']);
                throw new Erfurt_Exception($msg . '<br />Refreshing in 3 seconds.');
            } else {
                echo $msg . '<br /><b>Please reload now.</b>';
            }
            
            exit();
        }
        if (!$this->store[$this->defaultStore]->modelExists($config->sysont->model, false)) {
            $msg = 'Database Setup: Checking for Ontowiki SysOnt model ... no model found.<br />';
            
            $m = $this->store[$this->defaultStore]->getNewModel($config->sysont->model, '', 'RDFS', false);
            $m->dontCheckForDuplicatesOnAdd = true;
            $this->store[$this->defaultStore]->dbConn->StartTrans();
            $m->load(ERFURT_BASE . 'SysOntLocal.rdf', NULL, true);
            $this->store[$this->defaultStore]->dbConn->CompleteTrans();
            
            $msg .= 'Database Setup: Ontowiki SysOnt model created<br />';
            
            if ($this->throwExceptions) {
                header('Refresh: 3; url=' . $_SERVER['REQUEST_URI']);
                throw new Erfurt_Exception($msg . '<br />Refreshing in 3 seconds.');
            } else {
                echo $msg . '<br /><b>Please reload now.</b>';
            }
            
            exit();
        }
    }*/
    
    
    /**
     * authtenticate user
     * 
     * authenticate a user to the store
     * 
     */
    public function authenticate($username = 'Anonymous', $password = '')
    {
        // Set up the authentication adapter
        require_once 'Erfurt/Auth/Adapter/Rdf.php';
        $adapter = new Erfurt_Auth_Adapter_Rdf($username, $password);
        
        // Attempt authentication, saving the result
        $result = $this->getAuth()->authenticate($adapter);

        if (!$result->isValid()) {
            $this->getAuth()->clearIdentity();
        }
        
        return $result;
    }

    public function getAuth()
    {    
        if (!$this->_auth) {
            require_once 'Zend/Auth.php';
            $this->_auth = Zend_Auth::getInstance();
            
            // TODO: this seems to not work
            // require_once 'Zend/Auth/Storage/Session.php';
            // $this->_auth->setStorage(new Zend_Auth_Storage_Session('Erfurt_Auth'));
        }
        
        return $this->_auth;
    }
    
    public function getCache() 
    {    
        if (!$this->_cache) {
            $config = $this->getConfig();
            if (!isset($config->cache->lifetime) || ($config->cache->lifetime == -1)) {
                $lifetime = null;
            } else {
                $lifetime = $config->cache->lifetime;
            }
        
            $frontendOptions = array(
                'lifetime' => $lifetime,
                'automatic_serialization' => true
            );
        
            require_once 'Zend/Cache.php'; // workaround, for zend actually does not include it itself
            require_once 'Erfurt/Cache/Frontend/AutoId.php';
            $this->_cache = new Erfurt_Cache_Frontend_AutoId($frontendOptions);
            
            $backend = $this->getCacheBackend();
            $this->_cache->setBackend($backend);
        }
        
        return $this->_cache;
    }
    
    /**
     * @throws Erfurt_Exception if cache type is not set
     * @throws Erfurt_Exception if cache type is not supported
     * @throws Erfurt_Exception if cache params are not set seperatly and backend does not work with cache backend.
     */
    public function getCacheBackend() 
    {    
        if (!$this->_cacheBackend) {
            $config = $this->getConfig();
            
            if (!isset($config->cache->enable) || !(boolean)$config->cache->enable) {
                require_once 'Erfurt/Cache/Backend/Null.php';
                
                $this->_cacheBackend = new Erfurt_Cache_Backend_Null();
            } 
            // cache is enabled
            else {
                // check for the cache type and throw an exception if cache type is not set
                if (!isset($config->cache->type)) {
                    require_once 'Erfurt/Exception.php';
                    throw new Erfurt_Exception('Cache type is not set in config.'); 
                } else {
                    // check the type an whether type is supported
                    switch (strtolower($config->cache->type)) {
                        case 'mysqli':
                            if (isset($config->cache->mysqli->host)) {
                                $dbHost = $config->cache->mysqli->host;
                            } else if ($config->database->backend == strtolower('mysqli')) {
                                $dbHost = $config->database->host;
                            } else {
                                require_once 'Erfurt/Exception.php';
                                throw new Erfurt_Exception('Cache parameters must be set seperatly or backend must be mysql in order to use the default database settings.');
                            }
                            
                            if (isset($config->cache->mysqli->username)) {
                                $dbUser = $config->cache->mysqli->username;
                            } else {
                                $dbUser = $config->database->username;
                            }
                            
                            if (isset($config->cache->mysqli->password)) {
                                $dbPassword = $config->cache->mysqli->password;
                            } else {
                                $dbPassword = $config->database->password;
                            }
                            
                            if (isset($config->cache->mysqli->dbname)) {
                                $dbName = $config->cache->mysqli->dbname;
                            } else {
                                $dbName = $config->database->dbname;
                            }
                            
                            $backendOptions = array(
                                'host'      => $dbHost,
                                'username'  => $dbUser,
                                'password'  => $dbPassword,
                                'dbname'    => $dbName
                            );
                            
                            require_once 'Erfurt/Cache/Backend/Mysqli.php';
                            $this->_cacheBackend = new Erfurt_Cache_Backend_Mysqli($backendOptions);
                            break;
                        case 'sqlite':
                            if (isset($config->cache->sqlite->dbname)) {
                                $backendOptions = array(
                                    'cache_db_complete_path' => EF_BASE . 'tmp/' .$config->cache->sqlite->dbname
                                );
                            } else {
                                require_once 'Erfurt/Exception.php';
                                throw new Erfurt_Exception('Cache database filename must be set for sqlite cache backend');
                            }
                            
                            require_once 'Zend/Cache/Backend/Sqlite.php';
                            $this->_cacheBackend = new Zend_Cache_Backend_Sqlite($backendOptions);
                            
                            break;
                        default: 
                            require_once 'Erfurt/Exception.php';
                            throw new Erfurt_Exception('Cache type is not supported.');
                    }
                }
            }
        }
        
        return $this->_cacheBackend;
    }
    
    /**
     * Convenience shortcut for Ac_Default::isActionAllowed()
     */
    public function isActionAllowed($actionSpec)
    {
        return $this->getAc()->isActionAllowed($actionSpec);
    }
    
    /**
     * Convenience shortcut for Ac_Default::getActionConfig()
     */
    public function getActionConfig($actionSpec)
    {
        return $this->getAc()->getActionConfig($actionSpec);
    }
    
    /**
     * Convenience shortcut for Auth_Adapter_Rdf::getUsers()
     */
    public function getUsers()
    {
        // TODO: do it in a better way
        require_once 'Erfurt/Auth/Adapter/Rdf.php';
        $tempAdapter = new Erfurt_Auth_Adapter_Rdf($this->getAcModel(), '', '');
        
        return $tempAdapter->getUsers();
    }
    
    /**
     * Adds a new user to the store
     *
     * @todo Make robust
     */
    public function addUser($username, $password, $email, $userGroupUri = null)
    {
        $acModel = $this->getAcModel();
        $userUri = $acModel->getModelIri() . urlencode($username);
        
        $acModel->addStatement($userUri, EF_RDF_TYPE, $this->_config->ac->user->class, array(), false);
        $acModel->addStatement(
            $userUri, $this->_config->ac->user->name, $username, array(
                'object_type' => Erfurt_Store::TYPE_LITERAL, 'literal_datatype' => EF_XSD_NS . 'string'
            ), false);
        $acModel->addStatement($userUri, $this->_config->ac->user->mail, 'mailto:' . $email, array(), false);
        $acModel->addStatement($userUri, $this->_config->ac->user->pass, sha1($password), array(), false);
        
        if ($userGroupUri) {
            $acModel->addStatement($userGroupUri, $this->_config->ac->group->membership, $userUri, array(), false);
        }
        
        return true;
    }

    /**
     * Returns Versioning, if not found instantiates it
     *
     * @return Erfurt_Versioning
     */
    public function getVersioning() {
        if (!$this->_versioning) {
            require_once 'Erfurt/Versioning.php';
            $this->_versioning = new Erfurt_Versioning();
        }
        return $this->_versioning;
    }

}

?>
