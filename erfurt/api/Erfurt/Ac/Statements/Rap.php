<?php
require_once RDFAPI_INCLUDE_DIR . '/sparql/SparqlParser.php';
require_once RDFAPI_INCLUDE_DIR . '/sparql/SparqlEngineDb.php';
require_once RDFAPI_INCLUDE_DIR . '/model/ModelFactory.php';

/**
  * class providing Erfurt-API statement based ac for rap
  * 
  * Uses SPARQL-Transformation classes
  *
  * @package ac
  * @author Stefan Berger <berger@intersolut.de>
  * @version $Id$
  */
class Erfurt_Ac_Statements_Rap extends Erfurt_Ac_Statements_Abstract 
																							implements Erfurt_Ac_Statements_Interface {
	
	/**
	 * using merge algorithme for view
	 */																								
	private $useMerge = true;
	
	private $rapViews = null;
	
	private $db = null;
	
	public function __construct() {
		$this->rapViews = new Erfurt_Ac_Statements_Views_Rap();
		$this->db = Zend_Registry::get('erfurt')->getStore()->dbConn;
		parent::__construct();
	}
	
	/**
	 * remove all sbac 
	 */
	public function dropSbac() {
		return $this->rapViews->dropViews();
	}
	
	/**
	 * checks for exiting view
	 */
	public function checkExistingView($uri, $user = true, $type = 'view') {
		# get view name
		$viewName = ($user) ? $this->rapViews->getUserViewName($uri, $type) : $this->rapViews->getGroupViewName($uri, $type);
		$views = $this->rapViews->getViews();
		if (in_array($viewName, $views)) {
			return $viewName;
		}
		return false;
	}
	
	/**
	 * check for using existing view
	 *
	 * @param string read or write
	 */
	public function checkAccessPossibility ($type = 'view') {
		$views = $this->rapViews->getViews();
		$userView = '';
		if (in_array($userView, $views)) {
			
		}
		
	}
	
	/**
	 * setup rap for using read view
	 */
	public function performViewRestriction() {
		# check for existing personal view
		$personalView = $this->personalViewNeeded('view');
		if ($personalView and $userViewName = $this->checkExistingView($this->_activeUserUri, true, 'view')) {
			# true: replace table with view
			$this->_log->info('OntoWiki_Ac_Statements_Rap::performViewRestriction: selected personal view "'.$userViewName.'"'."\n"); 
			
			# change table
			$GLOBALS['RAP']['conf']['database']['tblStatements'] = $userViewName;
			$this->_personalViewName = $userViewName;
			$this->_needViewSbac = true;
			return;
		} else if ($personalView) {
			#$GLOBALS['RAP']['conf']['database']['tblStatements'] = 'user_view_af4fc15dd033ac5df8bf3e97d4a46acb';
			
			#return;
			
			## READ ACCESS
			$personalSelectors = $this->getSelectors('view');
			#printr($personalSelectors);
			
			# get new view sql
			$det = $this->_getNewViewSQL($personalSelectors);
			#printr($det);exit;
			
			# create view 
			$personalViewName = $this->rapViews->getUserViewName($this->_activeUserUri);
			$this->rapViews->createView($personalViewName,  $det['from'], $det['where'], $det['add'], $this->useMerge); 
			
			## WRITE ACCESS
			/*
			$personalEditSelectors = $this->getSelectors('edit');
			
			#printr($groupEditSelectors);
			
			# get new edit view sql
			$det = $this->_getNewViewSQL($personalEditSelectors);
			
			# create edit view
			if (count($personalEditSelectors) > 0) {
				$personalEditName = $this->rapViews->getUserViewName($det['targetUri'], 'edit');
				$this->rapViews->createView($personalEditName,  $det['from'], $det['where'], $det['add'], $this->useMerge);
			}*/
			
			
			$this->_log->info('OntoWiki_Ac_Statements_Rap::performViewRestriction: created and selected personal view "'.$personalViewName.'"'."\n"); 
			
			# change table
			$GLOBALS['RAP']['conf']['database']['tblStatements'] = $personalViewName;
			$this->_personalViewName = $personalViewName;
			$this->_needViewSbac = true;
			return;
		}
		
		# check for group view
		$groupView = $this->groupViewNeeded('view');
		# get selector configuration
		if ($groupView) {
			$groupSelectors = $this->getSelectors('view');
			$groupUri = $this->getFirstKey($groupSelectors);
		}
		if ($groupView and ($groupViewName = $this->checkExistingView($groupUri, false, 'view'))) {
			$this->_log->info('OntoWiki_Ac_Statements_Rap::performViewRestriction: selected group view "'.$groupViewName.'"'."\n"); 
			$GLOBALS['RAP']['conf']['database']['tblStatements'] = $groupViewName;
			$this->_personalViewName = $groupViewName;
			$this->_needViewSbac = true;
			return;
		} else if ($groupView) {
			
			## READ ACCESS
			# get new view sql
			$det = $this->_getNewViewSQL($groupSelectors);
			
			# create view 
			$groupViewName = $this->rapViews->getGroupViewName($det['targetUri']);
			$this->rapViews->createView($groupViewName,  $det['from'], $det['where'], $det['add'], $this->useMerge); 
			
			## WRITE ACCESS
			/*
			$groupEditSelectors = $this->getSelectors('edit');
			
			#printr($groupEditSelectors);
			
			# get new edit view sql
			$det = $this->_getNewViewSQL($groupEditSelectors);
			
			# create edit view
			if (count($groupEditSelectors) > 0) {
				$groupEditName = $this->rapViews->getGroupViewName($det['targetUri'], 'edit');
				$this->rapViews->createView($groupEditName,  $det['from'], $det['where'], $det['add'], $this->useMerge);
			}
			*/
			$this->_log->info('OntoWiki_Ac_Statements_Rap::performViewRestriction: created and selected group view "'.$groupViewName.'"'."\n");

			# change table
			$GLOBALS['RAP']['conf']['database']['tblStatements'] = $groupViewName;
			$this->_personalViewName = $groupViewName;
			$this->_needViewSbac = true;
			return; 
		}

		# false: going on
		
		# check for
		 
	}
	
	
	/**
	 * get plain list of models
	 * 
	 * @return array key is modelID and value is modelURI 
	 */
	private function getModelList() {
		static $ret;
		if (is_array($ret)) return $ret;
		
		$sql = 'SELECT modelID, modelURI FROM models';
		$views = $this->db->getAll($sql);
		$ret = array();
		if ($views) {
			foreach($views as $row) {
				$ret[$row[0]] = $row[1];
			}
		} 
		return $ret;
	}
	
	/**
	 * setup rap for using write view
	 */
	public function performEditRestriction() {
		# check for existing personal view
		$personalView = $this->personalViewNeeded('edit');
		
		#printr($personalView);
		#printr($this->checkExistingView($this->_activeUserUri, true, 'edit'));exit;
		if ($personalView and ($userViewName = $this->checkExistingView($this->_activeUserUri, true, 'edit')))  {
			$this->_personalEditName = $userViewName;
			$this->_needEditSbac = true;
		} elseif ($personalView) {
			#$GLOBALS['RAP']['conf']['database']['tblStatements'] = 'user_view_af4fc15dd033ac5df8bf3e97d4a46acb';
			$this->_log->info('OntoWiki_Ac_Statements_Rap::performEditRestriction: start to create personal view "'.$userViewName.'"'."\n");
			
			## WRITE ACCESS
			$personalEditSelectors = $this->getSelectors('edit');
			
			# get new edit view sql
			$det = $this->_getNewViewSQL($personalEditSelectors);
			
			# create edit view
			if (count($personalEditSelectors) > 0) {
				$personalEditName = $this->rapViews->getUserViewName($det['targetUri'], 'edit');
				$this->rapViews->createView($personalEditName,  $det['from'], $det['where'], $det['add'], $this->useMerge);
			}
			
			$this->_log->info('OntoWiki_Ac_Statements_Rap::performViewRestriction: created personal edit view "'.$personalEditName.'"'."\n"); 
			
			# change table
			#$GLOBALS['RAP']['conf']['database']['tblStatements'] = $personalViewName;
			$this->_personalEditName = $personalEditName;
			$this->_needEditSbac = true;
			return;
		}
		
		# check for group view
		$groupView = $this->groupViewNeeded('edit');
		# get selector configuration
		if ($groupView) {
			$groupEditSelectors = $this->getSelectors('edit');
			$groupUri = $this->getFirstKey($groupEditSelectors);
		}
		
		if ($groupView and ($groupViewName = $this->checkExistingView($groupUri, false, 'edit'))) {
			$this->_personalEditName = $groupViewName;
			$this->_needEditSbac = true;
		} elseif ($groupView) { 
			
			#printr($groupEditSelectors);
			
			# get new edit view sql
			$det = $this->_getNewViewSQL($groupEditSelectors);
			
			# create edit view
			if (count($groupEditSelectors) > 0) {
				$groupEditName = $this->rapViews->getGroupViewName($det['targetUri'], 'edit');
				$this->rapViews->createView($groupEditName,  $det['from'], $det['where'], $det['add'], $this->useMerge);
			}
			
			$this->_log->info('OntoWiki_Ac_Statements_Rap::performEditRestriction: created edit group view "'.$groupEditName.'"'."\n");
			$this->_personalEditName = $groupEditName;
			$this->_needEditSbac = true;
			return; 
		}
	}
	
	public function decideMethod(){
		
	}
	
																							
	public  function _getRuleDetails($sourceSelectors) {
		# select details
		$selectorDetails = $this->getSelectorDetails($sourceSelectors);
		#printr($sourceSelectors);
		# change selectorSelect
		 
		# get rules details
		$rules = array();
		$usingTargetUri = ''; 
		foreach ($sourceSelectors as $targetUri => $selectors) {
			if ($usingTargetUri == '')
				$usingTargetUri = $targetUri;
			foreach($selectors as $prop => $selectorUri) {
				foreach($selectorDetails as $res) {
					if ($res['?s']->getUri() != $selectorUri) continue;
					# where clause
					if ($res['?p']->getUri() == $this->_propSparqlClause) {
						if (!isset($rules[$selectorUri]['sparql']) or !is_array($rules[$selectorUri]['sparql'])) 
							$rules[$selectorUri]['sparql'] = array();
						
						$sparql = $res['?o']->getLabel();
						
						# exists?
						if (in_array($sparql, $rules[$selectorUri]['sparql'])) continue;
						
						# replacement rules
						if (strpos($sparql, $this->_currentUserReplace) !== FALSE) {
							$rules[$selectorUri]['individual'] = true;
							$sparql = str_replace($this->_currentUserReplace, $targetUri, $sparql); 
						}
						if (strpos($sparql, $this->_selectorSubjectReplace) !== FALSE) {
							$rules[$selectorUri]['individual'] = true;
							$sparql = str_replace($this->_selectorSubjectReplace, $targetUri, $sparql);	
						}
						
						$rules[$selectorUri]['sparql'][] = $sparql;
						continue;
					}
					# models
					if ($res['?p']->getUri() == $this->_propStatementsModel) {
						if (!isset($rules[$selectorUri]['models']) or !is_array($rules[$selectorUri]['models'])) 
							$rules[$selectorUri]['models'] = array();
						#$rules[$selectorUri]['models'][] = $res['?o']->getUri();
						
						# TODO: look for any-model => but any model if no model?
						$modelId = $this->db->getOne("SELECT modelID FROM models WHERE modelURI='".$res['?o']->getUri()."'");
						
						# store mode
						if (!in_array($modelId, $rules[$selectorUri]['models']))
							$rules[$selectorUri]['models'][] = $modelId;
					}
					if (!isset($rules[$selectorUri]) or !is_array($rules[$selectorUri])) continue;
					
					# individual bit
					if (!isset($rules[$selectorUri]['individual'])) 
						$rules[$selectorUri]['individual'] = false;
					
					# set combine-element
					if (in_array($prop, array($this->_propGrantStatementsView, $this->_propGrantStatementsEdit))) {
						$rules[$selectorUri]['combine'] = ' OR ';
						$rules[$selectorUri]['combinenegation'] = false;
					} else {
						$rules[$selectorUri]['combine'] = ' AND NOT ';
						$rules[$selectorUri]['combinenegation'] = true;
					}
					
				}
			}
		}
	
		
		#printr($groupSelectors);
		#printr($groupSelectorDetails);
		return $rules; 
	}
	
	private function _getNewViewSQL($sourceSelectors) {
		$rules = array();
		$usingTargetUri = ''; 
		foreach ($sourceSelectors as $targetUri => $selectors) {
			if ($usingTargetUri == '')
				$usingTargetUri = $targetUri;
			foreach($selectors as $prop => $selectorUri) {
				$rules[$selectorUri] = $this->_rules[$selectorUri];
			}
		}
		
		# model list
		$modelList = $this->getModelList();
		
		$prefixed_query = '';
		foreach ($this->_sysontModel->getParsedNamespaces() as $uri => $prefix) {
			$prefixed_query .= 'PREFIX ' . $prefix . ': <' . $uri . '>' . PHP_EOL;
		}
		
		$qp     = new SparqlParser();
		$negativeWhere = '';
		$positiveWhere = '';
		$positiveWhereCount = 0;
		$negativeWhereCount = 0;
		$from = '';
		foreach($rules as $selectorUri => $rule) {
			foreach($rule['sparql'] as $sparql) {
				$select = '';
				if (strpos($sparql, '?s') == true) {
					$select = ' ?s';
				} else if (strpos($sparql, '?p') == TRUE) {
					$select = ' ?p';
				} else if (strpos($sparql, '?o') == TRUE) {
					$select = ' ?o';
				} else {
					// TODO:exeption
 						$this->_log->error('OntoWiki_Ac_Statements_Rap::performViewRestriction: malformed rule"'."\n");
					continue;
				}
				$strQuery = $prefixed_query . " SELECT ".$select." WHERE ".$sparql;
				#$strQuery = $prefixed_query . " SELECT ".$select." WHERE {?s ?p ?o. ?s rdf:type foaf:Agent. ?s rdf:type foaf:Group}";
				#$strQuery = $prefixed_query . " SELECT ".$select." WHERE {?s rdf:type foaf:Group}";
				
				foreach($rule['models'] as $modelId) {
					# unset for later
					if (isset($modelList[$modelId])) unset($modelList[$modelId]);
				}
				
				$query  = $qp->parse($strQuery);
				$resPart = $query->getResultPart();
				$sg     = new SparqlEngineDb_SqlGenerator($query, $this->db, $rule['models']);
				$arSqls = $sg->createSql();
				#printr($arSqls);exit;

				# first from
				if ($from == '') {
					$from = $arSqls[0]['from'];
				}
				
				# positive add
				if (!$rule['combinenegation']) {
					if ($positiveWhere == '') {
						$positiveWhere .= '('.substr($arSqls[0]['where'], 6).")\n";
					} else {
						$positiveWhere .= ' OR '.'('.substr($arSqls[0]['where'], 6).")\n";
					}
					$positiveWhereCount++;
				}
				
				# subselect if more than ohne triple and negative
				$subSelect = false;
				if ($rule['combinenegation'] and count($resPart[0]->getTriplePatterns()) == 1) {
					$negativeWhere .= $rule['combine'].'('.substr($arSqls[0]['where'], 6).")\n";
					$negativeWhereCount++; 
				} else if ($rule['combinenegation']) {
					$subSelect = true;
					$negativeWhere .= $rule['combine'].' t0.id IN (SELECT t0.id '.$arSqls[0]['from']. ' '.$arSqls[0]['where'].")\n";
				}

				# if more tX. joins - take it in from
				if (!$subSelect and strlen($from) < strlen($arSqls[0]['from'])) {
					$from = $arSqls[0]['from'];
				}
			}
		}
		
		# new from for empty positive
		if ($positiveWhereCount == 0) {
			$from = ' FROM statements as t0 ';
		}
		
		# add more models => no rules!
		$addMore = '';
		$aKe = array_keys($modelList);
		
		# using merge: no union allowed in view
		if ($positiveWhereCount > 0) {
			if ($this->useMerge and is_array($aKe) and count($aKe) > 0) {
				$positiveWhere .= ($positiveWhere != '') ? ' OR ' : '';
				$positiveWhere .= '(t0.modelID IN ('.implode(', ', $aKe).') ';
				$positiveWhere .= (strpos($from, 't1.') !== FALSE) ? ' AND t1.id =  t0.id ' : '';
				$positiveWhere .= ')';
			} else if (!$this->useMerge and is_array($aKe) and count($aKe) > 0) {
				$addMore .= " UNION SELECT s.* FROM statements as s WHERE modelID IN (".implode(', ', $aKe).")";
			}
		}	
		
		
		# combine where clause
		$where .= ($positiveWhere != '') ? 'AND ('.$positiveWhere.')'."\n" : '';
		$where .= $negativeWhere;
		
		return array('targetUri' => $usingTargetUri, 'from'	=> $from, 'where' => $where, 'add' => $addMore);
	}
	
	/**
	 * perform insert query
	 *
	 * @param string $sql
	 * @return mixed
	 */
	public function addQuery($sql) {
		return $this->performQuery($sql, false);
	}
	
	/**
	 * perform delete query
	 *
	 * @param string $sql
	 * @return mixed
	 */
	public function removeQuery($sql) {
		return $this->performQuery($sql, true);
	}
	
	/**
	 * perform write query
	 *
	 */
	protected function performQuery($editsql, $delete = false) {
		
		# db debug
		#$this->db->debug = true;
		
		# start transaction
		$this->db->startTrans();
		
		# count statements in Edit-View
		$sql = 'SELECT COUNT(*) FROM '.$this->_personalEditName;
		if (!$firstCount = $this->db->getOne($sql)) {
			return $this->_errorEditQuery(true);
		}
		
		# perform query
		if (!$rs = & $this->db->execute($editsql) ) {
			return $this->_errorEditQuery(true);
		}
		$affectedRows = $this->db->Affected_Rows();
		
		# count statements in edit-view
		$sql = 'SELECT COUNT(*) FROM '.$this->_personalEditName;
		if (!$secondCount = $this->db->getOne($sql)) {
			return $this->_errorEditQuery(true);
		}
		
		# compare counts
		$this->_log->debug('OntoWiki_Ac_Statements_Rap::editQuery - first count: '.$firstCount.' second count: '.$secondCount.' '. " \n");
		if (($delete and $firstCount == ($secondCount + 1))
				or (!$delete and ($firstCount + 1) == $secondCount)) {
			# commit
			if (!$this->db->CompleteTrans()) {
					return $this->_errorEditQuery(true);
			}
			
			$this->_log->debug('OntoWiki_Ac_Statements_Rap::editQuery: commited '. " \n");
		} else {
			# rollback
			return $this->_errorEditQuery();
		}
		return $affectedRows;
	}
	
	/**
	 * perform transaction error
	 *
	 * @param bool $dbError error message in db?
	 */
	private function _errorEditQuery($dbError = false) {
		$this->_log->debug('OntoWiki_Ac_Statements_Rap::_errorEditQuery: rollback '.(($dbError) ? $this->db->errorMsg() : '') ."\n"); 
		#rollback
		$this->db->RollbackTrans();
		# message
		if ($dbError)
			return $this->db->errorMsg();

			return false;
	}
}
