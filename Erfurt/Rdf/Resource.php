<?php

require_once 'Erfurt/Rdf/Node.php';

/**
 * Represents a basic RDF resource.
 *
 * @package erfurt
 * @subpackage    rdf
 * @author     Philipp Frischmuth
 * @author     Norman Heino <norman.heino@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Rdf_Resource extends Erfurt_Rdf_Node
{
    /**
     * The model to which this resource belongs.
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
     * Human-readable representation of this resource.
     */
    protected $_title = null;
    
    protected $_isBlankNode = false;
    
    /**
     * Constructor
     *
     * @param string $iri
     * @param Erfurt_Rdf_Model $model
     */
    public function __construct($iri, Erfurt_Rdf_Model $model = null)
    {
        $this->_model = $model;
        $namespaces   = $this->_model ? $this->_model->getNamespaces() : array();
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
            } else {
                $flag = true;
                $this->_namespace = $matches[1];
                $this->_name      = $matches[2];
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
    
    public function getNamespace()
    {
        return $this->_namespace;
    }
    
    public function getLocalName()
    {
        return $this->_name;
    }
    
    /**
     * Returns a human-readable representation of this resource or false
     * if no suitable value has been found.
     *
     * @return string|false
     */
    public function getTitle()
    {
        if (null === $this->_title) {
            if ($this->_model) {
                $select = '';
                $where = array();
                
                // query for all title props
                foreach ($this->_model->getTitleProperties() as $key => $titleProp) {
                    $select .= ' ?' . $key;
                    $where[] = ' {<' . $this->getIri() . '> <' . $titleProp . '> ?' . $key . '}' . PHP_EOL;
                }
                $titleQuery = '
                    SELECT ' . $select . ' 
                    FROM <' . $this->_model->getModelIri() . '> 
                    WHERE {
                        ' . implode(' UNION ', $where) . '
                    }';
                
                // build query object
                include_once 'Erfurt/Sparql/SimpleQuery.php';
                $query = Erfurt_Sparql_SimpleQuery::initWithString($titleQuery);
                $store = $this->_model->getStore();
                
                // check all title props for values
                if ($result = $store->sparqlQuery($query)) {
                    foreach ($result as $row) {
                        foreach ($this->_model->getTitleProperties() as $key => $titleProp) {
                            if (!empty($row[$key])) {
                                $this->_title = $row[$key];
                                break(2);
                            }
                        }
                    }
                }
            }
            
            // still empty?
            if (empty($this->_title)) {
                $this->_title = false;
            }
        }
        
        return $this->_title;
    }
    
    // ------------------------------------------------------------------------
    
    public static function initWithIri($iri)
    {
        $resource = new self($iri);
        return $resource;
    }
    
    public static function initWithUri($uri)
    {
        $resource = new self($uri);
        return $resource;
    }
    
    public static function initWithNamespaceAndLocalname($namespace, $local)
    {
        $resource = new self($namespace . $local);
        return $resource;
    }
    
    public static function initWithBlankNode($id)
    {
        $resource = new self($id);
        $this->_isBlankNode = true;
        return $resource;
    }
    
    public function isBlankNode()
    {
        return $this->_isBlankNode;
    }
    
    public function getId()
    {
        // Alias for BlankNodes
        return $this->getIri();
    }
    
    public function getUri()
    {
        return $this->getIri();
    }
}
