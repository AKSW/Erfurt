<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g 2010-03-22 22:31:42


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class Erfurt_Sparql_Parser_Sparql11_QueryParser extends AntlrParser {
    public static $tokenNames = array(
        "<invalid>", "<EOR>", "<DOWN>", "<UP>", "DATA", "MODIFY", "DELETE", "INSERT", "INTO", "LOAD", "CLEAR", "CREATE", "SILENT", "DROP", "EXISTS", "UNSAID", "HAVING", "COUNT", "COALESCE", "DEFINE", "IF", "BASE", "PREFIX", "NOT", "SELECT", "DISTINCT", "REDUCED", "CONSTRUCT", "DESCRIBE", "ASK", "FROM", "NAMED", "WHERE", "ORDER", "GROUP", "BY", "ASC", "DESC", "LIMIT", "OFFSET", "OPTIONAL", "GRAPH", "UNION", "FILTER", "A", "AS", "STR", "LANG", "LANGMATCHES", "DATATYPE", "BOUND", "SAMETERM", "ISIRI", "ISURI", "ISBLANK", "ISLITERAL", "REGEX", "TRUE", "FALSE", "LESS", "GREATER", "OPEN_CURLY_BRACE", "CLOSE_CURLY_BRACE", "IRI_REF", "PN_PREFIX", "PNAME_NS", "PN_LOCAL", "PNAME_LN", "VARNAME", "VAR1", "VAR2", "MINUS", "LANGTAG", "INTEGER", "DOT", "DECIMAL", "DIGIT", "EXPONENT", "DOUBLE", "PLUS", "INTEGER_POSITIVE", "DECIMAL_POSITIVE", "DOUBLE_POSITIVE", "INTEGER_NEGATIVE", "DECIMAL_NEGATIVE", "DOUBLE_NEGATIVE", "ECHAR", "STRING_LITERAL1", "STRING_LITERAL2", "STRING_LITERAL_LONG1", "STRING_LITERAL_LONG2", "EOL", "WS", "PN_CHARS_BASE", "PN_CHARS_U", "PN_CHARS", "BLANK_NODE_LABEL", "REFERENCE", "AND", "OR", "COMMENT", "SEMICOLON", "ASTERISK", "COMMA", "NOT_SIGN", "DIVIDE", "EQUAL", "OPEN_BRACE", "CLOSE_BRACE", "LESS_EQUAL", "GREATER_EQUAL", "NOT_EQUAL", "OPEN_SQUARE_BRACE", "CLOSE_SQUARE_BRACE", "HAT_LABEL", "QUESTION_MARK_LABEL"
    );
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
    public $gSparql11query;
    // delegators

    
    static $FOLLOW_query11_in_parse37;
    static $FOLLOW_EOF_in_parse39;

    
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
            $this->gSparql11query = new Erfurt_Sparql_Parser_Sparql11_Query_Sparql11query($input, $state, $this);         
            
            
        }
        

    public function getTokenNames() { return Erfurt_Sparql_Parser_Sparql11_QueryParser::$tokenNames; }
    public function getGrammarFileName() { return "/Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g"; }



    // $ANTLR start "parse"
    // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g:9:1: parse : query11 EOF ; 
    public function parse(){
        try {
            // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g:10:3: ( query11 EOF ) 
            // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Query.g:11:3: query11 EOF 
            {
            $this->pushFollow(self::$FOLLOW_query11_in_parse37);
            $this->query11();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('EOF'),self::$FOLLOW_EOF_in_parse39); 

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
    // $ANTLR end "parse"

    // Delegated rules
    public function groupOrUnionGraphPattern() { $this->gSparql11query->groupOrUnionGraphPattern(); }
    public function limitOffsetClauses() { $this->gSparql11query->limitOffsetClauses(); }
    public function verb() { $this->gSparql11query->verb(); }
    public function relationalExpression() { $this->gSparql11query->relationalExpression(); }
    public function orderClause() { $this->gSparql11query->orderClause(); }
    public function baseDecl() { $this->gSparql11query->baseDecl(); }
    public function unaryExpression() { $this->gSparql11query->unaryExpression(); }
    public function string() { $this->gSparql11query->string(); }
    public function whereClause() { $this->gSparql11query->whereClause(); }
    public function brackettedExpression() { $this->gSparql11query->brackettedExpression(); }
    public function filter() { $this->gSparql11query->filter(); }
    public function groupGraphPatternSub() { $this->gSparql11query->groupGraphPatternSub(); }
    public function blankNodePropertyList() { $this->gSparql11query->blankNodePropertyList(); }
    public function conditionalOrExpression() { $this->gSparql11query->conditionalOrExpression(); }
    public function numericLiteral() { $this->gSparql11query->numericLiteral(); }
    public function solutionModifier() { $this->gSparql11query->solutionModifier(); }
    public function sourceSelector() { $this->gSparql11query->sourceSelector(); }
    public function numericLiteralUnsigned() { $this->gSparql11query->numericLiteralUnsigned(); }
    public function object() { $this->gSparql11query->object(); }
    public function expression() { $this->gSparql11query->expression(); }
    public function numericExpression() { $this->gSparql11query->numericExpression(); }
    public function triplesBlock() { $this->gSparql11query->triplesBlock(); }
    public function iriRef() { $this->gSparql11query->iriRef(); }
    public function booleanLiteral() { $this->gSparql11query->booleanLiteral(); }
    public function constructTemplate() { $this->gSparql11query->constructTemplate(); }
    public function defaultGraphClause() { $this->gSparql11query->defaultGraphClause(); }
    public function constraint() { $this->gSparql11query->constraint(); }
    public function prefixedName() { $this->gSparql11query->prefixedName(); }
    public function graphNode() { $this->gSparql11query->graphNode(); }
    public function objectList() { $this->gSparql11query->objectList(); }
    public function prefixDecl() { $this->gSparql11query->prefixDecl(); }
    public function prologue() { $this->gSparql11query->prologue(); }
    public function datasetClause() { $this->gSparql11query->datasetClause(); }
    public function collection() { $this->gSparql11query->collection(); }
    public function describeQuery() { $this->gSparql11query->describeQuery(); }
    public function subSelect() { $this->gSparql11query->subSelect(); }
    public function offsetClause() { $this->gSparql11query->offsetClause(); }
    public function variable() { $this->gSparql11query->variable(); }
    public function primaryExpression() { $this->gSparql11query->primaryExpression(); }
    public function iriRefOrFunction() { $this->gSparql11query->iriRefOrFunction(); }
    public function selectQuery() { $this->gSparql11query->selectQuery(); }
    public function builtInCall() { $this->gSparql11query->builtInCall(); }
    public function constructQuery() { $this->gSparql11query->constructQuery(); }
    public function additiveExpression() { $this->gSparql11query->additiveExpression(); }
    public function blankNode() { $this->gSparql11query->blankNode(); }
    public function numericLiteralPositive() { $this->gSparql11query->numericLiteralPositive(); }
    public function varOrIRIref() { $this->gSparql11query->varOrIRIref(); }
    public function graphGraphPattern() { $this->gSparql11query->graphGraphPattern(); }
    public function regexExpression() { $this->gSparql11query->regexExpression(); }
    public function optionalGraphPattern() { $this->gSparql11query->optionalGraphPattern(); }
    public function query11() { $this->gSparql11query->query11(); }
    public function graphTerm() { $this->gSparql11query->graphTerm(); }
    public function project() { $this->gSparql11query->project(); }
    public function functionCall() { $this->gSparql11query->functionCall(); }
    public function orderCondition() { $this->gSparql11query->orderCondition(); }
    public function valueLogical() { $this->gSparql11query->valueLogical(); }
    public function namedGraphClause() { $this->gSparql11query->namedGraphClause(); }
    public function triplesNode() { $this->gSparql11query->triplesNode(); }
    public function limitClause() { $this->gSparql11query->limitClause(); }
    public function graphPatternNotTriples() { $this->gSparql11query->graphPatternNotTriples(); }
    public function rdfLiteral() { $this->gSparql11query->rdfLiteral(); }
    public function constructTriples() { $this->gSparql11query->constructTriples(); }
    public function askQuery() { $this->gSparql11query->askQuery(); }
    public function argList() { $this->gSparql11query->argList(); }
    public function conditionalAndExpression() { $this->gSparql11query->conditionalAndExpression(); }
    public function propertyList() { $this->gSparql11query->propertyList(); }
    public function groupGraphPattern() { $this->gSparql11query->groupGraphPattern(); }
    public function numericLiteralNegative() { $this->gSparql11query->numericLiteralNegative(); }
    public function triplesSameSubject() { $this->gSparql11query->triplesSameSubject(); }
    public function multiplicativeExpression() { $this->gSparql11query->multiplicativeExpression(); }
    public function propertyListNotEmpty() { $this->gSparql11query->propertyListNotEmpty(); }
    public function varOrTerm() { $this->gSparql11query->varOrTerm(); }


    
}

 



Erfurt_Sparql_Parser_Sparql11_QueryParser::$FOLLOW_query11_in_parse37 = new Set(array());
Erfurt_Sparql_Parser_Sparql11_QueryParser::$FOLLOW_EOF_in_parse39 = new Set(array(1));

?>