<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */




/**
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package Erfurt_Cache_Backend
 */
class Erfurt_Cache_Backend_Null extends Zend_Cache_Backend implements Zend_Cache_Backend_Interface
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function load($id, $doNotTestCacheValidity = false) 
    {
        return false;
    }
    
    public function test($id) 
    {
        return false;
    }
    
    public function save($data, $id, $tags = array(), $specificLifetime = false)
    {
        return true;
    }
    
    public function remove($id)
    {
        return true;
    }
    
    public function clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array())
    {
        return true;
    }
}
?>
