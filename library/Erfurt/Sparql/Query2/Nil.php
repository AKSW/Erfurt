<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt SParql Query2 - Nil
 * 
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
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
