<?php 

/*
 * database tables:
 * CREATE TABLE ef_versioning_actions(
 *   id             INT NOT NULL, 
 *   model          VARCHAR(255) NOT NULL, 
 *   user           VARCHAR(255) NOT NULL,
 *   resource       VARCHAR(255), 
 *   tstamp         TIMESTAMP NOT NULL, 
 *   action_type    INT NOT NULL, 
 *   parent         INT DEFAULT NULL, 
 *   payload_id     INT NOT NULL
 * );
 * 
 * CREATE TABLE ef_versioning_payloads(
 *   id                 INT NOT NULL PRIMARY KEY, 
 *   statement_hash     LONGTEXT
 * );
 *
 */

/**
 * Erfurt versioning component
 *
 * @package    versioning
 * @author     Philipp Frischmuth <prischmuth@googlemail.com>
 * @author     Norman Heino <norman.heino@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Versioning
{
    const MODEL_IMPORTED      = 10;
    const STATEMENT_ADDED     = 20;
    const STATEMENT_CHANGED   = 21;
    const STATEMENT_REMOVED   = 22;
    const STATEMENTS_ROLLBACK = 23;
    
    protected $_currentAction = null;
    
    protected $_versioningEnabled = true;
    
    protected $_limit = 10;
    
    
    public function __construct()
    {
        $this->_initialize();
        
        // register for events
        require_once 'Erfurt/Event/Dispatcher.php';
        $eventDispatcher = Erfurt_Event_Dispatcher::getInstance();
        $eventDispatcher->register('onAddStatement', $this)
                        ->register('onAddMultipleStatements', $this)
                        ->register('onDeleteMatchingStatements', $this)
                        ->register('onDeleteMultipleStatements', $this);   
    }
    
    /**
     * Enables or disables versioning.
     *
     * @param bool $versioningEnabled True, if versioning is enabled, false otherwise
     */
    public function enableVersioning($versioningEnabled = true)
    {
        $this->_versioningEnabled = (bool) $versioningEnabled;
    }
    
    /**
     * 
     *
     *
     */
    public function endAction()
    {
        // no action to end?
        if (null === $this->_currentAction) {
// TODO throw exception
            throw new Exception();
        }
        
        $this->_currentAction = null;
    }
    
    /**
     * Probably shortcut?
     */
    public function getLastModifiedForResource($resourceUri, $graphUri)
    {
        $history = $this->getHistoryForResource($resourceUri, $graphUri);
        
        return $history[0];
    }
    
    public function getHistoryForGraph($graphUri, $page = 1)
    {
        $sql = 'SELECT id, user, resource, tstamp, action_type FROM ef_versioning_actions WHERE
                model = "' . $graphUri . '"
                ORDER BY tstamp DESC LIMIT ' . $this->getLimit() . ' OFFSET ' .
                ($page*$this->getLimit()-$this->getLimit());
                
        $result = $this->_getStore()->sqlQuery($sql);
        
        return $result;
    }
    
    public function getHistoryForResource($resourceUri, $graphUri, $page = 1)
    {   
        $sql = 'SELECT id, user, tstamp, action_type FROM ef_versioning_actions WHERE
                model = "' . $graphUri . '" AND resource = "' . $resourceUri . '"
                ORDER BY tstamp DESC LIMIT ' . $this->getLimit() . ' OFFSET ' .
                ($page*$this->getLimit()-$this->getLimit());
               
        $result = $this->_getStore()->sqlQuery($sql);
        
        return $result;
    }
    
    public function getHistoryForUser($userUri, $page = 1)
    {
        $sql = 'SELECT id, resource, tstamp, action_type FROM ef_versioning_actions WHERE
                user = "' . $userUri . '"
                ORDER BY tstamp DESC LIMIT ' . $this->getLimit() . ' OFFSET ' .
                ($page*$this->getLimit()-$this->getLimit());
                
        $result = $this->_getStore()->sqlQuery($sql);
        
        return $result;
    }
    
    public function getLimit()
    {
        return $this->_limit;
    }
    
    /**
     * Returns whether an action is currently running or not.
     * 
     * @return bool Returns true iff an action is currently started, else false.
     */
    public function isActionStarted()
    {
        return (null !== $this->_currentAction);
    }
    
    /**
     * Returns whether versioning is currently enabled or not.
     * 
     * @return bool Returns true iff versioning is enabled, false else.
     */
    public function isVersioningEnabled()
    {
        return (bool) $this->_versioningEnabled;
    }
    
    public function setLimit($limit)
    {
        if ($limit <= 0) {
// TODO dedicated exception
            // Limit always has to be greater than zero. One result row should be the minimum, for
            // zero means no result exists.
            throw new Exception();
        }
        
        $this->_limit = (int) $limit;
    }
    
    public function onAddStatement(Erfurt_Event $event)
    {
        $payloadId = $this->_execAddPayload($event->statement);
        $resourceArray = array_keys($event->statement);
        $resource = $resourceArray[0];
        $this->_execAddAction($event->graphUri, $resource, self::STATEMENT_ADDED, $payloadId);
    }
    
    public function onAddMultipleStatements(Erfurt_Event $event)
    {
        $graphUri = $event->graphUri;
        
        $this->_execAddPayloadsAndActions($graphUri, self::STATEMENT_ADDED, $event->statements);
    }
    
    public function onDeleteMatchingStatements(Erfurt_Event $event)
    {
        $graphUri = $event->graphUri;
        
        if (isset($event->statements)) {
            $this->_execAddPayloadsAndActions($graphUri, self::STATEMENT_REMOVED, $event->statements);
        } else {
            // In this case, we have no payload. Just add a action without a payload (no rollback possible).
            $this->_execAddAction($graphUri, $event->resource, self::STATEMENT_REMOVED);
        }
    }
    
    public function onDeleteMultipleStatements(Erfurt_Event $event)
    {
        $graphUri = $event->graphUri;
        
        $this->_execAddPayloadsAndActions($graphUri, self::STATEMENT_REMOVED, $event->statements);
    }
    
    public function rollbackAction($actionId) 
    {
        $actionsSql = 'SELECT action_type, payload_id FROM ef_versioning_actions WHERE id = ' . 
                       ((int)$actionId);
                       
        $result = $this->_getStore()->sqlQuery($actionsSql);
        
        if ((count($result) !== 1) || ($result[0]['payload_id'] === null)) {
// TODO dedicated exception
            throw new Exception('No rollback possible');
        } else {
            $type = (int) $result[0]['action_type'];
            
            $payloadsSql = 'SELECT statements_hash FROM ef_versioning_payloads WHERE id = ' .
                           ((int)$result[0]['payload_id']);
                           
            $payloadResult = $this->_getStore()->sqlQuery($payloadsSql);
            
            if (count($payloadResult) !== 1) {
// TODO dedicated exception
                throw new Exception('No rollback possible');
            }
                
            $payload = unserialize($payloadResult[0]['statements_hash']);
            
            if ($type === self::STATEMENT_ADDED) {
                $this->_getStore()->deleteMultipleStatements($payload);
            } else if ($type === self::STATEMENT_REMOVED) {
                $this->_getStore()->addMultipleStatements($payload);
            }
        }
    }
    
    /**
     * Starts a log action to which subsequent statement modifications are added.
     *
     * @param $actionName string The name of the action to be recorded.
     * @return 
     */
    public function startAction($actionSpec)
    {
        // action already running?
        if (null !== $this->_currentAction) {
// TODO throw exception
            throw new Exception();
        }
        
        $this->_currentAction = $actionSpec;
    }
    
    private function _execAddAction($graphUri, $resource, $actionType, $payloadId = null)
    {
        $user = $this->_getAuth()->getIdentity();
        $userUri = $user['uri'];
        
        $actionsSql = 'INSERT INTO ef_versioning_actions (model, user, resource, tstamp, action_type, parent';
        
        if (null !== $payloadId) {
            $actionsSql .= ', payload_id)';
        } else {
            $actionsSql .= ')';
        }
        
        $actionsSql .= 'VALUES (' . $graphUri . ', ' . $userUri . ', ' . $resource . ', ' . date('c') . ', ' . 
                       $actionType . ', NULL';
                       
        if (null !== $payloadId) {
           $actionsSql .= ', ' . $payloadId . ')';
        } else {
           $actionsSql .= ')';
        }               
                       
        $this->_getStore()->sqlQuery($actionsSql);
    }
    
    private function _execAddPayload($payload)
    {
        $payloadsSql = 'INSERT INTO ef_versioning_payloads (statement_hash) VALUES (' .
                        serialize($payload) . ')';
                        
        $this->_getStore()->sqlQuery($payloadsSql);
        $payloadId = $this->_getStore()->lastInsertId();
        
        return $payloadId;
    }
    
    private function _execAddPayloadsAndActions($graphUri, $actionType, $statements) 
    {
        foreach ($statements as $s => $poArray) {
            foreach ($poArray as $p => $oArray) {
                foreach ($oArray as $i => $oSpec) {
                    $statement = array($s => array($p => array(array($oSpec))));
                    
                    $payloadId = $this->_execAddPayload($statement);
                    $this->_execAddAction($graphUri, $s, $actionType, $payloadId);
                }
            }
        }
    }
    
    /**
     * This method is public only for unit testing purposes in order to allow stubbing of the store object.
     * It should never be called directly. A direct call of this method will not do any harm, for the object is
     * just reset.
     */
    public function _getStore()
    {
        $app = Erfurt_App::getInstance();
        return $app->getStore();
    }
    
    /**
     * This method is public only for unit testing purposes in order to allow stubbing of the auth object.
     * It should never be called directly. A direct call of this method will not do any harm, for the object is
     * just reset.
     */
    public function _getAuth()
    {
        $app = Erfurt_App::getInstance();
        return $app->getAuth();
    }
    
    private function _initialize()
    {
        if (!$this->_getStore()->isSqlSupported()) {
            throw new Exception('For versioning support store adapter needs to implement the SQL interface.');
        }
        
        $existingTableNames = $this->_getStore()->listTables();
        
        if (!in_array('ef_versioning_actions', $existingTableNames)) {
            $columnSpec = array(
                'id'          => 'INT PRIMARY KEY',
                'model'       => 'VARCHAR(255) NOT NULL',
                'user'        => 'VARCHAR(255) NOT NULL',
                'resource'    => 'VARCHAR(255)',
                'tstamp'      => 'TIMESTAMP NOT NULL',
                'action_type' => 'INT NOT NULL',
                'parent'      => 'INT DEFAULT NULL',
                'payload_id'  => 'INT NOT NULL'
            );
            
            $this->_getStore()->createTable('ef_versioning_actions', $columnSpec);
        }
        
        if (!in_array('ef_versioning_payloads', $existingTableNames)) {
            $columnSpec = array(
                'id'             => 'INT PRIMARY KEY',
                'statement_hash' => 'LONGTEXT'
            );
            
            $this->_getStore()->createTable('ef_versioning_payloads', $columnSpec);
        }        
    }
}
