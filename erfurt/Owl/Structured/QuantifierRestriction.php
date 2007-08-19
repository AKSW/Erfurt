<?php
class Erfurt_Owl_Structured_QuantifierRestriction 
extends Erfurt_Owl_Structured_Restriction 
{

//	private $fillerClass;
	
	public function __construct($uri, $onProperty,$fillerClass){
	
		$this->URI = $uri;
		$this->onProperty = $onProperty;
//		$this->fillerClass = $fillerClass;
		$this->addChildClass($fillerClass);
	
	}

}
?>