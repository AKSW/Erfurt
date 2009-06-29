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
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

class Zend_Soap_Wsdl_Strategy_ArrayOfTypeSequence extends Zend_Soap_Wsdl_Strategy_Abstract
{
    /**
     * Add an unbounded ArrayOfType based on the xsd:sequence syntax if type[] is detected in return value doc comment.
     *
     * @param string $type
     * @return string tns:xsd-type
     */
    public function addComplexType($type)
    {
        $nestedCounter = $this->_getNestedCount($type);

        if($nestedCounter > 0) {
            $singularType = $this->_getSingularType($type);

            for($i = 1; $i <= $nestedCounter; $i++) {
                $complexTypeName = $this->_getTypeNameBasedOnNestingLevel($singularType, $i);
                $childTypeName = $this->_getTypeNameBasedOnNestingLevel($singularType, $i-1);

                $this->_addElementFromWsdlAndChildTypes($complexTypeName, $childTypeName);
            }
            // adding the PHP type which is resolved to a nested XSD type. therefore add only once.
            $this->getContext()->addType($type);

            return "tns:$complexTypeName";
        } else {
            require_once "Zend/Soap/Wsdl/Exception.php";
            throw new Zend_Soap_Wsdl_Exception(sprintf(
                'ArrayOfTypeSequence Strategy does not allow for complex types that are not in @return type[] syntax. "%s" type was specified.', $type
            ));
        }
    }

    /**
     * Return the ArrayOf or simple type name based on the singular xsdtype and the nesting level
     *
     * @param  string $singularType
     * @param  int    $level
     * @return string
     */
    protected function _getTypeNameBasedOnNestingLevel($singularType, $level)
    {
        if($level == 0) {
            // This is not an Array anymore, return the xsd simple type
            return $singularType;
        } else {
            $prefix = str_repeat("ArrayOf", $level);
            $xsdType = $this->_getStrippedXsdType($singularType);
            $arrayType = $prefix.$xsdType;
            return $arrayType;
        }
    }

    /**
     * Strip the xsd: from a singularType and Format it nice for ArrayOf<Type> naming
     *
     * @param  string $singularType
     * @return string
     */
    protected function _getStrippedXsdType($singularType)
    {
        return ucfirst(substr(strtolower($singularType), 4));
    }

    /**
     * From a nested defintion with type[], get the singular xsd:type
     *
     * @throws Zend_Soap_Wsdl_Exception When no xsd:simpletype can be detected.
     * @param  string $type
     * @return string
     */
    protected function _getSingularType($type)
    {
        $singulartype = $this->getContext()->getType(str_replace("[]", "", $type));

        if(substr($singulartype, 0, 4) != "xsd:") {
            require_once "Zend/Soap/Wsdl/Exception.php";
            throw new Zend_Soap_Wsdl_Exception(sprintf(
                'ArrayOfTypeSequence Strategy works only with arrays of simple types like int, string, boolean, not with "%s".'.
                'You may use Zend_Soap_Wsdl_Strategy_ArrayOfTypeComplex for more complex types.', $type
            ));
        }
        return $singulartype;
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

    /**
     * Append the complex type definition to the WSDL via the context access
     *
     * @param  string $arrayType
     * @param  string $childTypeName
     * @return void
     */
    protected function _addElementFromWsdlAndChildTypes($arrayType, $childTypeName)
    {
        if (!in_array($arrayType, $this->getContext()->getTypes())) {
            $dom = $this->getContext()->toDomDocument();

            $complexType = $dom->createElement('xsd:complexType');
            $complexType->setAttribute('name', $arrayType);

            $sequence = $dom->createElement('xsd:sequence');

            $element = $dom->createElement('xsd:element');
            $element->setAttribute('name',      'item');
            $element->setAttribute('type',      $childTypeName);
            $element->setAttribute('minOccurs', 0);
            $element->setAttribute('maxOccurs', 'unbounded');
            $sequence->appendChild($element);

            $complexType->appendChild($sequence);

            $this->getContext()->getSchema()->appendChild($complexType);
            $this->getContext()->addType($arrayType);
        }
    }
}