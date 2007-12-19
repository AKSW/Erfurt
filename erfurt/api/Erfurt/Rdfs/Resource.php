<?php
/**
 * TODO
 *
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @version $Id: $
 */
interface Erfurt_Rdfs_Resource {
	
	/**
	 * Adds a label to this resource
	 *
	 * @param $language
	 * @param $label
	 */
	public function addLabel($label, $language = '');
	
	public function definingModels();
	
	/**
	 * Checks if the resource equals another resource.
	 * Two resources are equal, if they have the same URI
	 *
	 * @param object resource $that
	 * @return	boolean
	 */
	public function equals($that);
	
	/**
	 * Returns an RDFSClass this instance is an instance of.
	 *
	 * @return RDFSClass A class this instance is an instrance of.
	 */
	public function getClass($class = null);
	
	public function getComment($language = null);
	
	public function getDefiningModel($includeSubClasses = false, $includeProperties = false, 
			$includeInstances = false);
	
	public function getLabel();
	
	/**
	 * Returns the label for a language. If no label is available
	 * for the language in this resource return null.
	 *
	 * @param string $language
	 * @return string The label attached to this resource or null.
	 */
	public function getLabelForLanguage($language = '');
	
	public function getLiteralPropertyValue($property, $language = null, $datatype = null);
	
	public function getLocalName();
	
	/**
	 * @deprecated ???!
	 */
	public function getLocalNameFast();
	
	/**
	 * This method retruns the model which the resource belongs to.
	 *
	 * @return Erfurt_Rdfs_Model Returns the model the resource belongs to.
	 */
	public function getModel();
	
	public function getPropertyValue($property, $class = null);
	
	public function getType();
	public function hasPropertyValue($property, $value = null);
	public function hasPropertyValueTransitive($property, $value);
	public function isBlankNode();
	public function isClass();
	public function isImported();
	
	/**
	 * Checks if this resource is of a specific type.
	 *
	 * @param RDFResource $type
	 * @return boolean
	 */
	public function isOfType($type);
	
	/**
	 * Returns an array of all classes for the given instance.
	 * Each class will be an RDFSClass.
	 *
	 * @return array Array of all classes for the given instance.
	 */
	public function listClasses();
	
	/**
	 * Returns an array of comments of this resource indexed by their language
	 *
	 * @return string comment of the resource
	 */
	public function listComments($language = null);
	
	/**
	 * Returns an array of Erfurt_Rdfs_Resources declared to be "owl:differentFrom"
	 * this resource.
	 *
	 * @return array An array of Erfurt_Rdfs_Resources.
	 **/
	public function listDifferentFrom();
	
	/**
	 * Returns the labels of this resource
	 *
	 * @return array of labels attached to this resource
	 */
	public function listLabels($language = null);
	
	/**
	 * TODO: Beschreibung
	 *
	 * @param string $prefix
	 * @param string $suffix
	 * @return array of labels attached to this resource
	 */
	public function listLabelsPlain($prefix = '', $suffix = '');
	
	/**
	 * Returns a list of nodes representing lists the resource is part of
	 *
	 * @return array List of nodes representing lists the resource is part of
	 */
	public function listLists();
	
	/**
	 * Returns literal property values of this resource and
	 * property $property which macht the given language and
	 * datatype (null matches arbitrary ones).
	 *
	 * @param Erfurt_Rdfs_Resource $property
	 * @param string $language
	 * @param string $datatype
	 * @return
	 */
	public function listLiteralPropertyValues($property, $language = null, $datatype = null);
	
	public function listLiteralPropertyValuesPlain($property, $language = null, $datatype = null);
	
	/**
	 * Returns an array of nodes (resources or literals) which are values
	 * of the property $property for this resource.
	 *
	 * @param Erfurt_Rdfs_Resource $property
	 * @param string $class The class which the values should be instances of.
	 * @return array An array of nodes which occur as property values.
	 */
	public function listPropertyValues($property = null, $class = null);
	
	public function listPropertyValuesObject($property, $class = null);
	public function listPropertyValuesRegEx($property = null, $class = null);
	public function listPropertyValuesSymmetric($property, $class = null);
	public function listPropertyValuesTransitive($property, $class = null, $done = array());
	
	/**
	 * Returns an array of Erfurt_Rdfs_Resources declared to be "owl:sameAs"
	 * this resource.
	 *
	 * TODO put into owl package
	 * 
	 * @return array An array of Erfurt_Rdfs_Resources.
	 */
	public function listSameAs();
	
	/**
	 * Removes this resource from the ontology by deleting any statements that
	 * refer to it. If this resource is a property, this method will not remove
	 * instances of the property from the model.
	 *
	 */
	public function remove();
	
	public function removePropertyValues($property);
	
	/**
	 * Removes the type of this resource.
	 *
	 * @param RDFResource $type
	 */
	public function removeType($type);
	
	/**
	 * Renames this resource.
	 *
	 * @param string $newuri New name URI for this resource
	 * @return boolean If $newuri is an existing URI return false, else rename this resource an return true
	 */
	public function rename($newuri, $checkIfNewuriExists = true);
	
	/**
	 * Sets this instance to be an instance of $class.
	 *
	 * @param RDFSClass $class The new RDFSClass for the instance.
	 *
	 * @return
	 */
	public function setClass($classes);
	
	/**
	 * Sets the comment for this resource
	 *
	 * @param $comment
	 */
	public function setComment($comment, $language = '');

	/**
	 * Declares the Erfurt_Rdfs_Resources in $values to be "owl:differentFrom" as
	 * this resource.
	 *
	 * @param array $values Array of Erfurt_Rdfs_Resources.
	 * @return
	 */
	public function setDifferentFrom($values);

	/**
	 * Sets the label of this resource in specified language
	 *
	 * @param $label
	 * @param $language
	 * @return
	 */
	public function setLabel($label, $language = null);
	
	/**
	 * Removes all property values of $property which do not have
	 * the value $value. If a property value with value $value does
	 * not already exist it will be added.
	 *
	 * @param Erfurt_Rdfs_Resource $property The property to be set.
	 * @param Node $value The value of the property.
	 */
	public function setPropertyValue($property, $value);
	
	/**
	 * Removes all property values of $property which do not have
	 * a value included in $values. If a value included in $values
	 * does not already exist (as property value) it will be added.
	 *
	 * @param Erfurt_Rdfs_Resource $property The property to be set.
	 * @param Node $value The value of the property.
	 * @param boolean $valuesAreLiterals
	 */
	public function setPropertyValues($property, $values = array(), $language = null, $datatype = null, $newLang = null,
	 		$newDtype = null);
	
	public function setPropertyValuesObject($property, $values = array());
	public function setPropertyValuesSymmetric($property, $values = array());
	
	/**
	 * Declares the Erfurt_Rdfs_Resources in $values to be "owl:sameAs" as this resource.
	 *
	 * @param array $values Array of Erfurt_Rdfs_Resources.
	 * @return
	 */
	public function setSameAs($values);
	
	/**
	 * Sets the type of this resource.
	 *
	 * @param RDFResource $type
	 */
	public function setType($type);
	
	/**
	 * Sets or unsets the type of this resource. If only one parameter is given
	 * the present type of this resource will be returned.
	 * 
	 * type() -> returns the rdf:type(s) for the resource
	 * type('someType') -> Returns whether the resource is of 'someType' rdf:type
	 * type('someType', true) -> sets the rdf:type of the resource to 'someType'
	 * type('someType), false) -> removes 'someType' as rdf:type for the resource
	 *
	 * @param Erfurt_Rdfs_Resource/null $type
	 * @param boolean/null $setType If is set to true the type will be set, else it will be unset.
	 * @return boolean/null
	 */
	public function type($type = null, $setType = null);
}
?>
