<?php

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\IniFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

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
     * The paths to the container configuration files.
     *
     * @var array(string)
     */
    protected $configFiles = null;

    /**
     * The path to the cache directory.
     *
     * @var string
     */
    protected $cacheDirectory = null;

    /**
     * Additional container parameters.
     *
     * @var array(string=>scalar)
     */
    protected $parameters = null;

    /**
     * Creates a factory that uses the provided configuration files
     * to create a Dependency Injection container.
     *
     * Once created the container is cached in the provided directory.
     *
     * @param array(string) $configFiles
     * @param array(string=>mixed) $parameters Additional container parameters.
     * @param string $cacheDirectory
     * @throws \InvalidArgumentException If a config file or the cache directory does not exist.
     */
    public function __construct(array $configFiles, array $parameters, $cacheDirectory)
    {
        if (!is_dir($cacheDirectory)) {
            $message = 'Cache directory "' . $cacheDirectory . '" does not exist.';
            throw new InvalidArgumentException($message);
        }
        foreach ($configFiles as $config) {
            /* @var $config string */
            if (!is_file($config)) {
                $message = 'Configuration file "' . $config . '" does not exist.';
                throw new InvalidArgumentException($message);
            }
        }
        $this->configFiles    = $configFiles;
        $this->parameters     = $parameters;
        $this->cacheDirectory = $cacheDirectory;
    }

    /**
     * Creates the container that is described by the definition files.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function create()
    {
        $class = $this->getContainerClass();
        $cache = new ConfigCache($this->cacheDirectory . '/' . $class . '.php', true);
        if (!$cache->isFresh()) {
            $container = $this->createContainer();
            $container->compile();
            $dumper  = new PhpDumper($container);
            $content = $dumper->dump(array(
                'class' => $class
            ));
            $cache->write($content, $container->getResources());
            return $container;
        }

        require_once($cache);

        return new $class();
    }

    /**
     * Creates the container.
     *
     * @return ContainerBuilder
     */
    protected function createContainer()
    {
        $builder = new ContainerBuilder(new ParameterBag());
        $loader  = $this->createConfigLoader($builder);
        foreach ($this->configFiles as $config) {
            /* @var $config string */
            $loader->load($config);
        }
        // The parameters that are explicitly provided have the highest priority.
        // Therefore, they are added last and overwrite the ones in the configuration
        // files.
        $builder->getParameterBag()->add($this->parameters);
        $builder->addCompilerPass(new Erfurt_Store_Adapter_Container_SetupCompilerPass());
        return $builder;
    }

    /**
     * The name of the cached container class.
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return 'ErfurtContainer' . $this->getContainerId();
    }

    /**
     * Returns a loader for the config files.
     *
     * @param ContainerBuilder $container The service container
     * @return \Symfony\Component\Config\Loader\LoaderInterface
     */
    protected function createConfigLoader(ContainerBuilder $container)
    {
        $locator  = new FileLocator(array());
        $resolver = new LoaderResolver(array(
            new XmlFileLoader($container, $locator),
            new YamlFileLoader($container, $locator),
            new IniFileLoader($container, $locator),
            new PhpFileLoader($container, $locator)
        ));
        return new DelegatingLoader($resolver);
    }

    /**
     * Creates an ID for the container configuration.
     *
     * @return string
     */
    protected function getContainerId()
    {
        $signature = json_encode(array(
            $this->configFiles,
            $this->parameters
        ));
        return md5($signature);
    }

}
