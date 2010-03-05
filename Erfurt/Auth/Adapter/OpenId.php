<?php
require_once 'Zend/Auth/Adapter/Interface.php';

/**
 * This class provides functionality to authenticate and register users based
 * on OpenID. In addition to the OpenID functionality provided by Zend, this
 * class also checks, whether a given user exists in the store and is allowed
 * to login.
 * 
 * @package  erfurt
 * @subpackage   auth
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2009 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: OpenId.php 3378 2009-06-24 14:09:30Z pfrischmuth $
 */
class Erfurt_Auth_Adapter_OpenId implements Zend_Auth_Adapter_Interface
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Contains the URI of the graph used for ac and auth.
     * 
     * @var string
     */
    protected $_acModelUri = null;
    
    /**
     * Contains the query part of the OpenID auth request (used for the 
     * verification process) or is null else.
     * 
     * @var array|null
     */
    protected $_get = null;
    
    /**
     * Contains the OpenID to use for the authentication process or is null for
     * the verification process.
     * 
     * @var string|null
     */
    protected $_id = null;
    
    /**
     * Contains a URL, which is used for redirection after verification was successful
     * or is null.
     * 
     * @var string|null
     */
    protected $_redirectUrl = null;
    
    /**
     * This is s used for the registration process. If this property is set, we do
     * not check, whether the users exists in the store. It is also used to gather
     * additional user infos from the provider.
     * 
     * @var Zend_OpenId_Extension_Sreg|null
     */
    protected $_sReg = null;
    
    /**
     * Contains a reference to the store object in order to do SPARQL.
     * 
     * @var Erfurt_Store
     */
    protected $_store = null;
    
    /**
     * Contains the URIs used for modeling users and rights in RDF.
     * This URIs are loaded from the config file.
     * 
     * @var array
     */
    protected $_uris = array();
    
    /**
     * Contains a URL, which is used for redirection when the login at the OpenID
     * provider was successful and the result needs to be verified. If this is not
     * specified the same URL is used as for the login request.
     * 
     * @var string|null
     */
    protected $_verifyUrl = null;
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * The constructor is called in three different ways and defines which step of
     * the OpenID auth process will be done:
     * 
     * 1. $id, $verifyUrl and $redirectUrl are given - Login at provider
     * 2. $get is given - Verify the response
     * 3. $sReg is additionally given - Do not check the local store... We want to
     * register a new user.
     * 
     * @param string $id
     * @param string $verifyUrl
     * @param string $redirectUrl
     * @param array $get
     * @param Zend_OpenId_Extension_Sreg
     */
    public function __construct($id = null, $verifyUrl = null, $redirectUrl = null, $get = null, $sReg = null)
    {
        $this->_id = $id;
        $this->_verifyUrl = $verifyUrl;
        $this->_redirectUrl = $redirectUrl;
        $this->_get = $get;
        $this->_sReg = $sReg;
        
        $app = Erfurt_App::getInstance();
        $this->_store = $app->getStore();
        
        $config = $app->getConfig();
        
        $this->_acModelUri = $config->ac->modelUri;
        
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
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * This method is responsible for the complete OpenID authentication process.
     * In some cases this method does not return, for a redirect is done internally
     * by Zend.
     * 
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        // Check whether OpenId is supported (big integer support is needed.)
        if (!$this->_isOpenIdSupported()) {
            $result = false;
            $msg = 'OpenID is currently not supported!';

            require_once 'Zend/Auth/Result.php';
            return new Zend_Auth_Result($result, null, array($msg));
        }
        
        // If id is given, login the user.
        if (null !== $this->_id) {
            // If sReg is given, we want to register, so don't check whether user exists.
            // If it is not given, we need to check whether the user exists and is allowed
            // to login.
            if (null === $this->_sReg) {
                $userResult = $this->_checkOpenId($this->_id);

                if ($userResult['userUri'] === false) {
                    $result = false;
                    $msg = 'User does not exist!';

                    require_once 'Zend/Auth/Result.php';
                    return new Zend_Auth_Result($result, null, array($msg));
                }
                if ($userResult['denyLogin'] === true) {
                    $result = false;
                    $msg = 'Login not allowed!';

                    require_once 'Zend/Auth/Result.php';
                    return new Zend_Auth_Result($result, null, array($msg));
                }
            }
              
            if (null !== $this->_redirectUrl) {
                // This is a hack, for the setHttpClient method in Zend_OpenId_Consumer seems not to work.
                $this->_verifyUrl = $this->_verifyUrl . '/?ow_redirect_url=' . urlencode($this->_redirectUrl);
            }
            
            require_once 'Zend/OpenId/Consumer.php';
            $consumer = new Zend_OpenId_Consumer();
            
            if (!$consumer->login($this->_id, $this->_verifyUrl, null, $this->_sReg)) {
                $result = false;
                $msg = 'OpenID authentication failed.';
                
                require_once 'Zend/Auth/Result.php';
                return new Zend_Auth_Result($result, null, array($msg));
            }
            
            // This point is never reached, for there will be a redirect on successful login.
        } else {
            // If no id is given, verify the result.
            if (!isset($this->_get['openid_identity'])) {
                $result = false;
                $msg = 'OpenID authentication failed.';
                
                /*
                $identity = array(
                    'uri'       => null, 
                    'dbuser'    => false, 
                    'anonymous' => false
                );
                */
                
                require_once 'Zend/Auth/Result.php';
                return new Zend_Auth_Result($result, null, array($msg));
            }
            
            $identity = array(
                'uri'            => $this->_get['openid_identity'], 
                'dbuser'         => false, 
                'anonymous'      => false,
                'is_openid_user' => true
            );
            
            // This is just called in order to get the label for the user.
            $userResult = $this->_checkOpenId($this->_get['openid_identity']);
            
            if (isset($userResult['userLabel'])) {
                $identity['label'] = $userResult['userLabel'];
            }
            
            if (isset($userResult['username'])) {
                $identity['username'] = $userResult['username'];
            }
            
            if (isset($userResult['email'])) {
                $identity['email'] = $userResult['email'];
            }
            
            require_once 'Zend/OpenId/Consumer.php';
            $consumer = new Zend_OpenId_Consumer();
            
            if (!$consumer->verify($this->_get, $this->_get['openid_identity'], $this->_sReg)) {
                $result = false;
                $msg = 'OpenID authentication failed.';
                
                require_once 'Zend/Auth/Result.php';
                return new Zend_Auth_Result($result, null, array($msg));
            } else {
                $result = true;
                $msg = 'OpenID authentication successful.';
                
                require_once 'Erfurt/Auth/Identity.php';
                $identityObject = new Erfurt_Auth_Identity($identity);
                
                require_once 'Zend/Auth/Result.php';
                return new Zend_Auth_Result($result, $identityObject, array($msg));
            }
        }
    }
    
    // ------------------------------------------------------------------------
    // --- Protected methods --------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Checks a given OpenID against the store and fetches the required informations.
     * 
     * @param string $openId
     * @return array
     */ 
    protected function _checkOpenId($openId)
    {
        $retVal = array(
            'userUri'   => false,
            'denyLogin' => false
        );
        
        // Query the store.
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?s ?p ?o');
        $query->addFrom($this->_acModelUri);
        
        $where = 'WHERE { 
                            ?s ?p ?o . 
                            ?s <' . EF_RDF_TYPE . '> <' . $this->_uris['user_class'] . "> .
                            FILTER (sameTerm(?s, <$openId>))
                        }";
        $query->setWherePart($where);
        $result = $this->_store->sparqlQuery($query, array('use_ac' => false));
        
        foreach ((array)$result as $row) {
            // Set user URI
            if (($retVal['userUri']) === false) {
                $retVal['userUri'] = $row['s'];
            }
            
            // Check predicates, whether needed.
            switch ($row['p']) {
                case $this->_uris['action_deny']:
                    // if login is disallowed
                    if ($row['o'] === $this->_uris['action_login']) {
                        $retVal['denyLogin'] = true;
                    }
                    break;
                case EF_RDFS_LABEL:
                    $retVal['userLabel'] = $row['o'];
                    break;
                case $this->_uris['user_username']:
                    $retVal['username'] = $row['o'];
                    break;
                case $this->_uris['user_mail'];
                    $retVal['email'] = $row['o'];
                default:
                    // Ignore all other statements.
            }
        }

        return $retVal;
    }
    
    protected function _isOpenIdSupported()
    {
        if (extension_loaded('bcmath')) {
            return true;
        } else {
            return false;
        }
    }
}
