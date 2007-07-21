<?php
/**
 * select widget
 *
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: checkbox.php 549 2006-03-06 02:19:04Z soerenauer $
 * @access public
 **/
class checkbox extends powlModuleWidget {
	var $config=array(
		'cols'=>3,
		'separator'=>'<br />',
		'multi'=>true,
		'width'=>250,
		'height'=>200,
		'overflow'=>'',
	);

	function edit($name,$value='',$values=array('on'=>''),$config=array()) {
		if(!$values)
			$values=!empty($this)&&!empty($this->config['values'])?$this->config['values']:array();
		if(!empty($this))
			$config=array_merge($config,$this->config);
		if(count($values)==1) {
			$config['cols']=0;
			$config['separator']='';
		}
		if($config['cardinality'])
			$config['cardinalityMax']=$config['cardinalityMin']=1;
		$widget=!empty($config['cols'])?'<table width="100%"><tr>':'';
		$i = 0;
		if(empty($values['']) && !empty($config['cardinalityMax']) && $config['cardinalityMax']==1 && count($values)>1 && $config['cardinalityMin']!=1)
			$values['']='None';
		$name.=(!strstr($name,'[]') && count($values)>1 && (empty($config['cardinalityMax'])||!$config['cardinalityMax']==1)?'[]':'');
		foreach($values as $key => $val) {
			$w='';
			if($config['readonly'] && ($value==$key || (is_array($value) && in_array($key,$value)))) {
				$w=$val;
				$i++;
			} else if(!$config['readonly']) {
				$i++;
				$w='<input onchange="powl.formOptions(this,\''.$config['prefix'].'\')" '.(empty($config['Attributes'])?'':$config['Attributes']).
					' type="'.(empty($config['cardinalityMax'])||!$config['cardinalityMax']==1||count($values)==1?'checkbox':'radio').'"'.
					" name='$name' value='$key'".($value==$key || (is_array($value) && in_array($key,$value))?' checked="checked"':'').">&nbsp;".($val!='1'?$val:'').'</input>';
			}
			if($w) {
				if(!empty($config['cols'])) {
					$widget.='<td valign="top" awidth="'.ceil(100/$config['cols']).'%">'.$w.'</td>';
					if(!empty($config['cols']) && $i>=$config['cols']) {
						$widget.='</tr><tr>';
						$i = 0;
					}
				} else
					$widget.=$w.$config['separator'];
			}
		}
		if(!empty($config['cols']))
			$widget.='</tr></table>';
		return $widget.'<script language="javascript">powl.formOptions("'.$name.'",\''.$config['prefix'].'\');</script><script language="javascript">powl.SafeAddOnload(function() { powl.formOptions("'.$name.'",\''.$config['prefix'].'\'); });</script>'."\n";
	}
}
class boolean extends checkbox {
	function edit($name,$value) {
		$this->config['cardinalityMax']=1;
		return parent::edit($name,$value,array(1=>pwl_('Yes'),0=>pwl_('No')));
	}
}
?>