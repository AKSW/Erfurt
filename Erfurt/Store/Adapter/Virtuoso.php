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
 * @package    store
 * @author     Norman Heino <norman.heino@gmail.com>
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Store_Adapter_Virtuoso implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    /** @var ODBC connection id */
    private $_connection = null;
    
    /** @var boolean */
    private $_transactions = false;
    
    /** @var array */
    private $_virtuosoSpecialModels = array(
        'http://www.openlinksw.com/schemas/virtrdf#', 
        'http://localhost:8890/DAV'
    );
    
    /** @var array */
    private $_titleProperties = array(
        'http://www.w3.org/2000/01/rdf-schema#label', 
        'http://purl.org/dc/elements/1.1/title'
    );
    
    private $_models = false;
    
    /** 
     * An array of languages used in the store 
     */
    private $_languages = array();
    
    private $_longRead = false;
    
    /**
     * An array of languages appearing in
     * each model.
     */
    private $_modelLanguages = array();
    

    /**
     * An array that includes all necessary options for
     * http access to virtuoso key=>value style
     * useHTTP  
     * endpointURI
     * davFolder
     * username
     * password
     * 
     * 
     */
    private $_httpConfig = array();

    /**
     * Caching array for imported model IRIs.
     * Format: array(<model IRI> => array(<imported IRI>, ...))
     * @var array
     */
    private $_importedModels = array();
 
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
        $dsn        = $adapterOptions['dsn'];
        $username   = $adapterOptions['username'];
        $password   = $adapterOptions['password'];
        
        if(isset($adapterOptions['useHTTP']) && $adapterOptions['useHTTP']==true){
        	$this->_httpConfig['useHTTP'] 		= true;	
        	$this->_httpConfig['username'] 		= $username;	
        	$this->_httpConfig['password'] 		=  $password;	
        	$this->_httpConfig['endpointURI'] 	=  $adapterOptions['endpointURI'];	
        	$this->_httpConfig['davFolder'] 	=  $adapterOptions['davFolder'];	
         }else{
         	$this->_httpConfig['useHTTP'] 		= false;	
         }
        
        
        
        if (!function_exists('odbc_connect')) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Virtuoso adapter requires PHP ODBC extension to be loaded.');
            exit;
        }
        
        // try to connect
        $this->_connection = @odbc_connect($dsn, $username, $password);
        
        if (null == $this->_connection) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Unable to connect to Virtuoso Universal Server via ODBC: ' . $this->_getLastError());
            exit;
        }
        
        // load title properties for model titles
        $config = Erfurt_App::getInstance()->getConfig();
        if (isset($config->properties->title)) {
            $this->_titleProperties = $config->properties->title->toArray();
        }
        
        $result = $this->_execSql('SELECT DISTINCT rl_id FROM DB.DBA.RDF_LANGUAGE');
        while (odbc_fetch_row($result)) {
            $this->_languages[] = odbc_result($result, 1);
        }
    }
    
    /**
     * Destructor
     *
     * @throws Erfurt_Exception
     */
    public function __destruct() 
    {
        //
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
    public function addMultipleStatements($graphIri, array $statementsArray, $options = array())
    {
        // handle defaults
        $defaultOptions = array(
            'escape_literals' => true
        );
        $options = array_merge($defaultOptions, $options);
        $insertSparql = '
            INSERT INTO GRAPH <' . $graphIri . '> {
                ' . $this->_buildGraphPattern($statementsArray, false , $options['escape_literals']) . '
            }';
        
        return $this->_execSparql($insertSparql);
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function addStatement($graphIri, $subject, $predicate, $object, $options = array())
    {
        // handle defaults
        $options = array_merge(array(
            'subject_type'    => Erfurt_Store::TYPE_IRI, 
            'object_type'     => Erfurt_Store::TYPE_IRI, 
            'escape_literals' => true
        ), $options);
        
        if ($options['object_type'] == Erfurt_Store::TYPE_IRI) {
            // make IRI object
            $object = '<' . $object . '>';
        } else if ($options['object_type'] == Erfurt_Store::TYPE_LITERAL) {
            // make secure literal object 
            $object = $this->_buildLiteralString($object, (isset($options['literal_datatype'])) ? $options['literal_datatype'] : null);        
        }
        
        // datatype/language
        if (array_key_exists('literal_language', $options)) {
            $object .= '@' . $options['literal_language'];
        } else if (array_key_exists('literal_datatype', $options)) {
            $object .= '^^<' . $options['literal_datatype'] . '>';
        }
        
        // TODO: support blank nodes as subject
        $insertSparql = '
            INSERT INTO GRAPH <' . $graphIri . '> {
                <' . $subject . '> <' . $predicate . '> ' . $object . '
            }';
        
        return $this->_execSparql($insertSparql);
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
        #var_dump($createTable);exit;       
        return $this->sqlQuery($createTable);
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, $options = array())
    {        
        $subjectSpec   = $subject   ? '<' . $subject . '>'   : '?s';
        $predicateSpec = $predicate ? '<' . $predicate . '>' : '?p';
        $objectSpec    = $object    ? '<' . $object . '>'    : '?o';
        
        $deleteSparql = '
            DELETE FROM GRAPH <' . $graphUri . '> {' . $subjectSpec . ' ' . $predicateSpec . ' ' . $objectSpec . '.}
            WHERE {
                GRAPH <' . $graphUri . '> {' . $subjectSpec . ' ' . $predicateSpec . ' ' . $objectSpec . '.}
            }
        ';
        
        return $this->_execSparql($deleteSparql);
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
        $deleteSparql = '
            DELETE FROM GRAPH <' . $graphIri . '> {
                ' . $this->_buildGraphPattern($statementsArray, true) . '
            }
        ';
        // var_dump($deleteSparql);exit;
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
        $query  = 'SELECT DISTINCT ?s ';
        $query .= 'FROM <' . implode($graphUris, '>' . PHP_EOL . 'FROM <') . '> ';
        $query .= 'WHERE {
            ?s ?p ?o.
            ' . ($options['filter_properties'] ? '?ss ?s ?oo.' : '') . '
            FILTER (bif:contains(?o, \'"' . $stringSpec . '*"\'))
        }';
        
        $resources = array();
        if ($results = $this->sparqlQuery($query)) {
            foreach ($results as $row) {
                array_push($resources, $row['s']);
            }
        }
        
        return $resources;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getAvailableModels($withTitle = false) {        
        if (!$this->_models) {
            $this->_models = array();
            
            if ($withTitle) {
                $select = '';
                $where  = array();
                $order  = '';
                
                $where[] = ' {GRAPH ?graph {?graph <' . EF_RDF_TYPE . '> ?o.}}';
                foreach ($this->_titleProperties as $key => $uri) {
                    $select .= ' ?graph' . $key;
                    $where[] = ' {GRAPH ?graph {OPTIONAL {?graph <' . $uri . '> ?graph' . $key . '}}}';
                    $order   = ' ?graph' . $key . $order;
                }
                $query   = 'SELECT ?graph' . $select . ' WHERE {' . implode(' UNION ', $where) . '} ORDER BY' . $order;
                // var_dump((string) $query);
                
                $result = $this->_execSparql($query);
                while (odbc_fetch_row($result)) {
                    $graph = odbc_result($result, 1);
                    if (!in_array($graph, $this->_virtuosoSpecialModels)) {
                        if (!array_key_exists($graph, $this->_models)) {
                            $this->_models[$graph] = array('modelIri' => $graph);
                        }
                        for ($i = 2; $i <= odbc_num_fields($result); ++$i) {
                            $title = odbc_result($result, $i);
                            // echo $title;exit;
                            if (!empty($title) && !array_key_exists('label', $this->_models[$graph])) {
                                $this->_models[$graph]['label'] = $title;
                                break;
                            }
                        }
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
        // var_dump($this->_models);
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
        require_once 'Erfurt/Syntax/RdfParser.php';
        
        $func = null;
        if ($locator === Erfurt_Syntax_RdfParser::LOCATOR_FILE && is_readable($data)) {
            $func = '_importStatementsFromFile';
        } else if ($locator === Erfurt_Syntax_RdfParser::LOCATOR_URL) {
            $func = '_importStatementsFromUrl';
        } else {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception("Locator '$loactor' is not supported by Virtuoso.");
        }
        
        if ($func) {
            return $this->$func($data, $type, $graphIri);
        }
    }
    
    public function init()
    {
        // Nothing to be done here.
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function isModelAvailable($graphIri, $useAc = true) 
    {
        if (is_string($graphIri)) {
            // check if graph exists in database
            $result = $this->_execSparql('ASK WHERE {GRAPH <' . $graphIri . '> {?s ?p ?o.}}');
            
            if (odbc_result($result, 1)) {
                return true;
            }
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
        $result = $this->_execSparql($query);
        
        if (odbc_result($result, 1) == '1') {
            return true;
        }
        
        return false;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlQuery($query, $resultFormat = 'plain') 
    {    
    	
    	 if($this->_httpConfig['useHTTP']==true){
    	 	return  $this->_httpSelect($query, $resultFormat);
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
        
        if ($result = $this->_execSparql($query)) {
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
            '/SELECT/i'         => 'SELECT ' . $selectAdd, 
            '/LIMIT\s+(\d+)/i'  => '', 
            '/OFFSET\s+(\d+)/i' => ''
        );
        
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
    
    /**
     * Builds a sparql graph pattern from an array of statements.
     *
     * @param $statementsArray an array of statements in RDF/PHP structure.
     *
     * @return string
     */
    private function _buildGraphPattern(array $statementsArray, $handleStringBug = false, $escapeLiterals = true)
    {
        $triples = '';
        foreach ($statementsArray as $subject => $predicateArray) {
            foreach ($predicateArray as $predicate => $objectsArray) {
                foreach ($objectsArray as $object) {
                    $triples .= '<' . $subject . '> <' . $predicate . '> ';
                    
                    switch ($object['type']) {
                        case 'uri':
                            $triples .= '<' . $object['value'] . '>';
                            break;
                        case 'literal':
                            $object['value'] = $this->_buildLiteralString(
                                $object['value'], 
                                isset($object['datatype']) ? $object['datatype'] : null
                            );
                            
                            $triples .= $object['value'] ;
                            
                            if (array_key_exists('datatype', $object)) {
                                if ($handleStringBug && $object['datatype'] == 'http://www.w3.org/2001/XMLSchema#string') {
                                    // add string triple w/o datatype
                                    $triples .= '.' . PHP_EOL . '<' . $subject . '> <' . $predicate . '> ' . $object['value'] ;
                                } else {
                                    $triples .= '^^<' . $object['datatype'] . '>';
                                }
                            } else if (array_key_exists('lang', $object)) {
                                $triples .= '@' . $object['lang'];
                            }
                            break;
                    }
                    
                    $triples .= '.' . PHP_EOL;
                }
            }
        }
        #var_dump($triples);exit;
        
        return $triples;
    }
    
    /**
     * Builds a SPARQL-compatible literal string with long literals if necessary.
     */
    private function _buildLiteralString($literal, $datatype = 'http://www.w3.org/2001/XMLSchema#string')
    {
        $longLiteral = false;
        $literal     = (string) $literal;
        $quoteChar   = (strpos($literal, '"') !== false) ? "'" : '"';
        
        switch ($datatype) {
            case 'http://www.w3.org/2001/XMLSchema#boolean':
                $search  = array('0', '1');
                $replace = array('false', 'true');
                $literal = str_replace($search, $replace, $literal);
            break;
            case 'http://www.w3.org/2001/XMLSchema#string':
            case '':
            case null:
                $literal = addcslashes($literal, $quoteChar);
                
                /** 
                 * Check for characters not allowed in a short literal
                 * {@link http://www.w3.org/TR/rdf-sparql-query/#rECHAR}
                 */
                if (preg_match('/[\t\b\n\r\f\\\"\\\']/', $literal) !== false) {
                    $longLiteral = true;
                }
            break;
        }
        
        $literal = $quoteChar . ($longLiteral ? $quoteChar . $quoteChar : '')
                 . $literal 
                 . $quoteChar . ($longLiteral ? $quoteChar . $quoteChar : '');
        
        return $literal;
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
    	//echo $sparqlQuery;
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
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('SPARQL Error: ' . $this->_getLastError() . '<br />' . 'Query: ' . $sparqlQuery);
        }
        
        if ($this->_longRead) {
            // odbc_longreadlen($result, 100000000);
            odbc_longreadlen($result, 16777216);
            $this->_longRead = false;
        }
        
        return $result;
    }
    
    
    private function _httpUpdate( $sparqlQuery){
        	$username 		= $this->_httpConfig['username'];	
        	$password 		= $this->_httpConfig['password'];	
        	$endpointURI 	= $this->_httpConfig['endpointURI'];	
        	$davFolder 		= $this->_httpConfig['davFolder'];

    		$url = $endpointURI.$davFolder;
    		$client = new Zend_Http_Client($url, array());
    		$client->setMethod(Zend_Http_Client::POST);
    		$client->setRawData($query, 'application/sparql-query');
			$client->setAuth($username, $password);
			$response =  $client->request();
			//testing below here:
			
			//var_dump($client);
			echo "Answer\n";
			echo $response->getStatus();
			echo $response->getMessage();
    }
    
    /*
		All SPARQL queries that can be sent via http
*/
    
    private function _httpSelect( $sparqlQuery, $resultFormat = 'plain'){
    		$username 		= $this->_httpConfig['username'];	
        	$password 		= $this->_httpConfig['password'];	
        	$endpointURI 	= $this->_httpConfig['endpointURI'];	
        	
    		$sparqlQuery = urlencode($sparqlQuery);
    		$url = $endpointURI.'/sparql?query='.$sparqlQuery;
    		require_once('Zend/Http/Client.php');
    		$client = new Zend_Http_Client();
    		$client->setAuth($username, $password);
    		
    		//FORMAT issues:
    		$format = ($resultFormat=='plain')?'JSON':$resultFormat;
    		$url .='&format='.$format;
    		$client->setUri($url);
    		
			$response =  $client->request();
			$result = $response->getBody();
			
			//TODO catch errors here
			
			switch ($resultFormat ){
				case 'JSON': return $result;
				case 'xml': return $result;
				case 'plain' : {
					$retval = array();
					$j = json_decode($result,true);
					
					foreach ($j['results']['bindings'] as $b){
						$tmp=array();
						foreach ($b as $key=>$value){
							$tmp[$key]  = $value['value'];
						}//foreach 
						$retval[]=$tmp;
					}//foreach 
				}return $retval;
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
        
        if ($this->_longRead) {
            odbc_longreadlen($result, 0);
            $this->_longRead = false;
        }
        
        if (false === $result) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('SQL Error: ' . $this->_getLastError() . ' ' .
            $sqlQuery);
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
    private function _importStatementsFromFile($file, $type, $graphUri, $baseUri = '') 
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
        
        // import using internal Virtuoso/PL function
        $importSql = sprintf("CALL DB.DBA.%s(FILE_TO_STRING_OUTPUT('%s'), '%s', '%s')", $importFunc, $file, $baseUri, $graphUri);
        
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
        
        $importSql = sprintf("CALL DB.DBA.%s(XML_URI_GET_AND_CACHE('%s'), '%s', '%s')", $importFunc, $url, $baseUri, $graphUri);
        
        try {
            if ($this->_execSql($importSql)) {
                // TODO: owl:imports
                return $this->getModel($graphUri);
            }
        } catch (Erfurt_Store_Adapter_Exception $e) {
            throw new Erfurt_Store_Adapter_Exception('Error importing statements: ' . $e->getMessage());
        }
    }
}
