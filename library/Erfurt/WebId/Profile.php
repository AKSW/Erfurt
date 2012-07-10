<?php
require_once 'Erfurt/WebId.php';

class Erfurt_WebId_Profile
{
    private $_webId = null;
    private $_profileData = null;
    
    private $_rsaPublicKeys = null;
    
    private $_mboxValues      = null;
    private $_nameValues      = null;
    private $_depictionValues = null;
    
    public function __construct($webId, array $profileData)
    {
        $this->_webId = $webId;
        
        if (isset($profileData[$webId])) {
            $this->_profileData = $profileData;
        } else {
            $this->_profileData = array($webId => array());
        }
    }
    
    public function rsaPublicKeys()
    {
        if (null !== $this->_rsaPublicKeys) {
            return $this->_rsaPublicKeys;
        }
        
        $publicKeys = array();

        $webIdValues = $this->_profileData[$this->_webId];
        if (isset($webIdValues[Erfurt_WebId::CERT_KEY])) {
            $publicKeyIds = array();
            foreach ($webIdValues[Erfurt_WebId::CERT_KEY] as $oSpec) {
                if (($oSpec['type'] === 'bnode') || ($oSpec['type'] === 'uri')) {
                    $publicKeyIds[] = $oSpec['value'];
                }
            }

            require_once 'Erfurt/WebId/RsaPublicKey.php';
            
            foreach ($publicKeyIds as $id) {
                if (isset($this->_profileData[$id])) {
                    $modulus = null;
                    $exponent = null;
                    
                    if (isset($this->_profileData[$id][Erfurt_WebId::CERT_MODULUS])) {
                        $modulus = $this->_profileData[$id][Erfurt_WebId::CERT_MODULUS][0]['value'];
                    }
                    
                    if (isset($this->_profileData[$id][Erfurt_WebId::CERT_EXPONENT])) {
                        $exponent = $this->_profileData[$id][Erfurt_WebId::CERT_EXPONENT][0]['value'];
                    }
                    
                    if ((null !== $modulus) && (null !== $exponent)) {
                        $publicKeys[] = new Erfurt_WebId_RsaPublicKey($modulus, $exponent);
                    }
                }
            }
        }
        
        $this->_rsaPublicKeys = $publicKeys;
        
        return $this->_rsaPublicKeys;
    }
    
    public function mboxValues()
    {
        if (null !== $this->_mboxValues) {
            return $this->_mboxValues;
        }
        
        $mboxValues = array();
        
        $webIdValues = $this->_profileData[$this->_webId];
        if (isset($webIdValues[Erfurt_WebId::FOAF_MBOX])) {
            foreach ($webIdValues[Erfurt_WebId::FOAF_MBOX] as $oSpec) {
                $mboxValues[] = Erfurt_WebId::normalizeFoafMbox($oSpec['value']); 
            }
        }
        
        $this->_mboxValues = $mboxValues;
        return $this->_mboxValues;
    }
    
    public function nameValues()
    {
        if (null !== $this->_nameValues) {
            return $this->_nameValues;
        }
        
        $nameValues = array();
        
        $webIdValues = $this->_profileData[$this->_webId];
        if (isset($webIdValues[Erfurt_WebId::FOAF_NAME])) {
            foreach ($webIdValues[Erfurt_WebId::FOAF_NAME] as $oSpec) {
                $nameValues[] = $oSpec['value']; 
            }
        }
        
        $this->_nameValues = $nameValues;
        return $this->_nameValues;
    }
    
    public function depictionValues()
    {
        if (null !== $this->_depictionValues) {
            return $this->_depictionValues;
        }
        
        $depictionValues = array();
        
        $webIdValues = $this->_profileData[$this->_webId];
        if (isset($webIdValues[Erfurt_WebId::FOAF_DEPICTION])) {
            foreach ($webIdValues[Erfurt_WebId::FOAF_DEPICTION] as $oSpec) {
                $depictionValues[] = $oSpec['value']; 
            }
        }
        
        $this->_depictionValues = $depictionValues;
        return $this->_depictionValues;
    }
    
    public function webId()
    {
        return $this->_webId;
    }
}
