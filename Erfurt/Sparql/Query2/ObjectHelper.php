<?php
/**
 * OntoWiki Sparql Query ObjectHelper
 * 
 * a abstract helper class for objects that are elements of groups. i.e.: Triples but also GroupGraphPatterns
 * 
 * @package    
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 * @abstract
 */
abstract class Erfurt_Sparql_Query2_ObjectHelper{
	protected $id;
	protected $parents = array();
	
	public function __construct(){
		$this->id = Erfurt_Sparql_Query2::getNextID();
	}
	
	//abstract public function getSparql();
	
	/**
	 * addParent
	 * when a ObjectHelper-object is added to a GroupHelper-object this method is called. lets the child know of the new parent
	 * @param Erfurt_Sparql_Query2_GroupHelper $parent
	 * @return Erfurt_Sparql_Query2_ObjectHelper $this
	 */
	public function addParent(Erfurt_Sparql_Query2_GroupHelper $parent){
		if(!in_array($parent, $this->parents))
			$this->parents[] = $parent;
		
		return $this;
	}
	
	/**
	 * remove
	 * removes this object from all parents
	 * @return Erfurt_Sparql_Query2_ObjectHelper $this
	 */
	public function remove(){
		foreach($this->parents as $parent){
			$parent->removeElement($this);			
		}
		
		return $this;
	}
	
	/**
	 * removeParent
	 * removes a parent
	 * @param Erfurt_Sparql_Query2_GroupHelper $parent
	 * @return Erfurt_Sparql_Query2_ObjectHelper $this
	 */
	public function removeParent(Erfurt_Sparql_Query2_GroupHelper $parent){
		$new = array();
		foreach($this->parents as $compare){
			if($compare != $parent){
				$new[] = $compare;
			}		
		}
		
		$this->parents = $new;
		
		return $this;
	}
	
	/**
	 * getID
	 * @return int the id of this object
	 */
	public function getID(){
		return $this->id;
	}
	
	/**
	 * getParents
	 * @return array an array of Erfurt_Sparql_Query2_GroupHelper
	 */
	public function getParents(){
		return $this->parents;
	}
	
	/**
	 * equals
	 * @param mixed $obj the object to compare with
	 * @return bool true if equal, false otherwise
	 */
	public function equals($obj){
		//trivial cases
		if($this===$obj) return true;
		
		if(get_class($this) !== get_class($obj)){
			return false; 
		}
		
		return $this->getSparql() === $obj->getSparql();
	}	
}

/**
 * Erfurt_Sparql_Query2_GroupHelper
 */
abstract class Erfurt_Sparql_Query2_GroupHelper extends Erfurt_Sparql_Query2_ObjectHelper
{
	protected $elements = array();
	
	public function __construct(){
    	parent::__construct();
    }
    
	
	//abstract public function addElement($member); //not used because some use typehinting some do it internally for multiple types
	
	/**
	 * getElement
	 * @param int $i index of the element
	 * @return Erfurt_Sparql_Query2_ObjectHelper the element
	 */
	public function getElement($i){
		return $this->elements[$i];
	}
	
	/**
	 * getElements
	 * @return array array of Erfurt_Sparql_Query2_ObjectHelper - the elements that are contained
	 */
	public function getElements(){
		return $this->elements;
	}
	
	abstract public function getVars();
	//abstract public function setElement($i, $member); //not used because some use typehinting some do it internally
	abstract public function setElements($elements);
	
	/**
	 * removeElement
	 * @param int $i index of the element
	 * @return Erfurt_Sparql_Query2_GroupHelper $this
	 */
	public function removeElement($element, $equal = false){
		$new = array();
		
		for($i=0;$i<count($this->elements); $i++){
			if($this->elements[$i]->getID() != $element->getID() || ($equal && $this->elements[$i]->equals($element))){
				if($this->elements[$i] instanceof Erfurt_Sparql_Query2_GroupHelper)
					$this->elements[$i]->removeElement($element);
				$new[] = $this->elements[$i];
			}
		}
		$element->removeParent($this);
		$this->elements = $new;
	
		return $this; //for chaining
	}

	/**
	 * removeAllElements
	 * @return Erfurt_Sparql_Query2_GroupHelper $this
	 */
	public function removeAllElements(){
		$this->elements = array();
		return $this; //for chaining
	}
	
	/**
	 * equals
	 * checks for mutual inclusion
	 * @param mixed $obj the object to compare with
	 * @return bool true if equal, false otherwise
	 */
	public function equals($obj){
		//trivial cases
		if($this===$obj) return true;
		
		if(get_class($this) !== get_class($obj)){
			return false; 
		}

			//check for mutual inclusion
			foreach($obj->getElements() as $his){
				$found = false;
				
				foreach($this->elements as $mine){
					if($mine->equals($his)){
						$found = true;
					}
				}
				
				if(!$found) return false;
			}
			
			foreach($this->elements as $mine){
				$found = false;
				
				foreach($obj->getElements() as $his){
					if($his->equals($mine)){
						$found = true;
					}
				}
				
				if(!$found) return false;
			}
			
			return true;
	}	
} 
?>
