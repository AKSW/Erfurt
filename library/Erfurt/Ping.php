<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @category Erfurt
 * @package  Erfurt
 * @author   Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author   Sebastian Tramp <mail@sebastian.tramp.name>
 * @author   Jonas Brekle <jonas.brekle@gmail.com>
 * @author   Natanael Arndt <arndtn@gmail.com>
 * @author   Norman Radtke <norman.radtke@gmail.com>
 */
class Erfurt_Ping
{
    protected $_targetGraph = null;
    protected $_sourceRdf = null;
    private $_dbChecked = false;
    private $_options = array();
    private $_config = null;
    private $_wrapperRegistry = null;
    private $_httpAdapter = null;
    private $_errorCode = -1;
    private $_successMessage = '';

    /**
     * The XML-RPC error codes for pingback, see also:
     * http://www.hixie.ch/specs/pingback/pingback#TOC3
     */
    private static $_errUnknown         = 0x0000;
    private static $_errSNotExist       = 0x0010;
    private static $_errSNoLink         = 0x0011;
    private static $_errTNotExist       = 0x0020;
    private static $_errTNotUsable      = 0x0021;
    private static $_errRegistered      = 0x0030;
    private static $_errAccessDenied    = 0x0031;

    public function __construct ($options = array())
    {
        $this->_config = Erfurt_App::getInstance()->getConfig();

        if (!isset($options['rdfa'])) {
            $options['rdfa'] = true;
        }
        if (!isset($options['title_properties'])) {
            $options['title_properties'] = array();
        }
        if (!isset($options['generic_relation'])) {
            $options['generic_relation'] = 'http://rdfs.org/sioc/ns#links_to';
        }
        $this->_options = $options;
    }

    /**
     * receive a ping API
     * the XML-RPC code is returned by the method getReturnValue()
     *
     * @param string $sourceUri The source URI
     * @param string $targetUri The target URI
     *
     * @return boolean whether it was successfull or not
     */
    public function receive ($sourceUri, $targetUri)
    {
        $this->_logInfo('Method ping was called.');

        // Is $targetUri a valid linked data resource in this namespace?
        if (!$this->_checkTargetExists($targetUri)) {
            return $this->_setErrorCode(self::$_errTNotUsable);
        }

        $foundPingbackTriplesGraph = array();

        // 1. Try to dereference the source URI as RDF/XML, N3, Truples, Turtle
        $foundPingbackTriplesGraph = $this->_getResourceFromWrapper($sourceUri, $targetUri, 'Linkeddata');

        // 2. If nothing was found, try to use as RDFa service
        if (((boolean) $this->_options['rdfa']) && (count($foundPingbackTriplesGraph) === 0)) {
            $foundPingbackTriplesGraph = $this->_getResourceFromWrapper($sourceUri, $targetUri, 'Rdfa');
        }

        $foundPingbackTriples = array();
        foreach ($foundPingbackTriplesGraph as $s => $predicates) {
            foreach ($predicates as $p => $objects) {
                foreach ($objects as $o) {
                    $foundPingbackTriples[] = array(
                        's' => $s,
                        'p' => $p,
                        'o' => $o['value']
                    );
                }
            }
        }

        $versioning = Erfurt_App::getInstance()->getVersioning();
        $versioning->startAction(
            array(
                'type' => '9000',
                'modeluri' => $this->_targetGraph,
                'resourceuri' => $sourceUri
            )
        );

        // 3. If still nothing was found, try to find a link in the html
        if (count($foundPingbackTriples) === 0) {
            $client = Erfurt_App::getInstance()->getHttpClient(
                $sourceUri,
                array(
                    'maxredirects' => 10,
                    'timeout' => 30
                )
            );

            try {
                $response = $client->request();
            } catch (Exception $e) {
                $this->_logError($e->getMessage());
                $versioning->endAction();
                return $this->_setErrorCode(self::$_errUnknown);
            }
            if ($response->getStatus() === 200) {
                $htmlDoc = new DOMDocument();
                $result = @$htmlDoc->loadHtml($response->getBody());
                $aElements = $htmlDoc->getElementsByTagName('a');

                foreach ($aElements as $aElem) {
                    $a = $aElem->getAttribute('href');
                    if (strtolower($a) === $targetUri) {
                        $foundPingbackTriples[] = array(
                            's' => $sourceUri,
                            'p' => $_options['generic_relation'],
                            'o' => $targetUri
                        );
                        break;
                    }
                }
            } else {
                $versioning->endAction();
                return $this->_setErrorCode(self::$_errSNotExist);
            }
        }

        // 4. If still nothing was found, the sourceUri does not contain any link to targetUri
        if (count($foundPingbackTriples) === 0) {
            // Remove all existing pingback triples from that sourceUri.
            $removed = $this->_deleteInvalidPingbacks($sourceUri, $targetUri);

            if (!$removed) {
                $versioning->endAction();
                return $this->_setErrorCode(self::$_errSNoLink);
            } else {
                $this->_logInfo('All existing Pingbacks removed.');
                $versioning->endAction();
                $this->_successMessage = 'Existing Pingbacks have been removed.';
                return true;
            }
        }

        // 6. Iterate through pingback triples candidates and add those, who are not already registered.
        $added = false;
        foreach ($foundPingbackTriples as $triple) {
            if (!$this->_pingbackExists($triple['s'], $triple['p'], $triple['o'])) {
                $res = $this->_addPingback($triple['s'], $triple['p'], $triple['o']);
                if ($res) $added = true;
            }
        }

        // Remove all existing pingbacks from that source uri, that were not found this time.
        $removed = $this->_deleteInvalidPingbacks($sourceUri, $targetUri, $foundPingbackTriples);

        if (!$added && !$removed) {
            $versioning->endAction();
            return $this->_setErrorCode(self::$_errRegistered);
        }

        $this->_logInfo('Pingback registered.');
        $versioning->endAction();

        $this->_successMessage = 'Pingback has been registered or updated... Keep spinning the Data Web ;-)';
        return true;
    }

    /**
     * This method sets the current error code for receiving the ping
     *
     * @param $error the new error to set
     * @return boolean false, because errors are not good
     */
    private function _setErrorCode ($error)
    {
        $this->_logError('error code: ' . $error);
        $this->_errorCode = $error;

        return false;
    }

    /**
     * This method returns the last error code of a ping receive
     *
     * @return int the last error code, -1 if the run was successful
     */
    public function getErrorCode ()
    {
        return $this->_errorCode;
    }

    /**
     * This method returns the return value for the client as specified in:
     * http://www.hixie.ch/specs/pingback/pingback#TOC3
     *
     * @return string the return value which sould be send to the client
     */
    public function getReturnValue ()
    {
        if ($this->_errorCode > 0) {
            return sprintf('0x%04x', $this->_errorCode);
        } else {
            return $this->_successMessage;
        }
    }

    public function setWrapperRegistry ($wrapperRegistry)
    {
        $this->_wrapperRegistry = $wrapperRegistry;
    }

    public function setHttpAdapter($adapter)
    {
        $this->_httpAdapter = $adapter;
    }

    private function _getWrapper ($wrapperName)
    {
        if ($this->_wrapperRegistry === null) {
            Erfurt_Wrapper_Registry::reset();
            $this->_wrapperRegistry = Erfurt_Wrapper_Registry::getInstance();
        }

        $wrapper = $this->_wrapperRegistry->getWrapperInstance($wrapperName);

        if ($this->_httpAdapter !== null) {
            $wrapper->setHttpAdapter($this->_httpAdapter);
        }

        return $wrapper;
    }

    protected function _addPingback ($s, $p, $o)
    {
        if ($this->_targetGraph === null) {
            return false;
        }

        $modelUri = $this->_config->ping->modelUri;
        $nsPing = $this->_config->ping->baseUri;

        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getModelOrCreate($modelUri);

        $pingUri = $model->createResourceUri('Ping');
        $model->addMultipleStatements(
            array(
                $pingUri => array (
                    EF_RDF_NS . 'type' => array(array('type' => 'uri', 'value' => $nsPing . 'Item')),
                    $nsPing . 'source' => array(array('type' => 'uri', 'value' => $s)),
                    $nsPing . 'target' => array(array('type' => 'uri', 'value' => $o)),
                    $nsPing . 'relation' => array(array('type' => 'uri', 'value' => $p))
                )
            ), false
        );

        $store->addStatement(
            $this->_targetGraph, $s, $p, array('value' => $o, 'type' => 'uri'), false
        );

        // Add a title to the source resource
        $titleProps = $this->_options['title_properties'];
        if ($this->_sourceRdf !== null && count($titleProps) > 0) {
            foreach ($this->_sourceRdf as $prop => $oArray) {
                if (in_array($prop, $titleProps)) {
                    $store->addStatement(
                        $this->_targetGraph, $s, $prop, $oArray[0], false
                    );
                    break; // only one title
                }
            }
        }

        $event = new Erfurt_Event('onPingReceived');
        $event->s = $s;
        $event->p = $p;
        $event->o = $o;
        $event->trigger();

        return true;
    }

    protected function _checkTargetExists ($targetUri)
    {
        if ($this->_targetGraph == null) {
            $event = new Erfurt_Event('onNeedsGraphForLinkedDataUri');
            $event->uri = $targetUri;

            $graph = $event->trigger();
            if ($graph) {
                $this->_targetGraph = $graph;
                /*
                 * If we get a target graph from linked data plugin, we know that the target uri
                 * exists, since getGraphsUsingResource ist used by store.
                 */
                return true;
            } else {
                /*
                 * If there is no answer to 'onNeedsGraphForLinkedDataUri' we have to ask the store
                 */
                $store = Erfurt_App::getInstance()->getStore();
                $graphs = $store->getReadableGraphsUsingResource($targetUri);

                if ($graphs === null) {
                    return false;
                } else {
                    $this->_targetGraph = $graphs[0];
                    return true;
                }
            }
        }
    }

    protected function _deleteInvalidPingbacks ($sourceUri, $targetUri, $foundPingbackTriples = array())
    {
        $modelUri = $this->_config->ping->modelUri;
        $nsPing = $this->_config->ping->baseUri;

        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getModelOrCreate($modelUri);

        $query  = 'PREFIX pingback: <' . $nsPing . '>' . PHP_EOL;
        $query .= 'SELECT ?ping ?relation' . PHP_EOL;
        $query .= 'WHERE {' . PHP_EOL;
        $query .= '    ?ping a pingback:Item;' . PHP_EOL;
        $query .= '          pingback:relation ?relation;' . PHP_EOL;
        $query .= '          pingback:source <' . $sourceUri . '>;' . PHP_EOL;
        $query .= '          pingback:target <' . $targetUri . '>.' . PHP_EOL;
        $query .= '}';

        $result = $model->sparqlQuery($query);

        $removed = false;
        if (count($result) > 0) {
            foreach ($result as $row) {
                $found = false;
                foreach ($foundPingbackTriples as $triple) {
                    if ($triple['p'] === $row['relation']) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $model->deleteMatchingStatements($row['ping'], null, null, array('use_ac' => false));

                    $oSpec = array(
                        'value' => $targetUri,
                        'type' => 'uri'
                    );

                    $store->deleteMatchingStatements(
                        $this->_targetGraph,
                        $sourceUri,
                        $row['relation'],
                        $oSpec,
                        array('use_ac' => false)
                    );
                    $removed = true;
                }
            }
        }

        return $removed;
    }

    protected function _determineInverseProperty ($propertyUri)
    {
        $client = Erfurt_App::getInstance()->getHttpClient(
            $propertyUri,
            array(
                'maxredirects' => 10,
                'timeout' => 30
            )
        );
        $client->setHeaders('Accept', 'application/rdf+xml');
        try {
            $response = $client->request();
        } catch (Exception $e) {
            return null;
        }
        if ($response->getStatus() === 200) {
            $data = $response->getBody();

            $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat('rdfxml');
            try {
                $result = $parser->parse($data, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING);
            } catch (Exception $e) {
                return null;
            }

            if (isset($result[$propertyUri])) {
                $pArray = $result[$propertyUri];
                if (isset($pArray['http://www.w3.org/2002/07/owl#inverseOf'])) {
                    $oArray = $pArray['http://www.w3.org/2002/07/owl#inverseOf'];
                    return $oArray[0]['value'];
                }
            }

            return null;
        }
    }

    private function _getResourceFromWrapper ($sourceUri, $targetUri, $wrapperName = 'Linkeddata')
    {
        $r = new Erfurt_Rdf_Resource($sourceUri);

        // Try to instanciate the requested wrapper
        $wrapper = $this->_getWrapper($wrapperName);

        $wrapperResult = null;
        $wrapperResult = $wrapper->run($r, null, true);

        $newStatements = null;
        if ($wrapperResult === false) {
            // IMPORT_WRAPPER_NOT_AVAILABLE;
        } else if (is_array($wrapperResult)) {
            $newStatements = $wrapperResult['add'];
            // TODO make sure to only import the specified resource
            $newModel = new Erfurt_Rdf_MemoryModel($newStatements);
            $newStatements = array();
            $object = array('type' => 'uri', 'value' => $targetUri);
            $newStatements = $newModel->getP($sourceUri, $object);
        } else {
            // IMPORT_WRAPPER_ERR;
        }

        return $newStatements;
    }

    protected function _logError ($msg)
    {
        $logger = Erfurt_App::getInstance()->getLog();

        if (is_array($msg)) {
            $logger->debug('Pingback Component Error: ' . var_export($msg, true));
        } else {
            $logger->debug('Pingback Component Error: ' . $msg);
        }
    }

    protected function _logInfo ($msg)
    {
        $logger = Erfurt_App::getInstance()->getLog();

        if (is_array($msg)) {
            $logger->debug('Pingback Component Info: ' . var_export($msg, true));
        } else {
            $logger->debug('Pingback Component Info: ' . $msg);
        }
    }

    protected function _pingbackExists ($s, $p, $o)
    {
        $modelUri = $this->_config->ping->modelUri;
        $nsPing = $this->_config->ping->baseUri;

        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getModelOrCreate($modelUri);

        $query  = 'PREFIX pingback: <' . $nsPing . '>' . PHP_EOL;
        $query .= 'ASK' . PHP_EOL;
        $query .= 'WHERE {' . PHP_EOL;
        $query .= '    ?ping a pingback:Item;' . PHP_EOL;
        $query .= '          pingback:source <' . $s . '>;' . PHP_EOL;
        $query .= '          pingback:target <' . $o . '>.' . PHP_EOL;
        if ($p !== null) {
            $query .= '    ?ping pingback:relation <' . $p . '>.' . PHP_EOL;
        }
        $query .= '}';

        $exist = $model->sparqlQuery($query);

        if (count($exist) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
