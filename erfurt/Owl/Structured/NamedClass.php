<?php

class Erfurt_Owl_Structured_NamedClass 
extends Erfurt_Owl_Structured_StructuredClass 
{
	var $uri;
	var $subclass;

	public function Erfurt_Owl_Structured_NamedClass ($u){
		$this->uri=$u;
	}

	public getURI(){
	
	}

	public setSubclass($class){
	 	$this->subclass=$class;
	}

}
?>