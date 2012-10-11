<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt Sparql Query - A
 *
 * an object that does nothing else then behaving like a "Verb" (see sparql grammar) and printing an "a"
 *
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
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
