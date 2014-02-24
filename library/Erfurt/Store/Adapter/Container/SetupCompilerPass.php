<?php

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Compiler pass that executes registered setup routines during
 * container compiling.
 *
 * Setup instances must be tagged as "erfurt.container.setup".
 *
 * Setup procedures are only executed if the "erfurt.container.auto_setup"
 * parameter evaluates to true.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 24.02.14
 */
class Erfurt_Store_Adapter_Container_SetupCompilerPass implements CompilerPassInterface
{

    /**
     * Executes the setup procedures if necessary.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {

    }

}
