<?php
/*
 * RDFStringWriterImpl.php
 * Encoding: UTF-8
 *
 * Copyright (c) 2007 Philipp Frischmuth <philipp@frischmuth24.de>
 *
 * This file is part of pOWL - web based ontology editor.
 *
 * pOWL is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * pOWL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with pOWL; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * An implemenation of a RDF string writer.
 *
 * @package syntax
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: RDFStringWriterImpl.php 1010 2007-06-03 13:11:24Z p_frischmuth $
 */
class Erfurt_Syntax_RDFStringWriterImpl implements Erfurt_Syntax_RDFStringWriterInterface {
	
	/**
	 * @var string
	 */
	private $base; 
	
	/**
	 * @var MemModel
	 */
	private $model;
	
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
	
	/**
	 * @param Erfurt_Syntax_StringWriterInterface $stringWriter
	 * @param MemModel $model
	 */
	public function __construct(Erfurt_Syntax_StringWriterInterface $stringWriter, MemModel $model) {	
		
		$this->resetState();
		$this->model = $model;
		$this->stringWriter = $stringWriter;
		$this->stringWriter->setDoctype(EF_RDF_NS, 'RDF');
	}
	
	/**
	 * @return string
	 */
	public function __toString() {
		
		return $this->getContentString();
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function addNamespacePrefix($prefix, $ns) {
		
		$this->qnames[$ns] = $prefix;
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function serializeAll($comment = null) {
		
		$started = false;
		
		foreach ($this->subjects as $subURI=>$properties) {
			if (!$started && !isset($this->rendered[$subURI])) {
				if ($comment !== null) {
					$this->stringWriter->writeComment($comment);
				}
				$started = true;
			}
			$this->serializeSubject(new Resource($subURI));
		}
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function serializeSubject(Node $subject) {
		
		if (isset($this->rendered[$subject->getURI()]) || !isset($this->subjects[$subject->getURI()])) {
			return;
		}
		
		$this->level++;
		$this->rendered[$subject->getURI()] = $subject;
		$propertyMap = $this->subjects[$subject->getURI()];
			
		if (count($propertyMap[EF_RDF_TYPE]) > 0) {
			if ($propertyMap[EF_RDF_TYPE][0] instanceof Resource) {
				$this->startElement($propertyMap[EF_RDF_TYPE][0]->getURI());
				unset($propertyMap[EF_RDF_TYPE][0]);
			}
		} else {
			$this->stringWriter->startElement(EF_RDF_NS, 'Description');
		}
		
		// add identifier
		if ($subject instanceof BlankNode) {
			if (isset($this->bNodes[$subject->getURI()]) && isset($this->bNodeCount[$subject->getURI()])) {
				$nodeID = $this->bNodes[$subject->getURI()];
				$count = $this->bNodeCount[$subject->getURI()];
				
				if (($count > 1) || (($count === 1) && ($this->level === 1))) {
					$this->stringWriter->addAttribute(EF_RDF_NS, 'nodeID', $nodeID);
				}
			}
		} else {
			$this->stringWriter->addAttribute(EF_RDF_NS, 'about', $subject->getURI());	
		}
		
		// write short literal properties
		foreach ($propertyMap as $key=>$values) {
			if (count($values) !== 1) continue;
			
			if ($values[0] instanceof Literal) {
				if (($values[0]->getDatatype() == null) && ($values[0]->getLanguage() == null)
						&& (strlen($values[0]->getLabel()) < 40)) {
					
					$prop = new Resource($key);
					$this->stringWriter->addAttribute($prop->getNamespace(), $prop->getLocalName(),
							$values[0]->getLabel());
					unset($propertyMap[$key]);
				}
			}
		}
		
		// write all other properties
		foreach ($propertyMap as $key=>$values) {
			foreach ($values as $v) {
				$this->serializeProperty(new Resource($key), $v);
			}
		}

		$this->stringWriter->endElement();
		$this->level--;
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function serializeSubjects($subjects, $comment = null) {
		
		$started = false;
		foreach ($subjects as $s) {
			if (!$started && !isset($this->rendered[$s->getURI()])) {
				if ($comment !== null) $this->stringWriter->writeComment($comment);
				$started = true;
			}
			
			$this->serializeSubject($s);
		}
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function setMaxLevel($level) {
		
		$this->maxLevel = $level;
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function startDocument() {
		
		$this->collectInformations();
		$this->addNamespaces();
		$this->stringWriter->addEntity('xsd', EF_XSD_NS);
		$this->stringWriter->startDocument();
		$this->stringWriter->startElement(EF_RDF_NS, 'RDF');
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function endDocument() {
		
		$this->stringWriter->endDocument();
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function setBase($base) {
		
		$this->base = $base;
		$this->stringWriter->setBase($base);
	}
	
	/**
	 * @see Erfurt_Syntax_RDFStringWriterInterface
	 */
	public function getContentString() {
		
		return $this->stringWriter->getContentString();
	}
	
	private function addNamespaces() {
		
		foreach (array_unique($this->namespaces) as $ns) {
			
			if (isset($this->qnames[$ns])) $prefix = $this->qnames[$ns];
			else continue;
			
			$this->stringWriter->addNamespace($prefix, $ns);
			$this->stringWriter->addEntity($prefix, $ns);
		}
	}
	
	/**
	 * @param Resource $subject
	 * @return Node[][] Returns a two-dimensional array of the form Node[<Predicate-URI>][0-N].
	 */
	private function buildPropertyMap(Resource $subject) {
		
		$properties = array();
		
		$propModel = $this->model->find($subject, null, null);
		foreach ($propModel->triples as $statement) {
			$predicate = $statement->getPredicate();
			$object = $statement->getObject();
			
			if (isset($properties[$predicate->getURI()])) $objects = $properties[$predicate->getURI()];
			else {
				$objects = array();
			}
			
			$objects[] = $object;
			$properties[$statement->getLabelPredicate()] = $objects;
		}
		
		return $properties;
	}
	
	private function collectInformations() {
		
		$this->subjects = array();
		foreach ($this->model->triples as $statement) {
			
			$subject = $statement->getSubject();
			$predicate = $statement->getPredicate();
			$object = $statement->getObject();
			
			$subLabel = $statement->getLabelSubject();
			$predLabel = $statement->getLabelPredicate();
			$objLabel = $statement->getLabelObject();
			
			if (!isset($this->subjects[$subLabel])) {
				$this->subjects[$subLabel] = $this->buildPropertyMap($subject);
			}
			
			if (($subject instanceof BlankNode) && 
					(!isset($this->bNodes[$subLabel]))) {

				$this->bNodes[$subLabel] = 'b'.($this->bNodeNumber++);
			}
			
			if ($object instanceof BlankNode) {
				if (!isset($this->bNodes[$objLabel])) {
					$this->bNodes[$objLabel] = 'b'.($this->bNodeNumber++);
				}
				
				if (!isset($this->bNodeCount[$objLabel])) {
					$this->bNodeCount[$objLabel] = 1;
				} else {
					$this->bNodeCount[$objLabel]++;
				}
			}
			
			$this->namespaces[] = $predicate->getNamespace();
			if ($predLabel === EF_RDF_TYPE) {
				if (!($object instanceof BlankNode)) {
					$this->namespaces[] = $object->getNamespace();
				}
			}	
		}
	}
	
	/**
	 * @param Node $node
	 * @return boolean
	 */
	private function isList(Node $node) {
		
		if (!($node instanceof Resource) && !($node instanceof BlankNode)) return false;
		
		// Node is either anonymous or rdf:Nil
		if ($node instanceof Resource) {
			if ($node->getURI() === EF_RDF_NIL) {
				return true;
			}
			return false;
		}
		
		// Node is referenced exactly once
		if (!(isset($this->bNodeCount[$node->getURI()])) || ($this->bNodeCount[$node->getURI()] !== 1)) {
			return false;
		}
		
		if (!(isset($this->subjects[$node->getURI()])) || (count($this->subjects[$node->getURI()]) !== 2)) {
			return false;
		}
		
		$propertyMap = isset($this->subjects[$node->getURI()]);
		// should be only one element for rdf:first
		if ((!isset($propertyMap[EF_RDF_FIRST])) || (count($propertyMap[EF_RDF_FIRST]) !== 1)) {
			return false;
		}
		
		// of that one element, it should be a resource
		$firstSet = $propertyMap[EF_RDF_FIRST];
		if (!($firstSet[0] instanceof Resource)) return false;
		
		if ((!isset($propertyMap[EF_RDF_REST])) || (count($propertyMap[EF_RDF_REST]) !== 1)) {
			return false;
		} 
		
		$nextSet = $propertyMap[EF_RDF_REST];
		$child = $nextSet[0];
		
		// child should not be rendered allready
		if (isset($this->rendered[$child->getURI()])) return false;
		
		return $this->isList($child);
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyBNode(Node $value) {
		
		if ($value instanceof BlankNode) {
			$this->stringWriter->addAttribute(EF_RDF_NS, 'nodeID', $this->bNodes[$value->getLabel()]);
			return true;
		} else return false;
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyList($value) {
		
		if (!$this->isList($value)) return false;
		
		$elements = array();
		$current = $value;
		
		while ($current->getURI() !== EF_RDF_NIL) {
			$this->rendered[] = $current;
			$propertyMap = $this->subjects[$current->getURI()];
			$first = $propertyMap[EF_RDF_FIRST];
			$elements[] = $first;
			$rest = $propertyMap[EF_RDF_REST];
			$current = $rest;
		}
		
		// write list
		$this->stringWriter->addAttribute(EF_RDF_NS, 'parseType', 'Collection');
		foreach ($elements as $e) {
			if ($this->shouldNest($e)) $this->serializeSubject($e);
			else {
				$this->stringWriter->startElement(EF_RDF_NS, 'Description');
				if ($e instanceof BlankNode) {
					$this->stringWriter->addAttribute(EF_RDF_NS, 'nodeID', $this->bNodes[$e->getLabel()]);
				} else {
					$this->stringWriter->addAttribute(EF_RDF_NS, 'about', $e->getURI());
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
	private function propertyLiteral($value) {
		
		if ($value instanceof Literal) {
			$datatype = $value->getDatatype();
			$language = $value->getLanguage();
			
			if ($datatype != null) $this->stringWriter->addAttribute(EF_RDF_NS, 'datatype', $datatype);
			if ($language != null) $this->stringWriter->addAttribute(null, 'xml:lang', $language);
			$this->stringWriter->writeData($value->getLabel());
			return true;
		} else return false;
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyNested($value) {
		
		if (!($value instanceof Resource) || !$this->shouldNest($value)) return false;
		
		$this->serializeSubject($value);
		return true;
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyReference($value) {
		
		if ($value instanceof Resource) {
			$this->stringWriter->addAttribute(EF_RDF_NS, 'resource', $value->getURI());
			return true;
		} else return false;
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function propertyXMLLiteral($value) {
// TODO implement this function or check where the sense in this function is
		return false;
	}
	
	private function resetState() {
		
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
	private function serializeProperty($property, $value) {
		
		$propertyURI = $property->getURI();
		$this->startElement($propertyURI);
		
		if (!$this->propertyList($value)
				&& !$this->propertyNested($value)
				&& !$this->propertyBNode($value)
				&& !$this->propertyReference($value)
				&& !$this->propertyXMLLiteral($value)
				&& !$this->propertyLiteral($value)) {
			
			throw new Exception('Could not serialize property '.$property.' with value '.$value);
		}
		
		$this->stringWriter->endElement();
	}
	
	/**
	 * @param Node $value
	 * @return boolean
	 */
	private function shouldNest($node) {
		
		if ($node instanceof Resource) {
			if (isset($this->rendered[$node->getURI()]) || $this->subjects[$node->getURI()] === null) {
				return false;
			}
			
			if ($this->level >= $this->maxLevel) return false;
			
			return true;
		} else if ($node instanceof BlankNode) {
			return true;
		} else return false;
	}

	/**
	 * @param string $uri
	 */
	private function startElement($uri) {
		
		$r = new Resource($uri);
		$this->stringWriter->startElement($r->getNamespace(), $r->getLocalName());
	}
}
?>