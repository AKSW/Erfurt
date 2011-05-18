<?php
/**
 * @package erfurt
 * @subpackage   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: RdfParser.php 3757 2009-07-23 05:47:35Z pfrischmuth $
 */
class Erfurt_Syntax_RdfParser
{   
    const LOCATOR_URL        = 10;
    const LOCATOR_FILE       = 20;
    const LOCATOR_DATASTRING = 30;
    
    protected $_parserAdapter = null;
    
    public static function rdfParserWithFormat($format)
    {
        $parser = new Erfurt_Syntax_RdfParser();
        $parser->initializeWithFormat($format);
        
        return $parser;
    }
    
    public function initializeWithFormat($format)
    {
        $format = strtolower($format);
        
        switch ($format) {
            case 'rdfxml':
            case 'xml':
            case 'rdf':
                require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXml.php';
                $this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();
                break;
            case 'turtle':
            case 'ttl':
            case 'nt':
            case 'ntriple':
            case 'n3':
            case 'rdfn3':
                require_once 'Erfurt/Syntax/RdfParser/Adapter/Turtle.php';
                $this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_Turtle();
                break;
            case 'json':
            case 'rdfjson':
                require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfJson.php';
                $this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_RdfJson();
                break;
            default:
                require_once 'Erfurt/Syntax/RdfParserException.php';
                throw new Erfurt_Syntax_RdfParserException("Format '$format' not supported");
        }        
    }
    
    public function reset()
    {
        $this->_parserAdapter->reset();
    }
    
    /**
     * @param string E.g. a filename, a url or the data to parse itself.
     * @param int One of the supported pointer types.
     * @return array Returns an RDF/PHP array.
     */
    public function parse($dataPointer, $pointerType, $baseUri = null)
    {
        if ($pointerType === self::LOCATOR_URL) {
            $result = $this->_parserAdapter->parseFromUrl($dataPointer);       
        } else if ($pointerType === self::LOCATOR_FILE) {
            $result = $this->_parserAdapter->parseFromFilename($dataPointer);
        } else if ($pointerType === self::LOCATOR_DATASTRING) {
            $result = $this->_parserAdapter->parseFromDataString($dataPointer, $baseUri);
        } else {
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException('Type of data pointer not valid.');
        }
        
        return $result;
    }
    
    /**
     * Call this method after parsing only. The function parseToStore will add namespaces automatically.
     * This method is just for situations, where the namespaces are needed to after a in-memory parsing.
     * 
     * @return array
     */
    public function getNamespaces()
    {
        if (method_exists($this->_parserAdapter, 'getNamespaces')) {
            return $this->_parserAdapter->getNamespaces();
        } else {
            return array();
        }
    }
    
    public function parseNamespaces($dataPointer, $pointerType)
    {
        if ($pointerType === self::LOCATOR_URL) {
            $result = $this->_parserAdapter->parseNamespacesFromUrl($dataPointer);       
        } else if ($pointerType === self::LOCATOR_FILE) {
            $result = $this->_parserAdapter->parseNamespacesFromFilename($dataPointer);
        } else if ($pointerType === self::LOCATOR_DATASTRING) {
            $result = $this->_parserAdapter->parseNamespacesFromDataString($dataPointer);
        } else {
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException('Type of data pointer not valid.');
        }
        
        return $result;
    }
    
    public function parseToStore($dataPointer, $pointerType, $modelUri, $useAc = true, $baseUri = null)
    {
        if ($pointerType === self::LOCATOR_URL) {
            $result = $this->_parserAdapter->parseFromUrlToStore($dataPointer, $modelUri, $useAc);       
        } else if ($pointerType === self::LOCATOR_FILE) {
            $result = $this->_parserAdapter->parseFromFilenameToStore($dataPointer, $modelUri, $useAc);
        } else if ($pointerType === self::LOCATOR_DATASTRING) {
            $result = $this->_parserAdapter->parseFromDataStringToStore($dataPointer, $modelUri, $useAc, $baseUri);
        } else {
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException('Type of data pointer not valid.');
        }
        
        return $result;
    }
}