<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category  Zend
 * @package   Zend_Config
 * @copyright Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd     New BSD License
 * @version   $Id: Xml.php 11427 2008-09-18 16:11:43Z doctorrock83 $
 */

/**
 * @see Zend_Config
 */
require_once 'Zend/Config.php';

/**
 * XML Adapter for Zend_Config
 *
 * @category  Zend
 * @package   Zend_Config
 * @copyright Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Config_Xml extends Zend_Config
{
    /**
     * Loads the section $section from the config file $filename for
     * access facilitated by nested object properties.
     *
     * Sections are defined in the XML as children of the root element.
     *
     * In order to extend another section, a section defines the "extends"
     * attribute having a value of the section name from which the extending
     * section inherits values.
     *
     * Note that the keys in $section will override any keys of the same
     * name in the sections that have been included via "extends".
     *
     * @param  string  $filename           File to process
     * @param  mixed   $section            Section to process
     * @param  boolean $allowModifications Wether modifiacations are allowed at runtime
     * @throws Zend_Config_Exception When filename is not set
     * @throws Zend_Config_Exception When section $sectionName cannot be found in $filename
     */
    public function __construct($filename, $section = null, $allowModifications = false)
    {
        if (empty($filename)) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('Filename is not set');
        }

        set_error_handler(array($this, '_loadFileErrorHandler'));
        $config = simplexml_load_file($filename); // Warnings and errors are suppressed
        restore_error_handler();
        // Check if there was a error while loading file
        if ($this->_loadFileErrorStr !== null) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception($this->_loadFileErrorStr);
        }

        if ($section === null) {
            $dataArray = array();
            foreach ($config as $sectionName => $sectionData) {
                $dataArray[$sectionName] = $this->_processExtends($config, $sectionName);
            }

            parent::__construct($dataArray, $allowModifications);
        } else if (is_array($section)) {
            $dataArray = array();
            foreach ($section as $sectionName) {
                if (!isset($config->$sectionName)) {
                    require_once 'Zend/Config/Exception.php';
                    throw new Zend_Config_Exception("Section '$sectionName' cannot be found in $filename");
                }

                $dataArray = array_merge($this->_processExtends($config, $sectionName), $dataArray);
            }

            parent::__construct($dataArray, $allowModifications);
        } else {
            if (!isset($config->$section)) {
                require_once 'Zend/Config/Exception.php';
                throw new Zend_Config_Exception("Section '$section' cannot be found in $filename");
            }

            $dataArray = $this->_processExtends($config, $section);
            if (!is_array($dataArray)) {
                // Section in the XML file contains just one top level string
                $dataArray = array($section => $dataArray);
            }

            parent::__construct($dataArray, $allowModifications);
        }

        $this->_loadedSection = $section;
    }

    /**
     * Helper function to process each element in the section and handle
     * the "extends" inheritance attribute.
     *
     * @param  SimpleXMLElement $element XML Element to process
     * @param  string           $section Section to process
     * @param  array            $config  Configuration which was parsed yet
     * @throws Zend_Config_Exception When $section cannot be found
     * @return array
     */
    protected function _processExtends(SimpleXMLElement $element, $section, array $config = array())
    {
        if (!isset($element->$section)) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception("Section '$section' cannot be found");
        }

        $thisSection = $element->$section;

        if (isset($thisSection['extends'])) {
            $extendedSection = (string) $thisSection['extends'];
            $this->_assertValidExtend($section, $extendedSection);
            $config = $this->_processExtends($element, $extendedSection, $config);
        }

        $config = $this->_arrayMergeRecursive($config, $this->_toArray($thisSection));

        return $config;
    }

    /**
     * Returns a string or an associative and possibly multidimensional array from
     * a SimpleXMLElement.
     *
     * @param  SimpleXMLElement $xmlObject Convert a SimpleXMLElement into an array
     * @return array|string
     */
    protected function _toArray(SimpleXMLElement $xmlObject)
    {
        $config = array();

        // Search for parent node values
        if (count($xmlObject->attributes()) > 0) {
            foreach ($xmlObject->attributes() as $key => $value) {
                if ($key === 'extends') {
                    continue;
                }

                $value = (string) $value;

                if (array_key_exists($key, $config)) {
                    if (!is_array($config[$key])) {
                        $config[$key] = array($config[$key]);
                    }

                    $config[$key][] = $value;
                } else {
                    $config[$key] = $value;
                }
            }
        }

        // Search for children
        if (count($xmlObject->children()) > 0) {
            foreach ($xmlObject->children() as $key => $value) {
                if (count($value->children()) > 0) {
                    $value = $this->_toArray($value);
                } else if (count($value->attributes()) > 0) {
                    $attributes = $value->attributes();
                    if (isset($attributes['value'])) {
                        $value = (string) $attributes['value'];
                    } else {
                        $value = $this->_toArray($value);
                    }
                } else {
                    $value = (string) $value;
                }

                if (array_key_exists($key, $config)) {
                    if (!is_array($config[$key]) || !array_key_exists(0, $config[$key])) {
                        $config[$key] = array($config[$key]);
                    }

                    $config[$key][] = $value;
                } else {
                    $config[$key] = $value;
                }
            }
        } else if (!isset($xmlObject['extends']) && (count($config) === 0)) {
            // Object has no children nor attributes and doesn't use the extends
            // attribute: it's a string
            $config = (string) $xmlObject;
        }

        return $config;
    }

    /**
     * Merge two arrays recursively, overwriting keys of the same name
     * in $array1 with the value in $array2.
     *
     * @param  mixed $firstArray  First array
     * @param  mixed $secondArray Second array to merge into first array
     * @return array
     */
    protected function _arrayMergeRecursive($firstArray, $secondArray)
    {
        if (is_array($firstArray) && is_array($secondArray)) {
            foreach ($secondArray as $key => $value) {
                if (isset($firstArray[$key])) {
                    $firstArray[$key] = $this->_arrayMergeRecursive($firstArray[$key], $value);
                } else {
                    $firstArray[$key] = $value;
                }
            }
        } else {
            $firstArray = $secondArray;
        }

        return $firstArray;
    }
}
