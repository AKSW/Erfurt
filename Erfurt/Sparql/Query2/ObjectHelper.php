<?php
/**
 * OntoWiki Sparql Query ObjectHelper
 * 
 * a abstract helper class for objects that are elements of groups. i.e.: Triples but also GroupGraphPatterns
 * 
 * @package    
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: ObjectHelper.php 4246 2009-10-06 09:57:37Z jonas.brekle@gmail.com $
 * @abstract
 */
abstract class Erfurt_Sparql_Query2_ObjectHelper{
    protected $id;
    protected $parents = array();

    public function __construct() {
        $this->id = Erfurt_Sparql_Query2::getNextID();
    }

    //abstract public function getSparql();

    /**
     * addParent
     * when a ObjectHelper-object is added to a GroupHelper-object this method is called. lets the child know of the new parent
     * @param Erfurt_Sparql_Query2_GroupHelper $parent
     * @return Erfurt_Sparql_Query2_ObjectHelper $this
     */
    public function addParent(Erfurt_Sparql_Query2_GroupHelper $parent) {
        if (!in_array($parent, $this->parents))
                $this->parents[] = $parent;

        return $this;
    }

    /**
     * remove
     * removes this object from all parents
     * @return Erfurt_Sparql_Query2_ObjectHelper $this
     */
    public function remove() {
        foreach ($this->parents as $parent) {
                $parent->removeElement($this);
        }

        return $this;
    }

    /**
     * removeParent
     * removes a parent
     * @param Erfurt_Sparql_Query2_GroupHelper $parent
     * @return Erfurt_Sparql_Query2_ObjectHelper $this
     */
    public function removeParent(Erfurt_Sparql_Query2_GroupHelper $parent) {
        $new = array();
        foreach ($this->parents as $compare) {
                if ($compare != $parent) {
                        $new[] = $compare;
                }
        }

        $this->parents = $new;

        return $this;
    }

    /**
     * getID
     * @return int the id of this object
     */
    public function getID() {
        return $this->id;
    }

    /**
     * getParents
     * @return array an array of Erfurt_Sparql_Query2_GroupHelper
     */
    public function getParents() {
        return $this->parents;
    }

    /**
     * equals
     * @param mixed $obj the object to compare with
     * @return bool true if equal, false otherwise
     */
    public function equals($obj) {
        //trivial cases
        if ($this === $obj) return true;

        if (!method_exists($obj, "getID")) {
            return false;
        }

        if ($this->getID() == $obj->getID()) {
            return true;
        }

        if (get_class($this) !== get_class($obj)) {
                return false;
        }

        return $this->getSparql() === $obj->getSparql();
    }

    abstract public function getSparql();

    public function  __toString()
    {
        return $this->getSparql();
    }
}
