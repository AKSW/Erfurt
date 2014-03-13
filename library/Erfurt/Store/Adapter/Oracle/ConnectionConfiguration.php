<?php

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Defines the configuration for an Oracle database connection.
 *
 * This specification is used for validation and normalization.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 09.02.14
 */
class Erfurt_Store_Adapter_Oracle_ConnectionConfiguration implements ConfigurationInterface
{

    /**
     * The configuration builder.
     *
     * @var \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    protected $builder = null;

    /**
     * The root node of the configuration.
     *
     * @var \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    protected $root = null;

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $this->build();
        return $this->builder;
    }

    /**
     * Returns the root node of the configuration.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    public function getRoot()
    {
        $this->build();
        return $this->root;
    }

    /**
     * Builds the configuration tree,
     */
    protected function build()
    {
        if ($this->builder !== null) {
            return;
        }
        $this->builder = new TreeBuilder();
        $this->root = $this->builder->root('connection');
        $this->root
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
                            return is_numeric($value) ? (int)$value : $value;
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
                // The name of the connection pool. Only shared connections from
                // this pool are used by the application.
                ->scalarNode('pool')
                    ->defaultValue('erfurt')
                ->end()
                ->arrayNode('session')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function($value) {
                            if (!is_numeric($value)) {
                                return $value;
                            }
                            return (ctype_digit($value)) ? (int)$value : (double)$value;
                        })
                    ->end()
                ->end()
            ->end();
    }

}
