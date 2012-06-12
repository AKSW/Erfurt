<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
 
require_once 'Erfurt/Ac.php';

/**
 * A class providing support for access control.
 * 
 * This class provides support for model, action (and statement) based access control.
 * The access control informations are stored in a triple store.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package Erfurt_Ac
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Ac_Test extends Erfurt_Ac
{
    protected $_allowedModelsEdit = array();
    protected $_allowedModelsView = array();
    protected $_allowedActions = array();
    
    /**
     * Delivers the action configuration for a given action
     * 
     * @param string $actionSpec The URI of the action.
     * @return array Returns an array with the action spec.
     */
    public function getActionConfig($action, $isUri = true)
    {   
        return array();
    }
    
    /**
     * Checks whether the given action is allowed for the current user on the
     * given model uri.
     *
     * @param string $type Name of the access-type (view, edit).
     * @param string $modelUri The uri of the graph to check.
     * @return boolean Returns whether allowed or denied.
     */
    public function isModelAllowed($type, $modelUri) 
    {
        $modelUri = (string)$modelUri;
        
        if ($type === 'edit') {
            return isset($this->_allowedModelsEdit[$modelUri]);
        } else if ($type === 'view') {
            return isset($this->_allowedModelsView[$modelUri]);
        }
        
        return false;
    }
    
    /**
     * Checks whether the given action is allowed for the current user.
     *
     * @param string $action The name of the action.
     * @return boolean Returns whether action is allowed or not.
     */
    public function isActionAllowed($action, $isUri = true)
    {
        return in_array($action, $this->_allowedActions);
    }
    
    /**
     * Checks whether any action is allowed for the current user.
     *
     * @return boolean Returns whether an action is allowed or not.
     */
    public function isAnyActionAllowed() 
    {   
        return true;
    }
    
    /**
     * Checks whether the current user has the given permission 
     * for any models. 
     *
     * @param string $type (optional) Contains view or edit.
     * @return boolean Returns whether allowed or denied.
     */
    public function isAnyModelAllowed($type = Erfurt_Ac::ACCESS_TYPE_VIEW)
    {
        return true;
    }
        
    /**
     * Adds a right to a model for the current user.
     * 
     * @param string $modelUri The URI of the model. 
     * @param string $type Type of access: view or edit.
     * @param string $perm Type of permission: grant or deny.
     * @throws Erfurt_Exception Throws an exception if wrong type was submitted or
     * wrong perm type was submitted.
     */
    public function addUserModelRule($modelUri, $type = Erfurt_Ac::ACCESS_TYPE_VIEW, $perm = Erfurt_Ac::ACCESS_PERM_GRANT) 
    {
        if ($type === 'view') {
            if ($perm === 'grant') {
                $this->_allowedModelsView[$modelUri] = true;
            } else {
                unset($this->_allowedModelsView[$modelUri]);
            }
        } else if ($type === 'edit') {
            if ($perm === 'grant') {
                $this->_allowedModelsEdit[$modelUri] = true;
            } else {
                unset($this->_allowedModelsEdit[$modelUri]);
            }
        }
    }
    
    /* Helper Methods */
    
    public function setAllowedActions(array $allowedActions = array())
    {
        $this->_allowedActions = $allowedActions;
    }
}
