<?php
/**
 * @package   store
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author    Norman Heino <norman.heino@gmail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id$
 */
class Erfurt_Store
{   
    // ------------------------------------------------------------------------
    // --- Public constants ---------------------------------------------------
    // ------------------------------------------------------------------------
    
    const TYPE_LITERAL   = 1;
    const TYPE_IRI       = 2;
    const TYPE_BLANKNODE = 3;
    
    const COUNT_NOT_SUPPORTED = -1;
    
    const MAX_ITERATIONS = 100;
    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Username of the super user who gets unrestricted access
     * @var string
     */
    protected $_dbUser = null;
    
    /**
     * Password of the super user who gets unrestricted access
     * @var string
     */
    protected $_dbPass = null;
    
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Access control instance
     * @var Erfurt_Ac_Default
     */
    private $_ac = null;
    
    /**
     * The name of the backend adapter instance in use.
     * @var string
     */
    private $_backendName = null;
    
    /**
     * The backend adapter instance in use.
     * @var Erfurt_Store_Backend_Adapter_Interface
     */
    private $_backendAdapter = null;
    
    /**
     * Optional methods a backend adapter can implement
     * @var array
     */
    private $_optionalMethods = array(
        'countWhereMatches'
    );
    
    /**
     * Number of queries committed
     * @var int
     */
    private static $_queryCount = 0;
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Constructor method.
     * 
     * @param string $backend virtuoso, mysqli, adodb, redland
     * @param array $backendOptions
     * @param string/null $schema rap 
     * 
     * @throws Erfurt_Exception Throws an exception if store is not supported or store does not implement the store     
     * adapter interface.
     */
    public function __construct($backend, array $backendOptions = array(), $schema = null)
    {
        // store connection settings for super admin id
        if (array_key_exists('username', $backendOptions)) {
            $this->_dbUser = $backendOptions['username'];
        }
        if (array_key_exists('password', $backendOptions)) {
            $this->_dbPass = $backendOptions['password'];
        }
        
        if ($schema !== null) {
            $schemaName = ucfirst($schema);
        } else {
            $schemaName = '';
        }
        
        if ($backend === 'zenddb') {
            $this->_backendName = 'ZendDb';
            
            // Used Ef schema as default for the ZendDb backend
            if (null === $schema) {
                $schemaName = 'Ef';
            }
        } else {
            $this->_backendName = ucfirst($backend);
        }
        
        $fileName   = 'Store/Adapter/' 
                    . $schemaName 
                    . $this->_backendName 
                    . '.php';
        
        $className  = 'Erfurt_Store_Adapter_' 
                    . $schemaName 
                    . $this->_backendName;
        
        // import backend adapter file
        if (is_readable((EF_BASE . $fileName))) {
            require_once $fileName;
        } else {
            require_once 'Erfurt/Exception.php';
            $msg = "Backend '$this->_backendName' " 
                 . ($schema ? "with schema '$schemaName'" : "") 
                 . " not supported. No suitable backend adapter found.";
            throw new Erfurt_Exception($msg);
        }
        
        // check class exsitence
        if (!class_exists($className)) {
            require_once 'Erfurt/Exception.php';
            $msg = "Backend '$this->_backendName' " 
                 . ($schema ? "with schema '$schemaName'" : "") 
                 . " not supported. No suitable backend adapter class found.";
            throw new Erfurt_Exception($msg);
        }
        
        // instantiate backend adapter
        $this->_backendAdapter = new $className($backendOptions);
        
        // check interface conformance
        if (!($this->_backendAdapter instanceof Erfurt_Store_Adapter_Interface)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Adpater class must implement Erfurt_Store_Adapter_Interface.');
        }
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Adds statements in an array to the graph specified by $graphIri.
     *
     * @param string $graphIri
     * @param array  $statementsArray
     * 
     * @throws Erfurt_Exception
     */
    public function addMultipleStatements($graphUri, array $statementsArray, $useAc = true)
    {
        // check whether model is available
        if (!$this->isModelAvailable($graphUri, $useAc)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Model is not available.');
        }
        
        // check whether model is editable
        if (!$this->_checkAc($graphUri, 'edit', $useAc)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('No permissions to edit model.');
        }
        
        $this->_backendAdapter->addMultipleStatements($graphUri, $statementsArray);
        
        require_once 'Erfurt/Event/Dispatcher.php';
        require_once 'Erfurt/Event.php';
        $event = new Erfurt_Event('onAddMultipleStatements');
        $event->graphUri   = $graphUri; 
        $event->statements = $statementsArray;
        
        Erfurt_Event_Dispatcher::getInstance()->trigger($event);
    }
    
    /**
     * Adds a statement to the graph specified by $modelIri.
     * @param string $graphUri
     * @param string $subject (IRI or blank node)
     * @param string $predicate (IRI, no blank node!)
     * @param string $object (IRI, blank node or literal)
     * @param array $options An array containing two keys 'subject_type' and 'object_type'. The value of each is
     * one of the defined constants of Erfurt_Store: TYPE_IRI, TYPE_BLANKNODE and TYPE_LITERAL. In addtion to this
     * two keys the options array can contain two keys 'literal_language' and 'literal_datatype', but only in case
     * the object of the statement is a literal.
     * 
     * @throws Erfurt_Exception Throws an exception if adding of statements fails.
     */
    public function addStatement($graphUri, $subject, $predicate, $object, $options = array(), $useAcl = true)
    {        
        $options = array_merge(array(
            'subject_type' => Erfurt_Store::TYPE_IRI, 
            'object_type'  => Erfurt_Store::TYPE_IRI
        ), $options);
        
        // check whether model is available
        if ($useAcl && !$this->isModelAvailable($graphUri)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Model is not available.');
        }
        
        // check whether model is editable
        if ($useAcl && !$this->_checkAc($graphUri, 'edit')) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('No permissions to edit model.');
        }
        
       return $this->_backendAdapter->addStatement($graphUri, $subject, $predicate, $object, $options);
        
        require_once 'Erfurt/Event/Dispatcher.php';
        require_once 'Erfurt/Event.php';
        $event = new Erfurt_Event('onAddStatement');
        $event->graphUri   = $graphUri; 
        $event->subject = $subject;
        $event->predicate = $predicate;
        $event->object = $object;
        Erfurt_Event_Dispatcher::getInstance()->trigger($event);
    }
    
// TODO Remove the following method... not necessary...
    /**
     * @param string $modelIri
     * @param Erfurt_Rdf_Resource $subject (IRI or blank node)
     * @param Erfurt_Rdf_Resource $predicate (IRI, no blank node!)
     * @param Erfurt_Rdf_Node $object (IRI, blank node or literal)
     * 
     * @throws Erfurt_Exception Throws an exception if predicate $p is a blank node or if addition of statements
     * fails.
     */
    public function addStatementFromObjects($modelIri, Erfurt_Rdf_Resource $subject, Erfurt_Rdf_Resource $predicate, Erfurt_Rdf_Node $object)
    {
        if ($predicate->isBlankNode()) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Predicate must not be a blank node.');
        }
        
        // TODO: why getting labels here?
        $s = $subject->getLabel();
        $p = $predicate->getLabel();
        $o = $object->getLabel();
        
        $options = array();
        $options['subject_type'] = ($subject->isBlankNode()) ? self::TYPE_BLANKNODE : self::TYPE_IRI;
        $options['object_type'] = ($object instanceof Erfurt_Rdf_Literal) ? self::TYPE_LITERAL : 
                        ($object->isBlankNode()) ? self::TYPE_BLANKNODE : self::TYPE_IRI;
                        
        if ($object instanceof Erfurt_Rdf_Literal) {
            $options['literal_language'] = $object->getLanguage();
            $options['literal_datatype'] = $object->getDatatype();
        }
        
        $this->addStatement($modelIri, $s, $p, $o, $options);
    }
    
    /**
     * Checks whether the store has been set up yet and imports system 
     * ontologies if necessary.
     */
    public function checkSetup()
    {
        $config         = Erfurt_App::getInstance()->getConfig();
        $logger         = Erfurt_App::getInstance()->getLog();
        $sysOntSchema   = $config->sysOnt->schemaUri;
        $schemaLocation = $config->sysOnt->schemaLocation;
        $schemaPath     = preg_replace('/[\/\\\\]/', '/', EF_BASE . $config->sysOnt->schemaPath);
        $sysOntModel    = $config->sysOnt->modelUri;
        $modelLocation  = $config->sysOnt->modelLocation;
        $modelPath      = preg_replace('/[\/\\\\]/', '/', EF_BASE . $config->sysOnt->modelPath);
        
        $returnValue = true;
        
        // check for system ontology
        if (!$this->isModelAvailable($sysOntSchema, false)) {
            $logger->info('System schema model not found. Loading model ...');
            
            $this->getNewModel($sysOntSchema, '', 'owl', false);
            require_once 'Erfurt/Syntax/RdfParser.php';
            try {
                if (is_readable($schemaPath)) {
                    // load SysOnt from file
                    $this->importRdf($sysOntSchema, $schemaPath, 'rdfxml', Erfurt_Syntax_RdfParser::LOCATOR_FILE,
                            false);
                } else {
                    // load SysOnt from Web
                    $this->importRdf($sysOntSchema, $schemaLocation, 'rdfxml', Erfurt_Syntax_RdfParser::LOCATOR_URL,
                            false);
                }
            } catch (Erfurt_Exception $e) {
                // Delete the model, for the import failed.
                $this->deleteModel($sysOntSchema, false);
                
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception("Import of '$sysOntSchema' failed.");
            }
            
            if (!$this->isModelAvailable($sysOntSchema, false)) {
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception('Unable to load System Ontology schema.');
            }
            
            $logger->info('System schema successfully loaded.');
            $returnValue = false;
        }

        // check for system configuration model
        if (!$this->isModelAvailable($sysOntModel, false)) {
            $logger->info('System configuration model not found. Loading model ...');
            
            $this->getNewModel($sysOntModel, '', 'owl', false);
            require_once 'Erfurt/Syntax/RdfParser.php';
            try {
                if (is_readable($modelPath)) {
                    // // load SysOnt Model from file
                    $this->importRdf($sysOntModel, $modelPath, 'rdfxml',
                            Erfurt_Syntax_RdfParser::LOCATOR_FILE, false);
                } else {
                    // // load SysOnt Model from Web
                    $this->importRdf($sysOntModel, $modelLocation, 'rdfxml',
                            Erfurt_Syntax_RdfParser::LOCATOR_URL, false);
                }
            } catch (Erfurt_Exception $e) {
                // Delete the model, for the import failed.
                $this->deleteModel($sysOntSchema, false);
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception("Import of '$sysOntModel' failed.");
            }
            
            if (!$this->isModelAvailable($sysOntModel, false)) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Unable to load System Ontology model.');
            }
            
            
            $logger->info('System schema successfully loaded.');
            $returnValue = false;
        }
        
        if ($returnValue === false) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception('One or more system models imported.', 20);
        }
        
        return true;
    }
    
    /**
     * Counts all statements that match the SPARQL graph pattern $whereSpec.
     *
     * @param string $graphUri
     * @param string $whereSpec
     */
    public function countWhereMatches($graphIri, $countSpec, $whereSpec)
	{	    
	    if (method_exists($this->_backendAdapter, 'countWhereMatches')) {
	        if ($this->_checkAc($graphIri)) {
	            $graphIris = array_merge($this->_getImportsClosure($graphIri), array($graphIri));
                return $this->_backendAdapter->countWhereMatches($graphIris, $whereSpec, $countSpec);
	        }
	    }
	    
	    // TODO: is it better to throw an exception in this case?
	    return self::COUNT_NOT_SUPPORTED;
	}
	
	/**
     * Creates the table specified by $tableSpec according to backend-specific 
     * create table statement.
     *
     * @param array $tableSpec An associative array of SQL column names and columnd specs.
     */
	public function createTable($tableName, array $columns)
	{
	    if ($this->_backendAdapter instanceof Erfurt_Store_Sql_Interface) {
	        return $this->_backendAdapter->createTable($tableName, $columns);
	    }
	    
	    // TODO: use default SQL store
	}
    
    /**
     * Deletes all statements that match the triple pattern specified.
     *
     * @param string $modelIri
     * @param mixed triple pattern $subject (string or null)
     * @param mixed triple pattern $predicate (string or null)
     * @param mixed triple pattern $object (string or null)
     * @param array $options An array containing two keys 'subject_type' and 'object_type'. The value of each is
     * one of the defined constants of Erfurt_Store: TYPE_IRI, TYPE_BLANKNODE and TYPE_LITERAL. In addtion to this
     * two keys the options array can contain two keys 'literal_language' and 'literal_datatype'.
     * 
     * @throws Erfurt_Exception
     */
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, $options = array())
    {
        if ($this->_checkAc($graphUri, 'edit')) {
            try {
                $retVal =  $this->_backendAdapter->deleteMatchingStatements(
                $graphUri, $subject, $predicate, $object, $options);
                
                require_once 'Erfurt/Event/Dispatcher.php';
                require_once 'Erfurt/Event.php';
                $event = new Erfurt_Event('onDeleteMatchingStatements');
                $event->graphUri   = $graphUri; 
                $event->statements = $retVal;
                Erfurt_Event_Dispatcher::getInstance()->trigger($event);
            } catch (Erfurt_Store_Adapter_Exception $e) {
// TODO Create a exception for too many matching values
                // In this case we log without storing the payload. No rollback supported for such actions.
                require_once 'Erfurt/Event/Dispatcher.php';
                require_once 'Erfurt/Event.php';
                $event = new Erfurt_Event('onDeleteMatchingStatements');
                $event->graphUri = $graphUri; 
                $event->resource = $subject; 
                Erfurt_Event_Dispatcher::getInstance()->trigger($event);
            }
        }
    }
    
    /**
     * Deletes statements in an array from the graph specified by $graphIri.
     *
     * @param string $graphIri
     * @param array  $statementsArray
     * 
     * @throws Erfurt_Exception
     */
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {
        // check whether model is available
        if (!$this->isModelAvailable($graphUri)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Model is not available.');
        }
        
        // check whether model is editable
        if (!$this->_checkAc($graphUri, 'edit')) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('No permissions to edit model.');
        }
        
        $this->_backendAdapter->deleteMultipleStatements($graphUri, $statementsArray);
        
        require_once 'Erfurt/Event/Dispatcher.php';
        require_once 'Erfurt/Event.php';
        $event = new Erfurt_Event('onDeleteMultipleStatements');
        $event->graphUri   = $graphUri; 
        $event->statements = $statementsArray;
        Erfurt_Event_Dispatcher::getInstance()->trigger($event);
    }
    
    /**
     * @param string $modelIri The Iri, which identifies the model.
     * @param boolean $useAc Whether to use access control or not.
     * 
     * @throws Erfurt_Exception Throws an exception if no permission, model not existing or deletion fails.
     */
    public function deleteModel($modelIri, $useAc = true)
    {
        // check whether model is available
        if (!$this->isModelAvailable($modelIri, $useAc)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("Model <$modelIri> is not available and therefore not removable.");
        }
        
        // check whether model editing is allowed
        if (!$this->_checkAc($modelIri, 'edit', $useAc)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("No permissions to delete model <$modelIri>.");
        }
        
        // delete model
        $this->_backendAdapter->deleteModel($modelIri);
        
        // remove any statements about deleted model from SysOnt
        if (Erfurt_App::getInstance()->getAcModel() !== false) {
            $acModelIri = Erfurt_App::getInstance()->getAcModel()->getModelIri();
            
            // Only do that, if the deleted model was not one of the sys models
            $config = Erfurt_App::getInstance()->getConfig();
            if (($modelIri !== $config->sysont->model) && ($modelIri !== $config->sysont->schema)) {
                $this->_backendAdapter->deleteMatchingStatements($acModelIri, null, null, $modelIri);
                $this->_backendAdapter->deleteMatchingStatements($acModelIri, $modelIri, null, null);
            }
        }
    }
    
    /**
     * 
     * @param string $modelIri
     * @param string $serializationType One of:
     *                                          - 'xml'
     *                                          - 'n3' or 'nt'
     * @param mixed $filename Either a string containing a absolute filename or null. In case null is given,
     * this method returns a string containing the serialization.
     * 
     * @return string/null
     */
    public function exportRdf($modelIri, $serializationType = 'xml', $filename = null)
    {
        $serializationType = strtolower($serializationType);
        
        // check whether model is available
        if (!$this->isModelAvailable($modelIri)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("Model <$modelIri> cannot be exported. Model is not available.");
        }
        
        if (in_array($serializationType, $this->_backendAdapter->getSupportedExportFormats())) {
            return $this->_backendAdapter->exportRdf($modelIri, $serializationType, $filename);
        } else {
            require_once 'Erfurt/Syntax/RdfSerializer.php';
            $serializer = Erfurt_Syntax_RdfSerializer::rdfSerializerWithFormat($serializationType);
            
            return $serializer->serializeGraphToString($modelIri);
        }
    }
    
    /**
     * Searches resources that have literal property values matching $stringSpec.
     *
     * @param string $stringSpec The string pattern to be matched
     * @param string|array $graphUris One or more graph URIs to be searched
     * @param array option array
     */
    public function findResourcesWithPropertyValue($stringSpec, $graphUris, $options = array())
    {
        if (empty($graphUris)) {
            $graphUris = array_keys($this->getAvailableModels(true));
        }
        
        $stringSpec = (string) $stringSpec;
        $graphUris  = (array) $graphUris;
        
        $options = array_merge(array(
            'case_sensitive'    => false, 
            'filter_classes'    => false, 
            'filter_properties' => false
        ), $options);
        
        // execute backend-specific search
        if (method_exists($this->_backendAdapter, 'findResourcesWithPropertyValue')) {
            // TODO: add owl:imports'ed graphs
            return $this->_backendAdapter->findResourcesWithPropertyValue($stringSpec, $graphUris, $options);
        }
        
        // generic SPARQL search
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();

        foreach ($graphUris as $graphUri) {
            $query->addFrom($graphUri);
        }

        $query->setProloguePart('SELECT DISTINCT ?s');
        $query->setWherePart('WHERE {
            ?s ?p ?o.
            ' . ($options['filter_properties'] ? '?ss ?s ?oo.' : '') . '
            FILTER (regex(?o, "' . $stringSpec . '"' . ($options['case_sensitive'] ? '' : ', "i"') . '))
        }');

        $resources = array();
        if ($results = $this->sparqlQuery($query)) {
            foreach ($results as $row) {
                array_push($resources, $row['s']);
            }
        }

        return $resources;
    }
    
    /**
     * @param boolean $withTitle Whether to return a human readable title for each available model.
     * @return array Returns an indexed array containing an associative array for each row. Each result row has
     * the following keys:  - 'modelIri'    => Contains the Iri of the model.
     *                      - ('title')     => If the $withTitle parameter is given with true as value, this key
     *                                         contains a human readable title for the model resource, else this key
     *                                         will not be set.
     */
    public function getAvailableModels($withTitle = false)
    {
        // backend adapter returns all models
        $models = $this->_backendAdapter->getAvailableModels($withTitle);
    
        // filter for access control
        foreach ($models as $key => $model) {
            if (!$this->_checkAc($model['modelIri'])) {
                unset($models[$key]);
            }
        }
        
        return $models;
    }
    
    /**
     * Returns the class name of the currently used backend.
     *
     * @return string
     */
    public function getBackendName() {
        return $this->_backendName;
    }
    
    /**
     * Returns the db connection username
     *
     * @return string
     */
    public function getDbUser()
    {
        return $this->_dbUser;
    }
    
    /**
     * Returns the db connection password
     *
     * @return string
     */
    public function getDbPassword()
    {
        return $this->_dbPass;
    }
    
    /**
     * @param string $modelIri The IRI, which identifies the model.
     * @param boolean $useAc Whether to use access control or not.
     * 
     * @throws Erfurt_Exception Throws an exception if model is not available.
     * 
     * @return Erfurt_Rdf_Model Returns an instance of Erfurt_Rdf_Model or one of its subclasses.
     */
    public function getModel($modelIri, $useAc = true)
    {
        // check whether model exists and is visible
        if (!$this->isModelAvailable($modelIri, $useAc)) {
            $config = Erfurt_App::getInstance()->getConfig();
            
            if (!$useAc && (($modelIri === $config->sysont->model) || ($modelIri === $config->sysont->schema))) {
                try {
                    $this->checkSetup();
                } catch (Erfurt_Store_Exception $e) {
                    if ($e->getCode() === 20) {
                        // Everything is fine, sys models now imported
                    } else {
                        require_once 'Erfurt/Store/Exception.php';
                        throw new Erfurt_Store_Exception("Check setup failed.");
                    }
                }
                
                if (!$this->isModelAvailable($modelIri, $useAc)) {
                    require_once 'Erfurt/Store/Exception.php';
                    throw new Erfurt_Store_Exception("Model '$modelIri' is not available.");
                }
            } else {
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception("Model '$modelIri' is not available.");
            }
            
            
        }
        
        $modelInstance = $this->_backendAdapter->getModel($modelIri);
        
        // check for edit possibility
        if ($this->_checkAc($modelIri, 'edit', $useAc)) {
            $modelInstance->setEditable(true);
        } else {
            $modelInstance->setEditable(false);
        }
        
        return $modelInstance;
    }
    
    /**
     * Returns the number fo queries committed.
     *
     * @return int
     */
    public function getQueryCount()
    {
        return self::$_queryCount;
    }
    
    /**
     * Creates a new empty model instance with IRI $modelIri.
      *
     * @param string $modelIri
     * @param string $baseIri
     * @param string $type
     * @param boolean $useAc
     * 
     * @throws Erfurt_Exception
     * 
     * @return Erfurt_Rdf_Model
     */
    public function getNewModel($modelIri, $baseIri = '', $type = 'owl', $useAc = true)
    {
        if ($this->isModelAvailable($modelIri, false)) {
            require_once 'Erfurt/Exception.php';
            
            // if debug mode is enabled create a more detailed exception description. If debug mode is disabled the
            // user should not know why this fails.
            if (defined('_EFDEBUG')) {
                throw new Erfurt_Exception("Failed creating the model. A model with the same URI already exists!");
            } else {
                throw new Erfurt_Exception('Failed creating the model.');
            }   
        }
        
// TODO: check whether user is allowed to create a new model
        
        return $this->_backendAdapter->getNewModel($modelIri, $baseIri, $type);
    }
    
    public function getObjectsInferred($modelUri, $startResources, $objectProperty, $hierarchyProperty = null)
    {
        
    }
    
    /**
     * Calculates the transitive closure for a given property and a set of starting nodes.
     *
     * The inverse mode (which is enabled by default) can be used to calculate the 
     * rdfs:subClassOf closure of a set of starting classes.
     * By default this method uses a private SPARQL implementation to actually query and 
     * calculate the closure. Adapters can (and should!) provide their own implementation.
     *
     * @param string $propertyIri The property's IRI for which hte closure should be calculated
     * @param array $startResources An array of resources as starting nodes
     * @param boolean $inverse Denotes whether the property is inverse, i.e. ?child ?property ?parent
     * @param int $maxDepth The maximum number of iteration steps
     */ 
    public function getTransitiveClosure($modelIri, $property, $startResources, $inverse = true, $maxDepth = self::MAX_ITERATIONS)
    {
        if (method_exists($this->_backendAdapter, 'getTransitiveClosure')) {
            $closure = $this->_backendAdapter->getTransitiveClosure($modelIri, $property, (array) $startResources, $inverse, $maxDepth);
	    } else {
	        $closure = $this->_getTransitiveClosure($modelIri, $property, (array) $startResources, $inverse, $maxDepth);
	    }
	    
	    return $closure;
    }
    
    /**
     * Returns an array of serialization formats that can be exported.
     *
     * @return array
     */
    public function getSupportedExportFormats()
    {
        $supportedFormats = array(
            'rdfxml'    => 'RDF/XML',
            'n3'        => 'Notation 3',
            'rdfjson'   => 'RDF/JSON (Talis)'
        );
        
        return array_merge($supportedFormats, $this->_backendAdapter->getSupportedExportFormats());
    }
    
    /**
     * Returns an array of serialization formats that can be imported.
     *
     * @return array
     */
    public function getSupportedImportFormats()
    {
        $supportedFormats = array(
            'rdfxml'    => 'RDF/XML',
            'n3'        => 'Notation 3',
            'rdfjson'   => 'RDF/JSON (Talis)'
        );
        
        return array_merge($supportedFormats, $this->_backendAdapter->getSupportedImportFormats());
    }
    
    /**
     * 
     * @param string $modelIri
     * @param string $locator Either a URL or a absolute file name.
     * @param string $type One of: 
     *                              - 'auto' => Tries to detect the type automatically in the following order:
     *                                              1. Detect XML by XML-Header => rdf/xml
     *                                              2. If this fails use the extension of the file
     *                                              3. If this fails throw an exception
     *                              - 'xml'
     *                              - 'n3' or 'nt'
     * @param string $locator Denotes whether $data is a local file or a URL.
     * 
     * @throws Erfurt_Exception 
     */
    public function importRdf($modelIri, $data, $type = 'auto', $locator = Erfurt_Syntax_RdfParser::LOCATOR_FILE, 
            $useAc = true)
    {
        if (!$this->_checkAc($modelIri, 'edit', $useAc)) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception("Import failed. Model <$modelIri> not found or not writable.");
        }
        
        if ($type === 'auto') {
            // detect file type
            if ($locator === Erfurt_Syntax_RdfParser::LOCATOR_FILE && is_readable($data)) {
                $pathInfo = pathinfo($data);
                $type     = array_key_exists('extension', $pathInfo) ? $pathInfo['extension'] : '';
            } 
            
            if ($locator === Erfurt_Syntax_RdfParser::LOCATOR_URL) {
                $flag = false;
                // try content-type
                $headers = get_headers($data, 1);
                if (array_key_exists('Content-Type', $headers)) {
                    switch (strtolower($headers['Content-Type'])) {
                        case 'application/rdf+xml':
                            $type = 'rdfxml';
                            $flag = true;
                            break;
                        case 'text/rdf+n3':
                            $type = 'n3';
                            $flag = true;
                            break;
                        case 'application/json':
                            $type = 'rdfjson';
                            $flag = true;
                            break;
                    }
                } 
                
                // try file name
                if (!$flag) {
                    switch (strtolower(strrchr($data, '.'))) {
                        case '.rdf':
                            $type = 'rdfxml';
                            break;
                        case '.n3':
                            $type = 'rdfxml';
                            break;
                    }
                }
            }
        }
        
        
        if (array_key_exists($type, $this->_backendAdapter->getSupportedImportFormats())) {
            return $this->_backendAdapter->importRdf($modelIri, $data, $type, $locator);
        } else {
            require_once 'Erfurt/Syntax/RdfParser.php';
            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat($type);
            $retVal = $parser->parseToStore($data, $locator, $modelIri, $useAc);
            $this->_backendAdapter->init();
            
            return $retVal;
        }
    }
    
    /**
     * @param string $modelIri The Iri, which identifies the model to look for.
     * @param boolean $useAc Whether to use access control or not.
     * 
     * @return boolean Returns true if model exists and is available for the user ($useAc === true). 
     */ 
    public function isModelAvailable($modelIri, $useAc = true)
    {
        if ($this->_backendAdapter->isModelAvailable($modelIri) && $this->_checkAc($modelIri, 'view', $useAc)) {
            return true;
        }
        
        return false;
    }
    
    public function isSqlSupported()
    {
        return ($this->_backendAdapter instanceof Erfurt_Store_Sql_Interface);
    }
    
    /**
     * Returns the ID for the last insert statement.
     */
    public function lastInsertId()
    {
        if ($this->_backendAdapter instanceof Erfurt_Store_Sql_Interface) {
	        return $this->_backendAdapter->lastInsertId();
	    }
	    
	    // TODO: use default SQL store
    }
    
    /**
     * Returns an array of SQL tables available in the store.
     *
     * @param string $prefix An optional table prefix to filter table names.
     *
     * @return array|null
     */
    public function listTables($prefix = '')
    {
        if ($this->_backendAdapter instanceof Erfurt_Store_Sql_Interface) {
	        return $this->_backendAdapter->listTables($prefix);
	    }
	    
	    // TODO: use default SQL store
    }
    
    /**
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $modelIri
     * @param string $askSparql
     * @param boolean $useAc Whether to check for access control.
     */
    public function sparqlAsk(Erfurt_Sparql_SimpleQuery $queryObject, $useAc = true)
    {
        self::$_queryCount++;
        
        // add owl:imports
        foreach ($queryObject->getFrom() as $fromGraphUri) {
            foreach ($this->_getImportsClosure($fromGraphUri) as $importedGraphUri) {
                $queryObject->addFrom($importedGraphUri);
            }
        }
        
        if ($useAc) {
            $modelsFiltered = $this->_filterModels($queryObject->getFrom());
            
            // query contained a non-allowed non-existent model
            if (empty($modelsFiltered)) {
                return;
                // require_once 'Erfurt/Exception.php';
                // throw new Erfurt_Exception('Query could not be executed.');
            }
            
            $queryObject->setFrom($modelsFiltered);
            
            // from named only if it was set
            $fromNamed = $queryObject->getFromNamed();
            if (count($fromNamed)) {
                $queryObject->setFromNamed($this->_filterModels($fromNamed));
            }
        }
        
        return $this->_backendAdapter->sparqlAsk((string) $queryObject);
    }
    
    /**
     * @param Erfurt_Sparql_SimpleQuery $queryObject
     * @param string $resultFormat Currently supported are: 'plain' and 'xml'
     * @param boolean $useAc Whether to check for access control or not.
     * 
     * @throws Erfurt_Exception Throws an exception if query is no string.
     * 
     * @return mixed Returns a result depending on the query, e.g. an array or a boolean value.
     */
    public function sparqlQuery(Erfurt_Sparql_SimpleQuery $queryObject, $resultFormat = 'plain', $useAc = true)
    {
        self::$_queryCount++;
         
        // add owl:imports
        foreach ($queryObject->getFrom() as $fromGraphUri) {
            foreach ($this->_getImportsClosure($fromGraphUri) as $importedGraphUri) {
                $queryObject->addFrom($importedGraphUri);
            }
        }
        
        // if using accesss control, filter FROM (NAMED) for allowed models
        if ($useAc) {
            $modelsFiltered = $this->_filterModels($queryObject->getFrom());
            
            // query contained a non-allowed non-existent model
            if (empty($modelsFiltered)) {
                return;
                // require_once 'Erfurt/Exception.php';
                // throw new Erfurt_Exception('Query could not be executed.');
            }
            
            $queryObject->setFrom($modelsFiltered);
            
            // from named only if it was set
            $fromNamed = $queryObject->getFromNamed();
            if (count($fromNamed)) {
                $queryObject->setFromNamed($this->_filterModels($fromNamed));
            }
        }
   
        // TODO: check if adapter supports requested result format
        return $this->_backendAdapter->sparqlQuery((string) $queryObject, $resultFormat);
    }
    
    /**
     * Executes a SQL query with a SQL-capable backend.
     *
     * @param string $sqlQuery A string containing the SQL query to be executed.
     *
     * @return array
     */
    public function sqlQuery($sqlQuery)
    {
        if ($this->_backendAdapter instanceof Erfurt_Store_Sql_Interface) {
	        return $this->_backendAdapter->sqlQuery($sqlQuery);
	    }
	    
	    // TODO: use default SQL store
    }
    
    // ------------------------------------------------------------------------
    // --- Protected (implemented) methods ------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Checks whether 'view' or 'edit' are allowed on a certain model. The additional $useAc param
     * makes it easy to disable access control for internal usage.
     * 
     * @param string $modelIri The Iri, which identifies the model.
     * @param string $accessType Supported access types are 'view' and 'edit'.
     * @param boolean $useAc Whether to use access control or not.
     * 
     * @return boolean Returns whether view as the case may be edit is allowed for the model or not.
     */
    private function _checkAc($modelIri, $accessType = 'view', $useAc = true)
    {
        // check whether ac should be used (e.g. ac engine itself needs access to store without ac)
        if ($useAc === false) {
            return true;
        } else {
            if ($this->_ac === null) {
                require_once 'Erfurt/App.php';
                $this->_ac = Erfurt_App::getInstance()->getAc();
            }
            
            return $this->_ac->isModelAllowed($accessType, $modelIri);
        }
    }
    
    /**
     * Filters a list of model IRIs according to ACL constraints of the current agent.
     *
     * @param array $modelIris
     */
    private function _filterModels(array $modelIris)
    {
        $allowedModels = array();
        foreach ($this->getAvailableModels(true) as $key => $model) {
            $allowedModels[] = $model['modelIri'];
        }
        
        $modelIrisFiltered = array();
        if (count($modelIris)) {
            $modelIrisFiltered = array_intersect($modelIris, $allowedModels);
        } else {
            $modelIrisFiltered = $allowedModels;
        }
        
        return $modelIrisFiltered;
    }
    
    /**
     * Recursively gets owl:imported model IRIs starting with $modelIri as root.
     *
     * @param string $modelIri
     */
    private function _getImportsClosure($modelIri)
    {
        return $this->_backendAdapter->getImportsClosure($modelIri);
    }
    
    /**
     * Calculates the transitive closure for a given property and a set of starting nodes.
     *
     * @see getTransitiveClosure
     */
    private function _getTransitiveClosure($modelIri, $property, $startResources, $inverse, $maxDepth)
    {
        $closure = array();
        $classes = $startResources;
        $i       = 0;
        
        $from = '';
        foreach ($this->_getImportsClosure($modelIri) as $import) {
            $from .= 'FROM <' . $import . '>' . PHP_EOL;
        }
        
        while (++$i <= $maxDepth) {
            $where = $inverse ? '?child <' . $property . '> ?parent.' : '?parent <' . $property . '> ?child.';
            
            $subSparql = 'SELECT ?parent ?child 
                FROM <' . $modelIri . '>' . PHP_EOL . $from . '
                WHERE {
                    ' . $where . '
                    FILTER (
                        sameTerm(?parent, <' . implode('>) || sameTerm(?parent, <', $classes) . '>)
                    )
                }';

            if (count($result = $this->_backendAdapter->sparqlQuery($subSparql)) < 1) {
                break;
            }
            
            $classes = array();
            foreach ($result as $row) {
                // $key = $inverse ? $row['child'] : $row['parent'];
                $closure[$row['child']] = array(
                    'node'   => $inverse ? $row['child'] : $row['parent'], 
                    'parent' => $inverse ? $row['parent'] : $row['child'], 
                    'depth'  => $i
                );
                $classes[] = $row['child'];
            }
        }
        
        return $closure;
    }
}

