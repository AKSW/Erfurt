<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id: FoafSsl.php 4030 2009-08-14 04:31:05Z pfrischmuth $
 */

require_once 'Zend/Auth/Adapter/Interface.php';

/**
 * This class provides functionality to authenticate and register users based
 * on FOAF+SSL. If SSL/TLS is supported, this class checks whether a valid user exsists
 * by itself. If not, it can use a remote service, iff configured so in config. It also
 * supports a form of auth delegation, i.e. if another Erfurt application connects via
 * SSL/TLS and this application can be authenticated with FOAF+SSL and the application
 * provides a FOAF+SSL auth header (non-standard!) with a valid WebID and the dereferenced 
 * FOAF file contains the URI of the agent, then the user is authenticated...
 * 
 * @copyright  Copyright (c) 2009 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    erfurt
 * @subpackage auth
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Auth_Adapter_FoafSsl implements Zend_Auth_Adapter_Interface
{
    /**
     * The duration a timestamp is valid...
     * 
     * @var int
     */
    const TIMESTAMP_VALIDITY = 1000;
    
    /* Property URIs */
    const PUBLIC_KEY_PROPERTY = 'http://www.w3.org/ns/auth/rsa#RSAPublicKey';
    const IDENTITY_PROP       = 'http://www.w3.org/ns/auth/cert#identity';
    const EXPONENT_PROP       = 'http://www.w3.org/ns/auth/rsa#public_exponent';
    const MODULUS_PROP        = 'http://www.w3.org/ns/auth/rsa#modulus';
    const DECIMAL_PROP        = 'http://www.w3.org/ns/auth/cert#decimal';
    const HEX_PROP            = 'http://www.w3.org/ns/auth/cert#hex';
    
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
     * Contains the config object.
     * 
     * @var array
     */
    protected $_config = null;
    
    /**
     * Contains fetched FOAF data if dereferencing was succesfull.
     * 
     * @var array
     */
    protected $_foafData = array();
    
    /**
     * GET of the request if we use a remote idp.
     * 
     * @var array|null
     */
    protected $_get = null;
    
    /**
     * URL of the idp iff set.
     * 
     * @var string|null
     */
    protected $_idpServiceUrl = null;
    
    /**
     * Contains the public key of the idp iff configured.
     *
     * @var string|null
     */
    protected $_publicKey = null;
    
    /**
     * An optional redirect URL, that is used in combination with a remote idp only.
     * If a remote idp is used the idp will redirect to that URL.
     * 
     * @var string|null
     */
    protected $_redirectUrl = null;
    
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
     * Whether to verify signature of idp result.
     * 
     * @var bool
     */
    protected $_verifySignature = true;
    
    /**
     * Whether to check timestamp of idp result.
     * 
     * @var bool
     */
    protected $_verifyTimestamp  = true;
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * If SSL/TLS is used the parameters can be left out. If a remote idp is
     * used they need to be set.
     * 
     * @param array $get
     * @param string $redirectUrl
     */
    public function __construct(array $get = null, $redirectUrl = null)
    {
        $this->_get = $get;
        $this->_redirectUrl = $redirectUrl;
        
        $app = Erfurt_App::getInstance();
        $this->_store = $app->getStore();
        
        $config = $app->getConfig();
        $this->_config = $config;
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
            'user_class'       => $config->ac->user->class, 
            'user_username'    => $config->ac->user->name, 
            'user_password'    => $config->ac->user->pass, 
            'user_mail'        => $config->ac->user->mail, 
            'user_superadmin'  => $config->ac->user->superAdmin, 
            'user_anonymous'   => $config->ac->user->anonymousUser, 
            'action_deny'      => $config->ac->action->deny, 
            'action_login'     => $config->ac->action->login,
            'group_membership' => $config->ac->group->membership
        );   
    }
    
    // ------------------------------------------------------------------------
    // --- Static methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Whether creation of self signed certificates is supported or not.
     * 
     * @return bool
     */
    public static function canCreateCertificates()
    {
        if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on' && extension_loaded('openssl')) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Creates a certificate if possible. Returns cert data on success and false else.
     * 
     * @param string $webId
     * @param string $name
     * @param string $mail
     * @param string $spkac Browser generated challenge
     * 
     * @return array|bool
     */
    public static function createCertificate($webId, $name, $mail = '', $spkac = '')
    {
        if (!self::canCreateCertificates()) {
            return false;
        }
        
        // Set some temp filenames.
        $tmpDir = Erfurt_App::getInstance()->getTmpDir();
        if (!$tmpDir) {
            return false;
        }
        $uniqueFilename = uniqid();
        $spkacFilename  = $tmpDir . '/' . $uniqueFilename . '.spkac';
        $certFilename   = $tmpDir . '/' . $uniqueFilename . '.temp';
        
        // Configure for signing...
        $config = Erfurt_App::getInstance()->getConfig();
        $state   = $config->auth->foafssl->provider->ca->state;
        $country = $config->auth->foafssl->provider->ca->country;
        $org     = $config->auth->foafssl->provider->ca->org;
        
        // Prepate SPKAC
        $spkac = str_replace(str_split(" \t\n\r\0\x0B"), '', $spkac);
        $dn = 'SPKAC=' . $spkac;
        
        // Name needs to be set!
        $dn .= PHP_EOL . 'CN=' . $name;
         
        // Optional mail address...
        if ($mail !== '') {
            $dn .= PHP_EOL . 'emailAddress=' . $mail;
        }
        
        // Needs to be the same as in CA cert!
        $dn .= PHP_EOL . 'organizationName=' . $org;
        
        $dn .= PHP_EOL . 'stateOrProvinceName=' . $state;
        $dn .= PHP_EOL . 'countryName=' . $country;
        
        // Subject alternate name...
        $san = 'URI:' . $webId;
        putenv('SAN=' . $san);
        
        $fhandle = fopen($spkacFilename, 'w');
        fwrite($fhandle, $dn);
        fclose($fhandle);
        
        $expiration = $config->auth->foafssl->provider->ca->expiration;
        $pw = $config->auth->foafssl->provider->ca->password;
        
        // Sign the cert...
        $null = `openssl ca -days $expiration -notext -batch -spkac $spkacFilename -out $certFilename -passin pass:$pw`;
        
        unlink($spkacFilename);
        putenv('SAN=""');
        
        if (filesize($certFilename) === 0) {
            return false;
        }
          
        $fhandle = fopen($certFilename, 'r');
        $certData = fread($fhandle, filesize($certFilename));
        fclose($fhandle);
        
        // Extract data from cert...
        $pubKey = `openssl x509 -inform DER -in $certFilename -pubkey -noout`;
        $rsaCertStruct = `echo "$pubKey" | openssl asn1parse -inform PEM -i`;
        $rsaCertFields = explode("\n", $rsaCertStruct);
        $rsaKeyOffset  = explode(':', $rsaCertFields[4]);
        $rsaKeyOffset  = trim($rsaKeyOffset[0]);
        
        $rsaKey = `echo "$pubKey" | openssl asn1parse -inform PEM -i -strparse $rsaKeyOffset`;

        $rsaKeys  = explode("\n", $rsaKey);
        $modulus  = explode(':', $rsaKeys[1]);
        $modulus  = $modulus[3]; 
        $exponent = explode(':', $rsaKeys[2]);
        $exponent = $exponent[3];
        
        unlink($certFilename);
        
        return array(
            'certData' => $certData,
            'modulus'  => strtolower($modulus),
            'exponent' => hexdec($exponent)
        );
    }
    
    /**
     * Returns the certficate data of the given user cert if possible.
     * Else returns false.
     * 
     * @return array|bool
     */
    public static function getCertificateInfo()
    {
       if (!self::canCreateCertificates()) {
           return false;
       }

       $instance = new self();

       $rsaPublicKey = $instance->_getCertRsaPublicKey();
       if ($rsaPublicKey === false) {
           return false;
       }
       $san = $instance->_getSubjectAlternativeNames();
       if ($san === false || !isset($san['uri'])) {
           return false;
       }

       $foafPublicKey = $instance->_getFoafRsaPublicKey($san['uri']);
       if ($foafPublicKey === false) {
           return array(
               'certPublicKey' => $rsaPublicKey,
               'webId'         => $san['uri']
           );
       } else {
           return array(
               'certPublicKey' => $rsaPublicKey,
               'webId'         => $san['uri'],
               'foafPublicKey' => $foafPublicKey
           );
       }
    }
    
    /**
     * Returns FOAF data for a given FOAF URI iff available.
     * Returns false else.
     * 
     * @param string $foafUri
     * @return array|bool
     * 
     */
    public static function getFoafData($foafUri)
    {
        $client = Erfurt_App::getInstance()->getHttpClient($foafUri, array(
            'maxredirects'  => 3,
            'timeout'       => 30
        ));

        $client->setHeaders('Accept', 'application/rdf+xml');
        $response = $client->request();
        if ($response->getStatus() === 200) {
            require_once 'Erfurt/Syntax/RdfParser.php';
            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat('rdfxml');

            if ($idx = strrpos($foafUri, '#')) {
                $base = substr($foafUri, 0, $idx);
            } else {
                $base = $foafUri;
            }
            
            try {
                $result = $parser->parse($response->getBody(), Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING, $base);
            } catch (Erfurt_Syntax_RdfParserException $e) {
                return false;
            }
            
            return $result;
        } else {
            return false;
        }
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Adds a new FOAF+SSL user...
     * 
     * @param $webId
     */
    public function addUser($webId)
    {
        $acModelUri = $this->_acModelUri;
        $store      = $this->_store;
        
        // Only add the user if allowed...
        if (!Erfurt_App::getInstance()->getAc()->isActionAllowed('RegisterNewUser')) {
            return false;
        }
        
        // Does user already exist?
        $users = Erfurt_App::getInstance()->getUsers();
        if (isset($users[$webId])) {
            return false;
        }
        
        $actionConfig = Erfurt_App::getInstance()->getActionConfig('RegisterNewUser');

        $foafData = $this->_getFoafData($webId);
        if (isset($foafData[$webId][EF_RDF_TYPE][0]['value'])) {
            if ($foafData[$webId][EF_RDF_TYPE][0]['value'] === 'http://xmlns.com/foaf/0.1/OnlineAccount' ||
                $foafData[$webId][EF_RDF_TYPE][0]['value'] === 'http://xmlns.com/foaf/0.1/Person') {
                
                // Look for label, email
                if (isset($foafData[$webId]['http://xmlns.com/foaf/0.1/mbox'][0]['value'])) {
                    $email = $foafData[$webId]['http://xmlns.com/foaf/0.1/mbox'][0]['value'];
                }
                if (isset($foafData[$webId]['http://xmlns.com/foaf/0.1/name'][0]['value'])) {
                    $label = $foafData[$webId]['http://xmlns.com/foaf/0.1/name'][0]['value'];
                } else if (isset($foafData[$webId][EF_RDFS_LABEL][0]['value'])) {
                    $label = $foafData[$webId]['http://xmlns.com/foaf/0.1/name'][0]['value'];
                }
            } 
        }
        
        // uri rdf:type sioc:User
        $store->addStatement(
            $acModelUri,
            $webId, 
            EF_RDF_TYPE, 
            array(
                'value' => $this->_uris['user_class'],
                'type'  => 'uri'
            ), 
            false
        );
        
        if (!empty($email)) {
            // Check whether email already starts with mailto:
            if (substr($email, 0, 7) !== 'mailto:') {
                $email = 'mailto:' . $email;
            }
            
            // uri sioc:mailbox email
            $store->addStatement(
                $acModelUri,
                $userUri, 
                $this->_config->ac->user->mail, 
                array(
                    'value' => $email,
                    'type'  => 'uri'
                ),
                false
            );
        }
        
        if (!empty($label)) {
            // uri rdfs:label $label
            $store->addStatement(
                $acModelUri,
                $userUri, 
                EF_RDFS_LABEL, 
                array(
                    'value' => $label,
                    'type'  => 'literal'
                ),
                false
            );
        }
        
        if (isset($actionConfig['defaultGroup'])) {
            $store->addStatement(
                $acModelUri,
                $actionConfig['defaultGroup'], 
                $this->_uris['group_membership'], 
                array(
                    'value' => $webId,
                    'type'  => 'uri'
                ),
                false
            );
        }
        
        return true;
    }
    
    /**
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        if (null === $this->_get) {
            // Check if we can get the webid by ourself (https+openssl)
            if ($this->_isSelfCheckPossible()) {
                $webId = $this->_getAndCheckWebId();
                
                if ($webId !== false) {
                    // Auth...
                    $userResult = $this->_checkWebId($webId);
                    
                    if ($userResult['userUri'] === false) {
                        // Add the user automatically...
                        $this->addUser($webId);
                        $userResult = $this->_checkWebId($webId);    
                    }
                    
                    return $this->_getAuthResult($userResult);
                } else {
                    // Corrupt result
                    $msg = 'No valid WebId found.';
                    $result = false;

                    require_once 'Zend/Auth/Result.php';
                    return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, null, array($msg));
                }
            } else {
                if (null === $this->_idpServiceUrl) {
                    // Currently we need an external service for that...
                    $result = false;
                    $msg = 'No IdP configured.';

                    require_once 'Zend/Auth/Result.php';
                    return new Zend_Auth_Result($result, null, array($msg));
                }
                
                // First we fetch the webid in a secure manner...
                $url = $this->_idpServiceUrl . '?authreqissuer=' . urlencode($this->_redirectUrl);
                header('Location: ' . $url);
                exit;
            }
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
                // Auth...
                $webId = $this->_get['webid'];
                $userResult = $this->_checkWebId($webId);
                
                if ($userResult['userUri'] === false) {
                    // Add the user automatically...
                    $this->addUser($webId);
                    $userResult = $this->_checkWebId($webId);    
                }
                
                return $this->_getAuthResult($userResult);
            }
        }
    }
    
    /**
     * This method authenticates a user uri that is given via auth header FOAF+SSL.
     * Therefore the requesting agent needs to be connected via SSL/TLS and the users
     * FOAF needs to be connected to the agent...
     * 
     * @return Zend_Auth_Result
     */
    public function authenticateWithCredentials($credentials)
    {
        // Possible?
        if (!$this->_isSelfCheckPossible()) {
            // Corrupt result
            $msg = 'Not possible.';
            $result = false;

            require_once 'Zend/Auth/Result.php';
            return new Zend_Auth_Result($result, null, array($msg));
        }
        
        // 2. Check the WebID (AgentID) of the requesting client...
        $agentId = $this->_getAndCheckWebId();
        if (!$agentId) {
            // Corrupt result
            $msg = 'Not possible.';
            $result = false;

            require_once 'Zend/Auth/Result.php';
            return new Zend_Auth_Result($result, null, array($msg));
        }
        
        // Now we now that the requesting client is really the client...
        // No check, whether user from credentials delegated access to agent
        $userId = $credentials[1];
        $foafData = $this->_getFoafData($userId);
        $allows = false;
        if (isset($foafData[$userId]['http://ns.ontowiki.net/SysOnt/delegatesAccess'])) {
            foreach ($foafData['http://ns.ontowiki.net/SysOnt/delegatesAccess'] as $oArray) {
                if ($oArray['value'] === $agentId) {
                    $allows = true;
                    break;
                }
            }
        } else {
            // Corrupt result
            $msg = 'Not possible.';
            $result = false;

            require_once 'Zend/Auth/Result.php';
            return new Zend_Auth_Result($result, null, array($msg));
        }
        
        // If allows is true, the user allows the agent to authenticate as him...
        if ($allows === true) {
            $userResult = $this->_checkWebId($userId);
            return $this->_getAuthResult($userResult);
        } else {
            // Corrupt result
            $msg = 'Not possible.';
            $result = false;

            require_once 'Zend/Auth/Result.php';
            return new Zend_Auth_Result($result, null, array($msg));
        }
    }
    
    /**
     * Starts a request to a idp...
     */
    public function fetchWebId()
    {
        // First we fetch the webid in a secure manner...
        $url = $this->_idpServiceUrl . '?authreqissuer=' . urlencode($this->_redirectUrl);
        
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Verifies a idp result...
     * 
     * @param array $get
     * 
     * @return bool
     */
    public function verifyIdpResult($get)
    {
        if (isset($get['webid']) && isset($get['ts']) && isset($get['sig'])) {
            $webId = $get['webid'];
            $ts    = strtotime($get['ts']);
            $sig   = $get['sig'];

// TODO How to verify that in the right way? (time diffs between local server and remote server)
            if ($this->_verifyTimestamp) {
                if ((time() - $ts) > self::TIMESTAMP_VALIDITY) {
                    return false;
                }
            }
            
// TODO Does not work yet...?!
            if ($this->_verifySignature) { 
                if ((null === $this->_publicKey) || !extension_loaded('openssl')) {
                    return false;
                }
                //$this->_publicKey = str_replace(str_split(" \t\n\r\0\x0B"), '', $this->_publicKey);
                $schema = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'])) ? 'https://' : 'http://';
                $url = $schema . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                
                $data = substr($url, 0, strpos($url, '&sig='));
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
    
    // ------------------------------------------------------------------------
    // --- Protected methods --------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Checks the local database, whether user exists
     */
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
    
    /**
     * Checks, whether a client cert is given and valid. If cert is given, it
     * checks the WebID... If everything wents ok the WebID is returned, else
     * false is returned.
     * 
     * @return string|bool
     */
    protected function _getAndCheckWebId()
    {
        if (!(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on' && extension_loaded('openssl'))) {
            // Wrong configuration.
            return false;
        }
        
        if (!isset($_SERVER['SSL_CLIENT_CERT'])) {
            // No client certificate exists or no client certificate populated by server.
            return false;
        }
        
        // Extract the public key of the cert...
        $certRsaPublicKey = $this->_getCertRsaPublicKey();
        if (!$certRsaPublicKey) {
            // Certificate contains no RSA public key.
            return false;
        }
        
        // Extract the subject alternate name of the cert (URI)
        $subjectAlternateNames = $this->_getSubjectAlternativeNames();
        if (!$subjectAlternateNames) {
            // Certificate contains subject alternate name.
            return false;
        }
        
        $foafRsaPublicKey = $this->_getFoafRsaPublicKey($subjectAlternateNames['uri']);
        if (!$foafRsaPublicKey) {
            return false;
        }
        
        // Now compare the two keys...
        if ((int)$certRsaPublicKey['exponent'] === (int)$foafRsaPublicKey['exponent'] && 
            $certRsaPublicKey['modulus'] === $foafRsaPublicKey['modulus']) {
        
            return $subjectAlternateNames['uri'];
        } else {
            return false;
        }
    }
    
    /**
     * Checks the result from the SPARQL query and returns an appropriate result.
     * 
     * @param array $userResult
     * 
     * @return Zend_Auth_Result
     */
    protected function _getAuthResult($userResult)
    {
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
    
    /**
     * Returns the public key of the client cert on success.
     * 
     * @return array|bool
     */
    protected function _getCertRsaPublicKey()
    {
        if (isset($_SERVER['SSL_CLIENT_CERT']) && !empty($_SERVER['SSL_CLIENT_CERT'])) {
            $publicKey  = openssl_pkey_get_public($_SERVER['SSL_CLIENT_CERT']);
            $keyDetails = openssl_pkey_get_details($publicKey);
                        
            $rsaCert  = $keyDetails['key'];
            $rsaCertStruct = `echo "$rsaCert" | openssl asn1parse -inform PEM -i`;
            $rsaCertFields = explode("\n", $rsaCertStruct);
            $rsaKeyOffset  = explode(':', $rsaCertFields[4]);
            $rsaKeyOffset  = trim($rsaKeyOffset[0]);
            
            $rsaKey = `echo "$rsaCert" | openssl asn1parse -inform PEM -i -strparse $rsaKeyOffset`;

            $rsaKeys  = explode("\n", $rsaKey);
            $modulus  = explode(':', $rsaKeys[1]);
            $modulus  = $modulus[3]; 
            $exponent = explode(':', $rsaKeys[2]);
            $exponent = $exponent[3];

            return array(
                'exponent' => strtolower($exponent),
                'modulus'  => strtolower($modulus)
            );
        } else {
            return false;
        }
    }
    
    /**
     * Returns an approriate error message for a negative idp result.
     * 
     * @param array $get
     * 
     * @return string
     */
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

    /**
     * Returns the FOAF data for a given URI.
     * 
     * @return array|false
     */
    protected function _getFoafData($foafUri)
    {
        if (!isset($this->_foafData[$foafUri])) {
            $this->_foafData[$foafUri] = self::getFoafData($foafUri);
        }
        
        return $this->_foafData[$foafUri];
    }
    
    /**
     * Returns the public key in the foaf data on success.
     * 
     * @return array|bool
     */
    protected function _getFoafRsaPublicKey($foafUri)
    {
        $foafData = $this->_getFoafData($foafUri);
        if ($foafData === false) {
            return false;
        }
        
        $pubKeyId = null;
        foreach ($foafData as $s=>$pArray) {
            foreach ($pArray as $p=>$oArray) {
                if ($p === EF_RDF_TYPE) {
                    foreach ($oArray as $o) {
                        if ($o['type'] === 'uri' && $o['value'] === self::PUBLIC_KEY_PROPERTY) {
                            // This is a public key... Now check whether it belongs to the uri...
                            if (isset($foafData[$s][self::IDENTITY_PROP])) {
                                $values = $foafData[$s][self::IDENTITY_PROP];
                                foreach ($values as $v) {
                                    if ($v['type'] === 'uri' && $v['value'] === $foafUri) {
                                        // Match... We can use this Key and stop searching
                                        $pubKeyId = $s;
                                        break 4;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (isset($foafData[$pubKeyId][self::EXPONENT_PROP][0]['value'])) {
            $exponentId = $foafData[$pubKeyId][self::EXPONENT_PROP][0]['value'];
        } else {
            return false;
        }
        if (isset($foafData[$pubKeyId][self::MODULUS_PROP][0]['value'])) {
            $modulusId  = $foafData[$pubKeyId][self::MODULUS_PROP][0]['value'];
        }
        
        $exponent = $foafData[$exponentId][self::DECIMAL_PROP][0]['value'];
        $modulus  = $foafData[$modulusId][self::HEX_PROP][0]['value'];

        return array(
            'exponent' => dechex($exponent),
            'modulus'  => strtolower($modulus)
        );
    }
    
    /**
     * Returns a list of subject alternative names of a given cert on success.
     * 
     * @return array|bool
     */
    protected function _getSubjectAlternativeNames()
    {
        if (isset($_SERVER['SSL_CLIENT_CERT']) && !empty($_SERVER['SSL_CLIENT_CERT'])) {
            $x509Cert = openssl_x509_parse($_SERVER['SSL_CLIENT_CERT']);
           
            if (isset($x509Cert['extensions']['subjectAltName'])) {
                $uriList = explode(',', $x509Cert['extensions']['subjectAltName']);
                $retVal  = array();
                
                foreach ($uriList as $uri) {
                    $key = strtolower(trim(substr($uri, 0, strpos($uri, ':'))));
                    $val = trim(substr($uri, strpos($uri, ':')+1));
                    $retVal[$key] = $val;
                }

                return $retVal;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Can we check client certs ourself? (Needs SSL/TLS)
     * 
     * @return bool
     */ 
    protected function _isSelfCheckPossible()
    {
        if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on' && extension_loaded('openssl')) {
            return true;
        } else {
            return false;
        }
    }
}
