<?php
/**
 * Erfurt Structured OWL implementation of an anonymous class
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
class Erfurt_Owl_Structured_AnonymousClass extends Erfurt_Owl_Structured_StructuredClass

{

	private $subject ;

	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
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