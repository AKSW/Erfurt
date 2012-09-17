<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Update.g 2010-03-22 22:31:15


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class Erfurt_Sparql_Parser_Sparql11_UpdateParser extends AntlrParser {
    public static $tokenNames = array(
        "<invalid>", "<EOR>", "<DOWN>", "<UP>", "DATA", "MODIFY", "DELETE", "INSERT", "INTO", "LOAD", "CLEAR", "CREATE", "SILENT", "DROP", "EXISTS", "UNSAID", "HAVING", "COUNT", "COALESCE", "DEFINE", "IF", "BASE", "PREFIX", "NOT", "SELECT", "DISTINCT", "REDUCED", "CONSTRUCT", "DESCRIBE", "ASK", "FROM", "NAMED", "WHERE", "ORDER", "GROUP", "BY", "ASC", "DESC", "LIMIT", "OFFSET", "OPTIONAL", "GRAPH", "UNION", "FILTER", "A", "AS", "STR", "LANG", "LANGMATCHES", "DATATYPE", "BOUND", "SAMETERM", "ISIRI", "ISURI", "ISBLANK", "ISLITERAL", "REGEX", "TRUE", "FALSE", "LESS", "GREATER", "OPEN_CURLY_BRACE", "CLOSE_CURLY_BRACE", "IRI_REF", "PN_PREFIX", "PNAME_NS", "PN_LOCAL", "PNAME_LN", "VARNAME", "VAR1", "VAR2", "MINUS", "LANGTAG", "INTEGER", "DOT", "DECIMAL", "DIGIT", "EXPONENT", "DOUBLE", "PLUS", "INTEGER_POSITIVE", "DECIMAL_POSITIVE", "DOUBLE_POSITIVE", "INTEGER_NEGATIVE", "DECIMAL_NEGATIVE", "DOUBLE_NEGATIVE", "ECHAR", "STRING_LITERAL1", "STRING_LITERAL2", "STRING_LITERAL_LONG1", "STRING_LITERAL_LONG2", "EOL", "WS", "PN_CHARS_BASE", "PN_CHARS_U", "PN_CHARS", "BLANK_NODE_LABEL", "REFERENCE", "AND", "OR", "COMMENT", "SEMICOLON", "ASTERISK", "COMMA", "NOT_SIGN", "DIVIDE", "EQUAL", "OPEN_BRACE", "CLOSE_BRACE", "LESS_EQUAL", "GREATER_EQUAL", "NOT_EQUAL", "OPEN_SQUARE_BRACE", "CLOSE_SQUARE_BRACE", "HAT_LABEL", "QUESTION_MARK_LABEL", "SUM", "MIN", "MAX", "AVG"
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
    public $gSparql10;
    public $gSparql11update;
    // delegators

    
    static $FOLLOW_updateUnit_in_parse39;
    static $FOLLOW_EOF_in_parse41;

    
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
            $this->gSparql10 = new Erfurt_Sparql_Parser_Sparql11_Update_Sparql10($input, $state, $this);
            $this->gSparql11update = new Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update($input, $state, $this);         
            
            
        }
        

    public function getTokenNames() { return Erfurt_Sparql_Parser_Sparql11_UpdateParser::$tokenNames; }
    public function getGrammarFileName() { return "/Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Update.g"; }



    // $ANTLR start "parse"
    // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Update.g:8:1: parse : updateUnit EOF ; 
    public function parse(){
        try {
            // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Update.g:9:3: ( updateUnit EOF ) 
            // /Users/roll/Documents/workspace/SparqlGrammar/src/Erfurt_Sparql_Parser_Sparql11_Update.g:10:3: updateUnit EOF 
            {
            $this->pushFollow(self::$FOLLOW_updateUnit_in_parse39);
            $this->updateUnit();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('EOF'),self::$FOLLOW_EOF_in_parse41); 

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
    public function graphGraphPattern() { return $this->gSparql10->graphGraphPattern(); }
    public function path() { $this->gSparql11update->path(); }
    public function load() { $this->gSparql11update->load(); }
    public function pathMod() { $this->gSparql11update->pathMod(); }
    public function propertyListNotEmptyPath() { $this->gSparql11update->propertyListNotEmptyPath(); }
    public function offsetClause() { $this->gSparql10->offsetClause(); }
    public function delete() { $this->gSparql11update->delete(); }
    public function insertTemplate() { $this->gSparql11update->insertTemplate(); }
    public function update() { $this->gSparql11update->update(); }
    public function blankNode() { return $this->gSparql10->blankNode(); }
    public function objectList() { return $this->gSparql10->objectList(); }
    public function propertyListNotEmpty() { return $this->gSparql10->propertyListNotEmpty(); }
    public function collection() { return $this->gSparql10->collection(); }
    public function updateUnit() { $this->gSparql11update->updateUnit(); }
    public function prefixDecl() { $this->gSparql10->prefixDecl(); }
    public function updatePattern() { $this->gSparql11update->updatePattern(); }
    public function baseDecl() { $this->gSparql10->baseDecl(); }
    public function constructTriples() { return $this->gSparql10->constructTriples(); }
    public function conditionalAndExpression() { return $this->gSparql10->conditionalAndExpression(); }
    public function filter() { return $this->gSparql10->filter(); }
    public function booleanLiteral() { return $this->gSparql10->booleanLiteral(); }
    public function varOrIRIref() { return $this->gSparql10->varOrIRIref(); }
    public function brackettedExpression() { return $this->gSparql10->brackettedExpression(); }
    public function triplesBlock() { return $this->gSparql10->triplesBlock(); }
    public function numericExpression() { return $this->gSparql10->numericExpression(); }
    public function constraint() { return $this->gSparql10->constraint(); }
    public function graphPatternNotTriples() { return $this->gSparql10->graphPatternNotTriples(); }
    public function regexExpression() { return $this->gSparql10->regexExpression(); }
    public function askQuery() { $this->gSparql10->askQuery(); }
    public function graphIri() { $this->gSparql11update->graphIri(); }
    public function additiveExpression() { return $this->gSparql10->additiveExpression(); }
    public function pathUnit() { $this->gSparql11update->pathUnit(); }
    public function numericLiteralPositive() { return $this->gSparql10->numericLiteralPositive(); }
    public function selectQuery() { $this->gSparql10->selectQuery(); }
    public function orderCondition() { $this->gSparql10->orderCondition(); }
    public function variable() { return $this->gSparql10->variable(); }
    public function solutionModifier() { $this->gSparql10->solutionModifier(); }
    public function varOrTerm() { return $this->gSparql10->varOrTerm(); }
    public function orderClause() { $this->gSparql10->orderClause(); }
    public function groupGraphPattern() { return $this->gSparql10->groupGraphPattern(); }
    public function functionCall() { return $this->gSparql10->functionCall(); }
    public function propertyList() { return $this->gSparql10->propertyList(); }
    public function argList() { return $this->gSparql10->argList(); }
    public function triplesSameSubjectPath() { $this->gSparql11update->triplesSameSubjectPath(); }
    public function sourceSelector() { return $this->gSparql10->sourceSelector(); }
    public function describeQuery() { $this->gSparql10->describeQuery(); }
    public function pathPrimary() { $this->gSparql11update->pathPrimary(); }
    public function pathEltOrReverse() { $this->gSparql11update->pathEltOrReverse(); }
    public function triplesSameSubject() { return $this->gSparql10->triplesSameSubject(); }
    public function groupOrUnionGraphPattern() { return $this->gSparql10->groupOrUnionGraphPattern(); }
    public function datasetClause() { $this->gSparql10->datasetClause(); }
    public function propertyListPath() { $this->gSparql11update->propertyListPath(); }
    public function verb() { return $this->gSparql10->verb(); }
    public function pathAlternative() { $this->gSparql11update->pathAlternative(); }
    public function pathElt() { $this->gSparql11update->pathElt(); }
    public function primaryExpression() { return $this->gSparql10->primaryExpression(); }
    public function rdfLiteral() { return $this->gSparql10->rdfLiteral(); }
    public function graphTerm() { return $this->gSparql10->graphTerm(); }
    public function whereClause() { $this->gSparql10->whereClause(); }
    public function numericLiteral() { return $this->gSparql10->numericLiteral(); }
    public function query10() { return $this->gSparql10->query10(); }
    public function limitOffsetClauses() { $this->gSparql10->limitOffsetClauses(); }
    public function relationalExpression() { return $this->gSparql10->relationalExpression(); }
    public function drop() { $this->gSparql11update->drop(); }
    public function object() { return $this->gSparql10->object(); }
    public function insert() { $this->gSparql11update->insert(); }
    public function multiplicativeExpression() { return $this->gSparql10->multiplicativeExpression(); }
    public function manage() { $this->gSparql11update->manage(); }
    public function optionalGraphPattern() { return $this->gSparql10->optionalGraphPattern(); }
    public function aggregate() { $this->gSparql11update->aggregate(); }
    public function groupGraphPatternSub() { $this->gSparql11update->groupGraphPatternSub(); }
    public function unaryExpression() { return $this->gSparql10->unaryExpression(); }
    public function iriRefOrFunction() { return $this->gSparql10->iriRefOrFunction(); }
    public function deleteData() { $this->gSparql11update->deleteData(); }
    public function iriRef() { return $this->gSparql10->iriRef(); }
    public function verbSimple() { $this->gSparql11update->verbSimple(); }
    public function valueLogical() { return $this->gSparql10->valueLogical(); }
    public function blankNodePropertyList() { return $this->gSparql10->blankNodePropertyList(); }
    public function modify() { $this->gSparql11update->modify(); }
    public function prologue() { $this->gSparql10->prologue(); }
    public function expression() { return $this->gSparql10->expression(); }
    public function create() { $this->gSparql11update->create(); }
    public function existsFunc() { $this->gSparql11update->existsFunc(); }
    public function pathSequence() { $this->gSparql11update->pathSequence(); }
    public function limitClause() { $this->gSparql10->limitClause(); }
    public function defaultGraphClause() { return $this->gSparql10->defaultGraphClause(); }
    public function notExistsFunc() { $this->gSparql11update->notExistsFunc(); }
    public function conditionalOrExpression() { return $this->gSparql10->conditionalOrExpression(); }
    public function namedGraphClause() { return $this->gSparql10->namedGraphClause(); }
    public function triplesNode() { return $this->gSparql10->triplesNode(); }
    public function clear() { $this->gSparql11update->clear(); }
    public function constructTemplate() { return $this->gSparql10->constructTemplate(); }
    public function prefixedName() { return $this->gSparql10->prefixedName(); }
    public function constructQuery() { $this->gSparql10->constructQuery(); }
    public function graphNode() { return $this->gSparql10->graphNode(); }
    public function numericLiteralUnsigned() { return $this->gSparql10->numericLiteralUnsigned(); }
    public function deleteTemplate() { $this->gSparql11update->deleteTemplate(); }
    public function insertData() { $this->gSparql11update->insertData(); }
    public function verbPath() { $this->gSparql11update->verbPath(); }
    public function numericLiteralNegative() { return $this->gSparql10->numericLiteralNegative(); }
    public function string() { return $this->gSparql10->string(); }
    public function builtInCall() { return $this->gSparql10->builtInCall(); }


    
}

 



Erfurt_Sparql_Parser_Sparql11_UpdateParser::$FOLLOW_updateUnit_in_parse39 = new Set(array());
Erfurt_Sparql_Parser_Sparql11_UpdateParser::$FOLLOW_EOF_in_parse41 = new Set(array(1));

?>