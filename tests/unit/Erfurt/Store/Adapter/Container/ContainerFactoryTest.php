<?php

/**
 * Tests the DI container factory.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 22.02.14
 */
class Erfurt_Store_Adapter_Container_ContainerFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->cleanUpCache();
        $this->createTemporaryConfig();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->removeTemporaryConfig();
        $this->cleanUpCache();
        parent::tearDown();
    }

    /**
     * Ensures that the constructor throws an exception if the provided cache directory
     * does not exist.
     */
    public function testConstructorThrowsExceptionIfCacheDirectoryDoesNotExist()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Erfurt_Store_Adapter_Container_ContainerFactory(array(), array(), $this->path('missing'));
    }

    /**
     * Ensures that the constructor throws an exception if one of the definition files
     * does not exist.
     */
    public function testConstructorThrowsExceptionIfOneOfTheDefinitionFilesDoesNotExist()
    {
        $configs = array(
            $this->path('config/container.yml')
        );

        $this->setExpectedException('InvalidArgumentException');
        new Erfurt_Store_Adapter_Container_ContainerFactory($configs, array(), $this->path('cache'));
    }

    /**
     * Checks if create() returns a container.
     */
    public function testCreateReturnsContainer()
    {
        $factory   = $this->createFactory();
        $container = $factory->create();

        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);
    }

    /**
     * Checks if the factory creates cache files.
     */
    public function testFactoryCreatesCacheFiles()
    {
        $pattern = $this->path('cache') . '/*';

        $filesBefore = count(glob($pattern));
        $this->createFactory()->create();
        $filesAfter = count(glob($pattern));

        $this->assertGreaterThan($filesBefore, $filesAfter);
    }

    /**
     * Ensures that the second  call to create() returns a container (which
     * should be a cached version).
     */
    public function testSecondCallToCreateReturnsContainer()
    {
        $factory = $this->createFactory();

        $factory->create();
        $container = $factory->create();

        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);
    }

    /**
     * Ensures that the container is updated when one of the config files
     * changes.
     */
    public function testFactoryUpdatesContainerWhenConfigFileChanges()
    {
        $factory = $this->createFactory();

        $factory->create();
        // Wait a second, otherwise the file change might not be recognized as the timestamp does not change.
        sleep(1);
        $this->createTemporaryConfig('another_value');

        $container = $factory->create();

        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);
        $this->assertEquals('another_value', $container->getParameter('temp.parameter'));
    }

    /**
     * Ensures that the container is updated when the provided parameters change.
     */
    public function testFactoryUpdatesContainerWhenParametersChange()
    {
        $this->createFactory()->create();

        $container = $this->createFactory(array('another_parameter' => 'some_value'))->create();

        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);
        $this->assertEquals('some_value', $container->getParameter('another_parameter'));
    }

    /**
     * Ensures that the parameters in the configuration files are overwritten by the
     * ones that are explicitly provided.
     */
    public function testPassedParametersOverwriteTheOnesInConfigurationFiles()
    {
        $factory = $this->createFactory(array('default.parameter' => 'demo'));

        $container = $factory->create();

        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerInterface', $container);
        $this->assertEquals('demo', $container->getParameter('default.parameter'));
    }

    /**
     * Creates a container factory for testing.
     *
     * @param array(string=>mixed) $parameters
     * @return Erfurt_Store_Adapter_Container_ContainerFactory
     */
    protected function createFactory(array $parameters = array())
    {
        $configs = array(
            $this->path('configs/default.yml'),
            $this->getTemporaryConfigPath()
        );
        return new Erfurt_Store_Adapter_Container_ContainerFactory($configs, $parameters, $this->path('cache'));
    }

    /**
     * Removes cache files that have been created.
     */
    protected function cleanUpCache()
    {
        foreach (glob($this->path('cache') . '/*') as $file) {
            if (basename($file) === 'README.md') {
                continue;
            }
            unlink($file);
        }
    }

    /**
     * Writes a temporary config file that contains the parameter
     * "temp.parameter" with the provided value.
     *
     * @param string $parameterValue
     */
    protected function createTemporaryConfig($parameterValue = 'temp')
    {
        $content = array(
            'parameters:',
            '    temp.parameter: "' . $parameterValue . '"'
        );
        file_put_contents($this->getTemporaryConfigPath(), implode(PHP_EOL, $content));
    }

    /**
     * Removes the temporary config file.
     */
    protected function removeTemporaryConfig()
    {
        if (is_file($this->getTemporaryConfigPath())) {
            unlink($this->getTemporaryConfigPath());
        }
    }

    /**
     * Returns the path to the config file that is created temporarily.
     *
     * @return string
     */
    protected function getTemporaryConfigPath()
    {
        return $this->path('configs/temp.yml');
    }

    /**
     * Returns the absolute path to the provided test data file.
     *
     * Test data files are located in _files/ContainerFactory.
     *
     * @param string $file
     * @return string
     */
    protected function path($file)
    {
        return dirname(__FILE__) . '/_files/ContainerFactory/' . $file;
    }

}
