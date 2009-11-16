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

class Erfurt_Sparql_Query2_TriplesSameSubject extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_IF_TriplesSameSubject
{
    protected $subject;
    protected $propertyList = array();
    
    /**
     * @param Erfurt_Sparql_Query2_VarOrTerm $subject
     * @param array $propList array of (Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList)-pairs
     */
    public function __construct(Erfurt_Sparql_Query2_VarOrTerm $subject, $propList = array()) {
        $this->subject = $subject;
        if (!is_array($propList)) {
            throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_TriplesSameSubject::__construct must be an array of [Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList]-pairs, instance of '.typeHelper($propList).' given');
        } else {
            foreach ($propList as $prop) {
                if (!($prop['pred'] instanceof Erfurt_Sparql_Query2_Verb && $prop['obj'] instanceof Erfurt_Sparql_Query2_IF_ObjectList)) {
                    throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_TriplesSameSubject::__construct must be an array of [Erfurt_Sparql_Query2_Verb, Erfurt_Sparql_Query2_IF_ObjectList]-pairs, instance of '.typeHelper($prop).' given');
                } else {
                    $this->propertyList[] = $prop;
                }
            }
        }
        
        parent::__construct();
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj
     * @return string
     */
    public function getSparql() {
        $propList = '';
        
        for ($i=0; $i<count($this->propertyList); $i++) {
            $propList .= "\t".$this->propertyList[$i]['pred']->getSparql(). ' '.$this->propertyList[$i]['obj']->getSparql();
            if ($i<(count($this->propertyList)-1)) {
                $propList .=" ;\n";
            }
        }
        
        return $this->subject->getSparql().' '.$propList;
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

        foreach($this->propertyList as $prop){
            if($prop['pred'] instanceof Erfurt_Sparql_Query2_Var) {
                $ret[] = $prop['pred'];
            }

            if($prop['obj'] instanceof Erfurt_Sparql_Query2_ObjectList){
                $ret = array_merge($ret, $prop['obj']->getVars());
            } else {
                if($prop['obj'] instanceof Erfurt_Sparql_Query2_Var){
                    $ret[] = $prop['obj'];
                }
            }
        }
        
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
