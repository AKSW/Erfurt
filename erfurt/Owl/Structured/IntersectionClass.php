<?php

class Erfurt_Owl_Structured_IntersectionClass 
extends Erfurt_Owl_Structured_AnonymousClass 
{

	$var intersections;

	public function Erfurt_Owl_Structured_IntersectionClass(){
		$this->intersections=new array();
	}
	public function addIntersection($class){
		$this->intersections[]=$class;
		
	}
}
?>