<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 Erfurt_Sparql_Sparql10.g 2010-02-17 13:38:22


/**
 * Erfurt Sparql Query2 - Var.
 * 
 * @package    erfurt
 * @subpackage Parser
 * @author     Rolland Brunec
 * @copyright  Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */

require_once 'Erfurt/Sparql/Query2/structural-Interfaces.php';
require_once 'Erfurt/Sparql/Query2/ElementHelper.php';
require_once 'Erfurt/Sparql/Query2/ContainerHelper.php';
require_once 'Erfurt/Sparql/Query2/Constraint.php';
require_once 'Erfurt/Sparql/Query2/IriRef.php';
require_once 'Erfurt/Sparql/Query2/OrderClause.php';
require_once 'Erfurt/Sparql/Query2/GroupGraphPattern.php';
require_once 'Erfurt/Sparql/Query2/GraphClause.php';
require_once 'Erfurt/Sparql/Query2.php';



# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class Erfurt_Sparql_Sparql10Parser extends AntlrParser {
    public static $tokenNames = array(
        "<invalid>", "<EOR>", "<DOWN>", "<UP>", "BASE", "PREFIX", "MODIFY", "DELETE", "INSERT", "DATA", "INTO", "LOAD", "CLEAR", "CREATE", "SILENT", "DROP", "EXISTS", "UNSAID", "NOT", "SELECT", "DISTINCT", "REDUCED", "CONSTRUCT", "DESCRIBE", "ASK", "FROM", "NAMED", "WHERE", "ORDER", "GROUP", "HAVING", "BY", "ASC", "DESC", "LIMIT", "OFFSET", "OPTIONAL", "GRAPH", "UNION", "FILTER", "A", "AS", "STR", "LANG", "LANGMATCHES", "DATATYPE", "BOUND", "SAMETERM", "ISIRI", "ISURI", "ISBLANK", "ISLITERAL", "REGEX", "COUNT", "SUM", "MIN", "MAX", "AVG", "TRUE", "FALSE", "IF", "COALESCE", "LESS", "GREATER", "OPEN_CURLY_BRACE", "CLOSE_CURLY_BRACE", "IRI_REF", "PN_PREFIX", "PNAME_NS", "PN_LOCAL", "PNAME_LN", "VARNAME", "VAR1", "VAR2", "MINUS", "LANGTAG", "INTEGER", "DOT", "DECIMAL", "DIGIT", "EXPONENT", "DOUBLE", "PLUS", "INTEGER_POSITIVE", "DECIMAL_POSITIVE", "DOUBLE_POSITIVE", "INTEGER_NEGATIVE", "DECIMAL_NEGATIVE", "DOUBLE_NEGATIVE", "ECHAR", "STRING_LITERAL1", "STRING_LITERAL2", "STRING_LITERAL_LONG1", "STRING_LITERAL_LONG2", "EOL", "WS", "PN_CHARS_BASE", "PN_CHARS_U", "PN_CHARS", "BLANK_NODE_LABEL", "REFERENCE", "AND", "OR", "COMMENT", "SEMICOLON", "ASTERISK", "COMMA", "NOT_SIGN", "DIVIDE", "EQUAL", "OPEN_BRACE", "CLOSE_BRACE", "LESS_EQUAL", "GREATER_EQUAL", "NOT_EQUAL", "OPEN_SQUARE_BRACE", "CLOSE_SQUARE_BRACE", "'fake'"
    );
    public $PREFIX=5;
    public $EXPONENT=80;
    public $SILENT=14;
    public $CLOSE_SQUARE_BRACE=116;
    public $GRAPH=37;
    public $REGEX=52;
    public $PNAME_LN=70;
    public $CONSTRUCT=22;
    public $COUNT=53;
    public $NOT=18;
    public $EOF=-1;
    public $CLEAR=12;
    public $VARNAME=71;
    public $ISLITERAL=51;
    public $CREATE=13;
    public $EOL=94;
    public $GREATER=63;
    public $INSERT=8;
    public $NOT_EQUAL=114;
    public $LESS=62;
    public $LANGMATCHES=44;
    public $DOUBLE=81;
    public $PN_CHARS_U=97;
    public $BASE=4;
    public $COMMENT=103;
    public $SELECT=19;
    public $OPEN_CURLY_BRACE=64;
    public $INTO=10;
    public $CLOSE_CURLY_BRACE=65;
    public $DOUBLE_POSITIVE=85;
    public $DIVIDE=108;
    public $BOUND=46;
    public $ISIRI=48;
    public $COALESCE=61;
    public $A=40;
    public $NOT_SIGN=107;
    public $ASC=32;
    public $BLANK_NODE_LABEL=99;
    public $ASK=24;
    public $LOAD=11;
    public $SEMICOLON=104;
    public $DELETE=7;
    public $ISBLANK=50;
    public $GROUP=29;
    public $WS=95;
    public $NAMED=26;
    public $INTEGER_POSITIVE=83;
    public $OR=102;
    public $STRING_LITERAL2=91;
    public $FILTER=39;
    public $DESCRIBE=23;
    public $STRING_LITERAL1=90;
    public $PN_CHARS=98;
    public $DATATYPE=45;
    public $LESS_EQUAL=112;
    public $DOUBLE_NEGATIVE=88;
    public $FROM=25;
    public $FALSE=59;
    public $DISTINCT=20;
    public $LANG=43;
    public $MODIFY=6;
    public $WHERE=27;
    public $IRI_REF=66;
    public $ORDER=28;
    public $LIMIT=34;
    public $T__117=117;
    public $MAX=56;
    public $AND=101;
    public $SUM=54;
    public $ASTERISK=105;
    public $IF=60;
    public $UNSAID=17;
    public $ISURI=49;
    public $STR=42;
    public $AS=41;
    public $SAMETERM=47;
    public $COMMA=106;
    public $OFFSET=35;
    public $AVG=57;
    public $EQUAL=109;
    public $DECIMAL_POSITIVE=84;
    public $PLUS=82;
    public $EXISTS=16;
    public $DIGIT=79;
    public $DOT=77;
    public $INTEGER=76;
    public $BY=31;
    public $REDUCED=21;
    public $INTEGER_NEGATIVE=86;
    public $PN_LOCAL=69;
    public $PNAME_NS=68;
    public $REFERENCE=100;
    public $HAVING=30;
    public $CLOSE_BRACE=111;
    public $MIN=55;
    public $MINUS=74;
    public $TRUE=58;
    public $OPEN_SQUARE_BRACE=115;
    public $UNION=38;
    public $ECHAR=89;
    public $OPTIONAL=36;
    public $PN_CHARS_BASE=96;
    public $STRING_LITERAL_LONG2=93;
    public $DECIMAL=78;
    public $DROP=15;
    public $VAR1=72;
    public $STRING_LITERAL_LONG1=92;
    public $VAR2=73;
    public $DECIMAL_NEGATIVE=87;
    public $PN_PREFIX=67;
    public $DESC=33;
    public $OPEN_BRACE=110;
    public $GREATER_EQUAL=113;
    public $DATA=9;
    public $LANGTAG=75;

    // delegates
    // delegators

    
    static $FOLLOW_117_in_fakestart56;
    static $FOLLOW_start_in_fakestart58;
    static $FOLLOW_prologue_in_start82;
    static $FOLLOW_selectQuery_in_start95;
    static $FOLLOW_constructQuery_in_start107;
    static $FOLLOW_describeQuery_in_start120;
    static $FOLLOW_askQuery_in_start133;
    static $FOLLOW_EOF_in_start146;
    static $FOLLOW_baseDecl_in_prologue167;
    static $FOLLOW_prefixDecl_in_prologue170;
    static $FOLLOW_BASE_in_baseDecl190;
    static $FOLLOW_iriRef_in_baseDecl192;
    static $FOLLOW_PREFIX_in_prefixDecl217;
    static $FOLLOW_PNAME_NS_in_prefixDecl219;
    static $FOLLOW_iriRef_in_prefixDecl221;
    static $FOLLOW_SELECT_in_selectQuery242;
    static $FOLLOW_DISTINCT_in_selectQuery246;
    static $FOLLOW_REDUCED_in_selectQuery260;
    static $FOLLOW_variable_in_selectQuery277;
    static $FOLLOW_ASTERISK_in_selectQuery282;
    static $FOLLOW_datasetClause_in_selectQuery286;
    static $FOLLOW_whereClause_in_selectQuery289;
    static $FOLLOW_solutionModifier_in_selectQuery291;
    static $FOLLOW_CONSTRUCT_in_constructQuery311;
    static $FOLLOW_constructTemplate_in_constructQuery313;
    static $FOLLOW_datasetClause_in_constructQuery315;
    static $FOLLOW_whereClause_in_constructQuery318;
    static $FOLLOW_solutionModifier_in_constructQuery320;
    static $FOLLOW_DESCRIBE_in_describeQuery339;
    static $FOLLOW_varOrIRIref_in_describeQuery343;
    static $FOLLOW_ASTERISK_in_describeQuery348;
    static $FOLLOW_datasetClause_in_describeQuery352;
    static $FOLLOW_whereClause_in_describeQuery355;
    static $FOLLOW_solutionModifier_in_describeQuery358;
    static $FOLLOW_ASK_in_askQuery377;
    static $FOLLOW_datasetClause_in_askQuery379;
    static $FOLLOW_whereClause_in_askQuery382;
    static $FOLLOW_FROM_in_datasetClause403;
    static $FOLLOW_defaultGraphClause_in_datasetClause407;
    static $FOLLOW_namedGraphClause_in_datasetClause421;
    static $FOLLOW_sourceSelector_in_defaultGraphClause456;
    static $FOLLOW_NAMED_in_namedGraphClause481;
    static $FOLLOW_sourceSelector_in_namedGraphClause483;
    static $FOLLOW_iriRef_in_sourceSelector508;
    static $FOLLOW_WHERE_in_whereClause529;
    static $FOLLOW_groupGraphPattern_in_whereClause532;
    static $FOLLOW_orderClause_in_solutionModifier553;
    static $FOLLOW_limitOffsetClauses_in_solutionModifier556;
    static $FOLLOW_limitClause_in_limitOffsetClauses575;
    static $FOLLOW_offsetClause_in_limitOffsetClauses577;
    static $FOLLOW_offsetClause_in_limitOffsetClauses587;
    static $FOLLOW_limitClause_in_limitOffsetClauses589;
    static $FOLLOW_ORDER_in_orderClause609;
    static $FOLLOW_BY_in_orderClause611;
    static $FOLLOW_orderCondition_in_orderClause613;
    static $FOLLOW_ASC_in_orderCondition639;
    static $FOLLOW_DESC_in_orderCondition645;
    static $FOLLOW_brackettedExpression_in_orderCondition649;
    static $FOLLOW_constraint_in_orderCondition665;
    static $FOLLOW_variable_in_orderCondition671;
    static $FOLLOW_LIMIT_in_limitClause693;
    static $FOLLOW_INTEGER_in_limitClause695;
    static $FOLLOW_OFFSET_in_offsetClause716;
    static $FOLLOW_INTEGER_in_offsetClause718;
    static $FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern744;
    static $FOLLOW_triplesBlock_in_groupGraphPattern749;
    static $FOLLOW_graphPatternNotTriples_in_groupGraphPattern762;
    static $FOLLOW_filter_in_groupGraphPattern768;
    static $FOLLOW_DOT_in_groupGraphPattern786;
    static $FOLLOW_triplesBlock_in_groupGraphPattern792;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern801;
    static $FOLLOW_triplesSameSubject_in_triplesBlock828;
    static $FOLLOW_DOT_in_triplesBlock834;
    static $FOLLOW_triplesBlock_in_triplesBlock839;
    static $FOLLOW_optionalGraphPattern_in_graphPatternNotTriples876;
    static $FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples888;
    static $FOLLOW_graphGraphPattern_in_graphPatternNotTriples900;
    static $FOLLOW_OPTIONAL_in_optionalGraphPattern929;
    static $FOLLOW_groupGraphPattern_in_optionalGraphPattern931;
    static $FOLLOW_GRAPH_in_graphGraphPattern960;
    static $FOLLOW_varOrIRIref_in_graphGraphPattern962;
    static $FOLLOW_groupGraphPattern_in_graphGraphPattern964;
    static $FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern995;
    static $FOLLOW_UNION_in_groupOrUnionGraphPattern1001;
    static $FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern1005;
    static $FOLLOW_FILTER_in_filter1037;
    static $FOLLOW_constraint_in_filter1039;
    static $FOLLOW_brackettedExpression_in_constraint1070;
    static $FOLLOW_builtInCall_in_constraint1080;
    static $FOLLOW_functionCall_in_constraint1090;
    static $FOLLOW_iriRef_in_functionCall1112;
    static $FOLLOW_argList_in_functionCall1114;
    static $FOLLOW_OPEN_BRACE_in_argList1143;
    static $FOLLOW_WS_in_argList1145;
    static $FOLLOW_CLOSE_BRACE_in_argList1148;
    static $FOLLOW_OPEN_BRACE_in_argList1156;
    static $FOLLOW_expression_in_argList1160;
    static $FOLLOW_COMMA_in_argList1174;
    static $FOLLOW_expression_in_argList1178;
    static $FOLLOW_CLOSE_BRACE_in_argList1184;
    static $FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate1211;
    static $FOLLOW_constructTriples_in_constructTemplate1214;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate1220;
    static $FOLLOW_triplesSameSubject_in_constructTriples1247;
    static $FOLLOW_DOT_in_constructTriples1253;
    static $FOLLOW_constructTriples_in_constructTriples1258;
    static $FOLLOW_varOrTerm_in_triplesSameSubject1292;
    static $FOLLOW_propertyListNotEmpty_in_triplesSameSubject1294;
    static $FOLLOW_triplesNode_in_triplesSameSubject1304;
    static $FOLLOW_propertyList_in_triplesSameSubject1306;
    static $FOLLOW_verb_in_propertyListNotEmpty1337;
    static $FOLLOW_objectList_in_propertyListNotEmpty1341;
    static $FOLLOW_SEMICOLON_in_propertyListNotEmpty1355;
    static $FOLLOW_verb_in_propertyListNotEmpty1361;
    static $FOLLOW_objectList_in_propertyListNotEmpty1365;
    static $FOLLOW_propertyListNotEmpty_in_propertyList1404;
    static $FOLLOW_object_in_objectList1437;
    static $FOLLOW_COMMA_in_objectList1451;
    static $FOLLOW_object_in_objectList1455;
    static $FOLLOW_graphNode_in_object1483;
    static $FOLLOW_varOrIRIref_in_verb1512;
    static $FOLLOW_A_in_verb1522;
    static $FOLLOW_collection_in_triplesNode1547;
    static $FOLLOW_blankNodePropertyList_in_triplesNode1557;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1586;
    static $FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1588;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1590;
    static $FOLLOW_OPEN_BRACE_in_collection1623;
    static $FOLLOW_graphNode_in_collection1626;
    static $FOLLOW_CLOSE_BRACE_in_collection1632;
    static $FOLLOW_varOrTerm_in_graphNode1655;
    static $FOLLOW_triplesNode_in_graphNode1665;
    static $FOLLOW_variable_in_varOrTerm1690;
    static $FOLLOW_graphTerm_in_varOrTerm1700;
    static $FOLLOW_variable_in_varOrIRIref1725;
    static $FOLLOW_iriRef_in_varOrIRIref1735;
    static $FOLLOW_VAR1_in_variable1770;
    static $FOLLOW_VAR2_in_variable1782;
    static $FOLLOW_iriRef_in_graphTerm1813;
    static $FOLLOW_rdfLiteral_in_graphTerm1825;
    static $FOLLOW_numericLiteral_in_graphTerm1837;
    static $FOLLOW_booleanLiteral_in_graphTerm1849;
    static $FOLLOW_blankNode_in_graphTerm1861;
    static $FOLLOW_OPEN_BRACE_in_graphTerm1871;
    static $FOLLOW_WS_in_graphTerm1873;
    static $FOLLOW_CLOSE_BRACE_in_graphTerm1876;
    static $FOLLOW_conditionalOrExpression_in_expression1901;
    static $FOLLOW_conditionalAndExpression_in_conditionalOrExpression1936;
    static $FOLLOW_OR_in_conditionalOrExpression1946;
    static $FOLLOW_conditionalAndExpression_in_conditionalOrExpression1950;
    static $FOLLOW_valueLogical_in_conditionalAndExpression1987;
    static $FOLLOW_AND_in_conditionalAndExpression1993;
    static $FOLLOW_valueLogical_in_conditionalAndExpression1997;
    static $FOLLOW_relationalExpression_in_valueLogical2025;
    static $FOLLOW_numericExpression_in_relationalExpression2052;
    static $FOLLOW_EQUAL_in_relationalExpression2066;
    static $FOLLOW_numericExpression_in_relationalExpression2070;
    static $FOLLOW_NOT_EQUAL_in_relationalExpression2084;
    static $FOLLOW_numericExpression_in_relationalExpression2088;
    static $FOLLOW_LESS_in_relationalExpression2102;
    static $FOLLOW_numericExpression_in_relationalExpression2106;
    static $FOLLOW_GREATER_in_relationalExpression2120;
    static $FOLLOW_numericExpression_in_relationalExpression2124;
    static $FOLLOW_LESS_EQUAL_in_relationalExpression2138;
    static $FOLLOW_numericExpression_in_relationalExpression2142;
    static $FOLLOW_GREATER_EQUAL_in_relationalExpression2156;
    static $FOLLOW_numericExpression_in_relationalExpression2160;
    static $FOLLOW_additiveExpression_in_numericExpression2195;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression2226;
    static $FOLLOW_PLUS_in_additiveExpression2243;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression2247;
    static $FOLLOW_MINUS_in_additiveExpression2263;
    static $FOLLOW_multiplicativeExpression_in_additiveExpression2267;
    static $FOLLOW_numericLiteralPositive_in_additiveExpression2283;
    static $FOLLOW_numericLiteralNegative_in_additiveExpression2299;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression2347;
    static $FOLLOW_ASTERISK_in_multiplicativeExpression2364;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression2368;
    static $FOLLOW_DIVIDE_in_multiplicativeExpression2374;
    static $FOLLOW_unaryExpression_in_multiplicativeExpression2378;
    static $FOLLOW_NOT_SIGN_in_unaryExpression2406;
    static $FOLLOW_primaryExpression_in_unaryExpression2410;
    static $FOLLOW_PLUS_in_unaryExpression2420;
    static $FOLLOW_primaryExpression_in_unaryExpression2424;
    static $FOLLOW_MINUS_in_unaryExpression2434;
    static $FOLLOW_primaryExpression_in_unaryExpression2438;
    static $FOLLOW_primaryExpression_in_unaryExpression2450;
    static $FOLLOW_brackettedExpression_in_primaryExpression2481;
    static $FOLLOW_builtInCall_in_primaryExpression2493;
    static $FOLLOW_iriRefOrFunction_in_primaryExpression2505;
    static $FOLLOW_rdfLiteral_in_primaryExpression2517;
    static $FOLLOW_numericLiteral_in_primaryExpression2529;
    static $FOLLOW_booleanLiteral_in_primaryExpression2541;
    static $FOLLOW_variable_in_primaryExpression2553;
    static $FOLLOW_OPEN_BRACE_in_brackettedExpression2578;
    static $FOLLOW_expression_in_brackettedExpression2582;
    static $FOLLOW_CLOSE_BRACE_in_brackettedExpression2584;
    static $FOLLOW_STR_in_builtInCall2609;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2611;
    static $FOLLOW_expression_in_builtInCall2615;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2617;
    static $FOLLOW_LANG_in_builtInCall2627;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2629;
    static $FOLLOW_expression_in_builtInCall2633;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2635;
    static $FOLLOW_LANGMATCHES_in_builtInCall2645;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2647;
    static $FOLLOW_expression_in_builtInCall2651;
    static $FOLLOW_COMMA_in_builtInCall2653;
    static $FOLLOW_expression_in_builtInCall2657;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2659;
    static $FOLLOW_DATATYPE_in_builtInCall2669;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2671;
    static $FOLLOW_expression_in_builtInCall2675;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2677;
    static $FOLLOW_BOUND_in_builtInCall2687;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2689;
    static $FOLLOW_variable_in_builtInCall2691;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2693;
    static $FOLLOW_SAMETERM_in_builtInCall2703;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2705;
    static $FOLLOW_expression_in_builtInCall2709;
    static $FOLLOW_COMMA_in_builtInCall2711;
    static $FOLLOW_expression_in_builtInCall2715;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2717;
    static $FOLLOW_ISIRI_in_builtInCall2727;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2729;
    static $FOLLOW_expression_in_builtInCall2733;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2735;
    static $FOLLOW_ISURI_in_builtInCall2745;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2747;
    static $FOLLOW_expression_in_builtInCall2751;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2753;
    static $FOLLOW_ISBLANK_in_builtInCall2763;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2765;
    static $FOLLOW_expression_in_builtInCall2769;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2771;
    static $FOLLOW_ISLITERAL_in_builtInCall2781;
    static $FOLLOW_OPEN_BRACE_in_builtInCall2783;
    static $FOLLOW_expression_in_builtInCall2787;
    static $FOLLOW_CLOSE_BRACE_in_builtInCall2789;
    static $FOLLOW_regexExpression_in_builtInCall2799;
    static $FOLLOW_REGEX_in_regexExpression2824;
    static $FOLLOW_OPEN_BRACE_in_regexExpression2826;
    static $FOLLOW_expression_in_regexExpression2830;
    static $FOLLOW_COMMA_in_regexExpression2832;
    static $FOLLOW_expression_in_regexExpression2836;
    static $FOLLOW_COMMA_in_regexExpression2840;
    static $FOLLOW_expression_in_regexExpression2844;
    static $FOLLOW_CLOSE_BRACE_in_regexExpression2849;
    static $FOLLOW_iriRef_in_iriRefOrFunction2886;
    static $FOLLOW_argList_in_iriRefOrFunction2899;
    static $FOLLOW_string_in_rdfLiteral2930;
    static $FOLLOW_LANGTAG_in_rdfLiteral2944;
    static $FOLLOW_REFERENCE_in_rdfLiteral2961;
    static $FOLLOW_iriRef_in_rdfLiteral2963;
    static $FOLLOW_numericLiteralUnsigned_in_numericLiteral2996;
    static $FOLLOW_numericLiteralPositive_in_numericLiteral3003;
    static $FOLLOW_numericLiteralNegative_in_numericLiteral3010;
    static $FOLLOW_INTEGER_in_numericLiteralUnsigned3043;
    static $FOLLOW_DECIMAL_in_numericLiteralUnsigned3055;
    static $FOLLOW_DOUBLE_in_numericLiteralUnsigned3067;
    static $FOLLOW_INTEGER_POSITIVE_in_numericLiteralPositive3098;
    static $FOLLOW_DECIMAL_POSITIVE_in_numericLiteralPositive3110;
    static $FOLLOW_DOUBLE_POSITIVE_in_numericLiteralPositive3122;
    static $FOLLOW_INTEGER_NEGATIVE_in_numericLiteralNegative3153;
    static $FOLLOW_DECIMAL_NEGATIVE_in_numericLiteralNegative3165;
    static $FOLLOW_DOUBLE_NEGATIVE_in_numericLiteralNegative3177;
    static $FOLLOW_TRUE_in_booleanLiteral3210;
    static $FOLLOW_FALSE_in_booleanLiteral3220;
    static $FOLLOW_set_in_string0;
    static $FOLLOW_IRI_REF_in_iriRef3292;
    static $FOLLOW_prefixedName_in_iriRef3302;
    static $FOLLOW_set_in_prefixedName0;
    static $FOLLOW_BLANK_NODE_LABEL_in_blankNode3364;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_blankNode3374;
    static $FOLLOW_WS_in_blankNode3377;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode3381;

    
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
             
            
            
        }
        

    public function getTokenNames() { return Erfurt_Sparql_Sparql10Parser::$tokenNames; }
    public function getGrammarFileName() { return "Erfurt_Sparql_Sparql10.g"; }


    private $_q = null;



    // $ANTLR start "fakestart"
    // Erfurt_Sparql_Sparql10.g:52:1: fakestart : 'fake' start ; 
    public function fakestart(){
        try {
            // Erfurt_Sparql_Sparql10.g:53:2: ( 'fake' start ) 
            // Erfurt_Sparql_Sparql10.g:53:4: 'fake' start 
            {
            $this->match($this->input,$this->getToken('117'),self::$FOLLOW_117_in_fakestart56); 
            $this->pushFollow(self::$FOLLOW_start_in_fakestart58);
            $this->start();

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
    // $ANTLR end "fakestart"


    // $ANTLR start "start"
    // Erfurt_Sparql_Sparql10.g:57:1: start returns [$value] : prologue ( selectQuery | constructQuery | describeQuery | askQuery ) EOF ; 
    public function start(){
        $value = null;

        $this->_q = new Erfurt_Sparql_Query2();
        try {
            // Erfurt_Sparql_Sparql10.g:59:5: ( prologue ( selectQuery | constructQuery | describeQuery | askQuery ) EOF ) 
            // Erfurt_Sparql_Sparql10.g:59:7: prologue ( selectQuery | constructQuery | describeQuery | askQuery ) EOF 
            {
            $this->pushFollow(self::$FOLLOW_prologue_in_start82);
            $this->prologue();

            $this->state->_fsp--;

            // Erfurt_Sparql_Sparql10.g:59:16: ( selectQuery | constructQuery | describeQuery | askQuery ) 
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
                    // Erfurt_Sparql_Sparql10.g:60:9: selectQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_selectQuery_in_start95);
                    $this->selectQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:61:11: constructQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_constructQuery_in_start107);
                    $this->constructQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:62:11: describeQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_describeQuery_in_start120);
                    $this->describeQuery();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Erfurt_Sparql_Sparql10.g:63:11: askQuery 
                    {
                    $this->pushFollow(self::$FOLLOW_askQuery_in_start133);
                    $this->askQuery();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('EOF'),self::$FOLLOW_EOF_in_start146); 
              $value = $this->_q;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "start"


    // $ANTLR start "prologue"
    // Erfurt_Sparql_Sparql10.g:68:1: prologue : ( baseDecl )? ( prefixDecl )* ; 
    public function prologue(){
        try {
            // Erfurt_Sparql_Sparql10.g:69:5: ( ( baseDecl )? ( prefixDecl )* ) 
            // Erfurt_Sparql_Sparql10.g:69:7: ( baseDecl )? ( prefixDecl )* 
            {
            // Erfurt_Sparql_Sparql10.g:69:7: ( baseDecl )? 
            $alt2=2;
            $LA2_0 = $this->input->LA(1);

            if ( ($LA2_0==$this->getToken('BASE')) ) {
                $alt2=1;
            }
            switch ($alt2) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:69:7: baseDecl 
                    {
                    $this->pushFollow(self::$FOLLOW_baseDecl_in_prologue167);
                    $this->baseDecl();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Erfurt_Sparql_Sparql10.g:69:17: ( prefixDecl )* 
            //loop3:
            do {
                $alt3=2;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('PREFIX')) ) {
                    $alt3=1;
                }


                switch ($alt3) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:69:17: prefixDecl 
            	    {
            	    $this->pushFollow(self::$FOLLOW_prefixDecl_in_prologue170);
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
    // Erfurt_Sparql_Sparql10.g:73:1: baseDecl : BASE iriRef ; 
    public function baseDecl(){
        $iriRef1 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:74:5: ( BASE iriRef ) 
            // Erfurt_Sparql_Sparql10.g:74:7: BASE iriRef 
            {
            $this->match($this->input,$this->getToken('BASE'),self::$FOLLOW_BASE_in_baseDecl190); 
            $this->pushFollow(self::$FOLLOW_iriRef_in_baseDecl192);
            $iriRef1=$this->iriRef();

            $this->state->_fsp--;

              $this->_q->setBase($iriRef1);

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
    // Erfurt_Sparql_Sparql10.g:78:1: prefixDecl : PREFIX PNAME_NS iriRef ; 
    public function prefixDecl(){
        $PNAME_NS2=null;
        $iriRef3 = null;


        require_once 'Erfurt/Sparql/Query2/Prefix.php';
        try {
            // Erfurt_Sparql_Sparql10.g:80:5: ( PREFIX PNAME_NS iriRef ) 
            // Erfurt_Sparql_Sparql10.g:80:7: PREFIX PNAME_NS iriRef 
            {
            $this->match($this->input,$this->getToken('PREFIX'),self::$FOLLOW_PREFIX_in_prefixDecl217); 
            $PNAME_NS2=$this->match($this->input,$this->getToken('PNAME_NS'),self::$FOLLOW_PNAME_NS_in_prefixDecl219); 
            $this->pushFollow(self::$FOLLOW_iriRef_in_prefixDecl221);
            $iriRef3=$this->iriRef();

            $this->state->_fsp--;

              $this->_q->addPrefix(new Erfurt_Sparql_Query2_Prefix(($PNAME_NS2!=null?$PNAME_NS2->getText():null), $iriRef3));

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
    // Erfurt_Sparql_Sparql10.g:84:1: selectQuery : SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier ; 
    public function selectQuery(){
        try {
            // Erfurt_Sparql_Sparql10.g:85:5: ( SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier ) 
            // Erfurt_Sparql_Sparql10.g:85:7: SELECT ( DISTINCT | REDUCED )? ( ( variable )+ | ASTERISK ) ( datasetClause )* whereClause solutionModifier 
            {
            $this->match($this->input,$this->getToken('SELECT'),self::$FOLLOW_SELECT_in_selectQuery242); 
            // Erfurt_Sparql_Sparql10.g:85:14: ( DISTINCT | REDUCED )? 
            $alt4=3;
            $LA4_0 = $this->input->LA(1);

            if ( ($LA4_0==$this->getToken('DISTINCT')) ) {
                $alt4=1;
            }
            else if ( ($LA4_0==$this->getToken('REDUCED')) ) {
                $alt4=2;
            }
            switch ($alt4) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:85:16: DISTINCT 
                    {
                    $this->match($this->input,$this->getToken('DISTINCT'),self::$FOLLOW_DISTINCT_in_selectQuery246); 
                      $this->_q->setDistinct(true);

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:86:11: REDUCED 
                    {
                    $this->match($this->input,$this->getToken('REDUCED'),self::$FOLLOW_REDUCED_in_selectQuery260); 
                      $this->_q->setReduced(true);

                    }
                    break;

            }

            // Erfurt_Sparql_Sparql10.g:87:12: ( ( variable )+ | ASTERISK ) 
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
                    // Erfurt_Sparql_Sparql10.g:87:14: ( variable )+ 
                    {
                    // Erfurt_Sparql_Sparql10.g:87:14: ( variable )+ 
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
                    	    // Erfurt_Sparql_Sparql10.g:87:14: variable 
                    	    {
                    	    $this->pushFollow(self::$FOLLOW_variable_in_selectQuery277);
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
                    // Erfurt_Sparql_Sparql10.g:87:26: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_selectQuery282); 

                    }
                    break;

            }

            // Erfurt_Sparql_Sparql10.g:87:37: ( datasetClause )* 
            //loop7:
            do {
                $alt7=2;
                $LA7_0 = $this->input->LA(1);

                if ( ($LA7_0==$this->getToken('FROM')) ) {
                    $alt7=1;
                }


                switch ($alt7) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:87:37: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_selectQuery286);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop7;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_selectQuery289);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_selectQuery291);
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
    // Erfurt_Sparql_Sparql10.g:91:1: constructQuery : CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier ; 
    public function constructQuery(){
        try {
            // Erfurt_Sparql_Sparql10.g:92:5: ( CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier ) 
            // Erfurt_Sparql_Sparql10.g:92:7: CONSTRUCT constructTemplate ( datasetClause )* whereClause solutionModifier 
            {
            $this->match($this->input,$this->getToken('CONSTRUCT'),self::$FOLLOW_CONSTRUCT_in_constructQuery311); 
            $this->pushFollow(self::$FOLLOW_constructTemplate_in_constructQuery313);
            $this->constructTemplate();

            $this->state->_fsp--;

            // Erfurt_Sparql_Sparql10.g:92:35: ( datasetClause )* 
            //loop8:
            do {
                $alt8=2;
                $LA8_0 = $this->input->LA(1);

                if ( ($LA8_0==$this->getToken('FROM')) ) {
                    $alt8=1;
                }


                switch ($alt8) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:92:35: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_constructQuery315);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop8;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_constructQuery318);
            $this->whereClause();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_constructQuery320);
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
    // Erfurt_Sparql_Sparql10.g:96:1: describeQuery : DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier ; 
    public function describeQuery(){
        try {
            // Erfurt_Sparql_Sparql10.g:97:5: ( DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier ) 
            // Erfurt_Sparql_Sparql10.g:97:7: DESCRIBE ( ( varOrIRIref )+ | ASTERISK ) ( datasetClause )* ( whereClause )? solutionModifier 
            {
            $this->match($this->input,$this->getToken('DESCRIBE'),self::$FOLLOW_DESCRIBE_in_describeQuery339); 
            // Erfurt_Sparql_Sparql10.g:97:16: ( ( varOrIRIref )+ | ASTERISK ) 
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
                    // Erfurt_Sparql_Sparql10.g:97:18: ( varOrIRIref )+ 
                    {
                    // Erfurt_Sparql_Sparql10.g:97:18: ( varOrIRIref )+ 
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
                    	    // Erfurt_Sparql_Sparql10.g:97:18: varOrIRIref 
                    	    {
                    	    $this->pushFollow(self::$FOLLOW_varOrIRIref_in_describeQuery343);
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
                    // Erfurt_Sparql_Sparql10.g:97:33: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_describeQuery348); 

                    }
                    break;

            }

            // Erfurt_Sparql_Sparql10.g:97:44: ( datasetClause )* 
            //loop11:
            do {
                $alt11=2;
                $LA11_0 = $this->input->LA(1);

                if ( ($LA11_0==$this->getToken('FROM')) ) {
                    $alt11=1;
                }


                switch ($alt11) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:97:44: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_describeQuery352);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop11;
                }
            } while (true);

            // Erfurt_Sparql_Sparql10.g:97:59: ( whereClause )? 
            $alt12=2;
            $LA12_0 = $this->input->LA(1);

            if ( ($LA12_0==$this->getToken('WHERE')||$LA12_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                $alt12=1;
            }
            switch ($alt12) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:97:59: whereClause 
                    {
                    $this->pushFollow(self::$FOLLOW_whereClause_in_describeQuery355);
                    $this->whereClause();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_solutionModifier_in_describeQuery358);
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
    // Erfurt_Sparql_Sparql10.g:101:1: askQuery : ASK ( datasetClause )* whereClause ; 
    public function askQuery(){
        $ASK4=null;

        try {
            // Erfurt_Sparql_Sparql10.g:102:5: ( ASK ( datasetClause )* whereClause ) 
            // Erfurt_Sparql_Sparql10.g:102:7: ASK ( datasetClause )* whereClause 
            {
            $ASK4=$this->match($this->input,$this->getToken('ASK'),self::$FOLLOW_ASK_in_askQuery377); 
            // Erfurt_Sparql_Sparql10.g:102:11: ( datasetClause )* 
            //loop13:
            do {
                $alt13=2;
                $LA13_0 = $this->input->LA(1);

                if ( ($LA13_0==$this->getToken('FROM')) ) {
                    $alt13=1;
                }


                switch ($alt13) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:102:11: datasetClause 
            	    {
            	    $this->pushFollow(self::$FOLLOW_datasetClause_in_askQuery379);
            	    $this->datasetClause();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop13;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_whereClause_in_askQuery382);
            $this->whereClause();

            $this->state->_fsp--;

              $this->_q->setQueryType(($ASK4!=null?$ASK4->getText():null));

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
    // Erfurt_Sparql_Sparql10.g:106:1: datasetClause : FROM ( defaultGraphClause | namedGraphClause ) ; 
    public function datasetClause(){
        $defaultGraphClause5 = null;

        $namedGraphClause6 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:107:5: ( FROM ( defaultGraphClause | namedGraphClause ) ) 
            // Erfurt_Sparql_Sparql10.g:107:7: FROM ( defaultGraphClause | namedGraphClause ) 
            {
            $this->match($this->input,$this->getToken('FROM'),self::$FOLLOW_FROM_in_datasetClause403); 
            // Erfurt_Sparql_Sparql10.g:107:12: ( defaultGraphClause | namedGraphClause ) 
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
                    // Erfurt_Sparql_Sparql10.g:107:14: defaultGraphClause 
                    {
                    $this->pushFollow(self::$FOLLOW_defaultGraphClause_in_datasetClause407);
                    $defaultGraphClause5=$this->defaultGraphClause();

                    $this->state->_fsp--;

                      $this->_q->addFrom($defaultGraphClause5);

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:108:11: namedGraphClause 
                    {
                    $this->pushFollow(self::$FOLLOW_namedGraphClause_in_datasetClause421);
                    $namedGraphClause6=$this->namedGraphClause();

                    $this->state->_fsp--;

                      $this->_q->addFrom($namedGraphClause6, true);

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
    // Erfurt_Sparql_Sparql10.g:113:1: defaultGraphClause returns [$value] : sourceSelector ; 
    public function defaultGraphClause(){
        $value = null;

        $sourceSelector7 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:114:5: ( sourceSelector ) 
            // Erfurt_Sparql_Sparql10.g:114:7: sourceSelector 
            {
            $this->pushFollow(self::$FOLLOW_sourceSelector_in_defaultGraphClause456);
            $sourceSelector7=$this->sourceSelector();

            $this->state->_fsp--;

              $value = $sourceSelector7;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "defaultGraphClause"


    // $ANTLR start "namedGraphClause"
    // Erfurt_Sparql_Sparql10.g:118:1: namedGraphClause returns [$value] : NAMED sourceSelector ; 
    public function namedGraphClause(){
        $value = null;

        $sourceSelector8 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:119:5: ( NAMED sourceSelector ) 
            // Erfurt_Sparql_Sparql10.g:119:7: NAMED sourceSelector 
            {
            $this->match($this->input,$this->getToken('NAMED'),self::$FOLLOW_NAMED_in_namedGraphClause481); 
            $this->pushFollow(self::$FOLLOW_sourceSelector_in_namedGraphClause483);
            $sourceSelector8=$this->sourceSelector();

            $this->state->_fsp--;

              $value = $sourceSelector8;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "namedGraphClause"


    // $ANTLR start "sourceSelector"
    // Erfurt_Sparql_Sparql10.g:123:1: sourceSelector returns [$value] : iriRef ; 
    public function sourceSelector(){
        $value = null;

        $iriRef9 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:124:5: ( iriRef ) 
            // Erfurt_Sparql_Sparql10.g:124:7: iriRef 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_sourceSelector508);
            $iriRef9=$this->iriRef();

            $this->state->_fsp--;

              $value = $iriRef9;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "sourceSelector"


    // $ANTLR start "whereClause"
    // Erfurt_Sparql_Sparql10.g:128:1: whereClause : ( WHERE )? groupGraphPattern ; 
    public function whereClause(){
        $groupGraphPattern10 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:129:5: ( ( WHERE )? groupGraphPattern ) 
            // Erfurt_Sparql_Sparql10.g:129:7: ( WHERE )? groupGraphPattern 
            {
            // Erfurt_Sparql_Sparql10.g:129:7: ( WHERE )? 
            $alt15=2;
            $LA15_0 = $this->input->LA(1);

            if ( ($LA15_0==$this->getToken('WHERE')) ) {
                $alt15=1;
            }
            switch ($alt15) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:129:7: WHERE 
                    {
                    $this->match($this->input,$this->getToken('WHERE'),self::$FOLLOW_WHERE_in_whereClause529); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_whereClause532);
            $groupGraphPattern10=$this->groupGraphPattern();

            $this->state->_fsp--;

              $this->_q->setWhere($groupGraphPattern10);

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
    // Erfurt_Sparql_Sparql10.g:133:1: solutionModifier : ( orderClause )? ( limitOffsetClauses )? ; 
    public function solutionModifier(){
        try {
            // Erfurt_Sparql_Sparql10.g:134:5: ( ( orderClause )? ( limitOffsetClauses )? ) 
            // Erfurt_Sparql_Sparql10.g:134:7: ( orderClause )? ( limitOffsetClauses )? 
            {
            // Erfurt_Sparql_Sparql10.g:134:7: ( orderClause )? 
            $alt16=2;
            $LA16_0 = $this->input->LA(1);

            if ( ($LA16_0==$this->getToken('ORDER')) ) {
                $alt16=1;
            }
            switch ($alt16) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:134:7: orderClause 
                    {
                    $this->pushFollow(self::$FOLLOW_orderClause_in_solutionModifier553);
                    $this->orderClause();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Erfurt_Sparql_Sparql10.g:134:20: ( limitOffsetClauses )? 
            $alt17=2;
            $LA17_0 = $this->input->LA(1);

            if ( (($LA17_0>=$this->getToken('LIMIT') && $LA17_0<=$this->getToken('OFFSET'))) ) {
                $alt17=1;
            }
            switch ($alt17) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:134:20: limitOffsetClauses 
                    {
                    $this->pushFollow(self::$FOLLOW_limitOffsetClauses_in_solutionModifier556);
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
    // Erfurt_Sparql_Sparql10.g:137:1: limitOffsetClauses : ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ); 
    public function limitOffsetClauses(){
        try {
            // Erfurt_Sparql_Sparql10.g:138:5: ( limitClause ( offsetClause )? | offsetClause ( limitClause )? ) 
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
                    // Erfurt_Sparql_Sparql10.g:138:7: limitClause ( offsetClause )? 
                    {
                    $this->pushFollow(self::$FOLLOW_limitClause_in_limitOffsetClauses575);
                    $this->limitClause();

                    $this->state->_fsp--;

                    // Erfurt_Sparql_Sparql10.g:138:19: ( offsetClause )? 
                    $alt18=2;
                    $LA18_0 = $this->input->LA(1);

                    if ( ($LA18_0==$this->getToken('OFFSET')) ) {
                        $alt18=1;
                    }
                    switch ($alt18) {
                        case 1 :
                            // Erfurt_Sparql_Sparql10.g:138:19: offsetClause 
                            {
                            $this->pushFollow(self::$FOLLOW_offsetClause_in_limitOffsetClauses577);
                            $this->offsetClause();

                            $this->state->_fsp--;


                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:139:7: offsetClause ( limitClause )? 
                    {
                    $this->pushFollow(self::$FOLLOW_offsetClause_in_limitOffsetClauses587);
                    $this->offsetClause();

                    $this->state->_fsp--;

                    // Erfurt_Sparql_Sparql10.g:139:20: ( limitClause )? 
                    $alt19=2;
                    $LA19_0 = $this->input->LA(1);

                    if ( ($LA19_0==$this->getToken('LIMIT')) ) {
                        $alt19=1;
                    }
                    switch ($alt19) {
                        case 1 :
                            // Erfurt_Sparql_Sparql10.g:139:20: limitClause 
                            {
                            $this->pushFollow(self::$FOLLOW_limitClause_in_limitOffsetClauses589);
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
    // Erfurt_Sparql_Sparql10.g:143:1: orderClause : ORDER BY ( orderCondition )+ ; 
    public function orderClause(){
        try {
            // Erfurt_Sparql_Sparql10.g:144:5: ( ORDER BY ( orderCondition )+ ) 
            // Erfurt_Sparql_Sparql10.g:144:7: ORDER BY ( orderCondition )+ 
            {
            $this->match($this->input,$this->getToken('ORDER'),self::$FOLLOW_ORDER_in_orderClause609); 
            $this->match($this->input,$this->getToken('BY'),self::$FOLLOW_BY_in_orderClause611); 
            // Erfurt_Sparql_Sparql10.g:144:16: ( orderCondition )+ 
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
            	    // Erfurt_Sparql_Sparql10.g:144:16: orderCondition 
            	    {
            	    $this->pushFollow(self::$FOLLOW_orderCondition_in_orderClause613);
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
    // Erfurt_Sparql_Sparql10.g:148:1: orderCondition : ( ( (o= ASC | o= DESC ) brackettedExpression ) | (v= constraint | v= variable ) ); 
    public function orderCondition(){
        $o=null;
        $v = null;

        $brackettedExpression11 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:149:5: ( ( (o= ASC | o= DESC ) brackettedExpression ) | (v= constraint | v= variable ) ) 
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
                    // Erfurt_Sparql_Sparql10.g:149:7: ( (o= ASC | o= DESC ) brackettedExpression ) 
                    {
                    // Erfurt_Sparql_Sparql10.g:149:7: ( (o= ASC | o= DESC ) brackettedExpression ) 
                    // Erfurt_Sparql_Sparql10.g:149:9: (o= ASC | o= DESC ) brackettedExpression 
                    {
                    // Erfurt_Sparql_Sparql10.g:149:9: (o= ASC | o= DESC ) 
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
                            // Erfurt_Sparql_Sparql10.g:149:11: o= ASC 
                            {
                            $o=$this->match($this->input,$this->getToken('ASC'),self::$FOLLOW_ASC_in_orderCondition639); 

                            }
                            break;
                        case 2 :
                            // Erfurt_Sparql_Sparql10.g:149:19: o= DESC 
                            {
                            $o=$this->match($this->input,$this->getToken('DESC'),self::$FOLLOW_DESC_in_orderCondition645); 

                            }
                            break;

                    }

                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_orderCondition649);
                    $brackettedExpression11=$this->brackettedExpression();

                    $this->state->_fsp--;


                    }

                      $this->_q->getOrder()->add($brackettedExpression11, ($o!=null?$o->getText():null));

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:150:7: (v= constraint | v= variable ) 
                    {
                    // Erfurt_Sparql_Sparql10.g:150:7: (v= constraint | v= variable ) 
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
                            // Erfurt_Sparql_Sparql10.g:150:9: v= constraint 
                            {
                            $this->pushFollow(self::$FOLLOW_constraint_in_orderCondition665);
                            $v=$this->constraint();

                            $this->state->_fsp--;


                            }
                            break;
                        case 2 :
                            // Erfurt_Sparql_Sparql10.g:150:24: v= variable 
                            {
                            $this->pushFollow(self::$FOLLOW_variable_in_orderCondition671);
                            $v=$this->variable();

                            $this->state->_fsp--;


                            }
                            break;

                    }

                      $this->_q->getOrder()->add($v);

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
    // Erfurt_Sparql_Sparql10.g:154:1: limitClause : LIMIT INTEGER ; 
    public function limitClause(){
        $INTEGER12=null;

        try {
            // Erfurt_Sparql_Sparql10.g:155:5: ( LIMIT INTEGER ) 
            // Erfurt_Sparql_Sparql10.g:155:7: LIMIT INTEGER 
            {
            $this->match($this->input,$this->getToken('LIMIT'),self::$FOLLOW_LIMIT_in_limitClause693); 
            $INTEGER12=$this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_limitClause695); 
              $this->_q->setLimit(($INTEGER12!=null?$INTEGER12->getText():null));

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
    // Erfurt_Sparql_Sparql10.g:159:1: offsetClause : OFFSET INTEGER ; 
    public function offsetClause(){
        $INTEGER13=null;

        try {
            // Erfurt_Sparql_Sparql10.g:160:5: ( OFFSET INTEGER ) 
            // Erfurt_Sparql_Sparql10.g:160:7: OFFSET INTEGER 
            {
            $this->match($this->input,$this->getToken('OFFSET'),self::$FOLLOW_OFFSET_in_offsetClause716); 
            $INTEGER13=$this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_offsetClause718); 
              $this->_q->setOffset(($INTEGER13!=null?$INTEGER13->getText():null));

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
    // Erfurt_Sparql_Sparql10.g:164:1: groupGraphPattern returns [$value] : OPEN_CURLY_BRACE (t1= triplesBlock )? ( (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? )* CLOSE_CURLY_BRACE ; 
    public function groupGraphPattern(){
        $value = null;

        $t1 = null;

        $v = null;

        $t2 = null;



        require_once('Erfurt/Sparql/Query2/GroupGraphPattern.php');
        $value = new Erfurt_Sparql_Query2_GroupGraphPattern();

        try {
            // Erfurt_Sparql_Sparql10.g:169:2: ( OPEN_CURLY_BRACE (t1= triplesBlock )? ( (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? )* CLOSE_CURLY_BRACE ) 
            // Erfurt_Sparql_Sparql10.g:169:4: OPEN_CURLY_BRACE (t1= triplesBlock )? ( (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? )* CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern744); 
            // Erfurt_Sparql_Sparql10.g:169:21: (t1= triplesBlock )? 
            $alt25=2;
            $LA25_0 = $this->input->LA(1);

            if ( (($LA25_0>=$this->getToken('TRUE') && $LA25_0<=$this->getToken('FALSE'))||$LA25_0==$this->getToken('IRI_REF')||$LA25_0==$this->getToken('PNAME_NS')||$LA25_0==$this->getToken('PNAME_LN')||($LA25_0>=$this->getToken('VAR1') && $LA25_0<=$this->getToken('VAR2'))||$LA25_0==$this->getToken('INTEGER')||$LA25_0==$this->getToken('DECIMAL')||$LA25_0==$this->getToken('DOUBLE')||($LA25_0>=$this->getToken('INTEGER_POSITIVE') && $LA25_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA25_0>=$this->getToken('STRING_LITERAL1') && $LA25_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA25_0==$this->getToken('BLANK_NODE_LABEL')||$LA25_0==$this->getToken('OPEN_BRACE')||$LA25_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt25=1;
            }
            switch ($alt25) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:169:22: t1= triplesBlock 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPattern749);
                    $t1=$this->triplesBlock();

                    $this->state->_fsp--;

                      $value ->addElements($t1);

                    }
                    break;

            }

            // Erfurt_Sparql_Sparql10.g:170:2: ( (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? )* 
            //loop29:
            do {
                $alt29=2;
                $LA29_0 = $this->input->LA(1);

                if ( (($LA29_0>=$this->getToken('OPTIONAL') && $LA29_0<=$this->getToken('GRAPH'))||$LA29_0==$this->getToken('FILTER')||$LA29_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                    $alt29=1;
                }


                switch ($alt29) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:170:4: (v= graphPatternNotTriples | v= filter ) ( DOT )? (t2= triplesBlock )? 
            	    {
            	    // Erfurt_Sparql_Sparql10.g:170:4: (v= graphPatternNotTriples | v= filter ) 
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
            	            // Erfurt_Sparql_Sparql10.g:170:6: v= graphPatternNotTriples 
            	            {
            	            $this->pushFollow(self::$FOLLOW_graphPatternNotTriples_in_groupGraphPattern762);
            	            $v=$this->graphPatternNotTriples();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 2 :
            	            // Erfurt_Sparql_Sparql10.g:170:33: v= filter 
            	            {
            	            $this->pushFollow(self::$FOLLOW_filter_in_groupGraphPattern768);
            	            $v=$this->filter();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }

            	      $value ->addElement($v);
            	    // Erfurt_Sparql_Sparql10.g:171:13: ( DOT )? 
            	    $alt27=2;
            	    $LA27_0 = $this->input->LA(1);

            	    if ( ($LA27_0==$this->getToken('DOT')) ) {
            	        $alt27=1;
            	    }
            	    switch ($alt27) {
            	        case 1 :
            	            // Erfurt_Sparql_Sparql10.g:171:13: DOT 
            	            {
            	            $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_groupGraphPattern786); 

            	            }
            	            break;

            	    }

            	    // Erfurt_Sparql_Sparql10.g:171:18: (t2= triplesBlock )? 
            	    $alt28=2;
            	    $LA28_0 = $this->input->LA(1);

            	    if ( (($LA28_0>=$this->getToken('TRUE') && $LA28_0<=$this->getToken('FALSE'))||$LA28_0==$this->getToken('IRI_REF')||$LA28_0==$this->getToken('PNAME_NS')||$LA28_0==$this->getToken('PNAME_LN')||($LA28_0>=$this->getToken('VAR1') && $LA28_0<=$this->getToken('VAR2'))||$LA28_0==$this->getToken('INTEGER')||$LA28_0==$this->getToken('DECIMAL')||$LA28_0==$this->getToken('DOUBLE')||($LA28_0>=$this->getToken('INTEGER_POSITIVE') && $LA28_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA28_0>=$this->getToken('STRING_LITERAL1') && $LA28_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA28_0==$this->getToken('BLANK_NODE_LABEL')||$LA28_0==$this->getToken('OPEN_BRACE')||$LA28_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
            	        $alt28=1;
            	    }
            	    switch ($alt28) {
            	        case 1 :
            	            // Erfurt_Sparql_Sparql10.g:171:19: t2= triplesBlock 
            	            {
            	            $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPattern792);
            	            $t2=$this->triplesBlock();

            	            $this->state->_fsp--;

            	              $value ->addElements($t2);

            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop29;
                }
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern801); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "groupGraphPattern"


    // $ANTLR start "triplesBlock"
    // Erfurt_Sparql_Sparql10.g:175:1: triplesBlock returns [$value] : triplesSameSubject ( DOT (t= triplesBlock )? )? ; 
    public function triplesBlock(){
        $value = null;

        $t = null;

        $triplesSameSubject14 = null;



        $value = array();

        try {
            // Erfurt_Sparql_Sparql10.g:179:5: ( triplesSameSubject ( DOT (t= triplesBlock )? )? ) 
            // Erfurt_Sparql_Sparql10.g:179:7: triplesSameSubject ( DOT (t= triplesBlock )? )? 
            {
            $this->pushFollow(self::$FOLLOW_triplesSameSubject_in_triplesBlock828);
            $triplesSameSubject14=$this->triplesSameSubject();

            $this->state->_fsp--;

              $value[]=$triplesSameSubject14;
            // Erfurt_Sparql_Sparql10.g:179:65: ( DOT (t= triplesBlock )? )? 
            $alt31=2;
            $LA31_0 = $this->input->LA(1);

            if ( ($LA31_0==$this->getToken('DOT')) ) {
                $alt31=1;
            }
            switch ($alt31) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:179:67: DOT (t= triplesBlock )? 
                    {
                    $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_triplesBlock834); 
                    // Erfurt_Sparql_Sparql10.g:179:71: (t= triplesBlock )? 
                    $alt30=2;
                    $LA30_0 = $this->input->LA(1);

                    if ( (($LA30_0>=$this->getToken('TRUE') && $LA30_0<=$this->getToken('FALSE'))||$LA30_0==$this->getToken('IRI_REF')||$LA30_0==$this->getToken('PNAME_NS')||$LA30_0==$this->getToken('PNAME_LN')||($LA30_0>=$this->getToken('VAR1') && $LA30_0<=$this->getToken('VAR2'))||$LA30_0==$this->getToken('INTEGER')||$LA30_0==$this->getToken('DECIMAL')||$LA30_0==$this->getToken('DOUBLE')||($LA30_0>=$this->getToken('INTEGER_POSITIVE') && $LA30_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA30_0>=$this->getToken('STRING_LITERAL1') && $LA30_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA30_0==$this->getToken('BLANK_NODE_LABEL')||$LA30_0==$this->getToken('OPEN_BRACE')||$LA30_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                        $alt30=1;
                    }
                    switch ($alt30) {
                        case 1 :
                            // Erfurt_Sparql_Sparql10.g:179:72: t= triplesBlock 
                            {
                            $this->pushFollow(self::$FOLLOW_triplesBlock_in_triplesBlock839);
                            $t=$this->triplesBlock();

                            $this->state->_fsp--;

                              $value = array_merge($value, $t);

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
        
        return $value;
    }
    // $ANTLR end "triplesBlock"


    // $ANTLR start "graphPatternNotTriples"
    // Erfurt_Sparql_Sparql10.g:183:1: graphPatternNotTriples returns [$value] : (v= optionalGraphPattern | v= groupOrUnionGraphPattern | v= graphGraphPattern ); 
    public function graphPatternNotTriples(){
        $value = null;

        $v = null;


        try {
            // Erfurt_Sparql_Sparql10.g:185:5: (v= optionalGraphPattern | v= groupOrUnionGraphPattern | v= graphGraphPattern ) 
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
                    // Erfurt_Sparql_Sparql10.g:185:7: v= optionalGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_optionalGraphPattern_in_graphPatternNotTriples876);
                    $v=$this->optionalGraphPattern();

                    $this->state->_fsp--;

                      $v=$v;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:186:7: v= groupOrUnionGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples888);
                    $v=$this->groupOrUnionGraphPattern();

                    $this->state->_fsp--;

                      $v=$v;

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:187:7: v= graphGraphPattern 
                    {
                    $this->pushFollow(self::$FOLLOW_graphGraphPattern_in_graphPatternNotTriples900);
                    $v=$this->graphGraphPattern();

                    $this->state->_fsp--;

                      $v=$v;

                    }
                    break;

            }
              $value = $v;
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "graphPatternNotTriples"


    // $ANTLR start "optionalGraphPattern"
    // Erfurt_Sparql_Sparql10.g:191:1: optionalGraphPattern returns [$value] : OPTIONAL groupGraphPattern ; 
    public function optionalGraphPattern(){
        $value = null;

        $groupGraphPattern15 = null;


        require_once('Erfurt/Sparql/Query2/OptionalGraphPattern.php');
        try {
            // Erfurt_Sparql_Sparql10.g:193:5: ( OPTIONAL groupGraphPattern ) 
            // Erfurt_Sparql_Sparql10.g:193:7: OPTIONAL groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('OPTIONAL'),self::$FOLLOW_OPTIONAL_in_optionalGraphPattern929); 
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_optionalGraphPattern931);
            $groupGraphPattern15=$this->groupGraphPattern();

            $this->state->_fsp--;

              $value = new Erfurt_Sparql_Query2_OptionalGraphPattern(); $value->addElement($groupGraphPattern15);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "optionalGraphPattern"


    // $ANTLR start "graphGraphPattern"
    // Erfurt_Sparql_Sparql10.g:197:1: graphGraphPattern returns [$value] : GRAPH varOrIRIref groupGraphPattern ; 
    public function graphGraphPattern(){
        $value = null;

        $varOrIRIref16 = null;

        $groupGraphPattern17 = null;


        require_once('Erfurt/Sparql/Query2/GraphGraphPattern.php');
        try {
            // Erfurt_Sparql_Sparql10.g:199:5: ( GRAPH varOrIRIref groupGraphPattern ) 
            // Erfurt_Sparql_Sparql10.g:199:7: GRAPH varOrIRIref groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('GRAPH'),self::$FOLLOW_GRAPH_in_graphGraphPattern960); 
            $this->pushFollow(self::$FOLLOW_varOrIRIref_in_graphGraphPattern962);
            $varOrIRIref16=$this->varOrIRIref();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_graphGraphPattern964);
            $groupGraphPattern17=$this->groupGraphPattern();

            $this->state->_fsp--;

              $value = new Erfurt_Sparql_Query2_GraphGraphPattern($varOrIRIref16); $value->addElement($groupGraphPattern17);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "graphGraphPattern"


    // $ANTLR start "groupOrUnionGraphPattern"
    // Erfurt_Sparql_Sparql10.g:203:1: groupOrUnionGraphPattern returns [$value] : v1= groupGraphPattern ( UNION v2= groupGraphPattern )* ; 
    public function groupOrUnionGraphPattern(){
        $value = null;

        $v1 = null;

        $v2 = null;



        require_once('Erfurt/Sparql/Query2/GroupOrUnionGraphPattern.php');
        $value = new Erfurt_Sparql_Query2_GroupOrUnionGraphPattern();

        try {
            // Erfurt_Sparql_Sparql10.g:208:5: (v1= groupGraphPattern ( UNION v2= groupGraphPattern )* ) 
            // Erfurt_Sparql_Sparql10.g:208:7: v1= groupGraphPattern ( UNION v2= groupGraphPattern )* 
            {
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern995);
            $v1=$this->groupGraphPattern();

            $this->state->_fsp--;

              $value->addElement($v1);
            // Erfurt_Sparql_Sparql10.g:208:62: ( UNION v2= groupGraphPattern )* 
            //loop33:
            do {
                $alt33=2;
                $LA33_0 = $this->input->LA(1);

                if ( ($LA33_0==$this->getToken('UNION')) ) {
                    $alt33=1;
                }


                switch ($alt33) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:208:64: UNION v2= groupGraphPattern 
            	    {
            	    $this->match($this->input,$this->getToken('UNION'),self::$FOLLOW_UNION_in_groupOrUnionGraphPattern1001); 
            	    $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern1005);
            	    $v2=$this->groupGraphPattern();

            	    $this->state->_fsp--;

            	      $value->addElement($v2);

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
        
        return $value;
    }
    // $ANTLR end "groupOrUnionGraphPattern"


    // $ANTLR start "filter"
    // Erfurt_Sparql_Sparql10.g:212:1: filter returns [$value] : FILTER constraint ; 
    public function filter(){
        $value = null;

        $constraint18 = null;


        require_once('Erfurt/Sparql/Query2/Filter.php');
        try {
            // Erfurt_Sparql_Sparql10.g:214:5: ( FILTER constraint ) 
            // Erfurt_Sparql_Sparql10.g:214:7: FILTER constraint 
            {
            $this->match($this->input,$this->getToken('FILTER'),self::$FOLLOW_FILTER_in_filter1037); 
            $this->pushFollow(self::$FOLLOW_constraint_in_filter1039);
            $constraint18=$this->constraint();

            $this->state->_fsp--;

              $value = new Erfurt_Sparql_Query2_Filter($constraint18);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "filter"


    // $ANTLR start "constraint"
    // Erfurt_Sparql_Sparql10.g:218:1: constraint returns [$value] : (v= brackettedExpression | v= builtInCall | v= functionCall ); 
    public function constraint(){
        $value = null;

        $v = null;


        try {
            // Erfurt_Sparql_Sparql10.g:220:5: (v= brackettedExpression | v= builtInCall | v= functionCall ) 
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
                    // Erfurt_Sparql_Sparql10.g:220:7: v= brackettedExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_constraint1070);
                    $v=$this->brackettedExpression();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:221:7: v= builtInCall 
                    {
                    $this->pushFollow(self::$FOLLOW_builtInCall_in_constraint1080);
                    $v=$this->builtInCall();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:222:7: v= functionCall 
                    {
                    $this->pushFollow(self::$FOLLOW_functionCall_in_constraint1090);
                    $v=$this->functionCall();

                    $this->state->_fsp--;


                    }
                    break;

            }
              $value = $v;
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "constraint"


    // $ANTLR start "functionCall"
    // Erfurt_Sparql_Sparql10.g:225:1: functionCall returns [$value] : iriRef argList ; 
    public function functionCall(){
        $value = null;

        $iriRef19 = null;

        $argList20 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:226:5: ( iriRef argList ) 
            // Erfurt_Sparql_Sparql10.g:226:7: iriRef argList 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_functionCall1112);
            $iriRef19=$this->iriRef();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_argList_in_functionCall1114);
            $argList20=$this->argList();

            $this->state->_fsp--;

              $value = new Erfurt_Sparql_Query2_Function($iriRef19, $argList20);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "functionCall"


    // $ANTLR start "argList"
    // Erfurt_Sparql_Sparql10.g:230:1: argList returns [$value] : ( OPEN_BRACE ( WS )* CLOSE_BRACE | OPEN_BRACE e1= expression ( COMMA e2= expression )* CLOSE_BRACE ); 
    public function argList(){
        $value = null;

        $e1 = null;

        $e2 = null;


        $value=array();
        try {
            // Erfurt_Sparql_Sparql10.g:232:5: ( OPEN_BRACE ( WS )* CLOSE_BRACE | OPEN_BRACE e1= expression ( COMMA e2= expression )* CLOSE_BRACE ) 
            $alt37=2;
            $LA37_0 = $this->input->LA(1);

            if ( ($LA37_0==$this->getToken('OPEN_BRACE')) ) {
                $LA37_1 = $this->input->LA(2);

                if ( ($LA37_1==$this->getToken('WS')||$LA37_1==$this->getToken('CLOSE_BRACE')) ) {
                    $alt37=1;
                }
                else if ( (($LA37_1>=$this->getToken('STR') && $LA37_1<=$this->getToken('REGEX'))||($LA37_1>=$this->getToken('TRUE') && $LA37_1<=$this->getToken('FALSE'))||$LA37_1==$this->getToken('IRI_REF')||$LA37_1==$this->getToken('PNAME_NS')||$LA37_1==$this->getToken('PNAME_LN')||($LA37_1>=$this->getToken('VAR1') && $LA37_1<=$this->getToken('MINUS'))||$LA37_1==$this->getToken('INTEGER')||$LA37_1==$this->getToken('DECIMAL')||($LA37_1>=$this->getToken('DOUBLE') && $LA37_1<=$this->getToken('DOUBLE_NEGATIVE'))||($LA37_1>=$this->getToken('STRING_LITERAL1') && $LA37_1<=$this->getToken('STRING_LITERAL_LONG2'))||$LA37_1==$this->getToken('NOT_SIGN')||$LA37_1==$this->getToken('OPEN_BRACE')) ) {
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
                    // Erfurt_Sparql_Sparql10.g:232:7: OPEN_BRACE ( WS )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_argList1143); 
                    // Erfurt_Sparql_Sparql10.g:232:18: ( WS )* 
                    //loop35:
                    do {
                        $alt35=2;
                        $LA35_0 = $this->input->LA(1);

                        if ( ($LA35_0==$this->getToken('WS')) ) {
                            $alt35=1;
                        }


                        switch ($alt35) {
                    	case 1 :
                    	    // Erfurt_Sparql_Sparql10.g:232:18: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_argList1145); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop35;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_argList1148); 

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:233:7: OPEN_BRACE e1= expression ( COMMA e2= expression )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_argList1156); 
                    $this->pushFollow(self::$FOLLOW_expression_in_argList1160);
                    $e1=$this->expression();

                    $this->state->_fsp--;

                      $value []= $e1;
                    // Erfurt_Sparql_Sparql10.g:234:9: ( COMMA e2= expression )* 
                    //loop36:
                    do {
                        $alt36=2;
                        $LA36_0 = $this->input->LA(1);

                        if ( ($LA36_0==$this->getToken('COMMA')) ) {
                            $alt36=1;
                        }


                        switch ($alt36) {
                    	case 1 :
                    	    // Erfurt_Sparql_Sparql10.g:234:11: COMMA e2= expression 
                    	    {
                    	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_argList1174); 
                    	    $this->pushFollow(self::$FOLLOW_expression_in_argList1178);
                    	    $e2=$this->expression();

                    	    $this->state->_fsp--;

                    	      $value []= $e2;

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop36;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_argList1184); 

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
        
        return $value;
    }
    // $ANTLR end "argList"


    // $ANTLR start "constructTemplate"
    // Erfurt_Sparql_Sparql10.g:238:1: constructTemplate returns [$value] : OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ; 
    public function constructTemplate(){
        $value = null;

        $constructTriples21 = null;


        $value = new Erfurt_Sparql_Query2_ConstructTemplate();
        try {
            // Erfurt_Sparql_Sparql10.g:240:5: ( OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE ) 
            // Erfurt_Sparql_Sparql10.g:240:7: OPEN_CURLY_BRACE ( constructTriples )? CLOSE_CURLY_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate1211); 
            // Erfurt_Sparql_Sparql10.g:240:24: ( constructTriples )? 
            $alt38=2;
            $LA38_0 = $this->input->LA(1);

            if ( (($LA38_0>=$this->getToken('TRUE') && $LA38_0<=$this->getToken('FALSE'))||$LA38_0==$this->getToken('IRI_REF')||$LA38_0==$this->getToken('PNAME_NS')||$LA38_0==$this->getToken('PNAME_LN')||($LA38_0>=$this->getToken('VAR1') && $LA38_0<=$this->getToken('VAR2'))||$LA38_0==$this->getToken('INTEGER')||$LA38_0==$this->getToken('DECIMAL')||$LA38_0==$this->getToken('DOUBLE')||($LA38_0>=$this->getToken('INTEGER_POSITIVE') && $LA38_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA38_0>=$this->getToken('STRING_LITERAL1') && $LA38_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA38_0==$this->getToken('BLANK_NODE_LABEL')||$LA38_0==$this->getToken('OPEN_BRACE')||$LA38_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt38=1;
            }
            switch ($alt38) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:240:25: constructTriples 
                    {
                    $this->pushFollow(self::$FOLLOW_constructTriples_in_constructTemplate1214);
                    $constructTriples21=$this->constructTriples();

                    $this->state->_fsp--;

                      $value->setElements($constructTriples21);

                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate1220); 

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "constructTemplate"


    // $ANTLR start "constructTriples"
    // Erfurt_Sparql_Sparql10.g:244:1: constructTriples returns [$value] : triplesSameSubject ( DOT (c= constructTriples )? )? ; 
    public function constructTriples(){
        $value = null;

        $c = null;

        $triplesSameSubject22 = null;


        $value=array();
        try {
            // Erfurt_Sparql_Sparql10.g:246:5: ( triplesSameSubject ( DOT (c= constructTriples )? )? ) 
            // Erfurt_Sparql_Sparql10.g:246:7: triplesSameSubject ( DOT (c= constructTriples )? )? 
            {
            $this->pushFollow(self::$FOLLOW_triplesSameSubject_in_constructTriples1247);
            $triplesSameSubject22=$this->triplesSameSubject();

            $this->state->_fsp--;

              $value []= $triplesSameSubject22;
            // Erfurt_Sparql_Sparql10.g:246:67: ( DOT (c= constructTriples )? )? 
            $alt40=2;
            $LA40_0 = $this->input->LA(1);

            if ( ($LA40_0==$this->getToken('DOT')) ) {
                $alt40=1;
            }
            switch ($alt40) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:246:69: DOT (c= constructTriples )? 
                    {
                    $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_constructTriples1253); 
                    // Erfurt_Sparql_Sparql10.g:246:73: (c= constructTriples )? 
                    $alt39=2;
                    $LA39_0 = $this->input->LA(1);

                    if ( (($LA39_0>=$this->getToken('TRUE') && $LA39_0<=$this->getToken('FALSE'))||$LA39_0==$this->getToken('IRI_REF')||$LA39_0==$this->getToken('PNAME_NS')||$LA39_0==$this->getToken('PNAME_LN')||($LA39_0>=$this->getToken('VAR1') && $LA39_0<=$this->getToken('VAR2'))||$LA39_0==$this->getToken('INTEGER')||$LA39_0==$this->getToken('DECIMAL')||$LA39_0==$this->getToken('DOUBLE')||($LA39_0>=$this->getToken('INTEGER_POSITIVE') && $LA39_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA39_0>=$this->getToken('STRING_LITERAL1') && $LA39_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA39_0==$this->getToken('BLANK_NODE_LABEL')||$LA39_0==$this->getToken('OPEN_BRACE')||$LA39_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                        $alt39=1;
                    }
                    switch ($alt39) {
                        case 1 :
                            // Erfurt_Sparql_Sparql10.g:246:74: c= constructTriples 
                            {
                            $this->pushFollow(self::$FOLLOW_constructTriples_in_constructTriples1258);
                            $c=$this->constructTriples();

                            $this->state->_fsp--;

                              $value = array_merge($value, $c);

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
        
        return $value;
    }
    // $ANTLR end "constructTriples"


    // $ANTLR start "triplesSameSubject"
    // Erfurt_Sparql_Sparql10.g:250:1: triplesSameSubject returns [$value] : ( varOrTerm propertyListNotEmpty | triplesNode propertyList ); 
    public function triplesSameSubject(){
        $value = null;

        $varOrTerm23 = null;

        $propertyListNotEmpty24 = null;

        $triplesNode25 = null;

        $propertyList26 = null;


        require_once('Erfurt/Sparql/Query2/TriplesSameSubject.php');
        try {
            // Erfurt_Sparql_Sparql10.g:252:5: ( varOrTerm propertyListNotEmpty | triplesNode propertyList ) 
            $alt41=2;
            $LA41 = $this->input->LA(1);
            if($this->getToken('TRUE')== $LA41||$this->getToken('FALSE')== $LA41||$this->getToken('IRI_REF')== $LA41||$this->getToken('PNAME_NS')== $LA41||$this->getToken('PNAME_LN')== $LA41||$this->getToken('VAR1')== $LA41||$this->getToken('VAR2')== $LA41||$this->getToken('INTEGER')== $LA41||$this->getToken('DECIMAL')== $LA41||$this->getToken('DOUBLE')== $LA41||$this->getToken('INTEGER_POSITIVE')== $LA41||$this->getToken('DECIMAL_POSITIVE')== $LA41||$this->getToken('DOUBLE_POSITIVE')== $LA41||$this->getToken('INTEGER_NEGATIVE')== $LA41||$this->getToken('DECIMAL_NEGATIVE')== $LA41||$this->getToken('DOUBLE_NEGATIVE')== $LA41||$this->getToken('STRING_LITERAL1')== $LA41||$this->getToken('STRING_LITERAL2')== $LA41||$this->getToken('STRING_LITERAL_LONG1')== $LA41||$this->getToken('STRING_LITERAL_LONG2')== $LA41||$this->getToken('BLANK_NODE_LABEL')== $LA41)
                {
                $alt41=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA41)
                {
                $LA41_2 = $this->input->LA(2);

                if ( ($LA41_2==$this->getToken('WS')||$LA41_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt41=1;
                }
                else if ( ($LA41_2==$this->getToken('A')||$LA41_2==$this->getToken('IRI_REF')||$LA41_2==$this->getToken('PNAME_NS')||$LA41_2==$this->getToken('PNAME_LN')||($LA41_2>=$this->getToken('VAR1') && $LA41_2<=$this->getToken('VAR2'))) ) {
                    $alt41=2;
                }
                else {
                    $nvae = new NoViableAltException("", 41, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA41)
                {
                $LA41_3 = $this->input->LA(2);

                if ( ($LA41_3==$this->getToken('WS')||$LA41_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt41=1;
                }
                else if ( (($LA41_3>=$this->getToken('TRUE') && $LA41_3<=$this->getToken('FALSE'))||$LA41_3==$this->getToken('IRI_REF')||$LA41_3==$this->getToken('PNAME_NS')||$LA41_3==$this->getToken('PNAME_LN')||($LA41_3>=$this->getToken('VAR1') && $LA41_3<=$this->getToken('VAR2'))||$LA41_3==$this->getToken('INTEGER')||$LA41_3==$this->getToken('DECIMAL')||$LA41_3==$this->getToken('DOUBLE')||($LA41_3>=$this->getToken('INTEGER_POSITIVE') && $LA41_3<=$this->getToken('DOUBLE_NEGATIVE'))||($LA41_3>=$this->getToken('STRING_LITERAL1') && $LA41_3<=$this->getToken('STRING_LITERAL_LONG2'))||$LA41_3==$this->getToken('BLANK_NODE_LABEL')||$LA41_3==$this->getToken('OPEN_BRACE')||$LA41_3==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt41=2;
                }
                else {
                    $nvae = new NoViableAltException("", 41, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 41, 0, $this->input);

                throw $nvae;
            }

            switch ($alt41) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:252:7: varOrTerm propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_triplesSameSubject1292);
                    $varOrTerm23=$this->varOrTerm();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_triplesSameSubject1294);
                    $propertyListNotEmpty24=$this->propertyListNotEmpty();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_TriplesSameSubject($varOrTerm23, $propertyListNotEmpty24);

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:253:7: triplesNode propertyList 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_triplesSameSubject1304);
                    $triplesNode25=$this->triplesNode();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyList_in_triplesSameSubject1306);
                    $propertyList26=$this->propertyList();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_TriplesSameSubject($triplesNode25, $propertyList26);

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
        
        return $value;
    }
    // $ANTLR end "triplesSameSubject"


    // $ANTLR start "propertyListNotEmpty"
    // Erfurt_Sparql_Sparql10.g:257:1: propertyListNotEmpty returns [$value] : v1= verb ol1= objectList ( SEMICOLON (v2= verb ol2= objectList )? )* ; 
    public function propertyListNotEmpty(){
        $value = null;

        $v1 = null;

        $ol1 = null;

        $v2 = null;

        $ol2 = null;


        require_once 'Erfurt/Sparql/Query2/PropertyList.php';
        $value = new Erfurt_Sparql_Query2_PropertyList();
        try {
            // Erfurt_Sparql_Sparql10.g:260:5: (v1= verb ol1= objectList ( SEMICOLON (v2= verb ol2= objectList )? )* ) 
            // Erfurt_Sparql_Sparql10.g:260:7: v1= verb ol1= objectList ( SEMICOLON (v2= verb ol2= objectList )? )* 
            {
            $this->pushFollow(self::$FOLLOW_verb_in_propertyListNotEmpty1337);
            $v1=$this->verb();

            $this->state->_fsp--;

            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmpty1341);
            $ol1=$this->objectList();

            $this->state->_fsp--;

              $value->addProperty($v1, $ol1);
            // Erfurt_Sparql_Sparql10.g:261:9: ( SEMICOLON (v2= verb ol2= objectList )? )* 
            //loop43:
            do {
                $alt43=2;
                $LA43_0 = $this->input->LA(1);

                if ( ($LA43_0==$this->getToken('SEMICOLON')) ) {
                    $alt43=1;
                }


                switch ($alt43) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:261:11: SEMICOLON (v2= verb ol2= objectList )? 
            	    {
            	    $this->match($this->input,$this->getToken('SEMICOLON'),self::$FOLLOW_SEMICOLON_in_propertyListNotEmpty1355); 
            	    // Erfurt_Sparql_Sparql10.g:261:21: (v2= verb ol2= objectList )? 
            	    $alt42=2;
            	    $LA42_0 = $this->input->LA(1);

            	    if ( ($LA42_0==$this->getToken('A')||$LA42_0==$this->getToken('IRI_REF')||$LA42_0==$this->getToken('PNAME_NS')||$LA42_0==$this->getToken('PNAME_LN')||($LA42_0>=$this->getToken('VAR1') && $LA42_0<=$this->getToken('VAR2'))) ) {
            	        $alt42=1;
            	    }
            	    switch ($alt42) {
            	        case 1 :
            	            // Erfurt_Sparql_Sparql10.g:261:23: v2= verb ol2= objectList 
            	            {
            	            $this->pushFollow(self::$FOLLOW_verb_in_propertyListNotEmpty1361);
            	            $v2=$this->verb();

            	            $this->state->_fsp--;

            	            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmpty1365);
            	            $ol2=$this->objectList();

            	            $this->state->_fsp--;

            	              $value->addProperty($v2, $ol2);

            	            }
            	            break;

            	    }


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
        
        return $value;
    }
    // $ANTLR end "propertyListNotEmpty"


    // $ANTLR start "propertyList"
    // Erfurt_Sparql_Sparql10.g:265:1: propertyList returns [$value] : ( propertyListNotEmpty )? ; 
    public function propertyList(){
        $value = null;

        $propertyListNotEmpty27 = null;


        require_once 'Erfurt/Sparql/Query2/PropertyList.php';
        $v=null;
        try {
            // Erfurt_Sparql_Sparql10.g:269:5: ( ( propertyListNotEmpty )? ) 
            // Erfurt_Sparql_Sparql10.g:269:7: ( propertyListNotEmpty )? 
            {
            // Erfurt_Sparql_Sparql10.g:269:7: ( propertyListNotEmpty )? 
            $alt44=2;
            $LA44_0 = $this->input->LA(1);

            if ( ($LA44_0==$this->getToken('A')||$LA44_0==$this->getToken('IRI_REF')||$LA44_0==$this->getToken('PNAME_NS')||$LA44_0==$this->getToken('PNAME_LN')||($LA44_0>=$this->getToken('VAR1') && $LA44_0<=$this->getToken('VAR2'))) ) {
                $alt44=1;
            }
            switch ($alt44) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:269:8: propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_propertyList1404);
                    $propertyListNotEmpty27=$this->propertyListNotEmpty();

                    $this->state->_fsp--;

                      $v = $propertyListNotEmpty27;

                    }
                    break;

            }


            }

              $value=$v?$v:new Erfurt_Sparql_Query2_PropertyList();
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "propertyList"


    // $ANTLR start "objectList"
    // Erfurt_Sparql_Sparql10.g:273:1: objectList returns [$value] : o1= object ( COMMA o2= object )* ; 
    public function objectList(){
        $value = null;

        $o1 = null;

        $o2 = null;


        require_once 'Erfurt/Sparql/Query2/ObjectList.php';
        try {
            // Erfurt_Sparql_Sparql10.g:275:5: (o1= object ( COMMA o2= object )* ) 
            // Erfurt_Sparql_Sparql10.g:275:7: o1= object ( COMMA o2= object )* 
            {
            $this->pushFollow(self::$FOLLOW_object_in_objectList1437);
            $o1=$this->object();

            $this->state->_fsp--;

              $value = new Erfurt_Sparql_Query2_ObjectList(array($o1));
            // Erfurt_Sparql_Sparql10.g:276:9: ( COMMA o2= object )* 
            //loop45:
            do {
                $alt45=2;
                $LA45_0 = $this->input->LA(1);

                if ( ($LA45_0==$this->getToken('COMMA')) ) {
                    $alt45=1;
                }


                switch ($alt45) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:276:11: COMMA o2= object 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectList1451); 
            	    $this->pushFollow(self::$FOLLOW_object_in_objectList1455);
            	    $o2=$this->object();

            	    $this->state->_fsp--;

            	      $value -> addElement($o2);

            	    }
            	    break;

            	default :
            	    break 2;//loop45;
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
        
        return $value;
    }
    // $ANTLR end "objectList"


    // $ANTLR start "object"
    // Erfurt_Sparql_Sparql10.g:280:1: object returns [$value] : graphNode ; 
    public function object(){
        $value = null;

        $graphNode28 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:281:5: ( graphNode ) 
            // Erfurt_Sparql_Sparql10.g:281:7: graphNode 
            {
            $this->pushFollow(self::$FOLLOW_graphNode_in_object1483);
            $graphNode28=$this->graphNode();

            $this->state->_fsp--;

              $value = $graphNode28;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "object"


    // $ANTLR start "verb"
    // Erfurt_Sparql_Sparql10.g:285:1: verb returns [$value] : ( varOrIRIref | A ); 
    public function verb(){
        $value = null;

        $varOrIRIref29 = null;


        require_once('Erfurt/Sparql/Query2/A.php');
        try {
            // Erfurt_Sparql_Sparql10.g:287:5: ( varOrIRIref | A ) 
            $alt46=2;
            $LA46_0 = $this->input->LA(1);

            if ( ($LA46_0==$this->getToken('IRI_REF')||$LA46_0==$this->getToken('PNAME_NS')||$LA46_0==$this->getToken('PNAME_LN')||($LA46_0>=$this->getToken('VAR1') && $LA46_0<=$this->getToken('VAR2'))) ) {
                $alt46=1;
            }
            else if ( ($LA46_0==$this->getToken('A')) ) {
                $alt46=2;
            }
            else {
                $nvae = new NoViableAltException("", 46, 0, $this->input);

                throw $nvae;
            }
            switch ($alt46) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:287:7: varOrIRIref 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrIRIref_in_verb1512);
                    $varOrIRIref29=$this->varOrIRIref();

                    $this->state->_fsp--;

                      $value = $varOrIRIref29;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:288:7: A 
                    {
                    $this->match($this->input,$this->getToken('A'),self::$FOLLOW_A_in_verb1522); 
                      $value = new Erfurt_Sparql_Query2_A();

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
        
        return $value;
    }
    // $ANTLR end "verb"


    // $ANTLR start "triplesNode"
    // Erfurt_Sparql_Sparql10.g:292:1: triplesNode returns [$value] : ( collection | blankNodePropertyList ); 
    public function triplesNode(){
        $value = null;

        $collection30 = null;

        $blankNodePropertyList31 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:293:5: ( collection | blankNodePropertyList ) 
            $alt47=2;
            $LA47_0 = $this->input->LA(1);

            if ( ($LA47_0==$this->getToken('OPEN_BRACE')) ) {
                $alt47=1;
            }
            else if ( ($LA47_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt47=2;
            }
            else {
                $nvae = new NoViableAltException("", 47, 0, $this->input);

                throw $nvae;
            }
            switch ($alt47) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:293:7: collection 
                    {
                    $this->pushFollow(self::$FOLLOW_collection_in_triplesNode1547);
                    $collection30=$this->collection();

                    $this->state->_fsp--;

                      $value = $collection30;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:294:7: blankNodePropertyList 
                    {
                    $this->pushFollow(self::$FOLLOW_blankNodePropertyList_in_triplesNode1557);
                    $blankNodePropertyList31=$this->blankNodePropertyList();

                    $this->state->_fsp--;

                      $value = $blankNodePropertyList31;

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
        
        return $value;
    }
    // $ANTLR end "triplesNode"


    // $ANTLR start "blankNodePropertyList"
    // Erfurt_Sparql_Sparql10.g:298:1: blankNodePropertyList returns [$value] : OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE ; 
    public function blankNodePropertyList(){
        $value = null;

        $propertyListNotEmpty32 = null;


        require_once 'Erfurt/Sparql/Query2/BlankNodePropertyList.php';
        try {
            // Erfurt_Sparql_Sparql10.g:300:5: ( OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE ) 
            // Erfurt_Sparql_Sparql10.g:300:7: OPEN_SQUARE_BRACE propertyListNotEmpty CLOSE_SQUARE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1586); 
            $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1588);
            $propertyListNotEmpty32=$this->propertyListNotEmpty();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1590); 
              $value = new Erfurt_Sparql_Query2_BlankNodePropertyList($propertyListNotEmpty32);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "blankNodePropertyList"


    // $ANTLR start "collection"
    // Erfurt_Sparql_Sparql10.g:304:1: collection returns [$value] : OPEN_BRACE ( graphNode )+ CLOSE_BRACE ; 
    public function collection(){
        $value = null;

        $graphNode33 = null;


        require_once 'Erfurt/Sparql/Query2/Collection.php';
        $list=array();
        try {
            // Erfurt_Sparql_Sparql10.g:308:5: ( OPEN_BRACE ( graphNode )+ CLOSE_BRACE ) 
            // Erfurt_Sparql_Sparql10.g:308:7: OPEN_BRACE ( graphNode )+ CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_collection1623); 
            // Erfurt_Sparql_Sparql10.g:308:18: ( graphNode )+ 
            $cnt48=0;
            //loop48:
            do {
                $alt48=2;
                $LA48_0 = $this->input->LA(1);

                if ( (($LA48_0>=$this->getToken('TRUE') && $LA48_0<=$this->getToken('FALSE'))||$LA48_0==$this->getToken('IRI_REF')||$LA48_0==$this->getToken('PNAME_NS')||$LA48_0==$this->getToken('PNAME_LN')||($LA48_0>=$this->getToken('VAR1') && $LA48_0<=$this->getToken('VAR2'))||$LA48_0==$this->getToken('INTEGER')||$LA48_0==$this->getToken('DECIMAL')||$LA48_0==$this->getToken('DOUBLE')||($LA48_0>=$this->getToken('INTEGER_POSITIVE') && $LA48_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA48_0>=$this->getToken('STRING_LITERAL1') && $LA48_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA48_0==$this->getToken('BLANK_NODE_LABEL')||$LA48_0==$this->getToken('OPEN_BRACE')||$LA48_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt48=1;
                }


                switch ($alt48) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:308:19: graphNode 
            	    {
            	    $this->pushFollow(self::$FOLLOW_graphNode_in_collection1626);
            	    $graphNode33=$this->graphNode();

            	    $this->state->_fsp--;

            	       $list []= $graphNode33;

            	    }
            	    break;

            	default :
            	    if ( $cnt48 >= 1 ) break 2;//loop48;
                        $eee =
                            new EarlyExitException(48, $this->input);
                        throw $eee;
                }
                $cnt48++;
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_collection1632); 

            }

              $value = new Erfurt_Sparql_Query2_Collection($list);
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "collection"


    // $ANTLR start "graphNode"
    // Erfurt_Sparql_Sparql10.g:312:1: graphNode returns [$value] : ( varOrTerm | triplesNode ); 
    public function graphNode(){
        $value = null;

        $varOrTerm34 = null;

        $triplesNode35 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:313:5: ( varOrTerm | triplesNode ) 
            $alt49=2;
            $LA49 = $this->input->LA(1);
            if($this->getToken('TRUE')== $LA49||$this->getToken('FALSE')== $LA49||$this->getToken('IRI_REF')== $LA49||$this->getToken('PNAME_NS')== $LA49||$this->getToken('PNAME_LN')== $LA49||$this->getToken('VAR1')== $LA49||$this->getToken('VAR2')== $LA49||$this->getToken('INTEGER')== $LA49||$this->getToken('DECIMAL')== $LA49||$this->getToken('DOUBLE')== $LA49||$this->getToken('INTEGER_POSITIVE')== $LA49||$this->getToken('DECIMAL_POSITIVE')== $LA49||$this->getToken('DOUBLE_POSITIVE')== $LA49||$this->getToken('INTEGER_NEGATIVE')== $LA49||$this->getToken('DECIMAL_NEGATIVE')== $LA49||$this->getToken('DOUBLE_NEGATIVE')== $LA49||$this->getToken('STRING_LITERAL1')== $LA49||$this->getToken('STRING_LITERAL2')== $LA49||$this->getToken('STRING_LITERAL_LONG1')== $LA49||$this->getToken('STRING_LITERAL_LONG2')== $LA49||$this->getToken('BLANK_NODE_LABEL')== $LA49)
                {
                $alt49=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA49)
                {
                $LA49_2 = $this->input->LA(2);

                if ( ($LA49_2==$this->getToken('WS')||$LA49_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt49=1;
                }
                else if ( ($LA49_2==$this->getToken('A')||$LA49_2==$this->getToken('IRI_REF')||$LA49_2==$this->getToken('PNAME_NS')||$LA49_2==$this->getToken('PNAME_LN')||($LA49_2>=$this->getToken('VAR1') && $LA49_2<=$this->getToken('VAR2'))) ) {
                    $alt49=2;
                }
                else {
                    $nvae = new NoViableAltException("", 49, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA49)
                {
                $LA49_3 = $this->input->LA(2);

                if ( (($LA49_3>=$this->getToken('TRUE') && $LA49_3<=$this->getToken('FALSE'))||$LA49_3==$this->getToken('IRI_REF')||$LA49_3==$this->getToken('PNAME_NS')||$LA49_3==$this->getToken('PNAME_LN')||($LA49_3>=$this->getToken('VAR1') && $LA49_3<=$this->getToken('VAR2'))||$LA49_3==$this->getToken('INTEGER')||$LA49_3==$this->getToken('DECIMAL')||$LA49_3==$this->getToken('DOUBLE')||($LA49_3>=$this->getToken('INTEGER_POSITIVE') && $LA49_3<=$this->getToken('DOUBLE_NEGATIVE'))||($LA49_3>=$this->getToken('STRING_LITERAL1') && $LA49_3<=$this->getToken('STRING_LITERAL_LONG2'))||$LA49_3==$this->getToken('BLANK_NODE_LABEL')||$LA49_3==$this->getToken('OPEN_BRACE')||$LA49_3==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt49=2;
                }
                else if ( ($LA49_3==$this->getToken('WS')||$LA49_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt49=1;
                }
                else {
                    $nvae = new NoViableAltException("", 49, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 49, 0, $this->input);

                throw $nvae;
            }

            switch ($alt49) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:313:7: varOrTerm 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_graphNode1655);
                    $varOrTerm34=$this->varOrTerm();

                    $this->state->_fsp--;

                      $value=$varOrTerm34;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:314:7: triplesNode 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_graphNode1665);
                    $triplesNode35=$this->triplesNode();

                    $this->state->_fsp--;

                      $value=$triplesNode35;

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
        
        return $value;
    }
    // $ANTLR end "graphNode"


    // $ANTLR start "varOrTerm"
    // Erfurt_Sparql_Sparql10.g:318:1: varOrTerm returns [$value] : ( variable | graphTerm ); 
    public function varOrTerm(){
        $value = null;

        $variable36 = null;

        $graphTerm37 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:319:5: ( variable | graphTerm ) 
            $alt50=2;
            $LA50_0 = $this->input->LA(1);

            if ( (($LA50_0>=$this->getToken('VAR1') && $LA50_0<=$this->getToken('VAR2'))) ) {
                $alt50=1;
            }
            else if ( (($LA50_0>=$this->getToken('TRUE') && $LA50_0<=$this->getToken('FALSE'))||$LA50_0==$this->getToken('IRI_REF')||$LA50_0==$this->getToken('PNAME_NS')||$LA50_0==$this->getToken('PNAME_LN')||$LA50_0==$this->getToken('INTEGER')||$LA50_0==$this->getToken('DECIMAL')||$LA50_0==$this->getToken('DOUBLE')||($LA50_0>=$this->getToken('INTEGER_POSITIVE') && $LA50_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA50_0>=$this->getToken('STRING_LITERAL1') && $LA50_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA50_0==$this->getToken('BLANK_NODE_LABEL')||$LA50_0==$this->getToken('OPEN_BRACE')||$LA50_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt50=2;
            }
            else {
                $nvae = new NoViableAltException("", 50, 0, $this->input);

                throw $nvae;
            }
            switch ($alt50) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:319:7: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_varOrTerm1690);
                    $variable36=$this->variable();

                    $this->state->_fsp--;

                      $value = $variable36;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:320:7: graphTerm 
                    {
                    $this->pushFollow(self::$FOLLOW_graphTerm_in_varOrTerm1700);
                    $graphTerm37=$this->graphTerm();

                    $this->state->_fsp--;

                      $value = $graphTerm37;

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
        
        return $value;
    }
    // $ANTLR end "varOrTerm"


    // $ANTLR start "varOrIRIref"
    // Erfurt_Sparql_Sparql10.g:324:1: varOrIRIref returns [$value] : ( variable | iriRef ); 
    public function varOrIRIref(){
        $value = null;

        $variable38 = null;

        $iriRef39 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:325:5: ( variable | iriRef ) 
            $alt51=2;
            $LA51_0 = $this->input->LA(1);

            if ( (($LA51_0>=$this->getToken('VAR1') && $LA51_0<=$this->getToken('VAR2'))) ) {
                $alt51=1;
            }
            else if ( ($LA51_0==$this->getToken('IRI_REF')||$LA51_0==$this->getToken('PNAME_NS')||$LA51_0==$this->getToken('PNAME_LN')) ) {
                $alt51=2;
            }
            else {
                $nvae = new NoViableAltException("", 51, 0, $this->input);

                throw $nvae;
            }
            switch ($alt51) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:325:7: variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_varOrIRIref1725);
                    $variable38=$this->variable();

                    $this->state->_fsp--;

                      $value = $variable38;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:326:7: iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_varOrIRIref1735);
                    $iriRef39=$this->iriRef();

                    $this->state->_fsp--;

                      $value = $iriRef39;

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
        
        return $value;
    }
    // $ANTLR end "varOrIRIref"


    // $ANTLR start "variable"
    // Erfurt_Sparql_Sparql10.g:330:1: variable returns [$value] : (v= VAR1 | v= VAR2 ); 
    public function variable(){
        $value = null;

        $v=null;

        require_once('Erfurt/Sparql/Query2/Var.php');
        try {
            // Erfurt_Sparql_Sparql10.g:333:5: (v= VAR1 | v= VAR2 ) 
            $alt52=2;
            $LA52_0 = $this->input->LA(1);

            if ( ($LA52_0==$this->getToken('VAR1')) ) {
                $alt52=1;
            }
            else if ( ($LA52_0==$this->getToken('VAR2')) ) {
                $alt52=2;
            }
            else {
                $nvae = new NoViableAltException("", 52, 0, $this->input);

                throw $nvae;
            }
            switch ($alt52) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:333:7: v= VAR1 
                    {
                    $v=$this->match($this->input,$this->getToken('VAR1'),self::$FOLLOW_VAR1_in_variable1770); 
                      $vartype = "?";

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:334:7: v= VAR2 
                    {
                    $v=$this->match($this->input,$this->getToken('VAR2'),self::$FOLLOW_VAR2_in_variable1782); 
                      $vartype = "$";

                    }
                    break;

            }
              $value = new Erfurt_Sparql_Query2_Var(($v!=null?$v->getText():null)); $value->setVarLabelType($vartype);
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "variable"


    // $ANTLR start "graphTerm"
    // Erfurt_Sparql_Sparql10.g:338:1: graphTerm returns [$value] : (v= iriRef | v= rdfLiteral | v= numericLiteral | v= booleanLiteral | v= blankNode | OPEN_BRACE ( WS )* CLOSE_BRACE ); 
    public function graphTerm(){
        $value = null;

        $v = null;


        require_once('Erfurt/Sparql/Query2/Nil.php');
        try {
            // Erfurt_Sparql_Sparql10.g:340:5: (v= iriRef | v= rdfLiteral | v= numericLiteral | v= booleanLiteral | v= blankNode | OPEN_BRACE ( WS )* CLOSE_BRACE ) 
            $alt54=6;
            $LA54 = $this->input->LA(1);
            if($this->getToken('IRI_REF')== $LA54||$this->getToken('PNAME_NS')== $LA54||$this->getToken('PNAME_LN')== $LA54)
                {
                $alt54=1;
                }
            else if($this->getToken('STRING_LITERAL1')== $LA54||$this->getToken('STRING_LITERAL2')== $LA54||$this->getToken('STRING_LITERAL_LONG1')== $LA54||$this->getToken('STRING_LITERAL_LONG2')== $LA54)
                {
                $alt54=2;
                }
            else if($this->getToken('INTEGER')== $LA54||$this->getToken('DECIMAL')== $LA54||$this->getToken('DOUBLE')== $LA54||$this->getToken('INTEGER_POSITIVE')== $LA54||$this->getToken('DECIMAL_POSITIVE')== $LA54||$this->getToken('DOUBLE_POSITIVE')== $LA54||$this->getToken('INTEGER_NEGATIVE')== $LA54||$this->getToken('DECIMAL_NEGATIVE')== $LA54||$this->getToken('DOUBLE_NEGATIVE')== $LA54)
                {
                $alt54=3;
                }
            else if($this->getToken('TRUE')== $LA54||$this->getToken('FALSE')== $LA54)
                {
                $alt54=4;
                }
            else if($this->getToken('BLANK_NODE_LABEL')== $LA54||$this->getToken('OPEN_SQUARE_BRACE')== $LA54)
                {
                $alt54=5;
                }
            else if($this->getToken('OPEN_BRACE')== $LA54)
                {
                $alt54=6;
                }
            else{
                $nvae =
                    new NoViableAltException("", 54, 0, $this->input);

                throw $nvae;
            }

            switch ($alt54) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:340:7: v= iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_graphTerm1813);
                    $v=$this->iriRef();

                    $this->state->_fsp--;

                      $value=$v;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:341:7: v= rdfLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_rdfLiteral_in_graphTerm1825);
                    $v=$this->rdfLiteral();

                    $this->state->_fsp--;

                      $value=$v;

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:342:7: v= numericLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteral_in_graphTerm1837);
                    $v=$this->numericLiteral();

                    $this->state->_fsp--;

                      $value=$v;

                    }
                    break;
                case 4 :
                    // Erfurt_Sparql_Sparql10.g:343:7: v= booleanLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_booleanLiteral_in_graphTerm1849);
                    $v=$this->booleanLiteral();

                    $this->state->_fsp--;

                      $value=$v;

                    }
                    break;
                case 5 :
                    // Erfurt_Sparql_Sparql10.g:344:7: v= blankNode 
                    {
                    $this->pushFollow(self::$FOLLOW_blankNode_in_graphTerm1861);
                    $v=$this->blankNode();

                    $this->state->_fsp--;

                      $value=$v;

                    }
                    break;
                case 6 :
                    // Erfurt_Sparql_Sparql10.g:345:7: OPEN_BRACE ( WS )* CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_graphTerm1871); 
                    // Erfurt_Sparql_Sparql10.g:345:18: ( WS )* 
                    //loop53:
                    do {
                        $alt53=2;
                        $LA53_0 = $this->input->LA(1);

                        if ( ($LA53_0==$this->getToken('WS')) ) {
                            $alt53=1;
                        }


                        switch ($alt53) {
                    	case 1 :
                    	    // Erfurt_Sparql_Sparql10.g:345:18: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_graphTerm1873); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop53;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_graphTerm1876); 
                      $value=new Erfurt_Sparql_Query2_Nil();

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
        
        return $value;
    }
    // $ANTLR end "graphTerm"


    // $ANTLR start "expression"
    // Erfurt_Sparql_Sparql10.g:349:1: expression returns [$value] : conditionalOrExpression ; 
    public function expression(){
        $value = null;

        $conditionalOrExpression40 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:350:5: ( conditionalOrExpression ) 
            // Erfurt_Sparql_Sparql10.g:350:7: conditionalOrExpression 
            {
            $this->pushFollow(self::$FOLLOW_conditionalOrExpression_in_expression1901);
            $conditionalOrExpression40=$this->conditionalOrExpression();

            $this->state->_fsp--;

              $value = $conditionalOrExpression40;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "expression"


    // $ANTLR start "conditionalOrExpression"
    // Erfurt_Sparql_Sparql10.g:354:1: conditionalOrExpression returns [$value] : c1= conditionalAndExpression ( OR c2= conditionalAndExpression )* ; 
    public function conditionalOrExpression(){
        $value = null;

        $c1 = null;

        $c2 = null;


        $v = array();
        try {
            // Erfurt_Sparql_Sparql10.g:357:5: (c1= conditionalAndExpression ( OR c2= conditionalAndExpression )* ) 
            // Erfurt_Sparql_Sparql10.g:357:7: c1= conditionalAndExpression ( OR c2= conditionalAndExpression )* 
            {
            $this->pushFollow(self::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1936);
            $c1=$this->conditionalAndExpression();

            $this->state->_fsp--;

              $v[]=$c1;
            // Erfurt_Sparql_Sparql10.g:358:5: ( OR c2= conditionalAndExpression )* 
            //loop55:
            do {
                $alt55=2;
                $LA55_0 = $this->input->LA(1);

                if ( ($LA55_0==$this->getToken('OR')) ) {
                    $alt55=1;
                }


                switch ($alt55) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:358:7: OR c2= conditionalAndExpression 
            	    {
            	    $this->match($this->input,$this->getToken('OR'),self::$FOLLOW_OR_in_conditionalOrExpression1946); 
            	    $this->pushFollow(self::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1950);
            	    $c2=$this->conditionalAndExpression();

            	    $this->state->_fsp--;

            	      $v[]=$c2;

            	    }
            	    break;

            	default :
            	    break 2;//loop55;
                }
            } while (true);


            }

              $value =  new Erfurt_Sparql_Query2_ConditionalOrExpression($v);
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "conditionalOrExpression"


    // $ANTLR start "conditionalAndExpression"
    // Erfurt_Sparql_Sparql10.g:362:1: conditionalAndExpression returns [$value] : v1= valueLogical ( AND v2= valueLogical )* ; 
    public function conditionalAndExpression(){
        $value = null;

        $v1 = null;

        $v2 = null;


        $v = array();
        try {
            // Erfurt_Sparql_Sparql10.g:365:5: (v1= valueLogical ( AND v2= valueLogical )* ) 
            // Erfurt_Sparql_Sparql10.g:365:7: v1= valueLogical ( AND v2= valueLogical )* 
            {
            $this->pushFollow(self::$FOLLOW_valueLogical_in_conditionalAndExpression1987);
            $v1=$this->valueLogical();

            $this->state->_fsp--;

              $v[] = $v1;
            // Erfurt_Sparql_Sparql10.g:365:44: ( AND v2= valueLogical )* 
            //loop56:
            do {
                $alt56=2;
                $LA56_0 = $this->input->LA(1);

                if ( ($LA56_0==$this->getToken('AND')) ) {
                    $alt56=1;
                }


                switch ($alt56) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:365:46: AND v2= valueLogical 
            	    {
            	    $this->match($this->input,$this->getToken('AND'),self::$FOLLOW_AND_in_conditionalAndExpression1993); 
            	    $this->pushFollow(self::$FOLLOW_valueLogical_in_conditionalAndExpression1997);
            	    $v2=$this->valueLogical();

            	    $this->state->_fsp--;

            	      $v[]=$v2;

            	    }
            	    break;

            	default :
            	    break 2;//loop56;
                }
            } while (true);


            }

              $value = new Erfurt_Sparql_Query2_ConditionalAndExpression($v);
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "conditionalAndExpression"


    // $ANTLR start "valueLogical"
    // Erfurt_Sparql_Sparql10.g:369:1: valueLogical returns [$value] : relationalExpression ; 
    public function valueLogical(){
        $value = null;

        $relationalExpression41 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:370:5: ( relationalExpression ) 
            // Erfurt_Sparql_Sparql10.g:370:7: relationalExpression 
            {
            $this->pushFollow(self::$FOLLOW_relationalExpression_in_valueLogical2025);
            $relationalExpression41=$this->relationalExpression();

            $this->state->_fsp--;

              $value = $relationalExpression41;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "valueLogical"


    // $ANTLR start "relationalExpression"
    // Erfurt_Sparql_Sparql10.g:374:1: relationalExpression returns [$value] : n1= numericExpression ( EQUAL n2= numericExpression | NOT_EQUAL n2= numericExpression | LESS n2= numericExpression | GREATER n2= numericExpression | LESS_EQUAL n2= numericExpression | GREATER_EQUAL n2= numericExpression )? ; 
    public function relationalExpression(){
        $value = null;

        $n1 = null;

        $n2 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:375:5: (n1= numericExpression ( EQUAL n2= numericExpression | NOT_EQUAL n2= numericExpression | LESS n2= numericExpression | GREATER n2= numericExpression | LESS_EQUAL n2= numericExpression | GREATER_EQUAL n2= numericExpression )? ) 
            // Erfurt_Sparql_Sparql10.g:375:7: n1= numericExpression ( EQUAL n2= numericExpression | NOT_EQUAL n2= numericExpression | LESS n2= numericExpression | GREATER n2= numericExpression | LESS_EQUAL n2= numericExpression | GREATER_EQUAL n2= numericExpression )? 
            {
            $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression2052);
            $n1=$this->numericExpression();

            $this->state->_fsp--;

              $value = $n1;
            // Erfurt_Sparql_Sparql10.g:376:9: ( EQUAL n2= numericExpression | NOT_EQUAL n2= numericExpression | LESS n2= numericExpression | GREATER n2= numericExpression | LESS_EQUAL n2= numericExpression | GREATER_EQUAL n2= numericExpression )? 
            $alt57=7;
            $LA57 = $this->input->LA(1);
            if($this->getToken('EQUAL')== $LA57)
                {
                $alt57=1;
                }
            else if($this->getToken('NOT_EQUAL')== $LA57)
                {
                $alt57=2;
                }
            else if($this->getToken('LESS')== $LA57)
                {
                $alt57=3;
                }
            else if($this->getToken('GREATER')== $LA57)
                {
                $alt57=4;
                }
            else if($this->getToken('LESS_EQUAL')== $LA57)
                {
                $alt57=5;
                }
            else if($this->getToken('GREATER_EQUAL')== $LA57)
                {
                $alt57=6;
                }

            switch ($alt57) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:376:11: EQUAL n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('EQUAL'),self::$FOLLOW_EQUAL_in_relationalExpression2066); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression2070);
                    $n2=$this->numericExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_Equals($n1, $n2);

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:377:11: NOT_EQUAL n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('NOT_EQUAL'),self::$FOLLOW_NOT_EQUAL_in_relationalExpression2084); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression2088);
                    $n2=$this->numericExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_NotEquals($n1, $n2);

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:378:11: LESS n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('LESS'),self::$FOLLOW_LESS_in_relationalExpression2102); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression2106);
                    $n2=$this->numericExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_Smaller($n1, $n2);

                    }
                    break;
                case 4 :
                    // Erfurt_Sparql_Sparql10.g:379:11: GREATER n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('GREATER'),self::$FOLLOW_GREATER_in_relationalExpression2120); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression2124);
                    $n2=$this->numericExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_Larger($n1, $n2);

                    }
                    break;
                case 5 :
                    // Erfurt_Sparql_Sparql10.g:380:11: LESS_EQUAL n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('LESS_EQUAL'),self::$FOLLOW_LESS_EQUAL_in_relationalExpression2138); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression2142);
                    $n2=$this->numericExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_SmallerEqual($n1, $n2);

                    }
                    break;
                case 6 :
                    // Erfurt_Sparql_Sparql10.g:381:11: GREATER_EQUAL n2= numericExpression 
                    {
                    $this->match($this->input,$this->getToken('GREATER_EQUAL'),self::$FOLLOW_GREATER_EQUAL_in_relationalExpression2156); 
                    $this->pushFollow(self::$FOLLOW_numericExpression_in_relationalExpression2160);
                    $n2=$this->numericExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_LargerEqual($n1, $n2);

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
        
        return $value;
    }
    // $ANTLR end "relationalExpression"


    // $ANTLR start "numericExpression"
    // Erfurt_Sparql_Sparql10.g:386:1: numericExpression returns [$value] : additiveExpression ; 
    public function numericExpression(){
        $value = null;

        $additiveExpression42 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:387:5: ( additiveExpression ) 
            // Erfurt_Sparql_Sparql10.g:387:7: additiveExpression 
            {
            $this->pushFollow(self::$FOLLOW_additiveExpression_in_numericExpression2195);
            $additiveExpression42=$this->additiveExpression();

            $this->state->_fsp--;

              $value = $additiveExpression42;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "numericExpression"


    // $ANTLR start "additiveExpression"
    // Erfurt_Sparql_Sparql10.g:391:1: additiveExpression returns [$value] : m1= multiplicativeExpression ( (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) )* ; 
    public function additiveExpression(){
        $value = null;

        $op=null;
        $m1 = null;

        $m2 = null;

        $n = null;


        $value = new Erfurt_Sparql_Query2_AdditiveExpression(); $op=null; $v2=null;
        try {
            // Erfurt_Sparql_Sparql10.g:393:5: (m1= multiplicativeExpression ( (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) )* ) 
            // Erfurt_Sparql_Sparql10.g:393:7: m1= multiplicativeExpression ( (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) )* 
            {
            $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression2226);
            $m1=$this->multiplicativeExpression();

            $this->state->_fsp--;

              $value->addElement('+', $m1);
            // Erfurt_Sparql_Sparql10.g:394:9: ( (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) )* 
            //loop59:
            do {
                $alt59=2;
                $LA59_0 = $this->input->LA(1);

                if ( ($LA59_0==$this->getToken('MINUS')||($LA59_0>=$this->getToken('PLUS') && $LA59_0<=$this->getToken('DOUBLE_NEGATIVE'))) ) {
                    $alt59=1;
                }


                switch ($alt59) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:394:10: (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) 
            	    {
            	    // Erfurt_Sparql_Sparql10.g:394:10: (op= PLUS m2= multiplicativeExpression | op= MINUS m2= multiplicativeExpression | n= numericLiteralPositive | n= numericLiteralNegative ) 
            	    $alt58=4;
            	    $LA58 = $this->input->LA(1);
            	    if($this->getToken('PLUS')== $LA58)
            	        {
            	        $alt58=1;
            	        }
            	    else if($this->getToken('MINUS')== $LA58)
            	        {
            	        $alt58=2;
            	        }
            	    else if($this->getToken('INTEGER_POSITIVE')== $LA58||$this->getToken('DECIMAL_POSITIVE')== $LA58||$this->getToken('DOUBLE_POSITIVE')== $LA58)
            	        {
            	        $alt58=3;
            	        }
            	    else if($this->getToken('INTEGER_NEGATIVE')== $LA58||$this->getToken('DECIMAL_NEGATIVE')== $LA58||$this->getToken('DOUBLE_NEGATIVE')== $LA58)
            	        {
            	        $alt58=4;
            	        }
            	    else{
            	        $nvae =
            	            new NoViableAltException("", 58, 0, $this->input);

            	        throw $nvae;
            	    }

            	    switch ($alt58) {
            	        case 1 :
            	            // Erfurt_Sparql_Sparql10.g:394:12: op= PLUS m2= multiplicativeExpression 
            	            {
            	            $op=$this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_additiveExpression2243); 
            	            $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression2247);
            	            $m2=$this->multiplicativeExpression();

            	            $this->state->_fsp--;

            	              $op=($op!=null?$op->getText():null); $v2=$m2;

            	            }
            	            break;
            	        case 2 :
            	            // Erfurt_Sparql_Sparql10.g:395:11: op= MINUS m2= multiplicativeExpression 
            	            {
            	            $op=$this->match($this->input,$this->getToken('MINUS'),self::$FOLLOW_MINUS_in_additiveExpression2263); 
            	            $this->pushFollow(self::$FOLLOW_multiplicativeExpression_in_additiveExpression2267);
            	            $m2=$this->multiplicativeExpression();

            	            $this->state->_fsp--;

            	              $op=($op!=null?$op->getText():null); $v2=$m2;

            	            }
            	            break;
            	        case 3 :
            	            // Erfurt_Sparql_Sparql10.g:396:11: n= numericLiteralPositive 
            	            {
            	            $this->pushFollow(self::$FOLLOW_numericLiteralPositive_in_additiveExpression2283);
            	            $n=$this->numericLiteralPositive();

            	            $this->state->_fsp--;

            	              $op='+'; $v2=$n;

            	            }
            	            break;
            	        case 4 :
            	            // Erfurt_Sparql_Sparql10.g:397:11: n= numericLiteralNegative 
            	            {
            	            $this->pushFollow(self::$FOLLOW_numericLiteralNegative_in_additiveExpression2299);
            	            $n=$this->numericLiteralNegative();

            	            $this->state->_fsp--;

            	              $op='-'; $v2=$n;

            	            }
            	            break;

            	    }

            	      $value->addElement($op, $v2);

            	    }
            	    break;

            	default :
            	    break 2;//loop59;
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
        
        return $value;
    }
    // $ANTLR end "additiveExpression"


    // $ANTLR start "multiplicativeExpression"
    // Erfurt_Sparql_Sparql10.g:402:1: multiplicativeExpression returns [$value] : u1= unaryExpression ( (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) )* ; 
    public function multiplicativeExpression(){
        $value = null;

        $op=null;
        $u1 = null;

        $u2 = null;


        $value=new Erfurt_Sparql_Query2_MultiplicativeExpression();
        try {
            // Erfurt_Sparql_Sparql10.g:404:5: (u1= unaryExpression ( (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) )* ) 
            // Erfurt_Sparql_Sparql10.g:404:7: u1= unaryExpression ( (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) )* 
            {
            $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression2347);
            $u1=$this->unaryExpression();

            $this->state->_fsp--;

              $value->addElement('*', $u1);
            // Erfurt_Sparql_Sparql10.g:405:9: ( (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) )* 
            //loop61:
            do {
                $alt61=2;
                $LA61_0 = $this->input->LA(1);

                if ( ($LA61_0==$this->getToken('ASTERISK')||$LA61_0==$this->getToken('DIVIDE')) ) {
                    $alt61=1;
                }


                switch ($alt61) {
            	case 1 :
            	    // Erfurt_Sparql_Sparql10.g:405:10: (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) 
            	    {
            	    // Erfurt_Sparql_Sparql10.g:405:10: (op= ASTERISK u2= unaryExpression | op= DIVIDE u2= unaryExpression ) 
            	    $alt60=2;
            	    $LA60_0 = $this->input->LA(1);

            	    if ( ($LA60_0==$this->getToken('ASTERISK')) ) {
            	        $alt60=1;
            	    }
            	    else if ( ($LA60_0==$this->getToken('DIVIDE')) ) {
            	        $alt60=2;
            	    }
            	    else {
            	        $nvae = new NoViableAltException("", 60, 0, $this->input);

            	        throw $nvae;
            	    }
            	    switch ($alt60) {
            	        case 1 :
            	            // Erfurt_Sparql_Sparql10.g:405:12: op= ASTERISK u2= unaryExpression 
            	            {
            	            $op=$this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_multiplicativeExpression2364); 
            	            $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression2368);
            	            $u2=$this->unaryExpression();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 2 :
            	            // Erfurt_Sparql_Sparql10.g:405:45: op= DIVIDE u2= unaryExpression 
            	            {
            	            $op=$this->match($this->input,$this->getToken('DIVIDE'),self::$FOLLOW_DIVIDE_in_multiplicativeExpression2374); 
            	            $this->pushFollow(self::$FOLLOW_unaryExpression_in_multiplicativeExpression2378);
            	            $u2=$this->unaryExpression();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }

            	      $value->addElement(($op!=null?$op->getText():null), $u2);

            	    }
            	    break;

            	default :
            	    break 2;//loop61;
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
        
        return $value;
    }
    // $ANTLR end "multiplicativeExpression"


    // $ANTLR start "unaryExpression"
    // Erfurt_Sparql_Sparql10.g:409:1: unaryExpression returns [$value] : ( NOT_SIGN e= primaryExpression | PLUS e= primaryExpression | MINUS e= primaryExpression | e= primaryExpression ); 
    public function unaryExpression(){
        $value = null;

        $e = null;


        try {
            // Erfurt_Sparql_Sparql10.g:410:5: ( NOT_SIGN e= primaryExpression | PLUS e= primaryExpression | MINUS e= primaryExpression | e= primaryExpression ) 
            $alt62=4;
            $LA62 = $this->input->LA(1);
            if($this->getToken('NOT_SIGN')== $LA62)
                {
                $alt62=1;
                }
            else if($this->getToken('PLUS')== $LA62)
                {
                $alt62=2;
                }
            else if($this->getToken('MINUS')== $LA62)
                {
                $alt62=3;
                }
            else if($this->getToken('STR')== $LA62||$this->getToken('LANG')== $LA62||$this->getToken('LANGMATCHES')== $LA62||$this->getToken('DATATYPE')== $LA62||$this->getToken('BOUND')== $LA62||$this->getToken('SAMETERM')== $LA62||$this->getToken('ISIRI')== $LA62||$this->getToken('ISURI')== $LA62||$this->getToken('ISBLANK')== $LA62||$this->getToken('ISLITERAL')== $LA62||$this->getToken('REGEX')== $LA62||$this->getToken('TRUE')== $LA62||$this->getToken('FALSE')== $LA62||$this->getToken('IRI_REF')== $LA62||$this->getToken('PNAME_NS')== $LA62||$this->getToken('PNAME_LN')== $LA62||$this->getToken('VAR1')== $LA62||$this->getToken('VAR2')== $LA62||$this->getToken('INTEGER')== $LA62||$this->getToken('DECIMAL')== $LA62||$this->getToken('DOUBLE')== $LA62||$this->getToken('INTEGER_POSITIVE')== $LA62||$this->getToken('DECIMAL_POSITIVE')== $LA62||$this->getToken('DOUBLE_POSITIVE')== $LA62||$this->getToken('INTEGER_NEGATIVE')== $LA62||$this->getToken('DECIMAL_NEGATIVE')== $LA62||$this->getToken('DOUBLE_NEGATIVE')== $LA62||$this->getToken('STRING_LITERAL1')== $LA62||$this->getToken('STRING_LITERAL2')== $LA62||$this->getToken('STRING_LITERAL_LONG1')== $LA62||$this->getToken('STRING_LITERAL_LONG2')== $LA62||$this->getToken('OPEN_BRACE')== $LA62)
                {
                $alt62=4;
                }
            else{
                $nvae =
                    new NoViableAltException("", 62, 0, $this->input);

                throw $nvae;
            }

            switch ($alt62) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:410:7: NOT_SIGN e= primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('NOT_SIGN'),self::$FOLLOW_NOT_SIGN_in_unaryExpression2406); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression2410);
                    $e=$this->primaryExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_UnaryExpressionNot($e);

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:411:7: PLUS e= primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_unaryExpression2420); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression2424);
                    $e=$this->primaryExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_UnaryExpressionPlus($e);

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:412:7: MINUS e= primaryExpression 
                    {
                    $this->match($this->input,$this->getToken('MINUS'),self::$FOLLOW_MINUS_in_unaryExpression2434); 
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression2438);
                    $e=$this->primaryExpression();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_UnaryExpressionMinus($e);

                    }
                    break;
                case 4 :
                    // Erfurt_Sparql_Sparql10.g:413:7: e= primaryExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_primaryExpression_in_unaryExpression2450);
                    $e=$this->primaryExpression();

                    $this->state->_fsp--;

                      $value = $e;

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
        
        return $value;
    }
    // $ANTLR end "unaryExpression"


    // $ANTLR start "primaryExpression"
    // Erfurt_Sparql_Sparql10.g:417:1: primaryExpression returns [$value] : (v= brackettedExpression | v= builtInCall | v= iriRefOrFunction | v= rdfLiteral | v= numericLiteral | v= booleanLiteral | v= variable ); 
    public function primaryExpression(){
        $value = null;

        $v = null;


        try {
            // Erfurt_Sparql_Sparql10.g:419:5: (v= brackettedExpression | v= builtInCall | v= iriRefOrFunction | v= rdfLiteral | v= numericLiteral | v= booleanLiteral | v= variable ) 
            $alt63=7;
            $LA63 = $this->input->LA(1);
            if($this->getToken('OPEN_BRACE')== $LA63)
                {
                $alt63=1;
                }
            else if($this->getToken('STR')== $LA63||$this->getToken('LANG')== $LA63||$this->getToken('LANGMATCHES')== $LA63||$this->getToken('DATATYPE')== $LA63||$this->getToken('BOUND')== $LA63||$this->getToken('SAMETERM')== $LA63||$this->getToken('ISIRI')== $LA63||$this->getToken('ISURI')== $LA63||$this->getToken('ISBLANK')== $LA63||$this->getToken('ISLITERAL')== $LA63||$this->getToken('REGEX')== $LA63)
                {
                $alt63=2;
                }
            else if($this->getToken('IRI_REF')== $LA63||$this->getToken('PNAME_NS')== $LA63||$this->getToken('PNAME_LN')== $LA63)
                {
                $alt63=3;
                }
            else if($this->getToken('STRING_LITERAL1')== $LA63||$this->getToken('STRING_LITERAL2')== $LA63||$this->getToken('STRING_LITERAL_LONG1')== $LA63||$this->getToken('STRING_LITERAL_LONG2')== $LA63)
                {
                $alt63=4;
                }
            else if($this->getToken('INTEGER')== $LA63||$this->getToken('DECIMAL')== $LA63||$this->getToken('DOUBLE')== $LA63||$this->getToken('INTEGER_POSITIVE')== $LA63||$this->getToken('DECIMAL_POSITIVE')== $LA63||$this->getToken('DOUBLE_POSITIVE')== $LA63||$this->getToken('INTEGER_NEGATIVE')== $LA63||$this->getToken('DECIMAL_NEGATIVE')== $LA63||$this->getToken('DOUBLE_NEGATIVE')== $LA63)
                {
                $alt63=5;
                }
            else if($this->getToken('TRUE')== $LA63||$this->getToken('FALSE')== $LA63)
                {
                $alt63=6;
                }
            else if($this->getToken('VAR1')== $LA63||$this->getToken('VAR2')== $LA63)
                {
                $alt63=7;
                }
            else{
                $nvae =
                    new NoViableAltException("", 63, 0, $this->input);

                throw $nvae;
            }

            switch ($alt63) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:419:7: v= brackettedExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_brackettedExpression_in_primaryExpression2481);
                    $v=$this->brackettedExpression();

                    $this->state->_fsp--;

                      $v = $v;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:420:7: v= builtInCall 
                    {
                    $this->pushFollow(self::$FOLLOW_builtInCall_in_primaryExpression2493);
                    $v=$this->builtInCall();

                    $this->state->_fsp--;

                      $v = $v;

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:421:7: v= iriRefOrFunction 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRefOrFunction_in_primaryExpression2505);
                    $v=$this->iriRefOrFunction();

                    $this->state->_fsp--;

                      $v = $v;

                    }
                    break;
                case 4 :
                    // Erfurt_Sparql_Sparql10.g:422:7: v= rdfLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_rdfLiteral_in_primaryExpression2517);
                    $v=$this->rdfLiteral();

                    $this->state->_fsp--;

                      $v = $v;

                    }
                    break;
                case 5 :
                    // Erfurt_Sparql_Sparql10.g:423:7: v= numericLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteral_in_primaryExpression2529);
                    $v=$this->numericLiteral();

                    $this->state->_fsp--;

                      $v = $v;

                    }
                    break;
                case 6 :
                    // Erfurt_Sparql_Sparql10.g:424:7: v= booleanLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_booleanLiteral_in_primaryExpression2541);
                    $v=$this->booleanLiteral();

                    $this->state->_fsp--;

                      $v = $v;

                    }
                    break;
                case 7 :
                    // Erfurt_Sparql_Sparql10.g:425:7: v= variable 
                    {
                    $this->pushFollow(self::$FOLLOW_variable_in_primaryExpression2553);
                    $v=$this->variable();

                    $this->state->_fsp--;

                      $v = $v;

                    }
                    break;

            }
              $value = $v;
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "primaryExpression"


    // $ANTLR start "brackettedExpression"
    // Erfurt_Sparql_Sparql10.g:429:1: brackettedExpression returns [$value] : OPEN_BRACE e= expression CLOSE_BRACE ; 
    public function brackettedExpression(){
        $value = null;

        $e = null;


        try {
            // Erfurt_Sparql_Sparql10.g:430:5: ( OPEN_BRACE e= expression CLOSE_BRACE ) 
            // Erfurt_Sparql_Sparql10.g:430:7: OPEN_BRACE e= expression CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_brackettedExpression2578); 
            $this->pushFollow(self::$FOLLOW_expression_in_brackettedExpression2582);
            $e=$this->expression();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_brackettedExpression2584); 
              $value = new Erfurt_Sparql_Query2_BrackettedExpression($e);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "brackettedExpression"


    // $ANTLR start "builtInCall"
    // Erfurt_Sparql_Sparql10.g:434:1: builtInCall returns [$value] : ( STR OPEN_BRACE e= expression CLOSE_BRACE | LANG OPEN_BRACE e= expression CLOSE_BRACE | LANGMATCHES OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE | DATATYPE OPEN_BRACE e= expression CLOSE_BRACE | BOUND OPEN_BRACE variable CLOSE_BRACE | SAMETERM OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE | ISIRI OPEN_BRACE e= expression CLOSE_BRACE | ISURI OPEN_BRACE e= expression CLOSE_BRACE | ISBLANK OPEN_BRACE e= expression CLOSE_BRACE | ISLITERAL OPEN_BRACE e= expression CLOSE_BRACE | regexExpression ); 
    public function builtInCall(){
        $value = null;

        $e = null;

        $e1 = null;

        $e2 = null;

        $variable43 = null;

        $regexExpression44 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:435:5: ( STR OPEN_BRACE e= expression CLOSE_BRACE | LANG OPEN_BRACE e= expression CLOSE_BRACE | LANGMATCHES OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE | DATATYPE OPEN_BRACE e= expression CLOSE_BRACE | BOUND OPEN_BRACE variable CLOSE_BRACE | SAMETERM OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE | ISIRI OPEN_BRACE e= expression CLOSE_BRACE | ISURI OPEN_BRACE e= expression CLOSE_BRACE | ISBLANK OPEN_BRACE e= expression CLOSE_BRACE | ISLITERAL OPEN_BRACE e= expression CLOSE_BRACE | regexExpression ) 
            $alt64=11;
            $LA64 = $this->input->LA(1);
            if($this->getToken('STR')== $LA64)
                {
                $alt64=1;
                }
            else if($this->getToken('LANG')== $LA64)
                {
                $alt64=2;
                }
            else if($this->getToken('LANGMATCHES')== $LA64)
                {
                $alt64=3;
                }
            else if($this->getToken('DATATYPE')== $LA64)
                {
                $alt64=4;
                }
            else if($this->getToken('BOUND')== $LA64)
                {
                $alt64=5;
                }
            else if($this->getToken('SAMETERM')== $LA64)
                {
                $alt64=6;
                }
            else if($this->getToken('ISIRI')== $LA64)
                {
                $alt64=7;
                }
            else if($this->getToken('ISURI')== $LA64)
                {
                $alt64=8;
                }
            else if($this->getToken('ISBLANK')== $LA64)
                {
                $alt64=9;
                }
            else if($this->getToken('ISLITERAL')== $LA64)
                {
                $alt64=10;
                }
            else if($this->getToken('REGEX')== $LA64)
                {
                $alt64=11;
                }
            else{
                $nvae =
                    new NoViableAltException("", 64, 0, $this->input);

                throw $nvae;
            }

            switch ($alt64) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:435:7: STR OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('STR'),self::$FOLLOW_STR_in_builtInCall2609); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2611); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2615);
                    $e=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2617); 
                      $value = new Erfurt_Sparql_Query2_Str($e);

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:436:7: LANG OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('LANG'),self::$FOLLOW_LANG_in_builtInCall2627); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2629); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2633);
                    $e=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2635); 
                      $value = new Erfurt_Sparql_Query2_Lang($e);

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:437:7: LANGMATCHES OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('LANGMATCHES'),self::$FOLLOW_LANGMATCHES_in_builtInCall2645); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2647); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2651);
                    $e1=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall2653); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2657);
                    $e2=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2659); 
                      $value = new Erfurt_Sparql_Query2_LangMatches($e1, $e2);

                    }
                    break;
                case 4 :
                    // Erfurt_Sparql_Sparql10.g:438:7: DATATYPE OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('DATATYPE'),self::$FOLLOW_DATATYPE_in_builtInCall2669); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2671); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2675);
                    $e=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2677); 
                      $value = new Erfurt_Sparql_Query2_Datatype($e);

                    }
                    break;
                case 5 :
                    // Erfurt_Sparql_Sparql10.g:439:7: BOUND OPEN_BRACE variable CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('BOUND'),self::$FOLLOW_BOUND_in_builtInCall2687); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2689); 
                    $this->pushFollow(self::$FOLLOW_variable_in_builtInCall2691);
                    $variable43=$this->variable();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2693); 
                      $value = new Erfurt_Sparql_Query2_bound($variable43);

                    }
                    break;
                case 6 :
                    // Erfurt_Sparql_Sparql10.g:440:7: SAMETERM OPEN_BRACE e1= expression COMMA e2= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('SAMETERM'),self::$FOLLOW_SAMETERM_in_builtInCall2703); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2705); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2709);
                    $e1=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_builtInCall2711); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2715);
                    $e2=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2717); 
                      $value = new Erfurt_Sparql_Query2_sameTerm($e1, $e2);

                    }
                    break;
                case 7 :
                    // Erfurt_Sparql_Sparql10.g:441:7: ISIRI OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISIRI'),self::$FOLLOW_ISIRI_in_builtInCall2727); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2729); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2733);
                    $e=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2735); 
                      $value = new Erfurt_Sparql_Query2_isIri($e);

                    }
                    break;
                case 8 :
                    // Erfurt_Sparql_Sparql10.g:442:7: ISURI OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISURI'),self::$FOLLOW_ISURI_in_builtInCall2745); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2747); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2751);
                    $e=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2753); 
                      $value = new Erfurt_Sparql_Query2_isUri($e);

                    }
                    break;
                case 9 :
                    // Erfurt_Sparql_Sparql10.g:443:7: ISBLANK OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISBLANK'),self::$FOLLOW_ISBLANK_in_builtInCall2763); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2765); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2769);
                    $e=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2771); 
                      $value = new Erfurt_Sparql_Query2_isBlank($e);

                    }
                    break;
                case 10 :
                    // Erfurt_Sparql_Sparql10.g:444:7: ISLITERAL OPEN_BRACE e= expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ISLITERAL'),self::$FOLLOW_ISLITERAL_in_builtInCall2781); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_builtInCall2783); 
                    $this->pushFollow(self::$FOLLOW_expression_in_builtInCall2787);
                    $e=$this->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_builtInCall2789); 
                      $value = new Erfurt_Sparql_Query2_isLiteral($e);

                    }
                    break;
                case 11 :
                    // Erfurt_Sparql_Sparql10.g:445:7: regexExpression 
                    {
                    $this->pushFollow(self::$FOLLOW_regexExpression_in_builtInCall2799);
                    $regexExpression44=$this->regexExpression();

                    $this->state->_fsp--;

                      $value = $regexExpression44;

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
        
        return $value;
    }
    // $ANTLR end "builtInCall"


    // $ANTLR start "regexExpression"
    // Erfurt_Sparql_Sparql10.g:449:1: regexExpression returns [$value] : REGEX OPEN_BRACE e1= expression COMMA e2= expression ( COMMA e3= expression )? CLOSE_BRACE ; 
    public function regexExpression(){
        $value = null;

        $e1 = null;

        $e2 = null;

        $e3 = null;


        try {
            // Erfurt_Sparql_Sparql10.g:450:5: ( REGEX OPEN_BRACE e1= expression COMMA e2= expression ( COMMA e3= expression )? CLOSE_BRACE ) 
            // Erfurt_Sparql_Sparql10.g:450:7: REGEX OPEN_BRACE e1= expression COMMA e2= expression ( COMMA e3= expression )? CLOSE_BRACE 
            {
            $this->match($this->input,$this->getToken('REGEX'),self::$FOLLOW_REGEX_in_regexExpression2824); 
            $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_regexExpression2826); 
            $this->pushFollow(self::$FOLLOW_expression_in_regexExpression2830);
            $e1=$this->expression();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_regexExpression2832); 
            $this->pushFollow(self::$FOLLOW_expression_in_regexExpression2836);
            $e2=$this->expression();

            $this->state->_fsp--;

            // Erfurt_Sparql_Sparql10.g:450:58: ( COMMA e3= expression )? 
            $alt65=2;
            $LA65_0 = $this->input->LA(1);

            if ( ($LA65_0==$this->getToken('COMMA')) ) {
                $alt65=1;
            }
            switch ($alt65) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:450:60: COMMA e3= expression 
                    {
                    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_regexExpression2840); 
                    $this->pushFollow(self::$FOLLOW_expression_in_regexExpression2844);
                    $e3=$this->expression();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_regexExpression2849); 
              $value = new Erfurt_Sparql_Query2_Regex($e1, $e2, $e3);

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "regexExpression"


    // $ANTLR start "iriRefOrFunction"
    // Erfurt_Sparql_Sparql10.g:455:1: iriRefOrFunction returns [$value] : iriRef ( argList )? ; 
    public function iriRefOrFunction(){
        $value = null;

        $iriRef45 = null;

        $argList46 = null;


        $al = null;$i=null;
        try {
            // Erfurt_Sparql_Sparql10.g:462:5: ( iriRef ( argList )? ) 
            // Erfurt_Sparql_Sparql10.g:462:7: iriRef ( argList )? 
            {
            $this->pushFollow(self::$FOLLOW_iriRef_in_iriRefOrFunction2886);
            $iriRef45=$this->iriRef();

            $this->state->_fsp--;

              $i=$iriRef45;
            // Erfurt_Sparql_Sparql10.g:463:9: ( argList )? 
            $alt66=2;
            $LA66_0 = $this->input->LA(1);

            if ( ($LA66_0==$this->getToken('OPEN_BRACE')) ) {
                $alt66=1;
            }
            switch ($alt66) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:463:10: argList 
                    {
                    $this->pushFollow(self::$FOLLOW_argList_in_iriRefOrFunction2899);
                    $argList46=$this->argList();

                    $this->state->_fsp--;

                      $al = $argList46;

                    }
                    break;

            }


            }


              if(isset($al)){
                  $value = new Erfurt_Sparql_Query2_Function($i, $al);
              } else{$value = $i;}

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "iriRefOrFunction"


    // $ANTLR start "rdfLiteral"
    // Erfurt_Sparql_Sparql10.g:467:1: rdfLiteral returns [$value] : string ( LANGTAG | ( REFERENCE iriRef ) )? ; 
    public function rdfLiteral(){
        $value = null;

        $LANGTAG48=null;
        $string47 = null;

        $iriRef49 = null;


        require_once('Erfurt/Sparql/Query2/RDFLiteral.php');
        try {
            // Erfurt_Sparql_Sparql10.g:469:5: ( string ( LANGTAG | ( REFERENCE iriRef ) )? ) 
            // Erfurt_Sparql_Sparql10.g:469:7: string ( LANGTAG | ( REFERENCE iriRef ) )? 
            {
            $this->pushFollow(self::$FOLLOW_string_in_rdfLiteral2930);
            $string47=$this->string();

            $this->state->_fsp--;

              $value = new Erfurt_Sparql_Query2_RDFLiteral(($string47!=null?$this->input->toStringBetweenTokens($string47->start,$string47->stop):null));
            // Erfurt_Sparql_Sparql10.g:470:9: ( LANGTAG | ( REFERENCE iriRef ) )? 
            $alt67=3;
            $LA67_0 = $this->input->LA(1);

            if ( ($LA67_0==$this->getToken('LANGTAG')) ) {
                $alt67=1;
            }
            else if ( ($LA67_0==$this->getToken('REFERENCE')) ) {
                $alt67=2;
            }
            switch ($alt67) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:470:11: LANGTAG 
                    {
                    $LANGTAG48=$this->match($this->input,$this->getToken('LANGTAG'),self::$FOLLOW_LANGTAG_in_rdfLiteral2944); 
                      $value->setLanguageTag(($LANGTAG48!=null?$LANGTAG48->getText():null));

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:471:11: ( REFERENCE iriRef ) 
                    {
                    // Erfurt_Sparql_Sparql10.g:471:11: ( REFERENCE iriRef ) 
                    // Erfurt_Sparql_Sparql10.g:471:13: REFERENCE iriRef 
                    {
                    $this->match($this->input,$this->getToken('REFERENCE'),self::$FOLLOW_REFERENCE_in_rdfLiteral2961); 
                    $this->pushFollow(self::$FOLLOW_iriRef_in_rdfLiteral2963);
                    $iriRef49=$this->iriRef();

                    $this->state->_fsp--;

                      $value->setDatatype($iriRef49);

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
        
        return $value;
    }
    // $ANTLR end "rdfLiteral"


    // $ANTLR start "numericLiteral"
    // Erfurt_Sparql_Sparql10.g:475:1: numericLiteral returns [$value] : (n= numericLiteralUnsigned | n= numericLiteralPositive | n= numericLiteralNegative ) ; 
    public function numericLiteral(){
        $value = null;

        $n = null;


        try {
            // Erfurt_Sparql_Sparql10.g:476:5: ( (n= numericLiteralUnsigned | n= numericLiteralPositive | n= numericLiteralNegative ) ) 
            // Erfurt_Sparql_Sparql10.g:476:7: (n= numericLiteralUnsigned | n= numericLiteralPositive | n= numericLiteralNegative ) 
            {
            // Erfurt_Sparql_Sparql10.g:476:7: (n= numericLiteralUnsigned | n= numericLiteralPositive | n= numericLiteralNegative ) 
            $alt68=3;
            $LA68 = $this->input->LA(1);
            if($this->getToken('INTEGER')== $LA68||$this->getToken('DECIMAL')== $LA68||$this->getToken('DOUBLE')== $LA68)
                {
                $alt68=1;
                }
            else if($this->getToken('INTEGER_POSITIVE')== $LA68||$this->getToken('DECIMAL_POSITIVE')== $LA68||$this->getToken('DOUBLE_POSITIVE')== $LA68)
                {
                $alt68=2;
                }
            else if($this->getToken('INTEGER_NEGATIVE')== $LA68||$this->getToken('DECIMAL_NEGATIVE')== $LA68||$this->getToken('DOUBLE_NEGATIVE')== $LA68)
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
                    // Erfurt_Sparql_Sparql10.g:476:8: n= numericLiteralUnsigned 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralUnsigned_in_numericLiteral2996);
                    $n=$this->numericLiteralUnsigned();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:477:4: n= numericLiteralPositive 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralPositive_in_numericLiteral3003);
                    $n=$this->numericLiteralPositive();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:478:4: n= numericLiteralNegative 
                    {
                    $this->pushFollow(self::$FOLLOW_numericLiteralNegative_in_numericLiteral3010);
                    $n=$this->numericLiteralNegative();

                    $this->state->_fsp--;


                    }
                    break;

            }

              $value=$n;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "numericLiteral"


    // $ANTLR start "numericLiteralUnsigned"
    // Erfurt_Sparql_Sparql10.g:482:1: numericLiteralUnsigned returns [$value] : (v= INTEGER | v= DECIMAL | v= DOUBLE ); 
    public function numericLiteralUnsigned(){
        $value = null;

        $v=null;

        require_once('Erfurt/Sparql/Query2/NumericLiteral.php');
        try {
            // Erfurt_Sparql_Sparql10.g:484:5: (v= INTEGER | v= DECIMAL | v= DOUBLE ) 
            $alt69=3;
            $LA69 = $this->input->LA(1);
            if($this->getToken('INTEGER')== $LA69)
                {
                $alt69=1;
                }
            else if($this->getToken('DECIMAL')== $LA69)
                {
                $alt69=2;
                }
            else if($this->getToken('DOUBLE')== $LA69)
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
                    // Erfurt_Sparql_Sparql10.g:484:7: v= INTEGER 
                    {
                    $v=$this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_numericLiteralUnsigned3043); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((int)($v!=null?$v->getText():null));

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:485:7: v= DECIMAL 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL'),self::$FOLLOW_DECIMAL_in_numericLiteralUnsigned3055); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((float)($v!=null?$v->getText():null));

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:486:7: v= DOUBLE 
                    {
                    $v=$this->match($this->input,$this->getToken('DOUBLE'),self::$FOLLOW_DOUBLE_in_numericLiteralUnsigned3067); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((double)($v!=null?$v->getText():null));

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
        
        return $value;
    }
    // $ANTLR end "numericLiteralUnsigned"


    // $ANTLR start "numericLiteralPositive"
    // Erfurt_Sparql_Sparql10.g:490:1: numericLiteralPositive returns [$value] : (v= INTEGER_POSITIVE | v= DECIMAL_POSITIVE | v= DOUBLE_POSITIVE ); 
    public function numericLiteralPositive(){
        $value = null;

        $v=null;

        require_once('Erfurt/Sparql/Query2/NumericLiteral.php');
        try {
            // Erfurt_Sparql_Sparql10.g:492:5: (v= INTEGER_POSITIVE | v= DECIMAL_POSITIVE | v= DOUBLE_POSITIVE ) 
            $alt70=3;
            $LA70 = $this->input->LA(1);
            if($this->getToken('INTEGER_POSITIVE')== $LA70)
                {
                $alt70=1;
                }
            else if($this->getToken('DECIMAL_POSITIVE')== $LA70)
                {
                $alt70=2;
                }
            else if($this->getToken('DOUBLE_POSITIVE')== $LA70)
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
                    // Erfurt_Sparql_Sparql10.g:492:7: v= INTEGER_POSITIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('INTEGER_POSITIVE'),self::$FOLLOW_INTEGER_POSITIVE_in_numericLiteralPositive3098); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((int)($v!=null?$v->getText():null));

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:493:7: v= DECIMAL_POSITIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL_POSITIVE'),self::$FOLLOW_DECIMAL_POSITIVE_in_numericLiteralPositive3110); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((float)($v!=null?$v->getText():null));

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:494:7: v= DOUBLE_POSITIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('DOUBLE_POSITIVE'),self::$FOLLOW_DOUBLE_POSITIVE_in_numericLiteralPositive3122); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((double)($v!=null?$v->getText():null));

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
        
        return $value;
    }
    // $ANTLR end "numericLiteralPositive"


    // $ANTLR start "numericLiteralNegative"
    // Erfurt_Sparql_Sparql10.g:498:1: numericLiteralNegative returns [$value] : (v= INTEGER_NEGATIVE | v= DECIMAL_NEGATIVE | v= DOUBLE_NEGATIVE ); 
    public function numericLiteralNegative(){
        $value = null;

        $v=null;

        require_once('Erfurt/Sparql/Query2/NumericLiteral.php');
        try {
            // Erfurt_Sparql_Sparql10.g:500:5: (v= INTEGER_NEGATIVE | v= DECIMAL_NEGATIVE | v= DOUBLE_NEGATIVE ) 
            $alt71=3;
            $LA71 = $this->input->LA(1);
            if($this->getToken('INTEGER_NEGATIVE')== $LA71)
                {
                $alt71=1;
                }
            else if($this->getToken('DECIMAL_NEGATIVE')== $LA71)
                {
                $alt71=2;
                }
            else if($this->getToken('DOUBLE_NEGATIVE')== $LA71)
                {
                $alt71=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 71, 0, $this->input);

                throw $nvae;
            }

            switch ($alt71) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:500:7: v= INTEGER_NEGATIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('INTEGER_NEGATIVE'),self::$FOLLOW_INTEGER_NEGATIVE_in_numericLiteralNegative3153); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((int)($v!=null?$v->getText():null));

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:501:7: v= DECIMAL_NEGATIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL_NEGATIVE'),self::$FOLLOW_DECIMAL_NEGATIVE_in_numericLiteralNegative3165); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((float)($v!=null?$v->getText():null));

                    }
                    break;
                case 3 :
                    // Erfurt_Sparql_Sparql10.g:502:7: v= DOUBLE_NEGATIVE 
                    {
                    $v=$this->match($this->input,$this->getToken('DOUBLE_NEGATIVE'),self::$FOLLOW_DOUBLE_NEGATIVE_in_numericLiteralNegative3177); 
                      $value = new Erfurt_Sparql_Query2_NumericLiteral((double)($v!=null?$v->getText():null));

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
        
        return $value;
    }
    // $ANTLR end "numericLiteralNegative"


    // $ANTLR start "booleanLiteral"
    // Erfurt_Sparql_Sparql10.g:506:1: booleanLiteral returns [$value] : ( TRUE | FALSE ); 
    public function booleanLiteral(){
        $value = null;

        require_once 'Erfurt/Sparql/Query2/BooleanLiteral.php'; $v=null;
        try {
            // Erfurt_Sparql_Sparql10.g:509:5: ( TRUE | FALSE ) 
            $alt72=2;
            $LA72_0 = $this->input->LA(1);

            if ( ($LA72_0==$this->getToken('TRUE')) ) {
                $alt72=1;
            }
            else if ( ($LA72_0==$this->getToken('FALSE')) ) {
                $alt72=2;
            }
            else {
                $nvae = new NoViableAltException("", 72, 0, $this->input);

                throw $nvae;
            }
            switch ($alt72) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:509:7: TRUE 
                    {
                    $this->match($this->input,$this->getToken('TRUE'),self::$FOLLOW_TRUE_in_booleanLiteral3210); 
                      $v=1;

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:510:7: FALSE 
                    {
                    $this->match($this->input,$this->getToken('FALSE'),self::$FOLLOW_FALSE_in_booleanLiteral3220); 
                      $v=0;

                    }
                    break;

            }
              $value = new Erfurt_Sparql_Query2_BooleanLiteral((bool)$v);
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "booleanLiteral"

    public static function string_return() {
    	require_once 'ParserRuleReturnScope.php';
    /*    
    */
    	return new ParserRuleReturnScope();
    }

    // $ANTLR start "string"
    // Erfurt_Sparql_Sparql10.g:514:1: string : ( STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 ); 
    public function string(){
        $retval = $this->string_return();
        $retval->start = $this->input->LT(1);

        try {
            // Erfurt_Sparql_Sparql10.g:515:5: ( STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 ) 
            // Erfurt_Sparql_Sparql10.g: 
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

            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $retval;
    }
    // $ANTLR end "string"


    // $ANTLR start "iriRef"
    // Erfurt_Sparql_Sparql10.g:522:1: iriRef returns [$value] : ( IRI_REF | prefixedName ); 
    public function iriRef(){
        $value = null;

        $IRI_REF50=null;
        $prefixedName51 = null;


        require_once 'Erfurt/Sparql/Query2/IriRef.php';
        try {
            // Erfurt_Sparql_Sparql10.g:524:5: ( IRI_REF | prefixedName ) 
            $alt73=2;
            $LA73_0 = $this->input->LA(1);

            if ( ($LA73_0==$this->getToken('IRI_REF')) ) {
                $alt73=1;
            }
            else if ( ($LA73_0==$this->getToken('PNAME_NS')||$LA73_0==$this->getToken('PNAME_LN')) ) {
                $alt73=2;
            }
            else {
                $nvae = new NoViableAltException("", 73, 0, $this->input);

                throw $nvae;
            }
            switch ($alt73) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:524:7: IRI_REF 
                    {
                    $IRI_REF50=$this->match($this->input,$this->getToken('IRI_REF'),self::$FOLLOW_IRI_REF_in_iriRef3292); 
                      $value = new Erfurt_Sparql_Query2_IriRef(($IRI_REF50!=null?$IRI_REF50->getText():null));

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:525:7: prefixedName 
                    {
                    $this->pushFollow(self::$FOLLOW_prefixedName_in_iriRef3302);
                    $prefixedName51=$this->prefixedName();

                    $this->state->_fsp--;

                      $value = new Erfurt_Sparql_Query2_IriRef(($prefixedName51!=null?$this->input->toStringBetweenTokens($prefixedName51->start,$prefixedName51->stop):null));

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
        
        return $value;
    }
    // $ANTLR end "iriRef"

    public static function prefixedName_return() {
    	require_once 'ParserRuleReturnScope.php';
    /*    
    */
    	return new ParserRuleReturnScope();
    }

    // $ANTLR start "prefixedName"
    // Erfurt_Sparql_Sparql10.g:529:1: prefixedName : ( PNAME_LN | PNAME_NS ); 
    public function prefixedName(){
        $retval = $this->prefixedName_return();
        $retval->start = $this->input->LT(1);

        try {
            // Erfurt_Sparql_Sparql10.g:530:5: ( PNAME_LN | PNAME_NS ) 
            // Erfurt_Sparql_Sparql10.g: 
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

            $retval->stop = $this->input->LT(-1);

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $retval;
    }
    // $ANTLR end "prefixedName"


    // $ANTLR start "blankNode"
    // Erfurt_Sparql_Sparql10.g:535:1: blankNode returns [$value] : (v= BLANK_NODE_LABEL | OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE ); 
    public function blankNode(){
        $value = null;

        $v=null;

        require_once 'Erfurt/Sparql/Query2/BlankNode.php'; $v=null;
        try {
            // Erfurt_Sparql_Sparql10.g:538:5: (v= BLANK_NODE_LABEL | OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE ) 
            $alt75=2;
            $LA75_0 = $this->input->LA(1);

            if ( ($LA75_0==$this->getToken('BLANK_NODE_LABEL')) ) {
                $alt75=1;
            }
            else if ( ($LA75_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt75=2;
            }
            else {
                $nvae = new NoViableAltException("", 75, 0, $this->input);

                throw $nvae;
            }
            switch ($alt75) {
                case 1 :
                    // Erfurt_Sparql_Sparql10.g:538:7: v= BLANK_NODE_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('BLANK_NODE_LABEL'),self::$FOLLOW_BLANK_NODE_LABEL_in_blankNode3364); 
                      $v = ($v!=null?$v->getText():null);

                    }
                    break;
                case 2 :
                    // Erfurt_Sparql_Sparql10.g:539:7: OPEN_SQUARE_BRACE ( WS )* CLOSE_SQUARE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNode3374); 
                    // Erfurt_Sparql_Sparql10.g:539:25: ( WS )* 
                    //loop74:
                    do {
                        $alt74=2;
                        $LA74_0 = $this->input->LA(1);

                        if ( ($LA74_0==$this->getToken('WS')) ) {
                            $alt74=1;
                        }


                        switch ($alt74) {
                    	case 1 :
                    	    // Erfurt_Sparql_Sparql10.g:539:26: WS 
                    	    {
                    	    $this->match($this->input,$this->getToken('WS'),self::$FOLLOW_WS_in_blankNode3377); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop74;
                        }
                    } while (true);

                    $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode3381); 
                      $v='';

                    }
                    break;

            }
              $value = new Erfurt_Sparql_Query2_BlankNode($v);
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            throw $e;
        }
        
        return $value;
    }
    // $ANTLR end "blankNode"

    // Delegated rules


    
}

 



Erfurt_Sparql_Sparql10Parser::$FOLLOW_117_in_fakestart56 = new Set(array(4, 5, 19, 22, 23, 24));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_start_in_fakestart58 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_prologue_in_start82 = new Set(array(4, 5, 19, 22, 23, 24));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_selectQuery_in_start95 = new Set(array());
Erfurt_Sparql_Sparql10Parser::$FOLLOW_constructQuery_in_start107 = new Set(array());
Erfurt_Sparql_Sparql10Parser::$FOLLOW_describeQuery_in_start120 = new Set(array());
Erfurt_Sparql_Sparql10Parser::$FOLLOW_askQuery_in_start133 = new Set(array());
Erfurt_Sparql_Sparql10Parser::$FOLLOW_EOF_in_start146 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_baseDecl_in_prologue167 = new Set(array(1, 5));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_prefixDecl_in_prologue170 = new Set(array(1, 5));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_BASE_in_baseDecl190 = new Set(array(66, 68, 70));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRef_in_baseDecl192 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_PREFIX_in_prefixDecl217 = new Set(array(68));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_PNAME_NS_in_prefixDecl219 = new Set(array(66, 68, 70));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRef_in_prefixDecl221 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_SELECT_in_selectQuery242 = new Set(array(20, 21, 72, 73, 105));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DISTINCT_in_selectQuery246 = new Set(array(72, 73, 105));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_REDUCED_in_selectQuery260 = new Set(array(72, 73, 105));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_variable_in_selectQuery277 = new Set(array(25, 27, 64, 72, 73));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ASTERISK_in_selectQuery282 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_datasetClause_in_selectQuery286 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_whereClause_in_selectQuery289 = new Set(array(28, 34, 35));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_solutionModifier_in_selectQuery291 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CONSTRUCT_in_constructQuery311 = new Set(array(64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_constructTemplate_in_constructQuery313 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_datasetClause_in_constructQuery315 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_whereClause_in_constructQuery318 = new Set(array(28, 34, 35));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_solutionModifier_in_constructQuery320 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DESCRIBE_in_describeQuery339 = new Set(array(66, 68, 70, 72, 73, 105));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_varOrIRIref_in_describeQuery343 = new Set(array(25, 27, 28, 34, 35, 64, 66, 68, 70, 72, 73));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ASTERISK_in_describeQuery348 = new Set(array(25, 27, 28, 34, 35, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_datasetClause_in_describeQuery352 = new Set(array(25, 27, 28, 34, 35, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_whereClause_in_describeQuery355 = new Set(array(28, 34, 35));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_solutionModifier_in_describeQuery358 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ASK_in_askQuery377 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_datasetClause_in_askQuery379 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_whereClause_in_askQuery382 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_FROM_in_datasetClause403 = new Set(array(26, 66, 68, 70));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_defaultGraphClause_in_datasetClause407 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_namedGraphClause_in_datasetClause421 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_sourceSelector_in_defaultGraphClause456 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_NAMED_in_namedGraphClause481 = new Set(array(66, 68, 70));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_sourceSelector_in_namedGraphClause483 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRef_in_sourceSelector508 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_WHERE_in_whereClause529 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_groupGraphPattern_in_whereClause532 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_orderClause_in_solutionModifier553 = new Set(array(1, 34, 35));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_limitOffsetClauses_in_solutionModifier556 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_limitClause_in_limitOffsetClauses575 = new Set(array(1, 34, 35));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_offsetClause_in_limitOffsetClauses577 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_offsetClause_in_limitOffsetClauses587 = new Set(array(1, 34));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_limitClause_in_limitOffsetClauses589 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ORDER_in_orderClause609 = new Set(array(31));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_BY_in_orderClause611 = new Set(array(32, 33, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 66, 68, 70, 72, 73, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_orderCondition_in_orderClause613 = new Set(array(1, 32, 33, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 66, 68, 70, 72, 73, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ASC_in_orderCondition639 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DESC_in_orderCondition645 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_brackettedExpression_in_orderCondition649 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_constraint_in_orderCondition665 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_variable_in_orderCondition671 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_LIMIT_in_limitClause693 = new Set(array(76));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_INTEGER_in_limitClause695 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OFFSET_in_offsetClause716 = new Set(array(76));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_INTEGER_in_offsetClause718 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_CURLY_BRACE_in_groupGraphPattern744 = new Set(array(25, 27, 36, 37, 39, 58, 59, 64, 65, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_triplesBlock_in_groupGraphPattern749 = new Set(array(25, 27, 36, 37, 39, 64, 65));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_graphPatternNotTriples_in_groupGraphPattern762 = new Set(array(25, 27, 36, 37, 39, 58, 59, 64, 65, 66, 68, 70, 72, 73, 76, 77, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_filter_in_groupGraphPattern768 = new Set(array(25, 27, 36, 37, 39, 58, 59, 64, 65, 66, 68, 70, 72, 73, 76, 77, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DOT_in_groupGraphPattern786 = new Set(array(25, 27, 36, 37, 39, 58, 59, 64, 65, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_triplesBlock_in_groupGraphPattern792 = new Set(array(25, 27, 36, 37, 39, 64, 65));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_CURLY_BRACE_in_groupGraphPattern801 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_triplesSameSubject_in_triplesBlock828 = new Set(array(1, 77));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DOT_in_triplesBlock834 = new Set(array(1, 58, 59, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_triplesBlock_in_triplesBlock839 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_optionalGraphPattern_in_graphPatternNotTriples876 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_groupOrUnionGraphPattern_in_graphPatternNotTriples888 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_graphGraphPattern_in_graphPatternNotTriples900 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPTIONAL_in_optionalGraphPattern929 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_groupGraphPattern_in_optionalGraphPattern931 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_GRAPH_in_graphGraphPattern960 = new Set(array(66, 68, 70, 72, 73));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_varOrIRIref_in_graphGraphPattern962 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_groupGraphPattern_in_graphGraphPattern964 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern995 = new Set(array(1, 38));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_UNION_in_groupOrUnionGraphPattern1001 = new Set(array(25, 27, 64));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_groupGraphPattern_in_groupOrUnionGraphPattern1005 = new Set(array(1, 38));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_FILTER_in_filter1037 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 66, 68, 70, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_constraint_in_filter1039 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_brackettedExpression_in_constraint1070 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_builtInCall_in_constraint1080 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_functionCall_in_constraint1090 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRef_in_functionCall1112 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_argList_in_functionCall1114 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_argList1143 = new Set(array(95, 111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_WS_in_argList1145 = new Set(array(95, 111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_argList1148 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_argList1156 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_argList1160 = new Set(array(106, 111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_COMMA_in_argList1174 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_argList1178 = new Set(array(106, 111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_argList1184 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_CURLY_BRACE_in_constructTemplate1211 = new Set(array(58, 59, 65, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_constructTriples_in_constructTemplate1214 = new Set(array(65));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_CURLY_BRACE_in_constructTemplate1220 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_triplesSameSubject_in_constructTriples1247 = new Set(array(1, 77));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DOT_in_constructTriples1253 = new Set(array(1, 58, 59, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_constructTriples_in_constructTriples1258 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_varOrTerm_in_triplesSameSubject1292 = new Set(array(40, 66, 68, 70, 72, 73));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_propertyListNotEmpty_in_triplesSameSubject1294 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_triplesNode_in_triplesSameSubject1304 = new Set(array(40, 66, 68, 70, 72, 73));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_propertyList_in_triplesSameSubject1306 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_verb_in_propertyListNotEmpty1337 = new Set(array(58, 59, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_objectList_in_propertyListNotEmpty1341 = new Set(array(1, 104));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_SEMICOLON_in_propertyListNotEmpty1355 = new Set(array(1, 40, 66, 68, 70, 72, 73, 104));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_verb_in_propertyListNotEmpty1361 = new Set(array(58, 59, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_objectList_in_propertyListNotEmpty1365 = new Set(array(1, 104));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_propertyListNotEmpty_in_propertyList1404 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_object_in_objectList1437 = new Set(array(1, 106));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_COMMA_in_objectList1451 = new Set(array(58, 59, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_object_in_objectList1455 = new Set(array(1, 106));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_graphNode_in_object1483 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_varOrIRIref_in_verb1512 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_A_in_verb1522 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_collection_in_triplesNode1547 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_blankNodePropertyList_in_triplesNode1557 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNodePropertyList1586 = new Set(array(40, 66, 68, 70, 72, 73));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_propertyListNotEmpty_in_blankNodePropertyList1588 = new Set(array(116));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNodePropertyList1590 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_collection1623 = new Set(array(58, 59, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_graphNode_in_collection1626 = new Set(array(58, 59, 66, 68, 70, 72, 73, 76, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 99, 110, 111, 115));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_collection1632 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_varOrTerm_in_graphNode1655 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_triplesNode_in_graphNode1665 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_variable_in_varOrTerm1690 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_graphTerm_in_varOrTerm1700 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_variable_in_varOrIRIref1725 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRef_in_varOrIRIref1735 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_VAR1_in_variable1770 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_VAR2_in_variable1782 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRef_in_graphTerm1813 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_rdfLiteral_in_graphTerm1825 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericLiteral_in_graphTerm1837 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_booleanLiteral_in_graphTerm1849 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_blankNode_in_graphTerm1861 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_graphTerm1871 = new Set(array(95, 111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_WS_in_graphTerm1873 = new Set(array(95, 111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_graphTerm1876 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_conditionalOrExpression_in_expression1901 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1936 = new Set(array(1, 102));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OR_in_conditionalOrExpression1946 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_conditionalAndExpression_in_conditionalOrExpression1950 = new Set(array(1, 102));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_valueLogical_in_conditionalAndExpression1987 = new Set(array(1, 101));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_AND_in_conditionalAndExpression1993 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_valueLogical_in_conditionalAndExpression1997 = new Set(array(1, 101));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_relationalExpression_in_valueLogical2025 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericExpression_in_relationalExpression2052 = new Set(array(1, 62, 63, 109, 112, 113, 114));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_EQUAL_in_relationalExpression2066 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericExpression_in_relationalExpression2070 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_NOT_EQUAL_in_relationalExpression2084 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericExpression_in_relationalExpression2088 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_LESS_in_relationalExpression2102 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericExpression_in_relationalExpression2106 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_GREATER_in_relationalExpression2120 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericExpression_in_relationalExpression2124 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_LESS_EQUAL_in_relationalExpression2138 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericExpression_in_relationalExpression2142 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_GREATER_EQUAL_in_relationalExpression2156 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericExpression_in_relationalExpression2160 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_additiveExpression_in_numericExpression2195 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_multiplicativeExpression_in_additiveExpression2226 = new Set(array(1, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_PLUS_in_additiveExpression2243 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_multiplicativeExpression_in_additiveExpression2247 = new Set(array(1, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_MINUS_in_additiveExpression2263 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_multiplicativeExpression_in_additiveExpression2267 = new Set(array(1, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericLiteralPositive_in_additiveExpression2283 = new Set(array(1, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericLiteralNegative_in_additiveExpression2299 = new Set(array(1, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_unaryExpression_in_multiplicativeExpression2347 = new Set(array(1, 105, 108));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ASTERISK_in_multiplicativeExpression2364 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_unaryExpression_in_multiplicativeExpression2368 = new Set(array(1, 105, 108));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DIVIDE_in_multiplicativeExpression2374 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_unaryExpression_in_multiplicativeExpression2378 = new Set(array(1, 105, 108));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_NOT_SIGN_in_unaryExpression2406 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_primaryExpression_in_unaryExpression2410 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_PLUS_in_unaryExpression2420 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_primaryExpression_in_unaryExpression2424 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_MINUS_in_unaryExpression2434 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_primaryExpression_in_unaryExpression2438 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_primaryExpression_in_unaryExpression2450 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_brackettedExpression_in_primaryExpression2481 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_builtInCall_in_primaryExpression2493 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRefOrFunction_in_primaryExpression2505 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_rdfLiteral_in_primaryExpression2517 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericLiteral_in_primaryExpression2529 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_booleanLiteral_in_primaryExpression2541 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_variable_in_primaryExpression2553 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_brackettedExpression2578 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_brackettedExpression2582 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_brackettedExpression2584 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_STR_in_builtInCall2609 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2611 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2615 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2617 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_LANG_in_builtInCall2627 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2629 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2633 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2635 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_LANGMATCHES_in_builtInCall2645 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2647 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2651 = new Set(array(106));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_COMMA_in_builtInCall2653 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2657 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2659 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DATATYPE_in_builtInCall2669 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2671 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2675 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2677 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_BOUND_in_builtInCall2687 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2689 = new Set(array(72, 73));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_variable_in_builtInCall2691 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2693 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_SAMETERM_in_builtInCall2703 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2705 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2709 = new Set(array(106));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_COMMA_in_builtInCall2711 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2715 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2717 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ISIRI_in_builtInCall2727 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2729 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2733 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2735 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ISURI_in_builtInCall2745 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2747 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2751 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2753 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ISBLANK_in_builtInCall2763 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2765 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2769 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2771 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_ISLITERAL_in_builtInCall2781 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_builtInCall2783 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_builtInCall2787 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_builtInCall2789 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_regexExpression_in_builtInCall2799 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_REGEX_in_regexExpression2824 = new Set(array(110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_BRACE_in_regexExpression2826 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_regexExpression2830 = new Set(array(106));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_COMMA_in_regexExpression2832 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_regexExpression2836 = new Set(array(106, 111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_COMMA_in_regexExpression2840 = new Set(array(42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 58, 59, 66, 68, 70, 72, 73, 74, 76, 78, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93, 107, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_expression_in_regexExpression2844 = new Set(array(111));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_BRACE_in_regexExpression2849 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRef_in_iriRefOrFunction2886 = new Set(array(1, 110));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_argList_in_iriRefOrFunction2899 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_string_in_rdfLiteral2930 = new Set(array(1, 75, 100));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_LANGTAG_in_rdfLiteral2944 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_REFERENCE_in_rdfLiteral2961 = new Set(array(66, 68, 70));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_iriRef_in_rdfLiteral2963 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericLiteralUnsigned_in_numericLiteral2996 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericLiteralPositive_in_numericLiteral3003 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_numericLiteralNegative_in_numericLiteral3010 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_INTEGER_in_numericLiteralUnsigned3043 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DECIMAL_in_numericLiteralUnsigned3055 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DOUBLE_in_numericLiteralUnsigned3067 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_INTEGER_POSITIVE_in_numericLiteralPositive3098 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DECIMAL_POSITIVE_in_numericLiteralPositive3110 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DOUBLE_POSITIVE_in_numericLiteralPositive3122 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_INTEGER_NEGATIVE_in_numericLiteralNegative3153 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DECIMAL_NEGATIVE_in_numericLiteralNegative3165 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_DOUBLE_NEGATIVE_in_numericLiteralNegative3177 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_TRUE_in_booleanLiteral3210 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_FALSE_in_booleanLiteral3220 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_set_in_string0 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_IRI_REF_in_iriRef3292 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_prefixedName_in_iriRef3302 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_set_in_prefixedName0 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_BLANK_NODE_LABEL_in_blankNode3364 = new Set(array(1));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_OPEN_SQUARE_BRACE_in_blankNode3374 = new Set(array(95, 116));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_WS_in_blankNode3377 = new Set(array(95, 116));
Erfurt_Sparql_Sparql10Parser::$FOLLOW_CLOSE_SQUARE_BRACE_in_blankNode3381 = new Set(array(1));

?>