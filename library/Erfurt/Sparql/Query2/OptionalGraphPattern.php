<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * Erfurt_Sparql Query - OptionalGraphPattern.
 * 
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_Query2_OptionalGraphPattern extends Erfurt_Sparql_Query2_GroupGraphPattern 
{
    public function __construct($elements = array()) {
        parent::__construct($elements);
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like 'OPTIONAL {...}'
     * @return string
     */
     public function getSparql() {
        return 'OPTIONAL '.substr(parent::getSparql(),0,-1); //substr is cosmetic for stripping off the last linebreak 
    }
}
?>
