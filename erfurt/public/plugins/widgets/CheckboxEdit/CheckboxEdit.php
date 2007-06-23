<?php

/**
  * Erfurt checkbox edit widget
  *
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class CheckboxEdit extends Erfurt_Plugin_Widget {
	
	/**
	  * @var Array of possible options as array($key => $value)
	  *      where value is displayed and key is the value sent.
	  */
	protected $options;
	
	/**
	  * @var Array of slected keys or one key
	  */
	protected $selected;
	
	public function __construct($elementName = null, $selected = null, $config = array()) {
		parent::__construct($elementName, $selected, $config);
		
		// make an array since
		// foreach is used later
		if (is_array($config['options'])) {
			$this->options = $config['options'];
		} else {
			$this->options = array($config['options'] => $config['options']);
		}
		
		if (is_array($selected)) {
			foreach ($selected as $sel) {
				if ($sel instanceof Literal) {
					$this->selected[] = $sel->getLabel();
				} elseif ($sel instanceof Resource) {
					$this->selected[] = $sel->getLocalName();
				} else {
					$this->selected[] = $sel;
				}
			}
		} else {
			$this->selected[] = $selected;
		}
		
		$this->config['class'] = 'CheckboxEditContainer';
		
		$this->styles[] = $this->widgetBaseUrl . 'CheckboxEdit/checkbox_edit.css';
	}
	
	public function __toString() {
		// print_r($this->options);
		// print_r($this->selected);
		$count = 0;
		$ret = '<div id="container-' . $this->id . '" class="' . $this->config['class'] . '">' . PHP_EOL;
		foreach ($this->options as $key => $value) {
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
			// $lang = 'Lang';
			// $dtype = isset($this->config['dtype']) ? $this->config['dtype'] : '';
		}
		
		if (empty($this->config['cardinalityMax']) || $this->config['cardinalityMax'] > 1 || count($this->options) === 1) {
			$type = 'checkbox';
		} else {
			$type = 'radio';
		}
		
		if (empty($this->config['embedded'])) {
			$postfix = '[value]';
		}
		
		$ret = '<input type="' . $type . '" name="' . $this->elementName . $postfix . '" value="' . $key . '" id="option-' . $this->id . $num . '"';
		if (is_array($this->selected) && in_array($key, $this->selected)) {
			$ret .= ' checked="checked"';
		}
		$ret .= ' class="CheckboxEditValue"';
		if ($this->config['onchange']) {
			$ret .= ' onchange="' . $this->config['onchange'] . '"';
		}
		$ret .= '>';
		if (($value != '1') && ($value != 'true')) {
			$ret .= '<label for="option-' . $this->id . $num . '" class="CheckboxEditLabel">' . $value . '</label>' . PHP_EOL;
		}
		$ret .= '</input>' . PHP_EOL;
		if ($lang) {
			$ret .= '<input type="hidden" name="' . $this->elementName . '[lang]" value="' . $lang . '" />' . PHP_EOL;
		}
		if ($dtype) {
			$ret .= '<input type="hidden" name="' . $this->elementName . '[dtype]" value="' . $dtype . '" />&nbsp;' . PHP_EOL;
		}
		
		return $ret;
	}
}

?>
