<?php

/**
 *
 *
 * @version $Id: include.php 965 2007-05-01 16:35:48Z nheino $
 * @copyright 2003
 **/

global $store;
if (Zend_Registry::isRegistered('erfurt')) {
	$store = Zend_Registry::get('erfurt')->getStore();
} else {
	die('Erfurt_App object not instantiated!');
}

function pwlLogTablesCreate() {
	global $store;
	$tables=array(
		'log_statements'=>array(
			'fields'=>'
				id			INTEGER	AUTO KEY,
				subject		C(255)	NOTNULL,
				predicate		C(255)	NOTNULL,
				object			B,
				l_language	C(255),
				l_datatype	C(255),
				subject_is	C(1)	NOTNULL,
				object_is	C(1)	NOTNULL,
				ar			C(1)	NOTNULL,
				action_id	I		NOTNULL',
			'options'=>'',
			'indexes'=>array('action_id'),
		),
		'log_actions'=>array(
			'fields'=>'
				id			INTEGER	AUTO KEY,
				parent_id	I,
				model_id	I		NOTNULL,
				user		C(255)	NOTNULL,
				date		T		NOTNULL,
				descr_id	I		NOTNULL,
				subject		C(255),
				details		B',
			'options'=>'',
			'indexes'=>array('model_id','parent_id','user'),
		),
		'log_action_descr'=>array(
			'fields'=>'
				id			INTEGER	AUTO KEY,
				description	C(255)	NOTNULL',
			'options'=>'',
			'indexes'=>array('description'),
		)
	);
	$dict=NewDataDictionary($store->dbConn);
	foreach($tables as $tablename=>$table) {
		$dict->ExecuteSQLArray($dict->CreateTableSQL($tablename,$table['fields'],$table['options']));
		foreach($table['indexes'] as $indexname=>$index)
			$dict->ExecuteSQLArray($dict->CreateIndexSQL(is_numeric($indexname)?'idx_'.str_replace('_','',$tablename).'_'.strtr($index,array('_'=>'',','=>'')):$indexname,$tablename,$index));
	}
}
function pwlLogTablesDrop() {
	global $store;
	$dict=NewDataDictionary($store->dbConn);
	$dict->ExecuteSQLArray($dict->DropTableSQL('log_actions'));
	$dict->ExecuteSQLArray($dict->DropTableSQL('log_statements'));
	$dict->ExecuteSQLArray($dict->DropTableSQL('log_action_descr'));
}
function pwlLogRollback($actionId, &$m) {
	$m->dbConn->StartTrans();
	$m->logStart('Rollback action',$actionId);
	if ($rs = $m->dbConn->execute("
		SELECT ls.subject, ls.predicate, ls.object, l_language, l_datatype, subject_is, object_is, ar, action_id
			FROM log_statements ls
			INNER JOIN log_actions ON (action_id=log_actions.id)
			WHERE action_id = '$actionId' OR parent_id = '$actionId' 
			ORDER BY date DESC")) {
#		print_r($rs);
		
		while(1 && $rs) {
			if($rs->fields[8]!=$actionId) {
				if(!pwlLogRollback($rs->fields[8],$m))
					return false;
				while($rs->fields[8]!=$actionId && $rs->moveNext());
			}
			$ar=$rs->fields[7];
			if(!$stm=$m->fetchStatementFromRecordSet($rs))
				break;
			$f=$m->find($stm->subj,$stm->pred,$stm->obj);
			if($ar=='r') {
				if(!$f->triples)
					$m->add($stm);
				else {
					echo('Rollback failed: Statement exists!');
					$m->dbConn->CompleteTrans(false);
					return false;
				}
			} else {
				if($f->triples)
					$m->remove($stm);
				else {
					echo('Rollback failed: Statement does not exists!');
					$m->dbConn->CompleteTrans(false);
					return false;
				}
			}
		}		
	}
	$m->logEnd();
	$m->dbConn->CompleteTrans();
}
function pwlLogRollbackMultiple($actionIds) {
	global $store;
	foreach($store->dbConn->GetAll("SELECT modelURI,id FROM log_actions
			INNER JOIN models ON(model_id=modelID) WHERE id IN (".join(',',$actionIds).")
			ORDER BY modelURI,date DESC") as $row)
		$models[$row[0]][]=$row[1];
	foreach($models as $modelURI=>$actions) {
		$m=$store->getModel($modelURI);
		if(count($actions)>1)
			$m->logStart('Rollback actions',join(',',$actions));
			
		foreach ($actions as $action) {
			pwlLogRollback($action, $m);
		}
		if(count($actions)>1)
			$m->logEnd();
	}
}

function pwlNodeShow($node, $baseURI) {
	if (!is_a($node, 'Node')) {
		$node = new RDFSResource($node, $GLOBALS['_ET']['rdfsmodel']);
	}
	if (is_a($node, 'Literal')) {
		$ret = $node->getLabel() . sprintf(' ( Language: %s, Datatype: %s)', 
				                           $node->getLanguage() ? $node->getLanguage() : '-', 
				                           $node->getDatatype() ? $node->getDatatype() : '-');
	} else {
		$ret = $node->getLocalName();
	}
	return $ret;
}

function pwlLogRenderAction($id,$description,$subject,$details,$modelId,$baseURI,&$mayRolledBack) {
	global $store;
	$ret='<img src="'.Zend_Registry::get('config')->erfurtPublicUri.'images/tree/cornerplus.gif" valign="absmiddle" onclick="this.src=this.src.replace(\'plus\',\'minus\').replace(\'minus\',\'plus\'); powl.toggleVisibility(\'ver'.++$GLOBALS['i'].'\')"><b>'.$description.':</b>&nbsp;<i>'.$subject.'</i><br />'.
	$details.'<div id="ver'.$GLOBALS['i'].'" style="display:none; margin-left:19px;">
	<table style="border:solid black 1px; border-spacing:0px; width:100%;">';
	$sql="SELECT ls.*,s.modelID FROM log_statements ls
			LEFT JOIN statements s ON(s.modelID='$modelId' AND ls.subject=s.subject AND ls.predicate=s.predicate AND ls.object=s.object AND ls.l_language=s.l_language AND ls.l_datatype=s.l_datatype AND ls.subject_is=s.subject_is AND ls.object_is=s.object_is)
		WHERE action_id='$id' GROUP BY ls.id ORDER BY ar";
		// echo $sql;
	foreach($store->dbConn->getAll($sql) as $stm) {
		// print_r($stm);
		$ret.='<tr><td>'.($stm[8]=='a'?'+':'-').'</td>'.
				($_REQUEST['filter']['resource']?'':'<td style="background-color:#eaeaea"><a href="'.pwlURLParamReplace('filter[resource]',str_replace('#','%23',$stm[1])).'">'.pwlNodeShow($stm[1],$baseURI).'</a></td>').'
				<td style="background-color:#eaeaea"><a href="'.pwlURLParamReplace('filter[resource]',str_replace('#','%23',$stm[2])).'">'.pwlNodeShow($stm[2],$baseURI).'</a></td>
				<td style="background-color:#eaeaea"><a href="'.pwlURLParamReplace('filter[resource]',str_replace('#','%23',$stm[3])).'">'.pwlNodeShow($stm[3],$baseURI).'</a></td></tr>';
		// ar = 'r' + modelID || ar = 'a' + !modelID
		if(($stm[8]=='r' && $stm[10]) || ($stm[8]=='a' && !$stm[10]))
			$mayRolledBack=false;
	}
	$ret.='</table>';
	foreach($store->dbConn->getAll("SELECT la.id,description,subject,details FROM log_actions la INNER JOIN log_action_descr lad ON(lad.id=descr_id) WHERE parent_id='$id'") as $row)
		$ret.=pwlLogRenderAction($row[0],$row[1],$row[2],$row[3],$modelId,$baseURI,$mayRolledBack);
	$ret.='</div>';
	return $ret;
}

function pwlLogListEntries($filter=array(),$start=0,$count=0,$erg=0) {
	global $store;
	if($filter) foreach($filter as $key=>$val) if($val) {
		switch($key) {
			case 'date':
				$search.=" AND date LIKE '$val%'";
				break;
			case 'model':
				$search.=" AND modelURI='$val'";
				break;
			case 'user':
				$search.=" AND user='$val'";
				break;
			case 'resource':
				$join=" INNER JOIN log_statements s ON (s.action_id=la.id)";
				$search.=" AND (s.subject='$val' OR s.predicate='$val' OR s.object='$val')";
				$group=" GROUP BY la.id";
				break;
		}
	}
	$sql='SELECT la.id,date,user,modelURI,description,modelID,la.subject,details FROM log_actions la '.$join.'
			INNER JOIN models ON(model_id=modelID)
			INNER JOIN log_action_descr lad ON (lad.id=descr_id)
		WHERE ISNULL(parent_id)'.$search.$group.' ORDER BY date DESC';
#$store->dbConn->SetFetchMode(ADODB_FETCH_ASSOC);
	$res=$store->dbConn->pageExecute($sql,$count,$start/$count+1);
	$erg=$res->_maxRecordCount?$res->_maxRecordCount:$res->_numOfRows;
	return $res;
}
?>