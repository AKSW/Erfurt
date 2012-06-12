<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2008-2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
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
 * @copyright  Copyright (c) 2009-2012 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    erfurt
 * @subpackage auth
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Auth_Adapter_WebId implements Zend_Auth_Adapter_Interface
{
    private $_certData = null;
    
    private $_config = array(
        'autoAddNewUsers' => true
    );        
    
    private $_consumerStorage = null;
    
    private $_ac = null;
    
    private $_httpClient = null;
        
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
    public function __construct($certData, Erfurt_WebId_Consumer_Storage $consumerStorage, array $config = array())
    {
        $this->_certData        = $certData;
        $this->_consumerStorage = $consumerStorage;
        $this->_config          = array_merge($this->_config, $config);
    }
        
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        require_once 'Erfurt/WebId/Consumer.php';
        $consumer = new Erfurt_WebId_Consumer($this->_consumerStorage);
        if (null !== $this->_httpClient) {
            $consumer->setHttpClient($this->_httpClient);
        }
        
        $autoAddNewUsers = (bool)$this->_config['autoAddNewUsers'];
        if ($autoAddNewUsers === true) {
            if (null !== $this->_ac) {
                $this->_ac->setUser(null); // Anonymous
                $autoAddNewUsers = $this->_ac->isActionAllowed(Erfurt_Ac::ACTION_REGISTER);
            }
        }
        
        // Validate the WebID
        $profile = $consumer->login($this->_certData, $autoAddNewUsers); // Auto add new users
        if (!($profile instanceof Erfurt_WebId_Profile)) {
            // Fail
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE, 
                null, 
                array($consumer->getError())
            );
        }

        $userUri = $this->_consumerStorage->userUriForProfile($profile);
        if (!$userUri) {
            // Fail
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE, 
                null, 
                array('User URI not found for WebID: ' . $profile->webId())
            );
        }
        
        // TODO: Refactor Auth identity?
        $identity = new Erfurt_Auth_Identity(array(
            'uri'            => $userUri,
            'dbuser'         => false, 
            'anonymous'      => false,
            'is_webid_user'  => true
        ));
        
        $loginAllowed = true;
        if (null !== $this->_ac) {
            // Check AC if user login action is denied for user
            $this->_ac->setUser($identity);
            $loginAllowed = $this->_ac->isActionAllowed(Erfurt_Ac::ACTION_LOGIN);
            
            // Reset user on AC object, since Auth class will set it on success.
            $this->_ac->setUser(null);
        }
        
        if ($loginAllowed === true) {
            // Success
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identity, array());
        }
        
        // Fail
        return new Zend_Auth_Result(
            Zend_Auth_Result::FAILURE, 
            null, 
            array('Login not allowed for user with URI: ' . $userUri)
        );
    }
    
    public function setAc(Erfurt_Ac $ac)
    {
        $this->_ac = $ac;
    }
    
    public function setHttpClient(Zend_Http_Client $httpClient)
    {
        $this->_httpClient = $httpClient;
    }
}
