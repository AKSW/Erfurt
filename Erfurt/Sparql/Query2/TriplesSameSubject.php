<?php
/**
 * Erfurt Sparql Query2 - TriplesSameSubject
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: TriplesSameSubject.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */

class Erfurt_Sparql_Query2_TriplesSameSubject extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_IF_TriplesSameSubject
{
    protected $subject;
    protected $propertyList;
    
    /**
     * @param Erfurt_Sparql_Query2_VarOrTerm $subject
     * @param array $propList array of (Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList)-pairs
     */
    public function __construct($subject, Erfurt_Sparql_Query2_PropertyList $propList) {
        if(!($subject instanceof Erfurt_Sparql_Query2_VarOrTerm) && !($subject instanceof Erfurt_Sparql_Query2_TriplesNode)){
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_TriplesSameSubject::__construct must be instance of Erfurt_Sparql_Query2_VarOrTerm or Erfurt_Sparql_Query2_TriplesNode', E_USER_ERROR);
        }
        $this->subject = $subject;
        $this->propertyList = $propList;
        
        parent::__construct();
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj
     * @return string
     */
    public function getSparql() {
        $propList = '';
                
        return $this->subject->getSparql().' '.$this->propertyList->getSparql();
    }
    
    /**
     * getVars
     * get all vars used in this pattern (recursive)
     * @return array array of Erfurt_Sparql_Query2_Var
     */
    public function getVars() {
        $ret = array();

        if ($this->subject instanceof Erfurt_Sparql_Query2_Var){
            $ret[] = $this->subject;
        }

        $ret = array_merge($ret, $this->propertyList->getVars());
        
        return $ret;
    }
    
    /**
     * getPropList
     * @return array array of (Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList)-pairs
     */
    public function getPropList() {
        return $this->propertyList;
    }
    
    /**
     * getSubject
     * @return Erfurt_Sparql_Query2_VarOrTerm the subject
     */
    public function getSubject() {
        return $this->subject;
    }
    public function setSubject($subject) {
        $this->subject = $subject;
    }


    public function getWeight($part = null){
        if($part == null){
            $i = 0;
            foreach($this->propertyList as $prop){
                $i += ($prop['pred'] instanceof Erfurt_Sparql_Query2_Var ? 1 : 0) + ($prop['obj'] instanceof Erfurt_Sparql_Query2_ObjectList ? $prop['obj']->getNumVars() : 0 );
            }
            return ($this->subject instanceof Erfurt_Sparql_Query2_Var ? 1 : 0) + $i;
        } else {
            switch($part){
                case 0:
                    return ($this->subject instanceof Erfurt_Sparql_Query2_Var ? 1 : 0);
                    break;
                case 1:
                    $i = 0;
                    foreach($this->propertyList as $prop){
                        $i += $prop['pred'] instanceof Erfurt_Sparql_Query2_Var ? 1 : 0;
                    }
                    return $i;
                case 2:
                    $i = 0;
                    foreach($this->propertyList as $prop){
                        if($prop['obj'] instanceof Erfurt_Sparql_Query2_ObjectList){
                            $i += $prop['obj']->getNumVars();
                        } else if($prop['obj'] instanceof Erfurt_Sparql_Query2_Var){
                            $i++;
                        }
                    }
                    return $i;
                    break;
            }
        }
    }

    public static function compareWeight($c1, $c2){
        if (!($c1 instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject && $c2 instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject)) {
                return 0;
        }

        $res = $c1->getWeight() - $c2->getWeight();
        switch ($res){
            case $res == 0:
                // go deeper 
                
                
                break;
            case $res < 0:
                $ret = -1;
                break;
            case $res > 0:
                $ret = 1;
                break;
        }

        return $ret;
    }
}
?>
