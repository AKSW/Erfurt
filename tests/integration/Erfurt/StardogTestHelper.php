<?php

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper class that is used to set up the environment for Stardog integration tests.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 */
class Erfurt_StardogTestHelper
{

    /**
     * Cleans up the environment.
     */
    public function cleanUp()
    {

    }

    /**
     * Returns the Stardog API client instance.
     *
     * @return Erfurt_Store_Adapter_Stardog_ApiClient
     */
    public function getApiClient()
    {
        $container = $this->getContainer();
        $client    = $container->get('stardog.api_client');
        PHPUnit_Framework_Assert::assertInstanceOf('Erfurt_Store_Adapter_Stardog_ApiClient', $client);
        return $client;
    }

    /**
     * Returns the service container that wires the different
     * components for the Stardog connector.
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        $config = $this->getConfig();
        $config['service'] = 'service_container';
        return\Erfurt_Store_Adapter_Container::createFromOptions($config);
    }

    /**
     * Loads the configuration for the adapter.
     *
     * @return array(mixed)
     * @throws \PHPUnit_Framework_SkippedTestError If the config does not exist.
     */
    protected function getConfig()
    {
        $path = __DIR__ . '/../../stardog.ini';
        if (!is_file($path)) {
            $message = 'This test requires a Stardog configuration in the file '
                     . 'stardog.ini in the test root. Use stardog.ini.dist as a template.';
            throw new PHPUnit_Framework_SkippedTestError($message);
        }
        $config = new Zend_Config_Ini($path);
        return $config->toArray();
    }

}
