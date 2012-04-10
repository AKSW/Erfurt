<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id: Default.php 4316 2009-10-16 19:56:50Z c.riess.dev $
 */

/**
 * A class providing support for disabled access control.
 *
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package erfurt
 * @subpackage ac
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Ac_None
{
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Delivers the action configuration for a given action
     * 
     * @param string $actionSpec The URI of the action.
     * @return array Returns an array with the action spec.
     */
    public function getActionConfig($actionSpec)
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
        $type = strtolower($type);
        if ($type !== 'view') {
            return false;
        }
        
        return true;
    }
    
    /**
     * Checks whether the given action is allowed for the current user.
     *
     * @param string $action The name of the action.
     * @return boolean Returns whether action is allowed or not.
     */
    public function isActionAllowed($action) 
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
    public function setUserModelRight($modelUri, $type = 'view', $perm = 'grant') 
    {    
        // Nothing to do here...
    }
}
