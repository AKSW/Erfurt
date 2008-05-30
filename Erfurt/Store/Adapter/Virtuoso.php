<?php
require_once 'Erfurt/Sparql/SimpleQuery.php';
require_once 'Erfurt/Store/Adapter/Interface.php';

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
class Erfurt_Store_Adapter_Virtuoso implements Erfurt_Store_Adapter_Interface
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
    
    /**
     * An array of languages appearing in
     * each model.
     */
    private $_modelLanguages = array();
    
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
        
        // try to connect
        $this->_connection = @odbc_connect($dsn, $username, $password);
        
        if (null == $this->_connection) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Unable to connect to Virtuoso Universal Server via ODBC: ' . $this->_getLastError());
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
    public function addStatement($modelUri, 
		                         $subject, 
		                         $predicate, 
		                         $object, 
		                         $options = array('subject_type' => Erfurt_Store::TYPE_IRI, 'object_type' => Erfurt_Store::TYPE_IRI))
	{	    
	    if ($options['object_type'] == Erfurt_Store::TYPE_IRI) {
	        $object = "<$object>";
	    }
	    // TODO: support blanknodes as subject
	    $insertQuery = '
	        INSERT INTO GRAPH <' . $modelUri . '> {
	            <' . $subject . '> <' . $predicate . '> ' . $object . '
	        }';
	    
	    $this->_execSparql($insertQuery);
	}
	
	public function countWhereMatches($graphUri, $whereSpec)
	{
	    $query = new Erfurt_Sparql_SimpleQuery();
	    $query->setProloguePart("SELECT COUNT(*)")
	          ->addFrom($graphUri)
	          ->setWherePart($whereSpec);
	    
	    if ($result = $this->sparqlQuery($query)) {
	        $count = (int) $result[0]['callret-0'];
	        
	        return $count;
	    }
	    
	    return 0;
	}
    
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, $options = array())
    {
        if ($subject) {
            $subjectMatch = "AND S = DB.DBA.RDF_MAKE_IID_OF_QNAME('" . $subject . "')";
        }
        if ($predicate) {
            $predicateMatch = "AND P = DB.DBA.RDF_MAKE_IID_OF_QNAME('" . $predicate . "')";
        }
        if ($object) {
            $objectMatch = "AND O = DB.DBA.RDF_MAKE_IID_OF_QNAME('" . $object . "')";
        }
        
        // TODO: do not write to DB.DBA.RDF_QUAD directly (http://docs.openlinksw.com/virtuoso/rdfdatarepresentation.html)
        $deleteSql = "
            DELETE FROM DB.DBA.RDF_QUAD
            WHERE G = DB.DBA.RDF_MAKE_IID_OF_QNAME('" . $graphUri . "')
            " . $subjectMatch . " 
            " . $predicateMatch . " 
            " . $objectMatch . "
        ";
        
        $this->_execSql($deleteSql);
    }
    
    /** @see Erfurt_Store_DataInterface */
    public function deleteModel($modelUri) 
    {
        $this->_execSparql('DROP GRAPH <' . $modelUri . '>');
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function exportRdf($modelUri, $serializationType = 'xml', $filename = false)
    {
        throw new Exception('Not implemented yet.');
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
    public function getModel($modelUri) 
    {
        $owlQuery = new Erfurt_Sparql_SimpleQuery();
        $owlQuery->setProloguePart('ASK ')
                 ->setWherePart('WHERE {
                     GRAPH <' . $modelUri . '> {<' . $modelUri . '> <' . EF_RDF_NS . 'type> <' . EF_OWL_NS . 'Ontology>.}
                 }');
        
        if ($this->sparqlAsk($owlQuery, $modelUri)) {
            // assume owl model
            require_once 'Erfurt/Owl/Model.php';
            $model = new Erfurt_Owl_Model($modelUri, 'TODO');
        // TODO: set owl:imports cache
        // TODO: base URIs
        } else {
            // instantiate RDFS model
            require_once 'Erfurt/Rdfs/Model.php';
            $model = new Erfurt_Rdfs_Model($modelUri, 'TODO');
        }
        
        return $model;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getModelLanguages($modelUri)
    {
        if (!array_key_exists($modelUri, $this->_modelLanguages)) {
            $this->_modelLanguages[$modelUri] = array();
            
            $query = new Erfurt_Sparql_SimpleQuery();
            $query->setProloguePart('ASK')
                  ->addFrom($modelUri);
            
            foreach ($this->_languages as $language) {
                $query->setWherePart('WHERE {?s ?p ?o. FILTER (lang(?o) = "' . $language . '")}');
                var_dump((string) $query);
                if ($this->sparqlAsk($query)) {
                    array_push($this->_modelLanguages[$modelUri], $lang);
                }
            }
        }
        
        return $this->_modelLanguages[$modelUri];
    }
    
    /** @see Erfurt_Store_Adapter_Interface */ 
    public function getNewModel($modelUri, $baseUri = '', $type = 'rdfs') 
    {
        if ($this->isModelAvailable($modelUri, false)) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception("A model with the IRI '$modelUri' already exists.");
        }
        
        // TODO: set base uris
        if (strtolower($type) == 'owl') {
            // add statement (?model rdf:type owl:Ontology)
            $owlInsert = 'INSERT INTO GRAPH <' . $modelUri . '> {<' . $modelUri . '> <' . EF_RDF_NS . 'type> <' . EF_OWL_NS . 'Ontology>.}';
            $this->_execSparql($owlInsert);

            require_once 'Erfurt/Owl/Model.php';
            $model = new Erfurt_Owl_Model($modelUri, 'TODO');
        } else {
            // nothing to insert
            require_once 'Erfurt/Rdfs/Model.php';
            $model = new Erfurt_Rdfs_Model($modelUri, 'TODO');
        }
        
        return $model;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
	public function getSupportedExportFormats()
	{
	    
	}
	
	/** @see Erfurt_Store_Adapter_Interface */
	public function getSupportedImportFormats()
	{
	    return array(
	        'n3'  => 'N3', 
	        'nt'  => 'N-Triple', 
	        'rdf' => 'RDF/XML'
	    );
	}
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function importRdf($modelUri, $data, $type, $locator)
    {
        if ($locator == 'file' && is_readable($data)) {
            return $this->_importStatementsFromFile($data, $type, $modelUri);
        } else if ($locator == 'url') {
            return $this->_importStatementsFromUrl($data, $type, $modelUri);
        } else {
            // not supported
        }
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function isModelAvailable($modelUri, $useAc = true) 
    {
        if (is_string($modelUri)) {
            // check if graph exists in database
            $result = $this->_execSparql('ASK WHERE {GRAPH <' . $modelUri . '> {?s ?p ?o.}}');
            
            if (odbc_result($result, 1)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $modelUri
     * @param string $saprqlAsk
     */
    public function sparqlAsk(Erfurt_Sparql_SimpleQuery $queryObject)
    {
        // load owl:imports
        foreach ($queryObject->getFrom() as $fromGraphUri) {
            foreach ($this->_getImportedGraphs($fromGraphUri) as $importedGraphUri) {
                $queryObject->addFrom($importedGraphUri);
            }
        }
        
        $result = $this->_execSparql((string) $queryObject);
        
        if (odbc_result($result, 1) == '1') {
            return true;
        }
        
        return false;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlQuery(Erfurt_Sparql_SimpleQuery $queryObject, $resultform = 'plain') 
    {    
        $resultArray    = array();
        $resultRow      = array();
        $resultRowNamed = array();
        
        // load owl:imports
        foreach ($queryObject->getFrom() as $fromGraphUri) {
            foreach ($this->_getImportedGraphs($fromGraphUri) as $importedGraphUri) {
                $queryObject->addFrom($importedGraphUri);
            }
        }
        
        $result = $this->_execSparql((string) $queryObject);
        
        // get number of fields (columns)
        $numFields = odbc_num_fields($result);
        
        // if we have more results
        // fetch result row into array
        while (odbc_fetch_into($result, $resultRow)) {
            // copy column names to array indices
            
            for ($i = 0; $i < $numFields; ++$i) {
                $colName = odbc_field_name($result, $i + 1);
                
                // check for instantiation options
                // if ($classes[$colName]) {
                //  $className = $classes[$colName];
                //  $resultRowNamed[$colName] = new $className($resultRow[$i], $model, false);
                // } else {
                    $resultRowNamed[$colName] = $resultRow[$i];
                // }
            }
            
            // add row to result array
            array_push($resultArray, $resultRowNamed);
        }
        
        // print_r($resultArray);
        
        return $resultArray;
    }
    
    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------
    
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
        
        if (null == $result) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('SQL Error: ' . $this->_getLastError());
        }
        
        return $result;
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
        
        $virtuosoPl = 'CALL DB.DBA.SPARQL_EVAL(\'' . $sparqlQuery . '\', ' . $graphUri . ', 0)';
        
        $result = @odbc_exec($this->_connection, $virtuosoPl);
        
        if (null == $result) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('SPARQL Error: ' . $this->_getLastError() . '<br />' . 'Query: ' . $sparqlQuery);
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
        return odbc_errormsg() . ' (' . odbc_error() . ')';
    }
    
    private function _getImportedGraphs($graphUri)
    {
        $imports = array();
        $query = '
            SELECT ?o
            FROM <' . $graphUri . '>
            WHERE {
                <' . $graphUri . '> <' . EF_OWL_NS . 'imports> ?o.
            }';
        
        // TODO: cache results
        if ($result = $this->_execSparql($query)) {
            while (odbc_fetch_row($result)) {
                $imports[] = odbc_result($result, 'o');
            }
        }
        
        return $imports;
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
        if ($type == 'auto') {
            $pathInfo = pathinfo($file);
            $type     = $pathInfo['extension'];
        }
        
        // check type parameter
        switch (strtolower($type)) {
            case 'n3':  // N3
            case 'nt':  // N-Triple
                $importFunc = 'TTLP';
                break;
            case 'rdf': // RDF-XML
            default:    // unknown defaults to RDF-XML
                $importFunc = 'RDF_LOAD_RDFXML';
                break;
        }
        
        // import using internal Virtuoso/PL function
        $importSql = sprintf("CALL DB.DBA.%s(FILE_TO_STRING_OUTPUT('%s'), '%s', '%s')", $importFunc, $file, $baseUri, $graphUri);
        
        if ($this->_execSql($importSql)) {
            // TODO: owl:imports
            return $this->getModel($graphUri);
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
            default:    // unknown defaults to RDF-XML
                $importFunc = 'RDF_LOAD_RDFXML';
                break;
        }
        
        $importSql = sprintf("CALL DB.DBA.%s(XML_URI_GET_AND_CACHE('%s'), '%s', '%s')", $importFunc, $url, $baseUri, $graphUri);
        
        if ($this->_execSql($importSql)) {
            // TODO: owl:imports
            return $this->getModel($graphUri);
        }
    }
}
