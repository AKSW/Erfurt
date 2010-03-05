<?php
/**
 * Erfurt SParql Query2 - Nil
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: Nil.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */

class Erfurt_Sparql_Query2_Nil implements Erfurt_Sparql_Query2_GraphTerm
{
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be "()"
     * @return string
     */
    public function getSparql() {
        return '()';
    }

    public function __toString(){
        return $this->getSparql();
    }

}
?>
