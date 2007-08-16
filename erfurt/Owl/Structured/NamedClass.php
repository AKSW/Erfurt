<?php

class Erfurt_Owl_Structured_NamedClass 
extends Erfurt_Owl_Structured_StructuredClass 
{
	
	//toTreeString
	public function toTreeString(){
		return $this->getURI();
	}

	
}
?>