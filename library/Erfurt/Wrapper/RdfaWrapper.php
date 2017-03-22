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
class Erfurt_Wrapper_RdfaWrapper extends Erfurt_Wrapper_RdfImportWrapper
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
}
