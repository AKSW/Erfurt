<?php

class Erfurt_Rdf_StoreStub
{    
    public $addMultipleStatements = null;
    public $deleteMultipleStatements = null;
    
    public function addMultipleStatements($graphIri, stdClass $statements)
    {
        $this->addMultipleStatements = $statements;
    }
    
    public function deleteMultipleStatements($graphIri, stdClass $statements)
    {
        $this->deleteMultipleStatements = $statements;
    }
}



