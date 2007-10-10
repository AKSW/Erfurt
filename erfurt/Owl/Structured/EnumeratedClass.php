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
		
		//TODO blank node + oneOf?? (in mapping subject=classID)
		

		$model = new Memmodel ( ) ;
		$blank = new BlankNode ( "_blankXXX" ) ;
		$subject = new Resource ( $blank->getID () ) ;
		
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $subject, $predicate, new Literal ( $this->getURLPrefix () . "Class" ) ) ;
		$model->add ( $statement ) ;
		
		$rangeString = '' ;
		foreach ( $this->oneOfInstances as $key => $value ) {
			$rangeString .= $value->getURI () ;
			if ($key < count ( $this->oneOfInstances ) - 1) {
				$rangeString .= ' ' ;
			}
		}
		$statement = new Statement ( $subject, new Resource ( $this->getURLPrefix () . "oneOf" ), new Literal ( $rangeString ) ) ;
		$model->add ( $statement ) ;
		return $model ;
	}

}
?>