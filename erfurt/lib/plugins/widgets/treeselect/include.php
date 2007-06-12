<?php
/**
 * treeselect widget
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: include.php 276 2004-05-28 17:23:27Z soerenauer $
 * @access public
 **/
class treeselect extends powlModuleWidget {
	var $saveConfig=array(
		sqlStorageFieldTypes=>array('text','varchar'),
		separator=>',',
	);
	var $showConfig=array();
	var $editConfig=array(
		multi=>true,
		width=>250,
		height=>200,
		overflow=>'',
	);
	
	// returns
	function show($value,$name=false,$config=false) {
		return join($this->saveConfig[separator],$value);
	}

	function tree_recurse($name,$node,&$value,&$subselected) {
		static $id;
		foreach($this->treeGetChildNodes($node) as $key=>$val) {
			if(in_array($key,$value)) $subselected=true;
			$childs.=$this->treeGetChildNodes($key)?$this->tree_recurse($name,$key,$value,$subselected):'';
			$ret.="['$key','".join('\',\'',$val)."',".(in_array($key,$value)?'1':'0').'],';
		}
		return "_tree['$name']['".($node?$node:'__cxroot')."']=[$ret];\n".$childs;
	}

	function edit($name,$value=array(),$config=false) {
		$value=is_array($value)?$value:array($value=>$value);
		return (!$this->editConfig[multi]?'<input type="text" name="'.$name.'" value="'.array_shift($value).'" readonly>':'<textarea id="__cxtreeview'.$name.'" readonly="readonly">'.join("\n",$value)."\n".'</textarea>').'&nbsp;<input type="button" onclick="powl.addEvent(document, \'mousedown\', treeselect.treeHide); powl.toggleVisibility(\'__'.$name.'tree\')" value="..."><br />'.
			"<div id=\"__".$name."tree\" name=\"__cxtree\" class=\"treeselect\" style=\"width:".$this->editConfig[width]."; height:".$this->editConfig[height]."; overflow:".$this->editConfig[overflow]."; display:none\">".
			'<link rel="stylesheet" type="text/css" media="screen" href="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/treeselect/styles.css"></style>'.
			'<script language="javascript" src="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/treeselect/scripts.js"></script>
			<script language="javascript" src="'.$GLOBALS['_POWL']['uriBase'].'plugins/widgets/treeview/scripts.js"></script>
			<script language="javascript">
				pwlbase=\''.$GLOBALS['_POWL']['uriBase'].'\';
				_tree=new Array();
				_tree["'.$name.'"]=new Array();
				'.$this->tree_recurse($name,'',array_keys($value),$subselected).'
				document.write(treeselect.treeRecurse(_tree["'.$name.'"],"__cxroot","'.$name.'",0,"",'.($this->editConfig[multi]?'true':'false').'));
			</script>
			</div>';
	}
	function save($value,$name,$config=false) {
		return join($this->saveConfig[separator],$value);
	}
}

class treeselectClasses extends treeselect {
	function treeselectClasses($model='') {
		$this->model=$model?$model:$GLOBALS['_ET']['rdfsmodel'];
	}
	function edit($name,$value=array(),$config=false) {
		$value=is_array($value)?$value:array($value=>$value);
		$vals=array();
		foreach($value as $val=>$n) {
			$v=new Resource($val);
			$vals[$val]=$v->getLocalName();
		}
		return parent::edit($name,$vals,$config);
	}
	function treeGetChildNodes($node='') {
		if($node=='')
			$cls=$this->model->listTopClasses();
		else {
			$class=$this->model->getClass($node);
			if($class) $cls=$class->listSubClasses();
		}
		$ret=array();
		if($cls) foreach($cls as $cl)
			$ret[$cl->getURI()]=array($cl->getLocalName());
		return $ret;
	}
}
class treeselectClass extends treeselectClasses {
}
class treeselectProperty extends treeselect {
	function treeselectProperty($model='') {
		$this->model=$model?$model:$GLOBALS['_ET']['rdfsmodel'];
	}
	function edit($name,$value=array(),$config=false) {
		$value=is_array($value)?$value:array($value=>$value);
		$vals=array();
		foreach($value as $val) {
			$v=new Resource($val);
			$vals[$val]=$v->getLocalName();
		}
		return parent::edit($name,$vals,$config);
	}
	function treeGetChildNodes($node='') {
		if($node=='')
			$cls=$this->model->listTopProperties();
		else {
			$class=$this->model->getProperty($node);
			if($class) $cls=$class->listSubProperties();
		}
		$ret=array();
		if($cls) foreach($cls as $cl)
			$ret[$cl->getURI()]=array($cl->getLocalName());
		return $ret;
	}
}
/*
class treeselectDirectories extends treeselect {
	function treeGetChildNodes($node='',$level=0) {
		$ret=array();
		$dir="$GLOBALS['installPath']$node";
		if(is_dir($dir)) {
			$handle = opendir($dir);
			while(false!==($file=readdir($handle)))
				if($file!="." && $file!=".." && is_dir($dir.$file) && !cxPatternMatch($dir.$file) && cxFilePrivileg($node.$file,'read'))
					$ret[$node.$file.'/']=array($file);
		}
		return $ret;
	}
}*/
?>