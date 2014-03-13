<?php

/**
 * Provides implementations for most of the SPARQL related methods
 * that are used by Erfurt.
 *
 * Uses objects of type \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
 * to connect to a triple store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.02.14
 */
class Erfurt_Store_Adapter_Sparql_GenericSparqlAdapter implements \Erfurt_Store_Adapter_Interface
{

    /**
     * The SPARQL connector that is used internally.
     *
     * @var \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
     */
    protected $connector = null;

    /**
     * Contains IRIs of graphs that have been created in this request,
     * but which might not contain triples yet.
     *
     * The in-memory graph management is necessary, as models that are
     * created via createModel() would not be detected instantly otherwise.
     *
     * @var array(string) List of graph IRIs.
     */
    protected $currentlyCreatedGraphs = array();

    /**
     * Cached result of the query that determines the available graphs.
     *
     * These results will most likely not change during a request, therefore, it
     * makes sense to cache them.
     *
     * @var array(array(string=>string))|null
     */
    protected $cachedAvailableGraphs = null;

    /**
     * Creates a SPARQL adapter that uses the provided connector.
     *
     * @param Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector
     */
    public function __construct(\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * This method allows the backend to (re)initialize itself, e.g. when an import was done.
     */
    public function init()
    {
    }

    /**
     * @param string $graphUri
     * @param string $subject (IRI or blank node)
     * @param string $predicate (IRI, no blank node!)
     * @param array $object
     * @param array $options It is possible to disable automatic escaping special
     * characters (like \n) with the option: "escapeLiteral" and the possible values true and false.
     *
     * @throws Erfurt_Exception Throws an exception if adding of statements fails.
     */
    public function addStatement($graphUri, $subject, $predicate, array $object, array $options = array())
    {
        $this->connector->addTriple(
            $graphUri,
            new Erfurt_Store_Adapter_Sparql_Triple($subject, $predicate, $object)
        );
    }

    /**
     * Adds statements in an array to the graph specified by $graphIri.
     *
     * The statements are provided as multi-dimensional array:
     *
     *     array(
     *         'http://example.org/subject1' => array(
     *             'http://example.org/predicate1' => array(
     *                 array(
     *                     'type' => 'literal',
     *                     'value' => 'Hello world.'
     *                 )
     *             ),
     *             'http://example.org/predicate2' => array(
     *                 array(
     *                     'type' => 'uri',
     *                     'value' => 'http://example.org/object'
     *                 )
     *             )
     *         )
     *     );
     *
     * The subject URIs are used as keys, the corresponding predicates are used as
     * keys in the value array. This array contains a list of objects that form
     * triples with the subject and predicate. Each object (even URIs) is represented
     * by an array that contains at least type and value.
     *
     * @param string $graphIri
     * @param array $statementsArray
     * @param array $options ("escapeLiteral" => true/false) to disable automatic escaping characters
     */
    public function addMultipleStatements($graphIri, array $statementsArray, array $options = array())
    {
        $triples = new Erfurt_Store_Adapter_Sparql_TripleIterator($statementsArray);
        $this->connector->batch(function (\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector) use ($graphIri, $triples) {
            foreach ($triples as $triple) {
                /* @var $triple \Erfurt_Store_Adapter_Sparql_Triple */
                $connector->addTriple($graphIri, $triple);
            }
        });
    }

    /**
     *
     * @param string $modelIri
     * @param mixed $subject (string or null)
     * @param mixed $predicate (string or null)
     * @param mixed $object (array or null)
     * @param array $options
     *
     * @throws Erfurt_Exception
     *
     * @return int The number of statements deleted
     */
    public function deleteMatchingStatements($modelIri, $subject, $predicate, $object, array $options = array())
    {
        return $this->connector->deleteMatchingTriples(
            $modelIri,
            new Erfurt_Store_Adapter_Sparql_TriplePattern($subject, $predicate, $object)
        );
    }

    /**
     * Deletes statements in an array from the graph specified by $graphIri.
     *
     * @param string $graphIri
     * @param array $statementsArray
     */
    public function deleteMultipleStatements($graphIri, array $statementsArray)
    {
        $triples = new Erfurt_Store_Adapter_Sparql_TripleIterator($statementsArray);
        $this->connector->batch(function (\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector) use ($graphIri, $triples) {
            foreach ($triples as $triple) {
                /* @var $triple \Erfurt_Store_Adapter_Sparql_Triple */
                $connector->deleteMatchingTriples($graphIri, $triple);
            }
        });
    }

    /**
     * @param string $query A string containing a sparql query
     * @param array $options Option array to push down parameters to adapters
     * feel free to add anything you want. put the store name in front for special options, but use macros
     *      'result_format' => ['plain' | 'xml']
     *      'timeout' => 1000 (in msec)
     * I included some define macros at the top of Store.php
     * @return mixed Returns a result depending on the query, e.g. an array or a boolean value.
     * @throws Erfurt_Exception Throws an exception if query is no string.
     */
    public function sparqlQuery($query, $options = array())
    {
        try {
            $extendedResult = $this->connector->query($query);
            $format         = isset($options[Erfurt_Store::RESULTFORMAT]) ? $options[Erfurt_Store::RESULTFORMAT] : null;
            return $this->formatResultSet($extendedResult, $this->determineResultFormat($format, $query));
        } catch (Exception $e) {
            if (!($e instanceof Erfurt_Exception)) {
                // Normalize the exception.
                throw new Erfurt_Exception($e->getMessage(), 0, $e);
            }
            throw $e;
        }
    }

    /**
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $query
     * @return boolean
     */
    public function sparqlAsk($query)
    {
        return $this->sparqlQuery($query, array(Erfurt_Store::RESULTFORMAT => 'raw'));
    }

    /**
     * Creates a new empty model (named graph) with the URI specified.
     *
     * @param string $graphUri
     * @param int $type
     * @return boolean true on success, false otherwise
     */
    public function createModel($graphUri, $type = Erfurt_Store::MODEL_TYPE_OWL)
    {
        if (!in_array($graphUri, $this->currentlyCreatedGraphs)) {
            $this->currentlyCreatedGraphs[] = $graphUri;
        }
        if ($type === Erfurt_Store::MODEL_TYPE_OWL) {
            $this->addStatement($graphUri, $graphUri, EF_RDF_TYPE, array('type' => 'uri', 'value' => EF_OWL_ONTOLOGY));
        }
        return true;
    }

    /**
     * @param string $modelIri The Iri, which identifies the model.
     *
     * @throws Erfurt_Exception Throws an exception if no permission, model not existing or deletion fails.
     */
    public function deleteModel($modelIri)
    {
        if (($index = array_search($modelIri, $this->currentlyCreatedGraphs)) !== false) {
            unset($this->currentlyCreatedGraphs[$index]);
        }
        $this->deleteMatchingStatements($modelIri, null, null, null);
        // Clear the graph cache, otherwise it might return the deleted graph.
        $this->cachedAvailableGraphs = null;
    }

    /**
     * @return array Returns an associative array, where the key is the URI of a graph and the value
     * is true.
     */
    public function getAvailableModels()
    {
        if ($this->cachedAvailableGraphs === null) {
            $sparqlQuery = 'SELECT DISTINCT ?graph '
                         . 'WHERE {'
                         . '    GRAPH ?graph {'
                         . '        ?subject ?predicate ?object .'
                         . '    }'
                         . '}';
            $this->cachedAvailableGraphs = $this->sparqlQuery($sparqlQuery);
        }
        if (count($this->cachedAvailableGraphs) === 0) {
            return $this->toModelResult($this->currentlyCreatedGraphs);
        }
        $graphs = array_reduce($this->cachedAvailableGraphs, function (array $graphs, array $row) {
            $graphs[] = $row['graph'];
            return $graphs;
        }, $this->currentlyCreatedGraphs);
        return $this->toModelResult($graphs);
    }

    /**
     * @param string $modelIri The Iri, which identifies the model to look for.
     * @return boolean Returns true if model exists and is available for the user ($useAc === true).
     */
    public function isModelAvailable($modelIri)
    {
        $models = $this->getAvailableModels();
        return isset($models[$modelIri]);
    }

    /**
     * Returns the formats this store can export.
     *
     * @return  array
     */
    public function getSupportedExportFormats()
    {
        return array();
    }

    /**
     *
     * @param string $modelIri
     * @param string $serializationType One of:
     *        - 'xml'
     *        - 'n3' or 'nt'
     * @param mixed $filename Either a string containing a absolute filename or null. In case null is given,
     * this method returns a string containing the serialization.
     *
     * @return string|null
     */
    public function exportRdf($modelIri, $serializationType = 'xml', $filename = null)
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
    }

    /**
     * Returns the formats this store can import.
     *
     * @return  array
     */
    public function getSupportedImportFormats()
    {
        return array();
    }

    /**
     *
     * @param string $modelIri
     * @param string $data
     * @param string $type One of:
     *        - 'auto' => Tries to detect the type automatically in the following order:
     *           1. Detect XML by XML-Header => rdf/xml
     *           2. If this fails use the extension of the file
     *           3. If this fails throw an exception
     *        - 'xml'
     *        - 'n3' or 'nt'
     * @param string $locator Either a URL or a absolute file name.
     *
     * @throws Erfurt_Exception
     *
     * @return boolean On success
     */
    public function importRdf($modelIri, $data, $type, $locator)
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
    }

    /**
     * Returns the prefix used by the store to identify blank nodes.
     *
     * @return string
     */
    public function getBlankNodePrefix()
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
    }

    /**
     * Determines the result format, depending on requested format and query type.
     *
     * @param string|null $requestedFormat
     * @param string $query The SPARQL query.
     * @return string The result format.
     */
    protected function determineResultFormat($requestedFormat, $query)
    {
        if ($requestedFormat === null) {
            return $this->isAskQuery($query) ? 'raw' : Erfurt_Store::RESULTFORMAT_PLAIN;
        }
        return $requestedFormat;
    }

    /**
     * Checks if the provided SPARQL query is an ASK query.
     *
     * @param string $query
     * @return boolean
     */
    protected function isAskQuery($query)
    {
        if (strpos($query, 'ASK') === false) {
            // Query does not even contain the ASK keyword, no further
            // detection required.
            return false;
        }
        $parser = new Erfurt_Sparql_Parser();
        $info   = $parser->parse($query);
        return $info->getResultForm() === 'ask';
    }

    /**
     * Returns the converter that must be used to create the given result format.
     *
     * @param string $format
     * @return \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
     * @throws Erfurt_Exception If the result format is not supported.
     */
    protected function getConverterFor($format)
    {
        switch ($format) {
            case Erfurt_Store::RESULTFORMAT_EXTENDED:
            case 'raw':
                // Extended is the default format.
                return new Erfurt_Store_Adapter_ResultConverter_NullConverter();
            case Erfurt_Store::RESULTFORMAT_XML:
                return new Erfurt_Store_Adapter_Virtuoso_ResultConverter_SparqlResultsXml();
            case 'json':
                return new Erfurt_Store_Adapter_ResultConverter_ToJsonConverter();
            case Erfurt_Store::RESULTFORMAT_PLAIN:
                return new Erfurt_Store_Adapter_ResultConverter_ExtendedToPlainConverter();
        }
        $message = 'The result format "%s" is not supported by adapter %s.';
        $message = sprintf($message, $format, get_class($this));
        throw new Erfurt_Exception($message);
    }

    /**
     * Normalizes the provided result set, which means that keys
     * are normalized and that unnecessary elements are removed.
     *
     * @param array(string=>string) $results
     * @param string $format One of the Erfurt_Store::RESULTFORMAT_* constants or an adapter specific format string.
     * @return array(string=>string)
     */
    protected function formatResultSet($results, $format)
    {
        $converter = $this->getConverterFor($format);
        return $converter->convert($results);
    }

    /**
     * Converts the provided graph list into a model result.
     *
     * The model result contains the IRIs as key and true as value
     * for all entries.
     *
     * @param array(string) $graphs List of model IRIs.
     * @return array(string=>boolean)
     */
    protected function toModelResult(array $graphs)
    {
        if (count($graphs) === 0) {
            return array();
        }
        $graphs = array_unique($graphs);
        return array_combine($graphs, array_fill(0, count($graphs), true));
    }

}
