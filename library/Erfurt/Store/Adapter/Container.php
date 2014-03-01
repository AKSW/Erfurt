<?php

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

/**
 * Factory that uses a Dependency Injection container to retrieve
 * an adapter.
 *
 * This adapter factory relies on the Dependency Injection container
 * of Symfony to create adapter instances.
 *
 * # Basic Configuration #
 *
 * The minimal configuration includes at least one service configuration
 * file and the ID of the service that is used as adapter. Additionally,
 * the adapter class must be explicitly provided if a name other than
 * ``container`` is used to reference the configured store:
 *
 *     store.container_adapter.adapterClass = "Erfurt_Store_Adapter_Container"
 *     store.container_adapter.configs[]    = "%erfurt.root%/container-configs/MyConfig.yml"
 *     store.container_adapter.service      = "my_service"
 *
 * The placeholder %erfurt.root% can be used in the configuration path to refer to the project
 * root of Erfurt.
 *
 * # Container Parameters #
 *
 * In addition to this minimal configuration, container parameters can be provided:
 *
 *     ;[...]
 *     store.container_adapter.parameters.mysql.host = "localhost"
 *
 * Container parameters are available in the container configuration files
 * and can be used to parametrize the constructed objects.
 * The parameter in the example above is available as "mysql.host".
 *
 * # Container Configuration #
 *
 * This factory supports YAML, XML and PHP files to define services.
 * Refer to {@link http://symfony.com/doc/current/components/dependency_injection/introduction.html}
 * to learn about the various configuration styles.
 *
 * # Adapter Setup #
 *
 * The container factory provides an optional feature to automate the setup of
 * an adapter.
 *
 * To automate the setup, one or more services that implement \Erfurt_Store_Adapter_Container_SetupInterface
 * must be configured in the container. Additionally, these setup services must be tagged with
 * "erfurt.container.setup".
 *
 * The following example shows the configuration of the Oracle Package setup:
 *
 *     oracle.setup.package:
 *         class: Erfurt_Store_Adapter_Oracle_Setup_PackageSetup
 *         arguments: ["@doctrine.connection"]
 *         tags:
 *             -  { name: erfurt.container.setup }
 *
 * To ensure that the setup is called, the "erfurt.auto_setup" parameter must evaluate to true.
 * This can be configured in the *.ini file:
 *
 *      store.container_adapter.parameters.erfurt.auto_setup = On
 *
 * Now the setup routines are checked each time when the container is compiled (which is
 * usually the case on the first run or after a configuration change).
 * An installation is only started if the component is not already installed.
 *
 * # Retrieve the Container #
 *
 * In some cases (for example for testing) it might be useful to retrieve the service
 * container directly to get access to the sub-components.
 *
 * Simply pass the identifier "service_container" as service parameter to get the whole
 * container instead of a specific adapter service:
 *
 *     ; [...]
 *     store.container_adapter.service = "service_container"
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
            static::substituteRootPlaceholder($adapterOptions['configs']),
            static::flattenParameters($adapterOptions['parameters']),
            $adapterOptions['cache_directory']
        );
        $container = $factory->create();
        return $container->get($adapterOptions['service']);
    }

    /**
     * Replaces occurrences of "%erfurt.root%" with the absolute path
     * to the project root directory of Erfurt.
     *
     * @param array(string) $configs
     * @return array(string)
     */
    protected static function substituteRootPlaceholder(array $configs)
    {
        $root = dirname(__FILE__) . '/../../../..';
        $root = realpath($root);
        foreach (array_keys($configs) as $index) {
            /* @var $index string|integer */
            $configs[$index] = str_replace('%erfurt.root%', $root, $configs[$index]);
        }
        return $configs;
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
