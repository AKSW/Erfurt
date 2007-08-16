<?php

class Erfurt_Owl_Structured_StructuredClass 
{

	private $childClasses;
	private $URI;
	
	public function __construct($uri){
	
		$this->childClasses = array();
		$this->URI=$uri;
	}
	
	public function addChildClass($structuredClass){
	
		$this->childClasses[]=$structuredClass;
		//echo "adding child ".$structuredClass."\n";
	
	}
	
	public function getURI(){
	
		return $this->URI;
		
	}
	
	public function getChildClasses(){
		return $this->childClasses;
	}
	
	//toTreeString
	public function toTreeString(){
		return $this->childClasses;
	}

}
?>