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
    public function endAction($actionSpec)
    {
        // no action to end?
        if (null === $this->_currentAction) {
            // throw exception
        }
        
        $this->_currentAction = $actionSpec;
    }
    
    /**
     * Probably shortcut?
     */
    public function getLastModifiedForResource($resourceUri, $graphUri)
    {
        return $this->getHistoryForResource($resourceUri, $graphUri)[0];
    }
    
    public function getHistoryForModel($graphUri, $page = 1)
    {
        $app = Erfurt_App::getInstance();
        $store = $app->getStore();
        
        $sql = 'SELECT id, user, resource, tstamp, action_type FROM ef_versioning_actions WHERE
                model = `' . $graphUri . '` 
                ORDER BY tstamp DESC';
                
        $result = $store->sqlQuery($sql);
        
        return $result;
    }
    
    public function getHistoryForResource($resourceUri, $graphUri, $page = 1)
    {
        $app = Erfurt_App::getInstance();
        $store = $app->getStore();
        
        $sql = 'SELECT id, user, tstamp, action_type FROM ef_versioning_actions WHERE
                model = `' . $graphUri . '` AND resource = `' . $resourceUri . '`
                ORDER BY tstamp DESC';
                
        $result = $store->sqlQuery($sql);
        
        return $result;
    }
    
    public function getHistoryForUser($userUri, $page = 1)
    {
        $app = Erfurt_App::getInstance();
        $store = $app->getStore();
        
        $sql = 'SELECT id, resource, tstamp, action_type FROM ef_versioning_actions WHERE
                user = `' . $userUri . '` 
                ORDER BY tstamp DESC';
                
        $result = $store->sqlQuery($sql);
        
        return $result;
    }
    
    public function setLimit($limit)
    {
        $this->_limit = (int) $limit;
    }
    
    public function onAddStatement(Erfurt_Event $event)
    {
        $payloadId = $this->_execAddPayload($event->statement);
        $this->_execAddAction($event->graphUri, array_keys($event->statement)[0], self::STATEMENT_ADDED, $payloadId);
    }
    
    public function onAddMultipleStatements(Erfurt_Event $event)
    {
        $graphUri = $event->graphUri;
        
        $this->_execAddPayloadsAndActions($graphUri, self::STATEMENT_ADDED, $event->statements);
    }
    
    public function onDeleteMatchingStatements(Erfurt_Event $event)
    {
        $graphUri = $event->graphUri;
        
        if (isset($event->statements) {
            $this->execAddPayloadsAndActions($graphUri, self::STATEMENT_REMOVED, $event->statements);
        } else {
            // In this case, we have no payload. Just add a action without a payload (no rollback possible).
            $this->_execAddAction($graphUri, $event->resource, self::STATEMENT_REMOVED);
        }
    }
    
    public function onDeleteMultipleStatements(Erfurt_Event $event)
    {
        $graphUri = $event->graphUri;
        
        $this->execAddPayloadsAndActions($graphUri, self::STATEMENT_REMOVED, $event->statements);
    }
    
    public function rollbackAction($actionId) 
    {
        $app = Erfurt_App::getInstance();
        $store = $app->getStore();
        
        $actionsSql = 'SELECT action_type, payload_id FROM ef_versioning_actions WHERE action_id = ' . 
                       ((int)$action_id);
                       
        $result = $store->sqlQuery($actionsSql);
        
        if ((count($result) === 0) || ($result[0]['payload_id'] === null)) {
// TODO dedicated exception
            throw new Exception('No rollback possible');
        } else {
            $type = (int) $result[0]['action_type'];
            
            $payloadsSql = 'SELECT statements_hash FROM ef_versioning_payloads WHERE id = ' .
                           ((int)$result[0]['payload_id']);
                           
            $payloadResult = $store->sqlQuery($payloadsSql);
            
            if (count($payloadResult) !== 1) {
// TODO dedicated exception
                throw new Exception('No rollback possible');
            }
                
            $payload = unserialize($payloadResult[0]['statements_hash']);
            
            if ($type === self::STATEMENT_ADDED) {
                $store->deleteMultipleStatements($payload);
            } else if ($type === self::STATEMENT_REMOVED) {
                $store->addMultipleStatements($payload);
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
            // throw exception
        }
        
        $this->_currentAction = $actionSpec;
    }
    
    private function _execAddAction($graphUri, $resource, $actionType, $payloadId = null)
    {
        $app = Erfurt_App::getInstance();
        $store = $app->getStore();
        $user = $app->getAuth()->getIdentity();
        $userUri = $user['userUri'];
        
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
                       
        $store->sqlQuery($actionsSql);
    }
    
    private function _execAddPayload($payload)
    {
        $app = Erfurt_App::getInstance();
        $store = $app->getStore();
        
        $payloadsSql = 'INSERT INTO ef_versioning_payloads (statement_hash) VALUES (' .
                        serialize($payload) . ')';
                        
        $store->sqlQuery($payloadsSql);
        $payloadId = $store->lastInsertId();
        
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
}


