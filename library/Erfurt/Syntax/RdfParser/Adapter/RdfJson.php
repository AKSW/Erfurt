<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * 
 * @package   Erfurt_Syntax_RdfParser_Adapter
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Syntax_RdfParser_Adapter_RdfJson extends Erfurt_Syntax_RdfParser_Adapter_Base
{
    public function parseFromDataString($dataString, $baseUri = null, $type = null)
    {
        //because this method is reused internally we got to have this $type switch
        if($type === null){
            $type = self::TYPE_STRING;
        }
        if($type == self::TYPE_FILE){
            $this->_setLocalFileBaseUri($baseUri);
        } else if($type == self::TYPE_URL){
            $this->_setURLBaseUri($baseUri);
        } else {
            $this->_setBaseUri($baseUri);
        }
        
        $result = json_decode($dataString, true);
        
        if ($result === null) {
            
            throw new Erfurt_Syntax_RdfParserException('Decoding of JSON failed.');
        }
        
        return $result;
    }
    
    public function parseFromFilename($filename) 
    {
        $handle = fopen($filename, 'r');
        
        if ($handle === false) {
            
            throw new Erfurt_Syntax_RdfParserException("Failed to open file with filename '$filename'");
        }
        
        $dataString = fread($handle, filesize($filename));
        fclose($handle);
        
        return $this->parseFromDataString($dataString, $filename, self::TYPE_FILE);
    }

    public function parseFromDataStringToStore($dataString, $graphUri, $useAc = true)
    {
        $triples = $this->parseFromDataString($dataString, $graphUri);
        
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

    public function parseNamespacesFromDataString($dataString)
    {
        return array();
    }
    
    public function parseNamespacesFromFilename($filename)
    {
        return array();
    }
}

