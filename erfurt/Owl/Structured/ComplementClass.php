<?php

class Erfurt_Owl_Structured_ComplementClass 
extends Erfurt_Owl_Structured_AnonymousClass 

{
	
	public function __construct($complementClass){
		parent::__construct('not '.$complementClass->getURI());
		$this->addChildClass($complementClass);
	}
	
	public function toManchesterSyntaxString()
	{
		$returnString='(';
		$children=$this->getChildClasses();
		foreach ($children as $key => $value) {
			$returnString.=$value->toManchesterSyntaxString();
		}
		return "not ".$returnString.")";
	}
	


	
}
?>