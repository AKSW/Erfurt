<?php

require_once 'Zend/Auth/Adapter/Interface.php';
require_once 'Zend/Auth/Result.php';

/**
 * Erfurt RDF authentication adapter.
 *
 * Authenticates a subject via an RDF store using a provided model.
 *
 * @package erfurt
 * @subpackage auth
 * @author  Stefan Berger <berger@intersolut.de>
 * @author  Norman Heino <norman.heino@gmail.com>
 * @author  Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license
 * @version $Id: Rdf.php 4191 2009-09-25 10:32:03Z c.riess.dev $
 */
class Erfurt_Auth_Adapter_Rdf implements Zend_Auth_Adapter_Interface
{
    
    private $_config = null;
    
    /** @var string */
    protected $_username = null;

    /** @var string */
    protected $_password = null;

    /** @var string */
    protected $_acModelUri = null;

    /** @var array */
    protected $_users = array();
    
    /** @var boolean */
    protected $_userDataFetched = false;

    /** @var string */
    private $_dbUsername = null;

    /** @var string */
    private $_dbPassword = null;
    
    private $_store = null;
    
    
    /** @var array */
    private $_uris = null;
    
    private $_loginDisabled = null;
    
    private $_dbUserAllowed = null;
    
    /**
     * Constructor
     */
    public function __construct($username = null, $password = null) 
    {        
        $this->_username = $username;
        $this->_password = $password; 
    }
    
    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate() 
    {
        
        if ($this->_isLoginDisabled() === true || $this->_username === 'Anonymous') {
            $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_getAnonymousUser());
        } else if ($this->_isDbUserAllowed() && $this->_username === $this->_getDbUsername() && 
            // super admin
            $this->_password === $this->_getDbPassword()) {
            
            $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_getSuperAdmin());
        } else {
            // normal user from system ontology
            $identity = array(
                'username'  => $this->_username, 
                'uri'       => '', 
                'dbuser'    => false, 
                'anonymous' => false
            );
            
            // have a look at the cache...
            /*$cache = Erfurt_App::getInstance()->getCache();
            $id = $cache->makeId($this, '_fetchDataForUser', array($this->_username));
            OntoWiki::getInstance()->appendMessage( new OntoWiki_Message($id));
            $cachedVal = $cache->load($id);
            if ($cachedVal) {
                OntoWiki::getInstance()->appendMessage( new OntoWiki_Message("cached"));
                $this->_users[$this->_username] = $cachedVal;
            } else {
                */$this->_users[$this->_username] = $this->_fetchDataForUser($this->_username);
                /*$cache->save($this->_users[$this->_username], $id, array('_fetchDataForUser'));
                OntoWiki::getInstance()->appendMessage( new OntoWiki_Message("uncached"));
            }*/
            
            // if login is denied return failure auth result
            if ($this->_users[$this->_username]['denyLogin'] === true) {
                $authResult = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null, array('Login not allowed!'));
            } else if ($this->_users[$this->_username]['userUri'] === false) {
                // does user not exist?
                $authResult = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null, array('Unknown user identifier.'));
            } else {
                // verify the password
                if (!$this->_verifyPassword($this->_password, $this->_users[$this->_username]['userPassword'], 'sha1') 
                    && !$this->_verifyPassword($this->_password, $this->_users[$this->_username]['userPassword'], '')) {
                    
                    $authResult = new Zend_Auth_Result(
                        Zend_Auth_Result::FAILURE, null, array('Wrong password entered!')
                    );
                } else {
                    $identity['uri'] = $this->_users[$this->_username]['userUri'];
                    $identity['email'] = $this->_users[$this->_username]['userEmail'];
                    
                    require_once 'Erfurt/Auth/Identity.php';
                    $identityObject = new Erfurt_Auth_Identity($identity);
                    
                    $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identityObject);
                }
            } 
        }
        
        //Erfurt_App::getInstance()->getAc()->init();
        return $authResult;
    }
    
    /**
     * Fetches the data for a specific user from the RDF user store.
     * 
     * Returns the data for the user only if $username match the data stored. 
     *
     * @param string $username
     *
     * @return array
     */
    private function _fetchDataForUser($username) 
    {
        
        $returnVal = array(
            'userUri'       => false,
            'denyLogin'     => false,
            'userPassword'  => '',
            'userEmail'     => ''
        );
        
        $uris = $this->_getUris();
        
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $sparqlQuery = new Erfurt_Sparql_SimpleQuery();
        $sparqlQuery->setProloguePart('SELECT ?subject ?predicate ?object');
        
        $wherePart = 'WHERE { ?subject ?predicate ?object . ?subject <' . EF_RDF_TYPE . '> <' .
            $uris['user_class'] . '> . ?subject <' . $uris['user_username'] . '> "' . $username . '"^^<' . 
            EF_XSD_NS . 'string> }';
        $sparqlQuery->setWherePart($wherePart);
        
        if ($result = $this->_sparql($sparqlQuery)) {
            
            foreach ($result as $userStatement) {
                // set user URI
                if (($returnVal['userUri']) === false) {
                    $returnVal['userUri'] = $userStatement['subject'];
                }
                
                // check other predicates
                switch ($userStatement['predicate']) {
                    case $uris['action_deny']:
                        // if login is disallowed
                        if ($userStatement['object'] === $uris['action_login']) {
                            return array('denyLogin' => true);
                        }
                    case $uris['user_password']:
                        $returnVal['userPassword'] = $userStatement['object'];
                        break;
                    case $uris['user_mail']:
                        $returnVal['userEmail'] = $userStatement['object'];
                        break;
                    default:
                        // ignore other statements
                }
            }
        }
        
        return $returnVal;
    }
    
    /**
     * Fetches the for all users from the RDF user store.
     * 
     * Stores the user data in an internal array for alter reference.
     *
     * @return void
     */
    public function fetchDataForAllUsers()
    {   
        $uris = $this->_getUris();
         
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $userSparql = new Erfurt_Sparql_SimpleQuery();
        $userSparql->setProloguePart('SELECT ?subject ?predicate ?object');
        
        $wherePart = 'WHERE { ?subject ?predicate ?object . ?subject <' . EF_RDF_TYPE . '> <' .
            $uris['user_class'] . '> }';
        $userSparql->setWherePart($wherePart);
        
        if ($result = $this->_sparql($userSparql)) {
            foreach ($result as $statement) {
                switch ($statement['predicate']) {
                case $uris['action_deny']:
                    if ($statement['object'] == $uris['action_login']) {
                        $this->_users[$statement['subject']]['loginForbidden'] = true;
                    }
                    break;
                case $uris['user_username']:
                    // save username
                    $this->_users[$statement['subject']]['userName'] = $statement['object'];
                    break;
                case $uris['user_password']:
                    // save password
                    $this->_users[$statement['subject']]['userPassword'] = $statement['object'];
                    break;
                case $uris['user_mail']:
                    // save e-mail
                    $this->_users[$statement['subject']]['userEmail'] = $statement['object'];
                    break;
                default:
                    // ignore other statements
                }
            }
            $this->_userDataFetched = true;
        }
    }
    
    /**
     * Returns an array of users available within the container.
     *
     * @return array
     */
    public function getUsers() 
    {
        if (!$this->_userDataFetched) {
            $this->fetchDataForAllUsers();
        }
        
        return $this->_users;
    }
    
    /**
     * Crypt and verfiy the entered password
     *
     * @param  string Entered password
     * @param  string Password from the data container (usually this password
     *                is already encrypted.
     * @param  string Type of algorithm with which the password from
     *                the container has been crypted. (md5, crypt etc.)
     *                Defaults to "md5".
     * @return bool   True, if the passwords match
     */
    private function _verifyPassword($password1, $password2, $cryptType = 'md5') 
    {
        switch ($cryptType) {
        case 'md5':
            return ((string) md5($password1) === (string) $password2);
            break;
        case 'sha1':
            return ((string) sha1($password1) === (string) $password2);
            break;
        case 'crypt':
            return ((string) crypt($password1, $password2) === (string) $password2);
            break;
        case 'none':
        case '':
            return ((string) $password1 === (string) $password2);
            break;
        default:
            if (function_exists($cryptType)) {
                return ((string) $cryptType($password1) === (string) $password2);
            } else if (method_exists($this, $cryptType)) { 
                return ((string) $this->$cryptType($password1) === (string) $password2);
            } else {
                return false;
            }
        }
    }
    
    /**
     * Queries the ac model.
     *
     * @return array|null 
     */
    private function _sparql($sparqlQuery) 
    {
        try {
            $sparqlQuery->addFrom($this->_getAcModelUri());
            $result = $this->_getStore()->sparqlQuery($sparqlQuery, array('use_ac' => false));
        } catch (Exception $e) {
            return null;
        }
        
        return $result;
    }
    
    /**
     * Returns the anonymous user details.
     *
     * @return array 
     */
    private function _getAnonymousUser() 
    {
        $uris = $this->_getUris();
        
        $user = array(
            'username'  => 'Anonymous', 
            'uri'       => $uris['user_anonymous'], 
            'dbuser'    => false, 
            'email'     => '', 
            'anonymous' => true
        );
        
        require_once 'Erfurt/Auth/Identity.php';
        $identityObject = new Erfurt_Auth_Identity($user);
        
        return $identityObject;
    }

    /**
     * Returns the super admin (db user) details
     *
     * @return array  
     */
    private function _getSuperAdmin() 
    {
        $uris = $this->_getUris();
        
        $user = array(
            'username'  => 'SuperAdmin', 
            'uri'       => $uris['user_superadmin'], 
            'dbuser'    => true, 
            'email'     => '', 
            'anonymous' => false
        );
        
        require_once 'Erfurt/Auth/Identity.php';
        $identityObject = new Erfurt_Auth_Identity($user);
        
        return $identityObject;
    }
    
    private function _getDbUsername()
    {
        if (null === $this->_dbUsername) {
            $this->_dbUsername = $this->_getStore()->getDbUser();
        }
        
        return $this->_dbUsername;
    }
    
    private function _getDbPassword()
    {
        if (null === $this->_dbPassword) {
            $this->_dbPassword = $this->_getStore()->getDbPassword();
        }
        
        return $this->_dbPassword;
    }
    
    private function _getConfig()
    {
        if (null === $this->_config) {
            $this->_config = Erfurt_App::getInstance()->getConfig();
        }
        
        return $this->_config;
    }
    
    private function _getStore()
    {
        if (null === $this->_store) {
            $this->_store = Erfurt_App::getInstance()->getStore();
        }
        
        return $this->_store;
    }
    
    private function _getAcModelUri()
    {
        if (null === $this->_acModelUri) {
            $config = $this->_getConfig();
            $this->_acModelUri = $config->ac->modelUri;
        }
        
        return $this->_acModelUri;
    }
    
    private function _getUris()
    {
        if (null === $this->_uris) {
            $config = $this->_getConfig();
            
            $this->_uris = array(
                'user_class'      => $config->ac->user->class, 
                'user_username'   => $config->ac->user->name, 
                'user_password'   => $config->ac->user->pass, 
                'user_mail'       => $config->ac->user->mail, 
                'user_superadmin' => $config->ac->user->superAdmin, 
                'user_anonymous'  => $config->ac->user->anonymousUser, 
                'action_deny'     => $config->ac->action->deny, 
                'action_login'    => $config->ac->action->login
            );
        }
        
        return $this->_uris;
    }
    
    private function _isLoginDisabled()
    {
        if (null === $this->_loginDisabled) {
            $config = $this->_getConfig();
            
            if (isset($config->ac->deactivateLogin) && ((boolean)$config->ac->deactivateLogin === true)) {
                $this->_loginDisabled = true;
            }
        }
        
        return $this->_loginDisabled;
    }
    
    private function _isDbUserAllowed()
    {
        if (null === $this->_dbUserAllowed) {
            $config = $this->_getConfig();
            
            if (isset($config->ac->allowDbUser) && ((boolean)$config->ac->allowDbUser === true)) {
                $this->_dbUserAllowed = true;
            } else {
                $this->_dbUserAllowed = false;
            }
        }
        
        return $this->_dbUserAllowed;
    }
}
