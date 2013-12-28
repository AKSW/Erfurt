<?php
use Symfony\Component\Config\Definition\Processor;

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

    /**
     * Ensures that a configuration, which omits the connection part, is rejected.
     */
    public function testConfigurationIsRejectedIfConnectionParametersAreOmitted()
    {

    }

    /**
     * Ensures that a configuration is rejected if the connection parameters are incomplete.
     */
    public function testConfigurationIsRejectedIfConnectionParametersAreIncomplete()
    {

    }

    /**
     * Checks if a complete configuration is accepted.
     */
    public function testCompleteConfigurationIsAccepted()
    {

    }

    /**
     * Checks if the configuration accepts the port number as a string.
     */
    public function testConfigurationAcceptsPortAsString()
    {

    }

    /**
     * Uses the configuration to process the provided options.
     *
     * @param array(string=>mixed) $options
     * @return array(string=>mixed) The processed options.
     */
    protected function processOptions(array $options)
    {
        $processor = new Processor();
        return $processor->processConfiguration($this->configuration, array($options));
    }

}
