<?php

/**
 * Tests the Oracle adapter factory.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 12.12.13
 */
class Erfurt_Store_Adapter_OracleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Ensures that the factory implements the mandatory factory interface.
     */
    public function testImplementsFactoryInterface()
    {
        $info = new ReflectionClass('Erfurt_Store_Adapter_Oracle');
        $this->assertTrue($info->implementsInterface('Erfurt_Store_Adapter_FactoryInterface'));
    }

    /**
     * Ensures that createFromOptions() throws an exception if no connection options
     * are passed.
     */
    public function testCreateFromOptionsThrowsExceptionIfConnectionOptionsAreOmitted()
    {
        $options = array();

        $this->setExpectedException('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        Erfurt_Store_Adapter_Oracle::createFromOptions($options);
    }

    /**
     * Ensures that createFromOptions() throws an exception if invalid connection options
     * are passed.
     */
    public function testCreateFromOptionsThrowsExceptionIfInvalidConnectionOptionsArePassed()
    {
        $options = array(
            'connection' => array()
        );

        $this->setExpectedException('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException');
        Erfurt_Store_Adapter_Oracle::createFromOptions($options);
    }

    /**
     * Checks if createFromOptions() returns an adapter instance if all options are valid.
     */
    public function testCreateFromOptionsReturnsAdapterInstanceIfOptionsAreValid()
    {
        $options = array(
            'connection'   => array(
                'dbname'   => 'orcl',
                'user'     => 'unknown',
                'password' => 'secret',
                'host'     => 'not-important-in-this-test.local',
                'port'     => 1521
            )
        );
        $adapter = Erfurt_Store_Adapter_Oracle::createFromOptions($options);

        $this->assertInstanceOf('Erfurt_Store_Adapter_Oracle_OracleAdapter', $adapter);
    }

}
