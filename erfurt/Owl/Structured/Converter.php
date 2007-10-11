<?php

class Erfurt_Owl_Structured_Converter

{	private $debug_flag = false;

	/**
	new methods:
	
		@returns Erfurt_OWL_Structured_StructuredClass
	**/
	public function convertErfurtClass($ErfurtOWLClass){
	
	
		/*echo $ErfurtOWLClass->getURI()."\n";
		print_r($ErfurtOWLClass->listPropertyValues("http://www.w3.org/2002/07/owl#unionOf",'Class'));
		print_r($ErfurtOWLClass->listUnionOf());
		//echo "|".$ErfurtOWLClass->getURI()."|\n";
		echo "|bn:".$this->isBlankNode($ErfurtOWLClass)."|\n";
	
	*/
		if(!($ErfurtOWLClass->isBlankNode())) 
		{	
			//echo $ErfurtOWLClass->getURI()."notablanknode";
			$structClass=new Erfurt_Owl_Structured_NamedClass($ErfurtOWLClass->getURI());
			return $structClass;
		}//ifBlankNode
		else 
		{	
			//classify this blanknode
			//echo $ErfurtOWLClass->getURI()."a\n";
			/*INTERSECTION?**/
			$int=$ErfurtOWLClass->listIntersectionOf();
			
			//$this->p("blanknode",$int);
			if(sizeof($int)>=1)
			{
				$tmp=new Erfurt_Owl_Structured_IntersectionClass($ErfurtOWLClass->getURI());
				foreach ($int as $one)
				{
					$tmp->addChildClass($this->convertErfurtClass($one));
				}//foreach
				return $tmp;
			}//if

			/*UNION?**/
			$uni=$ErfurtOWLClass->listUnionOf();
			if(sizeof($uni)>=1)
			{
				$tmp=new Erfurt_Owl_Structured_UnionClass($ErfurtOWLClass->getURI());
				foreach ($uni as $one)
				{
					$tmp->addChildClass($this->convertErfurtClass($one));
				}
				return $tmp;
			}//if
			/*Complement?**/
			$comp=$ErfurtOWLClass->listComplementOf();
			if(sizeof($uni)>=1)
			{
				$tmp=new Erfurt_Owl_Structured_ComplementClass($ErfurtOWLClass->getURI());
				foreach ($comp as $one)
				{
					$tmp->addChildClass($this->convertErfurtClass($one));
				}//foreach
				return $tmp;
			}//if
		}//else
	
	/* STILL MISSING:
	property restrictions
	
	**/
	}//function
	
	/**
	@returns Erfurt_OWL_StructuredClass LIST
	**/
	public function getEquivalentClasses($ErfurtOWLClass){
		
		$list=$ErfurtOWLClass->listEquivalentClasses();
		$ret=array();
		//print_r(array_keys($list));
		
		foreach ($list as $one){
		
			$ret[]=$this->convertErfurtClass($one);
		}
		
		return $ret;
	}// function
	
	/**
		@returns Erfurt_OWL_StructuredClass LIST
	**/
	public function getSubclassOfClasses($ErfurtOWLClass){
		$list=$ErfurtOWLClass->listSuperClasses();
		$ret=array();
		//print_r(array_keys($list));

		foreach ($list as $one){

			$ret[]=$this->convertErfurtClass($one);
		}
			
		return $ret;
	
	}
	
	/**
		@returns Erfurt_OWL_StructuredClass LIST
	**/
	public function getDisjointWithClasses($ErfurtOWLClass){
		$list=$ErfurtOWLClass->listDisjointWith();
		$ret=array();
		//print_r(array_keys($list));

		foreach ($list as $one){

			$ret[]=$this->convertErfurtClass($one);
		}
				
		return $ret;
	
	
	}
	/**
		@returns Structured_Axiom List
	**/
	public function convertErfurtModel($ErfurtOWLModel){
		$Erfurt_OWL_Class_List=$ErfurtOWLModel->listClasses();
		//$Erfurt_OWL_Class_List_Keys=array_keys($Erfurt_OWL_Class_List);
		
		
		$axioms=array();
		foreach ($Erfurt_OWL_Class_List as $Erfurt_OWL_Class){
			
		//	print_r($Erfurt_OWL_Class);
			//this step is not needed everytime- remove for optimization
			$Actual_Structured_Class=$this->convertErfurtClass($Erfurt_OWL_Class);
	
			//Axiome
		
			$Structured_Class_Array=$this->getDisjointWithClasses($Erfurt_OWL_Class);
			foreach($Structured_Class_Array as $Structured_Class){
				$axioms[]=new Erfurt_Owl_Structured_AxiomDisjointClasses($Actual_Structured_Class,$Structured_Class);
				}

			$Structured_Class_Array=$this->getEquivalentClasses($Erfurt_OWL_Class);
			foreach($Structured_Class_Array as $Structured_Class){
				$axioms[]=new Erfurt_Owl_Structured_AxiomEquivalence($Actual_Structured_Class,$Structured_Class);
				}

			$Structured_Class_Array=$this->getSubclassOfClasses($Erfurt_OWL_Class);
			foreach($Structured_Class_Array as $Structured_Class){
				$axioms[]=new Erfurt_Owl_Structured_AxiomSubclass($Actual_Structured_Class,$Structured_Class);
				}

			
		
		}//end outer foreach
		
		return $axioms;
	}
	
	
	
	/*public function isBlankNode($OWLClass){
		if(strpos($OWLClass->getURI(),"ode")==1){
			return true;
		}
		else return false;
	
	}*/
	
	public function p($string,$array){
			if($this->debug_flag){
				echo $string;
				print_r( array_keys($array));
			}
	}



	// returns structured class
	// WARNING reads the definition recursively until NamedClasses are found
	/*
	public function convert($OWLClass,$first=true)
	{
		if($first==true)
		{	
			if($this->isBlankNode($OWLClass)) 
			{	throw new Exception("blank nodes cannot be converted yet");
			}//if
			else 
			{	//echo $OWLClass->getURI()."notablanknode";
				$structClass=new Erfurt_Owl_Structured_NamedClass($OWLClass->getURI());
			//***initialize Axioms***
			
			
			//***SubclassOf***
				$superClasses=$OWLClass->listSuperClasses();
				$this->p("superClasses\n",$superClasses);
				$tmpStruct=array();
				foreach($superClasses as $one)
				{
					$structClass->addSubclassOf($this->convert($one,false));
				}//foreach
				
			//***Equivalent***
				//!!!!CHECK IF BLANKNODES ARE RETURNED
				$equiClasses=$OWLClass->listEquivalentClasses() ;
				$this->p("equivalentClasses\n",$equiClasses);
				$tmpStruct=array();
				foreach($equiClasses as $one)
				{
					$structClass->addEquivalentClass($this->convert($one,false));
				}//foreach
				$int=$OWLClass->listIntersectionOf();
				$this->p("intersectionClasses\n",$int);
    			$uni=$OWLClass->listUnionOf();
    			$this->p("UnionClasses\n",$uni);
    			   			
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
				
				
				
			//***Disjoints***
				//!!!!CHECK IF BLANKNODES ARE RETURNED
				$disjointClasses=$OWLClass->listDisjointWith();
				$this->p("disjointClasses\n",$disjointClasses);
				$tmpStruct=array();
				foreach($disjointClasses as $one)
				{
					$structClass->addDisjointWith($this->convert($one,false));
				}//foreach
				$comp=$OWLClass->listComplementOf();
				$this->p("complementClasses\n",$comp);
				foreach($comp as $one)
				{
					$structClass->addDisjointWith($this->convert($one,false));
				}//foreach
				
				return $structClass;
				
			}//else
	
		}//if(first)
		else
		{
			
			if($this->isBlankNode($OWLClass))
			{  
				//echo $OWLClass->getURI();
				//classify this blanknode
				$int=$OWLClass->listIntersectionOf();
				//print_r($OWLClass->listPropertyValues("owl:intersectionOf",'Class'));
				echo "|".$OWLClass->getURI()."|\n";
				echo "|".$OWLClass->isBlankNode()."|\n";
				$this->p("blanknode",$int);
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

*/

}//class
?>