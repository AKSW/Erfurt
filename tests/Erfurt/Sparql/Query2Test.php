<?php
/**
 * Erfurt Sparql Query - little test script
 * 
 * @package    query
 * @author     Jonas Brekle <jonas.brekle@gmail.com>
 * @copyright  Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version    $Id$
 */
require_once 'Erfurt/TestCase.php';

class Erfurt_Sparql_Query2Test extends Erfurt_TestCase
{
    protected $query;

    public function setUp(){
        $this->query = new Erfurt_Sparql_Query2();
    }

    /**
     * what should a unconfigured query evaluate to?
     * to a empty string?
     * to a query that matches nothing (FILTER(false))?
     * or to a query that matches all triples (?s ?p ?o)?
     *
     * for now it is:
       SELECT *
       WHERE {
       }
     * this is checked here
     */
    public function testInit(){
        $this->query = new Erfurt_Sparql_Query2();

        $this->assertEquals(
            preg_replace("/\s\s/", " ", (string) $this->query),
            "SELECT * WHERE { } ");
    }

    /**
     * copy&pasted from the old "test"-script
     * no real unit test, just a use lot of classes so errors reveal themselves :)
     */
    public function old1 ()
    {

        try {
            //test graph pattern
            $query = new Erfurt_Sparql_Query2();
            $pattern = new Erfurt_Sparql_Query2_GroupGraphPattern();
            $s = new Erfurt_Sparql_Query2_Var('s');
            $foafPrefix =new Erfurt_Sparql_Query2_Prefix('foaf', new Erfurt_Sparql_Query2_IriRef('http://xmlns.com/foaf/0.1/'));
            $triple1 = new Erfurt_Sparql_Query2_Triple($s, new Erfurt_Sparql_Query2_A(), new Erfurt_Sparql_Query2_IriRef('Person', $foafPrefix));
            $iri1 = new Erfurt_Sparql_Query2_IriRef('http://bob-home.example.com');
            $iri2 = new Erfurt_Sparql_Query2_IriRef('http://bob-work.example.com');
            $iri3 = new Erfurt_Sparql_Query2_IriRef('http://bob-work.example.com/mailaddr_checker_func');
            $query->addPrefix($foafPrefix);
            $query->addFrom('http://3ba.se/conferences/', true); //we can add strings - will be converted internally
            $query->addFrom('http://3ba.se/conferences/'); //doubled
            $query->removeFrom(1); //so remove
            $prefixedUri1 = new Erfurt_Sparql_Query2_IriRef('name', $foafPrefix);
            $prefixedUri2 = new Erfurt_Sparql_Query2_IriRef('website', $foafPrefix);
            $name = new Erfurt_Sparql_Query2_RDFLiteral('bob', 'en');
            $bnode = new Erfurt_Sparql_Query2_BlankNode('bn');
            $collecion = new Erfurt_Sparql_Query2_Collection(array($s, $bnode));

            $propList = new Erfurt_Sparql_Query2_PropertyList(
                    array(
                        array(
                            'verb'=>$prefixedUri1,
                            'objList'=>
                                new Erfurt_Sparql_Query2_ObjectList(
                                    array($name)
                                )
                        ),
                        array(
                            'verb'=>$prefixedUri2,
                            'objList'=>
                                new Erfurt_Sparql_Query2_ObjectList(
                                    array(
                                        $iri1,
                                        $iri2
                                    )
                                )
                        )
                    )
                );
            $bnPropList = new Erfurt_Sparql_Query2_BlankNodePropertyList($propList);
            $triplesamesubj = new Erfurt_Sparql_Query2_TriplesSameSubject(
                $collecion,
                $propList
            );
            $optional_pattern = new Erfurt_Sparql_Query2_OptionalGraphPattern();
            $optional_pattern2 = new Erfurt_Sparql_Query2_OptionalGraphPattern();
            $mbox =  new Erfurt_Sparql_Query2_Var('mbox');
            $mbox2 =  new Erfurt_Sparql_Query2_Var('mbox');
            $triple2 = new Erfurt_Sparql_Query2_Triple($s, new Erfurt_Sparql_Query2_IriRef('mbox', $foafPrefix),$mbox);

            //test filter
            $or = new Erfurt_Sparql_Query2_ConditionalOrExpression();
            $one1= new Erfurt_Sparql_Query2_NumericLiteral(1);
            $one2 = new Erfurt_Sparql_Query2_RDFLiteral('1', 'int');

            $st = new Erfurt_Sparql_Query2_sameTerm($one1, $one2);
            $additiv = new Erfurt_Sparql_Query2_AdditiveExpression();
            $additiv -> setElements(
                array(
                    array(
                        "op" => Erfurt_Sparql_Query2_AdditiveExpression::invOperator,
                        "exp" => $one1
                    ),
                    array(
                        "op" => Erfurt_Sparql_Query2_AdditiveExpression::operator,
                        "exp" => $one2)
                )
            );

            $nst = new Erfurt_Sparql_Query2_UnaryExpressionNot($st);
            $and = new Erfurt_Sparql_Query2_ConditionalAndExpression();
            $regex = new Erfurt_Sparql_Query2_Regex(new Erfurt_Sparql_Query2_Str($mbox), new Erfurt_Sparql_Query2_RDFLiteral('/home/'),new Erfurt_Sparql_Query2_RDFLiteral('i'));
            $filter = new Erfurt_Sparql_Query2_Filter($or);

            //build structure
            $query->setWhere(
                    $pattern
                    ->addElement($triple1)
                    ->addElement($triplesamesubj)
                    ->addElement($triplesamesubj) //duplicate
                    ->addElement(
                            $optional_pattern
                                    ->addElement($triple2)
                    )
                    ->addElement($filter
                            ->setConstraint($or
                                    ->addElement( $and
                                            ->addElement($nst)
                                            ->addElement($additiv)
                                            ->addElement(new Erfurt_Sparql_Query2_isLiteral($mbox))
                                            ->addElement(new Erfurt_Sparql_Query2_Function($iri3,array($mbox)))
                                    )
                                    ->addElement($regex)
                            )
                    )
            );
            $query->optimize();
            $nst->remove($query);
            // or
            // $and->removeElement($nst->getID());
            // but the 2nd command removes only occurences of $nst in add, while $nst->remove() removes all ocurrences

            //modify query
            $query->addProjectionVar($mbox);
            $query->setCountStar(true);

            //$query->setReduced(true);
            $query->setDistinct(true);

            $query->setLimit(50);
            $query->setOffset(30);
            $idx = $query->getOrder()->add($mbox);
            //$query->getOrder()->toggleDirection($idx);

            //test different types
            //$query->setQueryType(Erfurt_Sparql_Query2::typeConstruct);
            //$query->getWhere()->removeAllElements();
            //$query->getConstructTemplate()->addElement(new Erfurt_Sparql_Query2_Triple($s, $prefixedUri1, $name));

            //echo $query->getSparql();
            
            $usagebefore = memory_get_usage();
            //$query2 = new Erfurt_Sparql_Query2();
            //for($i=0;$i<1000; $i++){
            //    ${"x".$i} = "new";
            //}
            $x = "new";
            $usageafter = memory_get_usage();
            echo "used " . ($usageafter - $usagebefore) . " bytes for 1 new var";
        } catch(Exception $e){
            throw $e;
            $this->assertTrue(false);
        }
    }
    

    public function testOld2 ()
    {function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
    //require_once '../../../dBug.php';
        try {
            $timesum = (float) 0;
            $memorysum = (float) 0;
            for($i=0;$i<1; $i++){
                $usagebefore = memory_get_usage(true);
                $timebefore = microtime_float();

                //test graph pattern
                $query = new Erfurt_Sparql_Query2();
                $iri3 = new Erfurt_Sparql_Query2_IriRef('http://example.com/');
                $exPrefix =new Erfurt_Sparql_Query2_Prefix('abc',$iri3);
                $prefixedUri1 = new Erfurt_Sparql_Query2_IriRef('xyz', $exPrefix);
                $var =  new Erfurt_Sparql_Query2_Var('var');
                $triple = new Erfurt_Sparql_Query2_Triple($var, new Erfurt_Sparql_Query2_Var("p"), new Erfurt_Sparql_Query2_Var("o"));

                // Query building
                $query->setBase(new Erfurt_Sparql_Query2_IriRef('http://base.com'));
                $query->addPrefix($exPrefix);
                $query->addFrom($prefixedUri1);
                $query->addProjectionVar($var);
                $query->setLimit(10);
                $query->setOffset(20);
                $query->getOrder()->add($var);
                $query->addElement($triple);

                $timeafter = microtime_float();
                $timediff = $timeafter - $timebefore;
                $usageafter = memory_get_usage(true);
                $usagediff = $usageafter - $usagebefore;
                
                $memorysum += $usagediff;
                $timesum += $timediff;
                //echo "used " . ($usageafter - $usagebefore) . " bytes and " . $timediff . " sec.";
                //echo $usagediff."\n";
                //echo "<pre>"; var_dump($query); echo "</pre>";
            }
            //echo "$i used avg ".($memorysum/$i) . " bytes and avg " .(number_format($timesum/$i, 9))." seconds";
        } catch(Exception $e){
            throw $e;
            $this->assertTrue(false);
        }
    }

    public function testProjectionVars(){
        $var = new Erfurt_Sparql_Query2_Var('s');
        $this->assertFalse($this->query->hasProjectionVars());
        $this->query->addProjectionVar($var);
        $this->assertTrue($this->query->hasProjectionVars());
        $this->assertContains($var, $this->query->getProjectionVars());
        $vars = $this->query->getProjectionVars();
        $this->assertTrue( count($vars) == 1 );
        $this->assertEquals('s', $vars[0]->getName());

        $this->query->removeProjectionVar($var);
        $vars = $this->query->getProjectionVars();
        $this->assertTrue(empty($vars));

        $this->query->addProjectionVar($var);
        $this->query->removeAllProjectionVars();
        $vars = $this->query->getProjectionVars();
        $this->assertTrue(empty($vars));
    }

    public function testFroms(){
        $from = new Erfurt_Sparql_Query2_GraphClause("http://test.com");
        $this->query->addFrom($from);
        $this->assertTrue($this->query->hasFroms());
        $this->assertContains($from, $this->query->getFroms());

        $froms = $this->query->getFroms();
        $this->assertTrue( count($froms) == 1 );
        $this->assertEquals($from, $froms[0]);

        $this->query->removeFroms();
        $froms = $this->query->getFroms();
        $this->assertTrue(empty($froms));

        $this->query->addFrom($from);
        $this->query->removeFrom(0);
        $froms = $this->query->getFroms();
        $this->assertTrue(empty($froms));
    }

    public function testPrefixes(){
        $prefix = new Erfurt_Sparql_Query2_Prefix("pre", "http://test.com");
        $this->query->addPrefix($prefix);
        $this->assertTrue($this->query->hasPrefix());
        $this->assertContains($prefix, $this->query->getPrefixes());

        $prefixes = $this->query->getPrefixes();
        $this->assertTrue( count($prefixes) == 1 );
        $this->assertEquals($prefix, $prefixes[0]);

        $this->query->removePrefixes();
        $prefixes = $this->query->getPrefixes();
        $this->assertTrue(empty($prefixes));

        $this->query->addPrefix($prefix);
        $this->query->removePrefix(0);
        $prefixes = $this->query->getPrefixes();
        $this->assertTrue(empty($prefixes));
    }

    public function testBase(){
        $base = new Erfurt_Sparql_Query2_IriRef("http://example.com");
        $this->query->setBase($base);
        $this->assertEquals($base, $this->query->getBase());
        $this->assertTrue($this->query->hasBase());
        $this->query->removeBase();
        $this->assertFalse($this->query->hasBase());
    }

    public function testDistinctReduced(){
        $this->assertFalse($this->query->isReduced());
        $this->assertFalse($this->query->isDistinct());

        $this->query->setDistinct(false);
        $this->assertFalse($this->query->isDistinct());

        $this->query->setReduced(false);
        $this->assertFalse($this->query->isReduced());

        $this->query->setDistinct();
        $this->assertTrue($this->query->isDistinct());
        $this->assertFalse($this->query->isReduced());
        
        $this->query->setReduced();
        $this->assertTrue($this->query->isReduced());
        $this->assertFalse($this->query->isDistinct());
    }
}
?>
