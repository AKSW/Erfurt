<?php
/**
 * RDFSmodel
 *
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004
 * @version $Id$
 */
class RDFSModel extends Erfurt_Rdfs_Model_Abstract {
	public function __construct($store,$modelURI,$type=NULL) {
		$modelVars =& $store->dbConn->execute("SELECT modelURI, modelID, baseURI FROM models WHERE modelURI='" .$modelURI ."'");
		$this->modelID 	= $modelVars->fields[1];
		$this->baseURI 	= $this->_checkBaseURI($modelVars->fields[2]);
		parent::__construct($store,$modelURI,$type);
	}
	
#######################################################################################################################
#######################################################################################################################
## 
## methods that have to be overwritten for a specific backend
##	
#######################################################################################################################
#######################################################################################################################
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function getParsedNamespaces() {
		
		$c=cache('getParsedNamespaces'.$this->modelURI,array());
		if($c!==NULL)
			return $c;
		$ret=array_flip((array) $GLOBALS['default_prefixes']);
		// get namespace prefixes from SysOnt-Class "Model"
		if(0 && !empty($this->store->SysOnt) && $modelClass=$this->store->SysOnt->getClass('Model'))
			if($inst=$modelClass->findInstance(array('modelURI'=>$this->modelURI)))
				foreach($inst->listPropertyValuesPlain(Zend_Registry::get('SysOntSchemaURI').'modelXMLNS') as $prefix) {
					$ns=explode(':',$prefix,2);
					$ret[$ns[1].(ereg('[#/]$',$ns[1])?'':'#')]=$ns[0];
				}
		$pns=DbModel::getParsedNamespaces();
		$ret=array_filter($pns?array_merge((array)$ret,$pns):$ret);
		return cache('getParsedNamespaces'.$this->modelURI,array(),$ret);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	protected function _createStatement($subj,$pred=false,$obj=false,$objLang='',$objDType='') {
		
		if(($subj instanceof Statement))
			return $subj;
		else if(is_numeric($subj) && !$pred)
			return $this->fetchStatementFromRecordSet($this->dbConn->execute("SELECT subject,predicate,object,l_language,l_datatype,subject_is,object_is FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." WHERE id='$subj'"));
		if(!($subj instanceof Resource))
			$subj=$this->resourceF($subj);
		if(!($pred instanceof Resource))
			$pred=$this->resourceF($pred);
		if(!($obj instanceof Node)) {
			if($objLang || $objDType)
				$obj=new RDFSLiteral($obj,$objLang,($objDType instanceof Resource)?$objDType->getURI():$objDType);
			else if(preg_match('/"(.*)"@(.*)\^\^(.*)/ms',$obj,$matches))
				$obj=new RDFSLiteral($matches[1],$matches[2],$matches[3]);
			else
				$obj=$this->resourceF($obj);
		}
		return new Statement($subj,$pred,$obj);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function add($subj,$pred='',$obj='') {
		
		if (!$this->isEditable()) 
			throw new Erfurt_Exception('no rights to extend this model', 1502);
		
		Zend_Registry::set('cache', array());
		$statement=!$obj?$subj:$this->_createStatement($subj,$pred,$obj);
		 
		# sbac
		if (($this->getStore()->getAc() !== null) && ($this->getStore()->getAc()->isEditSbac())) {
			$affectedRows = $this->_addExt($statement);
		} else {
			DbModel::add($statement);
			$affectedRows = $this->dbConn->Affected_Rows();
		}
		
		$success=false;
		if($affectedRows===false || $affectedRows===1) {
			$success=true;
			stmCache::expire($statement);
			$this->logAdd($statement);
		} else
			trigger_error('Addition of statement <i>'.$statement->subj->getLabel().'->'.$statement->pred->getLabel().'->'.$statement->obj->getLabel().'</i> failed!',E_USER_WARNING);
		#queryCacheExpire($this->modelID,$statement->subj,$statement->pred,$statement->obj);
		return $success;
	}
	
	private function _addExt(&$statement) {
	if (!($statement instanceof Statement)) {
			$errmsg = RDFAPI_ERROR . '(class: DbModel; method: add): Statement expected.';
			trigger_error($errmsg, E_USER_ERROR);
		}

		if (!$this->contains($statement)) {

			$subject_is = $this->_getNodeFlag($statement->subject());
			$sql = "INSERT INTO statements
			        (modelID, subject, predicate, object, l_language, l_datatype, subject_is, object_is)
			        VALUES
                    (" .$this->modelID .","
			."'" .$statement->getLabelSubject() ."',"
			."'" .$statement->getLabelPredicate() ."',";

			if ($statement->object() instanceof Literal) {
				$quotedLiteral = $this->dbConn->qstr($statement->obj->getLabel(), get_magic_quotes_gpc());
				$sql .=        $quotedLiteral .","
				."'" .$statement->obj->getLanguage() ."',"
				."'" .$statement->obj->getDatatype() ."',"
				."'" .$subject_is ."',"
				."'l')";
			}else{
				$object_is = $this->_getNodeFlag($statement->object());
				$sql .=   "'" .$statement->obj->getLabel() ."',"
				."'',"
				."'',"
				."'" .$subject_is ."',"
				."'" .$object_is ."')";
			}
			#$rs =& $this->dbConn->execute($sql);

			# start sbac
			$rs = $this->getStore()->getAc()->getSbac()->addQuery($sql);
			
			if (!$rs) {
				return 'db transaction failed - see logs';
            } else {
                return $rs;
            }
		} else {
			return false;
		}
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function remove($subj,$pred='',$obj='') {
		
		if (!$this->isEditable()) 
			throw new Erfurt_Exception('no rights for editing this model', 1501);
		
		Zend_Registry::set('cache', array());
		$statement=$this->_createStatement($subj,$pred,$obj);
		#if(isBnode($statement->obj)) {
		#	$o=new $this->resource($statement->obj->getURI(),$this);
		#	$o->remove();
		#}
#print_r($statement->subj->toString().$statement->pred->toString().$statement->obj->toString());
		
		# sbac
		if (($this->getStore()->getAc() !== null) && ($this->getStore()->getAc()->isEditSbac())) {
			$affectedRows = $this->_removeExt($statement);
		} else {
			DbModel::remove($statement);
			$affectedRows = $this->dbConn->Affected_Rows();
		}
		
			
		$success=false;
		if($affectedRows===0 || $affectedRows===1) {
			$success=true;
			stmCache::expire($statement);
			$this->logRemove($statement);
		} else
			
			trigger_error('Deletion of statement <i>'.$statement->subj->getLabel().'->'.$statement->pred->getLabel().'->'.$statement->obj->getLabel().'</i> failed!',E_USER_WARNING);
		#queryCacheExpire($this->modelID,$statement->subj,$statement->pred,$statement->obj);
		return $success;
	}
	
	
	/**
	 * override the rap-remove function for sbac
	 */
	private function _removeExt(&$statement) {

		if (!($statement instanceof Statement)) {
			$errmsg = RDFAPI_ERROR . '(class: DbModel; method: remove): Statement expected.';
			trigger_error($errmsg, E_USER_ERROR);
		}

		$sql = 'DELETE FROM statements
           WHERE modelID=' .$this->modelID; 
		$sql .= $this->_createDynSqlPart_SPO ($statement->subj, $statement->pred, $statement->obj);
		
		# start sbac
		$rs = $this->getStore()->getAc()->getSbac()->removeQuery($sql);
		
		#$rs =& $this->dbConn->execute($sql);
		if (!$rs)
			 return 'db transaction failed - see logs';
		return $rs;
	}
	
	public function addStatementArray($statements, $startTransaction = true, $completeTransaction = true) {
		
		if (!is_array($statements)) {
// TODO exception code
			throw new Erfurt_Exception();
		}
		
		if (!$this->isEditable()) 
			throw new Erfurt_Exception('no rights to extend this model', 1502);
			
		Zend_Registry::set('cache', array());
		
		if ($startTransaction === true) {
			$this->dbConn->StartTrans();
		}
		foreach ($statements as $stm) {
			if (!$stm instanceof Statement) {
// TODO exception code
				throw new Erfurt_Exception();
			}
			
			# sbac
			if (($this->getStore()->getAc() !== null) && ($this->getStore()->getAc()->isEditSbac())) {
				$affectedRows = $this->_addExt($stm);
			} else {
				DbModel::add($stm);
				$affectedRows = $this->dbConn->Affected_Rows();
			}
		}
		if ($completeTransaction === true) {
			return $this->dbConn->CompleteTrans();
		}	
	}
	
	public function removeStatementArray($statements, $startTransaction = true, $completeTransaction = true) {
		
		if (!is_array($statements)) {
// TODO exception code
			throw new Erfurt_Exception();
		}
		
		if (!$this->isEditable()) 
			throw new Erfurt_Exception('no rights for editing this model', 1502);
			
		Zend_Registry::set('cache', array());
		
		if ($startTransaction === true) {
			$this->dbConn->StartTrans();
		}
		foreach ($statements as $stm) {
			if (!$stm instanceof Statement) {
// TODO exception code
				throw new Erfurt_Exception();
			}
			
			# sbac
			if (($this->getStore()->getAc() !== null) && ($this->getStore()->getAc()->isEditSbac())) {
				$affectedRows = $this->_removeExt($stm);
			} else {
				DbModel::remove($stm);
				$affectedRows = $this->dbConn->Affected_Rows();
			}
		}
		if ($completeTransaction === true) {
			return $this->dbConn->CompleteTrans();
		}
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function listNamespaces() {

		$ret = array();

		foreach (array('subject', 'predicate', 'object') as $col) {
			$temp = $this->dbConn->getCol('SELECT SUBSTRING('.$col.',1,LOCATE("#",'.$col.')) ns FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' WHERE modelID IN ('.$this->getModelIds().')'.
			($col != 'predicate' ? ' AND '.$col.'_is="r"' : '').' GROUP BY ns');

			$ret = array_merge($ret, $temp);
		}
		$ret=array_unique($ret);
		sort($ret);
		return $ret;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function listDatatypes() {
		
		$ret=$this->dbConn->getCol("SELECT l_datatype
				FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." WHERE modelID IN (".$this->getModelIds().") AND object_is='l' GROUP BY l_datatype");
		sort($ret);
		return $ret;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function listLanguages() {
		
		$ret=$this->dbConn->getCol("SELECT l_language FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
				WHERE modelID IN (".$this->getModelIds().") AND object_is='l' GROUP BY l_language");
		sort($ret);
		return array_filter($ret);
	}
	
	
	protected function _listResourcesCol($col,$search='',$start=0,$count=0,$erg=0) {
		
		$sql="SELECT $col res FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
				WHERE modelID IN (".$this->getModelIds().')'.($col!='predicate'?" AND {$col}_is='r'":'').($search?" AND $col LIKE '%$search%'":'')."
				GROUP BY res";
		$res=$count?$this->dbConn->pageExecute($sql,$count,$start/$count+1):$this->dbConn->execute($sql);
		$erg=$res->_maxRecordCount?$res->_maxRecordCount:$res->_numOfRows;
		$ret=array();
		foreach($res->getArray() as $a)
			foreach($a as $r)
				$ret[$r]=$this->resourceF($r);

		return $ret;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	// public function listTopClasses($systemClasses = false, $emptyClasses = false, $implicitClasses = false, $hiddenClasses = true) {
	//         
	// 		//$args = func_get_args();
	// 		//$cache = Zend_Registry::get('cache');
	// 		//if ($c = $cache->load($this, 'listTopClasses', $args)) {
	// 		//	return $c;
	// 		//}
	// 
	//         $sparql = 'SELECT DISTINCT ?class
	// 				   WHERE {
	// 					 { ?class rdf:type ?x .
	// 					   OPTIONAL { ?class rdfs:subClassOf ?super1 . } .
	// 					   OPTIONAL { ?class <http://ns.ontowiki.net/SysOnt/hidden> ?h } . 
	// 					   FILTER ( ?x = owl:Class || ?x = owl:DeprecatedClass || ?x = rdfs:Class ) .
	// 					   FILTER ( !bound(?super1) && !isBlank(?class) ) . ' .
	// 					   (($hiddenClasses == false) ? ' FILTER ( !bound(?h) || ?h != "true") . ' : '') .
	// 					   (($systemClasses == false) ? 
	// 						'FILTER ( !regex(str(?class), "(http://www.w3.org/2002/07/owl#|http://www.w3.org/1999/02/22-rdf-syntax-ns#|http://www.w3.org/2000/01/rdf-schema#).*") ) . ' 
	// 						: '') .
	// 					 '}' . (($implicitClasses == true) ? 
	// 					' UNION
	// 					 { ?implr rdf:type ?class . 
	// 					   OPTIONAL { ?class rdfs:subClassOf ?super2 . } .
	// 					   OPTIONAL { ?class <http://ns.ontowiki.net/SysOnt/hidden> ?h } .
	// 					   FILTER ( !bound(?super2) && !isBlank(?implr) ) . ' .
	// 					   (($hiddenClasses == false) ? ' FILTER ( !bound(?h) || ?h != "true") . ' : '') .
	// 					   (($systemClasses == false) ? 
	// 						'FILTER ( !regex(str(?class), "(http://www.w3.org/2002/07/owl#|http://www.w3.org/1999/02/22-rdf-syntax-ns#|http://www.w3.org/2000/01/rdf-schema#).*") ) . ' 
	// 						: '') .
	// 					 '}
	// 		    	   }' : '}');
	// 		
	// 				
	// 		$result = $this->sparqlQueryAs($sparql, 'class');
	// 		$res = array();
	// 		
	// 		foreach ($result as $row) {
	// 			if (!isset($res[($row['?class']->getURI())])) {
	// 				if ($emptyClasses === true) {
	// 					$res[$row['?class']->getURI()] = $row['?class'];
	// 				} else {
	// 					if ($row['?class']->countInstancesRecursive() > 0) {
	// 						$res[$row['?class']->getURI()] = $row['?class'];
	// 					}
	// 				}
	// 			}
	// 		}
	// 		
	// 		ksort($res);
	// 		//$cache->save($this, 'listTopClasses', $args, null, $res, array('rdf:type', 'rdfs:subClassOf'));
	// 		return $res;
	//     }
	
	public function listTopClasses($systemClasses = false, $emptyClasses = false, $implicitClasses = false, $hiddenClasses = true) {
        
		$args = func_get_args();
		$c = new stmCache('listTopClasses', $args, $this);
		 	
		$cVal = $c->get();	
		if (null != $cVal) {
			return $cVal;
		}

		$sql = 'SELECT s.object 
				FROM statements s	
				WHERE s.predicate = "' . EF_RDF_TYPE . '" AND s.object_is <> "b" AND modelID IN (' . $this->getModelIds() . ')
				UNION DISTINCT
				SELECT s.subject
				FROM statements s
				WHERE s.predicate = "' . EF_RDF_TYPE . '" 
				AND s.object IN ("' . EF_RDFS_CLASS . '", "' . EF_OWL_CLASS . '", "' . EF_OWL_DEPRECATED_CLASS . '") 
				AND s.subject_is <> "b" AND modelID IN (' . $this->getModelIds() . ')';
		
		$sqlResult = $this->getStore()->sqlQuery($sql);
		$tempClassArray = array(); // contains all classes that fit to the config given by the parameters
		
			
		// check whether classes are top classes
		foreach ($sqlResult as $row) {
			if (!$this->hasStatement($row, 'rdfs:subClassOf', null) || $this->hasStatement($row, 'rdfs:subClassOf', EF_OWL_THING)) {
				$tempClassArray[] = $this->classF($row[0]);
			}
		}
		
		// check for system classes iff $systemClasses = false
		if ($systemClasses == false) {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if (!((strstr($row->getURI(), EF_RDF_NS)) || (strstr($row->getURI(), EF_RDFS_NS)) || (strstr($row->getURI(), EF_OWL_NS)))) {	
					$tempClassArray[] = $row;
				} 
			}
		} else {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if (((strstr($row->getURI(), EF_RDF_NS)) || (strstr($row->getURI(), EF_RDFS_NS)) || (strstr($row->getURI(), EF_OWL_NS)))) {	
					$row->system = true;
					$tempClassArray[] = $row;
				} else {
					$row->system = false;
					$tempClassArray[] = $row;
				}
			}
		}
		
		// check for empty classes iff $emptyClasses = false
		if ($emptyClasses == false) {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if ($row->countInstancesRecursive() > 0) {
					$tempClassArray[] = $row;
				}
			}		
		} else {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if (($count = $row->countInstancesRecursive()) > 0) {
					$tempClassArray[] = $row;
					$row->emptyRecursive = false;
					$row->countInstancesRecursive = $count;
					
				} else {
					$tempClassArray[] = $row;
					$row->emptyRecursive = true;
					$row->countInstancesRecursive = 0;
				}
			}
		}
			
		// check for implicit classes iff $implicitClasses = false
		if ($implicitClasses == false) {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if ($this->hasStatement($row, 'rdf:type', array(EF_RDFS_CLASS, EF_OWL_CLASS, EF_OWL_DEPRECATED_CLASS))) {
					$tempClassArray[] = $row;
				}
			}		
		} else {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if ($this->hasStatement($row, 'rdf:type', EF_RDFS_CLASS)) {
					$row->classType = 'rdfs:Class';
					$row->implicit = false;
					$tempClassArray[] = $row;
				} else if ($this->hasStatement($row, 'rdf:type', EF_OWL_CLASS)) {
					$row->classType = 'owl:Class';
					$row->implicit = false;
					$tempClassArray[] = $row;
				} else if ($this->hasStatement($row, 'rdf:type', EF_OWL_DEPRECATED_CLASS)) {
					$row->classType = 'owl:DeprecatedClass';
					$row->implicit = false;
					$tempClassArray[] = $row;
				} else {
					$row->implicit = true;
					$tempClassArray[] = $row;
				}
			}
		}
		
		// check for hidden classes iff $hiddenClasses = false
		if ($hiddenClasses === false) {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach($temp as $row) {
				if (!$row->isHidden()) {
					$tempClassArray[$row->getLabelForLanguage()] = $row;
				}
			}
		} else {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach($temp as $row) {
				if ($row->isHidden()) {
					$tempClassArray[$row->getLabelForLanguage()] = $row;
				} else {
					$tempClassArray[$row->getLabelForLanguage()] = $row;
				}
			}
		}
		
	 	ksort($tempClassArray);
		$c->set($tempClassArray, array('rdf:type', 'rdfs:subClassOf', 'rdfs:label'));
		return $tempClassArray;
    }

	public function buildClassTree($systemClasses = false, $emptyClasses = false, $implicitClasses = false, $hiddenClasses = true) {

		$sql = 'SELECT s.object 
				FROM statements s	
				WHERE s.predicate = "' . EF_RDF_TYPE . '" 
				UNION DISTINCT
				SELECT s.subject
				FROM statements s
				WHERE s.predicate = "' . EF_RDF_TYPE . '" 
				AND s.object IN ("' . EF_RDFS_CLASS . '", "' . EF_OWL_CLASS . '", "' . EF_OWL_DEPRECATED_CLASS. '")';
		
		$sqlResult = $this->getStore()->sqlQuery($sql);
		$tempClassArray = array(); // contains all classes that fit to the config given by the parameters
		
		// check whether classes are top classes
		foreach ($sqlResult as $row) {
			if (!$this->hasStatement(null, 'rdfs:subClassOf', $row[0])) {
				$tempClasses[] = $this->classF($row[0]);
			}
		}
		
		// check for system classes iff $systemClasses = false
		if ($systemClasses === false) {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if (!((strstr($row->getURI(), EF_RDF_NS)) || (strstr($row->getURI(), EF_RDFS_NS)) || (strstr($row->getURI(), EF_OWL_NS)))) {
					$tempClassArray[] = $row;
				} 
			}
		}
		
		// check for empty classes iff $emptyClasses = false
		if ($implicitClasses === false) {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if ($row->countInstancesRecursive() > 0) {
					$tempClassArray[] = $row;
				}
			}		
		}
			
		// check for implicit classes iff $implicitClasses = false
		if ($implicitClasses === false) {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach ($temp as $row) {
				if ($this->hasStatement($row, 'rdf:type', array(EF_RDFS_CLASS, EF_OWL_CLASS, EF_OWL_DEPRECATED_CLASS))) {
					$tempClassArray[] = $row;
				}
			}		
		}
		
		// check for hidden classes iff $hiddenClasses = false
		if ($hiddenClasses === false) {
			$temp = $tempClassArray;
			$tempClassArray = array();
			foreach($temp as $row) {
				if (!$row->isHidden()) {
					$tempClassArray[] = $row;
				}
			}
		} 
	}
	
	/**
	 * @param mixed $s null, string, Resource or array
	 * @param mixed $p null, string, Resource or array
	 * @param moxed $o null,string, Node or array
	 * @return boolean 
	 */
	public function hasStatement($s, $p, $o) {
		
		$sql = 'SELECT s.subject, s.predicate, s.object
				FROM statements s WHERE modelID IN (' . $this->getModelIds() . ')';
				
		
			
		$subString = '';
		$predString = '';
		$objString = '';
		
		if ($s === null) {
			$subString = '';
		} else if (is_array($s)) {
			$subString = ' AND s.subject IN (';
			for ($i=0; $i<count($s); ++$i ) {
				$subString .= '"' . $this->_dbId($s[$i]) . '"';
				if ($i < (count($s)-1)) {
					$subString .= ', ';
				}
			}
			$subString .= ') ';
		} else {
			$subString = ' AND s.subject = "' . $this->_dbId($s) . '" ';
		}
		
		if ($p !== null || $o !== null) {
			$subString .= ' AND ';
		}
		
		if ($p === null) {
			$predString = '';
		} else if (is_array($p)) {
			$predString = 's.predicate IN (';
			for ($i=0; $i<count($p); ++$i ) {
				$predString .= '"' . $this->_dbId($p[$i]) . '"';
				if ($i < (count($p)-1)) {
					$predString .= ', ';
				}
			}
			$predString .= ') ';
		} else {
			$predString = 's.predicate = "' . $this->_dbId($p) . '" ';
		}
		
		if ($p !== null && $o !== null) {
			$predString .= ' AND ';
		}
		
		if ($o === null) {
			$objString = '';
		} else if (is_array($o)) {
			$objString = 's.object IN (';
			for ($i=0; $i<count($o); ++$i ) {
				$objString .= '"' . $o[$i] . '"';
				if ($i < (count($o)-1)) {
					$objString .= ', ';
				}
			}
			$objString .= ') ';
		} else {
			$objString = 's.object = "' . $o . '" ';
		}
		
		$sql .= $subString . $predString . $objString;
		
		//echo $sql;
		$result = $this->getStore()->sqlQuery($sql);
		
		if (count($result) > 0) {
			return true;
		} else {
			return false; 
		}
	}

	/**
	 * @see DefaultRDFSModel
	 */
	public function listClassLabelLanguages() {
		
		foreach($this->vocabulary['Class'] as $cl)
			$clsql.=" OR s2.object='".$cl->getURI()."'";
		$sql="SELECT s1.l_language
		      FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s1 INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s2
		         ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
		            AND s1.predicate='".$this->_dbId($GLOBALS['RDFS_label'])."'
		            AND s2.predicate='".$this->_dbId($GLOBALS['RDF_type'])."'
		            AND (1=0 ".$clsql."))
				WHERE s1.modelID IN (".$this->getModelIds().")
		      GROUP BY s1.l_language";
		return $this->dbConn->getCol($sql);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function listInstances($start=0,$erg=0,$end=0) {
		
		$ret=array();
		foreach($this->vocabulary['Class'] as $class) {
			$q="SELECT ?x WHERE (?x,<rdf:type>,?y) (?y,<rdf:type>,<".$class->getURI().">)";
			foreach($this->rdqlQuery($q) as $res)
				if($res['?x']) {
					if(method_exists($res['?x'],'getLocalName')) {
						$ret[$res['?x']->getLocalName()]=new $this->instance($res['?x']->getURI(),$this);
					}
				}
		}
		$end=count($ret);
		return array_slice($ret,$start,$start+$erg);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function listClassAnnotationProperties() {
		
		foreach($this->vocabulary['Class'] as $cl)
			$clsql.=" OR s2.object='".$cl->getURI()."'";
		$sql="SELECT s3.subject
		      FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s1 INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s2
		         ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
		            AND s2.predicate='".$GLOBALS['RDF_type']->getURI()."'
		            AND (1=0 ".$clsql."))
				INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s3 ON(s2.modelID=s3.modelID AND s1.predicate=s3.subject
					AND s3.predicate='".$GLOBALS['RDF_type']->getURI()."' AND s3.object='".$GLOBALS['OWL_AnnotationProperty']->getURI()."')
				WHERE (s1.modelID=".$this->modelID.str_replace('modelID','s1.modelID',$this->model->importsSQL).")
		      GROUP BY s3.subject";
#print_r($sql);
		return $this->dbConn->getCol($sql);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function findAsMemModel($s, $p, $o, $offset = 0, $limit = 0, $erg = 0) {
		
		$args=func_get_args();
		$c=cache('find'.$this->modelURI,$args);
		if($c!==NULL)
			return $c;

		$rs=$this->query($s,$p,$o,$offset,$limit);
		$erg=$rs->_maxRecordCount?$rs->_maxRecordCount:$rs->_numOfRows;
		$c=$this->_convertRecordSetToMemModel($rs);


		cache('find'.$this->modelURI,$args,$c);
		return $c;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function findSubjectsForPredicateAs($predicate, $class = 'resource', $offset = 0, $limit = 0, $erg = 0) {
		
		$sql = 'SELECT subject,subject_is FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].'
				WHERE modelID IN ('.$this->getModelIds().') AND predicate="'.$this->_dbId($predicate).'"
				GROUP BY subject';
		
		return $this->_convertRecordSetToNodeList($sql, $class, $offset, $limit, &$erg);
		
		/*
// TODO handle offset and limit
// TODO check whether to use a generic method for such cases instead of direct sparql
// TODO add a class parameter to sparqlQuery method
		if (!$predicate instanceof RDFSResource) $predicate = $this->resourceF($predicate);

		$sparql = 'SELECT DISTINCT ?subject
				   WHERE { ?subject <' . $predicate->getURI() . '> ?object } ';
				
		return $this->sparqlQuery($sparql, $class);
		*/
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function findObjectsForPredicateAs($predicate, $class = 'resource', $offset = 0, $limit = 0, $erg = 0) {
		
		$sql = "SELECT object,object_is FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
				WHERE modelID IN (".$this->getModelIds().') AND predicate="'.$this->_dbId($predicate).'"
				GROUP BY object';
				
		return $this->_convertRecordSetToNodeList($sql, $class, $offset, $limit, &$erg);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function findPredicates($subject = null, $object = null) {
		
		$sql = "SELECT predicate FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." WHERE modelID IN (".$this->getModelIds().')';
		$sql .= $this->_createDynSqlPart_SPO($subject, $predicate, $object).(!$count?" GROUP BY predicate":'');
		
		return $this->_convertRecordSetToNodeList($sql);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function findInstances($properties = array(), $compare = 'exact', $offset = 0, $limit = 0, $erg = 0) {
		
		$args = func_get_args();
		$cache = new stmCache('findInstances', $args, $this);
		
		$cVal = $cache->get();
		
		if ($cVal !== null) {
			$erg = $cVal[0];
			return $this->_convertRecordSetToNodeList($cVal[1], 'instance');
		}

		$ret = array();

		$sql = 'SELECT s.subject, s.subject_is FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s';
		$where = '';
		$n = 0;
		
		if (isset($properties['localName'])) {
			$where .= ' AND s.subject LIKE "' . $properties['localName'] . '%"';
			unset($properties['localName']);
		}
		
		foreach($properties as $property=>$value) {
			$prop = $this->resourceF($property);
			$sql .= ($value ? ' INNER ' : ' LEFT ');
			$n++;
			
			if (!$value) {
				$cond = '1';
			} else if ($compare === 'exact') {
				$cond = '(s' . $n . '.object = "' . $this->_dbId($value) . '" OR s' . $n . '.object = "' . $value . '")';
			} else if ($compare === 'starts') {
				$cond = 's' . $n . '.object LIKE "' . $value . '%"';
			} else if ($compare === 'contains') {
				$cond = 's' . $n . '.object LIKE "%' . $value . '%"';
			} else if ($compare === 'regex') {
				$cond = 's' . $n . '.object REGEXP "' . $value . '"';
			} else if ($compare === 'empty') {
				$cond = 'ISNULL(s' . $n . '.object)';
			}
				
			$sql .= 'JOIN '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s' . $n . ' ON (s.modelID = s' . $n . '.modelID AND s.subject = s' . $n . '.subject ' .
						'AND s' . $n . '.predicate = "' . $this->_dbId($prop) . '" AND ' . $cond . ')';
						
			if (!$value) {
				$where .= ' AND ISNULL(s' . $n . '.object)';
			}		
		}

		$sql .= ' WHERE s.modelID IN (' . $this->getModelIds() . ') AND	s.predicate = "' . $this->_dbId('RDF_type') . '" ' .
		 			'AND s.object NOT IN ("' . EF_OWL_RESTRICTION . '", "' . EF_OWL_CLASS .'", "' . EF_RDFS_CLASS . '", ' .
		            '"' . EF_OWL_DEPRECATED_CLASS . '", "' . EF_RDF_PROPERTY . '", "' . EF_OWL_DATATYPE_PROPERTY . '", ' .
		            '"' . EF_OWL_OBJECT_PROPERTY . '", "' . EF_OWL_ANNOTATION_PROPERTY . '", "' . EF_OWL_DEPRECATED_PROPERTY. '", ' .
		            '"' . EF_OWL_FUNCTIONAL_PROPERTY . '", "' . EF_OWL_INVERSEFUNCTIONAL_PROPERTY . '", ' .
		            '"' . EF_OWL_SYMMETRIC_PROPERTY . '", "' . EF_OWL_TRANSITIVE_PROPERTY . '")';

		$sql .= (!empty($where)) ? $where : '';
		$sql .= ' GROUP BY s.subject';
		

		if ($limit) {
			$res = &$this->dbConn->PageExecute($sql, $limit, ($offset/$limit+1));
		} else {
			$res = &$this->dbConn->execute($sql);
		}
			
		$erg = ($res->_maxRecordCount) ? $res->_maxRecordCount : $res->_numOfRows;
		$resArr = $res->getArray();

		$c = array($erg, $resArr);
		$cache->set($c, array_merge(array('rdf:type'), array_keys($properties)));
		$ret = $this->_convertRecordSetToNodeList($resArr, $this->instance);

		return $ret;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function getListAs($rest, $class = null) {
		
		if(!($rest instanceof Resource) || $rest->getURI()==$GLOBALS['RDF_nil']->getURI())
			return array();
		if($class=='Class')
			$class=$this->vclass;
		else if($class=='Property')
			$class=$this->property;

		$sql="SELECT s1.object,s1.object_is,s3.object,s3.object_is,s4.object,s4.object_is
				FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s1
				LEFT JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s2 ON(s1.modelID=s2.modelID AND s2.subject=s1.subject AND s2.predicate='".$this->_dbId('RDF_rest')."')
				LEFT JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s3 ON(s1.modelID=s3.modelID AND s3.subject=s2.object AND s3.predicate='".$this->_dbId('RDF_first')."')
				LEFT JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s4 ON(s1.modelID=s4.modelID AND s4.subject=s2.object AND s4.predicate='".$this->_dbId('RDF_rest')."')
			WHERE
				s1.subject='".$this->_dbId($rest)."' AND s1.predicate='".$this->_dbId('RDF_first')."'
				AND s1.modelID IN (".$this->getModelIds().')';
#echo $sql;
		$ret=array();
		$row=$this->dbConn->getRow($sql);
		if($row)
		for($i=0;$i<6;$i+=2) {
			if(Zend_Registry::get('config')->database->backend=='powl' && $row[$i+1]=='r') {
				$n=$this->_getNodeById($row[$i]);
				$row[$i]=$n->getURI();
				$row[$i+1]=isBNode($n)?'b':$row[$i+1];
			}
			if($row[$i+1]=='l')
				$ret[$row[$i]]=new RDFSLiteral($row[$i]);
			else if($row[$i+1]=='r' && $row[$i]!=$GLOBALS['RDF_nil']->getURI()) {
				$r=($class && class_exists($class)?new $class($row[$i],$this):new $this->resource($row[$i],$this));
				$ret[$r->getLocalName()]=$class=='Plain'?$r->getLocalName():$r;
			} else if($row[$i]) {
				$member=$row[$i+1]=='b'?($class && class_exists($class)?new $class($row[$i],$this):new BlankNode($row[$i])):new $this->resource($row[$i],$this);
				if($row[$i+1]=='b') // Blanknodes have empty namespace
					$member->uri=$row[$i];
				$list=$this->getList($member,$class);
				if($list)
					$ret=array_merge($ret,$list);
				else if($row[$i]!=$GLOBALS['RDF_nil']->getURI())
					array_push($ret,$member);
			}
		}
		return $ret;
/*		return array_merge(
			$this->findNodes($rest,$GLOBALS['RDF_first'],NULL,$class),
			$this->getList(parray_shift($this->findNodes($rest,$GLOBALS['RDF_rest'],NULL)),$class)
		);*/
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function logStart($action, $subject = '', $details = '') {
		
		if(!$this->logEnabled())
			return;
		if(!$descrId=$this->dbConn->getOne("SELECT id FROM log_action_descr WHERE description='$action'")) {
			$this->dbConn->execute("INSERT INTO log_action_descr VALUES (NULL,'$action');");
			$descrId=$this->dbConn->Insert_ID();
		}
		$this->dbConn->execute("INSERT INTO log_actions VALUES (NULL,".(!empty($this->logActions[0])?$this->logActions[0]:'NULL').",{$this->modelID},'".(empty($_SESSION['PWL']['user'])?'':$_SESSION['PWL']['user'])."',".$this->dbConn->sysTimeStamp.",'$descrId','$subject','$details');");
		$actionId=$this->dbConn->Insert_ID();
		array_unshift($this->logActions,$actionId);
		$this->dbConn->StartTrans();
		return $actionId;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function logEnd() {
		
		if(!$this->logEnabled())
			return;
		array_shift($this->logActions);
		return $this->dbConn->CompleteTrans();
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function logEnabled() {
// TODO clean up the following statement
		
		return (empty(Zend_Registry::get('config')->logging) || Zend_Registry::get('config')->logging) && empty($this->logDisabled) && in_array((empty(Zend_Registry::get('config')->database->tablePrefix) ? '' : Zend_Registry::get('config')->database->tablePrefix).'log_action_descr',$this->dbConn->MetaTables())?true:false;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function renameNamespace($fromNS, $toNS) {
		
		$this->dbConn->execute("UPDATE statements SET
			subject=REPLACE(subject,'$fromNS','$toNS'),predicate=REPLACE(predicate,'$fromNS','$toNS'),object=REPLACE(object,'$fromNS','$toNS')
			WHERE modelID='{$this->modelID}'");
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function removeDuplicateStatements() {

/*		$res=$this->dbConn->execute('SELECT s1.id,s2.id FROM statements s1 INNER JOIN statements s2 USING(modelID,subject,predicate,object,object_is) WHERE modelID="'.$this->modelID.'"');
		while($row=$res->FetchRow()) {
			if($row[0]>$row[1])
			$res=$this->dbConn->execute('DELETE FROM statements WHERE id="'.$row[0].'"');
		}*/
		$res=$this->dbConn->execute('SELECT * FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' WHERE modelID IN ('.$this->getModelIds().')');
		while($row=$res->FetchRow()) {
			$hash=md5(serialize($row));
			if($exists[$hash])
				$this->dbConn->execute('DELETE FROM statements WHERE modelID="'.$row[0].'" AND subject="'.$row[1].'" AND predicate="'.$row[2].'" AND object="'.$row[3].'" AND object_is="'.$row[4].'" LIMIT 1');
			else
				$exists[$hash]=true;
		}
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function listLists() {
		
		$sql='SELECT s1.subject,s2.subject FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s1
				LEFT JOIN '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s2 ON(s1.modelID=s2.modelID AND s1.subject=s2.object AND s2.predicate="'.$this->_dbId('rdf:rest').'")
			WHERE s1.predicate="'.$this->_dbId('rdf:first').'"
				AND s1.modelID IN ('.$this->getModelIds().') HAVING ISNULL(s2.subject)';
		$res=$this->dbConn->execute($sql);
		$ret = $this->_convertRecordSetToNodeList($res);


		return $ret;
	}
	
#######################################################################################################################
#######################################################################################################################
## 
## methods that are overwritten for performance reasons, but that have a default implementation
##	
#######################################################################################################################
#######################################################################################################################

	/**
 	* Overwritten for perfomance reasons.
 	*
 	* @see DefaultRDFSModel
 	*/
	public function countInstances($includeImports = true) {
	
		$clsql='';
		foreach($this->vocabulary['Class'] as $cl)
			$clsql.="OR s1.object='".$cl->getURI()."'";
		$sql="SELECT COUNT(s1.modelID) FROM
				".$GLOBALS['RAP']['conf']['database']['tblStatements']." s1 INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s2
					ON((s1.modelID=s2.modelID".(!empty($this->importsIds)?" OR s1.modelID IN (".$this->getModelIds().')':'').")
						AND s1.predicate='".$this->_dbId('RDF_type')."'
						AND (1=0 $clsql)
						AND s2.predicate='".$this->_dbId('RDF_type')."'
						AND s2.object=s1.subject
					)
				WHERE s2.modelID IN (".($includeImports?$this->getModelIds():$this->modelID).")";
		return $this->dbConn->getOne($sql);
	}
	
	/**
 	* Overwritten for perfomance reasons.
 	*
 	* @see DefaultRDFSModel
 	*/
	public function countTriples($includeImports = true) {
		
		return $this->dbConn->getOne("SELECT COUNT(modelID) FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
			WHERE modelID IN (".($includeImports?$this->getModelIds():$this->modelID).")");
	}

#######################################################################################################################
#######################################################################################################################
## 
## INTERNAL METHODS
##	
#######################################################################################################################
#######################################################################################################################

	/**
 	 * General method to search for triples in the DbModel.
	 * NULL input for any parameter will match anything.
	 * Example:  $result = $m->query( NULL, NULL, $node );
	 *           Finds all triples with $node as object.
	 *
	 * @param	object Resource	$subject
	 * @param	object Resource	$predicate
	 * @param	object Node	$object
	 * @return	object ADORecordSet
	 * @throws	PhpError
	 * @throws  SqlError
	 * @access	protected
	 */
	protected function query($subject,$predicate,$object,$start=0,$count='') {
		if(!($subject instanceof Node) && $subject!=NULL)
			$subject=new $this->resource($subject,$this);
		if(!($predicate instanceof Node) && $predicate!=NULL)
			$predicate=new $this->resource($predicate,$this);
		if(!($object instanceof Node) && $object != NULL)
			$object=new $this->resource($object,$this);
		// static part of the sql statement
		$sql="SELECT subject,predicate,object,l_language,l_datatype,subject_is,object_is,id
			FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." WHERE modelID IN (".$this->getModelIds().')';
		// dynamic part of the sql statement
		foreach(array('subject','predicate','object') as $o)
			if($$o && method_exists($$o,'isBlankNode') && $$o->isBlankNode())
				$$o=new Blanknode($$o->uri);
		$sql.=$this->_createDynSqlPart_SPO($subject, $predicate, $object).(!$count?" ORDER BY subject, predicate, object":'');
		// execute the query
#if($subject->uri=='bN4500580ac116e3')
#echo($sql);
#exit;
		if($count)
			$recordSet =& $this->dbConn->PageExecute($sql,$count,$start/$count+1);
		else
			$recordSet =& $this->dbConn->execute($sql);
		if (!$recordSet)
			echo $this->dbConn->errorMsg();
		else
			return $recordSet;
	}
	
	/**
	 * Helper function for logging statement add or removes.
	 *
	 * @param $statement
	 * @param $ar
	 * @return
	 * @access	private
	 **/
	protected function log($statement,$ar) {
		if(!$this->logEnabled())
			return;
		if(!empty($this->logActions))
			$actionId=$this->logActions[0];
		else {
			$actionId=$this->logStart('Statement '.($ar=='a'?'added':'removed'));
			$this->logEnd();
		}
		if(!method_exists($statement,'subject')) {
			// print_r($statement);
		}
		$subject_is=$this->_getNodeFlag($statement->subject());
		$sql="INSERT INTO log_statements VALUES (NULL,'".$statement->getLabelSubject()."','".$statement->getLabelPredicate()."',";
		if(($statement->object() instanceof Literal)) {
			$quotedLiteral = $this->dbConn->qstr($statement->obj->getLabel());
			$sql.=$quotedLiteral.",'".$statement->obj->getLanguage()."','".$statement->obj->getDatatype()."',"
				."'".$subject_is ."','l','$ar','$actionId')";
		} else {
			$object_is=$this->_getNodeFlag($statement->object());
			$sql.="'" .$statement->obj->getLabel()."','','','" .$subject_is."','".$object_is ."','$ar','$actionId')";
		}
		$rs=&$this->dbConn->execute($sql);
		if(!$rs)
			$this->dbConn->errorMsg();
	}
	
#######################################################################################################################
#######################################################################################################################
## 
## methods that should be declared protected, but that are used outside of the RDFSModel class.
##	
#######################################################################################################################
#######################################################################################################################
	
	/**
	 * Convert an ADORecordSet to an array of RDFS Resources or Literals.
	 *
	 * Every successful database query returns an ADORecordSet object which is actually
	 * a cursor that holds the current row in the array fields[].
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * !!! This method can only be applied to a RecordSet with array fields[]
	 * !!! containing at least two elements:
	 * !!! [0] - resource
	 * !!! [1] - resource type, i.e. 'r' for resource, 'b' for blank node, 'l' for literals
	 * !!! [2] - l_language
	 * !!! [3] - l_datatype
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 *
	 * @param   object  ADORecordSet
	 * @return  array  Array of RDFSResources
	 * @access	private
	 */
	function _convertRecordSetToNodeList(&$recordSet,$class='RDFSResource',$start=0,$count=100000,$erg=0)  {
		if(is_string($recordSet)) {
			if($count)
				$recordSet=$this->dbConn->PageExecute($recordSet,$count,$start/$count+1);
			else
				$recordSet=$this->dbConn->execute($recordSet);
			$erg=$recordSet->_maxRecordCount?$recordSet->_maxRecordCount:$recordSet->_numOfRows;
		}
		
		if(($recordSet instanceof ADORecordSet))
			$recordSet=$recordSet->getArray();
		$ret=array();
		if ($recordSet != null) {
			foreach($recordSet as $fields) {
				if($fields[1]=='l')
					$res=new RDFSLiteral($fields[0],$fields[2],$fields[3]);
				else if($fields[1]=='b' && !$class)
					$res=new BlankNode($fields[0]);
				else if($class) {
					if(strtolower($class)=='resource')
						$res=$this->resourceF($fields[0]);
					else if(strtolower($class)=='class')
						$res=$this->classF($fields[0]);
					else if(strtolower($class)=='property')
						$res=$this->propertyF($fields[0]);
					else if(strtolower($class)=='instance')
						$res=$this->instanceF($fields[0]);
					else
						$res=new $class($fields[0],$this);
					if($fields[1]=='b')
						$res->uri=$fields[0];
				} else
					$res=$this->resourceF($fields[0]);
				if(method_exists($res,'getLocalName') && $res->getLocalName())
					$ret[$res->getLocalName()]=$res;
				else
					$ret[]=$res;
			}
		}
		return $ret;
	}
	
	/**
	 * Convert an ADORecordSet to a memory Model.
	 *
	 * Every successful database query returns an ADORecordSet object which is actually
	 * a cursor that holds the current row in the array fields[].
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * !!! This method can only be applied to a RecordSet with array fields[]
	 * !!! containing a representation of the database table: statements,
	 * !!! with an index corresponding to following table columns:
	 * !!! [0] - subject, [1] - predicate, [2] - object, [3] - l_language,
	 * !!! [4] - l_datatype, [5] - subject_is, [6] - object_is
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 *
	 * @param   object  ADORecordSet
	 * @return  object  MemModel
	 * @access	private
	 */
	function _convertRecordSetToMemModel(&$recordSet)  {
		$res = new MemModel($this->baseURI);
		if($recordSet)
		while (!$recordSet->EOF) {
			if(method_exists($this,'_convertRowToStatement')) {
#				print_r($this);
				$stm=$this->_convertRowToStatement($recordSet->fields);
				$res->add($stm);
			}
			$recordSet->moveNext();
		}
		return $res;
	}
	
	function _convertRowToStatement($row) {
		$sub=$row[5]=='r'?$this->resourceF($row[0]):new BlankNode($row[0]);
		$pred=$this->resourceF($row[1]);
		// object
		if($row[6]=='l')
			$obj=new RDFSLiteral($row[2],$row[3],$row[4]);
		else if($row[6] == 'b')
			$obj=new BlankNode($row[2]);
		else
			$obj=$this->resourceF($row[2]);
		$stm=new Statement($sub,$pred,$obj);
		$stm->dbId=$row[7];
		return $stm;
	}
	
	/**
	 * RDFSModel::_getNodeFlag()
	 *
	 * @param $object
	 * @return
	 * @access	private
	 */
	function _getNodeFlag($object)  {
		if ($object instanceof Blanknode || (method_exists($object, 'isBlankNode') && $object->isBlankNode())) {
			return 'b';
		} elseif ($object instanceof Resource) {
			return 'r';
		} else {
			return 'l';
		}
	}
	/**
	 * RDFSModel::_dbId()
	 *
	 * @param $resource
	 * @return
	 * @access	private
	 */
	function _dbId($resource) {
		if(is_string($resource))
			$resource=($GLOBALS[$resource] instanceof Resource)?$GLOBALS[$resource]:new $this->resource($resource,$this);
		return $resource->getURI();
	}
	function _dbIds($resources) {
		$ret=array();
		foreach($resources as $resource)
			$ret[]=$this->_dbId($resource);
		return $ret;
	}
	
	/**
	 * Return a statement from a ADORecordSet resulting from a
	 * query to the statement table.
	 *
	 * @param   object  ADORecordSet
	 * @return  object  Statement
	 * @access	private
	 */
	function fetchStatementFromRecordSet(&$recordSet)  {
		if($recordSet->EOF)
			return false;
		// subject
		$sub=$recordSet->fields[5] == 'r'?new $this->resource($recordSet->fields[0],$this):new BlankNode($recordSet->fields[0]);
		// predicate
		$pred=new $this->resource($recordSet->fields[1],$this);
		// object
		if ($recordSet->fields[6]=='r')
			$obj=new $this->resource($recordSet->fields[2],$this);
		else if($recordSet->fields[6]=='b')
			$obj=new BlankNode($recordSet->fields[2]);
		else {
			$obj=new Literal($recordSet->fields[2], $recordSet->fields[3]);
			if($recordSet->fields[4])
				$obj->setDatatype($recordSet->fields[4]);
		}
		$recordSet->moveNext();

		return new Statement($sub,$pred,$obj);
	}

/**
 * methods that are not used in OntoWiki, but that are still existing in the api
 */
// TODO check whether this methods are really not used!	
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function rdqlQuery($queryString, $returnNodes = TRUE) {
		$args=func_get_args();
		$c=cache('rdqlQuery'.$this->modelURI,$args);
		if($c!==NULL)
			return $c;

		include_once(RDFAPI_INCLUDE_DIR.PACKAGE_RDQL);
		$parser=new RdqlParser();
		$parsedQuery=&$parser->parseQuery($queryString);

		// this method can only query this DbModel
		// if another model was specified in the from clause throw an error
		if (isset($parsedQuery['sources'][0]))
			if($parsedQuery['sources'][0] != $this->modelURI) {
				$errmsg = RDFAPI_ERROR . '(class: DbModel; method: rdqlQuery):';
				$errmsg .= ' this method can only query this DbModel';
				trigger_error($errmsg, E_USER_ERROR);
			}

		$engine=new RdqlDbEngine();
		$engine->parsedQuery=&$parsedQuery;

		$sql=$engine->generateSql($this->getModelIds());
		$recordSet=&$this->dbConn->execute($sql);
        if ($recordSet instanceof ADORecordSet) {
    		$queryResult=$engine->filterQueryResult($recordSet);
        }

		return cache('rdqlQuery'.$this->modelURI,$args,$returnNodes?$engine->toNodes($queryResult):$engine->toString($queryResult));
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function search($search, $where, $compare, $start = 0, $count = 0) {
		// dynamic part of the sql statement
		foreach($where as $whe)
			if($compare=='starts')
				$w[]="$whe like '$search%'";
			else if($compare=='contains')
				$w[]="$whe like '%$search%'";
			else if($compare=='regex')
				$w[]="$whe rlike '$search'";
			else {
				if($whe!='object') {
					$r=new $this->resource($search,$this);
					$w[]="$whe='".$this->_dbId($r)."'";
				} else
					$w[]="$whe='$search'";
			}
		// static part of the sql statement
		$sql="SELECT subject,predicate,object,l_language,l_datatype,subject_is,object_is
			FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." WHERE modelID IN (".$this->getModelIds().") AND (".join(' OR ',$w).')';
		$recordSet=$count?$this->dbConn->PageExecute($sql,$count,$start/$count+1):$this->dbConn->execute($sql);

		if(!$recordSet)
			echo $this->dbConn->errorMsg();
		else
			return $recordSet;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function searchFullText($search, $type = null, $start=0, $count = 10000, $erg = 0) {
		
		$sql='SELECT s.subject,s.predicate,s.object,s.l_language,s.l_datatype,s.subject_is,s.object_is,MATCH('.(is_string($type)?'subject':'s.object').') AGAINST (\''.$search.'\' /*!40001 IN BOOLEAN MODE */) AS score FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s
			'.(is_array($type)?'INNER JOIN '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s1 ON(s.modelID=s1.modelID AND s.subject=s1.subject AND s1.predicate="'.$this->_dbId('RDF_type').'" AND s1.object IN ("'.join('","',$type).'"))':'').'
			WHERE MATCH('.(is_string($type)?'subject':'s.object').') AGAINST (\''.$search.'\' /*!40001 IN BOOLEAN MODE */) AND s.modelID IN ('.$this->getModelIds().')'.
			(is_string($type)?' AND object_is=\'r\'':' AND s.object_is=\'l\'');
		if($type=='Classes')
			$sql.=' AND predicate=\''.$this->_dbId('RDF_type').'\' AND object IN (\''.join('\',\'',array_keys($this->vocabulary['Class'])).'\')';
		else if($type=='Properties')
			$sql.=' AND predicate=\''.$this->_dbId('RDF_type').'\' AND object IN (\''.join('\',\'',array_keys($this->vocabulary['Property'])).'\')';
		else if($type=='Instances')
			$sql.=' AND predicate=\''.$this->_dbId('RDF_type').'\' AND object NOT IN (\''.join('\',\'',array_keys(array_merge($this->vocabulary['Class'],$this->vocabulary['Property']))).'\')';
#	print_r($sql);
#	exit;
		$rs=$this->dbConn->PageExecute($sql,$count,$start/$count+1);
		$erg=$rs->_maxRecordCount?$rs->_maxRecordCount:$rs->_numOfRows;
		return $rs;
	}
	
	
	
	
	
	
	
	function listTopClassesImplicit($start=0,$count=100000,$erg=0) {
		$args=func_get_args();
		$c=cache('listTopClassesImplicit'.$this->modelURI,$args);
		if($c!==NULL)
			return $c;
		$sql="SELECT s1.object,s1.object_is,s2.object_is,s2.object,
				".(!strcasecmp(Zend_Registry::get('config')->database->params->type,'SQLite')?'0':"count(distinct s2.object_is)")." cois
		      FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s1 LEFT JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s2
		         ON(s1.object=s2.subject AND s2.modelID IN (".$this->getModelIds().") AND s2.predicate='".$this->_dbId('RDFS_subClassOf')."')
		      WHERE
			     s1.object_is<>'b' AND s1.predicate='".$this->_dbId('RDF_type')."' AND s1.modelID IN (".$this->getModelIds().")
			  GROUP BY s1.object
			  HAVING (cois=0 OR s2.object_is IS NULL) OR (cois=1 AND s2.object_is='b') OR
			  	s2.object='".$this->_dbId('RDFS_Resource')."' OR
				(1=0 AND s2.object_is='r' AND s2.object NOT LIKE '".$this->baseURI."%')
			  ORDER BY s1.subject";
		$topclasses=$this->_convertRecordSetToNodeList($sql,$this->vclass,$start,$count,&$erg);
		return cache('listTopClassesImplicit'.$this->modelURI,$args,$topclasses);
 	}
	function countClasses($includeImports=true) {
		$clsql='';
		foreach($this->vocabulary['Class'] as $cl)
			$clsql.=" OR object='".$cl->getURI()."'";
		return $this->dbConn->getOne("SELECT COUNT(modelID) FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
			WHERE modelID IN (".($includeImports?$this->getModelIds():$this->modelID).")
				AND subject_is!='b'	AND predicate='".$this->_dbId('RDF_type')."' AND (1=0 $clsql)");
	}
	function getInstance($uri) {
		$res=($uri instanceof Resource)?$uri:new $this->resource($uri,$this);
		$uri=$res->getURI();
		foreach($this->vocabulary['Class'] as $class) {
			$q="SELECT ?x WHERE (<".$uri.">,<rdf:type>,?x) (?x,<rdf:type>,<".$class->getURI().">)";
			$instance=$this->rdqlQuery($q);
			if($instance[0]['?x'])
				return new $this->instance($uri,$this);
		}
		return false;
	}
	function countProperties($includeImports=true) {
		$clsql='';
		foreach($this->vocabulary['Property'] as $cl)
			$clsql.="OR object='".$this->_dbId($cl)."'";
		return $this->dbConn->getOne("SELECT COUNT(modelID) FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
			WHERE modelID IN (".($includeImports?$this->getModelIds():$this->modelID).")
				AND predicate='".$this->_dbId('RDF_type')."' AND (1=0 $clsql)");
	}
	
/*******************************************************************************
 * NEW METHODS
 ******************************************************************************/
 
    /**
     * Helper function, which returns a list with inferred classes.
     *
     * @access protected
     * @param boolean $systemClasses Indicates whether system-classes (classes with rdf, rdfs or owl namespace)
     * should be returned or not. (default: false)
     * @return RDFSClass[]/OWLClass[] Returns an array of either RDFSClass objects or OWLClass objects.
     */
    protected function _listImplicitTopClasses($systemClasses = false) {
        
        
        $args = func_get_args();
		$c = cache('_listImplicitTopClasses'.$this->modelURI, $args);
        
        $sql = 'SELECT s1.object, s1.object_is
                FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s1 LEFT JOIN '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s2
                ON (s1.object=s2.subject AND s2.modelID IN (' . $this->getModelIds() . ') AND
                s2.predicate="' . $this->_dbId('RDFS_subClassOf') . '")
                LEFT JOIN '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s3
                ON (s1.object=s3.subject AND s3.modelID IN (' . $this->getModelIds() . ') AND
                s3.predicate="' . $this->_dbId('RDF_type') . '")
                WHERE s2.subject IS NULL AND s3.subject IS NULL AND s1.object_is = "r" AND 
                s1.predicate = "' . $this->_dbId('RDF_type') . '"
                AND s1.modelID IN (' . $this->getModelIds() . ') ';
        
        if (!$systemClasses) $sql .= 'AND s1.object NOT LIKE "' . RDF_NAMESPACE_URI . '%"
                                      AND s1.object NOT LIKE "' . RDF_SCHEMA_URI . '%"
                                      AND s1.object NOT LIKE "' . OWL_NS . '%" ';
                
        $sql .= 'GROUP BY s1.object
                 ORDER BY s1.object';
 
        $topClasses = $this->_convertRecordSetToNodeList($sql, $this->vclass);
        
        return cache('_listImplicitTopClasses'.$this->modelURI, $args, $topClasses);        
    }
    
    /**
     * Helper function, which returns a list of user-defined classes.
     *
     * @access protected
     * @param boolean $emptyClasses Indicates whether empty classes (classes that do not have any instances 
     * and which subclasses do not have instances, too) should be returned or not. (default: false)
     * @param boolean $systemClasses Indicates whether system-classes (classes with rdf, rdfs or owl namespace)
     * should be returned or not. (default: false)
     * @return RDFSClass[]/OWLClass[] Returns an array of either RDFSClass objects or OWLClass objects.
     */
    protected function _listDefinedTopClasses($emptyClasses = false, $systemClasses = false) {
        
        $args = func_get_args();
		$c = cache('_listDefinedTopClasses'.$this->modelURI, $args);
		
		$sql = 'SELECT s1.subject, s1.subject_is, MAX(s2.object_is) AS s2object_is, MAX(s2.object) AS s2object, 
    	        COUNT(DISTINCT s2.object_is) AS count_s2object_is
                FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s1 LEFT JOIN '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s2
                ON (s1.subject=s2.subject AND s2.modelID IN (' . $this->getModelIds() . ') AND
                s2.predicate="' . $this->_dbId('RDFS_subClassOf') . '")                         
                WHERE s1.modelID IN (' . $this->getModelIds() . ') AND
                s1.predicate = "' . $this->_dbId('RDF_type') . '" AND 
                (s1.object = "' . $this->_dbId('RDFS_Class') . '"
                 OR s1.object = "' . $this->_dbId('OWL_Class') . '"
                 OR s1.object = "' . $this->_dbId('OWL_DeprecatedClass') . '")
                AND s1.subject_is = "r" ';

         if (!$systemClasses) {
             $sql .= 'AND s1.subject NOT LIKE "' . RDF_NAMESPACE_URI . '%"
                      AND s1.subject NOT LIKE "' . RDF_SCHEMA_URI . '%"
                      AND s1.subject NOT LIKE "' . OWL_NS . '%" ';
         }

         $sql .= 'GROUP BY s1.subject, s1.subject_is
                  HAVING (count_s2object_is = 0 OR
                  (count_s2object_is = 1 AND s2object_is = "b") OR
                  (s2object = "' . $this->_dbId('RDFS_Resource') .'" 
                  OR s2object = "' . $this->_dbId('OWL_Thing') . '"))
                  ORDER BY s1.subject';
			
        $topClasses = $this->_convertRecordSetToNodeList($sql, $this->vclass);
        
		
        if (!$emptyClasses) {
            $temp = $topClasses;
            $topClasses = array();
            
            foreach ($temp as $t) {
                if (!$t->isEmpty(true)) $topClasses[] = $t;
            }
        }

        return cache('_listDefinedTopClasses'.$this->modelURI, $args, $topClasses);
    }

	/**
	 *
	 *
	 * @param string/Query $query
	 * @param SparqlEngineDb_ResultRenderer $renderer
	 * @return RDFSResource[]
	 */
	public function sparqlQuery($query, $renderer = null) {
		
		$args = func_get_args();
		$c = new stmCache('sparqlQuery', $args, $this);
		 	
		$cVal = $c->get();	
		if (null != $cVal) {
			return $cVal;
		}
		
		$result = $this->store->executeSparql($this, $query, null, $renderer);
		$c->set($result);
		
		return $result;
	}
	
	/**
	 *
	 *
	 * @param string/Query $query
	 * @param string $class
	 * @param SparqlEngineDb_ResultRenderer $renderer
	 * @return RDFSResource[]
	 */
	public function sparqlQueryAs($query, $class, $renderer = null) {

		return $this->store->executeSparql($this, $query, $class, $renderer);
	}
	
	public function getNamespaceForPrefix($prefix) {
		
		$sql = 'SELECT namespace FROM namespaces WHERE prefix = "' . $prefix .'" AND modelID IN (' . $this->getModelIds() . ')';
		
		$result = $this->_convertRecordSetToNodeList($sql);
		
		return $result[0];
	}
}
?>
