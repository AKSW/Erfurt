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
 * @version $Id$
 */
class Erfurt_Owl_Model extends RDFSModel {
	
	/**
	  * @var The internal import URI cache. This is needed quite
	  *      often, hence cached.
	  */ 
	protected $importedUris = array();
	
	/**
	 * 
	 *
	 * @param Erfurt_Store_Default $store
	 * @param string $modelURI
	 */
	public function __construct(Erfurt_Store_Abstract $store, $modelURI) {
		
		parent::__construct($store, $modelURI, 'OWL'); // force type OWL
		
		// initialize the import ids for the owl:imports support
		$this->importsIds = null;
	}
	
	/**
	  * Adds an owl:import URI to the internam URI cache
	  *
	  * @param string $importedUri The graph URI to be added to the cache
	  */
	public function addImportUri($importedUri) {
		$this->importedUris[] = $importedUri;
	}
	
	/**
	  * Returns the internal import URI cache
	  */
	public function getImports() {
		return $this->importedUris;
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @param boolean/null expandNS
	 * @return Erfurt_Owl_Property
	 */
	public function classF($uri, $expandNS = true) {

		// iff $uri is already a Erfrut_Owl_Class instance return it directly
		if ($uri instanceof Erfurt_Owl_Class) {
			return $uri;
		} else if ($uri instanceof Resource) {
			$uriString = $uri->getURI();
			
			if (isset($this->_classCache["$uriString"])) {
				return $this->_classCache["$uriString"];
			} else {
				$r = new Erfurt_Owl_Class($uri, $this, false);
				$this->_classCache["$uriString"] = $r;
				
#debug
$GLOBALS['classFCount']++;
				return $r;
			}
		} else {
			// in case $uri is a string containing the uri look for cached value
			if (isset($this->_classCache["$uri"])) {
				return $this->_classCache["$uri"];
			} else {
				$r = new Erfurt_Owl_Class($uri, $this, $expandNS);
				$this->_classCache["$uri"] = $r;

#debug
$GLOBALS['classFCount']++;
					return $r;
			}
		}
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @param boolean/null expandNS
	 * @return Erfurt_Owl_Property
	 */
	public function propertyF($uri, $expandNS = true) {

#debug
$GLOBALS['propertyFCount']++;		
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

		// iff $uri is already a Erfrut_Owl_Instance instance return it directly
		if ($uri instanceof Erfurt_Owl_Instance) {
			return $uri;
		} else if ($uri instanceof Resource) {
			$uriString = $uri->getURI();
			
			if (isset($this->_instanceCache["$uriString"])) {
				return $this->_instanceCache["$uriString"];
			} else {
				$r = new Erfurt_Owl_Instance($uri, $this, false);
				$this->_instanceCache["$uriString"] = $r;
				
#debug
$GLOBALS['instanceFCount']++;
				return $r;
			}
		} else {
			// in case $uri is a string containing the uri look for cached value
			if (isset($this->_instanceCache["$uri"])) {
				return $this->_instanceCache["$uri"];
			} else {
				$r = new Erfurt_Owl_Instance($uri, $this, $expandNS);
				$this->_instanceCache["$uri"] = $r;

#debug
$GLOBALS['instanceFCount']++;
					return $r;
			}
		}
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @return Erfurt_Owl_Property
	 */
	public function addDatatypeProperty($uri) {
		
		$this->add($uri, EF_RDF_TYPE, EF_OWL_DATATYPE_PROPERTY);
		return $this->propertyF($uri);
	}
	
	/**
	 *
	 *
	 * @param string/Resource $uri
	 * @return Erfurt_Owl_Property
	 */
	public function addObjectProperty($uri) {
		
		$this->add($uri, EF_RDF_TYPE, EF_OWL_OBJECT_PROPERTY);
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
	 * @return Erfurt_Rdfs_Resource[]
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
	 * @return Erfurt_Rdfs_Resource[]
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
	 * @return Erfurt_Rdfs_Resource[]
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
	 * @return Erfurt_Rdfs_Resource[]
	 */
	public function listAllDifferentSets() {
// TODO check method name		
		return $this->findNodes(null, EF_RDF_TYP, EF_OWL_ALLDIFFERENT);
	}
	
	/**
	 *
	 *
	 * @param string/Resource $set
	 * @param string/null $class
	 * @return Erfurt_Rdfs_Resource[]
	 */
	public function getAllDifferent($set, $class = null) {
		
		$distinctMembers = $this->findNode($set, 'owl:distinctMembers', null);
		return $this->getList($distinctMembers, $class);
	}
	
	/**
	 *
	 *
	 * @param string/Resource $set
	 * @param Erfurt_Rdfs_Resource[] $members
	 */
	public function setAllDifferent($set, $members) {
		
		$this->removeAllDifferent($set);
		$this->addAllDifferent($members);
	}
	
	/**
	 *
	 *
	 * @param Erfurt_Rdfs_Resource[] $members
	 */
	public function addAllDifferent($members) {
		
		$allDifferent = new BlankNode($this->getUniqueResourceURI(EF_BNODE_PREFIX));
		$this->add($allDifferent, EF_RDF_TYPE, 'owl:AllDifferent');
		$distinctMembers = $this->addList($members, false);
		$this->add($allDifferent, 'owl:distinctMembers', $distinctMembers);
	}
	
	/**
	 *
	 *
	 * @param string/Resource $set
	 */
	public function removeAllDifferent($set) {
		
		if(!($set instanceof Erfurt_Rdfs_Resource))	$set = $this->resourceF($set);
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