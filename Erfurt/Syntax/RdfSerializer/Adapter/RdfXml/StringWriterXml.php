<?php
/*
 * StringWriterXMLImpl.php
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
 * This implementation of a string writer, writes the content as pretty formatted XML in a string.
 *
 * @package erfurt
 * @subpackage   syntax
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 */
class Erfurt_Syntax_RdfSerializer_Adapter_RdfXml_StringWriterXml 
{

	/**
	 * @var string
	 */
	private $INDENT = '  ';
	
	/**
	 * @var string
	 */
	private $NS_PREFIX = 'ns';
	
	/**
	 * @var string
	 */
	private $c_encoding;
		
	/**
	 * @var string
	 */
	private $base;
	
	/**
	 * @var array (used as stack)
	 */
	private $bases;
	
	/**
	 * @var boolean
	 */
	private $dataWritten;
	
	/**
	 * @var string
	 */
	private $doctype_ns;
	
	/**
	 * @var string
	 */
	private $doctype_local;
	
	/**
	 * @var array (associative)
	 */
	private $entities;
	
	/**
	 * @var boolean
	 */
	private $firstAttribute;
	
	/**
	 * @var boolean
	 */
	private $inTag;
	
	/**
	 * @var int
	 */
	private $level;
	
	/**
	 * @var array[][] (first dimension as stack, second as an associative array)
	 */
	private $namespaces;
	
	/**
	 * @var array (indexed)
	 */
	private $nextNamespaces;
	
	/**
	 * @var int
	 */
	private $tagLength;
	
	/**
	 * @var array (used as stack)
	 */
	private $tags;
	
	/**
	 * @var boolean
	 */
	private $wasEmpty;
	
	/**
	 * @var boolean
	 */
	private $wasComment;
	
	/**
	 * @var string
	 */
	private $xmlString;
	
	protected $_ad = null;
	
	/**
	 * @param string/null $encoding
	 */
	public function __construct($encoding = null) {
		
		if ($encoding !== null) $this->c_encoding = $encoding;
		else $this->c_encoding = 'UTF-8';
		
		$this->resetState();
	}
	
	/**
	 * @return string
	 */
	public function __toString() {
		
		return $this->getContentString();
	}
	
	public function setAd($ad) 
	{
	    $this->_ad = $ad;
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function startDocument() {
		
		$this->write('<?xml version="1.0" encoding="' . $this->c_encoding . '" ?>');
		
		if (null !== $this->_ad) {
		    $this->writeComment($this->_ad);
		}
		
		$this->linefeed(2);
			
		// write entity definitions iff at least one is set
		if (count($this->entities) > 0) {
			$this->write('<!DOCTYPE ' . $this->getDoctype() . ' [' . PHP_EOL);
			
			foreach ($this->entities as $name=>$value) {
				$this->write($this->INDENT.'<!ENTITY '.$name.' "'.$this->sanitize($value, true).'">'.PHP_EOL);
			}
			
			$this->write(']>' . PHP_EOL);
		}
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function endDocument() {
		
		// close all open tags except from the root element
		while (!(count($this->tags) === 1)) {
			$this->endElement();
		}
		
		// add a newline and close the root element
		$this->linefeed();
		$this->endElement();
		
		$this->linefeed();
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function addEntity($name, $value) {

		if (($name !== null) && ($value !== null) && ($value !== '')) {
			$this->entities[$name] = $value;
		}
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function addNamespace($prefix, $ns) {
		
		$topNamespaces = array_pop($this->namespaces);
		$topNamespaces[$ns] = $prefix;
		array_push($this->namespaces, $topNamespaces);
		
		$this->nextNamespaces[] = $ns;
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function startElement($ns, $local = null) {
		
		if ($this->inTag === true) {
			$this->finishTag(false);
		} else if (($this->wasComment === false) && ($this->level < 2)) {
			$this->linefeed();
		}
		if ($this->wasComment === true) {
		    $this->wasComment = false;
		}

		
		if (count($this->tags) > 0) array_push($this->namespaces, array());
		
		$this->indent();
		
		$this->write('<');
		$tag = $this->writeQName($ns, $local);
		$tagLength = strlen($tag);
		array_push($this->tags, array($ns, $local));
		$this->inTag = true;
		$this->firstAttribute = true;
		
		if ((($this->base !== null) && (count($this->bases) === 0)) || ($this->base !== end($this->bases))) {
			$this->writeAttribute('xml:base', $this->base);
		}
		array_push($this->bases, $this->base);
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function endElement() {
		
		if ($this->inTag === true) {
			$this->finishTag(true);
			array_pop($this->tags);
			$this->level--;
			$this->wasEmpty = true;
		} else {
			$this->level--;
			
			if ($this->dataWritten === true) {
				$this->dataWritten = false;
			} else {
				$this->indent();
			}
			
			$tag = array_pop($this->tags);

			$this->write('</');
			$this->writeQName($tag[0], $tag[1]);
			$this->write('>');
			$this->wasEmpty = false;
		}
		
		array_pop($this->namespaces);
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function addAttribute($ns, $local, $value) {
		
		$this->indentAttribute();
		$this->write(' ');
		$this->writeQName($ns, $local);
		$this->write('="' . $this->replaceEntities($this->sanitize($value, true)) . '"');
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function writeComment($comment = null) {
		
		if (null === $comment) {
		    $this->write(PHP_EOL.PHP_EOL);
		    return;
		}
		
		if ($this->inTag === true) {
			$this->finishTag(false);
		}
		
		$this->write(PHP_EOL.PHP_EOL.'<!-- '.$this->sanitize($comment).' -->');
		$this->wasComment = true;
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function writeData($data, $raw = false) {
		
		if ($this->inTag === true) {
			$this->finishTag(false);
		}
		
		if ($raw) {
			$this->write($data);
		} else {
			$this->write($this->sanitize($data));
		}
		
		$this->dataWritten = true;
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function setBase($base) {
		
		$this->base = $base;
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function setDoctype($ns, $local) {
		
		$this->doctype_ns = $ns;
		$this->doctype_local = $local;
	}
	
	/**
	 * @see Erfurt_Syntax_StringWriterInterface
	 */
	public function getContentString() {
		
		return $this->xmlString;
	}
	
	private function resetState() {
		
		$this->base 			= null;
		$this->bases 			= array();
		$this->dataWritten 		= false;
		$this->entities 		= array();
		$this->firstAttribute	= false;
		$this->inTag 			= false;
		$this->level			= 0;			
		$this->namespaces 		= array();
		$this->nextNamespaces 	= array();
		$this->tagLength		= 0;
		$this->tags 			= array();
		$this->wasEmpty 		= true;
		$this->wasComment		= false;
		$this->xmlString		= '';
	}
	
	/**
	 * @param boolean $isEmpty
	 */
	private function finishTag($isEmpty) {
		
		$this->writeNamespaces();
		
		if ($isEmpty === true) $this->write(' />');
		else $this->write('>');
		
		if ($this->level === 0) {
		    $this->linefeed();
		}
		
		$this->inTag = false;
		$this->level++; 
	}
	
	/**
	 * @return string
	 */
	private function getDoctype() {
		
		if (($this->doctype_ns !== null) && ($this->doctype_local !== null)) {
			return $this->getName($this->doctype_ns) . ':' . $this->doctype_local;
		} else return '';
	}
	
	/**
	 * @param string $namespace
	 * @return string
	 */
	private function getName($namespace) {

		$name = null;
		foreach ($this->namespaces as $nsArray) {
			if (isset($nsArray[$namespace])) {
				$name = $nsArray[$namespace];
				break;
			}
		}
		
		if ($name === null) {
			$i = 0;
			
			while (true) {
				$contains = false;
				foreach ($this->namespaces as $nsArray) {
					foreach ($nsArray as $ns=>$prefix) {
						if ($prefix === ($this->NS_PREFIX.$i)) {
							$i++;
							$contains = true;
							break;
						}
					}
					if ($contains === true) break;
				}
				if ($contains === false) break;
			}
			
			$name = $this->NS_PREFIX . $i;
			$topNamespaces = array_pop($this->namespaces);
			$topNamespaces[$namespace] = $name;
			array_push($this->namespaces, $topNamespaces);
			$this->nextNamespaces[] = $namespace;
		}
			
		return $name;
	}
	
	/**
	 * @param int/null $extra
	 */
	private function indent($extra = 0) {
		
		$this->linefeed();
		
		for ($i=0; $i<$this->level; ++$i) $this->write($this->INDENT);
		
		for ($i=0; $i<$extra; ++$i) $this->write(' ');
	}
	
	/**
	 * @param int/null $count
	 */
	public function linefeed($count = 1) {
		
		for ($i=0; $i<$count; ++$i) {
			$this->write(PHP_EOL);
		}
	}
	
	private function indentAttribute() {
		
		if ($this->firstAttribute === true) {
			$this->firstAttribute = false;
		} else {
			$this->indent($this->tagLength+1);
		}
	}
	
	/**
	 * @param string $value
	 */
	private function replaceEntities($value) {
		
		if ((strpos($value, $this->base) !== false) && ($value !== $this->base)) {
		    $newValue = str_replace($this->base, '', $value);
		    if (strpos($newValue, '/') === false) {
		        return $newValue;
		    }
		}

		foreach ($this->entities as $entityName=>$entityValue) {
			if ((strpos($value, $entityValue) !== false)) {
				$value = str_replace($entityValue, '&'.$entityName.';', $value);
			}
		}
		return $value;
	}
	
	/**
	 * @param string $str
	 * @param boolean/null $quote
	 */
	private function sanitize($str, $quote = false) {

		$result = '';
		$str_chars = str_split($str);
		
		foreach ($str_chars as $c) {
			if ($c === '&') $result .= '&amp;';
			else if ($c === '<') $result .= "&lt;";
			else if ($c === '>') $result .= "&gt;";
			else if ($c === '\'') $result .= "&apos;";
			else if ($quote && $c === '"') $result .= '&quot;';
			else $result .= $c;
		}
		return $result;
	}
	
	/**
	 * @param string $data
	 */
	private function write($data) {
		
		$this->xmlString .= $data;
	}
	
	/**
	 * @param string $name
	 * @param string $value
	 */
	private function writeAttribute($name, $value) {
		
		$this->indentAttribute();
		$value = $this->sanitize($value, true);
		$value = $this->replaceEntities($value);
		$this->write(' '.$name.'="'.$value.'"');
	}
	
	private function writeNamespaces() {
		
		$additions = array();
		
		foreach ($this->nextNamespaces as $next) {
			foreach ($this->namespaces as $nsArray) {
				if (isset($nsArray[$next])) {
					$prefix = $nsArray[$next];
					break;
				}
			}
			$additions[$prefix] = $next;
		}
		
		$this->nextNamespaces = array();
		
		foreach ($additions as $prefix=>$ns) {
		    $this->_writtenPrefixes[] = $prefix;
			$this->writeAttribute('xmlns:'.$prefix, $ns);
		}
	}
	
	/**
	 * @param string $ns
	 * @param string $local
	 */
	private function writeQName($ns, $local = null) 
	{
	    if ($ns === 'xml:lang') {
	        $this->write($ns);
	        return;
	    } 
	    	
		if (null === $local) {
		    require_once 'Erfurt/Rdf/Resource.php';
		    $r = Erfurt_Rdf_Resource::initWithUri($ns);
		    $ns = $r->getNamespace();
		    $local = $r->getLocalName();
		}
	
		$tag = $local;
		
		if ($ns !== null) {
			$name = $this->getName($ns);

			if ($name !== '') $tag = $name . ':' . $local;
		} else {
		    if (substr($tag, 0, 7) !== 'http://' && strpos($tag, ':') !== false) {
		       $idx = strpos($tag, ':');
		       
		       $name = $this->getName(substr($tag, 0, $idx+1));
		       $local = substr($tag, $idx+1);
		       
		       if ($name !== '') $tag = $name . ':' . $local;
		    }
		}
		
		$this->write($tag);
		return $tag;
	}	
}
