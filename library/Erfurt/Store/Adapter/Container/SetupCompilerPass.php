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
     * @throws \RuntimeException If an invalid service is tagged as setup.
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('erfurt.container.auto_setup')) {
            return;
        }
        if (!$container->getParameter('erfurt.container.auto_setup')) {
            return;
        }
        // Auto setup is active, find Setup instances and perform an installation if necessary.
        $setupIds = array_keys($container->findTaggedServiceIds('erfurt.container.setup'));
        foreach ($setupIds as $id) {
            /* @var $id string */
            /* @var $setup \Erfurt_Store_Adapter_Container_SetupInterface */
            $setup = $container->get($id);
            if (!($setup instanceof Erfurt_Store_Adapter_Container_SetupInterface)) {
                $message = 'Each service that is tagged as "%s" must implement the interface %s. '
                         . 'Service %s does not fulfill this requirement';
                $message = sprintf(
                    $message,
                    'erfurt.container.setup',
                    'Erfurt_Store_Adapter_Container_SetupInterface',
                    $id
                );
                throw new RuntimeException($message);
            }
            if (!$setup->isInstalled()) {
                $setup->install();
            }
        }
    }

}
