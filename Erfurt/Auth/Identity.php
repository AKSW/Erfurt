<?php 

/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id:$
 */

/**
 * One-sentence description of Auth.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package erfurt
 * @subpackage auth
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Auth_Identity
{
    protected $_uri = null;
    
    protected $_isOpenId    = false;
    protected $_isWebId     = false;
    protected $_isAnonymous = false;
    protected $_isDbUser    = false;
    
    protected $_propertyUris = array();
    
    protected $_userData = array();
    
    public function __construct(array $userSpec)
    {
        $config = Erfurt_App::getInstance()->getConfig();
        $this->_propertyUris['username'] = $config->ac->user->name;
        $this->_propertyUris['email'] = $config->ac->user->mail;
        $this->_propertyUris['label'] = EF_RDFS_LABEL;
        
        $this->_uri = $userSpec['uri'];
        
        if (isset($userSpec['dbuser'])) {
            $this->_isDbUser = $userSpec['dbuser'];
        } else {
            $this->_isDbUser = false;
        }
        
        if (isset($userSpec['anonymous'])) {
            $this->_isAnonymous = $userSpec['anonymous'];
        } else {
            $this->_isAnonymous = false;
        }
        
        
        if (isset($userSpec['username'])) {
            $this->_userData[$this->_propertyUris['username']] = $userSpec['username'];
        } else {
            $this->_userData[$this->_propertyUris['username']] = '';
        }
        
        if (isset($userSpec['email'])) {
            if (substr($userSpec['email'], 0, 7) === 'mailto:') {
                $this->_userData[$this->_propertyUris['email']] = substr($userSpec['email'], 7);
            } else {
                $this->_userData[$this->_propertyUris['email']] = $userSpec['email'];
            }
        } else {
            $this->_userData[$this->_propertyUris['email']] = '';
        }
        
        if (isset($userSpec['label'])) {
            $this->_userData[$this->_propertyUris['label']] = $userSpec['label'];
        } else {
            $this->_userData[$this->_propertyUris['label']] = '';
        }
        
        if (isset($userSpec['is_openid_user'])) {
            $this->_isOpenId = true;
        } else {
            $this->_isOpenId = false;
        }
        
        if (isset($userSpec['is_webid_user'])) {
            $this->_isWebId = true;
        } else {
            $this->_isWebId = false;
        }   
    }
    
    public function getUri()
    {
        return $this->_uri;
    }
    
    public function getUsername()
    {
        return $this->_userData[$this->_propertyUris['username']];
    }
    
    public function getEmail()
    {
        return $this->_userData[$this->_propertyUris['email']];
    }
    
    public function getLabel()
    {
        return $this->_userData[$this->_propertyUris['label']];
    }
    
    public function isOpenId()
    {
        return $this->_isOpenId;
    }
    
    public function isWebId()
    {
        return $this->_isWebId;
    }
    
    public function isDbUser()
    {
        return $this->_isDbUser;
    }
    
    public function isAnonymousUser()
    {
        return $this->_isAnonymous;
    }
    
    public function setUsername($newUsername)
    {
        // Non-OpenID users are not allowed to change their username!
        if (!($this->isOpenId() || $this->isWebId())) {
            require_once 'Erfurt/Auth/Identity/Exception.php';
            throw new Erfurt_Auth_Identity_Exception('Username change is not allowed!');
        }
        
        $oldUsername = $this->getUsername();
        
        if ($oldUsername !== $newUsername) {
            // Username has changed
            
            $app = Erfurt_App::getInstance();
            $registeredUsernames = array();
            foreach($app->getUsers() as $userUri => $userArray) {
                if (array_key_exists('userName', $userArray)) {
                    $registeredUsernames[] = $userArray['userName'];
                }
            }
            
            $store = $app->getStore();
            
            if (in_array($newUsername, $registeredUsernames) || ($newUsername === $store->getDbUser())
                                                             || ($newUsername === 'Anonymous')
                                                             || ($newUsername === 'Admin')
                                                             || ($newUsername === 'SuperAdmin')) {
                require_once 'Erfurt/Auth/Identity/Exception.php';
                throw new Erfurt_Auth_Identity_Exception('Username already registered.');
            } else {
                // Set the new username.
                $config = $app->getConfig();
                $sysModelUri = $config->sysont->modelUri;
                
                $store->deleteMatchingStatements(
                    $sysModelUri, 
                    $this->getUri(),
                    $config->ac->user->name, 
                    null, 
                    array('use_ac' => false)
                );
                
                if ($newUsername !== '') {
                    $store->addStatement(
                        $sysModelUri, 
                        $this->getUri(),
                        $config->ac->user->name, 
                        array(
                            'type'  => 'literal',
                            'value' => $newUsername,
                            'datatype' => EF_XSD_NS . 'string'
                        ), 
                        false
                    );
                } else {
                    // Also delete password iff set!
                    $store->deleteMatchingStatements(
                        $sysModelUri, 
                        $this->getUri(),
                        $config->ac->user->pass, 
                        null, 
                        array('use_ac' => false)
                    );
                } 
            }
        }
        
        $this->_userData[$this->_propertyUris['username']] = $newUsername;
        return true;
    }
    
    public function setEmail($newEmail)
    {
        // We save mail uris with mailto: prefix.
        if (substr($newEmail, 0, 7) !== 'mailto:') {
            $newEmailWithMailto = 'mailto:' . $newEmail;
        } else {
            $newEmailWithMailto = $newEmail;
        }
        
        $oldEmail = $this->getEmail();
        
        if ($oldEmail !== $newEmail) {
            // Email has changed
            
            if ($newEmail === '') {
                // This case is not allowed, for every user needs a valid email address.
                require_once 'Erfurt/Auth/Identity/Exception.php';
                throw new Erfurt_Auth_Identity_Exception('Email must not be empty.');
            }
            
            $app = Erfurt_App::getInstance();
            
            $registeredEmailAddresses = array();
            foreach($app->getUsers() as $userUri => $userArray) {
                if (array_key_exists('userEmail', $userArray)) {
                    $registeredEmailAddresses[] = $userArray['userEmail'];
                }
            }
                    
            require_once 'Zend/Validate/EmailAddress.php';
            $emailValidator = new Zend_Validate_EmailAddress();
            $actionConfig = $app->getActionConfig('RegisterNewUser');
            
            if (in_array($newEmailWithMailto, $registeredEmailAddresses)) {
                require_once 'Erfurt/Auth/Identity/Exception.php';
                throw new Erfurt_Auth_Identity_Exception('Email address is already registered.');
            } else if (isset($actionConfig['mailvalidation']) && $actionConfig['mailvalidation'] == 'yes' 
                                                              && !$emailValidator->isValid($newEmail)) {
                
                require_once 'Erfurt/Auth/Identity/Exception.php';
                throw new Erfurt_Auth_Identity_Exception('Email address validation failed.');
            } else {
                // Set new mail address
                $store = $app->getStore();
                $config = $app->getConfig();
                $sysModelUri = $config->sysont->modelUri;
                 
                $store->deleteMatchingStatements(
                    $sysModelUri, 
                    $this->getUri(),
                    $config->ac->user->mail, 
                    null, 
                    array('use_ac' => false)
                );

                $store->addStatement(
                    $sysModelUri, 
                    $this->getUri(),
                    $config->ac->user->mail, 
                    array(
                        'type'  => 'uri',
                        'value' => $newEmailWithMailto
                    ), 
                    false
                );
             }
        }
        
        $this->_userData[$this->_propertyUris['email']] = $newEmail;
        return true;
    }
    
    public function setLabel($newLabel)
    {
        // TODO later
    }
    
    public function setPassword($newPassword)
    {
        $username = $this->getUsername();
        $app = Erfurt_App::getInstance();
        $actionConfig = $app->getActionConfig('RegisterNewUser');
        
        if ($username !== '') {
            if (strlen($newPassword) < 5) {
                require_once 'Erfurt/Auth/Identity/Exception.php';
                throw new Erfurt_Auth_Identity_Exception('Password needs at least 5 characters.');
            } else if (isset($actionConfig['passregexp']) && $actionConfig['passregexp'] != '' 
                                                          && !@preg_match($actionConfig['passregexp'], $newPassword)) {
            
                require_once 'Erfurt/Auth/Identity/Exception.php';
                throw new Erfurt_Auth_Identity_Exception('Password does not match regular expression set in system configuration');
            } else {
                // Set new password.
                $store = $app->getStore();
                $config = $app->getConfig();
                $sysModelUri = $config->sysont->modelUri;
                
                $store->deleteMatchingStatements(
                    $sysModelUri, 
                    $this->getUri(),
                    $config->ac->user->pass, 
                    null, 
                    array('use_ac' => false)
                );

                $store->addStatement(
                    $sysModelUri,
                    $this->getUri(), 
                    $config->ac->user->pass, 
                    array(
                        'value' => sha1($newPassword),
                        'type'  => 'literal'
                    ),
                    false
                );
            }
        } else {
            // If we have no username, we need no password.
            require_once 'Erfurt/Auth/Identity/Exception.php';
            throw new Erfurt_Auth_Identity_Exception('Passwords are only allowed if a Username is set.');
        }
        
        return true;
    }
    
    public function get($propertyUri)
    {
       // TODO later
    }
    
    public function set($propertyUri, $value)
    {
        // TODO later
    }
}
