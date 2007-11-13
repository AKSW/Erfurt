<?php

class Erfurt_Owl_Structured_AxiomEquivalence extends Erfurt_Owl_Structured_Axiom {


	public function toManchesterSyntaxString () {
		$returnString = '' ;
		$l=$this->getLeft();
		$r=$this->getRight();
		
		$returnString .= $l->toManchesterSyntaxString()." = ".$r->toManchesterSyntaxString();
		
		return  $returnString . "" ;
	}


	public function toDIG1_1String(){
		$l=$this->getLeft();
		$r=$this->getRight();
	
		return "<equalc>".$l->toDIG1_1String().$r->toDIG1_1String()."</equalc>" ;
		}
	
	
	

}
?>