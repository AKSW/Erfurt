<?php

class Erfurt_Owl_Structured_StructuredClass {
	private $childClasses = array ( ) ;
	private $URI ;
	private $firstChildBlankNode ;
	private $memmodel ;
	
	public function __construct ( $uri ) {
		
		//$this->childClasses = array();
		$this->URI = $uri ;
	}
	
	public function addChildClass ( $structuredClass ) {
		//echo"count children:".sizeof($structuredClass)."<br>";
		//print_r($structuredClass);echo"<br>";
		if (is_array ( $structuredClass )) {
			$this->childClasses = array_merge ( $this->childClasses, $structuredClass ) ;
		} else {
			$this->childClasses [] = $structuredClass ;
		}
	}
	/**
	 * 	getter for Child Classes
	 *
	 * @return array
	 */
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
	public function __toString () {
		return $this->toManchesterSyntaxString () ;
	}
	
	public function toManchesterSyntaxString () {
		
		return "Method not overwritten correctly" ;
	}
	
	public function toDIG1_1String () {
		
		return "Method not overwritten correctly" ;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return MemModel
	 */
	public function getChildrenRDF () {
		
		$this->firstChildBlankNode = new BlankNode ( $this->getMemModel () ) ;
		$blankNode = $this->getFirstChildBlankNode () ;
		$constPredicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$constObject = new Resource ( $this->getRDFURL (), "List" ) ;
		$constFirst = new Resource ( $this->getRDFURL (), "first" ) ;
		$constRest = new Resource ( $this->getRDFURL (), "rest" ) ;
		foreach ( $this->getChildClasses () as $key => $child ) {
			$statement = new Statement ( $blankNode, $constPredicate, $constObject ) ;
			$this->getMemModel ()->add ( $statement ) ;
			$statement = new Statement ( $blankNode, $constFirst, new Resource ( $child->getURI () ) ) ;
			$this->getMemModel ()->add ( $statement ) ;
			$newblankNode = $key < sizeof ( $this->getChildClasses () ) - 1 ? new BlankNode ( $this->getMemModel () ) : null ;
			$statement = new Statement ( $blankNode, $constRest, $newblankNode == null ? new Resource ( $this->getRDFURL () . "nil" ) : $newblankNode ) ;
			$this->getMemModel ()->add ( $statement ) ;
			$blankNode = $newblankNode ;
		}
		return $this->getMemModel () ;
	}
	/**
	 * Enter description here...
	 *
	 * @return BlankNode
	 */
	public function getFirstChildBlankNode () {
		return $this->firstChildBlankNode ;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return MemModel
	 */
	public function getMemModel () {
		if ($this->memmodel == null)
			$this->memmodel = new MemModel ( ) ;
		return $this->memmodel ;
	}
}
?>
