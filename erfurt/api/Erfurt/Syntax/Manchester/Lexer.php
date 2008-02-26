<?php
/**
 * Auto-generated tokenizer for the Manchester OWL Syntax. For modification make changes to Erfurt_Syntax_Manchester_Lexer.plex
 * 
 * @author Rolland Brunec <rollxx@rollxx.com>
 * @package syntax
 * @version $Id$
 */

// PHP section
require_once 'Parser.php';

class ManchesterLexer
{
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


	public function printout($text="nothing"){
		if($this->debug){
			echo $text." \n";
		}
	}

// Patterns section


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



// Rules section


    function yylex1()
    {
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
    	do {
	    	$rules = array(
    			'/^[ \t]+/',
    			'/^[Oo][Rr]/',
    			'/^[Aa][Nn][Dd]|[Tt][Hh][Aa][Tt]/',
    			'/^[Nn][Oo][Tt]/',
    			'/^[Mm][Ii][Nn]/',
    			'/^[Mm][Aa][Xx]/',
    			'/^[Ee][Xx][Aa][Cc][Tt][Ll][Yy]/',
    			'/^[Vv][Aa][Ll][Uu][Ee]/',
    			'/^[Oo][Nn][Ll][Yy][Ss][Oo][Mm][Ee]/',
    			'/^[Ss][Oo][Mm][Ee]/',
    			'/^[Oo][Nn][Ll][Yy]/',
    			'/^,/',
    			'/^\\(/',
    			'/^\\)/',
    			'/^\\{/',
    			'/^\\}/',
    			'/^\\[/',
    			'/^\\]/',
    			'/^[0-9]+/',
    			'/^[a-zA-Z0-9]+:[a-zA-Z0-9]+/',
    			'/^[a-zA-Z0-9]+/',
	    	);
	    	$match = false;
	    	foreach ($rules as $index => $rule) {
	    		if (preg_match($rule, substr($this->data, $this->N), $yymatches)) {
	            	if ($match) {
	            	    if (strlen($yymatches[0]) > strlen($match[0][0])) {
	            	    	$match = array($yymatches, $index); // matches, token
	            	    }
	            	} else {
	            		$match = array($yymatches, $index);
	            	}
	            }
	    	}
	    	if (!$match) {
	            throw new Exception('Unexpected input at line' . $this->line .
	                ': ' . $this->data[$this->N]);
	    	}
	    	$this->token = $match[1];
	    	$this->value = $match[0][0];
	    	$yysubmatches = $match[0];
	    	array_shift($yysubmatches);
	    	if (!$yysubmatches) {
	    		$yysubmatches = array();
	    	}
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
	        } else {
	            $yy_yymore_patterns = array_slice($rules, $this->token, true);
	            // yymore is needed
	            do {
	                if (!isset($yy_yymore_patterns[$this->token])) {
	                    throw new Exception('cannot do yymore for the last token');
	                }
			    	$match = false;
	                foreach ($yy_yymore_patterns[$this->token] as $index => $rule) {
	                	if (preg_match('/' . $rule . '/',
	                      	  substr($this->data, $this->N), $yymatches)) {
	                    	$yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
			            	if ($match) {
			            	    if (strlen($yymatches[0]) > strlen($match[0][0])) {
			            	    	$match = array($yymatches, $index); // matches, token
			            	    }
			            	} else {
			            		$match = array($yymatches, $index);
			            	}
			            }
			    	}
			    	if (!$match) {
			            throw new Exception('Unexpected input at line' . $this->line .
			                ': ' . $this->data[$this->N]);
			    	}
			    	$this->token = $match[1];
			    	$this->value = $match[0][0];
			    	$yysubmatches = $match[0];
			    	array_shift($yysubmatches);
			    	if (!$yysubmatches) {
			    		$yysubmatches = array();
			    	}
	                $this->line = substr_count($this->value, "\n");
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
        } while (true);

    } // end function


    const START = 1;
    function yy_r1_0($yy_subpatterns)
    {

//	$this->printout("whitespace");
    return false; // skip this token (do not return it)
    }
    function yy_r1_1($yy_subpatterns)
    {

//	$this->printout("or");
	$this->token=OWLParser::OR_OPERATOR;
    }
    function yy_r1_2($yy_subpatterns)
    {

//	$this->printout("and");
	$this->token=OWLParser::AND_OPERATOR;
    }
    function yy_r1_3($yy_subpatterns)
    {

//	$this->printout("not");
	$this->token=OWLParser::NOT_OPERATOR;
    }
    function yy_r1_4($yy_subpatterns)
    {

//	$this->printout("min");
	$this->token=OWLParser::MIN_OPERATOR;
    }
    function yy_r1_5($yy_subpatterns)
    {

//	$this->printout("max");
	$this->token=OWLParser::MAX_OPERATOR;
    }
    function yy_r1_6($yy_subpatterns)
    {

//	$this->printout("exactly");
	$this->token=OWLParser::EXACTLY_OPERATOR;
    }
    function yy_r1_7($yy_subpatterns)
    {

//	$this->printout("has");
	$this->token=OWLParser::VALUE_OPERATOR;
    }
    function yy_r1_8($yy_subpatterns)
    {

//	$this->printout("onlysome");
	$this->token=OWLParser::ONLYSOME_OPERATOR;
    }
    function yy_r1_9($yy_subpatterns)
    {

//	$this->printout("some");
	$this->token=OWLParser::SOME_OPERATOR;
    }
    function yy_r1_10($yy_subpatterns)
    {

//	$this->printout("only");
	$this->token=OWLParser::ONLY_OPERATOR;
    }
    function yy_r1_11($yy_subpatterns)
    {

//	$this->printout("comma");
	$this->token=OWLParser::COMMA;
    }
    function yy_r1_12($yy_subpatterns)
    {

//	$this->printout("lparen");
	$this->token=OWLParser::LPAREN;
    }
    function yy_r1_13($yy_subpatterns)
    {

//	$this->printout("rparen");
	$this->token=OWLParser::RPAREN;
    }
    function yy_r1_14($yy_subpatterns)
    {

//	$this->printout("lbrace");
	$this->token=OWLParser::LBRACE;
    }
    function yy_r1_15($yy_subpatterns)
    {

//	$this->printout("rbrace");
	$this->token=OWLParser::RBRACE;
    }
    function yy_r1_16($yy_subpatterns)
    {

//	$this->printout("lsquarebracket");
	$this->token=OWLParser::LSQUAREBRACKET;
    }
    function yy_r1_17($yy_subpatterns)
    {

//	$this->printout("rsquarebracket");
	$this->token=OWLParser::RSQUAREBRACKET;
    }
    function yy_r1_18($yy_subpatterns)
    {

//	$this->printout("numeric");
	$this->token=OWLParser::NUMERIC;
    }
    function yy_r1_19($yy_subpatterns)
    {

//	$this->printout("alphanumeric:alphanumeric");
	$this->token=OWLParser::ALPHANUMERIC;
    }
    function yy_r1_20($yy_subpatterns)
    {

//	$this->printout("alphanumeric");
	$this->token=OWLParser::ALPHANUMERIC;
    }

}
?>
