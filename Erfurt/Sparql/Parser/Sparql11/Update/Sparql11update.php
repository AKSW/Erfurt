<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 Sparql11update.g 2010-03-22 22:31:16


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

class Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update extends AntlrParser {
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

    
    static $FOLLOW_prologue_in_updateUnit16;
    static $FOLLOW_update_in_updateUnit26;
    static $FOLLOW_manage_in_updateUnit34;
    static $FOLLOW_modify_in_update54;
    static $FOLLOW_insert_in_update60;
    static $FOLLOW_delete_in_update66;
    static $FOLLOW_load_in_update72;
    static $FOLLOW_clear_in_update78;
    static $FOLLOW_MODIFY_in_modify93;
    static $FOLLOW_graphIri_in_modify96;
    static $FOLLOW_DELETE_in_modify100;
    static $FOLLOW_constructTemplate_in_modify102;
    static $FOLLOW_INSERT_in_modify104;
    static $FOLLOW_constructTemplate_in_modify106;
    static $FOLLOW_updatePattern_in_modify108;
    static $FOLLOW_DELETE_in_delete124;
    static $FOLLOW_deleteData_in_delete134;
    static $FOLLOW_deleteTemplate_in_delete142;
    static $FOLLOW_DATA_in_deleteData161;
    static $FOLLOW_FROM_in_deleteData164;
    static $FOLLOW_iriRef_in_deleteData167;
    static $FOLLOW_constructTemplate_in_deleteData171;
    static $FOLLOW_FROM_in_deleteTemplate187;
    static $FOLLOW_iriRef_in_deleteTemplate190;
    static $FOLLOW_constructTemplate_in_deleteTemplate194;
    static $FOLLOW_updatePattern_in_deleteTemplate196;
    static $FOLLOW_INSERT_in_insert212;
    static $FOLLOW_insertData_in_insert222;
    static $FOLLOW_insertTemplate_in_insert230;
    static $FOLLOW_DATA_in_insertData249;
    static $FOLLOW_INTO_in_insertData252;
    static $FOLLOW_iriRef_in_insertData255;
    static $FOLLOW_constructTemplate_in_insertData259;
    static $FOLLOW_INTO_in_insertTemplate275;
    static $FOLLOW_iriRef_in_insertTemplate278;
    static $FOLLOW_constructTemplate_in_insertTemplate282;
    static $FOLLOW_updatePattern_in_insertTemplate284;
    static $FOLLOW_GRAPH_in_graphIri300;
    static $FOLLOW_iriRef_in_graphIri303;
    static $FOLLOW_LOAD_in_load318;
    static $FOLLOW_iriRef_in_load320;
    static $FOLLOW_INTO_in_load324;
    static $FOLLOW_iriRef_in_load326;
    static $FOLLOW_CLEAR_in_clear343;
    static $FOLLOW_graphIri_in_clear345;
    static $FOLLOW_create_in_manage361;
    static $FOLLOW_drop_in_manage367;
    static $FOLLOW_CREATE_in_create382;
    static $FOLLOW_SILENT_in_create384;
    static $FOLLOW_graphIri_in_create387;
    static $FOLLOW_DROP_in_drop402;
    static $FOLLOW_SILENT_in_drop404;
    static $FOLLOW_graphIri_in_drop407;
    static $FOLLOW_WHERE_in_updatePattern422;
    static $FOLLOW_groupGraphPattern_in_updatePattern425;
    static $FOLLOW_triplesBlock_in_groupGraphPatternSub455;
    static $FOLLOW_graphPatternNotTriples_in_groupGraphPatternSub474;
    static $FOLLOW_filter_in_groupGraphPatternSub484;
    static $FOLLOW_DOT_in_groupGraphPatternSub496;
    static $FOLLOW_triplesBlock_in_groupGraphPatternSub499;
    static $FOLLOW_EXISTS_in_existsFunc543;
    static $FOLLOW_groupGraphPattern_in_existsFunc545;
    static $FOLLOW_UNSAID_in_notExistsFunc569;
    static $FOLLOW_NOT_in_notExistsFunc577;
    static $FOLLOW_EXISTS_in_notExistsFunc579;
    static $FOLLOW_groupGraphPattern_in_notExistsFunc587;
    static $FOLLOW_COUNT_in_aggregate605;
    static $FOLLOW_OPEN_BRACE_in_aggregate607;
    static $FOLLOW_ASTERISK_in_aggregate617;
    static $FOLLOW_variable_in_aggregate625;
    static $FOLLOW_DISTINCT_in_aggregate633;
    static $FOLLOW_ASTERISK_in_aggregate647;
    static $FOLLOW_variable_in_aggregate657;
    static $FOLLOW_CLOSE_BRACE_in_aggregate671;
    static $FOLLOW_SUM_in_aggregate677;
    static $FOLLOW_OPEN_BRACE_in_aggregate679;
    static $FOLLOW_expression_in_aggregate681;
    static $FOLLOW_CLOSE_BRACE_in_aggregate683;
    static $FOLLOW_MIN_in_aggregate689;
    static $FOLLOW_OPEN_BRACE_in_aggregate691;
    static $FOLLOW_expression_in_aggregate693;
    static $FOLLOW_CLOSE_BRACE_in_aggregate695;
    static $FOLLOW_MAX_in_aggregate701;
    static $FOLLOW_OPEN_BRACE_in_aggregate703;
    static $FOLLOW_expression_in_aggregate705;
    static $FOLLOW_CLOSE_BRACE_in_aggregate707;
    static $FOLLOW_AVG_in_aggregate713;
    static $FOLLOW_OPEN_BRACE_in_aggregate715;
    static $FOLLOW_expression_in_aggregate717;
    static $FOLLOW_CLOSE_BRACE_in_aggregate719;
    static $FOLLOW_varOrTerm_in_triplesSameSubjectPath737;
    static $FOLLOW_propertyListNotEmptyPath_in_triplesSameSubjectPath739;
    static $FOLLOW_triplesNode_in_triplesSameSubjectPath745;
    static $FOLLOW_propertyListPath_in_triplesSameSubjectPath747;
    static $FOLLOW_verbPath_in_propertyListNotEmptyPath771;
    static $FOLLOW_verbSimple_in_propertyListNotEmptyPath779;
    static $FOLLOW_objectList_in_propertyListNotEmptyPath787;
    static $FOLLOW_SEMICOLON_in_propertyListNotEmptyPath797;
    static $FOLLOW_verbPath_in_propertyListNotEmptyPath821;
    static $FOLLOW_verbSimple_in_propertyListNotEmptyPath833;
    static $FOLLOW_objectList_in_propertyListNotEmptyPath849;
    static $FOLLOW_propertyListNotEmpty_in_propertyListPath879;
    static $FOLLOW_path_in_verbPath898;
    static $FOLLOW_variable_in_verbSimple916;
    static $FOLLOW_path_in_pathUnit934;
    static $FOLLOW_pathAlternative_in_path952;
    static $FOLLOW_pathSequence_in_pathAlternative970;
    static $FOLLOW_pathEltOrReverse_in_pathSequence988;
    static $FOLLOW_DIVIDE_in_pathSequence998;
    static $FOLLOW_pathEltOrReverse_in_pathSequence1000;
    static $FOLLOW_HAT_LABEL_in_pathSequence1008;
    static $FOLLOW_pathElt_in_pathSequence1010;
    static $FOLLOW_pathPrimary_in_pathElt1033;
    static $FOLLOW_pathMod_in_pathElt1035;
    static $FOLLOW_pathElt_in_pathEltOrReverse1054;
    static $FOLLOW_HAT_LABEL_in_pathEltOrReverse1060;
    static $FOLLOW_pathElt_in_pathEltOrReverse1062;
    static $FOLLOW_ASTERISK_in_pathMod1080;
    static $FOLLOW_QUESTION_MARK_LABEL_in_pathMod1086;
    static $FOLLOW_PLUS_in_pathMod1092;
    static $FOLLOW_OPEN_CURLY_BRACE_in_pathMod1098;
    static $FOLLOW_INTEGER_in_pathMod1108;
    static $FOLLOW_COMMA_in_pathMod1122;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1140;
    static $FOLLOW_INTEGER_in_pathMod1152;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1154;
    static $FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1172;
    static $FOLLOW_iriRef_in_pathPrimary1200;
    static $FOLLOW_A_in_pathPrimary1206;
    static $FOLLOW_OPEN_BRACE_in_pathPrimary1212;
    static $FOLLOW_path_in_pathPrimary1214;
    static $FOLLOW_CLOSE_BRACE_in_pathPrimary1216;

    
    

        public function __construct($input, $state, $gErfurt_Sparql_Parser_Sparql11_Update = null) {
            if($state==null){
                $state = new RecognizerSharedState();
            }
            parent::__construct($input, $state, $gErfurt_Sparql_Parser_Sparql11_Update);
            $this->gErfurt_Sparql_Parser_Sparql11_Update = $gErfurt_Sparql_Parser_Sparql11_Update;
             
            $this->gParent = $this->gErfurt_Sparql_Parser_Sparql11_Update;
            
            
        }
        

    public function getTokenNames() { return Erfurt_Sparql_Parser_Sparql11_UpdateParser::$tokenNames; }
    public function getGrammarFileName() { return "Sparql11update.g"; }



    // $ANTLR start "updateUnit"
    // Sparql11update.g:3:1: updateUnit : prologue ( update | manage )* ; 
    public function updateUnit(){
        try {
            // Sparql11update.g:4:3: ( prologue ( update | manage )* ) 
            // Sparql11update.g:5:3: prologue ( update | manage )* 
            {
            $this->pushFollow(self::$FOLLOW_prologue_in_updateUnit16);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->prologue();

            $this->state->_fsp--;

            // Sparql11update.g:6:3: ( update | manage )* 
            //loop1:
            do {
                $alt1=3;
                $LA1_0 = $this->input->LA(1);

                if ( (($LA1_0>=$this->getToken('MODIFY') && $LA1_0<=$this->getToken('INSERT'))||($LA1_0>=$this->getToken('LOAD') && $LA1_0<=$this->getToken('CLEAR'))) ) {
                    $alt1=1;
                }
                else if ( ($LA1_0==$this->getToken('CREATE')||$LA1_0==$this->getToken('DROP')) ) {
                    $alt1=2;
                }


                switch ($alt1) {
            	case 1 :
            	    // Sparql11update.g:7:5: update 
            	    {
            	    $this->pushFollow(self::$FOLLOW_update_in_updateUnit26);
            	    $this->update();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // Sparql11update.g:8:7: manage 
            	    {
            	    $this->pushFollow(self::$FOLLOW_manage_in_updateUnit34);
            	    $this->manage();

            	    $this->state->_fsp--;


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
            throw $e;
        }
        
        return ;
    }
    // $ANTLR end "updateUnit"


    // $ANTLR start "update"
    // Sparql11update.g:12:1: update : ( modify | insert | delete | load | clear ); 
    public function update(){
        try {
            // Sparql11update.g:13:3: ( modify | insert | delete | load | clear ) 
            $alt2=5;
            $LA2 = $this->input->LA(1);
            if($this->getToken('MODIFY')== $LA2)
                {
                $alt2=1;
                }
            else if($this->getToken('INSERT')== $LA2)
                {
                $alt2=2;
                }
            else if($this->getToken('DELETE')== $LA2)
                {
                $alt2=3;
                }
            else if($this->getToken('LOAD')== $LA2)
                {
                $alt2=4;
                }
            else if($this->getToken('CLEAR')== $LA2)
                {
                $alt2=5;
                }
            else{
                $nvae =
                    new NoViableAltException("", 2, 0, $this->input);

                throw $nvae;
            }

            switch ($alt2) {
                case 1 :
                    // Sparql11update.g:14:3: modify 
                    {
                    $this->pushFollow(self::$FOLLOW_modify_in_update54);
                    $this->modify();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11update.g:15:5: insert 
                    {
                    $this->pushFollow(self::$FOLLOW_insert_in_update60);
                    $this->insert();

                    $this->state->_fsp--;


                    }
                    break;
                case 3 :
                    // Sparql11update.g:16:5: delete 
                    {
                    $this->pushFollow(self::$FOLLOW_delete_in_update66);
                    $this->delete();

                    $this->state->_fsp--;


                    }
                    break;
                case 4 :
                    // Sparql11update.g:17:5: load 
                    {
                    $this->pushFollow(self::$FOLLOW_load_in_update72);
                    $this->load();

                    $this->state->_fsp--;


                    }
                    break;
                case 5 :
                    // Sparql11update.g:18:5: clear 
                    {
                    $this->pushFollow(self::$FOLLOW_clear_in_update78);
                    $this->clear();

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
    // $ANTLR end "update"


    // $ANTLR start "modify"
    // Sparql11update.g:21:1: modify : MODIFY ( graphIri )* DELETE constructTemplate INSERT constructTemplate ( updatePattern )? ; 
    public function modify(){
        try {
            // Sparql11update.g:22:3: ( MODIFY ( graphIri )* DELETE constructTemplate INSERT constructTemplate ( updatePattern )? ) 
            // Sparql11update.g:23:3: MODIFY ( graphIri )* DELETE constructTemplate INSERT constructTemplate ( updatePattern )? 
            {
            $this->match($this->input,$this->getToken('MODIFY'),self::$FOLLOW_MODIFY_in_modify93); 
            // Sparql11update.g:23:10: ( graphIri )* 
            //loop3:
            do {
                $alt3=2;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('GRAPH')||$LA3_0==$this->getToken('IRI_REF')||$LA3_0==$this->getToken('PNAME_NS')||$LA3_0==$this->getToken('PNAME_LN')) ) {
                    $alt3=1;
                }


                switch ($alt3) {
            	case 1 :
            	    // Sparql11update.g:23:11: graphIri 
            	    {
            	    $this->pushFollow(self::$FOLLOW_graphIri_in_modify96);
            	    $this->graphIri();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop3;
                }
            } while (true);

            $this->match($this->input,$this->getToken('DELETE'),self::$FOLLOW_DELETE_in_modify100); 
            $this->pushFollow(self::$FOLLOW_constructTemplate_in_modify102);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->constructTemplate();

            $this->state->_fsp--;

            $this->match($this->input,$this->getToken('INSERT'),self::$FOLLOW_INSERT_in_modify104); 
            $this->pushFollow(self::$FOLLOW_constructTemplate_in_modify106);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->constructTemplate();

            $this->state->_fsp--;

            // Sparql11update.g:23:72: ( updatePattern )? 
            $alt4=2;
            $LA4_0 = $this->input->LA(1);

            if ( ($LA4_0==$this->getToken('WHERE')||$LA4_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                $alt4=1;
            }
            switch ($alt4) {
                case 1 :
                    // Sparql11update.g:23:72: updatePattern 
                    {
                    $this->pushFollow(self::$FOLLOW_updatePattern_in_modify108);
                    $this->updatePattern();

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
    // $ANTLR end "modify"


    // $ANTLR start "delete"
    // Sparql11update.g:26:1: delete : DELETE ( deleteData | deleteTemplate ) ; 
    public function delete(){
        try {
            // Sparql11update.g:27:3: ( DELETE ( deleteData | deleteTemplate ) ) 
            // Sparql11update.g:28:3: DELETE ( deleteData | deleteTemplate ) 
            {
            $this->match($this->input,$this->getToken('DELETE'),self::$FOLLOW_DELETE_in_delete124); 
            // Sparql11update.g:29:3: ( deleteData | deleteTemplate ) 
            $alt5=2;
            $LA5_0 = $this->input->LA(1);

            if ( ($LA5_0==$this->getToken('DATA')) ) {
                $alt5=1;
            }
            else if ( ($LA5_0==$this->getToken('FROM')||$LA5_0==$this->getToken('OPEN_CURLY_BRACE')||$LA5_0==$this->getToken('IRI_REF')||$LA5_0==$this->getToken('PNAME_NS')||$LA5_0==$this->getToken('PNAME_LN')) ) {
                $alt5=2;
            }
            else {
                $nvae = new NoViableAltException("", 5, 0, $this->input);

                throw $nvae;
            }
            switch ($alt5) {
                case 1 :
                    // Sparql11update.g:30:5: deleteData 
                    {
                    $this->pushFollow(self::$FOLLOW_deleteData_in_delete134);
                    $this->deleteData();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11update.g:31:7: deleteTemplate 
                    {
                    $this->pushFollow(self::$FOLLOW_deleteTemplate_in_delete142);
                    $this->deleteTemplate();

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
    // $ANTLR end "delete"


    // $ANTLR start "deleteData"
    // Sparql11update.g:35:1: deleteData : DATA ( ( FROM )? iriRef )* constructTemplate ; 
    public function deleteData(){
        try {
            // Sparql11update.g:36:3: ( DATA ( ( FROM )? iriRef )* constructTemplate ) 
            // Sparql11update.g:37:3: DATA ( ( FROM )? iriRef )* constructTemplate 
            {
            $this->match($this->input,$this->getToken('DATA'),self::$FOLLOW_DATA_in_deleteData161); 
            // Sparql11update.g:37:8: ( ( FROM )? iriRef )* 
            //loop7:
            do {
                $alt7=2;
                $LA7_0 = $this->input->LA(1);

                if ( ($LA7_0==$this->getToken('FROM')||$LA7_0==$this->getToken('IRI_REF')||$LA7_0==$this->getToken('PNAME_NS')||$LA7_0==$this->getToken('PNAME_LN')) ) {
                    $alt7=1;
                }


                switch ($alt7) {
            	case 1 :
            	    // Sparql11update.g:37:9: ( FROM )? iriRef 
            	    {
            	    // Sparql11update.g:37:9: ( FROM )? 
            	    $alt6=2;
            	    $LA6_0 = $this->input->LA(1);

            	    if ( ($LA6_0==$this->getToken('FROM')) ) {
            	        $alt6=1;
            	    }
            	    switch ($alt6) {
            	        case 1 :
            	            // Sparql11update.g:37:9: FROM 
            	            {
            	            $this->match($this->input,$this->getToken('FROM'),self::$FOLLOW_FROM_in_deleteData164); 

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_iriRef_in_deleteData167);
            	    $this->gErfurt_Sparql_Parser_Sparql11_Update->iriRef();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop7;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_constructTemplate_in_deleteData171);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->constructTemplate();

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
    // $ANTLR end "deleteData"


    // $ANTLR start "deleteTemplate"
    // Sparql11update.g:40:1: deleteTemplate : ( ( FROM )? iriRef )* constructTemplate ( updatePattern )? ; 
    public function deleteTemplate(){
        try {
            // Sparql11update.g:41:3: ( ( ( FROM )? iriRef )* constructTemplate ( updatePattern )? ) 
            // Sparql11update.g:42:3: ( ( FROM )? iriRef )* constructTemplate ( updatePattern )? 
            {
            // Sparql11update.g:42:3: ( ( FROM )? iriRef )* 
            //loop9:
            do {
                $alt9=2;
                $LA9_0 = $this->input->LA(1);

                if ( ($LA9_0==$this->getToken('FROM')||$LA9_0==$this->getToken('IRI_REF')||$LA9_0==$this->getToken('PNAME_NS')||$LA9_0==$this->getToken('PNAME_LN')) ) {
                    $alt9=1;
                }


                switch ($alt9) {
            	case 1 :
            	    // Sparql11update.g:42:4: ( FROM )? iriRef 
            	    {
            	    // Sparql11update.g:42:4: ( FROM )? 
            	    $alt8=2;
            	    $LA8_0 = $this->input->LA(1);

            	    if ( ($LA8_0==$this->getToken('FROM')) ) {
            	        $alt8=1;
            	    }
            	    switch ($alt8) {
            	        case 1 :
            	            // Sparql11update.g:42:4: FROM 
            	            {
            	            $this->match($this->input,$this->getToken('FROM'),self::$FOLLOW_FROM_in_deleteTemplate187); 

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_iriRef_in_deleteTemplate190);
            	    $this->gErfurt_Sparql_Parser_Sparql11_Update->iriRef();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop9;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_constructTemplate_in_deleteTemplate194);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->constructTemplate();

            $this->state->_fsp--;

            // Sparql11update.g:42:37: ( updatePattern )? 
            $alt10=2;
            $LA10_0 = $this->input->LA(1);

            if ( ($LA10_0==$this->getToken('WHERE')||$LA10_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                $alt10=1;
            }
            switch ($alt10) {
                case 1 :
                    // Sparql11update.g:42:37: updatePattern 
                    {
                    $this->pushFollow(self::$FOLLOW_updatePattern_in_deleteTemplate196);
                    $this->updatePattern();

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
    // $ANTLR end "deleteTemplate"


    // $ANTLR start "insert"
    // Sparql11update.g:45:1: insert : INSERT ( insertData | insertTemplate ) ; 
    public function insert(){
        try {
            // Sparql11update.g:46:3: ( INSERT ( insertData | insertTemplate ) ) 
            // Sparql11update.g:47:3: INSERT ( insertData | insertTemplate ) 
            {
            $this->match($this->input,$this->getToken('INSERT'),self::$FOLLOW_INSERT_in_insert212); 
            // Sparql11update.g:48:3: ( insertData | insertTemplate ) 
            $alt11=2;
            $LA11_0 = $this->input->LA(1);

            if ( ($LA11_0==$this->getToken('DATA')) ) {
                $alt11=1;
            }
            else if ( ($LA11_0==$this->getToken('INTO')||$LA11_0==$this->getToken('OPEN_CURLY_BRACE')||$LA11_0==$this->getToken('IRI_REF')||$LA11_0==$this->getToken('PNAME_NS')||$LA11_0==$this->getToken('PNAME_LN')) ) {
                $alt11=2;
            }
            else {
                $nvae = new NoViableAltException("", 11, 0, $this->input);

                throw $nvae;
            }
            switch ($alt11) {
                case 1 :
                    // Sparql11update.g:49:5: insertData 
                    {
                    $this->pushFollow(self::$FOLLOW_insertData_in_insert222);
                    $this->insertData();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11update.g:50:7: insertTemplate 
                    {
                    $this->pushFollow(self::$FOLLOW_insertTemplate_in_insert230);
                    $this->insertTemplate();

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
    // $ANTLR end "insert"


    // $ANTLR start "insertData"
    // Sparql11update.g:54:1: insertData : DATA ( ( INTO )? iriRef )* constructTemplate ; 
    public function insertData(){
        try {
            // Sparql11update.g:55:3: ( DATA ( ( INTO )? iriRef )* constructTemplate ) 
            // Sparql11update.g:56:3: DATA ( ( INTO )? iriRef )* constructTemplate 
            {
            $this->match($this->input,$this->getToken('DATA'),self::$FOLLOW_DATA_in_insertData249); 
            // Sparql11update.g:56:8: ( ( INTO )? iriRef )* 
            //loop13:
            do {
                $alt13=2;
                $LA13_0 = $this->input->LA(1);

                if ( ($LA13_0==$this->getToken('INTO')||$LA13_0==$this->getToken('IRI_REF')||$LA13_0==$this->getToken('PNAME_NS')||$LA13_0==$this->getToken('PNAME_LN')) ) {
                    $alt13=1;
                }


                switch ($alt13) {
            	case 1 :
            	    // Sparql11update.g:56:9: ( INTO )? iriRef 
            	    {
            	    // Sparql11update.g:56:9: ( INTO )? 
            	    $alt12=2;
            	    $LA12_0 = $this->input->LA(1);

            	    if ( ($LA12_0==$this->getToken('INTO')) ) {
            	        $alt12=1;
            	    }
            	    switch ($alt12) {
            	        case 1 :
            	            // Sparql11update.g:56:9: INTO 
            	            {
            	            $this->match($this->input,$this->getToken('INTO'),self::$FOLLOW_INTO_in_insertData252); 

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_iriRef_in_insertData255);
            	    $this->gErfurt_Sparql_Parser_Sparql11_Update->iriRef();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop13;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_constructTemplate_in_insertData259);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->constructTemplate();

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
    // $ANTLR end "insertData"


    // $ANTLR start "insertTemplate"
    // Sparql11update.g:59:1: insertTemplate : ( ( INTO )? iriRef )* constructTemplate ( updatePattern )? ; 
    public function insertTemplate(){
        try {
            // Sparql11update.g:60:3: ( ( ( INTO )? iriRef )* constructTemplate ( updatePattern )? ) 
            // Sparql11update.g:61:3: ( ( INTO )? iriRef )* constructTemplate ( updatePattern )? 
            {
            // Sparql11update.g:61:3: ( ( INTO )? iriRef )* 
            //loop15:
            do {
                $alt15=2;
                $LA15_0 = $this->input->LA(1);

                if ( ($LA15_0==$this->getToken('INTO')||$LA15_0==$this->getToken('IRI_REF')||$LA15_0==$this->getToken('PNAME_NS')||$LA15_0==$this->getToken('PNAME_LN')) ) {
                    $alt15=1;
                }


                switch ($alt15) {
            	case 1 :
            	    // Sparql11update.g:61:4: ( INTO )? iriRef 
            	    {
            	    // Sparql11update.g:61:4: ( INTO )? 
            	    $alt14=2;
            	    $LA14_0 = $this->input->LA(1);

            	    if ( ($LA14_0==$this->getToken('INTO')) ) {
            	        $alt14=1;
            	    }
            	    switch ($alt14) {
            	        case 1 :
            	            // Sparql11update.g:61:4: INTO 
            	            {
            	            $this->match($this->input,$this->getToken('INTO'),self::$FOLLOW_INTO_in_insertTemplate275); 

            	            }
            	            break;

            	    }

            	    $this->pushFollow(self::$FOLLOW_iriRef_in_insertTemplate278);
            	    $this->gErfurt_Sparql_Parser_Sparql11_Update->iriRef();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop15;
                }
            } while (true);

            $this->pushFollow(self::$FOLLOW_constructTemplate_in_insertTemplate282);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->constructTemplate();

            $this->state->_fsp--;

            // Sparql11update.g:61:37: ( updatePattern )? 
            $alt16=2;
            $LA16_0 = $this->input->LA(1);

            if ( ($LA16_0==$this->getToken('WHERE')||$LA16_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                $alt16=1;
            }
            switch ($alt16) {
                case 1 :
                    // Sparql11update.g:61:37: updatePattern 
                    {
                    $this->pushFollow(self::$FOLLOW_updatePattern_in_insertTemplate284);
                    $this->updatePattern();

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
    // $ANTLR end "insertTemplate"


    // $ANTLR start "graphIri"
    // Sparql11update.g:64:1: graphIri : ( GRAPH )? iriRef ; 
    public function graphIri(){
        try {
            // Sparql11update.g:65:3: ( ( GRAPH )? iriRef ) 
            // Sparql11update.g:66:3: ( GRAPH )? iriRef 
            {
            // Sparql11update.g:66:3: ( GRAPH )? 
            $alt17=2;
            $LA17_0 = $this->input->LA(1);

            if ( ($LA17_0==$this->getToken('GRAPH')) ) {
                $alt17=1;
            }
            switch ($alt17) {
                case 1 :
                    // Sparql11update.g:66:3: GRAPH 
                    {
                    $this->match($this->input,$this->getToken('GRAPH'),self::$FOLLOW_GRAPH_in_graphIri300); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_iriRef_in_graphIri303);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->iriRef();

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
    // $ANTLR end "graphIri"


    // $ANTLR start "load"
    // Sparql11update.g:69:1: load : LOAD ( iriRef )+ ( INTO iriRef )? ; 
    public function load(){
        try {
            // Sparql11update.g:70:3: ( LOAD ( iriRef )+ ( INTO iriRef )? ) 
            // Sparql11update.g:71:3: LOAD ( iriRef )+ ( INTO iriRef )? 
            {
            $this->match($this->input,$this->getToken('LOAD'),self::$FOLLOW_LOAD_in_load318); 
            // Sparql11update.g:71:8: ( iriRef )+ 
            $cnt18=0;
            //loop18:
            do {
                $alt18=2;
                $LA18_0 = $this->input->LA(1);

                if ( ($LA18_0==$this->getToken('IRI_REF')||$LA18_0==$this->getToken('PNAME_NS')||$LA18_0==$this->getToken('PNAME_LN')) ) {
                    $alt18=1;
                }


                switch ($alt18) {
            	case 1 :
            	    // Sparql11update.g:71:8: iriRef 
            	    {
            	    $this->pushFollow(self::$FOLLOW_iriRef_in_load320);
            	    $this->gErfurt_Sparql_Parser_Sparql11_Update->iriRef();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    if ( $cnt18 >= 1 ) break 2;//loop18;
                        $eee =
                            new EarlyExitException(18, $this->input);
                        throw $eee;
                }
                $cnt18++;
            } while (true);

            // Sparql11update.g:71:16: ( INTO iriRef )? 
            $alt19=2;
            $LA19_0 = $this->input->LA(1);

            if ( ($LA19_0==$this->getToken('INTO')) ) {
                $alt19=1;
            }
            switch ($alt19) {
                case 1 :
                    // Sparql11update.g:71:17: INTO iriRef 
                    {
                    $this->match($this->input,$this->getToken('INTO'),self::$FOLLOW_INTO_in_load324); 
                    $this->pushFollow(self::$FOLLOW_iriRef_in_load326);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->iriRef();

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
    // $ANTLR end "load"


    // $ANTLR start "clear"
    // Sparql11update.g:74:1: clear : CLEAR ( graphIri )? ; 
    public function clear(){
        try {
            // Sparql11update.g:75:3: ( CLEAR ( graphIri )? ) 
            // Sparql11update.g:76:3: CLEAR ( graphIri )? 
            {
            $this->match($this->input,$this->getToken('CLEAR'),self::$FOLLOW_CLEAR_in_clear343); 
            // Sparql11update.g:76:9: ( graphIri )? 
            $alt20=2;
            $LA20_0 = $this->input->LA(1);

            if ( ($LA20_0==$this->getToken('GRAPH')||$LA20_0==$this->getToken('IRI_REF')||$LA20_0==$this->getToken('PNAME_NS')||$LA20_0==$this->getToken('PNAME_LN')) ) {
                $alt20=1;
            }
            switch ($alt20) {
                case 1 :
                    // Sparql11update.g:76:9: graphIri 
                    {
                    $this->pushFollow(self::$FOLLOW_graphIri_in_clear345);
                    $this->graphIri();

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
    // $ANTLR end "clear"


    // $ANTLR start "manage"
    // Sparql11update.g:79:1: manage : ( create | drop ); 
    public function manage(){
        try {
            // Sparql11update.g:80:3: ( create | drop ) 
            $alt21=2;
            $LA21_0 = $this->input->LA(1);

            if ( ($LA21_0==$this->getToken('CREATE')) ) {
                $alt21=1;
            }
            else if ( ($LA21_0==$this->getToken('DROP')) ) {
                $alt21=2;
            }
            else {
                $nvae = new NoViableAltException("", 21, 0, $this->input);

                throw $nvae;
            }
            switch ($alt21) {
                case 1 :
                    // Sparql11update.g:81:3: create 
                    {
                    $this->pushFollow(self::$FOLLOW_create_in_manage361);
                    $this->create();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11update.g:82:5: drop 
                    {
                    $this->pushFollow(self::$FOLLOW_drop_in_manage367);
                    $this->drop();

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
    // $ANTLR end "manage"


    // $ANTLR start "create"
    // Sparql11update.g:85:1: create : CREATE ( SILENT )? graphIri ; 
    public function create(){
        try {
            // Sparql11update.g:86:3: ( CREATE ( SILENT )? graphIri ) 
            // Sparql11update.g:87:3: CREATE ( SILENT )? graphIri 
            {
            $this->match($this->input,$this->getToken('CREATE'),self::$FOLLOW_CREATE_in_create382); 
            // Sparql11update.g:87:10: ( SILENT )? 
            $alt22=2;
            $LA22_0 = $this->input->LA(1);

            if ( ($LA22_0==$this->getToken('SILENT')) ) {
                $alt22=1;
            }
            switch ($alt22) {
                case 1 :
                    // Sparql11update.g:87:10: SILENT 
                    {
                    $this->match($this->input,$this->getToken('SILENT'),self::$FOLLOW_SILENT_in_create384); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_graphIri_in_create387);
            $this->graphIri();

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
    // $ANTLR end "create"


    // $ANTLR start "drop"
    // Sparql11update.g:90:1: drop : DROP ( SILENT )? graphIri ; 
    public function drop(){
        try {
            // Sparql11update.g:91:3: ( DROP ( SILENT )? graphIri ) 
            // Sparql11update.g:92:3: DROP ( SILENT )? graphIri 
            {
            $this->match($this->input,$this->getToken('DROP'),self::$FOLLOW_DROP_in_drop402); 
            // Sparql11update.g:92:8: ( SILENT )? 
            $alt23=2;
            $LA23_0 = $this->input->LA(1);

            if ( ($LA23_0==$this->getToken('SILENT')) ) {
                $alt23=1;
            }
            switch ($alt23) {
                case 1 :
                    // Sparql11update.g:92:8: SILENT 
                    {
                    $this->match($this->input,$this->getToken('SILENT'),self::$FOLLOW_SILENT_in_drop404); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_graphIri_in_drop407);
            $this->graphIri();

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
    // $ANTLR end "drop"


    // $ANTLR start "updatePattern"
    // Sparql11update.g:95:1: updatePattern : ( WHERE )? groupGraphPattern ; 
    public function updatePattern(){
        try {
            // Sparql11update.g:96:3: ( ( WHERE )? groupGraphPattern ) 
            // Sparql11update.g:97:3: ( WHERE )? groupGraphPattern 
            {
            // Sparql11update.g:97:3: ( WHERE )? 
            $alt24=2;
            $LA24_0 = $this->input->LA(1);

            if ( ($LA24_0==$this->getToken('WHERE')) ) {
                $alt24=1;
            }
            switch ($alt24) {
                case 1 :
                    // Sparql11update.g:97:3: WHERE 
                    {
                    $this->match($this->input,$this->getToken('WHERE'),self::$FOLLOW_WHERE_in_updatePattern422); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_updatePattern425);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->groupGraphPattern();

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
    // $ANTLR end "updatePattern"


    // $ANTLR start "groupGraphPatternSub"
    // Sparql11update.g:114:1: groupGraphPatternSub : ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* ; 
    public function groupGraphPatternSub(){
        try {
            // Sparql11update.g:115:3: ( ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* ) 
            // Sparql11update.g:116:3: ( triplesBlock )? ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* 
            {
            // Sparql11update.g:116:3: ( triplesBlock )? 
            $alt25=2;
            $LA25_0 = $this->input->LA(1);

            if ( (($LA25_0>=$this->getToken('TRUE') && $LA25_0<=$this->getToken('FALSE'))||$LA25_0==$this->getToken('IRI_REF')||$LA25_0==$this->getToken('PNAME_NS')||$LA25_0==$this->getToken('PNAME_LN')||($LA25_0>=$this->getToken('VAR1') && $LA25_0<=$this->getToken('VAR2'))||$LA25_0==$this->getToken('INTEGER')||$LA25_0==$this->getToken('DECIMAL')||$LA25_0==$this->getToken('DOUBLE')||($LA25_0>=$this->getToken('INTEGER_POSITIVE') && $LA25_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA25_0>=$this->getToken('STRING_LITERAL1') && $LA25_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA25_0==$this->getToken('BLANK_NODE_LABEL')||$LA25_0==$this->getToken('OPEN_BRACE')||$LA25_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                $alt25=1;
            }
            switch ($alt25) {
                case 1 :
                    // Sparql11update.g:116:3: triplesBlock 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPatternSub455);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->triplesBlock();

                    $this->state->_fsp--;


                    }
                    break;

            }

            // Sparql11update.g:117:3: ( ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? )* 
            //loop29:
            do {
                $alt29=2;
                $LA29_0 = $this->input->LA(1);

                if ( (($LA29_0>=$this->getToken('OPTIONAL') && $LA29_0<=$this->getToken('GRAPH'))||$LA29_0==$this->getToken('FILTER')||$LA29_0==$this->getToken('OPEN_CURLY_BRACE')) ) {
                    $alt29=1;
                }


                switch ($alt29) {
            	case 1 :
            	    // Sparql11update.g:118:5: ( graphPatternNotTriples | filter ) ( DOT )? ( triplesBlock )? 
            	    {
            	    // Sparql11update.g:118:5: ( graphPatternNotTriples | filter ) 
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
            	            // Sparql11update.g:119:7: graphPatternNotTriples 
            	            {
            	            $this->pushFollow(self::$FOLLOW_graphPatternNotTriples_in_groupGraphPatternSub474);
            	            $this->gErfurt_Sparql_Parser_Sparql11_Update->graphPatternNotTriples();

            	            $this->state->_fsp--;


            	            }
            	            break;
            	        case 2 :
            	            // Sparql11update.g:120:9: filter 
            	            {
            	            $this->pushFollow(self::$FOLLOW_filter_in_groupGraphPatternSub484);
            	            $this->gErfurt_Sparql_Parser_Sparql11_Update->filter();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }

            	    // Sparql11update.g:122:5: ( DOT )? 
            	    $alt27=2;
            	    $LA27_0 = $this->input->LA(1);

            	    if ( ($LA27_0==$this->getToken('DOT')) ) {
            	        $alt27=1;
            	    }
            	    switch ($alt27) {
            	        case 1 :
            	            // Sparql11update.g:122:5: DOT 
            	            {
            	            $this->match($this->input,$this->getToken('DOT'),self::$FOLLOW_DOT_in_groupGraphPatternSub496); 

            	            }
            	            break;

            	    }

            	    // Sparql11update.g:122:10: ( triplesBlock )? 
            	    $alt28=2;
            	    $LA28_0 = $this->input->LA(1);

            	    if ( (($LA28_0>=$this->getToken('TRUE') && $LA28_0<=$this->getToken('FALSE'))||$LA28_0==$this->getToken('IRI_REF')||$LA28_0==$this->getToken('PNAME_NS')||$LA28_0==$this->getToken('PNAME_LN')||($LA28_0>=$this->getToken('VAR1') && $LA28_0<=$this->getToken('VAR2'))||$LA28_0==$this->getToken('INTEGER')||$LA28_0==$this->getToken('DECIMAL')||$LA28_0==$this->getToken('DOUBLE')||($LA28_0>=$this->getToken('INTEGER_POSITIVE') && $LA28_0<=$this->getToken('DOUBLE_NEGATIVE'))||($LA28_0>=$this->getToken('STRING_LITERAL1') && $LA28_0<=$this->getToken('STRING_LITERAL_LONG2'))||$LA28_0==$this->getToken('BLANK_NODE_LABEL')||$LA28_0==$this->getToken('OPEN_BRACE')||$LA28_0==$this->getToken('OPEN_SQUARE_BRACE')) ) {
            	        $alt28=1;
            	    }
            	    switch ($alt28) {
            	        case 1 :
            	            // Sparql11update.g:122:10: triplesBlock 
            	            {
            	            $this->pushFollow(self::$FOLLOW_triplesBlock_in_groupGraphPatternSub499);
            	            $this->gErfurt_Sparql_Parser_Sparql11_Update->triplesBlock();

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


    // $ANTLR start "existsFunc"
    // Sparql11update.g:148:1: existsFunc : EXISTS groupGraphPattern ; 
    public function existsFunc(){
        try {
            // Sparql11update.g:149:3: ( EXISTS groupGraphPattern ) 
            // Sparql11update.g:150:3: EXISTS groupGraphPattern 
            {
            $this->match($this->input,$this->getToken('EXISTS'),self::$FOLLOW_EXISTS_in_existsFunc543); 
            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_existsFunc545);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->groupGraphPattern();

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
    // $ANTLR end "existsFunc"


    // $ANTLR start "notExistsFunc"
    // Sparql11update.g:155:1: notExistsFunc : ( UNSAID | NOT EXISTS ) groupGraphPattern ; 
    public function notExistsFunc(){
        try {
            // Sparql11update.g:156:3: ( ( UNSAID | NOT EXISTS ) groupGraphPattern ) 
            // Sparql11update.g:157:3: ( UNSAID | NOT EXISTS ) groupGraphPattern 
            {
            // Sparql11update.g:157:3: ( UNSAID | NOT EXISTS ) 
            $alt30=2;
            $LA30_0 = $this->input->LA(1);

            if ( ($LA30_0==$this->getToken('UNSAID')) ) {
                $alt30=1;
            }
            else if ( ($LA30_0==$this->getToken('NOT')) ) {
                $alt30=2;
            }
            else {
                $nvae = new NoViableAltException("", 30, 0, $this->input);

                throw $nvae;
            }
            switch ($alt30) {
                case 1 :
                    // Sparql11update.g:158:5: UNSAID 
                    {
                    $this->match($this->input,$this->getToken('UNSAID'),self::$FOLLOW_UNSAID_in_notExistsFunc569); 

                    }
                    break;
                case 2 :
                    // Sparql11update.g:159:7: NOT EXISTS 
                    {
                    $this->match($this->input,$this->getToken('NOT'),self::$FOLLOW_NOT_in_notExistsFunc577); 
                    $this->match($this->input,$this->getToken('EXISTS'),self::$FOLLOW_EXISTS_in_notExistsFunc579); 

                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_groupGraphPattern_in_notExistsFunc587);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->groupGraphPattern();

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
    // $ANTLR end "notExistsFunc"


    // $ANTLR start "aggregate"
    // Sparql11update.g:166:1: aggregate : ( COUNT OPEN_BRACE ( ASTERISK | variable | DISTINCT ( ASTERISK | variable ) ) CLOSE_BRACE | SUM OPEN_BRACE expression CLOSE_BRACE | MIN OPEN_BRACE expression CLOSE_BRACE | MAX OPEN_BRACE expression CLOSE_BRACE | AVG OPEN_BRACE expression CLOSE_BRACE ); 
    public function aggregate(){
        try {
            // Sparql11update.g:167:3: ( COUNT OPEN_BRACE ( ASTERISK | variable | DISTINCT ( ASTERISK | variable ) ) CLOSE_BRACE | SUM OPEN_BRACE expression CLOSE_BRACE | MIN OPEN_BRACE expression CLOSE_BRACE | MAX OPEN_BRACE expression CLOSE_BRACE | AVG OPEN_BRACE expression CLOSE_BRACE ) 
            $alt33=5;
            $LA33 = $this->input->LA(1);
            if($this->getToken('COUNT')== $LA33)
                {
                $alt33=1;
                }
            else if($this->getToken('SUM')== $LA33)
                {
                $alt33=2;
                }
            else if($this->getToken('MIN')== $LA33)
                {
                $alt33=3;
                }
            else if($this->getToken('MAX')== $LA33)
                {
                $alt33=4;
                }
            else if($this->getToken('AVG')== $LA33)
                {
                $alt33=5;
                }
            else{
                $nvae =
                    new NoViableAltException("", 33, 0, $this->input);

                throw $nvae;
            }

            switch ($alt33) {
                case 1 :
                    // Sparql11update.g:168:3: COUNT OPEN_BRACE ( ASTERISK | variable | DISTINCT ( ASTERISK | variable ) ) CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('COUNT'),self::$FOLLOW_COUNT_in_aggregate605); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_aggregate607); 
                    // Sparql11update.g:169:3: ( ASTERISK | variable | DISTINCT ( ASTERISK | variable ) ) 
                    $alt32=3;
                    $LA32 = $this->input->LA(1);
                    if($this->getToken('ASTERISK')== $LA32)
                        {
                        $alt32=1;
                        }
                    else if($this->getToken('VAR1')== $LA32||$this->getToken('VAR2')== $LA32)
                        {
                        $alt32=2;
                        }
                    else if($this->getToken('DISTINCT')== $LA32)
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
                            // Sparql11update.g:170:5: ASTERISK 
                            {
                            $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_aggregate617); 

                            }
                            break;
                        case 2 :
                            // Sparql11update.g:171:7: variable 
                            {
                            $this->pushFollow(self::$FOLLOW_variable_in_aggregate625);
                            $this->gErfurt_Sparql_Parser_Sparql11_Update->variable();

                            $this->state->_fsp--;


                            }
                            break;
                        case 3 :
                            // Sparql11update.g:172:7: DISTINCT ( ASTERISK | variable ) 
                            {
                            $this->match($this->input,$this->getToken('DISTINCT'),self::$FOLLOW_DISTINCT_in_aggregate633); 
                            // Sparql11update.g:173:5: ( ASTERISK | variable ) 
                            $alt31=2;
                            $LA31_0 = $this->input->LA(1);

                            if ( ($LA31_0==$this->getToken('ASTERISK')) ) {
                                $alt31=1;
                            }
                            else if ( (($LA31_0>=$this->getToken('VAR1') && $LA31_0<=$this->getToken('VAR2'))) ) {
                                $alt31=2;
                            }
                            else {
                                $nvae = new NoViableAltException("", 31, 0, $this->input);

                                throw $nvae;
                            }
                            switch ($alt31) {
                                case 1 :
                                    // Sparql11update.g:174:7: ASTERISK 
                                    {
                                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_aggregate647); 

                                    }
                                    break;
                                case 2 :
                                    // Sparql11update.g:175:9: variable 
                                    {
                                    $this->pushFollow(self::$FOLLOW_variable_in_aggregate657);
                                    $this->gErfurt_Sparql_Parser_Sparql11_Update->variable();

                                    $this->state->_fsp--;


                                    }
                                    break;

                            }


                            }
                            break;

                    }

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_aggregate671); 

                    }
                    break;
                case 2 :
                    // Sparql11update.g:179:5: SUM OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('SUM'),self::$FOLLOW_SUM_in_aggregate677); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_aggregate679); 
                    $this->pushFollow(self::$FOLLOW_expression_in_aggregate681);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_aggregate683); 

                    }
                    break;
                case 3 :
                    // Sparql11update.g:180:5: MIN OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('MIN'),self::$FOLLOW_MIN_in_aggregate689); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_aggregate691); 
                    $this->pushFollow(self::$FOLLOW_expression_in_aggregate693);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_aggregate695); 

                    }
                    break;
                case 4 :
                    // Sparql11update.g:181:5: MAX OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('MAX'),self::$FOLLOW_MAX_in_aggregate701); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_aggregate703); 
                    $this->pushFollow(self::$FOLLOW_expression_in_aggregate705);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_aggregate707); 

                    }
                    break;
                case 5 :
                    // Sparql11update.g:182:5: AVG OPEN_BRACE expression CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('AVG'),self::$FOLLOW_AVG_in_aggregate713); 
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_aggregate715); 
                    $this->pushFollow(self::$FOLLOW_expression_in_aggregate717);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->expression();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_aggregate719); 

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
    // $ANTLR end "aggregate"


    // $ANTLR start "triplesSameSubjectPath"
    // Sparql11update.g:187:1: triplesSameSubjectPath : ( varOrTerm propertyListNotEmptyPath | triplesNode propertyListPath ); 
    public function triplesSameSubjectPath(){
        try {
            // Sparql11update.g:188:3: ( varOrTerm propertyListNotEmptyPath | triplesNode propertyListPath ) 
            $alt34=2;
            $LA34 = $this->input->LA(1);
            if($this->getToken('TRUE')== $LA34||$this->getToken('FALSE')== $LA34||$this->getToken('IRI_REF')== $LA34||$this->getToken('PNAME_NS')== $LA34||$this->getToken('PNAME_LN')== $LA34||$this->getToken('VAR1')== $LA34||$this->getToken('VAR2')== $LA34||$this->getToken('INTEGER')== $LA34||$this->getToken('DECIMAL')== $LA34||$this->getToken('DOUBLE')== $LA34||$this->getToken('INTEGER_POSITIVE')== $LA34||$this->getToken('DECIMAL_POSITIVE')== $LA34||$this->getToken('DOUBLE_POSITIVE')== $LA34||$this->getToken('INTEGER_NEGATIVE')== $LA34||$this->getToken('DECIMAL_NEGATIVE')== $LA34||$this->getToken('DOUBLE_NEGATIVE')== $LA34||$this->getToken('STRING_LITERAL1')== $LA34||$this->getToken('STRING_LITERAL2')== $LA34||$this->getToken('STRING_LITERAL_LONG1')== $LA34||$this->getToken('STRING_LITERAL_LONG2')== $LA34||$this->getToken('BLANK_NODE_LABEL')== $LA34)
                {
                $alt34=1;
                }
            else if($this->getToken('OPEN_SQUARE_BRACE')== $LA34)
                {
                $LA34_2 = $this->input->LA(2);

                if ( ($LA34_2==$this->getToken('A')||$LA34_2==$this->getToken('IRI_REF')||$LA34_2==$this->getToken('PNAME_NS')||$LA34_2==$this->getToken('PNAME_LN')||($LA34_2>=$this->getToken('VAR1') && $LA34_2<=$this->getToken('VAR2'))) ) {
                    $alt34=2;
                }
                else if ( ($LA34_2==$this->getToken('WS')||$LA34_2==$this->getToken('CLOSE_SQUARE_BRACE')) ) {
                    $alt34=1;
                }
                else {
                    $nvae = new NoViableAltException("", 34, 2, $this->input);

                    throw $nvae;
                }
                }
            else if($this->getToken('OPEN_BRACE')== $LA34)
                {
                $LA34_3 = $this->input->LA(2);

                if ( ($LA34_3==$this->getToken('WS')||$LA34_3==$this->getToken('CLOSE_BRACE')) ) {
                    $alt34=1;
                }
                else if ( (($LA34_3>=$this->getToken('TRUE') && $LA34_3<=$this->getToken('FALSE'))||$LA34_3==$this->getToken('IRI_REF')||$LA34_3==$this->getToken('PNAME_NS')||$LA34_3==$this->getToken('PNAME_LN')||($LA34_3>=$this->getToken('VAR1') && $LA34_3<=$this->getToken('VAR2'))||$LA34_3==$this->getToken('INTEGER')||$LA34_3==$this->getToken('DECIMAL')||$LA34_3==$this->getToken('DOUBLE')||($LA34_3>=$this->getToken('INTEGER_POSITIVE') && $LA34_3<=$this->getToken('DOUBLE_NEGATIVE'))||($LA34_3>=$this->getToken('STRING_LITERAL1') && $LA34_3<=$this->getToken('STRING_LITERAL_LONG2'))||$LA34_3==$this->getToken('BLANK_NODE_LABEL')||$LA34_3==$this->getToken('OPEN_BRACE')||$LA34_3==$this->getToken('OPEN_SQUARE_BRACE')) ) {
                    $alt34=2;
                }
                else {
                    $nvae = new NoViableAltException("", 34, 3, $this->input);

                    throw $nvae;
                }
                }
            else{
                $nvae =
                    new NoViableAltException("", 34, 0, $this->input);

                throw $nvae;
            }

            switch ($alt34) {
                case 1 :
                    // Sparql11update.g:189:3: varOrTerm propertyListNotEmptyPath 
                    {
                    $this->pushFollow(self::$FOLLOW_varOrTerm_in_triplesSameSubjectPath737);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->varOrTerm();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyListNotEmptyPath_in_triplesSameSubjectPath739);
                    $this->propertyListNotEmptyPath();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11update.g:190:5: triplesNode propertyListPath 
                    {
                    $this->pushFollow(self::$FOLLOW_triplesNode_in_triplesSameSubjectPath745);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->triplesNode();

                    $this->state->_fsp--;

                    $this->pushFollow(self::$FOLLOW_propertyListPath_in_triplesSameSubjectPath747);
                    $this->propertyListPath();

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
    // $ANTLR end "triplesSameSubjectPath"


    // $ANTLR start "propertyListNotEmptyPath"
    // Sparql11update.g:195:1: propertyListNotEmptyPath : ( verbPath | verbSimple ) objectList ( SEMICOLON ( ( verbPath | verbSimple ) objectList )? )* ; 
    public function propertyListNotEmptyPath(){
        try {
            // Sparql11update.g:196:3: ( ( verbPath | verbSimple ) objectList ( SEMICOLON ( ( verbPath | verbSimple ) objectList )? )* ) 
            // Sparql11update.g:197:3: ( verbPath | verbSimple ) objectList ( SEMICOLON ( ( verbPath | verbSimple ) objectList )? )* 
            {
            // Sparql11update.g:197:3: ( verbPath | verbSimple ) 
            $alt35=2;
            $LA35_0 = $this->input->LA(1);

            if ( ($LA35_0==$this->getToken('A')||$LA35_0==$this->getToken('IRI_REF')||$LA35_0==$this->getToken('PNAME_NS')||$LA35_0==$this->getToken('PNAME_LN')||$LA35_0==$this->getToken('OPEN_BRACE')||$LA35_0==$this->getToken('HAT_LABEL')) ) {
                $alt35=1;
            }
            else if ( (($LA35_0>=$this->getToken('VAR1') && $LA35_0<=$this->getToken('VAR2'))) ) {
                $alt35=2;
            }
            else {
                $nvae = new NoViableAltException("", 35, 0, $this->input);

                throw $nvae;
            }
            switch ($alt35) {
                case 1 :
                    // Sparql11update.g:198:5: verbPath 
                    {
                    $this->pushFollow(self::$FOLLOW_verbPath_in_propertyListNotEmptyPath771);
                    $this->verbPath();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11update.g:199:7: verbSimple 
                    {
                    $this->pushFollow(self::$FOLLOW_verbSimple_in_propertyListNotEmptyPath779);
                    $this->verbSimple();

                    $this->state->_fsp--;


                    }
                    break;

            }

            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmptyPath787);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->objectList();

            $this->state->_fsp--;

            // Sparql11update.g:202:3: ( SEMICOLON ( ( verbPath | verbSimple ) objectList )? )* 
            //loop38:
            do {
                $alt38=2;
                $LA38_0 = $this->input->LA(1);

                if ( ($LA38_0==$this->getToken('SEMICOLON')) ) {
                    $alt38=1;
                }


                switch ($alt38) {
            	case 1 :
            	    // Sparql11update.g:203:5: SEMICOLON ( ( verbPath | verbSimple ) objectList )? 
            	    {
            	    $this->match($this->input,$this->getToken('SEMICOLON'),self::$FOLLOW_SEMICOLON_in_propertyListNotEmptyPath797); 
            	    // Sparql11update.g:204:5: ( ( verbPath | verbSimple ) objectList )? 
            	    $alt37=2;
            	    $LA37_0 = $this->input->LA(1);

            	    if ( ($LA37_0==$this->getToken('A')||$LA37_0==$this->getToken('IRI_REF')||$LA37_0==$this->getToken('PNAME_NS')||$LA37_0==$this->getToken('PNAME_LN')||($LA37_0>=$this->getToken('VAR1') && $LA37_0<=$this->getToken('VAR2'))||$LA37_0==$this->getToken('OPEN_BRACE')||$LA37_0==$this->getToken('HAT_LABEL')) ) {
            	        $alt37=1;
            	    }
            	    switch ($alt37) {
            	        case 1 :
            	            // Sparql11update.g:205:7: ( verbPath | verbSimple ) objectList 
            	            {
            	            // Sparql11update.g:205:7: ( verbPath | verbSimple ) 
            	            $alt36=2;
            	            $LA36_0 = $this->input->LA(1);

            	            if ( ($LA36_0==$this->getToken('A')||$LA36_0==$this->getToken('IRI_REF')||$LA36_0==$this->getToken('PNAME_NS')||$LA36_0==$this->getToken('PNAME_LN')||$LA36_0==$this->getToken('OPEN_BRACE')||$LA36_0==$this->getToken('HAT_LABEL')) ) {
            	                $alt36=1;
            	            }
            	            else if ( (($LA36_0>=$this->getToken('VAR1') && $LA36_0<=$this->getToken('VAR2'))) ) {
            	                $alt36=2;
            	            }
            	            else {
            	                $nvae = new NoViableAltException("", 36, 0, $this->input);

            	                throw $nvae;
            	            }
            	            switch ($alt36) {
            	                case 1 :
            	                    // Sparql11update.g:206:9: verbPath 
            	                    {
            	                    $this->pushFollow(self::$FOLLOW_verbPath_in_propertyListNotEmptyPath821);
            	                    $this->verbPath();

            	                    $this->state->_fsp--;


            	                    }
            	                    break;
            	                case 2 :
            	                    // Sparql11update.g:207:11: verbSimple 
            	                    {
            	                    $this->pushFollow(self::$FOLLOW_verbSimple_in_propertyListNotEmptyPath833);
            	                    $this->verbSimple();

            	                    $this->state->_fsp--;


            	                    }
            	                    break;

            	            }

            	            $this->pushFollow(self::$FOLLOW_objectList_in_propertyListNotEmptyPath849);
            	            $this->gErfurt_Sparql_Parser_Sparql11_Update->objectList();

            	            $this->state->_fsp--;


            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop38;
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
    // $ANTLR end "propertyListNotEmptyPath"


    // $ANTLR start "propertyListPath"
    // Sparql11update.g:216:1: propertyListPath : ( propertyListNotEmpty )? ; 
    public function propertyListPath(){
        try {
            // Sparql11update.g:217:3: ( ( propertyListNotEmpty )? ) 
            // Sparql11update.g:218:3: ( propertyListNotEmpty )? 
            {
            // Sparql11update.g:218:3: ( propertyListNotEmpty )? 
            $alt39=2;
            $LA39_0 = $this->input->LA(1);

            if ( ($LA39_0==$this->getToken('A')||$LA39_0==$this->getToken('IRI_REF')||$LA39_0==$this->getToken('PNAME_NS')||$LA39_0==$this->getToken('PNAME_LN')||($LA39_0>=$this->getToken('VAR1') && $LA39_0<=$this->getToken('VAR2'))) ) {
                $alt39=1;
            }
            switch ($alt39) {
                case 1 :
                    // Sparql11update.g:218:3: propertyListNotEmpty 
                    {
                    $this->pushFollow(self::$FOLLOW_propertyListNotEmpty_in_propertyListPath879);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->propertyListNotEmpty();

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
    // $ANTLR end "propertyListPath"


    // $ANTLR start "verbPath"
    // Sparql11update.g:223:1: verbPath : path ; 
    public function verbPath(){
        try {
            // Sparql11update.g:224:3: ( path ) 
            // Sparql11update.g:225:3: path 
            {
            $this->pushFollow(self::$FOLLOW_path_in_verbPath898);
            $this->path();

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
    // $ANTLR end "verbPath"


    // $ANTLR start "verbSimple"
    // Sparql11update.g:230:1: verbSimple : variable ; 
    public function verbSimple(){
        try {
            // Sparql11update.g:231:3: ( variable ) 
            // Sparql11update.g:232:3: variable 
            {
            $this->pushFollow(self::$FOLLOW_variable_in_verbSimple916);
            $this->gErfurt_Sparql_Parser_Sparql11_Update->variable();

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
    // $ANTLR end "verbSimple"


    // $ANTLR start "pathUnit"
    // Sparql11update.g:237:1: pathUnit : path ; 
    public function pathUnit(){
        try {
            // Sparql11update.g:238:3: ( path ) 
            // Sparql11update.g:239:3: path 
            {
            $this->pushFollow(self::$FOLLOW_path_in_pathUnit934);
            $this->path();

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
    // $ANTLR end "pathUnit"


    // $ANTLR start "path"
    // Sparql11update.g:244:1: path : pathAlternative ; 
    public function path(){
        try {
            // Sparql11update.g:245:3: ( pathAlternative ) 
            // Sparql11update.g:246:3: pathAlternative 
            {
            $this->pushFollow(self::$FOLLOW_pathAlternative_in_path952);
            $this->pathAlternative();

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
    // $ANTLR end "path"


    // $ANTLR start "pathAlternative"
    // Sparql11update.g:251:1: pathAlternative : pathSequence ; 
    public function pathAlternative(){
        try {
            // Sparql11update.g:252:3: ( pathSequence ) 
            // Sparql11update.g:253:3: pathSequence 
            {
            $this->pushFollow(self::$FOLLOW_pathSequence_in_pathAlternative970);
            $this->pathSequence();

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
    // $ANTLR end "pathAlternative"


    // $ANTLR start "pathSequence"
    // Sparql11update.g:258:1: pathSequence : pathEltOrReverse ( DIVIDE pathEltOrReverse | HAT_LABEL pathElt )* ; 
    public function pathSequence(){
        try {
            // Sparql11update.g:259:3: ( pathEltOrReverse ( DIVIDE pathEltOrReverse | HAT_LABEL pathElt )* ) 
            // Sparql11update.g:260:3: pathEltOrReverse ( DIVIDE pathEltOrReverse | HAT_LABEL pathElt )* 
            {
            $this->pushFollow(self::$FOLLOW_pathEltOrReverse_in_pathSequence988);
            $this->pathEltOrReverse();

            $this->state->_fsp--;

            // Sparql11update.g:261:3: ( DIVIDE pathEltOrReverse | HAT_LABEL pathElt )* 
            //loop40:
            do {
                $alt40=3;
                $LA40_0 = $this->input->LA(1);

                if ( ($LA40_0==$this->getToken('DIVIDE')) ) {
                    $alt40=1;
                }
                else if ( ($LA40_0==$this->getToken('HAT_LABEL')) ) {
                    $alt40=2;
                }


                switch ($alt40) {
            	case 1 :
            	    // Sparql11update.g:262:5: DIVIDE pathEltOrReverse 
            	    {
            	    $this->match($this->input,$this->getToken('DIVIDE'),self::$FOLLOW_DIVIDE_in_pathSequence998); 
            	    $this->pushFollow(self::$FOLLOW_pathEltOrReverse_in_pathSequence1000);
            	    $this->pathEltOrReverse();

            	    $this->state->_fsp--;


            	    }
            	    break;
            	case 2 :
            	    // Sparql11update.g:263:7: HAT_LABEL pathElt 
            	    {
            	    $this->match($this->input,$this->getToken('HAT_LABEL'),self::$FOLLOW_HAT_LABEL_in_pathSequence1008); 
            	    $this->pushFollow(self::$FOLLOW_pathElt_in_pathSequence1010);
            	    $this->pathElt();

            	    $this->state->_fsp--;


            	    }
            	    break;

            	default :
            	    break 2;//loop40;
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
    // $ANTLR end "pathSequence"


    // $ANTLR start "pathElt"
    // Sparql11update.g:269:1: pathElt : pathPrimary ( pathMod )? ; 
    public function pathElt(){
        try {
            // Sparql11update.g:270:3: ( pathPrimary ( pathMod )? ) 
            // Sparql11update.g:271:3: pathPrimary ( pathMod )? 
            {
            $this->pushFollow(self::$FOLLOW_pathPrimary_in_pathElt1033);
            $this->pathPrimary();

            $this->state->_fsp--;

            // Sparql11update.g:271:15: ( pathMod )? 
            $alt41=2;
            $LA41_0 = $this->input->LA(1);

            if ( ($LA41_0==$this->getToken('OPEN_CURLY_BRACE')||$LA41_0==$this->getToken('PLUS')||$LA41_0==$this->getToken('ASTERISK')||$LA41_0==$this->getToken('QUESTION_MARK_LABEL')) ) {
                $alt41=1;
            }
            switch ($alt41) {
                case 1 :
                    // Sparql11update.g:271:15: pathMod 
                    {
                    $this->pushFollow(self::$FOLLOW_pathMod_in_pathElt1035);
                    $this->pathMod();

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
    // $ANTLR end "pathElt"


    // $ANTLR start "pathEltOrReverse"
    // Sparql11update.g:276:1: pathEltOrReverse : ( pathElt | HAT_LABEL pathElt ); 
    public function pathEltOrReverse(){
        try {
            // Sparql11update.g:277:3: ( pathElt | HAT_LABEL pathElt ) 
            $alt42=2;
            $LA42_0 = $this->input->LA(1);

            if ( ($LA42_0==$this->getToken('A')||$LA42_0==$this->getToken('IRI_REF')||$LA42_0==$this->getToken('PNAME_NS')||$LA42_0==$this->getToken('PNAME_LN')||$LA42_0==$this->getToken('OPEN_BRACE')) ) {
                $alt42=1;
            }
            else if ( ($LA42_0==$this->getToken('HAT_LABEL')) ) {
                $alt42=2;
            }
            else {
                $nvae = new NoViableAltException("", 42, 0, $this->input);

                throw $nvae;
            }
            switch ($alt42) {
                case 1 :
                    // Sparql11update.g:278:3: pathElt 
                    {
                    $this->pushFollow(self::$FOLLOW_pathElt_in_pathEltOrReverse1054);
                    $this->pathElt();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11update.g:279:5: HAT_LABEL pathElt 
                    {
                    $this->match($this->input,$this->getToken('HAT_LABEL'),self::$FOLLOW_HAT_LABEL_in_pathEltOrReverse1060); 
                    $this->pushFollow(self::$FOLLOW_pathElt_in_pathEltOrReverse1062);
                    $this->pathElt();

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
    // $ANTLR end "pathEltOrReverse"


    // $ANTLR start "pathMod"
    // Sparql11update.g:284:1: pathMod : ( ASTERISK | QUESTION_MARK_LABEL | PLUS | OPEN_CURLY_BRACE ( INTEGER ( COMMA ( CLOSE_CURLY_BRACE | INTEGER CLOSE_CURLY_BRACE ) | CLOSE_CURLY_BRACE ) ) ); 
    public function pathMod(){
        try {
            // Sparql11update.g:285:3: ( ASTERISK | QUESTION_MARK_LABEL | PLUS | OPEN_CURLY_BRACE ( INTEGER ( COMMA ( CLOSE_CURLY_BRACE | INTEGER CLOSE_CURLY_BRACE ) | CLOSE_CURLY_BRACE ) ) ) 
            $alt45=4;
            $LA45 = $this->input->LA(1);
            if($this->getToken('ASTERISK')== $LA45)
                {
                $alt45=1;
                }
            else if($this->getToken('QUESTION_MARK_LABEL')== $LA45)
                {
                $alt45=2;
                }
            else if($this->getToken('PLUS')== $LA45)
                {
                $alt45=3;
                }
            else if($this->getToken('OPEN_CURLY_BRACE')== $LA45)
                {
                $alt45=4;
                }
            else{
                $nvae =
                    new NoViableAltException("", 45, 0, $this->input);

                throw $nvae;
            }

            switch ($alt45) {
                case 1 :
                    // Sparql11update.g:286:3: ASTERISK 
                    {
                    $this->match($this->input,$this->getToken('ASTERISK'),self::$FOLLOW_ASTERISK_in_pathMod1080); 

                    }
                    break;
                case 2 :
                    // Sparql11update.g:287:5: QUESTION_MARK_LABEL 
                    {
                    $this->match($this->input,$this->getToken('QUESTION_MARK_LABEL'),self::$FOLLOW_QUESTION_MARK_LABEL_in_pathMod1086); 

                    }
                    break;
                case 3 :
                    // Sparql11update.g:288:5: PLUS 
                    {
                    $this->match($this->input,$this->getToken('PLUS'),self::$FOLLOW_PLUS_in_pathMod1092); 

                    }
                    break;
                case 4 :
                    // Sparql11update.g:289:5: OPEN_CURLY_BRACE ( INTEGER ( COMMA ( CLOSE_CURLY_BRACE | INTEGER CLOSE_CURLY_BRACE ) | CLOSE_CURLY_BRACE ) ) 
                    {
                    $this->match($this->input,$this->getToken('OPEN_CURLY_BRACE'),self::$FOLLOW_OPEN_CURLY_BRACE_in_pathMod1098); 
                    // Sparql11update.g:290:3: ( INTEGER ( COMMA ( CLOSE_CURLY_BRACE | INTEGER CLOSE_CURLY_BRACE ) | CLOSE_CURLY_BRACE ) ) 
                    // Sparql11update.g:291:5: INTEGER ( COMMA ( CLOSE_CURLY_BRACE | INTEGER CLOSE_CURLY_BRACE ) | CLOSE_CURLY_BRACE ) 
                    {
                    $this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_pathMod1108); 
                    // Sparql11update.g:292:5: ( COMMA ( CLOSE_CURLY_BRACE | INTEGER CLOSE_CURLY_BRACE ) | CLOSE_CURLY_BRACE ) 
                    $alt44=2;
                    $LA44_0 = $this->input->LA(1);

                    if ( ($LA44_0==$this->getToken('COMMA')) ) {
                        $alt44=1;
                    }
                    else if ( ($LA44_0==$this->getToken('CLOSE_CURLY_BRACE')) ) {
                        $alt44=2;
                    }
                    else {
                        $nvae = new NoViableAltException("", 44, 0, $this->input);

                        throw $nvae;
                    }
                    switch ($alt44) {
                        case 1 :
                            // Sparql11update.g:293:7: COMMA ( CLOSE_CURLY_BRACE | INTEGER CLOSE_CURLY_BRACE ) 
                            {
                            $this->match($this->input,$this->getToken('COMMA'),self::$FOLLOW_COMMA_in_pathMod1122); 
                            // Sparql11update.g:294:7: ( CLOSE_CURLY_BRACE | INTEGER CLOSE_CURLY_BRACE ) 
                            $alt43=2;
                            $LA43_0 = $this->input->LA(1);

                            if ( ($LA43_0==$this->getToken('CLOSE_CURLY_BRACE')) ) {
                                $alt43=1;
                            }
                            else if ( ($LA43_0==$this->getToken('INTEGER')) ) {
                                $alt43=2;
                            }
                            else {
                                $nvae = new NoViableAltException("", 43, 0, $this->input);

                                throw $nvae;
                            }
                            switch ($alt43) {
                                case 1 :
                                    // Sparql11update.g:295:9: CLOSE_CURLY_BRACE 
                                    {
                                    $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1140); 

                                    }
                                    break;
                                case 2 :
                                    // Sparql11update.g:296:11: INTEGER CLOSE_CURLY_BRACE 
                                    {
                                    $this->match($this->input,$this->getToken('INTEGER'),self::$FOLLOW_INTEGER_in_pathMod1152); 
                                    $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1154); 

                                    }
                                    break;

                            }


                            }
                            break;
                        case 2 :
                            // Sparql11update.g:298:9: CLOSE_CURLY_BRACE 
                            {
                            $this->match($this->input,$this->getToken('CLOSE_CURLY_BRACE'),self::$FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1172); 

                            }
                            break;

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
        
        return ;
    }
    // $ANTLR end "pathMod"


    // $ANTLR start "pathPrimary"
    // Sparql11update.g:305:1: pathPrimary : ( iriRef | A | OPEN_BRACE path CLOSE_BRACE ); 
    public function pathPrimary(){
        try {
            // Sparql11update.g:306:3: ( iriRef | A | OPEN_BRACE path CLOSE_BRACE ) 
            $alt46=3;
            $LA46 = $this->input->LA(1);
            if($this->getToken('IRI_REF')== $LA46||$this->getToken('PNAME_NS')== $LA46||$this->getToken('PNAME_LN')== $LA46)
                {
                $alt46=1;
                }
            else if($this->getToken('A')== $LA46)
                {
                $alt46=2;
                }
            else if($this->getToken('OPEN_BRACE')== $LA46)
                {
                $alt46=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 46, 0, $this->input);

                throw $nvae;
            }

            switch ($alt46) {
                case 1 :
                    // Sparql11update.g:307:3: iriRef 
                    {
                    $this->pushFollow(self::$FOLLOW_iriRef_in_pathPrimary1200);
                    $this->gErfurt_Sparql_Parser_Sparql11_Update->iriRef();

                    $this->state->_fsp--;


                    }
                    break;
                case 2 :
                    // Sparql11update.g:308:5: A 
                    {
                    $this->match($this->input,$this->getToken('A'),self::$FOLLOW_A_in_pathPrimary1206); 

                    }
                    break;
                case 3 :
                    // Sparql11update.g:309:5: OPEN_BRACE path CLOSE_BRACE 
                    {
                    $this->match($this->input,$this->getToken('OPEN_BRACE'),self::$FOLLOW_OPEN_BRACE_in_pathPrimary1212); 
                    $this->pushFollow(self::$FOLLOW_path_in_pathPrimary1214);
                    $this->path();

                    $this->state->_fsp--;

                    $this->match($this->input,$this->getToken('CLOSE_BRACE'),self::$FOLLOW_CLOSE_BRACE_in_pathPrimary1216); 

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
    // $ANTLR end "pathPrimary"

    // Delegated rules


    
}

 



Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_prologue_in_updateUnit16 = new Set(array(1, 5, 6, 7, 9, 10, 11, 13));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_update_in_updateUnit26 = new Set(array(1, 5, 6, 7, 9, 10, 11, 13));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_manage_in_updateUnit34 = new Set(array(1, 5, 6, 7, 9, 10, 11, 13));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_modify_in_update54 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_insert_in_update60 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_delete_in_update66 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_load_in_update72 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_clear_in_update78 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_MODIFY_in_modify93 = new Set(array(6, 41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_graphIri_in_modify96 = new Set(array(6, 41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_DELETE_in_modify100 = new Set(array(61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_constructTemplate_in_modify102 = new Set(array(7));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_INSERT_in_modify104 = new Set(array(61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_constructTemplate_in_modify106 = new Set(array(1, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_updatePattern_in_modify108 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_DELETE_in_delete124 = new Set(array(4, 30, 41, 61, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_deleteData_in_delete134 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_deleteTemplate_in_delete142 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_DATA_in_deleteData161 = new Set(array(30, 41, 61, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_FROM_in_deleteData164 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_iriRef_in_deleteData167 = new Set(array(30, 41, 61, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_constructTemplate_in_deleteData171 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_FROM_in_deleteTemplate187 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_iriRef_in_deleteTemplate190 = new Set(array(30, 41, 61, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_constructTemplate_in_deleteTemplate194 = new Set(array(1, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_updatePattern_in_deleteTemplate196 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_INSERT_in_insert212 = new Set(array(4, 8, 41, 61, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_insertData_in_insert222 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_insertTemplate_in_insert230 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_DATA_in_insertData249 = new Set(array(8, 41, 61, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_INTO_in_insertData252 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_iriRef_in_insertData255 = new Set(array(8, 41, 61, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_constructTemplate_in_insertData259 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_INTO_in_insertTemplate275 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_iriRef_in_insertTemplate278 = new Set(array(8, 41, 61, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_constructTemplate_in_insertTemplate282 = new Set(array(1, 32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_updatePattern_in_insertTemplate284 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_GRAPH_in_graphIri300 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_iriRef_in_graphIri303 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_LOAD_in_load318 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_iriRef_in_load320 = new Set(array(1, 8, 41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_INTO_in_load324 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_iriRef_in_load326 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLEAR_in_clear343 = new Set(array(1, 41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_graphIri_in_clear345 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_create_in_manage361 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_drop_in_manage367 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CREATE_in_create382 = new Set(array(12, 41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_SILENT_in_create384 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_graphIri_in_create387 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_DROP_in_drop402 = new Set(array(12, 41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_SILENT_in_drop404 = new Set(array(41, 63, 65, 67));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_graphIri_in_drop407 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_WHERE_in_updatePattern422 = new Set(array(32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_groupGraphPattern_in_updatePattern425 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_triplesBlock_in_groupGraphPatternSub455 = new Set(array(1, 32, 40, 41, 43, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_graphPatternNotTriples_in_groupGraphPatternSub474 = new Set(array(1, 32, 40, 41, 43, 57, 58, 61, 63, 65, 67, 69, 70, 73, 74, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_filter_in_groupGraphPatternSub484 = new Set(array(1, 32, 40, 41, 43, 57, 58, 61, 63, 65, 67, 69, 70, 73, 74, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_DOT_in_groupGraphPatternSub496 = new Set(array(1, 32, 40, 41, 43, 57, 58, 61, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_triplesBlock_in_groupGraphPatternSub499 = new Set(array(1, 32, 40, 41, 43, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_EXISTS_in_existsFunc543 = new Set(array(32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_groupGraphPattern_in_existsFunc545 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_UNSAID_in_notExistsFunc569 = new Set(array(32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_NOT_in_notExistsFunc577 = new Set(array(14));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_EXISTS_in_notExistsFunc579 = new Set(array(32, 61));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_groupGraphPattern_in_notExistsFunc587 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_COUNT_in_aggregate605 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_OPEN_BRACE_in_aggregate607 = new Set(array(25, 69, 70, 102));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_ASTERISK_in_aggregate617 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_variable_in_aggregate625 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_DISTINCT_in_aggregate633 = new Set(array(69, 70, 102));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_ASTERISK_in_aggregate647 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_variable_in_aggregate657 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_BRACE_in_aggregate671 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_SUM_in_aggregate677 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_OPEN_BRACE_in_aggregate679 = new Set(array(41, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_expression_in_aggregate681 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_BRACE_in_aggregate683 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_MIN_in_aggregate689 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_OPEN_BRACE_in_aggregate691 = new Set(array(41, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_expression_in_aggregate693 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_BRACE_in_aggregate695 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_MAX_in_aggregate701 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_OPEN_BRACE_in_aggregate703 = new Set(array(41, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_expression_in_aggregate705 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_BRACE_in_aggregate707 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_AVG_in_aggregate713 = new Set(array(107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_OPEN_BRACE_in_aggregate715 = new Set(array(41, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 63, 65, 67, 69, 70, 71, 73, 75, 78, 79, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 104, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_expression_in_aggregate717 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_BRACE_in_aggregate719 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_varOrTerm_in_triplesSameSubjectPath737 = new Set(array(41, 44, 63, 65, 67, 69, 70, 107, 114));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_propertyListNotEmptyPath_in_triplesSameSubjectPath739 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_triplesNode_in_triplesSameSubjectPath745 = new Set(array(41, 44, 63, 65, 67, 69, 70));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_propertyListPath_in_triplesSameSubjectPath747 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_verbPath_in_propertyListNotEmptyPath771 = new Set(array(41, 57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_verbSimple_in_propertyListNotEmptyPath779 = new Set(array(41, 57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_objectList_in_propertyListNotEmptyPath787 = new Set(array(1, 101));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_SEMICOLON_in_propertyListNotEmptyPath797 = new Set(array(1, 41, 44, 63, 65, 67, 69, 70, 101, 107, 114));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_verbPath_in_propertyListNotEmptyPath821 = new Set(array(41, 57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_verbSimple_in_propertyListNotEmptyPath833 = new Set(array(41, 57, 58, 63, 65, 67, 69, 70, 73, 75, 78, 80, 81, 82, 83, 84, 85, 87, 88, 89, 90, 96, 107, 112));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_objectList_in_propertyListNotEmptyPath849 = new Set(array(1, 101));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_propertyListNotEmpty_in_propertyListPath879 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_path_in_verbPath898 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_variable_in_verbSimple916 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_path_in_pathUnit934 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathAlternative_in_path952 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathSequence_in_pathAlternative970 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathEltOrReverse_in_pathSequence988 = new Set(array(1, 105, 114));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_DIVIDE_in_pathSequence998 = new Set(array(41, 44, 63, 65, 67, 107, 114));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathEltOrReverse_in_pathSequence1000 = new Set(array(1, 105, 114));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_HAT_LABEL_in_pathSequence1008 = new Set(array(41, 44, 63, 65, 67, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathElt_in_pathSequence1010 = new Set(array(1, 105, 114));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathPrimary_in_pathElt1033 = new Set(array(1, 61, 79, 102, 115));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathMod_in_pathElt1035 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathElt_in_pathEltOrReverse1054 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_HAT_LABEL_in_pathEltOrReverse1060 = new Set(array(41, 44, 63, 65, 67, 107));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_pathElt_in_pathEltOrReverse1062 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_ASTERISK_in_pathMod1080 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_QUESTION_MARK_LABEL_in_pathMod1086 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_PLUS_in_pathMod1092 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_OPEN_CURLY_BRACE_in_pathMod1098 = new Set(array(73));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_INTEGER_in_pathMod1108 = new Set(array(62, 103));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_COMMA_in_pathMod1122 = new Set(array(62, 73));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1140 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_INTEGER_in_pathMod1152 = new Set(array(62));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1154 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_CURLY_BRACE_in_pathMod1172 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_iriRef_in_pathPrimary1200 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_A_in_pathPrimary1206 = new Set(array(1));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_OPEN_BRACE_in_pathPrimary1212 = new Set(array(41, 44, 63, 65, 67, 107, 114));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_path_in_pathPrimary1214 = new Set(array(108));
Erfurt_Sparql_Parser_Sparql11_Update_Sparql11update::$FOLLOW_CLOSE_BRACE_in_pathPrimary1216 = new Set(array(1));

?>