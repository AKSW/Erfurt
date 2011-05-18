<?php
/**
 * Erfurt_Sparql Query - BlankNode.
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_BlankNode implements Erfurt_Sparql_Query2_GraphTerm
{ //TODO 1. may not appear in two different graphs. 2. an anon bn should only be used once (fix in ...GraphPattern)
    protected $name = '';

    /**
     * @param string $nname
     */
    public function __construct($nname) {
        if (is_string($nname))
            $this->name = $nname;
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "[]" or "_:localname"
     * @return string
     */
    public function getSparql() {
        return $this->isAnon() ? '[]' : '_:'.$this->name;
    }
    
    /**
     * getName
     * @return string the name of this blanknode
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * isAnon
     * @return bool true if no name is set
     */
    public function isAnon() {
        return empty($this->name);
    }

    public function __toString(){
        return $this->getSparql();
    }
}
?>
