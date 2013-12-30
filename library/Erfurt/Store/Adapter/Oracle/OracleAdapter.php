<?php

use Doctrine\DBAL\Connection;

/**
 * Adapter that connects to the Oracle Triple Store (named Semantic and Graph option).
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 07.12.13
 */
class Erfurt_Store_Adapter_Oracle_OracleAdapter implements \Erfurt_Store_Adapter_Interface
{

    /**
     * The database connection that is used.
     *
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * A prepared insert statement or null if it was not created yet.
     *
     * @var \Doctrine\DBAL\Driver\Statement|null
     */
    protected $insertStatement = null;

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
     * Creates an adapter that uses the provided database connection to interact
     * with the Oracle Triple Store.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * This method allows the backend to (re)initialize itself, e.g. when an import was done.
     */
    public function init()
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
    }

    /**
     * Adds statements in an array to the graph specified by $graphIri.
     *
     * @param string $graphIri
     * @param array $statementsArray
     * @param array $options ("escapeLiteral" => true/false) to disable automatic escaping characters
     */
    public function addMultipleStatements($graphIri, array $statementsArray, array $options = array())
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
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
        $params = array(
            'modelAndGraph' => $this->getModelName() . ':<' . $graphUri . '>',
            'subject'       => '<' . $subject . '>',
            'predicate'     => '<' . $predicate . '>',
            'object'        => $this->objectToString($object)
        );
        $this->getInsertStatement()->execute($params);
    }

    /**
     * Deletes statements that match the given criteria.
     *
     * Use null as a wildcard.
     *
     * @param string $modelIri
     * @param mixed $subject (string or null)
     * @param mixed $predicate (string or null)
     * @param mixed $object (array or null)
     * @param array $options
     * @return integer The number of statements deleted
     * @throws Erfurt_Exception
     */
    public function deleteMatchingStatements($modelIri, $subject, $predicate, $object, array $options = array())
    {
        $params = array(
            'modelAndGraph' => strtoupper($this->getModelName()) . ':<' . $modelIri . '>'
        );
        $query = $this->connection->createQueryBuilder()
                                  ->delete('erfurt_semantic_data', 'd')
                                  ->where('d.triple.GET_MODEL() = :modelAndGraph');
        if ($subject !== null) {
            $query->andWhere('d.triple.GET_SUBJECT() = :subject');
            $params['subject'] = '<' . $subject . '>';
        }
        if ($predicate !== null) {
            $query->andWhere('d.triple.GET_PROPERTY() = :predicate');
            $params['predicate'] = '<' . $predicate . '>';
        }
        if ($object !== null) {
            $query->andWhere('d.triple.GET_TRIPLE().object = :object');
            $params['object'] = $this->objectToString($object);
        }
        $query->setParameters($params);
        return $query->execute();
    }

    /**
     * Deletes statements in an array from the graph specified by $graphIri.
     *
     * @param string $graphIri
     * @param array $statementsArray
     */
    public function deleteMultipleStatements($graphIri, array $statementsArray)
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
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
    }

    /**
     * @return array Returns an associative array, where the key is the URI of a graph and the value
     * is true.
     */
    public function getAvailableModels()
    {
        $sparqlQuery = 'SELECT DISTINCT ?graph '
                     . 'WHERE {'
                     . '    GRAPH ?graph {'
                     . '        ?subject ?predicate ?object .'
                     . '    }'
                     . '}';
        $result = $this->sparqlQuery($sparqlQuery);
        if (count($result) === 0) {
            return $this->toModelResult($this->currentlyCreatedGraphs);
        }
        $graphs = array_reduce($result, function (array $graphs, array $row) {
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
     * Returns the prefix used by the store to identify blank nodes.
     *
     * @return string
     */
    public function getBlankNodePrefix()
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
    }

    /**
     * Returns the formats this store can export.
     *
     * @return  array
     */
    public function getSupportedExportFormats()
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
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
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
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
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $query
     * @return boolean
     */
    public function sparqlAsk($query)
    {
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
    }

    /**
     * Executes the provided SPARQL query and returns the result.
     *
     * @param string $query A string containing a sparql query
     * @param array $options Option array to push down parameters to adapters
     * @return mixed Returns a result depending on the query, e.g. an array or a boolean value.
     * @throws Erfurt_Exception If the SPARQL query is invalid or the execution fails.
     */
    public function sparqlQuery($query, $options = array())
    {
        try {
            $statement = $this->createSparqlStatement($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            $format  = isset($options[Erfurt_Store::RESULTFORMAT]) ? $options[Erfurt_Store::RESULTFORMAT] : null;
            return $this->formatResultSet($results, $format);
        } catch (Exception $e) {
            // Normalize the exception.
            throw new Erfurt_Exception($e->getMessage(), 0, $e);
        }
    }

    /**
     * Recursively gets owl:imported model IRIs starting with $modelUri as root.
     *
     * Note: What exactly should be returned? What is the intention?
     *
     * @param string $modelUri
     * @return array(string=>string)
     */
    public function getImportsClosure($modelUri)
    {
        return array();
    }

    /**
     * Prepares a statement that is used to insert a triple.
     *
     * The statement requires the following parameters:
     *
     * # modelAndGraph - Model name and graph IRI, separated by colon (":").
     * # subject       - Subject IRI.
     * # predicate     - Predicate IRI.
     * # object        - Encoded object.
     *
     * IRI must be enclosed by angle braces ("<", ">").
     * Objects must be IRIs or encoded literals, for example:
     *
     * # "literal"
     * # "literal"@de
     * # "literal"^^xsd:string
     *
     * @return \Doctrine\DBAL\Driver\Statement
     */
    protected function getInsertStatement()
    {
        if ($this->insertStatement === null) {
            $query = 'INSERT INTO erfurt_semantic_data (triple) '
                   . 'VALUES ('
                   . '  SDO_RDF_TRIPLE_S('
                   . '    :modelAndGraph,'
                   . '    :subject,'
                   . '    :predicate,'
                   . '    :object'
                   . '  )'
                   . ')';
            $this->insertStatement = $this->connection->prepare($query);
        }
        return $this->insertStatement;
    }

    /**
     * Creates a statement that is used to perform a SPARQL query.
     *
     * @param string $sparqlQuery The SPARQL query.
     * @return \Doctrine\DBAL\Driver\Statement
     */
    protected function createSparqlStatement($sparqlQuery)
    {
        $query = 'SELECT * '
               . 'FROM TABLE('
               . '  SEM_MATCH('
               . '    ' . $this->escapeSparql($sparqlQuery) . ','
               . '    SEM_MODELS(' . $this->connection->quote($this->getModelName()). '),'
               . '    NULL,'
               . '    NULL,'
               . '    NULL,'
               . '    NULL,'
               . '    ' . $this->connection->quote('STRICT_DEFAULT=T') . ','
               . '    NULL,'
               . '    NULL'
               . '  )'
               . ') '
               . 'ORDER BY SEM$ROWNUM';
        return $this->connection->prepare($query);
    }

    /**
     * Uses the provided object specification to encode it
     * into a string.
     *
     * @param array(string=>string) $objectSpec
     * @return string
     */
    protected function objectToString(array $objectSpec)
    {
        if ($objectSpec['type'] === 'uri') {
            return '<' . $objectSpec['value'] . '>';
        }
        return Erfurt_Utils::buildLiteralString(
            $objectSpec['value'],
            isset($objectSpec['datatype']) ? $objectSpec['datatype'] : null,
            isset($objectSpec['lang']) ? $objectSpec['lang'] : null
        );
    }

    /**
     * Uses the Oracle q operator to escape a SPARQL query string.
     *
     * Usually it is much better to use prepared statements, but
     * parameters like the SPARQL query must be available at
     * compile time for optimization reasons.
     *
     * @param string $query
     * @return string
     * @throws \InvalidArgumentException If the string contains the escape sequence.
     */
    protected function escapeSparql($query)
    {
        if (strpos($query, "~'") !== false) {
            $message = 'SPARQL query must not contain the sequence "~\'", which is used internally for escaping."';
            throw new \InvalidArgumentException($message);
        }
        return "q'~$query~'";
    }

    /**
     * Returns the name of the semantic model that is used.
     *
     * @return string
     */
    protected function getModelName()
    {
        return $this->connection->getUsername() . '_erfurt';
    }

    /**
     * Normalizes the provided result set, which means that keys
     * are normalized and that unnecessary elements are removed.
     *
     * @param array(string=>string) $results
     * @param string|null $format One of the Erfurt_Store::RESULTFORMAT_* constants or null for plain format.
     * @return array(string=>string)
     * @throws Erfurt_Exception If the result format is not supported.
     */
    protected function formatResultSet($results, $format = null)
    {
        switch ($format) {
            case Erfurt_Store::RESULTFORMAT_EXTENDED:
                $converter = new Erfurt_Store_Adapter_Oracle_ResultConverter_RawToExtendedConverter();
                break;
            case Erfurt_Store::RESULTFORMAT_PLAIN:
            case null:
                $converter = new Erfurt_Store_Adapter_Oracle_ResultConverter_RawToSimpleConverter();
                break;
            case 'raw':
                $converter = new Erfurt_Store_Adapter_ResultConverter_NullConverter();
                break;
            default:
                $message = 'The result format "%s" is not supported by adapter %s';
                $message = sprintf($message, $format, get_class($this));
                throw new Erfurt_Exception($message);
        }
        return $converter->convert($results);
    }

    /**
     * Fallback for requested (but undeclared) methods.
     *
     * @param string $name
     * @param array(mixed) $args
     * @throws BadMethodCallException
     */
    public function __call($name, $args)
    {
        throw new BadMethodCallException('Method ' . $name . ' is not available.');
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