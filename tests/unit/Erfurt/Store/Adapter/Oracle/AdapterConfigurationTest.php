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
        $options = array(
        );

        $this->assertConfigurationRejected($options);
    }

    /**
     * Ensures that a configuration is rejected if the connection parameters are incomplete.
     */
    public function testConfigurationIsRejectedIfConnectionParametersAreIncomplete()
    {
        $options = array(
            'connection'   => array(
                'dbname'   => 'orcl',
                'host'     => 'not-important-in-this-test.local',
                'port'     => 1521
            )
        );

        $this->assertConfigurationRejected($options);
    }

    /**
     * Checks if a complete configuration is accepted.
     */
    public function testCompleteConfigurationIsAccepted()
    {
        $options = array(
            'connection'   => array(
                'dbname'   => 'orcl',
                'user'     => 'unknown',
                'password' => 'secret',
                'host'     => 'not-important-in-this-test.local',
                'port'     => 1521
            )
        );

        $this->assertConfigurationAccepted($options);
    }

    /**
     * Checks if the configuration accepts the port number as a string.
     *
     * The port might be passed as string if *.ini config files are used.
     */
    public function testConfigurationAcceptsPortAsString()
    {
        $options = array(
            'connection'   => array(
                'dbname'   => 'orcl',
                'user'     => 'unknown',
                'password' => 'secret',
                'host'     => 'not-important-in-this-test.local',
                'port'     => '1521'
            )
        );

        $this->assertConfigurationAccepted($options);
    }

    /**
     * Ensures that a port number, which is obviously invalid, is rejected.
     */
    public function testConfigurationRejectsInvalidPortNumber()
    {
        $options = array(
            'connection'   => array(
                'dbname'   => 'orcl',
                'user'     => 'unknown',
                'password' => 'secret',
                'host'     => 'not-important-in-this-test.local',
                'port'     => 'hello'
            )
        );

        $this->assertConfigurationRejected($options);
    }

    /**
     * Checks if number strings like "1" and "0" can be used for
     * the auto_setup option.
     *
     * This is important if On and Off values are used in *.ini
     * configuration files.
     */
    public function testConfigurationAcceptsNumbersForAutoSetup()
    {
        $options = array(
            'connection'   => array(
                'dbname'   => 'orcl',
                'user'     => 'unknown',
                'password' => 'secret',
                'host'     => 'not-important-in-this-test.local',
                'port'     => 1521
            ),
            'auto_setup' => '1'
        );

        $this->assertConfigurationAccepted($options);
    }

    /**
     * Checks if the configuration rejects an invalid auto_setup
     * option value.
     */
    public function testConfigurationRejectsInvalidAutoSetupValue()
    {
        $options = array(
            'connection'   => array(
                'dbname'   => 'orcl',
                'user'     => 'unknown',
                'password' => 'secret',
                'host'     => 'not-important-in-this-test.local',
                'port'     => 1521
            ),
            'auto_setup' => 'hello world'
        );

        $this->assertConfigurationRejected($options);
    }

    /**
     * asserts that the provided options are accepted.
     *
     * @param array(string=>mixed) $options
     */
    protected function assertConfigurationAccepted(array $options)
    {
        $this->setExpectedException(null);
        $this->processOptions($options);
    }

    /**
     * Asserts that the provided options are rejected.
     *
     * @param array(string=>mixed) $options
     */
    protected function assertConfigurationRejected(array $options)
    {
        $this->setExpectedException('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        $this->processOptions($options);
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
