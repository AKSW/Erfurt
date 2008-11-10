<?php
/**
 * Parses a SPARQL Query string and returns a Query Object.
 *
 * @author   Tobias Gauss <tobias.gauss@web.de>
 * @author   Christian Weiske <cweiske@cweiske.de>
 * @version     $Id$
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 *
 * @package sparql
 */
class Erfurt_Sparql_Parser 
{
    /** 
     * The query Object 
     * @var Query 
     */
    protected $_query;

    /**
     * The tokenized Query
     * @var array
     */
    protected $_tokens = array();

    /**
     * Last parsed graphPattern
     * @var int
     */
    protected $_tmp;

    /**
     * Operators introduced by sparql
     * @var array
     */
    protected static $_sops = array(
        'regex',
        'bound',
        'isuri',
        'isblank',
        'isliteral',
        'str',
        'lang',
        'datatype',
        'langmatches'
    );

    /**
     *   Which order operators are to be treated.
     *   (11.3 Operator Mapping)
     *   @var array
     */
    protected static $_operatorPrecedence = array(
        '||'    => 0,
        '&&'    => 1,
        '='     => 2,
        '!='    => 3,
        '<'     => 4,
        '>'     => 5,
        '<='    => 6,
        '>='    => 7,
        '*'     => 0,
        '/'     => 0,
        '+'     => 0,
        '-'     => 0,
    );

    /**
     * Main function of SparqlParser. Parses a query string.
     *
     * @param  String $queryString The SPARQL query
     * @return Query  The query object
     * @throws SparqlParserException
     */
    public function parse($queryString = false) 
    {
        $this->_prepare();

        if ($queryString) {
            $this->_query->setQueryString($queryString);

            $uncommented    = self::uncomment($queryString);
            $this->_tokens  = self::tokenize($uncommented);
            
            $this->_parseQuery();
            
            if (!$this->_query->isComplete()) {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException('Query is incomplete.', null, $queryString);
            }
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('Querystring is empty.', null, key($this->_tokens));
            $this->_query->isEmpty = true;
        }

        return $this->_query;
    }

    /**
     *   Set all internal variables to a clear state
     *   before we start parsing.
     */
    protected function _prepare() 
    {   
        require_once 'Erfurt/Sparql/Query.php';
        $this->_query          = new Erfurt_Sparql_Query();
        
        $this->_tokens         = array();
        $this->_tmp            = null;
    }

    /**
     * Tokenizes the query string into $tokens.
     * The query may not contain any comments.
     *
     * @param  string $queryString Query to split into tokens
     *
     * @return array Tokens
     */
    public static function tokenize($queryString) 
    {
        $queryString  = trim($queryString);

        $removeableSpecialChars = array(' ', "\t", "\r", "\n");
        $specialChars           = array(',', '\\', '(', ')', '{', '}', '"', "'", ';', '[', ']');
        
        $len          = strlen($queryString);
        $tokens       = array();
        $n            = 0;
        
        for ($i=0; $i<$len; ++$i) {
            if (in_array($queryString{$i}, $removeableSpecialChars)) {        
                if (isset($tokens[$n])) {
                    $n++;
                }
                
                continue;
            } else if (in_array($queryString{$i}, $specialChars)) {
                if (isset($tokens[$n])) {
                    $n++;
                } 

                $tokens[$n++] = $queryString{$i};
            } else {
                if (!isset($tokens[$n])) {
                    $tokens[$n] = '';
                }
                
                $tokens[$n] .= $queryString{$i};
            }
        }
        
        return $tokens;
    }

    /**
     * Removes comments in the query string. Comments are
     * indicated by '#'.
     *
     * @param  String $queryString
     * @return String The uncommented query string
     */
    public static function uncomment($queryString)
    {
// TODO better way?
        $regex = "/((\"[^\"]*\")|(\'[^\']*\')|(\<[^\>]*\>))|(#.*)/";
        
        return preg_replace($regex, '\1', $queryString);
    }

    /** Starts parsing the tokenized SPARQL Query. */
    protected function _parseQuery() 
    {
        do {
            switch (strtolower(current($this->_tokens))) {
                case 'base':
                    $this->_parseBase();
                    break;
                case 'prefix':
                    $this->_parsePrefix();
                    break;
                case 'select':
                    $this->_parseSelect();
                    break;
                case 'describe':
                    $this->_parseDescribe();
                    break;
                case 'ask':
                    $this->_parseAsk('ask');
                    break;
                case 'count':
                    $this->_parseAsk('count');
                    break;
                case 'from':
                    $this->_parseFrom();
                    break;
                case 'construct':
                    $this->_parseConstruct();
                    break;
                case 'where':
                    $this->_parseWhere();
                    $this->_parseModifier();
                    break;
                case '{':
                    prev($this->_tokens);
                    $this->_parseWhere();
                    $this->_parseModifier();
                    break;
            }
        } while (next($this->_tokens));
    }

// TODO clean up from here

    /**
    * Parses the BASE part of the query.
    *
    * @return void
    * @throws SparqlParserException
    */
    protected function _parseBase()
    {
        $this->_fastForward();
        if ($this->iriCheck(current($this->_tokens))) {
            $this->_query->setBase(current($this->_tokens));
        } else {
            $msg = current($this->_tokens);
            $msg = preg_replace('/</', '&lt;', $msg);
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException(
                "IRI expected",
                null,
                key($this->_tokens)
            );
        }
    }



    /**
    * Adds a new namespace prefix to the query object.
    *
    * @return void
    * @throws SparqlParserException
    */
    protected function _parsePrefix()
    {
        $this->_fastForward();
        $prefix = substr(current($this->_tokens), 0, -1);
        $this->_fastForward();
        if ($this->iriCheck(current($this->_tokens))) {
            $uri = substr(current($this->_tokens), 1, -1);
            $this->_query->addPrefix($prefix, $uri);
        } else {
            $msg = current($this->_tokens);
            $msg = preg_replace('/</', '&lt;', $msg);
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException(
                "IRI expected",
                null,
                key($this->_tokens)
            );
        }
    }



    /**
    * Parses the SELECT part of a query.
    *
    * @return void
    * @throws SparqlParserException
    */
    protected function _parseSelect()
    {
        $this->_fastForward();
        $curLow = strtolower(current($this->_tokens));
        prev($this->_tokens);
        if ($curLow == 'distinct') {
            $this->_query->setResultForm('select distinct');
        } else {
            $this->_query->setResultForm('select');
        }

        $currentVar = null;
        $currentFunc = null;
        $bWaitForRenaming = false;
        while ($curLow != 'from' && $curLow != 'where' &&
               $curLow != "{"
        ){
            $this->_fastForward();
            $curTok = current($this->_tokens);
            $curLow = strtolower($curTok);

            if ($this->varCheck($curTok) || $curLow == '*') {
                if ($bWaitForRenaming) {
                    $bWaitForRenaming = false;
                    $currentVar->setAlias($curTok);
                    if ($currentFunc != null) {
                        $currentVar->setFunc($currentFunc);
                    }
                    $this->_query->addResultVar($currentVar);
                    $currentVar = null;
                } else {
                    if ($currentVar != null) {
                        $this->_query->addResultVar($currentVar);
                        $currentVar = null;
                    }
                    require_once 'Erfurt/Sparql/QueryResultVariable.php';
                    $currentVar = new Erfurt_Sparql_QueryResultVariable($curTok);
                    if ($currentFunc != null) {
                        $currentVar->setFunc($currentFunc);
                    }
                }
                $currentFunc = null;
            } else if ($curLow == 'as') {
                if ($currentVar === null) {
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException(
                        'AS requires a variable left and right',
                        null,
                        key($this->_tokens)
                    );
                }
                $bWaitForRenaming = true;
            } else if (in_array($curLow, self::$_sops)) {
                $currentFunc = $curLow;
            }

            if (!current($this->_tokens)) {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException(
                    "Unexpected end of File.",
                    null,
                    key($this->_tokens)
                );
            }
        }

        if ($currentVar != null) {
            $this->_query->addResultVar($currentVar);
        }
        prev($this->_tokens);

        if (count($this->_query->getResultVars()) == 0) {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException(
                "Variable or '*' expected.",
                null,
                key($this->_tokens)
            );
        }
    }//protected function parseSelect()


    /**
    * Adds a new variable to the query and sets result form to 'DESCRIBE'.
    *
    * @return void
    */
    protected function _parseDescribe()
    {
        while(strtolower(current($this->_tokens))!='from'& strtolower(current($this->_tokens))!='where'){
            $this->_fastForward();
            if($this->varCheck(current($this->_tokens))|$this->iriCheck(current($this->_tokens))){
                $this->_query->addResultVar(current($this->_tokens));
                if(!$this->_query->getResultForm())
                    $this->_query->setResultForm('describe');
            }
            if(!current($this->_tokens))
            break;
        }
        prev($this->_tokens);
    }

    /**
    * Sets result form to 'ASK' and 'COUNT'.
    *
    * @param string $form  if it's an ASK or COUNT query
    * @return void
    */
    protected function _parseAsk($form){
        
        $this->_query->setResultForm($form);
        $this->_fastForward();
        if(current($this->_tokens)=="{")
            $this->_rewind();
        $this->_parseWhere();
        $this->_parseModifier();
    }

    /**
    * Parses the FROM clause.
    *
    * @return void
    * @throws SparqlParserException
    */
    protected function _parseFrom(){
    
        $this->_fastForward();
        if (strtolower(current($this->_tokens)) != 'named') {
            if ($this->iriCheck(current($this->_tokens)) || $this->qnameCheck(current($this->_tokens))) {
                $this->_query->addFrom(substr(current($this->_tokens), 1, -1));
            } else if ($this->varCheck(current($this->_tokens))) {
                $this->_query->addFrom(current($this->_tokens));
            } else {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException("Variable, Iri or qname expected in FROM ",null,key($this->_tokens));
            }
        } else{
            $this->_fastForward();
            if($this->iriCheck(current($this->_tokens))||$this->qnameCheck(current($this->_tokens))){
                $this->_query->addFromNamed(substr(current($this->_tokens),1,-1));
            }else if($this->varCheck(current($this->_tokens))){
                $this->_query->addFromNamed(current($this->_tokens));
            } else {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException("Variable, Iri or qname expected in FROM NAMED ",null,key($this->_tokens));
            }
        }
    }


    /**
    * Parses the CONSTRUCT clause.
    *
    * @return void
    * @throws SparqlParserException
    */
    protected function _parseConstruct(){
        $this->_fastForward();
        $this->_query->setResultForm('construct');
        if(current($this->_tokens)=="{"){
            $this->parseGraphPattern(false,false,false,true);
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException("Unable to parse CONSTRUCT part. '{' expected. ",null,key($this->_tokens));
        }
        $this->_parseWhere();
        $this->_parseModifier();
    }


    /**
    * Parses the WHERE clause.
    *
    * @return void
    * @throws SparqlParserException
    */
    protected function _parseWhere(){
        $this->_fastForward();
        if(current($this->_tokens)=="{"){
            $this->parseGraphPattern();
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException("Unable to parse WHERE part. '{' expected in Query. ",null,key($this->_tokens));
        }
    }



    /**
    * Checks if $token is a variable.
    *
    * @param  String  $token The token
    * @return boolean TRUE if the token is a variable false if not
    */
    protected function varCheck($token)
    {
        if (isset($token[0]) && ($token{0} == '$' || $token{0} == '?')) {
            $this->_query->addUsedVar($token);
            return true;
        }
        return false;
    }

    /**
    * Checks if $token is an IRI.
    *
    * @param  String  $token The token
    * @return boolean TRUE if the token is an IRI false if not
    */
    protected function iriCheck($token){
        $pattern="/^<[^>]*>\.?$/";
        if(preg_match($pattern,$token)>0)
        return true;
        return false;
    }


    /**
    * Checks if $token is a Blanknode.
    *
    * @param  String  $token The token
    * @return boolean TRUE if the token is BNode false if not
    */
    protected function bNodeCheck($token){
        if($token{0} == "_")
        return true;
        else
        return false;
    }


    /**
    * Checks if $token is a qname.
    *
    * @param  String  $token The token
    * @return boolean TRUE if the token is a qname false if not
    * @throws SparqlParserException
    */
    protected function qnameCheck($token)
    {
        $pattern="/^([^:^\<]*):([^:]*)$/";
        if (preg_match($pattern,$token,$hits)>0) {
            $prefs = $this->_query->getPrefixes();
            if (isset($prefs{$hits{1}})) {
                return true;
            }
            if ($hits{1} == "_") {
                return true;
            }
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException("Unbound Prefix: <i>".$hits{1}."</i>",null,key($this->_tokens));
        } else {
            return false;
        }
    }



    /**
    * Checks if $token is a Literal.
    *
    * @param string $token The token
    *
    * @return boolean TRUE if the token is a Literal false if not
    */
    protected function literalCheck($token)
    {
        $pattern = "/^[\"\'].*$/";
        if (preg_match($pattern,$token) > 0) {
            return true;
        }
        return false;
    }//protected function literalCheck($token)



    /**
    * FastForward until next token which is not blank.
    *
    * @return void
    */
    protected function _fastForward()
    {
        next($this->_tokens);
        #while(current($this->_tokens)==" " | current($this->_tokens)==chr(10) | current($this->_tokens)==chr(13) | current($this->_tokens)==chr(9)){
        #    next($this->_tokens);
        #}
    }//protected function _fastForward()



    /**
    * Rewind until next token which is not blank.
    *
    * @return void
    */
    protected function _rewind()
    {
        prev($this->_tokens);
        #while(current($this->_tokens)==" "|current($this->_tokens)==chr(10)|current($this->_tokens)==chr(13)|current($this->_tokens)==chr(9)){
        #    prev($this->_tokens);
        #}
        #return;
    }//protected function _rewind()



    /**
    * Parses a graph pattern.
    *
    * @param  int     $optional Optional graph pattern
    * @param  int     $union    Union graph pattern
    * @param  string  $graph    Graphname
    * @param  boolean $constr   TRUE if the pattern is a construct pattern
    * @param  boolean $external If the parsed pattern shall be returned
    * @param  int     $subpattern If the new pattern is subpattern of the
    *                               pattern with the given id
    * @return void
    */
    protected function parseGraphPattern(
      $optional = false, $union    = false, $graph = false,
      $constr   = false, $external = false, $subpattern = false
    ){
        $pattern = $this->_query->getNewPattern($constr);
        if (is_int($optional)) {
            $pattern->setOptional($optional);
        } else {
            $this->_tmp = $pattern->getId();
        }
        if (is_int($union)) {
            $pattern->setUnion($union);
        }
        if (is_int($subpattern)) {
            $pattern->setSubpatternOf($subpattern);
        }
        if ($graph != false) {
            $pattern->setGraphname($graph);
        }

        $this->_fastForward();

        do {
            switch (strtolower(current($this->_tokens))) {
                case "graph":
                    $this->parseGraph();
                    break;
                case "union":
                    $this->_fastForward();
                    $this->parseGraphPattern(
                        false, $this->_tmp, false, false, false, $subpattern
                    );
                    break;
                case "optional":
                    $this->_fastForward();
                    $this->parseGraphPattern(
                        $this->_tmp, false, false, false, false, $subpattern
                    );
                    break;
                case "filter":
                    $this->parseConstraint(
                        $pattern, true, false, false, false, $subpattern
                    );
                    $this->_fastForward();
                    break;
                case ".":
                    $this->_fastForward();
                    break;
                case "{":
                    if (!is_int($subpattern)) {
                        $subpattern = $pattern->getId();
                    }

                    $this->parseGraphPattern(
                        false, false, false, false, false, $subpattern
                    );
                    break;
                case "}":
                    $pattern->open = false;
                    break;
                default:
                    $this->parseTriplePattern($pattern);
                    break;
            }
        } while ($pattern->open);

        if ($external) {
            return $pattern;
        }
        $this->_fastForward();
    }

    /**
    * Parses a triple pattern.
    *
    * @param  GraphPattern $pattern
    * @return void
    */
    protected function parseTriplePattern(&$pattern)
    {
        $trp      = array();
        $prev     = false;
        $prevPred = false;
        $cont     = true;
        $sub      = "";
        $pre      = "";
        $tmp      = "";
        $tmpPred  = "";
        $obj      = "";
        do {
//echo strtolower(current($this->_tokens)) . "\n";
            switch (strtolower(current($this->_tokens))) {
                case false:
                    $cont          = false;
                    $pattern->open = false;
                    break;
                case "filter":
                    $this->parseConstraint($pattern,false);
                    $this->_fastForward();
                    break;
                case "optional":
                    $this->_fastForward();
                    $this->parseGraphPattern($pattern->getId(),false);
                    //$cont = false;
                    break;
                case "union":
                    $this->_fastForward();
                    $this->parseGraphPattern(
                        false, $this->_tmp, false, false, false, $pattern->getId()
                    );
                    break;
                case ";":
                    $prev = true;
                    $this->_fastForward();
                    break;
                case ".":
                    $prev = false;
                    $this->_fastForward();
                    break;
                case "graph":
                    $this->parseGraph();
                    break;
                case ",":
                    $prev     = true;
                    $prevPred = true;
                    $this->_fastForward();
                    break;
                case "}":
                    $prev = false;
                    $pattern->open = false;
                    $cont = false;
                    break;
                case '{':
                    //subpatterns opens
                    $this->parseGraphPattern(
                        false, false, false, false, false, $pattern->getId()
                    );
                    break;
                case "[":
                    $prev = true;
                    $tmp  = $this->parseNode($this->_query->getBlanknodeLabel());
                    $this->_fastForward();
                    break;
                case "]":
                    $prev = true;
                    $this->_fastForward();
                    break;
                case "(":
                    $prev = true;
                    $tmp = $this->parseCollection($trp);
                    $this->_fastForward();
                    break;
                case false:
                    $cont = false;
                    $pattern->open = false;
                    break;
                default:
                    if ($prev) {
                        $sub = $tmp;
                    } else {
                        $sub = $this->parseNode();
                        $this->_fastForward();
                        $tmp     = $sub;
                    }
                    if ($prevPred) {
                        $pre = $tmpPred;
                    } else {
                        $pre = $this->parseNode();
                        $this->_fastForward();
                        $tmpPred = $pre;
                    }
                    if (current($this->_tokens)=="[") {
                        $tmp  = $this->parseNode($this->_query->getBlanknodeLabel());
                        $prev = true;
                        $obj = $tmp;
                    } else if (current($this->_tokens)=="(") {
                        $obj = $this->parseCollection($trp);
                    } else {
                        $obj = $this->parseNode();
                    }
                    
                    require_once 'Erfurt/Sparql/QueryTriple.php';
                    $trp[] = new Erfurt_Sparql_QueryTriple($sub, $pre, $obj);
                    $this->_fastForward();
                    break;

            }
        } while ($cont);

        if (count($trp) > 0) {
            $pattern->addTriplePatterns($trp);
        }
    }



    /**
    * Parses a value constraint.
    *
    * @param GraphPattern $pattern
    * @param boolean $outer     If the constraint is an outer one.
    * @return void
    */
    protected function parseConstraint(&$pattern, $outer)
    {
        require_once 'Erfurt/Sparql/Constraint.php';
        $constraint = new Erfurt_Sparql_Constraint();
        $constraint->setOuterFilter($outer);
        $this->_fastForward();
        $this->_rewind();
        $nBeginKey = key($this->_tokens);
        $constraint->setTree(
            $t = $this->parseConstraintTree()
        );

        $nEndKey = key($this->_tokens);
        if (current($this->_tokens) == '}') {
            prev($this->_tokens);
        }

        //for backwards compatibility with the normal sparql engine
        // which does not use the tree array currently
        $expression = trim(implode(
            '',
            array_slice(
                    $this->_tokens,
                    $nBeginKey + 1,
                    $nEndKey - $nBeginKey - 1
            )
        ));
        if ($expression[0] == '(' && substr($expression, -1) == ')') {
            $expression = trim(substr($expression, 1, -1));
        }
        $constraint->addExpression($expression);

        $pattern->addConstraint($constraint);
    }//protected function parseConstraint(&$pattern, $outer)



    /**
    *   Parses a constraint string recursively.
    *
    *   The result array is one "element" which may contain subelements.
    *   All elements have one key "type" that determines which other
    *   array keys the element array has. Valid types are:
    *   - "value":
    *       Just a plain value with a value key, nothing else
    *   - "function"
    *       A function has a name and an array of parameter(s). Each parameter
    *       is an element.
    *   - "equation"
    *       An equation has an operator, and operand1 and operand2 which
    *       are elements themselves
    *   Any element may have the "negated" value set to true, which means
    *   that is is - negated (!).
    *
    *   @internal The functionality of this method is being unit-tested
    *   in testSparqlParserTests::testParseFilter()
    *   "equation'-elements have another key "level" which is to be used
    *   internally only.
    *
    *   @return array Nested tree array representing the filter
    */
    protected function parseConstraintTree($nLevel = 0, $bParameter = false)
    {
        $tree       = array();
        $part       = array();
        $chQuotes   = null;
        $litQuotes  = null;
        $strQuoted  = '';

        while ($tok = next($this->_tokens)) {
//var_dump(array($tok, $tok[strlen($tok) - 1]));
            if ($chQuotes !== null && $tok != $chQuotes) {
                $strQuoted .= $tok;
                continue;
            } else if ($litQuotes !== null) {
                $strQuoted .= $tok;
                if ($tok[strlen($tok) - 1] == '>') {
                    $tok = '>';
                } else {
                    continue;
                }
            } else if ($tok == ')' || $tok == '}' || $tok == '.') {
                break;
            }

            switch ($tok) {
                case '"':
                case '\'':
                    if ($chQuotes === null) {
                        $chQuotes  = $tok;
                        $strQuoted = '';
                    } else {
                        $chQuotes = null;
                        $part[] = array(
                            'type'  => 'value',
                            'value' => $strQuoted,
                            'quoted'=> true
                        );
                    }
                    continue 2;
                    break;

                case '>':
                    $litQuotes = null;
                    $part[] = array(
                        'type'  => 'value',
                        'value' => $strQuoted,
                        'quoted'=> false
                    );
                    continue 2;
                    break;

                case '(':
                    $bFunc1 = isset($part[0]['type']) && $part[0]['type'] == 'value';
                    $bFunc2 = isset($tree['type'])    && $tree['type']    == 'equation'
                           && isset($tree['operand2']) && isset($tree['operand2']['value']);
                    $part[] = $this->parseConstraintTree(
                        $nLevel + 1,
                        $bFunc1 || $bFunc2
                    );

                    if ($bFunc1) {
                        $tree['type']       = 'function';
                        $tree['name']       = $part[0]['value'];
                        self::fixNegationInFuncName($tree);
                        if (isset($part[1]['type'])) {
                            $part[1] = array($part[1]);
                        }
                        $tree['parameter']  = $part[1];
                        $part = array();
                    } else if ($bFunc2) {
                        $tree['operand2']['type']       = 'function';
                        $tree['operand2']['name']       = $tree['operand2']['value'];
                        self::fixNegationInFuncName($tree['operand2']);
                        $tree['operand2']['parameter']  = $part[0];
                        unset($tree['operand2']['value']);
                        unset($tree['operand2']['quoted']);
                        $part = array();
                    }
                    continue 2;
                    break;

                case ' ':
                case "\t":
                    continue 2;

                case '=':
                case '>':
                case '<':
                case '<=':
                case '>=':
                case '!=':
                case '&&':
                case '||':
                    if (isset($tree['type']) && $tree['type'] == 'equation'
                        && isset($tree['operand2'])) {
                        //previous equation open
                        $part = array($tree);
                    } else if (isset($tree['type']) && $tree['type'] != 'equation') {
                        $part = array($tree);
                        $tree = array();
                    }
                    $tree['type']       = 'equation';
                    $tree['level']      = $nLevel;
                    $tree['operator']   = $tok;
                    $tree['operand1']   = $part[0];
                    unset($tree['operand2']);
                    $part = array();
                    continue 2;
                    break;

                case '!':
                    if ($tree != array()) {
                        throw new SparqlParserException(
                            'Unexpected "!" negation in constraint.'
                        );
                    }
                    $tree['negated'] = true;
                    continue 2;

                case ',':
                    //parameter separator
                    if (count($part) == 0 && !isset($tree['type'])) {
                        throw new SparqlParserException(
                            'Unexpected comma'
                        );
                    }
                    $bParameter = true;
                    if (count($part) == 0) {
                        $part[] = $tree;
                        $tree = array();
                    }
                    continue 2;

                default:
                    break;
            }

            if ($this->varCheck($tok)) {
                $part[] = array(
                    'type'      => 'value',
                    'value'     => $tok,
                    'quoted'    => false
                );
            } else if (substr($tok, 0, 2) == '^^') {
                $part[count($part) - 1]['datatype']
                    = $this->_query->getFullUri(substr($tok, 2));
            } else if ($tok[0] == '@') {
                $part[count($part) - 1]['language'] = substr($tok, 1);
            } else if ($tok[0] == '<') {
                if ($tok[strlen($tok) - 1] == '>') {
                    //single-tokenized <> uris
                    $part[] = array(
                        'type'      => 'value',
                        'value'     => $tok,
                        'quoted'    => false
                    );
                } else {
                    //iris split over several tokens
                    $strQuoted = $tok;
                    $litQuotes = true;
                }
            } else if ($tok == 'true' || $tok == 'false') {
                $part[] = array(
                    'type'      => 'value',
                    'value'     => $tok,
                    'quoted'    => false,
                    'datatype'  => 'http://www.w3.org/2001/XMLSchema#boolean'
                );
            } else {
                $part[] = array(
                    'type'      => 'value',
                    'value'     => $tok,
                    'quoted'    => false
                );
            }

            if (isset($tree['type']) && $tree['type'] == 'equation' && isset($part[0])) {
                $tree['operand2'] = $part[0];
                self::balanceTree($tree);
                $part = array();
            }
        }

        if (!isset($tree['type']) && $bParameter) {
            return $part;
        } else if (isset($tree['type']) && $tree['type'] == 'equation'
            && isset($tree['operand1']) && !isset($tree['operand2'])
            && isset($part[0])) {
            $tree['operand2'] = $part[0];
            self::balanceTree($tree);
        }

        if (!isset($tree['type']) && isset($part[0])) {
            if (isset($tree['negated'])) {
                $part[0]['negated'] = true;
            }
            return $part[0];
        }

        return $tree;
    }//protected function parseConstraintTree($nLevel = 0, $bParameter = false)



    /**
    *   "Balances" the filter tree in the way that operators on the same
    *   level are nested according to their precedence defined in
    *   $operatorPrecedence array.
    *
    *   @param array $tree  Tree to be modified
    */
    protected static function balanceTree(&$tree)
    {
        if (
            isset($tree['type']) && $tree['type'] == 'equation'
         && isset($tree['operand1']['type']) && $tree['operand1']['type'] == 'equation'
         && $tree['level'] == $tree['operand1']['level']
         && self::$_operatorPrecedence[$tree['operator']] > self::$_operatorPrecedence[$tree['operand1']['operator']]
        ) {
            $op2 = array(
                'type'      => 'equation',
                'level'     => $tree['level'],
                'operator'  => $tree['operator'],
                'operand1'  => $tree['operand1']['operand2'],
                'operand2'  => $tree['operand2']
            );
            $tree['operator']   = $tree['operand1']['operator'];
            $tree['operand1']   = $tree['operand1']['operand1'];
            $tree['operand2']   = $op2;
        }
    }//protected static function balanceTree(&$tree)



    protected static function fixNegationInFuncName(&$tree)
    {
        if ($tree['type'] == 'function' && $tree['name'][0] == '!') {
            $tree['name'] = substr($tree['name'], 1);
            if (!isset($tree['negated'])) {
                $tree['negated'] = true;
            } else {
                unset($tree['negated']);
            }
            //perhaps more !!
            self::fixNegationInFuncName($tree);
        }
    }//protected static function fixNegationInFuncName(&$tree)



    /**
    * Parses a bracketted expression.
    *
    * @param  Constraint $constraint
    * @return void
    * @throws SparqlParserException
    */
    protected function parseBrackettedExpression(&$constraint)
    {
        $open = 1;
        $exp = "";
        $this->_fastForward();
        while ($open != 0 && current($this->_tokens)!= false) {
            switch (current($this->_tokens)) {
                case "(":
                    $open++;
                    $exp = $exp . current($this->_tokens);
                    break;
                case ")":
                    $open--;
                    if($open != 0){
                        $exp = $exp . current($this->_tokens);
                    }
                    break;
                case false:
                    throw new SparqlParserException(
                        "Unexpected end of query.",
                        null,
                        key($this->_tokens)
                    );
                default:
                    $exp = $exp . current($this->_tokens);
                    break;
            }
            next($this->_tokens);
        }
        $constraint->addExpression($exp);
    }


    /**
    * Parses an expression.
    *
    * @param  Constraint  $constrain
    * @return void
    * @throws SparqlParserException
    */
    protected function parseExpression(&$constraint)
    {
        $exp = "";
        while (current($this->_tokens) != false && current($this->_tokens) != "}") {
            switch (current($this->_tokens)) {
                case false:
                    throw new SparqlParserException(
                        "Unexpected end of query.",
                        null,
                        key($this->_tokens)
                    );
                case ".":
                    break;
                    break;
                default:
                    $exp = $exp . current($this->_tokens);
                    break;
            }
            next($this->_tokens);
        }
        $constraint->addExpression($exp);
    }

    /**
    * Parses a GRAPH clause.
    *
    * @param  GraphPattern $pattern
    * @return void
    * @throws SparqlParserException
    */
    protected function parseGraph(){
        $this->_fastForward();
        $name = current($this->_tokens);
        if(!$this->varCheck($name)&!$this->iriCheck($name)&&!$this->qnameCheck($name)){
            $msg = $name;
            $msg = preg_replace('/</', '&lt;', $msg);
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException(" IRI or Var expected. ",null,key($this->_tokens));
        }
        $this->_fastForward();

        if($this->iriCheck($name)){
            require_once 'Erfurt/Rdf/Resource.php';
            $name = Erfurt_Rdf_Resource::initWithIri(substr($name,1,-1));
        }else if($this->qnameCheck($name)){
            require_once 'Erfurt/Rdf/Resource.php';
            $name =  Erfurt_Rdf_Resource::initWithIri($this->_query->getFullUri($name));
        }
        $this->parseGraphPattern(false,false,$name);
        if(current($this->_tokens)=='.')
        $this->_fastForward();
    }

    /**
    * Parses the solution modifiers of a query.
    *
    * @return void
    * @throws SparqlParserException
    */
    protected function _parseModifier(){
        do{
            switch(strtolower(current($this->_tokens))){
                case "order":
                $this->_fastForward();
                if(strtolower(current($this->_tokens))=='by'){
                    $this->_fastForward();
                    $this->parseOrderCondition();
                } else {
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException("'BY' expected.",null,key($this->_tokens));
                }
                break;
                case "limit":
                $this->_fastForward();
                $val = current($this->_tokens);
                $this->_query->setSolutionModifier('limit',$val);
                break;
                case "offset":
                $this->_fastForward();
                $val = current($this->_tokens);
                $this->_query->setSolutionModifier('offset',$val);
                break;
                default:
                break;
            }
        }while(next($this->_tokens));
    }

    /**
    * Parses order conditions of a query.
    *
    * @return void
    * @throws SparqlParserException
    */
    protected function parseOrderCondition(){
        $valList = array();
        $val = array();
        while(strtolower(current($this->_tokens))!='limit'
        & strtolower(current($this->_tokens))!= false
        & strtolower(current($this->_tokens))!= 'offset'){
            switch (strtolower(current($this->_tokens))){
                case "desc":
                $this->_fastForward();
                $this->_fastForward();
                if($this->varCheck(current($this->_tokens))){
                    $val['val'] = current($this->_tokens);
                } else {
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException("Variable expected in ORDER BY clause. ",null,key($this->_tokens));
                }
                $this->_fastForward();
                if(current($this->_tokens)!=')') {
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException("missing ')' in ORDER BY clause.",null,key($this->_tokens));
                }
                
                $val['type'] = 'desc';
                $this->_fastForward();
                break;
                case "asc" :
                $this->_fastForward();
                $this->_fastForward();
                if($this->varCheck(current($this->_tokens))){
                    $val['val'] = current($this->_tokens);
                } else {
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException("Variable expected in ORDER BY clause. ",null,key($this->_tokens));
                }
                $this->_fastForward();
                if(current($this->_tokens)!=')') {
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException("missing ')' in ORDER BY clause.",null,key($this->_tokens));
                }
                
                $val['type'] = 'asc';
                $this->_fastForward();
                break;
                default:
                if($this->varCheck(current($this->_tokens))){
                    $val['val'] = current($this->_tokens);
                    $val['type'] = 'asc';
                } else {
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException("Variable expected in ORDER BY clause.", null, key($this->_tokens));
                }
                $this->_fastForward();
                break;
            }
            $valList[] = $val;
        }
        prev($this->_tokens);
        $this->_query->setSolutionModifier('order by',$valList);
    }

    /**
    * Parses a String to an RDF node.
    *
    * @param  String $node
    *
    * @return Node   The parsed RDF node
    * @throws SparqlParserException
    */
    protected function parseNode($node = false)
    {
        //$eon = false;
        if ($node) {
            $node = $node;
        } else {
            $node = current($this->_tokens);
        }
        if ($node{strlen($node)-1} == '.') {
            $node = substr($node,0,-1);
        }
        if ($this->dtypeCheck($node)) {
            return $node;
        }
        if ($this->bNodeCheck($node)) {
            $node = '?'.$node;
            $this->_query->addUsedVar($node);
            return $node;
        }
        if ($node == '[') {
            $node = '?' . substr($this->_query->getBlanknodeLabel(), 1);
            $this->_query->addUsedVar($node);
            $this->_fastForward();
            if(current($this->_tokens)!=']') {
                prev($this->_tokens);
            }
            return $node;
        }
        if ($this->iriCheck($node)){
            $base = $this->_query->getBase();
            if ($base!=null) {
                require_once 'Erfurt/Rdf/Resource.php';
                $node = Erfurt_Rdf_Resource::initWithNamespaceAndLocalName(substr($base, 1, -1), substr($node, 1, -1));
            } else {
                require_once 'Erfurt/Rdf/Resource.php';
                $node = Erfurt_Rdf_Resource::initWithIri(substr($node, 1, -1));
            }
            return $node;
        } else if ($this->qnameCheck($node)) {
            $node = $this->_query->getFullUri($node);
            require_once 'Erfurt/Rdf/Resource.php';
            $node = Erfurt_Rdf_Resource::initWithIri($node);
            return $node;
        } else if ($this->literalCheck($node)) {
            $ch     = substr($node, 0, 1);
            $chLong = str_repeat($ch, 3);
            if (substr($node, 0, 3) == $chLong) {
                $ch = $chLong;
            }
            $this->parseLiteral($node, $ch);
        } else if ($this->varCheck($node)) {
            $pos = strpos($node,'.');
            if ($pos) {
                return substr($node,0,$pos);
            } else {
                return $node;
            }
        } else if ($node[0] == '<') {
            //partial IRI? loop tokens until we find a closing >
            while (next($this->_tokens)) {
                $node .= current($this->_tokens);
                if (substr($node, -1) == '>') {
                    break;
                }
            }
            if (substr($node, -1) != '>') {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException(
                    "Unclosed IRI: " . $node,
                    null,
                    key($this->_tokens)
                );
            }
            return $this->parseNode($node);
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException(
                '"' . $node . '" is neither a valid rdf- node nor a variable.',
                null,
                key($this->_tokens)
            );
        }
        return $node;
    }//protected function parseNode($node = false)



    /**
    * Checks if there is a datatype given and appends it to the node.
    *
    * @param string $node Node to check
    *
    * @return void
    */
    protected function checkDtypeLang(&$node, $nSubstrLength = 1)
    {
        $this->_fastForward();
        switch (substr(current($this->_tokens), 0, 1)) {
            case '^':
                if (substr(current($this->_tokens),0,2)=='^^') {
                    require_once 'Erfurt/Rdf/Literal.php';
                    $node = Erfurt_Rdf_Literal::initWithLabel(substr($node, 1, -1));
                    $node->setDatatype(
                        $this->_query->getFullUri(
                            substr(current($this->_tokens), 2)
                        )
                    );
                }
                break;
            case '@':
                require_once 'Erfurt/Rdf/Literal.php';
                $node = Erfurt_Rdf_Literal::initWithLabelAndLanguage(
                    substr($node, $nSubstrLength, -$nSubstrLength),
                    substr(current($this->_tokens), $nSubstrLength)
                );
                break;
            default:
                prev($this->_tokens);
                require_once 'Erfurt/Rdf/Literal.php';
                $node = Erfurt_Rdf_Literal::initWithLabel(substr($node, $nSubstrLength, -$nSubstrLength));
                break;

        }
    }//protected function checkDtypeLang(&$node, $nSubstrLength = 1)



    /**
    * Parses a literal.
    *
    * @param String $node
    * @param String $sep used separator " or '
    *
    * @return void
    */
    protected function parseLiteral(&$node, $sep)
    {
        do {
            next($this->_tokens);
            $node = $node.current($this->_tokens);
        } while (current($this->_tokens) != $sep);
        $this->checkDtypeLang($node, strlen($sep));
    }//protected function parseLiteral(&$node, $sep)



    /**
    * Checks if the Node is a typed Literal.
    *
    * @param String $node
    *
    * @return boolean TRUE if typed FALSE if not
    */
    protected function dtypeCheck(&$node)
    {
        $patternInt = "/^-?[0-9]+$/";
        $match = preg_match($patternInt,$node,$hits);
        if($match>0){
            require_once 'Erfurt/Rdf/Literal.php';
            $node = Erfurt_Rdf_Literal::initWithLabel($hits[0]);
            $node->setDatatype(EF_XSD_NS.'integer');
            return true;
        }
        $patternBool = "/^(true|false)$/";
        $match = preg_match($patternBool,$node,$hits);
        if($match>0){
            require_once 'Erfurt/Rdf/Literal.php';
            $node = Erfurt_Rdf_Literal::initWithLabel($hits[0]);
            $node->setDatatype(EF_XSD_NS.'boolean');
            return true;
        }
        $patternType = "/^a$/";
        $match = preg_match($patternType,$node,$hits);
        if($match>0){
            require_once 'Erfurt/Rdf/Resource.php';
            $node = Erfurt_Rdf_Resource::initWithNamespaceAndLocalName(EF_RDF_NS, 'type');
            return true;
        }
        $patternDouble = "/^-?[0-9]+.[0-9]+[e|E]?-?[0-9]*/";
        $match = preg_match($patternDouble,$node,$hits);
        if($match>0){
            require_once 'Erfurt/Rdf/Literal.php';
            $node = Erfurt_Rdf_Literal::initWithLabel($hits[0]);
            $node->setDatatype(EF_XSD_NS.'double');
            return true;
        }
        return false;
    }//protected function dtypeCheck(&$node)



    /**
    * Parses an RDF collection.
    *
    * @param  TriplePattern $trp
    *
    * @return Node          The first parsed label
    */
    protected function parseCollection(&$trp)
    {
        $tmpLabel = $this->_query->getBlanknodeLabel();
        $firstLabel = $this->parseNode($tmpLabel);
        $this->_fastForward();
        $i = 0;
        require_once 'Erfurt/Sparql/QueryTriple.php';
        while (current($this->_tokens)!=")") {
            if($i>0)
            $trp[] = new QueryTriple($this->parseNode($tmpLabel),new Resource("http://www.w3.org/1999/02/22-rdf-syntax-ns#rest"),$this->parseNode($tmpLabel = $this->_query->getBlanknodeLabel()));
            $trp[] = new QueryTriple($this->parseNode($tmpLabel),new Resource("http://www.w3.org/1999/02/22-rdf-syntax-ns#first"),$this->parseNode());
            $this->_fastForward();
            $i++;
        }
        $trp[] = new QueryTriple($this->parseNode($tmpLabel),new Resource("http://www.w3.org/1999/02/22-rdf-syntax-ns#rest"),new Resource("http://www.w3.org/1999/02/22-rdf-syntax-ns#nil"));
        return $firstLabel;
    }//protected function parseCollection(&$trp)

}// end class: SparqlParser.php

?>