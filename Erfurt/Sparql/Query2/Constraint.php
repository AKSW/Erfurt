<?php
/**
 * Erfurt Sparql Query2 - Constraint (can be set as filter expression)
 * 
 * @package    erfurt
 * @subpackage query2
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id: Constraint.php 4203 2009-09-28 13:56:20Z jonas.brekle@gmail.com $
 */
interface Erfurt_Sparql_Query2_Constraint{}

/**
 * the root interface for all constraining expressions
 * @package    erfurt
 * @subpackage query2
 */
interface Erfurt_Sparql_Query2_Expression extends Erfurt_Sparql_Query2_Constraint {}

/**
 * @package    erfurt
 * @subpackage query2
 */
interface Erfurt_Sparql_Query2_IF_ConditionalOrExpression extends Erfurt_Sparql_Query2_Expression {}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_AndOrHelper extends Erfurt_Sparql_Query2_ContainerHelper implements Erfurt_Sparql_Query2_IF_ConditionalOrExpression
{
    protected $conjunction;

    /**
     *
     * @param array $elements array of Erfurt_Sparql_Query2_Expression
     */
    public function __construct($elements = array()) {
        parent::__construct();
        if (!empty($elements)) {
            $this->setElements($elements);
        }
    }

    /**
     * @param Erfurt_Sparql_Query2_Expression
     * @return Erfurt_Sparql_Query2_AndOrHelper
     */
    public function addElement($element) {
        if (is_string($element)) {
            $element = new Erfurt_Sparql_Query2_RDFLiteral($element);
        }
        if (!($element instanceof Erfurt_Sparql_Query2_Expression)) {
             throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_RDFLiteral::__construct must be an instance of Erfurt_Sparql_Query2_Expression or string, instance of '.typeHelper($element).' given');
             exit;
        }
        $element->addParent($this);
        $this->elements[] = $element;
        return $this; //for chaining
    }

    /**
     * get the string-representation of this expression
     * @return string
     */
    public function getSparql() {
        $sparql = '';
        
        $countElements = count($this->elements);
        
        for ($i=0; $i<$countElements; ++$i) {
            $sparql .= $this->elements[$i]->getSparql();
            if (isset($this->elements[$i+1])) {
                $sparql .= ' '.$this->conjunction.' ';
            }
        }
        if (count($this->elements) > 1) {
            $sparql = '('.$sparql.')';
        }
        return $sparql;
    }

    /**
     * set an array of alements at once
     * @param array $elements of Erfurt_Sparql_Query2_Expression
     * @return Erfurt_Sparql_Query2_AndOrHelper
     */
    public function setElements($elements) {
        if (!is_array($elements)) {
            throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array');
        }
        
        foreach ($elements as $element) {
            if (!($element instanceof Erfurt_Sparql_Query2_Expression)) {
                throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array of Erfurt_Sparql_Query2_Expression');
                return $this; //for chaining
            }
        }
        $this->elements = $elements;
        return $this; //for chaining
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_ConditionalOrExpression extends Erfurt_Sparql_Query2_AndOrHelper
{    
    protected $conjunction = '||';
    
    public function __construct($elements = array()) {
        parent::__construct($elements);
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
interface Erfurt_Sparql_Query2_IF_ConditionalAndExpression extends Erfurt_Sparql_Query2_IF_ConditionalOrExpression{
    
}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_ConditionalAndExpression extends Erfurt_Sparql_Query2_AndOrHelper implements Erfurt_Sparql_Query2_IF_ConditionalAndExpression
{    
    protected $conjunction = '&&';

    /**
     *
     * @param <type> $elements
     */
    public function __construct($elements = array()) {
        parent::__construct($elements);
    }
}

/**
 * helper class for second-order relations
 */
abstract class Erfurt_Sparql_Query2_RelHelper extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_Expression
{
    protected $conjuction;
    protected $element1;
    protected $element2;

    /**
     * create a relation
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct();
        $this->element1 = $e1;
        $this->element2 = $e2;
    }

    /**
     * set the first element
     * @param Erfurt_Sparql_Query2_Expression $element
     * @return Erfurt_Sparql_Query2_RelHelper
     */
    public function setElement1(Erfurt_Sparql_Query2_Expression $element) {
        $this->element1 = $element;
        return $this; //for chaining
    }

    /**
     * set the second element
     * @param Erfurt_Sparql_Query2_Expression $element
     * @return Erfurt_Sparql_Query2_RelHelper
     */
    public function setElement2(Erfurt_Sparql_Query2_Expression $element) {
        $this->element2 = $element;
        return $this; //for chaining
    }

    /**
     * get string representation
     * @return string
     */
    public function getSparql() {    
        return $this->element1->getSparql().' '.$this->conjuction.' '.$this->element2->getSparql();
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
interface Erfurt_Sparql_Query2_RelationalExpression extends Erfurt_Sparql_Query2_IF_ConditionalAndExpression{ }

/**
 * equals relation
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_Equals extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '=';

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct($e1, $e2);
    }
}
class Erfurt_Sparql_Query2_NotEquals extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '!=';

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct($e1, $e2);
    }
}


/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_Larger extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '>';

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct($e1, $e2);
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_Smaller extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '<';

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct($e1, $e2);
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_LargerEqual extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '>=';

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct($e1, $e2);
    }
}


/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_SmallerEqual extends Erfurt_Sparql_Query2_RelHelper implements Erfurt_Sparql_Query2_RelationalExpression
{
    protected $conjuction = '<=';

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $e1
     * @param Erfurt_Sparql_Query2_Expression $e2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $e1, Erfurt_Sparql_Query2_Expression $e2) {
        parent::__construct($e1, $e2);
    }
}

interface Erfurt_Sparql_Query2_IF_AdditiveExpression extends Erfurt_Sparql_Query2_RelationalExpression {}

abstract class Erfurt_Sparql_Query2_AddMultHelper extends Erfurt_Sparql_Query2_ContainerHelper{

    const operator = null;
    const invOperator = null;
    /**
     *
     */
    public function __construct() {
        parent::__construct();
    }
    
    abstract public function addElement($op, Erfurt_Sparql_Query2_Expression $element);

    /**
     * get string representation
     * @return string
     */
    public function getSparql() {
        $sparql = '';
        
        $countElements = count($this->elements);
        
        for ($i=0; $i<$countElements; ++$i) {
            if ($i != 0 || $this->elements[$i]['op'] == self::invOperator) {
                $sparql .= ' '.$this->elements[$i]['op'].' ';
            }
            $sparql .= $this->elements[$i]['exp']->getSparql();
        }
        if (count($this->elements) > 1) {
            $sparql = '('.$sparql.')';
        }
        return $sparql;
    }

    /**
     *
     * @param array $elements array of Erfurt_Sparql_Query2_Expression
     * @return Erfurt_Sparql_Query2_AddMultHelper $this
     */
    public function setElements($elements) {
        if (!is_array($elements)) {
            throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array');
        }
        
        foreach ($elements as $element) {
            if (!($element['exp'] instanceof Erfurt_Sparql_Query2_Expression) || !isset($element['op'])) {
                throw new RuntimeException('Argument 1 passed to '.__CLASS__.'::setElements : must be an array of arrays consisting of a field "exp" with type Erfurt_Sparql_Query2_Expression and a field "op" containing the operator (+,-,*,/) as string');
                return $this; //for chaining
            } else {
                $this->addElement($element['op'], $element['exp']);
            }
        }

        return $this; //for chaining
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_AdditiveExpression extends Erfurt_Sparql_Query2_AddMultHelper implements Erfurt_Sparql_Query2_IF_AdditiveExpression
{    
    const operator = '+';
    const invOperator = '-';

    /**
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * @param <type> $op + or -. operator used to connect to the remaining elements
     * @param Erfurt_Sparql_Query2_Expression $exp
     * @return Erfurt_Sparql_Query2_AdditiveExpression $this
     */
    public function addElement($op, Erfurt_Sparql_Query2_Expression $exp) {
        if ($op == self::operator || $op == self::invOperator ) {
            //a hack to convert a expression that is added first when added with a minus as operator - would be omitted otherwise. maybe not usefull?!
            if ($op == self::invOperator && count($this->elements)==0) {
                if ($exp instanceof Erfurt_Sparql_Query2_RDFLiteral) {
                    $exp->setValue( invOperator . $exp->getValue() );
                } else if ($exp instanceof Erfurt_Sparql_Query2_NumericLiteral) {
                    $exp->setValue((-1)*$exp->getValue());
                } else {
                    $exp = new Erfurt_Sparql_Query2_UnaryExpressionMinus($exp);
                }    
            }
            $this->elements[] = array('op'=>$op, 'exp'=>$exp);
            $exp->addParent($this);
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_UnaryExpression::__construct must be Erfurt_Sparql_Query2_AdditiveExpression::minus or Erfurt_Sparql_Query2_AdditiveExpression::plus');
        }
        return $this; //for chaining
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
interface Erfurt_Sparql_Query2_IF_MultiplicativeExpression extends Erfurt_Sparql_Query2_IF_AdditiveExpression{}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_MultiplicativeExpression extends Erfurt_Sparql_Query2_AddMultHelper implements Erfurt_Sparql_Query2_IF_MultiplicativeExpression
{    
    const operator = '*';
    const invOperator = '/';

    /**
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * @param string $op * or / operator used to connect to the remaining elements
     * @param Erfurt_Sparql_Query2_Expression $exp
     * @return Erfurt_Sparql_Query2_MultiplicativeExpression $this
     */
    public function addElement($op, Erfurt_Sparql_Query2_Expression $exp) {
        if ($op == self::operator || $op == self::invOperator ) {
            $this->elements[] = array('op'=>$op, 'exp'=>$exp);
        } else {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_UnaryExpression::__construct must be Erfurt_Sparql_Query2_AdditiveExpression::times or Erfurt_Sparql_Query2_AdditiveExpression::divided');
        }
        $exp->addParent($this);
        return $this; //for chaining
    }

        /**
     * get string representation
     * @return string
     */
    public function getSparql() {
        $sparql = '';

        $countElements = count($this->elements);

        for ($i=0; $i<$countElements; ++$i) {
            if ($i == 0) {
                if($this->elements[$i]['op'] == self::invOperator){
                    $sparql .= ' 1'.$this->elements[$i]['op'].' '; // => 1/x
                }
            } else {
                $sparql .= ' '.$this->elements[$i]['op'].' ';
            }
            $sparql .= $this->elements[$i]['exp']->getSparql();
        }
        if ($countElements > 1) {
            $sparql = '('.$sparql.')';
        }
        return $sparql;
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
interface Erfurt_Sparql_Query2_IF_UnaryExpression extends Erfurt_Sparql_Query2_IF_MultiplicativeExpression {}

/**
 * @package    erfurt
 * @subpackage query2
 */
abstract class Erfurt_Sparql_Query2_UnaryExpressionHelper extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_IF_UnaryExpression
{
    protected $mod;
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_PrimaryExpression $element
     */
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return $this->mod.$this->element->getSparql();
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_UnaryExpressionNot extends Erfurt_Sparql_Query2_UnaryExpressionHelper
{
    protected $mod = '!';
    
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element) {
        parent::__construct($element);
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_UnaryExpressionPlus extends Erfurt_Sparql_Query2_UnaryExpressionHelper
{
    protected $mod = '+';

    /**
     *
     * @param Erfurt_Sparql_Query2_PrimaryExpression $element
     */
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element) {
        parent::__construct($element);
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_UnaryExpressionMinus extends Erfurt_Sparql_Query2_UnaryExpressionHelper
{
    protected $mod = '-';

    /**
     *
     * @param Erfurt_Sparql_Query2_PrimaryExpression $element
     */
    public function __construct(Erfurt_Sparql_Query2_PrimaryExpression $element) {
        parent::__construct($element);
    }
}

/**
 * @package    erfurt
 * @subpackage query2
 */
interface Erfurt_Sparql_Query2_PrimaryExpression extends Erfurt_Sparql_Query2_IF_UnaryExpression {}

/**
 * @package    erfurt
 * @subpackage query2
 */
interface Erfurt_Sparql_Query2_IriRefOrFunction extends Erfurt_Sparql_Query2_PrimaryExpression {}

/**
 * represents a user-defined function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_Function extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_IriRefOrFunction{
    protected $iri;
    protected $args = array();

    /**
     *
     * @param Erfurt_Sparql_Query2_IriRef|string $iri the iri of the function
     * @param array $args array of arguments (Erfurt_Sparql_Query2_Expression) of the function.
     */
    public function __construct($iri, $args = array()) {
        if (is_string($iri)) {
            $iri = new Erfurt_Sparql_Query2_IriRef($iri);
        }
        
        if (!($iri instanceof Erfurt_Sparql_Query2_IriRef)) {
            throw new RuntimeException('Argument 1 passed to Erfurt_Sparql_Query2_Function::__construct must be an instance of Erfurt_Sparql_Query2_IriRef or string (will be converted to IriRef), instance of '.typeHelper($iri).' given');
        }
        
        $this->iri = $iri;
        if ($args instanceof Erfurt_Sparql_Query2_Expression) {
            //only one given - pack into array
            $args = array($args);
        }
        
        
        if (!is_array($args)) {
            throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_Function::__construct must be an array of Erfurt_Sparql_Query2_Expression\'s, instance of '.typeHelper($args).' given');
        } else {
            foreach ($args as $arg) {
                if (!($arg instanceof Erfurt_Sparql_Query2_Expression)) {
                    throw new RuntimeException('Argument 2 passed to Erfurt_Sparql_Query2_Function::__construct must be an array of Erfurt_Sparql_Query2_Expression\'s, instance of '.typeHelper($arg).' given');
                } else {
                    $this->args[] = $arg;
                }
            }
        }
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return $this->iri->getSparql().'('.implode(', ', $this->args).')';
    }
    
}

/**
 * wrapps an expression in brackets
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_BrackettedExpression extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_PrimaryExpression
{
    protected $expression;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $expression
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $expression) {
        $this->expression = $expression;
        parent::__construct();
    }

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $expression
     * @return Erfurt_Sparql_Query2_BrackettedExpression
     */
    public function setExpression(Erfurt_Sparql_Query2_Expression $expression) {
        $this->expression = $expression;
        return $this; //for chaining
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return '('.$this->expression->getSparql().')';
    }
}
interface Erfurt_Sparql_Query2_BuiltInCall extends Erfurt_Sparql_Query2_PrimaryExpression {}

/**
 * represents a built-in str function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_Str extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'STR('.$this->element->getSparql().')';
    }
}

/**
 * represents a built-in Lang function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_Lang extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'LANG('.$this->element->getSparql().')';
    }
}

/**
 * represents a built-in datatype function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_Datatype extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'DATATYPE('.$this->element->getSparql().')';
    }
}

/**
 * represents a built-in isIri function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_isIri extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'isIRI('.$this->element->getSparql().')';
    }
}

/**
 * represents a built-in isUri function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_isUri extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'isURI('.$this->element->getSparql().')';
    }
}

/**
 * represents a built-in isLiteral function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_isLiteral extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'isLITERAL('.$this->element->getSparql().')';
    }
}

/**
 * represents a build-in isBlank function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_isBlank extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'isBLANK('.$this->element->getSparql().')';
    }
}

/**
 * represents a built-in bound function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_bound extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element;

    /**
     *
     * @param Erfurt_Sparql_Query2_Var $element
     */
    public function __construct(Erfurt_Sparql_Query2_Var $element) {
        $this->element = $element;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'BOUND('.$this->element->getSparql().')';
    }
}

/**
 * represents a built-in LangMatches function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_LangMatches extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element1;
    protected $element2;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element1
     * @param Erfurt_Sparql_Query2_Expression $element2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element1, Erfurt_Sparql_Query2_Expression $element2) {
        $this->element1 = $element1;
        $this->element2 = $element2;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'LANGMATCHES('.$this->element1->getSparql().', '.$this->element2->getSparql().')';
    }
}

/**
 * represents a built-in sameTerm function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_sameTerm extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element1;
    protected $element2;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element1
     * @param Erfurt_Sparql_Query2_Expression $element2
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element1, Erfurt_Sparql_Query2_Expression $element2) {
        $this->element1 = $element1;
        $this->element2 = $element2;
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'sameTerm('.$this->element1->getSparql().', '.$this->element2->getSparql().')';
    }
}

/**
 * represents a built-in "regex" function call
 * @package    erfurt
 * @subpackage query2
 */
class Erfurt_Sparql_Query2_Regex extends Erfurt_Sparql_Query2_ElementHelper implements Erfurt_Sparql_Query2_BuiltInCall
{
    protected $element1;
    protected $element2;
    protected $element3;

    /**
     *
     * @param Erfurt_Sparql_Query2_Expression $element1
     * @param Erfurt_Sparql_Query2_Expression $element2
     * @param <type> $element3
     */
    public function __construct(Erfurt_Sparql_Query2_Expression $element1, Erfurt_Sparql_Query2_Expression $element2, $element3 = null) {
        $this->element1 = $element1;
        $this->element2 = $element2;
        
        if ($element3 != null) {
            if ($element3 instanceof Erfurt_Sparql_Query2_Expression) {
                $this->element3 = $element3;
            } else {
                throw new RuntimeException('Argument 3 passed to Erfurt_Sparql_Query2_Regex::__construct must be an instance of Erfurt_Sparql_Query2_Expression or null, instance of '.typeHelper($element3).' given');
            }
        }
        parent::__construct();
    }

    /**
     * get the string representation
     * @return string
     */
    public function getSparql() {
        return 'REGEX('.$this->element1->getSparql().
', '.$this->element2->getSparql().
(gettype($this->element3)=='object'?(', '.$this->element3->getSparql()):'').')';
    }
}
?>
