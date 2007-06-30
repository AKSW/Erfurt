<?php
/*
 * RDFSerializer.php
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
 * An implementation of a RDF serializer, which sorts the output by categories, so it is more readable for humans.
 *
 * @package syntax
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2007
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: RDFSerializer.php 1010 2007-06-03 13:11:24Z p_frischmuth $
 */
class Erfurt_Syntax_RDFSerializer implements Erfurt_Syntax_RDFSerializerInterface {
	
	/**
	 * @var Model
	 */
	private $model;
	
	/**
	 * @var Erfurt_Syntax_RDFStringWriterInterface
	 */
	private $rdfWriter;
	
	/**
	 * @var string
	 */
	private $base;
		
	/**
	 * @see Erfurt_Syntax_RDFSerializerInterface
	 */
	public function serializeToString(Erfurt_Syntax_StringWriterInterface $stringWriter, Model $model) {
		
		$this->model = $model;
		$this->base = $model->getBaseURI();
		
		// check whether a MemModel or a DbModel is given; Erfurt_Syntax_RDFStringWriterImpl always needs a MemModel
		if ($model instanceof DbModel) {
			$this->rdfWriter = new Erfurt_Syntax_RDFStringWriterImpl($stringWriter, $model->getMemModel());
		} else {
			$this->rdfWriter = new Erfurt_Syntax_RDFStringWriterImpl($stringWriter, $model);
		}
		
		if ($this->base !== null) $this->rdfWriter->setBase($this->base);
		
		$prefixes = $this->model->getParsedNamespaces();
		foreach ($prefixes as $ns=>$p) $this->rdfWriter->addNamespacePrefix($p, $ns);

		$this->rdfWriter->startDocument();
		$this->rdfWriter->setMaxLevel(10);
		$this->serializeType('ontology specific information', EF_OWL_ONTOLOGY);
		$this->rdfWriter->setMaxLevel(1);
		$this->serializeType('classes', EF_OWL_CLASS);
		$this->serializeType('datatypes', EF_RDFS_DATATYPE);
		$this->serializeType('annotaition properties', EF_OWL_ANNOTATION_PROPERTY);
		$this->serializeType('datatype properties', EF_OWL_DATATYPE_PROPERTY);
		$this->serializeType('object properties', EF_OWL_OBJECT_PROPERTY);
		$this->rdfWriter->serializeAll('instances and untyped data');
		$this->rdfWriter->endDocument();
		
		return $this->rdfWriter->getContentString();
	}
	
	/**
	 * @see Erfurt_Syntax_RDFSerializerInterface
	 */
	public function serializeToFile(Erfurt_Syntax_StringWriterInterface $stringWriter, Model $model, $filename) {
// TODO test this function		
		$rdf = $this->serializeToString($stringWriter, $model);
		
		$fileHandle = fopen($filename, 'w');
		fwrite($fileHandle, $rdf);
		fclose($fileHandle);
	}
	
	/**
	 * Internal function, which takes a type and a description and serializes all statements of this type in a section.
	 *
	 * @param string $description A description for the given class of statements (e.g. owl:Class).
	 * @param string $class The type which to serialize (e.g. owl:Class).
	 */
	private function serializeType($description, $class) {
		
		$subjects = array();
		$started = false;
		
		$typeModel = $this->model->find(null, new Resource(EF_RDF_TYPE), new Resource($class));
		
		foreach ($typeModel->triples as $s) $subjects[] = $s->getSubject();
		
		$this->rdfWriter->serializeSubjects($subjects, $description);
	}
}
?>