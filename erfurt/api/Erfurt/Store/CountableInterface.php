<?php
/**
 * This interface provides methods, that a store that allows counting functionality has to implement.
 *
 * @package store
 * @author Philipp Frischmuth <philipp@frischmuth24.de>
 * @version $Id$
 */
interface Erfurt_Store_CountableInterface {
	
	/**
	 * This method counts all available models.
	 * 
	 * @return int Returns the number of available models.
	 */
	public function countAvailableModels();
	
	/**
	 * This method counts the number of values matching the parameters.
	 * 
	 * @param Model $model
	 * @param Resource $subject
	 * @param Resource $predicate
	 * @param boolean $distinct Whether only distinct values should be counted or not.
	 * @param boolean $r Whether resource values should be counted (uris).
	 * @param boolean $b Whether blank node values should be counted.
	 * @param boolean $l Whether literal values should be counted.
	 * @return int Returns the number (count) of matching values.
	 */
	public function executeCountValues(Model $model, Resource $subject = null, Resource $predicate = null, 
						$distinct = true, $r = true, $b = true, $l = true);
	
	/**
	 * This method counts the number of values matching the parameters. The subject of all matching statements need to
	 * have an additional rdf:type definition with $subjectType as value.
	 * 
	 * @param Model $model
	 * @param Resource $subjectType
	 * @param Resource $predicate
	 * @param boolean $distinct Whether only distinct values should be counted or not.
	 * @param boolean $r Whether resource values should be counted (uris).
	 * @param boolean $b Whether blank node values should be counted.
	 * @param boolean $l Whether literal values should be counted.
	 * @return int Returns the number (count) of matching values.
	 */
	public function executeCountValuesOnMatchingSubjectType(Model $model, Resource $subjectType, 
						Resource $predicate = null, $distinct = true, $r = true, $b = true, $l = true);
}
?>
