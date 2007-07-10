<?php
require_once './manchester.php';
class TestLexer
{
	
	const TEXT = OWLParser::NOT_OPERATOR;
	const OPERATOR = OWLParser::AND_OPERATOR;
	const OPERATOR1 = OWLParser::OR_OPERATOR;
	const OPENPAREN = OWLParser::LPAREN;
	const ALPHA = OWLParser::ALPHANUMERIC;
    private $data;
    private $N;
    public $token;
    public $value;
    private $line;
    private $state = 1;

    function __construct($data)
    {
        $this->data = $data;
        $this->N = 0;
        $this->line = 1;
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
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(and|or|some|not|only|min|max|exactly|has)|^(\\()|^(\\))|^([a-zA-Z]+[0-9]*)|^([ \t\n]+)/";

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
        1 => "^(\\()|^(\\))|^([a-zA-Z]+[0-9]*)|^([ \t\n]+)",
        2 => "^(\\))|^([a-zA-Z]+[0-9]*)|^([ \t\n]+)",
        3 => "^([a-zA-Z]+[0-9]*)|^([ \t\n]+)",
        4 => "^([ \t\n]+)",
        5 => "",
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        if (preg_match($yy_yymore_patterns[$this->token],
                              substr($this->data, $this->N), $yymatches)) {
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token = key($yymatches); // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                        }
                    	$r = $this->{'yy_r1_' . $this->token}();
                    } while ($r !== null || !$r);
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
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

	echo "operator found\n";
    var_dump($this->value);
//    echo "    rule operator subpatterns: \n";
//    var_dump($yy_subpatterns);
    }
    function yy_r1_2($yy_subpatterns)
    {

	$this->token=self::OPENPAREN;
	echo "leftbrace found\n";
//    var_dump($this->value);
//    echo "    rule leftbrace subpatterns: \n";
//    var_dump($yy_subpatterns);
//	$this->yybegin(self::THREE);
    }
    function yy_r1_3($yy_subpatterns)
    {

	echo "rightbrace found\n";
    var_dump($this->value);
  //  echo "    rule rightbrace subpatterns: \n";
  //  var_dump($yy_subpatterns);
//	$this->yybegin(self::TWO);
    }
    function yy_r1_4($yy_subpatterns)
    {

    echo "rule alphanumeric\n";
    var_dump($this->value);
    //echo "    rule alphanumeric subpatterns: \n";
    //var_dump($yy_subpatterns);
   // $this->yybegin(self::THREE);
    }
    function yy_r1_5($yy_subpatterns)
    {

    echo "whitespace\n";
    //echo "    whitespace subpatterns: \n";
    //var_dump($yy_subpatterns);
    return false; // skip this token (do not return it)
    }


    function yylex2()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\))|^([a-zA-Z]+[0-9]*)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state TWO');
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
                $r = $this->{'yy_r2_' . $this->token}($yysubmatches);
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
        1 => "^([a-zA-Z]+[0-9]*)",
        2 => "",
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        if (preg_match($yy_yymore_patterns[$this->token],
                              substr($this->data, $this->N), $yymatches)) {
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token = key($yymatches); // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                        }
                    	$r = $this->{'yy_r2_' . $this->token}();
                    } while ($r !== null || !$r);
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
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


    const TWO = 2;
    function yy_r2_1($yy_subpatterns)
    {

    echo "alphanumeric (state TWO)\n";
    var_dump($this->value);
	$this->yypopstate();
    }
    function yy_r2_2($yy_subpatterns)
    {

    echo "alphanumeric (state TWO)\n";
    var_dump($this->value);
    $this->yypopstate();
    }


    function yylex3()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\()|^([a-zA-Z]+[0-9]*)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state THREE');
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
                $r = $this->{'yy_r3_' . $this->token}($yysubmatches);
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
        1 => "^([a-zA-Z]+[0-9]*)",
        2 => "",
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        if (preg_match($yy_yymore_patterns[$this->token],
                              substr($this->data, $this->N), $yymatches)) {
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token = key($yymatches); // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                        }
                    	$r = $this->{'yy_r3_' . $this->token}();
                    } while ($r !== null || !$r);
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
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


    const THREE = 3;
    function yy_r3_1($yy_subpatterns)
    {

	echo "leftbrace found in state 3\n";
	$this->yypushstate(self::START);
    }
    function yy_r3_2($yy_subpatterns)
    {

    echo "number (state THREE)\n";
	$this->yypushstate(self::START);
//    $this->yybegin(self::START);
    }

}

$a = new TestLexer('not (abc and hello )');
while ($a->yylex()) {
	var_dump('advance:' . $a->value);
}