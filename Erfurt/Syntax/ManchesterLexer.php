<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 src/Erfurt_Syntax_Manchester.g 2010-11-05 08:03:24


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
class Erfurt_Syntax_ManchesterLexer_DFA1_static {
	static function getValues(){
		$eot = array(1, 65535, 1, 2, 1, 65535, 8, 2, 1, 65535);
		$eof = array(12, 65535);
		$min = array(1, 9, 1, 103, 1, 65535, 6, 103, 1, 114, 1, 33, 1, 65535);
		$max = array(1, 125, 1, 103, 1, 65535, 6, 103, 1, 114, 1, 33, 1, 65535);
		$accept = array(2, 65535, 1, 2, 8, 65535, 1, 1);
		$special = array(12, 65535);
		$transitionS = array(array(2, 2, 2, 65535, 1, 2, 18, 65535, 1, 2, 1, 65535, 
    1, 2, 5, 65535, 2, 2, 1, 65535, 4, 2, 1, 65535, 11, 2, 1, 65535, 1, 
    2, 1, 65535, 1, 2, 1, 65535, 28, 2, 1, 65535, 3, 2, 1, 65535, 6, 2, 
    1, 1, 20, 2, 1, 65535, 1, 2), array(1, 3), array(), array(1, 4), array(
    1, 5), array(1, 6), array(1, 7), array(1, 8), array(1, 9), array(1, 
    10), array(1, 11), array());
		
		$arr = array();
		$arr['eot'] = DFA::unpackRLE($eot);
		$arr['eof'] = DFA::unpackRLE($eof);
		$arr['min'] = DFA::unpackRLE($min, true);
		$arr['max'] = DFA::unpackRLE($max, true);
		$arr['accept'] = DFA::unpackRLE($accept);
		$arr['special'] = DFA::unpackRLE($special);
		
		
		$numStates = sizeof($transitionS);
		$arr['transition'] = array();
		for ($i=0; $i<$numStates; $i++) {
		    $arr['transition'][$i] = DFA::unpackRLE($transitionS[$i]);
		}
		return $arr;
	}
}
//$Erfurt_Syntax_ManchesterLexer_DFA1 = Erfurt_Syntax_ManchesterLexer_DFA1_static();

class Erfurt_Syntax_ManchesterLexer_DFA1 extends DFA {

    public function __construct($recognizer) {
//        global $Erfurt_Syntax_ManchesterLexer_DFA1;
//        $DFA = $Erfurt_Syntax_ManchesterLexer_DFA1;
		$DFA = Erfurt_Syntax_ManchesterLexer_DFA1_static::getValues();
        $this->recognizer = $recognizer;
        $this->decisionNumber = 1;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "1:1: Tokens : ( ITFUCKINDOESNTWORK | ManchesterTokenizer. Tokens );";
    }
}
      

class Erfurt_Syntax_ManchesterLexer extends AntlrLexer {
    static $MAX_LENGTH_LABEL=7;
    static $EXPONENT=54;
    static $CLOSE_SQUARE_BRACE=50;
    static $DECIMAL_LABEL=37;
    static $ONLY_LABEL=28;
    static $DIGITS=15;
    static $MAX_LABEL=32;
    static $FPLITERAL_HELPER=59;
    static $EOF=-1;
    static $STRING_LABEL=40;
    static $LANG_PATTERN_LABEL=9;
    static $FLOAT_LABEL=38;
    static $ABBREVIATED_IRI=56;
    static $INVERSE_LABEL=11;
    static $INTEGER_LABEL=39;
    static $GREATER=22;
    static $EOL=17;
    static $F_LABEL=4;
    static $OR_LABEL=25;
    static $COMMA=34;
    static $LESS=21;
    static $PN_CHARS_U=45;
    static $QUOTED_STRING=52;
    static $PLUS=14;
    static $DOT=13;
    static $DLITERAL_HELPER=58;
    static $OPEN_CURLY_BRACE=23;
    static $CLOSE_CURLY_BRACE=24;
    static $PATTERN_LABEL=8;
    static $SIMPLE_IRI=47;
    static $PREFIX_NAME=55;
    static $AND_LABEL=26;
    static $REFERENCE=41;
    static $FULL_IRI=46;
    static $CLOSE_BRACE=36;
    static $ILITERAL_HELPER=57;
    static $MINUS=12;
    static $LENGTH_LABEL=5;
    static $SOME_LABEL=27;
    static $Tokens=61;
    static $NODE_ID=48;
    static $ITFUCKINDOESNTWORK=60;
    static $OPEN_SQUARE_BRACE=49;
    static $ECHAR=51;
    static $WS=18;
    static $MIN_LABEL=31;
    static $PN_CHARS_BASE=44;
    static $THAT_LABEL=10;
    static $NOT_LABEL=16;
    static $PN_PREFIX=43;
    static $SELF_LABEL=30;
    static $PN_CHARS=42;
    static $MIN_LENGTH_LABEL=6;
    static $VALUE_LABEL=29;
    static $EXACTLY_LABEL=33;
    static $LESS_EQUAL=19;
    static $LANGUAGE_TAG=53;
    static $OPEN_BRACE=35;
    static $GREATER_EQUAL=20;

    // delegates
    /**
    * @param Erfurt_Syntax_Manchester_ManchesterTokenizer $gManchesterTokenizer
    */
    public $gManchesterTokenizer;
    // delegators

    function __construct($input, $state=null){
        parent::__construct($input,$state);
        $this->gManchesterTokenizer = new Erfurt_Syntax_Manchester_ManchesterTokenizer($input, $state);
        
            $this->dfa1 = new Erfurt_Syntax_ManchesterLexer_DFA1($this);
    }
    function getGrammarFileName() { return "src/Erfurt_Syntax_Manchester.g"; }

    // $ANTLR start "ITFUCKINDOESNTWORK"
    function mITFUCKINDOESNTWORK(){
        try {
            $_type = Erfurt_Syntax_ManchesterLexer::$ITFUCKINDOESNTWORK;
            $_channel = Erfurt_Syntax_ManchesterLexer::$DEFAULT_TOKEN_CHANNEL;
            // src/Erfurt_Syntax_Manchester.g:488:20: ( 'ggggggggr!!!' ) 
            // src/Erfurt_Syntax_Manchester.g:488:22: 'ggggggggr!!!' 
            {
            $this->matchString("ggggggggr!!!"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ITFUCKINDOESNTWORK"

    function mTokens(){
        // src/Erfurt_Syntax_Manchester.g:1:8: ( ITFUCKINDOESNTWORK | ManchesterTokenizer. Tokens ) 
        $alt1=2;
        $alt1 = $this->dfa1->predict($this->input);
        switch ($alt1) {
            case 1 :
                // src/Erfurt_Syntax_Manchester.g:1:10: ITFUCKINDOESNTWORK 
                {
                $this->mITFUCKINDOESNTWORK(); 

                }
                break;
            case 2 :
                // src/Erfurt_Syntax_Manchester.g:1:29: ManchesterTokenizer. Tokens 
                {
                $this->gManchesterTokenizer->mTokens(); 

                }
                break;

        }

    }



}
?>