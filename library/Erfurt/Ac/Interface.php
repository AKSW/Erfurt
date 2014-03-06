<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Interface defining methods to support basic model, action (and statement) based access control.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package Erfurt_Ac
 * @author Marvin Frommhold <frommhold@informatik.uni-leipzig.de>
 * @author Sebastian Nuck <nuck@infai.org>
 */
interface Erfurt_Ac_Interface
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
    public function getActionConfig($actionSpec);

    /**
     * Checks whether the given action is allowed for the current user on the
     * given model uri.
     *
     * @param string $type Name of the access-type (view, edit).
     * @param string $modelUri The uri of the graph to check.
     * @return boolean Returns whether allowed or denied.
     */
    public function isModelAllowed($type, $modelUri);

    /**
     * Checks whether the given action is allowed for the current user on the
     * given model uri.
     *
     * @param string $type Name of the access-type (view, edit).
     * @param array $modelUris The array of uris of the graphs to check.
     * @return array Returns array with boolean values of whether allowed or denied.
     */
    public function areModelsAllowed($type, $modelUris);

    /**
     * Checks whether the given action is allowed for the current user.
     *
     * @param string $action The name of the action.
     * @return boolean Returns whether action is allowed or not.
     */
    public function isActionAllowed($action);

    /**
     * Adds a right to a model for the current user.
     *
     * @param string $modelUri The URI of the model.
     * @param string $type Type of access: view or edit.
     * @param string $perm Type of permission: grant or deny.
     * @throws Erfurt_Exception Throws an exception if wrong type was submitted or
     * wrong perm type was submitted.
     */
    public function setUserModelRight($modelUri, $type = 'view', $perm = 'grant');
}