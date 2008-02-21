<?php
/*
 * Class.php
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
 * Erfurt_Owl_Class represents an OWL ontology node characterising a class 
 * description.
 *
 * @package owl
 * @author Sören Auer <soeren@auer.cx>, Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 */
class Erfurt_Owl_Class extends RDFSClass {
	
	/**
	 * Returns true in case this restriction is a cardinality
	 * restriction.
	 * @return boolean 
	 */
	public function isCardinalityRestriction() {
		
		return $this->hasPropertyValue(EF_OWL_MAXCARDINALITY) 
					|| $this->hasPropertyValue(EF_OWL_MINCARDINALITY)
					||$this->hasPropertyValue(EF_OWL_CARDINALITY);
	}
	
	/**
	 * Returns true in case this restriction is a has value
	 * restriction.
	 * @return boolean 
	 */
	public function isHasValueRestriction() {
		
		return $this->hasPropertyValue(EF_OWL_HASVALUE);
	}
	
	/**
	 * Returns true in case this restriction is a some values
	 * from restriction.
	 * @return boolean 
	 */
	public function isSomeValuesFromRestriction() {
		
		return $this->hasPropertyValue(EF_OWL_SOMEVALUESFROM);
	}
	
	/**
	 * Returns true in case this restriction is an all values
	 * from restriction.
	 * @return boolean 
	 */
	public function isAllValuesFromRestriction() {
		
		return $this->hasPropertyValue(EF_OWL_ALLVALUESFROM);
	}
	
	/** 
	 * Returns true in case this class is an intersection of a
	 * list of classes.
	 * @return boolean
	 */
	public function isIntersection() {
		
		return $this->hasPropertyValue(EF_OWL_INTERSECTIONOF);
	}
	
	/** Returns an array containing all the classes that are
	 * declared to be equivalent to this class.
	 * @return array 
	 */
	public function listEquivalentClasses() {
		
		return $this->listPropertyValues(EF_OWL_EQUIVALENTCLASS, 'class');
	}
	
	/**
	 * Returns an array containing all the classes that are
	 * declared to be equivalent to this class and all classes that 
	 * declare to be equivalent to this class
	 * @return Erfurt_Owl_Class[] 
	 */
	public function listEquivalentClassesInfered() {
		
		return $this->listPropertyValuesSymmetric(EF_OWL_EQUIVALENTCLASS, 'class');
	}
	
	/** 
	 * Returns an array containing all the classes that are declared to
	 * be disjoint with this class.
	 * @return Erfurt_Owl_Class[]
	 */
	public function listDisjointWith() {
		
		return $this->listPropertyValues(EF_OWL_DISJOINTWITH);
	}
	
	/**
	 * Returns a list of classes, that are declared  to be an 
	 * intersection of this class with owl:intersectionOf
	 * @return Erfurt_Owl_Class[]
	 */
	public function listIntersectionOf() {
		
		return $this->model->getList(parray_shift($this->listPropertyValues(EF_OWL_INTERSECTIONOF)), 'class');
	}
	
	/**
	 * Returns a list of classes, that are declared  to be a
	 * union of this class with owl:unionOf
	 * @return Erfurt_Owl_Class[]
	 */
	public function listUnionOf() {
		
		return $this->model->getList(parray_shift($this->listPropertyValues(EF_OWL_UNIONOF)));
	}
	
	/** 
	 * Returns a list of classes, that are declared  to be a
	 * Complement of this class with owl:complementOf
	 * @return Erfurt_Owl_Class[]
	 */
	public function listComplementOf() {
		
		return $this->listPropertyValues(EF_OWL_COMPLEMENTOF);
	}
	
	/** //TODO
	 * @param $values
	 * @return void
	 */
	public function setEquivalentClasses($values) {
		
		return $this->setPropertyValues(EF_OWL_EQUIVALENTCLASS, $values);
	}
	
	/** //TODO
	 * @param $values
	 */
	public function setDisjointWith($values) {
		
		return $this->setPropertyValues(EF_OWL_DISJOINTWITH, $values);
	}
	
	/** //TODO
	 * @param $values
	 */
	public function setIntersectionOf($values) {
		
		$list=$this->model->addList($values,false);
		return $this->setPropertyValues(EF_OWL_INTERSECTIONOF, $list);
	}
	
	/** //TODO
	 * @param $values
	 */
	public function setUnionOf($values) {
		
		if($values==array_keys($this->listUnionOf()))
			return;
		$list=$this->model->addList($values,false);
		return $this->setPropertyValues(EF_OWL_UNIONOF, $list);
	}
	
	/** //TODO
	 * @param $values
	 */
	public function setComplementOf($values) {
		
		return $this->setPropertyValues(EF_OWL_COMPLEMENTOF, $values);
	}

	/**
	 * Changed see comments below
	 * Returns a list of subclasses merged with the list 
	 * of subclasses of the equivalent classes
	 *  
	 * @return Erfurt_Owl_Class[]
	 */
	public function listSubClassesInfered() {
			
		$ret=$this->listSubClasses();
		foreach($this->listEquivalentClassesInfered() as $eqiv) {
			$ret=array_merge($ret,$eqiv->listSubClasses());
		}
		$ret=array_merge($ret,$this->model->listSubClassesInfered($this));

		return $ret;
	}
	
	/* Do not yet delete, ask Sebastian
	CHANGED listsubclasses already exists why input true/false??
	Could be kept to make more inference in  line 4 listSubclassesInfered(true)
	
	public function listSubClassesInfered($includeEquivalentClasses=true) {
		
		$ret=$this->listSubClasses();
		if($includeEquivalentClasses)
			foreach($this->listEquivalentClassesInfered() as $eqiv)
				$ret=array_merge($ret,$eqiv->listSubClassesInfered(false));
		$ret=array_merge($ret,$this->model->listSubClassesInfered($this));

		return $ret;
	}*/
	
	/**
	 * Returns a list of Superclasses
	 * @return Erfurt_Owl_Class[]
	 */
	 
	public function listSuperClassesInfered() {
		
		$ret=$this->listSuperClasses();
		foreach($this->listIntersectionOf() as $inferedSuperClass)
			if(!isBnode($inferedSuperClass))
				$ret[$inferedSuperClass->getLocalName()]=$inferedSuperClass;
		return $ret;
	}
	
	

	/**
	 * Returns the minimum cardinality of a property.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @return int Minimum cardinality of a property.
	 */
	public function getCardinalityMin($property) {
		
		return $this->_getCardinality($property,'min');
	}
	
	/**
	 * Returns the maximum cardinality of a property.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @return int Maximum cardinality of a property
	 */
	public function getCardinalityMax($property) {
		
		return $this->_getCardinality($property,'max');
	}
	
	/**
	 * Returns the minimum cardinality of a property or a minimum cardinality
	 * for that property inherited from a superclass.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @return int Minimum cardinality of a property.
	 */
	public function getCardinalityMinInherited($property) {
		
		return $this->_getCardinalityInherited($property,'min');
	}
	
	/**
	 * Returns the maximum cardinality of a property or a maximum cardinality
	 * for that property inherited from a superclass.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @return int Maximum cardinality of a property
	 */
	public function getCardinalityMaxInherited($property) {
		
		return $this->_getCardinalityInherited($property,'max');
	}

	/**
	 * //TODO add comment check functionality
	 * @param Erfurt_Rdfs_Property $property
	 * @param String[] with value restriction types
	 * @return Erfurt_Owl_Class[]
	 */
	public function getRestriction($property,$type=array('allValuesFrom','someValuesFrom','hasValue')) {
		
		if($stm=$this->_getRestrictionStatement($property,$type))
			return array($this->getLocalName()=>$stm);
		else
			foreach($this->listSuperClassesInfered() as $superclass)
				if($res=$superclass->getRestriction($property,$type))
					return $res;
		return array();
	}
	
	/**
	 * //TODO add comment check functionality
	 * @param Erfurt_Rdfs_Property $property
	 * @return Erfurt_Owl_Class[]
	 */
	public function getRestrictionAllValuesFrom($property) {
		
		return $this->getRestriction($property,'allValuesFrom');
	}
	
	/**
	 * //TODO add comment check functionality
	 * @param Erfurt_Rdfs_Property $property
	 * @return Erfurt_Owl_Class[]
	 */
	public function getRestrictionSomeValuesFrom($property) {
		
		return $this->getRestriction($property,'someValuesFrom');
	}
	
	/**
	 * //TODO add comment check functionality
	 * @param Erfurt_Rdfs_Property $property
	 * @return Erfurt_Owl_Class[]
	 */
	public function getRestrictionHasValue($property) {
		
		return $this->getRestriction($property,'hasValue');
	}

	/**
	 * Sets the cardinality for a property.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @param int $cardinality
	 */
	public function setCardinality($property,$cardinality) {
		
		$this->setCardinalityMin($property,$cardinality);
		$this->setCardinalityMax($property,$cardinality);
	}
	
	/**
	 * Sets the minimum cardinality for a property.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @param int $cardinality
	 */
	public function setCardinalityMin($property,$cardinality) {
		
		$this->_setCardinality($property,'min',$cardinality);
	}
	
	/**
	 * Sets the maximum cardinality for a property.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @param int $cardinality
	 */
	public function setCardinalityMax($property,$cardinality) {
		
		$this->_setCardinality($property,'max',$cardinality);
	}
	
	/**
	 * Returns a list of nodes representing owl:intersectionOf lists the class is part of
	 *
	 * @return array List of nodes representing owl:intersectionOf lists the class is part of
	 */
	public function listIntersections() {
		
		$ret=array();
		foreach($this->listLists() as $l)
			if($i=$this->model->findNode(null, EF_OWL_INTERSECTIONOF, $l, 'class'))
				$ret[]=$i;
		return $ret;
	}

	/*
	 * Helper function returning the statement stating the cardinality
	 * of a property
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @param string $minmax
	 * @return Statement
	 */
	private function _getCardinalityStm($property,$minmax) {
		
		if(!($property instanceof Resource))
			$property=new Resource($property);
			
		$sql="SELECT s4.subject,s4.predicate,s4.object,s4.l_language,s4.l_datatype,s4.subject_is,s4.object_is,s4.object_is,s4.object
				FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s1
				INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s2 ON(s1.modelID=s2.modelID AND s2.subject=s1.object)
				INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s3 ON(s1.modelID=s3.modelID AND s3.subject=s2.subject)
				INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s4 ON(s1.modelID=s4.modelID AND s4.subject=s2.subject)
			WHERE
				s1.subject='".$this->getURI()."' AND s1.predicate='".EF_RDFS_SUBCLASSOF."'
				AND s2.subject_is='b' AND s2.predicate='".EF_RDF_TYPE.
					"' AND s2.object='".EF_OWL_RESTRICTION."'
				AND s3.predicate='".EF_OWL_ONPROPERTY."' AND s3.object='".$this->model->_dbId($property)."'
				AND (s4.predicate='".EF_OWL_CARDINALITY."' OR s4.predicate='".$this->model->_dbId('owl:'.$minmax.'Cardinality')."')
				AND s1.modelID IN (".$this->model->getModelIds().')';
		if($rs=$this->model->dbConn->execute($sql))
			$stmts=$this->model->_convertRecordSetToMemModel($rs);
		if(!empty($stmts->triples[0]))
			return $stmts->triples[0];
		else return;
	}
	
	/*
	 * Returns the minmimum or maximum cardinality of a property.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @param string $minmax
	 * @return minmimum or maximum cardinality of a property
	 */
	private function _getCardinality($property,$minmax) {
		
		$stm=$this->_getCardinalityStm($property,$minmax);
		if(!empty($stm) && ($stm->obj instanceof Literal))
			return $stm->obj->label;
	}
	
	/*
	 * OWLClass::_getCardinalityInherited()
	 *
	 * @param $property
	 * @param $minmax
	 * @return int
	 */
	private function _getCardinalityInherited($property,$minmax) {
		
		if(!$ret=$this->_getCardinality($property,$minmax))
			foreach($this->listSuperClasses() as $superclass)
				if($ret=$superclass->_getCardinalityInherited($property,$minmax))
					break;
		return $ret;
	}
	
	/*
	 * Sets the cardinality for a property.
	 *
	 * @param Erfurt_Rdfs_Property $property
	 * @param string $minmax
	 * @param int $cardinality
	 * @return void
	 */
	private function _setCardinality($property,$minmax,$cardinality) {
		
		if(!($property instanceof Resource))
			$property=new Resource($property);
		$cardinalitystmmin=$this->_getCardinalityStm($property,'min');
		$cardinalitystmmax=$this->_getCardinalityStm($property,'max');
		$cardinalitystm=${'cardinalitystm'.$minmax};
		$restriction=($cardinalitystmmin instanceof Statement)?$cardinalitystmmin->subj:
			(($cardinalitystmmax instanceof Statement)?$cardinalitystmmax->subj:false);
		$value=new Literal($cardinality);
		$value->setDatatype('http://www.w3.org/2001/XMLSchema#nonNegativeInteger');
		if(($cardinalitystm instanceof Statement)) { // restriction exists
			if($cardinalitystm->obj->label==$cardinality)
				return;
			else { // update restriction
				$this->model->remove($cardinalitystm);
				if($cardinality)
					$this->model->add($cardinalitystm->subj,$cardinalitystm->pred,$value);
				else {
					$r = $this->model->resourceF($cardinalitystm->subj->getURI(), false);
					$r->remove();
				}
			}
		} else if($cardinality) { // create new restriction
			if(!$restriction) {
				$restriction=new Blanknode($this->model->getUniqueResourceURI(BNODE_PREFIX));
				$this->model->add($restriction,EF_RDF_TYPE,EF_OWL_RESTRICTION);
				$this->model->add($restriction,EF_OWL_ONPROPERTY,$property);
				$this->model->add($this,EF_RDFS_SUBCLASSOF,$restriction);
			}
			$this->model->add($restriction,"owl:".$minmax."Cardinality",$value);
		}
	}
	
	/*
	 * OWLClass::_getRestrictionStatement()
	 *
	 * @param $property
	 * @param string $type
	 * @return array
	 */
	public function _getRestrictionStatement($property,$types=array('allValuesFrom','someValuesFrom','hasValue')) {
		
		if(!is_array($types))
			$types=array($types);
		foreach($types as $type)
			$t[]=$this->model->_dbId('owl:'.$type);
		$sql="SELECT s4.subject,s4.predicate,s4.object,s4.l_language,s4.l_datatype,s4.subject_is,s4.object_is,s4.object_is,s4.object
				FROM ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s1
				INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s2 ON(s1.modelID=s2.modelID AND s2.subject=s1.object)
				INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s3 ON(s1.modelID=s3.modelID AND s3.subject=s2.subject)
				INNER JOIN ".$GLOBALS['RAP']['conf']['database']['tblStatements']." s4 ON(s1.modelID=s4.modelID AND s4.subject=s2.subject)
			WHERE
				s1.subject='".$this->getURI()."' AND s1.predicate='".EF_RDFS_SUBCLASSOF."'
				AND s2.subject_is='b' AND s2.predicate='".EF_RDF_TYPE."' AND s2.object='".EF_OWL_RESTRICTION."'
				AND s3.predicate='".EF_OWL_ONPROPERTY."' AND s3.object='".$this->model->_dbId($property)."'
				AND s4.predicate IN ('".join("','",$t)."')
				AND s1.modelID IN(".$this->model->getModelIds().')';
				
		if($rs=$this->model->dbConn->execute($sql))
			$stmts=$this->model->_convertRecordSetToMemModel($rs);
		if(!empty($stmts->triples[0]))
			return $stmts->triples[0];
		else return;
	}
}
?>