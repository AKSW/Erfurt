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

include_once 'ARC2/ARC2.php';

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
class Erfurt_Store_Adapter_Arc implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
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

    protected $_parser = null;
    protected $_store = null;
    protected $_sparqlEndpoint = null;
    
    // ------------------------------------------------------------------------
    // --- Magic Methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @throws Erfurt_Store_Adapter_Exception
     *
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function __construct($adapterOptions = array())
    {
        try{
            #include_once '../../ARC/ARC2.php';
            #include_once '/usr/local/ARC/ARC2.php';
            #include_once $adapterOptions['path_to_arc'].'ARC2.php';
            

            $this->_parser = ARC2::getRDFParser();
            $config = array(
              /* db */
              'db_host' => $adapterOptions['host'], /* default: localhost */
              'db_name' => $adapterOptions['dbname'],
              'db_user' => $adapterOptions['username'],
              'db_pwd'  => $adapterOptions['password'],
              /* store */
              'store_name' => $adapterOptions['store'],
              /* network */
              #'proxy_host' => '192.168.1.1',
              #'proxy_port' => 8080,
              /* parsers */
              'bnode_prefix' => 'bn',
              /* sem html extraction */
              'sem_html_formats' => 'rdfa microformats',
                /* endpoint */
              'endpoint_features' => array(
                'select', 'construct', 'ask', 'describe',
                'load', 'insert', 'delete',
                'dump' /* dump is a special command for streaming SPOG export */
              ),
              'endpoint_timeout' => 60, /* not implemented in ARC2 preview */
              'endpoint_read_key' => '', /* optional */
              'endpoint_write_key' => 'somekey', /* optional */
              'endpoint_max_limit' => 250, /* optional */
            );

            $this->_store = ARC2::getStore($config);
            if (!$this->_store->isSetUp()) {
              $this->_store->setUp();
            }
            

            # Daten laden
            #$rdfParser = ARC2::getRDFParser();
            #$rdfParser->parse('/home/flo/Dokumente/work/uni/wenig_triple.ttl');
            #$triples = $rdfParser->getTriples();
            #$this->_store->insert($triples, 'http://example.org/test');                                       // funktioniert
            //$this->_store->insert('/home/flo/Dokumente/work/uni/100k_dataset.turtle', 'http://example.org/test');     // fehler
            //$this->_store->query('LOAD <http://localhost/wenig_triple.ttl>');                                         // funktioniert
            //$this->_store->query('LOAD <http://localhost/100k_dataset.turtle>');                                      // funktioniert

            # Query
            
            /*$query = 'PREFIX bsbm: <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/vocabulary/>
                        PREFIX dc: <http://purl.org/dc/elements/1.1/>

                        SELECT DISTINCT ?offer ?price
                        WHERE {
                                ?offer bsbm:product <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/instances/dataFromProducer4/Product150> .
                                ?offer bsbm:vendor ?vendor .
                            ?offer dc:publisher ?vendor .
                                ?vendor bsbm:country <http://downlode.org/rdf/iso-3166/countries#US> .
                                ?offer bsbm:deliveryDays ?deliveryDays .
                                FILTER (?deliveryDays <= 3)
                                ?offer bsbm:price ?price .
                            ?offer bsbm:validTo ?date .
                            #FILTER (?date > "2008-06-06T00:00:00" )
                        }
                        ORDER BY ?price
                        LIMIT 10';
             * 
             *
             *
            $query = 'PREFIX bsbm: <http://www4.wiwiss.fu-berlin.de/bizer/bsbm/v01/vocabulary/>
                        PREFIX dc: <http://purl.org/dc/elements/1.1/>

                        SELECT DISTINCT ?s ?p
                        FROM <http://localhost/100k_dataset.turtle>
                        WHERE {
                                ?s ?p "practiced"
                        }';
             *
             *
             */
            /*$query = '
SELECT ?s ?p ?o
FROM <http://localhost/OntoWiki/Config/>
WHERE { ?s ?p ?o . ?s a <http://ns.ontowiki.net/SysOnt/Model> }';

*/
            /*
            $query = 'DROP GRAPH <http://localhost/wenig_triple.ttl>';

            # Query Parsen
            
            $parser = ARC2::getSPARQLParser();
            $parser->parse($query);
            if (!$parser->getErrors()) {
              $q_infos = $parser->getQueryInfos();
              print_r($q_infos);
            }
            else {
              echo "invalid query: " . print_r($parser->getErrors());
            }
            

            # Query an Store schicken + Ausgabe
            
            $result = $this->_store->query($query);
            echo "<br><br>";var_dump($result);echo "<br><br>";
            #var_dump($this->_store->getErrors());echo "<br><br>";
            $rows = $result['result']['rows'];
            foreach($rows as $row)
            {
                var_dump($row);echo "<br><br>";
            }die;
            #*/
            $this->_adapterOptions = $adapterOptions;

        } catch (Erfurt_Store_Adapter_Exception $e){
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw $e;
            exit;
        }
        
    }
    
    /**
     * Destructor
     *
     * @throws Erfurt_Exception
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function __destruct() 
    {
        // not required?
    }
    
    // ------------------------------------------------------------------------
    // --- Public Methods (Erfurt_Store_Adapter_Interface) --------------------
    // ------------------------------------------------------------------------
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function addMultipleStatements($graphUri, array $statementsArray, array $options = array())
    {
        $insertSparql = sprintf(
            'INSERT INTO <%s> {%s}', 
            $graphUri, 
            $this->buildTripleString($statementsArray));
        
        if (defined('_EFDEBUG')) {
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->debug('Add mutliple statements query: ' . PHP_EOL . $insertSparql);
        }
        
        return $this->_execSparql($insertSparql);
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
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
            INSERT INTO <' . $graphUri . '> {
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
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function createModel($graphUri, $type = Erfurt_Store::MODEL_TYPE_OWL)
    {
        $query = 'INSERT INTO <'.$graphUri.'> { <'.$graphUri.'> a <'.$type.'> . }';
        
        #var_dump($this->_store->query($query, 'raw', '', true));
        
        // force reloading graphs next time
        $this->_graphs = null;
        
        return true;
    }
    
    /**
     * Returns the current connection resource.
     * The resource is created lazily if it doesn't exist.
     * @retun resource
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function connection()
    {
        // not required?

        if (!$this->_connection) {
            $adapterOptions = $this->_adapterOptions;

            extract($adapterOptions);

            /*
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
                throw new Erfurt_Store_Adapter_Exception('Unable to connect to ARC Backend.');
                exit;
            }*/
        }
        
        return $this->_connection;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     *
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
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
            'DELETE FROM %s {%s %s %s.} WHERE {%s %s %s}', 
            $graphSpec, 
            $subjectSpec, 
            $predicateSpec, 
            $objectSpec, 
            $subjectSpec, 
            $predicateSpec, 
            $objectSpec
        );     
        
        // perform delete
        $rs = $this->_execSparql($deleteSparql);
        return $rs['result']['t_count'];

        /*if () {
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
        return 0;*/
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {
        $deleteSparql = sprintf(
            'DELETE FROM <%s> {%s}', 
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
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function deleteModel($graphUri)
    {
        $store = $this->_adapterOptions['store'];
        // delete triple
        $query =   "DELETE 
                    FROM ".$store."_triple
                    WHERE 	t IN (
                                    SELECT g.t as t 
                                    FROM 	".$store."_id2val as id
                                            JOIN ".$store."_g2t as g
                                            ON id.id = g.g 
                                    WHERE id.val = '".$graphUri."')
                            AND t NOT IN (
                                    SELECT t 
                                    FROM ".$store."_g2t
                                    WHERE 	t IN (
                                                    SELECT g.t as t 
                                                    FROM 	".$store."_id2val as id
                                                            JOIN ".$store."_g2t as g
                                                            ON id.id = g.g 
                                                    WHERE id.val = '".$graphUri."')
                                            AND g NOT IN (
                                                    SELECT id 
                                                    FROM ".$store."_id2val
                                                    WHERE val = '".$graphUri."'))";
        $result = $this->sqlQuery($query);
        
        // delete triple-model mapping
        $query =   "DELETE
                    FROM ".$store."_g2t
                    WHERE g IN (
                            SELECT id 
                            FROM ".$store."_id2val
                            WHERE val = '".$graphUri."')";
        $result .= $this->sqlQuery($query);
        
        // delete model
        $query =   "DELETE
                    FROM ".$store."_id2val
                    WHERE val = '".$graphUri."'";
        $result .= $this->sqlQuery($query);
        
        return $result;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     * @todo implement
     */
    public function exportRdf($graphUri, $serializationType = 'xml', $filename = null)
    {
        require_once 'Erfurt/Store/Adapter/Exception.php';
        throw new Erfurt_Store_Adapter_Exception('RDF export not implemented yet.');
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function getAvailableModels()
    {       
        if (null === $this->_graphs)
        {
            $store = $this->_adapterOptions['store'];
            $this->_graphs = array();
            $sql = "SELECT DISTINCT val 
                    FROM    ".$store."_g2t as a
                            JOIN ".$store."_id2val as b
                            ON a.g = b.id
                            JOIN ".$store."_triple as c
                            ON c.t = a.t";
            $rs = $this->_store->queryDB($sql, $this->_store->getDBCon());
            while($row = mysql_fetch_array($rs))
            {
                $this->_graphs[$row['val']] = true;
            }
        }
        
        return $this->_graphs;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    public function getBlankNodePrefix()
    {
        return self::BLANKNODE_PREFIX;
    }
    
    /**
     * @see Erfurt_Store
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    public function getLogoUri()
    {
        return $this->_xyz();
    }
    
    /**
     * @see Erfurt_Store
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    #public function getSearchPattern($stringSpec, $graphUris, $options)
    public function virtuoso_getSearchPattern($stringSpec, $graphUris, $options)
    {
        // NOT REQUIRED!
        /*
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
#                    *new Erfurt_Sparql_Query2_Function(
#                        $bifContains,
#                        array($subjectVariable, new Erfurt_Sparql_Query2_RDFLiteral($stringSpec))
#                    ),
                    // why doesnt this work???
                    // ANSWER: bif:contains uses virtuoso specific fulltext index only 
                    // available for object column uris could only be treated as codepoint representation
                    // of themselves -> Solution again is IRI (maybe not before PHP 6)
                    //
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

            #
            #$filter->getConstraint()->addElement(
            #    new Erfurt_Sparql_Query2_Function(
            #        $bifContains,
            #        array($oo_var, new Erfurt_Sparql_Query2_RDFLiteral($stringSpec))
            #    )
            #);
        }

        $searchPattern[] = $filter;

        return $searchPattern;*/
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    public function getSupportedExportFormats()
    {
        return array();
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
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
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function importRdf($graphUri, $data, $type, $locator)
    {

        try
        {
            switch($locator){
                case Erfurt_Syntax_RdfParser::LOCATOR_FILE:
                    $parser = ARC2::getRDFParser();
                    $parser->parse($data);
                    $this->_store->insert($parser->getTriples(), $graphUri);
                    break;
                case Erfurt_Syntax_RdfParser::LOCATOR_URL:
                    $this->_store->query('LOAD <'.$data.'>');
                    $sql = "UPDATE ".$this->_adapterOptions['store']."_id2val SET val = '".$graphUri."' WHERE val = '".$data."'";
                    $this->_execSql($sql);
                    break;
                default:
                    require_once 'Erfurt/Store/Adapter/Exception.php';
                    throw new Erfurt_Store_Adapter_Exception("Locator '$locator' not supported by ARC.");
                    break;
            }
        }
        catch (Erfurt_Store_Adapter_Exception $e) {
            throw new Erfurt_Store_Adapter_Exception('Error importing statements: ' . $e->getMessage() . '(maybe: '.$this->getLastError().')');
        }
        catch(Exception $e){
            throw new Exception('Error importing statements: ' . $e->getMessage() . '(maybe: '.$this->getLastError().')');
        }

        // success
        return true;
        
        /*

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
            $rs = $this->_execSql($importSql);
            
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
        return true;*/
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    public function init()
    {
        // not required?
        // create fulltext index rule and update index
        //$this->_createFullTextIndexRules();
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    public function isModelAvailable($graphUri)
    {
        $bool = array_key_exists((string)$graphUri, (array)$this->getAvailableModels());
        return $bool;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function sparqlAsk($query)
    {
        $rs = $this->_execSparql($query);
        return $rs['result'];
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function sparqlQuery($query, $options=array())
    {        
        $resultFormat = isset($options[STORE_RESULTFORMAT]) ?
                            $options[STORE_RESULTFORMAT] :
                            STORE_RESULTFORMAT_PLAIN;
        
        // load query config variables
        extract($this->_getQueryConfig($resultFormat));
        
        // prepare query
        #$query = $queryPrefix
        #       . PHP_EOL
        #       . (string)$query;
        //echo htmlentities($query);
        
        $rs = $this->_execSparql($query);
        
        $result = $rs['result']['rows'];
        
        #if ($rid = $this->_execSparql($query)) {
        if(!empty($result)){
            
            #$result = $this->_odbcResultToArray($rid);
            
            // map single field to complete result
            #if ($singleField) {
                // the result is in the first field of the first row                
                #var_dump("result: ".print_r($result,true));
                #var_dump("current(result): ".print_r(current($result),true));
            #    $result = current(current($result));
                #var_dump("SingleField (current(current(result)): ".$result);
            #}
            
            // convert XML result
            if (null !== $converter) {
                foreach ((array) $converter as $currentConverter) {                    
                    $converterClass = 'Erfurt_Store_Adapter_Virtuoso_ResultConverter_' . $currentConverter;                    
                    
                    require_once str_replace('_', '/', $converterClass) . '.php';
                    $converter = new $converterClass();
                    #$result = $converter->convert($result);

                    #var_dump($rs);
                    $result = $this->convertToSJP($rs);
                    #var_dump($result['bindings']);die;
                }
            }
            
            // encode as JSON string
            if ($jsonEncode) {
                $result = json_encode($result);
            }
            var_dump($query); var_dump($options);var_dump($result);#die;
            
            return $result;
        }
    }
    
    // ------------------------------------------------------------------------
    // --- Public Methods (Erfurt_Store_Adapter_Sql_Interface) ----------------
    // ------------------------------------------------------------------------
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
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
     * ## ARC ##
     * Basic: ? (FUNCTION ontowiki.IDENTITY_VALUE does not exist)
     * Final:
     * #########
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
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function listTables($prefix = '')
    {
        $query = "SHOW TABLES LIKE '".$prefix."%'";
        return $this->sqlQuery($query);
    }
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
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
        
        $rs = $this->_execSql((string)$sqlQuery);
        while($row = mysql_fetch_array($rs))
        {
            $resultArray[] = $row;
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
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    public function buildLiteralString($value, $datatype = null, $lang = null)
    {
        $longLiteral = false;
        $quoteChar   = (strpos($value, '"') !== false) ? "'" : '"';
        $value       = (string)$value;
        
        // datatype-specific treatment
        switch ($datatype) {
            case 'http://www.w3.org/2001/XMLSchema#boolean':
                $search  = array('0', '1');
                $replace = array('false', 'true');
                $value   = str_replace($search, $replace, $value);
                break;
            case '':
            case null:
            case 'http://www.w3.org/1999/02/22-rdf-syntax-ns#XMLLiteral':
            case 'http://www.w3.org/2001/XMLSchema#string':
                $value = addcslashes($value, $quoteChar);
                
                /** 
                 * Check for characters not allowed in a short literal
                 * {@link http://www.w3.org/TR/rdf-sparql-query/#rECHAR}
                 * wrong: \t\b\n\r\f\\\"\\\' 
                 */
                if (preg_match('/[\\\r\n"]/', $value) > 0) {
                    $longLiteral = true;
                    $value = trim($value, "\n\r");
                    // $value = str_replace("\x0A", '\n', $value);
                }
                break;
        }
        
        // add short, long literal quotes respectively
        $value = $quoteChar . ($longLiteral ? ($quoteChar . $quoteChar) : '')
               . $value 
               . $quoteChar . ($longLiteral ? ($quoteChar . $quoteChar) : '');
        
        // add datatype URI/lang tag
        if (!empty($datatype)) {
            $value .= '^^<' . (string)$datatype . '>';
        } else if (!empty($lang)) {
            $value .= '@' . (string)$lang;
        }
        
        return $value;
    }
    
    /**
     * Builds a string of triples in N-Triples syntax out of an RDF/PHP array.
     *
     * @param $rdfPhpStatements A nested statement array
     * @return string
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
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
     * ## ARC ##
     * Basic: ? Eingabe unklar
     * Final:
     * #########
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
        
        $fromSpec = implode('> FROM <', (array)$graphUris);
        $countQuery = sprintf(
            'SELECT %s COUNT(%s) AS ?counters FROM <%s> %s',
            $distinct,
            $countSpec,
            $fromSpec,
            $whereSpec);

        $rs = $this->_execSparql($countQuery);
        return (int) $rs['result']['rows'][0]['counters'];
        /*if ($rid = $this->_execSparql($countQuery)) {
            $count = (int)odbc_result($rid, 1);
            return $count;
        }

        return 0;*/
    }

    /**
     * Recursively gets owl:imported model IRIs starting with $modelUri as root.
     *
     * @param string $modelUri
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function getImportsClosure($modelUri)
    {
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
            } while ($result = $this->sparqlQuery($query));
            
            // unset root node
            unset($models[$modelUri]);
            
            // cache result
            $this->_importedModels[$modelUri] = array_keys($models);
        }
        
        return $this->_importedModels[$modelUri];
    }
    
    /**
     * Returns the last ARC error message
     *
     * @return string
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    public function getLastError() 
    {
        $errors = $this->_store->getErrors();
        return $errors[sizeof($errors)-1];
    }
    
    // ------------------------------------------------------------------------
    // --- Protected Methods --------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Closes a current connection if it exists
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    protected function _closeConnection()
    {
        // not required?
    }
    
    /**
     * Creates a fulltext index to be used with bif:contains matching.
     *
     * @throws Erfurt_Store_Adapter_Exception
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */ 
    protected function _createFullTextIndexRules()
    {
        // NOT REQUIRED!
        
        /*
        $pre = microtime(true);
        $this->_execSql('DB.DBA.RDF_OBJ_FT_RULE_ADD(NULL, NULL, \'' . self::FULLTEXT_INDEX_NAME . '\')');
        $this->_execSql('DB.DBA.VT_INC_INDEX_DB_DBA_RDF_OBJ()');
        
        if (defined('_EFDEBUG')) {            
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->info(sprintf('Creating Virtuoso full-text index: %f ms', (microtime(true) - $pre) * 1000));
        }*/
    }
    
    /**
     * Executes a SPARQL query and returns an ODBC result identifier.
     *
     * @param string $sparqlQuery
     * @param string $graphUri
     * @return ODBC result identifier
     * @throws Erfurt_Store_Adapter_Exception
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    private function _execSparql($sparqlQuery, $graphUri = null) 
    {
        // Query-Return:
        // query_type   = Typ der Query (z.B. Select, Insert, Ask etc)
        // result       = eigentliche Ergebnismenge
        // query_time   = Ausführungszeit
        return $this->_store->query($sparqlQuery);
        
        /*
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
        echo "<br>";
        var_dump("sparqlquery: ".$sparqlQuery);
        
        // build Virtuoso/PL query
        $virtuosoPl = 'CALL DB.DBA.SPARQL_EVAL(\'' . $sparqlQuery . '\', ' . $graphUri . ', 0)';
        var_dump("virtuosoPl: ".$virtuosoPl);

        $resultId = @odbc_exec($this->connection(), $virtuosoPl);
        var_dump("resultId: ".$resultId);
        
        if (false === $resultId) {
            $message = sprintf('SPARQL Error: %s in query: %s', $this->getLastError(), htmlentities($sparqlQuery));
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception($message);
        }
        
        return $resultId;*/
    }
    
    /**
     * Executes a SQL statement and returns an ODBC result identifier.
     *
     * @param  string $sqlQuery
     * @return ODBC result identifier
     * @throws Erfurt_Store_Adapter_Exception
     * ## ARC ##
     * Basic: +
     * Final: Test
     * #########
     */
    protected function _execSql($sqlQuery) 
    {
        // return resultSet
        return $this->_store->queryDB($sqlQuery, $this->_store->getDBCon());
        /*
        $resultId = @odbc_exec($this->connection(), $sqlQuery);
        
        if (false === $resultId) {
            $message = sprintf('SQL Error: %s in query: %s', $this->getLastError(), $sqlQuery);
            
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception($message);
        }
        
        return $resultId;*/
    }
    
    /**
     *  Returns the query configuration for a given query type.
     *
     * @param string $format The result format
     * @return array
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    protected function _getQueryConfig($format = 'plain')
    {
        $queryConfigs = array(
            'json' => array(
                'singleField' => true, 
                'converter'   => 'Extended',
                'jsonEncode'  => true, 
                'queryPrefix' => 'define output:format "RDF/XML"'
            ), 
            'extended' => array(
                'singleField' => true, 
                'converter'   => 'Extended',
                'jsonEncode'  => false, 
                'queryPrefix' => 'define output:format "RDF/XML"'
            ), 
            'xml' => array(
                'singleField' => true, 
                'converter'   => array('Extended', 'SparqlResultsXml'),
                'jsonEncode'  => false, 
                'queryPrefix' => 'define output:format "RDF/XML"'
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
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    protected function _getImportSql($method, $data, $type, $graphUri, $baseUri = null)
    {
        // NOT REQUIRED!
        /*
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
        
        return $importSql;*/
    }

    /**
     * Converts an ARC result to an SPARQL/JSON-like PHP-Format (here called SJP)
     * see: http://www.w3.org/TR/rdf-sparql-json-res/
     *
     * @param result  the arc result
     *
     * @return array
     * ## ARC ##
     * Basic: NEW
     * Final: NEW
     * #########
     */
    private function _convertToSJP($arcResult)
    {
        $bindings = array();
        foreach($arcResult['result']['rows'] as $row)
        {
            $rowBinding = array();
            foreach($arcResult['result']['variables'] as $var)
            {
                if(!empty($row[$var]))
                {
                    $rowBinding[$var] = array( 'type'  => $row[$var.' type'],
                                             'value' => $row[$var]
                                            );
                }
            }
            $bindings[] = $rowBinding;
        }

        $result = array(
                    'head' => array(
                        'vars' => $arcResult['result']['variables']
                    ),
                    'results' => array(
                        'bindings' => $bindings
                    ),
                    /**
                     * Ensures compatibility with erroneous pre-0.9.5 behaviour
                     * @deprecated 0.9.5
                     */
                    'bindings' => $bindings
                );

        return $result;
    }
    
    /**
     * Converts an ODBC result to an array.
     *
     * @param boolean $columnsAsKeys If true, column names are used as indices.
     * @param string $field Non-null values denote the only column name that is returned as the 
     *        result for a row. If null, all column values are returned in an array.
     *
     * @return array
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
     */
    private function _odbcResultToArray($odbcResult, $columnsAsKeys = true, $field = null)
    {
        // NOT REQUIRED!
        /*
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
        
        return $resultArray;*/
    }
    
    /**
     * Returns a data URI with the Virtuoso logo png image.
     *
     * @return string
     * ## ARC ##
     * Basic: +
     * Final: +
     * #########
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
