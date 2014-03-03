<?php

/**
 * Accepts a value specification and converts literal value to their native PHP
 * types (if possible).
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_ResultConverter_LiteralToTypedConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Converts the provided result set.
     *
     * @param array(string=>string) $valueSpecification
     * @return array(string=>string) The specification with typed literal value.
     * @throws \Erfurt_Store_Adapter_ResultConverter_Exception If conversion is not possible.
     */
    public function convert($valueSpecification)
    {
        // TODO: Implement convert() method.
    }

}
