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
	
	
//	function listTopClasses($start=0,$count=100000,$erg=0) {
//		$args=func_get_args();
//		$c=cache('listTopClasses'.$this->modelURI,$args);
//		if($c!==NULL)
//			return $c;
//		$clsql='';
//		foreach($this->vocabulary['Class'] as $cl)
//			$clsql.=" OR s1.object='".$cl->getURI()."'";
//		$sql="SELECT s1.subject,s1.subject_is,MAX(s2.object_is) AS s2object_is,MAX(s2.object) AS s2object,
//				".(!strcasecmp($GLOBALS['_POWL']['db']['type'],'SQLite')?'0':"count(distinct s2.object_is)")." AS cois
//		      FROM statements s1 LEFT JOIN statements s2
//		         ON(s1.subject=s2.subject AND s2.modelID IN (".$this->getModelIds().") AND s2.predicate='".$this->_dbId('RDFS_subClassOf')."')
//		      WHERE
//			     s1.subject_is<>'b' AND s1.predicate='".$this->_dbId('RDF_type')."' AND (1=0 $clsql)
//		         AND s1.modelID IN (".$this->getModelIds().")
//			  GROUP BY s1.subject,s1.subject_is
//			  HAVING (cois=0 OR s2object_is IS NULL"./*$this->dbConn->IfNull('s2.object_is','1=0').*/") OR (cois=1 AND s2object_is='b') OR
//			  	s2object='".$this->_dbId('RDFS_Resource')."' OR
//				(1=0 AND s2object_is='r' AND s2object NOT LIKE '".$this->baseURI."%')
//			  ORDER BY s1.subject";
//		$topclasses=$this->_convertRecordSetToNodeList($sql,$this->vclass,$start,$count,&$erg);
//		return cache('listTopClasses'.$this->modelURI,$args,$topclasses);
// 	}
 	
 
	function listTopClassesImplicit($start=0,$count=100000,$erg=0) {
		$args=func_get_args();
		$c=cache('listTopClassesImplicit'.$this->modelURI,$args);
		if($c!==NULL)
			return $c;
		$sql="SELECT s1.object,s1.object_is,s2.object_is,s2.object,
				".(!strcasecmp($GLOBALS['_POWL']['db']['type'],'SQLite')?'0':"count(distinct s2.object_is)")." cois
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
     * Returns a list with classes that are not part of a rdfs:subClassOf relation (top-classes).
     *
     * @param boolean $systemClasses Indicates whether system-classes (classes with rdf, rdfs or owl namespace)
     * should be returned or not. (default: false)
     * @param boolean $emptyClasses Indicates whether empty classes (classes that do not have any instances 
     * and which subclasses do not have instances, too) should be returned or not. (default: false)
     * @param boolean $implicitClasses Indicates whether classes that are inferred (classes, which have no explicit
     * definition, but which are the domain of at least one instance) should be returned or not. (default: false)
     * @return RDFSClass[]/OWLClass[] Returns an array of either RDFSClass objects or OWLClass objects.
     */
    public function listTopClasses($systemClasses = false, $emptyClasses = false, $implicitClasses = false) {
        
        if ($implicitClasses) {
            return array_merge($this->_listDefinedTopClasses($emptyClasses, $systemClasses), $this->_listImplicitTopClasses($systemClasses));
        } else return $this->_listDefinedTopClasses($emptyClasses, $systemClasses);
        
    }
    
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
}
?>