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

    public function __construct($erfurtobject) {
        $this->_initPlugin($erfurtobject);
        return;
    }

    protected function _initPlugin($erfurtobject) {
        $this->_erfurtApp = $erfurtobject;
        $this->_pluginManager = $this->_erfurtApp->getPluginManager();
        $this->_eventDispatcher = $this->_erfurtApp->getEventDispatcher();
        return;
    }
    
    protected function _getRootdir() {
        return $this->_pluginManager->getPluginRoot(get_class($this));
    }

}
?>
