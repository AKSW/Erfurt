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
	start ::= classExpr(A).{print_r(A/*->toManchesterSyntaxString()*/);}
	classExpr(A)::= LPAREN classExpr(B) RPAREN.{A=B;}
	classExpr(A)::= LBRACE enum(B) RBRACE.{echo A; A= "{".B."}"; }
	classExpr(A)::= classExpr(B) ONLYSOME_OPERATOR LSQUAREBRACKET list(C) RSQUAREBRACKET.{echo A; A= B. " onlysome [".C."]"; }
	classExpr(A)::= propExpr(B) SOME_OPERATOR LSQUAREBRACKET list(C) RSQUAREBRACKET.{/*not finished!!!*/A= $X; foreach(C as $value){$X=new Erfurt_Owl_Structured_SomeValuesFrom(null, B, $value);}}
    classExpr(A)::= classExpr(B) AND_OPERATOR  classExpr(C).   {A = new Erfurt_Owl_Structured_IntersectionClass(B." and ".C);
														A->addChildClass(B);
														A->addChildClass(C);}
    classExpr(A) ::= classExpr(B) OR_OPERATOR  classExpr(C).   {A = new Erfurt_Owl_Structured_UnionClass(B." or ".C);
													A->addChildClass(B);
													A->addChildClass(C);}
    classExpr(A) ::= propExpr(B) SOME_OPERATOR  classExpr(C).   { A = new Erfurt_Owl_Structured_SomeValuesFrom(B . " some " . C,B,C);}
	classExpr(A) ::= NOT_OPERATOR  classExpr(B).   {A = new Erfurt_Owl_Structured_ComplementClass(B);}
    classExpr(A) ::= propExpr(B) ONLY_OPERATOR  classExpr(C).   {A = new Erfurt_Owl_Structured_AllValuesFrom(B." only ".C,B,C); }
	classExpr(A) ::= propExpr(B) MIN_OPERATOR NUMERIC(C).   { A = new Erfurt_Owl_Structured_MinCardinality(B." min ".C, B, C);}
    classExpr(A) ::= propExpr(B) MAX_OPERATOR NUMERIC(C).   { A = new Erfurt_Owl_Structured_MaxCardinality(B." max ".C, B, C);}
    classExpr(A) ::= propExpr(B) EXACTLY_OPERATOR  NUMERIC(C).   {A = new Erfurt_Owl_Structured_Cardinality(B." exactly ".C, B, C);}
    classExpr(A) ::= propExpr(B) HAS_OPERATOR  ALPHANUMERIC(C).   { A = new Erfurt_Owl_Structured_HasValue(B." has ".C, B, C); }
	classExpr(A) ::= ALPHANUMERIC(B). { A =new Erfurt_Owl_Structured_NamedClass(B);}
	propExpr(A) ::= ALPHANUMERIC(B). { A = B;}
	
	enum(A) ::= ALPHANUMERIC(B) enum(C).{ echo A; A=B . " ".C;}
	enum(A) ::= ALPHANUMERIC(B).{A=B;}
	list(A) ::= ALPHANUMERIC(B) COMMA list(C).{ A= array_merge(array(B),array(C));}
	list(A) ::= ALPHANUMERIC(B). {A=new Erfurt_Owl_Structured_NamedClass(B);}
