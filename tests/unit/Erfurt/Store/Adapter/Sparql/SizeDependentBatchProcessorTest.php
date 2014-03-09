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
        $this->assertInstanceOf('Erfurt_Store_Adapter_Sparql_BatchProcessorInterface', $this->processor);
    }

    /**
     * Ensures that the processor does not pass empty quad lists to any sub-processor.
     */
    public function testProcessorDoesNotPassEmptySets()
    {
        $this->smallProcessor->expects($this->never())
                             ->method('persist');
        $this->hugeProcessor->expects($this->never())
                            ->method('persist');

        $this->processor->persist(array());
    }

    /**
     * Checks if the processor passes quad sets that are smaller than the provided
     * size to the sub-processor that is responsible for small sets.
     */
    public function testProcessorPassesSetsSmallerThanSizeToSmallProcessor()
    {
        $this->smallProcessor->expects($this->once())
                             ->method('persist')
                             ->with(new PHPUnit_Framework_Constraint_Count(2));
        $this->hugeProcessor->expects($this->never())
                            ->method('persist');

        $this->processor->persist($this->createQuadSet(2));
    }

    /**
     * Checks if the processor passes quad sets that are greater than the provided
     * size to the sub-processor that is responsible for huge sets.
     */
    public function testProcessorPassesSetsGreaterThanSizeToHugeProcessor()
    {
        $this->smallProcessor->expects($this->never())
                             ->method('persist');
        $this->hugeProcessor->expects($this->once())
                            ->method('persist')
                            ->with(new PHPUnit_Framework_Constraint_Count(4));

        $this->processor->persist($this->createQuadSet(4));
    }

    /**
     * Ensures that a quad set of the exact provided size is passed to the sub-processor
     * that is responsible for small sets.
     */
    public function testProcessorPassesSetsWithExactSizeToSmallProcessor()
    {
        $this->smallProcessor->expects($this->once())
                             ->method('persist')
                             ->with(new PHPUnit_Framework_Constraint_Count(3));
        $this->hugeProcessor->expects($this->never())
                            ->method('persist');

        $this->processor->persist($this->createQuadSet(3));
    }

    /**
     * Creates a quad set of the provided size.
     *
     * @param integer $size
     * @return array(\Erfurt_Store_Adapter_Sparql_Quad)
     */
    protected function createQuadSet($size)
    {
        $quads = array();
        for ($i = 0; $i < $size; $i++) {
            $quads[] = new Erfurt_Store_Adapter_Sparql_Quad(
                'http://example.org/subject' . $i,
                'http://example.org/predicate' . $i,
                array(
                    'type'  => 'uri',
                    'value' => 'http://example.org/object' . $i,
                ),
                'http://example.org/graph' . $i
            );
        }
        return $quads;
    }

}
