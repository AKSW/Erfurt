<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Zend/Auth.php';

/**
 * Extends the Zend_Auth class in order to provide some additional functionality.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package Erfurt
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Auth extends Zend_Auth
{
    public static function getInstance()
    {
        // We need to copy this, for PHP uses superclass with self :(
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    public function setIdentity(Zend_Auth_Result $authResult)
    {
        if ($authResult->isValid()) {
            $this->getStorage()->write($authResult->getIdentity());
        }
    }
    
    public function setUsername($newUsername)
    {
        $storage = $this->getStorage();
        
        if ($storage->isEmpty()) {
            return;
        }
        
        $identity = $storage->read();
        $identity->setUsername($newUsername);
        $storage->write($identity);
    }
    
    public function setEmail($newEmail)
    {
        $storage = $this->getStorage();
        
        if ($storage->isEmpty()) {
            return;
        }
        
        $identity = $storage->read();
        $identity->setEmail($newEmail);
        $storage->write($identity);
    }
}
