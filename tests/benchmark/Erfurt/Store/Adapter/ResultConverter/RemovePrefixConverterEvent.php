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
     * Number of rows in the data sets that are used for testing.
     */
    const DATA_SET_SIZE = 200;

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
     * Converts a data set that does not contain prefixed variables.
     *
     * @Iterations 500
     */
    public function convertDataSetWithoutPrefixes()
    {
        $this->converter->convert($this->dataSets['noPrefixes']);
    }

    /**
     * Converts a data set that contains some (50%) prefixed variables.
     *
     * @Iterations 500
     */
    public function convertDataSetWithSomePrefixes()
    {
        $this->converter->convert($this->dataSets['somePrefixes']);
    }

    /**
     * Converts a data set that contains only prefixed variables.
     *
     * @Iterations 500
     */
    public function convertDataSetWithOnlyPrefixes()
    {
        $this->converter->convert($this->dataSets['onlyPrefixes']);
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
        $this->dataSets['noPrefixes'] = $this->createDataSet($variables);

        $somePrefixedVariables = array_map(function ($variable, $index) {
            return (($index % 2) === 0) ? 'prefix_' . $variable : $variable;
        },$variables, array_keys($variables));
        $this->dataSets['somePrefixes'] = $this->createDataSet($somePrefixedVariables);

        $prefixedVariables = array_map(function ($variable) {
            return 'prefix_' . $variable;
        }, $variables);
        $this->dataSets['onlyPrefixes'] = $this->createDataSet($prefixedVariables);
    }

    /**
     * Creates a data set that uses the provided row variable names.
     *
     * @param array(string) $variables
     * @return array(array(string=>string))
     */
    protected function createDataSet(array $variables)
    {
        $faker = \Faker\Factory::create('en');
        $faker->seed(0);
        $dataSet = array();
        for ($i = 0; $i < static::DATA_SET_SIZE; $i++) {
            $dataSet[$i] = array();
            foreach ($variables as $variable) {
                /* @var $variable string */
                $dataSet[$i][$variable] = $faker->text(100);
            }
        }
        return $dataSet;
    }

}
