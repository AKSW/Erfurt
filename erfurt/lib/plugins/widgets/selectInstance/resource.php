<?php
/**
 * instance selection widget
 * 
 * @package POWL-Widgets
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: resource.php 435 2004-08-11 18:17:54Z soerenauer $
 * @access public
 **/

include('../../../include.php');

$uri=$_REQUEST['uri'];
if($_ET['rdfsmodel']->getInstance($uri))
	include('../../../modules/instances/instance.php');
else if($_ET['rdfsmodel']->getClass($uri))
	include('../../../modules/classes/class.php');
else if($_ET['rdfsmodel']->getProperty($uri))
	include('../../../modules/properties/property.php');
else {
	pwlHTMLHeader();
?>
<h1>Resource Not Found</h1>
A resource with URI "<?=$uri?>" was not found in the currently selected model "<?=$_ET['rdfsmodel']->modelURI?>"!<br />
Would you like to create a new:
<ul>
	<li><a href="../../../modules/classes/class.php?uri=<?=$uri?>">Class</a></li>
	<li><a href="../../../modules/properties/property.php?uri=<?=$uri?>">Property</a></li>
	<li>Instance of class:
<?
$tv=new treeViewJSClasses(array('baseURL'=>'../../../modules/instances/instance.php?uri='.urlencode($uri).'&class='));
?>
<script language="javascript">
treeviewJS.renderNode=function(node) {
	return '<a href="'+this.baseURL+node+'">'+node+'</a>';
}
</script>
<?=$tv->show()?>
	</li>
</ul>
with that URI? Or view <a href="<?=$uri?>">"<?=$uri?>"</a> on the web?
<?
	pwlHTMLFooter();
}
?>