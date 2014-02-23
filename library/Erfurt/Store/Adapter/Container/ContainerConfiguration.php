<?php

use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Describes the configuration for the factory that uses a service container
 * to create an adapter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 23.02.14
 */
class Erfurt_Store_Adapter_Container_ContainerConfiguration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        // TODO: Implement getConfigTreeBuilder() method.
    }

}
