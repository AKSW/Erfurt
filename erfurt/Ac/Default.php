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
																							'grantAccess'	=>	array(),
																							'denyAccess'	=>	array()
																							);
	
	/**
	 * anonymous user uri
	 */
	private $_anonymousUserUri = 'http://ns.ontowiki.net/SysOnt/Anonymous';
	
	/**
	 * default user group uri
	 */
	private $_defaultUserGroupUri = 'http://localhost/OntoWiki/Config/DefaultUserGroup';
	
	/**
	 * default system ontology uri
	 */
	private $_defaultSysOntUri = 'http://ns.ontowiki.net/SysOnt/';
	
	/**
	 * default holder for ac information
	 */
	private $_defaultAcModelUri = 'http://ns.ontowiki.net/SysOnt/';
	
	
	/**
	 * default action property uri
	 */
	private $_defaultActionConfigUri = 'http://ns.ontowiki.net/SysOnt/rawConfig';
	
	
	/**
	 * any model property 
	 */
	private $_propAnyModel = 'AnyModel';
	
	/**
	 * grant model view property 
	 */
	private $_propGrantModelView = 'grantModelView';
	
	/**
	 * deny model view property 
	 */
	private $_propDenyModelView = 'denyModelView';
	
	/**
	 * grant model edit property 
	 */
	private $_propGrantModelEdit = 'grantModelEdit';
	
	/**
	 * deny model edit property 
	 */
	private $_propDenyModelEdit = 'denyModelEdit';
	
	/**
	 * any action property 
	 */
	private $_propAnyAction = 'AnyAction';
	
	/**
	 * grant action property 
	 */
	private $_propGrantAccess = 'grantAccess';
	
	/**
	 * deny action property 
	 */
	private $_propDenyAccess = 'denyAccess';
	
	
/**
	 * NUR ABLAGE, SOLANGE AUTH NICH TIMMER ETWAS ZURÜC GIBT
	 * delievers the anonymous user details 
	 */
	public function _getAnonymous() {	
		$user['userName'] = 'Anonymous';
		$user['uri'] = $this->_anonymousUserUri;
		$user['dbuser'] = false;
		$user['email'] = '';
		return $user;
	}
	
	/**
	 * constructor
	 */
	public function __construct(Zend_Log $log = null) {
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
		
		$this->_getUserModelRights($this->_user['uri']);
		#printr($this->_userRights);
		
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
				if ($entry['?o']->getUri() == $this->_defaultSysOntUri.$this->_propAnyAction and $entry['?p']->getUri() == $this->_defaultSysOntUri.$this->_propGrantAccess) {
					$this->_userAnyActionAllowed = true;
				}
				# any model allowed
				else if ($entry['?o']->getUri() == $this->_defaultSysOntUri.$this->_propAnyModel and $entry['?p']->getUri() == $this->_defaultSysOntUri.$this->_propGrantModelView) {
					$this->_userAnyModelViewAllowed = true;
				} else if ($entry['?o']->getUri() == $this->_defaultSysOntUri.$this->_propAnyModel and $entry['?p']->getUri() == $this->_defaultSysOntUri.$this->_propGrantModelEdit) {
					$this->_userAnyModelEditAllowed = true;
				}
				# grant action
				else if ($entry['?p']->getUri() == $this->_defaultSysOntUri.$this->_propGrantAccess) {
					if (!in_array($entry['?o']->getLocalName(), $this->_userRights[$this->_propGrantAccess]))
						$this->_userRights[$this->_propGrantAccess][] = $entry['?o']->getLocalName();
				}
				# deny action
				else if ($entry['?p']->getUri() == $this->_propDenyAccess) {
					if (!in_array($entry['?o']->getLocalName(), $this->_userRights[$this->_propDenyAccess]))
						$this->_userRights[$this->_propDenyAccess][] = $entry['?o']->getLocalName();
				}
				# othter model
				foreach($this->_userRights as $right => $val) {
					if ($entry['?p']->getUri() == $this->_defaultSysOntUri.$right and !in_array($entry['?o']->getUri(), $this->_userRights[$right])) {
						$this->_userRights[$right][] = $entry['?o']->getUri();
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
 			if (in_array($modelUri, $this->_userRights['denyModelView']))
 				return false;
			# view explicit allowed and not denied
			else if (in_array($modelUri, $this->_userRights['grantModelView'])) 
				return true;
			# view in edit allowed and not denied
			else if (in_array($modelUri, $this->_userRights['grantModelEdit']))
				return true;
			# any model
			else if ($this->isAnyModelAllowed('view'))
				return true;
			
		## return edit
		if ($type == 'edit')
			# explicit forbidden
			if (in_array($modelUri, $this->_userRights['denyModelEdit']))
				return false;
			# edit allowed and not denied
			else if (in_array($modelUri, $this->_userRights['grantModelEdit']))
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
		# filter denied actions
		foreach ($this->_userRights['grantModel'.ucfirst($type)] as $a) {
			if (in_array($a, $this->_userRights['denyModel'.ucfirst($type)])) continue;
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
		
		return $this->_userRights['denyAccess'.ucfirst($type)];
	}
	
	/**
	 * delivers action configuration
	 */
	public function getActionConfig($action) {
		$actionUri = $this->_defaultSysOntUri.$action;
		## standard config
		
		## direct action config
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
	}
	
	/**
	 * delievers list of allowed actions
	 *  
	 * @return array list of actions
	 */
	public function getAllowedActions() {
		$ret = array();
		# filter denied actions
		foreach ($this->_userRights['grantAccess'] as $a) {
			if (in_array($a, $this->_userRights['denyAccess'])) continue;
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
		return $this->_userRights['denyAccess'];
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
		if (in_array($action, $this->_userRights['denyAccess']))
			return false;
		if (in_array($action, $this->_userRights['grantAccess'])) 
			return true;
		if ($this->isAnyActionAllowed())
			return true;
			
		return false;
	}
}
?>