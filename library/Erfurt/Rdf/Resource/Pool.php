<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
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
     * The Erfurt_Rdf_ResourcePool instance.
     * @var Erfurt_Rdf_ResourcePool
     */
    private static $_instance = null;

    /**
     * Constructs a new Erfurt_Rdf_ResourcePool instance.
     */
    public function __construct()
    {
        //maybe something will be here in the future
    }

    /**
     * Singleton instance
     *
     * @return Instance of Erfurt_Rdf_ResourcePool
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
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
                $logger = OntoWiki::getInstance()->logger;
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
                    $logger = OntoWiki::getInstance()->logger;
                    $logger->info('ResourcePool: Resource not available and will be created now.');
                }
                $resource = $this->_createResource($resourceIri, $graphIri);
                $this->addResource($resource, $graphIri);
            }
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
                    $model = new Erfurt_Rdf_Model($graphIri);
                    $resource = new Erfurt_Rdf_Resource($resourceIri, $model);
                } else {
                    if (defined('_OWDEBUG')) {
                        $logger = OntoWiki::getInstance()->logger;
                        $logger->info('ResourcePool: Given GraphIri not valid.');
                    }
                }
            }
        } else {
            if (defined('_OWDEBUG')) {
                $logger = OntoWiki::getInstance()->logger;
                $logger->info('ResourcePool: Given ResourceIri not valid.');
            }
        }
        return $resource;
    }
}
