<?php

class Erfurt_Owl_Structured_ComplementClass 
extends Erfurt_Owl_Structured_AnonymousClass 

{
	public function toTreeString(){
		return $this->getURI();
	}
	
	public function toManchesterSyntaxString()
	{
		return "not ".$this->getURI();
	}


	
}
?>