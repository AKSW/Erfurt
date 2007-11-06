<?php
interface Erfurt_Store_SparulInterface {
	
	/**
	 * Executes a SPARQL/Update (SPARUL) query.
	 *
	 * @param string $sparul
	 */
	public function executeSparul($sparul);
}
?>
