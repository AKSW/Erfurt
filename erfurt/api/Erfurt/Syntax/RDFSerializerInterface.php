<?php
/*
 * RDFSerializerInterface.php
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
 * This is the base interface for a RDF serializer implementation.
 * 
 * @package syntax
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 */
interface Erfurt_Syntax_RDFSerializerInterface {
	
	/**
	 * This function takes a model and a string writer and serializes the given model in the given syntax (syntax
	 * is given through the string writer).
	 *
	 * @param Erfurt_Syntax_StringWriterInterface $stringWriter An instance of a string writer (e.g. an xml string
	 * writer).
	 * @param Model $model The model, which should be serialized.
	 * @return string Returns a string containing a rdf serialization of the given model.
	 */
	public function serializeToString(Erfurt_Syntax_StringWriterInterface $stringWriter, Model $model);
	
	/**
	 * This function takes a model and a string writer and serializes the given model in the given syntax (syntax
	 * is given through the string writer). The result is written in the file represented by the given filename.
	 *
	 * @param Erfurt_Syntax_StringWriterInterface $stringWriter An instance of a string writer (e.g. an xml string
	 * writer).
	 * @param Model $model The model, which should be serialized.
	 * @param string $filename A string containing the full path to the file.
	 */
	public function serializeToFile(Erfurt_Syntax_StringWriterInterface $stringWriter, Model $model, $filename);
}
?>