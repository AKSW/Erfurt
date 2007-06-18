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
	
	protected $_propertyPreferences;
	
	protected $_requiredScripts;
	
	protected $_requiredStylesheets;
	
	protected $_pluginManager;
	
	public function __construct() {
		$this->_datatypePreferences = array();
		$this->_propertyPreferences = array();
		$this->_requiredScripts = array();
		$this->_requiredStylesheets = array();
		
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
		}
	}
	
	public function getWidgetHtml($class, $property, $value, $config) {
		if (isset($config['name'])) {
			$elementName = $config['name'];
		} else {
			$elementName = 'prop[' . $property->getURI() . ']';
		}
		if ($widgetClass = $this->_getWidgetClass($class, $property, $elementName, $value, $config)) {
			$widget = new $widgetClass($elementName, $value);
			if ($scripts = $widget->getScripts()) {
				foreach ($scripts as $script) {
					if (!in_array($script, $this->_requiredScripts)) {
						$this->_requiredScripts[] = $script;
					}
				}
			}
			if ($stylesheets = $widget->getStylesheets()) {
				foreach ($stylesheets as $stylesheet) {
					if (!in_array($stylesheet, $this->_requiredStylesheets)) {
						$this->_requiredStylesheets[] = $stylesheet;
					}
				}
			}
			return $widget;
		}
	}
	
	public function getRequiredScripts() {
		return $this->_requiredScripts;
	}
	
	public function getRequiredStylesheets() {
		return $this->_requiredStylesheets;
	}
	
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
		return null;
	}
	
	private function _configureWidget($widgetClass) {
		// TODO:
	}
}

?>
