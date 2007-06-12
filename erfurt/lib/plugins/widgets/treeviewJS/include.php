<?php
/**
 * treeviewJS widget
 *
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: include.php 547 2006-01-31 19:01:15Z soerenauer $
 * @access public
 **/


/**
 * treeviewJS
 *
 * @package
 * @author auer
 * @copyright Copyright (c) 2004
 * @version $Id: include.php 547 2006-01-31 19:01:15Z soerenauer $
 * @access public
 **/
class treeviewJS extends powlModuleWidget {
	var $_require=array(
		'css'=>'styles.css',
		'js'=>'scripts.js'
	);
	var $config=array(
		'autoLoadLevels'=>0,
		'getNodesScript'=>'',
		'startNode'=>'/',
		'enableNodeAttributes'=>true,
		'baseURL' => 'class.php?uri='
	);
	function treeviewJS($config=0,$loadFiles=true) {
		if(is_array($config))
			$this->config=array_merge($this->config,$config);
		else
			$this->config['autoLoadLevels']=$config;
		$this->config['getNodesScript']=$GLOBALS['_POWL']['uriBase'].'plugins/widgets/treeviewJS/nodes.php?'.(empty($_SERVER['QUERY_STRING'])?'':$_SERVER['QUERY_STRING']).'&model='.urlencode($GLOBALS['_ET']['rdfsmodel']->modelURI).'&class='.get_class($this).'&autoLoadLevels='.$this->config['autoLoadLevels'].'&startNode='.urlencode($this->config['startNode']).'&node=';
		parent::powlModuleWidget($loadFiles);
	}
	function show() {
		global $_POWL;
#		$ret='<link rel="stylesheet" type="text/css" media="screen" href="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/treeviewJS/styles.css"></style>
#<SCRIPT type="text/javascript" src="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/treeviewJS/scripts.js"></SCRIPT>
$ret='
<SCRIPT id="dirjs" type="text/javascript" src="'.$this->config['getNodesScript'].urlencode($this->config['startNode']).'"></SCRIPT>
<SCRIPT language="javascript">
treeviewJS.baseURL=\''.$this->config['baseURL'].'\';
treeviewJS.target=\''.$this->config['target'].'\';
treeviewJS.autoLoadLevels='.$this->config['autoLoadLevels'].';
treeviewJS.enableNodeAttributes='.$this->config['enableNodeAttributes'].';
treeviewJS.getNodesScript=\''.$this->config['getNodesScript'].'\';
'.($this->config['startNode']!='/'?'document.write(treeviewJS.renderNode(\''.$this->config['startNode'].'\'));':'').'
</SCRIPT>
<div id="'.$this->config['startNode'].'" class="treeviewJS"></div>
<SCRIPT language="javascript">
treeviewJS.printNode(\''.$this->config['startNode'].'\',\'\');
if(powl.getState(\'treeview\',\'selected\')) {
	treeviewJS.select(powl.getState(\'treeview\',\'selected\'));
	frame=parent.frames[treeviewJS.target?treeviewJS.target:\'details\'];
	if(frame && document.getElementById(\'tree\'+powl.getState(\'treeview\',\'selected\')) && frame.location.href!=document.getElementById(\'tree\'+powl.getState(\'treeview\',\'selected\')).href)
		frame.location.href=document.getElementById(\'tree\'+powl.getState(\'treeview\',\'selected\')).href;
}
</SCRIPT>';
		return $ret;
	}
}

class treeviewJSClasses extends treeviewJS {
	function getNode($node='') {
		static $tree,$inferedSubClasses;
		if($node) {
			if($class=$GLOBALS['_ET']['rdfsmodel']->getClass($node))
				$subclasses=method_exists($class,'listSubClassesInfered')?$class->listSubClassesInfered():$class->listSubClasses();
			else return array();
		} else $subclasses=method_exists($GLOBALS['_ET']['rdfsmodel'],'listTopClassesInfered')?$GLOBALS['_ET']['rdfsmodel']->listTopClassesInfered():$GLOBALS['_ET']['rdfsmodel']->listTopClasses();
		$equivalentClasses=!empty($class) && method_exists($class,'listEquivalentClassesInfered')?$class->listEquivalentClassesInfered():array();
		$childs=array();
		if(!empty($subclasses))
		foreach($subclasses as $subclass)
			$childs[$subclass->getLocalName()]=$subclass->getLocalName();
		if($this->config['enableNodeAttributes']) {
			if($class && !empty($_REQUEST['show']) && $_REQUEST['show']!='Names') {
				$labelsPlain=$class->listLabelsPlain();
				if(!empty($labelsPlain) && !empty($labelsPlain[$_REQUEST['show']]))
					$name=str_replace("'","\'",$labelsPlain[$_REQUEST['show']]);
				else
					$name=str_replace("'","\'",join(', ',array_keys($class->listPropertyValues($_REQUEST['show']))));
			}
			return array(!empty($class)?$class->getLocalName():'/',$childs,!empty($class)?$class->countInstances():'',join(',',array_keys($equivalentClasses)),$name);
		} else
			return $childs;
	}
}
class treeviewJSProperties extends treeviewJS {
	function getNode($node='') {
		if($node) {
			if($class=$GLOBALS['_ET']['rdfsmodel']->getProperty($node))
				$subclasses=$class->listSubProperties();
		} else $subclasses=$GLOBALS['_ET']['rdfsmodel']->listTopProperties();
		$childs=array();
		if(!$subclasses && !$this->config['enableNodeAttributes'])
			return array();
		else if($subclasses)
			foreach($subclasses as $subclass)
				$childs[]=$subclass->getLocalName();
		if($this->config['enableNodeAttributes'])
			return array(
				$class?$class->getLocalName():'/',
				$childs,
				method_exists($class,'listEquivalentProperties')?parray_shift(array_keys($class->listEquivalentProperties())):'',
				method_exists($class,'listInverseOf')?parray_shift(array_keys($class->listInverseOf())):''
			);
		else
			return $childs;
	}
}
class treeviewJSInstances extends treeviewJS {
	function getNode($node='') {
		$class=$GLOBALS['_ET']['rdfsmodel']->getClass($_REQUEST['uri']);
		$instance=$GLOBALS['_ET']['rdfsmodel']->getInstance($node);
		$childs=array_keys($class->findInstances(array($_REQUEST['hierarchyProperty']=>($node?$GLOBALS['_ET']['rdfsmodel']->resourceF($node):''))));
#print_r($class->findInstances(array($_REQUEST['hierarchyProperty']=>($node?$GLOBALS['_ET']['rdfsmodel']->resourceF($node):''))));
#		if($this->config['enableNodeAttributes']) {
			$name=$instance&&$_REQUEST['show']?str_replace("'","\'",join(', ',$instance->listPropertyValuesPlain($_REQUEST['show']))):'';
			return array($node?$node:'/',$childs,'','',$name);
#		} else
#			return array_keys($childs);
	}
}
class treeviewJSArray extends treeviewJS {
	function show($value) {
		$this->value=$value;
		return parent::show();
	}
	function getNode($node='') {
		function index($val,$key,&$node) {
			if($key==$node)
				$node=$val;
		}
		print_r($this->value);
		array_walk($this->value,'index',$node);
		return $node;
	}
}
?>