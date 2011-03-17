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

/** ARC library **/
require_once 'ARC2/ARC2.php';

/**
 * ARC Adapter for the Erfurt Semantic Web Framework.
 *
 * Connects to a MySQL-DB via ARC
 *
 * @category Erfurt
 * @package Store_Adapter
 * @author Florian Agsten <florianagsten@googlemail.com>
 * @copyright Copyright (c) 2011, {@link http://aksw.org AKSW}
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
        
    // ------------------------------------------------------------------------
    // --- Protected Properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
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

    /*
     * The ARC-rdf-parser
     */
    protected $_parser = null;
    /*
     * The ARC-store
     */
    protected $_store = null;
    
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
        #$this->count = 0;
        try{
            if(isset($adapterOptions['store']))
                $storeName = $adapterOptions['store'];
            else
                $storeName = 'ef';
            $config = array(
              /* db */
              'db_host' => $adapterOptions['host'], /* default: localhost */
              'db_name' => $adapterOptions['dbname'],
              'db_user' => $adapterOptions['username'],
              'db_pwd'  => $adapterOptions['password'],
              /* store */
              'store_name' => $storeName,
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
            $this->_adapterOptions = $adapterOptions;
            $this->_adapterOptions['store'] = $storeName;

            $this->_parser = ARC2::getRDFParser();

            $this->_store = ARC2::getStore($config);
            if (!$this->_store->isSetUp()) {
              $this->_store->setUp();
            }
/*
            $query2 = "SELECT DISTINCT ?resourceUri ?classUri
WHERE {
?resourceUri ?p ?classUri.

    FILTER(sameTerm(?resourceUri, <http://ns.ontowiki.net/SysOnt/AnyModel>) || sameTerm(?resourceUri, <http://ns.ontowiki.net/SysOnt/AnyAction>))
    FILTER langMatches( ?resourceUri, 'FR' )
    FILTER regex(?name, '^ali', 'i')
    FILTER sameTerm(?resourceUri, <http://ns.ontowiki.net/SysOnt/AnyModel>) || sameTerm(?resourceUri, <http://ns.ontowiki.net/SysOnt/AnyAction>)
}
";
 *

OPTIONAL {
?resourceUri <http://ns.ontowiki.net/SysOnt/hidden> ?reg
}
OPTIONAL {
?resourceUri <http://www.w3.org/2000/01/rdf-schema#subClassOf> ?super
}
FILTER (isURI(?resourceUri))
FILTER (!BOUND(?reg))
FILTER (!REGEX(STR(?resourceUri), '^http://www.w3.org/1999/02/22-rdf-syntax-ns#'))
FILTER (!REGEX(STR(?resourceUri), '^http://www.w3.org/2000/01/rdf-schema#'))
FILTER (!REGEX(STR(?resourceUri), '^http://www.w3.org/2002/07/owl#'))
FILTER (REGEX(STR(?super), '^http://www.w3.org/2002/07/owl#') || !BOUND(?super))
  *
            $query = "SELECT DISTINCT ?resourceUri
FROM <http://localhost/100k_dataset.rdf>
WHERE {
{
?sub <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?resourceUri
}
OPTIONAL {
?resourceUri <http://ns.ontowiki.net/SysOnt/hidden> ?reg
}
OPTIONAL {
?resourceUri <http://www.w3.org/2000/01/rdf-schema#subClassOf> ?super
}
FILTER (isURI(?resourceUri))
FILTER (!BOUND(?reg))
FILTER (!REGEX(STR(?resourceUri), '^http://www.w3.org/1999/02/22-rdf-syntax-ns#'))
FILTER (!REGEX(STR(?resourceUri), '^http://www.w3.org/2000/01/rdf-schema#'))
FILTER (!REGEX(STR(?resourceUri), '^http://www.w3.org/2002/07/owl#'))
FILTER (REGEX(STR(?super), '^http://www.w3.org/2002/07/owl#') || !BOUND(?super))


}

";
 /* $query = "SELECT DISTINCT ?s ?p ?o
               WHERE{ ?s ?p ?o }
";
#*
            $this->test_execSparql($query);
/*
            $newQuery = preg_replace("#\?#","?__",$query);
            var_dump($query);
            var_dump($newQuery);
            exit;
            $test = explode("WHERE", $query);
            $test = explode("FROM", $test[0]);
            # SELECT $test[0]
            $test = explode("?", $test[0]);
            var_dump($test);exit;

            var_dump($query2);
            $filters = explode("FILTER", $query2);
            $updatedQuery = $filters[0];
            for($i = 1; $i < sizeof($filters); $i++)
            {                
                if(strpos($filters[$i],"sameTerm"))
                {
                    $filters[$i] = preg_replace(array("#sameTerm\(#","#,#"),array("(", " = "),$filters[$i]);
                }
                $updatedQuery .= "FILTER ".$filters[$i];
            }
            var_dump($updatedQuery);exit;

            #FILTER (sameTerm(?p, http://ns.ontowiki.net/SysOnt/grantModelEdit))
            #http://ns.ontowiki.net/SysOnt/grantModelEdit
         #   $query = "SELECT ?s ?p ?o
         #       WHERE{
         #       ?s ?p ?o}";
                            #http://www.w3.org/2002/07/owl#Class
                            #http://www.w3.org/2002/07/owl#Class
 
            $rs = $this->_store->query($query);
            var_dump($this->_store->getErrors());
            foreach($rs as $row)
            {
                var_dump($row);
            }exit;
            #var_dump($this->sparqlQuery($query));

            #exit;

            #$query = "INSERT INTO arc_test2_g2t VALUES (999999,9999999);";
            #var_dump($this->_execSql($query));exit;*/

        } catch (Erfurt_Store_Adapter_Exception $e){
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw $e;
            exit;
        }
        
    }
    
    // ------------------------------------------------------------------------
    // --- Public Methods (Erfurt_Store_Adapter_Interface) --------------------
    // ------------------------------------------------------------------------
    
    /**
     * @see Erfurt_Store_Adapter_Interface
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
        
        $insertSparql = '
            INSERT INTO <' . $graphUri . '> {
                <' . $subject . '> <' . $predicate . '> ' . $object . '
            }';
        
        #if (defined('_EFDEBUG')) {
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->debug('Add statement query: ' . PHP_EOL . $insertSparql);
        #}
        
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
        $query = 'INSERT INTO <'.$graphUri.'> { <'.$graphUri.'> a <'.$type.'> . }';
        
        $this->_store->query($query, 'raw', '', true);
        
        // force reloading graphs next time
        $this->_graphs = null;
        
        return true;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     *
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
        if(isset($rs['result']['t_count']))
            return $rs['result']['t_count'];
        else
            return 0;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {
        if(empty($statementsArray))
            return true;

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
        #if (null === $this->_graphs)
        #{
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
        #}
        
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
            'rdfxml' => 'RDF/XML'
        );
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function importRdf($graphUri, $data, $type, $locator)
    {

        try
        {
            switch($locator){
                case Erfurt_Syntax_RdfParser::LOCATOR_FILE:
                    $parser = ARC2::getRDFParser();
                    $parser->parse($data);
                    # insert triple
                    $this->_store->insert($parser->getTriples(), $graphUri);
                    # insert prefix
                    #$model = new Erfurt_Rdf_Model($graphUri);
                    #$prefixes = $parser->getParsedNamespacePrefixes();
                    #foreach($prefixes as $namespace => $prefix)
                    #{
                    #    $model->addPrefix($prefix, $namespace);
                    #}

                    /*
                     * s
    the subject value (a URI, Bnode ID, or Variable)
p
    the property URI (or a Variable)
o
    the subject value (a URI, Bnode ID, Literal, or Variable)
s_type
    "uri", "bnode", or "var"
o_type
    "uri", "bnode", "literal", or "var"
o_datatype
    a datatype URI
o_lang
    a language identifier, e.g. ("en-us")
                     */
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
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function init()
    {
    }

    #private $count = 0;
    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function isModelAvailable($graphUri)
    {
        /*$models = (array) $this->getAvailableModels();
        $bool = false;
        $bool = array_key_exists((string)$graphUri, $models);
        $logger = Erfurt_App::getInstance()->getLog();
        $this->count++;
        $logger->debug('ARC::isModelAvailable('.$graphUri.')['.$this->count.']: '.$bool);#.'/n '.print_r($models,true));
        return $bool;*/
        return array_key_exists((string)$graphUri, (array) $this->getAvailableModels());
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function sparqlAsk($query)
    {
        $rs = $this->_execSparql($query);
        if(isset($rs['result']))
            return $rs['result'];
        else
            return array();
    }
    
    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function sparqlQuery($query, $options=array(), $debug=false)
    {
        $logger = Erfurt_App::getInstance()->getLog();
        if(strpos($query, "?sub <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?resourceUri ") != false)
        {
            $logger->debug($query);
        }

        $result = array();
        $resultFormat = isset($options[STORE_RESULTFORMAT]) ?
                            $options[STORE_RESULTFORMAT] :
                            STORE_RESULTFORMAT_PLAIN;
        
        // load query config variables
        extract($this->_getQueryConfig($resultFormat));

        $rs = $this->_execSparql($query);
        
        $result = $rs['result']['rows'];        
            
        // convert XML result
        if (null !== $converter) {
            foreach ((array) $converter as $currentConverter) {
                $converterClass = 'Erfurt_Store_Adapter_Virtuoso_ResultConverter_' . $currentConverter;

                require_once str_replace('_', '/', $converterClass) . '.php';
                $converter = new $converterClass();

                $result = $this->_convertToSJP($rs);
            }
        }

        // encode as JSON string
        if ($jsonEncode) {
            $result = json_encode($result);
        }

        return $result;
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
        
        foreach ($columns as $columnName => $columnSpec) {
            $colSpecs[] = PHP_EOL
                        .  ' `' . $columnName . '` '
                        .  $columnSpec;
        }
        
        $createTable = 'CREATE TABLE ' . (string)$tableName . ' (' . implode(',', $colSpecs) . PHP_EOL . ')';
    
        return $this->sqlQuery($createTable);
    }
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     */
    public function lastInsertId()
    {
        $query = "SELECT LAST_INSERT_ID();";
        $rs = $this->_execSql($query);
        $result = mysql_fetch_array($rs);        
        if(isset($result[0]))
            return $result[0];
        else
            return null;
    }
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     * @todo Easier implementation
     */
    public function listTables($prefix = '')
    {
        $query = "SHOW TABLES LIKE '".$prefix."%'";
        return $this->sqlQuery($query);
    }
    
    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {

        if ($limit < PHP_INT_MAX) {
            $selectRegex   = '/SELECT(\s+DISTINCT)?/i';
            $selectReplace = sprintf('$0 TOP %d, %d', (int)$offset, (int)$limit);
            $sqlQuery      = preg_replace($selectRegex, $selectReplace, (string)$sqlQuery);
        }
        
        $resultArray = array();
        
        $rs = $this->_execSql($sqlQuery);
        if(!($rs === true) && !($rs === false))
            while($row = mysql_fetch_array($rs))
            {
                $resultArray[] = $row;
            }
        else
            $resultArray[] = $rs;            
                
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
     * @return string+
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
        
        $fromSpec = implode('> FROM <', (array)$graphUris);
        $countQuery = sprintf(
            'SELECT %s COUNT(%s) AS ?counters FROM <%s> %s',
            $distinct,
            $countSpec,
            $fromSpec,
            $whereSpec);

        $rs = $this->_execSparql($countQuery);
        if(isset($rs['result']['rows'][0]['counters']))
            return (int) $rs['result']['rows'][0]['counters'];
        else
            return 0;
    }

    /**
     * Recursively gets owl:imported model IRIs starting with $modelUri as root.
     *
     * @param string $modelUri
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
     */
    public function getLastError() 
    {
        $errors = $this->_store->getErrors();
        if(sizeof($errors) > 0)
            return $errors[sizeof($errors)-1];
        else
            return null;
    }
    
    // ------------------------------------------------------------------------
    // --- Protected Methods --------------------------------------------------
    // ------------------------------------------------------------------------
    
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
        $logger = Erfurt_App::getInstance()->getLog();

        // Query-Return:
        // query_type   = Typ der Query (z.B. Select, Insert, Ask etc)
        // result       = eigentliche Ergebnismenge
        // query_time   = Ausführungszeit
        
        $filters = explode("FILTER", $sparqlQuery);
        $updatedQuery = $filters[0];
        for($i = 1; $i < sizeof($filters); $i++)
        {
            if(strpos($filters[$i],"sameTerm"))
            {
                $filters[$i] = preg_replace(array("#sameTerm\(#","#,#"),array("(", " = "),$filters[$i]);
            }
            $updatedQuery .= "FILTER ".$filters[$i];
        }
        $rs =  $this->_store->query($updatedQuery);

        if($this->_store->getErrors()){
            var_dump($this->_store->getErrors());
            exit;
        }

        #if((strpos($sparqlQuery,'http://localhost/OntoWiki/Config/') != false) && ())
        #{
        #
        #}
        /*$rs =  $this->_store->query(preg_replace("#\?#","?__",$updatedQuery));
        foreach($rs as $r)
        {
            echo var_dump($r);
            if(isset($r['variables']) && !empty($r['variables']))
            {
                var_dump($r['variables']);
                foreach($r['variables'] as $var)
                {
                    var_dump($var);
                }
            }
        }
        exit;*/
        return $rs;
    }

    public function test_execSparql($sparqlQuery, $graphUri = null)
    {
        $logger = Erfurt_App::getInstance()->getLog();

        // Query-Return:
        // query_type   = Typ der Query (z.B. Select, Insert, Ask etc)
        // result       = eigentliche Ergebnismenge
        // query_time   = Ausführungszeit

        $filters = explode("FILTER", $sparqlQuery);
        $updatedQuery = $filters[0];
        for($i = 1; $i < sizeof($filters); $i++)
        {
            if(strpos($filters[$i],"sameTerm"))
            {
                $filters[$i] = preg_replace(array("#sameTerm\(#","#,#"),array("(", " = "),$filters[$i]);
            }
            $updatedQuery .= "FILTER ".$filters[$i];
        }
        $rs =  $this->_store->query($updatedQuery);

        var_dump($this->_store->getErrors());
        foreach($rs as $row)
        {
            var_dump($row);
        }exit;
        
        #return $rs;
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
        // return resultSet
        return $this->_store->queryDB($sqlQuery, $this->_store->getDBCon());
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
     * Converts an ARC result to an SPARQL/JSON-like PHP-Format (here called SJP)
     * see: http://www.w3.org/TR/rdf-sparql-json-res/
     *
     * @param result  the arc result
     *
     * @return array
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
