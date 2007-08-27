<?php

class Erfurt_Owl_Structured_Converter

{	private $debug_flag =true;
	// returns structured class
	// WARNING reads the definition recursively until NamedClasses are found
	public function convert($OWLClass,$first=true)
	{
		if($first)
		{
			if($OWLClass->isBlankNode()) 
			{	throw new Exception("blank nodes cannot be converted yet");
			}//if
			else 
			{
				$structClass=new Erfurt_Owl_Structured_NamedClass($OWLClass->getURI());
			/***initialize Axioms***/
			/***SubclassOf***/
				$superClasses=$OWLClass->listSuperClasses();
				echo "superClasses\n";
				print_r(array_keys($superClasses));
				$tmpStruct=array();
				foreach($superClasses as $one)
				{
					$structClass->addSubclassOf($this->convert($one,false));
				}//foreach
				
			/***Equivalent***/
				//!!!!CHECK IF BLANKNODES ARE RETURNED
				$equiClasses=$OWLClass->listEquivalentClasses() ;
				echo "equivalentClasses:\n";
				print_r(array_keys($equiClasses));
				$tmpStruct=array();
				foreach($equiClasses as $one)
				{
					$structClass->addEquivalentClass($this->convert($one,false));
				}//foreach
				$int=$OWLClass->listIntersectionOf();
    			$uni=$OWLClass->listUnionOf();
    			echo "intersectionClasses:\n";
				print_r(array_keys($int));
				echo "UnionClasses:\n";
				print_r(array_keys($uni));
    			
				if(sizeof($int)==1)
				{
					$structClass->addEquivalentClass($this->convert($int[0],false));
				}else if(sizeof($int)>=1)
				{
					$tmp=new Erfurt_Owl_Structured_IntersectionClass();
					foreach ($int as $one)
					{
						$tmp->addChildClass($this->convert($one,false));
					}//foreach
					$structClass->addEquivalentClass($tmp);
				}//else if
				if(sizeof($uni)==1)
				{
					$structClass->addEquivalentClass($this->convert($uni[0],false));
				}else if(sizeof($int)>=1)
				{
					$tmp=new Erfurt_Owl_Structured_UnionClass();
					foreach ($uni as $one)
					{
						$tmp->addChildClass($this->convert($one,false));
					}//foreach
					$structClass->addEquivalentClass($tmp);
				}//else if
				
				
				
			/***Disjoints***/
				//!!!!CHECK IF BLANKNODES ARE RETURNED
				$disjointClasses=$OWLClass->listDisjointWith();
				echo "disjoint classes:\n";
				print_r(array_keys($disjointClasses));
				$tmpStruct=array();
				foreach($disjointClasses as $one)
				{
					$structClass->addDisjointWith($this->convert($one,false));
				}//foreach
				$comp=$OWLClass->listComplementOf();
				foreach($comp as $one)
				{
					$structClass->addDisjointWith($this->convert($one,false));
				}//foreach
				
				return $structClass;
				
			}//else
	
		}//if(first)
		else
		{
			
			if($OWLClass->isBlankNode())
			{
				//classify this blanknode
				$int=$OWLClass->listIntersectionOf();
				if(sizeof($int)>=1)
				{
					$tmp=new Erfurt_Owl_Structured_IntersectionClass();
					foreach ($int as $one)
					{
						$tmp->addChildClass($this->convert($one,false));
					}//foreach
					return $tmp;
				}//if
				
		    	$uni=$OWLClass->listUnionOf();
		    	if(sizeof($uni)>=1)
		    	{
					$tmp=new Erfurt_Owl_Structured_UnionClass();
					foreach ($uni as $one)
					{
						$tmp->addChildClass($this->convert($one,false));
					}
					return $tmp;
				}//if
		    	
    			$comp=$OWLClass->listComplementOf();
				if(sizeof($uni)>=1)
				{
					$tmp=new Erfurt_Owl_Structured_ComplementClass();
					foreach ($comp as $one)
					{
						$tmp->addChildClass($this->convert($one,false));
					}//foreach
					return $tmp;
				}//if
			}//if
			else
			{
				// WARNING: No definitions are made for this Named Class
				// needs to be done by a separate call to the convert function
				return new Erfurt_Owl_Structured_NamedClass($OWLClass->getURI());
			}//else
		
		}//else first

	}//function



}//class
?>