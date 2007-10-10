<?php

class Erfurt_Owl_Structured_UnionClass 
extends Erfurt_Owl_Structured_AnonymousClass 
{

	public function __construct(){
			
	}
	
	public function toManchesterSyntaxString()
	{
		$returnString='(';
		$children=$this->getChildClasses();
		foreach ($children as $key => $value) {
			$returnString.=$value->toManchesterSyntaxString();
			if ($key<count($children)-1) {
				$returnString.=' or ';
			}
		}
		return $returnString.')';
	}
	
}
?>