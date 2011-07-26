<?php
require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Interface.php';

class Erfurt_Syntax_RdfSerializer_Adapter_RdfXml implements Erfurt_Syntax_RdfSerializer_Adapter_Interface
{
    protected $_currentSubject = null;
    protected $_currentSubjectType = null;
    protected $_pArray = array();
    
    protected $_store = null;
    protected $_graphUri = null;
    
    protected $_renderedTypes = array();
    
    protected $_rdfWriter = null;
        
    public function serializeGraphToString($graphUri, $pretty = false, $useAc = true)
    {
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfXml/StringWriterXml.php';
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfXml/RdfWriter.php';
      
        $xmlStringWriter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml_StringWriterXml();
        $this->_rdfWriter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml_RdfWriter($xmlStringWriter, $useAc);
        
        $this->_store = Erfurt_App::getInstance()->getStore();
        $this->_graphUri = $graphUri;
        $graph = $this->_store->getModel($graphUri, $useAc);
        
        $this->_rdfWriter->setGraphUri($graphUri);

        $base  = $graph->getBaseUri();
        $this->_rdfWriter->setBase($base);

        $namespaces = Erfurt_App::getInstance()->getNamespaces();

        foreach ($namespaces->getNamespacePrefixes($graphUri) as $prefix => $ns) {
            $this->_rdfWriter->addNamespacePrefix($prefix, $ns);
        }
		
		$config = Erfurt_App::getInstance()->getConfig();
        if (isset($config->serializer->ad)) {
            $this->_rdfWriter->startDocument($config->serializer->ad);
        } else {
            $this->_rdfWriter->startDocument();
        }
	
        $this->_rdfWriter->setMaxLevel(10);

        $this->_serializeType('Ontology specific informations', EF_OWL_ONTOLOGY);
        $this->_rdfWriter->setMaxLevel(1);

        $this->_serializeType('Classes', EF_OWL_CLASS);

        $this->_serializeType('Datatypes', EF_RDFS_DATATYPE);
        $this->_serializeType('Annotation properties', EF_OWL_ANNOTATION_PROPERTY);
        $this->_serializeType('Datatype properties', EF_OWL_DATATYPE_PROPERTY);
        $this->_serializeType('Object properties', EF_OWL_OBJECT_PROPERTY);

        $this->_serializeRest('Instances and untyped data');

        $this->_rdfWriter->endDocument();
        return $this->_rdfWriter->getContentString();
    }
    
    public function serializeResourceToString($resource, $graphUri, $pretty = false, $useAc = true, array $additional = array())
    {
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfXml/StringWriterXml.php';
        require_once 'Erfurt/Syntax/RdfSerializer/Adapter/RdfXml/RdfWriter.php';
        
        $xmlStringWriter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml_StringWriterXml();
        $this->_rdfWriter = new Erfurt_Syntax_RdfSerializer_Adapter_RdfXml_RdfWriter($xmlStringWriter, $useAc);
        
        $this->_store = Erfurt_App::getInstance()->getStore();
        $this->_graphUri = $graphUri;
        $graph = $this->_store->getModel($graphUri, $useAc);
        
        $this->_rdfWriter->setGraphUri($graphUri);

        $base  = $graph->getBaseUri();
        $this->_rdfWriter->setBase($base);

        $namespaces = Erfurt_App::getInstance()->getNamespaces();

        foreach ($namespaces->getNamespacePrefixes($graphUri) as $prefix => $ns) {
            $this->_rdfWriter->addNamespacePrefix($prefix, $ns);
        }
		
        $config = Erfurt_App::getInstance()->getConfig();
        if (isset($config->serializer->ad)) {
            $this->_rdfWriter->startDocument($config->serializer->ad);
        } else {
            $this->_rdfWriter->startDocument();
        }
		
        $this->_rdfWriter->setMaxLevel(1);

        foreach ($additional as $s=>$pArray) {
            foreach($pArray as $p=>$oArray) {
                foreach ($oArray as $o) {
                    $sType = (substr($s, 0, 2) === '_:') ? 'bnode' : 'uri';
                    $lang  = isset($o['lang']) ? $o['lang'] : null; 
                    $dType = isset($o['datatype']) ? $o['datatype'] : null;
                    
                    $this->_handleStatement($s, $p, $o['value'], $sType, $o['type'], $lang, $dType);
                }
            }
        }
        $this->_rdfWriter->resetState();

        $this->_serializeResource($resource, $useAc);

        $this->_rdfWriter->endDocument();

        return $this->_rdfWriter->getContentString();
    }
    
    protected function _handleStatement($s, $p, $o, $sType, $oType, $lang = null, $dType = null)
    { 
        if (null === $this->_currentSubject) {
            $this->_currentSubject = $s;
            $this->_currentSubjectType = $sType;
        }
        
        if ($s === $this->_currentSubject && $sType === $this->_currentSubjectType) {
            // Put the statement on the list.
            if (!isset($this->_pArray[$p])) {
                $this->_pArray[$p] = array();
            }
            
            if ($oType === 'typed-literal') {
               $oType = 'literal';
            }
            
            $oArray =  array(
                'value' => $o,
                'type'  => $oType
            );
            
            if (null !== $lang) {
                $oArray['lang'] = $lang;
            } else if (null !== $dType) {
                $oArray['datatype'] = $dType;
            }
            
            $this->_pArray[$p][] = $oArray;
        } else {
            $this->_forceWrite();
            
            $this->_currentSubject = $s;
            $this->_currentSubjectType = $sType;
            $this->_pArray = array($p => array());

            if ($oType === 'typed-literal') {
               $oType = 'literal';
            }

            $oArray =  array(
                'value' => $o,
                'type'  => $oType
            );

            if (null !== $lang) {
                $oArray['lang'] = $lang;
            } else if (null !== $dType) {
                $oArray['datatype'] = $dType;
            }

            $this->_pArray[$p][] = $oArray;
        }
    }
    
    protected function _forceWrite()
    {
        if (null === $this->_currentSubject) {
            return;
        }
        
        // Write the statements
        $this->_rdfWriter->serializeSubject($this->_currentSubject, $this->_currentSubjectType, $this->_pArray);
        
        $this->_currentSubject = null;
        $this->_currentSubjectType = null;
        $this->_pArray = array();
    }
    
    /**
     * Internal function, which takes a type and a description and serializes all statements of this type in a section.
     *
     * @param string $description A description for the given class of statements (e.g. owl:Class).
     * @param string $class The type which to serialize (e.g. owl:Class).
     */
    protected function _serializeType($description, $class) 
    {	
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT DISTINCT ?s ?p ?o');
        $query->addFrom($this->_graphUri);
        $query->setWherePart('WHERE { ?s ?p ?o . ?s <' . EF_RDF_TYPE . '> <' . $class . '> }');
        $query->setOrderClause('?s ?p ?o');
        $query->setLimit(1000);

        $offset = 0;
        while (true) {
            $query->setOffset($offset);

            $result = $this->_store->sparqlQuery($query, array(
                'result_format'   => 'extended',
                'use_owl_imports' => false,
                'use_additional_imports' => false
            ));

        if ($offset === 0 && count($result['results']['bindings']) > 0) {
            $this->_rdfWriter->addComment($description);
        }

        foreach ($result['results']['bindings'] as $row) {
            $s = $row['s']['value'];
            $p = $row['p']['value'];
            $o = $row['o']['value'];
            $sType = $row['s']['type'];
            $oType = $row['o']['type'];
            $lang  = isset($row['o']['xml:lang']) ? $row['o']['xml:lang'] : null;
            $dType = isset($row['o']['datatype']) ? $row['o']['datatype'] : null;

            $this->_handleStatement($s, $p, $o, $sType, $oType, $lang, $dType);
        }

        if (count($result['results']['bindings']) < 1000) {
            break;
        }

        $offset += 1000;	
        }

        $this->_forceWrite();

        $this->_renderedTypes[] = $class;
    }

    protected function _serializeRest($description)
    {
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT DISTINCT ?s ?p ?o');
        $query->addFrom($this->_graphUri);

        $where = 'WHERE 
                  { ?s ?p ?o . 
                  OPTIONAL { ?s <' . EF_RDF_TYPE . '> ?o2  } .
              FILTER (!bound(?o2) || (';

        $count = count($this->_renderedTypes);
        for ($i=0; $i<$count; ++$i) {
            $where .= '!sameTerm(?o2, <' . $this->_renderedTypes[$i] . '>)';

            if ($i < $count-1) {
                $where .= ' && ';
            }
        }

        $where .= '))}';

        $query->setWherePart($where);
        $query->setOrderClause('?s ?p ?o');
        $query->setLimit(1000);

        $offset = 0;
        while (true) {
            $query->setOffset($offset);

            $result = $this->_store->sparqlQuery($query, array(
                'result_format'   => 'extended',
                'use_owl_imports' => false,
                'use_additional_imports' => false
            ));

        if ($offset === 0 && count($result['results']['bindings']) > 0) {
            $this->_rdfWriter->addComment($description);
        }

        foreach ($result['results']['bindings'] as $row) {
            $s = $row['s']['value'];
            $p = $row['p']['value'];
            $o = $row['o']['value'];
            $sType = $row['s']['type'];
            $oType = $row['o']['type'];
            $lang  = isset($row['o']['xml:lang']) ? $row['o']['xml:lang'] : null;
            $dType = isset($row['o']['datatype']) ? $row['o']['datatype'] : null;

            $this->_handleStatement($s, $p, $o, $sType, $oType, $lang, $dType);
        }

        if (count($result['bindings']) < 1000) {
            break;
        }

        $offset += 1000;
        }

        $this->_forceWrite();
    }

    protected function _serializeResource($resource, $useAc = true, $level = 0)
    {
        require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?s ?p ?o');
        $query->addFrom($this->_graphUri);
        $query->setWherePart('WHERE { ?s ?p ?o . FILTER (sameTerm(?s, <'.$resource.'>))}');
        $query->setOrderClause('?s ?p ?o');
        $query->setLimit(1000);

        $offset = 0;
        $bnObjects = array();

        while (true) {
            $query->setOffset($offset);

            $result = $this->_store->sparqlQuery($query, 
                    array(
                        'result_format'   => 'extended',
                        'use_owl_imports' => false,
                        'use_additional_imports' => false,
                        'use_ac' => $useAc
                    ));

            foreach ($result['results']['bindings'] as $row) {
                $s     = $row['s']['value'];
                $p     = $row['p']['value'];
                $o     = $row['o']['value'];
                $sType = $row['s']['type'];
                $oType = $row['o']['type'];
                $lang  = isset($row['o']['xml:lang']) ? $row['o']['xml:lang'] : null;
                $dType = isset($row['o']['datatype']) ? $row['o']['datatype'] : null;

                if ($oType === 'bnode') {
                    $bnObjects[] = substr($o, 2);
                }

                $this->_handleStatement($s, $p, $o, $sType, $oType, $lang, $dType);
            }

            if (count($result['results']['bindings']) < 1000) {
                break;
            }

            $offset += 1000;
        }
        $this->_forceWrite();

        // SCBD -> Write Bnodes, too
        if ($level <= 10) {
            foreach ($bnObjects as $bn) {
                $this->_serializeResource($bn, $useAc, $level+1);
            }
        }

        // We only return SCBD of the TOP resource...
        if ($level > 0) {
            return;
        }

        // SCBD: Do the same for all Resources, that have the resource as object

        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?s ?p ?o');
        $query->addFrom($this->_graphUri);
        $query->setWherePart('WHERE { ?s ?p ?o . ?s ?p2 ?o2 . FILTER (sameTerm(?o2, <'.$resource.'>)) }');
        $query->setOrderClause('?s ?p ?o');
        $query->setLimit(1000);

        $offset = 0;
        $bnObjects = array();

        while (true) {
            $query->setOffset($offset);

            $result = $this->_store->sparqlQuery($query, 
                    array(
                        'result_format'   => 'extended',
                        'use_owl_imports' => false,
                        'use_additional_imports' => false,
                        'use_ac' => $useAc
                    ));

            foreach ($result['results']['bindings'] as $row) {
                $s     = $row['s']['value'];
                $p     = $row['p']['value'];
                $o     = $row['o']['value'];
                $sType = $row['s']['type'];
                $oType = $row['o']['type'];
                $lang  = isset($row['o']['xml:lang']) ? $row['o']['xml:lang'] : null;
                $dType = isset($row['o']['datatype']) ? $row['o']['datatype'] : null;

                if ($oType === 'bnode') {
                    $bnObjects[] = substr($o, 2);
                }

                $this->_handleStatement($s, $p, $o, $sType, $oType, $lang, $dType);
            }

            if (count($result['results']['bindings']) < 1000) {
                break;
            }

            $offset += 1000;
        }
        $this->_forceWrite();

        // SCBD -> Write Bnodes, too
        if ($level <= 10) {
            foreach ($bnObjects as $bn) {
                $this->_serializeResource($bn, $useAc, $level+1);
            }
        }
    }
}
