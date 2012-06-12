<?php
require_once 'Erfurt/WebId/Consumer/Storage.php';

class Erfurt_WebId_Consumer_Storage_Test extends Erfurt_WebId_Consumer_Storage
{
    private $_addUserWithProfileWillFail = false;
    private $_userUriForProfileWillReturnNull = false;

    private $_config = array(
        'userBaseUri' => 'http://localhost/OntoWiki/User/'
    );

    private $_users = null;

    public function __construct(array $users = array())
    {
        $this->_users = $users;
    }
    
    public function addUserWithProfile(Erfurt_WebId_Profile $profile)
    {
        if ($this->_addUserWithProfileWillFail === true) {
            return false;
        }
    
    	$webId = $profile->webId();
    
        if (!isset($this->_users[$webId])) {
            $this->_users[$webId] = $this->_config['userBaseUri'] . md5($webId);
        }
            	
    	return true;
    }
    
    public function hasUserWithProfile(Erfurt_WebId_Profile $profile)
    {
    	$webId = $profile->webId();
    		
		return isset($this->_users[$webId]);
    }
    
    public function userUriForProfile(Erfurt_WebId_Profile $profile)
    {
        if ($this->_userUriForProfileWillReturnNull === true) {
            return null;
        }
    
        $webId = $profile->webId();
        
        return (isset($this->_users[$webId]) ? $this->_users[$webId] : null);
    }
    
    /* Helper Methods */
    
    public function setAddUserWithProfileWillFail($flag)
    {
        $this->_addUserWithProfileWillFail = $flag;
    }
    
    public function setUserUriForProfileWillReturnNull($flag)
    {
        $this->_userUriForProfileWillReturnNull = $flag;
    }
}
