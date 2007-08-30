<?php

class Erfurt_Owl_Structured_Restriction 
extends Erfurt_Owl_Structured_AnonymousClass 
{

	private $onProperty;
	
	public function setOnProperty($newOnProperty)
	{
		$this->onProperty=$newOnProperty;
	}
	public function getOnProperty()
	{
		return $this->onProperty;
	}
	
}
?>