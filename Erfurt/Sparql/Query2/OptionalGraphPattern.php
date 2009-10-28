<?php
require_once 'GroupGraphPattern.php';

/**
 * Erfurt_Sparql Query - OptionalGraphPattern.
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_OptionalGraphPattern extends Erfurt_Sparql_Query2_GroupGraphPattern 
{
    public function __construct() {
        parent::__construct();
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
