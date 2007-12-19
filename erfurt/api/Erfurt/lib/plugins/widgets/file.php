<?php
/**
 * file upload widget
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: file.php 536 2005-04-12 18:27:07Z soerenauer $
 * @access public
 **/
class file extends powlModuleWidget {
	function edit($name,$value,$config=false) {
		if(!empty($this))
			$config=$config?array_merge($this->config,$config):$this->config;
#		if($config['readonly'])
#			return text::edit($name,$values[$value],$config);
		if($config['cardinality'])
			$config['cardinalityMax']=$config['cardinalityMin']=1;
		if(!$values && $this->config['values'])
			$values=$this->config['values'];
		if((empty($config['cardinalityMax']) || $config['cardinalityMax']!=1) && substr($name,-2,2)!='[]')
				$name.='[]';
		if(!empty($config['cardinalityMax']) && $config['cardinalityMax']==1 && !empty($config['cardinalityMin']) && $config['cardinalityMin']!=1 && !$values[''])
			$values['']=pwl_($config['emptyLabel']);
#print_r($value);
		return '<input type="file" name="'.$name.'"'.
#			(!empty($config['Attributes'])?' '.$config['Attributes']:'').'"'.
#			(!empty($config['AttributeClass'])?' class="'.$config['AttributeClass'].'"':'').
#			(!empty($config['AttributeStyle'])?' style="'.$config['AttributeStyle'].'"':'').
			'>';
	}
	function process($name) {
		if(empty($this->config['FileUploadDir'])) {
			$path=$GLOBALS['_POWL']['installPath'].'uploads';
			$uriBase=$GLOBALS['_POWL']['uriBase'].'uploads';
		} else
			$path=$this->config['FileUploadDir'];
		if(!is_dir($path))
			mkdir($path);
#print_r($_SERVER['DOCUMENT_ROOT']);
		move_uploaded_file($_FILES[$name]['tmp_name'],$path.'/'.$_FILES[$name]['name']);
		return new Erfurt_Rdfs_Literal_Default($uriBase.'/'.$_FILES[$name]['name']);
	}
}
?>