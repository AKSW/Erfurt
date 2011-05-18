<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 Sparql10.g 2010-03-22 18:29:03


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class Erfurt_Sparql_Parser_Sparql11_Update_Sparql10 extends AntlrParser {
    public $PREFIX=22;
    public $EXPONENT=77;
    public $SILENT=12;
    public $CLOSE_SQUARE_BRACE=113;
    public $GRAPH=41;
    public $REGEX=56;
    public $PNAME_LN=67;
    public $CONSTRUCT=27;
    public $COUNT=17;
    public $NOT=23;
    public $EOF=-1;
    public $CLEAR=10;
    public $VARNAME=68;
    public $ISLITERAL=55;
    public $CREATE=11;
    public $GREATER=60;
    public $EOL=91;
    public $INSERT=7;
    public $NOT_EQUAL=111;
    public $LESS=59;
    public $LANGMATCHES=48;
    public $DOUBLE=78;
    public $PN_CHARS_U=94;
    public $BASE=21;
    public $COMMENT=100;
    public $SELECT=24;
    public $OPEN_CURLY_BRACE=61;
    public $INTO=8;
    public $CLOSE_CURLY_BRACE=62;
    public $DOUBLE_POSITIVE=82;
    public $DIVIDE=105;
    public $BOUND=50;
    public $ISIRI=52;
    public $COALESCE=18;
    public $A=44;
    public $NOT_SIGN=104;
    public $ASC=36;
    public $BLANK_NODE_LABEL=96;
    public $ASK=29;
    public $LOAD=9;
    public $SEMICOLON=101;
    public $DELETE=6;
    public $QUESTION_MARK_LABEL=115;
    public $ISBLANK=54;
    public $GROUP=34;
    public $WS=92;
    public $NAMED=31;
    public $INTEGER_POSITIVE=80;
    public $OR=99;
    public $STRING_LITERAL2=88;
    public $FILTER=43;
    public $DESCRIBE=28;
    public $STRING_LITERAL1=87;
    public $PN_CHARS=95;
    public $DATATYPE=49;
    public $LESS_EQUAL=109;
    public $DOUBLE_NEGATIVE=85;
    public $FROM=30;
    public $FALSE=58;
    public $DISTINCT=25;
    public $LANG=47;
    public $MODIFY=5;
    public $WHERE=32;
    public $IRI_REF=63;
    public $ORDER=33;
    public $LIMIT=38;
    public $MAX=118;
    public $SUM=116;
    public $AND=98;
    public $DEFINE=19;
    public $ASTERISK=102;
    public $IF=20;
    public $UNSAID=15;
    public $ISURI=53;
    public $AS=45;
    public $STR=46;
    public $SAMETERM=51;
    public $COMMA=103;
    public $OFFSET=39;
    public $AVG=119;
    public $EQUAL=106;
    public $DECIMAL_POSITIVE=81;
    public $PLUS=79;
    public $EXISTS=14;
    public $DIGIT=76;
    public $DOT=74;
    public $INTEGER=73;
    public $BY=35;
    public $REDUCED=26;
    public $INTEGER_NEGATIVE=83;
    public $PN_LOCAL=66;
    public $PNAME_NS=65;
    public $REFERENCE=97;
    public $HAVING=16;
    public $MIN=117;
    public $CLOSE_BRACE=108;
    public $MINUS=71;
    public $TRUE=57;
    public $OPEN_SQUARE_BRACE=112;
    public $UNION=42;
    public $ECHAR=86;
    public $OPTIONAL=40;
    public $HAT_LABEL=114;
    public $PN_CHARS_BASE=93;
    public $STRING_LITERAL_LONG2=90;
    public $DECIMAL=75;
    public $DROP=13;
    public $VAR1=69;
    public $VAR2=70;
    public $STRING_LITERAL_LONG1=89;
    public $DECIMAL_NEGATIVE=84;
    public $PN_PREFIX=64;
    public $DESC=37;
    public $OPEN_BRACE=107;
    public $GREATER_EQUAL=110;
    public $DATA=4;
    public $LANGTAG=72;

    // delegates
    // delegators
    public $gErfurt_Sparql_Parser_Sparql11_Update;
    public $gParent;

    
    static $FOLLOW_prologue_in_query1021;
    static $FOLLOW_selectQuery_in_query1031;
    static $FOLLOW_constructQuery_in_query1039;
    static $FOLLOW_describeQuery_in_query1047;
    static $FOLLOW_askQuery_in_query1055;
    static $FOLLOW_baseDecl_in_prologue77;
    static $FOLLOW_prefixDecl_in_prologue80;
    static $FOLLOW_BASE_in_baseDecl99;
    static $FOLLOW_iriRef_in_baseDecl103;
    static $FOLLOW_PREFIX_in_prefixDecl121;
    static $FOLLOW_PNAME_NS_in_prefixDecl126;
    static $FOLLOW_iriRef_in_prefixDecl128;
    static $FOLLOW_SELECT_in_selectQuery146;
    static $FOLLOW_set_in_selectQuery150;
    static $FOLLOW_variable_in_selectQuery179;
    static $FOLLOW_ASTERISK_in_selectQuery188;
    static $FOLLOW_datasetClause_in_selectQuery196;
    static $FOLLOW_whereClause_in_selectQuery199;
    static $FOLLOW_solutionModifier_in_selectQuery201;
    static $FOLLOW_CONSTRUCT_in_constructQuery219;
    static $FOLLOW_constructTemplate_in_constructQuery224;
    static $FOLLOW_datasetClause_in_constructQuery226;
    static $FOLLOW_whereClause_in_constructQuery229;
    static $FOLLOW_solutionModifier_in_constructQuery231;
    static $FOLLOW_DESCRIBE_in_describeQuery249;
    static $FOLLOW_varOrIRIref_in_describeQuery259;
    static $FOLLOW_ASTERISK_in_describeQuery268;
    static $FOLLOW_datasetClause_in_describeQuery276;
    static $FOLLOW_whereClause_in_describeQuery279;
    static $FOLLOW_solutionModifier_in_describeQuery282;
    static $FOLLOW_ASK_in_askQuery300;
    static $FOLLOW_datasetClause_in_askQuery305;
    static $FOLLOW_whereClause_in_askQuery308;
    static $FOLLOW_FROM_in_datasetClause326;
    static $FOLLOW_defaultGraphClause_in_datasetClause336;
    static $FOLLOW_namedGraphClause_in_datasetClause344;
    static $FOLLOW_sourceSelector_in_defaultGraphClause366;
    static $FOLLOW_NAMED_in_namedGraphClause384;
    static $FOLLOW_sourceSelector_in_namedGraphClause389;
    static $FOLLOW_iriRef_in_sourceSelector407;
    static $FOLLOW_WHERE_in_whereClause425;
    static $FOLLOW_groupGraphPattern_in_whereClause428;
    static $FOLLOW_orderClause_in_solutionModifier446;
    static $FOLLOW_limitOffsetClauses_in_solutionModifier449;
    static $FOLLOW_limitClause_in_limitOffsetClauses467;
    static $FOLLOW_offsetClause_in_limitOffsetClauses469;
    static $FOLLOW_offsetClause_in_limitOffsetClauses476;
    static $FOLLOW_limitClause_in_limitOffsetClauses478;
    static $FOLLOW_ORDER_in_orderClause497;
    static $FOLLOW_BY_in_orderClause499;
    static $FOLLOW_orderCondition_in_orderClause501;
    static $FOLLOW_ASC_in_orderCondition536;
    static $FOLLOW_DESC_in_orderCondition548;
    static $FOLLOW_brackettedExpression_in_orderCondition560;
    static $FOLLOW_constraint_in_orderCondition580;
    static $FOLLOW_variable_in_orderCondition590;
    static $FOLLOW_LIMIT_in_limitClause612;
    static $FOLLOW_INTEGER_in_limitClause614;
    static $FOLLOW_OFFSET_in_offsetClause632;
    static $FOLLOW_INTEGER_in_offsetClause634;
    static $FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern652;
    static $FOLLOW_triplesBlock_in_groupGraphPattern657;
    static $FOLLOW_graphPatternNotTriples_in_groupGraphPattern679;
    static $FOLLOW_filter_in_groupGraphPattern691;
    static $FOLLOW_DOT_in_groupGraphPattern703;
    static $FOLLOW_triplesBlock_in_groupGraphPattern709;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern720;
    static $FOLLOW_triplesSameSubject_in_triplesBlock738;
    static $FOLLOW_DOT_in_triplesBlock741;
    static $FOLLOW_triplesBlock_in_triplesBlock746;
    static $FOLLOW_optionalGraphPattern_in_graphPatternNotTriples770;
    static $FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples778;
    static $FOLLOW_graphGraphPattern_in_graphPatternNotTriples786;
    static $FOLLOW_OPTIONAL_in_optionalGraphPattern804;
    static $FOLLOW_groupGraphPattern_in_optionalGraphPattern806;
    static $FOLLOW_GRAPH_in_graphGraphPattern824;
    static $FOLLOW_varOrIRIref_in_graphGraphPattern826;
    static $FOLLOW_groupGraphPattern_in_graphGraphPattern828;
    static $FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern848;
    static $FOLLOW_UNION_in_groupOrUnionGraphPattern851;
    static $FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern855;
    static $FOLLOW_FILTER_in_filter875;
    static $FOLLOW_constraint_in_filter877;
    static $FOLLOW_brackettedExpression_in_constraint897;
    static $FOLLOW_builtInCall_in_constraint905;
    static $FOLLOW_functionCall_in_constraint913;
    static $FOLLOW_iriRef_in_functionCall930;
    static $FOLLOW_argList_in_functionCall932;
    static $FOLLOW_OPEN_BRACE_in_argList950;
    static $FOLLOW_WS_in_argList952;
    static $FOLLOW_CLOSE_BRACE_in_argList955;
    static $FOLLOW_OPEN_BRACE_in_argList961;
    static $FOLLOW_expression_in_argList965;
    static $FOLLOW_COMMA_in_argList968;
    static $FOLLOW_expression_in_argList972;
    static $FOLLOW_CLOSE_BRACE_in_argList976;
    static $FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate994;
    static $FOLLOW_constructTriples_in_constructTemplate997;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate1001;
    static $FOLLOW_OPEN_CURLY_BRACE_in_constructTriples1019;
    static $FOLLOW_constructTriples_in_constructTriples1022;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_constructTriples1026;
    static $FOLLOW_varOrTerm_in_triplesSameSubject1044;
    static $FOLLOW_propertyListNotEmpty_in_triplesSameSubject1046;
    static $FOLLOW_triplesNode_in_triplesSameSubject1052;
    static $FOLLOW_propertyList_in_triplesSameSubject1054;
    static $FOLLOW_verb_in_propertyListNotEmpty1074;
    static $FOLLOW_objectList_in_propertyListNotEmpty1078;
    static $FOLLOW_SEMICOLON_in_propertyListNotEmpty1081;
    static $FOLLOW_verb_in_propertyListNotEmpty1086;
    static $FOLLOW_objectList_in_propertyListNotEmpty1090;
    static $FOLLOW_propertyListNotEmpty_in_propertyList1113;
    static $FOLLOW_object_in_objectList1135;
    static $FOLLOW_COMMA_in_objectList1138;
    static $FOLLOW_object_in_objectList1142;
    static $FOLLOW_graphNode_in_object1162;
    static $FOLLOW_varOrIRIref_in_verb1180;
    static $FOLLOW_A_in_verb1186;
    static $FOLLOW_collection_in_triplesNode1204;
    static $FOLLOW_blankNodePropertyList_in_triplesNode1210;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1228;
    static $FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1230;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1232;
    static $FOLLOW_OPEN_BRACE_in_collection1250;
    static $FOLLOW_graphNode_in_collection1253;
    static $FOLLOW_CLOSE_BRACE_in_collection1257;
    static $FOLLOW_varOrTerm_in_graphNode1275;
    static $FOLLOW_triplesNode_in_graphNode1281;
    static $FOLLOW_variable_in_varOrTerm1299;
    static $FOLLOW_graphTerm_in_varOrTerm1305;
    static $FOLLOW_variable_in_varOrIRIref1323;
    static $FOLLOW_iriRef_in_varOrIRIref1329;
    static $FOLLOW_VAR1_in_variable1349;
    static $FOLLOW_VAR2_in_variable1357;
    static $FOLLOW_iriRef_in_graphTerm1377;
    static $FOLLOW_rdfLiteral_in_graphTerm1385;
    static $FOLLOW_numericLiteral_in_graphTerm1393;
    static $FOLLOW_booleanLiteral_in_graphTerm1401;
    static $FOLLOW_blankNode_in_graphTerm1409;
    static $FOLLOW_OPEN_BRACE_in_graphTerm1415;
    static $FOLLOW_WS_in_graphTerm1417;
    static $FOLLOW_CLOSE_BRACE_in_graphTerm1420;
    static $FOLLOW_conditionalOrExpression_in_expression1438;
    static $FOLLOW_conditionalAndExpression_in_conditionalOrExpression1458;
    static $FOLLOW_OR_in_conditionalOrExpression1461;
    static $FOLLOW_conditionalAndExpression_in_conditionalOrExpression1465;
    static $FOLLOW_valueLogical_in_conditionalAndExpression1487;
    static $FOLLOW_AND_in_conditionalAndExpression1490;
    static $FOLLOW_valueLogical_in_conditionalAndExpression1494;
    static $FOLLOW_relationalExpression_in_valueLogical1514;
    static $FOLLOW_numericExpression_in_relationalExpression1534;
    static $FOLLOW_EQUAL_in_relationalExpression1544;
    static $FOLLOW_numericExpression_in_relationalExpression1548;
    static $FOLLOW_NOT_EQUAL_in_relationalExpression1556;
    static $FOLLOW_numericExpression_in_relationalExpression1560;
    static $FOLLOW_LESS_in_relationalExpression1568;
    static $FOLLOW_numericExpression_in_relationalExpression1572;
    static $FOLLOW_GREATER_in_relationalExpression1580;
    static $FOLLOW_numericExpression_in_relationalExpression1584;
    static $FOLLOW_LESS_EQUAL_in_relationalExpression1592;
    static $FOLLOW_numericExpression_in_relationalExpression1596;
    static $FOLLOW_GREATER_EQUAL_in_relationalExpression1604;
    static $FOLLOW_numericExpression_in_relationalExpression1608;
    static $FOLLOW_additiveExpression_in_numericExpression1631;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1651;
    static $FOLLOW_PLUS_in_additiveExpression1671;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1675;
    static $FOLLOW_MINUS_in_additiveExpression1687;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1691;
    static $FOLLOW_numericLiteralPositive_in_additiveExpression1703;
    static $FOLLOW_numericLiteralNegative_in_additiveExpression1715;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1746;
    static $FOLLOW_ASTERISK_in_multiplicativeExpression1766;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1770;
    static $FOLLOW_DIVIDE_in_multiplicativeExpression1782;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1786;
    static $FOLLOW_NOT_SIGN_in_unaryExpression1815;
    static $FOLLOW_primaryExpression_in_unaryExpression1819;
    static $FOLLOW_PLUS_in_unaryExpression1825;
    static $FOLLOW_primaryExpression_in_unaryExpression1829;
    static $FOLLOW_MINUS_in_unaryExpression1835;
    static $FOLLOW_primaryExpression_in_unaryExpression1839;
    static $FOLLOW_primaryExpression_in_unaryExpression1847;
    static $FOLLOW_brackettedExpression_in_primaryExpression1867;
    static $FOLLOW_builtInCall_in_primaryExpression1875;
    static $FOLLOW_iriRefOrFunction_in_primaryExpression1883;
    static $FOLLOW_rdfLiteral_in_primaryExpression1891;
    static $FOLLOW_numericLiteral_in_primaryExpression1899;
    static $FOLLOW_booleanLiteral_in_primaryExpression1907;
    static $FOLLOW_variable_in_primaryExpression1915;
    static $FOLLOW_OPEN_BRACE_in_brackettedExpression1933;
    static $FOLLOW_expression_in_brackettedExpression1937;
    static $FOLLOW_CLOSE_BRACE_in_brackettedExpression1939;
    static $FOLLOW_STR_in_builtInCall1957;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1959;
    static $FOLLOW_expression_in_builtInCall1963;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1965;
    static $FOLLOW_LANG_in_builtInCall1971;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1973;
    static $FOLLOW_expression_in_builtInCall1977;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1979;
    static $FOLLOW_LANGMATCHES_in_builtInCall1985;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1987;
    static $FOLLOW_expression_in_builtInCall1991;
    static $FOLLOW_COMMA_in_builtInCall1993;
    static $FOLLOW_expression_in_builtInCall1997;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1999;
    static $FOLLOW_DATATYPE_in_builtInCall2005;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2007;
    static $FOLLOW_expression_in_builtInCall2011;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2013;
    static $FOLLOW_BOUND_in_builtInCall2019;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2021;
    static $FOLLOW_variable_in_builtInCall2023;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2025;
    static $FOLLOW_SAMETERM_in_builtInCall2031;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2033;
    static $FOLLOW_expression_in_builtInCall2037;
    static $FOLLOW_COMMA_in_builtInCall2039;
    static $FOLLOW_expression_in_builtInCall2043;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2045;
    static $FOLLOW_ISIRI_in_builtInCall2051;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2053;
    static $FOLLOW_expression_in_builtInCall2057;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2059;
    static $FOLLOW_ISURI_in_builtInCall2065;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2067;
    static $FOLLOW_expression_in_builtInCall2071;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2073;
    static $FOLLOW_ISBLANK_in_builtInCall2079;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2081;
    static $FOLLOW_expression_in_builtInCall2085;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2087;
    static $FOLLOW_ISLITERAL_in_builtInCall2093;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2095;
    static $FOLLOW_expression_in_builtInCall2099;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2101;
    static $FOLLOW_regexExpression_in_builtInCall2107;
    static $FOLLOW_REGEX_in_regexExpression2125;
    static $FOLLOW_OPEN_BRACE_in_regexExpression2130;
    static $FOLLOW_expression_in_regexExpression2134;
    static $FOLLOW_COMMA_in_regexExpression2136;
    static $FOLLOW_expression_in_regexExpression2140;
    static $FOLLOW_COMMA_in_regexExpression2143;
    static $FOLLOW_expression_in_regexExpression2147;
    static $FOLLOW_CLOSE_BRACE_in_regexExpression2151;
    static $FOLLOW_iriRef_in_iriRefOrFunction2169;
    static $FOLLOW_argList_in_iriRefOrFunction2172;
    static $FOLLOW_string_in_rdfLiteral2192;
    static $FOLLOW_LANGTAG_in_rdfLiteral2202;
    static $FOLLOW_REFERENCE_in_rdfLiteral2211;
    static $FOLLOW_iriRef_in_rdfLiteral2213;
    static $FOLLOW_numericLiteralUnsigned_in_numericLiteral2245;
    static $FOLLOW_numericLiteralPositive_in_numericLiteral2255;
    static $FOLLOW_numericLiteralNegative_in_numericLiteral2265;
    static $FOLLOW_INTEGER_in_numericLiteralUnsigned2289;
    static $FOLLOW_DECIMAL_in_numericLiteralUnsigned2297;
    static $FOLLOW_DOUBLE_in_numericLiteralUnsigned2305;
    static $FOLLOW_INTEGER_POSITIVE_in_numericLiteralPositive2325;
    static $FOLLOW_DECIMAL_POSITIVE_in_numericLiteralPositive2333;
    static $FOLLOW_DOUBLE_POSITIVE_in_numericLiteralPositive2341;
    static $FOLLOW_INTEGER_NEGATIVE_in_numericLiteralNegative2361;
    static $FOLLOW_DECIMAL_NEGATIVE_in_numericLiteralNegative2369;
    static $FOLLOW_DOUBLE_NEGATIVE_in_numericLiteralNegative2377;
    static $FOLLOW_set_in_booleanLiteral0;
    static $FOLLOW_set_in_string0;
    static $FOLLOW_IRI_REF_in_iriRef2455;
    static $FOLLOW_prefixedName_in_iriRef2461;
    static $FOLLOW_set_in_prefixedName0;
    static $FOLLOW_BLANK_NODE_LABEL_in_blankNode2505;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2511;
    static $FOLLOW_WS_in_blankNode2514;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2518;

    
    

        public function __construct($input, $state, $gErfurt_Sparql_Parser_Sparql11_Update = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state, $gErfurt_Sparql_Parser_Sparql11_Update);
            $this->gErfurt_Sparql_Parser_Sparql11_Update = $gErfurt_Sparql_Parser_Sparql11_Update;
             
            $this->gParent = $this->gErfurt_Sparql_Parser_Sparql11_Update;
            
            
        }
        

    public function getTokenNames() { return Erfurt_Sparql_Parser_Sparql11_UpdateParser::$tokenNames; }
    public function getGrammarFileName() { return "Sparql10.g"; }



    // $ANTLR start "query10"
    // Sparql10.g:9:1: query10 : prologue ( selectQuery | constructQuery | describeQuery | askQuery ) ; 
    public function query10(){
        try {
            // Sparql10.g:10:3: ( prologue ( selectQuery | constructQuery | describeQuery | askQuery ) ) 
            // Sparql10.g:11:3: prologue ( selectQuery | constructQuery | describeQuery | askQuery ) 
            {
            $this->pushFollow(self::$FOLLOW_prologue_in_query1021);
            $this->prologue();

            $this->state->_fsp--;

            // Sparql10.g:12:3: ( selectQuery | constructQuery | describeQuery | askQuery ) 
            $alt1=4;
            $LA1 = $this->input->LA(1);
            if($this->getToken('SELECT')== $LA1)
                {
                $alt1=1;
                }
            else if($this->getToken('CONSTRUCT')== $LA1)
                {
                $alt1=2;
                }
            else if($this->getToken('DESCRIBE')== $LA1)
                {
                $alt1=3;
                }
            else if($this->getToken('ASK')== $LA1)
                {
                $alt1=4;
                }
            else{
                $nvae =
                    new NoViableAltException("", 1, 0, $this->input);

                throw $nvae;
            }

            switch ($alt1) {
                case 1 :
                    // Sparql10.g:13:5: selectQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_selectQuery_in_query1031);
                    $this->selectQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:14:7: constructQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_constructQuery_in_query1039);
                    $this->constructQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql10.g:15:7: describeQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_describeQuery_in_query1047);
                    $this->describeQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql10.g:16:7: askQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_askQuery_in_query1055);
                    $this->askQuery();

                    $this->state->_fsp--;


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "query10"


    // $ANTLR start "prologue"
    // Sparql10.g:22:1: prologue : ( baseDecl )? ( prefixDecl )* ; 
    public function prologue(){
        try {
            // Sparql10.g:23:3: ( ( baseDecl )? ( prefixDecl )* ) 
            // Sparql10.g:24:3: ( baseDecl )? ( prefixDecl )* 
            {
            // Sparql10.g:24:3: ( baseDecl )? 
            $alt2=2;
            $LA2_0 = $this->input->LA(1);

            if ( ($LA2_0==$this->getToken('BASE')) ) {
                $alt2=1;
            }
            switch ($alt2) {
                case 1 :
                    // Sparql10.g:24:3: baseDecl 
                    {
                    $this->pushFollow(self::$FOLLOW_baseDecl_in_prologue77);
                    $this->baseDecl();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Sparql10.g:24:13: ( prefixDecl )* 
            //loop3:
            do {
                $alt3=2;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('PREFIX')) ) {
                    $alt3=1;
                }


                switch ($alt3) {
            	case 1 :
            	    // Sparql10.g:24:13: prefixDecl 
            	    {
            	    $this->pushFollow(self::$FOLLOW_prefixDecl_in_prologue80);
            	    $this->prefixDecl();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop3;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "prologue"


    // $ANTLR start "baseDecl"
    // Sparql10.g:29:1: baseDecl : BASE iriRef ; 
    public function baseDecl(){
        try {
            // Sparql10.g:30:3: ( BASE iriRef ) 
            // Sparql10.g:31:3: BASE iriRef 
            {
            $this->match($this->input,$this->getToken('BASE'),self::$FOLLOW_BASE_in_baseDecl99); 
            $this->pushFollow(self::$FOLLOW_iriRef_in_baseDecl103);
            $this->iriRef();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "baseDecl"


    // $ANTLR start "prefixDecl"
    // Sparql10.g:37:1: prefixDecl : PREFIX PNAME_NS iriRef ; 
    public function prefixDecl(){
        try {
            // Sparql10.g:38:3: ( PREFIX PNAME_NS iriRef ) 
            // Sparql10.g:39:3: PREFIX PNAME_NS iriRef 
            {
            $this->match($this->input,$this->getToken('PREFIX'),self::$FOLLOW_PREFIX_in_prefixDecl121); 
            $this->match($this->input,$this->getToken('PNAME_NS'),self::$FOLLOW_PNAME_NS_in_prefixDecl126); 
            $this->pushFollow(self::$FOLLOW_iriRef_in_prefixDecl128);
            $this->iriRef();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "prefixDecl"


    // $ANTLR start "selectQuery"
    // Sparql10.g:45:1: selectQuery : SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier ; 
    public function selectQuery(){
        try {
            // Sparql10.g:46:3: ( SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier ) 
            // Sparql10.g:47:3: SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier 
            {
            $this->match($this->input,$this->getToken('SELECT'),self::$FOLLOW_SELECT_in_selectQuery146); 
            // Sparql10.g:48:3: ( DISTINCT | REDUCED )? 
            $alt4=2;
            $LA4_0 = $this->input->LA(1);

            if ( (($LA4_0>=$this->getToken('DISTINCT') && $LA4_0<=$this->getToken('REDUCED'))) ) {
                $alt4=1;
            }
            switch ($alt4) {
                case 1 :
                    // Sparql10.g: 
                    {
                    if ( ($this->input->LA(1)>=$this->getToken('DISTINCT') && $this->input->LA(1)<=$this->getToken('REDUCED')) ) {
                        $this->input->consume();
                        $this->state->errorRecovery=false;
                    }
                    else {
                        $mse = new MismatchedSetException(null,$this->input);
                        throw $mse;
                    }


                    }
                    break;

            }

            // Sparql10.g:52:3: ( ( variable )+ | ASTERISK ) 
            $alt6=2;
            $LA6_0 = $this->input->LA(1);

            if ( (($LA6_0>=$this->getToken('VAR1') && $LA6_0<=$this->getToken('VAR2'))) ) {
                $alt6=1;
            }
            else if ( ($LA6_0==$this->getToken('ASTERISK')) ) {
                $alt6=2;
            }
            else {
                $nvae = new NoViableAltException("", 6, 0, $this->input);

                throw $nvae;
            }
            switch ($alt6) {
                case 1 :
                    // Sparql10.g:53:5: ( variable )+ 
                    {
                    // Sparql10.g:53:5: ( variable )+ 
                    $cnt5=0;
                    //loop5:
                    do {
                        $alt5=2;
                        $LA5_0 = $this->input->LA(1);

                        if ( (($LA5_0>=$this->getToken('VAR1') && $LA5_0<=$this->getToken('VAR2'))) ) {
                            $alt5=1;
                        }


                        switch ($alt5) {
                    	case 1 :
                    	    // Sparql10.g:53:5: variable 
                    	    {
                    	    $this->pushFollow(self::$FOLLOW_variable_in_selectQuery179);
                    	    $this->variable();

                    	    $this->state->_fsp--;


                    	    }
                    	    break;

                    	default :
                    	    if ( $cnt5 >= 1 ) break 2;//loop5;
                                $eee =
                                    new EarlyExitException(5, $this->input);
                                throw $eee;
                        }
                        $cnt5++;
                    } while (true);


                    }
                    break;
                case 2 :
                    // Sparql10.g:54:7: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_selectQuery188); 

                    }
                    break;

            }

            // Sparql10.g:56:3: ( datasetClause )* 
            //loop7:
            do {
                $alt7=2;
                $LA7_0 = $this->input->LA(1);

                if ( ($LA7_0==$this->getToken('FROM')) ) {
                    $alt7=1;
                }


                switch ($alt7) {
            	case 1 :
            	    // Sparql10.g:56:3: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_selectQuery196);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop7;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_selectQuery199);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_selectQuery201);
            $this->solutionModifier();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "selectQuery"


    // $ANTLR start "constructQuery"
    // Sparql10.g:61:1: constructQuery : CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier ; 
    public function constructQuery(){
        try {
            // Sparql10.g:62:3: ( CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier ) 
            // Sparql10.g:63:3: CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier 
            {
            $this->match($this->input,$this->getToken('CONSTRUCT'),self::$FOLLOW_CONSTRUCT_in_constructQuery219); 
            $this->pushFollow(self::$FOLLOW_constructTemplate_in_constructQuery224);
            $this->constructTemplate();

            $this->state->_fsp--;

            // Sparql10.g:64:21: ( datasetClause )* 
            //loop8:
            do {
                $alt8=2;
                $LA8_0 = $this->input->LA(1);

                if ( ($LA8_0==$this->getToken('FROM')) ) {
                    $alt8=1;
                }


                switch ($alt8) {
            	case 1 :
            	    // Sparql10.g:64:21: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_constructQuery226);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop8;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_constructQuery229);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_constructQuery231);
            $this->solutionModifier();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "constructQuery"


    // $ANTLR start "describeQuery"
    // Sparql10.g:69:1: describeQuery : DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier ; 
    public function describeQuery(){
        try {
            // Sparql10.g:70:3: ( DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier ) 
            // Sparql10.g:71:3: DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier 
            {
            $this->match($this->input,$this->getToken('DESCRIBE'),self::$FOLLOW_DESCRIBE_in_describeQuery249); 
            // Sparql10.g:72:3: ( ( varOrIRIref )+ | ASTERISK ) 
            $alt10=2;
            $LA10_0 = $this->input->LA(1);

            if ( ($LA10_0==$this->getToken('IRI_REF')||$LA10_0==$this->getToken('PNAME_NS')||$LA10_0==$this->getToken('PNAME_LN')||($LA10_0>=$this->getToken('VAR1') && $LA10_0<=$this->getToken('VAR2'))) ) {
                $alt10=1;
            }
            else if ( ($LA10_0==$this->getToken('ASTERISK')) ) {
                $alt10=2;
            }
            else {
                $nvae = new NoViableAltException("", 10, 0, $this->input);

                throw $nvae;
            }
            switch ($alt10) {
                case 1 :
                    // Sparql10.g:73:5: ( varOrIRIref )+ 
                    {
                    // Sparql10.g:73:5: ( varOrIRIref )+ 
                    $cnt9=0;
                    //loop9:
                    do {
                        $alt9=2;
                        $LA9_0 = $this->input->LA(1);

                        if ( ($LA9_0==$this->getToken('IRI_REF')||$LA9_0==$this->getToken('PNAME_NS')||$LA9_0==$this->getToken('PNAME_LN')||($LA9_0>=$this->getToken('VAR1') && $LA9_0<=$this->getToken('VAR2'))) ) {
                            $alt9=1;
                        }


                        switch ($alt9) {
                    	case 1 :
                    	    // Sparql10.g:73:5: varOrIRIref 
                    	    {
                    	    $this->pushFollow(self::$FOLLOW_varOrIRIref_in_describeQuery259);
                    	    $this->varOrIRIref();

                    	    $this->state->_fsp--;


                    	    }
                    	    break;

                    	default :
                    	    if ( $cnt9 >= 1 ) break 2;//loop9;
                                $eee =
                                    new EarlyExitException(9, $this->input);
                                throw $eee;
                        }
                        $cnt9++;
                    } while (true);


                    }
                    break;
                case 2 :
                    // Sparql10.g:74:7: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_describeQuery268); 

                    }
                    break;

            }

            // Sparql10.g:76:3: ( datasetClause )* 
            //loop11:
            do {
                $alt11=2;
                $LA11_0 = $this->input->LA(1);

                if ( ($LA11_0==$this->getToken('FROM')) ) {
                    $alt11=1;
                }


                switch ($alt11) {
            	case 1 :
            	    // Sparql10.g:76:3: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_describeQuery276);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop11;
                }
            } while (true);

            // Sparql10.g:76:18: ( whereClause )? 
            $alt12=2;
            $LA12_0 = $this->input->LA(1);

            if ( ($LA12_0==$this->getToken('WHERE')||$LA12_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                $alt12=1;
            }
            switch ($alt12) {
                case 1 :
                    // Sparql10.g:76:18: whereClause 
                    {
                    $this->pushFollow(self::$FOLLOW_whereClause_in_describeQuery279);
                    $this->whereClause();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_describeQuery282);
            $this->solutionModifier();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "describeQuery"


    // $ANTLR start "askQuery"
    // Sparql10.g:81:1: askQuery : ASK ( datasetClause )* whereClause ; 
    public function askQuery(){
        try {
            // Sparql10.g:82:3: ( ASK ( datasetClause )* whereClause ) 
            // Sparql10.g:83:3: ASK ( datasetClause )* whereClause 
            {
            $this->match($this->input,$this->getToken('ASK'),self::$FOLLOW_ASK_in_askQuery300); 
            // Sparql10.g:84:3: ( datasetClause )* 
            //loop13:
            do {
                $alt13=2;
                $LA13_0 = $this->input->LA(1);

                if ( ($LA13_0==$this->getToken('FROM')) ) {
                    $alt13=1;
                }


                switch ($alt13) {
            	case 1 :
            	    // Sparql10.g:84:3: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_askQuery305);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop13;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_askQuery308);
            $this->whereClause();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "askQuery"


    // $ANTLR start "datasetClause"
    // Sparql10.g:89:1: datasetClause : FROM ( defaultGraphClause | namedGraphClause ) ; 
    public function datasetClause(){
        try {
            // Sparql10.g:90:3: ( FROM ( defaultGraphClause | namedGraphClause ) ) 
            // Sparql10.g:91:3: FROM ( defaultGraphClause | namedGraphClause ) 
            {
            $this->match($this->input,$this->getToken('FROM'),self::$FOLLOW_FROM_in_datasetClause326); 
            // Sparql10.g:92:3: ( defaultGraphClause | namedGraphClause ) 
            $alt14=2;
            $LA14_0 = $this->input->LA(1);

            if ( ($LA14_0==$this->getToken('IRI_REF')||$LA14_0==$this->getToken('PNAME_NS')||$LA14_0==$this->getToken('PNAME_LN')) ) {
                $alt14=1;
            }
            else if ( ($LA14_0==$this->getToken('NAMED')) ) {
                $alt14=2;
            }
            else {
                $nvae = new NoViableAltException("", 14, 0, $this->input);

                throw $nvae;
            }
            switch ($alt14) {
                case 1 :
                    // Sparql10.g:93:5: defaultGraphClause 
                    {
                    $this->pushFollow(self::$FOLLOW_defaultGraphClause_in_datasetClause336);
                    $this->defaultGraphClause();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:94:7: namedGraphClause 
                    {
                    $this->pushFollow(self::$FOLLOW_namedGraphClause_in_datasetClause344);
                    $this->namedGraphClause();

                    $this->state->_fsp--;


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "datasetClause"


    // $ANTLR start "defaultGraphClause"
    // Sparql10.g:100:1: defaultGraphClause : sourceSelector ; 
    public function defaultGraphClause(){
        try {
            // Sparql10.g:101:3: ( sourceSelector ) 
            // Sparql10.g:102:3: sourceSelector 
            {
            $this->pushFollow(self::$FOLLOW_sourceSelector_in_defaultGraphClause366);
            $this->sourceSelector();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "defaultGraphClause"


    // $ANTLR start "namedGraphClause"
    // Sparql10.g:107:1: namedGraphClause : NAMED sourceSelector ; 
    public function namedGraphClause(){
        try {
            // Sparql10.g:108:3: ( NAMED sourceSelector ) 
            // Sparql10.g:109:3: NAMED sourceSelector 
            {
            $this->match($this->input,$this->getToken('NAMED'),self::$FOLLOW_NAMED_in_namedGraphClause384); 
            $this->pushFollow(self::$FOLLOW_sourceSelector_in_namedGraphClause389);
            $this->sourceSelector();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "namedGraphClause"


    // $ANTLR start "sourceSelector"
    // Sparql10.g:115:1: sourceSelector : iriRef ; 
    public function sourceSelector(){
        try {
            // Sparql10.g:116:3: ( iriRef ) 
            // Sparql10.g:117:3: iriRef 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_sourceSelector407);
            $this->iriRef();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "sourceSelector"


    // $ANTLR start "whereClause"
    // Sparql10.g:122:1: whereClause : ( WHERE )? groupGraphPattern ; 
    public function whereClause(){
        try {
            // Sparql10.g:123:3: ( ( WHERE )? groupGraphPattern ) 
            // Sparql10.g:124:3: ( WHERE )? groupGraphPattern 
            {
            // Sparql10.g:124:3: ( WHERE )? 
            $alt15=2;
            $LA15_0 = $this->input->LA(1);

            if ( ($LA15_0==$this->getToken('WHERE')) ) {
                $alt15=1;
            }
            switch ($alt15) {
                case 1 :
                    // Sparql10.g:124:3: WHERE 
                    {
                    $this->match($this->input,$this->getToken('WHERE'),self::$FOLLOW_WHERE_in_whereClause425); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_whereClause428);
            $this->groupGraphPattern();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "whereClause"


    // $ANTLR start "solutionModifier"
    // Sparql10.g:129:1: solutionModifier : ( orderClause )? ( limitOffsetClauses )? ; 
    public function solutionModifier(){
        try {
            // Sparql10.g:130:3: ( ( orderClause )? ( limitOffsetClauses )? ) 
            // Sparql10.g:131:3: ( orderClause )? ( limitOffsetClauses )? 
            {
            // Sparql10.g:131:3: ( orderClause )? 
            $alt16=2;
            $LA16_0 = $this->input->LA(1);

            if ( ($LA16_0==$this->getToken('ORDER')) ) {
                $alt16=1;
            }
            switch ($alt16) {
                case 1 :
                    // Sparql10.g:131:3: orderClause 
                    {
                    $this->pushFollow(self::$FOLLOW_orderClause_in_solutionModifier446);
                    $this->orderClause();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Sparql10.g:131:16: ( limitOffsetClauses )? 
            $alt17=2;
            $LA17_0 = $this->input->LA(1);

            if ( (($LA17_0>=$this->getToken('LIMIT') && $LA17_0<=$this->getToken('OFFSET'))) ) {
                $alt17=1;
            }
            switch ($alt17) {
                case 1 :
                    // Sparql10.g:131:16: limitOffsetClauses 
                    {
                    $this->pushFollow(self::$FOLLOW_limitOffsetClauses_in_solutionModifier449);
                    $this->limitOffsetClauses();

                    $this->state->_fsp--;


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "solutionModifier"


    // $ANTLR start "limitOffsetClauses"
    // Sparql10.g:135:1: limitOffsetClauses : ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ); 
    public function limitOffsetClauses(){
        try {
            // Sparql10.g:136:3: ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ) 
            $alt20=2;
            $LA20_0 = $this->input->LA(1);

            if ( ($LA20_0==$this->getToken('LIMIT')) ) {
                $alt20=1;
            }
            else if ( ($LA20_0==$this->getToken('OFFSET')) ) {
                $alt20=2;
            }
            else {
                $nvae = new NoViableAltException("", 20, 0, $this->input);

                throw $nvae;
            }
            switch ($alt20) {
                case 1 :
                    // Sparql10.g:137:3: limitClause ( offsetClause )? 
                    {
                    $this->pushFollow(self::$FOLLOW_limitClause_in_limitOffsetClauses467);
                    $this->limitClause();

                    $this->state->_fsp--;

                    // Sparql10.g:137:15: ( offsetClause )? 
                    $alt18=2;
                    $LA18_0 = $this->input->LA(1);

                    if ( ($LA18_0==$this->getToken('OFFSET')) ) {
                        $alt18=1;
                    }
                    switch ($alt18) {
                        case 1 :
                            // Sparql10.g:137:15: offsetClause 
                            {
                            $this->pushFollow(self::$FOLLOW_offsetClause_in_limitOffsetClauses469);
                            $this->offsetClause();

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // Sparql10.g:138:5: offsetClause ( limitClause )? 
                    {
                    $this->pushFollow(self::$FOLLOW_offsetClause_in_limitOffsetClauses476);
                    $this->offsetClause();

                    $this->state->_fsp--;

                    // Sparql10.g:138:18: ( limitClause )? 
                    $alt19=2;
                    $LA19_0 = $this->input->LA(1);

                    if ( ($LA19_0==$this->getToken('LIMIT')) ) {
                        $alt19=1;
                    }
                    switch ($alt19) {
                        case 1 :
                            // Sparql10.g:138:18: limitClause 
                            {
                            $this->pushFollow(self::$FOLLOW_limitClause_in_limitOffsetClauses478);
                            $this->limitClause();

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "limitOffsetClauses"


    // $ANTLR start "orderClause"
    // Sparql10.g:143:1: orderClause : ORDER BY ( orderCondition )+ ; 
    public function orderClause(){
        try {
            // Sparql10.g:144:3: ( ORDER BY ( orderCondition )+ ) 
            // Sparql10.g:145:3: ORDER BY ( orderCondition )+ 
            {
            $this->match($this->input,$this->getToken('ORDER'),self::$FOLLOW_ORDER_in_orderClause497); 
            $this->match($this->input,$this->getToken('BY'),self::$FOLLOW_BY_in_orderClause499); 
            // Sparql10.g:145:12: ( orderCondition )+ 
            $cnt21=0;
            //loop21:
            do {
                $alt21=2;
                $LA21_0 = $this->input->LA(1);

                if ( (($LA21_0>=$this->getToken('ASC') && $LA21_0<=$this->getToken('DESC'))||($LA21_0>=$this->getToken('STR') && $LA21_0<=$this->getToken('REGEX'))||$LA21_0==$this->getToken('IRI_REF')||$LA21_0==$this->getToken('PNAME_NS')||$LA21_0==$this->getToken('PNAME_LN')||($LA21_0>=$this->getToken('VAR1') && $LA21_0<=$this->getToken('VAR2'))||$LA21_0==$this->getToken('OPEN_BRACE')) ) {
                    $alt21=1;
                }


                switch ($alt21) {
            	case 1 :
            	    // Sparql10.g:145:12: orderCondition 
            	    {
            	    $this->pushFollow(self::$FOLLOW_orderCondition_in_orderClause501);
            	    $this->orderCondition();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt21 >= 1 ) break 2;//loop21;
                        $eee =
                            new EarlyExitException(21, $this->input);
                        throw $eee;
                }
                $cnt21++;
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "orderClause"


    // $ANTLR start "orderCondition"
    // Sparql10.g:150:1: orderCondition : ( ( (o= ASC | o= DESC ) brackettedExpression ) | (v= constraint | v= variable ) ); 
    public function orderCondition(){
        $o=null;

        try {
            // Sparql10.g:151:3: ( ( (o= ASC | o= DESC ) brackettedExpression ) | (v= constraint | v= variable ) ) 
            $alt24=2;
            $LA24_0 = $this->input->LA(1);

            if ( (($LA24_0>=$this->getToken('ASC') && $LA24_0<=$this->getToken('DESC'))) ) {
                $alt24=1;
            }
            else if ( (($LA24_0>=$this->getToken('STR') && $LA24_0<=$this->getToken('REGEX'))||$LA24_0==$this->getToken('IRI_REF')||$LA24_0==$this->getToken('PNAME_NS')||$LA24_0==$this->getToken('PNAME_LN')||($LA24_0>=$this->getToken('VAR1') && $LA24_0<=$this->getToken('VAR2'))||$LA24_0==$this->getToken('OPEN_BRACE')) ) {
                $alt24=2;
            }
            else {
                $nvae = new NoViableAltException("", 24, 0, $this->input);

                throw $nvae;
            }
            switch ($alt24) {
                case 1 :
                    // Sparql10.g:152:3: ( (o= ASC | o= DESC ) brackettedExpression ) 
                    {
                    // Sparql10.g:152:3: ( (o= ASC | o= DESC ) brackettedExpression ) 
                    // Sparql10.g:153:5: (o= ASC | o= DESC ) brackettedExpression 
                    {
                    // Sparql10.g:153:5: (o= ASC | o= DESC ) 
                    $alt22=2;
                    $LA22_0 = $this->input->LA(1);

                    if ( ($LA22_0==$this->getToken('ASC')) ) {
                        $alt22=1;
                    }
                    else if ( ($LA22_0==$this->getToken('DESC')) ) {
                        $alt22=2;
                    }
                    else {
                        $nvae = new NoViableAltException("", 22, 0, $this->input);

                        throw $nvae;
                    }
                    switch ($alt22) {
                        case 1 :
                            // Sparql10.g:154:7: o= ASC 
                            {
                            $o=$this->match($this->input,$this->getToken('ASC'),self::$FOLLOW_ASC_in_orderCondition536); 

                            }
                            break;
                        case 2 :
                            // Sparql10.g:155:9: o= DESC 
                            {
                            $o=$this->match($this->input,$this->getToken('DESC'),self::$FOLLOW_DESC_in_orderCondition548); 

                            }
                            break;

                    }

                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_orderCondition560);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }


                    }
                    break;
                case 2 :
                    // Sparql10.g:160:3: (v= constraint | v= variable ) 
                    {
                    // Sparql10.g:160:3: (v= constraint | v= variable ) 
                    $alt23=2;
                    $LA23_0 = $this->input->LA(1);

                    if ( (($LA23_0>=$this->getToken('STR') && $LA23_0<=$this->getToken('REGEX'))||$LA23_0==$this->getToken('IRI_REF')||$LA23_0==$this->getToken('PNAME_NS')||$LA23_0==$this->getToken('PNAME_LN')||$LA23_0==$this->getToken('OPEN_BRACE')) ) {
                        $alt23=1;
                    }
                    else if ( (($LA23_0>=$this->getToken('VAR1') && $LA23_0<=$this->getToken('VAR2'))) ) {
                        $alt23=2;
                    }
                    else {
                        $nvae = new NoViableAltException("", 23, 0, $this->input);

                        throw $nvae;
                    }
                    switch ($alt23) {
                        case 1 :
                            // Sparql10.g:161:5: v= constraint 
                            {
                            $this->pushFollow(self::$FOLLOW_constraint_in_orderCondition580);
                            $this->constraint();

                            $this->state->_fsp--;


                            }
                            break;
                        case 2 :
                            // Sparql10.g:162:7: v= variable 
                            {
                            $this->pushFollow(self::$FOLLOW_variable_in_orderCondition590);
                            $this->variable();

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "orderCondition"


    // $ANTLR start "limitClause"
    // Sparql10.g:168:1: limitClause : LIMIT INTEGER ; 
    public function limitClause(){
        try {
            // Sparql10.g:169:3: ( LIMIT INTEGER ) 
            // Sparql10.g:170:3: LIMIT INTEGER 
            {
            $this->match($this->input,$this->getToken('LIMIT'),self::$FOLLOW_LIMIT_in_limitClause612); 
            $this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_limitClause614); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "limitClause"


    // $ANTLR start "offsetClause"
    // Sparql10.g:175:1: offsetClause : OFFSET INTEGER ; 
    public function offsetClause(){
        try {
            // Sparql10.g:176:3: ( OFFSET INTEGER ) 
            // Sparql10.g:177:3: OFFSET INTEGER 
            {
            $this->match($this->input,$this->getToken('OFFSET'),self::$FOLLOW_OFFSET_in_offsetClause632); 
            $this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_offsetClause634); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "offsetClause"


    // $ANTLR start "groupGraphPattern"
    // Sparql10.g:182:1: groupGraphPattern : OPEN_CURLY_BRACE (t1= triplesBlock )? ( (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? )* CLOSE_CURLY_BRACE ; 
    public function groupGraphPattern(){
        try {
            // Sparql10.g:183:3: ( OPEN_CURLY_BRACE (t1= triplesBlock )? ( (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? )* CLOSE_CURLY_BRACE ) 
            // Sparql10.g:184:3: OPEN_CURLY_BRACE (t1= triplesBlock )? ( (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? )* CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern652); 
            // Sparql10.g:184:20: (t1= triplesBlock )? 
            $alt25=2;
            $LA25_0 = $this->input->LA(1);

            if ( (($LA25_0>=$this->getToken('TRUE') && $LA25_0<=$this->getToken('FALSE'))||$LA25_0==$this->getToken('IRI_REF')||$LA25_0==$this->getToken('PNAME_NS')||$LA25_0==$this->getToken('PNAME_LN')||($LA25_0>=$this->getToken('VAR1') && $LA25_0<=$this->getToken('VAR2'))||$LA25_0==$this->getToken('INTEGER')||$LA25_0==$this->getToken('DECIMAL')||$LA25_0==$this->getToken('DOUBLE')||($LA25_0>=$this->getToken('INTEGER_POSITIVE') && $LA25_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA25_0>=$this->getToken('STRING_LITERAL1') && $LA25_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA25_0==$this->getToken('BLANK_NODE_LABEL')||$LA25_0==$this->getToken('OPEN_BRACE')||$LA25_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt25=1;
            }
            switch ($alt25) {
                case 1 :
                    // Sparql10.g:184:21: t1= triplesBlock 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPattern657);
                    $this->triplesBlock();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Sparql10.g:185:3: ( (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? )* 
            //loop29:
            do {
                $alt29=2;
                $LA29_0 = $this->input->LA(1);

                if ( (($LA29_0>=$this->getToken('OPTIONAL') && $LA29_0<=$this->getToken('GRAPH'))||$LA29_0==$this->getToken('FILTER')||$LA29_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                    $alt29=1;
                }


                switch ($alt29) {
            	case 1 :
            	    // Sparql10.g:186:5: (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? 
            	    {
            	    // Sparql10.g:186:5: (v= graphPatternNotTriples | v= filter ) 
            	    $alt26=2;
            	    $LA26_0 = $this->input->LA(1);

            	    if ( (($LA26_0>=$this->getToken('OPTIONAL') && $LA26_0<=$this->getToken('GRAPH'))||$LA26_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
            	        $alt26=1;
            	    }
            	    else if ( ($LA26_0==$this->getToken('FILTER')) ) {
            	        $alt26=2;
            	    }
            	    else {
            	        $nvae = new NoViableAltException("", 26, 0, $this->input);

            	        throw $nvae;
            	    }
            	    switch ($alt26) {
            	        case 1 :
            	            // Sparql10.g:187:7: v= graphPatternNotTriples 
            	            {
            	            $this->pushFollow(self::$FOLLOW_graphPatternNotTriples_in_groupGraphPattern679);
            	            $this->graphPatternNotTriples();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 2 :
            	            // Sparql10.g:188:9: v= filter 
            	            {
            	            $this->pushFollow(self::$FOLLOW_filter_in_groupGraphPattern691);
            	            $this->filter();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }

            	    // Sparql10.g:190:5: ( DOT )? 
            	    $alt27=2;
            	    $LA27_0 = $this->input->LA(1);

            	    if ( ($LA27_0==$this->getToken('DOT')) ) {
            	        $alt27=1;
            	    }
            	    switch ($alt27) {
            	        case 1 :
            	            // Sparql10.g:190:5: DOT 
            	            {
            	            $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_groupGraphPattern703); 

            	            }
            	            break;

            	    }

            	    // Sparql10.g:190:10: (t2= triplesBlock )? 
            	    $alt28=2;
            	    $LA28_0 = $this->input->LA(1);

            	    if ( (($LA28_0>=$this->getToken('TRUE') && $LA28_0<=$this->getToken('FALSE'))||$LA28_0==$this->getToken('IRI_REF')||$LA28_0==$this->getToken('PNAME_NS')||$LA28_0==$this->getToken('PNAME_LN')||($LA28_0>=$this->getToken('VAR1') && $LA28_0<=$this->getToken('VAR2'))||$LA28_0==$this->getToken('INTEGER')||$LA28_0==$this->getToken('DECIMAL')||$LA28_0==$this->getToken('DOUBLE')||($LA28_0>=$this->getToken('INTEGER_POSITIVE') && $LA28_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA28_0>=$this->getToken('STRING_LITERAL1') && $LA28_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA28_0==$this->getToken('BLANK_NODE_LABEL')||$LA28_0==$this->getToken('OPEN_BRACE')||$LA28_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
            	        $alt28=1;
            	    }
            	    switch ($alt28) {
            	        case 1 :
            	            // Sparql10.g:190:11: t2= triplesBlock 
            	            {
            	            $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPattern709);
            	            $this->triplesBlock();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop29;
                }
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern720); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "groupGraphPattern"


    // $ANTLR start "triplesBlock"
    // Sparql10.g:197:1: triplesBlock : triplesSameSubject ( DOT (t= triplesBlock )? )? ; 
    public function triplesBlock(){
        try {
            // Sparql10.g:198:3: ( triplesSameSubject ( DOT (t= triplesBlock )? )? ) 
            // Sparql10.g:199:3: triplesSameSubject ( DOT (t= triplesBlock )? )? 
            {
            $this->pushFollow(self::$FOLLOW_triplesSameSubject_in_triplesBlock738);
            $this->triplesSameSubject();

            $this->state->_fsp--;

            // Sparql10.g:199:22: ( DOT (t= triplesBlock )? )? 
            $alt31=2;
            $LA31_0 = $this->input->LA(1);

            if ( ($LA31_0==$this->getToken('DOT')) ) {
                $alt31=1;
            }
            switch ($alt31) {
                case 1 :
                    // Sparql10.g:199:23: DOT (t= triplesBlock )? 
                    {
                    $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_triplesBlock741); 
                    // Sparql10.g:199:27: (t= triplesBlock )? 
                    $alt30=2;
                    $LA30_0 = $this->input->LA(1);

                    if ( (($LA30_0>=$this->getToken('TRUE') && $LA30_0<=$this->getToken('FALSE'))||$LA30_0==$this->getToken('IRI_REF')||$LA30_0==$this->getToken('PNAME_NS')||$LA30_0==$this->getToken('PNAME_LN')||($LA30_0>=$this->getToken('VAR1') && $LA30_0<=$this->getToken('VAR2'))||$LA30_0==$this->getToken('INTEGER')||$LA30_0==$this->getToken('DECIMAL')||$LA30_0==$this->getToken('DOUBLE')||($LA30_0>=$this->getToken('INTEGER_POSITIVE') && $LA30_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA30_0>=$this->getToken('STRING_LITERAL1') && $LA30_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA30_0==$this->getToken('BLANK_NODE_LABEL')||$LA30_0==$this->getToken('OPEN_BRACE')||$LA30_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                        $alt30=1;
                    }
                    switch ($alt30) {
                        case 1 :
                            // Sparql10.g:199:28: t= triplesBlock 
                            {
                            $this->pushFollow(self::$FOLLOW_triplesBlock_in_triplesBlock746);
                            $this->triplesBlock();

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "triplesBlock"


    // $ANTLR start "graphPatternNotTriples"
    // Sparql10.g:204:1: graphPatternNotTriples : (v= optionalGraphPattern | v= groupOrUnionGraphPattern | v= graphGraphPattern ); 
    public function graphPatternNotTriples(){
        try {
            // Sparql10.g:205:3: (v= optionalGraphPattern | v= groupOrUnionGraphPattern | v= graphGraphPattern ) 
            $alt32=3;
            $LA32 = $this->input->LA(1);
            if($this->getToken('OPTIONAL')== $LA32)
                {
                $alt32=1;
                }
            else if($this->getToken('OPEN_CURLY_BRACE')== $LA32)
                {
                $alt32=2;
                }
            else if($this->getToken('GRAPH')== $LA32)
                {
                $alt32=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 32, 0, $this->input);

                throw $nvae;
            }

            switch ($alt32) {
                case 1 :
                    // Sparql10.g:206:3: v= optionalGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_optionalGraphPattern_in_graphPatternNotTriples770);
                    $this->optionalGraphPattern();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:207:5: v= groupOrUnionGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples778);
                    $this->groupOrUnionGraphPattern();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql10.g:208:5: v= graphGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_graphGraphPattern_in_graphPatternNotTriples786);
                    $this->graphGraphPattern();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "graphPatternNotTriples"


    // $ANTLR start "optionalGraphPattern"
    // Sparql10.g:213:1: optionalGraphPattern : OPTIONAL groupGraphPattern ; 
    public function optionalGraphPattern(){
        try {
            // Sparql10.g:214:3: ( OPTIONAL groupGraphPattern ) 
            // Sparql10.g:215:3: OPTIONAL groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('OPTIONAL'),self::$FOLLOW_OPTIONAL_in_optionalGraphPattern804); 
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_optionalGraphPattern806);
            $this->groupGraphPattern();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "optionalGraphPattern"


    // $ANTLR start "graphGraphPattern"
    // Sparql10.g:220:1: graphGraphPattern : GRAPH varOrIRIref groupGraphPattern ; 
    public function graphGraphPattern(){
        try {
            // Sparql10.g:221:3: ( GRAPH varOrIRIref groupGraphPattern ) 
            // Sparql10.g:222:3: GRAPH varOrIRIref groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('GRAPH'),self::$FOLLOW_GRAPH_in_graphGraphPattern824); 
            $this->pushFollow(self::$FOLLOW_varOrIRIref_in_graphGraphPattern826);
            $this->varOrIRIref();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_graphGraphPattern828);
            $this->groupGraphPattern();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "graphGraphPattern"


    // $ANTLR start "groupOrUnionGraphPattern"
    // Sparql10.g:227:1: groupOrUnionGraphPattern : v1= groupGraphPattern ( UNION v2= groupGraphPattern )* ; 
    public function groupOrUnionGraphPattern(){
        try {
            // Sparql10.g:228:3: (v1= groupGraphPattern ( UNION v2= groupGraphPattern )* ) 
            // Sparql10.g:229:3: v1= groupGraphPattern ( UNION v2= groupGraphPattern )* 
            {
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern848);
            $this->groupGraphPattern();

            $this->state->_fsp--;

            // Sparql10.g:229:24: ( UNION v2= groupGraphPattern )* 
            //loop33:
            do {
                $alt33=2;
                $LA33_0 = $this->input->LA(1);

                if ( ($LA33_0==$this->getToken('UNION')) ) {
                    $alt33=1;
                }


                switch ($alt33) {
            	case 1 :
            	    // Sparql10.g:229:25: UNION v2= groupGraphPattern 
            	    {
            	    $this->match($this->input,$this->getToken('UNION'),self::$FOLLOW_UNION_in_groupOrUnionGraphPattern851); 
            	    $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern855);
            	    $this->groupGraphPattern();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop33;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "groupOrUnionGraphPattern"


    // $ANTLR start "filter"
    // Sparql10.g:234:1: filter : FILTER constraint ; 
    public function filter(){
        try {
            // Sparql10.g:235:3: ( FILTER constraint ) 
            // Sparql10.g:236:3: FILTER constraint 
            {
            $this->match($this->input,$this->getToken('FILTER'),self::$FOLLOW_FILTER_in_filter875); 
            $this->pushFollow(self::$FOLLOW_constraint_in_filter877);
            $this->constraint();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "filter"


    // $ANTLR start "constraint"
    // Sparql10.g:241:1: constraint : (v= brackettedExpression | v= builtInCall | v= functionCall ); 
    public function constraint(){
        try {
            // Sparql10.g:242:3: (v= brackettedExpression | v= builtInCall | v= functionCall ) 
            $alt34=3;
            $LA34 = $this->input->LA(1);
            if($this->getToken('OPEN_BRACE')== $LA34)
                {
                $alt34=1;
                }
            else if($this->getToken('STR')== $LA34||$this->getToken('LANG')== $LA34||$this->getToken('LANGMATCHES')== $LA34||$this->getToken('DATATYPE')== $LA34||$this->getToken('BOUND')== $LA34||$this->getToken('SAMETERM')== $LA34||$this->getToken('ISIRI')== $LA34||$this->getToken('ISURI')== $LA34||$this->getToken('ISBLANK')== $LA34||$this->getToken('ISLITERAL')== $LA34||$this->getToken('REGEX')== $LA34)
                {
                $alt34=2;
                }
            else if($this->getToken('IRI_REF')== $LA34||$this->getToken('PNAME_NS')== $LA34||$this->getToken('PNAME_LN')== $LA34)
                {
                $alt34=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 34, 0, $this->input);

                throw $nvae;
            }

            switch ($alt34) {
                case 1 :
                    // Sparql10.g:243:3: v= brackettedExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_constraint897);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:244:5: v= builtInCall 
                    {
                    $this->pushFollow(self::$FOLLOW_builtInCall_in_constraint905);
                    $this->builtInCall();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql10.g:245:5: v= functionCall 
                    {
                    $this->pushFollow(self::$FOLLOW_functionCall_in_constraint913);
                    $this->functionCall();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "constraint"


    // $ANTLR start "functionCall"
    // Sparql10.g:249:1: functionCall : iriRef argList ; 
    public function functionCall(){
        try {
            // Sparql10.g:250:3: ( iriRef argList ) 
            // Sparql10.g:251:3: iriRef argList 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_functionCall930);
            $this->iriRef();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_argList_in_functionCall932);
            $this->argList();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "functionCall"


    // $ANTLR start "argList"
    // Sparql10.g:256:1: argList : ( OPEN_BRACE ( WS )* CLOSE_BRACE | OPEN_BRACE e1= expression ( COMMA e2= expression )* CLOSE_BRACE ); 
    public function argList(){
        try {
            // Sparql10.g:257:3: ( OPEN_BRACE ( WS )* CLOSE_BRACE | OPEN_BRACE e1= expression ( COMMA e2= expression )* CLOSE_BRACE ) 
            $alt37=2;
            $LA37_0 = $this->input->LA(1);

            if ( ($LA37_0==$this->getToken('OPEN_BRACE')) ) {
                $LA37_1 = $this->input->LA(2);

                if ( ($LA37_1==$this->getToken('WS')||$LA37_1==$this->getToken('CLOSE_BRACE')) ) {
                    $alt37=1;
                }
                else if ( (($LA37_1>=$this->getToken('STR') && $LA37_1<=$this->getToken('FALSE'))||$LA37_1==$this->getToken('IRI_REF')||$LA37_1==$this->getToken('PNAME_NS')||$LA37_1==$this->getToken('PNAME_LN')||($LA37_1>=$this->getToken('VAR1') && $LA37_1<=$this->getToken('MINUS'))||$LA37_1==$this->getToken('INTEGER')||$LA37_1==$this->getToken('DECIMAL')||($LA37_1>=$this->getToken('DOUBLE') && $LA37_1<=$this->getToken('DOUBLE_NEGATIVE'))||($LA37_1>=$this->getToken('STRING_LITERAL1') && $LA37_1<=$this->getToken('STRING_LITERAL_LONG2'))||$LA37_1==$this->getToken('NOT_SIGN')||$LA37_1==$this->getToken('OPEN_BRACE')) ) {
                    $alt37=2;
                }
                else {
                    $nvae = new NoViableAltException("", 37, 1, $this->input);

                    throw $nvae;
                }
            }
            else {
                $nvae = new NoViableAltException("", 37, 0, $this->input);

                throw $nvae;
            }
            switch ($alt37) {
                case 1 :
                    // Sparql10.g:258:3: OPEN_BRACE ( WS )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_argList950); 
                    // Sparql10.g:258:14: ( WS )* 
                    //loop35:
                    do {
                        $alt35=2;
                        $LA35_0 = $this->input->LA(1);

                        if ( ($LA35_0==$this->getToken('WS')) ) {
                            $alt35=1;
                        }


                        switch ($alt35) {
                    	case 1 :
                    	    // Sparql10.g:258:14: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_argList952); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop35;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_argList955); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:259:5: OPEN_BRACE e1= expression ( COMMA e2= expression )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_argList961); 
                    $this->pushFollow(self::$FOLLOW_expression_in_argList965);
                    $this->expression();

                    $this->state->_fsp--;

                    // Sparql10.g:259:30: ( COMMA e2= expression )* 
                    //loop36:
                    do {
                        $alt36=2;
                        $LA36_0 = $this->input->LA(1);

                        if ( ($LA36_0==$this->getToken('COMMA')) ) {
                            $alt36=1;
                        }


                        switch ($alt36) {
                    	case 1 :
                    	    // Sparql10.g:259:31: COMMA e2= expression 
                    	    {
                    	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_argList968); 
                    	    $this->pushFollow(self::$FOLLOW_expression_in_argList972);
                    	    $this->expression();

                    	    $this->state->_fsp--;


                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop36;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_argList976); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "argList"


    // $ANTLR start "constructTemplate"
    // Sparql10.g:264:1: constructTemplate : OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ; 
    public function constructTemplate(){
        try {
            // Sparql10.g:265:3: ( OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ) 
            // Sparql10.g:266:3: OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate994); 
            // Sparql10.g:266:20: ( constructTriples )? 
            $alt38=2;
            $LA38_0 = $this->input->LA(1);

            if ( ($LA38_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                $alt38=1;
            }
            switch ($alt38) {
                case 1 :
                    // Sparql10.g:266:21: constructTriples 
                    {
                    $this->pushFollow(self::$FOLLOW_constructTriples_in_constructTemplate997);
                    $this->constructTriples();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate1001); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "constructTemplate"


    // $ANTLR start "constructTriples"
    // Sparql10.g:271:1: constructTriples : OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ; 
    public function constructTriples(){
        try {
            // Sparql10.g:272:3: ( OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ) 
            // Sparql10.g:273:3: OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_constructTriples1019); 
            // Sparql10.g:273:20: ( constructTriples )? 
            $alt39=2;
            $LA39_0 = $this->input->LA(1);

            if ( ($LA39_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                $alt39=1;
            }
            switch ($alt39) {
                case 1 :
                    // Sparql10.g:273:21: constructTriples 
                    {
                    $this->pushFollow(self::$FOLLOW_constructTriples_in_constructTriples1022);
                    $this->constructTriples();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTriples1026); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "constructTriples"


    // $ANTLR start "triplesSameSubject"
    // Sparql10.g:278:1: triplesSameSubject : ( varOrTerm propertyListNotEmpty | triplesNode propertyList ); 
    public function triplesSameSubject(){
        try {
            // Sparql10.g:279:3: ( varOrTerm propertyListNotEmpty | triplesNode propertyList ) 
            $alt40=2;
            $LA40 = $this->input->LA(1);
            if($this->getToken('TRUE')== $LA40||$this->getToken('FALSE')== $LA40||$this->getToken('IRI_REF')== $LA40||$this->getToken('PNAME_NS')== $LA40||$this->getToken('PNAME_LN')== $LA40||$this->getToken('VAR1')== $LA40||$this->getToken('VAR2')== $LA40||$this->getToken('INTEGER')== $LA40||$this->getToken('DECIMAL')== $LA40||$this->getToken('DOUBLE')== $LA40||$this->getToken('INTEGER_POSITIVE')== $LA40||$this->getToken('DECIMAL_POSITIVE')== $LA40||$this->getToken('DOUBLE_POSITIVE')== $LA40||$this->getToken('INTEGER_NEGATIVE')== $LA40||$this->getToken('DECIMAL_NEGATIVE')== $LA40||$this->getToken('DOUBLE_NEGATIVE')== $LA40||$this->getToken('STRING_LITERAL1')== $LA40||$this->getToken('STRING_LITERAL2')== $LA40||$this->getToken('STRING_LITERAL_LONG1')== $LA40||$this->getToken('STRING_LITERAL_LONG2')== $LA40||$this->getToken('BLANK_NODE_LABEL')== $LA40)
                {
                $alt40=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA40)
                {
                $LA40_2 = $this->input->LA(2);

                if ( ($LA40_2==$this->getToken('A')||$LA40_2==$this->getToken('IRI_REF')||$LA40_2==$this->getToken('PNAME_NS')||$LA40_2==$this->getToken('PNAME_LN')||($LA40_2>=$this->getToken('VAR1') && $LA40_2<=$this->getToken('VAR2'))) ) {
                    $alt40=2;
                }
                else if ( ($LA40_2==$this->getToken('WS')||$LA40_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt40=1;
                }
                else {
                    $nvae = new NoViableAltException("", 40, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA40)
                {
                $LA40_3 = $this->input->LA(2);

                if ( ($LA40_3==$this->getToken('WS')||$LA40_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt40=1;
                }
                else if ( (($LA40_3>=$this->getToken('TRUE') && $LA40_3<=$this->getToken('FALSE'))||$LA40_3==$this->getToken('IRI_REF')||$LA40_3==$this->getToken('PNAME_NS')||$LA40_3==$this->getToken('PNAME_LN')||($LA40_3>=$this->getToken('VAR1') && $LA40_3<=$this->getToken('VAR2'))||$LA40_3==$this->getToken('INTEGER')||$LA40_3==$this->getToken('DECIMAL')||$LA40_3==$this->getToken('DOUBLE')||($LA40_3>=$this->getToken('INTEGER_POSITIVE') && $LA40_3<=$this->getToken('DOUBLE_NEGATIVE'))||($LA40_3>=$this->getToken('STRING_LITERAL1') && $LA40_3<=$this->getToken('STRING_LITERAL_LONG2'))||$LA40_3==$this->getToken('BLANK_NODE_LABEL')||$LA40_3==$this->getToken('OPEN_BRACE')||$LA40_3==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt40=2;
                }
                else {
                    $nvae = new NoViableAltException("", 40, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 40, 0, $this->input);

                throw $nvae;
            }

            switch ($alt40) {
                case 1 :
                    // Sparql10.g:280:3: varOrTerm propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_triplesSameSubject1044);
                    $this->varOrTerm();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_triplesSameSubject1046);
                    $this->propertyListNotEmpty();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:281:5: triplesNode propertyList 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_triplesSameSubject1052);
                    $this->triplesNode();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyList_in_triplesSameSubject1054);
                    $this->propertyList();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "triplesSameSubject"


    // $ANTLR start "propertyListNotEmpty"
    // Sparql10.g:286:1: propertyListNotEmpty : v1= verb ol1= objectList ( SEMICOLON (v2= verb ol2= objectList )? )* ; 
    public function propertyListNotEmpty(){
        try {
            // Sparql10.g:287:3: (v1= verb ol1= objectList ( SEMICOLON (v2= verb ol2= objectList )? )* ) 
            // Sparql10.g:288:3: v1= verb ol1= objectList ( SEMICOLON (v2= verb ol2= objectList )? )* 
            {
            $this->pushFollow(self::$FOLLOW_verb_in_propertyListNotEmpty1074);
            $this->verb();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmpty1078);
            $this->objectList();

            $this->state->_fsp--;

            // Sparql10.g:288:26: ( SEMICOLON (v2= verb ol2= objectList )? )* 
            //loop42:
            do {
                $alt42=2;
                $LA42_0 = $this->input->LA(1);

                if ( ($LA42_0==$this->getToken('SEMICOLON')) ) {
                    $alt42=1;
                }


                switch ($alt42) {
            	case 1 :
            	    // Sparql10.g:288:27: SEMICOLON (v2= verb ol2= objectList )? 
            	    {
            	    $this->match($this->input,$this->getToken('SEMICOLON'),self::$FOLLOW_SEMICOLON_in_propertyListNotEmpty1081); 
            	    // Sparql10.g:288:37: (v2= verb ol2= objectList )? 
            	    $alt41=2;
            	    $LA41_0 = $this->input->LA(1);

            	    if ( ($LA41_0==$this->getToken('A')||$LA41_0==$this->getToken('IRI_REF')||$LA41_0==$this->getToken('PNAME_NS')||$LA41_0==$this->getToken('PNAME_LN')||($LA41_0>=$this->getToken('VAR1') && $LA41_0<=$this->getToken('VAR2'))) ) {
            	        $alt41=1;
            	    }
            	    switch ($alt41) {
            	        case 1 :
            	            // Sparql10.g:288:38: v2= verb ol2= objectList 
            	            {
            	            $this->pushFollow(self::$FOLLOW_verb_in_propertyListNotEmpty1086);
            	            $this->verb();

            	            $this->state->_fsp--;

            	            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmpty1090);
            	            $this->objectList();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop42;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "propertyListNotEmpty"


    // $ANTLR start "propertyList"
    // Sparql10.g:293:1: propertyList : ( propertyListNotEmpty )? ; 
    public function propertyList(){
        try {
            // Sparql10.g:294:3: ( ( propertyListNotEmpty )? ) 
            // Sparql10.g:295:3: ( propertyListNotEmpty )? 
            {
            // Sparql10.g:295:3: ( propertyListNotEmpty )? 
            $alt43=2;
            $LA43_0 = $this->input->LA(1);

            if ( ($LA43_0==$this->getToken('A')||$LA43_0==$this->getToken('IRI_REF')||$LA43_0==$this->getToken('PNAME_NS')||$LA43_0==$this->getToken('PNAME_LN')||($LA43_0>=$this->getToken('VAR1') && $LA43_0<=$this->getToken('VAR2'))) ) {
                $alt43=1;
            }
            switch ($alt43) {
                case 1 :
                    // Sparql10.g:295:4: propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_propertyList1113);
                    $this->propertyListNotEmpty();

                    $this->state->_fsp--;


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "propertyList"


    // $ANTLR start "objectList"
    // Sparql10.g:300:1: objectList : o1= object ( COMMA o2= object )* ; 
    public function objectList(){
        try {
            // Sparql10.g:301:3: (o1= object ( COMMA o2= object )* ) 
            // Sparql10.g:302:3: o1= object ( COMMA o2= object )* 
            {
            $this->pushFollow(self::$FOLLOW_object_in_objectList1135);
            $this->object();

            $this->state->_fsp--;

            // Sparql10.g:302:13: ( COMMA o2= object )* 
            //loop44:
            do {
                $alt44=2;
                $LA44_0 = $this->input->LA(1);

                if ( ($LA44_0==$this->getToken('COMMA')) ) {
                    $alt44=1;
                }


                switch ($alt44) {
            	case 1 :
            	    // Sparql10.g:302:14: COMMA o2= object 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectList1138); 
            	    $this->pushFollow(self::$FOLLOW_object_in_objectList1142);
            	    $this->object();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop44;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "objectList"


    // $ANTLR start "object"
    // Sparql10.g:307:1: object : graphNode ; 
    public function object(){
        try {
            // Sparql10.g:308:3: ( graphNode ) 
            // Sparql10.g:309:3: graphNode 
            {
            $this->pushFollow(self::$FOLLOW_graphNode_in_object1162);
            $this->graphNode();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "object"


    // $ANTLR start "verb"
    // Sparql10.g:314:1: verb : ( varOrIRIref | A ); 
    public function verb(){
        try {
            // Sparql10.g:315:3: ( varOrIRIref | A ) 
            $alt45=2;
            $LA45_0 = $this->input->LA(1);

            if ( ($LA45_0==$this->getToken('IRI_REF')||$LA45_0==$this->getToken('PNAME_NS')||$LA45_0==$this->getToken('PNAME_LN')||($LA45_0>=$this->getToken('VAR1') && $LA45_0<=$this->getToken('VAR2'))) ) {
                $alt45=1;
            }
            else if ( ($LA45_0==$this->getToken('A')) ) {
                $alt45=2;
            }
            else {
                $nvae = new NoViableAltException("", 45, 0, $this->input);

                throw $nvae;
            }
            switch ($alt45) {
                case 1 :
                    // Sparql10.g:316:3: varOrIRIref 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrIRIref_in_verb1180);
                    $this->varOrIRIref();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:317:5: A 
                    {
                    $this->match($this->input,$this->getToken('A'),self::$FOLLOW_A_in_verb1186); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "verb"


    // $ANTLR start "triplesNode"
    // Sparql10.g:322:1: triplesNode : ( collection | blankNodePropertyList ); 
    public function triplesNode(){
        try {
            // Sparql10.g:323:3: ( collection | blankNodePropertyList ) 
            $alt46=2;
            $LA46_0 = $this->input->LA(1);

            if ( ($LA46_0==$this->getToken('OPEN_BRACE')) ) {
                $alt46=1;
            }
            else if ( ($LA46_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt46=2;
            }
            else {
                $nvae = new NoViableAltException("", 46, 0, $this->input);

                throw $nvae;
            }
            switch ($alt46) {
                case 1 :
                    // Sparql10.g:324:3: collection 
                    {
                    $this->pushFollow(self::$FOLLOW_collection_in_triplesNode1204);
                    $this->collection();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:325:5: blankNodePropertyList 
                    {
                    $this->pushFollow(self::$FOLLOW_blankNodePropertyList_in_triplesNode1210);
                    $this->blankNodePropertyList();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "triplesNode"


    // $ANTLR start "blankNodePropertyList"
    // Sparql10.g:330:1: blankNodePropertyList : OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE ; 
    public function blankNodePropertyList(){
        try {
            // Sparql10.g:331:3: ( OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE ) 
            // Sparql10.g:332:3: OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1228); 
            $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1230);
            $this->propertyListNotEmpty();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1232); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "blankNodePropertyList"


    // $ANTLR start "collection"
    // Sparql10.g:337:1: collection : OPEN_BRACE ( graphNode )+ CLOSE_BRACE ; 
    public function collection(){
        try {
            // Sparql10.g:338:3: ( OPEN_BRACE ( graphNode )+ CLOSE_BRACE ) 
            // Sparql10.g:339:3: OPEN_BRACE ( graphNode )+ CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_collection1250); 
            // Sparql10.g:339:14: ( graphNode )+ 
            $cnt47=0;
            //loop47:
            do {
                $alt47=2;
                $LA47_0 = $this->input->LA(1);

                if ( (($LA47_0>=$this->getToken('TRUE') && $LA47_0<=$this->getToken('FALSE'))||$LA47_0==$this->getToken('IRI_REF')||$LA47_0==$this->getToken('PNAME_NS')||$LA47_0==$this->getToken('PNAME_LN')||($LA47_0>=$this->getToken('VAR1') && $LA47_0<=$this->getToken('VAR2'))||$LA47_0==$this->getToken('INTEGER')||$LA47_0==$this->getToken('DECIMAL')||$LA47_0==$this->getToken('DOUBLE')||($LA47_0>=$this->getToken('INTEGER_POSITIVE') && $LA47_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA47_0>=$this->getToken('STRING_LITERAL1') && $LA47_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA47_0==$this->getToken('BLANK_NODE_LABEL')||$LA47_0==$this->getToken('OPEN_BRACE')||$LA47_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt47=1;
                }


                switch ($alt47) {
            	case 1 :
            	    // Sparql10.g:339:15: graphNode 
            	    {
            	    $this->pushFollow(self::$FOLLOW_graphNode_in_collection1253);
            	    $this->graphNode();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt47 >= 1 ) break 2;//loop47;
                        $eee =
                            new EarlyExitException(47, $this->input);
                        throw $eee;
                }
                $cnt47++;
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_collection1257); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "collection"


    // $ANTLR start "graphNode"
    // Sparql10.g:344:1: graphNode : ( varOrTerm | triplesNode ); 
    public function graphNode(){
        try {
            // Sparql10.g:345:3: ( varOrTerm | triplesNode ) 
            $alt48=2;
            $LA48 = $this->input->LA(1);
            if($this->getToken('TRUE')== $LA48||$this->getToken('FALSE')== $LA48||$this->getToken('IRI_REF')== $LA48||$this->getToken('PNAME_NS')== $LA48||$this->getToken('PNAME_LN')== $LA48||$this->getToken('VAR1')== $LA48||$this->getToken('VAR2')== $LA48||$this->getToken('INTEGER')== $LA48||$this->getToken('DECIMAL')== $LA48||$this->getToken('DOUBLE')== $LA48||$this->getToken('INTEGER_POSITIVE')== $LA48||$this->getToken('DECIMAL_POSITIVE')== $LA48||$this->getToken('DOUBLE_POSITIVE')== $LA48||$this->getToken('INTEGER_NEGATIVE')== $LA48||$this->getToken('DECIMAL_NEGATIVE')== $LA48||$this->getToken('DOUBLE_NEGATIVE')== $LA48||$this->getToken('STRING_LITERAL1')== $LA48||$this->getToken('STRING_LITERAL2')== $LA48||$this->getToken('STRING_LITERAL_LONG1')== $LA48||$this->getToken('STRING_LITERAL_LONG2')== $LA48||$this->getToken('BLANK_NODE_LABEL')== $LA48)
                {
                $alt48=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA48)
                {
                $LA48_2 = $this->input->LA(2);

                if ( ($LA48_2==$this->getToken('A')||$LA48_2==$this->getToken('IRI_REF')||$LA48_2==$this->getToken('PNAME_NS')||$LA48_2==$this->getToken('PNAME_LN')||($LA48_2>=$this->getToken('VAR1') && $LA48_2<=$this->getToken('VAR2'))) ) {
                    $alt48=2;
                }
                else if ( ($LA48_2==$this->getToken('WS')||$LA48_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt48=1;
                }
                else {
                    $nvae = new NoViableAltException("", 48, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA48)
                {
                $LA48_3 = $this->input->LA(2);

                if ( ($LA48_3==$this->getToken('WS')||$LA48_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt48=1;
                }
                else if ( (($LA48_3>=$this->getToken('TRUE') && $LA48_3<=$this->getToken('FALSE'))||$LA48_3==$this->getToken('IRI_REF')||$LA48_3==$this->getToken('PNAME_NS')||$LA48_3==$this->getToken('PNAME_LN')||($LA48_3>=$this->getToken('VAR1') && $LA48_3<=$this->getToken('VAR2'))||$LA48_3==$this->getToken('INTEGER')||$LA48_3==$this->getToken('DECIMAL')||$LA48_3==$this->getToken('DOUBLE')||($LA48_3>=$this->getToken('INTEGER_POSITIVE') && $LA48_3<=$this->getToken('DOUBLE_NEGATIVE'))||($LA48_3>=$this->getToken('STRING_LITERAL1') && $LA48_3<=$this->getToken('STRING_LITERAL_LONG2'))||$LA48_3==$this->getToken('BLANK_NODE_LABEL')||$LA48_3==$this->getToken('OPEN_BRACE')||$LA48_3==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt48=2;
                }
                else {
                    $nvae = new NoViableAltException("", 48, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 48, 0, $this->input);

                throw $nvae;
            }

            switch ($alt48) {
                case 1 :
                    // Sparql10.g:346:3: varOrTerm 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_graphNode1275);
                    $this->varOrTerm();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:347:5: triplesNode 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_graphNode1281);
                    $this->triplesNode();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "graphNode"


    // $ANTLR start "varOrTerm"
    // Sparql10.g:352:1: varOrTerm : ( variable | graphTerm ); 
    public function varOrTerm(){
        try {
            // Sparql10.g:353:3: ( variable | graphTerm ) 
            $alt49=2;
            $LA49_0 = $this->input->LA(1);

            if ( (($LA49_0>=$this->getToken('VAR1') && $LA49_0<=$this->getToken('VAR2'))) ) {
                $alt49=1;
            }
            else if ( (($LA49_0>=$this->getToken('TRUE') && $LA49_0<=$this->getToken('FALSE'))||$LA49_0==$this->getToken('IRI_REF')||$LA49_0==$this->getToken('PNAME_NS')||$LA49_0==$this->getToken('PNAME_LN')||$LA49_0==$this->getToken('INTEGER')||$LA49_0==$this->getToken('DECIMAL')||$LA49_0==$this->getToken('DOUBLE')||($LA49_0>=$this->getToken('INTEGER_POSITIVE') && $LA49_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA49_0>=$this->getToken('STRING_LITERAL1') && $LA49_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA49_0==$this->getToken('BLANK_NODE_LABEL')||$LA49_0==$this->getToken('OPEN_BRACE')||$LA49_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt49=2;
            }
            else {
                $nvae = new NoViableAltException("", 49, 0, $this->input);

                throw $nvae;
            }
            switch ($alt49) {
                case 1 :
                    // Sparql10.g:354:3: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_varOrTerm1299);
                    $this->variable();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:355:5: graphTerm 
                    {
                    $this->pushFollow(self::$FOLLOW_graphTerm_in_varOrTerm1305);
                    $this->graphTerm();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "varOrTerm"


    // $ANTLR start "varOrIRIref"
    // Sparql10.g:360:1: varOrIRIref : ( variable | iriRef ); 
    public function varOrIRIref(){
        try {
            // Sparql10.g:361:3: ( variable | iriRef ) 
            $alt50=2;
            $LA50_0 = $this->input->LA(1);

            if ( (($LA50_0>=$this->getToken('VAR1') && $LA50_0<=$this->getToken('VAR2'))) ) {
                $alt50=1;
            }
            else if ( ($LA50_0==$this->getToken('IRI_REF')||$LA50_0==$this->getToken('PNAME_NS')||$LA50_0==$this->getToken('PNAME_LN')) ) {
                $alt50=2;
            }
            else {
                $nvae = new NoViableAltException("", 50, 0, $this->input);

                throw $nvae;
            }
            switch ($alt50) {
                case 1 :
                    // Sparql10.g:362:3: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_varOrIRIref1323);
                    $this->variable();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:363:5: iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_varOrIRIref1329);
                    $this->iriRef();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "varOrIRIref"


    // $ANTLR start "variable"
    // Sparql10.g:368:1: variable : (v= VAR1 | v= VAR2 ); 
    public function variable(){
        $v=null;

        try {
            // Sparql10.g:369:3: (v= VAR1 | v= VAR2 ) 
            $alt51=2;
            $LA51_0 = $this->input->LA(1);

            if ( ($LA51_0==$this->getToken('VAR1')) ) {
                $alt51=1;
            }
            else if ( ($LA51_0==$this->getToken('VAR2')) ) {
                $alt51=2;
            }
            else {
                $nvae = new NoViableAltException("", 51, 0, $this->input);

                throw $nvae;
            }
            switch ($alt51) {
                case 1 :
                    // Sparql10.g:370:3: v= VAR1 
                    {
                    $v=$this->match($this->input,$this->getToken('VAR1'),self::$FOLLOW_VAR1_in_variable1349); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:371:5: v= VAR2 
                    {
                    $v=$this->match($this->input,$this->getToken('VAR2'),self::$FOLLOW_VAR2_in_variable1357); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "variable"


    // $ANTLR start "graphTerm"
    // Sparql10.g:376:1: graphTerm : (v= iriRef | v= rdfLiteral | v= numericLiteral | v= booleanLiteral | v= blankNode | OPEN_BRACE ( WS )* CLOSE_BRACE ); 
    public function graphTerm(){
        try {
            // Sparql10.g:377:3: (v= iriRef | v= rdfLiteral | v= numericLiteral | v= booleanLiteral | v= blankNode | OPEN_BRACE ( WS )* CLOSE_BRACE ) 
            $alt53=6;
            $LA53 = $this->input->LA(1);
            if($this->getToken('IRI_REF')== $LA53||$this->getToken('PNAME_NS')== $LA53||$this->getToken('PNAME_LN')== $LA53)
                {
                $alt53=1;
                }
            else if($this->getToken('STRING_LITERAL1')== $LA53||$this->getToken('STRING_LITERAL2')== $LA53||$this->getToken('STRING_LITERAL_LONG1')== $LA53||$this->getToken('STRING_LITERAL_LONG2')== $LA53)
                {
                $alt53=2;
                }
            else if($this->getToken('INTEGER')== $LA53||$this->getToken('DECIMAL')== $LA53||$this->getToken('DOUBLE')== $LA53||$this->getToken('INTEGER_POSITIVE')== $LA53||$this->getToken('DECIMAL_POSITIVE')== $LA53||$this->getToken('DOUBLE_POSITIVE')== $LA53||$this->getToken('INTEGER_NEGATIVE')== $LA53||$this->getToken('DECIMAL_NEGATIVE')== $LA53||$this->getToken('DOUBLE_NEGATIVE')== $LA53)
                {
                $alt53=3;
                }
            else if($this->getToken('TRUE')== $LA53||$this->getToken('FALSE')== $LA53)
                {
                $alt53=4;
                }
            else if($this->getToken('BLANK_NODE_LABEL')== $LA53||$this->getToken('OPEN_SQUARE_BRACE')== $LA53)
                {
                $alt53=5;
                }
            else if($this->getToken('OPEN_BRACE')== $LA53)
                {
                $alt53=6;
                }
            else{
                $nvae =
                    new NoViableAltException("", 53, 0, $this->input);

                throw $nvae;
            }

            switch ($alt53) {
                case 1 :
                    // Sparql10.g:378:3: v= iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_graphTerm1377);
                    $this->iriRef();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:379:5: v= rdfLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_rdfLiteral_in_graphTerm1385);
                    $this->rdfLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql10.g:380:5: v= numericLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteral_in_graphTerm1393);
                    $this->numericLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql10.g:381:5: v= booleanLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_booleanLiteral_in_graphTerm1401);
                    $this->booleanLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Sparql10.g:382:5: v= blankNode 
                    {
                    $this->pushFollow(self::$FOLLOW_blankNode_in_graphTerm1409);
                    $this->blankNode();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Sparql10.g:383:5: OPEN_BRACE ( WS )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_graphTerm1415); 
                    // Sparql10.g:383:16: ( WS )* 
                    //loop52:
                    do {
                        $alt52=2;
                        $LA52_0 = $this->input->LA(1);

                        if ( ($LA52_0==$this->getToken('WS')) ) {
                            $alt52=1;
                        }


                        switch ($alt52) {
                    	case 1 :
                    	    // Sparql10.g:383:16: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_graphTerm1417); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop52;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_graphTerm1420); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "graphTerm"


    // $ANTLR start "expression"
    // Sparql10.g:388:1: expression : conditionalOrExpression ; 
    public function expression(){
        try {
            // Sparql10.g:389:3: ( conditionalOrExpression ) 
            // Sparql10.g:390:3: conditionalOrExpression 
            {
            $this->pushFollow(self::$FOLLOW_conditionalOrExpression_in_expression1438);
            $this->conditionalOrExpression();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "expression"


    // $ANTLR start "conditionalOrExpression"
    // Sparql10.g:395:1: conditionalOrExpression : c1= conditionalAndExpression ( OR c2= conditionalAndExpression )* ; 
    public function conditionalOrExpression(){
        try {
            // Sparql10.g:396:3: (c1= conditionalAndExpression ( OR c2= conditionalAndExpression )* ) 
            // Sparql10.g:397:3: c1= conditionalAndExpression ( OR c2= conditionalAndExpression )* 
            {
            $this->pushFollow(self::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1458);
            $this->conditionalAndExpression();

            $this->state->_fsp--;

            // Sparql10.g:397:31: ( OR c2= conditionalAndExpression )* 
            //loop54:
            do {
                $alt54=2;
                $LA54_0 = $this->input->LA(1);

                if ( ($LA54_0==$this->getToken('OR')) ) {
                    $alt54=1;
                }


                switch ($alt54) {
            	case 1 :
            	    // Sparql10.g:397:32: OR c2= conditionalAndExpression 
            	    {
            	    $this->match($this->input,$this->getToken('OR'),self::$FOLLOW_OR_in_conditionalOrExpression1461); 
            	    $this->pushFollow(self::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1465);
            	    $this->conditionalAndExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop54;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "conditionalOrExpression"


    // $ANTLR start "conditionalAndExpression"
    // Sparql10.g:402:1: conditionalAndExpression : v1= valueLogical ( AND v2= valueLogical )* ; 
    public function conditionalAndExpression(){
        try {
            // Sparql10.g:403:3: (v1= valueLogical ( AND v2= valueLogical )* ) 
            // Sparql10.g:404:3: v1= valueLogical ( AND v2= valueLogical )* 
            {
            $this->pushFollow(self::$FOLLOW_valueLogical_in_conditionalAndExpression1487);
            $this->valueLogical();

            $this->state->_fsp--;

            // Sparql10.g:404:19: ( AND v2= valueLogical )* 
            //loop55:
            do {
                $alt55=2;
                $LA55_0 = $this->input->LA(1);

                if ( ($LA55_0==$this->getToken('AND')) ) {
                    $alt55=1;
                }


                switch ($alt55) {
            	case 1 :
            	    // Sparql10.g:404:20: AND v2= valueLogical 
            	    {
            	    $this->match($this->input,$this->getToken('AND'),self::$FOLLOW_AND_in_conditionalAndExpression1490); 
            	    $this->pushFollow(self::$FOLLOW_valueLogical_in_conditionalAndExpression1494);
            	    $this->valueLogical();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop55;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "conditionalAndExpression"


    // $ANTLR start "valueLogical"
    // Sparql10.g:409:1: valueLogical : relationalExpression ; 
    public function valueLogical(){
        try {
            // Sparql10.g:410:3: ( relationalExpression ) 
            // Sparql10.g:411:3: relationalExpression 
            {
            $this->pushFollow(self::$FOLLOW_relationalExpression_in_valueLogical1514);
            $this->relationalExpression();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "valueLogical"


    // $ANTLR start "relationalExpression"
    // Sparql10.g:416:1: relationalExpression : n1= numericExpression ( EQUAL n2= numericExpression | NOT_EQUAL n2= numericExpression | LESS n2= numericExpression | GREATER n2= numericExpression | LESS_EQUAL n2= numericExpression | GREATER_EQUAL n2= numericExpression )? ; 
    public function relationalExpression(){
        try {
            // Sparql10.g:417:3: (n1= numericExpression ( EQUAL n2= numericExpression | NOT_EQUAL n2= numericExpression | LESS n2= numericExpression | GREATER n2= numericExpression | LESS_EQUAL n2= numericExpression | GREATER_EQUAL n2= numericExpression )? ) 
            // Sparql10.g:418:3: n1= numericExpression ( EQUAL n2= numericExpression | NOT_EQUAL n2= numericExpression | LESS n2= numericExpression | GREATER n2= numericExpression | LESS_EQUAL n2= numericExpression | GREATER_EQUAL n2= numericExpression )? 
            {
            $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1534);
            $this->numericExpression();

            $this->state->_fsp--;

            // Sparql10.g:419:3: ( EQUAL n2= numericExpression | NOT_EQUAL n2= numericExpression | LESS n2= numericExpression | GREATER n2= numericExpression | LESS_EQUAL n2= numericExpression | GREATER_EQUAL n2= numericExpression )? 
            $alt56=7;
            $LA56 = $this->input->LA(1);
            if($this->getToken('EQUAL')== $LA56)
                {
                $alt56=1;
                }
            else if($this->getToken('NOT_EQUAL')== $LA56)
                {
                $alt56=2;
                }
            else if($this->getToken('LESS')== $LA56)
                {
                $alt56=3;
                }
            else if($this->getToken('GREATER')== $LA56)
                {
                $alt56=4;
                }
            else if($this->getToken('LESS_EQUAL')== $LA56)
                {
                $alt56=5;
                }
            else if($this->getToken('GREATER_EQUAL')== $LA56)
                {
                $alt56=6;
                }

            switch ($alt56) {
                case 1 :
                    // Sparql10.g:420:5: EQUAL n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('EQUAL'),self::$FOLLOW_EQUAL_in_relationalExpression1544); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1548);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:421:7: NOT_EQUAL n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('NOT_EQUAL'),self::$FOLLOW_NOT_EQUAL_in_relationalExpression1556); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1560);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql10.g:422:7: LESS n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('LESS'),self::$FOLLOW_LESS_in_relationalExpression1568); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1572);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql10.g:423:7: GREATER n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('GREATER'),self::$FOLLOW_GREATER_in_relationalExpression1580); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1584);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Sparql10.g:424:7: LESS_EQUAL n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('LESS_EQUAL'),self::$FOLLOW_LESS_EQUAL_in_relationalExpression1592); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1596);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Sparql10.g:425:7: GREATER_EQUAL n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('GREATER_EQUAL'),self::$FOLLOW_GREATER_EQUAL_in_relationalExpression1604); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1608);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "relationalExpression"


    // $ANTLR start "numericExpression"
    // Sparql10.g:431:1: numericExpression : additiveExpression ; 
    public function numericExpression(){
        try {
            // Sparql10.g:432:3: ( additiveExpression ) 
            // Sparql10.g:433:3: additiveExpression 
            {
            $this->pushFollow(self::$FOLLOW_additiveExpression_in_numericExpression1631);
            $this->additiveExpression();

            $this->state->_fsp--;


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "numericExpression"


    // $ANTLR start "additiveExpression"
    // Sparql10.g:438:1: additiveExpression : m1= multiplicativeExpression ( (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) )* ; 
    public function additiveExpression(){
        $op=null;

        try {
            // Sparql10.g:439:3: (m1= multiplicativeExpression ( (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) )* ) 
            // Sparql10.g:440:3: m1= multiplicativeExpression ( (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) )* 
            {
            $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1651);
            $this->multiplicativeExpression();

            $this->state->_fsp--;

            // Sparql10.g:441:3: ( (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) )* 
            //loop58:
            do {
                $alt58=2;
                $LA58_0 = $this->input->LA(1);

                if ( ($LA58_0==$this->getToken('MINUS')||($LA58_0>=$this->getToken('PLUS') && $LA58_0<=$this->getToken('DOUBLE_NEGATIVE'))) ) {
                    $alt58=1;
                }


                switch ($alt58) {
            	case 1 :
            	    // Sparql10.g:442:5: (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) 
            	    {
            	    // Sparql10.g:442:5: (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) 
            	    $alt57=4;
            	    $LA57 = $this->input->LA(1);
            	    if($this->getToken('PLUS')== $LA57)
            	        {
            	        $alt57=1;
            	        }
            	    else if($this->getToken('MINUS')== $LA57)
            	        {
            	        $alt57=2;
            	        }
            	    else if($this->getToken('INTEGER_POSITIVE')== $LA57||$this->getToken('DECIMAL_POSITIVE')== $LA57||$this->getToken('DOUBLE_POSITIVE')== $LA57)
            	        {
            	        $alt57=3;
            	        }
            	    else if($this->getToken('INTEGER_NEGATIVE')== $LA57||$this->getToken('DECIMAL_NEGATIVE')== $LA57||$this->getToken('DOUBLE_NEGATIVE')== $LA57)
            	        {
            	        $alt57=4;
            	        }
            	    else{
            	        $nvae =
            	            new NoViableAltException("", 57, 0, $this->input);

            	        throw $nvae;
            	    }

            	    switch ($alt57) {
            	        case 1 :
            	            // Sparql10.g:443:7: op= PLUS m2= multiplicativeExpression 
            	            {
            	            $op=$this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_additiveExpression1671); 
            	            $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1675);
            	            $this->multiplicativeExpression();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 2 :
            	            // Sparql10.g:444:9: op= MINUS m2= multiplicativeExpression 
            	            {
            	            $op=$this->match($this->input,$this->getToken('MINUS'),self::$FOLLOW_MINUS_in_additiveExpression1687); 
            	            $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1691);
            	            $this->multiplicativeExpression();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 3 :
            	            // Sparql10.g:445:9: n= numericLiteralPositive 
            	            {
            	            $this->pushFollow(self::$FOLLOW_numericLiteralPositive_in_additiveExpression1703);
            	            $this->numericLiteralPositive();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 4 :
            	            // Sparql10.g:446:9: n= numericLiteralNegative 
            	            {
            	            $this->pushFollow(self::$FOLLOW_numericLiteralNegative_in_additiveExpression1715);
            	            $this->numericLiteralNegative();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop58;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "additiveExpression"


    // $ANTLR start "multiplicativeExpression"
    // Sparql10.g:453:1: multiplicativeExpression : u1= unaryExpression ( (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) )* ; 
    public function multiplicativeExpression(){
        $op=null;

        try {
            // Sparql10.g:454:3: (u1= unaryExpression ( (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) )* ) 
            // Sparql10.g:455:3: u1= unaryExpression ( (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) )* 
            {
            $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1746);
            $this->unaryExpression();

            $this->state->_fsp--;

            // Sparql10.g:456:3: ( (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) )* 
            //loop60:
            do {
                $alt60=2;
                $LA60_0 = $this->input->LA(1);

                if ( ($LA60_0==$this->getToken('ASTERISK')||$LA60_0==$this->getToken('DIVIDE')) ) {
                    $alt60=1;
                }


                switch ($alt60) {
            	case 1 :
            	    // Sparql10.g:457:5: (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) 
            	    {
            	    // Sparql10.g:457:5: (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) 
            	    $alt59=2;
            	    $LA59_0 = $this->input->LA(1);

            	    if ( ($LA59_0==$this->getToken('ASTERISK')) ) {
            	        $alt59=1;
            	    }
            	    else if ( ($LA59_0==$this->getToken('DIVIDE')) ) {
            	        $alt59=2;
            	    }
            	    else {
            	        $nvae = new NoViableAltException("", 59, 0, $this->input);

            	        throw $nvae;
            	    }
            	    switch ($alt59) {
            	        case 1 :
            	            // Sparql10.g:458:7: op= ASTERISK u2= unaryExpression 
            	            {
            	            $op=$this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_multiplicativeExpression1766); 
            	            $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1770);
            	            $this->unaryExpression();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 2 :
            	            // Sparql10.g:459:9: op= DIVIDE u2= unaryExpression 
            	            {
            	            $op=$this->match($this->input,$this->getToken('DIVIDE'),self::$FOLLOW_DIVIDE_in_multiplicativeExpression1782); 
            	            $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1786);
            	            $this->unaryExpression();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop60;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "multiplicativeExpression"


    // $ANTLR start "unaryExpression"
    // Sparql10.g:466:1: unaryExpression : ( NOT_SIGN e= primaryExpression | PLUS e= primaryExpression | MINUS e= primaryExpression | e= primaryExpression ); 
    public function unaryExpression(){
        try {
            // Sparql10.g:467:3: ( NOT_SIGN e= primaryExpression | PLUS e= primaryExpression | MINUS e= primaryExpression | e= primaryExpression ) 
            $alt61=4;
            $LA61 = $this->input->LA(1);
            if($this->getToken('NOT_SIGN')== $LA61)
                {
                $alt61=1;
                }
            else if($this->getToken('PLUS')== $LA61)
                {
                $alt61=2;
                }
            else if($this->getToken('MINUS')== $LA61)
                {
                $alt61=3;
                }
            else if($this->getToken('STR')== $LA61||$this->getToken('LANG')== $LA61||$this->getToken('LANGMATCHES')== $LA61||$this->getToken('DATATYPE')== $LA61||$this->getToken('BOUND')== $LA61||$this->getToken('SAMETERM')== $LA61||$this->getToken('ISIRI')== $LA61||$this->getToken('ISURI')== $LA61||$this->getToken('ISBLANK')== $LA61||$this->getToken('ISLITERAL')== $LA61||$this->getToken('REGEX')== $LA61||$this->getToken('TRUE')== $LA61||$this->getToken('FALSE')== $LA61||$this->getToken('IRI_REF')== $LA61||$this->getToken('PNAME_NS')== $LA61||$this->getToken('PNAME_LN')== $LA61||$this->getToken('VAR1')== $LA61||$this->getToken('VAR2')== $LA61||$this->getToken('INTEGER')== $LA61||$this->getToken('DECIMAL')== $LA61||$this->getToken('DOUBLE')== $LA61||$this->getToken('INTEGER_POSITIVE')== $LA61||$this->getToken('DECIMAL_POSITIVE')== $LA61||$this->getToken('DOUBLE_POSITIVE')== $LA61||$this->getToken('INTEGER_NEGATIVE')== $LA61||$this->getToken('DECIMAL_NEGATIVE')== $LA61||$this->getToken('DOUBLE_NEGATIVE')== $LA61||$this->getToken('STRING_LITERAL1')== $LA61||$this->getToken('STRING_LITERAL2')== $LA61||$this->getToken('STRING_LITERAL_LONG1')== $LA61||$this->getToken('STRING_LITERAL_LONG2')== $LA61||$this->getToken('OPEN_BRACE')== $LA61)
                {
                $alt61=4;
                }
            else{
                $nvae =
                    new NoViableAltException("", 61, 0, $this->input);

                throw $nvae;
            }

            switch ($alt61) {
                case 1 :
                    // Sparql10.g:468:3: NOT_SIGN e= primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('NOT_SIGN'),self::$FOLLOW_NOT_SIGN_in_unaryExpression1815); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1819);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:469:5: PLUS e= primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_unaryExpression1825); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1829);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql10.g:470:5: MINUS e= primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('MINUS'),self::$FOLLOW_MINUS_in_unaryExpression1835); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1839);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql10.g:471:5: e= primaryExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1847);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "unaryExpression"


    // $ANTLR start "primaryExpression"
    // Sparql10.g:476:1: primaryExpression : (v= brackettedExpression | v= builtInCall | v= iriRefOrFunction | v= rdfLiteral | v= numericLiteral | v= booleanLiteral | v= variable ); 
    public function primaryExpression(){
        try {
            // Sparql10.g:477:3: (v= brackettedExpression | v= builtInCall | v= iriRefOrFunction | v= rdfLiteral | v= numericLiteral | v= booleanLiteral | v= variable ) 
            $alt62=7;
            $LA62 = $this->input->LA(1);
            if($this->getToken('OPEN_BRACE')== $LA62)
                {
                $alt62=1;
                }
            else if($this->getToken('STR')== $LA62||$this->getToken('LANG')== $LA62||$this->getToken('LANGMATCHES')== $LA62||$this->getToken('DATATYPE')== $LA62||$this->getToken('BOUND')== $LA62||$this->getToken('SAMETERM')== $LA62||$this->getToken('ISIRI')== $LA62||$this->getToken('ISURI')== $LA62||$this->getToken('ISBLANK')== $LA62||$this->getToken('ISLITERAL')== $LA62||$this->getToken('REGEX')== $LA62)
                {
                $alt62=2;
                }
            else if($this->getToken('IRI_REF')== $LA62||$this->getToken('PNAME_NS')== $LA62||$this->getToken('PNAME_LN')== $LA62)
                {
                $alt62=3;
                }
            else if($this->getToken('STRING_LITERAL1')== $LA62||$this->getToken('STRING_LITERAL2')== $LA62||$this->getToken('STRING_LITERAL_LONG1')== $LA62||$this->getToken('STRING_LITERAL_LONG2')== $LA62)
                {
                $alt62=4;
                }
            else if($this->getToken('INTEGER')== $LA62||$this->getToken('DECIMAL')== $LA62||$this->getToken('DOUBLE')== $LA62||$this->getToken('INTEGER_POSITIVE')== $LA62||$this->getToken('DECIMAL_POSITIVE')== $LA62||$this->getToken('DOUBLE_POSITIVE')== $LA62||$this->getToken('INTEGER_NEGATIVE')== $LA62||$this->getToken('DECIMAL_NEGATIVE')== $LA62||$this->getToken('DOUBLE_NEGATIVE')== $LA62)
                {
                $alt62=5;
                }
            else if($this->getToken('TRUE')== $LA62||$this->getToken('FALSE')== $LA62)
                {
                $alt62=6;
                }
            else if($this->getToken('VAR1')== $LA62||$this->getToken('VAR2')== $LA62)
                {
                $alt62=7;
                }
            else{
                $nvae =
                    new NoViableAltException("", 62, 0, $this->input);

                throw $nvae;
            }

            switch ($alt62) {
                case 1 :
                    // Sparql10.g:478:3: v= brackettedExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_primaryExpression1867);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:479:5: v= builtInCall 
                    {
                    $this->pushFollow(self::$FOLLOW_builtInCall_in_primaryExpression1875);
                    $this->builtInCall();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql10.g:480:5: v= iriRefOrFunction 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRefOrFunction_in_primaryExpression1883);
                    $this->iriRefOrFunction();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql10.g:481:5: v= rdfLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_rdfLiteral_in_primaryExpression1891);
                    $this->rdfLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Sparql10.g:482:5: v= numericLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteral_in_primaryExpression1899);
                    $this->numericLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Sparql10.g:483:5: v= booleanLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_booleanLiteral_in_primaryExpression1907);
                    $this->booleanLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 7 :
                    // Sparql10.g:484:5: v= variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_primaryExpression1915);
                    $this->variable();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "primaryExpression"


    // $ANTLR start "brackettedExpression"
    // Sparql10.g:489:1: brackettedExpression : OPEN_BRACE e= expression CLOSE_BRACE ; 
    public function brackettedExpression(){
        try {
            // Sparql10.g:490:3: ( OPEN_BRACE e= expression CLOSE_BRACE ) 
            // Sparql10.g:491:3: OPEN_BRACE e= expression CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_brackettedExpression1933); 
            $this->pushFollow(self::$FOLLOW_expression_in_brackettedExpression1937);
            $this->expression();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_brackettedExpression1939); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "brackettedExpression"


    // $ANTLR start "builtInCall"
    // Sparql10.g:496:1: builtInCall : ( STR OPEN_BRACE e= expression CLOSE_BRACE | LANG OPEN_BRACE e= expression CLOSE_BRACE | LANGMATCHES OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE | DATATYPE OPEN_BRACE e= expression CLOSE_BRACE | BOUND OPEN_BRACE variable CLOSE_BRACE | SAMETERM OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE | ISIRI OPEN_BRACE e= expression CLOSE_BRACE | ISURI OPEN_BRACE e= expression CLOSE_BRACE | ISBLANK OPEN_BRACE e= expression CLOSE_BRACE | ISLITERAL OPEN_BRACE e= expression CLOSE_BRACE | regexExpression ); 
    public function builtInCall(){
        try {
            // Sparql10.g:497:3: ( STR OPEN_BRACE e= expression CLOSE_BRACE | LANG OPEN_BRACE e= expression CLOSE_BRACE | LANGMATCHES OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE | DATATYPE OPEN_BRACE e= expression CLOSE_BRACE | BOUND OPEN_BRACE variable CLOSE_BRACE | SAMETERM OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE | ISIRI OPEN_BRACE e= expression CLOSE_BRACE | ISURI OPEN_BRACE e= expression CLOSE_BRACE | ISBLANK OPEN_BRACE e= expression CLOSE_BRACE | ISLITERAL OPEN_BRACE e= expression CLOSE_BRACE | regexExpression ) 
            $alt63=11;
            $LA63 = $this->input->LA(1);
            if($this->getToken('STR')== $LA63)
                {
                $alt63=1;
                }
            else if($this->getToken('LANG')== $LA63)
                {
                $alt63=2;
                }
            else if($this->getToken('LANGMATCHES')== $LA63)
                {
                $alt63=3;
                }
            else if($this->getToken('DATATYPE')== $LA63)
                {
                $alt63=4;
                }
            else if($this->getToken('BOUND')== $LA63)
                {
                $alt63=5;
                }
            else if($this->getToken('SAMETERM')== $LA63)
                {
                $alt63=6;
                }
            else if($this->getToken('ISIRI')== $LA63)
                {
                $alt63=7;
                }
            else if($this->getToken('ISURI')== $LA63)
                {
                $alt63=8;
                }
            else if($this->getToken('ISBLANK')== $LA63)
                {
                $alt63=9;
                }
            else if($this->getToken('ISLITERAL')== $LA63)
                {
                $alt63=10;
                }
            else if($this->getToken('REGEX')== $LA63)
                {
                $alt63=11;
                }
            else{
                $nvae =
                    new NoViableAltException("", 63, 0, $this->input);

                throw $nvae;
            }

            switch ($alt63) {
                case 1 :
                    // Sparql10.g:498:3: STR OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('STR'),self::$FOLLOW_STR_in_builtInCall1957); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1959); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1963);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1965); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:499:5: LANG OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('LANG'),self::$FOLLOW_LANG_in_builtInCall1971); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1973); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1977);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1979); 

                    }
                    break;
                case 3 :
                    // Sparql10.g:500:5: LANGMATCHES OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('LANGMATCHES'),self::$FOLLOW_LANGMATCHES_in_builtInCall1985); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1987); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1991);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall1993); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1997);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1999); 

                    }
                    break;
                case 4 :
                    // Sparql10.g:501:5: DATATYPE OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('DATATYPE'),self::$FOLLOW_DATATYPE_in_builtInCall2005); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2007); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2011);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2013); 

                    }
                    break;
                case 5 :
                    // Sparql10.g:502:5: BOUND OPEN_BRACE variable CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('BOUND'),self::$FOLLOW_BOUND_in_builtInCall2019); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2021); 
                    $this->pushFollow(self::$FOLLOW_variable_in_builtInCall2023);
                    $this->variable();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2025); 

                    }
                    break;
                case 6 :
                    // Sparql10.g:503:5: SAMETERM OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('SAMETERM'),self::$FOLLOW_SAMETERM_in_builtInCall2031); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2033); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2037);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall2039); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2043);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2045); 

                    }
                    break;
                case 7 :
                    // Sparql10.g:504:5: ISIRI OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISIRI'),self::$FOLLOW_ISIRI_in_builtInCall2051); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2053); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2057);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2059); 

                    }
                    break;
                case 8 :
                    // Sparql10.g:505:5: ISURI OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISURI'),self::$FOLLOW_ISURI_in_builtInCall2065); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2067); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2071);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2073); 

                    }
                    break;
                case 9 :
                    // Sparql10.g:506:5: ISBLANK OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISBLANK'),self::$FOLLOW_ISBLANK_in_builtInCall2079); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2081); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2085);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2087); 

                    }
                    break;
                case 10 :
                    // Sparql10.g:507:5: ISLITERAL OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISLITERAL'),self::$FOLLOW_ISLITERAL_in_builtInCall2093); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2095); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2099);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2101); 

                    }
                    break;
                case 11 :
                    // Sparql10.g:508:5: regexExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_regexExpression_in_builtInCall2107);
                    $this->regexExpression();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "builtInCall"


    // $ANTLR start "regexExpression"
    // Sparql10.g:513:1: regexExpression : REGEX OPEN_BRACE e1= expression COMMA e2= expression ( COMMA e3= expression )? CLOSE_BRACE ; 
    public function regexExpression(){
        try {
            // Sparql10.g:514:3: ( REGEX OPEN_BRACE e1= expression COMMA e2= expression ( COMMA e3= expression )? CLOSE_BRACE ) 
            // Sparql10.g:515:3: REGEX OPEN_BRACE e1= expression COMMA e2= expression ( COMMA e3= expression )? CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('REGEX'),self::$FOLLOW_REGEX_in_regexExpression2125); 
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_regexExpression2130); 
            $this->pushFollow(self::$FOLLOW_expression_in_regexExpression2134);
            $this->expression();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_regexExpression2136); 
            $this->pushFollow(self::$FOLLOW_expression_in_regexExpression2140);
            $this->expression();

            $this->state->_fsp--;

            // Sparql10.g:516:48: ( COMMA e3= expression )? 
            $alt64=2;
            $LA64_0 = $this->input->LA(1);

            if ( ($LA64_0==$this->getToken('COMMA')) ) {
                $alt64=1;
            }
            switch ($alt64) {
                case 1 :
                    // Sparql10.g:516:49: COMMA e3= expression 
                    {
                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_regexExpression2143); 
                    $this->pushFollow(self::$FOLLOW_expression_in_regexExpression2147);
                    $this->expression();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_regexExpression2151); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "regexExpression"


    // $ANTLR start "iriRefOrFunction"
    // Sparql10.g:521:1: iriRefOrFunction : iriRef ( argList )? ; 
    public function iriRefOrFunction(){
        try {
            // Sparql10.g:522:3: ( iriRef ( argList )? ) 
            // Sparql10.g:523:3: iriRef ( argList )? 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_iriRefOrFunction2169);
            $this->iriRef();

            $this->state->_fsp--;

            // Sparql10.g:523:10: ( argList )? 
            $alt65=2;
            $LA65_0 = $this->input->LA(1);

            if ( ($LA65_0==$this->getToken('OPEN_BRACE')) ) {
                $alt65=1;
            }
            switch ($alt65) {
                case 1 :
                    // Sparql10.g:523:11: argList 
                    {
                    $this->pushFollow(self::$FOLLOW_argList_in_iriRefOrFunction2172);
                    $this->argList();

                    $this->state->_fsp--;


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "iriRefOrFunction"


    // $ANTLR start "rdfLiteral"
    // Sparql10.g:528:1: rdfLiteral : string ( LANGTAG | ( REFERENCE iriRef ) )? ; 
    public function rdfLiteral(){
        try {
            // Sparql10.g:529:3: ( string ( LANGTAG | ( REFERENCE iriRef ) )? ) 
            // Sparql10.g:530:3: string ( LANGTAG | ( REFERENCE iriRef ) )? 
            {
            $this->pushFollow(self::$FOLLOW_string_in_rdfLiteral2192);
            $this->string();

            $this->state->_fsp--;

            // Sparql10.g:531:3: ( LANGTAG | ( REFERENCE iriRef ) )? 
            $alt66=3;
            $LA66_0 = $this->input->LA(1);

            if ( ($LA66_0==$this->getToken('LANGTAG')) ) {
                $alt66=1;
            }
            else if ( ($LA66_0==$this->getToken('REFERENCE')) ) {
                $alt66=2;
            }
            switch ($alt66) {
                case 1 :
                    // Sparql10.g:532:5: LANGTAG 
                    {
                    $this->match($this->input,$this->getToken('LANGTAG'),self::$FOLLOW_LANGTAG_in_rdfLiteral2202); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:533:7: ( REFERENCE iriRef ) 
                    {
                    // Sparql10.g:533:7: ( REFERENCE iriRef ) 
                    // Sparql10.g:533:8: REFERENCE iriRef 
                    {
                    $this->match($this->input,$this->getToken('REFERENCE'),self::$FOLLOW_REFERENCE_in_rdfLiteral2211); 
                    $this->pushFollow(self::$FOLLOW_iriRef_in_rdfLiteral2213);
                    $this->iriRef();

                    $this->state->_fsp--;


                    }


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "rdfLiteral"


    // $ANTLR start "numericLiteral"
    // Sparql10.g:539:1: numericLiteral : (n= numericLiteralUnsigned | n= numericLiteralPositive | n= numericLiteralNegative ) ; 
    public function numericLiteral(){
        try {
            // Sparql10.g:540:3: ( (n= numericLiteralUnsigned | n= numericLiteralPositive | n= numericLiteralNegative ) ) 
            // Sparql10.g:541:3: (n= numericLiteralUnsigned | n= numericLiteralPositive | n= numericLiteralNegative ) 
            {
            // Sparql10.g:541:3: (n= numericLiteralUnsigned | n= numericLiteralPositive | n= numericLiteralNegative ) 
            $alt67=3;
            $LA67 = $this->input->LA(1);
            if($this->getToken('INTEGER')== $LA67||$this->getToken('DECIMAL')== $LA67||$this->getToken('DOUBLE')== $LA67)
                {
                $alt67=1;
                }
            else if($this->getToken('INTEGER_POSITIVE')== $LA67||$this->getToken('DECIMAL_POSITIVE')== $LA67||$this->getToken('DOUBLE_POSITIVE')== $LA67)
                {
                $alt67=2;
                }
            else if($this->getToken('INTEGER_NEGATIVE')== $LA67||$this->getToken('DECIMAL_NEGATIVE')== $LA67||$this->getToken('DOUBLE_NEGATIVE')== $LA67)
                {
                $alt67=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 67, 0, $this->input);

                throw $nvae;
            }

            switch ($alt67) {
                case 1 :
                    // Sparql10.g:542:5: n= numericLiteralUnsigned 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralUnsigned_in_numericLiteral2245);
                    $this->numericLiteralUnsigned();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql10.g:543:7: n= numericLiteralPositive 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralPositive_in_numericLiteral2255);
                    $this->numericLiteralPositive();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql10.g:544:7: n= numericLiteralNegative 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralNegative_in_numericLiteral2265);
                    $this->numericLiteralNegative();

                    $this->state->_fsp--;


                    }
                    break;

            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "numericLiteral"


    // $ANTLR start "numericLiteralUnsigned"
    // Sparql10.g:550:1: numericLiteralUnsigned : (v= INTEGER | v= DECIMAL | v= DOUBLE ); 
    public function numericLiteralUnsigned(){
        $v=null;

        try {
            // Sparql10.g:551:3: (v= INTEGER | v= DECIMAL | v= DOUBLE ) 
            $alt68=3;
            $LA68 = $this->input->LA(1);
            if($this->getToken('INTEGER')== $LA68)
                {
                $alt68=1;
                }
            else if($this->getToken('DECIMAL')== $LA68)
                {
                $alt68=2;
                }
            else if($this->getToken('DOUBLE')== $LA68)
                {
                $alt68=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 68, 0, $this->input);

                throw $nvae;
            }

            switch ($alt68) {
                case 1 :
                    // Sparql10.g:552:3: v= INTEGER 
                    {
                    $v=$this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_numericLiteralUnsigned2289); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:553:5: v= DECIMAL 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL'),self::$FOLLOW_DECIMAL_in_numericLiteralUnsigned2297); 

                    }
                    break;
                case 3 :
                    // Sparql10.g:554:5: v= DOUBLE 
                    {
                    $v=$this->match($this->input,$this->getToken('DOUBLE'),self::$FOLLOW_DOUBLE_in_numericLiteralUnsigned2305); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "numericLiteralUnsigned"


    // $ANTLR start "numericLiteralPositive"
    // Sparql10.g:559:1: numericLiteralPositive : (v= INTEGER_POSITIVE | v= DECIMAL_POSITIVE | v= DOUBLE_POSITIVE ); 
    public function numericLiteralPositive(){
        $v=null;

        try {
            // Sparql10.g:560:3: (v= INTEGER_POSITIVE | v= DECIMAL_POSITIVE | v= DOUBLE_POSITIVE ) 
            $alt69=3;
            $LA69 = $this->input->LA(1);
            if($this->getToken('INTEGER_POSITIVE')== $LA69)
                {
                $alt69=1;
                }
            else if($this->getToken('DECIMAL_POSITIVE')== $LA69)
                {
                $alt69=2;
                }
            else if($this->getToken('DOUBLE_POSITIVE')== $LA69)
                {
                $alt69=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 69, 0, $this->input);

                throw $nvae;
            }

            switch ($alt69) {
                case 1 :
                    // Sparql10.g:561:3: v= INTEGER_POSITIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('INTEGER_POSITIVE'),self::$FOLLOW_INTEGER_POSITIVE_in_numericLiteralPositive2325); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:562:5: v= DECIMAL_POSITIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL_POSITIVE'),self::$FOLLOW_DECIMAL_POSITIVE_in_numericLiteralPositive2333); 

                    }
                    break;
                case 3 :
                    // Sparql10.g:563:5: v= DOUBLE_POSITIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('DOUBLE_POSITIVE'),self::$FOLLOW_DOUBLE_POSITIVE_in_numericLiteralPositive2341); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "numericLiteralPositive"


    // $ANTLR start "numericLiteralNegative"
    // Sparql10.g:568:1: numericLiteralNegative : (v= INTEGER_NEGATIVE | v= DECIMAL_NEGATIVE | v= DOUBLE_NEGATIVE ); 
    public function numericLiteralNegative(){
        $v=null;

        try {
            // Sparql10.g:569:3: (v= INTEGER_NEGATIVE | v= DECIMAL_NEGATIVE | v= DOUBLE_NEGATIVE ) 
            $alt70=3;
            $LA70 = $this->input->LA(1);
            if($this->getToken('INTEGER_NEGATIVE')== $LA70)
                {
                $alt70=1;
                }
            else if($this->getToken('DECIMAL_NEGATIVE')== $LA70)
                {
                $alt70=2;
                }
            else if($this->getToken('DOUBLE_NEGATIVE')== $LA70)
                {
                $alt70=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 70, 0, $this->input);

                throw $nvae;
            }

            switch ($alt70) {
                case 1 :
                    // Sparql10.g:570:3: v= INTEGER_NEGATIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('INTEGER_NEGATIVE'),self::$FOLLOW_INTEGER_NEGATIVE_in_numericLiteralNegative2361); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:571:5: v= DECIMAL_NEGATIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL_NEGATIVE'),self::$FOLLOW_DECIMAL_NEGATIVE_in_numericLiteralNegative2369); 

                    }
                    break;
                case 3 :
                    // Sparql10.g:572:5: v= DOUBLE_NEGATIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('DOUBLE_NEGATIVE'),self::$FOLLOW_DOUBLE_NEGATIVE_in_numericLiteralNegative2377); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "numericLiteralNegative"


    // $ANTLR start "booleanLiteral"
    // Sparql10.g:577:1: booleanLiteral : ( TRUE | FALSE ); 
    public function booleanLiteral(){
        try {
            // Sparql10.g:578:3: ( TRUE | FALSE ) 
            // Sparql10.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('TRUE') && $this->input->LA(1)<=$this->getToken('FALSE')) ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw $mse;
            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "booleanLiteral"


    // $ANTLR start "string"
    // Sparql10.g:585:1: string : ( STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 ); 
    public function string(){
        try {
            // Sparql10.g:586:3: ( STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 ) 
            // Sparql10.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('STRING_LITERAL1') && $this->input->LA(1)<=$this->getToken('STRING_LITERAL_LONG2')) ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw $mse;
            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "string"


    // $ANTLR start "iriRef"
    // Sparql10.g:595:1: iriRef : ( IRI_REF | prefixedName ); 
    public function iriRef(){
        try {
            // Sparql10.g:596:3: ( IRI_REF | prefixedName ) 
            $alt71=2;
            $LA71_0 = $this->input->LA(1);

            if ( ($LA71_0==$this->getToken('IRI_REF')) ) {
                $alt71=1;
            }
            else if ( ($LA71_0==$this->getToken('PNAME_NS')||$LA71_0==$this->getToken('PNAME_LN')) ) {
                $alt71=2;
            }
            else {
                $nvae = new NoViableAltException("", 71, 0, $this->input);

                throw $nvae;
            }
            switch ($alt71) {
                case 1 :
                    // Sparql10.g:597:3: IRI_REF 
                    {
                    $this->match($this->input,$this->getToken('IRI_REF'),self::$FOLLOW_IRI_REF_in_iriRef2455); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:598:5: prefixedName 
                    {
                    $this->pushFollow(self::$FOLLOW_prefixedName_in_iriRef2461);
                    $this->prefixedName();

                    $this->state->_fsp--;


                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "iriRef"


    // $ANTLR start "prefixedName"
    // Sparql10.g:603:1: prefixedName : ( PNAME_LN | PNAME_NS ); 
    public function prefixedName(){
        try {
            // Sparql10.g:604:3: ( PNAME_LN | PNAME_NS ) 
            // Sparql10.g: 
            {
            if ( $this->input->LA(1)==$this->getToken('PNAME_NS')||$this->input->LA(1)==$this->getToken('PNAME_LN') ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw $mse;
            }


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "prefixedName"


    // $ANTLR start "blankNode"
    // Sparql10.g:611:1: blankNode : (v= BLANK_NODE_LABEL | OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE ); 
    public function blankNode(){
        $v=null;

        try {
            // Sparql10.g:612:3: (v= BLANK_NODE_LABEL | OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE ) 
            $alt73=2;
            $LA73_0 = $this->input->LA(1);

            if ( ($LA73_0==$this->getToken('BLANK_NODE_LABEL')) ) {
                $alt73=1;
            }
            else if ( ($LA73_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt73=2;
            }
            else {
                $nvae = new NoViableAltException("", 73, 0, $this->input);

                throw $nvae;
            }
            switch ($alt73) {
                case 1 :
                    // Sparql10.g:613:3: v= BLANK_NODE_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('BLANK_NODE_LABEL'),self::$FOLLOW_BLANK_NODE_LABEL_in_blankNode2505); 

                    }
                    break;
                case 2 :
                    // Sparql10.g:614:5: OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2511); 
                    // Sparql10.g:614:23: ( WS )* 
                    //loop72:
                    do {
                        $alt72=2;
                        $LA72_0 = $this->input->LA(1);

                        if ( ($LA72_0==$this->getToken('WS')) ) {
                            $alt72=1;
                        }


                        switch ($alt72) {
                    	case 1 :
                    	    // Sparql10.g:614:24: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_blankNode2514); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop72;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2518); 

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "blankNode"

    // Delegated rules


    
}

 



Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_prologue_in_query1021 = new Set(array(24, 27, 28, 29));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_selectQuery_in_query1031 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_constructQuery_in_query1039 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_describeQuery_in_query1047 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_askQuery_in_query1055 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_baseDecl_in_prologue77 = new Set(array(1, 22));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_prefixDecl_in_prologue80 = new Set(array(1, 22));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_BASE_in_baseDecl99 = new Set(array(63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRef_in_baseDecl103 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_PREFIX_in_prefixDecl121 = new Set(array(65));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_PNAME_NS_in_prefixDecl126 = new Set(array(63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRef_in_prefixDecl128 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_SELECT_in_selectQuery146 = new Set(array(25, 26, 69, 70, 102));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_set_in_selectQuery150 = new Set(array(69, 70, 102));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_variable_in_selectQuery179 = new Set(array(30, 32, 61, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ASTERISK_in_selectQuery188 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_datasetClause_in_selectQuery196 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_whereClause_in_selectQuery199 = new Set(array(33, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_solutionModifier_in_selectQuery201 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CONSTRUCT_in_constructQuery219 = new Set(array(61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_constructTemplate_in_constructQuery224 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_datasetClause_in_constructQuery226 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_whereClause_in_constructQuery229 = new Set(array(33, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_solutionModifier_in_constructQuery231 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DESCRIBE_in_describeQuery249 = new Set(array(63, 65, 67, 69, 70, 102));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_varOrIRIref_in_describeQuery259 = new Set(array(30, 32, 33, 38, 39, 61, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ASTERISK_in_describeQuery268 = new Set(array(30, 32, 33, 38, 39, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_datasetClause_in_describeQuery276 = new Set(array(30, 32, 33, 38, 39, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_whereClause_in_describeQuery279 = new Set(array(33, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_solutionModifier_in_describeQuery282 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ASK_in_askQuery300 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_datasetClause_in_askQuery305 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_whereClause_in_askQuery308 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_FROM_in_datasetClause326 = new Set(array(31, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_defaultGraphClause_in_datasetClause336 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_namedGraphClause_in_datasetClause344 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_sourceSelector_in_defaultGraphClause366 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_NAMED_in_namedGraphClause384 = new Set(array(63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_sourceSelector_in_namedGraphClause389 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRef_in_sourceSelector407 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_WHERE_in_whereClause425 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_groupGraphPattern_in_whereClause428 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_orderClause_in_solutionModifier446 = new Set(array(1, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_limitOffsetClauses_in_solutionModifier449 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_limitClause_in_limitOffsetClauses467 = new Set(array(1, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_offsetClause_in_limitOffsetClauses469 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_offsetClause_in_limitOffsetClauses476 = new Set(array(1, 38));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_limitClause_in_limitOffsetClauses478 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ORDER_in_orderClause497 = new Set(array(35));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_BY_in_orderClause499 = new Set(array(36, 37, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 63, 65, 67, 69, 70, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_orderCondition_in_orderClause501 = new Set(array(1, 36, 37, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 63, 65, 67, 69, 70, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ASC_in_orderCondition536 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DESC_in_orderCondition548 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_brackettedExpression_in_orderCondition560 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_constraint_in_orderCondition580 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_variable_in_orderCondition590 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_LIMIT_in_limitClause612 = new Set(array(73));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_INTEGER_in_limitClause614 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OFFSET_in_offsetClause632 = new Set(array(73));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_INTEGER_in_offsetClause634 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern652 = new Set(array(30, 32, 40, 41, 43, 57, 58, 61, 62, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_triplesBlock_in_groupGraphPattern657 = new Set(array(30, 32, 40, 41, 43, 61, 62));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_graphPatternNotTriples_in_groupGraphPattern679 = new Set(array(30, 32, 40, 41, 43, 57, 58, 61, 62, 63, 65, 67, 69, 70, 73, 74, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_filter_in_groupGraphPattern691 = new Set(array(30, 32, 40, 41, 43, 57, 58, 61, 62, 63, 65, 67, 69, 70, 73, 74, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DOT_in_groupGraphPattern703 = new Set(array(30, 32, 40, 41, 43, 57, 58, 61, 62, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_triplesBlock_in_groupGraphPattern709 = new Set(array(30, 32, 40, 41, 43, 61, 62));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern720 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_triplesSameSubject_in_triplesBlock738 = new Set(array(1, 74));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DOT_in_triplesBlock741 = new Set(array(1, 57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_triplesBlock_in_triplesBlock746 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_optionalGraphPattern_in_graphPatternNotTriples770 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples778 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_graphGraphPattern_in_graphPatternNotTriples786 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPTIONAL_in_optionalGraphPattern804 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_groupGraphPattern_in_optionalGraphPattern806 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_GRAPH_in_graphGraphPattern824 = new Set(array(63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_varOrIRIref_in_graphGraphPattern826 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_groupGraphPattern_in_graphGraphPattern828 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern848 = new Set(array(1, 42));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_UNION_in_groupOrUnionGraphPattern851 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern855 = new Set(array(1, 42));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_FILTER_in_filter875 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 63, 65, 67, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_constraint_in_filter877 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_brackettedExpression_in_constraint897 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_builtInCall_in_constraint905 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_functionCall_in_constraint913 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRef_in_functionCall930 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_argList_in_functionCall932 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_argList950 = new Set(array(92, 108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_WS_in_argList952 = new Set(array(92, 108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_argList955 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_argList961 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_argList965 = new Set(array(103, 108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_COMMA_in_argList968 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_argList972 = new Set(array(103, 108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_argList976 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate994 = new Set(array(61, 62));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_constructTriples_in_constructTemplate997 = new Set(array(62));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate1001 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_CURLY_BRACE_in_constructTriples1019 = new Set(array(61, 62));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_constructTriples_in_constructTriples1022 = new Set(array(62));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTriples1026 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_varOrTerm_in_triplesSameSubject1044 = new Set(array(44, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_propertyListNotEmpty_in_triplesSameSubject1046 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_triplesNode_in_triplesSameSubject1052 = new Set(array(44, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_propertyList_in_triplesSameSubject1054 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_verb_in_propertyListNotEmpty1074 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_objectList_in_propertyListNotEmpty1078 = new Set(array(1, 101));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_SEMICOLON_in_propertyListNotEmpty1081 = new Set(array(1, 44, 63, 65, 67, 69, 70, 101));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_verb_in_propertyListNotEmpty1086 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_objectList_in_propertyListNotEmpty1090 = new Set(array(1, 101));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_propertyListNotEmpty_in_propertyList1113 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_object_in_objectList1135 = new Set(array(1, 103));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_COMMA_in_objectList1138 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_object_in_objectList1142 = new Set(array(1, 103));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_graphNode_in_object1162 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_varOrIRIref_in_verb1180 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_A_in_verb1186 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_collection_in_triplesNode1204 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_blankNodePropertyList_in_triplesNode1210 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1228 = new Set(array(44, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1230 = new Set(array(113));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1232 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_collection1250 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_graphNode_in_collection1253 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 108, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_collection1257 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_varOrTerm_in_graphNode1275 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_triplesNode_in_graphNode1281 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_variable_in_varOrTerm1299 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_graphTerm_in_varOrTerm1305 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_variable_in_varOrIRIref1323 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRef_in_varOrIRIref1329 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_VAR1_in_variable1349 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_VAR2_in_variable1357 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRef_in_graphTerm1377 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_rdfLiteral_in_graphTerm1385 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericLiteral_in_graphTerm1393 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_booleanLiteral_in_graphTerm1401 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_blankNode_in_graphTerm1409 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_graphTerm1415 = new Set(array(92, 108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_WS_in_graphTerm1417 = new Set(array(92, 108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_graphTerm1420 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_conditionalOrExpression_in_expression1438 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1458 = new Set(array(1, 99));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OR_in_conditionalOrExpression1461 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1465 = new Set(array(1, 99));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_valueLogical_in_conditionalAndExpression1487 = new Set(array(1, 98));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_AND_in_conditionalAndExpression1490 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_valueLogical_in_conditionalAndExpression1494 = new Set(array(1, 98));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_relationalExpression_in_valueLogical1514 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericExpression_in_relationalExpression1534 = new Set(array(1, 59, 60, 106, 109, 110, 111));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_EQUAL_in_relationalExpression1544 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericExpression_in_relationalExpression1548 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_NOT_EQUAL_in_relationalExpression1556 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericExpression_in_relationalExpression1560 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_LESS_in_relationalExpression1568 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericExpression_in_relationalExpression1572 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_GREATER_in_relationalExpression1580 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericExpression_in_relationalExpression1584 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_LESS_EQUAL_in_relationalExpression1592 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericExpression_in_relationalExpression1596 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_GREATER_EQUAL_in_relationalExpression1604 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericExpression_in_relationalExpression1608 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_additiveExpression_in_numericExpression1631 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_multiplicativeExpression_in_additiveExpression1651 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_PLUS_in_additiveExpression1671 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_multiplicativeExpression_in_additiveExpression1675 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_MINUS_in_additiveExpression1687 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_multiplicativeExpression_in_additiveExpression1691 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericLiteralPositive_in_additiveExpression1703 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericLiteralNegative_in_additiveExpression1715 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_unaryExpression_in_multiplicativeExpression1746 = new Set(array(1, 102, 105));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ASTERISK_in_multiplicativeExpression1766 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_unaryExpression_in_multiplicativeExpression1770 = new Set(array(1, 102, 105));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DIVIDE_in_multiplicativeExpression1782 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_unaryExpression_in_multiplicativeExpression1786 = new Set(array(1, 102, 105));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_NOT_SIGN_in_unaryExpression1815 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_primaryExpression_in_unaryExpression1819 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_PLUS_in_unaryExpression1825 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_primaryExpression_in_unaryExpression1829 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_MINUS_in_unaryExpression1835 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_primaryExpression_in_unaryExpression1839 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_primaryExpression_in_unaryExpression1847 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_brackettedExpression_in_primaryExpression1867 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_builtInCall_in_primaryExpression1875 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRefOrFunction_in_primaryExpression1883 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_rdfLiteral_in_primaryExpression1891 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericLiteral_in_primaryExpression1899 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_booleanLiteral_in_primaryExpression1907 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_variable_in_primaryExpression1915 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_brackettedExpression1933 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_brackettedExpression1937 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_brackettedExpression1939 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_STR_in_builtInCall1957 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall1959 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall1963 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall1965 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_LANG_in_builtInCall1971 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall1973 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall1977 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall1979 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_LANGMATCHES_in_builtInCall1985 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall1987 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall1991 = new Set(array(103));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_COMMA_in_builtInCall1993 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall1997 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall1999 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DATATYPE_in_builtInCall2005 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall2007 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall2011 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall2013 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_BOUND_in_builtInCall2019 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall2021 = new Set(array(69, 70));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_variable_in_builtInCall2023 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall2025 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_SAMETERM_in_builtInCall2031 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall2033 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall2037 = new Set(array(103));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_COMMA_in_builtInCall2039 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall2043 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall2045 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ISIRI_in_builtInCall2051 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall2053 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall2057 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall2059 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ISURI_in_builtInCall2065 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall2067 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall2071 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall2073 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ISBLANK_in_builtInCall2079 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall2081 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall2085 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall2087 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_ISLITERAL_in_builtInCall2093 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_builtInCall2095 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_builtInCall2099 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_builtInCall2101 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_regexExpression_in_builtInCall2107 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_REGEX_in_regexExpression2125 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_BRACE_in_regexExpression2130 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_regexExpression2134 = new Set(array(103));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_COMMA_in_regexExpression2136 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_regexExpression2140 = new Set(array(103, 108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_COMMA_in_regexExpression2143 = new Set(array(46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_expression_in_regexExpression2147 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_BRACE_in_regexExpression2151 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRef_in_iriRefOrFunction2169 = new Set(array(1, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_argList_in_iriRefOrFunction2172 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_string_in_rdfLiteral2192 = new Set(array(1, 72, 97));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_LANGTAG_in_rdfLiteral2202 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_REFERENCE_in_rdfLiteral2211 = new Set(array(63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_iriRef_in_rdfLiteral2213 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericLiteralUnsigned_in_numericLiteral2245 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericLiteralPositive_in_numericLiteral2255 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_numericLiteralNegative_in_numericLiteral2265 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_INTEGER_in_numericLiteralUnsigned2289 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DECIMAL_in_numericLiteralUnsigned2297 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DOUBLE_in_numericLiteralUnsigned2305 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_INTEGER_POSITIVE_in_numericLiteralPositive2325 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DECIMAL_POSITIVE_in_numericLiteralPositive2333 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DOUBLE_POSITIVE_in_numericLiteralPositive2341 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_INTEGER_NEGATIVE_in_numericLiteralNegative2361 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DECIMAL_NEGATIVE_in_numericLiteralNegative2369 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_DOUBLE_NEGATIVE_in_numericLiteralNegative2377 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_set_in_booleanLiteral0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_set_in_string0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_IRI_REF_in_iriRef2455 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_prefixedName_in_iriRef2461 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_set_in_prefixedName0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_BLANK_NODE_LABEL_in_blankNode2505 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2511 = new Set(array(92, 113));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_WS_in_blankNode2514 = new Set(array(92, 113));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql10::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2518 = new Set(array(1));

?>