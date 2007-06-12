<?
include('../../../include.php');
pwlHTMLHeaderTree();

if(strtolower($_REQUEST['resource'])=='selectresource') {
	$t=new tab();
	$tab=!empty($_REQUEST['tab'])?$_REQUEST['tab']:'classes';
	echo($t->show(array('classes'=>'Classes','properties'=>'Properties')).'<p></p><br/>');
	echo('<script language="javascript">'.$t->name.'.onclick=\'if(tab!="'.$tab.'") document.location.href="classes.php?tab='.($tab=='classes'?'properties':'classes').'&resource='.$_REQUEST['resource'].'&element='.urlencode($_REQUEST['element']).'";\';</script>');
}

function getnav($classes) {
	$nav=array();
	foreach($classes as $cl) {
		$c=count($cl->listInstances());
		$nav[]=array($cl->getLocalName().($c?" ($c)":''),'','class.php?uri='.urlencode($cl->getURI()),!$_REQUEST[search]?getnav($cl->listSubClasses()):'');
	}
	return $nav;
}
if(!empty($_REQUEST['search'])) {
	$classes=array();
	foreach($_ET['rdfsmodel']->vocabulary['Class'] as $cl)
		$clsql.="OR object='".$cl->getURI()."'";
	$sql = "SELECT subject, predicate, object, l_language, l_datatype, subject_is, object_is
	        FROM statements
	        WHERE modelID IN (" .$_ET['rdfsmodel']->getModelIds().") AND
	          subject LIKE '%$_REQUEST[search]%' AND
	          predicate='".$GLOBALS['RDF_type']->getURI()."' AND (0 $clsql)";
	$count=pwlSessionVar($_SERVER['PHP_SELF'],'count');
	$recordSet =& $_ET['rdfsmodel']->dbConn->PageExecute($sql,$count,$_REQUEST[start]/$count+1);
	echo(pwlListHead($_REQUEST[start],$count,$recordSet->_maxRecordCount));
	while($stm=$_ET['rdfsmodel']->fetchStatementFromRecordSet($recordSet))
		$classes[]=$_ET['rdfsmodel']->classF($stm->subj->getURI());
	$t=new treeview();
	$tv='treeview';
	echo($t->show(getnav($classes)));
} else {
	$cl=$_ET['rdfsmodel']->countClasses();
	if($cl==0) echo(pwl_('No classes found!'));
	else {
		$startNodes=!empty($_REQUEST['uri'])?unserialize($_REQUEST['uri']):array('/');
		$startNodes=$startNodes==array('0'=>'0')?array('/'):$startNodes;
		foreach($startNodes as $startNode) {
			if(strtolower($_REQUEST['resource'])=='selectproperty' || (!empty($_REQUEST['tab']) && $_REQUEST['tab']=='properties'))
				$t=new treeviewJSProperties(array('autoLoadLevels'=>0,'startNode'=>$startNode));
			else {
				if($cl>5000) $t=new treeviewJSClasses(array('autoLoadLevels'=>2,'startNode'=>$startNode));
				else if($cl>500) $t=new treeviewJSClasses(array('autoLoadLevels'=>3,'startNode'=>$startNode));
				else $t=new treeviewJSClasses(array('autoLoadLevels'=>0,'startNode'=>$startNode));
			}
			$tv='treeviewJS';
			echo('<script src="scripts.js" type="text/javascript" language="javascript"></script>');
			echo("<script language=\"javascript\">modelURI='".$_ET['rdfsmodel']->baseURI."'; treeviewJS.renderNode=function(node) { setTimeout('selectResource.initialSelect(\'".$_REQUEST['element']."\');',100); return '&nbsp;");
			// show checkbox
			if(strtolower($_REQUEST['resource'])!='selectinstance')
				echo('<input name="'.$_REQUEST['element'].'" value="\'+node+\'" type="checkbox" onclick="selectResource.select(\\\''.$_REQUEST['element'].'\\\',this.checked,\\\'\'+node+\'\\\',\\\'\'+node+\'\\\')">&nbsp;');
			// show link to instances
			if((strtolower($_REQUEST['resource'])=='selectinstance' || strtolower($_REQUEST['resource'])=='selectresource') && (empty($_REQUEST['tab']) || $_REQUEST[tab]!='properties'))
				echo("<a id=\"tree'+node+'\" onclick=\"treeviewJS.select(\''+node+'\')\" href=\"instances_frame.php?model=".urlencode($GLOBALS['_ET']['rdfsmodel']->modelURI)."&element=".urlencode($_REQUEST['element'])."&uri='+node+'\" target=\"instances\">'+
					node+(n[node]&&n[node][1]>0?' ('+n[node][1]+')':'')+'</a>'");
			else
				echo('\'+node');
			echo(";}</script>");
			echo($t->show());
				echo("<script language=\"javascript\">selectResource.initialSelect('".$_REQUEST['element']."');</script>");
		}
	}
} 

pwlHTMLFooter(); ?>