<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * Erfurt RDF Store - Adapter for the {@link http://www4.wiwiss.fu-berlin.de/bizer/rdfapi/ RAP} schema (modified) with
 * Zend_Db database abstraction layer.
 *
 * @package    Erfurt_Store_Adapter
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright  Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Store_Adapter_Test implements Erfurt_Store_Adapter_Interface, Erfurt_Store_Sql_Interface
{
    private $_data = array();

    private $_queryResults = array();
    private $_queryResultIndex = 0;

    private $_countResults = array();
    private $_countResultsIndex = 0;

    /** @see Erfurt_Store_Adapter_Interface */
    public function addMultipleStatements($graphUri, array $statementsArray, array $options = array())
    {
        if (isset($this->_data[$graphUri])) {
            $this->_data[$graphUri] = $statementsArray;

            return true;
        }

        return false;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function addStatement($graphUri, $subject, $predicate, array $object, array $options = array())
    {
        if (isset($this->_data[$graphUri])) {
            $statementsArray = array(
                $subject => array(
                    $predicate => array($object)
                )
            );

            $this->_data[$graphUri] = $statementsArray;

            return true;
        }

        return false;
    }

    public function getResourceDescription($resourceIri, $modelIri, $options = array())
    {
        $result = array();
        if (isset($this->_data[$modelIri][$resourceIri])) {
            $result[$resourceIri] = $this->_data[$modelIri][$resourceIri];
        } else {
            $result[$resourceIri] = array();
        }
        return $result;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function countWhereMatches($graphUri, $whereSpec, $countSpec, $distinct = false)
    {
        if ($this->_countResultsIndex >= count($this->_countResults)) {
            return 0;
        }

        return $this->_countResults[$this->_countResultsIndex++];
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function createModel($graphUri, $type = Erfurt_Store::MODEL_TYPE_OWL)
    {
        if (!isset($this->_data[$graphUri])) {
            $this->_data[$graphUri] = array();
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMatchingStatements(
        $graphUri, $subjectToDelete, $predicateToDelete, $objectToDelete, array $options = array()
    )
    {
        foreach (array_keys($this->_data[$graphUri]) as $subject) {
            if ($subjectToDelete == null || $subject == $subjectToDelete) {
                foreach (array_keys($this->_data[$graphUri][$subject]) as $predicate) {
                    if ($predicateToDelete == null || $predicate == $predicateToDelete) {
                        foreach (array_keys($this->_data[$graphUri][$subject][$predicate]) as $object) {
                            if ($objectToDelete == null) {
                                unset($this->_data[$graphUri][$subject][$predicate][$object]);
                            } else {
                                $diff = array_diff(
                                    $this->_data[$graphUri][$subject][$predicate][$object],
                                    $objectToDelete
                                );
                                if (empty($diff)) {
                                    unset($this->_data[$graphUri][$subject][$predicate][$object]);
                                }
                            }
                        }
                        if (empty($this->_data[$graphUri][$subject][$predicate])){
                            unset($this->_data[$graphUri][$subject][$predicate]);
                        }
                    }
                }
                if (empty($this->_data[$graphUri][$subject])){
                    unset($this->_data[$graphUri][$subject]);
                }
            }
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {

    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function deleteModel($graphUri)
    {
        if (isset($this->_data[$graphUri])) {
            unset($this->_data[$graphUri]);
        }
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function exportRdf($modelIri, $serializationType = 'xml', $filename = false)
    {

    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getAvailableModels()
    {
        $modelsArray = array_keys($this->_data);
        $models = array();
        foreach ($modelsArray as $graphUri) {
            $models[$graphUri] = true;
        }

        return $models;
    }

    public function getBackendName()
    {
        return 'Test';
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getBlankNodePrefix()
    {
        return 'bNode';
    }

    /**
     * Returns a list of graph uris, where each graph in the list contains at least
     * one statement where the given resource uri is subject.
     *
     * @param string $resourceUri
     * @return array
     */
    public function getGraphsUsingResource($resourceUri)
    {
        return array();
    }

    public function getImportsClosure($modelIri)
    {
        return array();
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getModel($modelIri)
    {
        if (isset($this->_data[$modelIri])) {
            return new Erfurt_Rdf_Model($modelIri);
        }
        return null;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getNewModel($graphUri, $baseUri = '', $type = 'owl')
    {
        $this->createModel($graphUri);
        return $this->getModel($graphUri);
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getSupportedExportFormats()
    {
        return array();
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function getSupportedImportFormats()
    {
        return array();
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function importRdf($modelUri, $data, $type, $locator)
    {

    }

    public function init()
    {

    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function isModelAvailable($modelIri)
    {
        return isset($this->_data[$modelIri]);
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlAsk($query)
    {
        return false;
    }

    /** @see Erfurt_Store_Adapter_Interface */
    public function sparqlQuery($query, $options=array())
    {
        if ($this->_queryResultIndex >= count($this->_queryResults)) {
            return array(); // empty result by default
        }

        return $this->_queryResults[$this->_queryResultIndex++];
    }

    public function createTable($tableName, array $columns)
    {

    }

    public function lastInsertId()
    {

    }

    public function listTables($prefix = '')
    {
        return array(
            'ef_versioning_actions',
            'ef_versioning_payloads'
        );
    }

    public function sqlQuery($sqlQuery, $limit = PHP_INT_MAX, $offset = 0)
    {

    }

#pragma mark -
#pragma mark Helper methods

    public function addQueryResult(array $queryResult)
    {
        $this->_queryResults[] = $queryResult;
    }

    public function getStatementsForGraph($graphUri)
    {
        if (isset($this->_data[$graphUri])) {
            return $this->_data[$graphUri];
        }

        return array();
    }

    public function addCountResult($i)
    {
        $this->_countResults[] = $i;
    }

}
