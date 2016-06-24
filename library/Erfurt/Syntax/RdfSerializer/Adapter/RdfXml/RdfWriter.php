<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * An implemenation of a RDF string writer.
 *
 * @package Erfurt_Syntax_RdfSerializer_Adapter_RdfXml
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Erfurt_Syntax_RdfSerializer_Adapter_RdfXml_RdfWriter
{
    /**
     * @var string
     */
    private $_base;

    /**
     * @var Erfurt_Syntax_StringWriterInterface
     */
    private $_stringWriter;

    /**
     * An associative array where the key is the label of the blank node. 
     *
     * @var string[]
     */
    private $_bNodes;

    /**
     * An associative array where the key is the label of the blank node. 
     *
     * @var int[]
     */
    private $_bNodeCount;

    /**
     * This string array is handled like a set of namespaces.
     *
     * @var string[]
     */
    private $_namespaces;

    /**
     * This Node array is an associative array of Nodes where the key is the uri of the subject
     *
     * @var Node[]
     */
    private $_rendered;

    /**
     * This string array is an associative array where the key is the namespace and the value is the prefix.
     *
     * @var string[]
     */
    private $_qnames;

    /**
     * @var int
     */
    private $_level;

    /**
     * @var int
     */
    private $_maxLevel;

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
        $this->_stringWriter = $stringWriter;
        $this->_stringWriter->setDoctype(EF_RDF_NS, 'RDF');
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
        $this->_namespaces[] = $ns;
        $this->_qnames[$ns] = $prefix;
    }

    /**
     * @see Erfurt_Syntax_RDFStringWriterInterface
     */
    public function serializeSubject($s, $sType, $pArray)
    {
        if ($sType === 'bnode' && isset($this->_renderedBNodes[$s])) {
            return;
        }

        if (isset($this->_rendered[$s])) {
            return;
        }

        $this->_level++;
        $propertyMap = $pArray;

        if (isset($propertyMap[EF_RDF_TYPE]) && count($propertyMap[EF_RDF_TYPE]) > 0) {
            if ($propertyMap[EF_RDF_TYPE][0]['type'] === 'uri') {
                $this->startElement($propertyMap[EF_RDF_TYPE][0]['value']);
                unset($propertyMap[EF_RDF_TYPE][0]);
                $propertyMap[EF_RDF_TYPE] = array_values($propertyMap[EF_RDF_TYPE]);
            }
        } else {
            $this->_stringWriter->startElement(EF_RDF_NS, 'Description');
        }

        // add identifier
        if ($sType === 'bnode') {
            $this->_stringWriter->addAttribute(EF_RDF_NS, 'nodeID', 'b' . substr($s, 2));
        } else {
            $this->_stringWriter->addAttribute(EF_RDF_NS, 'about', $s);
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
                    $this->_stringWriter->addAttribute($prop, null, $values[0]['value']);
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

        $this->_rendered[$s] = true;

        $this->_stringWriter->endElement();
        $this->_level--;
    }

    /**
     * @see Erfurt_Syntax_RDFStringWriterInterface
     */
    public function setMaxLevel($level)
    {
        $this->_maxLevel = $level;
    }

    /**
     * @see Erfurt_Syntax_RDFStringWriterInterface
     */
    public function startDocument($ad = null)
    {
        $this->addNamespaces();

        if (null !== $ad) {
            $this->_stringWriter->setAd($ad);
        }

        $this->_stringWriter->addEntity('xsd', EF_XSD_NS);
        $this->_stringWriter->startDocument();
        $this->_stringWriter->startElement(EF_RDF_NS, 'RDF');
    }

    public function linefeed($count = 1)
    {
        $this->_stringWriter->linefeed($count);
    }

    /**
     * @see Erfurt_Syntax_RDFStringWriterInterface
     */
    public function endDocument()
    {
        $this->_stringWriter->endDocument();
    }

    /**
     * @see Erfurt_Syntax_RDFStringWriterInterface
     */
    public function setBase($base)
    {
        $this->_base = $base;
        $this->_stringWriter->setBase($base);
    }

    public function addComment($comment)
    {
        $this->_stringWriter->writeComment($comment);
    }

    private function addNamespaces()
    {
        foreach (array_unique($this->_namespaces) as $ns) {

            if (isset($this->_qnames[$ns])) {
                $prefix = $this->_qnames[$ns];
            } else {
                continue;
            }

            $this->_stringWriter->addNamespace($prefix, $ns);
            $this->_stringWriter->addEntity($prefix, $ns);
        }
    }

    /**
     * @param Node $node
     * @return boolean
     */
    private function isList($node)
    {
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
        if (isset($this->_rendered[$child])) {
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
            $this->_stringWriter->addAttribute(EF_RDF_NS, 'nodeID', 'b' . substr($value['value'], 2));
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
            $this->_rendered[$current] = true;
            $propertyMap = $listArray[$current];
            $first = $propertyMap['first'];
            $elements[] = $first;
            $rest = $propertyMap['rest'];
            $current = $rest;
        }

        // write list
        $this->_stringWriter->addAttribute(EF_RDF_NS, 'parseType', 'Collection');
        foreach ($elements as $e) {
            if ($this->shouldNest($e)) {
                $this->serializeSubject($e);
            } else {
                $this->_stringWriter->startElement(EF_RDF_NS, 'Description');
                if ($e['type'] === 'bnode') {
                    $this->_stringWriter->addAttribute(EF_RDF_NS, 'nodeID', 'b' . $e['value']);
                } else {
                    $this->_stringWriter->addAttribute(EF_RDF_NS, 'about', $e['value']);
                }
                $this->_stringWriter->endElement();
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
                $this->_stringWriter->addAttribute('xml:lang', null, $language);
            } else if (isset($value['datatype'])) {
                $datatype = $value['datatype'];
                $this->_stringWriter->addAttribute(EF_RDF_NS, 'datatype', $datatype);
            }

            $this->_stringWriter->writeData($value['value']);
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
            $this->_stringWriter->addAttribute(EF_RDF_NS, 'resource', $value['value']);
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

    public function resetState()
    {
        $this->_bNodes = array();
        $this->_bNodeCount = array();
        $this->_namespaces = array();
        $this->_rendered = array();
        $this->_level = 0;
        $this->_maxLevel = 1;
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

        $this->_stringWriter->endElement();
    }

    /**
     * @param Node $value
     * @return boolean
     */
    private function shouldNest($node)
    {
        if ($node['type'] === 'uri') {
            if (isset($this->_rendered[$node['value']])) {
                return false;
            }

            if ($this->_level >= $this->_maxLevel) {
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
        $this->_stringWriter->startElement($uri);
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

        $result = $this->_store->sparqlQuery(
            $query,
            array(
                'result_format'   => 'extended',
                'use_owl_imports' => false,
                'use_additional_imports' => false
            )
        );

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
        return $this->_stringWriter->getContentString();
    }
}
