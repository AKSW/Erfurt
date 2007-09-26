<?php

class Erfurt_Owl_Structured_AllValuesFrom 
extends Erfurt_Owl_Structured_QuantifierRestriction

{
	public function toManchesterSyntaxString()
	{
		$returnString='[';
		$children=$this->getChildClasses();
		foreach ($children as $key => $value) {
			$returnString.=$value->toManchesterSyntaxString();
			if ($key<count($children)-1) {
				$returnString.=', ';
			}
		}
		$returnString.=']';
		return "(".$this->getOnProperty() . " only " . $returnString.")";
	}

}
?>