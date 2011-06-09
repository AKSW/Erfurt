<?php
require_once 'Erfurt/Store/Adapter/Interface.php';
require_once 'Erfurt/Store/Sql/Interface.php';

/**
 * Erfurt RDF Store - Adapter for the {@link http://www4.wiwiss.fu-berlin.de/bizer/rdfapi/ RAP} schema (modified) with
 * Zend_Db database abstraction layer.
 *
 * @package erfurt
 * @subpackage    store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: RapZendDb.php 2532 2009-02-06 08:15:41Z pfrischmuth $
 */
class Erfurt_Store_Adapter_EfZendDb implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------

    private $_modelCache = array();
    private $_modelInfoCache = null;

    private $_dbConn = false;

    /** @var array */
    private $_titleProperties = array(
        'http://www.w3.org/2000/01/rdf-schema#label',
        'http://purl.org/dc/elements/1.1/title'
    );

    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Constructor
     *
     * @param array $adapterOptions This adapter class needs the following parameters:
     *                  - 'host'
     *                  - 'username'
     *                  - 'password'
     *                  - 'dbname'
     */
    public function __construct($adapterOptions = array())
    {
        $adapter    = $adapterOptions['dbtype'];
        $host       = isset($adapterOptions['host']) ? $adapterOptions['host'] : 'localhost';
        $username   = $adapterOptions['username'];
        $password   = $adapterOptions['password'];
        $dbname     = $adapterOptions['dbname'];

        $adapterOptions = array(
            'host'      => $host,
            'username'  => $username,
            'password'  => $password,
            'dbname'    => $dbname,
            'profiler'  => false
        );

        switch (strtolower($adapter)) {
            case 'mysql':
                if (extension_loaded('mysqli')) {
                    require_once 'Zend/Db/Adapter/Mysqli.php';
                    $this->_dbConn = new Zend_Db_Adapter_Mysqli($adapterOptions);
                } else if (extension_loaded('pdo') && extension_loaded('pdo_mysql')) {
                    require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
                    $this->_dbConn = new Zend_Db_Adapter_Pdo_Mysql($adapterOptions);
                } else {
                    require_once 'Erfurt/Exception.php';
                    throw new Erfurt_Exception('Neither "mysqli" nor "pdo_mysql" extension found.', -1);
                }
                break;
            case 'sqlsrv':
                if (extension_loaded('sqlsrv')) {
                    require_once 'Zend/Db/Adapter/Sqlsrv.php';
                    $this->_dbConn = new Zend_Db_Adapter_Sqlsrv($adapterOptions);
                } else {
                    require_once 'Erfurt/Exception.php';
                    throw new Erfurt_Exception('Sqlsrv extension not found.', -1);
                }
                break;
            default:
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Given database adapter is not supported.', -1);
        }

        try {
            // try to initialize the connection
            $this->_dbConn->getConnection();
        } catch (Zend_Db_Adapter_Exception $e) {
            // maybe wrong login credentials or db-server not running?!
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Could not connect to database with name: "' . $dbname . '". Please check your credentials and whether the database exists and the server is running.', -1);
        } catch (Zend_Exception $e) {
            // maybe a needed php extension is not loaded?!
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('An error with the specified database adapter occured.', -1);
        }

        // we want indexed results
        //$this->_dbConn->setFetchMode(Zend_Db::FETCH_NUM);

        // load title properties for model titles
        $config = Erfurt_App::getInstance()->getConfig();
        if (isset($config->properties->title)) {
            $this->_titleProperties = $config->properties->title->toArray();
        }
    }

    public function __destruct()
    {
        #$log = Erfurt_App::getInstance()->getLog();

        #$profiles = $this->_dbConn->getProfiler()->getQueryProfiles();

        #foreach ($profiles as $profile) {
        #    $debugStr = 'Query: ' . $profile->getQuery() . PHP_EOL;
        #    $debugStr .= 'Time: ' . $profile->getElapsedSecs() . PHP_EOL;
        #
        #    $log->debug($debugStr);
        #}
    }

    // ------------------------------------------------------------------------
    // --- Public methods (derived from Erfurt_Store_Adapter_Abstract) --------
    // ------------------------------------------------------------------------

    /** @see Erfurt_Store_Adapter_Interface */
    public function addMultipleStatements($graphUri, array $statementsArray, array $options = array())
    {
        $modelInfoCache = $this->_getModelInfos();

        $graphId = $modelInfoCache[$graphUri]['modelId'];

        $sqlQuery = 'INSERT IGNORE INTO ef_stmt (g,s,p,o,s_r,p_r,o_r,st,ot,ol,od,od_r) VALUES ';
        $insertArray = array();

        $counter = 0;
        foreach ($statementsArray as $subject => $predicatesArray) {
            foreach ($predicatesArray as $predicate => $objectsArray) {
                foreach ($objectsArray as $object) {
                    $sqlString = '';

                    $s = $subject;
                    $p = $predicate;
                    $o = $object;

                    // check whether the subject is a blank node
                    if (substr((string)$s, 0, 2) === '_:') {
                        $s = substr((string)$s, 2);
                        $subjectIs = '1';
                    } else {
                        $subjectIs = '0';
                    }

                    // check the type of the object
                    if ($o['type'] === 'uri') {
                        $objectIs = '0';
                        $lang = false;
                        $dType = false;
                    } else if ($o['type'] === 'bnode') {
                        if (substr((string)$o['value'], 0, 2) === '_:') {
                            $o['value'] = substr((string)$o['value'], 2);
                        }

                        $objectIs = '1';
                        $lang = false;
                        $dType = false;
                    } else {
                        $objectIs = '2';
                        $lang = isset($o['lang']) ? $o['lang'] : '';
                        $dType = isset($o['datatype']) ? $o['datatype'] : '';
                    }

                    $sRef = false;
                    if (strlen((string)$s) > $this->_getSchemaRefThreshold()) {
                        $subjectHash = md5((string)$s);

                        try {
                            $sRef = $this->_insertValueInto('ef_uri', $graphId, $s, $subjectHash);
                        } catch (Erfurt_Store_Adapter_Exception $e) {
                            $this->_dbConn->rollback();
                            require_once 'Erfurt/Store/Adapter/Exception.php';
                            throw new Erfurt_Store_Adapter_Exception($e->getMessage());
                        }

                        $s = substr((string)$s, 0, 128) . $subjectHash;
                    }

                    $pRef = false;
                    if (strlen((string)$p) > $this->_getSchemaRefThreshold()) {
                        $predicateHash = md5((string)$p);

                        try {
                            $pRef = $this->_insertValueInto('ef_uri', $graphId, $p, $predicateHash);
                        } catch (Erfurt_Store_Adapter_Exception $e) {
                            $this->_dbConn->rollback();
                            require_once 'Erfurt/Store/Adapter/Exception.php';
                            throw new Erfurt_Store_Adapter_Exception($e->getMessage());
                        }

                        $p = substr((string)$p, 0, 128) . $predicateHash;
                    }

                    $oRef = false;
                    if (strlen((string)$o['value']) > $this->_getSchemaRefThreshold()) {
                        $objectHash = md5((string)$o['value']);

                        if ($o['type'] === 'literal') {
                            $tableName = 'ef_lit';
                        } else {
                            $tableName = 'ef_uri';
                        }

                        try {
                            $oRef = $this->_insertValueInto($tableName, $graphId, $o['value'], $objectHash);
                        } catch (Erfurt_Store_Adapter_Exception $e) {
                            $this->_dbConn->rollback();
                            require_once 'Erfurt/Store/Adapter/Exception.php';
                            throw new Erfurt_Store_Adapter_Exception($e->getMessage());
                        }

                        $o['value'] = substr((string)$o['value'], 0, 128) . $objectHash;
                    }

                    $oValue = addslashes($o['value']);

                    $sqlString .= "($graphId,'$s','$p','$oValue',";

                    #$data = array(
                    #    'g'     => $graphId,
                    #    's'     => $subject,
                    #    'p'     => $predicate,
                    #    'o'     => $object['value'],
                    #    'st'    => $subjectIs,
                    #    'ot'    => $objectIs
                    #);

                    if ($sRef !== false) {
                        $sqlString .= "$sRef,";
                    } else {
                        $sqlString .= "\N,";
                    }
                    if ($pRef !== false) {
                        $sqlString .= "$pRef,";
                    } else {
                        $sqlString .= "\N,";
                    }
                    if ($oRef !== false) {
                        $sqlString .= "$oRef,";
                    } else {
                        $sqlString .= "\N,";
                    }

                    $sqlString .= "$subjectIs,$objectIs,'$lang',";

                    #$data['ol'] = $lang;


                    if (strlen((string)$dType) > $this->_getSchemaRefThreshold()) {
                        $dTypeHash = md5((string)$dType);

                        try {
                            $dtRef = $this->_insertValueInto('ef_uri', $graphId, $dType, $dTypeHash);
                        } catch (Erfurt_Store_Adapter_Exception $e) {
                            $this->_dbConn->rollback();
                            require_once 'Erfurt/Store/Adapter/Exception.php';
                            throw new Erfurt_Store_Adapter_Exception($e->getMessage());
                        }

                        $dType   = substr((string)$data['od'], 0, 128) . $dTypeHash;
                        $data['od_r'] = $dtRef;

                        $sqlString .= "'$dType',$dtRef)";
                    } else {
                        #$data['od'] = $dType;
                        $sqlString .= "'$dType',\N)";
                    }

                    $insertArray[] = $sqlString;
                    $counter++;

                    #try {
                    #    $this->_dbConn->insert('ef_stmt', $data);
                    #    $counter++;
                    #} catch (Exception $e) {
                    #    if ($this->_getNormalizedErrorCode() === 1000) {
                    #        continue;
                    #    } else {
                    #        $this->_dbConn->rollback();
                    #        require_once 'Erfurt/Store/Adapter/Exception.php';
                    #        throw new Erfurt_Store_Adapter_Exception('Bulk insertion of statements failed: ' .
                    #                        $this->_dbConn->getConnection()->error);
                    #    }
                    #}
                }
            }
        }

        $sqlQuery .= implode(',', $insertArray);

        if (defined('_EFDEBUG')) {
            $logger = Erfurt_App::getInstance()->getLog();
            $logger->info('ZendDb multiple statements added: ' . $counter);
        }

        if ($counter > 0) {
            $this->sqlQuery($sqlQuery);
        }

        if ($counter > 100) {
            $this->_optimizeTables();
        }
    }

    protected function _getNormalizedErrorCode()
    {
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            switch($this->_dbConn->getConnection()->errno) {
                case 1062:
                    // duplicate entry
                    return 1000;
            }
        } else {
            return -1;
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function addStatement($graphUri, $subject, $predicate, $object, array $options = array())
    {
        $statementArray = array();
        $statementArray["$subject"] = array();
        $statementArray["$subject"]["$predicate"] = array();
        $statementArray["$subject"]["$predicate"][] = $object;

        try {
            $this->addMultipleStatements($graphUri, $statementArray);
        } catch (Erfurt_Store_Adapter_Exception $e) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Insertion of statement failed:' .
                            $e->getMessage());
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function countWhereMatches($graphIris, $whereSpec, $countSpec, $distinct = false)
    {
        $query = new Erfurt_Sparql_SimpleQuery();
        if(!$distinct){
            $query->setProloguePart("COUNT DISTINCT $countSpec"); // old way: distinct has no effect !!!
        } else {
            $query->setProloguePart("COUNT-DISTINCT $countSpec"); // i made a (uncool) hack to fix this, the "-" is there because i didnt want to change tokenization
        }
        $query->setFrom($graphIris)
              ->setWherePart($whereSpec);
        
        $result = $this->sparqlQuery($query);

        if ($result) {
            return $result;
        }

        return 0;
    }

    /** @see Erfurt_Store_Sql_Interface */
    public function createTable($tableName, array $columns)
    {
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            return $this->_createTableMysql($tableName, $columns);
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function createModel($graphUri, $type = Erfurt_Store::MODEL_TYPE_OWL)
    {
        $data = array(
            'uri'  => &$graphUri
        );

        $baseUri = $graphUri;
        if ($baseUri !== '') {
            $data['base'] = $baseUri;
        }

        // insert the new model into the database
        $this->_dbConn->insert('ef_graph', $data);
        $graphId = $this->lastInsertId();

        $uriRef = false;
        if (strlen($graphUri) > $this->_getSchemaRefThreshold()) {
            $uriHash = md5($uri);

            $uriData = array(
                'g'     => $graphid,
                'v'     => $uri,
                'vh'    => $uriHash);

            $uriRef = $this->_insertValueInto('ef_uri', $uriData);

            $updateData = array(
                'uri'       => $uriHash,
                'uri_r'     => $uriRef);

            $this->_dbConn->update('ef_graph', $updateData, "id = graphId");
        }

        $baseRef = false;
        if (strlen($baseUri) > $this->_getSchemaRefThreshold()) {
            $baseHash = md5($baseUri);

            $baseData = array(
                'g'     => $graphid,
                'v'     => $baseUri,
                'vh'    => $baseHash);

            $baseRef = $this->_insertValueInto('ef_uri', $baseData);

            $updateData = array(
                'base'       => $baseHash,
                'base_r'     => $baseRef);

            $this->_dbConn->update('ef_graph', $updateData, "id = graphId");
        }

        // invalidate the cache and fetch model infos again
        require_once 'Erfurt/App.php';
        $cache = Erfurt_App::getInstance()->getCache();
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('model_info'));
        $this->_modelInfoCache = null;

        if ($type === Erfurt_Store::MODEL_TYPE_OWL) {
            $this->addStatement($graphUri, $graphUri, EF_RDF_TYPE, array('type' => 'uri', 'value' => EF_OWL_ONTOLOGY));
            $this->_modelInfoCache = null;
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, array $options = array())
    {
        $modelInfoCache = $this->_getModelInfos();

        $modelId = $modelInfoCache[$graphUri]['modelId'];

        if ($subject !== null && strlen($subject) > $this->_getSchemaRefThreshold()) {
            $subject = substr($subject, 0, 128) . md5($subject);
        }

        if ($predicate !== null && strlen($predicate) > $this->_getSchemaRefThreshold()) {
            $predicate = substr($predicate, 0, 128) . md5($predicate);
        }

        if ($object !== null && strlen($object['value']) > $this->_getSchemaRefThreshold()) {
            $object = substr($object['value'], 0, 128) . md5($object['value']);
        }

        $whereString = '1';

        // determine the rows, which should be deleted by the given parameters
        if ($subject !== null) {
            $whereString .= " AND s = '$subject'";
        }
        if ($predicate !== null) {
            $whereString .= " AND p = '$predicate'";
        }


        if (null !== $subject) {
            if (substr($subject, 0, 2) === '_:') {
                $whereString .= ' AND st = 1';
            } else {
                $whereString .= ' AND st = 0';
            }
        }

        if (null !== $object) {
            if (isset($object['value'])) {
                $whereString .= ' AND o = "' . $object['value'] . '"';
            }

            if (isset($object['type'])) {
                switch ($object['type']) {
                    case 'uri':
                        $whereString .= ' AND ot = 0';
                        break;
                    case 'literal':
                        $whereString .= ' AND ot = 2';
                        break;
                    case 'bnode':
                        $whereString .= ' AND ot = 1';
                        break;
                }
            }

            if (isset($object['lang'])) {
                $whereString .= ' AND ol = "' . $object['lang'] . '"';
            }

            if (isset($object['datatype'])) {
                if (strlen($object['datatype']) > $this->_getSchemaRefThreshold()) {
                    $whereString .= ' AND od = "' . substr($object['datatype'], 0, 128) .
                                    md5($object['datatype']) . '"';
                } else {
                    $whereString .= ' AND od = "' . $object['datatype'] . '"';
                }
            }
        }

        // remove the specified statements from the database
        $ret = $this->_dbConn->delete('ef_stmt', $whereString);

        // Clean up ef_uri and ef_lit table
        $this->_cleanUpValueTables($graphUri);

        // return number of affected rows (>0 means there were triples deleted)
        return $ret;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {

        $modelInfoCache = $this->_getModelInfos();

        $modelId = $modelInfoCache[$graphUri]['modelId'];

        $this->_dbConn->beginTransaction();
        try {
            foreach ($statementsArray as $subject => $predicatesArray) {
                foreach ($predicatesArray as $predicate => $objectsArray) {
                    foreach ($objectsArray as $object) {
                        $whereString = 'g = ' . $modelId . ' ';

                        // check whether the subject is a blank node
                        if (substr($subject, 0, 2) === '_:') {
                            $subject = substr($subject, 2);
                            $whereString .= 'AND st = 1 ';
                        } else {
                            $whereString .= 'AND st = 0 ';
                        }

                        // check the type of the object
                        if ($object['type'] === 'uri') {
                            $whereString .= 'AND ot = 0 ';
                        } else if ($object['type'] === 'bnode') {
                            $whereString .= 'AND ot = 1 ';
                        } else {
                            $whereString .= 'AND ot = 2 ';
                            $whereString .= isset($object['lang']) ? 'AND ol = \'' . $object['lang'] . '\' ' : '';
                            $whereString .= isset($object['datatype']) ? 'AND od = \'' . $object['datatype'] .
                                            '\' ' : '';
                        }

                        if (strlen((string)$subject) > $this->_getSchemaRefThreshold()) {
                            $subjectHash = md5((string)$subject);
                            $subject = substr((string)$subject, 0, 128) . $subjectHash;
                        }
                        if (strlen((string)$predicate) > $this->_getSchemaRefThreshold()) {
                            $predicateHash = md5((string)$predicate);
                            $predicate = substr((string)$predicate, 0, 128) . $predicateHash;
                        }
                        if (strlen((string)$object['value']) > $this->_getSchemaRefThreshold()) {
                            $objectHash = md5((string)$object['value']);
                            $object = substr((string)$object['value'], 0, 128) . $objectHash;
                        } else {
                            $object = $object['value'];
                        }


                        $whereString .= 'AND s = \'' . $subject . '\' ';
                        $whereString .= 'AND p = \'' . $predicate . '\' ';
                        $whereString .= 'AND o = \'' . str_replace('\'', '\\\'', $object) . '\' ';

                        $this->_dbConn->delete('ef_stmt', $whereString);
                    }
                }
            }

            // if everything went ok... commit the changes to the database
            $this->_dbConn->commit();

            $this->_cleanUpValueTables($graphUri);
        } catch (Exception $e) {
            // something went wrong... rollback
            $this->_dbConn->rollback();
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Bulk deletion of statements failed.'.$e->getMessage());
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteModel($graphUri)
    {
        $modelInfoCache = $this->_getModelInfos();

        if (isset($modelInfoCache[$graphUri]['modelId'])) {
            $graphId = $modelInfoCache[$graphUri]['modelId'];
        } else {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Model deletion failed: No db id found for model URL.');
        }

        // remove all rows with the specified modelID from the models, statements and namespaces tables
        $this->_dbConn->delete('ef_graph', "id = $graphId");
        $this->_dbConn->delete('ef_stmt', "g = $graphId");
        $this->_dbConn->delete('ef_uri', "g = $graphId");
        $this->_dbConn->delete('ef_lit', "g = $graphId");

        // invalidate the cache and fetch model infos again
        // Note: we invalidate the complete model info here
        $queryCache = Erfurt_App::getInstance()->getQueryCache();
        $queryCache->invalidateWithModelIri( (string) $graphUri);
        $cache = Erfurt_App::getInstance()->getCache();
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('model_info'));
        $this->_modelCache = array();
        $this->_modelInfoCache = null;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function exportRdf($modelIri, $serializationType = 'xml', $filename = false)
    {
        require_once 'Erfurt/Store/Adapter/Exception.php';
        throw new Erfurt_Store_Adapter_Exception('Not implemented yet.');
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getAvailableModels()
    {
        $modelInfoCache = $this->_getModelInfos();

        $models = array();
        foreach ($modelInfoCache as $mInfo) {
            $models[$mInfo['modelIri']] = true;
        }

        return $models;
    }

    public function getBackendName()
    {
        return 'ZendDb';
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getBlankNodePrefix()
    {
        return 'bNode';
    }

    /**
     * Returns a list of graph uris, where each graph in the list contains at least
     * one statement where the given resource uri is subject.
     *
     * @param string $resourceUri
     * @return array
     */
    public function getGraphsUsingResource($resourceUri)
    {
        $sqlQuery = 'SELECT DISTINCT g.uri FROM ef_stmt s
                     LEFT JOIN ef_graph g ON ( g.id = s.g)
                     WHERE s.s = \'' . $resourceUri . '\'';
        $sqlResult = $this->sqlQuery($sqlQuery);

        $result = array();
        foreach ($sqlResult as $row) {
            $result[] = $row['uri'];
        }

        return $result;
    }

    /**
     * Recursively gets owl:imported model IRIs starting with $modelIri as root.
     *
     * @param string $modelIri
     */
    public function getImportsClosure($modelIri)
    {
        $modelInfoCache = $this->_getModelInfos();

        if (isset($modelInfoCache["$modelIri"]['imports'])) {
            return $modelInfoCache["$modelIri"]['imports'];
        } else {
            return array();
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getModel($modelIri)
    {
        // if model is already in cache return the cached value
        if (isset($this->_modelCache[$modelIri])) {
            return clone $this->_modelCache[$modelIri];
        }

        $modelInfoCache = $this->_getModelInfos();

        $baseUri = $modelInfoCache[$modelIri]['baseIri'];
        if ($baseUri === '') {
            $baseUri = null;
        }

        // choose the right type for the model instance and instanciate it
        if ($modelInfoCache[$modelIri]['type'] === 'owl') {
            require_once 'Erfurt/Owl/Model.php';
            $m = new Erfurt_Owl_Model($modelIri, $baseUri);
        } else if ($this->_modelInfoCache[$modelIri]['type'] === 'rdfs') {
            require_once 'Erfurt/Rdfs/Model.php';
            $m = new Erfurt_Rdfs_Model($modelIri, $baseUri);
        } else {
            require_once 'Erfurt/Rdf/Model.php';
            $m = new Erfurt_Rdf_Model($modelIri, $baseUri);
        }

        $this->_modelCache[$modelIri] = $m;
        return $m;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getNewModel($graphUri, $baseUri = '', $type = 'owl')
    {
        $data = array(
            'uri'  => &$graphUri
        );

        if ($baseUri !== '') {
            $data['base'] = $baseUri;
        }

        // insert the new model into the database
        $this->_dbConn->insert('ef_graph', $data);
        $graphId = $this->lastInsertId();

        $uriRef = false;
        if (strlen($graphUri) > $this->_getSchemaRefThreshold()) {
            $uriHash = md5($uri);

            $uriData = array(
                'g'     => $graphid,
                'v'     => $uri,
                'vh'    => $uriHash);

            $uriRef = $this->_insertValueInto('ef_uri', $uriData);

            $updateData = array(
                'uri'       => $uriHash,
                'uri_r'     => $uriRef);

            $this->_dbConn->update('ef_graph', $updateData, "id = graphId");
        }

        $baseRef = false;
        if (strlen($baseUri) > $this->_getSchemaRefThreshold()) {
            $baseHash = md5($baseUri);

            $baseData = array(
                'g'     => $graphid,
                'v'     => $baseUri,
                'vh'    => $baseHash);

            $baseRef = $this->_insertValueInto('ef_uri', $baseData);

            $updateData = array(
                'base'       => $baseHash,
                'base_r'     => $baseRef);

            $this->_dbConn->update('ef_graph', $updateData, "id = graphId");
        }

        // invalidate the cache and fetch model infos again
        require_once 'Erfurt/App.php';
        $cache = Erfurt_App::getInstance()->getCache();
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('model_info'));
        $this->_modelInfoCache = null;

        if ($type === 'owl') {
            $this->addStatement($graphUri, $graphUri, EF_RDF_TYPE, array('type' => 'uri', 'value' => EF_OWL_ONTOLOGY));
            $this->_modelInfoCache = null;
        }

        // instanciate the model
        $m = $this->getModel($graphUri);

        return $m;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getSupportedExportFormats()
    {
        return array();
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getSupportedImportFormats()
    {
        return array();
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function importRdf($modelUri, $data, $type, $locator)
    {
// TODO fix or remove
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            require_once 'Erfurt/Syntax/RdfParser.php';
            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat($type);
            $parsedArray = $parser->parse($data, $locator, $modelUri, false);

            $modelInfoCache = $this->_getModelInfos();
            $modelId = $modelInfoCache["$modelUri"]['modelId'];

            // create file
            $tmpDir     = Erfurt_App::getInstance()->getTmpDir();
            $filename   = $tmpDir . '/import' . md5((string)time()) . '.csv';
            $fileHandle = fopen($filename, 'w');

            $count = 0;
            $longStatements = array();
            foreach ($parsedArray as $s => $pArray) {
                if (substr($s, 0, 2) === '_:') {
                    $s = substr($s, 2);
                    $sType = '1';
                } else {
                    $sType = '0';
                }

                foreach ($pArray as $p => $oArray) {
                    foreach ($oArray as $o) {
                        // to long values need to be put in a different table, so we can't bulk insert these
                        // values, for they need a foreign key
                        if (strlen($s) > $this->_getSchemaRefThreshold() ||
                            strlen($p) > $this->_getSchemaRefThreshold() ||
                            strlen($o['value']) > $this->_getSchemaRefThreshold() ||
                            (isset($o['datatype']) && strlen($o['datatype']) > $this->_getSchemaRefThreshold())) {
                            $longStatements[] = array(
                                's' => $s,
                                'p' => $p,
                                'o' => $o
                            );
                            continue;
                        }

                        if ($o['type'] === 'literal') {
                            $oType = '2';
                        } else if ($o['type'] === 'bnode') {
                            if (substr($o['value'], 0, 2) === '_:') {
                                $o['value'] = substr($o['value'], 2);
                            }

                            $oType = '1';
                        } else {
                            $oType = '0';
                        }

                        $lineString = $modelId . ';' . $s . ';' . $p . ';' . $o['value'] . ';';
                        $lineString .= "\N;\N;\N;";

                        $lineString .=  $sType . ';' . $oType . ';';

                        if (isset($o['lang'])) {
                            $lineString .= $o['lang'];
                        } else {
                            $lineString .= "\N";
                        }

                        $lineString .= ';';

                        if (isset($o['datatype'])) {
                            $lineString .= $o['datatype'] . ";\N";
                        } else {
                            $lineString .= "\N;\N";
                        }

                        $lineString .= PHP_EOL;

                        $count++;
                        fputs($fileHandle, $lineString);

                    }
                }
            }

            fclose($fileHandle);

            if ($count > 10000) {
                $this->_dbConn->getConnection()->query('ALTER TABLE ef_stmt DISABLE KEYS');
            }

            $sql = "LOAD DATA INFILE '$filename' IGNORE INTO TABLE ef_stmt
                    FIELDS TERMINATED BY ';'
                    (g, s, p, o, s_r, p_r, o_r, st, ot, ol, od, od_r);";

            $this->_dbConn->getConnection()->query('START TRANSACTION;');
            $this->_dbConn->getConnection()->query($sql);
            $this->_dbConn->getConnection()->query('COMMIT');

            // Delete the temp file
            unlink($filename);

            // Now add the long-value-statements
            foreach($longStatements as $stm) {
                $sId = false;
                $pId = false;
                $oId = false;
                $dtId = false;

                $s = $stm['s'];
                $p = $stm['p'];
                $o = $stm['o']['value'];

                if (strlen($s) > $this->_getSchemaRefThreshold()) {
                    $sHash = md5($s);

                    $sId = $this->_insertValueInto('ef_uri', $modelId, $s, $sHash);
                    $s = substr($s, 0, 128) . $sHash;
                }
                if (strlen($p) > $this->_getSchemaRefThreshold()) {
                    $pHash = md5($p);

                    $pId = $this->_insertValueInto('ef_uri', $modelId, $p, $pHash);
                    $p = substr($p, 0, 128) . $pHash;
                }
                if (strlen($o) > $this->_getSchemaRefThreshold()) {
                    $oHash = md5($o);

                    if ($stm['o']['type'] === 'literal') {
                        $oId = $this->_insertValueInto('ef_lit', $modelId, $o, $oHash);
                    } else {
                        $oId = $this->_insertValueInto('ef_uri', $modelId, $o, $oHash);
                    }

                    $o = substr($o, 0, 128) . $oHash;
                }
                if (isset($stm['o']['datatype']) && strlen($stm['o']['datatype']) > $this->_getSchemaRefThreshold()) {
                    $oDtHash = md5($stm['o']['datatype']);

                    $dtId = $this->_insertValueInto('ef_uri', $modelId, $stm['o']['datatype'], $oDtHash);

                    $oDt = substr($oDt, 0, 128) . $oDtHash;
                }

                $sql = "INSERT INTO ef_stmt
                        (g,s,p,o,s_r,p_r,o_r,st,ot,ol,od,od_r)
                        VALUES ($modelId,'$s','$p','$o',";

                if ($sId !== false) {
                    $sql .= $sId . ',';
                } else {
                    $sql .= "\N,";
                }

                if ($pId !== false) {
                    $sql .= $pId . ',';
                } else {
                    $sql .= "\N,";
                }

                if ($oId !== false) {
                    $sql .= $oId . ',';
                } else {
                    $sql .= "\N,";
                }

                if (substr($stm['s'], 0, 2) === '_:') {
                    $sql .= '1,';
                } else {
                    $sql .= '0,';
                }

                if ($stm['o']['type'] === 'literal') {
                    $sql .= '2,';
                } else if ($stm['o']['type'] === 'uri') {
                    $sql .= '0,';
                } else {
                    $sql .= '1,';
                }

                if (isset($stm['o']['lang'])) {
                    $sql .= '"' . $stm['o']['lang'] . '",';
                } else {
                    $sql .= "\N,";
                }

                if (isset($stm['o']['datatype'])) {
                    if ($dtId !== false) {
                        $sql .= '"' . $oDt . '",' . $dtId . ')';
                    } else {
                        $sql .= '"' . $stm['o']['datatype'] . '",' . "\N)";
                    }
                } else {
                    $sql .= "\N,\N)";
                }

                //$this->_dbConn->getConnection()->query($sql);
            }

            if ($count > 10000) {
                 $this->_dbConn->getConnection()->query('ALTER TABLE ef_stmt ENABLE KEYS');
            }

            $this->_optimizeTables();
        } else {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('CSV import not supported for this database server.');
        }
    }

    public function init()
    {
        $this->_modelInfoCache = null;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function isModelAvailable($modelIri)
    {
        $modelInfoCache = $this->_getModelInfos();

        if (isset($modelInfoCache[$modelIri])) {
            return true;
        } else {
            return false;
        }
    }

    /** @see Erfurt_Store_Sql_Interface */
    public function lastInsertId()
    {
        return $this->_dbConn->lastInsertId();
    }

    /** @see Erfurt_Store_Sql_Interface */
    public function listTables($prefix = '')
    {
        return $this->_dbConn->listTables();
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlAsk($query)
    {
		//TODO works for me...., why hasnt this be enabled earlier? is the same as sparqlQuery... looks like the engine supports it. but there is probably a reason for this not to be supported
		$start = microtime(true);

        require_once 'Erfurt/Sparql/EngineDb/Adapter/EfZendDb.php';
        $engine = new Erfurt_Sparql_EngineDb_Adapter_EfZendDb($this->_dbConn, $this->_getModelInfos());

        require_once 'Erfurt/Sparql/Parser.php';
        $parser = new Erfurt_Sparql_Parser();

        if(!($query instanceof Erfurt_Sparql_Query))
        	$query = $parser->parse((string)$query);

        $result = $engine->queryModel($query);

        // Debug executed SPARQL queries in debug mode (7)
        $logger = Erfurt_App::getInstance()->getLog();
        $time = (microtime(true) - $start)*1000;
        $debugText = 'SPARQL Query (' . $time . ' ms)';
        $logger->debug($debugText);

        return $result;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlQuery($query, $options=array())
    {
        $resultform =(isset($options[STORE_RESULTFORMAT]))?$options[STORE_RESULTFORMAT]:STORE_RESULTFORMAT_PLAIN;

        $start = microtime(true);

        require_once 'Erfurt/Sparql/EngineDb/Adapter/EfZendDb.php';
        $engine = new Erfurt_Sparql_EngineDb_Adapter_EfZendDb($this->_dbConn, $this->_getModelInfos());

        require_once 'Erfurt/Sparql/Parser.php';
        $parser = new Erfurt_Sparql_Parser();

        if(!($query instanceof Erfurt_Sparql_Query)) {
            $query = $parser->parse((string)$query);
        }

        $result = $engine->queryModel($query, $resultform);

        // Debug executed SPARQL queries in debug mode (7)
        $logger = Erfurt_App::getInstance()->getLog();
        $time = (microtime(true) - $start)*1000;
        $debugText = 'SPARQL Query (' . $time . ' ms)';
        $logger->debug($debugText);

        return $result;
    }

    /** @see Erfurt_Store_Sql_Interface */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        $start = microtime(true);

        // add limit/offset
        if ($limit < PHP_INT_MAX) {
            $sqlQuery = sprintf('%s LIMIT %d OFFSET %d', (string)$sqlQuery, (int)$limit, (int)$offset);
        }

        $queryType = strtolower(substr($sqlQuery, 0, 6));
        if ( $queryType  === 'insert' ||
             $queryType  === 'update' ||
             $queryType  === 'create' ||
             $queryType  === 'delete') {
            // Handle without ZendDb

            $this->_config = Erfurt_App::getInstance()->getConfig();

            if($this->_config->store->zenddb->dbtype=='sqlsrv') {
                $result = $this->_dbConn->query($sqlQuery);
            }
            else
            {
                $result = $this->_dbConn->getConnection()->query($sqlQuery);
            }



            if ($result !== true) {
                require_once 'Erfurt/Store/Adapter/Exception.php';
                throw new Erfurt_Store_Adapter_Exception('SQL query failed: ' .
                            $this->_dbConn->getConnection()->error);
            }
        } else {
            try {
                $result = @$this->_dbConn->fetchAll($sqlQuery);
            } catch (Zend_Db_Exception $e) { #return false;
                require_once 'Erfurt/Store/Adapter/Exception.php';
                throw new Erfurt_Store_Adapter_Exception($e->getMessage());
            }
        }

        // Debug executed SQL queries in debug mode (7)
        $logger = Erfurt_App::getInstance()->getLog();
        $time = (microtime(true) - $start)*1000;
        $debugText = 'SQL Query (' . $time . ' ms)';
        $logger->debug($debugText);

        return $result;
    }

    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * For Zend_Db does not abstract SQL statements that can't be prepared, we need to do this by hand
     * for each supported db server, which can be used with the ZendDb adapter.
     */
    private function _createTableMysql($tableName, array $columns)
    {
        $createTable = 'CREATE TABLE `' . (string) $tableName . '` (';

        $i = 0;
	    foreach ($columns as $columnName => $columnSpec) {
	        $createTable .= PHP_EOL
	                     .  '`' . $columnName . '` '
	                     .  $columnSpec . (($i < count($columns)-1) ? ',' : '');
	        ++$i;
	    }
	    $createTable .= PHP_EOL
	                 .  ')';
#var_dump($createTable); die;
	    $success = $this->_dbConn->getConnection()->query($createTable);

	    if (!$success) {
// TODO dedicated exception
	        throw new Exception('Could not create database table with name ' . $tableName . '.');
	    } else {
	        return $success;
	    }
    }

    /**
     * @throws Erfurt_Exception Throws exception if something goes wrong while initialization of database.
     */
    private function _createTables()
    {
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            return $this->_createTablesMysql();
        } else if ($this->_dbConn instanceof Zend_Db_Adapter_Sqlsrv) {
            return $this->_createTablesSqlsrv();
        }
    }

    /**
     * This internal function creates the table structure for MySQL databases.
     */
    private function _createTablesMysql()
    {
        // Create ef_info table.
        $sql = 'CREATE TABLE IF NOT EXISTS ef_info (
                    id        TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                    schema_id VARCHAR(10) COLLATE ascii_bin NOT NULL
                ) ENGINE = MyISAM DEFAULT CHARSET = ascii;';

        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_info" failed:' .
                            $this->_dbConn->getConnection()->error);
        }


        // Insert id of the current schema into the ef_info table.
        $sql = 'INSERT INTO ef_info (schema_id) VALUES ("1.0")';

        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Insertion of "schema_id" into "ef_info" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }


        // Create ef_graph table.
        $sql = 'CREATE TABLE IF NOT EXISTS ef_graph (
        	        id			INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        	        uri			VARCHAR(160) COLLATE ascii_bin NOT NULL,
        	        uri_r	    INT UNSIGNED DEFAULT NULL,
        	        base		VARCHAR(160) COLLATE ascii_bin DEFAULT NULL,
        	        base_r	    INT UNSIGNED DEFAULT NULL,
        	        UNIQUE unique_graph (uri)
                ) ENGINE = MyISAM DEFAULT CHARSET = ascii;';

        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_graph" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }

        // INT means, we could store up to 4.294.967.295 statements

        // Create ef_stmt table.
        $sql = 'CREATE TABLE IF NOT EXISTS ef_stmt (
            	    id 		INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            	    g	    INT UNSIGNED NOT NULL,                      # foreign key to ef_graph
            	    s		VARCHAR(160) COLLATE ascii_bin NOT NULL,    # subject or subject hash
            	    p		VARCHAR(160) COLLATE ascii_bin NOT NULL,    # predicate or predicate hash
            	    o		VARCHAR(160) COLLATE utf8_bin NOT NULL,     # object or object hash
            	    s_r     INT UNSIGNED DEFAULT NULL,                  # foreign key to ef_uri
            	    p_r     INT UNSIGNED DEFAULT NULL,                  # foreign key to ef_uri
            	    o_r     INT UNSIGNED DEFAULT NULL,                  # foreign key to ef_uri or ef_lit
            	    st 		TINYINT(1) UNSIGNED NOT NULL,				# 0 - uri, 1 - bnode
            	    ot 		TINYINT(1) UNSIGNED NOT NULL,				# 0 - uri, 1 - bnode, 2 - literal
            	    ol 		VARCHAR(10) COLLATE ascii_bin NOT NULL,
            	    od 	    VARCHAR(160) COLLATE ascii_bin NOT NULL,
            	    od_r 	INT UNSIGNED DEFAULT NULL,
            	    UNIQUE  unique_stmt (g, s, p, o, st, ot, ol, od),
            	    INDEX   idx_g_p_o_ot (g, p, o, ot),
            	    INDEX   idx_g_o_ot (g, o, ot)
            	    #INDEX   idx_o_g_p_ot (o, g, p, ot)
            	    #INDEX   idx_s_g_p_st (s, g, p, st)
                ) ENGINE = MyISAM DEFAULT CHARSET = ascii;';

        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_stmt" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }

        /*
        // Create ef_ns table.
        $sql = 'CREATE TABLE IF NOT EXISTS ef_ns (
        	        id		INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        	        g	    INT UNSIGNED NOT NULL,
        	        ns		VARCHAR(160) COLLATE ascii_bin NOT NULL,
        	        ns_r	INT UNSIGNED DEFAULT NULL,
        	        prefix	VARCHAR(160) COLLATE ascii_bin NOT NULL,
        	        UNIQUE unique_ns (g, ns, prefix)
                ) ENGINE = MyISAM DEFAULT CHARSET = ascii;';

        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
             require_once 'Erfurt/Store/Adapter/Exception.php';
             throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_ns" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }
        */

        // Create ef_uri table.
        $sql = 'CREATE TABLE IF NOT EXISTS ef_uri (
        	        id	INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        	        g	INT UNSIGNED NOT NULL,
        	        v	LONGTEXT COLLATE ascii_bin NOT NULL,
        	        vh  CHAR(32) COLLATE ascii_bin NOT NULL,
        	        UNIQUE unique_uri (g, vh)
                ) ENGINE = MyISAM DEFAULT CHARSET = ascii;';

        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_uri" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }


        // Create ef_lit table.
        $sql = 'CREATE TABLE IF NOT EXISTS ef_lit (
        	        id	INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        	        g	INT UNSIGNED NOT NULL,
        	        v	LONGTEXT COLLATE utf8_bin NOT NULL,
        	        vh  CHAR(32) COLLATE ascii_bin NOT NULL,
        	        UNIQUE unique_lit (g, vh)
                ) ENGINE = MyISAM DEFAULT CHARSET = ascii;';

        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_lit" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }
    }

    /**
     * This internal function creates the table structure for MS SQL Server databases.
     */
    private function _createTablesSqlsrv()
    {
                //#####################################################################
        // Create table ef_info if not existing

        $sqlsrv ='IF NOT EXISTS
                  ( SELECT * FROM SysObjects WHERE [Name] = \'ef_info\')
                  CREATE TABLE ef_info (
                  id        TINYINT NOT NULL IDENTITY(1,1),
                  schema_id VARCHAR(10) COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL
                  ) ON [PRIMARY]';

       $success = $this->_dbConn->query($sqlsrv);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_info" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }


        // Insert id of the current schema into the ef_info table.
        $sql = 'INSERT INTO ef_info (schema_id) VALUES (1.0)';

        $success = false;
        $success = $this->_dbConn->query($sql);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Insertion of "schema_id" into "ef_info" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }



        //#####################################################################
        // Create table ef_graph if not existing

        $sqlsrv ='IF NOT EXISTS
                  ( SELECT * FROM SysObjects WHERE [Name] = \'ef_graph\')
                  BEGIN
                  CREATE TABLE ef_graph (
                  id        TINYINT NOT NULL IDENTITY(1,1),
                  uri       VARCHAR(160)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  uri_r     INT NULL,
                  base      VARCHAR(160)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  base_r    INT NULL
                  ) ON [PRIMARY]
                  CREATE UNIQUE INDEX unique_uri ON ef_graph (uri)
                   END';

       $success = $this->_dbConn->query($sqlsrv);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_info" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }

        //#####################################################################
        // Create table ef_stmt if not existing

        $sqlsrv ='IF NOT EXISTS
                  ( SELECT * FROM SysObjects WHERE [Name] = \'ef_stmt\')
                  BEGIN
                  CREATE TABLE ef_stmt (
                  id        TINYINT NOT NULL IDENTITY(1,1),
                  g         INT NOT NULL,
                  s         VARCHAR(160)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  p         VARCHAR(160)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  o         VARCHAR(160)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  s_r       INT NOT NULL,
                  p_r       INT NOT NULL,
                  o_r       INT NOT NULL,
                  st        TINYINT NOT NULL,
                  ot        TINYINT NOT NULL,
                  ol        VARCHAR(50)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  od        VARCHAR(160)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  od_r      INT NOT NULL,
                  ) ON [PRIMARY]
                  CREATE UNIQUE NONCLUSTERED INDEX unique_stmt ON ef_stmt (g,s,p,o,st,ot,ol,od)
                  CREATE NONCLUSTERED INDEX idx_g_p_o_ot ON ef_stmt (g, p, o, ot)
                  CREATE NONCLUSTERED INDEX idx_g_o_ot ON ef_stmt (g, o, ot)
                  END';

       $success = $this->_dbConn->query($sqlsrv);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_info" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }

//#####################################################################
        // Create table ef_uri if not existing

        $sqlsrv ='IF NOT EXISTS
                  ( SELECT * FROM SysObjects WHERE [Name] = \'ef_uri\')
                  BEGIN
                  CREATE TABLE ef_uri (
                  id        TINYINT NOT NULL IDENTITY(1,1),
                  g         INT NOT NULL,
                  v         TEXT COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  vh        VARCHAR(32)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL
                    ) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
                 CREATE UNIQUE NONCLUSTERED INDEX unique_uri ON ef_uri (g,vh)
                 END';

       $success = $this->_dbConn->query($sqlsrv);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_uri" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }

        //#####################################################################
        // Create table ef_lit if not existing

        //v would b UTF8 - not shure if SQL_Latin1_general_CP850_bin is the right type

        $sqlsrv ='IF NOT EXISTS
                  ( SELECT * FROM SysObjects WHERE [Name] = \'ef_lit\')
                  BEGIN
                  CREATE TABLE ef_lit (
                  id        TINYINT NOT NULL IDENTITY(1,1),
                  g         INT NOT NULL,
                  v         TEXT COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL,
                  vh        VARCHAR(32)COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL

                    ) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
                 CREATE UNIQUE NONCLUSTERED INDEX unique_lit ON ef_lit (g,vh)
                 END';

       $success = $this->_dbConn->query($sqlsrv);

        if (!$success) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Creation of table "ef_uri" failed: ' .
                            $this->_dbConn->getConnection()->error);
        }
    }

    protected function _getModelInfos()
    {
        if (null === $this->_modelInfoCache) {

            try {
                // try to fetch model and namespace infos... if all tables are present this should not lead to an error.
                $this->_fetchModelInfos();
            } catch (Erfurt_Exception $e) {
                // error while fetching model and namespace infos... should only be the case if the tables aren't present,
                // for db connection is already established (in constructor)... so let's check for tables
                if (!$this->_isSetup()) {
                    $this->_createTables();

                    try {
                        Erfurt_App::getInstance()->getStore()->checkSetup();
                    } catch (Erfurt_Store_Exception $e2) {
                        if ($e2->getCode() == 20) {
                            $this->_fetchModelInfos();
                        } else {
                            require_once 'Erfurt/Store/Adapter/Exception.php';
                            throw new Erfurt_Store_Adapter_Exception(
                                'Store: Error while initializing the environment: ' . $e2->getMessage(), -1);
                        }
                    }

                } else {
                    require_once 'Erfurt/Store/Adapter/Exception.php';
                    throw new Erfurt_Store_Adapter_Exception(
                        'Store: Error while fetching model and namespace infos.', -1);
                }
            }
        }

        return $this->_modelInfoCache;
    }

    protected function _getSchemaRefThreshold()
    {
        // We use 160, for the max index length is 1000 byte and the unique_stmt index needs
        // to fit in.
        return 160;
    }

    protected function _optimizeTables()
    {
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            $this->_dbConn->getConnection()->query('OPTIMIZE TABLE ef_stmt');
            $this->_dbConn->getConnection()->query('OPTIMIZE TABLE ef_uri');
            $this->_dbConn->getConnection()->query('OPTIMIZE TABLE ef_lit');
        } else {
            // not supported yet.
        }
    }

    protected function _cleanUpValueTables($graphUri)
    {
        if (isset($this->_modelInfoCache[$graphUri]['modelId'])) {
            $graphId = $this->_modelInfoCache[$graphUri]['modelId'];
        } else {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Failed to clean up value tables: No db id for <' . $graphUri .
                                                     '> was found.');
        }

        $sql = "SELECT l.id as id, count(l.id)
                FROM ef_lit l
                JOIN ef_stmt s ON s.g = $graphId AND s.ot = 2 AND s.o_r = l.id
                WHERE l.g = $graphId
                GROUP BY l.id";

        $idArray = array();

        foreach ($this->_dbConn->fetchAssoc($sql) as $row) {
            $idArray[] = $row['id'];
        }

        if (count($idArray) > 0) {
            $ids = implode (',', $idArray);
            $whereString = "g = $graphId AND id NOT IN ($ids)";
            $this->_dbConn->delete('ef_lit', $whereString);
        }

        $sql = "SELECT u.id as id, count(u.id)
                FROM ef_uri u
                JOIN ef_stmt s ON s.g = $graphId AND (s.s_r = u.id OR s.p_r = u.id OR s.od_r = u.id OR
                (s.ot IN (0, 1) AND s.o_r = u.id))
                WHERE u.g = $graphId
                GROUP BY u.id";

        $idArray = array();
        foreach ($this->_dbConn->fetchAssoc($sql) as $row) {
            $idArray[] = $row['id'];
        }

        if (count($idArray) > 0) {
            $ids = implode (',', $idArray);
            $whereString = "g = $graphId AND id NOT IN ($ids)";
            $this->_dbConn->delete('ef_uri', $whereString);
        }
    }



    protected function _insertValueInto($tableName, $graphId, $value, $valueHash)
    {
        $data = array(
            'g'     => &$graphId,
            'v'     => &$value,
            'vh'    => &$valueHash
        );

        try {
            $this->_dbConn->insert($tableName, $data);
        } catch (Exception $e) {
            if ($this->_getNormalizedErrorCode() !== 1000) {
                require_once 'Erfurt/Store/Adapter/Exception.php';
                throw new Erfurt_Store_Adapter_Exception("Insertion of value into $tableName failed: " .
                                $e->getMessage());
            }
        }

        $sql = "SELECT id FROM $tableName WHERE vh = '$valueHash'";
        $result = $this->_dbConn->fetchRow($sql);

        if (!$result) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Fetching of uri id failed: ' .
                            $this->_dbConn->getConnection()->error);
        }

        $id = $result['id'];

        return $id;
    }

    /**
     *
     * @throws Erfurt_Exception
     */
    private function _fetchModelInfos()
    {
        require_once 'Erfurt/App.php';
        $cache = Erfurt_App::getInstance()->getCache();

        $id = $cache->makeId($this, '_fetchModelInfos', array());
        $cachedVal = $cache->load($id);
        if ($cachedVal) {
            $this->_modelInfoCache = $cachedVal;
        } else {
            $sql = 'SELECT g.id, g.uri, g.uri_r, g.base, g.base_r, s.o, u.v,
                        (SELECT count(*)
                        FROM ef_stmt s2
                        WHERE s2.g = g.id
                        AND s2.s = g.uri
                        AND s2.st = 0
                        AND s2.p = \'' . EF_RDF_TYPE . '\'
                        AND s2.o = \'' . EF_OWL_ONTOLOGY . '\'
                        AND s2.ot = 0) as is_owl_ontology
                    FROM ef_graph g
                    LEFT JOIN ef_stmt s ON (g.id = s.g
                        AND g.uri = s.s
                        AND s.p = \'' . EF_OWL_IMPORTS. '\'
                        AND s.ot = 0)
                    LEFT JOIN ef_uri u ON (u.id = g.uri_r OR u.id = g.base_r OR u.id = s.o_r)';

            try {
                $result = $this->sqlQuery($sql);
            } catch (Exception $e) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Error while fetching model and namespace informations.');
            }


            if ($result === false) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Error while fetching model and namespace informations.');
            } else {
                $this->_modelInfoCache = array();

                #$rowSet = $result->fetchAll();
                #var_dump($result);exit;
                foreach ($result as $row) {
                    if (!isset($this->_modelInfoCache[$row['uri']])) {
                        $this->_modelInfoCache[$row['uri']]['modelId']      = $row['id'];
                        $this->_modelInfoCache[$row['uri']]['modelIri']     = $row['uri'];
                        $this->_modelInfoCache[$row['uri']]['baseIri']      = $row['base'];
                        $this->_modelInfoCache[$row['uri']]['imports']      = array();

                        // set the type of the model
                        if ($row['is_owl_ontology'] > 0) {
                            $this->_modelInfoCache[$row['uri']]['type'] = 'owl';
                        } else {
                            $this->_modelInfoCache[$row['uri']]['type'] = 'rdfs';
                        }

                        if ($row['o'] !== null &&
                         !isset($this->_modelInfoCache[$row['uri']]['imports'][$row['o']])) {
                            $this->_modelInfoCache[$row['uri']]['imports'][$row['o']] = $row['o'];
                        }
                    } else {
                        if ($row['o'] !== null &&
                                !isset($this->_modelInfoCache[$row['uri']]['imports'][$row['o']])) {

                            $this->_modelInfoCache[$row['uri']]['imports'][$row['o']] = $row['o'];
                        }
                    }
                }

                //var_dump($this->_modelInfoCache);exit;

                // build the transitive closure for owl:imports
                // check for recursive owl:imports; also check for cylces!
                do {
                    // indicated whether anything was changed in the array or not and whether loop needs to run again
                    $hasChanged = false;

                    // test every model exists in the model table
                    foreach ($this->_modelInfoCache as $modelIri) {
                        // only owl models can import other models
                        if ($modelIri['type'] !== 'owl') {
                            continue;
                        }
                        foreach ($modelIri['imports'] as $importsIri) {
                            if (isset($this->_modelInfoCache[$importsIri])) {
                                foreach ($this->_modelInfoCache[$importsIri]['imports'] as $importsImportIri) {
                                    if (!isset($modelIri['imports'][$importsImportIri]) &&
                                            !($importsImportIri === $modelIri['modelIri'])) {

                                        $this->_modelInfoCache[$modelIri['modelIri']]
                                                    ['imports'][$importsImportIri] = $importsImportIri;
                                        $hasChanged = true;
                                    }
                                }
                            }
                        }
                    }
                } while ($hasChanged === true);
            }

            $cache->save($this->_modelInfoCache, $id, array('model_info'));
        }
    }

    /**
     * Checks whether all needed database table for the adapter are present.
     *
     * Currently we need three tables: 'models', 'statements' and 'namespaces'
     *
     * @throws Erfurt_Exception
     * @return boolean Returns true if all tables are present.
     */
    private function _isSetup()
    {
        $existingTables = $this->listTables();

        if (is_array($existingTables)) {
            if (!in_array('ef_info', $existingTables) ||
                !in_array('ef_graph', $existingTables) ||
                !in_array('ef_stmt', $existingTables) ||
                !in_array('ef_uri', $existingTables) ||
                !in_array('ef_lit', $existingTables)) {

                return false;
            } else {
                return true;
            }
        } else {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Determining of database tables failed.');
        }
    }
}
?>
