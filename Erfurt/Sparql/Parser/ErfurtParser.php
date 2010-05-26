<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @category Erfurt
 * @package Sparql_Parser_Sparql
 * @author Rolland Brunec <rollxx@gmail.com>
 * @copyright Copyright (c) 2010 {@link http://aksw.org aksw}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Sparql/Parser.php';

class Erfurt_Sparql_Parser_ErfurtParser implements Erfurt_Sparql_Parser_Interface
{
		
	function __construct($parserOptions=array())
	{
		// TODO pass options?
	}

	public static function initFromString($queryString, $parserOptions = array()){
		require_once 'Erfurt/Sparql/ParserException.php';
		$retval=null;
		$errors=null;
		$parser = new Erfurt_Sparql_Parser($queryString);
		try {
			$retval = $parser->parse();
		} catch (Erfurt_Sparql_ParserException $e) {
			$errors = $e->__toString();
		}
		return array('retval' =>$retval, 'errors'=>$errors);
	}
	
}
