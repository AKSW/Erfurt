<?php
require_once 'Erfurt/WebId/CertHandler.php';

class Erfurt_WebId_CertHandler_OpenSsl extends Erfurt_WebId_CertHandler
{
    public function canHandleCertificates()
    {
        return (bool)extension_loaded('openssl');
    }
    
    public function extractWebIdUris($certDataString)
    {
        $retVal = array();
        
        $x509Cert = openssl_x509_parse($certDataString);
        if (isset($x509Cert[Erfurt_WebId::X509_EXT_KEY][Erfurt_WebId::X509_SAN_KEY])) {
           $sanList = explode(',', $x509Cert[Erfurt_WebId::X509_EXT_KEY][Erfurt_WebId::X509_SAN_KEY]);
           foreach ($sanList as $sanItem) {
               $prefix = strtolower(substr($sanItem, 0, 4));
               if ($prefix === 'uri:') {
                   $retVal[] = substr($sanItem, 4);
               }
           }
       }
       
       return $retVal;
    }
    
    public function extractRsaPublicKey($certDataString)
    {
        $publicKey = openssl_pkey_get_public($certDataString);
        if (!$publicKey) {
            $this->_setError('Failed to retrieve public key from certificate');
            return false;
        }

        $keyDetails = openssl_pkey_get_details($publicKey);
        if (!is_array($keyDetails) || !isset($keyDetails['key'])) {
            $this->_setError('Invalid public key details');
            return false;
        }
        
        $rsaPubKeyPem = $keyDetails['key'];
        $rsaPubKeyInfoStruct = shell_exec("echo '$rsaPubKeyPem' | openssl asn1parse -inform PEM -i");
        if (!$rsaPubKeyInfoStruct) {
            $this->_setError('Failed to retrieve public key info structure');
            return false;
        }
        
        $rsaPubKeyInfoFields = explode("\n", $rsaPubKeyInfoStruct);
        if (count($rsaPubKeyInfoFields) < 5) {
            $this->_setError('Public key info field for offset missing');
            return false;
        }
        $rsaPubKeyOffsetLine = explode(':', $rsaPubKeyInfoFields[4]); // line that contains the offset
        $rsaPubKeyOffset = (int)trim($rsaPubKeyOffsetLine[0]); // first number is the offset
        if (!is_numeric($rsaPubKeyOffset)) {
            $this->_setError('Invalid public key offset');
            return false;
        }        
        
        $cmd = "echo '$rsaPubKeyPem' | openssl asn1parse -inform PEM -i -strparse $rsaPubKeyOffset";
        $rsaKeyStruct = shell_exec($cmd);
        
        $rsaKeyStructLines = explode("\n", $rsaKeyStruct);
        if (count($rsaKeyStructLines) < 3) {
            $this->_setError('Invalid RSA key struct');
            return false;
        }
        
        $modulusLine = $rsaKeyStructLines[1]; // contains the modulus
        $exponentLine = $rsaKeyStructLines[2]; // contains the exponent
        
        $modulusLineItems = explode(':', $modulusLine);
        if (count($modulusLineItems) < 4) {
            $this->_setError('Modulus not found');
            return false;
        }
        $modulus = $modulusLineItems[3]; // contains the modulus
        
        $exponentLineItems = explode(':', $exponentLine);
        if (count($exponentLineItems) < 4) {
            $this->_setError('Exponent not found');
            return false;
        }
        $exponent = (int)hexdec($exponentLineItems[3]); // contains the exponent
        if (!is_numeric($exponent)) {
            $this->_setError('Invalid exponent');
            return false;
        }
        
        require_once 'Erfurt/WebId/RsaPublicKey.php';
        return new Erfurt_WebId_RsaPublicKey($modulus, $exponent);
    }
}
