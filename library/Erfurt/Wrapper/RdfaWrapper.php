<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * Initial version of a wrapper for RDFa.
 *
 * @copyright  Copyright (c) 2010 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    Erfurt_Wrapper
 */
class Erfurt_Wrapper_RdfaWrapper extends Erfurt_Wrapper
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
     * If the location of the data differs from the tested URI, this property
     * contains the current URL.
     *
     * @var string|null
     */
    private $_url = null;

    private $_httpAdapter = null;

    public function getDescription()
    {
        return 'A simple wrapper to extract RDFa data HTML pages';
    }

    public function getName()
    {
        return 'RDFa';
    }

    public function init($config)
    {
        parent::init($config);

    }

    public function isAvailable($r, $graphUri)
    {
      $uri = $r->getUri();
      $url = $r->getLocator();

      $retVal = false;
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

      $response = $client->request();
      $success = $this->_handleResponse($client, $response);

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

          $data = $this->_handleResponseBody($response, $baseUri);
          $retVal = true;
      }

      $this->_cachedData = $data;

      return $retVal;

    }

    public function isHandled($r, $graphUri)
    {
        $url = $r->getLocator();

        // We only support HTTP URLs.
        if ((substr($url, 0, 7) !== 'http://') && (substr($url, 0, 8) !== 'https://')) {
            return false;
        } else {
            if (isset($this->_config->handle->mode) && $this->_config->handle->mode === 'none') {
                if (isset($this->_config->handle->exception)) {
                    // handle only explicit mentioned uris
                    $isHandled = false;
                    foreach ($this->_config->handle->exception->toArray() as $exception) {
                        if ($this->_matchUri($exception, $url)) {
                            $isHandled = true;
                            break;
                        }
                    }

                    return $isHandled;
                } else {
                    return false;
                }
            } else {
                // handle all uris by default
                if (isset($this->_config->handle->exception)) {
                    foreach ($this->_config->handle->exception->toArray() as $ignored) {
                        if ($this->_matchUri($ignored, $url)) {
                            return false;
                        }
                    }
                } else {
                    return true;
                }
            }
        }

        return true;
    }

    public function run($r, $graphUri)
    {
        $isAvailable = $this->isAvailable($r, $graphUri);
        if ($isAvailable === false) {
          return false;
        }
        $data = $this->_cachedData;
        $uri = $r->getUri();
        if ((!isset($data[$uri][EF_RDF_TYPE])) &&
            (isset($this->_config->defaultClass))) {
                $data[$uri][EF_RDF_TYPE][] = array(
                    'type'  => 'uri',
                    'value' => $this->_config->defaultClass
                );
        }
        $fullResult = array();
        $fullResult['status_codes'] = array(
            Erfurt_Wrapper::NO_MODIFICATIONS,
            Erfurt_Wrapper::RESULT_HAS_ADD
        );

        $fullResult['status_description'] = "RDFa data found for URI $uri";
        $fullResult['add'] = $data;
        return $fullResult;
    }

    public function setHttpAdapter($adapter)
    {
        $this->_httpAdapter = $adapter;
    }

    private function _handleResponse(&$client, $response)
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

                $client->setHeaders(
                    'Authorization',
                    'FOAF+SSL '.base64_encode('ow_auth_user_key="' . $identity->getUri() . '"'),
                    true
                );

                $response = $client->request();

                return $this->_handleResponse($client, $response);
            default:
                return false;
        }
    }

    private function _handleResponseBody($response, $baseUri = null)
    {
        $data = $response->getBody();

        $graph = new EasyRdf_Graph();
        $parser = new EasyRdf_Parser_Rdfa();

        $parser->parse($graph, $data, 'rdfa', $baseUri);
        $tmpdata = $graph->toRdfPhp();
        //filter object bnodes because the filter searches for the 'bnode' type which does not exist for easyrdf
        $data = array();
        foreach ($tmpdata as $s => $pArray) {
            foreach ($pArray as $p => $oArray) {
                foreach ($oArray as $oSpec) {
                    preg_match('/_:genid([0-9])+/', $oSpec['value'], $matches);
                    if (!empty($matches)) {
                        $oSpec['type'] = 'bnode';
                    }
                    if (!isset($data[$s])) {
                        $data[$s] = array();
                    }
                    if (!isset($data[$s][$p])) {
                        $data[$s][$p] = array();
                    }
                    $data[$s][$p][] = $oSpec;
                }
            }
        }
        return  $data;
    }

    private function _matchUri($pattern, $uri)
    {
        if ((substr($pattern, 0, 7) !== 'http://')) {
            $pattern = 'http://' . $pattern;
        }
        if ((substr($uri, 0, strlen($pattern)) === $pattern)) {
            return true;
        } else {
            return false;
        }
    }

    private function _getHttpClient($uri, $options = array())
    {
        if (null !== $this->_httpAdapter) {
            $options['adapter'] = $this->_httpAdapter;
        }
        // TODO Create HTTP client here and remove method from Erfurt_App.
        return Erfurt_App::getInstance()->getHttpClient($uri, $options);
    }
}
