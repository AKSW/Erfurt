<?php
/**
 * RDFSResource
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: resource.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
abstract class DefaultRDFSResource extends Resource {
	
	/**
	* A reference to the RDFSModel this resource belongs to.
	**/
	var $model;
	
	/**
	 * Constructor
	 *
	 * @param string $uri
	 * @param RDFSModel $model
	 * @return
	 **/
	public function DefaultRDFSResource($uri,&$model,$expandNS=true) {
		
		if(is_a($uri,'Resource'))
			$uri=$uri->getURI();
		if($expandNS && !strstr($uri,'/')) {
			$nsArr = $model->getParsedNamespaces();
			if(!is_array($nsArr))
				var_dump($nsArr);
			foreach($nsArr as $key=>$val)
				$uri=str_replace($val.':',$key,$uri);
			if(!strstr($uri,'#') && !strstr($uri,'/'))
				$uri=$model->baseURI.$uri;
		}
		Resource::Resource($uri);
		$this->model=&$model;
	}
	
	public function __toString() {
		
		return 'RDFSResource("' . $this->getURI() .'")';
	}
	
	public function isBlankNode() {
		
		if(strstr($this->getURI(),EF_BNODE_PREFIX)===$this->getURI())
			return true;
		else false;
	}
	
	public function getLabel() {
		
		return $this->isBlankNode()?parent::getLocalName():parent::getLabel();
	}
	
	public function getLocalNameFast() {
		
		if($s1=strrchr($this->uri,'#'))
			return substr($s1,1);
		else if($s2=strrchr($this->uri,'/'))
			return substr($s2,1);
		else if($s2=strrchr($this->uri,':'))
			return substr($s2,1);
		else
			return $this->uri;
	}
	
	public function getLocalName() {
		
		static $cache;
		if($cache[$this->getURI()])
			return $cache[$this->getURI()];
		$ns=$this->getNamespace();
		if($ns && $ns==$this->getURI())
			$cache[$this->getURI()]=$this->getURI();
		else if($ns && (empty($this->model->baseURI) || strpos($ns,$this->model->baseURI)===false)) {
			$ret=$this->getURI();
			foreach($this->model->getParsedNamespaces() as $key=>$val)
				$ret=str_replace($key,$val.':',$ret);
			$cache[$this->getURI()]=$ret;
		} else if(empty($this->model->baseURI))
			$cache[$this->getURI()]=$this->getURI();
		else
			$cache[$this->getURI()]=$this->getLocalNameFast();
		return $cache[$this->getURI()];
	}
	
	/**
	 * Get the model which the resource belongs to.
	 *
	 * @return RDFSModel Model the Resource belongs to
	 **/
	public function getModel() {
		
		return $this->model;
	}
	
	public function getDBId() {
		
		return $this->model->_dbId($this);
	}
	
	/**
	 * Returns an array of comments of this resource indexed by their language
	 *
	 * @return string comment of the resource
	 **/
	public function listComments($language=NULL) {
		
		return $this->listLiteralPropertyValues($GLOBALS['RDFS_comment'],$language);
	}
	
	public function getComment($language=NULL) {
		
		return parray_shift($this->listComments($language));
	}
	
	/**
	 * Sets the comment for this resource
	 *
	 * @param $comment
	 **/
	public function setComment($comment,$language='') {
		
		$this->setPropertyValues($GLOBALS['RDFS_comment'],$comment,$language,'');
	}

	/**
	 * Adds a label to this resource
	 *
	 * @param $language
	 * @param $label
	 **/
	public function addLabel($label,$language='') {
		
		if(!empty($label))
			$this->addPropertyValue($GLOBALS['RDFS_label'],new Literal($label,$language));
	}
	
	/**
	 * Sets the label of this resource in specified language
	 *
	 * @param $label
	 * @param $language
	 **/
	public function setLabel($label,$language=NULL) {

		return $this->setPropertyValues($GLOBALS['RDFS_label'],$label,$language,NULL,$language,'http://www.w3.org/2001/XMLSchema#string');
	}
	
	/**
	 * Returns the labels of this resource
	 *
	 * @return array of labels attached to this resource
	 **/
	public function listLabels($language=NULL) {
		
		return $this->listLiteralPropertyValues($GLOBALS['RDFS_label'],$language);
	}
	
	/**
	 * TODO: Beschreibung
	 *
	 * @param string $prefix
	 * @param string $suffix
	 * @return array of labels attached to this resource
	 **/
	public function listLabelsPlain($prefix='',$suffix='') {
		
		$ret=array();
		foreach($this->listLabels() as $label)
			$ret[$prefix.$label->getLanguage().$suffix]=$label->getLabel();
		return $ret;
	}
	
	/**
	 * Returns the label for a language. If no label is available
	 * for the language in this resource return NULL.
	 *
	 * @param string $language
	 * @return string The label attached to this resource or NULL.
	 **/
	public function getLabelForLanguage($language='') {
		
		$label=parray_shift($this->listLabels($language));
		return $label?$label->getLabel():NULL;
	}
	
	/**
	 * Returns an array of RDFSResources declared to be "owl:sameAs"
	 * this resource.
	 *
	 * @return array An array of RDFSResources.
	 **/
	public function listSameAs() {
		
		return $this->listPropertyValues($GLOBALS['OWL_sameAs']);
	}
	
	/**
	 * Declares the RDFSResources in $values to be "owl:sameAs" as this resource.
	 *
	 * @param array $values Array of RDFSResources.
	 * @return
	 **/
	public function setSameAs($values) {
		
		return $this->setPropertyValues($GLOBALS['OWL_sameAs'],$values);
	}
	
	/**
	 * Returns an array of RDFSResources declared to be "owl:differentFrom"
	 * this resource.
	 *
	 * @return array An array of RDFSResources.
	 **/
	public function listDifferentFrom() {
		
		return $this->listPropertyValues($GLOBALS['OWL_differentFrom']);
	}
	
	/**
	 * Declares the RDFSResources in $values to be "owl:differentFrom" as
	 * this resource.
	 *
	 * @param array $values Array of RDFSResources.
	 * @return
	 **/
	public function setDifferentFrom($values) {
		
		return $this->setPropertyValues($GLOBALS['OWL_differentFrom'],$values);
	}
	
	/**
	 * Removes this resource from the ontology by deleting any statements that
	 * refer to it. If this resource is a property, this method will not remove
	 * instances of the property from the model.
	 *
	 * @return void
	 **/
	public function remove() {
		
		// Remove the resource from RDF lists
		if($ls=$this->model->findNode(NULL,$GLOBALS['RDF_first'],$this)) {
			$le=$this->model->findNode($ls,$GLOBALS['RDF_rest'],NULL);
			$this->model->remove($ls,$GLOBALS['RDF_first'],$this);
			$this->model->remove($ls,$GLOBALS['RDF_rest'],$le);
			if($le->getURI()!=$GLOBALS['RDF_nil']->getURI()) {
				$this->model->replace(NULL,NULL,$ls,$le);
				$this->model->replace($ls,NULL,NULL,$le);
			} else {
				if(!$this->model->findNode(NULL,$GLOBALS['RDF_rest'],$ls)) {
					$bNode=$this->model->resourceF($ls->getLabel());
#$bNode->uri=$ls->getLabel();
#print_r($bNode);
#					$bNode->remove();
				} else
					$this->model->replace(NULL,NULL,$ls,$GLOBALS['RDF_nil']);
			}
		}

		$res=$this->isBlankNode()?new Blanknode($this->getURI()):$this;
		$stm1=$this->model->find($res,NULL,NULL);
		$stm2=$this->model->find(NULL,$res,NULL);
		$stm3=$this->model->find(NULL,NULL,$res);
		$stms=array_merge($stm1->triples,$stm2->triples,$stm3->triples);
		foreach($stms as $stm) {
			$this->model->remove($stm);
			if(isBNode($stm->subj)) {
				$bNode=$this->model->resourceF($stm->subj);
				$bNode->remove();
			}
			if(isBNode($stm->obj)) {
				$bNode=$this->model->resourceF($stm->obj);
				$bNode->remove();
			}
		}
	}
	
	/**
	 * Checks if this resource is of a specific type.
	 *
	 * @param RDFResource $type
	 * @return boolean
	 **/
	public function isOfType($type) {
		
		if($this->model->findStatement($this,$GLOBALS['RDF_type'],$type))
			return true;
		else return false;
	}
	
	/**
	 * Sets or unsets the type of this resource. If only one parameter is given
	 * the present type of this resource will be returned.
	 *
	 * @param RDFResource $type
	 * @param boolean $bool If bool isset to true the type will be set, else it will be unset.
	 * @return boolean
	 **/
	public function type($type=NULL,$bool=NULL) {
		
		if(!$type)
			return $this->model->findNodes($this,$GLOBALS['RDF_type'],NULL);
		if($bool===NULL)
			return $this->isOfType($type);
		else if($bool)
			$this->setType($type);
		else
			$this->removeType($type);
	}
	
	public function getType() {
		
		return $this->model->findNode($this,$GLOBALS['RDF_type'],NULL);
	}
	
	/**
	 * Sets the type of this resource.
	 *
	 * @param RDFResource $type
	 **/
	public function setType($type) {
		
		if(!$this->isOfType($type))
			$this->model->add($this,$GLOBALS['RDF_type'],$type);
	}
	
	/**
	 * Removes the type of this resource.
	 *
	 * @param RDFResource $type
	 **/
	public function removeType($type) {
		
		if($this->isOfType($type))
			$this->model->remove($this,$GLOBALS['RDF_type'],$type);
	}
	
	/**
	 * Renames this resource.
	 *
	 * @param string $newuri New name URI for this resource
	 * @return boolean If $newuri is an existing URI return false, else rename this resource an return true
	 **/
	public function rename($newuri,$checkIfNewuriExists=true) {
		
		if(!is_a($newuri,'Resource'))
			$newuri=$this->model->resourceF($newuri);
		if($checkNewuriExists && ($this->model->findNode($newuri,NULL,NULL) || $this->model->findNode(NULL,$newuri,NULL) || $this->model->findNode(NULL,NULL,$newuri)))
			return false;
		else {
			$this->model->replace(NULL,NULL,$this,$newuri);
			$this->model->replace(NULL,$this,NULL,$newuri);
			$this->model->replace($this,NULL,NULL,$newuri);
			$this->uri=$newuri->getURI();
			return true;
		}
	}
	
	/**
	 * Returns the model ids of the models that have a statement where this resource is subject and the predicate is rdf:type.
	 * This means it returns the ids of the models, which rdf:type-define this resource.
	 *
	 * @return int[] Returns an array of model ids.
	 */
	abstract public function definingModels();
	
	public function isImported() {
		
		if(in_array($this->model->modelID,$this->definingModels()))
			return false;
		else return true;
	}
	
	/**
	 * Returns an array of nodes (resources or literals) which are values
	 * of the property $property for this resource.
	 *
	 * @param RDFSResource $property
	 * @param string $class The class which the values should be instances of.
	 * @return array An array of nodes which occur as property values.
	 **/
	public function listPropertyValues($property=NULL,$class=NULL) {
		
		return $this->model->findNodes($this,$property,null,$class);
		//return $this->model->findRegex($this->getURI(), $property->getURI(), null);
	}
	
	public function listPropertyValuesRegEx($property = null, $class = null) {
		
		//print_r();
		
		return $this->model->findRegEx($this->getURI(), $property, null);
	}
	
	public function getPropertyValue($property,$class=NULL) {
		
		return parray_shift($this->listPropertyValues($property,$class));
	}
	
	public function hasPropertyValue($property,$value=NULL) {
		
		if($this->model->findNode($this,$property,$value))
			return true;
		else
			return false;
	}
	
	public function listPropertyValuesObject($property,$class=NULL) {
		
		return $this->model->findNodes(NULL,$property,$this,$class);
	}
	
	public function listPropertyValuesSymmetric(&$property,$class=NULL) {
		
		return array_merge(
			$this->listPropertyValues($property,$class),
			$this->listPropertyValuesObject($property,$class)
		);
	}
	
	public function listPropertyValuesTransitive($property,$class=NULL,$done=array()) {
		
		$ret=$values=$this->listPropertyValues($property);
		foreach($values as $val)
			if(is_a($val,'Resource') && !in_array($val->getURI(),$done))
				$ret=array_merge($ret,$val->listPropertyValuesTransitive($property,$class,array_keys($ret)));
		return $ret;
	}
	
	public function hasPropertyValueTransitive($property,$value) {
		
		if(is_a($value,'Resource'))
			$value=$value->getLocalName();
		return in_array($value,array_keys($this->listPropertyValuesTransitive($property)))?true:false;
	}
	
	/**
	 * Returns literal property values of this resource and
	 * property $property which macht the given language and
	 * datatype (NULL matches arbitrary ones).
	 *
	 * @param RDFSResource $property
	 * @param string $language
	 * @param string $datatype
	 * @return
	 **/
	public function listLiteralPropertyValues($property,$language=NULL,$datatype=NULL) {
		
		$ret=array();
		foreach($this->listPropertyValues($property) as $value)
			if(is_a($value,'Literal') &&
				($language===NULL || $value->getLanguage()==$language) &&
				($datatype===NULL || $value->getDatatype()==$datatype))
				$ret[$this->model->getLiteralId($value)]=$value;
		return $ret;
	}
	
	public function getLiteralPropertyValue($property,$language=NULL,$datatype=NULL) {
		
		echo parray_shift($this->listLiteralPropertyValues($property,$language,$datatype));
		return parray_shift($this->listLiteralPropertyValues($property,$language,$datatype));
	}
	
	public function listLiteralPropertyValuesPlain($property,$language=NULL,$datatype=NULL) {
		
		$ret=array();
		foreach($this->listLiteralPropertyValues($property,$language,$datatype) as $value)
			$ret[]=$value->getLabel();
		return $ret;
	}
	
	/**
	 * Removes all property values of $property which do not have
	 * the value $value. If a property value with value $value does
	 * not already exist it will be added.
	 *
	 * @param RDFSResource $property The property to be set.
	 * @param Node $value The value of the property.
	 * @return
	 **/
	public function setPropertyValue($property,$value) {
		
		$this->setPropertyValues($property,$value);
	}
	
	public function removePropertyValues($property) {
		
		$this->setPropertyValues($property);
	}
	
#	public function removePropertyValues($property,$language=false,$datatype=NULL) {
#		
#	$this->setPropertyValues($property,array(),$language,$datatype);
#	}

	/**
	 * Removes all property values of $property which do not have
	 * a value included in $values. If a value included in $values
	 * does not already exist (as property value) it will be added.
	 *
	 * @param RDFSResource $property The property to be set.
	 * @param Node $value The value of the property.
	 * @param boolean $valuesAreLiterals
	 * @return
	 **/
	public function setPropertyValues($property,$values=array(),$language=NULL,$datatype=NULL,$newLang=NULL,$newDtype=NULL) {
		
		if(!is_array($values) || $values['type'] || isset($values['value']) || isset($values['uri']) || isset($values['lang']) || isset($values['dtype']))
			$values=array($values);
		$values=array_filter($values);
		if(!is_a($property,'RDFSProperty'))
			$property=new $this->model->property($property,$this->model);
		$range=$property->getRange();
		$val=array();
		$valuesAreLiterals=($language!==NULL||$datatype!==NULL||$newLang!==NULL||$newDtype!==NULL||(method_exists($property,'isDatatypeProperty')&&$property->isDatatypeProperty()))?true:false;
		foreach($values as $v)
			if(is_a($v,'Resource'))
				$val[]=$v->getLocalName();
			else if(is_a($v,'Literal'))
				$val[]=$this->model->getLiteralId($v);
			else if(is_array($v)) { // && $v['type'] || isset($v['value']) || isset($v['uri']) || isset($v['lang']) || isset($v['dtype'])) {
				if($v['type']!='resource' && isset($v['value'])) {
					$vt=new RDFSLiteral($v['value'],$v['lang']!='Lang'?$v['lang']:NULL,$v['dtype']);
					$obj=$val[]=$this->model->getLiteralId($vt);
#if($property->getLocalName()=='rdfs:comment') {
#print_r($v);
#preg_match('/"(.*)"@(.*)\^\^(.*)/ms',$obj,$matches);
#print_r($matches);
#exit;
#}
				} else if($v['type']!='literal' && $v['uri'])
					$val[]=$this->model->resourceF($v['uri']);
			} else if($valuesAreLiterals) {
				$vt=new RDFSLiteral($v,$newLang!==NULL?$newLang:$language,$newDtype!==NULL?$newDtype:$datatype);
				$val[]=$this->model->getLiteralId($vt);
			} else {
				$vt=$this->model->resourceF($v);
#if($property->getURI()==$GLOBALS['OWL_imports']->getURI())
#	print_r($vt->model->baseURI);
				$val[]=$vt->getLocalName()?$vt->getLocalName():$vt->getURI();
			}
		if($valuesAreLiterals)
			$valuesOld=$this->listLiteralPropertyValues($property,$language,$datatype);
		else
			$valuesOld=$this->listPropertyValues($property);
		$valuesOldPlain=array_keys($valuesOld);
		$values=array_filter($val);
		if(array_diff($valuesOldPlain,$values) && array_diff($values,$valuesOldPlain))
			$this->model->logStart('Property values changed',$property->getLocalName());
		foreach(array_diff($valuesOldPlain,$values) as $removed) {
			if(isBnode($valuesOld[$removed])) {
				if(!method_exists($valuesOld[$removed],'remove'))
					$valuesOld[$removed]=new RDFSResource($valuesOld[$removed]->getURI(),$this->model);
				$valuesOld[$removed]->remove();
			} else
				$this->model->remove($this,$property,$removed);
		}
		foreach(array_diff($values,$valuesOldPlain) as $added)
			$this->model->add($this,$property,$added);
		$this->model->logEnd();
	}
	
	public function setPropertyValuesObject($property,$values=array()) {
		
		if(!is_array($values))
			$values=array($values);
		$valuesOld=$this->listPropertyValuesObject($property);
		$valuesOldPlain=array_keys($valuesOld);
		$values=array_filter($values);
		foreach(array_diff($valuesOldPlain,$values) as $removed) {
			if(isBnode($valuesOld[$removed]))
				$valuesOld[$removed]->remove();
			else
				$this->model->remove($removed,$property,$this);
		} foreach(array_diff($values,$valuesOldPlain) as $added)
			$this->model->add($added,$property,$this);
	}
	
	public function setPropertyValuesSymmetric($property,$values=array()) {
		
		if(!is_array($values))
			$values=array($values);
		$valuesOld=$this->listPropertyValuesSymmetric($property);
		$valuesOldPlain=array_keys($valuesOld);
		$values=array_filter($values);
		foreach(array_diff($valuesOldPlain,$values) as $removed) {
			if(isBnode($valuesOld[$removed]))
				$valuesOld[$removed]->remove();
			else
				$this->model->remove($removed,$property,$this);
		} foreach(array_diff($values,$valuesOldPlain) as $added)
			$this->model->add($added,$property,$this);
	}
	
	/**
	 * Checks if the resource equals another resource.
	 * Two resources are equal, if they have the same URI
	 *
	 * @access	public
	 * @param		object	resource $that
	 * @return	boolean
	 */
	public function equals ($that) {
		
		if($that==NULL || !is_a($that,'Resource') || is_a($that, 'BlankNode'))
			return false;
		if($this->getURI()==$that->getURI())
			return true;
		return false;
	}
	
	public function getDefiningModel($includeSubClasses=false,$includeProperties=false,$includeInstances=false) {
		
		$m=$this->model->find($this,NULL,NULL);
		foreach($m->triples as $key=>$t)
			if(isBnode($t->obj))
				$m=$m->unite($this->model->find($t->obj,NULL,NULL));

		if($class=$this->model->getClass($this)) {
			if($includeSubClasses)
				foreach($class->listSubClasses() as $cl)
					$m=$m->unite($cl->getDefiningModel($includeSubClasses,$includeProperties,$includeInstances));
			if($includeProperties)
				foreach($class->listProperties() as $property)
					foreach($property as $prop)
						$m=$m->unite($prop->getDefiningModel($includeSubClasses,$includeProperties,$includeInstances));
			if($includeInstances)
				foreach($class->listInstances() as $inst)
					$m=$m->unite($inst->getDefiningModel($includeSubClasses,$includeProperties,$includeInstances));
		}
		return $m;
	}
	
	/**
	 * Returns an array of all classes for the given instance.
	 * Each class will be an RDFSClass.
	 *
	 * @return array Array of all classes for the given instance.
	 **/
	public function listClasses() {
		
		return $this->listPropertyValues($GLOBALS['RDF_type'],'Class');
	}
	
	/**
	 * Returns an RDFSClass this instance is an instance of.
	 *
	 * @return RDFSClass A class this instance is an instrance of.
	 **/
	public function getClass($class = null) {
		
		if ($class == null)	return parray_shift($this->listClasses());
		else {
			foreach ($this->listClasses() as $c) {
				if ($class->getURI() === $c->getURI()) return $class;
			}
			return null;
		}
	}
	
	/**
	 * Sets this instance to be an instance of $class.
	 *
	 * @param RDFSClass $class The new RDFSClass for the instance.
	 *
	 * @return
	 **/
	public function setClass($classes) {
		
		return $this->setPropertyValues($GLOBALS['RDF_type'],$classes);
	}
	
	/**
	 * Returns a list of nodes representing lists the resource is part of
	 *
	 * @return array List of nodes representing lists the resource is part of
	 **/
	public function listLists() {
		
		$ret=array();
		$n=$this->isBlankNode()?new BlankNode($this->getURI()):$this;
		foreach($this->model->findNodes(NULL,'rdf:first',$n) as $l) {
			while($p=$this->model->findNode(NULL,'rdf:rest',$l))
				$l=$p;
			$ret[]=$l;
		}
		return $ret;
	}
}
?>
