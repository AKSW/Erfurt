<?php

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Defines an Oracle adapter configuration.
 *
 * This specification is used for validation and normalization.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 28.12.13
 */
class Erfurt_Store_Adapter_Oracle_AdapterConfiguration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $connectionConfig = new Erfurt_Store_Adapter_Oracle_ConnectionConfiguration();
        $builder = new TreeBuilder();
        $root = $builder->root('oracle');
        $root
            ->children()
                ->append($connectionConfig->getRoot()->isRequired())
                ->booleanNode('auto_setup')
                    ->beforeNormalization()
                        ->ifInArray(array('0', '1', ''))
                        ->then(function($value) {
                            return (bool)$value;
                        })
                    ->end()
                    ->defaultFalse()
                ->end()
                ->scalarNode('username')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('password')
                    ->cannotBeEmpty()
                ->end()
            ->end();
        return $builder;
    }

}
