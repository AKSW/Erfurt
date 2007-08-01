%name OWL_To_Erfurt_
%declare_class {class OWLParser}
%include {require_once '/Users/roll/Sites/ontowiki/lib/Erfurt/erfurt.php';}
%include_class{
    	private $lex;
	    function __construct($lexer='lex.php')
	    {
	        $this->lex = $lexer;
			self::doParse(12,0);
			//self::doParse(1,0);
			self::doParse(2,"xxx");
			self::doParse(13,0);
			//self::doParse(11,0);
			//self::doParse(2,"yyy");
	
//			self::doParse('(',0);
			/*
			self::doParse(2,"xxx");
			self::doParse(9,0);
			self::doParse(16,0);
			self::doParse(2,"one");
			self::doParse(18,0);
			self::doParse(2,"two");
			self::doParse(18,0);
			self::doParse(2,"three");
			self::doParse(17,0);

			self::doParse(3,0);


			self::doParse(1,0);
			self::doParse(12,0);
			self::doParse(2,"one");
			self::doParse(3,0);
			self::doParse(2,"two");
			self::doParse(4,0);
			self::doParse(2,"three");
			self::doParse(13,0);

			self::doParse(4,0);

			self::doParse(14,0);
			self::doParse(2,"one");
			self::doParse(2,"two");
			self::doParse(2,"three");
			self::doParse(15,0);
*/
			self::doParse(0,0);
			
		}
	}

%left NOT_OPERATOR.
%left ALPHANUMERIC AND_OPERATOR OR_OPERATOR.
%left MIN_OPERATOR MAX_OPERATOR EXACTLY_OPERATOR HAS_OPERATOR.
%left ONLYSOME_OPERATOR ONLY_OPERATOR SOME_OPERATOR.

%syntax_error {
    echo "Syntax Error on line " . $this->lex->line . ": token '" . 
        $this->lex->value . "' while parsing rule:";
    foreach ($this->yystack as $entry) {
        echo $this->tokenName($entry->major) . ' ';
    }
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN
        . '), expected one of: ' . implode(',', $expect));
}
    start ::= expr(A).   { echo  A ; }
	expr(A)::= LPAREN expr(B) RPAREN.{echo B; }
	expr(A)::= LBRACE list(B) RBRACE.{echo A; A= "{".B."}"; }
	expr(A)::= expr(B) ONLYSOME_OPERATOR LSQUAREBRACKET enum(C) RSQUAREBRACKET.{echo A; A= B. " onlysome [".C."]"; }
    expr(A) ::= expr(B) AND_OPERATOR  expr(C).   { return A;
														A = new Erfurt_Owl_IntersectionClass(null);
	 													B = new Erfurt_Owl_IntersectionClass(null);
														C = new Erfurt_Owl_IntersectionClass(null);
														A->addStructuredClass(B);
														A->addStructuredClass(C);}
    expr(A) ::= expr(B) OR_OPERATOR  expr(C).   {A = B ." or ". C; }
    expr(A) ::= expr(B) SOME_OPERATOR  expr(C).   { A = new Erfurt_Owl_Structured_QuantifierRestriction(null,B,C);}
    expr(A) ::= NOT_OPERATOR  expr(B).   { echo A; A=" not " . B;}
    expr(A) ::= expr(B) ONLY_OPERATOR  expr(C).   { echo A; A = new Erfurt_Owl_Structured_AllValuesFrom(null,B,C); }
    expr(A) ::= expr(B) ONLYSOME_OPERATOR  expr(C).   { echo A; A = B ." onlysome ". C; }
    expr(A) ::= expr(B) MIN_OPERATOR  ALPHANUMERIC(C).   { echo A; A = B ." min ". C; }
    expr(A) ::= expr(B) MAX_OPERATOR  ALPHANUMERIC(C).   { echo A; A = B ." max ". C; }
    expr(A) ::= expr(B) EXACTLY_OPERATOR  expr(C).   { echo A; A = B ." exactly ". C; }
    expr(A) ::= expr(B) HAS_OPERATOR  expr(C).   { echo A; A = B ." has ". C; }
	expr(A) ::= ALPHANUMERIC(B). { A = new Erfurt_Owl_Structured_NamedClass(B);}
	list(A) ::= ALPHANUMERIC(B) list(C).{ echo A; A=B . " ".C;}
	list(A) ::= ALPHANUMERIC(B).{A=B;}
	enum(A) ::= ALPHANUMERIC(B) COMMA enum(C).{ echo A; A=B . " , ".C;}
	enum(A) ::= ALPHANUMERIC(B). {A=B;}

	%code{
		$x=new OWLParser();
		// load allowed classes?
		
	}