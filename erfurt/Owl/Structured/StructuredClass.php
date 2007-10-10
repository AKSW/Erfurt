<?php

class Erfurt_Owl_Structured_StructuredClass {
	private $childClasses = array ( ) ;
	private $URI ;
	
	public function __construct ( $uri ) {
		
		//$this->childClasses = array();
		$this->URI = $uri ;
	}
	
	public function addChildClass ( $structuredClass ) {
		if (is_array ( $structuredClass )) {
			$this->childClasses = array_merge ( $this->childClasses, $structuredClass ) ;
		} else {
			$this->childClasses [] = $structuredClass ;
		}
	}
	
	public function getChildClasses () {
		return $this->childClasses ;
	}
	
	public function getURI () {
		return $this->URI ;
	}
	
	public function setURI ( $newURI ) {
		$this->URI = $newURI ;
	}
	
	public function getURLPrefix () {
		return "http://www.w3.org/2002/07/owl#" ;
	}
	public function getRDFURL () {
		return "http://www.w3.org/1999/02/22-rdf-syntax-ns#" ;
	}
	public function _toString(){
		return $this->toManchesterSyntaxString();
	}
	
	public function toManchesterSyntaxString(){
	
		return "Method not overwritten correctly";
	}

}
?>
