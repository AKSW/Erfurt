<?php
require_once 'Erfurt/Store/Adapter/Interface.php';
require_once 'Erfurt/Store/Sql/Interface.php';

/**
 * Erfurt RDF Store - Adapter for the {@link http://www4.wiwiss.fu-berlin.de/bizer/rdfapi/ RAP} schema with Zend_Db
 * database abstraction layer.
 * 
 * @package erfurt
 * @subpackage    store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: RapZendDb.php 3498 2009-06-30 00:01:06Z sebastian.dietzold $
 */
class Erfurt_Store_Adapter_RapZendDb implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    private $_modelCache = array();
    private $_modelInfoCache = false;
    
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
        $adapter    = $adapterOptions['adapter'];
        $host       = $adapterOptions['host'];
        $username   = $adapterOptions['username'];
        $password   = $adapterOptions['password'];
        $dbname     = $adapterOptions['dbname'];
        
        $adapterOptions = array(
            'host'      => $host,
            'username'  => $username,
            'password'  => $password,
            'dbname'    => $dbname,
            'profiler'  => true
        );
        
        switch (strtolower($adapter)) {
            case 'mysqli':
                require_once 'Zend/Db/Adapter/Mysqli.php';
                $this->_dbConn = new Zend_Db_Adapter_Mysqli($adapterOptions);
                break;
            case 'db2':
                require_once 'Zend/Db/Adapter/Db2.php';
                $this->_dbConn = new Zend_Db_Adapter_Db2($adapterOptions);
                break;
            case 'oracle':
                require_once 'Zend/Db/Adapter/Oracle.php';
                $this->_dbConn = new Zend_Db_Adapter_Oracle($adapterOptions);
                break;
            case 'pdo_ibm':
                require_once 'Zend/Db/Adapter/Pdo/Ibm.php';
                $this->_dbConn = new Zend_Db_Adapter_Pdo_Ibm($adapterOptions);
                break;
            case 'pdo_mssql':
                require_once 'Zend/Db/Adapter/Pdo/Mssql.php';
                $this->_dbConn = new Zend_Db_Adapter_Pdo_Mssql($adapterOptions);
                break;
            case 'pdo_mysql':
                require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
                $this->_dbConn = new Zend_Db_Adapter_Pdo_Mysql($adapterOptions);
                break;
            case 'pdo_oci':
                require_once 'Zend/Db/Adapter/Pdo/Oci.php';
                $this->_dbConn = new Zend_Db_Adapter_Pdo_Oci($adapterOptions);
                break;
            case 'pdo_pgsql':
                require_once 'Zend/Db/Adapter/Pdo/Pgsql.php';
                $this->_dbConn = new Zend_Db_Adapter_Pdo_Pgsql($adapterOptions);
                break;
            case 'pdo_sqlite':
                require_once 'Zend/Db/Adapter/Pdo/Sqlite.php';
                $this->_dbConn = new Zend_Db_Adapter_Pdo_Sqlite($adapterOptions);
                break;
            default:
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Given database adapter is not supported by Zend_Db', -1);
        }
        
        try {
            // try to initialize the connection
            $this->_dbConn->getConnection();
        } catch (Zend_Db_Adapter_Exception $e) {
            // maybe wrong login credentials or db-server not running?!
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Could not connect to database.', -1);
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
        
        try {
            // try to fetch model and namespace infos... if all tables are present this should not lead to an error.
            $this->_fetchModelInfos();
        } catch (Erfurt_Exception $e) {
            // error while fetching model and namespace infos... should only be the case if the tables aren't present,
            // for db connection is already established (in constructor)... so let's check for tables
            require_once 'Erfurt/Exception.php';
            if (!$this->_isSetup()) {
                $this->_createTables();
                #throw new Erfurt_Exception('Store: Database environment not initialized.', -1);
            } else {
                throw new Erfurt_Exception('Store: Error while fetching model and namespace infos.', -1);
            }   
        }
    }
    
    public function __destruct() 
    {   
        //var_dump($this->_dbConn);exit;
        //$this->_dbConn->closeConnection();
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods (derived from Erfurt_Store_Adapter_Abstract) --------
    // ------------------------------------------------------------------------
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function addMultipleStatements($graphIri, array $statementsArray, $options = array())
    {
        $modelId = $this->_modelInfoCache[$graphIri]['modelId'];
        
        $this->_dbConn->beginTransaction();
        
        foreach ($statementsArray as $subject => $predicatesArray) {
            foreach ($predicatesArray as $predicate => $objectsArray) {
                foreach ($objectsArray as $object) {
                    // check whether the subject is a blank node
                    if (substr($subject, 0, 2) === '_:') {
                        $subject = substr($subject, 2);
                        $subjectIs = 'b';
                    } else {
                        $subjectIs = 'r';
                    }

                    // check the type of the object
                    if ($object['type'] === 'uri') {
                        $objectIs = 'r';
                        $lang = '';
                        $dType = '';
                    } else if ($object['type'] === 'bnode') {
                        $objectIs = 'b';
                        $lang = '';
                        $dType = '';
                    } else {
                        $objectIs = 'l';
                        $lang = isset($object['lang']) ? $object['lang'] : '';
                        $dType = isset($object['datatype']) ? $object['datatype'] : '';
                    }

                    $data = array(
                        'modelID'       => $modelId,
                        'subject'       => $subject,
                        'predicate'     => $predicate,
                        'object'        => $object['value'],
                        'object_hash'   => md5($object['value']),
                        'subject_is'    => $subjectIs,
                        'object_is'     => $objectIs,
                        'l_language'    => $lang,
                        'l_datatype'    => $dType
                    );

                    try {
                        $this->_dbConn->insert('statements', $data);
                    } catch (Exception $e) {
                        if ($this->_getNormalizedErrorCode() === 1000) {
                            continue;
                        } else {
                            $this->_dbConn->rollback();
                            throw new Erfurt_Exception('Bulk insertion of statements failed.');
                        } 
                    }    
                }
            }
        }
            
        // if everything went ok... commit the changes to the database
        $this->_dbConn->commit();
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
    public function addStatement($modelIri, $subject, $predicate, $object, 
            $options = array('subject_type' => Erfurt_Store::TYPE_IRI, 'object_type' => Erfurt_Store::TYPE_IRI))
    {
        $modelId = $this->_modelInfoCache[$modelIri]['modelId'];
        $subjectType = ($options['subject_type'] === Erfurt_Store::TYPE_IRI) ? 'r' : 'b';
        $objectType = ($options['object_type'] === Erfurt_Store::TYPE_IRI) ? 'r' : 
                        (($options['object_type'] === Erfurt_Store::TYPE_LITERAL) ? 'l' : 'b');
       
        if ($objectType === 'l') {
            // check for language in object string
            if (strpos($object, '^^') !== false) {
                $dType = substr(strstr($object, '^^'), 3, -1);
                $object = substr($object, 1, strpos($object, '^^')-2);
            } else {
                $dType = '';
            }
            
            $lang = (isset($options['literal_language'])) ? $options['literal_language'] : '';
            $dType = (isset($options['literal_datatype'])) ? $options['literal_datatype'] : $dType;
        } else {
            $lang = '';
            $dType = '';
        }
        
        $data = array(
            'modelID'       => $modelId,
            'subject'       => $subject,
            'predicate'     => $predicate,
            'object'        => $object,
            'object_hash'   => md5($object),
            'subject_is'    => $subjectType,
            'object_is'     => $objectType,
            'l_language'    => $lang,
            'l_datatype'    => $dType
        );
        
        // add the statement to the database
        $this->_dbConn->insert('statements', $data);
    }
    
    /** @see Erfurt_Store_Sql_Interface */
    public function createTable($tableName, array $columns) 
    {
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            return $this->_createTableMysqli($tableName, $columns);
        }	    
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMatchingStatements($modelIri, $subject, $predicate, $object, $options = array())
    {
        $modelId = $this->_modelInfoCache[$modelIri]['modelId'];
        
        $whereString = '1';
        
        // determine the rows, which should be deleted by the given parameters
        if ($subject !== null) {
            $whereString .= ' AND subject = ' . $this->_dbConn->quote($subject);
        }
        if ($predicate !== null) {
            $whereString .= ' AND predicate = ' . $this->_dbConn->quote($predicate);
        }
        if ($object !== null) {
            $whereString .= ' AND object = ' . $this->_dbConn->quote($object);
        }
        if (isset($options['subject_type'])) {
            switch ($options['subject_type']) {
                case Erfurt_Store::TYPE_IRI:
                    $whereString .= ' AND subject_is = "r"';
                    break;
                case Erfurt_Store::TYPE_BLANKNODE:
                    $whereString .= ' AND subject_is = "b"';
                    break;
            }
        }
        if (isset($options['object_type'])) {
            switch ($options['object_type']) {
                case Erfurt_Store::TYPE_IRI:
                    $whereString .= ' AND object_is = "r"';
                    break;
                case Erfurt_Store::TYPE_LITERAL:
                    $whereString .= ' AND object_is = "l"';
                    break;
                case Erfurt_Store::TYPE_BLANKNODE:
                    $whereString .= ' AND object_is = "b"';
                    break;
            }
        }
        if (isset($options['literal_language'])) {
            $whereString .= ' AND l_language = "' . $this->_dbConn->quote($options['literal_language']) . '"';
        }
        if (isset($options['literal_datatype'])) {
            $whereString .= ' AND l_datatype = "' . $this->_dbConn->quote($options['literal_datatype']) . '"';
        }
        
        // remove the specified statements from the database
        $this->_dbConn->delete('statements', $whereString);   
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMultipleStatements($graphIri, array $statementsArray)
    {
        $modelId = $this->_modelInfoCache[$graphIri]['modelId'];
        
        $this->_dbConn->beginTransaction();
        try {
            foreach ($statementsArray as $subject => $predicatesArray) {
                foreach ($predicatesArray as $predicate => $objectsArray) {
                    foreach ($objectsArray as $object) {
                        $whereString = 'modelID = ' . $modelId . ' ';
                        
                        // check whether the subject is a blank node
                        if (substr($subject, 0, 2) === '_:') {
                            $subject = substr($subject, 2);
                            $whereString .= 'AND subject_is = "b" ';
                        } else {
                            $whereString .= 'AND subject_is = "r" ';
                        }

                        // check the type of the object
                        if ($object['type'] === 'uri') {
                            $whereString .= 'AND object_is = "r" ';
                        } else if ($object['type'] === 'bnode') {
                            $whereString .= 'AND object_is = "b" ';
                        } else {
                            $whereString .= 'AND object_is = "l" ';
                            $whereString .= isset($object['lang']) ? 'AND l_language ="' . $object['lang'] . '" ' : '';
                            $whereString .= isset($object['datatype']) ? 'AND l_datatype ="' . $object['datatype'] . 
                                            '" ' : '';
                        }

                        $whereString .= 'AND subject = "' . $subject . '" ';
                        $whereString .= 'AND predicate = "' . $predicate . '" ';
                        $whereString .= 'AND object = "' . $object . '" ';
                        
                        $this->_dbConn->delete('statements', $whereString);
                    }
                }
            }
            
            // if everything went ok... commit the changes to the database
            $this->_dbConn->commit();
        } catch (Exception $e) {
            // something went wrong... rollback
            $this->_dbConn->rollback();
            throw new Erfurt_Exception('Bulk insertion of statements failed.');
        }
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteModel($modelIri) 
    {
        $whereString = 'modelID = ' . $this->_modelInfoCache[$modelIri]['modelId'];
        
        // remove all rows with the specified modelID from the models, statements and namespaces tables
        $this->_dbConn->delete('models', $whereString);
        $this->_dbConn->delete('statements', $whereString);
        $this->_dbConn->delete('namespaces', $whereString);
        
        // invalidate the cache and fetch model infos again
        require_once 'Erfurt/App.php';
        $cache = Erfurt_App::getInstance()->getCache();
        $tags =  array('model_info', $this->_modelInfoCache[$modelIri]['modelId']);
        #$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, $tags);
        $this->_fetchModelInfos();
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function exportRdf($modelIri, $serializationType = 'xml', $filename = false)
    {
        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getAvailableModels($withTitle = false) 
    {    
        $models = array();
        foreach ($this->_modelInfoCache as $mInfo) {
            $m = array(
                'modelIri'  => $mInfo['modelIri'],
            );
                
            if ($withTitle === true) {
// TODO add title here
                if (isset($mInfo['title'])) {
                    $m['label'] = $mInfo['title'];
                }
            }
                
            $models[$mInfo['modelIri']] = $m;   
        }
        
        return $models;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getBlankNodePrefix() 
    {
        return 'bNode';
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function getModel($modelIri) 
    {
        // if model is already in cache return the cached value
        if (isset($this->_modelCache[$modelIri])) {
            return $this->_modelCache[$modelIri];
        }

        // choose the right type for the model instance and instanciate it
        if ($this->_modelInfoCache[$modelIri]['type'] === 'owl') {
            require_once 'Erfurt/Owl/Model.php';
            $m = new Erfurt_Owl_Model($modelIri, $this->_modelInfoCache[$modelIri]['baseIri']);
        } else if ($this->_modelInfoCache[$modelIri]['type'] === 'rdfs') {
            require_once 'Erfurt/Rdfs/Model.php';
            $m = new Erfurt_Rdfs_Model($modelIri, $this->_modelInfoCache[$modelIri]['baseIri']);
        } else {
            require_once 'Erfurt/Rdf/Model.php';
            $m = new Erfurt_Rdf_Model($modelIri, $this->_modelInfoCache[$modelIri]['baseIri']);
        }
        
        $this->_modelCache[$modelIri] = $m;
        return $m;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */ 
    public function getNewModel($modelIri, $baseIri = '', $type = 'owl') 
    {    
        $data = array(
            'modelURI'  => $modelIri,
            'baseURI'   => $baseIri
        );

        // insert the new model into the database
        $this->_dbConn->insert('models', $data);
    
        
// TODO add owl:Ontology statement if we can do add
        //if ($type === 'owl') {
        //    $mt->add(new Statement(new Resource($modelIri), new Resource(EF_RDF_TYPE), new Resource(EF_OWL_ONTOLOGY)));
        //}
        
        // invalidate the cache and fetch model infos again
        require_once 'Erfurt/App.php';
        $cache = Erfurt_App::getInstance()->getCache();
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('model_info'));
        $this->_fetchModelInfos();
        
        // instanciate the model
        $m = $this->getModel($modelIri);
            
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
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            return array('rdfxml' => 'RDF/XML');
        } else {
            return array();
        }
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function importRdf($modelUri, $data, $type, $locator)
    {
        if ($this->_dbConn instanceof Zend_Db_Adapter_Mysqli) {
            require_once 'Erfurt/Syntax/RdfParser.php';
            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat($type);
            $parsedArray = $parser->parse($data, $locator, $modelUri, false);
            
            $modelId = $this->_modelInfoCache["$modelUri"]['modelId']; 
            
            // create file
            $filename   =  '/Users/philipp/Sites/ontowiki_1_0/ontowiki/src/libraries/Erfurt/tmp/import.csv';
            $fileHandle = fopen($filename, 'w');
            
            $count = 0;
            foreach ($parsedArray as $s => $pArray) {
                if (substr($s, 0, 1) === '_') {
                    $sType = 'b';
                } else {
                    $sType = 'r';
                }
                
                foreach ($pArray as $p => $oArray) {
                    foreach ($oArray as $o) {
                        if ($o['type'] === 'literal') {
                            $oType = 'l';
                        } else if ($o['type'] === 'bnode') {
                            $oType = 'b';
                        } else {
                            $oType = 'r';
                        }
                                                    
                        $lineString = $modelId . ';' . $s . ';' . $p . ';' . $o['value'] . ';' .
                            md5($o['value']) . ';';
                        
                        if (isset($o['lang'])) {
                            $lineString .= $o['lang'];
                        } else {
                            $lineString .= '';
                        }
                        
                        $lineString .= ';';
                        
                        if (isset($o['datatype'])) {
                            $lineString .= $o['datatype'];
                        } else {
                            $lineString .= '';
                        }
                        
                        $lineString .= ';' . $sType . ';' . $oType . PHP_EOL;
                        
                        $count++;
                        fputs($fileHandle, $lineString);
                        
                    }
                }
            }
      
            fclose($fileHandle);
        
            if ($count > 10000) {
                $this->_dbConn->getConnection()->query('ALTER TABLE statements DISABLE KEYS');
            }
        
            $sql = "LOAD DATA INFILE '$filename' IGNORE INTO TABLE statements
                    FIELDS TERMINATED BY ';'
                    (modelID, subject, predicate, object, object_hash, l_language, l_datatype, subject_is, object_is);";
            
            $this->_dbConn->getConnection()->query('START TRANSACTION;');   
            $this->_dbConn->getConnection()->query($sql);
            $this->_dbConn->getConnection()->query('COMMIT');
            
            if ($count > 10000) {
                 $this->_dbConn->getConnection()->query('ALTER TABLE statements ENABLE KEYS');
            }
            
            unlink($filename);
        } else {
            // Nothing to do here, for this backend has no own import functionality.
        }
        
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function isModelAvailable($modelIri) 
    {
        if (isset($this->_modelInfoCache[$modelIri])) {
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
        
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlQuery($query, $options=array()) 
    {
        $resultform =(isset($options[STORE_RESULTFORMAT]))?$options[STORE_RESULTFORMAT]:STORE_RESULTFORMAT_PLAIN;
        
        require_once 'Erfurt/Sparql/EngineDb/Adapter/RapZendDb.php';
        $engine = new Erfurt_Sparql_EngineDb_Adapter_RapZendDb($this->_dbConn, $this->_modelInfoCache);
                
        require_once 'Erfurt/Sparql/Parser.php';
        $parser = new Erfurt_Sparql_Parser();
        $query = $parser->parse((string)$query);        
#var_dump($query);
        $result = $engine->queryModel($query, $resultform);
        //var_dump($this->_dbConn->getProfiler());exit;
        
        return $result;   
    }
    
    /** @see Erfurt_Store_Sql_Interface */
    public function sqlQuery($sqlQuery)
    {
        return $this->_dbConn->fetchAssoc($sqlQuery);
    }
    
    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * For Zend_Db does not abstract SQL statements that can't be prepared, we need to do this by hand
     * for each supported db server, which can be used with the ZendDb adapter.
     */
    private function _createTableMysqli($tableName, array $columns)
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
#var_dump($createTable);exit;	    
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
            return $this->_createTablesMysqli();
        }
    }
    
    private function _createTablesMysqli() 
    {
        // Create models table.
        $sql = 'CREATE TABLE IF NOT EXISTS models (
                    modelID  INT UNSIGNED AUTO_INCREMENT,
                    modelURI VARCHAR(255) COLLATE ascii_bin NOT NULL, 
                    baseURI  VARCHAR(255) COLLATE ascii_bin NOT NULL DEFAULT "",
                    PRIMARY KEY (modelID),
                    UNIQUE KEY m_modelURI_idx (modelURI))
                ENGINE = MyISAM DEFAULT CHARSET = ascii;';
        
        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);
        
        if (!$success) {
            throw new Exception('Store: Creation of models table failed.');
        }
        
        /*$sql = 'CREATE TABLE IF NOT EXISTS statements (
                    id          INT UNSIGNED AUTO_INCREMENT,
                    modelID     INT UNSIGNED NOT NULL,
                    subject     VARCHAR(255) COLLATE ascii_bin NOT NULL,
                    predicate   VARCHAR(255) COLLATE ascii_bin NOT NULL,
                    object      LONGTEXT COLLATE utf8_bin,
                    object_hash CHAR(32) COLLATE ascii_general_ci NOT NULL,
                    l_language  CHAR(2) COLLATE ascii_general_ci DEFAULT "",
                    l_datatype  VARCHAR(255) COLLATE ascii_bin DEFAULT "",
                    subject_is  ENUM("r","b") COLLATE ascii_general_ci NOT NULL,
                    object_is   ENUM("r","b","l") COLLATE ascii_general_ci NOT NULL,
                    PRIMARY KEY (id),
                    UNIQUE unique_statement (modelID, subject, predicate, object_hash, l_language, l_datatype,
                           subject_is, object_is),
                    KEY s_modelID_idx (modelID),
                    KEY s_subject_idx (subject),
                    KEY s_predicate_idx (predicate),
                    KEY s_object_idx (object(200)),
                    KEY s_sub_pred_idx (subject, predicate),
                    KEY s_pred_obj_idx (predicate, object(200)),
                    KEY s_sub_obj_idx (subject, object(200)),
                    KEY s_subjectis_idx (subject_is),
                    KEY s_objectis_idx (object_is),
                    KEY s_sub_subis_idx (subject, subject_is),
                    KEY s_obj_objis_idx (object(200), object_is),
                    KEY s_obj_objis_lang_idx (object(200), object_is, l_language),
                    KEY s_obj_objis_dt_idx (object(200), object_is, l_datatype),
                    KEY s_llang_idx (l_language),
                    KEY s_ldtype_idx (l_datatype),
                    FULLTEXT KEY s_object_ft_idx (object)) 
                ENGINE = MyISAM DEFAULT CHARSET = ascii;';*/
        
            $sql = 'CREATE TABLE IF NOT EXISTS statements (
                        id          INT UNSIGNED AUTO_INCREMENT,
                        modelID     INT UNSIGNED NOT NULL,
                        subject     VARCHAR(255) COLLATE ascii_bin NOT NULL,
                        predicate   VARCHAR(255) COLLATE ascii_bin NOT NULL,
                        object      LONGTEXT COLLATE utf8_bin,
                        object_hash CHAR(32) COLLATE ascii_general_ci NOT NULL,
                        l_language  CHAR(2) COLLATE ascii_general_ci DEFAULT "",
                        l_datatype  VARCHAR(255) COLLATE ascii_bin DEFAULT "",
                        subject_is  ENUM("r","b") COLLATE ascii_general_ci NOT NULL,
                        object_is   ENUM("r","b","l") COLLATE ascii_general_ci NOT NULL,
                        PRIMARY KEY (id),
                        UNIQUE unique_statement (modelID, subject, predicate, object_hash, l_language, l_datatype,
                               subject_is, object_is),
                        #KEY s_modelID_idx (modelID),
                        #KEY s_subject_idx (subject),
                        #KEY s_predicate_idx (predicate),
                        #KEY s_object_idx (object(333)),
                        #KEY s_sub_pred_idx (subject, predicate),
                        #KEY s_pred_obj_idx (predicate, object(248)),
                        #KEY s_sub_obj_idx (subject, object(248)),
                        #KEY s_subjectis_idx (subject_is),
                        #KEY s_objectis_idx (object_is),
                        #KEY s_sub_subis_idx (subject, subject_is))
                        #KEY s_obj_objis_idx (object(333), object_is),
                        #KEY s_obj_objis_lang_idx (object(332), object_is, l_language),
                        #KEY s_obj_objis_dt_idx (object(248), object_is, l_datatype),
                        #KEY s_llang_idx (l_language),
                        #KEY s_ldtype_idx (l_datatype),
                        #FULLTEXT KEY s_object_ft_idx (object)) 
                    ENGINE = MyISAM DEFAULT CHARSET = ascii;';
        
        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
            throw new Exception('Store: Creation of statements table failed: '.$this->_dbConn->getConnection()->error);
        }
                
        $sql = 'CREATE TABLE IF NOT EXISTS namespaces (
                    modelID   INT UNSIGNED NOT NULL,
                    namespace VARCHAR(255) COLLATE ascii_bin NOT NULL,
                    prefix    VARCHAR(255) COLLATE ascii_bin NOT NULL,
                    PRIMARY KEY (modelID, namespace),
                    KEY n_modelID_idx (modelID)) 
                ENGINE = MyISAM DEFAULT CHARSET = ascii;';
        
        $success = false;
        $success = $this->_dbConn->getConnection()->query($sql);

        if (!$success) {
            throw new Exception('Store: Creation of namespaces table failed.');
        }
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
            $sql = 'SELECT m.modelID, m.modelURI, m.baseURI, n.namespace, n.prefix, s.object, s3.object AS title, 
                        (SELECT count(*) 
                        FROM statements s2 
                        WHERE s2.modelID = m.modelID 
                        AND s2.subject = m.modelURI 
                        AND s2.subject_is = "r" 
                        AND s2.predicate = "' . EF_RDF_TYPE . '" 
                        AND s2.object = "' . EF_OWL_ONTOLOGY . '" 
                        AND s2.object_is = "r") as is_owl_ontology 
                    FROM models m 
                    LEFT JOIN namespaces n ON (m.modelID = n.modelID) 
                    LEFT JOIN statements s ON (m.modelID = s.modelID 
                        AND m.modelURI = s.subject 
                        AND s.predicate = "' . EF_OWL_IMPORTS. '" 
                        AND s.object_is = "r") 
                    LEFT JOIN statements s3 ON (m.modelID = s3.modelID 
                        AND m.modelURI = s3.subject 
                        AND s3.subject_is = "r" 
                        AND s3.object_is = "l" 
                        AND (';
            
            $countTP = count($this->_titleProperties);
            for ($i=1; $i<$countTP; ++$i) {
                $sql .= 's3.predicate = "' . $this->_titleProperties[$i] . '"';
                
                if ($i < count($this->_titleProperties)-1) {
                    $sql .= ' OR ';
                }
            }
            
            $sql .= '))';
            
            // $countSelect = $this->_dbConn->select();
            //             
            //             $countWhereCondition = 's2.modelID = m.modelID AND s2.subject = m.modelURI AND s2.subject_is = `r`' .
            //                                     ' AND s2.predicate = `' . EF_RDF_TYPE . '` AND s2.object = `' . EF_OWL_ONTOLOGY .
            //                                     '` AND s2.object_is = `r`';
            //             
            //             $countSelect
            //                 ->from(array('s2' => 'statements'), array('count(*)'))
            //                 ->where($countWhereCondition);
            //             
            //             $select = $this->_dbConn->select();
            // 
            //             $sJoinCondition = 'm.modelID = s.modelID AND m.modelURI = s.subject AND s.predicate = `' . 
            //                                 EF_OWL_IMPORTS . '` AND s.object_is = `r`';
            //             
            //             $select
            //                 ->from(array('m' => 'models'), array('modelID', 'modelURI', 'baseURI'))
            //                 ->joinLeft(array('n' => 'namespaces'), 'm.modelID = n.modelID', array('namespace', 'prefix'));
            //                 //->joinLeft(array('s' => 'statements'), $sJoinCondition, array('object'));
    
   
    
            //$result = $select->query();
            //var_dump((string)$select);exit;
            //var_dump($select->query()->fetchAll());exit;
            
            try {
                $result = $this->_dbConn->query($sql);
            } catch (Exception $e) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Error while fetching model and namespace informations.');
            }
            
            
            if ($result === false) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Error while fetching model and namespace informations.');
            } else {
                $this->_modelInfoCache = array();
                
                $rowSet = $result->fetchAll();
                foreach ($rowSet as $row) {
                    if (!isset($this->_modelInfoCache[$row['modelURI']])) {
                        $this->_modelInfoCache[$row['modelURI']]['modelId']      = $row['modelID'];
                        $this->_modelInfoCache[$row['modelURI']]['modelIri']     = $row['modelURI'];
                        $this->_modelInfoCache[$row['modelURI']]['baseIri']      = $row['baseURI'];
                        $this->_modelInfoCache[$row['modelURI']]['namespaces']   = array();
                        $this->_modelInfoCache[$row['modelURI']]['imports']      = array();
                    
                        // set the type of the model
                        if ($row['is_owl_ontology'] > 0) {
                            $this->_modelInfoCache[$row['modelURI']]['type'] = 'owl';
                        } else {
                            $this->_modelInfoCache[$row['modelURI']]['type'] = 'rdfs';
                        }

                        if ($row['namespace'] !== null &&
                                !isset($this->_modelInfoCache[$row['modelURI']]['namespaces'][$row['namespace']])) {
                            
                            $this->_modelInfoCache[$row['modelURI']]['namespaces'][$row['namespace']] = $row['prefix'];
                        }
                        if ($row['object'] !== null &&
                         !isset($this->_modelInfoCache[$row['modelURI']]['imports'][$row['object']])) {
                            $this->_modelInfoCache[$row['modelURI']]['imports'][$row['object']] = $row['object'];
                        }
                        
                        if ($row['title'] !== null) {
                            $this->_modelInfoCache[$row['modelURI']]['title'] = $row['title'];
                        }
                    } else {
                        if ($row['namespace'] !== null &&
                                !isset($this->_modelInfoCache[$row['modelURI']]['namespaces'][$row['namespace']])) {
                            
                            $this->_modelInfoCache[$row['modelURI']]['namespaces'][$row['namespace']] = $row['prefix'];
                        }
                        if ($row['object'] !== null &&
                                !isset($this->_modelInfoCache[$row['modelURI']]['imports'][$row['object']])) {
                            
                            $this->_modelInfoCache[$row['modelURI']]['imports'][$row['object']] = $row['object'];
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
            if (!in_array('models', $existingTables) ||
                !in_array('namespaces', $existingTables) ||
                !in_array('statements', $existingTables)) {
            
                return false;
            } else {
                return true;
            }
        } else {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('could not show tables... is db avaiable?');
        }
    }
}
?>
