<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g 2010-03-22 22:31:43


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
      

class Erfurt_Sparql_Parser_Sparql11_QueryLexer extends AntlrLexer {
    static $PREFIX=22;
    static $EXPONENT=77;
    static $SILENT=12;
    static $CLOSE_SQUARE_BRACE=113;
    static $GRAPH=41;
    static $REGEX=56;
    static $PNAME_LN=67;
    static $CONSTRUCT=27;
    static $COUNT=17;
    static $NOT=23;
    static $EOF=-1;
    static $CLEAR=10;
    static $VARNAME=68;
    static $ISLITERAL=55;
    static $CREATE=11;
    static $GREATER=60;
    static $EOL=91;
    static $INSERT=7;
    static $NOT_EQUAL=111;
    static $LESS=59;
    static $LANGMATCHES=48;
    static $DOUBLE=78;
    static $BASE=21;
    static $PN_CHARS_U=94;
    static $COMMENT=100;
    static $OPEN_CURLY_BRACE=61;
    static $SELECT=24;
    static $CLOSE_CURLY_BRACE=62;
    static $INTO=8;
    static $DOUBLE_POSITIVE=82;
    static $BOUND=50;
    static $DIVIDE=105;
    static $ISIRI=52;
    static $COALESCE=18;
    static $A=44;
    static $NOT_SIGN=104;
    static $ASC=36;
    static $LOAD=9;
    static $ASK=29;
    static $BLANK_NODE_LABEL=96;
    static $SEMICOLON=101;
    static $DELETE=6;
    static $QUESTION_MARK_LABEL=115;
    static $ISBLANK=54;
    static $GROUP=34;
    static $WS=92;
    static $NAMED=31;
    static $INTEGER_POSITIVE=80;
    static $OR=99;
    static $STRING_LITERAL2=88;
    static $FILTER=43;
    static $DESCRIBE=28;
    static $STRING_LITERAL1=87;
    static $PN_CHARS=95;
    static $DATATYPE=49;
    static $LESS_EQUAL=109;
    static $DOUBLE_NEGATIVE=85;
    static $FROM=30;
    static $FALSE=58;
    static $DISTINCT=25;
    static $LANG=47;
    static $MODIFY=5;
    static $WHERE=32;
    static $IRI_REF=63;
    static $ORDER=33;
    static $LIMIT=38;
    static $AND=98;
    static $DEFINE=19;
    static $ASTERISK=102;
    static $IF=20;
    static $UNSAID=15;
    static $ISURI=53;
    static $AS=45;
    static $STR=46;
    static $SAMETERM=51;
    static $COMMA=103;
    static $OFFSET=39;
    static $EQUAL=106;
    static $DECIMAL_POSITIVE=81;
    static $PLUS=79;
    static $EXISTS=14;
    static $DIGIT=76;
    static $DOT=74;
    static $INTEGER=73;
    static $BY=35;
    static $REDUCED=26;
    static $INTEGER_NEGATIVE=83;
    static $PN_LOCAL=66;
    static $PNAME_NS=65;
    static $REFERENCE=97;
    static $HAVING=16;
    static $CLOSE_BRACE=108;
    static $MINUS=71;
    static $Tokens=116;
    static $TRUE=57;
    static $UNION=42;
    static $OPEN_SQUARE_BRACE=112;
    static $ECHAR=86;
    static $OPTIONAL=40;
    static $HAT_LABEL=114;
    static $STRING_LITERAL_LONG2=90;
    static $PN_CHARS_BASE=93;
    static $DECIMAL=75;
    static $VAR1=69;
    static $DROP=13;
    static $STRING_LITERAL_LONG1=89;
    static $VAR2=70;
    static $DECIMAL_NEGATIVE=84;
    static $PN_PREFIX=64;
    static $DESC=37;
    static $OPEN_BRACE=107;
    static $GREATER_EQUAL=110;
    static $DATA=4;
    static $LANGTAG=72;

    // delegates
    /**
    * @param Erfurt_Sparql_Parser_Sparql11_Query_Tokenizer11 $gTokenizer11
    */
    public $gTokenizer11;
    // delegators

    function __construct($input, $state=null){
        parent::__construct($input,$state);
        $this->gTokenizer11 = new Erfurt_Sparql_Parser_Sparql11_Query_Tokenizer11($input, $state);
        
    }
    function getGrammarFileName() { return "/Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g"; }

    // $ANTLR start "A"
    function mA(){
        try {
            $_type = Erfurt_Sparql_Parser_Sparql11_QueryLexer::$A;
            $_channel = Erfurt_Sparql_Parser_Sparql11_QueryLexer::$DEFAULT_TOKEN_CHANNEL;
            // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g:15:3: ( 'a' ) 
            // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g:16:3: 'a' 
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
        // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g:1:8: ( A | Tokenizer11. Tokens ) 
        $alt1=2;
        $LA1_0 = $this->input->LA(1);

        if ( ($LA1_0==$this->getToken('97')) ) {
            $LA1_1 = $this->input->LA(2);

            if ( (($LA1_1>=$this->getToken('45') && $LA1_1<=$this->getToken('46'))||($LA1_1>=$this->getToken('48') && $LA1_1<=$this->getToken('58'))||$LA1_1==$this->getToken('95')||($LA1_1>=$this->getToken('97') && $LA1_1<=$this->getToken('122'))||$LA1_1==$this->getToken('183')||($LA1_1>=$this->getToken('192') && $LA1_1<=$this->getToken('214'))||($LA1_1>=$this->getToken('216') && $LA1_1<=$this->getToken('246'))||($LA1_1>=$this->getToken('248') && $LA1_1<=$this->getToken('893'))||($LA1_1>=$this->getToken('895') && $LA1_1<=$this->getToken('8191'))||($LA1_1>=$this->getToken('8204') && $LA1_1<=$this->getToken('8205'))||($LA1_1>=$this->getToken('8255') && $LA1_1<=$this->getToken('8256'))||($LA1_1>=$this->getToken('8304') && $LA1_1<=$this->getToken('8591'))||($LA1_1>=$this->getToken('11264') && $LA1_1<=$this->getToken('12271'))||($LA1_1>=$this->getToken('12289') && $LA1_1<=$this->getToken('55295'))||($LA1_1>=$this->getToken('63744') && $LA1_1<=$this->getToken('64975'))||($LA1_1>=$this->getToken('65008') && $LA1_1<=$this->getToken('65533'))) ) {
                $alt1=2;
            }
            else {
                $alt1=1;}
        }
        else if ( (($LA1_0>=$this->getToken('9') && $LA1_0<=$this->getToken('10'))||$LA1_0==$this->getToken('13')||($LA1_0>=$this->getToken('32') && $LA1_0<=$this->getToken('36'))||($LA1_0>=$this->getToken('38') && $LA1_0<=$this->getToken('64'))||$LA1_0==$this->getToken('91')||($LA1_0>=$this->getToken('93') && $LA1_0<=$this->getToken('95'))||($LA1_0>=$this->getToken('98') && $LA1_0<=$this->getToken('125'))||($LA1_0>=$this->getToken('192') && $LA1_0<=$this->getToken('214'))||($LA1_0>=$this->getToken('216') && $LA1_0<=$this->getToken('246'))||($LA1_0>=$this->getToken('248') && $LA1_0<=$this->getToken('767'))||($LA1_0>=$this->getToken('880') && $LA1_0<=$this->getToken('893'))||($LA1_0>=$this->getToken('895') && $LA1_0<=$this->getToken('8191'))||($LA1_0>=$this->getToken('8204') && $LA1_0<=$this->getToken('8205'))||($LA1_0>=$this->getToken('8304') && $LA1_0<=$this->getToken('8591'))||($LA1_0>=$this->getToken('11264') && $LA1_0<=$this->getToken('12271'))||($LA1_0>=$this->getToken('12289') && $LA1_0<=$this->getToken('55295'))||($LA1_0>=$this->getToken('63744') && $LA1_0<=$this->getToken('64975'))||($LA1_0>=$this->getToken('65008') && $LA1_0<=$this->getToken('65533'))) ) {
            $alt1=2;
        }
        else {
            $nvae = new NoViableAltException("", 1, 0, $this->input);

            throw $nvae;
        }
        switch ($alt1) {
            case 1 :
                // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g:1:10: A 
                {
                $this->mA(); 

                }
                break;
            case 2 :
                // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g:1:12: Tokenizer11. Tokens 
                {
                $this->gTokenizer11->mTokens(); 

                }
                break;

        }

    }



}
?>