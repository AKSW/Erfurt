<?php

/**
  * Erfurt node edit widget
  *
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class NodeEdit extends Erfurt_Plugin_Widget {
	
	public function __construct($elementName = null, $values = null) {
		parent::__construct($elementName, 
			                $values, 
							// config
							array('class' => 'NodeEditContainer')
		);
		
		$this->_scripts[] = $this->_widgetBaseUrl . 'NodeEdit/node_edit.js';
		
		$cb = new CheckboxEdit();
		$le = new LiteralEdit();
		$re = new LiteralEdit();
		$this->_styles = array_merge(array($this->_widgetBaseUrl . 'NodeEdit/node_edit.css'), 
		                               $cb->getStylesheets(), 
		                               $le->getStylesheets(), 
		                               $re->getStylesheets());
	}
	
	public function getSingleValueHtml($value, $num = 1) {
		$name = $this->_elementName;
		
		$options = array('resource' => 'Resource', 'literal' => 'Literal');
		
		if ($value instanceof Literal) {
			$selected = 'literal';
		} elseif ($value instanceof Resource) {
			$selected = 'resource';
		} else {
			$selected = 'literal';
		}
		
		$checkbox = new CheckboxEdit($name . '[' . $num . '][type]', $selected, $options, array(
																				'cardinality' => 1, 
																				'prefix' => $name, 
																				'class' => 'NodeEditSelector', 
																				'separator' => '&nbsp;', 
																				'onchange' => 'toggleSubWidget(\'' . $this->_id . '\',this.value,' . $num . ')'
																				)
		);
		$resource = new ResourceEdit($name, $value, array('cardinality' => 1, 
																	'display' => ($selected == 'literal' ? 'none' : ''), 
																	'cssId' => 'resource' . $this->_id,
																	'start' => $num
																	)
		);
		$literal = new LiteralEdit($name, $value, array('cardinality' => 1, 
														'display' => ($selected == 'resource' ? 'none' : ''), 
														'cssId' => 'literal' . $this->_id,
														'start' => $num
														)
		);
		$ret = $checkbox . $resource . $literal;
		
		return $ret;
	}
}

?>
