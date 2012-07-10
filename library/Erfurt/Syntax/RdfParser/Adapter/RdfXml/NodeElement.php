<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @package Erfurt_Syntax_RdfParser_Adapter_RdfXml
 */
class Erfurt_Syntax_RdfParser_Adapter_RdfXml_NodeElement
{
    protected $_resource = null;
    protected $_isVolatile = false;
    protected $_liCounter = 1;
    
    public function __construct($resource)
    {
        $this->_resource = $resource;
    }
    
    public function getResource()
    {
        return $this->_resource;
    }
    
    public function setIsVolatile($isVolatile)
    {
        $this->_isVolatile = $isVolatile;
    }
    
    public function isVolatile()
    {
        return $this->_isVolatile;
    }
    
    public function getNextLiCounter()
    {
        return $this->_liCounter++;
    }
}
