<?php
/**
 * Erfurt_Sparql_Query2_ContainerHelper
 */
abstract class Erfurt_Sparql_Query2_ContainerHelper extends Erfurt_Sparql_Query2_ElementHelper
{
    protected $elements = array();

    public function __construct($elements = array()) {
        parent::__construct();
        if(is_array($elements)){
            $this->setElements($elements);
        } else if($elements instanceof Erfurt_Sparql_Query2_ElementHelper){
             $this->addElement($elements);
        }
    }

    public function getParentContainer($needle){
        $parents = array();

        if(in_array($needle, $this->elements)){
            $parents[] = $this;
        }

        foreach($this->elements as $element){
            if($element instanceof Erfurt_Sparql_Query2_ContainerHelper){
                $parents = array_merge($parents, $element->getParentContainer($needle));
            }
        }

        return $parents;
    }
    //abstract public function addElement($member); //not used because some use typehinting some do it internally for multiple types

    /**
     * getElement
     * @param int $i index of the element
     * @return Erfurt_Sparql_Query2_ElementHelper the element
     */
    public function getElement($i) {
        return $this->elements[$i];
    }

    /**
     * getElements
     * @return array array of Erfurt_Sparql_Query2_ElementHelper - the elements that are contained
     */
    public function getElements() {
        return $this->elements;
    }

    public function size() {
        return count($this->elements);
    }

    /**
     * get all variables that are contained (recursive)
     * @return array of Erfurt_Sparql_Query2_Var
     */
    public function getVars() {
        $ret = array();
        foreach($this->elements as $element){
            if($element instanceof Erfurt_Sparql_Query2_Var){
                $ret[] = $element;
            } else if ($element instanceof Erfurt_Sparql_Query2_ContainerHelper){
                $ret = array_merge($ret, $element->getVars());
            }
        }
        return $ret;
    }

    //abstract public function setElement($i, $member); //not used because some use typehinting some do it internally
    abstract public function setElements($elements);

    /**
     * removeElement
     * @param Erfurt_Sparql_Query2_ElementHelper $toDelete
     * @param boolean $equal
     * @return Erfurt_Sparql_Query2_ContainerHelper $this
     */
    public function removeElement($toDelete, $equal = false) {
        $new = array();
        foreach ($this->elements as $element) {
            $inExp = false;
            if(!($element instanceof Erfurt_Sparql_Query2_ElementHelper)){
                if(isset($element['exp']) && $element['exp'] instanceof Erfurt_Sparql_Query2_ElementHelper){
                     //this is used in Erfurt_Sparql_Query2_AdditiveExpression
                     $inExp = true;
                } else {
                    throw new RuntimeException("Element of a Erfurt_Sparql_Query2_ContainerHelper must be of type Erfurt_Sparql_Query2_ElementHelper", E_USER_ERROR);
                }
            }
            if ($toDelete->getID() == ($inExp ? $element["exp"]->getID() :  $element->getID()) || ($equal && $toDelete->equals($inExp ? $element["exp"] :  $element))) {
                //matched - dont keep
            } else {
                //not matched - keep
                $new[] = $element;
                //recursive
                if (($inExp ? $element["exp"] :  $element) instanceof Erfurt_Sparql_Query2_ContainerHelper){
                    if($inExp){
                        $element["exp"]->removeElement($toDelete, $equal);
                    } else {
                        $element->removeElement($toDelete, $equal);
                    }
                }
            }
        }
        //$toDelete->removeParent($this);
        $this->elements = $new;

        return $this; //for chaining
    }

    /**
     * removeAllElements
     * @return Erfurt_Sparql_Query2_ContainerHelper $this
     */
    public function removeAllElements() {
        $this->elements = array();
        return $this; //for chaining
    }

    /**
     * equals
     * checks for mutual inclusion
     * @param mixed $obj the object to compare with
     * @return bool true if equal, false otherwise
     */
    public function equals($obj) {
        //trivial cases
        if ($this===$obj) return true;

        if (get_class($this) !== get_class($obj)) {
                return false;
        }


        if (!method_exists($obj, "getID")) {
            return false;
        }

        if ($this->getID() == $obj->getID()) {
            return true;
        }

        //check for mutual inclusion
        foreach ($obj->getElements() as $his) {
                $found = false;

                foreach ($this->elements as $mine) {
                        if ($mine->equals($his)) {
                                $found = true;
                        }
                }

                if (!$found) return false;
        }

        foreach ($this->elements as $mine) {
                $found = false;

                foreach ($obj->getElements() as $his) {
                        if ($his->equals($mine)) {
                                $found = true;
                        }
                }

                if (!$found) return false;
        }

        return true;
    }

    public function contains($element, $recursive = false) {
        foreach ($this->elements as $mine) {
            if($recursive && $mine instanceof Erfurt_Sparql_Query2_ContainerHelper){
                if($mine->contains($element, true)){
                    return true;
                }
                continue;
            }
            if ($element->equals($mine)) {
                return true;
            }
        }

        return false;
    }
}
?>
