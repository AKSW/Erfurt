<?php

include('../../include.php');
pwlHTMLHeader();

if(!empty($_REQUEST['uri'])) 
{
	$instance=$_ET['rdfsmodel']->getInstance($_REQUEST['uri']);
	if(empty($_REQUEST["class"]) || !$class=$_ET['rdfsmodel']->getClass($_REQUEST["class"]))
	{
		$class=$instance->getClass('http://powl.sf.net/WCMS/Structure/0.1#PageInstanceOverview');		
	}
} 
else 
{
	$class=$_ET['rdfsmodel']->getClass('http://powl.sf.net/WCMS/Structure/0.1#PageInstanceOverview');
	$instance=new $_ET['rdfsmodel']->instance(empty($_REQUEST['name'])?$_ET['rdfsmodel']->getUniqueResourceURI('Instance'):$_REQUEST['name'],$class->model,$_ET['rdfsmodel']);
}

$editable=$powl->aclCheck('Edit',$_ET['rdfsmodel'])&&$instance->getNamespace()==$_ET['rdfsmodel']->getBaseURI()?true:false;

if($_SERVER['REQUEST_METHOD']=='POST') 
{

	$_site	= new site($_SESSION['PWL']['cms']['language']);

	if(!$editable) pwlDeny();
	
	// new instance for class
	if($_REQUEST['name'] && !$_REQUEST['uri']) 
	{		
		$class->addInstance($_REQUEST['name']);		
	} 
	else 
	{
		if($_REQUEST['name']!=$instance->getLocalName())
			$instance->rename($_REQUEST['name']);		
	}	
	

	//ADDING STRUCTURE INFOS    

	$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Structure/0.1#pageIsLinkable');
	$instance->setPropertyValue($prop,$_REQUEST['pageIsLinkable']);

	$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Structure/0.1#pageWorkflowStatus');
	$instance->setPropertyValue($prop,$_REQUEST['pageWorkflowStatus']);

	// calculate child and position		
	if($_REQUEST['pageRelationType']=='pageChildOf')
	{
		$children 	= $_site->listNaviElements($_REQUEST['pageRelationElement']);
		$lastElement    = $children[0];
		$position	= $lastElement->getPropertyValuePlain('http://powl.sf.net/WCMS/Structure/0.1#pagePosition');
		$pagePosition	= ($position/2);
		$pageChildOf	= $_REQUEST['pageRelationElement'];
	}
	else
	{
		$pageChildOf	= $_site->getNodeParent($_REQUEST['pageRelationElement']);
		$children 	= $_site->listNaviElements($pageChildOf);
		$relationInstance = $_ET['rdfsmodel']->instanceF($_REQUEST['pageRelationElement']);
		
		for($i=0;$i<count($children);$i++)
		{
			if($children[$i]->getLocalName()==$relationInstance->getLocalName())
			{
				if(!empty($children[$i+1]))
				{
					$nextRelationInstance = $children[$i+1];
					$nextPosition 	  = $nextRelationInstance->getPropertyValuePlain('http://powl.sf.net/WCMS/Structure/0.1#pagePosition');
					$relationPosition = $relationInstance->getPropertyValuePlain('http://powl.sf.net/WCMS/Structure/0.1#pagePosition');
				}
				else
				{
					$relationPosition = $relationInstance->getPropertyValuePlain('http://powl.sf.net/WCMS/Structure/0.1#pagePosition');
					$nextPosition 	  = (2*$relationPosition);				
				}
				$pagePosition = ($nextPosition+$relationPosition)/2;
			}
		}	
	}
	
	// only if childOf is given
	if(!empty($pageChildOf))
	{
		$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Structure/0.1#pageChildOf');
		$instance->setPropertyValue($prop,'http://powl.sf.net/WCMS/AisSite/0.1#'.$pageChildOf);
	}
	
	$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Structure/0.1#pagePosition');
	$instance->setPropertyValue($prop,($pagePosition+0));

    
    
	// Content-instance already exists?	
	if(!empty($_POST['pageContent']))
	{
		// get old literal values
		$inst = $_ET['rdfsmodel']->instanceF($_POST['pageContent']);
		$_tmpClass = $_ET['rdfsmodel']->getClass('http://powl.sf.net/WCMS/Content/0.1#Content');
		$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Content/0.1#ContentDetail');
		$cont=$inst->listLiteralPropertyValues($prop);
		foreach($cont as $c)
		{			
			if($c->getLanguage()!=$_SESSION['PWL']['cms']['language'])
				$values[]=$c;
		}
	}
	// create new content instance
	else
	{		
		$contentInstanceName=$instance->getLocalName().'Content';
		$_tmpClass = $_ET['rdfsmodel']->getClass('http://powl.sf.net/WCMS/Content/0.1#Content');	
		$inst = $_ET['rdfsmodel']->instanceF($contentInstanceName);
		$_tmpClass->addInstance($inst);
	}

	// create literal value
	$_tmpClass = $_ET['rdfsmodel']->getClass('http://powl.sf.net/WCMS/Content/0.1#Content');
	$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Content/0.1#ContentDetail');
	$label = new Literal($inst->getLocalName(),$_ET['rdfsmodel']);
	$label->setDatatype('http://www.w3.org/2001/XMLSchema#string');		
	$label->setLanguage($_SESSION['PWL']['cms']['language']);		
	$label->label=$_POST['prop']['http://powl.sf.net/WCMS/Content/0.1#ContentDetail'];
	// save old and NEW literal values
	$values[]=$label;
	$inst->setPropertyValues($prop,$values,true);

	// set reference to content instance
	if($contentInstanceName)
	{
		$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Structure/0.1#pageContent');
		$instance->setPropertyValues($prop,'http://powl.sf.net/WCMS/Content/0.1#'.$contentInstanceName);
	}

	// set page instance list
	$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Structure/0.1#pageInstanceList');
	$instance->setPropertyValues($prop,$_POST['prop']['http://powl.sf.net/WCMS/Structure/0.1#pageInstanceList']);


	// save metainformations for instance
	// instance label will be written in the lines after
	pwlResourceMetaProcess($instance);
	
	
	if($_REQUEST['pageTitle'])
	{
		$instance->setLabel($_REQUEST['pageTitle'],$_SESSION['PWL']['cms']['language']);
	}
	
	
	echo('<script language="javascript">parent.frames[\'tree\'].document.location.href="tree.php";</script>');
}

if(!empty($_REQUEST['action']) && $_REQUEST['action']=='remove') 
{
	if(!$editable)
		pwlDeny();
	//$instance->model->logStart('Instance removed',$instance->getLocalName(),$_POST['versioningDetails']);
	$instance->remove();	
	echo('<script language="javascript">parent.frames[\'tree\'].document.location.href="tree.php";</script>');
	echo('<script language="javascript">parent.frames[\'details\'].document.location.reload();document.location.href="cms.php?class='.urlencode($_REQUEST['class']).'";</script>');	
}



// /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
// START OUTPUT
// /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
$_site=new site($_SESSION['PWL']['cms']['language']);
$instance_properties = $instance->listAllPropertyValuesPlain();
$pageChildOf 	     = $instance_properties['structure:pageChildOf'][0];


if(strstr($pageChildOf,'#'))
{
	$tmp=explode('#',$pageChildOf);
	$pageChildOf=$tmp[1];
}
$children 		= $_site->listNaviElements($pageChildOf);
$pagePosition 		= $instance_properties['structure:pagePosition'][0];
$pageContent 		= $instance_properties['structure:pageContent'][0];
$pageIsLinkable 	= ($instance_properties['structure:pageIsLinkable'][0]+0);
$pageInstanceList 	= $instance_properties['structure:pageInstanceList'];
$pageWorkflowStatus 	= $instance_properties['structure:pageWorkflowStatus'][0];

// initialize for new page
if(!$instance_properties['structure:pageIsLinkable'][0])
{
	$pageIsLinkable=1;
}
if(!strlen($pageWorkflowStatus))
{
	$pageWorkflowStatus='Approved';
}

// calculate relation element and relation type
$pageRelationType	= 'pageSibling';
$pageRelationElement	= $_REQUEST['pageRelationElement'];
for($i=0;$i<count($children);$i++)
{
	if($children[$i]->getLocalName()==$instance->getLocalName())
	{
		if($i==0)
		{
			// child of parent, position egal
			$pageRelationElement 	= $pageChildOf;
			$pageRelationType 	= 'pageChildOf';
		}
		else
		{
			// child of $i-1
			$pageRelationElement 	= $children[$i-1]->getLocalName();
			$pageRelationType 	= 'pageSibling';
		}
	}
}


$_pageContent=explode(':',$pageContent);
if(!empty($_pageContent[1]))
{
	$pageContent=$_pageContent[1];
}

?>
<h1><?= pwl_("pOWL WCMS") ?>&nbsp;/&nbsp;<?php

$node_name=$instance->getLabelForLanguage($_SESSION['PWL']['cms']['language']);
if($node_name->label)
	echo $node_name->label;
else
	echo $instance->getLocalName();


?>&nbsp;&nbsp;[<?php echo $_SESSION['PWL']['cms']['language']; ?>]</h1>


<form method="POST">
<input type="hidden" name="action" value=""/>
<input type="hidden" name="uri" value="<?=!empty($_REQUEST['uri'])?$_REQUEST['uri']:''?>"/>
<input type="hidden" name="name" value="<?=$instance->getLocalName()?>" style="font-weight:bold; width:400px;" onkeyup="this.value=this.value.replace(/[^a-z0-9-_]/gi,'');"<?=$editable?'':' readonly="readonly"'?>>
<input type="hidden" name="pageChildOf" value="<?php echo $pageChildOf; ?>">
<input type="hidden" name="pagePosition" value="<?php echo $pagePosition; ?>">
<input type="hidden" name="clanguage" value="<?php echo $_SESSION['PWL']['cms']['language']; ?>">
<input type="hidden" name="pageContent" value="<?php echo $pageContent; ?>">

<table>
<tr bgcolor="#ffffff">
  <td colspan="2" style="background-color: #ffffff;"><br /><h2>Structure</h2></td>
</tr>
<tr valign="top">
  <td align="right"><b><?= pwl_("Page Title") ?></b></td>
  <td><input type="text" name="pageTitle" value="<?php echo $instance->getLabelForLanguage($_SESSION['PWL']['cms']['language']); ?>"></td>
</tr>
<tr valign="top">
  <td align="right"><b><?= pwl_("Insert after") ?></b></td>
  <td><select name="pageRelationElement">
  	<option value="Startseite"><?= pwl_("Homepage") ?></option><?php
// ------------------------------------------------------  		
	$nodes=$_site->listNaviElements();	
	foreach($nodes as $_node)
	{
		
		$_node_name=$_node->getLabelForLanguage($_SESSION['PWL']['cms']['language']);
		if(!$node_name) $_node_name = $_node->getLocalName();
		$tmp='';
					
		
		if($_node->getLocalName()!=$instance->getLocalName())
		{
			$sel='';
			if($_node->getLocalName()==$pageRelationElement)
			{
				$sel=' SELECTED';
			}
		
			echo '<option value="'.$_node->getLocalName().'"'.$sel.'>'.$_node_name.'</option>';		
		}
		
		
		$sub_nodes = $_site->listNaviElements($_node->getLocalName());
		foreach($sub_nodes as $_sub)
		{
			$_sub_name=$_sub->getLabelForLanguage($_SESSION['PWL']['cms']['language']);						
			if(!$_sub_name) $_sub_name = $_sub->getLocalName();
						
			if($_sub->getLocalName()!=$instance->getLocalName())
			{
				$sel='';
				if($_sub->getLocalName()==$pageRelationElement)
				{
					$sel=' SELECTED';
				}
			
				echo '<option value="'.$_sub->getLocalName().'"'.$sel.'>&nbsp;&nbsp;'.$_sub_name.'</option>';
			}
		}
	}
// ------------------------------------------------------  	
  ?></select></td>
</tr>
<tr valign="top">
  <td align="right"><b><?= pwl_("as") ?></b></td>
  <td><input type="radio" name="pageRelationType" value="pageChildOf" <?php if($pageRelationType=='pageChildOf') echo 'CHECKED'?>><?= pwl_("Child") ?>&nbsp;&nbsp;<input type="radio" name="pageRelationType" value="pageSibling" <?php if($pageRelationType=='pageSibling') echo 'CHECKED'?>><?= pwl_("Sibling") ?>&nbsp;&nbsp;</td>
</tr>  
<tr valign="top">
  <td align="right"><b><?= pwl_("Hide") ?></b></td>
  <td><input type="radio" name="pageIsLinkable" value="0" <?php if(!$pageIsLinkable) echo 'CHECKED'; ?>><?= pwl_("Yes") ?>&nbsp;&nbsp;<input type="radio" name="pageIsLinkable" value="1"  <?php if($pageIsLinkable) echo 'CHECKED'; ?>><?= pwl_("No") ?>&nbsp;&nbsp;</td>
</tr>
<tr valign="top">
  <td align="right"><b><?= pwl_("Workflow") ?></b></td>
  <td><input type="radio" name="pageWorkflowStatus" value="Approved" <?php if($pageWorkflowStatus=='Approved') echo 'CHECKED'; ?>><?= pwl_("Approved") ?>&nbsp;&nbsp;<input type="radio" name="pageWorkflowStatus" value="In Process" <?php if($pageWorkflowStatus=='In Process') echo 'CHECKED'; ?>><?= pwl_("In Process") ?>&nbsp;&nbsp;<input type="radio" name="pageWorkflowStatus" value="Submitted" <?php if($pageWorkflowStatus=='Submitted') echo 'CHECKED'; ?>><?= pwl_("Submitted") ?>&nbsp;&nbsp;</td>
</tr>
<tr bgcolor="#ffffff">
  <td colspan="2" style="background-color: #ffffff;"><br /><h2>Content</h2></td>
</tr>
<tr valign="top">  
  <td colspan="2"><b><?= pwl_("Instance overview") ?></b><br /><?php
// --------------------------------------------------------
$_tmpClass = $_ET['rdfsmodel']->getClass('http://powl.sf.net/WCMS/Structure/0.1#PageInstanceOverview');
$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Structure/0.1#pageInstanceList');
echo pwlGetWidget($_tmpClass,$prop,$pageInstanceList);
// --------------------------------------------------------
  ?></td>
</tr>
<tr valign="top">  
  <td colspan="2"><b><?= pwl_("Page content") ?></b><br /><?php
// --------------------------------------------------------

if(!empty($pageContent))
{		
	$inst = $_ET['rdfsmodel']->instanceF('http://powl.sf.net/WCMS/AisSite/0.1#'.$pageContent);		
	$pageContent = array();
	$pageContent[] = $inst->getPropertyValuePlain('http://powl.sf.net/WCMS/Content/0.1#ContentDetail');

}  
$_tmpClass = $_ET['rdfsmodel']->getClass('http://powl.sf.net/WCMS/Content/0.1#Content');
$prop = $_ET['rdfsmodel']->propertyF('http://powl.sf.net/WCMS/Content/0.1#ContentDetail');
$cont=$inst->listLiteralPropertyValuesPlain($prop,$_SESSION['PWL']['cms']['language']);

echo pwlGetWidget($_tmpClass,$prop,$cont);
// --------------------------------------------------------
  ?></td>
</tr>  

</table>
<?php

// meta-data
echo pwlResourceMetaShow($instance,false);
echo '<br />';

// versioning and editing, if allowed
if($editable) 
{ 
	echo pwlResourceVersioning($instance);
	echo '<br />';
	echo '<INPUT type="submit" value="'. pwl_("Save changes") .'" onclick="powl.wait(this)" />';
	echo '<br />';
} 
echo '</form>';
pwlHTMLFooter();
?>