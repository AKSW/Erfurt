<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 src/Erfurt_Syntax_Manchester.g 2010-11-04 23:29:17


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
    static $EXPONENT=89;
    static $CLOSE_SQUARE_BRACE=85;
    static $DECIMAL_LABEL=38;
    static $ONLY_LABEL=29;
    static $FPLITERAL_HELPER=94;
    static $DISJOINT_CLASSES_LABEL=60;
    static $SUBCLASS_OF_LABEL=66;
    static $INDIVIDUAL_LABEL=53;
    static $EOF=-1;
    static $LANG_PATTERN_LABEL=10;
    static $DISJOINT_UNION_OF_LABEL=68;
    static $ANNOTATION_PROPERTY_LABEL=49;
    static $FLOAT_LABEL=39;
    static $FACTS_LABEL=55;
    static $DISJOINT_PROPERTIES_LABEL=62;
    static $CHARACTERISTICS_LABEL=44;
    static $ABBREVIATED_IRI=91;
    static $DATA_PROPERTY_LABEL=48;
    static $EOL=18;
    static $GREATER=23;
    static $INTEGER_LABEL=40;
    static $DISJOINT_WITH_LABEL=67;
    static $EQUIVALENT_TO_LABEL=65;
    static $OR_LABEL=26;
    static $ANNOTATIONS_LABEL=72;
    static $OBJECT_PROPERTY_LABEL=47;
    static $LESS=22;
    static $PN_CHARS_U=80;
    static $ONTOLOGY_LABEL=52;
    static $OPEN_CURLY_BRACE=24;
    static $CLOSE_CURLY_BRACE=25;
    static $PATTERN_LABEL=9;
    static $SIMPLE_IRI=82;
    static $FULL_IRI=81;
    static $NODE_ID=83;
    static $ITFUCKINDOESNTWORK=95;
    static $NAMED_INDIVIDUAL_LABEL=50;
    static $WS=19;
    static $DIFFERENET_FROM_LABEL=57;
    static $SELF_LABEL=31;
    static $PN_CHARS=77;
    static $EXACTLY_LABEL=34;
    static $LESS_EQUAL=20;
    static $LANGUAGE_TAG=88;
    static $TYPES_LABEL=54;
    static $MAX_LENGTH_LABEL=8;
    static $IMPORT_LABEL=71;
    static $DIGITS=16;
    static $MAX_LABEL=33;
    static $SUB_PROPERTY_OF_LABEL=45;
    static $STRING_LABEL=41;
    static $INVERSE_OF_LABEL=70;
    static $FUNCTIONAL_LABEL=74;
    static $DATATYPE_LABEL=58;
    static $EQUIVALENT_CLASSES_LABEL=59;
    static $INVERSE_LABEL=12;
    static $DIFFERENT_INDIVIDUALS_LABEL=64;
    static $F_LABEL=5;
    static $COMMA=35;
    static $SUB_PROPERTY_CHAIN_LABEL=46;
    static $HAS_KEY_LABEL=69;
    static $PLUS=15;
    static $QUOTED_STRING=87;
    static $PREFIX_LABEL=51;
    static $SAME_AS_LABEL=56;
    static $SAME_INDIVIDUAL_LABEL=63;
    static $DOT=14;
    static $DLITERAL_HELPER=93;
    static $EQUIVALENT_PROPERTIES_LABEL=61;
    static $PREFIX_NAME=90;
    static $AND_LABEL=27;
    static $REFERENCE=42;
    static $CLOSE_BRACE=37;
    static $ILITERAL_HELPER=92;
    static $SOME_LABEL=28;
    static $LENGTH_LABEL=6;
    static $MINUS=13;
    static $Tokens=96;
    static $OPEN_SQUARE_BRACE=84;
    static $RANGE_LABEL=43;
    static $ECHAR=86;
    static $DOMAIN_LABEL=76;
    static $O_LABEL=4;
    static $MIN_LABEL=32;
    static $OBJECT_PROPERTY_CHARACTERISTIC=75;
    static $PN_CHARS_BASE=79;
    static $CLASS_LABEL=73;
    static $THAT_LABEL=11;
    static $NOT_LABEL=17;
    static $PN_PREFIX=78;
    static $MIN_LENGTH_LABEL=7;
    static $VALUE_LABEL=30;
    static $OPEN_BRACE=36;
    static $GREATER_EQUAL=21;

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