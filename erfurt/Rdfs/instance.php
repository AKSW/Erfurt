<?php
/**
 * RDFSInstance
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: instance.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
class DefaultRDFSInstance extends RDFSResource {
	
	/**
	 * Returns an array of all properties defined for classes which this instance is instance of.
	 *
	 * @return array Array of all properties.
	 **/
	public function listProperties() {
		
		$prop=array();
		foreach($this->listClasses() as $class) {
			$prop=array_merge($prop,$class->listProperties());
		}
		return array_reverse($prop);
	}
	
	/**
	 * Returns the value (label) of a property.
	 *
	 * @param mixed $prop Property
	 *
	 * @return value of the property. the data type depends on the given widget
	 **/
	public function getPropertyValuePlain($prop) {
		
		static $cache;
		if(!($prop instanceof Resource))
			$prop=$this->model->resourceF($prop);

		if(empty($cache[$this->model->modelURI][$this->getURI()][$prop->getURI()]))
			$cache[$this->model->modelURI][$this->getURI()][$prop->getURI()]=($res=$this->model->findNode($this,$prop,NULL))?$res->getLabel():'';
		return $cache[$this->model->modelURI][$this->getURI()][$prop->getURI()];
	}

	/**
	 * Returns an array of the values (labels) of a property.
	 * TODO Depreciated!!!
	 *
	 * @param mixed $prop Property
	 *
	 * @return array Values of the property.
	 **/
	public function listPropertyValuesPlain($prop='') {
		
		$ret=array();
		foreach($this->model->findNodes($this,$prop,NULL) as $val)
			$ret[]=($val instanceof Resource)?$val->getLocalName():$val->getLabel();
		return $ret;
	}
	
	/**
	 * Returns an array of the values (labels) of all properties of the instance.
	 *
	 * @return array Values of the all properties of the instance.
	 **/
	public function listAllPropertyValuesPlain() {
		
		$ret=array();
		foreach($this->listProperties() as $class)
			foreach($class as $property)
				$ret[$property->getLocalName()]=$this->listPropertyValuesPlain($property);
		return $ret;
	}
	
	/**
	 * Sets a value for a property.
	 *
	 * @param RDFSProperty $prop,
	 * @param $value Value for the property.
	 * @return
	 **/
	public function setPropertyValue($prop,$value) {
		
		if(!($prop instanceof RDFSProperty))
			$prop=$this->model->propertyF($prop);
#print_r($prop);
		$range=$prop->getRange();
		if($this->model->findNode($this,$prop,NULL))
			$this->removePropertyValues($prop);
		if(!($value instanceof Node))
			$value=method_exists($prop,'isObjectProperty') && $prop->isObjectProperty()?
				$this->model->resourceF($value):
				new RDFSLiteral($value,'',isBnode($range) || !$range?'':$range->getURI());
		$this->model->add($this,$prop,$value);
	}
	
	/**
	 * Adds a value for a property. RDFSProperties might have
	 * more than one value.
	 *
	 * @param RDFSProperty $prop The property the value should be added to.
	 * @param $value Value for the property
	 * @return
	 **/
	public function addPropertyValue($prop,$value) {
		
		if(!($prop instanceof RDFSProperty))
			$prop=$this->model->propertyF($prop);
		$range=$prop->getRange();
		if(!in_array($value,$this->listPropertyValuesPlain($prop)))
			$this->model->add($this,$prop,($value instanceof Node)?$value:
				($prop->isObjectProperty()?$this->model->resourceF($value):new RDFSLiteral($value,'',$range?$range->getURI():NULL)));
	}
	
	/**
	 * Removes all property values of the given property.
	 *
	 * @param RDFSProperty $prop
	 * @param mixed $value
	 * @return
	 **/
	public function removePropertyValues($prop,$value='') {
		
		if(!($prop instanceof RDFSProperty))
			$prop=new $this->model->property($prop,$this->model);
		if($value && !($value instanceof Node))
			$value=$prop->isObjectProperty()?$this->model->resourceF($value):new RDFSLiteral($value);
		foreach($this->model->findNodes($this,$prop,NULL) as $val)
			if(!$value || $value->getLabel()==$val->getLabel()) {
				$this->model->remove($this,$prop,$val);
			}
	}
}
?>
