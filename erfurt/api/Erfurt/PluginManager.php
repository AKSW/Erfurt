<?php
/**
 * Erfurt Plugin Manager
 *
 * 
 *
 * @package erfurt
 * @author  Michael Haschke
 * @version $Id: PluginManager.php 1638 2007-11-13 19:53:20Z p_frischmuth $
 */
class Erfurt_PluginManager {
    
    private $_pluginFolders = array(); # all directories where plugin files and classes may be located
    private $_classRelations = array();
    private $_included = array();
    private $_prepared = array();
    private $_erfurt = null;
    private $_ed = null;
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
            $this->_classRelations = array();
            $this->_included = array();
            $this->_prepared = array();
        }
    
        # add folder to include path
        # set_include_path(get_include_path() . PATH_SEPARATOR . $folder);
        
        # load plugin configurations
        $this->_loadConfigurations($folder);
        
        return true;
        
    }
    
	/**
	 * Erfurt_PluginManager::prepare()
	 * prepare system environment for usage of class:method from a plugin
	 *
	 * @param String    $classMethod  name of method in class (classname::methodname)
 	 *
 	 * @return Bool|Null
 	 *      o true: success
 	 *      o false: preparation failed
 	 *      o null: preparation was already tried before
 	 *
 	 * @access public
 	 */
    public function prepare($classMethod) {
    
        if (isset($this->_classRelations[$classMethod])) {      # search for related namespace
            $namespace = $this->_classRelations[$classMethod];
            if ($this->_includeFolders($namespace)) {           # include folders related to namespace
                $this->_prepared[$classMethod] = true;              # mark class::method as prepared
                unset($this->_classRelations[$classMethod]);        # delete relation to namespace
                return true;
            }
            else {
                return false;
            }
        }
        elseif (isset($this->_prepared[$classMethod])) {
            return null;
        }
        else {
            return false;
        }
    
    }
    
    private function _loadConfigurations($folder) {
    
        # get list of all active plugins
        $plugins = $this->_listActivePlugins($folder);
        
        foreach ($plugins as $plugin) {
            # get plugin configuration from ini file
            $pluginConfig = new Zend_Config_Ini($plugin.'.ini','general');
            
            if ($pluginConfig->get('switch') == 'on') { # do for active plugins

                # filename as namespace
                $namespace = $plugin;
                
                # root folder for plugin
                $pluginRoot = dirname($plugin) . '/';
                
                # read plugin folders
                $pluginFolders = array();
                if ($pluginConfig->get('folder') !== null) {
                    $tempPluginFolders = $pluginConfig->folder->toArray();
                    foreach ($tempPluginFolders as $folderKey => $folderValue) {
                        $pluginFolders[$folderKey] = realpath($pluginRoot.$folderValue);
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
                                $this->_classRelations[$class.'::'.$method] = $namespace;
                                
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
                                $this->_classRelations[$class.'::'.$method] = $namespace;
                                
                            }
                    }
                }
            
            }
            
        }
        
        return true;
    }
    
    private function _listActivePlugins($folder) {
    
        # next version: plugins are marked as active in erfurt/ontowiki configuration
        # this version: all plugins in plugin folder are active
        
        return $this->_listPluginsFromFolder($folder);
    }

    private function _listPluginsFromFolder($folder, $plugins = array()) {

        # run through folder and look for *.ini
        # save absolute dir + filename (without .ini)
        
        if (file_exists($folder) && is_dir($folder) && $fileHandler = opendir($folder)) {
            # folder exists and can be opened
            
            while (($file = readdir($fileHandler)) !== false) {
            
                $concat = str_replace('//','/',$folder.'/'.$file);
            
                # read dir item by item and check type
                if (is_dir($concat) && $file != '.' && $file != '..') {
                    # is folder
                    $plugins = $this->_listPluginsFromFolder($concat,$plugins);
                }
                elseif (is_readable($concat) && substr($file,-4) == '.ini') {
                    # is readable ini file
                    $plugins[] = substr($concat,0,-4);
                }
            }        
        }
        
        return $plugins;
    }

    private function _includeFolders($namespace) {
        
        if (isset($this->_pluginFolders[$namespace])) {
            
            $folders = array_diff($this->_pluginFolders[$namespace], $this->_included);
            
            if (count($folders) > 0) {
            
                # add folders to include path
                if (set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR,$folders)) !== false) {
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
