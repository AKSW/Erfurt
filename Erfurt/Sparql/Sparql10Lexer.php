<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 Erfurt_Sparql_Sparql10__.g 2010-02-17 13:38:23


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
      

class Erfurt_Sparql_Sparql10Lexer extends AntlrLexer {
    static $PREFIX=5;
    static $EXPONENT=80;
    static $SILENT=14;
    static $CLOSE_SQUARE_BRACE=116;
    static $GRAPH=37;
    static $REGEX=52;
    static $PNAME_LN=70;
    static $CONSTRUCT=22;
    static $COUNT=53;
    static $NOT=18;
    static $EOF=-1;
    static $CLEAR=12;
    static $VARNAME=71;
    static $ISLITERAL=51;
    static $CREATE=13;
    static $EOL=94;
    static $GREATER=63;
    static $INSERT=8;
    static $NOT_EQUAL=114;
    static $LESS=62;
    static $LANGMATCHES=44;
    static $DOUBLE=81;
    static $BASE=4;
    static $PN_CHARS_U=97;
    static $COMMENT=103;
    static $OPEN_CURLY_BRACE=64;
    static $SELECT=19;
    static $CLOSE_CURLY_BRACE=65;
    static $INTO=10;
    static $DOUBLE_POSITIVE=85;
    static $BOUND=46;
    static $DIVIDE=108;
    static $ISIRI=48;
    static $COALESCE=61;
    static $A=40;
    static $NOT_SIGN=107;
    static $ASC=32;
    static $LOAD=11;
    static $ASK=24;
    static $BLANK_NODE_LABEL=99;
    static $SEMICOLON=104;
    static $DELETE=7;
    static $ISBLANK=50;
    static $GROUP=29;
    static $WS=95;
    static $NAMED=26;
    static $INTEGER_POSITIVE=83;
    static $OR=102;
    static $STRING_LITERAL2=91;
    static $FILTER=39;
    static $DESCRIBE=23;
    static $STRING_LITERAL1=90;
    static $PN_CHARS=98;
    static $DATATYPE=45;
    static $LESS_EQUAL=112;
    static $DOUBLE_NEGATIVE=88;
    static $FROM=25;
    static $FALSE=59;
    static $DISTINCT=20;
    static $LANG=43;
    static $MODIFY=6;
    static $WHERE=27;
    static $IRI_REF=66;
    static $ORDER=28;
    static $LIMIT=34;
    static $T__117=117;
    static $MAX=56;
    static $AND=101;
    static $SUM=54;
    static $ASTERISK=105;
    static $IF=60;
    static $UNSAID=17;
    static $ISURI=49;
    static $STR=42;
    static $AS=41;
    static $SAMETERM=47;
    static $COMMA=106;
    static $OFFSET=35;
    static $AVG=57;
    static $EQUAL=109;
    static $DECIMAL_POSITIVE=84;
    static $PLUS=82;
    static $EXISTS=16;
    static $DIGIT=79;
    static $DOT=77;
    static $INTEGER=76;
    static $BY=31;
    static $REDUCED=21;
    static $INTEGER_NEGATIVE=86;
    static $PN_LOCAL=69;
    static $PNAME_NS=68;
    static $REFERENCE=100;
    static $HAVING=30;
    static $MIN=55;
    static $CLOSE_BRACE=111;
    static $MINUS=74;
    static $Tokens=118;
    static $TRUE=58;
    static $UNION=38;
    static $OPEN_SQUARE_BRACE=115;
    static $ECHAR=89;
    static $OPTIONAL=36;
    static $STRING_LITERAL_LONG2=93;
    static $PN_CHARS_BASE=96;
    static $DECIMAL=78;
    static $VAR1=72;
    static $DROP=15;
    static $VAR2=73;
    static $STRING_LITERAL_LONG1=92;
    static $DECIMAL_NEGATIVE=87;
    static $PN_PREFIX=67;
    static $DESC=33;
    static $OPEN_BRACE=110;
    static $GREATER_EQUAL=113;
    static $DATA=9;
    static $LANGTAG=75;

    // delegates
    /**
    * @param Erfurt_Sparql_Sparql10_Tokens $gTokens
    */
    public $gTokens;
    // delegators

    function __construct($input, $state=null){
        parent::__construct($input,$state);
        $this->gTokens = new Erfurt_Sparql_Sparql10_Tokens($input, $state);
        
    }
    function getGrammarFileName() { return "Erfurt_Sparql_Sparql10__.g"; }

    // $ANTLR start "T__117"
    function mT__117(){
        try {
            $_type = Erfurt_Sparql_Sparql10Lexer::$T__117;
            $_channel = Erfurt_Sparql_Sparql10Lexer::$DEFAULT_TOKEN_CHANNEL;
            // Erfurt_Sparql_Sparql10__.g:7:8: ( 'fake' ) 
            // Erfurt_Sparql_Sparql10__.g:7:10: 'fake' 
            {
            $this->matchString("fake"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "T__117"

    function mTokens(){
        // Erfurt_Sparql_Sparql10__.g:1:8: ( T__117 | Tokens. Tokens ) 
        $alt1=2;
        $LA1_0 = $this->input->LA(1);

        if ( ($LA1_0==$this->getToken('102')) ) {
            $LA1_1 = $this->input->LA(2);

            if ( ($LA1_1==$this->getToken('97')) ) {
                $LA1_3 = $this->input->LA(3);

                if ( ($LA1_3==$this->getToken('107')) ) {
                    $LA1_4 = $this->input->LA(4);

                    if ( ($LA1_4==$this->getToken('101')) ) {
                        $LA1_5 = $this->input->LA(5);

                        if ( (($LA1_5>=$this->getToken('45') && $LA1_5<=$this->getToken('46'))||($LA1_5>=$this->getToken('48') && $LA1_5<=$this->getToken('58'))||($LA1_5>=$this->getToken('65') && $LA1_5<=$this->getToken('90'))||$LA1_5==$this->getToken('95')||($LA1_5>=$this->getToken('97') && $LA1_5<=$this->getToken('122'))||$LA1_5==$this->getToken('183')||($LA1_5>=$this->getToken('192') && $LA1_5<=$this->getToken('214'))||($LA1_5>=$this->getToken('216') && $LA1_5<=$this->getToken('246'))||($LA1_5>=$this->getToken('248') && $LA1_5<=$this->getToken('893'))||($LA1_5>=$this->getToken('895') && $LA1_5<=$this->getToken('8191'))||($LA1_5>=$this->getToken('8204') && $LA1_5<=$this->getToken('8205'))||($LA1_5>=$this->getToken('8255') && $LA1_5<=$this->getToken('8256'))||($LA1_5>=$this->getToken('8304') && $LA1_5<=$this->getToken('8591'))||($LA1_5>=$this->getToken('11264') && $LA1_5<=$this->getToken('12271'))||($LA1_5>=$this->getToken('12289') && $LA1_5<=$this->getToken('55295'))||($LA1_5>=$this->getToken('63744') && $LA1_5<=$this->getToken('64975'))||($LA1_5>=$this->getToken('65008') && $LA1_5<=$this->getToken('65533'))) ) {
                            $alt1=2;
                        }
                        else {
                            $alt1=1;}
                    }
                    else if ( (($LA1_4>=$this->getToken('45') && $LA1_4<=$this->getToken('46'))||($LA1_4>=$this->getToken('48') && $LA1_4<=$this->getToken('58'))||($LA1_4>=$this->getToken('65') && $LA1_4<=$this->getToken('90'))||$LA1_4==$this->getToken('95')||($LA1_4>=$this->getToken('97') && $LA1_4<=$this->getToken('100'))||($LA1_4>=$this->getToken('102') && $LA1_4<=$this->getToken('122'))||$LA1_4==$this->getToken('183')||($LA1_4>=$this->getToken('192') && $LA1_4<=$this->getToken('214'))||($LA1_4>=$this->getToken('216') && $LA1_4<=$this->getToken('246'))||($LA1_4>=$this->getToken('248') && $LA1_4<=$this->getToken('893'))||($LA1_4>=$this->getToken('895') && $LA1_4<=$this->getToken('8191'))||($LA1_4>=$this->getToken('8204') && $LA1_4<=$this->getToken('8205'))||($LA1_4>=$this->getToken('8255') && $LA1_4<=$this->getToken('8256'))||($LA1_4>=$this->getToken('8304') && $LA1_4<=$this->getToken('8591'))||($LA1_4>=$this->getToken('11264') && $LA1_4<=$this->getToken('12271'))||($LA1_4>=$this->getToken('12289') && $LA1_4<=$this->getToken('55295'))||($LA1_4>=$this->getToken('63744') && $LA1_4<=$this->getToken('64975'))||($LA1_4>=$this->getToken('65008') && $LA1_4<=$this->getToken('65533'))) ) {
                        $alt1=2;
                    }
                    else {
                        $nvae = new NoViableAltException("", 1, 4, $this->input);

                        throw $nvae;
                    }
                }
                else if ( (($LA1_3>=$this->getToken('45') && $LA1_3<=$this->getToken('46'))||($LA1_3>=$this->getToken('48') && $LA1_3<=$this->getToken('58'))||($LA1_3>=$this->getToken('65') && $LA1_3<=$this->getToken('90'))||$LA1_3==$this->getToken('95')||($LA1_3>=$this->getToken('97') && $LA1_3<=$this->getToken('106'))||($LA1_3>=$this->getToken('108') && $LA1_3<=$this->getToken('122'))||$LA1_3==$this->getToken('183')||($LA1_3>=$this->getToken('192') && $LA1_3<=$this->getToken('214'))||($LA1_3>=$this->getToken('216') && $LA1_3<=$this->getToken('246'))||($LA1_3>=$this->getToken('248') && $LA1_3<=$this->getToken('893'))||($LA1_3>=$this->getToken('895') && $LA1_3<=$this->getToken('8191'))||($LA1_3>=$this->getToken('8204') && $LA1_3<=$this->getToken('8205'))||($LA1_3>=$this->getToken('8255') && $LA1_3<=$this->getToken('8256'))||($LA1_3>=$this->getToken('8304') && $LA1_3<=$this->getToken('8591'))||($LA1_3>=$this->getToken('11264') && $LA1_3<=$this->getToken('12271'))||($LA1_3>=$this->getToken('12289') && $LA1_3<=$this->getToken('55295'))||($LA1_3>=$this->getToken('63744') && $LA1_3<=$this->getToken('64975'))||($LA1_3>=$this->getToken('65008') && $LA1_3<=$this->getToken('65533'))) ) {
                    $alt1=2;
                }
                else {
                    $nvae = new NoViableAltException("", 1, 3, $this->input);

                    throw $nvae;
                }
            }
            else if ( (($LA1_1>=$this->getToken('45') && $LA1_1<=$this->getToken('46'))||($LA1_1>=$this->getToken('48') && $LA1_1<=$this->getToken('58'))||($LA1_1>=$this->getToken('65') && $LA1_1<=$this->getToken('90'))||$LA1_1==$this->getToken('95')||($LA1_1>=$this->getToken('98') && $LA1_1<=$this->getToken('122'))||$LA1_1==$this->getToken('183')||($LA1_1>=$this->getToken('192') && $LA1_1<=$this->getToken('214'))||($LA1_1>=$this->getToken('216') && $LA1_1<=$this->getToken('246'))||($LA1_1>=$this->getToken('248') && $LA1_1<=$this->getToken('893'))||($LA1_1>=$this->getToken('895') && $LA1_1<=$this->getToken('8191'))||($LA1_1>=$this->getToken('8204') && $LA1_1<=$this->getToken('8205'))||($LA1_1>=$this->getToken('8255') && $LA1_1<=$this->getToken('8256'))||($LA1_1>=$this->getToken('8304') && $LA1_1<=$this->getToken('8591'))||($LA1_1>=$this->getToken('11264') && $LA1_1<=$this->getToken('12271'))||($LA1_1>=$this->getToken('12289') && $LA1_1<=$this->getToken('55295'))||($LA1_1>=$this->getToken('63744') && $LA1_1<=$this->getToken('64975'))||($LA1_1>=$this->getToken('65008') && $LA1_1<=$this->getToken('65533'))) ) {
                $alt1=2;
            }
            else {
                $nvae = new NoViableAltException("", 1, 1, $this->input);

                throw $nvae;
            }
        }
        else if ( (($LA1_0>=$this->getToken('9') && $LA1_0<=$this->getToken('10'))||$LA1_0==$this->getToken('13')||($LA1_0>=$this->getToken('32') && $LA1_0<=$this->getToken('36'))||($LA1_0>=$this->getToken('38') && $LA1_0<=$this->getToken('91'))||($LA1_0>=$this->getToken('93') && $LA1_0<=$this->getToken('95'))||($LA1_0>=$this->getToken('97') && $LA1_0<=$this->getToken('101'))||($LA1_0>=$this->getToken('103') && $LA1_0<=$this->getToken('125'))||($LA1_0>=$this->getToken('192') && $LA1_0<=$this->getToken('214'))||($LA1_0>=$this->getToken('216') && $LA1_0<=$this->getToken('246'))||($LA1_0>=$this->getToken('248') && $LA1_0<=$this->getToken('767'))||($LA1_0>=$this->getToken('880') && $LA1_0<=$this->getToken('893'))||($LA1_0>=$this->getToken('895') && $LA1_0<=$this->getToken('8191'))||($LA1_0>=$this->getToken('8204') && $LA1_0<=$this->getToken('8205'))||($LA1_0>=$this->getToken('8304') && $LA1_0<=$this->getToken('8591'))||($LA1_0>=$this->getToken('11264') && $LA1_0<=$this->getToken('12271'))||($LA1_0>=$this->getToken('12289') && $LA1_0<=$this->getToken('55295'))||($LA1_0>=$this->getToken('63744') && $LA1_0<=$this->getToken('64975'))||($LA1_0>=$this->getToken('65008') && $LA1_0<=$this->getToken('65533'))) ) {
            $alt1=2;
        }
        else {
            $nvae = new NoViableAltException("", 1, 0, $this->input);

            throw $nvae;
        }
        switch ($alt1) {
            case 1 :
                // Erfurt_Sparql_Sparql10__.g:1:10: T__117 
                {
                $this->mT__117(); 

                }
                break;
            case 2 :
                // Erfurt_Sparql_Sparql10__.g:1:17: Tokens. Tokens 
                {
                $this->gTokens->mTokens(); 

                }
                break;

        }

    }



}
?>