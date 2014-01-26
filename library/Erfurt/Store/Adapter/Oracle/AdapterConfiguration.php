<?php

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Represents an Oracle adapter configuration.
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
        $builder = new TreeBuilder();
        $root = $builder->root('oracle');
        $root
            ->children()
                ->arrayNode('connection')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('dbname')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('user')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('password')
                            ->isRequired()
                        ->end()
                        ->scalarNode('host')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->integerNode('port')
                            ->beforeNormalization()
                                ->ifString()
                                ->then(function($value) {
                                    return is_numeric($value) ? (int) $value : $value;
                                })
                            ->end()
                            ->defaultValue(1521)
                        ->end()
                        ->scalarNode('charset')
                            ->defaultValue('UTF8')
                        ->end()
                        ->booleanNode('persistent')
                            ->beforeNormalization()
                                ->ifInArray(array('0', '1', ''))
                                ->then(function($value) {
                                    return (bool)$value;
                                })
                            ->end()
                            ->defaultFalse()
                        ->end()
                        // Allows the usage of pooled connections as described at
                        // {@link http://de2.php.net/manual/de/oci8.connection.php}.
                        ->booleanNode('pooled')
                            ->beforeNormalization()
                                ->ifInArray(array('0', '1', ''))
                                ->then(function($value) {
                                    return (bool)$value;
                                })
                            ->end()
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
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
