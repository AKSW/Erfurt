<?php

/**
 * Interface foe setup procedures that can be executed automatically
 * during container compiling.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 24.02.14
 */
interface Erfurt_Store_Adapter_Container_SetupInterface
{

    /**
     * Checks if the feature is already installed.
     *
     * @return boolean
     */
    public function isInstalled();

    /**
     * Installs the feature.
     */
    public function install();

    /**
     * Removes a previously installed feature.
     *
     * All stored data will be lost.
     */
    public function uninstall();

}