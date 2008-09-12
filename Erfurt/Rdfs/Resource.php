<?php

require_once 'Erfurt/Rdf/Resource.php';

class Erfurt_Rdfs_Resource extends Erfurt_Rdf_Resource
{
    protected $_title = null;
    
    public function getTitle()
    {
        if (!$this->_title) {
            // TODO: get title
            $this->_title = 'Resource Title';
        }
        
        return $this->_title;
    }
}

