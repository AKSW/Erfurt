<?php
/**
 * instance selection widget
 *
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: include.php 548 2006-02-18 17:50:02Z soerenauer $
 * @access public
 **/

class selectResource extends powlModuleWidget {
	var $_require=array(
		'js'=>'script.js'
	);
	function edit($name,$value=array(''),$config=array()) {
		if(!empty($this))
			$config=array_merge($this->config,$config);
		$value=is_a($value,'Node')?$value->getLabel():$value;
		$value=is_array($value)?$value:($value?array($value=>$value):array(''));
		if(!empty($config['cardinality']))
			$config['cardinalityMax']=$config['cardinalityMin']=1;
		$attributes=(!empty($config['Attributes'])?' '.$config['Attributes']:'').'"'.
			(!empty($config['size'])?' size="'.$config['size'].'"':'').
			(!empty($config['length'])?' length="'.$config['length'].'"':'').
			(!empty($config['AttributeClass'])?' class="'.$config['AttributeClass'].'"':'').
			(!empty($config['AttributeStyle'])?' style="'.$config['AttributeStyle'].'"':'');
		if(empty($config['cardinalityMax']) || !$config['cardinalityMax']==1)
			$name.='[]';
		$ret='';
		if(!empty($config['class']))
			foreach($config['class'] as $cl) {
				$firstClass=$cl;
				break;
			}
		else $firstClass=false;
		if(empty($config['cardinalityMax']) || !$config['cardinalityMax']==1)
			foreach($value as $key=>$val)
				$ret.='<input type="hidden" name="'.$name.'" value="'.$val.'" />';
		$ret.=(!empty($config['cardinalityMax']) && $config['cardinalityMax']==1?
		  '<input type="text" id="'.$name.'" name="'.$name.'" value="'.htmlspecialchars(array_shift($value)).'" readonly="readonly"'.$attributes.' />':
		  '<textarea id="__cxtreeview'.$name.'" readonly="readonly"'.$attributes.'>'.join("\n",$value)."\n".'</textarea>');
		if(!$config['readonly']) {
			$ret.='<br /><a href="javascript:powl.winopen(\''.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/selectInstance/';
			$instancesOnly=((bool)$firstClass && count($config['class'])==1 && $firstClass->countSubClasses()==0);
			$ret.=($instancesOnly?'instances_frame.php?uri='.urlencode(urlencode($firstClass->getURI())):
			  'selectInstance.php?'.($firstClass?'uri='.urlencode(urlencode(serialize(array_keys($config['class'])))):'')).
			  '&resource='.get_class($this).'&element='.urlencode(urlencode($name)).'\',\'selectInstance\',\'height=400,width='.
			  ((strtolower(get_class($this))=='selectinstance'||strtolower(get_class($this))=='selectresource')&&!$instancesOnly?600:300).'\');" title="'.pwl_('Select').'">[s]</a><br />';
		}
		return $ret;
	}
}
class selectClass extends selectResource {
}
class selectProperty extends selectResource {
	function edit($name,$value,$config=array()) {
		if(!empty($this))
			$config=array_merge($this->config,$config);
		$value=is_a($value,'Node')?$value->getLabel():$value;
		$value=is_array($value)?$value:($value?array($value=>$value):array(''));
		if(!empty($config['cardinality']))
			$config['cardinalityMax']=$config['cardinalityMin']=1;
		if($config['selectCount'] && $GLOBALS['_ET']['rdfsmodel']->countProperties()<$config['selectCount']) {
			$props=array_keys($GLOBALS['_ET']['rdfsmodel']->listProperties());
			pwlArrayCopyValues2Indexes(&$props);
			return select::edit($name,$value,$props,$config);
		} else
			return parent::edit($name,$value,$config);
	}
}
class selectInstance extends selectResource {
	function edit($name,$value,$config=array()) {
		if(!empty($this))
			$config=array_merge($this->config,$config);
		$value=is_a($value,'Node')?$value->getLabel():$value;
		$value=is_array($value)?$value:($value?array($value=>$value):array(''));
		if(!empty($config['cardinality']))
			$config['cardinalityMax']=$config['cardinalityMin']=1;
		if(!empty($config['class'])) {
			$config['class']=is_array($config['class'])?$config['class']:array($config['class']);
			$ci=0;
			foreach($config['class'] as $key=>$cl) {
				if(!is_a($cl,'RDFSClass'))
					$cl=$config['class'][$key]=$GLOBALS['_ET']['rdfsmodel']->getClass($cl);
				if($cl->model->countClasses()<1000)
					$ci+=$cl->countInstancesRecursive();
			}
			if(0<$ci && $ci<50) {
				$w=$ci<15?new checkbox():new select();
				$w->config=$config;
				foreach($config['class'] as $cl)
					foreach($cl->listInstancesRecursive() as $key=>$val)
						$w->config['values'][$key]=$val->getLocalName();
				return $w->edit($name,$value);
			}
		}
		return parent::edit($name,$value,$config);
	}
}
?>