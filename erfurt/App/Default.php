<?php
/**
 * Erfurt application class
 */
class Erfurt_App_Default {
	
	/**
	 * @var object auth instance
	 */
	protected $auth = null;
	
	/**
	 * @var object instance auth adapter
	 */
	protected $authAdapter = null;
	
	/**
	 * @var object instance of ac-object
	 */
	protected $ac = null;
	
	/**
	 * @var object instance of model-object
	 */
	protected $acModel = null;
	
	
	/**
	 * @var array array of store instances
	 */
	protected $store = array();
	
	
	
	/**
	 *  
	 * @var string default store name
	 */
	protected $defaultStore = 'default';
	
	/**
	 * constructor
	 *
	 * @param object configuration parameters
	 */
	public function __construct($config) {
		Zend_Log::log('Erfurt_App_Default::__construct()', Zend_Log::LEVEL_DEBUG, 'erfurt');
		$storeClass = 'Erfurt_Store_Adapter_'.ucfirst(($config->database->backend ? $config->database->backend : 'rap'));
		
		$defaultStore = $this->store[$this->defaultStore] = 
												new $storeClass($config->database->params->type, 
																								$config->database->params->host, 
																								$config->database->params->dbname, 
																								$config->database->params->username, 
																								$config->database->params->password, 
																								$config->SysOntModelURI,
																								$config->database->tableprefix);
					
		/**
 		* load OntoWiki action access control configuration
 		*/
		$owActionClass = $defaultStore->getModel($config->ac->action->class);
		Zend_Registry::set('owActionClass', $owActionClass);
		
		$owAcUserModel = $defaultStore->getModel($config->ac->user->model);
		
		# action conf
		$defautlActionConf = include(ERFURT_BASE.'actions.ini.php');
		
		$this->ac = null;
		
		# set auth instance
		$this->auth = Zend_Auth::getInstance();
		
		$this->acModel = $defaultStore->getModel($config->ac->model);
		Zend_Registry::set('owAc', $this->acModel);
		
		# no current auth data? => set default user
		if (!$this->auth->hasIdentity()) {
			# authenticate anonymous
			$this->authenticate('Anonymous');
		}
		$identity = $this->auth->getIdentity();
		
		$this->ac = new Erfurt_Ac_Default();
		Zend_Registry::set('ac', $this->ac);
		
		# set ac to store
		$defaultStore->setAc($this->ac);
		
		# call init
		$this->init();
	}
	
	
	/**
	 * init-function 
	 * 
	 * init is called at the end of the initialisation process
	 */
	public function init() {
		
		
	}
	
	/**
	 * authtenticate user
	 * 
	 * authenticate a user to the store
	 */
	public function authenticate($username = '', $password = '') {
		
		// Set up the authentication adapter
		$this->authAdapter = new Erfurt_Auth_Adapter_RDF($this->acModel, $username, $password);
		
		// Attempt authentication, saving the result
		$result = $this->auth->authenticate($this->authAdapter);
		
		return $result;
	}
	
	/**
	 * returns a direct or default store instance
	 */
	public function getStore($store = '') {
		if ($store == '' or !isset($this->store[$store]))
			return $this->store[$this->defaultStore];
		else
			return $this->store[$store];
	}
	
}
?>