<?php
/*
 * RDFStringWriterInterface.php
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
 * The base interface for a RDF string writer implementation.
 *
 * @package syntax
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: RDFStringWriterInterface.php 1010 2007-06-03 13:11:24Z p_frischmuth $
 */
interface Erfurt_Syntax_RDFStringWriterInterface {

	/**
	 * @param string $prefix A prefix, which should be used for the given namespace.
	 * @param string $ns The namespace, which should be prefixed.
	 */
	public function addNamespacePrefix($prefix, $ns);
	
	/**
	 * Serializes all triples that are not rendered yet.
	 *
	 * @param string/null $comment An optional comment.
	 */
	public function serializeAll($comment = null);
	
	/**
	 * @param Node $subject
	 */
	public function serializeSubject(Node $subject);
	
	/**
	 * @param Node[] $subject
	 * @param string $comment
	 */
	public function serializeSubjects($subjects, $comment = null);
	
	/**
	 * @param int $level
	 */
	public function setMaxLevel($level);
	
	/**
	 * Starts the document. All entities and prefix-definitions, that should exist in the whole document should be defined
	 * before!
	 */
	public function startDocument();
	
	/**
	 * Finishes the document.
	 */
	public function endDocument();
	
	/**
	 * Sets the base for the document.
	 *
	 * @param string $base
	 */
	public function setBase($base);
	
	/**
	 * @return string Returns a string representation of the document. This should be called after a endDocument()-call.
	 */ 
	public function getContentString();
}
?>