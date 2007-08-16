<?php

class Erfurt_Owl_Structured_IntersectionClass 
extends Erfurt_Owl_Structured_AnonymousClass 
{
	//toTreeString
	public function toTreeString(){
		return $this->getChildClasses();
	}
}
?>