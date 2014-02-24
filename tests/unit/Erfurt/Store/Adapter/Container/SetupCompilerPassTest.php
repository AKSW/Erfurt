<?php

/**
 * Tests the Setup compiler pass.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 24.02.14
 */
class Erfurt_Store_Adapter_Container_SetupCompilerPassTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Checks if the compiler pass implements the required interface.
     */
    public function testImplementsInterface()
    {

    }

    /**
     * Ensures that the setup instances are not called if the "erfurt.container.auto_setup"
     * parameter is false.
     */
    public function testSetupsAreNotCalledIfAutoSetupIsFalse()
    {

    }

    /**
     * Ensures that the setups are called if the "erfurt.container.auto_setup" evaluates
     * to true.
     */
    public function testPassCallsSetupsIfAutoSetupIsTrue()
    {

    }

    /**
     * Ensures that features that are already installed won't be installed again.
     */
    public function testPassDoesNotReInstallFeatures()
    {

    }

}
