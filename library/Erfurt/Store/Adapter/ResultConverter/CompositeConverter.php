<?php

/**
 * Contains several converters that are applied to a result set
 * one after another.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_ResultConverter_CompositeConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{


    /**
     * The inner converters.
     *
     * @var array(Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface)
     */
    protected $converters = array();

    /**
     * Creates a composite that will apply the provided converters to result sets,
     * which are passed to convert().
     *
     * @param array(Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface) $converters
     */
    public function __construct(array $converters)
    {
        $this->converters = $converters;
    }

    /**
     * Converts the provided result set.
     *
     * @param array(array(string=>string))|mixed $resultSet
     * @return array(array(string=>string))|mixed
     */
    public function convert($resultSet)
    {
        foreach ($this->converters as $converter) {
            /* @var $converter Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface */
            $resultSet = $converter->convert($resultSet);
        }
        return $resultSet;
    }

}
