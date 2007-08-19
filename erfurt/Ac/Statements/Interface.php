<?php
interface Erfurt_Ac_Statements_Interface {
	
	public function checkAccessPossibility ();
	
	
	/**
	 * checks the necessity of the statement based ac from the given rules
	 */
	public function checkAccessRestriction ();
	
	public function performViewRestriction();
	public function performEditRestriction();
	public function dropSbac();
	public  function _getRuleDetails($selectors);
}