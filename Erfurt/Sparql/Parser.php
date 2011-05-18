<?php
/**
 * Parses a SPARQL Query string and returns a Erfurt_Sparql_Query Object.
 *
 * This class was originally adopted from rdfapi-php (@link http://sourceforge.net/projects/rdfapi-php/).
 * It was modified and extended in order to fit into Erfurt.
 *
 * @package erfurt
 * @subpackage sparql
 * @author Tobias Gauss <tobias.gauss@web.de>
 * @author Christian Weiske <cweiske@cweiske.de>
 * @author Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @version	$Id: Parser.php 4181 2009-09-22 15:46:24Z jonas.brekle@gmail.com $
 */
class Erfurt_Sparql_Parser 
{
    // ------------------------------------------------------------------------
    // --- Protected static properties ----------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Which order operators are to be treated (11.3 Operator Mapping).
     *  
     * @var array
     */
    protected static $_operatorPrecedence = array(
        '||' => 0,
        '&&' => 1,
        '='  => 2,
        '!=' => 3,
        '<'  => 4,
        '>'  => 5,
        '<=' => 6,
        '>=' => 7,
        '*'  => 0,
        '/'  => 0,
        '+'  => 0,
        '-'  => 0,
    );
    
    /**
     * Operators introduced by sparql.
     *
     * @var array
     */
    protected static $_sops = array('regex', 'bound', 'isuri', 'isblank',
        'isliteral', 'str', 'lang', 'datatype', 'langmatches'
    );
    
    // ------------------------------------------------------------------------
    // --- Protected properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /** 
     * The query object. 
     *
     * @var Erfurt_Sparql_Query 
     */
    protected $_query;

    /**
     * Last parsed graphPattern.
     *
     * @var int
     */
    protected $_tmp;

    /**
     * The tokenized query.
     *
     * @var array
     */
    protected $_tokens = array();

    /**
     * Contains blank node ids as key and an boolean value as value.
     * This array is used in order to invalidate used blank node ids in some
     * cases.
     */
    protected $_usedBlankNodes = array();

    // ------------------------------------------------------------------------
    // --- Public static methods ----------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Tokenizes the query string into $tokens.
     * The query may not contain any comments.
     *
     * @param  string $queryString Query to split into tokens
     * @return array Tokens
     */
    public static function tokenize($queryString) 
    {
        $inTelUri = false;
        $inUri = false;
        
        $queryString = trim($queryString);

        $removeableSpecialChars = array(' ', "\t", "\r", "\n");
        $specialChars           = array(',', '\\', '(', ')', '{', '}', '"', "'", ';', '[', ']');
        
        $len    = strlen($queryString);
        $tokens = array();
        $n      = 0;
        
        $inLiteral   = false;
        $longLiteral = false;
        
        for ($i=0; $i<$len; ++$i) {
            if (in_array($queryString[$i], $removeableSpecialChars) && !$inLiteral && !$inTelUri) {        
                if (isset($tokens[$n]) && $tokens[$n] !== '') {
                    if ((strlen($tokens[$n]) >= 2)) {
                        if (($tokens[$n][strlen($tokens[$n])-1] === '.') && 
                                !is_numeric(substr($tokens[$n], 0, strlen($tokens[$n])-1))) {
                            
                            $tokens[$n] = substr($tokens[$n], 0, strlen($tokens[$n])-1);
                            $tokens[++$n] = '.';
                        } else if (($tokens[$n][0] === '.')) {
                            $dummy = substr($tokens[$n], 1);
                            $tokens[$n] = '.';
                            $tokens[++$n] = $dummy;
                        }
                    }
                    
                    $n++;
                }
                
                continue;
            } else if (in_array($queryString[$i], $specialChars) && !$inTelUri && !$inUri) {
                if ($queryString[$i] === '"' || $queryString[$i] === "'") {
                    $foundChar = $queryString[$i];
                    if (!$inLiteral) {
                        // Check for long literal
                        if (($queryString[($i+1)] === $foundChar) && ($queryString[($i+2)] === $foundChar)) {
                            $longLiteral = true;
                        }
                        
                        $inLiteral = true;
                    } else {
                        // We are inside a literal... Check whether this is the end of the literal.
                        if ($longLiteral) {
                            if (($queryString[($i+1)] === $foundChar) && ($queryString[($i+2)] === $foundChar)) {
                                $inLiteral = false;
                                $longLiteral = false;
                            }
                        } else {
                            $inLiteral = false;
                        }
                    }
                }
                
                if (isset($tokens[$n]) && ($tokens[$n] !== '')) {
                    // Check whether trailing char is a dot.
                    if ((strlen($tokens[$n]) >= 2)) {
                        if (($tokens[$n][strlen($tokens[$n])-1] === '.') && 
                                !is_numeric(substr($tokens[$n], 0, strlen($tokens[$n])-1))) {
                            
                            $tokens[$n] = substr($tokens[$n], 0, strlen($tokens[$n])-1);
                            $tokens[++$n] = '.';
                        } else if (($tokens[$n][0] === '.')) {
                            $dummy = substr($tokens[$n], 1);
                            $tokens[$n] = '.';
                            $tokens[++$n] = $dummy;
                        }
                    }
                    
                    $tokens[++$n] = '';
                } 

                // In case we have a \ in the string we add the following char to the current token.
                // In that case it doesn't matter what type of char the following one is!
                if ($queryString[$i] === '\\') {
                    // Escaped chars do not need a new token.
                    $n--;
                    
                    $tokens[$n] .= $queryString[$i] .  $queryString[++$i];
                    
                    // In case we have added \u we will also add the next 4 digits.
                    if ($queryString[$i] === 'u') {
                        $tokens[$n] .= $queryString[++$i] . $queryString[++$i]. $queryString[++$i]. $queryString[++$i];
                    }
                    
                    $n++;
                } 
                // Sparql supports literals that are written as """...""" in order to support quotation inside
                // the literal.
                else if (($queryString[$i] === '"') && ($i<($len-2)) && ($queryString[($i+1)] === '"') &&
                        ($queryString[($i+2)] === '"')) {
                    $tokens[$n++] = $queryString[$i] .  $queryString[++$i] . $queryString[++$i];
                } 
                // Sparql supports literals that are written as '''...''' in order to support quotation inside
                // the literal.
                else if (($queryString[$i] === "'") && ($i<($len-2)) && ($queryString[($i+1)] === "'") &&
                        ($queryString[($i+2)] === "'")) {
                    $tokens[$n++] = $queryString[$i] .  $queryString[++$i] . $queryString[++$i];
                } else {
                    $tokens[$n++] = $queryString[$i];
                }
            } else {
                // Special care for tel URIs
                if (substr($queryString, $i, 5) === '<tel:') {
                    $inTelUri = true;
                }
                if ($inTelUri && $queryString[$i] === '>') {
                    $inTelUri = false;
                }
                
                
                if (!isset($tokens[$n])) {
                    $tokens[$n] = '';
                }
                
                // Iris written as <><><> can be written without whitespace, so we need to test for this.
                // If yes, we need to start a new token.
                if ((substr($tokens[$n], 0, 1) === '<') && ($queryString[$i] === '>')) {
                    $tokens[$n++] .= $queryString[$i];
                    $inUri = false;
                    continue;
                } else if ($queryString[$i] === '<') {
                    $inUri = true;
                    if ($tokens[$n] === '') {
                        $tokens[$n] = '<';
                        continue;
                    } else {
                        $tokens[++$n] = '<';
                        continue;
                    }
                    
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
     * @param  string $queryString
     * @return string The uncommented query string
     */
    public static function uncomment($queryString)
    {
        $regex = "/((\"[^\"]*\")|(\'[^\']*\')|(\<[^\>]*\>))|(#.*)/";
        
        return preg_replace($regex, '\1', $queryString);
    }

    // ------------------------------------------------------------------------
    // --- Protected static methods -------------------------------------------
    // ------------------------------------------------------------------------

    /**
     *   "Balances" the filter tree in the way that operators on the same
     *   level are nested according to their precedence defined in
     *   $operatorPrecedence array.
     *
     *   @param array $tree  Tree to be modified
     */
    public static function balanceTree(&$tree)
    {

        if (isset($tree['type']) && $tree['type'] === 'equation' && isset($tree['operand1']['type']) &&
            $tree['operand1']['type'] === 'equation' && $tree['level'] === $tree['operand1']['level'] &&
            self::$_operatorPrecedence[$tree['operator']] > self::$_operatorPrecedence[$tree['operand1']['operator']]) {
            
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
    }
    
    public static function fixNegationInFuncName(&$tree)
    {
        if ($tree['type'] === 'function' && $tree['name'][0] === '!') {
            $tree['name'] = substr($tree['name'], 1);
            
            if (!isset($tree['negated'])) {
                $tree['negated'] = true;
            } else {
                unset($tree['negated']);
            }
            //perhaps more !!
            self::fixNegationInFuncName($tree);
        }
    }

    // ------------------------------------------------------------------------
    // --- Public methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Main function of Erfurt_Sparql_Parser. 
     * Parses a query string.
     *
     * @param string $queryString The SPARQL query
     * @return Erfurt_Sparql_Query The query object
     * @throws Erfurt_Sparql_ParserException
     */
    public function parse($queryString = false) 
    {
        if ($queryString === false) {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('Querystring is empty.');
        }
        //echo "Parser is called on:\n".$queryString."\n\n";
        $this->_prepare();
        $this->_query->setQueryString($queryString);

        $uncommented = self::uncomment($queryString);
        $this->_tokens = self::tokenize($uncommented);
      
        $this->_parseQuery();
            
        if (!$this->_query->isComplete()) {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('Query is incomplete.');
        }
        
        return $this->_query;
    }
    
    // ------------------------------------------------------------------------
    // --- Protected methods --------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Checks if $token is a Blanknode.
     *
     * @param  string  $token The token
     * @return boolean true if the token is BNode false if not
     */
    protected function _bNodeCheck($token)
    {
        if (substr($token, 0, 2) === '_:') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Checks if there is a datatype given and appends it to the node.
     *
     * @param string $node Node to check
     */
    protected function _checkDtypeLang(&$node, $nSubstrLength = 1)
    {
        $this->_fastForward();
        switch (substr(current($this->_tokens), 0, 1)) {
            case '^':
                if (substr(current($this->_tokens), 0, 2) === '^^') {
                    if (strlen(current($this->_tokens)) === 2) {
                        next($this->_tokens);
                    }
                    
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
    }
    
    
    protected function _dissallowBlankNodes()
    {
        foreach ($this->_usedBlankNodes as $key => &$value) {
            $value = false;
        }
    }
    
    /**
     * Checks if the Node is a typed Literal.
     *
     * @param String $node
     * @return boolean true if typed, false if not.
     */
    protected function _dtypeCheck(&$node)
    {
        $patternInt = "/^-?[0-9]+$/";
        $match = preg_match($patternInt,$node,$hits);
        if ($match > 0) {
            require_once 'Erfurt/Rdf/Literal.php';
            $node = Erfurt_Rdf_Literal::initWithLabel($hits[0]);
            $node->setDatatype(EF_XSD_NS.'integer');
            return true;
        }
        
        $patternBool = "/^(true|false)$/";
        $match = preg_match($patternBool,$node,$hits);
        if ($match>0) {
            require_once 'Erfurt/Rdf/Literal.php';
            $node = Erfurt_Rdf_Literal::initWithLabel($hits[0]);
            $node->setDatatype(EF_XSD_NS.'boolean');
            return true;
        }
        
        $patternType = "/^a$/";
        $match = preg_match($patternType,$node,$hits);
        if ($match>0) {
            require_once 'Erfurt/Rdf/Resource.php';
            $node = Erfurt_Rdf_Resource::initWithNamespaceAndLocalName(EF_RDF_NS, 'type');
            return true;
        }
        
        $patternDouble = "/^-?[0-9]+.[0-9]+[e|E]?-?[0-9]*/";
        $match = preg_match($patternDouble,$node,$hits);
        if ($match>0) {
            require_once 'Erfurt/Rdf/Literal.php';
            $node = Erfurt_Rdf_Literal::initWithLabel($hits[0]);
            $node->setDatatype(EF_XSD_NS.'double');
            return true;
        }
        return false;
    }
    
    /** FastForward until next token which is not blank. */
    protected function _fastForward()
    {
        #next($this->_tokens);
        #return;
        
        $tok = next($this->_tokens);
        while ($tok === ' ') {
            $tok = next($this->_tokens);
        }
    }

    /**
     * Checks if $token is an IRI.
     *
     * @param  string  $token The token
     * @return boolean true if the token is an IRI false if not
     */
    protected function _iriCheck($token)
    {
        $pattern = "/^<[^>]*>\.?$/";
        
        if (preg_match($pattern, $token) > 0) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Checks if $token is a Literal.
     *
     * @param string $token The token
     * @return boolean true if the token is a Literal false if not
     */
    protected function _literalCheck($token)
    {
        $pattern = "/^[\"\'].*$/";
        if (preg_match($pattern, $token) > 0) {
            return true;
        } else if (is_numeric($token)) {
            return true;
        }
        
        return false;
    }

    /**
     * Sets result form to 'ASK' and 'COUNT'.
     *
     * @param string $form  if it's an ASK or COUNT query
     */
    protected function _parseAsk($form)
    {    
        $this->_query->setResultForm($form);       
        
        $this->_fastForward();

        if (current($this->_tokens) === '{' || strtolower(current($this->_tokens)) === 'from') {
            prev($this->_tokens);
        }
    }

    /**
     * Parses the BASE part of the query.
     *
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseBase()
    {
        $this->_fastForward();
        if ($this->_iriCheck(current($this->_tokens))) {
            $this->_query->setBase(current($this->_tokens));
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('IRI expected', -1, key($this->_tokens));
        }
    }
    
    /**
     * Parses an RDF collection.
     *
     * @param  Erfurt_Sparql_TriplePattern $trp
     * @return Erfurt_Rdf_Node The first parsed label.
     */
    protected function _parseCollection(&$trp)
    {
        if (prev($this->_tokens) === '{') {
            $prevStart = true;
        } else {
            $prevStart = false;
        }
        next($this->_tokens);
        
        $tmpLabel = $this->_query->getBlanknodeLabel();
        $firstLabel = $this->_parseNode($tmpLabel);
        $this->_fastForward();
        $i = 0;
        $emptyList = true;
        
        require_once 'Erfurt/Rdf/Resource.php';
        $rdfRest    = Erfurt_Rdf_Resource::initWithNamespaceAndLocalName(EF_RDF_NS, 'rest');
        $rdfFirst   = Erfurt_Rdf_Resource::initWithNamespaceAndLocalName(EF_RDF_NS, 'first');
        $rdfNil     = Erfurt_Rdf_Resource::initWithNamespaceAndLocalName(EF_RDF_NS, 'nil');
            
        require_once 'Erfurt/Sparql/QueryTriple.php';
        while (current($this->_tokens) !== ')') {
            if ($i>0) {
                $trp[] = new Erfurt_Sparql_QueryTriple($this->_parseNode($tmpLabel), $rdfRest, 
                                $this->_parseNode($tmpLabel = $this->_query->getBlanknodeLabel()));
            }
            
            if (current($this->_tokens) === '(') {
                $listNode = $this->_parseCollection($trp);
                
                $trp[] = new Erfurt_Sparql_QueryTriple($this->_parseNode($tmpLabel), $rdfFirst, $listNode);
            } else if (current($this->_tokens) === '[') {
                $this->_fastForward();
                if (current($this->_tokens) === ']') {
                    $this->_rewind();
                    $trp[] = new Erfurt_Sparql_QueryTriple($this->_parseNode($tmpLabel), $rdfFirst, $this->_parseNode());
                } else {
                    $this->_rewind();
                    
                    $sNode = $this->_parseNode();
                    $trp[] = new Erfurt_Sparql_QueryTriple($this->_parseNode($tmpLabel), $rdfFirst, $sNode);

                    $this->_fastForward();
                    $p =  $this->_parseNode();

                    $this->_fastForward();
                    $o = $this->_parseNode();

                    $trp[] = new Erfurt_Sparql_QueryTriple($sNode, $p, $o);
                    $this->_fastForward();
                }                    
            } else {
                $trp[] = new Erfurt_Sparql_QueryTriple($this->_parseNode($tmpLabel), $rdfFirst, $this->_parseNode());
            }
            
            $this->_fastForward();
            $emptyList = false;
            $i++;
        }

        if ($prevStart && $emptyList) {
            if (next($this->_tokens) === '}') {
                // list may not occure standalone in a pattern.
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException(
                    'A list may not occur standalone in a pattern.', -1, key($this->_tokens));
            }
            prev($this->_tokens);
        }
        
        $trp[] = new Erfurt_Sparql_QueryTriple($this->_parseNode($tmpLabel), $rdfRest, $rdfNil);
        return $firstLabel;
    }
    
    /**
     * Parses a value constraint.
     *
     * @param GraphPattern $pattern
     * @param boolean $outer If the constraint is an outer one.
     */
    protected function _parseConstraint(&$pattern, $outer)
    {
        require_once 'Erfurt/Sparql/Constraint.php';
        $constraint = new Erfurt_Sparql_Constraint();
        $constraint->setOuterFilter($outer);
        
        $constraint->setTree($this->_parseConstraintTree());

        if (current($this->_tokens) === '}') {
            prev($this->_tokens);
        }

        $pattern->addConstraint($constraint);
    }
    
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
    protected function _parseConstraintTree($nLevel = 0, $bParameter = false)
    {
        $tree       = array();
        $part       = array();
        $chQuotes   = null;
        $litQuotes  = null;
        $strQuoted  = '';
        $parens     = false;

        while ($tok = next($this->_tokens)) {
            if ($chQuotes !== null && $tok != $chQuotes) {
                $strQuoted .= $tok;
                continue;
            } else if ($litQuotes !== null) {
                $strQuoted .= $tok;
                if ($tok[strlen($tok) - 1] === '>') {
                    $tok = '>';
                } else {
                    continue;
                }
            } else if ($tok === ')' || $tok === '}' || $tok === '.') {
                break;
            } else if (strtolower($tok) === 'filter' || strtolower($tok) === 'optional') {
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
#                case '>':
#                   $litQuotes = null;
#                    $part[] = array(
#                        'type'  => 'value',
#                        'value' => $strQuoted,
#                        'quoted'=> false
#                    ); 
#                    continue 2;
#                    break;
                case '(':
                    $parens = true;
                    $bFunc1 = isset($part[0]['type']) && $part[0]['type'] === 'value';
                    $bFunc2 = isset($tree['type']) && $tree['type'] === 'equation'
                           && isset($tree['operand2']) && isset($tree['operand2']['value']);
                    $part[] = $this->_parseConstraintTree(
                        $nLevel + 1,
                        $bFunc1 || $bFunc2
                    );
                    
                    if ($bFunc1) {
                        $tree['type'] = 'function';
                        $tree['name'] = $part[0]['value'];
                        self::fixNegationInFuncName($tree);
                        if (isset($part[1]['type'])) {
                            $part[1] = array($part[1]);
                        }
                        $tree['parameter'] = $part[1];
                        $part = array();
                    } else if ($bFunc2) {
                        $tree['operand2']['type'] = 'function';
                        $tree['operand2']['name'] = $tree['operand2']['value'];
                        self::fixNegationInFuncName($tree['operand2']);
                        $tree['operand2']['parameter']  = $part[0];
                        unset($tree['operand2']['value']);
                        unset($tree['operand2']['quoted']);
                        $part = array();
                    }
                    
                    if (current($this->_tokens) === ')') {
                        if (substr(next($this->_tokens), 0, 2) === '_:') {
                            // filter ends here
                            prev($this->_tokens);
                            break 2;
                        } else {
                            prev($this->_tokens);
                        }
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
                case '-' : //TODO: check correctness
                case '+' : //TODO: check correctness
                case '!=':
                case '&&':
                case '||':
                    if (isset($tree['type']) && $tree['type'] === 'equation' && isset($tree['operand2'])) {
                        //previous equation open
                        $part = array($tree);
                    } else if (isset($tree['type']) && $tree['type'] !== 'equation') {
                        $part = array($tree);
                        $tree = array();
                    }
                    
                    $tree['type'] = 'equation';
                    $tree['level'] = $nLevel;
                    $tree['operator'] = $tok;
                    //TODO: remove the if when parse contraint is fixed (issue 601)
                    if(isset($part[0])) $tree['operand1'] = $part[0]; else $tree['operand1'] = null;
                    unset($tree['operand2']);
                    $part = array();
                    continue 2;
                    break;
                case '!':
                    if ($tree != array()) {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException(
                            'Unexpected "!" negation in constraint.', -1, current($this->_tokens));
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
                    if (count($part) === 0) {
                        $part[] = $tree;
                        $tree = array();
                    }
                    continue 2;
                default:
                    break;
            }

            if ($this->_varCheck($tok)) {
                if (!$parens && $nLevel === 0) {
                    // Variables need parenthesizes first
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException('FILTER expressions that start with a variable need parenthesizes.', -1, current($this->_tokens));
                }
                
                $part[] = array(
                    'type'      => 'value',
                    'value'     => $tok,
                    'quoted'    => false
                );
            } else if (substr($tok, 0, 2) === '_:') {
                // syntactic blank nodes not allowed in filter
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException('Syntactic Blanknodes not allowed in FILTER.', -1,
                                current($this->_tokens));
            } else if (substr($tok, 0, 2) === '^^') {
                $part[count($part) - 1]['datatype'] = $this->_query->getFullUri(substr($tok, 2));
            } else if ($tok[0] === '@') {
                $part[count($part) - 1]['language'] = substr($tok, 1);
            } else if ($tok[0] === '<') {
                if ($tok[strlen($tok) - 1] === '>') {
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
            } else if ($tok === 'true' || $tok === 'false') {
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
            if (isset($tree['type']) && $tree['type'] === 'equation' && isset($part[0])) {
                $tree['operand2'] = $part[0];
                self::balanceTree($tree);
                $part = array();
            }
        }
        
        if (!isset($tree['type']) && $bParameter) {
            return $part;
        } else if (isset($tree['type']) && $tree['type'] === 'equation'
            && isset($tree['operand1']) && !isset($tree['operand2'])
            && isset($part[0])) {
            $tree['operand2'] = $part[0];
            self::balanceTree($tree);
        }

        if ((count($tree) === 0) && (count($part) > 1)) {
            require_once 'Erfurt/Sparql/ParserException.php';
            //TODO: uncomment when issue 601 is fixed
            //throw new Erfurt_Sparql_ParserException('Failed to parse constraint.', -1, current($this->_tokens));
        }
        
        if (!isset($tree['type']) && isset($part[0])) {
            if (isset($tree['negated'])) {
                $part[0]['negated'] = true;
            }
            return $part[0];
        }

        return $tree;
    }
    
    /**
     * Parses the CONSTRUCT clause.
     *
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseConstruct()
    {
        $this->_fastForward();
        $this->_query->setResultForm('construct');

        if (current($this->_tokens) === '{') {
            $this->_parseGraphPattern(false, false, false, true);
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('Unable to parse CONSTRUCT part. "{" expected.', -1, 
                            key($this->_tokens));
        }

        while (true) {
            if (strtolower(current($this->_tokens)) === 'from') {
                $this->_parseFrom();
            } else {
                break;
            }
        }
        
        $this->_parseWhere();
        $this->_parseModifier();
    }
    
    /** Adds a new variable to the query and sets result form to 'DESCRIBE'. */
    protected function _parseDescribe()
    {
        while (strtolower(current($this->_tokens)) != 'from' && strtolower(current($this->_tokens)) != 'where') {
            $this->_fastForward();
            if ($this->_varCheck(current($this->_tokens)) || $this->_iriCheck(current($this->_tokens))) {
                require_once 'Erfurt/Sparql/QueryResultVariable.php';
                $var = new Erfurt_Sparql_QueryResultVariable(current($this->_tokens));
                
                $this->_query->addResultVar($var);
                if (!$this->_query->getResultForm()) {
                    $this->_query->setResultForm('describe');
                }   
            }
            
            if (!current($this->_tokens)) {
                break;
            }
        }
        prev($this->_tokens);
    }
    
    /**
     * Parses the FROM clause.
     *
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseFrom()
    {
        $this->_fastForward();

        if (strtolower(current($this->_tokens)) !== 'named') {
            if ($this->_iriCheck(current($this->_tokens)) || $this->_qnameCheck(current($this->_tokens))) {
                $this->_query->addFrom(substr(current($this->_tokens), 1, -1));
            } else if ($this->_varCheck(current($this->_tokens))) {
                $this->_query->addFrom(current($this->_tokens));
            } else {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException('Variable, iri or qname expected in FROM', -1,
                                key($this->_tokens));
            }
        } else {
            $this->_fastForward();
            if ($this->_iriCheck(current($this->_tokens)) || $this->_qnameCheck(current($this->_tokens))) {
                $this->_query->addFromNamed(substr(current($this->_tokens), 1, -1));
            } else if ($this->_varCheck(current($this->_tokens))) {
                $this->_query->addFromNamed(current($this->_tokens));
            } else {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException('Variable, Iri or qname expected in FROM NAMED', -1, 
                                key($this->_tokens));
            }
        }
    }
    
    /**
     * Parses a GRAPH clause.
     *
     * @param  Erfurt_Sparql_GraphPattern $pattern
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseGraph() 
    {
        $this->_fastForward();
        $name = current($this->_tokens);
        if (!$this->_varCheck($name) && !$this->_iriCheck($name) && !$this->_qnameCheck($name)) {
            $msg = $name;
            $msg = preg_replace('/</', '&lt;', $msg);
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('IRI or Var expected.', -1, key($this->_tokens));
        }
        $this->_fastForward();

        if ($this->_iriCheck($name)) {
            require_once 'Erfurt/Rdf/Resource.php';
            $name = Erfurt_Rdf_Resource::initWithIri(substr($name,1,-1));
        } else if($this->_qnameCheck($name)) {
            require_once 'Erfurt/Rdf/Resource.php';
            $name =  Erfurt_Rdf_Resource::initWithIri($this->_query->getFullUri($name));
        }
        $this->_parseGraphPattern(false, false, $name);
        if (current($this->_tokens) === '.') {
            $this->_fastForward();
        }
    }
    
    /**
     * Parses a graph pattern.
     *
     * @param  int     $optional Optional graph pattern
     * @param  int     $union    Union graph pattern
     * @param  string  $graph    Graphname
     * @param  boolean $constr   TRUE if the pattern is a construct pattern
     * @param  boolean $external If the parsed pattern shall be returned
     * @param  int     $subpattern If the new pattern is subpattern of the pattern with the given id
     */
    protected function _parseGraphPattern($optional = false, $union = false, $graph = false, $constr = false, 
        $external = false, $subpattern = false) 
    {
        $pattern = $this->_query->getNewPattern($constr);

        if (current($this->_tokens) !== '{') {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException(
                'A graph pattern needs to start with "{".', -1, key($this->_tokens));
        }
        
        // A new graph pattern invalidates the use of all previous blank nodes.
        $this->_dissallowBlankNodes();
     
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
                case 'graph':
                    $this->_parseGraph();
                    $this->_dissallowBlankNodes();
                    break;
                case 'union':
                    $this->_fastForward();
                    $this->_parseGraphPattern(false, $this->_tmp, false, false, false, $subpattern);
                    break;
                case 'optional':
                    $this->_fastForward();
                    $this->_parseGraphPattern($pattern->patternId, false, false, false, false, null);
                    break;
                case 'filter':
                    $this->_parseConstraint($pattern, true);
                    
                    if (current($this->_tokens) === ')') {
                        $this->_fastForward();
                    }
                    
                    $needsDot = false;
                    break;
                case '.':
                case ';':
                    // Check whether the previous token is {, for this is not allowed.
                    $this->_rewind();
                    if (current($this->_tokens) === '{') {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('A dot/semicolon must not follow a "{" directly.', -1,
                                        key($this->_tokens));
                    }
                    $this->_fastForward();
                    
                    $this->_fastForward();
                    break;
                case '{':
                    $subpattern = $pattern->getId();
                    $this->_parseGraphPattern(false, false, false, false, false, $subpattern);
                    break;
                case '}':
                    $pattern->open = false;
                    break;
                default:
                    $this->_parseTriplePattern($pattern);
                    break;
            }
        } while ($pattern->open);

        if ($external) {
            return $pattern;
        }
        $this->_fastForward();
    }
    
    /**
     * Parses a literal.
     *
     * @param string $node
     * @param string $sep used separator " or '
     */
    protected function _parseLiteral(&$node, $sep)
    {
        if ($sep !== null) {
            do {
                next($this->_tokens);
                $node = $node . current($this->_tokens);
            } while ((current($this->_tokens) != $sep));
            $this->_checkDtypeLang($node, strlen($sep));
        } else {
            $datatype = '';
            if (is_string($node) && strpos($node, '.') !== false) {
                $datatype = EF_XSD_NS . 'integer';
            } else {
                $datatype = EF_XSD_NS . 'decimal';
            }
            
            require_once 'Erfurt/Rdf/Literal.php';
            $node = Erfurt_Rdf_Literal::initWithLabel($node);
            $node->setDatatype($datatype);
        }
    }
    
    /**
     * Parses the solution modifiers of a query.
     *
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseModifier()
    {
        do {
            switch(strtolower(current($this->_tokens))) {
                case 'order':
                    $this->_fastForward();
                    if (strtolower(current($this->_tokens)) === 'by') {
                        $this->_fastForward();
                        $this->_parseOrderCondition();
                    } else {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('"BY" expected.', -1, key($this->_tokens));
                    }
                    break;
                case 'limit':
                    $this->_fastForward();
                    $val = current($this->_tokens);
                    $this->_query->setSolutionModifier('limit', $val);
                    break;
                case 'offset':
                    $this->_fastForward();
                    $val = current($this->_tokens);
                    $this->_query->setSolutionModifier('offset', $val);
                    break;
                default:
                    break;
            }
        } while (next($this->_tokens));
    }
    
    /**
     * Parses a String to an RDF node.
     *
     * @param  string $node
     * @return Erfurt_Rdf_Node The parsed RDF node
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseNode($node = false)
    {
        if ($node) {
            $node = $node;
        } else {
            $node = current($this->_tokens);
        }
 
        if ($node{strlen($node)-1} === '.') {
            $node = substr($node, 0, -1);
        }
        
        if ($this->_dtypeCheck($node)) {
            return $node;
        }



        if ($this->_bNodeCheck($node)) {
            $node = '?' . $node;
            
            if (isset($this->_usedBlankNodes[$node]) && $this->_usedBlankNodes[$node] === false) {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException('Reuse of blank node id not allowed here.' -1,
                            key($this->_tokens));
            }

            $this->_query->addUsedVar($node);
            $this->_usedBlankNodes[$node] = true;
            
            return $node;
        }
        if ($node === '[') {
            $node = '?' . substr($this->_query->getBlanknodeLabel(), 1);
            $this->_query->addUsedVar($node);
            $this->_fastForward();
            if (current($this->_tokens) !== ']') {
                prev($this->_tokens);
            }
            return $node;
        }

        if ($this->_iriCheck($node)){
            $base = $this->_query->getBase();
            if ($base != null) {
                require_once 'Erfurt/Rdf/Resource.php';
                $node = Erfurt_Rdf_Resource::initWithNamespaceAndLocalName(substr($base, 1, -1), substr($node, 1, -1));
            } else {
                require_once 'Erfurt/Rdf/Resource.php';
                $node = Erfurt_Rdf_Resource::initWithIri(substr($node, 1, -1));
            }
            return $node;
        } else if ($this->_qnameCheck($node)) {
            $node = $this->_query->getFullUri($node);
            require_once 'Erfurt/Rdf/Resource.php';
            $node = Erfurt_Rdf_Resource::initWithIri($node);
            return $node;
        } else if ($this->_literalCheck($node)) {
            if ((substr($node, 0, 1) === '"') || (substr($node, 0, 1) === "'")) {
                $ch     = substr($node, 0, 1);
                $chLong = str_repeat($ch, 3);
                if (substr($node, 0, 3) == $chLong) {
                    $ch = $chLong;
                }
                $this->_parseLiteral($node, $ch);
            } else {
                $this->_parseLiteral($node, null);
            }    
            
        } else if ($this->_varCheck($node)) {
            $pos = is_string($node) ? strpos($node, '.') : false;
            if ($pos) {
                return substr($node,0,$pos);
            } else {
                return $node;
            }
        } else if ($node[0] === '<') {
            //partial IRI? loop tokens until we find a closing >
            while (next($this->_tokens)) {
                $node .= current($this->_tokens);
                if (substr($node, -1) === '>') {
                    break;
                }
            }
            if (substr($node, -1) != '>') {
var_dump($this->_tokens);exit;
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException('Unclosed IRI: ' . $node, -1, key($this->_tokens));
            }
            return $this->_parseNode($node);
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException(
                '"' . $node . '" is neither a valid rdf- node nor a variable.',
                -1,
                key($this->_tokens)
            );
        }

        return $node;
    }
    
    /**
     * Parses order conditions of a query.
     *
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseOrderCondition()
    {
        $valList = array();
        $val = array();
        
        while (strtolower(current($this->_tokens)) !== 'limit' && strtolower(current($this->_tokens)) != false
                    && strtolower(current($this->_tokens)) !== 'offset') {
            
            switch (strtolower(current($this->_tokens))) {
                case 'desc':
                    $this->_fastForward();
                    $this->_fastForward();
                    
                    if ($this->_varCheck(current($this->_tokens))) {
                        $val['val'] = current($this->_tokens);
                    } else if ($this->_iriCheck(current($this->_tokens)) || $this->_qnameCheck(current($this->_tokens)) ||
                                in_array(current($this->_tokens), $this->_sops)) {
                    
                        $fName = current($this->_tokens);
                    
                        do {
                            $this->_fastForward();
                            $fName .= current($this->_tokens);
                        } while (current($this->_tokens) !== ')');
                    
                        $val['val'] = $fName;
                    } else {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('Variable expected in ORDER BY clause.', -1, 
                                        key($this->_tokens));
                    }
                    
                    $this->_fastForward();
                    
                    if (current($this->_tokens) != ')') {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('missing ")" in ORDER BY clause.', -1,
                                        key($this->_tokens));
                    }
                
                    $val['type'] = 'desc';
                    $this->_fastForward();
                    break;
                case 'asc':
                    $this->_fastForward();
                    $this->_fastForward();
                    
                    if ($this->_varCheck(current($this->_tokens))) {
                        $val['val'] = current($this->_tokens);
                    } else if ($this->_iriCheck(current($this->_tokens)) || $this->_qnameCheck(current($this->_tokens)) ||
                                in_array(current($this->_tokens), $this->_sops)) {
                    
                        $fName = current($this->_tokens);

                        do {
                            $this->_fastForward();
                            $fName .= current($this->_tokens);
                        } while (current($this->_tokens) !== ')');

                        $val['val'] = $fName;
                    } else {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('Variable expected in ORDER BY clause. ', -1, 
                                        key($this->_tokens));
                    }
                
                    $this->_fastForward();
                
                    if (current($this->_tokens) !== ')') {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('missing ")" in ORDER BY clause.', -1,          
                                        key($this->_tokens));
                    }
                
                    $val['type'] = 'asc';
                    $this->_fastForward();
                    break;
                case ')':
                    $this->_fastForward();
                    break;
                case '(':
                    $this->_fastForward();
                default:
                    if ($this->_varCheck(current($this->_tokens))) {
                        $val['val'] = current($this->_tokens);
                        $val['type'] = 'asc';
                    } else if ($this->_iriCheck(current($this->_tokens)) || $this->_qnameCheck(current($this->_tokens)) ||
                                    in_array(current($this->_tokens), self::$_sops)) {
                    
                        $fName = current($this->_tokens);

                        do {
                            $this->_fastForward();
                            $fName .= current($this->_tokens);
                        } while (current($this->_tokens) !== ')');

                        $val['val'] = $fName;
                    } else {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        //TODO: fix recognition of "ORDER BY ASC(?x)"
                        //throw new Erfurt_Sparql_ParserException('Variable expected in ORDER BY clause.', -1,
                          //              key($this->_tokens));
                    }
                
                    $this->_fastForward();
                    break;
            }
            $valList[] = $val;
        }
        prev($this->_tokens);
        $this->_query->setSolutionModifier('order by', $valList);
    }
    
    /**
     * Adds a new namespace prefix to the query object.
     *
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parsePrefix()
    {
        $this->_fastForward();
        $prefix = substr(current($this->_tokens), 0, -1);
        $this->_fastForward();
        if ($this->_iriCheck(current($this->_tokens))) {
            $uri = substr(current($this->_tokens), 1, -1);
            $this->_query->addPrefix($prefix, $uri);
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('IRI expected', -1, key($this->_tokens));
        }
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
                case 'count-distinct':
                    $this->_parseAsk('count-distinct');
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
    
    /**
     * Parses the SELECT part of a query.
     *
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseSelect()
    {
        $this->_fastForward();
        $curLow = strtolower(current($this->_tokens));
        prev($this->_tokens);
        if ($curLow === 'distinct') {
            $this->_query->setResultForm('select distinct');
        } else {
            $this->_query->setResultForm('select');
        }

        $currentVar = null;
        $currentFunc = null;
        $bWaitForRenaming = false;
        while ($curLow != 'from' && $curLow != 'where' && $curLow != "{") {
            $this->_fastForward();
            $curTok = current($this->_tokens);
            $curLow = strtolower($curTok);

            if ($this->_varCheck($curTok) || $curLow == '*') {
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
                    throw new Erfurt_Sparql_ParserException('AS requires a variable left and right', -1,
                                    key($this->_tokens));
                }
                $bWaitForRenaming = true;
            } else if (in_array($curLow, self::$_sops)) {
                $currentFunc = $curLow;
            }

            if (!current($this->_tokens)) {
                require_once 'Erfurt/Sparql/ParserException.php';
                throw new Erfurt_Sparql_ParserException(
                    'Unexpected end of query.', -1, key($this->_tokens));
            }
        }

        if ($currentVar != null) {
            $this->_query->addResultVar($currentVar);
        }
        prev($this->_tokens);

        if (count($this->_query->getResultVars()) == 0) {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('Variable or "*" expected.', -1, key($this->_tokens));
        }
    }
    
    /**
     * Parses a triple pattern.
     *
     * @param  Sparql_GraphPattern $pattern
     */
    protected function _parseTriplePattern(&$pattern)
    {
        $trp        = array();
        $prev       = false;
        $prevPred   = false;
        $cont       = true;
        $needsDot   = false;
        $dotAllowed = true;
        $sub        = '';
        $pre        = '';
        $tmp        = '';
        $tmpPred    = '';
        $obj        = '';
        
        do {
            switch (strtolower(current($this->_tokens))) {
                case false:
                    $cont          = false;
                    $pattern->open = false;
                    break;
                case 'filter':
                    $this->_parseConstraint($pattern, false);
                    
                    if (strtolower(current($this->_tokens)) !== 'filter' && 
                            strtolower(current($this->_tokens)) !== 'optional') {
                        
                        $this->_fastForward();
                    }
                    
                    $needsDot = false;
                    break;
                case 'optional':
                    $needsDot = false;
                    $this->_fastForward();
                    $this->_parseGraphPattern($pattern->getId(), false);
                    break;
                case 'union':
                    $this->_fastForward();
                    $this->_parseGraphPattern(false, $this->_tmp, false, false, false, $pattern->getId());
                    break;
                case ';':
                    // Check whether the previous token is a dot too, for this is not allowed.
                    $this->_rewind();
                    if (current($this->_tokens) === '.') {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('A semicolon must not follow a dot directly.', -1,
                                        key($this->_tokens));
                    }
                    $this->_fastForward();
                
                    $prev = true;
                    $needsDot = false;
                    $this->_fastForward();
                    break;
                case '.':
                    if ($dotAllowed === false) {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('A dot is not allowed here.', -1, key($this->_tokens));
                    }
                
                    // Check whether the previous token is a dot too, for this is not allowed.
                    $this->_rewind();
                    if (current($this->_tokens) === '.') {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('A dot may not follow a dot directly.', -1,
                                        key($this->_tokens));
                    }
                    $this->_fastForward();
                    
                    $prev = false;
                    $needsDot = false;
                    $this->_fastForward();
                    break;
                case 'graph':
                    $this->_parseGraph();
                    break;
                case ',':
                    require_once 'Erfurt/Sparql/ParserException.php';
                    throw new Erfurt_Sparql_ParserException('A comma is not allowed directly after a triple.', -1,
                                    key($this->_tokens));
                
                    $prev     = true;
                    $prevPred = true;
                    $this->_fastForward();
                    break;
                case '}':
                    $prev = false;
                    $pattern->open = false;
                    $cont = false;
                    $this->_dissallowBlankNodes();
                    break;
                case '{':
                    //subpatterns opens
                    $this->_parseGraphPattern(false, false, false, false, false, $pattern->getId());
                    $needsDot = false;
                    break;
                case "[":
                    $needsDot = false;
                    $prev = true;
                    $tmp  = $this->_parseNode($this->_query->getBlanknodeLabel());
                    $this->_fastForward();
                    break;
                case "]":
                    $needsDot = false;
                    $dotAllowed = false;
                    $prev = true;
                    $this->_fastForward();
                    break;
                case "(":
                    $prev = true;
                    $tmp = $this->_parseCollection($trp);
                    $this->_fastForward();
                    break;
                case false:
                    $cont = false;
                    $pattern->open = false;
                    break;
                default:
                    if ($needsDot === true) {
                        require_once 'Erfurt/Sparql/ParserException.php';
                        throw new Erfurt_Sparql_ParserException('Two triple pattern need to be seperated by a dot. In Query: '.htmlentities($this->_query), -1,
                                        key($this->_tokens));
                    }
                
                    $dotAllowed = false;
                
                    if ($prev) {
                        $sub = $tmp;
                    } else {
                        $sub = $this->_parseNode();
                        $this->_fastForward();
                        $tmp = $sub;
                    }
                    if ($prevPred) {
                        $pre = $tmpPred;
                    } else {
                        // Predicates may not be blank nodes.
                        if ((current($this->_tokens) === '[') || (substr(current($this->_tokens), 0, 2) === '_:')) {
                            require_once 'Erfurt/Sparql/ParserException.php';
                            throw new Erfurt_Sparql_ParserException('Predicates may not be blank nodes.', -1,
                                            key($this->_tokens));
                        }

                        $pre = $this->_parseNode();
                        $this->_fastForward();
                        $tmpPred = $pre;
                    }

                    if (current($this->_tokens) === '[') {
                        $tmp  = $this->_parseNode($this->_query->getBlanknodeLabel());
                        $prev = true;
                        $obj = $tmp;
                        
                        require_once 'Erfurt/Sparql/QueryTriple.php';
                        $trp[] = new Erfurt_Sparql_QueryTriple($sub, $pre, $obj);
                        $dotAllowed = true;
                        $this->_fastForward();
                        continue;
                    } else if (current($this->_tokens) === '(') {
                        $obj = $this->_parseCollection($trp);
                    } else {
                        $obj = $this->_parseNode();
                    }
                    
                    require_once 'Erfurt/Sparql/QueryTriple.php';
                    $trp[] = new Erfurt_Sparql_QueryTriple($sub, $pre, $obj);
                    $dotAllowed = true;
                    $needsDot = true;
                    $this->_fastForward();
                    break;
            }
        } while ($cont);

        if (count($trp) > 0) {
            $pattern->addTriplePatterns($trp);
        }
    }
    
    /**
     * Parses the WHERE clause.
     *
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _parseWhere()
    {    
        $this->_fastForward();

        if (current($this->_tokens) === '{') {
            $this->_parseGraphPattern();
        } else {
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('Unable to parse WHERE part. "{" expected in Query. ', -1,
                            key($this->_tokens));
        }
    }

    /**
     *   Set all internal variables to a clear state
     *   before we start parsing.
     */
    protected function _prepare() 
    {   
        require_once 'Erfurt/Sparql/Query.php';
        $this->_query = new Erfurt_Sparql_Query();
        
        $this->_tokens = array();
        $this->_tmp = null;
    }

    /**
     * Checks if $token is a qname.
     *
     * @param  string  $token The token
     * @return boolean true if the token is a qname false if not
     * @throws Erfurt_Sparql_ParserException
     */
    protected function _qnameCheck($token)
    {
        $pattern = "/^([^:^\<]*):([^:]*)$/";
        
        if (preg_match($pattern, $token, $hits) > 0) {
            $prefs = $this->_query->getPrefixes();
            if (isset($prefs[$hits{1}])) {
                return true;
            }
            if ($hits{1} === '_') {
                return true;
            }
            
            require_once 'Erfurt/Sparql/ParserException.php';
            throw new Erfurt_Sparql_ParserException('Unbound Prefix: <i>' . $hits{1} . '</i>', -1, key($this->_tokens));
        } else {
            return false;
        }
    }
    
    /** Rewind until next token which is not blank. */
    protected function _rewind()
    {
        prev($this->_tokens);
    }

    /**
     * Checks if $token is a variable.
     *
     * @param  string  $token The token
     * @return boolean true if the token is a variable false if not
     */
    protected function _varCheck($token)
    {
        if (isset($token[0]) && ($token{0} == '$' || $token{0} == '?')) {
            $this->_query->addUsedVar($token);
            return true;
        }
        
        return false;
    }
}
