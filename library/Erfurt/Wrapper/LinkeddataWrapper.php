<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * This wrapper extension provides functionality for gathering linked data.
 *
 * @category  Erfurt
 * @package   Erfurt_Wrapper
 * @copyright Copyright (c) 2013 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @author    Natanael Arndt <arndtn@gmail.com>
 */
class Erfurt_Wrapper_LinkeddataWrapper extends Erfurt_Wrapper_RdfImportWrapper
{
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Contains cached data if the wrapper is used more than once in one
     * request.
     *
     * @var array|null
     */
    private $_cachedData = null;

    /**
     * Contains cached namespaces if the wrapper is used more than once in one
     * request.
     *
     * @var array|null
     */
    private $_cachedNs = null;

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    public function getDescription()
    {
        return 'This wrapper checks for Linked Data that is accessible through an URI.';
    }

    public function getName()
    {
        return 'Linked Data Wrapper';
    }

    public function isAvailable($r, $graphUri, $all = false)
    {
        $uri = $r->getUri();
        $url = $r->getLocator();

        // Check whether there is a cache hit...
        if (null !== $this->_cache) {
            $id = $this->_cache->makeId($this, 'isAvailable', array($uri, $graphUri));
            $result = $this->_cache->load($id);
            if ($result !== false) {
                if (isset($result['data'])) {
                    $this->_cachedData = $result['data'];
                    $this->_cachedNs   = $result['ns'];
                }

                return $result['value'];
            }
        }

        $retVal = false;
        $ns = array();
        $data = array();

        // Test the URI.
        $this->_url = $url;
        try {
            $client = $this->_getHttpClient(
                $url,
                array(
                    'maxredirects'  => 0,
                    'timeout'       => 30
                )
            );
        } catch (Zend_Uri_Exception $e) {
            return false;
        }

        $client->setHeaders('Accept', 'application/rdf+xml');
        $response = $client->request();
        $success = $this->_handleResponse($client, $response, 'application/rdf+xml');

        if ($success === true) {
            $response = $client->getLastResponse();

            if (null !== $this->_url) {
                $temp = $this->_url;
            } else {
                $temp = $url;
            }

            if (strrpos($url, '#') !== false) {
                $baseUri = substr($temp, 0, strrpos($temp, '#'));
            } else {
                $baseUri = $temp;
            }

            $tempArray = $this->_handleResponseBody($response, $baseUri);
            $ns = $tempArray['ns'];
            $data = $tempArray['data'];
            $retVal = true;
        } else {
            // try n3
            $client->setHeaders('Accept', 'text/n3, text/turtle');
            $response = $client->request();

            $success = $this->_handleResponse($client, $response);
            if ($success === true) {
                $tempArray = $this->_handleResponseBody($client->getLastResponse(), $url);
                $ns = $tempArray['ns'];
                $data = $tempArray['data'];
                $retVal = true;
            } else {
                // try text/html...
                $client->setHeaders('Accept', 'text/html');
                $response = $client->request();

                $success = $this->_handleResponse($client, $response);
                if ($success === true) {
                    $tempArray = $this->_handleResponseBody($client->getLastResponse(), $url);
                    $ns = $tempArray['ns'];
                    $data = $tempArray['data'];
                    $retVal = true;
                }
            }
        }

        $this->_cachedData = $data;
        $this->_cachedNs   = $ns;

        if (null !== $this->_cache) {
            $cacheVal = array('value' => $retVal, 'data' => $data, 'ns' => $ns);
            $this->_cache->save($cacheVal, $id);
        }

        return $retVal;
    }

    public function run($r, $graphUri, $all = false)
    {
        if (null === $this->_cachedData) {
            $isAvailable = $this->isAvailable($r, $graphUri, $all);

            if ($isAvailable === false) {
                return false;
            }
        }

        $data = $this->_cachedData;
        $ns   = $this->_cachedNs;

        $fullResult = array();
        $fullResult['status_codes'] = array(
            Erfurt_Wrapper::NO_MODIFICATIONS,
            Erfurt_Wrapper::RESULT_HAS_ADD,
            Erfurt_Wrapper::RESULT_HAS_NS
        );

        $uri = $r->getUri();

        $fullResult['status_description'] = "Linked Data found for URI $uri";
        $fullResult['ns'] = $ns;
        $fullResult['add'] = $data;

        return $fullResult;
    }

    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Handles the data contained in a response.
     */
    private function _handleResponseBody($response, $baseUri = null)
    {
        $contentType = $response->getHeader('Content-type');
        if ($pos = strpos($contentType, ';')) {
            $contentType = substr($contentType, 0, $pos);
        }

        $found = false;
        if ($contentType == 'text/plain' && !empty($baseUri)) {
            //if the mime type does not reveal anything, try file endings. duh
            $parts = parse_url($baseUri);
            $ending = pathinfo($parts['path'], PATHINFO_EXTENSION);
            $found = true;
            switch ($ending) {
                case 'n3':
                case 'ttl':
                    $type = 'rdfn3';
                    break;
                case 'xml':
                    $type = 'rdfxml';
                    break;
                case 'json':
                    $type = 'rdfjson';
                    break;
                default:
                    $found = false;
                    break;
            }
        }
        if (!$found) {
            //use the defined mime type
            switch ($contentType) {
                case 'application/rdf+xml':
                case 'application/xml': // Hack for lsi urns
                case 'text/plain':
                    $type = 'rdfxml';
                    break;
                case 'application/json':
                    $type = 'rdfjson';
                    break;
                case 'text/rdf+n3':
                case 'text/n3':
                case 'text/turtle':
                case 'application/x-turtle':
                    $type = 'rdfn3';
                    break;
                case 'text/html':
                    return $this->_handleResponseBodyHtml($response, $baseUri);
                case '':
                    $type = $this->_checkExtension($baseUri);
                    if ($type != false) {
                        break;
                    }
                default:
                    throw new Erfurt_Wrapper_Exception('Server returned not supported content type: ' . $contentType);
            }
        }

        $data = $response->getBody();

        $parser = Erfurt_Syntax_RdfParser::rdfParserWithFormat($type);
        $result = $parser->parse($data, Erfurt_Syntax_RdfParser::LOCATOR_DATASTRING, $baseUri);
        $ns     = $parser->getNamespaces();

        return array(
            'data' => $result,
            'ns'   => $ns
        );
    }

    private function _handleResponseBodyHtml($response, $baseUri = null)
    {
        $htmlDoc = new DOMDocument();
        $result = @$htmlDoc->loadHtml($response->getBody());

        $relElements = $htmlDoc->getElementsByTagName('link');

        $documents = array();
        foreach ($relElements as $relElem) {
            $rel  = $relElem->getAttribute('rel');
            $type = $relElem->getAttribute('type');

            if (strtolower($rel) === 'meta' && strtolower($type) === 'application/rdf+xml') {
                $documents[] = $relElem->getAttribute('href');
            }
        }

        $fullNs     = array();
        $fullResult = array();

        $client = $this->_getHttpClient(
            null,
            array(
                'maxredirects'  => 0,
                'timeout'       => 30
            )
        );
        $client->setHeaders('Accept', 'application/rdf+xml');

        foreach ($documents as $docUrl) {

            $client->setUri($docUrl);
            $response = $client->request();

            $success = $this->_handleResponse($client, $response);

            if ($success === true) {
                $response = $client->getLastResponse();

                if (null !== $this->_url) {
                    $temp = $this->_url;
                } else {
                    $temp = $docUrl;
                }

                if (strrpos($temp, '#') !== false) {
                    $baseUri = substr($temp, 0, strrpos($temp, '#'));
                } else {
                    $baseUri = $temp;
                }

                $tempArray = $this->_handleResponseBody($response, $baseUri);
                $fullNs = array_merge($tempArray['ns'], $fullNs);
                $tempArray = $tempArray['data'];

                foreach ($tempArray as $s=>$pArray) {
                    if (isset($fullResult[$s])) {
                        foreach ($pArray as $p=>$oArray) {
                            if (isset($fullResult[$s][$p])) {
                                foreach ($oArray as $o) {
                                    // TODO Make a full check in order to avoid duplicate objects!
                                    $fullResult[$s][$p][] = $o;
                                }
                            } else {
                                $fullResult[$s][$p] = $oArray;
                            }
                        }
                    } else {
                        $fullResult[$s] = $pArray;
                    }
                }

            } else {
                // Do nothing for the moment...
            }
        }

        return array(
            'data' => $fullResult,
            'ns'   => $fullNs
        );
    }

    private function _checkExtension($uri)
    {
        $hashPos = strrpos($uri, '#');
        if ($hashPos == false) {
            $hashPos = strlen($uri);
        }
        $url = substr($uri, 0, $hashPos);
        $extension = strrchr($url, '.');
        switch ($extension) {
            case '.rdf':
                return 'rdfxml';
            case '.ttl':
            case '.nt':
            case '.n3':
                return 'rdfn3';
            case '.json':
                return 'rdfjson';
            default:
                return false;
        }
    }
}
