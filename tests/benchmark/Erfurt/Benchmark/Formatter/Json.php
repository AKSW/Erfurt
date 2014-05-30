<?php

use Athletic\Formatters\FormatterInterface;
use Athletic\Results\ClassResults;
use Athletic\Results\MethodResults;

/**
 * Formats benchmarking results as JSON.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 30.05.14
 */
class Erfurt_Benchmark_Formatter_Json implements FormatterInterface
{

    /**
     * Returns the results as JSON string.
     *
     * @param ClassResults[] $results
     * @return string
     */
    public function getFormattedResults($results)
    {
        $data = array();
        foreach ($results as $result) {
            if (!isset($data[$result->getClassName()])) {
                $data[$result->getClassName()] = array();
            }
            foreach ($result as $methodResults) {
                /* @var $methodResults MethodResults */
                $data[$result->getClassName()][] = $this->convertToArray($methodResults);
            }
        }
        return $this->encode($data);
    }

    /**
     * Encodes the given data as JSON.
     *
     * @param array(string=>mixed) $data
     * @return string
     */
    protected function encode($data)
    {
        $options = 0;
        if (defined('JSON_PRETTY_PRINT')) {
            $options = $options | JSON_PRETTY_PRINT;
        }
        return json_encode((object)$data, $options);
    }

    /**
     * Converts the given method results into a simple array that can be JSON encoded.
     *
     * @param MethodResults $methodResults
     * @return array(string=>mixed)
     */
    protected function convertToArray(MethodResults $methodResults)
    {
        // The results object provides all data as public attributes.
        return get_object_vars($methodResults);
    }

}
