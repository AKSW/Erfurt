<?php
/**
 * text widget
 *
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: text.php 548 2006-02-18 17:50:02Z soerenauer $
 * @access public
 **/
class text extends powlModuleWidget {
	var $config=array(
	);

	function edit($name,$values=array(),$config=false) {
		if(!empty($this))
			$config=$config?array_merge($this->config,$config):$this->config;
		if(!is_array($values))
			$values=!empty($config['values'])?$config['values']:array($values);
		if(count($values)==0)
			$values[]='';
		if($config['cardinality'])
			$config['cardinalityMax']=$config['cardinalityMin']=1;
		if((empty($this) || empty($this->config['cardinalityMax']) || $config['cardinalityMax']!=1) && substr($name,-2,2)!='[]')
				$name.='[]';
		$ret='';
		foreach($values as $value)
			$ret.='<span name="add'.$name.'"><input type="'.(!empty($config['password'])?'password':'text').'"'.
		              'name="'.$name.'" value="'.str_replace('"','&quot;',$value).'"'.
					  (!empty($config['Attributes'])?' '.$config['Attributes']:'').'"'.
					  (!empty($config['size'])?' size="'.$config['size'].'"':'').
					  (!empty($config['length'])?' length="'.$config['length'].'"':'').
					  (!empty($config['readonly'])?' readonly="readonly"':'').
					  (!empty($config['AttributeClass'])?' class="'.$config['AttributeClass'].'"':'').
					  (!empty($config['AttributeStyle'])?' style="'.$config['AttributeStyle'].'"':'').
					 ' />'.(!empty($config['readonly']) || (!empty($config['cardinalityMax']) && $config['cardinalityMax']==1)?'':'&nbsp;<input type="image" onclick="if(document.getElementsByName(\''.$name.'\').length>1) powl.remove(this.parentNode); else document.getElementsByName(\''.$name.'\')[0].value=\'\'; return false;" src="'.$GLOBALS['_POWL']['uriBase'].'images/delete.gif" title="'.pwl_('Remove').'" />').'<br /></span>';
		if(empty($config['readonly']) && (empty($config['cardinalityMax']) || $config['cardinalityMax']!=1))
			$ret.='<a href="javascript:powl.duplicate(\'add'.$name.'\')" title="'.pwl_('Add').'">[+]</a>';
#			$ret.='&nbsp;<img src="'.$GLOBALS['_POWL']['uriBase'].'images/item_ltr.png" align="absmiddle">&nbsp;<a href="javascript:powl.duplicate(\'add'.$name.'\')">'.pwl_('Add').'</a>';
		return $ret."\n";
	}
}
?>