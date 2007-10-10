<?php

class Erfurt_Owl_Structured_AnonymousClass extends Erfurt_Owl_Structured_StructuredClass 

{
	
	private $subject ;
	
	public function generateRDF () {
		
		$model = new MemModel ( ) ;
		$blankNode = new BlankNode ( "_blankXXX" ) ;
		$this->subject = new Resource ( $blankNode->getID () ) ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $this->subject, $predicate, new Literal ( $this->getURLPrefix () . $this->getURLPrefix () . "Class" ) ) ;
		$model->add ( $statement ) ;
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