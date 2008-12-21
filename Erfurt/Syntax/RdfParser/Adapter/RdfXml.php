<?php
require_once 'Erfurt/Syntax/RdfParser/Adapter/Interface.php';

/**
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id:$
 */
class Erfurt_Syntax_RdfParser_Adapter_RdfXml implements Erfurt_Syntax_RdfParser_Adapter_Interface
{
    private $_elementStack = array();
    private $_baseUri = null;
    private $_namespaces = array();
    
    public function parseFromDataString($dataString)
    {
// TODO later
        $result = array();
        
        $xmlParser = xml_parser_create();
        
        // Set the handler method for namespace definitions
        xml_set_start_namespace_decl_handler(
            $xmlParser,
            array(&$this, '_handleNamespaceDeclaration')
        );
        
        // Set the handler methods for the start and end element events
        xml_set_element_handler(
            $xmlParser, 
            array(&$this, '_handleStartElement'),
            array(&$this, '_handleEndElement')
        );
        
        // Disable case folding, for we need the uris.
        xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, 0);
         
        // Let's parse.
        xml_parse($xmlParser, $dataString);
    }
    
    public function parseFromFileHandle($fileHandle)
    {
        
    }
    
    public function parseFromDataStringToStore($dataString, $modelUri)
    {
        $store = $this->_getStore();
        
        if (!$store->isModelAvailabler($modelUri)) {
            throw new Exception('Model with uri ' . $modelUri . ' not available.');
        }
        
        
        
    }
    
    public function parseFromFileHandleToStore($fileHandle)
    {
        
    }
    
    private function _getStore()
    {
        return Erfurt_App::getInstance()->getStore();
    }
    
    private function _handleStartElement($parser, $name, $attrs)
    {
        array_push($this->_elementStack, $name);
        
        switch ($name) {
            case 'RDF':
                if (isset($attrs['xml:base'])) {
                    $this->_baseUri = $attrs['xml:base'];
                }
                break;
            default:
        }
        
    }
    
    private function _handleEndElement($parser, $name)
    {
        $currentElem = array_pop($this->_elementStack);
        
        if ($currentElem !== $name) {
            throw new Exception('Malformed XML');
        }
    }
    
    private function _handlerCharacterData($parser, $data)
    {
        
    }
    
    private function _handleNamespaceDeclaration($parser, $userData, $prefix, $uri) 
    {
        var_dump('ttt');
    }
}
