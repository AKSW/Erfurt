<?php
/**
 * Erfurt_Sparql_Query2_GroupHelper
 */
abstract class Erfurt_Sparql_Query2_GroupHelper extends Erfurt_Sparql_Query2_ObjectHelper
{
    protected $elements = array();

    public function __construct($elements = array()) {
        parent::__construct();
        if(is_array($elements)){
            $this->setElements($elements);
        }
    }


    //abstract public function addElement($member); //not used because some use typehinting some do it internally for multiple types

    /**
     * getElement
     * @param int $i index of the element
     * @return Erfurt_Sparql_Query2_ObjectHelper the element
     */
    public function getElement($i) {
        return $this->elements[$i];
    }

    /**
     * getElements
     * @return array array of Erfurt_Sparql_Query2_ObjectHelper - the elements that are contained
     */
    public function getElements() {
        return $this->elements;
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
            } else if ($element instanceof Erfurt_Sparql_Query2_GroupHelper){
                $ret = array_merge($ret, $element->getVars());
            }
        }
        return $ret;
    }

    //abstract public function setElement($i, $member); //not used because some use typehinting some do it internally
    abstract public function setElements($elements);

    /**
     * removeElement
     * @param int $i index of the element
     * @return Erfurt_Sparql_Query2_GroupHelper $this
     */
    public function removeElement($element, $equal = false) {
        $new = array();

        for ($i=0;$i<count($this->elements); $i++) {
                if ($this->elements[$i]->getID() != $element->getID() || ($equal && $this->elements[$i]->equals($element))) {
                        if ($this->elements[$i] instanceof Erfurt_Sparql_Query2_GroupHelper)
                                $this->elements[$i]->removeElement($element);
                        $new[] = $this->elements[$i];
                }
        }
        $element->removeParent($this);
        $this->elements = $new;

        return $this; //for chaining
    }

    /**
     * removeAllElements
     * @return Erfurt_Sparql_Query2_GroupHelper $this
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
}
?>
