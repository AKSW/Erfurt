<?php
/**
 * Erfurt SParql Query2 - Nil
 * 
 * @package    ontowiki
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */

class Erfurt_Sparql_Query2_Nil implements Erfurt_Sparql_Query2_GraphTerm
{
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be "()"
     * @return string
     */
    public function getSparql(){
        return '()';
    }
}
?>
