<?php
/**
 * The default implementation of the property interface. This implemenation is used by default.
 *
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @version $Id$
 */
class Erfurt_Rdfs_Property_Default extends Erfurt_Rdfs_Resource_Default implements Erfurt_Rdfs_Property {
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function addDomain($classes) {
		
		if ($classes instanceof RDFSClass) {
// TODO rename RDFSClass->addProperty
			$classes->addProperty($this);
		} else if (is_array($classes)) {
			foreach ($classes as $class) {
				$class = $this->model->getClass($class);
				if ($class instanceof RDFSClass) {
					$class->addProperty($this);
				}
			}
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function addRange($ranges) {
		
		if ($ranges instanceof RDFSClass) {
			$this->model->add($this, EF_RDFS_RANGE, $ranges);
		} else if (is_array($ranges)) {
			foreach ($ranges as $range) {
				if ($range) {
					$this->model->add($this, EF_RDFS_RANGE, $range);
				}
			}
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function addSubProperty($property) {
		
		if (!($property instanceof Erfurt_Rdfs_Property)) {
			$property = $this->model->propertyF($property);
		}
			
		$this->model->add($property, EF_RDFS_SUBPROPERTYOF, $this);
		return $property;
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function countDistinctPropertyValues($class = null, $resourcesOnly = true, $minDistinctValues = 0) {
		
		if (!($this->model->getStore() instanceof Erfurt_Store_CountableInterface)) {
// TODO error code
			throw new Erfurt_Exception('counting not supported');
		}
		
		if (($class !== null) && $class = $this->model->getClass($class)) {
			return $class->countInstancePropertyValues($this, $resourcesOnly, $minDistinctValues);
		} else if ($class !== null) {
			// this case counts all objects (distinct) of all statements, where this property is predicate, but only
			// where the subject is a owl:DatatypeProperty itself. 
// TODO put this case into the owl package...

			$owlDatatypeProp = new Resource(EF_OWL_DATATYPE_PROPERTY);

			return $this->model->getStore()->executeCountValuesOnMatchingSubjectType($this->model, $owlDatatypeProp,
				 		$this, true, true, false, (($resourcesOnly === true) ? false : true));		
		} else {
			// this case counts all objects (distinct) of all statements, where this property is predicate... 
			// (without blank nodes) executeCountValues($sub = null, $pred = $this, $distinct = true, $r = true, 
			// $b = false, $l = true)
			
			return $this->model->getStore()->executeCountValues($this->model, null, $this, true, true, false,
												(($resourcesOnly === true) ? false : true));	
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function getDomain() {
// TODO
		return array_shift($this->listDomain());
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function getRange() {
// TODO	
		return array_shift($this->listRange());
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function listDistinctPropertyValues($class = null, $resourcesOnly = true, $start = 0, $count = 0, $erg = 0) {
	
		if (($class !== null) && $class = $this->model->getClass($class)) {
			return $class->listInstancePropertyValues($this, $resourcesOnly);
		} else if ($class !== null) {
			// this case lists all objects (distinct) of all statements, where this property is predicate, but only
			// where the subject is a owl:DatatypeProperty itself. 
// TODO put this case into the owl package...

			$owlDatatypeProp = new Resource(EF_OWL_DATATYPE_PROPERTY);
	
			$result = $this->model->getStore()->executeFindOnMatchingSubjectType($this->model, $owlDatatypeProp, $this,
				 null, true, true, true, true, false, (($resourcesOnly === true) ? false : true));
			
			$ret = array();
			foreach ($result as $stm) {
				$ret[] = $stm->getObject();
			}
			return $ret;				
		} else {
			// this case lists all objects (distinct) of all statements, where this property is predicate... 
			// (without blank nodes) executeFind($s = null, $p = $this, $o = null, $distinct = true, $sR = true, 
			// $sB = true, $oR = true, $oB = false, $oL = true, $offset = 0, $limit = -1)
			
			$result = $this->model->getStore()->executeFind($this->model, null, $this, null, true, true, true, true,
							false, (($resourcesOnly === true) ? false : true));
			$ret = array();
			foreach ($result as $stm) {
				$ret[] = $stm->getObject();
			}
			return $ret;
		}
		
		return $this->model->_convertRecordSetToNodeList($sql);
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function listDomain() {
		
		$ret = $this->listPropertyValues(EF_RDFS_DOMAIN, 'class');
		
		foreach ($this->listSuperProperties() as $sup) {
			$ret = array_merge($ret, $sup->listDomain());
		}
			
		return $ret;
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function listRange() {
		
		if ($range = $this->listPropertyValues(EF_RDFS_RANGE, 'class')) {
			return $range;
		} else {
			foreach ($this->listSuperProperties() as $supp) {
				if ($supp->listRange()) {
					return $supp->listRange();
				}
			}
		}
			
		return array();
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function listSubProperties() {
		
		return $this->listPropertyValuesObject(EF_RDFS_SUBPROPERTYOF, 'property');
	}
	
	/**
	 * Erfurt_Rdfs_Property
	 */
	public function listSuperProperties() {
		
		return $this->listPropertyValues(EF_RDFS_SUBPROPERTYOF, 'property');
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function removeDomain(RDFSClass $class = null) {
		
		$d = $this->model->find($this, EF_RDFS_DOMAIN, $class);
		foreach ($d->triples as $stm) {
			$this->model->remove($stm);
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function removeRange(RDFSClass $range = null) {
		
		$r = $this->model->find($this, EF_RDFS_RANGE, $range);
		foreach ($r->triples as $stm) {
			$this->model->remove($stm);
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function setDomain($classes) {
		
		$this->setPropertyValues(EF_RDFS_DOMAIN, $classes);
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function setRange($ranges) {
		
		$this->setPropertyValues(EF_RDFS_RANGE, $ranges);
	}
	
	/**
	 * @see Erfurt_Rdfs_Property
	 */
	public function setSubProperties($values) {
		
		$this->setPropertyValuesObject(EF_RDFS_SUBPROPERTYOF, $values);
	}
	
	/**
	 * @see Erfurt_Rdfs_Property 
	 */
	public function setSuperProperties($values) {
		
		$this->setPropertyValues(EF_RDFS_SUBPROPERTYOF, $values);
	}
}
?>
