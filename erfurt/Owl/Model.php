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
 * OWLModel represents a owl based knowledge base.
 *
 * @package owl
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: $
 */
class Erfurt_Owl_Model extends Erfurt_Rdfs_ModelAbstract {
	
	public function __construct($store, $modelURI) {
		
		parent::__construct($store,$modelURI);
		$this->importsIds=array();
	}
	
	public function addDatatypeProperty($uri) {
		
		$this->add($uri,'rdf:type','owl:DatatypeProperty');
		return new $this->property($uri,$this);
	}
	
	public function addObjectProperty($uri) {
		
		$this->add($uri,'rdf:type','owl:ObjectProperty');
		return new $this->property($uri,$this);
	}
	
	/**
	 * Returns the OWL_ObjectProperties of the model
	 *
	 * @return array Array of RDFSProperty objects.
	 */
	public function listObjectProperties() {
		
		return $this->listTypes($GLOBALS['OWL_ObjectProperty'],'RDFSProperty');
	}
	
	/**
	 * Returns the functional properties of the model
	 *
	 * @return array Array of RDFSProperty objects.
	 */
	public function listFunctionalProperties() {
		
		return $this->listTypes($GLOBALS['OWL_FunctionalProperty'],'OWLProperty');
	}
	
	/**
	 * Returns the inverse functional properties of the model
	 *
	 * @return array Array of RDFSProperty objects.
	 */
	public function listInverseFunctionalProperties() {
		
		return $this->listTypes($GLOBALS['OWL_InverseFunctionalProperty'],'OWLProperty');
	}
	
	/**
	 * Returns the OWL_DatatypeProperties of the model
	 *
	 * @return array Array of RDFSProperty objects.
	 */
	public function listDatatypeProperties() {
		
		return $this->listTypes($GLOBALS['OWL_DatatypeProperty'],'RDFSProperty');
	}
	
	public function listRestrictions() {
		
		return $this->findSubjects('owl:onProperty','Class');
	}
	
	public function listTopClassesInfered() {
		
		if($topClasses=$this->listTopClasses())
		foreach($topClasses as $key=>$topClass)
			if(method_exists($topClass,'listIntersectionOf') && $inferedSuperClasses=$topClass->listIntersectionOf())
				foreach($inferedSuperClasses as $inferedSuperClass)
					if(!isBnode($inferedSuperClass))
						unset($topClasses[$key]);
		return $topClasses;
	}
	
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
	
	public function setImports($imports) {
		
		$this->asResource->setPropertyValues($GLOBALS['OWL_imports'],$imports);
	}
	
	public function listPriorVersion() {
		
		return $this->asResource->listPropertyValues($GLOBALS['OWL_priorVersion']);
	}
	
	public function setPriorVersion($values) {
		
		$this->asResource->setPropertyValues($GLOBALS['OWL_priorVersion'],$values);
	}
	
	public function listBackwardCompatibleWith() {
		
		return $this->asResource->listPropertyValues($GLOBALS['OWL_backwardCompatibleWith']);
	}
	
	public function setBackwardCompatibleWith($values) {
		
		$this->asResource->setPropertyValues($GLOBALS['OWL_backwardCompatibleWith'],$values);
	}
	
	public function listIncompatibleWith() {
		
		return $this->asResource->listPropertyValues($GLOBALS['OWL_incompatibleWith']);
	}
	
	public function setIncompatibleWith($values) {
		
		$this->asResource->setPropertyValues($GLOBALS['OWL_incompatibleWith'],$values);
	}
	
	public function listAllDifferentSets() {
		
		return $this->findNodes(NULL,$GLOBALS['RDF_type'],$GLOBALS['OWL_AllDifferent']);
	}
	
	public function getAllDifferent($set,$class=NULL) {
		
		$distinctMembers=$this->findNode($set,$GLOBALS['OWL_distinctMembers'],NULL);
		return $this->getList($distinctMembers,$class);
	}
	
	public function setAllDifferent($set,$members) {
		
		$this->removeAllDifferent($set);
		$this->addAllDifferent($members);
	}
	
	public function addAllDifferent($members) {
		
		$allDifferent=new BlankNode($this->getUniqueResourceURI(BNODE_PREFIX));
		$this->add($allDifferent,$GLOBALS['RDF_type'],$GLOBALS['OWL_AllDifferent']);
		$distinctMembers=$this->addList($members,false);
		$this->add($allDifferent,$GLOBALS['OWL_distinctMembers'],$distinctMembers);
	}
	
	public function removeAllDifferent($set) {
		
		if(!is_a($set,'RDFSResource'))
			$set=$this->resourceF($set);
		$set->remove();
	}
	
	public function listIntersectionClasses() {
		
		return $this->findNodes(NULL,'owl:intersectionOf',NULL,'OWLClass');
	}
}
?>