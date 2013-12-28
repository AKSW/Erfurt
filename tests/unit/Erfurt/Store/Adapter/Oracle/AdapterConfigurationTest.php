<?php

/**
 * Tests the Oracle adapter configuration.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 28.12.13
 */
class Erfurt_Store_Adapter_Oracle_AdapterConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Oracle_AdapterConfiguration
     */
    protected $configuration = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->configuration = new Erfurt_Store_Adapter_Oracle_AdapterConfiguration();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->configuration = null;
        parent::tearDown();
    }

    /**
     * Checks if the configuration implements the required interface.
     */
    public function testImplementsConfigurationInterface()
    {
        $this->assertInstanceOf('Symfony\Component\Config\Definition\ConfigurationInterface', $this->configuration);
    }

    /**
     * Checks if getConfigTreeBuilder() returns a tree builder object.
     */
    public function testProvidesTreeBuilder()
    {
        $builder = $this->configuration->getConfigTreeBuilder();
        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $builder);
    }

    public function testConfigurationIsRejectedIfConnectionParametersAreOmitted()
    {

    }

    public function testConfigurationIsRejectedIfConnectionParametersAreIncomplete()
    {

    }

    public function testConfigurationAcceptsPortAsString()
    {
        
    }

}
