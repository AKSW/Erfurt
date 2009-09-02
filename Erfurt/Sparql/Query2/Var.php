<?php
/**
 * Erfurt_Sparql Query - Var.
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_Var extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_VarOrIriRef, Erfurt_Sparql_Query2_VarOrTerm, Erfurt_Sparql_Query2_PrimaryExpression
{
	protected $name;
	protected $varLabelType = "?";
	
	public function __construct($nname){
		if(is_string($nname) && $nname != ""){
			$this->name = $nname;
		} else if($nname instanceof Erfurt_Sparql_Query2_IriRef){
			$this->name = $this->extractName($nname->getIri());
		} else {
			throw new RuntimeException("wrong parameter for constructing Erfurt_Sparql_Query2_Var. string (not empty) or Erfurt_Sparql_Query2_IriRef expected. ".typeHelper($nname)." found.");
		}
		parent::__construct();
	}
	
	public function getSparql(){
		return $this->varLabelType.$this->name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($nname){
		$this->name = $nname;
		return $this; //for chaining
	}
	
	public function setVarLabelType($ntype){
		if($ntype == "?" || $ntype == "$"){
			$this->varLabelType = $ntype;
		} else {
			throw new RuntimeException("wrong parameter for Erfurt_Sparql_Query2_Var::setVarLabelType . $ or ? expected. "+$ntype+" found.");
		}
		return $this; //for chaining
	}
	
	public function getVarLabelType($ntype){
		return $this->varLabelType;
	}
	
	public function toggleVarLabelType(){
		$this->varLabelType = $this->varLabelType == "?" ? "$" : "?";
		return $this; //for chaining
	}
	
	protected function extractName($name){
		$parts = preg_split("/[\/#]/", $name);
		return $parts[count($parts)-1];
	}
	
	
	public function __toString(){
		return $this->getSparql();
	}
	
	/*
	public function equals($obj){
		if(get_class($this) != get_class($obj)){
			return false; //trivial case
		}
		
		return ($this->name == $obj->getName() && $this->varLabelType == $obj->getVarLabelType());
	}*/
}
?>
