<?php

use Athletic\AthleticEvent;
use Faker\Generator;

/**
 * Base class for connector benchmarks.
 *
 * Contains the code that is necessary to set up and clean up a triple store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.02.14
 */
abstract class Erfurt_Store_Adapter_Sparql_AbstractConnectorAthleticEvent extends AthleticEvent
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface
     */
    protected $connector = null;

    /**
     * Helper class that is used to retrieve the connector and to clean up the environment.
     *
     * @var \Erfurt_Store_Adapter_Sparql_ConnectorBenchmarkHelperInterface
     */
    protected $helper = null;

    /**
     * A seeded faker that can be used to generate test data.
     *
     * @var \Faker\Generator
     */
    protected $faker = null;

    /**
     * Sets up the environment.
     */
    protected function classSetUp()
    {
        $this->faker = \Faker\Factory::create('en');
        $this->faker->seed(0);
        $this->helper    = $this->createHelper();
        $this->connector = $this->helper->getSparqlConnector();
        $this->populateStoreAsBatch();
    }

    /**
     * Cleans up the environment.
     */
    protected function classTearDown()
    {
        $this->connector = null;
        if ($this->helper !== null) {
            $this->helper->cleanUp();
        }
        $this->helper = null;
    }

    /**
     * Re-initializes the faker to ensure that the same values
     * are generated in each iteration.
     */
    protected function setUp()
    {
        $this->faker->seed(0);
    }

    /**
     * Method that can be overridden to populate the store with triples.
     *
     * The triples will be automatically added in batch mode.
     *
     * @param \Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector
     * @param \Faker\Generator $faker
     */
    public function populateStore(\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector, Generator $faker)
    {
    }

    /**
     * Populates the store in batch mode.
     */
    protected function populateStoreAsBatch()
    {
        $faker = $this->faker;
        $event = $this;
        $import = function (\Erfurt_Store_Adapter_Sparql_SparqlConnectorInterface $connector) use ($faker, $event) {
            $event->populateStore($connector, $faker);
        };
        $this->connector->batch($import);
    }

    /**
     * Creates the helper object that is used to set up the benchmark environment.
     *
     * @return Erfurt_Store_Adapter_Sparql_ConnectorBenchmarkHelperInterface
     */
    protected function createHelper()
    {
        throw new RuntimeException('Create helper.');
    }

}
