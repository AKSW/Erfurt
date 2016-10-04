<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * Erfurt RDF authentication adapter.
 *
 * Authenticates a subject via an nothing.
 *
 * @package Erfurt_Auth_Adapter
 * @author  Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Auth_Adapter_None implements Zend_Auth_Adapter_Interface
{   
    private $_username = null;
    private $_password = null;

    /**
     * Constructor
     */
    public function __construct($username = null, $password = null) 
    {        
        // Nothing to do here...
        $this->_username = $username;
        $this->_password = $password;
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
            'username'  => $this->_username,
            'uri'       => 'http://ns.ontowiki.net/SysOnt/' . $this->_username,
            'dbuser'    => (($this->_username === 'SuperAdmin') ? true : false), 
            'anonymous' => (($this->_username === 'Anonymous') ? true : false)
        );
        
        $identityObject = new Erfurt_Auth_Identity($identity);
        $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identityObject);
        
        return $authResult;
    }
}
