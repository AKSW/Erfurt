<?php
require_once 'structural-Interfaces.php';

/**
 * Erfurt_Sparql Query - Triple.
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_Triple extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_IF_TriplesSameSubject
{
    protected $s;
    protected $p;
    protected $o;
    
    /**
     * @param Erfurt_Sparql_Query2_VarOrTerm $s
     * @param Erfurt_Sparql_Query2_Verb $p
     * @param Erfurt_Sparql_Query2_IF_ObjectList $o
     */
    public function __construct(Erfurt_Sparql_Query2_VarOrTerm $s, Erfurt_Sparql_Query2_Verb $p, Erfurt_Sparql_Query2_IF_ObjectList $o) {
        $this->s=$s;
        $this->p=$p;
        $this->o=$o;
        parent::__construct();
    }
    
    /**
     * setS
     * set the subject (the first element of this triple)
     * @param Erfurt_Sparql_Query2_VarOrTerm $s
     * @return Erfurt_Sparql_Query2_Triple $this
     */
    public function setS(Erfurt_Sparql_Query2_VarOrTerm $s) {
        $this->s=$s;
        return $this; //for chaining
    }
    
    /**
     * setP
     * set the predicate (the second element of this triple)
     * @param Erfurt_Sparql_Query2_Verb $p
     * @return Erfurt_Sparql_Query2_Triple $this
     */
    public function setP(Erfurt_Sparql_Query2_Verb $p) {
        $this->p=$p;
        return $this; //for chaining
    }
    
    /**
     * setO
     * set the object (the third element of this triple)
     * @param Erfurt_Sparql_Query2_IF_ObjectList $o
     * @return Erfurt_Sparql_Query2_Triple $this
     */
    public function setO(Erfurt_Sparql_Query2_IF_ObjectList $o) {
        $this->o=$o;
        return $this; //for chaining
    }
    
    /**
     * getS
     * get the subject (the first element of this triple)
     * @return Erfurt_Sparql_Query2_VarOrTerm
     */
    public function getS() {
        return $this->s;
    }
    
    /**
     * getP
     * get the predicate (the second element of this triple)
     * @return Erfurt_Sparql_Query2_Verb
     */
    public function getP() {
        return $this->p;
    }
    
    /**
     * getO
     * get the object (the third element of this triple)
     * @return Erfurt_Sparql_Query2_IF_ObjectList
     */
    public function getO() {
        return $this->o;
    }
       
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "?s ?p ?o"
     * @return string
     */
    public function getSparql() {
        return $this->s->getSparql().' '.$this->p->getSparql().' '.$this->o->getSparql();
    }
    
    /**
     * getVars
     * get all vars used in this pattern (recursive)
     * @return array array of Erfurt_Sparql_Query2_Var
     */
    public function getVars() {
        $vars = array();
        
        if ($this->s instanceof Erfurt_Sparql_Query2_Var) {
            $vars[] = $this->s;
        }
        if ($this->p instanceof Erfurt_Sparql_Query2_Var) {
            $vars[] = $this->p;
        }
        if ($this->o instanceof Erfurt_Sparql_Query2_Var) {
            $vars[] = $this->o;
        }
        
        return $vars;
    }

    public function getWeight($part = null){
        if($part == null){
            return ($this->s instanceof Erfurt_Sparql_Query2_Var ? 1 : 0) +
            ($this->p instanceof Erfurt_Sparql_Query2_Var ? 1 : 0) +
            ($this->o instanceof Erfurt_Sparql_Query2_ObjectList ?
                $this->o->getNumVars() :
                ($this->o instanceof Erfurt_Sparql_Query2_Var ?
                    1 :
                    0
                )
            );
        } else {
            switch($part){
                case 0:
                    return ($this->s instanceof Erfurt_Sparql_Query2_Var ? 1 : 0);
                    break;
                case 1:
                    return ($this->p instanceof Erfurt_Sparql_Query2_Var ? 1 : 0);
                    break;
                case 2:
                    if($this->o instanceof Erfurt_Sparql_Query2_ObjectList){
                        return $this->o->getNumVars();
                    } else if($this->o instanceof Erfurt_Sparql_Query2_Var){
                        return 1;
                    } else {
                        return 0;
                    }
                    break;
            }
        }
    }
}
?>
