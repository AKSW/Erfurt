<?php

class Erfurt_Sparql_Query2_TripleTest  extends Erfurt_TestCase
{
    public function testInstanceCreationInvalidTriple()
    {
        $iri = new Erfurt_Sparql_Query2_IriRef("http://example.com");
        $var = new Erfurt_Sparql_Query2_Var("x");
        $literal = new Erfurt_Sparql_Query2_RDFLiteral("abc");
        
        $triple = null;
        try {
            $triple = new Erfurt_Sparql_Query2_Triple($var, $literal, $iri);
            
            $this->fail('Triple creation with literal in predicate position should fail.');
        } catch (Exception $e) {
            $this->assertNull($triple);
        }
        
    }
    
    public function testInstanceCreationValidTriples()
    {
        $iri = new Erfurt_Sparql_Query2_IriRef("http://example.com");
        $var = new Erfurt_Sparql_Query2_Var("x");
        $literal = new Erfurt_Sparql_Query2_RDFLiteral("abc");
        
        $triple1 = new Erfurt_Sparql_Query2_Triple($var, $iri, $literal);
        $this->assertInstanceOf('Erfurt_Sparql_Query2_Triple', $triple1);
        
        $triple2 = new Erfurt_Sparql_Query2_Triple($iri, $var, $literal);
        $this->assertInstanceOf('Erfurt_Sparql_Query2_Triple', $triple2);
        
// TODO: @jbrekle Why are literal subjects OK?
        $triple3 = new Erfurt_Sparql_Query2_Triple($literal, $var, $iri); //literal subject is ok :)
        $this->assertInstanceOf('Erfurt_Sparql_Query2_Triple', $triple3);
        
        $triple4 = new Erfurt_Sparql_Query2_Triple($literal, $iri, $var); //literal subject is ok :)
        $this->assertInstanceOf('Erfurt_Sparql_Query2_Triple', $triple4);
    }
}
