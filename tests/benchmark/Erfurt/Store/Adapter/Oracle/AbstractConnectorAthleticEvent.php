<?php

use Athletic\AthleticEvent;
use Faker\Generator;

/**
 * Base class for Oracle connector benchmarks.
 *
 * Contains the code that is necessary to set up and clean up the triple store.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.02.14
 */
abstract class Erfurt_Store_Adapter_Oracle_AbstractConnectorAthleticEvent extends AthleticEvent
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Oracle_OracleSparqlConnector
     */
    protected $connector = null;

    /**
     * Test helper that is used to set up the environment.
     *
     * @var \Erfurt_OracleTestHelper
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
        $this->helper = new \Erfurt_OracleTestHelper();
        $this->helper->installTripleStore();
        $this->connector = new Erfurt_Store_Adapter_Oracle_OracleSparqlConnector($this->helper->getConnection());
    }

    /**
     * Cleans up the environment.
     */
    protected function classTearDown()
    {
        $this->connector = null;
        $this->helper->cleanUp();
    }

    /**
     * Method that can be overridden to populate the store with triples.
     *
     * @param \Faker\Generator $faker
     */
    protected function populateStore(Generator $faker)
    {
    }

}
