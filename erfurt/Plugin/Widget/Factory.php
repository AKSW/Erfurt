<?php

/**
  * Erfurt widget factory
  *
  * @package Plugin
  * @subpackage Widget
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class Erfurt_Plugin_Widget_Factory {
	
	/**
	  * @var Array(property uri => widget class) of preferences
	  */
	protected $_datatypePreferences;
	
	/**
	  * @var An array () TODO
	  */
	protected $_propertyPreferences;
	
	/**
	  * @var An array of required scripts.
	  */
	protected $_requiredScripts;
	
	/**
	  * @var An array of required stylesheets.
	  */
	protected $_requiredStylesheets;
	
	/**
	  * @var The Erfurt_Plugin_Manager instance used.
	  */
	protected $_pluginManager;
	
	/**
	  * @var The singleton instance.
	  */
	protected static $_instance = null;
	
	/**
	  * 
	  *
	  * @return An instance of Erfurt_Plugin_Widget_Factory
	  */
	public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
	}
	
	/**
	  * Private constructor, singleton instance.
	  * Use Erfurt_Plugin_Widget_Factory::getInstance() to retrieve an instance.
	  */
	private function __construct() {
		$this->_datatypePreferences = array();
		$this->_propertyPreferences = array();
		$this->_requiredScripts = array();
		$this->_requiredStylesheets = array();
		
		$config = Zend_Registry::get('config');
		
		$this->_pluginManager = Zend_Registry::get('pluginManager');
		
		// TODO: collisions?
		foreach ($this->_pluginManager->getActivePlugins() as $widget) {
			// check preferred data types
			$dtypes = call_user_func(array($widget, 'getPreferredDatatypes'));
			if (is_array($dtypes)) {
				// TODO: array
			} elseif (is_string($dtypes)) {
				$this->_datatypePreferences[$dtypes] = $widget;
			}
			// foreach ($dtypes as $datatype) {
				// if (is_array($datatype)) {
				// 	foreach ($datatypes as $dt) {
				// 		$this->_datatypePreferences[$dt] = $widget;
				// 	}
				// } else {
				// 	$this->_datatypePreferences[$datatype] = $widget;
				// }
			// }
			// // check preferred properties
			// foreach ($widget->getPreferredProperties() as $property) {
			// 	if (is_array($property)) {
			// 		foreach ($property as $prop) {
			// 			$this->_propertyPreferences[$prop] = $widget;
			// 		}
			// 	} else {
			// 		$this->_propertyPreferences[$proprty] = $widget;
			// 	}
			// }
			
			$widgetObject = new $widget();
			// collect required scripts
			if ($scripts = $widgetObject->getScripts()) {
				foreach ($scripts as $script) {
					if (!in_array($script, $this->_requiredScripts)) {
						$this->_requiredScripts[] = $script;
					}
				}
			}
			// collect required stylesheets
			if ($stylesheets = $widgetObject->getStylesheets()) {
				foreach ($stylesheets as $stylesheet) {
					if (!in_array($stylesheet, $this->_requiredStylesheets)) {
						$this->_requiredStylesheets[] = $stylesheet;
					}
				}
			}
		}
	}
	
	/**
	  * Selects a suitable widget and returns its HTML code with values, datatypes etc. set.
	  *
	  * @param RDFSClass $class 
	  * @param RDFSProperty $property 
	  * @param mixed $value An array of values or a single value
	  * @param $config An array of config values this widget interprets. $config gets merged
	  *        with the widget's default condiguration (if any).
	  */
	public function getWidgetHtml($class, $property, $value, $config) {
		if (isset($config['name'])) {
			$elementName = $config['name'];
		} else {
			$elementName = 'prop[' . $property->getURI() . ']';
		}
		if ($widgetClass = $this->_getWidgetClass($class, $property, $elementName, $value, $config)) {
			$widget = new $widgetClass($elementName, $value);
			return $widget;
		}
	}
	
	/**
	  * Returns an array of required scripts of all active widgets.
	  */
	public function getRequiredScripts() {
		return $this->_requiredScripts;
	}
	
	/**
	  * Returns an array of required stylesheets of all active widgets.
	  */
	public function getRequiredStylesheets() {
		return $this->_requiredStylesheets;
	}
	
	/**
	  * Returns a widget class name for a given combination of class, property and value.
	  */
	private function _getWidgetClass($class, $property, $elementName, $value, $config) {
		// get datatype of literal value (if any)
		if (is_array($value) && $first = array_shift($value)) {
			if ($first instanceof Literal) {
				$literalDatatype = $first->getDatatype();
			}
		} elseif ($value instanceof Literal) {
			$literalDatatype = $value->getDatatype();
		}
		// return widget for datatype
		if (in_array($literalDatatype, array_keys($this->_datatypePreferences))) {
			if ($this->_pluginManager->isPluginActive($this->_datatypePreferences[$literalDatatype])) {
				return $this->_datatypePreferences[$literalDatatype];
			}
		}
		// TODO: check preferred properties
		// check owl properties
		if ($property instanceof OWLProperty) {
			if ($property->isObjectProperty()) {
				return 'ResourceEdit';
			} elseif ($property->isDatatypeProperty()) {
				return 'LiteralEdit';
			}
		}
		
		// check value types
		if ($first instanceof Resource) {
			return 'ResourceEdit';
		} elseif ($first instanceof Literal) {
			return 'LiteralEdit';
		} elseif (is_string($value)) {
			return 'LiteralEdit';
		}
		
		// fallback
		return 'NodeEdit';
	}
	
	/**
	  * Sets the widget's configuration array according to values
	  * inferred from class, property and value.
	  */
	private function _configureWidget($widgetClass) {
		// TODO
	}
}

?>
