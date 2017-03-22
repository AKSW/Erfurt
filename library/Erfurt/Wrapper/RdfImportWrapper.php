<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2017, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * This abstract class implements the functions for dedicated rdf import wrapper
 * implementation classes, that provide RDF data for a given URI. Developers
 * are encouraged to utilize the built-in config and cache objects in order
 * to make wrappers customizable by the user and to avoid expensive requests
 * to be done to frequent. The default cache lifetime is one hour.
 *
 * @copyright  Copyright (c) 2017 {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    Erfurt
 * @author     Fabian Niehoff <niehoff.fabian@web.de>
 */
abstract class Erfurt_Wrapper_RdfImportWrapper extends Erfurt_Wrapper
{

    /**
     * If the location of the data differs from the tested URI, this property
     * contains the current URL.
     *
     * @var string|null
     */
    protected $_url = null;

    protected $_httpAdapter = null;

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

    public function setHttpAdapter($adapter)
    {
        $this->_httpAdapter = $adapter;
    }

    /**
     * Handles the different response codes for a given response.
     */
    protected function _handleResponse(&$client, $response, $accept = null)
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

    protected function _matchUri ($pattern, $uri)
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

    protected function _getHttpClient ($uri, $options = array())
    {
        if (null !== $this->_httpAdapter) {
            $options['adapter'] = $this->_httpAdapter;
        }
        // TODO Create HTTP client here and remove method from Erfurt_App.
        return Erfurt_App::getInstance()->getHttpClient($uri, $options);
    }

}