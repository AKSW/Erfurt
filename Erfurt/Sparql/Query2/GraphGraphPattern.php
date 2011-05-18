<?php
require_once 'GroupGraphPattern.php';

/**
 * Erfurt_Sparql Query2 - GraphGraphPattern.
 * 
 * representation of named graphs
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */

class Erfurt_Sparql_Query2_GraphGraphPattern extends Erfurt_Sparql_Query2_GroupGraphPattern 
{
    protected $varOrIri;
    
    /**
     * @param Erfurt_Sparql_Query2_VarOrIriRef $nvarOrIri
     */
    public function __construct(Erfurt_Sparql_Query2_VarOrIriRef $nvarOrIri) {
        $this->varOrIri = $nvarOrIri;
        parent::__construct();
    }
    
    /**
     * setVarOrIri
     * @param Erfurt_Sparql_Query2_VarOrIriRef $nvarOrIri
     * @return Erfurt_Sparql_Query2_GraphGraphPattern $this
     */
    public function setVarOrIri(Erfurt_Sparql_Query2_VarOrIriRef $nvarOrIri) {
        $this->varOrIri = $nvarOrIri;
        return $this; //for chaining
    }
    
    /**
     * getVarOrIri
     * @return Erfurt_Sparql_Query2_VarOrIriRef the name of this graph
     */
    public function getVarOrIri() {
        return $this->varOrIri;
    }
       
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "GRAPH <http://example.com> {[Triple...]}" or "GRAPH ?graphName {[Triple...]}"
     * @return string
     */
    public function getSparql() {
        return 'GRAPH '.$this->varOrIri->getSparql().' '. substr(parent::getSparql(),0,-1); //subtr is cosmetic for stripping off the last linebreak 
    }
    
    public function __toString() 
    {    
        return $this->getSparql();
    }
    
    /**
     * getVars
     * get all vars used in this pattern (recursive)
     * @return array array of Erfurt_Sparql_Query2_Var
     */
    public function getVars() {
        $vars = parent::getVars();
        if ($this->varOrIri instanceof Erfurt_Sparql_Query2_Var)
            $vars[] = $this->varOrIri;
        return $vars;
    }
}
?>
