<?php

/**
 * Tests the size dependent batch processor.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.03.14
 */
class Erfurt_Store_Adapter_Sparql_SizeDependentBatchProcessorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Sparql_SizeDependentBatchProcessor
     */
    protected $processor = null;

    /**
     * Mocked processor that is used for small quad sets.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $smallProcessor = null;

    /**
     * Mocked processor that is used for huge quad sets.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $hugeProcessor = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->smallProcessor = $this->getMock('Erfurt_Store_Adapter_Sparql_BatchProcessorInterface');
        $this->hugeProcessor  = $this->getMock('Erfurt_Store_Adapter_Sparql_BatchProcessorInterface');
        $this->processor = new Erfurt_Store_Adapter_Sparql_SizeDependentBatchProcessor(
            3,
            $this->smallProcessor,
            $this->hugeProcessor
        );
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->processor      = null;
        $this->hugeProcessor  = null;
        $this->smallProcessor = null;
        parent::tearDown();
    }

    /**
     * Checks if the processor implements the necessary interface.
     */
    public function testImplementsInterface()
    {

    }

}
