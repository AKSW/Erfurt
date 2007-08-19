<?php

class Erfurt_Owl_Structured_SomeValuesFrom 
extends Erfurt_Owl_Structured_QuantifierRestriction

{

public function toTreeString()
{
	return "Some values from ".$this->getURI()." ".$this->onProperty."\n".$this->printChildClasses();
}

}
?>