<?php

class Erfurt_Owl_Structured_EnumeratedClass extends Erfurt_Owl_Structured_AnonymousClass {
	private $oneOfInstances ;
	
	public function __construct ( $instancesArray ) {
		
		$this->oneOfInstances = $instancesArray ;
	}
	
	public function toManchesterSyntaxString () {
		$returnString = '{' ;
		foreach ( $this->oneOfInstances as $key => $value ) {
			$returnString .= $value->toManchesterSyntaxString () ;
			if ($key < count ( $this->oneOfInstances ) - 1) {
				$returnString .= ' ' ;
			}
		}
		return $returnString . '}' ;
	}
	
	public function generateRDF () {
		//TODO check if this is correct implementation
		$model = $this->getMemModel();
		$blankNode = new BlankNode ( $model ) ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $blankNode, $predicate, new Resource ( $this->getURLPrefix () . "Class" ) ) ;
		$model->add ( $statement ) ;
		$constPredicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$constObject = new Resource ( $this->getRDFURL (), "List" ) ;
		$constFirst = new Resource ( $this->getRDFURL (), "first" ) ;
		$constRest = new Resource ( $this->getRDFURL (), "rest" ) ;
		foreach ( $this->oneOfInstances as $key => $value ) {
			$statement = new Statement ( $blankNode, $constPredicate, $constObject ) ;
			$model->add ( $statement ) ;
			$statement = new Statement ( $blankNode, $constFirst, new Resource ( $value->getURI () ) ) ;
			$model->add ( $statement ) ;
			$newblankNode = $key < sizeof ( $this->oneOfInstances ) - 1 ? new BlankNode ( $model ) : null ;
			$statement = new Statement ( $blankNode, $constRest, $newblankNode == null ? new Resource ( $this->getRDFURL () . "nil" ) : $newblankNode ) ;
			$model->add ( $statement ) ;
			$blankNode = $newblankNode ;
		}
		return $model ;
	}

}
?>