<?php
/**
 * select widget
 *
 * @package POWL-Widgets
 * @author S�ren Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: select.php 893 2007-03-26 08:36:52Z nheino $
 * @access public
 **/
class select extends powlModuleWidget {
	var $config=array(
		'multi'=>false,
		'multisize'=>5,
		'width'=>250,
		'height'=>200,
		'overflow'=>'',
		'onchange'=>'powl.formOptions(this)',
		'emptyLabel'=>'None'
	);

	function edit($name,$value,$values=array(),$config=false) {
		if (!empty($this) && is_array($this->config)) {
			$config = $config ? array_merge($this->config, $config) : $this->config;
		}
#		if($config['readonly'])
#			return text::edit($name,$values[$value],$config);
		if($config['cardinality'])
			$config['cardinalityMax']=$config['cardinalityMin']=1;
		if(!$values && !empty($this) && $this->config['values'])
			$values=$this->config['values'];
		if((empty($config['cardinalityMax']) || $config['cardinalityMax']!=1) && substr($name,-2,2)!='[]')
				$name.='[]';
		if(!empty($config['cardinalityMax']) && $config['cardinalityMax']==1 && !empty($config['cardinalityMin']) && $config['cardinalityMin']!=1 && !$values[''])
			$values['']=pwl_($config['emptyLabel']);
		$ret='';
		if($values)
			foreach($values as $key=>$val)
				$ret.='<option value="' . ((is_integer($key)) ? $val : $key) . '"'.(is_array($value)&&(in_array($key,$value)||in_array($key,array_keys($value)))||$key===$value?' selected':'').'>'.$val.'</option>'."\n";
		return '<select name="'.$name.'"'.
			(empty($config['cardinalityMax']) || !$config['cardinalityMax']==1?' multiple="multiple" size="'.$config['multisize'].'"':'').
			($config['onchange']?' onchange="'.$config['onchange'].'"':'').
			(!empty($config['readonly'])?' disabled="disabled"':'').
			(!empty($config['Attributes'])?' '.$config['Attributes']:'').
			(!empty($config['AttributeClass'])?' class="'.$config['AttributeClass'].'"':'').
			(!empty($config['AttributeStyle'])?' style="'.$config['AttributeStyle'].'"':'').
			'>'."\n".$ret.'</select><script language="javascript">powl.SafeAddOnload(function() { powl.formOptions("'.$name.'"); });</script>'."\n";
	}
}
class selectModel extends select {
	function edit($name,$value,$config=false) {
		$config=$config?array_merge($this->config,$config):$this->config;
		if(!empty($this->config['cardinalityMax']) && $this->config['cardinalityMax']==1 && !empty($this->config['cardinalityMin']) && $this->config['cardinalityMin']!=1 && !$values[''])
			$values['']=pwl_($config['emptyLabel']);
		foreach($GLOBALS['_ET']['store']->listModels() as $model)
			$values[$model->modelURI]=$model->modelURI;
		return parent::edit($name,$value,$values,$config);
	}
}
class selectUser extends select {
	function edit($name,$value,$config=false) {
		if($this->config['cardinalityMax']==1 && $this->config['cardinalityMin']!=1 && !$values[''])
			$values['']=pwl_('None');
		foreach(pwlGetSysOntClassInstances('User') as $user)
			$values[$user->getURI()]=$user->getPropertyValuePlain('userFirstName').' '.$user->getPropertyValuePlain('userName');
		return parent::edit($name,$value,$values,$config);
	}
}
class selectGroup extends select {
	function edit($name,$value,$config=false) {
		if($this->config['cardinalityMax']==1 && $this->config['cardinalityMin']!=1 && !$values[''])
			$values['']=pwl_('None');
		foreach(pwlGetSysOntClassInstances('Group') as $group)
			$values[$group->getURI()]=$group->getLocalName();
		return parent::edit($name,$value,$values,$config);
	}
}
?>