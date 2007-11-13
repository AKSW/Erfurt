<?php
//  Interface ReasoningTasks mit Methoden subsumption, instanceCheck,
//   retrieval...



/**
 * @package reasoning
 */
interface Erfurt_Reasoning_ReasoningTasks {


// Retrieval
public function allConceptNames ();
public function allRoleNames ();
public function allIndividuals ();


// Satisfiability

public function satisfiable ($concept);
public function subsumes ($concept1, $concept2);
public function disjoint ($concept1, $concept2);

// Concept Hierarchy

public function parents ($concept);
public function children ($concept);
public function ancestors ($concept);
public function descendants ($concept);
public function equivalents ($concept);

//Role Hierarchy

public function rparents ($role);
public function rchildren ($role);
public function rancestors ($role);
public function rdescendants($role);

// Individual Queries

public function instances ($concept);
public function types ($instance);
public function instance ($instance, $concept);
public function roleFillers ($instance, $role);
public function relatedIndividuals ($role);
public function toldvalues ($instance, $atom);



}
?>