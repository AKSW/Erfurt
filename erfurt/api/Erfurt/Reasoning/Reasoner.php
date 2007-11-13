<?php
//Interface Reasoner extends ReasoningTasks mit Methoden createKB,
//    releaseKB
require_once "ReasoningTasks.php";

interface Erfurt_Reasoning_Reasoner extends Erfurt_Reasoning_ReasoningTasks {

//returns the internal reasonerURI
public function createKB ($modelURI);
// intern oder extern??? momentan intern;
public function releaseKB ($releaseURI);

}
?>