<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 Sparql11query.g 2010-03-22 22:31:43


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query extends AntlrParser {
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
    public $gErfurt_Sparql_Parser_Sparql11_Query;
    public $gParent;

    
    static $FOLLOW_prologue_in_query1122;
    static $FOLLOW_selectQuery_in_query1132;
    static $FOLLOW_constructQuery_in_query1140;
    static $FOLLOW_describeQuery_in_query1148;
    static $FOLLOW_askQuery_in_query1156;
    static $FOLLOW_baseDecl_in_prologue78;
    static $FOLLOW_prefixDecl_in_prologue81;
    static $FOLLOW_BASE_in_baseDecl100;
    static $FOLLOW_iriRef_in_baseDecl102;
    static $FOLLOW_PREFIX_in_prefixDecl120;
    static $FOLLOW_PNAME_NS_in_prefixDecl122;
    static $FOLLOW_iriRef_in_prefixDecl124;
    static $FOLLOW_SELECT_in_selectQuery142;
    static $FOLLOW_set_in_selectQuery146;
    static $FOLLOW_variable_in_selectQuery175;
    static $FOLLOW_ASTERISK_in_selectQuery184;
    static $FOLLOW_datasetClause_in_selectQuery192;
    static $FOLLOW_whereClause_in_selectQuery195;
    static $FOLLOW_solutionModifier_in_selectQuery197;
    static $FOLLOW_CONSTRUCT_in_constructQuery215;
    static $FOLLOW_constructTemplate_in_constructQuery217;
    static $FOLLOW_datasetClause_in_constructQuery219;
    static $FOLLOW_whereClause_in_constructQuery222;
    static $FOLLOW_solutionModifier_in_constructQuery224;
    static $FOLLOW_DESCRIBE_in_describeQuery242;
    static $FOLLOW_varOrIRIref_in_describeQuery252;
    static $FOLLOW_ASTERISK_in_describeQuery261;
    static $FOLLOW_datasetClause_in_describeQuery269;
    static $FOLLOW_whereClause_in_describeQuery272;
    static $FOLLOW_solutionModifier_in_describeQuery275;
    static $FOLLOW_ASK_in_askQuery293;
    static $FOLLOW_datasetClause_in_askQuery295;
    static $FOLLOW_whereClause_in_askQuery298;
    static $FOLLOW_FROM_in_datasetClause316;
    static $FOLLOW_defaultGraphClause_in_datasetClause326;
    static $FOLLOW_namedGraphClause_in_datasetClause334;
    static $FOLLOW_sourceSelector_in_defaultGraphClause356;
    static $FOLLOW_NAMED_in_namedGraphClause374;
    static $FOLLOW_sourceSelector_in_namedGraphClause376;
    static $FOLLOW_iriRef_in_sourceSelector394;
    static $FOLLOW_WHERE_in_whereClause412;
    static $FOLLOW_groupGraphPattern_in_whereClause415;
    static $FOLLOW_orderClause_in_solutionModifier433;
    static $FOLLOW_limitOffsetClauses_in_solutionModifier436;
    static $FOLLOW_limitClause_in_limitOffsetClauses455;
    static $FOLLOW_offsetClause_in_limitOffsetClauses457;
    static $FOLLOW_offsetClause_in_limitOffsetClauses464;
    static $FOLLOW_limitClause_in_limitOffsetClauses466;
    static $FOLLOW_ORDER_in_orderClause485;
    static $FOLLOW_BY_in_orderClause487;
    static $FOLLOW_orderCondition_in_orderClause489;
    static $FOLLOW_set_in_orderCondition514;
    static $FOLLOW_brackettedExpression_in_orderCondition544;
    static $FOLLOW_constraint_in_orderCondition562;
    static $FOLLOW_variable_in_orderCondition570;
    static $FOLLOW_LIMIT_in_limitClause592;
    static $FOLLOW_INTEGER_in_limitClause594;
    static $FOLLOW_OFFSET_in_offsetClause612;
    static $FOLLOW_INTEGER_in_offsetClause614;
    static $FOLLOW_triplesSameSubject_in_triplesBlock637;
    static $FOLLOW_DOT_in_triplesBlock640;
    static $FOLLOW_triplesBlock_in_triplesBlock642;
    static $FOLLOW_optionalGraphPattern_in_graphPatternNotTriples663;
    static $FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples669;
    static $FOLLOW_graphGraphPattern_in_graphPatternNotTriples675;
    static $FOLLOW_OPTIONAL_in_optionalGraphPattern693;
    static $FOLLOW_groupGraphPattern_in_optionalGraphPattern695;
    static $FOLLOW_GRAPH_in_graphGraphPattern713;
    static $FOLLOW_varOrIRIref_in_graphGraphPattern715;
    static $FOLLOW_groupGraphPattern_in_graphGraphPattern717;
    static $FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern735;
    static $FOLLOW_UNION_in_groupOrUnionGraphPattern738;
    static $FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern740;
    static $FOLLOW_FILTER_in_filter760;
    static $FOLLOW_constraint_in_filter762;
    static $FOLLOW_brackettedExpression_in_constraint780;
    static $FOLLOW_builtInCall_in_constraint786;
    static $FOLLOW_functionCall_in_constraint792;
    static $FOLLOW_iriRef_in_functionCall810;
    static $FOLLOW_argList_in_functionCall812;
    static $FOLLOW_OPEN_BRACE_in_argList830;
    static $FOLLOW_WS_in_argList832;
    static $FOLLOW_CLOSE_BRACE_in_argList835;
    static $FOLLOW_OPEN_BRACE_in_argList841;
    static $FOLLOW_expression_in_argList843;
    static $FOLLOW_COMMA_in_argList846;
    static $FOLLOW_expression_in_argList848;
    static $FOLLOW_CLOSE_BRACE_in_argList852;
    static $FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate870;
    static $FOLLOW_constructTriples_in_constructTemplate872;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate875;
    static $FOLLOW_triplesSameSubject_in_constructTriples893;
    static $FOLLOW_DOT_in_constructTriples896;
    static $FOLLOW_constructTriples_in_constructTriples898;
    static $FOLLOW_varOrTerm_in_triplesSameSubject919;
    static $FOLLOW_propertyListNotEmpty_in_triplesSameSubject921;
    static $FOLLOW_triplesNode_in_triplesSameSubject927;
    static $FOLLOW_propertyList_in_triplesSameSubject929;
    static $FOLLOW_verb_in_propertyListNotEmpty947;
    static $FOLLOW_objectList_in_propertyListNotEmpty949;
    static $FOLLOW_SEMICOLON_in_propertyListNotEmpty952;
    static $FOLLOW_verb_in_propertyListNotEmpty955;
    static $FOLLOW_objectList_in_propertyListNotEmpty957;
    static $FOLLOW_propertyListNotEmpty_in_propertyList979;
    static $FOLLOW_object_in_objectList998;
    static $FOLLOW_COMMA_in_objectList1001;
    static $FOLLOW_object_in_objectList1003;
    static $FOLLOW_graphNode_in_object1023;
    static $FOLLOW_varOrIRIref_in_verb1041;
    static $FOLLOW_A_in_verb1047;
    static $FOLLOW_collection_in_triplesNode1065;
    static $FOLLOW_blankNodePropertyList_in_triplesNode1071;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1089;
    static $FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1091;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1093;
    static $FOLLOW_OPEN_BRACE_in_collection1111;
    static $FOLLOW_graphNode_in_collection1113;
    static $FOLLOW_CLOSE_BRACE_in_collection1116;
    static $FOLLOW_varOrTerm_in_graphNode1134;
    static $FOLLOW_triplesNode_in_graphNode1140;
    static $FOLLOW_variable_in_varOrTerm1158;
    static $FOLLOW_graphTerm_in_varOrTerm1164;
    static $FOLLOW_variable_in_varOrIRIref1182;
    static $FOLLOW_iriRef_in_varOrIRIref1188;
    static $FOLLOW_set_in_variable0;
    static $FOLLOW_iriRef_in_graphTerm1230;
    static $FOLLOW_rdfLiteral_in_graphTerm1236;
    static $FOLLOW_numericLiteral_in_graphTerm1242;
    static $FOLLOW_booleanLiteral_in_graphTerm1248;
    static $FOLLOW_blankNode_in_graphTerm1254;
    static $FOLLOW_OPEN_BRACE_in_graphTerm1260;
    static $FOLLOW_WS_in_graphTerm1262;
    static $FOLLOW_CLOSE_BRACE_in_graphTerm1265;
    static $FOLLOW_conditionalOrExpression_in_expression1283;
    static $FOLLOW_conditionalAndExpression_in_conditionalOrExpression1301;
    static $FOLLOW_OR_in_conditionalOrExpression1304;
    static $FOLLOW_conditionalAndExpression_in_conditionalOrExpression1306;
    static $FOLLOW_valueLogical_in_conditionalAndExpression1326;
    static $FOLLOW_AND_in_conditionalAndExpression1329;
    static $FOLLOW_valueLogical_in_conditionalAndExpression1331;
    static $FOLLOW_relationalExpression_in_valueLogical1351;
    static $FOLLOW_numericExpression_in_relationalExpression1369;
    static $FOLLOW_EQUAL_in_relationalExpression1379;
    static $FOLLOW_numericExpression_in_relationalExpression1381;
    static $FOLLOW_NOT_EQUAL_in_relationalExpression1389;
    static $FOLLOW_numericExpression_in_relationalExpression1391;
    static $FOLLOW_LESS_in_relationalExpression1399;
    static $FOLLOW_numericExpression_in_relationalExpression1401;
    static $FOLLOW_GREATER_in_relationalExpression1409;
    static $FOLLOW_numericExpression_in_relationalExpression1411;
    static $FOLLOW_LESS_EQUAL_in_relationalExpression1419;
    static $FOLLOW_numericExpression_in_relationalExpression1421;
    static $FOLLOW_GREATER_EQUAL_in_relationalExpression1429;
    static $FOLLOW_numericExpression_in_relationalExpression1431;
    static $FOLLOW_additiveExpression_in_numericExpression1454;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1472;
    static $FOLLOW_PLUS_in_additiveExpression1482;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1484;
    static $FOLLOW_MINUS_in_additiveExpression1492;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1494;
    static $FOLLOW_numericLiteralPositive_in_additiveExpression1502;
    static $FOLLOW_numericLiteralNegative_in_additiveExpression1510;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1533;
    static $FOLLOW_ASTERISK_in_multiplicativeExpression1543;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1545;
    static $FOLLOW_DIVIDE_in_multiplicativeExpression1553;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1555;
    static $FOLLOW_NOT_SIGN_in_unaryExpression1578;
    static $FOLLOW_primaryExpression_in_unaryExpression1580;
    static $FOLLOW_PLUS_in_unaryExpression1586;
    static $FOLLOW_primaryExpression_in_unaryExpression1588;
    static $FOLLOW_MINUS_in_unaryExpression1594;
    static $FOLLOW_primaryExpression_in_unaryExpression1596;
    static $FOLLOW_primaryExpression_in_unaryExpression1602;
    static $FOLLOW_brackettedExpression_in_primaryExpression1620;
    static $FOLLOW_builtInCall_in_primaryExpression1626;
    static $FOLLOW_iriRefOrFunction_in_primaryExpression1632;
    static $FOLLOW_rdfLiteral_in_primaryExpression1638;
    static $FOLLOW_numericLiteral_in_primaryExpression1644;
    static $FOLLOW_booleanLiteral_in_primaryExpression1650;
    static $FOLLOW_variable_in_primaryExpression1656;
    static $FOLLOW_OPEN_BRACE_in_brackettedExpression1674;
    static $FOLLOW_expression_in_brackettedExpression1676;
    static $FOLLOW_CLOSE_BRACE_in_brackettedExpression1678;
    static $FOLLOW_STR_in_builtInCall1713;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1715;
    static $FOLLOW_expression_in_builtInCall1717;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1719;
    static $FOLLOW_LANG_in_builtInCall1725;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1727;
    static $FOLLOW_expression_in_builtInCall1729;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1731;
    static $FOLLOW_LANGMATCHES_in_builtInCall1737;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1739;
    static $FOLLOW_expression_in_builtInCall1741;
    static $FOLLOW_COMMA_in_builtInCall1743;
    static $FOLLOW_expression_in_builtInCall1745;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1747;
    static $FOLLOW_DATATYPE_in_builtInCall1753;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1755;
    static $FOLLOW_expression_in_builtInCall1757;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1759;
    static $FOLLOW_BOUND_in_builtInCall1765;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1767;
    static $FOLLOW_variable_in_builtInCall1769;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1771;
    static $FOLLOW_COALESCE_in_builtInCall1777;
    static $FOLLOW_argList_in_builtInCall1779;
    static $FOLLOW_IF_in_builtInCall1785;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1787;
    static $FOLLOW_expression_in_builtInCall1789;
    static $FOLLOW_COMMA_in_builtInCall1791;
    static $FOLLOW_expression_in_builtInCall1793;
    static $FOLLOW_COMMA_in_builtInCall1795;
    static $FOLLOW_expression_in_builtInCall1797;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1799;
    static $FOLLOW_SAMETERM_in_builtInCall1805;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1807;
    static $FOLLOW_expression_in_builtInCall1809;
    static $FOLLOW_COMMA_in_builtInCall1811;
    static $FOLLOW_expression_in_builtInCall1813;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1815;
    static $FOLLOW_ISIRI_in_builtInCall1821;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1823;
    static $FOLLOW_expression_in_builtInCall1825;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1827;
    static $FOLLOW_ISURI_in_builtInCall1833;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1835;
    static $FOLLOW_expression_in_builtInCall1837;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1839;
    static $FOLLOW_ISBLANK_in_builtInCall1845;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1847;
    static $FOLLOW_expression_in_builtInCall1849;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1851;
    static $FOLLOW_ISLITERAL_in_builtInCall1857;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1859;
    static $FOLLOW_expression_in_builtInCall1861;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1863;
    static $FOLLOW_regexExpression_in_builtInCall1869;
    static $FOLLOW_REGEX_in_regexExpression1889;
    static $FOLLOW_OPEN_BRACE_in_regexExpression1891;
    static $FOLLOW_expression_in_regexExpression1893;
    static $FOLLOW_COMMA_in_regexExpression1895;
    static $FOLLOW_expression_in_regexExpression1897;
    static $FOLLOW_COMMA_in_regexExpression1900;
    static $FOLLOW_expression_in_regexExpression1902;
    static $FOLLOW_CLOSE_BRACE_in_regexExpression1906;
    static $FOLLOW_iriRef_in_iriRefOrFunction1924;
    static $FOLLOW_argList_in_iriRefOrFunction1926;
    static $FOLLOW_string_in_rdfLiteral1945;
    static $FOLLOW_LANGTAG_in_rdfLiteral1955;
    static $FOLLOW_REFERENCE_in_rdfLiteral1964;
    static $FOLLOW_iriRef_in_rdfLiteral1966;
    static $FOLLOW_numericLiteralUnsigned_in_numericLiteral1990;
    static $FOLLOW_numericLiteralPositive_in_numericLiteral1996;
    static $FOLLOW_numericLiteralNegative_in_numericLiteral2002;
    static $FOLLOW_set_in_numericLiteralUnsigned0;
    static $FOLLOW_set_in_numericLiteralPositive0;
    static $FOLLOW_set_in_numericLiteralNegative0;
    static $FOLLOW_set_in_booleanLiteral0;
    static $FOLLOW_set_in_string0;
    static $FOLLOW_IRI_REF_in_iriRef2170;
    static $FOLLOW_prefixedName_in_iriRef2176;
    static $FOLLOW_set_in_prefixedName0;
    static $FOLLOW_BLANK_NODE_LABEL_in_blankNode2218;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2224;
    static $FOLLOW_WS_in_blankNode2227;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2231;
    static $FOLLOW_project_in_subSelect2248;
    static $FOLLOW_whereClause_in_subSelect2250;
    static $FOLLOW_solutionModifier_in_subSelect2252;
    static $FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern2269;
    static $FOLLOW_subSelect_in_groupGraphPattern2279;
    static $FOLLOW_groupGraphPatternSub_in_groupGraphPattern2287;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern2295;
    static $FOLLOW_triplesBlock_in_groupGraphPatternSub2313;
    static $FOLLOW_graphPatternNotTriples_in_groupGraphPatternSub2332;
    static $FOLLOW_filter_in_groupGraphPatternSub2342;
    static $FOLLOW_DOT_in_groupGraphPatternSub2354;
    static $FOLLOW_triplesBlock_in_groupGraphPatternSub2357;
    static $FOLLOW_SELECT_in_project2381;
    static $FOLLOW_set_in_project2385;
    static $FOLLOW_ASTERISK_in_project2414;
    static $FOLLOW_variable_in_project2434;
    static $FOLLOW_builtInCall_in_project2444;
    static $FOLLOW_functionCall_in_project2454;
    static $FOLLOW_OPEN_BRACE_in_project2465;
    static $FOLLOW_expression_in_project2467;
    static $FOLLOW_AS_in_project2470;
    static $FOLLOW_variable_in_project2472;
    static $FOLLOW_CLOSE_BRACE_in_project2476;

    
    

        public function __construct($input, $state, $gErfurt_Sparql_Parser_Sparql11_Query = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state, $gErfurt_Sparql_Parser_Sparql11_Query);
            $this->gErfurt_Sparql_Parser_Sparql11_Query = $gErfurt_Sparql_Parser_Sparql11_Query;
             
            $this->gParent = $this->gErfurt_Sparql_Parser_Sparql11_Query;
            
            
        }
        

    public function getTokenNames() { return Erfurt_Sparql_Parser_Sparql11_QueryParser::$tokenNames; }
    public function getGrammarFileName() { return "Sparql11query.g"; }



    // $ANTLR start "query11"
    // Sparql11query.g:8:1: query11 : prologue ( selectQuery | constructQuery | describeQuery | askQuery ) ; 
    public function query11(){
        try {
            // Sparql11query.g:9:3: ( prologue ( selectQuery | constructQuery | describeQuery | askQuery ) ) 
            // Sparql11query.g:10:3: prologue ( selectQuery | constructQuery | describeQuery | askQuery ) 
            {
            $this->pushFollow(self::$FOLLOW_prologue_in_query1122);
            $this->prologue();

            $this->state->_fsp--;

            // Sparql11query.g:11:3: ( selectQuery | constructQuery | describeQuery | askQuery ) 
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
                    // Sparql11query.g:12:5: selectQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_selectQuery_in_query1132);
                    $this->selectQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:13:7: constructQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_constructQuery_in_query1140);
                    $this->constructQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11query.g:14:7: describeQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_describeQuery_in_query1148);
                    $this->describeQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql11query.g:15:7: askQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_askQuery_in_query1156);
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
    // $ANTLR end "query11"


    // $ANTLR start "prologue"
    // Sparql11query.g:21:1: prologue : ( baseDecl )? ( prefixDecl )* ; 
    public function prologue(){
        try {
            // Sparql11query.g:22:3: ( ( baseDecl )? ( prefixDecl )* ) 
            // Sparql11query.g:23:3: ( baseDecl )? ( prefixDecl )* 
            {
            // Sparql11query.g:23:3: ( baseDecl )? 
            $alt2=2;
            $LA2_0 = $this->input->LA(1);

            if ( ($LA2_0==$this->getToken('BASE')) ) {
                $alt2=1;
            }
            switch ($alt2) {
                case 1 :
                    // Sparql11query.g:23:3: baseDecl 
                    {
                    $this->pushFollow(self::$FOLLOW_baseDecl_in_prologue78);
                    $this->baseDecl();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Sparql11query.g:23:13: ( prefixDecl )* 
            //loop3:
            do {
                $alt3=2;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('PREFIX')) ) {
                    $alt3=1;
                }


                switch ($alt3) {
            	case 1 :
            	    // Sparql11query.g:23:13: prefixDecl 
            	    {
            	    $this->pushFollow(self::$FOLLOW_prefixDecl_in_prologue81);
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
    // Sparql11query.g:28:1: baseDecl : BASE iriRef ; 
    public function baseDecl(){
        try {
            // Sparql11query.g:29:3: ( BASE iriRef ) 
            // Sparql11query.g:30:3: BASE iriRef 
            {
            $this->match($this->input,$this->getToken('BASE'),self::$FOLLOW_BASE_in_baseDecl100); 
            $this->pushFollow(self::$FOLLOW_iriRef_in_baseDecl102);
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
    // Sparql11query.g:35:1: prefixDecl : PREFIX PNAME_NS iriRef ; 
    public function prefixDecl(){
        try {
            // Sparql11query.g:36:3: ( PREFIX PNAME_NS iriRef ) 
            // Sparql11query.g:37:3: PREFIX PNAME_NS iriRef 
            {
            $this->match($this->input,$this->getToken('PREFIX'),self::$FOLLOW_PREFIX_in_prefixDecl120); 
            $this->match($this->input,$this->getToken('PNAME_NS'),self::$FOLLOW_PNAME_NS_in_prefixDecl122); 
            $this->pushFollow(self::$FOLLOW_iriRef_in_prefixDecl124);
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
    // Sparql11query.g:42:1: selectQuery : SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier ; 
    public function selectQuery(){
        try {
            // Sparql11query.g:43:3: ( SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier ) 
            // Sparql11query.g:44:3: SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier 
            {
            $this->match($this->input,$this->getToken('SELECT'),self::$FOLLOW_SELECT_in_selectQuery142); 
            // Sparql11query.g:45:3: ( DISTINCT | REDUCED )? 
            $alt4=2;
            $LA4_0 = $this->input->LA(1);

            if ( (($LA4_0>=$this->getToken('DISTINCT') && $LA4_0<=$this->getToken('REDUCED'))) ) {
                $alt4=1;
            }
            switch ($alt4) {
                case 1 :
                    // Sparql11query.g: 
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

            // Sparql11query.g:49:3: ( ( variable )+ | ASTERISK ) 
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
                    // Sparql11query.g:50:5: ( variable )+ 
                    {
                    // Sparql11query.g:50:5: ( variable )+ 
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
                    	    // Sparql11query.g:50:5: variable 
                    	    {
                    	    $this->pushFollow(self::$FOLLOW_variable_in_selectQuery175);
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
                    // Sparql11query.g:51:7: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_selectQuery184); 

                    }
                    break;

            }

            // Sparql11query.g:53:3: ( datasetClause )* 
            //loop7:
            do {
                $alt7=2;
                $LA7_0 = $this->input->LA(1);

                if ( ($LA7_0==$this->getToken('FROM')) ) {
                    $alt7=1;
                }


                switch ($alt7) {
            	case 1 :
            	    // Sparql11query.g:53:3: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_selectQuery192);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop7;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_selectQuery195);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_selectQuery197);
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
    // Sparql11query.g:58:1: constructQuery : CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier ; 
    public function constructQuery(){
        try {
            // Sparql11query.g:59:3: ( CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier ) 
            // Sparql11query.g:60:3: CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier 
            {
            $this->match($this->input,$this->getToken('CONSTRUCT'),self::$FOLLOW_CONSTRUCT_in_constructQuery215); 
            $this->pushFollow(self::$FOLLOW_constructTemplate_in_constructQuery217);
            $this->constructTemplate();

            $this->state->_fsp--;

            // Sparql11query.g:60:31: ( datasetClause )* 
            //loop8:
            do {
                $alt8=2;
                $LA8_0 = $this->input->LA(1);

                if ( ($LA8_0==$this->getToken('FROM')) ) {
                    $alt8=1;
                }


                switch ($alt8) {
            	case 1 :
            	    // Sparql11query.g:60:31: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_constructQuery219);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop8;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_constructQuery222);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_constructQuery224);
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
    // Sparql11query.g:65:1: describeQuery : DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier ; 
    public function describeQuery(){
        try {
            // Sparql11query.g:66:3: ( DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier ) 
            // Sparql11query.g:67:3: DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier 
            {
            $this->match($this->input,$this->getToken('DESCRIBE'),self::$FOLLOW_DESCRIBE_in_describeQuery242); 
            // Sparql11query.g:68:3: ( ( varOrIRIref )+ | ASTERISK ) 
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
                    // Sparql11query.g:69:5: ( varOrIRIref )+ 
                    {
                    // Sparql11query.g:69:5: ( varOrIRIref )+ 
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
                    	    // Sparql11query.g:69:5: varOrIRIref 
                    	    {
                    	    $this->pushFollow(self::$FOLLOW_varOrIRIref_in_describeQuery252);
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
                    // Sparql11query.g:70:7: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_describeQuery261); 

                    }
                    break;

            }

            // Sparql11query.g:72:3: ( datasetClause )* 
            //loop11:
            do {
                $alt11=2;
                $LA11_0 = $this->input->LA(1);

                if ( ($LA11_0==$this->getToken('FROM')) ) {
                    $alt11=1;
                }


                switch ($alt11) {
            	case 1 :
            	    // Sparql11query.g:72:3: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_describeQuery269);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop11;
                }
            } while (true);

            // Sparql11query.g:72:18: ( whereClause )? 
            $alt12=2;
            $LA12_0 = $this->input->LA(1);

            if ( ($LA12_0==$this->getToken('WHERE')||$LA12_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                $alt12=1;
            }
            switch ($alt12) {
                case 1 :
                    // Sparql11query.g:72:18: whereClause 
                    {
                    $this->pushFollow(self::$FOLLOW_whereClause_in_describeQuery272);
                    $this->whereClause();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_describeQuery275);
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
    // Sparql11query.g:77:1: askQuery : ASK ( datasetClause )* whereClause ; 
    public function askQuery(){
        try {
            // Sparql11query.g:78:3: ( ASK ( datasetClause )* whereClause ) 
            // Sparql11query.g:79:3: ASK ( datasetClause )* whereClause 
            {
            $this->match($this->input,$this->getToken('ASK'),self::$FOLLOW_ASK_in_askQuery293); 
            // Sparql11query.g:79:7: ( datasetClause )* 
            //loop13:
            do {
                $alt13=2;
                $LA13_0 = $this->input->LA(1);

                if ( ($LA13_0==$this->getToken('FROM')) ) {
                    $alt13=1;
                }


                switch ($alt13) {
            	case 1 :
            	    // Sparql11query.g:79:7: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_askQuery295);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop13;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_askQuery298);
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
    // Sparql11query.g:84:1: datasetClause : FROM ( defaultGraphClause | namedGraphClause ) ; 
    public function datasetClause(){
        try {
            // Sparql11query.g:85:3: ( FROM ( defaultGraphClause | namedGraphClause ) ) 
            // Sparql11query.g:86:3: FROM ( defaultGraphClause | namedGraphClause ) 
            {
            $this->match($this->input,$this->getToken('FROM'),self::$FOLLOW_FROM_in_datasetClause316); 
            // Sparql11query.g:87:3: ( defaultGraphClause | namedGraphClause ) 
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
                    // Sparql11query.g:88:5: defaultGraphClause 
                    {
                    $this->pushFollow(self::$FOLLOW_defaultGraphClause_in_datasetClause326);
                    $this->defaultGraphClause();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:89:7: namedGraphClause 
                    {
                    $this->pushFollow(self::$FOLLOW_namedGraphClause_in_datasetClause334);
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
    // Sparql11query.g:95:1: defaultGraphClause : sourceSelector ; 
    public function defaultGraphClause(){
        try {
            // Sparql11query.g:96:3: ( sourceSelector ) 
            // Sparql11query.g:97:3: sourceSelector 
            {
            $this->pushFollow(self::$FOLLOW_sourceSelector_in_defaultGraphClause356);
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
    // Sparql11query.g:102:1: namedGraphClause : NAMED sourceSelector ; 
    public function namedGraphClause(){
        try {
            // Sparql11query.g:103:3: ( NAMED sourceSelector ) 
            // Sparql11query.g:104:3: NAMED sourceSelector 
            {
            $this->match($this->input,$this->getToken('NAMED'),self::$FOLLOW_NAMED_in_namedGraphClause374); 
            $this->pushFollow(self::$FOLLOW_sourceSelector_in_namedGraphClause376);
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
    // Sparql11query.g:109:1: sourceSelector : iriRef ; 
    public function sourceSelector(){
        try {
            // Sparql11query.g:110:3: ( iriRef ) 
            // Sparql11query.g:111:3: iriRef 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_sourceSelector394);
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
    // Sparql11query.g:116:1: whereClause : ( WHERE )? groupGraphPattern ; 
    public function whereClause(){
        try {
            // Sparql11query.g:117:3: ( ( WHERE )? groupGraphPattern ) 
            // Sparql11query.g:118:3: ( WHERE )? groupGraphPattern 
            {
            // Sparql11query.g:118:3: ( WHERE )? 
            $alt15=2;
            $LA15_0 = $this->input->LA(1);

            if ( ($LA15_0==$this->getToken('WHERE')) ) {
                $alt15=1;
            }
            switch ($alt15) {
                case 1 :
                    // Sparql11query.g:118:3: WHERE 
                    {
                    $this->match($this->input,$this->getToken('WHERE'),self::$FOLLOW_WHERE_in_whereClause412); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_whereClause415);
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
    // Sparql11query.g:123:1: solutionModifier : ( orderClause )? ( limitOffsetClauses )? ; 
    public function solutionModifier(){
        try {
            // Sparql11query.g:124:3: ( ( orderClause )? ( limitOffsetClauses )? ) 
            // Sparql11query.g:125:3: ( orderClause )? ( limitOffsetClauses )? 
            {
            // Sparql11query.g:125:3: ( orderClause )? 
            $alt16=2;
            $LA16_0 = $this->input->LA(1);

            if ( ($LA16_0==$this->getToken('ORDER')) ) {
                $alt16=1;
            }
            switch ($alt16) {
                case 1 :
                    // Sparql11query.g:125:3: orderClause 
                    {
                    $this->pushFollow(self::$FOLLOW_orderClause_in_solutionModifier433);
                    $this->orderClause();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Sparql11query.g:125:16: ( limitOffsetClauses )? 
            $alt17=2;
            $LA17_0 = $this->input->LA(1);

            if ( (($LA17_0>=$this->getToken('LIMIT') && $LA17_0<=$this->getToken('OFFSET'))) ) {
                $alt17=1;
            }
            switch ($alt17) {
                case 1 :
                    // Sparql11query.g:125:16: limitOffsetClauses 
                    {
                    $this->pushFollow(self::$FOLLOW_limitOffsetClauses_in_solutionModifier436);
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
    // Sparql11query.g:130:1: limitOffsetClauses : ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ); 
    public function limitOffsetClauses(){
        try {
            // Sparql11query.g:131:3: ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ) 
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
                    // Sparql11query.g:132:3: limitClause ( offsetClause )? 
                    {
                    $this->pushFollow(self::$FOLLOW_limitClause_in_limitOffsetClauses455);
                    $this->limitClause();

                    $this->state->_fsp--;

                    // Sparql11query.g:132:15: ( offsetClause )? 
                    $alt18=2;
                    $LA18_0 = $this->input->LA(1);

                    if ( ($LA18_0==$this->getToken('OFFSET')) ) {
                        $alt18=1;
                    }
                    switch ($alt18) {
                        case 1 :
                            // Sparql11query.g:132:15: offsetClause 
                            {
                            $this->pushFollow(self::$FOLLOW_offsetClause_in_limitOffsetClauses457);
                            $this->offsetClause();

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // Sparql11query.g:133:5: offsetClause ( limitClause )? 
                    {
                    $this->pushFollow(self::$FOLLOW_offsetClause_in_limitOffsetClauses464);
                    $this->offsetClause();

                    $this->state->_fsp--;

                    // Sparql11query.g:133:18: ( limitClause )? 
                    $alt19=2;
                    $LA19_0 = $this->input->LA(1);

                    if ( ($LA19_0==$this->getToken('LIMIT')) ) {
                        $alt19=1;
                    }
                    switch ($alt19) {
                        case 1 :
                            // Sparql11query.g:133:18: limitClause 
                            {
                            $this->pushFollow(self::$FOLLOW_limitClause_in_limitOffsetClauses466);
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
    // Sparql11query.g:138:1: orderClause : ORDER BY ( orderCondition )+ ; 
    public function orderClause(){
        try {
            // Sparql11query.g:139:3: ( ORDER BY ( orderCondition )+ ) 
            // Sparql11query.g:140:3: ORDER BY ( orderCondition )+ 
            {
            $this->match($this->input,$this->getToken('ORDER'),self::$FOLLOW_ORDER_in_orderClause485); 
            $this->match($this->input,$this->getToken('BY'),self::$FOLLOW_BY_in_orderClause487); 
            // Sparql11query.g:140:12: ( orderCondition )+ 
            $cnt21=0;
            //loop21:
            do {
                $alt21=2;
                $LA21_0 = $this->input->LA(1);

                if ( ($LA21_0==$this->getToken('COALESCE')||$LA21_0==$this->getToken('IF')||($LA21_0>=$this->getToken('ASC') && $LA21_0<=$this->getToken('DESC'))||($LA21_0>=$this->getToken('STR') && $LA21_0<=$this->getToken('REGEX'))||$LA21_0==$this->getToken('IRI_REF')||$LA21_0==$this->getToken('PNAME_NS')||$LA21_0==$this->getToken('PNAME_LN')||($LA21_0>=$this->getToken('VAR1') && $LA21_0<=$this->getToken('VAR2'))||$LA21_0==$this->getToken('OPEN_BRACE')) ) {
                    $alt21=1;
                }


                switch ($alt21) {
            	case 1 :
            	    // Sparql11query.g:140:12: orderCondition 
            	    {
            	    $this->pushFollow(self::$FOLLOW_orderCondition_in_orderClause489);
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
    // Sparql11query.g:145:1: orderCondition : ( ( ( ASC | DESC ) brackettedExpression ) | ( constraint | variable ) ); 
    public function orderCondition(){
        try {
            // Sparql11query.g:146:3: ( ( ( ASC | DESC ) brackettedExpression ) | ( constraint | variable ) ) 
            $alt23=2;
            $LA23_0 = $this->input->LA(1);

            if ( (($LA23_0>=$this->getToken('ASC') && $LA23_0<=$this->getToken('DESC'))) ) {
                $alt23=1;
            }
            else if ( ($LA23_0==$this->getToken('COALESCE')||$LA23_0==$this->getToken('IF')||($LA23_0>=$this->getToken('STR') && $LA23_0<=$this->getToken('REGEX'))||$LA23_0==$this->getToken('IRI_REF')||$LA23_0==$this->getToken('PNAME_NS')||$LA23_0==$this->getToken('PNAME_LN')||($LA23_0>=$this->getToken('VAR1') && $LA23_0<=$this->getToken('VAR2'))||$LA23_0==$this->getToken('OPEN_BRACE')) ) {
                $alt23=2;
            }
            else {
                $nvae = new NoViableAltException("", 23, 0, $this->input);

                throw $nvae;
            }
            switch ($alt23) {
                case 1 :
                    // Sparql11query.g:147:3: ( ( ASC | DESC ) brackettedExpression ) 
                    {
                    // Sparql11query.g:147:3: ( ( ASC | DESC ) brackettedExpression ) 
                    // Sparql11query.g:148:5: ( ASC | DESC ) brackettedExpression 
                    {
                    if ( ($this->input->LA(1)>=$this->getToken('ASC') && $this->input->LA(1)<=$this->getToken('DESC')) ) {
                        $this->input->consume();
                        $this->state->errorRecovery=false;
                    }
                    else {
                        $mse = new MismatchedSetException(null,$this->input);
                        throw $mse;
                    }

                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_orderCondition544);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }


                    }
                    break;
                case 2 :
                    // Sparql11query.g:155:3: ( constraint | variable ) 
                    {
                    // Sparql11query.g:155:3: ( constraint | variable ) 
                    $alt22=2;
                    $LA22_0 = $this->input->LA(1);

                    if ( ($LA22_0==$this->getToken('COALESCE')||$LA22_0==$this->getToken('IF')||($LA22_0>=$this->getToken('STR') && $LA22_0<=$this->getToken('REGEX'))||$LA22_0==$this->getToken('IRI_REF')||$LA22_0==$this->getToken('PNAME_NS')||$LA22_0==$this->getToken('PNAME_LN')||$LA22_0==$this->getToken('OPEN_BRACE')) ) {
                        $alt22=1;
                    }
                    else if ( (($LA22_0>=$this->getToken('VAR1') && $LA22_0<=$this->getToken('VAR2'))) ) {
                        $alt22=2;
                    }
                    else {
                        $nvae = new NoViableAltException("", 22, 0, $this->input);

                        throw $nvae;
                    }
                    switch ($alt22) {
                        case 1 :
                            // Sparql11query.g:156:5: constraint 
                            {
                            $this->pushFollow(self::$FOLLOW_constraint_in_orderCondition562);
                            $this->constraint();

                            $this->state->_fsp--;


                            }
                            break;
                        case 2 :
                            // Sparql11query.g:157:7: variable 
                            {
                            $this->pushFollow(self::$FOLLOW_variable_in_orderCondition570);
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
    // Sparql11query.g:163:1: limitClause : LIMIT INTEGER ; 
    public function limitClause(){
        try {
            // Sparql11query.g:164:3: ( LIMIT INTEGER ) 
            // Sparql11query.g:165:3: LIMIT INTEGER 
            {
            $this->match($this->input,$this->getToken('LIMIT'),self::$FOLLOW_LIMIT_in_limitClause592); 
            $this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_limitClause594); 

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
    // Sparql11query.g:170:1: offsetClause : OFFSET INTEGER ; 
    public function offsetClause(){
        try {
            // Sparql11query.g:171:3: ( OFFSET INTEGER ) 
            // Sparql11query.g:172:3: OFFSET INTEGER 
            {
            $this->match($this->input,$this->getToken('OFFSET'),self::$FOLLOW_OFFSET_in_offsetClause612); 
            $this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_offsetClause614); 

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


    // $ANTLR start "triplesBlock"
    // Sparql11query.g:182:1: triplesBlock : triplesSameSubject ( DOT ( triplesBlock )? )? ; 
    public function triplesBlock(){
        try {
            // Sparql11query.g:183:3: ( triplesSameSubject ( DOT ( triplesBlock )? )? ) 
            // Sparql11query.g:184:3: triplesSameSubject ( DOT ( triplesBlock )? )? 
            {
            $this->pushFollow(self::$FOLLOW_triplesSameSubject_in_triplesBlock637);
            $this->triplesSameSubject();

            $this->state->_fsp--;

            // Sparql11query.g:184:22: ( DOT ( triplesBlock )? )? 
            $alt25=2;
            $LA25_0 = $this->input->LA(1);

            if ( ($LA25_0==$this->getToken('DOT')) ) {
                $alt25=1;
            }
            switch ($alt25) {
                case 1 :
                    // Sparql11query.g:184:23: DOT ( triplesBlock )? 
                    {
                    $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_triplesBlock640); 
                    // Sparql11query.g:184:27: ( triplesBlock )? 
                    $alt24=2;
                    $LA24_0 = $this->input->LA(1);

                    if ( (($LA24_0>=$this->getToken('TRUE') && $LA24_0<=$this->getToken('FALSE'))||$LA24_0==$this->getToken('IRI_REF')||$LA24_0==$this->getToken('PNAME_NS')||$LA24_0==$this->getToken('PNAME_LN')||($LA24_0>=$this->getToken('VAR1') && $LA24_0<=$this->getToken('VAR2'))||$LA24_0==$this->getToken('INTEGER')||$LA24_0==$this->getToken('DECIMAL')||$LA24_0==$this->getToken('DOUBLE')||($LA24_0>=$this->getToken('INTEGER_POSITIVE') && $LA24_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA24_0>=$this->getToken('STRING_LITERAL1') && $LA24_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA24_0==$this->getToken('BLANK_NODE_LABEL')||$LA24_0==$this->getToken('OPEN_BRACE')||$LA24_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                        $alt24=1;
                    }
                    switch ($alt24) {
                        case 1 :
                            // Sparql11query.g:184:27: triplesBlock 
                            {
                            $this->pushFollow(self::$FOLLOW_triplesBlock_in_triplesBlock642);
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
    // Sparql11query.g:189:1: graphPatternNotTriples : ( optionalGraphPattern | groupOrUnionGraphPattern | graphGraphPattern ); 
    public function graphPatternNotTriples(){
        try {
            // Sparql11query.g:190:3: ( optionalGraphPattern | groupOrUnionGraphPattern | graphGraphPattern ) 
            $alt26=3;
            $LA26 = $this->input->LA(1);
            if($this->getToken('OPTIONAL')== $LA26)
                {
                $alt26=1;
                }
            else if($this->getToken('OPEN_CURLY_BRACE')== $LA26)
                {
                $alt26=2;
                }
            else if($this->getToken('GRAPH')== $LA26)
                {
                $alt26=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 26, 0, $this->input);

                throw $nvae;
            }

            switch ($alt26) {
                case 1 :
                    // Sparql11query.g:191:3: optionalGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_optionalGraphPattern_in_graphPatternNotTriples663);
                    $this->optionalGraphPattern();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:192:5: groupOrUnionGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples669);
                    $this->groupOrUnionGraphPattern();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11query.g:193:5: graphGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_graphGraphPattern_in_graphPatternNotTriples675);
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
    // Sparql11query.g:198:1: optionalGraphPattern : OPTIONAL groupGraphPattern ; 
    public function optionalGraphPattern(){
        try {
            // Sparql11query.g:199:3: ( OPTIONAL groupGraphPattern ) 
            // Sparql11query.g:200:3: OPTIONAL groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('OPTIONAL'),self::$FOLLOW_OPTIONAL_in_optionalGraphPattern693); 
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_optionalGraphPattern695);
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
    // Sparql11query.g:205:1: graphGraphPattern : GRAPH varOrIRIref groupGraphPattern ; 
    public function graphGraphPattern(){
        try {
            // Sparql11query.g:206:3: ( GRAPH varOrIRIref groupGraphPattern ) 
            // Sparql11query.g:207:3: GRAPH varOrIRIref groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('GRAPH'),self::$FOLLOW_GRAPH_in_graphGraphPattern713); 
            $this->pushFollow(self::$FOLLOW_varOrIRIref_in_graphGraphPattern715);
            $this->varOrIRIref();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_graphGraphPattern717);
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
    // Sparql11query.g:212:1: groupOrUnionGraphPattern : groupGraphPattern ( UNION groupGraphPattern )* ; 
    public function groupOrUnionGraphPattern(){
        try {
            // Sparql11query.g:213:3: ( groupGraphPattern ( UNION groupGraphPattern )* ) 
            // Sparql11query.g:214:3: groupGraphPattern ( UNION groupGraphPattern )* 
            {
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern735);
            $this->groupGraphPattern();

            $this->state->_fsp--;

            // Sparql11query.g:214:21: ( UNION groupGraphPattern )* 
            //loop27:
            do {
                $alt27=2;
                $LA27_0 = $this->input->LA(1);

                if ( ($LA27_0==$this->getToken('UNION')) ) {
                    $alt27=1;
                }


                switch ($alt27) {
            	case 1 :
            	    // Sparql11query.g:214:22: UNION groupGraphPattern 
            	    {
            	    $this->match($this->input,$this->getToken('UNION'),self::$FOLLOW_UNION_in_groupOrUnionGraphPattern738); 
            	    $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern740);
            	    $this->groupGraphPattern();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop27;
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
    // Sparql11query.g:219:1: filter : FILTER constraint ; 
    public function filter(){
        try {
            // Sparql11query.g:220:3: ( FILTER constraint ) 
            // Sparql11query.g:221:3: FILTER constraint 
            {
            $this->match($this->input,$this->getToken('FILTER'),self::$FOLLOW_FILTER_in_filter760); 
            $this->pushFollow(self::$FOLLOW_constraint_in_filter762);
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
    // Sparql11query.g:226:1: constraint : ( brackettedExpression | builtInCall | functionCall ); 
    public function constraint(){
        try {
            // Sparql11query.g:227:3: ( brackettedExpression | builtInCall | functionCall ) 
            $alt28=3;
            $LA28 = $this->input->LA(1);
            if($this->getToken('OPEN_BRACE')== $LA28)
                {
                $alt28=1;
                }
            else if($this->getToken('COALESCE')== $LA28||$this->getToken('IF')== $LA28||$this->getToken('STR')== $LA28||$this->getToken('LANG')== $LA28||$this->getToken('LANGMATCHES')== $LA28||$this->getToken('DATATYPE')== $LA28||$this->getToken('BOUND')== $LA28||$this->getToken('SAMETERM')== $LA28||$this->getToken('ISIRI')== $LA28||$this->getToken('ISURI')== $LA28||$this->getToken('ISBLANK')== $LA28||$this->getToken('ISLITERAL')== $LA28||$this->getToken('REGEX')== $LA28)
                {
                $alt28=2;
                }
            else if($this->getToken('IRI_REF')== $LA28||$this->getToken('PNAME_NS')== $LA28||$this->getToken('PNAME_LN')== $LA28)
                {
                $alt28=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 28, 0, $this->input);

                throw $nvae;
            }

            switch ($alt28) {
                case 1 :
                    // Sparql11query.g:228:3: brackettedExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_constraint780);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:229:5: builtInCall 
                    {
                    $this->pushFollow(self::$FOLLOW_builtInCall_in_constraint786);
                    $this->builtInCall();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11query.g:230:5: functionCall 
                    {
                    $this->pushFollow(self::$FOLLOW_functionCall_in_constraint792);
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
    // Sparql11query.g:235:1: functionCall : iriRef argList ; 
    public function functionCall(){
        try {
            // Sparql11query.g:236:3: ( iriRef argList ) 
            // Sparql11query.g:237:3: iriRef argList 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_functionCall810);
            $this->iriRef();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_argList_in_functionCall812);
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
    // Sparql11query.g:242:1: argList : ( OPEN_BRACE ( WS )* CLOSE_BRACE | OPEN_BRACE expression ( COMMA expression )* CLOSE_BRACE ); 
    public function argList(){
        try {
            // Sparql11query.g:243:3: ( OPEN_BRACE ( WS )* CLOSE_BRACE | OPEN_BRACE expression ( COMMA expression )* CLOSE_BRACE ) 
            $alt31=2;
            $LA31_0 = $this->input->LA(1);

            if ( ($LA31_0==$this->getToken('OPEN_BRACE')) ) {
                $LA31_1 = $this->input->LA(2);

                if ( ($LA31_1==$this->getToken('COALESCE')||$LA31_1==$this->getToken('IF')||($LA31_1>=$this->getToken('STR') && $LA31_1<=$this->getToken('FALSE'))||$LA31_1==$this->getToken('IRI_REF')||$LA31_1==$this->getToken('PNAME_NS')||$LA31_1==$this->getToken('PNAME_LN')||($LA31_1>=$this->getToken('VAR1') && $LA31_1<=$this->getToken('MINUS'))||$LA31_1==$this->getToken('INTEGER')||$LA31_1==$this->getToken('DECIMAL')||($LA31_1>=$this->getToken('DOUBLE') && $LA31_1<=$this->getToken('DOUBLE_NEGATIVE'))||($LA31_1>=$this->getToken('STRING_LITERAL1') && $LA31_1<=$this->getToken('STRING_LITERAL_LONG2'))||$LA31_1==$this->getToken('NOT_SIGN')||$LA31_1==$this->getToken('OPEN_BRACE')) ) {
                    $alt31=2;
                }
                else if ( ($LA31_1==$this->getToken('WS')||$LA31_1==$this->getToken('CLOSE_BRACE')) ) {
                    $alt31=1;
                }
                else {
                    $nvae = new NoViableAltException("", 31, 1, $this->input);

                    throw $nvae;
                }
            }
            else {
                $nvae = new NoViableAltException("", 31, 0, $this->input);

                throw $nvae;
            }
            switch ($alt31) {
                case 1 :
                    // Sparql11query.g:244:3: OPEN_BRACE ( WS )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_argList830); 
                    // Sparql11query.g:244:14: ( WS )* 
                    //loop29:
                    do {
                        $alt29=2;
                        $LA29_0 = $this->input->LA(1);

                        if ( ($LA29_0==$this->getToken('WS')) ) {
                            $alt29=1;
                        }


                        switch ($alt29) {
                    	case 1 :
                    	    // Sparql11query.g:244:14: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_argList832); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop29;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_argList835); 

                    }
                    break;
                case 2 :
                    // Sparql11query.g:245:5: OPEN_BRACE expression ( COMMA expression )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_argList841); 
                    $this->pushFollow(self::$FOLLOW_expression_in_argList843);
                    $this->expression();

                    $this->state->_fsp--;

                    // Sparql11query.g:245:27: ( COMMA expression )* 
                    //loop30:
                    do {
                        $alt30=2;
                        $LA30_0 = $this->input->LA(1);

                        if ( ($LA30_0==$this->getToken('COMMA')) ) {
                            $alt30=1;
                        }


                        switch ($alt30) {
                    	case 1 :
                    	    // Sparql11query.g:245:28: COMMA expression 
                    	    {
                    	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_argList846); 
                    	    $this->pushFollow(self::$FOLLOW_expression_in_argList848);
                    	    $this->expression();

                    	    $this->state->_fsp--;


                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop30;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_argList852); 

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
    // Sparql11query.g:250:1: constructTemplate : OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ; 
    public function constructTemplate(){
        try {
            // Sparql11query.g:251:3: ( OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ) 
            // Sparql11query.g:252:3: OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate870); 
            // Sparql11query.g:252:20: ( constructTriples )? 
            $alt32=2;
            $LA32_0 = $this->input->LA(1);

            if ( (($LA32_0>=$this->getToken('TRUE') && $LA32_0<=$this->getToken('FALSE'))||$LA32_0==$this->getToken('IRI_REF')||$LA32_0==$this->getToken('PNAME_NS')||$LA32_0==$this->getToken('PNAME_LN')||($LA32_0>=$this->getToken('VAR1') && $LA32_0<=$this->getToken('VAR2'))||$LA32_0==$this->getToken('INTEGER')||$LA32_0==$this->getToken('DECIMAL')||$LA32_0==$this->getToken('DOUBLE')||($LA32_0>=$this->getToken('INTEGER_POSITIVE') && $LA32_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA32_0>=$this->getToken('STRING_LITERAL1') && $LA32_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA32_0==$this->getToken('BLANK_NODE_LABEL')||$LA32_0==$this->getToken('OPEN_BRACE')||$LA32_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt32=1;
            }
            switch ($alt32) {
                case 1 :
                    // Sparql11query.g:252:20: constructTriples 
                    {
                    $this->pushFollow(self::$FOLLOW_constructTriples_in_constructTemplate872);
                    $this->constructTriples();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate875); 

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
    // Sparql11query.g:257:1: constructTriples : triplesSameSubject ( DOT ( constructTriples )? )? ; 
    public function constructTriples(){
        try {
            // Sparql11query.g:258:3: ( triplesSameSubject ( DOT ( constructTriples )? )? ) 
            // Sparql11query.g:259:3: triplesSameSubject ( DOT ( constructTriples )? )? 
            {
            $this->pushFollow(self::$FOLLOW_triplesSameSubject_in_constructTriples893);
            $this->triplesSameSubject();

            $this->state->_fsp--;

            // Sparql11query.g:259:22: ( DOT ( constructTriples )? )? 
            $alt34=2;
            $LA34_0 = $this->input->LA(1);

            if ( ($LA34_0==$this->getToken('DOT')) ) {
                $alt34=1;
            }
            switch ($alt34) {
                case 1 :
                    // Sparql11query.g:259:23: DOT ( constructTriples )? 
                    {
                    $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_constructTriples896); 
                    // Sparql11query.g:259:27: ( constructTriples )? 
                    $alt33=2;
                    $LA33_0 = $this->input->LA(1);

                    if ( (($LA33_0>=$this->getToken('TRUE') && $LA33_0<=$this->getToken('FALSE'))||$LA33_0==$this->getToken('IRI_REF')||$LA33_0==$this->getToken('PNAME_NS')||$LA33_0==$this->getToken('PNAME_LN')||($LA33_0>=$this->getToken('VAR1') && $LA33_0<=$this->getToken('VAR2'))||$LA33_0==$this->getToken('INTEGER')||$LA33_0==$this->getToken('DECIMAL')||$LA33_0==$this->getToken('DOUBLE')||($LA33_0>=$this->getToken('INTEGER_POSITIVE') && $LA33_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA33_0>=$this->getToken('STRING_LITERAL1') && $LA33_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA33_0==$this->getToken('BLANK_NODE_LABEL')||$LA33_0==$this->getToken('OPEN_BRACE')||$LA33_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                        $alt33=1;
                    }
                    switch ($alt33) {
                        case 1 :
                            // Sparql11query.g:259:27: constructTriples 
                            {
                            $this->pushFollow(self::$FOLLOW_constructTriples_in_constructTriples898);
                            $this->constructTriples();

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
    // $ANTLR end "constructTriples"


    // $ANTLR start "triplesSameSubject"
    // Sparql11query.g:264:1: triplesSameSubject : ( varOrTerm propertyListNotEmpty | triplesNode propertyList ); 
    public function triplesSameSubject(){
        try {
            // Sparql11query.g:265:3: ( varOrTerm propertyListNotEmpty | triplesNode propertyList ) 
            $alt35=2;
            $LA35 = $this->input->LA(1);
            if($this->getToken('TRUE')== $LA35||$this->getToken('FALSE')== $LA35||$this->getToken('IRI_REF')== $LA35||$this->getToken('PNAME_NS')== $LA35||$this->getToken('PNAME_LN')== $LA35||$this->getToken('VAR1')== $LA35||$this->getToken('VAR2')== $LA35||$this->getToken('INTEGER')== $LA35||$this->getToken('DECIMAL')== $LA35||$this->getToken('DOUBLE')== $LA35||$this->getToken('INTEGER_POSITIVE')== $LA35||$this->getToken('DECIMAL_POSITIVE')== $LA35||$this->getToken('DOUBLE_POSITIVE')== $LA35||$this->getToken('INTEGER_NEGATIVE')== $LA35||$this->getToken('DECIMAL_NEGATIVE')== $LA35||$this->getToken('DOUBLE_NEGATIVE')== $LA35||$this->getToken('STRING_LITERAL1')== $LA35||$this->getToken('STRING_LITERAL2')== $LA35||$this->getToken('STRING_LITERAL_LONG1')== $LA35||$this->getToken('STRING_LITERAL_LONG2')== $LA35||$this->getToken('BLANK_NODE_LABEL')== $LA35)
                {
                $alt35=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA35)
                {
                $LA35_2 = $this->input->LA(2);

                if ( ($LA35_2==$this->getToken('WS')||$LA35_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt35=1;
                }
                else if ( ($LA35_2==$this->getToken('A')||$LA35_2==$this->getToken('IRI_REF')||$LA35_2==$this->getToken('PNAME_NS')||$LA35_2==$this->getToken('PNAME_LN')||($LA35_2>=$this->getToken('VAR1') && $LA35_2<=$this->getToken('VAR2'))) ) {
                    $alt35=2;
                }
                else {
                    $nvae = new NoViableAltException("", 35, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA35)
                {
                $LA35_3 = $this->input->LA(2);

                if ( (($LA35_3>=$this->getToken('TRUE') && $LA35_3<=$this->getToken('FALSE'))||$LA35_3==$this->getToken('IRI_REF')||$LA35_3==$this->getToken('PNAME_NS')||$LA35_3==$this->getToken('PNAME_LN')||($LA35_3>=$this->getToken('VAR1') && $LA35_3<=$this->getToken('VAR2'))||$LA35_3==$this->getToken('INTEGER')||$LA35_3==$this->getToken('DECIMAL')||$LA35_3==$this->getToken('DOUBLE')||($LA35_3>=$this->getToken('INTEGER_POSITIVE') && $LA35_3<=$this->getToken('DOUBLE_NEGATIVE'))||($LA35_3>=$this->getToken('STRING_LITERAL1') && $LA35_3<=$this->getToken('STRING_LITERAL_LONG2'))||$LA35_3==$this->getToken('BLANK_NODE_LABEL')||$LA35_3==$this->getToken('OPEN_BRACE')||$LA35_3==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt35=2;
                }
                else if ( ($LA35_3==$this->getToken('WS')||$LA35_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt35=1;
                }
                else {
                    $nvae = new NoViableAltException("", 35, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 35, 0, $this->input);

                throw $nvae;
            }

            switch ($alt35) {
                case 1 :
                    // Sparql11query.g:266:3: varOrTerm propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_triplesSameSubject919);
                    $this->varOrTerm();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_triplesSameSubject921);
                    $this->propertyListNotEmpty();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:267:5: triplesNode propertyList 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_triplesSameSubject927);
                    $this->triplesNode();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyList_in_triplesSameSubject929);
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
    // Sparql11query.g:272:1: propertyListNotEmpty : verb objectList ( SEMICOLON ( verb objectList )? )* ; 
    public function propertyListNotEmpty(){
        try {
            // Sparql11query.g:273:3: ( verb objectList ( SEMICOLON ( verb objectList )? )* ) 
            // Sparql11query.g:274:3: verb objectList ( SEMICOLON ( verb objectList )? )* 
            {
            $this->pushFollow(self::$FOLLOW_verb_in_propertyListNotEmpty947);
            $this->verb();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmpty949);
            $this->objectList();

            $this->state->_fsp--;

            // Sparql11query.g:274:19: ( SEMICOLON ( verb objectList )? )* 
            //loop37:
            do {
                $alt37=2;
                $LA37_0 = $this->input->LA(1);

                if ( ($LA37_0==$this->getToken('SEMICOLON')) ) {
                    $alt37=1;
                }


                switch ($alt37) {
            	case 1 :
            	    // Sparql11query.g:274:20: SEMICOLON ( verb objectList )? 
            	    {
            	    $this->match($this->input,$this->getToken('SEMICOLON'),self::$FOLLOW_SEMICOLON_in_propertyListNotEmpty952); 
            	    // Sparql11query.g:274:30: ( verb objectList )? 
            	    $alt36=2;
            	    $LA36_0 = $this->input->LA(1);

            	    if ( ($LA36_0==$this->getToken('A')||$LA36_0==$this->getToken('IRI_REF')||$LA36_0==$this->getToken('PNAME_NS')||$LA36_0==$this->getToken('PNAME_LN')||($LA36_0>=$this->getToken('VAR1') && $LA36_0<=$this->getToken('VAR2'))) ) {
            	        $alt36=1;
            	    }
            	    switch ($alt36) {
            	        case 1 :
            	            // Sparql11query.g:274:31: verb objectList 
            	            {
            	            $this->pushFollow(self::$FOLLOW_verb_in_propertyListNotEmpty955);
            	            $this->verb();

            	            $this->state->_fsp--;

            	            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmpty957);
            	            $this->objectList();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop37;
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
    // Sparql11query.g:279:1: propertyList : ( propertyListNotEmpty )? ; 
    public function propertyList(){
        try {
            // Sparql11query.g:280:3: ( ( propertyListNotEmpty )? ) 
            // Sparql11query.g:281:3: ( propertyListNotEmpty )? 
            {
            // Sparql11query.g:281:3: ( propertyListNotEmpty )? 
            $alt38=2;
            $LA38_0 = $this->input->LA(1);

            if ( ($LA38_0==$this->getToken('A')||$LA38_0==$this->getToken('IRI_REF')||$LA38_0==$this->getToken('PNAME_NS')||$LA38_0==$this->getToken('PNAME_LN')||($LA38_0>=$this->getToken('VAR1') && $LA38_0<=$this->getToken('VAR2'))) ) {
                $alt38=1;
            }
            switch ($alt38) {
                case 1 :
                    // Sparql11query.g:281:3: propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_propertyList979);
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
    // Sparql11query.g:286:1: objectList : object ( COMMA object )* ; 
    public function objectList(){
        try {
            // Sparql11query.g:287:3: ( object ( COMMA object )* ) 
            // Sparql11query.g:288:3: object ( COMMA object )* 
            {
            $this->pushFollow(self::$FOLLOW_object_in_objectList998);
            $this->object();

            $this->state->_fsp--;

            // Sparql11query.g:288:10: ( COMMA object )* 
            //loop39:
            do {
                $alt39=2;
                $LA39_0 = $this->input->LA(1);

                if ( ($LA39_0==$this->getToken('COMMA')) ) {
                    $alt39=1;
                }


                switch ($alt39) {
            	case 1 :
            	    // Sparql11query.g:288:11: COMMA object 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectList1001); 
            	    $this->pushFollow(self::$FOLLOW_object_in_objectList1003);
            	    $this->object();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop39;
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
    // Sparql11query.g:293:1: object : graphNode ; 
    public function object(){
        try {
            // Sparql11query.g:294:3: ( graphNode ) 
            // Sparql11query.g:295:3: graphNode 
            {
            $this->pushFollow(self::$FOLLOW_graphNode_in_object1023);
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
    // Sparql11query.g:300:1: verb : ( varOrIRIref | A ); 
    public function verb(){
        try {
            // Sparql11query.g:301:3: ( varOrIRIref | A ) 
            $alt40=2;
            $LA40_0 = $this->input->LA(1);

            if ( ($LA40_0==$this->getToken('IRI_REF')||$LA40_0==$this->getToken('PNAME_NS')||$LA40_0==$this->getToken('PNAME_LN')||($LA40_0>=$this->getToken('VAR1') && $LA40_0<=$this->getToken('VAR2'))) ) {
                $alt40=1;
            }
            else if ( ($LA40_0==$this->getToken('A')) ) {
                $alt40=2;
            }
            else {
                $nvae = new NoViableAltException("", 40, 0, $this->input);

                throw $nvae;
            }
            switch ($alt40) {
                case 1 :
                    // Sparql11query.g:302:3: varOrIRIref 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrIRIref_in_verb1041);
                    $this->varOrIRIref();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:303:5: A 
                    {
                    $this->match($this->input,$this->getToken('A'),self::$FOLLOW_A_in_verb1047); 

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
    // Sparql11query.g:308:1: triplesNode : ( collection | blankNodePropertyList ); 
    public function triplesNode(){
        try {
            // Sparql11query.g:309:3: ( collection | blankNodePropertyList ) 
            $alt41=2;
            $LA41_0 = $this->input->LA(1);

            if ( ($LA41_0==$this->getToken('OPEN_BRACE')) ) {
                $alt41=1;
            }
            else if ( ($LA41_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt41=2;
            }
            else {
                $nvae = new NoViableAltException("", 41, 0, $this->input);

                throw $nvae;
            }
            switch ($alt41) {
                case 1 :
                    // Sparql11query.g:310:3: collection 
                    {
                    $this->pushFollow(self::$FOLLOW_collection_in_triplesNode1065);
                    $this->collection();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:311:5: blankNodePropertyList 
                    {
                    $this->pushFollow(self::$FOLLOW_blankNodePropertyList_in_triplesNode1071);
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
    // Sparql11query.g:316:1: blankNodePropertyList : OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE ; 
    public function blankNodePropertyList(){
        try {
            // Sparql11query.g:317:3: ( OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE ) 
            // Sparql11query.g:318:3: OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1089); 
            $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1091);
            $this->propertyListNotEmpty();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1093); 

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
    // Sparql11query.g:323:1: collection : OPEN_BRACE ( graphNode )+ CLOSE_BRACE ; 
    public function collection(){
        try {
            // Sparql11query.g:324:3: ( OPEN_BRACE ( graphNode )+ CLOSE_BRACE ) 
            // Sparql11query.g:325:3: OPEN_BRACE ( graphNode )+ CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_collection1111); 
            // Sparql11query.g:325:14: ( graphNode )+ 
            $cnt42=0;
            //loop42:
            do {
                $alt42=2;
                $LA42_0 = $this->input->LA(1);

                if ( (($LA42_0>=$this->getToken('TRUE') && $LA42_0<=$this->getToken('FALSE'))||$LA42_0==$this->getToken('IRI_REF')||$LA42_0==$this->getToken('PNAME_NS')||$LA42_0==$this->getToken('PNAME_LN')||($LA42_0>=$this->getToken('VAR1') && $LA42_0<=$this->getToken('VAR2'))||$LA42_0==$this->getToken('INTEGER')||$LA42_0==$this->getToken('DECIMAL')||$LA42_0==$this->getToken('DOUBLE')||($LA42_0>=$this->getToken('INTEGER_POSITIVE') && $LA42_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA42_0>=$this->getToken('STRING_LITERAL1') && $LA42_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA42_0==$this->getToken('BLANK_NODE_LABEL')||$LA42_0==$this->getToken('OPEN_BRACE')||$LA42_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt42=1;
                }


                switch ($alt42) {
            	case 1 :
            	    // Sparql11query.g:325:14: graphNode 
            	    {
            	    $this->pushFollow(self::$FOLLOW_graphNode_in_collection1113);
            	    $this->graphNode();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt42 >= 1 ) break 2;//loop42;
                        $eee =
                            new EarlyExitException(42, $this->input);
                        throw $eee;
                }
                $cnt42++;
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_collection1116); 

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
    // Sparql11query.g:330:1: graphNode : ( varOrTerm | triplesNode ); 
    public function graphNode(){
        try {
            // Sparql11query.g:331:3: ( varOrTerm | triplesNode ) 
            $alt43=2;
            $LA43 = $this->input->LA(1);
            if($this->getToken('TRUE')== $LA43||$this->getToken('FALSE')== $LA43||$this->getToken('IRI_REF')== $LA43||$this->getToken('PNAME_NS')== $LA43||$this->getToken('PNAME_LN')== $LA43||$this->getToken('VAR1')== $LA43||$this->getToken('VAR2')== $LA43||$this->getToken('INTEGER')== $LA43||$this->getToken('DECIMAL')== $LA43||$this->getToken('DOUBLE')== $LA43||$this->getToken('INTEGER_POSITIVE')== $LA43||$this->getToken('DECIMAL_POSITIVE')== $LA43||$this->getToken('DOUBLE_POSITIVE')== $LA43||$this->getToken('INTEGER_NEGATIVE')== $LA43||$this->getToken('DECIMAL_NEGATIVE')== $LA43||$this->getToken('DOUBLE_NEGATIVE')== $LA43||$this->getToken('STRING_LITERAL1')== $LA43||$this->getToken('STRING_LITERAL2')== $LA43||$this->getToken('STRING_LITERAL_LONG1')== $LA43||$this->getToken('STRING_LITERAL_LONG2')== $LA43||$this->getToken('BLANK_NODE_LABEL')== $LA43)
                {
                $alt43=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA43)
                {
                $LA43_2 = $this->input->LA(2);

                if ( ($LA43_2==$this->getToken('WS')||$LA43_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt43=1;
                }
                else if ( ($LA43_2==$this->getToken('A')||$LA43_2==$this->getToken('IRI_REF')||$LA43_2==$this->getToken('PNAME_NS')||$LA43_2==$this->getToken('PNAME_LN')||($LA43_2>=$this->getToken('VAR1') && $LA43_2<=$this->getToken('VAR2'))) ) {
                    $alt43=2;
                }
                else {
                    $nvae = new NoViableAltException("", 43, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA43)
                {
                $LA43_3 = $this->input->LA(2);

                if ( (($LA43_3>=$this->getToken('TRUE') && $LA43_3<=$this->getToken('FALSE'))||$LA43_3==$this->getToken('IRI_REF')||$LA43_3==$this->getToken('PNAME_NS')||$LA43_3==$this->getToken('PNAME_LN')||($LA43_3>=$this->getToken('VAR1') && $LA43_3<=$this->getToken('VAR2'))||$LA43_3==$this->getToken('INTEGER')||$LA43_3==$this->getToken('DECIMAL')||$LA43_3==$this->getToken('DOUBLE')||($LA43_3>=$this->getToken('INTEGER_POSITIVE') && $LA43_3<=$this->getToken('DOUBLE_NEGATIVE'))||($LA43_3>=$this->getToken('STRING_LITERAL1') && $LA43_3<=$this->getToken('STRING_LITERAL_LONG2'))||$LA43_3==$this->getToken('BLANK_NODE_LABEL')||$LA43_3==$this->getToken('OPEN_BRACE')||$LA43_3==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt43=2;
                }
                else if ( ($LA43_3==$this->getToken('WS')||$LA43_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt43=1;
                }
                else {
                    $nvae = new NoViableAltException("", 43, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 43, 0, $this->input);

                throw $nvae;
            }

            switch ($alt43) {
                case 1 :
                    // Sparql11query.g:332:3: varOrTerm 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_graphNode1134);
                    $this->varOrTerm();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:333:5: triplesNode 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_graphNode1140);
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
    // Sparql11query.g:338:1: varOrTerm : ( variable | graphTerm ); 
    public function varOrTerm(){
        try {
            // Sparql11query.g:339:3: ( variable | graphTerm ) 
            $alt44=2;
            $LA44_0 = $this->input->LA(1);

            if ( (($LA44_0>=$this->getToken('VAR1') && $LA44_0<=$this->getToken('VAR2'))) ) {
                $alt44=1;
            }
            else if ( (($LA44_0>=$this->getToken('TRUE') && $LA44_0<=$this->getToken('FALSE'))||$LA44_0==$this->getToken('IRI_REF')||$LA44_0==$this->getToken('PNAME_NS')||$LA44_0==$this->getToken('PNAME_LN')||$LA44_0==$this->getToken('INTEGER')||$LA44_0==$this->getToken('DECIMAL')||$LA44_0==$this->getToken('DOUBLE')||($LA44_0>=$this->getToken('INTEGER_POSITIVE') && $LA44_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA44_0>=$this->getToken('STRING_LITERAL1') && $LA44_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA44_0==$this->getToken('BLANK_NODE_LABEL')||$LA44_0==$this->getToken('OPEN_BRACE')||$LA44_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt44=2;
            }
            else {
                $nvae = new NoViableAltException("", 44, 0, $this->input);

                throw $nvae;
            }
            switch ($alt44) {
                case 1 :
                    // Sparql11query.g:340:3: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_varOrTerm1158);
                    $this->variable();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:341:5: graphTerm 
                    {
                    $this->pushFollow(self::$FOLLOW_graphTerm_in_varOrTerm1164);
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
    // Sparql11query.g:346:1: varOrIRIref : ( variable | iriRef ); 
    public function varOrIRIref(){
        try {
            // Sparql11query.g:347:3: ( variable | iriRef ) 
            $alt45=2;
            $LA45_0 = $this->input->LA(1);

            if ( (($LA45_0>=$this->getToken('VAR1') && $LA45_0<=$this->getToken('VAR2'))) ) {
                $alt45=1;
            }
            else if ( ($LA45_0==$this->getToken('IRI_REF')||$LA45_0==$this->getToken('PNAME_NS')||$LA45_0==$this->getToken('PNAME_LN')) ) {
                $alt45=2;
            }
            else {
                $nvae = new NoViableAltException("", 45, 0, $this->input);

                throw $nvae;
            }
            switch ($alt45) {
                case 1 :
                    // Sparql11query.g:348:3: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_varOrIRIref1182);
                    $this->variable();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:349:5: iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_varOrIRIref1188);
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
    // Sparql11query.g:354:1: variable : ( VAR1 | VAR2 ); 
    public function variable(){
        try {
            // Sparql11query.g:355:3: ( VAR1 | VAR2 ) 
            // Sparql11query.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('VAR1') && $this->input->LA(1)<=$this->getToken('VAR2')) ) {
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
    // $ANTLR end "variable"


    // $ANTLR start "graphTerm"
    // Sparql11query.g:362:1: graphTerm : ( iriRef | rdfLiteral | numericLiteral | booleanLiteral | blankNode | OPEN_BRACE ( WS )* CLOSE_BRACE ); 
    public function graphTerm(){
        try {
            // Sparql11query.g:363:3: ( iriRef | rdfLiteral | numericLiteral | booleanLiteral | blankNode | OPEN_BRACE ( WS )* CLOSE_BRACE ) 
            $alt47=6;
            $LA47 = $this->input->LA(1);
            if($this->getToken('IRI_REF')== $LA47||$this->getToken('PNAME_NS')== $LA47||$this->getToken('PNAME_LN')== $LA47)
                {
                $alt47=1;
                }
            else if($this->getToken('STRING_LITERAL1')== $LA47||$this->getToken('STRING_LITERAL2')== $LA47||$this->getToken('STRING_LITERAL_LONG1')== $LA47||$this->getToken('STRING_LITERAL_LONG2')== $LA47)
                {
                $alt47=2;
                }
            else if($this->getToken('INTEGER')== $LA47||$this->getToken('DECIMAL')== $LA47||$this->getToken('DOUBLE')== $LA47||$this->getToken('INTEGER_POSITIVE')== $LA47||$this->getToken('DECIMAL_POSITIVE')== $LA47||$this->getToken('DOUBLE_POSITIVE')== $LA47||$this->getToken('INTEGER_NEGATIVE')== $LA47||$this->getToken('DECIMAL_NEGATIVE')== $LA47||$this->getToken('DOUBLE_NEGATIVE')== $LA47)
                {
                $alt47=3;
                }
            else if($this->getToken('TRUE')== $LA47||$this->getToken('FALSE')== $LA47)
                {
                $alt47=4;
                }
            else if($this->getToken('BLANK_NODE_LABEL')== $LA47||$this->getToken('OPEN_SQUARE_BRACE')== $LA47)
                {
                $alt47=5;
                }
            else if($this->getToken('OPEN_BRACE')== $LA47)
                {
                $alt47=6;
                }
            else{
                $nvae =
                    new NoViableAltException("", 47, 0, $this->input);

                throw $nvae;
            }

            switch ($alt47) {
                case 1 :
                    // Sparql11query.g:364:3: iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_graphTerm1230);
                    $this->iriRef();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:365:5: rdfLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_rdfLiteral_in_graphTerm1236);
                    $this->rdfLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11query.g:366:5: numericLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteral_in_graphTerm1242);
                    $this->numericLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql11query.g:367:5: booleanLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_booleanLiteral_in_graphTerm1248);
                    $this->booleanLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Sparql11query.g:368:5: blankNode 
                    {
                    $this->pushFollow(self::$FOLLOW_blankNode_in_graphTerm1254);
                    $this->blankNode();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Sparql11query.g:369:5: OPEN_BRACE ( WS )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_graphTerm1260); 
                    // Sparql11query.g:369:16: ( WS )* 
                    //loop46:
                    do {
                        $alt46=2;
                        $LA46_0 = $this->input->LA(1);

                        if ( ($LA46_0==$this->getToken('WS')) ) {
                            $alt46=1;
                        }


                        switch ($alt46) {
                    	case 1 :
                    	    // Sparql11query.g:369:16: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_graphTerm1262); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop46;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_graphTerm1265); 

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
    // Sparql11query.g:374:1: expression : conditionalOrExpression ; 
    public function expression(){
        try {
            // Sparql11query.g:375:3: ( conditionalOrExpression ) 
            // Sparql11query.g:376:3: conditionalOrExpression 
            {
            $this->pushFollow(self::$FOLLOW_conditionalOrExpression_in_expression1283);
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
    // Sparql11query.g:381:1: conditionalOrExpression : conditionalAndExpression ( OR conditionalAndExpression )* ; 
    public function conditionalOrExpression(){
        try {
            // Sparql11query.g:382:3: ( conditionalAndExpression ( OR conditionalAndExpression )* ) 
            // Sparql11query.g:383:3: conditionalAndExpression ( OR conditionalAndExpression )* 
            {
            $this->pushFollow(self::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1301);
            $this->conditionalAndExpression();

            $this->state->_fsp--;

            // Sparql11query.g:383:28: ( OR conditionalAndExpression )* 
            //loop48:
            do {
                $alt48=2;
                $LA48_0 = $this->input->LA(1);

                if ( ($LA48_0==$this->getToken('OR')) ) {
                    $alt48=1;
                }


                switch ($alt48) {
            	case 1 :
            	    // Sparql11query.g:383:29: OR conditionalAndExpression 
            	    {
            	    $this->match($this->input,$this->getToken('OR'),self::$FOLLOW_OR_in_conditionalOrExpression1304); 
            	    $this->pushFollow(self::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1306);
            	    $this->conditionalAndExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop48;
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
    // Sparql11query.g:388:1: conditionalAndExpression : valueLogical ( AND valueLogical )* ; 
    public function conditionalAndExpression(){
        try {
            // Sparql11query.g:389:3: ( valueLogical ( AND valueLogical )* ) 
            // Sparql11query.g:390:3: valueLogical ( AND valueLogical )* 
            {
            $this->pushFollow(self::$FOLLOW_valueLogical_in_conditionalAndExpression1326);
            $this->valueLogical();

            $this->state->_fsp--;

            // Sparql11query.g:390:16: ( AND valueLogical )* 
            //loop49:
            do {
                $alt49=2;
                $LA49_0 = $this->input->LA(1);

                if ( ($LA49_0==$this->getToken('AND')) ) {
                    $alt49=1;
                }


                switch ($alt49) {
            	case 1 :
            	    // Sparql11query.g:390:17: AND valueLogical 
            	    {
            	    $this->match($this->input,$this->getToken('AND'),self::$FOLLOW_AND_in_conditionalAndExpression1329); 
            	    $this->pushFollow(self::$FOLLOW_valueLogical_in_conditionalAndExpression1331);
            	    $this->valueLogical();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop49;
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
    // Sparql11query.g:395:1: valueLogical : relationalExpression ; 
    public function valueLogical(){
        try {
            // Sparql11query.g:396:3: ( relationalExpression ) 
            // Sparql11query.g:397:3: relationalExpression 
            {
            $this->pushFollow(self::$FOLLOW_relationalExpression_in_valueLogical1351);
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
    // Sparql11query.g:402:1: relationalExpression : numericExpression ( EQUAL numericExpression | NOT_EQUAL numericExpression | LESS numericExpression | GREATER numericExpression | LESS_EQUAL numericExpression | GREATER_EQUAL numericExpression )? ; 
    public function relationalExpression(){
        try {
            // Sparql11query.g:403:3: ( numericExpression ( EQUAL numericExpression | NOT_EQUAL numericExpression | LESS numericExpression | GREATER numericExpression | LESS_EQUAL numericExpression | GREATER_EQUAL numericExpression )? ) 
            // Sparql11query.g:404:3: numericExpression ( EQUAL numericExpression | NOT_EQUAL numericExpression | LESS numericExpression | GREATER numericExpression | LESS_EQUAL numericExpression | GREATER_EQUAL numericExpression )? 
            {
            $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1369);
            $this->numericExpression();

            $this->state->_fsp--;

            // Sparql11query.g:405:3: ( EQUAL numericExpression | NOT_EQUAL numericExpression | LESS numericExpression | GREATER numericExpression | LESS_EQUAL numericExpression | GREATER_EQUAL numericExpression )? 
            $alt50=7;
            $LA50 = $this->input->LA(1);
            if($this->getToken('EQUAL')== $LA50)
                {
                $alt50=1;
                }
            else if($this->getToken('NOT_EQUAL')== $LA50)
                {
                $alt50=2;
                }
            else if($this->getToken('LESS')== $LA50)
                {
                $alt50=3;
                }
            else if($this->getToken('GREATER')== $LA50)
                {
                $alt50=4;
                }
            else if($this->getToken('LESS_EQUAL')== $LA50)
                {
                $alt50=5;
                }
            else if($this->getToken('GREATER_EQUAL')== $LA50)
                {
                $alt50=6;
                }

            switch ($alt50) {
                case 1 :
                    // Sparql11query.g:406:5: EQUAL numericExpression 
                    {
                    $this->match($this->input,$this->getToken('EQUAL'),self::$FOLLOW_EQUAL_in_relationalExpression1379); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1381);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:407:7: NOT_EQUAL numericExpression 
                    {
                    $this->match($this->input,$this->getToken('NOT_EQUAL'),self::$FOLLOW_NOT_EQUAL_in_relationalExpression1389); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1391);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11query.g:408:7: LESS numericExpression 
                    {
                    $this->match($this->input,$this->getToken('LESS'),self::$FOLLOW_LESS_in_relationalExpression1399); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1401);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql11query.g:409:7: GREATER numericExpression 
                    {
                    $this->match($this->input,$this->getToken('GREATER'),self::$FOLLOW_GREATER_in_relationalExpression1409); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1411);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Sparql11query.g:410:7: LESS_EQUAL numericExpression 
                    {
                    $this->match($this->input,$this->getToken('LESS_EQUAL'),self::$FOLLOW_LESS_EQUAL_in_relationalExpression1419); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1421);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Sparql11query.g:411:7: GREATER_EQUAL numericExpression 
                    {
                    $this->match($this->input,$this->getToken('GREATER_EQUAL'),self::$FOLLOW_GREATER_EQUAL_in_relationalExpression1429); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1431);
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
    // Sparql11query.g:417:1: numericExpression : additiveExpression ; 
    public function numericExpression(){
        try {
            // Sparql11query.g:418:3: ( additiveExpression ) 
            // Sparql11query.g:419:3: additiveExpression 
            {
            $this->pushFollow(self::$FOLLOW_additiveExpression_in_numericExpression1454);
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
    // Sparql11query.g:424:1: additiveExpression : multiplicativeExpression ( PLUS multiplicativeExpression | MINUS multiplicativeExpression | numericLiteralPositive | numericLiteralNegative )* ; 
    public function additiveExpression(){
        try {
            // Sparql11query.g:425:3: ( multiplicativeExpression ( PLUS multiplicativeExpression | MINUS multiplicativeExpression | numericLiteralPositive | numericLiteralNegative )* ) 
            // Sparql11query.g:426:3: multiplicativeExpression ( PLUS multiplicativeExpression | MINUS multiplicativeExpression | numericLiteralPositive | numericLiteralNegative )* 
            {
            $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1472);
            $this->multiplicativeExpression();

            $this->state->_fsp--;

            // Sparql11query.g:427:3: ( PLUS multiplicativeExpression | MINUS multiplicativeExpression | numericLiteralPositive | numericLiteralNegative )* 
            //loop51:
            do {
                $alt51=5;
                $LA51 = $this->input->LA(1);
                if($this->getToken('PLUS')== $LA51)
                    {
                    $alt51=1;
                    }
                else if($this->getToken('MINUS')== $LA51)
                    {
                    $alt51=2;
                    }
                else if($this->getToken('INTEGER_POSITIVE')== $LA51||$this->getToken('DECIMAL_POSITIVE')== $LA51||$this->getToken('DOUBLE_POSITIVE')== $LA51)
                    {
                    $alt51=3;
                    }
                else if($this->getToken('INTEGER_NEGATIVE')== $LA51||$this->getToken('DECIMAL_NEGATIVE')== $LA51||$this->getToken('DOUBLE_NEGATIVE')== $LA51)
                    {
                    $alt51=4;
                    }



                switch ($alt51) {
            	case 1 :
            	    // Sparql11query.g:428:5: PLUS multiplicativeExpression 
            	    {
            	    $this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_additiveExpression1482); 
            	    $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1484);
            	    $this->multiplicativeExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // Sparql11query.g:429:7: MINUS multiplicativeExpression 
            	    {
            	    $this->match($this->input,$this->getToken('MINUS'),self::$FOLLOW_MINUS_in_additiveExpression1492); 
            	    $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1494);
            	    $this->multiplicativeExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 3 :
            	    // Sparql11query.g:430:7: numericLiteralPositive 
            	    {
            	    $this->pushFollow(self::$FOLLOW_numericLiteralPositive_in_additiveExpression1502);
            	    $this->numericLiteralPositive();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 4 :
            	    // Sparql11query.g:431:7: numericLiteralNegative 
            	    {
            	    $this->pushFollow(self::$FOLLOW_numericLiteralNegative_in_additiveExpression1510);
            	    $this->numericLiteralNegative();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop51;
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
    // Sparql11query.g:437:1: multiplicativeExpression : unaryExpression ( ASTERISK unaryExpression | DIVIDE unaryExpression )* ; 
    public function multiplicativeExpression(){
        try {
            // Sparql11query.g:438:3: ( unaryExpression ( ASTERISK unaryExpression | DIVIDE unaryExpression )* ) 
            // Sparql11query.g:439:3: unaryExpression ( ASTERISK unaryExpression | DIVIDE unaryExpression )* 
            {
            $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1533);
            $this->unaryExpression();

            $this->state->_fsp--;

            // Sparql11query.g:440:3: ( ASTERISK unaryExpression | DIVIDE unaryExpression )* 
            //loop52:
            do {
                $alt52=3;
                $LA52_0 = $this->input->LA(1);

                if ( ($LA52_0==$this->getToken('ASTERISK')) ) {
                    $alt52=1;
                }
                else if ( ($LA52_0==$this->getToken('DIVIDE')) ) {
                    $alt52=2;
                }


                switch ($alt52) {
            	case 1 :
            	    // Sparql11query.g:441:5: ASTERISK unaryExpression 
            	    {
            	    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_multiplicativeExpression1543); 
            	    $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1545);
            	    $this->unaryExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // Sparql11query.g:442:7: DIVIDE unaryExpression 
            	    {
            	    $this->match($this->input,$this->getToken('DIVIDE'),self::$FOLLOW_DIVIDE_in_multiplicativeExpression1553); 
            	    $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1555);
            	    $this->unaryExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop52;
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
    // Sparql11query.g:448:1: unaryExpression : ( NOT_SIGN primaryExpression | PLUS primaryExpression | MINUS primaryExpression | primaryExpression ); 
    public function unaryExpression(){
        try {
            // Sparql11query.g:449:3: ( NOT_SIGN primaryExpression | PLUS primaryExpression | MINUS primaryExpression | primaryExpression ) 
            $alt53=4;
            $LA53 = $this->input->LA(1);
            if($this->getToken('NOT_SIGN')== $LA53)
                {
                $alt53=1;
                }
            else if($this->getToken('PLUS')== $LA53)
                {
                $alt53=2;
                }
            else if($this->getToken('MINUS')== $LA53)
                {
                $alt53=3;
                }
            else if($this->getToken('COALESCE')== $LA53||$this->getToken('IF')== $LA53||$this->getToken('STR')== $LA53||$this->getToken('LANG')== $LA53||$this->getToken('LANGMATCHES')== $LA53||$this->getToken('DATATYPE')== $LA53||$this->getToken('BOUND')== $LA53||$this->getToken('SAMETERM')== $LA53||$this->getToken('ISIRI')== $LA53||$this->getToken('ISURI')== $LA53||$this->getToken('ISBLANK')== $LA53||$this->getToken('ISLITERAL')== $LA53||$this->getToken('REGEX')== $LA53||$this->getToken('TRUE')== $LA53||$this->getToken('FALSE')== $LA53||$this->getToken('IRI_REF')== $LA53||$this->getToken('PNAME_NS')== $LA53||$this->getToken('PNAME_LN')== $LA53||$this->getToken('VAR1')== $LA53||$this->getToken('VAR2')== $LA53||$this->getToken('INTEGER')== $LA53||$this->getToken('DECIMAL')== $LA53||$this->getToken('DOUBLE')== $LA53||$this->getToken('INTEGER_POSITIVE')== $LA53||$this->getToken('DECIMAL_POSITIVE')== $LA53||$this->getToken('DOUBLE_POSITIVE')== $LA53||$this->getToken('INTEGER_NEGATIVE')== $LA53||$this->getToken('DECIMAL_NEGATIVE')== $LA53||$this->getToken('DOUBLE_NEGATIVE')== $LA53||$this->getToken('STRING_LITERAL1')== $LA53||$this->getToken('STRING_LITERAL2')== $LA53||$this->getToken('STRING_LITERAL_LONG1')== $LA53||$this->getToken('STRING_LITERAL_LONG2')== $LA53||$this->getToken('OPEN_BRACE')== $LA53)
                {
                $alt53=4;
                }
            else{
                $nvae =
                    new NoViableAltException("", 53, 0, $this->input);

                throw $nvae;
            }

            switch ($alt53) {
                case 1 :
                    // Sparql11query.g:450:3: NOT_SIGN primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('NOT_SIGN'),self::$FOLLOW_NOT_SIGN_in_unaryExpression1578); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1580);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:451:5: PLUS primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_unaryExpression1586); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1588);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11query.g:452:5: MINUS primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('MINUS'),self::$FOLLOW_MINUS_in_unaryExpression1594); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1596);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql11query.g:453:5: primaryExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1602);
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
    // Sparql11query.g:458:1: primaryExpression : ( brackettedExpression | builtInCall | iriRefOrFunction | rdfLiteral | numericLiteral | booleanLiteral | variable ); 
    public function primaryExpression(){
        try {
            // Sparql11query.g:459:3: ( brackettedExpression | builtInCall | iriRefOrFunction | rdfLiteral | numericLiteral | booleanLiteral | variable ) 
            $alt54=7;
            $LA54 = $this->input->LA(1);
            if($this->getToken('OPEN_BRACE')== $LA54)
                {
                $alt54=1;
                }
            else if($this->getToken('COALESCE')== $LA54||$this->getToken('IF')== $LA54||$this->getToken('STR')== $LA54||$this->getToken('LANG')== $LA54||$this->getToken('LANGMATCHES')== $LA54||$this->getToken('DATATYPE')== $LA54||$this->getToken('BOUND')== $LA54||$this->getToken('SAMETERM')== $LA54||$this->getToken('ISIRI')== $LA54||$this->getToken('ISURI')== $LA54||$this->getToken('ISBLANK')== $LA54||$this->getToken('ISLITERAL')== $LA54||$this->getToken('REGEX')== $LA54)
                {
                $alt54=2;
                }
            else if($this->getToken('IRI_REF')== $LA54||$this->getToken('PNAME_NS')== $LA54||$this->getToken('PNAME_LN')== $LA54)
                {
                $alt54=3;
                }
            else if($this->getToken('STRING_LITERAL1')== $LA54||$this->getToken('STRING_LITERAL2')== $LA54||$this->getToken('STRING_LITERAL_LONG1')== $LA54||$this->getToken('STRING_LITERAL_LONG2')== $LA54)
                {
                $alt54=4;
                }
            else if($this->getToken('INTEGER')== $LA54||$this->getToken('DECIMAL')== $LA54||$this->getToken('DOUBLE')== $LA54||$this->getToken('INTEGER_POSITIVE')== $LA54||$this->getToken('DECIMAL_POSITIVE')== $LA54||$this->getToken('DOUBLE_POSITIVE')== $LA54||$this->getToken('INTEGER_NEGATIVE')== $LA54||$this->getToken('DECIMAL_NEGATIVE')== $LA54||$this->getToken('DOUBLE_NEGATIVE')== $LA54)
                {
                $alt54=5;
                }
            else if($this->getToken('TRUE')== $LA54||$this->getToken('FALSE')== $LA54)
                {
                $alt54=6;
                }
            else if($this->getToken('VAR1')== $LA54||$this->getToken('VAR2')== $LA54)
                {
                $alt54=7;
                }
            else{
                $nvae =
                    new NoViableAltException("", 54, 0, $this->input);

                throw $nvae;
            }

            switch ($alt54) {
                case 1 :
                    // Sparql11query.g:460:3: brackettedExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_primaryExpression1620);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:461:5: builtInCall 
                    {
                    $this->pushFollow(self::$FOLLOW_builtInCall_in_primaryExpression1626);
                    $this->builtInCall();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11query.g:462:5: iriRefOrFunction 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRefOrFunction_in_primaryExpression1632);
                    $this->iriRefOrFunction();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql11query.g:463:5: rdfLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_rdfLiteral_in_primaryExpression1638);
                    $this->rdfLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Sparql11query.g:464:5: numericLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteral_in_primaryExpression1644);
                    $this->numericLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Sparql11query.g:465:5: booleanLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_booleanLiteral_in_primaryExpression1650);
                    $this->booleanLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 7 :
                    // Sparql11query.g:466:5: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_primaryExpression1656);
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
    // Sparql11query.g:471:1: brackettedExpression : OPEN_BRACE expression CLOSE_BRACE ; 
    public function brackettedExpression(){
        try {
            // Sparql11query.g:472:3: ( OPEN_BRACE expression CLOSE_BRACE ) 
            // Sparql11query.g:473:3: OPEN_BRACE expression CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_brackettedExpression1674); 
            $this->pushFollow(self::$FOLLOW_expression_in_brackettedExpression1676);
            $this->expression();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_brackettedExpression1678); 

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
    // Sparql11query.g:495:1: builtInCall : ( STR OPEN_BRACE expression CLOSE_BRACE | LANG OPEN_BRACE expression CLOSE_BRACE | LANGMATCHES OPEN_BRACE expression COMMA expression CLOSE_BRACE | DATATYPE OPEN_BRACE expression CLOSE_BRACE | BOUND OPEN_BRACE variable CLOSE_BRACE | COALESCE argList | IF OPEN_BRACE expression COMMA expression COMMA expression CLOSE_BRACE | SAMETERM OPEN_BRACE expression COMMA expression CLOSE_BRACE | ISIRI OPEN_BRACE expression CLOSE_BRACE | ISURI OPEN_BRACE expression CLOSE_BRACE | ISBLANK OPEN_BRACE expression CLOSE_BRACE | ISLITERAL OPEN_BRACE expression CLOSE_BRACE | regexExpression ); 
    public function builtInCall(){
        try {
            // Sparql11query.g:496:3: ( STR OPEN_BRACE expression CLOSE_BRACE | LANG OPEN_BRACE expression CLOSE_BRACE | LANGMATCHES OPEN_BRACE expression COMMA expression CLOSE_BRACE | DATATYPE OPEN_BRACE expression CLOSE_BRACE | BOUND OPEN_BRACE variable CLOSE_BRACE | COALESCE argList | IF OPEN_BRACE expression COMMA expression COMMA expression CLOSE_BRACE | SAMETERM OPEN_BRACE expression COMMA expression CLOSE_BRACE | ISIRI OPEN_BRACE expression CLOSE_BRACE | ISURI OPEN_BRACE expression CLOSE_BRACE | ISBLANK OPEN_BRACE expression CLOSE_BRACE | ISLITERAL OPEN_BRACE expression CLOSE_BRACE | regexExpression ) 
            $alt55=13;
            $LA55 = $this->input->LA(1);
            if($this->getToken('STR')== $LA55)
                {
                $alt55=1;
                }
            else if($this->getToken('LANG')== $LA55)
                {
                $alt55=2;
                }
            else if($this->getToken('LANGMATCHES')== $LA55)
                {
                $alt55=3;
                }
            else if($this->getToken('DATATYPE')== $LA55)
                {
                $alt55=4;
                }
            else if($this->getToken('BOUND')== $LA55)
                {
                $alt55=5;
                }
            else if($this->getToken('COALESCE')== $LA55)
                {
                $alt55=6;
                }
            else if($this->getToken('IF')== $LA55)
                {
                $alt55=7;
                }
            else if($this->getToken('SAMETERM')== $LA55)
                {
                $alt55=8;
                }
            else if($this->getToken('ISIRI')== $LA55)
                {
                $alt55=9;
                }
            else if($this->getToken('ISURI')== $LA55)
                {
                $alt55=10;
                }
            else if($this->getToken('ISBLANK')== $LA55)
                {
                $alt55=11;
                }
            else if($this->getToken('ISLITERAL')== $LA55)
                {
                $alt55=12;
                }
            else if($this->getToken('REGEX')== $LA55)
                {
                $alt55=13;
                }
            else{
                $nvae =
                    new NoViableAltException("", 55, 0, $this->input);

                throw $nvae;
            }

            switch ($alt55) {
                case 1 :
                    // Sparql11query.g:497:3: STR OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('STR'),self::$FOLLOW_STR_in_builtInCall1713); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1715); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1717);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1719); 

                    }
                    break;
                case 2 :
                    // Sparql11query.g:498:5: LANG OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('LANG'),self::$FOLLOW_LANG_in_builtInCall1725); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1727); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1729);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1731); 

                    }
                    break;
                case 3 :
                    // Sparql11query.g:499:5: LANGMATCHES OPEN_BRACE expression COMMA expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('LANGMATCHES'),self::$FOLLOW_LANGMATCHES_in_builtInCall1737); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1739); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1741);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall1743); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1745);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1747); 

                    }
                    break;
                case 4 :
                    // Sparql11query.g:500:5: DATATYPE OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('DATATYPE'),self::$FOLLOW_DATATYPE_in_builtInCall1753); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1755); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1757);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1759); 

                    }
                    break;
                case 5 :
                    // Sparql11query.g:501:5: BOUND OPEN_BRACE variable CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('BOUND'),self::$FOLLOW_BOUND_in_builtInCall1765); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1767); 
                    $this->pushFollow(self::$FOLLOW_variable_in_builtInCall1769);
                    $this->variable();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1771); 

                    }
                    break;
                case 6 :
                    // Sparql11query.g:502:5: COALESCE argList 
                    {
                    $this->match($this->input,$this->getToken('COALESCE'),self::$FOLLOW_COALESCE_in_builtInCall1777); 
                    $this->pushFollow(self::$FOLLOW_argList_in_builtInCall1779);
                    $this->argList();

                    $this->state->_fsp--;


                    }
                    break;
                case 7 :
                    // Sparql11query.g:503:5: IF OPEN_BRACE expression COMMA expression COMMA expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('IF'),self::$FOLLOW_IF_in_builtInCall1785); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1787); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1789);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall1791); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1793);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall1795); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1797);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1799); 

                    }
                    break;
                case 8 :
                    // Sparql11query.g:504:5: SAMETERM OPEN_BRACE expression COMMA expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('SAMETERM'),self::$FOLLOW_SAMETERM_in_builtInCall1805); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1807); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1809);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall1811); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1813);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1815); 

                    }
                    break;
                case 9 :
                    // Sparql11query.g:505:5: ISIRI OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISIRI'),self::$FOLLOW_ISIRI_in_builtInCall1821); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1823); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1825);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1827); 

                    }
                    break;
                case 10 :
                    // Sparql11query.g:506:5: ISURI OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISURI'),self::$FOLLOW_ISURI_in_builtInCall1833); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1835); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1837);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1839); 

                    }
                    break;
                case 11 :
                    // Sparql11query.g:507:5: ISBLANK OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISBLANK'),self::$FOLLOW_ISBLANK_in_builtInCall1845); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1847); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1849);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1851); 

                    }
                    break;
                case 12 :
                    // Sparql11query.g:508:5: ISLITERAL OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISLITERAL'),self::$FOLLOW_ISLITERAL_in_builtInCall1857); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1859); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1861);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1863); 

                    }
                    break;
                case 13 :
                    // Sparql11query.g:509:5: regexExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_regexExpression_in_builtInCall1869);
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
    // Sparql11query.g:516:1: regexExpression : REGEX OPEN_BRACE expression COMMA expression ( COMMA expression )? CLOSE_BRACE ; 
    public function regexExpression(){
        try {
            // Sparql11query.g:517:3: ( REGEX OPEN_BRACE expression COMMA expression ( COMMA expression )? CLOSE_BRACE ) 
            // Sparql11query.g:518:3: REGEX OPEN_BRACE expression COMMA expression ( COMMA expression )? CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('REGEX'),self::$FOLLOW_REGEX_in_regexExpression1889); 
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_regexExpression1891); 
            $this->pushFollow(self::$FOLLOW_expression_in_regexExpression1893);
            $this->expression();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_regexExpression1895); 
            $this->pushFollow(self::$FOLLOW_expression_in_regexExpression1897);
            $this->expression();

            $this->state->_fsp--;

            // Sparql11query.g:518:48: ( COMMA expression )? 
            $alt56=2;
            $LA56_0 = $this->input->LA(1);

            if ( ($LA56_0==$this->getToken('COMMA')) ) {
                $alt56=1;
            }
            switch ($alt56) {
                case 1 :
                    // Sparql11query.g:518:49: COMMA expression 
                    {
                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_regexExpression1900); 
                    $this->pushFollow(self::$FOLLOW_expression_in_regexExpression1902);
                    $this->expression();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_regexExpression1906); 

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
    // Sparql11query.g:523:1: iriRefOrFunction : iriRef ( argList )? ; 
    public function iriRefOrFunction(){
        try {
            // Sparql11query.g:524:3: ( iriRef ( argList )? ) 
            // Sparql11query.g:525:3: iriRef ( argList )? 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_iriRefOrFunction1924);
            $this->iriRef();

            $this->state->_fsp--;

            // Sparql11query.g:525:10: ( argList )? 
            $alt57=2;
            $LA57_0 = $this->input->LA(1);

            if ( ($LA57_0==$this->getToken('OPEN_BRACE')) ) {
                $alt57=1;
            }
            switch ($alt57) {
                case 1 :
                    // Sparql11query.g:525:10: argList 
                    {
                    $this->pushFollow(self::$FOLLOW_argList_in_iriRefOrFunction1926);
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
    // Sparql11query.g:530:1: rdfLiteral : string ( LANGTAG | ( REFERENCE iriRef ) )? ; 
    public function rdfLiteral(){
        try {
            // Sparql11query.g:531:3: ( string ( LANGTAG | ( REFERENCE iriRef ) )? ) 
            // Sparql11query.g:532:3: string ( LANGTAG | ( REFERENCE iriRef ) )? 
            {
            $this->pushFollow(self::$FOLLOW_string_in_rdfLiteral1945);
            $this->string();

            $this->state->_fsp--;

            // Sparql11query.g:533:3: ( LANGTAG | ( REFERENCE iriRef ) )? 
            $alt58=3;
            $LA58_0 = $this->input->LA(1);

            if ( ($LA58_0==$this->getToken('LANGTAG')) ) {
                $alt58=1;
            }
            else if ( ($LA58_0==$this->getToken('REFERENCE')) ) {
                $alt58=2;
            }
            switch ($alt58) {
                case 1 :
                    // Sparql11query.g:534:5: LANGTAG 
                    {
                    $this->match($this->input,$this->getToken('LANGTAG'),self::$FOLLOW_LANGTAG_in_rdfLiteral1955); 

                    }
                    break;
                case 2 :
                    // Sparql11query.g:535:7: ( REFERENCE iriRef ) 
                    {
                    // Sparql11query.g:535:7: ( REFERENCE iriRef ) 
                    // Sparql11query.g:535:8: REFERENCE iriRef 
                    {
                    $this->match($this->input,$this->getToken('REFERENCE'),self::$FOLLOW_REFERENCE_in_rdfLiteral1964); 
                    $this->pushFollow(self::$FOLLOW_iriRef_in_rdfLiteral1966);
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
    // Sparql11query.g:541:1: numericLiteral : ( numericLiteralUnsigned | numericLiteralPositive | numericLiteralNegative ); 
    public function numericLiteral(){
        try {
            // Sparql11query.g:542:3: ( numericLiteralUnsigned | numericLiteralPositive | numericLiteralNegative ) 
            $alt59=3;
            $LA59 = $this->input->LA(1);
            if($this->getToken('INTEGER')== $LA59||$this->getToken('DECIMAL')== $LA59||$this->getToken('DOUBLE')== $LA59)
                {
                $alt59=1;
                }
            else if($this->getToken('INTEGER_POSITIVE')== $LA59||$this->getToken('DECIMAL_POSITIVE')== $LA59||$this->getToken('DOUBLE_POSITIVE')== $LA59)
                {
                $alt59=2;
                }
            else if($this->getToken('INTEGER_NEGATIVE')== $LA59||$this->getToken('DECIMAL_NEGATIVE')== $LA59||$this->getToken('DOUBLE_NEGATIVE')== $LA59)
                {
                $alt59=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 59, 0, $this->input);

                throw $nvae;
            }

            switch ($alt59) {
                case 1 :
                    // Sparql11query.g:543:3: numericLiteralUnsigned 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralUnsigned_in_numericLiteral1990);
                    $this->numericLiteralUnsigned();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:544:5: numericLiteralPositive 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralPositive_in_numericLiteral1996);
                    $this->numericLiteralPositive();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11query.g:545:5: numericLiteralNegative 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralNegative_in_numericLiteral2002);
                    $this->numericLiteralNegative();

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
    // $ANTLR end "numericLiteral"


    // $ANTLR start "numericLiteralUnsigned"
    // Sparql11query.g:550:1: numericLiteralUnsigned : ( INTEGER | DECIMAL | DOUBLE ); 
    public function numericLiteralUnsigned(){
        try {
            // Sparql11query.g:551:3: ( INTEGER | DECIMAL | DOUBLE ) 
            // Sparql11query.g: 
            {
            if ( $this->input->LA(1)==$this->getToken('INTEGER')||$this->input->LA(1)==$this->getToken('DECIMAL')||$this->input->LA(1)==$this->getToken('DOUBLE') ) {
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
    // $ANTLR end "numericLiteralUnsigned"


    // $ANTLR start "numericLiteralPositive"
    // Sparql11query.g:559:1: numericLiteralPositive : ( INTEGER_POSITIVE | DECIMAL_POSITIVE | DOUBLE_POSITIVE ); 
    public function numericLiteralPositive(){
        try {
            // Sparql11query.g:560:3: ( INTEGER_POSITIVE | DECIMAL_POSITIVE | DOUBLE_POSITIVE ) 
            // Sparql11query.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('INTEGER_POSITIVE') && $this->input->LA(1)<=$this->getToken('DOUBLE_POSITIVE')) ) {
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
    // $ANTLR end "numericLiteralPositive"


    // $ANTLR start "numericLiteralNegative"
    // Sparql11query.g:568:1: numericLiteralNegative : ( INTEGER_NEGATIVE | DECIMAL_NEGATIVE | DOUBLE_NEGATIVE ); 
    public function numericLiteralNegative(){
        try {
            // Sparql11query.g:569:3: ( INTEGER_NEGATIVE | DECIMAL_NEGATIVE | DOUBLE_NEGATIVE ) 
            // Sparql11query.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('INTEGER_NEGATIVE') && $this->input->LA(1)<=$this->getToken('DOUBLE_NEGATIVE')) ) {
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
    // $ANTLR end "numericLiteralNegative"


    // $ANTLR start "booleanLiteral"
    // Sparql11query.g:577:1: booleanLiteral : ( TRUE | FALSE ); 
    public function booleanLiteral(){
        try {
            // Sparql11query.g:578:3: ( TRUE | FALSE ) 
            // Sparql11query.g: 
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
    // Sparql11query.g:585:1: string : ( STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 ); 
    public function string(){
        try {
            // Sparql11query.g:586:3: ( STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 ) 
            // Sparql11query.g: 
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
    // Sparql11query.g:595:1: iriRef : ( IRI_REF | prefixedName ); 
    public function iriRef(){
        try {
            // Sparql11query.g:596:3: ( IRI_REF | prefixedName ) 
            $alt60=2;
            $LA60_0 = $this->input->LA(1);

            if ( ($LA60_0==$this->getToken('IRI_REF')) ) {
                $alt60=1;
            }
            else if ( ($LA60_0==$this->getToken('PNAME_NS')||$LA60_0==$this->getToken('PNAME_LN')) ) {
                $alt60=2;
            }
            else {
                $nvae = new NoViableAltException("", 60, 0, $this->input);

                throw $nvae;
            }
            switch ($alt60) {
                case 1 :
                    // Sparql11query.g:597:3: IRI_REF 
                    {
                    $this->match($this->input,$this->getToken('IRI_REF'),self::$FOLLOW_IRI_REF_in_iriRef2170); 

                    }
                    break;
                case 2 :
                    // Sparql11query.g:598:5: prefixedName 
                    {
                    $this->pushFollow(self::$FOLLOW_prefixedName_in_iriRef2176);
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
    // Sparql11query.g:603:1: prefixedName : ( PNAME_LN | PNAME_NS ); 
    public function prefixedName(){
        try {
            // Sparql11query.g:604:3: ( PNAME_LN | PNAME_NS ) 
            // Sparql11query.g: 
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
    // Sparql11query.g:611:1: blankNode : ( BLANK_NODE_LABEL | OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE ); 
    public function blankNode(){
        try {
            // Sparql11query.g:612:3: ( BLANK_NODE_LABEL | OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE ) 
            $alt62=2;
            $LA62_0 = $this->input->LA(1);

            if ( ($LA62_0==$this->getToken('BLANK_NODE_LABEL')) ) {
                $alt62=1;
            }
            else if ( ($LA62_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt62=2;
            }
            else {
                $nvae = new NoViableAltException("", 62, 0, $this->input);

                throw $nvae;
            }
            switch ($alt62) {
                case 1 :
                    // Sparql11query.g:613:3: BLANK_NODE_LABEL 
                    {
                    $this->match($this->input,$this->getToken('BLANK_NODE_LABEL'),self::$FOLLOW_BLANK_NODE_LABEL_in_blankNode2218); 

                    }
                    break;
                case 2 :
                    // Sparql11query.g:614:5: OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2224); 
                    // Sparql11query.g:614:23: ( WS )* 
                    //loop61:
                    do {
                        $alt61=2;
                        $LA61_0 = $this->input->LA(1);

                        if ( ($LA61_0==$this->getToken('WS')) ) {
                            $alt61=1;
                        }


                        switch ($alt61) {
                    	case 1 :
                    	    // Sparql11query.g:614:24: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_blankNode2227); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop61;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2231); 

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


    // $ANTLR start "subSelect"
    // Sparql11query.g:619:1: subSelect : project whereClause solutionModifier ; 
    public function subSelect(){
        try {
            // Sparql11query.g:620:3: ( project whereClause solutionModifier ) 
            // Sparql11query.g:621:3: project whereClause solutionModifier 
            {
            $this->pushFollow(self::$FOLLOW_project_in_subSelect2248);
            $this->project();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_whereClause_in_subSelect2250);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_subSelect2252);
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
    // $ANTLR end "subSelect"


    // $ANTLR start "groupGraphPattern"
    // Sparql11query.g:625:1: groupGraphPattern : OPEN_CURLY_BRACE ( subSelect | groupGraphPatternSub ) CLOSE_CURLY_BRACE ; 
    public function groupGraphPattern(){
        try {
            // Sparql11query.g:626:3: ( OPEN_CURLY_BRACE ( subSelect | groupGraphPatternSub ) CLOSE_CURLY_BRACE ) 
            // Sparql11query.g:627:3: OPEN_CURLY_BRACE ( subSelect | groupGraphPatternSub ) CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern2269); 
            // Sparql11query.g:628:3: ( subSelect | groupGraphPatternSub ) 
            $alt63=2;
            $LA63_0 = $this->input->LA(1);

            if ( ($LA63_0==$this->getToken('SELECT')) ) {
                $alt63=1;
            }
            else if ( (($LA63_0>=$this->getToken('OPTIONAL') && $LA63_0<=$this->getToken('GRAPH'))||$LA63_0==$this->getToken('FILTER')||($LA63_0>=$this->getToken('TRUE') && $LA63_0<=$this->getToken('FALSE'))||($LA63_0>=$this->getToken('OPEN_CURLY_BRACE') && $LA63_0<=$this->getToken('IRI_REF'))||$LA63_0==$this->getToken('PNAME_NS')||$LA63_0==$this->getToken('PNAME_LN')||($LA63_0>=$this->getToken('VAR1') && $LA63_0<=$this->getToken('VAR2'))||$LA63_0==$this->getToken('INTEGER')||$LA63_0==$this->getToken('DECIMAL')||$LA63_0==$this->getToken('DOUBLE')||($LA63_0>=$this->getToken('INTEGER_POSITIVE') && $LA63_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA63_0>=$this->getToken('STRING_LITERAL1') && $LA63_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA63_0==$this->getToken('BLANK_NODE_LABEL')||$LA63_0==$this->getToken('OPEN_BRACE')||$LA63_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt63=2;
            }
            else {
                $nvae = new NoViableAltException("", 63, 0, $this->input);

                throw $nvae;
            }
            switch ($alt63) {
                case 1 :
                    // Sparql11query.g:629:5: subSelect 
                    {
                    $this->pushFollow(self::$FOLLOW_subSelect_in_groupGraphPattern2279);
                    $this->subSelect();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11query.g:630:7: groupGraphPatternSub 
                    {
                    $this->pushFollow(self::$FOLLOW_groupGraphPatternSub_in_groupGraphPattern2287);
                    $this->groupGraphPatternSub();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern2295); 

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


    // $ANTLR start "groupGraphPatternSub"
    // Sparql11query.g:637:1: groupGraphPatternSub : ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* ; 
    public function groupGraphPatternSub(){
        try {
            // Sparql11query.g:638:3: ( ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* ) 
            // Sparql11query.g:639:3: ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* 
            {
            // Sparql11query.g:639:3: ( triplesBlock )? 
            $alt64=2;
            $LA64_0 = $this->input->LA(1);

            if ( (($LA64_0>=$this->getToken('TRUE') && $LA64_0<=$this->getToken('FALSE'))||$LA64_0==$this->getToken('IRI_REF')||$LA64_0==$this->getToken('PNAME_NS')||$LA64_0==$this->getToken('PNAME_LN')||($LA64_0>=$this->getToken('VAR1') && $LA64_0<=$this->getToken('VAR2'))||$LA64_0==$this->getToken('INTEGER')||$LA64_0==$this->getToken('DECIMAL')||$LA64_0==$this->getToken('DOUBLE')||($LA64_0>=$this->getToken('INTEGER_POSITIVE') && $LA64_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA64_0>=$this->getToken('STRING_LITERAL1') && $LA64_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA64_0==$this->getToken('BLANK_NODE_LABEL')||$LA64_0==$this->getToken('OPEN_BRACE')||$LA64_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt64=1;
            }
            switch ($alt64) {
                case 1 :
                    // Sparql11query.g:639:3: triplesBlock 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPatternSub2313);
                    $this->triplesBlock();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Sparql11query.g:640:3: ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* 
            //loop68:
            do {
                $alt68=2;
                $LA68_0 = $this->input->LA(1);

                if ( (($LA68_0>=$this->getToken('OPTIONAL') && $LA68_0<=$this->getToken('GRAPH'))||$LA68_0==$this->getToken('FILTER')||$LA68_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                    $alt68=1;
                }


                switch ($alt68) {
            	case 1 :
            	    // Sparql11query.g:641:5: ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? 
            	    {
            	    // Sparql11query.g:641:5: ( graphPatternNotTriples | filter ) 
            	    $alt65=2;
            	    $LA65_0 = $this->input->LA(1);

            	    if ( (($LA65_0>=$this->getToken('OPTIONAL') && $LA65_0<=$this->getToken('GRAPH'))||$LA65_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
            	        $alt65=1;
            	    }
            	    else if ( ($LA65_0==$this->getToken('FILTER')) ) {
            	        $alt65=2;
            	    }
            	    else {
            	        $nvae = new NoViableAltException("", 65, 0, $this->input);

            	        throw $nvae;
            	    }
            	    switch ($alt65) {
            	        case 1 :
            	            // Sparql11query.g:642:7: graphPatternNotTriples 
            	            {
            	            $this->pushFollow(self::$FOLLOW_graphPatternNotTriples_in_groupGraphPatternSub2332);
            	            $this->graphPatternNotTriples();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 2 :
            	            // Sparql11query.g:643:9: filter 
            	            {
            	            $this->pushFollow(self::$FOLLOW_filter_in_groupGraphPatternSub2342);
            	            $this->filter();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }

            	    // Sparql11query.g:645:5: ( DOT )? 
            	    $alt66=2;
            	    $LA66_0 = $this->input->LA(1);

            	    if ( ($LA66_0==$this->getToken('DOT')) ) {
            	        $alt66=1;
            	    }
            	    switch ($alt66) {
            	        case 1 :
            	            // Sparql11query.g:645:5: DOT 
            	            {
            	            $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_groupGraphPatternSub2354); 

            	            }
            	            break;

            	    }

            	    // Sparql11query.g:645:10: ( triplesBlock )? 
            	    $alt67=2;
            	    $LA67_0 = $this->input->LA(1);

            	    if ( (($LA67_0>=$this->getToken('TRUE') && $LA67_0<=$this->getToken('FALSE'))||$LA67_0==$this->getToken('IRI_REF')||$LA67_0==$this->getToken('PNAME_NS')||$LA67_0==$this->getToken('PNAME_LN')||($LA67_0>=$this->getToken('VAR1') && $LA67_0<=$this->getToken('VAR2'))||$LA67_0==$this->getToken('INTEGER')||$LA67_0==$this->getToken('DECIMAL')||$LA67_0==$this->getToken('DOUBLE')||($LA67_0>=$this->getToken('INTEGER_POSITIVE') && $LA67_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA67_0>=$this->getToken('STRING_LITERAL1') && $LA67_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA67_0==$this->getToken('BLANK_NODE_LABEL')||$LA67_0==$this->getToken('OPEN_BRACE')||$LA67_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
            	        $alt67=1;
            	    }
            	    switch ($alt67) {
            	        case 1 :
            	            // Sparql11query.g:645:10: triplesBlock 
            	            {
            	            $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPatternSub2357);
            	            $this->triplesBlock();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop68;
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
    // $ANTLR end "groupGraphPatternSub"


    // $ANTLR start "project"
    // Sparql11query.g:651:1: project : SELECT ( DISTINCT | REDUCED )? ( ASTERISK | ( variable | builtInCall | functionCall | ( OPEN_BRACE expression ( AS variable )? CLOSE_BRACE )+ ) ) ; 
    public function project(){
        try {
            // Sparql11query.g:652:3: ( SELECT ( DISTINCT | REDUCED )? ( ASTERISK | ( variable | builtInCall | functionCall | ( OPEN_BRACE expression ( AS variable )? CLOSE_BRACE )+ ) ) ) 
            // Sparql11query.g:653:3: SELECT ( DISTINCT | REDUCED )? ( ASTERISK | ( variable | builtInCall | functionCall | ( OPEN_BRACE expression ( AS variable )? CLOSE_BRACE )+ ) ) 
            {
            $this->match($this->input,$this->getToken('SELECT'),self::$FOLLOW_SELECT_in_project2381); 
            // Sparql11query.g:654:3: ( DISTINCT | REDUCED )? 
            $alt69=2;
            $LA69_0 = $this->input->LA(1);

            if ( (($LA69_0>=$this->getToken('DISTINCT') && $LA69_0<=$this->getToken('REDUCED'))) ) {
                $alt69=1;
            }
            switch ($alt69) {
                case 1 :
                    // Sparql11query.g: 
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

            // Sparql11query.g:658:3: ( ASTERISK | ( variable | builtInCall | functionCall | ( OPEN_BRACE expression ( AS variable )? CLOSE_BRACE )+ ) ) 
            $alt73=2;
            $LA73_0 = $this->input->LA(1);

            if ( ($LA73_0==$this->getToken('ASTERISK')) ) {
                $alt73=1;
            }
            else if ( ($LA73_0==$this->getToken('COALESCE')||$LA73_0==$this->getToken('IF')||($LA73_0>=$this->getToken('STR') && $LA73_0<=$this->getToken('REGEX'))||$LA73_0==$this->getToken('IRI_REF')||$LA73_0==$this->getToken('PNAME_NS')||$LA73_0==$this->getToken('PNAME_LN')||($LA73_0>=$this->getToken('VAR1') && $LA73_0<=$this->getToken('VAR2'))||$LA73_0==$this->getToken('OPEN_BRACE')) ) {
                $alt73=2;
            }
            else {
                $nvae = new NoViableAltException("", 73, 0, $this->input);

                throw $nvae;
            }
            switch ($alt73) {
                case 1 :
                    // Sparql11query.g:659:5: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_project2414); 

                    }
                    break;
                case 2 :
                    // Sparql11query.g:661:5: ( variable | builtInCall | functionCall | ( OPEN_BRACE expression ( AS variable )? CLOSE_BRACE )+ ) 
                    {
                    // Sparql11query.g:661:5: ( variable | builtInCall | functionCall | ( OPEN_BRACE expression ( AS variable )? CLOSE_BRACE )+ ) 
                    $alt72=4;
                    $LA72 = $this->input->LA(1);
                    if($this->getToken('VAR1')== $LA72||$this->getToken('VAR2')== $LA72)
                        {
                        $alt72=1;
                        }
                    else if($this->getToken('COALESCE')== $LA72||$this->getToken('IF')== $LA72||$this->getToken('STR')== $LA72||$this->getToken('LANG')== $LA72||$this->getToken('LANGMATCHES')== $LA72||$this->getToken('DATATYPE')== $LA72||$this->getToken('BOUND')== $LA72||$this->getToken('SAMETERM')== $LA72||$this->getToken('ISIRI')== $LA72||$this->getToken('ISURI')== $LA72||$this->getToken('ISBLANK')== $LA72||$this->getToken('ISLITERAL')== $LA72||$this->getToken('REGEX')== $LA72)
                        {
                        $alt72=2;
                        }
                    else if($this->getToken('IRI_REF')== $LA72||$this->getToken('PNAME_NS')== $LA72||$this->getToken('PNAME_LN')== $LA72)
                        {
                        $alt72=3;
                        }
                    else if($this->getToken('OPEN_BRACE')== $LA72)
                        {
                        $alt72=4;
                        }
                    else{
                        $nvae =
                            new NoViableAltException("", 72, 0, $this->input);

                        throw $nvae;
                    }

                    switch ($alt72) {
                        case 1 :
                            // Sparql11query.g:662:7: variable 
                            {
                            $this->pushFollow(self::$FOLLOW_variable_in_project2434);
                            $this->variable();

                            $this->state->_fsp--;


                            }
                            break;
                        case 2 :
                            // Sparql11query.g:663:9: builtInCall 
                            {
                            $this->pushFollow(self::$FOLLOW_builtInCall_in_project2444);
                            $this->builtInCall();

                            $this->state->_fsp--;


                            }
                            break;
                        case 3 :
                            // Sparql11query.g:664:9: functionCall 
                            {
                            $this->pushFollow(self::$FOLLOW_functionCall_in_project2454);
                            $this->functionCall();

                            $this->state->_fsp--;


                            }
                            break;
                        case 4 :
                            // Sparql11query.g:665:9: ( OPEN_BRACE expression ( AS variable )? CLOSE_BRACE )+ 
                            {
                            // Sparql11query.g:665:9: ( OPEN_BRACE expression ( AS variable )? CLOSE_BRACE )+ 
                            $cnt71=0;
                            //loop71:
                            do {
                                $alt71=2;
                                $LA71_0 = $this->input->LA(1);

                                if ( ($LA71_0==$this->getToken('OPEN_BRACE')) ) {
                                    $alt71=1;
                                }


                                switch ($alt71) {
                            	case 1 :
                            	    // Sparql11query.g:665:10: OPEN_BRACE expression ( AS variable )? CLOSE_BRACE 
                            	    {
                            	    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_project2465); 
                            	    $this->pushFollow(self::$FOLLOW_expression_in_project2467);
                            	    $this->expression();

                            	    $this->state->_fsp--;

                            	    // Sparql11query.g:665:32: ( AS variable )? 
                            	    $alt70=2;
                            	    $LA70_0 = $this->input->LA(1);

                            	    if ( ($LA70_0==$this->getToken('AS')) ) {
                            	        $alt70=1;
                            	    }
                            	    switch ($alt70) {
                            	        case 1 :
                            	            // Sparql11query.g:665:33: AS variable 
                            	            {
                            	            $this->match($this->input,$this->getToken('AS'),self::$FOLLOW_AS_in_project2470); 
                            	            $this->pushFollow(self::$FOLLOW_variable_in_project2472);
                            	            $this->variable();

                            	            $this->state->_fsp--;


                            	            }
                            	            break;

                            	    }

                            	    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_project2476); 

                            	    }
                            	    break;

                            	default :
                            	    if ( $cnt71 >= 1 ) break 2;//loop71;
                                        $eee =
                                            new EarlyExitException(71, $this->input);
                                        throw $eee;
                                }
                                $cnt71++;
                            } while (true);


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
    // $ANTLR end "project"

    // Delegated rules


    
}

 



Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_prologue_in_query1122 = new Set(array(24, 27, 28, 29));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_selectQuery_in_query1132 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_constructQuery_in_query1140 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_describeQuery_in_query1148 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_askQuery_in_query1156 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_baseDecl_in_prologue78 = new Set(array(1, 22));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_prefixDecl_in_prologue81 = new Set(array(1, 22));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_BASE_in_baseDecl100 = new Set(array(63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRef_in_baseDecl102 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_PREFIX_in_prefixDecl120 = new Set(array(65));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_PNAME_NS_in_prefixDecl122 = new Set(array(63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRef_in_prefixDecl124 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_SELECT_in_selectQuery142 = new Set(array(25, 26, 69, 70, 102));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_selectQuery146 = new Set(array(69, 70, 102));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_variable_in_selectQuery175 = new Set(array(30, 32, 61, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ASTERISK_in_selectQuery184 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_datasetClause_in_selectQuery192 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_whereClause_in_selectQuery195 = new Set(array(33, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_solutionModifier_in_selectQuery197 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CONSTRUCT_in_constructQuery215 = new Set(array(61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_constructTemplate_in_constructQuery217 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_datasetClause_in_constructQuery219 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_whereClause_in_constructQuery222 = new Set(array(33, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_solutionModifier_in_constructQuery224 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_DESCRIBE_in_describeQuery242 = new Set(array(63, 65, 67, 69, 70, 102));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_varOrIRIref_in_describeQuery252 = new Set(array(30, 32, 33, 38, 39, 61, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ASTERISK_in_describeQuery261 = new Set(array(30, 32, 33, 38, 39, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_datasetClause_in_describeQuery269 = new Set(array(30, 32, 33, 38, 39, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_whereClause_in_describeQuery272 = new Set(array(33, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_solutionModifier_in_describeQuery275 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ASK_in_askQuery293 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_datasetClause_in_askQuery295 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_whereClause_in_askQuery298 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_FROM_in_datasetClause316 = new Set(array(31, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_defaultGraphClause_in_datasetClause326 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_namedGraphClause_in_datasetClause334 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_sourceSelector_in_defaultGraphClause356 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_NAMED_in_namedGraphClause374 = new Set(array(63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_sourceSelector_in_namedGraphClause376 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRef_in_sourceSelector394 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_WHERE_in_whereClause412 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_groupGraphPattern_in_whereClause415 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_orderClause_in_solutionModifier433 = new Set(array(1, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_limitOffsetClauses_in_solutionModifier436 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_limitClause_in_limitOffsetClauses455 = new Set(array(1, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_offsetClause_in_limitOffsetClauses457 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_offsetClause_in_limitOffsetClauses464 = new Set(array(1, 38));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_limitClause_in_limitOffsetClauses466 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ORDER_in_orderClause485 = new Set(array(35));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_BY_in_orderClause487 = new Set(array(18, 20, 36, 37, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 63, 65, 67, 69, 70, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_orderCondition_in_orderClause489 = new Set(array(1, 18, 20, 36, 37, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 63, 65, 67, 69, 70, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_orderCondition514 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_brackettedExpression_in_orderCondition544 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_constraint_in_orderCondition562 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_variable_in_orderCondition570 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_LIMIT_in_limitClause592 = new Set(array(73));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_INTEGER_in_limitClause594 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OFFSET_in_offsetClause612 = new Set(array(73));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_INTEGER_in_offsetClause614 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_triplesSameSubject_in_triplesBlock637 = new Set(array(1, 74));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_DOT_in_triplesBlock640 = new Set(array(1, 57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_triplesBlock_in_triplesBlock642 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_optionalGraphPattern_in_graphPatternNotTriples663 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples669 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_graphGraphPattern_in_graphPatternNotTriples675 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPTIONAL_in_optionalGraphPattern693 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_groupGraphPattern_in_optionalGraphPattern695 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_GRAPH_in_graphGraphPattern713 = new Set(array(63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_varOrIRIref_in_graphGraphPattern715 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_groupGraphPattern_in_graphGraphPattern717 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern735 = new Set(array(1, 42));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_UNION_in_groupOrUnionGraphPattern738 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern740 = new Set(array(1, 42));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_FILTER_in_filter760 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 63, 65, 67, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_constraint_in_filter762 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_brackettedExpression_in_constraint780 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_builtInCall_in_constraint786 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_functionCall_in_constraint792 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRef_in_functionCall810 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_argList_in_functionCall812 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_argList830 = new Set(array(92, 108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_WS_in_argList832 = new Set(array(92, 108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_argList835 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_argList841 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_argList843 = new Set(array(103, 108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COMMA_in_argList846 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_argList848 = new Set(array(103, 108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_argList852 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate870 = new Set(array(57, 58, 62, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_constructTriples_in_constructTemplate872 = new Set(array(62));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate875 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_triplesSameSubject_in_constructTriples893 = new Set(array(1, 74));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_DOT_in_constructTriples896 = new Set(array(1, 57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_constructTriples_in_constructTriples898 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_varOrTerm_in_triplesSameSubject919 = new Set(array(44, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_propertyListNotEmpty_in_triplesSameSubject921 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_triplesNode_in_triplesSameSubject927 = new Set(array(44, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_propertyList_in_triplesSameSubject929 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_verb_in_propertyListNotEmpty947 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_objectList_in_propertyListNotEmpty949 = new Set(array(1, 101));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_SEMICOLON_in_propertyListNotEmpty952 = new Set(array(1, 44, 63, 65, 67, 69, 70, 101));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_verb_in_propertyListNotEmpty955 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_objectList_in_propertyListNotEmpty957 = new Set(array(1, 101));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_propertyListNotEmpty_in_propertyList979 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_object_in_objectList998 = new Set(array(1, 103));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COMMA_in_objectList1001 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_object_in_objectList1003 = new Set(array(1, 103));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_graphNode_in_object1023 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_varOrIRIref_in_verb1041 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_A_in_verb1047 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_collection_in_triplesNode1065 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_blankNodePropertyList_in_triplesNode1071 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1089 = new Set(array(44, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1091 = new Set(array(113));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1093 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_collection1111 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_graphNode_in_collection1113 = new Set(array(57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 108, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_collection1116 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_varOrTerm_in_graphNode1134 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_triplesNode_in_graphNode1140 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_variable_in_varOrTerm1158 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_graphTerm_in_varOrTerm1164 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_variable_in_varOrIRIref1182 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRef_in_varOrIRIref1188 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_variable0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRef_in_graphTerm1230 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_rdfLiteral_in_graphTerm1236 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericLiteral_in_graphTerm1242 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_booleanLiteral_in_graphTerm1248 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_blankNode_in_graphTerm1254 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_graphTerm1260 = new Set(array(92, 108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_WS_in_graphTerm1262 = new Set(array(92, 108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_graphTerm1265 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_conditionalOrExpression_in_expression1283 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1301 = new Set(array(1, 99));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OR_in_conditionalOrExpression1304 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1306 = new Set(array(1, 99));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_valueLogical_in_conditionalAndExpression1326 = new Set(array(1, 98));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_AND_in_conditionalAndExpression1329 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_valueLogical_in_conditionalAndExpression1331 = new Set(array(1, 98));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_relationalExpression_in_valueLogical1351 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericExpression_in_relationalExpression1369 = new Set(array(1, 59, 60, 106, 109, 110, 111));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_EQUAL_in_relationalExpression1379 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericExpression_in_relationalExpression1381 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_NOT_EQUAL_in_relationalExpression1389 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericExpression_in_relationalExpression1391 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_LESS_in_relationalExpression1399 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericExpression_in_relationalExpression1401 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_GREATER_in_relationalExpression1409 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericExpression_in_relationalExpression1411 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_LESS_EQUAL_in_relationalExpression1419 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericExpression_in_relationalExpression1421 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_GREATER_EQUAL_in_relationalExpression1429 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericExpression_in_relationalExpression1431 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_additiveExpression_in_numericExpression1454 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_multiplicativeExpression_in_additiveExpression1472 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_PLUS_in_additiveExpression1482 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_multiplicativeExpression_in_additiveExpression1484 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_MINUS_in_additiveExpression1492 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_multiplicativeExpression_in_additiveExpression1494 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericLiteralPositive_in_additiveExpression1502 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericLiteralNegative_in_additiveExpression1510 = new Set(array(1, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_unaryExpression_in_multiplicativeExpression1533 = new Set(array(1, 102, 105));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ASTERISK_in_multiplicativeExpression1543 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_unaryExpression_in_multiplicativeExpression1545 = new Set(array(1, 102, 105));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_DIVIDE_in_multiplicativeExpression1553 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_unaryExpression_in_multiplicativeExpression1555 = new Set(array(1, 102, 105));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_NOT_SIGN_in_unaryExpression1578 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_primaryExpression_in_unaryExpression1580 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_PLUS_in_unaryExpression1586 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_primaryExpression_in_unaryExpression1588 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_MINUS_in_unaryExpression1594 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_primaryExpression_in_unaryExpression1596 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_primaryExpression_in_unaryExpression1602 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_brackettedExpression_in_primaryExpression1620 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_builtInCall_in_primaryExpression1626 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRefOrFunction_in_primaryExpression1632 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_rdfLiteral_in_primaryExpression1638 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericLiteral_in_primaryExpression1644 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_booleanLiteral_in_primaryExpression1650 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_variable_in_primaryExpression1656 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_brackettedExpression1674 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_brackettedExpression1676 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_brackettedExpression1678 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_STR_in_builtInCall1713 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1715 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1717 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1719 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_LANG_in_builtInCall1725 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1727 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1729 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1731 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_LANGMATCHES_in_builtInCall1737 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1739 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1741 = new Set(array(103));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COMMA_in_builtInCall1743 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1745 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1747 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_DATATYPE_in_builtInCall1753 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1755 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1757 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1759 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_BOUND_in_builtInCall1765 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1767 = new Set(array(69, 70));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_variable_in_builtInCall1769 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1771 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COALESCE_in_builtInCall1777 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_argList_in_builtInCall1779 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_IF_in_builtInCall1785 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1787 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1789 = new Set(array(103));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COMMA_in_builtInCall1791 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1793 = new Set(array(103));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COMMA_in_builtInCall1795 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1797 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1799 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_SAMETERM_in_builtInCall1805 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1807 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1809 = new Set(array(103));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COMMA_in_builtInCall1811 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1813 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1815 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ISIRI_in_builtInCall1821 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1823 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1825 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1827 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ISURI_in_builtInCall1833 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1835 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1837 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1839 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ISBLANK_in_builtInCall1845 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1847 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1849 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1851 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ISLITERAL_in_builtInCall1857 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_builtInCall1859 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_builtInCall1861 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_builtInCall1863 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_regexExpression_in_builtInCall1869 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_REGEX_in_regexExpression1889 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_regexExpression1891 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_regexExpression1893 = new Set(array(103));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COMMA_in_regexExpression1895 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_regexExpression1897 = new Set(array(103, 108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_COMMA_in_regexExpression1900 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_regexExpression1902 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_regexExpression1906 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRef_in_iriRefOrFunction1924 = new Set(array(1, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_argList_in_iriRefOrFunction1926 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_string_in_rdfLiteral1945 = new Set(array(1, 72, 97));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_LANGTAG_in_rdfLiteral1955 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_REFERENCE_in_rdfLiteral1964 = new Set(array(63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_iriRef_in_rdfLiteral1966 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericLiteralUnsigned_in_numericLiteral1990 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericLiteralPositive_in_numericLiteral1996 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_numericLiteralNegative_in_numericLiteral2002 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_numericLiteralUnsigned0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_numericLiteralPositive0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_numericLiteralNegative0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_booleanLiteral0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_string0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_IRI_REF_in_iriRef2170 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_prefixedName_in_iriRef2176 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_prefixedName0 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_BLANK_NODE_LABEL_in_blankNode2218 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2224 = new Set(array(92, 113));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_WS_in_blankNode2227 = new Set(array(92, 113));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2231 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_project_in_subSelect2248 = new Set(array(30, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_whereClause_in_subSelect2250 = new Set(array(33, 38, 39));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_solutionModifier_in_subSelect2252 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern2269 = new Set(array(24, 30, 32, 40, 41, 43, 57, 58, 61, 62, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_subSelect_in_groupGraphPattern2279 = new Set(array(62));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_groupGraphPatternSub_in_groupGraphPattern2287 = new Set(array(62));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern2295 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_triplesBlock_in_groupGraphPatternSub2313 = new Set(array(1, 30, 32, 40, 41, 43, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_graphPatternNotTriples_in_groupGraphPatternSub2332 = new Set(array(1, 30, 32, 40, 41, 43, 57, 58, 61, 63, 65, 67, 69, 70, 73, 74, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_filter_in_groupGraphPatternSub2342 = new Set(array(1, 30, 32, 40, 41, 43, 57, 58, 61, 63, 65, 67, 69, 70, 73, 74, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_DOT_in_groupGraphPatternSub2354 = new Set(array(1, 30, 32, 40, 41, 43, 57, 58, 61, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_triplesBlock_in_groupGraphPatternSub2357 = new Set(array(1, 30, 32, 40, 41, 43, 61));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_SELECT_in_project2381 = new Set(array(18, 20, 25, 26, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 63, 65, 67, 69, 70, 102, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_set_in_project2385 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 63, 65, 67, 69, 70, 102, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_ASTERISK_in_project2414 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_variable_in_project2434 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_builtInCall_in_project2444 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_functionCall_in_project2454 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_OPEN_BRACE_in_project2465 = new Set(array(18, 20, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_expression_in_project2467 = new Set(array(45, 108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_AS_in_project2470 = new Set(array(69, 70));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_variable_in_project2472 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query::$FOLLOW_CLOSE_BRACE_in_project2476 = new Set(array(1, 107));

?>