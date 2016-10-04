<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @package   Erfurt_Syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Syntax_RdfParser
{   
    const LOCATOR_URL        = 10;
    const LOCATOR_FILE       = 20;
    const LOCATOR_DATASTRING = 30;

    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_Interface
     */
    private $_parserAdapter = null;

    private $_httpClient = null;
    private $_httpClientAdapter = null;

    private $_dataCache = array();
    
    public static function rdfParserWithFormat($format)
    {
        $parser = new Erfurt_Syntax_RdfParser();
        $parser->initializeWithFormat($format);
        
        return $parser;
    }
    
    public function initializeWithFormat($format)
    {
        $format = strtolower($format);
        
        switch ($format) {
            case 'rdfxml':
            case 'xml':
            case 'rdf':
                $this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();
                break;
            case 'turtle':
            case 'ttl':
            case 'nt':
            case 'ntriple':
            case 'ntriples':
            case 'n3':
            case 'rdfn3':
                $this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_Turtle();
                break;
            case 'json':
            case 'rdfjson':
                $this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();
                break;
            default:
                throw new Erfurt_Syntax_RdfParserException("Format '$format' not supported");
        }        
    }
    
    public function reset()
    {
        $this->_parserAdapter->reset();
    }
    
    /**
     *
     *
     * @param string $dataPointer E.g. a filename, a url or the data to parse itself.
     * @param int $pointerType One of the supported pointer types.
     * @param string|null $baseUri
     * @return array Returns an RDF/PHP array.
     * @throws Erfurt_Syntax_RdfParserException
     */
    public function parse($dataPointer, $pointerType, $baseUri = null)
    {
        if ($pointerType === self::LOCATOR_URL) {
            $dataString = $this->fetchDataFromUrl($dataPointer);
            if (!$dataString) {
                throw new Erfurt_Syntax_RdfParserException('Failed to fetch data from URL:' . $dataPointer);
            }
            $result = $this->_parserAdapter->parseFromDataString($dataString, $baseUri);
        } else if ($pointerType === self::LOCATOR_FILE) {
            $result = $this->_parserAdapter->parseFromFilename($dataPointer);
        } else if ($pointerType === self::LOCATOR_DATASTRING) {
            $result = $this->_parserAdapter->parseFromDataString($dataPointer, $baseUri);
        } else {
            throw new Erfurt_Syntax_RdfParserException('Type of data pointer not valid.');
        }
        
        return $result;
    }

    public function fetchDataFromUrl($url)
    {
        // replace all whitespaces (prevent possible CRLF Injection attacks)
        // http://www.acunetix.com/websitesecurity/crlf-injection.htm
        $url = preg_replace('/\\s+/', '', $url);

        if (!isset($this->_dataCache[$url])) {
            $client = $this->_httpClient($url);
            $response = $client->request();

            if ($response->getStatus() === 200) {
                $this->_dataCache[$url] = $response->getBody();
            } else {
                $this->_dataCache[$url] = true; // mark as already fetched
            }
        }

        if (is_string($this->_dataCache[$url])) {
            return $this->_dataCache[$url];
        }

        return false;
    }

    /**
     * Call this method after parsing only. The function parseToStore will add namespaces automatically.
     * This method is just for situations, where the namespaces are needed to after a in-memory parsing.
     * 
     * @return array
     */
    public function getNamespaces()
    {
        if (method_exists($this->_parserAdapter, 'getNamespaces')) {
            return $this->_parserAdapter->getNamespaces();
        } else {
            return array();
        }
    }
    
    public function parseNamespaces($dataPointer, $pointerType)
    {
        if ($pointerType === self::LOCATOR_URL) {
            $dataString = $this->fetchDataFromUrl($dataPointer);
            if (!$dataString) {
                throw new Erfurt_Syntax_RdfParserException('Failed to fetch data from URL:' . $dataPointer);
            }

            $result = $this->_parserAdapter->parseNamespacesFromDataString($dataString);
        } else if ($pointerType === self::LOCATOR_FILE) {
            $result = $this->_parserAdapter->parseNamespacesFromFilename($dataPointer);
        } else if ($pointerType === self::LOCATOR_DATASTRING) {
            $result = $this->_parserAdapter->parseNamespacesFromDataString($dataPointer);
        } else {
            throw new Erfurt_Syntax_RdfParserException('Type of data pointer not valid.');
        }
        
        return $result;
    }
    
    public function getBaseUri()
    {
        return $this->_parserAdapter->getBaseUri();
    }
    
    public function parseToStore($dataPointer, $pointerType, $modelUri, $useAc = true, $baseUri = null)
    {
        if ($pointerType === self::LOCATOR_URL) {
            $dataString = $this->fetchDataFromUrl($dataPointer);
            if (!$dataString) {
                throw new Erfurt_Syntax_RdfParserException('Failed to fetch data from URL:' . $dataPointer);
            }

            $result = $this->_parserAdapter->parseFromDataStringToStore($dataString, $modelUri, $useAc, $baseUri);
        } else if ($pointerType === self::LOCATOR_FILE) {
            $result = $this->_parserAdapter->parseFromFilenameToStore($dataPointer, $modelUri, $useAc);
        } else if ($pointerType === self::LOCATOR_DATASTRING) {
            $result = $this->_parserAdapter->parseFromDataStringToStore($dataPointer, $modelUri, $useAc, $baseUri);
        } else {
            throw new Erfurt_Syntax_RdfParserException('Type of data pointer not valid.');
        }
        
        return $result;
    }

    /**
     *
     * @param $url
     * @return Zend_Http_Client
     */
    private function _httpClient($url = null)
    {
        if (null === $this->_httpClient) {
            $options = array(
                'maxredirects' => 10,
                'timeout'      => 30
            );

            if (null !== $this->_httpClientAdapter) {
                $options['adapter'] = $this->_httpClientAdapter;
            }

            $this->_httpClient = Erfurt_App::getInstance()->getHttpClient(
                $url,
                $options
            );

            if ($this->_parserAdapter instanceof Erfurt_Syntax_RdfParser_Adapter_RdfXml) {
                $this->_httpClient->setHeaders('Accept', 'application/rdf+xml, text/plain');
            } else if ($this->_parserAdapter instanceof Erfurt_Syntax_RdfParser_Adapter_Turtle) {
                $this->_httpClient->setHeaders('Accept', 'text/turtle, text/plain');
            } else if ($this->_parserAdapter instanceof Erfurt_Syntax_RdfParser_Adapter_RdfJson) {
                $this->_httpClient->setHeaders('Accept', 'application/rdf+json, text/plain');
            }
        }

        return $this->_httpClient;
    }

    /**
     * For testing purposes the HTTP client used for retrieving remote data can be overwritten.
     *
     * @param $httpClientAdapter
     */
    public function setHttpClientAdapter($httpClientAdapter)
    {
        $this->_httpClientAdapter = $httpClientAdapter;
    }
}
