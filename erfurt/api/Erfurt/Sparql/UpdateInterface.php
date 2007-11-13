<?php

/**
  * Defines an interface a store adapter must implement in order to provide
  * sparul capabilities.
  *
  * @author Norman Heino <norman.heino@googlemail.com>
  * @version $Id$
  */
interface Erfurt_Sparql_UpdateInterface {
	
	/**
	  * Executes a sparul query and updates the model accordingly
	  * if permissions for the action are granted.
	  *
	  * @param $model The model to be queried
	  * @param $query The sparul query
	  */
	public function updateSparql($model, $query);
}

?>
