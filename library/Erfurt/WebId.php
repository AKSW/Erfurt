<?php
class Erfurt_WebId
{
    const X509_EXT_KEY = 'extensions';
    const X509_SAN_KEY = 'subjectAltName';
    
    const CERT_RSA_PUBLIC_KEY = 'http://www.w3.org/ns/auth/cert#RSAPublicKey';
    const CERT_KEY            = 'http://www.w3.org/ns/auth/cert#key';
    const CERT_MODULUS        = 'http://www.w3.org/ns/auth/cert#modulus';
    const CERT_EXPONENT       = 'http://www.w3.org/ns/auth/cert#exponent';
    
    const FOAF_MBOX      = 'http://xmlns.com/foaf/0.1/mbox';
    const FOAF_NAME      = 'http://xmlns.com/foaf/0.1/name';
    const FOAD_DEPICTION = 'http://xmlns.com/foaf/0.1/depiction';
    
    /**
     * Normalizes a foaf:mbox value from a profile.
     *
     * Since the definition of foaf:mbox does not specify that the value needs to be a URI,
     * the value is checked and converted to a mailto: URI in this method iff required.
     *
     * @param string $mbox An arbitrary string representation of a mbox.
     * @return string Will return a mailto: URI.
     */
    static public function normalizeFoafMbox($mbox)
    {
        $mbox = trim($mbox);
    
        if (substr($mbox, 0, 7) === 'mailto:') {
            return $mbox;
        }
        
        return ('mailto:' . $mbox);
    }
}