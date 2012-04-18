<?php

require_once 'Zend/Auth/Adapter/Interface.php';
require_once 'Zend/Auth/Result.php';

/**
 * Erfurt RDF authentication adapter.
 *
 * Authenticates a subject via an nothing.
 *
 * @package erfurt
 * @subpackage auth
 * @author  Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license
 * @version $Id: Rdf.php 4191 2009-09-25 10:32:03Z c.riess.dev $
 */
class Erfurt_Auth_Adapter_None implements Zend_Auth_Adapter_Interface
{   
    /**
     * Constructor
     */
    public function __construct($username = null, $password = null) 
    {        
        // Nothing to do here...
    }
    
    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate() 
    {
        $identity = array(
            'username'  => 'Anonymous', 
            'uri'       => 'http://ns.ontowiki.net/SysOnt/Anonymous', 
            'dbuser'    => false, 
            'anonymous' => true
        );
        
        require_once 'Erfurt/Auth/Identity.php';
        $identityObject = new Erfurt_Auth_Identity($identity);
        $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identityObject);
        
        return $authResult;
    }
}
