<?php

/**
 * widget related classes and functions common to all POWL modules
 *
 * @package POWLAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: widget.php 829 2007-03-11 10:05:02Z nheino $
 * @access public
 **/

class powlModuleWidget extends powlModule {
	var $config=array();
	function powlModuleWidget($config=true) {
		if(is_array($config)) {
			$this->config=array_merge($this->config,$config);
			if(!empty($this->config['cardinality']))
				$this->config['cardinalityMin']=$this->config['cardinalityMax']=$this->config['cardinality'];
		}
		else if(!$config)
			return;
		$this->_require['js']=empty($this->_require['js'])?array():(!is_array($this->_require['js'])?array($this->_require['js']):$this->_require['js']);
		$base=strcasecmp(get_parent_class($this),'powlmodulewidget')?get_parent_class($this):get_class($this);
		$base=$base=='treeviewjs'?'treeviewJS':$base;
		foreach($this->_require['js'] as $js) if($js)
			echo('<SCRIPT type="text/javascript" src="'.(!ereg('#^http://|/#',$js)?$GLOBALS['_POWL']['uriBase'].'plugins/widgets/'.$base.'/':'').$js.'"></SCRIPT>');
		$this->_require['css']=empty($this->_require['css'])?array():(!is_array($this->_require['css'])?array($this->_require['css']):$this->_require['css']);
		foreach($this->_require['css'] as $css) if($css)
			echo('<link rel="stylesheet" type="text/css" media="screen" href="'.(ereg('#^http://|^/#',$css)?'':$GLOBALS['_POWL']['uriBase'].'plugins/widgets/'.$base.'/').$css.'"></style>');
	}
	function show($value) {
		return $value;
	}
}

/**
 *
 * personalisiert:
 * Class,Property,Model,Datatype,Group
 * Property,Model,Datatype,Group
 * Model,Datatype,Group
 * Datatype,Group
 *
 * unpersonalisiert:
 * Class,Property,Model,Datatype
 * Property,Model,Datatype
 * Model,Datatype
 * Datatype
 *
 *
 * @param $property
 * @param string $class
 * @param string $user
 * @return
 **/

#Property,Class,Model,Datatype
#1,1,0,1
#1,0,0,1
#1,0,0,0
#0,1,0,1
#0,0,1,1
#0,0,0,1

function pwlFindWidget($Property,$Class='',$user='') {
	if(!$widgetClass=pwlGetSysOntClass('WidgetSelection'))
		return false;

	$r=$Property->getRange();
	$Datatype=$r?$r->getURI():'';

	$Model=$Property->model->modelURI;
	$Property=$Property->getURI();
	#Class=$Class->getURI();

	# TODO: pass the same with Group added to $p first
	$p=array('Property','Class','Model','Datatype');

	$t=array();
	$f=array();
	foreach($p as $prop) {
		$t[$prop][$GLOBALS['_POWL']['SysOntSchemaURI'].'widget'.$prop]=$$prop;
		$f[$prop][$GLOBALS['_POWL']['SysOntSchemaURI'].'widget'.$prop]='';
	}
# disabled for performance (class and model specific widget configurations)
#	if($widgetInstance=parray_shift($widgetClass->findInstancesRecursive(array_merge($t['Property'],$t['Class'],$f['Model'],$t['Datatype']))))
#		return $widgetInstance;
#	if($widgetInstance=parray_shift($widgetClass->findInstancesRecursive(array_merge($t['Property'],$f['Class'],$f['Model'],$t['Datatype']))))
#		return $widgetInstance;
	if($widgetInstance=parray_shift($widgetClass->findInstancesRecursive(array_merge($t['Property'],$f['Class'],$f['Model'],$f['Datatype']))))
		return $widgetInstance;
#	if($widgetInstance=parray_shift($widgetClass->findInstancesRecursive(array_merge($f['Property'],$t['Class'],$f['Model'],$t['Datatype']))))
#		return $widgetInstance;
#	if($widgetInstance=parray_shift($widgetClass->findInstancesRecursive(array_merge($f['Property'],$f['Class'],$t['Model'],$t['Datatype']))))
#		return $widgetInstance;
#print_r($widgetClass);
	if($widgetInstance=parray_shift($widgetClass->findInstancesRecursive(array_merge($f['Property'],$f['Class'],$f['Model'],$t['Datatype']))))
		return $widgetInstance;
}

function pwlGetWidgetObject($class,$property,$config=array(),$strict=false) {
	if(method_exists($property,'isFunctional')) {
		if($property->isFunctional())
			$config['cardinality']=$config['cardinalityMin']=$config['cardinalityMax']=1;
		else if(method_exists($property,'getCardinalityMinInherited')) {
			$config['cardinalityMin']=$class->getCardinalityMinInherited($property);
			$config['cardinalityMax']=$class->getCardinalityMaxInherited($property);
		}
	}
	if(!$GLOBALS['powl']->aclCheck('Edit',$class->model) && !isset($config['readonly']))
		$config['readonly']=true;
	$range=$property->getRange();
	if(method_exists($class,'getRestrictionHasValue') && $reststm=parray_shift($class->getRestrictionHasValue($property))) {
		$hasValue=$reststm->obj;
		$widgetClassName='text';
		$config['Attributes']='readonly="readonly"';
		$config['values']=array(is_a($hasValue,'Resource')?$hasValue->getLocalName():$hasValue->getLabel());
		$config['cardinalityMin']=$config['cardinalityMax']=1;
	} else if(method_exists($property,'listRangeFromDataRange') && $rangeValues=$property->listRangeFromDataRange()) {
		$widgetClassName=count($rangeValues)<25?'checkbox':'select';
		foreach($rangeValues as $one=>$val)
			$config['values'][$one]=$one;
	} else if($widgetSelectionInstance=pwlFindWidget($property,$class)) {
		if($widgetInstance=pwlGetSysOntInstance($widgetSelectionInstance->getPropertyValuePlain('widgetConfiguration'))) {
			$widgetClass=$widgetInstance->getClass();
			$widgetClassName=$widgetClass->getLocalName();
			foreach($widgetInstance->listAllPropertyValuesPlain() as $key=>$val)
				$config[str_replace('widget'.$widgetClassName,'',$key)]=count($val)>1?$val:array_pop($val);
		}
	}
	if(empty($widgetClassName)) {
		if(empty($range)) {
			if(!$strict) {
				if(method_exists($property,'isObjectProperty') && $property->isObjectProperty())
					$widgetClassName='editResource';
				else if(method_exists($property,'isDatatypeProperty') && $property->isDatatypeProperty())
					$widgetClassName='editliteral';
				else
					$widgetClassName='editnode';
			} else
				return false;
		} else if(is_array($range)) {
			$widgetClassName='selectInstance';
			$config['class']=$range;
		} else if($rangeClass=$property->model->getClass($range->getURI())) {
			$widgetClassName='selectInstance';
			if(method_exists($property,'rangeIsUnionClass') && $property->rangeIsUnionClass())
				$config['class']=$property->listRangeFromUnionClass();
			else
				$config['class'][$range->getLocalName()]=$rangeClass;
		} else if(in_array($range->getURI(),array_keys($property->model->vocabulary['Property'])))
			$widgetClassName='selectProperty';
		else if(in_array($range->getURI(),array_keys($property->model->vocabulary['Class'])))
			$widgetClassName='selectClass';
		else if(in_array($range->getURI(),array_keys($GLOBALS['_POWL']['datatypes']))) {
			$widgetClassName='editLiteral';
			$config['datatype']=$range->getURI();
		} else if(!$strict)
			$widgetClassName='editnode';
		else
			return false;
	}
	
	// if ($property->getLocalName() == 'dc:description') {
	// 	$widgetClassName = 'htmledit';
	// }
	
	$widget = new $widgetClassName();
	
	// static request
	$config['asXml'] = false;
	
	$widget->config=$config;
	if(!empty($widgetInstance))
		$widget->widgetConfigInstance=$widgetInstance;
	return $widget;
}
/**
  * Returns a requestet pOWL widget by retrieving the actual widget
  * object from <code>pwlGetWidgetObject</code> and calling its 
  * <code>edit</code> method when returning.
  *
  * @param $class the property's data type class
  * @param $property the property name
  * @param $value the property value
  * @param $config the widgets displaying configuration
  * @param $strict ???
  * @return string the widgets html edit code.
  */
function pwlGetWidget($class, $property, $value, $config = array(), $strict = false) {
	$widgetName = !empty($config['name']) ? $config['name'] : 'prop['.$property->getURI().']';
	if ($widget = pwlGetWidgetObject($class, $property, $config, $strict))
		return $widget->edit($widgetName, $value)/* . get_class($widget)*/;
		
	#		.'<a title="'.pwl_('Configure widget ...').'" href="javascript:powl.winopen(\''.$GLOBALS['_POWL']['uriBase'].'modules/instances/conf_widget_frame.php?property='.urlencode(urlencode($property->getLocalName())).'&uri='.'\')">[c]</a>';
	#		.(!empty($widget->widgetConfigInstance)?'<br /><a title="'.pwl_('Configure widget ...').'" href="javascript:powl.winopen(\''.$GLOBALS['_POWL']['uriBase'].'modules/instances/instance.php?model='.urlencode(urlencode($GLOBALS['_POWL']['SysOnt']->modelURI)).'&uri='.urlencode(urlencode($widget->widgetConfigInstance->getURI())).'\')">[c]</a>':'');
}
?>