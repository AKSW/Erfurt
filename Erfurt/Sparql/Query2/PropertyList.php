<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PropertyList
 *
 * @author jonas
 */
class Erfurt_Sparql_Query2_PropertyList {
    protected $properties = array();

    function __construct(array $props = null) {
        if($props !== null){
            foreach($props as $prop){
                if(!is_array($prop) || !isset($prop['verb']) || !isset($prop['objList']) || !($prop['verb'] instanceof Erfurt_Sparql_Query2_Verb) || !($prop['objList'] instanceof Erfurt_Sparql_Query2_ObjectList)){
                    throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_PropertyList::__construct must be an array of arrays containing the fields "verb"(instance of Erfurt_Sparql_Query2_Verb) and "objList"(instance of Erfurt_Sparql_Query2_ObjectList)', E_USER_ERROR);
                }
                $this->addProperty($prop['verb'], $prop['objList']);
            }
        }
    }


    public function addProperty(Erfurt_Sparql_Query2_Verb $verb, Erfurt_Sparql_Query2_ObjectList $objList){
        $this->properties[] = array('verb' => $verb, 'objList' => $objList);
    }

    public function getSparql(){
        $ret = '';
        
        $countProperties = count($this->properties);
        
        for($i = 0; $i < $countProperties; ++$i){
            $ret .= "\t" . $this->properties[$i]['verb'] . " " . $this->properties[$i]['objList'];
            if(isset($this->properties[$i+1])){
                $ret .= " ; \n";
            }
        }
        return $ret;
    }

    public function isEmpty(){
        return (count($this->properties) == 0);
    }

    public function getVars(){
        $ret = array();
        
        $countProperties = count($this->properties);
        
        for($i = 0; $i < $countProperties; ++$i){
            if($this->properties[$i]['verb'] instanceof Erfurt_Sparql_Query2_Var){
                $ret[] = $this->properties[$i]['verb'];
            }
            $ret = array_merge($ret, $this->properties[$i]['objList']->getVars());
        }
        return $ret;
    }

    public function __toString(){
        return $this->getSparql();
    }
}
?>
