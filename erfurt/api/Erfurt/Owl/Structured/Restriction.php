<?php
/**
 * Superclass used by restriction classes
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
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
		$statement = new Statement ( $this->subject, $predicate, new Resource ( $this->getURLPrefix () . $this->getOWLType () ) ) ;
		
		$statement1 = new Statement ( $this->subject, new Resource ( $this->getURLPrefix () . "onProperty" ), new Resource ( $this->getOnProperty () ) ) ;
		
		$model->add ( $statement ) ;
		$model->add ( $statement1 ) ;
//		$statement = new Statement ( new Resource ( $this->getOnProperty () ), $predicate, new Resource ( $this->getURLPrefix () . "Class" ) ) ;
//		$model->add ( $statement ) ;
		$statement1 = new Statement ( new Resource ( $this->getOnProperty () ), $predicate, new Resource ( $this->getURLPrefix () . "DatatypeProperty" ) ) ;
		$model->add ( $statement1 ) ;
		return $model ;
	}
	
	/**
	 * function returns the subject, needed for generating the RDF Triples
	 *
	 * @return string
	 */
	public function getSubject () {
		return $this->subject ;
	}

}
?>