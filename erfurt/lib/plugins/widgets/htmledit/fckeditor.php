<?php
/**
 * html editor widget
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004 
 * @access public
 **/

include($_POWL['installPath'].'plugins/widgets/htmledit/FCKeditor/fckeditor.php');
class htmledit {
	var $config=array(
	);
	
	function edit($name,$value,$config=false) {
		$config=$config?array_merge($this->config,$config):$this->config;
		$htmledit=new FCKeditor();
		$htmledit->Value = $value;
		// set basic toolbar
		$htmledit->ToolbarSet = 'Basic' ;
		// simple editor without configuration
		$htmledit->CreateFCKeditor('EditorDefault','600',150) ;
		
	}
}
/*
Aufruf:
$editor=new htmledit();
$editor->edit('varName','varContent');
*/
?>