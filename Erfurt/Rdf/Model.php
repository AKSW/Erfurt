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
        'http://www.w3.org/2001/XMLSchema#'           => 'xsd', 
        'http://ns.ontowiki.net/SysOnt/'              => 'SysOnt', 
        'http://purl.org/dc/elements/1.1/'            => 'dc', 
        'http://xmlns.com/foaf/0.1/'                  => 'foaf', 
        'http://usefulinc.com/ns/doap#'               => 'doap', 
        'http://xmlns.com/wordnet/1.6/'               => 'wordnet', 
        'http://www.w3.org/2004/02/skos/core#'        => 'skos', 
        'http://rdfs.org/sioc/ns#'                    => 'sioc', 
        'http://swrc.ontoware.org/ontology#'          => 'swrc', 
        'http://ns.aksw.org/e-learning/lcl/'          => 'lcl', 
        'http://www.w3.org/2003/01/geo/wgs84_pos#'    => 'geo', 
        // 'nodeID://'                                   => '_'
    );
    
    /**
     * The model's title property value
     * @var string
     */
    protected $_title = null;
    
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
    
    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
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
     * Returns a string representing the model instance. For convenience
     * reasons this is in fact the model IRI.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getModelIri();
    }
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Adds a statement to this model
     *
     * @param string $subject
     * @param string $predicate
     * @param string $object
     * @param array $options
     */
    public function addStatement($subject, $predicate, $object, $options = array(), $useAcl = true)
    {   
        $this->getStore()->addStatement($this->_modelIri, $subject, $predicate, $object, $options, $useAcl);
        
        return $this;
    }
    
    /**
     * Adds multiple statements to this model.
     *
     * Accepts an associative array of statement subjects. The format of the 
     * array must conform to Talis' RDF/PHP specification 
     * ({@link http://n2.talis.com/wiki/RDF_PHP_Specification}).
     *
     * @param stdClass $statements
     */
    public function addMultipleStatements(array $statements)
    {
        $this->getStore()->addMultipleStatements($this->_modelIri, $statements);
        
        return $this;
    }
    
    /**
     * Creates a unique resource URI with the model's base URI as namespace and
     * a unique ID starting with $spec.
     *
     * @param string $spec
     * @return string
     */
    public function createResourceUri($spec = '')
    {
        $prefix = $this->getBaseIri()
                . $spec;
        
        // TODO: check uniqueness
        $prefix .= uniqid();
        
        return $prefix;
    }
    
    /**
     * Deletes the statement denoted by subject, predicate, object.
     *
     * @param string $subject
     * @param string $predicate
     * @param string $object
     */
    public function deleteStatement($subject, $predicate, $object)
    {
        $this->getStore()->deleteMatchingStatements($this->_modelIri, $subject, $predicate, $object);
    }
    
    /**
     * Deletes all statements contained in the associative array from this model.
     *
     * @param string $subject
     * @param string $predicate
     * @param string $object
     */
    public function deleteMultipleStatements(array $statements)
    {
        $this->getStore()->deleteMultipleStatements($this->_modelIri, $statements);
    }
    
    /**
     * Deletes all statements that match a certain triple pattern.
     *
     * The triple patterns is denoted by subject, predicate, object
     * where one or two can be <code>null</code>.
     *
     * @param string|null $subjectSpec
     * @param string|null $predicateSpec
     * @param string|null $objectSpec
     */
    public function deleteMatchingStatements($subjectSpec, $predicateSpec, $objectSpec, $options = array())
    {
        $this->getStore()->deleteMatchingStatements($this->_modelIri, $subjectSpec, $predicateSpec, $objectSpec,
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
     * Resource factory method
     *
     * @return Erfurt_Rdf_Resource
     */
    public function getResource($resourceIri)
    {
        require_once 'Erfurt/Rdf/Resource.php';
        return new Erfurt_Rdf_Resource($resourceIri, $this);
    }
    
    /**
     * Returns the model's title property value.
     *
     * @return string
     */
    public function getTitle()
    {        
        if (null === $this->_title) {
            $titleProperties = $this->getTitleProperties();

            $select = '';
            $where  = array();
            
            if (!empty($titleProperties)) {
                foreach ($titleProperties as $key => $uri) {
                    $select .= ' ?' . $key;
                    $where[] = '{?s <' . $uri . '> ' . '?' . $key . '.}';
                }
                
                require_once 'Erfurt/Sparql/SimpleQuery.php';
                $query = Erfurt_Sparql_SimpleQuery::initWithString(
                    'SELECT ' . $select . '
                    WHERE {
                        ' . implode(' UNION ', $where) . '
                        FILTER (sameTerm(?s, <' . $this->getModelIri() . '>))
                    }'
                );
                
                if ($result = $this->getStore()->sparqlQuery($query)) {
                    if (is_array($result) && is_array($result[0])) {
                        foreach ($titleProperties as $key => $uri) {
                            if (!empty($result[0][$key])) {
                                $this->_title = $result[0][$key];
                            }
                            
                            continue;
                        }
                    }
                }
            }
        }
        
        return $this->_title;
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
     * Returns whether the current agent has edit privileges
     * on this model instance.
     *
     * @return bool
     */
    public function isEditable()
    {
        return $this->_isEditable;
    }
    
    /**
     * Sets this model's editable flag.
     *
     * @param boolean $editableFlag
     */
    public function setEditable($editableFlag)
    {
        $this->_isEditable = $editableFlag;
        
        return $this;
    }
    
    /**
     * Updates this model if the mutual difference of 2 RDF/PHP arrays.
     *
     * Added statements are those that are found in $changed but not in $original, 
     * removed statements are found in $original but not in $changed.
     *
     * @param stdClass statementsObject1
     * @param stdClass statementsObject2
     */
    public function updateWithMutualDifference(array $original, array $changed)
    {
        $addedStatements   = $this->_getStatementsDiff($changed, $original);
        $removedStatements = $this->_getStatementsDiff($original, $changed);        
        
        // var_dump('added: ', $addedStatements);
        // var_dump('removed: ', $removedStatements);
        // exit;
        
        $this->addMultipleStatements($addedStatements);
        $this->deleteMultipleStatements($removedStatements);
        
        return $this;
    }
    
    // ------------------------------------------------------------------------
    // --- Private/protected methods ------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Calculates the difference of two RDF/PHP arrays.
     *
     * The difference will contain any statement in the first object that
     * is not contained in the second object.
     *
     * @param stdClass statementsObject1
     * @param stdClass statementsObject2
     *
     * @return stdClass a RDF/JSON object
     */
    private function _getStatementsDiff(array $statementsObject1, array $statementsObject2)
    {
        $difference = array();
        
        // check for each subject if it is found in object 2
        // if it is not, continue immediately
        foreach ($statementsObject1 as $subject => $predicatesArray) {
            if (!array_key_exists($subject, $statementsObject2)) {
                $difference[$subject] = $statementsObject1[$subject];
                continue;
            }
            
            // check for each predicate if it is found in the current 
            // subject's predicates of object 2, if it is not, continue immediately
            foreach ($predicatesArray as $predicate => $objectsArray) {
                if (!array_key_exists($predicate, $statementsObject2[$subject])) {
                    $difference[$subject][$predicate] = $statementsObject1[$subject][$predicate];
                    continue;
                }
                
                // for each object we have to check if it exists in object 2
                // (subject and predicate are identical up here)
                foreach ($objectsArray as $key => $object) {
                    $found = false;
                    foreach ($statementsObject2[$subject][$predicate] as $object2) {
                        if ($object['type'] == $object2['type'] && $object['value'] == $object2['value']) {
                            $found = true;
                        }
                    }
                    
                    // if object hasn't been found, add it
                    if (!$found) {
                        if (!array_key_exists($subject, $difference)) {
                            $difference[$subject] = array();
                        }
                        
                        if (!array_key_exists($predicate, $difference[$subject])) {
                            $difference[$subject][$predicate] = array();
                        }
                        
                        array_push(
                            $difference[$subject][$predicate], 
                            $statementsObject1[$subject][$predicate][$key]
                        );
                    }
                }
            }
        }
        
        return $difference;
    }
    
    // ------------------------------------------------------------------------
    
    public function sparqlQueryWithPlainResult($query)
    {    
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($query);
        $queryObject->addFrom($this->_modelIri);
        
        return $this->getStore()->sparqlQuery($queryObject);
    }
    
    public function getStore()
    {    
        require_once 'Erfurt/App.php';
        return Erfurt_App::getInstance()->getStore();
    }
}
