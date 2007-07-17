<?php

class Erfurt_Owl_Structured_EnumeratedClass 
extends Erfurt_Owl_Structured_AnonymousClass 
{
		var $oneOfInstances
		
		public function __construct($instancesArray){
	
			$this->oneOfInstances=$instanceArray;
			
		}

}
?>