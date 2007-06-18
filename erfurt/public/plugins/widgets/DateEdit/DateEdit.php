<?php

/**
  * Erfurt date widget
  *
  * @author Norman Heino
  * @version $Id$
  */
class DateEdit extends Erfurt_Plugin_Widget {
	
	public function __construct($elementName, $values) {
		parent::__construct($elementName, 
			                $values, 
							// config
							array(
								'class' => 'date_edit'
							)
		);
		
		$this->_scripts[] = $this->_widgetBaseUrl . 'DateEdit/epoch_classes.js';
		$this->_styles[] = $this->_widgetBaseUrl . 'DateEdit/epoch_styles.css';
		$this->_styles[] = $this->_widgetBaseUrl . 'DateEdit/date_edit.css';
	}
	
	public function getSingleValueHtml($date, $num = 1) {
		if ($date instanceof Literal) {
			$value = $date->getLabel();
		} else {
			$value = $date;
		}
		
		$ret = '<input type="text" name="' . $name . '[value]" class="DateEditValue" value="' . $value . '" id="value-' . $this->_id . $num . '" />' . PHP_EOL;
		$ret .= '<script type="text/javascript">' . PHP_EOL . 
                'cal' . $this->_id . ' = new Epoch(\'value-' . $this->_id . $num . '\', \'popup\', $(\'value-' . $this->_id . $num . '\'));' . PHP_EOL . 
                '</script>' . PHP_EOL;
		$ret .= '<input type="hidden" name="' . $name . '[dtype]" value="http://www.w3.org/2001/XMLSchema#date" />' . PHP_EOL;
		
		return $ret;
	}
	
	public static function getPreferredDatatypes() {
		return 'http://www.w3.org/2001/XMLSchema#date';
	}
}

?>