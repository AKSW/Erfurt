<?php

// this is just a rough draft, it still needs a complete makeover, it is taken from the powl2digConverter

class Erfurt_Owl_Structured_Converter

{
	// returns structured class
	public function convert($OWLClass,$first=true){
		if(isBlankNode($OWLClass) && $first) throw new Exception("blank nodes cannot be converted yet");
		else if($first)
			$target=new Erfurt_Owl_Structured_NamedClass ($OWLClass->getURI());
		else{}
		
		
		/**SUBCLASSES******/
			
		$subclasses=$OWLClass->listSubClasses();
		$intersectionClass=new Erfurt_Owl_Structured_IntersectionClass();
		foreach ($subclasses as $subclass)	{
			$intersectionClass->addIntersection($this->convert($subclass,false));
		}
		
		
	
	}


	public function internal(){}


public function getDIGStringForClass($OWLClass,$redundant=true){
		
 		$classname=$OWLClass->getURI();
 		///echo $classname."\n";
 		
 		$digForThis="<catom name=\"".$classname."\"/>\n";
 		if(!($redundant)){
 			if(stristr($classname,"node")){
 			}
 			else{
 			return $digForThis;}
 		}
 		
 		
 	
 		
 		
 		$retval="";

	

       
   
    /**Equivalent*****/
    	
    	
    	$int=$OWLClass->listIntersectionOf();
    	$uni=$OWLClass->listUnionOf();
    	$comp=$OWLClass->listComplementOf();
    	$equi=$OWLClass->listEquivalentClasses();
    	    	
    	$size=sizeof($int)+sizeof($uni)+sizeof($comp)+sizeof($equi);
    	if($size>0)
    	{
    		$retval.="<equalc>\n".$digForThis;
    		
    		if(sizeof($int)>0){
    			//print_r( $int);
    			$retval.="<and>\n";
    			foreach($int as $i){
    				$retval.=$this->getDIGStringForClass($i,false);
    				}
    			$retval.="</and>\n";
    		}
    		
    		if(sizeof($uni)>0){
				$retval.="<or>\n";
				foreach($uni as $u){
					$retval.=$this->getDIGStringForClass($u,false);
					}
				$retval.="</or>\n";
    		}
    		if(sizeof($comp)>0){
				foreach($comp as $c){
					$retval.="<not>\n".$this->getDIGStringForClass($c,false)."</not>\n";
					}
				
    		}
    		if(sizeof($equi)>0){
    			foreach($equi as $e){
					$retval.=$this->getDIGStringForClass($e,false);
					}
							
    		}
    		
    		$retval.="</equalc>\n";
    	}
    	
    	else{}
    	
    	 /**DISJOINT******/
		$disjointwith=$OWLClass->listDisjointWith();
		$distmp="<disjoint>";
		foreach ($disjointwith as $d) {
			$distmp.=$this->getDIGStringForClass($d,false).$digForThis;

			}
			$distmp.="</disjoint>\n";
		
		 if(sizeof($disjointwith)==0 )$distmp="";
	 	$retval.=$distmp;
    	
		 return $retval;
		
	}
}
?>