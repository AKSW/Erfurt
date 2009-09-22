<?php
/**
 * Erfurt Sparql Query2 - NumericLiteral
 * 
 * represents numeric literals - does not do a lot because php's numeric literals are pretty much the same
 * 
 * @package    ontowiki
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_NumericLiteral implements Erfurt_Sparql_Query2_GraphTerm, Erfurt_Sparql_Query2_PrimaryExpression
{
    protected $value;
    
    /**
     * @param numeric $num
     */
    public function __construct ($num){
        if(is_numeric($num)){
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
    public function getSparql(){
        return (string) $this->value;
    }
    public function __toString(){    
        return $this->getSparql();
    }
}
?>
