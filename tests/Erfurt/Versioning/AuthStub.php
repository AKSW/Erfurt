<?php
require_once 'Erfurt/Auth/Identity.php';

class Erfurt_Versioning_AuthStub
{    
    public function getIdentity()
    {
        return new Erfurt_Auth_Identity(array('uri' => 'http://example.org/user1/'));
    }
}
