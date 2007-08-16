<?php

class Erfurt_Owl_Structured_MinCardinality 
extends Erfurt_Owl_Structured_CardinalityBase

{

	public function toTreeString(){
		return "min cardinality ".$this->cardinality . " on " . $this->onProperty;
	}


}
?>