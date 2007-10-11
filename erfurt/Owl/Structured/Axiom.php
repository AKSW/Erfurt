<?php

class Erfurt_Owl_Structured_Axiom {

	private $leftPart;
	private $rightPart;
	
	function __construct($l,$r){
	
		$this->leftPart=$l;
		$this->rightPart=$r;
			
	}
	
	
	public function getLeft(){
			return $this->leftPart;
	}
	
	public function getRight(){
			return $this->rightPart;
	}
	
	
		
	public function toManchesterSyntaxString(){
		return "Method not overwritten correctly";
	}
	
	public function toDIG1_1String(){
			
		return "Method not overwritten correctly";
	}
}
?>