<?php

/**
  * Abstract base class for all Erfurt widget plug-ins. 
  *
  * @package Plugin
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
	  * Protected constructor. You cannot instantiate this class.
	  */
	protected function __construct($elementName = null, $values = null, $widgetConfig = null, $scripts = null, $styles = null) {
		$config = Zend_Registry::get('config');
		
		// call plug-in constructor
		parent::__construct();
		$this->_widgetBaseDir = ERFURT_BASE . $config->widgetDir;
		$this->_widgetBaseUrl = $config->erfurtUrlBase . $config->widgetDir;
		
		if ($elementName) {
			$this->_elementName = $elementName;
		} else {
			$this->_elementName = '';
		}
		if (!$values) {
			$values = '';
		}
		
		// values are generally handles as an array
		// even single values should be arrays
		if (is_array($values)) {
			$this->_values = $values;
		} else {
			$this->_values = array($values);
		}
		// set passed config
		if (is_array($widgetConfig)) {
			$this->_config = $widgetConfig;
		}
		// set passed scripts
		if (is_array($scripts)) {
			$this->_scripts = $scripts;
		} elseif (is_string($scripts)) {
			$this->_scripts[] = $scripts;
		}
		// set passed stylesheets
		if (is_array($styles)) {
			$this->_styles = $styles;
		} elseif (is_string($styles)) {
			$this->_styles[] = $styles;
		}
		if ($this->_config['cardinality'] == 1) {
			$this->_config['cardinalityMin'] = 1;
			$this->_config['cardinalityMax'] = 1;
		}
		// set passed id attribute (used to propagate
		// an id to subwidgets)
		if (isset($this->_config['cssId'])) {
			$this->_id = $this->_config['cssId'];
		} else {
			$this->_id = uniqid();
		}
	}
	
	/**
	  * Returns a string with the widget's rendered HTML code.
	  *
	  * @return string
	  */
	public function __toString() {
		if (isset($this->_config['start'])) {
			$count = $this->_config['start'] - 1;
			$id = $this->_id . $this->_config['start'];
			$withContainer = true;
		} else {
			$count = 0;
			$id = $this->_id;
			$withContainer = true;
		}
		if (isset($this->_config['display'])) {
			$displayOption = ' style="display:' . $this->_config['display'] . '"';
		} else {
			$displayOption = '';
		}
		if (isset($this->_config['container'])) {
			$container = $this->_config['container'];
		} else {
			$container = 'container';
		}
		if ($withContainer) {
			$ret = '<div id="' . $container . '-' . $id . '" class="' . $this->_config['class'] . '"' . $displayOption . '>' . PHP_EOL;
		}
		foreach ($this->_values as $value) {
			$ret .= $this->getSingleValueHtml($value, ++$count);
		}
		if (empty($this->_config['cardinalityMax']) || $this->_config['cardinalityMax'] > $count) {
			// $ret .= '<a href="javascript:ow.getEmptyHtml(\'' . $this->_id . '\',\'' . get_class($this) . '\')" title="Add a value">
			// 	<img src="" alt="+"/></a>' . PHP_EOL;
			$ret .= '<input type="hidden" id="count-' . $id . '" value="' . $count . '" />' . PHP_EOL;
		}
		if ($withContainer) {
			$ret .= '</div>' . PHP_EOL;
		}
		
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
	
	/**
	  * Returns an array of scripts needed by this widget. You don't
	  * need to overwrite this method. Just set the $_scripts member
	  * in your widget class's constructor accordingly. 
	  * To get the basis URL you can use the $_widgetBaseUrl member.
	  *
	  * @return array An array of js script URLs.
	  */
	public function getScripts() {
		return $this->_scripts;
	}
	
	/**
	  * Returns an array of stylesheets used by this widget. You don't
	  * need to overwrite this method. Just set the $_styles member
	  * in your widget class's constructor accordingly. 
	  * To get the basis URL you can use the $_widgetBaseUrl member.
	  *
	  * @return array An array of cs sheet URLs
	  */
	public function getStylesheets() {
		return $this->_styles;
	}
	
	/**
	  * Returns an array of datatype URIs this widget preferes to handle.
	  * Overwrite this method, if your widget has preferred data types.
	  *
	  * @return array|string An array of data type URIs or a single data type URI 
	  *         (e.g. <code>http://www.w3.org/2001/XMLSchema#date</code>)
	  */
	public static function getPreferredDatatypes() {
		return null;
	}
	
	/**
	  * Returns an array of properties this widget prefers to handle.
	  * Overwrite this method, if your widget has preferred properties.
	  *
	  * @return array An associative array of the form 'class URI' => 'property URI'
	  *         or an array of property URIs.
	  */
	public static function getPreferredProperties() {
		return null;
	}
	
}

?>