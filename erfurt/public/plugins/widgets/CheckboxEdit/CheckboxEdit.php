<?php

/**
  * Erfurt checkbox edit widget
  *
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class CheckboxEdit extends Erfurt_Plugin_Widget {
	
	protected $_options;
	
	protected $_selected;
	
	public function __construct($elementName = null, $selected = null, $options = null, $config = array()) {
		parent::__construct($elementName, $options, $config);
		
		$this->_options = $options;
		$this->_selected = $selected;
		
		$this->_config['class'] = 'CheckboxEditContainer';
		
		$this->_styles[] = $this->_widgetBaseUrl . 'CheckboxEdit/checkbox_edit.css';
	}
	
	public function __toString() {
		$count = 0;
		$ret = '<div id="container-' . $this->_id . '" class="' . $this->_config['class'] . '">' . PHP_EOL;
		foreach ($this->_options as $key => $value) {
			$ret .= $this->getSingleValueHtml($value, $key, ++$count);
		}
		$ret .= '</div>' . PHP_EOL;
		
		return $ret;
	}
	
	public function getSingleValueHtml($literal, $key, $num = 1) {		
		if ($literal instanceof Literal) {
			$value = $literal->getLabel();
			$lang = $literal->getLanguage() ? $literal->getLanguage() : 'Lang';
			$dtype = $literal->getDatatype();
		} else {
			$value = $literal;
			$lang = 'Lang';
			$dtype = 'http://www.w3.org/2001/XMLSchema#boolean';
		}
		
		// if (!($key instanceof RDFSLiteral)) {
		// 	$key = new RDFSLiteral($key);
		// 	$keyVal = $key->getLabel();
		// }
		
		if (empty($this->_config['cardinalityMax']) || $this->_config['cardinalityMax'] > 1 || count($this->_options) === 1) {
			$type = 'checkbox';
		} else {
			$type = 'radio';
		}
		$ret = '<input type="' . $type . '" name="' . $this->_elementName . '" value="' . $key . '" id="option-' . $this->_id . $num . '"';
		if ($this->_selected == $key || (is_array($this->_selected) && in_array($key, $this->_selected))) {
			$ret .= ' checked="checked"';
		}
		$ret .= ' class="CheckboxEditValue"';
		if ($this->_config['onchange']) {
			$ret .= ' onchange="' . $this->_config['onchange'] . '"';
		}
		$ret .= '>';
		if (($value != '1') && ($value != 'true')) {
			$ret .= '<label for="option-' . $this->_id . $num . '" class="CheckboxEditLabel">' . $value . '</label>' . PHP_EOL;
		}
		$ret .= '</input>&nbsp;' . PHP_EOL;
		
		return $ret;
	}
	
	public static function getPreferredDatatypes() {
		return 'http://www.w3.org/2001/XMLSchema#boolean';
	}
}

?>
