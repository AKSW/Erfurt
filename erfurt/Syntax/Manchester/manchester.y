%name OWL_To_Erfurt_
%declare_class {class OWLParser}
%include {require_once '../../erfurt.php';
require_once 'lex.php';
//require_once './SyntaxConstants.php';
}
%include_class{
    	private $lex;
	    function __construct()
	    {
		}
		function parseString($stringToParse){
			$this->lex = new ManchesterLexer($stringToParse);
			while ($this->lex->yylex()) {
			//var_dump('advance: token=' . $this->lex->token ." value=". $this->lex->value);
				self::doParse($this->lex->token, $this->lex->value);
			}
			self::doParse(0,0);
		}
	}

//%left NOT_OPERATOR.
%left NOT_OPERATOR LPAREN RPAREN AND_OPERATOR OR_OPERATOR.
%left MIN_OPERATOR MAX_OPERATOR EXACTLY_OPERATOR HAS_OPERATOR.
%left ONLYSOME_OPERATOR ONLY_OPERATOR SOME_OPERATOR.

%syntax_error {
    echo "Syntax Error in token '" . 
        $this->lex->value."'\n";
    foreach ($this->yystack as $entry) {
        echo $this->tokenName($entry->major) . ' ';
    }
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
	echo ('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN
        . '), expected one of: ' . implode(',', $expect) . "\n");
}
	start ::= expr(A).{print_r(A);}
	expr(A)::= LPAREN expr(B) RPAREN.{A=B;}
	expr(A)::= LBRACE enum(B) RBRACE.{echo A; A= "{".B."}"; }
	expr(A)::= expr(B) ONLYSOME_OPERATOR LSQUAREBRACKET list(C) RSQUAREBRACKET.{echo A; A= B. " onlysome [".C."]"; }
	expr(A)::= expr(B) SOME_OPERATOR LSQUAREBRACKET list(C) RSQUAREBRACKET.{/*not finished!!!*/A= $X; foreach(C as $value){$X=new Erfurt_Owl_Structured_SomeValuesFrom(null, B, $value);}}
    expr(A)::= expr(B) AND_OPERATOR  expr(C).   {A = new Erfurt_Owl_Structured_IntersectionClass(B."_".C);
														A->addChildClass(B);
														A->addChildClass(C);}
    expr(A) ::= expr(B) OR_OPERATOR  expr(C).   {A = new Erfurt_Owl_Structured_UnionClass(B."_".C);
													A->addChildClass(B);
													A->addChildClass(C);}
    expr(A) ::= expr(B) SOME_OPERATOR  expr(C).   { A = new Erfurt_Owl_Structured_SomeValuesFrom(null,B,C);}
	expr(A) ::= NOT_OPERATOR  expr(B).   {A = new Erfurt_Owl_Structured_ComplementClass(B);}
    expr(A) ::= expr(B) ONLY_OPERATOR  expr(C).   {A = new Erfurt_Owl_Structured_AllValuesFrom(null,B,C); }
	expr(A) ::= expr(B) MIN_OPERATOR NUMERIC(C).   { A = new Erfurt_Owl_Structured_MinCardinality(null, B, C);}
    expr(A) ::= expr(B) MAX_OPERATOR NUMERIC(C).   { A = new Erfurt_Owl_Structured_MaxCardinality(null, B, C);}
    expr(A) ::= expr(B) EXACTLY_OPERATOR  NUMERIC(C).   {A = new Erfurt_Owl_Structured_Cardinality(null, B, C);}
    expr(A) ::= expr(B) HAS_OPERATOR  expr(C).   { A = new Erfurt_Owl_Structured_HasValue(null, B, C); }
	expr(A) ::= ALPHANUMERIC(B). { A = B; B=new Erfurt_Owl_Structured_NamedClass(B);}
	enum(A) ::= ALPHANUMERIC(B) enum(C).{ echo A; A=B . " ".C;}
	enum(A) ::= ALPHANUMERIC(B).{A=B;}
	list(A) ::= ALPHANUMERIC(B) COMMA list(C).{ echo A; A=B . " , ".C;}
	list(A) ::= ALPHANUMERIC(B). {A=array(B);}
