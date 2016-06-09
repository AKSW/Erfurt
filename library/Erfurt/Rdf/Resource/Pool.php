<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Represents a list of resources.
 *
 * @category   Erfurt
 * @package    Erfurt_Rdf
 * @author     Michael Martin <martin@informatik.uni-leipzig.de>
  */
class Erfurt_Rdf_Resource_Pool
{
    /**
     * The array of resources.
     * @var array
     */
    protected $_resources = null;

    /**
     * The currently valide instance of Erfurt_App
     */
    private $_app;

    /**
     * Constructs a new Erfurt_Rdf_ResourcePool instance.
     */
    public function __construct($erfurtApp)
    {
        //maybe something will be here in the future
        $this->_app = $erfurtApp;
    }

    /**
     * add an resource to the list
     *
     * @param Erfurt_Rdf_Resource resource
     * @param string graphIri
     * @return boolean state
     */
    public function addResource($resource, $graphIri = 'store')
    {
        $added = false;
        $graphIri = (string) $graphIri;

        if ($resource instanceOf Erfurt_Rdf_Resource) {
            $id = $resource->getIri();
            $this->_resources[$graphIri][$id] = $resource;
            $added = true ;
        } else {
            if (defined('_OWDEBUG')) {
                $logger = $this->_app->getLog();
                $logger->info('ResourcePool: Given item is not of correct Type and will not be added to the List.');
            }
        }
        return $added;
    }

    /**
     * returns a resource according a given resourceIri
     *
     * @param string resourceIri
     * @param string graphIri or null
     * @return Erfurt_Rdf_Resource resource
     */
    public function getResource($resourceIri, $graphIri = 'store')
    {
        $resource = null;
        if (Erfurt_Uri::check($resourceIri)) {
            if (!empty($this->_resources[$graphIri][$resourceIri])) {
                $resource = $this->_resources[$graphIri][$resourceIri];
            } else {
                if (defined('_OWDEBUG')) {
                    $logger = $this->_app->getLog();
                    $logger->info('ResourcePool: Resource not available and will be created now.');
                }
                $resource = $this->_createResource($resourceIri, $graphIri);
                $this->addResource($resource, $graphIri);
            }
        } else {
            throw new Erfurt_Exception('The given string is not a URI "' . $resourceIri . '"');
        }
        return $resource;
    }

    /**
     * returns an array of resources according a given array of ResourceIris
     *
     * @param array resources
     * @param string graphIri or null
     * @return array of Erfurt_Rdf_Resource
     */
    public function getResources($resourceIris = array(), $graphIri = 'store')
    {
        $resources = array();
        foreach ($resourceIris as $iri) {
            $resource = $this->getResource($iri, $graphIri);
            if ($resource != null) {
                $resources[$iri] = $this->getResource($iri, $graphIri);
            }
        }
        return $resources;
    }

    /**
     * create a Resource
     *
     * @param string resourceIri
     * @param string graphIri or null
     * @return Erfurt_Rdf_Resource resource
     */
    private function _createResource($resourceIri, $graphIri = 'store')
    {
        $resource = null;
        if (Erfurt_Uri::check($resourceIri)) {
            if ($graphIri == 'store') {
                $resource = new Erfurt_Rdf_Resource($resourceIri);
            } else {
                if (Erfurt_Uri::check($graphIri)) {
                    $model = $this->_app->getStore()->getModel($graphIri, false);
                    $resource = $model->getResource($resourceIri);
                } else {
                    if (defined('_OWDEBUG')) {
                        $logger = $this->_app->getLog();
                        $logger->info('ResourcePool: Given GraphIri not valid.');
                    }
                }
            }
        } else {
            if (defined('_OWDEBUG')) {
                $logger = $this->_app->getLog();
                $logger->info('ResourcePool: Given ResourceIri not valid.');
            }
        }
        return $resource;
    }
}
