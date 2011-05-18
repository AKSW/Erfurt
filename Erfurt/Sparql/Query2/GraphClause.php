<?php
/**
 * Erfurt Sparql Query2 - GraphClause
 * 
 * represents a FROM
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_GraphClause extends Erfurt_Sparql_Query2_ElementHelper
{
    protected $graphIri;
    protected $named = false;
    
    /**
     * @param Erfurt_Sparql_Query2_IriRef $iri
     */
    public function __construct($iri, $named = false) {
        if(is_string($iri)){
            $iri = new Erfurt_Sparql_Query2_IriRef($iri);
        }
        if(!($iri instanceof Erfurt_Sparql_Query2_IriRef)){
            throw new RuntimeException("Argument 1 passed to Erfurt_Sparql_Query2_GraphClause::__construct must be instance of Erfurt_Sparql_Query2_IriRef or string", E_USER_ERROR);
        }
        $this->graphIri = $iri;
        
        if (is_bool($named)){
            $this->named = $named;
        }

        parent::__construct();
    }
    
    /**
     * isNamed
     * @return bool true if this FROM is a "FROM NAMED"
     */
    public function isNamed() {
        return $this->named;
    }
    
    /**
     * setNamed
     * @param bool $bool
     * @return Erfurt_Sparql_Query2_GraphClause $this
     */
    public function setNamed($bool = true) {
        if (is_bool($bool)){
            $this->named = $bool;
        }
        return $this; // for chaining
    }
    
    /**
     * getGraphIri
     * @return Erfurt_Sparql_Query2_IriRef the iri
     */
    public function getGraphIri() {
        return $this->graphIri;
    }
       
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "FROM <http://example.com>" or "FROM NAMED <http://example.com>"
     * @return string
     */
    public function getSparql() {
        return ($this->named ? 'NAMED ': '') . $this->graphIri->getSparql();
    }
    
    public function __toString() 
    {    
        return $this->getSparql();
    }
}
?>
