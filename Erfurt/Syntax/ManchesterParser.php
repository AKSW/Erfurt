<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 src/Erfurt_Syntax_Manchester.g 2011-03-11 19:30:42


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class Erfurt_Syntax_ManchesterParser extends AntlrParser {
    public static $tokenNames = array(
        "<invalid>", "<EOR>", "<DOWN>", "<UP>", "F_LABEL", "LENGTH_LABEL", "MIN_LENGTH_LABEL", "MAX_LENGTH_LABEL", "PATTERN_LABEL", "LANG_PATTERN_LABEL", "THAT_LABEL", "INVERSE_LABEL", "MINUS", "DOT", "PLUS", "DIGITS", "NOT_LABEL", "EOL", "WS", "LESS_EQUAL", "GREATER_EQUAL", "LESS", "GREATER", "OPEN_CURLY_BRACE", "CLOSE_CURLY_BRACE", "OR_LABEL", "AND_LABEL", "SOME_LABEL", "ONLY_LABEL", "VALUE_LABEL", "SELF_LABEL", "MIN_LABEL", "MAX_LABEL", "EXACTLY_LABEL", "COMMA", "OPEN_BRACE", "CLOSE_BRACE", "DECIMAL_LABEL", "FLOAT_LABEL", "INTEGER_LABEL", "STRING_LABEL", "REFERENCE", "SUBCLASS_OF_LABEL", "CLASS_LABEL", "PN_CHARS", "PN_PREFIX", "PN_CHARS_BASE", "PN_CHARS_U", "FULL_IRI", "SIMPLE_IRI", "NODE_ID", "OPEN_SQUARE_BRACE", "CLOSE_SQUARE_BRACE", "ECHAR", "QUOTED_STRING", "LANGUAGE_TAG", "EXPONENT", "PREFIX_NAME", "ABBREVIATED_IRI", "ILITERAL_HELPER", "DLITERAL_HELPER", "FPLITERAL_HELPER", "ITFUCKINDOESNTWORK"
    );
    public $MAX_LENGTH_LABEL=7;
    public $EXPONENT=56;
    public $CLOSE_SQUARE_BRACE=52;
    public $DECIMAL_LABEL=37;
    public $ONLY_LABEL=28;
    public $DIGITS=15;
    public $MAX_LABEL=32;
    public $FPLITERAL_HELPER=61;
    public $SUBCLASS_OF_LABEL=42;
    public $EOF=-1;
    public $STRING_LABEL=40;
    public $LANG_PATTERN_LABEL=9;
    public $FLOAT_LABEL=38;
    public $ABBREVIATED_IRI=58;
    public $INVERSE_LABEL=11;
    public $EOL=17;
    public $GREATER=22;
    public $INTEGER_LABEL=39;
    public $F_LABEL=4;
    public $OR_LABEL=25;
    public $COMMA=34;
    public $LESS=21;
    public $PN_CHARS_U=47;
    public $QUOTED_STRING=54;
    public $PLUS=14;
    public $DOT=13;
    public $DLITERAL_HELPER=60;
    public $OPEN_CURLY_BRACE=23;
    public $CLOSE_CURLY_BRACE=24;
    public $PATTERN_LABEL=8;
    public $SIMPLE_IRI=49;
    public $PREFIX_NAME=57;
    public $AND_LABEL=26;
    public $REFERENCE=41;
    public $FULL_IRI=48;
    public $CLOSE_BRACE=36;
    public $ILITERAL_HELPER=59;
    public $MINUS=12;
    public $LENGTH_LABEL=5;
    public $SOME_LABEL=27;
    public $NODE_ID=50;
    public $ITFUCKINDOESNTWORK=62;
    public $OPEN_SQUARE_BRACE=51;
    public $ECHAR=53;
    public $WS=18;
    public $PN_CHARS_BASE=46;
    public $MIN_LABEL=31;
    public $CLASS_LABEL=43;
    public $THAT_LABEL=10;
    public $NOT_LABEL=16;
    public $PN_PREFIX=45;
    public $SELF_LABEL=30;
    public $PN_CHARS=44;
    public $MIN_LENGTH_LABEL=6;
    public $VALUE_LABEL=29;
    public $LESS_EQUAL=19;
    public $EXACTLY_LABEL=33;
    public $LANGUAGE_TAG=55;
    public $OPEN_BRACE=35;
    public $GREATER_EQUAL=20;

    // delegates
    // delegators

    
    static $FOLLOW_conjunction_in_description59;
    static $FOLLOW_OR_LABEL_in_description72;
    static $FOLLOW_conjunction_in_description76;
    static $FOLLOW_classIRI_in_conjunction110;
    static $FOLLOW_THAT_LABEL_in_conjunction112;
    static $FOLLOW_primary_in_conjunction120;
    static $FOLLOW_AND_LABEL_in_conjunction129;
    static $FOLLOW_primary_in_conjunction133;
    static $FOLLOW_NOT_LABEL_in_primary159;
    static $FOLLOW_restriction_in_primary166;
    static $FOLLOW_atomic_in_primary172;
    static $FOLLOW_FULL_IRI_in_iri201;
    static $FOLLOW_ABBREVIATED_IRI_in_iri209;
    static $FOLLOW_SIMPLE_IRI_in_iri217;
    static $FOLLOW_objectPropertyIRI_in_objectPropertyExpression242;
    static $FOLLOW_inverseObjectProperty_in_objectPropertyExpression250;
    static $FOLLOW_objectPropertyExpression_in_restriction271;
    static $FOLLOW_SOME_LABEL_in_restriction279;
    static $FOLLOW_primary_in_restriction283;
    static $FOLLOW_ONLY_LABEL_in_restriction295;
    static $FOLLOW_primary_in_restriction299;
    static $FOLLOW_VALUE_LABEL_in_restriction311;
    static $FOLLOW_individual_in_restriction315;
    static $FOLLOW_SELF_LABEL_in_restriction327;
    static $FOLLOW_MIN_LABEL_in_restriction339;
    static $FOLLOW_nonNegativeInteger_in_restriction343;
    static $FOLLOW_primary_in_restriction347;
    static $FOLLOW_MAX_LABEL_in_restriction359;
    static $FOLLOW_nonNegativeInteger_in_restriction363;
    static $FOLLOW_primary_in_restriction367;
    static $FOLLOW_EXACTLY_LABEL_in_restriction379;
    static $FOLLOW_nonNegativeInteger_in_restriction383;
    static $FOLLOW_primary_in_restriction387;
    static $FOLLOW_dataPropertyExpression_in_restriction402;
    static $FOLLOW_SOME_LABEL_in_restriction410;
    static $FOLLOW_dataRange_in_restriction414;
    static $FOLLOW_ONLY_LABEL_in_restriction424;
    static $FOLLOW_dataRange_in_restriction428;
    static $FOLLOW_VALUE_LABEL_in_restriction438;
    static $FOLLOW_literal_in_restriction442;
    static $FOLLOW_MIN_LABEL_in_restriction451;
    static $FOLLOW_nonNegativeInteger_in_restriction455;
    static $FOLLOW_dataRange_in_restriction459;
    static $FOLLOW_MAX_LABEL_in_restriction470;
    static $FOLLOW_nonNegativeInteger_in_restriction474;
    static $FOLLOW_dataRange_in_restriction478;
    static $FOLLOW_EXACTLY_LABEL_in_restriction489;
    static $FOLLOW_nonNegativeInteger_in_restriction493;
    static $FOLLOW_dataRange_in_restriction497;
    static $FOLLOW_objectPropertyExpression_in_restriction524;
    static $FOLLOW_EXACTLY_LABEL_in_restriction526;
    static $FOLLOW_nonNegativeInteger_in_restriction530;
    static $FOLLOW_classIRI_in_atomic552;
    static $FOLLOW_OPEN_CURLY_BRACE_in_atomic560;
    static $FOLLOW_individualList_in_atomic562;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_atomic564;
    static $FOLLOW_OPEN_BRACE_in_atomic572;
    static $FOLLOW_description_in_atomic574;
    static $FOLLOW_CLOSE_BRACE_in_atomic576;
    static $FOLLOW_iri_in_classIRI597;
    static $FOLLOW_individual_in_individualList620;
    static $FOLLOW_COMMA_in_individualList629;
    static $FOLLOW_individual_in_individualList633;
    static $FOLLOW_individualIRI_in_individual658;
    static $FOLLOW_NODE_ID_in_individual666;
    static $FOLLOW_DIGITS_in_nonNegativeInteger687;
    static $FOLLOW_NOT_LABEL_in_dataPrimary711;
    static $FOLLOW_dataAtomic_in_dataPrimary715;
    static $FOLLOW_dataPropertyIRI_in_dataPropertyExpression738;
    static $FOLLOW_dataType_in_dataAtomic760;
    static $FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic770;
    static $FOLLOW_literalList_in_dataAtomic772;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic774;
    static $FOLLOW_dataTypeRestriction_in_dataAtomic784;
    static $FOLLOW_OPEN_BRACE_in_dataAtomic794;
    static $FOLLOW_dataRange_in_dataAtomic796;
    static $FOLLOW_CLOSE_BRACE_in_dataAtomic798;
    static $FOLLOW_literal_in_literalList822;
    static $FOLLOW_COMMA_in_literalList829;
    static $FOLLOW_literal_in_literalList833;
    static $FOLLOW_datatypeIRI_in_dataType856;
    static $FOLLOW_INTEGER_LABEL_in_dataType866;
    static $FOLLOW_DECIMAL_LABEL_in_dataType877;
    static $FOLLOW_FLOAT_LABEL_in_dataType887;
    static $FOLLOW_STRING_LABEL_in_dataType897;
    static $FOLLOW_typedLiteral_in_literal924;
    static $FOLLOW_stringLiteralNoLanguage_in_literal930;
    static $FOLLOW_stringLiteralWithLanguage_in_literal936;
    static $FOLLOW_integerLiteral_in_literal942;
    static $FOLLOW_decimalLiteral_in_literal948;
    static $FOLLOW_floatingPointLiteral_in_literal954;
    static $FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage973;
    static $FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage994;
    static $FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage996;
    static $FOLLOW_QUOTED_STRING_in_lexicalValue1017;
    static $FOLLOW_lexicalValue_in_typedLiteral1038;
    static $FOLLOW_REFERENCE_in_typedLiteral1040;
    static $FOLLOW_dataType_in_typedLiteral1042;
    static $FOLLOW_literal_in_restrictionValue1063;
    static $FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1084;
    static $FOLLOW_objectPropertyIRI_in_inverseObjectProperty1086;
    static $FOLLOW_DLITERAL_HELPER_in_decimalLiteral1107;
    static $FOLLOW_ILITERAL_HELPER_in_integerLiteral1129;
    static $FOLLOW_DIGITS_in_integerLiteral1135;
    static $FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1157;
    static $FOLLOW_objectPropertyIRI_in_objectProperty1178;
    static $FOLLOW_dataPropertyIRI_in_dataProperty1199;
    static $FOLLOW_iri_in_dataPropertyIRI1220;
    static $FOLLOW_iri_in_datatypeIRI1241;
    static $FOLLOW_iri_in_objectPropertyIRI1262;
    static $FOLLOW_dataType_in_dataTypeRestriction1283;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1287;
    static $FOLLOW_facet_in_dataTypeRestriction1301;
    static $FOLLOW_restrictionValue_in_dataTypeRestriction1305;
    static $FOLLOW_COMMA_in_dataTypeRestriction1309;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1316;
    static $FOLLOW_iri_in_individualIRI1335;
    static $FOLLOW_iri_in_datatypePropertyIRI1356;
    static $FOLLOW_LENGTH_LABEL_in_facet1383;
    static $FOLLOW_MIN_LENGTH_LABEL_in_facet1389;
    static $FOLLOW_MAX_LENGTH_LABEL_in_facet1395;
    static $FOLLOW_PATTERN_LABEL_in_facet1401;
    static $FOLLOW_LANG_PATTERN_LABEL_in_facet1407;
    static $FOLLOW_LESS_EQUAL_in_facet1413;
    static $FOLLOW_LESS_in_facet1419;
    static $FOLLOW_GREATER_EQUAL_in_facet1425;
    static $FOLLOW_GREATER_in_facet1431;
    static $FOLLOW_dataConjunction_in_dataRange1460;
    static $FOLLOW_OR_LABEL_in_dataRange1474;
    static $FOLLOW_dataConjunction_in_dataRange1478;
    static $FOLLOW_dataPrimary_in_dataConjunction1511;
    static $FOLLOW_AND_LABEL_in_dataConjunction1528;
    static $FOLLOW_dataPrimary_in_dataConjunction1532;
    static $FOLLOW_description_in_descriptionAnnotatedList1575;
    static $FOLLOW_CLASS_LABEL_in_classFrame1604;
    static $FOLLOW_classIRI_in_classFrame1609;
    static $FOLLOW_SUBCLASS_OF_LABEL_in_classFrame1621;
    static $FOLLOW_descriptionAnnotatedList_in_classFrame1625;
    static $FOLLOW_objectPropertyExpression_in_synpred15_Erfurt_Syntax_Manchester271;
    static $FOLLOW_SOME_LABEL_in_synpred15_Erfurt_Syntax_Manchester279;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester283;
    static $FOLLOW_ONLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester295;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester299;
    static $FOLLOW_VALUE_LABEL_in_synpred15_Erfurt_Syntax_Manchester311;
    static $FOLLOW_individual_in_synpred15_Erfurt_Syntax_Manchester315;
    static $FOLLOW_SELF_LABEL_in_synpred15_Erfurt_Syntax_Manchester327;
    static $FOLLOW_MIN_LABEL_in_synpred15_Erfurt_Syntax_Manchester339;
    static $FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester343;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester347;
    static $FOLLOW_MAX_LABEL_in_synpred15_Erfurt_Syntax_Manchester359;
    static $FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester363;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester367;
    static $FOLLOW_EXACTLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester379;
    static $FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester383;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester387;
    static $FOLLOW_dataPropertyExpression_in_synpred24_Erfurt_Syntax_Manchester402;
    static $FOLLOW_SOME_LABEL_in_synpred24_Erfurt_Syntax_Manchester410;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester414;
    static $FOLLOW_ONLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester424;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester428;
    static $FOLLOW_VALUE_LABEL_in_synpred24_Erfurt_Syntax_Manchester438;
    static $FOLLOW_literal_in_synpred24_Erfurt_Syntax_Manchester442;
    static $FOLLOW_MIN_LABEL_in_synpred24_Erfurt_Syntax_Manchester451;
    static $FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester455;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester459;
    static $FOLLOW_MAX_LABEL_in_synpred24_Erfurt_Syntax_Manchester470;
    static $FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester474;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester478;
    static $FOLLOW_EXACTLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester489;
    static $FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester493;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester497;
    static $FOLLOW_OR_LABEL_in_synpred54_Erfurt_Syntax_Manchester1474;
    static $FOLLOW_dataConjunction_in_synpred54_Erfurt_Syntax_Manchester1478;
    static $FOLLOW_AND_LABEL_in_synpred55_Erfurt_Syntax_Manchester1528;
    static $FOLLOW_dataPrimary_in_synpred55_Erfurt_Syntax_Manchester1532;

    
    protected $dfa18;
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
             
            
            $this->dfa18 = new Erfurt_Syntax_ManchesterParser_DFA18($this);
            
        }
        

    public function getTokenNames() { return Erfurt_Syntax_ManchesterParser::$tokenNames; }
    public function getGrammarFileName() { return "src/Erfurt_Syntax_Manchester.g"; }



    // $ANTLR start "description"
    // src/Erfurt_Syntax_Manchester.g:11:1: description returns [$value] : c1= conjunction ( OR_LABEL c2= conjunction )* ; 
    public function description(){
        $value = null;

        $c1 = null;

        $c2 = null;



        $ce = new Erfurt_Owl_Structured_ClassExpression();

        try {
            // src/Erfurt_Syntax_Manchester.g:23:3: (c1= conjunction ( OR_LABEL c2= conjunction )* ) 
            // src/Erfurt_Syntax_Manchester.g:24:3: c1= conjunction ( OR_LABEL c2= conjunction )* 
            {
            $this->pushFollow(self::$FOLLOW_conjunction_in_description59);
            $c1=$this->conjunction();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $ce->addElement($c1);
            }
            // src/Erfurt_Syntax_Manchester.g:25:9: ( OR_LABEL c2= conjunction )* 
            //loop1:
            do {
                $alt1=2;
                $LA1_0 = $this->input->LA(1);

                if ( ($LA1_0==$this->getToken('OR_LABEL')) ) {
                    $alt1=1;
                }


                switch ($alt1) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:25:10: OR_LABEL c2= conjunction 
            	    {
            	    $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_description72); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_conjunction_in_description76);
            	    $c2=$this->conjunction();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $ce->addElement($c2);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop1;
                }
            } while (true);


            }

            if ( $this->state->backtracking==0 ) {

                if(count($ce->getElements())>1)
                  $value = new Erfurt_Owl_Structured_ClassExpression_ObjectUnionOf($ce->getElements());
                else {
                  $e = $ce->getElements();
                  $value = $e[0];
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
    // $ANTLR end "description"


    // $ANTLR start "conjunction"
    // src/Erfurt_Syntax_Manchester.g:28:1: conjunction returns [$value] : (c= classIRI THAT_LABEL )? p1= primary ( AND_LABEL p2= primary )* ; 
    public function conjunction(){
        $value = null;

        $c = null;

        $p1 = null;

        $p2 = null;



        $ce = new Erfurt_Owl_Structured_ClassExpression();

        try {
            // src/Erfurt_Syntax_Manchester.g:40:3: ( (c= classIRI THAT_LABEL )? p1= primary ( AND_LABEL p2= primary )* ) 
            // src/Erfurt_Syntax_Manchester.g:41:3: (c= classIRI THAT_LABEL )? p1= primary ( AND_LABEL p2= primary )* 
            {
            // src/Erfurt_Syntax_Manchester.g:41:3: (c= classIRI THAT_LABEL )? 
            $alt2=2;
            $LA2 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA2)
                {
                $LA2_1 = $this->input->LA(2);

                if ( ($LA2_1==$this->getToken('THAT_LABEL')) ) {
                    $alt2=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA2)
                {
                $LA2_2 = $this->input->LA(2);

                if ( ($LA2_2==$this->getToken('THAT_LABEL')) ) {
                    $alt2=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA2)
                {
                $LA2_3 = $this->input->LA(2);

                if ( ($LA2_3==$this->getToken('THAT_LABEL')) ) {
                    $alt2=1;
                }
                }

            switch ($alt2) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:41:4: c= classIRI THAT_LABEL 
                    {
                    $this->pushFollow(self::$FOLLOW_classIRI_in_conjunction110);
                    $c=$this->classIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('THAT_LABEL'),self::$FOLLOW_THAT_LABEL_in_conjunction112); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $ce->addElement($c);
                    }

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_primary_in_conjunction120);
            $p1=$this->primary();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {

                          $ce->addElement($p1);
            }
            // src/Erfurt_Syntax_Manchester.g:43:5: ( AND_LABEL p2= primary )* 
            //loop3:
            do {
                $alt3=2;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('AND_LABEL')) ) {
                    $alt3=1;
                }


                switch ($alt3) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:43:6: AND_LABEL p2= primary 
            	    {
            	    $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_conjunction129); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_primary_in_conjunction133);
            	    $p2=$this->primary();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $ce->addElement($p2);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop3;
                }
            } while (true);


            }

            if ( $this->state->backtracking==0 ) {

                if(count($ce->getElements())>1)
                  $value = new Erfurt_Owl_Structured_ClassExpression_ObjectIntersectionOf($ce->getElements());
                 else {
                  $e = $ce->getElements();
                  $value = $e[0];
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
    // $ANTLR end "conjunction"


    // $ANTLR start "primary"
    // src/Erfurt_Syntax_Manchester.g:46:1: primary returns [$value] : (n= NOT_LABEL )? (v= restriction | v= atomic ) ; 
    public function primary(){
        $value = null;

        $n=null;
        $v = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:47:3: ( (n= NOT_LABEL )? (v= restriction | v= atomic ) ) 
            // src/Erfurt_Syntax_Manchester.g:48:3: (n= NOT_LABEL )? (v= restriction | v= atomic ) 
            {
            // src/Erfurt_Syntax_Manchester.g:48:3: (n= NOT_LABEL )? 
            $alt4=2;
            $LA4_0 = $this->input->LA(1);

            if ( ($LA4_0==$this->getToken('NOT_LABEL')) ) {
                $alt4=1;
            }
            switch ($alt4) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:48:4: n= NOT_LABEL 
                    {
                    $n=$this->match($this->input,$this->getToken('NOT_LABEL'),self::$FOLLOW_NOT_LABEL_in_primary159); if ($this->state->failed) return $value;

                    }
                    break;

            }

            // src/Erfurt_Syntax_Manchester.g:48:18: (v= restriction | v= atomic ) 
            $alt5=2;
            $LA5 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA5)
                {
                $LA5_1 = $this->input->LA(2);

                if ( (($LA5_1>=$this->getToken('SOME_LABEL') && $LA5_1<=$this->getToken('EXACTLY_LABEL'))) ) {
                    $alt5=1;
                }
                else if ( ($LA5_1==$this->getToken('EOF')||($LA5_1>=$this->getToken('OR_LABEL') && $LA5_1<=$this->getToken('AND_LABEL'))||$LA5_1==$this->getToken('CLOSE_BRACE')||$LA5_1==$this->getToken('SUBCLASS_OF_LABEL')) ) {
                    $alt5=2;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 5, 1, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA5)
                {
                $LA5_2 = $this->input->LA(2);

                if ( (($LA5_2>=$this->getToken('SOME_LABEL') && $LA5_2<=$this->getToken('EXACTLY_LABEL'))) ) {
                    $alt5=1;
                }
                else if ( ($LA5_2==$this->getToken('EOF')||($LA5_2>=$this->getToken('OR_LABEL') && $LA5_2<=$this->getToken('AND_LABEL'))||$LA5_2==$this->getToken('CLOSE_BRACE')||$LA5_2==$this->getToken('SUBCLASS_OF_LABEL')) ) {
                    $alt5=2;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 5, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA5)
                {
                $LA5_3 = $this->input->LA(2);

                if ( (($LA5_3>=$this->getToken('SOME_LABEL') && $LA5_3<=$this->getToken('EXACTLY_LABEL'))) ) {
                    $alt5=1;
                }
                else if ( ($LA5_3==$this->getToken('EOF')||($LA5_3>=$this->getToken('OR_LABEL') && $LA5_3<=$this->getToken('AND_LABEL'))||$LA5_3==$this->getToken('CLOSE_BRACE')||$LA5_3==$this->getToken('SUBCLASS_OF_LABEL')) ) {
                    $alt5=2;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 5, 3, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('INVERSE_LABEL')== $LA5)
                {
                $alt5=1;
                }
            else if($this->getToken('OPEN_CURLY_BRACE')== $LA5||$this->getToken('OPEN_BRACE')== $LA5)
                {
                $alt5=2;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 5, 0, $this->input);

                throw $nvae;
            }

            switch ($alt5) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:48:19: v= restriction 
                    {
                    $this->pushFollow(self::$FOLLOW_restriction_in_primary166);
                    $v=$this->restriction();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:48:35: v= atomic 
                    {
                    $this->pushFollow(self::$FOLLOW_atomic_in_primary172);
                    $v=$this->atomic();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }

            if ( $this->state->backtracking==0 ) {

                          if(isset($n)) {$value = new Erfurt_Owl_Structured_ClassExpression_ObjectComplementOf($v);}
                          else {$value = $v;}
                
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
    // $ANTLR end "primary"


    // $ANTLR start "iri"
    // src/Erfurt_Syntax_Manchester.g:54:1: iri returns [$value] : (v= FULL_IRI | v= ABBREVIATED_IRI | v= SIMPLE_IRI ); 
    public function iri(){
        $value = null;

        $v=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:58:3: (v= FULL_IRI | v= ABBREVIATED_IRI | v= SIMPLE_IRI ) 
            $alt6=3;
            $LA6 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA6)
                {
                $alt6=1;
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA6)
                {
                $alt6=2;
                }
            else if($this->getToken('SIMPLE_IRI')== $LA6)
                {
                $alt6=3;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 6, 0, $this->input);

                throw $nvae;
            }

            switch ($alt6) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:59:3: v= FULL_IRI 
                    {
                    $v=$this->match($this->input,$this->getToken('FULL_IRI'),self::$FOLLOW_FULL_IRI_in_iri201); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:60:5: v= ABBREVIATED_IRI 
                    {
                    $v=$this->match($this->input,$this->getToken('ABBREVIATED_IRI'),self::$FOLLOW_ABBREVIATED_IRI_in_iri209); if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:61:5: v= SIMPLE_IRI 
                    {
                    $v=$this->match($this->input,$this->getToken('SIMPLE_IRI'),self::$FOLLOW_SIMPLE_IRI_in_iri217); if ($this->state->failed) return $value;

                    }
                    break;

            }
            if ( $this->state->backtracking==0 ) {

              $value = new Erfurt_Owl_Structured_Iri(($v!=null?$v->getText():null));

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
    // $ANTLR end "iri"


    // $ANTLR start "objectPropertyExpression"
    // src/Erfurt_Syntax_Manchester.g:64:1: objectPropertyExpression returns [$value] : (v= objectPropertyIRI | v= inverseObjectProperty ); 
    public function objectPropertyExpression(){
        $value = null;

        $v = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:66:3: (v= objectPropertyIRI | v= inverseObjectProperty ) 
            $alt7=2;
            $LA7_0 = $this->input->LA(1);

            if ( (($LA7_0>=$this->getToken('FULL_IRI') && $LA7_0<=$this->getToken('SIMPLE_IRI'))||$LA7_0==$this->getToken('ABBREVIATED_IRI')) ) {
                $alt7=1;
            }
            else if ( ($LA7_0==$this->getToken('INVERSE_LABEL')) ) {
                $alt7=2;
            }
            else {
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae = new NoViableAltException("", 7, 0, $this->input);

                throw $nvae;
            }
            switch ($alt7) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:67:3: v= objectPropertyIRI 
                    {
                    $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_objectPropertyExpression242);
                    $v=$this->objectPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:68:5: v= inverseObjectProperty 
                    {
                    $this->pushFollow(self::$FOLLOW_inverseObjectProperty_in_objectPropertyExpression250);
                    $v=$this->inverseObjectProperty();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }
            if ( $this->state->backtracking==0 ) {
              $value = $v;
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
    // $ANTLR end "objectPropertyExpression"


    // $ANTLR start "restriction"
    // src/Erfurt_Syntax_Manchester.g:71:1: restriction returns [$value] : (o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) | dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) | (o= objectPropertyExpression EXACTLY_LABEL nni= nonNegativeInteger ) ); 
    public function restriction(){
        $value = null;

        $o = null;

        $p = null;

        $i = null;

        $nni = null;

        $dp = null;

        $d = null;

        $l = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:72:3: (o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) | dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) | (o= objectPropertyExpression EXACTLY_LABEL nni= nonNegativeInteger ) ) 
            $alt13=3;
            $LA13 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA13)
                {
                $LA13_1 = $this->input->LA(2);

                if ( ($this->synpred15_Erfurt_Syntax_Manchester()) ) {
                    $alt13=1;
                }
                else if ( ($this->synpred24_Erfurt_Syntax_Manchester()) ) {
                    $alt13=2;
                }
                else if ( (true) ) {
                    $alt13=3;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 13, 1, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA13)
                {
                $LA13_2 = $this->input->LA(2);

                if ( ($this->synpred15_Erfurt_Syntax_Manchester()) ) {
                    $alt13=1;
                }
                else if ( ($this->synpred24_Erfurt_Syntax_Manchester()) ) {
                    $alt13=2;
                }
                else if ( (true) ) {
                    $alt13=3;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 13, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA13)
                {
                $LA13_3 = $this->input->LA(2);

                if ( ($this->synpred15_Erfurt_Syntax_Manchester()) ) {
                    $alt13=1;
                }
                else if ( ($this->synpred24_Erfurt_Syntax_Manchester()) ) {
                    $alt13=2;
                }
                else if ( (true) ) {
                    $alt13=3;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 13, 3, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('INVERSE_LABEL')== $LA13)
                {
                $LA13_4 = $this->input->LA(2);

                if ( ($this->synpred15_Erfurt_Syntax_Manchester()) ) {
                    $alt13=1;
                }
                else if ( (true) ) {
                    $alt13=3;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 13, 4, $this->input);

                    throw $nvae;
                }
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 13, 0, $this->input);

                throw $nvae;
            }

            switch ($alt13) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:73:3: o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) 
                    {
                    $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_restriction271);
                    $o=$this->objectPropertyExpression();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    // src/Erfurt_Syntax_Manchester.g:74:5: ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) 
                    $alt8=7;
                    $LA8 = $this->input->LA(1);
                    if($this->getToken('SOME_LABEL')== $LA8)
                        {
                        $alt8=1;
                        }
                    else if($this->getToken('ONLY_LABEL')== $LA8)
                        {
                        $alt8=2;
                        }
                    else if($this->getToken('VALUE_LABEL')== $LA8)
                        {
                        $alt8=3;
                        }
                    else if($this->getToken('SELF_LABEL')== $LA8)
                        {
                        $alt8=4;
                        }
                    else if($this->getToken('MIN_LABEL')== $LA8)
                        {
                        $alt8=5;
                        }
                    else if($this->getToken('MAX_LABEL')== $LA8)
                        {
                        $alt8=6;
                        }
                    else if($this->getToken('EXACTLY_LABEL')== $LA8)
                        {
                        $alt8=7;
                        }
                    else{
                        if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                        $nvae =
                            new NoViableAltException("", 8, 0, $this->input);

                        throw $nvae;
                    }

                    switch ($alt8) {
                        case 1 :
                            // src/Erfurt_Syntax_Manchester.g:74:6: ( SOME_LABEL p= primary ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:74:6: ( SOME_LABEL p= primary ) 
                            // src/Erfurt_Syntax_Manchester.g:74:7: SOME_LABEL p= primary 
                            {
                            $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_restriction279); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction283);
                            $p=$this->primary();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectSomeValuesFrom($o, $p);
                            }

                            }


                            }
                            break;
                        case 2 :
                            // src/Erfurt_Syntax_Manchester.g:75:7: ( ONLY_LABEL p= primary ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:75:7: ( ONLY_LABEL p= primary ) 
                            // src/Erfurt_Syntax_Manchester.g:75:8: ONLY_LABEL p= primary 
                            {
                            $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_restriction295); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction299);
                            $p=$this->primary();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectAllValuesFrom($o, $p);
                            }

                            }


                            }
                            break;
                        case 3 :
                            // src/Erfurt_Syntax_Manchester.g:76:7: ( VALUE_LABEL i= individual ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:76:7: ( VALUE_LABEL i= individual ) 
                            // src/Erfurt_Syntax_Manchester.g:76:8: VALUE_LABEL i= individual 
                            {
                            $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_restriction311); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_individual_in_restriction315);
                            $i=$this->individual();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectHasValue($o, $i);
                            }

                            }


                            }
                            break;
                        case 4 :
                            // src/Erfurt_Syntax_Manchester.g:77:7: ( SELF_LABEL ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:77:7: ( SELF_LABEL ) 
                            // src/Erfurt_Syntax_Manchester.g:77:8: SELF_LABEL 
                            {
                            $this->match($this->input,$this->getToken('SELF_LABEL'),self::$FOLLOW_SELF_LABEL_in_restriction327); if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectHasSelf($o);
                            }

                            }


                            }
                            break;
                        case 5 :
                            // src/Erfurt_Syntax_Manchester.g:78:7: ( MIN_LABEL nni= nonNegativeInteger p= primary ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:78:7: ( MIN_LABEL nni= nonNegativeInteger p= primary ) 
                            // src/Erfurt_Syntax_Manchester.g:78:8: MIN_LABEL nni= nonNegativeInteger p= primary 
                            {
                            $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_restriction339); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction343);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction347);
                            $p=$this->primary();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectMinCardinality($o, $nni, isset($p)?$p:null);
                            }

                            }


                            }
                            break;
                        case 6 :
                            // src/Erfurt_Syntax_Manchester.g:79:7: ( MAX_LABEL nni= nonNegativeInteger p= primary ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:79:7: ( MAX_LABEL nni= nonNegativeInteger p= primary ) 
                            // src/Erfurt_Syntax_Manchester.g:79:8: MAX_LABEL nni= nonNegativeInteger p= primary 
                            {
                            $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_restriction359); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction363);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction367);
                            $p=$this->primary();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectMaxCardinality($o, $nni, isset($p)?$p:null);
                            }

                            }


                            }
                            break;
                        case 7 :
                            // src/Erfurt_Syntax_Manchester.g:80:7: ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:80:7: ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) 
                            // src/Erfurt_Syntax_Manchester.g:80:8: EXACTLY_LABEL nni= nonNegativeInteger p= primary 
                            {
                            $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_restriction379); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction383);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction387);
                            $p=$this->primary();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectExactCardinality($o, $nni, isset($p)?$p:null);
                            }

                            }


                            }
                            break;

                    }


                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:82:5: dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) 
                    {
                    $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_restriction402);
                    $dp=$this->dataPropertyExpression();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    // src/Erfurt_Syntax_Manchester.g:82:30: ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) 
                    $alt12=6;
                    $LA12 = $this->input->LA(1);
                    if($this->getToken('SOME_LABEL')== $LA12)
                        {
                        $alt12=1;
                        }
                    else if($this->getToken('ONLY_LABEL')== $LA12)
                        {
                        $alt12=2;
                        }
                    else if($this->getToken('VALUE_LABEL')== $LA12)
                        {
                        $alt12=3;
                        }
                    else if($this->getToken('MIN_LABEL')== $LA12)
                        {
                        $alt12=4;
                        }
                    else if($this->getToken('MAX_LABEL')== $LA12)
                        {
                        $alt12=5;
                        }
                    else if($this->getToken('EXACTLY_LABEL')== $LA12)
                        {
                        $alt12=6;
                        }
                    else{
                        if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                        $nvae =
                            new NoViableAltException("", 12, 0, $this->input);

                        throw $nvae;
                    }

                    switch ($alt12) {
                        case 1 :
                            // src/Erfurt_Syntax_Manchester.g:83:5: ( SOME_LABEL d= dataRange ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:83:5: ( SOME_LABEL d= dataRange ) 
                            // src/Erfurt_Syntax_Manchester.g:83:6: SOME_LABEL d= dataRange 
                            {
                            $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_restriction410); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_dataRange_in_restriction414);
                            $d=$this->dataRange();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_DataPropertyRestriction_DataSomeValuesFrom($dp, $d);
                            }

                            }


                            }
                            break;
                        case 2 :
                            // src/Erfurt_Syntax_Manchester.g:84:5: ( ONLY_LABEL d= dataRange ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:84:5: ( ONLY_LABEL d= dataRange ) 
                            // src/Erfurt_Syntax_Manchester.g:84:6: ONLY_LABEL d= dataRange 
                            {
                            $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_restriction424); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_dataRange_in_restriction428);
                            $d=$this->dataRange();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_DataPropertyRestriction_DataAllValuesFrom($dp, $d);
                            }

                            }


                            }
                            break;
                        case 3 :
                            // src/Erfurt_Syntax_Manchester.g:85:5: ( VALUE_LABEL l= literal ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:85:5: ( VALUE_LABEL l= literal ) 
                            // src/Erfurt_Syntax_Manchester.g:85:6: VALUE_LABEL l= literal 
                            {
                            $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_restriction438); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_literal_in_restriction442);
                            $l=$this->literal();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_DataPropertyRestriction_DataHasValue($dp, $l);
                            }

                            }


                            }
                            break;
                        case 4 :
                            // src/Erfurt_Syntax_Manchester.g:86:5: ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:86:5: ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            // src/Erfurt_Syntax_Manchester.g:86:6: MIN_LABEL nni= nonNegativeInteger (d= dataRange )? 
                            {
                            $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_restriction451); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction455);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:86:40: (d= dataRange )? 
                            $alt9=2;
                            $LA9_0 = $this->input->LA(1);

                            if ( ($LA9_0==$this->getToken('NOT_LABEL')||$LA9_0==$this->getToken('OPEN_CURLY_BRACE')||$LA9_0==$this->getToken('OPEN_BRACE')||($LA9_0>=$this->getToken('DECIMAL_LABEL') && $LA9_0<=$this->getToken('STRING_LABEL'))||($LA9_0>=$this->getToken('FULL_IRI') && $LA9_0<=$this->getToken('SIMPLE_IRI'))||$LA9_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt9=1;
                            }
                            switch ($alt9) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                                    {
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction459);
                                    $d=$this->dataRange();

                                    $this->state->_fsp--;
                                    if ($this->state->failed) return $value;

                                    }
                                    break;

                            }

                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_DataPropertyRestriction_DataMinCardinality($dp, $nni, isset($d)?$d:null);
                            }

                            }


                            }
                            break;
                        case 5 :
                            // src/Erfurt_Syntax_Manchester.g:87:5: ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:87:5: ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            // src/Erfurt_Syntax_Manchester.g:87:6: MAX_LABEL nni= nonNegativeInteger (d= dataRange )? 
                            {
                            $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_restriction470); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction474);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:87:40: (d= dataRange )? 
                            $alt10=2;
                            $LA10_0 = $this->input->LA(1);

                            if ( ($LA10_0==$this->getToken('NOT_LABEL')||$LA10_0==$this->getToken('OPEN_CURLY_BRACE')||$LA10_0==$this->getToken('OPEN_BRACE')||($LA10_0>=$this->getToken('DECIMAL_LABEL') && $LA10_0<=$this->getToken('STRING_LABEL'))||($LA10_0>=$this->getToken('FULL_IRI') && $LA10_0<=$this->getToken('SIMPLE_IRI'))||$LA10_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt10=1;
                            }
                            switch ($alt10) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                                    {
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction478);
                                    $d=$this->dataRange();

                                    $this->state->_fsp--;
                                    if ($this->state->failed) return $value;

                                    }
                                    break;

                            }

                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_DataPropertyRestriction_DataMaxCardinality($dp, $nni, isset($d)?$d:null);
                            }

                            }


                            }
                            break;
                        case 6 :
                            // src/Erfurt_Syntax_Manchester.g:88:5: ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:88:5: ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            // src/Erfurt_Syntax_Manchester.g:88:6: EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? 
                            {
                            $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_restriction489); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction493);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:88:44: (d= dataRange )? 
                            $alt11=2;
                            $LA11_0 = $this->input->LA(1);

                            if ( ($LA11_0==$this->getToken('NOT_LABEL')||$LA11_0==$this->getToken('OPEN_CURLY_BRACE')||$LA11_0==$this->getToken('OPEN_BRACE')||($LA11_0>=$this->getToken('DECIMAL_LABEL') && $LA11_0<=$this->getToken('STRING_LABEL'))||($LA11_0>=$this->getToken('FULL_IRI') && $LA11_0<=$this->getToken('SIMPLE_IRI'))||$LA11_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt11=1;
                            }
                            switch ($alt11) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                                    {
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction497);
                                    $d=$this->dataRange();

                                    $this->state->_fsp--;
                                    if ($this->state->failed) return $value;

                                    }
                                    break;

                            }

                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_DataPropertyRestriction_DataExactCardinality($dp, $nni, $d);
                            }

                            }


                            }
                            break;

                    }


                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:93:5: (o= objectPropertyExpression EXACTLY_LABEL nni= nonNegativeInteger ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:93:5: (o= objectPropertyExpression EXACTLY_LABEL nni= nonNegativeInteger ) 
                    // src/Erfurt_Syntax_Manchester.g:93:6: o= objectPropertyExpression EXACTLY_LABEL nni= nonNegativeInteger 
                    {
                    $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_restriction524);
                    $o=$this->objectPropertyExpression();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_restriction526); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction530);
                    $nni=$this->nonNegativeInteger();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }

                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectExactCardinality($o, $nni, isset($p)?$p:null);
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
        
        return $value;
    }
    // $ANTLR end "restriction"


    // $ANTLR start "atomic"
    // src/Erfurt_Syntax_Manchester.g:96:1: atomic returns [$value] : ( classIRI | OPEN_CURLY_BRACE individualList CLOSE_CURLY_BRACE | OPEN_BRACE description CLOSE_BRACE ); 
    public function atomic(){
        $value = null;

        $classIRI1 = null;

        $individualList2 = null;

        $description3 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:97:3: ( classIRI | OPEN_CURLY_BRACE individualList CLOSE_CURLY_BRACE | OPEN_BRACE description CLOSE_BRACE ) 
            $alt14=3;
            $LA14 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA14||$this->getToken('SIMPLE_IRI')== $LA14||$this->getToken('ABBREVIATED_IRI')== $LA14)
                {
                $alt14=1;
                }
            else if($this->getToken('OPEN_CURLY_BRACE')== $LA14)
                {
                $alt14=2;
                }
            else if($this->getToken('OPEN_BRACE')== $LA14)
                {
                $alt14=3;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 14, 0, $this->input);

                throw $nvae;
            }

            switch ($alt14) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:98:3: classIRI 
                    {
                    $this->pushFollow(self::$FOLLOW_classIRI_in_atomic552);
                    $classIRI1=$this->classIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_OwlClass($classIRI1);
                    }

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:99:5: OPEN_CURLY_BRACE individualList CLOSE_CURLY_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_atomic560); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_individualList_in_atomic562);
                    $individualList2=$this->individualList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_atomic564); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_ClassExpression_ObjectOneOf($individualList2);
                    }

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:100:5: OPEN_BRACE description CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_atomic572); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_description_in_atomic574);
                    $description3=$this->description();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_atomic576); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $description3;
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
        
        return $value;
    }
    // $ANTLR end "atomic"


    // $ANTLR start "classIRI"
    // src/Erfurt_Syntax_Manchester.g:103:1: classIRI returns [$value] : iri ; 
    public function classIRI(){
        $value = null;

        $iri4 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:104:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:105:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_classIRI597);
            $iri4=$this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $iri4;
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
    // $ANTLR end "classIRI"


    // $ANTLR start "individualList"
    // src/Erfurt_Syntax_Manchester.g:108:1: individualList returns [$value] : i= individual ( COMMA i1= individual )* ; 
    public function individualList(){
        $value = null;

        $i = null;

        $i1 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:109:3: (i= individual ( COMMA i1= individual )* ) 
            // src/Erfurt_Syntax_Manchester.g:110:3: i= individual ( COMMA i1= individual )* 
            {
            $this->pushFollow(self::$FOLLOW_individual_in_individualList620);
            $i=$this->individual();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_IndividualList($i);
            }
            // src/Erfurt_Syntax_Manchester.g:111:5: ( COMMA i1= individual )* 
            //loop15:
            do {
                $alt15=2;
                $LA15_0 = $this->input->LA(1);

                if ( ($LA15_0==$this->getToken('COMMA')) ) {
                    $alt15=1;
                }


                switch ($alt15) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:111:6: COMMA i1= individual 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_individualList629); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_individual_in_individualList633);
            	    $i1=$this->individual();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($i1);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop15;
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
    // $ANTLR end "individualList"


    // $ANTLR start "individual"
    // src/Erfurt_Syntax_Manchester.g:114:1: individual returns [$value] : (i= individualIRI | NODE_ID ); 
    public function individual(){
        $value = null;

        $NODE_ID5=null;
        $i = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:115:3: (i= individualIRI | NODE_ID ) 
            $alt16=2;
            $LA16_0 = $this->input->LA(1);

            if ( (($LA16_0>=$this->getToken('FULL_IRI') && $LA16_0<=$this->getToken('SIMPLE_IRI'))||$LA16_0==$this->getToken('ABBREVIATED_IRI')) ) {
                $alt16=1;
            }
            else if ( ($LA16_0==$this->getToken('NODE_ID')) ) {
                $alt16=2;
            }
            else {
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae = new NoViableAltException("", 16, 0, $this->input);

                throw $nvae;
            }
            switch ($alt16) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:116:3: i= individualIRI 
                    {
                    $this->pushFollow(self::$FOLLOW_individualIRI_in_individual658);
                    $i=$this->individualIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_Individual_NamedIndividual($i);
                    }

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:117:5: NODE_ID 
                    {
                    $NODE_ID5=$this->match($this->input,$this->getToken('NODE_ID'),self::$FOLLOW_NODE_ID_in_individual666); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_Individual_AnonymousIndividual(($NODE_ID5!=null?$NODE_ID5->getText():null));
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
        
        return $value;
    }
    // $ANTLR end "individual"


    // $ANTLR start "nonNegativeInteger"
    // src/Erfurt_Syntax_Manchester.g:120:1: nonNegativeInteger returns [$value] : DIGITS ; 
    public function nonNegativeInteger(){
        $value = null;

        $DIGITS6=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:121:3: ( DIGITS ) 
            // src/Erfurt_Syntax_Manchester.g:122:3: DIGITS 
            {
            $DIGITS6=$this->match($this->input,$this->getToken('DIGITS'),self::$FOLLOW_DIGITS_in_nonNegativeInteger687); if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = ($DIGITS6!=null?$DIGITS6->getText():null);
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
    // $ANTLR end "nonNegativeInteger"


    // $ANTLR start "dataPrimary"
    // src/Erfurt_Syntax_Manchester.g:125:1: dataPrimary returns [$value] : (n= NOT_LABEL )? dataAtomic ; 
    public function dataPrimary(){
        $value = null;

        $n=null;
        $dataAtomic7 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:126:3: ( (n= NOT_LABEL )? dataAtomic ) 
            // src/Erfurt_Syntax_Manchester.g:127:3: (n= NOT_LABEL )? dataAtomic 
            {
            // src/Erfurt_Syntax_Manchester.g:127:3: (n= NOT_LABEL )? 
            $alt17=2;
            $LA17_0 = $this->input->LA(1);

            if ( ($LA17_0==$this->getToken('NOT_LABEL')) ) {
                $alt17=1;
            }
            switch ($alt17) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:127:4: n= NOT_LABEL 
                    {
                    $n=$this->match($this->input,$this->getToken('NOT_LABEL'),self::$FOLLOW_NOT_LABEL_in_dataPrimary711); if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_dataAtomic_in_dataPrimary715);
            $dataAtomic7=$this->dataAtomic();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {

                          $value = (isset($n))? new Erfurt_Owl_Structured_DataRange_DataComplementOf($dataAtomic7) : $dataAtomic7;
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
    // $ANTLR end "dataPrimary"


    // $ANTLR start "dataPropertyExpression"
    // src/Erfurt_Syntax_Manchester.g:131:1: dataPropertyExpression returns [$value] : d= dataPropertyIRI ; 
    public function dataPropertyExpression(){
        $value = null;

        $d = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:132:3: (d= dataPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:133:3: d= dataPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_dataPropertyIRI_in_dataPropertyExpression738);
            $d=$this->dataPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $d;
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
    // $ANTLR end "dataPropertyExpression"


    // $ANTLR start "dataAtomic"
    // src/Erfurt_Syntax_Manchester.g:136:1: dataAtomic returns [$value] : ( ( dataType ) | ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) | ( dataTypeRestriction ) | ( OPEN_BRACE dataRange CLOSE_BRACE ) ); 
    public function dataAtomic(){
        $value = null;

        $dataType8 = null;

        $literalList9 = null;

        $dataTypeRestriction10 = null;

        $dataRange11 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:137:3: ( ( dataType ) | ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) | ( dataTypeRestriction ) | ( OPEN_BRACE dataRange CLOSE_BRACE ) ) 
            $alt18=4;
            $alt18 = $this->dfa18->predict($this->input);
            switch ($alt18) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:138:3: ( dataType ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:138:3: ( dataType ) 
                    // src/Erfurt_Syntax_Manchester.g:138:4: dataType 
                    {
                    $this->pushFollow(self::$FOLLOW_dataType_in_dataAtomic760);
                    $dataType8=$this->dataType();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $dataType8;
                    }

                    }


                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:139:5: ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:139:5: ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) 
                    // src/Erfurt_Syntax_Manchester.g:139:6: OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic770); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_literalList_in_dataAtomic772);
                    $literalList9=$this->literalList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic774); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_DataRange_DataOneOf($literalList9);
                    }

                    }


                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:140:5: ( dataTypeRestriction ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:140:5: ( dataTypeRestriction ) 
                    // src/Erfurt_Syntax_Manchester.g:140:6: dataTypeRestriction 
                    {
                    $this->pushFollow(self::$FOLLOW_dataTypeRestriction_in_dataAtomic784);
                    $dataTypeRestriction10=$this->dataTypeRestriction();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $dataTypeRestriction10;
                    }

                    }


                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:141:5: ( OPEN_BRACE dataRange CLOSE_BRACE ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:141:5: ( OPEN_BRACE dataRange CLOSE_BRACE ) 
                    // src/Erfurt_Syntax_Manchester.g:141:6: OPEN_BRACE dataRange CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_dataAtomic794); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_dataRange_in_dataAtomic796);
                    $dataRange11=$this->dataRange();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_dataAtomic798); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $dataRange11;
                    }

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
        
        return $value;
    }
    // $ANTLR end "dataAtomic"


    // $ANTLR start "literalList"
    // src/Erfurt_Syntax_Manchester.g:144:1: literalList returns [$value] : l1= literal ( COMMA l2= literal )* ; 
    public function literalList(){
        $value = null;

        $l1 = null;

        $l2 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:145:3: (l1= literal ( COMMA l2= literal )* ) 
            // src/Erfurt_Syntax_Manchester.g:146:3: l1= literal ( COMMA l2= literal )* 
            {
            $this->pushFollow(self::$FOLLOW_literal_in_literalList822);
            $l1=$this->literal();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_OwlList_LiteralList($l1);
            }
            // src/Erfurt_Syntax_Manchester.g:147:3: ( COMMA l2= literal )* 
            //loop19:
            do {
                $alt19=2;
                $LA19_0 = $this->input->LA(1);

                if ( ($LA19_0==$this->getToken('COMMA')) ) {
                    $alt19=1;
                }


                switch ($alt19) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:147:4: COMMA l2= literal 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_literalList829); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_literal_in_literalList833);
            	    $l2=$this->literal();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($l2);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop19;
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
    // $ANTLR end "literalList"


    // $ANTLR start "dataType"
    // src/Erfurt_Syntax_Manchester.g:150:1: dataType returns [$value] : ( datatypeIRI | v= INTEGER_LABEL | v= DECIMAL_LABEL | v= FLOAT_LABEL | v= STRING_LABEL ); 
    public function dataType(){
        $value = null;

        $v=null;
        $datatypeIRI12 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:151:3: ( datatypeIRI | v= INTEGER_LABEL | v= DECIMAL_LABEL | v= FLOAT_LABEL | v= STRING_LABEL ) 
            $alt20=5;
            $LA20 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA20||$this->getToken('SIMPLE_IRI')== $LA20||$this->getToken('ABBREVIATED_IRI')== $LA20)
                {
                $alt20=1;
                }
            else if($this->getToken('INTEGER_LABEL')== $LA20)
                {
                $alt20=2;
                }
            else if($this->getToken('DECIMAL_LABEL')== $LA20)
                {
                $alt20=3;
                }
            else if($this->getToken('FLOAT_LABEL')== $LA20)
                {
                $alt20=4;
                }
            else if($this->getToken('STRING_LABEL')== $LA20)
                {
                $alt20=5;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 20, 0, $this->input);

                throw $nvae;
            }

            switch ($alt20) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:152:3: datatypeIRI 
                    {
                    $this->pushFollow(self::$FOLLOW_datatypeIRI_in_dataType856);
                    $datatypeIRI12=$this->datatypeIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $datatypeIRI12;
                    }

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:153:5: v= INTEGER_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('INTEGER_LABEL'),self::$FOLLOW_INTEGER_LABEL_in_dataType866); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:154:5: v= DECIMAL_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL_LABEL'),self::$FOLLOW_DECIMAL_LABEL_in_dataType877); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:155:5: v= FLOAT_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('FLOAT_LABEL'),self::$FOLLOW_FLOAT_LABEL_in_dataType887); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:156:5: v= STRING_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('STRING_LABEL'),self::$FOLLOW_STRING_LABEL_in_dataType897); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
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
        
        return $value;
    }
    // $ANTLR end "dataType"


    // $ANTLR start "literal"
    // src/Erfurt_Syntax_Manchester.g:159:1: literal returns [$value] : (v= typedLiteral | v= stringLiteralNoLanguage | v= stringLiteralWithLanguage | v= integerLiteral | v= decimalLiteral | v= floatingPointLiteral ); 
    public function literal(){
        $value = null;

        $v = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:161:3: (v= typedLiteral | v= stringLiteralNoLanguage | v= stringLiteralWithLanguage | v= integerLiteral | v= decimalLiteral | v= floatingPointLiteral ) 
            $alt21=6;
            $LA21 = $this->input->LA(1);
            if($this->getToken('QUOTED_STRING')== $LA21)
                {
                $LA21 = $this->input->LA(2);
                if($this->getToken('LANGUAGE_TAG')== $LA21)
                    {
                    $alt21=3;
                    }
                else if($this->getToken('EOF')== $LA21||$this->getToken('LENGTH_LABEL')== $LA21||$this->getToken('MIN_LENGTH_LABEL')== $LA21||$this->getToken('MAX_LENGTH_LABEL')== $LA21||$this->getToken('PATTERN_LABEL')== $LA21||$this->getToken('LANG_PATTERN_LABEL')== $LA21||$this->getToken('LESS_EQUAL')== $LA21||$this->getToken('GREATER_EQUAL')== $LA21||$this->getToken('LESS')== $LA21||$this->getToken('GREATER')== $LA21||$this->getToken('CLOSE_CURLY_BRACE')== $LA21||$this->getToken('OR_LABEL')== $LA21||$this->getToken('AND_LABEL')== $LA21||$this->getToken('COMMA')== $LA21||$this->getToken('CLOSE_BRACE')== $LA21||$this->getToken('SUBCLASS_OF_LABEL')== $LA21||$this->getToken('CLOSE_SQUARE_BRACE')== $LA21)
                    {
                    $alt21=2;
                    }
                else if($this->getToken('REFERENCE')== $LA21)
                    {
                    $alt21=1;
                    }
                else{
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae =
                        new NoViableAltException("", 21, 1, $this->input);

                    throw $nvae;
                }

                }
            else if($this->getToken('DIGITS')== $LA21||$this->getToken('ILITERAL_HELPER')== $LA21)
                {
                $alt21=4;
                }
            else if($this->getToken('DLITERAL_HELPER')== $LA21)
                {
                $alt21=5;
                }
            else if($this->getToken('FPLITERAL_HELPER')== $LA21)
                {
                $alt21=6;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 21, 0, $this->input);

                throw $nvae;
            }

            switch ($alt21) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:162:3: v= typedLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_typedLiteral_in_literal924);
                    $v=$this->typedLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:162:20: v= stringLiteralNoLanguage 
                    {
                    $this->pushFollow(self::$FOLLOW_stringLiteralNoLanguage_in_literal930);
                    $v=$this->stringLiteralNoLanguage();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:162:48: v= stringLiteralWithLanguage 
                    {
                    $this->pushFollow(self::$FOLLOW_stringLiteralWithLanguage_in_literal936);
                    $v=$this->stringLiteralWithLanguage();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:162:78: v= integerLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_integerLiteral_in_literal942);
                    $v=$this->integerLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:162:97: v= decimalLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_decimalLiteral_in_literal948);
                    $v=$this->decimalLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 6 :
                    // src/Erfurt_Syntax_Manchester.g:162:116: v= floatingPointLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_floatingPointLiteral_in_literal954);
                    $v=$this->floatingPointLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }
            if ( $this->state->backtracking==0 ) {
              $value = $v;
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
    // $ANTLR end "literal"


    // $ANTLR start "stringLiteralNoLanguage"
    // src/Erfurt_Syntax_Manchester.g:165:1: stringLiteralNoLanguage returns [$value] : QUOTED_STRING ; 
    public function stringLiteralNoLanguage(){
        $value = null;

        $QUOTED_STRING13=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:166:3: ( QUOTED_STRING ) 
            // src/Erfurt_Syntax_Manchester.g:167:3: QUOTED_STRING 
            {
            $QUOTED_STRING13=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage973); if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {

                          $value = new Erfurt_Owl_Structured_Literal_StringLiteral(($QUOTED_STRING13!=null?$QUOTED_STRING13->getText():null));
                      
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
    // $ANTLR end "stringLiteralNoLanguage"


    // $ANTLR start "stringLiteralWithLanguage"
    // src/Erfurt_Syntax_Manchester.g:172:1: stringLiteralWithLanguage returns [$value] : QUOTED_STRING LANGUAGE_TAG ; 
    public function stringLiteralWithLanguage(){
        $value = null;

        $QUOTED_STRING14=null;
        $LANGUAGE_TAG15=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:173:3: ( QUOTED_STRING LANGUAGE_TAG ) 
            // src/Erfurt_Syntax_Manchester.g:174:3: QUOTED_STRING LANGUAGE_TAG 
            {
            $QUOTED_STRING14=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage994); if ($this->state->failed) return $value;
            $LANGUAGE_TAG15=$this->match($this->input,$this->getToken('LANGUAGE_TAG'),self::$FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage996); if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_Literal_StringLiteral(($QUOTED_STRING14!=null?$QUOTED_STRING14->getText():null), ($LANGUAGE_TAG15!=null?$LANGUAGE_TAG15->getText():null));
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
    // $ANTLR end "stringLiteralWithLanguage"


    // $ANTLR start "lexicalValue"
    // src/Erfurt_Syntax_Manchester.g:177:1: lexicalValue returns [$value] : QUOTED_STRING ; 
    public function lexicalValue(){
        $value = null;

        $QUOTED_STRING16=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:178:3: ( QUOTED_STRING ) 
            // src/Erfurt_Syntax_Manchester.g:179:3: QUOTED_STRING 
            {
            $QUOTED_STRING16=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_lexicalValue1017); if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = ($QUOTED_STRING16!=null?$QUOTED_STRING16->getText():null);
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
    // $ANTLR end "lexicalValue"


    // $ANTLR start "typedLiteral"
    // src/Erfurt_Syntax_Manchester.g:182:1: typedLiteral returns [$value] : lexicalValue REFERENCE dataType ; 
    public function typedLiteral(){
        $value = null;

        $lexicalValue17 = null;

        $dataType18 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:183:3: ( lexicalValue REFERENCE dataType ) 
            // src/Erfurt_Syntax_Manchester.g:184:3: lexicalValue REFERENCE dataType 
            {
            $this->pushFollow(self::$FOLLOW_lexicalValue_in_typedLiteral1038);
            $lexicalValue17=$this->lexicalValue();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            $this->match($this->input,$this->getToken('REFERENCE'),self::$FOLLOW_REFERENCE_in_typedLiteral1040); if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_dataType_in_typedLiteral1042);
            $dataType18=$this->dataType();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_Literal_TypedLiteral($lexicalValue17, $dataType18);
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
    // $ANTLR end "typedLiteral"


    // $ANTLR start "restrictionValue"
    // src/Erfurt_Syntax_Manchester.g:187:1: restrictionValue returns [$value] : literal ; 
    public function restrictionValue(){
        $value = null;

        $literal19 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:188:3: ( literal ) 
            // src/Erfurt_Syntax_Manchester.g:189:3: literal 
            {
            $this->pushFollow(self::$FOLLOW_literal_in_restrictionValue1063);
            $literal19=$this->literal();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $literal19;
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
    // $ANTLR end "restrictionValue"


    // $ANTLR start "inverseObjectProperty"
    // src/Erfurt_Syntax_Manchester.g:192:1: inverseObjectProperty returns [$value] : INVERSE_LABEL objectPropertyIRI ; 
    public function inverseObjectProperty(){
        $value = null;

        $objectPropertyIRI20 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:193:3: ( INVERSE_LABEL objectPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:194:3: INVERSE_LABEL objectPropertyIRI 
            {
            $this->match($this->input,$this->getToken('INVERSE_LABEL'),self::$FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1084); if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_inverseObjectProperty1086);
            $objectPropertyIRI20=$this->objectPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {

                          $value = new Erfurt_Owl_Structured_ObjectPropertyExpression($objectPropertyIRI20, true);
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
    // $ANTLR end "inverseObjectProperty"


    // $ANTLR start "decimalLiteral"
    // src/Erfurt_Syntax_Manchester.g:198:1: decimalLiteral returns [$value] : DLITERAL_HELPER ; 
    public function decimalLiteral(){
        $value = null;

        $DLITERAL_HELPER21=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:199:3: ( DLITERAL_HELPER ) 
            // src/Erfurt_Syntax_Manchester.g:200:3: DLITERAL_HELPER 
            {
            $DLITERAL_HELPER21=$this->match($this->input,$this->getToken('DLITERAL_HELPER'),self::$FOLLOW_DLITERAL_HELPER_in_decimalLiteral1107); if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_Literal_DecimalLiteral(($DLITERAL_HELPER21!=null?$DLITERAL_HELPER21->getText():null));
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
    // $ANTLR end "decimalLiteral"


    // $ANTLR start "integerLiteral"
    // src/Erfurt_Syntax_Manchester.g:203:1: integerLiteral returns [$value] : (i= ILITERAL_HELPER | i= DIGITS ) ; 
    public function integerLiteral(){
        $value = null;

        $i=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:204:3: ( (i= ILITERAL_HELPER | i= DIGITS ) ) 
            // src/Erfurt_Syntax_Manchester.g:204:5: (i= ILITERAL_HELPER | i= DIGITS ) 
            {
            // src/Erfurt_Syntax_Manchester.g:204:5: (i= ILITERAL_HELPER | i= DIGITS ) 
            $alt22=2;
            $LA22_0 = $this->input->LA(1);

            if ( ($LA22_0==$this->getToken('ILITERAL_HELPER')) ) {
                $alt22=1;
            }
            else if ( ($LA22_0==$this->getToken('DIGITS')) ) {
                $alt22=2;
            }
            else {
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae = new NoViableAltException("", 22, 0, $this->input);

                throw $nvae;
            }
            switch ($alt22) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:204:6: i= ILITERAL_HELPER 
                    {
                    $i=$this->match($this->input,$this->getToken('ILITERAL_HELPER'),self::$FOLLOW_ILITERAL_HELPER_in_integerLiteral1129); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:204:26: i= DIGITS 
                    {
                    $i=$this->match($this->input,$this->getToken('DIGITS'),self::$FOLLOW_DIGITS_in_integerLiteral1135); if ($this->state->failed) return $value;

                    }
                    break;

            }

            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_Literal_IntegerLiteral(($i!=null?$i->getText():null));
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
    // $ANTLR end "integerLiteral"


    // $ANTLR start "floatingPointLiteral"
    // src/Erfurt_Syntax_Manchester.g:207:1: floatingPointLiteral returns [$value] : FPLITERAL_HELPER ; 
    public function floatingPointLiteral(){
        $value = null;

        $FPLITERAL_HELPER22=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:208:3: ( FPLITERAL_HELPER ) 
            // src/Erfurt_Syntax_Manchester.g:209:3: FPLITERAL_HELPER 
            {
            $FPLITERAL_HELPER22=$this->match($this->input,$this->getToken('FPLITERAL_HELPER'),self::$FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1157); if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_Literal_FloatingPointLiteral(($FPLITERAL_HELPER22!=null?$FPLITERAL_HELPER22->getText():null));
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
    // $ANTLR end "floatingPointLiteral"


    // $ANTLR start "objectProperty"
    // src/Erfurt_Syntax_Manchester.g:212:1: objectProperty returns [$value] : objectPropertyIRI ; 
    public function objectProperty(){
        $value = null;

        $objectPropertyIRI23 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:213:3: ( objectPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:214:3: objectPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_objectProperty1178);
            $objectPropertyIRI23=$this->objectPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_ObjectPropertyExpression($objectPropertyIRI23);
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
    // $ANTLR end "objectProperty"


    // $ANTLR start "dataProperty"
    // src/Erfurt_Syntax_Manchester.g:217:1: dataProperty returns [$value] : dataPropertyIRI ; 
    public function dataProperty(){
        $value = null;

        $dataPropertyIRI24 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:218:3: ( dataPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:219:3: dataPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_dataPropertyIRI_in_dataProperty1199);
            $dataPropertyIRI24=$this->dataPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_DataProperty($dataPropertyIRI24);
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
    // $ANTLR end "dataProperty"


    // $ANTLR start "dataPropertyIRI"
    // src/Erfurt_Syntax_Manchester.g:222:1: dataPropertyIRI returns [$value] : iri ; 
    public function dataPropertyIRI(){
        $value = null;

        $iri25 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:223:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:224:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_dataPropertyIRI1220);
            $iri25=$this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $iri25;
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
    // $ANTLR end "dataPropertyIRI"


    // $ANTLR start "datatypeIRI"
    // src/Erfurt_Syntax_Manchester.g:227:1: datatypeIRI returns [$value] : iri ; 
    public function datatypeIRI(){
        $value = null;

        $iri26 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:228:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:229:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_datatypeIRI1241);
            $iri26=$this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $iri26;
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
    // $ANTLR end "datatypeIRI"


    // $ANTLR start "objectPropertyIRI"
    // src/Erfurt_Syntax_Manchester.g:232:1: objectPropertyIRI returns [$value] : iri ; 
    public function objectPropertyIRI(){
        $value = null;

        $iri27 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:233:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:234:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_objectPropertyIRI1262);
            $iri27=$this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $iri27;
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
    // $ANTLR end "objectPropertyIRI"


    // $ANTLR start "dataTypeRestriction"
    // src/Erfurt_Syntax_Manchester.g:237:1: dataTypeRestriction returns [$value] : dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE ; 
    public function dataTypeRestriction(){
        $value = null;

        $f = null;

        $r = null;

        $dataType28 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:238:3: ( dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE ) 
            // src/Erfurt_Syntax_Manchester.g:239:3: dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE 
            {
            $this->pushFollow(self::$FOLLOW_dataType_in_dataTypeRestriction1283);
            $dataType28=$this->dataType();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_DataRange_DatatypeRestriction($dataType28);
            }
            $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1287); if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:240:9: (f= facet r= restrictionValue ( COMMA )? )+ 
            $cnt24=0;
            //loop24:
            do {
                $alt24=2;
                $LA24_0 = $this->input->LA(1);

                if ( (($LA24_0>=$this->getToken('LENGTH_LABEL') && $LA24_0<=$this->getToken('LANG_PATTERN_LABEL'))||($LA24_0>=$this->getToken('LESS_EQUAL') && $LA24_0<=$this->getToken('GREATER'))) ) {
                    $alt24=1;
                }


                switch ($alt24) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:240:11: f= facet r= restrictionValue ( COMMA )? 
            	    {
            	    $this->pushFollow(self::$FOLLOW_facet_in_dataTypeRestriction1301);
            	    $f=$this->facet();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_restrictionValue_in_dataTypeRestriction1305);
            	    $r=$this->restrictionValue();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value -> addRestriction($f, $r);
            	    }
            	    // src/Erfurt_Syntax_Manchester.g:240:87: ( COMMA )? 
            	    $alt23=2;
            	    $LA23_0 = $this->input->LA(1);

            	    if ( ($LA23_0==$this->getToken('COMMA')) ) {
            	        $alt23=1;
            	    }
            	    switch ($alt23) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: COMMA 
            	            {
            	            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataTypeRestriction1309); if ($this->state->failed) return $value;

            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    if ( $cnt24 >= 1 ) break 2;//loop24;
            	    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                        $eee =
                            new EarlyExitException(24, $this->input);
                        throw $eee;
                }
                $cnt24++;
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1316); if ($this->state->failed) return $value;

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
    // $ANTLR end "dataTypeRestriction"


    // $ANTLR start "individualIRI"
    // src/Erfurt_Syntax_Manchester.g:244:1: individualIRI returns [$value] : iri ; 
    public function individualIRI(){
        $value = null;

        $iri29 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:245:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:246:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_individualIRI1335);
            $iri29=$this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $iri29;
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
    // $ANTLR end "individualIRI"


    // $ANTLR start "datatypePropertyIRI"
    // src/Erfurt_Syntax_Manchester.g:249:1: datatypePropertyIRI returns [$value] : iri ; 
    public function datatypePropertyIRI(){
        $value = null;

        $iri30 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:250:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:251:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_datatypePropertyIRI1356);
            $iri30=$this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $iri30;
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
    // $ANTLR end "datatypePropertyIRI"


    // $ANTLR start "facet"
    // src/Erfurt_Syntax_Manchester.g:254:1: facet returns [$value] : (v= LENGTH_LABEL | v= MIN_LENGTH_LABEL | v= MAX_LENGTH_LABEL | v= PATTERN_LABEL | v= LANG_PATTERN_LABEL | v= LESS_EQUAL | v= LESS | v= GREATER_EQUAL | v= GREATER ); 
    public function facet(){
        $value = null;

        $v=null;

        try {
            // src/Erfurt_Syntax_Manchester.g:256:3: (v= LENGTH_LABEL | v= MIN_LENGTH_LABEL | v= MAX_LENGTH_LABEL | v= PATTERN_LABEL | v= LANG_PATTERN_LABEL | v= LESS_EQUAL | v= LESS | v= GREATER_EQUAL | v= GREATER ) 
            $alt25=9;
            $LA25 = $this->input->LA(1);
            if($this->getToken('LENGTH_LABEL')== $LA25)
                {
                $alt25=1;
                }
            else if($this->getToken('MIN_LENGTH_LABEL')== $LA25)
                {
                $alt25=2;
                }
            else if($this->getToken('MAX_LENGTH_LABEL')== $LA25)
                {
                $alt25=3;
                }
            else if($this->getToken('PATTERN_LABEL')== $LA25)
                {
                $alt25=4;
                }
            else if($this->getToken('LANG_PATTERN_LABEL')== $LA25)
                {
                $alt25=5;
                }
            else if($this->getToken('LESS_EQUAL')== $LA25)
                {
                $alt25=6;
                }
            else if($this->getToken('LESS')== $LA25)
                {
                $alt25=7;
                }
            else if($this->getToken('GREATER_EQUAL')== $LA25)
                {
                $alt25=8;
                }
            else if($this->getToken('GREATER')== $LA25)
                {
                $alt25=9;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 25, 0, $this->input);

                throw $nvae;
            }

            switch ($alt25) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:257:3: v= LENGTH_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('LENGTH_LABEL'),self::$FOLLOW_LENGTH_LABEL_in_facet1383); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:257:20: v= MIN_LENGTH_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('MIN_LENGTH_LABEL'),self::$FOLLOW_MIN_LENGTH_LABEL_in_facet1389); if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:257:41: v= MAX_LENGTH_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('MAX_LENGTH_LABEL'),self::$FOLLOW_MAX_LENGTH_LABEL_in_facet1395); if ($this->state->failed) return $value;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:257:62: v= PATTERN_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('PATTERN_LABEL'),self::$FOLLOW_PATTERN_LABEL_in_facet1401); if ($this->state->failed) return $value;

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:257:80: v= LANG_PATTERN_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('LANG_PATTERN_LABEL'),self::$FOLLOW_LANG_PATTERN_LABEL_in_facet1407); if ($this->state->failed) return $value;

                    }
                    break;
                case 6 :
                    // src/Erfurt_Syntax_Manchester.g:257:103: v= LESS_EQUAL 
                    {
                    $v=$this->match($this->input,$this->getToken('LESS_EQUAL'),self::$FOLLOW_LESS_EQUAL_in_facet1413); if ($this->state->failed) return $value;

                    }
                    break;
                case 7 :
                    // src/Erfurt_Syntax_Manchester.g:257:118: v= LESS 
                    {
                    $v=$this->match($this->input,$this->getToken('LESS'),self::$FOLLOW_LESS_in_facet1419); if ($this->state->failed) return $value;

                    }
                    break;
                case 8 :
                    // src/Erfurt_Syntax_Manchester.g:257:127: v= GREATER_EQUAL 
                    {
                    $v=$this->match($this->input,$this->getToken('GREATER_EQUAL'),self::$FOLLOW_GREATER_EQUAL_in_facet1425); if ($this->state->failed) return $value;

                    }
                    break;
                case 9 :
                    // src/Erfurt_Syntax_Manchester.g:257:145: v= GREATER 
                    {
                    $v=$this->match($this->input,$this->getToken('GREATER'),self::$FOLLOW_GREATER_in_facet1431); if ($this->state->failed) return $value;

                    }
                    break;

            }
            if ( $this->state->backtracking==0 ) {
              $value = ($v!=null?$v->getText():null);
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
    // $ANTLR end "facet"


    // $ANTLR start "dataRange"
    // src/Erfurt_Syntax_Manchester.g:260:1: dataRange returns [$value] : d1= dataConjunction ( OR_LABEL d2= dataConjunction )* ; 
    public function dataRange(){
        $value = null;

        $d1 = null;

        $d2 = null;


        $retval = array();
        try {
            // src/Erfurt_Syntax_Manchester.g:266:3: (d1= dataConjunction ( OR_LABEL d2= dataConjunction )* ) 
            // src/Erfurt_Syntax_Manchester.g:267:3: d1= dataConjunction ( OR_LABEL d2= dataConjunction )* 
            {
            $this->pushFollow(self::$FOLLOW_dataConjunction_in_dataRange1460);
            $d1=$this->dataConjunction();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $retval []= $d1;
            }
            // src/Erfurt_Syntax_Manchester.g:268:9: ( OR_LABEL d2= dataConjunction )* 
            //loop26:
            do {
                $alt26=2;
                $LA26_0 = $this->input->LA(1);

                if ( ($LA26_0==$this->getToken('OR_LABEL')) ) {
                    $LA26_2 = $this->input->LA(2);

                    if ( ($this->synpred54_Erfurt_Syntax_Manchester()) ) {
                        $alt26=1;
                    }


                }


                switch ($alt26) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:268:10: OR_LABEL d2= dataConjunction 
            	    {
            	    $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_dataRange1474); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_dataConjunction_in_dataRange1478);
            	    $d2=$this->dataConjunction();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $retval []= $d2;
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop26;
                }
            } while (true);


            }

            if ( $this->state->backtracking==0 ) {

                if(count($retval)>1) $value = new Erfurt_Owl_Structured_DataRange_DataUnionOf($retval);
                else $value = $retval[0];

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
    // $ANTLR end "dataRange"


    // $ANTLR start "dataConjunction"
    // src/Erfurt_Syntax_Manchester.g:271:1: dataConjunction returns [$value] : d1= dataPrimary ( AND_LABEL d2= dataPrimary )* ; 
    public function dataConjunction(){
        $value = null;

        $d1 = null;

        $d2 = null;


        $retval = array();
        try {
            // src/Erfurt_Syntax_Manchester.g:277:3: (d1= dataPrimary ( AND_LABEL d2= dataPrimary )* ) 
            // src/Erfurt_Syntax_Manchester.g:278:3: d1= dataPrimary ( AND_LABEL d2= dataPrimary )* 
            {
            $this->pushFollow(self::$FOLLOW_dataPrimary_in_dataConjunction1511);
            $d1=$this->dataPrimary();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $retval []= $d1;
            }
            // src/Erfurt_Syntax_Manchester.g:279:13: ( AND_LABEL d2= dataPrimary )* 
            //loop27:
            do {
                $alt27=2;
                $LA27_0 = $this->input->LA(1);

                if ( ($LA27_0==$this->getToken('AND_LABEL')) ) {
                    $LA27_2 = $this->input->LA(2);

                    if ( ($this->synpred55_Erfurt_Syntax_Manchester()) ) {
                        $alt27=1;
                    }


                }


                switch ($alt27) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:279:14: AND_LABEL d2= dataPrimary 
            	    {
            	    $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_dataConjunction1528); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_dataPrimary_in_dataConjunction1532);
            	    $d2=$this->dataPrimary();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $retval []= $d2;
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop27;
                }
            } while (true);


            }

            if ( $this->state->backtracking==0 ) {

                if(count($retval)>1) $value = new Erfurt_Owl_Structured_DataRange_DataIntersectionOf($retval);
                else $value = $retval[0];

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
    // $ANTLR end "dataConjunction"


    // $ANTLR start "descriptionAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:302:1: descriptionAnnotatedList returns [$value] : description ; 
    public function descriptionAnnotatedList(){
        $value = null;

        $description31 = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:303:4: ( description ) 
            // src/Erfurt_Syntax_Manchester.g:304:1: description 
            {
            $this->pushFollow(self::$FOLLOW_description_in_descriptionAnnotatedList1575);
            $description31=$this->description();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $description31;
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
    // $ANTLR end "descriptionAnnotatedList"


    // $ANTLR start "classFrame"
    // src/Erfurt_Syntax_Manchester.g:316:1: classFrame returns [$value] : CLASS_LABEL c= classIRI ( SUBCLASS_OF_LABEL s= descriptionAnnotatedList )* ; 
    public function classFrame(){
        $value = null;

        $c = null;

        $s = null;


        try {
            // src/Erfurt_Syntax_Manchester.g:317:3: ( CLASS_LABEL c= classIRI ( SUBCLASS_OF_LABEL s= descriptionAnnotatedList )* ) 
            // src/Erfurt_Syntax_Manchester.g:317:5: CLASS_LABEL c= classIRI ( SUBCLASS_OF_LABEL s= descriptionAnnotatedList )* 
            {
            $this->match($this->input,$this->getToken('CLASS_LABEL'),self::$FOLLOW_CLASS_LABEL_in_classFrame1604); if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_classIRI_in_classFrame1609);
            $c=$this->classIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:319:3: ( SUBCLASS_OF_LABEL s= descriptionAnnotatedList )* 
            //loop28:
            do {
                $alt28=2;
                $LA28_0 = $this->input->LA(1);

                if ( ($LA28_0==$this->getToken('SUBCLASS_OF_LABEL')) ) {
                    $alt28=1;
                }


                switch ($alt28) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:321:1: SUBCLASS_OF_LABEL s= descriptionAnnotatedList 
            	    {
            	    $this->match($this->input,$this->getToken('SUBCLASS_OF_LABEL'),self::$FOLLOW_SUBCLASS_OF_LABEL_in_classFrame1621); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_descriptionAnnotatedList_in_classFrame1625);
            	    $s=$this->descriptionAnnotatedList();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value = new Erfurt_Owl_Structured_ClassAxiom_SubClassOf($c, $s);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop28;
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
    // $ANTLR end "classFrame"

    // $ANTLR start synpred15_Erfurt_Syntax_Manchester
    public function synpred15_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:73:3: (o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) ) 
        // src/Erfurt_Syntax_Manchester.g:73:3: o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) 
        {
        $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_synpred15_Erfurt_Syntax_Manchester271);
        $o=$this->objectPropertyExpression();

        $this->state->_fsp--;
        if ($this->state->failed) return ;
        // src/Erfurt_Syntax_Manchester.g:74:5: ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) 
        $alt29=7;
        $LA29 = $this->input->LA(1);
        if($this->getToken('SOME_LABEL')== $LA29)
            {
            $alt29=1;
            }
        else if($this->getToken('ONLY_LABEL')== $LA29)
            {
            $alt29=2;
            }
        else if($this->getToken('VALUE_LABEL')== $LA29)
            {
            $alt29=3;
            }
        else if($this->getToken('SELF_LABEL')== $LA29)
            {
            $alt29=4;
            }
        else if($this->getToken('MIN_LABEL')== $LA29)
            {
            $alt29=5;
            }
        else if($this->getToken('MAX_LABEL')== $LA29)
            {
            $alt29=6;
            }
        else if($this->getToken('EXACTLY_LABEL')== $LA29)
            {
            $alt29=7;
            }
        else{
            if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
            $nvae =
                new NoViableAltException("", 29, 0, $this->input);

            throw $nvae;
        }

        switch ($alt29) {
            case 1 :
                // src/Erfurt_Syntax_Manchester.g:74:6: ( SOME_LABEL p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:74:6: ( SOME_LABEL p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:74:7: SOME_LABEL p= primary 
                {
                $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_synpred15_Erfurt_Syntax_Manchester279); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester283);
                $p=$this->primary();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 2 :
                // src/Erfurt_Syntax_Manchester.g:75:7: ( ONLY_LABEL p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:75:7: ( ONLY_LABEL p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:75:8: ONLY_LABEL p= primary 
                {
                $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester295); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester299);
                $p=$this->primary();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 3 :
                // src/Erfurt_Syntax_Manchester.g:76:7: ( VALUE_LABEL i= individual ) 
                {
                // src/Erfurt_Syntax_Manchester.g:76:7: ( VALUE_LABEL i= individual ) 
                // src/Erfurt_Syntax_Manchester.g:76:8: VALUE_LABEL i= individual 
                {
                $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_synpred15_Erfurt_Syntax_Manchester311); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_individual_in_synpred15_Erfurt_Syntax_Manchester315);
                $i=$this->individual();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 4 :
                // src/Erfurt_Syntax_Manchester.g:77:7: ( SELF_LABEL ) 
                {
                // src/Erfurt_Syntax_Manchester.g:77:7: ( SELF_LABEL ) 
                // src/Erfurt_Syntax_Manchester.g:77:8: SELF_LABEL 
                {
                $this->match($this->input,$this->getToken('SELF_LABEL'),self::$FOLLOW_SELF_LABEL_in_synpred15_Erfurt_Syntax_Manchester327); if ($this->state->failed) return ;

                }


                }
                break;
            case 5 :
                // src/Erfurt_Syntax_Manchester.g:78:7: ( MIN_LABEL nni= nonNegativeInteger p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:78:7: ( MIN_LABEL nni= nonNegativeInteger p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:78:8: MIN_LABEL nni= nonNegativeInteger p= primary 
                {
                $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_synpred15_Erfurt_Syntax_Manchester339); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester343);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester347);
                $p=$this->primary();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 6 :
                // src/Erfurt_Syntax_Manchester.g:79:7: ( MAX_LABEL nni= nonNegativeInteger p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:79:7: ( MAX_LABEL nni= nonNegativeInteger p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:79:8: MAX_LABEL nni= nonNegativeInteger p= primary 
                {
                $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_synpred15_Erfurt_Syntax_Manchester359); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester363);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester367);
                $p=$this->primary();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 7 :
                // src/Erfurt_Syntax_Manchester.g:80:7: ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:80:7: ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:80:8: EXACTLY_LABEL nni= nonNegativeInteger p= primary 
                {
                $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester379); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester383);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester387);
                $p=$this->primary();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;

        }


        }
    }
    // $ANTLR end synpred15_Erfurt_Syntax_Manchester

    // $ANTLR start synpred24_Erfurt_Syntax_Manchester
    public function synpred24_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:82:5: (dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) ) 
        // src/Erfurt_Syntax_Manchester.g:82:5: dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) 
        {
        $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_synpred24_Erfurt_Syntax_Manchester402);
        $dp=$this->dataPropertyExpression();

        $this->state->_fsp--;
        if ($this->state->failed) return ;
        // src/Erfurt_Syntax_Manchester.g:82:30: ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) 
        $alt35=6;
        $LA35 = $this->input->LA(1);
        if($this->getToken('SOME_LABEL')== $LA35)
            {
            $alt35=1;
            }
        else if($this->getToken('ONLY_LABEL')== $LA35)
            {
            $alt35=2;
            }
        else if($this->getToken('VALUE_LABEL')== $LA35)
            {
            $alt35=3;
            }
        else if($this->getToken('MIN_LABEL')== $LA35)
            {
            $alt35=4;
            }
        else if($this->getToken('MAX_LABEL')== $LA35)
            {
            $alt35=5;
            }
        else if($this->getToken('EXACTLY_LABEL')== $LA35)
            {
            $alt35=6;
            }
        else{
            if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
            $nvae =
                new NoViableAltException("", 35, 0, $this->input);

            throw $nvae;
        }

        switch ($alt35) {
            case 1 :
                // src/Erfurt_Syntax_Manchester.g:83:5: ( SOME_LABEL d= dataRange ) 
                {
                // src/Erfurt_Syntax_Manchester.g:83:5: ( SOME_LABEL d= dataRange ) 
                // src/Erfurt_Syntax_Manchester.g:83:6: SOME_LABEL d= dataRange 
                {
                $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_synpred24_Erfurt_Syntax_Manchester410); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester414);
                $d=$this->dataRange();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 2 :
                // src/Erfurt_Syntax_Manchester.g:84:5: ( ONLY_LABEL d= dataRange ) 
                {
                // src/Erfurt_Syntax_Manchester.g:84:5: ( ONLY_LABEL d= dataRange ) 
                // src/Erfurt_Syntax_Manchester.g:84:6: ONLY_LABEL d= dataRange 
                {
                $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester424); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester428);
                $d=$this->dataRange();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 3 :
                // src/Erfurt_Syntax_Manchester.g:85:5: ( VALUE_LABEL l= literal ) 
                {
                // src/Erfurt_Syntax_Manchester.g:85:5: ( VALUE_LABEL l= literal ) 
                // src/Erfurt_Syntax_Manchester.g:85:6: VALUE_LABEL l= literal 
                {
                $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_synpred24_Erfurt_Syntax_Manchester438); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_literal_in_synpred24_Erfurt_Syntax_Manchester442);
                $l=$this->literal();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 4 :
                // src/Erfurt_Syntax_Manchester.g:86:5: ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                {
                // src/Erfurt_Syntax_Manchester.g:86:5: ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                // src/Erfurt_Syntax_Manchester.g:86:6: MIN_LABEL nni= nonNegativeInteger (d= dataRange )? 
                {
                $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_synpred24_Erfurt_Syntax_Manchester451); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester455);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:86:40: (d= dataRange )? 
                $alt32=2;
                $LA32_0 = $this->input->LA(1);

                if ( ($LA32_0==$this->getToken('NOT_LABEL')||$LA32_0==$this->getToken('OPEN_CURLY_BRACE')||$LA32_0==$this->getToken('OPEN_BRACE')||($LA32_0>=$this->getToken('DECIMAL_LABEL') && $LA32_0<=$this->getToken('STRING_LABEL'))||($LA32_0>=$this->getToken('FULL_IRI') && $LA32_0<=$this->getToken('SIMPLE_IRI'))||$LA32_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt32=1;
                }
                switch ($alt32) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                        {
                        $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester459);
                        $d=$this->dataRange();

                        $this->state->_fsp--;
                        if ($this->state->failed) return ;

                        }
                        break;

                }


                }


                }
                break;
            case 5 :
                // src/Erfurt_Syntax_Manchester.g:87:5: ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                {
                // src/Erfurt_Syntax_Manchester.g:87:5: ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                // src/Erfurt_Syntax_Manchester.g:87:6: MAX_LABEL nni= nonNegativeInteger (d= dataRange )? 
                {
                $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_synpred24_Erfurt_Syntax_Manchester470); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester474);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:87:40: (d= dataRange )? 
                $alt33=2;
                $LA33_0 = $this->input->LA(1);

                if ( ($LA33_0==$this->getToken('NOT_LABEL')||$LA33_0==$this->getToken('OPEN_CURLY_BRACE')||$LA33_0==$this->getToken('OPEN_BRACE')||($LA33_0>=$this->getToken('DECIMAL_LABEL') && $LA33_0<=$this->getToken('STRING_LABEL'))||($LA33_0>=$this->getToken('FULL_IRI') && $LA33_0<=$this->getToken('SIMPLE_IRI'))||$LA33_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt33=1;
                }
                switch ($alt33) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                        {
                        $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester478);
                        $d=$this->dataRange();

                        $this->state->_fsp--;
                        if ($this->state->failed) return ;

                        }
                        break;

                }


                }


                }
                break;
            case 6 :
                // src/Erfurt_Syntax_Manchester.g:88:5: ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                {
                // src/Erfurt_Syntax_Manchester.g:88:5: ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                // src/Erfurt_Syntax_Manchester.g:88:6: EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? 
                {
                $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester489); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester493);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:88:44: (d= dataRange )? 
                $alt34=2;
                $LA34_0 = $this->input->LA(1);

                if ( ($LA34_0==$this->getToken('NOT_LABEL')||$LA34_0==$this->getToken('OPEN_CURLY_BRACE')||$LA34_0==$this->getToken('OPEN_BRACE')||($LA34_0>=$this->getToken('DECIMAL_LABEL') && $LA34_0<=$this->getToken('STRING_LABEL'))||($LA34_0>=$this->getToken('FULL_IRI') && $LA34_0<=$this->getToken('SIMPLE_IRI'))||$LA34_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt34=1;
                }
                switch ($alt34) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                        {
                        $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester497);
                        $d=$this->dataRange();

                        $this->state->_fsp--;
                        if ($this->state->failed) return ;

                        }
                        break;

                }


                }


                }
                break;

        }


        }
    }
    // $ANTLR end synpred24_Erfurt_Syntax_Manchester

    // $ANTLR start synpred54_Erfurt_Syntax_Manchester
    public function synpred54_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:268:10: ( OR_LABEL d2= dataConjunction ) 
        // src/Erfurt_Syntax_Manchester.g:268:10: OR_LABEL d2= dataConjunction 
        {
        $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_synpred54_Erfurt_Syntax_Manchester1474); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_dataConjunction_in_synpred54_Erfurt_Syntax_Manchester1478);
        $d2=$this->dataConjunction();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred54_Erfurt_Syntax_Manchester

    // $ANTLR start synpred55_Erfurt_Syntax_Manchester
    public function synpred55_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:279:14: ( AND_LABEL d2= dataPrimary ) 
        // src/Erfurt_Syntax_Manchester.g:279:14: AND_LABEL d2= dataPrimary 
        {
        $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_synpred55_Erfurt_Syntax_Manchester1528); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_dataPrimary_in_synpred55_Erfurt_Syntax_Manchester1532);
        $d2=$this->dataPrimary();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred55_Erfurt_Syntax_Manchester

    // Delegated rules

    public function synpred24_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred24_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred55_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred55_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred54_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred54_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred15_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred15_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }


    
}

class Erfurt_Syntax_ManchesterParser_DFA18_static {
	static function getValues(){
		$eot = array(12, 65535);
		$eof = array(1, 65535, 7, 11, 4, 65535);
		$min = array(1, 23, 7, 25, 4, 65535);
		$max = array(1, 58, 7, 51, 4, 65535);
		$accept = array(8, 65535, 1, 2, 1, 4, 1, 3, 1, 1);
		$special = array(12, 65535);
		$transitionS = array(array(1, 8, 11, 65535, 1, 9, 1, 65535, 1, 5, 1, 6, 
    1, 4, 1, 7, 7, 65535, 1, 1, 1, 3, 8, 65535, 1, 2), array(2, 11, 9, 65535, 
    1, 11, 5, 65535, 1, 11, 8, 65535, 1, 10), array(2, 11, 9, 65535, 1, 
    11, 5, 65535, 1, 11, 8, 65535, 1, 10), array(2, 11, 9, 65535, 1, 11, 
    5, 65535, 1, 11, 8, 65535, 1, 10), array(2, 11, 9, 65535, 1, 11, 5, 
    65535, 1, 11, 8, 65535, 1, 10), array(2, 11, 9, 65535, 1, 11, 5, 65535, 
    1, 11, 8, 65535, 1, 10), array(2, 11, 9, 65535, 1, 11, 5, 65535, 1, 
    11, 8, 65535, 1, 10), array(2, 11, 9, 65535, 1, 11, 5, 65535, 1, 11, 
    8, 65535, 1, 10), array(), array(), array(), array());
		
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
//$Erfurt_Syntax_ManchesterParser_DFA18 = Erfurt_Syntax_ManchesterParser_DFA18_static();

class Erfurt_Syntax_ManchesterParser_DFA18 extends DFA {

    public function __construct($recognizer) {
//        global $Erfurt_Syntax_ManchesterParser_DFA18;
//        $DFA = $Erfurt_Syntax_ManchesterParser_DFA18;
		$DFA = Erfurt_Syntax_ManchesterParser_DFA18_static::getValues();
        $this->recognizer = $recognizer;
        $this->decisionNumber = 18;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "136:1: dataAtomic returns [$value] : ( ( dataType ) | ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) | ( dataTypeRestriction ) | ( OPEN_BRACE dataRange CLOSE_BRACE ) );";
    }
}
 



Erfurt_Syntax_ManchesterParser::$FOLLOW_conjunction_in_description59 = new Set(array(1, 25));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_description72 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_conjunction_in_description76 = new Set(array(1, 25));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_conjunction110 = new Set(array(10));
Erfurt_Syntax_ManchesterParser::$FOLLOW_THAT_LABEL_in_conjunction112 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_conjunction120 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_conjunction129 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_conjunction133 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NOT_LABEL_in_primary159 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_restriction_in_primary166 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_atomic_in_primary172 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FULL_IRI_in_iri201 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ABBREVIATED_IRI_in_iri209 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SIMPLE_IRI_in_iri217 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_objectPropertyExpression242 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_inverseObjectProperty_in_objectPropertyExpression250 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_restriction271 = new Set(array(27, 28, 29, 30, 31, 32, 33));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_restriction279 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction283 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_restriction295 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction299 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_restriction311 = new Set(array(48, 49, 50, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_restriction315 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SELF_LABEL_in_restriction327 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_restriction339 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction343 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction347 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_restriction359 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction363 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction367 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_restriction379 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction383 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction387 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_restriction402 = new Set(array(27, 28, 29, 31, 32, 33));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_restriction410 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction414 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_restriction424 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction428 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_restriction438 = new Set(array(15, 54, 59, 60, 61));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_restriction442 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_restriction451 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction455 = new Set(array(1, 16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction459 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_restriction470 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction474 = new Set(array(1, 16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction478 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_restriction489 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction493 = new Set(array(1, 16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction497 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_restriction524 = new Set(array(33));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_restriction526 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction530 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_atomic552 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_CURLY_BRACE_in_atomic560 = new Set(array(48, 49, 50, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualList_in_atomic562 = new Set(array(24));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_CURLY_BRACE_in_atomic564 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_atomic572 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_description_in_atomic574 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_atomic576 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_classIRI597 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualList620 = new Set(array(1, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_individualList629 = new Set(array(48, 49, 50, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualList633 = new Set(array(1, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualIRI_in_individual658 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NODE_ID_in_individual666 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DIGITS_in_nonNegativeInteger687 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NOT_LABEL_in_dataPrimary711 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataAtomic_in_dataPrimary715 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyIRI_in_dataPropertyExpression738 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_dataAtomic760 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic770 = new Set(array(15, 54, 59, 60, 61));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literalList_in_dataAtomic772 = new Set(array(24));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic774 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataTypeRestriction_in_dataAtomic784 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_dataAtomic794 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_dataAtomic796 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_dataAtomic798 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_literalList822 = new Set(array(1, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_literalList829 = new Set(array(15, 54, 59, 60, 61));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_literalList833 = new Set(array(1, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_datatypeIRI_in_dataType856 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_INTEGER_LABEL_in_dataType866 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DECIMAL_LABEL_in_dataType877 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FLOAT_LABEL_in_dataType887 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_STRING_LABEL_in_dataType897 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_typedLiteral_in_literal924 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_stringLiteralNoLanguage_in_literal930 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_stringLiteralWithLanguage_in_literal936 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_integerLiteral_in_literal942 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_decimalLiteral_in_literal948 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_floatingPointLiteral_in_literal954 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage973 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage994 = new Set(array(55));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage996 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_lexicalValue1017 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_lexicalValue_in_typedLiteral1038 = new Set(array(41));
Erfurt_Syntax_ManchesterParser::$FOLLOW_REFERENCE_in_typedLiteral1040 = new Set(array(37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_typedLiteral1042 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_restrictionValue1063 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1084 = new Set(array(48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_inverseObjectProperty1086 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DLITERAL_HELPER_in_decimalLiteral1107 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ILITERAL_HELPER_in_integerLiteral1129 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DIGITS_in_integerLiteral1135 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1157 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_objectProperty1178 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyIRI_in_dataProperty1199 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_dataPropertyIRI1220 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_datatypeIRI1241 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_objectPropertyIRI1262 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_dataTypeRestriction1283 = new Set(array(51));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1287 = new Set(array(5, 6, 7, 8, 9, 19, 20, 21, 22));
Erfurt_Syntax_ManchesterParser::$FOLLOW_facet_in_dataTypeRestriction1301 = new Set(array(15, 54, 59, 60, 61));
Erfurt_Syntax_ManchesterParser::$FOLLOW_restrictionValue_in_dataTypeRestriction1305 = new Set(array(5, 6, 7, 8, 9, 19, 20, 21, 22, 34, 52));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataTypeRestriction1309 = new Set(array(5, 6, 7, 8, 9, 19, 20, 21, 22, 52));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1316 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_individualIRI1335 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_datatypePropertyIRI1356 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LENGTH_LABEL_in_facet1383 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LENGTH_LABEL_in_facet1389 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LENGTH_LABEL_in_facet1395 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_PATTERN_LABEL_in_facet1401 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LANG_PATTERN_LABEL_in_facet1407 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LESS_EQUAL_in_facet1413 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LESS_in_facet1419 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_GREATER_EQUAL_in_facet1425 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_GREATER_in_facet1431 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_dataRange1460 = new Set(array(1, 25));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_dataRange1474 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_dataRange1478 = new Set(array(1, 25));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_dataConjunction1511 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_dataConjunction1528 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_dataConjunction1532 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_description_in_descriptionAnnotatedList1575 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLASS_LABEL_in_classFrame1604 = new Set(array(48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_classFrame1609 = new Set(array(1, 42));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SUBCLASS_OF_LABEL_in_classFrame1621 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_descriptionAnnotatedList_in_classFrame1625 = new Set(array(1, 42));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_synpred15_Erfurt_Syntax_Manchester271 = new Set(array(27, 28, 29, 30, 31, 32, 33));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_synpred15_Erfurt_Syntax_Manchester279 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester283 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester295 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester299 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_synpred15_Erfurt_Syntax_Manchester311 = new Set(array(48, 49, 50, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_synpred15_Erfurt_Syntax_Manchester315 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SELF_LABEL_in_synpred15_Erfurt_Syntax_Manchester327 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_synpred15_Erfurt_Syntax_Manchester339 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester343 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester347 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_synpred15_Erfurt_Syntax_Manchester359 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester363 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester367 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester379 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester383 = new Set(array(11, 16, 23, 35, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester387 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_synpred24_Erfurt_Syntax_Manchester402 = new Set(array(27, 28, 29, 31, 32, 33));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_synpred24_Erfurt_Syntax_Manchester410 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester414 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester424 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester428 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_synpred24_Erfurt_Syntax_Manchester438 = new Set(array(15, 54, 59, 60, 61));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_synpred24_Erfurt_Syntax_Manchester442 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_synpred24_Erfurt_Syntax_Manchester451 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester455 = new Set(array(1, 16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester459 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_synpred24_Erfurt_Syntax_Manchester470 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester474 = new Set(array(1, 16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester478 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester489 = new Set(array(15));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester493 = new Set(array(1, 16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester497 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_synpred54_Erfurt_Syntax_Manchester1474 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_synpred54_Erfurt_Syntax_Manchester1478 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_synpred55_Erfurt_Syntax_Manchester1528 = new Set(array(16, 23, 35, 37, 38, 39, 40, 48, 49, 58));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_synpred55_Erfurt_Syntax_Manchester1532 = new Set(array(1));

?>