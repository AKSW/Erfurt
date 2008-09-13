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
     * Caching array for imported model IRIs.
     * Format: array(<model IRI> => array(<imported IRI>, ...))
     * @var array
     */
    private $_importedModels = array();
    
    /**
     * Optional methods a backend adapter can implement
     * @var array
     */
    private $_optionalMethods = array(
        'countWhereMatches'
    );
    
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
        
        $this->_checkSetup();
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * @param string $modelIri
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
    public function addStatement($modelIri, $subject, $predicate, $object, $options = array())
    {
        $defaults = array(
            'subject_type' => Erfurt_Store::TYPE_IRI, 
            'object_type'  => Erfurt_Store::TYPE_IRI
        );
        
        $options = array_merge($defaults, $options);
        
        // check whether model is available
        if (!$this->isModelAvailable($modelIri)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Model is not available.');
        }
        
        // check whether model is editable
        if (!$this->_checkAc($modelIri, 'edit')) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('No permissions to edit model.');
        }
        
        $this->_backendAdapter->addStatement($modelIri, $subject, $predicate, $object, $options);
    }
    
    /**
     * @param string $modelIri
     * @param Erfurt_Rdf_Resource $subject (IRI or blank node)
     * @param Erfurt_Rdf_Resource $predicate (IRI, no blank node!)
     * @param Erfurt_Rdf_Node $object (IRI, blank node or literal)
     * 
     * @throws Erfurt_Exception Throws an exception if predicate $p is a blank node or if addition of statements
     * fails.
     */
    public function addStatementFromObjects($modelIri, 
                                            Erfurt_Rdf_Resource $subject, 
                                            Erfurt_Rdf_Resource $predicate, 
                                            Erfurt_Rdf_Node $object)
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
     * Counts all statements that match the SPARQL graph pattern $whereSpec.
     *
     * @param string $graphUri
     * @param string $whereSpec
     */
    public function countWhereMatches($graphUri, $whereSpec)
	{
	    // TODO: owl:imports
	    if (method_exists($this->_backendAdapter, 'countWhereMatches')) {
	        if ($this->_checkAc($graphUri)) {
                return $this->_backendAdapter->countWhereMatches($graphUri, $whereSpec);
	        }
	    }
	    
	    // TODO: is it better to throw an exception in this case?
	    return self::COUNT_NOT_SUPPORTED;
	}
    
    /**
     * 
     * @param string $modelIri
     * @param mixed $subject (string or null)
     * @param mixed $predicate (string or null)
     * @param mixed $object (string or null)
     * @param array $options An array containing two keys 'subject_type' and 'object_type'. The value of each is
     * one of the defined constants of Erfurt_Store: TYPE_IRI, TYPE_BLANKNODE and TYPE_LITERAL. In addtion to this
     * two keys the options array can contain two keys 'literal_language' and 'literal_datatype'.
     * 
     * @throws Erfurt_Exception
     */
    public function deleteMatchingStatements($modelIri, $subject, $predicate, $object, $options = array())
    {
        if ($this->_checkAc($modelIri, 'edit')) {
            return $this->_backendAdapter->deleteMatchingStatements($modelIri, $subject, $predicate, $object, $options);
        }
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
        $acModelUri = Erfurt_App::getInstance()->getAcModel()->getUri();
        $this->_backendAdapter->deleteMatchingStatements($acModelUri, null, null, $modelIri);
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
        // check whether model is available
        if (!$this->isModelAvailable($modelIri)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("Model <$modelIri> cannot be exported. Model is not available.");
        }
        
        if (in_array($serializationType, $this->_backendAdapter->getSupportedExportFormats())) {
            $this->_backendAdapter->exportRdf($modelIri, $serializationType, $filename);
        } else {
            throw new Exception("Serialization format '$serializationType' not supported by backend.");
        }
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
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("Model <$modelIri> is not available.");
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
    
    /**
     * Returns an array of serialization formats that can be imported.
     *
     * @return array
     */
    public function getSupportedImportFormats()
    {
        // TODO: check import plug-ins
        return $this->_backendAdapter->getSupportedImportFormats();
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
    public function importRdf($modelIri, $data, $type = 'auto', $locator = 'file')
    {
        if (!$this->_checkAc($modelIri, 'edit')) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("Import failed. Model <$modelIri> not found or not writable.");
        }
        
        if (array_key_exists($type, $this->_backendAdapter->getSupportedImportFormats())) {
            return $this->_backendAdapter->importRdf($modelIri, $data, $type, $locator);
        } else if ($type == 'auto') {
            // TODO: check format
            return $this->_backendAdapter->importRdf($modelIri, $data, $type, $locator);
        } else {
            // TODO: look for plugins
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
    
    /**
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $modelIri
     * @param string $askSparql
     * @param boolean $useAc Whether to check for access control.
     */
    public function sparqlAsk(Erfurt_Sparql_SimpleQuery $query, $useAc = true)
    {
        // add owl:imports
        foreach ($queryObject->getFrom() as $fromGraphUri) {
            foreach ($this->_getImportedModels($fromGraphUri) as $importedGraphUri) {
                $queryObject->addFrom($importedGraphUri);
            }
        }
        
        if ($useAc) {
            $query->setFrom($this->_filterModels($query->getFrom()));
            
            // from named only if it was set
            $fromNamed = $query->getFromNamed();
            if (count($fromNamed)) {
                $query->setFromNamed($this->_filterModels($fromNamed));
            }
        }
        
        return $this->_backendAdapter->sparqlAsk((string) $query);
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
        // add owl:imports
        foreach ($queryObject->getFrom() as $fromGraphUri) {
            foreach ($this->_getImportedModels($fromGraphUri) as $importedGraphUri) {
                $queryObject->addFrom($importedGraphUri);
            }
        }
        
        // if using accesss control, filter FROM (NAMED) for allowed models
        if ($useAc) {
            $queryObject->setFrom($this->_filterModels($queryObject->getFrom()));
            
            // from named only if it was set
            $fromNamed = $queryObject->getFromNamed();
            if (count($fromNamed)) {
                $queryObject->setFromNamed($this->_filterModels($fromNamed));
            }
        }
        
        return $this->_backendAdapter->sparqlQuery((string) $queryObject, $resultFormat);
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
     * Checks whether the store has been set up yet and imports system 
     * ontologies if necessary.
     */
    private function _checkSetup()
    {
        $config         = Erfurt_App::getInstance()->getConfig();
        $logger         = Erfurt_App::getInstance()->getLog();
        $sysOntSchema   = $config->sysOnt->schemaUri;
        $schemaLocation = $config->sysOnt->schemaLocation;
        $schemaPath     = EF_BASE . $config->sysOnt->schemaPath;
        $sysOntModel    = $config->sysOnt->modelUri;
        $modelLocation  = $config->sysOnt->modelLocation;
        $modelPath      = EF_BASE . $config->sysOnt->modelPath;
        
        // check for system ontology
        if (!$this->_backendAdapter->isModelAvailable($sysOntSchema)) {
            $logger->info('System schema model not found. Loading model ...');
            
            if (is_readable($schemaPath)) {
                // load SysOnt from file
                $this->_backendAdapter->importRdf($sysOntSchema, $schemaPath, 'rdf', 'file');
            } else {
                // load SysOnt from Web
                $this->_backendAdapter->importRdf($sysOntSchema, $schemaLocation, 'rdf', 'url');
            }
            
            if (!$this->isModelAvailable($sysOntSchema, false)) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Unable to load System Ontology schema.');
            }
            
            $logger->info('System schema successfully loaded.');
        }
        
        // check for system configuration model
        if (!$this->_backendAdapter->isModelAvailable($sysOntModel)) {
            $logger->info('System configuration model not found. Loading model ...');
            
            if (is_readable($modelPath)) {
                // // load SysOnt Model from file
                $this->_backendAdapter->importRdf($sysOntModel, $modelPath, 'rdf', 'file');
            } else {
                // // load SysOnt Model from Web
                $this->_backendAdapter->importRdf($sysOntModel, $modelLocation, 'rdf', 'url');
            }
            
            if (!$this->isModelAvailable($sysOntModel, false)) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Unable to load System Ontology model.');
            }
            
            $logger->info('System schema successfully loaded.');
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
    private function _getImportedModels($modelIri)
    {
        if (!array_key_exists($modelIri, $this->_importedModels)) {
            $models = array();
            $result = array(
                // mock first result
                array('o' => $modelIri)
            );

            do {
                $from    = '';
                $filter   = array();
                foreach ($result as $row) {
                    $from    .= ' FROM <' . $row['o'] . '>' . "\n";
                    $filter[] = 'str(?model) = <' . $row['o'] . '>';

                    // ensure no model is added twice
                    if (!array_key_exists($row['o'], $models)) {
                        $models[$row['o']] = $row['o'];
                    }
                }
                $query = '
                    SELECT ?o' . 
                    $from . '
                    WHERE {
                        ?model <' . EF_OWL_NS . 'imports> ?o. 
                        FILTER (' . implode(' || ', $filter) . ')
                    }';
            } while ($result = $this->_backendAdapter->sparqlQuery($query));
            
            // unset root node
            unset($models[$modelIri]);
            // cache result
            $this->_importedModels[$modelIri] = array_keys($models);
        }
        
        return $this->_importedModels[$modelIri];
    }
}

