<?php

class Erfurt_Owl_Structured_StructuredClass {
	private $childClasses = array ( ) ;
	private $URI ;
	private $firstChildBlankNode =null;
	private $memmodel ;
	
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
	//TODO rename
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
		if($this->firstChildBlankNode==null){
			$this->firstChildBlankNode = new BlankNode ( $this->getMemModel () ) ;
		}
		$blankNode = $this->getFirstChildBlankNode () ;
		$constPredicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$constObject = new Resource ( $this->getRDFURL (), "List" ) ;
		$constFirst = new Resource ( $this->getRDFURL (), "first" ) ;
		$constRest = new Resource ( $this->getRDFURL (), "rest" ) ;
		foreach ( $this->getChildClasses () as $key => $child ) {
			if($child instanceof Erfurt_Owl_Structured_NamedClass){
				//TODO use MemModel->unite, to eliminate duplicates
				$recModel=$child->generateRDF();
				$statement = new Statement ( $blankNode, $constFirst, new Resource ( $child->getURI () ) ) ;
				$this->getMemModel()->addModel($recModel);
				//$statement = new Statement ( $blankNode, $constFirst, new Resource ( $child->getURI () ) ) ;
			}else{
				$statement = new Statement ( $blankNode, $constPredicate, $constObject ) ;
				$this->getMemModel ()->add ( $statement ) ;
				$recModel=$child->generateRDF();
				$this->getMemModel()->addModel($recModel);
				//TODO find out what is the next node id
//				print_r($child->getFirstChildBlankNode()->uri); echo "<br>";
				$statement = new Statement ( $blankNode, $constFirst, $child->getFirstChildBlankNode()/*new Resource ( "xxx" ) */) ;
			}
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
