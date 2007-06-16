<?php

/**
  * Abstract base class for all Erfurt plug-ins. 
  *
  * @package Erfurt
  * @subpackage Plugin
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
abstract class Erfurt_Plugin {
	
	var $_types;
	
	protected function __construct() {
		$this->_types = Zend_Registry::get('datatypes');
	}
	
}

?>