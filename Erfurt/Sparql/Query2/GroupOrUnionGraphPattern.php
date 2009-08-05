<?php
/**
 * Erfurt_Sparql Query - GroupOrUnionGraphPattern.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_GroupOrUnionGraphPattern extends Erfurt_Sparql_Query2_GroupGraphPattern
{
	protected $elements = array();
	
	public function getSparql(){
		$sparql = "";
		
		for($i = 0; $i < count($this->elements); $i++){
			$sparql .= $this->elements[$i]->getSparql();
			if($i < (count($this->elements)-1)){
				$sparql .= " UNION ";
			}
		}
		
		return $sparql;
	}
	
	public function addElement(Erfurt_Sparql_Query2_GroupGraphPattern $element){
		$this->elements[] = $element;
	}
}
?>
