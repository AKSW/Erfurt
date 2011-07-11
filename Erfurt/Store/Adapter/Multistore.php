<?php 
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id: Multistore.php 4059 2009-08-14 06:40:23Z pfrischmuth $
 */

require_once 'Erfurt/Store/Adapter/Interface.php';
require_once 'Erfurt/Store/Sql/Interface.php';

/**
 * This class acts as a meta-backend class, which can handle multiple 
 * heterogenous backends.
 *
 * @copyright  Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    erfurt
 * @subpackage store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Store_Adapter_Multistore implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{
    const DEFAULT_BACKEND = '__default_backend__'; 
    const BACKEND_PREFIX  = '__additional_backend__';
    
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    private $_backends = array();
    
    private $_configuredGraphs = array();
    
    private $_availableGraphs = null;
    
    public function __construct($adapterOptions = array())
    {
        // Instanciate the default backend
        $defaultBackend        = $adapterOptions['default']['backend'];
        $defaultAdapterOptions = $adapterOptions['default'][$defaultBackend]; 
        
        switch ($defaultBackend) {
            case 'zenddb':
                require_once 'Erfurt/Store/Adapter/EfZendDb.php';
                $this->_backends[self::DEFAULT_BACKEND] = new Erfurt_Store_Adapter_EfZendDb($defaultAdapterOptions);
                break;
            case 'virtuoso':
                require_once 'Erfurt/Store/Adapter/Virtuoso.php';
                $this->_backends[self::DEFAULT_BACKEND] = new Erfurt_Store_Adapter_Virtuoso($defaultAdapterOptions);
                break;
            default:
                require_once 'Erfurt/Store/Adapter/Exception.php';
                throw new Erfurt_Store_Adapter_Exception('Wrong default backend type specified.');
        }
        
        // For the default backend we configure all available graphs.
        // default, for they are needed!
        $backend = $this->_backends[self::DEFAULT_BACKEND];
        foreach ($backend->getAvailableModels() as $modelUri=>$true) {
            $this->_configuredGraphs[$modelUri] = self::DEFAULT_BACKEND;
        }

        // Instanciate additional backends from ini
        if (isset($adapterOptions['additional'])) {
            foreach ($adapterOptions['additional'] as $i=>$additionalConfig) {
                $backendName = $additionalConfig['backend'];
                $backendOptions = $additionalConfig[$backendName];

                switch ($backendName) {
                    case 'zenddb':
                        require_once 'Erfurt/Store/Adapter/EfZendDb.php';
                        $this->_backends[self::BACKEND_PREFIX.$i] = new Erfurt_Store_Adapter_EfZendDb($backendOptions);
                        break;
                    case 'virtuoso':
                        require_once 'Erfurt/Store/Adapter/Virtuoso.php';
                        $this->_backends[self::BACKEND_PREFIX.$i] = new Erfurt_Store_Adapter_Virtuoso($backendOptions);
                        break;
                    case 'sparql':
                        require_once 'Erfurt/Store/Adapter/Sparql.php';
                        $this->_backends[self::BACKEND_PREFIX.$i] = new Erfurt_Store_Adapter_Sparql($backendOptions);
                        break;
                    case 'ontowiki':
                        require_once 'Erfurt/Store/Adapter/OntoWiki.php';
                        $this->_backends[self::BACKEND_PREFIX.$i] = new Erfurt_Store_Adapter_OntoWiki($backendOptions);
                        break;
                    default:
                        require_once 'Erfurt/Store/Adapter/Exception.php';
                        throw new Erfurt_Store_Adapter_Exception('Backend type currently not supported.');
                }

                if (isset($additionalConfig['graphs'])) {
                    foreach ($additionalConfig['graphs'] as $graphUri) {
                        $this->_configuredGraphs[$graphUri] = self::BACKEND_PREFIX . $i;
                    }
                }
            }
        }
    }
    
    public function addMultipleStatements($graphUri, array $statementsArray, array $options = array())
    {
        $backend = $this->_getBackend($graphUri);
        
        return $backend->addMultipleStatements($graphUri, $statementsArray, $options);
    }
    
    public function addStatement($graphUri, $subject, $predicate, $object, array $options = array())
    {
        $backend = $this->_getBackend($graphUri);
        
        return $backend->addStatement($graphUri, $subject, $predicate, $object, $options);
    }
    
    public function countWhereMatches($graphIris, $whereSpec, $countSpec)
    {
        $fullCount = 0;
        foreach ($graphIris as $graphUri) {
            $backend = $this->_getBackend($graphUri);
            
            if (method_exists($backend, 'countWhereMatches')) {
                $fullCount += $backend->countWhereMatches(array($graphUri), $whereSpec, $countSpec);
            } else {
                // If one backend does not support this, we need to throw an exception.
                throw new Erfurt_Store_Adapter_Exception('Count not supported by backend.');
            }
        }
        
        return $fullCount;
    }
    
    public function createModel($graphUri, $type = Erfurt_Store::MODEL_TYPE_OWL)
    {
        $this->_availableGraphs = null;
        $this->_configuredGraphs[$graphUri] = self::DEFAULT_BACKEND;
        
        return $this->_backends[self::DEFAULT_BACKEND]->createModel($graphUri, $type);
    }
    
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, array $options = array())
    {
        $backend = $this->_getBackend($graphUri);
        
        return $backend->deleteMatchingStatements($graphUri, $subject, $predicate, $object, $options);
    }
    
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {
        $backend = $this->_getBackend($graphUri);
        
        return $backend->deleteMultipleStatements($graphUri, $statementsArray);
    }
    
    public function deleteModel($graphUri)
    {
        $backend = $this->_getBackend($graphUri);
        
        return $backend->deleteModel($graphUri);
    }
    
    public function exportRdf($graphUri, $serializationType = 'xml', $filename = false)
    {
        $backend = $this->_getBackend($graphUri);
        
        return $backend->exportRdf($graphUri, $serializationType, $filename);
    }
    
    public function getImportsClosure($graphUri)
    {
        $backend = $this->_getBackend($graphUri);
        
        return $backend->getImportsClosure($graphUri);
    }
    
    public function getAvailableModels()
    {
        if (null === $this->_availableGraphs) {
            $result = array();
            
            foreach ($this->_configuredGraphs as $graphUri=>$backend) {
                if (isset($this->_backends[$backend]) && $this->_backends[$backend]->isModelAvailable($graphUri)) {
                    $result[$graphUri] = true;
                }
            }
            
            $this->_availableGraphs = $result;
        }
        
        return $this->_availableGraphs;
    }
    
    public function getBackendName()
    {
        if (method_exists($this->_backends[self::DEFAULT_BACKEND], 'getBackendName')) {
            return $this->_backends[self::DEFAULT_BACKEND]->getBackendName();
        } else {
            return 'Multistore';
        }
    }
    
    public function getBlankNodePrefix()
    {
        return 'bNode';
    }
    
    public function getModel($graphUri)
    {
        if (isset($this->_configuredGraphs[$graphUri])) {
            $backend = $this->_backends[$this->_configuredGraphs[$graphUri]];
            return $backend->getModel($graphUri);
        } else {
            return false;
        }
    }
    
    public function getSupportedExportFormats()
    {
        return array();
    }
    
    public function getSupportedImportFormats()
    {
        return array();
    }
    
    public function importRdf($modelUri, $data, $type, $locator)
    {
        return false;
    }
    
    public function init()
    {
        $this->_availableGraphs = null;
        
        foreach ($this->_backends as $backend) {
            $backend->init();
        }
    }
    
    public function isModelAvailable($graphUri)
    {
        $graphs = $this->getAvailableModels();
        
        if (isset($graphs[$graphUri])) {
            return true;
        } else {
            return false;
        }
    }
    
    public function sparqlAsk($query)
    {
// TODO
    }
    
    public function sparqlQuery($query, $options=array())
    {   
        $resultform =(isset($options[STORE_RESULTFORMAT]))?$options[STORE_RESULTFORMAT]:STORE_RESULTFORMAT_PLAIN;
        
        if(!($query instanceof Erfurt_Sparql_SimpleQuery)) {
            $query = Erfurt_Sparql_SimpleQuery::initWithString((string)$query);
        }
        
        $limit  = $query->getLimit();
        $offset = $query->getOffset();
        
        if (strpos(strtolower($query->getProloguePart()), 'distinct') !== false) {
            $isDistinct = true;
        } else {
            $isDistinct = false;
        }
        
        $queryBackends = array();
        foreach ($query->getFrom() as $from) {
            if (isset($this->_configuredGraphs[$from])) {
                if (isset($queryBackends[$this->_configuredGraphs[$from]])) {
                    $queryBackends[$this->_configuredGraphs[$from]][] = $from;
                } else {
                    $queryBackends[$this->_configuredGraphs[$from]] = array($from);
                }
            }
        }
        foreach ($query->getFromNamed() as $fromNamed) {
            if (isset($this->_configuredGraphs[$fromNamed])) {
                if (isset($queryBackends[$this->_configuredGraphs[$fromNamed]])) {
                    $queryBackends[$this->_configuredGraphs[$fromNamed]][] = $fromNamed;
                } else {
                    $queryBackends[$this->_configuredGraphs[$fromNamed]] = array($fromNamed);
                }
            }
        }
        
        // Special care if offset is given and grater zero
        if (null !== $offset && $offset > 0) {
            $currentCount = 0;
            $newBackends = array();
            foreach ($queryBackends as $backendId=>$graphUris) {
                $tempQuery = clone $query;
                if ($isDistinct) {
                    $tempQuery->setProloguePart('COUNT DISTINCT');
                } else {
                    $tempQuery->setProloguePart('COUNT');
                }
                $tempQuery->setFrom($graphUris);
                $tempQuery->setOffset(null);
                $tempQuery->setLimit(null);
                
                $count = $this->_backends[$backendId]->sparqlQuery($tempQuery);
                $currentCount += $count;
                
                if ($offset < $currentCount) {
                    $newBackends[$backendId] = $graphUris;
                    
                    if (null !== $limit && $currentCount >= ($offset+$limit)) {
                        break;
                    }
                } else {
                    $offset = $offset-$count;
                    if ($offset < 0) {
                        $offset = 0;
                    }
                }
            }
            
            $queryBackends = $newBackends;
        }
        
        $result = array();
        $currentCount = 0;
        foreach ($queryBackends as $backendId=>$graphUris) {
            $tempQuery = clone $query;
            $tempQuery->setFrom($graphUris);
            $tempQuery->setOffset($offset);
            $tempQuery->setLimit($limit);
            $offset = null;
            
            $tempResult = $this->_backends[$backendId]->sparqlQuery($tempQuery, $resultform);
            
            if (null !== $limit) {
                if ($resultform === 'plain') {
                    $limit = $limit - count($tempResult);
                    if ($limit < 0) {
                        $limit = 0;
                    }
                } else {
                    $limit = $limit - count($tempResult['result']['bindings']);
                    if ($limit < 0) {
                        $limit = 0;
                    }
                }
            }
            
            if ($resultform === 'plain') {
                $result = array_merge($result, $tempResult);
            } else {
                if (empty($result)) {
                    $result['head'] = $tempResult['head'];
                    $result['result']['bindings'] = $tempResult['bindings'];
                } else {
                    $result['result']['bindings'] = array_merge($result['bindings'], $tempResult['bindings']);
                }
                
                
            }
        }
        
// TODO Handle DISTINCT
        
        return $result;
    }
    
    public function getLogoUri()
    {
        return $this->_xyz();
    }
        
    private function _xyz()
    {
        $logo = 'data:image/png;base64,
        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
        lOkbAAAAAElFTkSuQmCC';
        
        return $logo;
    }
    
    
    // ------------------------------------------------------------------------
    // --- Sql interface methods ----------------------------------------------
    // ------------------------------------------------------------------------
    
    public function createTable($tableName, array $columns)
    {
        $defaultBackend = $this->_backends[self::DEFAULT_BACKEND];
        return $defaultBackend->createTable($tableName, $columns);
    }
    
    public function lastInsertId()
    {
        $defaultBackend = $this->_backends[self::DEFAULT_BACKEND];
        return $defaultBackend->lastInsertId();
    }
    
    public function listTables($prefix = '')
    {
        $defaultBackend = $this->_backends[self::DEFAULT_BACKEND];
        return $defaultBackend->listTables($prefix);
    }
    
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        $defaultBackend = $this->_backends[self::DEFAULT_BACKEND];
        return $defaultBackend->sqlQuery($sqlQuery, $limit, $offset);
    }
    
    
    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------
    
    private function _getBackend($graphUri) {
        
        if (isset($this->_configuredGraphs[$graphUri])) {
           return $this->_backends[$this->_configuredGraphs[$graphUri]];
        } else {
            var_dump($this->_configuredGraphs, $graphUri);exit;
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Graph with URI <' . $graphUri . '> is not configured.');
        }
    }
}
