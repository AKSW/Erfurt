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

    }

    /**
     * Checks if the factory creates cache files.
     */
    public function testFactoryCreatesCacheFiles()
    {

    }

    /**
     * Ensures that the second  call to create() returns a container (which
     * should be a cached version).
     */
    public function testSecondCallToCreateReturnsContainer()
    {

    }

    /**
     * Ensures that the container is updated when one of the config files
     * changes.
     */
    public function testFactoryUpdatesContainerWhenConfigFileChanges()
    {

    }

    /**
     * Ensures that the container is updated when the provided parameters change.
     */
    public function testFactoryUpdatesContainerWhenParametersChange()
    {

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
        return dirname(__FILE__) . '/files/ContainerFactory/' . $file;
    }

}
