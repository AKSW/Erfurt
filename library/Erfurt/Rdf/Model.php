<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Represents a basic RDF graph and some functionality that goes beyond RDF.
 *
 * @category Erfurt
 * @package  Erfurt_Rdf
 * @author   Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author   Norman Heino <norman.heino@gmail.com>
 * @author   Natanael Arndt <arndtn@gmail.com>
 * @author   Sebastian Tramp <mail@sebastian.tramp.name>
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
     * An array containing options for the graph stored in the system ontology.
     * @var array
     */
    protected $_graphOptions = null;

    /**
     * The model IRI
     * @var string
     */
    protected $_graphUri = null;

    /**
     * Erfurt namespace management module
     * @var Erfurt_Namespaces
     */
    protected $_namespaces = null;

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

    /**
     * Erfurt Store Object
     * @var Erfurt_Store
     */
    protected $_store = null;

    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @param string       $modelIri The IRI identifier of the Model
     * @param string       $baseIri  The IRI base for creating resources etc.
     * @param Erfurt_Store $store    The used store object
     */
    public function __construct($modelIri, $baseIri = null, $store = null)
    {
        $this->_graphUri = $modelIri;
        $this->_baseIri  = $baseIri;

        $config = Erfurt_App::getInstance()->getConfig();
        if (isset($config->properties->title)) {
            $this->_titleProperties = $config->properties->title->toArray();
        }

        if ($store != null) {
            $this->_store = $store;
        }

        // namespace module
        $this->_namespaces = Erfurt_App::getInstance()->getNamespaces();
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
     * @param string $subject   The subject resource URI
     * @param string $predicate The predicate resource URI
     * @param array  $object    The object array
     *
     * @return Erfurt_Rdf_Model
     */
    public function addStatement($subject, $predicate, array $object)
    {
        $this->getStore()->addStatement(
            $this->_graphUri, $subject, $predicate, $object
        );

        return $this;
    }

    /**
     * Adds multiple statements to this model.
     *
     * Accepts an associative array of statement subjects. The format of the
     * array must conform to Talis' RDF/PHP specification
     * ({@link http://n2.talis.com/wiki/RDF_PHP_Specification}).
     *
     * @param stdClass $statements Statements array (?)
     * @param bool     $useAc      use Access Control or not
     *
     * @return Erfurt_Rdf_Model
     */
    public function addMultipleStatements(array $statements, $useAc = true)
    {
        $this->getStore()->addMultipleStatements(
            $this->_graphUri, $statements, $useAc
        );

        return $this;
    }

    /**
     * Creates a unique resource URI with the model's base URI as namespace and
     * a unique ID starting with $spec.
     *
     * @param string $spec IRI part between base URI and local resource name
     *
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
     * @param mixed $subject   Subject spec (string or null)
     * @param mixed $predicate Predicate spec (string or null)
     * @param mixed $object    Object spec (string or null)
     *
     * @return void
     */
    public function deleteStatement($subject, $predicate, $object)
    {
        $this->getStore()->deleteMatchingStatements(
            $this->_graphUri, $subject, $predicate, $object
        );
    }

    /**
     * Deletes all statements contained in the associative array from this model.
     *
     * @param array $statements Statements Array
     * @param bool  $useAc      use Access Control or not
     *
     * @return void
     */
    public function deleteMultipleStatements(array $statements, $useAc = true)
    {
        $this->getStore()->deleteMultipleStatements(
            $this->_graphUri, $statements, $useAc
        );
    }

    /**
     * Deletes all statements that match a certain triple pattern.
     *
     * The triple patterns is denoted by subject, predicate, object
     * where one or two can be <code>null</code>.
     *
     * @param string|null $subjectSpec   Subject spec
     * @param string|null $predicateSpec Predicate spec
     * @param string|null $objectSpec    Object spec
     * @param array       $options       Options Array
     *
     * @return void
     */
    public function deleteMatchingStatements(
        $subjectSpec, $predicateSpec, $objectSpec, array $options = array()
    )
    {
        $this->getStore()->deleteMatchingStatements(
            $this->_graphUri, $subjectSpec, $predicateSpec, $objectSpec, $options
        );
    }

    /**
     * Returns the model base IRI
     *
     * @return string
     */
    public function getBaseIri()
    {
        if (empty($this->_baseIri)) {
            return $this->getModelIri();
        }

        return $this->_baseIri;
    }

    /**
     * Returns the Base IRI
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->getBaseIri();
    }

    /**
     * Returns the model IRI
     *
     * @return string
     */
    public function getModelIri()
    {
        return $this->_graphUri;
    }

    /**
     * Returns the model URI
     *
     * @return string
     */
    public function getModelUri()
    {
        return $this->getModelIri();
    }

    /**
     * Returns an array of options (the object part of an RDF/PHP array) or null
     * if no such options exists. An option is identified through an URI.
     *
     * @param string $optionUri The URI that identifies the option.
     *
     * @return array|null An array containing the value(s) for the given option.
     */
    public function getOption($optionUri)
    {
        $options = $this->_getOptions();

        if (!isset($options[$optionUri])) {
            return null;
        } else {
            return $options[$optionUri];
        }
    }

    /**
     * Resource factory method
     *
     * @param string $resourceIri Resource IRI
     *
     * @return Erfurt_Rdf_Resource
     */
    public function getResource($resourceIri)
    {
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

                $query = Erfurt_Sparql_SimpleQuery::initWithString(
                    'SELECT ' . $select . ' WHERE { ' .
                    implode(' UNION ', $where) .
                    ' FILTER (sameTerm(?s, <' . $this->getModelIri() . '>)) }'
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
     * @param boolean $editableFlag editable (true) or not editable (false)
     *
     * @return Erfurt_Rdf_Model
     */
    public function setEditable($editableFlag)
    {
        $this->_isEditable = (boolean) $editableFlag;
        return $this;
    }

    /**
     * Moves resource to new URI
     * renaming all occurences of the resource.
     *
     * @param string $oldUri The URI that identifies the resource.
     * @param string $newUri The URI to move resource to.
     *
     * @return void
     */
    public function renameResource($oldUri, $newUri)
    {
        $query = new Erfurt_Sparql_Query2();
        $query->setDistinct(true);

        $vars = array();
        foreach (array('s', 'p', 'o') as $varName) {
            $vars[$varName] = new Erfurt_Sparql_Query2_Var($varName);
            $query->addProjectionVar($vars[$varName]);
        }

        $oldUriRef = new Erfurt_Sparql_Query2_IriRef($oldUri);

        $union = new Erfurt_Sparql_Query2_GroupOrUnionGraphPattern();
        foreach ($vars as $var) {
            $group = new Erfurt_Sparql_Query2_GroupGraphPattern();
            $group->addTriple($vars['s'], $vars['p'], $vars['o']);
            $group->addFilter(new Erfurt_Sparql_Query2_sameTerm($var, $oldUriRef));
            $union->addElement($group);
        }
        $query->addElement($union);
        $result = $this->sparqlQuery($query, array('result_format' => 'extended'));

        $removed = array();
        $added   = array();

        foreach ($result['results']['bindings'] as $s) {
            // result format from sparqlQuery
            // isn't the same as format for delete/addMultipleStatements
            if (array_key_exists('xml:lang', $s['o'])) {
                $s['o']['lang'] = $s['o']['xml:lang'];
                unset($s['o']['xml:lang']);
            }

            $removed[$s['s']['value']][$s['p']['value']][] = $s['o'];

            foreach (array('s', 'p', 'o') as $varName) {
                if ( $s[$varName]['type'] === 'uri'
                    && $s[$varName]['value'] === $oldUri
                ) {
                    $s[$varName]['value'] = $newUri;
                }
            }

            $added[$s['s']['value']][$s['p']['value']][] = $s['o'];
        }

        $this->deleteMultipleStatements($removed);
        $this->addMultipleStatements($added);
    }

    /**
     * Sets an option for the model in the SysOnt.
     * If no value is given, the option will be unset.
     *
     * @param string     $optionUri The URI that identifies the option.
     * @param array|null $value     An array (RDF/PHP object part) of values or null.
     * @param bool       $replace   Replace (true) or do not replace (false) value
     *
     * @return void
     */
    public function setOption($optionUri, $value = null, $replace = true)
    {
        if (!$this->_isEditable) {
            // User has no right to edit the model.
            return;
        }

        $sysOntUri = Erfurt_App::getInstance()->getConfig()->sysont->modelUri;

        $options = $this->_getOptions();

        if ($replace && isset($options[$optionUri])) {
            // In this case we need to remove the old values from sysont
            $options = array(
                // We disable AC, for we need to write the system ontology.
                'use_ac' => false
            );

            $this->getStore()->deleteMatchingStatements(
                $sysOntUri, $this->_graphUri, $optionUri, null, $options
            );
        }

        if (null !== $value) {
            $addArray = array();
            $addArray[$this->_graphUri] = array();
            $addArray[$this->_graphUri][$optionUri] = $value;

            $this->getStore()->addMultipleStatements($sysOntUri, $addArray, false);
        }

        // Reset the options
        $this->_graphOptions = null;
    }

    /**
     * Updates this model if the mutual difference of 2 RDF/PHP arrays.
     *
     * Added statements are those that are found in $changed but not in $original,
     * removed statements are found in $original but not in $changed.
     *
     * @param array $original original PHP RDF Statements array
     * @param array $changed  new PHP RDF Statements array
     * @param bool  $useAc    use Access Control or not
     *
     * @return Erfurt_Rdf_Model
     */
    public function updateWithMutualDifference(
        array $original, array $changed, $useAc = true
    )
    {
        $addedStatements   = self::getStatementsDiff($changed, $original);
        $removedStatements = self::getStatementsDiff($original, $changed);

        if (defined('_EFDEBUG')) {
            $logger = Erfurt_App::getInstance()->getLog();

            $logger->debug('added: ', count($addedStatements));
            $logger->debug('removed: ', count($removedStatements));
        }

        $this->deleteMultipleStatements($removedStatements, $useAc);
        $this->addMultipleStatements($addedStatements, $useAc);

        return $this;
    }

    // ------------------------------------------------------------------------
    // --- Private/protected methods ------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Sets the internal options array for the model (if neccessary) and returns it.
     * The options are actually fetched by the store class.
     *
     * @return array An array of all options. If there are no options for the model
     * an empty array is returned.
     */
    protected function _getOptions()
    {
        if (null === $this->_graphOptions) {
            $this->_graphOptions = $this->getStore()
                ->getGraphConfiguration($this->_graphUri);
        }

        return $this->_graphOptions;
    }

    /**
     * Calculates the difference of two RDF/PHP arrays.
     *
     * The difference will contain any statement in the first object that
     * is not contained in the second object.
     *
     * @param array $first  RDF/PHP statements array
     * @param array $second RDF/PHP statements array
     *
     * @return array a RDF/PHP array the complement of the intersection
     */
    public static function getStatementsDiff(array $first, array $second)
    {
        $difference = array();

        // check for each subject if it is found in object 2
        // if it is not, continue immediately
        foreach ($first as $subject => $predicatesArray) {
            if (!array_key_exists($subject, $second)) {
                $difference[$subject] = $first[$subject];
                continue;
            }

            // check for each predicate if it is found in the current
            // subject's predicates of object 2, if it is not, continue immediately
            foreach ($predicatesArray as $predicate => $objectsArray) {
                if (!array_key_exists($predicate, $second[$subject])) {
                    $difference[$subject][$predicate] = $first[$subject][$predicate];
                    continue;
                }

                // for each object we have to check if it exists in objectTwo
                // (subject and predicate are identical up here)
                foreach ($objectsArray as $key => $object) {
                    $found = false;
                    foreach ($second[$subject][$predicate] as $objectTwo) {
                        if ($object['type'] == $objectTwo['type']
                            && $object['value'] == $objectTwo['value']
                        ) {
                            if (isset($object['datatype'])) {
                                if (isset($objectTwo['datatype'])
                                    && $object['datatype'] === $objectTwo['datatype']
                                ) {
                                    $found = true;
                                }
                            } else {
                                if (!isset($objectTwo['datatype'])) {
                                    if (isset($object['lang'])) {
                                        if (isset($objectTwo['lang'])
                                            && $object['lang'] === $objectTwo['lang']
                                        ) {
                                            $found = true;
                                        }
                                    } else {
                                        if (!isset($objectTwo['lang'])) {
                                            $found = true;
                                        }
                                    }
                                }
                            }
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
                            $first[$subject][$predicate][$key]
                        );
                    }
                }
            }
        }

        return $difference;
    }

    /**
     * Performs an sparql query on the model using the stores sparqlQuery
     * method and returning the resultset
     * Returns a result depending on the query, e.g. an array or a boolean value.
     *
     * @param mixed $query   The query, as string or object (SimpleQuery or Query2)
     * @param array $options options array
     *
     * @return mixed
     **/
    public function sparqlQuery($query, $options = array())
    {
        $defaultOptions = array(
            Erfurt_Store::RESULTFORMAT => Erfurt_Store::RESULTFORMAT_PLAIN
        );

        $options = array_merge($defaultOptions, $options);

        // Do not allow disabling of ac here!
        $options[Erfurt_Store::USE_AC] = true;

        if (is_string($query)) {
            $query = Erfurt_Sparql_SimpleQuery::initWithString($query);
        }

        // restrict to this model
        if ($query instanceof Erfurt_Sparql_SimpleQuery) {
            $query->setFrom(array($this->_graphUri));
        } elseif ($query instanceof Erfurt_Sparql_Query2) {
            $query->setFroms(array($this->_graphUri));
        }

        return $this->getStore()->sparqlQuery($query, $options);
    }

    /*public function sparqlQueryWithPlainResult($query)
    {
        $queryObject = Erfurt_Sparql_SimpleQuery::initWithString($query);
        $queryObject->addFrom($this->_graphUri);

        return $this->getStore()->sparqlQuery($queryObject);
    }*/

    /**
     * set the model store
     *
     * @param Erfurt_Store $store The store object
     *
     * @return void
     */
    public function setStore(Erfurt_Store $store)
    {
        $this->_store = $store;
    }

    /**
     * get the model store
     *
     * @return Erfurt_Store
     */
    public function getStore()
    {
        if (null === $this->_store) {
            // backwards compatibility
            $this->_store = Erfurt_App::getInstance()->getStore();
        }

        return $this->_store;
    }

    /**
     * Returns an array of namespace IRIs (keys) and prefixes defined
     * in this model's source file.
     *
     * @return array
     * @deprecated
     */
    public function getNamespaces()
    {
        return array_flip($this->getNamespacePrefixes());
    }

    /**
     * Add a namespace -> prefix mapping
     *
     * @param string $prefix    a prefix to identify the namespace
     * @param string $namespace the namespace uri
     *
     * @deprecated
     *
     * @return void
     */
    public function addPrefix($prefix, $namespace)
    {
        return $this->addNamespacePrefix($prefix, $namespace);
    }

    /**
     * Get all namespaces with there prefix
     *
     * @return array with namespace as key and prefix as value
     */
    public function getNamespacePrefixes()
    {
        // return $this->getStore()->getNamespacePrefixes($this->_graphUri);

        return $this->_namespaces->getNamespacePrefixes($this->getModelUri());
    }

    /**
     * Get the prefix for one namespaces, will be created if no prefix exists
     *
     * @param string $namespace the namespace uri
     *
     * @return array with namespace as key and prefix as value
     */
    public function getNamespacePrefix($namespace)
    {
        return $this->_namespaces->getNamespacePrefix(
            $this->getModelUri(), $namespace
        );
    }

    /**
     * Add a namespace -> prefix mapping
     *
     * @param string $prefix    a prefix to identify the namespace
     * @param string $namespace the namespace uri
     *
     * @return result of addNamespacePrefix method of Erfurt_Namespace
     */
    public function addNamespacePrefix($prefix, $namespace)
    {
        return $this->_namespaces->addNamespacePrefix(
            $this->getModelUri(), $namespace, $prefix
        );
    }

    /**
     * Delete a namespace -> prefix mapping
     *
     * @param string $prefix the prefix you want to remove
     *
     * @return result of deleteNamespacePrefix method of Erfurt_Namespace
     */
    public function deleteNamespacePrefix($prefix)
    {
        return $this->_namespaces->deleteNamespacePrefix(
            $this->getModelUri(), $prefix
        );
    }

    /**
     * check if a namespace prefix is registered and return the namespace uri
     *
     * @param string $prefix the prefix you want to query
     *
     * @throws Erfurt_Namespace_Exception if the namespace is not registered
     *
     * @return string
     */
    public function getNamespaceByPrefix($prefix)
    {
        return $this->_namespaces->getNamespaceByPrefix(
            $this->getModelUri(), $prefix
        );
    }

    /**
     * check if a namespace prefix is registered and returns true or false
     *
     * @param string $prefix prefix you want to query
     *
     * @return bool
     */
    public function hasNamespaceByPrefix($prefix)
    {
        return $this->_namespaces->hasNamespaceByPrefix(
            $this->getModelUri(), $prefix
        );
    }

}
