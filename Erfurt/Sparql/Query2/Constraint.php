<?php
/**
 * Erfurt Sparql Query2 - Constraint
 * 
 * @package    ontowiki
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
interface Erfurt_Sparql_Query2_Constraint
{
    public function getSparql();
}
interface Erfurt_Sparql_Query2_Expression extends Erfurt_Sparql_Query2_Constraint {}


abstract class Erfurt_Sparql_Query2_AndOrHelper extends Erfurt_Sparql_Query2_GroupHelper
{
    protected $conjuction;
    
    public function __construct($elements = null){
        parent::__construct();
        if($elements != null) $this->setElements($elements);
    }
    
    public function addElement($element){
        if(is_string($element)){
            $element = new Erfurt_Sparql_Query2_RDFLiteral($element);
        }
        if(!($element instanceof Erfurt_Sparql_Query2_Expression)){
             throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_RDFLiteral::__construct must be an instance of Erfurt_Sparql_Query2_Expression or string, instance of '.typeHelper($element).' given');
        }
        $element->newUser($this);
        $this->elements[] = $element;
        return $this; //for chaining
    }
    
    public function getSparql(){
        $sparql = '';
        
        for($i=0; $i<count($this->elements); $i++){
            $sparql .= $this->elements[$i]->getSparql();
            if(isset($this->elements[$i+1])){
                $sparql .= ' '.$this->conjunction.' ';
            }
        }
        if(count($this->elements) > 1){
            $sparql = '('.$sparql.')';
        }
        return $sparql;
    }
    
    public function getVars(){
        //TODO not implemented yet
        return array();
    }
    
    public function setElements($elements){
        if(!is_array($elements)){
            throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array');
        }
        
        foreach($elements as $element){
            if(!($element instanceof Erfurt_Sparql_Query2_Expression)){
                throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array of Erfurt_Sparql_Query2_Expression');
                return $this; //for chaining
            }
        }
        $this->elements = $elements;
        return $this; //for chaining
    }
}

interface Erfurt_Sparql_Query2_IF_ConditionalOrExpression extends Erfurt_Sparql_Query2_Expression {}

class Erfurt_Sparql_Query2_ConditionalOrExpression extends Erfurt_Sparql_Query2_AndOrHelper implements Erfurt_Sparql_Query2_IF_ConditionalOrExpression
{    
    protected $conjunction = '||';
    
    public function __construct($elements = null){
        parent::__construct($elements);
    }
    
}
interface Erfurt_Sparql_Query2_IF_ConditionalAndExpression extends Erfurt_Sparql_Query2_IF_ConditionalOrExpression{
    
}
class Erfurt_Sparql_Query2_ConditionalAndExpression extends Erfurt_Sparql_Query2_AndOrHelper implements Erfurt_Sparql_Query2_IF_ConditionalAndExpression
{    
    protected $conjunction = '&&';
    
    public function __construct($elements = null){
        parent::__construct($elements);
    }
}
abstract class Erfurt_Sparql_Query2_RelHelper extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_Expression
{
    protected $conjuction;
    protected $element1;
    protected $element2;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2){
        $this->element1 = $e1;
        $this->element2 = $e2;
        parent::__construct();
    }
    
    public function setElement1(Erfurt_Sparql_Query2_Expression $element){
        $this->element1 = $element;
        return $this; //for chaining
    }
    public function setElement2(Erfurt_Sparql_Query2_Expression $element){
        $this->element2 = $element;
        return $this; //for chaining
    }
    
    public function getSparql(){    
        return $this->element1->getSparql().' '.$this->conjuction.' '.$this->element2->getSparql();
    }
}

interface Erfurt_Sparql_Query2_RelationalExpression extends Erfurt_Sparql_Query2_IF_ConditionalAndExpression{ }

class Erfurt_Sparql_Query2_Equals extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '=';
    
    public function __construct(){
        parent::__construct();
    }
}
class Erfurt_Sparql_Query2_NotEquals extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '!=';
    
    public function __construct(){
        parent::__construct();
    }
}
class Erfurt_Sparql_Query2_Larger extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '>';
    
    public function __construct(){
        parent::__construct();
    }
}
class Erfurt_Sparql_Query2_Smaller extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '<';
    
    public function __construct(){
        parent::__construct();
    }
}
class Erfurt_Sparql_Query2_LargerEqual extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '>=';
    
    public function __construct(){
        parent::__construct();
    }
}
class Erfurt_Sparql_Query2_SmallerEqual extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '<=';
    
    public function __construct(){
        parent::__construct();
    }
}

interface Erfurt_Sparql_Query2_IF_AdditiveExpression extends Erfurt_Sparql_Query2_RelationalExpression {}

abstract class Erfurt_Sparql_Query2_AddMultHelper extends Erfurt_Sparql_Query2_GroupHelper{
    
    public function __construct(){
        parent::__construct();
    }
    
    abstract public function addElement($op, Erfurt_Sparql_Query2_Expression $element);
    
    public function getSparql(){
        $sparql = '';
        
        for($i=0; $i<count($this->elements); $i++){
            if($i!=0){
                $sparql .= ' '.$this->elements[$i]['op'].' ';
            }
            $sparql .= $this->elements[$i]['exp']->getSparql();
        }
        if(count($this->elements) > 1){
            $sparql = '('.$sparql.')';
        }
        return $sparql;
    }
        
    public function getVars(){
        //TODO not implemented yet
        return array();
    }
    
    public function setElements($elements){
        if(!is_array($elements)){
            throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array');
        }
        
        foreach($elements as $element){
            if(!($element instanceof Erfurt_Sparql_Query2_Expression)){
                throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array of instances of Erfurt_Sparql_Query2_Expression');
                return $this; //for chaining
            }
        }
        $this->elements = $elements;
        return $this; //for chaining
    }
}
class Erfurt_Sparql_Query2_AdditiveExpression extends Erfurt_Sparql_Query2_AddMultHelper implements Erfurt_Sparql_Query2_IF_AdditiveExpression
{    
    const minus = '-';
    const plus = '+';
    
    public function __construct(){
        parent::__construct();
    }
    
    public function addElement($op, Erfurt_Sparql_Query2_Expression $exp){
        if($op == self::minus || $op == self::plus ){
            //a hack to convert a expression that is added first when added with a minus as operator - would be omitted otherwise. maybe not usefull?!
            if($op == self::minus && count($this->elements)==0){
                if($exp instanceof Erfurt_Sparql_Query2_RDFLiteral){
                    $exp->setValue('-'.$exp->getValue());
                } else if ($exp instanceof Efurt_Sparql_Query2_NumericLiteral){
                    $exp->setValue((-1)*$exp->getValue());
                } else {
                    $exp = new Erfurt_Sparql_Query2_UnaryExpression(Erfurt_Sparql_Query2_UnaryExpression::minus, $exp);
                }    
            }
            $this->elements[] = array('op'=>$op, 'exp'=>$exp);
            $exp->newUser($this);
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_UnaryExpression::__construct must be Erfurt_Sparql_Query2_AdditiveExpression::minus or Erfurt_Sparql_Query2_AdditiveExpression::plus');
        }
        return $this; //for chaining
    }
}

interface Erfurt_Sparql_Query2_IF_MultiplicativeExpression extends Erfurt_Sparql_Query2_IF_AdditiveExpression{}

class Erfurt_Sparql_Query2_MultiplicativeExpression extends Erfurt_Sparql_Query2_AddMultHelper implements Erfurt_Sparql_Query2_IF_MultiplicativeExpression
{    
    const times = '*';
    const divided = '/';
    
    public function __construct(){
        parent::__construct();
    }
    
    public function addElement($op, Erfurt_Sparql_Query2_Expression $exp){
        if($op == self::times || $op == self::divided ){
            $this->elements[] = array('op'=>$op, 'exp'=>$exp);
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_UnaryExpression::__construct must be Erfurt_Sparql_Query2_AdditiveExpression::times or Erfurt_Sparql_Query2_AdditiveExpression::divided');
        }
        $exp->newUser($this);
        return $this; //for chaining
    }
}

interface Erfurt_Sparql_Query2_IF_UnaryExpression extends Erfurt_Sparql_Query2_IF_MultiplicativeExpression{
    
}

abstract class Erfurt_Sparql_Query2_UnaryExpressionHelper extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_IF_UnaryExpression
{
    protected $mod;
    protected $element;

    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return $this->mod.$this->element->getSparql();
    }
}

class Erfurt_Sparql_Query2_UnaryExpressionNot extends Erfurt_Sparql_Query2_UnaryExpressionHelper
{
    protected $mod = '!';
    
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element){
        parent::__construct($element);
    }
}
class Erfurt_Sparql_Query2_UnaryExpressionPlus extends Erfurt_Sparql_Query2_UnaryExpressionHelper
{
    protected $mod = '+';
    
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element){
        parent::__construct($element);
    }
}
class Erfurt_Sparql_Query2_UnaryExpressionMinus extends Erfurt_Sparql_Query2_UnaryExpressionHelper
{
    protected $mod = '-';
    
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element){
        parent::__construct($element);
    }
}

interface Erfurt_Sparql_Query2_PrimaryExpression extends Erfurt_Sparql_Query2_IF_UnaryExpression {}

interface Erfurt_Sparql_Query2_IriRefOrFunction extends Erfurt_Sparql_Query2_PrimaryExpression {}

class Erfurt_Sparql_Query2_Function extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_IriRefOrFunction{
    protected $iri;
    protected $args = array();
    
    public function __construct($iri, $args = array()){
        if(is_string($iri)){
            $iri = new Erfurt_Sparql_Query2_IriRef($iri);
        }
        
        if(!($iri instanceof Erfurt_Sparql_Query2_IriRef)){
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_Function::__construct must be an instance of Erfurt_Sparql_Query2_IriRef or string (will be converted to IriRef), instance of '.typeHelper($iri).' given');
        }
        
        $this->iri = $iri;
        if($args instanceof Erfurt_Sparql_Query2_Expression){
            //only one given - pack into array
            $args = array($args);
        }
        
        
        if(!is_array($args)){
            throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_Function::__construct must be an array of Erfurt_Sparql_Query2_Expression\'s, instance of '.typeHelper($args).' given');
        } else {
            foreach($args as $arg){
                if(!($arg instanceof Erfurt_Sparql_Query2_Expression)){
                    throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_Function::__construct must be an array of Erfurt_Sparql_Query2_Expression\'s, instance of '.typeHelper($arg).' given');
                } else {
                    $this->args[] = $arg;
                }
            }
        }
        parent::__construct();
    }
    
    public function getSparql(){
        return $this->iri->getSparql().'('.implode(', ', $this->args).')';
    }
    
}

class Erfurt_Sparql_Query2_BrackettedExpression extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_PrimaryExpression
{
    protected $expression;

    public function __construct(Erfurt_Sparql_Query2_Expression $expression){
        $this->expression = $expression;
        parent::__construct();
    }
    
    public function setExpression(Erfurt_Sparql_Query2_Expression $expression){
        $this->expression = $expression;
        return $this; //for chaining
    }
    
    public function getSparql(){
        return '('.$this->expression->getSparql().')';
    }
}
interface Erfurt_Sparql_Query2_BuiltInCall extends Erfurt_Sparql_Query2_PrimaryExpression
{
    
}
class Erfurt_Sparql_Query2_Str extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    public function __construct(Erfurt_Sparql_Query2_Expression $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'STR('.$this->element->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_Lang extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'LANG('.$this->element->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_Datatype extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'DATATYPE('.$this->element->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_isIri extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'isIRI('.$this->element->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_isUri extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'isURI('.$this->element->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_isLiteral extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'isLITERAL('.$this->element->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_isBlank extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'isBLANK('.$this->element->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_bound extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;
    
    public function __construct(Erfurt_Sparql_Query2_Var $element){
        $this->element = $element;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'BOUND('.$this->element->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_LangMatches extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element1;
    protected $element2;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element1, Erfurt_Sparql_Query2_Expression $element2){
        $this->element1 = $element1;
        $this->element2 = $element2;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'LANGMATCHES('.$this->element1->getSparql().', '.$this->element2->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_sameTerm extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element1;
    protected $element2;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element1, Erfurt_Sparql_Query2_Expression $element2){
        $this->element1 = $element1;
        $this->element2 = $element2;
        parent::__construct();
    }
    
    public function getSparql(){
        return 'sameTerm('.$this->element1->getSparql().', '.$this->element2->getSparql().')';
    }
}
class Erfurt_Sparql_Query2_Regex extends Erfurt_Sparql_Query2_ObjectHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element1;
    protected $element2;
    protected $element3;
    
    public function __construct(Erfurt_Sparql_Query2_Expression $element1, Erfurt_Sparql_Query2_Expression $element2){
        $this->element1 = $element1;
        $this->element2 = $element2;
        
        if(func_num_args()>2){
            $element3 = func_get_arg(2);
            if($element3 instanceof Erfurt_Sparql_Query2_Expression){
                $this->element3 = $element3;
            } else {
                throw new RuntimeException('Argument 3 passed to Erfurt_Sparql_Query2_Regex::__construct must be an instance of Erfurt_Sparql_Query2_Expression, instance of '.typeHelper($element3).' given');
            }
        }
        parent::__construct();
    }
    
    public function getSparql(){
        return 'REGEX('.$this->element1->getSparql().
', '.$this->element2->getSparql().
(gettype($this->element3)=='object'?(', '.$this->element3->getSparql()):'').')';
    }
}
?>
