<?
include('../../../include.php');
pwlHTMLHeader();
#echo('<b>'.pwl_('Search:').'</b>');
$class=$_ET['rdfsmodel']->getClass($_REQUEST['uri']);
?>
<form target="instanceslist" action="<?=strstr($_SERVER['HTTP_REFERER'],'instances.php')?'../../../modules/instances/instances_show.php':'instances.php'?>">
<input type="hidden" name="uri" value="<?=$_REQUEST['uri']?>" />
<input type="hidden" name="element" value="<?=$_REQUEST['element']?>" />
<input type="hidden" name="resource" value="<?=$_REQUEST['resource']?>" />
<?
$l=array($GLOBALS['RDFS_label']->getURI()=>'Label');
#if($languages=$class->listInstanceLabelLanguages())
#	foreach($languages as $label) {
#		$labels[$label]='';
#		$l[$label]='Label ('.$label.')';
#	}

$properties=array();
foreach($class->listPropertiesUsed() as $p)
	$properties[$p->getURI()]=$p->getLocalName();

$s=new select(array('cardinalityMax'=>1,'AttributeStyle'=>'width:30%;','AttributeClass'=>'ui'));
echo($s->edit('property',empty($_REQUEST['property'])?'':$_REQUEST['property'],array_merge(array('localName'=>'Instance'),$l,$properties)));
echo($s->edit('compare',empty($_REQUEST['compare'])?'':$_REQUEST['compare'],array('exact'=>'exactly matching','starts'=>'starting with','contains'=>'containing','regex'=>'regex matching')));
?>
<input type="text" name="search" class="ui" style="width:30%;" value="<?=pwl_('Search')?>" onclick="if(this.value=='<?=pwl_('Search')?>') this.value='';" />
</form>
<? pwlHTMLFooter(); ?>