<?php

/**
  * Erfurt select widget
  *
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
// TODO: rename to Select
class SelectNew extends Erfurt_Plugin_Widget {
	
	/**
	  * @var currently selected item
	  */
	var $selected;
	
	public function __construct($elementName = null, $selected = null, $values = null, $config = array()) {
		$defaultConfig = array(
			'cardinalityMax' => 1, 
			'multi'          => false,
			'multiSize'      => 5,
			'emptyLabel'     => 'None'
		);
		parent::__construct($elementName, 
			                $values, 
							// config
							array_merge($defaultConfig, $config)
		);
		
		$this->selected = $selected;
	}
	
	public function __toString() {
		if (isset($this->config['start'])) {
			$count = $this->config['start'] - 1;
			$this->id = $this->id . $this->config['start'];
		} else {
			$count = 0;
		}
		if (empty($this->values[''])) {
			$this->values = array_merge(array('' => 'Datatype'), $this->values);
		}
		$ret = '<span id="select-container-' . $this->id . '"';
		if (!empty($this->config['class'])) {
			$ret .= ' class="' . $this->config['class'] . '">' . PHP_EOL;
		} else {
			$ret .= ' class="SelectNew">' . PHP_EOL;
		}
		$ret .= $this->getSingleValueHtml();
		$ret .= '</span>' . PHP_EOL;
		
		return $ret;
	}
	
	private function getSingleValueHtml() {
		
		$ret = '<select name="' . $this->elementName . '"';
		if (empty($this->config['cardinalityMax']) || $this->config['cardinalityMax'] > 1) {
			$ret .= ' multiple="multiple" size="' . $this->config['multiSize'] . '"';
		}
		if (!empty($this->config['onChange'])) {
			$ret .= ' onchange="' . $this->config['onChange'] . '"';
		}
		if (!empty($this->config['readOnly'])) {
			$ret .= ' disabled="disabled"';
		}
		if (!empty($this->config['class'])) {
			$ret .= ' class="' . $this->config['class'] . '"';
		} else {
			$ret .= ' class="SelectNew"';
		}
		$ret .= ' id="dtype-' . $this->id . '">' . PHP_EOL;
		
		foreach ($this->values as $key => $val) {
			if (is_int($key)) {
				$option = $val;
			} else {
				$option = $key;
			}
			$ret .= '<option value="' . $option . '"';
			if (
			    ($key === $this->selected)) {
				$ret .= ' selected="selected"';
			}
			$ret .= '>' . $val . '</option>' . PHP_EOL;
		}
		
		$ret .= '</select>' . PHP_EOL;
		
		return $ret;
	}
}

?>
