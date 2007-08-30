<?php

class Erfurt_Owl_Structured_HasValue
extends Erfurt_Owl_Structured_Restriction
{

	var $fillerInstance;
	
	public function __construct($uri, $onProperty,$fillerInstance){
		
		//TODO could be an array of instances, maybe???
		
		$this->setURI($uri);
		$this->setOnProperty($onProperty);
		$this->fillerInstance = $fillerInstance;
	}


	public function toManchesterSyntaxString()
	{
		return $this->getOnProperty() . " has " . $this->fillerInstance;
	}

}
?>