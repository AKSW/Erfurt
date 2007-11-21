%name OWL_To_Erfurt_
%declare_class {class OWLParser}
%include {require_once '../../erfurt.php';
require_once 'Lexer.php';}
%include_class{
    	private $lex;
	    function __construct()
	    {
		}
		function parseString($stringToParse){
			$this->lex = new ManchesterLexer($stringToParse);
			while ($this->lex->yylex()) {
				self::doParse($this->lex->token, $this->lex->value);
			}
			self::doParse(0,0);
		}
	}

%left NOT_OPERATOR AND_OPERATOR OR_OPERATOR.
%left MIN_OPERATOR MAX_OPERATOR.
%left EXACTLY_OPERATOR HAS_OPERATOR.
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
    exit(1);
}

	start ::= classExpr(A).{
		print_r(A->generateRDF()->writeAsHtmlTable());}
//		print_r(A->generateRDF()->writeAsHtml());}
//		print_r(A->toManchesterSyntaxString());}
		
	classExpr(A)::= LPAREN classExpr(B) RPAREN.{
		A=B;}
	
	classExpr(A)::= LBRACE enum(B) RBRACE.{
		A= new Erfurt_Owl_Structured_EnumeratedClass(B);}
	
	classExpr(A)::= propExpr(B) ONLYSOME_OPERATOR LSQUAREBRACKET list(C) RSQUAREBRACKET.{
		A = new Erfurt_Owl_Structured_IntersectionClass(B ." onlysome ". C);
		foreach (C as $value) {
			A->addChildClass(new Erfurt_Owl_Structured_SomeValuesFrom(B . " some " . C,B,$value));}
		$x=new Erfurt_Owl_Structured_UnionClass("".C);
		$x->addChildClass(C);
		A->addChildClass(new Erfurt_Owl_Structured_AllValuesFrom(B." only ".C,B,$x));}
		
	classExpr(A)::= propExpr(B) SOME_OPERATOR LSQUAREBRACKET list(C) RSQUAREBRACKET.{
		A=new Erfurt_Owl_Structured_SomeValuesFrom(B." some ".C,B,C);
		}
		
	classExpr(A)::= propExpr(B) ONLY_OPERATOR LSQUAREBRACKET list(C) RSQUAREBRACKET.{
		A=new Erfurt_Owl_Structured_AllValuesFrom(B." some ".C,B,C);
		}

    classExpr(A) ::= classExpr(B) AND_OPERATOR classExpr(C).{
		A = new Erfurt_Owl_Structured_IntersectionClass(B->getURI()." and ".C->getURI());
		if(B instanceof Erfurt_Owl_Structured_IntersectionClass){
			A->addChildClass(B->getChildClasses());
		}else{
			A->addChildClass(B);
		}
		if(C instanceof Erfurt_Owl_Structured_IntersectionClass){
			A->addChildClass(C->getChildClasses());
		}else{
			A->addChildClass(C);
		}
		}

   	classExpr(A) ::= classExpr(B) OR_OPERATOR  classExpr(C).{
		A = new Erfurt_Owl_Structured_UnionClass(B->getURI()." or ".C->getURI());
		if(B instanceof Erfurt_Owl_Structured_UnionClass){
			A->addChildClass(B->getChildClasses());
		}else{
			A->addChildClass(B);
		}
		if(C instanceof Erfurt_Owl_Structured_UnionClass){
			A->addChildClass(C->getChildClasses());
		}else{
			A->addChildClass(C);
		}
		}
		
    classExpr(A) ::= propExpr(B) SOME_OPERATOR  classExpr(C).{ 
		A = new Erfurt_Owl_Structured_SomeValuesFrom(B . " some " . C->getURI(),B,C);}
		
	classExpr(A) ::= NOT_OPERATOR  classExpr(B).{
		A = new Erfurt_Owl_Structured_ComplementClass(B);}
		
    classExpr(A) ::= propExpr(B) ONLY_OPERATOR  instExpr(C).{
		A = new Erfurt_Owl_Structured_AllValuesFrom(B." only ".C,B,C);}
		
	classExpr(A) ::= propExpr(B) MIN_OPERATOR NUMERIC(C).{
		A = new Erfurt_Owl_Structured_MinCardinality(B." min ".C, B, C);}
		
    classExpr(A) ::= propExpr(B) MAX_OPERATOR NUMERIC(C).{
		A = new Erfurt_Owl_Structured_MaxCardinality(B." max ".C, B, C);}
	
    classExpr(A) ::= propExpr(B) EXACTLY_OPERATOR  NUMERIC(C).{
		A = new Erfurt_Owl_Structured_Cardinality(B." exactly ".C, B, C);}
		
    classExpr(A) ::= propExpr(B) HAS_OPERATOR  instExpr(C).{
		A = new Erfurt_Owl_Structured_HasValue(B." has ".C, B, C); }

	classExpr(A) ::= ALPHANUMERIC(B).{
		A =new Erfurt_Owl_Structured_NamedClass(B);}
		
	propExpr(A) ::= ALPHANUMERIC(B).{
		A = B;}
	
	enum(A) ::= instExpr(B) enum(C).{
		A=array_merge(array(B),C);}
		
	enum(A) ::= instExpr(B).{
		A=array(B);}
		
	instExpr(A) ::= ALPHANUMERIC(B).{
		A = new Erfurt_Owl_Structured_Instance(B);}

	list(A) ::= classExpr(B) COMMA list(C).{
		A= array_merge(array(B),C);}
		
	list(A) ::= classExpr(B).{
		A=array(B);}
