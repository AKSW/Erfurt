<?php
/**
 * Erfurt Plugin Manager
 *
 * Provides methods to initialize and activate plugins founded in a submitted
 * directory, save their configurations, instanciate their classes by request
 * and announce plugin methods to event dispatcher as subscriber/listener.
 *
 * @package plugin
 * @package erfurt
 * @author  Michael Haschke
 * @version $Id: PluginManager.php 1638 2007-11-13 19:53:20Z p_frischmuth $
 */
class Erfurt_PluginManager {
    
	/**
	 * all directories where plugin files and classes may be located
	 */																								
    private $_pluginFolders = array(); 

	/**
	 * relations between plugin class and plugin "namespace"
	 * "namespace" = absolute filename of ini-file without extension
	 */																								
    private $_relationClassPlugin = array();

	/**
	 * all directories which were inluded to PHP include path
	 */																								
    private $_included = array();

	/**
	 * all previously prepared instances of plugin classes
	 */																								
    private $_instances = array();

	/**
	 * Erfurt App object
	 */																								
    private $_erfurt = null;

	/**
	 * EventDispatcher object
	 */																								
    private $_ed = null;

	/**
	 * saved vars by magic methods
	 */																								
    private $_vars = array();

    public function __construct($o) {
    
        $this->_erfurt = $o;
        $this->_ed = $o->getEventDispatcher();
    
    }
    
	/**
	 * Erfurt_PluginManager::init()
	 * init plugins to system
	 *
	 * @param String    $folder  absolute path to plugins
 	 * @param Bool      $refresh delete all data when true (default: false)
 	 *
 	 * @return Bool
 	 *
 	 * @access public
 	 */
    public function init($folder,$refresh=false) {
    
        # set up a fresh environment
        if ($refresh === true) {
            $this->_pluginFolders = array();
            $this->_relationsClassPlugin = array();
            $this->_included = array();
            $this->_instances = array();
        }
    
        # load plugin configurations
        $this->_loadConfigurations($folder);
        
        return true;
        
    }
    
	/**
	 * Erfurt_PluginManager::prepare()
	 * prepare system environment for usage of class:method from a plugin
	 *
	 * @param String    $classname  name of plugin class
 	 *
 	 * @return Mixed
 	 *      o class object: success
 	 *      o bool false: preparation failed
 	 *
 	 * @access public
 	 */
    public function prepare($classname) {

        if (isset($this->_instances[$classname])) {                 # class instance available
            return $this->_instances[$classname];
        }
        elseif (isset($this->_relationClassPlugin[$classname])) {   # search for related namespace
            $namespace = $this->_relationClassPlugin[$classname];
            if ($this->_includeFolders($namespace)) {               # include folders related to namespace
                if (false !== $this->_instanciate($classname)) {
                    # unset($this->_relationClassPlugin[$classname]); # delete relation to namespace
                    return $this->_instances[$classname];
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    
    }
    
	/**
	 * Erfurt_PluginManager::getPluginRoot()
	 * returns absolute root dir path of plugin using submitted class
	 *
	 * @param String    $classname  name of plugin class
 	 *
 	 * @return Mixed
 	 *      o String: absolute path of plugin root dir
 	 *      o Bool false: class not known
 	 *
 	 * @access public
 	 */
    public function getPluginRoot($classname) {
        if (isset($this->_relationClassPlugin[$classname])) {
            $namespace = $this->_relationClassPlugin[$classname];
            return $namespace;
        }
        else {
            return false;
        }   
    }
    
    # create instance of class
    # returns object or false
    private function _instanciate($classname) {

        if (false !== include_once($classname.'.php')) {
            if (class_exists($classname,false)) {
                $pluginRoot = $this->getPluginRoot($classname);
                $config = new Zend_Config_Ini($pluginRoot.'/config.ini');
                eval('$this->_instances[$classname] = new '.$classname.'($this->_erfurt, $config);');
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
        
        # maybe todo: do not use include path but look itself in _pluginFolders[namespace] for php file
    }
    
    
	/**
	 * Erfurt_PluginManager::_loadConfigurations()
	 * read plugin configurations and save information when switch=on
	 *
	 * @param String    $folder  plugin dir on server
 	 *
 	 * @return Bool true after all
 	 *      o currently no errors (cannot read config file, etc) are catched
 	 *
 	 * @access private
 	 */
    private function _loadConfigurations($folder) {
    
        # get list of all active plugins
        $plugins = $this->_listActivePlugins($folder);
        
        foreach ($plugins as $plugin) {
            # get plugin configuration from ini file
            
            $pluginConfig = new Zend_Config_Ini($plugin.'/config.ini', 'general');
            
            if ($pluginConfig->get('switch') == 'on') { # do for active plugins

                # filename as namespace
                $namespace = $plugin;
                
                # root folder for plugin
                $pluginRoot = $plugin . '/';
                
                # read plugin folders
                $pluginFolders = array();
                if ($pluginConfig->get('folder') !== null) {
                    $tempPluginFolders = $pluginConfig->folder->toArray();
                    foreach ($tempPluginFolders as $folderKey => $folderValue) {
                        if ($realpath = realpath($pluginRoot.$folderValue))
                            $pluginFolders[$folderKey] = $realpath;
                           
                    }
                    # save plugin folders with absolute path names
                    $this->_pluginFolders[$namespace] = array_unique($pluginFolders);
                }
                
                
                # read announcements to events
                if ($pluginConfig->get('announce') !== null) {
                    $pluginAnnouncements = $pluginConfig->announce->toArray();
                    foreach ($pluginAnnouncements as $announce) {
                        if (is_array($announce) && count($announce) == 3 &&
                            isset($announce['event']) && isset($announce['class']) && isset($announce['method']) &&
                            is_string($announce['event']) && is_string($announce['class']) && is_string($announce['method']) &&
                            strlen($announce['event'])>0 && strlen($announce['class'])>0 && strlen($announce['method'])>0) {
                                
                                $event = str_replace(' ','',$announce['event']);
                                $class = str_replace(' ','',$announce['class']);
                                $method = str_replace(' ','',$announce['method']);
                                
                                # save releation between class/method and plugin namespace
                                $this->_relationClassPlugin[$class] = $namespace;
                                
                                # announce method to event
                                $this->_ed->announce($event,$class.'::'.$method);
                                
                            }
                    }
                }
                
                # read additional announcements
                if ($pluginConfig->get('add') !== null) {
                    $pluginAnnouncements2 = $pluginConfig->add->toArray();
                    foreach ($pluginAnnouncements2 as $announce) {
                        if (is_array($announce) && count($announce) == 3 &&
                            sset($announce['class']) && isset($announce['method']) &&
                            is_string($announce['class']) && is_string($announce['method']) &&
                            strlen($announce['class'])>0 && strlen($announce['method'])>0) {
                                
                                $class = str_replace(' ','',$announce['class']);
                                $method = str_replace(' ','',$announce['method']);
                                
                                # save relation between class/method and plugin namespace
                                $this->_relationClassPlugin[$class] = $namespace;
                                
                            }
                    }
                }
            
            }
            
        }
        
        return true;
    }
    
	/**
	 * Erfurt_PluginManager::_listActivePlugins()
	 * right now all plugins in submitted folder and switch=on are activated
	 *
	 * @param String    $folder plugin dir on server
 	 *
 	 * @return Array with .ini-files (= plugin "namespaces")
 	 *
 	 * @access private
 	 */
    private function _listActivePlugins($folder) {
    
        # next version: plugins are marked as active in erfurt/ontowiki configuration
        # this version: all plugins in plugin folder are active
        
        return $this->_listPluginsFromFolder($folder);
    }

    private function _listPluginsFromFolder($folder, $plugins = array()) {

        // run through folder and look for *.ini
        // save absolute dir + filename (without .ini)
        
        if (file_exists($folder) && is_dir($folder) && ($fileHandler = opendir($folder))) {
            // folder exists and can be opened
            
            while (($file = readdir($fileHandler)) !== false) {
            
                $concat = str_replace('//','/',$folder.'/'.$file);
            
                // read dir item by item and check type
                if (is_dir($concat) && $file != '.' && $file != '..' && substr($file, 0, 1) != '.'
                        && is_readable(str_replace('//', '/', ($concat.'/config.ini')))) {
                    
                    $plugins[] = $concat;
                }
            }        
        }
        
        return $plugins;
    }

	/**
	 * Erfurt_PluginManager::_includeFolders()
	 * include all folders used by submitted plugin to PHP include dir
	 *
	 * @param String    $namespace  plugin's "namespace" 
 	 *
 	 * @return Bool
 	 *      o true: successfully included to PHP include path
 	 *      o false: no success
 	 *
 	 * @access private
 	 */
    private function _includeFolders($namespace) {
        
        if (isset($this->_pluginFolders[$namespace])) {
            
            $folders = array_diff($this->_pluginFolders[$namespace], $this->_included);
            
            if (count($folders) > 0) {
            
                # add folders to include path
                if (set_include_path(rtrim(get_include_path(),PATH_SEPARATOR) . PATH_SEPARATOR . implode(PATH_SEPARATOR,$folders)) !== false) {
                    # include worked
                    unset($this->_pluginFolders[$namespace]);
                    $this->_included = array_merge($this->_included,$folders); # add folders to included folders
                    return true;
                }
                else {
                    # not included
                    return false;
                }
            
            }
            else {
                return true;
            }
            
        }
        else {
            return true;
        }
        
    }
    
    /* magic methods,
       see http://de3.php.net/manual/en/language.oop5.overloading.php */
    
    public function __get($v)
    {
        if (isset($this->_vars[$v])) {
            return $this->_vars[$v];
        } else {
            return null;
        }
    }

    public function __set($vName, $vValue)
    {
        $this->_vars[$vName] = $vValue;
        if (isset($this->_vars[$vName]) && $this->_vars[$vName] === $vValue) {
            return $this->_vars[$vName];
        } else {
            return false;
        }
    }

    public function __isset($v)
    {
        return isset($this->_vars[$v]);
    }

    public function __unset($v)
    {
        unset($this->_vars[$v]);
    }
}

?>
