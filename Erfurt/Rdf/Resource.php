<?php

require_once 'Erfurt/Rdf/Node.php';

/**
 * Represents a basic RDF resource.
 *
 * @package    rdf
 * @author     Philipp Frischmuth
 * @author     Norman Heino <norman.heino@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Rdf_Resource extends Erfurt_Rdf_Node
{
    /**
     * The mode to which this resource belongs.
     * @var Erfurt_Rdf_Model
     */
    protected $_model = null;
    
    /**
     * The name of the resource (either a IRI or a local name)
     * @var string
     */
    protected $_name = null;
    
    /**
     * The namespace this resource's IRI is contained in.
     * @var string
     */
    protected $_namespace = null;
    
    /**
     * A namespace prefix.
     * @var string
     */
    protected $_prefix = null;
    
    /**
     * Delimiter between namespace prefix and local name.
     * @var string
     */
    protected $_qualifiedNameDelimiter = ':';
    
    /**
     * Constructor
     *
     * @param string $iri
     * @param Erfurt_Rdf_Model $model
     */
    public function __construct($iri, Erfurt_Rdf_Model $model)
    {
        $this->_model = $model;
        $namespaces   = $this->_model->getNamespaces();
        $matches      = array();
        
        // parse namespace/local part
        preg_match('/^(.+[#\/])(.+[^#\/])$/', $iri, $matches);
        
        $flag = false;
        
        if (count($matches) >= 3) {
            // match namespace
            if (array_key_exists($matches[1], $namespaces)) {
                $flag = true;
                $this->_namespace = $matches[1];
                $this->_name      = $matches[2];
                $this->_prefix    = $namespaces[$this->_namespace];
            }
        }
        
        // no namespace found/matched
        if (!$flag) {
            $this->_name = $iri;
        }
    }
    
    /**
     * Returns a string representation of this resource.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getIri();
    }
    
    /**
     * Returns the resource's IRI
     *
     * @return string
     */
    public function getIri()
    {
        return $this->_namespace . $this->_name;
    }
    
    /**
     * Returns a qualified name for the resource or null.
     *
     * @return string|null
     */
    public function getQualifiedName()
    {
        if ($this->_prefix) {
            $qName = $this->_prefix 
                   . $this->_qualifiedNameDelimiter
                   . $this->_name;
            
            return $qName;
        }
    }
}
