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
	  * @var An array of required onload actions.
	  */
	protected $requiredOnLoadActions;
	
	/**
	  * @var The Erfurt_Plugin_Manager instance used.
	  */
	protected $pluginManager;
	
	/**
	  * @var The singleton instance.
	  */
	protected static $instance = null;
	
	/**
	  * @var An array of property URIs for which the LiteralEdit widget should be used.
	  * Only RDF and RDFS properties need to be set here, since OWL propeties are either 
	  * defnied as DatatypeProperties or ObjectProperties taking care of selecting the 
	  * correct widget.
	  */
	protected $literalProperties = array(
		'http://www.w3.org/2000/01/rdf-schema#label', 
		'http://www.w3.org/2000/01/rdf-schema#comment'
	);
	
	/**
	  * @var An array of property URIs for which the ResourceEdit widget should be used.
	  * Only RDF and RDFS properties need to be set here, since OWL propeties are either 
	  * defnied as DatatypeProperties or ObjectProperties taking care of selecting the 
	  * correct widget.
	  */
	protected $resourceProperties = array(
		'http://www.w3.org/1999/02/22-rdf-syntax-ns#type', 
		'http://www.w3.org/2000/01/rdf-schema#domain', 
		'http://www.w3.org/2000/01/rdf-schema#range', 
		'http://www.w3.org/2000/01/rdf-schema#subClassOf', 
		'http://www.w3.org/2000/01/rdf-schema#subPropertyOf'
	);
	
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
		$this->requiredOnLoadActions = array();
		
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
		if ($widgetClass = $this->_getWidgetClass($class, $property, $elementName, $value, $config)) {
			$config['modelUri'] = $property->getModel()->modelURI;
			$config['propertyUri'] = $property->getUri();
			
			$widget = new $widgetClass($elementName, $value, $config);
			
			$return = $widget->__toString();
			
			if ($onLoad = $widget->getOnLoadCode()) {
				$this->requiredOnLoadActions[] = $onLoad;
			}
			return $return;
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
	  * Returns an array of required scripts of all active widgets.
	  */
	public function getRequiredOnLoadActions() {
		return $this->requiredOnLoadActions;
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
		
		// widget inference based on property
		if (is_object($property)) {
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

			$propUri = $property->getURI();

			// check pre-configured literal properties
			if (in_array($propUri, $this->literalProperties)) {
				return 'LiteralEdit';
			}

			// check pre-configured resource properties
			if (in_array($propUri, $this->resourceProperties)) {
				return 'ResourceEdit';
			}

			// check owl properties
			if ($property instanceof OWLProperty) {
				if ($property->isObjectProperty()) {
					return 'ResourceEdit';
				} elseif ($property->isDatatypeProperty()) {
					return 'LiteralEdit';
				}
			}
		}
		
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
