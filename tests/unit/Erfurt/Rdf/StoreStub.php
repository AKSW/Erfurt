<?php

class Erfurt_Rdf_StoreStub
{    
    public $addMultipleStatements = null;
    public $deleteMultipleStatements = null;
    
    public function addMultipleStatements($graphIri, array $statements)
    {
        $this->addMultipleStatements = $statements;
    }
    
    public function deleteMultipleStatements($graphIri, array $statements)
    {
        $this->deleteMultipleStatements = $statements;
    }
}



