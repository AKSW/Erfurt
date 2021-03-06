<?php

/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2009-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @category Erfurt
 * @package Sparql_Parser_Sparql
 * @author Rolland Brunec <rollxx@gmail.com>
 * @copyright Copyright (c) 2010 {@link http://aksw.org aksw}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


class Erfurt_Sparql_Parser_Sparql11query implements Erfurt_Sparql_Parser_Interface
{
		
	function __construct($parserOptions=array())
	{
	}
		
	public static function initFromString($queryString, $parserOptions = array()){
		
		$input = new Erfurt_Sparql_Parser_Util_CaseInsensitiveStream($queryString);
		$lexer = new Erfurt_Sparql_Parser_Sparql11_QueryLexer($input);
		$tokens = new CommonTokenStream($lexer);
		$parser = new Erfurt_Sparql_Parser_Sparql11_QueryParser($tokens);
		$retval =  $parser->parse();
		return array('retval' =>$retval, 'errors'=>array_merge($lexer->getErrors(), $parser->getErrors()));
	}
	
}
