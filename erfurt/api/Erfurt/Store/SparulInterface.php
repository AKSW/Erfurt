<?php
/**
  * Defines an interface a store adapter must implement in order to provide
  * sparul capabilities.
  *
  * @package store
  * @author Norman Heino <norman.heino@googlemail.com>
  * @author Philipp Frischmuth <philipp@frischmuth24.de>
  * @version $Id$
  */
interface Erfurt_Store_SparulInterface {
	
	/**
	 * Executes a SPARQL/Update (SPARUL) query.
	 *
	 * @param string $sparul
	 */
	public function executeSparul($sparul);
}
?>
