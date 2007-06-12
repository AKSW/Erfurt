<?
include('../../../include.php');
pwlHTMLHeader();
echo('<h2>'.pwl_('Instances').'</h2>');

#$uris=unserialize($_REQUEST['uri']);
$uri=$_REQUEST['uri'];
function getnav($classes) {
	foreach($classes as $cl) {
		$labelsPlain=$cl->listLabelsPlain();
		$name=$_REQUEST['show']&&$labelsPlain[$_REQUEST['show']]?$labelsPlain[$_REQUEST['show']]:$cl->getLocalName();
		$nav[]=array($name,'','instance.php?uri='.urlencode($cl->uri).'&class='.urlencode($uri),'','instance');
	}
	return $nav;
}
if($class=$_ET['rdfsmodel']->getClass($uri)) {
	// determine what to show
	if(!$_REQUEST['show']=pwlSessionVar($class->getURI(),'InstancesList','show'))
		foreach($class->listSuperClassesRecursive() as $superclass)
			if($_REQUEST['show']=pwlSessionVar($superclass->getURI(),'InstancesList','show'))
				break;
	if($_REQUEST['show'])
		$_SERVER['QUERY_STRING']=$_SERVER['QUERY_STRING'].'&show='.$_REQUEST['show'];

	if($languages=$class->listInstanceLabelLanguages()) {
		$show=array('Names'=>pwl_('Names'));
		foreach($languages as $l)
			$show[$l]="Labels ($l)";
		$show=array_merge($show,pwlArrayCopyValues2Indexes(array_keys($class->listPropertiesUsed())));
		$s=new select(array('cardinalityMax'=>1,'onchange'=>'this.form.submit()','AttributeClass'=>'ui'));
		echo('<form><input type="hidden" name="search" value="'.$_REQUEST['search'].'" /><input type="hidden" name="property" value="'.$_REQUEST['property'].'" /><input type="hidden" name="compare" value="'.$_REQUEST['compare'].'" />'. pwl_('Show').': <input type="hidden" name="element" value="'.$_REQUEST['element'].'"><input type="hidden" name="uri" value="'.$_REQUEST['uri'].'">'.$s->edit('show',$_REQUEST['show'],$show).'</form>');
	}
	$count=pwlSessionVar($_SERVER['PHP_SELF'],'count');
	$start=empty($_REQUEST['start'])?0:$_REQUEST['start'];
#print_r(empty($_REQUEST['search'])?array():array($_REQUEST['property']=>$_REQUEST['search']).$_REQUEST['compare']);
	if($instances=$class->findInstances(empty($_REQUEST['search'])?array():array($_REQUEST['property']=>$_REQUEST['search']),empty($_REQUEST['compare'])?'':$_REQUEST['compare'],$start,$count,&$erg)) {	
		echo(pwlListHead($start,$count,$erg));
		$name=$_REQUEST['element'];
		echo('<script src="scripts.js" type="text/javascript" language="javascript"></script>');
		foreach($instances as $instance) {
			echo('<input name="'.$name.'" value="'.$instance->getLocalName().'" type="checkbox" onclick="selectResource.select(\''.$name.'\',this.checked,\''.($_SESSION['_ETS']['model']==$_ET['rdfsmodel']->modelURI?$instance->getLocalName():$instance->getURI()).'\',\''.$instance->getLocalName().'\')">');
			if(!empty($_REQUEST['show']) && $labelsPlain=$instance->listLabelsPlain())
				echo($labelsPlain[$_REQUEST['show']]?$labelsPlain[$_REQUEST['show']]:$instance->getLocalName());
			else echo($instance->getLocalName());
			echo('<br />');
		}
		echo('<script language="javascript">selectResource.initialSelect(\''.$name.'\');</script>');
	} else echo('<p />'.pwl_('No instances found!'));
} else echo(pwl_('<p />'.'No instances found!'));
pwlHTMLFooter();
?>