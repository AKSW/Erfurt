<?php
require_once 'Erfurt/Syntax/RdfParser/Adapter/Interface.php';

/**
 * 
 * @package erfurt
 * @subpackage   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: RdfJson.php 2929 2009-04-22 14:56:30Z pfrischmuth $
 */
class Erfurt_Syntax_RdfParser_Adapter_RdfJson implements Erfurt_Syntax_RdfParser_Adapter_Interface
{    
    
    public function parseFromDataString($dataString)
    {    
        $result = json_decode($dataString, true);
        
        if ($result === null) {
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException('Decoding of JSON failed.');
        }
        
        return $result;
    }
    
    public function parseFromFilename($filename) 
    {
        $handle = fopen($filename, 'r');
        
        if ($handle === false) {
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException("Failed to open file with filename '$filename'");
        }
        
        $dataString = fread($handle, filesize($filename));
        fclose($handle);
        
        return $this->parseFromDataString($dataString);
    }
    
    public function parseFromUrl($url) 
    {
        // replace all whitespaces (prevent possible CRLF Injection attacks)
        // http://www.acunetix.com/websitesecurity/crlf-injection.htm
        $url = preg_replace('/\\s+/', '', $url);

        $handle = fopen($url, 'r');
        
        if ($handle === false) {
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException("Failed to open file at url '$url'");
        }
        
        $dataString = '';
        
        while(!feof($handle)) {
            $dataString .= fread($handle, 1024);
        }
        
        fclose($handle);
        
        return $this->parseFromDataString($dataString);
    }
    
    public function parseFromDataStringToStore($dataString, $graphUri, $useAc = true)
    {
        $triples = $this->parseFromDataString($dataString);
        
        $store = Erfurt_App::getInstance()->getStore();
        
        $store->addMultipleStatements($graphUri, $triples, $useAc);
        
        return true;
    }
    
    public function parseFromFilenameToStore($filename, $graphUri, $useAc = true)
    {
        $triples = $this->parseFromFilename($filename);
        
        $store = Erfurt_App::getInstance()->getStore();
             
        $store->addMultipleStatements($graphUri, $triples, $useAc);
        
        return true;
    }
    
    public function parseFromUrlToStore($url, $graphUri, $useAc = true)
    {
        $triples = $this->parseFromUrl($url);
        
        $store = Erfurt_App::getInstance()->getStore();
             
        $store->addMultipleStatements($graphUri, $triples, $useAc);
        
        return true;
    }
    
    public function parseNamespacesFromDataString($dataString)
    {
        return array();
    }
    
    public function parseNamespacesFromFilename($filename)
    {
        return array();
    }
    
    public function parseNamespacesFromUrl($url)
    {
        return array();
    }
}
