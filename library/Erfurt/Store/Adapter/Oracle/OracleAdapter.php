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
        throw new BadMethodCallException(__FUNCTION__ . ' is not implemented yet.');
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
       return true;
    }

    /**
     * @param string $modelIri The Iri, which identifies the model.
     *
     * @throws Erfurt_Exception Throws an exception if no permission, model not existing or deletion fails.
     */
    public function deleteModel($modelIri)
    {
        $query = 'DELETE FROM erfurt_semantic_data d '
               . 'WHERE d.triple.GET_MODEL() = :modelAndGraph';
        $statement = $this->connection->prepare($query);
        $params = array(
            'modelAndGraph' => strtoupper($this->getModelName()) . ':<' . $modelIri . '>'
        );
        $statement->execute($params);
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
            return array();
        }
        $graphs = array_map(function (array $row) {
            return $row['graph'];
        }, $result);
        return array_combine($graphs, array_fill(0, count($graphs), true));
    }

    /**
     * @param string $modelIri The Iri, which identifies the model to look for.
     * @return boolean Returns true if model exists and is available for the user ($useAc === true).
     */
    public function isModelAvailable($modelIri)
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
            return $this->normalizeResultSet($results);
        } catch (Exception $e) {
            // Normalize the exception.
            throw new Erfurt_Exception($e->getMessage(), 0, $e);
        }
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
               . '    ' . $this->connection->quote($sparqlQuery) . ','
               . '    SEM_MODELS(' . $this->connection->quote($this->getModelName()). '),'
               . '    NULL,'
               . '    NULL,'
               . '    NULL,'
               . '    NULL,'
               . '    ' . $this->connection->quote('STRICT_DEFAULT=T') . ','
               . '    NULL,'
               . '    NULL'
               . '  )'
               . ')'
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
     * @return array(string=>string)
     */
    protected function normalizeResultSet($results)
    {
        $results = array_map(function (array $row) {
            foreach (array_keys($row) as $key) {
                // Remove additional data that contains meta data,
                // which is provided by Oracle.
                if (strpos($key, '$') !== false) {
                    unset($row[$key]);
                }
            }
            return array_change_key_case($row, CASE_LOWER);
        }, $results);
        return $results;
    }

}
