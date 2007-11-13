<?php

/**
  * Defines an interface a store adapter must implement in order to provide
  * sparql capabilities.
  *
  * @author Norman Heino <norman.heino@googlemail.com>
  * @version $Id$
  */
interface Erfurt_Sparql_QueryInterface {
	
	/**
	  * Executes a sparql query and returns results as a
	  * database independent array.
	  *
	  * @param $model The model to be queried
	  * @param $query The query
	  * @return array An array of result rows, which are in turn arrays 
	  *         of column values
	  */
	public function executeSparql($model, $query);
	
	/**
	  * Executes a sparql ask query.
	  *
	  * @param $model
	  * @param $query
	  * @return boolean
	  */
	public function askSparql($model, $query);
}

?>
