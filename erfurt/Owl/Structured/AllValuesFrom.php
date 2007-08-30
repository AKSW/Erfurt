<?php

class Erfurt_Owl_Structured_AllValuesFrom 
extends Erfurt_Owl_Structured_QuantifierRestriction

{

	public function toManchesterSyntaxString()
	{
		return $this->getOnProperty() . " only " . join(',',$this->getChildClasses());
	}


}
?>