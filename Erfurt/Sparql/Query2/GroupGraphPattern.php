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
class Erfurt_Sparql_Query2_GroupGraphPattern extends Erfurt_Sparql_Query2_GroupHelper
{
	public function addElement($member){
		if(!($member instanceof Erfurt_Sparql_Query2_GroupGraphPattern) && !($member instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject) && !($member instanceof Erfurt_Sparql_Query2_Filter)){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::addElement must be an instance of Erfurt_Sparql_Query2_GroupGraphPattern or Erfurt_Sparql_Query2_Triple or Erfurt_Sparql_Query2_Filter, instance of ".typeHelper($member)." given");
			return;
		}
		$this->elements[] = $member;
		$member->newUser($this);
		return $this; //for chaining
	}
	
	public function getElement($i){
		return $this->elements[$i];
	}
	
	public function getElements(){
		return $this->elements;
	}
	
	public function getSparql(){
		//sort filters to the end
		$filters = array();
		$new = array();
		for($i=0; $i < count($this->elements); $i++){
			if($this->elements[$i] instanceof Erfurt_Sparql_Query2_Filter){
				$filters[] = $this->elements[$i];
			} else {
				$new[] = $this->elements[$i];
			}
		}
		for($i=0; $i < count($filters); $i++){
			$new[] = $filters[$i];
		}
		$this->elements = $new;
		
		//build sparql-string
		$sparql = "{ \n";
		for($i=0; $i < count($this->elements); $i++){
			 $sparql .= $this->elements[$i]->getSparql();
			if($this->elements[$i] instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject && isset($this->elements[$i+1]) && $this->elements[$i+1] instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject){
				$sparql .= " ."; //realisation of TriplesBlock
			} 
			$sparql .= " \n";
		}
		
		
		return $sparql."} \n";
	}
	
	public function getVars(){
		$vars = array();
		
		foreach($this->elements as $element){
			$new = $element->getVars();
			$vars = array_merge($vars, $new);
		}
		
		return $vars;
	}
	
	
	public function setElement($i, $member){
		if(!($member instanceof Erfurt_Sparql_Query2_GroupGraphPattern) && !($member instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject) && !($member instanceof Erfurt_Sparql_Query2_Filter)){
			throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElement must be an instance of Erfurt_Sparql_Query2_GroupGraphPattern or Erfurt_Sparql_Query2_IF_TriplesSameSubject or Erfurt_Sparql_Query2_Filter, instance of ".typeHelper($member)." given");
		}
		if(!is_int($i)){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElement must be an instance of integer, instance of ".typeHelper($i)." given");
		}
		$this->elements[$i] = $member;
		return $this; //for chaining
	}
	
	public function setElements($elements){
		if(!is_array($elements)){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElements : must be an array");
		}
		
		foreach($elements as $element){
			if(!($element instanceof Erfurt_Sparql_Query2_GroupGraphPattern) && !($element instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject) && !($element instanceof Erfurt_Sparql_Query2_Filter)){
				throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElements : must be an array of instances of Erfurt_Sparql_Query2_GroupGraphPattern or Erfurt_Sparql_Query2_IF_TriplesSameSubject or Erfurt_Sparql_Query2_Filter");
				return $this; //for chaining
			}
		}
		$this->elements = $elements;
		return $this; //for chaining
	}
	
	public function addElements($elements){
		if(!is_array($elements)){
			throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElements : must be an array");
		}
		
		foreach($elements as $element){
			if(!($element instanceof Erfurt_Sparql_Query2_GroupGraphPattern) && !($element instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject) && !($element instanceof Erfurt_Sparql_Query2_Filter)){
				throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GroupGraphPattern::setElements : must be an array of instances of Erfurt_Sparql_Query2_GroupGraphPattern or Erfurt_Sparql_Query2_IF_TriplesSameSubject or Erfurt_Sparql_Query2_Filter");
				return $this; //for chaining
			}
		}
		$this->elements = array_merge($this->elements, $elements);
		return $this; //for chaining
	}
	
	/**
	 * little demo of optimization: 
	 * - delete duplicates
	 */
	public function optimize(){
		//delete duplicates
		$to_remove = array();
		for($i=0; $i<count($this->elements); $i++){
			for($j=0; $j<count($this->elements); $j++){
				if($i!=$j){
					//compare
					if($this->elements[$i] == $this->elements[$j]){
						//identical same object
						$to_remove[] = $this->elements[$i];
						
						//cant delete one without deleting both - need to copy first 
						if($this->elements[$j] instanceof Erfurt_Sparql_Query2_GroupHelper){
							$copy = $this->elements[$j];
							$classname = get_class($this->elements[$j]);
							$this->elements[$j] = new $classname;
							$this->elements[$j]->setElements($copy->getElements());
						} else if($this->elements[$j] instanceof Erfurt_Sparql_Query2_Triple){
							$this->elements[$j] = new Erfurt_Sparql_Query2_Triple($this->elements[$j]->getS(),$this->elements[$j]->getP(),$this->elements[$j]->getO());
						} else if($this->elements[$j] instanceof Erfurt_Sparql_Query2_TriplesSameSubject){
							$this->elements[$j] = new Erfurt_Sparql_Query2_TriplesSameSubject($this->elements[$j]->getSubject(),$this->elements[$j]->getPropList());
						}
						continue;
						//TODO cover all cases - cant be generic?!
					} else if($this->elements[$i]->equals($this->elements[$j]) && $this->elements[$i] != $this->elements[$j]){
						if(!in_array($this->elements[$j], $to_remove)) //if the j of this i-j-pair is already marked for deletion skip i
							$to_remove[] = $this->elements[$i];
					}
				}
			}
		}
		foreach($to_remove as $obj){
			$obj->remove();
		}
		
		//optimization is done on this level - proceed on deeper level
		foreach($this->elements as $element){
			if($element instanceof Erfurt_Sparql_Query2_GroupGraphPattern){
				$element->optimize();
			}
		}
		
		return $this;
	}
}
?>
