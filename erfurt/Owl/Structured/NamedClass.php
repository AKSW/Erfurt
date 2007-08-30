<?php

class Erfurt_Owl_Structured_NamedClass 
extends Erfurt_Owl_Structured_StructuredClass 
{
	
	//toTreeString
	public function toTreeString(){
		return $this->getURI();
	}
	//toTreeString
	public function toString($depth=0){
		
		//$tab=str_repeat("-",$depth).">";
		return $this->getURI();
	}
	public function toManchesterSyntaxString()
	{
		return $this->getURI();
	}

	
}
?>