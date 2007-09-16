<?php

class Erfurt_Owl_Structured_EnumeratedClass 
extends Erfurt_Owl_Structured_AnonymousClass 
{
		var $oneOfInstances;
		
		public function __construct($instancesArray){
	
			$this->oneOfInstances=$instancesArray;
		}

		public function toManchesterSyntaxString()
		{
			$returnString='{';
			foreach ($this->oneOfInstances as $key => $value) {
				$returnString.=$value->toManchesterSyntaxString();
				if ($key<count($this->oneOfInstances)-1) {
					$returnString.=' ';
				}
			}
			return $returnString.'}';
		}

}
?>