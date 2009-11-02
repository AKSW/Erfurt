<?php
require_once 'Erfurt/Sparql/SimpleQuery.php';
require_once 'Erfurt/Store/Adapter/Interface.php';
require_once 'Erfurt/Store/Sql/Interface.php';

/**
 * Erfurt RDF Store – Virtuoso Adapter
 *
 * Connects to a Virtuoso Universal Server via ODBC, therefore
 * requiring PHP to be compiled with the ODBC extension.
 *
 * @package erfurt
 * @subpackage    store
 * @author     Norman Heino <norman.heino@gmail.com>
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: Virtuoso.php 4317 2009-10-17 15:36:10Z norman.heino $
 */
class Erfurt_Store_Adapter_Virtuoso implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    /** 
     * ODBC connection id 
     * @var int
     */
    private $_connection = null;
    
    /** 
     * Are transactions active
     * @var boolean
     */
    private $_transactions = false;
    
    /**
     * Graph URIs internally used by Virtuoso
     * @var array 
     */
    private $_virtuosoSpecialModels = array(
        'http://www.openlinksw.com/schemas/virtrdf#', 
        'http://localhost:8890/DAV'
    );
    
    /**
     * Properties for graph titles
     * @var array 
     */
    private $_titleProperties = array(
        'http://www.w3.org/2000/01/rdf-schema#label', 
        'http://purl.org/dc/elements/1.1/title'
    );
    
    /**
     * Graph cache
     * @var array
     */
    private $_models = null;
    
    /** 
     * An array of languages used in the store 
     * @var array
     */
    private $_languages = array();
    
    /**
     * Special treatment of long column data (e. g. XML results)
     * @var boolean
     */    
    private $_longRead = false;
    
    /**
     * An array of languages appearing in
     * each model.
     * @var array
     */
    private $_modelLanguages = array();
    

    /**
     * Configuration options for HTTP access to Virtuoso.
     * The following keys are recognized:
     * - use_http
     * - username
     * - password
     * - endpoint_uri
     * - dav_folder
     * @var array
     */
    private $_httpConfig = array();

    /**
     * Caching array for imported model IRIs.
     * Format: array(<model IRI> => array(<imported IRI>, ...))
     * @var array
     */
    private $_importedModels = array();
    
    
    /**
     * Debug flag, if enabled all SPARQL queries 
     * are echo'ed.
     * @var boolean
     */
    private $_debugQueries = false;
 
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Constructor
     *
     * @throws Erfurt_Exception
     */
    public function __construct($adapterOptions = array()) 
    {    
        $dsn      = $adapterOptions['dsn'];
        $username = $adapterOptions['username'];
        $password = $adapterOptions['password'];
        
        if (isset($adapterOptions['useHTTP']) && (boolean)$adapterOptions['useHTTP']) {
            $this->_httpConfig['use_http']     = true; 
            $this->_httpConfig['username']     = $username;    
            $this->_httpConfig['password']     = $password;   
            $this->_httpConfig['endpoint_uri'] = $adapterOptions['endpointURI'];  
            $this->_httpConfig['dav_folder']   = $adapterOptions['davFolder'];    
         } else {
            $this->_httpConfig['use_http'] = false;    
         }
        
        if (!function_exists('odbc_connect')) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Virtuoso adapter requires PHP ODBC extension to be loaded.');
            exit;
        }
        
        // try to connect using the php plugin security if possible
        if (function_exists('__virt_internal_dsn')) {
            $this->_connection = @odbc_connect(__virt_internal_dsn(), null, null);
        } else {
             // try to connect normally
            $this->_connection = @odbc_connect($dsn, $username, $password);
        }
        
        if (null == $this->_connection) {
            $msg = 'Unable to connect to Virtuoso Universal Server via ODBC: ' 
                 . $this->_getLastError();
            
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception($msg);
            exit;
        }
        
        // load title properties for model titles
        $config = Erfurt_App::getInstance()->getConfig();
        if (isset($config->properties->title)) {
            $this->_titleProperties = $config->properties->title->toArray();
        }
        
        // $result = $this->_execSql('SELECT DISTINCT rl_id FROM DB.DBA.RDF_LANGUAGE');
        // while (odbc_fetch_row($result)) {
        //     $this->_languages[] = odbc_result($result, 1);
        // }
    }
    
    /**
     * Destructor
     *
     * @throws Erfurt_Exception
     */
    public function __destruct() 
    {
        // check for ongoing transactions
        if ($this->_transactions) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Cannot close the connection while tranactions are open.');
        }
        
        // close connection
        @odbc_close($this->_connection);
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function addMultipleStatements($graphIri, array $statementsArray, array $options = array())
    {
        $insertSparql = sprintf(
            'INSERT INTO GRAPH <%s> {%s}', 
            $graphIri, 
            $this->buildTripleString($statementsArray));
        
        if (defined('_EFDEBUG')) {
            $log = Erfurt_App::getInstance()->getLog();
            $log->debug('Add mutliple statements query: ' . PHP_EOL . $insertSparql);
        }
        
        return $this->_execSparql($insertSparql);
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function addStatement($graphIri, $subject, $predicate, $objectSpec, array $options = array())
    {
        if ($objectSpec['type'] == 'uri') {
            $object = '<' . $objectSpec['value'] . '>';
        } else {
            $datatype = isset($objectSpec['datatype']) ? $objectSpec['datatype'] : null;
            $lang     = isset($objectSpec['lang']) ? $objectSpec['lang'] : null;
            $object   = $this->buildLiteralString($objectSpec['value'], $datatype, $lang);
        }
        
        // TODO: support blank nodes as subject
        $insertSparql = '
            INSERT INTO GRAPH <' . $graphIri . '> {
                <' . $subject . '> <' . $predicate . '> ' . $object . '
            }';
        
        return $this->_execSparql($insertSparql);
    }
    
    /**
     * Builds a SPARQL-compatible literal string with long literals if necessary.
     */
    public function buildLiteralString($value, $datatype = null, $lang = null)
    {
        $longLiteral    = false;
        $value          = (string) $value;
        $quoteChar      = (strpos($value, '"') !== false) ? "'" : '"';
        $languageString = null;
        
        switch ($datatype) {
            case 'http://www.w3.org/2001/XMLSchema#boolean':
                $search  = array('0', '1');
                $replace = array('false', 'true');
                $value   = str_replace($search, $replace, $value);
                break;
            case '':
            case null:
            case 'http://www.w3.org/2001/XMLSchema#string':
                $value = addcslashes($value, $quoteChar);
                
                /** 
                 * Check for characters not allowed in a short literal
                 * {@link http://www.w3.org/TR/rdf-sparql-query/#rECHAR}
                 */
                if (preg_match('/[\t\b\n\r\f\\\"\\\']/', $value) > 0) {
                    $longLiteral = true;
                }
            break;
        }
        
        $value = $quoteChar . ($longLiteral ? ($quoteChar . $quoteChar) : '')
               . $value 
               . $quoteChar . ($longLiteral ? ($quoteChar . $quoteChar) : '');
        
        if (!empty($datatype)) {
            $value .= '^^' . '<' . (string) $datatype . '>';
        } else if (!empty($lang)) {
            $value .= '@' . (string) $lang;
        }
        
        return $value;
    }
    
    /**
     * Builds a string of triples in N-Triples syntax out of an RDF/PHP array.
     *
     * @param $rdfPhpStatements A nested statement array
     * @return string
     */
    public function buildTripleString(array $rdfPhpStatements)
    {
        $triples = '';
        
        foreach ($rdfPhpStatements as $currentSubject => $predicates) {
            foreach ($predicates as $currentPredicate => $objects) {
                foreach ($objects as $currentObject) {
                    // TODO: blank nodes
                    $resource = '<' . trim($currentSubject) . '>';
                    $property = '<' . trim($currentPredicate) . '>';
                    
                    if ($currentObject['type'] == 'uri') {
                        $value = '<' . $currentObject['value'] . '>';
                    } else {
                        $value = $this->buildLiteralString(
                            $currentObject['value'], 
                            array_key_exists('datatype', $currentObject) ? $currentObject['datatype'] : null, 
                            array_key_exists('lang', $currentObject) ? $currentObject['lang'] : null
                        );
                    }
                    
                    // add triple
                    $triples .= sprintf('%s %s %s . %s', $resource, $property, $value, PHP_EOL);
                }
            }
        }
        
        return $triples;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function countWhereMatches($graphIris, $whereSpec, $countSpec)
    {
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart("SELECT COUNT DISTINCT $countSpec")
              ->setFrom($graphIris)
              ->setWherePart($whereSpec);
        
        if ($result = $this->sparqlQuery($query)) {
            $count = (int) $result[0]['callret-0'];
            
            return $count;
        }
        
        return 0;
    }
    
    /** @see Erfurt_Store_Sql_Interface */
    public function createTable($tableName, array $columns)
    {
        $colSpecs = array();

        // Virtuoso-specific replacings
        $replace = array(
            'AUTO_INCREMENT' => 'IDENTITY', 
            'LONGTEXT'       => 'LONG VARCHAR'
        );
        
        foreach ($columns as $columnName => $columnSpec) {
            $colSpecs[] = PHP_EOL
                        .  ' "' . $columnName . '" '
                        .  str_ireplace(array_keys($replace), array_values($replace), $columnSpec);
        }
        
        $createTable = 'CREATE TABLE ' . (string) $tableName . ' (' . implode(',', $colSpecs) . PHP_EOL . ')';
    
        return $this->sqlQuery($createTable);
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, array $options = array())
    {        
        $subjectSpec   = $subject   ? '<' . $subject . '>'   : '?s';
        $predicateSpec = $predicate ? '<' . $predicate . '>' : '?p';
        
        if (null !== $object) {
            if ($object['type'] == 'uri') {
                $objectSpec = '<' . $object['value'] . '>';
            } else {
                $objectSpec = $this->buildLiteralString(
                    $object['value'], 
                    array_key_exists('datatype', $object) ? $object['datatype'] : null, 
                    array_key_exists('lang', $object) ? $object['datatype'] : null
                );
            }
        } else {
            $objectSpec = '?o';
        }
        
        $quadSpec = sprintf('GRAPH <%s> {%s %s %s . }', $graphUri, $subjectSpec, $predicateSpec, $objectSpec);
        
        $deleteSparql = "
            DELETE FROM $quadSpec
            WHERE {
                $quadSpec
            }
        ";

        // perform delete operations
        $ret = $this->_execSparql($deleteSparql);
        
        // load results
        $retArray = array();
        odbc_fetch_into($ret, $retArray);

        // check how many triples have been deleted and return as int if possible
        // else return odbc resource reference (like it was before)
        if (is_string(reset($retArray))) {
            $set = preg_split('/(,|triples)/', current($retArray));
            return (int)$set[1];
        }
        
        return $ret;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteModel($graphIri) 
    {
        // $this->_execSparql('DROP GRAPH <' . $graphIri . '>');
        return $this->_execSparql("
            DELETE FROM GRAPH <$graphIri> {?s ?p ?o.}
                WHERE {GRAPH <$graphIri> {?s ?p ?o.}}
        ");
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMultipleStatements($graphIri, array $statementsArray)
    {
        $deleteSparql = sprintf(
            'DELETE FROM GRAPH <%s> {%s}', 
            $graphIri, 
            $this->buildTripleString($statementsArray));
        
        if (defined('_EFDEBUG')) {
            $log = Erfurt_App::getInstance()->getLog();
            $log->debug('Delete multiple statements query:' . PHP_EOL . $deleteSparql);
        }
        
        return $this->_execSparql($deleteSparql);
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function exportRdf($graphIri, $serializationType = 'xml', $filename = false)
    {
        switch ($serializationType) {
            case 'ttl':
                $exportFunc = 'RDF_TRIPLES_TO_TTL';
                break;
            case 'xml':
                $exportFunc = 'RDF_TRIPLES_TO_RDF_XML_TEXT';
                break;
        }
    }
    
    /** @see Erfurt_Store */
    public function findResourcesWithPropertyValue($stringSpec, $graphUris, $options)
    {        
        // New query object (Erfurt_Sparql_Query2)
        require_once 'Erfurt/Sparql/Query2.php';
        $query = new Erfurt_Sparql_Query2();
        
        foreach ($graphUris as $graphUri) {
            $query->addFrom($graphUri);
        }
        
        $query->setDistinct(true);
        
        $s_var = new Erfurt_Sparql_Query2_Var('resourceUri');
        $p_var = new Erfurt_Sparql_Query2_Var('p');
        $o_var = new Erfurt_Sparql_Query2_Var('o');
        
        $query->addProjectionVar($s_var);
        
        $default_tpattern = new Erfurt_Sparql_Query2_Triple($s_var, $p_var, $o_var);
        
        $query->getWhere()->addElement($default_tpattern);
        
        if ($options['filter_properties']) {
            $ss_var = new Erfurt_Sparql_Query2_var('ss');
            $oo_var = new Erfurt_Sparql_Query2_var('oo');
            
            $filterprop_tpattern = Erfurt_Sparql_Query2_Triple($ss_var, $s_var, $oo_var);
            
            $query->getWhere()->addElement($filterprop_tpattern);
        }
        
        $query->addFilter(
            new Erfurt_Sparql_Query2_Function(
                'bif:contains' ,
                array( $o_var, new Erfurt_Sparql_Query2_RDFLiteral($stringSpec) )
            )
        );
        
        /*
        $resources = array();
        if ($results = $this->sparqlQuery($query)) {
            foreach ($results as $row) {
                array_push($resources, $row['s']);
            }
        }
        */
        
        return $query;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getAvailableModels()
    {        
        if (null === $this->_models) {
            $this->_models = array();
                
            $query = 'SELECT ?graph WHERE {
                GRAPH ?graph {
                    ?graph <' . EF_RDF_TYPE . '> ?o.
                }
            }';
            
            $result = $this->_execSparql($query);
            while (odbc_fetch_row($result)) {
                $graph = odbc_result($result, 1);
                if (!in_array($graph, $this->_virtuosoSpecialModels)) {
                    if (!array_key_exists($graph, $this->_models)) {
                            $this->_models[$graph] = true;
                    }
                }
            }
            
            // TODO: this slower method must be used for graphs that do not contain statements
            // about themselves
            // $graphSql = 'SELECT DISTINCT ID_TO_IRI(G) FROM DB.DBA.RDF_QUAD';
            // $result = $this->_execSql($graphSql);
            // 
            // while (odbc_fetch_row($result)) {
            //     $graph = odbc_result($result, 1);
            //     if (!in_array($graph, $this->_virtuosoSpecialModels)) {
            //         if (!array_key_exists($graph, $this->_models)) {
            //             $this->_models[$graph] = array('modelIri' => $graph);
            //         }
            //     }
            // }
        }
        
        return $this->_models;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getBlankNodePrefix()
    {
        return 'nodeID://';
    }
    
    /**
     * Recursively gets owl:imported model IRIs starting with $modelIri as root.
     *
     * @param string $modelIri
     */
    public function getImportsClosure($modelIri)
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
                    $filter[] = 'sameTerm(?model, <' . $row['o'] . '>)';

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
            } while ($result = $this->sparqlQuery($query));
            
            // unset root node
            unset($models[$modelIri]);
            
            // cache result
            $this->_importedModels[$modelIri] = array_keys($models);
        }
        
        return $this->_importedModels[$modelIri];
    }
    
    /** @see Erfurt_Store */
    public function getLogoUri()
    {
        return $this->_xyz();
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getModel($graphIri) 
    {
        $owlQuery = '
            ASK WHERE {
                GRAPH <' . $graphIri . '> {<' . $graphIri . '> <' . EF_RDF_NS . 'type> <' . EF_OWL_NS . 'Ontology>.}
            }';
        
        if ($this->sparqlAsk($owlQuery, $graphIri)) {
            // assume owl model
            require_once 'Erfurt/Owl/Model.php';
            $model = new Erfurt_Owl_Model($graphIri);
        // TODO: set owl:imports cache
        // TODO: base URIs
        } else {
            // instantiate RDFS model
            require_once 'Erfurt/Rdfs/Model.php';
            $model = new Erfurt_Rdfs_Model($graphIri);
        }
        
        return $model;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getModelLanguages($graphIri)
    {
        if (!array_key_exists($graphIri, $this->_modelLanguages)) {
            $this->_modelLanguages[$graphIri] = array();
            
            foreach ($this->_languages as $language) {
                $query = 'ASK FROM <' . $graphIri . '> WHERE {?s ?p ?o. FILTER (lang(?o) = "' . $language . '")}';
                
                if ($this->sparqlAsk($query)) {
                    array_push($this->_modelLanguages[$graphIri], $lang);
                }
            }
        }
        
        return $this->_modelLanguages[$graphIri];
    }
    
    /** @see Erfurt_Store_Adapter_Interface */ 
    public function getNewModel($graphIri, $baseUri = '', $type = 'rdfs') 
    {
        if ($this->isModelAvailable($graphIri, false)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("A model with the IRI '$graphIri' already exists.");
        }
        
        // TODO: set base uris
        if (strtolower($type) == 'owl') {
            // add statement (?model rdf:type owl:Ontology)
            $owlInsert = 'INSERT INTO GRAPH <' . $graphIri . '> {<' . $graphIri . '> <' . EF_RDF_NS . 'type> <' . EF_OWL_NS . 'Ontology>.}';
            $this->_execSparql($owlInsert);

            require_once 'Erfurt/Owl/Model.php';
            $model = new Erfurt_Owl_Model($graphIri);
        } else {
            // nothing to insert
            require_once 'Erfurt/Rdfs/Model.php';
            $model = new Erfurt_Rdfs_Model($graphIri);
        }
        
        return $model;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getSupportedExportFormats()
    {
        return array();
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getSupportedImportFormats()
    {
        return array(
            'n3'     => 'N3', 
            'nt'     => 'N-Triple', 
            'rdfxml' => 'RDF/XML'
        );
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function importRdf($graphIri, $data, $type, $locator)
    {        
        // check type parameter
        switch (strtolower($type)) {
            case 'n3':  // N3
            case 'nt':  // N-Triple
                $type = 'ttl';
                break;
            case 'rdf': // RDF-XML
            case 'rdfxml':
            default:    // RDF/XML is default
                $type = 'rdfxml';
                break;
        }
        
        $func = null;
        if ($locator === Erfurt_Syntax_RdfParser::LOCATOR_FILE && is_readable($data)) {
            $func = '_importStatementsFromFile';
        } else if ($locator === Erfurt_Syntax_RdfParser::LOCATOR_URL) {
            $func = '_importStatementsFromUrl';
        } else {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception("Locator '$loactor' is not supported by Virtuoso.");
        }
        
        $model = null;
        if ($func) {
            // import statements
            $model = $this->$func($data, $type, $graphIri);
            
            if ($model instanceof Erfurt_Rdf_Model) {
                require_once 'Erfurt/Syntax/RdfParser.php';
                $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat($type);
                
                foreach ($parser->parseNamespaces($data, $locator) as $namespaceUri => $prefix) {
                    try {
                        $model->addNamespacePrefix($prefix, $namespaceUri);
                    } catch (Erfurt_Namespaces_Exception $e) {
                        // Do nothing...
                    }
                    
                }
            }
        }
        
        return $model;
    }
    
    public function init()
    {
        // create fulltext index rule and update index
        $this->_createFullTextIndexRules();
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function isModelAvailable($graphIri, $useAc = true) 
    {
        if (is_string($graphIri)) {
            // check if graph exists in database
            return $this->sparqlAsk('ASK WHERE {GRAPH <' . $graphIri . '> {?s ?p ?o.}}');
        }
        return false;
    }
    
    /** @see Erfurt_Store_Sql_Interface */
    public function lastInsertId()
    {
        if ($result = $this->sqlQuery('SELECT IDENTITY_VALUE()')) {
            return current(current($result));
        }
    }
    
    /** @see Erfurt_Store_Sql_Interface */
    public function listTables($prefix = '')
    {
        $tablesArray = array();
        $prefix = trim($prefix);
        
        $tablesSql = 'select name_part(KEY_TABLE, 2) as TABLE_NAME NVARCHAR(128)
        from DB.DBA.SYS_KEYS 
        where __any_grants(KEY_TABLE) and KEY_IS_MAIN = 1 and KEY_MIGRATE_TO is null';
        
        if (!empty($prefix)) {
            $tablesSql .= ' and name_part(KEY_TABLE, 2) like \'' . $prefix . '%\'';
        }
        
        $tablesSql .= ' order by TABLE_NAME';
        
        if ($result = $this->_execSql($tablesSql)) {
            $tablesArray = $this->_odbcResultToArray($result, false, false);
        }
        
        return $tablesArray;
    }
    
    /**
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $graphIri
     * @param string $saprqlAsk
     */
    public function sparqlAsk($query)
    {        
        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        if (!($sparqlResult = $queryCache->load($query, 'plain'))) {
            $sparqlResult = $this->_execSparql($query);
            
            if (odbc_result($sparqlResult, 1) == '1') {
                $sparqlResult = true;
            }
            else {
                $sparqlResult = false;
            }
            
            $queryCache->save($query, 'plain' , $sparqlResult);
        }
        return $sparqlResult;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlQuery($query, $resultFormat = 'plain') 
    {
        if ($this->_httpConfig['use_http']) {
            return $this->_httpSelect($query, $resultFormat);
        }
        
        $result      = array();
        $json_encode = false;
        
        if ($resultFormat == 'json') {
            $json_encode  = true;
            $resultFormat = 'extended';
        }
        
        if ($resultFormat == 'xml' or $resultFormat == 'extended') {
            $this->_longRead = true;
            $query = ' define output:format "RDF/XML" '
                   .  $query;
        } else if ($resultFormat == 'n3') {
            $query = ' define output:format "TTL" '
                   .  $query;
        }
        
        // this is used to filter out certain queries when working with dbpedia
        // it should be deactivated for normal use
        if (strpos($query, "?__resource") !== false
            && strpos($query, "?__resource1") !== false
            && strpos($query, "?__resource2") !== false
        ) {
            $this->printDebugMessage($query . PHP_EOL . 'was filtered');
            $arr['head'] = array();
            $arr['head']['vars'] = array();
            $arr['head']['vars'][] = '__resource';
            $arr['head']['vars'][] = '__resource1';
            $arr['bindings'] = array();
            
            // this is used to filter out certain queries when working with dbpedia
            // the following line should be deactivated for normal use
            // return $arr;
        }
     
        if ($result = $this->_execSparql((string)$query)) {
            $result = $this->_odbcResultToArray($result);
        }
        
        if ($resultFormat == 'xml' or $resultFormat == 'n3' or $resultFormat == 'extended') {
            if (is_array($result)) {
                // sould be only one row
                foreach ($result[0] as $field) {
                    $result = $field;
                }
            }
        }
        
        // create extended format
        if ($resultFormat == 'extended') {
            require_once 'Erfurt/Store/Adapter/Virtuoso/XmlConverter.php';
            $conv   = new Erfurt_Store_Adapter_Virtuoso_XmlConverter();
            $result = $conv->toArray($result);
            
        }
        
        if ($json_encode) {
            $result = json_encode($result);
        }
        
        return $result;
    }
    
    /** @see Erfurt_Store_Sql_Interface */
    public function sqlQuery($sqlQuery)
    {
        $selectAdd = '';
        
        $parts = array(
            'limit' => '', 
            'offset' => ''
        );
        
        $tokens = array(
            'limit'  => '/LIMIT\s+(\d+)/i', 
            'offset' => '/OFFSET\s+(\d+)/i'
        );
        
        foreach ($tokens as $key => $pattern) {
            preg_match_all($pattern, $sqlQuery, $parts[$key]);
        }
        
        if (isset($parts['limit'][1][0])) {
            $selectAdd = 'TOP ' . $parts['limit'][1][0];
            
            if (isset($parts['offset'][1][0]) && ((int) $parts['offset'][1][0] > 0)) {
                $selectAdd = 'TOP ' . $parts['offset'][1][0] . ' , ' . $parts['limit'][1][0];
            }
        }
        
        $replacings = array(
            '/LIMIT\s+(\d+)/i'  => '', 
            '/OFFSET\s+(\d+)/i' => ''
        );

        // Need to distinguish between SELECT and SELECT DISTINCT for LIMIT-OFFSET conversion
        if ( preg_match('/DISTINCT/i',$sqlQuery) ) {
            $replacings['/SELECT\s+DISTINCT/i'] = 'SELECT DISTINCT ' . $selectAdd;
        } else {
            $replacings['/SELECT/i'] = 'SELECT ' . $selectAdd;
        }

        $sqlQuery = preg_replace(array_keys($replacings), array_values($replacings), $sqlQuery);
        $resultArray = array();
        
        if ($result = $this->_execSql($sqlQuery)) {
            $resultArray = $this->_odbcResultToArray($result);
        }

        return $resultArray;
    }
    
    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------
    
    private function _createFullTextIndexRules()
    {
        $a = microtime(true);
        $this->_execSql('DB.DBA.RDF_OBJ_FT_RULE_ADD(NULL, NULL, \'ontowiki_ft_index\')');
        $this->_execSql('DB.DBA.VT_INC_INDEX_DB_DBA_RDF_OBJ()');
        
        if (defined('_EFDEBUG')) {            
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->info(sprintf('Creating Virtuoso full-text index: %f ms', (microtime(true) - $a) * 1000));
        }
    }
    
    /**
     * Converts an ODBC result to an array.
     *
     * @param boolean $columnsAsKeys If true, column names are used as indices.
     * @param boolean $rowsAsArrays If false and only 1 column is selected 
     *        the first field in each row is directly pushed into the result array.
     *
     * @return array
     */
    private function _odbcResultToArray($odbcResult, $columnsAsKeys = true, $rowsAsArrays = true)
    {
        $result         = $odbcResult;
        $resultArray    = array();
        $resultRow      = array();
        $resultRowNamed = array();
        
        // get number of fields (columns)
        $numFields = odbc_num_fields($result);

        if ($numFields === 0) {
            return $resultArray;
        }        
       
        while (odbc_fetch_into($result, $resultRow)) {
            if ($numFields == 1 && !$rowsAsArrays) {
                // add first row field to result array
                array_push($resultArray, $resultRow[0]);
            } else {
                // copy column names to array indices
                for ($i = 0; $i < $numFields; ++$i) {
                    if ($columnsAsKeys) {
                        $colName = odbc_field_name($result, $i + 1);
                        $resultRowNamed[$colName] = $resultRow[$i];
                    } else {
                        $resultRowNamed[] = $resultRow[$i];
                    }
                }
                
                // add row to result array
                array_push($resultArray, $resultRowNamed);
            }
        }
        
        return $resultArray;
    }
    
    /**
     * Executes a SPARQL query and returns an ODBC result identifier.
     *
     * @param  string $sparqlQuery
     * @param  string $graphUri
     * @return ODBC result identifier
     * @throws Erfurt_Exception
     */
    private function _execSparql($sparqlQuery, $graphUri = 'NULL')
    {
        if (!is_string($graphUri) || $graphUri == '') {
            $graphUri = 'NULL';
        } else if ($graphUri != 'NULL') {
            $graphUri = '\'' . $graphUri . '\'';
        }
        
        // escape characters that delimit the query within the query
        $sparqlQuery = addcslashes($sparqlQuery, '\'\\');
        // build Virtuoso/PL query
        $virtuosoPl = 'CALL DB.DBA.SPARQL_EVAL(\'' . $sparqlQuery . '\', ' . $graphUri . ', 0)';
        
        $result = @odbc_exec($this->_connection, $virtuosoPl);
        
        if (false === $result) {
            //require_once 'Erfurt/Exception.php';
            trigger_error ('SPARQL Error: ' . $this->_getLastError() . '<br />' . 'Query: ' . htmlentities($sparqlQuery));
            exit;
        }
        
        if ($this->_longRead) {
            odbc_longreadlen($result, 16777216);
            $this->_longRead = false;
        }
       
        return $result;
    }
    
    /**
     * Sends a SPARQL/Update query via HTTP.
     *
     * @param string $sparlQuery
     */
    private function _httpUpdate($sparqlQuery)
    {
        $username    = $this->_httpConfig['username'];   
        $password    = $this->_httpConfig['password'];   
        $endpointUri = $this->_httpConfig['endpoint_uri'];    
        $davFolder   = $this->_httpConfig['dav_folder'];
        
        $url = $endpointUri
             . $davFolder;
        
        $client = new Zend_Http_Client($url, array());
        $client->setMethod(Zend_Http_Client::POST)
               ->setRawData($query, 'application/sparql-query')
               ->setAuth($username, $password);
        
        $response = $client->request();
        
        // testing
        echo 'Answer' . PHP_EOL;
        echo $response->getStatus();
        echo $response->getMessage();
    }
    
    /**
     * Sends a SPARQL query via HTTP.
     *
     * @param string $sparlQuery
     * @param string $resultFormat
     */
    private function _httpSelect($sparqlQuery, $resultFormat = 'plain')
    {
        $username    = $this->_httpConfig['username'];
        $password    = $this->_httpConfig['password'];
        $endpointUri = $this->_httpConfig['endpoint_uri'];

        $sparqlQuery = urlencode($sparqlQuery);
        $format      = ($resultFormat == 'plain') ? 'JSON' : $resultFormat;
        
        
        $url = trim($endpointUri, '/') 
             . '/sparql?query=' 
             . $sparqlQuery
             . '&format='
             . $format;
        
        require_once 'Zend/Http/Client.php';
        $client = new Zend_Http_Client();
        $client->setAuth($username, $password)
               ->setUri($url);
        
        $response = $client->request();
        $result   = $response->getBody();
                
        // TODO: catch errors here
        
        switch (strtolower($resultFormat)) {
            case 'json':
                return $result;
                break;
            case 'xml':
                return $result;
                break;
            case 'plain':
                $retval = array();
                $array  = json_decode($result, true);
                
                // rows
                foreach ($array['results']['bindings'] as $row) {
                    $tmp = array();
                    
                    // fields
                    foreach ($row as $key => $value) {
                        $tmp[$key] = $value['value'];
                    }
                    
                    array_push($retval, $tmp);
                }
                
                return $retval;
                break;
        }
    }
        
    /**
     * Executes a SQL statement and returns an ODBC result identifier.
     *
     * @param  string $sqlQuery
     * @return ODBC result identifier
     * @throws Erfurt_Exception
     */
    private function _execSql($sqlQuery) 
    {
        $result = @odbc_exec($this->_connection, $sqlQuery);
        
        if (false === $result) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('SQL Error: ' . $this->_getLastError() . ' ' .
            $sqlQuery);
        }
        
        // FIXME: temp fix, always go big
        $this->_longRead = true;
        
        if ($result && $this->_longRead) {
            odbc_longreadlen($result, 16777216);
            $this->_longRead = false;
        }
        
        return $result;
    }
    
    /**
     * Returns the last ODBC error message and number.
     *
     * @return string
     */
    private function _getLastError() 
    {
        if (null != $this->_connection) {
          return odbc_errormsg($this->_connection) . ' (' . odbc_error($this->_connection) . ')';
        } else {
          return '(no errormsg)';
        }
    }
    
    /**
     * Checks whether an error occured during the last operation.
     *
     * @return boolean True if an error occured, false otherwise
     */
    private function _hasError()
    {
        $error = odbc_error($this->_connection);
        if (!empty($error)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Imports statements from a file into a graph.
     * The file can be in either N3, N-Triples or RDF/XML format.
     *
     * @param string $file Path to the file that contains statements.
     * @param string $type (n3|nt|rdf) 
     * @param string $graphUri The model IRI
     * @param string $baseUri The base IRI
     */
    private function _importStatementsFromFile($file, $type, $graphUri, $baseUri = null) 
    {
        // check type parameter
        switch (strtolower($type)) {
            case 'n3':  // N3
            case 'nt':  // N-Triple
                $importFunc = 'TTLP';
                break;
            case 'rdf': // RDF-XML
            case 'rdfxml':
            default:    // unknown defaults to RDF-XML
                $importFunc = 'RDF_LOAD_RDFXML';
                break;
        }
        
        // default base uri to graph uri if not given 
        // (will be overriden by document directives e.g. xml:base)
        if ($baseUri === null) {
            $baseUri = $graphUri;
        }
        
        // import using internal Virtuoso/PL function
        $importSql = sprintf(
            "CALL DB.DBA.%s(FILE_TO_STRING_OUTPUT('%s'), '%s', '%s')", 
            $importFunc, 
            $file, 
            $baseUri, 
            $graphUri);

        try {
            if ($res = $this->_execSql($importSql)) {
                // TODO: owl:imports
                return $this->getModel($graphUri);
            }
        } catch (Erfurt_Store_Adapter_Exception $e) {
            throw new Erfurt_Store_Adapter_Exception('Error importing statements: ' . $e->getMessage());
        }
    }
    
    /**
     * Imports statements from a URL into the graph denoted by $graphUri
     *
     * @param string $url
     * @param string $type nr|nt|rdf
     * @param string $graphUri
     * @param string $baseUri
     *
     * @todo Use mime type to as hint to the file format
     */ 
    private function _importStatementsFromUrl($url, $type, $graphUri, $baseUri = '')
    {
        // do some guesswork
        if (substr($url, -2) == 'n3' or substr($url, -2) == 'nt') {
            $type = 'n3';
        }
        
        // check type parameter
        switch (strtolower($type)) {
            case 'n3':  // N3
            case 'nt':  // N-Triple
                $importFunc = 'TTLP';
                break;
            case 'rdf': // RDF-XML
            case 'rdfxml':
            default:    // unknown defaults to RDF-XML
                $importFunc = 'RDF_LOAD_RDFXML';
                break;
        }
        
        $importSql = sprintf("CALL DB.DBA.%s(XML_URI_GET_AND_CACHE('%s'), '%s', '%s')", 
                             $importFunc, 
                             $url, 
                             $baseUri, 
                             $graphUri);
        
        try {
            if ($this->_execSql($importSql)) {
                return $this->getModel($graphUri);
            }
        } catch (Erfurt_Store_Adapter_Exception $e) {
            throw new Erfurt_Store_Adapter_Exception('Error importing statements: ' . $e->getMessage());
        }
    }
    
    private function _xyz()
    {
        $logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAcCAYAAACXkxr4AAAACXBIWXMAA'
              . 'AsTAAALEwEAmpwYAAAKC0lEQVRoge2ZeVDU5xnHPz/AXdmDGwUEXDAsMxaRywOJEkINxmGp1cYDZ+o0'
              . 'bTTtZDqTQDrpTOu09srkciYzMSpNtO2ITZxpMrD5IyIB2yikchjU6C5JRMBFZFniHuAu6779Y7MbEZZ'
              . 'L2z9Svv/sb/d9rt/7fZ7nPRbmMIc5zGEOc5gdpAdl6Pr1AdFjsnChy4piPkjz5azJTCVGCbbbHpShcs'
              . 'KU8gfm79uK+56g5nMGceSdMxh6bSiUoQTHqlAp5KgUMuShC0ldqGTN4hAUYSrSNbHI5bI5UibBrCenw'
              . '3BdvFH1IYZeG/FLE4mOTiIsIpyQ+aFj5BRqFSqVgoj+VjKXashMXzTO5969e4Xved++fdJEYxP9vm/f'
              . 'Punez6lsTsfXTHRm8h4TxXkvQgINTIYDR06JF176gNScLH6wOZOISDkAXw05sduHx8iqVApSUuWYrsv'
              . 'ovXodt9stQkJCxgXkC/LugAM9TxeB5CezORud2cgFwowIsTqcYv/bjbQPjlBe+RQajcDeNYCltx9PsJ'
              . 'poZRiolNzsuwl4q8OHpIxkWt+rY+OGlRMGGagS7geBJmUyX7OdyKlsT6c6YAaEWB1OUfH7fxCfV8Cuj'
              . 'YlcqmvlxKFmFiyIILNwBXnp0VzpsZDiNvN5pIzmywNAHADh4TJkIfO5efOrgPYfJBFT2ZxNhczU53+9'
              . 'Qva/3ciSohLWLglC/7u3ACjZsJLioizmzQvBPjKKLTSOUNs1tq9L4otLRgZugEL9kN+G0+maUXC+rPI'
              . '9TzQ2WebNpuomW7OmY+t+K31aSlUnzonB8CV8RznAqRN1pKTG85MnS1AqlUiSJAkhxLGGLhZFSoS6na'
              . 'zK01Ktb+HvZzopeHQDD6+NYPRKN+//Rc/+135GUFDQ3E4rAKaskOZzBtE4FEuy1MvZDz5hx871rMrTA'
              . 'iBJkgTQ2TNIrzscW2sz2cuXALAkLow7A3YAomVwtf8mCoV8jowpEDTZoNXhFDVGyEoa5ULDJ+zYtZGV'
              . 'uWkIIfxkCCHEe6eukJU0iuWmhezMFCRJkgZcMOwY8W55b49iNPawMC4Kt9stJvP5/45JK0R/1sDqXC1'
              . 'XP/6IteuWs0ybAHxTGV4ZI47wZMxXPkepCkUmm4fb7RZVR0+i1sSSkioHXDQ1X+bZZ5/At+U1dpvFsf'
              . 'qLmAZtFC1fTPn6zDGVU13XIWwjLmwjTgw9FtKToqjcViA1tHeJ2jMGbLdd5GnjaTH2oZ4vQ1eQTlG2R'
              . 'qo9YxA1TUYAEqLVmAZt5Gnj/d9tw04aPr0GQFWlboxP3QvVovbFcv9vh2pahP6s15bJYqMwU8PTZblo'
              . 'k2MkgD6zVRysbcM0aMM+7EKbFM3O4gz/uLHbLA7WtHK6o4uEKDXWESflxcvYU5YXsEsErBCrwymGPBE'
              . 'ssF2jYO1yHvtuDi7XKC7XqF9GCCFq9G2sKkji0rnP0GqTAAgODqbxozYWJz1EaqzgvXf/RdyCCLIzU/'
              . 'y62uQYqWJrPsYeM8frL47zX9vUSVGWhsptBdINsw1DjwWAomyNlJ4cTZvRxG5dLlWVOqkoW0Plmx/SZ'
              . '7YKH8FVlTopIVpFm9HEnrI8aU9ZnqQrSJd8xLcZTeN8miw2//OhmhZxWN9K6RottS+WS8d/tYU+i52K'
              . 'Ayf9Mj4yqip10vG9W6Q8bTwN57v84xUHTtJnsXOkopTaF8ulPaW5HNa3cqimJWCXCEhIq7GPJcneA19'
              . 'YRDivv2/gzl3iQgjx5tF65IlLiHDcYmjIxrqHlyKE4ILRRL9HzepHVxBxe5TTdc2UbFg57tokTCmXdG'
              . 'u0mCw2jN1mf5B9ZquwDzv9mRYXo54wRl+l6grSJW1iDMfqL1C2Rjuu2u6Fr2Img/6skRxtgj+btckx0'
              . 'i+3rcZksdHQ3iUA9E2GMTqFWRrK1njX14b2LmGy2Nity/V3lvL1mVJhpobG89cC+g1IyA2XGs81r2Jy'
              . 'rIK48Dv84s9tXOu34vF4hG3Yhf7jL3msOJNP/9lCUtIC366LN6o+JGNtPrlawTtv6UnVLKS4KGtCP2X'
              . '56QDU3PVyDe1dFGYvnmrO/CRaHU5hGrSSEKUmPibsgWwaTBbbOOJ81z7GHjMApfnptBlNVNd1CPAmmM'
              . '+/TyZXGz+mxacnR2PsNQf0OyEhHo9HKMOVAL5Fmk3rlhLrGeL12i95+ehZ9r/dSGpOFmlpMjr+3UHx+'
              . 'hUAfNJipGfIzeNbVnCrrZOm5st87/vrAl4qapNjpIQoNafbv8ma2qZOdhYvm3TCAI7VX6S6rkNUvHmS'
              . '3LQEStekT6nzIFGxNZ/CTA2vnmhC90K16DBcH9eKZnrDPSEh/RY70fNuExUdTnBwEEIIFPIQadfWAgY'
              . 'He+gZkTEQFMnjW1Zg6bISGalmVZ4Wh8PBvoOn2fjjH5KjdrF//wk26fJZvSJ90qAKsxf721af2SqAaW'
              . 'd6i6GPNqOJ57fn/8+v98OUcum1Z0qkV35agnXEyY9e1furZbaYkBDnnSDUbgeKMBUhISGS7+yQHKugN'
              . 'DsZ50g/iWneBftqxyV27NoIwLN/qCVv4waKV8n4beUbZGZo2Lx57ZRB+NrWsfqLNLR3octPm1bwFVvz'
              . 'eX57PuBdYB80bCPOackVZWuk2j+WkxCl5pC+dcyYL8GmiwkJkavmEa2SERutxuPx+A0GBQVJO3UrJPV'
              . '82Rj5ZdoEXjpyhtiMHHZsSuRgxQEiI9U8ubuMefOmvp3RJsdI2sQYGs9f9e6usjXTCt7Xs3cUZ6BvMs'
              . 'z45a0Op5joGUCbGEOr4cYYeV9L0ibFTBhL6dcL+t0yLYa+MXKG7kG0ieP1fZiQkKgQifDwUOJjwqR7T'
              . '9Yej0c8XZZLb+fndHa6WJmbzoGTPYjEpWwqieOvv36LBQsi+Plz2ybUDwRdfhr2ERcqhWzGC/Pu0jxU'
              . 'oTL2Hj09pazH4xH56d7F+rC+BavDKawOpzisbyHn690QQHlxBsZeM7VnDAK8ZPzpnWa0iTEUZWskq8M'
              . 'pnnqlVlTXdYg+s1X0ma2i8fw1dF+TUpStkbSJMVTXX/T7OFTTIlo7TZQXZwSMb9Y9t7quQ0hhi1CGKw'
              . 'mOkBM8dJPTf6thYVwUT2xZx6JFsTOy3We2iucO1LFbl0tRtmaMrrHbLGqaDFRuK5DAm82/OdLIa8+U+'
              . 'OWq6zpEbVMnx/duke7We/ndpnEHwLvlTYNW7CMuCjM1PL89f0wy1J4xiOr6i9iHnVhHnDySlcLTuhy/'
              . 'TEN7lzhc24qx14wqVMYjWSlUbP1mLbM6nOLVd5toM3jPPCqFHF1+2qTb8hkT4vF4RPfAMB9fGoB4Ddp'
              . 'YK2erT9F/w0LmslQ2b1479zftfWDSiRt2ukV7r93/3eZy8kW3E5ukYmmyAuvlVi6d+2zWVTGH8Zh0Aj'
              . '0ejxgddWM232LQ7v0vY9hqxzJ4i1tD3muG3ILl/hP1HObwrcN/AF5zmzGLB8I2AAAAAElFTkSuQmCC';
        
        return $logo;
    }
    
    /**
     * Used for performance debugging of OntoWiki w/ Virtuoso.
     * Certain queries are very slow when executed against a Virtuoso store.
     *
     * @param string $message
     */ 
    private function printDebugMessage($message)
    {
        if ($this->_debugQueries) {
            $string = 'This message is shown, because the debug variable in store adapter '
                    . __FILE__
                    . ' is set to true.';
            $line = '--------------------------------------------------------------------------------';
            
            echo sprintf('<xmp>%s</xmp>%s%s%s%s', $string, PHP_EOL, $message, $line, PHP_EOL);
        }
    }
}
