<?php

class Erfurt_Owl_Structured_UnionClass 
extends Erfurt_Owl_Structured_AnonymousClass 

{

	//toTreeString
	public function toTreeString(){
		return $this->getChildClasses();
	}

	public function toManchesterSyntax()
	{
		$returnString='';
		$children=$this->getChildClasses();
		if(null!=$this->children){
			$returnString.=$this->children[0]. " or " . $this->children[1];
		}
		return returnString;
	}

}
?>