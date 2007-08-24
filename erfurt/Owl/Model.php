<?php
/*
 * Model.php
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
 * Erfurt_Owl_Model represents an owl based knowledge base.
 *
 * @package owl
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: $
 */
class Erfurt_Owl_Model extends RDFSModel {
	
	/**
	 * 
	 *
	 * @param Erfurt_Store_Default $store
	 * @param string $modelURI
	 */
	public function __construct(Erfurt_Store_Default $store, $modelURI) {
		
		parent::__construct($store, $modelURI);
		
		// initialize the import ids for the owl:imports support
		$this->importsIds = array();
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @param boolean/null expandNS
	 * @return Erfurt_Owl_Property
	 */
	public function classF($uri, $expandNS = true) {
		
		return new Erfurt_Owl_Class($uri, $this, $expandNS); 
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @param boolean/null expandNS
	 * @return Erfurt_Owl_Property
	 */
	public function propertyF($uri, $expandNS = true) {
		
		return new Erfurt_Owl_Property($uri, $this, $expandNS); 
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @param boolean/null expandNS
	 * @return Erfurt_Owl_Property
	 */
	public function instanceF($uri, $expandNS = true) {
		
		return new Erfurt_Owl_Instance($uri, $this, $expandNS); 
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @return Erfurt_Owl_Property
	 */
	public function addDatatypeProperty($uri) {
		
		$this->add($uri, 'rdf:type', 'owl:DatatypeProperty');
		return $this->propertyF($uri);
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @return Erfurt_Owl_Property
	 */
	public function addObjectProperty($uri) {
		
		$this->add($uri, 'rdf:type', 'owl:ObjectProperty');
		return $this->propertyF($uri);
	}
	
	/**
	 * Returns all owl:ObjectPropertiy instances of the model.
	 *
	 * @return Erfurt_Owl_Property[] Returns an array of Erfurt_Owl_Property objects.
	 */
	public function listObjectProperties() {
		
		return $this->listRDFTypeInstancesAs('owl:ObjectProperty', 'property');
	}
	
	/**
	 * Returns all owl:FunctionalProperty instances of the model.
	 *
	 * @return Erfurt_Owl_Property[] Returns an array of Erfurt_Owl_Property objects.
	 */
	public function listFunctionalProperties() {
		
		return $this->listRDFTypeInstancesAs('owl:FunctionalProperty', 'property');
	}
	
	/**
	 * Returns all owl:InverseFunctionalProperty instances of the model.
	 *
	 * @return Erfurt_Owl_Property[] Returns an array of Erfurt_Owl_Property objects.
	 */
	public function listInverseFunctionalProperties() {
		
		return $this->listRDFTypeInstancesAs('owl:InverseFunctionalProperty', 'property');
	}
	
	/**
	 * Returns all owl:DatatypeProperty instances of the model.
	 *
	 * @return Erfurt_Owl_Property[] Returns an array of Erfurt_Owl_Property objects.
	 */
	public function listDatatypeProperties() {
		
		return $this->listRDFTypeInstancesAs('owl:DatatypeProperty', 'property');
	}
	
	/**
	 *
	 *
	 * @return Erfurt_Owl_Class[]
	 */
	public function listRestrictions() {
	
		return $this->findSubjectsForPredicateAs('owl:onProperty', 'class');
	}
	
	/**
	 *
	 *
	 * @return Erfurt_Rdfs_Class[]
	 */
	public function listTopClassesInfered() {
		
		$topClasses = $this->listTopClasses();
		
		foreach ($topClasses as $uri=>$topClass) {
			if(method_exists($topClass, 'listIntersectionOf')) {
				$inferedSuperClasses = $topClass->listIntersectionOf();
				
				foreach ($inferedSuperClasses as $inferedSuperClass) {
					if(!isBnode($inferedSuperClass)) unset($topClasses[$uri]);
				}
			}
		}
						
		return $topClasses;
	}
	
// TODO put this method in Erfurt_Owl_Class
// TODO revise this method
	public function listSubClassesInfered($class) {
		
		static $subClassesInfered;
		if(!is_array($subClassesInfered)) {
			$subClassesInfered=array();
			foreach($this->listTopClasses() as $key=>$topClass)
				if(method_exists($topClass,'listIntersectionOf') && $inferedSuperClasses=$topClass->listIntersectionOf())
					foreach($inferedSuperClasses as $inferedSuperClass)
						$subClassesInfered[$inferedSuperClass->getLocalName()][$topClass->getLocalName()]=$topClass;
		}
		return !empty($subClassesInfered[$class->getLocalName()])?$subClassesInfered[$class->getLocalName()]:array();
	}
	
	/**
	 *
	 *
	 * @param string[] $imports
	 */
	public function setImports($imports) {
		
		$this->asResource->setPropertyValues('owl:imports', $imports);
	}
	
	/**
	 *
	 *
	 * @return RDFSResource[]
	 */
	public function listPriorVersion() {
		
		return $this->asResource->listPropertyValues('owl:priorVersion');
	}
	
	/**
	 *
	 *
	 * @param string[] $values
	 */
	public function setPriorVersion($values) {
		
		$this->asResource->setPropertyValues('owl:priorVersion', $values);
	}
	
	/**
	 *
	 *
	 * @return RDFSResource[]
	 */
	public function listBackwardCompatibleWith() {
		
		return $this->asResource->listPropertyValues('owl:backwardCompatibleWith');
	}
	
	/**
	 *
	 *
	 * @param string[] $values
	 */
	public function setBackwardCompatibleWith($values) {
		
		$this->asResource->setPropertyValues('owl:backwardCompatibleWith', $values);
	}
	
	/**
	 *
	 *
	 * @return RDFSResource[]
	 */
	public function listIncompatibleWith() {
		
		return $this->asResource->listPropertyValues('owl:incompatibleWith');
	}
	
	/**
	 *
	 *
	 * @param string[] $values
	 */
	public function setIncompatibleWith($values) {
		
		$this->asResource->setPropertyValues('owl:incompatibleWith', $values);
	}
	
	/**
	 *
	 *
	 * @return RDFSResource[]
	 */
	public function listAllDifferentSets() {
// TODO check method name		
		return $this->findNodes(null, 'rdf:type', 'owl:AllDifferent');
	}
	
	/**
	 *
	 *
	 * @param string/Resource $set
	 * @param string/null $class
	 * @return RDFSResource[]
	 */
	public function getAllDifferent($set, $class = null) {
		
		$distinctMembers = $this->findNode($set, 'owl:distinctMembers', null);
		return $this->getList($distinctMembers, $class);
	}
	
	/**
	 *
	 *
	 * @param string/Resource $set
	 * @param RDFSResource[] $members
	 */
	public function setAllDifferent($set, $members) {
		
		$this->removeAllDifferent($set);
		$this->addAllDifferent($members);
	}
	
	/**
	 *
	 *
	 * @param RDFSResource[] $members
	 */
	public function addAllDifferent($members) {
		
		$allDifferent = new BlankNode($this->getUniqueResourceURI(EF_BNODE_PREFIX));
		$this->add($allDifferent, 'rdf:type', 'owl:AllDifferent');
		$distinctMembers = $this->addList($members, false);
		$this->add($allDifferent, 'owl:distinctMembers', $distinctMembers);
	}
	
	/**
	 *
	 *
	 * @param string/Resource $set
	 */
	public function removeAllDifferent($set) {
		
		if(!($set instanceof RDFSResource))	$set = $this->resourceF($set);
		$set->remove();
	}
	
	/**
	 *
	 *
	 * @return Erfurt_Owl_Class
	 */
	public function listIntersectionClasses() {
		
		return $this->findNodes(null, 'owl:intersectionOf', null, 'class');
	}
}
?>