<?php
/**
 * This interface provides some method definitions, that must be implemented by any store, that is used by an erfurt
 * application.
 *
 * @package store
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id$
 */
interface Erfurt_Store_MainInterface extends Erfurt_Store_DataInterface {
		
	/**
	 * Check if the DbModel with the given modelURI is already stored in the database
	 *
	 * @param   string   View || Edit || ??
	 * @param   mixed		Model-Object || URI-String
	 * @param   string 	Property
	 * @return  boolean
	 * @access	public
	 */
	public function aclCheck($accessType,$model='',$property='',$class='',$instance='');
	
// TODO delete?
	public function aclCompute($user,$accessType,$model,$property='',$class='',$instance='');
	
// TODO delete?
	public function aclGet($user,$accessType,$model='',$property='',$class='',$instance='');	
	
	/**
	 * Checks whether the ac-object is set or not.
	 * 
	 * @return boolean Returns true iff ac-object is set, else false.
	 */
	public function checkAc();
	
	/**
	 * Get the ac-object instance.
	 * 
	 * @return Erfurt_Ac_Default/Erfurt_Ac_Statements_Abstract Returns an instance of an ac-class.
	 */
	public function getAc();
	
	/**
	 * Initializes the store.
	 */
	public function init();
	
	/**
	 * This method checks whether the backend is initialized and ready to use.
	 * 
	 * @return boolean Returns true iff the store is initiaized and ready to use, else false.
	 */
	public function isSetup();
	
	/**
	 * This method sets the ac-object for the store.
	 * 
	 * @param Erfurt_Ac_Default/Erfurt_Ac_Statements_Abstract An instance of an ac-class.
	 */
	public function setAc($acObj = null);
}
?>
