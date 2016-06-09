<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt Sparql Query2 - TriplesSameSubject
 * 
 * @package    Erfurt_Sparql_Query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
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
            }
        }
    }

    /**
     * like strcmp for graph pattern elements
     * @param type $c1
     * @param type $c2
     * @return int
     */
    public static function compareWeight($c1, $c2){
        switch(true){
            case $c1 instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject:
                $c1weight = 1;
                break;
            case $c1 instanceof Erfurt_Sparql_Query2_GroupGraphPattern:
                $c1weight = 2;
                break;
            case $c1 instanceof Erfurt_Sparql_Query2_Filter:
                $c1weight = 3;
                break;
        }
        switch(true){
            case $c2 instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject:
                $c2weight = 1;
                break;
            case $c2 instanceof Erfurt_Sparql_Query2_GroupGraphPattern:
                $c2weight = 2;
                break;
            case $c2 instanceof Erfurt_Sparql_Query2_Filter:
                $c2weight = 3;
                break;
        }
        if (!($c1 instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject && $c2 instanceof Erfurt_Sparql_Query2_IF_TriplesSameSubject)) {
            return $c1weight - $c2weight;
        }

        //both are normal triples
        $cmp = $c1->getWeight() - $c2->getWeight();
        return $cmp != 0 ? $cmp : strcmp((string)$c1, (string)$c2);
    }
}

