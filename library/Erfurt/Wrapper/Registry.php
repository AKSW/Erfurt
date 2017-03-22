<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * This class acts as the central registry for all active wrapper extensions.
 * It provides functionality for listing all active wrapper extensions and
 * gives access to wrapper instances.
 *
 * @copyright  Copyright (c) 2012 {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @package    Erfurt_Wrapper
 */
class Erfurt_Wrapper_Registry
{
    /**
     * This static property contains the instance, for this class is realized
     * following the singleton pattern.
     * 
     * @var Erfurt_Wrapper_Registry
     */
    private static $_instance = null;

    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * This property contains all registered (active) wrapper.
     * 
     * @var array
     */
    protected $_wrapperRegistry = array();

    // ------------------------------------------------------------------------
    // --- Magic methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * The constructor is private, for this class is a singleton.
     */
    private function __construct()
    {
        $this->_addDefaultWrappers();
    }

    // ------------------------------------------------------------------------
    // --- Public static methods ----------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Returns the one and only instance of this class.
     * 
     * @return Erfurt_Wrapper_Registry
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new Erfurt_Wrapper_Registry();
        }

        return self::$_instance;
    }

    /**
     * Destroys the current instance. Next time getInstance is called a new
     * instance will be created.
     */
    public static function reset()
    {
        if (self::$_instance != null) {
            self::$_instance->_wrapperRegistry = array();
        }
        self::$_instance = null;
    }

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Returns the instanciated wrapper class specified by the given wrapper
     * name. If no such a wrapper is registered, this method throws an exception.
     * 
     * @param string $wrapperName
     * @throws Erfurt_Wrapper_Exception
     */
    public function getWrapperInstance($wrapperName)
    {
        if ($wrapperName === 'Erfurt_Wrapper_Test') {
            return new Erfurt_Wrapper_Test();
        }

        $wrapperName = strtolower($wrapperName);
        if (!isset($this->_wrapperRegistry[$wrapperName])) {
            throw new Erfurt_Wrapper_Exception("A wrapper with name '$wrapperName' has not been registered.");
        }

        if (null === $this->_wrapperRegistry[$wrapperName]['instance']) {
            $pathSpec = rtrim($this->_wrapperRegistry[$wrapperName]['include_path'], '/\\')
                      . DIRECTORY_SEPARATOR
                      . ucfirst($wrapperName) . 'Wrapper.php';

            require_once $pathSpec;
            $cn = $this->_wrapperRegistry[$wrapperName]['class_name'];
            if(!class_exists($cn)){
                throw new Erfurt_Wrapper_Exception("class ".$cn." not found - check class name in ".$pathSpec);
            }
            $instance = new $cn;
            $instance->init($this->_wrapperRegistry[$wrapperName]['config']);
            $this->_wrapperRegistry[$wrapperName]['instance'] = $instance;
        }

        return $this->_wrapperRegistry[$wrapperName]['instance'];
    }

    /**
     * Returns a list containing all active wrapper.
     * 
     * @return array
     */
    public function listActiveWrapper()
    {
        return array_keys($this->_wrapperRegistry);
    }

    /**
     * Registers a given wrapper within the registry. The wrapper specification
     * contains the following keys: class_name, include_path, config, instance.
     * 
     * @param string $wrapperName
     * @param array $wrapperSpec
     * @throws Erfurt_Wrapper_Exception
     */
    public function register($wrapperName, $wrapperSpec)
    {
        // We alway use a lowercase key.
        $wrapperName = strtolower($wrapperName);

        if (isset($this->_wrapperRegistry[$wrapperName])) {
            throw new Erfurt_Wrapper_Exception("A wrapper with name '$wrapperName' has already been registered.");
        }

        $this->_wrapperRegistry[$wrapperName] = $wrapperSpec;
    }

    /**
     * Ths method iterates through the Wrapper directory in Erfurt to import all default Wrappers
     */
    protected function _addDefaultWrappers()
    {
        $defaultPath = EF_BASE . 'Wrapper' . DIRECTORY_SEPARATOR;

        $iterator = new DirectoryIterator($defaultPath);

        foreach ($iterator as $file) {
            $fileName  = $file->getFileName();
            if (!$file->isDot() && !$file->isDir() && $this->_isWrapperFile($fileName) && !$this->_isAbstract($fileName)) {

                $wrapperName = $this->_getWrapperName($fileName);
                $wrapperSpec = array(
                        'class_name'   => 'Erfurt_Wrapper_' . $wrapperName . 'Wrapper',
                        'include_path' => $defaultPath,
                        'config'       => false,
                        'instance'     => null
                );

                // Finally register the wrapper.
                $activeWrappers = $this->listActiveWrapper();
                if (!isset($activeWrappers[$wrapperName])) {
                    $this->register($wrapperName, $wrapperSpec);
                }
            }
        }
    }

    private function _isWrapperFile($fileName)
    {
        $length = strlen('Wrapper.php');
        if ($length == 0) {
            return true;
        }

        $start  = $length * -1; //negative
        return (substr($fileName, $start) === 'Wrapper.php');
    }

    private function _isAbstract($filename)
    {
        $testClass = new ReflectionClass('Erfurt_Wrapper_' . substr($filename,0,-4));
        return $testClass->isAbstract();
    }

    private function _getWrapperName($fileName)
    {
        $pos = strpos($fileName, 'Wrapper.php');

        return substr($fileName, 0, $pos);
    }
}
