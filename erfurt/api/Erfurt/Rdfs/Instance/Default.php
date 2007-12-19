<?php
/**
 * The default implementation of the instance interface. This implemenation is used by default.
 *
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>
 * @author  Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @version $Id: $
 */
class Erfurt_Rdfs_Instance_Default extends Erfurt_Rdfs_Resource_Default {
	
	/**
	 * @see Erfurt_Rdfs_Instance
	 */
	public function addPropertyValue($prop, $value) {
		
		if (!($prop instanceof Erfurt_Rdfs_Property)) {
			$prop = $this->model->propertyF($prop);
		}
			
		$range = $prop->getRange();
		
		if (!in_array($value, $this->listPropertyValuesPlain($prop))) {
			if (!($value instanceof Node)) {
				if ($prop->isObjectProperty()) {
					$value = $this->model->resourceF($value);
				} else {
					if ($range) {
						$value = new Literal($value, '', $range->getURI());
					} else {
						$value = new Literal($value);
					}
				}
			}
			
			$this->model->add($this, $prop, $value);
		}	
	}
	
	/**
	 * @see Erfurt_Rdfs_Instance
	 */
	public function getPropertyValuePlain($prop) {
		
		if (!($prop instanceof Resource)) {
			$prop = $this->model->resourceF($prop);
		}
			
		$result = $this->model->findNode($this, $prop, null);
		
		if ($result !== null) {
			return $result->getLabel();
		} else {
			return '';
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Instance
	 */
	public function listAllPropertyValuesPlain() {
		
		$ret = array();
		foreach ($this->listProperties() as $class) {
			foreach ($class as $property) {
				$ret[$property->getLocalName()] = $this->listPropertyValuesPlain($property);
			}
		}
		
		return $ret;
	}
	
	/**
	 * @see Erfurt_Rdfs_Instance
	 */
	public function listProperties() {
		
		$prop = array();
		foreach ($this->listClasses() as $class) {
			$prop = array_merge($prop, $class->listProperties());
		}
		
		return array_reverse($prop);
	}
	
	/**
	 * Erfurt_Rdfs_Instance
	 */
	public function listPropertyValuesPlain($prop = '') {
		
		$ret = array();
		foreach ($this->model->findNodes($this, $prop, null) as $val) {
			$ret[] = ($val instanceof Resource) ? $val->getLocalName() : $val->getLabel();
		}
			
		return $ret;
	}
	
	/**
	 * @see Erfurt_Rdfs_Instance
	 */
	public function removePropertyValues($prop, $value = '') {
		
		if (!($prop instanceof Erfurt_Rdfs_Property)) {
			$prop = new $this->model->propertyF($prop);
		}
			
		if ($value && !($value instanceof Node)) {
			if ($prop->isObjectProperty()) {
				$value = $this->model->resourceF($value);
			} else {
				$value = new Literal($value);
			}
		}
			
		foreach ($this->model->findNodes($this, $prop, null) as $val) {
			if (!$value || ($value->getLabel() === $val->getLabel())) {
				$this->model->remove($this, $prop, $val);
			}
		}		
	}
	
	/**
	 * @see Erfurt_Rdfs_Instance
	 */
	public function setPropertyValue($prop,$value) {
		
		if (!($prop instanceof Erfurt_Rdfs_Property)) {
			$prop = $this->model->propertyF($prop);
		}
			
		$range = $prop->getRange();
		if ($this->model->findNode($this, $prop, null)) {
			$this->removePropertyValues($prop);
		}
			
		if (!($value instanceof Node)) {
			if (method_exists($prop, 'isObjectProperty') && $prop->isObjectProperty()) {
				$value = $this->model->resourceF($value);
			} else {
				if (isBnode($range) || !$range) {
					$value = new Literal($value);
				} else {
					$value = new Literal($value, '', $range->getURI());
				}
			}
		}
			
		$this->model->add($this, $prop, $value);
	}
}
?>
