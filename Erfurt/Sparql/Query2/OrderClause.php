<?php
/**
 * Erfurt_Sparql Query2 - OrderClause.
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_OrderClause
{
    protected $exps = array();
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * add
     * add an expression to this order clause - expresssion will mostly be a Var... but by the grammar this can be almost anything
     * @param Erfurt_Sparql_Query2_Expression $exp
     * @return int index of added element
     */
    public function add(Erfurt_Sparql_Query2_Expression $exp, $order = self::ASC) {
        if ($order != self::ASC && $order != self::DESC) {
            throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_OrderClause::add must be \'ASC\' or \'DESC\', '.$order.' (instance of '.typeHelper($order).') given');
        }
        
        $this->exps[] = array('exp'=>$exp, 'dir'=>$order);
        return count($this->exps)-1; //last index = index of added element
    }

    /**
     *
     */
    public function setExpressions($arr){
        $this->exps = array();
        foreach ($arr as $orderItem){
            if(isset($orderItem['exp']) && isset($orderItem['dir']) ){
                $this->add($orderItem['exp'], $orderItem['dir']);
            } else if($orderItem instanceof Erfurt_Sparql_Query2_Expression){
                $this->add($orderItem);
            }
        }
    }
    /**
     *
     */
    public function setExpression($item){
        $this->exps = array();
        if(is_array($item) && isset($item['exp']) && isset($item['dir']) ){
           $this->add($item['exp'], $item['dir']);
        } else if($item instanceof Erfurt_Sparql_Query2_Expression){
           $this->add($item);
        }

    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like 'ORDER BY ASC(?var)'
     * @return string
     */
    public function getSparql() {
        $sparql = 'ORDER BY';
        
        $countExps = count($this->exps);
        
        for ($i = 0; $i < $countExps; ++$i) {
            $sparql .=' '.$this->exps[$i]['dir'].'('.$this->exps[$i]['exp']->getSparql().')';
            if ($i < (count($this->exps)-1))
                $sparql .= ' ';
        }
        $sparql .= '';
        return $sparql;
    }

    public function __toString(){
        return $this->getSparql();
    }
    /**
     * toggleDirection
     * @param int $i index of element which direction should be toggled
     * @return Erfurt_Sparql_Query2_OrderClause $this
     */
    public function toggleDirection($i) {
        $this->exps[$i]['dir'] = $this->exps[$i]['dir']==self::ASC ? self::DESC : self::ASC;
        return $this; //for chaining
    }
    
    /**
     * setAsc
     * @param int $i index of element which direction should be set to ASC
     * @return Erfurt_Sparql_Query2_OrderClause $this
     */
    public function setAsc($i) {
        $this->exps[$i]['dir'] = self::ASC;
        return $this; //for chaining
    }
    
    /**
     * setDesc
     * @param int $i index of element which direction should be set to DESC
     * @return Erfurt_Sparql_Query2_OrderClause $this
     */
    public function setDesc($i) {
        $this->exps[$i]['dir'] = self::DESC;
        return $this; //for chaining
    }
    
    /**
     * used
     * @return bool true if any expressions are added
     */
    public function used() {
        return !empty($this->exps);
    }
    
    public function clear() {
        $this->exps = array();
        return $this; //for chaining
    }

    public function getExpressions() {
        return $this->exps;
    }
}


?>
