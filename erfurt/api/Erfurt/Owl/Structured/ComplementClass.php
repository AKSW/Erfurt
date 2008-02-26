<?php
/**
 * Erfurt Structured OWL implementation of the complementOf OWL Constructor
 * 
 * @author
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package owl
 * @version $Id$
 */
class Erfurt_Owl_Structured_ComplementClass extends Erfurt_Owl_Structured_AnonymousClass 

{
	
	public function __construct ( $complementClass ) {
		parent::__construct ( 'not ' . $complementClass->getURI () ) ;
		$this->addChildClass ( $complementClass ) ;
	}
	
	/**
	 * Generates Manchester OWL Syntax string
	 * 
	 * @return string Manchester OWL Syntax output
	 * 
	 **/
	public function toManchesterSyntaxString () {
		$returnString = '(' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $value ) {
			$returnString .= $value->toManchesterSyntaxString () ;
		}
		return "not " . $returnString . ")" ;
	}
	
	/**
	 * Recursively generates the MemModel from the Structured Class
	 * 
	 * @return MemModel of the Structured Class
	 * 
   	 **/	
	public function generateRDF () {
		$model = $this->getMemModel();
		$blank = new BlankNode ($model) ;
		$predicate = new Resource ( $this->getRDFURL (), "type" ) ;
		$statement = new Statement ( $blank, $predicate, new Resource ( $this->getURLPrefix () . "Class" ) ) ;
		$model->add ( $statement ) ;
		//$this->getChildrenRDF();
		$children=$this->getChildClasses();
		$child=$children[0];
		$model->addModel(
			$child->generateRDF()
			)
			;
			if($child instanceof Erfurt_Owl_Structured_NamedClass){
				$node=new Resource($child->getURI());
			}
			else{
				$node=$child->getFirstChildBlankNode();
			}
		$statement1 = new Statement ( $blank, new Resource ( $this->getURLPrefix () . "complementOf" ), $node ) ;
		$model->add ( $statement1 ) ;
		return $model ;
	}
	
	public function toDIG1_1String(){
		
		$returnString = '<not>' ;
		$children = $this->getChildClasses () ;
		foreach ( $children as $one ) {
			$returnString .= $one->toManchesterSyntaxString () ;
		}
		return $returnString . '</not>' ;
	}

	// TODO Finish this one!!!
	// Currently works only with two level of complement classes e.g. "not not class".
	// possible solution: make it recursive
	public function getFirstChildBlankNode(){
		$children=$this->getChildClasses();
		$child=$children[0];
		print_r($child);
		if(sizeof($child->getChildClasses())==1){
			return new Statement(new Resource($this->getURI()),new Resource($this->getRDFURL(),"type"),new Resource ( $this->getURLPrefix () . "Class" ));
		}
		else return new BlankNode($this->getMemModel());
	}

}
?>