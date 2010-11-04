<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 src/Erfurt_Syntax_Manchester.g 2010-11-04 23:29:17


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
    static $FOLLOW_classIRI_in_conjunction120;
    static $FOLLOW_THAT_LABEL_in_conjunction122;
    static $FOLLOW_primary_in_conjunction130;
    static $FOLLOW_AND_LABEL_in_conjunction139;
    static $FOLLOW_primary_in_conjunction143;
    static $FOLLOW_NOT_LABEL_in_primary169;
    static $FOLLOW_restriction_in_primary176;
    static $FOLLOW_atomic_in_primary182;
    static $FOLLOW_FULL_IRI_in_iri211;
    static $FOLLOW_ABBREVIATED_IRI_in_iri219;
    static $FOLLOW_SIMPLE_IRI_in_iri227;
    static $FOLLOW_objectPropertyIRI_in_objectPropertyExpression252;
    static $FOLLOW_inverseObjectProperty_in_objectPropertyExpression260;
    static $FOLLOW_objectPropertyExpression_in_restriction281;
    static $FOLLOW_SOME_LABEL_in_restriction289;
    static $FOLLOW_primary_in_restriction293;
    static $FOLLOW_ONLY_LABEL_in_restriction305;
    static $FOLLOW_primary_in_restriction309;
    static $FOLLOW_VALUE_LABEL_in_restriction321;
    static $FOLLOW_individual_in_restriction325;
    static $FOLLOW_SELF_LABEL_in_restriction337;
    static $FOLLOW_MIN_LABEL_in_restriction349;
    static $FOLLOW_nonNegativeInteger_in_restriction353;
    static $FOLLOW_primary_in_restriction357;
    static $FOLLOW_MAX_LABEL_in_restriction369;
    static $FOLLOW_nonNegativeInteger_in_restriction373;
    static $FOLLOW_primary_in_restriction377;
    static $FOLLOW_EXACTLY_LABEL_in_restriction389;
    static $FOLLOW_nonNegativeInteger_in_restriction393;
    static $FOLLOW_primary_in_restriction397;
    static $FOLLOW_dataPropertyExpression_in_restriction412;
    static $FOLLOW_SOME_LABEL_in_restriction420;
    static $FOLLOW_dataRange_in_restriction424;
    static $FOLLOW_ONLY_LABEL_in_restriction434;
    static $FOLLOW_dataRange_in_restriction438;
    static $FOLLOW_VALUE_LABEL_in_restriction448;
    static $FOLLOW_literal_in_restriction452;
    static $FOLLOW_MIN_LABEL_in_restriction461;
    static $FOLLOW_nonNegativeInteger_in_restriction465;
    static $FOLLOW_dataRange_in_restriction469;
    static $FOLLOW_MAX_LABEL_in_restriction480;
    static $FOLLOW_nonNegativeInteger_in_restriction484;
    static $FOLLOW_dataRange_in_restriction488;
    static $FOLLOW_EXACTLY_LABEL_in_restriction499;
    static $FOLLOW_nonNegativeInteger_in_restriction503;
    static $FOLLOW_dataRange_in_restriction507;
    static $FOLLOW_objectPropertyExpression_in_restriction534;
    static $FOLLOW_EXACTLY_LABEL_in_restriction536;
    static $FOLLOW_nonNegativeInteger_in_restriction540;
    static $FOLLOW_classIRI_in_atomic562;
    static $FOLLOW_OPEN_CURLY_BRACE_in_atomic570;
    static $FOLLOW_individualList_in_atomic572;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_atomic574;
    static $FOLLOW_OPEN_BRACE_in_atomic582;
    static $FOLLOW_description_in_atomic584;
    static $FOLLOW_CLOSE_BRACE_in_atomic586;
    static $FOLLOW_iri_in_classIRI607;
    static $FOLLOW_individual_in_individualList630;
    static $FOLLOW_COMMA_in_individualList639;
    static $FOLLOW_individual_in_individualList643;
    static $FOLLOW_individualIRI_in_individual668;
    static $FOLLOW_NODE_ID_in_individual676;
    static $FOLLOW_DIGITS_in_nonNegativeInteger697;
    static $FOLLOW_NOT_LABEL_in_dataPrimary721;
    static $FOLLOW_dataAtomic_in_dataPrimary725;
    static $FOLLOW_dataPropertyIRI_in_dataPropertyExpression748;
    static $FOLLOW_dataType_in_dataAtomic770;
    static $FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic780;
    static $FOLLOW_literalList_in_dataAtomic782;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic784;
    static $FOLLOW_dataTypeRestriction_in_dataAtomic794;
    static $FOLLOW_OPEN_BRACE_in_dataAtomic804;
    static $FOLLOW_dataRange_in_dataAtomic806;
    static $FOLLOW_CLOSE_BRACE_in_dataAtomic808;
    static $FOLLOW_literal_in_literalList832;
    static $FOLLOW_COMMA_in_literalList839;
    static $FOLLOW_literal_in_literalList843;
    static $FOLLOW_datatypeIRI_in_dataType866;
    static $FOLLOW_INTEGER_LABEL_in_dataType876;
    static $FOLLOW_DECIMAL_LABEL_in_dataType887;
    static $FOLLOW_FLOAT_LABEL_in_dataType897;
    static $FOLLOW_STRING_LABEL_in_dataType907;
    static $FOLLOW_typedLiteral_in_literal934;
    static $FOLLOW_stringLiteralNoLanguage_in_literal940;
    static $FOLLOW_stringLiteralWithLanguage_in_literal946;
    static $FOLLOW_integerLiteral_in_literal952;
    static $FOLLOW_decimalLiteral_in_literal958;
    static $FOLLOW_floatingPointLiteral_in_literal964;
    static $FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage983;
    static $FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage1004;
    static $FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage1006;
    static $FOLLOW_QUOTED_STRING_in_lexicalValue1027;
    static $FOLLOW_lexicalValue_in_typedLiteral1048;
    static $FOLLOW_REFERENCE_in_typedLiteral1050;
    static $FOLLOW_dataType_in_typedLiteral1052;
    static $FOLLOW_literal_in_restrictionValue1073;
    static $FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1094;
    static $FOLLOW_objectPropertyIRI_in_inverseObjectProperty1096;
    static $FOLLOW_DLITERAL_HELPER_in_decimalLiteral1117;
    static $FOLLOW_ILITERAL_HELPER_in_integerLiteral1139;
    static $FOLLOW_DIGITS_in_integerLiteral1145;
    static $FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1167;
    static $FOLLOW_objectPropertyIRI_in_objectProperty1188;
    static $FOLLOW_dataPropertyIRI_in_dataProperty1209;
    static $FOLLOW_iri_in_dataPropertyIRI1230;
    static $FOLLOW_iri_in_datatypeIRI1251;
    static $FOLLOW_iri_in_objectPropertyIRI1272;
    static $FOLLOW_dataType_in_dataTypeRestriction1293;
    static $FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1297;
    static $FOLLOW_facet_in_dataTypeRestriction1311;
    static $FOLLOW_restrictionValue_in_dataTypeRestriction1315;
    static $FOLLOW_COMMA_in_dataTypeRestriction1319;
    static $FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1326;
    static $FOLLOW_iri_in_individualIRI1345;
    static $FOLLOW_iri_in_datatypePropertyIRI1366;
    static $FOLLOW_LENGTH_LABEL_in_facet1393;
    static $FOLLOW_MIN_LENGTH_LABEL_in_facet1399;
    static $FOLLOW_MAX_LENGTH_LABEL_in_facet1405;
    static $FOLLOW_PATTERN_LABEL_in_facet1411;
    static $FOLLOW_LANG_PATTERN_LABEL_in_facet1417;
    static $FOLLOW_LESS_EQUAL_in_facet1423;
    static $FOLLOW_LESS_in_facet1429;
    static $FOLLOW_GREATER_EQUAL_in_facet1435;
    static $FOLLOW_GREATER_in_facet1441;
    static $FOLLOW_dataConjunction_in_dataRange1470;
    static $FOLLOW_OR_LABEL_in_dataRange1484;
    static $FOLLOW_dataConjunction_in_dataRange1488;
    static $FOLLOW_dataPrimary_in_dataConjunction1521;
    static $FOLLOW_AND_LABEL_in_dataConjunction1538;
    static $FOLLOW_dataPrimary_in_dataConjunction1542;
    static $FOLLOW_annotations_in_annotationAnnotatedList1565;
    static $FOLLOW_annotation_in_annotationAnnotatedList1568;
    static $FOLLOW_COMMA_in_annotationAnnotatedList1571;
    static $FOLLOW_annotations_in_annotationAnnotatedList1573;
    static $FOLLOW_annotation_in_annotationAnnotatedList1576;
    static $FOLLOW_annotationPropertyIRI_in_annotation1595;
    static $FOLLOW_annotationTarget_in_annotation1599;
    static $FOLLOW_NODE_ID_in_annotationTarget1616;
    static $FOLLOW_iri_in_annotationTarget1623;
    static $FOLLOW_literal_in_annotationTarget1630;
    static $FOLLOW_ANNOTATIONS_LABEL_in_annotations1647;
    static $FOLLOW_annotationAnnotatedList_in_annotations1651;
    static $FOLLOW_description_in_descriptionList1682;
    static $FOLLOW_COMMA_in_descriptionList1687;
    static $FOLLOW_description_in_descriptionList1691;
    static $FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1734;
    static $FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1737;
    static $FOLLOW_COMMA_in_objectPropertyCharacteristicAnnotatedList1740;
    static $FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1742;
    static $FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1745;
    static $FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1760;
    static $FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1763;
    static $FOLLOW_COMMA_in_objectPropertyExpressionAnnotatedList1766;
    static $FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1768;
    static $FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1771;
    static $FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1805;
    static $FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1808;
    static $FOLLOW_COMMA_in_dataPropertyExpressionAnnotatedList1811;
    static $FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1813;
    static $FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1816;
    static $FOLLOW_ANNOTATION_PROPERTY_LABEL_in_annotationPropertyFrame1833;
    static $FOLLOW_annotationPropertyIRI_in_annotationPropertyFrame1835;
    static $FOLLOW_ANNOTATIONS_LABEL_in_annotationPropertyFrame1841;
    static $FOLLOW_annotationAnnotatedList_in_annotationPropertyFrame1844;
    static $FOLLOW_DOMAIN_LABEL_in_annotationPropertyFrame1853;
    static $FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1856;
    static $FOLLOW_RANGE_LABEL_in_annotationPropertyFrame1862;
    static $FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1865;
    static $FOLLOW_SUB_PROPERTY_OF_LABEL_in_annotationPropertyFrame1871;
    static $FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyFrame1873;
    static $FOLLOW_annotations_in_iriAnnotatedList1888;
    static $FOLLOW_iri_in_iriAnnotatedList1891;
    static $FOLLOW_COMMA_in_iriAnnotatedList1894;
    static $FOLLOW_annotations_in_iriAnnotatedList1896;
    static $FOLLOW_iri_in_iriAnnotatedList1899;
    static $FOLLOW_iri_in_annotationPropertyIRI1918;
    static $FOLLOW_annotations_in_annotationPropertyIRIAnnotatedList1934;
    static $FOLLOW_annotationPropertyIRI_in_annotationPropertyIRIAnnotatedList1937;
    static $FOLLOW_COMMA_in_annotationPropertyIRIAnnotatedList1940;
    static $FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyIRIAnnotatedList1942;
    static $FOLLOW_annotations_in_factAnnotatedList1971;
    static $FOLLOW_fact_in_factAnnotatedList1974;
    static $FOLLOW_COMMA_in_factAnnotatedList1977;
    static $FOLLOW_annotations_in_factAnnotatedList1979;
    static $FOLLOW_fact_in_factAnnotatedList1982;
    static $FOLLOW_annotations_in_individualAnnotatedList2001;
    static $FOLLOW_individual_in_individualAnnotatedList2004;
    static $FOLLOW_COMMA_in_individualAnnotatedList2007;
    static $FOLLOW_annotations_in_individualAnnotatedList2009;
    static $FOLLOW_individual_in_individualAnnotatedList2012;
    static $FOLLOW_NOT_LABEL_in_fact2026;
    static $FOLLOW_objectPropertyFact_in_fact2030;
    static $FOLLOW_dataPropertyFact_in_fact2034;
    static $FOLLOW_objectPropertyIRI_in_objectPropertyFact2045;
    static $FOLLOW_individual_in_objectPropertyFact2047;
    static $FOLLOW_dataPropertyIRI_in_dataPropertyFact2061;
    static $FOLLOW_literal_in_dataPropertyFact2063;
    static $FOLLOW_DATATYPE_LABEL_in_datatypeFrame2077;
    static $FOLLOW_dataType_in_datatypeFrame2080;
    static $FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2086;
    static $FOLLOW_annotationAnnotatedList_in_datatypeFrame2089;
    static $FOLLOW_EQUIVALENT_TO_LABEL_in_datatypeFrame2097;
    static $FOLLOW_annotations_in_datatypeFrame2100;
    static $FOLLOW_dataRange_in_datatypeFrame2102;
    static $FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2110;
    static $FOLLOW_annotationAnnotatedList_in_datatypeFrame2113;
    static $FOLLOW_individual_in_individual2List2138;
    static $FOLLOW_COMMA_in_individual2List2140;
    static $FOLLOW_individualList_in_individual2List2142;
    static $FOLLOW_dataProperty_in_dataProperty2List2154;
    static $FOLLOW_COMMA_in_dataProperty2List2156;
    static $FOLLOW_dataPropertyList_in_dataProperty2List2158;
    static $FOLLOW_dataProperty_in_dataPropertyList2172;
    static $FOLLOW_COMMA_in_dataPropertyList2175;
    static $FOLLOW_dataProperty_in_dataPropertyList2177;
    static $FOLLOW_objectProperty_in_objectProperty2List2193;
    static $FOLLOW_COMMA_in_objectProperty2List2195;
    static $FOLLOW_objectPropertyList_in_objectProperty2List2197;
    static $FOLLOW_objectProperty_in_objectPropertyList2211;
    static $FOLLOW_COMMA_in_objectPropertyList2214;
    static $FOLLOW_objectProperty_in_objectPropertyList2216;
    static $FOLLOW_DATATYPE_LABEL_in_entity2242;
    static $FOLLOW_OPEN_BRACE_in_entity2244;
    static $FOLLOW_dataType_in_entity2246;
    static $FOLLOW_CLOSE_BRACE_in_entity2248;
    static $FOLLOW_CLASS_LABEL_in_entity2254;
    static $FOLLOW_OPEN_BRACE_in_entity2256;
    static $FOLLOW_classIRI_in_entity2258;
    static $FOLLOW_CLOSE_BRACE_in_entity2260;
    static $FOLLOW_OBJECT_PROPERTY_LABEL_in_entity2266;
    static $FOLLOW_OPEN_BRACE_in_entity2268;
    static $FOLLOW_objectPropertyIRI_in_entity2270;
    static $FOLLOW_CLOSE_BRACE_in_entity2272;
    static $FOLLOW_DATA_PROPERTY_LABEL_in_entity2278;
    static $FOLLOW_OPEN_BRACE_in_entity2280;
    static $FOLLOW_datatypePropertyIRI_in_entity2282;
    static $FOLLOW_CLOSE_BRACE_in_entity2284;
    static $FOLLOW_ANNOTATION_PROPERTY_LABEL_in_entity2290;
    static $FOLLOW_OPEN_BRACE_in_entity2292;
    static $FOLLOW_annotationPropertyIRI_in_entity2294;
    static $FOLLOW_CLOSE_BRACE_in_entity2296;
    static $FOLLOW_NAMED_INDIVIDUAL_LABEL_in_entity2302;
    static $FOLLOW_OPEN_BRACE_in_entity2304;
    static $FOLLOW_individualIRI_in_entity2306;
    static $FOLLOW_CLOSE_BRACE_in_entity2308;
    static $FOLLOW_iri_in_ontologyIri2325;
    static $FOLLOW_iri_in_versionIri2336;
    static $FOLLOW_IMPORT_LABEL_in_imports2346;
    static $FOLLOW_iri_in_imports2348;
    static $FOLLOW_objectPropertyExpression_in_synpred15_Erfurt_Syntax_Manchester281;
    static $FOLLOW_SOME_LABEL_in_synpred15_Erfurt_Syntax_Manchester289;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester293;
    static $FOLLOW_ONLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester305;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester309;
    static $FOLLOW_VALUE_LABEL_in_synpred15_Erfurt_Syntax_Manchester321;
    static $FOLLOW_individual_in_synpred15_Erfurt_Syntax_Manchester325;
    static $FOLLOW_SELF_LABEL_in_synpred15_Erfurt_Syntax_Manchester337;
    static $FOLLOW_MIN_LABEL_in_synpred15_Erfurt_Syntax_Manchester349;
    static $FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester353;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester357;
    static $FOLLOW_MAX_LABEL_in_synpred15_Erfurt_Syntax_Manchester369;
    static $FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester373;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester377;
    static $FOLLOW_EXACTLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester389;
    static $FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester393;
    static $FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester397;
    static $FOLLOW_dataPropertyExpression_in_synpred24_Erfurt_Syntax_Manchester412;
    static $FOLLOW_SOME_LABEL_in_synpred24_Erfurt_Syntax_Manchester420;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester424;
    static $FOLLOW_ONLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester434;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester438;
    static $FOLLOW_VALUE_LABEL_in_synpred24_Erfurt_Syntax_Manchester448;
    static $FOLLOW_literal_in_synpred24_Erfurt_Syntax_Manchester452;
    static $FOLLOW_MIN_LABEL_in_synpred24_Erfurt_Syntax_Manchester461;
    static $FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester465;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester469;
    static $FOLLOW_MAX_LABEL_in_synpred24_Erfurt_Syntax_Manchester480;
    static $FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester484;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester488;
    static $FOLLOW_EXACTLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester499;
    static $FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester503;
    static $FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester507;
    static $FOLLOW_OR_LABEL_in_synpred54_Erfurt_Syntax_Manchester1484;
    static $FOLLOW_dataConjunction_in_synpred54_Erfurt_Syntax_Manchester1488;
    static $FOLLOW_AND_LABEL_in_synpred55_Erfurt_Syntax_Manchester1538;
    static $FOLLOW_dataPrimary_in_synpred55_Erfurt_Syntax_Manchester1542;
    static $FOLLOW_annotations_in_synpred56_Erfurt_Syntax_Manchester1565;
    static $FOLLOW_annotations_in_synpred57_Erfurt_Syntax_Manchester1573;
    static $FOLLOW_annotations_in_synpred63_Erfurt_Syntax_Manchester1734;
    static $FOLLOW_annotations_in_synpred64_Erfurt_Syntax_Manchester1742;
    static $FOLLOW_annotations_in_synpred66_Erfurt_Syntax_Manchester1760;
    static $FOLLOW_annotations_in_synpred67_Erfurt_Syntax_Manchester1768;
    static $FOLLOW_annotations_in_synpred69_Erfurt_Syntax_Manchester1805;
    static $FOLLOW_annotations_in_synpred70_Erfurt_Syntax_Manchester1813;
    static $FOLLOW_annotations_in_synpred76_Erfurt_Syntax_Manchester1888;
    static $FOLLOW_annotations_in_synpred77_Erfurt_Syntax_Manchester1896;
    static $FOLLOW_annotations_in_synpred79_Erfurt_Syntax_Manchester1934;
    static $FOLLOW_COMMA_in_synpred80_Erfurt_Syntax_Manchester1940;
    static $FOLLOW_annotationPropertyIRIAnnotatedList_in_synpred80_Erfurt_Syntax_Manchester1942;
    static $FOLLOW_annotations_in_synpred81_Erfurt_Syntax_Manchester1971;
    static $FOLLOW_annotations_in_synpred82_Erfurt_Syntax_Manchester1979;
    static $FOLLOW_annotations_in_synpred84_Erfurt_Syntax_Manchester2001;
    static $FOLLOW_annotations_in_synpred85_Erfurt_Syntax_Manchester2009;
    static $FOLLOW_ANNOTATIONS_LABEL_in_synpred89_Erfurt_Syntax_Manchester2086;
    static $FOLLOW_annotationAnnotatedList_in_synpred89_Erfurt_Syntax_Manchester2089;

    
    protected $dfa18;
    

        public function __construct($input, $state = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state);
            $this->state->ruleMemo = array();
             
            for ($i=0; $i < 162; $i++) { 
                $this->state->ruleMemo[$i] = array();				
            }
             
            
            $this->dfa18 = new Erfurt_Syntax_ManchesterParser_DFA18($this);
            
        }
        

    public function getTokenNames() { return Erfurt_Syntax_ManchesterParser::$tokenNames; }
    public function getGrammarFileName() { return "src/Erfurt_Syntax_Manchester.g"; }



    // $ANTLR start "description"
    // src/Erfurt_Syntax_Manchester.g:11:1: description returns [$value] : c1= conjunction ( OR_LABEL c2= conjunction )* ; 
    public function description(){
        $value = null;
        $description_StartIndex = $this->input->index();
        $c1 = null;

        $c2 = null;



        $ce = new Erfurt_Owl_Structured_ClassExpression();

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 1) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:23:3: (c1= conjunction ( OR_LABEL c2= conjunction )* ) 
            // src/Erfurt_Syntax_Manchester.g:24:3: c1= conjunction ( OR_LABEL c2= conjunction )* 
            {
            $this->pushFollow(self::$FOLLOW_conjunction_in_description69);
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
            	    $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_description82); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_conjunction_in_description86);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 1, $description_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 1, $description_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "description"


    // $ANTLR start "conjunction"
    // src/Erfurt_Syntax_Manchester.g:28:1: conjunction returns [$value] : (c= classIRI THAT_LABEL )? p1= primary ( AND_LABEL p2= primary )* ; 
    public function conjunction(){
        $value = null;
        $conjunction_StartIndex = $this->input->index();
        $c = null;

        $p1 = null;

        $p2 = null;



        $ce = new Erfurt_Owl_Structured_ClassExpression();

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 2) ) { return $value; }
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
                    $this->pushFollow(self::$FOLLOW_classIRI_in_conjunction120);
                    $c=$this->classIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('THAT_LABEL'),self::$FOLLOW_THAT_LABEL_in_conjunction122); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $ce->addElement($c);
                    }

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_primary_in_conjunction130);
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
            	    $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_conjunction139); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_primary_in_conjunction143);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 2, $conjunction_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 2, $conjunction_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "conjunction"


    // $ANTLR start "primary"
    // src/Erfurt_Syntax_Manchester.g:46:1: primary returns [$value] : (n= NOT_LABEL )? (v= restriction | v= atomic ) ; 
    public function primary(){
        $value = null;
        $primary_StartIndex = $this->input->index();
        $n=null;
        $v = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 3) ) { return $value; }
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
                    $n=$this->match($this->input,$this->getToken('NOT_LABEL'),self::$FOLLOW_NOT_LABEL_in_primary169); if ($this->state->failed) return $value;

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
                    // src/Erfurt_Syntax_Manchester.g:48:19: v= restriction 
                    {
                    $this->pushFollow(self::$FOLLOW_restriction_in_primary176);
                    $v=$this->restriction();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:48:35: v= atomic 
                    {
                    $this->pushFollow(self::$FOLLOW_atomic_in_primary182);
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
    // src/Erfurt_Syntax_Manchester.g:54:1: iri returns [$value] : (v= FULL_IRI | v= ABBREVIATED_IRI | v= SIMPLE_IRI ); 
    public function iri(){
        $value = null;
        $iri_StartIndex = $this->input->index();
        $v=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 4) ) { return $value; }
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
                    $v=$this->match($this->input,$this->getToken('FULL_IRI'),self::$FOLLOW_FULL_IRI_in_iri211); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:60:5: v= ABBREVIATED_IRI 
                    {
                    $v=$this->match($this->input,$this->getToken('ABBREVIATED_IRI'),self::$FOLLOW_ABBREVIATED_IRI_in_iri219); if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:61:5: v= SIMPLE_IRI 
                    {
                    $v=$this->match($this->input,$this->getToken('SIMPLE_IRI'),self::$FOLLOW_SIMPLE_IRI_in_iri227); if ($this->state->failed) return $value;

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
    // src/Erfurt_Syntax_Manchester.g:64:1: objectPropertyExpression returns [$value] : (v= objectPropertyIRI | v= inverseObjectProperty ); 
    public function objectPropertyExpression(){
        $value = null;
        $objectPropertyExpression_StartIndex = $this->input->index();
        $v = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 5) ) { return $value; }
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
                    $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_objectPropertyExpression252);
                    $v=$this->objectPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:68:5: v= inverseObjectProperty 
                    {
                    $this->pushFollow(self::$FOLLOW_inverseObjectProperty_in_objectPropertyExpression260);
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
    // src/Erfurt_Syntax_Manchester.g:71:1: restriction returns [$value] : (o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) | dp= dataPropertyExpression ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) | (o= objectPropertyExpression EXACTLY_LABEL nni= nonNegativeInteger ) ); 
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
                    $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_restriction281);
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
                            $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_restriction289); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction293);
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
                            $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_restriction305); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction309);
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
                            $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_restriction321); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_individual_in_restriction325);
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
                            $this->match($this->input,$this->getToken('SELF_LABEL'),self::$FOLLOW_SELF_LABEL_in_restriction337); if ($this->state->failed) return $value;
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
                            $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_restriction349); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction353);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction357);
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
                            $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_restriction369); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction373);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction377);
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
                            $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_restriction389); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction393);
                            $nni=$this->nonNegativeInteger();

                            $this->state->_fsp--;
                            if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_primary_in_restriction397);
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
                    $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_restriction412);
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
                            $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_restriction420); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_dataRange_in_restriction424);
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
                            $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_restriction434); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_dataRange_in_restriction438);
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
                            $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_restriction448); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_literal_in_restriction452);
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
                            $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_restriction461); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction465);
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
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction469);
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
                            $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_restriction480); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction484);
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
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction488);
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
                            $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_restriction499); if ($this->state->failed) return $value;
                            $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction503);
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
                                    $this->pushFollow(self::$FOLLOW_dataRange_in_restriction507);
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
                    $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_restriction534);
                    $o=$this->objectPropertyExpression();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_restriction536); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_restriction540);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 6, $restriction_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 6, $restriction_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "restriction"


    // $ANTLR start "atomic"
    // src/Erfurt_Syntax_Manchester.g:96:1: atomic returns [$value] : ( classIRI | OPEN_CURLY_BRACE individualList CLOSE_CURLY_BRACE | OPEN_BRACE description CLOSE_BRACE ); 
    public function atomic(){
        $value = null;
        $atomic_StartIndex = $this->input->index();
        $classIRI1 = null;

        $individualList2 = null;

        $description3 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 7) ) { return $value; }
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
                    $this->pushFollow(self::$FOLLOW_classIRI_in_atomic562);
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
                    $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_atomic570); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_individualList_in_atomic572);
                    $individualList2=$this->individualList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_atomic574); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = new Erfurt_Owl_Structured_ClassExpression_ObjectOneOf($individualList2);
                    }

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:100:5: OPEN_BRACE description CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_atomic582); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_description_in_atomic584);
                    $description3=$this->description();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_atomic586); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:103:1: classIRI returns [$value] : iri ; 
    public function classIRI(){
        $value = null;
        $classIRI_StartIndex = $this->input->index();
        $iri4 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 8) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:104:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:105:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_classIRI607);
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
    // src/Erfurt_Syntax_Manchester.g:108:1: individualList returns [$value] : i= individual ( COMMA i1= individual )* ; 
    public function individualList(){
        $value = null;
        $individualList_StartIndex = $this->input->index();
        $i = null;

        $i1 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 9) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:109:3: (i= individual ( COMMA i1= individual )* ) 
            // src/Erfurt_Syntax_Manchester.g:110:3: i= individual ( COMMA i1= individual )* 
            {
            $this->pushFollow(self::$FOLLOW_individual_in_individualList630);
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
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_individualList639); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_individual_in_individualList643);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 9, $individualList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 9, $individualList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "individualList"


    // $ANTLR start "individual"
    // src/Erfurt_Syntax_Manchester.g:114:1: individual returns [$value] : (i= individualIRI | NODE_ID ); 
    public function individual(){
        $value = null;
        $individual_StartIndex = $this->input->index();
        $NODE_ID5=null;
        $i = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 10) ) { return $value; }
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
                    $this->pushFollow(self::$FOLLOW_individualIRI_in_individual668);
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
                    $NODE_ID5=$this->match($this->input,$this->getToken('NODE_ID'),self::$FOLLOW_NODE_ID_in_individual676); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:120:1: nonNegativeInteger returns [$value] : DIGITS ; 
    public function nonNegativeInteger(){
        $value = null;
        $nonNegativeInteger_StartIndex = $this->input->index();
        $DIGITS6=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 11) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:121:3: ( DIGITS ) 
            // src/Erfurt_Syntax_Manchester.g:122:3: DIGITS 
            {
            $DIGITS6=$this->match($this->input,$this->getToken('DIGITS'),self::$FOLLOW_DIGITS_in_nonNegativeInteger697); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:125:1: dataPrimary returns [$value] : (n= NOT_LABEL )? dataAtomic ; 
    public function dataPrimary(){
        $value = null;
        $dataPrimary_StartIndex = $this->input->index();
        $n=null;
        $dataAtomic7 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 12) ) { return $value; }
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
                    $n=$this->match($this->input,$this->getToken('NOT_LABEL'),self::$FOLLOW_NOT_LABEL_in_dataPrimary721); if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_dataAtomic_in_dataPrimary725);
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
    // src/Erfurt_Syntax_Manchester.g:131:1: dataPropertyExpression returns [$value] : d= dataPropertyIRI ; 
    public function dataPropertyExpression(){
        $value = null;
        $dataPropertyExpression_StartIndex = $this->input->index();
        $d = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 13) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:132:3: (d= dataPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:133:3: d= dataPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_dataPropertyIRI_in_dataPropertyExpression748);
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
    // src/Erfurt_Syntax_Manchester.g:136:1: dataAtomic returns [$value] : ( ( dataType ) | ( OPEN_CURLY_BRACE literalList CLOSE_CURLY_BRACE ) | ( dataTypeRestriction ) | ( OPEN_BRACE dataRange CLOSE_BRACE ) ); 
    public function dataAtomic(){
        $value = null;
        $dataAtomic_StartIndex = $this->input->index();
        $dataType8 = null;

        $literalList9 = null;

        $dataTypeRestriction10 = null;

        $dataRange11 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 14) ) { return $value; }
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
                    $this->pushFollow(self::$FOLLOW_dataType_in_dataAtomic770);
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
                    $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic780); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_literalList_in_dataAtomic782);
                    $literalList9=$this->literalList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic784); if ($this->state->failed) return $value;
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
                    $this->pushFollow(self::$FOLLOW_dataTypeRestriction_in_dataAtomic794);
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
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_dataAtomic804); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_dataRange_in_dataAtomic806);
                    $dataRange11=$this->dataRange();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_dataAtomic808); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:144:1: literalList returns [$value] : l1= literal ( COMMA l2= literal )* ; 
    public function literalList(){
        $value = null;
        $literalList_StartIndex = $this->input->index();
        $l1 = null;

        $l2 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 15) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:145:3: (l1= literal ( COMMA l2= literal )* ) 
            // src/Erfurt_Syntax_Manchester.g:146:3: l1= literal ( COMMA l2= literal )* 
            {
            $this->pushFollow(self::$FOLLOW_literal_in_literalList832);
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
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_literalList839); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_literal_in_literalList843);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 15, $literalList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 15, $literalList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "literalList"


    // $ANTLR start "dataType"
    // src/Erfurt_Syntax_Manchester.g:150:1: dataType returns [$value] : ( datatypeIRI | v= INTEGER_LABEL | v= DECIMAL_LABEL | v= FLOAT_LABEL | v= STRING_LABEL ); 
    public function dataType(){
        $value = null;
        $dataType_StartIndex = $this->input->index();
        $v=null;
        $datatypeIRI12 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 16) ) { return $value; }
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
                    $this->pushFollow(self::$FOLLOW_datatypeIRI_in_dataType866);
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
                    $v=$this->match($this->input,$this->getToken('INTEGER_LABEL'),self::$FOLLOW_INTEGER_LABEL_in_dataType876); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:154:5: v= DECIMAL_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('DECIMAL_LABEL'),self::$FOLLOW_DECIMAL_LABEL_in_dataType887); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:155:5: v= FLOAT_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('FLOAT_LABEL'),self::$FOLLOW_FLOAT_LABEL_in_dataType897); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($v!=null?$v->getText():null);
                    }

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:156:5: v= STRING_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('STRING_LABEL'),self::$FOLLOW_STRING_LABEL_in_dataType907); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:159:1: literal returns [$value] : (v= typedLiteral | v= stringLiteralNoLanguage | v= stringLiteralWithLanguage | v= integerLiteral | v= decimalLiteral | v= floatingPointLiteral ); 
    public function literal(){
        $value = null;
        $literal_StartIndex = $this->input->index();
        $v = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 17) ) { return $value; }
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
                else if($this->getToken('REFERENCE')== $LA21)
                    {
                    $alt21=1;
                    }
                else if($this->getToken('EOF')== $LA21||$this->getToken('LENGTH_LABEL')== $LA21||$this->getToken('MIN_LENGTH_LABEL')== $LA21||$this->getToken('MAX_LENGTH_LABEL')== $LA21||$this->getToken('PATTERN_LABEL')== $LA21||$this->getToken('LANG_PATTERN_LABEL')== $LA21||$this->getToken('INVERSE_LABEL')== $LA21||$this->getToken('NOT_LABEL')== $LA21||$this->getToken('LESS_EQUAL')== $LA21||$this->getToken('GREATER_EQUAL')== $LA21||$this->getToken('LESS')== $LA21||$this->getToken('GREATER')== $LA21||$this->getToken('OPEN_CURLY_BRACE')== $LA21||$this->getToken('CLOSE_CURLY_BRACE')== $LA21||$this->getToken('OR_LABEL')== $LA21||$this->getToken('AND_LABEL')== $LA21||$this->getToken('COMMA')== $LA21||$this->getToken('OPEN_BRACE')== $LA21||$this->getToken('CLOSE_BRACE')== $LA21||$this->getToken('DECIMAL_LABEL')== $LA21||$this->getToken('FLOAT_LABEL')== $LA21||$this->getToken('INTEGER_LABEL')== $LA21||$this->getToken('STRING_LABEL')== $LA21||$this->getToken('EQUIVALENT_TO_LABEL')== $LA21||$this->getToken('ANNOTATIONS_LABEL')== $LA21||$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC')== $LA21||$this->getToken('FULL_IRI')== $LA21||$this->getToken('SIMPLE_IRI')== $LA21||$this->getToken('NODE_ID')== $LA21||$this->getToken('CLOSE_SQUARE_BRACE')== $LA21||$this->getToken('ABBREVIATED_IRI')== $LA21)
                    {
                    $alt21=2;
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
                    $this->pushFollow(self::$FOLLOW_typedLiteral_in_literal934);
                    $v=$this->typedLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:162:20: v= stringLiteralNoLanguage 
                    {
                    $this->pushFollow(self::$FOLLOW_stringLiteralNoLanguage_in_literal940);
                    $v=$this->stringLiteralNoLanguage();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:162:48: v= stringLiteralWithLanguage 
                    {
                    $this->pushFollow(self::$FOLLOW_stringLiteralWithLanguage_in_literal946);
                    $v=$this->stringLiteralWithLanguage();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:162:78: v= integerLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_integerLiteral_in_literal952);
                    $v=$this->integerLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:162:97: v= decimalLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_decimalLiteral_in_literal958);
                    $v=$this->decimalLiteral();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;
                case 6 :
                    // src/Erfurt_Syntax_Manchester.g:162:116: v= floatingPointLiteral 
                    {
                    $this->pushFollow(self::$FOLLOW_floatingPointLiteral_in_literal964);
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
    // src/Erfurt_Syntax_Manchester.g:165:1: stringLiteralNoLanguage returns [$value] : QUOTED_STRING ; 
    public function stringLiteralNoLanguage(){
        $value = null;
        $stringLiteralNoLanguage_StartIndex = $this->input->index();
        $QUOTED_STRING13=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 18) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:166:3: ( QUOTED_STRING ) 
            // src/Erfurt_Syntax_Manchester.g:167:3: QUOTED_STRING 
            {
            $QUOTED_STRING13=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage983); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:172:1: stringLiteralWithLanguage returns [$value] : QUOTED_STRING LANGUAGE_TAG ; 
    public function stringLiteralWithLanguage(){
        $value = null;
        $stringLiteralWithLanguage_StartIndex = $this->input->index();
        $QUOTED_STRING14=null;
        $LANGUAGE_TAG15=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 19) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:173:3: ( QUOTED_STRING LANGUAGE_TAG ) 
            // src/Erfurt_Syntax_Manchester.g:174:3: QUOTED_STRING LANGUAGE_TAG 
            {
            $QUOTED_STRING14=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage1004); if ($this->state->failed) return $value;
            $LANGUAGE_TAG15=$this->match($this->input,$this->getToken('LANGUAGE_TAG'),self::$FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage1006); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:177:1: lexicalValue returns [$value] : QUOTED_STRING ; 
    public function lexicalValue(){
        $value = null;
        $lexicalValue_StartIndex = $this->input->index();
        $QUOTED_STRING16=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 20) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:178:3: ( QUOTED_STRING ) 
            // src/Erfurt_Syntax_Manchester.g:179:3: QUOTED_STRING 
            {
            $QUOTED_STRING16=$this->match($this->input,$this->getToken('QUOTED_STRING'),self::$FOLLOW_QUOTED_STRING_in_lexicalValue1027); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:182:1: typedLiteral returns [$value] : lexicalValue REFERENCE dataType ; 
    public function typedLiteral(){
        $value = null;
        $typedLiteral_StartIndex = $this->input->index();
        $lexicalValue17 = null;

        $dataType18 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 21) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:183:3: ( lexicalValue REFERENCE dataType ) 
            // src/Erfurt_Syntax_Manchester.g:184:3: lexicalValue REFERENCE dataType 
            {
            $this->pushFollow(self::$FOLLOW_lexicalValue_in_typedLiteral1048);
            $lexicalValue17=$this->lexicalValue();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            $this->match($this->input,$this->getToken('REFERENCE'),self::$FOLLOW_REFERENCE_in_typedLiteral1050); if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_dataType_in_typedLiteral1052);
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
    // src/Erfurt_Syntax_Manchester.g:187:1: restrictionValue returns [$value] : literal ; 
    public function restrictionValue(){
        $value = null;
        $restrictionValue_StartIndex = $this->input->index();
        $literal19 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 22) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:188:3: ( literal ) 
            // src/Erfurt_Syntax_Manchester.g:189:3: literal 
            {
            $this->pushFollow(self::$FOLLOW_literal_in_restrictionValue1073);
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
    // src/Erfurt_Syntax_Manchester.g:192:1: inverseObjectProperty returns [$value] : INVERSE_LABEL objectPropertyIRI ; 
    public function inverseObjectProperty(){
        $value = null;
        $inverseObjectProperty_StartIndex = $this->input->index();
        $objectPropertyIRI20 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 23) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:193:3: ( INVERSE_LABEL objectPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:194:3: INVERSE_LABEL objectPropertyIRI 
            {
            $this->match($this->input,$this->getToken('INVERSE_LABEL'),self::$FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1094); if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_inverseObjectProperty1096);
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
    // src/Erfurt_Syntax_Manchester.g:198:1: decimalLiteral returns [$value] : DLITERAL_HELPER ; 
    public function decimalLiteral(){
        $value = null;
        $decimalLiteral_StartIndex = $this->input->index();
        $DLITERAL_HELPER21=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 24) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:199:3: ( DLITERAL_HELPER ) 
            // src/Erfurt_Syntax_Manchester.g:200:3: DLITERAL_HELPER 
            {
            $DLITERAL_HELPER21=$this->match($this->input,$this->getToken('DLITERAL_HELPER'),self::$FOLLOW_DLITERAL_HELPER_in_decimalLiteral1117); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:203:1: integerLiteral returns [$value] : (i= ILITERAL_HELPER | i= DIGITS ) ; 
    public function integerLiteral(){
        $value = null;
        $integerLiteral_StartIndex = $this->input->index();
        $i=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 25) ) { return $value; }
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
                    $i=$this->match($this->input,$this->getToken('ILITERAL_HELPER'),self::$FOLLOW_ILITERAL_HELPER_in_integerLiteral1139); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:204:26: i= DIGITS 
                    {
                    $i=$this->match($this->input,$this->getToken('DIGITS'),self::$FOLLOW_DIGITS_in_integerLiteral1145); if ($this->state->failed) return $value;

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
    // src/Erfurt_Syntax_Manchester.g:207:1: floatingPointLiteral returns [$value] : FPLITERAL_HELPER ; 
    public function floatingPointLiteral(){
        $value = null;
        $floatingPointLiteral_StartIndex = $this->input->index();
        $FPLITERAL_HELPER22=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 26) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:208:3: ( FPLITERAL_HELPER ) 
            // src/Erfurt_Syntax_Manchester.g:209:3: FPLITERAL_HELPER 
            {
            $FPLITERAL_HELPER22=$this->match($this->input,$this->getToken('FPLITERAL_HELPER'),self::$FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1167); if ($this->state->failed) return $value;
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
    // src/Erfurt_Syntax_Manchester.g:212:1: objectProperty returns [$value] : objectPropertyIRI ; 
    public function objectProperty(){
        $value = null;
        $objectProperty_StartIndex = $this->input->index();
        $objectPropertyIRI23 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 27) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:213:3: ( objectPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:214:3: objectPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_objectProperty1188);
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
    // src/Erfurt_Syntax_Manchester.g:217:1: dataProperty returns [$value] : dataPropertyIRI ; 
    public function dataProperty(){
        $value = null;
        $dataProperty_StartIndex = $this->input->index();
        $dataPropertyIRI24 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 28) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:218:3: ( dataPropertyIRI ) 
            // src/Erfurt_Syntax_Manchester.g:219:3: dataPropertyIRI 
            {
            $this->pushFollow(self::$FOLLOW_dataPropertyIRI_in_dataProperty1209);
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
    // src/Erfurt_Syntax_Manchester.g:222:1: dataPropertyIRI returns [$value] : iri ; 
    public function dataPropertyIRI(){
        $value = null;
        $dataPropertyIRI_StartIndex = $this->input->index();
        $iri25 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 29) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:223:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:224:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_dataPropertyIRI1230);
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
    // src/Erfurt_Syntax_Manchester.g:227:1: datatypeIRI returns [$value] : iri ; 
    public function datatypeIRI(){
        $value = null;
        $datatypeIRI_StartIndex = $this->input->index();
        $iri26 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 30) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:228:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:229:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_datatypeIRI1251);
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
    // src/Erfurt_Syntax_Manchester.g:232:1: objectPropertyIRI returns [$value] : iri ; 
    public function objectPropertyIRI(){
        $value = null;
        $objectPropertyIRI_StartIndex = $this->input->index();
        $iri27 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 31) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:233:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:234:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_objectPropertyIRI1272);
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
    // src/Erfurt_Syntax_Manchester.g:237:1: dataTypeRestriction returns [$value] : dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE ; 
    public function dataTypeRestriction(){
        $value = null;
        $dataTypeRestriction_StartIndex = $this->input->index();
        $f = null;

        $r = null;

        $dataType28 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 32) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:238:3: ( dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE ) 
            // src/Erfurt_Syntax_Manchester.g:239:3: dataType OPEN_SQUARE_BRACE (f= facet r= restrictionValue ( COMMA )? )+ CLOSE_SQUARE_BRACE 
            {
            $this->pushFollow(self::$FOLLOW_dataType_in_dataTypeRestriction1293);
            $dataType28=$this->dataType();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_DataRange_DatatypeRestriction($dataType28);
            }
            $this->match($this->input,$this->getToken('OPEN_SQUARE_BRACE'),self::$FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1297); if ($this->state->failed) return $value;
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
            	    $this->pushFollow(self::$FOLLOW_facet_in_dataTypeRestriction1311);
            	    $f=$this->facet();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_restrictionValue_in_dataTypeRestriction1315);
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
            	            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataTypeRestriction1319); if ($this->state->failed) return $value;

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

            $this->match($this->input,$this->getToken('CLOSE_SQUARE_BRACE'),self::$FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1326); if ($this->state->failed) return $value;

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
    // src/Erfurt_Syntax_Manchester.g:244:1: individualIRI returns [$value] : iri ; 
    public function individualIRI(){
        $value = null;
        $individualIRI_StartIndex = $this->input->index();
        $iri29 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 33) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:245:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:246:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_individualIRI1345);
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
    // src/Erfurt_Syntax_Manchester.g:249:1: datatypePropertyIRI returns [$value] : iri ; 
    public function datatypePropertyIRI(){
        $value = null;
        $datatypePropertyIRI_StartIndex = $this->input->index();
        $iri30 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 34) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:250:3: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:251:3: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_datatypePropertyIRI1366);
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
    // src/Erfurt_Syntax_Manchester.g:254:1: facet returns [$value] : (v= LENGTH_LABEL | v= MIN_LENGTH_LABEL | v= MAX_LENGTH_LABEL | v= PATTERN_LABEL | v= LANG_PATTERN_LABEL | v= LESS_EQUAL | v= LESS | v= GREATER_EQUAL | v= GREATER ); 
    public function facet(){
        $value = null;
        $facet_StartIndex = $this->input->index();
        $v=null;

        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 35) ) { return $value; }
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
                    $v=$this->match($this->input,$this->getToken('LENGTH_LABEL'),self::$FOLLOW_LENGTH_LABEL_in_facet1393); if ($this->state->failed) return $value;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:257:20: v= MIN_LENGTH_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('MIN_LENGTH_LABEL'),self::$FOLLOW_MIN_LENGTH_LABEL_in_facet1399); if ($this->state->failed) return $value;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:257:41: v= MAX_LENGTH_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('MAX_LENGTH_LABEL'),self::$FOLLOW_MAX_LENGTH_LABEL_in_facet1405); if ($this->state->failed) return $value;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:257:62: v= PATTERN_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('PATTERN_LABEL'),self::$FOLLOW_PATTERN_LABEL_in_facet1411); if ($this->state->failed) return $value;

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:257:80: v= LANG_PATTERN_LABEL 
                    {
                    $v=$this->match($this->input,$this->getToken('LANG_PATTERN_LABEL'),self::$FOLLOW_LANG_PATTERN_LABEL_in_facet1417); if ($this->state->failed) return $value;

                    }
                    break;
                case 6 :
                    // src/Erfurt_Syntax_Manchester.g:257:103: v= LESS_EQUAL 
                    {
                    $v=$this->match($this->input,$this->getToken('LESS_EQUAL'),self::$FOLLOW_LESS_EQUAL_in_facet1423); if ($this->state->failed) return $value;

                    }
                    break;
                case 7 :
                    // src/Erfurt_Syntax_Manchester.g:257:118: v= LESS 
                    {
                    $v=$this->match($this->input,$this->getToken('LESS'),self::$FOLLOW_LESS_in_facet1429); if ($this->state->failed) return $value;

                    }
                    break;
                case 8 :
                    // src/Erfurt_Syntax_Manchester.g:257:127: v= GREATER_EQUAL 
                    {
                    $v=$this->match($this->input,$this->getToken('GREATER_EQUAL'),self::$FOLLOW_GREATER_EQUAL_in_facet1435); if ($this->state->failed) return $value;

                    }
                    break;
                case 9 :
                    // src/Erfurt_Syntax_Manchester.g:257:145: v= GREATER 
                    {
                    $v=$this->match($this->input,$this->getToken('GREATER'),self::$FOLLOW_GREATER_in_facet1441); if ($this->state->failed) return $value;

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
    // src/Erfurt_Syntax_Manchester.g:260:1: dataRange returns [$value] : d1= dataConjunction ( OR_LABEL d2= dataConjunction )* ; 
    public function dataRange(){
        $value = null;
        $dataRange_StartIndex = $this->input->index();
        $d1 = null;

        $d2 = null;


        $retval = array();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 36) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:266:3: (d1= dataConjunction ( OR_LABEL d2= dataConjunction )* ) 
            // src/Erfurt_Syntax_Manchester.g:267:3: d1= dataConjunction ( OR_LABEL d2= dataConjunction )* 
            {
            $this->pushFollow(self::$FOLLOW_dataConjunction_in_dataRange1470);
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
            	    $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_dataRange1484); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_dataConjunction_in_dataRange1488);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 36, $dataRange_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 36, $dataRange_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataRange"


    // $ANTLR start "dataConjunction"
    // src/Erfurt_Syntax_Manchester.g:271:1: dataConjunction returns [$value] : d1= dataPrimary ( AND_LABEL d2= dataPrimary )* ; 
    public function dataConjunction(){
        $value = null;
        $dataConjunction_StartIndex = $this->input->index();
        $d1 = null;

        $d2 = null;


        $retval = array();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 37) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:277:3: (d1= dataPrimary ( AND_LABEL d2= dataPrimary )* ) 
            // src/Erfurt_Syntax_Manchester.g:278:3: d1= dataPrimary ( AND_LABEL d2= dataPrimary )* 
            {
            $this->pushFollow(self::$FOLLOW_dataPrimary_in_dataConjunction1521);
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
            	    $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_dataConjunction1538); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_dataPrimary_in_dataConjunction1542);
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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 37, $dataConjunction_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 37, $dataConjunction_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "dataConjunction"


    // $ANTLR start "annotationAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:285:1: annotationAnnotatedList returns [$value] : ( annotations )? annotation ( COMMA ( annotations )? annotation )* ; 
    public function annotationAnnotatedList(){
        $value = null;
        $annotationAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 38) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:286:2: ( ( annotations )? annotation ( COMMA ( annotations )? annotation )* ) 
            // src/Erfurt_Syntax_Manchester.g:286:4: ( annotations )? annotation ( COMMA ( annotations )? annotation )* 
            {
            // src/Erfurt_Syntax_Manchester.g:286:4: ( annotations )? 
            $alt28=2;
            $LA28 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA28)
                {
                $alt28=1;
                }
            else if($this->getToken('FULL_IRI')== $LA28)
                {
                $LA28_2 = $this->input->LA(2);

                if ( ($this->synpred56_Erfurt_Syntax_Manchester()) ) {
                    $alt28=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA28)
                {
                $LA28_3 = $this->input->LA(2);

                if ( ($this->synpred56_Erfurt_Syntax_Manchester()) ) {
                    $alt28=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA28)
                {
                $LA28_4 = $this->input->LA(2);

                if ( ($this->synpred56_Erfurt_Syntax_Manchester()) ) {
                    $alt28=1;
                }
                }

            switch ($alt28) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_annotationAnnotatedList1565);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_annotation_in_annotationAnnotatedList1568);
            $this->annotation();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:286:28: ( COMMA ( annotations )? annotation )* 
            //loop30:
            do {
                $alt30=2;
                $LA30_0 = $this->input->LA(1);

                if ( ($LA30_0==$this->getToken('COMMA')) ) {
                    $alt30=1;
                }


                switch ($alt30) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:286:29: COMMA ( annotations )? annotation 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_annotationAnnotatedList1571); if ($this->state->failed) return $value;
            	    // src/Erfurt_Syntax_Manchester.g:286:35: ( annotations )? 
            	    $alt29=2;
            	    $LA29 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA29)
            	        {
            	        $alt29=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA29)
            	        {
            	        $LA29_2 = $this->input->LA(2);

            	        if ( ($this->synpred57_Erfurt_Syntax_Manchester()) ) {
            	            $alt29=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA29)
            	        {
            	        $LA29_3 = $this->input->LA(2);

            	        if ( ($this->synpred57_Erfurt_Syntax_Manchester()) ) {
            	            $alt29=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA29)
            	        {
            	        $LA29_4 = $this->input->LA(2);

            	        if ( ($this->synpred57_Erfurt_Syntax_Manchester()) ) {
            	            $alt29=1;
            	        }
            	        }

            	    switch ($alt29) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_annotationAnnotatedList1573);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return $value;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_annotation_in_annotationAnnotatedList1576);
            	    $this->annotation();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 38, $annotationAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 38, $annotationAnnotatedList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "annotationAnnotatedList"


    // $ANTLR start "annotation"
    // src/Erfurt_Syntax_Manchester.g:289:1: annotation returns [$value] : ap= annotationPropertyIRI at= annotationTarget ; 
    public function annotation(){
        $value = null;
        $annotation_StartIndex = $this->input->index();
        $ap = null;

        $at = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 39) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:290:2: (ap= annotationPropertyIRI at= annotationTarget ) 
            // src/Erfurt_Syntax_Manchester.g:290:4: ap= annotationPropertyIRI at= annotationTarget 
            {
            $this->pushFollow(self::$FOLLOW_annotationPropertyIRI_in_annotation1595);
            $ap=$this->annotationPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            $this->pushFollow(self::$FOLLOW_annotationTarget_in_annotation1599);
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
    // src/Erfurt_Syntax_Manchester.g:293:1: annotationTarget returns [$value] : ( NODE_ID | iri | literal ); 
    public function annotationTarget(){
        $value = null;
        $annotationTarget_StartIndex = $this->input->index();
        $NODE_ID31=null;
        $iri32 = null;

        $literal33 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 40) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:294:2: ( NODE_ID | iri | literal ) 
            $alt31=3;
            $LA31 = $this->input->LA(1);
            if($this->getToken('NODE_ID')== $LA31)
                {
                $alt31=1;
                }
            else if($this->getToken('FULL_IRI')== $LA31||$this->getToken('SIMPLE_IRI')== $LA31||$this->getToken('ABBREVIATED_IRI')== $LA31)
                {
                $alt31=2;
                }
            else if($this->getToken('DIGITS')== $LA31||$this->getToken('QUOTED_STRING')== $LA31||$this->getToken('ILITERAL_HELPER')== $LA31||$this->getToken('DLITERAL_HELPER')== $LA31||$this->getToken('FPLITERAL_HELPER')== $LA31)
                {
                $alt31=3;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return $value;}
                $nvae =
                    new NoViableAltException("", 31, 0, $this->input);

                throw $nvae;
            }

            switch ($alt31) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:294:4: NODE_ID 
                    {
                    $NODE_ID31=$this->match($this->input,$this->getToken('NODE_ID'),self::$FOLLOW_NODE_ID_in_annotationTarget1616); if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = ($NODE_ID31!=null?$NODE_ID31->getText():null);
                    }

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:295:4: iri 
                    {
                    $this->pushFollow(self::$FOLLOW_iri_in_annotationTarget1623);
                    $iri32=$this->iri();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;
                    if ( $this->state->backtracking==0 ) {
                      $value = $iri32;
                    }

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:296:4: literal 
                    {
                    $this->pushFollow(self::$FOLLOW_literal_in_annotationTarget1630);
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
    // src/Erfurt_Syntax_Manchester.g:298:1: annotations returns [$value] : ( ANNOTATIONS_LABEL a= annotationAnnotatedList )? ; 
    public function annotations(){
        $value = null;
        $annotations_StartIndex = $this->input->index();
        $a = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 41) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:299:2: ( ( ANNOTATIONS_LABEL a= annotationAnnotatedList )? ) 
            // src/Erfurt_Syntax_Manchester.g:299:4: ( ANNOTATIONS_LABEL a= annotationAnnotatedList )? 
            {
            // src/Erfurt_Syntax_Manchester.g:299:4: ( ANNOTATIONS_LABEL a= annotationAnnotatedList )? 
            $alt32=2;
            $LA32_0 = $this->input->LA(1);

            if ( ($LA32_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                $alt32=1;
            }
            switch ($alt32) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:299:5: ANNOTATIONS_LABEL a= annotationAnnotatedList 
                    {
                    $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_annotations1647); if ($this->state->failed) return $value;
                    $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_annotations1651);
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
    // src/Erfurt_Syntax_Manchester.g:310:1: descriptionList returns [$value] : d1= description ( COMMA d2= description )* ; 
    public function descriptionList(){
        $value = null;
        $descriptionList_StartIndex = $this->input->index();
        $d1 = null;

        $d2 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 42) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:311:3: (d1= description ( COMMA d2= description )* ) 
            // src/Erfurt_Syntax_Manchester.g:311:5: d1= description ( COMMA d2= description )* 
            {
            $this->pushFollow(self::$FOLLOW_description_in_descriptionList1682);
            $d1=$this->description();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            if ( $this->state->backtracking==0 ) {
              $value = new Erfurt_Owl_Structured_OwlList($d1);
            }
            // src/Erfurt_Syntax_Manchester.g:311:78: ( COMMA d2= description )* 
            //loop33:
            do {
                $alt33=2;
                $LA33_0 = $this->input->LA(1);

                if ( ($LA33_0==$this->getToken('COMMA')) ) {
                    $alt33=1;
                }


                switch ($alt33) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:311:79: COMMA d2= description 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_descriptionList1687); if ($this->state->failed) return $value;
            	    $this->pushFollow(self::$FOLLOW_description_in_descriptionList1691);
            	    $d2=$this->description();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;
            	    if ( $this->state->backtracking==0 ) {
            	      $value->addElement($d2);
            	    }

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 42, $descriptionList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 42, $descriptionList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "descriptionList"


    // $ANTLR start "objectPropertyCharacteristicAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:340:1: objectPropertyCharacteristicAnnotatedList : ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC ( COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC )* ; 
    public function objectPropertyCharacteristicAnnotatedList(){
        $objectPropertyCharacteristicAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 43) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:341:2: ( ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC ( COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC )* ) 
            // src/Erfurt_Syntax_Manchester.g:341:4: ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC ( COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC )* 
            {
            // src/Erfurt_Syntax_Manchester.g:341:4: ( annotations )? 
            $alt34=2;
            $LA34_0 = $this->input->LA(1);

            if ( ($LA34_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                $alt34=1;
            }
            else if ( ($LA34_0==$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC')) ) {
                $LA34_2 = $this->input->LA(2);

                if ( ($this->synpred63_Erfurt_Syntax_Manchester()) ) {
                    $alt34=1;
                }
            }
            switch ($alt34) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1734);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->match($this->input,$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC'),self::$FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1737); if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:341:48: ( COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC )* 
            //loop36:
            do {
                $alt36=2;
                $LA36_0 = $this->input->LA(1);

                if ( ($LA36_0==$this->getToken('COMMA')) ) {
                    $alt36=1;
                }


                switch ($alt36) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:341:49: COMMA ( annotations )? OBJECT_PROPERTY_CHARACTERISTIC 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectPropertyCharacteristicAnnotatedList1740); if ($this->state->failed) return ;
            	    // src/Erfurt_Syntax_Manchester.g:341:55: ( annotations )? 
            	    $alt35=2;
            	    $LA35_0 = $this->input->LA(1);

            	    if ( ($LA35_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
            	        $alt35=1;
            	    }
            	    else if ( ($LA35_0==$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC')) ) {
            	        $LA35_2 = $this->input->LA(2);

            	        if ( ($this->synpred64_Erfurt_Syntax_Manchester()) ) {
            	            $alt35=1;
            	        }
            	    }
            	    switch ($alt35) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1742);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return ;

            	            }
            	            break;

            	    }

            	    $this->match($this->input,$this->getToken('OBJECT_PROPERTY_CHARACTERISTIC'),self::$FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1745); if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 43, $objectPropertyCharacteristicAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 43, $objectPropertyCharacteristicAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "objectPropertyCharacteristicAnnotatedList"


    // $ANTLR start "objectPropertyExpressionAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:344:1: objectPropertyExpressionAnnotatedList : ( annotations )? objectPropertyExpression ( COMMA ( annotations )? objectPropertyExpression )* ; 
    public function objectPropertyExpressionAnnotatedList(){
        $objectPropertyExpressionAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 44) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:345:3: ( ( annotations )? objectPropertyExpression ( COMMA ( annotations )? objectPropertyExpression )* ) 
            // src/Erfurt_Syntax_Manchester.g:345:5: ( annotations )? objectPropertyExpression ( COMMA ( annotations )? objectPropertyExpression )* 
            {
            // src/Erfurt_Syntax_Manchester.g:345:5: ( annotations )? 
            $alt37=2;
            $LA37 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA37)
                {
                $alt37=1;
                }
            else if($this->getToken('FULL_IRI')== $LA37)
                {
                $LA37_2 = $this->input->LA(2);

                if ( ($this->synpred66_Erfurt_Syntax_Manchester()) ) {
                    $alt37=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA37)
                {
                $LA37_3 = $this->input->LA(2);

                if ( ($this->synpred66_Erfurt_Syntax_Manchester()) ) {
                    $alt37=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA37)
                {
                $LA37_4 = $this->input->LA(2);

                if ( ($this->synpred66_Erfurt_Syntax_Manchester()) ) {
                    $alt37=1;
                }
                }
            else if($this->getToken('INVERSE_LABEL')== $LA37)
                {
                $LA37_5 = $this->input->LA(2);

                if ( ($this->synpred66_Erfurt_Syntax_Manchester()) ) {
                    $alt37=1;
                }
                }

            switch ($alt37) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1760);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1763);
            $this->objectPropertyExpression();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:345:43: ( COMMA ( annotations )? objectPropertyExpression )* 
            //loop39:
            do {
                $alt39=2;
                $LA39_0 = $this->input->LA(1);

                if ( ($LA39_0==$this->getToken('COMMA')) ) {
                    $alt39=1;
                }


                switch ($alt39) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:345:44: COMMA ( annotations )? objectPropertyExpression 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectPropertyExpressionAnnotatedList1766); if ($this->state->failed) return ;
            	    // src/Erfurt_Syntax_Manchester.g:345:50: ( annotations )? 
            	    $alt38=2;
            	    $LA38 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA38)
            	        {
            	        $alt38=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA38)
            	        {
            	        $LA38_2 = $this->input->LA(2);

            	        if ( ($this->synpred67_Erfurt_Syntax_Manchester()) ) {
            	            $alt38=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA38)
            	        {
            	        $LA38_3 = $this->input->LA(2);

            	        if ( ($this->synpred67_Erfurt_Syntax_Manchester()) ) {
            	            $alt38=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA38)
            	        {
            	        $LA38_4 = $this->input->LA(2);

            	        if ( ($this->synpred67_Erfurt_Syntax_Manchester()) ) {
            	            $alt38=1;
            	        }
            	        }
            	    else if($this->getToken('INVERSE_LABEL')== $LA38)
            	        {
            	        $LA38_5 = $this->input->LA(2);

            	        if ( ($this->synpred67_Erfurt_Syntax_Manchester()) ) {
            	            $alt38=1;
            	        }
            	        }

            	    switch ($alt38) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1768);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return ;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1771);
            	    $this->objectPropertyExpression();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 44, $objectPropertyExpressionAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 44, $objectPropertyExpressionAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "objectPropertyExpressionAnnotatedList"


    // $ANTLR start "dataPropertyExpressionAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:364:1: dataPropertyExpressionAnnotatedList : ( annotations )? dataPropertyExpression ( COMMA ( annotations )? dataPropertyExpression )* ; 
    public function dataPropertyExpressionAnnotatedList(){
        $dataPropertyExpressionAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 45) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:365:4: ( ( annotations )? dataPropertyExpression ( COMMA ( annotations )? dataPropertyExpression )* ) 
            // src/Erfurt_Syntax_Manchester.g:365:6: ( annotations )? dataPropertyExpression ( COMMA ( annotations )? dataPropertyExpression )* 
            {
            // src/Erfurt_Syntax_Manchester.g:365:6: ( annotations )? 
            $alt40=2;
            $LA40 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA40)
                {
                $alt40=1;
                }
            else if($this->getToken('FULL_IRI')== $LA40)
                {
                $LA40_2 = $this->input->LA(2);

                if ( ($this->synpred69_Erfurt_Syntax_Manchester()) ) {
                    $alt40=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA40)
                {
                $LA40_3 = $this->input->LA(2);

                if ( ($this->synpred69_Erfurt_Syntax_Manchester()) ) {
                    $alt40=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA40)
                {
                $LA40_4 = $this->input->LA(2);

                if ( ($this->synpred69_Erfurt_Syntax_Manchester()) ) {
                    $alt40=1;
                }
                }

            switch ($alt40) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1805);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1808);
            $this->dataPropertyExpression();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:365:42: ( COMMA ( annotations )? dataPropertyExpression )* 
            //loop42:
            do {
                $alt42=2;
                $LA42_0 = $this->input->LA(1);

                if ( ($LA42_0==$this->getToken('COMMA')) ) {
                    $alt42=1;
                }


                switch ($alt42) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:365:43: COMMA ( annotations )? dataPropertyExpression 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataPropertyExpressionAnnotatedList1811); if ($this->state->failed) return ;
            	    // src/Erfurt_Syntax_Manchester.g:365:49: ( annotations )? 
            	    $alt41=2;
            	    $LA41 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA41)
            	        {
            	        $alt41=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA41)
            	        {
            	        $LA41_2 = $this->input->LA(2);

            	        if ( ($this->synpred70_Erfurt_Syntax_Manchester()) ) {
            	            $alt41=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA41)
            	        {
            	        $LA41_3 = $this->input->LA(2);

            	        if ( ($this->synpred70_Erfurt_Syntax_Manchester()) ) {
            	            $alt41=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA41)
            	        {
            	        $LA41_4 = $this->input->LA(2);

            	        if ( ($this->synpred70_Erfurt_Syntax_Manchester()) ) {
            	            $alt41=1;
            	        }
            	        }

            	    switch ($alt41) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1813);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return ;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1816);
            	    $this->dataPropertyExpression();

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 45, $dataPropertyExpressionAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 45, $dataPropertyExpressionAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "dataPropertyExpressionAnnotatedList"


    // $ANTLR start "annotationPropertyFrame"
    // src/Erfurt_Syntax_Manchester.g:368:1: annotationPropertyFrame : ( ANNOTATION_PROPERTY_LABEL annotationPropertyIRI ( ANNOTATIONS_LABEL annotationAnnotatedList )* | DOMAIN_LABEL iriAnnotatedList | RANGE_LABEL iriAnnotatedList | SUB_PROPERTY_OF_LABEL annotationPropertyIRIAnnotatedList ); 
    public function annotationPropertyFrame(){
        $annotationPropertyFrame_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 46) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:369:3: ( ANNOTATION_PROPERTY_LABEL annotationPropertyIRI ( ANNOTATIONS_LABEL annotationAnnotatedList )* | DOMAIN_LABEL iriAnnotatedList | RANGE_LABEL iriAnnotatedList | SUB_PROPERTY_OF_LABEL annotationPropertyIRIAnnotatedList ) 
            $alt44=4;
            $LA44 = $this->input->LA(1);
            if($this->getToken('ANNOTATION_PROPERTY_LABEL')== $LA44)
                {
                $alt44=1;
                }
            else if($this->getToken('DOMAIN_LABEL')== $LA44)
                {
                $alt44=2;
                }
            else if($this->getToken('RANGE_LABEL')== $LA44)
                {
                $alt44=3;
                }
            else if($this->getToken('SUB_PROPERTY_OF_LABEL')== $LA44)
                {
                $alt44=4;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                $nvae =
                    new NoViableAltException("", 44, 0, $this->input);

                throw $nvae;
            }

            switch ($alt44) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:369:5: ANNOTATION_PROPERTY_LABEL annotationPropertyIRI ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
                    {
                    $this->match($this->input,$this->getToken('ANNOTATION_PROPERTY_LABEL'),self::$FOLLOW_ANNOTATION_PROPERTY_LABEL_in_annotationPropertyFrame1833); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_annotationPropertyIRI_in_annotationPropertyFrame1835);
                    $this->annotationPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    // src/Erfurt_Syntax_Manchester.g:370:3: ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
                    //loop43:
                    do {
                        $alt43=2;
                        $LA43_0 = $this->input->LA(1);

                        if ( ($LA43_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                            $alt43=1;
                        }


                        switch ($alt43) {
                    	case 1 :
                    	    // src/Erfurt_Syntax_Manchester.g:370:5: ANNOTATIONS_LABEL annotationAnnotatedList 
                    	    {
                    	    $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_annotationPropertyFrame1841); if ($this->state->failed) return ;
                    	    $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_annotationPropertyFrame1844);
                    	    $this->annotationAnnotatedList();

                    	    $this->state->_fsp--;
                    	    if ($this->state->failed) return ;

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop43;
                        }
                    } while (true);


                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:371:5: DOMAIN_LABEL iriAnnotatedList 
                    {
                    $this->match($this->input,$this->getToken('DOMAIN_LABEL'),self::$FOLLOW_DOMAIN_LABEL_in_annotationPropertyFrame1853); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1856);
                    $this->iriAnnotatedList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:372:5: RANGE_LABEL iriAnnotatedList 
                    {
                    $this->match($this->input,$this->getToken('RANGE_LABEL'),self::$FOLLOW_RANGE_LABEL_in_annotationPropertyFrame1862); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1865);
                    $this->iriAnnotatedList();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:373:5: SUB_PROPERTY_OF_LABEL annotationPropertyIRIAnnotatedList 
                    {
                    $this->match($this->input,$this->getToken('SUB_PROPERTY_OF_LABEL'),self::$FOLLOW_SUB_PROPERTY_OF_LABEL_in_annotationPropertyFrame1871); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyFrame1873);
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
    // src/Erfurt_Syntax_Manchester.g:376:1: iriAnnotatedList : ( annotations )? iri ( COMMA ( annotations )? iri )* ; 
    public function iriAnnotatedList(){
        $iriAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 47) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:377:3: ( ( annotations )? iri ( COMMA ( annotations )? iri )* ) 
            // src/Erfurt_Syntax_Manchester.g:377:5: ( annotations )? iri ( COMMA ( annotations )? iri )* 
            {
            // src/Erfurt_Syntax_Manchester.g:377:5: ( annotations )? 
            $alt45=2;
            $LA45 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA45)
                {
                $alt45=1;
                }
            else if($this->getToken('FULL_IRI')== $LA45)
                {
                $LA45_2 = $this->input->LA(2);

                if ( ($this->synpred76_Erfurt_Syntax_Manchester()) ) {
                    $alt45=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA45)
                {
                $LA45_3 = $this->input->LA(2);

                if ( ($this->synpred76_Erfurt_Syntax_Manchester()) ) {
                    $alt45=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA45)
                {
                $LA45_4 = $this->input->LA(2);

                if ( ($this->synpred76_Erfurt_Syntax_Manchester()) ) {
                    $alt45=1;
                }
                }

            switch ($alt45) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_iriAnnotatedList1888);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_iri_in_iriAnnotatedList1891);
            $this->iri();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:377:22: ( COMMA ( annotations )? iri )* 
            //loop47:
            do {
                $alt47=2;
                $LA47_0 = $this->input->LA(1);

                if ( ($LA47_0==$this->getToken('COMMA')) ) {
                    $alt47=1;
                }


                switch ($alt47) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:377:23: COMMA ( annotations )? iri 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_iriAnnotatedList1894); if ($this->state->failed) return ;
            	    // src/Erfurt_Syntax_Manchester.g:377:29: ( annotations )? 
            	    $alt46=2;
            	    $LA46 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA46)
            	        {
            	        $alt46=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA46)
            	        {
            	        $LA46_2 = $this->input->LA(2);

            	        if ( ($this->synpred77_Erfurt_Syntax_Manchester()) ) {
            	            $alt46=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA46)
            	        {
            	        $LA46_3 = $this->input->LA(2);

            	        if ( ($this->synpred77_Erfurt_Syntax_Manchester()) ) {
            	            $alt46=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA46)
            	        {
            	        $LA46_4 = $this->input->LA(2);

            	        if ( ($this->synpred77_Erfurt_Syntax_Manchester()) ) {
            	            $alt46=1;
            	        }
            	        }

            	    switch ($alt46) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_iriAnnotatedList1896);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return ;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_iri_in_iriAnnotatedList1899);
            	    $this->iri();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

            	    }
            	    break;

            	default :
            	    break 2;//loop47;
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
    // src/Erfurt_Syntax_Manchester.g:380:1: annotationPropertyIRI returns [$value] : iri ; 
    public function annotationPropertyIRI(){
        $value = null;
        $annotationPropertyIRI_StartIndex = $this->input->index();
        $iri34 = null;


        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 48) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:381:2: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:381:4: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_annotationPropertyIRI1918);
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
    // src/Erfurt_Syntax_Manchester.g:384:1: annotationPropertyIRIAnnotatedList : ( annotations )? annotationPropertyIRI ( COMMA annotationPropertyIRIAnnotatedList )* ; 
    public function annotationPropertyIRIAnnotatedList(){
        $annotationPropertyIRIAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 49) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:385:3: ( ( annotations )? annotationPropertyIRI ( COMMA annotationPropertyIRIAnnotatedList )* ) 
            // src/Erfurt_Syntax_Manchester.g:385:5: ( annotations )? annotationPropertyIRI ( COMMA annotationPropertyIRIAnnotatedList )* 
            {
            // src/Erfurt_Syntax_Manchester.g:385:5: ( annotations )? 
            $alt48=2;
            $LA48 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA48)
                {
                $alt48=1;
                }
            else if($this->getToken('FULL_IRI')== $LA48)
                {
                $LA48_2 = $this->input->LA(2);

                if ( ($this->synpred79_Erfurt_Syntax_Manchester()) ) {
                    $alt48=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA48)
                {
                $LA48_3 = $this->input->LA(2);

                if ( ($this->synpred79_Erfurt_Syntax_Manchester()) ) {
                    $alt48=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA48)
                {
                $LA48_4 = $this->input->LA(2);

                if ( ($this->synpred79_Erfurt_Syntax_Manchester()) ) {
                    $alt48=1;
                }
                }

            switch ($alt48) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_annotationPropertyIRIAnnotatedList1934);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_annotationPropertyIRI_in_annotationPropertyIRIAnnotatedList1937);
            $this->annotationPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:385:40: ( COMMA annotationPropertyIRIAnnotatedList )* 
            //loop49:
            do {
                $alt49=2;
                $LA49_0 = $this->input->LA(1);

                if ( ($LA49_0==$this->getToken('COMMA')) ) {
                    $LA49_2 = $this->input->LA(2);

                    if ( ($this->synpred80_Erfurt_Syntax_Manchester()) ) {
                        $alt49=1;
                    }


                }


                switch ($alt49) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:385:41: COMMA annotationPropertyIRIAnnotatedList 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_annotationPropertyIRIAnnotatedList1940); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyIRIAnnotatedList1942);
            	    $this->annotationPropertyIRIAnnotatedList();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 49, $annotationPropertyIRIAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 49, $annotationPropertyIRIAnnotatedList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "annotationPropertyIRIAnnotatedList"


    // $ANTLR start "factAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:398:1: factAnnotatedList returns [$value] : ( annotations )? fact ( COMMA ( annotations )? fact )* ; 
    public function factAnnotatedList(){
        $value = null;
        $factAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 50) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:399:2: ( ( annotations )? fact ( COMMA ( annotations )? fact )* ) 
            // src/Erfurt_Syntax_Manchester.g:399:4: ( annotations )? fact ( COMMA ( annotations )? fact )* 
            {
            // src/Erfurt_Syntax_Manchester.g:399:4: ( annotations )? 
            $alt50=2;
            $LA50 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA50)
                {
                $alt50=1;
                }
            else if($this->getToken('NOT_LABEL')== $LA50)
                {
                $LA50_2 = $this->input->LA(2);

                if ( ($this->synpred81_Erfurt_Syntax_Manchester()) ) {
                    $alt50=1;
                }
                }
            else if($this->getToken('FULL_IRI')== $LA50)
                {
                $LA50_3 = $this->input->LA(2);

                if ( ($this->synpred81_Erfurt_Syntax_Manchester()) ) {
                    $alt50=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA50)
                {
                $LA50_4 = $this->input->LA(2);

                if ( ($this->synpred81_Erfurt_Syntax_Manchester()) ) {
                    $alt50=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA50)
                {
                $LA50_5 = $this->input->LA(2);

                if ( ($this->synpred81_Erfurt_Syntax_Manchester()) ) {
                    $alt50=1;
                }
                }

            switch ($alt50) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_factAnnotatedList1971);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_fact_in_factAnnotatedList1974);
            $this->fact();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:399:22: ( COMMA ( annotations )? fact )* 
            //loop52:
            do {
                $alt52=2;
                $LA52_0 = $this->input->LA(1);

                if ( ($LA52_0==$this->getToken('COMMA')) ) {
                    $alt52=1;
                }


                switch ($alt52) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:399:23: COMMA ( annotations )? fact 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_factAnnotatedList1977); if ($this->state->failed) return $value;
            	    // src/Erfurt_Syntax_Manchester.g:399:29: ( annotations )? 
            	    $alt51=2;
            	    $LA51 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA51)
            	        {
            	        $alt51=1;
            	        }
            	    else if($this->getToken('NOT_LABEL')== $LA51)
            	        {
            	        $LA51_2 = $this->input->LA(2);

            	        if ( ($this->synpred82_Erfurt_Syntax_Manchester()) ) {
            	            $alt51=1;
            	        }
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA51)
            	        {
            	        $LA51_3 = $this->input->LA(2);

            	        if ( ($this->synpred82_Erfurt_Syntax_Manchester()) ) {
            	            $alt51=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA51)
            	        {
            	        $LA51_4 = $this->input->LA(2);

            	        if ( ($this->synpred82_Erfurt_Syntax_Manchester()) ) {
            	            $alt51=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA51)
            	        {
            	        $LA51_5 = $this->input->LA(2);

            	        if ( ($this->synpred82_Erfurt_Syntax_Manchester()) ) {
            	            $alt51=1;
            	        }
            	        }

            	    switch ($alt51) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_factAnnotatedList1979);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return $value;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_fact_in_factAnnotatedList1982);
            	    $this->fact();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return $value;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 50, $factAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 50, $factAnnotatedList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "factAnnotatedList"


    // $ANTLR start "individualAnnotatedList"
    // src/Erfurt_Syntax_Manchester.g:402:1: individualAnnotatedList returns [$value] : ( annotations )? individual ( COMMA ( annotations )? individual )* ; 
    public function individualAnnotatedList(){
        $value = null;
        $individualAnnotatedList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 51) ) { return $value; }
            // src/Erfurt_Syntax_Manchester.g:403:3: ( ( annotations )? individual ( COMMA ( annotations )? individual )* ) 
            // src/Erfurt_Syntax_Manchester.g:403:5: ( annotations )? individual ( COMMA ( annotations )? individual )* 
            {
            // src/Erfurt_Syntax_Manchester.g:403:5: ( annotations )? 
            $alt53=2;
            $LA53 = $this->input->LA(1);
            if($this->getToken('ANNOTATIONS_LABEL')== $LA53)
                {
                $alt53=1;
                }
            else if($this->getToken('FULL_IRI')== $LA53)
                {
                $LA53_2 = $this->input->LA(2);

                if ( ($this->synpred84_Erfurt_Syntax_Manchester()) ) {
                    $alt53=1;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA53)
                {
                $LA53_3 = $this->input->LA(2);

                if ( ($this->synpred84_Erfurt_Syntax_Manchester()) ) {
                    $alt53=1;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA53)
                {
                $LA53_4 = $this->input->LA(2);

                if ( ($this->synpred84_Erfurt_Syntax_Manchester()) ) {
                    $alt53=1;
                }
                }
            else if($this->getToken('NODE_ID')== $LA53)
                {
                $LA53_5 = $this->input->LA(2);

                if ( ($this->synpred84_Erfurt_Syntax_Manchester()) ) {
                    $alt53=1;
                }
                }

            switch ($alt53) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
                    {
                    $this->pushFollow(self::$FOLLOW_annotations_in_individualAnnotatedList2001);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return $value;

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_individual_in_individualAnnotatedList2004);
            $this->individual();

            $this->state->_fsp--;
            if ($this->state->failed) return $value;
            // src/Erfurt_Syntax_Manchester.g:403:29: ( COMMA ( annotations )? individual )* 
            //loop55:
            do {
                $alt55=2;
                $LA55_0 = $this->input->LA(1);

                if ( ($LA55_0==$this->getToken('COMMA')) ) {
                    $alt55=1;
                }


                switch ($alt55) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:403:30: COMMA ( annotations )? individual 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_individualAnnotatedList2007); if ($this->state->failed) return $value;
            	    // src/Erfurt_Syntax_Manchester.g:403:36: ( annotations )? 
            	    $alt54=2;
            	    $LA54 = $this->input->LA(1);
            	    if($this->getToken('ANNOTATIONS_LABEL')== $LA54)
            	        {
            	        $alt54=1;
            	        }
            	    else if($this->getToken('FULL_IRI')== $LA54)
            	        {
            	        $LA54_2 = $this->input->LA(2);

            	        if ( ($this->synpred85_Erfurt_Syntax_Manchester()) ) {
            	            $alt54=1;
            	        }
            	        }
            	    else if($this->getToken('ABBREVIATED_IRI')== $LA54)
            	        {
            	        $LA54_3 = $this->input->LA(2);

            	        if ( ($this->synpred85_Erfurt_Syntax_Manchester()) ) {
            	            $alt54=1;
            	        }
            	        }
            	    else if($this->getToken('SIMPLE_IRI')== $LA54)
            	        {
            	        $LA54_4 = $this->input->LA(2);

            	        if ( ($this->synpred85_Erfurt_Syntax_Manchester()) ) {
            	            $alt54=1;
            	        }
            	        }
            	    else if($this->getToken('NODE_ID')== $LA54)
            	        {
            	        $LA54_5 = $this->input->LA(2);

            	        if ( ($this->synpred85_Erfurt_Syntax_Manchester()) ) {
            	            $alt54=1;
            	        }
            	        }

            	    switch ($alt54) {
            	        case 1 :
            	            // src/Erfurt_Syntax_Manchester.g:0:0: annotations 
            	            {
            	            $this->pushFollow(self::$FOLLOW_annotations_in_individualAnnotatedList2009);
            	            $this->annotations();

            	            $this->state->_fsp--;
            	            if ($this->state->failed) return $value;

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_individual_in_individualAnnotatedList2012);
            	    $this->individual();

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 51, $individualAnnotatedList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 51, $individualAnnotatedList_StartIndex); }
        
        return $value;
    }
    // $ANTLR end "individualAnnotatedList"


    // $ANTLR start "fact"
    // src/Erfurt_Syntax_Manchester.g:406:1: fact : ( NOT_LABEL )? ( objectPropertyFact | dataPropertyFact ) ; 
    public function fact(){
        $fact_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 52) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:406:6: ( ( NOT_LABEL )? ( objectPropertyFact | dataPropertyFact ) ) 
            // src/Erfurt_Syntax_Manchester.g:406:8: ( NOT_LABEL )? ( objectPropertyFact | dataPropertyFact ) 
            {
            // src/Erfurt_Syntax_Manchester.g:406:8: ( NOT_LABEL )? 
            $alt56=2;
            $LA56_0 = $this->input->LA(1);

            if ( ($LA56_0==$this->getToken('NOT_LABEL')) ) {
                $alt56=1;
            }
            switch ($alt56) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:0:0: NOT_LABEL 
                    {
                    $this->match($this->input,$this->getToken('NOT_LABEL'),self::$FOLLOW_NOT_LABEL_in_fact2026); if ($this->state->failed) return ;

                    }
                    break;

            }

            // src/Erfurt_Syntax_Manchester.g:406:19: ( objectPropertyFact | dataPropertyFact ) 
            $alt57=2;
            $LA57 = $this->input->LA(1);
            if($this->getToken('FULL_IRI')== $LA57)
                {
                $LA57_1 = $this->input->LA(2);

                if ( ($LA57_1==$this->getToken('DIGITS')||$LA57_1==$this->getToken('QUOTED_STRING')||($LA57_1>=$this->getToken('ILITERAL_HELPER') && $LA57_1<=$this->getToken('FPLITERAL_HELPER'))) ) {
                    $alt57=2;
                }
                else if ( (($LA57_1>=$this->getToken('FULL_IRI') && $LA57_1<=$this->getToken('NODE_ID'))||$LA57_1==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt57=1;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                    $nvae = new NoViableAltException("", 57, 1, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('ABBREVIATED_IRI')== $LA57)
                {
                $LA57_2 = $this->input->LA(2);

                if ( ($LA57_2==$this->getToken('DIGITS')||$LA57_2==$this->getToken('QUOTED_STRING')||($LA57_2>=$this->getToken('ILITERAL_HELPER') && $LA57_2<=$this->getToken('FPLITERAL_HELPER'))) ) {
                    $alt57=2;
                }
                else if ( (($LA57_2>=$this->getToken('FULL_IRI') && $LA57_2<=$this->getToken('NODE_ID'))||$LA57_2==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt57=1;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                    $nvae = new NoViableAltException("", 57, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('SIMPLE_IRI')== $LA57)
                {
                $LA57_3 = $this->input->LA(2);

                if ( ($LA57_3==$this->getToken('DIGITS')||$LA57_3==$this->getToken('QUOTED_STRING')||($LA57_3>=$this->getToken('ILITERAL_HELPER') && $LA57_3<=$this->getToken('FPLITERAL_HELPER'))) ) {
                    $alt57=2;
                }
                else if ( (($LA57_3>=$this->getToken('FULL_IRI') && $LA57_3<=$this->getToken('NODE_ID'))||$LA57_3==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt57=1;
                }
                else {
                    if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                    $nvae = new NoViableAltException("", 57, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                $nvae =
                    new NoViableAltException("", 57, 0, $this->input);

                throw $nvae;
            }

            switch ($alt57) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:406:20: objectPropertyFact 
                    {
                    $this->pushFollow(self::$FOLLOW_objectPropertyFact_in_fact2030);
                    $this->objectPropertyFact();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:406:41: dataPropertyFact 
                    {
                    $this->pushFollow(self::$FOLLOW_dataPropertyFact_in_fact2034);
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
    // src/Erfurt_Syntax_Manchester.g:408:1: objectPropertyFact : objectPropertyIRI individual ; 
    public function objectPropertyFact(){
        $objectPropertyFact_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 53) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:409:3: ( objectPropertyIRI individual ) 
            // src/Erfurt_Syntax_Manchester.g:409:5: objectPropertyIRI individual 
            {
            $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_objectPropertyFact2045);
            $this->objectPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_individual_in_objectPropertyFact2047);
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
    // src/Erfurt_Syntax_Manchester.g:412:1: dataPropertyFact : dataPropertyIRI literal ; 
    public function dataPropertyFact(){
        $dataPropertyFact_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 54) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:413:3: ( dataPropertyIRI literal ) 
            // src/Erfurt_Syntax_Manchester.g:413:5: dataPropertyIRI literal 
            {
            $this->pushFollow(self::$FOLLOW_dataPropertyIRI_in_dataPropertyFact2061);
            $this->dataPropertyIRI();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_literal_in_dataPropertyFact2063);
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
    // src/Erfurt_Syntax_Manchester.g:416:1: datatypeFrame : DATATYPE_LABEL dataType ( ANNOTATIONS_LABEL annotationAnnotatedList )* ( EQUIVALENT_TO_LABEL annotations dataRange )? ( ANNOTATIONS_LABEL annotationAnnotatedList )* ; 
    public function datatypeFrame(){
        $datatypeFrame_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 55) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:417:3: ( DATATYPE_LABEL dataType ( ANNOTATIONS_LABEL annotationAnnotatedList )* ( EQUIVALENT_TO_LABEL annotations dataRange )? ( ANNOTATIONS_LABEL annotationAnnotatedList )* ) 
            // src/Erfurt_Syntax_Manchester.g:417:5: DATATYPE_LABEL dataType ( ANNOTATIONS_LABEL annotationAnnotatedList )* ( EQUIVALENT_TO_LABEL annotations dataRange )? ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
            {
            $this->match($this->input,$this->getToken('DATATYPE_LABEL'),self::$FOLLOW_DATATYPE_LABEL_in_datatypeFrame2077); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_dataType_in_datatypeFrame2080);
            $this->dataType();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:418:4: ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
            //loop58:
            do {
                $alt58=2;
                $LA58_0 = $this->input->LA(1);

                if ( ($LA58_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                    $LA58_2 = $this->input->LA(2);

                    if ( ($this->synpred89_Erfurt_Syntax_Manchester()) ) {
                        $alt58=1;
                    }


                }


                switch ($alt58) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:418:5: ANNOTATIONS_LABEL annotationAnnotatedList 
            	    {
            	    $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2086); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_datatypeFrame2089);
            	    $this->annotationAnnotatedList();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

            	    }
            	    break;

            	default :
            	    break 2;//loop58;
                }
            } while (true);

            // src/Erfurt_Syntax_Manchester.g:419:4: ( EQUIVALENT_TO_LABEL annotations dataRange )? 
            $alt59=2;
            $LA59_0 = $this->input->LA(1);

            if ( ($LA59_0==$this->getToken('EQUIVALENT_TO_LABEL')) ) {
                $alt59=1;
            }
            switch ($alt59) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:419:5: EQUIVALENT_TO_LABEL annotations dataRange 
                    {
                    $this->match($this->input,$this->getToken('EQUIVALENT_TO_LABEL'),self::$FOLLOW_EQUIVALENT_TO_LABEL_in_datatypeFrame2097); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_annotations_in_datatypeFrame2100);
                    $this->annotations();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_dataRange_in_datatypeFrame2102);
                    $this->dataRange();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;

                    }
                    break;

            }

            // src/Erfurt_Syntax_Manchester.g:420:4: ( ANNOTATIONS_LABEL annotationAnnotatedList )* 
            //loop60:
            do {
                $alt60=2;
                $LA60_0 = $this->input->LA(1);

                if ( ($LA60_0==$this->getToken('ANNOTATIONS_LABEL')) ) {
                    $alt60=1;
                }


                switch ($alt60) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:420:5: ANNOTATIONS_LABEL annotationAnnotatedList 
            	    {
            	    $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2110); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_datatypeFrame2113);
            	    $this->annotationAnnotatedList();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 55, $datatypeFrame_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 55, $datatypeFrame_StartIndex); }
        
        return ;
    }
    // $ANTLR end "datatypeFrame"


    // $ANTLR start "individual2List"
    // src/Erfurt_Syntax_Manchester.g:432:1: individual2List : individual COMMA individualList ; 
    public function individual2List(){
        $individual2List_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 56) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:433:2: ( individual COMMA individualList ) 
            // src/Erfurt_Syntax_Manchester.g:433:4: individual COMMA individualList 
            {
            $this->pushFollow(self::$FOLLOW_individual_in_individual2List2138);
            $this->individual();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_individual2List2140); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_individualList_in_individual2List2142);
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
    // src/Erfurt_Syntax_Manchester.g:436:1: dataProperty2List : dataProperty COMMA dataPropertyList ; 
    public function dataProperty2List(){
        $dataProperty2List_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 57) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:437:3: ( dataProperty COMMA dataPropertyList ) 
            // src/Erfurt_Syntax_Manchester.g:437:5: dataProperty COMMA dataPropertyList 
            {
            $this->pushFollow(self::$FOLLOW_dataProperty_in_dataProperty2List2154);
            $this->dataProperty();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataProperty2List2156); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_dataPropertyList_in_dataProperty2List2158);
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
    // src/Erfurt_Syntax_Manchester.g:440:1: dataPropertyList : dataProperty ( COMMA dataProperty )* ; 
    public function dataPropertyList(){
        $dataPropertyList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 58) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:441:2: ( dataProperty ( COMMA dataProperty )* ) 
            // src/Erfurt_Syntax_Manchester.g:441:4: dataProperty ( COMMA dataProperty )* 
            {
            $this->pushFollow(self::$FOLLOW_dataProperty_in_dataPropertyList2172);
            $this->dataProperty();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:441:17: ( COMMA dataProperty )* 
            //loop61:
            do {
                $alt61=2;
                $LA61_0 = $this->input->LA(1);

                if ( ($LA61_0==$this->getToken('COMMA')) ) {
                    $alt61=1;
                }


                switch ($alt61) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:441:18: COMMA dataProperty 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_dataPropertyList2175); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_dataProperty_in_dataPropertyList2177);
            	    $this->dataProperty();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

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
            if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 58, $dataPropertyList_StartIndex); }
            throw $e;
        }
        if ( $this->state->backtracking>0 ) { $this->memoize($this->input, 58, $dataPropertyList_StartIndex); }
        
        return ;
    }
    // $ANTLR end "dataPropertyList"


    // $ANTLR start "objectProperty2List"
    // src/Erfurt_Syntax_Manchester.g:444:1: objectProperty2List : objectProperty COMMA objectPropertyList ; 
    public function objectProperty2List(){
        $objectProperty2List_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 59) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:445:3: ( objectProperty COMMA objectPropertyList ) 
            // src/Erfurt_Syntax_Manchester.g:445:5: objectProperty COMMA objectPropertyList 
            {
            $this->pushFollow(self::$FOLLOW_objectProperty_in_objectProperty2List2193);
            $this->objectProperty();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectProperty2List2195); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_objectPropertyList_in_objectProperty2List2197);
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
    // src/Erfurt_Syntax_Manchester.g:448:1: objectPropertyList : objectProperty ( COMMA objectProperty )* ; 
    public function objectPropertyList(){
        $objectPropertyList_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 60) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:449:3: ( objectProperty ( COMMA objectProperty )* ) 
            // src/Erfurt_Syntax_Manchester.g:449:5: objectProperty ( COMMA objectProperty )* 
            {
            $this->pushFollow(self::$FOLLOW_objectProperty_in_objectPropertyList2211);
            $this->objectProperty();

            $this->state->_fsp--;
            if ($this->state->failed) return ;
            // src/Erfurt_Syntax_Manchester.g:449:20: ( COMMA objectProperty )* 
            //loop62:
            do {
                $alt62=2;
                $LA62_0 = $this->input->LA(1);

                if ( ($LA62_0==$this->getToken('COMMA')) ) {
                    $alt62=1;
                }


                switch ($alt62) {
            	case 1 :
            	    // src/Erfurt_Syntax_Manchester.g:449:21: COMMA objectProperty 
            	    {
            	    $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_objectPropertyList2214); if ($this->state->failed) return ;
            	    $this->pushFollow(self::$FOLLOW_objectProperty_in_objectPropertyList2216);
            	    $this->objectProperty();

            	    $this->state->_fsp--;
            	    if ($this->state->failed) return ;

            	    }
            	    break;

            	default :
            	    break 2;//loop62;
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
    // src/Erfurt_Syntax_Manchester.g:462:1: entity : ( DATATYPE_LABEL OPEN_BRACE dataType CLOSE_BRACE | CLASS_LABEL OPEN_BRACE classIRI CLOSE_BRACE | OBJECT_PROPERTY_LABEL OPEN_BRACE objectPropertyIRI CLOSE_BRACE | DATA_PROPERTY_LABEL OPEN_BRACE datatypePropertyIRI CLOSE_BRACE | ANNOTATION_PROPERTY_LABEL OPEN_BRACE annotationPropertyIRI CLOSE_BRACE | NAMED_INDIVIDUAL_LABEL OPEN_BRACE individualIRI CLOSE_BRACE ); 
    public function entity(){
        $entity_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 61) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:463:3: ( DATATYPE_LABEL OPEN_BRACE dataType CLOSE_BRACE | CLASS_LABEL OPEN_BRACE classIRI CLOSE_BRACE | OBJECT_PROPERTY_LABEL OPEN_BRACE objectPropertyIRI CLOSE_BRACE | DATA_PROPERTY_LABEL OPEN_BRACE datatypePropertyIRI CLOSE_BRACE | ANNOTATION_PROPERTY_LABEL OPEN_BRACE annotationPropertyIRI CLOSE_BRACE | NAMED_INDIVIDUAL_LABEL OPEN_BRACE individualIRI CLOSE_BRACE ) 
            $alt63=6;
            $LA63 = $this->input->LA(1);
            if($this->getToken('DATATYPE_LABEL')== $LA63)
                {
                $alt63=1;
                }
            else if($this->getToken('CLASS_LABEL')== $LA63)
                {
                $alt63=2;
                }
            else if($this->getToken('OBJECT_PROPERTY_LABEL')== $LA63)
                {
                $alt63=3;
                }
            else if($this->getToken('DATA_PROPERTY_LABEL')== $LA63)
                {
                $alt63=4;
                }
            else if($this->getToken('ANNOTATION_PROPERTY_LABEL')== $LA63)
                {
                $alt63=5;
                }
            else if($this->getToken('NAMED_INDIVIDUAL_LABEL')== $LA63)
                {
                $alt63=6;
                }
            else{
                if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
                $nvae =
                    new NoViableAltException("", 63, 0, $this->input);

                throw $nvae;
            }

            switch ($alt63) {
                case 1 :
                    // src/Erfurt_Syntax_Manchester.g:463:5: DATATYPE_LABEL OPEN_BRACE dataType CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('DATATYPE_LABEL'),self::$FOLLOW_DATATYPE_LABEL_in_entity2242); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2244); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_dataType_in_entity2246);
                    $this->dataType();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2248); if ($this->state->failed) return ;

                    }
                    break;
                case 2 :
                    // src/Erfurt_Syntax_Manchester.g:464:5: CLASS_LABEL OPEN_BRACE classIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('CLASS_LABEL'),self::$FOLLOW_CLASS_LABEL_in_entity2254); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2256); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_classIRI_in_entity2258);
                    $this->classIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2260); if ($this->state->failed) return ;

                    }
                    break;
                case 3 :
                    // src/Erfurt_Syntax_Manchester.g:465:5: OBJECT_PROPERTY_LABEL OPEN_BRACE objectPropertyIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OBJECT_PROPERTY_LABEL'),self::$FOLLOW_OBJECT_PROPERTY_LABEL_in_entity2266); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2268); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_objectPropertyIRI_in_entity2270);
                    $this->objectPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2272); if ($this->state->failed) return ;

                    }
                    break;
                case 4 :
                    // src/Erfurt_Syntax_Manchester.g:466:5: DATA_PROPERTY_LABEL OPEN_BRACE datatypePropertyIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('DATA_PROPERTY_LABEL'),self::$FOLLOW_DATA_PROPERTY_LABEL_in_entity2278); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2280); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_datatypePropertyIRI_in_entity2282);
                    $this->datatypePropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2284); if ($this->state->failed) return ;

                    }
                    break;
                case 5 :
                    // src/Erfurt_Syntax_Manchester.g:467:5: ANNOTATION_PROPERTY_LABEL OPEN_BRACE annotationPropertyIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('ANNOTATION_PROPERTY_LABEL'),self::$FOLLOW_ANNOTATION_PROPERTY_LABEL_in_entity2290); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2292); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_annotationPropertyIRI_in_entity2294);
                    $this->annotationPropertyIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2296); if ($this->state->failed) return ;

                    }
                    break;
                case 6 :
                    // src/Erfurt_Syntax_Manchester.g:468:5: NAMED_INDIVIDUAL_LABEL OPEN_BRACE individualIRI CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('NAMED_INDIVIDUAL_LABEL'),self::$FOLLOW_NAMED_INDIVIDUAL_LABEL_in_entity2302); if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_entity2304); if ($this->state->failed) return ;
                    $this->pushFollow(self::$FOLLOW_individualIRI_in_entity2306);
                    $this->individualIRI();

                    $this->state->_fsp--;
                    if ($this->state->failed) return ;
                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_entity2308); if ($this->state->failed) return ;

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
    // src/Erfurt_Syntax_Manchester.g:475:1: ontologyIri : iri ; 
    public function ontologyIri(){
        $ontologyIri_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 62) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:476:2: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:476:4: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_ontologyIri2325);
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
    // src/Erfurt_Syntax_Manchester.g:479:1: versionIri : iri ; 
    public function versionIri(){
        $versionIri_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 63) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:480:2: ( iri ) 
            // src/Erfurt_Syntax_Manchester.g:480:4: iri 
            {
            $this->pushFollow(self::$FOLLOW_iri_in_versionIri2336);
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
    // src/Erfurt_Syntax_Manchester.g:483:1: imports : IMPORT_LABEL iri ; 
    public function imports(){
        $imports_StartIndex = $this->input->index();
        try {
            if ( $this->state->backtracking>0 && $this->alreadyParsedRule($this->input, 64) ) { return ; }
            // src/Erfurt_Syntax_Manchester.g:483:9: ( IMPORT_LABEL iri ) 
            // src/Erfurt_Syntax_Manchester.g:483:11: IMPORT_LABEL iri 
            {
            $this->match($this->input,$this->getToken('IMPORT_LABEL'),self::$FOLLOW_IMPORT_LABEL_in_imports2346); if ($this->state->failed) return ;
            $this->pushFollow(self::$FOLLOW_iri_in_imports2348);
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

    // $ANTLR start synpred15_Erfurt_Syntax_Manchester
    public function synpred15_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:73:3: (o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) ) 
        // src/Erfurt_Syntax_Manchester.g:73:3: o= objectPropertyExpression ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) 
        {
        $this->pushFollow(self::$FOLLOW_objectPropertyExpression_in_synpred15_Erfurt_Syntax_Manchester281);
        $o=$this->objectPropertyExpression();

        $this->state->_fsp--;
        if ($this->state->failed) return ;
        // src/Erfurt_Syntax_Manchester.g:74:5: ( ( SOME_LABEL p= primary ) | ( ONLY_LABEL p= primary ) | ( VALUE_LABEL i= individual ) | ( SELF_LABEL ) | ( MIN_LABEL nni= nonNegativeInteger p= primary ) | ( MAX_LABEL nni= nonNegativeInteger p= primary ) | ( EXACTLY_LABEL nni= nonNegativeInteger p= primary ) ) 
        $alt64=7;
        $LA64 = $this->input->LA(1);
        if($this->getToken('SOME_LABEL')== $LA64)
            {
            $alt64=1;
            }
        else if($this->getToken('ONLY_LABEL')== $LA64)
            {
            $alt64=2;
            }
        else if($this->getToken('VALUE_LABEL')== $LA64)
            {
            $alt64=3;
            }
        else if($this->getToken('SELF_LABEL')== $LA64)
            {
            $alt64=4;
            }
        else if($this->getToken('MIN_LABEL')== $LA64)
            {
            $alt64=5;
            }
        else if($this->getToken('MAX_LABEL')== $LA64)
            {
            $alt64=6;
            }
        else if($this->getToken('EXACTLY_LABEL')== $LA64)
            {
            $alt64=7;
            }
        else{
            if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
            $nvae =
                new NoViableAltException("", 64, 0, $this->input);

            throw $nvae;
        }

        switch ($alt64) {
            case 1 :
                // src/Erfurt_Syntax_Manchester.g:74:6: ( SOME_LABEL p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:74:6: ( SOME_LABEL p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:74:7: SOME_LABEL p= primary 
                {
                $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_synpred15_Erfurt_Syntax_Manchester289); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester293);
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
                $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester305); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester309);
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
                $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_synpred15_Erfurt_Syntax_Manchester321); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_individual_in_synpred15_Erfurt_Syntax_Manchester325);
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
                $this->match($this->input,$this->getToken('SELF_LABEL'),self::$FOLLOW_SELF_LABEL_in_synpred15_Erfurt_Syntax_Manchester337); if ($this->state->failed) return ;

                }


                }
                break;
            case 5 :
                // src/Erfurt_Syntax_Manchester.g:78:7: ( MIN_LABEL nni= nonNegativeInteger p= primary ) 
                {
                // src/Erfurt_Syntax_Manchester.g:78:7: ( MIN_LABEL nni= nonNegativeInteger p= primary ) 
                // src/Erfurt_Syntax_Manchester.g:78:8: MIN_LABEL nni= nonNegativeInteger p= primary 
                {
                $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_synpred15_Erfurt_Syntax_Manchester349); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester353);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester357);
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
                $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_synpred15_Erfurt_Syntax_Manchester369); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester373);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester377);
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
                $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester389); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester393);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester397);
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
        $this->pushFollow(self::$FOLLOW_dataPropertyExpression_in_synpred24_Erfurt_Syntax_Manchester412);
        $dp=$this->dataPropertyExpression();

        $this->state->_fsp--;
        if ($this->state->failed) return ;
        // src/Erfurt_Syntax_Manchester.g:82:30: ( ( SOME_LABEL d= dataRange ) | ( ONLY_LABEL d= dataRange ) | ( VALUE_LABEL l= literal ) | ( MIN_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( MAX_LABEL nni= nonNegativeInteger (d= dataRange )? ) | ( EXACTLY_LABEL nni= nonNegativeInteger (d= dataRange )? ) ) 
        $alt70=6;
        $LA70 = $this->input->LA(1);
        if($this->getToken('SOME_LABEL')== $LA70)
            {
            $alt70=1;
            }
        else if($this->getToken('ONLY_LABEL')== $LA70)
            {
            $alt70=2;
            }
        else if($this->getToken('VALUE_LABEL')== $LA70)
            {
            $alt70=3;
            }
        else if($this->getToken('MIN_LABEL')== $LA70)
            {
            $alt70=4;
            }
        else if($this->getToken('MAX_LABEL')== $LA70)
            {
            $alt70=5;
            }
        else if($this->getToken('EXACTLY_LABEL')== $LA70)
            {
            $alt70=6;
            }
        else{
            if ($this->state->backtracking>0) {$this->state->failed=true; return ;}
            $nvae =
                new NoViableAltException("", 70, 0, $this->input);

            throw $nvae;
        }

        switch ($alt70) {
            case 1 :
                // src/Erfurt_Syntax_Manchester.g:83:5: ( SOME_LABEL d= dataRange ) 
                {
                // src/Erfurt_Syntax_Manchester.g:83:5: ( SOME_LABEL d= dataRange ) 
                // src/Erfurt_Syntax_Manchester.g:83:6: SOME_LABEL d= dataRange 
                {
                $this->match($this->input,$this->getToken('SOME_LABEL'),self::$FOLLOW_SOME_LABEL_in_synpred24_Erfurt_Syntax_Manchester420); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester424);
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
                $this->match($this->input,$this->getToken('ONLY_LABEL'),self::$FOLLOW_ONLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester434); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester438);
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
                $this->match($this->input,$this->getToken('VALUE_LABEL'),self::$FOLLOW_VALUE_LABEL_in_synpred24_Erfurt_Syntax_Manchester448); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_literal_in_synpred24_Erfurt_Syntax_Manchester452);
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
                $this->match($this->input,$this->getToken('MIN_LABEL'),self::$FOLLOW_MIN_LABEL_in_synpred24_Erfurt_Syntax_Manchester461); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester465);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:86:40: (d= dataRange )? 
                $alt67=2;
                $LA67_0 = $this->input->LA(1);

                if ( ($LA67_0==$this->getToken('NOT_LABEL')||$LA67_0==$this->getToken('OPEN_CURLY_BRACE')||$LA67_0==$this->getToken('OPEN_BRACE')||($LA67_0>=$this->getToken('DECIMAL_LABEL') && $LA67_0<=$this->getToken('STRING_LABEL'))||($LA67_0>=$this->getToken('FULL_IRI') && $LA67_0<=$this->getToken('SIMPLE_IRI'))||$LA67_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt67=1;
                }
                switch ($alt67) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                        {
                        $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester469);
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
                $this->match($this->input,$this->getToken('MAX_LABEL'),self::$FOLLOW_MAX_LABEL_in_synpred24_Erfurt_Syntax_Manchester480); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester484);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:87:40: (d= dataRange )? 
                $alt68=2;
                $LA68_0 = $this->input->LA(1);

                if ( ($LA68_0==$this->getToken('NOT_LABEL')||$LA68_0==$this->getToken('OPEN_CURLY_BRACE')||$LA68_0==$this->getToken('OPEN_BRACE')||($LA68_0>=$this->getToken('DECIMAL_LABEL') && $LA68_0<=$this->getToken('STRING_LABEL'))||($LA68_0>=$this->getToken('FULL_IRI') && $LA68_0<=$this->getToken('SIMPLE_IRI'))||$LA68_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt68=1;
                }
                switch ($alt68) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                        {
                        $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester488);
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
                $this->match($this->input,$this->getToken('EXACTLY_LABEL'),self::$FOLLOW_EXACTLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester499); if ($this->state->failed) return ;
                $this->pushFollow(self::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester503);
                $nni=$this->nonNegativeInteger();

                $this->state->_fsp--;
                if ($this->state->failed) return ;
                // src/Erfurt_Syntax_Manchester.g:88:44: (d= dataRange )? 
                $alt69=2;
                $LA69_0 = $this->input->LA(1);

                if ( ($LA69_0==$this->getToken('NOT_LABEL')||$LA69_0==$this->getToken('OPEN_CURLY_BRACE')||$LA69_0==$this->getToken('OPEN_BRACE')||($LA69_0>=$this->getToken('DECIMAL_LABEL') && $LA69_0<=$this->getToken('STRING_LABEL'))||($LA69_0>=$this->getToken('FULL_IRI') && $LA69_0<=$this->getToken('SIMPLE_IRI'))||$LA69_0==$this->getToken('ABBREVIATED_IRI')) ) {
                    $alt69=1;
                }
                switch ($alt69) {
                    case 1 :
                        // src/Erfurt_Syntax_Manchester.g:0:0: d= dataRange 
                        {
                        $this->pushFollow(self::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester507);
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
        $this->match($this->input,$this->getToken('OR_LABEL'),self::$FOLLOW_OR_LABEL_in_synpred54_Erfurt_Syntax_Manchester1484); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_dataConjunction_in_synpred54_Erfurt_Syntax_Manchester1488);
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
        $this->match($this->input,$this->getToken('AND_LABEL'),self::$FOLLOW_AND_LABEL_in_synpred55_Erfurt_Syntax_Manchester1538); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_dataPrimary_in_synpred55_Erfurt_Syntax_Manchester1542);
        $d2=$this->dataPrimary();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred55_Erfurt_Syntax_Manchester

    // $ANTLR start synpred56_Erfurt_Syntax_Manchester
    public function synpred56_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:286:4: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:286:4: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred56_Erfurt_Syntax_Manchester1565);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred56_Erfurt_Syntax_Manchester

    // $ANTLR start synpred57_Erfurt_Syntax_Manchester
    public function synpred57_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:286:35: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:286:35: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred57_Erfurt_Syntax_Manchester1573);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred57_Erfurt_Syntax_Manchester

    // $ANTLR start synpred63_Erfurt_Syntax_Manchester
    public function synpred63_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:341:4: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:341:4: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred63_Erfurt_Syntax_Manchester1734);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred63_Erfurt_Syntax_Manchester

    // $ANTLR start synpred64_Erfurt_Syntax_Manchester
    public function synpred64_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:341:55: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:341:55: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred64_Erfurt_Syntax_Manchester1742);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred64_Erfurt_Syntax_Manchester

    // $ANTLR start synpred66_Erfurt_Syntax_Manchester
    public function synpred66_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:345:5: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:345:5: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred66_Erfurt_Syntax_Manchester1760);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred66_Erfurt_Syntax_Manchester

    // $ANTLR start synpred67_Erfurt_Syntax_Manchester
    public function synpred67_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:345:50: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:345:50: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred67_Erfurt_Syntax_Manchester1768);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred67_Erfurt_Syntax_Manchester

    // $ANTLR start synpred69_Erfurt_Syntax_Manchester
    public function synpred69_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:365:6: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:365:6: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred69_Erfurt_Syntax_Manchester1805);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred69_Erfurt_Syntax_Manchester

    // $ANTLR start synpred70_Erfurt_Syntax_Manchester
    public function synpred70_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:365:49: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:365:49: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred70_Erfurt_Syntax_Manchester1813);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred70_Erfurt_Syntax_Manchester

    // $ANTLR start synpred76_Erfurt_Syntax_Manchester
    public function synpred76_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:377:5: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:377:5: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred76_Erfurt_Syntax_Manchester1888);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred76_Erfurt_Syntax_Manchester

    // $ANTLR start synpred77_Erfurt_Syntax_Manchester
    public function synpred77_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:377:29: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:377:29: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred77_Erfurt_Syntax_Manchester1896);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred77_Erfurt_Syntax_Manchester

    // $ANTLR start synpred79_Erfurt_Syntax_Manchester
    public function synpred79_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:385:5: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:385:5: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred79_Erfurt_Syntax_Manchester1934);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred79_Erfurt_Syntax_Manchester

    // $ANTLR start synpred80_Erfurt_Syntax_Manchester
    public function synpred80_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:385:41: ( COMMA annotationPropertyIRIAnnotatedList ) 
        // src/Erfurt_Syntax_Manchester.g:385:41: COMMA annotationPropertyIRIAnnotatedList 
        {
        $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_synpred80_Erfurt_Syntax_Manchester1940); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_annotationPropertyIRIAnnotatedList_in_synpred80_Erfurt_Syntax_Manchester1942);
        $this->annotationPropertyIRIAnnotatedList();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred80_Erfurt_Syntax_Manchester

    // $ANTLR start synpred81_Erfurt_Syntax_Manchester
    public function synpred81_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:399:4: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:399:4: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred81_Erfurt_Syntax_Manchester1971);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred81_Erfurt_Syntax_Manchester

    // $ANTLR start synpred82_Erfurt_Syntax_Manchester
    public function synpred82_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:399:29: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:399:29: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred82_Erfurt_Syntax_Manchester1979);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred82_Erfurt_Syntax_Manchester

    // $ANTLR start synpred84_Erfurt_Syntax_Manchester
    public function synpred84_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:403:5: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:403:5: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred84_Erfurt_Syntax_Manchester2001);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred84_Erfurt_Syntax_Manchester

    // $ANTLR start synpred85_Erfurt_Syntax_Manchester
    public function synpred85_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:403:36: ( annotations ) 
        // src/Erfurt_Syntax_Manchester.g:403:36: annotations 
        {
        $this->pushFollow(self::$FOLLOW_annotations_in_synpred85_Erfurt_Syntax_Manchester2009);
        $this->annotations();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred85_Erfurt_Syntax_Manchester

    // $ANTLR start synpred89_Erfurt_Syntax_Manchester
    public function synpred89_Erfurt_Syntax_Manchester_fragment() {   
        // src/Erfurt_Syntax_Manchester.g:418:5: ( ANNOTATIONS_LABEL annotationAnnotatedList ) 
        // src/Erfurt_Syntax_Manchester.g:418:5: ANNOTATIONS_LABEL annotationAnnotatedList 
        {
        $this->match($this->input,$this->getToken('ANNOTATIONS_LABEL'),self::$FOLLOW_ANNOTATIONS_LABEL_in_synpred89_Erfurt_Syntax_Manchester2086); if ($this->state->failed) return ;
        $this->pushFollow(self::$FOLLOW_annotationAnnotatedList_in_synpred89_Erfurt_Syntax_Manchester2089);
        $this->annotationAnnotatedList();

        $this->state->_fsp--;
        if ($this->state->failed) return ;

        }
    }
    // $ANTLR end synpred89_Erfurt_Syntax_Manchester

    // Delegated rules

    public function synpred89_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred89_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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
    public function synpred80_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred80_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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
    public function synpred63_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred63_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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
    public function synpred70_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred70_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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
    public function synpred77_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred77_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
        } catch (RecognitionException $re) {
            echo("impossible: ".$re);
        }
        $success = !$this->state->failed;
        $this->input->rewind($start);
        $this->state->backtracking--;
        $this->state->failed=false;
        return $success;
    }
    public function synpred76_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred76_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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
    public function synpred67_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred67_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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
    public function synpred85_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred85_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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
    public function synpred64_Erfurt_Syntax_Manchester() {
        $this->state->backtracking++;
        $start = $this->input->mark();
        try {
            $this->synpred64_Erfurt_Syntax_Manchester_fragment(); // can never throw exception
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
		$min = array(1, 24, 7, 26, 4, 65535);
		$max = array(1, 91, 7, 84, 4, 65535);
		$accept = array(8, 65535, 1, 2, 1, 4, 1, 3, 1, 1);
		$special = array(12, 65535);
		$transitionS = array(array(1, 8, 11, 65535, 1, 9, 1, 65535, 1, 5, 1, 6, 
    1, 4, 1, 7, 39, 65535, 1, 1, 1, 3, 8, 65535, 1, 2), array(2, 11, 7, 
    65535, 1, 11, 1, 65535, 1, 11, 34, 65535, 1, 11, 11, 65535, 1, 10), 
    array(2, 11, 7, 65535, 1, 11, 1, 65535, 1, 11, 34, 65535, 1, 11, 11, 
    65535, 1, 10), array(2, 11, 7, 65535, 1, 11, 1, 65535, 1, 11, 34, 65535, 
    1, 11, 11, 65535, 1, 10), array(2, 11, 7, 65535, 1, 11, 1, 65535, 1, 
    11, 34, 65535, 1, 11, 11, 65535, 1, 10), array(2, 11, 7, 65535, 1, 11, 
    1, 65535, 1, 11, 34, 65535, 1, 11, 11, 65535, 1, 10), array(2, 11, 7, 
    65535, 1, 11, 1, 65535, 1, 11, 34, 65535, 1, 11, 11, 65535, 1, 10), 
    array(2, 11, 7, 65535, 1, 11, 1, 65535, 1, 11, 34, 65535, 1, 11, 11, 
    65535, 1, 10), array(), array(), array(), array());
		
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
 



Erfurt_Syntax_ManchesterParser::$FOLLOW_conjunction_in_description69 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_description82 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_conjunction_in_description86 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_conjunction120 = new Set(array(11));
Erfurt_Syntax_ManchesterParser::$FOLLOW_THAT_LABEL_in_conjunction122 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_conjunction130 = new Set(array(1, 27));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_conjunction139 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_conjunction143 = new Set(array(1, 27));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NOT_LABEL_in_primary169 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_restriction_in_primary176 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_atomic_in_primary182 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FULL_IRI_in_iri211 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ABBREVIATED_IRI_in_iri219 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SIMPLE_IRI_in_iri227 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_objectPropertyExpression252 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_inverseObjectProperty_in_objectPropertyExpression260 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_restriction281 = new Set(array(28, 29, 30, 31, 32, 33, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_restriction289 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction293 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_restriction305 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction309 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_restriction321 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_restriction325 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SELF_LABEL_in_restriction337 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_restriction349 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction353 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction357 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_restriction369 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction373 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction377 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_restriction389 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction393 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_restriction397 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_restriction412 = new Set(array(28, 29, 30, 32, 33, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_restriction420 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction424 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_restriction434 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction438 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_restriction448 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_restriction452 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_restriction461 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction465 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction469 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_restriction480 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction484 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction488 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_restriction499 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction503 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_restriction507 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_restriction534 = new Set(array(34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_restriction536 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_restriction540 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_atomic562 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_CURLY_BRACE_in_atomic570 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualList_in_atomic572 = new Set(array(25));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_CURLY_BRACE_in_atomic574 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_atomic582 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_description_in_atomic584 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_atomic586 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_classIRI607 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualList630 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_individualList639 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualList643 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualIRI_in_individual668 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NODE_ID_in_individual676 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DIGITS_in_nonNegativeInteger697 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NOT_LABEL_in_dataPrimary721 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataAtomic_in_dataPrimary725 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyIRI_in_dataPropertyExpression748 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_dataAtomic770 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_CURLY_BRACE_in_dataAtomic780 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literalList_in_dataAtomic782 = new Set(array(25));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_CURLY_BRACE_in_dataAtomic784 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataTypeRestriction_in_dataAtomic794 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_dataAtomic804 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_dataAtomic806 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_dataAtomic808 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_literalList832 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_literalList839 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_literalList843 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_datatypeIRI_in_dataType866 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_INTEGER_LABEL_in_dataType876 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DECIMAL_LABEL_in_dataType887 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FLOAT_LABEL_in_dataType897 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_STRING_LABEL_in_dataType907 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_typedLiteral_in_literal934 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_stringLiteralNoLanguage_in_literal940 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_stringLiteralWithLanguage_in_literal946 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_integerLiteral_in_literal952 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_decimalLiteral_in_literal958 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_floatingPointLiteral_in_literal964 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_stringLiteralNoLanguage983 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_stringLiteralWithLanguage1004 = new Set(array(88));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LANGUAGE_TAG_in_stringLiteralWithLanguage1006 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_QUOTED_STRING_in_lexicalValue1027 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_lexicalValue_in_typedLiteral1048 = new Set(array(42));
Erfurt_Syntax_ManchesterParser::$FOLLOW_REFERENCE_in_typedLiteral1050 = new Set(array(38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_typedLiteral1052 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_restrictionValue1073 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_INVERSE_LABEL_in_inverseObjectProperty1094 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_inverseObjectProperty1096 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DLITERAL_HELPER_in_decimalLiteral1117 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ILITERAL_HELPER_in_integerLiteral1139 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DIGITS_in_integerLiteral1145 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_FPLITERAL_HELPER_in_floatingPointLiteral1167 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_objectProperty1188 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyIRI_in_dataProperty1209 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_dataPropertyIRI1230 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_datatypeIRI1251 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_objectPropertyIRI1272 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_dataTypeRestriction1293 = new Set(array(84));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_SQUARE_BRACE_in_dataTypeRestriction1297 = new Set(array(6, 7, 8, 9, 10, 20, 21, 22, 23));
Erfurt_Syntax_ManchesterParser::$FOLLOW_facet_in_dataTypeRestriction1311 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_restrictionValue_in_dataTypeRestriction1315 = new Set(array(6, 7, 8, 9, 10, 20, 21, 22, 23, 35, 85));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataTypeRestriction1319 = new Set(array(6, 7, 8, 9, 10, 20, 21, 22, 23, 85));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_SQUARE_BRACE_in_dataTypeRestriction1326 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_individualIRI1345 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_datatypePropertyIRI1366 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LENGTH_LABEL_in_facet1393 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LENGTH_LABEL_in_facet1399 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LENGTH_LABEL_in_facet1405 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_PATTERN_LABEL_in_facet1411 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LANG_PATTERN_LABEL_in_facet1417 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LESS_EQUAL_in_facet1423 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_LESS_in_facet1429 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_GREATER_EQUAL_in_facet1435 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_GREATER_in_facet1441 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_dataRange1470 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_dataRange1484 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_dataRange1488 = new Set(array(1, 26));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_dataConjunction1521 = new Set(array(1, 27));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_dataConjunction1538 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_dataConjunction1542 = new Set(array(1, 27));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_annotationAnnotatedList1565 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotation_in_annotationAnnotatedList1568 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_annotationAnnotatedList1571 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_annotationAnnotatedList1573 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotation_in_annotationAnnotatedList1576 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRI_in_annotation1595 = new Set(array(16, 81, 82, 83, 87, 91, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationTarget_in_annotation1599 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NODE_ID_in_annotationTarget1616 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_annotationTarget1623 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_annotationTarget1630 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_annotations1647 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_annotations1651 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_description_in_descriptionList1682 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_descriptionList1687 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_description_in_descriptionList1691 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1734 = new Set(array(75));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1737 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_objectPropertyCharacteristicAnnotatedList1740 = new Set(array(72, 75));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_objectPropertyCharacteristicAnnotatedList1742 = new Set(array(75));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OBJECT_PROPERTY_CHARACTERISTIC_in_objectPropertyCharacteristicAnnotatedList1745 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1760 = new Set(array(12, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1763 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_objectPropertyExpressionAnnotatedList1766 = new Set(array(12, 72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_objectPropertyExpressionAnnotatedList1768 = new Set(array(12, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_objectPropertyExpressionAnnotatedList1771 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1805 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1808 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataPropertyExpressionAnnotatedList1811 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_dataPropertyExpressionAnnotatedList1813 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_dataPropertyExpressionAnnotatedList1816 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATION_PROPERTY_LABEL_in_annotationPropertyFrame1833 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRI_in_annotationPropertyFrame1835 = new Set(array(1, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_annotationPropertyFrame1841 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_annotationPropertyFrame1844 = new Set(array(1, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DOMAIN_LABEL_in_annotationPropertyFrame1853 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1856 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_RANGE_LABEL_in_annotationPropertyFrame1862 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iriAnnotatedList_in_annotationPropertyFrame1865 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SUB_PROPERTY_OF_LABEL_in_annotationPropertyFrame1871 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyFrame1873 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_iriAnnotatedList1888 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_iriAnnotatedList1891 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_iriAnnotatedList1894 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_iriAnnotatedList1896 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_iriAnnotatedList1899 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_annotationPropertyIRI1918 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_annotationPropertyIRIAnnotatedList1934 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRI_in_annotationPropertyIRIAnnotatedList1937 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_annotationPropertyIRIAnnotatedList1940 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRIAnnotatedList_in_annotationPropertyIRIAnnotatedList1942 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_factAnnotatedList1971 = new Set(array(17, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_fact_in_factAnnotatedList1974 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_factAnnotatedList1977 = new Set(array(17, 72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_factAnnotatedList1979 = new Set(array(17, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_fact_in_factAnnotatedList1982 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_individualAnnotatedList2001 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualAnnotatedList2004 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_individualAnnotatedList2007 = new Set(array(72, 81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_individualAnnotatedList2009 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individualAnnotatedList2012 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NOT_LABEL_in_fact2026 = new Set(array(17, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyFact_in_fact2030 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyFact_in_fact2034 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_objectPropertyFact2045 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_objectPropertyFact2047 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyIRI_in_dataPropertyFact2061 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_dataPropertyFact2063 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DATATYPE_LABEL_in_datatypeFrame2077 = new Set(array(38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_datatypeFrame2080 = new Set(array(1, 65, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2086 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_datatypeFrame2089 = new Set(array(1, 65, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EQUIVALENT_TO_LABEL_in_datatypeFrame2097 = new Set(array(17, 24, 36, 38, 39, 40, 41, 72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_datatypeFrame2100 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_datatypeFrame2102 = new Set(array(1, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_datatypeFrame2110 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_datatypeFrame2113 = new Set(array(1, 72));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_individual2List2138 = new Set(array(35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_individual2List2140 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualList_in_individual2List2142 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataProperty_in_dataProperty2List2154 = new Set(array(35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataProperty2List2156 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyList_in_dataProperty2List2158 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataProperty_in_dataPropertyList2172 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_dataPropertyList2175 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataProperty_in_dataPropertyList2177 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectProperty_in_objectProperty2List2193 = new Set(array(35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_objectProperty2List2195 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyList_in_objectProperty2List2197 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectProperty_in_objectPropertyList2211 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_objectPropertyList2214 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectProperty_in_objectPropertyList2216 = new Set(array(1, 35));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DATATYPE_LABEL_in_entity2242 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2244 = new Set(array(38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataType_in_entity2246 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2248 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLASS_LABEL_in_entity2254 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2256 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_classIRI_in_entity2258 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2260 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OBJECT_PROPERTY_LABEL_in_entity2266 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2268 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyIRI_in_entity2270 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2272 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_DATA_PROPERTY_LABEL_in_entity2278 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2280 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_datatypePropertyIRI_in_entity2282 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2284 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATION_PROPERTY_LABEL_in_entity2290 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2292 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRI_in_entity2294 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2296 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_NAMED_INDIVIDUAL_LABEL_in_entity2302 = new Set(array(36));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OPEN_BRACE_in_entity2304 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individualIRI_in_entity2306 = new Set(array(37));
Erfurt_Syntax_ManchesterParser::$FOLLOW_CLOSE_BRACE_in_entity2308 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_ontologyIri2325 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_versionIri2336 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_IMPORT_LABEL_in_imports2346 = new Set(array(81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_iri_in_imports2348 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_objectPropertyExpression_in_synpred15_Erfurt_Syntax_Manchester281 = new Set(array(28, 29, 30, 31, 32, 33, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_synpred15_Erfurt_Syntax_Manchester289 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester293 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester305 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester309 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_synpred15_Erfurt_Syntax_Manchester321 = new Set(array(81, 82, 83, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_individual_in_synpred15_Erfurt_Syntax_Manchester325 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SELF_LABEL_in_synpred15_Erfurt_Syntax_Manchester337 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_synpred15_Erfurt_Syntax_Manchester349 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester353 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester357 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_synpred15_Erfurt_Syntax_Manchester369 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester373 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester377 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_synpred15_Erfurt_Syntax_Manchester389 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred15_Erfurt_Syntax_Manchester393 = new Set(array(12, 17, 24, 36, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_primary_in_synpred15_Erfurt_Syntax_Manchester397 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPropertyExpression_in_synpred24_Erfurt_Syntax_Manchester412 = new Set(array(28, 29, 30, 32, 33, 34));
Erfurt_Syntax_ManchesterParser::$FOLLOW_SOME_LABEL_in_synpred24_Erfurt_Syntax_Manchester420 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester424 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ONLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester434 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester438 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_VALUE_LABEL_in_synpred24_Erfurt_Syntax_Manchester448 = new Set(array(16, 87, 92, 93, 94));
Erfurt_Syntax_ManchesterParser::$FOLLOW_literal_in_synpred24_Erfurt_Syntax_Manchester452 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MIN_LABEL_in_synpred24_Erfurt_Syntax_Manchester461 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester465 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester469 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_MAX_LABEL_in_synpred24_Erfurt_Syntax_Manchester480 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester484 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester488 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_EXACTLY_LABEL_in_synpred24_Erfurt_Syntax_Manchester499 = new Set(array(16));
Erfurt_Syntax_ManchesterParser::$FOLLOW_nonNegativeInteger_in_synpred24_Erfurt_Syntax_Manchester503 = new Set(array(1, 17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataRange_in_synpred24_Erfurt_Syntax_Manchester507 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_OR_LABEL_in_synpred54_Erfurt_Syntax_Manchester1484 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataConjunction_in_synpred54_Erfurt_Syntax_Manchester1488 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_AND_LABEL_in_synpred55_Erfurt_Syntax_Manchester1538 = new Set(array(17, 24, 36, 38, 39, 40, 41, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_dataPrimary_in_synpred55_Erfurt_Syntax_Manchester1542 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred56_Erfurt_Syntax_Manchester1565 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred57_Erfurt_Syntax_Manchester1573 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred63_Erfurt_Syntax_Manchester1734 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred64_Erfurt_Syntax_Manchester1742 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred66_Erfurt_Syntax_Manchester1760 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred67_Erfurt_Syntax_Manchester1768 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred69_Erfurt_Syntax_Manchester1805 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred70_Erfurt_Syntax_Manchester1813 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred76_Erfurt_Syntax_Manchester1888 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred77_Erfurt_Syntax_Manchester1896 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred79_Erfurt_Syntax_Manchester1934 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_COMMA_in_synpred80_Erfurt_Syntax_Manchester1940 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationPropertyIRIAnnotatedList_in_synpred80_Erfurt_Syntax_Manchester1942 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred81_Erfurt_Syntax_Manchester1971 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred82_Erfurt_Syntax_Manchester1979 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred84_Erfurt_Syntax_Manchester2001 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotations_in_synpred85_Erfurt_Syntax_Manchester2009 = new Set(array(1));
Erfurt_Syntax_ManchesterParser::$FOLLOW_ANNOTATIONS_LABEL_in_synpred89_Erfurt_Syntax_Manchester2086 = new Set(array(72, 81, 82, 91));
Erfurt_Syntax_ManchesterParser::$FOLLOW_annotationAnnotatedList_in_synpred89_Erfurt_Syntax_Manchester2089 = new Set(array(1));

?>