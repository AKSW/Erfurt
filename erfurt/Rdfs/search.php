<?php
/**
 * RDFSmodel
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: search.php 549 2006-03-06 02:19:04Z soerenauer $
 * @access public
 **/
class InstanceSearch {
	var $model;
	var $searchString;
	var $classes;
	var $properties;
	function InstanceSearch(&$model,$searchString,$classes=array(),$properties=array()) {
		$this->model=&$model;
		$this->allModels=$model?false:true;
		$this->searchString=$searchString;
		$this->classes=$classes;
		foreach($this->classes as $class) {
			$cl=$this->model->classF($class);
			$this->classes=array_merge($this->classes,$cl->listSubClassesRecursive());
		}
		$this->properties=$properties;
	}
	function _generateSQL($select) {
		$sql='SELECT '.$select.'
			FROM statements s INNER JOIN statements s1 ON(
				'.(!$this->allModels?'s1.modelID IN ('.$this->model->getModelIds().') AND':'').'
				s.subject=s1.subject AND
				s1.predicate="'.$GLOBALS['RDF_type']->getURI().'")
			WHERE
				MATCH(s.object) AGAINST (\''.$this->searchString.'\' /*!40001 IN BOOLEAN MODE */) AND
				'.(!$this->allModels?'s.modelID IN ('.$this->model->getModelIds().') AND':'').'
				s.object_is=\'l\'';
		if($this->instancesOnly)
			$sql.=' AND s1.object NOT IN (\''.join('\',\'',array_keys(array_merge($this->model->vocabulary['Class'],$this->model->vocabulary['Property']))).'\')';
		else if($this->propertiesOnly)
			$sql.=' AND s1.object IN (\''.join('\',\'',array_keys($this->model->vocabulary['Property'])).'\')';
		if($this->classes)
			$sql.=' AND s1.object IN (\''.join('\',\'',$this->classes).'\')';
		if($this->properties)
			$sql.=' AND s.predicate IN (\''.join('\',\'',$this->properties).'\')';
		return $sql;
	}
	function listClasses() {
		$sql=$this->_generateSQL('s1.object,COUNT(DISTINCT s.subject),COUNT(*),AVG(MATCH(s.object) AGAINST (\''.$this->searchString.'\' /*!40001 IN BOOLEAN MODE */)) AS score').' GROUP BY s1.object';
		return $GLOBALS['powl']->dbConn->getAll($sql);
	}
	function listProperties() {
		$sql=$this->_generateSQL('s.predicate,COUNT(DISTINCT s.subject),COUNT(*),AVG(MATCH(s.object) AGAINST (\''.$this->searchString.'\' /*!40001 IN BOOLEAN MODE */)) AS score').' GROUP BY s.predicate';
		return $GLOBALS['powl']->dbConn->getAll($sql);
	}
	function search($start=0,$count=10,$erg=0) {
		$sql=$this->_generateSQL('s.subject,s.predicate,s.object,s.l_language,s.l_datatype,s.subject_is,s.object_is,s.id,s.modelID,MATCH(s.object) AGAINST (\''.$this->searchString.'\' /*!40001 IN BOOLEAN MODE */) AS score,COUNT(DISTINCT s.subject,s.predicate,s.object,s.l_language,s.l_datatype,s.subject_is,s.object_is)').' GROUP BY s.subject';
		$rs=$GLOBALS['powl']->dbConn->PageExecute($sql,$count,$start/$count+1);
		$erg=$rs->_maxRecordCount?$rs->_maxRecordCount:$rs->_numOfRows;
		return $rs;
	}
	function searchInstance($instance) {
		$sql=$this->_generateSQL(' DISTINCT s.subject,s.predicate,s.object,s.l_language,s.l_datatype,s.subject_is,s.object_is,s.id,s.modelID,MATCH(s.object) AGAINST (\''.$this->searchString.'\' /*!40001 IN BOOLEAN MODE */) AS score').' AND s.subject="'.$this->model->_dbId($instance).'"';
#print $sql;
		$rs=$GLOBALS['powl']->dbConn->execute($sql);
		$erg=$rs->_maxRecordCount?$rs->_maxRecordCount:$rs->_numOfRows;
#print_r($rs);
		return $rs;
	}
}

?>