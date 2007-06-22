<?php
/**
 * DefaultRDFSModel
 *
 * @package rdfsapi
 * @author soa
 * @copyright Copyright (c) 2006
 * @version $Id: model.php 982 2007-05-14 14:09:12Z cweiske $
 */
abstract class DefaultRDFSModel extends DbModel {
	/**
	 * Provides a view of the model as a resource, e.g. to retrieve
	 * or set owl:OntologyProperties.
	 **/
	var $asResource;
	var $logActions=array();
	var $importsSQL;
	var $importsIds=array();
	var	$resource='RDFSResource';
	var $vocabulary;
	var $instance;
	
	/**
	 * if is set, model can be written
	 */
	private $_isEditable = false;
	
	/**
	 * Class constructor.
	 *
	 * @param RDFSStore $store
	 * @param string $modelURI
	 * @return RDFSmodel
	 **/
	function DefaultRDFSModel($store,$modelURI,$type=NULL) {
		if(!$store->modelExists($modelURI))
			return FALSE;

		$this->dbConn 	=& $store->dbConn;
		$this->store 	=& $store;
		$this->modelURI = $modelURI;
		$this->type=$type?$type:$this->getType();
		$this->resource='RDFSResource';
		$this->vclass=($this->type=='OWL'?'OWL':'RDFS').'Class';
		$this->property=($this->type=='OWL'?'OWL':'RDFS').'Property';
		$this->instance=($this->type=='OWL'?'OWL':'RDFS').'Instance';
		$this->asResource=new $this->resource($this->modelURI,&$this);
#		$this->asResource=new $this->resource(rtrim($this->modelURI,'/#'),&$this);
		$this->importsSQL='';

		$this->vocabulary=array(
				'Class'=>array(
					$this->_dbId('OWL_Class')=>$GLOBALS['OWL_Class'],
					$this->_dbId('RDFS_Class')=>$GLOBALS['RDFS_Class'],
					$this->_dbId('OWL_DeprecatedClass')=>$GLOBALS['OWL_DeprecatedClass']),
				'Property'=>array(
					$this->_dbId('RDF_Property')=>$GLOBALS['RDF_Property'],
					$this->_dbId('OWL_DatatypeProperty')=>$GLOBALS['OWL_DatatypeProperty'],
					$this->_dbId('OWL_ObjectProperty')=>$GLOBALS['OWL_ObjectProperty'],
					$this->_dbId('OWL_AnnotationProperty')=>$GLOBALS['OWL_AnnotationProperty'],
					$this->_dbId('OWL_DeprecatedProperty')=>$GLOBALS['OWL_DeprecatedProperty'],
					$this->_dbId('OWL_FunctionalProperty')=>$GLOBALS['OWL_FunctionalProperty'],
					$this->_dbId('OWL_InverseFunctionalProperty')=>$GLOBALS['OWL_InverseFunctionalProperty'],
					$this->_dbId('OWL_SymmetricProperty')=>$GLOBALS['OWL_SymmetricProperty'],
					$this->_dbId('OWL_TransitiveProperty')=>$GLOBALS['OWL_TransitiveProperty'],
					)
			);
	}
	/**
	 * Resource factory.
	 *
	 * @param string $uri URI or localname of the resource to generate
	 * @return RDFSResource
	 **/
	function resourceF($uri, $expandNS = true) {
		
		return new RDFSResource($uri, $this, $expandNS);
	}
	/**
	 * Class factory.
	 *
	 * @param string $uri URI or localname of the class to generate
	 * @return RDFSClass
	 **/
	function classF($uri, $expandNS = true) {
		
		return new RDFSClass($uri, $this, $expandNS);
	}
	/**
	 * Property factory.
	 *
	 * @param string $uri URI or localname of the property to generate
	 * @return RDFSProperty
	 **/
	function propertyF($uri, $expandNS = true) {
		
		return new RDFSProperty($uri, $this, $expandNS);
	}
	
	/**
	 * Instance factory.
	 *
	 * @param string $uri URI or localname of the instance to generate
	 * @return RDFSInstance
	 **/
	function instanceF($uri, $expandNS = true) {
		
		return new RDFSInstance($uri, $this, $expandNS);
	}
	
	/**
	 *
	 *
	 * @param string $label
	 * @param string/null $language
	 * @param string/Resource/null $datatype
	 * @return RDFSLiteral
	 */
	public function literalF($label, $language = null, $datatype = null) {
		
		return new RDFSLiteral($label, $language, $datatype);
	}
	
	/**
	 * @abstract Can't use abstract construct, for this is inherited from RAP DbModel -> Implement this for a
	 * specific backend.
	 * @return string[] Returns an associative array where the key is a namespace and the value a prefix.
	 */
	public function getParsedNamespaces() { /* abstract */ }

	/**
	 * Returns a list of models imported by owl:imports.
	 *
	 * @return array Array of RDFResources
	 */
	public function listImports() {
		
		return $this->asResource->listPropertyValues($GLOBALS['OWL_imports']);
	}
	
	public function listModelIds() {
		
		return array_merge($this->importsIds,array($this->modelID));
	}
	
	public function getModelIds() {
		
		return join(',', $this->listModelIds());
	}
	
	/**
 	 * Internal method, that returns a resource URI that is unique for the DbModel.
 	 * URIs are generated using the base_uri of the DbModel, the prefix and a unique number.
 	 *
 	 * @param	string	$prefix
 	 * @return	string
 	 * @access	private
 	 */
 	function getUniqueResourceURI($prefix) {
		
		static $counter;
   		$counter = !empty($counter)?$counter:1;
   		while (true) {
     		$uri= ($prefix!=BNODE_PREFIX?$this->getBaseURI():'').$prefix.$counter;
	 		$tempbNode= new BlankNode($uri);
     		$res1 = $this->find($tempbNode, NULL, NULL);
  	 		$res2 = $this->find(NULL, NULL, $tempbNode);
	 		$Node= new $this->resource($uri,$this);
     		$res3 = $this->find($Node, NULL, NULL);
  	 		$res4 = $this->find(NULL, NULL, $Node);
	 		if ($res1->size()==0 && $res2->size()==0 && $res3->size()==0 && $res4->size()==0)
        		return $uri;
     		$counter++;
   		}
	}

	/**
	 * Returns a string representation of the literal.
	 *
	 * @param Literal $literal
	 * @return string
	 **/
	public function getLiteralId($literal) {
		
		return '"'.$literal->getLabel().'"@'.$literal->getLanguage().'^^'.$literal->getDatatype();
	}
	
	/**
	 * Returns a uniq string for a node, which can be used for indexing arrays of nodes.
	 *
	 * @param node $node
	 * @return string
	 **/
	public function getNodeId($node) {
		
		return is_a($node,'resource')?$node->getLocalName():$this->getLiteralId($node);
	}
	
	/**
	 * Creates a new Statement with the given parameters
	 *
	 * @param RDFSResource/string/Statement/int $subj Subject of the Statement
	 * @param RDFSResource/string/null $pred Predicate of the Statement
	 * @param RDFSNode/string/null $obj Object of the Statement
	 * @param string/null $objLang Optional a language
	 * @param string/null $objDType  Optional a datatype
	 * @return Statement
	 */
	abstract protected function _createStatement($subj, $pred = false, $obj = false, $objLang = '', $objDType = '');
	
	
	/**
	 * Adds a statement to the model.
	 *
	 * @abstract Can't use abstract construct, for this is inherited from RAP DbModel -> Implement this for a
	 * specific backend.
	 * @param RDFSResource $subj Subject of the Statement
	 * @param RDFSResource $pred Predicate of the Statement
	 * @param RDFSNode $obj Object of the Statement
	 * @return boolean Returns true iff the statement was added successfully.
	 */
	public function add($subj, $pred = '', $obj = '') { /* abstract */ }
	
	/**
	 * Removes a statement from the model
	 *
	 * @abstract Can't use abstract construct, for this is inherited from RAP DbModel -> Implement this for a
	 * specific backend.
	 * @param RDFSResource $subj Subject of the Statement
	 * @param RDFSResource $pred Predicate of the Statement
	 * @param RDFSResource_or_Literal $obj Object of the Statement
	 * @return boolean Returns true iff the statement was removed successfully.
	 */
	public function remove($subj,$pred='',$obj='') { /* abstract */ }
	
	/**
	 * Returns the type of the model.
	 *
	 * @return string Returns one of RDF, RDFS or OWL.
	 */
	public function getType() {
		 
		if(!empty(Zend_Registry::get('config')->SysOntModelURI) && $this->modelURI == Zend_Registry::get('config')->SysOntModelURI)
			$type='OWL';
		else if(!empty($this->store->SysOnt) && $modelClass = $this->store->SysOnt->getClass('Model'))
			if($modelInstance=$modelClass->findInstance(array('modelURI'=>$this->modelURI)))
				$type=$modelInstance->getPropertyValuePlain('modelType');
		if((!empty($type) && $type=='OWL') || (empty($type) && ($this->findNode(NULL,'rdf:type','owl:Ontology') || $this->findNode(NULL,'rdf:type','owl:Class')))) {
			return 'OWL';
		} else {
			$this->vocabulary=array(
				'Class'=>array($this->_dbId('RDFS_Class')=>$GLOBALS['RDFS_Class']),
				'Property'=>array($this->_dbId('RDF_Property')=>$GLOBALS['RDF_Property'])
			);
			if(!empty($type) && $type=='RDFS' || (empty($type) && $this->findNode(NULL,'rdf:type','rdfs:Class')))
				return 'RDFS';
			else
				return 'RDF';
		}
	}
	
	/**
	 * Sets the type of the model.
	 * 
	 * @param string $type The new type for the model. (Currently only 'OWL' is supported.)
	 */ 
	public function setType($type) {
		
		if ($type != $this->getType()) {
			if ($type == 'OWL')
				$this->add($this->modelURI, 'rdf:type', 'owl:Ontology');
		}
	}
	
	/**
	 * Returns an array of all XML namespaces (unique) used in the model (not the namespaces from the namespace table; 
	 * just namespaces that are used in statements).
	 *
	 * @return string[] Array of XML namespaces.
	 */
	abstract public function listNamespaces();
	
	/**
	 * Returns an array of all XML datatypes (unique) used in the model.
	 *
	 * @return string[] Array of XML datatypes.
	 */
	abstract public function listDatatypes();
	
	/**
	 * Returns an array of all languages (unique) used in conjunction with literals in the model.
	 *
	 * @return string[] Array of language strings.
	 */
	abstract public function listLanguages();
	
	/**
	 * Returns an array of all resource URIs in the model.
	 *
	 * @return array Array of resource URIs.
	 */
	public function listResources() {
		
		return array_merge($this->listResourcesSubject(), $this->listResourcesPredicate(), $this->listResourcesObject());
	}
	
	/**
	 * Returns a all (or if $count is given max. $count) matching (if search string is given) resources of a given column.
	 * An optional offset can be set by passing the $start parameter.
	 *
	 * @param string $col One of 'subject', 'predicate' or 'object.
	 * @param string/null $search An optional search string
	 * @param int/null $start
	 * @param int/null $count
	 * @param int/null $erg
	 * @return RDFSResource[] Returns an associative array, where the key is the URI of the resource and the value is an
	 * RDFSResource object.
	 */
	abstract protected function _listResourcesCol($col, $search = '', $start = 0, $count = 0, $erg = 0);
	
	/**
	 * Returns an array of all (or if $count is given max. $count) matching (if search string is given) resource URIs, 
	 * which occur as subjects of statements in the model. An optional offset can be set by passing the $start parameter.
	 *
	 * @return RDFSResource[] Returns an associative array, where the key is the URI of the resource and the value is an
	 * RDFSResource object.
	 */
	public function listResourcesSubject($search = '', $start = 0, $count = 0, $erg = 0) {
		
		return $this->_listResourcesCol('subject', $search, $start, $count, &$erg);
	}
	
	/**
	 * Returns an array of all (or if $count is given max. $count) matching (if search string is given) resource URIs, 
	 * which occur as predicate of statements in the model. An optional offset can be set by passing the $start parameter.
	 *
	 * @return RDFSResource[] Returns an associative array, where the key is the URI of the resource and the value is an
	 * RDFSResource object.
	 */
	public function listResourcesPredicate($search = '', $start = 0, $count = 0, $erg = 0) {
		
		return $this->_listResourcesCol('predicate', $search, $start, $count, &$erg);
	}
	
	/**
	 * Returns an array of all (or if $count is given max. $count) matching (if search string is given) resource URIs, 
	 * which occur as objects of statements in the model. An optional offset can be set by passing the $start parameter.
	 *
	 * @return RDFSResource[] Returns an associative array, where the key is the URI of the resource and the value is an
	 * RDFSResource object.
	 */
	public function listResourcesObject($search = '', $start = 0, $count = 0, $erg = 0) {
		
		return $this->_listResourcesCol('object', $search, $start, $count, &$erg);
	}
	
	/**
	 * Find helper function.
	 *
	 * @deprecated use listRDFTypeInstances or listRDFTypeInstancesAs instead
	 * @param RDFSResource $type
	 * @param RDFSClass $class
	 * @param int $start
	 * @param int $count
	 * @param int $erg
	 * @return
	 **/
	public function listTypes($type=NULL,$class=NULL,$start=0,$count=0,$erg=0) {
		return $this->findNodes(NULL,'rdf:type',$type,$class,$start,$count,&$erg);
	}
	
	/**
	 * This method searches for rdf:type instances of a specific type or of all types if no type is given.
	 * You can set the optional parameter to 'class' or 'property' if you want such objects to be returned.
	 *
	 * @param RDFSResource/null $type Indicates whether to return only rdf:type instances of the given type.
	 * @param int/null $offset An optional offset.
	 * @param int/null $limit An optional limit.
	 * @return mixed[] Returns an array that holds RFDSResource/BlankNode/RDFSClass/RDFSProperty objects
	 */
	public function listRDFTypeInstances($type = null, $offset = null, $limit = null) {
		
		return $this->findNodes(null, 'rdf:type', $type, null, $offset, $limit);
	}
	
	/**
	 * This method searches for rdf:type instances of a specific type or of all types if no type is given.
	 * You can set the optional parameter to 'class' or 'property' if you want such objects to be returned.
	 *
	 * @param RDFSResource/null $type Indicates whether to return only rdf:type instances of the given type.
	 * @param string $class Indicates whether to return specific objects, e.g. 'class' or 'property'.
	 * @param int/null $offset An optional offset.
	 * @param int/null $limit An optional limit.
	 * @return mixed[] Returns an array that holds RFDSResource/BlankNode/RDFSClass/RDFSProperty objects
	 */
	public function listRDFTypeInstancesAs($type = null, $class, $offset = null, $limit = null) {
		
		return $this->findNodes(null, 'rdf:type', $type, $class, $offset, $limit);
	}
	
	/**
	 * Returns array of all named classes in this model.
	 *
	 * @return RDFSClass[] Returns an array of RDFSClass objects.
	 */
	public function listClasses() {
		
		$ret=array();
		foreach($this->vocabulary['Class'] as $class)
			$ret=array_merge($ret,$this->findNodes(NULL,'rdf:type',$class,'Class'));
		return $ret;
	}
	
	/**
     * Returns a list with classes that are not part of a rdfs:subClassOf relation (top-classes).
     *
     * @param boolean $systemClasses Indicates whether system-classes (classes with rdf, rdfs or owl namespace)
     * should be returned or not. (default: false)
     * @param boolean $emptyClasses Indicates whether empty classes (classes that do not have any instances 
     * and which subclasses do not have instances, too) should be returned or not. (default: false)
     * @param boolean $implicitClasses Indicates whether classes that are inferred (classes, which have no explicit
     * definition, but which are the domain of at least one instance) should be returned or not. (default: false)
     * @return RDFSClass[]/OWLClass[] Returns an array of either RDFSClass objects or OWLClass objects.
     */
	abstract public function listTopClasses($systemClasses = false, $emptyClasses = false, $implicitClasses = false); 
	
	/**
	 * Returns an array containing the label-languages of all classes in the model that have a label (distinct).
	 *
	 * @return string[] Returns an array containing label-languages.
	 */
	abstract public function listClassLabelLanguages();
	
	/**
	 * Adds a named class description node with the given URI to the model and returns an instance of RDFSClass or OWLClass
	 * that represents this named class.
	 *
	 * @deprecated Use addNamedClass instead.
	 * @param string $uri
	 * @return RDFSClass/OWLClass Returns an instance of either RDFSClass or OWLClass.
	 */
	public function addClass($uri) {
		
		return $this->addNamedClass($uri);
		
		$cl=$this->vocabulary['Class'];
		$this->add($uri,'rdf:type',current($cl));
		return new $this->vclass($uri,$this);
	}
	
	/**
	 * Adds a named class description node with the given URI to the model and returns an instance of RDFSClass or OWLClass
	 * that represents this named class.
	 *
	 * @param string $uri
	 * @return RDFSClass/OWLClass Returns an instance of either RDFSClass or OWLClass.
	 */
	public function addNamedClass($uri) {
		
		$cl = $this->vocabulary['Class'];
		$this->add($uri, 'rdf:type', current($cl));
		
		return new $this->classF($uri);
	}
	
	/**
	 * Adds an anonymous class description to the model an returns an instance of RDFSClass or OWLClass that represents
	 * this anonymous class.
	 *
	 * @return RDFSClass/OWLClass Returns an instance of either RDFSClass or OWLClass.
	 */
	public function addAnonymousClass() {
		
		$bNode=new BlankNode($this->getUniqueResourceURI(BNODE_PREFIX));
		$this->add($bNode,'rdf:type',current($this->vocabulary['Class']));
		return new $this->vclass($bNode->getURI(),$this);
	}
	
	/**
	 * Return a RDFSClass object corresponding to the URI or false if such one does not exist.
	 *
	 * @param string/Resource $uri
	 * @return RDFSClass/false The class or false if the class does not exist.
	 */
	public function getClass($uri) {
		
		$uri=is_a($uri,'Resource')?$uri->getURI():$uri;
		if($uri)
		foreach($this->vocabulary['Class'] as $class) {
			$cl=$this->find($uri,'rdf:type',$class);
			if($cl->triples)
				return new $this->vclass($uri,$this);
		}
		return false;
	}
	
	/**
	 * Adds a new property to the model and returns an instance of RDFSProperty or OWLProperty.
	 *
	 * @param string $uri
	 * @return RDFSProperty/OWLProperty Returns an instance of either RDFSProperty or OWLProperty.
	 */
	public function addProperty($uri) {
		
		reset($this->vocabulary['Property']);
		$this->add($uri,'rdf:type',current($this->vocabulary['Property']));
		return new $this->property($uri,$this);
	}
	
	/**
	 * Returns a RDFSProperty object corresponding to the URI or false if such one does not exist.
	 *
	 * @param string $uri
	 * @return RDFSProperty/false The property or false if the class does not exist.
	 */
	public function getProperty($uri) {
		
		$uri=is_a($uri,'Resource')?$uri->getURI():$uri;
		if($uri)
		foreach($this->vocabulary['Property'] as $property) {
			$cl=$this->find($uri, 'rdf:type', $property);
			if($cl->triples)
				return new $this->property($uri,$this);
		}
		return false;
	}
	
	/**
	 * Adds a new instance to the model and returns an instance of RDFSInstance or OWLInstance.
	 *
	 * @param string $uri
	 * @param string $class
	 * @return RDFSInstance The instance created.
	 */
	public function addInstance($uri, $class) {
		
		$this->add($uri,'rdf:type',$class);
		return $this->instanceF($uri);
	}
	
	/**
	 * Returns a RDFSInstance object corresponding to the URI or false if such one does not exist.
	 *
	 * @param string $uri
	 * @return RDFSInstance/false The property or false if the class does not exist.
	 */
	public function getInstance($uri) {
		
		foreach(array_keys($this->findNodes($uri,'rdf:type',NULL)) as $class) {
			if(array_intersect(array_keys($this->findNodes($class,'rdf:type',NULL)),array_keys($this->vocabulary['Class'])))
				return new $this->instance($uri,$this);
		}
		return false;
	}
	
	/**
	 * Returns a RDFSClass, RDFSProperty or RDFSInstance object corresponding to the URI or 
	 * if there is not matching statement (in the given order...).
	 *
	 * @param string $uri
	 * @return RDFSClass/RDFSProperty/RDFDSInstance/false The class, property, instance or 
	 * false if the class does not exist.
	 */
	public function getResource($uri) {
		
		if(!$ret=$this->getClass($uri))
			if(!$ret=$this->getProperty($uri))
				$ret=$this->getInstance($uri);
		return $ret;
	}
	
	/**
	 * Lists all instances of any class in the model.
	 *
	 * @return RDFSInstance[] Returns an array of RDFSInstance instances in the model.
	 */
	abstract public function listInstances($start = 0, $erg = 0, $end = 0);
	
	/**
	 * Returns all properties (RDFSProperty, OWL_ObjectProperties, OWL_DatatypeProperties and OWL_AnnotationProperties) 
	 * of the model.
	 *
	 * @return RDFSProperty[] Returns an array of RDFSProperty objects.
	 */
	public function listProperties() {
		
		if(method_exists($this, 'listObjectProperties')) {
			return array_merge(
				$this->listRDFTypeInstancesAs('rdfs:Property', 'property'),
				$this->listObjectProperties(),
				$this->listDatatypeProperties(),
				$this->listAnnotationProperties()
			);
		} else return $this->listRDFTypeInstancesAs('rdfs:Property', 'property');
	}
	
	/**
	 * Returns an array of all properties not being sub-properties of any other property in this model.
	 *
	 * @return RDFSProperty[] Returns an array of RDFSProperty objects.
	 */
	public function listTopProperties() {
		
		$properties = $this->listProperties();
		$topprop = array();
		
		foreach ($properties as $prop) {
			$toAdd=true;
			foreach($prop->listSuperProperties() as $superprop)
				if($this->findStatement($superprop, null, null)) $toAdd=false;
			if ($toAdd)
				$topprop[$prop->getLocalName()] = $this->propertyF($prop);
		}
		
		return $topprop;
	}
	
	/**
	 * Returns an array of all annotation properties in this model.
	 *
	 * @param boolean $includePredefined Indicates whether predefined annotation properties should be included.
	 * @return RDFSProperty[] Returns an array of all annotation properties in this model.
	 */
	public function listAnnotationProperties($includePredefined = false) {
		
		$ret=$this->listTypes($GLOBALS['OWL_AnnotationProperty'],'RDFSProperty');
		if($includePredefined)
			$ret=array_merge($ret,array(
				$GLOBALS['RDFS_isDefinedBy']->getURI()=>$GLOBALS['RDFS_isDefinedBy'],
				$GLOBALS['RDFS_seeAlso']->getURI()=>$GLOBALS['RDFS_seeAlso'],
				$GLOBALS['OWL_versionInfo']->getURI()=>$GLOBALS['OWL_versionInfo']));
		return $ret;
	}
	
	/**
	 * Returns an array of all annotation properties in this model belonging to rdfs:Class or owl:Class.
	 *
	 * @return RDFSProperty[] Returns an array of annotation properties in this model.
	 */
	abstract public function listClassAnnotationProperties();
	
	/**
	 * Method to search for triples in the RDFSModel.
	 * null input for any parameter will match anything.
	 * Example: $result = $m->find(null, null, $node); -> Finds all triples with $node as object.
	 *
	 * @abstract Can't use abstract construct, for this is inherited from RAP DbModel -> Implement this for a
	 * specific backend.
	 * @param RDFSResource/null $s Subject
	 * @param RDFSResource/null $p Predicate
	 * @param RDFSResource/null $o Object
	 * @param int $start Return results starting with this row number.
	 * @param int $count Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 *
	 * @return MemModel.
	 */
	public function find($s, $p, $o, $start = 0, $count = 0, $erg = 0) { /* abstract */ }
	
/* ------------------------------------------------------------------------------- */
// TODO findAsMemModel, findAsStatement, findAs...
	
		
	/**
	 * Returns the first statements of this model matching the parameters.
	 *
	 * @param RDFSResource_or_NULL $s Subject
	 * @param RDFSResource_or_NULL $p Predicate
	 * @param RDFSResource_or_NULL $o Object
	 *
	 * @return Array of RDFSInstance objects.
	 */
	function findStatement($s,$p,$o) {
		$stms=$this->findStatements($s,$p,$o,0,1);
		return array_shift($stms);
	}
	/**
	 * Returns the statements of this model matching the parameters.
	 *
	 * @param RDFSResource_or_NULL $s Subject
	 * @param RDFSResource_or_NULL $p Predicate
	 * @param RDFSResource_or_NULL $o Object
	 * @param int $start Return results starting with this row number.
	 * @param int $count Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 *
	 * @return array Array of RDFSInstance objects.
	 **/
	function findStatements($s,$p,$o,$start=0,$count=0,$erg=0) {
		$find=$this->find($s,$p,$o,$start,$count,&$erg);
		return $find->triples;
	}
	
	/**
	 * @deprecated use findSubjectsForPredicateAs instead
	 */
	function findSubjects($predicate,$class='Resource',$start=0,$count=0,$erg=0) {
		$sql='SELECT subject,subject_is FROM statements
			WHERE modelID IN ('.$this->getModelIds().') AND predicate="'.$this->_dbId($predicate).'"
			GROUP BY subject';
		return $this->_convertRecordSetToNodeList($sql,$class,$start,$count,&$erg);
	}
	
	/**
	 *
	 * 
	 * @param string/RDFSResource $predicate
	 * @param string/null $class
	 * @param int/null $offset
	 * @param int/null $limit
	 */
	public function findSubjectsForPredicateAs($predicate, $class = null, $offset = null, $limit = null) {
// TODO handle offset and limit
// TODO check whether to use a generic method for such cases instead of direct sparql
// TODO add a class parameter to sparqlQuery method
return $this->findSubjects($predicate, $class);

		if (!$predicate instanceof RDFSResource) $predicate = $this->resourceF($predicate);

		$sparql = 'SELECT DISTINCT ?subject
				   WHERE { ?subject <' . $predicate->getURI() . '> ?object } ';
				
		return $this->sparqlQuery($sparql, $class);
	}
	
	
	function findObjects($predicate,$class='Resource',$start=0,$count=0,$erg=0) {
		$sql="SELECT object,object_is FROM statements
			WHERE modelID IN (".$this->getModelIds().') AND predicate="'.$this->_dbId($predicate).'"
			GROUP BY object';
		return $this->_convertRecordSetToNodeList($sql,$class,$start,$count,&$erg);
	}
	function findPredicates($subject=NULL,$object=NULL) {
		$sql="SELECT predicate FROM statements WHERE modelID IN (".$this->getModelIds().')';
		$sql.=$this->_createDynSqlPart_SPO($subject, $predicate, $object).(!$count?" GROUP BY predicate":'');
		return $this->_convertRecordSetToNodeList($sql);
	}
	/**
	 * Exactly one of the parameters $subject, $predicate or $object must be NULL.
	 * This method then returns the node at this position of the first matching statement.
	 *
	 * @param RDFSResource_or_NULL $subject Subject
	 * @param RDFSResource_or_NULL $predicate Predicate
	 * @param RDFSResource_or_NULL $object Object
	 * @param string $class	PHPClass which the returned nodes should be instances of.
	 *
	 * @return Nodel
	 **/
	function findNode($subject,$predicate,$object,$class=NULL) {
		$ret=$this->findNodes($subject,$predicate,$object,$class,0,1);
		return array_shift($ret);
	}
	/**
	 * Exactly one of the parameters $subject, $predicate or $object must be NULL.
	 * This method then returns an array of all nodes at this position of matching statements.
	 *
	 * @param RDFSResource_or_NULL $subject Subject
	 * @param RDFSResource_or_NULL $predicate Predicate
	 * @param RDFSResource_or_NULL $object Object
	 * @param string $class	PHPClass which the returned nodes should be instances of.
	 * @param int $start Return results starting with this row number.
	 * @param int $count Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 * @return array Array of nodes (RDFSResources or Literals).
	 **/
	function findNodes($subject,$predicate,$object,$class=NULL,$start=0,$count=0,$erg=0) {
		/*
		$sparql = 'SELECT ?x WHERE { ';
		
		if ($subject == null) {
			$sparql .= ' ?x ';
			if ($predicate == null) $sparql .= '?y ';
			else {
				if (!($predicate instanceof Node)) $predicate = $this->resourceF($predicate);
				$sparql .= '<' . $predicate->getURI() . '> ';
			}
			if ($object == null) $sparql .= '?z }';
			else {
				if (!($object instanceof Node)) $object = $this->resourceF($object);
				if ($object->isBlankNode()) $object = new BlankNode($object->getURI());
				$sparql .= '<' . $object->getURI() . '> }';
			}	
		} else if ($predicate == null) {
			if (!($subject instanceof Node)) $subject = $this->resourceF($subject);
			if ($subject->isBlankNode()) $subject = new BlankNode($subject->getURI());
			$sparql .= ' <' . $subject->getURI() . '> ?x ';
			
			if ($object == null) $sparql .= '?z }';
			else {
				if (!($object instanceof Node)) $object = $this->resourceF($object);
				if ($object->isBlankNode()) $object = new BlankNode($object->getURI());
				$sparql .= '<' . $object->getURI() . '> }';
			}	 
		} else if ($object == null) {
			
			if (!($subject instanceof Node)) $subject = $this->resourceF($subject);
			if ($subject->isBlankNode()) $subject = new BlankNode($subject->getURI());
			if (!($predicate instanceof Node)) $predicate = $this->resourceF($predicate);
			
			$sparql .= ' <' . $subject->getURI() . '> <'. $predicate->getURI() . '> ?x }';
			
		} else return false;
		
		$renderer = new Erfurt_Sparql_ResultRenderer_Array($this, $class);
		$result = $this->sparqlQuery($sparql, $renderer);
		return $result;
		*/
		
		if($class=='Class')
			$class=$this->vclass;
		else if($class=='Property')
			$class=$this->property;
		$res=$this->find($subject,$predicate,$object,$start,$count,&$erg);
		$ret=array();
		foreach($res->triples as $triple) {
			if(is_null($subject))
				$r=$triple->subj;
			else if(is_null($predicate))
				$r=$triple->pred;
			else if(is_null($object))
				$r=$triple->obj;
			if(is_a($r,'Resource') && !is_a($r,'Blanknode'))
				$r=new $this->resource($r->getURI(),$this);
			$uri=(is_a($r,'Resource')?$r->getLocalName():'"'.$r->getLabel().'"@'.$r->getLanguage().'^^'.$r->getDatatype());
			$ret[$uri]=($class && class_exists($class) && method_exists($r,'getURI')?new $class($r->getURI(),$this):$r);
			if(is_a($r,'Blanknode') && $class && class_exists($class) && method_exists($r,'getURI'))
				$ret[$uri]->uri=$uri;
		}
		return $ret;
	}
	
	
	
	/**
	 * Return an array of individuals in the model. If an array properties of
	 * PropertyURI=>Value mappings is given, only individuals with the specified
	 * property values will be returned.
	 *
	 * @param array $properties Array of PropertyURI=>Value pairs.
	 * @param string $compare Comparision method to be used - default is exact match.
	 * @param int $start Return results starting with this row number.
	 * @param int $count Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 *
	 * @return Array of RDFSInstance objects.
	 **/
	function _findInstances($types,$properties=array(),$compare='exact',$start=0,$count=0,$erg=0) {
		$args=func_get_args();
		$cache=new stmCache('_findInstances',$args,$this);
		if($cache->value!==NULL) {
			$erg=$cache->value[0];
			return $this->_convertRecordSetToNodeList($cache->value[1],$this->instance);
		}

		$ret=array();

		$sql='SELECT s.subject,s.subject_is FROM statements s';
		$n=0;
		if($properties['localName']) {
			$where.=' AND s.subject LIKE "'.$properties['localName'].'%"';
			unset($properties['localName']);
		}
		if($properties)
		foreach($properties as $property=>$value) {
			$prop=$this->resourceF($property);
			$sql.=($value?' INNER ':' LEFT ');
			$n++;
			if(!$value)
				$cond='1';
			else if($compare=='exact')
				$cond="(s$n.object='".$this->_dbId($value)."' OR s$n.object='".$value."')";
			else if($compare=='starts')
				$cond="s$n.object LIKE '$value%'";
			else if($compare=='contains')
				$cond="s$n.object LIKE '%$value%'";
			else if($compare=='regex')
				$cond="s$n.object REGEXP '$value'";
			else if($compare=='empty')
				$cond="ISNULL(s$n.object)";

			$sql.='JOIN statements s'.$n." ON(s.modelID=s$n.modelID AND s.subject=s$n.subject AND s$n.predicate='".$this->_dbId($prop)."' AND $cond)";
			if(!$value)
				$where.=" AND ISNULL(s$n.object)";
		}
#print_r($types);
		$sql.=' WHERE s.modelID IN ('.$this->getModelIds().') AND
			s.predicate=\''.$this->_dbId('RDF_type').'\' AND s.object '."$types".
			(!empty($where)?$where:'').' GROUP BY s.subject';
#print_r($sql);
#exit;
		if($count)
			$res=&$this->dbConn->PageExecute($sql,$count,$start/$count+1);
		else
			$res=&$this->dbConn->execute($sql);

		$erg=$res->_maxRecordCount?$res->_maxRecordCount:$res->_numOfRows;

		$resarr=$res->getArray();
		$c=array($erg,$resarr);
		$cache->set($c,array_merge(array('rdf:type'),array_keys($properties)));
		$ret=$this->_convertRecordSetToNodeList($resarr,$this->instance);



		return $ret;
	}
	function findInstances($properties=array(),$compare='exact',$start=0,$count=0,$erg=0) {
		return $this->_findInstances(' NOT IN (\''.join('\',\'',array_keys(array_merge(array('http://www.w3.org/2002/07/owl#Restriction'=>''),$this->vocabulary['Class'],$this->vocabulary['Property']))).'\')',$properties,$compare,$start,$count,&$erg);
	}
	/**
	 * Adds an RDF list to the model
	 *
	 * @param array $members Array of list members to be added.
	 *
	 * @return
	 **/
	function addList($symbols,$literals=true) {
		if(!is_array($symbols))
			return false;
		$symbols=array_values(array_filter($symbols));
		$oneOf=new Blanknode($this->getUniqueResourceURI(BNODE_PREFIX));
		$rest=$oneOf;
		foreach($symbols as $symbol) {
			if($literals)
				$obj=new Literal($symbol);
			else
				$obj=new $this->resource($symbol,$this);
			$this->add($rest,$GLOBALS['RDF_first'],$obj);
			$restn=(($symbol==$symbols[count($symbols)-1])?$GLOBALS['RDF_nil']:new Blanknode($this->getUniqueResourceURI(BNODE_PREFIX)));
			$this->add($rest,$GLOBALS['RDF_rest'],$restn);
			$rest=$restn;
		}
		return $oneOf;
	}
	/**
	 * TODO: Beschreibung und return
	 *
	 * @param RDFResource $oneOf
	 *
	 * @return array
	 **/
	function getOneOf($oneOf) {
		return $this->getList(parray_shift($this->findNodes($oneOf,$GLOBALS['OWL_oneOf'],NULL)));
	}
	/**
	 * Returns RDF list members as an array
	 *
	 * @param Resource $rest The resource or resource URI representing the list.
	 *
	 * @return array Array of list members.
	 **/
	function getList($rest,$class=NULL) {
		if(!is_a($rest,'Resource') || $rest->getURI()==$GLOBALS['RDF_nil']->getURI())
			return array();
		if($class=='Class')
			$class=$this->vclass;
		else if($class=='Property')
			$class=$this->property;

		$sql="SELECT s1.object,s1.object_is,s3.object,s3.object_is,s4.object,s4.object_is
				FROM statements s1
				LEFT JOIN statements s2 ON(s1.modelID=s2.modelID AND s2.subject=s1.subject AND s2.predicate='".$this->_dbId('RDF_rest')."')
				LEFT JOIN statements s3 ON(s1.modelID=s3.modelID AND s3.subject=s2.object AND s3.predicate='".$this->_dbId('RDF_first')."')
				LEFT JOIN statements s4 ON(s1.modelID=s4.modelID AND s4.subject=s2.object AND s4.predicate='".$this->_dbId('RDF_rest')."')
			WHERE
				s1.subject='".$this->_dbId($rest)."' AND s1.predicate='".$this->_dbId('RDF_first')."'
				AND s1.modelID IN (".$this->getModelIds().')';
#echo $sql;
		$ret=array();
		$row=$this->dbConn->getRow($sql);
		if($row)
		for($i=0;$i<6;$i+=2) {
			if(Zend_Registry::get('config')->database->backend=='powl' && $row[$i+1]=='r') {
				$n=$this->_getNodeById($row[$i]);
				$row[$i]=$n->getURI();
				$row[$i+1]=isBNode($n)?'b':$row[$i+1];
			}
			if($row[$i+1]=='l')
				$ret[$row[$i]]=new RDFSLiteral($row[$i]);
			else if($row[$i+1]=='r' && $row[$i]!=$GLOBALS['RDF_nil']->getURI()) {
				$r=($class && class_exists($class)?new $class($row[$i],$this):new $this->resource($row[$i],$this));
				$ret[$r->getLocalName()]=$class=='Plain'?$r->getLocalName():$r;
			} else if($row[$i]) {
				$member=$row[$i+1]=='b'?($class && class_exists($class)?new $class($row[$i],$this):new BlankNode($row[$i])):new $this->resource($row[$i],$this);
				if($row[$i+1]=='b') // Blanknodes have empty namespace
					$member->uri=$row[$i];
				$list=$this->getList($member,$class);
				if($list)
					$ret=array_merge($ret,$list);
				else if($row[$i]!=$GLOBALS['RDF_nil']->getURI())
					array_push($ret,$member);
			}
		}
		return $ret;
/*		return array_merge(
			$this->findNodes($rest,$GLOBALS['RDF_first'],NULL,$class),
			$this->getList(parray_shift($this->findNodes($rest,$GLOBALS['RDF_rest'],NULL)),$class)
		);*/
	}
	/**
	 * Returns the number of classes in this model.
	 *
	 * @param boolean $includeImports Count classes in imported models as well.
	 * @return int Number of classes in this model.
	 **/
	function countClasses($includeImports=true) {
		return count($this->listClasses());
	}
	/**
	 * Returns the number of instances in this model.
	 *
	 * @param boolean $includeImports Count instances in imported models as well.
	 * @return int Number of instances in this model.
	 **/
	function countInstances($includeImports=true) {
		$clsql='';
		foreach($this->vocabulary['Class'] as $cl)
			$clsql.="OR s1.object='".$cl->getURI()."'";
		$sql="SELECT COUNT(s1.modelID) FROM
				statements s1 INNER JOIN statements s2
					ON((s1.modelID=s2.modelID".(!empty($this->importsIds)?" OR s1.modelID IN (".$this->getModelIds().')':'').")
						AND s1.predicate='".$this->_dbId('RDF_type')."'
						AND (1=0 $clsql)
						AND s2.predicate='".$this->_dbId('RDF_type')."'
						AND s2.object=s1.subject
					)
			WHERE s2.modelID IN (".($includeImports?$this->getModelIds():$this->modelID).")";
		return $this->dbConn->getOne($sql);
	}
	/**
	 * Returns the number of properties in this model.
	 *
	 * @param boolean $includeImports Count properties in imported models as well.
	 * @return int Number of properties in this model.
	 **/
	function countProperties($includeImports=true) {
		return count($this->listProperties());
	}
	/**
	 * Returns the number of triples/statements in this model.
	 *
	 * @param boolean $includeImports Count triples in imported models as well.
	 * @return int Number of triples in this model.
	 **/
	function countTriples($includeImports=true) {
		return $this->dbConn->getOne("SELECT COUNT(modelID) FROM statements
			WHERE modelID IN (".($includeImports?$this->getModelIds():$this->modelID).")");
	}
	/**
	* General method to search for triples in the DbModel.
	* NULL input for any parameter will match anything.
	* Example:  $result = $m->query( NULL, NULL, $node );
	*           Finds all triples with $node as object.
	*
	* @param	object Resource	$subject
	* @param	object Resource	$predicate
	* @param	object Node	$object
	* @return	object ADORecordSet
	* @throws	PhpError
	* @throws  SqlError
	* @access	public
	*/
	function query($subject,$predicate,$object,$start=0,$count='') {
		if(!is_a($subject,'Node') && $subject!=NULL)
			$subject=new $this->resource($subject,$this);
		if(!is_a($predicate,'Node') && $predicate!=NULL)
			$predicate=new $this->resource($predicate,$this);
		if(!is_a($object,'Node') && $object != NULL)
			$object=new $this->resource($object,$this);
		// static part of the sql statement
		$sql="SELECT subject,predicate,object,l_language,l_datatype,subject_is,object_is,id
			FROM statements WHERE modelID IN (".$this->getModelIds().')';
		// dynamic part of the sql statement
		foreach(array('subject','predicate','object') as $o)
			if($$o && method_exists($$o,'isBlankNode') && $$o->isBlankNode())
				$$o=new Blanknode($$o->uri);
		$sql.=$this->_createDynSqlPart_SPO($subject, $predicate, $object).(!$count?" ORDER BY subject, predicate, object":'');
		// execute the query
#if($subject->uri=='bN4500580ac116e3')
#echo($sql);
#exit;
		if($count)
			$recordSet =& $this->dbConn->PageExecute($sql,$count,$start/$count+1);
		else
			$recordSet =& $this->dbConn->execute($sql);
		if (!$recordSet)
			echo $this->dbConn->errorMsg();
		else
			return $recordSet;
	}
	function rdqlQuery($queryString,$returnNodes=TRUE) {
		$args=func_get_args();
		$c=cache('rdqlQuery'.$this->modelURI,$args);
		if($c!==NULL)
			return $c;

		include_once(RDFAPI_INCLUDE_DIR.PACKAGE_RDQL);
		$parser=new RdqlParser();
		$parsedQuery=&$parser->parseQuery($queryString);

		// this method can only query this DbModel
		// if another model was specified in the from clause throw an error
		if (isset($parsedQuery['sources'][0]))
			if($parsedQuery['sources'][0] != $this->modelURI) {
				$errmsg = RDFAPI_ERROR . '(class: DbModel; method: rdqlQuery):';
				$errmsg .= ' this method can only query this DbModel';
				trigger_error($errmsg, E_USER_ERROR);
			}

		$engine=new RdqlDbEngine();
		$engine->parsedQuery=&$parsedQuery;

		$sql=$engine->generateSql($this->getModelIds());
		$recordSet=&$this->dbConn->execute($sql);
        if ($recordSet instanceof ADORecordSet) {
    		$queryResult=$engine->filterQueryResult($recordSet);
        }



		return cache('rdqlQuery'.$this->modelURI,$args,$returnNodes?$engine->toNodes($queryResult):$engine->toString($queryResult));
	}
	/**
	 * Removes all references to a resource from the model.
	 *
	 * @param string $resource The URI of the resource to remove.
	 * @return
	 **/
	function removeResource($resource) {
		if(!is_a($resource,'RDFSResource'))
			$resource=new $this->resource($resource,$this);
		$resource->remove();
	}
	/**
	 * Removes a class (including all references to this class) from the model.
	 *
	 * @param string $uri The URI of the class to remove.
	 * @return
	 **/
	function removeClass($uri) {
		if(is_a($uri,'Resource'))
			$uri=$uri->getURI();
		if($resource=$this->getClass($uri))
			$resource->remove();
		else
			trigger_error(RDFSAPI_ERROR.'(class: RDFSModel; method: removeClass): Class "'.$uri.'" not found.',E_USER_ERROR);
	}
	/**
	 * Removes a property (including all references to this property) from the model.
	 *
	 * @param string $uri The URI of the property to remove.
	 * @return
	 **/
	function removeProperty($uri) {
		if(is_a($uri,'Resource'))
			$uri=$uri->getURI();
		if($resource=$this->getProperty($uri))
			$resource->remove();
		else
			trigger_error(RDFSAPI_ERROR.'(class: RDFSModel; method: removeProperty): Property "'.$uri.'" not found.',E_USER_ERROR);
	}
	/**
	 * Removes an instance (including all references to the instance) from the model.
	 *
	 * @param string $uri The URI of the instance to remove.
	 * @return
	 **/
	function removeInstance($uri) {
		if(is_a($uri,'Resource'))
			$uri=$uri->getURI();
		if($resource=$this->getInstance($uri))
			$resource->remove();
		else
			trigger_error(RDFSAPI_ERROR.'(class: RDFSModel; method: removeInstance): Instance "'.$uri.'" not found.',E_USER_ERROR);
	}
	/**
	* Method to search for triples in the DbModel which match the search
	* string $search according to a certain comparision.
	* Example: $rs=$m->search('Animal',array('Subject','Object'),'contains');
	*          Finds all triples where 'Animal' is contained in
	*          the subject or object.
	*
	* @param	string	$search
	* @param	array	$where	values
	* @param	string	$compare	stating how matching should be performed (maybe on of 'exact', 'contains', 'starts', 'regex').
	* @param	int	$start return triples starting from $start.
	* @param	int	$count return $count triples.
	* @return	object ADORecordSet
	* @throws	PhpError
	* @throws  SqlError
	* @access	public
	*/
	function search($search,$where,$compare,$start=0,$count=0) {
		// dynamic part of the sql statement
		foreach($where as $whe)
			if($compare=='starts')
				$w[]="$whe like '$search%'";
			else if($compare=='contains')
				$w[]="$whe like '%$search%'";
			else if($compare=='regex')
				$w[]="$whe rlike '$search'";
			else {
				if($whe!='object') {
					$r=new $this->resource($search,$this);
					$w[]="$whe='".$this->_dbId($r)."'";
				} else
					$w[]="$whe='$search'";
			}
		// static part of the sql statement
		$sql="SELECT subject,predicate,object,l_language,l_datatype,subject_is,object_is
			FROM statements WHERE modelID IN (".$this->getModelIds().") AND (".join(' OR ',$w).')';
		$recordSet=$count?$this->dbConn->PageExecute($sql,$count,$start/$count+1):$this->dbConn->execute($sql);

		if(!$recordSet)
			echo $this->dbConn->errorMsg();
		else
			return $recordSet;
	}
	/**
	 * Convert an ADORecordSet to an array of RDFS Resources or Literals.
	 *
	 * Every successful database query returns an ADORecordSet object which is actually
	 * a cursor that holds the current row in the array fields[].
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * !!! This method can only be applied to a RecordSet with array fields[]
	 * !!! containing at least two elements:
	 * !!! [0] - resource
	 * !!! [1] - resource type, i.e. 'r' for resource, 'b' for blank node, 'l' for literals
	 * !!! [2] - l_language
	 * !!! [3] - l_datatype
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 *
	 * @param   object  ADORecordSet
	 * @return  array  Array of RDFSResources
	 * @access	private
	 */
	function _convertRecordSetToNodeList(&$recordSet,$class='RDFSResource',$start=0,$count=100000,$erg=0)  {
		if(is_string($recordSet)) {
			if($count)
				$recordSet=$this->dbConn->PageExecute($recordSet,$count,$start/$count+1);
			else
				$recordSet=$this->dbConn->execute($recordSet);
			$erg=$recordSet->_maxRecordCount?$recordSet->_maxRecordCount:$recordSet->_numOfRows;
		}
		if(is_a($recordSet,'ADORecordSet'))
			$recordSet=$recordSet->getArray();
		$ret=array();
		foreach($recordSet as $fields) {
			if($fields[1]=='l')
				$res=new RDFSLiteral($fields[0],$fields[2],$fields[3]);
			else if($fields[1]=='b' && !$class)
				$res=new BlankNode($fields[0]);
			else if($class) {
				if($class=='Resource')
					$res=$this->resourceF($fields[0]);
				else if($class=='Class')
					$res=$this->classF($fields[0]);
				else if($class=='Property')
					$res=$this->propertyF($fields[0]);
				else if($class=='Instance')
					$res=$this->instanceF($fields[0]);
				else
					$res=new $class($fields[0],$this);
				if($fields[1]=='b')
					$res->uri=$fields[0];
			} else
				$res=$this->resourceF($fields[0]);
			if(method_exists($res,'getLocalName') && $res->getLocalName())
				$ret[$res->getLocalName()]=$res;
			else
				$ret[]=$res;
		}

		return $ret;
	}
	/**
	 * Convert an ADORecordSet to a memory Model.
	 *
	 * Every successful database query returns an ADORecordSet object which is actually
	 * a cursor that holds the current row in the array fields[].
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * !!! This method can only be applied to a RecordSet with array fields[]
	 * !!! containing a representation of the database table: statements,
	 * !!! with an index corresponding to following table columns:
	 * !!! [0] - subject, [1] - predicate, [2] - object, [3] - l_language,
	 * !!! [4] - l_datatype, [5] - subject_is, [6] - object_is
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 *
	 * @param   object  ADORecordSet
	 * @return  object  MemModel
	 * @access	private
	 */
	function _convertRecordSetToMemModel(&$recordSet)  {
		$res = new MemModel($this->baseURI);
		if($recordSet)
		while (!$recordSet->EOF) {
			if(method_exists($this,'_convertRowToStatement')) {
#				print_r($this);
				$stm=$this->_convertRowToStatement($recordSet->fields);
				$res->add($stm);
			}
			$recordSet->moveNext();
		}
		return $res;
	}
	function _convertRowToStatement($row) {
		$sub=$row[5]=='r'?$this->resourceF($row[0]):new BlankNode($row[0]);
		$pred=$this->resourceF($row[1]);
		// object
		if($row[6]=='l')
			$obj=new RDFSLiteral($row[2],$row[3],$row[4]);
		else if($row[6] == 'b')
			$obj=new BlankNode($row[2]);
		else
			$obj=$this->resourceF($row[2]);
		$stm=new Statement($sub,$pred,$obj);
		$stm->dbId=$row[7];
		return $stm;
	}
	/**
	 * RDFSModel::_getNodeFlag()
	 *
	 * @param $object
	 * @return
	 * @access	private
	 **/
	function _getNodeFlag($object)  {
		return (is_a($object,'BlankNode')||(method_exists($object,'isBlankNode') && $object->isBlankNode()))?'b':(is_a($object,'Resource')?'r':'l');
	}
	/**
	 * RDFSModel::_dbId()
	 *
	 * @param $resource
	 * @return
	 * @access	private
	 **/
	function _dbId($resource) {
		if(is_string($resource))
			$resource=is_a($GLOBALS[$resource],'resource')?$GLOBALS[$resource]:new $this->resource($resource,$this);
		return $resource->getURI();
	}
	function _dbIds($resources) {
		$ret=array();
		foreach($resources as $resource)
			$ret[]=$this->_dbId($resource);
		return $ret;
	}
	/**
	 * Full-text search on the model.
	 *
	 * @param mixed $search Search string.
	 * @param string $type Objects to search for, i.e. Classes, Instances, Properties.
	 * @param integer $start Return resuls from $start.
	 * @param integer $count Return $count results.
	 * @param integer $erg Number of overall matching records will be written to $erg.
	 * @return
	 **/
	function searchFullText($search,$type=NULL,$start=0,$count=10000,$erg=0) {
		$sql='SELECT s.subject,s.predicate,s.object,s.l_language,s.l_datatype,s.subject_is,s.object_is,MATCH('.(is_string($type)?'subject':'s.object').') AGAINST (\''.$search.'\' /*!40001 IN BOOLEAN MODE */) AS score FROM statements s
			'.(is_array($type)?'INNER JOIN statements s1 ON(s.modelID=s1.modelID AND s.subject=s1.subject AND s1.predicate="'.$this->_dbId('RDF_type').'" AND s1.object IN ("'.join('","',$type).'"))':'').'
			WHERE MATCH('.(is_string($type)?'subject':'s.object').') AGAINST (\''.$search.'\' /*!40001 IN BOOLEAN MODE */) AND s.modelID IN ('.$this->getModelIds().')'.
			(is_string($type)?' AND object_is=\'r\'':' AND s.object_is=\'l\'');
		if($type=='Classes')
			$sql.=' AND predicate=\''.$this->_dbId('RDF_type').'\' AND object IN (\''.join('\',\'',array_keys($this->vocabulary['Class'])).'\')';
		else if($type=='Properties')
			$sql.=' AND predicate=\''.$this->_dbId('RDF_type').'\' AND object IN (\''.join('\',\'',array_keys($this->vocabulary['Property'])).'\')';
		else if($type=='Instances')
			$sql.=' AND predicate=\''.$this->_dbId('RDF_type').'\' AND object NOT IN (\''.join('\',\'',array_keys(array_merge($this->vocabulary['Class'],$this->vocabulary['Property']))).'\')';
#	print_r($sql);
#	exit;
		$rs=$this->dbConn->PageExecute($sql,$count,$start/$count+1);
		$erg=$rs->_maxRecordCount?$rs->_maxRecordCount:$rs->_numOfRows;
		return $rs;
	}
	
	
	/**
	 * Return a statement from a ADORecordSet resulting from a
	 * query to the statement table.
	 *
	 * @param   object  ADORecordSet
	 * @return  object  Statement
	 * @access	private
	 */
	function fetchStatementFromRecordSet(&$recordSet)  {
		if($recordSet->EOF)
			return false;
		// subject
		$sub=$recordSet->fields[5] == 'r'?new $this->resource($recordSet->fields[0],$this):new BlankNode($recordSet->fields[0]);
		// predicate
		$pred=new $this->resource($recordSet->fields[1],$this);
		// object
		if ($recordSet->fields[6]=='r')
			$obj=new $this->resource($recordSet->fields[2],$this);
		else if($recordSet->fields[6]=='b')
			$obj=new BlankNode($recordSet->fields[2]);
		else {
			$obj=new Literal($recordSet->fields[2], $recordSet->fields[3]);
			if($recordSet->fields[4])
				$obj->setDatatype($recordSet->fields[4]);
		}
		$recordSet->moveNext();

		return new Statement($sub,$pred,$obj);
	}
	
	/**
	 * Starts a new logging action, all subsequent adds and removes of statements
	 * to the model will be related to this action until the method "logEnd" is called.
	 *
	 * @param $action
	 * @param string $subject
	 * @param string $details
	 * @return
	 **/
	function logStart($action,$subject='',$details='') {
		if(!$this->logEnabled())
			return;
		if(!$descrId=$this->dbConn->getOne("SELECT id FROM log_action_descr WHERE description='$action'")) {
			$this->dbConn->execute("INSERT INTO log_action_descr VALUES (NULL,'$action');");
			$descrId=$this->dbConn->Insert_ID();
		}
		$this->dbConn->execute("INSERT INTO log_actions VALUES (NULL,".(!empty($this->logActions[0])?$this->logActions[0]:'NULL').",{$this->modelID},'".(empty($_SESSION['PWL']['user'])?'':$_SESSION['PWL']['user'])."',".$this->dbConn->sysTimeStamp.",'$descrId','$subject','$details');");
		$actionId=$this->dbConn->Insert_ID();
		array_unshift($this->logActions,$actionId);
		$this->dbConn->StartTrans();
		return $actionId;
	}
	
	
	/**
	 * Finishes the last logging action.
	 *
	 * @return
	 **/
	function logEnd() {
		if(!$this->logEnabled())
			return;
		array_shift($this->logActions);
		$this->dbConn->CompleteTrans();
	}
	
	
	/**
	 * Writes the adding of the given statement to the log.
	 *
	 * @param $statement The statement whichs removel should be logged.
	 * @return
	 **/
	function logAdd($statement) {
		$this->log($statement,'a');
	}
	
	
	/**
	 * Writes the removal of the given statement to the log.
	 *
	 * @param $statement The statement whichs removel should be logged.
	 * @return
	 **/
	function logRemove($statement) {
		$this->log($statement,'r');
	}
	/**
	 * Helper function for logging statement add or removes.
	 *
	 * @param $statement
	 * @param $ar
	 * @return
	 * @access	private
	 **/
	function log($statement,$ar) {
		if(!$this->logEnabled())
			return;
		if(!empty($this->logActions))
			$actionId=$this->logActions[0];
		else {
			$actionId=$this->logStart('Statement '.($ar=='a'?'added':'removed'));
			$this->logEnd();
		}
		if(!method_exists($statement,'subject'))
		$subject_is=$this->_getNodeFlag($statement->subject());
		$sql="INSERT INTO log_statements VALUES (NULL,'".$statement->getLabelSubject()."','".$statement->getLabelPredicate()."',";
		if(is_a($statement->object(), 'Literal')) {
			$quotedLiteral = $this->dbConn->qstr($statement->obj->getLabel());
			$sql.=$quotedLiteral.",'".$statement->obj->getLanguage()."','".$statement->obj->getDatatype()."',"
				."'".$subject_is ."','l','$ar','$actionId')";
		} else {
			$object_is=$this->_getNodeFlag($statement->object());
			$sql.="'" .$statement->obj->getLabel()."','','','" .$subject_is."','".$object_is ."','$ar','$actionId')";
		}
		$rs=&$this->dbConn->execute($sql);
		if(!$rs)
			$this->dbConn->errorMsg();
	}
	
	
	/**
	 * Returns true if logging is enabled for the model/store false otherwise.
	 *
	 * @return boolean True if logging is enabled for the model/store false otherwise.
	 **/
	function logEnabled() {
		return (empty(Zend_Registry::get('config')->logging) || Zend_Registry::get('config')->logging) && empty($this->logDisabled) && in_array((empty(Zend_Registry::get('config')->database->tablePrefix) ? '' : Zend_Registry::get('config')->database->tablePrefix).'log_action_descr',$this->dbConn->MetaTables())?true:false;
	}
	
	
	function renameNamespace($fromNS,$toNS) {
		$this->dbConn->execute("UPDATE statements SET
			subject=REPLACE(subject,'$fromNS','$toNS'),predicate=REPLACE(predicate,'$fromNS','$toNS'),object=REPLACE(object,'$fromNS','$toNS')
			WHERE modelID='{$this->modelID}'");
	}
	
	
	function removeDuplicateStatements() {
/*		$res=$this->dbConn->execute('SELECT s1.id,s2.id FROM statements s1 INNER JOIN statements s2 USING(modelID,subject,predicate,object,object_is) WHERE modelID="'.$this->modelID.'"');
		while($row=$res->FetchRow()) {
			if($row[0]>$row[1])
			$res=$this->dbConn->execute('DELETE FROM statements WHERE id="'.$row[0].'"');
		}*/
		$res=$this->dbConn->execute('SELECT * FROM statements WHERE modelID IN ('.$this->getModelIds().')');
		while($row=$res->FetchRow()) {
			$hash=md5(serialize($row));
			if($exists[$hash])
				$this->dbConn->execute('DELETE FROM statements WHERE modelID="'.$row[0].'" AND subject="'.$row[1].'" AND predicate="'.$row[2].'" AND object="'.$row[3].'" AND object_is="'.$row[4].'" LIMIT 1');
			else
				$exists[$hash]=true;
		}

	}
	/**
	 * Lt all rdf:lists in the model
	 *
	 * @return
	 **/
	function listLists() {
		$sql='SELECT s1.subject,s2.subject FROM statements s1
				LEFT JOIN statements s2 ON(s1.modelID=s2.modelID AND s1.subject=s2.object AND s2.predicate="'.$this->_dbId('rdf:rest').'")
			WHERE s1.predicate="'.$this->_dbId('rdf:first').'"
				AND s1.modelID IN ('.$this->getModelIds().') HAVING ISNULL(s2.subject)';
		$res=$this->dbConn->execute($sql);
		$ret = $this->_convertRecordSetToNodeList($res);


		return $ret;
	}
	
	/**
	 * get the edit permission
	 */
	public function isEditable() {
		return $this->_isEditable;
	}
	
	/**
	 * set the edit permission
	 */
	public function setEdititable($e) {
		$this->_isEditable = $e;
	}
} 
?>