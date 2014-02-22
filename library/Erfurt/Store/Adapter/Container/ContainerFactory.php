<?php

/**
 * Factory that creates a container.
 *
 * The container is cached if possible.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 22.02.14
 */
class Erfurt_Store_Adapter_Container_ContainerFactory
{

    /**
     * Creates a factory that uses the provided configuration files
     * to create a Dependency Injection container.
     *
     * Once created the container is cached in the provided directory.
     *
     * @param array(string) $definitionFiles
     * @param $cacheDirectory
     */
    public function __construct(array $definitionFiles, $cacheDirectory)
    {

    }

    /**
     * Creates the container that is described by the definition files.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function create()
    {

    }

}
