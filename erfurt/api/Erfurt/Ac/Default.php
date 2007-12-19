<?php
/**
  * class providing OntoWiki access control support methods.
  * 
  * TODO: RECHTE REIHENFOLGE 
  *
  * @package ac
  * @author Stefan Berger <berger@intersolut.de>
  * @version $Id$
  */
class Erfurt_Ac_Default {
	/**
	 * instance of config-object
	 */
	protected $_log = null;
	
	/**
	 * instance of config-object
	 */
	protected $_config = null;
	
	/**
	 * instance of the ac-Model
	 */
	protected $_acModel = null;
	
	/**
	 * instance of the sysont-Model
	 */
	protected $_sysontModel = null;
	
	/**
	 * instance of user-object
	 */
	protected $_user = null;
	
	/**
	 * instance of the sbac-Model
	 */
	protected $_sbacModel = null;
	
	/**
	 * set the permission for the view of all models
	 */
	protected $_userAnyModelViewAllowed = false;
	
	/**
	 * set the permission for the edit of all models
	 */
	protected $_userAnyModelEditAllowed = false;
	
	/**
	 * set the permission for using all action
	 */
	protected $_userAnyActionAllowed = false;
	
	
	/**
	 * storage of the current user permissions 
	 */
	protected $_userRights = array('grantAccess'	=>	array(),
																							'denyAccess'	=>	array(),
																							'grantModelView'	=>	array(),
																							'denyModelView'	=>	array(),
																							'grantModelEdit'	=>	array(),
																							'denyModelEdit'	=>	array(),
																							);
	
	/**
	 * storage of the current group properties permissions 
	 */																							
	protected $_statementbasedRightsProperties = array('grantStatementsView', 
																														'grantStatementsEdit', 
																														'denyStatementsView', 
																														'denyStatementsEdit',
																														'statementsModel');
  
	/**
	 * storage of the current group permissions 
	 */
	protected $_groupRights = array(); 
																							
	/**
	 * default system ontology uri
	 */
	private $_defaultSysOntUri = 'http://localhost/OntoWiki/Config/';
	
	/**
	 * default holder for ac information
	 */
	private $_defaultAcModelUri = 'http://localhost/OntoWiki/Config/';
	
	
	/**
	 * anonymous user uri
	 */
	private $_anonymousUserUri = 'http://ns.ontowiki.net/SysOnt/Anonymous';
	

	/**
	 * super admin user uri
	 */
	private $_defaultSuperUserUri = 'http://ns.ontowiki.net/SysOnt/SuperAdmin';
	
	
	/**
	 * model class schma uri
	 */
	private $_modelClassUri = 'http://ns.ontowiki.net/SysOnt/model';
	
	/**
	 * any model property 
	 */
	private $_propAnyModel = 'http://ns.ontowiki.net/SysOnt/anyModel';
	
	/**
	 * grant model view property 
	 */
	private $_propGrantModelView = 'http://ns.ontowiki.net/SysOnt/grantModelView';
	
	/**
	 * deny model view propertacy 
	 */
	private $_propDenyModelView = 'http://ns.ontowiki.net/SysOnt/denyModelView';
	
	/**
	 * grant model edit property 
	 */
	private $_propGrantModelEdit = 'http://ns.ontowiki.net/SysOnt/grantModelEdit';
	
	/**
	 * deny model edit property 
	 */
	private $_propDenyModelEdit = 'http://ns.ontowiki.net/SysOnt/denyModelEdit';
	
	/**
	 * action class schema uri
	 */
	private $_actionClassUri = 'http://ns.ontowiki.net/SysOnt/Action';
	
	/**
	 * any action property 
	 */
	private $_propAnyAction = 'http://ns.ontowiki.net/SysOnt/anyAction';
	
	/**
	 * grant action property 
	 */
	private $_propGrantAccess = 'http://ns.ontowiki.net/SysOnt/grantAccess';
	
	/**
	 * deny action properregexty 
	 */
	private $_propDenyAccess = 'http://ns.ontowiki.net/SysOnt/denyAccess';
	
	/**
	 * sbac enabled? 
	 */
	private $statementsAcEnabled= false;
	
	/**
	 * sbac edit enabled? 
	 */
	private $statementsAcEditEnabled= false;
	
	/**
	 * grant statements view 
	 */
	private $_propStatementsModel = 'http://ns.ontowiki.net/SysOnt/model';
	/**
	 * grant statements view 
	 */
	private $_propGrantStatementsView = 'http://ns.ontowiki.net/SysOnt/grantStatementsView';
	
	/**
	 * deny statements view 
	 */
	private $_propDenyStatementsView = 'http://ns.ontowiki.net/SysOnt/denyStatementsView';
	
	/**
	 * grant statements edit 
	 */
	private $_propGrantStatementsEdit = 'http://ns.ontowiki.net/SysOnt/grantStatementsEdit';
	
	/**
	 * deny statements edit 
	 */
	private $_propDenyStatementsEdit = 'http://ns.ontowiki.net/SysOnt/denyStatementsEdit';
	
	
	/**
	 * deny action properregexty 
	 */
	private $_defaultActionConfigUri = 'http://ns.ontowiki.net/SysOnt/rawConfig';
	
	
	/**
	 * array with default action configuration 
	 */
	private $_defaultActionConfigs = array();

	/**
	 * constructor
	 * 
	 * @param array default action configuration
	 * @param Zend_Log logging instance
	 * @return void
	 */
	public function __construct(Array $defautlActionConf = array(), Zend_Log $log = null) {
		$this->_defaultActionConfigs = $defautlActionConf;
		
		if (Zend_Registry::isRegistered('erfurtLog')) {
			$this->_log = Zend_Registry::get('erfurtLog');
		} else {
			$this->_log = $log;
		}
		$this->init();
	}
	
	
	/**
	 * initialisation of models and uris
	 * 
	 * @return void
	 */
	public function init() {
		$auth = Zend_Auth::getInstance();
		$this->_config = $config = Zend_Registry::get('config');
		
		# get uri configuration
		$this->_setUris();
		
		# system configuration
		$this->_sysontModel = Zend_Registry::get('sysontModel');
		# $this->_defaultSysOntUri = $this->_config->sysont->model;
		## TODO: CHANGE IT, IF SPARQL CAN ASK IMPORTED MODELS
		$this->_defaultSysOntUri = 'http://ns.ontowiki.net/SysOnt/';


		# access control information
		$this->_acModel = Zend_Registry::get('owAc');
		$this->_acModelUri = '';
		if ($auth->hasIdentity()) {
	    	// Identity exists; get it
	    	$this->_user = $auth->getIdentity();
		} else 
			throw new Erfurt_Exception('no valid user given', 1103);
		
		# check statements ac
		$e = $this->_config->ac->statements->enabled;
		if ($e and $e == true) {
			$this->statementsAcEnabled = true;
		}
			
		# setting up right-field
		$this->_userRights = array(
				$this->_propGrantAccess	=>	array(),
				$this->_propDenyAccess	=>	array(),
				$this->_propGrantModelView	=>	array(),
				$this->_propDenyModelView	=>	array(),
				$this->_propGrantModelEdit	=>	array(),
				$this->_propDenyModelEdit	=>	array(),
				$this->_propGrantStatementsView	=>	array(),
				$this->_propDenyStatementsView	=>	array(),
				$this->_propGrantStatementsEdit	=>	array(),
				$this->_propDenyStatementsEdit	=>	array()
				);
		
		$this->_statementbasedRightsProperties = array(
				$this->_propGrantStatementsView	=>	array(),
				$this->_propDenyStatementsView	=>	array(),
				$this->_propGrantStatementsEdit	=>	array(),
				$this->_propDenyStatementsEdit	=>	array()
				);
				
		
		
		$this->_getUserModelRights($this->_user['uri']);
		if ($this->_log !== null) {
			$this->_log->debug('OntoWiki_Ac::_userRights for '.$this->_user['uri']."\n".
					print_r($this->_userRights, true) .
					"\n_groupRights: " . print_r($this->_groupRights, true) .
					"\nAnyModelView: " . print_r($this->_userAnyModelViewAllowed, true). 
					"\nAnyModelEdit: " . print_r($this->_userAnyModelEditAllowed, true) . 
					"\nAnyAction: ".print_r($this->_userAnyActionAllowed, true));
		}
		
		
		# statement based ac
		#  set the default value to statements
		$GLOBALS['RAP']['conf']['database']['tblStatements'] = 'statements';
		if ($this->statementsAcEnabled 
					and file_exists(ERFURT_BASE.'Ac/Statements/'.ucfirst($this->_config->database->backend).'.php')) {
			try {
				$sbacName = 'Erfurt_Ac_Statements_'.ucfirst($this->_config->database->backend);
				$sbacObj = new $sbacName($log);
				$this->_sbacModel= $sbacObj; 
				
				# set rights/rules
				$sbacObj->setUserRules($this->_userRights);
				$sbacObj->setGroupRules($this->_groupRights);
				$sbacObj->setActiveUser($this->_user['uri']);
				# checks 
				if ($sbacObj->checkAccessRestriction()) {
					# perform sbac
					$this->statementsAcEditEnabled = $sbacObj->isEditSbac();
					#				"(2, 'http://localhost/OntoWiki/Config/tester2', 'http://xmlns.com/foaf/0.1/nick', 0x74657374657232, '', '', 'r', 'l', 2114),"
					#printr($sbacObj->editQuery("INSERT INTO `statements` (`modelID`, `subject`, `predicate`, `object`, `l_language`, `l_datatype`, `subject_is`, `object_is`) VALUES (2, 'http://localhost/OntoWiki/Config/tester2', 'http://xmlns.com/foaf/0.1/nick', 0x74657374657232, '', '', 'r', 'l')"));		 			
					#printr($sbacObj->editQuery("INSERT INTO `statements` (`modelID`, `subject`, `predicate`, `object`, `l_language`, `l_datatype`, `subject_is`, `object_is`) VALUES (2, 'http://localhost/OntoWiki/Config/tester3', 'http://ns.ontowiki.net/SysOnt/userPassword', 0x39373839386561306632646561363231343963646165346630373362343432666631323361616636, '', '', 'r', 'l')")); 
				}
				
			} catch(Exception $e) {
				$this->_log->info('error in statement based adapter');
				printr($e);
			}
		}
		#printr(debug_backtrace(), 1);exit;
		#$GLOBALS['RAP']['conf']['database']['tblStatements'] = 'statements';
	}
	
	/**
	 * check if edit-sbac is needed
	 */
	public function isEditSbac() {
		return $this->statementsAcEditEnabled; 
	}
	
	/**
	 * return sbac object
	 */
	public function getSbac() {
		return $this->_sbacModel; 
	}
	
	/**
	 * set the schema uris from config
	 * 
	 * @return void 
	 */
	private function _setUris() {
	
		$this->_anonymousUserUri 			= $this->_config->ac->user->anonymousUser;
		$this->_defaultSuperUserUri 		= $this->_config->ac->user->superAdmin;
		$this->_modelClassUri 						= $this->_config->ac->models->class;
		$this->_propAnyModel 						= $this->_config->ac->models->anyModel;
		$this->_propGrantModelView 		= $this->_config->ac->models->grantView;
		$this->_propDenyModelView 		= $this->_config->ac->models->denyView;
		$this->_propGrantModelEdit 		= $this->_config->ac->models->grantEdit;
		$this->_propDenyModelEdit 			= $this->_config->ac->models->denyEdit;
		$this->_actionClassUri 						= $this->_config->ac->action->class;
		$this->_propAnyAction 						= $this->_config->ac->action->anyAction;
		$this->_propGrantAccess 				= $this->_config->ac->action->grant;
		$this->_propDenyAccess 					= $this->_config->ac->action->deny;
		$this->_defaultActionConfigUri	= $this->_config->ac->action->config;
		
		# statementbased
		$this->_propStatementsModel 					= $this->_config->ac->statements->model;
		$this->_propGrantStatementsView 		= $this->_config->ac->statements->grantView;
		$this->_propDenyStatementsView 		= $this->_config->ac->statements->denyView;
		$this->_propGrantStatementsEdit 		= $this->_config->ac->statements->grantEdit;
		$this->_propDenyStatementsEdit 			= $this->_config->ac->statements->denyEdit;
		
	}
	
	/**
	 * parse sparql query 
	 * 
	 * @param object active model instance to query sparql
	 * @param string sparql query string
	 * @return array results
	 * @throws Erfurt_Exception if query does not work
	 */
	private function _sparql($model, $sparqlQuery) {
		# get all ns
		$prefixed_query = '';
		foreach ($model->getParsedNamespaces() as $uri => $prefix) {
			$prefixed_query .= 'PREFIX ' . $prefix . ': <' . $uri . '>' . PHP_EOL;
		}
		
		# query model
		try {
			$renderer = new Erfurt_Sparql_ResultRenderer_Plain();
			$result = $model->sparqlQuery($prefixed_query.$sparqlQuery, $renderer);
		} catch (SparqlParserException $e) {
			$this->_log->info('Ac::_sparql() - query contains the following error: '.$e->getMessage());
			die('Ac::_sparql() - query contains the following error: '.$e->getMessage());
			return false;
		} catch (Exception $e) {
			$this->_log->info('Ac::_sparql() - There was a problem with your query, most likely due to a syntax error.: '.$e->getMessage());
			die('Ac::_sparql() - There was a problem with your query, most likely due to a syntax error.: '.$e->getMessage());
			return false;
		}
		return $result;
	}
	
	/**
	 * gets the user rights for the current user
	 * 
	 * @param string user uri
	 */
	private function _getUserModelRights($userURI) {
		
		if ($this->_log !== null) {
			$this->_log->debug('OntoWiki_Ac::_getUserModelRights()');
		}
		
		
		
		# super admin
		if ($userURI == $this->_defaultSuperUserUri) {
			$this->_userAnyActionAllowed = true;
			$this->_userAnyModelEditAllowed = true;
			return;
		}
		
		# user groups
		$sparqlQuery = '
			select ?group ?p ?o
			where {
				?group ?p ?o.
				?group <'.$this->_config->ac->group->membership.'> <'.$this->_user['uri'].'>.
			}';
			
		if ($this->_log !== null) {
			$this->_log->debug('Query for user groups: ' . $sparqlQuery);
		}
		
		if ($result = $this->_sparql($this->_acModel, $sparqlQuery)) {
			$this->_filterAcess($result, true);
		}
		
		## direct user rightsgrantEdit
		$sparqlQuery = '
			select ?s ?p ?o
			where {
				?s ?p ?o.
				<'.$this->_user['uri'].'> ?p ?o.
			}';
			
		if ($this->_log !== null) {
			$this->_log->debug('Query for user rights: ' . $sparqlQuery);
		}
		
		if ($result = $this->_sparql($this->_acModel, $sparqlQuery)) {
			$this->_filterAcess($result);
		}
		
		##  now look for forbidden any model
		# view
		if (in_array($this->_propAnyModel, $this->_userRights[$this->_propDenyModelView])) {
			$this->_userAnyModelViewAllowed = false;
			$this->_userAnyModelEditAllowed = false;
			$this->_userRights[$this->_propGrantModelView]  = array();
			$this->_userRights[$this->_propGrantModelEdit]  = array();
		}
		
		# edit
		if (in_array($this->_propAnyModel, $this->_userRights[$this->_propDenyModelEdit])) {
			$this->_userAnyModelEditAllowed = false;
			$this->_userRights[$this->_propGrantModelEdit]  = array();
		}
		
	}
	
	/**
	 * filter the sparql results
	 * 
	 * saves the results in class var  
	 * 
	 * @param array list of sparql results
	 * @param bool acl's for groups
	 * @return void
	 */
	private function _filterAcess($resultList, $group = false) { // TODO: remove = array()
		// print_r($resultList);exit();
		foreach($resultList as $entry) {			
			if ($entry['o'] instanceof Literal ) continue;
			
			if ($this->_log !== null) {
				$this->_log->debug('Checked o:' . $entry['o'] . ', p:' . $entry['p']);
			}
			
			
			# any action allowed
			if ($entry['o'] == $this->_propAnyAction /*and $entry['p'] == $this->_propGrantAccess*/) {
				$this->_userAnyActionAllowed = true;
				// print_r($entry); exit();
			}
			# any model allowed
			else if ($entry['o'] == $this->_propAnyModel and $entry['p'] == $this->_propGrantModelView) {
				$this->_userAnyModelViewAllowed = true;
			} else if ($entry['o'] == $this->_propAnyModel and $entry['p'] == $this->_propGrantModelEdit) {
				$this->_userAnyModelEditAllowed = true;
			}
			# grant action
			else if ($entry['p'] == $this->_propGrantAccess) {
				if (!in_array($entry['o'], $this->_userRights[$this->_propGrantAccess]))
					$this->_userRights[$this->_propGrantAccess][] = $entry['o'];
			}
			# deny action
			else if ($entry['p'] == $this->_propDenyAccess) {
				if (!in_array($entry['o'], $this->_userRights[$this->_propDenyAccess]))
					$this->_userRights[$this->_propDenyAccess][] = $entry['o'];
			}
			# othter model & statements
			foreach($this->_userRights as $rightUri => $val) {
				# filter statements for groups
				if ($group and array_key_exists($entry['p'], $this->_statementbasedRightsProperties)) continue;
				# perform
				if ($entry['p'] == $rightUri and !in_array($entry['o'], $this->_userRights[$rightUri])) {
					$this->_userRights[$rightUri][] = $entry['o'];
				}
			}
			
			# group statementbased
			if ($group and $this->statementsAcEnabled) {
				if (!array_key_exists($entry['p'], $this->_statementbasedRightsProperties)) continue;
				
				if (!array_key_exists($entry['group'], $this->_groupRights)) {
					$this->_groupRights[$entry['group']] = $this->_statementbasedRightsProperties;
				}
				$this->_groupRights[$entry['group']][$entry['p']][] = $entry['o'];
			}
		}
	}
	
		
	/**
	 * checks the permission for a user action
	 *
	 * @param string name of the access-type: view || edit
	 * @param string modelUri
	 * @return bool allowed or denied
	 */
	public function isModelAllowed($type, $modelUri) {
		$type = strtolower($type);
		# not supported type
		if (!in_array($type, array('view', 'edit')))
			return false;
		
		## return view
		if ($type == 'view')
			# explicit forbidden
 			if (in_array($modelUri, $this->_userRights[$this->_propDenyModelView]))
 				return false;
			# view explicit allowed and not denied
			else if (in_array($modelUri, $this->_userRights[$this->_propGrantModelView])) 
				return true;
			# view in edit allowed and not denied
			else if (in_array($modelUri, $this->_userRights[$this->_propGrantModelEdit]))
				return true;
			# any model
			else if ($this->isAnyModelAllowed('view'))
				return true;
			
		## return edit
		if ($type == 'edit')
			# explicit forbidden
			if (in_array($modelUri, $this->_userRights[$this->_propDenyModelEdit]))
				return false;
			# edit allowed and not denied
			else if (in_array($modelUri, $this->_userRights[$this->_propGrantModelEdit]))
				return true;
			# any model
			else if ($this->isAnyModelAllowed('edit'))
				return true;
		
		## denied =>false
		return false;
	}
	
	/**
	 * checks the permission for any models 
	 *
	 * @return bool allowed or denied
	 */
	public function isAnyModelAllowed($type = 'view') {
		$type = strtolower($type);
		# not supported type
		if (!in_array($type, array('view', 'edit')))
			return false;
		
		 # true, if view: any model editable or viewable, edit: editable
		return ($type == 'view')  ? (($this->_userAnyModelViewAllowed or $this->_userAnyModelEditAllowed) ? true : false) : $this->_userAnyModelEditAllowed;
	}
		
	
	/**
	 * delievers list of allowed models
	 *  
	 * @param string name of the access type
	 * @return array list of actions
	 */
	public function getAllowedModels($type = 'view') {
		$type = strtolower($type);
		# not supported type
		if (!in_array($type, array('view', 'edit')))
			return array();
		$ret = array();
		
		$grantModelKey = ($type == 'view') ? $this->_propGrantModelView : $this->_propGrantModelEdit;
		$denyModelKey = ($type == 'view') ? $this->_propDenyModelView : $this->_propDenyModelEdit;
		
		# filter denied models
		foreach ($this->_userRights[$grantModelKey] as $a) {
			if (in_array($a, $this->_userRights[$denyModelKey])) continue;
			$ret[] = $a;
		}
		return $ret;
	}
	
	/**
	 * delievers list of denied models
	 *
	 * @param string name of the access type
	 * @return array list of actions
	 */
	public function getDeniedModels($type = 'view') {
		$type = strtolower($type);
		# not supported type
		if (!in_array($type, array('view', 'edit')))
			return false;
		
		$denyModelKey = ($type == 'view') ? $this->_propDenyModelView : $this->_propDenyModelEdit;
		return $this->_userRights[$denyModelKey];
	}
	
	/**
	 * delivers action configuration
	 */
	public function getActionConfig($action) {
		$actionUri = $this->_defaultSysOntUri.$action;
		
		## direct action config
		$sparqlQuery = 'select ?o 
													where { 
														<'.$actionUri.'> <'.$this->_defaultActionConfigUri.'> ?o.
													}';
		
		$ret = array();
		if ($result = $this->_sparql($this->_sysontModel, $sparqlQuery)) {
			foreach($result as $r) {
				$s = explode('=', $r['o']);
				# remove quotas
				if (substr($s[1], 0, 1) == '"') $s[1] = substr($s[1], 1);
				if (substr($s[1], -1) == '"') $s[1] = substr($s[1], 0,  -1);
				$ret[$s[0]] = $s[1];
			}
			if (isset($this->_defaultActionConfigs[$actionUri])) {
				$this->_defaultActionConfigs[$actionUri] = array_merge($this->_defaultActionConfigs[$actionUri], $ret);
			} else {
				$this->_defaultActionConfigs[$actionUri] = $ret;
			}
		}
		
		## standard config
		if (isset($this->_defaultActionConfigs[$actionUri])) {
			return $this->_defaultActionConfigs[$actionUri];
		}
		return array();
	}
	
	/**
	 * delievers list of allowed actions
	 *  
	 * @return array list of actions
	 */
	public function getAllowedActions() {
		$ret = array();
		# filter denied actions
		foreach ($this->_userRights[$this->_propGrantAccess] as $a) {
			if (in_array($a, $this->_userRights[$this->_propDenyAccess])) continue;
			$ret[] = $a;
		}
		return $ret;
	}
	
	/**
	 * delievers list of denied actions
	 *
	 * @return array list of actions
	 */
	public function getDeniedActions() {
		return $this->_userRights[$this->_propDenyAccess]; 
	}
	
	/**
	 * checks the any action permission
	 *
	 * @return bool allowed or denied
	 */
	public function isAnyActionAllowed() {
		return $this->_userAnyActionAllowed;
	}
	
	/**
	 * checks the action permission of an the active user
	 *
	 * @param string name of the user-action
	 * @return bool allowed or denied
	 * */
	public function isActionAllowed($action) {
		$action = $this->_defaultSysOntUri.$action;
		if (in_array($action, $this->_userRights[$this->_propDenyAccess]))
			return false;
		if (in_array($action, $this->_userRights[$this->_propGrantAccess])) 
			return true;
		if ($this->isAnyActionAllowed())
			return true;
			
		return false;
	}
	
	/**
	 * adds an right for the current user
	 * 
	 * @param string model uri
	 * @param string type of access: view or edit
	 * @param string permission: grant or deny
	 * @return boolean result of the add process
	 * @throws Erfurt_Exception if wrong type or permission was submitted 
	 */
	public function setUserModelRight($modelUri, $type = 'view', $perm = 'grant') {
		if (!in_array($type, array('view', 'edit')))
			throw new Erfurt_Exception('wrong type submitted', 1101);
		if (!in_array($perm, array('grant', 'deny')))
			throw new Erfurt_Exception('wrong perm type submitted', 1102);
			
		$prop = ($view == 'edit') ? (($perm == 'grant') ? $this->_propGrantModelEdit : $this->_propDenyModelEdit) : (($perm == 'grant') ? $this->_propGrantModelView : $this->_propDenyModelView);
		$this->_userRights[$prop][] = $modelUri;
		$erg = $this->_acModel->add($this->_user['uri'], $prop, $modelUri);
		return $erg;
	}
}
?>