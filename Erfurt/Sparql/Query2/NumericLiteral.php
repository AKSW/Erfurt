<?php
/**
 * OntoWiki
 * 
 * @package    
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_NumericLiteral implements Erfurt_Sparql_Query2_GraphTerm
{
	protected $value;
	
	public function __construct ($num){
		if(is_numeric($num)){
			$this->value = $num;
		} else {
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_NumericLiteral::__construct must be numeric, instance of ".gettype($num)." given");
		}
	}
	
	public function getSparql(){
		return (string) $this->value;
	}
}
?>
