<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */



/**
 * Represents a basic RDF resource.
 *
 * @category   Erfurt
 * @package    Erfurt_Rdf
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author     Norman Heino <norman.heino@gmail.com>
 */
class Erfurt_Rdf_Resource extends Erfurt_Rdf_Node
{
    /**
     * Maximum path length for the CBD.
     * @var int
     */
    const DESCRIPTION_MAX_DEPTH = 3;

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
     * Holds the CBD or null if no property has been queried.
     * @var array
     */
    protected $_description = null;

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
     * Whether this resource identifies a blank node
     * @var boolean
     */
    protected $_isBlankNode = false;

    /**
     * An optional locator for the resource.
     *
     * If this property is set, the value of it (a URL) is used, when data
     * for this resource should be fetched.
     *
     * @var string
     */
    protected $_locator = null;

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
        preg_match('/^(.+[#\/])(.*[^#\/])$/', $iri, $matches);

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
     * returns the serialized representation (string) of this resource according
     * to the notation parameter. It always uses the pretty format option
     * and the access control.
     *
     * @param string $notation the specified notation (see Erfurt_Syntax_RdfSerializer
     *  for possible arguments)
     *
     * @return string the representation of this resource in a specified notation
     */
    public function serialize($notation = 'xml')
    {
        $modelIri = $this->_model ? $this->_model->getModelIri() : "" ;
        require_once('Erfurt/Syntax/RdfSerializer.php');
        $serializer = Erfurt_Syntax_RdfSerializer::rdfSerializerWithFormat($notation);
        return $serializer->serializeResourceToString(
            $this->getIri(),
            $this->_model->getModelIri(),
            true
        );
    }

    /*
     * get the resource description of this resource
     *
     * @param array $options array of different options:
     *     Erfurt_Store::USE_AC=true|false - use access control
     *     maxDepth=int - how much blank node level
     *     fetchInverse - also fetch incoming properties
     *
     * @return RDF/PHP array description
     */
    public function getDescription($options = array())
    {
        // merge given options into default options
        $options = array_merge(
            array(
                'maxDepth'           => self::DESCRIPTION_MAX_DEPTH
            ), $options
        );

        $this->_description = Erfurt_App::getInstance()->getStore()->getResourceDescription(
            $this->getIri(),
            $this->_model ? $this->_model->getModelIri() : false,
            $options
        );

        return $this->_description;
    }

    /**
     * return a memory model based on the resource description
     *
     * @return Erfurt_Rdf_MemoryModel
     */
    public function getMemoryModel()
    {
        return new Erfurt_Rdf_MemoryModel($this->getDescription());
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
     * Returns an optional locator for the resource, or the IRI of it, if no
     * locator value was set.
     *
     * @return string
     */
    public function getLocator()
    {
        // If no locator was explicitly set, we return the IRIof the resource.
        if (null === $this->_locator) {
            return $this->getIri();
        }
        return $this->_locator;
    }

    /**
     * Set a locator URL for this resource.
     *
     * @param string $locator
     */
    public function setLocator($locator)
    {
       $this->_locator = $locator;
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
        return null;
    }

    public function getNamespace()
    {
        return $this->_namespace;
    }

    public function getLocalName()
    {
        return $this->_name;
    }

    protected function _fetchDescription($maxDepth)
    {
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?p ?o')
              ->setWherePart(sprintf('{<%s> ?p ?o . }', $this->getIri()));
        $description = array();
        $result = null ;
        if ($this->_model) {
            $result = $this->_model->sparqlQuery($query, array('result_format' => 'extended'));
        } else {
            $result = Erfurt_App::getInstance()->getStore()->sparqlQuery($query, array('result_format' => 'extended'));
        }

        if (($maxDepth > 0) && $result) {
            foreach ($result['results']['bindings'] as $row) {
                $property = $row['p']['value'];
                $this->_descriptionResource($property);

                $currentValue = array(
                    // typed-literal --> literal
                    // 'type' => str_replace('typed-', '', $row['o']['type']),
                    'type' => $row['o']['type'],
                    'value' => $row['o']['value']
                );

                if ($row['o']['type'] == 'uri') {
                    $this->_descriptionResource($row['o']['value']);
                } else if ($row['o']['type'] == 'typed-literal') {
                    $currentValue['type'] = 'literal';
                    $currentValue['datatype'] = $row['o']['datatype'];
                } else if (isset($row['o']['xml:lang'])) {
                    $currentValue['lang'] = $row['o']['xml:lang'];
                }

                if (!array_key_exists($property, $description)) {
                    $description[$property] = array();
                }

                array_push($description[$property], $currentValue);

                if ($row['o']['type'] === 'bnode') {
                    $nodeId  = $row['o']['value'];
                    $bNode   = self::initWithBlankNode($nodeId, $this->_model);
                    $nodeKey = sprintf('_:%s', $nodeId);

                    $description[$nodeKey] = $bNode->getDescription($maxDepth-1);
                }
            }
        }

        return array(
            $this->getIri() => $description
        );
    }

    protected function _descriptionResource($uri)
    {
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

    public static function initWithNamespaceAndLocalName($namespace, $local)
    {
        $resource = new self($namespace . $local);
        return $resource;
    }

    public static function initWithBlankNode($id, $model = null)
    {
        $resource = new self($id, $model);
        $resource->_isBlankNode = true;
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
