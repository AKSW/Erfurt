<?php
/**
 * Erfurt_Sparql Query - GroupGraphPattern.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_GroupGraphPattern
{
	protected $elements = Array();
	
	public function addMember($member){
		if(!is_a($member, "Erfurt_Sparql_Query2_GroupGraphPattern") && !is_a($member, "Erfurt_Sparql_Query2_TriplesBlock")){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::addMember must be an instance of Erfurt_Sparql_Query2_GroupGraphPattern or Erfurt_Sparql_Query2_TriplesBlock, instance of ".gettype($member)." given");
			return;
		}
		$this->elements[] = $member;
	}
	
	public function getSparql(){
		$sparql = "{ \n";
		
		foreach($this->elements as $element){
			$sparql .= $element->getSparql();
		}
		
		return $sparql."} \n";
	}
	
	public function getVars(){
		$vars = array();
		
		foreach($this->elements as $element){
			$vars = array_merge($vars, $element->getVars());
		}
		
		return $vars;
	}
	
	public function getElement($i){
		return $this->elements[$i];
	}
	
	public function getElements(){
		return $this->elements;
	}
	
	public function setElement($i, Erfurt_Sparql_Query2_GroupGraphPattern $element){
		$this->elements[$i] = $element;
	}
	
	public function setElements($elements){
		foreach($elements as $element){
			if(!is_a($element, "Erfurt_Sparql_Query2_GroupGraphPattern")){
				throw new RuntimeException("In Erfurt_Sparql_Query2_GroupGraphPattern::setElements : the given array was not filled with objects from type \"Erfurt_Sparql_Query2_GroupGraphPattern\"");
				return;
			}
		}
		$this->elements = $elements;
	}
	
	public $filters = array();
	
	public function addFilters(array $filters){
		foreach($filters as $filter){
			addFilter($filter);
		}
	}
	
	public function addFilter(Erfurt_Sparql_Query2_Filter $filter){
		$filters[]=$filter;
	}
}
?>
