<?php
/**
 * TODO
 * 
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @see http://www4.wiwiss.fu-berlin.de/bizer/rdfapi/phpdoc/model/Resource.html
 * @version $Id: $
 */
class Erfurt_Rdfs_Resource_Default extends Resource implements Erfurt_Rdfs_Resource {
	
	/**
	 * @var array
	 */
	protected $properties;
	
	/**
	 * A reference to the RDFSModel this resource belongs to.
	 * 
	 * @var Erfurt_Rdfs_Model
	 */
	protected $model;
	
	protected $_propertyValueCache;
	protected $_propertySubjectCache;
	
	/**
	 * Constructor
	 *
	 * @param string $uri ttt
	 * @param RDFSModel $model
	 * @return
	 **/
	public function __construct($uri, Erfurt_Rdfs_Model_Abstract $model, $expandNS = true) {

#debug
#$GLOBALS['EFResourceConstruct']++;

#Zend_Registry::get('erfurtLog')->debug('Erfurt_Rdfs_Resource_Default::__construct()');
		
		if ($uri instanceof Resource) {
			$uri = $uri->getURI();
		}
		
		#if ($uri == '') {
		#	return false;
		#}
			
		if($expandNS && !strstr($uri,'/') && !(substr($uri, 0, 4) == 'http')) {
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

# deprecated... remove asap		
$this->properties = array();


		$this->_propertyValueCache = null;
		$this->_propertySubjectCache = null;
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
	public function countPropertyValuesObject($prop) {
//TODO use method from store... faster for e.g. rdf:type is not fetched by default	
		if ($this->model->getStore() instanceof Erfurt_Store_CountableInterface) {
			return count($this->listPropertyValuesObject($prop));
		} else {
// TODO exception code
			throw new Erfurt_Exception('count not supported by store');
		}
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function countPropertyValuesObjectRecursive($prop, $subRelProp) {
		
		if ($this->model->getStore() instanceof Erfurt_Store_CountableInterface) {
			$count = $this->countPropertyValuesObject($prop);

			foreach ($this->listPropertyValuesObject($subRelProp) as $subItem) {
				$count += $subItem->countPropertyValuesObjectRecursive($prop, $subRelProp);
			}
			
			return $count;
		} else {
// TODO exception code
			throw new Erfurt_Exception('count not supported by store');
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
	
	protected function _fetchPropertyValues() {

		$sparql = 	'SELECT ?p ?o WHERE
					{
						<' . $this->uri . '> ?p ?o . ';
						
		$config = Zend_Registry::get('config');
		if (isset($config->prefetchExlusionPropertiesSubject)) {
			foreach ($config->prefetchExlusionPropertiesSubject->toArray() as $exclude) {
				$sparql .= 'FILTER ( ?p != <' . $exclude . '> ) . ';
			}
		}
		$sparql .= 	'}';

		$result = $this->model->sparqlQuery($sparql);
		
		$this->_propertyValueCache = array(); 			
		foreach ($result as $row) {
			$propString = $row['p']->getURI();
			
			if (isset($this->_propertyValueCache["$propString"])) {
		 		$this->_propertyValueCache["$propString"][] = $row['o'];
		 	} else {
				$this->_propertyValueCache["$propString"] = array($row['o']);
		 	}
		 }
	}
	
	protected function _fetchPropertySubjects() {

		$sparql = 	'SELECT ?s ?p  WHERE
					{
						?s  ?p <' . $this->uri . '> . ';
						
		$config = Zend_Registry::get('config');
		if (isset($config->prefetchExlusionPropertiesObject)) {
			foreach ($config->prefetchExlusionPropertiesObject->toArray() as $exclude) {
				$sparql .= 'FILTER ( ?p != <' . $exclude . '> ) . ';
			}
		}
		$sparql .= 	'}';
		
		$result = $this->model->sparqlQuery($sparql);
				
		$this->_propertySubjectCache = array(); 			
		foreach ($result as $row) {
			$propString = $row['p']->getURI();
			
			if (isset($this->_propertySubjectCache["$propString"])) {
		 		$this->_propertySubjectCache["$propString"][] = $row['s'];
		 	} else {
				$this->_propertySubjectCache["$propString"] = array($row['s']);
		 	}
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
	public function getQualifiedName() {
		
		// blank nodes are local and have no namespace
		if ($this->isBlankNode()) {
			return $this->getLocalName();
		}
		
		$ns = $this->getNamespace();
		
		$namespaces = $this->getModel()->getParsedNamespaces();
		foreach ($namespaces as $ns_uri => $prefix) {
			if ($ns_uri === $ns) {
				$uri = $this->getURI();
				return str_replace($ns, $prefix.':', $uri);
			}
		}
		
		// if namespace equals base uri return only localname
		if ($ns === $this->getModel()->getBaseURI()) {
			return $this->getLocalName();
		}
		
		// add namespace or return uri ???!!! cheack with seebi and norman
		return $this->getURI();
	}
	
	public function getSuperElement($subRelProp) {

		return $this->getPropertyValue($subRelProp);
	}
	
	/**
	 * @param mixed $subRelProp
	 * @param array $ret
	 */
	public function getSuperElementPath($subRelProp, &$ret) {
		
		$ret[] = $this;

		if ($r = $this->getSuperElement($subRelProp)) {
			$r->getSuperElementPath($subRelProp, $ret);
		}
		
		return;
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource  
	 */
	public function getTitle($language = null) {
	
		// handle the case that ow gives us a $language param 'none', which means no lang
		if ($language === 'none') {
			$language = null;
		}
	
		$config = Zend_Registry::get('config');
		
		foreach ($config->titleProperties->toArray() as $title) {
			// if language is set search for label with language tag
			if (($language !== null) && ($ret = $this->getLiteralPropertyValue($title, $language))) {
				return $ret->getLabel();
			// else use anonymous labels (w/o lang tag)
			} else if ($ret = $this->getLiteralPropertyValue($title)) {
				return $ret->getLabel();
			// if still nothing found, try english labels
			} else if ($ret = $this->getLiteralPropertyValue($title, 'en')) {
				return $ret->getLabel('en');
			}
		}
		
		return $this->getLocalName();
	}
	
	public function getTitleWithTitleProperty($language = null) {
		
		// handle the case that ow gives us a $language param 'none', which means no lang
		if ($language === 'none') {
			$language = null;
		}
	
		$config = Zend_Registry::get('config');
		
		foreach ($config->titleProperties->toArray() as $title) {
			// if language is set search for label with language tag
			if (($language !== null) && ($ret = $this->getLiteralPropertyValue($title, $language))) {
				return array($title, $ret->getLabel());
			// else use anonymous labels (w/o lang tag)
			} else if ($ret = $this->getLiteralPropertyValue($title)) {
				return array($title, $ret->getLabel());
			// if still nothing found, try english labels
			} else if ($ret = $this->getLiteralPropertyValue($title, 'en')) {
				return array($title, $ret->getLabel('en'));
			}
		}
		
		return array('localname', $this->getLocalName());
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource  
	 */
	public function getType() {
		
		return $this->model->findNode($this, EF_RDF_TYPE, null);
	}
	
	public function hasPropertyValue($property, $value = null) {
		
		$val = $this->getPropertyValue($property);
		if ($val === null) {
			return false;
		} else {
			if (($value === null) || ($val->getLabel() === $value)) {
				return true;
			} else {
				return false;
			}
		}
		
		#if ($this->model->findNode($this, $property, $value)) {
		#	return true;
		#} else {
		#	return false;
		#}
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
		
		if ($this->hasPropertyValue(EF_RDF_TYPE, EF_OWL_CLASS) ||
			$this->hasPropertyValue(EF_RDF_TYPE, EF_OWL_DEPRECATED_CLASS) ||
			$this->hasPropertyValue(EF_RDF_TYPE, EF_RDFS_CLASS) ||
			$this->hasPropertyValue(EF_RDFS_SUBCLASSOF) ||
			$this->isPropertyValue(EF_RDF_TYPE) ||
			$this->isPropertyValue(EF_RDFS_SUBCLASSOF)) {
		
			return true;
		} else {
			return false;
		}
		
		#if (($this->model->findNode(null, EF_RDF_TYPE, $this) || 
		#		$this->model->findStatement($this, EF_RDF_TYPE, EF_OWL_CLASS) || 
		#		$this->model->findNode($this, EF_RDFS_SUBCLASSOF, null) || 
		#		$this->model->findNode(null, EF_RDFS_SUBCLASSOF, $this) || 
		#		$this->model->findStatement($this, EF_RDF_TYPE, EF_RDFS_CLASS))) {
		#
		#			return true;
		#}
		
		#return false;
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
	
	public function isPropertyValue($property) {
		
		$val = array_shift($this->listPropertyValuesObject($property));
		if ($val === null) {
			return false;
		} else {
			return true;
		}
				
	}
	
	public function listClasses() {
		
		return $this->listPropertyValues(EF_RDF_TYPE, 'class');
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function listComments($language = null) {
		
		return $this->listLiteralPropertyValues(EF_RDFS_COMMENT, $language);
	}
	
	/**
	 * @see Erfurt_Rdfs_Resource
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
	
	/**
	 * @see Erfurt_Rdfs_Resource
	 */
	public function listPropertiesUsedAsObject() {
	
		$config = Zend_Registry::get('config');
		// at least one predicate is excluded from prefteching, so have a look in the db
		if (isset($config->prefetchExlusionPropertiesSubject)) {
			return $this->model->findPredicates(null, $this);
		}
		// it is save to return the prefetched properties
		else {
			if ($this->_propertySubjectCache === null) {
				$this->_fetchPropertySubjects();
			}

			$ret = array();
			foreach ($this->_propertySubjectCache as $key => $value) {
				$ret[] = $this->model->resourceF($key, false);
			}

			return $ret;
		}	
	}
	
	public function listPropertyValues($property = null, $class = null) {
		
		if ($this->_propertyValueCache === null) {
			$this->_fetchPropertyValues();
		}
		
		$ret = array();
		// for it is not sure that all property values are prefetched, we need to go the old way :(
		if ($property === null) {
// TODO fix... this will return an array containing all properties not values :(
			return $this->model->findNodes($this, $property, null, $class);
		}
		// this is the best case... we have a prefetched property, no db query required :) 
		else if (isset($this->_propertyValueCache["$property"])) {
			if ($class === null) {
				$ret = $this->_propertyValueCache["$property"];
			} else {
				$class = strtolower($class);
				if (($class === 'owlclass') || ($class === 'rdfsclass')) {
					$class = 'class';
				} else if (($class === 'owlproperty') || ($class === 'rdfsproperty')) {
					$class = 'property';
				} else if (($class === 'owlinstance') || ($class === 'rdfsinstance')) {
					$class = 'instance';
				}
				
				foreach ($this->_propertyValueCache["$property"] as $row) {
					if ($row instanceof Erfurt_Rdfs_Resource) {
						switch ($class) {
							case 'class':
							case 'erfurt_owl_class':
								$ret[] = $this->model->classF($row, false);
								break;
							case 'property':
							case 'erfurt_rdfs_property':
							case 'erfurt_owl_property':
								$ret[] = $this->model->propertyF($row, false);
								break;
							case 'instance':
							case 'erfurt_rdfs_instance':
							case 'erfurt_owl_instance':
								$ret[] = $this->model->instanceF($row, false);
								break;
							default:
								$ret[] = $row;
						}
					}
				}
			}
		}
		// nothing found in prefetched cache... so ask the db :( 
		else {
			return $this->model->findNodes($this, $property, null, $class);
		} 
		
		return $ret;
	}
	
	public function listPropertyValuesObject($property = null, $class = null) {
		
		if ($this->_propertySubjectCache === null) {
			$this->_fetchPropertySubjects();
		}
		
		$ret = array();
		// for it is not sure that all property values are prefetched, we need to go the old way :(
		if ($property === null) {
			return $this->model->findNodes(null, $property, $this, $class);
		} else {
			if ($property instanceof Erfurt_Rdfs_Resource) {
				$property = $property->getURI();
			}
			// this is the best case... we have a prefetched property, no db query required :)
			if (isset($this->_propertySubjectCache["$property"])) {
				if ($class === null) {
					$ret = $this->_propertySubjectCache["$property"];
				} else {
					$class = strtolower($class);
					if (($class === 'owlclass') || ($class === 'rdfsclass')) {
						$class = 'class';
					} else if (($class === 'owlproperty') || ($class === 'rdfsproperty')) {
						$class = 'property';
					} else if (($class === 'owlinstance') || ($class === 'rdfsinstance')) {
						$class = 'instance';
					}
				
					foreach ($this->_propertySubjectCache["$property"] as $row) {
						if ($row instanceof Erfurt_Rdfs_Resource) {
							switch ($class) {
								case 'class':
								case 'RDFSClass':
								case 'Erfurt_Owl_Class':
									$ret[] = $this->model->classF($row, false);
									break;
								case 'property':
								case 'Erfurt_Rdfs_Property':
								case 'Erfurt_Owl_Property':
									$ret[] = $this->model->propertyF($row, false);
									break;
								case 'instance':
								case 'Erfurt_Rdfs_Instance':
								case 'Erfurt_Owl_Instance':
									$ret[] = $this->model->instanceF($row, false);
									break;
								default:
									$ret[] = $row;
							}
						}
					}
				}
			}
			// nothing found in prefetched cache... so ask the db :( 
			else {
				return $this->model->findNodes(null, $property, $this, $class);
			} 
		}
		
		return $ret;
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
		if ($ls = $this->model->findNode(null, EF_RDF_FIRST, $this)) {
			$le = $this->model->findNode($ls, EF_RDF_REST, null);
			$this->model->remove($ls, EF_RDF_FIRST, $this);
			$this->model->remove($ls, EF_RDF_REST, $le);
			
			if ($le->getURI() != EF_RDF_NIL) {
				$this->model->replace(null, null, $ls, $le);
				$this->model->replace($ls, null, null, $le);
			} else {
				if (!$this->model->findNode(null, EF_RDF_REST, $ls)) {
					$bNode = $this->model->resourceF($ls->getLabel());
#$bNode->uri=$ls->getLabel();
#print_r($bNode);
#					$bNode->remove();
				} else
					$this->model->replace(null,null,$ls,EF_RDF_NIL);
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
                $val[] = $vt->getURI();
			}
		}
		
		$valuesOldPlain = array();
		if ($valuesAreLiterals) {
			$valuesOld = $this->listLiteralPropertyValues($property, $language, $datatype);
			$valuesOldPlain = array_keys($valuesOld);
		} else {
			$valuesOld = $this->listPropertyValues($property);
			foreach ($valuesOld as $value) {
    		    $valuesOldPlain[] = $value->getURI();
    		}
		}
		
        // $valuesOldPlain = array_keys($valuesOld);
		
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
			return $this->listPropertyValues(EF_RDF_TYPE);
			#return $this->model->findNodes($this, EF_RDF_TYPE, null);
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
