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
abstract class Erfurt_Sparql_Query2_ObjectHelper{
	protected $id;
	protected $parents = array();
	
	public function __construct(){
		$this->id = Erfurt_Sparql_Query2::getNextID();
	}
	
	public function newUser($parent){
		if(!in_array($parent, $this->parents))
			$this->parents[] = $parent;
		
		return $this;
	}
	
	public function remove(){
		foreach($this->parents as $parent){
			$parent->removeElement($this->getID());			
		}
		
		return $this;
	}
	
	public function getID(){
		return $this->id;
	}
	
	public function getParents(){
		return $this->parents;
	}	
}
abstract class Erfurt_Sparql_Query2_GroupHelper extends Erfurt_Sparql_Query2_ObjectHelper
{
	protected $elements;
	
	//abstract public function addElement($member); //not used because some use typehinting some do it internally
	
	public function getElement($i){
		return $this->elements[$i];
	}
	
	public function getElements(){
		return $this->elements;
	}
	
	abstract public function getVars();
	//abstract public function setElement($i, $member); //not used because some use typehinting some do it internally
	abstract public function setElements($elements);
	
	public function removeElement($id){
		$new = array();
		
		for($i=0;$i<count($this->elements); $i++){
			if($this->elements[$i]->getID() != $id){
				if(is_a($this->elements[$i], "Erfurt_Sparql_Query2_GroupHelper"))
					$this->elements[$i]->removeElement($id);
				$new[] = $this->elements[$i];
			}
		}
		
		$this->elements = $new;
	
		return $this; //for chaining
	}
	
	public function removeAllElements(){
		$this->elements = array();
		return $this; //for chaining
	}
} 
?>
