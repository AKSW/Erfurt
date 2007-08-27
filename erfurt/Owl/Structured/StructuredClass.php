<?php

class Erfurt_Owl_Structured_StructuredClass 
{
	
	private $childClasses;
	// WARNING the following arrays are implicitly intersections
	private $equivalentClasses;
	private $subclassOfClasses;
	private $disjointWithClasses;
	private $URI;
	
	public function __construct($uri){
	
		$this->childClasses = array();
		$this->equivalentClasses = array();
		$this->subclassOfClasses = array();
		$this->disjointWithClasses = array();
		$this->URI=$uri;
	}
	
	public function addChildClass($structuredClass){
		$this->childClasses[]=$structuredClass;
		//echo "adding child ".$structuredClass."\n";
	}
	public function addChildClasses($arrayStructuredClass){
		foreach($arrayStructuredClass as $one){
			$this->childClasses[]=$one;
		}
	}
	public function getChildClasses(){
		return $this->childClasses;
	}

	//toTreeString
	public function printChildClasses(){
		return $this->childClasses; //return string structured
	}

	public function toString($depth=0){
		$tab=str_repeat("\t",$depth);
		if(sizeof($this->URI)>=1)echo $tab.$this->URI."\n";
		//echo get_class($this);
		
		
		foreach ($this->childClasses as $one){
					echo $tab."has ChildClasses: \n".$tab.$one->toString();
		}
		foreach ($this->equivalentClasses as $one){
					echo $tab."has EquivalentClass: \n".$tab.$one->toString();
		}
		foreach ($this->subclassOfClasses as $one){
					echo $tab."has SubclassOfClasses: \n".$tab.$one->toString();
		}
		foreach ($this->disjointWithClasses as $one){
			echo $tab."has disjointWithClasses: \n".$tab.$one->toString();
		}
	}
	
	public function getURI(){
		return $this->URI;
	}
	
	public function addEquivalentClass($structuredClass){
		$this->equivalentClasses[]=$structuredClass;
		//echo "adding child ".$structuredClass."\n";
	}
	public function getEquivalentClasses(){
		return $this->equivalentClasses;
	}
	
	public function addSubclassOf($structuredClass){
			$this->subclassOfClasses[]=$structuredClass;
			//echo "adding child ".$structuredClass."\n";
	}
	public function getSubclassOf(){
			return $this->subclassOfClasses;
	}
	
	public function addDisjointWith($structuredClass){
			$this->disjointWithClasses=$structuredClass;
			//echo "adding child ".$structuredClass."\n";
		}
		public function getDisjointWith(){
			return $this->disjointWithClasses;
	}

	
	
}
?>