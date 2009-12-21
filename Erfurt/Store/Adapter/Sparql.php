<?php 
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id: Sparql.php 4059 2009-08-14 06:40:23Z pfrischmuth $
 */

require_once 'Erfurt/Store/Adapter/Interface.php';
require_once 'Erfurt/Store.php';

/**
 * This class acts as a backend for SPARQL endpoints.
 *
 * @copyright  Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    erfurt
 * @subpackage store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Store_Adapter_Sparql implements Erfurt_Store_Adapter_Interface
{    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    protected $_configuredGraphs = array();
    
    protected $_serviceUrl = null;
    
    protected $_username = null;
    
    protected $_password = null;
    
    public function __construct($adapterOptions = array())
    {
        $this->_serviceUrl = $adapterOptions['serviceurl'];
                
        foreach($adapterOptions['graphs'] as $graphUri) {
            $this->_configuredGraphs[$graphUri] = true;
        }
        
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
    
    public function addStatement($graphUri, $subject, $predicate, $object, array $options = array())
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
// TODO
    }
    
    public function sparqlQuery($query, $options=array())
    {
        $resultform =(isset($options[STORE_RESULTFORMAT]))?$options[STORE_RESULTFORMAT]:STORE_RESULTFORMAT_PLAIN;
        
        $url = $this->_serviceUrl . '?query=' . urlencode((string)$query) . '&maxrows=10';
                
        require_once 'Zend/Http/Client.php';
        $client = new Zend_Http_Client($url, array(
            'maxredirects'  => 10,
            'timeout'       => 30
        ));
    
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
                $result = array('head' => array(), 'bindings' => array());
            } else {
                $result = $this->_parseSparqlXmlResults($response->getBody());
            }
        } else {            
            $result = array('head' => array(), 'bindings' => array());
        }
    
        switch ($resultform) {
            case 'plain':
                $newResult = array();
                
                foreach ($result['bindings'] as $row) {
                    $newRow = array();
                    
                    foreach ($row as $var=>$value) {
                        // TODO datatype and lang support
                        $newRow[$var] = $value['value'];
                    }
                    
                    $newResult[] = $newRow;
                }
                
                return $newResult;
            case 'extended':
                return $result;
            case 'json':
                return json_encode($result);
                break;
            default:
                throw new Exception('Result form not supported yet.');
        }        
    }
    
    protected function _parseSparqlXmlResults($sparqlXmlResults)
    {
        if (trim($sparqlXmlResults) === '') {
            return array(
                'head'     => array(),
                'bindings' => array()
            );
        }
        
        $result = array();
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($sparqlXmlResults);

        if ($xmlDoc === false) {
            return array(
                'head'     => array(),
                'bindings' => array()
            );
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

        $result['bindings'] = array();
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
                    foreach ($valueNodes as $vn) {
                        if (!$vn instanceof DOMNode
                               || '' === trim($vn->nodeValue)) {
                            continue;
                        }
                        
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
            
            $result['bindings'][] = $row;
        }

        return $result;
    }
}
