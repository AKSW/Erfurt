<?php
/*
 * StringWriterInterface.php
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
 * The base interface for a string writer implementation.
 *
 * @package syntax
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: StringWriterInterface.php 1010 2007-06-03 13:11:24Z p_frischmuth $
 */
interface Erfurt_Syntax_StringWriterInterface {
	
	public function startDocument();
	public function endDocument();
	
	/**
	 * @param string $name 
	 * @param string $value
	 */
	public function addEntity($name, $value);
	
	/**
	 * @param string $prefix 
	 * @param string $ns
	 */
	public function addNamespace($prefix, $ns);
	
	/**
	 * @param string $ns 
	 * @param string $local
	 */
	public function startElement($ns, $local);
	public function endElement();
	
	/**
	 * @param string $ns
	 * @param string $local
	 * @param string $value
	 */
	public function addAttribute($ns, $local, $value);
	
	/**
	 * @param string $comment
	 */
	public function writeComment($comment);
	
	/**
	 * @param string $data 
	 * @param boolean $raw
	 */
	public function writeData($data, $raw = false);
	
	/**
	 * @param string $base
	 */
	public function setBase($base);
	
	/**
	 * @param string $ns
	 * @param string $local
	 */
	public function setDoctype($ns, $local);

	/**
	 * @return string
	 */
	public function getContentString();
}
?>