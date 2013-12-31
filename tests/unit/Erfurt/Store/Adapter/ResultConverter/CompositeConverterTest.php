<?php

/**
 * Tests the composite converter.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_ResultConverter_CompositeConverterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Checks if the converter implements the necessary interface.
     */
    public function testImplementsInterface()
    {

    }

    /**
     * Ensures that  the unmodified result set is returned by convert() if no
     * converter was passed to the composite.
     */
    public function testCompositeReturnsUnchangedResultIfNoConverterIsProvided()
    {

    }

    /**
     * Checks if the result set is passed to the first converter.
     */
    public function testCompositePassesResultSetToFirstConverter()
    {

    }

    /**
     * Ensures that the result of the first converter is passed to
     * the second one.
     */
    public function testCompositePassesResultFromFirstToSecondConverter()
    {

    }

    /**
     * Checks if the result of the last converter is returned by convert().
     */
    public function testCompositeReturnsResultFromLastConverter()
    {

    }

}
