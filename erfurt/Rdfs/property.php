<?php
/**
 * RDFSProperty
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: property.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
class DefaultRDFSProperty  extends RDFSResource {
	/**
	 * Gets the domain for the property
	 *
	 * @return array $ret
	 **/
	function listDomain() {
		$ret=$this->listPropertyValues($GLOBALS['RDFS_domain'],'Class');
		foreach($this->listSuperProperties() as $sup)
			$ret=array_merge($ret,$sup->listDomain());
		return $ret;
	}
	function getDomain() {
		return parray_shift($this->listDomain());
	}
	/**
	 * Adds classes to the domain of the property.
	 *
	 * @param mixed $class Class or array of classes to add.
	 * @return
	 **/
	function addDomain($classes) {
		if(!$classes) return;
		if(!is_array($classes))
			$classes=array($classes);
		foreach($classes as $class) {
			if(!is_a($class,'RDFSClass'))
				$class=$this->model->getClass($class);
			$class->addProperty($this);
		}
	}
	/**
	 * Removes classes from the domain of the property
	 * and adds classes to the domain of the property.
	 *
	 * @param mixed $class Class or array of classes to add.
	 * @return
	 **/
	function setDomain($classes) {
		$this->setPropertyValues($GLOBALS['RDFS_domain'],$classes);
	}
	/**
	 * Removes classes from the domain of the property.
	 *
	 * @param mixed $class Class or array of classes to add.
	 * @return
	 **/
	function removeDomain($class='') {
		$d=$this->model->find($this,$GLOBALS['RDFS_domain'],$class?$class:NULL);
		foreach($d->triples as $stm)
			$this->model->remove($stm);
	}
	/**
	 * Gets the range of the property
	 *
	 * @return RDFSResource/Literal $range
	 **/
	function listRange() {
		if($range=$this->listPropertyValues($GLOBALS['RDFS_range'],'Class'))
			return $range;
		else
			foreach($this->listSuperProperties() as $supp)
				if($supp->listRange())
					return $supp->listRange();
		return array();
	}
	function getRange() {
		return parray_shift($this->listRange());
	}
	/**
	 * Adds the property to the specified ranges.
	 *
	 * @param mixed $ranges Ranges for the property
	 * @return
	 **/
	function addRange($ranges) {
		if(!is_array($ranges))
			$ranges=array($ranges);
		foreach($ranges as $range) if($range)
			$this->model->add($this,$GLOBALS['RDFS_range'],$range);
	}
	/**
	 * Removes the property from its old ranges and
	 * adds the property to the new specified ranges.
	 *
	 * @param mixed $ranges Ranges for the property
	 * @return
	 **/
	function setRange($ranges) {
		$this->setPropertyValues($GLOBALS['RDFS_range'],$ranges);
	}
	/**
	 * Remove the property from the specified ranges.
	 *
	 * @param mixed $ranges Ranges for the property
	 * @return
	 **/
	function removeRange($range='') {
		if($range && !is_a($range,'RDFSResource'))
			$range=new $this->model->resource($range,$this);
		$ranges=$this->model->find($this,$GLOBALS['RDFS_range'],$range?$range:NULL);
		foreach($ranges->triples as $range)
			$this->model->remove($range);
	}
	/**
	 * Gets all sub-properties of the property
	 *
	 * @return array Array of RDFSProperty properties
	 **/
	function listSubProperties() {
		return $this->listPropertyValuesObject($GLOBALS['RDFS_subPropertyOf'],'Property');
	}
	function setSubProperties($values) {
		return $this->setPropertyValuesObject($GLOBALS['RDFS_subPropertyOf'],$values);
	}
	/**
	 * Gets all super-properties of the property
	 *
	 * @return array Array of RDFSProperty properties
	 **/
	function listSuperProperties() {
		return $this->listPropertyValues($GLOBALS['RDFS_subPropertyOf'],'Property');
	}
	function setSuperProperties($values) {
		return $this->setPropertyValues($GLOBALS['RDFS_subPropertyOf'],$values);
	}
	/**
	 * Add a sub-property of this property. If the sub-property is a URI instead
	 * of a RDFSProperty object - the sub-property will first be created.
	 *
	 * @param RDFSProperty $property A property that is a sub-property of this property.
	 * @return RDFSProperty The property created.
	 **/
	function addSubProperty($property) {
		if(!is_a($property,'RDFSProperty'))
			$property=$this->model->addProperty($property);
		$this->model->add($property,$GLOBALS['RDFS_subPropertyOf'],$this);
		return $property;
	}
	
	function countDistinctPropertyValues($class = null, $resourcesOnly = true, $minDistinctValues = 0) {
		
		if ($class && $class=$this->model->getClass($class))
			return $class->countInstancePropertyValues($this,$resourcesOnly,$minDistinctValues);
		else if ($class !== null) {
			$sql = 'SELECT COUNT(DISTINCT s1.object, s1.object_is, s1.l_language, s1.l_datatype)
					FROM statements s1 
					LEFT JOIN statements s2 ON (
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
			$sql = "SELECT COUNT(DISTINCT object,object_is,l_language,l_datatype) FROM statements
				WHERE predicate='".$this->model->_dbId($this)."' AND modelID IN (".$this->model->getModelIds().") 
				AND object_is <> 'b' ".
				($resourcesOnly?" AND object_is='r'":'');
		}
		
		return $this->model->dbConn->getOne($sql);
	}
	
	function listDistinctPropertyValues($class = null, $resourcesOnly = true, $start = 0, $count = 0, $erg = 0) {
		
		$ret = array();
		
		//if(is_a($class,'resource'))
			//return $class->listInstancePropertyValues($this,$resourcesOnly);
		
		if ($class && $class=$this->model->getClass($class))
			return $class->listInstancePropertyValues($this, $resourcesOnly);
		else if ($class !== null) {
			$sql = 'SELECT s1.object, s1.object_is, s1.l_language, s1.l_datatype
					FROM statements s1 
					LEFT JOIN statements s2 ON (
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
			$sql = "SELECT object,object_is,l_language,l_datatype FROM statements
				WHERE predicate='".$this->model->_dbId($this)."' AND modelID IN (".$this->model->getModelIds().") 
				AND object_is <> 'b' ".
				($resourcesOnly?" AND object_is='r'":'')."
				GROUP BY object,object_is,l_language,l_datatype";
		}
		
		return $this->model->_convertRecordSetToNodeList($sql);
	}
	
	function guessDomain() {
		$dom=array();
		$q="SELECT ?y WHERE (?x,<rdf:type>,?y) (?x,<".$this->getURI().">,?z)";
		foreach($this->model->rdqlQuery($q) as $res) if($res['?y'])
			$dom[$res['?y']->getLocalName()]=$res['?y'];
		return $dom;
	}
	function guessRange() {
		$range=array();
		if($this->guessType()=='owl:ObjectProperty')
			$type='ob';
		else if($this->guessType()=='owl:DatatypeProperty')
			$type='dp';
		else return;
		$values=$this->listDistinctPropertyValues(NULL,false);
		foreach($values as $value) {
			if($type=='dp' && $value->getDatatype())
				$range[$value->getDatatype()]=$value->getDatatype();
			else if ($type=='ob') {
				if($c=$value->getClass())
					$range[$c->getLocalName()]=$c->getURI();
			}
		}
		return $range;
	}
	function guessMinCardinality() {
		$sql="SELECT MIN(c) FROM (
				SELECT COUNT(DISTINCT object) c FROM statements
					WHERE predicate='".$this->model->_dbId($this)."' AND modelID IN (".$this->model->getModelIds().")
					GROUP BY subject,predicate) AS cs
			GROUP BY c";
		return $this->model->dbConn->getOne($sql);
	}
	function guessMaxCardinality() {
		$sql="SELECT MAX(c) FROM (
				SELECT COUNT(DISTINCT object) c FROM statements
					WHERE predicate='".$this->model->_dbId($this)."' AND modelID IN (".$this->model->getModelIds().")
					GROUP BY subject,predicate) AS cs
			GROUP BY c";
		return $this->model->dbConn->getOne($sql);
	}
	function guessFunctional() {
		return $this->guessMaxCardinality()<=1?true:false;
	}
	function guessType(){
		$distinctValues=$this->countDistinctPropertyValues(NULL,false);
		$distinctObjectValues=$this->countDistinctPropertyValues(NULL,true);
		if($distinctValues==$distinctObjectValues)
			return 'owl:ObjectProperty';
		else if($distinctObjectValues==0 && $distinctValues>0)
			return 'owl:DatatypeProperty';
	}
}
?>