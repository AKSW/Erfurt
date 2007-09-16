<?php

class Erfurt_Owl_Structured_IntersectionClass 
extends Erfurt_Owl_Structured_AnonymousClass 
{
	public function toManchesterSyntaxString()
	{
		$returnString='(';
		$children=$this->getChildClasses();
		foreach ($children as $key => $value) {
			$returnString.=$value->toManchesterSyntaxString();
			if ($key<count($children)-1) {
				$returnString.=' and ';
			}
		}
		return $returnString.')';
	}
	
}
?>