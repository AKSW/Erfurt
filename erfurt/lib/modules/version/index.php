<?
/**
 * RDF versioning viewer.
 *
 * @package POWL
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: index.php 559 2006-09-11 18:44:05Z soerenauer $
 **/

include('../../include.php');
include_once('./include.php');
pwlHTMLHeader();

switch(!empty($_REQUEST['action'])?$_REQUEST['action']:'') {
	case 'tablesdrop':
		pwlLogTablesDrop();
		break;
	case 'tablescreate':
		pwlLogTablesCreate();
		break;
	case 'deletebefore':
		foreach($GLOBALS['_ET']['store']->dbConn->getAll("SELECT * FROM log_actions INNER JOIN models ON(model_id=modelID)
			WHERE date<'".str_pad(str_replace('/','-',$_REQUEST['date']),'0')."%' ".($_REQUEST['model']?"AND modelURI='$_REQUEST[model]' ":'')."ORDER BY date ASC") as $row) {
			$GLOBALS['_ET']['store']->dbConn->BeginTrans();
				$GLOBALS['_ET']['store']->dbConn->execute("DELETE FROM actions WHERE id='$row[0]'");
				$GLOBALS['_ET']['store']->dbConn->execute("DELETE FROM log_statements WHERE action_id='$row[0]'");
			$GLOBALS['_ET']['store']->dbConn->CommitTrans();
			#echo("Deleting $row[0] at $row[3] <br>");
		}
		break;
	case 'rollbackafter':
		$m=$GLOBALS['_ET']['store']->getModel($_REQUEST['model']);
		$m->dbConn->StartTrans();
		$m->logStart('Rollback actions after '.$_REQUEST['date']);
		foreach($GLOBALS['_ET']['store']->dbConn->getAll("SELECT * FROM log_actions INNER JOIN models ON(model_id=modelID)
			WHERE date>'".str_pad(str_replace('/','',$_REQUEST['date']),'0')."%' ".($_REQUEST['model']?"AND modelURI='$_REQUEST[model]' ":'')."ORDER BY date ASC") as $row)
			pwlLogRollback($row[0],$m);
		$m->logEnd();
		$m->dbConn->CompleteTrans();
		break;
	default:
		if(!empty($_REQUEST['selected']))
			pwlLogRollbackMultiple($_REQUEST['selected']);
		break;
}
?>
<h1><?= pwl_("RDF Versioning") ?></h1>
<?
if($_SESSION['PWL']['user']!='Admin')
	$_REQUEST['filter']['model']=$_ET['rdfsmodel']->modelURI?$_ET['rdfsmodel']->modelURI:'none';

if(!empty($_REQUEST['filter']))
	foreach($_REQUEST['filter'] as $key=>$val)
		if($val)
			$filter.="<a href=\"".pwlURLParamReplace("filter[$key]",'')."\">$key: $val</a> | ";

$count=pwlSessionVar($_SERVER['PHP_SELF'],'count');
$start=empty($_REQUEST['start'])?0:$_REQUEST['start'];
if(!in_array($GLOBALS['_POWL']['db']['tablePrefix'].'log_action_descr',$GLOBALS['_ET']['store']->dbConn->MetaTables()))
	echo('<p>Versioning tables missing: <a href="?action=tablescreate">Create versioning tables</a>');
else {
$res=pwlLogListEntries($_REQUEST['filter'],$start,$count,&$erg);
echo(pwl_('Filter: ').$filter.'<br />'.pwlListHead($start,$count,$erg));
?>
<form name="select" method="POST">
<table class="tripletable"><tr><th><a href="javascript:powl.toggleChecked(document.forms['select'],'selected[]');">S</a></th>
	<th><?=pwl_('Nr.')?></th><th><?=pwl_('Date')?></th><?=$_REQUEST['filter']['user']?'':'<th>'.pwl_("User").'</th>' ?>
	<th><?= pwl_("Action") ?></th><th><?= pwl_("Rollback") ?></th></tr>
<?
$i=0;
foreach($res->getArray() as $row) {
	$row[1]='<a href="'.pwlURLParamReplace('filter[date]',substr($row[1],0,4)).'">'.substr($row[1],0,4).'</a>/'.
		'<a href="'.pwlURLParamReplace('filter[date]',substr($row[1],0,7)).'">'.substr($row[1],5,2).'</a>/'.
		'<a href="'.pwlURLParamReplace('filter[date]',substr($row[1],0,10)).'">'.substr($row[1],8,2).'</a>&nbsp;&nbsp;'.
		'<a href="'.pwlURLParamReplace('filter[date]',substr($row[1],0,13)).'">'.substr($row[1],11,2).'</a>:'.
		'<a href="'.pwlURLParamReplace('filter[date]',substr($row[1],0,16)).'">'.substr($row[1],14,2).'</a>:'.substr($row[1],17);
	if($_REQUEST['filter']['user'])
		unset($row[2]);
	else
		$row[2]='<a href="'.pwlURLParamReplace('filter[user]',$row[2]).'">'.$row[2].'</a>';
	if($_REQUEST['filter']['model'])
		unset($row[3]);
	else
		$row[3]='<a href="'.pwlURLParamReplace('filter[model]',str_replace('#','%23',$row[3])).'">'.$row[3].'</a>';
	$mayRolledBack=true;
	$row[4]=pwlLogRenderAction($row[0],$row[4],$row[6],$row[7],$row[5],$row[3],$mayRolledBack);
	$row[5]=$mayRolledBack?'<a onclick="if(confirm(\''.pwl_('Do you really want to rollback the selected actions?').'\')) { form=document.forms[\'select\']; form.reset(); document.getElementById(\'select\'+'.$row[0].').checked=\'true\'; form.submit();}" href="#" title="'.pwl_('Rollback this action.').'">[R]</a>':'	';
	unset($row[6],$row[7]);
	array_unshift($row,$row[5]?"<input id=\"select".$row[0]."\" type=\"checkbox\" name=\"selected[]\" value=\"".$row[0]."\">":'');
	echo(pwlListRow($row));
}
?>
<tr><th colspan="7" align="left"><img src="../../images/item_ltr.png">&nbsp;<a href="javascript:if(confirm('<?=pwl_('Do you really want to rollback the selected actions?')?>')) document.forms['select'].submit();"><?=pwl_('Rollback selected actions')?></a></th></tr>
</table>
<h3><?=pwl_('Operations')?></h3>
For model:<br />
<?
$sm=new selectModel(array('cardinalityMax'=>1,'emptyLabel'=>'All'));
echo($sm->edit('model',!empty($_REQUEST['filter']['model'])?$_REQUEST['filter']['model']:''));
?>
<p>
<input type="radio" name="action" value="rollbackafter"> <?=pwl_('Rollback all actions done after')?><br />
<input type="radio" name="action" value="deletebefore"> <?=pwl_('Delete versioning information before')?></p>
<input type="radio" name="action" value="tablesdrop"> <?=pwl_('Drop versioning tables: All versioning information will be lost!')?>
<p>Date: <? $d=new date(array('showsTime'=>true)); echo($d->edit('date')); ?></p>
<input type="submit" value="<?=pwl_('Submit')?>" onclick="powl.wait(this)" />
</form>
<?
}
pwlHTMLFooter(); ?>