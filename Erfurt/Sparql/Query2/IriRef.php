<?php
/**
 * Erfurt_Sparql Query - IriRef.
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_IriRef extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_VarOrIriRef, Erfurt_Sparql_Query2_GraphTerm, Erfurt_Sparql_Query2_IriRefOrFunction {
    protected $iri;
    protected $prefix = null;
    
    /**
     * @param string $nresource
     * @param Erfurt_Sparql_Query2_Prefix $prefix
     */
    public function __construct($nresource, Erfurt_Sparql_Query2_Prefix $prefix = null) {
        if (!is_string($nresource)) {throw new RuntimeException('wrong argument 1 passed to Erfurt_Sparql_Query2_Var::__construct. string expected. '.typeHelper($nresource).' found.');}
        $this->iri = $nresource;
                
        if ($prefix != null) {
            $this->prefix = $prefix;
        }
    }
       
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "<http://example.com>" or "ns:local"
     * @return string
     */
    public function getSparql() {
        return $this->isPrefixed() ? ($this->prefix->getPrefixName().':'.$this->iri) : ('<'.$this->iri.'>');
    }
    
    public function __toString() {    
        return $this->getSparql();
    }
    
    /**
     * isPrefixed
     * check if this IriRef uses a prefix
     */
    public function isPrefixed() {
        return $this->prefix != null;
    }
    
    /**
     * getIri
     * get the iri - may be only the local part if prefixed
     * @return string
     * @see getExpanded
     */
    public function getIri() {
        return $this->iri;
    }
    
    /**
     * getExpanded
     * expand the prefix
     * @return string
     */
    public function getExpanded() {
        return '<'.( $this->isPrefixed() ? $this->prefix->getPrefixIri()->getIri() : '') . ($this->iri.'>');
    }
}
?>
