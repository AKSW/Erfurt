<?php
require_once 'Erfurt/Syntax/RdfParser/Adapter/Interface.php';
require_once 'arc/ARC2.php';

/**
 * This class acts as an intermediate implementation for some important formats.
 * It uses the ARC library unitl we have own implementations.
 * 
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: $
 */
class Erfurt_Syntax_RdfParser_Adapter_Arc implements Erfurt_Syntax_RdfParser_Adapter_Interface
{    
    private $_format = null; 
    private $_parser = null;
    
    public function __construct($format = 'rdfxml')
    {
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
        if (defined(_EFDEBUG)) {
            error_reporting(E_ALL | E_STRICT);
        }
    }
    
    public function parseFromDataString($dataString)
    {
        $this->_parser->parse('', $dataString);
        
        return $this->_parser->getSimpleIndex(0);
    }
    
    public function parseFromFilename($filename) 
    {
        $this->_parser->parse($filename);
        
        return $this->_parser->getSimpleIndex(0);
    }
    
    public function parseFromUrl($url) 
    {
        $this->_parser->parse($url);
        
        return $this->_parser->getSimpleIndex(0);
    }
    
    public function parseFromDataStringToStore($dataString, $graphUri, $useAc = true)
    {
        $this->_parser->parse('', $dataString);
        
        $store = Erfurt_App::getInstance()->getStore();
             
        $triples = $this->_parser->getSimpleIndex(0);
        $store->addMultipleStatements($graphUri, $triples, $useAc);
        
        return true;
    }
    
    public function parseFromFilenameToStore($filename, $graphUri, $useAc = true)
    {
        $this->_parser->parse($filename);
        
        $store = Erfurt_App::getInstance()->getStore();
             
        $triples = $this->_parser->getSimpleIndex(0);
        $store->addMultipleStatements($graphUri, $triples, $useAc);
        
        return true;
    }
    
    public function parseFromUrlToStore($url, $graphUri, $useAc = true)
    {
        $this->_parser->parse($url);
        
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
}
