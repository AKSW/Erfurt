<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @category Erfurt
 * @package Erfurt_Sparql_Parser
 * @author Rolland Brunec <rollxx@gmail.com>
 * @copyright Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_Parser_Rasqal implements Erfurt_Sparql_Parser_Interface
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
