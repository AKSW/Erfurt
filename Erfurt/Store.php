<?php
// vim: sw=4:sts=4:expandtab
/**
 * @package  erfurt
 * @subpackage   store
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author    Norman Heino <norman.heino@gmail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: Store.php 4312 2009-10-14 21:37:14Z c.riess.dev $
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
    
    /**
     * A RDF/PHP array containing additional configuration options for graphs
     * in the triple store. This information is stored in the local system
     * ontology.
     * @var array
     * 
     */
    protected $_graphConfigurations = null;

    /**
     * An Array holding the Namespace prefixes (An array of namespace IRIs (keys) and prefixes) for some models
     * @var array
     */
    protected $_prefixes = null;

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
            
            // Use Ef schema as default for the ZendDb backend
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
     * Get all namespaces with there prefix
     * @param string $graphUri
     * @return array with namespace as key and prefix as value
     */
    public function getNamespacePrefixes($graphUri)
    {
        if (null === $this->_prefixes || !isset($this->_prefixes[$graphUri])) {
            $this->_initiateNamespacePrefixes($graphUri);
        }

        return $this->_prefixes[$graphUri];
    }

    /**
     * Get the prefix for one namespaces, will be created if no prefix exists
     * @param string $graphUri
     * @return array with namespace as key and prefix as value
     */
    public function getNamespacePrefix($graphUri, $namespace, $useAc = true)
    {
        require_once('Erfurt/Exception.php');
        require_once('Erfurt/Ac/Exception.php');

        if (null === $this->_prefixes || isset($this->_prefixes[$graphUri]) === false) {
            $this->_initiateNamespacePrefixes($graphUri);
        }

        $prefix = array_search($namespace, $this->_prefixes[$graphUri]);

        if ($this->_checkAc($graphUri, 'edit', $useAc)) {
            if($prefix === false) {
                $efApp = Erfurt_App::getInstance();
                $logger = $efApp->getLog();
                // serach erfurt config for predefined prefixes

                $config = $efApp->getConfig();
                $namespaces = $config->namespaces->toArray();

                $logger->debug('Prefixmangagement in Store: Searching for namespace: ' . var_export($namespace, true));
                $logger->debug('Prefixmangagement in Store: The predefined namespace prefixes: ' . var_export($namespaces, true));

                if (is_array($namespaces)) {
                    $prefix = array_search($namespace, $namespaces);
                } else {
                    $prefix = false;
                }

                $logger->debug('Prefixmangagement in Store: Found prefix? ' . var_export($prefix, true));

                if($prefix === false || isset($this->_prefixes[$graphUri][$prefix])) {
                    for($i = 0; isset($this->_prefixes[$graphUri]['ns' . $i]); $i++) {
                    }
                    $prefix = 'ns' . $i;
                }
                $this->addNamespacePrefix($graphUri, $prefix, $namespace, $useAc);
            }
        } else {
            throw new Erfurt_Ac_Exception();
        }

        return $prefix;
    }

    /**
     * Add a namespace -> prefix mapping
     * @param string $graphUri
     * @param $prefix a prefix to identify the namespace
     * @param $namespace the namespace uri
     * @param $useAc use access control
     * @return boolean success state
     * @throws Erfurt_Exception
     */
    public function addNamespacePrefix($graphUri, $prefix, $namespace, $useAc = true)
    {
        require_once('Erfurt/Utils.php');
        require_once('Zend/Uri.php');

        if ($this->_checkAc($graphUri, 'edit', $useAc)) {

            if (null === $this->_prefixes || !isset($this->_prefixes[$graphUri])) {
                $this->_initiateNamespacePrefixes($graphUri);
            }

            /**
             * check namespace if valid
             */
            if (Zend_Uri::check($namespace) === false) {
                require_once('Erfurt/Store/Exception.php');
                throw new Erfurt_Store_Exception('The given namespace ("' . $namespace . '") is not a valid URI.');
            }

            /**
             * check prefix if valid
             */
            if (Erfurt_Utils::isXmlPrefix($prefix) === false) {
                require_once('Erfurt/Store/Exception.php');
                throw new Erfurt_Store_Exception('The given prefix ("' . $prefix . '") is not a valid XML Prefix.');
            }

            /**
             * check if prefix matches a uri schema
             */
            $config = Erfurt_App::getInstance()->getConfig();
            $schemataArray = $config->uri->schemata->toArray();
            $schema = array_search($prefix, $schemataArray);
            if ($schema !== false) {
                require_once('Erfurt/Store/Exception.php');
                throw new Erfurt_Store_Exception('The given prefix ("' . $prefix . '") matches a URI schema. Please avoid to use a URI schema from the IANA list: http://www.iana.org/assignments/uri-schemes.html.');
            }

            if (isset($this->_prefixes[$graphUri][$prefix]) === false) {
                $this->_prefixes[$graphUri][$prefix] = $namespace;

                /**
                 * get prefixes from model configuration
                 */
                $option     = $this->getGraphConfiguration($graphUri);

                /**
                 * add new prefix with namespace to the config option
                 */
                if (!isset($option['http://ns.ontowiki.net/SysOnt/prefix'])) {
                    $option['http://ns.ontowiki.net/SysOnt/prefix'] = array();
            }
            $option['http://ns.ontowiki.net/SysOnt/prefix'][] = array(
                'value' => $prefix . '=' . $namespace,
                'type'  => 'literal'
                    );

            /**
             * write the config option back to the model
             */
            $model      = $this->getModel($graphUri, $useAc);
            $model->setOption('http://ns.ontowiki.net/SysOnt/prefix', $option['http://ns.ontowiki.net/SysOnt/prefix']);

            /**
             * return success
             */
            return true;
            } else {
                require_once('Erfurt/Store/Exception.php');
                throw new Erfurt_Store_Exception('This prefix "' . $prefix . '" already exists.');
                return false;
            }
        } else {
            /**
             * return fail
             */
            require_once('Erfurt/Ac/Exception.php');
            throw new Erfurt_Ac_Exception('No rights to add namespace prefix.');
            return false;
        }
    }

    /**
     * Delete a namespace -> prefix mapping
     * @param string $graphUri
     * @param $prefix the prefix you want to remove
     * @param $useAc use access control
     * @return boolean successfully state
     * @throws Erfurt_Exception
     */
    public function deleteNamespacePrefix($graphUri, $prefix, $useAc = true)
    {
        if ($this->_checkAc($graphUri, 'edit', $useAc)) {

            if (null === $this->_prefixes || !isset($this->_prefixes[$graphUri])) {
                $this->_initiateNamespacePrefixes($graphUri);
            }

            unset($this->_prefixes[$graphUri][$prefix]);

            /**
             * get prefixes from model configuration
             */
            $option     = $this->getGraphConfiguration($graphUri);

            /**
             * remove the entry with the given prefix from the config option
             */
            if (isset($option['http://ns.ontowiki.net/SysOnt/prefix'])) {
                for($i = 0; $i < count($option['http://ns.ontowiki.net/SysOnt/prefix']); $i++){
                    if(0 === strpos($option['http://ns.ontowiki.net/SysOnt/prefix'][$i]['value'], $prefix . '=')){
                        unset($option['http://ns.ontowiki.net/SysOnt/prefix'][$i]);
        }
        }
        } else {
            $option['http://ns.ontowiki.net/SysOnt/prefix'] = array();
        }

        /**
         * write the config option back to the model
         */
        $model      = $this->getModel($graphUri);
        $model->setOption('http://ns.ontowiki.net/SysOnt/prefix', $option['http://ns.ontowiki.net/SysOnt/prefix']);

        /**
         * should be successfully in every case
         */
        return true;
        } else {

            /**
             * if authentication failes
             */
            return false;
        }
    }

    /**
     * initialy set the namespace mapping array for the model
     * (read the mapping from system configuration)
     * @param string $graphUri
     */
    protected function _initiateNamespacePrefixes($graphUri)
    {

        /**
         * get prefixes from model configuration
         */
        $option     = $this->getGraphConfiguration($graphUri);

        /**
         * iterate config option and split prefix and namespace
         */
        if (isset($option['http://ns.ontowiki.net/SysOnt/prefix'])) {
            for($i = 0; $i < count($option['http://ns.ontowiki.net/SysOnt/prefix']); $i++){
                $property   = $option['http://ns.ontowiki.net/SysOnt/prefix'][$i];
        $splitpos   = strpos($property['value'], '=');           // find splitposition
        $prefix     = substr($property['value'], 0, $splitpos);  // get the part befor the '='
        $namespace  = substr($property['value'], $splitpos + 1); // get the rest
        $this->_prefixes[$graphUri][$prefix] = $namespace;
    }
    } else {
        $this->_prefixes[$graphUri] = array();
    }
    }

    /**
     * This is a trigger function to test if the config options are written propperly
     * @param string $graphUri
     */
    public function initiateNamespacsPrefixesTrigger($graphUri){
        $this->_initiateNamespacsPrefixes($graphUri);
    }

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
        
        //invalidate deprecated Cache Objects
        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidateWithStatements($graphUri, $statementsArray );
        
        require_once 'Erfurt/Event/Dispatcher.php';
        require_once 'Erfurt/Event.php';
        $event = new Erfurt_Event('onAddMultipleStatements');
        $event->graphUri   = $graphUri; 
        $event->statements = $statementsArray;
        $event->trigger();
        
        $this->_graphConfigurations = null;
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
    public function addStatement($graphUri, $subject, $predicate, $object, $useAcl = true)
    {        
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
        
        $this->_backendAdapter->addStatement($graphUri, $subject, $predicate, $object);

        //invalidate deprecateded Cache Objects
        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidate( $graphUri, $subject , $predicate, $object );


        require_once 'Erfurt/Event/Dispatcher.php';
        require_once 'Erfurt/Event.php';
        $event = new Erfurt_Event('onAddStatement');
        $event->graphUri   = $graphUri; 
        $event->statement = array(
            'subject'   => $subject,
            'predicate' => $predicate,
            'object'    => $object
        );
        $event->trigger();
        
        $this->_graphConfigurations = null;
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
        $sysOntSchema   = $config->sysont->schemaUri;
        $schemaLocation = $config->sysont->schemaLocation;
        $schemaPath     = preg_replace('/[\/\\\\]/', '/', EF_BASE . $config->sysont->schemaPath);
        $sysOntModel    = $config->sysont->modelUri;
        $modelLocation  = $config->sysont->modelLocation;
        $modelPath      = preg_replace('/[\/\\\\]/', '/', EF_BASE . $config->sysont->modelPath);
        
        $returnValue = true;
        
        // check for system configuration model
        // We need to import this first, for the schema model has namespaces definitions, which will be stored in the
        // local config!
        if (!$this->isModelAvailable($sysOntModel, false)) {
            $logger->info('System configuration model not found. Loading model ...');
            Erfurt_App::getInstance()->getVersioning()->enableVersioning(false);
            
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
                // clear query cache completly
                $queryCache = Erfurt_App::getInstance()->getQueryCache();
                $queryCache->cleanUpCache( array('mode' => 'uninstall') );
                // Delete the model, for the import failed.
                $this->_backendAdapter->deleteModel($sysOntModel);
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception("Import of '$sysOntModel' failed -> " . $e->getMessage());
            }
            
            if (!$this->isModelAvailable($sysOntModel, false)) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Unable to load System Ontology model.');
            }
            
            Erfurt_App::getInstance()->getVersioning()->enableVersioning(true);
            $logger->info('System model successfully loaded.');
            $returnValue = false;
        }
        
        // check for system ontology
        if (!$this->isModelAvailable($sysOntSchema, false)) {
            $logger->info('System schema model not found. Loading model ...');
            Erfurt_App::getInstance()->getVersioning()->enableVersioning(false);
            
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
                // clear query cache completly
                $queryCache = Erfurt_App::getInstance()->getQueryCache();
                $queryCache->cleanUpCache( array('mode' => 'uninstall') );
                // Delete the model, for the import failed.
                $this->_backendAdapter->deleteModel($sysOntSchema);
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception("Import of '$sysOntSchema' failed -> " . $e->getMessage());
            }
            
            if (!$this->isModelAvailable($sysOntSchema, false)) {
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception('Unable to load System Ontology schema.');
            }
            
            Erfurt_App::getInstance()->getVersioning()->enableVersioning(true);
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
    public function countWhereMatches($graphIri, $whereSpec, $countSpec)
    {
        if (method_exists($this->_backendAdapter, 'countWhereMatches')) {
            if ($this->_checkAc($graphIri)) {
                $graphIris = array_merge($this->getImportsClosure($graphIri), array($graphIri));
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
        if (!isset($options['use_ac'])) {
            $options['use_ac'] = true;
        }
        
        if ($this->_checkAc($graphUri, 'edit', $options['use_ac'])) {
            try {
                $ret =  $this->_backendAdapter->deleteMatchingStatements(
                $graphUri, $subject, $predicate, $object, $options);

                $queryCache = Erfurt_App::getInstance()->getQueryCache();
                $queryCache->invalidate( $graphUri, $subject , $predicate, $object );
                
                require_once 'Erfurt/Event/Dispatcher.php';
                require_once 'Erfurt/Event.php';
                $event = new Erfurt_Event('onDeleteMatchingStatements');
                $event->graphUri = $graphUri;
                $event->resource = $subject;
                
                // just trigger if really data operations were performed 
                if ((int) $ret > 0) {
                    $event->trigger();
                }
                
                return $ret;

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

        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidateWithStatements( $graphUri, $statementsArray );
        
        require_once 'Erfurt/Event.php';
        $event = new Erfurt_Event('onDeleteMultipleStatements');
        $event->graphUri   = $graphUri; 
        $event->statements = $statementsArray;
        $event->trigger();
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
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception("Model <$modelIri> is not available and therefore not removable.");
        }
        
        // check whether model editing is allowed
        if (!$this->_checkAc($modelIri, 'edit', $useAc)) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception("No permissions to delete model <$modelIri>.");
        }
        
        // delete model
        $this->_backendAdapter->deleteModel($modelIri);

        // and history
        Erfurt_App::getInstance()->getVersioning()->deleteHistoryForModel($modelIri);

        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidateWithModelIri($modelIri);

        
        // remove any statements about deleted model from SysOnt
        if (Erfurt_App::getInstance()->getAcModel() !== false) {
            $acModelIri = Erfurt_App::getInstance()->getAcModel()->getModelIri();
            
            // Only do that, if the deleted model was not one of the sys models
            $config = Erfurt_App::getInstance()->getConfig();
            if (($modelIri !== $config->sysont->modelUri) && ($modelIri !== $config->sysont->schemaUri)) {
                $this->_backendAdapter->deleteMatchingStatements(
                    $acModelIri,
                    null,
                    null,
                    array('value' => $modelIri, 'type' => 'uri')
                );
                $this->_backendAdapter->deleteMatchingStatements(
                    $acModelIri, 
                    $modelIri, 
                    null, 
                    null
                );
                // invalidate for the sysmodel too
                $queryCache->invalidateWithModelIri($acModelIri);
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

        // TODO stringSpec should be more than simple string (parse for and/or/xor etc...)
        $stringSpec = (string) $stringSpec;
        $graphUris  = (array) $graphUris;

        $options = array_merge(array(
            'case_sensitive'    => false, 
            'filter_classes'    => false, 
            'filter_properties' => false,
            'with_imports'      => true
        ), $options);
        
        if ($options['with_imports'] === true) {
        
            // load imports for each graph
            foreach ($graphUris as $graphUri) {
            
                // get imports
                $importUris = $this->getImportsClosure($graphUri);
                
                // check if imports should be added else they are already present
                foreach ($importUris as $importUri) {
                
                    if ( !in_array($importUri,$graphUris) ) {
                        $graphUris[] = $importUri;
                    } else {
                        // do nothing
                    }
                    
                }
                 
            }
            
        } else {
            // do nothing (leave the graphUris-array as is)
        }
        
        
        // execute backend-specific search if available
        if (method_exists($this->_backendAdapter, 'findResourcesWithPropertyValue')) 
        {
        
            return $this->_backendAdapter->findResourcesWithPropertyValue($stringSpec, $graphUris, $options);
            
        }
        // else execute Sparql Regex Fallback
        else
        {
        
            // New query object (Erfurt_Sparql_Query2)
            require_once 'Erfurt/Sparql/Query2.php';
            $query = new Erfurt_Sparql_Query2();
            
            foreach ($graphUris as $graphUri) {
                $query->addFrom($graphUri);
            }
            
            $query->setDistinct(true);
            
            $s_var = new Erfurt_Sparql_Query2_Var('s');
            $p_var = new Erfurt_Sparql_Query2_Var('p');
            $o_var = new Erfurt_Sparql_Query2_Var('o');
            
            $query->addProjectionVar($s_var);
            
            $default_tpattern = new Erfurt_Sparql_Query2_Triple($s_var, $p_var, $o_var);
            
            $query->getWhere()->addElement($default_tpattern);
            
            if ($options['filter_properties']) {
                $ss_var = new Erfurt_Sparql_Query2_var('ss');
                $oo_var = new Erfurt_Sparql_Query2_var('oo');
                
                $filterprop_tpattern = new Erfurt_Sparql_Query2_Triple($ss_var, $s_var, $oo_var);
                
                $query->getWhere()->addElement($filterprop_tpattern);
            }
            
            if ($options['case_sensitive']) {
            
                $query->addFilter(
                    new Erfurt_Sparql_Query2_Regex(
                        $o_var, 
                        new Erfurt_Sparql_Query2_RDFLiteral($stringSpec)
                    )
                );
                
            } else {
            
                $query->addFilter(
                
                    new Erfurt_Sparql_Query2_Regex(
                        $o_var, 
                        new Erfurt_Sparql_Query2_RDFLiteral($stringSpec), 
                        new Erfurt_Sparql_Query2_RDFLiteral('i')
                    )
                );
                
            }
            
            $resources = array();
            if ($results = $this->sparqlQuery($query)) {
                foreach ($results as $row) {
                    array_push($resources, $row['s']);
                }
            }

            return $resources;

        }
    }
    
    /**
     * @param boolean $withHidden Whether to return URIs of hidden graphs, too.
     * @return array Returns an associative array, where the key is the URI of a graph and the value
     * is true.
     */
    public function getAvailableModels($withHidden = false)
    {
        // backend adapter returns all models
        $models = $this->_backendAdapter->getAvailableModels();

        // filter for access control and hidden models
        foreach ($models as $graphUri => $true) {
            if (!$this->_checkAc($graphUri)) {
                unset($models[$graphUri]);
            }
            if ($withHidden === false) {
                $graphConfig = $this->getGraphConfiguration($graphUri);
                
                if (isset($graphConfig['http://ns.ontowiki.net/SysOnt/hidden'])) {                    
                    if ((boolean)$graphConfig['http://ns.ontowiki.net/SysOnt/hidden'][0]['value']) {
                        unset($models[$graphUri]);
                    }
                }
            }
        }
        
        return $models;
    }
    
    /**
     * Returns the class name of the currently used backend.
     *
     * @return string
     */
    public function getBackendName() 
    {
        if (method_exists($this->_backendAdapter, 'getBackendName')) {
            return $this->_backendAdapter->getBackendName();
        }
        
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
     * Recursively gets owl:imported model IRIs starting with $modelIri as root.
     *
     * @param string $modelIri
     */
    public function getImportsClosure($modelIri, $withHiddenImports = true)
    {
        $currentLevel = $this->_backendAdapter->getImportsClosure($modelIri);
        
        if ($withHiddenImports === true) {
            $config = Erfurt_App::getInstance()->getConfig();
            $importsUri = $config->sysont->properties->hiddenImports;
            
            $graphConfig = $this->getGraphConfiguration($modelIri);
            if (isset($graphConfig[$importsUri])) {
                foreach ($graphConfig[$importsUri] as $valueArray) {
                    $currentLevel[$valueArray['value']] = $valueArray['value'];
                }
            }
            
            foreach ($currentLevel as $graphUri) {
                $graphConfig = $this->getGraphConfiguration($graphUri);
                
                if (isset($graphConfig[$importsUri])) {
                    foreach ($graphConfig[$importsUri] as $valueArray) {
                        $currentLevel = array_merge(
                            $currentLevel, 
                            $this->getImportsClosure($valueArray['value'], $withHiddenImports)
                        );
                    }
                }
            }
        }
        
        return array_unique($currentLevel);
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
                        throw new Erfurt_Store_Exception('Check setup failed:' . $e->getMessage());
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
     * Returns a logo URL.
     *
     * @return string
     */
    public function getLogoUri()
    {
        if (method_exists($this->_backendAdapter, 'getLogoUri')) {
            return $this->_backendAdapter->getLogoUri();
        }
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
    
        if ($useAc && !Erfurt_App::getInstance()->isActionAllowed('ModelManagement')) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("Failed creating the model. Action not allowed!");
        }

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
            'ttl'       => 'Turtle',
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
            'ttl'       => 'Turtle',
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
        
        require_once 'Erfurt/Syntax/RdfParser.php';
        
        if ($type === 'auto') {
            // detect file type
            if ($locator === Erfurt_Syntax_RdfParser::LOCATOR_FILE && is_readable($data)) {
                $pathInfo = pathinfo($data);
                $type     = array_key_exists('extension', $pathInfo) ? $pathInfo['extension'] : '';
            } 
            
            if ($locator === Erfurt_Syntax_RdfParser::LOCATOR_URL) {
                $flag = false;
                // try content-type
                stream_context_get_default(array(
                    'http' => array(
                        'header' => "Accept: application/rdf+xml, appliaction/json, text/rdf+n3, text/plain"
                )));

                $headers = get_headers($data, 1);
                stream_context_get_default(array(
                    'http' => array(
                        'header' => ""
                )));
                
                if (is_array($headers) && array_key_exists('Content-Type', $headers)) {
                    $ct = $headers['Content-Type'];
                    if (is_array($ct)) {
                        $ct = array_pop($ct);
                    }
                    $ct = strtolower($ct);

                    if (substr($ct, 0, strlen('application/rdf+xml')) === 'application/rdf+xml') {
                        $type = 'rdfxml';
                        $flag = true;
                    } else if (substr($ct, 0, strlen('text/plain')) === 'text/plain') {
                        $type = 'rdfxml';
                        $flag = true;
                    } else if (substr($ct, 0, strlen('text/rdf+n3')) === 'text/rdf+n3') {
                        $type = 'ttl';
                        $flag = true;
                    } else if (substr($ct, 0, strlen('application/json')) === 'application/json') {
                        $type = 'rdfjson';
                        $flag = true;
                    }
                } 
                
                // try file name
                if (!$flag) {
                    switch (strtolower(strrchr($data, '.'))) {
                        case '.rdf':
                            $type = 'rdfxml';
                            break;
                        case '.n3':
                            $type = 'ttl';
                            break;
                    }
                }
            }
        }
        
        
        if (array_key_exists($type, $this->_backendAdapter->getSupportedImportFormats())) {
            $result = $this->_backendAdapter->importRdf($modelIri, $data, $type, $locator);
            $this->_backendAdapter->init();
            return $result;
        } else {
            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat($type);
            $retVal = $parser->parseToStore($data, $locator, $modelIri, $useAc);

            // After import re-initialize the backend (e.g. zenddb: fetch model infos again)
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
            foreach ($this->getImportsClosure($fromGraphUri) as $importedGraphUri) {
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
        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        if (!($sparqlResult = $queryCache->load( (string) $queryObject, "plain"))){
            // TODO: check if adapter supports requested result format
            $startTime = microtime(true);
            $sparqlResult = $this->_backendAdapter->sparqlAsk((string) $queryObject);
            $duration = microtime(true) - $startTime;
            $queryCache->save( (string) $queryObject, "plain" , $sparqlResult, $duration);
        }
        
        return $sparqlResult;
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
    public function sparqlQuery($queryObject, $options = array())
    {
        if($queryObject instanceof Erfurt_Sparql_Query2)
            Erfurt_App::getInstance()->getLog()->info('Store: evaluating a Query2-object (sparql:'."\n".$queryObject.') ');
        
        self::$_queryCount++;
        
        $defaultOptions = array(
            'result_format'          => 'plain',
            'use_ac'                 => true,
            'use_owl_imports'        => true,
            'use_additional_imports' => true
        );
        
        $options = array_merge($defaultOptions, $options);

        $useAdditional = $options['use_additional_imports'];
        if ($options['use_owl_imports'] === true) {
            // add owl:imports
            if($queryObject instanceof Erfurt_Sparql_Query2 || $queryObject instanceof Erfurt_Sparql_Query2_Abstraction){
                //new way, "
                $queryObject = clone $queryObject; // we dont want to modify the query itself - could be used elsewhere
                $from_strings = array();
                foreach ($queryObject->getFroms() as $graphClause) {
                    $uri = $graphClause->getGraphIri()->getIri();
                    //$from_strings[] = $uri;
                    foreach ($this->getImportsClosure($uri, $useAdditional) as $importedGraphUri) {
                        $queryObject->addFrom($importedGraphUri);
                    }
                }

            } else {
                foreach ($queryObject->getFrom() as $fromGraphUri) {
                    foreach ($this->getImportsClosure($fromGraphUri, $useAdditional) as $importedGraphUri) {
                        $queryObject->addFrom($importedGraphUri);
                    }
                }
            }
        }
        
        // if using accesss control, filter FROM (NAMED) for allowed models
        if ($options['use_ac'] === true) {
            if($queryObject instanceof Erfurt_Sparql_Query2 || $queryObject instanceof Erfurt_Sparql_Query2_Abstraction){
                //new way
                $queryObject = clone $queryObject; // we dont want to modify the query itself - could be used elsewhere

                $from_strings = array();
                foreach ($queryObject->getFroms() as $graphClause) {
                    $uri = $graphClause->getGraphIri()->getIri();
                    $from_strings[] = $uri;
                }

                $modelsFiltered = $this->_filterModels($from_strings);

                // query contained a non-allowed non-existent model
                if (empty($modelsFiltered)) {
                    return false;
                }

                $queryObject->setFroms($modelsFiltered);
            } else {
                $modelsFiltered = $this->_filterModels($queryObject->getFrom());

                // query contained a non-allowed non-existent model
                if (empty($modelsFiltered)) {
                    return false;
                }

                $queryObject->setFrom($modelsFiltered);
                // from named only if it was set
                $fromNamed = $queryObject->getFromNamed();
                if (count($fromNamed)) {
                    $queryObject->setFromNamed($this->_filterModels($fromNamed));
                }
            }
        }

        //queriing SparqlEngine or retrieving Result from QueryCache
        $resultFormat = $options['result_format'];
        $queryCache = Erfurt_App::getInstance()->getQueryCache();

        if (!($sparqlResult = $queryCache->load( (string) $queryObject, $resultFormat ))){
#           // TODO: check if adapter supports requested result format
            $startTime = microtime(true);
            $sparqlResult = $this->_backendAdapter->sparqlQuery($queryObject, $resultFormat);
            $duration = microtime(true) - $startTime;
            $queryCache->save( (string) $queryObject , $resultFormat, $sparqlResult, $duration );
        }
        return $sparqlResult;
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
        } else {
            return false;
        }
    }

    /**
     * Get the configuration for a graph.
     * @param string $graphUri to specity the graph
     * @return array 
     */
    public function getGraphConfiguration($graphUri)
    {
        if (null === $this->_graphConfigurations) {
            $config         = Erfurt_App::getInstance()->getConfig();
            $sysOntModelUri = $config->sysont->modelUri;
            
            // Fetch the graph configurations
            require_once 'Erfurt/Sparql/SimpleQuery.php';
            $queryObject = new Erfurt_Sparql_SimpleQuery();
            $queryObject->setProloguePart('SELECT ?s ?p ?o');
            $queryObject->setFrom(array($sysOntModelUri));
            $queryObject->setWherePart('WHERE { ?s ?p ?o . ?s a <http://ns.ontowiki.net/SysOnt/Model> }');

            $result = $this->sparqlQuery($queryObject, 
                array(
                    'use_ac' => false, 
                    'result_format' => 'extended',
                    'use_additional_imports' => false
                )
            );
        
            $stmtArray = array();
            foreach ($result['bindings'] as $row) {
                if (!isset($stmtArray[$row['s']['value']])) {
                    $stmtArray[$row['s']['value']] = array();
                }
                
                if (!isset($stmtArray[$row['s']['value']][$row['p']['value']])) {
                    $stmtArray[$row['s']['value']][$row['p']['value']] = array();
                }
                
                if ($row['o']['type'] === 'typed-literal') {
                    $row['o']['type'] = 'literal';
                }
                
                if (isset($row['o']['xml:lang'])) {
                    $row['o']['lang'] = $row['o']['xml:lang'];
                    unset($row['o']['xml:lang']);
                }
                
                $stmtArray[$row['s']['value']][$row['p']['value']][] = $row['o'];
            }
            
            $this->_graphConfigurations = $stmtArray;    
        }
        
        if (isset($this->_graphConfigurations[$graphUri])) {
            return $this->_graphConfigurations[$graphUri];
        } else {
            return array();
        }
    }

    /**
     * Returns a list of graph uris, where each graph in the list contains at least
     * one statement where the given resource uri is subject.
     * 
     * @param string $resourceUri
     * @return array
     */
    public function getGraphsUsingResource($resourceUri, $useAc = true)
    {
        if (method_exists($this->_backendAdapter, 'getGraphsUsingResource')) {
            $backendResult = $this->_backendAdapter->getGraphsUsingResource($resourceUri);
            
            if ($useAc) {
                $realResult = array();
                
                foreach ($backendResult as $graphUri) {
                    if ($this->isModelAvailable($graphUri, $useAc)) {
                        $realResult[] = $graphUri;
                    }
                }
                
                return $realResult;
            } else {
                return $backendResult;
            }
        }
        
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT DISTINCT ?graph')
              ->setWherePart('WHERE {GRAPH ?graph {<' . $resourceUri . '> ?p ?o.}}');
        
        $graphResult = array();
        $result = $this->sparqlQuery($query, array('use_ac' => $useAc));
          
        if ($result) {
            foreach ($result as $row) {
                $graphResult[] = $row['graph'];
            }
        }
        
        return $graphResult;
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
        foreach ($this->getAvailableModels(true) as $key => $true) {
            $allowedModels[] = $key;
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
        foreach ($this->getImportsClosure($modelIri) as $import) {
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

            require_once 'Erfurt/Sparql/SimpleQuery.php';
            $subSparql = Erfurt_Sparql_SimpleQuery::initWithString($subSparql);

            if (count($result = $this->_backendAdapter->sparqlQuery($subSparql)) < 1) {
                break;
            }
            
            $classes = array();
            foreach ($result as $row) {
                // $key = $inverse ? $row['child'] : $row['parent'];
                $key = $inverse ? $row['child'] : $row['parent'];
                $closure[$key] = array(
                    'node'   => $inverse ? $row['child'] : $row['parent'], 
                    'parent' => $inverse ? $row['parent'] : $row['child'], 
                    'depth'  => $i
                );
                $classes[] = $row['child'];
            }
        }
        
        // prepare start resources inclusion
        $merger = array();
        foreach ($startResources as $startUri) {
            $merger[(string) $startUri] = array(
                'node'   => $startUri, 
                'parent' => null, 
                'depth'  => 0
            );
        }
        
        // merge in start resources
        $closure = array_merge($merger, $closure);
        
        return $closure;
    }
}

