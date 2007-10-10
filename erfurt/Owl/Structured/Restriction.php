<?php

class Erfurt_Owl_Structured_Restriction extends Erfurt_Owl_Structured_AnonymousClass {
	
	private $onProperty ;
	/**
	 * subject will be the same for all CardinalityBase classes
	 *
	 * @var Resource
	 */
	private $subject ;
	
	public function setOnProperty ( $newOnProperty ) {
		$this->onProperty = $newOnProperty ;
	}
	public function getOnProperty () {
		return $this->onProperty ;
	}
	
	public function getOWLType () {
		return "Restriction" ;
	}
	
	public function generateRDF () {
		
		$model = new MemModel ( ) ;
		$blankNode = new BlankNode ( "_blankXXX" ) ;
		$this->subject = new Resource ( $blankNode->getID () ) ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $this->subject, $predicate, new Literal ( $this->getURLPrefix () . $this->getOWLType () ) ) ;
		
		$statement1 = new Statement ( $this->subject, new Resource ( $this->getURLPrefix () . "OnProperty" ), new Literal ( $this->getOnProperty () ) ) ;
		$model->add ( $statement ) ;
		$model->add ( $statement1 ) ;
		
		return $model ;
	}
	
	/**
	 * function returns the subject, needed for generating the RDF Triples
	 *
	 * @return subject
	 */
	public function getSubject () {
		return $this->subject ;
	}

}
?>