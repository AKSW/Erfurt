<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Zend/Auth/Adapter/Interface.php';
require_once 'Zend/Auth/Result.php';

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
        
        require_once 'Erfurt/Auth/Identity.php';
        $identityObject = new Erfurt_Auth_Identity($identity);
        $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identityObject);
        
        return $authResult;
    }
}
