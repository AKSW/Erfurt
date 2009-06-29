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
 * @package    Zend_Soap
 * @subpackage Wsdl
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

require_once "Zend/Soap/Wsdl/Strategy/DefaultComplexType.php";

class Zend_Soap_Wsdl_Strategy_ArrayOfTypeComplex extends Zend_Soap_Wsdl_Strategy_Abstract
{
    /**
     * Add an ArrayOfType based on the xsd:complexType syntax if type[] is detected in return value doc comment.
     *
     * @param string $type
     * @return string tns:xsd-type
     */
    public function addComplexType($type)
    {
        $nestingLevel = $this->_getNestedCount($type);

        if($nestingLevel > 1) {
            require_once "Zend/Soap/Wsdl/Exception.php";
            throw new Zend_Soap_Wsdl_Exception(
                "ArrayOfTypeComplex cannot return nested ArrayOfObject deeper than ".
                "one level. Use array object properties to return deep nested data.
            ");
        }

        $singularType = $this->_getSingularPhpType($type);

        if(!class_exists($singularType)) {
            require_once "Zend/Soap/Wsdl/Exception.php";
            throw new Zend_Soap_Wsdl_Exception(sprintf(
                "Cannot add a complex type %s that is not an object or where ".
                "class could not be found in 'DefaultComplexType' strategy.", $type
            ));
        }

        if($nestingLevel == 1) {
            // The following blocks define the Array of Object structure
            $xsdComplexTypeName = $this->_addArrayOfComplexType($singularType, $type);
        } else {
            $xsdComplexTypeName = $singularType;
        }

        // The array for the objects has been created, now build the object definition:
        $this->_addObjectComplexType($singularType);

        return "tns:".$xsdComplexTypeName;
    }

    protected function _addArrayOfComplexType($singularType, $type)
    {
        $dom = $this->getContext()->toDomDocument();

        $xsdComplexTypeName = $this->_getXsdComplexTypeName($singularType);
        $complexType = $dom->createElement('xsd:complexType');
        $complexType->setAttribute('name', $xsdComplexTypeName);

        $complexContent = $dom->createElement("xsd:complexContent");
        $complexType->appendChild($complexContent);

        $xsdRestriction = $dom->createElement("xsd:restriction");
        $xsdRestriction->setAttribute('base', 'soap-enc:Array');
        $complexContent->appendChild($xsdRestriction);

        $xsdAttribute = $dom->createElement("xsd:attribute");
        $xsdAttribute->setAttribute("ref", "soap-enc:arrayType");
        $xsdAttribute->setAttribute("wsdl:arrayType", sprintf("tns:%s[]", $singularType));
        $xsdRestriction->appendChild($xsdAttribute);

        $this->getContext()->getSchema()->appendChild($complexType);
        $this->getContext()->addType($type);

        return $xsdComplexTypeName;
    }

    protected function _addObjectComplexType($singularType)
    {
        $complexStrategy = $this->getContext()->getComplexTypeStrategy();

        // Override strategy to stay DRY
        $objectStrategy = new Zend_Soap_Wsdl_Strategy_DefaultComplexType();
        $this->getContext()->setComplexTypeStrategy($objectStrategy);
        $this->getContext()->addComplexType($singularType);

        // Reset strategy
        $this->getContext()->setComplexTypeStrategy($complexStrategy);
    }

    protected function _getXsdComplexTypeName($type)
    {
        return sprintf('ArrayOf%s', $type);
    }

    /**
     * From a nested defintion with type[], get the singular PHP Type
     *
     * @param  string $type
     * @return string
     */
    protected function _getSingularPhpType($type)
    {
        return str_replace("[]", "", $type);
    }

    /**
     * Return the array nesting level based on the type name
     *
     * @param  string $type
     * @return integer
     */
    protected function _getNestedCount($type)
    {
        return substr_count($type, "[]");
    }
}