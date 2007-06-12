<?php
/**
 * output js-array with subclasses of $_REQUEST[node]
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: nodes.php 428 2004-08-09 07:46:01Z soerenauer $
 * @access public
 **/

include('../../../include.php');

$treeviewJS=new $_REQUEST['class'](0,false);
function showNode($node='',$level=0) {
	static $nodes;
	if(!empty($nodes[$node]))
		return;
	else
		$nodes[$node]=true;

	$node=$GLOBALS['treeviewJS']->getNode($node);
	$nodeName=array_shift($node);
	$nodeChilds=array_shift($node);
	if(!$node && !$nodeChilds) return;
	if($_REQUEST['node']==$_REQUEST['startNode'] || $level==$_REQUEST['autoLoadLevels']) {
		$c=$nodeChilds?'[\''.join('\',\'',$nodeChilds).'\']':'';
		if($node)
			echo('n[\''.$nodeName.'\']=['.$c.',\''.join('\',\'',$node).'\'];');
		else
			echo('n[\''.$nodeName.'\']='.$c.';');
	}
	if(!$_REQUEST['autoLoadLevels'] || $level<$_REQUEST['autoLoadLevels'])
		foreach($nodeChilds as $nodeChild)
			showNode($nodeChild,$level+1);
}

showNode($_REQUEST['node']!='/'?$_REQUEST['node']:'');
if($_REQUEST['node']!='/' && $_REQUEST['autoLoadLevels']==2)
	echo('treeviewJS.plus(\''.$_REQUEST['node'].'\');');
#echo("\n".timer()."\n");
#echo('alert("'.$_REQUEST['node'].'");');
?>