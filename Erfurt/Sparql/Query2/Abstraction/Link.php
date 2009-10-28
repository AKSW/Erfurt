<?php
/**
 * OntoWiki
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: Link.php 3977 2009-08-09 14:38:37Z jonas.brekle@gmail.com $
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
