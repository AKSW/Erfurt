<?php

/**
 * Class that combines a SPARQL as well as a SQL adapter and just delegates
 * the calls to the interface methods.
 *
 * This allows one to separate SPARQL and SQL adapters and gives the opportunity
 * to create any combination of these.
 * Without these separation each SPARQL adapter must implement the SQL interface
 * to enable versioning support, even if SQL is not supported by it's architecture.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 06.01.14
 */
class Erfurt_Store_Adapter_SparqlSqlCombination
    implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{

    /**
     * Uses the given adapters to provide SPARQL as well as SQL capabilities.
     *
     * @param Erfurt_Store_Adapter_Interface $sparqlAdapter
     * @param Erfurt_Store_Sql_Interface $sqlAdapter
     */
    public function __construct(Erfurt_Store_Adapter_Interface $sparqlAdapter, Erfurt_Store_Sql_Interface $sqlAdapter)
    {

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
        // TODO: Implement addMultipleStatements() method.
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
        // TODO: Implement addStatement() method.
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
        // TODO: Implement createModel() method.
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
        // TODO: Implement deleteMatchingStatements() method.
    }

    /**
     * Deletes statements in an array from the graph specified by $graphIri.
     *
     * @param string $graphIri
     * @param array $statementsArray
     */
    public function deleteMultipleStatements($graphIri, array $statementsArray)
    {
        // TODO: Implement deleteMultipleStatements() method.
    }

    /**
     * @param string $modelIri The Iri, which identifies the model.
     *
     * @throws Erfurt_Exception Throws an exception if no permission, model not existing or deletion fails.
     */
    public function deleteModel($modelIri)
    {
        // TODO: Implement deleteModel() method.
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
     * @return string/null
     */
    public function exportRdf($modelIri, $serializationType = 'xml', $filename = null)
    {
        // TODO: Implement exportRdf() method.
    }

    /**
     * @return array Returns an associative array, where the key is the URI of a graph and the value
     * is true.
     */
    public function getAvailableModels()
    {
        // TODO: Implement getAvailableModels() method.
    }

    /**
     * Returns the prefix used by the store to identify blank nodes.
     *
     * @return string
     */
    public function getBlankNodePrefix()
    {
        // TODO: Implement getBlankNodePrefix() method.
    }

    /**
     * Returns the formats this store can export.
     *
     * @return  array
     */
    public function getSupportedExportFormats()
    {
        // TODO: Implement getSupportedExportFormats() method.
    }

    /**
     * Returns the formats this store can import.
     *
     * @return  array
     */
    public function getSupportedImportFormats()
    {
        // TODO: Implement getSupportedImportFormats() method.
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
        // TODO: Implement importRdf() method.
    }

    /**
     * This method allows the backend to (re)initialize itself, e.g. when an import was done.
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @param string $modelIri The Iri, which identifies the model to look for.
     * @return boolean Returns true if model exists and is available for the user ($useAc === true).
     */
    public function isModelAvailable($modelIri)
    {
        // TODO: Implement isModelAvailable() method.
    }

    /**
     * Executes a SPARQL ASK query and returns a boolean result value.
     *
     * @param string $query
     * @return boolean
     */
    public function sparqlAsk($query)
    {
        // TODO: Implement sparqlAsk() method.
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
        // TODO: Implement sparqlQuery() method.
    }

    /// SQL METHODS

    /**
     * Creates the table specified by $tableSpec according to backend-specific
     * create table statement.
     *
     * @param string $tableName
     * @param array $columns An associative array of SQL column names and column specs.
     */
    public function createTable($tableName, array $columns)
    {
        // TODO: Implement createTable() method.
    }

    /**
     * Returns the ID for the last insert statement.
     *
     * @return int
     */
    public function lastInsertId()
    {
        // TODO: Implement lastInsertId() method.
    }

    /**
     * Returns an array of SQL tables available in the store.
     *
     * @param string $prefix An optional table prefix to filter table names.
     * @return array
     */
    public function listTables($prefix = '')
    {
        // TODO: Implement listTables() method.
    }

    /**
     * Executes a SQL query with a SQL-capable backend.
     *
     * @param string $sqlQuery A string containing the SQL query to be executed.
     * @param int $limit Maximum number of results to return
     * @param int $offset The number of results to skip from the beginning
     * @return array
     */
    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {
        // TODO: Implement sqlQuery() method.
    }

}
