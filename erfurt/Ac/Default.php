<?php
/**
  * class providing OntoWiki access control support methods.
  * 
  * TODO: RECHTE REIHENFOLGE 
  *
  * @author Stefan Berger <berger@intersolut.de>
  * @version $Id: $
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
	 * instance of user-object
	 */
	protected $_user = null;
	
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
	 * default system ontology uri
	 */
	private $_defaultSysOntUri = 'http://ns.ontowiki.net/SysOnt/';
	
	/**
	 * default holder for ac information
	 */
	private $_defaultAcModelUri = 'http://localhost/OntoWiki/Config/';
	
	
	/**
	 * anonymous user uri
	 */
	private $_anonymousUserUri = 'http://ns.ontowiki.net/SysOnt/Anonymous';
	
	/**
	 * default user group uri
	 */
	private $_defaultUserGroupUri = 'http://localhost/OntoWiki/Config/DefaultUserGroup';

	/**
	 * super admin user uri
	 */
	private $_defaultSuperUserUri = 'http://ns.ontowiki.net/SysOnt/SuperAdmin';
	
	
	/**
	 * model class schma uri
	 */
	private $_modelClassUri = 'http://ns.ontowiki.net/SysOnt/Model';
	
	/**
	 * any model property 
	 */
	private $_propAnyModel = 'http://ns.ontowiki.net/SysOnt/anyModel';
	
	/**
	 * grant model view property 
	 */
	private $_propGrantModelView = 'http://ns.ontowiki.net/SysOnt/grantModelView';
	
	/**
	 * deny model view property 
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
	 * action class schma uri
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
	 * deny action property 
	 */
	private $_propDenyAccess = 'http://ns.ontowiki.net/SysOnt/denyAccess';
	
	/**
	 * array with default action configuration 
	 */
	private $_defaultActionConfigs = array();

	/**
	 * constructor
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
	
	
	
	public function init() {
		$auth = Zend_Auth::getInstance();
		$this->_config = $config = Zend_Registry::get('config');
		$this->_acModel = Zend_Registry::get('owAc');
		$this->_acModelUri = '';
		if ($auth->hasIdentity()) {
    	// Identity exists; get it
    	$this->_user = $auth->getIdentity();
		} else {
			$this->_user = $this->_getAnonymous();
		}
		
		# setting up right-field
		$this->_userRights = array(
				$this->_propGrantAccess	=>	array(),
				$this->_propDenyAccess	=>	array(),
				$this->_propGrantModelView	=>	array(),
				$this->_propDenyModelView	=>	array(),
				$this->_propGrantModelEdit	=>	array(),
				$this->_propDenyModelEdit	=>	array());
		
		$this->_getUserModelRights($this->_user['uri']);
		$this->_log->debug('OntoWiki_Ac::_userRights'."\n".print_r($this->_userRights, true) .
				"\nAnyModelView: " . print_r($this->_userAnyModelViewAllowed, true). 
				"\nAnyModelEdit: " . print_r($this->_userAnyModelEditAllowed, true) . 
				"\nAnyAction: ".print_r($this->_userAnyActionAllowed, true));
		
		
	}
	
	/**
	 * parse sparql query 
	 */
	private function _sparql($sparqlQuery) {
		static $prefixed_query;
		
		# get all 
		if ($prefixed_query == '') { 
		$prefixed_query = '';
			foreach ($this->_acModel->getParsedNamespaces() as $uri => $prefix) {
				$prefixed_query .= 'PREFIX ' . $prefix . ': <' . $uri . '>' . PHP_EOL;
			}
		}
		# query model
		try {
			$result = $this->_acModel->sparqlQuery($prefixed_query.$sparqlQuery, false);
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
	 */
	private function _getUserModelRights($userURI) {
		$this->_log->debug('OntoWiki_Ac::_getUserModelRights()');
		
		
		# super admin
		if ($userURI == $this->_defaultSuperUserUri) {
			$this->_userAnyActionAllowed = true;
			$this->_userAnyModelEditAllowed = true;
			return;
		}
		
		## direct user rights
		$sparqlQuery = 'select ?p ?o 
													where { 
														<'.$this->_user['uri'].'> ?p ?o.
													}';
		
		if ($result = $this->_sparql($sparqlQuery)) {
			$this->_filterAcess($result);
		}
		
		# user groups
		$sparqlQuery = 'select ?p ?o 
													where { 
														?group ?p ?o.
														?group <'.$this->_config->ac->group->membership.'> <'.$this->_user['uri'].'>.
													}';
		if ($result = $this->_sparql($sparqlQuery)) {
			$this->_filterAcess($result);
		}
	}
	
	/**
	 * filter the sparql results 
	 */
	private function _filterAcess($resultList) {
		foreach($resultList as $entry) {
			if ($entry['?o'] instanceof Literal ) continue;
			
			# any action allowed
			if ($entry['?o']->getUri() == $this->_propAnyAction and $entry['?p']->getUri() == $this->_propGrantAccess) {
				$this->_userAnyActionAllowed = true;
			}
			# any model allowed
			else if ($entry['?o']->getUri() == $this->_propAnyModel and $entry['?p']->getUri() == $this->_propGrantModelView) {
				$this->_userAnyModelViewAllowed = true;
			} else if ($entry['?o']->getUri() == $this->_propAnyModel and $entry['?p']->getUri() == $this->_propGrantModelEdit) {
				$this->_userAnyModelEditAllowed = true;
			}
			# grant action
			else if ($entry['?p']->getUri() == $this->_propGrantAccess) {
				if (!in_array($entry['?o']->getLocalName(), $this->_userRights[$this->_propGrantAccess]))
					$this->_userRights[$this->_propGrantAccess][] = $entry['?o']->getLocalName();
			}
			# deny action
			else if ($entry['?p']->getUri() == $this->_propDenyAccess) {
				if (!in_array($entry['?o']->getLocalName(), $this->_userRights[$this->_propDenyAccess]))
					$this->_userRights[$this->_propDenyAccess][] = $entry['?o']->getLocalName();
			}
			# othter model
			foreach($this->_userRights as $rightUri => $val) {
				if ($entry['?p']->getUri() == $rightUri and !in_array($entry['?o']->getUri(), $this->_userRights[$rightUri])) {
					$this->_userRights[$rightUri][] = $entry['?o']->getUri();
				}
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
		## standard config
		if (isset($this->_defaultActionConfigs[$actionUri])) {
			return $this->_defaultActionConfigs[$actionUri];
		}
		return array();
		
		# TODO: OBSOLETE
		## direct action config
	/*
		$sparqlQuery = 'select ?o 
													where { 
														<'.$actionUri.'> <'.$this->_defaultActionConfigUri.'> ?o.
													}';
		
		$ret = array();
		if ($result = $this->_sparql($sparqlQuery)) {
			foreach($result as $r) {
				$s = explode('=', $r['?o']->getLabel());
				$ret[$s[0]] = $s[1];
			}
		}
		return $ret;
	*/
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
}
?>