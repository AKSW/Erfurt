<?php
/**
 * This interface contains methods, that have to be implemented by any backend, that implements this interface.
 *
 * @package store
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id$
 */
interface Erfurt_Store_SqlInterface {
	
	/**
	 * This method takes a sql-query and queries a sql-capable backend.
	 *
	 * @param string $sql A string containing the sql-query, that should be executed.
	 * @return array Returns an array containing the result of the query.
	 */
	public function sqlQuery($sql);
}
?>
