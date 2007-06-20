<?php

/**
  * Erfurt resource edit widget
  *
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class ResourceEdit extends Erfurt_Plugin_Widget {
	
	public function __construct($elementName = null, $values = null, $config = array()) {
		parent::__construct($elementName, 
			                $values, 
							// config
							$config
		);
		
		$this->_config['class'] = 'ResourceEditContainer';
		// $this->_scripts[] = $this->_widgetBaseUrl . 'ResourceEdit/resource_edit.js';
		$this->_styles[] = $this->_widgetBaseUrl . 'ResourceEdit/resource_edit.css';
	}
	
	public function getSingleValueHtml($resource, $num = 1) {
		if ($resource instanceof Resource) {
			$value = $resource->getLocalName();
		// TODO: why check for Literal here???
		} elseif ($resource instanceof Literal) {
			$value = $resource->getLabel();
		} else {
			$value = $resource;
		}

		$name = $this->_elementName . '[' . $num . ']';
		
		if (isset($this->_config['nameMod'])) {
			$nameMod .= '[' . $this->_config['nameMod'] . ']';
		} else {
			$nameMod = '';
		}
		
		// $ret  = '<div id="' . $this->_id . $num . '-container" class="ResourceEditContainer">' . PHP_EOL;
		$ret .= '<input type="text" name="' . $name . $nameMod . '" class="ResourceEditValue" value="' . 
				$value . '" id="value-' . $this->_id . $num . '" />' . PHP_EOL;
		// $ret .= '</div>' . PHP_EOL;
		
		return $ret;
	}
}

?>
