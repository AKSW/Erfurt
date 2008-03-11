<?php
/**
 * Erfurt Plugin
 *
 * Base class for Erfurt plugins:
 * class YourErfurtPluginClass extends Erfurt_Plugin {}
 *
 * @package plugin
 * @package erfurt
 * @author  Michael Haschke
 * @version $Id:$
 */
class Erfurt_Plugin {

    protected $_erfurtApp = null;
    protected $_eventDispatcher = null;
    protected $_pluginManager = null;
    protected $_pluginConfig = null;

    public function __construct($erfurtobject, $config) {
        $this->_pluginConfig = $config;
        $this->_initPlugin($erfurtobject);

        return;
    }

    protected function _initPlugin($erfurtobject) {
        $this->_erfurtApp = $erfurtobject;
        $this->_pluginManager = $this->_erfurtApp->getPluginManager();
        $this->_eventDispatcher = $this->_erfurtApp->getEventDispatcher();
        return;
    }
    
    protected function _getPluginRootDir() {
        return rtrim($this->_pluginManager->getPluginRoot(get_class($this)),DIRECTORY_SEPARATOR);
    }
    
    protected function _getPluginConfig() {
        
        return $this->_pluginConfig;
    }

}
?>
