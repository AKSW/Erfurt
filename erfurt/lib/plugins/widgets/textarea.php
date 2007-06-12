<?php
/**
 * select widget
 *
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: textarea.php 548 2006-02-18 17:50:02Z soerenauer $
 * @access public
 **/
class textarea extends powlModuleWidget {
	var $config=array();

	function edit($name,$value,$config=false) {
		if(!empty($this))
			$config=$config?array_merge($this->config,$config):$this->config;
		return '<textarea name="'.$name.'"'.
					(!empty($config['Attributes'])?' '.$config['Attributes']:'').
					(!empty($config['readonly'])?' readonly="readonly"':'').'"'.
					(!empty($config['rows'])?' rows="'.$config['rows'][0].'"':'').
					(!empty($config['cols'])?' cols="'.$config['cols'][0].'"':'').
					(!empty($config['AttributeClass'])?' class="'.$config['AttributeClass'].'"':'').
					(!empty($config['AttributeStyle'])?' style="'.$config['AttributeStyle'].'"':'').
				'>'.(is_array($value)?array_shift($value):$value).'</textarea>'."\n";
	}
}
?>