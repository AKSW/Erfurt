<?
/**
 * RDFS-instance viewer and editor.
 * 
 * @package POWL
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: site.php 494 2004-11-22 22:03:46Z soerenauer $
 **/

include('../../include.php');
pwlHTMLHeader();

// set class
$class=$_ET['rdfsmodel']->getClass($_REQUEST["class"]);

if($_REQUEST['name']) {
	$instance = $class->model->instanceF($_REQUEST['name']);	
} else if($_REQUEST['uri']) {
	$m=$class?$class->model:$_ET['rdfsmodel'];
	$instance=$m->instanceF($_REQUEST['uri']);
	if(!$class->getLocalName()) $class=$instance->getClass();
} else {
	$instance=$_ET['rdfsmodel']->instanceF($_ET['rdfsmodel']->getUniqueResourceURI('Instance'));
}

if($_SERVER[REQUEST_METHOD]=='POST') {
	// new instance for class
	if($_REQUEST['name'] && !$_REQUEST['uri']) {
		$class->addInstance($_REQUEST['name']);
		$list_location = 'instances_show.php?uri='.urlencode($_REQUEST['class']) . '&new=1';			
		$this_location = 'instance.php?uri='.urlencode($class->model->baseURI.$_REQUEST['name']).'&class='.urlencode($_REQUEST['class']);
		echo('<script language="javascript">parent.frames[\'tree\'].location.reload();</script>');
		//echo('<script language="javascript">document.location.href="'.$this_location.'";</script>');
	}
	
	// save new/modified properties
	if($_POST[prop] && $p=$class->listProperties()) {
		foreach($p as $cl)
			foreach($cl as $prop) {	
				if(!$_POST[prop][$prop->getURI()])
					$instance->removePropertyValues($prop);
				else if(is_array($_POST[prop][$prop->getURI()])) {
					$newPropertyValues=array_filter($_POST[prop][$prop->getURI()]);
					$oldPropertyValues=$instance->listPropertyValuesPlain($prop);
					foreach(array_diff($oldPropertyValues,$newPropertyValues) as $removed)
						$instance->removePropertyValues($prop,$removed);
					foreach(array_diff($newPropertyValues,$oldPropertyValues) as $added)
						$instance->addPropertyValue($prop,$added);
				} else if($instance->getPropertyValuePlain($prop)!=$_POST[prop][$prop->getURI()])
					$instance->setPropertyValue($prop,$_POST[prop][$prop->getURI()]);										
			}
	}
	// save metainformations for instance
	$instance->processInfo($_POST['lang'],$_POST['label'],$_POST['comment'],$_POST['annotationProperty'],$_POST['annotationValue']);			
}
if($_REQUEST[action]=='remove') {
	$instance->remove();
	echo('<script language="javascript">parent.frames[\'tree\'].location.reload();</script>');
}
	
?>
<h1><?= pwl_("Instance") ?></h1>
<form method="POST">
<INPUT type="hidden" name="action" value=""/>
<INPUT type="hidden" name="uri" value="<?=$_REQUEST[uri]?>"/>
<INPUT type="hidden" name="class" value="<?=$class->model->baseURI.$class->getLocalName()?>"/>
<input type="text" name="name" value="<?=$instance->getLocalName()?>" style="font-weight:bold" onkeyup="this.value=this.value.replace(/[^a-z0-9-_]/gi,'');">
<h2><img src="../../images/Properties.gif" align="absmiddle">&nbsp;<?= pwl_("Properties") ?></h2>
<table>
<tr><th><?= pwl_("Name") ?></th><th><?= pwl_("Value") ?></th></tr>
<?
if($p=$class->listProperties()) {
	foreach($p as $cl)
		foreach($cl as $prop) {
			if($_GET['pageChildOf'] && $prop->getLocalName()=='pageChildOf') {
				$propertyValue=$class->model->baseURI.$_GET['pageChildOf'];					
			} elseif($_GET['pagePosition'] && $prop->getLocalName()=='pagePosition') {
				$propertyValue=$_GET['pagePosition'];					
			} else {
				$propertyValue=$instance->listPropertyValuesPlain($prop);
			}
			echo('<tr'.($i++%2==0?' class="even"':'').'><td align="right">'.$prop->getLocalName().'</td><td>'.
			     pwlGetWidget($class,$prop,$propertyValue?$propertyValue:($_REQUEST[uri]?'':$_GET[$prop->getLocalName()])).'</td></tr>');
		}
}
else {
	echo '<tr><td colspan="2"><?= pwl_("No properties defined yet") ?></tr>';
}
?>
</table>
<?=$instance->showInfo()?>
<br />
<INPUT type="submit" value="<?= pwl_("Save changes") ?>"/>
</form>
<? pwlHTMLFooter(); ?>