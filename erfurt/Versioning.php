<?php
class Erfurt_Versioning {
	
	protected $model;
	protected $currentItem;
	
	public function __construct(Erfurt_Rdfs_Model_Abstract $model) {
		
		$this->model = $model;
		$this->currentItem = 0;
		
	}
	
	public function listEntries(Array $filter = array(), $offset = 0, $limit = 0, &$erg = 0) {
		
		$search = '';
		$join = '';
		$group = '';
		if ($filter) {
			foreach ($filter as $key=>$value) {
				if ($value) {
					switch ($key) {
						case 'date':
							$search .= ' AND date LIKE "' . $value . '"';
							break;
						case 'model':
							$search .= ' AND modelURI = "' . $value . '"';
							break;
						case 'user':
							$search .= ' AND user = "' . $value . '"';
							break;
						case 'resource':
							$join = 'INNER JOIN log_statements s ON (s.action_id = la.id)';
							$search .= ' AND (s.subject = "' . $value . '" OR s.predicate = "' . $value . '" OR s.object = "' . $value . '")';
							$group = ' GROUP BY la.id';
							break;
					}
				}
			}
		}
		
		$sql = 'SELECT la.id, date, user, modelURI, description, modelID, la.subject, details 
				FROM log_actions la ' . 
				$join . 
			   'INNER JOIN models ON (model_id = modelID)
				INNER JOIN log_action_descr lad ON (lad.id = descr_id)
				WHERE model_id = ' . $this->model->getModelID() . ' AND ISNULL(parent_id)' . $search . $group . ' ORDER BY date DESC';
				
		$result = $this->model->getStore()->getDbConn()->pageExecute($sql, $limit, ($offset/$limit+1));
		$erg = (($result->_maxRecordCount) ? $result->_maxRecordCount : $result->_numOfRows);
		return $result;
	}
	
	public function renderAction($id, $description, $subject, $details, &$mayRolledBack) {
		
		$imgSrc = Zend_Registry::get('config')->erfurtPublicUri . 'images/plus.png';
		$onClick = "if (this.src.search('plus') != -1) this.src = this.src.replace('plus', 'minus'); else this.src = this.src.replace('minus', 'plus');
					powl.toggleVisibility('ver" . ++$this->currentItem . "')"; 
		
		$resultString = '<img src="' . $imgSrc . '" valign="absmiddle" onclick="' . $onClick . '" />';
		$resultString .= '<b>' . $description . ': </b>&nbsp;<i>' . $subject . '</i><br />' . $details;
		$resultString .= '<div id="ver' . $this->currentItem . '" style="display:none; margin-left: 4px;">';
		$resultString .= '<table style="border: solid black 1px; border-spacing: 0px; width: 100%;">';
		
		$sql = 'SELECT ls.*, s.modelID 
				FROM log_statements ls
				LEFT JOIN statements s ON (s.modelID = ' . $this->model->getModelID() . ' AND ls.subject = s.subject AND ls.predicate = s.predicate 
				AND ls.object = s.object AND ls.l_language = s.l_language AND ls.l_datatype = s.l_datatype 
				AND ls.subject_is = s.subject_is AND ls.object_is = s.object_is)
				WHERE action_id = ' . $id . ' 
				GROUP BY ls.id 
				ORDER BY ar';
			
		$sqlResult = $this->model->getStore()->getDbConn()->getAll($sql);
		
		foreach ($sqlResult as $stm) {
			$resultString .= '<tr><td style="vertical-align: middle; padding-left: 0px;">' . (($stm[8] == 'a') ? '<img src="' . Zend_Registry::get('config')->erfurtPublicUri . 'images/plus_big.png" />' : '<img src="' . Zend_Registry::get('config')->erfurtPublicUri . 'images/minus_big.png" />') . '</td>';
			
			if (!$_REQUEST['filter']['resource']) {
				$resultString .= '<td style="background-color: #eaeaea">';
				$resultString .= '<a href="' . pwlURLParamReplace('filter[resource]', str_replace('#', '%23', $stm[1])) . '">' . $this->showNode($stm[1]) . '</a><br />';
				#$resultString .= '<td style="background-color: #eaeaea">';
				$resultString .= '<a href="' . pwlURLParamReplace('filter[resource]', str_replace('#', '%23', $stm[2])) . '">' . $this->showNode($stm[2]) . '</a><br />';
				#$resultString .= '<td style="background-color: #eaeaea">';
				$resultString .= '<a href="' . pwlURLParamReplace('filter[resource]', str_replace('#', '%23', $stm[3])) . '">' . $this->showNode($stm[3]) . '</a></td></tr>';
			}
					
			// ar = 'r' + modelID || ar = 'a' + !modelID
			if (($stm[8] == 'r' && $stm[10]) || ($stm[8] == 'a' && !$stm[10])) {
				$mayRolledBack = false;
			}		
		}
		
		$resultString .= '</table>';
		
		//$sql = 'SELECT la.id, description, subject, details 
		//		FROM log_actions la 
		//		INNER JOIN log_action_descr lad ON (lad.id = descr_id) 
		//		WHERE parent_id = ' . $id;
				
		//$sqlResult = $this->model->getStore()->getDbConn()->getAll($sql);
		//foreach($sqlResult as $row) {
		//	$resultString .= $this->renderAction($row[0], $row[1], $row[2], $row[3], $mayRolledBack);
		//}
			
		$resultString .= '</div>';
		
		return $resultString;
	}
	
	public function rollback($actionId) {
		
		$this->model->getDbConn()->StartTrans();
		$this->model->logStart('Rollback action', $actionId);
		
		$sql = 'SELECT ls.subject, ls.predicate, ls.object, l_language, l_datatype, subject_is, object_is, ar, action_id
				FROM log_statements ls
				INNER JOIN log_actions ON (action_id = log_actions.id)
				WHERE action_id = ' . $actionId . ' OR parent_id = ' . $actionId . ' 
				ORDER BY date DESC';
				
		$rs = $this->model->getDbConn()->execute($sql);
		
		while ($rs) {
			if ($rs->fields[8] != $actionId) {
				if (!$this->rollback($rs->fields[8])) {
					return false;
				}
						
				while ($rs->fields[8] != $actionId && $rs->moveNext());
			}
			
			$ar = $rs->fields[7];
			
			if (!($stm = $this->model->fetchStatementFromRecordSet($rs))) {
				break;
			}
					
			$f = $this->model->find($stm->subj, $stm->pred, $stm->obj);
			
			if ($ar == 'r') {
				if (!$f->triples) {
					$this->model->add($stm);
				} else {
					echo 'Rollback failed: Statement exists!';
					$this->model->getDbConn()->CompleteTrans(false);
					return false;
				}
			} else {
				if ($f->triples) {
					$this->model->remove($stm);
				}	else {
					echo 'Rollback failed: Statement does not exists!';
					$this->model->getDbConn()->CompleteTrans(false);
					return false;
				}
			}
		}
		
		$this->model->logEnd();
		$this->model->getDbConn()->CompleteTrans();
	}
	
	public function multipleRollback(Array $actionIds) {
		
		$sql = 'SELECT modelURI, id 
				FROM log_actions
				INNER JOIN models ON (model_id = modelID) WHERE id IN (' . join(',', $actionIds) . ') 
				ORDER BY modelURI, date DESC';
		
		$sqlResult = $this->model->getStore()->getDbConn()->getAll($sql);
		foreach ($sqlResult as $row) {
			$models[$row[0]][] = $row[1];
		}
			
		foreach($models as $modelURI=>$actions) {
			$m = $this->model->getStore()->getModel($modelURI);
			if (count($actions) > 1) {
				$m->logStart('Rollback actions', join(',', $actions));
			}
			
			foreach ($actions as $action) {
				$this->rollback($action);
			}
			
			if (count($actions) > 1) {
				$m->logEnd();
			}
		}
	}
	
	protected function showNode($node) {
		
		if (!($node instanceof Node)) {
			$node = $this->model->resourceF($node);
		} 
		
		if ($node instanceof Literal) {
			$result = $node->getLabel() . sprintf(' ( Language: %s, Datatype: %s)', 
					                           $node->getLanguage() ? $node->getLanguage() : '-', 
					                           $node->getDatatype() ? $node->getDatatype() : '-');
		} else {
			$result = $node->getLocalName();
		}
		
		return $result;
	}
}
?>
