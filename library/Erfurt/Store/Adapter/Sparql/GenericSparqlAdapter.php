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
     * Creates a SPARQL adapter that uses the provided connector.
     *
     * @param Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector
     */
    public function __construct(\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector)
    {

    }

    /**
     * This method allows the backend to (re)initialize itself, e.g. when an import was done.
     */
    public function init()
    {
        // TODO: Implement init() method.
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
     * @param string $modelIri The Iri, which identifies the model.
     *
     * @throws Erfurt_Exception Throws an exception if no permission, model not existing or deletion fails.
     */
    public function deleteModel($modelIri)
    {
        // TODO: Implement deleteModel() method.
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
     * @param string $modelIri The Iri, which identifies the model to look for.
     * @return boolean Returns true if model exists and is available for the user ($useAc === true).
     */
    public function isModelAvailable($modelIri)
    {
        // TODO: Implement isModelAvailable() method.
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
        // TODO: Implement exportRdf() method.
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
     * Returns the prefix used by the store to identify blank nodes.
     *
     * @return string
     */
    public function getBlankNodePrefix()
    {
        // TODO: Implement getBlankNodePrefix() method.
    }

}
