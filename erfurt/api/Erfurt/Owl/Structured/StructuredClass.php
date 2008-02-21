<?php
/**
 * Superclass for Erfurt Structured OWL Classes
 * 
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version 
 */
class Erfurt_Owl_Structured_StructuredClass {
	private $childClasses = array ( ) ;
	private $URI ;
	private $firstChildBlankNode =null;
	private $memmodel ;
	
	/**
	 * Default constructor. Used by the subclasses to assign the URI value
	 * @param string URI
	 * 
	 */
	public function __construct ( $uri ) {
		
		//$this->childClasses = array();
		$this->URI = $uri ;
	}
	
	/**
	 * Method for adding child classes to existing Structured Class
	 * 
	 * @param array or Erfurt_Owl_Structured_StructuredClass
	 * 
	 */	
	public function addChildClass ( $structuredClass ) {
		if (is_array ( $structuredClass )) {
			$this->childClasses = array_merge ( $this->childClasses, $structuredClass ) ;
		} else {
			$this->childClasses [] = $structuredClass ;
		}
	}
	/**
	 * Method for getter for Child Classes
	 *
	 * @return array of Child Classes
	 * 
	 */
	public function getChildClasses () {
		return $this->childClasses ;
	}
	
	/**
	 * returns the URI of the Structured Class
	 * 
	 * @return string URI
	 * 
	 */	
	public function getURI () {
		return $this->URI ;
	}
	
	/**
	 * sets the URI of the Structured Class
	 * 
	 * @param string URI
	 * 
	 */	
	public function setURI ( $newURI ) {
		$this->URI = $newURI ;
	}
	//TODO rename
	/**
	 * gets the URL prefix for the OWL Triples (Has to be renamed to match OWL 1.1)
	 * 
	 * @return string URL
	 * 
	 */	
	public function getURLPrefix () {
		return "http://www.w3.org/2002/07/owl#" ;
	}

	/**
	 * gets the URL prefix for the RDF Triples
	 * 
	 * @return string URL
	 * 
	 */	
	public function getRDFURL () {
		return "http://www.w3.org/1999/02/22-rdf-syntax-ns#" ;
	}
	/**
	 * Helper method for generating the Manchester OWL Syntax string. Used by subclasses.
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 */	
	public function __toString () {
		return $this->toManchesterSyntaxString () ;
	}
	
	/**
	 * not used
	 * 
	 * @return string Error message
	 * 
	 */	
	public function toManchesterSyntaxString () {
		
		return "Method not overwritten correctly" ;
	}
	
	public function toDIG1_1String () {
		
		return "Method not overwritten correctly" ;
	}
	
	/**
	 * Method used by subclasses to generate RDF for included statements
	 *
	 * @return MemModel of included child classes
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
			}else{
				$statement = new Statement ( $blankNode, $constPredicate, $constObject ) ;
				$this->getMemModel ()->add ( $statement ) ;
				$recModel=$child->generateRDF();
				$it=$recModel->getStatementIterator();
				$nextBlankNode=$it->next()->getSubject();
				$this->getMemModel()->addModel($recModel);
				$statement = new Statement ( $blankNode, $constFirst, $nextBlankNode ) ;
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
	 * getter for the first defined BlankNode
	 *
	 * @return BlankNode of the first child
	 */
	public function getFirstChildBlankNode () {
		return $this->firstChildBlankNode ;
	}
	
	/**
	 * Generates or returns MemModel for this Structured Class
	 *
	 * @return MemModel of the class
	 */
	public function getMemModel () {
		if ($this->memmodel == null)
			$this->memmodel = new MemModel ( ) ;
		return $this->memmodel ;
	}
}
?>
