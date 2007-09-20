<?php

/**
  * Erfurt literal edit widget
  *
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class LiteralEdit extends Erfurt_Plugin_Widget {
	
	public function __construct($elementName = null, $values = null, $config = array()) {
		parent::__construct($elementName, 
			                $values, 
							// config
							$config
		);
		
		$this->config['class'] = 'LiteralEditContainer';
		
		$this->scripts[] = $this->widgetBaseUrl . 'LiteralEdit/literal_edit.js';
		$this->styles[] = $this->widgetBaseUrl . 'LiteralEdit/literal_edit.css';
	}
	
	public function getSingleValueHtml($literal = '', $num = 1) {
		if ($literal instanceof Literal) {
			$value = $literal->getLabel();
			$lang = $literal->getLanguage() ? $literal->getLanguage() : 'Lang';
			$dtype = $literal->getDatatype();
		} elseif ($literal instanceof Resource) {
			$value = $literal->getLocalName();
			$lang = 'Lang';
		} else {
			$value = $literal;
			$lang = 'Lang';
			// $dtype = 'http://www.w3.org/2001/XMLSchema#string';
		}
		
		$name = $this->elementName . '[' . $num . ']';
		
		if (isset($this->config['nameMod'])) {
			$nameMod .= '[' . $this->config['nameMod'] . ']';
		} else {
			$nameMod = '';
		}
		
		if (!isset($this->config['embedded'])) {
			// $ret = '<div id="container-' . $this->id . $num . '" class="LiteralEditContainer"' . 
			// ' onmouseover="toggleOptions($(\'opt-cont' . $this->id . $num . '\'), \'mouseover\')"' . 
			// ' onmouseout="toggleOptions($(\'opt-cont' . $this->id . $num . '\'), \'mouseout\')"' . 
			// '>' . PHP_EOL;
		} else {
			$ret = '';
		}
		if (!strstr($value, PHP_EOL) && strlen($value) < 20) {
			$ret .= '<input type="text" name="' . $name . '[value]' . $nameMod . '" class="LiteralEditValue text" value="' . 
					$value . '" id="value-' . $this->id . $num . '" />' . PHP_EOL;
		} else {
			$ret .= '<textarea rows="' . ceil(strlen($value) / 25) . '" cols="25" name="' . $name . '[value]' . $nameMod . '" class="LiteralEditValue" id="value-' . 
					$this->id . $num . '">' . $value . '</textarea>' . PHP_EOL;
		}
		$ret .= '<div class="LiteralEditOptionsContainer" id="opt-cont' . $this->id . $num . '">' . PHP_EOL; // style="opacity:0"
		$ret .= '@<input type="text" name="' . $name . '[lang]" class="LiteralEditLang text" value="' . $lang . '" id="lang-' . 
				$this->id . $num . '" />' . PHP_EOL;
		
		if (!empty($this->config['dtype'])) {
			$ret .= '^^<input type="text" readonly="readonly" name="' . $name . '[dtype]" class="LiteralEditDtype text" value="' . 
					str_replace('&nbsp;', '', $this->config['dtype']) . '" id="dtype-' . $this->id . $num . '" />' . PHP_EOL;
		} else {
			if (!empty($this->config['cssId'])) {
				$ret .= '^^' . new SelectNew($name . '[dtype]', $dtype, $this->types, array('cardinalityMax' => 1, 
				                                                                      'class' => 'LiteralEditDtype select', 
				                                                                      'cssId' => $this->config['cssId'], 
				                                                                      'start' => $this->config['start']));
			} else {
				$ret .= '^^' . new SelectNew($name . '[dtype]', $dtype, $this->types, array('cardinalityMax' => 1, 
				                                                                      'class' => 'LiteralEditDtype'));
			}
		}
		
		$ret .= '<img class="delete button" id="img-' . $this->id . $num . '" src="' . $this->publicUri . 'images/delete.gif" alt="del" />' . PHP_EOL;
		
		$ret .= '</div>' . PHP_EOL;
		
		if (!isset($this->config['embedded'])) {
			// $ret .= '</div>' . PHP_EOL;
		}
		
		return $ret;
	}
}

?>
