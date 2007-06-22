<?php
/**
 * RDFSmodel
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: model.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
class RDFSModel extends DefaultRDFSModel {
	function RDFSModel($store,$modelURI,$type=NULL) {
		$modelVars =& $store->dbConn->execute("SELECT modelURI, modelID, baseURI FROM models WHERE modelURI='" .$modelURI ."'");
		$this->modelID 	= $modelVars->fields[1];
		$this->baseURI 	= $this->_checkBaseURI($modelVars->fields[2]);
		parent::DefaultRDFSModel($store,$modelURI,$type);
	}
	
/*
 * methods that have to be overwritten for a specific backend
 */	
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function getParsedNamespaces() {
		
		$c=cache('getParsedNamespaces'.$this->modelURI,array());
		if($c!==NULL)
			return $c;
		$ret=array_flip($GLOBALS['default_prefixes']);
		// get namespace prefixes from SysOnt-Class "Model"
		if(0 && !empty($this->store->SysOnt) && $modelClass=$this->store->SysOnt->getClass('Model'))
			if($inst=$modelClass->findInstance(array('modelURI'=>$this->modelURI)))
				foreach($inst->listPropertyValuesPlain(Zend_Registry::get('SysOntSchemaURI').'modelXMLNS') as $prefix) {
					$ns=explode(':',$prefix,2);
					$ret[$ns[1].(ereg('[#/]$',$ns[1])?'':'#')]=$ns[0];
				}
		$pns=parent::getParsedNamespaces();
		$ret=array_filter($pns?array_merge($ret,$pns):$ret);
		return cache('getParsedNamespaces'.$this->modelURI,array(),$ret);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	protected function _createStatement($subj,$pred=false,$obj=false,$objLang='',$objDType='') {
		
		if(is_a($subj,'Statement'))
			return $subj;
		else if(is_numeric($subj) && !$pred)
			return $this->fetchStatementFromRecordSet($this->dbConn->execute("SELECT subject,predicate,object,l_language,l_datatype,subject_is,object_is FROM statements WHERE id='$subj'"));
		if(!is_a($subj,'Resource'))
			$subj=$this->resourceF($subj);
		if(!is_a($pred,'Resource'))
			$pred=$this->resourceF($pred);
		if(!is_a($obj,'Node')) {
			if($objLang || $objDType)
				$obj=new RDFSLiteral($obj,$objLang,is_a($objDType,'Resource')?$objDType->getURI():$objDType);
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
		
		Zend_Registry::set('cache', array());
		$statement=!$obj?$subj:$this->_createStatement($subj,$pred,$obj);
		parent::add($statement);
		$success=false;
		if($this->dbConn->Affected_Rows()===false || $this->dbConn->Affected_Rows()===1) {
			$success=true;
			stmCache::expire($statement);
			$this->logAdd($statement);
		} else
			trigger_error('Addition of statement <i>'.$statement->subj->getLabel().'->'.$statement->pred->getLabel().'->'.$statement->obj->getLabel().'</i> failed!',E_USER_WARNING);
		#queryCacheExpire($this->modelID,$statement->subj,$statement->pred,$statement->obj);
		return $success;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function remove($subj,$pred='',$obj='') {
		
		Zend_Registry::set('cache', array());
		$statement=$this->_createStatement($subj,$pred,$obj);
		#if(isBnode($statement->obj)) {
		#	$o=new $this->resource($statement->obj->getURI(),$this);
		#	$o->remove();
		#}
#print_r($statement->subj->toString().$statement->pred->toString().$statement->obj->toString());
		parent::remove($statement);
		$success=false;
		if($this->dbConn->Affected_Rows()===0 || $this->dbConn->Affected_Rows()===1) {
			$success=true;
			stmCache::expire($statement);
			$this->logRemove($statement);
		} else
			trigger_error('Deletion of statement <i>'.$statement->subj->getLabel().'->'.$statement->pred->getLabel().'->'.$statement->obj->getLabel().'</i> failed!',E_USER_WARNING);
		#queryCacheExpire($this->modelID,$statement->subj,$statement->pred,$statement->obj);
		return $success;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function listNamespaces() {

		$ret = array();

		foreach (array('subject', 'predicate', 'object') as $col) {
			$temp = $this->dbConn->getCol('SELECT SUBSTRING('.$col.',1,LOCATE("#",'.$col.')) ns FROM statements WHERE modelID IN ('.$this->getModelIds().')'.
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
				FROM statements WHERE modelID IN (".$this->getModelIds().") AND object_is='l' GROUP BY l_datatype");
		sort($ret);
		return $ret;
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function listLanguages() {
		
		$ret=$this->dbConn->getCol("SELECT l_language FROM statements
				WHERE modelID IN (".$this->getModelIds().") AND object_is='l' GROUP BY l_language");
		sort($ret);
		return array_filter($ret);
	}
	
	
	protected function _listResourcesCol($col,$search='',$start=0,$count=0,$erg=0) {
		
		$sql="SELECT $col res FROM statements
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
	public function listTopClasses($systemClasses = false, $emptyClasses = false, $implicitClasses = false) {
        
        if ($implicitClasses) {
            return array_merge($this->_listDefinedTopClasses($emptyClasses, $systemClasses), $this->_listImplicitTopClasses($systemClasses));
        } else return $this->_listDefinedTopClasses($emptyClasses, $systemClasses);
        
    }

	/**
	 * @see DefaultRDFSModel
	 */
	public function listClassLabelLanguages() {
		
		foreach($this->vocabulary['Class'] as $cl)
			$clsql.=" OR s2.object='".$cl->getURI()."'";
		$sql="SELECT s1.l_language
		      FROM statements s1 INNER JOIN statements s2
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
		      FROM statements s1 INNER JOIN statements s2
		         ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
		            AND s2.predicate='".$GLOBALS['RDF_type']->getURI()."'
		            AND (1=0 ".$clsql."))
				INNER JOIN statements s3 ON(s2.modelID=s3.modelID AND s1.predicate=s3.subject
					AND s3.predicate='".$GLOBALS['RDF_type']->getURI()."' AND s3.object='".$GLOBALS['OWL_AnnotationProperty']->getURI()."')
				WHERE (s1.modelID=".$this->modelID.str_replace('modelID','s1.modelID',$this->model->importsSQL).")
		      GROUP BY s3.subject";
#print_r($sql);
		return $this->dbConn->getCol($sql);
	}
	
	/**
	 * @see DefaultRDFSModel
	 */
	public function find($s, $p, $o, $start = 0, $count = 0, $erg = 0) {
		
		$args=func_get_args();
		$c=cache('find'.$this->modelURI,$args);
		if($c!==NULL)
			return $c;

		$rs=$this->query($s,$p,$o,$start,$count);
		$erg=$rs->_maxRecordCount?$rs->_maxRecordCount:$rs->_numOfRows;
		$c=&$this->_convertRecordSetToMemModel($rs);


		cache('find'.$this->modelURI,$args,$c);
		return $c;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	function listTopClassesImplicit($start=0,$count=100000,$erg=0) {
		$args=func_get_args();
		$c=cache('listTopClassesImplicit'.$this->modelURI,$args);
		if($c!==NULL)
			return $c;
		$sql="SELECT s1.object,s1.object_is,s2.object_is,s2.object,
				".(!strcasecmp(Zend_Registry::get('config')->database->params->type,'SQLite')?'0':"count(distinct s2.object_is)")." cois
		      FROM statements s1 LEFT JOIN statements s2
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
		return $this->dbConn->getOne("SELECT COUNT(modelID) FROM statements
			WHERE modelID IN (".($includeImports?$this->getModelIds():$this->modelID).")
				AND subject_is!='b'	AND predicate='".$this->_dbId('RDF_type')."' AND (1=0 $clsql)");
	}
	function getInstance($uri) {
		$res=is_a($uri,'Resource')?$uri:new $this->resource($uri,$this);
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
		return $this->dbConn->getOne("SELECT COUNT(modelID) FROM statements
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
                FROM statements s1 LEFT JOIN statements s2
                ON (s1.object=s2.subject AND s2.modelID IN (' . $this->getModelIds() . ') AND
                s2.predicate="' . $this->_dbId('RDFS_subClassOf') . '")
                LEFT JOIN statements s3
                ON (s1.object=s3.subject AND s3.modelID IN (' . $this->getModelIds() . ') AND
                s3.predicate="' . $this->_dbId('RDF_type') . '")
                WHERE s2.subject IS NULL AND s3.subject IS NULL AND s1.object_is <> "b" AND 
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
                FROM statements s1 LEFT JOIN statements s2
                ON (s1.subject=s2.subject AND s2.modelID IN (' . $this->getModelIds() . ') AND
                s2.predicate="' . $this->_dbId('RDFS_subClassOf') . '")                         
                WHERE s1.modelID IN (' . $this->getModelIds() . ') AND
                s1.predicate = "' . $this->_dbId('RDF_type') . '" AND 
                (s1.object = "' . $this->_dbId('RDFS_Class') . '"
                 OR s1.object = "' . $this->_dbId('OWL_Class') . '"
                 OR s1.object = "' . $this->_dbId('OWL_DeprecatedClass') . '")
                AND s1.subject_is <> "b" ';

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
		
		return $this->store->executeSparql($this, $query, null, $renderer);
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