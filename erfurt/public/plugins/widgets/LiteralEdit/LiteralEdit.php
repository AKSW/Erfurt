<?php

/**
  * Erfurt literal edit widget
  *
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class LiteralEdit extends Erfurt_Plugin_Widget {
	
	public function __construct($elementName, $values) {
		parent::__construct($elementName, 
			                $values, 
							// config
							array(
								'class' => 'literal_edit'
							)
							// scripts
							// style sheets
		);
		
		$this->_styles[] = $this->_widgetBaseUrl . 'LiteralEdit/literal_edit.css';
	}
	
	public function getSingleValueHtml($literal, $num = 1) {
		if ($literal instanceof Literal) {
			$value = $literal->getLabel();
			$lang = $literal->getLanguage() ? $literal->getLanguage() : 'Lang';
			$dtype = $literal->getDatatype();
		} else {
			$value = $literal;
			$lang = 'Lang';
			// $dtype = 'http://www.w3.org/2001/XMLSchema#string';
		}
		
		$name = $this->_elementName . '[' . $num . ']';
		
		$ret  = '<div id="container-' . $this->_id . $num . '" class="LiteralEditContainer">' . PHP_EOL;
		$ret .= '<input type="text" name="' . $name . '[value]" class="LiteralEditValue" value="' . $value . '" id="value-' . $this->_id . $num . '" />' . PHP_EOL;
		$ret .= '<div class="LiteralEditOptionsContainer">' . PHP_EOL;
		$ret .= '<input type="text" name="' . $name . '[lang]" class="LiteralEditLang" value="' . $lang . '" id="lang-' . $this->_id . $num . '" />' . PHP_EOL;
		
		if (!empty($this->_config['dtype'])) {
			$ret .= '<input type="hidden" name="' . $name . '[dtype]" class="LiteralEditDtype" value="' . 
					$this->_config['datatype'] . '" id="dtype-' . $this->_id . $num . '" />' . PHP_EOL;
		} else {
			$ret .= new SelectNew($name . '[dtype]', $dtype, $this->_types, array('cardinalityMax' => 1, 'class' => 'LiteralEditDtype'));
		}
		
		$ret .= '</div>' . PHP_EOL . '</div>' . PHP_EOL;
		
		return $ret;
	}
}

?>
