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
class Erfurt_Auth_Adapter_FoafSsl implements Zend_Auth_Adapter_Interface
{
    const TIMESTAMP_VALIDITY = 10;
    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Contains the URI of the graph used for ac and auth.
     * 
     * @var string
     */
    protected $_acModelUri = null;
    
    protected $_get = null;
    
    protected $_redirectUrl = null;
    
    protected $_idpServiceUrl = null;
    
    protected $_verifyTimestamp  = true;
    protected $_verfifySignature = true;
    protected $_publicKey = null;
    
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
    public function __construct($get = null, $redirectUrl = null)
    {
        $this->_get = $get;
        $this->_redirectUrl = $redirectUrl;
        
        $app = Erfurt_App::getInstance();
        $this->_store = $app->getStore();
        
        $config = $app->getConfig();
        
        $this->_acModelUri = $config->ac->modelUri;
        
        if (isset($config->auth->foafssl->idp->serviceUrl)) {
            $this->_idpServiceUrl = $config->auth->foafssl->idp->serviceUrl;
        }
        
        if (isset($config->auth->foafssl->idp->verifyTimestamp)) {
            $this->_verifyTimestamp = (bool)$config->auth->foafssl->idp->verifyTimestamp;
        }
        
        if (isset($config->auth->foafssl->idp->verifySignature)) {
            $this->_verifySignature = (bool)$config->auth->foafssl->idp->verifySignature;
            
            if (isset($config->auth->foafssl->idp->publicKey)) {
                $this->_publicKey = $config->auth->foafssl->idp->publicKey;
            }
        }
        
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
        if (null === $this->_idpServiceUrl) {
            // Currently we need an external service for that...
            $result = false;
            $msg = 'No IdP configured.';

            require_once 'Zend/Auth/Result.php';
            return new Zend_Auth_Result($result, null, array($msg));
        }
        
        if (null === $this->_get) {
            // First we fetch the webid in a secure manner...
            $url = $this->_idpServiceUrl . '?authreqissuer=' . urlencode($this->_redirectUrl);
            header('Location: ' . $url);
            exit;
        } else {
            // First we need to verify the idp result!
            if (!$this->verifyIdpResult($this->_get)) {
                // Corrupt result
                $msg = $this->_getErrorMessage($this->_get);
                $result = false;
                
                require_once 'Zend/Auth/Result.php';
                return new Zend_Auth_Result($result, null, array($msg));
            } else {
                // Result is OK, so we have a valid WebId now. We now know, that the user is really the user...
                // Now check against the local ac model...
                $webId = $this->_get['webid'];
                
                $userResult = $this->_checkWebId($webId);
                
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
                
                // Create the identity object and return it...
                $identity = array(
                    'uri'            => $userResult['userUri'], 
                    'dbuser'         => false, 
                    'anonymous'      => false,
                    'is_webid_user'  => true
                );
                
                if (isset($userResult['userLabel'])) {
                    $identity['label'] = $userResult['userLabel'];
                }

                if (isset($userResult['username'])) {
                    $identity['username'] = $userResult['username'];
                }

                if (isset($userResult['email'])) {
                    $identity['email'] = $userResult['email'];
                }
                
                require_once 'Erfurt/Auth/Identity.php';
                $identityObject = new Erfurt_Auth_Identity($identity);

                require_once 'Zend/Auth/Result.php';
                return new Zend_Auth_Result(true, $identityObject, array());
            }
        }
    }
    
    public function fetchWebId()
    {
        // First we fetch the webid in a secure manner...
        $url = $this->_idpServiceUrl . '?authreqissuer=' . urlencode($this->_redirectUrl);
        
        header('Location: ' . $url);
        exit;
    }
    
    public function verifyIdpResult($get)
    {
        if (isset($get['webid']) && isset($get['ts']) && isset($get['sig'])) {
            $webId = $get['webid'];
            $ts    = strtotime($get['ts']);
            $sig   = $get['sig'];
            
            if ($this->_verifyTimestamp) {
                if ((time() - $ts) > self::TIMESTAMP_VALIDITY) {
                    return false;
                }
            }
            
            if ($this->_verifySignature) {
                if ((null === $this->_publicKey) || !extension_loaded('openssl')) {
                    return false;
                }
                
                $data = substr($get['url'], 0, strpos($get['url'], '&sig='));
                $publicKeyId = openssl_pkey_get_public($this->_publicKey);
                $result = openssl_verify($data, $sig, $publicKeyId);
                openssl_free_key($publicKeyId);
                
                if ($result != 1) {
                    return false;
                }
            }
            
            return true;
        } else {
            return false;
        }
    }
    
    public function fetchFoafForWebId($webId)
    {
        require_once 'Zend/Http/Client.php';
        $client = new Zend_Http_Client($webId, array(
            'maxredirects'  => 3,
            'timeout'       => 30
        ));
    
        $client->setHeaders('Accept', 'application/rdf+xml');
        $response = $client->request();
        if ($response->getStatus() === 200) {
            require_once 'Erfurt/Syntax/RdfParser.php';
            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat('rdfxml');
            
            try {
                $result = $parser->parse($response->getBody(), Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
            } catch (Erfurt_Syntax_RdfParserException $e) {
                return array();
            }
            
            return $result;
        } else {
            return array();
        }
    }
    
    protected function _getErrorMessage($get)
    {
        if (isset($get['error'])) {
            $error = $get['error'];
            
            if ($error === 'nocert') {
                return 'No valid certificate was found.';
            } else if ($error === 'IdPError') {
                return 'The IdP returned an unknown error.';
            }
        } 
        
        return 'Something went wrong.';
    }
    
    protected function _checkWebId($webId)
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
                            FILTER (sameTerm(?s, <$webId>))
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
}
