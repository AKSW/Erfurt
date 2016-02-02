<?php

/**
 * Can be implemented by adapters that provide a factory method to create the adapter instance.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 12.12.13
 */
interface Erfurt_Store_Adapter_FactoryInterface
{

    /**
     * Uses the options to create an adapter instance.
     *
     * @param array(string=>mixed) $adapterOptions
     * @return \Erfurt_Store_Adapter_Interface
     * @throws \InvalidArgumentException If options are missing or wrong options are provided.
     */
    public static function createFromOptions(array $adapterOptions);

}
