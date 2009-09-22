<?php
/**
 * Erfurt_Sparql Query2 - OrderClause.
 * 
 * @package    ontowiki
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_OrderClause
{
    protected $exps = array();
    
    /**
     * add
     * add an expression to this order clause - expresssion will mostly be a Var... but by the grammar this can be almost anything
     * @param Erfurt_Sparql_Query2_Expression $exp
     * @return int index of added element
     */
    public function add(Erfurt_Sparql_Query2_Expression $exp, $order = 'ASC'){
        if($order != 'ASC' && $order != 'DESC'){
            throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_OrderClause::add must be \'ASC\' or \'DESC\', '.$order.' (instance of '.typeHelper($order).') given');
        }
        
        $this->exps[] = array('exp'=>$exp, 'dir'=>$order);
        return count($this->exps)-1; //last index = index of added element
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like 'ORDER BY ASC(?var)'
     * @return string
     */
    public function getSparql(){
        $sparql = 'ORDER BY';
        for ($i = 0; $i < count($this->exps); $i++){
            $sparql .=' '.$this->exps[$i]['dir'].'('.$this->exps[$i]['exp']->getSparql().')';
            if($i < (count($this->exps)-1))
                $sparql .= ', ';
        }
        $sparql .= '';
        return $sparql;
    }
    
    /**
     * toggleDirection
     * @param int $i index of element which direction should be toggled
     * @return Erfurt_Sparql_Query2_OrderClause $this
     */
    public function toggleDirection($i){
        $this->exps[$i]['dir'] = $this->exps[$i]['dir']=='ASC'?'DESC':'ASC';
        return $this; //for chaining
    }
    
    /**
     * setAsc
     * @param int $i index of element which direction should be set to ASC
     * @return Erfurt_Sparql_Query2_OrderClause $this
     */
    public function setAsc($i){
        $this->exps[$i]['dir'] = 'ASC';
        return $this; //for chaining
    }
    
    /**
     * setDesc
     * @param int $i index of element which direction should be set to DESC
     * @return Erfurt_Sparql_Query2_OrderClause $this
     */
    public function setDesc($i){
        $this->exps[$i]['dir'] = 'DESC';
        return $this; //for chaining
    }
    
    /**
     * used
     * @return bool true if any expressions are added
     */
    public function used(){
        return !empty($this->exps);
    }
    
    public function clear(){
    	$this->exps = array();
    	return $this; //for chaining
    }
}


?>
