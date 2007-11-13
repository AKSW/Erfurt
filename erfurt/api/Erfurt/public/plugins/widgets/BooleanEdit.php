<?php

// require CheckboxEdit
if (!class_exists('CheckboxEdit', false)) {
	require_once ERFURT_BASE . Zend_Registry::get('config')->widgetDir . 'CheckboxEdit/CheckboxEdit.php';
}

/**
  * Erfurt boolean edit widget
  *
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class BooleanEdit extends CheckboxEdit {
	
	public function __construct($elementName = null, $selected = null, $config = array()) {
		parent::__construct($elementName, $selected, $config);
		
		// support all lexical representations of xsd:boolean
		if (in_array('true', $this->selected) || in_array('false', $this->selected)) {
			$this->options = array('true' => 'True', 'false' => 'False');
		} else {
			$this->options = array('1' => 'True', '0' => 'False');
		}
		$this->config['cardinalityMax'] = 1;
		$this->config['class'] = 'BooleanEditContainer radio';
		$this->config['dtype'] = 'http://www.w3.org/2001/XMLSchema#boolean';
	}
	
	public static function getPreferredDatatypes() {
		return 'http://www.w3.org/2001/XMLSchema#boolean';
	}
}

?>
