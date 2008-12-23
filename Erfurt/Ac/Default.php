<?php
require_once 'Erfurt/App.php';

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
    
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * @var Zend_Log $_log instance of config-object
     */
    private $_log = false;
    
    /**
     * @var Zend_Config $_config instance of config-object
     */
    private $_config = false;
    
    /**
     * @var Erfurt_Rdf_Model $_acModel instance of the ac-Model
     */
    private $_acModel = false;
    
    /**
     * @var Erfurt_Rdf_Model $_sysOntModel instance of the sysont-Model
     */
    private $_sysOntModel = false;
    
    /**
     * @var array $_user instance of user-object
     */
    private $_user = false;
        
    /**
     * @var array $_userRights storage of the current user permissions 
     */
    private $_userRights = array(
        'userAnyModelViewAllowed' => false,
        'userAnyModelEditAllowed' => false,
        'userAnyActionAllowed'    => false,
        'grantAccess'             => array(),
        'denyAccess'              => array(),
        'grantModelView'          => array(),
        'denyModelView'           => array(),
        'grantModelEdit'          => array(),
        'denyModelEdit'           => array()
    );
    
    /**
     * @var array $_uris
     */
    private $_uris = array(
        'sysOntUri'          => 'http://ns.ontowiki.net/SysOnt/',
        'acModelUri'         => 'http://localhost/OntoWiki/Config/',
        'anonymousUserUri'   => 'http://ns.ontowiki.net/SysOnt/Anonymous',
        'superUserUri'       => 'http://ns.ontowiki.net/SysOnt/SuperAdmin',
        'propAnyModel'       => 'http://ns.ontowiki.net/SysOnt/anyModel',
        'propGrantModelView' => 'http://ns.ontowiki.net/SysOnt/grantModelView',
        'propDenyModelView'  => 'http://ns.ontowiki.net/SysOnt/denyModelView',
        'propGrantModelEdit' => 'http://ns.ontowiki.net/SysOnt/grantModelEdit',
        'propDenyModelEdit'  => 'http://ns.ontowiki.net/SysOnt/denyModelEdit',
        'actionClassUri'     => 'http://ns.ontowiki.net/SysOnt/Action',
        'propAnyAction'      => 'http://ns.ontowiki.net/SysOnt/anyAction',
        'propGrantAccess'    => 'http://ns.ontowiki.net/SysOnt/grantAccess',
        'propDenyAccess'     => 'http://ns.ontowiki.net/SysOnt/denyAccess',
        'modelClassUri'      => 'http://ns.ontowiki.net/SysOnt/model',
        'actionConfigUri'    => 'http://ns.ontowiki.net/SysOnt/rawConfig'
    );
    
    // TODO: make configurable
    // from: actions.ini.php
    private $_defaultActionConfig = array(
        'http://ns.ontowiki.net/SysOnt/RegisterNewUser' => array(
            'defaultGroup'   => 'http://localhost/OntoWiki/Config/DefaultUserGroup', 
            'mailvalidation' => 'yes', 
            'uidregexp'      => '/^[[:alnum:]]+$/', 
            'passregexp'     => ''
        )
    );
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * constructor
     */
    public function __construct() {
        
        $this->_init();
    }
    
    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Checks whether the user has changed and re-initializes if neccessary. 
     */
    private function _checkUserChanged()
    {
        $auth = Erfurt_App::getInstance()->getAuth();
        
        if ($auth->hasIdentity()) {
            $currentUser = $auth->getIdentity();
            
            if ($currentUser['uri'] !== $this->_user['uri']) {
                $this->_init();
            }
        } else {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('no valid user given', 1103);
        }
        
        
    }
    
    /**
     * initialisation of models, uris and rights
     * 
     */
    private function _init()
    {   
        $this->_userRights = array(
            'userAnyModelViewAllowed' => false,
            'userAnyModelEditAllowed' => false,
            'userAnyActionAllowed'    => false,
            'grantAccess'             => array(),
            'denyAccess'              => array(),
            'grantModelView'          => array(),
            'denyModelView'           => array(),
            'grantModelEdit'          => array(),
            'denyModelEdit'           => array()
        );
        
        $app =  Erfurt_App::getInstance();
        $this->_log = $app->getLog();   
        $this->_config = $app->getConfig();
        $auth = $app->getAuth();
        
        // get custom uri configuration
        $this->_setUris();
        
        // system configuration
        $this->_sysOntModel = $app->getSysOntModel();
        // $this->_uris['sysOntUri'] = $this->_sysOntModel->getModelIri();
        
        // access control informations
        $this->_acModel = $app->getAcModel();
        $this->_acModelUri = $this->_acModel->getModelIri();
        
        if ($auth->hasIdentity()) {
            // Identity exists; get it
            $this->_user = $auth->getIdentity();
        } else {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('no valid user given', 1103);
        }
        
        // check whether there is a cached value and set the user rights
        $cache = $app->getCache();
        $id = $cache->makeId($this, '_getUserModelRights', array($this->_user['uri']));
        $cachedVal = $cache->load($id);
        if ($cachedVal) {
            $this->_userRights = $cachedVal;
        } else {
            $this->_userRights = $this->_getUserModelRights($this->_user['uri']);
            $cache->save($this->_userRights);
        }
    }
    
    /**
     * set the schema uris from config
     */
    private function _setUris() {
    
        $this->_uris['anonymousUserUri']    = $this->_config->ac->user->anonymousUser;
        $this->_uris['superUserUri']        = $this->_config->ac->user->superAdmin;
        $this->_uris['propAnyModel']        = $this->_config->ac->models->anyModel;
        $this->_uris['propGrantModelView']  = $this->_config->ac->models->grantView;
        $this->_uris['propDenyModelView']   = $this->_config->ac->models->denyView;
        $this->_uris['propGrantModelEdit']  = $this->_config->ac->models->grantEdit;
        $this->_uris['propDenyModelEdit']   = $this->_config->ac->models->denyEdit;
        $this->_uris['actionClassUri']      = $this->_config->ac->action->class;
        $this->_uris['propAnyAction']       = $this->_config->ac->action->anyAction;
        $this->_uris['propGrantAccess']     = $this->_config->ac->action->grant;
        $this->_uris['propDenyAccess']      = $this->_config->ac->action->deny;
        $this->_uris['modelClassUri']       = $this->_config->ac->models->class;
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

        try {
            $sparqlQuery->addFrom($model->getModelIri());
            $result = $model->getStore()->sparqlQuery($sparqlQuery, 'plain', false);
        } catch (SparqlParserException $e) {
            $this->_log->info('Ac::_sparql() - query contains the following error: '.$e->getMessage());
            
            return false;
        } catch (Exception $e) {
            $this->_log->info('Ac::_sparql() - There was a problem with your query, most likely due to a syntax error.: '.$e->getMessage());
            
            return false;
        }

        return $result;
    }
    
    /**
     * gets the user rights for the current user
     * 
     * @param string user uri
     * @return array
     */
    private function _getUserModelRights($userURI) {
        
        $this->_log->debug('OntoWiki_Ac::_getUserModelRights()');
        
        $userRights = $this->_userRights;
        
        // super admin, i.e. a user that has database rights (only for debugging purposes)
        if ($userURI === $this->_uris['superUserUri']) {
            $userRights['userAnyActionAllowed']     = true;
            $userRights['userAnyModelEditAllowed']  = true;
            $userRights['userAnyModelViewAllowed']  = true;
            
            return $userRights;
        }
        
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $sparqlQuery = new Erfurt_Sparql_SimpleQuery();
        $sparqlQuery->setProloguePart('SELECT ?group ?p ?o');
        
        $wherePart = 'WHERE { ?group ?p ?o . ?group <' . $this->_config->ac->group->membership . '> <' .
            $this->_user['uri'] . '> }'; 
        $sparqlQuery->setWherePart($wherePart);
        
        if ($result = $this->_sparql($this->_acModel, $sparqlQuery)) {
            $this->_filterAccess($result, $userRights);
        }
        
        $sparqlQuery = new Erfurt_Sparql_SimpleQuery();
        $sparqlQuery->setProloguePart('SELECT ?s ?p ?o');
        
        $wherePart = 'WHERE { ?s ?p ?o . <' . $this->_user['uri'] . '> ?p ?o }';
        $sparqlQuery->setWherePart($wherePart);
            
        if ($result = $this->_sparql($this->_acModel, $sparqlQuery)) {
            $this->_filterAccess($result, $userRights);
        }
        
        // now check for forbidden any model
        // view
        if (in_array($this->_uris['propAnyModel'], $userRights['denyModelView'])) {
            $userRights['userAnyModelViewAllowed']  = false;
            $userRights['userAnyModelEditAllowed']  = false;
            $userRights['grantModelView']           = array();
            $userRights['grantModelEdit']           = array();
        }
        // edit
        if (in_array($this->_uris['propAnyModel'], $userRights['denyModelEdit'])) {
            $userRights['userAnyModelEditAllowed']  = false;
            $userRights['grantModelEdit']           = array();
        }
        
        return $userRights;
    }
    
    /**
     * filter the sparql results
     * 
     * saves the results in $userRights var  
     * 
     * @param array list of sparql results
     * @param bool acl's for groups
     * @return void
     */
    private function _filterAccess($resultList, &$userRights) { 
        
        foreach($resultList as $entry) {            
            // any action allowed?
            if (($entry['o'] === $this->_uris['propAnyAction']) 
                    && ($entry['p'] === $this->_uris['propGrantAccess'])) {
                
                $userRights['userAnyActionAllowed'] = true;
            
            }
            // any model view allowed?
            else if (($entry['o'] === $this->_uris['propAnyModel']) 
                    && ($entry['p'] === $this->_uris['propGrantModelView'])) {
                
                $userRights['userAnyModelViewAllowed'] = true;
            } 
            // any model edit allowed?
            else if (($entry['o'] === $this->_uris['propAnyModel']) 
                    && ($entry['p'] === $this->_uris['propGrantModelEdit'])) {
                
                $userRights['userAnyModelEditAllowed'] = true;
            }
            // grant action?
            else if ($entry['p'] === $this->_uris['propGrantAccess']) {
                if (!in_array($entry['o'], $userRights['grantAccess'])) {
                    $userRights['grantAccess'][] = $entry['o'];
                }   
            }
            // deny action?
            else if ($entry['p'] === $this->_uris['propDenyAccess']) {
                if (!in_array($entry['o'], $userRights['denyAccess'])) {
                    $userRights['denyAccess'][] = $entry['o'];
                }
            }
            // grant model view?
            else if ($entry['p'] === $this->_uris['propGrantModelView']) {
                if (!in_array($entry['o'], $userRights['grantModelView'])) {
                    $userRights['grantModelView'][] = $entry['o'];
                }
            }
            // deny model view?
            else if ($entry['p'] === $this->_uris['propDenyModelView']) {
                if (!in_array($entry['o'], $userRights['denyModelView'])) {
                    $userRights['denyModelView'][] = $entry['o'];
                }
            }
            // grant model edit?
            else if ($entry['p'] === $this->_uris['propGrantModelEdit']) {
                if (!in_array($entry['o'], $userRights['grantModelEdit'])) {
                    $userRights['grantModelEdit'][] = $entry['o'];
                }
            }
            // deny model edit?
            else if ($entry['p'] === $this->_uris['propDenyModelEdit']) {
                if (!in_array($entry['o'], $userRights['denyModelEdit'])) {
                    $userRights['denyModelEdit'][] = $entry['o'];
                }
            }
        }
    }
    
    /**
     * checks whether the given type is supported by the acl engine
     */
    private function _isTypeSupported($type) {
        
        $type = strtolower($type);
        
        // check whether type is supported
        if (!in_array($type, array('view', 'edit'))) {
            return false;
        } else {
            return true;
        }
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * checks the permission for a user action
     *
     * @param string name of the access-type: view || edit
     * @param string modelUri
     * @return bool allowed or denied
     */
    public function isModelAllowed($type, $modelUri) {

        $this->_checkUserChanged();

        $type = strtolower($type);
        
        // type = view; check whether allowed
        if ($type === 'view') {
            // explicit forbidden
            if (in_array($modelUri, $this->_userRights['denyModelView'])) {
                return false;
            }   
            // view explicit allowed and not denied
            else if (in_array($modelUri, $this->_userRights['grantModelView'])) {
                return true;
            }
            // view in edit allowed and not denied
            else if (in_array($modelUri, $this->_userRights['grantModelEdit'])) {
                return true;
            }
            // any model
            else if ($this->isAnyModelAllowed('view')) {
                return true;
            }
        }
            
        // type = edit; check whether allowed
        if ($type === 'edit') {
            // explicit forbidden
            if (in_array($modelUri, $this->_userRights['denyModelEdit'])) {
                return false;
            }
            // edit allowed and not denied
            else if (in_array($modelUri, $this->_userRights['grantModelEdit'])) {
                return true;
            }
            // any model
            else if ($this->isAnyModelAllowed('edit')) {
                return true;
            }
        }
        
        // deny everything else => false
        return false;
    }
    
    /**
     * checks the permission for any models 
     *
     * @return bool allowed or denied
     */
    public function isAnyModelAllowed($type = 'view') {
        
        $this->_checkUserChanged();
        
        $type = strtolower($type);
        
        if ($type === 'view') {
            // any model view allowed?
            if ($this->_userRights['userAnyModelViewAllowed'] === true) {
                return true;
            }
            // any model edit allowed? (implies view right)
            else if ($this->_userRights['userAnyModelEditAllowed'] === true) {
                return true;
            }
            // not allowed!
            else {
                return false;
            }
        }
        
        if ($type === 'edit') {
            // any model edit allowed?
            if ($this->_userRights['userAnyModelEditAllowed'] === true) {
                return true;
            } 
            // not allowed!
            else {
                return false;
            }           
        }
        
        // deny everything else => false
        return false;
    }
        
    /**
     * delievers list of allowed models
     *  
     * @param string name of the access type
     * @return array list of allowed models
     */
    public function getAllowedModels($type = 'view') {
        
        $this->_checkUserChanged();
        
        $type = strtolower($type);
        
        // not supported type?
        if (!in_array($type, array('view', 'edit'))) {
            return array();
        }
            
        $ret = array();
        $grantModelKey  = ($type === 'view') ? 'grantModelView' : 'grantModelEdit';
        $denyModelKey   = ($type === 'view') ? 'denyModelView'  : 'denyModelEdit';
        
        // filter denied models
        foreach ($this->_userRights[$grantModelKey] as $allowed) {
            if (in_array($allowed, $this->_userRights[$denyModelKey])) {
                continue;
            } 
            $ret[] = $allowed;
        }
        
        return $ret;
    }
    
    /**
     * delievers list of denied models
     *
     * @param string name of the access type
     * @return array list of denied models
     */
    public function getDeniedModels($type = 'view') {
        
        $this->_checkUserChanged();
        
        $type = strtolower($type);
        
        // not supported type?
        if (!in_array($type, array('view', 'edit'))) {
            return array();
        }
            
        $denyModelKey = ($type === 'view') ? 'denyModelView' : 'denyModelEdit';
        
        return $this->_userRights[$denyModelKey];
    }
    
    /**
     * delivers action configuration
     */
    public function getActionConfig($actionSpec)
    {   
        $actionUri = $this->_uris['sysOntUri'] . $actionSpec;
        
        // direct action config
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?o')
              ->setWherePart('WHERE {
                  <' . $actionUri . '> <' . $this->_uris['actionConfigUri'] . '> ?o.
                }');
        
        $ret = array();
        if ($result = $this->_sparql($this->_sysOntModel, $query)) {
            foreach($result as $r) {
                $s = explode('=', $r['o']);
                
                // remove quotas
                if (substr($s[1], 0, 1) === '"') {
                    $s[1] = substr($s[1], 1);
                }
                if (substr($s[1], -1) === '"') {
                    $s[1] = substr($s[1], 0,  -1);
                }
                
                $ret[$s[0]] = $s[1];
            }
        }
        
        // standard config
        if (isset($this->_defaultActionConfig[$actionUri])) {
            return $this->_defaultActionConfig[$actionUri];
        }
        return array();
        
        return $ret;
    }
    
    /**
     * delievers list of allowed actions
     *  
     * @return array list of actions
     */
    public function getAllowedActions() {
        
        $this->_checkUserChanged();
        
        $ret = array();
        
        // filter denied actions
        foreach ($this->_userRights['grantAccess'] as $allowed) {
            if (in_array($allowed, $this->_userRights['denyAccess'])) {
                continue;
            }
            
            $ret[] = $allowed;
        }
        
        return $ret;
    }
    
    /**
     * delievers list of denied actions
     *
     * @return array list of actions
     */
    public function getDeniedActions() {
        
        $this->_checkUserChanged();
        
        return $this->_userRights['denyAccess']; 
    }
    
    /**
     * checks the any action permission
     *
     * @return bool allowed or denied
     */
    public function isAnyActionAllowed() {
        
        $this->_checkUserChanged();
        
        return $this->_userRights['userAnyActionAllowed'];
    }
    
    /**
     * checks the action permission of an the active user
     *
     * @param string name of the user-action
     * @return bool allowed or denied
     * */
    public function isActionAllowed($action) {

        $this->_checkUserChanged();

        $actionUri = $this->_uris['sysOntUri'] . $action;
        
        if (in_array($actionUri, $this->_userRights['denyAccess'])) {
            return false;
        } else if (in_array($actionUri, $this->_userRights['grantAccess'])) {
            return true;
        } else  if ($this->isAnyActionAllowed()) {
            return true;
        }
            
        // deny everything else => false
        return false;
    }
    
    /**
     * adds an right for the current user
     * 
     * @param string model uri
     * @param string type of access: view or edit
     * @param string permission: grant or deny
     * @throws Erfurt_Exception if wrong type was submitted 
     * @throws Erfurt_Exception if wrong permission was submitted 
     * @throws Erfurt_Exception if addition of statements fails
     */
    public function setUserModelRight($modelUri, $type = 'view', $perm = 'grant') {
        
        $this->_checkUserChanged();
        
        // is type supported?
        if (!in_array($type, array('view', 'edit'))) {
            throw new Erfurt_Exception('wrong type submitted', 1101);
        }
            
        // is permission supported?
        if (!in_array($perm, array('grant', 'deny'))) {
            throw new Erfurt_Exception('wrong perm type submitted', 1102);
        }
            
        // set the property for the right to add...
        if ($type === 'view') {
            if ($perm === 'grant') {
                $prop = $this->_uris['propGrantModelView'];
                $right = 'grantModelView';
            }
            // else the permission is deny
            else {
                $prop = $this->_uris['propDenyModelView'];
                $right = 'denyModelView';
            }
        } 
        // else the type is edit
        else {
            if ($perm === 'grant') {
                $prop = $this->_uris['propGrantModelEdit'];
                $right = 'grantModelEdit';
            }
            // else the permission is deny
            else {
                $prop = $this->_uris['propDenyModelEdit'];
                $right = 'denyModelEdit';
            }
        }
            
        $this->_userRights[$right][] = $modelUri;

// TODO set the right cache tags, such that cache is invalidated!!!
        $this->_acModel->addStatement($this->_user['uri'], $prop, $modelUri);
    }
}
?>
