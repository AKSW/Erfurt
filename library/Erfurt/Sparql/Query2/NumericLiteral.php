<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt Sparql Query2 - NumericLiteral
 * 
 * represents numeric literals - does not do a lot because php's numeric literals are pretty much the same
 * 
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Sparql_Query2_NumericLiteral extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_GraphTerm, Erfurt_Sparql_Query2_PrimaryExpression
{
    protected $value;
    
    /**
     * @param numeric $num
     */
    public function __construct ($num) {
        if (is_numeric($num)) {
            $this->value = $num;
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_NumericLiteral::__construct must be numeric, instance of '.typeHelper($num).' given');
        }
    }
    
    //TODO test this, looks too easy... 
    /**
     * getSparql
     * build a valid sparql representation of this obj
     * @return string
     */
    public function getSparql() {
        return (string) $this->value;
    }
    public function __toString() {    
        return $this->getSparql();
    }

        /**
     * setValue
     * @param string $val
     * @return Erfurt_Sparql_Query2_NumricLiteral $this
     */
    public function setValue($val) {
        if (is_numeric($val)) {
            $this->value = $val;
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_NumericLiteral::setValue must be numeric, instance of '.typeHelper($val).' given');
        }
        return $this;
    }

    /**
     * getValue
     * @return string the value of the literal
     */
    public function getValue() {
        return $this->value;
    }
}
?>
