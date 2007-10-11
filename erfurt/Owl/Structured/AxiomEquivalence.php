<?php

class Erfurt_Owl_Structured_AxiomEquivalence extends Erfurt_Owl_Structured_Axiom {




	public function toManchesterSyntaxString () {
		$returnString = '' ;
		$l=$this->getLeft();
		$r=$this->getRight();
		
		$returnString .= $l->toManchesterSyntaxString()." = ".$r->toManchesterSyntaxString();
		
		return  $returnString . "" ;
	}

}
?>