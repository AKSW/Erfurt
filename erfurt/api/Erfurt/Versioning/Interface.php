<?php

/**
  * Defines an interface a store adapter must imlement in order to provide
  * versioning capabilities.
  *
  * @package versioning
  * @author Norman Heino <norman.heino@googlemail.com>
  * @version $Id$
  */
interface Erfurt_Versioning_Interface {
	
	/**
	  * The constructor ties the versioning module to a model on which it operates.
	  *
	  * @param string $model A model URI
	  */
	public function __construct(Erfurt_Rdfs_Model_Abstract $model);
	
	/**
	  * Returns an array of versioning entries.
	  * The entries returned can be specified by the $filter parameter which
	  * takes an array of key/value pairs.
	  * The following keys are possible:
	  * <ul>
	  *   <li>date &ndash; a date string</li>
	  *   <li>model &ndash; a model URI</li>
	  *   <li>user &ndash; a user URI</li>
	  *   <li>resource &ndash; a resource URI</li>
	  * </ul>
	  *
	  * @param array $filter An array key/value pairs
	  * @param int   $offset The first line to be returned
	  * @param int   $limit  The maximum number of reults to be returned
	  * @param int   $erg    The total number of results found
	  */
	public function listEntries(array $filter = array(), $offset = 0, $limit = 0, &$erg = 0);
	
	/**
	  * Renders a table of version information for a certain action.
	  *
	  * @param $id            The action identifier of the action to be rendered
	  * @param $description   A textual description for the action
	  * @param $subject       The subject of the statement
	  * @param $details       Action details
	  * @param $mayRolledBack Needs to be set to <code>true</true> if the action is allowed to be rolled back
	  */
	public function renderAction($actionId, $description, $subject, $details, &$mayRolledBack);
	
	/**
	  * Undos the selected action, restoring the state before its execution.
	  *
	  * @param $actionId the action identifier if the action to be rolled back
	  */
	public function rollback($actionId);
	
	/**
	  * Undos multiple actions at once.
	  *
	  * @param array $actionIds An array of action identifiers.
	  */
	public function multipleRollback(array $actionIds);
}

?>