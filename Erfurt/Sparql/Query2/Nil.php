<?php
/**
 * OntoWiki
 * 
 * @package    
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */

class Erfurt_Sparql_Query2_Nil implements Erfurt_Sparql_Query2_GraphTerm
{
	public function getSparql(){
		return "()";
	}
}
?>
