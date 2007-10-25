<?php

// Does this class make any sense? please tell me if you know: kurzum@googlemail.com


class Erfurt_Owl_Structured_Instance {
	private $uri ;
	
	public function __construct ( $uri ) {
		$this->uri = $uri ;
	}
	
	public function getURI () {
		return $this->uri ;
	}
	
	public function toManchesterSyntaxString () {
		return $this->uri ;
	}
	
	public function toDIG1_1String () {
		
		return "<individual name=" . $this->getURI () . "/>" ;
	}

}
?>