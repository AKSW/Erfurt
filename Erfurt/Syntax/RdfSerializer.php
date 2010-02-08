<?php
/**
 * @package erfurt
 * @subpackage   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: RdfSerializer.php 4016 2009-08-13 15:21:13Z pfrischmuth $
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
    
    public static function normalizeFormat($format)
    {
        $formatMapping = array(
            'application/rdf+xml' => 'rdfxml', 
            'rdfxml' => 'rdfxml', 
            'rdf/xml' => 'rdfxml', 
            'xml' => 'rdfxml',  
            'rdf' => 'rdfxml', 
            'text/plain' => 'rdfxml', 
            'application/x-turtle' => 'turtle',
            'text/turtle' => 'turtle',
            'rdf/turtle' => 'turtle',
            'rdfturtle' => 'turtle',
            'turtle' => 'turtle',
            'ttl' => 'turtle',
            'nt' => 'turtle',
            'ntriple' => 'turtle',
            'rdf/n3' => 'rdfn3',
            'rdfn3' => 'rdfn3',
            'n3' => 'rdfn3',
            'application/json' => 'rdfjson',
            'json' => 'rdfjson',
            'rdfjson' => 'rdfjson',
            'rdf/json' => 'rdfjson'
        );
        
        if (isset($formatMapping[strtolower($format)])) {
            return $formatMapping[strtolower($format)];
        } else {
            return strtolower($format);
        }
    }
    
    public static function getSupportedFormats()
    {
        return array(
            'rdfxml'  => 'RDF/XML',
            'turtle'  => 'Turtle',
            'rdfjson' => 'RDF/JSON (Talis)',
            'rdfn3'   => 'Notation 3'
        );
    }
    
    public function initializeWithFormat($format)
    {
        $format = self::normalizeFormat($format);
        switch ($format) {
            case 'rdfxml':
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfXml.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml();
                break;
            case 'turtle':
            case 'rdfn3':
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Turtle.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_Turtle();
                break;
            case 'rdfjson':
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfJson.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfJson();
                break;
            default:
                require_once 'Erfurt/Syntax/RdfSerializerException.php';
                throw new Erfurt_Syntax_RdfSerializerException("Format '$format' not supported");
        }        
    }
    
    public function serializeGraphToString($graphUri, $pretty = false, $useAc = true)
    {
        return $this->_serializerAdapter->serializeGraphToString($graphUri, $pretty, $useAc);
    }

    public function serializeQueryResultToString($query, $graphUri, $pretty = false, $useAc = true)
    {
        return $this->_serializerAdapter->serializeQueryResultToString($query, $graphUri, $pretty, $useAc);
    }
    
    public function serializeResourceToString($resourceUri, $graphUri, $pretty = false, $useAc = true, array $additional = array())
    {
        return $this->_serializerAdapter->serializeResourceToString($resourceUri, $graphUri, $pretty, $useAc, $additional);
    }
}
