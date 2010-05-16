<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 src/Erfurt_Sparql_Parser_Sparql10_Sparql10.g 2010-05-16 20:22:27


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
      

class Erfurt_Sparql_Parser_Sparql10_Sparql10Lexer extends AntlrLexer {
    static $PREFIX=5;
    static $EXPONENT=60;
    static $CLOSE_SQUARE_BRACE=97;
    static $GRAPH=24;
    static $REGEX=39;
    static $PNAME_LN=50;
    static $CONSTRUCT=10;
    static $NOT=6;
    static $EOF=-1;
    static $VARNAME=51;
    static $ISLITERAL=38;
    static $GREATER=43;
    static $EOL=74;
    static $NOT_EQUAL=95;
    static $LESS=42;
    static $LANGMATCHES=31;
    static $DOUBLE=61;
    static $PN_CHARS_U=77;
    static $BASE=4;
    static $COMMENT=84;
    static $OPEN_CURLY_BRACE=44;
    static $SELECT=7;
    static $CLOSE_CURLY_BRACE=45;
    static $DOUBLE_POSITIVE=65;
    static $DIVIDE=89;
    static $BOUND=33;
    static $ISIRI=35;
    static $A=27;
    static $NOT_SIGN=88;
    static $ASC=19;
    static $BLANK_NODE_LABEL=79;
    static $ASK=12;
    static $SEMICOLON=85;
    static $QUESTION_MARK_LABEL=99;
    static $ISBLANK=37;
    static $GROUP=17;
    static $OR_SINGLE=83;
    static $WS=75;
    static $INTEGER_POSITIVE=63;
    static $NAMED=14;
    static $STRING_LITERAL2=71;
    static $OR=82;
    static $FILTER=26;
    static $DESCRIBE=11;
    static $STRING_LITERAL1=70;
    static $PN_CHARS=78;
    static $DATATYPE=32;
    static $LESS_EQUAL=93;
    static $DOUBLE_NEGATIVE=68;
    static $FROM=13;
    static $FALSE=41;
    static $DISTINCT=8;
    static $LANG=30;
    static $WHERE=15;
    static $IRI_REF=46;
    static $ORDER=16;
    static $LIMIT=21;
    static $AND=81;
    static $ASTERISK=86;
    static $ISURI=36;
    static $STR=29;
    static $AS=28;
    static $SAMETERM=34;
    static $COMMA=87;
    static $OFFSET=22;
    static $DECIMAL_POSITIVE=64;
    static $EQUAL=90;
    static $PLUS=62;
    static $DIGIT=59;
    static $DOT=57;
    static $INTEGER=56;
    static $BY=18;
    static $REDUCED=9;
    static $INTEGER_NEGATIVE=66;
    static $PN_LOCAL=49;
    static $PNAME_NS=48;
    static $REFERENCE=80;
    static $CLOSE_BRACE=92;
    static $MINUS=54;
    static $Tokens=100;
    static $TRUE=40;
    static $OPEN_SQUARE_BRACE=96;
    static $UNION=25;
    static $ECHAR=69;
    static $OPTIONAL=23;
    static $HAT_LABEL=98;
    static $STRING_LITERAL_LONG2=73;
    static $PN_CHARS_BASE=76;
    static $DECIMAL=58;
    static $VAR1=52;
    static $STRING_LITERAL_LONG1=72;
    static $VAR2=53;
    static $DECIMAL_NEGATIVE=67;
    static $PN_PREFIX=47;
    static $DESC=20;
    static $OPEN_BRACE=91;
    static $GREATER_EQUAL=94;
    static $LANGTAG=55;

    private $_errors = array();

    public function emitErrorMessage($msg) {
         $this->_errors []= $msg;
      }
    public function getErrors(){
    	return $this->_errors;
    }


    // delegates
    /**
    * @param Erfurt_Sparql_Parser_Sparql10_Sparql10_Tokenizer $gTokenizer
    */
    public $gTokenizer;
    // delegators

    function __construct($input, $state=null){
        parent::__construct($input,$state);
        $this->gTokenizer = new Erfurt_Sparql_Parser_Sparql10_Sparql10_Tokenizer($input, $state);
        
    }
    function getGrammarFileName() { return "src/Erfurt_Sparql_Parser_Sparql10_Sparql10.g"; }

    // $ANTLR start "A"
    function mA(){
        try {
            $_type = Erfurt_Sparql_Parser_Sparql10_Sparql10Lexer::$A;
            $_channel = Erfurt_Sparql_Parser_Sparql10_Sparql10Lexer::$DEFAULT_TOKEN_CHANNEL;
            // src/Erfurt_Sparql_Parser_Sparql10_Sparql10.g:60:3: ( 'a' ) 
            // src/Erfurt_Sparql_Parser_Sparql10_Sparql10.g:61:3: 'a' 
            {
            $this->matchChar(97); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "A"

    function mTokens(){
        // src/Erfurt_Sparql_Parser_Sparql10_Sparql10.g:1:8: ( A | Tokenizer. Tokens ) 
        $alt1=2;
        $LA1_0 = $this->input->LA(1);

        if ( ($LA1_0==$this->getToken('97')) ) {
            $LA1_1 = $this->input->LA(2);

            if ( (($LA1_1>=$this->getToken('45') && $LA1_1<=$this->getToken('46'))||($LA1_1>=$this->getToken('48') && $LA1_1<=$this->getToken('58'))||$LA1_1==$this->getToken('95')||($LA1_1>=$this->getToken('97') && $LA1_1<=$this->getToken('122'))) ) {
                $alt1=2;
            }
            else {
                $alt1=1;}
        }
        else if ( (($LA1_0>=$this->getToken('9') && $LA1_0<=$this->getToken('10'))||$LA1_0==$this->getToken('13')||($LA1_0>=$this->getToken('32') && $LA1_0<=$this->getToken('36'))||($LA1_0>=$this->getToken('38') && $LA1_0<=$this->getToken('64'))||$LA1_0==$this->getToken('91')||($LA1_0>=$this->getToken('93') && $LA1_0<=$this->getToken('95'))||($LA1_0>=$this->getToken('98') && $LA1_0<=$this->getToken('125'))) ) {
            $alt1=2;
        }
        else {
            $nvae = new NoViableAltException("", 1, 0, $this->input);

            throw $nvae;
        }
        switch ($alt1) {
            case 1 :
                // src/Erfurt_Sparql_Parser_Sparql10_Sparql10.g:1:10: A 
                {
                $this->mA(); 

                }
                break;
            case 2 :
                // src/Erfurt_Sparql_Parser_Sparql10_Sparql10.g:1:12: Tokenizer. Tokens 
                {
                $this->gTokenizer->mTokens(); 

                }
                break;

        }

    }



}
?>