<?php
require_once 'Erfurt/Syntax/RdfSerializer/Adapter/Interface.php';
require_once 'Erfurt/Syntax/Utils/Turtle.php';

/**
 * This class acts as an intermediate implementation for some important formats.
 * It uses the ARC library unitl we have own implementations.
 * 
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: Arc.php 2672 2009-03-26 16:20:49Z pfrischmuth $
 */
class Erfurt_Syntax_RdfSerializer_Adapter_Turtle implements Erfurt_Syntax_RdfSerializer_Adapter_Interface
{   
    protected $_baseUri = null;
    protected $_writingStarted = false;
    protected $_namespaces = array();
    
    protected $_resultString = '';
    
    protected $_lastWrittenSubject = null;
    protected $_lastWrittenSubjectLength = 0;
    protected $_lastWrittenPredicate = null;
    protected $_lastWrittenUriLength = 0;
    
    protected $_newLine = false;
    
    protected $_store = null;
    protected $_graphUri = null;
    
    public function serializeGraphToString($graphUri, $pretty = false)
    {
        $this->_store = Erfurt_App::getInstance()->getStore();
        $this->_graphUri = $graphUri;
        $graph = $this->_store->getModel($graphUri);
		
		require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?s ?p ?o');
        $query->addFrom($graphUri);
        $query->setWherePart('WHERE { ?s ?p ?o . }');
        $query->setOrderClause('?s');
        $query->setLimit(1000);
        
        
        $base = $graph->getBaseUri();
        $this->setBaseUri($base);
        
        foreach ($this->_store->listNamespacePrefixes($graphUri) as $ns => $prefix) {
            $this->handleNamespace($prefix, $ns);
        }

        $config = Erfurt_App::getInstance()->getConfig();
        if (isset($config->serializer->ad)) {
            $this->startRdf($config->serializer->ad);
        } else {
            $this->startRdf();
        }
        
        
        $offset = 0;
        while (true) {
            $query->setOffset($offset);
            
            $result = $this->_store->sparqlQuery($query, array('result_format' => 'extended'));
            
            foreach ($result['bindings'] as $row) {
                $s     = $row['s']['value'];
                $p     = $row['p']['value'];
                $o     = $row['o']['value'];
                $sType = $row['s']['type'];
                $oType = $row['o']['type'];
                $lang  = isset($row['o']['xml:lang']) ? $row['o']['xml:lang'] : null;
                $dType = isset($row['o']['datatype']) ? $row['o']['datatype'] : null;

                $this->handleStatement($s, $p, $o, $sType, $oType, $lang, $dType);
            }
            
            if (count($result['bindings']) < 1000) {
    	        break;
    		}
    		
    		$offset += 1000;
        }
        
        return $this->endRdf();
    }
    
    public function serializeResourceToString($resource, $graphUri, $pretty = false)
    {
        $this->_store = Erfurt_App::getInstance()->getStore();
        $this->_graphUri = $graphUri;
        $graph = $this->_store->getModel($graphUri);
		
		require_once 'Erfurt/Sparql/SimpleQuery.php';
        $query = new Erfurt_Sparql_SimpleQuery();
        $query->setProloguePart('SELECT ?s ?p ?o');
        $query->addFrom($graphUri);
        $query->setWherePart('WHERE { ?s ?p ?o . FILTER (sameTerm(?s, <'.$resource.'>))}');
        $query->setOrderClause('?s');
        $query->setLimit(1000);
        
        
        $base = $graph->getBaseUri();
        $this->setBaseUri($base);
        
        foreach ($this->_store->listNamespacePrefixes($graphUri) as $ns => $prefix) {
            $this->handleNamespace($prefix, $ns);
        }

        $config = Erfurt_App::getInstance()->getConfig();
        if (isset($config->serializer->ad)) {
            $this->startRdf($config->serializer->ad);
        } else {
            $this->startRdf();
        }
        
        
        $offset = 0;
        while (true) {
            $query->setOffset($offset);
            
            $result = $this->_store->sparqlQuery($query, array('result_format' => 'extended'));
            
            foreach ($result['bindings'] as $row) {
                $s     = $row['s']['value'];
                $p     = $row['p']['value'];
                $o     = $row['o']['value'];
                $sType = $row['s']['type'];
                $oType = $row['o']['type'];
                $lang  = isset($row['o']['xml:lang']) ? $row['o']['xml:lang'] : null;
                $dType = isset($row['o']['datatype']) ? $row['o']['datatype'] : null;

                $this->handleStatement($s, $p, $o, $sType, $oType, $lang, $dType);
            }
            
            if (count($result['bindings']) < 1000) {
    	        break;
    		}
    		
    		$offset += 1000;
        }
        
        return $this->endRdf();
    }
    
    public function setBaseUri($baseUri)
    {
        $this->_baseUri = $baseUri;
    }
     
    public function startRdf($ad = null)
    {
        if ($this->_writingStarted) {
            $this->_throwException('Document was already started.');
        }
        
        $this->_resultString = '';
        $this->_writingStarted = true;
        
        if (null != $ad) {
            $this->_resultString .= '# ' . $ad . PHP_EOL . PHP_EOL;
        }
        
        if (null !== $this->_baseUri) {
            $this->_resultString .= '@base <' . $this->_baseUri . '> .' . PHP_EOL;
        }
        
        foreach ($this->_namespaces as $ns => $prefix) {
            $this->_resultString .= '@prefix ' . $prefix. ': <' . $ns . '> .' . PHP_EOL;
        }
        
        $this->_resultString .= PHP_EOL;
        
    }   
    
    public function endRdf()
    {
        if (!$this->_writingStarted) {
            $this->_throwException('Document has not been started yet.');
        }
        
        if (null !== $this->_lastWrittenSubject) {
            $this->_write(' .'.PHP_EOL);
        }
        
        $this->_writingStarted = false;
        return $this->_resultString;
    } 
    
    public function handleNamespace($prefix, $ns)
    {
        $this->_addNamespace($ns, $prefix);
    }
    
    protected function _addNamespace($ns, $prefix = null)
    {
        if (isset($this->_namespaces[$ns])) {
            // Namespace already exists.
            return;
        }
        
        $counter = 0;
        $genPrefix = 'ns';
        
        if (null == $prefix) {
            $prefix = $genPrefix;
            $testPrefix = $prefix.$counter++;
        } else {
            $testPrefix = $prefix;
        }
        
        while (true) {
            if (in_array($testPrefix, array_values($this->_namespaces))) {
                $testPrefix = $prefix.$counter++;
            } else {
                $this->_namespaces[$ns] = $testPrefix;
                break;
            }
        }
    }
    
    public function handleStatement($s, $p, $o, $sType, $oType, $lang = null, $dType = null)
    {
        if (!$this->_writingStarted) {
            $this->_throwException('Document has not been started yet.');
        }
        
        if ($s === $this->_lastWrittenSubject) {
            if ($p === $this->_lastWrittenPredicate) {
                $this->_write(', ');
            } else {
                $this->_write(' ;');
                $this->_writeNewline();
                
                $this->_writePredicate($p);
                $this->_lastWrittenPredicate = $p;
            }
        } else {
            if (null !== $this->_lastWrittenSubject) {
                $this->_write(' .');
                $this->_writeNewline(2);
            }
            
            $this->_writeSubject($s, $sType);
            $this->_writePredicate($p);
        }
        
        $this->_writeObject($o, $oType, $lang, $dType);
        
    }
    
    protected function _writeSubject($s, $sType)
    {
        if ($sType === 'uri') {
            $this->_writeUri($s);
            $this->_lastWrittenSubjectLength = $this->_lastWrittenUriLength;
        } else {
            $this->_write($s);
            $this->_lastWrittenSubjectLength = strlen($s);
        }
        
        $this->_resultString .= ' ';
        $this->_lastWrittenSubject = $s;
    }
    
    protected function _writeObject($o, $oType, $lang = null, $dType = null)
    {
        if ($oType === 'uri') {
            $this->_writeUri($o);
        } else if ($oType === 'bnode') {
            $this->_write($o);
        } else {
            if (strpos($o, "\n") !== false || strpos($o, "\r") !== false || strpos($o, "\t") !== false) {
                $this->_write('"""');
                $this->_write(Erfurt_Syntax_Utils_Turtle::encodeLongString($o));
                $this->_write('"""');
            } else {
                $this->_write('"');
                $this->_write(Erfurt_Syntax_Utils_Turtle::encodeString($o));
                $this->_write('"');
            }
            
            if (null !== $lang) {
                $this->_write('@'.$lang);
            } else if (null !== $dType) {
                $this->_write('^^');
                $this->_writeUri($dType);
            }
        }
    }
    
    protected function _writePredicate($p)
    {
        if ($this->_newLine) {
            $this->_resultString .= str_repeat(' ', $this->_lastWrittenSubjectLength+1);
        }
        
        if ($p === EF_RDF_TYPE) {
            $this->_write('a');
        } else {
            $this->_writeUri($p);
        }
        
        $this->_resultString .= ' ';
        $this->_lastWrittenPredicate = $p;
    }
    
   
    
    protected function _writeUri($uri)
    {
        $prefix = null;
        
        $splitIdx = Erfurt_Syntax_Utils_Turtle::findUriSplitIndex($uri);
        if ($splitIdx !== false) {
            $ns = substr($uri, 0, $splitIdx);
            
            if (isset($this->_namespaces[$ns])) {
                $prefix = $this->_namespaces[$ns];
            } else if (null !== $this->_baseUri && substr($uri, 0, $splitIdx) === $this->_baseUri) {
                $prefix = null;
                $uri = substr($uri, $splitIdx);
            } else {
                // We need to support large exports so we add namespaces once and write uris that do not match as
                // full uris.
                //$this->_addNamespace($ns);
                //$prefix = $this->_namespaces[$ns];
            }
            
            if (null !== $prefix) {
                $this->_write($prefix.':'.substr($uri, $splitIdx));
                $this->_lastWrittenUriLength = strlen($prefix.':'.substr($uri, $splitIdx));
            } else {
                $this->_write('<'.$uri.'>');
                $this->_lastWrittenUriLength = strlen('<'.$uri.'>');
            }
        } else {
            if (null !== $this->_baseUri && $uri === $this->_baseUri) {
                $this->_write('<>');
                $this->_lastWrittenUriLength = strlen('<>');
            } else {
                $this->_write('<'.$uri.'>');
                $this->_lastWrittenUriLength = strlen('<'.$uri.'>');
            }
            
        }
    }
    
    protected function _writeNewline($count = 1)
    {
        for ($i=0; $i<$count; ++$i) {
            $this->_resultString .= PHP_EOL;
        }
        
        $this->_newLine = true;
    }
    
    protected function _write($value) 
    {
        $this->_resultString .= $value;
        $this->_newLine = false;        
    }
    
    public function handleComment($comment)
    {   
        $this->_writeNewline();
        $this->_write('# '.$comment);
        $this->_writeNewline();
    }
    
    protected function _throwException($msg)
    {
        require_once 'Erfurt/Syntax/RdfSerializerException.php';
        throw new Erfurt_Syntax_RdfSerializerException($msg);
    }
}
