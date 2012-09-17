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

require_once 'antlr/Php/antlr.php';

class Erfurt_Sparql_Parser_Sparql10 implements Erfurt_Sparql_Parser_Interface
{
	public static function initFromString($queryString, $parsePartial = null){
		$retval=null;
		$input = new Erfurt_Sparql_Parser_Util_CaseInsensitiveStream($queryString);
		$lexer = new Erfurt_Sparql_Parser_Sparql10_Sparql10Lexer($input);
//		if (!count($lexer->getErrors())) {
			$tokens = new CommonTokenStream($lexer);
			$parser = new Erfurt_Sparql_Parser_Sparql10_Sparql10Parser($tokens);
			if($parsePartial != null && is_string($parsePartial) && method_exists($parser, $parsePartial)){
                            $retval =  call_user_func( array( $parser, $parsePartial ) );
                        } else {
                            $retval =  $parser->parse();
                        }
//		}
		return array('retval' =>$retval, 'errors'=>
			//array_merge($lexer->getErrors(), 
			//$parser?
			$parser->getErrors()
			//:array())
			);
	}
	
}
