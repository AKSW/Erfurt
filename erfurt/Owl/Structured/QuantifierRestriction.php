<?php
class Erfurt_Owl_Structured_QuantifierRestriction 
extends Erfurt_Owl_Structured_Restriction 
{

	public function __construct($uri, $onProperty,$fillerClass){
	
		$this->setURI($uri);
		$this->setOnProperty($onProperty);
		$this->addChildClass($fillerClass);
	}

}
?>