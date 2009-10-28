<?php
/**
 * Erfurt Sparql Query - A
 * 
 * an object that does nothing else then behaving like a "Verb" (see sparql grammar) and printing an "a"
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: A.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
class Erfurt_Sparql_Query2_A implements Erfurt_Sparql_Query2_Verb {
    /**
     * getSparql
     * build a valid sparql representation of this obj - is "a"
     * @return string
     */
    public function getSparql() {
        return 'a';
    }
    
    public function __toString() 
    {    
        return $this->getSparql();
    }
}
?>
