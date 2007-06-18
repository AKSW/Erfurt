<?php

/**
  * Abstract base class for all Erfurt plug-ins. 
  *
  * @package Erfurt
  * @subpackage Plugin
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
abstract class Erfurt_Plugin {
	
	protected $_types;
	
	protected $_pluginBaseUrl;
	
	protected $_pluginBaseDir;
	
	protected function __construct() {
		$config = Zend_Registry::get('config');
		$this->_types = Zend_Registry::get('datatypes');
		$this->_pluginBaseUrl = $config->erfurtPublicUri . $config->pluginDir;
	}
	
}

?>