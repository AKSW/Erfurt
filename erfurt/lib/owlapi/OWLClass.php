<?php
/*
 * OWLClass.php
 * Encoding: ISO-8859-1
 *
 * Copyright (c) 2006 Sören Auer <soeren@auer.cx>
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
 * OWLClass represents an OWL ontology node characterising a class 
 * description.
 *
 * @package owlapi
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: OWLClass.php 629 2006-11-06 18:47:55Z p_frischmuth $
 */
class OWLClass extends RDFSClass {
	/**
	 * @return boolean Returns true in case this restriction is a cardinality
	 * restriction.
	 */
	function isCardinalityRestriction() {
		return $this->hasPropertyValue('owl:maxCardinality')||$this->hasPropertyValue('owl:minCardinality')||$this->hasPropertyValue('owl:cardinality');
	}
	/**
	 * @return boolean Returns true in case this restriction is a has value
	 * restriction.
	 */
	function isHasValueRestriction() {
#echo('<div>isHasValueRestriction: '.$this->getLocalName());
#if($this->uri=='bN4500580ac116e3')
#	var_dump($this->hasPropertyValue('owl:hasValue'));
#echo('</div>');
		return $this->hasPropertyValue('owl:hasValue');
	}
	/**
	 * @return boolean Returns true in case this restriction is a some values
	 * from restriction.
	 */
	function isSomeValuesFromRestriction() {
		return $this->hasPropertyValue('owl:someValuesFrom');
	}
	/**
	 * @return boolean Returns true in case this restriction is an all values
	 * from restriction.
	 */
	function isAllValuesFromRestriction() {
		return $this->hasPropertyValue('owl:allValuesFrom');
	}
	/**
	 * @return boolean Returns true in case this class is an intersection of a
	 * list of classes.
	 */
	function isIntersection() {
		return $this->hasPropertyValue('owl:intersectionOf');
	}
	/*
	 * @return array Returns an array containing all the classes that are
	 * declared to be equivalent to this class.
	 */
	function listEquivalentClasses() {
		return $this->listPropertyValues($GLOBALS['OWL_equivalentClass'],'Class');
	}
	/**
	 * @return array Returns an array containing all the classes that are
	 * declared to be equivalent to this class and that are infered from this
	 * class.
	 */
	function listEquivalentClassesInfered() {
		return $this->listPropertyValuesSymmetric($GLOBALS['OWL_equivalentClass'],'Class');
	}
	/**
	 * @return array Returns an array containing all the classes that are declared to
	 * be disjoint with this class.
	 */
	function listDisjointWith() {
		return $this->listPropertyValues($GLOBALS['OWL_disjointWith']);
	}
	/**
	 * @return array
	 */
	function listIntersectionOf() {
		return $this->model->getList(parray_shift($this->listPropertyValues($GLOBALS['OWL_intersectionOf'])),'Class');
	}
	/**
	 * @return array
	 */
	function listUnionOf() {
		return $this->model->getList(parray_shift($this->listPropertyValues($GLOBALS['OWL_unionOf'])));
	}
	/**
	 * @return array
	 */
	function listComplementOf() {
		return $this->listPropertyValues($GLOBALS['OWL_complementOf']);
	}
	/**
	 * @param
	 * @return
	 */
	function setEquivalentClasses($values) {
		return $this->setPropertyValues($GLOBALS['OWL_equivalentClass'],$values);
	}
	/**
	 * @param
	 */
	function setDisjointWith($values) {
		return $this->setPropertyValues($GLOBALS['OWL_disjointWith'],$values);
	}
	/**
	 * @param
	 */
	function setIntersectionOf($values) {
		$list=$this->model->addList($values,false);
		return $this->setPropertyValues($GLOBALS['OWL_intersectionOf'],$list);
	}
	/**
	 * @param
	 */
	function setUnionOf($values) {
		if($values==array_keys($this->listUnionOf()))
			return;
		$list=$this->model->addList($values,false);
		return $this->setPropertyValues($GLOBALS['OWL_unionOf'],$list);
	}
	/**
	 * @param
	 */
	function setComplementOf($values) {
		return $this->setPropertyValues($GLOBALS['OWL_complementOf'],$values);
	}


	/**
	 * @param
	 * @return
	 */
	function listSubClassesInfered($includeEquivalentClasses=true) {
		$ret=$this->listSubClasses();
		if($includeEquivalentClasses)
			foreach($this->listEquivalentClassesInfered() as $eqiv)
				$ret=array_merge($ret,$eqiv->listSubClassesInfered(false));
		$ret=array_merge($ret,$this->model->listSubClassesInfered($this));
#		foreach($this->model->listTopClasses() as $key=>$topClass)
#			if(method_exists($topClass,'listIntersectionOf') && $inferedSuperClasses=$topClass->listIntersectionOf())
#				foreach($inferedSuperClasses as $inferedSuperClass)
#					if($inferedSuperClass->getURI()==$this->getURI())
#						$ret[$topClass->getLocalName()]=$topClass;
		return $ret;
	}
	/**
	 * @return
	 */
	function listSuperClassesInfered() {
		$ret=$this->listSuperClasses();
		foreach($this->listIntersectionOf() as $inferedSuperClass)
			if(!isBnode($inferedSuperClass))
				$ret[$inferedSuperClass->getLocalName()]=$inferedSuperClass;
		return $ret;
	}


	/**
	 * Returns the minimum cardinality of a property.
	 *
	 * @param RDFSProperty $property
	 * @return int Minimum cardinality of a property.
	 */
	function getCardinalityMin($property) {
		return $this->_getCardinality($property,'min');
	}
	/**
	 * Returns the maximum cardinality of a property.
	 *
	 * @param RDFSProperty $property
	 * @return int Maximum cardinality of a property
	 */
	function getCardinalityMax($property) {
		return $this->_getCardinality($property,'max');
	}
	/**
	 * Returns the minimum cardinality of a property or a minimum cardinality
	 * for that property inherited from a superclass.
	 *
	 * @param RDFSProperty $property
	 * @return int Minimum cardinality of a property.
	 */
	function getCardinalityMinInherited($property) {
		return $this->_getCardinalityInherited($property,'min');
	}
	/**
	 * Returns the maximum cardinality of a property or a maximum cardinality
	 * for that property inherited from a superclass.
	 *
	 * @param RDFSProperty $property
	 * @return int Maximum cardinality of a property
	 */
	function getCardinalityMaxInherited($property) {
		return $this->_getCardinalityInherited($property,'max');
	}

	/**
	 * @param
	 * @param
	 * @return array
	 */
	function getRestriction($property,$type=array('allValuesFrom','someValuesFrom','hasValue')) {
		if($stm=$this->_getRestrictionStatement($property,$type))
			return array($this->getLocalName()=>$stm);
		else
			foreach($this->listSuperClassesInfered() as $superclass)
				if($res=$superclass->getRestriction($property,$type))
					return $res;
		return array();
	}
	/**
	 * @param
	 * @return
	 */
	function getRestrictionAllValuesFrom($property) {
		return $this->getRestriction($property,'allValuesFrom');
	}
	/**
	 * @param
	 * @return
	 */
	function getRestrictionSomeValuesFrom($property) {
		return $this->getRestriction($property,'someValuesFrom');
	}
	/**
	 * @param
	 * @return
	 */
	function getRestrictionHasValue($property) {
		return $this->getRestriction($property,'hasValue');
	}


	/**
	 * Sets the cardinality for a property.
	 *
	 * @param RDFSProperty $property
	 * @param int $cardinality
	 */
	function setCardinality($property,$cardinality) {
		$this->setCardinalityMin($property,$cardinality);
		$this->setCardinalityMax($property,$cardinality);
	}
	/**
	 * Sets the minimum cardinality for a property.
	 *
	 * @param RDFSProperty $property
	 * @param int $cardinality
	 */
	function setCardinalityMin($property,$cardinality) {
		$this->_setCardinality($property,'min',$cardinality);
	}
	/**
	 * Sets the maximum cardinality for a property.
	 *
	 * @param RDFSProperty $property
	 * @param int $cardinality
	 */
	function setCardinalityMax($property,$cardinality) {
		$this->_setCardinality($property,'max',$cardinality);
	}
	/**
	 * Returns a list of nodes representing owl:intersectionOf lists the class is part of
	 *
	 * @return array List of nodes representing owl:intersectionOf lists the class is part of
	 */
	function listIntersections() {
		$ret=array();
		foreach($this->listLists() as $l)
			if($i=$this->model->findNode(NULL,'owl:intersectionOf',$l,'OWLClass'))
				$ret[]=$i;
		return $ret;
	}

	/*
	 * Helper function returning the statement stating the cardinality
	 * of a property
	 *
	 * @param RDFSProperty $property
	 * @param string $minmax
	 * @return Statement
	 */
	private function _getCardinalityStm($property,$minmax) {
		if(!is_a($property,'Resource'))
			$property=new Resource($property);

# AND s3.predicate='".$this->model->_dbId('owl:onProperty')."' AND s3.object='".$property->getDBId()."'
			
		$sql="SELECT s4.subject,s4.predicate,s4.object,s4.l_language,s4.l_datatype,s4.subject_is,s4.object_is,s4.object_is,s4.object
				FROM statements s1
				INNER JOIN statements s2 ON(s1.modelID=s2.modelID AND s2.subject=s1.object)
				INNER JOIN statements s3 ON(s1.modelID=s3.modelID AND s3.subject=s2.subject)
				INNER JOIN statements s4 ON(s1.modelID=s4.modelID AND s4.subject=s2.subject)
			WHERE
				s1.subject='".$this->getDBId()."' AND s1.predicate='".$this->model->_dbId('rdfs:subClassOf')."'
				AND s2.subject_is='b' AND s2.predicate='".$this->model->_dbId('rdf:type').
					"' AND s2.object='".$this->model->_dbId('owl:Restriction')."'
				AND s3.predicate='".$this->model->_dbId('owl:onProperty')."' AND s3.object='".$this->model->_dbId($property)."'
				AND (s4.predicate='".$this->model->_dbId('owl:cardinality')."' OR s4.predicate='".$this->model->_dbId('owl:'.$minmax.'Cardinality')."')
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
	 * @param RDFSProperty $property
	 * @param string $minmax
	 * @return minmimum or maximum cardinality of a property
	 */
	private function _getCardinality($property,$minmax) {
		$stm=$this->_getCardinalityStm($property,$minmax);
		if(!empty($stm) && is_a($stm->obj,'Literal'))
			return $stm->obj->label;
	}
	/*
	 * OWLClass::_getCardinalityInherited()
	 *
	 * @param $property
	 * @param $minmax
	 * @return
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
	 * @param RDFSProperty $property
	 * @param string $minmax
	 * @param int $cardinality
	 * @return
	 */
	private function _setCardinality($property,$minmax,$cardinality) {
		if(!is_a($property,'Resource'))
			$property=new Resource($property);
		$cardinalitystmmin=$this->_getCardinalityStm($property,'min');
		$cardinalitystmmax=$this->_getCardinalityStm($property,'max');
		$cardinalitystm=${'cardinalitystm'.$minmax};
		$restriction=is_a($cardinalitystmmin,'Statement')?$cardinalitystmmin->subj:
			(is_a($cardinalitystmmax,'Statement')?$cardinalitystmmax->subj:false);
		$value=new Literal($cardinality);
		$value->setDatatype('http://www.w3.org/2001/XMLSchema#nonNegativeInteger');
		if(is_a($cardinalitystm,'Statement')) { // restriction exists
			if($cardinalitystm->obj->label==$cardinality)
				return;
			else { // update restriction
				$this->model->remove($cardinalitystm);
				if($cardinality)
					$this->model->add($cardinalitystm->subj,$cardinalitystm->pred,$value);
				else {
					$r=$this->model->resourceF($cardinalitystm->subj->getURI());
					$r->remove();
				}
			}
		} else if($cardinality) { // create new restriction
			if(!$restriction) {
				$restriction=new Blanknode($this->model->getUniqueResourceURI(BNODE_PREFIX));
				$this->model->add($restriction,$GLOBALS['RDF_type'],$GLOBALS['OWL_Restriction']);
				$this->model->add($restriction,$GLOBALS['OWL_onProperty'],$property);
				$this->model->add($this,$GLOBALS['RDFS_subClassOf'],$restriction);
			}
			$this->model->add($restriction,$GLOBALS['OWL_'.$minmax.'Cardinality'],$value);
		}
	}
	/*
	 * OWLClass::_getRestrictionStatement()
	 *
	 * @param $property
	 * @param string $type
	 * @return
	 */
	function _getRestrictionStatement($property,$types=array('allValuesFrom','someValuesFrom','hasValue')) {
		if(!is_array($types))
			$types=array($types);
		foreach($types as $type)
			$t[]=$this->model->_dbId('owl:'.$type);
		$sql="SELECT s4.subject,s4.predicate,s4.object,s4.l_language,s4.l_datatype,s4.subject_is,s4.object_is,s4.object_is,s4.object
				FROM statements s1
				INNER JOIN statements s2 ON(s1.modelID=s2.modelID AND s2.subject=s1.object)
				INNER JOIN statements s3 ON(s1.modelID=s3.modelID AND s3.subject=s2.subject)
				INNER JOIN statements s4 ON(s1.modelID=s4.modelID AND s4.subject=s2.subject)
			WHERE
				s1.subject='".$this->getDBId()."' AND s1.predicate='".$this->model->_dbId('rdfs:subClassOf')."'
				AND s2.subject_is='b' AND s2.predicate='".$this->model->_dbId('rdf:type')."' AND s2.object='".$this->model->_dbId('owl:Restriction')."'
				AND s3.predicate='".$this->model->_dbId('owl:onProperty')."' AND s3.object='".$property->getDBId()."'
				AND s4.predicate IN ('".join("','",$t)."')
				AND s1.modelID IN(".$this->model->getModelIds().')';
#echo($sql);
		if($rs=$this->model->dbConn->execute($sql))
			$stmts=$this->model->_convertRecordSetToMemModel($rs);
		if(!empty($stmts->triples[0]))
			return $stmts->triples[0];
		else return;
	}
}
?>