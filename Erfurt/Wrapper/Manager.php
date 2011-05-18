<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id: Manager.php 4013 2009-08-13 14:37:18Z pfrischmuth $
 */

require_once 'Erfurt/Wrapper/Registry.php';

/**
 * This class provides functionality in order to scan directories for wrapper
 * extensions.
 * 
 * @copyright  Copyright (c) 2009 {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    erfurt
 * @subpackage wrapper
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Wrapper_Manager
{
    // ------------------------------------------------------------------------
    // --- Public constants ---------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Name of the wrapper config file.
     * 
     * @var string
     */
    const CONFIG_FILENAME = 'wrapper.ini';
    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * This property defines the section of the configuration file, which is
     * used for wrapper-internal options.
     * 
     * @var string
     */
    protected $_configPrivateSection = 'private';
    
    /**
     * This property holds a reference to the registry instance.
     * 
     * @var Erfurt_Wrapper_Registry 
     */
    protected $_registry = null;
    
    /**
     * This property contains directories, that were already scanned.
     * 
     * @var array
     */
    protected $_wrapperPaths = array();
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * The constructor of this class, which initializes new objects.
     */
    public function __construct()
    {
        $this->_registry = Erfurt_Wrapper_Registry::getInstance();
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Scans a given path and adds the wrapper plugins found in that path.
     * 
     * @param string $pathSpec
     */
    public function addWrapperPath($pathSpec)
    {
        $path = rtrim($pathSpec, '/\\') . DIRECTORY_SEPARATOR;
        
        if (is_readable($path) && !isset($this->_wrapperPaths[$path])) {
            $this->_wrapperPaths[$path] = true;
            $this->_scanWrapperPath($path);
        }
    }
    
    // ------------------------------------------------------------------------
    // --- Protected methods --------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Checks a given wrapper name and path pair, whether the specified plugin
     * is active (a key "enabled" needs to be set to "true").
     * If a wrapper plugin is not active, the method just returns. 
     * If a wrapper plugin is activated, the method parses the config file and
     * registers the wrapper within the registry.
     * 
     * @param string $wrapperName
     * @param string $wrapperPath
     */ 
    protected function _addWrapper($wrapperName, $wrapperPath)
    {
        $wrapperConfig = parse_ini_file(($wrapperPath . self::CONFIG_FILENAME), true); 
        if (!array_key_exists('enabled', $wrapperConfig) || !(boolean)$wrapperConfig['enabled']) {
            // Wrapper is disabled.
            return;
        }
        
        if (isset($wrapperConfig[$this->_configPrivateSection])) {
            require_once 'Zend/Config/Ini.php';
            $privateConfig = new Zend_Config_Ini(
                $wrapperPath . self::CONFIG_FILENAME, 
                $this->_configPrivateSection, 
                true
            );
        } else {
            $privateConfig = false;
        }
        
        $wrapperSpec = array(
            'class_name'   => ucfirst($wrapperName) . 'Wrapper',
            'include_path' => $wrapperPath,
            'config'       => $privateConfig,
            'instance'     => null
        );
        
        // Finally register the wrapper.
        $this->_registry->register($wrapperName, $wrapperSpec);
    }
    
    /**
     * This method iterates through a given directory.
     * 
     * @var string $pathSpec
     */
    protected function _scanWrapperPath($pathSpec)
    {
        $iterator = new DirectoryIterator($pathSpec);
        
        foreach ($iterator as $file) {
            if (!$file->isDot() && $file->isDir()) {
                $fileName  = $file->getFileName();
                $innerPath = $pathSpec . $fileName . DIRECTORY_SEPARATOR;
                
                // Iff a config file exists add the wrapper
                if (is_readable(($innerPath . self::CONFIG_FILENAME))) {
                    $this->_addWrapper($fileName, $innerPath);
                }
            }
        }
    }   
}
