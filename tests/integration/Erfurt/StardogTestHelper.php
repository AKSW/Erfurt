<?php

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper class that is used to set up the environment for Stardog integration tests.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 */
class Erfurt_StardogTestHelper extends Erfurt_AbstractTestHelper
{

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

}
