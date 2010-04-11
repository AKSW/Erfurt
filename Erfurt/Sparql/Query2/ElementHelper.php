<?php
/**
 * OntoWiki Sparql Query ElementHelper
 * 
 * a abstract helper class for objects that are elements of groups. i.e.: Triples but also GroupGraphPatterns
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: ElementHelper.php 4246 2009-10-06 09:57:37Z jonas.brekle@gmail.com $
 * @abstract
 */
abstract class Erfurt_Sparql_Query2_ElementHelper {
    protected $id;
    protected $parents = array();

    public function __construct() {
        $this->id = Erfurt_Sparql_Query2::getNextID();
    }

    //abstract public function getSparql();

    /**
     * addParent
     * when a ElementHelper-object is added to a ContainerHelper-object this method is called. lets the child know of the new parent
     * @param Erfurt_Sparql_Query2_ContainerHelper $parent
     * @return Erfurt_Sparql_Query2_ElementHelper $this
     */
    public function addParent(Erfurt_Sparql_Query2_ContainerHelper $parent) {
//        if (!in_array($parent, $this->parents))
//                $this->parents[] = $parent;

        return $this;
    }

    /**
     * remove
     * removes this object from a query
     * @param $query 
     * @return Erfurt_Sparql_Query2_ElementHelper $this
     */
    public function remove($query) {
        //remove from this query
        foreach($query->getParentContainer($this) as $parent){
            $parent->removeElement($this);
        }

//        foreach ($this->parents as $parent) {
//                $parent->removeElement($this);
//        }

        return $this;
    }

    /**
     * removeParent
     * removes a parent
     * @param Erfurt_Sparql_Query2_ContainerHelper $parent
     * @return Erfurt_Sparql_Query2_ElementHelper $this
     */
    public function removeParent(Erfurt_Sparql_Query2_ContainerHelper $parent) {
//        $new = array();
//        foreach ($this->parents as $compare) {
//                if ($compare->equals($parent)) {
//                        $new[] = $compare;
//                }
//        }
//
//        $this->parents = $new;

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
     * @return array an array of Erfurt_Sparql_Query2_ContainerHelper
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

        if (!method_exists($obj, 'getID')) {
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
