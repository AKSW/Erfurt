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
		
		$this->config['class'] = 'ResourceEditContainer';
		// $this->scripts[] = $this->widgetBaseUrl . 'ResourceEdit/resource_edit.js';
		$this->styles[] = $this->widgetBaseUrl . 'ResourceEdit/resource_edit.css';
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

		$name = $this->elementName . '[' . $num . ']';
		
		if (isset($this->config['nameMod'])) {
			$nameMod .= '[' . $this->config['nameMod'] . ']';
		} else {
			$nameMod = '';
		}
		
		// $ret  = '<div id="' . $this->id . $num . '-container" class="ResourceEditContainer">' . PHP_EOL;
		$ret .= '<input type="text" name="' . $name . $nameMod . '" class="ResourceEditValue" value="' . 
				$value . '" id="value-' . $this->id . $num . '" />' . PHP_EOL;
		// $ret .= '</div>' . PHP_EOL;
		
		return $ret;
	}
}

?>
