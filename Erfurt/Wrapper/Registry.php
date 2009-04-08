<?php
/**
 *
 * @category  erfurt
 * @package   wrapper
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2009 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id$
 */
class Erfurt_Wrapper_Registry
{
    /**
     * This static property contains the instance, for this class is realized
     * following the singleton pattern.
     * 
     * @var Erfurt_Wrapper_Registry
     */
    private static $_instance = null;
    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * This property contains all registered (active) wrapper.
     * 
     * @var array
     */
    protected $_wrapperRegistry = array();
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * The constructor is private, for this class is a singleton.
     */
    private function __construct()
    {
        // Nothing to do here.
    }
    
    // ------------------------------------------------------------------------
    // --- Public static methods ----------------------------------------------
    // ------------------------------------------------------------------------
    
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new Erfurt_Wrapper_Registry();
        }
        
        return self::$_instance;
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Returns the instanciated wrapper class specified by the given wrapper
     * name. If no such a wrapper is registered, this method throws an exception.
     * 
     * @param string $wrapperName
     * @throws Erfurt_Wrapper_Exception
     */
    public function getWrapperInstance($wrapperName)
    {
        if (!isset($this->_wrapperRegistry[$wrapperName])) {
            require_once 'Erfurt/Wrapper/Exception.php';
            throw new Erfurt_Wrapper_Exception("A wrapper with name '$wrapperName' has not been registered.");
        }
        
        if (null === $this->_wrapperRegistry[$wrapperName]['instance']) {
            $pathSpec = rtrim($this->_wrapperRegistry[$wrapperName]['include_path'], '/\\') 
                      . DIRECTORY_SEPARATOR 
                      . strtolower($wrapperName) . '.php';
            
            require_once $pathSpec;
            $instance = new $this->_wrapperRegistry[$wrapperName]['class_name'];
            $instance->init($this->_wrapperRegistry[$wrapperName]['config']);
            $this->_wrapperRegistry[$wrapperName]['instance'] = $instance;
        }
        
        return $this->_wrapperRegistry[$wrapperName]['instance'];
    }
    
    /**
     * Returns a list containing all active wrapper.
     * 
     * @return array
     */
    public function listActiveWrapper()
    {
        return array_keys($this->_wrapperRegistry);
    }
    
    /**
     * Registers a given wrapper within the registry. The wrapper specification
     * contains the following keys: class_name, include_path, config, instance.
     * 
     * @param string $wrapperName
     * @param array $wrapperSpec
     * @throws Erfurt_Wrapper_Exception
     */
    public function register($wrapperName, $wrapperSpec)
    {
        if (isset($this->_wrapperRegistry[$wrapperName])) {
            require_once 'Erfurt/Wrapper/Exception.php';
            throw new Erfurt_Wrapper_Exception("A wrapper with name '$wrapperName' has already been registered.");
        }
        
        $this->_wrapperRegistry[$wrapperName] = $wrapperSpec;
    }
}
