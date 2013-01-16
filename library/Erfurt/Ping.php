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
    private $_receivedData = array();

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
        if (!isset($options['write_data'])) {
            $options['write_data'] = true;
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

        // 1. & 2. Try to dereference the source URI as RDF/XML, N3, Truples, Turtle
        // If nothing was found, try to use as RDFa service
        $foundPingbackTriples = $this->_getResource($sourceUri, $targetUri);

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
            $result = $this->_getHtmlLink($sourceUri, $targetUri);

            if (!is_array($result)) {
                $versioning->endAction();
                return $this->_setErrorCode($result);
            } else {
                $foundPingbackTriples = $result;
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
        $added = $this->_addPingbacks($foundPingbackTriples);

        // Remove all existing pingbacks from that source uri, that were not found this time.
        $removed = $this->_deleteInvalidPingbacks($sourceUri, $targetUri, $foundPingbackTriples);

        if (!$added && !$removed) {
            $versioning->endAction();
            return $this->_setErrorCode(self::$_errRegistered);
        }

        if ($this->_options['write_data'] === true) {
            $this->_writeData();
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

    /**
     * This method returns the received data, which was found at the source
     *
     * @return array of array-triples with the received data
     */
    public function getReceivedData ()
    {
        return $this->_receivedData;
    }

    /**
     * This method checks whether the given target already exists in the local target graph.
     *
     * Tip: When using the Erfurt_Ping in a different environment you can overload this method to
     *      search only in your model.
     *
     * @param $targetUri the uri of the received target
     * @return boolean whether the target resource exists or not
     */
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

    /**
     * This method adds new pingback:Items to the ping model for each received triple.
     *
     * @param $foundPingbackTriples an array of array-triples containing the triples between source
     *                              and target
     * @return boolean true if new pingback:Items where created, else false
     */
    protected function _addPingbacks ($foundPingbackTriples)
    {
        if ($this->_targetGraph === null) {
            return false;
        }

        $pingModelUri = $this->_config->ping->modelUri;
        $nsPing = $this->_config->ping->baseUri;

        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getModelOrCreate($pingModelUri);

        $this->_receivedData['add'] = array();
        $added = false;

        foreach ($foundPingbackTriples as $triple) {
            if ($this->_pingbackExists($triple['s'], $triple['p'], $triple['o'])) {
                // this ping was already received before
                continue;
            }

            $pingUri = $model->createResourceUri('Ping');
            $model->addMultipleStatements(
                array(
                    $pingUri => array (
                        EF_RDF_NS . 'type' => array(
                            array('type' => 'uri', 'value' => $nsPing . 'Item')
                        ),
                        $nsPing . 'source' => array(
                            array('type' => 'uri', 'value' => $triple['s'])
                        ),
                        $nsPing . 'target' => array(
                            array('type' => 'uri', 'value' => $triple['o'])
                        ),
                        $nsPing . 'relation' => array(
                            array('type' => 'uri', 'value' => $triple['p'])
                        )
                    )
                ), false
            );

            $this->_receivedData['add'][] = $triple;

            $event = new Erfurt_Event('onPingReceived');
            $event->s = $triple['s'];
            $event->p = $triple['p'];
            $event->o = $triple['o'];
            $event->trigger();

            $added = true;
        }
        return $added;
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

        $this->_receivedData['delete'] = array();
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
                    $model->deleteMatchingStatements(
                        $row['ping'], null, null, array('use_ac' => false)
                    );
                    $this->_receivedData['delete'][] = array(
                        's' => $sourceUri, 'p' => $row['relation'], 'o' => $targetUri
                    );
                    $removed = true;
                }
            }
        }

        return $removed;
    }

    /**
     * This method writes the received triples to the target graph
     */
    protected function _writeData ()
    {
        $store = Erfurt_App::getInstance()->getStore();
        $model = $store->getModelOrCreate($this->_targetGraph);

        foreach ($this->_receivedData['add'] as $triple) {
            $model->addStatement(
                $triple['s'],
                $triple['p'],
                array('value' => $triple['o'], 'type' => 'uri'),
                false
            );

            // Add a title to the source resource
            // seams unused, because _sourceRdf is never written
            $titleProps = $this->_options['title_properties'];
            if ($this->_sourceRdf !== null && count($titleProps) > 0) {
                foreach ($this->_sourceRdf as $prop => $oArray) {
                    if (in_array($prop, $titleProps)) {
                        $model->addStatement($triple['s'], $prop, $oArray[0], false);
                        break; // only one title
                    }
                }
            }

        }

        foreach ($this->_receivedData['delete'] as $triple) {
            $model->deleteMatchingStatements(
                $triple['s'],
                $triple['p'],
                array('value' => $triple['o'], 'type' => 'uri'),
                array('use_ac' => false)
            );
        }
    }

    /**
     * Get the source resources triples which also contain the target
     * (source as subject, target as object)
     *
     * @param $sourceUri the uri of the ping source
     * @param $targetUri the uri of the ping target
     * @return array containing the source triples as array('s', 'p', 'o') entries
     */
    protected function _getResource ($sourceUri, $targetUri)
    {
        $foundGraph = array();

        // 1. Try to dereference the source URI as RDF/XML, N3, Truples, Turtle
        $foundGraph = $this->_getResourceFromWrapper($sourceUri, $targetUri, 'Linkeddata');

        // 2. If nothing was found, try to use as RDFa service
        if (((boolean) $this->_options['rdfa']) && (count($foundGraph) === 0)) {
            $foundGraph = $this->_getResourceFromWrapper($sourceUri, $targetUri, 'Rdfa');
        }

        $foundTriples = array();
        foreach ($foundGraph as $s => $predicates) {
            foreach ($predicates as $p => $objects) {
                foreach ($objects as $o) {
                    $foundTriples[] = array(
                        's' => $s,
                        'p' => $p,
                        'o' => $o['value']
                    );
                }
            }
        }

        return $foundTriples;
    }

    private function _getResourceFromWrapper ($sourceUri, $targetUri, $wrapperName = 'Linkeddata')
    {
        $r = new Erfurt_Rdf_Resource($sourceUri);

        // Try to instanciate the requested wrapper
        $wrapper = $this->_getWrapper($wrapperName);

        $wrapperResult = $wrapper->run($r, null, true);

        $newStatements = array();
        if ($wrapperResult === false) {
            // IMPORT_WRAPPER_NOT_AVAILABLE;
        } else if (is_array($wrapperResult)) {
            // TODO make sure to only import the specified resource
            $newModel = new Erfurt_Rdf_MemoryModel($wrapperResult['add']);
            $object = array('type' => 'uri', 'value' => $targetUri);
            $newStatements = $newModel->getP($sourceUri, $object);
        } else {
            // IMPORT_WRAPPER_ERR;
        }

        return $newStatements;
    }

    /**
     * This method tries to fetches the source as html and extracts hyperlinks refering to the
     * target.
     *
     * @param $sourceUri the uri of the ping source
     * @param $targetUri the uri of the ping target
     * @return array|int on success an array containing the source triples as array('s', 'p', 'o')
     *         entries or an integer with the error code.
     */
    protected function _getHtmlLink ($sourceUri, $targetUri)
    {
        $erfurt = Erfurt_App::getInstance();
        $client = $erfurt->getHttpClient($sourceUri, array( 'maxredirects' => 10, 'timeout' => 30));

        try {
            $response = $client->request();
        } catch (Exception $e) {
            $this->_logError($e->getMessage());
            return self::$_errUnknown;
        }

        if ($response->getStatus() === 200) {
            $htmlDoc = new DOMDocument();
            $result = @$htmlDoc->loadHtml($response->getBody());
            $aElements = $htmlDoc->getElementsByTagName('a');

            $foundPingbackTriples = array();

            foreach ($aElements as $aElem) {
                $a = $aElem->getAttribute('href');

                if (strtolower($a) === $targetUri) {
                    $foundPingbackTriples[] = array(
                        's' => $sourceUri,
                        'p' => $_options['generic_relation'],
                        'o' => $targetUri
                    );
                    return $foundPingbackTriples;
                }
            }
        } else {
            return self::$_errSNotExist;
        }
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
