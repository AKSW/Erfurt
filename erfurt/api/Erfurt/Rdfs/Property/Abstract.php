<?php
/**
 * RDFSProperty
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id$
 * @access public
 **/
abstract class Erfurt_Rdfs_Property_Abstract  extends RDFSResource {
	
	/**
	 * Gets the domain for the property
	 *
	 * @return array $ret
	 **/
	public function listDomain() {
		
		$ret=$this->listPropertyValues($GLOBALS['RDFS_domain'],'Class');
		foreach($this->listSuperProperties() as $sup)
			$ret=array_merge($ret,$sup->listDomain());
		return $ret;
	}
	
	public function getDomain() {
		
		return parray_shift($this->listDomain());
	}
	
	/**
	 * Adds classes to the domain of the property.
	 *
	 * @param mixed $class Class or array of classes to add.
	 * @return
	 **/
	public function addDomain($classes) {
		
		if(!$classes) return;
		if(!is_array($classes))
			$classes=array($classes);
		foreach($classes as $class) {
			if(!($class instanceof RDFSClass))
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
	public function setDomain($classes) {
		
		$this->setPropertyValues($GLOBALS['RDFS_domain'],$classes);
	}
	
	/**
	 * Removes classes from the domain of the property.
	 *
	 * @param mixed $class Class or array of classes to add.
	 * @return
	 **/
	public function removeDomain($class='') {
		
		$d=$this->model->find($this,$GLOBALS['RDFS_domain'],$class?$class:NULL);
		foreach($d->triples as $stm)
			$this->model->remove($stm);
	}
	
	/**
	 * Gets the range of the property
	 *
	 * @return RDFSResource/Literal $range
	 **/
	public function listRange() {
		
		if($range=$this->listPropertyValues($GLOBALS['RDFS_range'],'Class'))
			return $range;
		else
			foreach($this->listSuperProperties() as $supp)
				if($supp->listRange())
					return $supp->listRange();
		return array();
	}
	
	public function getRange() {
		
		return parray_shift($this->listRange());
	}
	
	/**
	 * Adds the property to the specified ranges.
	 *
	 * @param mixed $ranges Ranges for the property
	 * @return
	 **/
	public function addRange($ranges) {
		
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
	public function setRange($ranges) {
		
		$this->setPropertyValues($GLOBALS['RDFS_range'],$ranges);
	}
	
	/**
	 * Remove the property from the specified ranges.
	 *
	 * @param mixed $ranges Ranges for the property
	 * @return
	 **/
	public function removeRange($range='') {
		
		if($range && !($range instanceof RDFSResource))
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
	public function listSubProperties() {
		
		return $this->listPropertyValuesObject($GLOBALS['RDFS_subPropertyOf'],'Property');
	}
	
	public function setSubProperties($values) {
		
		return $this->setPropertyValuesObject($GLOBALS['RDFS_subPropertyOf'],$values);
	}
	
	/**
	 * Gets all super-properties of the property
	 *
	 * @return array Array of RDFSProperty properties
	 **/
	public function listSuperProperties() {
		
		return $this->listPropertyValues($GLOBALS['RDFS_subPropertyOf'],'Property');
	}
	
	public function setSuperProperties($values) {
		
		return $this->setPropertyValues($GLOBALS['RDFS_subPropertyOf'],$values);
	}
	
	/**
	 * Add a sub-property of this property. If the sub-property is a URI instead
	 * of a RDFSProperty object - the sub-property will first be created.
	 *
	 * @param RDFSProperty $property A property that is a sub-property of this property.
	 * @return RDFSProperty The property created.
	 **/
	public function addSubProperty($property) {
		
		if(!($property instanceof RDFSProperty))
			$property=$this->model->addProperty($property);
		$this->model->add($property,$GLOBALS['RDFS_subPropertyOf'],$this);
		return $property;
	}
	
	/**
	 * @param $class
	 * @param boolean $resourcesOnly
	 * @param int $minDistinctValues
	 * @return int
	 */
	abstract public function countDistinctPropertyValues($class = null, $resourcesOnly = true, $minDistinctValues = 0);
	
	/**
	 * @param $class
	 * @param boolean $resourcesOnly
	 * @param int $start
	 * @param int $count
	 * @param int $erg
	 * @return array
	 */
	abstract public function listDistinctPropertyValues($class = null, $resourcesOnly = true, $start = 0, $count = 0, $erg = 0);
	
// TODO turn this into sparql or something equivalent, but do not use rdql!
	public function guessDomain() {
		
		$dom=array();
		$q="SELECT ?y WHERE (?x,<rdf:type>,?y) (?x,<".$this->getURI().">,?z)";
		foreach($this->model->rdqlQuery($q) as $res) if($res['?y'])
			$dom[$res['?y']->getLocalName()]=$res['?y'];
		return $dom;
	}
	
	public function guessRange() {
		
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
	
	/**
	 * @return int
	 */
	abstract public function guessMinCardinality();
	
	/**
	 * @return int
	 */
	abstract public function guessMaxCardinality() ;
	
	public function guessFunctional() {
		
		return $this->guessMaxCardinality()<=1?true:false;
	}
	
	public function guessType(){
		
		$distinctValues=$this->countDistinctPropertyValues(NULL,false);
		$distinctObjectValues=$this->countDistinctPropertyValues(NULL,true);
		if($distinctValues==$distinctObjectValues)
			return 'owl:ObjectProperty';
		else if($distinctObjectValues==0 && $distinctValues>0)
			return 'owl:DatatypeProperty';
	}
}
?>
