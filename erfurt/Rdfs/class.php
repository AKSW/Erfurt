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
class DefaultRDFSClass extends RDFSResource {
	/**
	 * Returns number of all classes that are declared to be sub-classes
	 * of this class.
	 *
	 * @return int Number of all declared sub-classes of this class.
	 **/
	function countSubClasses() {
		return count($this->listSubClasses());
	}
	/**
	 * Returns number of all classes this class is super-class for.
	 *
	 * @return int Number of all sub-classes of this class.
	 **/
	function countSubClassesRecursive() {
		return count($this->listSubClassesRecursive());
	}
	/**
	 * Returns all classes that are declared to be sub-classes
	 * of this class.
	 *
	 * @return array All declared sub-classes of this class.
	 **/
	function listSubClasses() {
		return $this->listPropertyValuesObject('rdfs:subClassOf','Class');
	}
	
	/**
	 * Returns a list with all direct sub-classes of this class.
	 *
	 * @param boolean $emptyClasses Indicated whether empty sub-classes should 
	 * be returned or not.
	 * @return RDFSClass[]/OWLClass[] Returns an array of either RDFSClass objects or OWLClass objects.
	 */
	public function listDirectSubClasses($emptyClasses = false) {
	    
	    $sql = 'SELECT DISTINCT s.subject, s.subject_is
	            FROM statements s
	            WHERE modelID IN (' . $this->model->getModelIds() . ') AND
	            s.predicate = "' . $this->model->_dbId('RDFS_subClassOf') . '" AND 
	            s.object = "' . $this->model->_dbId($this) . '"
	            GROUP BY s.subject
	            ORDER BY s.subject';
	            
	    $subClasses = $this->model->_convertRecordSetToNodeList($sql, $this->model->vclass);
	    
	    if (!$emptyClasses) {
	        $temp = $subClasses;
            $subClasses = array();
            
            foreach ($temp as $t) {
                if (!$t->isEmpty(true)) $subClasses[] = $t;
            }
	    }
	      
	    return $subClasses;
	}
	
	/**
     * Function, which returns whether a class has instances or not (which means empty).
     *
     * @param boolean $includeSubClasses Indicates whether just direct instances should be considered or
     * all sub-classes of the class, too (recursion).
     * @return boolean Returns true iff the class or as the case may be any of it's sub-classes has at least one
     * instance, false otherwise.
     */
	public function isEmpty($includeSubClasses = false) {

        if ($this->countInstances() > 0) return false;
        if ($includeSubClasses) {
            foreach ($this->listSubClassesRecursive() as $subC) {
                if ($subC->countInstances() > 0) {
                    return false;
                } 
            }
            return true;
        }
    }
	
	/**
	 * Sets the direct subclasses of this class.
	 *
	 * @param array $subclasses Array of RDFSClass objects, resource URIs or local names.
	 * @return
	 **/
	function setSubClasses($values) {
		return $this->setPropertyValuesObject('rdfs:subClassOf',$values);
	}
	/**
	 * Returns true if this class is a direct subclass of $class.
	 *
	 * @param RDFSClass $class The class which this class should be sub-class of.
	 * @return boolean
	 **/
	function isSubClassOf($class) {
		return $this->hasPropertyValue('rdfs:subClassOf',$class);
	}
	/**
	 * Returns all classes this class is super-class for.
	 *
	 * @return array Array of all super-classes.
	 **/
	function listSubClassesRecursive() {
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
	function listSuperClasses() {
		return $this->listPropertyValues('rdfs:subClassOf','Class'); # <- returns bNodes
	}
	function getSuperClass() {
		return parray_shift($this->listSuperClasses());
	}
	function getSuperClassPath() {
		$ret[$this->getLocalName()]=$this;
		if($cl=$this->getSuperClass())
			$ret=array_merge($cl->getSuperClassPath(),$ret);
		return $ret;
	}
	function isSuperClassRecursive($class) {
		if(is_a($class,'resource'))
			$class=$class->getLocalName();
		return in_array($class,array_keys($this->listSuperClassesRecursive()));
	}
	/**
	 * Returns an array of RDFSCLass objects which are a superclass
	 * of this class or one of its superclasses.
	 *
	 * @return array Array of RDFSClasses.
	 **/
	function listSuperClassesRecursive() {
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
	function setSuperClasses($values) {
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
	function listDirectProperties() {
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
	function listInheritedProperties($includeAnnotationProperties=false) {
		$propertyURIs=$this->model->vocabulary['Property'];
		if(!$includeAnnotationProperties)
			unset($propertyURIs[$this->model->_dbId('OWL_AnnotationProperty')]);
		return $this->_listInheritedProperties(array_keys($propertyURIs));
	}
	function listInheritedAnnotationProperties() {
		return $this->_listInheritedProperties(array($this->model->_dbId('OWL_AnnotationProperty')));
	}
	/**
	 * RDFSClass::_listInheritedProperties()
	 *
	 * @param $propertyURIs
	 * @return
	 * @access	private
	 **/
	function _listInheritedProperties($propertyURIs) {
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
	function listProperties() {
		return array_merge($this->listDirectProperties(),$this->listInheritedProperties());
	}
	/**
	 * Returns an array of property resource URIs which are set by instances of this class.
	 *
	 * @return array Array of property resource URIs
	 **/
	function listPropertiesUsed() {
# TODO
		$ret=array();
		foreach($this->listProperties() as $cl)
			$ret=array_merge($ret,$cl);
		return $ret;
	}
	function listPropertiesUsedRecursive() {
		$ret=$this->listPropertiesUsed();
		foreach($this->listSubClasses() as $subClass)
			$ret=array_merge($ret,$subClass->listPropertiesUsedRecursive());
		return $ret;
	}
	/**
	 * Lists all distinct values of $property assigned to instances of this class.
	 *
	 * @param $property
	 * @return
	 **/
	function listInstancePropertyValues($property,$resourcesOnly=true) {
		$sql="SELECT DISTINCT s1.object,s1.object_is,s1.l_language,s1.l_datatype
			FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
				AND s1.predicate='".$this->model->_dbId($property)."'
				AND s2.predicate='".$this->model->_dbId('RDF_type')."' AND s2.object='".$this->model->_dbId($this)."')
			WHERE s1.modelID IN (".$this->model->getModelIds().")".($resourcesOnly?" AND s1.object_is='r'":'');
#print_r($sql);
		return $this->model->_convertRecordSetToNodeList($sql);
	}
	function countInstancePropertyValues($property,$resourcesOnly=true,$minDistinctValues=0) {
		if($minDistinctValues>1)
			$sql="SELECT SUM(b) FROM (SELECT 1 as b
					FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
						AND s1.predicate='".$this->model->_dbId($property)."'
						AND s2.predicate='".$this->model->_dbId('RDF_type')."' AND s2.object='".$this->model->_dbId($this)."')
					WHERE s1.modelID IN (".$this->model->getModelIds().")".
						($resourcesOnly?" AND s1.object_is='r'":'').
					'GROUP BY s1.object,s1.object_is,s1.l_language,s1.l_datatype HAVING COUNT(*)>='.$minDistinctValues.') c';
		else
			$sql="SELECT COUNT(DISTINCT s1.object,s1.object_is,s1.l_language,s1.l_datatype)
				FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
					AND s1.predicate='".$this->model->_dbId($property)."'
					AND s2.predicate='".$this->model->_dbId('RDF_type')."' AND s2.object='".$this->model->_dbId($this)."')
				WHERE s1.modelID IN (".$this->model->getModelIds().")".
					($resourcesOnly?" AND s1.object_is='r'":'');
#print_r($sql);
		$ret=$this->model->dbConn->getOne($sql);
#		foreach($this->listSubClasses() as $cl)
#			$ret+=$cl->countInstancePropertyValues($property,$resourcesOnly);
		return $ret;
	}
	/**
	 * Returns an array of local names of the RDFSProperty objects inherited
	 * from super-classes or directly attached to this class: i.e. the properties
	 * that have this class, or optionally one of its super-classes, as domain.
	 *
	 * @return Array of local names of RDFSProperty objects.
	 **/
	function listPropertiesPlain() {
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
	function setProperties($properties) {
		foreach($properties as $property)
			$this->addProperty($property);
	}
	/**
	 * Add this class to the domain of the property.
	 *
	 * @param RDFSProperty $property
	 * @return boolean Returns false if property does not exist.
	 **/
	function addProperty($property) {
		if(!is_a($property,'RDFSProperty'))
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
	function removeProperty($property) {
		if(!is_a($property,'RDFSProperty'))
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
	function countInstances() {
		return count($this->listInstances());
	}
	/**
	 * Returns the number of instances of this class and its sub-classes.
	 *
	 * @return int Number of instances for this class and its sub-classes.
	 **/
	function countInstancesOfSubclasses() {
		$count=0;
		$subclasses=array();
		foreach($this->listSubClasses() as $subclass) {
			$subclasses[]=$subclass->getURI();
			$count+=$subclass->countInstancesOfSubclasses();
		}
		if($subclasses) {
			$subclassSQL=join('\',\'',$subclasses);
			$sql="SELECT COUNT(s1.modelID) FROM statements s1 INNER JOIN statements s2
					ON(s2.modelID IN (".$this->model->getModelIds().") AND s1.subject=s2.object AND s1.object_is=s2.object_is)
				WHERE
					s1.modelID IN (".$this->model->getModelIds().")
					AND s1.predicate='".$this->model->_dbId('RDFS_subClassOf')."' AND s1.object='".$this->model->_dbId($this)."'
					AND s2.predicate='".$this->model->_dbId('RDF_type')."'";
			$count+=$this->model->dbConn->getOne($sql);
		}
		return $count;
	}
	/**
	 * Returns the number of instances of this class and all its sub-classes.
	 *
	 * @return int Number of instances of this class and all its sub-classes.
	 **/
	function countInstancesRecursive() {
		return $this->countInstances()+$this->countInstancesOfSubclasses();
	}
	/**
	 * Returns an array of all distinct label languages for instances of this class.
	 *
	 * @return array All distinct label languages for instances of this class.
	 **/
	function listInstanceLabelLanguages() {
		$sql="SELECT s1.l_language
		      FROM statements s1 INNER JOIN statements s2
		         ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
		            AND s1.predicate='".$this->model->_dbId('RDFS_label')."'
		            AND s2.predicate='".$this->model->_dbId('RDF_type')."'
		            AND s2.object='".$this->model->_dbId($this)."')
				WHERE s1.modelID IN (".$this->model->getModelIds().")
		      GROUP BY s1.l_language";
		return $this->model->dbConn->getCol($sql);
	}
	function listInstanceLabelLanguagesRecursive() {
		$ret=$this->listInstanceLabelLanguages();
		foreach($this->listSubClasses() as $subClass)
			$ret=array_merge($ret,$subClass->listInstanceLabelLanguagesRecursive());
		return $ret;
	}
	function listInstanceLabels($language) {
		$sql="SELECT s1.object,s3.object,s4.object,s5.object
		      FROM statements s1 INNER JOIN statements s2 ON(s1.subject=s2.subject AND s1.modelID=s2.modelID
		            AND s1.predicate='".$this->model->_dbId('RDFS_label')."'
		            AND s1.l_language='".$language."'
		            AND s2.predicate='".$this->model->_dbId('RDF_type')."'
		            AND s2.object='".$this->getURI()."')
				INNER JOIN statements s3 ON(s1.subject=s3.subject AND s1.modelID=s3.modelID
					AND s3.predicate='".Zend_Registry::get('erfurt')->getStore()->SysOnt->baseURI.'labelText'."')
				LEFT JOIN statements s4 ON(s1.subject=s4.subject AND s1.modelID=s4.modelID
		            AND s4.predicate='".$this->model->_dbId('RDFS_comment')."'
		            AND s4.l_language='".$language."')
				LEFT JOIN statements s5 ON(s1.subject=s5.subject AND s1.modelID=s5.modelID
		            AND s5.predicate='".$this->model->_dbId('RDFS_seeAlso')."')
				WHERE s1.modelID IN (".$this->model->getModelIds().")";
		$ret=array();
		foreach($this->model->dbConn->getAll($sql) as $row)
			$ret[$row[1]]=array($row[0],$row[2],$row[3]);
		return $ret;
	}
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
	function listInstances($start=0,$count=0,$erg=0) {
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
	function listInstancesRecursive($start=0,$count=0,$erg=0) {
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
	 **/
	function findInstances($properties=array(),$compare='exact',$start=0,$count=0,$erg=0) {
		$args=func_get_args();
		$cache=new stmCache('findInstances',$args,$this->model,$this);
		if($cache->value!==NULL)
			return $cache->value;

		if(!$properties)
			return $this->listInstances($start,$count,&$erg);
		$ret=array();

		$sql='SELECT s.subject,s.subject_is FROM statements s';
		$n=0;
		if($properties['localName']) {
			$where.=' AND s.subject LIKE "'.$properties['localName'].'%"';
			unset($properties['localName']);
		}
		foreach($properties as $property=>$value) {
			$prop=$this->model->resourceF($property);
			$sql.=($value?' INNER ':' LEFT ');
			$n++;
			if(!$value)
				$cond='1';
			else if($compare=='exact')
				$cond="s$n.object='".(is_a($value,'Resource')?$this->model->_dbId($value):$value)."'";
			else if($compare=='starts')
				$cond="s$n.object LIKE '$value%'";
			else if($compare=='contains')
				$cond="s$n.object LIKE '%$value%'";
			else if($compare=='regex')
				$cond="s$n.object REGEXP '$value'";
			else if($compare=='empty')
				$cond="ISNULL(s$n.object)";

			$sql.='JOIN statements s'.$n." ON(s.modelID=s$n.modelID AND s.subject=s$n.subject AND s$n.predicate='".$this->model->_dbId($prop)."' AND $cond)";
			if(!$value)
				$where.=" AND ISNULL(s$n.object)";
		}
		$sql.=' WHERE s.modelID IN ('.$this->model->getModelIds().') AND
			s.predicate=\''.$this->model->_dbId('RDF_type').'\' AND s.object=\''.$this->model->_dbId($this).'\''.
			(!empty($where)?$where:'').' GROUP BY s.subject';
#print_r($sql);
		if($count)
			$res=&$this->model->dbConn->PageExecute($sql,$count,$start/$count+1);
		else
			$res=&$this->model->dbConn->execute($sql);

		$erg=$res->_maxRecordCount?$res->_maxRecordCount:$res->_numOfRows;

		$ret=$this->model->_convertRecordSetToNodeList($res,$this->model->instance);
		$cache->set($ret,array_merge(array('rdf:type'),array_keys($properties)));
		return $ret;
	}
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
	function findInstance($properties=array(),$compare='exact') {
		$ret=parray_shift($this->findInstances($properties,$compare,0,1));
		return $ret;
	}
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
	function findInstancesRecursive($properties=array(),$compare='exact',$start=0,$count=0,$erg=0) {
		static $subclasses;

#		if($properties)
		return $this->model->_findInstances('IN (\''.$this->model->_dbId($this).'\',\''.join('\',\'',$this->model->_dbIds($this->listSubClassesRecursive())).'\')',$properties,$compare,$start,$count,&$erg);
#		else
#			return $this->listInstances($start,$count,&$erg);
	}
	/**
	 * Return RDFSInstance object with specified URI.
	 * If no RDFSInstance is found, return false.
	 *
	 * @param string $uri
	 *
	 * @return RDFSInstance or false.
	 **/
	function getInstance($uri) {
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
	function addSubClass($subclass) {
		if(!is_a($subclass,$this->model->vclass))
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
	function addInstance($instance) {
		if(!is_a($instance,'Resource'))
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
	function removeInstance($instance) {
		if(!is_a($instance,'Resource'))
			$instance=$this->model->getInstance($instance);
		$instance->remove();
	}
	/**
	 * Deletes all instances of this class.
	 *
	 * @return void
	 **/
	function removeInstances() {
		foreach($this->listInstances() as $instance)
			$instance->remove();
	}
}
?>