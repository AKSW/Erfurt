<?php
/**
 * Class that represents an RDFS ontology node characterising a class description.
 *
 * @package RDFSAPI
 * @author Sören Auer <soeren@auer.cx>
 * @copyright Copyright (c) 2004
 * @version $Id: class.php 956 2007-04-23 11:21:47Z cweiske $
 * @access public
 **/
abstract class Erfurt_Rdfs_Class_Abstract extends RDFSResource {
	
	public function isHidden() {
		
		if (isset($this->hidden)) {
			return $this->hidden;
		} else {
			$hidden = $this->model->hasStatement($this, 'http://ns.ontowiki.net/SysOnt/hidden', 'true');
			$this->hidden = $hidden;
			
			return $hidden;
		}
	}
	
	public function isSystem() {
		
		if (isset($this->system)) {
			return $this->system;
		} else {
			$system = false;
			if (((strstr($this->getURI(), EF_RDF_NS)) || (strstr($this->getURI(), EF_RDFS_NS)) || (strstr($this->getURI(), EF_OWL_NS)))) {
				$system = true;
			}
			$this->system = $system;
			
			return $system;
		}
	}
	
	public function isImplicit() {
		
		if (isset($this->implicit)) {
			return $this->implicit;
		} else {
			$implicit = !$this->model->hasStatement($this, 'rdf:type', array(EF_RDFS_CLASS, EF_OWL_CLASS, EF_OWL_DEPRECATED_CLASS));
			$this->implicit = $implicit;
			
			return $implicit;
		}
	}
	
	/**
	 * Returns number of all classes that are declared to be sub-classes
	 * of this class.
	 *
	 * @return int Number of all declared sub-classes of this class.
	 **/
	public function countSubClasses() {
		
		return count($this->listSubClasses());
	}
	
	/**
	 * Returns number of all classes this class is super-class for.
	 *
	 * @return int Number of all sub-classes of this class.
	 **/
	public function countSubClassesRecursive() {
		
		return count($this->listSubClassesRecursive());
	}
	
	/**
	 * Returns all classes that are declared to be sub-classes
	 * of this class.
	 *
	 * @return array All declared sub-classes of this class.
	 **/
	public function listSubClasses() {
		
		return $this->listPropertyValuesObject('rdfs:subClassOf','Class');
	}
	
	/**
	 * Returns a list with all direct sub-classes of this class.
	 *
	 * @param boolean $emptyClasses Indicated whether empty sub-classes should 
	 * be returned or not.
	 * @return RDFSClass[]/OWLClass[] Returns an array of either RDFSClass objects or OWLClass objects.
	 */
	abstract public function listDirectSubClasses($emptyClasses = false);
	    
	/**
     * Function, which returns whether a class has instances or not (which means empty).
     *
     * @param boolean $includeSubClasses Indicates whether just direct instances should be considered or
     * all sub-classes of the class, too (recursion).
     * @return boolean Returns true iff the class or as the case may be any of it's sub-classes has at least one
     * instance, false otherwise.
     */
	public function isEmpty($includeSubClasses = false) {
		
		if ($includeSubClasses === true) {
			if (isset($this->emptyRecursive)) {
				return $this->emptyRecursive;
			} else {
				if ($this->countInstancesRecursive() > 0) {
					$this->emptyRecursive = false;
					return false;
				} else {
					$this->emptyRecursive = true;
					return true;
				}
			}
		} else {
			if (isset($this->empty)) {
				return $this->empty;
			} else {
				if ($this->countInstances() > 0) {
					$this->empty = false;
					return false;
				} else {
					$this->empty = true;
					return true;
				}
			}
		}
    }
	
	/**
	 * Sets the direct subclasses of this class.
	 *
	 * @param array $subclasses Array of RDFSClass objects, resource URIs or local names.
	 * @return
	 **/
	public function setSubClasses($values) {
		
		return $this->setPropertyValuesObject('rdfs:subClassOf',$values);
	}
	
	/**
	 * Returns true if this class is a direct subclass of $class.
	 *
	 * @param RDFSClass $class The class which this class should be sub-class of.
	 * @return boolean
	 **/
	public function isSubClassOf($class) {
		
		return $this->hasPropertyValue('rdfs:subClassOf',$class);
	}
	
	/**
	 * Returns all classes this class is super-class for.
	 *
	 * @return array Array of all super-classes.
	 **/
	public function listSubClassesRecursive() {
		
		$ret=$this->listSubClasses();
		foreach($ret as $subclass)
			$ret=array_merge($ret,$subclass->listSubClassesRecursive());
		ksort($ret);
		return $ret;
	}
	
	/**
	 * Returns an array of all classes that are declared to be super-classes
	 * of this class. Each element of the array will be an RDFSClass.
	 *
	 * @return array Array of all declared super-classes of this class.
	 **/
	public function listSuperClasses() {
		
		return $this->listPropertyValues('rdfs:subClassOf','Class'); # <- returns bNodes
	}
	
	public function getSuperClass() {
		
		return parray_shift($this->listSuperClasses());
	}
	
	public function getSuperClassPath() {
		
		$ret[$this->getLocalName()]=$this;
		if($cl=$this->getSuperClass())
			$ret=array_merge($cl->getSuperClassPath(),$ret);
		return $ret;
	}
	
	public function isSuperClassRecursive($class) {
		
		if($class instanceof Resource)
			$class=$class->getLocalName();
		return in_array($class,array_keys($this->listSuperClassesRecursive()));
	}
	
	/**
	 * Returns an array of RDFSCLass objects which are a superclass
	 * of this class or one of its superclasses.
	 *
	 * @return array Array of RDFSClasses.
	 **/
	public function listSuperClassesRecursive() {
		
		$ret=$this->listSuperClasses();
		foreach($ret as $superclass)
			$ret=array_merge($ret,$superclass->listSuperClassesRecursive());
		ksort($ret);
		return $ret;
	}
	
	/**
	 * Sets the super classes of this class.
	 *
	 * @param array $superclasses Array of RDFSClass objects, resource URIs or local names.
	 * @return void
	 **/
	public function setSuperClasses($values) {
		
		// setPropertyValues is not used, since it does not preserve subClass of bNodes
		if(!is_array($values))
			$values=array($values);
		$valuesOld=array_keys($this->listSuperClasses());
		$values=array_filter($values);
		foreach(array_diff($valuesOld,$values) as $removed)
			$this->model->remove($this,'rdfs:subClassOf',$removed);
		foreach(array_diff($values,$valuesOld) as $added)
			$this->model->add($this,'rdfs:subClassOf',$added);
	}
	
	/**
	 * Returns an array of RDFSProperty objects directly attached to this class:
	 * i.e. the properties that have this class as domain.
	 *
	 * @return array Array of RDFSProperty objects.
	 **/
	public function listDirectProperties() {
		$ret=$this->model->findNodes(NULL,$GLOBALS['RDFS_domain'],$this,'Property');
		foreach($ret as $property)
			$ret=array_merge($ret,$property->listSubProperties());
		# TODO consider properties which have a union as domain
		return array($this->getLocalName()=>$ret);
	}
	
	/**
	 * Returns an array of RDFSProperty objects inherited from super-classes
	 * to this class: i.e. the properties that have one of its super-classes
	 * as domain.
	 *
	 * @return array Array of RDFSProperty objects.
	 **/
	public function listInheritedProperties($includeAnnotationProperties=false) {
		
		$propertyURIs=$this->model->vocabulary['Property'];
		if(!$includeAnnotationProperties)
			unset($propertyURIs[$this->model->_dbId('OWL_AnnotationProperty')]);
		return $this->_listInheritedProperties(array_keys($propertyURIs));
	}
	
	public function listInheritedAnnotationProperties() {
		
		return $this->_listInheritedProperties(array($this->model->_dbId('OWL_AnnotationProperty')));
	}
	
	/**
	 * RDFSClass::_listInheritedProperties()
	 *
	 * @param $propertyURIs
	 * @return
	 * @access	private
	 **/
	protected function _listInheritedProperties($propertyURIs) {
		
		$c=cache('listInheritedProperties'.$this->model->modelURI.$this->getURI());
		if($c!==NULL)
			return $c;
		$ret=array();
		if(!$superclasses=method_exists($this,'listSuperClassesInfered')?$this->listSuperClassesInfered():$this->listSuperClasses()) {
			// get Properties at OWL_Thing
			$ret=array('owl:Thing'=>$this->model->findNodes(NULL,$GLOBALS['RDFS_domain'],$GLOBALS['OWL_Thing'],'Property'));
			// TODO get properties with domain not defined
		}
		$done=array();
		foreach($superclasses as $sckey=>$sc) {
			foreach($sc->listProperties() as $class=>$props)
				foreach($props as $prop=>$val) {
					if(!in_array($prop,$done)) {
						$ret[$class][$prop]=$val;
						$done[$prop]=$prop;
					}
				}
		}
		cache('listInheritedProperties'.$this->model->modelURI.$this->getURI(),array(),$ret);
		return $ret;
	}
	
	/**
	 * Returns an array of RDFSProperty objects inherited from super-classes
	 * or directly attached to this class: i.e. the properties that have this
	 * class, or optionally one of its super-classes, as domain.
	 *
	 * @return Array of RDFSProperty objects.
	 **/
	public function listProperties() {
		
		return array_merge($this->listDirectProperties(),$this->listInheritedProperties());
	}
	
	/**
	 * Returns an array of property resource URIs which are set by instances of this class.
	 *
	 * @return array Array of property resource URIs
	 **/
	public function listPropertiesUsed() {
# TODO
		$ret=array();
		foreach($this->listProperties() as $cl)
			$ret=array_merge($ret,$cl);
		return $ret;
	}
	
	public function listPropertiesUsedRecursive() {
		
		$ret=$this->listPropertiesUsed();
		foreach($this->listSubClasses() as $subClass)
			$ret=array_merge($ret,$subClass->listPropertiesUsedRecursive());
		return $ret;
	}
	
	/**
	 * Lists all distinct values of $property assigned to instances of this class.
	 *
	 * @param string/Resource $property
	 * @param boolean $resourcesOnly Indicated whether only resources should be returned.
	 * @return Node[]
	 */
	abstract public function listInstancePropertyValues($property,$resourcesOnly=true);
	
	/**
	 * Counts all distinct values of $property assigned to instances of this class
	 *
	 * @param string/Resource $property
	 * @param boolean $resourcesOnly Indicated whether only resources should be returned.
	 * @param int $minDistinctValues
	 * @return int
	 */
	abstract public function countInstancePropertyValues($property,$resourcesOnly=true,$minDistinctValues=0);
	
	/**
	 * Returns an array of local names of the RDFSProperty objects inherited
	 * from super-classes or directly attached to this class: i.e. the properties
	 * that have this class, or optionally one of its super-classes, as domain.
	 *
	 * @return Array of local names of RDFSProperty objects.
	 **/
	public function listPropertiesPlain() {
		
		$ret=array();
		foreach($this->listProperties() as $lp)
			foreach($lp as $p)
				$ret[$p->getURI()]=$p->getLocalname();
		return $ret;
	}
	
	/**
	 * Add this class to the domain of the properties and remove it from all others.
	 * FIXME - seems to be broken
	 *
	 * @param array $properties Array of RDFSProperties.
	 * @return
	 **/
	public function setProperties($properties) {
		
		foreach($properties as $property)
			$this->addProperty($property);
	}
	
	/**
	 * Add this class to the domain of the property.
	 *
	 * @param RDFSProperty $property
	 * @return boolean Returns false if property does not exist.
	 **/
	public function addProperty($property) {
		
		if(!($property instanceof RDFSProperty))
			if(!$property=$this->model->getProperty($property))
				return false;
		if(!in_array($this,$property->listDomain()))
			$this->model->add($property,$GLOBALS['RDFS_domain'],$this);
	}
	
	/**
	 * Remove the property from this class.
	 *
	 * @param RDFSProperty $property
	 * @return boolean Returns false if property does not exist.
	 **/
	public function removeProperty($property) {
		
		if(!($property instanceof RDFSProperty))
			$property=$this->model->getProperty($property);
		$stms=$this->model->find($property,$GLOBALS['RDFS_domain'],$this);
		foreach($stms->triples as $stm)
			$this->model->remove($stm);
	}
	
	/**
	 * Returns the number of instances of this class.
	 *
	 * @return int Number of instances for this class.
	 **/
	public function countInstances() {
		
		return count($this->listInstances());
	}
	
	/**
	 * Returns the number of instances of this class and its sub-classes.
	 *
	 * @return int Number of instances for this class and its sub-classes.
	 */
	abstract public function countInstancesOfSubclasses(); 
	
	/**
	 * Counts all direct instances and all instances of all subclasses.
	 * 
	 * @return int Returns the number of instances of this class and its subclasses.
	 */
	public function countInstancesRecursive() {
		
		if (isset($this->countInstancesRecursive)) {
			return $this->countInstancesRecursive;
		}
		
		$count = $this->countInstances();
		$subclasses = $this->listDirectSubClasses();
		
		if (count($subclasses) === 0) return $count;
		else {
			foreach ($subclasses as $s) $count += $s->countInstancesRecursive();
		}
		
		$this->countInstancesRecursive = $count;
		return $count;
	}
	
	/**
	 * Returns an array of all distinct label languages for instances of this class.
	 *
	 * @return array All distinct label languages for instances of this class.
	 */
	abstract public function listInstanceLabelLanguages();
	
	public function listInstanceLabelLanguagesRecursive() {
		
		$ret=$this->listInstanceLabelLanguages();
		foreach($this->listSubClasses() as $subClass)
			$ret=array_merge($ret,$subClass->listInstanceLabelLanguagesRecursive());
		return $ret;
	}
	
	/**
	 * This method returns the labels for a given language.
	 *
	 * @param string $language The language code, e.g.: 'de', or 'en'.
	 * @return array
	 */
	abstract public function listInstanceLabels($language);
	
	/**
	 * Return an array of individuals in the model that have this class among
	 * their types.
	 *
	 * @param int $start Return results starting with this row number.
	 * @param int $count Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 *
	 * @return Array of RDFSInstance objects.
	 **/
	public function listInstances($start=0,$count=0,$erg=0) {
		
		return $this->model->listTypes($this,'RDFSInstance',$start,$count,&$erg);
	}
	
	/**
	 * Return an array of individuals in the model that have this class or one
	 * of its sub-classes among their types.
	 *
	 * @param int $start Return results starting with this row number.
	 * @param int $count Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 *
	 * @return Array of RDFSInstance objects.
	 **/
	public function listInstancesRecursive($start=0,$count=0,$erg=0) {
		
		$ret=$this->listInstances();
		foreach(method_exists($this,'listSubClassesInfered')?$this->listSubClassesInfered():$this->listSubClasses() as $subclass) {
			$ret=array_merge($ret,$subclass->listInstancesRecursive());
			if(count($ret)>$start+$count)
				break;
		}
		$erg=count($ret);
		return $count?array_slice($ret,$start,$count):$ret;
	}
	
	/**
	 * Return an array of individuals in the model that have this class among
	 * their types. If an array of PropertyURI=>Value is given, only individuals
	 * with the specified property values will be returned.
	 *
	 * @param array $properties Array of PropertyURI=>Value pairs.
	 * @param string $compare Comparision method to be used - default is exact match.
	 * @param int $start Return results starting with this row number.
	 * @param int $count Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 *
	 * @return Array of RDFSInstance objects.
	 */
	abstract public function findInstances($properties=array(),$compare='exact',$start=0,$count=0,$erg=0);
	
	/**
	 * Return an array of individuals in the model that have this class or its sub-classes among
	 * their types. If an array of PropertyURI=>value pairs is given, only individuals
	 * with the specified property values will be returned.
	 *
	 * @param array $properties Array of PropertyURI=>Value pairs.
	 * @param string $compare Comparision method to be used - default is exact match.
	 *
	 * @return array Array of RDFSInstance objects.
	 **/
	abstract public function findInstancesRecursive($properties = array(), $compare = 'exact', $offset = 0, $limit = 0,$erg = 0);

	/**
	 * Return one individual in the model that has this class among
	 * its types. If an array of PropertyURI=>Value is given, only individuals
	 * with the specified property values will be returned.
	 *
	 * @param array $properties Array of PropertyURI=>Value pairs.
	 * @param string $compare Comparision method to be used - default is exact match.
	 *
	 * @return RDFSInstance object.
	 **/
	public function findInstance($properties=array(),$compare='exact') {
		
		$ret=parray_shift($this->findInstances($properties,$compare,0,1));
		return $ret;
	}
	
	/**
	 * Return RDFSInstance object with specified URI.
	 * If no RDFSInstance is found, return false.
	 *
	 * @param string $uri
	 *
	 * @return RDFSInstance or false.
	 **/
	public function getInstance($uri) {
		
		$res=$this->model->find($uri,'rdf:type',$this);
		if($res->triples)
			return $this->model->instanceF($uri);
		else return false;
	}
	
	/**
	 * Add a sub-class of this class. If the subclass is a URI instead of a RDFSClass
	 * object - the subclass will first be created.
	 *
	 * @param RDFSClass $subclass A class that is a sub-class of this class.
	 * @return RDFSClass The class created.
	 **/
	public function addSubClass($subclass) {

		if(!($subclass instanceof RDFSClass))
			$subclass=$this->model->addClass($subclass);
		$this->model->add($subclass,'rdfs:subClassOf',$this);
		return $subclass;
	}
	
	/**
	 * Create new instance
	 *
	 * @param String $instance Local name of instance to create.
	 * @return
	 **/
	public function addInstance($instance) {
		
		if(!($instance instanceof Resource))
			$instance=$this->model->instanceF($instance);
		// check if name is allowed
		$stms=$this->model->find($instance,'rdf:type',NULL);
		if(!$stms->triples)
			$this->model->add($instance,'rdf:type',$this);
		return $instance;
	}
	
	/**
	 * Removes a instance.
	 * TODO: redundant?/broken?
	 *
	 * @param String $instance Local name of instance to create.
	 * @return
	 **/
	public function removeInstance($instance) {
		
		if(!($instance instanceof Resource))
			$instance=$this->model->getInstance($instance);
		$instance->remove();
	}
	
	/**
	 * Deletes all instances of this class.
	 *
	 * @return void
	 **/
	public function removeInstances() {
		
		foreach($this->listInstances() as $instance)
			$instance->remove();
	}
}
?>
