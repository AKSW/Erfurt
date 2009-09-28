<?php

require_once 'Query2/structural-Interfaces.php';
require_once 'Query2/ObjectHelper.php';
require_once 'Query2/Prefix.php';
require_once 'Query2/OrderClause.php';
require_once 'Query2/GraphClause.php';
require_once 'Query2/ObjectList.php';
require_once 'Query2/Triple.php';
require_once 'Query2/TriplesSameSubject.php';
require_once 'Query2/Constraint.php';
require_once 'Query2/Var.php';
require_once 'Query2/GroupGraphPattern.php';
require_once 'Query2/GroupOrUnionGraphPattern.php';
require_once 'Query2/OptionalGraphPattern.php';
require_once 'Query2/ConstructTemplate.php';
require_once 'Query2/IriRef.php';
require_once 'Query2/RDFLiteral.php';
require_once 'Query2/NumericLiteral.php';
require_once 'Query2/Nil.php';
require_once 'Query2/BooleanLiteral.php';
require_once 'Query2/BlankNode.php';
require_once 'Query2/Abstraction.php';
require_once 'Query2/A.php';
require_once 'Query2/Filter.php';

//TODO: is there a better way for getting the type/class?
function typeHelper($obj){
    $class = get_class($obj);
    return !empty($class) ? $class : gettype($obj);
}

/**
 * Erfurt Sparql Query2
 * 
 * represents a sparql query
 * 
 * @package    ontowiki
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
class Erfurt_Sparql_Query2 extends Erfurt_Sparql_Query2_GroupHelper
{
    /**
     * @staticvar string a constant for select type
     */
    const typeSelect = 'SELECT';
    /**
     * @staticvar string a constant for ask type
     */
    const typeAsk = 'ASK';
    /**
     * @staticvar string a constant for construct type
     */
    const typeConstruct = 'CONSTRUCT';
    /**
     * @staticvar string a constant for describe type
     */
    const typeDescribe = 'DESCRIBE';
    
    protected $type = null;
    protected $limit = 0;
    protected $offset = 0;
    protected $distinctReducedMode = 0;
    protected $order = null;
    protected $projectionVars = array();
    protected $star = true;
    protected $countStar = false;
    protected $where = null;
    protected $prefixes = array();
    protected $froms = array();
    protected $base = null;
    protected $constructTemplate = null;
    
    /**
     * @staticvar int id 
     */
    public static $idCounter = 0;
    
    /**
     * getNextID
     * generate a runtime-unique id for Query2 related objects
     * @return     int    id
     */
    static function getNextID(){
        return self::$idCounter++;
    }
    
    public function __construct(){
        $this->order = new Erfurt_Sparql_Query2_OrderClause();
        $this->where = new Erfurt_Sparql_Query2_GroupGraphPattern;
        $type = self::typeSelect;
        if(func_num_args()>0){
            $type = func_get_arg(0);
        }
        $this->setQueryType($type);
    }
    
    public function __clone() {
        foreach($this as $key => $val) {
            if(is_object($val)||(is_array($val))){
                $this->{$key} = unserialize(serialize($val));
                //$this->$key= clone($this->$key); 
            }
        }
    } 
    
    public function __toString() 
    {    
        return $this->getSparql();
    }
    
    /**
     * redirect method calls to the query object
     * @param string $name
     * @param array $params
     */
    public function __call($name, $params){
        if(method_exists($this->where, $name)){
            $ret = call_user_func_array(array($this->where, $name), $params);  
        } else throw new RuntimeException("Query2: method $name does not exists");
            
        if($ret == $this->where) 
        	return $this; 
        else 
            return $ret;
    }
   
    /**
     * getSparql
     * build a query string
     * @return	string	query
     */
    public function getSparql(){
        $sparql = '';
        
        if($this->hasBase()){
            $sparql .= 'BASE '.$this->base->getSparql()." \n";
        }
        
        foreach($this->prefixes as $prefix)
            $sparql .= $prefix->getSparql()." \n";
        
        $sparql .= $this->type.' ';
        
        if($this->isSelectType()){
            switch($this->distinctReducedMode){
                case 0:
                break;
                case 1:
                $sparql .= 'DISTINCT ';
                break;
                case 2:
                $sparql .= 'REDUCED ';
                break;
            }
        }
        if($this->isSelectType() || $this->isDescribeType()){
            if(!$this->countStar){
                if(count($this->projectionVars) != 0 && !$this->star){
                    foreach($this->projectionVars as $selectVar){
                        $sparql .= $selectVar->getSparql().' ';
                    }
                } else {
                    if(!$this->isAskType())
                        $sparql .= '*';
                }
            } else $sparql .= 'COUNT(*)';
        }
        $sparql .= " \n";
        
        if($this->isConstructType()){
            $sparql .= $this->constructTemplate->getSparql();
        }

        foreach($this->froms as $from){
            $sparql .= 'FROM '.$from->getSparql()." \n";
        }
        
        if(!($this->isDescribeType() && count($this->where->getElements()) == 0))
            $sparql .= 'WHERE '.$this->where->getSparql();
        
        if(!$this->isAskType()){
            if($this->hasOrderBy()){
                $sparql .= $this->order->getSparql()." \n";
            }
            if($this->hasLimit()){
                $sparql .= 'LIMIT '.$this->limit." \n";
            }
            
            if($this->hasOffset()){
                $sparql .= 'OFFSET '.$this->offset." \n";
            }
        }
        
        return $sparql;
    }
    
    /**
     * setQueryType
     * set type of the query (select, ask, describe or construct)
     * @param string $type one of the constants Erfurt_Sparql_Query2::typeSelect,...
     * @return	Erfurt_Sparql_Query2	$this
     */
    public function setQueryType($type){
        //special configs for different types...
        switch($type){
            case Erfurt_Sparql_Query2::typeSelect:
            break;
            case Erfurt_Sparql_Query2::typeAsk:
                //ask has no solution modifyer - delete?
                //$this->setLimit(0);
                //$this->setOffset(0);
                //$this->order = new Erfurt_Sparql_Query2_OrderClause();
                //$this->distinctReducedMode = 0;
                //$this->projectionVars = array();
            break;
            case Erfurt_Sparql_Query2::typeDescribe:
            break;
            case Erfurt_Sparql_Query2::typeConstruct:
                $this->constructTemplate = new Erfurt_Sparql_Query2_ConstructTemplate();
            break;
            default:
                throw new RuntimeException('Erfurt_Sparql_Query2::setQueryType : Unknown query type given: "'.$type.'"');
        }
        //save type
        $this->type = $type;
        return $this; //for chaining
    }
    
    /**
     * isSelectType
     * @return bool true if the query is a select query 
     */
    public function isSelectType(){
        return $this->type == Erfurt_Sparql_Query2::typeSelect;
    }
    
    /**
     * isAskType
     * @return bool true if the query is a ask query 
     */
    public function isAskType(){
        return $this->type == Erfurt_Sparql_Query2::typeAsk;
    }
    
    /**
     * isDescribeType
     * @return bool true if the query is a describe query 
     */
    public function isDescribeType(){
        return $this->type == Erfurt_Sparql_Query2::typeDescribe;
    }
    
    /**
     * isConstructType
     * @return bool true if the query is a construct query 
     */
    public function isConstructType(){
        return $this->type == Erfurt_Sparql_Query2::typeConstruct;
    }

    /**
     * hasOffset
     * @return bool true if the query a offset modifier
     */
    public function hasOffset(){
        return $this->offset!=0;
    }
    
    /**
     * hasLimit
     * @return bool true if the query is a limit modifier
     */
    public function hasLimit(){
        return $this->limit!=0;
    }
    
    /**
     * isSelectType
     * @return bool true if the query is a select query 
     */
    public function hasOrderBy(){
        return $this->order->used();
    }
    
    /**
     * setWhere
     * set a GroupGraphPattern as the where part of the query
     * @param Erfurt_Sparql_Query2_GroupGraphPattern $npattern
     * @return Erfurt_Sparql_Query2 $this
     */
    public function setWhere(Erfurt_Sparql_Query2_GroupGraphPattern $npattern){
        //TODO maybe add check here that the pattern doesnt contain two variables with same name
        $this->where = $npattern;
        return $this; //for chaining
    }
    
    /**
     * getWhere
     * get the where part of the query
     * @return Erfurt_Sparql_Query2_GroupGraphPattern pattern
     */
    public function getWhere(){
        return $this->where;
    }
    
    /**
     * setConstructTemplate
     * set a ConstructTemplate in the query (only usefull if the query is a construct query)
     * @param Erfurt_Sparql_Query2_ConstructTemplate $npattern
     * @return Erfurt_Sparql_Query2 $this
     */    
    public function setConstructTemplate(Erfurt_Sparql_Query2_ConstructTemplate $npattern){
        //TODO maybe add check here that the pattern doesnt contain two variables with same name
        $this->constructTemplate = $npattern;
        return $this; //for chaining
    }
    
    /**
     * getConstructTemplate
     * get the ConstructTemplate of the query
     * @return Erfurt_Sparql_Query2_ConstructTemplate pattern
     */
    public function getConstructTemplate(){
        return $this->constructTemplate;
    }
    
    /**
     * setLimit
     * set the solution modifier "limit"
     * @param int $nlimit
     */
    public function setLimit($nlimit){
        //if($this->isAskType()) throw new RuntimeException("Trying to set solution modifier \"Limit\" in an ASK-Query - not possible");
        $this->limit = $nlimit;
        return $this; //for chaining
    }
    
    /**
     * removeLimit
     * @return Erfurt_Sparql_Query2 $this
     */
    public function removeLimit(){
        $this->limit = 0;
        return $this; //for chaining
    }
    
    /**
     * getLimit
     * @return int the limit of the query
     */
    public function getLimit(){
        return $this->limit;
    }
    
    /**
     * setOffset
     * set the solution modifier "offset"
     * @param int $noffset
     */
    public function setOffset($noffset){
        //if($this->isAskType()) 
        //    throw new RuntimeException("Trying to set solution modifier \"Offset\" in an ASK-Query - not possible");
        
        $this->offset = $noffset;
        return $this; //for chaining
    }
    
    /**
     * removeOffset
     * @return Erfurt_Sparql_Query2 $this
     */
    public function removeOffset(){
        $this->offset = 0;
        return $this; //for chaining
    }
    
    /**
     * getOffset
     * @return int the offset of the query
     */
    public function getOffset(){
        return $this->offset;
    }
    
    /**
     * setStar
     * set a query to "star-mode" (when the query is of the form SELECT * FROM ...)
     * @param bool $bool true to turn on, false to turn off star-mode
     * @return Erfurt_Sparql_Query2 $this
     */
    public function setStar($bool = true){
        if($bool === true) $this->projectionVars = array(); // delete projection vars if set to star mode - usefull?
        $this->star = $bool;
        return $this; //for chaining
    }
    
    /**
     * isStar
     * @return bool true if if star-mode (when the query is of the form SELECT * FROM ...)
     */
    public function isStar(){
        return (count($this->projectionVars) == 0 || $this->star);
    }
    
    /**
     * setCountStar
     * set a query to count-star-mode (qhen the query is of the form SELECT count(*) FROM...)
     * @param bool $bool true to turn on, false to turn off count-star-mode
     * @return Erfurt_Sparql_Query2 $this
     */
    public function setCountStar($bool = true){
        if($bool === true) $this->projectionVars = array(); // delete projection vars if set to star mode - usefull?
        $this->countStar = $bool;
        return $this; //for chaining
    }
    
    /**
     * isCountStar
     * @return bool true if count-star-mode (when the query is of the form SELECT count(*) FROM ...)
     */
    public function isCountStar(){
        return $this->countStar;
    }
    
    /**
     * setDistinct
     * enable/disable distinct solution modifier
     * @param bool $bool true to turn on, false to turn off
     * @return Erfurt_Sparql_Query2 $this
     */
    public function setDistinct($bool = true){
        if($bool === true) 
            $this->distinctReducedMode = 1;
        else if($this->distinctReducedMode == 1) 
            $this->distinctReducedMode = 0;
        return $this; //for chaining
    }
    
    /**
     * isDistinct
     * @return bool true if query is set distinct, false otherwise
     */
    public function isDistinct(){
        return $this->distinctReducedMode == 1;
    }
    
    /**
     * setReduced
     * enable/disable reduced solution modifier
     * @param bool $bool true to turn on, false to turn off star-mode
     * @return Erfurt_Sparql_Query2 $this
     */
    public function setReduced($bool = true){
        if($bool === true) 
            $this->distinctReducedMode = 2;
        else if($this->distinctReducedMode == 2) 
            $this->distinctReducedMode = 0;
        return $this; //for chaining
    }
    
    /**
     * isReduced
     * @return bool true if query is set reduced false otherwise
     */
    public function isReduced(){
        return $this->distinctReducedMode == 2;
    }
    
    /**
     * setBase
     * @param Erfurt_Sparql_Query2_IriRef $base
     * @return Erfurt_Sparql_Query2 $this
     */
    public function setBase(Erfurt_Sparql_Query2_IriRef $base){
        if($base->isPrefixed()) throw new RuntimeException('Trying to add base with a prefix');
        $this->base = $base;
        $base->addParent($this);
        return $this; //for chaining
    }
    /**
     * removeBase
     * @return Erfurt_Sparql_Query2 $this
     */
    public function removeBase(){
        $this->base->removeParent($this);
        $this->base = null;
        return $this; //for chaining
    }
    
    /**
     * getBase
     * @return Erfurt_Sparql_Query2_IriRef base
     */
    public function getBase($base){
        return $this->base;
    }
    
    /**
     * hasBase
     * @return bool true if the query has a base set
     */
    public function hasBase(){
        return $this->base != null;
    }
    
    /**
     * addFrom
     * @param Erfurt_Sparql_Query2_GraphClause|Erfurt_Sparql_Query2_IriRef|string $from
     * @return Erfurt_Sparql_Query2 $this
     */
    public function addFrom($from, $name = false){
        if(!($from instanceof Erfurt_Sparql_Query2_GraphClause || $from instanceof Erfurt_Sparql_Query2_IriRef || is_string($from))){
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2::addFrom must be an instance of Erfurt_Sparql_Query2_GraphClause or Erfurt_Sparql_Query2_IriRef or string, instance of '.typeHelper($setNamed).' given');
        }
        
        $named = false;
        
        if($from instanceof Erfurt_Sparql_Query2_IriRef)
            $from = new Erfurt_Sparql_Query2_GraphClause($from);
        if(is_string($from))
            $from = new Erfurt_Sparql_Query2_GraphClause(new Erfurt_Sparql_Query2_IriRef($from));
        
        if(!is_bool($named)){
            throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2::addFrom must be an instance of bool, instance of '.typeHelper($named).' given');
        } else $from->setNamed($named);
        
        
        //search for equal froms
        foreach($this->froms as $compare){
            if($compare->getGraphIri()->getIri() == $from->getGraphIri()->getIri() && $compare->isNamed() == $from->isNamed()){
                return $this; //for chaining
            }
        }
        
        $this->froms[] = $from;
        return $this; //for chaining
    }
    
    /**
     * getFrom
     * @param int $i
     * @return Erfurt_Sparql_Query2_GraphClause the from with index i
     */
    public function getFrom($i){
        return $this->froms[$i];
    }
    
    /**
     * getFroms
     * @return array all froms - array of Erfurt_Sparql_Query2_GraphClause
     */
    public function getFroms(){
        return $this->froms;
    }
    
    /**
     * removeFroms
     * delete all Froms of this query
     * @return Erfurt_Sparql_Query2 $this
     */
    public function removeFroms(){
        $this->froms = array();
        return $this; //for chaining
    }
    
    /**
     * removeFrom
     * @param int $needle
     * @return Erfurt_Sparql_Query2 $this
     */
    public function removeFrom($needle){
        if(!is_int($needle)){
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2::removeFrom must be an instance of int, instance of '.typeHelper($needle).' given');
        }
        $new = array();
        for($i=0;$i<count($this->froms); $i++){
            if($i != $needle)
                $new[] = $this->froms[$i];
        }
        
        $this->froms = $new;
        return $this; //for chaining
    }
    
    /**
     * setFroms
     * @param array an array of Erfurt_Sparql_Query2_GraphClause
     * @return Erfurt_Sparql_Query2 $this
     */
    public function setFroms($froms){
        if(!is_array($froms)){
            $tmp = $froms;
            $froms = array();
            $froms[0] = $tmp;
        }
        
            
        foreach($froms as $key => $from){
            if($froms[$key] instanceof Erfurt_Sparql_Query2_IriRef)
                $froms[$key] = new Erfurt_Sparql_Query2_GraphClause($froms[$key]);
            if(is_string($froms[$key]))
                $froms[$key] = new Erfurt_Sparql_Query2_GraphClause(new Erfurt_Sparql_Query2_IriRef($froms[$key]));
        }
        
        $this->froms = $froms;
        return $this; //for chaining
    }
    
    /**
     * setFrom
     * @param int i index of the from to overwrite
     * @param Erfurt_Sparql_Query2_GraphClause from the new from object
     * @return Erfurt_Sparql_Query2 $this
     */
    public function setFrom($i, Erfurt_Sparql_Query2_GraphClause $from){
        if(!is_int($i)) throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2::setFrom must be an instance of int, instance of '.typeHelper($i).' given');
        $this->froms[$i] = $from;
        return $this; //for chaining
    }
    
    /**
     * hasFroms
     * @return bool true if there are froms in this query
     */
    public function hasFroms(){
        return !empty($this->froms);
    }
    
    /**
     * hasFrom
     * @param Erfurt_Sparql_Query2_GraphClause|Erfurt_Sparql_Query2_IriRef|string $from
     * @return bool true if the given from is present in this query
     */
    public function hasFrom($from){
        if(!($from instanceof Erfurt_Sparql_Query2_GraphClause || $from instanceof Erfurt_Sparql_Query2_IriRef || is_string($from))){
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2::hasFrom must be an instance of Erfurt_Sparql_Query2_GraphClause or Erfurt_Sparql_Query2_IriRef or string, instance of '.typeHelper($setNamed).' given');
        }
        
        
        if($from instanceof Erfurt_Sparql_Query2_IriRef)
            $from = new Erfurt_Sparql_Query2_GraphClause($from);
        if(is_string($from))
            $from = new Erfurt_Sparql_Query2_GraphClause(new Erfurt_Sparql_Query2_IriRef($from));
        
        return in_array($from, $this->froms);
    }
    
    /**
     * addProjectionVar
     * add a variable to the projection modifier (i.e. SELECT ?s FROM...)
     * @param Erfurt_Sparql_Query2_Var $var 
     * @return Erfurt_Sparql_Query2 $this
     */
    public function addProjectionVar(Erfurt_Sparql_Query2_Var $var){
        if(in_array($var, $this->projectionVars)){
            //already added
            return $this; //for chain/ing
        }
        
        /*if(!in_array($var, $this->where->getVars())){
            trigger_error('Trying to add projection-var ('.$var->getSparql().') that is not used in pattern', E_USER_NOTICE);
            return $this; //for chaining
        }*/
        
        if(count($this->projectionVars) == 0)
            $this->star = false; //if the first var is added: deactivate the star. maybe always?
        
        $this->projectionVars[] = $var;
        return $this; //for chaining
    }
    
    /**
     * removeProjectionVar
     * @param Erfurt_Sparql_Query2_Var $var 
     * @return Erfurt_Sparql_Query2 $this
     */
    public function removeProjectionVar(Erfurt_Sparql_Query2_Var $var){
        $new = array();
        
        //hack to detect multiple var objects with the same "name" - should be prevented by a factory method for vars
        foreach($this->projectionVars as $compare){
            if(!$compare->equals($var)){
                $new[] = $compare;
            } 
        }
        $this->projectionVars = $new;
        return $this; //for chaining
    }
    
    /**
     * removeAllProjectionVars
     * @return Erfurt_Sparql_Query2 $this
     */
    public function removeAllProjectionVars(){
        $this->projectionVars = array();
        return $this;
    }
    
    /**
     * addPrefix
     * @param Erfurt_Sparql_Query2_Prefix $prefix
     * @return Erfurt_Sparql_Query2 $this
     */
    public function addPrefix(Erfurt_Sparql_Query2_Prefix $prefix){
        $this->prefixes[] = $prefix;
        return $this; //for chaining
    }
        
    /**
     * removePrefix
     * @param Erfurt_Sparql_Query2_Prefix $var 
     * @return Erfurt_Sparql_Query2 $this
     */
    public function removePrefix(Erfurt_Sparql_Query2_Prefix $pre){
        $new = array();
        
        foreach($this->prefixes as $compare){
            if(!$compare->equals($pre)){
                $new[] = $compare;
            } 
        }
        $this->prefixes = $new;
        return $this; //for chaining
    }
    
    /**
     * getProjectionVars
     * @return array array of Erfurt_Sparql_Query2_Var - all projection vars
     */
    public function getProjectionVars(){
        return $this->projectionVars;
    }
    
    /**
     * getVars
     * @return array array of Erfurt_Sparql_Query2_Var - all vars used in the where pattern
     */
    public function getVars(){
        return $this->where->getVars();
    }
    
    /**
     * getOrder
     * @return Erfurt_Sparql_Query2_OrderClause the order clause
     */
    public function getOrder(){
        //if($this->isAskType()) throw new RuntimeException("Trying to set solution modifier \"Order\" in an ASK-Query - not possible");
        return $this->order;
    }
    
    /**
     * varFactory
     * a factory method that either instantiates a var with the given name or if a var with that name is already used in this query gives you that one
     * @param string $name
     * @return Erfurt_Sparql_Query2_Var the var
     */
    public function varFactory($name){
        $used = $this->where->getVars();
        for($i=0; $i < count($used); $i++){
            if($name == $used[$i]->getName()){
                return $used[$i];
            }
        }
        return new Erfurt_Sparql_Query2_Var($name);
    }
    
    /**
     * optimize
     * calls the optimize command on the where pattern and/or constructTemplate
     * @return Erfurt_Sparql_Query2 $this
     */
    public function optimize(){
        if($this->where != null)
        	$this->where->optimize();
        if($this->constructTemplate != null)
        	$this->constructTemplate->optimize();
        return $this;
    }
    
    public function removeElement($element, $equal = false){
    	if($element instanceof Erfurt_Sparql_Query2_Var){
    		$this->removeProjectionVar($element);
    	} else if ($element instanceof Erfurt_Sparql_Query2_GraphClause){
    		$this->removeFrom($element);
    	} else if ($element instanceof Erfurt_Sparql_Query2_Prefix){
    	   	$this->removePrefix($element);
    	} else if($element instanceof Erfurt_Sparql_Query2_IriRef){
    	    $this->removeBase($element);
    	} else {
    	    //throw
    	    return $this;
        }
        
        $element->removeParent($this);
        return $this;
    }
    
    public function setElements($elements){
    	//throw
    }
}
?>