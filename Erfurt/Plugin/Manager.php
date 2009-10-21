<?php

require_once 'Erfurt/Event/Dispatcher.php';

/**
 * Erfurt plugin manager.
 *
 * @package Erfurt
 * @subpackage plugin
 * @author Michael Haschke
 * @author Norman Heino <norman.heino@gmail.com>
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Plugin_Manager
{
    /**
     * Name of the plugin config file.
     * @var string
     */
    const CONFIG_FILENAME = 'plugin.ini';
    
    /**
     * Postfix for plug-in class names
     * @var string
     */
    const PLUGIN_CLASS_POSTFIX = 'Plugin';
    
    /**
     * Name of the private config section that is injected into the plugin instance.
     * @var string
     */
    const PRIVATE_SECTION = 'private';
    
    /**
     * Array of scanned plugin paths.
     * @var array
     */
    protected $_pluginPaths = array();
    
    /**
     * Array of active plugins.
     * @var array
     */
    protected $_plugins = array();
    
    /**
     * Erfurt event dispatcher to register plugins.
     * @var Erfurt_Event_Dispatcher
     */
    protected $_eventDispatcher = null;
    
    public function __construct()
    {
        $this->_eventDispatcher = Erfurt_Event_Dispatcher::getInstance();
    }
    
    /**
     * Adds a new plugin path and triggers scanning.
     *
     * @param string $pathSpec
     */
    public function addPluginPath($pathSpec)
    {
        $path = rtrim($pathSpec, '/\\') . DIRECTORY_SEPARATOR;
        
        if (is_readable($path) && !in_array($path, $this->_pluginPaths)) {
            $this->_pluginPaths[] = $path;
            $this->_scanPluginPath($path);
        }
    }
    
    /**
     * Returns whether the specified plug-in is enabled
     *
     * @param string $name The unique name of the plug-in
     * @param booleand $registeredOnly Returns true if the plug-in is enabled
     *        and has been registered for at least one event.
     * @return boolean
     */
    public function isPluginEnabled($pluginName, $registeredOnly = false)
    {
        if (array_key_exists($pluginName, $this->_plugins)) {
            return !$registeredOnly || !empty($this->_plugins[$pluginName]);
        }
        
        return false;
    }
    
    /**
     * Adds a plugin and registers it with the dispatcher.
     *
     * @param string $pluginName
     * @param string $pluginPath
     */
    private function _addPlugin($pluginName, $pluginPath)
    {
        // parse plugin config
        $pluginConfig = parse_ini_file($pluginPath . self::CONFIG_FILENAME, true);
        
        if (array_key_exists('private', $pluginConfig)) {
            require_once 'Zend/Config/Ini.php';
            $pluginPrivateConfig = new Zend_Config_Ini($pluginPath . self::CONFIG_FILENAME, 'private', true);
        }
        
        // check if plugin is enabled
        if (!array_key_exists('enabled', $pluginConfig) || !(boolean) $pluginConfig['enabled']) {
            return;
        }
        
        // keep track of loaded plug-ins
        if (!array_key_exists($pluginName, $this->_plugins)) {
            $this->_plugins[$pluginName] = array();
        }
        
        if (array_key_exists('events', $pluginConfig) and is_array($pluginConfig['events'])) {
            foreach ($pluginConfig['events'] as $event) {
                if (is_array($event)) {
                    // TODO: allow trigger method that differs from event name
                } else if (is_string($event)) {
                    $pluginSpec = array(
                        'class_name'   => ucfirst($pluginName) . self::PLUGIN_CLASS_POSTFIX, 
                        'file_name'    => $pluginName,
                        'include_path' => $pluginPath, 
                        'config'       => isset($pluginPrivateConfig) ? $pluginPrivateConfig : null
                    );
                    
                    // register plugin events with event dispatcher
                    $this->_eventDispatcher->register($event, $pluginSpec);
                    
                    // keep track of registered events for the plugin
                    array_push($this->_plugins[$pluginName], $event);
                }
            }
        }
        // var_dump($pluginConfig);
    }
    
    /**
     * Scans a specified path for plugins.
     *
     * @param string $pathSpec
     */
    private function _scanPluginPath($pathSpec)
    {
        $iterator = new DirectoryIterator($pathSpec);
        
        foreach ($iterator as $file) {
            if (!$file->isDot() && $file->isDir()) {
                $fileName  = $file->getFileName();
                $innerPath = $pathSpec . $fileName . DIRECTORY_SEPARATOR;
                
                // if a config file exists, add plugin
                if (is_readable($innerPath . self::CONFIG_FILENAME)) {
                    $this->_addPlugin($fileName, $innerPath);
                }
            }
        }
    }
}

