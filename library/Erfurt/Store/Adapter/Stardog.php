<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Stardog (http://stardog.com/) Adapter for the Erfurt Semantic Web Framework.
 *
 * Install Erfurt as described in https://github.com/AKSW/Erfurt/wiki/Getting-Started
 * but use config.ini-dist-stardog as config.ini and adopt to your requirements
 *
 * To run stardog integration tests run: make test-integration-stardog
 *
 * Its tested with Stardog Version >=4.0.1 (Docker available: https://hub.docker.com/r/aksw/dld-store-stardog) and uses
 * Zend_Http_Client in Erfurt_Store_Adapter_Stardog_ApiClient as HTTP Client
 *
 * @category Erfurt
 * @package  Erfurt_Store_Adapter
 * @author   Simeon Ackermann <amseon@web.de>
 */
class Erfurt_Store_Adapter_Stardog implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{
    /**
     * Prefix for blanknode identifiers.
     * @var string
     */
    const BLANKNODE_PREFIX = 'nodeID://';

    /**
     * The low-level client that is used to interact with the triple store.
     *
     * @var \Erfurt_Store_Adapter_Stardog_ApiClient
     */
    protected $_apiClient = null;

    /**
     * The inner SQL adapter.
     *
     * @var \Erfurt_Store_Sql_Interface
     */
    protected $_sqlAdapter = null;

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
     * Constructor.
     *
     * @throws Erfurt_Store_Adapter_Exception
     */
    public function __construct($adapterOptions = array())
    {
        // Access the connection in order to check whether it works.
        $this->_apiClient = $this->connection($adapterOptions);

        $dbs = $this->getDatabases();
        if ( null === $dbs || ! in_array($adapterOptions['database'], $dbs) ) {
            $this->createDatabase($adapterOptions['database']);
        }

        // Create sql Zend Adapter if Versioning is enabled
        $efApp = Erfurt_App::getInstance(false);
        if ( $efApp->getVersioning() !== false ) {
            $this->_sqlAdapter = $this->sqlConnection();
        }
    }

    /**
     * Destructor
     *
     * @throws Erfurt_Exception
     */
    public function __destruct()
    {
    }

    /**
     *  New Guzzle Http Client to Stardog
     *
     * @param array Stardog Options from config file
     * @return GuzzleHttp/Client
     */
    public function connection(array $options = array())
    {
        return $this->_apiClient ? $this->_apiClient : new Erfurt_Store_Adapter_Stardog_ApiClient($options);
    }

    /**
     * Connect new SQL Adapter for versioning
     *
     * @throws Erfurt_Store_Adapter_Exception if initialization failed
     * @return \Erfurt_Store_Sql_Interface
     */
    public function sqlConnection()
    {
        $app = Erfurt_App::getInstance(false);
        $config = $app->getConfig();

        // load Erfurt App with zenddb
        $config->store->backend = 'zenddb';
        $app->loadConfig($config);

        try {
            $efZend = $app->getStore();
        } catch (Exception $e) {
            throw new Erfurt_Store_Adapter_Exception(
                'Stardog with versioning requires SQL store, ' .
                'but initialization went wrong with message: '.$e->getMessage()
            );
        }

        // reset Erfurt App Config to Stardog
        $config->store->backend = 'stardog';
        $app->loadConfig($config);

        return $efZend;
    }

    /**
     * Returns a list of exiisting databases
     *
     * @return array
     */
    protected function getDatabases()
    {
        return $this->_apiClient->getDatabases();
    }

    /**
     * Creates an empty stardog database with the provided name
     *
     * @param string $database
     */
    protected function createDatabase($database)
    {
        $this->_apiClient->createDatabase($database);
    }

    /**
     * Deletes the provided stardog database
     *
     * @param string $database
     */
    protected function dropDatabase($database)
    {
        $this->_apiClient->dropMyDatabase($database);
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function addStatement($graphUri, $subject, $predicate, array $objectSpec, array $options = array())
    {
        if ($objectSpec['type'] == 'uri') {
            $object = '<' . $objectSpec['value'] . '>';
        } else {
            $object = $this->buildLiteralString(
                $objectSpec['value'],
                isset($objectSpec['datatype']) ? $objectSpec['datatype'] : null,
                isset($objectSpec['lang']) ? $objectSpec['lang'] : null,
                false
            );
        }

        $data = '<' . $subject . '> <' . $predicate . '> ' . $object . ' .';
        $this->_apiClient->import($data, $graphUri, Erfurt_Store_Adapter_Stardog_ApiClient::FORMAT_TURTLE);

        if (defined('_EFDEBUG')) {
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->debug('Add statement query: ' . PHP_EOL . $data);
        }

        return true;
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function addMultipleStatements($graphUri, array $statementsArray, array $options = array())
    {
        $triples = $this->buildTripleArray($statementsArray);
        $this->_apiClient->import(implode($triples), $graphUri, Erfurt_Store_Adapter_Stardog_ApiClient::FORMAT_TURTLE);
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, array $options = array())
    {
        if (empty($graphUri)) {
            throw new Erfurt_Store_Adapter_Exception('No graph URI given.');
        }
        $graphSpec     = '<' . (string)$graphUri . '>';
        $subjectSpec   = $subject   ? '<' . (string)$subject . '>'   : '?s';
        $predicateSpec = $predicate ? '<' . (string)$predicate . '>' : '?p';
        $objectSpec = $this->getObjectSpec($object);

        $deleteTriples = "";
        $deletes = $this->sparqlQuery(
            sprintf("SELECT * FROM %s WHERE { %s %s %s . }", $graphSpec, $subjectSpec, $predicateSpec, $objectSpec),
            array('result_format' => 'extended')
        );

        if ( count($deletes['results']['bindings']) == 0 ) {
            return 0;
        }

        foreach ($deletes['results']['bindings'] as $key => $triple) {
            $deleteTriples .= isset($triple['s']) ? "<".$triple['s']['value']."> " : $subjectSpec . " ";
            $deleteTriples .= isset($triple['p']) ? "<".$triple['p']['value']."> " : $predicateSpec . " ";
            if ( isset($triple['o']) ) {
                $objectSpec = $this->getObjectSpec($triple['o']);
            }
            $deleteTriples .= $objectSpec . "." . PHP_EOL;
        }

        $this->_apiClient->remove($deleteTriples, $graphUri, Erfurt_Store_Adapter_Stardog_ApiClient::FORMAT_TURTLE);

        return count($deletes);
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {
        $triples = $this->buildTripleArray($statementsArray);
        $count = count($triples);

        $this->_apiClient->remove(implode($triples), $graphUri, Erfurt_Store_Adapter_Stardog_ApiClient::FORMAT_TURTLE);
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function deleteModel($graphUri)
    {
        $this->_graphs = null;
        return $this->_apiClient->query('DROP SILENT GRAPH <' . $graphUri . '>');
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     * @todo test this, what needed for?
     */
    public function getBlankNodePrefix()
    {
        return self::BLANKNODE_PREFIX;
    }

    /**
     * @see Erfurt_Store
     */
    public function getGraphsUsingResource($resourceUri)
    {
        $graphs = array();

        $res = $this->sparqlQuery('SELECT DISTINCT ?graph { GRAPH ?graph { <'.$resourceUri.'> ?p ?o . } }');
        if ($res) {
            foreach ($res as $key => $value) {
                $graphs[] = $value['graph'];
            }
        }

        return $graphs;
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     * @todo Support Export
     */
    public function getSupportedExportFormats()
    {
        return array();
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     * @todo implement
     */
    public function exportRdf($graphUri, $serializationType = 'xml', $filename = null)
    {
        throw new Erfurt_Store_Adapter_Exception('RDF export not implemented yet.');
    }

    /**
     * Return supportet import formats, but we dont need to support any,
     * because \Erfurt_Store does all
     *
     * @see Erfurt_Store_Adapter_Interface
     */
    public function getSupportedImportFormats()
    {
        // dont support any (Erfurt_Store does all)
        return array();
    }

    /**
     * Import RDF, will be done by addMultipleStatements() from \Erfurt_Store
     *
     * @see Erfurt_Store_Adapter_Interface
     * @todo implement
     */
    public function importRdf($graphUri, $data, $type, $locator)
    {
        throw new Erfurt_Store_Adapter_Exception('RDF import not implemented yet.');
    }

    /**
     * We dont need to init indexes or anything else...
     *
     * @see Erfurt_Store_Adapter_Interface
     */
    public function init()
    {
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function getAvailableModels()
    {
        if (null === $this->_graphs) {
            $this->_graphs = array();

            $rid = $this->_apiClient->query("SELECT DISTINCT ?g { GRAPH ?g { ?s ?p ?o . } }");
            if ($rid) {
                foreach ($rid['results']['bindings'] as $key => $value) {
                    $this->_graphs[$value['g']['value']] = array('modelIri' => $value['g']['value']);
                }
            }
        }
        return $this->_graphs;
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function isModelAvailable($graphUri)
    {
        return array_key_exists((string)$graphUri, (array)$this->getAvailableModels());
    }

    /**
     * Explicitly creates a new named graph.
     *
     * @param string $graphUri
     * @param string $baseUri
     * @return boolean
     * @todo may allow creating empty graphs
     */
    public function createModel($graphUri, $type = Erfurt_Store::MODEL_TYPE_OWL)
    {
        // create empty graph
        $createQuery = "CREATE SILENT GRAPH <$graphUri>";
        $this->_apiClient->query($createQuery);

        if ($type === Erfurt_Store::MODEL_TYPE_OWL) {
            // add statement <graph> a owl:Ontology
            $this->addStatement(
                $graphUri, $graphUri, EF_RDF_TYPE, array('type'=>'uri','value'=>EF_OWL_ONTOLOGY)
            );
        } else {
            // Bugfix for new empty graphs: add <graphUri> a Sysont:Model as new statement,
            // otherwise getAvailableGraphs() will not recognize this empty graph
            $this->addStatement(
                $graphUri, $graphUri, EF_RDF_TYPE, array('type'=>'uri','value'=>'http://ns.ontowiki.net/SysOnt/Model')
            );
        }

        // force reloading graphs next time
        $this->_graphs = null;

        return true;
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function getModel($modelIri)
    {
        if ( array_key_exists($modelIri, $this->_graphs) ) {
            return new Erfurt_Rdf_Model($modelIri);
        }
        return null;
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function getNewModel($graphUri, $baseUri = '', $type = 'owl')
    {
        $this->createModel($graphUri);
        return $this->getModel($graphUri);
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     *
     * @return boolean|string|array is defined in _apiClient->query()
     */
    public function sparqlAsk($query)
    {
        return $this->_apiClient->query($query);
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     */
    public function sparqlQuery($query, $options=array())
    {
        $resultFormat = isset($options[Erfurt_Store::RESULTFORMAT]) ?
            $options[Erfurt_Store::RESULTFORMAT] :
            Erfurt_Store::RESULTFORMAT_PLAIN;

        // result format is extended by default, or boolean for ask
        $results = $this->_apiClient->query((string)$query);

        switch ($resultFormat) {
            case Erfurt_Store::RESULTFORMAT_EXTENDED:
                if ( is_bool($results) ) {
                    $results = [ 'results' => [ 'bindings' => [ $results ] ] ];
                } else {
                    foreach ($results['results']['bindings'] as $rskey => $result) {
                        foreach ($result as $rkey => $value) {
                            if ( isset($value['xml:lang']) ) {
                                $results['results']['bindings'][$rskey][$rkey]['lang'] = $value['xml:lang'];
                                unset($results['results']['bindings'][$rskey][$rkey]['xml:lang']);
                            }
                        }
                    }
                }
                break;

            case Erfurt_Store::RESULTFORMAT_XML:
                // @TODO
                throw new Erfurt_Store_Adapter_Exception('Result Format XML not implemented yet.');

            default: // RESULTFORMAT_PLAIN
                if ( isset($results['results']['bindings']) ) {
                    $results = $results['results']['bindings'];
                    foreach ($results as $rskey => $result) {
                        foreach ($result as $rkey => $value) {
                            $results[$rskey][$rkey] = $value['value'];
                        }
                    }
                }
                break;
        }

        return $results ;
    }

    // ------------------------------------------------------------------------
    // --- Public Methods (Erfurt_Store_Adapter_Sql_Interface) ----------------
    // ------------------------------------------------------------------------

    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     */
    public function createTable($tableName, array $columns)
    {
        if ( $this->_sqlAdapter == null ) {
            throw new Erfurt_Store_Adapter_Exception('SQL Adapter not connected.');
        }

        return $this->_sqlAdapter->createTable($tableName, $columns);
    }

    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     */
    public function lastInsertId()
    {
        if ( $this->_sqlAdapter == null ) {
            throw new Erfurt_Store_Adapter_Exception('SQL Adapter not connected.');
        }

        return $this->_sqlAdapter->lastInsertId();
    }

    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     */
    public function listTables($prefix = '')
    {
        if ( $this->_sqlAdapter == null ) {
            throw new Erfurt_Store_Adapter_Exception('SQL Adapter not connected.');
        }

        return $this->_sqlAdapter->listTables($prefix);
    }

    /**
     * @see Erfurt_Store_Adapter_Sql_Interface
     */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        if ( $this->_sqlAdapter == null ) {
            throw new Erfurt_Store_Adapter_Exception('SQL Adapter not connected.');
        }

        return $this->_sqlAdapter->sqlQuery($sqlQuery, $limit, $offset);
    }

    // ------------------------------------------------------------------------
    // --- Public Helper Methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Builds a SPARQL-compatible literal string with long literals if necessary.
     *
     * @param string $value
     * @param string|null $datatype
     * @param string|null $lang
     * @param boolean $longStringEnabled decides if the output can be a long string (""" """) or not
     * @return string
     */
    public function buildLiteralString($value, $datatype = null, $lang = null, $longStringEnabled = true)
    {
        return Erfurt_Utils::buildLiteralString($value, $datatype, $lang, $longStringEnabled);
    }

    /**
     * Calls specified function for every triple in N-Triples syntax out of an RDF/PHP array.
     *
     * @param $rdfPhpStatements A nested statement array
     * @param $callback A function which will be called for each triple
     */
    public function buildTriple(array $rdfPhpStatements, $callback)
    {
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
                    $callback(sprintf('%s %s %s .%s', $resource, $property, $value, PHP_EOL));
                }
            }
        }
    }

    /**
     * Builds an array of triples in N-Triples syntax out of an RDF/PHP array.
     *
     * @param $rdfPhpStatements A nested statement array
     * @return array
     */
    public function buildTripleArray(array $rdfPhpStatements)
    {
        $triples = array();

        $this->buildTriple(
            $rdfPhpStatements,
            function($triple) use(&$triples) {
                $triples[] = $triple;
            }
        );

        return $triples;
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

        $this->buildTriple(
            $rdfPhpStatements,
            function($triple) use(&$triples) {
                $triples .= $triple;
            }
        );

        return $triples;
    }

    /**
     * Creates an object specification as ?o or <object-uri> for sparql queries
     *
     * @param string|array(string->value) $object
     * @return string
     */
    public function getObjectSpec($object)
    {
        if (null !== $object) {
            if ($object['type'] == 'uri') {
                $objectSpec = '<' . $object['value'] . '>';
            } else {
                $objectSpec = $this->buildLiteralString(
                    $object['value'],
                    true == isset($object['datatype']) ? $object['datatype'] : null,
                    true == isset($object['lang']) ? $object['lang'] : null,
                    false
                );
            }
        } else {
            $objectSpec = '?o';
        }

        return $objectSpec;
    }

    /**
     * @see Erfurt_Store_Adapter_Interface
     * @todo Rename countMatchingStatements
     */
    public function countWhereMatches($graphUris, $whereSpec, $countSpec, $distinct = false)
    {
        if (empty($graphUris)) {
            throw new Erfurt_Store_Adapter_Exception('No graph URI given.');
        }
        if ($distinct) {
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
            $whereSpec
        );

        // @TODO test this
        if ($rid = $this->_apiClient->query($countQuery)) {
            $count = (int)$rid['results']['bindings'];
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
                    $from    .= ' FROM <' . $row['o'] . '>' . PHP_EOL;
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

                $result = $queryCache->load($query, Erfurt_Store::RESULTFORMAT_PLAIN);
                if ($result == Erfurt_Cache_Frontend_QueryCache::ERFURT_CACHE_NO_HIT) {
                    $startTime = microtime(true);
                    $result = $this->sparqlQuery($query);
                    $duration = microtime(true) - $startTime;
                    $queryCache->save($query, Erfurt_Store::RESULTFORMAT_PLAIN, $result, $duration);
                }
            } while ($result);

            // unset root node
            unset($models[$modelUri]);

            // cache result
            $this->_importedModels[$modelUri] = array_keys($models);
        }
        return $this->_importedModels[$modelUri];
    }
}
