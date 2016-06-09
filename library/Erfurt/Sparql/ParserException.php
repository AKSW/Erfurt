<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */



/**
 * A SPARQL Parser Execption for better errorhandling.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package Erfurt_Sparql
 * @author Tobias Gauss <tobias.gauss@web.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */
class Erfurt_Sparql_ParserException extends Erfurt_Exception 
{ 
	protected $_tokenPointer;

	public function __construct($message, $code = -1, $pointer = -1)
	{
		$this->_tokenPointer = $pointer;
		parent::__construct($message, $code);
	}

	/**
	 * Returns a pointer to the token which caused the exception.
	 *
	 * @return int
	 */
	public function getPointer()
	{
		return $this->tokenPointer;
	}
	
	function display($pre = true) {
		if ($pre) print '<pre>';  
		echo "Erfurt_Sparql_ParserException: code $this->code ($this->message) " .
			"in line $this->line of $this->file\n";
		echo $this->getTraceAsString(), "\n";
		echo "at token: ".$this->tokenPointer;
		if ($pre) print '</pre>';
	}

    public function __toString()
    {
        return $this->display(false);
    }
}
