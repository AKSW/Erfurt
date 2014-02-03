<?php

use Athletic\AthleticEvent;

/**
 * Tests the performance of the converter that removes prefixes from result set keys.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.02.14
 */
class Erfurt_Store_Adapter_ResultConverter_RemovePrefixConverterEvent  extends AthleticEvent
{

    /**
     * Number of rows in the small data sets that are used for testing.
     */
    const SMALL_DATA_SET_SIZE = 100;

    /**
     * Number of rows in the large data sets that are used for testing.
     */
    const LARGE_DATA_SET_SIZE = 500;

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_ResultConverter_RemovePrefixConverter
     */
    protected $converter = null;

    /**
     * Different data sets that are used in the benchmarks.
     *
     * @var array(string=>array(mixed))
     */
    protected $dataSets = array();

    /**
     * Sets up the environment.
     */
    protected function classSetUp()
    {
        $this->prepareDataSets();
        $this->converter = new Erfurt_Store_Adapter_ResultConverter_RemovePrefixConverter('prefix_');
    }

    /**
     * Cleans up the environment.
     */
    protected function classTearDown()
    {
        $this->converter = null;
        $this->dataSets  = array();
    }

    /**
     * Converts a small data set that does not contain prefixed variables.
     *
     * @Iterations 200
     */
    public function convertSmallDataSetWithoutPrefixes()
    {
        $this->convertDataSet('smallWithoutPrefixes');
    }

    /**
     * Converts a large data set that does not contain prefixed variables.
     *
     * @Iterations 200
     */
    public function convertLargeDataSetWithoutPrefixes()
    {
        $this->convertDataSet('largeWithoutPrefixes');
    }

    /**
     * Converts a small data set that contains some (50%) prefixed variables.
     *
     * @Iterations 200
     */
    public function convertSmallDataSetWithSomePrefixes()
    {
        $this->convertDataSet('smallWithSomePrefixes');
    }

    /**
     * Converts a large data set that contains some (50%) prefixed variables.
     *
     * @Iterations 200
     */
    public function convertLargeDataSetWithSomePrefixes()
    {
        $this->convertDataSet('largeWithSomePrefixes');
    }

    /**
     * Converts a small data set that contains only prefixed variables.
     *
     * @Iterations 200
     */
    public function convertSmallDataSetWithOnlyPrefixes()
    {
        $this->convertDataSet('smallWithPrefixes');
    }

    /**
     * Converts a large data set that contains only prefixed variables.
     *
     * @Iterations 200
     */
    public function convertLargeDataSetWithOnlyPrefixes()
    {
        $this->convertDataSet('largeWithPrefixes');
    }

    /**
     * Converts the data set with the provided name.
     *
     * @param string $name
     */
    protected function convertDataSet($name)
    {
        $this->converter->convert($this->dataSets[$name]);
    }

    /**
     * Prepares the data sets for testing.
     */
    protected function prepareDataSets()
    {
        $faker = \Faker\Factory::create('en');
        $faker->seed(0);

        // Generate some variable names.
        $variables = array($faker->uuid, $faker->uuid, $faker->uuid, $faker->uuid, $faker->uuid, $faker->uuid);
        $this->dataSets['smallWithoutPrefixes'] = $this->createDataSet($variables, static::SMALL_DATA_SET_SIZE);
        $this->dataSets['largeWithoutPrefixes'] = $this->createDataSet($variables, static::LARGE_DATA_SET_SIZE);

        $somePrefixedVariables = array_map(function ($variable, $index) {
            return (($index % 2) === 0) ? 'prefix_' . $variable : $variable;
        },$variables, array_keys($variables));
        $this->dataSets['smallWithSomePrefixes'] = $this->createDataSet($somePrefixedVariables, static::SMALL_DATA_SET_SIZE);
        $this->dataSets['largeWithSomePrefixes'] = $this->createDataSet($somePrefixedVariables, static::LARGE_DATA_SET_SIZE);

        $prefixedVariables = array_map(function ($variable) {
            return 'prefix_' . $variable;
        }, $variables);
        $this->dataSets['smallWithPrefixes'] = $this->createDataSet($prefixedVariables, static::SMALL_DATA_SET_SIZE);
        $this->dataSets['largeWithPrefixes'] = $this->createDataSet($prefixedVariables, static::LARGE_DATA_SET_SIZE);
    }

    /**
     * Creates a data set that uses the provided row variable names.
     *
     * @param array(string) $variables
     * @param integer $numberOfItems Number of records in the data set.
     * @return array(array(string=>string))
     */
    protected function createDataSet(array $variables, $numberOfItems)
    {
        $faker = \Faker\Factory::create('en');
        $faker->seed(0);
        $dataSet = array();
        for ($i = 0; $i < $numberOfItems; $i++) {
            $dataSet[$i] = array();
            foreach ($variables as $variable) {
                /* @var $variable string */
                $dataSet[$i][$variable] = $faker->text(100);
            }
        }
        return $dataSet;
    }

}
