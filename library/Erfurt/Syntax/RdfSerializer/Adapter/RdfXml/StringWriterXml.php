<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

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
 * @package Erfurt_Syntax_RdfSerializer_Adapter_RdfXml
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Erfurt_Syntax_RdfSerializer_Adapter_RdfXml_StringWriterXml
{

    /**
     * @var string
     */
    private $_indent = '  ';

    /**
     * @var string
     */
    private $_nsPrefix = 'ns';

    /**
     * @var string
     */
    private $_cEncoding;

    /**
     * @var string
     */
    private $_base;

    /**
     * @var array (used as stack)
     */
    private $_bases;

    /**
     * @var boolean
     */
    private $_dataWritten;

    /**
     * @var string
     */
    private $_doctypeNs;

    /**
     * @var string
     */
    private $_doctypeLocal;

    /**
     * @var array (associative)
     */
    private $_entities;

    /**
     * @var boolean
     */
    private $_firstAttribute;

    /**
     * @var boolean
     */
    private $_inTag;

    /**
     * @var int
     */
    private $_level;

    /**
     * @var array[][] (first dimension as stack, second as an associative array)
     */
    private $_namespaces;

    /**
     * @var array (indexed)
     */
    private $_nextNamespaces;

    /**
     * @var int
     */
    private $_tagLength;

    /**
     * @var array (used as stack)
     */
    private $_tags;

    /**
     * @var boolean
     */
    private $_wasEmpty;

    /**
     * @var boolean
     */
    private $_wasComment;

    /**
     * @var string
     */
    private $_xmlString;

    protected $_ad = null;

    /**
     * @param string/null $encoding
     */
    public function __construct($encoding = null)
    {
        if ($encoding !== null) $this->_cEncoding = $encoding;
        else $this->_cEncoding = 'UTF-8';

        $this->resetState();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getContentString();
    }

    public function setAd($ad)
    {
        $this->_ad = $ad;
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function startDocument()
    {
        $this->write('<?xml version="1.0" encoding="' . $this->_cEncoding . '" ?>');

        if (null !== $this->_ad) {
            $this->writeComment($this->_ad);
        }

        $this->linefeed(2);

        // write entity definitions iff at least one is set
        if (count($this->_entities) > 0) {
            $this->write('<!DOCTYPE ' . $this->getDoctype() . ' [' . PHP_EOL);

            foreach ($this->_entities as $name=>$value) {
                $this->write($this->_indent.'<!ENTITY '.$name.' "'.$this->sanitize($value, true).'">'.PHP_EOL);
            }

            $this->write(']>' . PHP_EOL);
        }
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function endDocument()
    {
        // close all open tags except from the root element
        while (!(count($this->_tags) === 1)) {
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
    public function addEntity($name, $value)
    {
        if (($name !== null) && ($value !== null) && ($value !== '')) {
            $this->_entities[$name] = $value;
        }
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function addNamespace($prefix, $ns)
    {
        $topNamespaces = array_pop($this->_namespaces);
        $topNamespaces[$ns] = $prefix;
        array_push($this->_namespaces, $topNamespaces);

        $this->_nextNamespaces[] = $ns;
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function startElement($ns, $local = null)
    {
        if ($this->_inTag === true) {
            $this->finishTag(false);
        } else if (($this->_wasComment === false) && ($this->_level < 2)) {
            $this->linefeed();
        }
        if ($this->_wasComment === true) {
            $this->_wasComment = false;
        }

        if (count($this->_tags) > 0) array_push($this->_namespaces, array());

        $this->indent();

        $this->write('<');
        $tag = $this->writeQName($ns, $local);
        $tagLength = strlen($tag);
        array_push($this->_tags, array($ns, $local));
        $this->_inTag = true;
        $this->_firstAttribute = true;

        if ((($this->_base !== null) && (count($this->_bases) === 0)) || ($this->_base !== end($this->_bases))) {
            $this->writeAttribute('xml:base', $this->_base);
        }
        array_push($this->_bases, $this->_base);
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function endElement()
    {
        if ($this->_inTag === true) {
            $this->finishTag(true);
            array_pop($this->_tags);
            $this->_level--;
            $this->_wasEmpty = true;
        } else {
            $this->_level--;

            if ($this->_dataWritten === true) {
                $this->_dataWritten = false;
            } else {
                $this->indent();
            }

            $tag = array_pop($this->_tags);

            $this->write('</');
            $this->writeQName($tag[0], $tag[1]);
            $this->write('>');
            $this->_wasEmpty = false;
        }

        array_pop($this->_namespaces);
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function addAttribute($ns, $local, $value)
    {
        $this->indentAttribute();
        $this->write(' ');
        $this->writeQName($ns, $local);
        $this->write('="' . $this->replaceEntities($this->sanitize($value, true)) . '"');
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function writeComment($comment = null)
    {
        if (null === $comment) {
            $this->write(PHP_EOL.PHP_EOL);
            return;
        }

        if ($this->_inTag === true) {
            $this->finishTag(false);
        }

        $this->write(PHP_EOL.PHP_EOL.'<!-- '.$this->sanitize($comment).' -->');
        $this->_wasComment = true;
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function writeData($data, $raw = false)
    {
        if ($this->_inTag === true) {
            $this->finishTag(false);
        }

        if ($raw) {
            $this->write($data);
        } else {
            $this->write($this->sanitize($data));
        }

        $this->_dataWritten = true;
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function setBase($base)
    {
        $this->_base = $base;
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function setDoctype($ns, $local)
    {
        $this->_doctypeNs = $ns;
        $this->_doctypeLocal = $local;
    }

    /**
     * @see Erfurt_Syntax_StringWriterInterface
     */
    public function getContentString()
    {
        return $this->_xmlString;
    }

    private function resetState()
    {
        $this->_base                     = null;
        $this->_bases                    = array();
        $this->_dataWritten              = false;
        $this->_entities                 = array();
        $this->_firstAttribute           = false;
        $this->_inTag                    = false;
        $this->_level                    = 0;
        $this->_namespaces               = array();
        $this->_nextNamespaces           = array();
        $this->_tagLength                = 0;
        $this->_tags                     = array();
        $this->_wasEmpty                 = true;
        $this->_wasComment               = false;
        $this->_xmlString                = '';
    }

    /**
     * @param boolean $isEmpty
     */
    private function finishTag($isEmpty)
    {
        $this->writeNamespaces();

        if ($isEmpty === true) $this->write(' />');
        else $this->write('>');

        if ($this->_level === 0) {
            $this->linefeed();
        }

        $this->_inTag = false;
        $this->_level++;
    }

    /**
     * @return string
     */
    private function getDoctype()
    {
        if (($this->_doctypeNs !== null) && ($this->_doctypeLocal !== null)) {
            return $this->getName($this->_doctypeNs) . ':' . $this->_doctypeLocal;
        } else return '';
    }

    /**
     * @param string $namespace
     * @return string
     */
    private function getName($namespace)
    {
        $name = null;
        foreach ($this->_namespaces as $nsArray) {
            if (isset($nsArray[$namespace])) {
                $name = $nsArray[$namespace];
                break;
            }
        }

        if ($name === null) {
            $i = 0;

            while (true) {
                $contains = false;
                foreach ($this->_namespaces as $nsArray) {
                    foreach ($nsArray as $ns=>$prefix) {
                        if ($prefix === ($this->_nsPrefix.$i)) {
                            $i++;
                            $contains = true;
                            break;
                        }
                    }
                    if ($contains === true) break;
                }
                if ($contains === false) break;
            }

            $name = $this->_nsPrefix . $i;
            $topNamespaces = array_pop($this->_namespaces);
            $topNamespaces[$namespace] = $name;
            array_push($this->_namespaces, $topNamespaces);
            $this->_nextNamespaces[] = $namespace;
        }

        return $name;
    }

    /**
     * @param int/null $extra
     */
    private function indent($extra = 0)
    {
        $this->linefeed();

        for ($i=0; $i<$this->_level; ++$i) $this->write($this->_indent);

        for ($i=0; $i<$extra; ++$i) $this->write(' ');
    }

    /**
     * @param int/null $count
     */
    public function linefeed($count = 1)
    {
        for ($i=0; $i<$count; ++$i) {
            $this->write(PHP_EOL);
        }
    }

    private function indentAttribute()
    {
        if ($this->_firstAttribute === true) {
            $this->_firstAttribute = false;
        } else {
            $this->indent($this->_tagLength+1);
        }
    }

    /**
     * @param string $value
     */
    private function replaceEntities($value)
    {
        if ((strpos($value, $this->_base) !== false) && ($value !== $this->_base)) {
            $newValue = str_replace($this->_base, '', $value);
            if (strpos($newValue, '/') === false) {
                return $newValue;
            }
        }

        foreach ($this->_entities as $entityName=>$entityValue) {
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
    private function sanitize($str, $quote = false)
    {
        $result = '';
        $strChars = str_split($str);

        foreach ($strChars as $c) {
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
    private function write($data)
    {
        $this->_xmlString .= $data;
    }

    /**
     * @param string $name
     * @param string $value
     */
    private function writeAttribute($name, $value)
    {
        $this->indentAttribute();
        $value = $this->sanitize($value, true);
        $value = $this->replaceEntities($value);
        $this->write(' '.$name.'="'.$value.'"');
    }

    private function writeNamespaces()
    {
        $additions = array();

        foreach ($this->_nextNamespaces as $next) {
            foreach ($this->_namespaces as $nsArray) {
                if (isset($nsArray[$next])) {
                    $prefix = $nsArray[$next];
                    break;
                }
            }
            $additions[$prefix] = $next;
        }

        $this->_nextNamespaces = array();

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
