<?php

/*
 * PluginManager.php
 * Encoding: utf-8
 *
 * Copyright (c) 2007, OntoWiki project team
 *
 * This file is part of OntoWiki.
 *
 * OntoWiki is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * OntoWiki is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OntoWiki; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
  * Erfurt Plugin Manager
  *
  * 
  *
  * @package: Erfurt
  * @author:  Michael Haschke
  * @version: $Id: EventHandler.php 1638 2007-11-13 19:53:20Z p_frischmuth $
  * @access: public
  */
class Erfurt_PluginManager {
    
    private $_pluginFolders = array(); # all directories where plugin files and classes may be located
    private $_classRelations = array();
    private $_included = array();
    private $_prepared = array();
    private $_erfurt = null;
    private $_eh = null;

    public function __construct($o) {
    
        $this->_erfurt = $o;
        $this->_eh = $o->getEventHandler();
    
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
                                $this->_eh->announce($event,$class.'::'.$method);
                                
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
    
}

class PluginTriggerZendEvents extends Zend_Controller_Plugin_Abstract {

    private $_eh = null;
    private $_request = null;

    function __construct(Erfurt_EventHandler $eh) {
        $this->_eh = $eh;
    }

    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
        $this->_eh->trigger('ZendRoutStartup',$this);
        $this->_eh->trigger('ZendRoutStartup_'.$request->getModuleName().'_'.$request->getControllerName().'_'.$request->getActionName(),$this);
    }

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
        $this->_eh->trigger('ZendRoutShutdown',$this);
        $this->_eh->trigger('ZendRoutShutdown_'.$request->getModuleName().'_'.$request->getControllerName().'_'.$request->getActionName(),$this);
    }

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
        $this->_eh->trigger('ZendDispatchLoopStartup',$this);
        $this->_eh->trigger('ZendDispatchLoopStartup_'.$request->getModuleName().'_'.$request->getControllerName().'_'.$request->getActionName(),$this);
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
        $this->_eh->trigger('ZendPreDispatch',$this);
        $this->_eh->trigger('ZendPreDispatch_'.$request->getModuleName().'_'.$request->getControllerName().'_'.$request->getActionName(),$this);
    }

    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
        $this->_eh->trigger('ZendPostDispatch',$this);
        $this->_eh->trigger('ZendPostDispatch_'.$request->getModuleName().'_'.$request->getControllerName().'_'.$request->getActionName(),$this);
    }

    public function dispatchLoopShutdown()
    {
        $this->_eh->trigger('ZendDispatchLoopShutdown',$this);
    }

}

?>
