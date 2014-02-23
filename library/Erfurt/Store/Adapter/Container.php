<?php

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

/**
 * Factory that uses a Dependency Injection container to retrieve
 * an adapter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 22.02.14
 */
class Erfurt_Store_Adapter_Container implements \Erfurt_Store_Adapter_FactoryInterface
{

    /**
     * Uses the options to create an adapter instance.
     *
     * @param array(string=>mixed) $adapterOptions
     * @return \Erfurt_Store_Adapter_Interface
     * @throws \InvalidArgumentException If options are missing or wrong options are provided.
     */
    public static function createFromOptions(array $adapterOptions)
    {
        $adapterOptions = static::normalizeOptions(
            $adapterOptions,
            new Erfurt_Store_Adapter_Container_ContainerConfiguration()
        );
        $factory = new Erfurt_Store_Adapter_Container_ContainerFactory(
            $adapterOptions['configs'],
            static::flattenParameters($adapterOptions['parameters']),
            $adapterOptions['cache_directory']
        );
        $container = $factory->create();
        return $container->get($adapterOptions['service']);
    }

    /**
     * Flattens the provided parameter structure.
     *
     * @param array(string=>mixed) $parameters
     * @param array(string) $prefixes
     * @return array(string=>scalar)
     */
    protected static function flattenParameters(array $parameters, $prefixes = array())
    {
        $flattened = array();
        foreach ($parameters as $name => $value) {
            /* @var $name string */
            /* @var $value mixed */
            $nameParts = $prefixes;
            $nameParts[] = $name;
            if (is_array($value)) {
                $params = static::flattenParameters($value, $nameParts);
                $flattened = array_merge($flattened, $params);
            } else {
                $flattened[implode('.', $nameParts)] = $value;
            }
        }
        return $flattened;
    }

    /**
     * Validates and normalizes the provided options.
     *
     * @param array(string=>mixed) $options
     * @param \Symfony\Component\Config\Definition\ConfigurationInterface $configuration
     * @return array(string=>mixed)
     */
    protected static function normalizeOptions(array $options, ConfigurationInterface $configuration)
    {
        $processor = new Processor();
        return $processor->processConfiguration(
            $configuration,
            array($options)
        );
    }

}
