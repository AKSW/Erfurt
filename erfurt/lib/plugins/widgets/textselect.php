<?php
/**
 * text widget
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: textselect.php 282 2004-06-01 23:29:34Z soerenauer $
 * @access public
 **/
class textselect extends powlModuleWidget {
	var $config=array(
	);
	
	function edit($name,$values,$selectvalues,$config=false) {
		$config=$config?array_merge($this->config,$config):$this->config;
		if(!is_array($values))
			$values=array($values);
		$values[]='';
		$name.='[]';
		$ret='';
		foreach($values as $value)
			$ret.='<span name="add'.$name.'"><input type="'.(!empty($config['password'])?'password':'text').'"'.
		              ' name="'.$name.'" value="'.$value.'"'.
					  (!empty($config['Attributes'])?' '.$config['Attributes']:'').'"'.
					  (!empty($config['size'])?' size="'.$config['size'].'"':'').
					  (!empty($config['length'])?' length="'.$config['length'].'"':'').
					  (!empty($config['AttributeClass'])?' class="'.$config['AttributeClass'].'"':'').
					  (!empty($config['AttributeStyle'])?' style="'.$config['AttributeStyle'].'"':'').
					 ' onchange="powl.setVisibility(this.parentNode.childNodes[4],\'none\');" onkeydown="this.parentNode.childNodes[4].firstChild.options[this.parentNode.childNodes[4].firstChild.selectedIndex].selected=false;"'.
					 ' onfocus="powl.toggleVisibility(this.parentNode.childNodes[4]);" />'.(!empty($this->config['cardinalityMax']) && $this->config['cardinalityMax']==1?'':'&nbsp;<input type="image" onclick="if(document.getElementsByName(\''.$name.'\').length>1) powl.remove(this.parentNode); else document.getElementsByName(\''.$name.'\')[0].value=\'\'; return false;" src="'.$GLOBALS['_POWL']['uriBase'].'images/delete.gif" title="'.pwl_('Remove').'" />').'
					<div style="display:none;"><select size="5" onblur="powl.setVisibility(this.parentNode,\'none\')" onchange="this.parentNode.parentNode.firstChild.value=this.options[this.selectedIndex].value; powl.setVisibility(this.parentNode,\'none\');"><option>'.join('</option><option>',$selectvalues).'</option></select></div>
					 <br /></span>';
		if(empty($config['cardinalityMax']) || $config['cardinalityMax']!=1)
			$ret.='<a href="javascript:powl.duplicate(\'add'.$name.'\')" title="'.pwl_('Add').'">[+]</a>';
#			$ret.='&nbsp;<img src="'.$GLOBALS['_POWL']['uriBase'].'images/item_ltr.png" align="absmiddle">&nbsp;<a href="javascript:powl.duplicate(\'add'.$name.'\')">'.pwl_('Add').'</a>';
		return $ret;
	}
}
?>