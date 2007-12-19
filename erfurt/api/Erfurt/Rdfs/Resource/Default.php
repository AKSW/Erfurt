<?php
/**
 * TODO
 *
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @version $Id: $
 */
class Erfurt_Rdfs_Resource_Default extends Resource implements Erfurt_Rdfs_Resource {
	
	/**
	 * @var
	 */
	protected $properties;
	
	/**
	 * A reference to the RDFSModel this resource belongs to.
	 * 
	 * @var Erfurt_Rdfs_Model
	 * @access protected
	 */
	protected $model;
	
	/**
	 * Constructor
	 *
	 * @param string $uri
	 * @param RDFSModel $model
	 * @return
	 **/
	public function __construct($uri, Erfurt_Rdfs_Model_Abstract $model, $expandNS = true) {
		
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
		$this->model = $model;
		
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
		
		return 'Erfurt_Rdfs_Resource_Default("' . $this->getURI() .'")';
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function addLabel($label, $language = '') {
		
		if (!empty($label)) {
			$this->addPropertyValue(EF_RDFS_LABEL, new Literal($label, $language));
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function definingModels() {
		
		return $this->store->executeFindDefiningModels($this, new Resource(EF_RDF_TYPE), null);
	}
	
	public function equals($that) {
		
		if ($that === null || !($that instanceof Resource) || ($that instanceof BlankNode)) {
			return false;
		} else if ($this->getURI() === $that->getURI()) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getClass($class = null) {
		
		if ($class == null)	{
			return array_shift($this->listClasses());
		} else {
			foreach ($this->listClasses() as $c) {
				if ($class->getURI() === $c->getURI()) {
					return $class;
				}
			}
			return null;
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function getComment($language = null) {
		
		return array_shift($this->listComments($language));
	}
	
	public function getDefiningModel($includeSubClasses = false, $includeProperties = false, 
			$includeInstances = false) {
		
		$m = $this->model->find($this, null, null);
		
		foreach ($m->triples as $key => $t) {
			if (($t->obj instanceof BlankNode) || (method_exists($t->obj, 'isBlankNode') && $t->obj->isBlankNode())) {
				$m = $m->unite($this->model->find($t->obj, null, null));
			}
		}
			
		if ($class = $this->model->getClass($this)) {
			if ($includeSubClasses === true) {
				foreach ($class->listSubClasses() as $cl) {
					$m = $m->unite($cl->getDefiningModel($includeSubClasses, $includeProperties, $includeInstances));
				}
			}
			if ($includeProperties) {
				foreach ($class->listProperties() as $property) {
					foreach ($property as $prop) {
						$m = $m->unite($prop->getDefiningModel($includeSubClasses, $includeProperties,
							 	$includeInstances));
					}
				}					
			}
				
			if ($includeInstances) {
				foreach ($class->listInstances() as $inst) {
					$m = $m->unite($inst->getDefiningModel($includeSubClasses, $includeProperties, $includeInstances));
				}
			}
		}
		
		$m->addParsedNamespaces($this->model->getParsedNamespaces());
		
		return $m;
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function getLabel() {
		
		return $this->isBlankNode() ? Resource::getLocalName() : Resource::getLabel();
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function getLabelForLanguage($language = '') {
		
		$label = array_shift($this->listLabels($language));
		
		return $label ? $label->getLabel() : $this->getLocalName();
	}
	
	public function getLiteralPropertyValue($property, $language = null, $datatype = null) {
		
		return array_shift($this->listLiteralPropertyValues($property, $language, $datatype));
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
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
	 * @see Erfurt_Rdfs_Resource
	 */
	public function getLocalNameFast() {
		
		if ($s1 = strrchr($this->uri, '#')) {
			return substr($s1, 1);
		} else if ($s2 = strrchr($this->uri, '/')) {
			return substr($s2, 1);
		} else if ($s2 = strrchr($this->uri, ':')) {
			return substr($s2, 1);
		} else {
			return $this->uri;
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function getModel() {
		
		return $this->model;
	}
	
	public function getPropertyValue($property, $class = null) {
		
		return array_shift($this->listPropertyValues($property, $class));
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource  
	 */
	public function getType() {
		
		return $this->model->findNode($this, EF_RDF_TYPE, null);
	}
	
	public function hasPropertyValue($property, $value = null) {
		
		if ($this->model->findNode($this, $property, $value)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function hasPropertyValueTransitive($property, $value) {
		
		if ($value instanceof Resource) {
			$value = $value->getLocalName();
		}
			
		return in_array($value, array_keys($this->listPropertyValuesTransitive($property))) ? true : false;
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function isBlankNode() {
		
		if (strstr($this->getURI(), EF_BNODE_PREFIX) === $this->getURI()) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
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
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function isImported() {
		
		if (in_array($this->model->modelID, $this->definingModels())) {
			return false;
		} else  {
			return true;
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function isOfType($type) {
		
		if($this->model->findStatement($this, EF_RDF_TYPE, $type)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function listClasses() {
		
		return $this->listPropertyValues(EF_RDF_TYPE, 'class');
	}
	
	/**
	 * Erfurt_Rdfs_Resource
	 */
	public function listComments($language = null) {
		
		return $this->listLiteralPropertyValues(EF_RDFS_COMMENT, $language);
	}
	
	/**
	 * Erfurt_Rdfs_Resource
	 */
	public function listDifferentFrom() {
		
		return $this->listPropertyValues(EF_OWL_DIFFERENTFROM);
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function listLabels($language = null) {
		
		return $this->listLiteralPropertyValues(EF_RDFS_LABEL, $language);
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function listLabelsPlain($prefix = '', $suffix = '') {
		
		$ret = array();
		foreach ($this->listLabels() as $label) {
			$ret[$prefix.$label->getLanguage().$suffix] = $label->getLabel();
		}
			
		return $ret;
	}
	
	public function listLists() {
		
		$ret = array();
		$n = $this->isBlankNode() ? new BlankNode($this->getURI()) : $this;
		foreach ($this->model->findNodes(null, EF_RDF_FIRST, $n) as $l) {
			while ($p = $this->model->findNode(null, EF_RDF_REST, $l)) {
				$l = $p;
			}
				
			$ret[] = $l;
		}
		
		return $ret;
	}
	
	public function listLiteralPropertyValues($property, $language = null, $datatype = null) {
		
		$ret = array();
		foreach ($this->listPropertyValues($property) as $value) {
			if (($value instanceof Literal) && ($language === null || $value->getLanguage() === $language) &&
					($datatype === null || $value->getDatatype() === $datatype)) {
			
				$ret[$this->model->getLiteralId($value)] = $value;
			}
		}
			
		return $ret;
	}
	
	public function listLiteralPropertyValuesPlain($property, $language = null, $datatype = null) {
		
		$ret = array();
		foreach ($this->listLiteralPropertyValues($property, $language, $datatype) as $value) {
			$ret[] = $value->getLabel();
		}
			
		return $ret;
	}
	
	public function listPropertyValues($property = null, $class = null) {
		
		return $this->model->findNodes($this, $property, null, $class);
	}
	
	public function listPropertyValuesObject($property, $class = null) {
		
		return $this->model->findNodes(null, $property, $this, $class);
	}
	
	public function listPropertyValuesRegEx($property = null, $class = null) {
		
		return $this->model->findRegEx($this->getURI(), $property, null);
	}
	
	public function listPropertyValuesSymmetric($property, $class = null) {
		
		return array_merge(
			$this->listPropertyValues($property, $class),
			$this->listPropertyValuesObject($property, $class)
		);
	}
	
	public function listPropertyValuesTransitive($property, $class = null, $done = array()) {
		
		$ret = $values = $this->listPropertyValues($property);
		foreach($values as $val) {
			if (($val instanceof Resource) && !in_array($val->getURI(), $done)) {
				$ret = array_merge($ret, $val->listPropertyValuesTransitive($property, $class, array_keys($ret)));
			}
		}
			
		return $ret;
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function listSameAs() {
		
		return $this->listPropertyValues(EF_OWL_SAMEAS);
	}
	
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

		$res=$this->isBlankNode()?new BlankNode($this->getURI()):$this;
		$stm1=$this->model->find($res,null,null);
		$stm2=$this->model->find(null,$res,null);
		$stm3=$this->model->find(null,null,$res);
		$stms=array_merge($stm1->triples,$stm2->triples,$stm3->triples);
		foreach($stms as $stm) {
			$this->model->remove($stm);
			if (($stm->subj instanceof BlankNode) || (method_exists($stm->subj, 'isBlankNode') &&
			 		$stm->subj->isBlankNode())) {
				$bNode=$this->model->resourceF($stm->subj);
				$bNode->remove();
			}
			if (($stm->obj instanceof BlankNode) || (method_exists($stm->obj, 'isBlankNode') &&
			 		$stm->obj->isBlankNode())) {
				$bNode=$this->model->resourceF($stm->obj);
				$bNode->remove();
			}
		}
	}
	
	public function removePropertyValues($property) {
		
		$this->setPropertyValues($property);
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function removeType($type) {
		
		if ($this->isOfType($type)) {
			$this->model->remove($this, EF_RDF_TYPE, $type);
		}		
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 **/
	public function rename($newuri, $checkIfNewuriExists = true) {
		
		if (!($newuri instanceof Resource)) {
			$newuri = $this->model->resourceF($newuri);
		}
			
		if ($checkNewuriExists && ($this->model->findNode($newuri, null, null) ||
		 		$this->model->findNode(null, $newuri, null) || $this->model->findNode(null, null, $newuri))) {
			
			return false;
		} else {
			$this->model->replace(null, null, $this, $newuri);
			$this->model->replace(null, $this, null, $newuri);
			$this->model->replace($this, null, null, $newuri);
			$this->uri = $newuri->getURI();
			return true;
		}
	}
	
	public function setClass($classes) {
		
		return $this->setPropertyValues(EF_RDF_TYPE, $classes);
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function setComment($comment, $language = '') {
		
		$this->setPropertyValues(EF_RDFS_COMMENT, $comment, $language, '');
	}
	
	public function setDifferentFrom($values) {
		
		return $this->setPropertyValues(EF_OWL_DIFFERENTFROM, $values);
	}

	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function setLabel($label, $language = null) {

		return $this->setPropertyValues(EF_RDFS_LABEL, $label, $language, null, $language,
			 		'http://www.w3.org/2001/XMLSchema#string');
	}
	
	public function setPropertyValue($property, $value) {
		
		$this->setPropertyValues($property, $value);
	}

	public function setPropertyValues($property, $values = array(), $language = null, $datatype = null, $newLang = null,
	 		$newDtype = null) {
			
		if (!is_array($values) || $values['type'] || isset($values['value']) || isset($values['uri']) || isset($values['lang']) || isset($values['dtype'])) {
			$values = array($values);
		}
		$values = array_filter($values);
		
		if (!($property instanceof Erfurt_Rdfs_Property)) {
			$property = $this->model->propertyF($property);
		}
		
		$range = $property->getRange();
		$val = array();
		
		if ($language || $newLang || $datatype || $newDtype || ($property instanceof Erfurt_Owl_Property && $property->isDatatypeProperty())) {
			$valuesAreLiterals = true;
		} else {
			$valuesAreLiterals = false;
		}
		
		foreach ($values as $v) {
			if ($v instanceof Resource) {
				$val[] = $v->getLocalName();
			} else if ($v instanceof Literal) {
				$val[] = $this->model->getLiteralId($v);
			} else if (is_array($v)) {
				if ($v['type'] != 'resource' && isset($v['value']) && !empty($v['value'])) {
					$vt = $this->model->literalF($v['value'], $v['lang'] != 'Lang' ? $v['lang'] : null, $v['dtype']);
					$obj = $val[] = $this->model->getLiteralId($vt);
				} else if ($v['type'] != 'literal' && $v['uri']) {
					$val[] = $this->model->resourceF($v['uri']);
				}
			} else if ($valuesAreLiterals) {
				$vt = $this->model->literalF($v, $newLang ? $newLang : $language, $newDtype ? $newDtype : $datatype);
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
			if (($valuesOld[$removed] instanceof BlankNode) || (method_exists($valuesOld[$removed], 'isBlankNode') &&
			 		$valuesOld[$removed]->isBlankNode())) {
				
				if (!method_exists($valuesOld[$removed], 'remove')) {
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
	
	public function setPropertyValuesObject($property, $values = array()) {
		
		if (!is_array($values)) {
			$values = array($values);
		}
			
		$valuesOld = $this->listPropertyValuesObject($property);
		$valuesOldPlain = array_keys($valuesOld);
		$values = array_filter($values);
		foreach (array_diff($valuesOldPlain, $values) as $removed) {
			if (($removed instanceof BlankNode) || (method_exists($removed, 'isBlankNode') 
					&& $removed->isBlankNode())) {
			
				$valuesOld[$removed]->remove();
			} else {
				$this->model->remove($removed, $property, $this);
			}
		} 
		
		foreach (array_diff($values, $valuesOldPlain) as $added) {
			$this->model->add($added, $property, $this);
		}
	}
	
	public function setPropertyValuesSymmetric($property, $values = array()) {
		
		if (!is_array($values)) {
			$values = array($values);
		}
			
		$valuesOld = $this->listPropertyValuesSymmetric($property);
		$valuesOldPlain = array_keys($valuesOld);
		$values = array_filter($values);
		foreach (array_diff($valuesOldPlain, $values) as $removed) {
			if (($removed instanceof BlankNode) || (method_exists($removed, 'isBlankNode') 
					&& $removed->isBlankNode())) {
				
				$valuesOld[$removed]->remove();
			} else {
				$this->model->remove($removed, $property, $this);
			}
		} 
		
		foreach (array_diff($values, $valuesOldPlain) as $added) {
			$this->model->add($added, $property, $this);
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function setSameAs($values) {
		
		return $this->setPropertyValues(EF_OWL_SAMEAS, $values);
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function setType($type) {
		
		if (!$this->isOfType($type)) {
			$this->model->add($this, EF_RDF_TYPE, $type);
		}		
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function type($type = null, $setType = null) {
		
		if($type === null) {
			return $this->model->findNodes($this, EF_RDF_TYPE, null);
		} else if ($setType === null) {
			return $this->isOfType($type);
		} else if ($setType === true) {
			$this->setType($type);
		} else {
			$this->removeType($type);
		}		
	}
}
?>
