<?php
require_once 'Erfurt/Exception.php';

/**
 * A SPARQL Parser Execption for better errorhandling.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package erfurt
 * @subpackage sparql
 * @author Tobias Gauss <tobias.gauss@web.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id$
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
}
