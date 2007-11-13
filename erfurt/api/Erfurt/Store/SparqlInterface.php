<?php
/**
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
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
