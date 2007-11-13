<?php
/**
 * 
 * @package owl
 */
class Erfurt_Owl_Structured_AnonymousClass extends Erfurt_Owl_Structured_StructuredClass

{

	private $subject ;

	/**
	 * Enter description here...
	 *
	 * @return MemModel
	 */
	public function generateRDF () {
		$model = $this->getMemModel () ;
		$blankNode = new BlankNode ( $model ) ;
		$this->subject = $blankNode ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $this->subject, $predicate, new Resource ( $this->getURLPrefix () . "Class" ) ) ;
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