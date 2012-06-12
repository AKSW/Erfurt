<?php
// TODO: Caching of WebIDs?
// TODO: Habndle fragment URIs differently? (e.g. no redirects?)
// TODO: Allow also HTTP WebIds? When configured?

require_once 'Zend/Http/Client.php';

class Erfurt_WebId_Consumer
{
    
    
    /**
     * HTTP client to make HTTP requests
     *
     * @var Zend_Http_Client
     */
    private $_httpClient = null;
    
    private $_error = null;
    
    private $_storage = null;
    
    private $_certHandler = null;
    
    public function __construct(Erfurt_WebId_Consumer_Storage $storage, Erfurt_WebId_CertHandler $certHandler = null)
    {
        $this->_storage = $storage;
        
        if (null === $certHandler) {
            $this->_certHandler = new Erfurt_WebId_CertHandler_OpenSsl();
        } else {
            $this->_certHandler = $certHandler;
        }
    
        if (!$this->_certHandler->canHandleCertificates()) {
            require_once 'Erfurt/WebId/Consumer/Exception.php'; 
            throw new Erfurt_WebId_Consumer_Exception('OpenSSL extension required for WebId support.');
        }
    }
    
    public function setHttpClient(Zend_Http_Client $httpClient)
    {
        $this->_httpClient = $httpClient;
    }
    
    public function getError()
    {
        return $this->_error;
    }
    
    public function login($certDataString, $autoAddUserToStorage = false)
    {
        $webIdUris = $this->_certHandler->extractWebIdUris($certDataString);
        if (count($webIdUris) === 0) {
            // No WebIds found in cert data.
            $this->_setError('No WebIds found in certificate');
            return false;
        }

        $certRsaPublicKey = $this->_certHandler->extractRsaPublicKey($certDataString);
        if (!$certRsaPublicKey) {
            $this->_setError('No RSA public key found in certificate');
            return false;
        }

        // Check for all found WebIds, but break on first success.
        $validatedProfile = null;
        foreach ($webIdUris as $webIdUri) {
            $profile = $this->_fetchProfile($webIdUri);
            if (!($profile instanceof Erfurt_WebId_Profile)) {
                continue;
            }
            
            $profileRsaPublicKeys = $profile->rsaPublicKeys();
            foreach ($profileRsaPublicKeys as $profileKey) {
                if ($certRsaPublicKey->isEqual($profileKey)) {
                    $validatedProfile = $profile;
                    break 2; // We break both loops here, since one match is enough.
                }
            }
        }
        
        if (null !== $validatedProfile) {
            // Check storage!
            if ($this->_storage->hasUserWithProfile($validatedProfile)) {
                return $validatedProfile;
            } else {
                if ($autoAddUserToStorage === true) {
                    $userAddResult = $this->_storage->addUserWithProfile($validatedProfile);
                    if ($userAddResult === true) {
                        return $validatedProfile;
                    } else {
                        $this->_setError(
                            'Failed to automatically add user with WebID: ' . $validatedProfile->webId()
                        );
                    }
                } else {
                    $this->_setError('User not existing with WebID: ' . $validatedProfile->webId());
                } 
            }
        } else {
            $this->_setError('No valid profile found.');
        }
        
        return false;
    }

    protected function _fetchProfile($webId)
    {
        if (substr($webId, 0, 8) !== 'https://') {
            $this->_setError('Only HTTPS WebIDs supported! Given: ' . $webId);
            return false;
        }
    
        $client = $this->_httpClient;
        if (null === $client) {
            // @codeCoverageIgnoreStart
            $client = new Zend_Http_Client(
                $webId,
                array(
                    'maxredirects'   => 1,
                    'timeout'        => 30,
                    'useragent'      => 'Erfurt_WebId'
                )
            );
            
            // WebId spec recommends to use a higher q value for RDF/XML, since some systems may return
            // HTML without annotations.
            $client->setHeaders('Accept: application/rdf+xml,application/xhtml+xml;q=0.9,text/html;q=0.9');
        } else {
            // @codeCoverageIgnoreEnd
            $client->setUri($webId);
        }
        
        try {
            $response = $client->request();
        } catch (Exception $e) {
            $this->_setError('HTTP request failed: ' . $e->getMessage());
            return false;
        }
        
        $status = $response->getStatus();
        $body = $response->getBody();
        if ($status !== 200) { // 200 OK
            $this->_setError('Bad HTTP response with status code: ' . $status);
            return false;
        }
        
        $contentType = $response->getHeader('Content-Type');
        if (null === $contentType) {
            $this->_setError('Bad HTTP response: Missing Content-Type');
            return false;
        }
        
        if ($contentType === 'application/rdf+xml') {
            require_once 'Erfurt/Syntax/RdfParser.php';
            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat('rdfxml');
            
            try {
                $profileData = $parser->parse($body, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
            } catch (Exception $e) {
                $this->_setError('Failed to parse RDF/XML for profile: ' . $e->getMessage());
                return false;
            }
            
            if (!is_array($profileData) || !isset($profileData[$webId])) {
                $this->_setError('Invalid profile data.');
                return false;
            }
            
            require_once 'Erfurt/WebId/Profile.php';
            return new Erfurt_WebId_Profile($webId, $profileData);
        } else if (($contentType === 'application/xhtml+xml') || ($contentType === 'text/html')) {
            // TODO: Handle RDFa
        } else {
            $this->_setError('Content-Type not supported: ' . $contentType);
            return false;
        }
        
        // @codeCoverageIgnoreStart
        return false;
        // @codeCoverageIgnoreEnd
    }
    
    protected function _setError($message)
    {
        $this->_error = $message;
    }
}
