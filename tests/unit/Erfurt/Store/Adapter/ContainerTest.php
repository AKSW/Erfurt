<?php

/**
 * Tests the adapter factory that uses a service container.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 23.02.14
 */
class Erfurt_Store_Adapter_ContainerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->cleanUpCache();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->cleanUpCache();
        parent::tearDown();
    }

    /**
     * Checks if the factory returns the referenced service.
     */
    public function testFactoryReturnsReferencedService()
    {
        $adapter = $this->createAdapter();

        $this->assertInstanceOf('ArrayObject', $adapter);
    }

    /**
     * Checks if the factory adds simple parameters.
     */
    public function testFactoryAddsSimpleParameters()
    {
        $adapter = $this->createAdapter();

        $this->assertInstanceOf('ArrayObject', $adapter);
        $this->assertEquals('simple_value', $adapter->offsetGet('simple_param'));
    }

    /**
     * Ensures that the factory flattens complex parameters (multi-dimensional
     * arrays).
     */
    public function testFactoryFlattensNestedParameters()
    {
        $adapter = $this->createAdapter();

        $this->assertInstanceOf('ArrayObject', $adapter);
        $this->assertEquals('nested_value', $adapter->offsetGet('nested_param'));
    }

    /**
     * Uses the factory to create the adapter.
     *
     * @return ArrayObject|mixed
     */
    protected function createAdapter()
    {
        return Erfurt_Store_Adapter_Container::createFromOptions($this->getOptions());
    }

    /**
     * Returns the options that are used for testing.
     *
     * @return array(string=>mixed)
     */
    protected function getOptions()
    {
        return array(
            'configs' => array(
                dirname(__FILE__) . '/_files/Container/config.yml'
            ),
            'service'         => 'my_adapter',
            'cache_directory' => $this->getCachePath(),
            'parameters'      => array(
                'simple_param' => 'simple_value',
                'nested'       => array(
                    'param' => 'nested_value'
                )
            )
        );
    }

    /**
     * Removes cache files that have been created.
     */
    protected function cleanUpCache()
    {
        foreach (glob($this->getCachePath() . '/*') as $file) {
            if (basename($file) === '.gitkeep') {
                continue;
            }
            unlink($file);
        }
    }

    /**
     * Returns the path to the cache directory.
     *
     * @return string
     */
    protected function getCachePath()
    {
        return dirname(__FILE__) . '/_files/Container/cache';
    }

}
