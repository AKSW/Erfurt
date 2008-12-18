<?php 

/*
 * database tables:
 * CREATE TABLE ef_versioning_actions(
 *   id             INT NOT NULL, 
 *   model          VARCHAR(255) NOT NULL, 
 *   user           VARCHAR(255) NOT NULL, 
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
    const MODEL_IMPORTED    = 10;
    const STATEMENT_ADDED   = 20;
    const STATEMENT_CHANGED = 21;
    const STATEMENT_REMOVED = 22;
    
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
    public function getLastModifiedForResource($resourceUri)
    {
    }
    
    public function getHistoryForModel($modelUri, $page = 1)
    {
    }
    
    public function getHistoryForResource($resourceUri, $page = 1)
    {
    }
    
    public function getHistoryForUser($userUri, $page = 1)
    {
    }
    
    public function setLimit($limit)
    {
        $this->_limit = (int) $limit;
    }
    
    public function onStatementAdded(Erfurt_Event $event)
    {
    }
    
    public function onStatementRemoved(Erfurt_Event $event)
    {
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

}


