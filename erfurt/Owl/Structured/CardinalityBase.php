<?php

class Erfurt_Owl_Structured_CardinalityBase 
extends Erfurt_Owl_Structured_Restriction 
{
	private $cardinality;
	
	public function __construct($uri, $onProperty,$cardinality){
	
		$this->setURI($uri);
		$this->setOnProperty($onProperty);
		$this->cardinality = $cardinality;
	
	}
	
	public function getCardinality()
	{
		return $this->cardinality;
	}

}
?>