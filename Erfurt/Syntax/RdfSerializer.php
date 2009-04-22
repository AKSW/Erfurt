<?php
/**
 * @package erfurt
 * @subpackage   syntax
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
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfXml.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml();
                break;
            case 'turtle':
            case 'ttl':
            case 'nt':
            case 'ntriple':
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Turtle.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_Turtle();
                break;
            case 'json':
            case 'rdfjson':
                require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfJson.php';
                $this->_serializerAdapter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfJson();
                break;
            case 'rdfn3':
            case 'n3':
            default:
                throw new Exception("Format '$format' not supported");
        }        
    }
    
    public function serializeGraphToString($graphUri, $pretty = false)
    {
        return $this->_serializerAdapter->serializeGraphToString($graphUri, $pretty);
    }
    
    public function serializeResourceToString($resourceUri, $graphUri, $pretty = false)
    {
        return $this->_serializerAdapter->serializeResourceToString($resourceUri, $graphUri, $pretty);
        
        $store = Erfurt_App::getInstance()->getStore();
        
        //return $this->_serializerAdapter->serializeResourceToString($resourceUri, $graphUri);
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?s ?p ?o');
        $query->addFrom($graphUri);
        $query->setWherePart('WHERE { ?s ?p ?o . FILTER (sameTerm(?s, <' . $resourceUri . '>)) } 
                              ORDER BY asc(?s) asc(?p)
                              LIMIT 1000');
        
        $result = $store->sparqlQuery($query, 'extended');

$this->_serializerAdapter->setGraphUri($graphUri);
$this->_serializerAdapter->setBaseUri('http://3ba.se/conferences/');
$this->_serializerAdapter->handleNamespace('rdf', EF_RDF_NS);
$this->_serializerAdapter->handleNamespace('rdfs', EF_RDFS_NS);
$this->_serializerAdapter->startRdf('Exported with the new Erfurt exporter classes...');
        //$this->_serializerAdapter->startRdf();
        

        
        foreach ($result['bindings'] as $row) {
            $s     = $row['s']['value'];
            $p     = $row['p']['value'];
            $o     = $row['o']['value'];
            $sType = $row['s']['type'];
            $oType = $row['o']['type'];
            $lang  = isset($row['o']['lang']) ? $row['o']['lang'] : null;
            $dType = isset($row['o']['datatype']) ? $row['o']['datatype'] : null;
            
            $this->_serializerAdapter->handleStatement($s, $p, $o, $sType, $oType, $lang, $dType);
        }
        
        return $this->_serializerAdapter->endRdf();

    }
}