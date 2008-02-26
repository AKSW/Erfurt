<?php
/**
 * Erfurt Structured OWL implementation of the hasValue OWL Constructor
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
class Erfurt_Owl_Structured_HasValue extends Erfurt_Owl_Structured_Restriction {
	
	private $fillerInstance ;
	
	public function __construct ( $uri , $onProperty , $fillerInstance ) {
		$this->setURI ( $uri ) ;
		$this->setOnProperty ( $onProperty ) ;
		$this->fillerInstance = $fillerInstance ;
	}
	
	/**
	 * Generates Manchester OWL Syntax string
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 **/	
	public function toManchesterSyntaxString () {
		return "(" . $this->getOnProperty () . " value " . $this->fillerInstance->toManchesterSyntaxString () . ")" ;
	}
	
	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$model = parent::generateRDF () ;
		$obj=new Resource($this->fillerInstance->getURI());
		$statement = new Statement ( $this->getSubject (), new Resource ( $this->getURLPrefix () . "hasValue" ), $obj) ;
		$statement1=new Statement($obj, new Resource ( $this->getRDFURL (), "type" ), new Resource ( $this->getURLPrefix (), "ObjectProperty" ));
		$model->add ( $statement ) ;
		$model->add($statement1);
		return $model ;
	}

}
?>