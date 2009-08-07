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
	
	public function addElement($member){
		if(!is_a($member, "Erfurt_Sparql_Query2_GroupGraphPattern") && !is_a($member, "Erfurt_Sparql_Query2_Triple") && !is_a($member, "Erfurt_Sparql_Query2_Filter")){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::addElement must be an instance of Erfurt_Sparql_Query2_GroupGraphPattern or Erfurt_Sparql_Query2_Triple or Erfurt_Sparql_Query2_Filter, instance of ".gettype($member)." given");
			return;
		}
		$this->elements[] = $member;
		return $this; //for chaining
	}
	
	public function getSparql(){
		$sparql = "{ \n";
		
		for($i=0; $i < count($this->elements); $i++){
			$sparql .= $this->elements[$i]->getSparql();
			if(isset($this->elements[$i+1]) && is_a($this->elements[$i+1], "Erfurt_Sparql_Query2_Triple")){
				$sparql .= " . "; //realisation of TriplesBlock
			} 
			$sparql .= " \n";
			
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
	
	public function setElement($i, $member){
		if(!is_a($member, "Erfurt_Sparql_Query2_GroupGraphPattern") && !is_a($member, "Erfurt_Sparql_Query2_Triple") && !is_a($member, "Erfurt_Sparql_Query2_Filter")){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElement must be an instance of Erfurt_Sparql_Query2_GroupGraphPattern or Erfurt_Sparql_Query2_Triple or Erfurt_Sparql_Query2_Filter, instance of ".gettype($member)." given");
			return;
		}
		$this->elements[$i] = $member;
		return $this; //for chaining
	}
	
	public function setElements($elements){
		foreach($elements as $element){
			if(!is_a($element, "Erfurt_Sparql_Query2_GroupGraphPattern") && !is_a($element, "Erfurt_Sparql_Query2_Triple") && !is_a($element, "Erfurt_Sparql_Query2_Filter")){
				throw new RuntimeException("In Erfurt_Sparql_Query2_GroupGraphPattern::setElements : the given array was not filled with objects from type \"Erfurt_Sparql_Query2_GroupGraphPattern\"");
				return $this; //for chaining
			}
		}
		$this->elements = $elements;
		return $this; //for chaining
	}
	
}
?>
