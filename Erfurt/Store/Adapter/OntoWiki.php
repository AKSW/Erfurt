<?php 
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id: OntoWiki.php 4060 2009-08-14 06:48:05Z pfrischmuth $
 */

require_once 'Erfurt/Store/Adapter/Sparql.php';

/**
 * This class acts as a backend for OntoWiki endpoints.
 *
 * @copyright  Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    erfurt
 * @subpackage store
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
class Erfurt_Store_Adapter_OntoWiki extends Erfurt_Store_Adapter_Sparql
{    
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------
    
    private $_updateUrl = null;
    
    public function __construct($adapterOptions = array())
    {
        parent::__construct($adapterOptions);
        
        $this->_updateUrl = $adapterOptions['updateurl'];
    }
    
    public function addMultipleStatements($graphUri, array $statementsArray, array $options = array())
    {
        $url = $this->_updateUrl . '?insert=' . urlencode(json_encode($statementsArray)) .
                                   '&named-graph-uri=' . urlencode($graphUri);
        
        $this->_handleRequest($url);
    }
    
    public function addStatement($graphUri, $subject, $predicate, $object, array $options = array())
    {
        $statementArray = array();
        $statementArray["$subject"] = array();
        $statementArray["$subject"]["$predicate"] = array();
        $statementArray["$subject"]["$predicate"][] = $object;
        
        try {
            $this->addMultipleStatements($graphUri, $statementArray);
        } catch (Erfurt_Store_Adapter_Exception $e) {
            require_once 'Erfurt/Store/Adapter/Exception.php';
            throw new Erfurt_Store_Adapter_Exception('Insertion of statement failed:' . $e->getMessage());
        }
    }
    
    public function deleteMatchingStatements($graphUri, $subject, $predicate, $object, array $options = array())
    {
// TODO 
    }
    
    public function deleteMultipleStatements($graphUri, array $statementsArray)
    {
        $url = $this->_updateUrl . '?delete=' . urlencode(json_encode($statementsArray)) .
                                   '&named-graph-uri=' . urlencode($graphUri);
        
        $this->_handleRequest($url);
    }
    
    public function deleteModel($graphUri)
    {
// TODO
    }
        
    public function getNewModel($graphUri, $baseUri = '', $type = 'owl')
    {
// TODO ?    
    }
    
    public function sparqlQuery($query, $options=array())
    {   
        $resultform =(isset($options[STORE_RESULTFORMAT]))?$options[STORE_RESULTFORMAT]:STORE_RESULTFORMAT_PLAIN;
        // Support for FOAF+SSL only when user is authenticated via WebID.
        $identity = Erfurt_App::getInstance()->getAuth()->getIdentity();
        if (!$identity->isWebId()) {
            return parent::sparqlQuery($query, $resultform);
        }
        
        $url = $this->_serviceUrl . '?query=' . urlencode((string)$query);
        $accept = 'application/sparql-results+xml';
    
        $response = $this->_handleRequest($url, $accept);
        $result = $this->_parseSparqlXmlResults($response);

        switch ($resultform) {
            case 'plain':
                $newResult = array();
                
                foreach ($result['results']['bindings'] as $row) {
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
    
    private function _handleRequest($url, $accept = null)
    {
        $client = Erfurt_App::getInstance()->getHttpClient($url, array(
            'maxredirects'  => 10,
            'timeout'       => 30
        ));
    
        if (null !== $accept) {
            $client->setHeaders('Accept', $accept);
        }
    
        $response = $client->request();

        if ($response->getStatus() === 200) {
            // OK
            return $response->getBody();
        } else if ($response->getStatus() === 401) {
            // In this case we try to request the service again with credentials.
            $identity = Erfurt_App::getInstance()->getAuth()->getIdentity();
            if (!$identity->isWebId()) {
                // We only support WebIDs here.
                return '';
            }
            
            $config = Erfurt_App::getInstance()->getConfig();
            if (isset($config->auth->foafssl->agentCertFilename)) {
                $certFilename = $config->auth->foafssl->agentCertFilename;
            } else {
                // We need a cert
                return '';
            }
            
            if (substr($url, 0, 7) === 'http://') {
                // We need SSL here!
                $url = 'https://' . substr($url, 7);
            }
            
            $client = Erfurt_App::getInstance()->getHttpClient($url, array(
                'maxredirects'  => 10,
                'timeout'       => 30,
                'sslcert'       => $certFilename
            ));
            
            $client->setHeaders(
                'Authorization', 
                'FOAF+SSL '.base64_encode('ow_auth_user_key="' . $identity->getUri() . '"'), 
                true
            );
            
            $response = $client->request();
            
            if ($response->getStatus() === 200) {
                // OK
                return $response->getBody();
            } else {
                return '';
            }
        } else {            
            return '';
        }
    }
}
