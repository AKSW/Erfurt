<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * The Erfurt application class.
 *
 * This class acts as the central class of an Erfurt application.
 * It provides access to a large number of objects that provide functionality an
 * application may use. It's also the place where an Erfurt application gets started
 * and initialized.
 *
 * @category Erfurt
 * @package Erfurt
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_App
{
    static $httpAdapter = null;

    // ------------------------------------------------------------------------
    // --- Class constants ----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Constant that contains the minimum required php version.
     * @var string
     */
    const EF_MIN_PHP_VERSION  = '5.2.0';

    /**
     * Constant that contains the minimum required zend framework version.
     * @var string
     */
    const EF_MIN_ZEND_VERSION = '1.5.0';

    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * The instance of this class which is returned on request, for this class
     * acts as a singleton.
     *
     * @var Erfurt_App
     */
    private static $_instance = null;

    /**
     * Contains an instance of the Erfurt access control class.
     * @var Erfurt_Ac_Default
     */
    private $_ac = null;

    /**
     * Contains an instanciated access control model.
     * @var Erfurt_Rdf_Model
     */
    private $_acModel = null;

    private $_acModelUri = null;

    /**
     * Contains a reference to Zend_Auth singleton.
     */
    private $_auth = null;

    /**
     * Contains the cache object.
     * @var Zend_Cache_Core
     */
    private $_cache = null;

    /**
     * Contains the cache backend.
     * @var Zend_Cache_Backend
     */
    private $_cacheBackend = null;

    /**
     * Contains an instance of the configuration object.
     * @var Zend_Config
     */
    private $_config = null;

    /**
     * Holds whether app was started.
     * @var boolean
     */
    private $_isStarted = false;

    /**
     * Contains an array of Zend_Log instances.
     * @var array
     */
    private $_logObjects = array();

    /**
     * Namespace management module
     * @var Erfurt_Namespaces
     */
    protected $_namespaces = null;

    /**
     * Contains an instance of the Erfurt plugin manager.
     * @var Erfurt_Plugin_Manager
     */
    private $_pluginManager = null;

    /**
     * Contains the query cache object.
     * @var Erfurt_Cache_Frontend_QueryCache
     */
    private $_queryCache = null;

    /**
     * Contains the query cache backend.
     * @var Erfurt_Cache_Backend_QueryCache_Backend
     */
    private $_queryCacheBackend = null;

    /**
     * Contains an instance of the store.
     * @var Erfurt_Store
     */
    private $_store = null;

    /**
     * Contains an instanciated system ontology model.
     * @var Erfurt_Rdf_Model
     */
    private $_sysOntModel = null;

    /**
     * Contains an instance of the Erfurt versioning class.
     * @var Erfurt_Versioning
     */
    private $_versioning = null;

    /**
     * Contains an instance of the Erfurt wrapper manager.
     * @var Erfurt_Wrapper_Manager
     */
    private $_wrapperManager = null;

    private $_resourcePool = null;

    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * The constructor of this class.
     *
     * @throws Erfurt_Exception Throws an exception if wrong PHP or wrong Zend
     * Framework version is used.
     */
    private function __construct()
    {
        // Check the PHP version.
        if (!version_compare(self::_getPhpVersion(), self::EF_MIN_PHP_VERSION, '>=')) {
            throw new Erfurt_Exception('Erfurt requires at least PHP version ' . self::EF_MIN_PHP_VERSION);
        }

        // Check whether Zend is loaded with the right version.
        if (!version_compare(self::_getZendVersion(), self::EF_MIN_ZEND_VERSION, '>=')) {
            throw new Erfurt_Exception(
                'Erfurt requires at least Zend Framework in version ' . self::EF_MIN_ZEND_VERSION
            );
        }

        // Define Erfurt base constant.
        if (!defined('EF_BASE')) {
            define('EF_BASE', rtrim(dirname(__FILE__), '\\/') . '/');
        }

        // Include the vocabulary file.
        require_once EF_BASE . 'include/vocabulary.php';
    }

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Returns the instance of this class.
     *
     * @param boolean $autoStart Whether the application should be started automatically
     * when this method is called the first time. If this parameter is set to false, an
     * application needs to call the start method explicit.
     * @return Erfurt_App
     */
    public static function getInstance($autoStart = true)
    {
        if (null === self::$_instance) {
            self::$_instance = new Erfurt_App();

            if ($autoStart === true) {
                self::$_instance->start();
            }
        }

        return self::$_instance;
    }

    public static function reset()
    {
        self::$_instance = null;
    }

    /**
     * Starts the application, which initializes it.
     *
     * @param Zend_Config|null $config An optional config object that will be merged with
     * the Erfurt config.
     *
     * @return Erfurt_App
     * @throws Erfurt_Exception Throws an exception if the connection to the backend server fails.
     */
    public function start(Zend_Config $config = null)
    {
        // If already started just return the object.
        if ($this->_isStarted === true) {
            return $this;
        }

        // Stop the time for debugging purposes.
        $start = microtime(true);

        // Load the configuration first.
        $this->loadConfig($config);

        // Check for debug mode.
        $config = $this->getConfig();
        if ((boolean)$config->debug === true) {
            error_reporting(E_ALL | E_STRICT);

            if (!defined('_EFDEBUG')) {
                define('_EFDEBUG', 1);
            }

            // In debug mode log level is set to the highest value automatically.
            $config->log->level = 7;
        }

        // Set the configured time zone.
        if (isset($config->timezone) && ((boolean)$config->timezone !== false)) {
            date_default_timezone_set($config->timezone);
        } else {
            date_default_timezone_set('Europe/Berlin');
        }

        // Starting Versioning
        try {
            $versioning = $this->getVersioning();
            if ($versioning instanceof Erfurt_Versioning) {
                if ((bool)$config->versioning === true) {
                    $versioning->enableVersioning(true);
                } else {
                    $versioning->enableVersioning(false);
                }
            }
        } catch (Erfurt_Exception $e) {
            throw new Erfurt_Exception($e->getMessage());
        }

        // Write time to the log, if enabled.
        $time = (microtime(true) - $start)*1000;
        $this->getLog()->debug('Erfurt_App started in ' . $time . ' ms.');

        $this->_isStarted = true;

        return $this;
    }

    /**
     * Adds a new OpenID user to the store.
     *
     * @param string $openid
     * @param string $email
     * @param string $label
     * @param string|null $group
     * @return boolean
     */
    public function addOpenIdUser($openid, $email = '', $label = '', $group = '')
    {
        $acModel    = $this->getAcModel();
        $acModelUri = $acModel->getModelUri();
        $store      = $acModel->getStore();
        $userUri    = urldecode($openid);

        // uri rdf:type sioc:User
        $store->addStatement(
            $acModelUri,
            $userUri,
            EF_RDF_TYPE,
            array(
                'value' => $this->_config->ac->user->class,
                'type'  => 'uri'
            ),
            false
        );

        if (!empty($email)) {
            // Check whether email already starts with mailto:
            if (substr($email, 0, 7) !== 'mailto:') {
                $email = 'mailto:' . $email;
            }

            // uri sioc:mailbox email
            $store->addStatement(
                $acModelUri,
                $userUri,
                $this->_config->ac->user->mail,
                array(
                    'value' => $email,
                    'type'  => 'uri'
                ),
                false
            );
        }

        if (!empty($label)) {
            // uri rdfs:label $label
            $store->addStatement(
                $acModelUri,
                $userUri,
                EF_RDFS_LABEL,
                array(
                    'value' => $label,
                    'type'  => 'literal'
                ),
                false
            );
        }

        if (!empty($group)) {
            $store->addStatement(
                $acModelUri,
                $group,
                $this->_config->ac->group->membership,
                array(
                    'value' => $userUri,
                    'type'  => 'uri'
                ),
                false
            );
        }

        return true;
    }

    /**
     * Adds a new user to the store.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string|null $userGroupUri
     * @return boolean
     */
    public function addUser($username, $password, $email, $userGroupUri = '')
    {
        $acModel    = $this->getAcModel();
        $acModelUri = $acModel->getModelUri();
        $store      = $acModel->getStore();
        $userUri    = $acModelUri . urlencode($username);

        $store->addStatement(
            $acModelUri,
            $userUri,
            EF_RDF_TYPE,
            array(
                'value' => $this->_config->ac->user->class,
                'type'  => 'uri'
            ),
            false
        );

        $store->addStatement(
            $acModelUri,
            $userUri,
            $this->_config->ac->user->name,
            array(
                'value'    => $username,
                'type'     => 'literal',
                'datatype' => EF_XSD_NS . 'string'
            ),
            false
        );

        // Check whether email already starts with mailto:
        if (substr($email, 0, 7) !== 'mailto:') {
            $email = 'mailto:' . $email;
        }

        $store->addStatement(
            $acModelUri,
            $userUri,
            $this->_config->ac->user->mail,
            array(
                'value' => $email,
                'type'  => 'uri'
            ),
            false
        );

        $store->addStatement(
            $acModelUri,
            $userUri,
            $this->_config->ac->user->pass,
            array(
                'value' => sha1($password),
                'type'  => 'literal'
            ),
            false
        );

        if (!empty($userGroupUri)) {
            $store->addStatement(
                $acModelUri,
                $userGroupUri,
                $this->_config->ac->group->membership,
                array(
                    'value' => $userUri,
                    'type'  => 'uri'
                ),
                false
            );
        }

        return true;
    }

    /**
     * Authenticates a user with a given username and password.
     *
     * @param string $username
     * @param string $password
     * @return Zend_Auth_Result
     */
    public function authenticate($username = 'Anonymous', $password = '')
    {
        // Set up the authentication adapter.
        $config = $this->getConfig();
        $type = strtolower($config->ac->type);

        $adapter = null;
        if ($type === 'rdf') {
            $adapter = new Erfurt_Auth_Adapter_Rdf($username, $password);
        } else if ($type === 'none') {
            $adapter = new Erfurt_Auth_Adapter_None($username, $password);
        } else {
            throw new Erfurt_Exception("Auth type '$type' not supported");
        }

        // Attempt authentication, saving the result.
        $result = $this->getAuth()->authenticate($adapter);

        // If the result is not valid, make sure the identity is cleared.
        if (!$result->isValid()) {
            $this->getAuth()->clearIdentity();
        }

        return $result;
    }

    public function authenticateWithFoafSsl($get = null, $redirectUrl = null)
    {
        // Set up the authentication adapter.
        $adapter = new Erfurt_Auth_Adapter_FoafSsl($get, $redirectUrl);

        // Attempt authentication, saving the result.
        $result = $this->getAuth()->authenticate($adapter);

        // If the result is not valid, make sure the identity is cleared.
        if (!$result->isValid()) {
            $this->getAuth()->clearIdentity();
        }

        return $result;
    }

    /**
     * The second step of the OpenID authentication process.
     * Authenticates a user with a given OpenID. On success this
     * method will not return but instead redirect the user to the
     * specified URL.
     *
     * @param string $openId
     * @param string $redirectUrl
     * @return Zend_Auth_Result
     */
    public function authenticateWithOpenId($openId, $verifyUrl, $redirectUrl)
    {
        $adapter = new Erfurt_Auth_Adapter_OpenId($openId, $verifyUrl, $redirectUrl);

        $result = $this->getAuth()->authenticate($adapter);

        // If we reach this point, something went wrong with the authentication process...
        // So we always clear the identity.
        $this->getAuth()->clearIdentity();

        return $result;
    }

    /**
     * Returns an instance of the access control class.
     *
     * @return Erfurt_Ac_Default
     */
    public function getAc()
    {
        if (null === $this->_ac) {
            $config = $this->getConfig();
            $type = strtolower($config->ac->type);
            if ($type === 'rdf') {
                $this->_ac = new Erfurt_Ac_Default();
            } else if ($type === 'none') {
                $this->_ac = new Erfurt_Ac_None();
            } else {
                throw new Erfurt_Exception("AC type '$type' not supported.");
            }
        }

        return $this->_ac;
    }

    public function setAc($ac)
    {
        $this->_ac = $ac;
    }

    /**
     * Returns an instance of the access control model.
     *
     * @return Erfurt_Rdf_Model
     */
    public function getAcModel()
    {
        if (null === $this->_acModel) {
            $config = $this->getConfig();
            $this->_acModel = $this->getStore()->getModel($this->getAcModelUri(), false);
        }

        return $this->_acModel;
    }

    public function getAcModelUri()
    {
        if (null === $this->_acModelUri) {
            $config = $this->getConfig();
            $this->_acModelUri = $config->ac->modelUri;
        }

        return $this->_acModelUri;
    }

    /**
     * Convenience shortcut for Ac_Default::getActionConfig().
     *
     * @param string $actionSpec The action to get the configuration for.
     * @return array Returns the configuration for the given action.
     */
    public function getActionConfig($actionSpec)
    {
        return $this->getAc()->getActionConfig($actionSpec);
    }

    /**
     * Returns the auth instance.
     *
     * @return Zend_Auth
     */
    public function getAuth()
    {
        if (null === $this->_auth) {
            $auth = Erfurt_Auth::getInstance();

            $config = $this->getConfig();
            if (isset($config->session->identifier)) {
                $sessionNamespace = 'Erfurt_Auth' . $config->session->identifier;
                $auth->setStorage(new Zend_Auth_Storage_Session($sessionNamespace));
            }

            $this->_auth = $auth;
        }

        return $this->_auth;
    }

    public function setAuth(Erfurt_Auth $auth)
    {
        $this->_auth = $auth;
    }

    /**
     * Returns a caching instance.
     *
     * @return Zend_Cache_Core
     */
    public function getCache()
    {
        if (null === $this->_cache) {
            $options	= $this->getConfig()->cache->frontend->toArray();
            $options['automatic_serialization']	= TRUE;
            if (!isset($options['lifetime']) || ((int)$options['lifetime'] < 1 )) {
                $options['lifetime']	= NULL;
            }
            $this->_cache = new Erfurt_Cache_Frontend_ObjectCache($options);
            $this->_cache->setBackend($this->_getCacheBackend());
        }
        return $this->_cache;
    }

    /**
     * Returns the configuration object.
     *
     * @return Zend_Config
     * @throws Erfurt_Exception Throws an exception if no config is loaded.
     */
    public function getConfig()
    {
        if (null === $this->_config) {
            throw new Erfurt_Exception('Configuration was not loaded.');
        } else {
            return $this->_config;
        }
    }

    /**
     * Returns the event dispatcher instance.
     *
     * @return Erfurt_Event_Dispatcher
     */
    public function getEventDispatcher()
    {
        $ed = Erfurt_Event_Dispatcher::getInstance();

        return $ed;
    }

    /**
     *
     */
    public function getHttpClient($uri, $options = array())
    {
        if (null !== self::$httpAdapter) {
            return new Zend_Http_Client($uri, array('adapter' => self::$httpAdapter));
        }

        $config = $this->getConfig();

        $defaultOptions = array();
        if (isset($config->proxy)) {
            $proxy = $config->proxy;

            if (isset($proxy->host)) {
                $defaultOptions['proxy_host'] = $proxy->host;

                $defaultOptions['adapter'] = 'Zend_Http_Client_Adapter_Proxy';

                if (isset($proxy->port)) {
                    $defaultOptions['proxy_port'] = (int)$proxy->port;
                }

                if (isset($proxy->username)) {
                    $defaultOptions['proxy_user'] = $proxy->username;
                }

                if (isset($proxy->password)) {
                    $defaultOptions['proxy_pass'] = $proxy->password;
                }
            }
        }

        $finalOptions = array_merge($defaultOptions, $options);
        $client = new Zend_Http_Client($uri, $finalOptions);

        return $client;
    }

    /**
     * Returns a logging instance. If logging is disabled Zend_Log_Writer_Null is returned,
     * so it is save to use this object without further checkings. It is possible to use
     * different logging files for different contexts. Just use an additional identifier.
     *
     * @param string $logIdentifier Identifies the logfile (filename without extension).
     * @return Zend_Log
     */
    public function getLog($logIdentifier = 'erfurt' )
    {
        if (!isset($this->_logObjects[$logIdentifier])) {
            $config = $this->getConfig();

            if ((boolean)$config->log->level !== false) {
                $logDir = $this->getLogDir();

                $logWriter = null;
                if ($logDir === false) {
                    $logWriter = new Zend_Log_Writer_Null();
                } else {
                    $logName = $logDir . $logIdentifier;

                    // Check whether log can be created with $logName... otherwise append a number.
                    // This needs to be done, since logs may be created by other processes (e.g. with
                    // testing) and thus can't be opened anymore.
                    for ($i = 0; $i<10; ++$i) {
                        try {
                            $fullLogName = $logName;
                            if ($i > 0) {
                                $fullLogName .= '_' . $i;
                            }
                            $fullLogName .= '.log';
                            $logWriter = new Zend_Log_Writer_Stream($fullLogName);
                            if (null !== $logWriter) {
                                break;
                            }
                        } catch (Zend_Log_Exception $e) {
                            // Nothing to do... just continue
                        }
                    }

                    if (null === $logWriter) {
                        $logWriter = new Zend_Log_Writer_Null();
                    }
                }
            } else {
                $logWriter = new Zend_Log_Writer_Null();
            }

            $logger = new Zend_Log($logWriter);

            // filter according to the given log level
            if ((boolean) $config->log->level !== false) {
                $levelFilter = new Zend_Log_Filter_Priority((int) $config->log->level, '<=');
                $logger->addFilter($levelFilter);
            }

            $this->_logObjects[$logIdentifier] = $logger;

        }

        return $this->_logObjects[$logIdentifier];
    }

    /**
     * Returns the configured log directory. If no such directory is configured
     * a logs folder under the Erfurt tree is used iff available.
     *
     * @return string|false
     */
    public function getLogDir()
    {
        $config = $this->getConfig();

        if (isset($config->log->path)) {
            $matches = array();
            if (!(preg_match('/^(\w:[\/|\\\\]|\/)/', $config->log->path, $matches) === 1)) {
                $config->log->path = realpath(EF_BASE . '../../' . $config->log->path);
            }

            $config->log->path = rtrim($config->log->path, '/\\') . '/';

            if (is_writable($config->log->path)) {
                return $config->log->path;
            } else {
                error_log('Attention : Erfurt log.path ('. $config->log->path .') not writable.');
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Returns the namespace management module.
     *
     * @return Erfurt_Namespaces
     */
    public function getNamespaces()
    {
        if (null === $this->_namespaces) {
            $config = $this->getConfig();

            // options
            $namespacesOptions = array(
                'standard_prefixes' => isset($config->namespaces) ? $config->namespaces->toArray() : array(),
                'reserved_names'    => isset($config->uri->schemata) ? $config->uri->schemata->toArray() : array()
            );

            $this->_namespaces = new Erfurt_Namespaces($namespacesOptions);
        }

        return $this->_namespaces;
    }

    /**
     * Returns a plugin manager instance
     *
     * @param boolean $addDefaultPluginPath Whether to add the default plugin path
     * on first call of this method (When the class is instanciated).
     * @return Erfurt_Plugin_Manager
     */
    public function getPluginManager($addDefaultPluginPath = true)
    {
        if (null === $this->_pluginManager) {
            $config = $this->getConfig();

            $this->_pluginManager = new Erfurt_Plugin_Manager();

            if ($addDefaultPluginPath && isset($config->extensions->plugins)) {
                $this->_pluginManager->addPluginPath(EF_BASE . $config->extensions->plugins);
            }
        }

        return $this->_pluginManager;
    }

    /**
     * Returns a query cache instance.
     *
     * @return Erfurt_Cache_Frontend_QueryCache
     */
    public function getQueryCache()
    {
        if (null === $this->_queryCache) {
            $config = $this->getConfig();
            $this->_queryCache = new Erfurt_Cache_Frontend_QueryCache();

            $backend = $this->_getQueryCacheBackend();
            $this->_queryCache->setBackend($backend);
        }

        return $this->_queryCache;
    }

    /**
     * Returns the ResourceList instance
     *
     * @return Erfurt_RDF_ResourceList
     */
    public function getResourcePool()
    {
        if ($this->_resourcePool === null) {
            $this->_resourcePool = new Erfurt_Rdf_Resource_Pool($this);
        }
        return $this->_resourcePool;
    }

    /**
     * Returns a instance of the store.
     *
     * @return Erfurt_Store
     * @throws Erfurt_Exception Throws an exception if the store is not configured right.
     */
    public function getStore()
    {
        if (null === $this->_store) {
            $config = $this->getConfig();

            // Backend must be set, else throw an exception.
            if (isset($config->store->backend)) {
                $backend = strtolower($config->store->backend);
            } else {
                throw new Erfurt_Exception('Backend must be set in configuration.');
            }

            // Check configured schema and if not set set it as empty (e.g. virtuoso needs no special schema.
            if (isset($config->store->schema)) {
                $schema = $config->store->schema;
            } else {
                $schema = null;
            }

            // fetch backend specific options from config.
            $backendOptions = array();
            if ($backendConfig = $config->store->get($backend)) {
                $backendOptions = $backendConfig->toArray();
            }

            // store config options
            if (isset($config->sysont)) {
                $storeOptions = $config->sysont->toArray();
            } else {
                $storeOptions = array();
            }

            $this->_store = new Erfurt_Store($storeOptions, $backend, $backendOptions, $schema);

            // Make sure the store is initialized
            try {
                $this->_store->checkSetup();
            } catch (Erfurt_Store_Exception $e) {
                if ($e->getCode() != Erfurt_Exception::SYSTEM_MODELS_IMPORTED) {
                    throw $e;
                }
            }
        }

        return $this->_store;
    }

    public function setStore(Erfurt_Store $store)
    {
        $this->_store = $store;
    }

    /**
     * Returns an instance of the system ontology model.
     *
     * @return Erfurt_Rdf_Model
     */
    public function getSysOntModel()
    {
        if (null === $this->_sysOntModel) {
            $config = $this->getConfig();
            $this->_sysOntModel = $this->getStore()->getModel($config->sysont->modelUri, false);
        }

        return $this->_sysOntModel;
    }

    /**
     * Returns a valid tmp folder depending on the OS used.
     *
     * @return string
     */
    public function getTmpDir()
    {
        // We use a Zend method here, for it already checks the OS.
        $temp = new Zend_Cache_Backend();
        return $temp->getTmpDir();
    }

    /**
     * Convenience shortcut for Auth_Adapter_Rdf::getUsers().
     *
     * @return array Returns a list of users.
     */
    public function getUsers()
    {
        $tempAdapter = new Erfurt_Auth_Adapter_Rdf();

        return $tempAdapter->getUsers();
    }

    /**
     * Returns a versioning instance.
     *
     * @return Erfurt_Versioning
     */
    public function getVersioning()
    {
        if (null === $this->_versioning) {
            $config = $this->getConfig();
            $versioningEnabled = (boolean)$config->versioning;

            if (!$versioningEnabled) {
                return false;
            }

            $this->_versioning = new Erfurt_Versioning();
        }

        return $this->_versioning;
    }

    /**
     * Returns the instance of the Erfurt wrapper registry.
     *
     * @param Erfurt_Wrapper_Registry
     */
    public function getWrapperRegistry()
    {
        return Erfurt_Wrapper_Registry::getInstance();
    }

    /**
     * Convenience shortcut for Ac_Default::isActionAllowed().
     *
     * @param string $actionSpec The action to check.
     * @return boolean Returns whether the given action is allowed for the current user.
     */
    public function isActionAllowed($actionSpec)
    {
        return $this->getAc()->isActionAllowed($actionSpec);
    }

    /**
     * Returns whether app was already started.
     */
    public function isStarted()
    {
        return $this->_isStarted;
    }

    /**
     * Loads the Erfurt configuration with an optional given config
     * object injected.
     *
     * @param Zend_Config|null $config
     */
    public function loadConfig(Zend_Config $config = null)
    {
        // Load the default erfurt config.
        if (is_readable((EF_BASE . 'config/default.ini'))) {
            try {
                $this->_config = new Zend_Config_Ini((EF_BASE . 'config/default.ini'), 'default', true);
            } catch (Zend_Config_Exception $e) {
                throw new Erfurt_App_Exception('Error while parsing config file default.ini.');
            }
        } else {
            throw new Erfurt_App_Exception('Config file default.ini not readable.');
        }

        // Load user config iff available.
        if (is_readable((EF_BASE . 'config.ini'))) {
            try {
                $this->_config->merge(new Zend_Config_Ini((EF_BASE . 'config.ini'), 'private', true));
            } catch (Zend_Config_Exception $e) {
                throw new Erfurt_App_Exception('Error while parsing config file config.ini.');
            }
        }

        // merge with injected config if given
        if (null !== $config) {
            try {
                $this->_config->merge($config);
            } catch (Zend_Config_Exception $e) {
                throw new Erfurt_App_Exception('Error while merging with injected config.');
            }
        }
    }

    /**
     * The third and last step of the OpenID authentication process.
     * Checks whether the response is a valid OpenID result and
     * returns the appropriate auth result.
     *
     * @param array $get The query part of the authentication request.
     * @return Zend_Auth_Result
     */
    public function verifyOpenIdResult($get)
    {
        $adapter = new Erfurt_Auth_Adapter_OpenId(null, null, null, $get);

        $result = $this->getAuth()->authenticate($adapter);

        if (!$result->isValid()) {
            $this->getAuth()->clearIdentity();
        }

        return $result;
    }

    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Returns a cache backend as configured.
     *
     * @return Zend_Cache_Backend
     * @throws Erfurt_Exception
     */
    private function _getCacheBackend()
    {
        if (null === $this->_cacheBackend) {
            $config = $this->getConfig();
            // check the type an whether type is supported
            $cacheType	= $config->cache->backend->type;
            // caching is not enabled, use fake cache backend
            if (!$config->cache->frontend->enable)
                $cacheType = "null";
            switch (strtolower($cacheType)) {
                case 'memcached':
                    $options = $config->cache->backend->memcached->toArray();
                    $cache   = new Zend_Cache_Backend_Memcached($options);
                    if (!$cache->save(time(), 'EF_lastConnect')) {
                        throw new Erfurt_Exception(
                            'Memcache server is not available.'
                        );
                    }
                    break;
                case 'apc':
                    $cache   = new Zend_Cache_Backend_Apc();
                    break;
                case 'sqlite':
                    $options = $config->cache->backend->sqlite->toArray();
                    if (!in_array('cache_db_complete_path', array_keys($options))) {
                        throw new Erfurt_Exception(
                            'Cache database filename must be set for sqlite cache backend (cache_db_complete_path).'
                        );
                    }
                    $cache   = new Zend_Cache_Backend_Sqlite($options);
                    break;
                case 'file':
                    $path = $config->cache->backend->file->cache_dir;
                    if (!$path) {
                        throw new Erfurt_App_Exception(
                            'No cache directory configured.'
                        );
                    }
                    if (!file_exists($path)) {
                        throw new Erfurt_App_Exception(
                            'Cache directory "'.$path.'" is not existing.'
                        );
                    }
                    if (!is_writable($path)) {
                        throw new Erfurt_App_Exception(
                            'Cache directory "'.$path.'" is not writable.'
                        );
                    }
                    $options = $config->cache->backend->file->toArray();
                    $cache   = new Zend_Cache_Backend_File($options);
                    break;
                case 'database':
                    $cache   = new Erfurt_Cache_Backend_Database();
                    break;
                case 'null':
                    $cache   = new Erfurt_Cache_Backend_Null();
                    break;
                default:
                    throw new Erfurt_Exception(
                        'Cache type "'.$cacheType.'" is not supported.'
                    );
            }
            $this->_cacheBackend = $cache;
        }
        return $this->_cacheBackend;
    }

    /**
     * Returns a query cache backend as configured.
     *
     * @return Erfurt_Cache_Backend_QueryCache_Backend
     * @throws Erfurt_Exception
     */
    private function _getQueryCacheBackend()
    {
        if (null === $this->_queryCacheBackend) {
            $config = $this->getConfig();
            $backendOptions = array();
            if (!isset($config->cache->query->enable) || ((boolean)$config->cache->query->enable === false)) {
                $this->_queryCacheBackend = new Erfurt_Cache_Backend_QueryCache_Null();
            } else {
                // cache is enabled
                // check for the cache type and throw an exception if cache type is not set
                if (!isset($config->cache->query->type)) {
                    throw new Erfurt_Exception('Cache type is not set in config.');
                } else {
                    // check the type an whether type is supported

                    switch (strtolower($config->cache->query->type)) {
                        case 'database':
                            $this->_queryCacheBackend = new Erfurt_Cache_Backend_QueryCache_Database();
                            break;
#                       case 'file':
#                            $this->_queryCacheBackend = new Erfurt_Cache_Backend_QueryCache_File();
#                            break;
#
#                       case 'memory':
#                            $this->_queryCacheBackend = new Erfurt_Cache_Backend_QueryCache_Memory();
#                            break;
                        default:
                            throw new Erfurt_Exception('Cache type is not supported.');
                    }
                }
            }
        }

        return $this->_queryCacheBackend;
    }

    protected function _getPhpVersion()
    {
        return phpversion();
    }

    protected function _getZendVersion()
    {
        return Zend_Version::VERSION;
    }
}
