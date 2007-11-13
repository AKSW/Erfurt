<?php
/**
  * Defines an interface a store adapter must implement in order to provide
  * sparql capabilities.
  *
  * @package store
  * @author Norman Heino <norman.heino@googlemail.com>, Philipp Frischmuth <philipp@frischmuth24.de>
  * @version $Id$
  */
interface Erfurt_Store_SparqlInterface {	
	
	/**
	 *
	 * @param null/array/Erfurt_Rdf_Model $graphs
	 * @param
	 * @param
	 * @param
	 * @return
	 */
	public function executeSparql($model, $query, $class = null, $renderer = null);
}
?>
