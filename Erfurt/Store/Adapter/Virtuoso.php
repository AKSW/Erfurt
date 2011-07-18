<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/** Erfurt_Store_Adapter_Interface */
require_once 'Erfurt/Store/Adapter/Interface.php';

/** Erfurt_Store_Sql_Interface */
require_once 'Erfurt/Store/Sql/Interface.php';

/**
 * OpenLink Virtuoso Adapter for the Erfurt Semantic Web Framework.
 *
 * Connects to a Virtuoso via ODBC, therefore requires PHP to be compiled with the ODBC extension.
 *
 * @category Erfurt
 * @package Store_Adapter
 * @author Norman Heino <norman.heino@gmail.com>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Store_Adapter_Virtuoso implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{
    // ------------------------------------------------------------------------
    // --- Class Constants ----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Prefix for blanknode identifiers.
     * @var string
     */
    const BLANKNODE_PREFIX = 'nodeID://';
    
    /**
     * Name for the fulltext index.
     * @var string
     */
    const FULLTEXT_INDEX_NAME = 'erfurt_ft_index';
        
    // ------------------------------------------------------------------------
    // --- Protected Properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /** 
     * ODBC connection identifier.
     * @var int
     */
    protected $_connection = null;
    
    /**
     * Adapter option array
     * @var array
     */
    protected $_adapterOptions = null;
    
    /**
     * The available graphs in this store.
     * @var array
     */
    protected $_graphs = null;
    
    /**
     * Model imports cache.
     * @var array
     */
    protected $_importedModels = array();
    
    /** 
     * Whether there are ongoing transactions.
     * @var boolean
     */
    protected $_transactions = false;
    
    /**
     * The user performing db requests
     * @var string
     */
    protected $_user = null;
    
    /**
     * Graph URIs internally used by Virtuoso
     * @var array 
     */
    protected $_virtuosoSpecialGraphs = array(
        'http://www.openlinksw.com/schemas/virtrdf#', 
        'http://localhost:8890/DAV'
    );
    
    // ------------------------------------------------------------------------
    // --- Magic Methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Constructor.
     *
     * @throws Erfurt_Store_Adapter_Exception
     */
    public function __construct($adapterOptions = array())
    {
        // check for odbc extension
        if (!extension_loaded('odbc')) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Virtuoso adapter requires the ODBC extension to be loaded.');
            exit;
        }
        
        $this->_adapterOptions = $adapterOptions;
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
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Cannot close the connection while transactions are open.');
        }
        
        $this->_closeConnection();
    }
    
    // ------------------------------------------------------------------------
    // --- Public Methods (Erfurt_Store_Adapter_Interface) --------------------
    // ------------------------------------------------------------------------
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function addMultipleStatements($graphUri, array $statementsArray, array $options = array())
    {
        $numBlocks = 1;
        $blockQueries = array();
        while (true){
            $statementBlocks = $this->array_split($statementsArray, $numBlocks);
            $blockQueries = array();
            foreach($statementBlocks as $statementBlock){
               $blockQuery = sprintf(
                'INSERT INTO GRAPH <%s> {%s}', 
                $graphUri, 
                $this->buildTripleString($statementBlock));

                if(substr_count($blockQuery, "\n") > 1000){ //split when too many linebreaks (virtuso has a limit of 10'000 - but in sql...?!)
                    $numBlocks *= 2;
                    continue 2;
                } 
                $blockQueries[] = $blockQuery;
            }
            break;  //this only reached if the continue call is not ŕeached
        }
        
        $odbcRes = true;
        foreach ($blockQueries as $query){
            if (defined('_EFDEBUG')) {
                $logger = Erfurt_App::getInstance()->getLog();
                $logger->debug('Add mutliple statements query: ' . PHP_EOL . $query);
            }

            $odbcRes = $this->_execSparql($query);
            $result = odbc_result($odbcRes,1);

        }
        
        //TODO why - please comment
        if (odbc_num_fields($odbcRes) > 0 && odbc_field_type($odbcRes, 1) == 'VARCHAR') {
            $strResult = odbc_result($odbcRes,1);
            return $strResult;
        }
    }
    
    // split the given array into n number of pieces
    private function array_split($array, $pieces=2)
    {  
        if ($pieces < 2)
            return array($array);
        $newCount = ceil(count($array)/$pieces);
        $a = array_slice($array, 0, $newCount);
        $b = $this->array_split(array_slice($array, $newCount), $pieces-1);
        return array_merge(array($a),$b);
    } 

        /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function addStatement($graphUri, $subject, $predicate, $objectSpec, array $options = array())
    {
        extract($objectSpec);
        
        if ($type == 'uri') {
            $object = '<' . $value . '>';
        } else {
            $object = $this->buildLiteralString(
                $value, 
                isset($datatype) ? $datatype : null, 
                isset($lang) ? $lang : null
            );
        }
        
        // TODO: support blank nodes as subject
        $insertSparql = '
            INSERT INTO GRAPH <' . $graphUri . '> {
                <' . $subject . '> <' . $predicate . '> ' . $object . '
            }';
        
        if (defined('_EFDEBUG')) {
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->debug('Add statement query: ' . PHP_EOL . $insertSparql);
        }
        
        return $this->_execSparql($insertSparql);
    }
    
    /**
     * Explicitly creates a new named graph.
     *
     * @param string $graphUri
     * @param string $baseUri
     * @return boolean
     */
    public function createModel($graphUri, $type = Erfurt_Store::MODEL_TYPE_OWL)
    {
        // create empty graph
        $createQuery = "CREATE SILENT GRAPH <$graphUri>";
        $this->_execSparql($createQuery);
        
        require_once 'Erfurt/Store.php';
        if ($type === Erfurt_Store::MODEL_TYPE_OWL) {
            // add statement <graph> a owl:Ontology
            $owlInsert = sprintf('INSERT INTO GRAPH <%s> {<%s> a <%s>.}', $graphUri, $graphUri, EF_OWL_ONTOLOGY);
            $this->_execSparql($owlInsert);
        }
        
        // force reloading graphs next time
        $this->_graphs = null;
        
        return true;
    }
    
    /**
     * Returns the current connection resource.
     * The resource is created lazily if it doesn't exist.
     * @retun resource
     */
    public function connection()
    {
        if (!$this->_connection) {
            $adapterOptions = $this->_adapterOptions;

            extract($adapterOptions);

            // determine connection function
            if (isset($use_persistent_connection) && (boolean)$use_persistent_connection === true) {
                $odbcConnectFunction = 'odbc_pconnect';
            } else {
                $odbcConnectFunction = 'odbc_connect';
            }

            // try to connect
            if (function_exists('__virt_internal_dsn')) {
                // via Virtuoso hosting
                $this->_connection = $odbcConnectFunction(__virt_internal_dsn(), null, null);
            } else {
                // via php_odbc
                $this->_connection = $odbcConnectFunction((string)$dsn, (string)$username, (string)$password);
                $this->_user = (string)$username;
            }

            // success?
            if (false === $this->_connection) {
                require_once 'Erfurt/Store/Adapter/Exception.php';
                throw new Erfurt_Store_Adapter_Exception('Unable to connect to Virtuoso Universal Server via ODBC.');
                exit;
            }
        }
        
        return $this->_connection;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, array $options = array())
    {
        if (empty($graphUri)) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('No graph URI given.');
        }
        
        $graphSpec     = '<' . (string)$graphUri . '>';
        $subjectSpec   = $subject   ? '<' . (string)$subject . '>'   : '?s';
        $predicateSpec = $predicate ? '<' . (string)$predicate . '>' : '?p';
        
        if (null !== $object) {
            if ($object['type'] == 'uri') {
                $objectSpec = '<' . $object['value'] . '>';
            } else {
                $objectSpec = $this->buildLiteralString(
                    $object['value'], 
                    array_key_exists('datatype', $object) ? $object['datatype'] : null, 
                    array_key_exists('lang', $object) ? $object['lang'] : null
                );
            }
        } else {
            $objectSpec = '?o';
        }
        
        $deleteSparql = sprintf(
            'DELETE FROM GRAPH %s {%s %s %s.} WHERE {%s %s %s}', 
            $graphSpec, 
            $subjectSpec, 
            $predicateSpec, 
            $objectSpec, 
            $subjectSpec, 
            $predicateSpec, 
            $objectSpec
        );     
        
        // perform delete
        if ($rid = $this->_execSparql($deleteSparql)) {
            $deleteResult = (string)odbc_result($rid, 1);
            
            // extract number of deleted statements
            $matches = array();
            preg_match('/,\s*(\d)\s*triples/i', $deleteResult, $matches);
            if (isset($matches[1])) {
                // return number of deleted statements
                return (int)$matches[1];
            }
        }
        
        // no statements deleted
        return 0;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {
        $deleteSparql = sprintf(
            'DELETE FROM GRAPH <%s> {%s}', 
            $graphUri, 
            $this->buildTripleString($statementsArray));
        
        if (defined('_EFDEBUG')) {
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->debug('Delete multiple statements query:' . PHP_EOL . $deleteSparql);
        }
        
        return $this->_execSparql($deleteSparql);
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function deleteModel($graphUri)
    {
        // delete explicit graph
        $result = $this->_execSparql('DROP SILENT GRAPH <' . $graphUri . '>');
        $this->_graphs = null;
        
        return $result;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * @todo implement
     */
    public function exportRdf($graphUri, $serializationType = 'xml', $filename = null)
    {
        require_once 'Erfurt/Store/Adapter/Exception.php';
        throw new Erfurt_Store_Adapter_Exception('RDF export not implemented yet.');
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function getAvailableModels()
    {
        if (null === $this->_graphs) {
            $this->_graphs = array();
            $rid = $this->_execSql(
                'SELECT ID_TO_IRI(REC_GRAPH_IID) AS GRAPH FROM DB.DBA.RDF_EXPLICITLY_CREATED_GRAPH');
            if ($rid) {
                $graphs = $this->_odbcResultToArray($rid, false, 'GRAPH');
                $this->_graphs = array();
                foreach ($graphs as $graph) {
                    $this->_graphs[$graph] = array('modelIri' => $graph);
                }
            }          
        }
        
        return $this->_graphs;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function getBlankNodePrefix()
    {
        return self::BLANKNODE_PREFIX;
    }
    
    /**
     * @see Erfurt_Store
     */
    public function getLogoUri()
    {
        return $this->_xyz();
    }
    
    /**
     * @see Erfurt_Store
     */
    public function getSearchPattern($stringSpec, $graphUris, $options)
    {
        $searchPattern = array();
        
        if (false === strpos($stringSpec, '*')) {
            $stringSpec .= '*';
        }
        
        require_once 'Erfurt/Sparql/Query2/Var.php';
        $subjectVariable   = new Erfurt_Sparql_Query2_Var('resourceUri');
        $predicateVariable = new Erfurt_Sparql_Query2_Var('p');
        $objectVariable    = new Erfurt_Sparql_Query2_Var('o');
        
        require_once 'Erfurt/Sparql/Query2/Triple.php';
        $defaultTriplePattern = new Erfurt_Sparql_Query2_Triple($subjectVariable, $predicateVariable, $objectVariable);
        $searchPattern[] = $defaultTriplePattern;
        
        $bifPrefix = new Erfurt_Sparql_Query2_Prefix('bif', new Erfurt_Sparql_Query2_IriRef('SparqlProcessorShouldKnow'));
        $bifContains = new Erfurt_Sparql_Query2_IriRef('contains', $bifPrefix);

        $filter = new Erfurt_Sparql_Query2_Filter(
            new Erfurt_Sparql_Query2_ConditionalOrExpression(
                array(
                    /*new Erfurt_Sparql_Query2_Function(
                        $bifContains,
                        array($subjectVariable, new Erfurt_Sparql_Query2_RDFLiteral($stringSpec))
                    ),
                    // why doesnt this work???
                    // ANSWER: bif:contains uses virtuoso specific fulltext index only 
                    // available for object column uris could only be treated as codepoint representation
                    // of themselves -> Solution again is IRI (maybe not before PHP 6)
                    */
                    new Erfurt_Sparql_Query2_Function(
                        $bifContains,
                        array($objectVariable, new Erfurt_Sparql_Query2_RDFLiteral($stringSpec, null, '\'"'))
                    )
                )
            )
        );

        if ($options['filter_properties']) {
            $ss_var = new Erfurt_Sparql_Query2_Var('ss');
            $oo_var = new Erfurt_Sparql_Query2_Var('oo');

            $propertyFilterTriplePattern = new Erfurt_Sparql_Query2_Triple($ss_var, $s_var, $oo_var);
            $searchPattern[] = $propertyFilterTriplePattern;

            /*
            $filter->getConstraint()->addElement(
                new Erfurt_Sparql_Query2_Function(
                    $bifContains,
                    array($oo_var, new Erfurt_Sparql_Query2_RDFLiteral($stringSpec))
                )
            );*/
        }

        $searchPattern[] = $filter;

        return $searchPattern;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function getSupportedExportFormats()
    {
        return array();
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function getSupportedImportFormats()
    {
        return array(
            'rdfxml' => 'RDF/XML',
            'n3'     => 'N3'
        );
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function importRdf($graphUri, $data, $type, $locator)
    {
        // check type parameter
        switch (strtolower($type)) {
            case 'n3':  // N3
            case 'nt':  // N-Triple (is N3 Subset)
            case 'ttl': // Turtle (is N3 Subset)
                $type = 'n3';
                break;
            case 'rdf': // RDF-XML
            case 'rdfxml':
            default:    // RDF/XML is default
                $type = 'rdfxml';
                break;
        }
        
        require_once 'Erfurt/Syntax/RdfParser.php';
        switch ($locator) {
            case Erfurt_Syntax_RdfParser::LOCATOR_FILE:
                $importSql = $this->_getImportSql('file', $data, $type, $graphUri);
                break;
                
            case Erfurt_Syntax_RdfParser::LOCATOR_URL:
                // do some type guesswork
                if ( 
                    substr($data, -2) == 'n3' ||
                    substr($data, -2) == 'nt' ||
                    substr($data, -3) == 'ttl'
                ) {
                    $type = 'n3';
                }
                $importSql = $this->_getImportSql('url', $data, $type, $graphUri);
                break;
                
            default:
                require_once 'Erfurt/Store/Adapter/Exception.php';
                throw new Erfurt_Store_Adapter_Exception("Locator '$locator' not supported by Virtuoso.");
                break;
        }
        
        try {
            // import graph
            $rid = $this->_execSql($importSql);
            
            // parse namespace prefixes
            require_once 'Erfurt/Syntax/RdfParser.php';
            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat($type);
            $namespacePrefixes = $parser->parseNamespaces($data, $locator);
            $namespaces = Erfurt_App::getInstance()->getNamespaces();
            
            // store namespace prefixes
            while (list($namespaceUri, $prefix) = each($namespacePrefixes)) {
                try {
                    $namespaces->addNamespacePrefix($graphUri, $namespaceUri, $prefix);
                } catch (Erfurt_Namespaces_Exception $e) {
                    // ignore
                }
            }
        } catch (Erfurt_Store_Adapter_Exception $e) {
            throw new Erfurt_Store_Adapter_Exception('Error importing statements: ' . $e->getMessage());
        } catch (Erfurt_Syntax_RdfParserException $parserException) {
            throw new Erfurt_Store_Adapter_Exception('Error parsing namespaces: ' . $parserException->getMessage());
        }
        
        // success
        return true;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function init()
    {
        // create fulltext index rule and update index
        $this->_createFullTextIndexRules();
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function isModelAvailable($graphUri)
    {
        return array_key_exists((string)$graphUri, (array)$this->getAvailableModels());
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function sparqlAsk($query)
    {
        $resultId = $this->_execSparql($query);
        
        if (odbc_result($resultId, 1) == '1') {
            return true;
        }
        
        return false;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface 
     */
    public function sparqlQuery($query, $options=array())
    {
        $resultFormat = isset($options[STORE_RESULTFORMAT]) ?
                            $options[STORE_RESULTFORMAT] :
                            STORE_RESULTFORMAT_PLAIN;
        
        // load query config variables
        extract($this->_getQueryConfig($resultFormat));
        
        // prepare query
        $query = $queryPrefix
               . PHP_EOL
               . (string)$query;

        if ($rid = $this->_execSparql($query)) {

            $result = $this->_odbcResultToArray($rid);

            // map single field to complete result
            if ($singleField) {
                // the result is in the first field of the first row
                $result = current(current($result));
            }
            
            // convert XML result
            if (null !== $converter) {
                foreach ((array) $converter as $currentConverter) {
                    $converterClass = 'Erfurt_Store_Adapter_Virtuoso_ResultConverter_' . $currentConverter;
                    
                    require_once str_replace('_', '/', $converterClass) . '.php';
                    $converter = new $converterClass();
                    $result = $converter->convert($result);
                }
            }

            // encode as JSON string
            if ($jsonEncode) {
                $result = json_encode($result);
            }
            
            return $result;
        }
    }
    
    // ------------------------------------------------------------------------
    // --- Public Methods (Erfurt_Store_Adapter_Sql_Interface) ----------------
    // ------------------------------------------------------------------------
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface 
     */
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
        
        $createTable = 'CREATE TABLE ' . (string)$tableName . ' (' . implode(',', $colSpecs) . PHP_EOL . ')';
    
        return $this->sqlQuery($createTable);
    }
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     */
    public function lastInsertId()
    {
        if ($rid = $this->_execSql('SELECT IDENTITY_VALUE()')) {
            return (int)odbc_result($rid, 1);
        }
    }
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     * @todo Easier implementation
     */
    public function listTables($prefix = '')
    {
        $tables = $this->_odbcResultToArray(
            odbc_tables(
                $this->connection(), 
                'db', 
                $this->_user, 
                (strlen($prefix) > 0) ? ($prefix . '%') : $prefix, 
                'TABLE, VIEW'
            ), 
            true, 
            'TABLE_NAME'
        );
        
        return $tables;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface 
     */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        // replacings needed?
        if ($limit < PHP_INT_MAX) {
            $selectRegex   = '/SELECT(\s+DISTINCT)?/i';
            $selectReplace = sprintf('$0 TOP %d, %d', (int)$offset, (int)$limit);
            $sqlQuery      = preg_replace($selectRegex, $selectReplace, (string)$sqlQuery);
        }
        
        $resultArray = array();

        if ($result = $this->_execSql((string)$sqlQuery)) {
            $resultArray = $this->_odbcResultToArray($result);
        }
                
        return $resultArray;
    }
    
    // ------------------------------------------------------------------------
    // --- Public Methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Builds a SPARQL-compatible literal string with long literals if necessary.
     *
     * @param string $value
     * @param string|null $datatype
     * @param string|null $lang
     * @return string
     */
    public function buildLiteralString($value, $datatype = null, $lang = null)
    {
        return Erfurt_Utils::buildLiteralString($value, $datatype, $lang);
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
                    $triples .= sprintf('%s %s %s .%s', $resource, $property, $value, PHP_EOL);
                }
            }
        }
        
        return $triples;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * @todo Rename countMatchingStatements
     */
    public function countWhereMatches($graphUris, $whereSpec, $countSpec, $distinct = false)
    {
        if (empty($graphUris)) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('No graph URI given.');
        }
        if($distinct){
            $distinct = "DISTINCT";
        } else {
            $distinct = "";
        }
        
        // more error save
        if ($countSpec == '?*') {
            $countSpec = '*';
        }
        
        $fromSpec = implode('> FROM <', (array)$graphUris);
        $countQuery = sprintf(
            'SELECT COUNT %s (%s) FROM <%s> %s',
            $distinct,
            $countSpec,
            $fromSpec,
            $whereSpec);

        if ($rid = $this->_execSparql($countQuery)) {
            $count = (int)odbc_result($rid, 1);
            return $count;
        }

        return 0;
    }

    /**
     * Recursively gets owl:imported model IRIs starting with $modelUri as root.
     *
     * @param string $modelUri
     */
    public function getImportsClosure($modelUri)
    {
        $queryCache = Erfurt_App::getInstance()->getQueryCache();

        if (!array_key_exists($modelUri, $this->_importedModels)) {
            $models = array();
            $result = array(
                // mock first result
                array('o' => $modelUri)
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

                $result = $queryCache->load( $query, STORE_RESULTFORMAT_PLAIN );
                if ($result == $queryCache::ERFURT_CACHE_NO_HIT) {
                    $startTime = microtime(true);
                    $result = $this->sparqlQuery($query);
                    $duration = microtime(true) - $startTime;
                    $queryCache->save( $query , STORE_RESULTFORMAT_PLAIN, $result, $duration );
                }
            } while ($result);
            
            // unset root node
            unset($models[$modelUri]);
            
            // cache result
            $this->_importedModels[$modelUri] = array_keys($models);
        }
        return $this->_importedModels[$modelUri];
    }
    
    /**
     * Returns the last ODBC error message and number.
     *
     * @return string
     */
    public function getLastError() 
    {
        if (null !== $this->connection()) {
            $message = sprintf('%s (%i)', odbc_errormsg($this->connection()), odbc_error($this->connection()));
            return $message;
        }
    }
    
    // ------------------------------------------------------------------------
    // --- Protected Methods --------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Closes a current connection if it exists
     */
    protected function _closeConnection()
    {
        if (is_resource($this->_connection)) {
            // close connection
            @odbc_close($this->_connection);
        }
    }
    
    /**
     * Creates a fulltext index to be used with bif:contains matching.
     *
     * @throws Erfurt_Store_Adapter_Exception
     */ 
    protected function _createFullTextIndexRules()
    {
        $pre = microtime(true);
        $this->_execSql('DB.DBA.RDF_OBJ_FT_RULE_ADD(NULL, NULL, \'' . self::FULLTEXT_INDEX_NAME . '\')');
        $this->_execSql('DB.DBA.VT_INC_INDEX_DB_DBA_RDF_OBJ()');
        
        if (defined('_EFDEBUG')) {            
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->info(sprintf('Creating Virtuoso full-text index: %f ms', (microtime(true) - $pre) * 1000));
        }
    }
    
    /**
     * Executes a SPARQL query and returns an ODBC result identifier.
     *
     * @param string $sparqlQuery
     * @param string $graphUri
     * @return ODBC result identifier
     * @throws Erfurt_Store_Adapter_Exception
     */
    private function _execSparql($sparqlQuery, $graphUri = null) 
    {
        $graphUri = (string)$graphUri;
        
        if (!empty($graphUri)) {
            // enquote
            $graphUri = '\'' . $graphUri . '\'';
        } else {
            // set Virtuoso NULL
            $graphUri = 'NULL';
        }
        
        // escape characters that delimit the query within the query
        $sparqlQuery = addcslashes($sparqlQuery, '\'\\');
        
        // build Virtuoso/PL query
        $virtuosoPl = 'CALL DB.DBA.SPARQL_EVAL(\'' . $sparqlQuery . '\', ' . $graphUri . ', 0)';
        
        $resultId = @odbc_exec($this->connection(), $virtuosoPl);
        
        if (false === $resultId) {
            $message = sprintf('SPARQL Error: %s in query: %s', $this->getLastError(), htmlentities($sparqlQuery));
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception($message);
        }
        
        return $resultId;
    }
    
    /**
     * Executes a SQL statement and returns an ODBC result identifier.
     *
     * @param  string $sqlQuery
     * @return ODBC result identifier
     * @throws Erfurt_Store_Adapter_Exception
     */
    protected function _execSql($sqlQuery) 
    {
        $resultId = @odbc_exec($this->connection(), $sqlQuery);
        
        if (false === $resultId) {
            $message = sprintf('SQL Error: %s in query: %s', $this->getLastError(), $sqlQuery);
            
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception($message);
        }
        
        return $resultId;
    }
    
    /**
     *  Returns the query configuration for a given query type.
     *
     * @param string $format The result format
     * @return array
     */
    protected function _getQueryConfig($format = 'plain')
    {
        $queryConfigs = array(
            'json' => array(
                'singleField' => true,
                'converter'   => null,
                'jsonEncode'  => false,
                'queryPrefix' => 'define output:format "JSON"'
            ), 
            // We now parse extended format via JSON
            'extended' => array(
                'singleField' => 'true',
                'converter'   => 'Json',
                'jsonEncode'  => false,
                'queryPrefix' => 'define output:format "JSON"'
            ),
            'xml' => array(
                'singleField' => true, 
                'converter'   => array('Json', 'SparqlResultsXml'),
                'jsonEncode'  => false, 
                'queryPrefix' => 'define output:format "JSON"'
            ), 
            'n3' => array(
                'singleField' => true, 
                'converter'   => null,
                'jsonEncode'  => false, 
                'queryPrefix' => 'define output:format "TTL"'
            ), 
            'plain' => array(
                'singleField' => false, 
                'converter'   => null,
                'jsonEncode'  => false, 
                'queryPrefix' => ''
            )
        );
        
        if (array_key_exists($format, $queryConfigs)) {
            return $queryConfigs[$format];
        }
        
        return $queryConfigs['plain'];
    }
    
    /**
     * Returns an SQL query to be used for importing statements from a file
     * or a URL.
     *
     * @param string $method 'file' or 'url'
     * @param mixed $data If $method is 'file', this is the path to a file containing triples;
     *        if $method is 'url', this is a URL.
     * @param string $type 'n3', 'nt' or 'rdf' 
     * @param string $graphUri The graph URI
     * @param string $baseUri The base URI
     * @return string
     */
    protected function _getImportSql($method, $data, $type, $graphUri, $baseUri = null)
    {
        // default base URI to graph URI if not given 
        // (will be overriden by document directives e. g. xml:base)
        if ($baseUri === null) {
            $baseUri = $graphUri;
        }
        
        // check type parameter
        switch (strtolower($type)) {
            case 'n3':  // N3
            case 'nt':  // N-Triple (is N3 subset)
            case 'ttl': // Turtle   (is N3 subset)
                // use TTLP function from Virtuoso (is N3 capable)
                $importFunc = 'TTLP';
                break;
            case 'rdf': // RDF-XML
            case 'rdfxml':
            default:    // unknown defaults to RDF-XML
                $importFunc = 'RDF_LOAD_RDFXML';
                break;
        }
        
        if ($method === 'url') {
            $importSql = sprintf(
                "CALL DB.DBA.%s(XML_URI_GET_AND_CACHE('%s'), '%s', '%s')", 
                $importFunc, 
                $data, 
                $baseUri, 
                $graphUri);
        } else {
            // import using internal Virtuoso/PL function
            $importSql = sprintf(
                "CALL DB.DBA.%s(FILE_TO_STRING_OUTPUT('%s'), '%s', '%s')", 
                $importFunc, 
                $data, 
                $baseUri, 
                $graphUri);
        }
        
        return $importSql;
    }
    
    /**
     * Converts an ODBC result to an array.
     *
     * @param boolean $columnsAsKeys If true, column names are used as indices.
     * @param string $field Non-null values denote the only column name that is returned as the 
     *        result for a row. If null, all column values are returned in an array.
     *
     * @return array
     */
    private function _odbcResultToArray($odbcResult, $columnsAsKeys = true, $field = null)
    {
        // the result will be stored in here
        $resultArray = array();
        
        // get number of fields (columns)
        $numFields = odbc_num_fields($odbcResult);
        
        // Return empty array on no results (0) or error (-1)
        if ($numFields < 1) {
            return $resultArray;
        }
        
        // for all rows
        while (odbc_fetch_row($odbcResult)) {
            $resultRowNamed = array();

            // for all columns
            for ($i = 1; $i <= $numFields; ++$i) {
                $fieldName = odbc_field_name($odbcResult, $i);
                $fieldType = odbc_field_type($odbcResult, $i);
                $value     = '';

                if (substr($fieldType, 0, 4) == 'LONG') {
                    // LONG VARCHAR or LONG VARBINARY
                    // get the field value in parts
                    while ($segment = odbc_result($odbcResult, $i)) {
                        $value .= (string)$segment;
                    }
                } else {
                    // get the field value normally
                    $value = odbc_result($odbcResult, $i);
                }

                if (null !== $field) {
                    // add only requested field
                    if ($fieldName == $field) {
                        $resultRowNamed = $value;
                    }
                } else {
                    // add all fields
                    if ($columnsAsKeys) {
                        $resultRowNamed[$fieldName] = $value;
                    } else {
                        $resultRowNamed[] = $value;
                    }
                }
            }

            // add row to result array
            array_push($resultArray, $resultRowNamed);
        }
        
        return $resultArray;
    }
    
    /**
     * Returns a data URI with the Virtuoso logo png image.
     *
     * @return string
     */
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
}
