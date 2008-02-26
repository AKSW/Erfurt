<?php

// Does this class make any sense? please tell me if you know: kurzum@googlemail.com

/**
 * Class represents Instances of Enumerated Classes
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 **/
class Erfurt_Owl_Structured_Instance {
	private $uri ;
	
	public function __construct ( $uri ) {
		$this->uri = $uri ;
	}
	
	public function getURI () {
		return $this->uri ;
	}
	
	/**
	 * Generates Manchester OWL Syntax string
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 **/	
	public function toManchesterSyntaxString () {
		return $this->uri ;
	}
	
	public function toDIG1_1String () {
		
		return "<individual name=" . $this->getURI () . "/>" ;
	}
	
	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$subject = new Resource ( $this->getURI () ) ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $subject, $predicate, new Resource ( $this->getURLPrefix () . "Class" ) ) ;
		$model = $this->getMemModel () ;
		$model->add ( $statement ) ;
		return $model ;
	}
	public function __toString()
		{
			return $this->uri;
		}

}
?>