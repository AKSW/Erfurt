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
    protected $unexpandablePrefix = null;
    
    /**
     * @param string $nresource
     * @param Erfurt_Sparql_Query2_Prefix $prefix
     * @param string $unexpandablePrefix
     */
    public function __construct($nresource, Erfurt_Sparql_Query2_Prefix $prefix = null, $unexpandablePrefix = null) {
        if (!is_string($nresource)) {
            throw new RuntimeException('wrong argument 1 passed to Erfurt_Sparql_Query2_IriRef::__construct. string expected. '.typeHelper($nresource).' found.');
        }
        $this->iri = $nresource;
                
        if ($prefix != null) {
            $this->prefix = $prefix;
        }

        if($unexpandablePrefix !== null && is_string($unexpandablePrefix)){
            $this->unexpandablePrefix = $unexpandablePrefix;
        }

        parent::__construct();
    }
       
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like "<http://example.com>" or "ns:local"
     * @return string
     */
    public function getSparql() {
        if($this->isPrefixed()){
            if($this->prefix != null){
                return $this->prefix->getPrefixName().':'.$this->iri;
            } else {
                return $this->unexpandablePrefix.':'.$this->iri;
            }
        } else {
            return '<'.$this->iri.'>';
        }
    }
    
    public function __toString() {    
        return $this->getSparql();
    }
    
    /**
     * isPrefixed
     * check if this IriRef uses a prefix
     */
    public function isPrefixed() {
        return $this->prefix != null || $this->unexpandablePrefix !== null;
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
        if($this->isPrefixed()){
            if($this->prefix != null){
                return '<'.$this->prefix->getPrefixIri()->iri . $this->iri.'>';
            } else {
                return $this->unexpandablePrefix.':'.$this->iri;
            }
        } else {
            return '<'.$this->iri.'>';
        }
    }
}
?>
