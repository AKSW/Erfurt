<?php
require_once 'Erfurt/WebId/Consumer/Storage.php';

class Erfurt_WebId_Consumer_Storage_Store extends Erfurt_WebId_Consumer_Storage
{
    private $_config = array(
        'userGraphUri'         => 'http://localhost/OntoWiki/Config/',
        'userBaseUri'          => 'http://localhost/OntoWiki/User/',
        'userClass'            => 'http://rdfs.org/sioc/ns#User',
        'userAccountOfProp'    => 'http://rdfs.org/sioc/ns#account_of',
        'userMailProp'         => 'http://rdfs.org/sioc/ns#email',
        'userNameProp'         => 'http://rdfs.org/sioc/ns#name',
        'userAvatarProp'       => 'http://rdfs.org/sioc/ns#avatar',
        'groupDefaultGroupUri' => 'http://localhost/OntoWiki/Config/DefaultUserGroup',
        'groupMemberProp'      => 'http://rdfs.org/sioc/ns#has_member'
    );

    private $_store = null;

    public function __construct(Erfurt_Store $store, array $config = array())
    {
        $this->_config = array_merge($this->_config, $config);
    
        $this->_store = $store;
    }
    
    public function addUserWithProfile(Erfurt_WebId_Profile $profile)
    {
    	$webId = $profile->webId();
    
    	$newUserUri = $this->_config['userBaseUri'] . md5($webId);
    	
    	$userGraphUri   = $this->_config['userGraphUri'];
    	$userClass      = $this->_config['userClass'];
    	$accountOfProp  = $this->_config['userAccountOfProp'];
    	$userMailProp   = $this->_config['userMailProp'];
    	$userNameProp   = $this->_config['userNameProp'];
    	$userAvatarProp = $this->_config['userAvatarProp'];
    	
    	$addArray = array($newUserUri => array(
    		EF_RDF_TYPE => array(array(
    			'type'  => 'uri',
    			'value' => $userClass
    		)),
    		$accountOfProp => array(array(
    			'type'  => 'uri',
    			'value' => $webId
    		))
    	));
    	
    	$mboxValues = $profile->mboxValues();
    	if (count($mboxValues) > 0) {
    		$addArray[$newUserUri][$userMailProp] = array(array(
    			'type'  => 'uri',
    			'value' => $mboxValues[0] // We always use the first mbox only
    		));
    	}
    	
    	$nameValues = $profile->nameValues();
    	if (count($nameValues) > 0) {
    		$addArray[$newUserUri][$userNameProp] = array(array(
    			'type'  => 'literal',
    			'value' => $nameValues[0] // We always use the first name only
    		));
    	}
    	
    	$depictionValues = $profile->depictionValues();
    	if (count($depictionValues) > 0) {
    		$addArray[$newUserUri][$userAvatarProp] = array(array(
    			'type'  => 'uri',
    			'value' => $depictionValues[0] // We always use the first depiction only
    		));
    	} else if ($mboxValues > 0) {
    		$gravatarBase = 'https://secure.gravatar.com/';
    		$mailHash = md5(strtolower(trim(substr($mboxValues[0], 7))));
    		$url = $gravatarBase . $mailHash . '?s=80&d=mm';
    		
    		$addArray[$newUserUri][$userAvatarProp] = array(array(
    			'type'  => 'uri',
    			'value' => $url
    		));
    	}
    	
    	try {
    		$this->_store->addMultipleStatements($userGraphUri, $addArray, false);
    	} catch (Erfurt_Store_Exception $e) {
    		return false;
    	}
    	
    	return true;
    }
    
    public function hasUserWithProfile(Erfurt_WebId_Profile $profile)
    {
    	$webId = $profile->webId();
    
    	$userGraphUri  = $this->_config['userGraphUri'];
    	$userClass     = $this->_config['userClass'];
    	$accountOfProp = $this->_config['userAccountOfProp'];
    
        $sparqlQuery = <<<EOF
ASK FROM <$userGraphUri>
WHERE {
	?user a <$userClass> .
    ?user <$accountOfProp> <$webId> . 
}
EOF;	
		
		return $this->_store->sparqlAsk($sparqlQuery, array('use_ac' => false));
    }
    
    public function userUriForProfile(Erfurt_WebId_Profile $profile)
    {
        $webId = $profile->webId();
    
    	$userGraphUri  = $this->_config['userGraphUri'];
    	$userClass     = $this->_config['userClass'];
    	$accountOfProp = $this->_config['userAccountOfProp'];
    
        $sparqlQuery = <<<EOF
SELECT ?user FROM <$userGraphUri>
WHERE {
	?user a <$userClass> .
    ?user <$accountOfProp> <$webId> . 
}
LIMIT 1
EOF;	
		
		$retVal = null;
		$result = $this->_store->sparqlQuery($sparqlQuery, array(
            'use_ac' => false, 
            STORE_RESULTFORMAT => STORE_RESULTFORMAT_PLAIN
        ));
		if (count($result) === 1) {
            $retVal = $result[0]['user'];
		}
		
		return $retVal;
    }
}
