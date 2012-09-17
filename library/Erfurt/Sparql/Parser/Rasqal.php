<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2010, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @category Erfurt
 * @package Sparql_Parser_Sparql
 * @author Rolland Brunec <rollxx@gmail.com>
 * @copyright Copyright (c) 2010 {@link http://aksw.org aksw}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_Sparql_Parser_Rasqal_Rasqal implements Erfurt_Sparql_Parser_Interface
{
	/**
	 * 
	 */
	protected $_fallback = 'sparql10';
	
	protected $_toString = 'toString';
	
	private $_parserName = null;
	
	private $_lexerName = null;
	
	function __construct($parserOptions=array())
	{
	}
		
	public function initFromString($queryString, $parserOptions = array()){
	}
}


}