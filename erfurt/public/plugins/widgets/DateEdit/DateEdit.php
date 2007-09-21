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
		$this->scripts[] = $this->widgetBaseUrl . 'DateEdit/date_edit.js';
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
		
		$ret = '<input type="text" name="' . $name . '[value]" class="DateEditValue text" value="' . $value . '" id="value-' . $this->id . $num . '" />' . PHP_EOL;
		$ret .= '<input type="hidden" name="' . $name . '[dtype]" value="http://www.w3.org/2001/XMLSchema#date" />' . PHP_EOL;
		if (!empty($value)) {
			$ret .= '<script type="text/javascript">var cal' . $this->id . $num . '=loadDateEdit(\'' . $this->id . $num . '\',' . strtotime($value) * 1000 . ')</script>';
		} else {
			$ret .= '<script type="text/javascript">var cal' . $this->id . $num . '=loadDateEdit(\'' . $this->id . $num . '\')</script>';
		}
		
		
		// $this->onLoadCode = 
		// 	'cal' . $this->id . ' = new Epoch(\'value-' . $this->id . $num . '\', \'popup\', document.getElementById(\'value-' . $this->id . $num . '\'), false);';
		// if (!empty($value)) {
		// 	$this->onLoadCode .= 'valueDate = new Date(' . strtotime($value) * 1000 . ');' . 
		// 			'cal' . $this->id . '.selectDates([valueDate], true, true, true);' . 
		// 			'cal' . $this->id . '.goToMonth(valueDate.getFullYear(), valueDate.getMonth());';
		// }
		
		return $ret;
	}
	
	public static function getPreferredDatatypes() {
		return 'http://www.w3.org/2001/XMLSchema#date';
	}
}

?>
