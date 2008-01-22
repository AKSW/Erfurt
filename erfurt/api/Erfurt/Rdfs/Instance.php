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
interface Erfurt_Rdfs_Instance extends Erfurt_Rdfs_Resource {
	
	/**
	 * TODO update doc 
	 * 
	 * Adds a value for a property. RDFSProperties might have
	 * more than one value.
	 *
	 * @param RDFSProperty $prop The property the value should be added to.
	 * @param $value Value for the property
	 * @trigger test trigger
	 */
	public function addPropertyValue($prop, $value);
	
	/**
	 * This method returns a string representation of the value that belongs to the first matching statement, which
	 * has the uri of this instance as subject and the uri of the given property as predicate. In case the object is a
	 * resource, the resource uri is returned, in case it is a literal, the literal value is returned (as string).
	 * In case that no matching statement is found, an empty string is returned.
	 * 
	 * @param Resource/string $prop The property that matching statements have as predicate.
	 * @return string Returns a string representation of the value of the first matching statement.
	 */
	public function getPropertyValuePlain($prop);
	
	/**
	 * TODO
	 */
	public function listAllPropertyValuesPlain();
	
	/**
	 * This method returns an array of all properties that have at least one of the classes this instance belongs to as
	 * rdfs:domain.
	 *
	 * @return Erfurt_Rdfs_Property[] Returns an array containg the properties.
	 */
	public function listProperties();
	
	/**
	 * This method returns a list of string representations of all values that match the (optional) given parameter.
	 * In case the object is a resource, the local name is returned, in case it is a literal, the literal value is
	 * returned (as string). In case that no matching statement is found, an empty array is returned.
	 *
	 * @param Resource/string $prop (default: '') An optional Resource object or resource uri in order to adapt the 
	 * result.
	 * @return string[] Returns a list containing a string representation of each value.
	 */
	public function listPropertyValuesPlain($prop = '');
	
	/**
	 * TODO update doc
	 * 
	 * Removes all property values of the given property.
	 *
	 * @param RDFSProperty $prop
	 * @param mixed $value
	 */
	public function removePropertyValues($prop, $value = '');
	
	/**
	 * TODO
	 */
	public function setPropertyValue($prop,$value);
	
	
}
?>