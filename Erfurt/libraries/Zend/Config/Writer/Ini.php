<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Config
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Ini.php 12221 2008-10-31 20:32:43Z dasprid $
 */

/**
 * @see Zend_Config_Writer
 */
require_once 'Zend/Config/Writer.php';

/**
 * @category   Zend
 * @package    Zend_Config
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Config_Writer_Ini extends Zend_Config_Writer
{
    /**
     * Filename to write to
     *
     * @var string
     */
    protected $_filename = null;
        
    /**
     * String that separates nesting levels of configuration data identifiers
     *
     * @var string
     */
    protected $_nestSeparator = '.';
    
    /**
     * Set the target filename
     *
     * @param  string $filename
     * @return Zend_Config_Writer_Xml
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;
        
        return $this;
    }
    
    /**
     * Set the nest separator
     *
     * @param  string $filename
     * @return Zend_Config_Writer_Ini
     */
    public function setNestSeparator($separator)
    {
        $this->_nestSeparator = $separator;
        
        return $this;
    }
    
    /**
     * Defined by Zend_Config_Writer
     *
     * @param  string      $filename
     * @param  Zend_Config $config
     * @throws Zend_Config_Exception When filename was not set
     * @throws Zend_Config_Exception When filename is not writable
     * @return void
     */
    public function write($filename = null, Zend_Config $config = null)
    {
        if ($filename !== null) {
            $this->setFilename($filename);
        }
        
        if ($config !== null) {
            $this->setConfig($config);
        }
        
        if ($this->_filename === null) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('No filename was set');
        }
        
        if ($this->_config === null) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('No config was set');
        }
        
        $iniString   = '';
        $extends     = $this->_config->getExtends();
        $sectionName = $this->_config->getSectionName();
        
        if (is_string($sectionName)) {
            $iniString .= '[' . $sectionName . ']' . "\n"
                       .  $this->_addBranch($this->_config)
                       .  "\n";
        } else {       
            foreach ($this->_config as $sectionName => $data) {
                if (isset($extends[$sectionName])) {
                    $sectionName .= ' : ' . $extends[$sectionName];
                }
                
                $iniString .= '[' . $sectionName . ']' . "\n"
                           .  $this->_addBranch($data)
                           .  "\n";
            }
        }
       
        $result = @file_put_contents($this->_filename, $iniString);

        if ($result === false) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('Could not write to file "' . $this->_filename . '"');
        }
    }
    
    /**
     * Add a branch to an INI string recursively
     *
     * @param  Zend_Config $config
     * @return void
     */
    protected function _addBranch(Zend_Config $config, $parents = array())
    {
        $iniString = '';

        foreach ($config as $key => $value) {
            $group = array_merge($parents, array($key));
            
            if ($value instanceof Zend_Config) {
                $iniString .= $this->_addBranch($value, $group);
            } else {
                $iniString .= implode($this->_nestSeparator, $group)
                           .  ' = '
                           .  $this->_prepareValue($value)
                           .  "\n";
            }
        }
        
        return $iniString;
    }
    
    /**
     * Prepare a value for INI
     *
     * @param  mixed $value
     * @return string
     */
    protected function _prepareValue($value)
    {
        if (is_integer($value) || is_float($value)) {
            return $value;
        } elseif (is_bool($value)) {
            return ($value ? 'true' : 'false');
        } else {
            return '"' . addslashes($value) .  '"';
        }
    }
}
