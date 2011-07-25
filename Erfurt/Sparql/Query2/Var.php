<?php
//some classes and interfaces are not in separate files
//(-> no compliance with zend classfile naming for autoloading)
//reason:  they are stubs and they are many
//so we have to require them manually. irgh
require_once 'structural-Interfaces.php';
require_once 'Constraint.php';

/**
 * Erfurt Sparql Query2 - Var.
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2_Var extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_VarOrIriRef, Erfurt_Sparql_Query2_VarOrTerm, Erfurt_Sparql_Query2_PrimaryExpression
{
    protected $name;
    protected $varLabelType = '?';
    
    /**
     * @param string $nname
     */
    public function __construct($nname) {
        if (is_string($nname) && $nname != '') {
            $this->name = preg_replace('/[^\w]/', '', $nname);
        } else if ($nname instanceof Erfurt_Sparql_Query2_IriRef) {
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
    public function getSparql() {
        return $this->varLabelType.$this->name;
    }
    
    /**
     * getName
     * @return string the name of this var
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * setName
     * @param string $nname the new name
     * @return Erfurt_Sparql_Query2_Var $this
     */
    public function setName($nname) {
        if (is_string($nname)) 
            $this->name = $nname;
        return $this; //for chaining
    }
    
    /**
     * setVarLabelType
     * @param string $ntype the new var label ('?' or '$')
     * @return Erfurt_Sparql_Query2_Var $this
     */
    public function setVarLabelType($ntype) {
        if ($ntype == '?' || $ntype == '$') {
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
    public function getVarLabelType() {
        return $this->varLabelType;
    }
    
    /**
     * toggleVarLabelType
     * @return Erfurt_Sparql_Query2_Var $this
     */
    public function toggleVarLabelType() {
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
    public static function extractName($name) {
        $parts = preg_split('/[\/#]/', $name);
        
        $ret = '';
        for ($i=count($parts)-1; $ret == ''; $i--) {
            $ret = $parts[$i];
        }
        
        if ($ret == '') $ret = $name;
        
        $lower = strtolower($ret);
        
        $PN_CHARS_BASE = 'A-Za-z\x{00C0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{02FF}\x{0370}-\x{037D}\x{037F}-\x{1FFF}\x{200C}-\x{200D}\x{2070}-\x{218F}\x{2C00}-\x{2FEF}\x{3001}-\x{D7FF}\x{F900}-\x{FDCF}\x{FDF0}-\x{FFFD}\x{10000}-\x{EFFFF}';
        $PN_CHARS_U	  = $PN_CHARS_BASE . '_';
        $firstVarNameChar = $PN_CHARS_U.'0-9';
        $tailVarNameChars = $PN_CHARS_U.'0-9\x{00B7}\x{0300}-\x{036F}\x{203F}-\x{2040}';
       
        $firstVarNameCharRegex = '/[^'.$firstVarNameChar.']/u';
        $firstChar = substr($lower, 0, 1);
        $firstCharClean = preg_replace($firstVarNameCharRegex, '', $firstChar);
        
        $tailVarNameCharsRegex = '/[^'.$tailVarNameChars.']+/u';
        $tailChars = substr($lower, 1);
        $tailCharsClean = preg_replace($tailVarNameCharsRegex, '', $tailChars);
        
        $clean = $firstCharClean.$tailCharsClean;
        
        return $clean;
    }
    
    
    public function __toString() {
        return $this->getSparql();
    }
}
?>
