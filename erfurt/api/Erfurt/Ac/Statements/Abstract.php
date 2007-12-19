<?php
/**
  * abstract class providing OntoWiki statement based ac
  *
  * @package ac
  * @author Stefan Berger <berger@intersolut.de>
  * @version $Id$
  */
abstract class Erfurt_Ac_Statements_Abstract implements  Erfurt_Ac_Statements_Interface {
	
	/**
	 * instance of config-object
	 * 
	 * @var object
	 */
	protected $_config = null;
	
	
	/**
	 * instance of log-object
	 * 
	 * @var object
	 */
	protected $_log = null;
	
	/**
	 * agent needs read sbac 
	 * 
	 * @var boolean
	 */
	protected $_needViewSbac = false;
	
	/**
	 * agent needs edit sbac
	 * 
	 * @var boolean
	 */
	protected $_needEditSbac = false;
	
	/**
	 * common view name
	 * 
	 * @var string
	 */
	protected $_viewName = '';
	
	/**
	 * agents personal read sbac view
	 * 
	 * @var string
	 */
	protected $_personalViewName = '';
	
	/**
	 * agents personal edit sbac view
	 * 
	 * @var string
	 */
	protected $_personalEditName = '';
	
	/**
	 * instance of the sysont-Model
	 * 
	 * @var object
	 */
	protected $_sysontModel = null;
	
	/**
	 * field of agent personal rules
	 * 
	 * @var array
	 */
	protected $_userRules = null;
	
	/**
	 * field of group rules
	 * 
	 * @var array
	 */
	protected $_groupRules = null;

	/**
	 * agent uri
	 * 
	 * @var string
	 */
	protected $_activeUserUri = '';
	
	/**
	 * field of rules
	 * 
	 * @var array
	 */
	protected $_rules = null;
	
	/**
	 * model uri
	 * 
	 * @var string 
	 */
	protected  $_propStatementsModel = 'http://ns.ontowiki.net/SysOnt/model';
	/**
	 * grant statements view 
	 * 
	 * @var string
	 */
	protected $_propGrantStatementsView = 'http://ns.ontowiki.net/SysOnt/grantStatementsView';
	
	/**
	 * deny statements view
	 * 
	 * @var string 
	 */
	protected $_propDenyStatementsView = 'http://ns.ontowiki.net/SysOnt/denyStatementsView';
	
	/**
	 * grant statements edit 
	 * 
	 * @var string
	 */
	protected $_propGrantStatementsEdit = 'http://ns.ontowiki.net/SysOnt/grantStatementsEdit';
	
	/**
	 * deny statements edit
	 * 
	 * @var string 
	 */
	protected $_propDenyStatementsEdit = 'http://ns.ontowiki.net/SysOnt/denyStatementsEdit';
	
	/**
	 * sqarql where clause
	 * 
	 * @var string
	 */
	protected  $_propSparqlClause = 'http://ns.ontowiki.net/SysOnt/denyStatementsEdit';
	
	/**
	 * current User rule replace 
	 * 
	 * @var string
	 */
	protected $_currentUserReplace = '%currentUser%';
	
	/**
	 * current selector subject rule replace 
	 * 
	 * @var string
	 */
	protected $_selectorSubjectReplace = '%selectorSubject%';
	
	
	/**
	 * Constructor
	 */
	public function __construct(Zend_Log $log = null) {
		# set special log object
		if (Zend_Registry::isRegistered('erfurtLog')) {
			$this->_log = Zend_Registry::get('erfurtLog');
		} else {
			$this->_log = $log;
		}
		
		# system configuration
		$this->_sysontModel = Zend_Registry::get('sysontModel');
		
		# set config
		$this->_config = $config = Zend_Registry::get('config');
		$this->_setUris();
	}
	
	/**
	 * parse sparql query 
	 * 
	 * @param object active model instance to query sparql
	 * @param string sparql query string
	 * @return array results
	 * @throws Erfurt_Exception if query does not work
	 */
	private function _sparql($sparqlQuery) {
		static $prefixed_query;
		$model = $this->_sysontModel;
		# get all ns
		if (empty($prefixed_query)) {
			$prefixed_query = '';
			foreach ($model->getParsedNamespaces() as $uri => $prefix) {
				$prefixed_query .= 'PREFIX ' . $prefix . ': <' . $uri . '>' . PHP_EOL;
			}
		}
		
		# query model
		try {
			$result = $model->sparqlQuery($prefixed_query.$sparqlQuery, false);
		} catch (SparqlParserException $e) {
			$this->_log->info('Ac_Statements::_sparql() - query contains the following error: '.$e->getMessage());
			die('Ac_Statements::_sparql() - query contains the following error: '.$e->getMessage());
			return false;
		} catch (Exception $e) {
			$this->_log->info('Ac_Statements::_sparql() - There was a problem with your query, most likely due to a syntax error.: '.$e->getMessage());
			die('Ac_Statements::_sparql() - There was a problem with your query, most likely due to a syntax error.: '.$e->getMessage());
			return false;
		}
		return $result;
	}
	
	/**
	 * set the schema uris from config
	 * 
	 * @return void 
	 */
	private function _setUris() {
		$this->_propStatementsModel 					= $this->_config->ac->statements->model;
		$this->_propSparqlClause 								= $this->_config->ac->statements->sparql;
		$this->_propGrantStatementsView 		= $this->_config->ac->statements->grantView;
		$this->_propDenyStatementsView 		= $this->_config->ac->statements->denyView;
		$this->_propGrantStatementsEdit 		= $this->_config->ac->statements->grantEdit;
		$this->_propDenyStatementsEdit 			= $this->_config->ac->statements->denyEdit;
	}
	
	public function setUserRules(Array &$rules) {
		$this->_userRules = &$rules;
	}
	
	public function setGroupRules(Array &$rules) {
		$this->_groupRules = &$rules;
	}
	
	
	public function setActiveUser($uri) {
		$this->_activeUserUri = $uri;
	}
	
	
	/**
	 * Checks, if a special access is needed
	 */
	public function checkAccessRestriction () {
		#if ($this->_userRules == null or $this->_groupRules == null or $this->_activeUserUri == '') 
			#throw new Erfurt_Exception('missing rules data', 1150);
		
		# check read 
		if ($this->checkViewAccessRestriction()) {
			# get rule details
			$this->_rules = $this->_getRuleDetails($this->getSelectors());
			# depending on store 
			$this->performViewRestriction();
		}
		
		# check write 
		if ($this->checkEditAccessRestriction()) {
			# get rule details
			if ($this->_rules == null) 
				$this->_rules = $this->_getRuleDetails($this->getSelectors());
			# depending on store
			$this->performEditRestriction();
		}
		
		# sbac used?
		if ($this->_needViewSbac or $this->_needEditSbac) { 
			return true;
		}
		return false;
	}
	
	public function isViewSbac() {
		return $this->_needViewSbac; 
	}
	
	public function isEditSbac() {
		return $this->_needEditSbac; 
	}
	
	/**
	 * check for an personal user view or using a group view 
	 */
	public function personalViewNeeded($type = 'view') {
		# check groups or personal infos
		if ($this->checkUserViewAccessRestriction() 
					or $this->checkGroupViewAccessRestriction() > 1) {
					return true;
		}
		## check dynamic rules
		# check for group rules
		if ($this->checkGroupReplacement($type)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * check for an personal user view or using a group view 
	 */
	public function groupViewNeeded($type = 'view') {
		# check groups or personal infos
		if ($this->checkGroupViewAccessRestriction() == 1)
			return true;
		
			
		## check dynamic rules
		# check for group rules
		if ($this->checkGroupReplacement($type)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Checks, if a special read access is needed
	 */
	public function checkViewAccessRestriction () {
		# check user
		if ($this->checkUserViewAccessRestriction ()) {
			return true;
		}
		
		# check group
		if ($this->checkGroupViewAccessRestriction()) {
			return true;
		}
		return false;
	}
	
	/**
	 * looks for avaiable props
	 */
	protected function checkUserViewAccessRestriction () {
		if (count($this->_userRules[$this->_propGrantStatementsView]) > 0
				 or count($this->_userRules[$this->_propDenyStatementsView]) > 0) {
			return true;		 	
		}
		return false;
	}
	
	
	/**
	 * return number of groups with sbac infos
	 */	
	protected function checkGroupViewAccessRestriction() {
		$ret = 0;
		foreach($this->_groupRules as $groupUri => $props) {
			if ($this->checkGroupViewAccessPropsRestriction($props)) {
				$ret++;
			}
		}
		
		return $ret;
	}
	
	/**
	 * helper function for checkGroupViewAccessRestriction
	 */
	protected function checkGroupViewAccessPropsRestriction(Array $props) {
		if (count($props[$this->_propGrantStatementsView]) > 0
					 or count($props[$this->_propDenyStatementsView]) > 0) {
				return true;		 	
		}
		return false;
	}
	
	
	
	/**
	 * Checks, if a special write access is needed
	 */
	public function checkEditAccessRestriction () {
		# check user
		if ($this->checkUserEditAccessRestriction ()) {
			return true;
		}
		
		# check group
		if ($this->checkGroupEditAccessRestriction()) {
			return true;
		}
		return false;
	}
	
	
	/**
	 * looks for avaiable props
	 */
	protected function checkUserEditAccessRestriction () {
		if (count($this->_userRules[$this->_propGrantStatementsEdit]) > 0
				 or count($this->_userRules[$this->_propDenyStatementsEdit]) > 0
				 or count($this->_userRules[$this->_propDenyStatementsView]) > 0) {
			return true;		 	
		}
		return false;
	}
	
	
	/**
	 * return number of groups with sbac infos
	 */	
	protected function checkGroupEditAccessRestriction() {
		$ret = 0;
		foreach($this->_groupRules as $groupUri => $props) {
			if ($this->checkGroupEditAccessPropsRestriction($props)) {
				$ret++;
			}
		}
		
		return $ret;
	}
	
	/**
	 * helper function for checkGroupViewAccessRestriction
	 */
	protected function checkGroupEditAccessPropsRestriction(Array $props) {
		if (count($props[$this->_propGrantStatementsEdit]) > 0
					 or count($props[$this->_propDenyStatementsEdit]) > 0
					 or count($props[$this->_propDenyStatementsView]) > 0) {
				return true;		 	
		}
		return false;
	}
	
	
	protected function getSelectors($type = '') {
		$ret = array();
		# view  or all
		if ($type == '' or $type == 'view') {
			# user
			$ret = $this->getViewSelectors($this->_userRules, $this->_activeUserUri, $ret);
			
			# groups
			foreach ($this->_groupRules as $groupUri => $data) {
				$ret = $this->getViewSelectors($data, $groupUri, $ret);
			}
		}
		# edit or all
		if ($type == '' or $type == 'edit') {
			# user
			$ret = $this->getEditSelectors($this->_userRules, $this->_activeUserUri, $ret);
			# groups
			foreach ($this->_groupRules as $groupUri => $data) {
				$ret = $this->getEditSelectors($data, $groupUri, $ret);
			}
		}
		return $ret;
	}
	
	/**
	 * return view selectors
	 */
	protected function getViewSelectors($data, $subject, $ret) {
		foreach($data[$this->_propGrantStatementsView] as $ruleUri) {
			if (!isset ($ret[$subject][$this->_propGrantStatementsView]) 
					or !in_array($ruleUri, $ret[$subject][$this->_propGrantStatementsView]))
				$ret[$subject][$this->_propGrantStatementsView]  = $ruleUri;
		}
		foreach($data[$this->_propDenyStatementsView] as $ruleUri) {
			if (!isset ($ret[$subject][$this->_propDenyStatementsView]) 
					or !in_array($ruleUri, $ret[$subject][$this->_propDenyStatementsView]))
				$ret[$subject][$this->_propDenyStatementsView]  = $ruleUri;
		}
		# edit allowed
		foreach($data[$this->_propGrantStatementsEdit] as $ruleUri) {
			if (!isset ($ret[$subject][$this->_propDenyStatementsView]) 
					or !in_array($ruleUri, $ret[$subject][$this->_propDenyStatementsView]))
				$ret[$subject][$this->_propDenyStatementsView] = $ruleUri;
		}
		return $ret; 
	}
	
	/**
	 * return edit selectors
	 */
	protected function getEditSelectors($data, $subject, $ret) {
		foreach($data[$this->_propGrantStatementsEdit] as $ruleUri) {
			if (!isset ($ret[$subject][$this->_propGrantStatementsEdit]) 
					or !in_array($ruleUri, $ret[$subject][$this->_propGrantStatementsEdit]))
				$ret[$subject][$this->_propGrantStatementsEdit] = $ruleUri;
				
			#if (!in_array($ruleUri, $ret))
				#(is_array($ret[$subject])) ? $ret[$subject][]  = $ruleUri : $ret[$subject] = array($ruleUri);
		}
		foreach($data[$this->_propDenyStatementsEdit] as $ruleUri) {
			if (!isset ($ret[$subject][$this->_propDenyStatementsEdit]) 
					or !in_array($ruleUri, $ret[$subject][$this->_propDenyStatementsEdit]))
				$ret[$subject][$this->_propDenyStatementsEdit] = $ruleUri;
			#if (!in_array($ruleUri, $ret))
			#	(is_array($ret[$subject])) ? $ret[$subject][]  = $ruleUri : $ret[$subject] = array($ruleUri);
		}
		
		# deny view
		foreach($data[$this->_propDenyStatementsView] as $ruleUri) {
			if (!isset ($ret[$subject][$this->_propDenyStatementsEdit]) 
					or !in_array($ruleUri, $ret[$subject][$this->_propDenyStatementsEdit]))
				$ret[$subject][$this->_propDenyStatementsEdit] = $ruleUri;
			#if (!in_array($ruleUri, $ret))
			#(is_array($ret[$subject])) ? $ret[$subject][]  = $ruleUri : $ret[$subject] = array($ruleUri);
			#	$ret[$subject][$this->_propDenyStatementsView]  = $ruleUri;
		}
		
		return $ret;
	}
	
	/**
	 * return number of groups with sbac infos
	 */	
	protected function checkUserReplacement($type = 'view') {
		foreach($this->_userRules as $propUri => $selector) {
			foreach($selector as $selectorUri) {
				if ($type == 'view' 
						and $propUri != $this->_propGrantStatementsView 
						and $propUri != $this->_propDenyStatementsView) continue;
				
				if ($type == 'edit' 
							and $propUri != $this->_propGrantStatementsEdit
							and $propUri != $this->_propDenyStatementsEdit 
							and $propUri != $this->_propDenyStatementsView) continue;
				
				if ($this->_rules[$selectorUri]['individual'] == true )
					return true;
			}
		}
		return false;
	}
	
	/**
	 * return number of groups with sbac infos
	 */	
	protected function checkGroupReplacement($type = 'view') { 
		foreach($this->_groupRules as $groupUri => $props) {
			foreach($props as $propUri => $selector) {
				foreach($selector as $selectorUri) {
					if ($type == 'view' 
							and $propUri != $this->_propGrantStatementsView 
							and $propUri != $this->_propDenyStatementsView) continue;
	
					if ($type == 'edit' 
							and $propUri != $this->_propGrantStatementsEdit
							and $propUri != $this->_propDenyStatementsEdit 
							and $propUri != $this->_propDenyStatementsView) continue;
					
					
					if ($this->_rules[$selectorUri]['individual'] == true )
						return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * returns the details of some selectors
	 * 
	 * gets some selector informations from database 
	 * and retrieves detail informations
	 * 
	 * @return array selector informations
	 */
	public function getSelectorDetails(Array $selectors) {
		$sel = array();
		$sparqlQuery = 'SELECT ?s ?p ?o
			WHERE {
  		?s ?p ?o.
			';
		
		foreach($selectors as $selector) {
			if (!is_array($selector)) continue;
			foreach($selector as $selectorUri) {
				if (in_array($selectorUri, $sel)) continue;
			 	$sparqlQuery .= "{<".$selectorUri."> ?p ?o} UNION ";
			 	$sel[] = $selectorUri;
			}
		}
		$sparqlQuery = substr($sparqlQuery, 0, -6);
		$sparqlQuery .= '} ORDER BY ?s';
		
		$result = array();
		if (count($sel) > 0 and $result = $this->_sparql($sparqlQuery)) {
			
			#$this->_filterAcess($result);
		}
		
		return $result;
	}
	
	
	/**
	 * get first key of an array
	 * 
	 * @return mixed key if is array or false
	 */
	public function getFirstKey($arr) {
		foreach($arr as $k => $v)
			return $k;
		return false;	
	}
}