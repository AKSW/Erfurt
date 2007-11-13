<?php
/**
 * RDFSProperty
 * 
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004
 * @version $Id$
 */
class RDFSProperty extends Erfurt_Rdfs_Property_Abstract {

#######################################################################################################################
#######################################################################################################################
## 
## methods that have to be overwritten for a specific backend
##	
#######################################################################################################################
#######################################################################################################################
	
	/**
	 * @see DefaultRDFSProperty
	 */
	public function countDistinctPropertyValues($class = null, $resourcesOnly = true, $minDistinctValues = 0) {
		
		if ($class && $class=$this->model->getClass($class))
			return $class->countInstancePropertyValues($this,$resourcesOnly,$minDistinctValues);
		else if ($class !== null) {
			$sql = 'SELECT COUNT(DISTINCT s1.object, s1.object_is, s1.l_language, s1.l_datatype)
					FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s1 
					LEFT JOIN '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s2 ON (
						s1.subject = s2.subject AND
						s2.predicate = "' . $this->model->_dbId('RDF_type'). '" AND 
						s2.object = "' . $this->model->_dbId('OWL_DatatypeProperty') . '")
					WHERE 
						s2.subject IS NOT NULL AND
						s1.predicate = "' . $this->model->_dbId($this) . '" AND 
						s1.modelID IN (' . $this->model->getModelIds() . ') AND 
						s1.object_is <> "b"' . 
						($resourcesOnly ? ' AND s1.object_is = "r"' : '');
		} else {
			$sql = "SELECT COUNT(DISTINCT object,object_is,l_language,l_datatype) FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
				WHERE predicate='".$this->model->_dbId($this)."' AND modelID IN (".$this->model->getModelIds().") 
				AND object_is <> 'b' ".
				($resourcesOnly?" AND object_is='r'":'');
		}
		
		return $this->model->dbConn->getOne($sql);
	}
	
	/**
	 * @see DefaultRDFSProperty
	 */
	public function listDistinctPropertyValues($class = null, $resourcesOnly = true, $start = 0, $count = 0, $erg = 0) {
		
		$ret = array();
		
		//if(is_a($class,'resource'))
			//return $class->listInstancePropertyValues($this,$resourcesOnly);
		
		if ($class && $class=$this->model->getClass($class))
			return $class->listInstancePropertyValues($this, $resourcesOnly);
		else if ($class !== null) {
			$sql = 'SELECT s1.object, s1.object_is, s1.l_language, s1.l_datatype
					FROM '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s1 
					LEFT JOIN '.$GLOBALS['RAP']['conf']['database']['tblStatements'].' s2 ON (
						s1.subject = s2.subject AND
						s2.predicate = "' . $this->model->_dbId('RDF_type'). '" AND 
						s2.object = "' . $this->model->_dbId('OWL_DatatypeProperty') . '")
					WHERE 
						s2.subject IS NOT NULL AND
						s1.predicate = "' . $this->model->_dbId($this) . '" AND 
						s1.modelID IN (' . $this->model->getModelIds() . ') AND 
						s1.object_is <> "b"' . 
						($resourcesOnly ? ' AND s1.object_is = "r"' : '');				
		} else {
			$sql = "SELECT object,object_is,l_language,l_datatype FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
				WHERE predicate='".$this->model->_dbId($this)."' AND modelID IN (".$this->model->getModelIds().") 
				AND object_is <> 'b' ".
				($resourcesOnly?" AND object_is='r'":'')."
				GROUP BY object,object_is,l_language,l_datatype";
		}
		
		return $this->model->_convertRecordSetToNodeList($sql);
	}
	
	/**
	 * @see DefaultRDFSProperty
	 */
	public function guessMinCardinality() {
		
		$sql="SELECT MIN(c) FROM (
				SELECT COUNT(DISTINCT object) c FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
					WHERE predicate='".$this->model->_dbId($this)."' AND modelID IN (".$this->model->getModelIds().")
					GROUP BY subject,predicate) AS cs
			GROUP BY c";
		return $this->model->dbConn->getOne($sql);
	}
	
	/**
	 * @see DefaultRDFSProperty
	 */
	public function guessMaxCardinality() {
		
		$sql="SELECT MAX(c) FROM (
				SELECT COUNT(DISTINCT object) c FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']."
					WHERE predicate='".$this->model->_dbId($this)."' AND modelID IN (".$this->model->getModelIds().")
					GROUP BY subject,predicate) AS cs
			GROUP BY c";
		return $this->model->dbConn->getOne($sql);
	}
}
