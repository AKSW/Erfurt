<?php
/**
 * 
 * @package owl
 */
class Erfurt_Owl_Structured_AxiomDisjointClasses extends Erfurt_Owl_Structured_Axiom  {


	public function toManchesterSyntaxString () {
		$returnString = '' ;
		$l=$this->getLeft();
		$r=$this->getRight();
		
		$returnString .= $l->toManchesterSyntaxString()." != ".$r->toManchesterSyntaxString();
		
		return  $returnString . "" ;
	}
	
	
	public function toDIG1_1String(){
		$l=$this->getLeft();
		$r=$this->getRight();
			
		return "<disjoint>".$l->toDIG1_1String().$r->toDIG1_1String()."</disjoint>" ;
	}
	
	

	
}
?>