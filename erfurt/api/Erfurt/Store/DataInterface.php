<?php
/**
 * This interface provides methods, that a store, that represents a data store (or triple store) has to implement.
 *
 * @package store
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id$
 */
interface Erfurt_Store_DataInterface {
	
	public function countAvailableModels();
	public function deleteModel($modelURI);
	public function executeAdd();
	public function executeFind();
	public function executeRemove();
	public function getModel($modelURI);
	public function getNewModel($modelURI,$baseURI=NULL);
	public function listModels();
	public function loadModel($modelURI,$file=NULL,$loadImports=false,$stream=false,$filetype=NULL);
	
// TODO doc
	/**
	 * Check if the DbModel with the given modelURI is already stored in the database
	 *
	 * @param   string   $modelURI
	 * @param   boolean  useACL for installation check
	 * @return  boolean
	 * @throws	SqlError
	 * @access	public
	 */
	public function modelExists($modelURI);
	
	
	
	
}
?>
