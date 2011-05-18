<?php
/**
 * Erfurt Sparql Query2 - GraphTerm.
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_Prefix extends Erfurt_Sparql_Query2_ElementHelper //TODO must be unique in Query - factory?
{
    protected $name;
    protected $iri;
    
    /**
     * @param string $nname
     * @param Erfurt_Sparql_Query2_IriRef $iri
     */
    public function __construct($nname, $iri) {
        if (!is_string($nname))
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_Prefix::__construct must be an instance of string, instance of '.typeHelper($iri).' given');
        $this->name = $nname;
        
        if(is_string($iri)){
            $iri = new Erfurt_Sparql_Query2_IriRef($iri);
        }
        if(!($iri instanceof Erfurt_Sparql_Query2_IriRef)){
            throw new RuntimeException("Argument 2 passed to Erfurt_Sparql_Query2_Prefix::__construct must be instance of Erfurt_Sparql_Query2_IriRef or string", E_USER_ERROR);
        }
        
        $this->iri = $iri;
        
        parent::__construct();
    }
    
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like 'PREFIX ns : <http://example.com>'
     * @return string
     */
    public function getSparql() {
        return 'PREFIX '.$this->name.':'.$this->iri->getSparql(); 
    }
    
    /**
     * getPrefixName
     * @return string the name of the prefix (everything before the ':')
     */
    public function getPrefixName() {
        return $this->name;
    }
    
    /**
     * getPrefixIri
     * @return Erfurt_Sparql_Query2_IriRef the iri which this prefix stands for
     */
    public function getPrefixIri() {
        return $this->iri;
    }
}
?>
