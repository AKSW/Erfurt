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
	 * This method initializes the database with the required tables.
	 */
	public function createTables();
	
	/**
	 * This method checks whether a database with the fiven name exists.
	 *
	 * @param string $dbType type of the database (e.g. MySQL)
	 * @param string $dbName name of the database
	 * @return boolean Returns true in case the database exists, false else.
	 */
	public function isDatabaseCreated($dbType = "MySQL", $dbName);
	
	/**
	 * This method takes a sql-query and queries a sql-capable backend.
	 *
	 * @param string $sql A string containing the sql-query, that should be executed.
	 * @return array Returns an array containing the result of the query.
	 */
	public function sqlQuery($sql);
}
?>
