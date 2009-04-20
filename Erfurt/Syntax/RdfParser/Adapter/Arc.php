<?php
require_once 'Erfurt/Syntax/RdfParser/Adapter/Interface.php';
require_once 'arc/ARC2.php';

/**
 * This class acts as an intermediate implementation for some important formats.
 * It uses the ARC library unitl we have own implementations.
 * 
 * @package erfurt
 * @subpackage   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: $
 */
class Erfurt_Syntax_RdfParser_Adapter_Arc implements Erfurt_Syntax_RdfParser_Adapter_Interface
{    
    private $_format = null; 
    private $_parser = null;
    
    private $_oldReporting = null;
    
    public function __construct($format = 'rdfxml')
    {
        $this->_oldReporting = error_reporting();
        error_reporting(E_ALL | ~E_STRICT);
        
        $this->_format = $format;
        
        switch ($format) {
            case 'rdfxml':
                $this->_parser = ARC2::getRDFXMLParser();
                break;
            case 'turtle':
                $this->_parser = ARC2::getTurtleParser();
                break;
            default:
        }
    }
    
    public function __destruct()
    {
            error_reporting($this->_oldReporting);
    }
    
    public function parseFromDataString($dataString)
    {
        $this->_parser->parse('', $dataString);
        
        $this->_testErrors();
        $this->_testWarnings();
        
        return $this->_parser->getSimpleIndex(0);
    }
    
    public function parseFromFilename($filename) 
    {
        $this->_parser->parse($filename);
        
        $this->_testErrors();
        $this->_testWarnings();
        
        return $this->_parser->getSimpleIndex(0);
    }
    
    public function parseFromUrl($url) 
    {
        $this->_parser->parse($url);
        
        $this->_testErrors();
        $this->_testWarnings();
        
        return $this->_parser->getSimpleIndex(0);
    }
    
    public function parseFromDataStringToStore($dataString, $graphUri, $useAc = true)
    {
        $this->_parser->parse('', $dataString);
        
        $this->_testErrors();
        $this->_testWarnings();
        
        $store = Erfurt_App::getInstance()->getStore();
             
        $triples = $this->_parser->getSimpleIndex(0);
        $store->addMultipleStatements($graphUri, $triples, $useAc);
        
        return true;
    }
    
    public function parseFromFilenameToStore($filename, $graphUri, $useAc = true)
    {
        $this->_parser->parse($filename);
        
        $this->_testErrors();
        $this->_testWarnings();
        
        $store = Erfurt_App::getInstance()->getStore();
             
        $triples = $this->_parser->getSimpleIndex(0);
        $store->addMultipleStatements($graphUri, $triples, $useAc);
        
        return true;
    }
    
    public function parseFromUrlToStore($url, $graphUri, $useAc = true)
    {
        $this->_parser->parse($url);
        
        $this->_testErrors();
        $this->_testWarnings();
        
        $store = Erfurt_App::getInstance()->getStore();
             
        $triples = $this->_parser->getSimpleIndex(0);
        $store->addMultipleStatements($graphUri, $triples, $useAc);
        
        return true;
        
    }
    
    public function reset()
    {
        switch ($this->_format) {
            case 'rdfxml':
                $this->_parser = ARC2::getRDFXMLParser();
                break;
            case 'turtle':
                $this->_parser = ARC2::getTurtleParser();
                break;
            default:
        }
    }
    
    protected function _testErrors()
    {
        $errors = $this->_parser->getErrors();

        if (count($errors) > 0) {
            $errorString = '';
            
            foreach ($errors as $e) {
                $errorString .= $e . PHP_EOL;
            }
            
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException($errorString);
        }
    }
    
    protected function _testWarnings()
    {
        $warnings = $this->_parser->getWarnings();

        if (count($warnings) > 0) {
            $warningString = '';
            
            foreach ($warnings as $w) {
                $warningString .= $w . PHP_EOL;
            }
            
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException($warningString);
        }
    }
}
