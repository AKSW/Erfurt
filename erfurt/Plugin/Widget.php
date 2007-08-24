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
	protected $widgetBaseUrl;
	
	/**
	  * @var File system reference to the widget base directory
	  */
	protected $widgetBaseDir;
	
	/**
	  * @var A unique id for this widget
	  */
	protected $id;
	
	/**
	  * @var The form element's name attribute
	  */
	protected $elementName;
	
	/**
	  * @var Array of values
	  */
	protected $values;
	
	/**
	  * @var Array of configuration values
	  */
	protected $config = array(
		// TODO: default configuration values
		'cardinality' => 1, 
		);
	
	/**
	  * @var Array of script URLs this widget requires
	  */
	protected $scripts;
	
	/**
	  * @var Array of style sheet URLs this widget requires
	  */
	protected $styles;
	
	/**
	  * @var JavScript code to be executed on page load
	  */
	protected $onLoadCode;
	
	/**
	  * Protected constructor. You cannot instantiate this class.
	  */
	protected function __construct($elementName = null, $values = null, $widgetConfig = null, $scripts = null, $styles = null) {
		$config = Zend_Registry::get('config');
		
		// call plug-in constructor
		parent::__construct();
		$this->widgetBaseDir = ERFURT_BASE . $config->widgetDir;
		$this->widgetBaseUrl = $config->erfurtUrlBase . $config->widgetDir;
		
		if ($elementName) {
			$this->elementName = $elementName;
		} else {
			$this->elementName = '';
		}
		if (!$values) {
			$values = '';
		}
		
		$this->onLoadCode = null;
		
		// values are generally handled as an array
		// even single values should be arrays
		if (is_array($values)) {
			$this->values = $values;
		} else {
			$this->values = array($values);
		}
		// set passed config
		if (is_array($widgetConfig)) {
			$this->config = $widgetConfig;
		}
		// set passed scripts
		if (is_array($scripts)) {
			$this->scripts = $scripts;
		} elseif (is_string($scripts)) {
			$this->scripts[] = $scripts;
		}
		// set passed stylesheets
		if (is_array($styles)) {
			$this->styles = $styles;
		} elseif (is_string($styles)) {
			$this->styles[] = $styles;
		}
		if (isset($this->config['cardinality']) && $this->config['cardinality'] == 1) {
			$this->config['cardinalityMin'] = 1;
			$this->config['cardinalityMax'] = 1;
		}
		// set passed id attribute (used to propagate
		// an id to subwidgets)
		if (isset($this->config['cssId'])) {
			$this->id = $this->config['cssId'];
		} else {
			$this->id = uniqid();
		}
	}
	
	/**
	  *
	  * @return string
	  */
	public abstract function getSingleValueHtml();
	
	/**
	  * Returns a string with the widget's rendered HTML code.
	  *
	  * @return string
	  */
	public function __toString() {
		if (isset($this->config['start'])) {
			$count = $this->config['start'] - 1;
			$id = $this->id . $this->config['start'];
			$withContainer = true;
		} else {
			$count = 0;
			$id = $this->id;
			$withContainer = true;
		}
		if (!empty($this->config['display'])) {
			$displayOption = ' style="display:' . $this->config['display'] . '"';
		} else {
			$displayOption = '';
		}
		if (isset($this->config['container'])) {
			$container = $this->config['container'];
		} else {
			$container = 'container';
		}
		if ($withContainer) {
			$ret = '<div id="' . $container . '-' . $id . '" class="' . $this->config['class'] . '"' . $displayOption . '>' . PHP_EOL;
		}
		$ret .= '<input type="hidden" id="model-' . $this->id . '" value="' . $this->config['modelUri'] . '" />' . PHP_EOL;
		$ret .= '<input type="hidden" id="property-' . $this->id . '" value="' . $this->config['propertyUri'] . '" />' . PHP_EOL;
		foreach ($this->values as $value) {
			$ret .= $this->getSingleValueHtml($value, ++$count);
		}
		if ($withContainer) {
			$ret .= '</div>' . PHP_EOL;
		}
		if (empty($this->config['cardinalityMax']) || $this->config['cardinalityMax'] > $count) {
			$ret .= '<a href="javascript:getEmptyHtml(this,\'' . $this->id . '\',\''.$container . '-' . $id.'\',\'' . get_class($this) . '\')"' . 
					  ' title="Add a value"><img src="' . $this->publicUri . 'images/plus_big.png" alt="+"/></a>' . PHP_EOL;
			$ret .= '<input type="hidden" id="count-' . $id . '" value="' . $count . '" />' . PHP_EOL;
			$ret .= '<input type="hidden" id="name-' . $id . '" value="' . $this->elementName . '" />' . PHP_EOL;
		}
		
		return $ret;
	}
	
	/**
	  * Default getter method for config values
	  */
	public function __get($var) {
		if (in_array($var, $this->config)) {
			return $this->config[$var];
		} else {
			return null;
		}
	}
	
	/**
	  * Returns an array of scripts needed by this widget. You don't
	  * need to overwrite this method. Just set the $scripts member
	  * in your widget class's constructor accordingly. 
	  * To get the basis URL you can use the $widgetBaseUrl member.
	  *
	  * @return array An array of js script URLs.
	  */
	public function getScripts() {
		return $this->scripts;
	}
	
	/**
	  * Returns an array of stylesheets used by this widget. You don't
	  * need to overwrite this method. Just set the $styles member
	  * in your widget class's constructor accordingly. 
	  * To get the basis URL you can use the $widgetBaseUrl member.
	  *
	  * @return array An array of cs sheet URLs
	  */
	public function getStylesheets() {
		return $this->styles;
	}
	
	/**
	  * Returns an array of stylesheets used by this widget. You don't
	  * need to overwrite this method. Just set the $styles member
	  * in your widget class's constructor accordingly. 
	  * To get the basis URL you can use the $widgetBaseUrl member.
	  *
	  * @return array An array of cs sheet URLs
	  */
	public function getOnLoadCode() {
		return $this->onLoadCode;
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
