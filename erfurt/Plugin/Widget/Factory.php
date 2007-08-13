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
	protected $datatypePreferences;
	
	/**
	  * @var An array () TODO
	  */
	protected $propertyPreferences;
	
	/**
	  * @var An array of required scripts.
	  */
	protected $requiredScripts;
	
	/**
	  * @var An array of required stylesheets.
	  */
	protected $requiredStylesheets;
	
	/**
	  * @var The Erfurt_Plugin_Manager instance used.
	  */
	protected $pluginManager;
	
	/**
	  * @var The singleton instance.
	  */
	protected static $instance = null;
	
	/**
	  * 
	  *
	  * @return An instance of Erfurt_Plugin_Widget_Factory
	  */
	public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
	}
	
	/**
	  * Private constructor, singleton instance.
	  * Use Erfurt_Plugin_Widget_Factory::getInstance() to retrieve an instance.
	  */
	private function __construct() {
		$config = Zend_Registry::get('config');
		
		$this->datatypePreferences = array();
		$this->propertyPreferences = array();
		$this->requiredScripts = array($config->erfurtPublicUri . 'js/widget.js');
		$this->requiredStylesheets = array();
		
		$this->pluginManager = Zend_Registry::get('pluginManager');
		
		// TODO: collisions?
		foreach ($this->pluginManager->getActivePlugins() as $widget) {
			// check preferred data types
			$dtypes = call_user_func(array($widget, 'getPreferredDatatypes'));
			if (is_array($dtypes)) {
				// TODO: array
			} elseif (is_string($dtypes)) {
				$this->datatypePreferences[$dtypes] = $widget;
			}
			// foreach ($dtypes as $datatype) {
				// if (is_array($datatype)) {
				// 	foreach ($datatypes as $dt) {
				// 		$this->datatypePreferences[$dt] = $widget;
				// 	}
				// } else {
				// 	$this->datatypePreferences[$datatype] = $widget;
				// }
			// }
			// // check preferred properties
			// foreach ($widget->getPreferredProperties() as $property) {
			// 	if (is_array($property)) {
			// 		foreach ($property as $prop) {
			// 			$this->propertyPreferences[$prop] = $widget;
			// 		}
			// 	} else {
			// 		$this->propertyPreferences[$proprty] = $widget;
			// 	}
			// }
			
			$widgetObject = new $widget();
			// collect required scripts
			if ($scripts = $widgetObject->getScripts()) {
				foreach ($scripts as $script) {
					if (!in_array($script, $this->requiredScripts)) {
						$this->requiredScripts[] = $script;
					}
				}
			}
			// collect required stylesheets
			if ($stylesheets = $widgetObject->getStylesheets()) {
				foreach ($stylesheets as $stylesheet) {
					if (!in_array($stylesheet, $this->requiredStylesheets)) {
						$this->requiredStylesheets[] = $stylesheet;
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
			$elementName = $config['name'] . '[' . $property->getURI() . ']';
		} else {
			$elementName = 'prop[' . $property->getURI() . ']';
		}
		if ($widgetClass = $this->_getWidgetClass($class, $property, $elementName, $value, &$config)) {
			if ($widgetClass == 'ResourceEdit' || $widgetClass == 'NodeEdit') {
				$config['modelUri'] = $property->getModel()->modelURI;
			}
			$widget = new $widgetClass($elementName, $value, $config);
			return $widget;
		}
	}
	
	/**
	  * Returns an array of required scripts of all active widgets.
	  */
	public function getRequiredScripts() {
		return $this->requiredScripts;
	}
	
	/**
	  * Returns an array of required stylesheets of all active widgets.
	  */
	public function getRequiredStylesheets() {
		return $this->requiredStylesheets;
	}
	
	/**
	  * Returns a widget class name for a given combination of class, property and value.
	  */
	private function _getWidgetClass($class, $property, $elementName, $value, &$config) {
		$log = Zend_Registry::get('erfurtLog');
		
		// get datatype of literal value (if any)
		if (is_array($value) && $first = array_shift($value)) {
			if ($first instanceof Literal) {
				$literalDatatype = $first->getDatatype();
			}
		} elseif ($value instanceof Literal) {
			$literalDatatype = $value->getDatatype();
		} else {
			$first = $value;
		}
		// return widget for datatype
		if (in_array($literalDatatype, array_keys($this->datatypePreferences))) {
			if ($this->pluginManager->isPluginActive($this->datatypePreferences[$literalDatatype])) {
				return $this->datatypePreferences[$literalDatatype];
			}
		}
		
		// TODO: check preferred class/property combinations or properties only
		
		// check value types
		if (($first instanceof Resource) || (is_string($first) && Erfurt_Util::isUri($first))) {
			return 'ResourceEdit';
		} /*elseif ($first instanceof Literal) {
			$config['dtype'] = $first->getDatatype();
			return 'LiteralEdit';
		}*/
		
		// check range
		if ($range = $property->getRange()) {
			$rangeUri = $range->getURI();
			if (in_array($rangeUri, array_keys($GLOBALS['datatypes']))) {
				if ($this->pluginManager->isPluginActive($this->datatypePreferences[$rangeUri])) {
					return $this->datatypePreferences[$rangeUri];
				} else {
					// set range as datatype for literal widget
					$config['dtype'] = $GLOBALS['datatypes'][$rangeUri];
					return 'LiteralEdit';
				}
			} else {
				// not a datatype, we assume resource
				return 'ResourceEdit';
			}
		}
		
		// check owl properties
		if ($property instanceof OWLProperty) {
			if ($property->isObjectProperty()) {
				return 'ResourceEdit';
			} elseif ($property->isDatatypeProperty()) {
				return 'LiteralEdit';
			}
		}
		
		// // check for rdfs properties
		// if ($property instanceof RDFSProperty) {
		// 	$range = $property->getRange();
		// 	if ($range instanceof RDFSResource) {
		// 		// echo $property->getRange()->getURI();
		// 		echo in_array($range->getURI(), array_keys($GLOBALS['datatypes']));
		// 		return 'ResourceEdit';
		// 	} elseif ($range instanceof RDFSLiteral) {
		// 		return 'LiteralEdit';
		// 	} else {
		// 		return 'NodeEdit';
		// 	}
		// }
		
		// fallback
		$log->info(__CLASS__ . ': no suitable widget found. Falling back to NodeEdit.');
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
