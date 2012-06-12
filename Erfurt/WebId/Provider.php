<?php

class Erfurt_WebId_Provider
{
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
        $spkacFilename  = $tmpDir . $uniqueFilename . '.spkac';
        $certFilename   = $tmpDir . $uniqueFilename . '.temp';
        
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
        $result = array();
        $cmd = "openssl ca -days $expiration -notext -batch -spkac $spkacFilename -out $certFilename -passin pass:$pw";
        $null = exec($cmd, $result);
        
        //unlink($spkacFilename);
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
#var_dump($certData, $modulus, $exponent);exit;
        return array(
            'certData' => $certData,
            'modulus'  => strtolower($modulus),
            'exponent' => hexdec($exponent)
        );
    }
    
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
        if (!Erfurt_App::getInstance()->getAc()->isActionAllowed(Erfurt_Ac::ACTION_REGISTER)) {
            return false;
        }
        
        // Does user already exist?
        $users = Erfurt_App::getInstance()->getUsers();
        if (isset($users[$webId])) {
            return false;
        }
        
        $actionConfig = Erfurt_App::getInstance()->getAc()->getActionConfig('RegisterNewUser');

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
}
