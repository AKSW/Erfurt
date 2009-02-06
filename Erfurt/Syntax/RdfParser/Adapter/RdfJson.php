<?php
require_once 'Erfurt/Syntax/RdfParser/Adapter/Interface.php';

/**
 * 
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id$
 */
class Erfurt_Syntax_RdfParser_Adapter_RdfJson implements Erfurt_Syntax_RdfParser_Adapter_Interface
{    
    
    public function parseFromDataString($dataString)
    {        
        return json_decode($dataString, true);
    }
    
    public function parseFromFilename($filename) 
    {
        $handle = fopen($filename, 'r');
        $dataString = fread($handle, filesize($filename));
        fclose($handle);
        
        return $this->parseFromDataString($dataString);
    }
    
    public function parseFromUrl($url) 
    {
        
        $handle = fopen($url, 'r');
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
    
    public function reset()
    {
        // Nothing to do here.
    }
}
