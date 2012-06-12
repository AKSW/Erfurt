<?php
require_once 'Erfurt/WebId/CertHandler.php';

class Erfurt_WebId_CertHandler_Test extends Erfurt_WebId_CertHandler
{
    private $_canHandleCertificates = true;
    private $_webIdUris = array();
    private $_rsaPublicKey = false;

    public function canHandleCertificates()
    {
        return $this->_canHandleCertificates;
    }
    
    public function extractWebIdUris($certDataString)
    {
        return $this->_webIdUris;
    }
    
    public function extractRsaPublicKey($certDataString)
    {
        return $this->_rsaPublicKey;
    }
    
    /* Helper Methods */
    
    public function setCanHandleCertificates($canHandleCertificates)
    {
        $this->_canHandleCertificates = $canHandleCertificates;
    }
    
    public function setWebIdUris(array $webIdUris = array())
    {
        $this->_webIdUris = $webIdUris;
    }
    
    public function setRsaPublicKey(Erfurt_WebId_RsaPublicKey $rsaPublicKey)
    {
        $this->_rsaPublicKey = $rsaPublicKey;
    }
}
