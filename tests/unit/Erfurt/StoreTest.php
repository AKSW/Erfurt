<?php

use WhiteGecko\Arrays;

class Erfurt_StoreTest extends Erfurt_TestCase
{

    /**
     * Sets up the fixture by creating a StoreSTub
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $config = new Zend_Config(array(
            "cache" => array("frontend" => array("enable" => 0))
        ));
        $this->markTestNeedsTestConfig($config);

        // create singleton app instance and authenticate to make identity available
        $app = Erfurt_App::getInstance(false);
        $app->authenticate();

        // should instantiate Erfurt_Store_Adapter_Test
        $this->_store = new Erfurt_Store(array(), 'Test');
    }

    public function tearDown()
    {
        Erfurt_App::reset();
    }

    public function testExistence()
    {
        $this->assertTrue(class_exists('Erfurt_Store'));
    }

    public function testAddMultipleStatements()
    {
        $model = "http://example.org/";
        $useAC = false;
        $this->_store->getNewModel($model, $model, Erfurt_Store::MODEL_TYPE_OWL, $useAC);

        $resource = array(
            "http://example.org/property" => array(
                array('type' => 'uri', 'value' => 'http://example.org/object'),
                array('type' => 'literal', 'value' => 'text'),
                array('type' => 'literal', 'value' => 'other text'),
            ),
            "http://example.org/otherproperty" => array(
                array('type' => 'uri', 'value' => 'http://example.org/object2'),
                array('type' => 'literal', 'value' => 'text'),
                array('type' => 'literal', 'value' => 'another text'),
            )
        );
        $resourceA = "http://example.org/resourceA";
        $resourceB = "http://example.org/otherresource";

        $this->_store->addMultipleStatements($model, array(
            $resourceA => $resource,
            $resourceB => $resource,
        ), $useAC);
        $statementsA = $this->_store->getResourceDescription($resourceA, $model, array(Erfurt_Store::USE_AC => false));
        $statementsB = $this->_store->getResourceDescription($resourceB, $model, array(Erfurt_Store::USE_AC => false));

        $this->assertCount(1, $statementsA);
        $this->assertCount(1, $statementsB);
        $this->assertArrayHasKey($resourceA, $statementsA);
        $this->assertArrayHasKey($resourceB, $statementsB);
        $this->assertCount(2, $statementsA[$resourceA]);
        $this->assertCount(2, $statementsB[$resourceB]);
        $this->assertEquals($resource, $statementsA[$resourceA]);
        $this->assertEquals($resource, $statementsB[$resourceB]);
        $this->assertCount(3, $statementsA[$resourceA]["http://example.org/property"]);
        $this->assertCount(3, $statementsB[$resourceB]["http://example.org/property"]);
        $this->assertTrue(Arrays\arrayRecursiveEqual(array($resourceA => $resource), $statementsA));
        $this->assertTrue(Arrays\arrayRecursiveEqual(array($resourceB => $resource), $statementsB));
    }

    public function testDeleteMatchingStatementsObjectUri()
    {
        $model = "http://example.org/";
        $useAC = false;
        $this->_store->getNewModel($model, $model, Erfurt_Store::MODEL_TYPE_OWL, $useAC);

        $insert = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'other text'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $after = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'other text'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $this->_store->addMultipleStatements($model, $insert, $useAC);
        $statementsBefore = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));
        $this->_store->deleteMatchingStatements(
            $model, null, null, array('type' => 'uri', 'value' => 'http://example.org/object'), array('use_ac' => $useAC)
        );
        $statementsAfter = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));

        $this->assertTrue(Arrays\arrayRecursiveEqual($insert, $statementsBefore));
        $this->assertTrue(Arrays\arrayRecursiveEqual($after, $statementsAfter));
    }

    public function testDeleteMatchingStatementsObjectLiteral()
    {
        $model = "http://example.org/";
        $useAC = false;
        $this->_store->getNewModel($model, $model, Erfurt_Store::MODEL_TYPE_OWL, $useAC);

        $insert = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'other text'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $after = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array('type' => 'literal', 'value' => 'other text'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $this->_store->addMultipleStatements($model, $insert, $useAC);
        $statementsBefore = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));
        $this->_store->deleteMatchingStatements(
            $model, null, null, array('type' => 'literal', 'value' => 'text'), array('use_ac' => $useAC)
        );
        $statementsAfter = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));

        $this->assertTrue(Arrays\arrayRecursiveEqual($insert, $statementsBefore));
        $this->assertTrue(Arrays\arrayRecursiveEqual($after, $statementsAfter));
    }

    public function testDeleteMatchingStatementsObjectLiteralLang()
    {
        $model = "http://example.org/";
        $useAC = false;
        $this->_store->getNewModel($model, $model, Erfurt_Store::MODEL_TYPE_OWL, $useAC);

        $insert = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'de'),
                    array('type' => 'literal', 'value' => 'other text', 'lang' => 'de'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'de'),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'en'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $after = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array('type' => 'literal', 'value' => 'other text', 'lang' => 'de'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'en'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $this->_store->addMultipleStatements($model, $insert, $useAC);
        $statementsBefore = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));
        $this->_store->deleteMatchingStatements(
            $model, null, null, array('type' => 'literal', 'value' => 'text', 'lang' => 'de'), array('use_ac' => $useAC)
        );
        $statementsAfter = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));

        $this->assertTrue(Arrays\arrayRecursiveEqual($insert, $statementsBefore));
        $this->assertTrue(Arrays\arrayRecursiveEqual($after, $statementsAfter));
    }

    public function testDeleteMatchingStatementsObjectLiteralTyped()
    {
        $model = "http://example.org/";
        $useAC = false;
        $this->_store->getNewModel($model, $model, Erfurt_Store::MODEL_TYPE_OWL, $useAC);

        $insert = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array(
                        'type' => 'literal',
                        'value' => '2016-06-26',
                        'datatype' => 'http://www.w3.org/2001/XMLSchema#date'
                    ),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'de'),
                    array('type' => 'literal', 'value' => 'other text', 'lang' => 'de'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array(
                        'type' => 'literal',
                        'value' => '2016-06-26',
                        'datatype' => 'http://www.w3.org/2001/XMLSchema#date'
                    ),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'de'),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'en'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $after = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'de'),
                    array('type' => 'literal', 'value' => 'other text', 'lang' => 'de'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'de'),
                    array('type' => 'literal', 'value' => 'text', 'lang' => 'en'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $this->_store->addMultipleStatements($model, $insert, $useAC);
        $statementsBefore = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));
        $this->_store->deleteMatchingStatements(
            $model,
            null,
            null,
            array('type' => 'literal', 'value' => '2016-06-26', 'datatype' => 'http://www.w3.org/2001/XMLSchema#date'),
            array('use_ac' => $useAC)
        );
        $statementsAfter = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));

        $this->assertTrue(Arrays\arrayRecursiveEqual($insert, $statementsBefore));
        $this->assertTrue(Arrays\arrayRecursiveEqual($after, $statementsAfter));
    }

    public function testDeleteMatchingStatementsPredicate()
    {
        $model = "http://example.org/";
        $useAC = false;
        $this->_store->getNewModel($model, $model, Erfurt_Store::MODEL_TYPE_OWL, $useAC);

        $insert = array(
            "http://example.org/resource" => array(
                "http://example.org/property" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object'),
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'other text'),
                ),
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $after = array(
            "http://example.org/resource" => array(
                "http://example.org/otherproperty" => array(
                    array('type' => 'uri', 'value' => 'http://example.org/object2'),
                    array('type' => 'literal', 'value' => 'text'),
                    array('type' => 'literal', 'value' => 'another text'),
                )
            )
        );

        $this->_store->addMultipleStatements($model, $insert, $useAC);
        $statementsBefore = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));
        $this->_store->deleteMatchingStatements(
            $model, null, "http://example.org/property", null, array('use_ac' => $useAC)
        );
        $statementsAfter = $this->_store->getResourceDescription("http://example.org/resource", $model, array(Erfurt_Store::USE_AC => false));

        $this->assertTrue(Arrays\arrayRecursiveEqual($insert, $statementsBefore));
        $this->assertTrue(Arrays\arrayRecursiveEqual($after, $statementsAfter));
    }

    public function testDeleteMatchingStatementsSubject()
    {
        $model = "http://example.org/";
        $useAC = false;
        $this->_store->getNewModel($model, $model, Erfurt_Store::MODEL_TYPE_OWL, $useAC);

        $resource = array(
            "http://example.org/property" => array(
                array('type' => 'uri', 'value' => 'http://example.org/object'),
                array('type' => 'literal', 'value' => 'text'),
                array('type' => 'literal', 'value' => 'other text'),
            ),
            "http://example.org/otherproperty" => array(
                array('type' => 'uri', 'value' => 'http://example.org/object2'),
                array('type' => 'literal', 'value' => 'text'),
                array('type' => 'literal', 'value' => 'another text'),
            )
        );
        $resourceA = "http://example.org/resourceA";
        $resourceB = "http://example.org/otherresource";

        $this->_store->addMultipleStatements($model, array(
            $resourceA => $resource,
            $resourceB => $resource,
        ), $useAC);

        $statementsBefore = $this->_store->getResourceDescription($resourceA, $model, array(Erfurt_Store::USE_AC => false));
        $this->_store->deleteMatchingStatements(
            $model, $resourceA, null, null, array('use_ac' => $useAC)
        );
        $statementsAfter = $this->_store->getResourceDescription($resourceA, $model, array(Erfurt_Store::USE_AC => false));
        $statementsAfterB = $this->_store->getResourceDescription($resourceB, $model, array(Erfurt_Store::USE_AC => false));

        $this->assertTrue(Arrays\arrayRecursiveEqual(array($resourceA => $resource), $statementsBefore));
        $this->assertTrue(Arrays\arrayRecursiveEqual(array($resourceB => $resource), $statementsAfterB));
        $this->assertEmpty($statementsAfter[$resourceA]);
    }
}
