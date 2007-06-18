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
	protected function __construct($elementName, $values, $widgetConfig = null, $scripts = null, $styles = null) {
		$config = Zend_Registry::get('config');
		
		parent::__construct();
		$this->_widgetBaseDir = ERFURT_BASE . $this->_config->widgetDir;
		$this->_widgetBaseUrl = $config->erfurtUrlBase . $config->widgetDir;
		
		$this->_id = uniqid();
		$this->_elementName = $elementName;
		if (is_array($values)) {
			$this->_values = $values;
		} else {
			$this->_values = array($values);
		}
		if (is_array($widgetConfig)) {
			$this->_config = $widgetConfig;
		}
		if (is_array($scripts)) {
			$this->_scripts = $scripts;
		} elseif (is_string($scripts)) {
			$this->_scripts[] = $scripts;
		}
		if (is_array($styles)) {
			$this->_styles = $styles;
		} elseif (is_string($styles)) {
			$this->_styles[] = $styles;
		}
	}
	
	public function __toString() {
		$count = 1;
		$ret = '<div id="container-' . $this->_id . '" class="' . $this->_config['class'] . '">' . PHP_EOL;
		foreach ($this->_values as $value) {
			$ret .= $this->getSingleValueHtml($value, $count++);
		}
		$ret .= '</div>' . PHP_EOL;
		
		return $ret;
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
	
	// overwrite this, if your widget has preferred data types!
	public static function getPreferredDatatypes() {
		return null;
	}
	
	// overwrite this, if your widget has preferred properties!
	public static function getPreferredProperties() {
		return null;
	}
	
}

?>