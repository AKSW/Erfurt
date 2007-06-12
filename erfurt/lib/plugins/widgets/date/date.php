<?php
/**
  * date widget
  *
  * @package POWL-Widgets
  * @author Sören Auer <soeren@auer.cx>
  * @copyright Copyright (c) 2004
  * @version $Id: date.php 886 2007-03-25 00:33:11Z nheino $
  * @access public
  */

// include($_POWL['installPath'].'plugins/widgets/date/jscalendar/calendar.php');

/**
  * The pOWL date widget displays a jscalendar to conviniently input date information.
  *
  * @author Soeren Auer
  */
class date extends powlModuleWidget {
	
	var $config = array();

	function edit($name, $value = '', $config = false) {
		$config = $config ? array_merge($this->config, $config) : $this->config;
		if (is_array($value))
			$value = array_shift($value);
		if (is_a($value, 'RDFSLiteral'))
			$value = $value->getLabel();
			
		$id = uniqid();
		
		$textRet = PHP_EOL.'<input type="hidden" name="' . $name . '[dtype]" value="http://www.w3.org/2001/XMLSchema#date" />' . PHP_EOL . 
		           '<input type="text" name="' . $name . '[value]" value="' . $value . '" id="cal' . $id . '" />' . PHP_EOL . 
		           '<script type="text/javascript">' . PHP_EOL . 
		             'cal' . $id . ' = new Epoch(\'cal' . 
		             $id . '\', \'popup\', document.getElementById(\'cal' . 
		             $id . '\'));' . PHP_EOL . 
		           '</script>' . PHP_EOL;
		
		
		$xmlRet = new DOMDocument();
		$root = $xmlRet->createElement('root');
		
		// create first input
		$input1 = $xmlRet->createElement('input');
		$input1->setAttribute('type', 'hidden');
		$input1->setAttribute('name', $name . '[dtype]');
		$input1->setAttribute('value', 'http://www.w3.org/2001/XMLSchema#date');
		
		// create second input
		$input2 = $xmlRet->createElement('input');
		$input2->setAttribute('type', 'text');
		$input2->setAttribute('name', $name . '[value]');
		$input2->setAttribute('value', $value);
		$input2->setAttribute('id', 'cal' . $id);
		
		// create script content
		$scriptText = $xmlRet->createTextNode('cal' . $id . ' = new Epoch(\'' . 
		                                      $id . '\', \'popup\', document.getElementById(\'cal' . 
		                                      $id . '\'));');
		
		
		// create script node
		$scriptNode = $xmlRet->createElement('script');
		$scriptNode->setAttribute('type', 'text/javascript');
		$scriptNode->appendChild($scriptText);
		
		
		$root->appendChild($input1);
		$root->appendChild($input2);
		$root->appendChild($scriptNode);
		
		$xmlRet->appendChild($root);
		
		/*
		 * Send a XML header if content should be returned as XML
		 * or a XML text representation otherwise which
		 * is perfectly valid XHTML.
		 */
		if ($config['asXML']) {
			header('Content-Type: text/xml');
			return $xmlRet->saveXML();
		} else {
			return $textRet;
		}
	}
}
?>