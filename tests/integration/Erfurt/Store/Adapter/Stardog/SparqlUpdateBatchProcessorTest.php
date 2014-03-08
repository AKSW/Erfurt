<?php

/**
 * Tests the SPARQL update batch processor.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 08.03.14
 * @group Stardog
 */
class Erfurt_Store_Adapter_Stardog_SparqlUpdateBatchProcessorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test helper that is used to initialize the environment.
     *
     * @var \Erfurt_StardogTestHelper
     */
    protected $helper = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->helper = new Erfurt_StardogTestHelper();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->helper->cleanUp();
        $this->helper = null;
        parent::tearDown();
    }

    public function testImplementsInterface()
    {

    }

    public function testPersistCanHandleEmptyQuadList()
    {

    }

    public function testPersistAddsSingleQuad()
    {

    }

    public function testPersistAddsMultipleQuads()
    {

    }

    public function testPersistAssignsQuadsToCorrectGraphs()
    {

    }

}
