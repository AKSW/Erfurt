<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * This wrapper extension provides functionality for gathering linked data.
 *
 * @category  Erfurt
 * @package   Erfurt_Wrapper
 * @copyright Copyright (c) 2014 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author    Natanael Arndt <arndt@informatik.uni-leipzig.de>
 */
class Erfurt_Wrapper_SparqlWrapper extends Erfurt_Wrapper
{
    // ------------------------------------------------------------------------
    // --- Private properties -------------------------------------------------
    // ------------------------------------------------------------------------

    private $_httpAdapter = null;
    private $_endpointUri = '';
    private $_cachedData = null;

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    public function __construct()
    {
        $this->_endpointUri = 'http://dbpedia.org/sparql/';
    }

    public function getDescription()
    {
        return 'This wrapper requests a resource description form a given SPARQL endpoint.';
    }

    public function getName()
    {
        return 'SPARQL Wrapper';
    }

    public function isAvailable($r, $graphUri, $all = false)
    {
        $uri = $r->getUri();

        $retVal = false;
        $ns = array();
        $data = array();

        // Test the URI.
        try {
            $client = $this->_getHttpClient(
                $this->_endpointUri,
                array(
                    'timeout'       => 30
                )
            );
        } catch (Zend_Uri_Exception $e) {
            return false;
        }

        $query = 'construct {<' . $uri . '> ?p ?o } where {<' . $uri . '> ?p ?o}';

        $logger = Erfurt_App::getInstance()->getLog();
        $logger->debug("Register new Wrapper: $query");

        $client->setParameterPost('query', $query);
        $client->setHeaders('Accept', 'application/sparql-results+xml; q=1.0, applicaton/sparql-results+json; q=1.0, applicaton/sparql-results+csv; q=1.0, application/rdf+xml; q=1.0, text/turtle; q=1.0, text/n3; q=1.0, */*; q=0.4');
        $response = $client->request();
        $success = $this->_handleResponse($client, $response, 'application/rdf+xml');

        $this->_cachedData = $data;
        $this->_cachedNs   = $ns;

        return $retVal;
    }

    public function isHandled($r, $graphUri)
    {
        $url = $r->getLocator();

        // We only support HTTP URLs.
        if ((substr($url, 0, 7) == 'http://') || (substr($url, 0, 8) == 'https://')) {
            return true;
        }
        return false;
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

    public function setHttpAdapter($adapter)
    {
        $this->_httpAdapter = $adapter;
    }

    // ------------------------------------------------------------------------
    // --- Private methods ----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Handles the different response codes for a given response.
     */
    private function _handleResponse(&$client, $response, $accept = null)
    {
        switch ($response->getStatus()) {
            case 302:
            case 303:
                // 303 See also... Do a second request with the new url
                $this->_url = $response->getHeader('Location');
                $client->setUri($this->_url);
                $response = $client->request();

                return $this->_handleResponse($client, $response);
            case 200:
                // 200 OK
                return true;
            case 401:
                // In this case we try to request the service again with credentials.
                $identity = Erfurt_App::getInstance()->getAuth()->getIdentity();
                if (!$identity->isWebId()) {
                    // We only support WebIDs here.
                    return false;
                }

                $url = $this->_url;
                if (substr($url, 0, 7) === 'http://') {
                    // We need SSL here!
                    $url = 'https://' . substr($url, 7);
                    $client->setUri($url);
                }

                // We need a valid cert that cats as the client cert for the request
                $config = Erfurt_App::getInstance()->getConfig();
                if (isset($config->auth->foafssl->agentCertFilename)) {
                    $certFilename = $config->auth->foafssl->agentCertFilename;
                } else {
                    return false;
                }

                $client = $this->_getHttpClient(
                    $url,
                    array(
                        'maxredirects'  => 10,
                        'timeout'       => 30,
                        'sslcert'       => $certFilename
                    )
                );

                if (null !== $accept) {
                    $client->setHeaders('Accept', $accept);
                }

                $client->setHeaders(
                    'Authorization',
                    'FOAF+SSL '.base64_encode('ow_auth_user_key="' . $identity->getUri() . '"'),
                    true
                );

                $response = $client->request();

                return $this->_handleResponse($client, $response, $accept);
            default:
                return false;
        }
    }

    /**
     * Handles the data contained in a response.
     */
    private function _handleResponseBody($response, $baseUri = null)
    {
        $contentType = $response->getHeader('Content-type');
        if ($pos = strpos($contentType, ';')) {
            $contentType = substr($contentType, 0, $pos);
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

    private function _getHttpClient ($uri, $options = array())
    {
        if (null !== $this->_httpAdapter) {
            $options['adapter'] = $this->_httpAdapter;
        }
        // TODO Create HTTP client here and remove method from Erfurt_App.
        return Erfurt_App::getInstance()->getHttpClient($uri, $options);
    }
}
