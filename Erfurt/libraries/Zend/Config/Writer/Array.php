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
 * @version    $Id: Array.php 12221 2008-10-31 20:32:43Z dasprid $
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
class Zend_Config_Writer_Array extends Zend_Config_Writer
{
    /**
     * Filename to write to
     *
     * @var string
     */
    protected $_filename = null;
    
    /**
     * Set the target filename
     *
     * @param  string $filename
     * @return Zend_Config_Writer_Array
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;
        
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
        
        $data        = $this->_config->toArray();
        $sectionName = $this->_config->getSectionName();
        
        if (is_string($sectionName)) {
            $data = array($sectionName => $data);
        }
        
        $arrayString = "<?php\n"
                     . "return " . var_export($data, true) . ";\n";
       
        $result = @file_put_contents($this->_filename, $arrayString);
        
        if ($result === false) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('Could not write to file "' . $this->_filename . '"');
        }
    }
}
