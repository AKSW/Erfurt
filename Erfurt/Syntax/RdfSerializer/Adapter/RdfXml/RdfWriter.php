<?php
/**
 * An implemenation of a RDF string writer.
 *
 * @package erfurt
 * @subpackage   syntax
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: RdfWriter.php 4016 2009-08-13 15:21:13Z pfrischmuth $
 */
class Erfurt_Syntax_RdfSerializer_Adapter_RdfXml_RdfWriter 
{
    	
	/**
	 * @var string
	 */
	private $base; 
	
	
	
	/**
	 * @var Erfurt_Syntax_StringWriterInterface
	 */
	private $stringWriter;
	
	/**
	 * An associative array where the key is the label of the blank node. 
	 *
	 * @var string[]
	 */
private $bNodes;
	
	/**
	 * An associative array where the key is the label of the blank node. 
	 *
	 * @var int[]
	 */
private $bNodeCount;
	
	/**
	 * This string array is handled like a set of namespaces.
	 * 
	 * @var string[]
	 */
	private $namespaces;
	
	/**
	 * This Node array is an associative array of Nodes where the key is the uri of the subject
	 *
	 * @var Node[]
	 */
	private $rendered;
	
	/**
	 * This string array is an associative array where the key is the namespace and the value is the prefix.
	 *
	 * @var string[]
	 */
	private $qnames;
	
	/**
	 * This is an associative array where the key is the uri of the subject and the value is an associative array 
	 * itself containing all properties for the specific subject. Each property is an indexed array again containing
	 * all objects for the property. So it looks something like this: Node[<Subject-URI][<Predicate-URI][0-N] 
	 * @var Node[][][]
	 */
private $subjects;
	
	/**
	 * @var int
	 */
	private $level;
	
	/**
	 * @var int
	 */
	private $maxLevel;
	
	/**
	 * @var int
	 */
	private static $bNodeNumber = 0;
	
	protected $_store = null;
	protected $_graphUri = null;
	
	protected $_listArray = null;
	
	protected $_useAc = true;
	
	/**
	 * @param Erfurt_Syntax_StringWriterInterface $stringWriter
	 * @param MemModel $model
	 */
	public function __construct($stringWriter, $useAc = true) 
	{		
		$this->resetState();
		$this->_useAc = $useAc;
		$this->stringWriter = $stringWriter;
		$this->stringWriter->setDoctype(EF_RDF_NS, 'RDF');
		$this->_store = Erfurt_App::getInstance()->getStore();
	}
	
	public function setGraphUri($graphUri)
	{
	    $this->_graphUri = $graphUri;
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function addNamespacePrefix($prefix, $ns) 
	{
	    $this->namespaces[] = $ns;
		$this->qnames[$ns] = $prefix;
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function serializeSubject($s, $sType, $pArray) 
	{
		if ($sType === 'bnode' && isset($this->_renderedBNodes[$s])) {
		    return;
		}
		
		if (isset($this->rendered[$s])) {
		    return;
		}
		
		$this->level++;
		$propertyMap = $pArray;
			
		if (isset($propertyMap[EF_RDF_TYPE]) && count($propertyMap[EF_RDF_TYPE]) > 0) {
			if ($propertyMap[EF_RDF_TYPE][0]['type'] === 'uri') {
				$this->startElement($propertyMap[EF_RDF_TYPE][0]['value']);
				unset($propertyMap[EF_RDF_TYPE][0]);
				$propertyMap[EF_RDF_TYPE] = array_values($propertyMap[EF_RDF_TYPE]);
			}
		} else {
			$this->stringWriter->startElement(EF_RDF_NS, 'Description');
		}

		// add identifier
		if ($sType === 'bnode') {
			$this->stringWriter->addAttribute(EF_RDF_NS, 'nodeID', 'b' . substr($s, 2));
		} else {
			$this->stringWriter->addAttribute(EF_RDF_NS, 'about', $s);	
		}
		
		// write short literal properties
		foreach ($propertyMap as $key=>$values) {
			if (count($values) !== 1) {
			    continue;
			}

			if ($values[0]['type'] === 'literal') {
				if ((!isset($values[0]['datatype']) && (!isset($values[0]['lang'])))
						&& (strlen($values[0]['value']) < 40)) {
					
					$prop = $key;
					$this->stringWriter->addAttribute($prop, null, $values[0]['value']);
					unset($propertyMap[$key]);
				}
			}
		}
		
		
		
		// write all other properties
		foreach ($propertyMap as $key=>$values) {
			foreach ($values as $v) {
				$this->serializeProperty($key, $v);
			}
		}

        $this->rendered[$s] = true;

		$this->stringWriter->endElement();
		$this->level--;
	}
		
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function setMaxLevel($level) 
	{	
		$this->maxLevel = $level;
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function startDocument($ad = null) 
    {	
		$this->addNamespaces();
		
		if (null !== $ad) {
		    $this->stringWriter->setAd($ad);
		}
		
		$this->stringWriter->addEntity('xsd', EF_XSD_NS);
		$this->stringWriter->startDocument();
		$this->stringWriter->startElement(EF_RDF_NS, 'RDF');
	}
	
	public function linefeed($count = 1) 
	{
	    $this->stringWriter->linefeed($count);
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function endDocument() 
	{	
		$this->stringWriter->endDocument();
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function setBase($base) 
	{	
		$this->base = $base;
		$this->stringWriter->setBase($base);
	}
	
	public function addComment($comment)
	{
	    $this->stringWriter->writeComment($comment);
	}
	
	private function addNamespaces() {
		
		foreach (array_unique($this->namespaces) as $ns) {
			
			if (isset($this->qnames[$ns])) {
			    $prefix = $this->qnames[$ns];
			} else {
			    continue;
		    }
			
			$this->stringWriter->addNamespace($prefix, $ns);
			$this->stringWriter->addEntity($prefix, $ns);
		}
	}
	
	/**
	 * @param Node $node
	 * @return boolean
	 */
	private function isList($node) {
		
		if ($node['type'] === 'literal') {
		    return false;
		}
		
		// Node is either anonymous or rdf:Nil
		if ($node['type'] === 'uri') {
			if ($node['value'] === EF_RDF_NIL) {
				return true;
			}
			return false;
		}

		$listArray = $this->_getListArray();
		if (isset($listArray[$node['value']])) {
		    $propertyMap = $listArray[$node['value']];
		} else {
		    return false;
		}
		
		
		
		$child = $propertyMap['rest'];
		
		// child should not be rendered allready
		if (isset($this->rendered[$child])) {
		    return false;
		}
		
		return $this->isList($child);
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyBNode($value) 
    {	
		if ($value['type'] === 'bnode') {
			$this->stringWriter->addAttribute(EF_RDF_NS, 'nodeID', 'b' . substr($value['value'], 2));
			return true;
		} else {
		    return false;
	    }
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyList($value) 
	{	
		if (!$this->isList($value)) {
		    return false;
		} 

		$elements = array();
		$current = $value['value'];
		
		$listArray = $this->_getListArray();
		
		while ($current !== EF_RDF_NIL) {
			$this->rendered[$current] = true;
			$propertyMap = $listArray[$current];
			$first = $propertyMap['first'];
			$elements[] = $first;
			$rest = $propertyMap['rest'];
			$current = $rest;
		}

		// write list
		$this->stringWriter->addAttribute(EF_RDF_NS, 'parseType', 'Collection');
		foreach ($elements as $e) {
			if ($this->shouldNest($e)) {
			    $this->serializeSubject($e);
			} else {
				$this->stringWriter->startElement(EF_RDF_NS, 'Description');
				if ($e['type'] === 'bnode') {
					$this->stringWriter->addAttribute(EF_RDF_NS, 'nodeID', 'b' . $e['value']);
				} else {
					$this->stringWriter->addAttribute(EF_RDF_NS, 'about', $e['value']);
				}
				$this->stringWriter->endElement();
			}
		}
		
		return true;
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyLiteral($value) 
	{
		if ($value['type'] === 'literal') {
		    if (isset($value['lang'])) {
		        $language = $value['lang'];
		        $this->stringWriter->addAttribute('xml:lang', null, $language);
		    } else if (isset($value['datatype'])) {
		        $datatype = $value['datatype'];
    		    $this->stringWriter->addAttribute(EF_RDF_NS, 'datatype', $datatype);
		    }
		    
		    $this->stringWriter->writeData($value['value']);
		    return true;
		} else {
		    return false;
		}
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyNested($value) 
	{	
		if (($value['type'] !== 'uri') || !$this->shouldNest($value)) {
		    return false;
		} 
		
		return false;
// TODO
		#$this->serializeSubject($value);
		#return true;
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyReference($value) 
	{
		if ($value['type'] === 'uri') {
			$this->stringWriter->addAttribute(EF_RDF_NS, 'resource', $value['value']);
			return true;
		} else {
		    return false;
	    }
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyXMLLiteral($value) 
	{
// TODO Implement this function!
		return false;
	}
	
	public function resetState() {
		
		$this->bNodes = array();
		$this->bNodeCount = array();
		$this->namespaces = array();
		$this->rendered = array();
		$this->level = 0;
		$this->maxLevel = 1;
	}
	
	/**
	 * @param Resource $value
	 * @param Node $value
	 * @throws Exception
	 */
	private function serializeProperty($property, $value) 
	{
		$this->startElement($property);
		
		if (!$this->propertyList($value)
				&& !$this->propertyNested($value)
				&& !$this->propertyBNode($value)
				&& !$this->propertyReference($value)
				&& !$this->propertyXMLLiteral($value)
				&& !$this->propertyLiteral($value)) {
			
			#var_dump($value);exit;
			throw new Exception('Could not serialize property '.$property.' with value '.$value);
		}
		
		$this->stringWriter->endElement();
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function shouldNest($node) 
	{	
		if ($node['type'] === 'uri') {
			if (isset($this->rendered[$node['value']])) {
				return false;
			}
			
			if ($this->level >= $this->maxLevel) {
			    return false;
		    }
			
			return true;
		} else if ($node['type'] === 'bnode') {
			return false;
			#return true;
		} else {
		    return false;
	    }
	}

	/**
	 * @param string $uri
	 */
	private function startElement($uri) 
	{	
		$this->stringWriter->startElement($uri);
	}
	
	protected function _getListArray()
	{
	    if (null === $this->_listArray) {
	        $this->_sparqlForListResources();
	    }
	    
	    return $this->_listArray;
	}
	
	protected function _sparqlForListResources()
	{
	    require_once 'Erfurt/Sparql/SimpleQuery.php';
	    $query = new Erfurt_Sparql_SimpleQuery();
	    $query->setProloguePart('SELECT ?s ?first ?rest');
	    $query->addFrom($this->_graphUri);
	    $query->setWherePart('WHERE { ?s <' . EF_RDF_FIRST . '> ?first . ?s <' . EF_RDF_REST . '> ?rest }');
	    
	    $result = $this->_store->sparqlQuery($query, array(
	        'result_format'   => 'extended',
	        'use_owl_imports' => false,
	        'use_additional_imports' => false
	    ));
	    
	    $listArray = array();
	    if ($result) {
	        foreach ($result['results']['bindings'] as $row) {
    	        $listArray[$row['s']['value']] = array(
    	            'first' => $row['first']['value'],
    	            'rest'  => $row['rest']['value']
    	        );
    	    }
	    }

	    $this->_listArray = $listArray;
	}
	
	public function getContentString()
	{
	    return $this->stringWriter->getContentString();
	}
}
?>
