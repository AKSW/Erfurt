<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @package    Erfurt_Sparql_Query2_Abstraction
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_Query2_Abstraction_Link
{
	protected $predicate;
	protected $target;
	
	public function __construct($predicate, Erfurt_Sparql_Query2_Abstraction_ClassNode $target){
		$this->predicate = $predicate;
		$this->target = $target;
	}
}

?>
