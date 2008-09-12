<?php

require_once 'Erfurt/Rdf/Model.php';

class Erfurt_Rdfs_Model extends Erfurt_Rdf_Model
{
    /**
     * Resource factory method
     *
     * @return Erfurt_Rdfs_Resource
     */
    public function getResource($resourceIri)
    {
        require_once 'Erfurt/Rdfs/Resource.php';
        return new Erfurt_Rdfs_Resource($resourceIri, $this);
    }
}

