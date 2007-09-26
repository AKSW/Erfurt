<?php

class Erfurt_Owl_Structured_MaxCardinality 
extends Erfurt_Owl_Structured_CardinalityBase

{
public function toManchesterSyntaxString()
{
	return $this->getOnProperty() . " max " . $this->getCardinality();
}


}
?>