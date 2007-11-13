<?php
/*
 * Property.php
 * Encoding: UTF-8
 *
 * Copyright (c) 2004-2007 Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 *
 * This file is part of pOWL - web based ontology editor.
 *
 * pOWL is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * pOWL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with pOWL; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Erfurt_Owl_Property represents a property which can be either a datatype property or
 * a object property.
 * 
 * @package owl
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 */
class Erfurt_Owl_Property  extends RDFSProperty {
	
	/**
	 * Checks whether the domain of this property is an union class description.
	 *
	 * @return Resource/boolean Returns the domain iff the domain is an union class description, false otherwise.
	 */
	public function domainIsUnionClass() {
		
		if ($domain = $this->getDomain()) {
			if ($domain->listUnionOf()) return $domain;
		}
			
		return false;
	}
	
	/**
	 * 
	 *
	 * @param Resource $class
	 */
	public function addDomainToUnionClass($class) {
		
		if (!($domain = $this->domainIsUnionClass())) $this->setDomainToUnionClass($class);
		else $domain->setUnionOf(array_push($domain->getUnionOf(), $class));
	}
	
	/**
	 *
	 *
	 * @param Resource/Resource[] $members
	 */
	public function setDomainToUnionClass($members) {
		
		if (($members instanceof Resource) || (count($members) === 1)) $this->setDomain($members);
		else {
			if (!($domain = $this->domainIsUnionClass())) {
				$domain = $this->model->addAnonymousClass();
				$this->setDomain($domain);
			}
			$domain->setUnionOf($members);
		}
	}
	
	/**
	 *
	 *
	 * @return Resource[]
	 */
	public function listDomainFromUnionClass() {
		
		if (!($domain = $this->domainIsUnionClass())) {
			$domain = $this->getDomain();
			return $domain ? array($domain) : array();
		} else {
			return $domain->listUnionOf();
		}	
	}
	
	/**
	 * Checks whether the range of this property is an union class description.
	 *
	 * @return Resource/boolean Returns the range iff the range is an union class description, false otherwise.
	 */
	public function rangeIsUnionClass() {
		
		if ($range = $this->getRange()) {
			if ($range->listUnionOf()) return $range;
		}
		
		return false;
	}
	
	/**
	 * Checks whether the range of this property is an owl:DataRange.
	 *
	 * @return Resource/boolean Returns the range iff the range is an owl:DataRange, false otherwise.
	 */
	public function rangeIsDataRange() {
		
		if ($range = $this->getRange()) {
			if ($range->type('owl:DataRange')) return $range;
		}
			
		return false;
	}
	
	/**
	 * 
	 *
	 * @return RDFSResource[]
	 */
	public function listRangeFromDataRange() {
		
		if ($this->rangeIsDataRange()) return $this->model->getOneOf($this->getRange());
		else return false;
	}
	
	/**
	 * 
	 *
	 * @param Resource $class
	 */
	public function addRangeToUnionClass($class) {
		
		if(!($range = $this->domainIsUnionClass())) $this->setRangeToUnionClass($class);
		else $range->setUnionOf(array_push($range->getUnionOf(), $class));
	}
	
	/**
	 * 
	 *
	 * @param Resource/Resource[] $members
	 */
	public function setRangeToUnionClass($members) {
		
		if (($members instanceof Resource)) $this->setRange($range);
		else {
			$members = array_filter($members);
			
			if ((count($members) === 1) || (count($members) === 0))	$this->setRange($members);
			else {
				if (!($range = $this->rangeIsUnionClass())) {
					$range = $this->model->addAnonymousClass();
				}
				
				$this->setRange($range);
				$range->setUnionOf($members);	
			}
		}
	}
	
	/**
	 * 
	 *
	 * @param Resource[] $members
	 */
	public function setRangeToDataRange($members) {
		
		$data = $this->listRangeFromDataRange();
		
		if($data && ($members == array_keys($data))) return;
		
		$this->removeRange();
		$range = new Blanknode($this->model->getUniqueResourceURI(EF_BNODE_PREFIX));
		$this->model->add($range, 'rdf:type', 'owl:DataRange');
		$oneOf = $this->model->addList($members);
		$this->model->add($range, 'owl:oneOf', $oneOf);
		$this->addRange($range);
	}
	
	/**
	 * 
	 *
	 * @return Resource[]
	 */
	public function listRangeFromUnionClass() {
		
		if ($this->rangeIsDataRange()) return false;
		else if (!($range = $this->rangeIsUnionClass())) {
			$range = $this->getRange();
			return $range ? array($range->getLocalName()=>$range) : array();
		} else return $range->listUnionOf();
	}
	
	/**
	 * Returns an array of inverse OWLProperties indexed by their local names.
	 *
	 * @return Erfurt_Owl_Property[] An array of inverse OWLProperties indexed by their local names.
	 */
	public function listInverseOf() {
// TODO use a method with a better name than listPropertyValuesSymmetric
		return $this->listPropertyValuesSymmetric('owl:inverseOf', 'property');
	}
	
	/**
	 * Returns an array of equivalent OWLProperties indexed by their local names.
	 *
	 * @return Erfurt_Owl_Property[] An array of equivalent OWLProperties indexed by their local names.
	 */
	public function listEquivalentProperties() {
// TODO use a method with a better name than listPropertyValuesSymmetric		
		return $this->listPropertyValuesSymmetric('owl:equivalentProperty', 'property');
	}
	
	/**
	 * Sets inverse properties to the properties given in values.
	 *
	 * @param string[]/Resource[] $values An array of properties, property URIs or property local names.
	 * @return boolean
	 */
	public function setInverseOf($values) {
// TODO use a method with a better name than setPropertyValuesSymmetric
		return $this->setPropertyValuesSymmetric('owl:inverseOf', $values);
	}
	
	/**
	 * Sets equivalent properties to the properties given in values.
	 *
	 * @param string[]/Resource[] $values An array of properties, property URIs or property local names.
	 * @return boolean
	 */
	public function setEquivalentProperties($values) {
		
		return $this->setPropertyValuesSymmetric('owl:equivalentProperty', $values);
	}
	
	/**
	 * Checks if this property is of type owl:FunctionalProperty.
	 * If the optional parameter $bool is given, owl:FunctionalProperty
	 * will be set or removed according to $bool.
	 *
	 * @param boolean $bool Shall the property be set to be of type owl:FunctionalProperty - NULL - no change, TRUE - yes, FALSE - no.
	 * @return boolean True if the property is of type owl:FunctionalProperty, false otherwise.
	 */
	public function isFunctional($bool = null) {
// TODO add a setFunctional method
// TODO revise type method
		return $this->type('owl:FunctionalProperty', $bool);
	}
	
	/**
	 * Checks if this property is of type owl:InverseFunctionalProperty.
	 * If the optional parameter $bool is given, owl:InverseFunctionalProperty
	 * will be set or removed according to $bool.
	 *
	 * @param boolean $bool Shall the property be set to be of type owl:InverseFunctionalProperty - NULL - no change, TRUE - yes, FALSE - no.
	 * @return boolean True if the property is of type owl:InverseFunctionalProperty, false otherwise.
	 */
	public function isInverseFunctional($bool = null) {
// TODO add a setInverseFunctional method
		return $this->type('owl:InverseFunctionalProperty', $bool);
	}
	
	/**
	 * Checks if this property is of type owl:SymmetricProperty.
	 * If the optional parameter $bool is given, owl:SymmetricProperty
	 * will be set or removed according to $bool.
	 *
	 * @param boolean $bool Shall the property be set to be of type owl:SymmetricProperty - NULL - no change, TRUE - yes, FALSE - no.
	 * @return boolean True if the property is of type owl:SymmetricProperty, false otherwise.
	 */
	public function isSymmetric($bool = null) {
// TODO add a setSymmetric method		
		return $this->type('owl:SymmetricProperty', $bool);
	}
	
	/**
	 * Checks if this property is of type owl:TransitiveProperty.
	 * If the optional parameter $bool is given, owl:TransitiveProperty
	 * will be set or removed according to $bool.
	 *
	 * @param boolean $bool Shall the property be set to be of type owl:TransitiveProperty - NULL - no change, TRUE - yes, FALSE - no.
	 * @return boolean True if the property is of type owl:TransitiveProperty, false otherwise.
	 */
	public function isTransitive($bool = null) {
// TODO add a setTransitive method		
		return $this->type('owl:TransitiveProperty', $bool);
	}
	
	/**
	 * Checks if this property is of type owl:AnnotationProperty.
	 * If the optional parameter $bool is given, owl:AnnotationProperty
	 * will be set or removed according to $bool.
	 *
	 * @param boolean $bool Shall the property be set to be of type owl:AnnotationProperty - NULL - no change, TRUE - yes, FALSE - no.
	 * @return boolean True if the property is of type owl:AnnotationProperty, false otherwise.
	 */
	public function isAnnotation($bool = null) {
// TODO add a setAnnotation method	
		return $this->type('owl:AnnotationProperty', $bool);
	}
	
	/**
	 * Checks if this property is of type owl:DatatypeProperty.
	 * If the optional parameter $bool is given, it will be toggled between
	 * owl:DatatypeProperty and owl:ObjectProperty according to $bool.
	 *
	 * @param boolean $bool Shall the property be set to be of type owl:DatatypeProperty - NULL - no change, TRUE - yes, FALSE - no.
	 * @return boolean True if the property is of type owl:DatatypeProperty, false otherwise.
	 */
	public function isDatatypeProperty($bool = null) {
// TODO add a setDatatypeProperty method	
		if ($bool !== null) {
			if ($bool === true)	$this->removeType('oel:ObjectProperty');
			else $this->setType('owl:ObjectProperty');
		}
		
		return $this->type('owl:DatatypeProperty', $bool);
	}
	
	/**
	 * Checks if this property is of type owl:ObjectProperty.
	 * If the optional parameter $bool is given, it will be toggled between
	 * owl:ObjectProperty and owl:DatatypeProperty according to $bool.
	 *
	 * @param boolean $bool Shall the property be set to be of type owl:ObjectProperty - NULL - no change, TRUE - yes, FALSE - no.
	 * @return boolean True if the property is of type owl:ObjectProperty, false otherwise.
	 */
	public function isObjectProperty($bool=NULL) {
// TODO add a setObjectProperty method	
		if($bool !== null) {
			if($bool === true) $this->removeType('owl:DatatypeProperty');
			else $this->setType('owl:DatatypeProperty');
		}
		
		return $this->type('owl:ObjectProperty', $bool);
	}
}
?>