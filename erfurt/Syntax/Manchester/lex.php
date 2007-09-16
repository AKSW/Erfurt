<?php
/*
* make changes to this file, if you want to make changes to tokenizer for manchester syntax
*/
require_once 'manchester.php';
class ManchesterLexer
{

	const 	NOT_OPERATOR  = OWLParser::NOT_OPERATOR;
	const 	ALPHANUMERIC  = OWLParser::ALPHANUMERIC;
	const 	AND_OPERATOR  = OWLParser::AND_OPERATOR;
	const 	THAT_OPERATOR  = OWLParser::THAT_OPERATOR;
	const 	OR_OPERATOR   = OWLParser::OR_OPERATOR;
	const 	MIN_OPERATOR   = OWLParser::MIN_OPERATOR;
	const 	MAX_OPERATOR   = OWLParser::MAX_OPERATOR;
	const 	EXACTLY_OPERATOR  = OWLParser::EXACTLY_OPERATOR;
	const 	HAS_OPERATOR    = OWLParser::HAS_OPERATOR;
	const 	ONLYSOME_OPERATOR  = OWLParser::ONLYSOME_OPERATOR;
	const 	ONLY_OPERATOR   = OWLParser::ONLY_OPERATOR;
	const 	SOME_OPERATOR   = OWLParser::SOME_OPERATOR;
	const 	LPAREN         = OWLParser:: LPAREN;
	const 	RPAREN       = OWLParser::RPAREN;
	const 	LBRACE       = OWLParser::LBRACE;
	const 	RBRACE        = OWLParser::RBRACE;
	const 	LSQUAREBRACKET  = OWLParser::LSQUAREBRACKET;
	const 	RSQUAREBRACKET  = OWLParser::RSQUAREBRACKET;
	const 	NUMERIC       = OWLParser::NUMERIC;
	const 	COMMA        = OWLParser::COMMA;

	private $data;
	private $N;
	public $token;
	public $value;
    public $line;
	private $debug = 0;
	
    function __construct($data)
    {
        $this->data = $data;
        $this->N = 0;
//        $this->line = 1;
    }


    private $_yy_state = 1;
    private $_yy_stack = array();

    function yylex()
    {
        return $this->{'yylex' . $this->_yy_state}();
    }

    function yypushstate($state)
    {
        array_push($this->_yy_stack, $this->_yy_state);
        $this->_yy_state = $state;
    }

    function yypopstate()
    {
        $this->_yy_state = array_pop($this->_yy_stack);
    }

    function yybegin($state)
    {
        $this->_yy_state = $state;
    }



    function yylex1()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 0,
              7 => 0,
              8 => 0,
              9 => 0,
              10 => 0,
              11 => 0,
              12 => 0,
              13 => 0,
              14 => 0,
              15 => 0,
              16 => 0,
              17 => 0,
              18 => 0,
              19 => 0,
              20 => 0,
              21 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^([ \t\n\r]+)|^([Aa][Nn][Dd][ \t\n\r]+)|^([Tt][Hh][Aa][Tt][ \t\n\r]+)|^([Oo][Rr][ \t\n\r]+)|^([Nn][Oo][Tt][ \t\n\r]+)|^([Mm][Ii][Nn][ \t\n\r]+)|^([Mm][Aa][Xx][ \t\n\r]+)|^([Ee][Xx][Aa][Cc][Tt][Ll][Yy][ \t\n\r]+)|^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state START');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {                    $yy_yymore_patterns = array(
        1 => array(0, "^([Aa][Nn][Dd][ \t\n\r]+)|^([Tt][Hh][Aa][Tt][ \t\n\r]+)|^([Oo][Rr][ \t\n\r]+)|^([Nn][Oo][Tt][ \t\n\r]+)|^([Mm][Ii][Nn][ \t\n\r]+)|^([Mm][Aa][Xx][ \t\n\r]+)|^([Ee][Xx][Aa][Cc][Tt][Ll][Yy][ \t\n\r]+)|^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        2 => array(0, "^([Tt][Hh][Aa][Tt][ \t\n\r]+)|^([Oo][Rr][ \t\n\r]+)|^([Nn][Oo][Tt][ \t\n\r]+)|^([Mm][Ii][Nn][ \t\n\r]+)|^([Mm][Aa][Xx][ \t\n\r]+)|^([Ee][Xx][Aa][Cc][Tt][Ll][Yy][ \t\n\r]+)|^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        3 => array(0, "^([Oo][Rr][ \t\n\r]+)|^([Nn][Oo][Tt][ \t\n\r]+)|^([Mm][Ii][Nn][ \t\n\r]+)|^([Mm][Aa][Xx][ \t\n\r]+)|^([Ee][Xx][Aa][Cc][Tt][Ll][Yy][ \t\n\r]+)|^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        4 => array(0, "^([Nn][Oo][Tt][ \t\n\r]+)|^([Mm][Ii][Nn][ \t\n\r]+)|^([Mm][Aa][Xx][ \t\n\r]+)|^([Ee][Xx][Aa][Cc][Tt][Ll][Yy][ \t\n\r]+)|^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        5 => array(0, "^([Mm][Ii][Nn][ \t\n\r]+)|^([Mm][Aa][Xx][ \t\n\r]+)|^([Ee][Xx][Aa][Cc][Tt][Ll][Yy][ \t\n\r]+)|^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        6 => array(0, "^([Mm][Aa][Xx][ \t\n\r]+)|^([Ee][Xx][Aa][Cc][Tt][Ll][Yy][ \t\n\r]+)|^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        7 => array(0, "^([Ee][Xx][Aa][Cc][Tt][Ll][Yy][ \t\n\r]+)|^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        8 => array(0, "^([Hh][Aa][Ss][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        9 => array(0, "^([Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        10 => array(0, "^([Ss][Oo][Mm][Ee][ \t\n\r]+)|^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        11 => array(0, "^([Oo][Nn][Ll][Yy][ \t\n\r]+)|^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        12 => array(0, "^(,)|^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        13 => array(0, "^(\\()|^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        14 => array(0, "^(\\))|^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        15 => array(0, "^(\\{)|^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        16 => array(0, "^(\\})|^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        17 => array(0, "^(\\[)|^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        18 => array(0, "^(\\])|^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        19 => array(0, "^([0-9]+)|^([a-zA-Z]+[0-9]*)"),
        20 => array(0, "^([a-zA-Z]+[0-9]*)"),
        21 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              substr($this->data, $this->N), $yymatches)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                    	$r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->data)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
			        } else {
	                    // accept
	                    $this->N += strlen($this->value);
	                    $this->line += substr_count($this->value, "\n");
	                    return true;
			        }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->data[$this->N]);
            }
            break;
        } while (true);

    } // end function


    const START = 1;
    function yy_r1_1($yy_subpatterns)
    {

	if ($this->debug) echo "whitespace found\n";
    return false; // skip this token (do not return it)
    }
    function yy_r1_2($yy_subpatterns)
    {

	if ($this->debug) echo "and operator found\n";
	$this->token=self::AND_OPERATOR;
    }
    function yy_r1_3($yy_subpatterns)
    {

	if ($this->debug) echo "and operator found\n";
	$this->token=self::AND_OPERATOR;
    }
    function yy_r1_4($yy_subpatterns)
    {

	if ($this->debug) echo "or operator found\n";
	$this->token=self::OR_OPERATOR;
    }
    function yy_r1_5($yy_subpatterns)
    {

	if ($this->debug) echo "not operator found\n";
	$this->token=self::NOT_OPERATOR;
    }
    function yy_r1_6($yy_subpatterns)
    {

	if ($this->debug) echo "min operator found\n";
	$this->token=self::MIN_OPERATOR;
    }
    function yy_r1_7($yy_subpatterns)
    {

	if ($this->debug) echo "max operator found\n";
	$this->token=self::MAX_OPERATOR;
    }
    function yy_r1_8($yy_subpatterns)
    {

	if ($this->debug) echo "exactly operator found\n";
	$this->token=self::EXACTLY_OPERATOR;
    }
    function yy_r1_9($yy_subpatterns)
    {

	if ($this->debug) echo "has operator found\n";
	$this->token=self::HAS_OPERATOR;
    }
    function yy_r1_10($yy_subpatterns)
    {

	if ($this->debug) echo "onlysome_operator operator found\n";
	$this->token=self::ONLYSOME_OPERATOR;
    }
    function yy_r1_11($yy_subpatterns)
    {

	if ($this->debug) echo "some_operator operator found\n";
	$this->token=self::SOME_OPERATOR;
    }
    function yy_r1_12($yy_subpatterns)
    {

	if ($this->debug) echo "only_operator operator found\n";
	$this->token=self::ONLY_OPERATOR;
    }
    function yy_r1_13($yy_subpatterns)
    {

	if ($this->debug) echo "comma found\n";
	$this->token=self::COMMA;
    }
    function yy_r1_14($yy_subpatterns)
    {

	if ($this->debug) echo "lparen found\n";
	$this->token=self::LPAREN;
    }
    function yy_r1_15($yy_subpatterns)
    {

	if ($this->debug) echo "rparen found\n";
	$this->token=self::RPAREN;
    }
    function yy_r1_16($yy_subpatterns)
    {

	if ($this->debug) echo "lbrace found\n";
	$this->token=self::LBRACE;
    }
    function yy_r1_17($yy_subpatterns)
    {

	if ($this->debug) echo "rbrace found\n";
	$this->token=self::RBRACE;
    }
    function yy_r1_18($yy_subpatterns)
    {

	if ($this->debug) echo "lsquarebracket found\n";
	$this->token=self::LSQUAREBRACKET;
    }
    function yy_r1_19($yy_subpatterns)
    {

	if ($this->debug) echo "rsquarebracket found\n";
	$this->token=self::RSQUAREBRACKET;
    }
    function yy_r1_20($yy_subpatterns)
    {

	if ($this->debug) echo "numeric found\n";
	$this->token=self::NUMERIC;
    }
    function yy_r1_21($yy_subpatterns)
    {

	if ($this->debug) echo "alphanumeric found\n";
	$this->token=self::ALPHANUMERIC;
    }

}