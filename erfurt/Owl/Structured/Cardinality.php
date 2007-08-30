<?php

class Erfurt_Owl_Structured_Cardinality 
extends Erfurt_Owl_Structured_CardinalityBase
{

	public function toManchesterSyntaxString()
	{
		return $this->getOnProperty() . " exactly " . $this->getCardinality();
	}


}
?>