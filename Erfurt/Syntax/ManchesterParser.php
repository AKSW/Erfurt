<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 src/Erfurt_Syntax_Manchester.g 2010-10-07 19:37:06


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class Erfurt_Syntax_ManchesterParser extends AntlrParser {
    public static $tokenNames = array(
        "<invalid>", "<EOR>", "<DOWN>", "<UP>", "O_LABEL", "F_LABEL", "LENGTH_LABEL", "MIN_LENGTH_LABEL", "MAX_LENGTH_LABEL", "PATTERN_LABEL", "LANG_PATTERN_LABEL", "THAT_LABEL", "INVERSE_LABEL", "MINUS", "DOT", "PLUS", "DIGITS", "NOT_LABEL", "EOL", "WS", "LESS_EQUAL", "GREATER_EQUAL", "LESS", "GREATER", "OPEN_CURLY_BRACE", "CLOSE_CURLY_BRACE", "OR_LABEL", "AND_LABEL", "SOME_LABEL", "ONLY_LABEL", "VALUE_LABEL", "SELF_LABEL", "MIN_LABEL", "MAX_LABEL", "EXACTLY_LABEL", "COMMA", "OPEN_BRACE", "CLOSE_BRACE", "DECIMAL_LABEL", "FLOAT_LABEL", "INTEGER_LABEL", "STRING_LABEL", "REFERENCE", "RANGE_LABEL", "CHARACTERISTICS_LABEL", "SUB_PROPERTY_OF_LABEL", "SUB_PROPERTY_CHAIN_LABEL", "OBJECT_PROPERTY_LABEL", "DATA_PROPERTY_LABEL", "ANNOTATION_PROPERTY_LABEL", "NAMED_INDIVIDUAL_LABEL", "PREFIX_LABEL", "ONTOLOGY_LABEL", "INDIVIDUAL_LABEL", "TYPES_LABEL", "FACTS_LABEL", "SAME_AS_LABEL", "DIFFERENET_FROM_LABEL", "DATATYPE_LABEL", "EQUIVALENT_CLASSES_LABEL", "DISJOINT_CLASSES_LABEL", "EQUIVALENT_PROPERTIES_LABEL", "DISJOINT_PROPERTIES_LABEL", "SAME_INDIVIDUAL_LABEL", "DIFFERENT_INDIVIDUALS_LABEL", "EQUIVALENT_TO_LABEL", "SUBCLASS_OF_LABEL", "DISJOINT_WITH_LABEL", "DISJOINT_UNION_OF_LABEL", "HAS_KEY_LABEL", "INVERSE_OF_LABEL", "IMPORT_LABEL", "ANNOTATIONS_LABEL", "CLASS_LABEL", "FUNCTIONAL_LABEL", "OBJECT_PROPERTY_CHARACTERISTIC", "DOMAIN_LABEL", "PN_CHARS", "PN_PREFIX", "PN_CHARS_BASE", "PN_CHARS_U", "FULL_IRI", "SIMPLE_IRI", "NODE_ID", "OPEN_SQUARE_BRACE", "CLOSE_SQUARE_BRACE", "ECHAR", "QUOTED_STRING", "LANGUAGE_TAG", "EXPONENT", "PREFIX_NAME", "ABBREVIATED_IRI", "ILITERAL_HELPER", "DLITERAL_HELPER", "FPLITERAL_HELPER", "ITFUCKINDOESNTWORK"
    );
    public $EXPONENT=89;
    public $CLOSE_SQUARE_BRACE=85;
    public $DECIMAL_LABEL=38;
    public $ONLY_LABEL=29;
    public $FPLITERAL_HELPER=94;
    public $DISJOINT_CLASSES_LABEL=60;
    public $SUBCLASS_OF_LABEL=66;
    public $INDIVIDUAL_LABEL=53;
    public $EOF=-1;
    public $LANG_PATTERN_LABEL=10;
    public $DISJOINT_UNION_OF_LABEL=68;
    public $ANNOTATION_PROPERTY_LABEL=49;
    public $FLOAT_LABEL=39;
    public $FACTS_LABEL=55;
    public $DISJOINT_PROPERTIES_LABEL=62;
    public $CHARACTERISTICS_LABEL=44;
    public $ABBREVIATED_IRI=91;
    public $DATA_PROPERTY_LABEL=48;
    public $INTEGER_LABEL=40;
    public $GREATER=23;
    public $EOL=18;
    public $OR_LABEL=26;
    public $EQUIVALENT_TO_LABEL=65;
    public $DISJOINT_WITH_LABEL=67;
    public $OBJECT_PROPERTY_LABEL=47;
    public $ANNOTATIONS_LABEL=72;
    public $LESS=22;
    public $ONTOLOGY_LABEL=52;
    public $PN_CHARS_U=80;
    public $OPEN_CURLY_BRACE=24;
    public $CLOSE_CURLY_BRACE=25;
    public $PATTERN_LABEL=9;
    public $SIMPLE_IRI=82;
    public $FULL_IRI=81;
    public $NODE_ID=83;
    public $ITFUCKINDOESNTWORK=95;
    public $NAMED_INDIVIDUAL_LABEL=50;
    public $WS=19;
    public $DIFFERENET_FROM_LABEL=57;
    public $SELF_LABEL=31;
    public $PN_CHARS=77;
    public $EXACTLY_LABEL=34;
    public $LESS_EQUAL=20;
    public $LANGUAGE_TAG=88;
    public $TYPES_LABEL=54;
    public $MAX_LENGTH_LABEL=8;
    public $IMPORT_LABEL=71;
    public $DIGITS=16;
    public $MAX_LABEL=33;
    public $SUB_PROPERTY_OF_LABEL=45;
    public $STRING_LABEL=41;
    public $INVERSE_OF_LABEL=70;
    public $FUNCTIONAL_LABEL=74;
    public $DATATYPE_LABEL=58;
    public $EQUIVALENT_CLASSES_LABEL=59;
    public $INVERSE_LABEL=12;
    public $DIFFERENT_INDIVIDUALS_LABEL=64;
    public $F_LABEL=5;
    public $COMMA=35;
    public $SUB_PROPERTY_CHAIN_LABEL=46;
    public $HAS_KEY_LABEL=69;
    public $PLUS=15;
    public $QUOTED_STRING=87;
    public $PREFIX_LABEL=51;
    public $SAME_AS_LABEL=56;
    public $SAME_INDIVIDUAL_LABEL=63;
    public $DOT=14;
    public $DLITERAL_HELPER=93;
    public $EQUIVALENT_PROPERTIES_LABEL=61;
    public $PREFIX_NAME=90;
    public $AND_LABEL=27;
    public $REFERENCE=42;
    public $CLOSE_BRACE=37;
    public $ILITERAL_HELPER=92;
    public $SOME_LABEL=28;
    public $LENGTH_LABEL=6;
    public $MINUS=13;
    public $OPEN_SQUARE_BRACE=84;
    public $RANGE_LABEL=43;
    public $ECHAR=86;
    public $DOMAIN_LABEL=76;
    public $O_LABEL=4;
    public $MIN_LABEL=32;
    public $OBJECT_PROPERTY_CHARACTERISTIC=75;
    public $PN_CHARS_BASE=79;
    public $CLASS_LABEL=73;
    public $THAT_LABEL=11;
    public $NOT_LABEL=17;
    public $PN_PREFIX=78;
    public $MIN_LENGTH_LABEL=7;
    public $VALUE_LABEL=30;
    public $OPEN_BRACE=36;
    public $GREATER_EQUAL=21;

    // delegates
    // delegators

    
    static $FOLLOW_conjunction_in_description69;
    static $FOLLOW_OR_LABEL_in_description82;
    static $FOLLOW_conjunction_in_description86;
    static $FOLLOW_classIRI_in_conjunction116;
    static $FOLLOW_THAT_LABEL_in_conjunction118;
    static $FOLLOW_primary_in_conjunction126;
    static $FOLLOW_AND_LABEL_in_conjunction135;
    static $FOLLOW_primary_in_conjunction139;
    static $FOLLOW_NOT_LABEL_in_primary165;
    static $FOLLOW_restriction_in_primary172;
    static $FOLLOW_atomic_in_primary178;
    static $FOLLOW_FULL_IRI_in_iri207;
    static $FOLLOW_ABBREVIATED_IRI_in_iri215;
    static $FOLLOW_SIMPLE_IRI_in_iri223;
    static $FOLLOW_objectPropertyIRI_in_objectPropertyExpression248;
    static $FOLLOW_inverseObjectProperty_in_objectPropertyExpression256;
    static $FOLLOW_objectPropertyExpression_in_restriction277;
    static $FOLLOW_SOME_LABEL_in_restriction285;
    static $FOLLOW_primary_in_restriction289;
    static $FOLLOW_ONLY_LABEL_in_restriction301;
    static $FOLLOW_primary_in_restriction305;
    static $FOLLOW_VALUE_LABEL_in_restriction317;
    static $FOLLOW_individual_in_restriction321;
    static $FOLLOW_SELF_LABEL_in_restriction333;
    static $FOLLOW_MIN_LABEL_in_restriction345;
    static $FOLLOW_nonNegativeInteger_in_restriction349;
    static $FOLLOW_primary_in_restriction353;
    static $FOLLOW_MAX_LABEL_in_restriction366;
    static $FOLLOW_nonNegativeInteger_in_restriction370;
    static $FOLLOW_primary_in_restriction374;
    static $FOLLOW_EXACTLY_LABEL_in_restriction387;
    static $FOLLOW_nonNegativeInteger_in_restriction391;
    static $FOLLOW_primary_in_restriction395;
    static $FOLLOW_dataPropertyExpression_in_restriction411;
    static $FOLLOW_SOME_LABEL_in_restriction419;
    static $FOLLOW_dataRange_in_restriction423;
    static $FOLLOW_ONLY_LABEL_in_restriction433;
    static $FOLLOW_dataRange_in_restriction437;
    static $FOLLOW_VALUE_LABEL_in_restriction447;
    static $FOLLOW_literal_in_restriction451;
    static $FOLLOW_MIN_LABEL_in_restriction460;
    static $FOLLOW_nonNegativeInteger_in_restriction464;
    static $FOLLOW_dataRange_in_restriction468;
    static $FOLLOW_MAX_LABEL_in_restriction479;
    static $FOLLOW_nonNegativeInteger_in_restriction483;
    static $FOLLOW_dataRange_in_restriction487;
    static $FOLLOW_EXACTLY_LABEL_in_restriction498;
    static $FOLLOW_nonNegativeInteger_in_restriction502;
    static $FOLLOW_dataRange_in_restriction506;
    static $FOLLOW_classIRI_in_atomic539;
    static $FOLLOW_OPEN_CURLY_BRACE_in_atomic547;
    static $FOLLOW_individualList_in_atomic549;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_atomic551;
    static $FOLLOW_OPEN_BRACE_in_atomic559;
    static $FOLLOW_description_in_atomic561;
    static $FOLLOW_CLOSE_BRACE_in_atomic563;
    static $FOLLOW_iri_in_classIRI584;
    static $FOLLOW_individual_in_individualList607;
    static $FOLLOW_COMMA_in_individualList616;
    static $FOLLOW_individual_in_individualList620;
    static $FOLLOW_individualIRI_in_individual645;
    static $FOLLOW_NODE_ID_in_individual653;
    static $FOLLOW_DIGITS_in_nonNegativeInteger674;
    static $FOLLOW_NOT_LABEL_in_dataPrimary698;
    static $FOLLOW_dataAtomic_in_dataPrimary702;
    static $FOLLOW_dataPropertyIRI_in_dataPropertyExpression725;
    static $FOLLOW_dataType_in_dataAtomic747;
    static $FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic757;
    static $FOLLOW_literalList_in_dataAtomic759;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic761;
    static $FOLLOW_dataTypeRestriction_in_dataAtomic771;
    static $FOLLOW_OPEN_BRACE_in_dataAtomic781;
    static $FOLLOW_dataRange_in_dataAtomic783;
    static $FOLLOW_CLOSE_BRACE_in_dataAtomic785;
    static $FOLLOW_literal_in_literalList809;
    static $FOLLOW_COMMA_in_literalList816;
    static $FOLLOW_literal_in_literalList820;
    static $FOLLOW_datatypeIRI_in_dataType843;
    static $FOLLOW_INTEGER_LABEL_in_dataType853;
    static $FOLLOW_DECIMAL_LABEL_in_dataType864;
    static $FOLLOW_FLOAT_LABEL_in_dataType874;
    static $FOLLOW_STRING_LABEL_in_dataType884;
    static $FOLLOW_typedLiteral_in_literal911;
    static $FOLLOW_stringLiteralNoLanguage_in_literal917;
    static $FOLLOW_stringLiteralWithLanguage_in_literal923;
    static $FOLLOW_integerLiteral_in_literal929;
    static $FOLLOW_decimalLiteral_in_literal935;
    static $FOLLOW_floatingPointLiteral_in_literal941;
    static $FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage960;
    static $FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage981;
    static $FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage983;
    static $FOLLOW_QUOTED_STRING_in_lexicalValue1004;
    static $FOLLOW_lexicalValue_in_typedLiteral1025;
    static $FOLLOW_REFERENCE_in_typedLiteral1027;
    static $FOLLOW_dataType_in_typedLiteral1029;
    static $FOLLOW_literal_in_restrictionValue1050;
    static $FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1071;
    static $FOLLOW_objectPropertyIRI_in_inverseObjectProperty1073;
    static $FOLLOW_DLITERAL_HELPER_in_decimalLiteral1094;
    static $FOLLOW_ILITERAL_HELPER_in_integerLiteral1116;
    static $FOLLOW_DIGITS_in_integerLiteral1122;
    static $FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1144;
    static $FOLLOW_objectPropertyIRI_in_objectProperty1165;
    static $FOLLOW_dataPropertyIRI_in_dataProperty1186;
    static $FOLLOW_iri_in_dataPropertyIRI1207;
    static $FOLLOW_iri_in_datatypeIRI1228;
    static $FOLLOW_iri_in_objectPropertyIRI1249;
    static $FOLLOW_dataType_in_dataTypeRestriction1270;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1274;
    static $FOLLOW_facet_in_dataTypeRestriction1288;
    static $FOLLOW_restrictionValue_in_dataTypeRestriction1292;
    static $FOLLOW_COMMA_in_dataTypeRestriction1296;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1303;
    static $FOLLOW_iri_in_individualIRI1322;
    static $FOLLOW_iri_in_datatypePropertyIRI1343;
    static $FOLLOW_LENGTH_LABEL_in_facet1370;
    static $FOLLOW_MIN_LENGTH_LABEL_in_facet1376;
    static $FOLLOW_MAX_LENGTH_LABEL_in_facet1382;
    static $FOLLOW_PATTERN_LABEL_in_facet1388;
    static $FOLLOW_LANG_PATTERN_LABEL_in_facet1394;
    static $FOLLOW_LESS_EQUAL_in_facet1400;
    static $FOLLOW_LESS_in_facet1406;
    static $FOLLOW_GREATER_EQUAL_in_facet1412;
    static $FOLLOW_GREATER_in_facet1418;
    static $FOLLOW_dataConjunction_in_dataRange1439;
    static $FOLLOW_OR_LABEL_in_dataRange1453;
    static $FOLLOW_dataConjunction_in_dataRange1457;
    static $FOLLOW_dataPrimary_in_dataConjunction1482;
    static $FOLLOW_AND_LABEL_in_dataConjunction1499;
    static $FOLLOW_dataPrimary_in_dataConjunction1503;
    static $FOLLOW_annotations_in_annotationAnnotatedList1526;
    static $FOLLOW_annotation_in_annotationAnnotatedList1529;
    static $FOLLOW_COMMA_in_annotationAnnotatedList1532;
    static $FOLLOW_annotations_in_annotationAnnotatedList1534;
    static $FOLLOW_annotation_in_annotationAnnotatedList1537;
    static $FOLLOW_annotationPropertyIRI_in_annotation1556;
    static $FOLLOW_annotationTarget_in_annotation1560;
    static $FOLLOW_NODE_ID_in_annotationTarget1577;
    static $FOLLOW_iri_in_annotationTarget1584;
    static $FOLLOW_literal_in_annotationTarget1591;
    static $FOLLOW_ANNOTATIONS_LABEL_in_annotations1608;
    static $FOLLOW_annotationAnnotatedList_in_annotations1612;
    static $FOLLOW_description_in_descriptionList1643;
    static $FOLLOW_COMMA_in_descriptionList1648;
    static $FOLLOW_description_in_descriptionList1652;
    static $FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1695;
    static $FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1698;
    static $FOLLOW_COMMA_in_objectPropertyCharacteristicAnnotatedList1701;
    static $FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1703;
    static $FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1706;
    static $FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1721;
    static $FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1724;
    static $FOLLOW_COMMA_in_objectPropertyExpressionAnnotatedList1727;
    static $FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1729;
    static $FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1732;
    static $FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1766;
    static $FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1769;
    static $FOLLOW_COMMA_in_dataPropertyExpressionAnnotatedList1772;
    static $FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1774;
    static $FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1777;
    static $FOLLOW_ANNOTATION_PROPERTY_LABEL_in_annotationPropertyFrame1794;
    static $FOLLOW_annotationPropertyIRI_in_annotationPropertyFrame1796;
    static $FOLLOW_ANNOTATIONS_LABEL_in_annotationPropertyFrame1802;
    static $FOLLOW_annotationAnnotatedList_in_annotationPropertyFrame1805;
    static $FOLLOW_DOMAIN_LABEL_in_annotationPropertyFrame1814;
    static $FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1817;
    static $FOLLOW_RANGE_LABEL_in_annotationPropertyFrame1823;
    static $FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1826;
    static $FOLLOW_SUB_PROPERTY_OF_LABEL_in_annotationPropertyFrame1832;
    static $FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyFrame1834;
    static $FOLLOW_annotations_in_iriAnnotatedList1849;
    static $FOLLOW_iri_in_iriAnnotatedList1852;
    static $FOLLOW_COMMA_in_iriAnnotatedList1855;
    static $FOLLOW_annotations_in_iriAnnotatedList1857;
    static $FOLLOW_iri_in_iriAnnotatedList1860;
    static $FOLLOW_iri_in_annotationPropertyIRI1879;
    static $FOLLOW_annotations_in_annotationPropertyIRIAnnotatedList1895;
    static $FOLLOW_annotationPropertyIRI_in_annotationPropertyIRIAnnotatedList1898;
    static $FOLLOW_COMMA_in_annotationPropertyIRIAnnotatedList1901;
    static $FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyIRIAnnotatedList1903;
    static $FOLLOW_annotations_in_factAnnotatedList1932;
    static $FOLLOW_fact_in_factAnnotatedList1935;
    static $FOLLOW_COMMA_in_factAnnotatedList1938;
    static $FOLLOW_annotations_in_factAnnotatedList1940;
    static $FOLLOW_fact_in_factAnnotatedList1943;
    static $FOLLOW_annotations_in_individualAnnotatedList1962;
    static $FOLLOW_individual_in_individualAnnotatedList1965;
    static $FOLLOW_COMMA_in_individualAnnotatedList1968;
    static $FOLLOW_annotations_in_individualAnnotatedList1970;
    static $FOLLOW_individual_in_individualAnnotatedList1973;
    static $FOLLOW_NOT_LABEL_in_fact1987;
    static $FOLLOW_objectPropertyFact_in_fact1991;
    static $FOLLOW_dataPropertyFact_in_fact1995;
    static $FOLLOW_objectPropertyIRI_in_objectPropertyFact2006;
    static $FOLLOW_individual_in_objectPropertyFact2008;
    static $FOLLOW_dataPropertyIRI_in_dataPropertyFact2022;
    static $FOLLOW_literal_in_dataPropertyFact2024;
    static $FOLLOW_DATATYPE_LABEL_in_datatypeFrame2038;
    static $FOLLOW_dataType_in_datatypeFrame2041;
    static $FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2047;
    static $FOLLOW_annotationAnnotatedList_in_datatypeFrame2050;
    static $FOLLOW_EQUIVALENT_TO_LABEL_in_datatypeFrame2058;
    static $FOLLOW_annotations_in_datatypeFrame2061;
    static $FOLLOW_dataRange_in_datatypeFrame2063;
    static $FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2071;
    static $FOLLOW_annotationAnnotatedList_in_datatypeFrame2074;
    static $FOLLOW_individual_in_individual2List2099;
    static $FOLLOW_COMMA_in_individual2List2101;
    static $FOLLOW_individualList_in_individual2List2103;
    static $FOLLOW_dataProperty_in_dataProperty2List2115;
    static $FOLLOW_COMMA_in_dataProperty2List2117;
    static $FOLLOW_dataPropertyList_in_dataProperty2List2119;
    static $FOLLOW_dataProperty_in_dataPropertyList2133;
    static $FOLLOW_COMMA_in_dataPropertyList2136;
    static $FOLLOW_dataProperty_in_dataPropertyList2138;
    static $FOLLOW_objectProperty_in_objectProperty2List2154;
    static $FOLLOW_COMMA_in_objectProperty2List2156;
    static $FOLLOW_objectPropertyList_in_objectProperty2List2158;
    static $FOLLOW_objectProperty_in_objectPropertyList2172;
    static $FOLLOW_COMMA_in_objectPropertyList2175;
    static $FOLLOW_objectProperty_in_objectPropertyList2177;
    static $FOLLOW_DATATYPE_LABEL_in_entity2203;
    static $FOLLOW_OPEN_BRACE_in_entity2205;
    static $FOLLOW_dataType_in_entity2207;
    static $FOLLOW_CLOSE_BRACE_in_entity2209;
    static $FOLLOW_CLASS_LABEL_in_entity2215;
    static $FOLLOW_OPEN_BRACE_in_entity2217;
    static $FOLLOW_classIRI_in_entity2219;
    static $FOLLOW_CLOSE_BRACE_in_entity2221;
    static $FOLLOW_OBJECT_PROPERTY_LABEL_in_entity2227;
    static $FOLLOW_OPEN_BRACE_in_entity2229;
    static $FOLLOW_objectPropertyIRI_in_entity2231;
    static $FOLLOW_CLOSE_BRACE_in_entity2233;
    static $FOLLOW_DATA_PROPERTY_LABEL_in_entity2239;
    static $FOLLOW_OPEN_BRACE_in_entity2241;
    static $FOLLOW_datatypePropertyIRI_in_entity2243;
    static $FOLLOW_CLOSE_BRACE_in_entity2245;
    static $FOLLOW_ANNOTATION_PROPERTY_LABEL_in_entity2251;
    static $FOLLOW_OPEN_BRACE_in_entity2253;
    static $FOLLOW_annotationPropertyIRI_in_entity2255;
    static $FOLLOW_CLOSE_BRACE_in_entity2257;
    static $FOLLOW_NAMED_INDIVIDUAL_LABEL_in_entity2263;
    static $FOLLOW_OPEN_BRACE_in_entity2265;
    static $FOLLOW_individualIRI_in_entity2267;
    static $FOLLOW_CLOSE_BRACE_in_entity2269;
    static $FOLLOW_iri_in_ontologyIri2286;
    static $FOLLOW_iri_in_versionIri2297;
    static $FOLLOW_IMPORT_LABEL_in_imports2307;
    static $FOLLOW_iri_in_imports2309;
    static $FOLLOW_objectPropertyExpression_in_synpred18_Erfurt_Syntax_Manchester277;
    static $FOLLOW_SOME_LABEL_in_synpred18_Erfurt_Syntax_Manchester285;
    static $FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester289;
    static $FOLLOW_ONLY_LABEL_in_synpred18_Erfurt_Syntax_Manchester301;
    static $FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester305;
    static $FOLLOW_VALUE_LABEL_in_synpred18_Erfurt_Syntax_Manchester317;
    static $FOLLOW_individual_in_synpred18_Erfurt_Syntax_Manchester321;
    static $FOLLOW_SELF_LABEL_in_synpred18_Erfurt_Syntax_Manchester333;
    static $FOLLOW_MIN_LABEL_in_synpred18_Erfurt_Syntax_Manchester345;
    static $FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester349;
    static $FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester353;
    static $FOLLOW_MAX_LABEL_in_synpred18_Erfurt_Syntax_Manchester366;
    static $FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester370;
    static $FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester374;
    static $FOLLOW_EXACTLY_LABEL_in_synpred18_Erfurt_Syntax_Manchester387;
    static $FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester391;
    static $FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester395;
    static $FOLLOW_OR_LABEL_in_synpred56_Erfurt_Syntax_Manchester1453;
    static $FOLLOW_dataConjunction_in_synpred56_Erfurt_Syntax_Manchester1457;
    static $FOLLOW_AND_LABEL_in_synpred57_Erfurt_Syntax_Manchester1499;
    static $FOLLOW_dataPrimary_in_synpred57_Erfurt_Syntax_Manchester1503;
    static $FOLLOW_annotations_in_synpred58_Erfurt_Syntax_Manchester1526;
    static $FOLLOW_annotations_in_synpred59_Erfurt_Syntax_Manchester1534;
    static $FOLLOW_annotations_in_synpred65_Erfurt_Syntax_Manchester1695;
    static $FOLLOW_annotations_in_synpred66_Erfurt_Syntax_Manchester1703;
    static $FOLLOW_annotations_in_synpred68_Erfurt_Syntax_Manchester1721;
    static $FOLLOW_annotations_in_synpred69_Erfurt_Syntax_Manchester1729;
    static $FOLLOW_annotations_in_synpred71_Erfurt_Syntax_Manchester1766;
    static $FOLLOW_annotations_in_synpred72_Erfurt_Syntax_Manchester1774;
    static $FOLLOW_annotations_in_synpred78_Erfurt_Syntax_Manchester1849;
    static $FOLLOW_annotations_in_synpred79_Erfurt_Syntax_Manchester1857;
    static $FOLLOW_annotations_in_synpred81_Erfurt_Syntax_Manchester1895;
    static $FOLLOW_COMMA_in_synpred82_Erfurt_Syntax_Manchester1901;
    static $FOLLOW_annotationPropertyIRIAnnotatedList_in_synpred82_Erfurt_Syntax_Manchester1903;
    static $FOLLOW_annotations_in_synpred83_Erfurt_Syntax_Manchester1932;
    static $FOLLOW_annotations_in_synpred84_Erfurt_Syntax_Manchester1940;
    static $FOLLOW_annotations_in_synpred86_Erfurt_Syntax_Manchester1962;
    static $FOLLOW_annotations_in_synpred87_Erfurt_Syntax_Manchester1970;
    static $FOLLOW_ANNOTATIONS_LABEL_in_synpred91_Erfurt_Syntax_Manchester2047;
    static $FOLLOW_annotationAnnotatedList_in_synpred91_Erfurt_Syntax_Manchester2050;

    
    protected $dfa21;
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
            $this->state->ruleMemo = array();
             
            for ($i=0; $i < 164; $i++) { 
                $this->state->ruleMemo[$i] = array();				
            }
             
            
            $this->dfa21 = new Erfurt_Syntax_ManchesterParser_DFA21($this);
            
        }
        

    public function getTokenNames() { return Erfurt_Syntax_ManchesterParser::$tokenNames; }
    public function getGrammarFileName() { return "src/Erfurt_Syntax_Manchester.g"; }



    // $ANTLR start "description"
    // src/Erfurt_Syntax_Manchester.g:15:1: description returns [$value] : c1= conjunction ( OR_LABEL c2= conjunction )* ; 
    public function description(){
        $value = null;
        $description_StartIndex = $this->input->index();
        $c1 = null;

        $c2 = null;



        $value = new Erfurt_Owl_Structured_ClassExpression_ObjectUnionOf();

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 1) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:19:3: (c1= conjunction ( OR_LABEL c2= conjunction )* ) 
            // src/Erfurt_Syntax_Manchester.g:20:3: c1= conjunction ( OR_LABEL c2= conjunction )* 
            {
            $this->pushFollow(self::$FOLLOW_conjunction_in_description69);
            $c1=$this->conjunction();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value->addElement($c1);
            }
            // src/Erfurt_Syntax_Manchester.g:21:9: ( OR_LABEL c2= conjunction )* 
            //loop1:
            do {
                $alt1=2;
                $LA1_0 = $this->input->LA(1);

                if ( ($LA1_0==$this->getToken('OR_LABEL')) ) {
                    $alt1=1;
                }


                switch ($alt1) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:21:10: OR_LABEL c2= conjunction 
            	    {
            	    $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_description82); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_conjunction_in_description86);
            	    $c2=$this->conjunction();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($c2);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop1;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 1, $description_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 1, $description_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "description"


    // $ANTLR start "conjunction"
    // src/Erfurt_Syntax_Manchester.g:24:1: conjunction returns [$value] : (c= classIRI THAT_LABEL )? p1= primary ( AND_LABEL p2= primary )* ; 
    public function conjunction(){
        $value = null;
        $conjunction_StartIndex = $this->input->index();
        $c = null;

        $p1 = null;

        $p2 = null;


        $value = new Erfurt_Owl_Structured_ClassExpression_ObjectIntersectionOf();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 2) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:26:3: ( (c= classIRI THAT_LABEL )? p1= primary ( AND_LABEL p2= primary )* ) 
            // src/Erfurt_Syntax_Manchester.g:27:3: (c= classIRI THAT_LABEL )? p1= primary ( AND_LABEL p2= primary )* 
            {
            // src/Erfurt_Syntax_Manchester.g:27:3: (c= classIRI THAT_LABEL )? 
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
                    // src/Erfurt_Syntax_Manchester.g:27:4: c= classIRI THAT_LABEL 
                    {
                    $this->pushFollow(self::$FOLLOW_classIRI_in_conjunction116);
                    $c=$this->classIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('THAT_LABEL'),self::$FOLLOW_THAT_LABEL_in_conjunction118); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value->addElement($c);
                    }

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_primary_in_conjunction126);
            $p1=$this->primary();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {

                          $value->addElement($p1);
            }
            // src/Erfurt_Syntax_Manchester.g:29:5: ( AND_LABEL p2= primary )* 
            //loop3:
            do {
                $alt3=2;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('AND_LABEL')) ) {
                    $alt3=1;
                }


                switch ($alt3) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:29:6: AND_LABEL p2= primary 
            	    {
            	    $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_conjunction135); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_primary_in_conjunction139);
            	    $p2=$this->primary();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($p2);
            	    }

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 2, $conjunction_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 2, $conjunction_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "conjunction"


    // $ANTLR start "primary"
    // src/Erfurt_Syntax_Manchester.g:32:1: primary returns [$value] : (n= NOT_LABEL )? (v= restriction | v= atomic ) ; 
    public function primary(){
        $value = null;
        $primary_StartIndex = $this->input->index();
        $n=null;
        $v = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 3) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:33:3: ( (n= NOT_LABEL )? (v= restriction | v= atomic ) ) 
            // src/Erfurt_Syntax_Manchester.g:34:3: (n= NOT_LABEL )? (v= restriction | v= atomic ) 
            {
            // src/Erfurt_Syntax_Manchester.g:34:3: (n= NOT_LABEL )? 
            $alt4=2;
            $LA4_0 = $this->input->LA(1);

            if ( ($LA4_0==$this->getToken('NOT_LABEL')) ) {
                $alt4=1;
            }
            switch ($alt4) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:34:4: n= NOT_LABEL 
                    {
                    $n=$this->match($this->input,$this->getToken('NOT_LABEL'),self::$FOLLOW_NOT_LABEL_in_primary165); if ($this->state->failed) return $value;

                    }
                    break;

            }

            // src/Erfurt_Syntax_Manchester.g:34:18: (v= restriction | v= atomic ) 
            $alt5=2;
            $LA5 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA5)
                {
                $LA5_1 = $this->input->LA(2);

                if ( (($LA5_1>=$this->getToken('SOME_LABEL') && $LA5_1<=$this->getToken('EXACTLY_LABEL'))) ) {
                    $alt5=1;
                }
                else if ( ($LA5_1==$this->getToken('EOF')||($LA5_1>=$this->getToken('OR_LABEL') && $LA5_1<=$this->getToken('AND_LABEL'))||$LA5_1==$this->getToken('COMMA')||$LA5_1==$this->getToken('CLOSE_BRACE')) ) {
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

                if ( ($LA5_2==$this->getToken('EOF')||($LA5_2>=$this->getToken('OR_LABEL') && $LA5_2<=$this->getToken('AND_LABEL'))||$LA5_2==$this->getToken('COMMA')||$LA5_2==$this->getToken('CLOSE_BRACE')) ) {
                    $alt5=2;
                }
                else if ( (($LA5_2>=$this->getToken('SOME_LABEL') && $LA5_2<=$this->getToken('EXACTLY_LABEL'))) ) {
                    $alt5=1;
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

                if ( ($LA5_3==$this->getToken('EOF')||($LA5_3>=$this->getToken('OR_LABEL') && $LA5_3<=$this->getToken('AND_LABEL'))||$LA5_3==$this->getToken('COMMA')||$LA5_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt5=2;
                }
                else if ( (($LA5_3>=$this->getToken('SOME_LABEL') && $LA5_3<=$this->getToken('EXACTLY_LABEL'))) ) {
                    $alt5=1;
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
                    // src/Erfurt_Syntax_Manchester.g:34:19: v= restriction 
                    {
                    $this->pushFollow(self::$FOLLOW_restriction_in_primary172);
                    $v=$this->restriction();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:34:35: v= atomic 
                    {
                    $this->pushFollow(self::$FOLLOW_atomic_in_primary178);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 3, $primary_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 3, $primary_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "primary"


    // $ANTLR start "iri"
    // src/Erfurt_Syntax_Manchester.g:40:1: iri returns [$value] : (v= FULL_IRI | v= ABBREVIATED_IRI | v= SIMPLE_IRI ); 
    public function iri(){
        $value = null;
        $iri_StartIndex = $this->input->index();
        $v=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 4) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:44:3: (v= FULL_IRI | v= ABBREVIATED_IRI | v= SIMPLE_IRI ) 
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
                    // src/Erfurt_Syntax_Manchester.g:45:3: v= FULL_IRI 
                    {
                    $v=$this->match($this->input,$this->getToken('FULL_IRI'),self::$FOLLOW_FULL_IRI_in_iri207); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:46:5: v= ABBREVIATED_IRI 
                    {
                    $v=$this->match($this->input,$this->getToken('ABBREVIATED_IRI'),self::$FOLLOW_ABBREVIATED_IRI_in_iri215); if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:47:5: v= SIMPLE_IRI 
                    {
                    $v=$this->match($this->input,$this->getToken('SIMPLE_IRI'),self::$FOLLOW_SIMPLE_IRI_in_iri223); if ($this->state->failed) return $value;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 4, $iri_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 4, $iri_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "iri"


    // $ANTLR start "objectPropertyExpression"
    // src/Erfurt_Syntax_Manchester.g:50:1: objectPropertyExpression returns [$value] : (v= objectPropertyIRI | v= inverseObjectProperty ); 
    public function objectPropertyExpression(){
        $value = null;
        $objectPropertyExpression_StartIndex = $this->input->index();
        $v = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 5) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:52:3: (v= objectPropertyIRI | v= inverseObjectProperty ) 
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
                    // src/Erfurt_Syntax_Manchester.g:53:3: v= objectPropertyIRI 
                    {
                    $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_objectPropertyExpression248);
                    $v=$this->objectPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:54:5: v= inverseObjectProperty 
                    {
                    $this->pushFollow(self::$FOLLOW_inverseObjectProperty_in_objectPropertyExpression256);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 5, $objectPropertyExpression_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 5, $objectPropertyExpression_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "objectPropertyExpression"


    // $ANTLR start "restriction"
    // src/Erfurt_Syntax_Manchester.g:57:1: restriction returns [$value] : (o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) | ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) ) | dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) ); 
    public function restriction(){
        $value = null;
        $restriction_StartIndex = $this->input->index();
        $o = null;

        $p = null;

        $i = null;

        $nni = null;

        $dp = null;

        $d = null;

        $l = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 6) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:58:3: (o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) | ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) ) | dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) ) 
            $alt16=2;
            $LA16 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA16)
                {
                $LA16_1 = $this->input->LA(2);

                if ( ($this->synpred18_Erfurt_Syntax_Manchester()) ) {
                    $alt16=1;
                }
                else if ( (true) ) {
                    $alt16=2;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 16, 1, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA16)
                {
                $LA16_2 = $this->input->LA(2);

                if ( ($this->synpred18_Erfurt_Syntax_Manchester()) ) {
                    $alt16=1;
                }
                else if ( (true) ) {
                    $alt16=2;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 16, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA16)
                {
                $LA16_3 = $this->input->LA(2);

                if ( ($this->synpred18_Erfurt_Syntax_Manchester()) ) {
                    $alt16=1;
                }
                else if ( (true) ) {
                    $alt16=2;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae = new NoViableAltException("", 16, 3, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('INVERSE_LABEL')== $LA16)
                {
                $alt16=1;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 16, 0, $this->input);

                throw $nvae;
            }

            switch ($alt16) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:59:3: o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) | ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) ) 
                    {
                    $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_restriction277);
                    $o=$this->objectPropertyExpression();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    // src/Erfurt_Syntax_Manchester.g:60:5: ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) | ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) ) 
                    $alt11=7;
                    $LA11 = $this->input->LA(1);
                    if($this->getToken('SOME_LABEL')== $LA11)
                        {
                        $alt11=1;
                        }
                    else if($this->getToken('ONLY_LABEL')== $LA11)
                        {
                        $alt11=2;
                        }
                    else if($this->getToken('VALUE_LABEL')== $LA11)
                        {
                        $alt11=3;
                        }
                    else if($this->getToken('SELF_LABEL')== $LA11)
                        {
                        $alt11=4;
                        }
                    else if($this->getToken('MIN_LABEL')== $LA11)
                        {
                        $alt11=5;
                        }
                    else if($this->getToken('MAX_LABEL')== $LA11)
                        {
                        $alt11=6;
                        }
                    else if($this->getToken('EXACTLY_LABEL')== $LA11)
                        {
                        $alt11=7;
                        }
                    else{
                        if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                        $nvae =
                            new NoViableAltException("", 11, 0, $this->input);

                        throw $nvae;
                    }

                    switch ($alt11) {
                        case 1 :
                            // src/Erfurt_Syntax_Manchester.g:60:6: ( SOME_LABEL p= primary ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:60:6: ( SOME_LABEL p= primary ) 
                            // src/Erfurt_Syntax_Manchester.g:60:7: SOME_LABEL p= primary 
                            {
                            $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_restriction285); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction289);
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
                            // src/Erfurt_Syntax_Manchester.g:61:7: ( ONLY_LABEL p= primary ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:61:7: ( ONLY_LABEL p= primary ) 
                            // src/Erfurt_Syntax_Manchester.g:61:8: ONLY_LABEL p= primary 
                            {
                            $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_restriction301); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction305);
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
                            // src/Erfurt_Syntax_Manchester.g:62:7: ( VALUE_LABEL i= individual ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:62:7: ( VALUE_LABEL i= individual ) 
                            // src/Erfurt_Syntax_Manchester.g:62:8: VALUE_LABEL i= individual 
                            {
                            $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_restriction317); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_individual_in_restriction321);
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
                            // src/Erfurt_Syntax_Manchester.g:63:7: ( SELF_LABEL ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:63:7: ( SELF_LABEL ) 
                            // src/Erfurt_Syntax_Manchester.g:63:8: SELF_LABEL 
                            {
                            $this->match($this->input,$this->getToken('SELF_LABEL'),self::$FOLLOW_SELF_LABEL_in_restriction333); if ($this->state->failed) return $value;
                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectHasSelf($o);
                            }

                            }


                            }
                            break;
                        case 5 :
                            // src/Erfurt_Syntax_Manchester.g:64:7: ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:64:7: ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) 
                            // src/Erfurt_Syntax_Manchester.g:64:8: MIN_LABEL nni= nonNegativeInteger (p= primary )? 
                            {
                            $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_restriction345); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction349);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:64:42: (p= primary )? 
                            $alt8=2;
                            $LA8_0 = $this->input->LA(1);

                            if ( ($LA8_0==$this->getToken('INVERSE_LABEL')||$LA8_0==$this->getToken('NOT_LABEL')||$LA8_0==$this->getToken('OPEN_CURLY_BRACE')||$LA8_0==$this->getToken('OPEN_BRACE')||($LA8_0>=$this->getToken('FULL_IRI') && $LA8_0<=$this->getToken('SIMPLE_IRI'))||$LA8_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt8=1;
                            }
                            switch ($alt8) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: p= primary 
                                    {
                                    $this->pushFollow(self::$FOLLOW_primary_in_restriction353);
                                    $p=$this->primary();

                                    $this->state->_fsp--;
                                    if ($this->state->failed) return $value;

                                    }
                                    break;

                            }

                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectMinCardinality($o, $nni, isset($p)?$p:null);
                            }

                            }


                            }
                            break;
                        case 6 :
                            // src/Erfurt_Syntax_Manchester.g:65:7: ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:65:7: ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) 
                            // src/Erfurt_Syntax_Manchester.g:65:8: MAX_LABEL nni= nonNegativeInteger (p= primary )? 
                            {
                            $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_restriction366); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction370);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:65:42: (p= primary )? 
                            $alt9=2;
                            $LA9_0 = $this->input->LA(1);

                            if ( ($LA9_0==$this->getToken('INVERSE_LABEL')||$LA9_0==$this->getToken('NOT_LABEL')||$LA9_0==$this->getToken('OPEN_CURLY_BRACE')||$LA9_0==$this->getToken('OPEN_BRACE')||($LA9_0>=$this->getToken('FULL_IRI') && $LA9_0<=$this->getToken('SIMPLE_IRI'))||$LA9_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt9=1;
                            }
                            switch ($alt9) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: p= primary 
                                    {
                                    $this->pushFollow(self::$FOLLOW_primary_in_restriction374);
                                    $p=$this->primary();

                                    $this->state->_fsp--;
                                    if ($this->state->failed) return $value;

                                    }
                                    break;

                            }

                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_ObjectPropertyRestriction_ObjectMaxCardinality($o, $nni, isset($p)?$p:null);
                            }

                            }


                            }
                            break;
                        case 7 :
                            // src/Erfurt_Syntax_Manchester.g:66:7: ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:66:7: ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) 
                            // src/Erfurt_Syntax_Manchester.g:66:8: EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? 
                            {
                            $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_restriction387); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction391);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:66:46: (p= primary )? 
                            $alt10=2;
                            $LA10_0 = $this->input->LA(1);

                            if ( ($LA10_0==$this->getToken('INVERSE_LABEL')||$LA10_0==$this->getToken('NOT_LABEL')||$LA10_0==$this->getToken('OPEN_CURLY_BRACE')||$LA10_0==$this->getToken('OPEN_BRACE')||($LA10_0>=$this->getToken('FULL_IRI') && $LA10_0<=$this->getToken('SIMPLE_IRI'))||$LA10_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt10=1;
                            }
                            switch ($alt10) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: p= primary 
                                    {
                                    $this->pushFollow(self::$FOLLOW_primary_in_restriction395);
                                    $p=$this->primary();

                                    $this->state->_fsp--;
                                    if ($this->state->failed) return $value;

                                    }
                                    break;

                            }

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
                    // src/Erfurt_Syntax_Manchester.g:68:5: dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) 
                    {
                    $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_restriction411);
                    $dp=$this->dataPropertyExpression();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    // src/Erfurt_Syntax_Manchester.g:68:30: ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) 
                    $alt15=6;
                    $LA15 = $this->input->LA(1);
                    if($this->getToken('SOME_LABEL')== $LA15)
                        {
                        $alt15=1;
                        }
                    else if($this->getToken('ONLY_LABEL')== $LA15)
                        {
                        $alt15=2;
                        }
                    else if($this->getToken('VALUE_LABEL')== $LA15)
                        {
                        $alt15=3;
                        }
                    else if($this->getToken('MIN_LABEL')== $LA15)
                        {
                        $alt15=4;
                        }
                    else if($this->getToken('MAX_LABEL')== $LA15)
                        {
                        $alt15=5;
                        }
                    else if($this->getToken('EXACTLY_LABEL')== $LA15)
                        {
                        $alt15=6;
                        }
                    else{
                        if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                        $nvae =
                            new NoViableAltException("", 15, 0, $this->input);

                        throw $nvae;
                    }

                    switch ($alt15) {
                        case 1 :
                            // src/Erfurt_Syntax_Manchester.g:69:5: ( SOME_LABEL d= dataRange ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:69:5: ( SOME_LABEL d= dataRange ) 
                            // src/Erfurt_Syntax_Manchester.g:69:6: SOME_LABEL d= dataRange 
                            {
                            $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_restriction419); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_dataRange_in_restriction423);
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
                            // src/Erfurt_Syntax_Manchester.g:70:5: ( ONLY_LABEL d= dataRange ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:70:5: ( ONLY_LABEL d= dataRange ) 
                            // src/Erfurt_Syntax_Manchester.g:70:6: ONLY_LABEL d= dataRange 
                            {
                            $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_restriction433); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_dataRange_in_restriction437);
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
                            // src/Erfurt_Syntax_Manchester.g:71:5: ( VALUE_LABEL l= literal ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:71:5: ( VALUE_LABEL l= literal ) 
                            // src/Erfurt_Syntax_Manchester.g:71:6: VALUE_LABEL l= literal 
                            {
                            $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_restriction447); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_literal_in_restriction451);
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
                            // src/Erfurt_Syntax_Manchester.g:72:5: ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:72:5: ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            // src/Erfurt_Syntax_Manchester.g:72:6: MIN_LABEL nni= nonNegativeInteger (d= dataRange )? 
                            {
                            $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_restriction460); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction464);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:72:40: (d= dataRange )? 
                            $alt12=2;
                            $LA12_0 = $this->input->LA(1);

                            if ( ($LA12_0==$this->getToken('NOT_LABEL')||$LA12_0==$this->getToken('OPEN_CURLY_BRACE')||$LA12_0==$this->getToken('OPEN_BRACE')||($LA12_0>=$this->getToken('DECIMAL_LABEL') && $LA12_0<=$this->getToken('STRING_LABEL'))||($LA12_0>=$this->getToken('FULL_IRI') && $LA12_0<=$this->getToken('SIMPLE_IRI'))||$LA12_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt12=1;
                            }
                            switch ($alt12) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                                    {
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction468);
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
                            // src/Erfurt_Syntax_Manchester.g:73:5: ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:73:5: ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            // src/Erfurt_Syntax_Manchester.g:73:6: MAX_LABEL nni= nonNegativeInteger (d= dataRange )? 
                            {
                            $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_restriction479); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction483);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:73:40: (d= dataRange )? 
                            $alt13=2;
                            $LA13_0 = $this->input->LA(1);

                            if ( ($LA13_0==$this->getToken('NOT_LABEL')||$LA13_0==$this->getToken('OPEN_CURLY_BRACE')||$LA13_0==$this->getToken('OPEN_BRACE')||($LA13_0>=$this->getToken('DECIMAL_LABEL') && $LA13_0<=$this->getToken('STRING_LABEL'))||($LA13_0>=$this->getToken('FULL_IRI') && $LA13_0<=$this->getToken('SIMPLE_IRI'))||$LA13_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt13=1;
                            }
                            switch ($alt13) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                                    {
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction487);
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
                            // src/Erfurt_Syntax_Manchester.g:74:5: ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            {
                            // src/Erfurt_Syntax_Manchester.g:74:5: ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) 
                            // src/Erfurt_Syntax_Manchester.g:74:6: EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? 
                            {
                            $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_restriction498); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction502);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            // src/Erfurt_Syntax_Manchester.g:74:44: (d= dataRange )? 
                            $alt14=2;
                            $LA14_0 = $this->input->LA(1);

                            if ( ($LA14_0==$this->getToken('NOT_LABEL')||$LA14_0==$this->getToken('OPEN_CURLY_BRACE')||$LA14_0==$this->getToken('OPEN_BRACE')||($LA14_0>=$this->getToken('DECIMAL_LABEL') && $LA14_0<=$this->getToken('STRING_LABEL'))||($LA14_0>=$this->getToken('FULL_IRI') && $LA14_0<=$this->getToken('SIMPLE_IRI'))||$LA14_0==$this->getToken('ABBREVIATED_IRI')) ) {
                                $alt14=1;
                            }
                            switch ($alt14) {
                                case 1 :
                                    // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                                    {
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction506);
                                    $d=$this->dataRange();

                                    $this->state->_fsp--;
                                    if ($this->state->failed) return $value;

                                    }
                                    break;

                            }

                            if ( $this->state->backtracking==0 ) {
                              $value = new Erfurt_Owl_Structured_DataPropertyRestriction_DataExactCardinality($dp, $nni, isset($d)?$d:null);
                            }

                            }


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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 6, $restriction_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 6, $restriction_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "restriction"


    // $ANTLR start "atomic"
    // src/Erfurt_Syntax_Manchester.g:78:1: atomic returns [$value] : ( classIRI | OPEN_CURLY_BRACE individualList CLOSE_CURLY_BRACE | OPEN_BRACE description CLOSE_BRACE ); 
    public function atomic(){
        $value = null;
        $atomic_StartIndex = $this->input->index();
        $classIRI1 = null;

        $individualList2 = null;

        $description3 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 7) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:79:3: ( classIRI | OPEN_CURLY_BRACE individualList CLOSE_CURLY_BRACE | OPEN_BRACE description CLOSE_BRACE ) 
            $alt17=3;
            $LA17 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA17||$this->getToken('SIMPLE_IRI')== $LA17||$this->getToken('ABBREVIATED_IRI')== $LA17)
                {
                $alt17=1;
                }
            else if($this->getToken('OPEN_CURLY_BRACE')== $LA17)
                {
                $alt17=2;
                }
            else if($this->getToken('OPEN_BRACE')== $LA17)
                {
                $alt17=3;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 17, 0, $this->input);

                throw $nvae;
            }

            switch ($alt17) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:80:3: classIRI 
                    {
                    $this->pushFollow(self::$FOLLOW_classIRI_in_atomic539);
                    $classIRI1=$this->classIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_OwlClass($classIRI1);
                    }

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:81:5: OPEN_CURLY_BRACE individualList CLOSE_CURLY_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_atomic547); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_individualList_in_atomic549);
                    $individualList2=$this->individualList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_atomic551); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_ClassExpression_ObjectOneOf($individualList2);
                    }

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:82:5: OPEN_BRACE description CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_atomic559); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_description_in_atomic561);
                    $description3=$this->description();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_atomic563); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 7, $atomic_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 7, $atomic_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "atomic"


    // $ANTLR start "classIRI"
    // src/Erfurt_Syntax_Manchester.g:85:1: classIRI returns [$value] : iri ; 
    public function classIRI(){
        $value = null;
        $classIRI_StartIndex = $this->input->index();
        $iri4 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 8) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:86:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:87:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_classIRI584);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 8, $classIRI_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 8, $classIRI_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "classIRI"


    // $ANTLR start "individualList"
    // src/Erfurt_Syntax_Manchester.g:90:1: individualList returns [$value] : i= individual ( COMMA i1= individual )* ; 
    public function individualList(){
        $value = null;
        $individualList_StartIndex = $this->input->index();
        $i = null;

        $i1 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 9) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:91:3: (i= individual ( COMMA i1= individual )* ) 
            // src/Erfurt_Syntax_Manchester.g:92:3: i= individual ( COMMA i1= individual )* 
            {
            $this->pushFollow(self::$FOLLOW_individual_in_individualList607);
            $i=$this->individual();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_IndividualList($i);
            }
            // src/Erfurt_Syntax_Manchester.g:93:5: ( COMMA i1= individual )* 
            //loop18:
            do {
                $alt18=2;
                $LA18_0 = $this->input->LA(1);

                if ( ($LA18_0==$this->getToken('COMMA')) ) {
                    $alt18=1;
                }


                switch ($alt18) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:93:6: COMMA i1= individual 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_individualList616); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_individual_in_individualList620);
            	    $i1=$this->individual();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($i1);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop18;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 9, $individualList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 9, $individualList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "individualList"


    // $ANTLR start "individual"
    // src/Erfurt_Syntax_Manchester.g:96:1: individual returns [$value] : (i= individualIRI | NODE_ID ); 
    public function individual(){
        $value = null;
        $individual_StartIndex = $this->input->index();
        $NODE_ID5=null;
        $i = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 10) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:97:3: (i= individualIRI | NODE_ID ) 
            $alt19=2;
            $LA19_0 = $this->input->LA(1);

            if ( (($LA19_0>=$this->getToken('FULL_IRI') && $LA19_0<=$this->getToken('SIMPLE_IRI'))||$LA19_0==$this->getToken('ABBREVIATED_IRI')) ) {
                $alt19=1;
            }
            else if ( ($LA19_0==$this->getToken('NODE_ID')) ) {
                $alt19=2;
            }
            else {
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae = new NoViableAltException("", 19, 0, $this->input);

                throw $nvae;
            }
            switch ($alt19) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:98:3: i= individualIRI 
                    {
                    $this->pushFollow(self::$FOLLOW_individualIRI_in_individual645);
                    $i=$this->individualIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_Individual_NamedIndividual($i);
                    }

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:99:5: NODE_ID 
                    {
                    $NODE_ID5=$this->match($this->input,$this->getToken('NODE_ID'),self::$FOLLOW_NODE_ID_in_individual653); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 10, $individual_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 10, $individual_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "individual"


    // $ANTLR start "nonNegativeInteger"
    // src/Erfurt_Syntax_Manchester.g:102:1: nonNegativeInteger returns [$value] : DIGITS ; 
    public function nonNegativeInteger(){
        $value = null;
        $nonNegativeInteger_StartIndex = $this->input->index();
        $DIGITS6=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 11) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:103:3: ( DIGITS ) 
            // src/Erfurt_Syntax_Manchester.g:104:3: DIGITS 
            {
            $DIGITS6=$this->match($this->input,$this->getToken('DIGITS'),self::$FOLLOW_DIGITS_in_nonNegativeInteger674); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 11, $nonNegativeInteger_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 11, $nonNegativeInteger_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "nonNegativeInteger"


    // $ANTLR start "dataPrimary"
    // src/Erfurt_Syntax_Manchester.g:107:1: dataPrimary returns [$value] : (n= NOT_LABEL )? dataAtomic ; 
    public function dataPrimary(){
        $value = null;
        $dataPrimary_StartIndex = $this->input->index();
        $n=null;
        $dataAtomic7 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 12) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:108:3: ( (n= NOT_LABEL )? dataAtomic ) 
            // src/Erfurt_Syntax_Manchester.g:109:3: (n= NOT_LABEL )? dataAtomic 
            {
            // src/Erfurt_Syntax_Manchester.g:109:3: (n= NOT_LABEL )? 
            $alt20=2;
            $LA20_0 = $this->input->LA(1);

            if ( ($LA20_0==$this->getToken('NOT_LABEL')) ) {
                $alt20=1;
            }
            switch ($alt20) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:109:4: n= NOT_LABEL 
                    {
                    $n=$this->match($this->input,$this->getToken('NOT_LABEL'),self::$FOLLOW_NOT_LABEL_in_dataPrimary698); if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_dataAtomic_in_dataPrimary702);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 12, $dataPrimary_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 12, $dataPrimary_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataPrimary"


    // $ANTLR start "dataPropertyExpression"
    // src/Erfurt_Syntax_Manchester.g:113:1: dataPropertyExpression returns [$value] : d= dataPropertyIRI ; 
    public function dataPropertyExpression(){
        $value = null;
        $dataPropertyExpression_StartIndex = $this->input->index();
        $d = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 13) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:114:3: (d= dataPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:115:3: d= dataPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_dataPropertyIRI_in_dataPropertyExpression725);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 13, $dataPropertyExpression_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 13, $dataPropertyExpression_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataPropertyExpression"


    // $ANTLR start "dataAtomic"
    // src/Erfurt_Syntax_Manchester.g:118:1: dataAtomic returns [$value] : ( ( dataType ) | ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) | ( dataTypeRestriction ) | ( OPEN_BRACE dataRange CLOSE_BRACE ) ); 
    public function dataAtomic(){
        $value = null;
        $dataAtomic_StartIndex = $this->input->index();
        $dataType8 = null;

        $literalList9 = null;

        $dataTypeRestriction10 = null;

        $dataRange11 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 14) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:119:3: ( ( dataType ) | ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) | ( dataTypeRestriction ) | ( OPEN_BRACE dataRange CLOSE_BRACE ) ) 
            $alt21=4;
            $alt21 = $this->dfa21->predict($this->input);
            switch ($alt21) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:120:3: ( dataType ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:120:3: ( dataType ) 
                    // src/Erfurt_Syntax_Manchester.g:120:4: dataType 
                    {
                    $this->pushFollow(self::$FOLLOW_dataType_in_dataAtomic747);
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
                    // src/Erfurt_Syntax_Manchester.g:121:5: ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:121:5: ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) 
                    // src/Erfurt_Syntax_Manchester.g:121:6: OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic757); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_literalList_in_dataAtomic759);
                    $literalList9=$this->literalList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic761); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_DataRange_DataOneOf($literalList9);
                    }

                    }


                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:122:5: ( dataTypeRestriction ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:122:5: ( dataTypeRestriction ) 
                    // src/Erfurt_Syntax_Manchester.g:122:6: dataTypeRestriction 
                    {
                    $this->pushFollow(self::$FOLLOW_dataTypeRestriction_in_dataAtomic771);
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
                    // src/Erfurt_Syntax_Manchester.g:123:5: ( OPEN_BRACE dataRange CLOSE_BRACE ) 
                    {
                    // src/Erfurt_Syntax_Manchester.g:123:5: ( OPEN_BRACE dataRange CLOSE_BRACE ) 
                    // src/Erfurt_Syntax_Manchester.g:123:6: OPEN_BRACE dataRange CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_dataAtomic781); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_dataRange_in_dataAtomic783);
                    $dataRange11=$this->dataRange();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_dataAtomic785); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 14, $dataAtomic_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 14, $dataAtomic_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataAtomic"


    // $ANTLR start "literalList"
    // src/Erfurt_Syntax_Manchester.g:126:1: literalList returns [$value] : l1= literal ( COMMA l2= literal )* ; 
    public function literalList(){
        $value = null;
        $literalList_StartIndex = $this->input->index();
        $l1 = null;

        $l2 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 15) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:127:3: (l1= literal ( COMMA l2= literal )* ) 
            // src/Erfurt_Syntax_Manchester.g:128:3: l1= literal ( COMMA l2= literal )* 
            {
            $this->pushFollow(self::$FOLLOW_literal_in_literalList809);
            $l1=$this->literal();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_OwlList_LiteralList($l1);
            }
            // src/Erfurt_Syntax_Manchester.g:129:3: ( COMMA l2= literal )* 
            //loop22:
            do {
                $alt22=2;
                $LA22_0 = $this->input->LA(1);

                if ( ($LA22_0==$this->getToken('COMMA')) ) {
                    $alt22=1;
                }


                switch ($alt22) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:129:4: COMMA l2= literal 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_literalList816); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_literal_in_literalList820);
            	    $l2=$this->literal();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($l2);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop22;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 15, $literalList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 15, $literalList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "literalList"


    // $ANTLR start "dataType"
    // src/Erfurt_Syntax_Manchester.g:132:1: dataType returns [$value] : ( datatypeIRI | v= INTEGER_LABEL | v= DECIMAL_LABEL | v= FLOAT_LABEL | v= STRING_LABEL ); 
    public function dataType(){
        $value = null;
        $dataType_StartIndex = $this->input->index();
        $v=null;
        $datatypeIRI12 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 16) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:133:3: ( datatypeIRI | v= INTEGER_LABEL | v= DECIMAL_LABEL | v= FLOAT_LABEL | v= STRING_LABEL ) 
            $alt23=5;
            $LA23 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA23||$this->getToken('SIMPLE_IRI')== $LA23||$this->getToken('ABBREVIATED_IRI')== $LA23)
                {
                $alt23=1;
                }
            else if($this->getToken('INTEGER_LABEL')== $LA23)
                {
                $alt23=2;
                }
            else if($this->getToken('DECIMAL_LABEL')== $LA23)
                {
                $alt23=3;
                }
            else if($this->getToken('FLOAT_LABEL')== $LA23)
                {
                $alt23=4;
                }
            else if($this->getToken('STRING_LABEL')== $LA23)
                {
                $alt23=5;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 23, 0, $this->input);

                throw $nvae;
            }

            switch ($alt23) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:134:3: datatypeIRI 
                    {
                    $this->pushFollow(self::$FOLLOW_datatypeIRI_in_dataType843);
                    $datatypeIRI12=$this->datatypeIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $datatypeIRI12;
                    }

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:135:5: v= INTEGER_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('INTEGER_LABEL'),self::$FOLLOW_INTEGER_LABEL_in_dataType853); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:136:5: v= DECIMAL_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL_LABEL'),self::$FOLLOW_DECIMAL_LABEL_in_dataType864); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:137:5: v= FLOAT_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('FLOAT_LABEL'),self::$FOLLOW_FLOAT_LABEL_in_dataType874); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:138:5: v= STRING_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('STRING_LABEL'),self::$FOLLOW_STRING_LABEL_in_dataType884); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 16, $dataType_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 16, $dataType_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataType"


    // $ANTLR start "literal"
    // src/Erfurt_Syntax_Manchester.g:141:1: literal returns [$value] : (v= typedLiteral | v= stringLiteralNoLanguage | v= stringLiteralWithLanguage | v= integerLiteral | v= decimalLiteral | v= floatingPointLiteral ); 
    public function literal(){
        $value = null;
        $literal_StartIndex = $this->input->index();
        $v = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 17) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:143:3: (v= typedLiteral | v= stringLiteralNoLanguage | v= stringLiteralWithLanguage | v= integerLiteral | v= decimalLiteral | v= floatingPointLiteral ) 
            $alt24=6;
            $LA24 = $this->input->LA(1);
            if($this->getToken('QUOTED_STRING')== $LA24)
                {
                $LA24 = $this->input->LA(2);
                if($this->getToken('LANGUAGE_TAG')== $LA24)
                    {
                    $alt24=3;
                    }
                else if($this->getToken('REFERENCE')== $LA24)
                    {
                    $alt24=1;
                    }
                else if($this->getToken('EOF')== $LA24||$this->getToken('LENGTH_LABEL')== $LA24||$this->getToken('MIN_LENGTH_LABEL')== $LA24||$this->getToken('MAX_LENGTH_LABEL')== $LA24||$this->getToken('PATTERN_LABEL')== $LA24||$this->getToken('LANG_PATTERN_LABEL')== $LA24||$this->getToken('INVERSE_LABEL')== $LA24||$this->getToken('NOT_LABEL')== $LA24||$this->getToken('LESS_EQUAL')== $LA24||$this->getToken('GREATER_EQUAL')== $LA24||$this->getToken('LESS')== $LA24||$this->getToken('GREATER')== $LA24||$this->getToken('OPEN_CURLY_BRACE')== $LA24||$this->getToken('CLOSE_CURLY_BRACE')== $LA24||$this->getToken('OR_LABEL')== $LA24||$this->getToken('AND_LABEL')== $LA24||$this->getToken('COMMA')== $LA24||$this->getToken('OPEN_BRACE')== $LA24||$this->getToken('CLOSE_BRACE')== $LA24||$this->getToken('DECIMAL_LABEL')== $LA24||$this->getToken('FLOAT_LABEL')== $LA24||$this->getToken('INTEGER_LABEL')== $LA24||$this->getToken('STRING_LABEL')== $LA24||$this->getToken('EQUIVALENT_TO_LABEL')== $LA24||$this->getToken('ANNOTATIONS_LABEL')== $LA24||$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC')== $LA24||$this->getToken('FULL_IRI')== $LA24||$this->getToken('SIMPLE_IRI')== $LA24||$this->getToken('NODE_ID')== $LA24||$this->getToken('CLOSE_SQUARE_BRACE')== $LA24||$this->getToken('ABBREVIATED_IRI')== $LA24)
                    {
                    $alt24=2;
                    }
                else{
                    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                    $nvae =
                        new NoViableAltException("", 24, 1, $this->input);

                    throw $nvae;
                }

                }
            else if($this->getToken('DIGITS')== $LA24||$this->getToken('ILITERAL_HELPER')== $LA24)
                {
                $alt24=4;
                }
            else if($this->getToken('DLITERAL_HELPER')== $LA24)
                {
                $alt24=5;
                }
            else if($this->getToken('FPLITERAL_HELPER')== $LA24)
                {
                $alt24=6;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 24, 0, $this->input);

                throw $nvae;
            }

            switch ($alt24) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:144:3: v= typedLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_typedLiteral_in_literal911);
                    $v=$this->typedLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:144:20: v= stringLiteralNoLanguage 
                    {
                    $this->pushFollow(self::$FOLLOW_stringLiteralNoLanguage_in_literal917);
                    $v=$this->stringLiteralNoLanguage();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:144:48: v= stringLiteralWithLanguage 
                    {
                    $this->pushFollow(self::$FOLLOW_stringLiteralWithLanguage_in_literal923);
                    $v=$this->stringLiteralWithLanguage();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:144:78: v= integerLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_integerLiteral_in_literal929);
                    $v=$this->integerLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:144:97: v= decimalLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_decimalLiteral_in_literal935);
                    $v=$this->decimalLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 6 :
                    // src/Erfurt_Syntax_Manchester.g:144:116: v= floatingPointLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_floatingPointLiteral_in_literal941);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 17, $literal_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 17, $literal_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "literal"


    // $ANTLR start "stringLiteralNoLanguage"
    // src/Erfurt_Syntax_Manchester.g:147:1: stringLiteralNoLanguage returns [$value] : QUOTED_STRING ; 
    public function stringLiteralNoLanguage(){
        $value = null;
        $stringLiteralNoLanguage_StartIndex = $this->input->index();
        $QUOTED_STRING13=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 18) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:148:3: ( QUOTED_STRING ) 
            // src/Erfurt_Syntax_Manchester.g:149:3: QUOTED_STRING 
            {
            $QUOTED_STRING13=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage960); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 18, $stringLiteralNoLanguage_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 18, $stringLiteralNoLanguage_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "stringLiteralNoLanguage"


    // $ANTLR start "stringLiteralWithLanguage"
    // src/Erfurt_Syntax_Manchester.g:154:1: stringLiteralWithLanguage returns [$value] : QUOTED_STRING LANGUAGE_TAG ; 
    public function stringLiteralWithLanguage(){
        $value = null;
        $stringLiteralWithLanguage_StartIndex = $this->input->index();
        $QUOTED_STRING14=null;
        $LANGUAGE_TAG15=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 19) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:155:3: ( QUOTED_STRING LANGUAGE_TAG ) 
            // src/Erfurt_Syntax_Manchester.g:156:3: QUOTED_STRING LANGUAGE_TAG 
            {
            $QUOTED_STRING14=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage981); if ($this->state->failed) return $value;
            $LANGUAGE_TAG15=$this->match($this->input,$this->getToken('LANGUAGE_TAG'),self::$FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage983); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 19, $stringLiteralWithLanguage_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 19, $stringLiteralWithLanguage_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "stringLiteralWithLanguage"


    // $ANTLR start "lexicalValue"
    // src/Erfurt_Syntax_Manchester.g:159:1: lexicalValue returns [$value] : QUOTED_STRING ; 
    public function lexicalValue(){
        $value = null;
        $lexicalValue_StartIndex = $this->input->index();
        $QUOTED_STRING16=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 20) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:160:3: ( QUOTED_STRING ) 
            // src/Erfurt_Syntax_Manchester.g:161:3: QUOTED_STRING 
            {
            $QUOTED_STRING16=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_lexicalValue1004); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 20, $lexicalValue_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 20, $lexicalValue_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "lexicalValue"


    // $ANTLR start "typedLiteral"
    // src/Erfurt_Syntax_Manchester.g:164:1: typedLiteral returns [$value] : lexicalValue REFERENCE dataType ; 
    public function typedLiteral(){
        $value = null;
        $typedLiteral_StartIndex = $this->input->index();
        $lexicalValue17 = null;

        $dataType18 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 21) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:165:3: ( lexicalValue REFERENCE dataType ) 
            // src/Erfurt_Syntax_Manchester.g:166:3: lexicalValue REFERENCE dataType 
            {
            $this->pushFollow(self::$FOLLOW_lexicalValue_in_typedLiteral1025);
            $lexicalValue17=$this->lexicalValue();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            $this->match($this->input,$this->getToken('REFERENCE'),self::$FOLLOW_REFERENCE_in_typedLiteral1027); if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_dataType_in_typedLiteral1029);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 21, $typedLiteral_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 21, $typedLiteral_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "typedLiteral"


    // $ANTLR start "restrictionValue"
    // src/Erfurt_Syntax_Manchester.g:169:1: restrictionValue returns [$value] : literal ; 
    public function restrictionValue(){
        $value = null;
        $restrictionValue_StartIndex = $this->input->index();
        $literal19 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 22) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:170:3: ( literal ) 
            // src/Erfurt_Syntax_Manchester.g:171:3: literal 
            {
            $this->pushFollow(self::$FOLLOW_literal_in_restrictionValue1050);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 22, $restrictionValue_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 22, $restrictionValue_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "restrictionValue"


    // $ANTLR start "inverseObjectProperty"
    // src/Erfurt_Syntax_Manchester.g:174:1: inverseObjectProperty returns [$value] : INVERSE_LABEL objectPropertyIRI ; 
    public function inverseObjectProperty(){
        $value = null;
        $inverseObjectProperty_StartIndex = $this->input->index();
        $objectPropertyIRI20 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 23) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:175:3: ( INVERSE_LABEL objectPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:176:3: INVERSE_LABEL objectPropertyIRI 
            {
            $this->match($this->input,$this->getToken('INVERSE_LABEL'),self::$FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1071); if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_inverseObjectProperty1073);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 23, $inverseObjectProperty_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 23, $inverseObjectProperty_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "inverseObjectProperty"


    // $ANTLR start "decimalLiteral"
    // src/Erfurt_Syntax_Manchester.g:180:1: decimalLiteral returns [$value] : DLITERAL_HELPER ; 
    public function decimalLiteral(){
        $value = null;
        $decimalLiteral_StartIndex = $this->input->index();
        $DLITERAL_HELPER21=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 24) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:181:3: ( DLITERAL_HELPER ) 
            // src/Erfurt_Syntax_Manchester.g:182:3: DLITERAL_HELPER 
            {
            $DLITERAL_HELPER21=$this->match($this->input,$this->getToken('DLITERAL_HELPER'),self::$FOLLOW_DLITERAL_HELPER_in_decimalLiteral1094); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 24, $decimalLiteral_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 24, $decimalLiteral_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "decimalLiteral"


    // $ANTLR start "integerLiteral"
    // src/Erfurt_Syntax_Manchester.g:185:1: integerLiteral returns [$value] : (i= ILITERAL_HELPER | i= DIGITS ) ; 
    public function integerLiteral(){
        $value = null;
        $integerLiteral_StartIndex = $this->input->index();
        $i=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 25) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:186:3: ( (i= ILITERAL_HELPER | i= DIGITS ) ) 
            // src/Erfurt_Syntax_Manchester.g:186:5: (i= ILITERAL_HELPER | i= DIGITS ) 
            {
            // src/Erfurt_Syntax_Manchester.g:186:5: (i= ILITERAL_HELPER | i= DIGITS ) 
            $alt25=2;
            $LA25_0 = $this->input->LA(1);

            if ( ($LA25_0==$this->getToken('ILITERAL_HELPER')) ) {
                $alt25=1;
            }
            else if ( ($LA25_0==$this->getToken('DIGITS')) ) {
                $alt25=2;
            }
            else {
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae = new NoViableAltException("", 25, 0, $this->input);

                throw $nvae;
            }
            switch ($alt25) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:186:6: i= ILITERAL_HELPER 
                    {
                    $i=$this->match($this->input,$this->getToken('ILITERAL_HELPER'),self::$FOLLOW_ILITERAL_HELPER_in_integerLiteral1116); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:186:26: i= DIGITS 
                    {
                    $i=$this->match($this->input,$this->getToken('DIGITS'),self::$FOLLOW_DIGITS_in_integerLiteral1122); if ($this->state->failed) return $value;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 25, $integerLiteral_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 25, $integerLiteral_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "integerLiteral"


    // $ANTLR start "floatingPointLiteral"
    // src/Erfurt_Syntax_Manchester.g:189:1: floatingPointLiteral returns [$value] : FPLITERAL_HELPER ; 
    public function floatingPointLiteral(){
        $value = null;
        $floatingPointLiteral_StartIndex = $this->input->index();
        $FPLITERAL_HELPER22=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 26) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:190:3: ( FPLITERAL_HELPER ) 
            // src/Erfurt_Syntax_Manchester.g:191:3: FPLITERAL_HELPER 
            {
            $FPLITERAL_HELPER22=$this->match($this->input,$this->getToken('FPLITERAL_HELPER'),self::$FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1144); if ($this->state->failed) return $value;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 26, $floatingPointLiteral_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 26, $floatingPointLiteral_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "floatingPointLiteral"


    // $ANTLR start "objectProperty"
    // src/Erfurt_Syntax_Manchester.g:194:1: objectProperty returns [$value] : objectPropertyIRI ; 
    public function objectProperty(){
        $value = null;
        $objectProperty_StartIndex = $this->input->index();
        $objectPropertyIRI23 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 27) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:195:3: ( objectPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:196:3: objectPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_objectProperty1165);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 27, $objectProperty_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 27, $objectProperty_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "objectProperty"


    // $ANTLR start "dataProperty"
    // src/Erfurt_Syntax_Manchester.g:199:1: dataProperty returns [$value] : dataPropertyIRI ; 
    public function dataProperty(){
        $value = null;
        $dataProperty_StartIndex = $this->input->index();
        $dataPropertyIRI24 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 28) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:200:3: ( dataPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:201:3: dataPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_dataPropertyIRI_in_dataProperty1186);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 28, $dataProperty_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 28, $dataProperty_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataProperty"


    // $ANTLR start "dataPropertyIRI"
    // src/Erfurt_Syntax_Manchester.g:204:1: dataPropertyIRI returns [$value] : iri ; 
    public function dataPropertyIRI(){
        $value = null;
        $dataPropertyIRI_StartIndex = $this->input->index();
        $iri25 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 29) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:205:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:206:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_dataPropertyIRI1207);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 29, $dataPropertyIRI_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 29, $dataPropertyIRI_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataPropertyIRI"


    // $ANTLR start "datatypeIRI"
    // src/Erfurt_Syntax_Manchester.g:209:1: datatypeIRI returns [$value] : iri ; 
    public function datatypeIRI(){
        $value = null;
        $datatypeIRI_StartIndex = $this->input->index();
        $iri26 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 30) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:210:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:211:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_datatypeIRI1228);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 30, $datatypeIRI_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 30, $datatypeIRI_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "datatypeIRI"


    // $ANTLR start "objectPropertyIRI"
    // src/Erfurt_Syntax_Manchester.g:214:1: objectPropertyIRI returns [$value] : iri ; 
    public function objectPropertyIRI(){
        $value = null;
        $objectPropertyIRI_StartIndex = $this->input->index();
        $iri27 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 31) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:215:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:216:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_objectPropertyIRI1249);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 31, $objectPropertyIRI_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 31, $objectPropertyIRI_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "objectPropertyIRI"


    // $ANTLR start "dataTypeRestriction"
    // src/Erfurt_Syntax_Manchester.g:219:1: dataTypeRestriction returns [$value] : dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE ; 
    public function dataTypeRestriction(){
        $value = null;
        $dataTypeRestriction_StartIndex = $this->input->index();
        $f = null;

        $r = null;

        $dataType28 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 32) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:220:3: ( dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE ) 
            // src/Erfurt_Syntax_Manchester.g:221:3: dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE 
            {
            $this->pushFollow(self::$FOLLOW_dataType_in_dataTypeRestriction1270);
            $dataType28=$this->dataType();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_DataRange_DatatypeRestriction($dataType28);
            }
            $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1274); if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:222:9: (f= facet r= restrictionValue ( COMMA )? )+ 
            $cnt27=0;
            //loop27:
            do {
                $alt27=2;
                $LA27_0 = $this->input->LA(1);

                if ( (($LA27_0>=$this->getToken('LENGTH_LABEL') && $LA27_0<=$this->getToken('LANG_PATTERN_LABEL'))||($LA27_0>=$this->getToken('LESS_EQUAL') && $LA27_0<=$this->getToken('GREATER'))) ) {
                    $alt27=1;
                }


                switch ($alt27) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:222:11: f= facet r= restrictionValue ( COMMA )? 
            	    {
            	    $this->pushFollow(self::$FOLLOW_facet_in_dataTypeRestriction1288);
            	    $f=$this->facet();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_restrictionValue_in_dataTypeRestriction1292);
            	    $r=$this->restrictionValue();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value -> addRestriction($f, $r);
            	    }
            	    // src/Erfurt_Syntax_Manchester.g:222:87: ( COMMA )? 
            	    $alt26=2;
            	    $LA26_0 = $this->input->LA(1);

            	    if ( ($LA26_0==$this->getToken('COMMA')) ) {
            	        $alt26=1;
            	    }
            	    switch ($alt26) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: COMMA 
            	            {
            	            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataTypeRestriction1296); if ($this->state->failed) return $value;

            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    if ( $cnt27 >= 1 ) break 2;//loop27;
            	    if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                        $eee =
                            new EarlyExitException(27, $this->input);
                        throw $eee;
                }
                $cnt27++;
            } while (true);

            $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1303); if ($this->state->failed) return $value;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 32, $dataTypeRestriction_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 32, $dataTypeRestriction_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataTypeRestriction"


    // $ANTLR start "individualIRI"
    // src/Erfurt_Syntax_Manchester.g:226:1: individualIRI returns [$value] : iri ; 
    public function individualIRI(){
        $value = null;
        $individualIRI_StartIndex = $this->input->index();
        $iri29 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 33) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:227:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:228:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_individualIRI1322);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 33, $individualIRI_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 33, $individualIRI_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "individualIRI"


    // $ANTLR start "datatypePropertyIRI"
    // src/Erfurt_Syntax_Manchester.g:231:1: datatypePropertyIRI returns [$value] : iri ; 
    public function datatypePropertyIRI(){
        $value = null;
        $datatypePropertyIRI_StartIndex = $this->input->index();
        $iri30 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 34) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:232:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:233:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_datatypePropertyIRI1343);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 34, $datatypePropertyIRI_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 34, $datatypePropertyIRI_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "datatypePropertyIRI"


    // $ANTLR start "facet"
    // src/Erfurt_Syntax_Manchester.g:236:1: facet returns [$value] : (v= LENGTH_LABEL | v= MIN_LENGTH_LABEL | v= MAX_LENGTH_LABEL | v= PATTERN_LABEL | v= LANG_PATTERN_LABEL | v= LESS_EQUAL | v= LESS | v= GREATER_EQUAL | v= GREATER ); 
    public function facet(){
        $value = null;
        $facet_StartIndex = $this->input->index();
        $v=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 35) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:238:3: (v= LENGTH_LABEL | v= MIN_LENGTH_LABEL | v= MAX_LENGTH_LABEL | v= PATTERN_LABEL | v= LANG_PATTERN_LABEL | v= LESS_EQUAL | v= LESS | v= GREATER_EQUAL | v= GREATER ) 
            $alt28=9;
            $LA28 = $this->input->LA(1);
            if($this->getToken('LENGTH_LABEL')== $LA28)
                {
                $alt28=1;
                }
            else if($this->getToken('MIN_LENGTH_LABEL')== $LA28)
                {
                $alt28=2;
                }
            else if($this->getToken('MAX_LENGTH_LABEL')== $LA28)
                {
                $alt28=3;
                }
            else if($this->getToken('PATTERN_LABEL')== $LA28)
                {
                $alt28=4;
                }
            else if($this->getToken('LANG_PATTERN_LABEL')== $LA28)
                {
                $alt28=5;
                }
            else if($this->getToken('LESS_EQUAL')== $LA28)
                {
                $alt28=6;
                }
            else if($this->getToken('LESS')== $LA28)
                {
                $alt28=7;
                }
            else if($this->getToken('GREATER_EQUAL')== $LA28)
                {
                $alt28=8;
                }
            else if($this->getToken('GREATER')== $LA28)
                {
                $alt28=9;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 28, 0, $this->input);

                throw $nvae;
            }

            switch ($alt28) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:239:3: v= LENGTH_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('LENGTH_LABEL'),self::$FOLLOW_LENGTH_LABEL_in_facet1370); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:239:20: v= MIN_LENGTH_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('MIN_LENGTH_LABEL'),self::$FOLLOW_MIN_LENGTH_LABEL_in_facet1376); if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:239:41: v= MAX_LENGTH_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('MAX_LENGTH_LABEL'),self::$FOLLOW_MAX_LENGTH_LABEL_in_facet1382); if ($this->state->failed) return $value;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:239:62: v= PATTERN_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('PATTERN_LABEL'),self::$FOLLOW_PATTERN_LABEL_in_facet1388); if ($this->state->failed) return $value;

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:239:80: v= LANG_PATTERN_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('LANG_PATTERN_LABEL'),self::$FOLLOW_LANG_PATTERN_LABEL_in_facet1394); if ($this->state->failed) return $value;

                    }
                    break;
                case 6 :
                    // src/Erfurt_Syntax_Manchester.g:239:103: v= LESS_EQUAL 
                    {
                    $v=$this->match($this->input,$this->getToken('LESS_EQUAL'),self::$FOLLOW_LESS_EQUAL_in_facet1400); if ($this->state->failed) return $value;

                    }
                    break;
                case 7 :
                    // src/Erfurt_Syntax_Manchester.g:239:118: v= LESS 
                    {
                    $v=$this->match($this->input,$this->getToken('LESS'),self::$FOLLOW_LESS_in_facet1406); if ($this->state->failed) return $value;

                    }
                    break;
                case 8 :
                    // src/Erfurt_Syntax_Manchester.g:239:127: v= GREATER_EQUAL 
                    {
                    $v=$this->match($this->input,$this->getToken('GREATER_EQUAL'),self::$FOLLOW_GREATER_EQUAL_in_facet1412); if ($this->state->failed) return $value;

                    }
                    break;
                case 9 :
                    // src/Erfurt_Syntax_Manchester.g:239:145: v= GREATER 
                    {
                    $v=$this->match($this->input,$this->getToken('GREATER'),self::$FOLLOW_GREATER_in_facet1418); if ($this->state->failed) return $value;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 35, $facet_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 35, $facet_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "facet"


    // $ANTLR start "dataRange"
    // src/Erfurt_Syntax_Manchester.g:242:1: dataRange returns [$value] : d1= dataConjunction ( OR_LABEL d2= dataConjunction )* ; 
    public function dataRange(){
        $value = null;
        $dataRange_StartIndex = $this->input->index();
        $d1 = null;

        $d2 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 36) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:243:3: (d1= dataConjunction ( OR_LABEL d2= dataConjunction )* ) 
            // src/Erfurt_Syntax_Manchester.g:244:3: d1= dataConjunction ( OR_LABEL d2= dataConjunction )* 
            {
            $this->pushFollow(self::$FOLLOW_dataConjunction_in_dataRange1439);
            $d1=$this->dataConjunction();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_DataRange_DataUnionOf($d1);
            }
            // src/Erfurt_Syntax_Manchester.g:245:9: ( OR_LABEL d2= dataConjunction )* 
            //loop29:
            do {
                $alt29=2;
                $LA29_0 = $this->input->LA(1);

                if ( ($LA29_0==$this->getToken('OR_LABEL')) ) {
                    $LA29_2 = $this->input->LA(2);

                    if ( ($this->synpred56_Erfurt_Syntax_Manchester()) ) {
                        $alt29=1;
                    }


                }


                switch ($alt29) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:245:10: OR_LABEL d2= dataConjunction 
            	    {
            	    $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_dataRange1453); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_dataConjunction_in_dataRange1457);
            	    $d2=$this->dataConjunction();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($d2);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop29;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 36, $dataRange_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 36, $dataRange_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataRange"


    // $ANTLR start "dataConjunction"
    // src/Erfurt_Syntax_Manchester.g:248:1: dataConjunction returns [$value] : d1= dataPrimary ( AND_LABEL d2= dataPrimary )* ; 
    public function dataConjunction(){
        $value = null;
        $dataConjunction_StartIndex = $this->input->index();
        $d1 = null;

        $d2 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 37) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:249:3: (d1= dataPrimary ( AND_LABEL d2= dataPrimary )* ) 
            // src/Erfurt_Syntax_Manchester.g:250:3: d1= dataPrimary ( AND_LABEL d2= dataPrimary )* 
            {
            $this->pushFollow(self::$FOLLOW_dataPrimary_in_dataConjunction1482);
            $d1=$this->dataPrimary();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_DataRange_DataIntersectionOf($d1);
            }
            // src/Erfurt_Syntax_Manchester.g:251:13: ( AND_LABEL d2= dataPrimary )* 
            //loop30:
            do {
                $alt30=2;
                $LA30_0 = $this->input->LA(1);

                if ( ($LA30_0==$this->getToken('AND_LABEL')) ) {
                    $LA30_2 = $this->input->LA(2);

                    if ( ($this->synpred57_Erfurt_Syntax_Manchester()) ) {
                        $alt30=1;
                    }


                }


                switch ($alt30) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:251:14: AND_LABEL d2= dataPrimary 
            	    {
            	    $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_dataConjunction1499); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_dataPrimary_in_dataConjunction1503);
            	    $d2=$this->dataPrimary();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($d2);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop30;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 37, $dataConjunction_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 37, $dataConjunction_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataConjunction"


    // $ANTLR start "annotationAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:257:1: annotationAnnotatedList returns [$value] : ( annotations )? annotation ( COMMA ( annotations )? annotation )* ; 
    public function annotationAnnotatedList(){
        $value = null;
        $annotationAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 38) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:258:2: ( ( annotations )? annotation ( COMMA ( annotations )? annotation )* ) 
            // src/Erfurt_Syntax_Manchester.g:258:4: ( annotations )? annotation ( COMMA ( annotations )? annotation )* 
            {
            // src/Erfurt_Syntax_Manchester.g:258:4: ( annotations )? 
            $alt31=2;
            $LA31 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA31)
                {
                $alt31=1;
                }
            else if($this->getToken('FULL_IRI')== $LA31)
                {
                $LA31_2 = $this->input->LA(2);

                if ( ($this->synpred58_Erfurt_Syntax_Manchester()) ) {
                    $alt31=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA31)
                {
                $LA31_3 = $this->input->LA(2);

                if ( ($this->synpred58_Erfurt_Syntax_Manchester()) ) {
                    $alt31=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA31)
                {
                $LA31_4 = $this->input->LA(2);

                if ( ($this->synpred58_Erfurt_Syntax_Manchester()) ) {
                    $alt31=1;
                }
                }

            switch ($alt31) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_annotationAnnotatedList1526);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_annotation_in_annotationAnnotatedList1529);
            $this->annotation();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:258:28: ( COMMA ( annotations )? annotation )* 
            //loop33:
            do {
                $alt33=2;
                $LA33_0 = $this->input->LA(1);

                if ( ($LA33_0==$this->getToken('COMMA')) ) {
                    $alt33=1;
                }


                switch ($alt33) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:258:29: COMMA ( annotations )? annotation 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_annotationAnnotatedList1532); if ($this->state->failed) return $value;
            	    // src/Erfurt_Syntax_Manchester.g:258:35: ( annotations )? 
            	    $alt32=2;
            	    $LA32 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA32)
            	        {
            	        $alt32=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA32)
            	        {
            	        $LA32_2 = $this->input->LA(2);

            	        if ( ($this->synpred59_Erfurt_Syntax_Manchester()) ) {
            	            $alt32=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA32)
            	        {
            	        $LA32_3 = $this->input->LA(2);

            	        if ( ($this->synpred59_Erfurt_Syntax_Manchester()) ) {
            	            $alt32=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA32)
            	        {
            	        $LA32_4 = $this->input->LA(2);

            	        if ( ($this->synpred59_Erfurt_Syntax_Manchester()) ) {
            	            $alt32=1;
            	        }
            	        }

            	    switch ($alt32) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_annotationAnnotatedList1534);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return $value;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_annotation_in_annotationAnnotatedList1537);
            	    $this->annotation();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 38, $annotationAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 38, $annotationAnnotatedList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "annotationAnnotatedList"


    // $ANTLR start "annotation"
    // src/Erfurt_Syntax_Manchester.g:261:1: annotation returns [$value] : ap= annotationPropertyIRI at= annotationTarget ; 
    public function annotation(){
        $value = null;
        $annotation_StartIndex = $this->input->index();
        $ap = null;

        $at = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 39) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:262:2: (ap= annotationPropertyIRI at= annotationTarget ) 
            // src/Erfurt_Syntax_Manchester.g:262:4: ap= annotationPropertyIRI at= annotationTarget 
            {
            $this->pushFollow(self::$FOLLOW_annotationPropertyIRI_in_annotation1556);
            $ap=$this->annotationPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_annotationTarget_in_annotation1560);
            $at=$this->annotationTarget();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Annotation($ap,$at);
            }

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 39, $annotation_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 39, $annotation_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "annotation"


    // $ANTLR start "annotationTarget"
    // src/Erfurt_Syntax_Manchester.g:265:1: annotationTarget returns [$value] : ( NODE_ID | iri | literal ); 
    public function annotationTarget(){
        $value = null;
        $annotationTarget_StartIndex = $this->input->index();
        $NODE_ID31=null;
        $iri32 = null;

        $literal33 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 40) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:266:2: ( NODE_ID | iri | literal ) 
            $alt34=3;
            $LA34 = $this->input->LA(1);
            if($this->getToken('NODE_ID')== $LA34)
                {
                $alt34=1;
                }
            else if($this->getToken('FULL_IRI')== $LA34||$this->getToken('SIMPLE_IRI')== $LA34||$this->getToken('ABBREVIATED_IRI')== $LA34)
                {
                $alt34=2;
                }
            else if($this->getToken('DIGITS')== $LA34||$this->getToken('QUOTED_STRING')== $LA34||$this->getToken('ILITERAL_HELPER')== $LA34||$this->getToken('DLITERAL_HELPER')== $LA34||$this->getToken('FPLITERAL_HELPER')== $LA34)
                {
                $alt34=3;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 34, 0, $this->input);

                throw $nvae;
            }

            switch ($alt34) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:266:4: NODE_ID 
                    {
                    $NODE_ID31=$this->match($this->input,$this->getToken('NODE_ID'),self::$FOLLOW_NODE_ID_in_annotationTarget1577); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($NODE_ID31!=null?$NODE_ID31->getText():null);
                    }

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:267:4: iri 
                    {
                    $this->pushFollow(self::$FOLLOW_iri_in_annotationTarget1584);
                    $iri32=$this->iri();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $iri32;
                    }

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:268:4: literal 
                    {
                    $this->pushFollow(self::$FOLLOW_literal_in_annotationTarget1591);
                    $literal33=$this->literal();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $literal33;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 40, $annotationTarget_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 40, $annotationTarget_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "annotationTarget"


    // $ANTLR start "annotations"
    // src/Erfurt_Syntax_Manchester.g:270:1: annotations returns [$value] : ( ANNOTATIONS_LABEL a= annotationAnnotatedList )? ; 
    public function annotations(){
        $value = null;
        $annotations_StartIndex = $this->input->index();
        $a = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 41) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:271:2: ( ( ANNOTATIONS_LABEL a= annotationAnnotatedList )? ) 
            // src/Erfurt_Syntax_Manchester.g:271:4: ( ANNOTATIONS_LABEL a= annotationAnnotatedList )? 
            {
            // src/Erfurt_Syntax_Manchester.g:271:4: ( ANNOTATIONS_LABEL a= annotationAnnotatedList )? 
            $alt35=2;
            $LA35_0 = $this->input->LA(1);

            if ( ($LA35_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                $alt35=1;
            }
            switch ($alt35) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:271:5: ANNOTATIONS_LABEL a= annotationAnnotatedList 
                    {
                    $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_annotations1608); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_annotations1612);
                    $a=$this->annotationAnnotatedList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $a;
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 41, $annotations_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 41, $annotations_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "annotations"


    // $ANTLR start "descriptionList"
    // src/Erfurt_Syntax_Manchester.g:282:1: descriptionList returns [$value] : d1= description ( COMMA d2= description )* ; 
    public function descriptionList(){
        $value = null;
        $descriptionList_StartIndex = $this->input->index();
        $d1 = null;

        $d2 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 42) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:283:3: (d1= description ( COMMA d2= description )* ) 
            // src/Erfurt_Syntax_Manchester.g:283:5: d1= description ( COMMA d2= description )* 
            {
            $this->pushFollow(self::$FOLLOW_description_in_descriptionList1643);
            $d1=$this->description();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_OwlList($d1);
            }
            // src/Erfurt_Syntax_Manchester.g:283:78: ( COMMA d2= description )* 
            //loop36:
            do {
                $alt36=2;
                $LA36_0 = $this->input->LA(1);

                if ( ($LA36_0==$this->getToken('COMMA')) ) {
                    $alt36=1;
                }


                switch ($alt36) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:283:79: COMMA d2= description 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_descriptionList1648); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_description_in_descriptionList1652);
            	    $d2=$this->description();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($d2);
            	    }

            	    }
            	    break;

            	default :
            	    break 2;//loop36;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 42, $descriptionList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 42, $descriptionList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "descriptionList"


    // $ANTLR start "objectPropertyCharacteristicAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:312:1: objectPropertyCharacteristicAnnotatedList : ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC ( COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC )* ; 
    public function objectPropertyCharacteristicAnnotatedList(){
        $objectPropertyCharacteristicAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 43) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:313:2: ( ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC ( COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC )* ) 
            // src/Erfurt_Syntax_Manchester.g:313:4: ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC ( COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC )* 
            {
            // src/Erfurt_Syntax_Manchester.g:313:4: ( annotations )? 
            $alt37=2;
            $LA37_0 = $this->input->LA(1);

            if ( ($LA37_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                $alt37=1;
            }
            else if ( ($LA37_0==$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC')) ) {
                $LA37_2 = $this->input->LA(2);

                if ( ($this->synpred65_Erfurt_Syntax_Manchester()) ) {
                    $alt37=1;
                }
            }
            switch ($alt37) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1695);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->match($this->input,$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC'),self::$FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1698); if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:313:48: ( COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC )* 
            //loop39:
            do {
                $alt39=2;
                $LA39_0 = $this->input->LA(1);

                if ( ($LA39_0==$this->getToken('COMMA')) ) {
                    $alt39=1;
                }


                switch ($alt39) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:313:49: COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectPropertyCharacteristicAnnotatedList1701); if ($this->state->failed) return ;
            	    // src/Erfurt_Syntax_Manchester.g:313:55: ( annotations )? 
            	    $alt38=2;
            	    $LA38_0 = $this->input->LA(1);

            	    if ( ($LA38_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
            	        $alt38=1;
            	    }
            	    else if ( ($LA38_0==$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC')) ) {
            	        $LA38_2 = $this->input->LA(2);

            	        if ( ($this->synpred66_Erfurt_Syntax_Manchester()) ) {
            	            $alt38=1;
            	        }
            	    }
            	    switch ($alt38) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1703);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return ;

            	            }
            	            break;

            	    }

            	    $this->match($this->input,$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC'),self::$FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1706); if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 43, $objectPropertyCharacteristicAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 43, $objectPropertyCharacteristicAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "objectPropertyCharacteristicAnnotatedList"


    // $ANTLR start "objectPropertyExpressionAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:316:1: objectPropertyExpressionAnnotatedList : ( annotations )? objectPropertyExpression ( COMMA ( annotations )? objectPropertyExpression )* ; 
    public function objectPropertyExpressionAnnotatedList(){
        $objectPropertyExpressionAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 44) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:317:3: ( ( annotations )? objectPropertyExpression ( COMMA ( annotations )? objectPropertyExpression )* ) 
            // src/Erfurt_Syntax_Manchester.g:317:5: ( annotations )? objectPropertyExpression ( COMMA ( annotations )? objectPropertyExpression )* 
            {
            // src/Erfurt_Syntax_Manchester.g:317:5: ( annotations )? 
            $alt40=2;
            $LA40 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA40)
                {
                $alt40=1;
                }
            else if($this->getToken('FULL_IRI')== $LA40)
                {
                $LA40_2 = $this->input->LA(2);

                if ( ($this->synpred68_Erfurt_Syntax_Manchester()) ) {
                    $alt40=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA40)
                {
                $LA40_3 = $this->input->LA(2);

                if ( ($this->synpred68_Erfurt_Syntax_Manchester()) ) {
                    $alt40=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA40)
                {
                $LA40_4 = $this->input->LA(2);

                if ( ($this->synpred68_Erfurt_Syntax_Manchester()) ) {
                    $alt40=1;
                }
                }
            else if($this->getToken('INVERSE_LABEL')== $LA40)
                {
                $LA40_5 = $this->input->LA(2);

                if ( ($this->synpred68_Erfurt_Syntax_Manchester()) ) {
                    $alt40=1;
                }
                }

            switch ($alt40) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1721);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1724);
            $this->objectPropertyExpression();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:317:43: ( COMMA ( annotations )? objectPropertyExpression )* 
            //loop42:
            do {
                $alt42=2;
                $LA42_0 = $this->input->LA(1);

                if ( ($LA42_0==$this->getToken('COMMA')) ) {
                    $alt42=1;
                }


                switch ($alt42) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:317:44: COMMA ( annotations )? objectPropertyExpression 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectPropertyExpressionAnnotatedList1727); if ($this->state->failed) return ;
            	    // src/Erfurt_Syntax_Manchester.g:317:50: ( annotations )? 
            	    $alt41=2;
            	    $LA41 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA41)
            	        {
            	        $alt41=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA41)
            	        {
            	        $LA41_2 = $this->input->LA(2);

            	        if ( ($this->synpred69_Erfurt_Syntax_Manchester()) ) {
            	            $alt41=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA41)
            	        {
            	        $LA41_3 = $this->input->LA(2);

            	        if ( ($this->synpred69_Erfurt_Syntax_Manchester()) ) {
            	            $alt41=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA41)
            	        {
            	        $LA41_4 = $this->input->LA(2);

            	        if ( ($this->synpred69_Erfurt_Syntax_Manchester()) ) {
            	            $alt41=1;
            	        }
            	        }
            	    else if($this->getToken('INVERSE_LABEL')== $LA41)
            	        {
            	        $LA41_5 = $this->input->LA(2);

            	        if ( ($this->synpred69_Erfurt_Syntax_Manchester()) ) {
            	            $alt41=1;
            	        }
            	        }

            	    switch ($alt41) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1729);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return ;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1732);
            	    $this->objectPropertyExpression();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 44, $objectPropertyExpressionAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 44, $objectPropertyExpressionAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "objectPropertyExpressionAnnotatedList"


    // $ANTLR start "dataPropertyExpressionAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:336:1: dataPropertyExpressionAnnotatedList : ( annotations )? dataPropertyExpression ( COMMA ( annotations )? dataPropertyExpression )* ; 
    public function dataPropertyExpressionAnnotatedList(){
        $dataPropertyExpressionAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 45) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:337:4: ( ( annotations )? dataPropertyExpression ( COMMA ( annotations )? dataPropertyExpression )* ) 
            // src/Erfurt_Syntax_Manchester.g:337:6: ( annotations )? dataPropertyExpression ( COMMA ( annotations )? dataPropertyExpression )* 
            {
            // src/Erfurt_Syntax_Manchester.g:337:6: ( annotations )? 
            $alt43=2;
            $LA43 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA43)
                {
                $alt43=1;
                }
            else if($this->getToken('FULL_IRI')== $LA43)
                {
                $LA43_2 = $this->input->LA(2);

                if ( ($this->synpred71_Erfurt_Syntax_Manchester()) ) {
                    $alt43=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA43)
                {
                $LA43_3 = $this->input->LA(2);

                if ( ($this->synpred71_Erfurt_Syntax_Manchester()) ) {
                    $alt43=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA43)
                {
                $LA43_4 = $this->input->LA(2);

                if ( ($this->synpred71_Erfurt_Syntax_Manchester()) ) {
                    $alt43=1;
                }
                }

            switch ($alt43) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1766);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1769);
            $this->dataPropertyExpression();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:337:42: ( COMMA ( annotations )? dataPropertyExpression )* 
            //loop45:
            do {
                $alt45=2;
                $LA45_0 = $this->input->LA(1);

                if ( ($LA45_0==$this->getToken('COMMA')) ) {
                    $alt45=1;
                }


                switch ($alt45) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:337:43: COMMA ( annotations )? dataPropertyExpression 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataPropertyExpressionAnnotatedList1772); if ($this->state->failed) return ;
            	    // src/Erfurt_Syntax_Manchester.g:337:49: ( annotations )? 
            	    $alt44=2;
            	    $LA44 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA44)
            	        {
            	        $alt44=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA44)
            	        {
            	        $LA44_2 = $this->input->LA(2);

            	        if ( ($this->synpred72_Erfurt_Syntax_Manchester()) ) {
            	            $alt44=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA44)
            	        {
            	        $LA44_3 = $this->input->LA(2);

            	        if ( ($this->synpred72_Erfurt_Syntax_Manchester()) ) {
            	            $alt44=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA44)
            	        {
            	        $LA44_4 = $this->input->LA(2);

            	        if ( ($this->synpred72_Erfurt_Syntax_Manchester()) ) {
            	            $alt44=1;
            	        }
            	        }

            	    switch ($alt44) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1774);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return ;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1777);
            	    $this->dataPropertyExpression();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 45, $dataPropertyExpressionAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 45, $dataPropertyExpressionAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "dataPropertyExpressionAnnotatedList"


    // $ANTLR start "annotationPropertyFrame"
    // src/Erfurt_Syntax_Manchester.g:340:1: annotationPropertyFrame : ( ANNOTATION_PROPERTY_LABEL annotationPropertyIRI ( ANNOTATIONS_LABEL annotationAnnotatedList )* | DOMAIN_LABEL iriAnnotatedList | RANGE_LABEL iriAnnotatedList | SUB_PROPERTY_OF_LABEL annotationPropertyIRIAnnotatedList ); 
    public function annotationPropertyFrame(){
        $annotationPropertyFrame_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 46) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:341:3: ( ANNOTATION_PROPERTY_LABEL annotationPropertyIRI ( ANNOTATIONS_LABEL annotationAnnotatedList )* | DOMAIN_LABEL iriAnnotatedList | RANGE_LABEL iriAnnotatedList | SUB_PROPERTY_OF_LABEL annotationPropertyIRIAnnotatedList ) 
            $alt47=4;
            $LA47 = $this->input->LA(1);
            if($this->getToken('ANNOTATION_PROPERTY_LABEL')== $LA47)
                {
                $alt47=1;
                }
            else if($this->getToken('DOMAIN_LABEL')== $LA47)
                {
                $alt47=2;
                }
            else if($this->getToken('RANGE_LABEL')== $LA47)
                {
                $alt47=3;
                }
            else if($this->getToken('SUB_PROPERTY_OF_LABEL')== $LA47)
                {
                $alt47=4;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                $nvae =
                    new NoViableAltException("", 47, 0, $this->input);

                throw $nvae;
            }

            switch ($alt47) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:341:5: ANNOTATION_PROPERTY_LABEL annotationPropertyIRI ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
                    {
                    $this->match($this->input,$this->getToken('ANNOTATION_PROPERTY_LABEL'),self::$FOLLOW_ANNOTATION_PROPERTY_LABEL_in_annotationPropertyFrame1794); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_annotationPropertyIRI_in_annotationPropertyFrame1796);
                    $this->annotationPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    // src/Erfurt_Syntax_Manchester.g:342:3: ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
                    //loop46:
                    do {
                        $alt46=2;
                        $LA46_0 = $this->input->LA(1);

                        if ( ($LA46_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                            $alt46=1;
                        }


                        switch ($alt46) {
                    	case 1 :
                    	    // src/Erfurt_Syntax_Manchester.g:342:5: ANNOTATIONS_LABEL annotationAnnotatedList 
                    	    {
                    	    $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_annotationPropertyFrame1802); if ($this->state->failed) return ;
                    	    $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_annotationPropertyFrame1805);
                    	    $this->annotationAnnotatedList();

                    	    $this->state->_fsp--;
                    	    if ($this->state->failed) return ;

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop46;
                        }
                    } while (true);


                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:343:5: DOMAIN_LABEL iriAnnotatedList 
                    {
                    $this->match($this->input,$this->getToken('DOMAIN_LABEL'),self::$FOLLOW_DOMAIN_LABEL_in_annotationPropertyFrame1814); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1817);
                    $this->iriAnnotatedList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:344:5: RANGE_LABEL iriAnnotatedList 
                    {
                    $this->match($this->input,$this->getToken('RANGE_LABEL'),self::$FOLLOW_RANGE_LABEL_in_annotationPropertyFrame1823); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1826);
                    $this->iriAnnotatedList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:345:5: SUB_PROPERTY_OF_LABEL annotationPropertyIRIAnnotatedList 
                    {
                    $this->match($this->input,$this->getToken('SUB_PROPERTY_OF_LABEL'),self::$FOLLOW_SUB_PROPERTY_OF_LABEL_in_annotationPropertyFrame1832); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyFrame1834);
                    $this->annotationPropertyIRIAnnotatedList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 46, $annotationPropertyFrame_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 46, $annotationPropertyFrame_StartIndex); }
        
        return ;
    }
    // $ANTLR end "annotationPropertyFrame"


    // $ANTLR start "iriAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:348:1: iriAnnotatedList : ( annotations )? iri ( COMMA ( annotations )? iri )* ; 
    public function iriAnnotatedList(){
        $iriAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 47) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:349:3: ( ( annotations )? iri ( COMMA ( annotations )? iri )* ) 
            // src/Erfurt_Syntax_Manchester.g:349:5: ( annotations )? iri ( COMMA ( annotations )? iri )* 
            {
            // src/Erfurt_Syntax_Manchester.g:349:5: ( annotations )? 
            $alt48=2;
            $LA48 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA48)
                {
                $alt48=1;
                }
            else if($this->getToken('FULL_IRI')== $LA48)
                {
                $LA48_2 = $this->input->LA(2);

                if ( ($this->synpred78_Erfurt_Syntax_Manchester()) ) {
                    $alt48=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA48)
                {
                $LA48_3 = $this->input->LA(2);

                if ( ($this->synpred78_Erfurt_Syntax_Manchester()) ) {
                    $alt48=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA48)
                {
                $LA48_4 = $this->input->LA(2);

                if ( ($this->synpred78_Erfurt_Syntax_Manchester()) ) {
                    $alt48=1;
                }
                }

            switch ($alt48) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_iriAnnotatedList1849);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_iri_in_iriAnnotatedList1852);
            $this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:349:22: ( COMMA ( annotations )? iri )* 
            //loop50:
            do {
                $alt50=2;
                $LA50_0 = $this->input->LA(1);

                if ( ($LA50_0==$this->getToken('COMMA')) ) {
                    $alt50=1;
                }


                switch ($alt50) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:349:23: COMMA ( annotations )? iri 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_iriAnnotatedList1855); if ($this->state->failed) return ;
            	    // src/Erfurt_Syntax_Manchester.g:349:29: ( annotations )? 
            	    $alt49=2;
            	    $LA49 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA49)
            	        {
            	        $alt49=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA49)
            	        {
            	        $LA49_2 = $this->input->LA(2);

            	        if ( ($this->synpred79_Erfurt_Syntax_Manchester()) ) {
            	            $alt49=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA49)
            	        {
            	        $LA49_3 = $this->input->LA(2);

            	        if ( ($this->synpred79_Erfurt_Syntax_Manchester()) ) {
            	            $alt49=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA49)
            	        {
            	        $LA49_4 = $this->input->LA(2);

            	        if ( ($this->synpred79_Erfurt_Syntax_Manchester()) ) {
            	            $alt49=1;
            	        }
            	        }

            	    switch ($alt49) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_iriAnnotatedList1857);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return ;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_iri_in_iriAnnotatedList1860);
            	    $this->iri();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

            	    }
            	    break;

            	default :
            	    break 2;//loop50;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 47, $iriAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 47, $iriAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "iriAnnotatedList"


    // $ANTLR start "annotationPropertyIRI"
    // src/Erfurt_Syntax_Manchester.g:352:1: annotationPropertyIRI returns [$value] : iri ; 
    public function annotationPropertyIRI(){
        $value = null;
        $annotationPropertyIRI_StartIndex = $this->input->index();
        $iri34 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 48) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:353:2: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:353:4: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_annotationPropertyIRI1879);
            $iri34=$this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = $iri34;
            }

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 48, $annotationPropertyIRI_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 48, $annotationPropertyIRI_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "annotationPropertyIRI"


    // $ANTLR start "annotationPropertyIRIAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:356:1: annotationPropertyIRIAnnotatedList : ( annotations )? annotationPropertyIRI ( COMMA annotationPropertyIRIAnnotatedList )* ; 
    public function annotationPropertyIRIAnnotatedList(){
        $annotationPropertyIRIAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 49) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:357:3: ( ( annotations )? annotationPropertyIRI ( COMMA annotationPropertyIRIAnnotatedList )* ) 
            // src/Erfurt_Syntax_Manchester.g:357:5: ( annotations )? annotationPropertyIRI ( COMMA annotationPropertyIRIAnnotatedList )* 
            {
            // src/Erfurt_Syntax_Manchester.g:357:5: ( annotations )? 
            $alt51=2;
            $LA51 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA51)
                {
                $alt51=1;
                }
            else if($this->getToken('FULL_IRI')== $LA51)
                {
                $LA51_2 = $this->input->LA(2);

                if ( ($this->synpred81_Erfurt_Syntax_Manchester()) ) {
                    $alt51=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA51)
                {
                $LA51_3 = $this->input->LA(2);

                if ( ($this->synpred81_Erfurt_Syntax_Manchester()) ) {
                    $alt51=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA51)
                {
                $LA51_4 = $this->input->LA(2);

                if ( ($this->synpred81_Erfurt_Syntax_Manchester()) ) {
                    $alt51=1;
                }
                }

            switch ($alt51) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_annotationPropertyIRIAnnotatedList1895);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_annotationPropertyIRI_in_annotationPropertyIRIAnnotatedList1898);
            $this->annotationPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:357:40: ( COMMA annotationPropertyIRIAnnotatedList )* 
            //loop52:
            do {
                $alt52=2;
                $LA52_0 = $this->input->LA(1);

                if ( ($LA52_0==$this->getToken('COMMA')) ) {
                    $LA52_2 = $this->input->LA(2);

                    if ( ($this->synpred82_Erfurt_Syntax_Manchester()) ) {
                        $alt52=1;
                    }


                }


                switch ($alt52) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:357:41: COMMA annotationPropertyIRIAnnotatedList 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_annotationPropertyIRIAnnotatedList1901); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyIRIAnnotatedList1903);
            	    $this->annotationPropertyIRIAnnotatedList();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 49, $annotationPropertyIRIAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 49, $annotationPropertyIRIAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "annotationPropertyIRIAnnotatedList"


    // $ANTLR start "factAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:370:1: factAnnotatedList returns [$value] : ( annotations )? fact ( COMMA ( annotations )? fact )* ; 
    public function factAnnotatedList(){
        $value = null;
        $factAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 50) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:371:2: ( ( annotations )? fact ( COMMA ( annotations )? fact )* ) 
            // src/Erfurt_Syntax_Manchester.g:371:4: ( annotations )? fact ( COMMA ( annotations )? fact )* 
            {
            // src/Erfurt_Syntax_Manchester.g:371:4: ( annotations )? 
            $alt53=2;
            $LA53 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA53)
                {
                $alt53=1;
                }
            else if($this->getToken('NOT_LABEL')== $LA53)
                {
                $LA53_2 = $this->input->LA(2);

                if ( ($this->synpred83_Erfurt_Syntax_Manchester()) ) {
                    $alt53=1;
                }
                }
            else if($this->getToken('FULL_IRI')== $LA53)
                {
                $LA53_3 = $this->input->LA(2);

                if ( ($this->synpred83_Erfurt_Syntax_Manchester()) ) {
                    $alt53=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA53)
                {
                $LA53_4 = $this->input->LA(2);

                if ( ($this->synpred83_Erfurt_Syntax_Manchester()) ) {
                    $alt53=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA53)
                {
                $LA53_5 = $this->input->LA(2);

                if ( ($this->synpred83_Erfurt_Syntax_Manchester()) ) {
                    $alt53=1;
                }
                }

            switch ($alt53) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_factAnnotatedList1932);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_fact_in_factAnnotatedList1935);
            $this->fact();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:371:22: ( COMMA ( annotations )? fact )* 
            //loop55:
            do {
                $alt55=2;
                $LA55_0 = $this->input->LA(1);

                if ( ($LA55_0==$this->getToken('COMMA')) ) {
                    $alt55=1;
                }


                switch ($alt55) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:371:23: COMMA ( annotations )? fact 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_factAnnotatedList1938); if ($this->state->failed) return $value;
            	    // src/Erfurt_Syntax_Manchester.g:371:29: ( annotations )? 
            	    $alt54=2;
            	    $LA54 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA54)
            	        {
            	        $alt54=1;
            	        }
            	    else if($this->getToken('NOT_LABEL')== $LA54)
            	        {
            	        $LA54_2 = $this->input->LA(2);

            	        if ( ($this->synpred84_Erfurt_Syntax_Manchester()) ) {
            	            $alt54=1;
            	        }
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA54)
            	        {
            	        $LA54_3 = $this->input->LA(2);

            	        if ( ($this->synpred84_Erfurt_Syntax_Manchester()) ) {
            	            $alt54=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA54)
            	        {
            	        $LA54_4 = $this->input->LA(2);

            	        if ( ($this->synpred84_Erfurt_Syntax_Manchester()) ) {
            	            $alt54=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA54)
            	        {
            	        $LA54_5 = $this->input->LA(2);

            	        if ( ($this->synpred84_Erfurt_Syntax_Manchester()) ) {
            	            $alt54=1;
            	        }
            	        }

            	    switch ($alt54) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_factAnnotatedList1940);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return $value;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_fact_in_factAnnotatedList1943);
            	    $this->fact();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 50, $factAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 50, $factAnnotatedList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "factAnnotatedList"


    // $ANTLR start "individualAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:374:1: individualAnnotatedList returns [$value] : ( annotations )? individual ( COMMA ( annotations )? individual )* ; 
    public function individualAnnotatedList(){
        $value = null;
        $individualAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 51) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:375:3: ( ( annotations )? individual ( COMMA ( annotations )? individual )* ) 
            // src/Erfurt_Syntax_Manchester.g:375:5: ( annotations )? individual ( COMMA ( annotations )? individual )* 
            {
            // src/Erfurt_Syntax_Manchester.g:375:5: ( annotations )? 
            $alt56=2;
            $LA56 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA56)
                {
                $alt56=1;
                }
            else if($this->getToken('FULL_IRI')== $LA56)
                {
                $LA56_2 = $this->input->LA(2);

                if ( ($this->synpred86_Erfurt_Syntax_Manchester()) ) {
                    $alt56=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA56)
                {
                $LA56_3 = $this->input->LA(2);

                if ( ($this->synpred86_Erfurt_Syntax_Manchester()) ) {
                    $alt56=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA56)
                {
                $LA56_4 = $this->input->LA(2);

                if ( ($this->synpred86_Erfurt_Syntax_Manchester()) ) {
                    $alt56=1;
                }
                }
            else if($this->getToken('NODE_ID')== $LA56)
                {
                $LA56_5 = $this->input->LA(2);

                if ( ($this->synpred86_Erfurt_Syntax_Manchester()) ) {
                    $alt56=1;
                }
                }

            switch ($alt56) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_individualAnnotatedList1962);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_individual_in_individualAnnotatedList1965);
            $this->individual();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:375:29: ( COMMA ( annotations )? individual )* 
            //loop58:
            do {
                $alt58=2;
                $LA58_0 = $this->input->LA(1);

                if ( ($LA58_0==$this->getToken('COMMA')) ) {
                    $alt58=1;
                }


                switch ($alt58) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:375:30: COMMA ( annotations )? individual 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_individualAnnotatedList1968); if ($this->state->failed) return $value;
            	    // src/Erfurt_Syntax_Manchester.g:375:36: ( annotations )? 
            	    $alt57=2;
            	    $LA57 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA57)
            	        {
            	        $alt57=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA57)
            	        {
            	        $LA57_2 = $this->input->LA(2);

            	        if ( ($this->synpred87_Erfurt_Syntax_Manchester()) ) {
            	            $alt57=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA57)
            	        {
            	        $LA57_3 = $this->input->LA(2);

            	        if ( ($this->synpred87_Erfurt_Syntax_Manchester()) ) {
            	            $alt57=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA57)
            	        {
            	        $LA57_4 = $this->input->LA(2);

            	        if ( ($this->synpred87_Erfurt_Syntax_Manchester()) ) {
            	            $alt57=1;
            	        }
            	        }
            	    else if($this->getToken('NODE_ID')== $LA57)
            	        {
            	        $LA57_5 = $this->input->LA(2);

            	        if ( ($this->synpred87_Erfurt_Syntax_Manchester()) ) {
            	            $alt57=1;
            	        }
            	        }

            	    switch ($alt57) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_individualAnnotatedList1970);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return $value;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_individual_in_individualAnnotatedList1973);
            	    $this->individual();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 51, $individualAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 51, $individualAnnotatedList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "individualAnnotatedList"


    // $ANTLR start "fact"
    // src/Erfurt_Syntax_Manchester.g:378:1: fact : ( NOT_LABEL )? ( objectPropertyFact | dataPropertyFact ) ; 
    public function fact(){
        $fact_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 52) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:378:6: ( ( NOT_LABEL )? ( objectPropertyFact | dataPropertyFact ) ) 
            // src/Erfurt_Syntax_Manchester.g:378:8: ( NOT_LABEL )? ( objectPropertyFact | dataPropertyFact ) 
            {
            // src/Erfurt_Syntax_Manchester.g:378:8: ( NOT_LABEL )? 
            $alt59=2;
            $LA59_0 = $this->input->LA(1);

            if ( ($LA59_0==$this->getToken('NOT_LABEL')) ) {
                $alt59=1;
            }
            switch ($alt59) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: NOT_LABEL 
                    {
                    $this->match($this->input,$this->getToken('NOT_LABEL'),self::$FOLLOW_NOT_LABEL_in_fact1987); if ($this->state->failed) return ;

                    }
                    break;

            }

            // src/Erfurt_Syntax_Manchester.g:378:19: ( objectPropertyFact | dataPropertyFact ) 
            $alt60=2;
            $LA60 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA60)
                {
                $LA60_1 = $this->input->LA(2);

                if ( ($LA60_1==$this->getToken('DIGITS')||$LA60_1==$this->getToken('QUOTED_STRING')||($LA60_1>=$this->getToken('ILITERAL_HELPER') && $LA60_1<=$this->getToken('FPLITERAL_HELPER'))) ) {
                    $alt60=2;
                }
                else if ( (($LA60_1>=$this->getToken('FULL_IRI') && $LA60_1<=$this->getToken('NODE_ID'))||$LA60_1==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt60=1;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                    $nvae = new NoViableAltException("", 60, 1, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA60)
                {
                $LA60_2 = $this->input->LA(2);

                if ( ($LA60_2==$this->getToken('DIGITS')||$LA60_2==$this->getToken('QUOTED_STRING')||($LA60_2>=$this->getToken('ILITERAL_HELPER') && $LA60_2<=$this->getToken('FPLITERAL_HELPER'))) ) {
                    $alt60=2;
                }
                else if ( (($LA60_2>=$this->getToken('FULL_IRI') && $LA60_2<=$this->getToken('NODE_ID'))||$LA60_2==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt60=1;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                    $nvae = new NoViableAltException("", 60, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA60)
                {
                $LA60_3 = $this->input->LA(2);

                if ( (($LA60_3>=$this->getToken('FULL_IRI') && $LA60_3<=$this->getToken('NODE_ID'))||$LA60_3==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt60=1;
                }
                else if ( ($LA60_3==$this->getToken('DIGITS')||$LA60_3==$this->getToken('QUOTED_STRING')||($LA60_3>=$this->getToken('ILITERAL_HELPER') && $LA60_3<=$this->getToken('FPLITERAL_HELPER'))) ) {
                    $alt60=2;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                    $nvae = new NoViableAltException("", 60, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                $nvae =
                    new NoViableAltException("", 60, 0, $this->input);

                throw $nvae;
            }

            switch ($alt60) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:378:20: objectPropertyFact 
                    {
                    $this->pushFollow(self::$FOLLOW_objectPropertyFact_in_fact1991);
                    $this->objectPropertyFact();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:378:41: dataPropertyFact 
                    {
                    $this->pushFollow(self::$FOLLOW_dataPropertyFact_in_fact1995);
                    $this->dataPropertyFact();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 52, $fact_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 52, $fact_StartIndex); }
        
        return ;
    }
    // $ANTLR end "fact"


    // $ANTLR start "objectPropertyFact"
    // src/Erfurt_Syntax_Manchester.g:380:1: objectPropertyFact : objectPropertyIRI individual ; 
    public function objectPropertyFact(){
        $objectPropertyFact_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 53) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:381:3: ( objectPropertyIRI individual ) 
            // src/Erfurt_Syntax_Manchester.g:381:5: objectPropertyIRI individual 
            {
            $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_objectPropertyFact2006);
            $this->objectPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_individual_in_objectPropertyFact2008);
            $this->individual();

            $this->state->_fsp--;
            if ($this->state->failed) return ;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 53, $objectPropertyFact_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 53, $objectPropertyFact_StartIndex); }
        
        return ;
    }
    // $ANTLR end "objectPropertyFact"


    // $ANTLR start "dataPropertyFact"
    // src/Erfurt_Syntax_Manchester.g:384:1: dataPropertyFact : dataPropertyIRI literal ; 
    public function dataPropertyFact(){
        $dataPropertyFact_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 54) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:385:3: ( dataPropertyIRI literal ) 
            // src/Erfurt_Syntax_Manchester.g:385:5: dataPropertyIRI literal 
            {
            $this->pushFollow(self::$FOLLOW_dataPropertyIRI_in_dataPropertyFact2022);
            $this->dataPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_literal_in_dataPropertyFact2024);
            $this->literal();

            $this->state->_fsp--;
            if ($this->state->failed) return ;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 54, $dataPropertyFact_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 54, $dataPropertyFact_StartIndex); }
        
        return ;
    }
    // $ANTLR end "dataPropertyFact"


    // $ANTLR start "datatypeFrame"
    // src/Erfurt_Syntax_Manchester.g:388:1: datatypeFrame : DATATYPE_LABEL dataType ( ANNOTATIONS_LABEL annotationAnnotatedList )* ( EQUIVALENT_TO_LABEL annotations dataRange )? ( ANNOTATIONS_LABEL annotationAnnotatedList )* ; 
    public function datatypeFrame(){
        $datatypeFrame_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 55) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:389:3: ( DATATYPE_LABEL dataType ( ANNOTATIONS_LABEL annotationAnnotatedList )* ( EQUIVALENT_TO_LABEL annotations dataRange )? ( ANNOTATIONS_LABEL annotationAnnotatedList )* ) 
            // src/Erfurt_Syntax_Manchester.g:389:5: DATATYPE_LABEL dataType ( ANNOTATIONS_LABEL annotationAnnotatedList )* ( EQUIVALENT_TO_LABEL annotations dataRange )? ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
            {
            $this->match($this->input,$this->getToken('DATATYPE_LABEL'),self::$FOLLOW_DATATYPE_LABEL_in_datatypeFrame2038); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_dataType_in_datatypeFrame2041);
            $this->dataType();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:390:4: ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
            //loop61:
            do {
                $alt61=2;
                $LA61_0 = $this->input->LA(1);

                if ( ($LA61_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                    $LA61_2 = $this->input->LA(2);

                    if ( ($this->synpred91_Erfurt_Syntax_Manchester()) ) {
                        $alt61=1;
                    }


                }


                switch ($alt61) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:390:5: ANNOTATIONS_LABEL annotationAnnotatedList 
            	    {
            	    $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2047); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_datatypeFrame2050);
            	    $this->annotationAnnotatedList();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

            	    }
            	    break;

            	default :
            	    break 2;//loop61;
                }
            } while (true);

            // src/Erfurt_Syntax_Manchester.g:391:4: ( EQUIVALENT_TO_LABEL annotations dataRange )? 
            $alt62=2;
            $LA62_0 = $this->input->LA(1);

            if ( ($LA62_0==$this->getToken('EQUIVALENT_TO_LABEL')) ) {
                $alt62=1;
            }
            switch ($alt62) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:391:5: EQUIVALENT_TO_LABEL annotations dataRange 
                    {
                    $this->match($this->input,$this->getToken('EQUIVALENT_TO_LABEL'),self::$FOLLOW_EQUIVALENT_TO_LABEL_in_datatypeFrame2058); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_annotations_in_datatypeFrame2061);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_dataRange_in_datatypeFrame2063);
                    $this->dataRange();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            // src/Erfurt_Syntax_Manchester.g:392:4: ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
            //loop63:
            do {
                $alt63=2;
                $LA63_0 = $this->input->LA(1);

                if ( ($LA63_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                    $alt63=1;
                }


                switch ($alt63) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:392:5: ANNOTATIONS_LABEL annotationAnnotatedList 
            	    {
            	    $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2071); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_datatypeFrame2074);
            	    $this->annotationAnnotatedList();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

            	    }
            	    break;

            	default :
            	    break 2;//loop63;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 55, $datatypeFrame_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 55, $datatypeFrame_StartIndex); }
        
        return ;
    }
    // $ANTLR end "datatypeFrame"


    // $ANTLR start "individual2List"
    // src/Erfurt_Syntax_Manchester.g:404:1: individual2List : individual COMMA individualList ; 
    public function individual2List(){
        $individual2List_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 56) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:405:2: ( individual COMMA individualList ) 
            // src/Erfurt_Syntax_Manchester.g:405:4: individual COMMA individualList 
            {
            $this->pushFollow(self::$FOLLOW_individual_in_individual2List2099);
            $this->individual();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_individual2List2101); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_individualList_in_individual2List2103);
            $this->individualList();

            $this->state->_fsp--;
            if ($this->state->failed) return ;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 56, $individual2List_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 56, $individual2List_StartIndex); }
        
        return ;
    }
    // $ANTLR end "individual2List"


    // $ANTLR start "dataProperty2List"
    // src/Erfurt_Syntax_Manchester.g:408:1: dataProperty2List : dataProperty COMMA dataPropertyList ; 
    public function dataProperty2List(){
        $dataProperty2List_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 57) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:409:3: ( dataProperty COMMA dataPropertyList ) 
            // src/Erfurt_Syntax_Manchester.g:409:5: dataProperty COMMA dataPropertyList 
            {
            $this->pushFollow(self::$FOLLOW_dataProperty_in_dataProperty2List2115);
            $this->dataProperty();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataProperty2List2117); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_dataPropertyList_in_dataProperty2List2119);
            $this->dataPropertyList();

            $this->state->_fsp--;
            if ($this->state->failed) return ;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 57, $dataProperty2List_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 57, $dataProperty2List_StartIndex); }
        
        return ;
    }
    // $ANTLR end "dataProperty2List"


    // $ANTLR start "dataPropertyList"
    // src/Erfurt_Syntax_Manchester.g:412:1: dataPropertyList : dataProperty ( COMMA dataProperty )* ; 
    public function dataPropertyList(){
        $dataPropertyList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 58) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:413:2: ( dataProperty ( COMMA dataProperty )* ) 
            // src/Erfurt_Syntax_Manchester.g:413:4: dataProperty ( COMMA dataProperty )* 
            {
            $this->pushFollow(self::$FOLLOW_dataProperty_in_dataPropertyList2133);
            $this->dataProperty();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:413:17: ( COMMA dataProperty )* 
            //loop64:
            do {
                $alt64=2;
                $LA64_0 = $this->input->LA(1);

                if ( ($LA64_0==$this->getToken('COMMA')) ) {
                    $alt64=1;
                }


                switch ($alt64) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:413:18: COMMA dataProperty 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataPropertyList2136); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_dataProperty_in_dataPropertyList2138);
            	    $this->dataProperty();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

            	    }
            	    break;

            	default :
            	    break 2;//loop64;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 58, $dataPropertyList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 58, $dataPropertyList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "dataPropertyList"


    // $ANTLR start "objectProperty2List"
    // src/Erfurt_Syntax_Manchester.g:416:1: objectProperty2List : objectProperty COMMA objectPropertyList ; 
    public function objectProperty2List(){
        $objectProperty2List_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 59) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:417:3: ( objectProperty COMMA objectPropertyList ) 
            // src/Erfurt_Syntax_Manchester.g:417:5: objectProperty COMMA objectPropertyList 
            {
            $this->pushFollow(self::$FOLLOW_objectProperty_in_objectProperty2List2154);
            $this->objectProperty();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectProperty2List2156); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_objectPropertyList_in_objectProperty2List2158);
            $this->objectPropertyList();

            $this->state->_fsp--;
            if ($this->state->failed) return ;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 59, $objectProperty2List_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 59, $objectProperty2List_StartIndex); }
        
        return ;
    }
    // $ANTLR end "objectProperty2List"


    // $ANTLR start "objectPropertyList"
    // src/Erfurt_Syntax_Manchester.g:420:1: objectPropertyList : objectProperty ( COMMA objectProperty )* ; 
    public function objectPropertyList(){
        $objectPropertyList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 60) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:421:3: ( objectProperty ( COMMA objectProperty )* ) 
            // src/Erfurt_Syntax_Manchester.g:421:5: objectProperty ( COMMA objectProperty )* 
            {
            $this->pushFollow(self::$FOLLOW_objectProperty_in_objectPropertyList2172);
            $this->objectProperty();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:421:20: ( COMMA objectProperty )* 
            //loop65:
            do {
                $alt65=2;
                $LA65_0 = $this->input->LA(1);

                if ( ($LA65_0==$this->getToken('COMMA')) ) {
                    $alt65=1;
                }


                switch ($alt65) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:421:21: COMMA objectProperty 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectPropertyList2175); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_objectProperty_in_objectPropertyList2177);
            	    $this->objectProperty();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

            	    }
            	    break;

            	default :
            	    break 2;//loop65;
                }
            } while (true);


            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 60, $objectPropertyList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 60, $objectPropertyList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "objectPropertyList"


    // $ANTLR start "entity"
    // src/Erfurt_Syntax_Manchester.g:434:1: entity : ( DATATYPE_LABEL OPEN_BRACE dataType CLOSE_BRACE | CLASS_LABEL OPEN_BRACE classIRI CLOSE_BRACE | OBJECT_PROPERTY_LABEL OPEN_BRACE objectPropertyIRI CLOSE_BRACE | DATA_PROPERTY_LABEL OPEN_BRACE datatypePropertyIRI CLOSE_BRACE | ANNOTATION_PROPERTY_LABEL OPEN_BRACE annotationPropertyIRI CLOSE_BRACE | NAMED_INDIVIDUAL_LABEL OPEN_BRACE individualIRI CLOSE_BRACE ); 
    public function entity(){
        $entity_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 61) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:435:3: ( DATATYPE_LABEL OPEN_BRACE dataType CLOSE_BRACE | CLASS_LABEL OPEN_BRACE classIRI CLOSE_BRACE | OBJECT_PROPERTY_LABEL OPEN_BRACE objectPropertyIRI CLOSE_BRACE | DATA_PROPERTY_LABEL OPEN_BRACE datatypePropertyIRI CLOSE_BRACE | ANNOTATION_PROPERTY_LABEL OPEN_BRACE annotationPropertyIRI CLOSE_BRACE | NAMED_INDIVIDUAL_LABEL OPEN_BRACE individualIRI CLOSE_BRACE ) 
            $alt66=6;
            $LA66 = $this->input->LA(1);
            if($this->getToken('DATATYPE_LABEL')== $LA66)
                {
                $alt66=1;
                }
            else if($this->getToken('CLASS_LABEL')== $LA66)
                {
                $alt66=2;
                }
            else if($this->getToken('OBJECT_PROPERTY_LABEL')== $LA66)
                {
                $alt66=3;
                }
            else if($this->getToken('DATA_PROPERTY_LABEL')== $LA66)
                {
                $alt66=4;
                }
            else if($this->getToken('ANNOTATION_PROPERTY_LABEL')== $LA66)
                {
                $alt66=5;
                }
            else if($this->getToken('NAMED_INDIVIDUAL_LABEL')== $LA66)
                {
                $alt66=6;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                $nvae =
                    new NoViableAltException("", 66, 0, $this->input);

                throw $nvae;
            }

            switch ($alt66) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:435:5: DATATYPE_LABEL OPEN_BRACE dataType CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('DATATYPE_LABEL'),self::$FOLLOW_DATATYPE_LABEL_in_entity2203); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2205); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_dataType_in_entity2207);
                    $this->dataType();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2209); if ($this->state->failed) return ;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:436:5: CLASS_LABEL OPEN_BRACE classIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('CLASS_LABEL'),self::$FOLLOW_CLASS_LABEL_in_entity2215); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2217); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_classIRI_in_entity2219);
                    $this->classIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2221); if ($this->state->failed) return ;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:437:5: OBJECT_PROPERTY_LABEL OPEN_BRACE objectPropertyIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OBJECT_PROPERTY_LABEL'),self::$FOLLOW_OBJECT_PROPERTY_LABEL_in_entity2227); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2229); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_entity2231);
                    $this->objectPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2233); if ($this->state->failed) return ;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:438:5: DATA_PROPERTY_LABEL OPEN_BRACE datatypePropertyIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('DATA_PROPERTY_LABEL'),self::$FOLLOW_DATA_PROPERTY_LABEL_in_entity2239); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2241); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_datatypePropertyIRI_in_entity2243);
                    $this->datatypePropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2245); if ($this->state->failed) return ;

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:439:5: ANNOTATION_PROPERTY_LABEL OPEN_BRACE annotationPropertyIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ANNOTATION_PROPERTY_LABEL'),self::$FOLLOW_ANNOTATION_PROPERTY_LABEL_in_entity2251); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2253); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_annotationPropertyIRI_in_entity2255);
                    $this->annotationPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2257); if ($this->state->failed) return ;

                    }
                    break;
                case 6 :
                    // src/Erfurt_Syntax_Manchester.g:440:5: NAMED_INDIVIDUAL_LABEL OPEN_BRACE individualIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('NAMED_INDIVIDUAL_LABEL'),self::$FOLLOW_NAMED_INDIVIDUAL_LABEL_in_entity2263); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2265); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_individualIRI_in_entity2267);
                    $this->individualIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2269); if ($this->state->failed) return ;

                    }
                    break;

            }
        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 61, $entity_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 61, $entity_StartIndex); }
        
        return ;
    }
    // $ANTLR end "entity"


    // $ANTLR start "ontologyIri"
    // src/Erfurt_Syntax_Manchester.g:447:1: ontologyIri : iri ; 
    public function ontologyIri(){
        $ontologyIri_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 62) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:448:2: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:448:4: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_ontologyIri2286);
            $this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return ;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 62, $ontologyIri_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 62, $ontologyIri_StartIndex); }
        
        return ;
    }
    // $ANTLR end "ontologyIri"


    // $ANTLR start "versionIri"
    // src/Erfurt_Syntax_Manchester.g:451:1: versionIri : iri ; 
    public function versionIri(){
        $versionIri_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 63) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:452:2: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:452:4: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_versionIri2297);
            $this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return ;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 63, $versionIri_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 63, $versionIri_StartIndex); }
        
        return ;
    }
    // $ANTLR end "versionIri"


    // $ANTLR start "imports"
    // src/Erfurt_Syntax_Manchester.g:455:1: imports : IMPORT_LABEL iri ; 
    public function imports(){
        $imports_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 64) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:455:9: ( IMPORT_LABEL iri ) 
            // src/Erfurt_Syntax_Manchester.g:455:11: IMPORT_LABEL iri 
            {
            $this->match($this->input,$this->getToken('IMPORT_LABEL'),self::$FOLLOW_IMPORT_LABEL_in_imports2307); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_iri_in_imports2309);
            $this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return ;

            }

        }
        catch (RecognitionException $re) {
            $this->reportError($re);
            $this->recover($this->input,$re);
        }
        catch(Exception $e) {
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 64, $imports_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 64, $imports_StartIndex); }
        
        return ;
    }
    // $ANTLR end "imports"

    // $ANTLR start synpred18_Erfurt_Syntax_Manchester
    public function synpred18_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:59:3: (o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) | ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) ) ) 
        // src/Erfurt_Syntax_Manchester.g:59:3: o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) | ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) ) 
        {
        $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_synpred18_Erfurt_Syntax_Manchester277);
        $o=$this->objectPropertyExpression();

        $this->state->_fsp--;
        if ($this->state->failed) return ;
        // src/Erfurt_Syntax_Manchester.g:60:5: ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) | ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) ) 
        $alt72=7;
        $LA72 = $this->input->LA(1);
        if($this->getToken('SOME_LABEL')== $LA72)
            {
            $alt72=1;
            }
        else if($this->getToken('ONLY_LABEL')== $LA72)
            {
            $alt72=2;
            }
        else if($this->getToken('VALUE_LABEL')== $LA72)
            {
            $alt72=3;
            }
        else if($this->getToken('SELF_LABEL')== $LA72)
            {
            $alt72=4;
            }
        else if($this->getToken('MIN_LABEL')== $LA72)
            {
            $alt72=5;
            }
        else if($this->getToken('MAX_LABEL')== $LA72)
            {
            $alt72=6;
            }
        else if($this->getToken('EXACTLY_LABEL')== $LA72)
            {
            $alt72=7;
            }
        else{
            if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
            $nvae =
                new NoViableAltException("", 72, 0, $this->input);

            throw $nvae;
        }

        switch ($alt72) {
            case 1 :
                // src/Erfurt_Syntax_Manchester.g:60:6: ( SOME_LABEL p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:60:6: ( SOME_LABEL p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:60:7: SOME_LABEL p= primary 
                {
                $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_synpred18_Erfurt_Syntax_Manchester285); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester289);
                $p=$this->primary();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 2 :
                // src/Erfurt_Syntax_Manchester.g:61:7: ( ONLY_LABEL p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:61:7: ( ONLY_LABEL p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:61:8: ONLY_LABEL p= primary 
                {
                $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_synpred18_Erfurt_Syntax_Manchester301); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester305);
                $p=$this->primary();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 3 :
                // src/Erfurt_Syntax_Manchester.g:62:7: ( VALUE_LABEL i= individual ) 
                {
                // src/Erfurt_Syntax_Manchester.g:62:7: ( VALUE_LABEL i= individual ) 
                // src/Erfurt_Syntax_Manchester.g:62:8: VALUE_LABEL i= individual 
                {
                $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_synpred18_Erfurt_Syntax_Manchester317); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_individual_in_synpred18_Erfurt_Syntax_Manchester321);
                $i=$this->individual();

                $this->state->_fsp--;
                if ($this->state->failed) return ;

                }


                }
                break;
            case 4 :
                // src/Erfurt_Syntax_Manchester.g:63:7: ( SELF_LABEL ) 
                {
                // src/Erfurt_Syntax_Manchester.g:63:7: ( SELF_LABEL ) 
                // src/Erfurt_Syntax_Manchester.g:63:8: SELF_LABEL 
                {
                $this->match($this->input,$this->getToken('SELF_LABEL'),self::$FOLLOW_SELF_LABEL_in_synpred18_Erfurt_Syntax_Manchester333); if ($this->state->failed) return ;

                }


                }
                break;
            case 5 :
                // src/Erfurt_Syntax_Manchester.g:64:7: ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) 
                {
                // src/Erfurt_Syntax_Manchester.g:64:7: ( MIN_LABEL nni= nonNegativeInteger (p= primary )? ) 
                // src/Erfurt_Syntax_Manchester.g:64:8: MIN_LABEL nni= nonNegativeInteger (p= primary )? 
                {
                $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_synpred18_Erfurt_Syntax_Manchester345); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester349);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:64:42: (p= primary )? 
                $alt69=2;
                $LA69_0 = $this->input->LA(1);

                if ( ($LA69_0==$this->getToken('INVERSE_LABEL')||$LA69_0==$this->getToken('NOT_LABEL')||$LA69_0==$this->getToken('OPEN_CURLY_BRACE')||$LA69_0==$this->getToken('OPEN_BRACE')||($LA69_0>=$this->getToken('FULL_IRI') && $LA69_0<=$this->getToken('SIMPLE_IRI'))||$LA69_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt69=1;
                }
                switch ($alt69) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: p= primary 
                        {
                        $this->pushFollow(self::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester353);
                        $p=$this->primary();

                        $this->state->_fsp--;
                        if ($this->state->failed) return ;

                        }
                        break;

                }


                }


                }
                break;
            case 6 :
                // src/Erfurt_Syntax_Manchester.g:65:7: ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) 
                {
                // src/Erfurt_Syntax_Manchester.g:65:7: ( MAX_LABEL nni= nonNegativeInteger (p= primary )? ) 
                // src/Erfurt_Syntax_Manchester.g:65:8: MAX_LABEL nni= nonNegativeInteger (p= primary )? 
                {
                $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_synpred18_Erfurt_Syntax_Manchester366); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester370);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:65:42: (p= primary )? 
                $alt70=2;
                $LA70_0 = $this->input->LA(1);

                if ( ($LA70_0==$this->getToken('INVERSE_LABEL')||$LA70_0==$this->getToken('NOT_LABEL')||$LA70_0==$this->getToken('OPEN_CURLY_BRACE')||$LA70_0==$this->getToken('OPEN_BRACE')||($LA70_0>=$this->getToken('FULL_IRI') && $LA70_0<=$this->getToken('SIMPLE_IRI'))||$LA70_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt70=1;
                }
                switch ($alt70) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: p= primary 
                        {
                        $this->pushFollow(self::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester374);
                        $p=$this->primary();

                        $this->state->_fsp--;
                        if ($this->state->failed) return ;

                        }
                        break;

                }


                }


                }
                break;
            case 7 :
                // src/Erfurt_Syntax_Manchester.g:66:7: ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) 
                {
                // src/Erfurt_Syntax_Manchester.g:66:7: ( EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? ) 
                // src/Erfurt_Syntax_Manchester.g:66:8: EXACTLY_LABEL nni= nonNegativeInteger (p= primary )? 
                {
                $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_synpred18_Erfurt_Syntax_Manchester387); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester391);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:66:46: (p= primary )? 
                $alt71=2;
                $LA71_0 = $this->input->LA(1);

                if ( ($LA71_0==$this->getToken('INVERSE_LABEL')||$LA71_0==$this->getToken('NOT_LABEL')||$LA71_0==$this->getToken('OPEN_CURLY_BRACE')||$LA71_0==$this->getToken('OPEN_BRACE')||($LA71_0>=$this->getToken('FULL_IRI') && $LA71_0<=$this->getToken('SIMPLE_IRI'))||$LA71_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt71=1;
                }
                switch ($alt71) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: p= primary 
                        {
                        $this->pushFollow(self::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester395);
                        $p=$this->primary();

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
    // $ANTLR end synpred18_Erfurt_Syntax_Manchester

    // $ANTLR start synpred56_Erfurt_Syntax_Manchester
    public function synpred56_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:245:10: ( OR_LABEL d2= dataConjunction ) 
        // src/Erfurt_Syntax_Manchester.g:245:10: OR_LABEL d2= dataConjunction 
        {
        $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_synpred56_Erfurt_Syntax_Manchester1453); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_dataConjunction_in_synpred56_Erfurt_Syntax_Manchester1457);
        $d2=$this->dataConjunction();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred56_Erfurt_Syntax_Manchester

    // $ANTLR start synpred57_Erfurt_Syntax_Manchester
    public function synpred57_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:251:14: ( AND_LABEL d2= dataPrimary ) 
        // src/Erfurt_Syntax_Manchester.g:251:14: AND_LABEL d2= dataPrimary 
        {
        $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_synpred57_Erfurt_Syntax_Manchester1499); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_dataPrimary_in_synpred57_Erfurt_Syntax_Manchester1503);
        $d2=$this->dataPrimary();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred57_Erfurt_Syntax_Manchester

    // $ANTLR start synpred58_Erfurt_Syntax_Manchester
    public function synpred58_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:258:4: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:258:4: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred58_Erfurt_Syntax_Manchester1526);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred58_Erfurt_Syntax_Manchester

    // $ANTLR start synpred59_Erfurt_Syntax_Manchester
    public function synpred59_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:258:35: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:258:35: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred59_Erfurt_Syntax_Manchester1534);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred59_Erfurt_Syntax_Manchester

    // $ANTLR start synpred65_Erfurt_Syntax_Manchester
    public function synpred65_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:313:4: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:313:4: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred65_Erfurt_Syntax_Manchester1695);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred65_Erfurt_Syntax_Manchester

    // $ANTLR start synpred66_Erfurt_Syntax_Manchester
    public function synpred66_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:313:55: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:313:55: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred66_Erfurt_Syntax_Manchester1703);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred66_Erfurt_Syntax_Manchester

    // $ANTLR start synpred68_Erfurt_Syntax_Manchester
    public function synpred68_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:317:5: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:317:5: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred68_Erfurt_Syntax_Manchester1721);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred68_Erfurt_Syntax_Manchester

    // $ANTLR start synpred69_Erfurt_Syntax_Manchester
    public function synpred69_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:317:50: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:317:50: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred69_Erfurt_Syntax_Manchester1729);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred69_Erfurt_Syntax_Manchester

    // $ANTLR start synpred71_Erfurt_Syntax_Manchester
    public function synpred71_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:337:6: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:337:6: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred71_Erfurt_Syntax_Manchester1766);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred71_Erfurt_Syntax_Manchester

    // $ANTLR start synpred72_Erfurt_Syntax_Manchester
    public function synpred72_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:337:49: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:337:49: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred72_Erfurt_Syntax_Manchester1774);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred72_Erfurt_Syntax_Manchester

    // $ANTLR start synpred78_Erfurt_Syntax_Manchester
    public function synpred78_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:349:5: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:349:5: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred78_Erfurt_Syntax_Manchester1849);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred78_Erfurt_Syntax_Manchester

    // $ANTLR start synpred79_Erfurt_Syntax_Manchester
    public function synpred79_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:349:29: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:349:29: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred79_Erfurt_Syntax_Manchester1857);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred79_Erfurt_Syntax_Manchester

    // $ANTLR start synpred81_Erfurt_Syntax_Manchester
    public function synpred81_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:357:5: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:357:5: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred81_Erfurt_Syntax_Manchester1895);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred81_Erfurt_Syntax_Manchester

    // $ANTLR start synpred82_Erfurt_Syntax_Manchester
    public function synpred82_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:357:41: ( COMMA annotationPropertyIRIAnnotatedList ) 
        // src/Erfurt_Syntax_Manchester.g:357:41: COMMA annotationPropertyIRIAnnotatedList 
        {
        $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_synpred82_Erfurt_Syntax_Manchester1901); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_annotationPropertyIRIAnnotatedList_in_synpred82_Erfurt_Syntax_Manchester1903);
        $this->annotationPropertyIRIAnnotatedList();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred82_Erfurt_Syntax_Manchester

    // $ANTLR start synpred83_Erfurt_Syntax_Manchester
    public function synpred83_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:371:4: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:371:4: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred83_Erfurt_Syntax_Manchester1932);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred83_Erfurt_Syntax_Manchester

    // $ANTLR start synpred84_Erfurt_Syntax_Manchester
    public function synpred84_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:371:29: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:371:29: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred84_Erfurt_Syntax_Manchester1940);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred84_Erfurt_Syntax_Manchester

    // $ANTLR start synpred86_Erfurt_Syntax_Manchester
    public function synpred86_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:375:5: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:375:5: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred86_Erfurt_Syntax_Manchester1962);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred86_Erfurt_Syntax_Manchester

    // $ANTLR start synpred87_Erfurt_Syntax_Manchester
    public function synpred87_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:375:36: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:375:36: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred87_Erfurt_Syntax_Manchester1970);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred87_Erfurt_Syntax_Manchester

    // $ANTLR start synpred91_Erfurt_Syntax_Manchester
    public function synpred91_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:390:5: ( ANNOTATIONS_LABEL annotationAnnotatedList ) 
        // src/Erfurt_Syntax_Manchester.g:390:5: ANNOTATIONS_LABEL annotationAnnotatedList 
        {
        $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_synpred91_Erfurt_Syntax_Manchester2047); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_synpred91_Erfurt_Syntax_Manchester2050);
        $this->annotationAnnotatedList();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred91_Erfurt_Syntax_Manchester

    // Delegated rules

    public function synpred86_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred86_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred84_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred84_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred56_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred56_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred58_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred58_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred79_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred79_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred66_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred66_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred65_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred65_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred83_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred83_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred78_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred78_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred71_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred71_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred72_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred72_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred81_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred81_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred18_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred18_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred87_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred87_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred82_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred82_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred59_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred59_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred69_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred69_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred91_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred91_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred57_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred57_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred68_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred68_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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

class Erfurt_Syntax_ManchesterParser_DFA21_static {
	static function getValues(){
		$eot = array(12, 65535);
		$eof = array(1, 65535, 7, 10, 4, 65535);
		$min = array(1, 24, 7, 26, 4, 65535);
		$max = array(1, 91, 7, 84, 4, 65535);
		$accept = array(8, 65535, 1, 2, 1, 4, 1, 1, 1, 3);
		$special = array(12, 65535);
		$transitionS = array(array(1, 8, 11, 65535, 1, 9, 1, 65535, 1, 5, 1, 6, 
    1, 4, 1, 7, 39, 65535, 1, 1, 1, 3, 8, 65535, 1, 2), array(2, 10, 7, 
    65535, 1, 10, 1, 65535, 1, 10, 34, 65535, 1, 10, 11, 65535, 1, 11), 
    array(2, 10, 7, 65535, 1, 10, 1, 65535, 1, 10, 34, 65535, 1, 10, 11, 
    65535, 1, 11), array(2, 10, 7, 65535, 1, 10, 1, 65535, 1, 10, 34, 65535, 
    1, 10, 11, 65535, 1, 11), array(2, 10, 7, 65535, 1, 10, 1, 65535, 1, 
    10, 34, 65535, 1, 10, 11, 65535, 1, 11), array(2, 10, 7, 65535, 1, 10, 
    1, 65535, 1, 10, 34, 65535, 1, 10, 11, 65535, 1, 11), array(2, 10, 7, 
    65535, 1, 10, 1, 65535, 1, 10, 34, 65535, 1, 10, 11, 65535, 1, 11), 
    array(2, 10, 7, 65535, 1, 10, 1, 65535, 1, 10, 34, 65535, 1, 10, 11, 
    65535, 1, 11), array(), array(), array(), array());
		
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
//$Erfurt_Syntax_ManchesterParser_DFA21 = Erfurt_Syntax_ManchesterParser_DFA21_static();

class Erfurt_Syntax_ManchesterParser_DFA21 extends DFA {

    public function __construct($recognizer) {
//        global $Erfurt_Syntax_ManchesterParser_DFA21;
//        $DFA = $Erfurt_Syntax_ManchesterParser_DFA21;
		$DFA = Erfurt_Syntax_ManchesterParser_DFA21_static::getValues();
        $this->recognizer = $recognizer;
        $this->decisionNumber = 21;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "118:1: dataAtomic returns [$value] : ( ( dataType ) | ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) | ( dataTypeRestriction ) | ( OPEN_BRACE dataRange CLOSE_BRACE ) );";
    }
}
 



Erfurt_Syntax_ManchesterParser::$FOLLOW_conjunction_in_description69 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_description82 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_conjunction_in_description86 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_conjunction116 = new Set(array(11));
Erfurt_Syntax_ManchesterParser::$FOLLOW_THAT_LABEL_in_conjunction118 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_conjunction126 = new Set(array(1, 27));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_conjunction135 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_conjunction139 = new Set(array(1, 27));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NOT_LABEL_in_primary165 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_restriction_in_primary172 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_atomic_in_primary178 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FULL_IRI_in_iri207 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ABBREVIATED_IRI_in_iri215 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SIMPLE_IRI_in_iri223 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_objectPropertyExpression248 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_inverseObjectProperty_in_objectPropertyExpression256 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_restriction277 = new Set(array(28, 29, 30, 31, 32, 33, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_restriction285 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction289 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_restriction301 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction305 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_restriction317 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_restriction321 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SELF_LABEL_in_restriction333 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_restriction345 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction349 = new Set(array(1, 12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction353 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_restriction366 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction370 = new Set(array(1, 12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction374 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_restriction387 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction391 = new Set(array(1, 12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction395 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_restriction411 = new Set(array(28, 29, 30, 32, 33, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_restriction419 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction423 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_restriction433 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction437 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_restriction447 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_restriction451 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_restriction460 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction464 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction468 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_restriction479 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction483 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction487 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_restriction498 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction502 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction506 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_atomic539 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_CURLY_BRACE_in_atomic547 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualList_in_atomic549 = new Set(array(25));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_CURLY_BRACE_in_atomic551 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_atomic559 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_description_in_atomic561 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_atomic563 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_classIRI584 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualList607 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_individualList616 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualList620 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualIRI_in_individual645 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NODE_ID_in_individual653 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DIGITS_in_nonNegativeInteger674 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NOT_LABEL_in_dataPrimary698 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataAtomic_in_dataPrimary702 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyIRI_in_dataPropertyExpression725 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_dataAtomic747 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic757 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literalList_in_dataAtomic759 = new Set(array(25));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic761 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataTypeRestriction_in_dataAtomic771 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_dataAtomic781 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_dataAtomic783 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_dataAtomic785 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_literalList809 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_literalList816 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_literalList820 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_datatypeIRI_in_dataType843 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_INTEGER_LABEL_in_dataType853 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DECIMAL_LABEL_in_dataType864 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FLOAT_LABEL_in_dataType874 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_STRING_LABEL_in_dataType884 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_typedLiteral_in_literal911 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_stringLiteralNoLanguage_in_literal917 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_stringLiteralWithLanguage_in_literal923 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_integerLiteral_in_literal929 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_decimalLiteral_in_literal935 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_floatingPointLiteral_in_literal941 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage960 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage981 = new Set(array(88));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage983 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_lexicalValue1004 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_lexicalValue_in_typedLiteral1025 = new Set(array(42));
Erfurt_Syntax_ManchesterParser::$FOLLOW_REFERENCE_in_typedLiteral1027 = new Set(array(38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_typedLiteral1029 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_restrictionValue1050 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1071 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_inverseObjectProperty1073 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DLITERAL_HELPER_in_decimalLiteral1094 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ILITERAL_HELPER_in_integerLiteral1116 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DIGITS_in_integerLiteral1122 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1144 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_objectProperty1165 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyIRI_in_dataProperty1186 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_dataPropertyIRI1207 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_datatypeIRI1228 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_objectPropertyIRI1249 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_dataTypeRestriction1270 = new Set(array(84));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1274 = new Set(array(6, 7, 8, 9, 10, 20, 21, 22, 23));
Erfurt_Syntax_ManchesterParser::$FOLLOW_facet_in_dataTypeRestriction1288 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_restrictionValue_in_dataTypeRestriction1292 = new Set(array(6, 7, 8, 9, 10, 20, 21, 22, 23, 35, 85));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataTypeRestriction1296 = new Set(array(6, 7, 8, 9, 10, 20, 21, 22, 23, 85));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1303 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_individualIRI1322 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_datatypePropertyIRI1343 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LENGTH_LABEL_in_facet1370 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LENGTH_LABEL_in_facet1376 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LENGTH_LABEL_in_facet1382 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_PATTERN_LABEL_in_facet1388 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LANG_PATTERN_LABEL_in_facet1394 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LESS_EQUAL_in_facet1400 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LESS_in_facet1406 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_GREATER_EQUAL_in_facet1412 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_GREATER_in_facet1418 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_dataRange1439 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_dataRange1453 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_dataRange1457 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_dataConjunction1482 = new Set(array(1, 27));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_dataConjunction1499 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_dataConjunction1503 = new Set(array(1, 27));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_annotationAnnotatedList1526 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotation_in_annotationAnnotatedList1529 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_annotationAnnotatedList1532 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_annotationAnnotatedList1534 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotation_in_annotationAnnotatedList1537 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRI_in_annotation1556 = new Set(array(16, 81, 82, 83, 87, 91, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationTarget_in_annotation1560 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NODE_ID_in_annotationTarget1577 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_annotationTarget1584 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_annotationTarget1591 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_annotations1608 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_annotations1612 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_description_in_descriptionList1643 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_descriptionList1648 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_description_in_descriptionList1652 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1695 = new Set(array(75));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1698 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_objectPropertyCharacteristicAnnotatedList1701 = new Set(array(72, 75));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1703 = new Set(array(75));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1706 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1721 = new Set(array(12, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1724 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_objectPropertyExpressionAnnotatedList1727 = new Set(array(12, 72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1729 = new Set(array(12, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1732 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1766 = new Set(array(12, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1769 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataPropertyExpressionAnnotatedList1772 = new Set(array(12, 72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1774 = new Set(array(12, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1777 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATION_PROPERTY_LABEL_in_annotationPropertyFrame1794 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRI_in_annotationPropertyFrame1796 = new Set(array(1, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_annotationPropertyFrame1802 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_annotationPropertyFrame1805 = new Set(array(1, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DOMAIN_LABEL_in_annotationPropertyFrame1814 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1817 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_RANGE_LABEL_in_annotationPropertyFrame1823 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1826 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SUB_PROPERTY_OF_LABEL_in_annotationPropertyFrame1832 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyFrame1834 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_iriAnnotatedList1849 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_iriAnnotatedList1852 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_iriAnnotatedList1855 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_iriAnnotatedList1857 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_iriAnnotatedList1860 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_annotationPropertyIRI1879 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_annotationPropertyIRIAnnotatedList1895 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRI_in_annotationPropertyIRIAnnotatedList1898 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_annotationPropertyIRIAnnotatedList1901 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyIRIAnnotatedList1903 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_factAnnotatedList1932 = new Set(array(12, 17, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_fact_in_factAnnotatedList1935 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_factAnnotatedList1938 = new Set(array(12, 17, 72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_factAnnotatedList1940 = new Set(array(12, 17, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_fact_in_factAnnotatedList1943 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_individualAnnotatedList1962 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualAnnotatedList1965 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_individualAnnotatedList1968 = new Set(array(72, 81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_individualAnnotatedList1970 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualAnnotatedList1973 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NOT_LABEL_in_fact1987 = new Set(array(12, 17, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyFact_in_fact1991 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyFact_in_fact1995 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_objectPropertyFact2006 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_objectPropertyFact2008 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyIRI_in_dataPropertyFact2022 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_dataPropertyFact2024 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DATATYPE_LABEL_in_datatypeFrame2038 = new Set(array(38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_datatypeFrame2041 = new Set(array(1, 65, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2047 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_datatypeFrame2050 = new Set(array(1, 65, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EQUIVALENT_TO_LABEL_in_datatypeFrame2058 = new Set(array(17, 24, 36, 38, 39, 40, 41, 72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_datatypeFrame2061 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_datatypeFrame2063 = new Set(array(1, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2071 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_datatypeFrame2074 = new Set(array(1, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individual2List2099 = new Set(array(35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_individual2List2101 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualList_in_individual2List2103 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataProperty_in_dataProperty2List2115 = new Set(array(35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataProperty2List2117 = new Set(array(12, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyList_in_dataProperty2List2119 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataProperty_in_dataPropertyList2133 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataPropertyList2136 = new Set(array(12, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataProperty_in_dataPropertyList2138 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectProperty_in_objectProperty2List2154 = new Set(array(35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_objectProperty2List2156 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyList_in_objectProperty2List2158 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectProperty_in_objectPropertyList2172 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_objectPropertyList2175 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectProperty_in_objectPropertyList2177 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DATATYPE_LABEL_in_entity2203 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2205 = new Set(array(38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_entity2207 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2209 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLASS_LABEL_in_entity2215 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2217 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_entity2219 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2221 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OBJECT_PROPERTY_LABEL_in_entity2227 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2229 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_entity2231 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2233 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DATA_PROPERTY_LABEL_in_entity2239 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2241 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_datatypePropertyIRI_in_entity2243 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2245 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATION_PROPERTY_LABEL_in_entity2251 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2253 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRI_in_entity2255 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2257 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NAMED_INDIVIDUAL_LABEL_in_entity2263 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2265 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualIRI_in_entity2267 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2269 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_ontologyIri2286 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_versionIri2297 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_IMPORT_LABEL_in_imports2307 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_imports2309 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_synpred18_Erfurt_Syntax_Manchester277 = new Set(array(28, 29, 30, 31, 32, 33, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_synpred18_Erfurt_Syntax_Manchester285 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester289 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_synpred18_Erfurt_Syntax_Manchester301 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester305 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_synpred18_Erfurt_Syntax_Manchester317 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_synpred18_Erfurt_Syntax_Manchester321 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SELF_LABEL_in_synpred18_Erfurt_Syntax_Manchester333 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_synpred18_Erfurt_Syntax_Manchester345 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester349 = new Set(array(1, 12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester353 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_synpred18_Erfurt_Syntax_Manchester366 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester370 = new Set(array(1, 12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester374 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_synpred18_Erfurt_Syntax_Manchester387 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred18_Erfurt_Syntax_Manchester391 = new Set(array(1, 12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred18_Erfurt_Syntax_Manchester395 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_synpred56_Erfurt_Syntax_Manchester1453 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_synpred56_Erfurt_Syntax_Manchester1457 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_synpred57_Erfurt_Syntax_Manchester1499 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_synpred57_Erfurt_Syntax_Manchester1503 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred58_Erfurt_Syntax_Manchester1526 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred59_Erfurt_Syntax_Manchester1534 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred65_Erfurt_Syntax_Manchester1695 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred66_Erfurt_Syntax_Manchester1703 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred68_Erfurt_Syntax_Manchester1721 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred69_Erfurt_Syntax_Manchester1729 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred71_Erfurt_Syntax_Manchester1766 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred72_Erfurt_Syntax_Manchester1774 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred78_Erfurt_Syntax_Manchester1849 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred79_Erfurt_Syntax_Manchester1857 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred81_Erfurt_Syntax_Manchester1895 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_synpred82_Erfurt_Syntax_Manchester1901 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRIAnnotatedList_in_synpred82_Erfurt_Syntax_Manchester1903 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred83_Erfurt_Syntax_Manchester1932 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred84_Erfurt_Syntax_Manchester1940 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred86_Erfurt_Syntax_Manchester1962 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred87_Erfurt_Syntax_Manchester1970 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_synpred91_Erfurt_Syntax_Manchester2047 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_synpred91_Erfurt_Syntax_Manchester2050 = new Set(array(1));

?>