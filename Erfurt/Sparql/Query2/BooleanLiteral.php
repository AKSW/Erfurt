<?php
/**
 * OntoWiki Sparql Query - BooleanLiteral
 * 
 * represent "true" and "false"
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: BooleanLiteral.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
class Erfurt_Sparql_Query2_BooleanLiteral extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_GraphTerm, Erfurt_Sparql_Query2_PrimaryExpression
{

    protected $value;
    
    /**
     * @param bool $bool
     */
    public function __construct($bool) {
        if (is_bool($bool)) {
            $this->value = $bool;
        } else {
            throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_BooleanLiteral::__construct must be boolean, instance of '.typeHelper($bool).' given");
        }
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be 'true' or 'false'
     * @return string
     */
    public function getSparql() {
        return $this->value ? 'true' : 'false';
    }
    
    public function __toString() {    
        return $this->getSparql();
    }
}
?>
