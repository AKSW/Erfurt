<?php
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Tests the Setup compiler pass.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 24.02.14
 */
class Erfurt_Store_Adapter_Container_SetupCompilerPassTest extends \PHPUnit_Framework_TestCase
{

    /**
     * System under test.
     *
     * @var \Erfurt_Store_Adapter_Container_SetupCompilerPass
     */
    protected $compilerPass = null;

    /**
     * The container that is used for testing.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected $container = null;

    /**
     * A mocked setup instance.
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $setup = null;

    /**
     * Identity helper method that is used to simulate a factory
     * in the container.
     *
     * @param mixed $input
     * @return mixed
     */
    public static function identity($input)
    {
        return $input;
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::setUp()} for details.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->setup        = $this->getMock('\Erfurt_Store_Adapter_Container_SetupInterface');
        $this->container    = $this->createContainer($this->setup);
        $this->compilerPass = new Erfurt_Store_Adapter_Container_SetupCompilerPass();
    }

    /**
     * See {@link PHPUnit_Framework_TestCase::tearDown()} for details.
     */
    protected function tearDown()
    {
        $this->compilerPass = null;
        $this->container    = null;
        $this->setup        = null;
        parent::tearDown();
    }

    /**
     * Checks if the compiler pass implements the required interface.
     */
    public function testImplementsInterface()
    {
        $expectedType = '\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface';
        $this->assertInstanceOf($expectedType, $this->compilerPass);
    }

    /**
     * Ensures that the setup instances are not called if the "erfurt.container.auto_setup"
     * parameter is false.
     */
    public function testSetupsAreNotCalledIfAutoSetupIsFalse()
    {
        $this->setup->expects($this->never())
                    ->method('isInstalled');
        $this->setup->expects($this->never())
                    ->method('install');

        $this->container->setParameter('erfurt.container.auto_setup', false);
        $this->compilerPass->process($this->container);
    }

    /**
     * Ensures that the setup instances are not called if the "erfurt.container.auto_setup"
     * parameter is not available.
     */
    public function testSetupsAreNotCalledIfAutoSetupParameterIsNotAvailable()
    {
        $this->setup->expects($this->never())
                    ->method('isInstalled');
        $this->setup->expects($this->never())
                    ->method('install');

        $this->compilerPass->process($this->container);
    }

    /**
     * Ensures that the setups are called if the "erfurt.container.auto_setup" evaluates
     * to true.
     */
    public function testPassCallsSetupsIfAutoSetupIsTrue()
    {
        $this->setup->expects($this->once())
                    ->method('isInstalled')
                    ->will($this->returnValue(true));
        $this->setup->expects($this->once())
                    ->method('install');

        $this->container->setParameter('erfurt.container.auto_setup', true);
        $this->compilerPass->process($this->container);
    }

    /**
     * Ensures that features that are already installed won't be installed again.
     */
    public function testPassDoesNotReInstallFeatures()
    {
        $this->setup->expects($this->once())
                    ->method('isInstalled')
                    ->will($this->returnValue(false));
        $this->setup->expects($this->never())
                    ->method('install');

        $this->container->setParameter('erfurt.container.auto_setup', true);
        $this->compilerPass->process($this->container);
    }

    /**
     * Creates a container that contains the provided Setup instance.
     *
     * @param Erfurt_Store_Adapter_Container_SetupInterface $setup
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected function createContainer(Erfurt_Store_Adapter_Container_SetupInterface $setup)
    {
        $container = new ContainerBuilder();
        $container->set('setup.instance', $setup);
        $referenceDefinition = new Definition();
        $referenceDefinition->addTag('erfurt.container.setup');
        $referenceDefinition->setFactoryClass(__CLASS__);
        $referenceDefinition->setFactoryMethod('identity');
        $referenceDefinition->addArgument(new Reference('setup.instance'));
        $container->setDefinition('setup.reference', $referenceDefinition);
        return $container;
    }

}
