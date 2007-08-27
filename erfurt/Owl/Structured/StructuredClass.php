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

	public function initialToString(){
		
		$depth=0;
		$ret=$this->URI."\n";
		$tab=str_repeat("-",$depth).">";
		foreach ($this->equivalentClasses as $one){
			$ret.= $tab."E:".$tab.$one->toString($depth)."\n";
		}
		foreach ($this->subclassOfClasses as $one){
			$ret.= $tab."S:".$tab.$one->toString($depth)."\n";
		}
		foreach ($this->disjointWithClasses as $one){
			$ret.=  $tab."D:".$tab.$one->toString($depth)."\n";
		}
		foreach ($this->childClasses as $one){
			$ret.=$tab."C:".$tab.$one->toString($depth++)."\n";
		}
		
		return $ret;
	}
	
	public function toString($depth=0){
		$tab=str_repeat("-",$depth).">";
		$ret="";
		foreach ($this->childClasses as $one){
			 $ret.=$tab."C:".$tab.$one->toString($depth++);
		}
		return $ret;
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
			$this->disjointWithClasses[]=$structuredClass;
			//echo "adding child ".$structuredClass."\n";
		}
		public function getDisjointWith(){
			return $this->disjointWithClasses;
	}

	
	
}
?>