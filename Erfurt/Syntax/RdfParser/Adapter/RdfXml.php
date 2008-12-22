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
    private $_subjectStack = array(); 
    private $_baseUri = null;
    
    
    private $_xmlParser = null;
    
    private $_namespaces = array();
    private $_statements = array();
    
    public function parseFromFileHandleToStore($fileHandle, $modelUri)
    {
        $store = $this->_getStore();
        
        if (!$store->isModelAvailable($modelUri, false)) {
            throw new Exception('Model with uri ' . $modelUri . ' not available.');
        }
        
        $xmlParser = $this->_getXmlParser();
        
        xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($xmlParser, XML_OPTION_SKIP_WHITE, 1);
        
        xml_set_default_handler($xmlParser, array(&$this, '_handleDefault'));
        
        // Set the handler method for namespace definitions
        $this->_setNamespaceDeclarationHandler('_handleNamespaceDeclaration');
        
        //xml_set_end_namespace_decl_handler($xmlParser, array(&$this, '_handleNamespaceDeclaration'));
        
        xml_set_character_data_handler($xmlParser, array(&$this, '_handleCharacterData'));
        
        xml_set_external_entity_ref_handler($xmlParser, array(&$this, '_handleExternalEntityRef'));
        
        xml_set_processing_instruction_handler($xmlParser, array(&$this, '_handleProcessingInstruction'));
        
        xml_set_unparsed_entity_decl_handler($xmlParser, array(&$this, '_handleUnparsedEntityDecl'));
        
        xml_set_element_handler(
            $xmlParser, 
            array(&$this, '_handleStartElement'),
            array(&$this, '_handleEndElement')
        );
        
        
        // Let's parse.
        while ($data = fread($fileHandle, 4096)) {
            xml_parse($xmlParser, $data, feof($fileHandle));
        }
        
        
        
        #var_dump($this->_namespaces);
        #var_dump($this->_baseUri);
        var_dump($this->_statements);
        #var_dump(array_pop($this->_statements));
        exit;
        
        
        // Set the handler methods for the start and end element events
        xml_set_element_handler(
            $xmlParser, 
            array(&$this, '_handleStartElement'),
            array(&$this, '_handleEndElement')
        );
        
        // Disable case folding, for we need the uris.
        xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, 0);
         
        
        
        
    }
    
    private function _getStore()
    {
        return Erfurt_App::getInstance()->getStore();
    }
    
    private function _handleStartElement($parser, $name, $attrs)
    {
        array_push($this->_elementStack, $name);
        
        #var_dump($attrs);return;
        
        switch ($name) {
            case (EF_RDF_NS . 'RDF'):
                if (isset($attrs[(EF_XML_NS . 'base')])) {
                    $this->_baseUri = $attrs[(EF_XML_NS . 'base')];
                }
                
                
                break;
            case (EF_RDF_NS . 'Description'):
                break;
            case (EF_RDFS_NS . 'domain'):
            case (EF_RDFS_NS . 'range');
                break;
            default:
                $subject = null;
                if (isset($attrs[(EF_RDF_NS . 'about')])) {
                    if ($this->_isFullUri($attrs[(EF_RDF_NS . 'about')])) {
                        $subject = $attrs[(EF_RDF_NS . 'about')];
                         array_push($this->_subjectStack, $subject);
                    } else {
                        if (null !== $this->_baseUri) {
                            $subject = ($this->_baseUri . $attrs[(EF_RDF_NS . 'about')]);
                            array_push($this->_subjectStack, $subject);
                        } else {
                            $subject = $attrs[(EF_RDF_NS . 'about')];
                            array_push($this->_subjectStack, $subject);
                        }
                    }
                    
                    $this->_addToStatements($subject, EF_RDF_TYPE, $name);
                    
                    unset($attrs[(EF_RDF_NS . 'about')]);
                } else if (isset($attrs[(EF_RDF_NS . 'nodeID')])) {
                    $subject = ('_:' . $attrs[(EF_RDF_NS . 'nodeID')]);
                    array_push($this->_subjectStack, $subject);
                    
                    $this->_addToStatements($subject, EF_RDF_TYPE, $name);
                    
                    unset($attrs[(EF_RDF_NS . 'nodeID')]);
                } else {
                    $subject = array_pop($this->_subjectStack);
                    array_push($this->_subjectStack, $subject);
                }
      
                //$this->_addToStatements($subject, EF_RDF_TYPE, $name);
                
                foreach ($attrs as $key => $value) {
                    $this->_addToStatements($subject, $key, $value);
                }
        }
        
    }
    
    private function _addToStatements($subject, $predicate, $object, $datatype = null, $lang = null)
    {
        if (!isset($this->_statements["$subject"])) {
            $this->_statements["$subject"] = array();
        }
        if (!isset($this->_statements["$subject"]["$predicate"])) {
            $this->_statements["$subject"]["$predicate"] = array();
        }
        
        $objectArray = array(
            'type'  => 'literal',
            'value' => $object
        );
        
        if (null !== $datatype) {
            $objectArray['datatype'] = $datatype;
        }
        if (null !== $lang) {
            $objectArray['lang'] = $lang;
        }
        
        $this->_statements["$subject"]["$predicate"][] = $objectArray;
    }
    
    private function _handleEndElement($parser, $name)
    {
        $currentElem = array_pop($this->_elementStack);
        
        if ($currentElem !== $name) {
            throw new Exception('Malformed XML');
        }
    }
    
    private function _handleDefault($parser, $data)
    {
        #var_dump($data);
    }
    
    private function _handleCharacterData($parser, $data)
    {
        if (trim($data) === '') {
            return;
        }
        
        $subject = array_pop($this->_subjectStack);
        array_push($this->_subjectStack, $subject);
        
        $predicate = array_pop($this->_elementStack);
        array_push($this->_elementStack, $predicate);
        
        $this->_addToStatements($subject, $predicate, $data);
    }
    
    private function _handleNamespaceDeclaration($parser, $prefix, $uri) 
    {
        if ($prefix) {
            $this->_namespaces["$prefix"] = $uri;
        } else {
            $this->_namespaces['_'] = $uri;
        }
    }
    
    private function _getXmlParser()
    {
        if (null === $this->_xmlParser) {
            $this->_xmlParser = xml_parser_create_ns(null, '');
        }
        
        return $this->_xmlParser;
    }
    
    private function _handleExternalEntityRef($parser, $openEntityNames, $base, $systemId, $publicId)
    {
        var_dump($openEntityNames);
    }
    
    private function _handleProcessingInstruction($parser, $target, $data)
    {
        var_dump($data);
    }
    
    private function _handleUnparsedEntityDecl($parser, $entityName, $base, $systemId, $publicId, $notationName)
    {
        var_dump($entityName);
    }
    
    private function _setNamespaceDeclarationHandler($handlerMethodName)
    {
        xml_set_start_namespace_decl_handler(
            $this->_getXmlParser(),
            array(&$this, $handlerMethodName)
        );
    }
    
    private function _isFullUri($uriString)
    {   
        $match = array();
        $success = preg_match('/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?/', $uriString, $match);
        
        $last = count($match)-1;
        $restIsEmpty = true;
        for ($i=1; $i<$last; ++$i) {
            if ($match[$i] !== '') {
                $restIsEmpty = false;
                break;
            }
        }
        if ($match[0] === $match[$last] && $restIsEmpty) {
            return false;
        } else if (!$success) {
            return false;
        } else {
            return true;
        }
    }
}
