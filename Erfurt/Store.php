<?php
/**
 * @package    store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
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
    
    protected $_dbUser = null;
    protected $_dbPass = null;
    
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    private $_backendAdapter = null;
    private $_ac = null;
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Constructor method.
     * 
     * @var string $backend virtuoso, mysqli, adodb, redland
     * @var array $backendOptions
     * @var string/null $schema rap 
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
            $backendName = 'ZendDb';
        } else {
            $backendName = ucfirst($backend);
        }
        
        
        $fileName   = 'Store/Adapter/' . $schemaName . $backendName . '.php';
        $className  = 'Erfurt_Store_Adapter_' . $schemaName . $backendName;
        
        if (is_readable((EF_BASE . $fileName))) {
            require_once $fileName;
        } else {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Backend (with schema) is not supported, for file was not found.');
        }
        
        if (!class_exists($className)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Backend (with schema) is not supported, for class was not found.');
        }
        
        $this->_backendAdapter = new $className($backendOptions);
        
        if (!($this->_backendAdapter instanceof Erfurt_Store_Adapter_Interface)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Adpater class does not implement Erfurt_Store_Adapter_Interface.');
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
    public function addStatement($modelIri, $subject, $predicate, $object, 
            $options = array('subject_type' => Erfurt_Store::TYPE_IRI, 'object_type'  => Erfurt_Store::TYPE_IRI))
    {
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
    public function addStatementFromObjects($modelIri, Erfurt_Rdf_Resource $subject, Erfurt_Rdf_Resource $predicate, 
            Erfurt_Rdf_Node $object)
    {
        if ($predicate->isBlankNode()) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Predicate must not be a blank node.');
        }
        
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
            throw new Erfurt_Exception('Model is not available and therefore not removable.');
        }
        
        // check whether model editing is allowed
        if (!$this->_checkAc($modelIri, 'edit', $useAc)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('No permissions to delete the model.');
        }
        
        // delete model
        $this->_backendAdapter->deleteModel($modelIri);
        
        // remove statements about deleted model from SysOnt
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
            throw new Erfurt_Exception('Model is not available and therefore not removable.');
        }
        
        if (in_array($serializationType, $this->_backendAdapter->getSupportedExportFormats())) {
            $this->_backendAdapter->exportRdf($modelIri, $serializationType, $filename);
        } else {
            throw new Exception('Not implemented yet.');
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
        $models = $this->_backendAdapter->getAvailableModels($withTitle);
        $result = array();
        foreach ($models as $m) {
            if ($this->_checkAc($m['modelIri'])) {
                $result[] = $m;
            }
        }
        
        return $result;
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
            throw new Erfurt_Exception('Model is not available.');
        }
        
        $m = $this->_backendAdapter->getModel($modelIri);
        
        // check for edit possibility
        if ($this->_checkAc($modelIri, 'edit', $useAc)) {
            $m->setEditable(true);
        } else {
            $m->setEditable(false);
        }
        
        return $m;
    }
    
    /**
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
            
// TODO check whether user is allowed to create a new model
        
        return $this->_backendAdapter->getNewModel($modelIri, $baseIri, $type);
    }
    
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
        } else {
            return false;
        }
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
        if ($useAc) {
            $from      = $query->getFrom();
            $fromNamed = $query->getFromNamed();
            
            $fromAllowed      = array();
            $fromNamedAllowed = array();
            
            if ((count($from) == 0) && (count($fromNamed) == 0)) {
                $availableModels = $this->getAvailableModels();
                foreach ($availableModels as $m) {
                    $fromAllowed[] = $m['modelIri'];
                }
            } else {
                foreach ($from as $f) {
                    if ($this->_checkAc($f, 'view', $useAc)) {
                        $fromAllowed[] = $f;
                    }
                }
                foreach ($fromNamed as $fN) {
                    if ($this->_checkAc($fN, 'view', $useAc)) {
                        $fromNamedAllowed[] = $fN;
                    }
                }
            }
            
            $query->setFrom($fromAllowed)
                  ->setFromNamed($fromNamedAllowed);
        }
        
        return $this->_backendAdapter->sparqlAsk($query);
    }
    
    /**
     * @param string $query A string containing a sparql query
     * @param string $resultform Currently supported are: 'plain' and 'xml'
     * @param boolean $useAc Whether to check for access control or not.
     * 
     * @throws Erfurt_Exception Throws an exception if query is no string.
     * 
     * @return mixed Returns a result depending on the query, e.g. an array or a boolean value.
     */
    public function sparqlQuery(Erfurt_Sparql_SimpleQuery $query, $resultform = 'plain', $useAc = true)
    {
        // if we use ac, check all from iris whether allowed or not and remove forbidden ones
        if ($useAc === true) {
            $from = $query->getFrom();
            $fromNamed = $query->getFromNamed();
            
            $fromAllowed = array();
            $fromNamedAllowed = array();
            
            // if $from and $fromNamed are both empty, this could mean neither from nor
            // from named was specified in any way... so ask all available models
            if ((count($from) === 0) && (count($fromNamed) === 0)) {
                $availableModels = $this->getAvailableModels();
                
                foreach ($availableModels as $m) {
                    $fromAllowed[] = $m['modelIri'];
                }
            } else {
                foreach ($from as $f) {
                    if ($this->_checkAc($f, 'view', $useAc)) {
                        $fromAllowed[] = $f;
                    }
                }
                
                foreach ($fromNamed as $fN) {
                    if ($this->_checkAc($fN, 'view', $useAc)) {
                        $fromNamedAllowed[] = $fN;
                    }
                }
            }
            
            // finally update the query with the from and from named iris
            $query->setFrom($fromAllowed);
            $query->setFromNamed($fromNamedAllowed);
        }
        
        return $this->_backendAdapter->sparqlQuery($query, $resultform);
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
    protected function _checkAc($modelIri, $accessType = 'view', $useAc = true)
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
    
    protected function _checkSetup()
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
                $test = $this->_backendAdapter->importRdf($sysOntSchema, $schemaPath, 'rdf', 'file');
            } else {
                // load SysOnt from Web
                $test = $this->_backendAdapter->importRdf($sysOntSchema, $schemaLocation, 'rdf', 'url');
            }
            
            if (!$test instanceof Erfurt_Rdf_Model) {
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
                $test = $this->_backendAdapter->importRdf($sysOntModel, $modelPath, 'rdf', 'file');
            } else {
                // // load SysOnt Model from Web
                $test = $this->_backendAdapter->importRdf($sysOntModel, $modelLocation, 'rdf', 'url');
            }
            
            if (!$test instanceof Erfurt_Rdf_Model) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Unable to load System Ontology model.');
            }
            
            $logger->info('System schema successfully loaded.');
        }
    }
}

?>
