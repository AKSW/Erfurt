<?php
/**
 * html editor widget
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004 
 * @access public
 **/

include('FCKeditor/fckeditor.php');
class htmledit {
	var $config=array(
	);
	
	function edit($name,$value,$config=false) {
		$config=$config?array_merge($this->config,$config):$this->config;
		$htmledit=new FCKeditor();
		$htmledit->Value = $value;
		// simple editor without configuration
		$htmledit->CreateFCKeditor('EditorDefault','75%',150) ;
		return ob_get_clean();
	}
}

?>