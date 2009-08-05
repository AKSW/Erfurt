<?php
/**
 * Erfurt_Sparql Query - TriplesBlock
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_TriplesBlock
{
	protected $triples = array();
	
	public function addTriple(Erfurt_Sparql_Query2_Triple $triple) {
		$this->triples[] = $triple;
	}
	
	public function getSparql(){
		$sparql = "";
		
		foreach($this->triples as $triple)
			$sparql .= $triple->getSparql()." . \n";
		
		return $sparql;
	}
	
	public function getVars(){
		$vars = array();
		
		foreach($this->triples as $triple){
			$vars = array_merge($vars, $triple->getVars());
		}
		
		return $vars;
	}
}
?>
