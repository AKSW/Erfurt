<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2010, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @category Erfurt
 * @package Sparql_Parser
 * @author Rolland Brunec <rollxx@gmail.com>
 * @copyright Copyright (c) 2010 {@link http://aksw.org aksw}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Sparql_Parser_Interface
{
	
	/**
	 * @param string $queryString
	 * @param array $parserOptions
	 * @throws Parser Exception, if there was a poblem parsing the query 
	 * @return Returns Erfurt_Sparql_Query2 object
	 */
	public static function initFromString($queryString, $parserOptions = array());
	
}