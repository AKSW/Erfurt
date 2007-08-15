<?php

/**
  * Erfurt date widget
  *
  * @author Norman Heino
  * @version $Id$
  */
class DateEdit extends Erfurt_Plugin_Widget {
	
	public function __construct($elementName = null, $values = null) {
		parent::__construct($elementName, 
			                $values, 
							// config
							array('class'          => 'date_edit', 
								  'cardinalityMax' => 1));
		
		$this->scripts[] = $this->widgetBaseUrl . 'DateEdit/epoch_classes.js';
		$this->styles[] = $this->widgetBaseUrl . 'DateEdit/epoch_styles.css';
		$this->styles[] = $this->widgetBaseUrl . 'DateEdit/date_edit.css';
	}
	
	public function getSingleValueHtml($date = '', $num = 1) {
		if ($date instanceof Literal) {
			$value = $date->getLabel();
		} else {
			$value = $date;
		}
		
		$name = $this->elementName;
		
		$ret = '<input type="text" name="' . $name . '[value]" class="DateEditValue" value="' . $value . '" id="value-' . $this->id . $num . '" />' . PHP_EOL;
		$ret .= '<script type="text/javascript">' . 
		                'cal' . $this->id . ' = new Epoch(\'value-' . $this->id . $num . '\', \'popup\', $(\'value-' . $this->id . $num . '\'), false);' . PHP_EOL . 
						'valueDate = new Date(' . strtotime($value) * 1000 . ');' . 
						'cal' . $this->id . '.selectDates([valueDate], true, true, true);' .  
						'cal' . $this->id . '.goToMonth(valueDate.getFullYear(), valueDate.getMonth());' . 
		                '</script>' . PHP_EOL;
		$ret .= '<input type="hidden" name="' . $name . '[dtype]" value="http://www.w3.org/2001/XMLSchema#date" />' . PHP_EOL;
		
		return $ret;
	}
	
	public static function getPreferredDatatypes() {
		return 'http://www.w3.org/2001/XMLSchema#date';
	}
}

?>