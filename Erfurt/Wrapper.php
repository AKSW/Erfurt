<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version $Id: Wrapper.php 4013 2009-08-13 14:37:18Z pfrischmuth $
 */

/**
 * This abstract class provides the basis for dedicated data wrapper 
 * implementation classes, that provide RDF data for a given URI. Developers 
 * are encouraged to utilize the built-in config and cache objects in order
 * to make wrappers customizable by the user and to avoid expensive requests
 * to be done to frequent. The default cache lifetime is one hour.
 * 
 * @copyright  Copyright (c) 2009 {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    erfurt
 * @subpackage wrapper
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
abstract class Erfurt_Wrapper
{
    // ------------------------------------------------------------------------
    // --- Constants ----------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /** 
     * States, whether statements have been added by the wrapper. 
     * 
     * @var int
     */
    const STATEMENTS_ADDED = 10;
    
    /** 
     * States, whether statements have been removed by the wrapper. 
     * 
     * @var int
     */
    const STATEMENTS_REMOVE = 20;
    
    /** 
     * States, whether there have not been any modifications by the wrapper. 
     * 
     * @var int
     */
    const NO_MODIFICATIONS = 30;
    
    /** 
     * States, whether the result contains a key 'add', which contains data 
     * to be added. 
     * 
     * @var int
     */
    const RESULT_HAS_ADD = 40;
    
    /** 
     * States, whether the result contains a key 'ns', which contains 
     * namespaces to be added. 
     * 
     * @var int
     */
    const RESULT_HAS_NS = 45;
    
    /** 
     * States, whether the result contains a key 'remove', which can be used 
     * to match statements. 
     * 
     * @var int
     */
    const RESULT_HAS_REMOVE = 50;
    
    /** 
     * States, whether the result contains a key 'added_count', which contains 
     * the number of triples added. 
     * 
     * @var int
     */
    const RESULT_HAS_ADDED_COUNT = 60;
    
    /** 
     * States, whether the result contains a key 'removed_count', which 
     * contains the number of triples removed. 
     * 
     * @var int
     */
    const RESULT_HAS_REMOVED_COUNT = 70;
    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Contains a caching class instance.
     * 
     * @var Erfurt_Cache_Frontend_AutoId
     */
    protected $_cache = null;
    
    /**
     * Contains the parsed configuration, iff existsing.
     * Otherwise this property is set to false.
     * 
     * @var Zend_Config_Ini
     */
    protected $_config = false;
    
    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Initializes the base wrapper class. It provides derived classes with
     * a reference to the config object and a reference to the cache, which 
     * should be used by all implemenataions. If a derived class needs to override
     * this method, it should call this method as the first operation.
     * 
     * @param Zend_Config_Ini
     */
    public function init($config)
    {
        $frontendOptions = array(
            'automatic_serialization' => true
        );
        
        require_once 'Erfurt/Cache/Frontend/ObjectCache.php';
        $frontendAdapter = new Erfurt_Cache_Frontend_ObjectCache($frontendOptions);
        
        $tmpDir = Erfurt_App::getInstance()->getCacheDir();
        if ($tmpDir !== false) {
            $backendOptions = array(
                'cache_dir' => $tmpDir);
                
            require_once 'Zend/Cache/Backend/File.php';
            $backendAdapter = new Zend_Cache_Backend_File($backendOptions);
        } else {
            require_once 'Erfurt/Cache/Backend/Null.php';
            $backendAdapter = new Erfurt_Cache_Backend_Null();
        }
        
        $frontendAdapter->setBackend($backendAdapter);

        $this->_cache  = $frontendAdapter;
        $this->_config = $config;
    }
    
    // ------------------------------------------------------------------------
    // --- Abstract methods ---------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * This method returns a human-readable string that describes the wrapper.
     * 
     * @return string A string representing a description of the wrapper.
     */
    abstract public function getDescription();
    
    /**
     * This method returns a human-readable string that identifies the wrapper. 
     * It is intended that this method is used by an application in order to
     * present the user with a name for the specific wrapper. It will also serve
     * as basis for further translations.
     * 
     * @return string A string representation of the wrapper name.
     */
    abstract public function getName();
    
    /**
     * This method forms the second step in the data fetching process.
     * If a given URI is handled by a wrapper, this method tests whether there
     * is data available for the URI. In many situations this implies,
     * that the data is actually fetched within this method and cached.
     * 
     * @param string $uri The URI to test for available data.
     * @param string $graphUri The URI fro the graph to use. Some wrapper implementations
     * may need it, e.g. to do SPARQL queries against the graph.
     * @return boolean Returns whether there is data available for the given URI or not.
     * @throws Erfurt_Wrapper_Exception
     */ 
    abstract public function isAvailable($uri, $graphUri);
    
    /**
     * This method will be called first in most cases. It therefore should 
     * not yet fetch any data. This method is intended to match a given URI 
     * against a certain URI-schema and return whether the wrapper will handle 
     * such URIs. 
     * 
     * @param string $uri The URI to be tested.
     * @param string $graphUri The URI fro the graph to use. Some wrapper implementations
     * may need it, e.g. to do SPARQL queries against the graph.
     * @return boolean Returns whether the wrapper will handle the given URI.
     * @throws Erfurt_Wrapper_Exception
     */
    abstract public function isHandled($uri, $graphUri);
    
    /**
     * This method actually executes the wrapper. Whatever the internal 
     * realization is like, this method actually does the heavy lifting. 
     * This method returns an array containing the following keys:
     *      
     *      'status_codes': An array containing status code constants.
     *      
     *      'status_desc': A human readable description of the status. 
     *      
     *      'add': (optional) A resource-centric array containing triples
     *      to add to the graph.
     *      
     *      'remove': (optional) An array, which can be used to match 
     *      statements that will be deleted. E.g. array('s' => 'http://...',
     *      'p' => null, 'o' => null) would match all statements with a
     *      given subject.
     *      
     *      'added_count': (optional) Contains the number of statements
     *      the wrapper has already added internally.
     *      
     *      'removed_count': (optional) Contains the number of statements
     *      the wrapper has already removed internally.
     *
     * If the result contains a 'add' key, the value for this key is a
     * resource-centric array of triples as proposed in [1].
     * 
     * [1] @link http://n2.talis.com/wiki/RDF_PHP_Specification
     * 
     * @param string $uri This is the URI for which data should be wrapped.
     * @param string $graphUri The URI fro the graph to use. Some wrapper implementations
     * may need it, e.g. to do SPARQL queries against the graph.
     * @return array|false 
     * @throws Erfurt_Wrapper_Exception
     */
    abstract public function run($uri, $graphUri);
}
