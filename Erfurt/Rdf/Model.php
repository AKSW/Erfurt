<?php

/**
 * Represents a basic RDF graph and some functionality that goes beyond RDF.
 *
 * @package    rdf
 * @author     Philipp Frischmuth
 * @author     Norman Heino <norman.heino@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Rdf_Model
{
    /**
     * The model base IRI. If not set, defaults to the model IRI.
     * @var string
     */
    protected $_baseIri = null;
    
    /**
     * Denotes whether the model is editable by the current agent.
     * @var boolean
     */
    protected $_isEditable = false;
    
    /**
     * The model IRI
     * @var string
     */
    protected $_modelIri = null;
    
    /**
     * An array of namespace IRIs (keys) and prefixes 
     * @var array
     * @todo remove hard-coded mock namespaces
     */
    protected $_namespaces = array(
        'http://www.w3.org/1999/02/22-rdf-syntax-ns#' => 'rdf', 
        'http://www.w3.org/2000/01/rdf-schema#'       => 'rdfs', 
        'http://www.w3.org/2002/07/owl#'              => 'owl', 
        'http://ns.ontowiki.net/SysOnt/'              => 'SysOnt', 
        'http://purl.org/dc/elements/1.1/'            => 'dc', 
        'http://xmlns.com/foaf/0.1/'                  => 'foaf', 
        'http://usefulinc.com/ns/doap#'               => 'doap', 
        'http://xmlns.com/wordnet/1.6/'               => 'wordnet', 
        'http://www.w3.org/2004/02/skos/core#'        => 'skos', 
        'http://rdfs.org/sioc/ns#'                    => 'sioc', 
        'http://swrc.ontoware.org/ontology#'          => 'swrc', 
        'http://ns.aksw.org/e-learning/lcl/'          => 'lcl'
    );
    
    /**
     * An array of properties used in this model to express
     * a resource's human-readable representation.
     * @var array
     * @todo remove hard-coded mock title properties
     */
    protected $_titleProperties = array(
        'http://www.w3.org/2000/01/rdf-schema#label', 
        'http://purl.org/dc/elements/1.1/title'
    );
    
    /**
     * Constructor.
     *
     * @param string $modelIri
     * @param string $baseIri
     */ 
    public function __construct($modelIri, $baseIri = null) 
    {
        $this->_modelIri = $modelIri;
        $this->_baseIri  = $baseIri;
    }
    
    /**
     * Adds a statements to this model
     *
     * @param string $subject
     * @param string $predicate
     * @param string $object
     * @param array $options
     */
    public function addStatement($subject, $predicate, $object, $options)
    {   
        $this->getStore()->addStatement($this->_modelIri, 
                                        $subject, 
                                        $predicate, 
                                        $object, 
                                        $options);
    }
    
    /**
     * Returns the model base IRI
     *
     * @return string
     */
    public function getBaseIri()
    {
        if (null === $this->_baseIri) {
            return $this->_modelIri;
        }
        
        return $this->_baseIri;
    }
    
    /**
     * Returns the model IRI
     *
     * @return string
     */
    public function getModelIri() 
    {    
        return $this->_modelIri;
    }
    
    /**
     * Returns an array of namespace IRIs (keys) and prefixes defined
     * in this model's source file.
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->_namespaces;
    }
    
    /**
     * Returns an array of properties used in this model to express
     * a resource's human-readable representation.
     *
     * @return array
     */
    public function getTitleProperties()
    {
       return $this->_titleProperties; 
    }
    
    /**
     * Sets this model's editable flag.
     *
     * @param boolean $editableFlag
     */
    public function setEditable($editableFlag)
    {
        $this->_isEditable = $editableFlag;
    }
    
    // ------------------------------------------------------------------------
    
    public function sparqlQueryWithPlainResult($query)
    {    
        return $this->getStore()->executeSparql($this, $query);
    }
    
    public function getStore()
    {    
        require_once 'Erfurt/App.php';
        return Erfurt_App::getInstance()->getStore();
    }
    
    // kept for compatibility reason
    // TODO: remove
    public function __toString()
    {
        return $this->_modelIri;
    }
}
