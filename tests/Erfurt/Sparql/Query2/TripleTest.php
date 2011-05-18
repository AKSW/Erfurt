<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Sparql/Query2/structural-Interfaces.php';
require_once 'Erfurt/Sparql/Query2/Constraint.php';
class Erfurt_Sparql_Query2_TripleTest  extends Erfurt_TestCase{
    protected $triple;

    public function setUp(){

    }

    public function testInterfaces(){
        $iri = new Erfurt_Sparql_Query2_IriRef("http://example.com");
        $var = new Erfurt_Sparql_Query2_Var("x");
        $literal = new Erfurt_Sparql_Query2_RDFLiteral("abc");

        //some negative tests first
        try{
            //literal as predicate
            $this->triple = new Erfurt_Sparql_Query2_Triple($var, $literal, $iri);

            //this should not be reached
            $this->fail();
        } catch (Exception $e){
            //good
        }

        //positive tests
         try{
            $this->triple = new Erfurt_Sparql_Query2_Triple($var, $iri, $literal);
        } catch (Exception $e){
            $this->fail();
        }
        try{
            $this->triple = new Erfurt_Sparql_Query2_Triple($iri, $var, $literal);
        } catch (Exception $e){
            $this->fail();
        }
        try{
            $this->triple = new Erfurt_Sparql_Query2_Triple($literal, $var, $iri); //literal subject is ok :)
        } catch (Exception $e){
            $this->fail();
        }
        try{
            $this->triple = new Erfurt_Sparql_Query2_Triple($literal, $iri, $var); //literal subject is ok :)
        } catch (Exception $e){
            $this->fail();
        }
    }
}
?>
