<?php

class Erfurt_Owl_Structured_CardinalityBase 
extends Erfurt_Owl_Structured_Restriction 
{
	private $cardinality;
	
	public function __construct($uri, $onProperty,$cardinality){
	
		$this->URI = $uri;
		$this->onProperty = $onProperty;
		$this->cardinality = $cardinality;
	
	}

}
?>