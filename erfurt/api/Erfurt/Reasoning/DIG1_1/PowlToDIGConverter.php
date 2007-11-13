<?php



//require_once '../../include.php';
/*
 Klasse PowlToDIGConverter mit Methoden getDIGString(OWLClass),
    getDIGString(OWLProperty), getDIGString(OWLModel)
*/



class Erfurt_Reasoning_DIG1_1_PowlToDIGConverter {

	
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

	/**SUBCLASSES******/
	
		$subclasses=$OWLClass->listSubClasses();
		foreach ($subclasses as $subclass)	{
			
			$retval.="<impliesc>\n".
			$this->getDIGStringForClass($subclass,false).
			$digForThis.
			"</impliesc>\n";
		}

       
   
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
	
	

    /**INSTANCES*****
    	$allInstances=$OWLClass->listInstances(0,9999999,0);
    	//define instanceof
   		foreach (array_keys($allInstances) as $oneInstance){
			//echo("<br>".$oneInstance);
			$i1=new Individual($oneInstance);
			$c2=new Catom($classname);
			$retval.="<instanceof>".$i1->toDIG()." ".$c2->toDIG()."</instanceof>\n";
        }

		$i1;$i2;$r;
        foreach (array_keys($allInstances) as $instanceName){
			$currentInstance=$allInstances[$instanceName];
			$allProps=$currentInstance-> listAllPropertyValuesPlain();
			foreach (array_keys($allProps) as $propertyname){
				$currentProp=$allProps[$propertyname];
				$i1=new Individual($instanceName);
				$r=new Ratom($propertyname);
				foreach($allProps[$propertyname] as $filler){
					$i2=new Individual($filler);
					$retval.="<related>".$i1->toDIG().$r->toDIG()." ".$i2->toDIG()."</related>";
				}
				//$i2=new Individual($allProps[$propertyname]);
				//print_r($allProps[$propertyname]);
				//$retval.="<related>".$i1->toDIG().$r->toDIG()." ".$i2->toDIG()."</related>";

			}
			//echo $oneinstance;
			//echo("<br>");
			//print_r(array_keys( $oneInstance->listProperties()));
			//$allll=$oneInstance-> listAllPropertyValuesPlain();
			//print_r($allll['benefit_victim']);

        }*/




	public function getDIGStringForProp($OWLProperty){

		$retval="";
		$digforthis="<ratom name=\"".$OWLProperty->getURI()."\"/>\n";

	/**SUBproperties******/
		foreach ($OWLProperty->listSubProperties() as $subproperty)	{
			
			$retval.="<impliesr>".$this-> $this->getDIGStringForProp($subproperty).$digforthis."</impliesr>\n";
		}

	   /*<equalr>R1 R2</equalr>*/

	   //<domain>R E</domain>
		foreach ($OWLProperty->listDomain() as $domain) {
		   
		   $retval.="<domain>".$digforthis.
		   $this->getDIGStringForClass($domain,false)."</domain>\n";
		}

	   //<range>RE</range>

		foreach ($OWLProperty->listRange() as $range)  {
			
			$retval.="<range>".$digforthis.$this->getDIGStringForClass($range,false)."</range>\n";
		}

   /*<rangeint>R</rangeint>
   <rangestring>R</rangestring>*/

	//NOT WORKING RDFSProperty not OWLProperty
	//print_r(array_keys($OWLProperty->listInverseOf()));
	//<functional>R</functional>
	/*if($OWLProperty->isFunctional()){
		$retval.="<functional>".$propexp->toDIG()."</functional>";}
	//<transitive>R</transitive>
	/*if($OWLProperty->isTransitive()){
		$retval.="<transitive>".$propexp->toDIG()."</transitive>";}*/

		return $retval;
	}


	public function getDIGStringForModel($OWLModel){

 	//CLASSES
        $allClasses=$OWLModel->listClasses();
        foreach ($allClasses as $oneClass){
            $tellAll.="<defconcept name=\"".$oneClass->getURI()."\"/>\n";
        	 $tellAll.=$this->getDIGStringForClass($oneClass,true)."\n";
        
        }

    //ROLES
	    $allProperties=$OWLModel->listProperties();
        foreach ($allProperties as $oneProperty){
            $tellAll.="<defrole name=\"".$oneProperty->getURI()."\"/>\n";
            $tellAll.=$this->getDIGStringForProp($oneProperty);
        }
    //INSTANCES
    // DICKER FETTER BUG IN LISTINSTANCES
        $allInstances=$OWLModel->listInstances(0,9999999,0);
        foreach ($allInstances as $oneInstance){
            $tellAll.="<defindividual name=\"".$oneInstance->getURI()."\"/>\n";
        }

	

        return $tellAll;
    }


	public function printkeys($ar){
  		print_r(array_keys($ar));
  	}
}
?>