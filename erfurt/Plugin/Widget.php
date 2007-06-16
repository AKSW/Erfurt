<?php

/**
  * Abstract base class for all Erfurt widget plug-ins. 
  *
  * @package Erfurt
  * @subpackage Plugin
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
abstract class Erfurt_Plugin_Widget extends Erfurt_Plugin {
	
	/**
	  * @var URL reference to the widget base directory
	  */
	protected $_widgetBaseUrl;
	
	/**
	  * @var File system reference to the widget base directory
	  */
	protected $_widgetBaseDir;
	
	/**
	  * @var A unique id for this widget
	  */
	protected $_id;
	
	/**
	  * @var The form element's name attribute
	  */
	protected $_elementName;
	
	/**
	  * @var Array of values
	  */
	protected $_values;
	
	/**
	  * @var Array of configuration values
	  */
	protected $_config = array(
		// TODO: default configuration values
		'cardinality' => 1, 
		);
	
	/**
	  * @var Array of script URLs this widget requires
	  */
	protected $_scripts;
	
	/**
	  * @var Array of style sheet URLs this widget requires
	  */
	protected $_styles;
	
	/**
	  * Protected constructor -- not instantiable.
	  */
	protected function __construct($elementName, $values, $config = null, $scripts = null, $styles = null) {
		parent::__construct();
		$this->_widgetBaseUrl = $this->_pluginBaseUrl . 'widgets/';
		$this->_widgetBaseDir = $this->_pluginBaseDir . 'plugins/';
		$this->_id = uniqid();
		$this->_elementName = $elementName;
		if (is_array($values)) {
			$this->_values = $values;
		} else {
			$this->_values = array($values);
		}
		if (is_array($config)) {
			$this->_config = $config;
		}
		if (is_array($scripts)) {
			$this->_scripts = $scripts;
		}
		if (is_array($styles)) {
			$this->_styles = $styles;
		}
	}
	
	/**
	  * Default getter method for config values
	  */
	public function __get($var) {
		if (in_array($var, $this->_config)) {
			return $this->_config[$var];
		} else {
			return null;
		}
	}
	
	public function getScripts() {
		return $this->_scripts;
	}
	
	public function getStylesheets() {
		return $this->_styles;
	}
	
}

?>