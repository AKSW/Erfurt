<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 Test.g 2009-11-30 17:01:47


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class TestParser extends AntlrParser {
    public static $tokenNames = array(
        "<invalid>", "<EOR>", "<DOWN>", "<UP>", "LESS", "GREATER", "OPEN_CURLY_BRACE", "CLOSE_CURLY_BRACE", "IRI_REF", "EOL", "WS", "BASE", "PREFIX", "SELECT", "DISTINCT", "REDUCED", "CONSTRUCT", "DESCRIBE", "ASK", "FROM", "NAMED", "WHERE", "ORDER", "BY", "ASC", "DESC", "LIMIT", "OFFSET", "OPTIONAL", "GRAPH", "UNION", "FILTER", "A", "STR", "LANG", "LANGMATCHES", "DATATYPE", "BOUND", "SAMETERM", "ISIRI", "ISURI", "ISBLANK", "ISLITERAL", "REGEX", "TRUE", "FALSE", "PNAME_NS", "PN_LOCAL", "PNAME_LN", "PN_PREFIX", "PN_CHARS_BASE", "PN_CHARS", "DOT", "PN_CHARS_U", "DIGIT", "VARNAME", "MINUS", "SEMICOLON", "PLUS", "ASTERISK", "COMMA", "NOT", "DIVIDE", "EQUAL", "VAR1", "VAR2", "ECHAR", "STRING_LITERAL1", "STRING_LITERAL2", "STRING_LITERAL_LONG1", "STRING_LITERAL_LONG2", "OPEN_BRACE", "CLOSE_BRACE", "REFERENCE", "LESS_EQUAL", "GREATER_EQUAL", "NOT_EQUAL", "AND", "OR", "BLANK_NODE_LABEL", "LANGTAG", "INTEGER", "DECIMAL", "EXPONENT", "DOUBLE", "INTEGER_POSITIVE", "DECIMAL_POSITIVE", "DOUBLE_POSITIVE", "INTEGER_NEGATIVE", "DECIMAL_NEGATIVE", "DOUBLE_NEGATIVE", "OPEN_SQUARE_BRACE", "CLOSE_SQUARE_BRACE", "COMMENT"
    );
    public $PREFIX=12;
    public $EXPONENT=83;
    public $CLOSE_SQUARE_BRACE=92;
    public $GRAPH=29;
    public $REGEX=43;
    public $PNAME_LN=48;
    public $CONSTRUCT=16;
    public $NOT=61;
    public $EOF=-1;
    public $VARNAME=55;
    public $ISLITERAL=42;
    public $GREATER=5;
    public $EOL=9;
    public $NOT_EQUAL=76;
    public $LESS=4;
    public $LANGMATCHES=35;
    public $DOUBLE=84;
    public $BASE=11;
    public $PN_CHARS_U=53;
    public $COMMENT=93;
    public $OPEN_CURLY_BRACE=6;
    public $SELECT=13;
    public $CLOSE_CURLY_BRACE=7;
    public $DOUBLE_POSITIVE=87;
    public $BOUND=37;
    public $DIVIDE=62;
    public $ISIRI=39;
    public $A=32;
    public $ASC=24;
    public $ASK=18;
    public $BLANK_NODE_LABEL=79;
    public $SEMICOLON=57;
    public $ISBLANK=41;
    public $WS=10;
    public $NAMED=20;
    public $INTEGER_POSITIVE=85;
    public $STRING_LITERAL2=68;
    public $OR=78;
    public $FILTER=31;
    public $DESCRIBE=17;
    public $STRING_LITERAL1=67;
    public $PN_CHARS=51;
    public $DATATYPE=36;
    public $LESS_EQUAL=74;
    public $DOUBLE_NEGATIVE=90;
    public $FROM=19;
    public $FALSE=45;
    public $DISTINCT=14;
    public $LANG=34;
    public $WHERE=21;
    public $IRI_REF=8;
    public $ORDER=22;
    public $LIMIT=26;
    public $AND=77;
    public $ASTERISK=59;
    public $ISURI=40;
    public $STR=33;
    public $SAMETERM=38;
    public $COMMA=60;
    public $OFFSET=27;
    public $EQUAL=63;
    public $DECIMAL_POSITIVE=86;
    public $PLUS=58;
    public $DIGIT=54;
    public $DOT=52;
    public $INTEGER=81;
    public $BY=23;
    public $REDUCED=15;
    public $INTEGER_NEGATIVE=88;
    public $PN_LOCAL=47;
    public $PNAME_NS=46;
    public $REFERENCE=73;
    public $CLOSE_BRACE=72;
    public $MINUS=56;
    public $TRUE=44;
    public $UNION=30;
    public $OPEN_SQUARE_BRACE=91;
    public $ECHAR=66;
    public $OPTIONAL=28;
    public $PN_CHARS_BASE=50;
    public $STRING_LITERAL_LONG2=70;
    public $DECIMAL=82;
    public $VAR1=64;
    public $VAR2=65;
    public $STRING_LITERAL_LONG1=69;
    public $DECIMAL_NEGATIVE=89;
    public $PN_PREFIX=49;
    public $DESC=25;
    public $OPEN_BRACE=71;
    public $GREATER_EQUAL=75;
    public $LANGTAG=80;

    // delegates
    // delegators

    
    static $FOLLOW_prologue_in_query37;
    static $FOLLOW_selectQuery_in_query41;
    static $FOLLOW_constructQuery_in_query45;
    static $FOLLOW_describeQuery_in_query49;
    static $FOLLOW_askQuery_in_query53;
    static $FOLLOW_EOF_in_query57;
    static $FOLLOW_baseDecl_in_prologue74;
    static $FOLLOW_prefixDecl_in_prologue77;
    static $FOLLOW_BASE_in_baseDecl95;
    static $FOLLOW_IRI_REF_in_baseDecl97;
    static $FOLLOW_PREFIX_in_prefixDecl114;
    static $FOLLOW_PNAME_NS_in_prefixDecl116;
    static $FOLLOW_IRI_REF_in_prefixDecl118;
    static $FOLLOW_SELECT_in_selectQuery135;
    static $FOLLOW_set_in_selectQuery137;
    static $FOLLOW_variable_in_selectQuery150;
    static $FOLLOW_ASTERISK_in_selectQuery155;
    static $FOLLOW_datasetClause_in_selectQuery159;
    static $FOLLOW_whereClause_in_selectQuery162;
    static $FOLLOW_solutionModifier_in_selectQuery164;
    static $FOLLOW_CONSTRUCT_in_constructQuery181;
    static $FOLLOW_constructTemplate_in_constructQuery183;
    static $FOLLOW_datasetClause_in_constructQuery185;
    static $FOLLOW_whereClause_in_constructQuery188;
    static $FOLLOW_solutionModifier_in_constructQuery190;
    static $FOLLOW_DESCRIBE_in_describeQuery207;
    static $FOLLOW_varOrIRIref_in_describeQuery211;
    static $FOLLOW_ASTERISK_in_describeQuery216;
    static $FOLLOW_datasetClause_in_describeQuery220;
    static $FOLLOW_whereClause_in_describeQuery223;
    static $FOLLOW_solutionModifier_in_describeQuery226;
    static $FOLLOW_ASK_in_askQuery243;
    static $FOLLOW_datasetClause_in_askQuery245;
    static $FOLLOW_whereClause_in_askQuery248;
    static $FOLLOW_FROM_in_datasetClause265;
    static $FOLLOW_defaultGraphClause_in_datasetClause269;
    static $FOLLOW_namedGraphClause_in_datasetClause273;
    static $FOLLOW_sourceSelector_in_defaultGraphClause292;
    static $FOLLOW_NAMED_in_namedGraphClause309;
    static $FOLLOW_sourceSelector_in_namedGraphClause311;
    static $FOLLOW_iriRef_in_sourceSelector328;
    static $FOLLOW_WHERE_in_whereClause345;
    static $FOLLOW_groupGraphPattern_in_whereClause348;
    static $FOLLOW_orderClause_in_solutionModifier365;
    static $FOLLOW_limitOffsetClauses_in_solutionModifier368;
    static $FOLLOW_limitClause_in_limitOffsetClauses388;
    static $FOLLOW_offsetClause_in_limitOffsetClauses390;
    static $FOLLOW_offsetClause_in_limitOffsetClauses395;
    static $FOLLOW_limitClause_in_limitOffsetClauses397;
    static $FOLLOW_ORDER_in_orderClause417;
    static $FOLLOW_BY_in_orderClause419;
    static $FOLLOW_orderCondition_in_orderClause421;
    static $FOLLOW_set_in_orderCondition441;
    static $FOLLOW_brackettedExpression_in_orderCondition451;
    static $FOLLOW_constraint_in_orderCondition463;
    static $FOLLOW_variable_in_orderCondition467;
    static $FOLLOW_LIMIT_in_limitClause486;
    static $FOLLOW_INTEGER_in_limitClause488;
    static $FOLLOW_OFFSET_in_offsetClause505;
    static $FOLLOW_INTEGER_in_offsetClause507;
    static $FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern524;
    static $FOLLOW_triplesBlock_in_groupGraphPattern526;
    static $FOLLOW_graphPatternNotTriples_in_groupGraphPattern533;
    static $FOLLOW_filter_in_groupGraphPattern537;
    static $FOLLOW_DOT_in_groupGraphPattern541;
    static $FOLLOW_triplesBlock_in_groupGraphPattern544;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern550;
    static $FOLLOW_triplesSameSubject_in_triplesBlock567;
    static $FOLLOW_DOT_in_triplesBlock571;
    static $FOLLOW_triplesBlock_in_triplesBlock573;
    static $FOLLOW_optionalGraphPattern_in_graphPatternNotTriples594;
    static $FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples598;
    static $FOLLOW_graphGraphPattern_in_graphPatternNotTriples602;
    static $FOLLOW_OPTIONAL_in_optionalGraphPattern619;
    static $FOLLOW_groupGraphPattern_in_optionalGraphPattern621;
    static $FOLLOW_GRAPH_in_graphGraphPattern638;
    static $FOLLOW_varOrIRIref_in_graphGraphPattern640;
    static $FOLLOW_groupGraphPattern_in_graphGraphPattern642;
    static $FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern659;
    static $FOLLOW_UNION_in_groupOrUnionGraphPattern663;
    static $FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern665;
    static $FOLLOW_FILTER_in_filter685;
    static $FOLLOW_constraint_in_filter687;
    static $FOLLOW_brackettedExpression_in_constraint704;
    static $FOLLOW_builtInCall_in_constraint708;
    static $FOLLOW_functionCall_in_constraint712;
    static $FOLLOW_iriRef_in_functionCall729;
    static $FOLLOW_argList_in_functionCall731;
    static $FOLLOW_OPEN_BRACE_in_argList750;
    static $FOLLOW_CLOSE_BRACE_in_argList752;
    static $FOLLOW_OPEN_BRACE_in_argList756;
    static $FOLLOW_expression_in_argList758;
    static $FOLLOW_COMMA_in_argList762;
    static $FOLLOW_expression_in_argList764;
    static $FOLLOW_CLOSE_BRACE_in_argList769;
    static $FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate788;
    static $FOLLOW_constructTriples_in_constructTemplate790;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate793;
    static $FOLLOW_triplesSameSubject_in_constructTriples810;
    static $FOLLOW_DOT_in_constructTriples814;
    static $FOLLOW_constructTriples_in_constructTriples816;
    static $FOLLOW_varOrTerm_in_triplesSameSubject837;
    static $FOLLOW_propertyListNotEmpty_in_triplesSameSubject839;
    static $FOLLOW_triplesNode_in_triplesSameSubject843;
    static $FOLLOW_propertyList_in_triplesSameSubject845;
    static $FOLLOW_verb_in_propertyListNotEmpty862;
    static $FOLLOW_objectList_in_propertyListNotEmpty864;
    static $FOLLOW_SEMICOLON_in_propertyListNotEmpty868;
    static $FOLLOW_verb_in_propertyListNotEmpty872;
    static $FOLLOW_objectList_in_propertyListNotEmpty874;
    static $FOLLOW_propertyListNotEmpty_in_propertyList897;
    static $FOLLOW_object_in_objectList915;
    static $FOLLOW_COMMA_in_objectList919;
    static $FOLLOW_object_in_objectList921;
    static $FOLLOW_graphNode_in_object941;
    static $FOLLOW_varOrIRIref_in_verb958;
    static $FOLLOW_A_in_verb966;
    static $FOLLOW_collection_in_triplesNode983;
    static $FOLLOW_blankNodePropertyList_in_triplesNode991;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1008;
    static $FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1010;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1012;
    static $FOLLOW_OPEN_BRACE_in_collection1029;
    static $FOLLOW_graphNode_in_collection1031;
    static $FOLLOW_CLOSE_BRACE_in_collection1034;
    static $FOLLOW_varOrTerm_in_graphNode1051;
    static $FOLLOW_triplesNode_in_graphNode1055;
    static $FOLLOW_variable_in_varOrTerm1072;
    static $FOLLOW_graphTerm_in_varOrTerm1080;
    static $FOLLOW_variable_in_varOrIRIref1097;
    static $FOLLOW_iriRef_in_varOrIRIref1101;
    static $FOLLOW_set_in_variable0;
    static $FOLLOW_iriRef_in_graphTerm1143;
    static $FOLLOW_rdfLiteral_in_graphTerm1151;
    static $FOLLOW_numericLiteral_in_graphTerm1159;
    static $FOLLOW_booleanLiteral_in_graphTerm1167;
    static $FOLLOW_blankNode_in_graphTerm1175;
    static $FOLLOW_OPEN_BRACE_in_graphTerm1183;
    static $FOLLOW_CLOSE_BRACE_in_graphTerm1185;
    static $FOLLOW_conditionalOrExpression_in_expression1202;
    static $FOLLOW_conditionalAndExpression_in_conditionalOrExpression1219;
    static $FOLLOW_OR_in_conditionalOrExpression1223;
    static $FOLLOW_conditionalAndExpression_in_conditionalOrExpression1225;
    static $FOLLOW_valueLogical_in_conditionalAndExpression1245;
    static $FOLLOW_AND_in_conditionalAndExpression1249;
    static $FOLLOW_valueLogical_in_conditionalAndExpression1251;
    static $FOLLOW_relationalExpression_in_valueLogical1271;
    static $FOLLOW_numericExpression_in_relationalExpression1288;
    static $FOLLOW_EQUAL_in_relationalExpression1292;
    static $FOLLOW_numericExpression_in_relationalExpression1294;
    static $FOLLOW_NOT_EQUAL_in_relationalExpression1298;
    static $FOLLOW_numericExpression_in_relationalExpression1300;
    static $FOLLOW_LESS_in_relationalExpression1304;
    static $FOLLOW_numericExpression_in_relationalExpression1306;
    static $FOLLOW_GREATER_in_relationalExpression1310;
    static $FOLLOW_numericExpression_in_relationalExpression1312;
    static $FOLLOW_LESS_EQUAL_in_relationalExpression1316;
    static $FOLLOW_numericExpression_in_relationalExpression1318;
    static $FOLLOW_GREATER_EQUAL_in_relationalExpression1322;
    static $FOLLOW_numericExpression_in_relationalExpression1324;
    static $FOLLOW_additiveExpression_in_numericExpression1344;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1361;
    static $FOLLOW_PLUS_in_additiveExpression1365;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1367;
    static $FOLLOW_MINUS_in_additiveExpression1371;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression1373;
    static $FOLLOW_numericLiteralPositive_in_additiveExpression1377;
    static $FOLLOW_numericLiteralNegative_in_additiveExpression1381;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1401;
    static $FOLLOW_ASTERISK_in_multiplicativeExpression1405;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1407;
    static $FOLLOW_DIVIDE_in_multiplicativeExpression1411;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression1413;
    static $FOLLOW_NOT_in_unaryExpression1433;
    static $FOLLOW_primaryExpression_in_unaryExpression1435;
    static $FOLLOW_PLUS_in_unaryExpression1443;
    static $FOLLOW_primaryExpression_in_unaryExpression1445;
    static $FOLLOW_MINUS_in_unaryExpression1453;
    static $FOLLOW_primaryExpression_in_unaryExpression1455;
    static $FOLLOW_primaryExpression_in_unaryExpression1463;
    static $FOLLOW_brackettedExpression_in_primaryExpression1480;
    static $FOLLOW_builtInCall_in_primaryExpression1484;
    static $FOLLOW_iriRefOrFunction_in_primaryExpression1488;
    static $FOLLOW_rdfLiteral_in_primaryExpression1492;
    static $FOLLOW_numericLiteral_in_primaryExpression1496;
    static $FOLLOW_booleanLiteral_in_primaryExpression1500;
    static $FOLLOW_variable_in_primaryExpression1504;
    static $FOLLOW_OPEN_BRACE_in_brackettedExpression1521;
    static $FOLLOW_expression_in_brackettedExpression1523;
    static $FOLLOW_CLOSE_BRACE_in_brackettedExpression1525;
    static $FOLLOW_STR_in_builtInCall1542;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1544;
    static $FOLLOW_expression_in_builtInCall1546;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1548;
    static $FOLLOW_LANG_in_builtInCall1556;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1558;
    static $FOLLOW_expression_in_builtInCall1560;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1562;
    static $FOLLOW_LANGMATCHES_in_builtInCall1570;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1572;
    static $FOLLOW_expression_in_builtInCall1574;
    static $FOLLOW_COMMA_in_builtInCall1576;
    static $FOLLOW_expression_in_builtInCall1578;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1580;
    static $FOLLOW_DATATYPE_in_builtInCall1588;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1590;
    static $FOLLOW_expression_in_builtInCall1592;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1594;
    static $FOLLOW_BOUND_in_builtInCall1602;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1604;
    static $FOLLOW_variable_in_builtInCall1606;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1608;
    static $FOLLOW_SAMETERM_in_builtInCall1616;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1618;
    static $FOLLOW_expression_in_builtInCall1620;
    static $FOLLOW_COMMA_in_builtInCall1622;
    static $FOLLOW_expression_in_builtInCall1624;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1626;
    static $FOLLOW_ISIRI_in_builtInCall1634;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1636;
    static $FOLLOW_expression_in_builtInCall1638;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1640;
    static $FOLLOW_ISURI_in_builtInCall1648;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1650;
    static $FOLLOW_expression_in_builtInCall1652;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1654;
    static $FOLLOW_ISBLANK_in_builtInCall1662;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1664;
    static $FOLLOW_expression_in_builtInCall1666;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1668;
    static $FOLLOW_ISLITERAL_in_builtInCall1676;
    static $FOLLOW_OPEN_BRACE_in_builtInCall1678;
    static $FOLLOW_expression_in_builtInCall1680;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall1682;
    static $FOLLOW_regexExpression_in_builtInCall1690;
    static $FOLLOW_REGEX_in_regexExpression1707;
    static $FOLLOW_OPEN_BRACE_in_regexExpression1709;
    static $FOLLOW_expression_in_regexExpression1711;
    static $FOLLOW_COMMA_in_regexExpression1713;
    static $FOLLOW_expression_in_regexExpression1715;
    static $FOLLOW_COMMA_in_regexExpression1719;
    static $FOLLOW_expression_in_regexExpression1721;
    static $FOLLOW_CLOSE_BRACE_in_regexExpression1726;
    static $FOLLOW_iriRef_in_iriRefOrFunction1743;
    static $FOLLOW_argList_in_iriRefOrFunction1745;
    static $FOLLOW_string_in_rdfLiteral1763;
    static $FOLLOW_LANGTAG_in_rdfLiteral1767;
    static $FOLLOW_REFERENCE_in_rdfLiteral1773;
    static $FOLLOW_iriRef_in_rdfLiteral1775;
    static $FOLLOW_numericLiteralUnsigned_in_numericLiteral1797;
    static $FOLLOW_numericLiteralPositive_in_numericLiteral1801;
    static $FOLLOW_numericLiteralNegative_in_numericLiteral1805;
    static $FOLLOW_set_in_numericLiteralUnsigned0;
    static $FOLLOW_set_in_numericLiteralPositive0;
    static $FOLLOW_set_in_numericLiteralNegative0;
    static $FOLLOW_set_in_booleanLiteral0;
    static $FOLLOW_set_in_string0;
    static $FOLLOW_IRI_REF_in_iriRef1987;
    static $FOLLOW_prefixedName_in_iriRef1995;
    static $FOLLOW_set_in_prefixedName0;
    static $FOLLOW_BLANK_NODE_LABEL_in_blankNode2037;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2045;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2047;

    
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
             
            
            
        }
        

    public function getTokenNames() { return TestParser::$tokenNames; }
    public function getGrammarFileName() { return "Test.g"; }



    // $ANTLR start "query"
    // Test.g:11:1: query : prologue ( selectQuery | constructQuery | describeQuery | askQuery ) EOF ; 
    public function query(){
        try {
            // Test.g:12:5: ( prologue ( selectQuery | constructQuery | describeQuery | askQuery ) EOF ) 
            // Test.g:12:7: prologue ( selectQuery | constructQuery | describeQuery | askQuery ) EOF 
            {
            $this->pushFollow(self::$FOLLOW_prologue_in_query37);
            $this->prologue();

            $this->state->_fsp--;

            // Test.g:12:16: ( selectQuery | constructQuery | describeQuery | askQuery ) 
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
                    // Test.g:12:18: selectQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_selectQuery_in_query41);
                    $this->selectQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:12:32: constructQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_constructQuery_in_query45);
                    $this->constructQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Test.g:12:49: describeQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_describeQuery_in_query49);
                    $this->describeQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Test.g:12:65: askQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_askQuery_in_query53);
                    $this->askQuery();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('EOF'),self::$FOLLOW_EOF_in_query57); 

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
    // $ANTLR end "query"


    // $ANTLR start "prologue"
    // Test.g:15:1: prologue : ( baseDecl )? ( prefixDecl )* ; 
    public function prologue(){
        try {
            // Test.g:16:5: ( ( baseDecl )? ( prefixDecl )* ) 
            // Test.g:16:7: ( baseDecl )? ( prefixDecl )* 
            {
            // Test.g:16:7: ( baseDecl )? 
            $alt2=2;
            $LA2_0 = $this->input->LA(1);

            if ( ($LA2_0==$this->getToken('BASE')) ) {
                $alt2=1;
            }
            switch ($alt2) {
                case 1 :
                    // Test.g:16:7: baseDecl 
                    {
                    $this->pushFollow(self::$FOLLOW_baseDecl_in_prologue74);
                    $this->baseDecl();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Test.g:16:17: ( prefixDecl )* 
            //loop3:
            do {
                $alt3=2;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('PREFIX')) ) {
                    $alt3=1;
                }


                switch ($alt3) {
            	case 1 :
            	    // Test.g:16:17: prefixDecl 
            	    {
            	    $this->pushFollow(self::$FOLLOW_prefixDecl_in_prologue77);
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
    // Test.g:19:1: baseDecl : BASE IRI_REF ; 
    public function baseDecl(){
        try {
            // Test.g:20:5: ( BASE IRI_REF ) 
            // Test.g:20:7: BASE IRI_REF 
            {
            $this->match($this->input,$this->getToken('BASE'),self::$FOLLOW_BASE_in_baseDecl95); 
            $this->match($this->input,$this->getToken('IRI_REF'),self::$FOLLOW_IRI_REF_in_baseDecl97); 

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
    // Test.g:23:1: prefixDecl : PREFIX PNAME_NS IRI_REF ; 
    public function prefixDecl(){
        try {
            // Test.g:24:5: ( PREFIX PNAME_NS IRI_REF ) 
            // Test.g:24:7: PREFIX PNAME_NS IRI_REF 
            {
            $this->match($this->input,$this->getToken('PREFIX'),self::$FOLLOW_PREFIX_in_prefixDecl114); 
            $this->match($this->input,$this->getToken('PNAME_NS'),self::$FOLLOW_PNAME_NS_in_prefixDecl116); 
            $this->match($this->input,$this->getToken('IRI_REF'),self::$FOLLOW_IRI_REF_in_prefixDecl118); 

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
    // Test.g:27:1: selectQuery : SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier ; 
    public function selectQuery(){
        try {
            // Test.g:28:5: ( SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier ) 
            // Test.g:28:7: SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier 
            {
            $this->match($this->input,$this->getToken('SELECT'),self::$FOLLOW_SELECT_in_selectQuery135); 
            // Test.g:28:14: ( DISTINCT | REDUCED )? 
            $alt4=2;
            $LA4_0 = $this->input->LA(1);

            if ( (($LA4_0>=$this->getToken('DISTINCT') && $LA4_0<=$this->getToken('REDUCED'))) ) {
                $alt4=1;
            }
            switch ($alt4) {
                case 1 :
                    // Test.g: 
                    {
                    if ( ($this->input->LA(1)>=$this->getToken('DISTINCT') && $this->input->LA(1)<=$this->getToken('REDUCED')) ) {
                        $this->input->consume();
                        $this->state->errorRecovery=false;
                    }
                    else {
                        $mse = new MismatchedSetException(null,$this->input);
                        throw mse;
                    }


                    }
                    break;

            }

            // Test.g:28:38: ( ( variable )+ | ASTERISK ) 
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
                    // Test.g:28:40: ( variable )+ 
                    {
                    // Test.g:28:40: ( variable )+ 
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
                    	    // Test.g:28:40: variable 
                    	    {
                    	    $this->pushFollow(self::$FOLLOW_variable_in_selectQuery150);
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
                    // Test.g:28:52: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_selectQuery155); 

                    }
                    break;

            }

            // Test.g:28:63: ( datasetClause )* 
            //loop7:
            do {
                $alt7=2;
                $LA7_0 = $this->input->LA(1);

                if ( ($LA7_0==$this->getToken('FROM')) ) {
                    $alt7=1;
                }


                switch ($alt7) {
            	case 1 :
            	    // Test.g:28:63: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_selectQuery159);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop7;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_selectQuery162);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_selectQuery164);
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
    // Test.g:31:1: constructQuery : CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier ; 
    public function constructQuery(){
        try {
            // Test.g:32:5: ( CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier ) 
            // Test.g:32:7: CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier 
            {
            $this->match($this->input,$this->getToken('CONSTRUCT'),self::$FOLLOW_CONSTRUCT_in_constructQuery181); 
            $this->pushFollow(self::$FOLLOW_constructTemplate_in_constructQuery183);
            $this->constructTemplate();

            $this->state->_fsp--;

            // Test.g:32:35: ( datasetClause )* 
            //loop8:
            do {
                $alt8=2;
                $LA8_0 = $this->input->LA(1);

                if ( ($LA8_0==$this->getToken('FROM')) ) {
                    $alt8=1;
                }


                switch ($alt8) {
            	case 1 :
            	    // Test.g:32:35: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_constructQuery185);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop8;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_constructQuery188);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_constructQuery190);
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
    // Test.g:35:1: describeQuery : DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier ; 
    public function describeQuery(){
        try {
            // Test.g:36:5: ( DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier ) 
            // Test.g:36:7: DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier 
            {
            $this->match($this->input,$this->getToken('DESCRIBE'),self::$FOLLOW_DESCRIBE_in_describeQuery207); 
            // Test.g:36:16: ( ( varOrIRIref )+ | ASTERISK ) 
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
                    // Test.g:36:18: ( varOrIRIref )+ 
                    {
                    // Test.g:36:18: ( varOrIRIref )+ 
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
                    	    // Test.g:36:18: varOrIRIref 
                    	    {
                    	    $this->pushFollow(self::$FOLLOW_varOrIRIref_in_describeQuery211);
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
                    // Test.g:36:33: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_describeQuery216); 

                    }
                    break;

            }

            // Test.g:36:44: ( datasetClause )* 
            //loop11:
            do {
                $alt11=2;
                $LA11_0 = $this->input->LA(1);

                if ( ($LA11_0==$this->getToken('FROM')) ) {
                    $alt11=1;
                }


                switch ($alt11) {
            	case 1 :
            	    // Test.g:36:44: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_describeQuery220);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop11;
                }
            } while (true);

            // Test.g:36:59: ( whereClause )? 
            $alt12=2;
            $LA12_0 = $this->input->LA(1);

            if ( ($LA12_0==$this->getToken('OPEN_CURLY_BRACE')||$LA12_0==$this->getToken('WHERE')) ) {
                $alt12=1;
            }
            switch ($alt12) {
                case 1 :
                    // Test.g:36:59: whereClause 
                    {
                    $this->pushFollow(self::$FOLLOW_whereClause_in_describeQuery223);
                    $this->whereClause();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_describeQuery226);
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
    // Test.g:39:1: askQuery : ASK ( datasetClause )* whereClause ; 
    public function askQuery(){
        try {
            // Test.g:40:5: ( ASK ( datasetClause )* whereClause ) 
            // Test.g:40:7: ASK ( datasetClause )* whereClause 
            {
            $this->match($this->input,$this->getToken('ASK'),self::$FOLLOW_ASK_in_askQuery243); 
            // Test.g:40:11: ( datasetClause )* 
            //loop13:
            do {
                $alt13=2;
                $LA13_0 = $this->input->LA(1);

                if ( ($LA13_0==$this->getToken('FROM')) ) {
                    $alt13=1;
                }


                switch ($alt13) {
            	case 1 :
            	    // Test.g:40:11: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_askQuery245);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop13;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_askQuery248);
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
    // Test.g:43:1: datasetClause : FROM ( defaultGraphClause | namedGraphClause ) ; 
    public function datasetClause(){
        try {
            // Test.g:44:5: ( FROM ( defaultGraphClause | namedGraphClause ) ) 
            // Test.g:44:7: FROM ( defaultGraphClause | namedGraphClause ) 
            {
            $this->match($this->input,$this->getToken('FROM'),self::$FOLLOW_FROM_in_datasetClause265); 
            // Test.g:44:12: ( defaultGraphClause | namedGraphClause ) 
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
                    // Test.g:44:14: defaultGraphClause 
                    {
                    $this->pushFollow(self::$FOLLOW_defaultGraphClause_in_datasetClause269);
                    $this->defaultGraphClause();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:44:35: namedGraphClause 
                    {
                    $this->pushFollow(self::$FOLLOW_namedGraphClause_in_datasetClause273);
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
    // Test.g:47:1: defaultGraphClause : sourceSelector ; 
    public function defaultGraphClause(){
        try {
            // Test.g:48:5: ( sourceSelector ) 
            // Test.g:48:7: sourceSelector 
            {
            $this->pushFollow(self::$FOLLOW_sourceSelector_in_defaultGraphClause292);
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
    // Test.g:51:1: namedGraphClause : NAMED sourceSelector ; 
    public function namedGraphClause(){
        try {
            // Test.g:52:5: ( NAMED sourceSelector ) 
            // Test.g:52:7: NAMED sourceSelector 
            {
            $this->match($this->input,$this->getToken('NAMED'),self::$FOLLOW_NAMED_in_namedGraphClause309); 
            $this->pushFollow(self::$FOLLOW_sourceSelector_in_namedGraphClause311);
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
    // Test.g:55:1: sourceSelector : iriRef ; 
    public function sourceSelector(){
        try {
            // Test.g:56:5: ( iriRef ) 
            // Test.g:56:7: iriRef 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_sourceSelector328);
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
    // Test.g:59:1: whereClause : ( WHERE )? groupGraphPattern ; 
    public function whereClause(){
        try {
            // Test.g:60:5: ( ( WHERE )? groupGraphPattern ) 
            // Test.g:60:7: ( WHERE )? groupGraphPattern 
            {
            // Test.g:60:7: ( WHERE )? 
            $alt15=2;
            $LA15_0 = $this->input->LA(1);

            if ( ($LA15_0==$this->getToken('WHERE')) ) {
                $alt15=1;
            }
            switch ($alt15) {
                case 1 :
                    // Test.g:60:7: WHERE 
                    {
                    $this->match($this->input,$this->getToken('WHERE'),self::$FOLLOW_WHERE_in_whereClause345); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_whereClause348);
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
    // Test.g:63:1: solutionModifier : ( orderClause )? ( limitOffsetClauses )? ; 
    public function solutionModifier(){
        try {
            // Test.g:64:5: ( ( orderClause )? ( limitOffsetClauses )? ) 
            // Test.g:64:7: ( orderClause )? ( limitOffsetClauses )? 
            {
            // Test.g:64:7: ( orderClause )? 
            $alt16=2;
            $LA16_0 = $this->input->LA(1);

            if ( ($LA16_0==$this->getToken('ORDER')) ) {
                $alt16=1;
            }
            switch ($alt16) {
                case 1 :
                    // Test.g:64:7: orderClause 
                    {
                    $this->pushFollow(self::$FOLLOW_orderClause_in_solutionModifier365);
                    $this->orderClause();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Test.g:64:20: ( limitOffsetClauses )? 
            $alt17=2;
            $LA17_0 = $this->input->LA(1);

            if ( (($LA17_0>=$this->getToken('LIMIT') && $LA17_0<=$this->getToken('OFFSET'))) ) {
                $alt17=1;
            }
            switch ($alt17) {
                case 1 :
                    // Test.g:64:20: limitOffsetClauses 
                    {
                    $this->pushFollow(self::$FOLLOW_limitOffsetClauses_in_solutionModifier368);
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
    // Test.g:67:1: limitOffsetClauses : ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ) ; 
    public function limitOffsetClauses(){
        try {
            // Test.g:68:5: ( ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ) ) 
            // Test.g:68:7: ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ) 
            {
            // Test.g:68:7: ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ) 
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
                    // Test.g:68:9: limitClause ( offsetClause )? 
                    {
                    $this->pushFollow(self::$FOLLOW_limitClause_in_limitOffsetClauses388);
                    $this->limitClause();

                    $this->state->_fsp--;

                    // Test.g:68:21: ( offsetClause )? 
                    $alt18=2;
                    $LA18_0 = $this->input->LA(1);

                    if ( ($LA18_0==$this->getToken('OFFSET')) ) {
                        $alt18=1;
                    }
                    switch ($alt18) {
                        case 1 :
                            // Test.g:68:21: offsetClause 
                            {
                            $this->pushFollow(self::$FOLLOW_offsetClause_in_limitOffsetClauses390);
                            $this->offsetClause();

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // Test.g:68:37: offsetClause ( limitClause )? 
                    {
                    $this->pushFollow(self::$FOLLOW_offsetClause_in_limitOffsetClauses395);
                    $this->offsetClause();

                    $this->state->_fsp--;

                    // Test.g:68:50: ( limitClause )? 
                    $alt19=2;
                    $LA19_0 = $this->input->LA(1);

                    if ( ($LA19_0==$this->getToken('LIMIT')) ) {
                        $alt19=1;
                    }
                    switch ($alt19) {
                        case 1 :
                            // Test.g:68:50: limitClause 
                            {
                            $this->pushFollow(self::$FOLLOW_limitClause_in_limitOffsetClauses397);
                            $this->limitClause();

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
    // $ANTLR end "limitOffsetClauses"


    // $ANTLR start "orderClause"
    // Test.g:71:1: orderClause : ORDER BY ( orderCondition )+ ; 
    public function orderClause(){
        try {
            // Test.g:72:5: ( ORDER BY ( orderCondition )+ ) 
            // Test.g:72:7: ORDER BY ( orderCondition )+ 
            {
            $this->match($this->input,$this->getToken('ORDER'),self::$FOLLOW_ORDER_in_orderClause417); 
            $this->match($this->input,$this->getToken('BY'),self::$FOLLOW_BY_in_orderClause419); 
            // Test.g:72:16: ( orderCondition )+ 
            $cnt21=0;
            //loop21:
            do {
                $alt21=2;
                $LA21_0 = $this->input->LA(1);

                if ( ($LA21_0==$this->getToken('IRI_REF')||($LA21_0>=$this->getToken('ASC') && $LA21_0<=$this->getToken('DESC'))||($LA21_0>=$this->getToken('STR') && $LA21_0<=$this->getToken('REGEX'))||$LA21_0==$this->getToken('PNAME_NS')||$LA21_0==$this->getToken('PNAME_LN')||($LA21_0>=$this->getToken('VAR1') && $LA21_0<=$this->getToken('VAR2'))||$LA21_0==$this->getToken('OPEN_BRACE')) ) {
                    $alt21=1;
                }


                switch ($alt21) {
            	case 1 :
            	    // Test.g:72:16: orderCondition 
            	    {
            	    $this->pushFollow(self::$FOLLOW_orderCondition_in_orderClause421);
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
    // Test.g:75:1: orderCondition : ( ( ( ASC | DESC ) brackettedExpression ) | ( constraint | variable ) ); 
    public function orderCondition(){
        try {
            // Test.g:76:5: ( ( ( ASC | DESC ) brackettedExpression ) | ( constraint | variable ) ) 
            $alt23=2;
            $LA23_0 = $this->input->LA(1);

            if ( (($LA23_0>=$this->getToken('ASC') && $LA23_0<=$this->getToken('DESC'))) ) {
                $alt23=1;
            }
            else if ( ($LA23_0==$this->getToken('IRI_REF')||($LA23_0>=$this->getToken('STR') && $LA23_0<=$this->getToken('REGEX'))||$LA23_0==$this->getToken('PNAME_NS')||$LA23_0==$this->getToken('PNAME_LN')||($LA23_0>=$this->getToken('VAR1') && $LA23_0<=$this->getToken('VAR2'))||$LA23_0==$this->getToken('OPEN_BRACE')) ) {
                $alt23=2;
            }
            else {
                $nvae = new NoViableAltException("", 23, 0, $this->input);

                throw $nvae;
            }
            switch ($alt23) {
                case 1 :
                    // Test.g:76:7: ( ( ASC | DESC ) brackettedExpression ) 
                    {
                    // Test.g:76:7: ( ( ASC | DESC ) brackettedExpression ) 
                    // Test.g:76:9: ( ASC | DESC ) brackettedExpression 
                    {
                    if ( ($this->input->LA(1)>=$this->getToken('ASC') && $this->input->LA(1)<=$this->getToken('DESC')) ) {
                        $this->input->consume();
                        $this->state->errorRecovery=false;
                    }
                    else {
                        $mse = new MismatchedSetException(null,$this->input);
                        throw mse;
                    }

                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_orderCondition451);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }


                    }
                    break;
                case 2 :
                    // Test.g:77:7: ( constraint | variable ) 
                    {
                    // Test.g:77:7: ( constraint | variable ) 
                    $alt22=2;
                    $LA22_0 = $this->input->LA(1);

                    if ( ($LA22_0==$this->getToken('IRI_REF')||($LA22_0>=$this->getToken('STR') && $LA22_0<=$this->getToken('REGEX'))||$LA22_0==$this->getToken('PNAME_NS')||$LA22_0==$this->getToken('PNAME_LN')||$LA22_0==$this->getToken('OPEN_BRACE')) ) {
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
                            // Test.g:77:9: constraint 
                            {
                            $this->pushFollow(self::$FOLLOW_constraint_in_orderCondition463);
                            $this->constraint();

                            $this->state->_fsp--;


                            }
                            break;
                        case 2 :
                            // Test.g:77:22: variable 
                            {
                            $this->pushFollow(self::$FOLLOW_variable_in_orderCondition467);
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
    // Test.g:80:1: limitClause : LIMIT INTEGER ; 
    public function limitClause(){
        try {
            // Test.g:81:5: ( LIMIT INTEGER ) 
            // Test.g:81:7: LIMIT INTEGER 
            {
            $this->match($this->input,$this->getToken('LIMIT'),self::$FOLLOW_LIMIT_in_limitClause486); 
            $this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_limitClause488); 

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
    // Test.g:84:1: offsetClause : OFFSET INTEGER ; 
    public function offsetClause(){
        try {
            // Test.g:85:5: ( OFFSET INTEGER ) 
            // Test.g:85:7: OFFSET INTEGER 
            {
            $this->match($this->input,$this->getToken('OFFSET'),self::$FOLLOW_OFFSET_in_offsetClause505); 
            $this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_offsetClause507); 

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
    // Test.g:88:1: groupGraphPattern : OPEN_CURLY_BRACE ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* CLOSE_CURLY_BRACE ; 
    public function groupGraphPattern(){
        try {
            // Test.g:89:5: ( OPEN_CURLY_BRACE ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* CLOSE_CURLY_BRACE ) 
            // Test.g:89:7: OPEN_CURLY_BRACE ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern524); 
            // Test.g:89:24: ( triplesBlock )? 
            $alt24=2;
            $LA24_0 = $this->input->LA(1);

            if ( ($LA24_0==$this->getToken('IRI_REF')||($LA24_0>=$this->getToken('TRUE') && $LA24_0<=$this->getToken('PNAME_NS'))||$LA24_0==$this->getToken('PNAME_LN')||($LA24_0>=$this->getToken('VAR1') && $LA24_0<=$this->getToken('VAR2'))||($LA24_0>=$this->getToken('STRING_LITERAL1') && $LA24_0<=$this->getToken('OPEN_BRACE'))||$LA24_0==$this->getToken('BLANK_NODE_LABEL')||($LA24_0>=$this->getToken('INTEGER') && $LA24_0<=$this->getToken('DECIMAL'))||($LA24_0>=$this->getToken('DOUBLE') && $LA24_0<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
                $alt24=1;
            }
            switch ($alt24) {
                case 1 :
                    // Test.g:89:24: triplesBlock 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPattern526);
                    $this->triplesBlock();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Test.g:89:38: ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* 
            //loop28:
            do {
                $alt28=2;
                $LA28_0 = $this->input->LA(1);

                if ( ($LA28_0==$this->getToken('OPEN_CURLY_BRACE')||($LA28_0>=$this->getToken('OPTIONAL') && $LA28_0<=$this->getToken('GRAPH'))||$LA28_0==$this->getToken('FILTER')) ) {
                    $alt28=1;
                }


                switch ($alt28) {
            	case 1 :
            	    // Test.g:89:40: ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? 
            	    {
            	    // Test.g:89:40: ( graphPatternNotTriples | filter ) 
            	    $alt25=2;
            	    $LA25_0 = $this->input->LA(1);

            	    if ( ($LA25_0==$this->getToken('OPEN_CURLY_BRACE')||($LA25_0>=$this->getToken('OPTIONAL') && $LA25_0<=$this->getToken('GRAPH'))) ) {
            	        $alt25=1;
            	    }
            	    else if ( ($LA25_0==$this->getToken('FILTER')) ) {
            	        $alt25=2;
            	    }
            	    else {
            	        $nvae = new NoViableAltException("", 25, 0, $this->input);

            	        throw $nvae;
            	    }
            	    switch ($alt25) {
            	        case 1 :
            	            // Test.g:89:42: graphPatternNotTriples 
            	            {
            	            $this->pushFollow(self::$FOLLOW_graphPatternNotTriples_in_groupGraphPattern533);
            	            $this->graphPatternNotTriples();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 2 :
            	            // Test.g:89:67: filter 
            	            {
            	            $this->pushFollow(self::$FOLLOW_filter_in_groupGraphPattern537);
            	            $this->filter();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }

            	    // Test.g:89:76: ( DOT )? 
            	    $alt26=2;
            	    $LA26_0 = $this->input->LA(1);

            	    if ( ($LA26_0==$this->getToken('DOT')) ) {
            	        $alt26=1;
            	    }
            	    switch ($alt26) {
            	        case 1 :
            	            // Test.g:89:76: DOT 
            	            {
            	            $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_groupGraphPattern541); 

            	            }
            	            break;

            	    }

            	    // Test.g:89:81: ( triplesBlock )? 
            	    $alt27=2;
            	    $LA27_0 = $this->input->LA(1);

            	    if ( ($LA27_0==$this->getToken('IRI_REF')||($LA27_0>=$this->getToken('TRUE') && $LA27_0<=$this->getToken('PNAME_NS'))||$LA27_0==$this->getToken('PNAME_LN')||($LA27_0>=$this->getToken('VAR1') && $LA27_0<=$this->getToken('VAR2'))||($LA27_0>=$this->getToken('STRING_LITERAL1') && $LA27_0<=$this->getToken('OPEN_BRACE'))||$LA27_0==$this->getToken('BLANK_NODE_LABEL')||($LA27_0>=$this->getToken('INTEGER') && $LA27_0<=$this->getToken('DECIMAL'))||($LA27_0>=$this->getToken('DOUBLE') && $LA27_0<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
            	        $alt27=1;
            	    }
            	    switch ($alt27) {
            	        case 1 :
            	            // Test.g:89:81: triplesBlock 
            	            {
            	            $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPattern544);
            	            $this->triplesBlock();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop28;
                }
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern550); 

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
    // Test.g:92:1: triplesBlock : triplesSameSubject ( DOT ( triplesBlock )? )? ; 
    public function triplesBlock(){
        try {
            // Test.g:93:5: ( triplesSameSubject ( DOT ( triplesBlock )? )? ) 
            // Test.g:93:7: triplesSameSubject ( DOT ( triplesBlock )? )? 
            {
            $this->pushFollow(self::$FOLLOW_triplesSameSubject_in_triplesBlock567);
            $this->triplesSameSubject();

            $this->state->_fsp--;

            // Test.g:93:26: ( DOT ( triplesBlock )? )? 
            $alt30=2;
            $LA30_0 = $this->input->LA(1);

            if ( ($LA30_0==$this->getToken('DOT')) ) {
                $alt30=1;
            }
            switch ($alt30) {
                case 1 :
                    // Test.g:93:28: DOT ( triplesBlock )? 
                    {
                    $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_triplesBlock571); 
                    // Test.g:93:32: ( triplesBlock )? 
                    $alt29=2;
                    $LA29_0 = $this->input->LA(1);

                    if ( ($LA29_0==$this->getToken('IRI_REF')||($LA29_0>=$this->getToken('TRUE') && $LA29_0<=$this->getToken('PNAME_NS'))||$LA29_0==$this->getToken('PNAME_LN')||($LA29_0>=$this->getToken('VAR1') && $LA29_0<=$this->getToken('VAR2'))||($LA29_0>=$this->getToken('STRING_LITERAL1') && $LA29_0<=$this->getToken('OPEN_BRACE'))||$LA29_0==$this->getToken('BLANK_NODE_LABEL')||($LA29_0>=$this->getToken('INTEGER') && $LA29_0<=$this->getToken('DECIMAL'))||($LA29_0>=$this->getToken('DOUBLE') && $LA29_0<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
                        $alt29=1;
                    }
                    switch ($alt29) {
                        case 1 :
                            // Test.g:93:32: triplesBlock 
                            {
                            $this->pushFollow(self::$FOLLOW_triplesBlock_in_triplesBlock573);
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
    // Test.g:96:1: graphPatternNotTriples : ( optionalGraphPattern | groupOrUnionGraphPattern | graphGraphPattern ); 
    public function graphPatternNotTriples(){
        try {
            // Test.g:97:5: ( optionalGraphPattern | groupOrUnionGraphPattern | graphGraphPattern ) 
            $alt31=3;
            $LA31 = $this->input->LA(1);
            if($this->getToken('OPTIONAL')== $LA31)
                {
                $alt31=1;
                }
            else if($this->getToken('OPEN_CURLY_BRACE')== $LA31)
                {
                $alt31=2;
                }
            else if($this->getToken('GRAPH')== $LA31)
                {
                $alt31=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 31, 0, $this->input);

                throw $nvae;
            }

            switch ($alt31) {
                case 1 :
                    // Test.g:97:7: optionalGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_optionalGraphPattern_in_graphPatternNotTriples594);
                    $this->optionalGraphPattern();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:97:30: groupOrUnionGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples598);
                    $this->groupOrUnionGraphPattern();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Test.g:97:57: graphGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_graphGraphPattern_in_graphPatternNotTriples602);
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
    // Test.g:100:1: optionalGraphPattern : OPTIONAL groupGraphPattern ; 
    public function optionalGraphPattern(){
        try {
            // Test.g:101:5: ( OPTIONAL groupGraphPattern ) 
            // Test.g:101:7: OPTIONAL groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('OPTIONAL'),self::$FOLLOW_OPTIONAL_in_optionalGraphPattern619); 
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_optionalGraphPattern621);
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
    // Test.g:104:1: graphGraphPattern : GRAPH varOrIRIref groupGraphPattern ; 
    public function graphGraphPattern(){
        try {
            // Test.g:105:5: ( GRAPH varOrIRIref groupGraphPattern ) 
            // Test.g:105:7: GRAPH varOrIRIref groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('GRAPH'),self::$FOLLOW_GRAPH_in_graphGraphPattern638); 
            $this->pushFollow(self::$FOLLOW_varOrIRIref_in_graphGraphPattern640);
            $this->varOrIRIref();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_graphGraphPattern642);
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
    // Test.g:108:1: groupOrUnionGraphPattern : groupGraphPattern ( UNION groupGraphPattern )* ; 
    public function groupOrUnionGraphPattern(){
        try {
            // Test.g:109:5: ( groupGraphPattern ( UNION groupGraphPattern )* ) 
            // Test.g:109:7: groupGraphPattern ( UNION groupGraphPattern )* 
            {
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern659);
            $this->groupGraphPattern();

            $this->state->_fsp--;

            // Test.g:109:25: ( UNION groupGraphPattern )* 
            //loop32:
            do {
                $alt32=2;
                $LA32_0 = $this->input->LA(1);

                if ( ($LA32_0==$this->getToken('UNION')) ) {
                    $alt32=1;
                }


                switch ($alt32) {
            	case 1 :
            	    // Test.g:109:27: UNION groupGraphPattern 
            	    {
            	    $this->match($this->input,$this->getToken('UNION'),self::$FOLLOW_UNION_in_groupOrUnionGraphPattern663); 
            	    $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern665);
            	    $this->groupGraphPattern();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop32;
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
    // Test.g:112:1: filter : FILTER constraint ; 
    public function filter(){
        try {
            // Test.g:113:5: ( FILTER constraint ) 
            // Test.g:113:7: FILTER constraint 
            {
            $this->match($this->input,$this->getToken('FILTER'),self::$FOLLOW_FILTER_in_filter685); 
            $this->pushFollow(self::$FOLLOW_constraint_in_filter687);
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
    // Test.g:116:1: constraint : ( brackettedExpression | builtInCall | functionCall ); 
    public function constraint(){
        try {
            // Test.g:117:5: ( brackettedExpression | builtInCall | functionCall ) 
            $alt33=3;
            $LA33 = $this->input->LA(1);
            if($this->getToken('OPEN_BRACE')== $LA33)
                {
                $alt33=1;
                }
            else if($this->getToken('STR')== $LA33||$this->getToken('LANG')== $LA33||$this->getToken('LANGMATCHES')== $LA33||$this->getToken('DATATYPE')== $LA33||$this->getToken('BOUND')== $LA33||$this->getToken('SAMETERM')== $LA33||$this->getToken('ISIRI')== $LA33||$this->getToken('ISURI')== $LA33||$this->getToken('ISBLANK')== $LA33||$this->getToken('ISLITERAL')== $LA33||$this->getToken('REGEX')== $LA33)
                {
                $alt33=2;
                }
            else if($this->getToken('IRI_REF')== $LA33||$this->getToken('PNAME_NS')== $LA33||$this->getToken('PNAME_LN')== $LA33)
                {
                $alt33=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 33, 0, $this->input);

                throw $nvae;
            }

            switch ($alt33) {
                case 1 :
                    // Test.g:117:7: brackettedExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_constraint704);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:117:30: builtInCall 
                    {
                    $this->pushFollow(self::$FOLLOW_builtInCall_in_constraint708);
                    $this->builtInCall();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Test.g:117:44: functionCall 
                    {
                    $this->pushFollow(self::$FOLLOW_functionCall_in_constraint712);
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
    // Test.g:120:1: functionCall : iriRef argList ; 
    public function functionCall(){
        try {
            // Test.g:121:5: ( iriRef argList ) 
            // Test.g:121:7: iriRef argList 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_functionCall729);
            $this->iriRef();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_argList_in_functionCall731);
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
    // Test.g:124:1: argList : ( OPEN_BRACE CLOSE_BRACE | OPEN_BRACE expression ( COMMA expression )* CLOSE_BRACE ) ; 
    public function argList(){
        try {
            // Test.g:125:5: ( ( OPEN_BRACE CLOSE_BRACE | OPEN_BRACE expression ( COMMA expression )* CLOSE_BRACE ) ) 
            // Test.g:125:7: ( OPEN_BRACE CLOSE_BRACE | OPEN_BRACE expression ( COMMA expression )* CLOSE_BRACE ) 
            {
            // Test.g:125:7: ( OPEN_BRACE CLOSE_BRACE | OPEN_BRACE expression ( COMMA expression )* CLOSE_BRACE ) 
            $alt35=2;
            $LA35_0 = $this->input->LA(1);

            if ( ($LA35_0==$this->getToken('OPEN_BRACE')) ) {
                $LA35_1 = $this->input->LA(2);

                if ( ($LA35_1==$this->getToken('CLOSE_BRACE')) ) {
                    $alt35=1;
                }
                else if ( ($LA35_1==$this->getToken('IRI_REF')||($LA35_1>=$this->getToken('STR') && $LA35_1<=$this->getToken('PNAME_NS'))||$LA35_1==$this->getToken('PNAME_LN')||$LA35_1==$this->getToken('MINUS')||$LA35_1==$this->getToken('PLUS')||$LA35_1==$this->getToken('NOT')||($LA35_1>=$this->getToken('VAR1') && $LA35_1<=$this->getToken('VAR2'))||($LA35_1>=$this->getToken('STRING_LITERAL1') && $LA35_1<=$this->getToken('OPEN_BRACE'))||($LA35_1>=$this->getToken('INTEGER') && $LA35_1<=$this->getToken('DECIMAL'))||($LA35_1>=$this->getToken('DOUBLE') && $LA35_1<=$this->getToken('DOUBLE_NEGATIVE'))) ) {
                    $alt35=2;
                }
                else {
                    $nvae = new NoViableAltException("", 35, 1, $this->input);

                    throw $nvae;
                }
            }
            else {
                $nvae = new NoViableAltException("", 35, 0, $this->input);

                throw $nvae;
            }
            switch ($alt35) {
                case 1 :
                    // Test.g:125:9: OPEN_BRACE CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_argList750); 
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_argList752); 

                    }
                    break;
                case 2 :
                    // Test.g:125:34: OPEN_BRACE expression ( COMMA expression )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_argList756); 
                    $this->pushFollow(self::$FOLLOW_expression_in_argList758);
                    $this->expression();

                    $this->state->_fsp--;

                    // Test.g:125:56: ( COMMA expression )* 
                    //loop34:
                    do {
                        $alt34=2;
                        $LA34_0 = $this->input->LA(1);

                        if ( ($LA34_0==$this->getToken('COMMA')) ) {
                            $alt34=1;
                        }


                        switch ($alt34) {
                    	case 1 :
                    	    // Test.g:125:58: COMMA expression 
                    	    {
                    	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_argList762); 
                    	    $this->pushFollow(self::$FOLLOW_expression_in_argList764);
                    	    $this->expression();

                    	    $this->state->_fsp--;


                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop34;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_argList769); 

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
    // $ANTLR end "argList"


    // $ANTLR start "constructTemplate"
    // Test.g:128:1: constructTemplate : OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ; 
    public function constructTemplate(){
        try {
            // Test.g:129:5: ( OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ) 
            // Test.g:129:7: OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate788); 
            // Test.g:129:24: ( constructTriples )? 
            $alt36=2;
            $LA36_0 = $this->input->LA(1);

            if ( ($LA36_0==$this->getToken('IRI_REF')||($LA36_0>=$this->getToken('TRUE') && $LA36_0<=$this->getToken('PNAME_NS'))||$LA36_0==$this->getToken('PNAME_LN')||($LA36_0>=$this->getToken('VAR1') && $LA36_0<=$this->getToken('VAR2'))||($LA36_0>=$this->getToken('STRING_LITERAL1') && $LA36_0<=$this->getToken('OPEN_BRACE'))||$LA36_0==$this->getToken('BLANK_NODE_LABEL')||($LA36_0>=$this->getToken('INTEGER') && $LA36_0<=$this->getToken('DECIMAL'))||($LA36_0>=$this->getToken('DOUBLE') && $LA36_0<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
                $alt36=1;
            }
            switch ($alt36) {
                case 1 :
                    // Test.g:129:24: constructTriples 
                    {
                    $this->pushFollow(self::$FOLLOW_constructTriples_in_constructTemplate790);
                    $this->constructTriples();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate793); 

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
    // Test.g:132:1: constructTriples : triplesSameSubject ( DOT ( constructTriples )? )? ; 
    public function constructTriples(){
        try {
            // Test.g:133:5: ( triplesSameSubject ( DOT ( constructTriples )? )? ) 
            // Test.g:133:7: triplesSameSubject ( DOT ( constructTriples )? )? 
            {
            $this->pushFollow(self::$FOLLOW_triplesSameSubject_in_constructTriples810);
            $this->triplesSameSubject();

            $this->state->_fsp--;

            // Test.g:133:26: ( DOT ( constructTriples )? )? 
            $alt38=2;
            $LA38_0 = $this->input->LA(1);

            if ( ($LA38_0==$this->getToken('DOT')) ) {
                $alt38=1;
            }
            switch ($alt38) {
                case 1 :
                    // Test.g:133:28: DOT ( constructTriples )? 
                    {
                    $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_constructTriples814); 
                    // Test.g:133:32: ( constructTriples )? 
                    $alt37=2;
                    $LA37_0 = $this->input->LA(1);

                    if ( ($LA37_0==$this->getToken('IRI_REF')||($LA37_0>=$this->getToken('TRUE') && $LA37_0<=$this->getToken('PNAME_NS'))||$LA37_0==$this->getToken('PNAME_LN')||($LA37_0>=$this->getToken('VAR1') && $LA37_0<=$this->getToken('VAR2'))||($LA37_0>=$this->getToken('STRING_LITERAL1') && $LA37_0<=$this->getToken('OPEN_BRACE'))||$LA37_0==$this->getToken('BLANK_NODE_LABEL')||($LA37_0>=$this->getToken('INTEGER') && $LA37_0<=$this->getToken('DECIMAL'))||($LA37_0>=$this->getToken('DOUBLE') && $LA37_0<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
                        $alt37=1;
                    }
                    switch ($alt37) {
                        case 1 :
                            // Test.g:133:32: constructTriples 
                            {
                            $this->pushFollow(self::$FOLLOW_constructTriples_in_constructTriples816);
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
    // Test.g:136:1: triplesSameSubject : ( varOrTerm propertyListNotEmpty | triplesNode propertyList ); 
    public function triplesSameSubject(){
        try {
            // Test.g:137:5: ( varOrTerm propertyListNotEmpty | triplesNode propertyList ) 
            $alt39=2;
            $LA39 = $this->input->LA(1);
            if($this->getToken('IRI_REF')== $LA39||$this->getToken('TRUE')== $LA39||$this->getToken('FALSE')== $LA39||$this->getToken('PNAME_NS')== $LA39||$this->getToken('PNAME_LN')== $LA39||$this->getToken('VAR1')== $LA39||$this->getToken('VAR2')== $LA39||$this->getToken('STRING_LITERAL1')== $LA39||$this->getToken('STRING_LITERAL2')== $LA39||$this->getToken('STRING_LITERAL_LONG1')== $LA39||$this->getToken('STRING_LITERAL_LONG2')== $LA39||$this->getToken('BLANK_NODE_LABEL')== $LA39||$this->getToken('INTEGER')== $LA39||$this->getToken('DECIMAL')== $LA39||$this->getToken('DOUBLE')== $LA39||$this->getToken('INTEGER_POSITIVE')== $LA39||$this->getToken('DECIMAL_POSITIVE')== $LA39||$this->getToken('DOUBLE_POSITIVE')== $LA39||$this->getToken('INTEGER_NEGATIVE')== $LA39||$this->getToken('DECIMAL_NEGATIVE')== $LA39||$this->getToken('DOUBLE_NEGATIVE')== $LA39)
                {
                $alt39=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA39)
                {
                $LA39_2 = $this->input->LA(2);

                if ( ($LA39_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt39=1;
                }
                else if ( ($LA39_2==$this->getToken('IRI_REF')||$LA39_2==$this->getToken('A')||$LA39_2==$this->getToken('PNAME_NS')||$LA39_2==$this->getToken('PNAME_LN')||($LA39_2>=$this->getToken('VAR1') && $LA39_2<=$this->getToken('VAR2'))) ) {
                    $alt39=2;
                }
                else {
                    $nvae = new NoViableAltException("", 39, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA39)
                {
                $LA39_3 = $this->input->LA(2);

                if ( ($LA39_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt39=1;
                }
                else if ( ($LA39_3==$this->getToken('IRI_REF')||($LA39_3>=$this->getToken('TRUE') && $LA39_3<=$this->getToken('PNAME_NS'))||$LA39_3==$this->getToken('PNAME_LN')||($LA39_3>=$this->getToken('VAR1') && $LA39_3<=$this->getToken('VAR2'))||($LA39_3>=$this->getToken('STRING_LITERAL1') && $LA39_3<=$this->getToken('OPEN_BRACE'))||$LA39_3==$this->getToken('BLANK_NODE_LABEL')||($LA39_3>=$this->getToken('INTEGER') && $LA39_3<=$this->getToken('DECIMAL'))||($LA39_3>=$this->getToken('DOUBLE') && $LA39_3<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
                    $alt39=2;
                }
                else {
                    $nvae = new NoViableAltException("", 39, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 39, 0, $this->input);

                throw $nvae;
            }

            switch ($alt39) {
                case 1 :
                    // Test.g:137:7: varOrTerm propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_triplesSameSubject837);
                    $this->varOrTerm();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_triplesSameSubject839);
                    $this->propertyListNotEmpty();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:137:40: triplesNode propertyList 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_triplesSameSubject843);
                    $this->triplesNode();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyList_in_triplesSameSubject845);
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
    // Test.g:140:1: propertyListNotEmpty : verb objectList ( SEMICOLON ( verb objectList )? )* ; 
    public function propertyListNotEmpty(){
        try {
            // Test.g:141:5: ( verb objectList ( SEMICOLON ( verb objectList )? )* ) 
            // Test.g:141:7: verb objectList ( SEMICOLON ( verb objectList )? )* 
            {
            $this->pushFollow(self::$FOLLOW_verb_in_propertyListNotEmpty862);
            $this->verb();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmpty864);
            $this->objectList();

            $this->state->_fsp--;

            // Test.g:141:23: ( SEMICOLON ( verb objectList )? )* 
            //loop41:
            do {
                $alt41=2;
                $LA41_0 = $this->input->LA(1);

                if ( ($LA41_0==$this->getToken('SEMICOLON')) ) {
                    $alt41=1;
                }


                switch ($alt41) {
            	case 1 :
            	    // Test.g:141:25: SEMICOLON ( verb objectList )? 
            	    {
            	    $this->match($this->input,$this->getToken('SEMICOLON'),self::$FOLLOW_SEMICOLON_in_propertyListNotEmpty868); 
            	    // Test.g:141:35: ( verb objectList )? 
            	    $alt40=2;
            	    $LA40_0 = $this->input->LA(1);

            	    if ( ($LA40_0==$this->getToken('IRI_REF')||$LA40_0==$this->getToken('A')||$LA40_0==$this->getToken('PNAME_NS')||$LA40_0==$this->getToken('PNAME_LN')||($LA40_0>=$this->getToken('VAR1') && $LA40_0<=$this->getToken('VAR2'))) ) {
            	        $alt40=1;
            	    }
            	    switch ($alt40) {
            	        case 1 :
            	            // Test.g:141:37: verb objectList 
            	            {
            	            $this->pushFollow(self::$FOLLOW_verb_in_propertyListNotEmpty872);
            	            $this->verb();

            	            $this->state->_fsp--;

            	            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmpty874);
            	            $this->objectList();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop41;
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
    // Test.g:144:1: propertyList : ( propertyListNotEmpty )? ; 
    public function propertyList(){
        try {
            // Test.g:145:5: ( ( propertyListNotEmpty )? ) 
            // Test.g:145:7: ( propertyListNotEmpty )? 
            {
            // Test.g:145:7: ( propertyListNotEmpty )? 
            $alt42=2;
            $LA42_0 = $this->input->LA(1);

            if ( ($LA42_0==$this->getToken('IRI_REF')||$LA42_0==$this->getToken('A')||$LA42_0==$this->getToken('PNAME_NS')||$LA42_0==$this->getToken('PNAME_LN')||($LA42_0>=$this->getToken('VAR1') && $LA42_0<=$this->getToken('VAR2'))) ) {
                $alt42=1;
            }
            switch ($alt42) {
                case 1 :
                    // Test.g:145:7: propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_propertyList897);
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
    // Test.g:148:1: objectList : object ( COMMA object )* ; 
    public function objectList(){
        try {
            // Test.g:149:5: ( object ( COMMA object )* ) 
            // Test.g:149:7: object ( COMMA object )* 
            {
            $this->pushFollow(self::$FOLLOW_object_in_objectList915);
            $this->object();

            $this->state->_fsp--;

            // Test.g:149:14: ( COMMA object )* 
            //loop43:
            do {
                $alt43=2;
                $LA43_0 = $this->input->LA(1);

                if ( ($LA43_0==$this->getToken('COMMA')) ) {
                    $alt43=1;
                }


                switch ($alt43) {
            	case 1 :
            	    // Test.g:149:16: COMMA object 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectList919); 
            	    $this->pushFollow(self::$FOLLOW_object_in_objectList921);
            	    $this->object();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop43;
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
    // Test.g:152:1: object : graphNode ; 
    public function object(){
        try {
            // Test.g:153:5: ( graphNode ) 
            // Test.g:153:7: graphNode 
            {
            $this->pushFollow(self::$FOLLOW_graphNode_in_object941);
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
    // Test.g:156:1: verb : ( varOrIRIref | A ); 
    public function verb(){
        try {
            // Test.g:157:5: ( varOrIRIref | A ) 
            $alt44=2;
            $LA44_0 = $this->input->LA(1);

            if ( ($LA44_0==$this->getToken('IRI_REF')||$LA44_0==$this->getToken('PNAME_NS')||$LA44_0==$this->getToken('PNAME_LN')||($LA44_0>=$this->getToken('VAR1') && $LA44_0<=$this->getToken('VAR2'))) ) {
                $alt44=1;
            }
            else if ( ($LA44_0==$this->getToken('A')) ) {
                $alt44=2;
            }
            else {
                $nvae = new NoViableAltException("", 44, 0, $this->input);

                throw $nvae;
            }
            switch ($alt44) {
                case 1 :
                    // Test.g:157:7: varOrIRIref 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrIRIref_in_verb958);
                    $this->varOrIRIref();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:158:7: A 
                    {
                    $this->match($this->input,$this->getToken('A'),self::$FOLLOW_A_in_verb966); 

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
    // Test.g:161:1: triplesNode : ( collection | blankNodePropertyList ); 
    public function triplesNode(){
        try {
            // Test.g:162:5: ( collection | blankNodePropertyList ) 
            $alt45=2;
            $LA45_0 = $this->input->LA(1);

            if ( ($LA45_0==$this->getToken('OPEN_BRACE')) ) {
                $alt45=1;
            }
            else if ( ($LA45_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt45=2;
            }
            else {
                $nvae = new NoViableAltException("", 45, 0, $this->input);

                throw $nvae;
            }
            switch ($alt45) {
                case 1 :
                    // Test.g:162:7: collection 
                    {
                    $this->pushFollow(self::$FOLLOW_collection_in_triplesNode983);
                    $this->collection();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:163:7: blankNodePropertyList 
                    {
                    $this->pushFollow(self::$FOLLOW_blankNodePropertyList_in_triplesNode991);
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
    // Test.g:166:1: blankNodePropertyList : OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE ; 
    public function blankNodePropertyList(){
        try {
            // Test.g:167:5: ( OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE ) 
            // Test.g:167:7: OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1008); 
            $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1010);
            $this->propertyListNotEmpty();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1012); 

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
    // Test.g:170:1: collection : OPEN_BRACE ( graphNode )+ CLOSE_BRACE ; 
    public function collection(){
        try {
            // Test.g:171:5: ( OPEN_BRACE ( graphNode )+ CLOSE_BRACE ) 
            // Test.g:171:7: OPEN_BRACE ( graphNode )+ CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_collection1029); 
            // Test.g:171:18: ( graphNode )+ 
            $cnt46=0;
            //loop46:
            do {
                $alt46=2;
                $LA46_0 = $this->input->LA(1);

                if ( ($LA46_0==$this->getToken('IRI_REF')||($LA46_0>=$this->getToken('TRUE') && $LA46_0<=$this->getToken('PNAME_NS'))||$LA46_0==$this->getToken('PNAME_LN')||($LA46_0>=$this->getToken('VAR1') && $LA46_0<=$this->getToken('VAR2'))||($LA46_0>=$this->getToken('STRING_LITERAL1') && $LA46_0<=$this->getToken('OPEN_BRACE'))||$LA46_0==$this->getToken('BLANK_NODE_LABEL')||($LA46_0>=$this->getToken('INTEGER') && $LA46_0<=$this->getToken('DECIMAL'))||($LA46_0>=$this->getToken('DOUBLE') && $LA46_0<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
                    $alt46=1;
                }


                switch ($alt46) {
            	case 1 :
            	    // Test.g:171:18: graphNode 
            	    {
            	    $this->pushFollow(self::$FOLLOW_graphNode_in_collection1031);
            	    $this->graphNode();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt46 >= 1 ) break 2;//loop46;
                        $eee =
                            new EarlyExitException(46, $this->input);
                        throw $eee;
                }
                $cnt46++;
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_collection1034); 

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
    // Test.g:174:1: graphNode : ( varOrTerm | triplesNode ); 
    public function graphNode(){
        try {
            // Test.g:175:5: ( varOrTerm | triplesNode ) 
            $alt47=2;
            $LA47 = $this->input->LA(1);
            if($this->getToken('IRI_REF')== $LA47||$this->getToken('TRUE')== $LA47||$this->getToken('FALSE')== $LA47||$this->getToken('PNAME_NS')== $LA47||$this->getToken('PNAME_LN')== $LA47||$this->getToken('VAR1')== $LA47||$this->getToken('VAR2')== $LA47||$this->getToken('STRING_LITERAL1')== $LA47||$this->getToken('STRING_LITERAL2')== $LA47||$this->getToken('STRING_LITERAL_LONG1')== $LA47||$this->getToken('STRING_LITERAL_LONG2')== $LA47||$this->getToken('BLANK_NODE_LABEL')== $LA47||$this->getToken('INTEGER')== $LA47||$this->getToken('DECIMAL')== $LA47||$this->getToken('DOUBLE')== $LA47||$this->getToken('INTEGER_POSITIVE')== $LA47||$this->getToken('DECIMAL_POSITIVE')== $LA47||$this->getToken('DOUBLE_POSITIVE')== $LA47||$this->getToken('INTEGER_NEGATIVE')== $LA47||$this->getToken('DECIMAL_NEGATIVE')== $LA47||$this->getToken('DOUBLE_NEGATIVE')== $LA47)
                {
                $alt47=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA47)
                {
                $LA47_2 = $this->input->LA(2);

                if ( ($LA47_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt47=1;
                }
                else if ( ($LA47_2==$this->getToken('IRI_REF')||$LA47_2==$this->getToken('A')||$LA47_2==$this->getToken('PNAME_NS')||$LA47_2==$this->getToken('PNAME_LN')||($LA47_2>=$this->getToken('VAR1') && $LA47_2<=$this->getToken('VAR2'))) ) {
                    $alt47=2;
                }
                else {
                    $nvae = new NoViableAltException("", 47, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA47)
                {
                $LA47_3 = $this->input->LA(2);

                if ( ($LA47_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt47=1;
                }
                else if ( ($LA47_3==$this->getToken('IRI_REF')||($LA47_3>=$this->getToken('TRUE') && $LA47_3<=$this->getToken('PNAME_NS'))||$LA47_3==$this->getToken('PNAME_LN')||($LA47_3>=$this->getToken('VAR1') && $LA47_3<=$this->getToken('VAR2'))||($LA47_3>=$this->getToken('STRING_LITERAL1') && $LA47_3<=$this->getToken('OPEN_BRACE'))||$LA47_3==$this->getToken('BLANK_NODE_LABEL')||($LA47_3>=$this->getToken('INTEGER') && $LA47_3<=$this->getToken('DECIMAL'))||($LA47_3>=$this->getToken('DOUBLE') && $LA47_3<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
                    $alt47=2;
                }
                else {
                    $nvae = new NoViableAltException("", 47, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 47, 0, $this->input);

                throw $nvae;
            }

            switch ($alt47) {
                case 1 :
                    // Test.g:175:7: varOrTerm 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_graphNode1051);
                    $this->varOrTerm();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:175:19: triplesNode 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_graphNode1055);
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
    // Test.g:178:1: varOrTerm : ( variable | graphTerm ); 
    public function varOrTerm(){
        try {
            // Test.g:179:5: ( variable | graphTerm ) 
            $alt48=2;
            $LA48_0 = $this->input->LA(1);

            if ( (($LA48_0>=$this->getToken('VAR1') && $LA48_0<=$this->getToken('VAR2'))) ) {
                $alt48=1;
            }
            else if ( ($LA48_0==$this->getToken('IRI_REF')||($LA48_0>=$this->getToken('TRUE') && $LA48_0<=$this->getToken('PNAME_NS'))||$LA48_0==$this->getToken('PNAME_LN')||($LA48_0>=$this->getToken('STRING_LITERAL1') && $LA48_0<=$this->getToken('OPEN_BRACE'))||$LA48_0==$this->getToken('BLANK_NODE_LABEL')||($LA48_0>=$this->getToken('INTEGER') && $LA48_0<=$this->getToken('DECIMAL'))||($LA48_0>=$this->getToken('DOUBLE') && $LA48_0<=$this->getToken('OPEN_SQUARE_BRACE'))) ) {
                $alt48=2;
            }
            else {
                $nvae = new NoViableAltException("", 48, 0, $this->input);

                throw $nvae;
            }
            switch ($alt48) {
                case 1 :
                    // Test.g:179:7: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_varOrTerm1072);
                    $this->variable();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:180:7: graphTerm 
                    {
                    $this->pushFollow(self::$FOLLOW_graphTerm_in_varOrTerm1080);
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
    // Test.g:183:1: varOrIRIref : ( variable | iriRef ); 
    public function varOrIRIref(){
        try {
            // Test.g:184:5: ( variable | iriRef ) 
            $alt49=2;
            $LA49_0 = $this->input->LA(1);

            if ( (($LA49_0>=$this->getToken('VAR1') && $LA49_0<=$this->getToken('VAR2'))) ) {
                $alt49=1;
            }
            else if ( ($LA49_0==$this->getToken('IRI_REF')||$LA49_0==$this->getToken('PNAME_NS')||$LA49_0==$this->getToken('PNAME_LN')) ) {
                $alt49=2;
            }
            else {
                $nvae = new NoViableAltException("", 49, 0, $this->input);

                throw $nvae;
            }
            switch ($alt49) {
                case 1 :
                    // Test.g:184:7: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_varOrIRIref1097);
                    $this->variable();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:184:18: iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_varOrIRIref1101);
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
    // Test.g:187:1: variable : ( VAR1 | VAR2 ); 
    public function variable(){
        try {
            // Test.g:188:5: ( VAR1 | VAR2 ) 
            // Test.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('VAR1') && $this->input->LA(1)<=$this->getToken('VAR2')) ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw mse;
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
    // Test.g:192:1: graphTerm : ( iriRef | rdfLiteral | numericLiteral | booleanLiteral | blankNode | OPEN_BRACE CLOSE_BRACE ); 
    public function graphTerm(){
        try {
            // Test.g:193:5: ( iriRef | rdfLiteral | numericLiteral | booleanLiteral | blankNode | OPEN_BRACE CLOSE_BRACE ) 
            $alt50=6;
            $LA50 = $this->input->LA(1);
            if($this->getToken('IRI_REF')== $LA50||$this->getToken('PNAME_NS')== $LA50||$this->getToken('PNAME_LN')== $LA50)
                {
                $alt50=1;
                }
            else if($this->getToken('STRING_LITERAL1')== $LA50||$this->getToken('STRING_LITERAL2')== $LA50||$this->getToken('STRING_LITERAL_LONG1')== $LA50||$this->getToken('STRING_LITERAL_LONG2')== $LA50)
                {
                $alt50=2;
                }
            else if($this->getToken('INTEGER')== $LA50||$this->getToken('DECIMAL')== $LA50||$this->getToken('DOUBLE')== $LA50||$this->getToken('INTEGER_POSITIVE')== $LA50||$this->getToken('DECIMAL_POSITIVE')== $LA50||$this->getToken('DOUBLE_POSITIVE')== $LA50||$this->getToken('INTEGER_NEGATIVE')== $LA50||$this->getToken('DECIMAL_NEGATIVE')== $LA50||$this->getToken('DOUBLE_NEGATIVE')== $LA50)
                {
                $alt50=3;
                }
            else if($this->getToken('TRUE')== $LA50||$this->getToken('FALSE')== $LA50)
                {
                $alt50=4;
                }
            else if($this->getToken('BLANK_NODE_LABEL')== $LA50||$this->getToken('OPEN_SQUARE_BRACE')== $LA50)
                {
                $alt50=5;
                }
            else if($this->getToken('OPEN_BRACE')== $LA50)
                {
                $alt50=6;
                }
            else{
                $nvae =
                    new NoViableAltException("", 50, 0, $this->input);

                throw $nvae;
            }

            switch ($alt50) {
                case 1 :
                    // Test.g:193:7: iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_graphTerm1143);
                    $this->iriRef();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:194:7: rdfLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_rdfLiteral_in_graphTerm1151);
                    $this->rdfLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Test.g:195:7: numericLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteral_in_graphTerm1159);
                    $this->numericLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Test.g:196:7: booleanLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_booleanLiteral_in_graphTerm1167);
                    $this->booleanLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Test.g:197:7: blankNode 
                    {
                    $this->pushFollow(self::$FOLLOW_blankNode_in_graphTerm1175);
                    $this->blankNode();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Test.g:198:7: OPEN_BRACE CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_graphTerm1183); 
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_graphTerm1185); 

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
    // Test.g:201:1: expression : conditionalOrExpression ; 
    public function expression(){
        try {
            // Test.g:202:5: ( conditionalOrExpression ) 
            // Test.g:202:7: conditionalOrExpression 
            {
            $this->pushFollow(self::$FOLLOW_conditionalOrExpression_in_expression1202);
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
    // Test.g:205:1: conditionalOrExpression : conditionalAndExpression ( OR conditionalAndExpression )* ; 
    public function conditionalOrExpression(){
        try {
            // Test.g:206:5: ( conditionalAndExpression ( OR conditionalAndExpression )* ) 
            // Test.g:206:7: conditionalAndExpression ( OR conditionalAndExpression )* 
            {
            $this->pushFollow(self::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1219);
            $this->conditionalAndExpression();

            $this->state->_fsp--;

            // Test.g:206:32: ( OR conditionalAndExpression )* 
            //loop51:
            do {
                $alt51=2;
                $LA51_0 = $this->input->LA(1);

                if ( ($LA51_0==$this->getToken('OR')) ) {
                    $alt51=1;
                }


                switch ($alt51) {
            	case 1 :
            	    // Test.g:206:34: OR conditionalAndExpression 
            	    {
            	    $this->match($this->input,$this->getToken('OR'),self::$FOLLOW_OR_in_conditionalOrExpression1223); 
            	    $this->pushFollow(self::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1225);
            	    $this->conditionalAndExpression();

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
    // $ANTLR end "conditionalOrExpression"


    // $ANTLR start "conditionalAndExpression"
    // Test.g:209:1: conditionalAndExpression : valueLogical ( AND valueLogical )* ; 
    public function conditionalAndExpression(){
        try {
            // Test.g:210:5: ( valueLogical ( AND valueLogical )* ) 
            // Test.g:210:7: valueLogical ( AND valueLogical )* 
            {
            $this->pushFollow(self::$FOLLOW_valueLogical_in_conditionalAndExpression1245);
            $this->valueLogical();

            $this->state->_fsp--;

            // Test.g:210:20: ( AND valueLogical )* 
            //loop52:
            do {
                $alt52=2;
                $LA52_0 = $this->input->LA(1);

                if ( ($LA52_0==$this->getToken('AND')) ) {
                    $alt52=1;
                }


                switch ($alt52) {
            	case 1 :
            	    // Test.g:210:22: AND valueLogical 
            	    {
            	    $this->match($this->input,$this->getToken('AND'),self::$FOLLOW_AND_in_conditionalAndExpression1249); 
            	    $this->pushFollow(self::$FOLLOW_valueLogical_in_conditionalAndExpression1251);
            	    $this->valueLogical();

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
    // $ANTLR end "conditionalAndExpression"


    // $ANTLR start "valueLogical"
    // Test.g:213:1: valueLogical : relationalExpression ; 
    public function valueLogical(){
        try {
            // Test.g:214:5: ( relationalExpression ) 
            // Test.g:214:7: relationalExpression 
            {
            $this->pushFollow(self::$FOLLOW_relationalExpression_in_valueLogical1271);
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
    // Test.g:217:1: relationalExpression : numericExpression ( EQUAL numericExpression | NOT_EQUAL numericExpression | LESS numericExpression | GREATER numericExpression | LESS_EQUAL numericExpression | GREATER_EQUAL numericExpression )? ; 
    public function relationalExpression(){
        try {
            // Test.g:218:5: ( numericExpression ( EQUAL numericExpression | NOT_EQUAL numericExpression | LESS numericExpression | GREATER numericExpression | LESS_EQUAL numericExpression | GREATER_EQUAL numericExpression )? ) 
            // Test.g:218:7: numericExpression ( EQUAL numericExpression | NOT_EQUAL numericExpression | LESS numericExpression | GREATER numericExpression | LESS_EQUAL numericExpression | GREATER_EQUAL numericExpression )? 
            {
            $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1288);
            $this->numericExpression();

            $this->state->_fsp--;

            // Test.g:218:25: ( EQUAL numericExpression | NOT_EQUAL numericExpression | LESS numericExpression | GREATER numericExpression | LESS_EQUAL numericExpression | GREATER_EQUAL numericExpression )? 
            $alt53=7;
            $LA53 = $this->input->LA(1);
            if($this->getToken('EQUAL')== $LA53)
                {
                $alt53=1;
                }
            else if($this->getToken('NOT_EQUAL')== $LA53)
                {
                $alt53=2;
                }
            else if($this->getToken('LESS')== $LA53)
                {
                $alt53=3;
                }
            else if($this->getToken('GREATER')== $LA53)
                {
                $alt53=4;
                }
            else if($this->getToken('LESS_EQUAL')== $LA53)
                {
                $alt53=5;
                }
            else if($this->getToken('GREATER_EQUAL')== $LA53)
                {
                $alt53=6;
                }

            switch ($alt53) {
                case 1 :
                    // Test.g:218:27: EQUAL numericExpression 
                    {
                    $this->match($this->input,$this->getToken('EQUAL'),self::$FOLLOW_EQUAL_in_relationalExpression1292); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1294);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:218:53: NOT_EQUAL numericExpression 
                    {
                    $this->match($this->input,$this->getToken('NOT_EQUAL'),self::$FOLLOW_NOT_EQUAL_in_relationalExpression1298); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1300);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Test.g:218:83: LESS numericExpression 
                    {
                    $this->match($this->input,$this->getToken('LESS'),self::$FOLLOW_LESS_in_relationalExpression1304); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1306);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Test.g:218:108: GREATER numericExpression 
                    {
                    $this->match($this->input,$this->getToken('GREATER'),self::$FOLLOW_GREATER_in_relationalExpression1310); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1312);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Test.g:218:136: LESS_EQUAL numericExpression 
                    {
                    $this->match($this->input,$this->getToken('LESS_EQUAL'),self::$FOLLOW_LESS_EQUAL_in_relationalExpression1316); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1318);
                    $this->numericExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Test.g:218:167: GREATER_EQUAL numericExpression 
                    {
                    $this->match($this->input,$this->getToken('GREATER_EQUAL'),self::$FOLLOW_GREATER_EQUAL_in_relationalExpression1322); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression1324);
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
    // Test.g:221:1: numericExpression : additiveExpression ; 
    public function numericExpression(){
        try {
            // Test.g:222:5: ( additiveExpression ) 
            // Test.g:222:7: additiveExpression 
            {
            $this->pushFollow(self::$FOLLOW_additiveExpression_in_numericExpression1344);
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
    // Test.g:225:1: additiveExpression : multiplicativeExpression ( PLUS multiplicativeExpression | MINUS multiplicativeExpression | numericLiteralPositive | numericLiteralNegative )* ; 
    public function additiveExpression(){
        try {
            // Test.g:226:5: ( multiplicativeExpression ( PLUS multiplicativeExpression | MINUS multiplicativeExpression | numericLiteralPositive | numericLiteralNegative )* ) 
            // Test.g:226:7: multiplicativeExpression ( PLUS multiplicativeExpression | MINUS multiplicativeExpression | numericLiteralPositive | numericLiteralNegative )* 
            {
            $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1361);
            $this->multiplicativeExpression();

            $this->state->_fsp--;

            // Test.g:226:32: ( PLUS multiplicativeExpression | MINUS multiplicativeExpression | numericLiteralPositive | numericLiteralNegative )* 
            //loop54:
            do {
                $alt54=5;
                $LA54 = $this->input->LA(1);
                if($this->getToken('PLUS')== $LA54)
                    {
                    $alt54=1;
                    }
                else if($this->getToken('MINUS')== $LA54)
                    {
                    $alt54=2;
                    }
                else if($this->getToken('INTEGER_POSITIVE')== $LA54||$this->getToken('DECIMAL_POSITIVE')== $LA54||$this->getToken('DOUBLE_POSITIVE')== $LA54)
                    {
                    $alt54=3;
                    }
                else if($this->getToken('INTEGER_NEGATIVE')== $LA54||$this->getToken('DECIMAL_NEGATIVE')== $LA54||$this->getToken('DOUBLE_NEGATIVE')== $LA54)
                    {
                    $alt54=4;
                    }



                switch ($alt54) {
            	case 1 :
            	    // Test.g:226:34: PLUS multiplicativeExpression 
            	    {
            	    $this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_additiveExpression1365); 
            	    $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1367);
            	    $this->multiplicativeExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // Test.g:226:66: MINUS multiplicativeExpression 
            	    {
            	    $this->match($this->input,$this->getToken('MINUS'),self::$FOLLOW_MINUS_in_additiveExpression1371); 
            	    $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression1373);
            	    $this->multiplicativeExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 3 :
            	    // Test.g:226:99: numericLiteralPositive 
            	    {
            	    $this->pushFollow(self::$FOLLOW_numericLiteralPositive_in_additiveExpression1377);
            	    $this->numericLiteralPositive();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 4 :
            	    // Test.g:226:124: numericLiteralNegative 
            	    {
            	    $this->pushFollow(self::$FOLLOW_numericLiteralNegative_in_additiveExpression1381);
            	    $this->numericLiteralNegative();

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
    // $ANTLR end "additiveExpression"


    // $ANTLR start "multiplicativeExpression"
    // Test.g:229:1: multiplicativeExpression : unaryExpression ( ASTERISK unaryExpression | DIVIDE unaryExpression )* ; 
    public function multiplicativeExpression(){
        try {
            // Test.g:230:5: ( unaryExpression ( ASTERISK unaryExpression | DIVIDE unaryExpression )* ) 
            // Test.g:230:7: unaryExpression ( ASTERISK unaryExpression | DIVIDE unaryExpression )* 
            {
            $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1401);
            $this->unaryExpression();

            $this->state->_fsp--;

            // Test.g:230:23: ( ASTERISK unaryExpression | DIVIDE unaryExpression )* 
            //loop55:
            do {
                $alt55=3;
                $LA55_0 = $this->input->LA(1);

                if ( ($LA55_0==$this->getToken('ASTERISK')) ) {
                    $alt55=1;
                }
                else if ( ($LA55_0==$this->getToken('DIVIDE')) ) {
                    $alt55=2;
                }


                switch ($alt55) {
            	case 1 :
            	    // Test.g:230:25: ASTERISK unaryExpression 
            	    {
            	    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_multiplicativeExpression1405); 
            	    $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1407);
            	    $this->unaryExpression();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // Test.g:230:52: DIVIDE unaryExpression 
            	    {
            	    $this->match($this->input,$this->getToken('DIVIDE'),self::$FOLLOW_DIVIDE_in_multiplicativeExpression1411); 
            	    $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression1413);
            	    $this->unaryExpression();

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
    // $ANTLR end "multiplicativeExpression"


    // $ANTLR start "unaryExpression"
    // Test.g:233:1: unaryExpression : ( NOT primaryExpression | PLUS primaryExpression | MINUS primaryExpression | primaryExpression ); 
    public function unaryExpression(){
        try {
            // Test.g:234:5: ( NOT primaryExpression | PLUS primaryExpression | MINUS primaryExpression | primaryExpression ) 
            $alt56=4;
            $LA56 = $this->input->LA(1);
            if($this->getToken('NOT')== $LA56)
                {
                $alt56=1;
                }
            else if($this->getToken('PLUS')== $LA56)
                {
                $alt56=2;
                }
            else if($this->getToken('MINUS')== $LA56)
                {
                $alt56=3;
                }
            else if($this->getToken('IRI_REF')== $LA56||$this->getToken('STR')== $LA56||$this->getToken('LANG')== $LA56||$this->getToken('LANGMATCHES')== $LA56||$this->getToken('DATATYPE')== $LA56||$this->getToken('BOUND')== $LA56||$this->getToken('SAMETERM')== $LA56||$this->getToken('ISIRI')== $LA56||$this->getToken('ISURI')== $LA56||$this->getToken('ISBLANK')== $LA56||$this->getToken('ISLITERAL')== $LA56||$this->getToken('REGEX')== $LA56||$this->getToken('TRUE')== $LA56||$this->getToken('FALSE')== $LA56||$this->getToken('PNAME_NS')== $LA56||$this->getToken('PNAME_LN')== $LA56||$this->getToken('VAR1')== $LA56||$this->getToken('VAR2')== $LA56||$this->getToken('STRING_LITERAL1')== $LA56||$this->getToken('STRING_LITERAL2')== $LA56||$this->getToken('STRING_LITERAL_LONG1')== $LA56||$this->getToken('STRING_LITERAL_LONG2')== $LA56||$this->getToken('OPEN_BRACE')== $LA56||$this->getToken('INTEGER')== $LA56||$this->getToken('DECIMAL')== $LA56||$this->getToken('DOUBLE')== $LA56||$this->getToken('INTEGER_POSITIVE')== $LA56||$this->getToken('DECIMAL_POSITIVE')== $LA56||$this->getToken('DOUBLE_POSITIVE')== $LA56||$this->getToken('INTEGER_NEGATIVE')== $LA56||$this->getToken('DECIMAL_NEGATIVE')== $LA56||$this->getToken('DOUBLE_NEGATIVE')== $LA56)
                {
                $alt56=4;
                }
            else{
                $nvae =
                    new NoViableAltException("", 56, 0, $this->input);

                throw $nvae;
            }

            switch ($alt56) {
                case 1 :
                    // Test.g:234:7: NOT primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('NOT'),self::$FOLLOW_NOT_in_unaryExpression1433); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1435);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:235:7: PLUS primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_unaryExpression1443); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1445);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Test.g:236:7: MINUS primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('MINUS'),self::$FOLLOW_MINUS_in_unaryExpression1453); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1455);
                    $this->primaryExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Test.g:237:7: primaryExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression1463);
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
    // Test.g:240:1: primaryExpression : ( brackettedExpression | builtInCall | iriRefOrFunction | rdfLiteral | numericLiteral | booleanLiteral | variable ); 
    public function primaryExpression(){
        try {
            // Test.g:241:5: ( brackettedExpression | builtInCall | iriRefOrFunction | rdfLiteral | numericLiteral | booleanLiteral | variable ) 
            $alt57=7;
            $LA57 = $this->input->LA(1);
            if($this->getToken('OPEN_BRACE')== $LA57)
                {
                $alt57=1;
                }
            else if($this->getToken('STR')== $LA57||$this->getToken('LANG')== $LA57||$this->getToken('LANGMATCHES')== $LA57||$this->getToken('DATATYPE')== $LA57||$this->getToken('BOUND')== $LA57||$this->getToken('SAMETERM')== $LA57||$this->getToken('ISIRI')== $LA57||$this->getToken('ISURI')== $LA57||$this->getToken('ISBLANK')== $LA57||$this->getToken('ISLITERAL')== $LA57||$this->getToken('REGEX')== $LA57)
                {
                $alt57=2;
                }
            else if($this->getToken('IRI_REF')== $LA57||$this->getToken('PNAME_NS')== $LA57||$this->getToken('PNAME_LN')== $LA57)
                {
                $alt57=3;
                }
            else if($this->getToken('STRING_LITERAL1')== $LA57||$this->getToken('STRING_LITERAL2')== $LA57||$this->getToken('STRING_LITERAL_LONG1')== $LA57||$this->getToken('STRING_LITERAL_LONG2')== $LA57)
                {
                $alt57=4;
                }
            else if($this->getToken('INTEGER')== $LA57||$this->getToken('DECIMAL')== $LA57||$this->getToken('DOUBLE')== $LA57||$this->getToken('INTEGER_POSITIVE')== $LA57||$this->getToken('DECIMAL_POSITIVE')== $LA57||$this->getToken('DOUBLE_POSITIVE')== $LA57||$this->getToken('INTEGER_NEGATIVE')== $LA57||$this->getToken('DECIMAL_NEGATIVE')== $LA57||$this->getToken('DOUBLE_NEGATIVE')== $LA57)
                {
                $alt57=5;
                }
            else if($this->getToken('TRUE')== $LA57||$this->getToken('FALSE')== $LA57)
                {
                $alt57=6;
                }
            else if($this->getToken('VAR1')== $LA57||$this->getToken('VAR2')== $LA57)
                {
                $alt57=7;
                }
            else{
                $nvae =
                    new NoViableAltException("", 57, 0, $this->input);

                throw $nvae;
            }

            switch ($alt57) {
                case 1 :
                    // Test.g:241:7: brackettedExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_primaryExpression1480);
                    $this->brackettedExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:241:30: builtInCall 
                    {
                    $this->pushFollow(self::$FOLLOW_builtInCall_in_primaryExpression1484);
                    $this->builtInCall();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Test.g:241:44: iriRefOrFunction 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRefOrFunction_in_primaryExpression1488);
                    $this->iriRefOrFunction();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Test.g:241:63: rdfLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_rdfLiteral_in_primaryExpression1492);
                    $this->rdfLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Test.g:241:76: numericLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteral_in_primaryExpression1496);
                    $this->numericLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 6 :
                    // Test.g:241:93: booleanLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_booleanLiteral_in_primaryExpression1500);
                    $this->booleanLiteral();

                    $this->state->_fsp--;


                    }
                    break;
                case 7 :
                    // Test.g:241:110: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_primaryExpression1504);
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
    // Test.g:244:1: brackettedExpression : OPEN_BRACE expression CLOSE_BRACE ; 
    public function brackettedExpression(){
        try {
            // Test.g:245:5: ( OPEN_BRACE expression CLOSE_BRACE ) 
            // Test.g:245:7: OPEN_BRACE expression CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_brackettedExpression1521); 
            $this->pushFollow(self::$FOLLOW_expression_in_brackettedExpression1523);
            $this->expression();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_brackettedExpression1525); 

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
    // Test.g:248:1: builtInCall : ( STR OPEN_BRACE expression CLOSE_BRACE | LANG OPEN_BRACE expression CLOSE_BRACE | LANGMATCHES OPEN_BRACE expression COMMA expression CLOSE_BRACE | DATATYPE OPEN_BRACE expression CLOSE_BRACE | BOUND OPEN_BRACE variable CLOSE_BRACE | SAMETERM OPEN_BRACE expression COMMA expression CLOSE_BRACE | ISIRI OPEN_BRACE expression CLOSE_BRACE | ISURI OPEN_BRACE expression CLOSE_BRACE | ISBLANK OPEN_BRACE expression CLOSE_BRACE | ISLITERAL OPEN_BRACE expression CLOSE_BRACE | regexExpression ); 
    public function builtInCall(){
        try {
            // Test.g:249:5: ( STR OPEN_BRACE expression CLOSE_BRACE | LANG OPEN_BRACE expression CLOSE_BRACE | LANGMATCHES OPEN_BRACE expression COMMA expression CLOSE_BRACE | DATATYPE OPEN_BRACE expression CLOSE_BRACE | BOUND OPEN_BRACE variable CLOSE_BRACE | SAMETERM OPEN_BRACE expression COMMA expression CLOSE_BRACE | ISIRI OPEN_BRACE expression CLOSE_BRACE | ISURI OPEN_BRACE expression CLOSE_BRACE | ISBLANK OPEN_BRACE expression CLOSE_BRACE | ISLITERAL OPEN_BRACE expression CLOSE_BRACE | regexExpression ) 
            $alt58=11;
            $LA58 = $this->input->LA(1);
            if($this->getToken('STR')== $LA58)
                {
                $alt58=1;
                }
            else if($this->getToken('LANG')== $LA58)
                {
                $alt58=2;
                }
            else if($this->getToken('LANGMATCHES')== $LA58)
                {
                $alt58=3;
                }
            else if($this->getToken('DATATYPE')== $LA58)
                {
                $alt58=4;
                }
            else if($this->getToken('BOUND')== $LA58)
                {
                $alt58=5;
                }
            else if($this->getToken('SAMETERM')== $LA58)
                {
                $alt58=6;
                }
            else if($this->getToken('ISIRI')== $LA58)
                {
                $alt58=7;
                }
            else if($this->getToken('ISURI')== $LA58)
                {
                $alt58=8;
                }
            else if($this->getToken('ISBLANK')== $LA58)
                {
                $alt58=9;
                }
            else if($this->getToken('ISLITERAL')== $LA58)
                {
                $alt58=10;
                }
            else if($this->getToken('REGEX')== $LA58)
                {
                $alt58=11;
                }
            else{
                $nvae =
                    new NoViableAltException("", 58, 0, $this->input);

                throw $nvae;
            }

            switch ($alt58) {
                case 1 :
                    // Test.g:249:7: STR OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('STR'),self::$FOLLOW_STR_in_builtInCall1542); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1544); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1546);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1548); 

                    }
                    break;
                case 2 :
                    // Test.g:250:7: LANG OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('LANG'),self::$FOLLOW_LANG_in_builtInCall1556); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1558); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1560);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1562); 

                    }
                    break;
                case 3 :
                    // Test.g:251:7: LANGMATCHES OPEN_BRACE expression COMMA expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('LANGMATCHES'),self::$FOLLOW_LANGMATCHES_in_builtInCall1570); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1572); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1574);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall1576); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1578);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1580); 

                    }
                    break;
                case 4 :
                    // Test.g:252:7: DATATYPE OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('DATATYPE'),self::$FOLLOW_DATATYPE_in_builtInCall1588); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1590); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1592);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1594); 

                    }
                    break;
                case 5 :
                    // Test.g:253:7: BOUND OPEN_BRACE variable CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('BOUND'),self::$FOLLOW_BOUND_in_builtInCall1602); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1604); 
                    $this->pushFollow(self::$FOLLOW_variable_in_builtInCall1606);
                    $this->variable();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1608); 

                    }
                    break;
                case 6 :
                    // Test.g:254:7: SAMETERM OPEN_BRACE expression COMMA expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('SAMETERM'),self::$FOLLOW_SAMETERM_in_builtInCall1616); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1618); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1620);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall1622); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1624);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1626); 

                    }
                    break;
                case 7 :
                    // Test.g:255:7: ISIRI OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISIRI'),self::$FOLLOW_ISIRI_in_builtInCall1634); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1636); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1638);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1640); 

                    }
                    break;
                case 8 :
                    // Test.g:256:7: ISURI OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISURI'),self::$FOLLOW_ISURI_in_builtInCall1648); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1650); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1652);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1654); 

                    }
                    break;
                case 9 :
                    // Test.g:257:7: ISBLANK OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISBLANK'),self::$FOLLOW_ISBLANK_in_builtInCall1662); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1664); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1666);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1668); 

                    }
                    break;
                case 10 :
                    // Test.g:258:7: ISLITERAL OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISLITERAL'),self::$FOLLOW_ISLITERAL_in_builtInCall1676); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall1678); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall1680);
                    $this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall1682); 

                    }
                    break;
                case 11 :
                    // Test.g:259:7: regexExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_regexExpression_in_builtInCall1690);
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
    // Test.g:262:1: regexExpression : REGEX OPEN_BRACE expression COMMA expression ( COMMA expression )? CLOSE_BRACE ; 
    public function regexExpression(){
        try {
            // Test.g:263:5: ( REGEX OPEN_BRACE expression COMMA expression ( COMMA expression )? CLOSE_BRACE ) 
            // Test.g:263:7: REGEX OPEN_BRACE expression COMMA expression ( COMMA expression )? CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('REGEX'),self::$FOLLOW_REGEX_in_regexExpression1707); 
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_regexExpression1709); 
            $this->pushFollow(self::$FOLLOW_expression_in_regexExpression1711);
            $this->expression();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_regexExpression1713); 
            $this->pushFollow(self::$FOLLOW_expression_in_regexExpression1715);
            $this->expression();

            $this->state->_fsp--;

            // Test.g:263:52: ( COMMA expression )? 
            $alt59=2;
            $LA59_0 = $this->input->LA(1);

            if ( ($LA59_0==$this->getToken('COMMA')) ) {
                $alt59=1;
            }
            switch ($alt59) {
                case 1 :
                    // Test.g:263:54: COMMA expression 
                    {
                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_regexExpression1719); 
                    $this->pushFollow(self::$FOLLOW_expression_in_regexExpression1721);
                    $this->expression();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_regexExpression1726); 

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
    // Test.g:266:1: iriRefOrFunction : iriRef ( argList )? ; 
    public function iriRefOrFunction(){
        try {
            // Test.g:267:5: ( iriRef ( argList )? ) 
            // Test.g:267:7: iriRef ( argList )? 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_iriRefOrFunction1743);
            $this->iriRef();

            $this->state->_fsp--;

            // Test.g:267:14: ( argList )? 
            $alt60=2;
            $LA60_0 = $this->input->LA(1);

            if ( ($LA60_0==$this->getToken('OPEN_BRACE')) ) {
                $alt60=1;
            }
            switch ($alt60) {
                case 1 :
                    // Test.g:267:14: argList 
                    {
                    $this->pushFollow(self::$FOLLOW_argList_in_iriRefOrFunction1745);
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
    // Test.g:270:1: rdfLiteral : string ( LANGTAG | ( REFERENCE iriRef ) )? ; 
    public function rdfLiteral(){
        try {
            // Test.g:271:5: ( string ( LANGTAG | ( REFERENCE iriRef ) )? ) 
            // Test.g:271:7: string ( LANGTAG | ( REFERENCE iriRef ) )? 
            {
            $this->pushFollow(self::$FOLLOW_string_in_rdfLiteral1763);
            $this->string();

            $this->state->_fsp--;

            // Test.g:271:14: ( LANGTAG | ( REFERENCE iriRef ) )? 
            $alt61=3;
            $LA61_0 = $this->input->LA(1);

            if ( ($LA61_0==$this->getToken('LANGTAG')) ) {
                $alt61=1;
            }
            else if ( ($LA61_0==$this->getToken('REFERENCE')) ) {
                $alt61=2;
            }
            switch ($alt61) {
                case 1 :
                    // Test.g:271:16: LANGTAG 
                    {
                    $this->match($this->input,$this->getToken('LANGTAG'),self::$FOLLOW_LANGTAG_in_rdfLiteral1767); 

                    }
                    break;
                case 2 :
                    // Test.g:271:26: ( REFERENCE iriRef ) 
                    {
                    // Test.g:271:26: ( REFERENCE iriRef ) 
                    // Test.g:271:28: REFERENCE iriRef 
                    {
                    $this->match($this->input,$this->getToken('REFERENCE'),self::$FOLLOW_REFERENCE_in_rdfLiteral1773); 
                    $this->pushFollow(self::$FOLLOW_iriRef_in_rdfLiteral1775);
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
    // Test.g:274:1: numericLiteral : ( numericLiteralUnsigned | numericLiteralPositive | numericLiteralNegative ); 
    public function numericLiteral(){
        try {
            // Test.g:275:5: ( numericLiteralUnsigned | numericLiteralPositive | numericLiteralNegative ) 
            $alt62=3;
            $LA62 = $this->input->LA(1);
            if($this->getToken('INTEGER')== $LA62||$this->getToken('DECIMAL')== $LA62||$this->getToken('DOUBLE')== $LA62)
                {
                $alt62=1;
                }
            else if($this->getToken('INTEGER_POSITIVE')== $LA62||$this->getToken('DECIMAL_POSITIVE')== $LA62||$this->getToken('DOUBLE_POSITIVE')== $LA62)
                {
                $alt62=2;
                }
            else if($this->getToken('INTEGER_NEGATIVE')== $LA62||$this->getToken('DECIMAL_NEGATIVE')== $LA62||$this->getToken('DOUBLE_NEGATIVE')== $LA62)
                {
                $alt62=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 62, 0, $this->input);

                throw $nvae;
            }

            switch ($alt62) {
                case 1 :
                    // Test.g:275:7: numericLiteralUnsigned 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralUnsigned_in_numericLiteral1797);
                    $this->numericLiteralUnsigned();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Test.g:275:32: numericLiteralPositive 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralPositive_in_numericLiteral1801);
                    $this->numericLiteralPositive();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Test.g:275:57: numericLiteralNegative 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralNegative_in_numericLiteral1805);
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
    // Test.g:278:1: numericLiteralUnsigned : ( INTEGER | DECIMAL | DOUBLE ); 
    public function numericLiteralUnsigned(){
        try {
            // Test.g:279:5: ( INTEGER | DECIMAL | DOUBLE ) 
            // Test.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('INTEGER') && $this->input->LA(1)<=$this->getToken('DECIMAL'))||$this->input->LA(1)==$this->getToken('DOUBLE') ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw mse;
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
    // Test.g:284:1: numericLiteralPositive : ( INTEGER_POSITIVE | DECIMAL_POSITIVE | DOUBLE_POSITIVE ); 
    public function numericLiteralPositive(){
        try {
            // Test.g:285:5: ( INTEGER_POSITIVE | DECIMAL_POSITIVE | DOUBLE_POSITIVE ) 
            // Test.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('INTEGER_POSITIVE') && $this->input->LA(1)<=$this->getToken('DOUBLE_POSITIVE')) ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw mse;
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
    // Test.g:290:1: numericLiteralNegative : ( INTEGER_NEGATIVE | DECIMAL_NEGATIVE | DOUBLE_NEGATIVE ); 
    public function numericLiteralNegative(){
        try {
            // Test.g:291:5: ( INTEGER_NEGATIVE | DECIMAL_NEGATIVE | DOUBLE_NEGATIVE ) 
            // Test.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('INTEGER_NEGATIVE') && $this->input->LA(1)<=$this->getToken('DOUBLE_NEGATIVE')) ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw mse;
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
    // Test.g:296:1: booleanLiteral : ( TRUE | FALSE ); 
    public function booleanLiteral(){
        try {
            // Test.g:297:5: ( TRUE | FALSE ) 
            // Test.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('TRUE') && $this->input->LA(1)<=$this->getToken('FALSE')) ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw mse;
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
    // Test.g:301:1: string : ( STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 ); 
    public function string(){
        try {
            // Test.g:302:5: ( STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 ) 
            // Test.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('STRING_LITERAL1') && $this->input->LA(1)<=$this->getToken('STRING_LITERAL_LONG2')) ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw mse;
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
    // Test.g:308:1: iriRef : ( IRI_REF | prefixedName ); 
    public function iriRef(){
        try {
            // Test.g:309:5: ( IRI_REF | prefixedName ) 
            $alt63=2;
            $LA63_0 = $this->input->LA(1);

            if ( ($LA63_0==$this->getToken('IRI_REF')) ) {
                $alt63=1;
            }
            else if ( ($LA63_0==$this->getToken('PNAME_NS')||$LA63_0==$this->getToken('PNAME_LN')) ) {
                $alt63=2;
            }
            else {
                $nvae = new NoViableAltException("", 63, 0, $this->input);

                throw $nvae;
            }
            switch ($alt63) {
                case 1 :
                    // Test.g:309:7: IRI_REF 
                    {
                    $this->match($this->input,$this->getToken('IRI_REF'),self::$FOLLOW_IRI_REF_in_iriRef1987); 

                    }
                    break;
                case 2 :
                    // Test.g:310:7: prefixedName 
                    {
                    $this->pushFollow(self::$FOLLOW_prefixedName_in_iriRef1995);
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
    // Test.g:313:1: prefixedName : ( PNAME_LN | PNAME_NS ); 
    public function prefixedName(){
        try {
            // Test.g:314:5: ( PNAME_LN | PNAME_NS ) 
            // Test.g: 
            {
            if ( $this->input->LA(1)==$this->getToken('PNAME_NS')||$this->input->LA(1)==$this->getToken('PNAME_LN') ) {
                $this->input->consume();
                $this->state->errorRecovery=false;
            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                throw mse;
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
    // Test.g:318:1: blankNode : ( BLANK_NODE_LABEL | OPEN_SQUARE_BRACE CLOSE_SQUARE_BRACE ); 
    public function blankNode(){
        try {
            // Test.g:319:5: ( BLANK_NODE_LABEL | OPEN_SQUARE_BRACE CLOSE_SQUARE_BRACE ) 
            $alt64=2;
            $LA64_0 = $this->input->LA(1);

            if ( ($LA64_0==$this->getToken('BLANK_NODE_LABEL')) ) {
                $alt64=1;
            }
            else if ( ($LA64_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt64=2;
            }
            else {
                $nvae = new NoViableAltException("", 64, 0, $this->input);

                throw $nvae;
            }
            switch ($alt64) {
                case 1 :
                    // Test.g:319:7: BLANK_NODE_LABEL 
                    {
                    $this->match($this->input,$this->getToken('BLANK_NODE_LABEL'),self::$FOLLOW_BLANK_NODE_LABEL_in_blankNode2037); 

                    }
                    break;
                case 2 :
                    // Test.g:320:7: OPEN_SQUARE_BRACE CLOSE_SQUARE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2045); 
                    $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2047); 

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

 



TestParser::$FOLLOW_prologue_in_query37 = new Set(array(13, 16, 17, 18));
TestParser::$FOLLOW_selectQuery_in_query41 = new Set(array());
TestParser::$FOLLOW_constructQuery_in_query45 = new Set(array());
TestParser::$FOLLOW_describeQuery_in_query49 = new Set(array());
TestParser::$FOLLOW_askQuery_in_query53 = new Set(array());
TestParser::$FOLLOW_EOF_in_query57 = new Set(array(1));
TestParser::$FOLLOW_baseDecl_in_prologue74 = new Set(array(1, 12));
TestParser::$FOLLOW_prefixDecl_in_prologue77 = new Set(array(1, 12));
TestParser::$FOLLOW_BASE_in_baseDecl95 = new Set(array(8));
TestParser::$FOLLOW_IRI_REF_in_baseDecl97 = new Set(array(1));
TestParser::$FOLLOW_PREFIX_in_prefixDecl114 = new Set(array(46));
TestParser::$FOLLOW_PNAME_NS_in_prefixDecl116 = new Set(array(8));
TestParser::$FOLLOW_IRI_REF_in_prefixDecl118 = new Set(array(1));
TestParser::$FOLLOW_SELECT_in_selectQuery135 = new Set(array(14, 15, 59, 64, 65));
TestParser::$FOLLOW_set_in_selectQuery137 = new Set(array(59, 64, 65));
TestParser::$FOLLOW_variable_in_selectQuery150 = new Set(array(6, 19, 21, 64, 65));
TestParser::$FOLLOW_ASTERISK_in_selectQuery155 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_datasetClause_in_selectQuery159 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_whereClause_in_selectQuery162 = new Set(array(22, 26, 27));
TestParser::$FOLLOW_solutionModifier_in_selectQuery164 = new Set(array(1));
TestParser::$FOLLOW_CONSTRUCT_in_constructQuery181 = new Set(array(6));
TestParser::$FOLLOW_constructTemplate_in_constructQuery183 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_datasetClause_in_constructQuery185 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_whereClause_in_constructQuery188 = new Set(array(22, 26, 27));
TestParser::$FOLLOW_solutionModifier_in_constructQuery190 = new Set(array(1));
TestParser::$FOLLOW_DESCRIBE_in_describeQuery207 = new Set(array(8, 46, 48, 59, 64, 65));
TestParser::$FOLLOW_varOrIRIref_in_describeQuery211 = new Set(array(6, 8, 19, 21, 22, 26, 27, 46, 48, 64, 65));
TestParser::$FOLLOW_ASTERISK_in_describeQuery216 = new Set(array(6, 19, 21, 22, 26, 27));
TestParser::$FOLLOW_datasetClause_in_describeQuery220 = new Set(array(6, 19, 21, 22, 26, 27));
TestParser::$FOLLOW_whereClause_in_describeQuery223 = new Set(array(22, 26, 27));
TestParser::$FOLLOW_solutionModifier_in_describeQuery226 = new Set(array(1));
TestParser::$FOLLOW_ASK_in_askQuery243 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_datasetClause_in_askQuery245 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_whereClause_in_askQuery248 = new Set(array(1));
TestParser::$FOLLOW_FROM_in_datasetClause265 = new Set(array(8, 20, 46, 48, 64, 65));
TestParser::$FOLLOW_defaultGraphClause_in_datasetClause269 = new Set(array(1));
TestParser::$FOLLOW_namedGraphClause_in_datasetClause273 = new Set(array(1));
TestParser::$FOLLOW_sourceSelector_in_defaultGraphClause292 = new Set(array(1));
TestParser::$FOLLOW_NAMED_in_namedGraphClause309 = new Set(array(8, 46, 48, 64, 65));
TestParser::$FOLLOW_sourceSelector_in_namedGraphClause311 = new Set(array(1));
TestParser::$FOLLOW_iriRef_in_sourceSelector328 = new Set(array(1));
TestParser::$FOLLOW_WHERE_in_whereClause345 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_groupGraphPattern_in_whereClause348 = new Set(array(1));
TestParser::$FOLLOW_orderClause_in_solutionModifier365 = new Set(array(1, 26, 27));
TestParser::$FOLLOW_limitOffsetClauses_in_solutionModifier368 = new Set(array(1));
TestParser::$FOLLOW_limitClause_in_limitOffsetClauses388 = new Set(array(1, 26, 27));
TestParser::$FOLLOW_offsetClause_in_limitOffsetClauses390 = new Set(array(1));
TestParser::$FOLLOW_offsetClause_in_limitOffsetClauses395 = new Set(array(1, 26));
TestParser::$FOLLOW_limitClause_in_limitOffsetClauses397 = new Set(array(1));
TestParser::$FOLLOW_ORDER_in_orderClause417 = new Set(array(23));
TestParser::$FOLLOW_BY_in_orderClause419 = new Set(array(8, 24, 25, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 46, 48, 64, 65, 71));
TestParser::$FOLLOW_orderCondition_in_orderClause421 = new Set(array(1, 8, 24, 25, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 46, 48, 64, 65, 71));
TestParser::$FOLLOW_set_in_orderCondition441 = new Set(array(71));
TestParser::$FOLLOW_brackettedExpression_in_orderCondition451 = new Set(array(1));
TestParser::$FOLLOW_constraint_in_orderCondition463 = new Set(array(1));
TestParser::$FOLLOW_variable_in_orderCondition467 = new Set(array(1));
TestParser::$FOLLOW_LIMIT_in_limitClause486 = new Set(array(81));
TestParser::$FOLLOW_INTEGER_in_limitClause488 = new Set(array(1));
TestParser::$FOLLOW_OFFSET_in_offsetClause505 = new Set(array(81));
TestParser::$FOLLOW_INTEGER_in_offsetClause507 = new Set(array(1));
TestParser::$FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern524 = new Set(array(6, 7, 8, 19, 21, 28, 29, 31, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_triplesBlock_in_groupGraphPattern526 = new Set(array(6, 7, 19, 21, 28, 29, 31));
TestParser::$FOLLOW_graphPatternNotTriples_in_groupGraphPattern533 = new Set(array(6, 7, 8, 19, 21, 28, 29, 31, 44, 45, 46, 48, 52, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_filter_in_groupGraphPattern537 = new Set(array(6, 7, 8, 19, 21, 28, 29, 31, 44, 45, 46, 48, 52, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_DOT_in_groupGraphPattern541 = new Set(array(6, 7, 8, 19, 21, 28, 29, 31, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_triplesBlock_in_groupGraphPattern544 = new Set(array(6, 7, 19, 21, 28, 29, 31));
TestParser::$FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern550 = new Set(array(1));
TestParser::$FOLLOW_triplesSameSubject_in_triplesBlock567 = new Set(array(1, 52));
TestParser::$FOLLOW_DOT_in_triplesBlock571 = new Set(array(1, 8, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_triplesBlock_in_triplesBlock573 = new Set(array(1));
TestParser::$FOLLOW_optionalGraphPattern_in_graphPatternNotTriples594 = new Set(array(1));
TestParser::$FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples598 = new Set(array(1));
TestParser::$FOLLOW_graphGraphPattern_in_graphPatternNotTriples602 = new Set(array(1));
TestParser::$FOLLOW_OPTIONAL_in_optionalGraphPattern619 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_groupGraphPattern_in_optionalGraphPattern621 = new Set(array(1));
TestParser::$FOLLOW_GRAPH_in_graphGraphPattern638 = new Set(array(8, 46, 48, 64, 65));
TestParser::$FOLLOW_varOrIRIref_in_graphGraphPattern640 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_groupGraphPattern_in_graphGraphPattern642 = new Set(array(1));
TestParser::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern659 = new Set(array(1, 30));
TestParser::$FOLLOW_UNION_in_groupOrUnionGraphPattern663 = new Set(array(6, 19, 21));
TestParser::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern665 = new Set(array(1, 30));
TestParser::$FOLLOW_FILTER_in_filter685 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 46, 48, 64, 65, 71));
TestParser::$FOLLOW_constraint_in_filter687 = new Set(array(1));
TestParser::$FOLLOW_brackettedExpression_in_constraint704 = new Set(array(1));
TestParser::$FOLLOW_builtInCall_in_constraint708 = new Set(array(1));
TestParser::$FOLLOW_functionCall_in_constraint712 = new Set(array(1));
TestParser::$FOLLOW_iriRef_in_functionCall729 = new Set(array(71));
TestParser::$FOLLOW_argList_in_functionCall731 = new Set(array(1));
TestParser::$FOLLOW_OPEN_BRACE_in_argList750 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_argList752 = new Set(array(1));
TestParser::$FOLLOW_OPEN_BRACE_in_argList756 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_argList758 = new Set(array(60, 72));
TestParser::$FOLLOW_COMMA_in_argList762 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_argList764 = new Set(array(60, 72));
TestParser::$FOLLOW_CLOSE_BRACE_in_argList769 = new Set(array(1));
TestParser::$FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate788 = new Set(array(7, 8, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_constructTriples_in_constructTemplate790 = new Set(array(7));
TestParser::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate793 = new Set(array(1));
TestParser::$FOLLOW_triplesSameSubject_in_constructTriples810 = new Set(array(1, 52));
TestParser::$FOLLOW_DOT_in_constructTriples814 = new Set(array(1, 8, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_constructTriples_in_constructTriples816 = new Set(array(1));
TestParser::$FOLLOW_varOrTerm_in_triplesSameSubject837 = new Set(array(8, 32, 46, 48, 64, 65));
TestParser::$FOLLOW_propertyListNotEmpty_in_triplesSameSubject839 = new Set(array(1));
TestParser::$FOLLOW_triplesNode_in_triplesSameSubject843 = new Set(array(8, 32, 46, 48, 64, 65));
TestParser::$FOLLOW_propertyList_in_triplesSameSubject845 = new Set(array(1));
TestParser::$FOLLOW_verb_in_propertyListNotEmpty862 = new Set(array(8, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_objectList_in_propertyListNotEmpty864 = new Set(array(1, 57));
TestParser::$FOLLOW_SEMICOLON_in_propertyListNotEmpty868 = new Set(array(1, 8, 32, 46, 48, 57, 64, 65));
TestParser::$FOLLOW_verb_in_propertyListNotEmpty872 = new Set(array(8, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_objectList_in_propertyListNotEmpty874 = new Set(array(1, 57));
TestParser::$FOLLOW_propertyListNotEmpty_in_propertyList897 = new Set(array(1));
TestParser::$FOLLOW_object_in_objectList915 = new Set(array(1, 60));
TestParser::$FOLLOW_COMMA_in_objectList919 = new Set(array(8, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_object_in_objectList921 = new Set(array(1, 60));
TestParser::$FOLLOW_graphNode_in_object941 = new Set(array(1));
TestParser::$FOLLOW_varOrIRIref_in_verb958 = new Set(array(1));
TestParser::$FOLLOW_A_in_verb966 = new Set(array(1));
TestParser::$FOLLOW_collection_in_triplesNode983 = new Set(array(1));
TestParser::$FOLLOW_blankNodePropertyList_in_triplesNode991 = new Set(array(1));
TestParser::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1008 = new Set(array(8, 32, 46, 48, 64, 65));
TestParser::$FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1010 = new Set(array(92));
TestParser::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1012 = new Set(array(1));
TestParser::$FOLLOW_OPEN_BRACE_in_collection1029 = new Set(array(8, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_graphNode_in_collection1031 = new Set(array(8, 44, 45, 46, 48, 64, 65, 67, 68, 69, 70, 71, 72, 79, 81, 82, 84, 85, 86, 87, 88, 89, 90, 91));
TestParser::$FOLLOW_CLOSE_BRACE_in_collection1034 = new Set(array(1));
TestParser::$FOLLOW_varOrTerm_in_graphNode1051 = new Set(array(1));
TestParser::$FOLLOW_triplesNode_in_graphNode1055 = new Set(array(1));
TestParser::$FOLLOW_variable_in_varOrTerm1072 = new Set(array(1));
TestParser::$FOLLOW_graphTerm_in_varOrTerm1080 = new Set(array(1));
TestParser::$FOLLOW_variable_in_varOrIRIref1097 = new Set(array(1));
TestParser::$FOLLOW_iriRef_in_varOrIRIref1101 = new Set(array(1));
TestParser::$FOLLOW_set_in_variable0 = new Set(array(1));
TestParser::$FOLLOW_iriRef_in_graphTerm1143 = new Set(array(1));
TestParser::$FOLLOW_rdfLiteral_in_graphTerm1151 = new Set(array(1));
TestParser::$FOLLOW_numericLiteral_in_graphTerm1159 = new Set(array(1));
TestParser::$FOLLOW_booleanLiteral_in_graphTerm1167 = new Set(array(1));
TestParser::$FOLLOW_blankNode_in_graphTerm1175 = new Set(array(1));
TestParser::$FOLLOW_OPEN_BRACE_in_graphTerm1183 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_graphTerm1185 = new Set(array(1));
TestParser::$FOLLOW_conditionalOrExpression_in_expression1202 = new Set(array(1));
TestParser::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1219 = new Set(array(1, 78));
TestParser::$FOLLOW_OR_in_conditionalOrExpression1223 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1225 = new Set(array(1, 78));
TestParser::$FOLLOW_valueLogical_in_conditionalAndExpression1245 = new Set(array(1, 77));
TestParser::$FOLLOW_AND_in_conditionalAndExpression1249 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_valueLogical_in_conditionalAndExpression1251 = new Set(array(1, 77));
TestParser::$FOLLOW_relationalExpression_in_valueLogical1271 = new Set(array(1));
TestParser::$FOLLOW_numericExpression_in_relationalExpression1288 = new Set(array(1, 4, 5, 63, 74, 75, 76));
TestParser::$FOLLOW_EQUAL_in_relationalExpression1292 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_numericExpression_in_relationalExpression1294 = new Set(array(1));
TestParser::$FOLLOW_NOT_EQUAL_in_relationalExpression1298 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_numericExpression_in_relationalExpression1300 = new Set(array(1));
TestParser::$FOLLOW_LESS_in_relationalExpression1304 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_numericExpression_in_relationalExpression1306 = new Set(array(1));
TestParser::$FOLLOW_GREATER_in_relationalExpression1310 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_numericExpression_in_relationalExpression1312 = new Set(array(1));
TestParser::$FOLLOW_LESS_EQUAL_in_relationalExpression1316 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_numericExpression_in_relationalExpression1318 = new Set(array(1));
TestParser::$FOLLOW_GREATER_EQUAL_in_relationalExpression1322 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_numericExpression_in_relationalExpression1324 = new Set(array(1));
TestParser::$FOLLOW_additiveExpression_in_numericExpression1344 = new Set(array(1));
TestParser::$FOLLOW_multiplicativeExpression_in_additiveExpression1361 = new Set(array(1, 56, 58, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_PLUS_in_additiveExpression1365 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_multiplicativeExpression_in_additiveExpression1367 = new Set(array(1, 56, 58, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_MINUS_in_additiveExpression1371 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_multiplicativeExpression_in_additiveExpression1373 = new Set(array(1, 56, 58, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_numericLiteralPositive_in_additiveExpression1377 = new Set(array(1, 56, 58, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_numericLiteralNegative_in_additiveExpression1381 = new Set(array(1, 56, 58, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_unaryExpression_in_multiplicativeExpression1401 = new Set(array(1, 59, 62));
TestParser::$FOLLOW_ASTERISK_in_multiplicativeExpression1405 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_unaryExpression_in_multiplicativeExpression1407 = new Set(array(1, 59, 62));
TestParser::$FOLLOW_DIVIDE_in_multiplicativeExpression1411 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_unaryExpression_in_multiplicativeExpression1413 = new Set(array(1, 59, 62));
TestParser::$FOLLOW_NOT_in_unaryExpression1433 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_primaryExpression_in_unaryExpression1435 = new Set(array(1));
TestParser::$FOLLOW_PLUS_in_unaryExpression1443 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_primaryExpression_in_unaryExpression1445 = new Set(array(1));
TestParser::$FOLLOW_MINUS_in_unaryExpression1453 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_primaryExpression_in_unaryExpression1455 = new Set(array(1));
TestParser::$FOLLOW_primaryExpression_in_unaryExpression1463 = new Set(array(1));
TestParser::$FOLLOW_brackettedExpression_in_primaryExpression1480 = new Set(array(1));
TestParser::$FOLLOW_builtInCall_in_primaryExpression1484 = new Set(array(1));
TestParser::$FOLLOW_iriRefOrFunction_in_primaryExpression1488 = new Set(array(1));
TestParser::$FOLLOW_rdfLiteral_in_primaryExpression1492 = new Set(array(1));
TestParser::$FOLLOW_numericLiteral_in_primaryExpression1496 = new Set(array(1));
TestParser::$FOLLOW_booleanLiteral_in_primaryExpression1500 = new Set(array(1));
TestParser::$FOLLOW_variable_in_primaryExpression1504 = new Set(array(1));
TestParser::$FOLLOW_OPEN_BRACE_in_brackettedExpression1521 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_brackettedExpression1523 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_brackettedExpression1525 = new Set(array(1));
TestParser::$FOLLOW_STR_in_builtInCall1542 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1544 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1546 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1548 = new Set(array(1));
TestParser::$FOLLOW_LANG_in_builtInCall1556 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1558 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1560 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1562 = new Set(array(1));
TestParser::$FOLLOW_LANGMATCHES_in_builtInCall1570 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1572 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1574 = new Set(array(60));
TestParser::$FOLLOW_COMMA_in_builtInCall1576 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1578 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1580 = new Set(array(1));
TestParser::$FOLLOW_DATATYPE_in_builtInCall1588 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1590 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1592 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1594 = new Set(array(1));
TestParser::$FOLLOW_BOUND_in_builtInCall1602 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1604 = new Set(array(64, 65));
TestParser::$FOLLOW_variable_in_builtInCall1606 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1608 = new Set(array(1));
TestParser::$FOLLOW_SAMETERM_in_builtInCall1616 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1618 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1620 = new Set(array(60));
TestParser::$FOLLOW_COMMA_in_builtInCall1622 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1624 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1626 = new Set(array(1));
TestParser::$FOLLOW_ISIRI_in_builtInCall1634 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1636 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1638 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1640 = new Set(array(1));
TestParser::$FOLLOW_ISURI_in_builtInCall1648 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1650 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1652 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1654 = new Set(array(1));
TestParser::$FOLLOW_ISBLANK_in_builtInCall1662 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1664 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1666 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1668 = new Set(array(1));
TestParser::$FOLLOW_ISLITERAL_in_builtInCall1676 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_builtInCall1678 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_builtInCall1680 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_builtInCall1682 = new Set(array(1));
TestParser::$FOLLOW_regexExpression_in_builtInCall1690 = new Set(array(1));
TestParser::$FOLLOW_REGEX_in_regexExpression1707 = new Set(array(71));
TestParser::$FOLLOW_OPEN_BRACE_in_regexExpression1709 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_regexExpression1711 = new Set(array(60));
TestParser::$FOLLOW_COMMA_in_regexExpression1713 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_regexExpression1715 = new Set(array(60, 72));
TestParser::$FOLLOW_COMMA_in_regexExpression1719 = new Set(array(8, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 48, 56, 58, 61, 64, 65, 67, 68, 69, 70, 71, 81, 82, 84, 85, 86, 87, 88, 89, 90));
TestParser::$FOLLOW_expression_in_regexExpression1721 = new Set(array(72));
TestParser::$FOLLOW_CLOSE_BRACE_in_regexExpression1726 = new Set(array(1));
TestParser::$FOLLOW_iriRef_in_iriRefOrFunction1743 = new Set(array(1, 71));
TestParser::$FOLLOW_argList_in_iriRefOrFunction1745 = new Set(array(1));
TestParser::$FOLLOW_string_in_rdfLiteral1763 = new Set(array(1, 73, 80));
TestParser::$FOLLOW_LANGTAG_in_rdfLiteral1767 = new Set(array(1));
TestParser::$FOLLOW_REFERENCE_in_rdfLiteral1773 = new Set(array(8, 46, 48, 64, 65));
TestParser::$FOLLOW_iriRef_in_rdfLiteral1775 = new Set(array(1));
TestParser::$FOLLOW_numericLiteralUnsigned_in_numericLiteral1797 = new Set(array(1));
TestParser::$FOLLOW_numericLiteralPositive_in_numericLiteral1801 = new Set(array(1));
TestParser::$FOLLOW_numericLiteralNegative_in_numericLiteral1805 = new Set(array(1));
TestParser::$FOLLOW_set_in_numericLiteralUnsigned0 = new Set(array(1));
TestParser::$FOLLOW_set_in_numericLiteralPositive0 = new Set(array(1));
TestParser::$FOLLOW_set_in_numericLiteralNegative0 = new Set(array(1));
TestParser::$FOLLOW_set_in_booleanLiteral0 = new Set(array(1));
TestParser::$FOLLOW_set_in_string0 = new Set(array(1));
TestParser::$FOLLOW_IRI_REF_in_iriRef1987 = new Set(array(1));
TestParser::$FOLLOW_prefixedName_in_iriRef1995 = new Set(array(1));
TestParser::$FOLLOW_set_in_prefixedName0 = new Set(array(1));
TestParser::$FOLLOW_BLANK_NODE_LABEL_in_blankNode2037 = new Set(array(1));
TestParser::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNode2045 = new Set(array(92));
TestParser::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode2047 = new Set(array(1));

?>