<?php
/**
 * This interface provides methods that a property implementation has to provide in order to be used with Erfurt.
 * Applications that use the Erfurt API should test against this interface.
 *
 * @package rdfs
 * @author Sören Auer <soeren@auer.cx>
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @copyright Copyright (c) 2004-2007
 * @version $Id$
 */
interface Erfurt_Rdfs_Property extends Erfurt_Rdfs_Resource {

	/**
	 * Adds the class in $classes or the array of classes in $classes as domain for this property.
	 *
	 * @param RDFSClass/RDFSClass[] $classes RDFSClass or array of classes to add as domain.
	 */
	public function addDomain($classes);
	
	/**
	 * This method adds the given class or a given array of classes as range for this proerty (rdfs:range).
	 *
	 * @param RDFSClass/RDFSClass[] $ranges RDFSClass or array of classes to add as range.
	 */
	public function addRange($ranges);
	
	/**
	 * Add a sub-property of this property. If the sub-property is a URI instead
	 * of a RDFSProperty object, the RDFSProperty will be created first.
	 *
	 * @param RDFSProperty/string $property A property, which should be added as a sub-property of the property.
	 * @return RDFSProperty Returns the property added itself.
	 */
	public function addSubProperty($property);

	/**
	 * 	This method counts the values (object) for the property. If a existing class is given, it counts the property
	 * values of all instances of the class. If a non existing class is given, this method counts all values of all
	 * statements that have a subject that is a owl:DatatypeProperty itself (This will be put into the owl package
	 * as soon as possible).
	 * 
	 * @param $class/null An existing class in order to return count of the values for instances of this class, or a non
	 * existing class in order to return the number of all values that have a subject that is a owl:DatatypeProperty.
	 * @param boolean $resourcesOnly (default = true) Whether to count resource values only or not.
	 * @param int $minDistinctValues (default = 0) A minimum number of distinct values. Only uses when an existing class
	 * is given.
	 * @return int Returns the number of values of matching statements.
	 * @throws Erfurt_Exception
	 */
	public function countDistinctPropertyValues($class = null, $resourcesOnly = true, $minDistinctValues = 0);

	/**
	 * This method returns the first rdfs:domain value, i.e. the domain for this property.
	 * 
	 * @return RDFSClass Returns a RDFSClass object.
	 */
	public function getDomain();
	
	/**
	 * This method returns the first rdfs:range value, i.e. the range for this property.
	 * 
	 * @return RDFSClass Returns a RDFSClass object.
	 */
	public function getRange();
	
	/**
	 * This method lists the values (object) for the property. If a existing class is given, it lists the property
	 * values of all instances of the class. If a non existing class is given, this method lists all values of all
	 * statements that have a subject that is a owl:DatatypeProperty itself (This will be put into the owl package
	 * as soon as possible).
	 * 
	 * @param $class/null An existing class in order to return values for instances of this class, or a non
	 * existing class in order to return all values that have a subject that is a owl:DatatypeProperty.
	 * @param boolean $resourcesOnly (default = true) Whether to return resource values only or not.
	 * @param int $start (default = 0) NOT USED YET.
	 * @param int $count (default = 0) NOT USED YET.
	 * @param $erg (default = 0) NOT USED YET.
	 * @return Node[] Returns an array containing all matching object values.
	 */
	public function listDistinctPropertyValues($class = null, $resourcesOnly = true, $start = 0, $count = 0, $erg = 0);
	
	/**
	 * This method lists all values for the rdfs:domain property.
	 *
	 * @return RDFSClass[] Returns an array containing RDFSClass objects.
	 */
	public function listDomain();
	
	/**
	 * This method returns all classes that are defined as rdfs:domain for this property.
	 * If no range is defined for this property, this method checks all super properties (recursivly) and returns the
	 * range of the first super-property, that has at least one range defined. If no parent has a range, an empty
	 * array is returned.
	 *
	 * @return RDFSClass[] Returns an array containing RDFSClass objects.
	 */
	public function listRange();
	
	/**
	 * This method returns a list containing all direct sub-properties (rdfs:subPropertyOf) for this property or an
	 * empty array if no sub-property exists.
	 *
	 * @return array Array of RDFSProperty properties
	 */
	public function listSubProperties();
	
	/**
	 * This method returns a list containing all direct super-properties (rdfs:subPropertyOf) for this property or an
	 * empty array if no super-property exists.
	 *
	 * @return RDFSProperty[] Returns an array of RDFSProperty objects.
	 */
	public function listSuperProperties();
	
	/**
	 * Removes the given class as the domain of the property or removes all classes as property iff no class is given.
	 *
	 * @param RDFSClass/null $class RDFSClass to remove as domain or null in order to remove all domains.
	 */
	public function removeDomain(RDFSClass $class = null);
	
	/**
	 * Removes the  given class ad range of the property or removes all classes as property iff no class is given.
	 *
	 * @param RDFSClass/null $range RDFSClass to remove as range or null in order to remove all ranges.
	 */
	public function removeRange(RDFSClass $range = null);
	
	/**
	 * Removes all current classes from the domain of the property
	 * and adds the class in $classes or the classes in $classes (iff $classes is an array) to the domain of the
	 * property.
	 *
	 * @param RDFSClass/array $classes RDFSClass or array of classes to add as domain.
	 */
	public function setDomain($classes);
	
	/**
	 * This method removes all current ranges for the property and adds the given array of classes as range for the
	 * property (rdfs:range).
	 *
	 * @param RDFSClass[] $ranges The new ranges for the property.
	 */
	public function setRange($ranges);
	
	/**
	 * This method takes an array containing properties, which should be set as sub-properties of the property
	 * (rdfs:subPropertyOf).
	 *
	 * @param Erfurt_Rdfs_Property[] Takes an array containing the properties to be set as sub-properties.
	 */
	public function setSubProperties($values);
	
	/**
	 * 	This method takes an array containing properties, which should be set as super-properties of the property
	 * (rdfs:subPropertyOf).
	 *
	 * @param Erfurt_Rdfs_Property[] Takes an array containing the properties to be set as super-properties.
	 */
	public function setSuperProperties($values);
}
?>
