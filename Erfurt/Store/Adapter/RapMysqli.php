<?php
require_once 'Erfurt/Store/Adapter/Interface.php';

/**
 * Erfurt RDF Store - Adapter for the {@link http://www4.wiwiss.fu-berlin.de/bizer/rdfapi/ RAP} schema with MySQL
 * database server, connected via the PHP mysqli extension.
 * 
 * @package    store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Store_Adapter_RapMysqli implements Erfurt_Store_Adapter_Interface 
{
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    private $_modelCache = array();
    private $_modelInfoCache = false;
    
    private $_dbConn = false;
    
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
// TODO support of table prefix ?!
        $host       = $adapterOptions['host'];
        $username   = $adapterOptions['username'];
        $password   = $adapterOptions['password'];
        $dbname     = $adapterOptions['dbname'];
        
        $this->_dbConn = new mysqli($host, $username, $password, $dbname);
    
        if (!$this->_dbConn) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('could not establish mysqli connection');
        }
        
        try {
            // try to fetch model and namespace infos... if all tables are present this should not lead to an error.
            $this->_fetchModelInfos();
        } catch (Erfurt_Exception $e) {
            // error while fetching model and namespace infos... should only be the case if the tables aren't present,
            // for db connection is already established (in constructor)... so let's check for tables
            require_once 'Erfurt/Exception.php';
            if (!$this->_isSetup()) {
                throw new Erfurt_Exception('Store: Database environment not initialized.');
            } else {
                throw new Erfurt_Exception('Store: Error while fetching model and namespace infos.');
            }   
        }
    }
    
    public function __destruct() 
    {    
        $this->_dbConn->close();
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods (derived from Erfurt_Store_Adapter_Abstract) --------
    // ------------------------------------------------------------------------
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function addStatement($modelIri, $subject, $predicate, $object, 
            $options = array('subject_type' => Erfurt_Store::TYPE_IRI, 'object_type' => Erfurt_Store::TYPE_IRI))
    {
        $modelId = $this->_modelInfoCache[$modelIri]['modelId'];
        $subject_type = ($options['subject_type'] === Erfurt_Store::TYPE_IRI) ? 'r' : 'b';
        $object_type = ($options['object_type'] === Erfurt_Store::TYPE_IRI) ? 'r' :
                            ($options['object_type'] === Erfurt_Store::TYPE_LITERAL) ? 'l' : 'b';
        
        if ($object_type === 'l') {
            $lang = (isset($options['literal_language'])) ? $options['literal_language'] : '';
            $dType = (isset($options['literal_datatype'])) ? $options['literal_datatype'] : '';
        } else {
            $lang = '';
            $dType = '';
        }
        
        $sql = 'INSERT INTO models (modelID, subject, predicate, object, subject_is, object_is, l_language, l_datatype)
                VALUES (
                    '  . $modelId . ',
                    "' . $subject . '",
                    "' . $predicate . '",
                    "' . $object . '",
                    "' . $subject_type . '",
                    "' . $object_type . '",
                    "' . $lang . '",
                    "' . $dType . '")';

        $result = $this->_dbConn->query($sql);
        
        if ($result !== true) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Addtition of statement failed.');
        }
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMatchingStatements($modelIri, $subject, $predicate, $object)
    {
        throw new Exception('Not implemented yet.');
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteModel($modelIri) 
    {
        $sql  = 'DELETE FROM models WHERE modelID = ' . $this->_modelInfoCache[$modelIri]['modelId'] . '; ';
        $sql .= 'DELETE FROM statements WHERE modelID = ' . $this->_modelInfoCache[$modelIri]['modelId'] . '; ';
        $sql .= 'DELETE FROM namespaces WHERE modelID = ' . $this->_modelInfoCache[$modelIri]['modelId'];
    
        // execute deletion and throw exception if fails
        if ($this->_dbConn->multi_query($sql) !== true) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('Deletion of model failed. (Database error.)');
        }
        
        // invalidate the cache and fetch model infos again
        require_once 'Erfurt/App.php';
        $cache = Erfurt_App::getInstance()->getCache();
        $tags =  array('model_info', $this->_modelInfoCache[$modelIri]['modelId']);
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, $tags);
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
                $m['title'] = 'NOT IMPLEMENTED YET.';
            }
                
            $models[] = $m;   
        }
        
        return $models;
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
    public function getNewModel($modelIri, $baseIri = '', $type = 'owl', $useAc = true) 
    {    
        $mIri = $this->_dbConn->real_escape_string($modelIri);
        $bIri = $this->_dbConn->real_escape_string($baseIri);

        $sql = 'INSERT INTO models (modelUri, baseUri)
                VALUES ("' . $mIri . '", "' . $bIri . '")';
    
        // execute insertion and throw exception if fails
        if ($this->_dbConn->query($sql) !== true) {
            require_once 'Erfurt/Exception.php';
            
            // if debug mode is enabled create a more detailed exception description. If debug mode is disabled the
            // user should not know why this fails.
            if (defined('_EFDEBUG')) {
                throw new Erfurt_Exception('Could not create model (Database error).');
            } else {
                throw new Erfurt_Exception('Could not create model.');
            }   
        }
        
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
        $m = $this->getModel($modelIri, $useAc);
            
        return $m;
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
	public function getSupportedExportFormats()
	{
	    return array('xml', 'n3', 'nt');
	}
	
	/** @see Erfurt_Store_Adapter_Interface */
	public function getSupportedImportFormats()
	{
	    return array('xml', 'n3', 'nt');
	}
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function importRdf($modelIri, $data, $type, $locator)
    {
        throw new Exception('Not implemented yet.');
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
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlAsk(Erfurt_Sparql_SimpleQuery $query)
    {
        
    }
    
    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlQuery(Erfurt_Sparql_SimpleQuery $query, $resultform = 'plain') 
    {   
        require_once 'Erfurt/Sparql/EngineDb/Adapter/RapMysqli.php';
        $engine = new Erfurt_Sparql_EngineDb_Adapter_RapMysqli($this->_dbConn, $this->_modelInfoCache);
                
        require_once 'Erfurt/Sparql/Parser.php';
        $parser = new Erfurt_Sparql_Parser();
        $query = $parser->parse((string)$query);        
                
        $result = $engine->queryModel($query, $resultform);
        
        return $result;   
    }
    
    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * @throws Erfurt_Exception Throws exception if something goes wrong while initialization of database.
     */
    private function _createTables() 
    {

        $sql = 'CREATE TABLE IF NOT EXISTS models (
                    modelID     INT UNSIGNED        AUTO_INCREMENT,
                    modelIri    VARCHAR(255)        COLLATE ascii_bin           NOT NULL, 
                    baseIri     VARCHAR(255)        COLLATE ascii_bin           NOT NULL        DEFAULT "",
                    PRIMARY KEY (modelID),
                    UNIQUE KEY m_modelIri_idx (modelIri))
                ENGINE = MyISAM     DEFAULT CHARSET = ascii;
                
                CREATE TABLE IF NOT EXISTS statements (
                    id          INT UNSIGNED        AUTO_INCREMENT,
                    modelID     INT UNSIGNED                                    NOT NULL,
                    subject     VARCHAR(255)        COLLATE ascii_bin           NOT NULL,
                    predicate   VARCHAR(255)        COLLATE ascii_bin           NOT NULL,
                    object      LONGTEXT            COLLATE utf8_bin,
                    l_language  CHAR(2)             COLLATE ascii_general_ci    DEFAULT "",
                    l_datatype  VARCHAR(255)        COLLATE ascii_bin           DEFAULT "",
                    subject_is  ENUM("r","b")       COLLATE ascii_general_ci    NOT NULL,
                    object_is   ENUM("r","b","l")   COLLATE ascii_general_ci    NOT NULL,
                    PRIMARY KEY (id),
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
                ENGINE = MyISAM     DEFAULT CHARSET = ascii;
                
                CREATE TABLE IF NOT EXISTS namespaces (
                    modelID     INT UNSIGNED                                    NOT NULL,
                    namespace   VARCHAR(255)                                    NOT NULL,
                    prefix      VARCHAR(255)                                    NOT NULL,
                    PRIMARY KEY (modelID, namespace),
                    KEY n_modelID_idx (modelID)) 
                ENGINE = MyISAM     DEFAULT CHARSET = ascii;';
        
        $result = $this->_dbConn->multi_query($sql);
        $errorCount = 0;
        $errorMsg = array();
        
        do {
            var_dump($result);
            if ($result === false) {
                $errorCount++;
                
                $errorMsg[] = $result->error;
            }
        } while ($result = $this->_dbConn->next_result());
        
        var_dump($errorMsg);exit;
        
        if ($errorCount > 0) {
            require_once 'Erfurt/Exception.php';
            if (defined('_EFDEBUG')) {
                $exceptionStr = 'DB initialization failed: ' . $errorCount . ' errors.' . PHP_EOL;
                foreach ($errorMsg as $msg) {
                    $exceptionStr .= '- ' . $msg . PHP_EOL;
                }
                
                throw new Erfurt_Exception($exceptionStr);
            } else {
                throw new Erfurt_Exception('DB initialization failed.');
            }
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
            $sql = 'SELECT m.modelID, m.modelURI, m.baseURI, n.namespace, n.prefix, s.object,
                    (SELECT count(*) as is_owl_ontology 
                     FROM statements s2 
                     WHERE s2.modelID = m.modelID AND s2.subject = m.modelURI AND s2.subject_is = "r" 
                     AND s2.predicate = "' . EF_RDF_TYPE . '" AND s2.object = "' . EF_OWL_ONTOLOGY . '"
                     AND s2.object_is = "r")
                FROM models m 
                LEFT JOIN namespaces n ON (m.modelID = n.modelID) 
                LEFT JOIN statements s ON (m.modelID = s.modelID AND m.modelURI = s.subject 
                AND s.predicate = "' . EF_OWL_IMPORTS. '" AND s.object_is = "r")';
        
    
            $result = $this->_dbConn->query($sql);
            if ($result === false) {
                require_once 'Erfurt/Exception.php';
                throw new Erfurt_Exception('Error while fetching model and namespace informations.');
            } else {
                $this->_modelInfoCache = array();
                while ($row = $result->fetch_row()) {
                    if (!isset($this->_modelInfoCache["$row[1]"])) {
                        $this->_modelInfoCache["$row[1]"]['modelId'] = $row[0];
                        $this->_modelInfoCache["$row[1]"]['modelIri'] = $row[1];
                        $this->_modelInfoCache["$row[1]"]['baseIri'] = $row[2];
                        $this->_modelInfoCache["$row[1]"]['namespaces'] = array();
                        $this->_modelInfoCache["$row[1]"]['imports'] = array();
                    
                        // set the type of the model
                        if ($row[6] > 0) {
                            $this->_modelInfoCache["$row[1]"]['type'] = 'owl';
                        } else {
                            $this->_modelInfoCache["$row[1]"]['type'] = 'rdfs';
                        }

                        if ($row[3] !== null && !isset($this->_modelInfoCache["$row[1]"]['namespaces']["$row[3]"])) {
                            $this->_modelInfoCache["$row[1]"]['namespaces']["$row[3]"] = $row[4];
                        }
                        if ($row[5] !== null && !isset($this->_modelInfoCache["$row[1]"]['imports']["$row[5]"])) {
                            $this->_modelInfoCache["$row[1]"]['imports']["$row[5]"] = $row[5];
                        }
                    } else {
                        if ($row[3] !== null && !isset($this->_modelInfoCache["$row[1]"]['namespaces']["$row[3]"])) {
                            $this->_modelInfoCache["$row[1]"]['namespaces']["$row[3]"] = $row[4];
                        }
                        if ($row[5] !== null && !isset($this->_modelInfoCache["$row[1]"]['imports']["$row[5]"])) {
                            $this->_modelInfoCache["$row[1]"]['imports']["$row[5]"] = $row[5];
                        }
                    }
                }
                $result->close();
            
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
        $result = $this->_dbConn->query('SHOW TABLES');
        
        // something went wrong... missing database?!
        if ($result === false) {
            require_once 'Erfurt/Exception.php';
            throw new Erfurt_Exception('could not show tables... is db avaiable?');
        } else if (count($result) < 3) {
            // currently we have 9 tables
            return false;
        } else {
            if (!in_array('models', $result) ||
                !in_array('namespaces', $result) ||
                !in_array('statements', $result)) {
            
                return false;
            } else {
                return true;
            }
        }
    }
}
?>
