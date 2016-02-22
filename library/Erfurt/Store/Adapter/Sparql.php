<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Store.php';
require_once 'Erfurt/Store/Adapter/Interface.php';
require_once 'Erfurt/Store.php';

/**
 * This class acts as a backend for SPARQL endpoints.
 *
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @package    Erfurt_Store_Adapter
 */
class Erfurt_Store_Adapter_Sparql implements Erfurt_Store_Adapter_Interface
{
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * an array of model URIs, that should be listed as available
     * a list of remote models, that are assumed to exist
     * @var array
     */
    protected $_configuredGraphs = array();

    protected $_serviceUrl = null;

    protected $_username = null;

    protected $_password = null;

    public function __construct($adapterOptions = array())
    {
        $this->_serviceUrl = $adapterOptions['serviceUrl'];
        foreach($adapterOptions['graphs'] as $graphUri) {
            $this->_configuredGraphs[$graphUri] = true;
        }

        //TODO add option to retrieve available graphs from the endpoint (slower but complete)

        if (isset($adapterOptions['username'])) {
            $this->_username = $adapterOptions['username'];
        }

        if (isset($adapterOptions['password'])) {
            $this->_password = $adapterOptions['password'];
        }
    }

    public function addMultipleStatements($graphUri, array $statementsArray, array $options = array())
    {

    }

    public function addStatement($graphUri, $subject, $predicate, array $object, array $options = array())
    {

    }

    public function createModel($graphUri, $type = Erfurt_Store::MODEL_TYPE_OWL)
    {

    }

    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, array $options = array())
    {

    }

    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {

    }

    public function deleteModel($graphUri)
    {

    }

    public function exportRdf($graphUri, $serializationType = 'xml', $filename = false)
    {

    }

    public function getImportsClosure($graphUri)
    {
        return array();
    }

    public function getAvailableModels()
    {
        return $this->_configuredGraphs;
    }

    public function getBlankNodePrefix()
    {
        return 'bNode';
    }

    public function getModel($graphUri)
    {
        if (isset($this->_configuredGraphs[$graphUri])) {
            require_once 'Erfurt/Owl/Model.php';
            $m = new Erfurt_Owl_Model($graphUri, null);

            return $m;
        } else {
            return false;
        }
    }

    public function getSupportedExportFormats()
    {
        return array();
    }

    public function getSupportedImportFormats()
    {
        return array();
    }

    public function importRdf($modelUri, $data, $type, $locator)
    {
        return false;
    }

    public function init()
    {

    }

    public function isModelAvailable($graphUri)
    {
        if (isset($this->_configuredGraphs[$graphUri])) {
            return true;
        } else {
            return false;
        }
    }

    public function sparqlAsk($query)
    {
        $result = $this->sparqlQuery($query);
        if ($result['boolean'] === "true") {
            return true;
        }else if ($result['boolean'] === "false") {
            return false;
        } else {
            throw new Exception('Erfurt: Ask query lead to a nebulous answer. Maybe the query was not designed correctly: ' . (string) $query);
        }
    }

    public function sparqlQuery($query, $options=array())
    {
        // Make sure, we only query for configured graphs...
        $q = Erfurt_Sparql_SimpleQuery::initWithString((string)$query);
        $from = $q->getFrom();
        $newFrom = array();
        foreach ($from as $f) {
            if (isset($this->_configuredGraphs[$f])) {
                $newFrom[] = $f;
            }
        }

        if (count($newFrom) === 0) {
            return array();
        }
        $q->setFrom($newFrom);

        $resultform =(isset($options[Erfurt_Store::RESULTFORMAT]))?$options[Erfurt_Store::RESULTFORMAT]:Erfurt_Store::RESULTFORMAT_PLAIN;

        $url = $this->_serviceUrl . '?query=' . urlencode((string)$q);

        $client = Erfurt_App::getInstance()->getHttpClient(
            $url,
            array(
                'maxredirects'  => 10,
                'timeout'       => 2000
            )
        );

        if (null !== $this->_username) {
            if (substr($url, 0, 7) === 'http://') {
                // We need SSL here!
                $url = 'https://' . substr($url, 7);
            }

            $client->setAuth($this->_username, $this->_password);
        }

        $client->setHeaders('Accept', 'application/sparql-results+xml');
        $response = $client->request();

        if ($response->getStatus() === 200) {
            // OK
            if ($response->getBody() === '') {
                $result = array('head' => array(), 'results' => array('bindings' => array()));
            } else {
                $result = $this->_parseSparqlXmlResults($response->getBody());
            }
        } else {
            $result = array('head' => array(), 'results' => array('bindings' => array()));
        }


        switch ($resultform) {
            case 'plain':
                $newResult = array();
                //could be an ask query
                if (empty($result['results']['bindings']) && (!empty($result['boolean'])) ) {
                    return $result;
                } else {
                    foreach ($result['results']['bindings'] as $row) {
                        $newRow = array();

                        foreach ($row as $var=>$value) {
                            // TODO datatype and lang support
                            $newRow[$var] = $value['value'];
                        }

                        $newResult[] = $newRow;
                    }
                }
                return $newResult;
            case 'extended':

                return $result;
                break;
            case 'json':
                return json_encode($result);
                break;
            default:
                throw new Exception('Result form '.$resultform.' not supported yet.');
        }
    }

    protected function _parseSparqlXmlResults($sparqlXmlResults)
    {
        if (trim($sparqlXmlResults) === '') {
            return array(
                'head'     => array(),
                'results' => array('bindings' => array())
            );
        }

        $result = array();
        $xmlDoc = new DOMDocument();
        $ret = @$xmlDoc->loadXML($sparqlXmlResults);

        if ($ret === false) {
            throw new OntoWiki_Exception('SPARQL store could not parse the xml result "'.htmlentities($sparqlXmlResults).'"');
        }

        $headElems = $xmlDoc->getElementsByTagName('head');
        $varElems = $xmlDoc->getElementsByTagName('variable');
        foreach ($varElems as $i=>$varElem) {
            if ($i === 0) {
                $result['head'] = array();
                $result['head']['vars'] = array();
            }

            $result['head']['vars'][] = $varElem->attributes->getNamedItem('name')->value;
        }

        $result['results'] = array('bindings' => array());

        //if it is a Ask query we have to expect a boolean value
        $booleanValues = $xmlDoc->getElementsByTagName('boolean');
        foreach ($booleanValues as $booleanValue) {
            $result['boolean'] = $booleanValue->nodeValue;
        }
        if (!empty($result['boolean'])) {
                return $result;
        }

        $resultElems = $xmlDoc->getElementsByTagName('result');
        foreach ($resultElems as $resultElem) {
            $row = array();

            $childNodes = $resultElem->childNodes;
            foreach ($childNodes as $node) {
                if (!$node instanceof DOMNode) {
                    continue;
                }

                if ($node->nodeName === 'binding') {
                    $var = $node->attributes->getNamedItem('name')->value;

                    $valueNodes = $node->childNodes;
                    $addRow = false;
                    foreach ($valueNodes as $vn) {
                        if (!($vn instanceof DOMNode) || trim($vn->nodeValue) === '') {
                            continue;
                        }
                        $addRow = true;

                        $valueType = $vn->nodeName;
                        if ($valueType === 'uri' || $valueType === 'bnode') {
                            $type = $valueType;
                            $val  = $vn->nodeValue;
                        } else {
                            if (null !== $vn->attributes->getNamedItem('datatype')) {
                                $type = 'typed-literal';
                                $dt = $vn->attributes->getNamedItem('datatype')->nodeValue;
                            } else {
                                $type = 'literal';
                            }

                            if (null !== $vn->attributes->getNamedItem('xml:lang')) {
                                $lang = $vn->attributes->getNamedItem('xml:lang')->nodeValue;
                            }

                            $val = $vn->nodeValue;
                        }

                        break;
                    }

                    if($addRow){
                        $row[$var] = array(
                            'type'  => $type,
                            'value' => $val
                        );

                        if (isset($lang)) {
                            $row[$var]['xml:lang'] = $lang;
                        }
                        if (isset($dt)) {
                            $row[$var]['datatype'] = $dt;
                        }
                    }
                }
            }

            $result['results']['bindings'][] = $row;
        }

        return $result;
    }
}
