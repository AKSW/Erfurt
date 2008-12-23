<?php

require_once 'Zend/Auth/Adapter/Interface.php';
require_once 'Zend/Auth/Result.php';

/**
 * Erfurt RDF authentication adapter.
 *
 * Authenticates a subject via an RDF store using a provided model.
 *
 * @package auth
 * @author  Stefan Berger <berger@intersolut.de>
 * @author  Norman Heino <norman.heino@gmail.com>
 * @license
 * @version $Id$
 */
class Erfurt_Auth_Adapter_Rdf implements Zend_Auth_Adapter_Interface {
    
    /** @var string */
    protected $username = null;

    /** @var string */
    protected $password = null;

    /** @var Erfurt_Rdf_Model */
    protected $acModel = null;

    /** @var array */
    protected $users = array();
    
    /** @var boolean */
    protected $_userDataFetched = false;

    /** @var string */
    private $_dbUsername = '';

    /** @var string */
    private $_dbPassword = '';
    
    /** @var array */
    private $_uris = array();
    
    /**
     * Constructor
     */
    public function __construct(Erfurt_Rdf_Model $acModel, $username = null, $password = null) {        
        $this->username = $username;
        $this->password = $password;
        $this->acModel  = $acModel;
        
        $config = Erfurt_App::getInstance()->getConfig();
        // $this->_dbUsername = $config->database->username;
        // $this->_dbPassword = $config->database->password;
        
        $store = $acModel->getStore();
        $this->_dbUsername = $store->getDbUser();
        $this->_dbPassword = $store->getDbPassword();
        
        // load URIs from config
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
    
    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate() {
            
        // anonymous is always allowed to log in?
        if ($this->username === 'Anonymous') {
            $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_getAnonymousUser());
        
        // super admin
        } else if ($this->username === $this->_dbUsername and $this->password === $this->_dbPassword) {
            $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_getSuperAdmin());
        
        // normal user from system ontology
        } else {
            $identity = array(
                'username'  => $this->username, 
                'uri'       => '', 
                'dbuser'    => false, 
                'anonymous' => false
            );
            
            // have a look at the cache...
            $cache = Erfurt_App::getInstance()->getCache();
            $id = $cache->makeId($this, '_fetchDataForUser', array($this->username));
            $cachedVal = $cache->load($id);
            if ($cachedVal) {
                $this->_users[$this->username] = $cachedVal;
            } else {
                $this->_users[$this->username] = $this->_fetchDataForUser($this->username);
                $cache->save($this->_users[$this->username]);
            }
            
            // if login is denied return failure auth result
            if ($this->_users[$this->username]['denyLogin'] === true) {
                $authResult = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, $identity, array('Login not allowed!'));
            } 
            // does user not exist?
            else if ($this->_users[$this->username]['userUri'] === false) {
                $authResult = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, $identity, array('User does not exist!'));
            } else {
                // verify the password
                if (!$this->_verifyPassword($this->password, $this->_users[$this->username]['userPassword'], 'sha1') 
                        && !$this->_verifyPassword($this->password, $this->_users[$this->username]['userPassword'], 
                        '')) {
                    
                    $authResult = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, $identity, array('Wrong password entered!'));
                } else {
                    $identity['uri'] = $this->_users[$this->username]['userUri'];
                    $identity['email'] = $this->_users[$this->username]['userEmail'];
                    
                    $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identity);
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
    private function _fetchDataForUser($username) {
        
        $returnVal = array(
            'userUri'       => false,
            'denyLogin'     => false,
            'userPassword'  => '',
            'userEmail'     => ''
        );
        
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $sparqlQuery = new Erfurt_Sparql_SimpleQuery();
        $sparqlQuery->setProloguePart('SELECT ?subject ?predicate ?object');
        
        $wherePart = 'WHERE { ?subject ?predicate ?object . ?subject <' . EF_RDF_TYPE . '> <' .
            $this->_uris['user_class'] . '> . ?subject <' . $this->_uris['user_username'] . '> "' . $username . '"^^<' . 
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
                    case $this->_uris['action_deny']:
                        // if login is disallowed
                        if ($userStatement['object'] === $this->_uris['action_login']) {
                            return array('denyLogin' => true);
                        }
                    case $this->_uris['user_password']:
                        $returnVal['userPassword'] = $userStatement['object'];
                        break;
                    case $this->_uris['user_mail']:
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
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $userSparql = new Erfurt_Sparql_SimpleQuery();
        $userSparql->setProloguePart('SELECT ?subject ?predicate ?object');
        
        $wherePart = 'WHERE { ?subject ?predicate ?object . ?subject <' . EF_RDF_TYPE . '> <' .
            $this->_uris['user_class'] . '> }';
        $userSparql->setWherePart($wherePart);
        
        if ($result = $this->_sparql($userSparql)) {
            foreach ($result as $statement) {
                switch ($statement['predicate']) {
                case $this->_uris['action_deny']:
                    if ($statement['object'] == $this->_uris['action_login']) {
                        $this->_users[$statement['subject']]['loginForbidden'] = true;
                    }
                    break;
                case $this->_uris['user_username']:
                    // save username
                    $this->_users[$statement['subject']]['userName'] = $statement['object'];
                    break;
                case $this->_uris['user_password']:
                    // save password
                    $this->_users[$statement['subject']]['userPassword'] = $statement['object'];
                    break;
                case $this->_uris['user_mail']:
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
    public function getUsers() {
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
    private function _verifyPassword($password1, $password2, $cryptType = 'md5') {
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
    private function _sparql($sparqlQuery) {
        try {
            $sparqlQuery->addFrom($this->acModel->getModelIri());
            $result = $this->acModel->getStore()->sparqlQuery($sparqlQuery, 'plain', false);
        } catch (Exception $e) {
            var_dump($e);exit;
            return null;
        }
        
        return $result;
    }
    
    /**
     * Returns the anonymous user details.
     *
     * @return array 
     */
    private function _getAnonymousUser() {
        $user = array(
            'username'  => 'Anonymous', 
            'uri'       => $this->_uris['user_anonymous'], 
            'dbuser'    => false, 
            'email'     => '', 
            'anonymous' => true
        );
        
        return $user;
    }

    /**
     * Returns the super admin (db user) details
     *
     * @return array  
     */
    private function _getSuperAdmin() {
        $user = array(
            'username'  => 'SuperAdmin', 
            'uri'       => $this->_uris['user_superadmin'], 
            'dbuser'    => true, 
            'email'     => '', 
            'anonymous' => false
        );
        
        return $user;
    }
}

?>