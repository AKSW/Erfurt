<?php
/**
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id$
 */
class Erfurt_Syntax_RdfSerializer
{   
    protected $_serializerAdapter = null;
    
    public static function rdfSerializerWithFormat($format)
    {
        $serializer = new Erfurt_Syntax_RdfSerializer();
        $serializer->initializeWithFormat($format);
        
        return $serializer;
    }
    
    public function initializeWithFormat($format)
    {
        $format = strtolower($format);
        
        switch ($format) {
            case 'rdfxml':
            case 'xml':
            case 'rdf':
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Arc.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_Arc('rdfxml');
                break;
            case 'turtle':
            case 'ttl':
            case 'n3':
            case 'nt':
            case 'ntriple':
            case 'rdfn3':
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Arc.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_Arc('turtle');
                break;
            case 'json':
            case 'rdfjson':
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfJson.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfJson();
                break;
            default:
                throw new Exception("Format '$format' not supported");
        }        
    }
    
    public function serializeGraphToString($graphUri)
    {
        return $this->_serializerAdapter->serializeGraphToString($graphUri);
    }
    
    public function serializeResourceToString($resourceUri, $graphUri)
    {
        return $this->_serializerAdapter->serializeResourceToString($resourceUri, $graphUri);
    }
}