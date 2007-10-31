<?php
// TODO throw an error on calling methods that are marked as abstract via @abstract.
/**
 * DefaultRDFSModel
 *
 * @package rdfsapi
 * @author soa
 * @copyright Copyright (c) 2006
 * @version $Id: model.php 982 2007-05-14 14:09:12Z cweiske $
 */
abstract class Erfurt_Rdfs_Model_Abstract extends DbModel {
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
	function __construct($store,$modelURI,$type=NULL) {
		if(!$store->modelExists($modelURI))
			return FALSE;

		$this->dbConn 	=& $store->dbConn;
		$this->store 	=& $store;
		$this->modelURI = $modelURI;
		$this->type=$type?$type:$this->getType();
		$this->resource='RDFSResource';
		$this->vclass=($this->type=='OWL'?'Erfurt_Owl_':'RDFS').'Class';
		$this->property=($this->type=='OWL'?'Erfurt_Owl_':'RDFS').'Property';
		$this->instance=($this->type=='OWL'?'Erfurt_Owl_':'RDFS').'Instance';
		$this->asResource = $this->resourceF($this->modelURI);
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
	public function literalF($label, $language = '', $datatype = '') {
		
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
		
		return '"' . $literal->getLabel() . '"@' . $literal->getLanguage() . '^^' . $literal->getDatatype();
	}
	
	/**
	 * Returns a uniq string for a node, which can be used for indexing arrays of nodes.
	 *
	 * @param node $node
	 * @return string
	 **/
	public function getNodeId($node) {
		
		return ($node instanceof Resource)?$node->getLocalName():$this->getLiteralId($node);
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
		
		$uri=($uri instanceof Resource)?$uri->getURI():$uri;
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
		
		$uri=($uri instanceof Resource)?$uri->getURI():$uri;
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
				return $this->instanceF($uri);
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
	 * Returns this model as an Erfurt_Rdfs_Resource object
	 */
	public function getAsResource() {
		
		return $this->asResource;
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
// TODO check whether rdf:Property or rdfs:Property ???
		if(method_exists($this, 'listObjectProperties')) {
			return array_merge(
				$this->listRDFTypeInstancesAs('rdf:Property', 'property'),
				$this->listObjectProperties(),
				$this->listDatatypeProperties(),
				$this->listAnnotationProperties()
			);
		} else return $this->listRDFTypeInstancesAs('rdf:Property', 'property');
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
	 * @deprecated Use findAsMemModel instead.
	 */
	public function find($s, $p, $o, $start = 0, $count = 0, $erg = 0) { 
	
		return $this->findAsMemModel($s, $p, $o, $start, $count, &$erg);
	}
	
	/**
	 * Method to search for triples in the RDFSModel.
	 * null input for any parameter will match anything.
	 * Example: $result = $m->find(null, null, $node); -> Finds all triples with $node as object.
	 *
	 * @param RDFSResource/null $s Subject
	 * @param RDFSResource/null $p Predicate
	 * @param RDFSResource/null $o Object
	 * @param int $offset Return results starting with this row number.
	 * @param int $limit Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 *
	 * @return MemModel
	 */
	abstract public function findAsMemModel($s, $p, $o, $offset = 0, $limit = 0, $erg = 0);
	
	/**
	 * @deprecated Use findFirstAsStatement instead.
	 */
	public function findStatement($s, $p, $o) {
		
		return $this->findFirstAsStatement($s, $p, $o);
	}
	
	/**
	 * Returns the first statements of this model matching the parameters.
	 *
	 * @param RDFSResource/null $s Subject
	 * @param RDFSResource/null $p Predicate
	 * @param RDFSResource/null $o Object
	 *
	 * @return Statement Returns an Statement object.
	 */
	public function findFirstAsStatement($s, $p, $o) {
		
		$stms = $this->findStatements($s, $p, $o, 0, 1);
		return array_shift($stms);
	}
	
	/**
	 * @deprecated Use findAsStatementArray instead.
	 */
	public function findStatements($s,$p,$o,$start=0,$count=0,$erg=0) {
		
		return $this->findAsStatementArray($s, $p, $o, $start, $count, &$erg);
	}
	
	/**
	 * Returns the statements of this model matching the parameters.
	 *
	 * @param RDFSResource/null $s Subject
	 * @param RDFSResource/null $p Predicate
	 * @param RDFSResource/null $o Object
	 * @param int $offset Return results starting with this row number.
	 * @param int $limit Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 *
	 * @return Statement[] Returns an array of Statement objects.
	 */
	public function findAsStatementArray($s, $p, $o, $offset = 0, $limit = 0, $erg = 0) {
		
		$find = $this->find($s, $p, $o, $offset, $limit, &$erg);
		return $find->triples;
	}
	
	/**
	 * @deprecated Use findSubjectsForPredicateAs instead.
	 */
	public function findSubjects($predicate, $class = 'resource', $start = 0, $count = 0, $erg = 0) {
		
		return $this->findSubjectsForPredicateAs($predicate, $class, $start, $count, &$erg);
	}
	
	/**
	 * This method returns a list of matching subjects for a given predicate.
	 * 
	 * @param string/RDFSResource $predicate
	 * @param string/null $class
	 * @param int/null $offset
	 * @param int/null $limit
	 * @param int/null $erg Variable passed by reference which will be set to the overall number of records.
	 * @return RDFSResource[] Returns an array of RDFSResource objects or of one of its subclasses (when $class parameter
	 * is given).
	 */
	abstract public function findSubjectsForPredicateAs($predicate, $class = 'resource', $offset = 0, $limit = 0, $erg = 0);
	
	/**
	 * @deprecated Use findObjectsForPredicateAs instead.
	 */
	public function findObjects($predicate, $class = 'resource', $start = 0, $count = 0, $erg = 0) {
		
		return $this->findObjectsForPredicateAs($predicate, $class, $start, $count, &$erg);
	}	
	
	/**
	 * This method returns a list of matching objects for a given predicate.
	 * 
	 * @param string/RDFSResource $predicate
	 * @param string/null $class
	 * @param int/null $offset
	 * @param int/null $limit
	 * @param int/null $erg Variable passed by reference which will be set to the overall number of records.
	 * @return RDFSResource[] Returns an array of RDFSResource objects or of one of its subclasses (when $class parameter
	 * is given).
	 */
	abstract public function findObjectsForPredicateAs($predicate, $class = 'resource', $offset = 0, $limit = 0, $erg = 0);
	
	/**
	 * Returns a list containing resources that act as a predicate in at least one statement belonging to this model.
	 * The result is restricted by the optional parameters $subject and/or $object. In case none of them is given, all
	 * resources that act as predicate in the model are returned. The result is a unique list.
	 *
	 * @param RDFSResource/string/null $subject
	 * @param RDFSResource/Literal/string/null $object
	 * @return RDFSResource[]
	 */
	abstract public function findPredicates($subject = null, $object = null);
	
	/**
	 * @deprecated Use findFirstNodeAs instead.
	 */
	public function findNode($subject, $predicate, $object, $class = 'resource') {
		
		return $this->findFirstNodeAs($subject, $predicate, $object, $class);
	}
	
	/**
	 * Exactly one of the parameters $subject, $predicate or $object must be null.
	 * This method returns the node (where the parameter is null) of the first matching statement, if there
	 * is at least one matching statement.
	 *
	 * @param RDFSResource/null $subject Subject
	 * @param RDFSResource/null $predicate Predicate
	 * @param RDFSResource/null $object Object
	 * @param string $class	PHPClass which the returned nodes should be instances of.
	 * @return RDFSResource/Literal
	 */
	public function findFirstNodeAs($subject, $predicate, $object, $class = 'resource') {
		
		$ret = $this->findNodes($subject, $predicate, $object, $class, 0, 1);
		
		return array_shift($ret);
	}
	
	/**
	 * @deprecated Use findNodesAs instead.
	 */
	public function findNodes($subject, $predicate, $object, $class = null, $start = 0, $count = 0, $erg = 0) {
		
		return $this->findNodesAs($subject, $predicate, $object, $class, $start, $count, &$erg);
	}
	
	/**
	 * Exactly one of the parameters $subject, $predicate or $object must be NULL.
	 * This method returns a list of nodes of all matching statements, if there
	 * is at least one matching statement. Whether the node represents the subject, predicate or object node depends
	 * one the parameter, which is null.
	 *
	 * @param RDFSResource/null $subject Subject
	 * @param RDFSResource/null $predicate Predicate
	 * @param RDFSResource/nukk $object Object
	 * @param string $class	PHPClass which the returned nodes should be instances of.
	 * @param int $offset Return results starting with this row number.
	 * @param int $limit Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 * @return Node[] Array of nodes (RDFSResources or Literals).
	 */
	public function findNodesAs($subject, $predicate, $object, $class = 'resource', $offset = 0, $limit = 0, $erg = 0) {
// TODO Sparqlize
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

		$class = strtolower($class);
		
		if (($class === 'owlclass') || ($class === 'rdfsclass')) {
			$class = 'class';
		} else if (($class === 'owlproperty') || ($class === 'rdfsproperty')) {
			$class = 'property';
		} else if (($class === 'owlinstance') || ($class === 'rdfsinstance')) {
			$class = 'instance';
		}
			
		$res = $this->findAsMemModel($subject, $predicate, $object, $offset, $limit, &$erg);
		$ret = array();
						
		foreach ($res->triples as $triple) {
			if (is_null($subject)) {
				$r = $triple->subj;
			} else if (is_null($predicate)) {
				$r = $triple->pred;
			} else if (is_null($object)) {
				$r = $triple->obj;
			}
			
			if (($r instanceof Resource) && !($r instanceof BlankNode)) {
				$r = $this->resourceF($r, false);
				$uri = $r->getLocalName();
			} else if ($r instanceof Literal) {
				#$r = $this->literalF($r);
				$uri = $this->getLiteralId($r);
				#echo $uri.'->'.$r;
			} else if ($r instanceof BlankNode) {
				$uri = $r->getLocalName();
			}

			if (($r instanceof RDFSResource) || ($r instanceof BlankNode)) {
				switch ($class) {
					case 'resource':
						$ret[$uri] = $r;
						break;
					case 'class':
						$ret[$uri] = $this->classF($r, false);
						break;
					case 'property':
						$ret[$uri] = $this->propertyF($r, false);
						break;
					case 'instance':
						$ret[$uri] = $this->instanceF($r, false);
						break;
					default:
						$ret[$uri] = $r;
						break;
				}
			} else {
				$ret[$uri] = $r;
			} 

			if ($r instanceof BlankNode) $ret[$uri]->uri = $uri;
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
	
	/**
	 * This method returns an array of individuals in the model. If an associative array of properties is given,
	 * where the key is the URI of the property and the value is a certain value for the property to look for, only matching
	 * individuals will be returned. The way this method searches can be changed by passing the $compare paramter. This
	 * parameter must have exact one of the following values:
	 * 			
	 *		'exact' 	=> The object of the statement must be exactly the value of the property.
	 *		'starts' 	=> The object of the statement must start with the value of the property.
	 *		'contains' 	=> The object of the statement must contain the value of the property.
	 *		'regex' 	=> The object of the statement must match the value of the property, this means the value of the property
	 *				   	   has to be a regular expression.
	 *		'empty' 	=> The object of the statement must not be set.
	 * 
	 * @param string[] $properties An associative array of properties, where the key is the property URI and the value is set
	 * according to the $compare paramter.
	 * @param string $compare One of 'exact', 'starts', 'contains', 'regex' and 'empty'. 
	 * @param int $offset Return results starting with this row number.
	 * @param int $limit Maximum number of records to return.
	 * @param int $erg Variable passed by reference which will be set to the overall number of records.
	 */
	abstract public function findInstances($properties = array(), $compare = 'exact', $offset = 0, $limit = 0, $erg = 0);
	
	/**
	 * Adds an RDF list to the model, where $symbols is an array containing the values for the list. If the $literals parameter
	 * is set to true, the list items are literals, else resources. By default the list items are literals. The method returns
	 * the an identifier for the added list.
	 *
	 * @param string[]/Literal[]/Resource[] $members An array of list members to be added.
	 * @param boolean $literals An boolean value that indicates, whether the list members are literals. This paramtere is true
	 * by default.
	 * @return BlankNode Returns an identifier for the list.
	 */
	public function addList($members, $literals = true) {
		
		if (!is_array($members)) {
			return false;
		}
			
		$members = array_values(array_filter($members));
		$oneOf = new Blanknode($this->getUniqueResourceURI(EF_BNODE_PREFIX));
		$rest = $oneOf;
		
		foreach ($members as $member) {
			if($literals) {
				$obj = $this->literalF($member);
			} else {
				$obj = $this->resourceF($member);
			}
				
			$this->add($rest, EF_RDF_FIRST, $obj);
			
			if ($member == $members[count($members)-1]) {
				$this->add($rest, EF_RDF_REST, EF_RDF_NIL);
			} else {
				$bn = new BlankNode($this->getUniqueResourceURI(EF_BNODE_PREFIX));
				$this->add($rest, EF_RDF_REST, $bn);
				$rest = $bn;
			}
		}
		
		return $oneOf;
	}
	
	/**
	 * This method returns an array of values, where the given resource has a owl:oneOf relationship with.
	 * This is usually a list, so all list items are returned.
	 *
	 * @param Resource/string $oneOf The URI of the resource that identifies the owl:oneOf relationship
	 * @return RDFSResource Returns an array of resources.
	 */
	public function getOneOf($oneOf) {
		
		return $this->getList($this->findFirstNodeAs($oneOf, EF_OWL_ONEOF, null));
	}
	
	/**
	 * @deprecated Use getListAs() instead.
	 */
	public function getList($id_or_rest, $class = null) {
		
		return $this->getListAs($id_or_rest, $class);
	}
	
	/**
	 * Returns the members of an RDF list as an array.
	 *
	 * @param Resource/string $id_or_rest The resource or resource URI representing the list, or the rest of a list.
	 * @return RDFSResource Returns an array of list members.
	 */
	abstract public function getListAs($id_or_rest, $class = null);
	
	/**
	 * Returns the number of classes in this model.
	 *
	 * @param boolean $includeImports Count classes in imported models as well.
	 * @return int Number of classes in this model.
	 */
	public function countClasses($includeImports = true) {
		
		return count($this->listClasses());
	}
	
	/**
	 * Returns the number of instances in this model.
	 *
	 * @param boolean $includeImports Count instances in imported models as well.
	 * @return int Number of instances in this model.
	 */
	public function countInstances($includeImports = true) {
		
		return count($this->listInstances());
	}
	
	/**
	 * Returns the number of properties in this model.
	 *
	 * @param boolean $includeImports Count properties in imported models as well.
	 * @return int Number of properties in this model.
	 */
	public function countProperties($includeImports = true) {
		
		return count($this->listProperties());
	}
	
	/**
	 * Returns the number of triples/statements in this model.
	 *
	 * @param boolean $includeImports Count triples in imported models as well.
	 * @return int Number of triples in this model.
	 */
	public function countTriples($includeImports = true) {
		
		return count($this->findAsStatementArray(null, null, null));
	}
		
	/**
	 * Removes all references to a resource from the model.
	 *
	 * @param Resource/string $resource The URI of the resource to remove.
	 */
	public function removeResource($resource) {
		
		if (!($resource instanceof RDFSResource)) {
			$resource = $this->resourceF($resource);
		}
			
		$resource->remove();
	}
	
	/**
	 * Removes a class (including all references to this class) from the model.
	 *
	 * @param Resource/string $uri The URI of the class to remove.
	 */
	public function removeClass($uri) {
		
		if ($uri instanceof Resource) {
			$uri = $uri->getURI();
		}
	
		if ($resource = $this->getClass($uri)) {
			$resource->remove();
		} else {
			trigger_error(RDFSAPI_ERROR.'(class: RDFSModel; method: removeClass): Class "'.$uri.'" not found.',E_USER_ERROR);
		}
			
	}
	
	/**
	 * Removes a property (including all references to this property) from the model.
	 *
	 * @param Resource/string $uri The URI of the property to remove.
	 */
	public function removeProperty($uri) {
		
		if ($uri instanceof Resource) {
			$uri = $uri->getURI();
		}
		
		if ($resource = $this->getProperty($uri)) {
			$resource->remove();
		} else {
			trigger_error(RDFSAPI_ERROR.'(class: RDFSModel; method: removeProperty): Property "'.$uri.'" not found.',E_USER_ERROR);
		}
	}
	
	/**
	 * Removes an instance (including all references to the instance) from the model.
	 *
	 * @param Resource/string $uri The URI of the instance to remove.
	 */
	public function removeInstance($uri) {
		
		if ($uri instanceof Resource) {
			$uri = $uri->getURI();
		}
		
		if ($resource = $this->getInstance($uri)) {
			$resource->remove();
		} else {
			trigger_error(RDFSAPI_ERROR.'(class: RDFSModel; method: removeInstance): Instance "'.$uri.'" not found.',E_USER_ERROR);
		}	
	}
	
	/**
	 * Method that executes an RDQL query.
	 *
	 * @abstract Can't use abstract construct, for this is inherited from RAP DbModel -> Implement this for a
	 * specific backend.
	 *
	 * @param string $queryString
	 * @param boolean $returnNodes
	 * @return string/Node[] Returns an array of Nodes (by default) or optional a string containing the result.
	 */
	public function rdqlQuery($queryString, $returnNodes = true) { /* abstract */ }
	
	/**
	 * Method to search for triples in the DbModel which match the search string $search according to a certain comparision.
	 *
	 * Example: $rs = $m->search('Animal', array('Subject', 'Object'), 'contains');
	 *          Finds all triples where 'Animal' is contained in
	 *          the subject or object.
	 *
	 * @param string $search
	 * @param string[] $where
	 * @param string $compare Stating how matching should be performed (must be one of: 'exact', 'contains', 'starts', 'regex').
	 * @param int $offset Return triples starting from $offset.
	 * @param int $limit Return max. $limit triples.
	 * @throws	PhpError
	 * @throws  SqlError
	 * @return	object ADORecordSet
	 */
// TODO check whethter ADORecordSet as result is ok.
	abstract public function search($search,$where,$compare,$offset=0,$limit=0);
	
	/**
	 * Full-text search on the model.
	 *
	 * @param string $search Search string.
	 * @param string $type Objects to search for, i.e. Classes, Instances, Properties.
	 * @param int $offset Return resuls from $start.
	 * @param int $limit Return $count results.
	 * @param int $erg Number of overall matching records will be written to $erg (passed by reference).
	 * @return
	 */
	abstract public function searchFullText($search, $type = null, $offset = 0, $limit = 10000, $erg = 0);
	
	/**
	 * Starts a new logging action, all subsequent adds and removes of statements
	 * to the model will be related to this action until the method "logEnd" is called.
	 *
	 * @param string $action Description of the action.
	 * @param string $subject
	 * @param string $details
	 * @return int Returns the id for this new action.
	 */
	abstract public function logStart($action, $subject = '', $details = '');
	
	/**
	 * Finishes the last logging action.
	 */
	abstract public function logEnd();
	
	/**
	 * Writes the adding of the given statement to the log.
	 *
	 * @param Statement $statement The statement whichs adding should be logged.
	 */
	public function logAdd($statement) {
		
		$this->log($statement, 'a');
	}
	
	/**
	 * Writes the removal of the given statement to the log.
	 *
	 * @param Statement $statement The statement whichs removal should be logged.
	 */
	public function logRemove($statement) {
		
		$this->log($statement, 'r');
	}
	
	/**
	 * Returns true iff logging is enabled for the model/store; false otherwise.
	 *
	 * @return boolean True iff logging is enabled for the model/store; false otherwise.
	 */
	abstract public function logEnabled();
	
	/**
	 * Renames the namespace of every matching statement (has $fromNS as namespace) in this model with the new namespace ($toNs).
	 * This method only operated on the triples of the model. 
	 *
	 * @param string $fromNS The old namespace.
	 * @param string $toNS The new namespace.
	 */
	abstract public function renameNamespace($fromNS, $toNS);
	
	/**
	 * Removes all statements in this model, that are duplicated.
	 */
	abstract public function removeDuplicateStatements();
	
	/**
	 * Lists all rdf:lists in the model.
	 *
	 * @return Resource[] Returns a list of list identifiers.
	 */
	abstract public function listLists();
	
	/**
	 * get the edit permission
	 *
	 * @return boolean
	 */
	public function isEditable() {
		
		return $this->_isEditable;
	}
	
	/**
	 * set the edit permission
	 *
	 * @param boolean $e
	 */
	public function setEdititable($e) {
		
		$this->_isEditable = $e;
	}
	
	public function getStore() {
		return $this->store;
	}
	
	/**
	 * This method makes a diff with the two given (json) models and updates this model
	 *
	 * @param string $origModelJson the (json) model before modification
	 * @param string $modifiedModelJson the (json) modek after modification
	 */
	public function updateFromJsonModels($origModelJson, $modifiedModelJson) {
		
		// workaround, for it is not possible to determine whether json is corrupt or empty with json_decode
		if ($origModelJson === '') {
			$origModel = array();
		} else {
			$origModel = json_decode($origModelJson, true);
		}
		
		if ($modifiedModelJson === '') {
			$modModel = array();
		} else {
			$modModel = json_decode($modifiedModelJson, true);
		}
		
		// throws an excpetion if one of the json models was corrupt
		if (!is_array($origModel)) {
// TODO exception code
			throw new Erfurt_Exception('Error in first model');
		}
		
		if (!is_array($modModel)) {
// TODO exception code
			throw new Erfurt_Exception('Error in second model');
		}
		
		$addModel = new MemModel();
		$removeModel = new MemModel();
		
		foreach ($origModel as $subject=>$rest) {
			foreach ($rest as $predicate=>$object) {
				$s = (strpos($subject, '_') === 0) ? new BlankNode(substr($subject, 2)) : new Resource($subject);
				$p = new Resource($predicate);
				
				if ($object['type'] === 'uri') {
					$o = new Resource($object['value'])
				} else if ($object['type'] === 'bnode') {
					$o = new BlankNode(substr($object['value'], 2));
				} else {
					$dtype = (isset($object['datatype'])) ? $object['datatype'] : '';
					$lang = (isset($object['lang'])) ? $object['lang'] : '';
					
					$o = new Literal($object['value'], $lang);
					$o->setDatatype($dtype);
				}
				
				$removeModel->add(new Statement($s, $p, $o));
			}
		}
		
		foreach ($modModel as $subject=>$rest) {
			foreach ($rest as $predicate=>$object) {
				$s = (strpos($subject, '_') === 0) ? new BlankNode(substr($subject, 2)) : new Resource($subject);
				$p = new Resource($predicate);
				
				if ($object['type'] === 'uri') {
					$o = new Resource($object['value'])
				} else if ($object['type'] === 'bnode') {
					$o = new BlankNode(substr($object['value'], 2));
				} else {
					$dtype = (isset($object['datatype'])) ? $object['datatype'] : '';
					$lang = (isset($object['lang'])) ? $object['lang'] : '';
					
					$o = new Literal($object['value'], $lang);
					$o->setDatatype($dtype);
				}
				
				$addModel->add(new Statement($s, $p, $o));
			}
		}
		
		$this->addStatementArray($addModel->subtract($removeModel)->triples, true, false);
		$success = $this->removeStatementArray($removeModel->subtract($addModel)->triples, false, true);
		
		if (success == true) {
// TODO exception code 
			throw new Erfurt_Exception('successfully updated the model');
		} else {
// TODO exception code
			throw new Erfurt_Exception('error while updating the model');
		}
		
	}
} 
?>
