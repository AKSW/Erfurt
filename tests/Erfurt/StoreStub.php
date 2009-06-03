<?php
class Erfurt_StoreStub
{   
    public $statements = array();
     
    public function addStatement($graphUri, $subject, $predicate, array $object, $useAc = true)
    {
        if (!isset($this->statements[$graphUri])) {
            $this->statements[$graphUri] = array();
        }
        
        if (!isset($this->statements[$graphUri][$subject])) {
            $this->statements[$graphUri][$subject] = array();
        }
        
        if (!isset($this->statements[$graphUri][$subject][$predicate])) {
            $this->statements[$graphUri][$subject][$predicate] = array();
        }
        
        $this->statements[$graphUri][$subject][$predicate][] = $object;
    }
}
