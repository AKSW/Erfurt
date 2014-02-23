<?php

use Symfony\Component\Config\Definition\Processor;

/**
 * Tests the configuration schema for the container adapter factory.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 23.02.14
 */
class Erfurt_Store_Adapter_Container_ContainerConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var Erfurt_Store_Adapter_Container_ContainerConfiguration
     */
    protected $configuration = null;

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->configuration = new Erfurt_Store_Adapter_Container_ContainerConfiguration();
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
     * Checks if the configuration rejects options without config file references.
     */
    public function testConfigurationRejectsOptionsWithoutConfigFiles()
    {
        $options = array(
            'configs'         => array(),
            'service'         => 'my_service',
            'cache_directory' => $this->getDataDirectory()
        );

        $this->assertConfigurationRejected($options);
    }

    /**
     * Checks if the configuration rejects options without service id.
     */
    public function testConfigurationRejectsOptionsWithoutServiceReference()
    {
        $options = array(
            'configs' => array(
                $this->getDataDirectory() . '/default.yml'
            ),
            'cache_directory' => $this->getDataDirectory()
        );

        $this->assertConfigurationRejected($options);
    }

    /**
     * Ensures that the configuration adds a default cache directory if non
     * is provided.
     */
    public function testConfigurationAddsCacheDirectoryIfNonIsProvided()
    {
        $options = array(
            'configs' => array(
                $this->getDataDirectory() . '/default.yml'
            ),
            'service' => 'my_service'
        );

        $processed = $this->processOptions($options);

        $this->assertFileExists($processed['cache_directory']);
        $this->assertTrue(is_dir($processed['cache_directory']));
    }

    /**
     * Ensures that the configuration accepts a minimal set of options (configuration,
     * service id and cache directory).
     */
    public function testConfigurationAcceptsMinimalOptions()
    {
        $options = array(
            'configs' => array(
                $this->getDataDirectory() . '/default.yml'
            ),
            'service'         => 'my_service',
            'cache_directory' => $this->getDataDirectory()
        );

        $this->assertConfigurationAccepted($options);
    }

    /**
     * Ensures that the configuration accepts options with simple parameter
     * map (single dimensional array).
     */
    public function testConfigurationAcceptsOptionsWithSimpleParameters()
    {
        $options = array(
            'configs' => array(
                $this->getDataDirectory() . '/default.yml'
            ),
            'service'         => 'my_service',
            'cache_directory' => $this->getDataDirectory(),
            'parameters'      => array(
                'a' => 'b',
                'c' => 'd'
            )
        );

        $this->assertConfigurationAccepted($options);
    }

    /**
     * Ensures that the configuration accepts options with nested arrays
     * as parameters.
     */
    public function testConfigurationAcceptsOptionsWithNestedParameters()
    {
        $options = array(
            'configs' => array(
                $this->getDataDirectory() . '/default.yml'
            ),
            'service'         => 'my_service',
            'cache_directory' => $this->getDataDirectory(),
            'parameters'      => array(
                'a' => array(
                    'b',
                    'c'
                )
            )
        );

        $this->assertConfigurationAccepted($options);
    }

    /**
     * Asserts that the provided options are accepted.
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

    /**
     * Returns the path to the test data directory.
     *
     * @return string
     */
    protected function getDataDirectory()
    {
        return dirname(__FILE__) . '/_files/ContainerConfiguration';
    }

}
