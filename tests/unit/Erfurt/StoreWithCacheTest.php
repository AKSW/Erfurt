<?php

use WhiteGecko\Arrays;

class Erfurt_StoreWithCacheTest extends Erfurt_TestCase
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
            "cache" => array("frontend" => array("enable" => 1))
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
