<?php
/**
 * RDFSResource
 *
 * @package RDFSAPI
 * @author S�ren Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id$
 * @access public
 **/
abstract class Erfurt_Rdfs_Resource_Abstract extends Resource {
	
	protected $properties;
	
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
	public function __construct($uri,&$model,$expandNS=true) {
		
		if ($uri instanceof Resource) {
			$uri = $uri->getURI();
		}
			
		if($expandNS && !strstr($uri,'/')) {
			$nsArr = $model->getParsedNamespaces();
			# Debug output if nsArr isn't Array and not null
			if(!is_array($nsArr) && $nsArr != null)
				var_dump($nsArr);
			foreach($nsArr as $key=>$val)
				$uri=str_replace($val.':',$key,$uri);
			if(!strstr($uri,'#') && !strstr($uri,'/'))
				$uri=$model->baseURI.$uri;
		}
		Resource::Resource($uri);
		$this->model=&$model;
		
		$this->properties = array();
	}
	
	public function __set($key, $value) {
		
		$this->properties[$key] = $value;
	}
	
	public function __get($key) {
		
		if (isset($this->properties[$key])) {
			return $this->properties[$key];
		} else {
			return false;
		}
	}
	
	public function __isset($key) {
		
		return (array_key_exists($key, $this->properties));
	}
	
	public function __toString() {
		
		return 'RDFSResource("' . $this->getURI() .'")';
	}
	
	public function isBlankNode() {
		
		if(strstr($this->getURI(),EF_BNODE_PREFIX)===$this->getURI())
			return true;
		else false;
	}
	
	public function isClass() {
		if (($this->model->findNode(null, 'rdf:type', $this) || 
				$this->model->findStatement($this, 'rdf:type', 'owl:Class') || 
				$this->model->findNode($this, 'rdfs:subClassOf', null) || 
				$this->model->findNode(null, 'rdfs:subClassOf', $this) || 
				$this->model->findStatement($this, 'rdf:type', 'rdfs:Class'))) {

			return true;
		}
		
		return false;
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
		
		if (isset($cache[$this->getURI()])) {
			return $cache[$this->getURI()];
		}
			
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
	public function listComments($language=null) {
		
		return $this->listLiteralPropertyValues($GLOBALS['RDFS_comment'],$language);
	}
	
	public function getComment($language=null) {
		
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
	public function setLabel($label,$language=null) {

		return $this->setPropertyValues($GLOBALS['RDFS_label'],$label,$language,null,$language,'http://www.w3.org/2001/XMLSchema#string');
	}
	
	/**
	 * Returns the labels of this resource
	 *
	 * @return array of labels attached to this resource
	 **/
	public function listLabels($language=null) {
		
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
	 * for the language in this resource return null.
	 *
	 * @param string $language
	 * @return string The label attached to this resource or null.
	 **/
	public function getLabelForLanguage($language='') {
		
		$label=parray_shift($this->listLabels($language));
		return $label?$label->getLabel():$this->getLocalName();
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
		if($ls=$this->model->findNode(null,$GLOBALS['RDF_first'],$this)) {
			$le=$this->model->findNode($ls,$GLOBALS['RDF_rest'],null);
			$this->model->remove($ls,$GLOBALS['RDF_first'],$this);
			$this->model->remove($ls,$GLOBALS['RDF_rest'],$le);
			if($le->getURI()!=$GLOBALS['RDF_nil']->getURI()) {
				$this->model->replace(null,null,$ls,$le);
				$this->model->replace($ls,null,null,$le);
			} else {
				if(!$this->model->findNode(null,$GLOBALS['RDF_rest'],$ls)) {
					$bNode=$this->model->resourceF($ls->getLabel());
#$bNode->uri=$ls->getLabel();
#print_r($bNode);
#					$bNode->remove();
				} else
					$this->model->replace(null,null,$ls,$GLOBALS['RDF_nil']);
			}
		}

		$res=$this->isBlankNode()?new Blanknode($this->getURI()):$this;
		$stm1=$this->model->find($res,null,null);
		$stm2=$this->model->find(null,$res,null);
		$stm3=$this->model->find(null,null,$res);
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
	public function type($type=null,$bool=null) {
		
		if(!$type)
			return $this->model->findNodes($this,$GLOBALS['RDF_type'],null);
		if($bool===null)
			return $this->isOfType($type);
		else if($bool)
			$this->setType($type);
		else
			$this->removeType($type);
	}
	
	public function getType() {
		
		return $this->model->findNode($this,$GLOBALS['RDF_type'],null);
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
		
		if(!($newuri instanceof Resource))
			$newuri=$this->model->resourceF($newuri);
		if($checkNewuriExists && ($this->model->findNode($newuri,null,null) || $this->model->findNode(null,$newuri,null) || $this->model->findNode(null,null,$newuri)))
			return false;
		else {
			$this->model->replace(null,null,$this,$newuri);
			$this->model->replace(null,$this,null,$newuri);
			$this->model->replace($this,null,null,$newuri);
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
	public function listPropertyValues($property=null,$class=null) {
		
		return $this->model->findNodes($this,$property,null,$class);
		//return $this->model->findRegex($this->getURI(), $property->getURI(), null);
	}
	
	public function listPropertyValuesRegEx($property = null, $class = null) {
		
		//print_r();
		
		return $this->model->findRegEx($this->getURI(), $property, null);
	}
	
	public function getPropertyValue($property,$class=null) {
		
		return parray_shift($this->listPropertyValues($property,$class));
	}
	
	public function hasPropertyValue($property,$value=null) {
		
		if($this->model->findNode($this,$property,$value))
			return true;
		else
			return false;
	}
	
	public function listPropertyValuesObject($property,$class=null) {
		
		return $this->model->findNodes(null,$property,$this,$class);
	}
	
	public function listPropertyValuesSymmetric(&$property,$class=null) {
		
		return array_merge(
			$this->listPropertyValues($property,$class),
			$this->listPropertyValuesObject($property,$class)
		);
	}
	
	public function listPropertyValuesTransitive($property,$class=null,$done=array()) {
		
		$ret=$values=$this->listPropertyValues($property);
		foreach($values as $val)
			if(($val instanceof Resource) && !in_array($val->getURI(),$done))
				$ret=array_merge($ret,$val->listPropertyValuesTransitive($property,$class,array_keys($ret)));
		return $ret;
	}
	
	public function hasPropertyValueTransitive($property,$value) {
		
		if(($value instanceof Resource))
			$value=$value->getLocalName();
		return in_array($value,array_keys($this->listPropertyValuesTransitive($property)))?true:false;
	}
	
	/**
	 * Returns literal property values of this resource and
	 * property $property which macht the given language and
	 * datatype (null matches arbitrary ones).
	 *
	 * @param RDFSResource $property
	 * @param string $language
	 * @param string $datatype
	 * @return
	 **/
	public function listLiteralPropertyValues($property,$language=null,$datatype=null) {
		
		$ret=array();
		foreach($this->listPropertyValues($property) as $value)
			if(($value instanceof Literal) &&
				($language===null || $value->getLanguage()==$language) &&
				($datatype===null || $value->getDatatype()==$datatype))
				$ret[$this->model->getLiteralId($value)]=$value;
		return $ret;
	}
	
	public function getLiteralPropertyValue($property,$language=null,$datatype=null) {
		
		return parray_shift($this->listLiteralPropertyValues($property,$language,$datatype));
	}
	
	public function listLiteralPropertyValuesPlain($property,$language=null,$datatype=null) {
		
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
	
#	public function removePropertyValues($property,$language=false,$datatype=null) {
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
	 */
	public function setPropertyValues($property, $values = array(), $language = null, $datatype = null, $newLang = null, $newDtype = null) {
			
		if (!is_array($values) || $values['type'] || isset($values['value']) || isset($values['uri']) || isset($values['lang']) || isset($values['dtype'])) {
			$values = array($values);
		}
		$values = array_filter($values);
		
		if (!($property instanceof RDFSProperty)) {
			$property = $this->model->propertyF($property);
		}
		
		$range = $property->getRange();
		$val = array();
		
		if ($language || $newLang || $datatype || $newDtype || ($property instanceof OWLProperty && $property->isDatatypeProperty())) {
			$valuesAreLiterals = true;
		} else {
			$valuesAreLiterals = false;
		}
		
		foreach ($values as $v) {
			if ($v instanceof Resource) {
				$val[] = $v->getLocalName();
			} elseif ($v instanceof Literal) {
				$val[] = $this->model->getLiteralId($v);
			} elseif (is_array($v)) {
				if ($v['type'] != 'resource' && isset($v['value']) && !empty($v['value'])) {
					$vt = new RDFSLiteral($v['value'], $v['lang'] != 'Lang' ? $v['lang'] : null, $v['dtype']);
					$obj = $val[] = $this->model->getLiteralId($vt);
				} elseif ($v['type'] != 'literal' && $v['uri']) {
					$val[] = $this->model->resourceF($v['uri']);
				}
			} elseif ($valuesAreLiterals) {
				$vt = new RDFSLiteral($v, $newLang ? $newLang : $language, $newDtype ? $newDtype : $datatype);
				$val[] = $this->model->getLiteralId($vt);
			} else {
				$vt = $this->model->resourceF($v);
				$val[] = $vt->getLocalName() ? $vt->getLocalName() : $vt->getURI();
			}
		}
		
		if ($valuesAreLiterals) {
			$valuesOld = $this->listLiteralPropertyValues($property, $language, $datatype);
		} else {
			$valuesOld = $this->listPropertyValues($property);
		}
		
		$valuesOldPlain = array_keys($valuesOld);
		$values = array_filter($val);
		
		if (array_diff($valuesOldPlain, $values) && array_diff($values, $valuesOldPlain)) {
			$this->model->logStart('Property values changed.', $property->getLocalName());
		}
		
		foreach (array_diff($valuesOldPlain, $values) as $removed) {
			if (isBnode($valuesOld[$removed])) {
				if(!method_exists($valuesOld[$removed], 'remove')) {
					$valuesOld[$removed] = $this->model->resourceF($valuesOld[$removed]->getURI());
				}
				$valuesOld[$removed]->remove();
			} else {
				$this->model->remove($this, $property, $removed);
			}
		}
		
		foreach (array_diff($values, $valuesOldPlain) as $added) {
			$this->model->add($this, $property, $added);
		}
		
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
		
		if($that==null || !($that instanceof Resource) || ($that instanceof BlankNode))
			return false;
		if($this->getURI()==$that->getURI())
			return true;
		return false;
	}
	
	public function getDefiningModel($includeSubClasses=false,$includeProperties=false,$includeInstances=false) {
		
		$m=$this->model->find($this,null,null);
		
		foreach($m->triples as $key=>$t)
			if(isBnode($t->obj))
				$m=$m->unite($this->model->find($t->obj,null,null));

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
		
		$m->addParsedNamespaces($this->model->getParsedNamespaces());
		
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
		foreach($this->model->findNodes(null,'rdf:first',$n) as $l) {
			while($p=$this->model->findNode(null,'rdf:rest',$l))
				$l=$p;
			$ret[]=$l;
		}
		return $ret;
	}
}
?>
