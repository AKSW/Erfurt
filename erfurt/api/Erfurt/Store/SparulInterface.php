<?php
/**
  * Defines an interface a store adapter must implement in order to provide
  * sparul capabilities.
  *
  * @author Norman Heino <norman.heino@googlemail.com>, Philipp Frischmuth <philipp@frischmuth24.de>
  * @version $Id$
  * @package store
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
