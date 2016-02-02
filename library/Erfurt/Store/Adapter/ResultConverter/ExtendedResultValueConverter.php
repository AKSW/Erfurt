<?php

/**
 * Converts values in the bindings of an extended result set.
 *
 * This converter applies another converter that is passed to the constructor to
 * each value specification in an extended result set.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_ResultConverter_ExtendedResultValueConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * The converter that is applied to each value specification.
     *
     * @var \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
     */
    protected $valueConverter = null;

    /**
     * Creates the converter.
     *
     * @param Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface $valueConverter
     */
    public function __construct(Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface $valueConverter)
    {
        $this->valueConverter = $valueConverter;
    }

    /**
     * Converts value specifications in the provided result.
     *
     * @param array(array(string=>string))|mixed $resultSet
     * @return array(array(string=>string))|mixed
     * @throws \Erfurt_Store_Adapter_ResultConverter_Exception If conversion is not possible.
     */
    public function convert($resultSet)
    {
        foreach (array_keys($resultSet['results']['bindings']) as $rowIndex) {
            /* @var $rowIndex integer */
            foreach (array_keys($resultSet['results']['bindings'][$rowIndex]) as $varName) {
                /* @var $varName string */
                $resultSet['results']['bindings'][$rowIndex][$varName] = $this->valueConverter->convert(
                    $resultSet['results']['bindings'][$rowIndex][$varName]
                );
            }
        }
        return $resultSet;
    }

}
