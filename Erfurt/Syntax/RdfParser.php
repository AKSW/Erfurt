<?php
/**
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id$
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
                require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';
                $this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_Arc('rdfxml');
                #require_once 'Erfurt/Syntax/RdfParser/Adapter/RdfXml.php';
                #$this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_RdfXml();
                break;
            case 'turtle':
            case 'ttl':
                require_once 'Erfurt/Syntax/RdfParser/Adapter/Arc.php';
                $this->_parserAdapter = new Erfurt_Syntax_RdfParser_Adapter_Arc('turtle');
                break;
            default:
                throw new Exception('Format not supported');
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
    public function parse($dataPointer, $pointerType)
    {
        if ($pointerType === self::LOCATOR_URL) {
            $fileHandle = fopen($dataPointer, 'r');
            
            if ($fileHandle === false) {
                throw new Exception('Could not locate data with url: ' . $dataPointer);
            }
            
            $result = $this->_parserAdapter->parseFromFileHandle($fileHandle);
            
            // Close the file handle resource.
            fclose($fileHandle);            
        } else if ($pointerType === self::LOCATOR_FILE) {
            $fileHandle = fopen($dataPointer, 'r');
            
            if ($fileHandle === false) {
                throw new Exception('Could not locate file with filename: ' . $dataPointer);
            }
            
            $result = $this->_parserAdapter->parseFromFileHandle($fileHandle);
            
            // Close the file handle resource.
            fclose($fileHandle);
        } else if ($pointerType === self::LOCATOR_DATASTRING) {
            $result = $this->_parserAdapter->parseFromDataString($dataPointer);
        } else {
            try {
                $result = $this->_parserAdapter->parse($dataPointer);
            } catch (Exception $e) {
                throw new Exception('Type of data pointer not valid.');
            }
        }
        
        return $result;
    }
    
    public function parseToStore($dataPointer, $pointerType, $modelUri)
    {
        if ($pointerType === self::LOCATOR_URL) {
            $fileHandle = fopen($dataPointer, 'r');
            
            if ($fileHandle === false) {
                throw new Exception('Could not locate data with url: ' . $dataPointer);
            }
            
            $this->_parserAdapter->parseFromFileHandleToStore($fileHandle, $modelUri);
            
            // Close the file handle resource.
            fclose($fileHandle);            
        } else if ($pointerType === self::LOCATOR_FILE) {
            $fileHandle = fopen($dataPointer, 'r');
            
            if ($fileHandle === false) {
                throw new Exception('Could not locate file with filename: ' . $dataPointer);
            }
            
            $this->_parserAdapter->parseFromFileHandleToStore($fileHandle, $modelUri);
            
            // Close the file handle resource.
            fclose($fileHandle);
        } else if ($pointerType === self::LOCATOR_DATASTRING) {
            $result = $this->_parserAdapter->parseFromDataStringToStore($dataPointer, $modelUri);
        } else {
            throw new Exception('Type of data pointer not valid.');
        }
    }
}