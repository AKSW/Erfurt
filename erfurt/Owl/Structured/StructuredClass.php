<?php

class Erfurt_Owl_Structured_StructuredClass 
{

	var $childClasses;
	var $URI
	
	public function __construct($uri){
	
		$this->childClasses=new array();
		$this->URI=$uri;
	}
	
	public function addChildClass($structuredClass){
	
		$this->childClasses[]=$structuredClass;
	
	}
	
	public function getURI(){
	
		return $this->URI;
		
	}

}
?>