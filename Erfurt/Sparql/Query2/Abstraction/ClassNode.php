<?php
require_once "Link.php";

//under construction
class Erfurt_Sparql_Query2_Abstraction_ClassNode 
{
	protected $shownproperties;
	
	protected $type;
	protected $classVar;
	
	protected $outgoinglinks;
	protected $query;
	protected $optionalpart;
	
	public function __construct(Erfurt_Sparql_Query2_Abstraction_RDFSClass $type, Erfurt_Sparql_Query2 $query){
		$this->type = $type;
		$this->query = $query;
		$this->classVar = new Erfurt_Sparql_Query2_Var($type->iri);
		$this->query->getPattern()->addElement(new Erfurt_Sparql_Query2_Triple($this->classVar, new Erfurt_Sparql_Query2_A(), $type->iri));
	}
	
	public function addShownProperty(Erfurt_Sparql_Query2_IriRef $prop){
		if(count($this->shownproperties) == 0){
			$this->optionalpart = new Erfurt_Sparql_Query2_OptionalGraphPattern();
		}
		$this->shownproperties[] = $prop;
		$var = new Erfurt_Sparql_Query2_Var($prop);
		$this->optionalpart->addElement(new Erfurt_Sparql_Query2_Triple($this->classVar, $prop, $var));
		$this->query->getPattern()->addElement($this->optionalpart);
		$this->query->addProjectionVar($var);
		return $this; //for chaining
	}
	
	public function addLink(Erfurt_Sparql_Query2_IriRef $predicate, Erfurt_Sparql_Query2_Abstraction_ClassNode $target){
		$this->outgoinglinks[] = new Erfurt_Sparql_Query2_Abstraction_Link($predicate, $target);
		$this->query->getPattern()->addElement(new Erfurt_Sparql_Query2_Triple($this->classVar, $predicate, new Erfurt_Sparql_Query2_Var($target->getClass()->iri)));
		return $this; //for chaining
	}
	
	public function getClass(){
		return $this->type;
	}
}
?>