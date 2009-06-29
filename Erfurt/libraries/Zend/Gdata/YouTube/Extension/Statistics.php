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
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage YouTube
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @see Zend_Gdata_Extension
 */
require_once 'Zend/Gdata/Extension.php';

/**
 * Represents the yt:statistics element used by the YouTube data API
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage YouTube
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_YouTube_Extension_Statistics extends Zend_Gdata_Extension
{

    protected $_rootNamespace = 'yt';
    protected $_rootElement = 'statistics';
    protected $_viewCount = null;
    protected $_watchCount = null;

    /**
     * Constructs a new Zend_Gdata_YouTube_Extension_Statistics object.
     * @param string $viewCount(optional) The viewCount value
     * @param string $watchCount(optional) The watchCount value
     */
    public function __construct($viewCount = null, $watchCount = null) 
    {
        foreach (Zend_Gdata_YouTube::$namespaces as $nsPrefix => $nsUri) {
            $this->registerNamespace($nsPrefix, $nsUri);
        }
        parent::__construct();        
        $this->_viewCount = $viewCount; 
        $this->_watchCount = $watchCount; 
    }

    /**
     * Retrieves a DOMElement which corresponds to this element and all 
     * child properties.  This is used to build an entry back into a DOM
     * and eventually XML text for sending to the server upon updates, or
     * for application storage/persistence.  
     *
     * @param DOMDocument $doc The DOMDocument used to construct DOMElements
     * @return DOMElement The DOMElement representing this element and all 
     * child properties.
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_viewCount !== null) {
            $element->setAttribute('viewCount', $this->_viewCount);
        }
        if ($this->_watchCount !== null) {
            $element->setAttribute('watchCount', $this->_watchCount);
        }
        return $element;
    }

    /**
     * Given a DOMNode representing an attribute, tries to map the data into
     * instance members.  If no mapping is defined, the name and valueare 
     * stored in an array.
     * TODO: Convert attributes to proper types
     *
     * @param DOMNode $attribute The DOMNode attribute needed to be handled
     */
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'viewCount':
            $this->_viewCount = $attribute->nodeValue;
            break;
        case 'watchCount':
            $this->_watchCount = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    /**
     * Get the value for this element's viewCount attribute.
     *
     * @return int The value associated with this attribute.
     */
    public function getViewCount()
    {
        return $this->_viewCount;
    }

    /**
     * Set the value for this element's viewCount attribute.
     *
     * @param int $value The desired value for this attribute.
     * @return Zend_Gdata_YouTube_Extension_Statistics The element being modified.
     */
    public function setViewCount($value)
    {
        $this->_viewCount = $value;
        return $this;
    }

    /**
     * Get the value for this element's watchCount attribute.
     *
     * @return int The value associated with this attribute.
     */
    public function getWatchCount()
    {
        return $this->_watchCount;
    }

    /**
     * Set the value for this element's watchCount attribute.
     *
     * @param int $value The desired value for this attribute.
     * @return Zend_Gdata_YouTube_Extension_Statistics The element being modified.
     */
    public function setWatchCount($value)
    {
        $this->_watchCount = $value;
        return $this;
    }

    /**
     * Magic toString method allows using this directly via echo
     * Works best in PHP >= 4.2.0
     *
     * @return string
     */
    public function __toString() 
    {
        return 'View Count=' . $this->_viewCount;
    }

}
