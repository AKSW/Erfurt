<?php
/**
 * Erfurt Sparql Query2 - Var.
 * 
 * @package    ontowiki
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_Var extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_VarOrIriRef, Erfurt_Sparql_Query2_VarOrTerm, Erfurt_Sparql_Query2_PrimaryExpression
{
    protected $name;
    protected $varLabelType = '?';
    
    /**
     * @param string $nname
     */
    public function __construct($nname){
        if(is_string($nname) && $nname != ''){
            $this->name = $nname;
        } else if($nname instanceof Erfurt_Sparql_Query2_IriRef){
            $this->name = self::extractName($nname->getIri());
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_Var : string (not empty) or Erfurt_Sparql_Query2_IriRef expected. '.typeHelper($nname).' found.');
        }
        parent::__construct();
    }
       
    /**
     * getSparql
     * build a valid sparql representation of this obj - should be like '?name'
     * @return string
     */
    public function getSparql(){
        return $this->varLabelType.$this->name;
    }
    
    /**
     * getName
     * @return string the name of this var
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * setName
     * @param string $nname the new name
     * @return Erfurt_Sparql_Query2_Var $this
     */
    public function setName($nname){
        if(is_string($nname)) 
            $this->name = $nname;
        return $this; //for chaining
    }
    
    /**
     * setVarLabelType
     * @param string $ntype the new var label ('?' or '$')
     * @return Erfurt_Sparql_Query2_Var $this
     */
    public function setVarLabelType($ntype){
        if($ntype == '?' || $ntype == '$'){
            $this->varLabelType = $ntype;
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_Var::setVarLabelType : $ or ? expected. '.$ntype.' found.');
        }
        return $this; //for chaining
    }
    
    /**
     * getVarLabelType
     * @return string var label ('?' or '$')
     */
    public function getVarLabelType($ntype){
        return $this->varLabelType;
    }
    
    /**
     * toggleVarLabelType
     * @return Erfurt_Sparql_Query2_Var $this
     */
    public function toggleVarLabelType(){
        $this->varLabelType = $this->varLabelType == '?' ? '$' : '?';
        return $this; //for chaining
    }
    
    /**
     * extractName
     * 
     * if you have a uri like 
     * http://example.com/foaf/bob or
     * http://example.com/foaf#bob
     * http://example.com/bob/
     *  -> returns bob
     * 
     * @param string $name a iri 
     * @return string string after last / or #
     */
    public static function extractName($name){
        $parts = preg_split('/[\/#]/', $name);
        
        $ret = '';
        for($i=count($parts)-1; $ret == ''; $i--){
            $ret = $parts[$i];
        }
        
        if($ret == '') $ret = $name;
        
        return strtolower($ret);
    }
    
    
    public function __toString(){
        return $this->getSparql();
    }
}
?>
