<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2011, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @category Erfurt
 * @package  Erfurt_Store
 * @author   Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author   Norman Heino <norman.heino@gmail.com>
 */

// ------------------------------------------------------------------------
// --- Macros ---------------------------------------------------
// ------------------------------------------------------------------------
define('STORE_RESULTFORMAT','result_format');
define('STORE_RESULTFORMAT_PLAIN','plain');
define('STORE_RESULTFORMAT_XML','xml');
define('STORE_RESULTFORMAT_EXTENDED','extended');
define('STORE_USE_AC','use_ac');
define('STORE_USE_OWL_IMPORTS','use_owl_imports');
define('STORE_USE_ADDITIONAL_IMPORTS','use_additional_imports');
define('STORE_TIMEOUT','timeout');

class Erfurt_Store
{
    // ------------------------------------------------------------------------
    // --- Public constants ---------------------------------------------------
    // ------------------------------------------------------------------------

    const COUNT_NOT_SUPPORTED = -1;

    /**
     * Literal type.
     * @var int
     */
    const TYPE_LITERAL = 1;

    /**
     * IRI type.
     * @var int
     */
    const TYPE_IRI = 2;

    /**
     * Balanknode type.
     * @var int
     */
    const TYPE_BLANKNODE = 3;

    /**
     * A proeprty for hiding resources.
     * @var string
     */
    const HIDDEN_PROPERTY = 'http://ns.ontowiki.net/SysOnt/hidden';

    /**
     * The maximum number of iterations for recursive operatiosn.
     * @var int
     */
    const MAX_ITERATIONS = 100;

    /**
     * RDF-S model identifier.
     * @var int
     */
    const MODEL_TYPE_RDFS = 501;

    /**
     * OWL model identifier.
     * @var int
     */
    const MODEL_TYPE_OWL = 502;

    // ------------------------------------------------------------------------
    // --- Protected Properties -----------------------------------------------
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
     * An RDF/PHP array containing additional configuration options for graphs
     * in the triple store. This information is stored in the local system
     * ontology.
     * @var array
     *
     */
    protected $_graphConfigurations = null;

    /**
     * Store options
     * @var array
     */
    protected $_options = array();

    /**
     * An Array holding the Namespace prefixes (An array of namespace IRIs (keys) and prefixes) for some models
     * @var array
     */
    protected $_prefixes = null;

    /**
     * Special zend logger, which protocolls all queries
     * Call with function to initialize
     * @var Zend Logger
     */
    protected $_queryLogger = null;

    /**
     * Special zend logger, which protocolls erfurt messages
     * Call with function to initialize
     * @var Zend Logger
     */
    protected $_erfurtLogger = null;

    protected $_bnodePrefix = 'nodeID:';

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

    private $_importsClosure = array();

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
     * @throws Erfurt_Store_Exception if store is not supported or store does not implement the store
     * adapter interface.
     */
    public function __construct($storeOptions, $backend, array $backendOptions = array(), $schema = null)
    {
        while (list($optionName, $optionValue) = each($storeOptions)) {
            $this->setOption($optionName, $optionValue);
        }

        if (isset($storeOptions['adapterInstance'])) {
            $this->_backendAdapter = $storeOptions['adapterInstance'];
            $this->_backendName = $backend;
            return;
        }

        // store connection settings for super admin id
        if (array_key_exists('username', $backendOptions)) {
            $this->_dbUser = $backendOptions['username'];
        }
        if (array_key_exists('password', $backendOptions)) {
            $this->_dbPass = $backendOptions['password'];
        }

        // build schema name
        $schemaName = $schema ? ucfirst($schema) : '';

        if ($backend === 'zenddb') {
            $this->_backendName = 'ZendDb';

            // Use Ef schema as default for the ZendDb backend
            if (null === $schema) {
                $schemaName = 'Ef';
            }
        } else {
            $this->_backendName = ucfirst($backend);
        }

        // backend file
        $fileName = 'Store/Adapter/'
                  . $schemaName
                  . $this->_backendName
                  . '.php';

        // backend class
        $className  = 'Erfurt_Store_Adapter_'
                    . $schemaName
                    . $this->_backendName;

        // import backend adapter file
        if (is_readable((EF_BASE . $fileName))) {
            require_once $fileName;
        } else {
            require_once 'Erfurt/Store/Exception.php';
            $msg = "Backend '$this->_backendName' "
                 . ($schema ? "with schema '$schemaName'" : "")
                 . " not supported. No suitable backend adapter found.";
            throw new Erfurt_Store_Exception($msg);
        }

        // check class existence
        if (!class_exists($className)) {
            require_once 'Erfurt/Store/Exception.php';
            $msg = "Backend '$this->_backendName' "
                 . ($schema ? "with schema '$schemaName'" : "")
                 . " not supported. No suitable backend adapter class found.";
            throw new Erfurt_Store_Exception($msg);
        }

        // instantiate backend adapter
        $this->_backendAdapter = new $className($backendOptions);

        // check interface conformance
        // but do not check the comparer adapter since we use __call there
        if ($backend != 'comparer') {
            if (!($this->_backendAdapter instanceof Erfurt_Store_Adapter_Interface)) {
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception('Adapter class must implement Erfurt_Store_Adapter_Interface.');
            }
        }
    }

    public function setBackendAdapter(Erfurt_Store_Adapter_Interface $adapter)
    {
        $this->_backendAdapter = $adapter;
        $this->_backendName = $adapter->getBackendName();
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
        if (defined('_EFDEBUG')) {
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->info('Store: adding multiple statements: ' . print_r($statementsArray, true));
        }

        // check whether model is available
        if (!$this->isModelAvailable($graphUri, $useAc)) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception('Model is not available.');
        }

        // check whether model is editable
        if (!$this->_checkAc($graphUri, 'edit', $useAc)) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception('No permissions to edit model.');
        }

        $this->_backendAdapter->addMultipleStatements($graphUri, $statementsArray);

        //invalidate deprecated Cache Objects
        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidateWithStatements($graphUri, $statementsArray );

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
     * @param array $object conaining keys "value", "type", "datatype", "lang"
     * @param bool $useAcl
     *
     * @throws Erfurt_Exception Throws an exception if adding of statements fails.
     */
    public function addStatement($graphUri, $subject, $predicate, $object, $useAcl = true)
    {
        // check whether model is available
        if ($useAcl && !$this->isModelAvailable($graphUri)) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception('Model is not available.');
        }

        // check whether model is editable
        if ($useAcl && !$this->_checkAc($graphUri, 'edit')) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception('No permissions to edit model.');
        }

        $this->_backendAdapter->addStatement($graphUri, $subject, $predicate, $object);

        //invalidate deprecateded Cache Objects
        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidate( $graphUri, $subject , $predicate, $object );

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

    /**
     * Checks whether the store has been set up yet and imports system
     * ontologies if necessary.
     */
    public function checkSetup()
    {
        $logger         = Erfurt_App::getInstance()->getLog();
        $sysOntSchema   = $this->getOption('schemaUri');
        $schemaLocation = $this->getOption('schemaLocation');
        $schemaPath     = preg_replace('/[\/\\\\]/', '/', EF_BASE . $this->getOption('schemaPath'));
        $sysOntModel    = $this->getOption('modelUri');
        $modelLocation  = $this->getOption('modelLocation');
        $modelPath      = preg_replace('/[\/\\\\]/', '/', EF_BASE . $this->getOption('modelPath'));

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
                    // load SysOnt Model from file
                    $this->importRdf($sysOntModel, $modelPath, 'rdfxml',
                            Erfurt_Syntax_RdfParser::LOCATOR_FILE, false);
                } else {
                    // load SysOnt Model from Web
                    $this->importRdf($sysOntModel, $modelLocation, 'rdfxml',
                            Erfurt_Syntax_RdfParser::LOCATOR_URL, false);
                }
            } catch (Erfurt_Exception $e) {
                // clear query cache completly
                $queryCache = Erfurt_App::getInstance()->getQueryCache();
                $queryCache->cleanUpCache(array('mode' => 'uninstall'));
                // Delete the model, for the import failed.
                $this->_backendAdapter->deleteModel($sysOntModel);
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception("Import of '$sysOntModel' failed -> " . $e->getMessage());
            }

            if (!$this->isModelAvailable($sysOntModel, false)) {
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception('Unable to load System Ontology model.');
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
                // TODO: Create a exception for too many matching values
                // In this case we log without storing the payload. No rollback supported for such actions.
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
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception('Model is not available.');
        }

        // check whether model is editable
        if (!$this->_checkAc($graphUri, 'edit')) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception('No permissions to edit model.');
        }

        $this->_backendAdapter->deleteMultipleStatements($graphUri, $statementsArray);

        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidateWithStatements($graphUri, $statementsArray);

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
            if (($modelIri !== $this->getOption('modelUri')) && ($modelIri !== $this->getOption('schemaUri'))) {
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
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception("Model <$modelIri> cannot be exported. Model is not available.");
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
    public function getSearchPattern($stringSpec, $graphUris, $options = array())
    {

        // TODO stringSpec should be more than simple string (parse for and/or/xor etc...)
        $stringSpec = (string) $stringSpec;

        $options = array_merge(array(
            'case_sensitive'    => false,
            'filter_classes'    => false,
            'filter_properties' => false,
            'with_imports'      => true
        ), $options);

        // execute backend-specific search if available
        if (method_exists($this->_backendAdapter, 'getSearchPattern'))
        {
            return $this->_backendAdapter->getSearchPattern($stringSpec, $graphUris, $options);
        }
        // else execute Sparql Regex Fallback
        else {
            $ret = array();

            $s_var = new Erfurt_Sparql_Query2_Var('resourceUri');
            $p_var = new Erfurt_Sparql_Query2_Var('p');
            $o_var = new Erfurt_Sparql_Query2_Var('o');

            $default_tpattern = new Erfurt_Sparql_Query2_Triple($s_var, $p_var, $o_var);
            $ret[] = $default_tpattern;



            $filter = new Erfurt_Sparql_Query2_Filter(
                new Erfurt_Sparql_Query2_ConditionalOrExpression(
                    array(
                        /*new Erfurt_Sparql_Query2_Regex(
                            $s_var,
                            new Erfurt_Sparql_Query2_RDFLiteral($stringSpec),
                            $options['case_sensitive'] ? null : new Erfurt_Sparql_Query2_RDFLiteral('i')
                        ),*/
                        new Erfurt_Sparql_Query2_Regex(
                            $o_var,
                            new Erfurt_Sparql_Query2_RDFLiteral($stringSpec),
                            $options['case_sensitive'] ? null : new Erfurt_Sparql_Query2_RDFLiteral('i')
                        )
                    )
                )
            );
            if ($options['filter_properties']) {
                $ss_var = new Erfurt_Sparql_Query2_var('ss');
                $oo_var = new Erfurt_Sparql_Query2_var('oo');

                $filterprop_tpattern = new Erfurt_Sparql_Query2_Triple($ss_var, $s_var, $oo_var);
                $ret[] = $filterprop_tpattern;
                /*
                $filter->getConstraint()->addElement(
                    new Erfurt_Sparql_Query2_Regex(
                            $oo_var,
                            new Erfurt_Sparql_Query2_RDFLiteral($stringSpec),
                            $options['case_sensitive'] ? null : new Erfurt_Sparql_Query2_RDFLiteral('i')
                        )
                );*/
            }
            $ret[] = $filter;

            return $ret;

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
                $graphConfig    = $this->getGraphConfiguration($graphUri);
                $hiddenProperty = $this->getOption('propertiesHidden');

                if (isset($graphConfig[$hiddenProperty])) {
                    $hidden = current($graphConfig[$hiddenProperty]);
                    if ((boolean)$hidden['value']) {
                        unset($models[$graphUri]);
                    }
                }
            }
        }

        return $models;
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

    public function getImportsClosure($modelIri, $withHiddenImports = true, $useAC = true)
    {
        if (array_key_exists($modelIri, $this->_importsClosure)) {
            return $this->_importsClosure[$modelIri];
        }

        if ($this->_backendName == "Virtuoso") {
            $objectCache = Erfurt_App::getInstance()->getCache();
            $importsClosure = null;
            $importsClosureKey = "ImportsClosure_".(md5($modelIri));
            $importsClosure = $objectCache->load($importsClosureKey);
            if (is_array($importsClosure)) {
                //nothing ToDo
            } else {
                $queryCache = Erfurt_App::getInstance()->getQueryCache();
                $queryCache->startTransaction($importsClosureKey);
                $importsClosure = $this->_getImportsClosure($modelIri, $withHiddenImports, $useAC);
                $queryCache->endTransaction($importsClosureKey);
                $objectCache->save($importsClosure, $importsClosureKey);
            }
        } else {
            $importsClosure = $this->_getImportsClosure($modelIri, $withHiddenImports, $useAC);
        }

        $this->_importsClosure[$modelIri] = $importsClosure;
        return $importsClosure;
    }



    /**
     * Recursively gets owl:imported model IRIs starting with $modelIri as root.
     *
     * @param string $modelIri
     */
    private function _getImportsClosure($modelIri, $withHiddenImports = true, $useAC = true)
    {
        $currentLevel = $this->_backendAdapter->getImportsClosure($modelIri);
        if($currentLevel == array($modelIri)) {
            return $currentLevel;
        }
        if ($withHiddenImports === true) {
            $importsUri = $this->getOption('propertiesHiddenImports');

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
     * @throws Erfurt_Store_Exception if the requested model is not available.
     * @return Erfurt_Rdf_Model Returns an instance of Erfurt_Rdf_Model or one of its subclasses.
     */
    public function getModel($modelIri, $useAc = true)
    {
        // check whether model exists and is visible
        if (!$this->isModelAvailable($modelIri, $useAc)) {
            $systemModelUri  = $this->getOption('modelUri');
            $systemSchemaUri = $this->getOption('schemaUri');

            // check whether requested model is one of the schema models
            if (!$useAc && (($modelIri === $systemModelUri) || ($modelIri === $systemSchemaUri))) {
                try {
                    $this->checkSetup();
                } catch (Erfurt_Store_Exception $e) {
                    if ($e->getCode() === 20) {
                        // Everything is fine, system models now imported
                    } else {
                        require_once 'Erfurt/Store/Exception.php';
                        throw new Erfurt_Store_Exception('Check setup failed: ' . $e->getMessage());
                    }
                }

                // still not available?
                if (!$this->isModelAvailable($modelIri, $useAc)) {
                    require_once 'Erfurt/Store/Exception.php';
                    throw new Erfurt_Store_Exception("Model '$modelIri' is not available.");
                }
            } else {
                require_once 'Erfurt/Store/Exception.php';
                throw new Erfurt_Store_Exception("Model '$modelIri' is not available.");
            }
        }

        // if backend adapter provides its own implementation
        if (method_exists($this->_backendAdapter, 'getModel')) {
            // … use it
            $modelInstance = $this->_backendAdapter->getModel($modelIri);
        } else {
            // use generic implementation
            $owlQuery = new Erfurt_Sparql_SimpleQuery();
            $owlQuery->setProloguePart('ASK')
                     ->addFrom($modelIri)
                     ->setWherePart('{<' . $modelIri . '> <' . EF_RDF_NS . 'type> <' . EF_OWL_ONTOLOGY . '>.}');

            // TODO: cache this
            if ($this->sparqlAsk($owlQuery, $useAc)) {
                // instantiate OWL model
                require_once 'Erfurt/Owl/Model.php';
                $modelInstance = new Erfurt_Owl_Model($modelIri);
            } else {
                // instantiate RDF-S model
                require_once 'Erfurt/Rdfs/Model.php';
                $modelInstance = new Erfurt_Rdfs_Model($modelIri);
            }
        }

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
     * @throws Erfurt_Store_Exception
     *
     * @return Erfurt_Rdf_Model
     */
    public function getNewModel($modelIri, $baseIri = '', $type = Erfurt_Store::MODEL_TYPE_OWL, $useAc = true)
    {
        // check model availablity
        if ($this->isModelAvailable($modelIri, false)) {
            // if debug mode is enabled create a more detailed exception description. If debug mode is disabled the
            // user should not know why this fails.
            require_once 'Erfurt/Store/Exception.php';
            $message = defined('_EFDEBUG')
                     ? 'Failed creating the model. Reason: A model with the same URI already exists.'
                     : 'Failed creating the model.';
            throw new Erfurt_Store_Exception($message);
        }

        // check action access
        if ($useAc && !Erfurt_App::getInstance()->isActionAllowed('ModelManagement')) {
            require_once 'Erfurt/Store/Exception.php';
            throw new Erfurt_Store_Exception("Failed creating the model. Action not allowed!");
        }

        try {
            $this->_backendAdapter->createModel($modelIri, $type);
        } catch (Erfurt_Store_Adapter_Exception $e) {
            require_once 'Erfurt/Store/Exception.php';
            $message = defined('_EFDEBUG')
                     ? "Failed creating the model. \nReason: {$e->getMessage()}."
                     : 'Failed creating the model.';
            throw new Erfurt_Store_Exception($message);
        }

        // everything ok, create new model
        // no access control since we have already checked
        return $this->getModel($modelIri, $useAc);
    }

    /**
     * Returns inferred objects in realation to a certain set of resources.
     *
     * Returned objects are related to objects in the closure of start resources.
     * Said closure is calculated using hte closure property. If no closure
     * property is specified, the object property is used instead.
     *
     * @todo Implement generic version and call backend implementation if applicable.
     */
    public function getObjectsInferred($modelUri, $startResources, $objectProperty, $closureProperty = null)
    {
    }

    /**
     * Returns a specified config option.
     *
     * @param string $optionName
     * @return string
     */
    public function getOption($optionName)
    {
        if (isset($this->_options[$optionName])) {
            return $this->_options[$optionName];
        }

        return null;
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
            'rdfjson'   => 'RDF/JSON (Talis)',
            'ttl'       => 'Turtle'
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

        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidateWithModelIri($modelIri);

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
                $headers['Location'] = true;

                // set default content-type header
                stream_context_get_default(array(
                    'http' => array(
                        'header' => 'Accept: application/rdf+xml, application/json, text/rdf+n3, text/plain',
                        'max_redirects' => 1 // no redirects as we need the 303 URI
                )));

                do { // follow redirects
                    $flag       = false;
                    $isRedirect = false;
                    $headers    = @get_headers($data, 1);

                    if (is_array($headers)) {
                        $http = $headers[0];

                        if (false !== strpos($http, '303')) {
                            $data = (string)$headers['Location'];
                            $isRedirect = true;
                        }
                    }
                } while ($isRedirect);

                // restore default empty headers
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
                    } else {
                        // RDF/XML is default
                        $type = 'rdfxml';
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
     * Sets store options.
     *
     * @param string $optionName
     * @param string|array $optionValue
     */
    public function setOption($optionName, $optionValue)
    {
        if (is_string($optionValue)) {
            $this->_options[$optionName] = $optionValue;
        } else if (is_array($optionValue)) {
            while (list($subName, $subValue) = each($optionValue)) {
                $subOptionName = $optionName
                               . ucfirst($subName);
                $this->setOption($subOptionName, $subValue);
            }
        }
    }

    /**
     * check and manipulate the declared FROMs according to the access control
     */
    protected function _prepareQuery($queryObject, &$options = array()){
        // if ($queryObject instanceof Erfurt_Sparql_Query2)
        //     Erfurt_App::getInstance()->getLog()->info('Store: evaluating a Query2-object (sparql:'."\n".$queryObject.') ');

        $defaultOptions = array(
            STORE_RESULTFORMAT           => STORE_RESULTFORMAT_PLAIN,
            STORE_USE_AC                 => true,
            STORE_USE_OWL_IMPORTS        => true,
            STORE_USE_ADDITIONAL_IMPORTS => true
        );
        $options = array_merge($defaultOptions, $options);
        $noBindings = false;

        //typechecking
        if (is_string($queryObject)) {
            require_once 'Erfurt/Sparql/SimpleQuery.php';
            $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($queryObject);
        }
        if (!($queryObject instanceof Erfurt_Sparql_Query2 || $queryObject instanceof Erfurt_Sparql_SimpleQuery)) {
            throw new Exception("Argument 1 passed to Erfurt_Store::sparqlQuery must be instance of Erfurt_Sparql_Query2, Erfurt_Sparql_SimpleQuery or string", 1);
        }

        if($options[STORE_USE_AC] == false){
            return $queryObject;
        }

        /*
         * clone the Query2 Object to not modify the original one
         * could be used elsewhere, could have side-effects
         */
        if ($queryObject instanceof Erfurt_Sparql_Query2) { //always clone?
            $queryObject = clone $queryObject;
        }

        //get all models
        $all = array();
        $allpre = $this->_backendAdapter->getAvailableModels(); //really all (without ac)
        foreach ($allpre as $key => $true) {
            $all[] = array('uri' => $key, 'named' => false);
        }

        //get available models (readable)
        $available = array();
        if ($options[STORE_USE_AC] === true) {
            $availablepre = $this->getAvailableModels(true);
            foreach ($availablepre as $key => $true) {
                $available[] = array('uri' => $key, 'named' => false);
            }
        } else {
            $available = $all;
        }

        // examine froms (for access control and imports) in 5 steps
        // 1. extract froms for easier handling
        $froms = array();
        if ($queryObject instanceof Erfurt_Sparql_Query2) {
            foreach ($queryObject->getFroms() as $graphClause) {
                $uri = $graphClause->getGraphIri()->getIri();
                $froms[] = array('uri' => $uri, 'named' => $graphClause->isNamed());
            }
        } else { //SimpleQuery
            foreach ($queryObject->getFrom() as $graphClause) {
                $froms[] = array('uri' => $graphClause, 'named' => false);
            }
            foreach ($queryObject->getFromNamed() as $graphClause) {
                $froms[] = array('uri' => $graphClause, 'named' => true);
            }
        }

        // 2. no froms in query -> froms = availableModels
        if (empty($froms)) {
            $froms = $available;
        }

        // 3. filter froms by availability and existence - if filtering deletes all -> give empty result back
        if ($options[STORE_USE_AC] === true) {
            $froms = $this->_maskModelList($froms, $available);
            if (empty($froms)) {
                $noBindings = true;
            }
        }

        // 4. get import closure for every remaining from
        if ($options[STORE_USE_OWL_IMPORTS] === true) {
            foreach ($froms as $from) {
                $importsClosure = $this->getImportsClosure($from['uri'], $options[STORE_USE_ADDITIONAL_IMPORTS], $options[STORE_USE_AC]);
                foreach ($importsClosure as $importedGraphUri) {
                    $addCandidate = array('uri' => $importedGraphUri, 'named' => false);
                    if (in_array($addCandidate, $available) && array_search($addCandidate, $froms) === false) {
                        $froms[] = $addCandidate;
                    }
                }
            }
        }

        // 5. put froms back
        if ($queryObject instanceof Erfurt_Sparql_Query2) {
            $queryObject->setFroms(array());
            foreach ($froms as $from) {
                $queryObject->addFrom($from['uri'], $from['named']);
            }
        } else {
             $queryObject->setFrom(array());
             $queryObject->setFromNamed(array());
             foreach ($froms as $from) {
                if (!$from['named']) {
                    $queryObject->addFrom($from['uri']);
                } else {
                    $queryObject->addFromNamed($from['uri']);
                }
            }
        }

       // if there were froms and all got deleted due to access controll - give back empty result set
       // this is achieved by replacing the where-part with an unsatisfiable one
       // i think this is efficient because otherwise we would have to deal with result formating und variables
       if ($noBindings) {
            if ($queryObject instanceof Erfurt_Sparql_SimpleQuery) {
                $queryObject->setWherePart('{FILTER(false)}');
            } else if ($queryObject instanceof Erfurt_Sparql_Query2) {
                $ggp = new Erfurt_Sparql_Query2_GroupGraphPattern();
                $ggp->addFilter(false); //unsatisfiable
                $queryObject->setWhere($ggp);
            }
        }
        return $queryObject;
    }

    /**
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $modelIri
     * @param string $askSparql
     * @param boolean $useAc Whether to check for access control.
     */
    public function sparqlAsk($queryObject, $useAc = true)
    {
        $options = array( STORE_USE_AC => $useAc);
        $queryObject = $this->_prepareQuery($queryObject, $options);

        //query from query cache
        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $sparqlResult = $queryCache->load( (string) $queryObject, 'plain');
        if ($sparqlResult == Erfurt_Cache_Frontend_QueryCache::ERFURT_CACHE_NO_HIT ){
            // TODO: check if adapter supports requested result format
            $startTime = microtime(true);
            $sparqlResult = $this->_backendAdapter->sparqlAsk((string) $queryObject);
            self::$_queryCount++;
            $duration = microtime(true) - $startTime;
            $queryCache->save( (string) $queryObject, 'plain' , $sparqlResult, $duration);
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
        $queryObject = $this->_prepareQuery($queryObject, $options);

        //querying SparqlEngine or retrieving Result from QueryCache
        $resultFormat = $options[STORE_RESULTFORMAT];
        $queryCache = Erfurt_App::getInstance()->getQueryCache();

        $queryString = (string)$queryObject;
        $replacements = 0;
        $queryString = str_replace($this->_bnodePrefix, $this->_backendAdapter->getBlankNodePrefix(), $queryString, $replacements);

        $sparqlResult = $queryCache->load($queryString, $resultFormat );
        if ($sparqlResult == Erfurt_Cache_Frontend_QueryCache::ERFURT_CACHE_NO_HIT) {
            // TODO: check if adapter supports requested result format
            $startTime = microtime(true);
            $sparqlResult = $this->_backendAdapter->sparqlQuery($queryString, $options);
            //check for the correct format
            if($resultFormat == STORE_RESULTFORMAT_EXTENDED && !isset($sparqlResult['results']['bindings'])){
                if(isset($sparqlResult['bindings'])){
                    //fix it if possible
                    $sparqlResult['results'] = array();
                    $sparqlResult['results']['bindings'] = $sparqlResult['bindings'];
                } else {
                    //var_dump($sparqlResult);
                    require_once 'Erfurt/Store/Exception.php';
                    throw new Erfurt_Store_Exception('invalid query result.');
                }
            }

            self::$_queryCount++;
            $duration = microtime(true) - $startTime;
            if (defined('_EFDEBUG')) {
                $logger = $this->_getQueryLogger();

                if ($duration > 1) {
                    $slow = " WARNING SLOW ";
                } else {
                    $slow = "";
                }

                $logger->debug("SPARQL *****************" . round((1000 * $duration),2) . " msec " . $slow . "\n" . $queryObject);
            }
            $queryCache->save( (string) $queryObject , $resultFormat, $sparqlResult, $duration );
        }
        return $sparqlResult;
    }

    /**
     * Executes a SQL query with a SQL-capable backend.
     *
     * @param string $sqlQuery A string containing the SQL query to be executed.
     * @throws Erfurt_Store_Exception
     * @return array
     */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        if ($this->_backendAdapter instanceof Erfurt_Store_Sql_Interface) {
            $startTime = microtime(true);
            $result = $this->_backendAdapter->sqlQuery($sqlQuery, $limit, $offset);
            $duration = microtime(true) - $startTime;
            if (defined('_EFDEBUG')) {
                $logger = $this->_getQueryLogger();
                $logger->debug("SQL ***************** ".round((1000 * $duration),2)." msec \n". $sqlQuery);
            }
            return $result;
        }

        // TODO: will throw an exception
        // require_once 'Erfurt/Store/Exception.php';
        // throw new Erfurt_Store_Exception('Current backend doesn not support SQL queries.');
    }

    /**
     * Get the configuration for a graph.
     * @param string $graphUri to specity the graph
     * @return array
     */
    public function getGraphConfiguration($graphUri)
    {
        if (null === $this->_graphConfigurations) {
            $sysOntModelUri = $this->getOption('modelUri');

            // Fetch the graph configurations
            require_once 'Erfurt/Sparql/SimpleQuery.php';
            $queryObject = new Erfurt_Sparql_SimpleQuery();
            $queryObject->setProloguePart('SELECT ?s ?p ?o');
            $queryObject->setFrom(array($sysOntModelUri));
            $queryObject->setWherePart('WHERE { ?s ?p ?o . ?s a <http://ns.ontowiki.net/SysOnt/Model> }');

            $queryoptions = array(
                'use_ac'                 => false,
                'result_format'          => STORE_RESULTFORMAT_EXTENDED,
                'use_additional_imports' => false
            );

            $stmtArray = array();
            if ($result = $this->sparqlQuery($queryObject, $queryoptions)) {
                $result = $result['results'];
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
            }

            $this->_graphConfigurations = $stmtArray;
        }

        if (isset($this->_graphConfigurations[$graphUri])) {
            return $this->_graphConfigurations[$graphUri];
        }

        return array();
    }

    // ------------------------------------------------------------------------
    // --- Optional Methods ---------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Counts all statements that match the SPARQL graph pattern $whereSpec.
     *
     * @param string $graphUri
     * @param string $whereSpec
     * @param string $countSpec
     * @param boolean $distinct
     * @param boolean $followImports - use importsClosure or not
     */
    public function countWhereMatches($graphIri, $whereSpec, $countSpec, $distinct = false, $followImports = true)
    {
        // unify parameters
        if (trim($countSpec[0]) !== '?') {
            // TODO: support $
            $countSpec = '?' . $countSpec;
        }

        if (method_exists($this->_backendAdapter, 'countWhereMatches')) {
            if ($this->isModelAvailable($graphIri)) {
                // use the imports closure per default (use 5th parameter to disable this)
                if ($followImports === true) {
                    $graphIris = array_merge($this->getImportsClosure($graphIri), array($graphIri));
                } else {
                    $graphIris = array($graphIri);
                }
                return $this->_backendAdapter->countWhereMatches($graphIris, $whereSpec, $countSpec, $distinct);
            } else {
                throw new Erfurt_Store_Exception('Model <' . $graphIri . '> is not available.');
            }
        } else {
            throw new Erfurt_Store_Exception('Count is not supported by backend.');
        }
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
     * Returns the currently used backend.
     *
     * @return Erfurt_Store_Adapter_Interface
     */
    public function getBackendAdapter()
    {
        return $this->_backendAdapter;
    }

    /**
     * Returns a list of graph URIs, where each graph in the list contains at least
     * one statement where the given resource URI is used as a subject.
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

    // ------------------------------------------------------------------------
    // --- Protected Methods --------------------------------------------------
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
            $logger = $this->_getErfurtLogger();
            $logger->warn("Store.php->_checkAc: Doing something without Access Controll!!!");
            $logger->debug("Store.php->_checkAc: ModelIri: " . $modelIri . " accessType: " . $accessType);
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

        return array_intersect($modelIris, $allowedModels);
    }


    /**
     * This function is nearly like _filterModels, but you specify the mask and
     * the list parameter is an 2D-Array of the format:
     * array(
     *     array('uri' => 'http://the.model.uri/1', 'names' => boolean),
     *     array('uri' => 'http://the.model.uri/2', 'names' => boolean),
     *     ...
     * )
     * while in _filterModels the list is a plain list of uris.
     * We need this function because array_intersect doesn't work on 2D-Arrays.
     * @param array $list a 2D-Array where the uris are available with $list[<index>]['uri']
     * @param array $maskIn the mask to apply on the list of the same format as the list
     * @return array the list witout uri missing in $maskIn
     */
    private function _maskModelList (array $list, array $maskIn = null) {
        $mask = array();
        if ($maskIn === null) {
            foreach ($this->getAvailableModels(true) as $key => $true) {
                $mask[] = $key;
            }
        } else {

            $countMaskIn = count($maskIn);
            for ($i = 0; $i < $countMaskIn; ++$i) {
                $mask[] = $maskIn[$i]['uri'];
            }
        }

        $countList = count($list);
        for ($i = 0; $i < $countList; ++$i) {
            if (array_search($list[$i]['uri'], $mask) === false) {
                // TODO: check if this maybe skips indices ...
                unset($list[$i]);
            }
        }
        return $list;
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
                    ' . $where . ' OPTIONAL {?child <http://ns.ontowiki.net/SysOnt/order> ?order}
                    FILTER (
                        sameTerm(?parent, <' . implode('>) || sameTerm(?parent, <', $classes) . '>)
                    )
                }
                ORDER BY ASC(?order)';

            require_once 'Erfurt/Sparql/SimpleQuery.php';
            $subSparql = Erfurt_Sparql_SimpleQuery::initWithString($subSparql);

            // get sub items
            $result = $this->_backendAdapter->sparqlQuery($subSparql, array(STORE_RESULTFORMAT => STORE_RESULTFORMAT_PLAIN));

            // break on first empty result
            if (empty($result)) {
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

    /**
     * Returns the query logger, lazy initialization
     *
     * @return object Zend Logger, which writes to logs/queries.log
     */
    protected function _getQueryLogger(){
        if(null === $this->_queryLogger){
            $this->_queryLogger =  Erfurt_App::getInstance()->getLog('queries');
        }
        return $this->_queryLogger;
    }

    /**
     * Returns the erfurt logger, lazy initialization
     *
     * @return object Zend Logger, which writes to logs/erfurt.log
     */
    protected function _getErfurtLogger(){
        if(null === $this->_erfurtLogger){
            $this->_erfurtLogger =  Erfurt_App::getInstance()->getLog('erfurt');
        }
        return $this->_erfurtLogger;
    }
}
